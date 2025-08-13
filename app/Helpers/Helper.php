<?php
namespace App\Helpers;

use App\Models\Menu;
use App\Models\MenuPermission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Helper
{


       static  function ordinal($number) {
            $ends = array('th','st','nd','rd','th','th','th','th','th','th');
            if ((($number % 100) >= 11) && (($number % 100) <= 13)) {
                return $number . 'th';
            } else {
                return $number . $ends[$number % 10];
            }
        }


   public static function formatOrdinal($number) {
        $lastDigit = $number % 10;
        $lastTwoDigits = $number % 100;

        if ($lastDigit == 1 && $lastTwoDigits != 11) {
            return $number . 'st';
        } elseif ($lastDigit == 2 && $lastTwoDigits != 12) {
            return $number . 'nd';
        } elseif ($lastDigit == 3 && $lastTwoDigits != 13) {
            return $number . 'rd';
        } else {
            return $number . 'th';
        }
    }
    public static function imageExtension($ext)
    {
        $allowed_extension = ['jpg', 'jpeg', 'png'];
        if (!in_array($ext, $allowed_extension)) {
            return 'Allowed Extension Only' . implode(',', $allowed_extension);
        }

        return  true;
    }

    public static function is_rtl($current_locale = '')
    {
        $current_locale = (!empty($current_locale)) ? $current_locale :  app()->getLocale();
        $is_rtl         = config('languages.' . $current_locale . '.is_rtl');

        return !empty($is_rtl);
    }

    public static function rlt_ext($current_locale = '')
    {
        $current_locale = (!empty($current_locale)) ? $current_locale :  app()->getLocale();

        return self::is_rtl($current_locale) ? '.rtl' : '';
    }

    public static function get_translation_url($locale = '')
    {

        return route('switch_lang', $locale);
    }

    public static function get_public_storage_asset_url($path)
    {

        $path = preg_replace('/^(public)[\/]/', '', $path);

        return asset('storage/' . $path);
    }

    public static function status_types(){
        return [
            ['id' => 1, 'name' => 'Open'],
            ['id' => 2, 'name' => 'Close'],
            ['id' => 3, 'name' => 'Sale'],
            ['id' => 4, 'name' => 'Panding'],
        ];
    }
     public static function user_menu_ids()
    {
        return MenuPermission::where('role_id', Auth::user()->role_id)->pluck('menu_id')->toArray();
    }
    public static function menus()
    {
        $query = Menu::where('parent_id', 0)->where('status',1)->orderBy('priority','ASC')->get()->toArray();
        $results = array();
        foreach ($query as $q){
            $q['children'] = Menu::where('parent_id', $q['id'])->get()->toArray();
            $results[] = $q;
        }
        return $results;

        // return [
        //     'enquiry' => [
        //         "id"         => 1,
        //         'url'        => 'enquiry',
        //         'title'      => "Enquiry",
        //         'icon'       => 'nav-icon-1 fas fa-user-check',
        //         'permission' => null,
        //         'children'   => []
        //     ],
        //     'passed_over' => [
        //         "id"         => 2,
        //         'url'        => 'passed-over',
        //         'title'      => "Passed Over Enquiry",
        //         'icon'       => 'nav-icon-2 fas fa-history',
        //         'permission' => "",
        //         'children'   => []
        //     ],
        //     'customer' => [
        //         "id"         => 3,
        //         'url'        => null,
        //         'title'      => "Customer",
        //         'icon'       => 'nav-icon-3 fas fa-user-friends',
        //         'permission' => "",
        //         'children'   => [
        //             'customer-type' => [
        //                 "id"    => 4,
        //                 'url'   => 'customer-type',
        //                 'title' => "Type",
        //                 'icon'  => null,
        //             ],
        //             'customer-profession' => [
        //                 "id"    => 5,
        //                 'url'   => 'customer-profession',
        //                 'title' => "Profession",
        //                 'icon'  => null,
        //             ],
        //             'customer' => [
        //                 "id"    => 6,
        //                 'url'   => 'customer',
        //                 'title' => "Customer List",
        //                 'icon'  => '',
        //             ],
        //         ]
        //     ],
        //     'enquiry_setting' => [
        //         "id"       => 7,
        //         'url'      => null,
        //         'title'    => "Enquiry Setting",
        //         'icon'     => 'nav-icon-4 fas fa-users-cog',
        //         'children' => [

        //             'enquiry-source' => [
        //                 "id"    => 9,
        //                 'url'   => 'enquiry-source',
        //                 'title' => "Enquiry Source",
        //                 'icon'  => null,
        //             ],
        //             'purchase-mode' => [
        //                 "id"    => 10,
        //                 'url'   => 'purchase-mode',
        //                 'title' => "Purchase Mode",
        //                 'icon'  => null,
        //             ],
        //             'followup-method' => [
        //                 "id"    => 11,
        //                 'url'   => 'follow-up-method',
        //                 'title' => "Followup Method",
        //                 'icon'  => null,
        //             ],
        //             'enquiry-status' => [
        //                 "id"    => 12,
        //                 'url'   => 'enquiry-status',
        //                 'title' => "Enquiry Status",
        //                 'icon'  => null,
        //             ],
        //             'enquiry-status-setting' => [
        //                 "id"    => 13,
        //                 'url'   => 'enquiry-status-setting',
        //                 'title' => "Enquiry Status Setting",
        //                 'icon'  => null,
        //             ],
        //         ]
        //     ],
        //     'showroom' => [
        //         "id"         => 14,
        //         'url'        => null,
        //         'title'      => "Showroom",
        //         'icon'       => 'nav-icon-7 fas fa-store',
        //         'permission' => null,
        //         'children'   => [
        //             'zone' => [
        //                 "id"    => 15,
        //                 'url'   => 'zones',
        //                 'title' => "Zone",
        //                 'icon'  => null,
        //             ],
        //             'showroom' => [
        //                 "id"    => 16,
        //                 'url'   => 'show-rooms',
        //                 'title' => "Showroom",
        //                 'icon'  => null,
        //             ]
        //         ]
        //     ],
        //     'user' => [
        //         "id"         => 17,
        //         'url'        => 'user',
        //         'title'      => "Users",
        //         'icon'       => 'nav-icon-5 fas fa-user',
        //         'permission' => "",
        //         'children'   => []
        //     },
        //     'permission' => [
        //         "id"         => 18,
        //         'url'        => null,
        //         'title'      => "Permission",
        //         'icon'       => 'nav-icon-6 fas fa-key',
        //         'permission' => "",
        //         'children'   => [
        //             'role' => [
        //                 "id"    => 19,
        //                 'url'   => 'roles',
        //                 'title' => "User Role",
        //                 'icon'  => null,
        //             ],
        //             'menu' => [
        //                 "id"    => 20,
        //                 'url'   => 'menu-permission',
        //                 'title' => "Menu Permission",
        //                 'icon'  => null,
        //             ]
        //         ]
        //     ],
        // ];
    }

    public static function menus_permission()
    {
        $query = Menu::where('parent_id', 0)->orderBy('priority','ASC')->get()->toArray();
        $results = array();
        foreach ($query as $q){
            $q['children'] = Menu::where('parent_id', $q['id'])->get()->toArray();
            $results[] = $q;
        }
        return $results;

    }

    /**
     * Format date to MM-DD-YY format
     * @param string|null $date
     * @return string|null
     */
    public static function formatDateStandard($date)
    {
        if (empty($date) || $date === null) {
            return null;
        }

        try {
            return date('m-d-y', strtotime($date));
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Format datetime to MM-DD-YY format (only date part)
     * @param string|null $datetime
     * @return string|null
     */
    public static function formatDateTimeStandard($datetime)
    {
        if (empty($datetime) || $datetime === null) {
            return null;
        }

        try {
            return date('m-d-y', strtotime($datetime));
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Format datetime for filename with MM-DD-YY-H-i-s format
     * @param string|null $datetime
     * @return string
     */
    public static function formatDateTimeFilename($datetime = null)
    {
        if (empty($datetime) || $datetime === null) {
            $datetime = now();
        }

        try {
            return date('m-d-y-H-i-s', strtotime($datetime));
        } catch (\Exception $e) {
            return date('m-d-y-H-i-s');
        }
    }

}
