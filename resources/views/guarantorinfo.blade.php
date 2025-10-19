<style type="text/css" media="print">
    @page {
        size: auto;
        margin-top: 40px;
        margin-bottom: 40px;
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
        /* padding: 20px; */
    }

    body {
        font-family: 'SutonnyMJ', sans-serif;
        font-size: 12px !important;
        padding: 2px;
        margin: 0px;
    }

    table th,
    table td {
        font-family: 'SutonnyMJ', sans-serif;
        font-size: 12px !important;
        border-collapse: collapse;
        padding: 2px !important;
    }

    p {
        line-height: 20px;
        font-family: 'SutonnyMJ', sans-serif;
    }
    .second_guarantor {
        border-top: 1.7px solid #00b050;
        padding-top: 5px;
        margin-top: 5px;
    }
    .first_guarantor{
            margin-top:3px;
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
            /* padding: 5px; */
        }

        body {
            font-family: 'SutonnyMJ', sans-serif;
            font-size: 12px !important;
            margin: 0px;
        }

        table th,
        table td {
            font-family: 'SutonnyMJ', sans-serif;
            font-size: 12px !important;
            border-collapse: collapse;
            padding: 1.5px !important;
        }

        p {
            line-height: 20px;
            font-family: 'SutonnyMJ', sans-serif;
        }

        body {
            -webkit-print-color-adjust: exact;
            /*chrome & webkit browsers*/
            color-adjust: exact;
            /*firefox & IE */
            font-family: 'Jost', sans-serif;
        }

        html,
        body {
            margin: 0;
            padding: 0;
        }

        img {
            -webkit-print-color-adjust: exact;
        }
        .second_guarantor {
            border-top: 1.7px solid #00b050;
            padding-top: 5px;
            margin-top: 5px;
        }
        .first_guarantor{
            margin-top:3px;
        }
    }
</style>
<div class="formBody" style="width: 795px;margin:0 auto;">
    <table style="width:100%;font-weight:600;" cellspacing="0">
        <tbody> 
            <tr>
                <table style="width:100%;margin-bottom:3px" cellspacing="0">
                    <tr>
                        <td>
                            <h2 style="font-weight: 600; font-size: 24px; color: #000;margin-top:0; margin-bottom: 6px;">
                                র‌্যাংগ্স ইলেকট্রনিক্স লিমিটেড
                            </h2>
                            <p style="font-size: 11.5px; line-height: 14px; margin: 0;margin-bottom: 2px;font-weight:500;">
                                সোনারতরী টাওয়ার, ১২ সোনারগাঁও রোড, ঢাকা-১০০০, বাংলাদেশ।
                            </p>
                            <p style="font-size: 11.5px; line-height: 14px; margin: 0;font-weight:500;">
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
                @foreach($guarantor as $key=>$guaran)
                <table style="width:100%;" cellspacing="0" class= @if($key==1) second_guarantor @else first_guarantor @endif>
                    <tr>
                        @if($key==1) 
                        <td></td>
                        @else 
                        <td style="text-align:center;vertical-align:middle;padding-bottom:4px !important;">
                            <div style="background-color: #ec2026; color: white; padding: 6px 22px; border-radius: 16px; display: inline-block; font-weight: 600; font-size: 18px; text-align: center;">
                                নিশ্চয়তা প্রদানকারীর তথ্যসমূহ
                            </div>
                            <div style="font-size: 11px; margin-top: 5px; font-style: italic;">
                                (প্রদেয় তথ্যের গোপনীয়তা রক্ষা করা হবে) বাংলা অথবা ইংরেজিতে সম্পূর্ণ আবেদন পত্রটি পূরণ যোগ্য
                            </div>
                            {{-- <div style="font-size: 11px; margin-top: 2px;">
                                বাংলা অথবা ইংরেজিতে সম্পূর্ণ আবেদন পত্রটি পূরণ যোগ্য
                            </div> --}}
                        </td>
                        @endif
                        <td @if($key==1) rowspan="5" @else rowspan="3" @endif style="font-size:11px !important;border:1px solid #000;vertical-align:middle;width:18%;padding:8px !important;height:120px;text-align:center">
                            @if($key==1) ২য়@else ১ম@endif নিশ্চয়তা প্রদানকারীর
                            ১ কপি পাসপোর্ট
                            সাইজের রঙিন ছবি।
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-top:10px;width:79%;">
                            <table style="width:100%;" cellspacing="0">
                                <tr>
                                    <td style="width:47%;background:#000;color:#fff;">১)@if($key==1) ২য়@else ১ম@endif প্রস্তাবিত নিশ্চয়তা প্রদানকারীর নাম- মিঃ/মিসেস/মিস:</td>
                                    <td style="width:1.5px;"></td>
                                    <td style="border: 1px solid #000;background: #F2F2F2;padding-left:3px !important;font-family: 'Jost', sans-serif;">{{ $guaran->guarater_name }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-top: 7px;">
                            <table style="width:100%;" cellspacing="0">
                                <tr>
                                    <td style="width:26%;">
                                        ২)
                                        <input type="checkbox" checked name="relation" id="father"> <label
                                            for="father">পিতা/</label>
                                        <input type="checkbox" name="relation" id="husband"> <label
                                            for="husband">স্বামীর নাম:</label>
                                    </td>
                                    <td style="border: 1px solid #000;background: #F2F2F2;padding-left:3px !important;font-family: 'Jost', sans-serif;">{{ $guaran->guarater_relation_name}}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td @if($key==0) colspan="2" @endif style="padding-top: 7px;">
                            <table style="width:100%;" cellspacing="0">
                                <tr>
                                    <td style= @if($key==1) width:27% @else width:22% @endif >৩)ক. বর্তমান আবাসিক ঠিকানা:</td>
                                    <td style="border: 1px solid #000;background: #F2F2F2;padding-left:3px !important;font-family: 'Jost', sans-serif;">{{ $guaran->guarater_address_present }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td @if($key==0) colspan="2" @endif style="padding-top: 7px;">
                            <table style="width:100%;" cellspacing="0">
                                <tr>
                                    <td style= @if($key==1) width:20% @else width:16% @endif>খ. ন্যাশনাল আইডি নং:</td>
                                    <td style="border: 1px solid #000;background: #F2F2F2;padding-left:3px !important;font-family: 'Jost', sans-serif;">{{ $guaran->guarater_nid }}</td>
                                    <td style= @if($key==1) width:14% @else width:11% @endif>গ. মোবাইল নং:</td>
                                    <td style="border: 1px solid #000;background: #F2F2F2;padding-left:3px !important;font-family: 'Jost', sans-serif;">{{ $guaran->guarater_phone }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="padding-top: 7px;">
                            <table style="width:100%;" cellspacing="0">
                                <tr>
                                    <td style="width: 15%;">ঘ.বর্তমান ঠিকানায় কতদিন বসবাস করছেন?</td>
                                    <td style="border: 1px solid #000;background: #F2F2F2;padding-left:3px !important;font-family: 'Jost', sans-serif;;width: 3%;">{{ $guaran->duration_of_staying }}</td>
                                    <td style="width: 1%;padding-left:5px !important;">বছর</td>
                                    <td style="border: 1px solid #000;background: #F2F2F2;padding-left:3px !important;font-family: 'Jost', sans-serif;;width: 3%;"></td>
                                     <td style="width: 3%;padding-left:5px !important;">মাস</td>
                                    <td style="width: 8%;">
                                       ঙ. নিজস্ব বাড়ি/ভাড়া :
                                    </td>
                                    <td style="border: 1px solid #000;background: #F2F2F2;padding-left:3px !important;font-family: 'Jost', sans-serif;;width:17%;">{{ $guaran->residense_status }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="padding-top: 7px;">
                            <table style="width:100%;" cellspacing="0">
                                <tr>
                                    <td style="width:11%;">
                                        ৪) স্থায়ী ঠিকানা:
                                    </td>
                                    <td style="border: 1px solid #000;background: #F2F2F2;padding-left:3px !important;font-family: 'Jost', sans-serif;">{{ $guaran->guarater_address_permanent }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="padding-top: 7px;">
                            <table style="width:100%;" cellspacing="0">
                                <tr>
                                    <td style="width:8%;">
                                        ৫)ক.বয়স 
                                    </td>
                                    <td style="border: 1px solid #000;background: #F2F2F2;padding-left:3px !important;font-family: 'Jost', sans-serif;">{{ $guaran->age }}</td>
                                    <td style="width: 4%;">বছর,</td>
                                    <td style="width: 13%;">খ.বৈবাহিক অবস্থা</td>
                                    <td style="border: 1px solid #000;background: #F2F2F2;padding-left:3px !important;font-family: 'Jost', sans-serif;">{{ $guaran->marital_status }}</td>
                                    
                                    <td style="width: 12%;">গ.সন্তানের সংখ্যা</td>
                                    <td style="border: 1px solid #000;background: #F2F2F2;padding-left:3px !important;font-family: 'Jost', sans-serif;">{{ $guaran->number_of_children }}</td>
                                    <td style="width: 19%;">ঘ.অন্যান্য পোষ্যদের সংখ্যা:</td>
                                    <td style="border: 1px solid #000;background: #F2F2F2;padding-left:3px !important;font-family: 'Jost', sans-serif;">{{ $guaran->other_family_member }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="padding-top: 7px;">
                            <table style="width:100%;" cellspacing="0">
                                <tr>
                                    <td style="width: 8%;">৬)ক.পেশা</td>
                                    <td style="border: 1px solid #000;background: #F2F2F2;padding-left:3px !important;font-family: 'Jost', sans-serif;;width: 24%;">{{ @$guaran->profession->name}}</td>
                                    <td style="padding-left: 5px !important">খ.পদবী</td>
                                    <td style="border: 1px solid #000;background: #F2F2F2;padding-left:3px !important;font-family: 'Jost', sans-serif;;width: 30%;">{{ $guaran->designation }}</td>
                                    <td style="padding-left: 5px !important">গ.মোবাইল নং:</td>
                                    <td style="border: 1px solid #000;background: #F2F2F2;padding-left:3px !important;font-family: 'Jost', sans-serif;;width: 20%;">
                                        {{ $guaran->profession_phone }}
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="padding-top: 7px;">
                            <table style="width:100%;" cellspacing="0">
                                <tr>
                                    <td style="width:11%;">
                                        ঘ.মাসিক আয়:
                                    </td>
                                    <td style="border: 1px solid #000;background: #F2F2F2;padding-left:3px !important;font-family: 'Jost', sans-serif;">{{ $guaran->monthly_income }}</td>
                                    <td style="padding-left:5px !important;width:7%;">টাকা</td>
                                    <td style="width: 25%;">ঙ. কতদিন বর্তমান পেশার সাথে যুক্ত:</td>
                                    <td style="border: 1px solid #000;background: #F2F2F2;padding-left:3px !important;font-family: 'Jost', sans-serif;">{{ $guaran->duration_current_profession }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="padding-top: 7px;">
                            <table style="width:100%;" cellspacing="0">
                                <tr>
                                    <td style="width:29%;">
                                        চ. অফিস/ব্যবসা প্রতিষ্ঠানের নাম ও ঠিকানা:
                                    </td>
                                    <td style="border: 1px solid #000;background: #F2F2F2;padding-left:3px !important;font-family: 'Jost', sans-serif;">{{ $guaran->name_address_office }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="padding-top: 7px;">
                            <table style="width:100%;" cellspacing="0">
                                <tr>
                                    <td style="width:34%;">
                                        ৭) র‌্যাংগস ইলেকট্রনিক্স লিমিটেড এর বাজারজাতকৃত
                                    </td>
                                    <td style="border: 1px solid #000;background: #F2F2F2;padding-left:3px !important;font-family: 'Jost', sans-serif;">{{ @$HirePurchaseProduct->brand->name }}</td>
                                    <td style="width: 13%;">ব্র্যান্ডের,মডেল নং:</td>
                                    <td style="border: 1px solid #000;background: #F2F2F2;padding-left:3px !important;font-family: 'Jost', sans-serif;">{{ @$HirePurchaseProduct->product->product_model }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="padding-top: 7px;">
                            <table style="width:100%;" cellspacing="0">
                                <tr>
                                    <td style="width: 4%;">মূল্য:</td>
                                    <td style="border: 1px solid #000;background: #F2F2F2;padding-left:3px !important;font-family: 'Jost', sans-serif;;width: 20%;">{{ @$HirePurchaseProduct->hire_price }}</td>
                                    <td>কিস্তিতে কেনার জন্য</td>
                                    <td style="border: 1px solid #000;background: #F2F2F2;padding-left:3px !important;font-family: 'Jost', sans-serif;;width: 44%;">{{ @$HirePurchase }}</td>
                                    <td>
                                        কে নিশ্চয়তা দেয়া হলো।
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="padding-top: 7px;">
                            <table style="width:100%;" cellspacing="0">
                                <tr>
                                    <td style="padding-right: 10px;">
                                        <table style="width:100%;" cellspacing="0">
                                            <tr>
                                                <td style="width: 47%;">৮) কিস্তি আবেদনকারীরর সাথে আপনার সম্পর্ক?</td>
                                                <td style="border: 1px solid #000;background: #F2F2F2;padding-left:3px !important;font-family: 'Jost', sans-serif;">{{ $guaran->relation }}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" style="padding-top: 7px;">৯)কিস্তি গ্রহীতা যদি সময়মত কোম্পানির বকেয়া টাকা পরিশোধ না করেন তাহলে প্রয়োজনীয় ব্যবস্থা এবং সহযোগিতার মাধ্যমে সমাধান দিতে বাধ্য থাকব।</td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <table width="45%" cellspacing="0">
                                                        <tr>
                                                            <td style="padding-top: 20px;width:40px;">তারিখঃ</td>
                                                            <td style="border-bottom: 1px solid #000;"></td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td style="border: 1px solid #000;padding: 0 !important;">
                                        <p style="text-align: center;margin-bottom:0;margin-top:0;">আমি নিশ্চয়তা প্রদান করছি যে  উক্ত প্রদত্ত তথ্যসমূহ সঠিক।
                                        </p>
                                        <p style="border-top: 2px dotted #000;padding-top: 4px; text-align: center;margin-top:14px;margin-bottom:0;">@if($key==1) ২য়@else ১ম@endif নিশ্চয়তাপ্রদানকারীর স্বাক্ষর</p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                @endforeach
            </tr>
            <tr>
                <td>
                    <table>
                        <tr>
                            <td>
                                কিস্তিতে পণ্য ক্রয়ের জন্য গ্যারান্টর বা নিশ্চয়তা প্রদানকারী হিসেবে,উপরে বর্ণিত ব্যক্তিগণের প্রদত্ত সকল তথ্যাবলী সম্পূর্ণ সঠিক।
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="padding-top: 7px;">
                    <table style="width:100%;" cellspacing="0">
                        <tr>
                            <td style="padding-right: 10px;">
                                <table width="45%" cellspacing="0">
                                    <tr>
                                        <td style="padding-top: 20px;width:40px;">তারিখঃ</td>
                                        <td style="border-bottom: 1px solid #000;"></td>
                                    </tr>
                                </table>
                            </td>
                            <td style="width: 27%;padding-top: 10px !important;">
                                <p style="border-top: 2px dotted #000;padding-top: 4px; text-align: center;">আবেদনকারীর স্বাক্ষর</p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    দরখাস্তকারীর উপরোল্লিখিত তথ্যসমূহ বিক্রয়ের পূর্বে যাচাই করা হয়েছে এবং সত্য বলে জানা গিয়েছে। 
                </td>
            </tr>
            <tr>
                <td  style="padding-top: 7px;">
                    <table style="width:100%;" cellspacing="0">
                        <tr>
                            <td style="padding-right: 10px;">
                                <table width="100%" cellspacing="0">
                                    <tr>
                                        <td style="padding-top: 20px;width:40px;">তারিখঃ</td>
                                        <td style="border-bottom: 1px solid #000;"></td>
                                    </tr>
                                </table>
                            </td>
                            <td style="width:20px"></td>
                            <td style="width: 32%;!important;padding-top: 32px !important;">
                                <p style="border-top: 2px dotted #000;padding-top: 4px; text-align: center;"> বিক্রয় প্রতিনিধির সীলসহ স্বাক্ষর</p>
                            </td>
                            <td style="width:20px"></td>
                            <td style="width: 32%;!important;padding-top: 32px !important;">
                                <p style="border-top: 2px dotted #000;padding-top: 4px; text-align: center;">শোরুম ইনচার্জের সীলসহ স্বাক্ষর</p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<script>
 //   window.print();
</script>