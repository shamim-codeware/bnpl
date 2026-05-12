<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Package;
use App\Models\Product;
use App\Models\DownPaymentSetting;
use App\Models\InterestRate;


class EmiController extends Controller
{
    public function index(){
        $title = "Emi Calculator ";
        $description = "Some description for the page";
        $products = Product::latest()->get();
        $packages = Package::latest()->get();

        $down_payment_percentage = DownPaymentSetting::latest()->get();
        return view('installment.hire_purchase.emi-calculator', compact('title', 'description', 'products', 'packages','down_payment_percentage'));
    }

    public function Calculation(Request $request, $id){
        $interestRate = InterestRate::orderBy('id','ASC')->get();
        $type = $request->get('type', 'product');
        $package = null;

        if ($type === 'package') {
            $package = Package::with(['items.product'])->findOrFail($id);
            $packagePrice = $package->items->reduce(function ($carry, $item) {
                return $carry + ($item->product->hire_price ?? 0);
            }, 0);
            $product = (object) [
                'product_model' => $package->name,
                'hire_price' => $packagePrice,
            ];
        } else {
            $product = Product::findOrFail($id);
        }

        // Get down payment from request or use default
        $down_payment = $request->has('down_payment')
            ? $request->down_payment
            : @DownPaymentSetting::orderby('id','ASC')->first()->payment_percentage??0;

        $down_payment_percentages = DownPaymentSetting::orderby('payment_percentage','ASC')->get();

        return view('installment.hire_purchase.calculate-ajax-data', compact('interestRate','down_payment','product', 'down_payment_percentages','type','package'));
    }
}
