<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>First Reminder</title>

    <style>
        body {
            font-family: 'solianmolipinormal', sans-serif;
            font-size: 14px;
            margin: 0;
            padding: 0;
        }

        .formBody {
            width: 795px;
            margin: 0 auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th,
        table td {
            font-family: 'solianmolipinormal', sans-serif;
            font-size: 15px;
            padding: 2px !important;
        }

        p {
            line-height: 23px;
            font-size: 15px;
            margin: 0;
        }

        h2 {
            font-weight: bold;
            font-size: 24px;
            margin: 0 0 3px 0;
        }

        @page {
            margin-top: 40px;
            margin-bottom: 50px;

            @bottom-right {
                content: "পৃষ্ঠা - " counter(page) "/" counter(pages);
                font-family: 'solianmolipinormal', sans-serif;
                font-size: 12px;
                font-weight: normal;
            }
        }

        @media print {
            body {
                font-size: 14px !important;
            }

            p {
                line-height: 22px;
                margin-top: 2px;
                margin-bottom: 3px !important;
            }

            table th,
            table td {
                font-size: 14px;
            }

            html, body {
                margin: 0;
                padding: 0;
            }
            .heading{
                border-radius: 16px !important;
            }
        }
    </style>
</head>

<body>
    <div class="formBody">
        <table cellspacing="0">
            <tr>
                <td style="width: 70%;">
                    <h2>র‍্যাংগস ইলেকট্রনিক্স লিমিটেড</h2>
                    <p style="font-size: 12.5px; line-height: 14px; margin-bottom: 2px; font-weight: bold;">
                        সোনারতরী টাওয়ার, ১২ সোনারগাঁও রোড, ঢাকা-১০০০, বাংলাদেশ।
                    </p>
                    <p style="font-size: 12.5px; line-height: 14px; font-weight: bold;">
                        হটলাইন : +৮৮ ০৯৬৭৭ ২৪৪ ২৪৪, ই-মেইল : marketing@rangs.com.bd
                    </p>
                </td>
                <td style="text-align: right; width: 30%;">
                    <img src="./assets/img/sony_rangs.png" alt="Logo" width="200">
                </td>
            </tr>
        </table>

        <table style="margin-bottom: 30px;" cellspacing="0">
            <tr>
                <td style="width: 36%;">
                    <table style="width:100%; font-size:14px; text-align:left; border: 1px solid #000;">
                        <tr>
                            <td colspan="2" style="background:#e30613; color:#fff; font-weight:bold; text-align:center; padding:3px; font-size:14px;">
                                Product Purchase Information
                            </td>
                        </tr>
                        <tr>
                            <td style="border:1px solid #000; padding:3px; background: #F2F2F2; font-weight:bold; font-size:12px;">
                                Date
                            </td>
                            <td style="border:1px solid #000; padding:3px; font-size:12px;">
                                {{ Carbon\Carbon::parse($penalty->installment->hire_purchase->created_at)->format('d M Y') }}
                            </td>
                        </tr>
                        {{-- <tr>
                            <td style="border:1px solid #000; padding:3px; background: #F2F2F2; font-weight:bold; font-size:12px;">
                                Reference No
                            </td>
                            <td style="border:1px solid #000; padding:3px; font-size:12px;">
                                {{ $penalty->order_no }}
                            </td>
                        </tr> --}}
                        <tr>
                            <td style="border:1px solid #000; padding:3px; background: #F2F2F2; font-weight:bold; font-size:12px;">
                                BNPL Order No.
                            </td>
                            <td style="border:1px solid #000; padding:3px; font-size:12px;">
                                {{ $penalty->order_no }}
                            </td>
                        </tr>
                        <tr>
                            <td style="border:1px solid #000; padding:3px; background: #F2F2F2; font-weight:bold; font-size:12px;">
                                Product Model
                            </td>
                            <td style="border:1px solid #000; padding:3px; font-size:12px;">
                                {{ $penalty->installment->hire_purchase->purchase_products->pluck('product.product_model')->implode(', ') }}
                            </td>
                        </tr>
                        <tr>
                            <td style="border:1px solid #000; padding:3px; background: #F2F2F2; font-weight:bold; font-size:12px;">
                                Category
                            </td>
                            <td style="border:1px solid #000; padding:3px; font-size:12px;">
                                 {{ $penalty->installment->hire_purchase->purchase_products->pluck('product_category.name')->implode(', ') }}
                            </td>
                        </tr>
                        <tr>
                            <td style="border:1px solid #000; padding:3px; background: #F2F2F2; font-weight:bold; font-size:12px;">
                                Hire Price
                            </td>
                            <td style="border:1px solid #000; padding:3px; font-size:12px;">
                             {{ $penalty->installment->hire_purchase->hire_price }}
                            </td>
                        </tr>
                        {{-- <tr>
                            <td style="border:1px solid #000; padding:3px; background: #F2F2F2; font-weight:bold; font-size:12px;">
                                1st Installment
                            </td>
                            <td style="border:1px solid #000; padding:3px; font-size:12px;">
                                10231.50
                            </td>
                        </tr> --}}
                        <tr>
                            <td style="border:1px solid #000; padding:3px; background: #F2F2F2; font-weight:bold; font-size:12px;">
                                Monthly Installment
                            </td>
                            <td style="border:1px solid #000; padding:3px; font-size:12px;">
                                {{ $penalty->installment->hire_purchase->monthly_installment }}
                            </td>
                        </tr>
                        <tr>
                            <td style="border:1px solid #000; padding:3px; background: #F2F2F2; font-weight:bold; font-size:12px;">
                                Total Installment
                            </td>
                            <td style="border:1px solid #000; padding:3px; font-size:12px;">
                                {{ $penalty->installment->hire_purchase->installment_month }}
                            </td>
                        </tr>
                    </table>
                </td>
                <td style="text-align: center; vertical-align: middle; width: 38%; padding: 10px;">
                    <table style="background-color: #ec2026; display: inline-block; border-collapse: separate; border-spacing: 0;">
                        <tr>
                            <td style="background-color: #ec2026;
                                    color: white;
                                    padding: 8px 25px;
                                    font-weight: 600;
                                    font-size: 18px;
                                    text-align: center;
                                    border: 2px solid #ec2026;">
                                বকেয়া কিস্তি পরিশোধের<br>প্রথম রিমাইন্ডার
                            </td>
                        </tr>
                    </table>
                </td>
                <td style="width: 26%;">
                    <table style="width:100%;" cellspacing="0">
                        <tr>
                            <td style="font-size:12px; border:1.5px solid #000; height:200px; text-align:center; vertical-align:middle; padding:15px;">
                                ক্রেতার<br>ছবি
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <!-- SUBJECT -->
        <table style="margin-top:15px;">
            <tr>
                <td style="text-align:left; font-weight:bold; font-size: 15px;">
                    বিষয়: আপনার বকেয়া কিস্তি পরিশোধের অনুরোধ - প্রথম রিমাইন্ডার
                </td>
            </tr>
        </table>

        <!-- LETTER BODY -->
        <p style="margin-top:18px;">জনাব/জনাবা,</p>

        <p style="margin-bottom: 15px;">
            আপনার অবগতির জন্য জানানো যাচ্ছে যে, আপনি র‍্যাংগস ইলেকট্রনিক্স থেকে
            উপরে উল্লিখিত তথ্যমতে একটি <strong> {{ $penalty->installment->hire_purchase->purchase_products->pluck('product_category.name')->implode(', ') }}</strong>,
            মডেল <strong>{{ $penalty->installment->hire_purchase->purchase_products->pluck('product.product_model')->implode(', ') }}</strong>, সিরিয়াল নম্বর <strong>{{ $penalty->installment->hire_purchase->purchase_products->pluck('serial_no')->implode(', ') }}</strong>,
            সর্বমোট কিস্তি মূল্য <strong>{{\App\Helpers\Helper::en_to_bn_number(number_format($penalty->installment->hire_purchase->hire_price, 2, '.', ',')) }}</strong>
            ({{ \App\Helpers\Helper::numberToBengaliWords($penalty->installment->hire_purchase->hire_price) }}) {{ \App\Helpers\Helper::en_to_bn_number($penalty->installment->hire_purchase->installment_month) }} টি কিস্তিতে ক্রয় করেছেন।
        </p>

        <p style="margin-bottom: 15px;">
            কোম্পানির সাথে সম্পাদিত সহজ কিস্তির চুক্তিনামা অনুযায়ী,
            কিস্তি বকেয়া <strong>{{\App\Helpers\Helper::en_to_bn_number(number_format($penalty->installment_amount, 2, '.', ',')) }} টাকা
            ({{ \App\Helpers\Helper::numberToBengaliWords($penalty->installment_amount) }})</strong> বকেয়া রয়েছে।
            কোম্পানি বিশ্বাস করে এই বকেয়া কিস্তি আপনার ইচ্ছাকৃত সৃষ্ট নয়।
        </p>

        <p>
            এমতাবস্থায়, কোম্পানি আশা করে যে অতি দ্রুততম সময়ে
            আপনার বকেয়া কিস্তি এবং চলতি মাসের কিস্তির টাকা পরিশোধ করে
            ব্যক্তিগত সুনাম অক্ষুণ্ণ রাখবেন।
        </p>

        <p style="margin-top:15px;">
            <span style="font-weight: bold;">ধন্যবাদান্তে,</span><br>
            র‍্যাংগস ইলেকট্রনিক্স লিমিটেড
        </p>

        <!-- CC -->
        <p style="margin-top:20px; font-weight: bold;">অনুলিপি:</p>
        <p style="margin-bottom: 7px;">১. শোরুমের নাম</p>
        <p style="margin-bottom: 7px; margin-top: 0;">২. জোনাল ম্যানেজার</p>
        <p style="margin-bottom: 7px; margin-top: 0;">৩. ইস্ট / ওয়েস্ট / নর্থ / সাউথ</p>
        <p style="margin-top: 0;">৪. অন্যান্য সংশ্লিষ্ট বিভাগ</p>

        <!-- ATTACHMENT -->
        <p style="margin-top:18px;"><span style="font-weight: bold;">সংযুক্তি :</span> কিস্তির তালিকা</p>

        <!-- FOOT NOTE -->
        <p style="margin-top:15px; font-size:14px;">
            <span style="font-weight: bold;">বি:দ্র:</span> এই পত্রটি কম্পিউটারাইজড বলে স্বাক্ষরের প্রয়োজন নেই।
            এই চিঠিটি পাওয়ার পূর্বে বকেয়া টাকা পরিশোধিত হলে এই চিঠিটি আমলে নেওয়ার প্রয়োজন নেই।
            যেকোন তথ্যের জন্য আপনাকে কোম্পানির মনোনীত প্রতিনিধির নিকট অথবা কোম্পানির নির্ধারিত কার্যালয়ে যোগাযোগ করার জন্য অনুরোধ করা যাচ্ছে।
        </p>

        <!-- SIGNATURE -->
        <table style="margin-top:45px;">
            <tr>
                <td style="width: 70%;"></td>
                <td style="text-align: center; padding-top:5px; border-top:1.5px dashed #000; vertical-align:bottom; padding-bottom: 45px;">
                    প্রদানকারীর স্বাক্ষর
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
