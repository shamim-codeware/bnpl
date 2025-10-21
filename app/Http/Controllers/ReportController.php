<?php

namespace App\Http\Controllers;

use App\Models\User;
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
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DueOnNextMonthExport;

use App\Traits\LateFeeCalculationTrait;

class ReportController extends Controller
{
    use LateFeeCalculationTrait;


    public function DueOnNextmonth()
    {
        $title = "Product Details";
        $description = "Some description for the page";
        $product_type = ProductType::latest()->get();
        return view('report.due_on_next_month', compact("title", "description", "product_type"));
    }


    // public function DueOnNextmonthGetData(Request $request)
    // {
    //     $query = HirePurchase::dueOnNextMonthGetData($request);

    //     // Handle role-based filtering
    //     if (Auth::user()->role_id == 2) {
    //         $zone_id = Auth::user()->zone_id;
    //         $query->whereHas('show_room', function ($q) use ($zone_id) {
    //             $q->where('zone_id', $zone_id);
    //         });
    //     } elseif (Auth::user()->role_id == 3) {
    //         $query->where('showroom_id', Auth::user()->showroom_id);
    //     } elseif (Auth::user()->role_id == 6) {
    //         $permission = ZonePermission::where('user_id', Auth::user()->id)->pluck('zone_id')->toArray();
    //         $query->whereHas('show_room', function ($q) use ($permission) {
    //             $q->whereIn('zone_id', $permission);
    //         });
    //     }

    //     $hirepurchase = $query->latest()->get();

    //     $from_date = date('Y-m-d 00:00:00', strtotime($request->from_date));
    //     $to_date = date('Y-m-d 23:59:59', strtotime($request->to_date));

    //     return view('report.due_on_next_ajax_view', compact("hirepurchase", "from_date", "to_date"));
    // }





    public function DueOnNextmonthGetData(Request $request)
    {
        // Calculate next month date range
        $nextMonthStart = date('Y-m-01', strtotime('first day of next month'));
        $nextMonthEnd = date('Y-m-t', strtotime('last day of next month'));

        // If specific dates are provided in request, use them instead
        $from_date = $request->from_date ? date('Y-m-d 00:00:00', strtotime($request->from_date)) : $nextMonthStart . ' 00:00:00';
        $to_date = $request->to_date ? date('Y-m-d 23:59:59', strtotime($request->to_date)) : $nextMonthEnd . ' 23:59:59';

        $query = HirePurchase::with([
            'installment' => function ($q) use ($from_date, $to_date) {
                $q->whereBetween('loan_start_date', [$from_date, $to_date])
                    ->where('status', 0) // Only unpaid installments
                    ->orderBy('loan_start_date', 'asc');
            },
            'transaction' => function ($q) {
                $q->where('status', 1)->orderBy('updated_at', 'desc');
            },
            'purchase_product.product_group',
            'purchase_product.product',
            'show_room.zone'
        ])
            ->where('status', 3) // Only confirmed sales
            ->whereHas('installment', function ($q) use ($from_date, $to_date) {
                $q->whereBetween('loan_start_date', [$from_date, $to_date])
                    ->where('status', 0); // Only records with unpaid installments in the date range
            });

        $product_group_ids = explode(',', $request->product_group);

        if ($request->order_no) {
            $query->where('order_no', $request->order_no);
        } else {
            if ($request->product_group) {
                $query->whereHas('purchase_product', function ($q) use ($product_group_ids) {
                    $q->whereIn('product_group_id', $product_group_ids);
                });
            }
        }

        // Role-based filtering
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

        $hirepurchase = $query->latest()->paginate();

        // Calculate late fees for each hire purchase
        foreach ($hirepurchase as $hire) {
            $hire->late_fee = $this->calculateLateFine($hire->id);
        }

        return view('report.due_on_next_ajax_view', compact("hirepurchase", "from_date", 'to_date'));
    }

    public function DueOnNextmonthExport(Request $request)
    {
        // Calculate next month date range
        $nextMonthStart = date('Y-m-01', strtotime('first day of next month'));
        $nextMonthEnd = date('Y-m-t', strtotime('last day of next month'));

        // If specific dates are provided in request, use them instead
        $from_date = $request->from_date ? date('Y-m-d 00:00:00', strtotime($request->from_date)) : $nextMonthStart . ' 00:00:00';
        $to_date = $request->to_date ? date('Y-m-d 23:59:59', strtotime($request->to_date)) : $nextMonthEnd . ' 23:59:59';

        $query = HirePurchase::with([
            'installment' => function ($q) use ($from_date, $to_date) {
                $q->whereBetween('loan_start_date', [$from_date, $to_date])
                    ->where('status', 0) // Only unpaid installments
                    ->orderBy('loan_start_date', 'asc');
            },
            'transaction' => function ($q) {
                $q->where('status', 1)->orderBy('updated_at', 'desc');
            },
            'purchase_product.product_group',
            'purchase_product.product',
            'show_room.zone'
        ])
            ->where('status', 3) // Only confirmed sales
            ->whereHas('installment', function ($q) use ($from_date, $to_date) {
                $q->whereBetween('loan_start_date', [$from_date, $to_date])
                    ->where('status', 0); // Only records with unpaid installments in the date range
            });

        $product_group_ids = explode(',', $request->product_group);

        if ($request->order_no) {
            $query->where('order_no', $request->order_no);
        } else {
            if ($request->product_group) {
                $query->whereHas('purchase_product', function ($q) use ($product_group_ids) {
                    $q->whereIn('product_group_id', $product_group_ids);
                });
            }
        }

        // Role-based filtering
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

        $hirepurchase = $query->latest()->get();

        return Excel::download(new DueOnNextMonthExport($hirepurchase), 'Due_On_Next_Month_Report_' . Helper::formatDateTimeFilename() . '.xlsx');
    }

    public function fullPaidCustomer()
    {
        $data = $this->prepareDataForReport();
        return view('report.full_paid_customer', $data);
    }

    public function getFullPaidCustomer(Request $request)
    {
        $hirepurchase = $this->filterHirePurchase($request, 1); // 1 means paid
        $from_date = date('Y-m-d 00:00:00', strtotime($request->from_date));
        $to_date = date('Y-m-d 23:59:59', strtotime($request->to_date));
        return view('report.full_paid_customer_ajax', compact("hirepurchase", "from_date", 'to_date'));
    }



    public function currentOutstanding()
    {
        $data = $this->prepareDataForReport();
        return view('report.current_outstanding', $data);
    }

    public function getCurrentOutstanding(Request $request)
    {
        $sale_status = 3;
        $hirepurchase = $this->filterHirePurchase($request, 0, $sale_status); // 0 means unpaid
        $from_date = date('Y-m-d 00:00:00', strtotime($request->from_date));
        $to_date = date('Y-m-d 23:59:59', strtotime($request->to_date));

        // Calculate late fees for each hire purchase
        foreach ($hirepurchase as $hire) {
            $hire->late_fee = $this->calculateLateFine($hire->id);
        }

        // return $hirepurchase;
        return view('report.current_outstanding_ajax', compact("hirepurchase", "from_date", 'to_date'));
    }


    public function zoneOverview()
    {
        $title = "Full Paid Customer Details";
        $description = "Some Description for the page";
        $data = $this->prepareDataForReport();
        return view('report.zone_overview', $data);
    }

    // public function zoneOverviewGetData(Request $request)
    // {
    //     $from_date = date('Y-m-d 00:00:00', strtotime($request->from_date));
    //     $to_date = date('Y-m-d 23:59:59', strtotime($request->to_date));

    //     $query = HirePurchase::selectEntities(null, 3); // 3 means status sale confirm

    //     $product_group_ids = explode(',', $request->product_group);
    //     $zone_id = explode(',', $request->zone_id);

    //     if ($request->from_date && $request->to_date) {
    //         $query->whereBetween('approval_date', [$from_date, $to_date]);
    //     }
    //     if ($request->zone_id) {
    //         $zone_id = $request->zone_id;
    //         $query->whereHas('show_room', function ($q) use ($zone_id) {
    //             $q->where('zone_id', $zone_id);
    //         });
    //     }
    //     if ($request->product_group) {
    //         $query->whereHas('purchase_product', function ($q) use ($product_group_ids) {
    //             $q->whereIn('product_group_id', $product_group_ids);
    //         });
    //     }


    //     $hirePurchases = $query->get();
    //     $total_hirepurchase = $hirePurchases->sum(function ($data) {
    //         return $data->purchase_product ? $data->purchase_product->hire_price : 0;
    //     });
    //     $total_paid = $hirePurchases->sum(function ($data) {
    //         return $data->purchase_product ? $data->purchase_product->total_paid : 0;
    //     });
    //     $total_remaining = $total_hirepurchase - $total_paid;
    //     return view('report.zone-overview-ajax', compact("total_hirepurchase", "total_paid", "total_remaining"));
    // }

    public function zoneOverviewGetData(Request $request)
    {
        $from_date = $request->from_date ? date('Y-m-d 00:00:00', strtotime($request->from_date)) : null;
        $to_date = $request->to_date ? date('Y-m-d 23:59:59', strtotime($request->to_date)) : null;

        $query = HirePurchase::selectEntities(null, 3); // 3 = status sale confirm

        $product_group_ids = $request->product_group ? explode(',', $request->product_group) : [];
        $zone_id = $request->zone_id ? explode(',', $request->zone_id) : [];

        // Filter by date
        if ($from_date && $to_date) {
            $query->whereBetween('approval_date', [$from_date, $to_date]);
        }

        // Role-based filtering
        $user = auth()->user();
        if ($user->role_id == 2) {
            // Zone-level manager
          $query->where('showroom_id', $user->showroom_id);

        } elseif ($user->role_id == 3) {
            // Showroom-level manager
            $query->where('showroom_id', $user->showroom_id);
            //  $query->whereHas('show_room', function ($q) use ($user) {
            //     $q->where('zone_id', $user->zone_id);
            // });

        } elseif ($user->role_id == 6) {
            // Users with multiple zone permissions
            $permissions = ZonePermission::where('user_id', $user->id)->pluck('zone_id')->toArray();
            $query->whereHas('show_room', function ($q) use ($permissions) {
                $q->whereIn('zone_id', $permissions);
            });
        } elseif (!empty($zone_id)) {
            // Admin or other roles filter zones if provided
            $query->whereHas('show_room', function ($q) use ($zone_id) {
                $q->whereIn('zone_id', $zone_id);
            });
        }
        // If admin does not provide zone_id, all zones are included

        // Product group filtering
        if (!empty($product_group_ids)) {
            $query->whereHas('purchase_product', function ($q) use ($product_group_ids) {
                $q->whereIn('product_group_id', $product_group_ids);
            });
        }

        $hirePurchases = $query->get();

        $total_hirepurchase = $hirePurchases->sum(function ($data) {
            return $data->purchase_product ? $data->purchase_product->hire_price : 0;
        });

        $total_paid = $hirePurchases->sum(function ($data) {
            return $data->purchase_product ? $data->purchase_product->total_paid : 0;
        });

        $total_remaining = $total_hirepurchase - $total_paid;

        return view('report.zone-overview-ajax', compact(
            'total_hirepurchase',
            'total_paid',
            'total_remaining'
        ));
    }



    private function prepareDataForReport()
    {
        $title = "Full Paid Customer Details";
        $description = "Some Description for the page";
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
        return compact('title', 'description', 'zones', 'showrooms', 'product_category', 'brands', 'product_type', 'products');
    }

    public function filterHirePurchase($request, $status, $sale_status = null)
    {
        $from_date = date('Y-m-d 00:00:00', strtotime($request->from_date));
        $to_date = date('Y-m-d 23:59:59', strtotime($request->to_date));

        $query = HirePurchase::selectEntities($status, $sale_status);  // 0 means unpaid and 1 means paid

        $product_group_ids = explode(',', $request->product_group);
        $showrooms = explode(',', $request->showroom_ctp);
        $product_model = explode(',', $request->product_model);
        $product_category = explode(',', $request->product_category);
        $brand = explode(',', $request->brand_id);

        $user = Auth::user();
        if ($user->role_id == 3) {
            // Role 3 always sees only their own showroom
            $query->where('showroom_id', $user->showroom_id);
        } elseif ($request->showroom_ctp) {
            // Other roles (1, 2, 6...) can select showroom(s)
            $query->whereIn('showroom_id', $showrooms);
        }

        if ($request->order_no) {
            $query->where('order_no', $request->order_no);
        } else {
            if ($request->from_date && $request->to_date) {
                $query->whereBetween('approval_date', [$from_date, $to_date]);
            }
            if ($request->product_model) {
                $query->whereHas('purchase_product', function ($q) use ($product_model) {
                    $q->whereIn('product_model_id', $product_model);
                });
            }
            if ($request->product_category) {
                $query->whereHas('purchase_product', function ($q) use ($product_category) {
                    $q->whereIn('product_category_id', $product_category);
                });
            }
            if ($request->brand_id) {
                $query->whereHas('purchase_product', function ($q) use ($brand) {
                    $q->whereIn('product_brand_id', $brand);
                });
            }
            if ($request->zone_id) {
                $zone_id = $request->zone_id;
                $query->whereHas('show_room', function ($q) use ($zone_id) {
                    $q->where('zone_id', $zone_id);
                });
            }
            if ($request->store_type) {
                $query->where('showroom_id', $request->store_type);
            }
            if ($request->showroom_ctp) {
                $query->whereIn('showroom_id', $showrooms);
            }
            if ($request->product_group) {
                $query->whereHas('purchase_product', function ($q) use ($product_group_ids) {
                    $q->whereIn('product_group_id', $product_group_ids);
                });
            }
        }

        // Get per_page value from request, default to 20
        $perPage = $request->per_page ? (int) $request->per_page : 20;

        return $query->paginate($perPage);
    }

    public function MonthlyReportAction(Request $request)
    {
        $title = "Monthly Report";
        $description = "Monthly Report for BNPL orders";

        // Get the date range from the request or set default values
        $from_date = $request->from_date ? date('Y-m-d 00:00:00', strtotime($request->from_date)) : date('Y-m-01') . ' 00:00:00';
        $to_date = $request->to_date ? date('Y-m-d 23:59:59', strtotime($request->to_date)) : date('Y-m-t') . ' 23:59:59';

        return view('report.monthly_report', compact('title', 'description', 'from_date', 'to_date'));
    }
}
