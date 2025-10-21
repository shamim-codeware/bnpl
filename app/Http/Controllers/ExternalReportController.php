<?php

namespace App\Http\Controllers;

use App\Models\Zone;
use App\Models\Brand;
use App\Helpers\Helper;
use App\Models\Product;
use App\Models\ShowRoom;
use App\Models\Installment;
use App\Models\ProductType;
use App\Models\HirePurchase;
use Illuminate\Http\Request;
use App\Models\ZonePermission;
use App\Models\ProductCategory;
use App\Exports\BnplOrdersExport;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Traits\LateFeeCalculationTrait;
use App\Exports\DefaulterCustomersExport;

class ExternalReportController extends Controller
{
    use LateFeeCalculationTrait;

    public function AllBnplSale()
    {
        $title = "All BNPL Orders";
        $description = "List of all Buy Now Pay Later (BNPL) orders";
        $data = $this->prepareDataForBnplReport();
        return view('report.all_bnpl_sales', compact('title', 'description', 'data'));
    }

    public function AllBnplSaleAction(Request $request)
    {
        $hirepurchase = $this->filterBnplOrders($request, true); // true means use pagination
        $from_date = $request->from_date ? date('Y-m-d 00:00:00', strtotime($request->from_date)) : null;
        $to_date = $request->to_date ? date('Y-m-d 23:59:59', strtotime($request->to_date)) : null;

        // Calculate late fees for each hire purchase
        foreach ($hirepurchase as $hire) {
            $hire->late_fee = $this->calculateLateFine($hire->id);
        }

        return view('report.all_bnpl_sales_ajax', compact("hirepurchase", "from_date", 'to_date'));
    }

    public function AllBnplSaleExport(Request $request)
    {
        $hirepurchase = $this->filterBnplOrders($request, false); // false means no pagination

            // Calculate late fees for each hire purchase
            foreach ($hirepurchase as $hire) {
                $hire->late_fee = $this->calculateLateFine($hire->id);
            }

        return Excel::download(new BnplOrdersExport($hirepurchase), 'All_BNPL_Orders_' . Helper::formatDateTimeFilename() . '.xlsx');
    }

    public function CancelBnplSale()
    {
        $title = "Cancelled BNPL Orders";
        $description = "List of all cancelled Buy Now Pay Later (BNPL) orders";
        $data = $this->prepareDataForBnplReport();
        return view('report.cancelled_bnpl_sales', compact('title', 'description', 'data'));
    }

    public function CancelBnplSaleAction(Request $request)
    {
        $hirepurchase = $this->filterCancelledBnplOrders($request, true);
        $from_date = $request->from_date ? date('Y-m-d 00:00:00', strtotime($request->from_date)) : null;
        $to_date = $request->to_date ? date('Y-m-d 23:59:59', strtotime($request->to_date)) : null;
        return view('report.cancelled_bnpl_sales_ajax', compact("hirepurchase", "from_date", 'to_date'));
    }

    public function CancelBnplSaleExport(Request $request)
    {
        $hirepurchase = $this->filterCancelledBnplOrders($request, false);
        return Excel::download(new BnplOrdersExport($hirepurchase), 'Cancelled_BNPL_Orders_' . Helper::formatDateTimeFilename() . '.xlsx');
    }

    public function DefaulterReport()
    {
        $title = "Defaulter Customers Report";
        $description = "List of all defaulter customers for BNPL orders";
        $data = $this->prepareDataForBnplReport();
        return view('report.defaulter_customers', compact('title', 'description', 'data'));
    }

    public function DefaulterReportAction(Request $request)
    {
        $customers = $this->filterDefaulterCustomers($request, true);

        $from_date = date('Y-m-d 00:00:00', strtotime($request->from_date));
        $to_date = date('Y-m-d 23:59:59', strtotime($request->to_date));

        // Calculate late fees for each hire purchase
        foreach ($customers as $customer) {
            $customer->late_fee = $this->calculateLateFine($customer->id);
        }

        return view('report.defaulter_customers_ajax', compact("customers", "from_date", 'to_date'));
    }

    public function DefaulterReportExport(Request $request)
    {
        $customers = $this->filterDefaulterCustomers($request, false);

        // Calculate late fees for each hire purchase
        foreach ($customers as $customer) {
            $customer->late_fee = $this->calculateLateFine($customer->id);
        }

        return Excel::download(new DefaulterCustomersExport($customers), 'Defaulter_Customers_Report_' . Helper::formatDateTimeFilename() . '.xlsx');
    }

    private function prepareDataForBnplReport()
    {
        if (Auth::user()->role_id == 6) {
            $permission = ZonePermission::where('user_id', Auth::user()->id)->pluck('zone_id')->toArray();
            $zones = Zone::selectRaw('id, name')->whereIn('id', $permission)->orderBy('id', 'ASC')->where('status', 1)->get();
            $showrooms = ShowRoom::selectRaw('id, name')->whereIn('zone_id', $permission)->where('status', 1)->orderby('name', 'ASC')->get();
        } elseif (Auth::user()->role_id == 2) {
            $showrooms = ShowRoom::selectRaw('id, name')->where('zone_id', Auth::user()->zone_id)->where('status', 1)->orderby('name', 'ASC')->get();
            $zones = Zone::selectRaw('id, name')->orderBy('id', 'ASC')->where('status', 1)->get();
        } else {
            $zones = Zone::selectRaw('id, name')->orderBy('id', 'ASC')->where('status', 1)->get();
            $showrooms = ShowRoom::selectRaw('id, name')->where('status', 1)->orderby('name', 'ASC')->get();
        }
        $product_category = ProductCategory::get();
        $brands = Brand::get();
        $product_type = ProductType::get();
        $products = Product::selectRaw('id,product_model')->get();
        return compact('zones', 'showrooms', 'product_category', 'brands', 'product_type', 'products');
    }

    private function filterBnplOrders($request, $paginate = true)
    {
        $from_date = $request->from_date ? date('Y-m-d 00:00:00', strtotime($request->from_date)) : null;
        $to_date = $request->to_date ? date('Y-m-d 23:59:59', strtotime($request->to_date)) : null;

        $query = HirePurchase::selectEntities();

        $product_group_ids = explode(',', $request->product_group);
        $showrooms = explode(',', $request->showroom_ctp);
        $product_model = explode(',', $request->product_model);
        $product_category = explode(',', $request->product_category);
        $brand = explode(',', $request->brand_id);


        if ($request->order_no) {
            $query->where('order_no', $request->order_no);
        } else {
            if ($from_date && $to_date) {
                $query->whereBetween('approval_date', [$from_date, $to_date]);
            }
            if ($request->product_model) {
                $query->whereHas('purchase_product', function ($q) use ($product_model) {
                    $q->whereIn('product_id', $product_model);
                });
            }
            if ($request->store_type !== null && $request->store_type !== '') {
                $query->where('store_type', $request->store_type);
            }
            if ($request->zone_id) {
                $query->whereHas('show_room', function ($q) use ($request) {
                    $q->where('zone_id', $request->zone_id);
                });
            }
            if ($request->showroom_ctp) {
                $query->whereIn('showroom_id', $showrooms);
            }
            if ($request->product_category) {
                $query->whereHas('purchase_product.product', function ($q) use ($product_category) {
                    $q->whereIn('category_id', $product_category);
                });
            }
            if ($request->product_group) {
                $query->whereHas('purchase_product', function ($q) use ($product_group_ids) {
                    $q->whereIn('product_group_id', $product_group_ids);
                });
            }
            if ($request->brand_id) {
                $query->whereHas('purchase_product.product', function ($q) use ($brand) {
                    $q->whereIn('brand_id', $brand);
                });
            }
        }

        if (Auth::user()->role_id == 2) {
            $zone_id = Auth::user()->zone_id;
            $query->whereHas('show_room', function ($q) use ($zone_id) {
                $q->where('zone_id', $zone_id);
            });
        } elseif (Auth::user()->role_id == 3) {
            $query->where('showroom_id', Auth::user()->showroom_id);
        } elseif (Auth::user()->role_id == 6) {
            $permission = ZonePermission::where('user_id', Auth::user()->id)->pluck('zone_id')->toArray();
            $query->whereHas('show_room', function ($q) use ($permission) {
                $q->whereIn('zone_id', $permission);
            });
        }

        $query = $query->latest();

        $per_page = $request->per_page ?? 30;
        return $paginate ? $query->paginate($per_page) : $query->get();
    }

    private function filterCancelledBnplOrders($request, $paginate = true)
    {
        $from_date = $request->from_date ? date('Y-m-d 00:00:00', strtotime($request->from_date)) : null;
        $to_date = $request->to_date ? date('Y-m-d 23:59:59', strtotime($request->to_date)) : null;

        $query = HirePurchase::selectEntities()
            ->whereIn('status', [2, 4]); // 2 means Rejected, 4 means Sale Cancel

        $product_group_ids = explode(',', $request->product_group);
        $showrooms = explode(',', $request->showroom_ctp);
        $product_model = explode(',', $request->product_model);
        $product_category = explode(',', $request->product_category);
        $brand = explode(',', $request->brand_id);

        if ($request->order_no) {
            $query->where('order_no', $request->order_no);
        } else {
            if ($from_date && $to_date) {
                $query->whereBetween('approval_date', [$from_date, $to_date]);
            }
            if ($request->product_model) {
                $query->whereHas('purchase_product', function ($q) use ($product_model) {
                    $q->whereIn('product_id', $product_model);
                });
            }
            if ($request->store_type !== null && $request->store_type !== '') {
                $query->where('store_type', $request->store_type);
            }
            if ($request->zone_id) {
                $query->whereHas('show_room', function ($q) use ($request) {
                    $q->where('zone_id', $request->zone_id);
                });
            }
            if ($request->showroom_ctp) {
                $query->whereIn('showroom_id', $showrooms);
            }
            if ($request->product_category) {
                $query->whereHas('purchase_product.product', function ($q) use ($product_category) {
                    $q->whereIn('category_id', $product_category);
                });
            }
            if ($request->product_group) {
                $query->whereHas('purchase_product', function ($q) use ($product_group_ids) {
                    $q->whereIn('product_group_id', $product_group_ids);
                });
            }
            if ($request->brand_id) {
                $query->whereHas('purchase_product.product', function ($q) use ($brand) {
                    $q->whereIn('brand_id', $brand);
                });
            }
        }

        if (Auth::user()->role_id == 2) {
            $zone_id = Auth::user()->zone_id;
            $query->whereHas('show_room', function ($q) use ($zone_id) {
                $q->where('zone_id', $zone_id);
            });
        } elseif (Auth::user()->role_id == 3) {
            $query->where('showroom_id', Auth::user()->showroom_id);
        } elseif (Auth::user()->role_id == 6) {
            $permission = ZonePermission::where('user_id', Auth::user()->id)->pluck('zone_id')->toArray();
            $query->whereHas('show_room', function ($q) use ($permission) {
                $q->whereIn('zone_id', $permission);
            });
        }

        $query = $query->latest();

        $per_page = $request->per_page ?? 30;
        return $paginate ? $query->paginate($per_page) : $query->get();
    }

    private function filterDefaulterCustomers($request, $paginate = true)
    {
        $from_date = date('Y-m-d 00:00:00', strtotime($request->from_date));
        $to_date = date('Y-m-d 23:59:59', strtotime($request->to_date));

        $query = HirePurchase::select('hire_purchases.*')
            ->with([
                'purchase_product',
                'show_room.zone',
                'transaction',
                'purchase_product.brand',
                'purchase_product.product',
                'installment',
                'purchase_product.product_category',
                'purchase_product.product_group'
            ])
            ->where('is_paid', 0) // Not fully paid
            ->where('status', 3)  // Confirmed sale
            ->whereHas('installment', function($q) {
                $q->where('status', 0) // Unpaid installment
                  ->whereDate('loan_start_date', '<', now()); // Overdue (loan_start_date is past current date)
            });

        $product_group_ids = explode(',', $request->product_group);
        $showrooms = explode(',', $request->showroom_ctp);
        $product_model = explode(',', $request->product_model);
        $product_category = explode(',', $request->product_category);
        $brand = explode(',', $request->brand_id);

        if ($request->order_no) {
            $query->where('order_no', $request->order_no);
        } else {
            if ($request->from_date && $request->to_date) {
                $query->whereBetween('approval_date', [$from_date, $to_date]);
            }
            if ($request->product_model) {
                $query->whereHas('purchase_product', function ($q) use ($product_model) {
                    $q->whereIn('product_id', $product_model);
                });
            }
            if ($request->store_type !== null && $request->store_type !== '') {
                $query->where('store_type', $request->store_type);
            }
            if ($request->zone_id) {
                $query->whereHas('show_room', function ($q) use ($request) {
                    $q->where('zone_id', $request->zone_id);
                });
            }
            if ($request->showroom_ctp) {
                $query->whereIn('showroom_id', $showrooms);
            }
            if ($request->product_category) {
                $query->whereHas('purchase_product.product', function ($q) use ($product_category) {
                    $q->whereIn('category_id', $product_category);
                });
            }
            if ($request->product_group) {
                $query->whereHas('purchase_product', function ($q) use ($product_group_ids) {
                    $q->whereIn('product_group_id', $product_group_ids);
                });
            }
            if ($request->brand_id) {
                $query->whereHas('purchase_product.product', function ($q) use ($brand) {
                    $q->whereIn('brand_id', $brand);
                });
            }
        }

        if (Auth::user()->role_id == 2) {
            $zone_id = Auth::user()->zone_id;
            $query->whereHas('show_room', function ($q) use ($zone_id) {
                $q->where('zone_id', $zone_id);
            });
        } elseif (Auth::user()->role_id == 3) {
            $query->where('showroom_id', Auth::user()->showroom_id);
        } elseif (Auth::user()->role_id == 6) {
            $permission = ZonePermission::where('user_id', Auth::user()->id)->pluck('zone_id')->toArray();
            $query->whereHas('show_room', function ($q) use ($permission) {
                $q->whereIn('zone_id', $permission);
            });
        }

        // Add the days_overdue and last_payment_date as additional selected fields
        $query->addSelect([
            \DB::raw('COALESCE(DATEDIFF(NOW(), (SELECT MIN(loan_start_date) FROM installments WHERE hire_purchase_id = hire_purchases.id AND status = 0 AND loan_start_date < NOW())), 0) as days_overdue'),
            \DB::raw('(SELECT MAX(updated_at) FROM installments WHERE hire_purchase_id = hire_purchases.id AND status = 1) as last_payment_date')
        ]);

        $query = $query->latest();
        $per_page = $request->per_page ?? 30;
        return $paginate ? $query->paginate($per_page) : $query->get();
    }
}
