<?php

namespace App\Service;

use Carbon\Carbon;
use App\Models\ErpLog;
use App\Models\Product;
use App\Models\District;
use App\Models\ShowRoom;
use App\Models\PaymentErpHistory;
use App\Models\CustomerProfession;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class ApiService
{
    public function OrderCreate($data, $showroom, $invoice_number, $orderid, $delivery_showroom)
    {
        $district = District::where('id', $data['pr_district_id'])->first()->en_name;
        $customerProfession = CustomerProfession::where('id', $data['profession_id'])->first()->name;
        // $product_model = Product::where('id', $data['product_model_id'])->first()->product_model;
        $ctp = $showroom = ShowRoom::findOrFail(auth()->user()->showroom_id);
        $age = $data['age'];

        if (!is_numeric($age) || $age <= 0) {
            $age = '';
        } else {
            $dob = Carbon::now()->subYears($age)->startOfYear();
            $age = $dob->toDateString();
        }

        $customerInfo = array_filter([
            "name" => $data['name'],
            "mobile" => $data['pr_phone'],
            "email" => $data['email'],
            "address" => $data['shipping_address'],
            "city" => $district,
            "date_of_birth" => $age,
            "designation" => $data['designation'],
            "profession" => $customerProfession,
            "org" => $data['organization_name'],
        ]);

        // Prepare order info
        $orderInfo = array_filter([
            "eorder_no" => $invoice_number,
            "entry_date" => now()->toDateTimeString(),
            "down_payment" => $data['down_payment'],
            'instalments_rate' => $data['monthly_installment'],
            "no_instalments" => (int)$data['installment_month'] - 1,
            "sales_from" => $ctp->ctp_name ? $ctp->ctp_name : $ctp->name,
            "delivery_from" => $delivery_showroom->ctp_name ? $delivery_showroom->ctp_name : $delivery_showroom->name,
            "delivery_fee" => 0,
            "note" => $data['organization_short_desc'],
            'payment_ref' => "Cash"
        ]);

        // Prepare order details array
        // $orderDetails = [
        //     [
        //         "item_model"     => "$product_model",
        //         "item_qty"       => 1,
        //         "unit_rate"      => $data['hire_price'],
        //         "unit_wise_disc" => 0
        //     ]
        // ];

        $orderDetails = [];

        if ($data['sale_type'] === 'package') {
            // foreach ($data['package_products'] ?? [] as $item) {
            //     $product = Product::find($item['product_id']);
            //     if ($product) {
            //         $orderDetails[] = [
            //             "item_model" => $product->product_model,
            //             "item_qty" => 1,
            //             "unit_rate" => $product->hire_price, // base price per item
            //             "unit_wise_disc" => 0
            //         ];
            //     }
            // }

            $packageProducts = $data['package_products'] ?? [];
            $totalItemsInPackage = count($packageProducts);

            if ($totalItemsInPackage > 0) {
                $totalPackagePrice = $data['hire_price'];

                $perItemPrice = $totalPackagePrice / $totalItemsInPackage;

                foreach ($packageProducts as $item) {
                    $product = Product::find($item['product_id']);
                    if ($product) {
                        $orderDetails[] = [
                            "item_model"     => $product->product_model,
                            "item_qty"       => 1,
                            "unit_rate"      => $perItemPrice,
                            "unit_wise_disc" => 0
                        ];
                    }
                }
            }

        } else {
            // Single product
            $product = Product::find($data['product_model_id']);
            if ($product) {
                $orderDetails[] = [
                    "item_model" => $product->product_model,
                    "item_qty" => 1,
                    "unit_rate" => $data['hire_price'],
                    "unit_wise_disc" => 0
                ];
            }
        }

        // Full data for the API request
        $requestData = [
            "update_flag" => 0,
            "cancel_flag" => 0,
            "cus_info" => $customerInfo,
            "order_info" => $orderInfo,
            "order_details" => $orderDetails
        ];

        $customerJsonInfo = json_encode($customerInfo);
        $orderJsonDetails = json_encode($orderDetails);
        $orderJsonInfo = json_encode($orderInfo);
        $erpLogData = [
            'cus_info'      => $customerJsonInfo,
            'order_details' => $orderJsonDetails,
            'order_info'    => $orderJsonInfo,
            'tracking_number' => $orderid,
            'sent'           => 0,
            // 'response'      => $response
        ];

        // if($decodedResponse['error'] == 1){
        //     $erpLogData['sent'] = 0;
        // }else{
        //     $erpLogData['sent'] = 1;
        // }

        $ErpLog = new ErpLog;
        $ErpLog->fill($erpLogData)->save();

        return 1;
    }

    public function SendToErp($receiveData)
    {
        $url = 'http://202.84.32.120:8527/da/ws';
        $apiKey = '746105e82fb9931c31d73a24904aa102b21b4e4a';

        // Convert the data array to JSON
        $jsonData = json_encode($receiveData, true);

        // Set up cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);

        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json",
            "Accept: */*",
            "Accept-Encoding: gzip, deflate, br",
            "Connection: keep-alive",
            "User-Agent: PostmanRuntime/7.45.0",
            "api_key: $apiKey"
        ]);

        // Set timeout (in seconds)
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);

        // Execute the cURL request
        $response = curl_exec($ch);

        // Check if there was an error
        if (curl_errno($ch)) {
            $errorMessage = curl_error($ch);
            curl_close($ch);
            return [
                'success' => false,
                'message' => "Request failed: $errorMessage"
            ];
        }

        // Close cURL and return successful response
        curl_close($ch);

        // Decode the JSON response if needed
        $decodedResponse = json_decode($response, true);

        return $decodedResponse;
    }


    public function CollectionApi($orderNo, $installement, $paymentRef = "Cash")
    {
        // Define the ERP API endpoint
        $url = 'http://202.84.32.120:8527/da/ws';

        // Set the headers
        $headers = [
            'api_key' => '88075da6b52a2e8beece2fad86d58f9e7f6a39a1',
            'Content-Type' => 'application/json'
        ];
        //'payment_ref'=>"Cash"
        // 'payment_ref'=>"Bkash-CUO0TSRL"
        // 'payment_ref'=>"Nagad-NUG0TSRL"
        // Prepare the data for the request
        $data = [
            'eorder_no' => $orderNo,
            'ins_no' => $installement,
            'payment_ref' => "Cash"
        ];
        // Send the POST request to the ERP API
        $response = Http::withHeaders($headers)->post($url, $data);
        return json_decode($response, true);
    }

    public function FineApi($orderNo, $panalty_amt, $installment_no, $paymentRef = "Cash")
    {
        // API Endpoint
        $url = 'http://202.84.32.120:8527/da/ws';
        // Set the headers
        $headers = [
            'api_key' => '64e7c561c9b4bb5d0801cc57b0a6c6f6568a0015',
            'Content-Type' => 'application/json'
        ];

        // Request Body
        $payload = [
            'eorder_no'   => $orderNo,
            'penalty_amt' => $panalty_amt,
            'payment_ref' => "Cash", // Default empty if not provided
            'ins_no'      => $installment_no
        ];
        try {
            // Send POST request using Laravel HTTP Client
            $response = Http::withHeaders($headers)->post($url, $payload);
            return $response->json();

            if ($response->successful()) {
                return response()->json([
                    'status'  => 'success',
                    'message' => 'Hire Purchase Collection submitted successfully.',
                    'data'    => $response->json(),
                ]);
            } else {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Failed to submit Hire Purchase Collection.',
                    'error'   => $response->json(),
                ], $response->status());
            }
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'API request failed.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }
}
