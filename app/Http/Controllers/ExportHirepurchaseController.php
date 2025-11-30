<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\HirePurchase;
use Illuminate\Http\Request;
use App\Models\ZonePermission;
use App\Exports\ExportPurchase;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DueOnNextMonthExport;
use App\Traits\LateFeeCalculationTrait;

class ExportHirepurchaseController extends Controller
{
    use LateFeeCalculationTrait;
    public function export(Request $request)
    {

        $query = HirePurchase::with(['purchase_products', 'purchase_products.product_category', 'purchase_products.brand', 'purchase_products.product', 'show_room', 'show_room_user', 'users'])->where('status', 3)->where('is_paid', 1);
        if ($request->from_date && $request->to_date) {
            // Date query
            $from_date = date('Y-m-d 00:00:00', strtotime($request->from_date));
            $to_date    = date('Y-m-d 23:59:59', strtotime($request->to_date));
            // Date
            $query->whereBetween('created_at', [$from_date, $to_date]);
        }
        if ($request->zone_id) {
            $zone_id = $request->zone_id;
            // Zone
            $query->whereHas('show_room', function ($q) use ($zone_id) {
                $q->where('zone_id', $zone_id);
            });
        }
        if ($request->showroom_id) {
            $query->where('showroom_id', $request->showroom_id);
        }

        if ($request->store_type) {
            $stor_type = $request->store_type;
            $query->whereHas('show_room', function ($q) use ($stor_type) {
                $q->where('dealar',  $stor_type);
            });
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


        $hirepurchase = $query->latest()->get();
        $filename = 'full-paid-purchase-report-' . date('m-d-y-H-i-s') . '.xlsx';
        return Excel::download(new ExportPurchase($hirepurchase), $filename);
    }
    public function Allexport(Request $request)
    {

        $query = HirePurchase::with(['purchase_products', 'purchase_products.product_category', 'purchase_products.brand', 'purchase_products.product', 'show_room', 'show_room_user', 'users', 'installment'])->where('status', 3);
        // if ($request->from_date && $request->to_date) {
        //     // Date query
        //     $from_date = date('Y-m-d 00:00:00', strtotime($request->from_date));
        //     $to_date    = date('Y-m-d 23:59:59', strtotime($request->to_date));
        //     // Date
        //     $query->whereBetween('created_at', [$from_date, $to_date]);
        // }

        if ($request->over_dues) {
            $query->whereHas('installment', function ($q) {
                $q->where('loan_end_date', '<', now())
                    ->where('status', 0);
            });
        } elseif ($request->from_date && $request->to_date) {
            $from_date = date('Y-m-d 00:00:00', strtotime($request->from_date));
            $to_date   = date('Y-m-d 23:59:59', strtotime($request->to_date));
            $query->whereBetween('created_at', [$from_date, $to_date]);
        }

        if ($request->zone_id) {
            $zone_id = $request->zone_id;
            // Zone
            $query->whereHas('show_room', function ($q) use ($zone_id) {
                $q->where('zone_id', $zone_id);
            });
        }
        if ($request->showroom_id) {
            $query->where('showroom_id', $request->showroom_id);
        }

        if ($request->store_type) {
            $stor_type = $request->store_type;
            $query->whereHas('show_room', function ($q) use ($stor_type) {
                $q->where('dealar',  $stor_type);
            });
        }

        if ($request->over_dues) {
            $query->whereHas('installment', function ($q) {
                $q->where('loan_end_date', '<', now())->where('status', 0);
            });
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


        $hirepurchase = $query->latest()->get();

        $filename = 'All-bnpl-purchase-list-report-' . date('m-d-y-H-i-s') . '.xlsx';
        return Excel::download(new ExportPurchase($hirepurchase), $filename);
    }

    public function currentOutstandingExport(Request $request)
    {
        // Use the same query structure as the getCurrentOutstanding method
        $query = HirePurchase::selectEntities(0, 3); // 0 means unpaid (current outstanding), 3 means status sale confirm

        if ($request->from_date && $request->to_date) {
            // Date query
            $from_date = date('Y-m-d 00:00:00', strtotime($request->from_date));
            $to_date    = date('Y-m-d 23:59:59', strtotime($request->to_date));
            // Date
            $query->whereBetween('approval_date', [$from_date, $to_date]);
        }

        if ($request->zone_id) {
            $zone_id = $request->zone_id;
            // Zone
            $query->whereHas('show_room', function ($q) use ($zone_id) {
                $q->where('zone_id', $zone_id);
            });
        }

        if ($request->showroom_ctp) {
            $showrooms = explode(',', $request->showroom_ctp);
            $query->whereIn('showroom_id', $showrooms);
        }

        if ($request->store_type) {
            $stor_type = $request->store_type;
            $query->whereHas('show_room', function ($q) use ($stor_type) {
                $q->where('dealar', $stor_type);
            });
        }

        if ($request->product_model) {
            $product_model = explode(',', $request->product_model);
            $query->whereHas('purchase_products', function ($q) use ($product_model) {
                $q->whereIn('product_model_id', $product_model);
            });
        }

        if ($request->product_category) {
            $product_category = explode(',', $request->product_category);
            $query->whereHas('purchase_products', function ($q) use ($product_category) {
                $q->whereIn('product_category_id', $product_category);
            });
        }

        if ($request->brand_id) {
            $brand = explode(',', $request->brand_id);
            $query->whereHas('purchase_products', function ($q) use ($brand) {
                $q->whereIn('product_brand_id', $brand);
            });
        }

        if ($request->product_group) {
            $product_group_ids = explode(',', $request->product_group);
            $query->whereHas('purchase_products', function ($q) use ($product_group_ids) {
                $q->whereIn('product_group_id', $product_group_ids);
            });
        }

        if ($request->order_no) {
            $query->where('order_no', $request->order_no);
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

        $hirepurchase = $query->latest()->get();

        foreach ($hirepurchase as $hire) {
            $hire->late_fee = $this->calculateLateFine($hire->id);
        }

        $filename = 'current-outstanding-report-' . date('m-d-y-H-i-s') . '.xlsx';
        return Excel::download(new ExportPurchase($hirepurchase), $filename);
    }
    public function dueOnNextMonthExport(Request $request)
    {
        $from_date = date('Y-m-d 00:00:00', strtotime($request->from_date));
        $to_date = date('Y-m-d 23:59:59', strtotime($request->to_date));

        $query = HirePurchase::with([
            'installment' => function ($q) use ($from_date, $to_date) {
                $q->whereBetween('loan_start_date', [$from_date, $to_date])
                    ->where('status', 0) // Only unpaid installments
                    ->orderBy('loan_start_date', 'asc');
            },
            'transaction' => function ($q) {
                $q->where('status', 1)->orderBy('updated_at', 'desc');
            },
            'purchase_products.product_group',
            'purchase_products.product',
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
                $query->whereHas('purchase_products', function ($q) use ($product_group_ids) {
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

        foreach ($hirepurchase as $hire) {
            $hire->late_fee = $this->calculateLateFine($hire->id);
        }

        $filename = 'due-on-next-month-report-' . \App\Helpers\Helper::formatDateTimeFilename(now()) . '.xlsx';
        return Excel::download(new DueOnNextMonthExport($hirepurchase), $filename);
    }
}
