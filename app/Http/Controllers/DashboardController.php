<?php

namespace App\Http\Controllers;

use DateTime;
use DatePeriod;
use DateInterval;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Zone;
use App\Models\Enquery;
use App\Models\Setting;
use App\Models\FollowUp;
use App\Models\ShowRoom;
use App\Models\Installment;
use App\Models\ProductType;
use App\Models\Transaction;
use App\Models\HirePurchase;
use App\Models\ShowRoomUser;
use Illuminate\Http\Request;
use App\Models\EnquirySource;


use App\Models\ZonePermission;
use Illuminate\Support\Facades\DB;
use App\Models\HirePurchaseProduct;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{

    public function userMarge(Request $request)
    {
        $user = User::where('role_id', 3)->get();


        //        foreach($user as $row){
        //            $showroom_user = ShowRoomUser::where('phone', $row->phone)->where('showroom_id',$row->showroom_id)->first();
        //
        //
        //
        //            if($showroom_user){
        //                echo "$showroom_user->phone    already exits<br>";
        //            }else{
        //                $showroom_user = new ShowRoomUser();
        //                $showroom_user->name = $row->name;
        //                $showroom_user->phone = $row->phone;
        //                $showroom_user->address = $row->address;
        //                $showroom_user->showroom_id = $row->showroom_id;
        //                $showroom_user->is_active = $row->status;
        //                $showroom_user->created_by = 210;
        //                $showroom_user->save();
        //
        //                echo "done <br>";
        //            }
        //        }

        //        return response()->json(['status' => 'success']);
    }


    public function index(Request $request)
    {
        date_default_timezone_set('Asia/Dhaka');

        $today = now()->format('Y-m-d');
        $startOfMonth = now()->startOfMonth()->format('Y-m-d');
        $endOfMonth = now()->endOfMonth()->format('Y-m-d');
        $title = "Dashboard";

        $showroom_credit = ShowRoom::latest();

        if (Auth::user()->role_id == User::ADMIN) {

            $dueData = Installment::join('hire_purchases', 'installments.hire_purchase_id', '=', 'hire_purchases.id')
                ->where('hire_purchases.status', 3)
                ->where('hire_purchases.is_paid', 0)
                ->where('installments.status', 0)
                ->selectRaw('SUM(installments.amount) as total_due, COUNT(DISTINCT hire_purchases.id) as total_count')
                ->first();
            $total_credit = $dueData->total_due;
        }
        $firstDayLastMonth = date('Y-m-d 00:00:00', strtotime("first day of last month"));
        // Calculate the last day of the last month
        $lastDayLastMonth = date('Y-m-d 23:59:59', strtotime("last day of last month"));
        $previousDate = date('Y-m-d', strtotime(now()->format('Y-m-d') . ' -1 day'));
        $zones = Zone::orderBy('name', 'ASC')->get();
        $description = "Some description for the page";
        $countData['countshowrooms'] = ShowRoom::count();

        $countexecutive = User::where('role_id', 2)->where('is_active', 1);
        $countmanager = User::where('role_id', 3)->where('is_active', 1);

        //count
        $counttodaysales = HirePurchase::whereDate('created_at', $today)->where('status', 3);
        $todays_collection = Transaction::whereDate('updated_at', $today)->where('status', 1);
        $overdue = Installment::whereDate('loan_end_date', '<', now()->toDateString())
            ->where('status', 0)
            ->whereHas('hire_purchase', function ($q) {
                $q->where('status', 3) // Only approved hire purchases
                    ->where('is_paid', 0); // Only unpaid hire purchases
            });
        $current_month_forcast = Installment::where('status', 0)->whereBetween('loan_start_date', [$startOfMonth, $endOfMonth]);
        //last 5 transaction
        $query = Transaction::with(['hire_purchase:id,name,pr_phone,showroom_id', 'users', 'hire_purchase.purchase_product.product', 'hire_purchase.show_room']);

        // Base query for dashboard statistics
        $statsQuery = HirePurchase::query(); // Approved status

        if ($request->zone) {
            $zone_id = $request->zone;
            $showroom_credit = $showroom_credit->where('zone_id', $zone_id);


            $dueData = Installment::join('hire_purchases', 'installments.hire_purchase_id', '=', 'hire_purchases.id')
                ->join('show_rooms', 'hire_purchases.showroom_id', '=', 'show_rooms.id')
                ->where('hire_purchases.status', 3)
                ->where('hire_purchases.is_paid', 0)
                ->where('installments.status', 0)
                ->where('show_rooms.zone_id', $zone_id)
                ->selectRaw('SUM(installments.amount) as total_due, COUNT(DISTINCT hire_purchases.id) as total_count')
                ->first();

            $total_credit = $dueData->total_due;
            $query->whereHas('hire_purchase.show_room', function ($q) use ($zone_id) {
                $q->where('zone_id', $zone_id);
            });
            $todays_collection->whereHas('hire_purchase.show_room', function ($q) use ($zone_id) {
                $q->where('zone_id', $zone_id);
            });
            $overdue->whereHas('hire_purchase.show_room', function ($q) use ($zone_id) {
                $q->where('zone_id', $zone_id);
            });

            $current_month_forcast->whereHas('hire_purchase.show_room', function ($q) use ($zone_id) {
                $q->where('zone_id', $zone_id);
            });

            $counttodaysales->whereHas('show_room', function ($q) use ($zone_id) {
                $q->where('zone_id', $zone_id);
            });

            // Apply zone filter to stats query
            $statsQuery->whereHas('show_room', function ($q) use ($zone_id) {
                $q->where('zone_id', $zone_id);
            });
        }

        if ($request->Showroom) {
            $showroom_id = $request->Showroom;
            $showroom_credit = $showroom_credit->where('id', $showroom_id);


            $dueData = Installment::join('hire_purchases', 'installments.hire_purchase_id', '=', 'hire_purchases.id')
                ->where('hire_purchases.showroom_id', $showroom_id)
                ->where('hire_purchases.status', 3)
                ->where('hire_purchases.is_paid', 0)
                ->where('installments.status', 0)
                ->selectRaw('SUM(installments.amount) as total_due, COUNT(DISTINCT hire_purchases.id) as total_count')
                ->first();

            $total_credit = $dueData->total_due;


            $query->whereHas('hire_purchase', function ($q) use ($showroom_id) {
                $q->where('showroom_id',  $showroom_id);
            });


            $todays_collection->whereHas('hire_purchase', function ($q) use ($showroom_id) {
                $q->where('showroom_id',  $showroom_id);
            });

            $overdue->whereHas('hire_purchase', function ($q) use ($showroom_id) {
                $q->where('showroom_id',  $showroom_id);
            });

            $current_month_forcast->whereHas('hire_purchase', function ($q) use ($showroom_id) {
                $q->where('showroom_id',  $showroom_id);
            });


            $counttodaysales->where('showroom_id',  $showroom_id);
            // Apply showroom filter to stats query
            $statsQuery->where('showroom_id', $showroom_id);
        }


        if (Auth::user()->role_id == User::ZONE) {
            $zone_id = Auth::user()->zone_id;

            $showroom_credit = $showroom_credit->where('zone_id', $zone_id);


            $dueData = Installment::join('hire_purchases', 'installments.hire_purchase_id', '=', 'hire_purchases.id')
                ->join('show_rooms', 'hire_purchases.showroom_id', '=', 'show_rooms.id')
                ->where('show_rooms.zone_id', $zone_id)
                ->where('hire_purchases.status', 3)
                ->where('hire_purchases.is_paid', 0)
                ->where('installments.status', 0)
                ->selectRaw('SUM(installments.amount) as total_due, COUNT(DISTINCT hire_purchases.id) as total_count')
                ->first();

            $total_credit = $dueData->total_due;


            $query->whereHas('hire_purchase.show_room', function ($q) use ($zone_id) {
                $q->where('zone_id', $zone_id);
            });
            $todays_collection->whereHas('hire_purchase.show_room', function ($q) use ($zone_id) {
                $q->where('zone_id', $zone_id);
            });
            $overdue->whereHas('hire_purchase.show_room', function ($q) use ($zone_id) {
                $q->where('zone_id', $zone_id);
            });

            $current_month_forcast->whereHas('hire_purchase.show_room', function ($q) use ($zone_id) {
                $q->where('zone_id', $zone_id);
            });

            $counttodaysales->whereHas('show_room', function ($q) use ($zone_id) {
                $q->where('zone_id', $zone_id);
            });

            // Apply zone filter to stats query
            $statsQuery->whereHas('show_room', function ($q) use ($zone_id) {
                $q->where('zone_id', $zone_id);
            });
        } elseif (Auth::user()->role_id == User::MANAGER) {


            $showroom_id = Auth::user()->showroom_id;

            $showroom_credit = $showroom_credit->where('id', $showroom_id);


            $dueData = Installment::join('hire_purchases', 'installments.hire_purchase_id', '=', 'hire_purchases.id')
                ->where('hire_purchases.showroom_id', $showroom_id)
                ->where('hire_purchases.status', 3)
                ->where('hire_purchases.is_paid', 0)
                ->where('installments.status', 0)
                ->selectRaw('SUM(installments.amount) as total_due, COUNT(DISTINCT hire_purchases.id) as total_count')
                ->first();

            $total_credit = $dueData->total_due;


            $query->whereHas('hire_purchase', function ($q) use ($showroom_id) {
                $q->where('showroom_id',  $showroom_id);
            });


            $todays_collection->whereHas('hire_purchase', function ($q) use ($showroom_id) {
                $q->where('showroom_id',  $showroom_id);
            });

            $overdue->whereHas('hire_purchase', function ($q) use ($showroom_id) {
                $q->where('showroom_id',  $showroom_id);
            });

            $counttodaysales->where('showroom_id',  $showroom_id);

            $current_month_forcast->whereHas('hire_purchase', function ($q) use ($showroom_id) {
                $q->where('showroom_id',  $showroom_id);
            });

            // Apply showroom filter to stats query
            $statsQuery->where('showroom_id', $showroom_id);
        } elseif (Auth::user()->role_id == User::RETAIL) {
            $permission = ZonePermission::where('user_id', Auth::user()->id)->pluck('zone_id')->toArray();
            $showroom_credit = $showroom_credit->whereIn('zone_id', $permission);

            // $dueData = HirePurchase::where('installment_complete', 0)
            //     ->join('show_rooms', 'hire_purchases.showroom_id', '=', 'show_rooms.id')
            //     ->whereIn('show_rooms.zone_id', $permission)
            //     ->join('hire_purchase_products', 'hire_purchases.id', '=', 'hire_purchase_products.hire_purchase_id')
            //     ->select(
            //         DB::raw('SUM(hire_purchase_products.hire_price - hire_purchase_products.total_paid) as total_due'),
            //         DB::raw('COUNT(hire_purchases.id) as total_count')
            //     )
            //     ->first();

            $dueData = Installment::join('hire_purchases', 'installments.hire_purchase_id', '=', 'hire_purchases.id')
                ->join('show_rooms', 'hire_purchases.showroom_id', '=', 'show_rooms.id')
                ->whereIn('show_rooms.zone_id', $permission) // $permission = array of allowed zone_ids
                ->where('hire_purchases.status', 3)
                ->where('hire_purchases.is_paid', 0)
                ->where('installments.status', 0)
                ->selectRaw('SUM(installments.amount) as total_due, COUNT(DISTINCT hire_purchases.id) as total_count')
                ->first();

            $total_credit = $dueData->total_due;

            $query->whereHas('hire_purchase.show_room', function ($q) use ($permission) {
                $q->whereIn('zone_id', $permission);
            });

            $counttodaysales->whereHas('show_room', function ($q) use ($permission) {
                $q->whereIn('zone_id', $permission);
            });

            $current_month_forcast->whereHas('hire_purchase.show_room', function ($q) use ($permission) {
                $q->whereIn('zone_id', $permission);
            });

            $overdue->whereHas('hire_purchase.show_room', function ($q) use ($permission) {
                $q->whereIn('zone_id', $permission);
            });

            $todays_collection->whereHas('hire_purchase.show_room', function ($q) use ($permission) {
                $q->whereIn('zone_id', $permission);
            });

            // Apply zone permission filter to stats query
            $statsQuery->whereHas('show_room', function ($q) use ($permission) {
                $q->whereIn('zone_id', $permission);
            });
        }

        // $totalSale = (clone $statsQuery)->count();
        // $fullPaid = (clone $statsQuery)->where('is_paid', 1)->count();
        // $customerWithDue = (clone $statsQuery)->where('is_paid', 0)->count();
        // $notApproved = HirePurchase::where('status', '!=', 3)->count(); // Same as totalSale since we're filtering by status=3

        // Dashboard stats
        $totalSale = (clone $statsQuery)->where('status', 3)->count(); // Approved
        $fullPaid = (clone $statsQuery)->where('status', 3)->where('is_paid', 1)->count();
        $customerWithDue = (clone $statsQuery)->where('status', 3)->where('is_paid', 0)->count();
        $pending = (clone $statsQuery)->where('status', '0')->count();

        // Add to data array
        $data['dashboard_stats'] = [
            'total_sale' => $totalSale,
            'full_paid' => $fullPaid,
            'customer_with_due' => $customerWithDue,
            'pending' => $pending
        ];

        $lastfiveenquiry = Enquery::orderBy('id', 'DESC');
        $counttpreviousenquery = Enquery::whereDate('created_at', $previousDate);

        $countData['request'] = $request->all();
        $counttodaysales = $counttodaysales->pluck('id')->toarray();
        $data['counttodaysales'] = HirePurchaseProduct::whereIn('hire_purchase_id', $counttodaysales)->sum('hire_price');
        $data['todays_collection'] = $todays_collection->sum('amount');
        $data['overdue']            = $overdue->sum('amount');
        $data['current_month_forcast'] = $current_month_forcast->sum('amount');
        $data['remaining_credit'] = $total_credit;
        $data['showroom_credit'] = $showroom_credit->sum('credit_score');

        $installments = $query->latest()->take(5)->get();
        //monthly collection status its shifted different method bia ajax

        $current_date = date('d-m-Y');
        $start_date = date('1-m-y');
        $end_date = date('t-m-Y');
        // dd($end_date);
        $lastdate = explode('-', $end_date);
        $alldate = [];
        $num = [];
        for ($i = 01; $i <= $lastdate[0]; $i++) {
            $alldate[] = date('Y-m-' . $i);
            $num[] = "$i";
        }
        $couttodaycollection = [];

        foreach ($alldate as $source) {
            $collectioncount = Transaction::whereDate('created_at', $source)->where('status', 1);
            if ($request->zone) {
                $zone_id = $request->zone;
                $collectioncount->whereHas('hire_purchase', function ($hirepurchase) use ($zone_id) {
                    $hirepurchase->whereHas('show_room', function ($showroom) use ($zone_id) {
                        $showroom->where('zone_id', $zone_id);
                    });
                });
            }

            if ($request->Showroom) {
                $showroom_id = $request->Showroom;
                $collectioncount->whereHas('hire_purchase', function ($hirepurchase) use ($showroom_id) {
                    $hirepurchase->where('showroom_id', $showroom_id);
                });
            }

            if (Auth::user()->role_id == User::ZONE) {
                $zone_id = Auth::user()->zone_id;

                $collectioncount->whereHas('hire_purchase', function ($hirepurchase) use ($zone_id) {
                    $hirepurchase->whereHas('show_room', function ($showroom) use ($zone_id) {
                        $showroom->where('zone_id', $zone_id);
                    });
                });
            } elseif (Auth::user()->role_id == User::MANAGER) {
                $showroom_id = Auth::user()->showroom_id;

                $collectioncount->whereHas('hire_purchase', function ($hirepurchase) use ($showroom_id) {
                    $hirepurchase->where('showroom_id', $showroom_id);
                });
            } elseif (Auth::user()->role_id == User::RETAIL) {

                $permission = ZonePermission::where('user_id', Auth::user()->id)->pluck('zone_id')->toArray();

                $collectioncount->whereHas('hire_purchase', function ($hirepurchase) use ($permission) {
                    $hirepurchase->whereHas('show_room', function ($showroom) use ($permission) {
                        $showroom->whereIn('zone_id', $permission);
                    });
                });
            }

            $couttodaycollection[] = $collectioncount->sum('amount');
        }

        $couttodaycollection = json_encode($couttodaycollection);

        $group_name = ProductType::latest()->pluck('name')->toArray();
        $group_id = ProductType::latest()->pluck('id')->toArray();

        $selList = [];

        foreach ($group_id as $id) {
            $hirepurchase_sale = HirePurchaseProduct::with(['hire_purchase'])
                ->whereHas('hire_purchase', function ($hirepurchase) use ($startOfMonth, $endOfMonth) {
                    $hirepurchase->whereBetween('approval_date', [$startOfMonth, $endOfMonth]);
                })
                ->where('product_group_id', $id);

            if ($request->zone) {
                $zone_id = $request->zone;
                $hirepurchase_sale->whereHas('hire_purchase', function ($hirepurchase) use ($zone_id) {
                    $hirepurchase->whereHas('show_room', function ($showroom) use ($zone_id) {
                        $showroom->where('zone_id', $zone_id);
                    });
                });
            }

            if ($request->Showroom) {
                $showroom_id = $request->Showroom;
                $hirepurchase_sale->whereHas('hire_purchase', function ($hirepurchase) use ($showroom_id) {
                    $hirepurchase->where('showroom_id', $showroom_id);
                });
            }

            $price = intval($hirepurchase_sale->sum('hire_price'));
            $selList[] = $price === 0 ? 1 : $price;
        }


        $enquery_source = EnquirySource::orderBy('id', 'ASC')->where('parent_id', 0)->get();
        return view('pages.dashboard', compact(
            'title',
            'firstDayLastMonth',
            'description',
            'countData',
            'zones',
            'enquery_source',
            'firstDayLastMonth',
            'lastDayLastMonth',
            'data',
            'installments',
            'couttodaycollection',
            'selList',
            'group_name'
        ));
    }

    public function SelectShowroom(Request $request)
    {

        $showrooms = ShowRoom::where('zone_id', $request->parent_id)->get();
        return json_encode($showrooms);
    }

    //     public function getCollectionChartData(Request $request)
    // {
    //     $from_date = $request->input('from_date', date('1-m-Y'));
    //     $to_date = $request->input('to_date', date('t-m-Y'));

    //     // Convert to Y-m-d format for database queries
    //     $from_date_formatted = date('Y-m-d', strtotime($from_date));
    //     $to_date_formatted = date('Y-m-d', strtotime($to_date));

    //     $start_date_obj = new DateTime($from_date_formatted);
    //     $end_date_obj = new DateTime($to_date_formatted);
    //     $end_date_obj->modify('+1 day'); // Include the end date

    //     $interval = new DateInterval('P1D');
    //     $date_range = new DatePeriod($start_date_obj, $interval, $end_date_obj);

    //     $alldate = [];
    //     $categories = [];
    //     foreach ($date_range as $date) {
    //         $alldate[] = $date->format('Y-m-d');
    //         $categories[] = $date->format('j');
    //     }

    //     $couttodaycollection = [];
    //     foreach ($alldate as $source) {
    //         $collectioncount = Transaction::whereDate('created_at', $source)->where('status', 1);

    //         // Apply the same filters as in the main index method
    //         if ($request->zone) {
    //             $zone_id = $request->zone;
    //             $collectioncount->whereHas('hire_purchase', function ($hirepurchase) use ($zone_id) {
    //                 $hirepurchase->whereHas('show_room', function ($showroom) use ($zone_id) {
    //                     $showroom->where('zone_id', $zone_id);
    //                 });
    //             });
    //         }
    //         if ($request->Showroom) {
    //             $showroom_id = $request->Showroom;
    //             $collectioncount->whereHas('hire_purchase', function ($hirepurchase) use ($showroom_id) {
    //                 $hirepurchase->where('showroom_id', $showroom_id);
    //             });
    //         }
    //         if (Auth::user()->role_id == User::ZONE) {
    //             $zone_id = Auth::user()->zone_id;
    //             $collectioncount->whereHas('hire_purchase', function ($hirepurchase) use ($zone_id) {
    //                 $hirepurchase->whereHas('show_room', function ($showroom) use ($zone_id) {
    //                     $showroom->where('zone_id', $zone_id);
    //                 });
    //             });
    //         } elseif (Auth::user()->role_id == User::MANAGER) {
    //             $showroom_id = Auth::user()->showroom_id;
    //             $collectioncount->whereHas('hire_purchase', function ($hirepurchase) use ($showroom_id) {
    //                 $hirepurchase->where('showroom_id', $showroom_id);
    //             });
    //         } elseif (Auth::user()->role_id == User::RETAIL) {
    //             $permission = ZonePermission::where('user_id', Auth::user()->id)->pluck('zone_id')->toArray();
    //             $collectioncount->whereHas('hire_purchase', function ($hirepurchase) use ($permission) {
    //                 $hirepurchase->whereHas('show_room', function ($showroom) use ($permission) {
    //                     $showroom->whereIn('zone_id', $permission);
    //                 });
    //             });
    //         }
    //         $couttodaycollection[] = $collectioncount->sum('amount');
    //     }

    //     // Format the month name for display
    //     $startMonth = date('F Y', strtotime($from_date_formatted));
    //     $endMonth = date('F Y', strtotime($to_date_formatted));
    //     $monthName = ($startMonth === $endMonth) ? $startMonth : "$startMonth - $endMonth";

    //     return response()->json([
    //         'data' => $couttodaycollection,
    //         'categories' => $categories,
    //         'month_name' => $monthName
    //     ]);
    // }

    public function EnquiryStatistics(Request $request)
    {
        // Parse the date inputs
        $startOfMonth = date('Y-m-d 00:00:00', strtotime($request->from_date));
        $endOfMonth = date('Y-m-d 23:59:59', strtotime($request->to_date));

        $group_name = ProductType::latest()->pluck('name');
        $gourp_id = ProductType::latest()->pluck('id');
        $group_name = json_encode($group_name);

        $selList = [];
        foreach ($gourp_id as $id) {
            $hirepurchase_sale = HirePurchaseProduct::with(['hire_purchase'])
                ->whereHas('hire_purchase', function ($hirepurchase) use ($startOfMonth, $endOfMonth) {
                    $hirepurchase->whereBetween('approval_date', [$startOfMonth, $endOfMonth]);
                })
                ->where('product_group_id', $id);

            // Zone filter
            if ($request->zone) {
                $zone_id = $request->zone;
                $hirepurchase_sale->whereHas('hire_purchase', function ($hirepurchase) use ($zone_id) {
                    $hirepurchase->whereHas('show_room', function ($showroom) use ($zone_id) {
                        $showroom->where('zone_id', $zone_id);
                    });
                });
            }

            // Showroom filter
            if ($request->Showroom) {
                $showroom_id = $request->Showroom;
                $hirepurchase_sale->whereHas('hire_purchase', function ($hirepurchase) use ($showroom_id) {
                    $hirepurchase->where('showroom_id', $showroom_id);
                });
            }

            // Role-based filters
            if (Auth::user()->role_id == User::ZONE) {
                $zone_id = Auth::user()->zone_id;
                $hirepurchase_sale->whereHas('hire_purchase', function ($hirepurchase) use ($zone_id) {
                    $hirepurchase->whereHas('show_room', function ($showroom) use ($zone_id) {
                        $showroom->where('zone_id', $zone_id);
                    });
                });
            } elseif (Auth::user()->role_id == User::MANAGER) {
                $showroom_id = Auth::user()->showroom_id;
                $hirepurchase_sale->whereHas('hire_purchase', function ($hirepurchase) use ($showroom_id) {
                    $hirepurchase->where('showroom_id', $showroom_id);
                });
            } elseif (Auth::user()->role_id == User::RETAIL) {
                $permission = ZonePermission::where('user_id', Auth::user()->id)->pluck('zone_id')->toArray();
                $hirepurchase_sale->whereHas('hire_purchase', function ($hirepurchase) use ($permission) {
                    $hirepurchase->whereHas('show_room', function ($showroom) use ($permission) {
                        $showroom->whereIn('zone_id', $permission);
                    });
                });
            }

            $price = intval($hirepurchase_sale->sum('hire_price'));
            $selList[] = $price;
        }

        $selList = json_encode($selList);

        return view('components.dashboard.enquirystatistic', compact('group_name', 'gourp_id', 'selList'));
    }




    public function SourceStatistics(Request $request)
    {
        $current_year = date('Y');
        $startOfMonth = $current_year . '-' . str_pad($request->month_source, 2, '0', STR_PAD_LEFT) . '-01';
        $endOfMonth = date('Y-m-t', strtotime($startOfMonth));
        $status = 1;

        $enquiry_status = @Setting::first()->enquiry_status;
        $new_close_status = array_diff($enquiry_status['close'], [$enquiry_status['sale']]);
        $pending_status   = isset($enquiry_status['pending']) ? $enquiry_status['pending'] : [];

        $enquiry_sources = EnquirySource::where('parent_id', 0)->get();


        return view('components.dashboard.sourcewisecount', compact('enquiry_sources', 'endOfMonth', 'startOfMonth', 'pending_status', 'enquiry_status', 'new_close_status'));
    }

    // public function getHirePurchaseApprovals(Request $request)
    // {

    //     date_default_timezone_set('Asia/Dhaka');
    //     $today = now()->format('Y-m-d');
    //     $user = Auth::user();
    //     $userId = $user->id;
    //     $showroomId = $user->showroom_id;
    //     $userRole = $user->role_id;

    //     $str = '';

    //     // Get today's created hire purchases (not yet approved)
    //     $created = HirePurchase::with(['show_room'])
    //         ->whereDate('created_at', $today)
    //         ->where('status', '!=', 3) // Not approved yet
    //         ->where('is_paid', 0); // Not fully paid

    //     // Apply role-based filters
    //     if ($userRole == User::ZONE) {
    //         $zoneId = $user->zone_id;
    //         $created->whereHas('show_room', function ($q) use ($zoneId) {
    //             $q->where('zone_id', $zoneId);
    //         });
    //     } elseif ($userRole == User::MANAGER) {
    //         $created->where('showroom_id', $showroomId);
    //     } elseif (($userRole == User::RETAIL) || ($userRole == 7) || ($userRole == 8)) {
    //         $permission = ZonePermission::where('user_id', $userId)->pluck('zone_id')->toArray();
    //         $created->whereHas('show_room', function ($q) use ($permission) {
    //             $q->whereIn('zone_id', $permission);
    //         });
    //     }

    //     $createdData = $created->get();

    //     // Add created notifications
    //     foreach ($createdData as $row) {
    //         $str .= "New BNPL Purchase Created: {$row->name} - {$row->show_room->name} ** ";
    //     }

    //     // Get today's approved hire purchases where loan has started
    //     $approvals = HirePurchase::with(['show_room'])
    //         ->whereDate('approval_date', $today)
    //         ->where('status', 3) // Status for approved loans
    //         ->where('is_paid', 0); // Not fully paid

    //     // Apply role-based filters (same as above)
    //     if ($userRole == User::ZONE) {
    //         $zoneId = $user->zone_id;
    //         $approvals->whereHas('show_room', function ($q) use ($zoneId) {
    //             $q->where('zone_id', $zoneId);
    //         });
    //     } elseif ($userRole == User::MANAGER) {
    //         $approvals->where('showroom_id', $showroomId);
    //     } elseif (($userRole == User::RETAIL) || ($userRole == 7) || ($userRole == 8)) {
    //         $permission = ZonePermission::where('user_id', $userId)->pluck('zone_id')->toArray();
    //         $approvals->whereHas('show_room', function ($q) use ($permission) {
    //             $q->whereIn('zone_id', $permission);
    //         });
    //     }

    //     $approvalData = $approvals->get();

    //     // Add approval notifications
    //     foreach ($approvalData as $row) {
    //         $str .= "New BNPL Purchase Approved: {$row->name} - {$row->show_room->name} ** ";
    //     }

    //     return $str;
    // }

    public function getTransactionMarquee(Request $request)
    {
        date_default_timezone_set('Asia/Dhaka');
        $user = Auth::user();
        $userId = $user->id;
        $userRole = $user->role_id;
        $today = now()->format('Y-m-d'); // Today

        $str = '';

        // Base query: today's transactions
        $query = Transaction::with([
            'hire_purchase:id,order_no,name,pr_phone,showroom_id',
            'hire_purchase.show_room',
            'users:id,name'
        ])
            ->where('status', 1)
            ->whereDate('created_at', $today);

        // Role-based filters
        if ($userRole == 2) { // Zone
            $zoneId = $user->zone_id;
            $query->whereHas('hire_purchase.show_room', fn($q) => $q->where('zone_id', $zoneId));
        } elseif ($userRole == 3) { // Manager
            $showroomId = $user->showroom_id;
            $query->whereHas('hire_purchase', fn($q) => $q->where('showroom_id', $showroomId));
        } elseif (in_array($userRole, [6, 7, 8])) { // Retail / permissions
            $permission = ZonePermission::where('user_id', $userId)->pluck('zone_id')->toArray();
            $query->whereHas('hire_purchase.show_room', fn($q) => $q->whereIn('zone_id', $permission));
        }

        $transactions = $query->latest()->get();
        // dd($transactions);

        // Build marquee string
        foreach ($transactions as $t) {
            $typeText = ucfirst($t->transaction_type); // e.g., Installment / Full_payment
            $str .= "New {$typeText} Paid ({$t->amount} TK): {$t->hire_purchase->name} - {$t->hire_purchase->show_room->name} ** ";
        }

        return $str;
    }
}
