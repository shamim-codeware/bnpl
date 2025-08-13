<style type="text/css" media="print">
    @page {
        size: auto;
        margin: 0mm;
        padding: 2px;
    }
</style>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Jost:wght@400;500;600;700&display=swap');

    .formBody {
        padding: 20px;
    }

    body {
        font-family: 'Jost', sans-serif !important;
        font-size: 12px !important;
        padding: 2px;
        margin: 0px;
    }

    table th,
    table td {
        font-family: 'Jost', sans-serif !important;
        font-size: 12px !important;
        border-collapse: collapse;
        padding: 2px !important;
    }

    p {
        line-height: 20px;
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

        .formBody {
            padding: 5px;
        }

        body {
            font-family: 'Jost', sans-serif !important;
            font-size: 10px !important;
            padding: 3px;
            margin: 0px;
        }

        table th,
        table td {
            font-family: 'Jost', sans-serif !important;
            font-size: 12px !important;
            border-collapse: collapse;
            padding: 2 !important;
        }

        p {
            line-height: 20px;
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
<br>
<div class="formBody" style="width: 795px;margin:0 auto;border: 1px solid #ddd;">
    <table style="width:100%;" cellspacing="0">
        <tbody> 
            <tr>
                <td style="padding-bottom: 10px;">
                    <h3 style="margin-bottom: 0;color:#00b050;text-align: center;font-size:12px">র‌্যাংগস ইলেকট্রনিক্স লিমিটেড এর পণ্য
                        সামগ্রী কিস্তিতে ক্রয়ের ক্ষেত্রে গ্রাহকের নিশ্চয়তা প্রদানকারীর বিবরণ</h3>
                </td>
            </tr>
            <tr>
                <td style="padding: 5px;border:1px solid #000;text-align: center;">
                    <strong>(প্রদেয় তথ্যের গোপনীয়তা রক্ষা করা হবে) সম্পূর্ণ আবেদন পত্রটি পূরণযোগ্য</strong>
                </td>
            </tr>
            <tr>
                @foreach($guarantor as $key=>$guaran)
                <table style="width:100%;" cellspacing="0" class= @if($key==1) second_guarantor @else first_guarantor @endif>
                    <tr>
                        <td style="padding-top:10px;width:79%;">
                            <table style="width:100%;" cellspacing="0">
                                <tr>
                                    <td style="width:51%;">১)@if($key==1) ২য়@else ১ম@endif প্রস্তাবিত নিশ্চয়তা প্রদানকারীর নাম- মিঃ/মিসেস/মিস : </td>
                                    <td style="border-bottom: 2px dotted #000;">{{ $guaran->guarater_name }}</td>
                                </tr>
                            </table>
                        </td>
                        <td rowspan="4" style="font-size:9px !important;border:1px solid #000;vertical-align:middle;width:160px;height:160px;text-align:center">
                            {{-- <img src="https://i.postimg.cc/Kz0Kp8yX/blank.png" alt="guarantor photo" style="width: 160px;height: 160px;object-fit: cover;margin-left:7px;"> --}}
                            ছবি
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-top: 7px;">
                            <table style="width:100%;" cellspacing="0">
                                <tr>
                                    <td style="width:20%;">২)পিতা/স্বামী/স্ত্রীর নাম:</td>
                                    <td style="border-bottom: 2px dotted #000;">{{ $guaran->guarater_relation_name}}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-top: 7px;">
                            <table style="width:100%;" cellspacing="0">
                                <tr>
                                    <td style="width:27%;">৩)ক. বর্তমান আবাসিক ঠিকানা:</td>
                                    <td style="border-bottom: 2px dotted #000;">{{ $guaran->guarater_address_present }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-top: 7px;">
                            <table style="width:100%;" cellspacing="0">
                                <tr>
                                    <td style="border-bottom: 2px dotted #000;width: 46%;"></td>
                                    <td style="width:23%;">খ. টেলিফোন/মোবাইল নং:</td>
                                    <td style="border-bottom: 2px dotted #000;">{{ $guaran->guarater_phone }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="padding-top: 7px;">
                            <table style="width:100%;" cellspacing="0">
                                <tr>
                                    <td style="width: 18%;">গ.বর্তমান ঠিকানায় কতদিন বসবাস করছেন?</td>
                                    <td style="border-bottom: 2px dotted #000;width: 12%;">{{ $guaran->duration_of_staying }}</td>
                                    <td style="width: 6%;">মাস/বছর,</td>
                                    <td style="width: 9%;">
                                        ঘ.নিজস্ব বাড়ি/ভাড়া?
                                    </td>
                                    <td style="border-bottom: 2px dotted #000;width:15%;">{{ $guaran->residense_status }}</td>
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
                                    <td style="border-bottom: 2px dotted #000;">{{ $guaran->guarater_address_permanent }}</td>
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
                                    <td style="border-bottom: 2px dotted #000;">{{ $guaran->age }}</td>
                                    <td style="width: 4%;">বছর,</td>
                                    <td style="width: 13%;">খ.বৈবাহিক অবস্থা</td>
                                    <td style="border-bottom: 2px dotted #000;">{{ $guaran->marital_status }}</td>
                                    
                                    <td style="width: 12%;">গ.সন্তানের সংখ্যা</td>
                                    <td style="border-bottom: 2px dotted #000;">{{ $guaran->number_of_children }}</td>
                                    <td style="width: 19%;">ঘ.অন্যান্য পোষ্যদের সংখ্যা:</td>
                                    <td style="border-bottom: 2px dotted #000;">{{ $guaran->other_family_member }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="padding-top: 7px;">
                            <table style="width:100%;" cellspacing="0">
                                <tr>
                                    <td style="width: 8%;">৬)ক.পেশা</td>
                                    <td style="border-bottom: 2px dotted #000;width: 24%;">{{ @$guaran->profession->name}}</td>
                                    <td>খ.পদবী</td>
                                    <td style="border-bottom: 2px dotted #000;width: 24%;">{{ $guaran->designation }}</td>
                                    <td>গ.টেলিফোন/মোবাইল নং:</td>
                                    <td style="border-bottom: 2px dotted #000;width: 20%;">
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
                                    <td style="border-bottom: 2px dotted #000;">{{ $guaran->monthly_income }}</td>
                                    <td style="width: 25%;">ঙ.কতদিন বর্তমান পেশার সাথে যুক্ত:</td>
                                    <td style="border-bottom: 2px dotted #000;">{{ $guaran->duration_current_profession }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="padding-top: 7px;">
                            <table style="width:100%;" cellspacing="0">
                                <tr>
                                    <td style="width:29%;">
                                        চ.অফিস/ব্যবসা প্রতিষ্ঠানের নাম ও ঠিকানা:
                                    </td>
                                    <td style="border-bottom: 2px dotted #000;">{{ $guaran->name_address_office }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="padding-top: 7px;">
                            <table style="width:100%;" cellspacing="0">
                                <tr>
                                    <td style="width:34%;">
                                        ৭)র‌্যাংগস ইলেকট্রনিক্স লিমিটেড এর বাজারজাতকৃত
                                    </td>
                                    <td style="border-bottom: 2px dotted #000;">{{ @$HirePurchaseProduct->brand->name }}</td>
                                    <td style="width: 13%;">ব্র্যান্ডের,মডেল নং:</td>
                                    <td style="border-bottom: 2px dotted #000;">{{ @$HirePurchaseProduct->product->product_model }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="padding-top: 7px;">
                            <table style="width:100%;" cellspacing="0">
                                <tr>
                                    <td style="width: 4%;">মূল্য:</td>
                                    <td style="border-bottom: 2px dotted #000;width: 20%;">{{ @$HirePurchaseProduct->hire_price }}</td>
                                    <td>কিস্তিতে কেনার জন্য</td>
                                    <td style="border-bottom: 2px dotted #000;width: 44%;">{{ @$HirePurchase }}</td>
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
                                                <td style="width: 33%;">৮)গ্রাহকের সাথে আপনার সম্পর্ক?</td>
                                                <td style="border-bottom: 2px dotted #000;">{{ $guaran->relation }}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" style="padding-top: 7px;">৯)কিস্তি গ্রহীতা যদি সময়মত কোম্পানির বকেয়া টাকা পরিশোধ না করেন তাহলে প্রয়োজনীয় ব্যবস্থা এবং সহযোগিতার মাধ্যমে সমাধান দিতে বাধ্য থাকব।</td>
                                            </tr>
                                            <tr>
                                                <td style="padding-top: 20px;">তারিখঃ</td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td style="border: 1px solid #000;padding: 5px;">
                                        <p style="text-align: center;margin-bottom:0;">আমি নিশ্চয়তা প্রদান করছি যে
                                            Hirer এর তথ্যসমূহ সঠিক। 
                                        </p>
                                        <br>
                                        <p style="border-top: 2px dotted #000;padding-top: 4px; text-align: center;margin-top:0">নিশ্চয়তাপ্রদানকারীর স্বাক্ষর</p>
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
                                <table style="width:100%;" cellspacing="0">
                                    <tr>
                                        <td style="padding-top: 20px;">তারিখঃ</td>
                                    </tr>
                                </table>
                            </td>
                            <td style="width: 27%;padding-top: 15px !important;">
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
                                <table style="width:100%;" cellspacing="0">
                                    <tr>
                                        <td style="padding-top: 20px;">তারিখঃ</td>
                                    </tr>
                                </table>
                            </td>
                            <td style="width: 32%;!important;">
                                <p style="border-top: 2px dotted #000;padding-top: 4px; text-align: center;">শোরুম ইনচার্জ/বিক্রয় প্রতিনিধির সীলসহ স্বাক্ষর</p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>

    {{-- <table style="width:100%; border-top: 1.3px solid #000;padding-top: 3px; margin-top: 10px;" cellspacing="0">
        <tbody>
            <tr>
                <table style="width:100%;" cellspacing="0">
                    <tr>
                        <td style="padding-top:10px;">
                            <table style="width:100%;" cellspacing="0">
                                <tr>
                                    <td style="width:46%;">১)২য় প্রস্তাবিত নিশ্চয়তা প্রদানকারীর নাম- মিঃ/মিসেস/মিস :</td>
                                    <td style="border-bottom: 2px dotted #000;"></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-top: 7px;">
                            <table style="width:100%;" cellspacing="0">
                                <tr>
                                    <td style="width:18%;">২)পিতা/স্বামী/স্ত্রীর নাম:</td>
                                    <td style="border-bottom: 2px dotted #000;"></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-top: 7px;">
                            <table style="width:100%;" cellspacing="0">
                                <tr>
                                    <td style="width:24%;">৩)ক. বর্তমান আবাসিক ঠিকানা:</td>
                                    <td style="border-bottom: 2px dotted #000;"></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-top: 7px;">
                            <table style="width:100%;" cellspacing="0">
                                <tr>
                                    <td style="border-bottom: 2px dotted #000;width: 40%;"></td>
                                    <td style="width:22%;">খ. টেলিফোন/মোবাইল নং:</td>
                                    <td style="border-bottom: 2px dotted #000;"></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-top: 7px;">
                            <table style="width:100%;" cellspacing="0">
                                <tr>
                                    <td style="width: 23%;">গ.বর্তমান ঠিকানায় কতদিন বসবাস করছেন?</td>
                                    <td style="border-bottom: 2px dotted #000;width: 12%;"></td>
                                    <td style="width: 6%;">মাস/বছর,</td>
                                    <td style="width: 11%;">
                                        ঘ.নিজস্ব বাড়ি/ভাড়া?
                                    </td>
                                    <td style="border-bottom: 2px dotted #000;width:15%;"></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-top: 7px;">
                            <table style="width:100%;" cellspacing="0">
                                <tr>
                                    <td style="width:13%;">
                                        ৪) স্থায়ী ঠিকানা:
                                    </td>
                                    <td style="border-bottom: 2px dotted #000;"></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-top: 7px;">
                            <table style="width:100%;" cellspacing="0">
                                <tr>
                                    <td style="width:8%;">
                                        ৫)ক.বয়স
                                    </td>
                                    <td style="border-bottom: 2px dotted #000;"></td>
                                    <td style="width: 4%;">বছর,</td>
                                    <td style="width: 14%;">খ.বৈবাহিক অবস্থা</td>
                                    <td style="border-bottom: 2px dotted #000;"></td>
                                    <td style="width: 14%;">গ.সন্তানের সংখ্যা</td>
                                    <td style="border-bottom: 2px dotted #000;"></td>
                                    <td style="width: 21%;">ঘ.অন্যান্য পোষ্যদের সংখ্যা:</td>
                                    <td style="border-bottom: 2px dotted #000;"></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-top: 7px;">
                            <table style="width:100%;" cellspacing="0">
                                <tr>
                                    <td style="width: 4%;">৬)ক.পেশা</td>
                                    <td style="border-bottom: 2px dotted #000;width: 20%;"></td>
                                    <td>খ.পদবী</td>
                                    <td style="border-bottom: 2px dotted #000;width: 20%;"></td>
                                    <td>গ.টেলিফোন/মোবাইল নং:</td>
                                    <td style="border-bottom: 2px dotted #000;width: 25%;"></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-top: 7px;">
                            <table style="width:100%;" cellspacing="0">
                                <tr>
                                    <td style="width:12%;">
                                        ঘ.মাসিক আয়:
                                    </td>
                                    <td style="border-bottom: 2px dotted #000;"></td>
                                    <td style="width: 28%;">ঙ.কতদিন বর্তমান পেশার সাথে যুক্ত:</td>
                                    <td style="border-bottom: 2px dotted #000;"></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-top: 7px;">
                            <table style="width:100%;" cellspacing="0">
                                <tr>
                                    <td style="width:33%;">
                                        চ.অফিস/ব্যবসা প্রতিষ্ঠানের নাম ও ঠিকানা:
                                    </td>
                                    <td style="border-bottom: 2px dotted #000;"></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-top: 7px;">
                            <table style="width:100%;" cellspacing="0">
                                <tr>
                                    <td style="width:38%;">
                                        ৭)Rangs ইলেকট্রনিক্স লিমিটেড এর বাজারজাতকৃত
                                    </td>
                                    <td style="border-bottom: 2px dotted #000;"></td>
                                    <td style="width: 15%;">ব্র্যান্ডের,মডেল নং:</td>
                                    <td style="border-bottom: 2px dotted #000;"></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-top: 7px;">
                            <table style="width:100%;" cellspacing="0">
                                <tr>
                                    <td style="width: 4%;">মূল্য:</td>
                                    <td style="border-bottom: 2px dotted #000;width: 20%;"></td>
                                    <td>Hire Purchase Scheme এ কেনার জন্য</td>
                                    <td style="border-bottom: 2px dotted #000;width: 29%;"></td>
                                    <td>
                                        কে নিশ্চয়তা দেয়া হলো।
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
                                        <table style="width:100%;" cellspacing="0">
                                            <tr>
                                                <td style="width: 39%;">৮)গ্রাহকের সাথে আপনার সম্পর্ক?</td>
                                                <td style="border-bottom: 2px dotted #000;"></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" style="padding-top: 7px;">৯)Hirer/কিস্তি গ্রহীতা যদি সময়মত
                                                    কোম্পানির বকেয়া টাকা পরিশোধ না করেন তাহলে প্রয়োজনীয় ব্যবস্থা এবং
                                                    সহযোগিতার মাধ্যমে সমাধান দিতে বাধ্য থাকব।</td>
                                            </tr>
                                            <tr>
                                                <td style="padding-top: 20px;">তারিখঃ</td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td style="border: 1px solid #000;padding: 5px;">
                                        <p style="text-align: center;">আমি নিশ্চয়তা প্রদান করছি যে
                                            Hirer এর তথ্যসমূহ সঠিক।
                                        </p>
                                        <br>
                                        <p style="border-top: 2px dotted #000;padding-top: 4px; text-align: center;">
                                            নিশ্চয়তাপ্রদানকারীর স্বাক্ষর</p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-top: 10px;">
                            <table>
                                <tr>
                                    <td>
                                        দরখাস্তকারীর উপরোল্লিখিত তথ্যসমূহ বিক্রয়ের পূর্বে যাচাই করা হয়েছে এবং সত্য বলে জানা গিয়েছে।
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-top: 55px;">
                            <table>
                                <tr>
                                    <td style="border-top: 2px dotted #000;padding-top: 4px; text-align: center;">
                                        শোরুমের নাম ও বিক্রয় প্রতিনিধির নাম</td>
                                    <td style="width: 43%;"></td>
                                    <td style="border-top: 2px dotted #000;padding-top: 4px; text-align: center;">
                                        শোরুম ইনচার্জের নাম,স্বাক্ষর ও সিল</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </tr>
        </tbody>
    </table> --}}
</div>

<script>
 //   window.print();
</script>