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

    public static function normalizeZero($value, $threshold = 0.09)
    {
        return ($value < $threshold) ? 0.00 : round($value, 2);
    }

    public static function formatNumber($value): string
    {
        if (empty($value) || $value == 0) {
            return '0.00';
        }

        return number_format((float)$value, 2, '.', '');
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

    public static function en_to_bn_number($number)
    {
        $en = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        $bn = ['০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯'];
        return str_replace($en, $bn, (string) $number);
    }

    // public static function numberToBengaliWords($number, $show_taka = true)
    // {
    //     if ($number <= 0) {
    //         return $show_taka ? 'শূন্য টাকা' : 'শূন্য';
    //     }

    //     $whole = floor($number);
    //     $fraction = round(($number - $whole) * 100);

    //     // ✅ Corrected Bengali words
    //     $ones = [
    //         '',
    //         'এক',
    //         'দুই',
    //         'তিন',
    //         'চার',
    //         'পাঁচ',
    //         'ছয়',
    //         'সাত',
    //         'আট',
    //         'নয়',
    //         'দশ',
    //         'এগারো',
    //         'বারো',
    //         'তেরো',
    //         'চৌদ্দ',
    //         'পনেরো',
    //         'ষোল',
    //         'সতেরো',
    //         'আঠারো',
    //         'ঊনিশ'
    //     ];

    //     $tens = [
    //         '',
    //         '',
    //         'বিশ',
    //         'ত্রিশ',
    //         'চল্লিশ',
    //         'পঞ্চাশ',
    //         'ষাট',
    //         'সত্তর',
    //         'আশি',
    //         'নব্বই' // ✅ "আশি" (not "আিশ")
    //     ];

    //     // Helper for numbers < 1000
    //     $convertBelowThousand = function ($n) use ($ones, $tens) {
    //         $str = '';

    //         if ($n >= 100) {
    //             $str .= $ones[intval($n / 100)] . ' শত ';
    //             $n %= 100;
    //         }

    //         if ($n > 0) {
    //             if ($n < 20) {
    //                 $str .= $ones[$n];
    //             } else {
    //                 $tenPart = $tens[intval($n / 10)];
    //                 $onePart = $ones[$n % 10];
    //                 if ($onePart) {
    //                     $str .= $tenPart . ' ' . $onePart;
    //                 } else {
    //                     $str .= $tenPart;
    //                 }
    //             }
    //         }

    //         return trim($str);
    //     };

    //     // Break into crore, lakh, thousand, rest
    //     $crore = intval($whole / 10000000);
    //     $lakh = intval(($whole % 10000000) / 100000);
    //     $thousand = intval(($whole % 100000) / 1000);
    //     $rest = $whole % 1000;

    //     $result = '';

    //     if ($crore > 0) {
    //         $result .= $convertBelowThousand($crore) . ' কোটি ';
    //     }
    //     if ($lakh > 0) {
    //         $result .= $convertBelowThousand($lakh) . ' লক্ষ ';
    //     }
    //     if ($thousand > 0) {
    //         $result .= $convertBelowThousand($thousand) . ' হাজার ';
    //     }
    //     if ($rest > 0) {
    //         $result .= $convertBelowThousand($rest);
    //     }

    //     $result = trim($result);

    //     // Handle output with/without paisa
    //     if ($fraction > 0) {
    //         if ($result) {
    //             $result .= ' টাকা ';
    //         }
    //         $result .= $convertBelowThousand($fraction) . ' পয়সা';
    //     } else {
    //         if ($show_taka && $result) {
    //             $result .= ' টাকা';
    //         }
    //     }

    //     return $result ?: ($show_taka ? 'শূন্য টাকা' : 'শূন্য');
    // }

    public static function numberToBengaliWords($number, $show_taka = true)
    {
        if ($number <= 0) {
            return $show_taka ? 'শূন্য টাকা' : 'শূন্য';
        }

        $whole = floor($number);
        $fraction = round(($number - $whole) * 100);

        // ✅ ১–৯৯ পর্যন্ত সম্পূর্ণ বাংলা নাম
        $numbers = [
            0 => 'শূন্য',
            1 => 'এক',
            2 => 'দুই',
            3 => 'তিন',
            4 => 'চার',
            5 => 'পাঁচ',
            6 => 'ছয়',
            7 => 'সাত',
            8 => 'আট',
            9 => 'নয়',
            10 => 'দশ',
            11 => 'এগারো',
            12 => 'বারো',
            13 => 'তেরো',
            14 => 'চৌদ্দ',
            15 => 'পনেরো',
            16 => 'ষোল',
            17 => 'সতেরো',
            18 => 'আঠারো',
            19 => 'ঊনিশ',
            20 => 'বিশ',
            21 => 'একুশ',
            22 => 'বাইশ',
            23 => 'তেইশ',
            24 => 'চব্বিশ',
            25 => 'পঁচিশ',
            26 => 'ছাব্বিশ',
            27 => 'সাতাশ',
            28 => 'আটাশ',
            29 => 'ঊনত্রিশ',
            30 => 'ত্রিশ',
            31 => 'একত্রিশ',
            32 => 'বত্রিশ',
            33 => 'তেত্রিশ',
            34 => 'চৌত্রিশ',
            35 => 'পঁইত্রিশ',
            36 => 'ছত্রিশ',
            37 => 'সাঁইত্রিশ',
            38 => 'আটত্রিশ',
            39 => 'ঊনচল্লিশ',
            40 => 'চল্লিশ',
            41 => 'একচল্লিশ',
            42 => 'বিয়াল্লিশ',
            43 => 'তেতাল্লিশ',
            44 => 'চুয়াল্লিশ',
            45 => 'পঁইচাল্লিশ',
            46 => 'ছেচল্লিশ',
            47 => 'সাতচল্লিশ',
            48 => 'আটচল্লিশ',
            49 => 'ঊনপঞ্চাশ',
            50 => 'পঞ্চাশ',
            51 => 'একান্ন',
            52 => 'বাহান্ন',
            53 => 'তিপ্পান্ন',
            54 => 'চুয়ান্ন',
            55 => 'পঞ্চান্ন',
            56 => 'ছাপ্পান্ন',
            57 => 'সাতান্ন',
            58 => 'আটান্ন',
            59 => 'ঊনষাট',
            60 => 'ষাট',
            61 => 'একষট্টি',
            62 => 'বাষট্টি',
            63 => 'তেষট্টি',
            64 => 'চৌষট্টি',
            65 => 'পঁইষট্টি',
            66 => 'ছেষট্টি',
            67 => 'সাতষট্টি',
            68 => 'আটষট্টি',
            69 => 'ঊনসত্তর',
            70 => 'সত্তর',
            71 => 'একাত্তর',
            72 => 'বাহাত্তর',
            73 => 'তিয়াত্তর',
            74 => 'চুয়াত্তর',
            75 => 'পঁচাত্তর',
            76 => 'ছিয়াত্তর',
            77 => 'সাতাত্তর',
            78 => 'আটাত্তর',
            79 => 'ঊনআশি',
            80 => 'আশি',
            81 => 'একাশি',
            82 => 'বিরাশি',
            83 => 'তিরাশি',
            84 => 'চুরাশি',
            85 => 'পঁইরাশি',
            86 => 'ছিয়াশি',
            87 => 'সাতাশি',
            88 => 'আটাশি',
            89 => 'ঊননব্বই',
            90 => 'নব্বই',
            91 => 'একানব্বই',
            92 => 'বিরানব্বই',
            93 => 'তিরানব্বই',
            94 => 'চুরানব্বই',
            95 => 'পঁইচানব্বই',
            96 => 'ছিয়ানব্বই',
            97 => 'সাতানব্বই',
            98 => 'আটানব্বই',
            99 => 'নিরানব্বই'
        ];

        // Helper for numbers < 1000
        $convertBelowThousand = function ($n) use ($numbers) {
            $str = '';

            if ($n >= 100) {
                $str .= $numbers[intval($n / 100)] . ' শত ';
                $n %= 100;
            }

            if ($n > 0) {
                $str .= $numbers[$n];
            }

            return trim($str);
        };

        // Break into crore, lakh, thousand, rest
        $crore = intval($whole / 10000000);
        $lakh = intval(($whole % 10000000) / 100000);
        $thousand = intval(($whole % 100000) / 1000);
        $rest = $whole % 1000;

        $result = '';

        if ($crore > 0) {
            $result .= $convertBelowThousand($crore) . ' কোটি ';
        }
        if ($lakh > 0) {
            $result .= $convertBelowThousand($lakh) . ' লক্ষ ';
        }
        if ($thousand > 0) {
            $result .= $convertBelowThousand($thousand) . ' হাজার ';
        }
        if ($rest > 0) {
            $result .= $convertBelowThousand($rest);
        }

        $result = trim($result);

        // Handle output with/without paisa
        if ($fraction > 0) {
            if ($result) {
                $result .= ' টাকা ';
            }
            $result .= $convertBelowThousand($fraction) . ' পয়সা';
        } else {
            if ($show_taka && $result) {
                $result .= ' টাকা';
            }
        }

        return $result ?: ($show_taka ? 'শূন্য টাকা' : 'শূন্য');
    }

}
