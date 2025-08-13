<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use DateTime;
use App\Models\Enquery;
use App\Models\FollowUp;
use App\Models\Installment;
use App\Models\Transaction;
use App\Models\HirePurchase;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\ZonePermission;
use App\Models\NotificationSeen;

class NotificationsController extends Controller
{
    public function notifications()
    {
        date_default_timezone_set('Asia/Dhaka');

        $notifications = [];
        $title = "customer";
        $description = "Some description for the page";
        $role_id = "";
        $userId = Auth::user()->id;

        if (Auth::user()->role_id == 3) { // manager
            $notifications = Notification::with(['showroom', 'notificationSeen', 'hirepurchase'])
                ->where('manager', 1)
                ->whereDoesntHave('notificationSeen', function ($query) use ($userId) {
                    $query->where('user_id', $userId);
                })->where('showroom_id', Auth::user()->showroom_id)
                ->get();
        } elseif (Auth::user()->role_id == 6) {
            $permission = ZonePermission::where('user_id', Auth::user()->id)->pluck('zone_id')->toArray();
       
            $notifications = Notification::with(['showroom', 'notificationSeen', 'hirepurchase'])
                ->where('retail', 1) // Filter by retail flag
                ->whereDoesntHave('notificationSeen', function ($query) use ($userId) {
                    // Exclude notifications that have been seen by this user
                    $query->where('user_id', $userId);
                })
                ->whereHas('showroom', function ($q) use ($permission) {
                    $q->whereIn('zone_id', $permission);
                })
                ->get();
        }

        // dd($notifications);
        return view('pages.notifications.notifications', compact('title', 'description', 'notifications'));


    }

    public function NotificationSeen($id)
    {



        $notification = Notification::findOrFail($id);

        if (empty($notification)) {
            return redirect()->back()->with('error', 'Notification Not Found Based On Given Hirepurchase Id');
        }

        $NotificationSeen = new NotificationSeen();

        $NotificationSeen->user_id = Auth::user()->id;
        $NotificationSeen->notification_id = $notification->id;
        $NotificationSeen->save();


        $title = "Product Details";
        $description = "Some description for the page";
        $product_details = HirePurchase::with(['purchase_product', 'purchase_product.product_category', 'purchase_product.brand', 'purchase_product.product', 'show_room', 'show_room_user', 'transaction', 'installment'])->findOrFail($notification->hire_id);
        $installments = Transaction::with(['hire_purchase:id,name,pr_phone', 'users', 'hire_purchase.purchase_product.product'])->where('hire_purchase_id', $notification->hire_id)->get();

        $installment_date = Installment::where('hire_purchase_id', $notification->hire_id)->orderBy('id', 'DESC')->first();

        return view('installment.hire_purchase.product_details', compact("title", "description", "product_details", 'installments', 'installment_date'));

    }

    public function NotificaionDetails($id, $notification_id)
    {

        $title = "Enquiry History";
        $description = "Some description for the page";
        $enquiries = Enquery::with(['enquiry_type', 'product', 'enquiry_source_child', 'customer', 'users', 'showroom'])
            ->where('id', $id)->first();
        // DB::table('enquiries')->where('id', $enquiries->id)->update(['seen' => 1]);
        FollowUp::with(['followupmethod'])->where('enquiry_id', $enquiries->id)->orderBy('id', 'ASC')->get();
        $followup = FollowUp::where('enquiry_id', $enquiries->id)->orderBy('id', 'DESC')->first();
        //  DB::table('follow_ups')->where('id', $followup->id)->update(['seen' => 1]);
        if (Auth::user()->role_id == 1) {
            DB::table('notifications')->where('id', $notification_id)->update(['admin_seen' => 1]);
        } elseif (Auth::user()->role_id == 2) {

            DB::table('notifications')->where('id', $notification_id)->update(['ex_seen' => 1]);

        } elseif (Auth::user()->role_id == 3) {
            DB::table('notifications')->where('id', $notification_id)->update(['man_seen' => 1]);
        }
        return view('pages.enquiry.history', compact('title', 'description', 'enquiries'));
    }


    public function GenerateNotification()
    {
        date_default_timezone_set('Asia/Dhaka');
        $presentTime = new DateTime();

        $futureTime = clone $presentTime;

        $pre = $futureTime->format('Y-m-d H:i:s');
        $futureTime->modify('+6 hours');
        $futureTime = $futureTime->format('Y-m-d H:i:s');

        $allertfollowup = FollowUp::with([
            'enquiry' => function ($enquiry) {
                $enquiry->with(['users', 'showroom']);
            }
        ])
            ->where('next_follow_up_date', '<', $futureTime)  // Assuming $futureTime is defined
            ->where('next_follow_up_date', '>', $pre)
            ->where('status', 0)
            ->where('alert_notifications', 0)
            ->get();

        $alertdata = [];

        foreach ($allertfollowup as $key => $allert) {
            $alertdata['name'] = $allert->enquiry->name;
            $alertdata['next_follow_up_date'] = $allert->next_follow_up_date;
            $alertdata['enquiry_id'] = $allert->enquiry_id;
            $alertdata['customer_id'] = $allert->enquiry->customer_id;
            $alertdata['assign'] = $allert->enquiry->assign;
            $alertdata['created_by'] = $allert->enquiry->created_by;
            $alertdata['notifications_type'] = 2;
            $alertdata['followup_id'] = $allert->id;
            $alertdata['showroom_id'] = $allert->enquiry->showroom_id;
            DB::table('follow_ups')->where('id', $allert->id)->update(['alert_notifications' => 1]);
            $notifi = new Notification;
            $notifi->fill($alertdata)->save();

        }

        $passedoverdata = [];

        $passedover = FollowUp::with([
            'enquiry' => function ($enquiry) {
                $enquiry->with(['users', 'showroom']);
            }
        ])->where('next_follow_up_date', '<', now())
            ->where('alert_passed_over', 0)
            ->where('status', 0)->get();

        $passoverData = [];

        foreach ($passedover as $key => $pass) {
            $passoverData['name'] = $pass->enquiry->name;
            $passoverData['next_follow_up_date'] = $pass->next_follow_up_date;
            $passoverData['enquiry_id'] = $pass->enquiry_id;
            $passoverData['customer_id'] = $pass->enquiry->customer_id;
            $passoverData['assign'] = $pass->enquiry->assign;
            $passoverData['created_by'] = $pass->enquiry->created_by;
            $passoverData['notifications_type'] = 3;
            $passoverData['showroom_id'] = $pass->enquiry->showroom_id;
            $passoverData['followup_id'] = $pass->id;

            DB::table('follow_ups')->where('id', $pass->id)->update(['alert_passed_over' => 1]);
            $notifi = new Notification;
            $notifi->fill($passoverData)->save();

        }

        echo "done";

    }


    public function ClearAll()
    {


        if (Auth::user()->role_id == 1) {
            DB::table('notifications')->update(['admin_seen' => 1]);
        } elseif (Auth::user()->role_id == 2) {
            DB::table('notifications')->update(['ex_seen' => 1]);

        } elseif (Auth::user()->role_id == 3) {
            DB::table('notifications')->update(['man_seen' => 1]);
        }

        return redirect()->back()->with('success', 'Success! Notifications Clear');


    }
}
