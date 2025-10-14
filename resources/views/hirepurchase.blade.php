<style type="text/css" media="print">
    @page {
        size: auto;
        margin-top: 50px;
        margin-bottom: 50px;
        padding: 1px;
    }
</style>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Jost:wght@400;500;600;700&display=swap');
   @font-face {
    font-family: 'SutonnyMJ';
    src: url('/assets/fonts/SutonnyMJ Regular.ttf') format('truetype');
    src: url('/assets/fonts/SutonnyMJ-Bold.ttf') format('truetype');
    /* font-weight: normal; */
    font-style: normal;
    }
    .formBody {
        padding: 20px;
    }
    body {
        font-family: 'SutonnyMJ', sans-serif;
        font-size: 12px;
        padding: 1px;
        margin: 0px;
    }

    table th,
    table td {
        font-family: 'SutonnyMJ', sans-serif;
        font-size: 12px;
        border-collapse: collapse;
        padding: 2px !important;
    }

    p {
        line-height: 20px;
        font-size: 12px;
        font-family: 'SutonnyMJ', sans-serif;
    }

    @media print {
        @import url('https://fonts.googleapis.com/css2?family=Jost:wght@400;500;600;700&display=swap');
        @font-face {
            font-family: 'SutonnyMJ';
            src: url('/assets/fonts/SutonnyMJ Regular.ttf') format('truetype');
            src: url('/assets/fonts/SutonnyMJ-Bold.ttf') format('truetype');
            /* font-weight: normal; */
            font-style: normal;
        }
        .formBody {
            /* padding: 20px; */
        }

        body {
            font-family: 'SutonnyMJ', sans-serif;
            font-size: 12px !important;
            padding: 0.5px;
            margin: 0px;
        }

        table th,
        table td {
            font-family: 'SutonnyMJ', sans-serif;
            font-size: 12px;
            border-collapse: collapse;
            padding: 2px !important;
        }

        p {
            line-height: 18px;
            margin-top: 2px;
            margin-bottom: 3px !important;
            font-size: 12px;
            font-family: 'SutonnyMJ', sans-serif;
        }

        body {
            -webkit-print-color-adjust: exact;
            /*chrome & webkit browsers*/
            color-adjust: exact;
            /*firefox & IE */
            font-family: 'SutonnyMJ', sans-serif;
        }

        html,
        body {
            margin: 0;
            padding: 0;
        }

        img {
            -webkit-print-color-adjust: exact;
        }
    }
</style>

<div class="formBody" style="width: 795px;margin:0 auto;">
    <table style="width:100%;" cellspacing="0">
        <tbody>
            <tr>
                <table style="width:100%;margin-bottom:3px" cellspacing="0">
                    <tr>
                        <td>
                            <h2 style="font-weight: 700; font-size: 24px; color: #000;margin-top:0; margin-bottom: 3px;">
                                র‍্যাংগ্স ইলেকট্রনিক্স লিমিটেড
                            </h2> 
                            <p style="font-size: 12.5px; line-height: 14px; margin: 0;margin-bottom: 2px;font-weight:500;">
                                সোনারতরী টাওয়ার, ১২ সোনারগাঁও রোড, ঢাকা-১০০০, বাংলাদেশ।
                            </p>
                            <p style="font-size: 12.5px; line-height: 14px; margin: 0;font-weight:500;">
                                হটলাইন : +৮৮ ০৯৬৭৭ ২৪৪ ২৪৪, ই-মেইল : <span style="font-family: 'Jost', sans-serif;">marketing@rangs.com.bd</span>
                            </p>
                        </td>
                        <td style="text-align: right;">
                            <img src="{{ asset('assets/img/sony_rangs.png') }}" alt="Logo" width="200">
                        </td>
                    </tr>
                </table>
            </tr>
            <tr>
                <table style="width:100%;margin-bottom:3px;" cellspacing="0">
                    <tr>
                        <td style="width: 30%;">
                            <table style="width:100%;font-size:14px; text-align:left;">
                            <tr>
                                <td colspan="2" style="background:#e30613; color:#fff; font-weight:600; text-align:center; padding:3px !important; font-size:14px !important;font-family: 'Jost', sans-serif;">
                                OFFICE USE ONLY
                                </td>
                            </tr>

                            <tr>
                                <td style="border:1px solid #000; padding:6px; background: #e6e7e9; font-weight:500;font-family: 'Jost', sans-serif;font-size:12px;padding:1px !important;">BNPL Order No.</td>
                                <td style="border:1px solid #000; padding:6px; background: #e6e7e9;font-family: 'Jost', sans-serif;font-size:12px;padding: 1px !important;">{{ @$hirePurchase->order_no }}</td>
                            </tr>

                            <tr>
                                <td style="border:1px solid #000; padding:6px; background: #e6e7e9; font-weight:500;font-family: 'Jost', sans-serif;font-size:12px;padding: 1px !important;">Product Model</td>
                                <td style="border:1px solid #000; padding:6px; background: #e6e7e9;font-family: 'Jost', sans-serif;font-size:12px;padding: 1px !important;">{{ @$hirePurchase->purchase_product->product->product_model }}</td>
                            </tr>

                            <tr>
                                <td style="border:1px solid #000; padding:6px; background: #e6e7e9; font-weight:500;font-family: 'Jost', sans-serif;font-size:12px;padding: 1px !important;">Category</td>
                                <td style="border:1px solid #000; padding:6px; background: #e6e7e9;font-family: 'Jost', sans-serif;font-size:12px;padding: 1px !important;">{{ @$hirePurchase->purchase_product->product_category->name }}</td>
                            </tr>

                            <tr>
                                <td style="border:1px solid #000; padding:6px; background: #e6e7e9; font-weight:500;font-family: 'Jost', sans-serif;font-size:12px;padding: 1px !important;">Hire Price</td>
                                <td style="border:1px solid #000; padding:6px; background: #e6e7e9;font-family: 'Jost', sans-serif;font-size:12px;padding: 1px !important;">{{ @$hirePurchase->purchase_product->hire_price }}</td>
                            </tr>

                            <tr>
                                <td style="border:1px solid #000; padding:6px; background: #e6e7e9; font-weight:500;font-family: 'Jost', sans-serif;font-size:12px;padding: 1px !important;">1st Installment</td>
                                <td style="border:1px solid #000; padding:6px; background: #e6e7e9;font-family: 'Jost', sans-serif;font-size:12px;padding: 1px !important;">{{ @$hirePurchase->purchase_product->down_payment }}</td>
                            </tr>

                            <tr>
                                <td style="border:1px solid #000; padding:6px; background: #e6e7e9; font-weight:500;font-family: 'Jost', sans-serif;font-size:12px;padding: 1px !important;">Monthly Installment</td>
                                <td style="border:1px solid #000; padding:6px; background: #e6e7e9;font-family: 'Jost', sans-serif;font-size:12px;padding: 1px !important;">{{ @$hirePurchase->purchase_product->monthly_installment }}</td>
                            </tr>

                            <tr>
                                <td style="border:1px solid #000; padding:6px; background: #e6e7e9; font-weight:500;font-family: 'Jost', sans-serif;font-size:12px;padding: 1px !important;">Total Installment</td>
                                <td style="border:1px solid #000; padding:6px; background: #e6e7e9;font-family: 'Jost', sans-serif;font-size:12px;padding: 1px !important;">
                                {{ @$hirePurchase->purchase_product->installment_month }}
                                </td>
                            </tr>
                            </table>
                        </td>
                        <td style="text-align:center;vertical-align:middle;">
                            <!-- Center Badge -->
                            <div style="background-color: #ec2026; color: white; padding: 5px 22px; border-radius: 16px; display: inline-block; font-weight: 600; font-size: 18px; text-align: center;">
                                সহজ কিস্তির চুক্তিনামা
                            </div>
                            <div style="font-size: 12px; margin-top: 5px; font-style: italic;">
                                (প্রদেয় তথ্যের গোপনীয়তা রক্ষা করা হবে)
                            </div>
                            <div style="font-size: 12px; margin-top: 2px;">
                                বাংলা অথবা ইংরেজিতে সম্পূর্ণ আবেদন পত্রটি পূরণ যোগ্য
                            </div>
                        </td>
                        <td
                            style="font-size:12px !important;border:1.5px solid #000;vertical-align:middle;width:155px;height:120px;text-align:center;padding:15px !important;">
                            আবেদনকারীর ২ কপি পাসপোর্ট সাইজের ছবি
                        </td>
                    </tr>
                </table>
            </tr>
            <tr>
                <table style="width:100%;" cellspacing="0">
                    <tr>
                        <td style="padding-top:10px;">
                            <table style="width:100%;" cellspacing="0">
                                <tr>
                                    <td style="width:29%;font-weight:600;">১)আবেদনকারীর পূর্ণ নাম(ডাকনাম সহ):</td>
                                    <td style="border: 1px solid #000;background: #e6e7e9;padding-left:3px !important;font-family: 'Jost', sans-serif;">{{ $hirePurchase->name }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-top: 7px;">
                            <table style="width:100%;" cellspacing="0">
                                <tr>
                                    <td style="width: 27%;font-weight:600;">২)
                                        <input type="checkbox" checked name="relation" id="father"> <label
                                            for="father">পিতা/</label>
                                        <input type="checkbox" name="relation" id="husband"> <label
                                            for="husband">স্বামী/</label>
                                        <input type="checkbox" name="relation" id="wife"> <label
                                            for="wife">স্ত্রীর/</label>নাম:
                                    </td>
                                    <td style="border: 1px solid #000;background: #e6e7e9;padding-left:3px !important;font-family: 'Jost', sans-serif;">{{ $hirePurchase->fathers_name }}</td>
                                    <td style="width: 17%;font-weight:600;padding-left:5px !important;">৩)ন্যাশনাল আইডি নং:</td>
                                    <td style="border: 1px solid #000;background: #e6e7e9;padding-left:3px !important;font-family: 'Jost', sans-serif;">
                                        {{ $hirePurchase->nid }}
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-top: 7px;">
                            <table style="width:100%;" cellspacing="0">
                                <tr>
                                    <td style="width:28%;">
                                        <strong style="font-weight:600;">৪)বর্তমান বাসস্থানের ঠিকানা:</strong> বাড়ি/গ্রাম:
                                    </td>
                                    <td style="border: 1px solid #000;background: #e6e7e9;padding-left:3px !important;font-family: 'Jost', sans-serif;">
                                        {{ $hirePurchase->pr_house_no }}
                                    </td>
                                    <td style="width: 7%;padding-left:5px !important;">ডাকঘর:</td>
                                    <td style="border: 1px solid #000;background: #e6e7e9;padding-left:3px !important;font-family: 'Jost', sans-serif;">{{ $hirePurchase->pr_road_no }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-top: 7px;">
                            <table style="width:100%;" cellspacing="0">
                                <tr>
                                    <td style="width:11%;">
                                        থানা ও জেলা:
                                    </td>
                                    <td style="border: 1px solid #000;background: #e6e7e9;padding-left:3px !important;font-family: 'Jost', sans-serif;">
                                        {{ @$hirePurchase->upazilapr->name }} ,
                                        {{ @$hirePurchase->districtpr->en_name }},
                                    </td>
                                    <td style="width: 9%;">মোবাইল নং:</td>
                                    <td style="border: 1px solid #000;background: #e6e7e9;padding-left:3px !important;font-family: 'Jost', sans-serif;">
                                        {{ $hirePurchase->pr_phone }}
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-top: 7px;">
                            <table style="width:100%;" cellspacing="0">
                                <tr>
                                    <td style="width: 22%; font-weight:600;">৫)এই বাসস্থান 
                                        <span style="font-family: 'Jost', sans-serif;">{{ $hirePurchase->pr_residence_status }}</span> এবং
                                        আমি</td>
                                    <td style="border: 1px solid #000;background: #e6e7e9;padding-left:3px !important;font-family: 'Jost', sans-serif;;width: 10%;">
                                        {{ $hirePurchase->pr_duration_staying }}</td>
                                        <td style="padding-left: 5px !important;width: 4%;">বছর</td>
                                    <td style="border: 1px solid #000;background: #e6e7e9;padding-left:3px !important;font-family: 'Jost', sans-serif;;width: 10%;">
                                    </td>
                                    <td style="font-weight:600;padding-left:5px !important;">মাস ধরে এই ঠিকানায় বসবাস করছি।</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-top: 7px;">
                            <table style="width:100%;" cellspacing="0">
                                <tr>
                                    <td style="width:19%;">
                                       <strong>৬)স্থায়ী ঠিকানা:</strong>বাড়ি/গ্রাম:
                                    </td>
                                    <td style="border: 1px solid #000;background: #e6e7e9;padding-left:3px !important;font-family: 'Jost', sans-serif;">
                                        {{ $hirePurchase->pa_house_no }}
                                    </td>
                                    <td style="width: 7%;padding-left: 5px !important;">ডাকঘর:</td>
                                    <td style="border: 1px solid #000;background: #e6e7e9;padding-left:3px !important;font-family: 'Jost', sans-serif;">{{ $hirePurchase->pa_road_no }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-top: 7px;">
                            <table style="width:100%;" cellspacing="0">
                                <tr>
                                    <td style="width:11%;">
                                        থানা ও জেলা:
                                    </td>
                                    <td style="border: 1px solid #000;background: #e6e7e9;padding-left:3px !important;font-family: 'Jost', sans-serif;;width:46%">
                                        {{ @$hirePurchase->districtpa->en_name }} ,
                                        {{ @$hirePurchase->upazilapa->name }},
                                    </td>
                                    <td style="width: 10%;padding-left: 5px ! IMPORTANT">মোবাইল নং:</td>
                                    <td style="border: 1px solid #000;background: #e6e7e9;padding-left:3px !important;font-family: 'Jost', sans-serif;">
                                        {{ $hirePurchase->pa_phone }}
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-top: 7px;">
                            <table style="width:100%;" cellspacing="0">
                                <tr>
                                    <td style="width:7%;font-weight:600;">
                                        ৭)পেশা:
                                    </td>
                                    <td style="border: 1px solid #000;background: #e6e7e9;padding-left:3px !important;font-family: 'Jost', sans-serif;;width:20%;">
                                        {{ $hirePurchase->customer_profession->name }}
                                    </td>
                                    <td style="width: 6%;font-weight:600;padding-left: 5px !important;">পদবী:</td>
                                    <td style="border: 1px solid #000;background: #e6e7e9;padding-left:3px !important;font-family: 'Jost', sans-serif;">{{ $hirePurchase->designation }}</td>
                                    <td style="width: 26%;padding-left:5px !important">কতদিন ধরে বর্তমান পেশার সাথে যুক্ত:</td>
                                    <td style="border: 1px solid #000;background: #e6e7e9;padding-left:3px !important;font-family: 'Jost', sans-serif;;width: 5%;">
                                        {{ $hirePurchase->duration_current_profe }}</td>
                                    <td style="padding-left: 5px !IMPORTANT;width: 4%;">বছর</td>
                                    <td style="border: 1px solid #000;background: #e6e7e9;padding-left:3px !important;font-family: 'Jost', sans-serif;;width: 5%;">
                                    </td>
                                    <td style="padding-left: 5px !IMPORTANT;">মাস</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-top: 7px;">
                            <table style="width:100%;" cellspacing="0">
                                <tr>
                                    <td style="width:12%;font-weight:600;">
                                        প্রতিষ্ঠানের নাম:
                                    </td>
                                    <td style="border: 1px solid #000;background: #e6e7e9;padding-left:3px !important;font-family: 'Jost', sans-serif;">
                                        {{ $hirePurchase->organization_name }}
                                    </td>
                                    <td style="width: 13%;padding-left: 5px !important;">কর্মস্থলের ঠিকানা:</td>
                                    <td style="border: 1px solid #000;background: #e6e7e9;padding-left:3px !important;font-family: 'Jost', sans-serif;">
                                        {{ $hirePurchase->organization_short_desc }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-top: 7px;">
                            <table style="width:100%;" cellspacing="0">
                                <tr>
                                    <td style="width:8%;">
                                        বাড়ি/গ্রাম:
                                    </td>
                                    <td style="border: 1px solid #000;background: #e6e7e9;padding-left:3px !important;font-family: 'Jost', sans-serif;">{{ $hirePurchase->org_house_no }}</td>
                                    <td style="width: 7%;padding-left: 5px !important;">ডাকঘর:</td>
                                    <td style="border: 1px solid #000;background: #e6e7e9;padding-left:3px !important;font-family: 'Jost', sans-serif;">
                                        {{ $hirePurchase->org_road_no }}
                                    </td>
                                    <td style="width: 10%;padding-left: 5px !important;">
                                        থানা ও জেলা:
                                    </td>
                                    <td style="border: 1px solid #000;background: #e6e7e9;padding-left:3px !important;font-family: 'Jost', sans-serif;">
                                        {{ @$hirePurchase->districtorg->en_name }} ,
                                        {{ @$hirePurchase->upazilaorg->name }}
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-top: 7px;">
                            <table style="width:100%;" cellspacing="0">
                                <tr>
                                    <td style="width: 9%;">মোবাইল নং:</td>
                                    <td style="border: 1px solid #000;background: #e6e7e9;padding-left:3px !important;font-family: 'Jost', sans-serif;">
                                        {{ $hirePurchase->org_phone }}
                                    </td>
                                    <td style="width: 14%;padding-left: 5px !important;">মাসিক আয়(টাকা):</td>
                                    <td style="border: 1px solid #000;background: #e6e7e9;padding-left:3px !important;font-family: 'Jost', sans-serif;">
                                        {{ $hirePurchase->month_income }}
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-top: 7px;">
                            <table style="width:100%;" cellspacing="0">
                                <tr>
                                    <td style="width:6%;font-weight:600;">
                                        ৮)বয়স:
                                    </td>
                                    <td style="border: 1px solid #000;background: #e6e7e9;padding-left:3px !important;font-family: 'Jost', sans-serif;;width: 10%;">{{ $hirePurchase->age }}</td>
                                    <td style="width: 4%;font-weight:600;padding-left:5px !important">বছর</td>
                                    <td style="width: 30px;"></td>
                                    <td style="font-weight:600;">৯)
                                        <input type="checkbox" @if( $hirePurchase->marital_status == "married") @checked(true) @endif  name="marital_status" id="married"> <label
                                            for="married">বিবাহিত/</label>
                                        <input type="checkbox"  @if( $hirePurchase->marital_status == "Unmarried") @checked(true) @endif name="marital_status" id="unmarried"> <label
                                            for="unmarried">অবিবাহিত</label>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-top: 7px;">
                            <table style="width:100%;" cellspacing="0">
                                <tr>
                                    <td style="width:16%;font-weight:600;">
                                        ১০)(ক) সন্তান সংখ্যা:
                                    </td>
                                    <td style="border: 1px solid #000;background: #e6e7e9;padding-left:3px !important;font-family: 'Jost', sans-serif;;width: 10%;">
                                        {{ $hirePurchase->number_of_children }}
                                    </td>
                                    <td style="width: 8%;font-weight:600;padding-left:5px !important;">জন,</td>
                                    <td style="width:15%;font-weight:600;">
                                        (খ) অন্যান্য পোষ্য:
                                    </td>
                                    <td style="border: 1px solid #000;background: #e6e7e9;padding-left:3px !important;font-family: 'Jost', sans-serif;;width: 10%;">
                                        {{ $hirePurchase->other_family_member }}</td>
                                    <td style="font-weight:600;padding-left:5px !important;">জন</td>
                                </tr>

                            </table>
                        </td>
                    </tr>
                    {{-- <tr>
                        <td style="padding-top: 7px;">(গ)স্ত্রী ও সন্তানদের নাম এবং বয়স:</td>
                    </tr> --}}
                    {{-- @if ($hirePurchase->name_age_family_member)
                        @php

                            $name_age = json_decode($hirePurchase->name_age_family_member);
                        @endphp

                        @foreach ($name_age as $row)
                            <tr>
                                <td style="padding-top: 7px;">
                                    <table style="width:100%;" cellspacing="0">
                                        <tr>
                                            <td style="width:5%;">
                                                (১)
                                                নাম:
                                            </td>
                                            <td style="border: 1px solid #000;background: #e6e7e9;padding-left:3px !important;font-family: 'Jost', sans-serif;;width: 40%;">{{ $row->name }}
                                            </td>
                                            <td>সম্পর্ক</td>
                                            <td style="border: 1px solid #000;background: #e6e7e9;padding-left:3px !important;font-family: 'Jost', sans-serif;;width: 30%;">
                                                {{ $row->relation }}</td>
                                            <td>বয়স</td>
                                            <td style="border: 1px solid #000;background: #e6e7e9;padding-left:3px !important;font-family: 'Jost', sans-serif;;width: 15%;">{{ $row->age }}
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        @endforeach
                    @endif --}}
                    <tr>
                        <td style="padding-top: 7px;">
                            <table style="width:100%;" cellspacing="0">
                                <tr>
                                    <td style="width:3%;">
                                        (গ)
                                    </td>
                                    <td style="border: 1px solid #000;background: #e6e7e9;padding-left:3px !important;font-family: 'Jost', sans-serif;;width: 5%;">
                                    </td>
                                    <td style="padding-left: 5px !important;width:3%;">স্ত্রী</td>
                                    <td style="border: 1px solid #000;background: #e6e7e9;padding-left:3px !important;font-family: 'Jost', sans-serif;;width: 4%;">
                                    </td>
                                    <td style="width: 10%;padding-left: 5px !important;">সন্তানের নামঃ</td>
                                    <td style="border: 1px solid #000;background: #e6e7e9;padding-left:3px !important;font-family: 'Jost', sans-serif;;">
                                    </td>
                                    <td style="width: 5%;padding-left: 5px !important;">বয়সঃ</td>
                                    <td style="border: 1px solid #000;background: #e6e7e9;padding-left:3px !important;font-family: 'Jost', sans-serif;;width: 5%;">
                                    </td>
                                    <td style="padding-left: 5px !IMPORTANT;width: 4%;">বছর</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-top: 7px;">
                            <table style="width:100%;" cellspacing="0">
                                <tr>
                                    <td style="width:27%;font-weight:600;">
                                        (১১)কোন পণ্য/মডেল কিনতে ইচ্ছুক:
                                    </td>
                                    <td style="border: 1px solid #000;background: #e6e7e9;padding-left:3px !important;font-family: 'Jost', sans-serif;;width: 40%;">
                                        {{ @$hirePurchase->purchase_product->product->product_model }}</td>
                                    <td style="width: 9%;font-weight:600;padding-left:5px !important">
                                        বিক্রয়মূল্য:
                                    </td>
                                    <td style="border: 1px solid #000;background: #e6e7e9;padding-left:3px !important;font-family: 'Jost', sans-serif;">
                                        {{ @$hirePurchase->purchase_product->hire_price }}
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-top: 4px; font-size:12px;font-weight:600;">(১২)পূর্বে র‌্যাংগস ইলেকট্রনিক্স লিমিটেডের কোন
                            পণ্য কিস্তিতে
                            কিনেছেন কি? @if($hirePurchase->previously_purchased == 1) হ্যাঁ @else না। @endif </td>
                    </tr>
                    @if($hirePurchase->previously_purchased == 1)
                    <tr>
                        <td style="padding-top: 7px;">
                            <table style="width:100%;" cellspacing="0">
                                <tr>
                                    <td style="width:29%;">
                                        যদি কিনে থাকেন তবে কি কিনেছেন?:
                                    </td>
                                    <td style="border: 1px solid #000;background: #e6e7e9;padding-left:3px !important;font-family: 'Jost', sans-serif;;width: 40%;">
                                        {{ $hirePurchase->pre_b_product_id == 'others' ? $hirePurchase->type_product : @$hirePurchase->pre_purchase_product->product_model }}
                                    </td>
                                    <td style="width: 11%;">
                                        ক্রয়ের তারিখ:
                                    </td>
                                    <td style="border: 1px solid #000;background: #e6e7e9;padding-left:3px !important;font-family: 'Jost', sans-serif;">{{ $hirePurchase->pre_purchase_date }}
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding-top: 7px;">
                            <table style="width:100%;" cellspacing="0">
                                <tr>
                                    <td style="width:24%;">
                                        কোন শোরুম থেকে কিনেছেন?:
                                    </td>
                                    <td style="border: 1px solid #000;background: #e6e7e9;padding-left:3px !important;font-family: 'Jost', sans-serif;">
                                        {{ @$hirePurchase->ppshow_room->name }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    @endif
                    <tr>
                        <td style="padding-top: 7px;">
                            <table style="width:100%;" cellspacing="0">
                                <tr>
                                    <td style="width:50%;font-weight:600;">
                                        ১৩) এখন যে সামগ্রী কিনতে চান তা কোন ঠিকানায় ব্যবহার করা হবে?:
                                    </td>
                                    <td style="border: 1px solid #000;background: #e6e7e9;padding-left:3px !important;font-family: 'Jost', sans-serif;">{{ $hirePurchase->shipping_address }}
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-top: 7px;">
                            <table style="width:100%;" cellspacing="0">
                                <tr>
                                    <td style="width:42%;font-weight:600;">
                                        ১৪) উল্লেখিত ঠিকানা হতে <span style="font-family: 'Jost', sans-serif;">Rangs</span> ইলেকট্রনিক্স লিমিটে এর:
                                    </td>
                                    <td style="border: 1px solid #000;background: #e6e7e9;padding-left:3px !important;font-family: 'Jost', sans-serif;;width: 29%;">
                                        {{ @$hirePurchase->show_room->name }}
                                    </td>
                                    <td style="width: 12%;padding-left: 5px !important;">
                                        শোরুমের দূরত্ব:
                                    </td>
                                    <td style="border: 1px solid #000;background: #e6e7e9;padding-left:3px !important;font-family: 'Jost', sans-serif;;width: 7%;">
                                        {{ $hirePurchase->distance_from_showroom }}</td>
                                    <td style="padding-left: 5px !important;">
                                        মাইল/কি.মি।
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-top: 7px;font-weight:600;">(১৫) আপনার আত্মীয়/পরিচিত এমন দুজন ব্যক্তি যারা আপনার গ্যারান্টার
                            অথবা
                            নিশ্চয়তা প্রদানকারী হবেন
                            এবং তারা আবেদনকারীর অবর্তমানে/অনাদায়ে বকেয়া পাওনা পরিশোধ করতে ইচ্ছুক তাদের নাম ও ঠিকানা:
                        </td>
                    </tr>
                    @foreach ($guarantor as $key => $guaran)
                        <tr>
                            <td style="padding-top: 7px;">
                                <table style="width:100%;" cellspacing="0">
                                    <tr>
                                        <td style="width:8%;">
                                            (@if ($key == 1)
                                                ২
                                            @else
                                                ১
                                            @endif)
                                            নাম:
                                        </td> 
                                        <td style="border: 1px solid #000;background: #e6e7e9;padding-left:3px !important;font-family: 'Jost', sans-serif;;width: 40%;">
                                            {{ $guaran->guarater_name }}</td>
                                        <td style="width: 13%;padding-left: 5px !important;">
                                            পিতা/স্বামীর নাম:
                                        </td>
                                        <td style="border: 1px solid #000;background: #e6e7e9;padding-left:3px !important;font-family: 'Jost', sans-serif;">
                                            {{ $guaran->guarater_relation_name }}</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding-top: 7px;">
                                <table style="width:100%;" cellspacing="0">
                                    <tr>
                                        <td style="width:6%;">
                                            ঠিকানা:
                                        </td>
                                        <td style="border: 1px solid #000;background: #e6e7e9;padding-left:3px !important;font-family: 'Jost', sans-serif;">
                                            {{ $guaran->guarater_address_present }}</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding-top: 7px;">
                                <table style="width:100%;" cellspacing="0">
                                    <tr>
                                        <td style="width:14%;">
                                            ন্যাশনাল আইডি নং:
                                        </td>
                                        <td style="border: 1px solid #000;background: #e6e7e9;padding-left:3px !important;font-family: 'Jost', sans-serif;;width: 32%;">
                                            {{ $guaran->guarater_nid }}</td>
                                        <td style="width: 12%;padding-left: 5px !important;">
                                            মোবাইল নাম্বার:
                                        </td>
                                        <td style="border: 1px solid #000;background: #e6e7e9;padding-left:3px !important;font-family: 'Jost', sans-serif;">
                                            {{ $guaran->guarater_phone }}
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td style="padding-top: 7px !important;font-size:13px !important;">
                            উল্লেখিত তথ্যসমূহ সঠিক ও সজ্ঞানে প্রদান করলাম।
                        </td>
                    </tr>
                    <!-- <tr>
                        <td>
                            <table style="width: 100%;" cellspacing="0">
                                <tr>
                                    <td style="padding-top: 7px;">
                                        <table style="width:100%;" cellspacing="0">
                                            <tr>
                                                <td>তারিখঃ</td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td style="padding-top: 10px;width: 42%; margin-top:50px">
                                        <table style="width:100%;" cellspacing="0">
                                            <tr>
                                                <td style="text-align: center;padding-top: 30px !important;margin-top:50px !important">আবেদনকারীর স্বাক্ষর</td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: center;padding-top: 7px;">আবেদনকারীর তথ্য যাচাই করে সঠিক প্রমাণিত
                                                    হলো</td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: center;padding-top: 7px;">শোরুম ইনচার্জ এর স্বাক্ষর</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr> -->
                </table>
            </tr>
        </tbody>
    </table>

    <!-- <p>#1 Customer Application form
        Before customer’s Signature:  -->
    <p style="margin-bottom: 0; margin-top:2px">
        আমি/আমরা (১) ও (২) নং অংশে উল্লেখিত ব্যক্তি/ব্যক্তি বর্গ এই আবেদন পত্রের ২য় ও ৩য় পৃষ্ঠায় বর্ণিত ও প্রদত্ত সকল তথ্য অবগত হইয়া স্বেচ্ছায় ও সজ্ঞানে অবহিত হইতে সম্মত হইলাম এবং সেই সাথে এই মর্মে অঙ্গীকার করিতেছি যে, আবেদনকারী কিস্তিতে যে পণ্যটি ক্রয়ের জন্য আবেদন করিয়াছেন, তাহার নিকট ঐ পণ্যটি কিস্তিতে বিক্রয় করা হলে যদি সে ঐ পণ্যটির মূল্য মাসিক কিস্তিতে নিয়মিত ভাবে এবং যথাসময়ে পরিশোধ করিতে ব্যর্থ হয় সেক্ষেত্রে আমি/আমরা উহার অপরিশোধিত মূল্য পরিশোধে করিতে অথবা পণ্যটি ফেরত দেওয়ার ব্যবস্থা করিতে আইনত বাধ্য থাকিব।
    </p>
    <p style="margin-top: 5px;">এই চুক্তিনামা আজ, <span style="font-size: 16px;">{{  date('d/m/Y h:i A', strtotime($hirePurchase->updated_at))  }}</span> তারিখ উপরোক্ত পক্ষসমূহের মধ্যে নিম্নলিখিত শর্তাবলীর
    সম্মতি সাপেক্ষে,সম্পাদিত হল।</p>

    <table style="width:100%;" cellspacing="0">
        <tr>
            <td style="padding-top: 30px !important;">
                <p style="border-top: 2px dotted #000;padding-top: 4px; text-align: center;margin:0;">১ম নিশ্চয়তা
                    প্রদানকারীর স্বাক্ষর</p>
            </td>
            <td style="width: 15%;"></td>
            <td style="padding-top: 30px !important;">
                <p style="border-top: 2px dotted #000;padding-top: 4px; text-align: center;margin:0;">২য় নিশ্চয়তা
                    প্রদানকারীর স্বাক্ষর</p>
            </td>
        </tr>
    </table>
    <p style="background: #000;color: #fff;margin: 0 auto;padding: 5px;text-align: center;width: 90px;font-size:18px;margin-bottom: 0;">শর্তাবলী: </p>
@php

$numberToWords = new NumberToWords\NumberToWords();
$numberTransformer = $numberToWords->getNumberTransformer('en'); // 'en' for English
$hirePriceInWords = $numberTransformer->toWords(@$hirePurchase->purchase_product->hire_price);
@endphp
    <p>১ । কিস্তিতে পণ্য গ্রহণকারী কর্তৃক ১ম কিস্তি <span style="border: 1px solid #000;background: #e6e7e9;padding: 1px 3px;margin-bottom: 1px;display: inline-block;font-family: 'Jost', sans-serif;"> {{ @$hirePurchase->purchase_product->down_payment }} </span> টাকা এবং
        অবশিষ্ট <span style="border: 1px solid #000;background: #e6e7e9;padding: 1px 3px;margin-bottom: 1px;display: inline-block;font-family: 'Jost', sans-serif;">{{ @$hirePurchase->purchase_product->hire_price - @$hirePurchase->purchase_product->down_payment }} </span> টাকা ভবিষ্যতে <span style="border: 1px solid #000;background: #e6e7e9;padding: 1px 3px;margin-bottom: 1px;display: inline-block;font-family: 'Jost', sans-serif;">{{ @$hirePurchase->purchase_product->installment_month - 1 }}</span> টি কিস্তিতে
        মাসিক <span style="border: 1px solid #000;background: #e6e7e9;padding: 1px 3px;margin-bottom: 1px;display: inline-block;font-family: 'Jost', sans-serif;">{{ @$hirePurchase->purchase_product->monthly_installment }}</span> টাকা হারে প্রদানের অঙ্গীকারের ভিত্তিতে ও প্রতিনিধিগণের অনুরোধে র‌্যাংগ্স ইলেকট্রনিকস
        লিমিটেড কিস্তিতে পণ্য গ্রহণকারীকে একটি  <span style="border: 1px solid #000;background: #e6e7e9;padding: 1px 3px;margin-bottom: 1px;display: inline-block;font-family: 'Jost', sans-serif;">{{ @$hirePurchase->purchase_product->product_category->name }}</span>
        মডেল <span style="border: 1px solid #000;background: #e6e7e9;padding: 1px 3px;margin-bottom: 1px;display: inline-block;font-family: 'Jost', sans-serif;"> {{ @$hirePurchase->purchase_product->product->product_model }}</span> সিরিয়াল
        নম্বর <span style="border: 1px solid #000;background: #e6e7e9;padding: 1px 3px;margin-bottom: 1px;display: inline-block;font-family: 'Jost', sans-serif;"> {{ @$hirePurchase->purchase_product->serial_no }}</span> (অতঃপর কিস্তিকৃত পণ্য হিসেবে গণ্য হবে) যার
        সর্বমোট মুল্য <span style="border: 1px solid #000;background: #e6e7e9;padding: 1px 3px;margin-bottom: 1px;display: inline-block;font-family: 'Jost', sans-serif;">{{ @$hirePurchase->purchase_product->hire_price }}</span> টাকা
        কথায় <span style="border: 1px solid #000;background: #e6e7e9;padding: 1px 3px;margin-bottom: 1px;display: inline-block;font-family: 'Jost', sans-serif;">{{ $hirePriceInWords }}</span>
        প্রদান করতে (কিস্তিতে পণ্য গ্রহণকারী ক্রয় করবার অধিকার সাপেক্ষে) সম্মত হলেন।</p>


    <p><span style="display: block;font-weight:600;">২। কিস্তি চলাকালীন সময়ে কিস্তি গ্রহণকারী নিম্নবর্ণিত শর্তসমূহ মেনে চলতে বাধ্য থাকবেন।</span>

        (ক) কিস্তি গ্রহণকারী মাসিক কিস্তি <span style="border: 1px solid #000;background: #e6e7e9;padding: 1px 3px;margin-bottom: 1px;display: inline-block;font-family: 'Jost', sans-serif;">{{ @$hirePurchase->purchase_product->monthly_installment }}</span> টাকা, প্রতি মাসের <span style="border: 1px solid #000;background: #e6e7e9;padding: 1px 3px;margin-bottom: 1px;display: inline-block;font-family: 'Jost', sans-serif;">{{  date('d', strtotime($hirePurchase->created_at))  }}</span> তারিখ এর
        মধ্যে যে শোরুম থেকে কিস্তিতে পণ্য গ্রহণ করেছেন, সেখানে নগদে পরিশোধ করবেন।</p>

    <p>(খ) কিস্তিতে পণ্য গ্রহণকারী, কিস্তিকৃত পণ্যটি ভাল, ত্রুটিমুক্ত ও কর্মক্ষম রাখবেন এবং র‌্যাংগ্স ইলেকট্রনিকস
        লিমিটেড বা তাহার প্রতিনিধিকে তা পরিদর্শনের জন্য সময় ও সুযোগ প্রদানে বাধ্য থাকবেন ।</p>

    <p>(গ) ওয়ারেন্টির আওতায়, কিস্তিকৃত পণ্যের ত্রুটি মেরামতের জন্য র‌্যাংগ্স ইলেকট্রনিকস লিমিটেড এর সার্ভিস টেকনিশিয়ান
        ব্যতীত অন্য কাউকে নিয়োগ করা যাবে না। র‌্যাংগ্স ইলেকট্রনিকস লিমিটেড এর মনোনীত টেকনিশিয়ান ব্যতীত অন্য কোন
        টেকনিশিয়ান দ্বারা সম্পন্ন কর্মের ফলে উল্লেখিত পণ্যের কোন ক্ষতিসাধন হইলে তজ্জন্য কিস্তি গ্রহণকারী র‌্যাংগ্স
        ইলেকট্রনিকস লিমিটেড এর নিকট যথাযথভাবে দায়ী থাকিবেন ।</p>

    <p>(ঘ) কিস্তিকৃত পণ্য, কিস্তি গ্রহণকারী উপরোল্লিখিত ঠিকানায় নিজ দায়িত্বে ও তত্ত্বাবধায়নে রাখবেন এবং র‌্যাংগ্স
        ইলেকট্রনিকস লিমিটেড এর লিখিত পূর্ব অনুমতি ব্যতীত সেখান হইতে কিস্তিকৃত পণ্য স্থানান্তর করা যাবে না বা অন্য
        কোনভাবে বন্ধক, বিক্রয়, কিস্তি, হস্তান্তর ইত্যাদি করতে পারবেন না। এই শর্ত প্রতিনিধিগণের জ্ঞাতসারে বা অগোচরে
        কিস্তি গ্রহণকারী ভংগ করলে বা তাদের যে কেউ অনুরূপ করিলে র‌্যাংগ্স ইলেকট্রনিকস লিমিটেড অত্র চুক্তি বাতিল করার
        অধিকারী হবেন এবং তৎক্ষনাৎ র‌্যাংগ্স ইলেকট্রনিকস লিমিটেড এর নিকট কিস্তিকৃত পন্য কিস্তি গ্রহণকারী বুঝিয়ে দিতে
        বাধ্য থাকিবে ।</p>

    <p>(ঙ) উপরে বিধানাবলি লংঘন ব্যতীরেকে র‌্যাংগ্স ইলেকট্রনিকস লিমিটেড কোন অবস্থাতেই উপরোক্ত ঠিকানা হতে কিস্তিকৃত পণ্য
        স্থানান্তর করতে অনুমতি দিবে না। যা পৌরসভার অধীনেই একই শহরে বা গ্রামের, যেখানে র‌্যাংগ্স ইলেকট্রনিকস লিমিটেড এর
        নিজস্ব শো-রুম নাই এবং কিস্তি গ্রহণকারী যদি পরিস্কার ইচ্ছা প্রকাশ করেন যে, উপরোক্ত ঠিকানা হতে প্রস্তাবিত শহর বা
        গ্রামে কিস্তিকৃত পণ্য স্থানান্তর করতে চান তবে তিনি পূর্বে তার উক্তরূপ ইচ্ছা প্রকাশ করে র‌্যাংগ্স ইলেকট্রনিকস
        লিমিটেড এর নিকট লিখিত নোটিশ প্রদান করবেন এবং সেক্ষেত্রে স্থানান্তর এর পূর্বে সংশ্লিষ্ট শো-রুম ইনচার্জ প্রয়োজনীয়
        ব্যবস্থা গ্রহণ করবেন।</p>


    <p>
        (চ) কোন কারণে কিস্তি গ্রহণকারীর ঠিকানা বা কিস্তিকৃত পণ্যের অবস্থা খুঁজে বের করতে হলে এই সংক্রান্ত যাবতীয় খরচাদি
        বা কোন সময়ের জন্য যদি অন্য কারো দখল হতে কিস্তিকৃত পণ্য পুনরূদ্ধার করতে হয়, তাহার যাবতীয় খরচাদি চাহিবামাত্র
        কিস্তিতে পণ্য গ্রহণকারী র‌্যাংগ্স ইলেকট্রনিকস লিমিটেড কে পরিশোধ করতে বাধ্য থাকবেন।
    </p>
    <p>৩ । কিস্তি গ্রহণকারীর ইচ্ছা বা অনিচ্ছাকৃত অবহেলা বা অন্য যেকোন কারণে গ্রহণকৃত পণ্য অগ্নি বা বন্যার কারণে ক্ষতি বা
        ধ্বংস বা হারানো, চুরি বা অন্য যেকোন ভাবেই কিস্তি গ্রহণকারীর বেদখলে বা নিয়ন্ত্রণের বাহিরে চলে গেলে, কিস্তির
        যাবতীয় ক্ষতিপূরণের অর্থ র‌্যাংগ্স ইলেকট্রনিকস লিমিটেড কে পরিশোধ করতে বাধ্য থাকবেন। এই ক্ষতি পরিমাণ নির্ধারনের
        ক্ষেত্রে দ্রব্যের কিস্তিকৃত মূল্যের উপর ভিত্তি করে চুক্তির সময় প্রারম্ভিকভাবে যে অর্থ প্রদান করা হয়েছিল এবং
        মাসিক কিস্তি বাবদ যাহা পরিশোধ করা হয়েছে, তা বাদ দিয়ে ক্ষতিপূরণ পরিশোধ করতে হবে ।</p>
    <p>৪ । কিস্তি গ্রহণকারী কিস্তিকৃত পণ্য ও তৎসংক্রান্ত খুচরা যন্ত্রাংশ গ্রহণের সময় ভালভাবে বুঝে নেবেন এবং র‌্যাংগ্স
        ইলেকট্রনিকস লিমিটেড এর মালামালের যথোপযুক্ততার উদ্দেশ্য বা অন্য যে কোন উদ্দেশ্যনির্ভর পত্র প্রদান করবেন না ।</p>
    <p>৫। কিস্তি গ্রহণকারী নিজ খরচে কিস্তিকৃত পণ্য র‌্যাংগ্স ইলেকট্রনিকস লিমিটেড এর শো-রুম বা এর ঢাকাস্থ অফিসে ফেরত
        প্রদানের মাধ্যমে এই চুক্তি বাতিল করতে পারিবেন। কিন্তু এই বাতিল কিস্তি গ্রহণকারীকে পাওনা কিস্তি পরিশোধ হইতে
        অব্যাহতি প্রদান করবে না; বা র‌্যাংগ্স ইলেকট্রনিকস লিমিটেড এর কোন অধিকারের ক্ষতিসাধন করবে না; বা ইতিপূর্বে
        প্রদানকৃত অর্থ কিস্তি গ্রহণকারী ফেরত পাবেন না ।</p>

    <p>৬। কিস্তি গ্রহণকারী এই চুক্তিকালীন সময়ে কিস্তির শর্তাবলি যথাযথভাবে পালন পূর্বক কিস্তিকৃত পণ্য ক্রয়ের অধিকারী হবেন
        এবং এই ক্ষেত্রে র‌্যাংগ্স ইলেকট্রনিকস লিমিটেড এর প্রচলিত নিয়ম অনুযায়ী শীঘ্রই অর্থ পরিশোধের জন্য তাহাকে রেয়াত
        দেওয়া যাবে।</p>


    <p>৭ । কিস্তি চলাকালীন সময়ে কিস্তি গ্রহণকারী যদিঃ</p>

    <p>(ক) চুক্তি অনুযায়ী নির্ধারিত পরিমাণ অর্থ পরিশোধ করতে ব্যর্থ হয় ।</p>
    <p>
        (খ) মৃত্যুবরণ বা দেউলিয়া সাব্যস্থ হন বা তার পাওনাদারের সাথে যুক্ত হন বা র‌্যাংগ্স ইলেকট্রনিকস লিমিটেড হিসাবে
        দেউলিয়া বা রিসিভার নিযুক্ত করেন।</p>
    <p>(গ) তাহার বিরুদ্ধে আদালতের কোন হুকুমনামা বা দেনার দায়ে মালামাল আটক করতে দেওয়া বা অন্য কোন প্রক্রিয়ায় আটক করা হয়।
    </p>

    <p>(ঘ) এমন কোন কাজ করে যা কিস্তিকৃত পণ্যের উপর র‌্যাংগ্স ইলেকট্রনিকস লিমিটেড এর স্বার্থ ও অধিকার ক্ষুন্ন হয় ।

        কিস্তি গ্রহণকারী এই চুক্তিতে বর্ণিত তাহার উপর অর্পিত সকল বা যে কোন শর্ত ও বিধানাবলি যথাযতভাবে পালন ও সম্পন্ন
        করতে ব্যর্থ হলে (এই চুক্তির মূখ্য উপাদান) র‌্যাংগ্স ইলেকট্রনিকস লিমিটেড তৎক্ষণাৎ কিস্তির চুক্তি বাতিল (ইহার অন্য
        যেকোন অধিকার ক্ষুন্ন না করে) করার অধিকারী হবেন এবং অত্র চুক্তি বলে কিস্তিকৃত পণ্য পূর্ণদখল নিতে পারবেন।</p>


    <p>৮। উপরোল্লিখিত অনুচ্ছেদের অধীনে কিস্তির চুক্তি বাতিল হলে কিত্তি গ্রহণকারী বা তার আইন সম্মত উত্তরাধিকারী তৎক্ষণাৎ কিস্তিকৃত পণ্য নিজ খরচে
    র‌্যাংগস ইলেকট্রনিকস লিমিটেড এর যে শো-রুম হতে পণ্য কিস্তি গ্রহণ করা হয়েছে সেখানে বা র‌্যাংগস ইলেকট্রনিকস লিমিটেড এর অফিসে হস্তান্তর
    করবেন। </p>

    <p>
        ৯। কিস্তি গ্রহণকারী তা করতে ব্যর্থ হলে র‌্যাংগস ইলেকট্রনিকস লিমিটেড বা এর প্রতিনিধি ব্য কর্মচারী বা র‌্যাংগস ইলেকট্রনিকস লিমিটেড এর মনোনীত
        যেকোন ব্যক্তি যেকোন স্থানে যেখানে রক্ষিত আছে বলে প্রতীয়মান হবে, সেখানে প্রবেশ করে মালামালের দখল নিতে পারবেন। সেক্ষেত্রে কিস্তি
        গ্রহণকারী বা তার মনোনীত কোন ব্যক্তি অন্য কোন ভাবে র‌্যাংগস ইলেকট্রনিকস লিমিটেড এর বিরুদ্ধে কোন প্রকার মামলা দায়ের বা কার্যক্রম গ্রহণ
        করতে পারবেন না।
    </p>

    <p>
        ১০। কিস্তি গ্রাহক, মাসিক কিস্তি প্রদেয় হবার তারিখের পরের মাসের মধ্যেও যদি কিস্তির টাকা পরিশোধে ব্যর্থ হন, সেক্ষেত্রে ২য় মাস থেকে প্রতি বকেয়া
        মাসের জন্য, ৫০০/- টাকা করে কিস্তিমূল্যের সাথে জরিমানা যোগ হবে।
    </p>

    <p>
        ১১। এই চুক্তিনামার যেকোন বিধানের অধীনে কিস্তির চুক্তি বাতিল হলে, তৎক্ষণাৎ সকল বকেয়া কিস্তি র‌্যাংগ্স ইলেকট্রনিকস লিমিটেড এর পণ্য গ্রহণের
        তারিখ পর্যন্ত এই চুক্তিনামা যে কোন বিধান অনুযায়ী ধার্য খরচাদি, দায়, পণ্য দখল নেওয়া, স্থানান্তর করার খরচাদি, পণ্য ভাল ও যথাযথ অবস্থায় আনার
        জন্য আনুষাঙ্গিক খরচাদিসহ যাবতীয় অর্থ র‌্যাংগস ইলেকট্রনিকস লিমিটেড এর কাছে পরিশোধ করবেন (যথাযথ ব্যবহার জনিত ক্ষয় ব্যতিরেকে) এই
        চুক্তিনামার বিধান অনুযায়ী ইতিপূর্বে পরিশোধিত অর্থ কোন অবস্থাতে র‌্যাংগস ইলেকট্রনিকস লিমিটেড কিস্তি গ্রহণকারীকে ফেরত প্রদান করবেন না।
    </p>

    <p>১২। এই চুক্তিনামা কিস্তি গ্রহণকারীর নিজস্ব ও ব্যক্তিগত ব্যাপার এবং কিস্তি গ্রহণকারী এই চুক্তির বলে প্রাপ্ত তাঁর অধিকার এবং দায়-দায়িত্ব প্রত্যক্ষ বা
পরোক্ষভাবে অন্য কাউকে হস্তান্তর বা অর্পণ করতে পারবেন না।</p>

    <p>
        ১৩। প্রতিনিধিগণ সম্মিলিতভাবে বা পৃথক পৃথকভাবে সম্মত হলেন যে তাহাদের দায়দায়িত্ব কিস্তি গ্রহণকারীর অনুরূপ হবে। যদিও সকল ক্ষেত্রে তাহাদের
প্রত্যেকে নিজে কিস্তি গ্রহণকারী এবং সম্মিলিতভাবে বা পৃথক পৃথকভাবে র‌্যাংগস ইলেকট্রনিকস লিমিটেড এর নিকট ঃ
    </p>
    <p>
        (ক) সকল মাসিক কিস্তি ও পাওনা নিয়মিত ও সময়মত পরিশোধের জনা এতদ্বারা আবদ্ধ হন।
    </p>
    <p>
        (খ) এই চুক্তির অধীনে বা বলে সকল প্রকার অর্থ যা ঋণ হোক আর কিস্তিই হোক বা ক্ষতিপূরণ, খরচাদি, যাই হোক না কেন, সমুদয় অর্থ র‌্যাংগস
ইলেকট্রনিকস লিমিটেড এর নিকট পরিশোধের নিশ্চয়তা প্রদান করবেন।
    </p>
    <p>১৪। প্রতিনিধিগণ আরও সম্মত হন যে-</p>
    <p>
        (ক) পাওনা অর্থ আদায়ের নিমিত্তে কিস্তি গ্রহণকারী ও প্রতিনিধিগণের বিরুদ্ধে সম্মিলিতভাবে বা পৃথক পৃথকভাবে মামলা করার বিশেষ অধিকার র‌্যাংগ্স
ইলেকট্রনিকস লিমিটেড এর থাকবে।
    </p>
    <p>
        (খ) প্রতিনিধিগণ কিস্তি গ্রহণকারীর কিস্তিকৃত পণ্যের উপর দাবীদার হওয়ার অধিকার এতদ্বারা পরিত্যাগ করেন এবং সেই সাথে আইনানুগ যে সুবিধা
পাওয়ার যোগ্য তাও এতদ্বারা পরিত্যাগ করেন।
    </p>
    <p>
        (গ) এই চুক্তি নামার আওতায় কিস্তি গ্রহণকারীর নিকট হতে কোন পাওনা অর্থ আদায় করতে র‌্যাংগ্স ইলেকট্রনিকস লিমিটেড বা এর মনোনীত
প্রতিনিধির কোন অবহেলা বা সহিষ্ণুতা বা অন্য যে কোনোভাবে উদাসীনতা থাকলে কিস্তি গ্রহণকারী বা প্রতিনিধিগণ অত্র চুক্তিনামার অধীনে দায়িত্ব
ও কর্তৃব্য হতে মুক্ত হবেন না বা অন্য কোনভাবে কিস্তি গ্রহণকারী বা প্রতিনিধিগণের উল্লেখিত দায়িত্ব ও কর্তব্য পরিবর্তিত হবেনা এবং অন্য
কোনভাবে র‌্যাংগস ইলেকট্রনিকস লিমিটেড এর অধিকারসমূহ ক্ষুন্ন হবে না।
    </p>
    <p>
        ১৫। কোন নোটিশ রেজিষ্টার্ড ডাকযোগে র‌্যাংগস ইলেকট্রনিকস লিমিটেড এর বেলায় ইহার উপরের বর্ণিত ঢাকাস্থ অফিসে পাঠালে এবং কিস্তি গ্রহণকারী বা
যেকোন প্রতিনিধির বেলায় তাহাদের উপরে বর্ণিত ঠিকানায় পাঠালে তা যথাযথভাবে প্রদান করা হয়েছে বলে বিবেচিত হবে। কিস্তি গ্রহণকারী ও
প্রতিনিধিগণের উপর বর্ণিত নিজ নিজ ঠিকানায় বা কোন পরিবর্তিত ঠিকানায় যদি উহ্য র‌্যাংগ্স ইলেকট্রনিকস লিমিটেড কে জ্ঞাত করা হয়ে থাকে তাহলে
এই ধরনের নোটিশ প্রাপ্তির পরের দিনেই যথাযথভাবে জারি ও কার্যকারী হয়েছে বলে বিবেচিত হবে।
    </p>


    <p>এতদ্বার্থে স্বেচ্ছায়, স্বজ্ঞানে, সুস্থ মস্তিষ্কে, অন্যের বিনা প্ররোচনায় অত্র চুক্তিনামা দলিল নিজে পড়ে বা অন্যের দ্বারা পড়িয়ে ইহার মর্ম সমাক্ষ অবগত হয়ে
স্বাক্ষীগণের মোকাবেলায় পক্ষগণ এবং প্রতিনিধিগণ নিজ নিজ নাম সহি স্বাক্ষর করলাম</p>

    <p>র‌্যাংগস ইলেকট্রনিক্স লিঃ কোন কারণ দর্শানো ব্যাতিরেকে উপরে উলেখিত শর্তাবলী পরিবর্তন, পরিবর্ধন ও সংশোধন করার অধিকার সংরক্ষণ করে এবং
যে কোন পরিবর্তন, পরিবর্ধন ও সংশোধন কিস্তি গ্রহণকারী মেনে নিতে বাধ্য থাকবেন।</p>


    <table style="width: 100%;padding-top:20px;" cellspacing="0">
        <tr>
            <td style="padding-right: 15px !important;">
                <p style="margin-top: 0;margin-bottom:0;font-weight:600;">সংযুক্তি :</p>
                <br>
                <p style="margin-top: 0 !important;">১. আবেদনকারীর পাসপোর্ট সাইজের রঙিন ছবি - দুই কপি।</p>
                <p>২. আবেদনকারীর জাতীয় পরিচয়পত্রের কপি - স্বাক্ষর সহ ফটোকপি।</p>
                <p>৩. আবেদনকারীর বর্তমান ঠিকানার ইউটিলিটি (বিদ্যুৎ, পানি বা গ্যাস ইত্যাদি) বিলের কপি - স্বাক্ষরসহ ফটোকপি।</p>
                <p>৪. আবেদনকারীর ব্যাংক একাউন্টের স্বাক্ষরসহ এবং তারিখ বিহীন একটি চেক - মূল কপি। </p>
                <p>৫. আবেদনকারীর বর্তমান পেশার স্বপক্ষের প্রমাণাদি (আইডি কার্ড, ভিজিটিং কার্ড, বাড়ি মালিকের ক্ষেত্রে বাড়ি ভাড়া গ্রহণের রশিদের কপি ইত্যাদি)।</p>
                <p>৬. ১ম নিশ্চয়তা প্রদানকারীর জাতীয় পরিচয়পত্রের কপি - স্বাক্ষর সহ ফটোকপি।</p>
                <p>৭. ১ম নিশ্চয়তা প্রদানকারীর প্রদত্ত ঠিকানার ইউটিলিটি (বিদ্যুৎ, পানি বা গ্যাস ইত্যাদি) বিলের কপি - স্বাক্ষরসহ ফটোকপি।</p>
                <p>৮. ২য় নিশ্চয়তা প্রদানকারীর জাতীয় পরিচয়পত্রের কপি - স্বাক্ষর সহ ফটোকপি।</p>
                <p>৯. ২য় নিশ্চয়তা প্রদানকারীর প্রদত্ত ঠিকানার ইউটিলিটি (বিদ্যুৎ, পানি বা গ্যাস ইত্যাদি) বিলের কপি - স্বাক্ষরসহ ফটোকপি। </p>
                <p>১০. প্রযোজ্য ক্ষেত্রে অন্যান্য প্রয়োজনীয় তথ্যাদি।</p>
            </td>
            <td style="width:38%;vertical-align: top;">
                <table style="width:100%;padding-top: 34px;height:100%;" cellspacing="0">
                    <tr>
                        <td style="width:43%;font-weight:600;">আবেদনকারীর স্বাক্ষর:</td>
                        <td style="text-align: center;padding-top:5px !important;border-bottom:2px dotted #000;"></td>
                    </tr>
                    <tr>
                        <td style="width:43%;font-weight:600;padding-top:15px !important;">আবেদনকারীর নাম:</td>
                        <td style="text-align: center;padding-top:5px !important;border-bottom:2px dotted #000;"></td>
                    </tr>
                    <tr>
                        <td style="width:43%;font-weight:600;padding-top:15px !important;">তারিখ:</td>
                        <td style="text-align: center;padding-top:5px !important;border-bottom:2px dotted #000;"></td>
                    </tr>
                    <tr>
                        <td colspan="2" style="text-align: center;padding-top: 7px; vertical-align:middle;height:180px;">
                            আবেদনকারীর তথ্য যাচাই করে সঠিক প্রমাণিত
                            হলো
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="text-align: center;padding-top:5px !important;border-top:2px dotted #000;vertical-align:bottom;padding-bottom: 45px !important;text-align: center;font-weight:600;">
                            বিক্রয় প্রতিনিধির সীলসহ স্বাক্ষর
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="text-align: center;padding-top:5px !important;border-top:2px dotted #000;vertical-align:bottom;text-align: center;font-weight:600;">
                            শোরুম ইনচার্জের সীলসহ স্বাক্ষর
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>

<script>
    // window.print();
</script>
