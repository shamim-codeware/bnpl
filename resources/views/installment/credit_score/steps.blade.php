@section('title', $title)
@section('description', $description)
@extends('layout.app')
@section('content')
    <div class="container-fluid">
        <div class="form-element">
            <div class="row">
                <div class="col-lg-12">
                    <form action="{{ url('/credit-score') }}" method="post" class="parent-assign">
                        @csrf
                        <div class="card card-default card-md mb-4">
                            <div class="card-header">
                                <h6>Credit Scoring Form Step-1</h6>
                            </div>
                            <div class="card-body py-md-30">
                                <div class="row">
                                    {{-- <div class="col-md-4 mb-25">
                                        <select name="ctp" id="ctp" class="form-control">
                                            <option value="">Select CTP</option>
                                            <option value="BADDA HOLLAND CENTER SHOWROOM">BADDA HOLLAND CENTER SHOWROOM
                                            </option>
                                            <option value="BAGERHAT SHOWROOM">BAGERHAT SHOWROOM</option>
                                        </select>
                                    </div> --}}
                                    <div class="col-md-4 mb-25">
                                        <label for="showroom_user_id" class="form-label">
                                            Sales Representative <span class="text-danger">*</span>
                                        </label>
                                        <select onchange="ReceivedSalesman()" required name="showroom_user_id"
                                            id="showroom_user_id" class="form-control">
                                            <option value="">Sales Representative</option>
                                            @foreach ($showroomusers as $key => $showroomuser)
                                                <option value="{{ $showroomuser->id }}">{{ $showroomuser->name }} -
                                                    {{ $showroomuser->code }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    {{-- <div class="col-md-4 mb-25">
                                        <select name="ctp" id="ctp" class="form-control">
                                            <option value="">Select CTP</option>
                                            <option value="BADDA HOLLAND CENTER SHOWROOM">BADDA HOLLAND CENTER SHOWROOM
                                            </option>
                                            <option value="BAGERHAT SHOWROOM">BAGERHAT SHOWROOM</option>
                                        </select>
                                    </div> --}}
                                </div>
                                <div class="col-md-4 mb-25">
                                    {{-- New checkbox --}}
                                    <div class="form-check mt-2">
                                        <input class="form-check-input" required type="checkbox" id="ack_incharge"
                                            name="ack_incharge" value="1">
                                        <label class="form-check-label" for="ack_incharge">
                                            Acknowledged by Showroom Incharge <span class="text-danger">*</span>
                                        </label>
                                    </div>
                                </div>
                                <table class="table pt-3 table-border credit_score_table mb-0">
                                    <thead>
                                        <tr class="userDatatable-header">
                                            <th colspan="2" style="text-align: left !important;"><span
                                                    class="userDatatable-title">Description</span></th>
                                            <th>
                                                <span class="userDatatable-title">YES</span>
                                            </th>
                                            <th>
                                                <span class="userDatatable-title">NO</span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="text-start">
                                            <td>
                                                <div style="width: 100%;height:100%;"
                                                    class="d-flex align-items-center justify-content-center">
                                                    1
                                                </div>
                                            </td>
                                            <td style="text-align: left !important;">Is the applicant in the Blacklist? <br>
                                                <small class="text_xs text-muted">(If YES, reject the application & if NO,
                                                    go to question no -2)</small>
                                            </td>
                                            <td>
                                                <input type="radio" name="blacklist" id="blacklist_yes" value="1" />
                                            </td>
                                            <td>
                                                <input type="radio" name="blacklist" id="blacklist_no" value="0" />
                                            </td>
                                        </tr>
                                        <tr class="text-start">
                                            <td>
                                                2
                                            </td>
                                            <td style="text-align: left !important;">Do you personnaly know that the
                                                Applicant is a bad creditor? <br>
                                                <small class="text_xs text-muted">(If YES, reject the application & if NO,
                                                    go to question no -3)</small>
                                            </td>
                                            <td>
                                                <input type="radio" name="bad_creditor" id="creditor_yes"
                                                    value="1" />
                                            </td>
                                            <td>
                                                <input type="radio" name="bad_creditor" id="creditor_no" value="0" />
                                            </td>
                                        </tr>
                                        <tr class="text-start">
                                            <td rowspan="2">
                                                3
                                            </td>
                                            <td style="text-align: left !important;">If the applicant provides NID of his
                                                own and mobile no- go to step-2 <br>
                                                <small class="text_xs text-muted">(If NOT, reject the application.)</small>
                                            </td>

                                            <td>
                                                <input type="radio" name="is_nid" value="0" />
                                            </td>
                                            <td>
                                                <input type="radio" name="is_nid" value="1" />
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                            </div>
                        </div>

                        <div class="card card-default card-md mb-4" id="step_two_form" style="display: none">
                            <div class="card-header">
                                <h6>Credit Scoring Form Step-2</h6>
                            </div>
                            <div class="card-body py-md-30">
                                <table class="table pt-3 table-border credit_score_table mb-0">
                                    <thead>
                                        <tr class="userDatatable-header">
                                            <th colspan="2" style="text-align: left !important;"><span
                                                    class="userDatatable-title">Description</span></th>
                                            <th>
                                                <span class="userDatatable-title">Scored</span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                1
                                            </td>
                                            <td style="text-align: left !important;">
                                                <select onchange="Calculate()" name="age" id="age"
                                                    class="form-control">
                                                    <option value="">AGE</option>
                                                    <option value="0">Below 18 years</option>
                                                    <option value="8">18-35 years</option>
                                                    <option value="10">35-50 years</option>
                                                    <option value="7">50 years above</option>
                                                </select>
                                            </td>
                                            <td id="age_score">0</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                2
                                            </td>
                                            <td style="text-align: left !important;padding-bottom:3px;">
                                                <select onchange="Calculate()" name="customer_status" id="customer_status"
                                                    class="form-control">
                                                    <option value="">CUSTOMER STATUS</option>
                                                    <option value="3">New</option>
                                                    <option value="4">Reference</option>
                                                    <option value="5">Old</option>
                                                </select>
                                            </td>
                                            <td id="customer_status_score">0</td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td style="padding-top:0;padding-bottom:0;">
                                                <small class="text_xs text-muted d-block text-start">(If old or previous
                                                    customer then his
                                                    payment status was good or bad? 5 of 0)</small>
                                            </td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                3
                                            </td>
                                            <td style="text-align: left !important;padding-bottom:3px;">
                                                <select onchange="Calculate()" name="monthly_income" id="monthly_income"
                                                    class="form-control">
                                                    <option value="">MONTHLY INCOME</option>
                                                    <option value="6">5,000 to 10,000</option>
                                                    <option value="7">10,000 to 20,000</option>
                                                    <option value="8">20,000 to 40,000</option>
                                                    <option value="9">40,000 to 60,000</option>
                                                    <option value="10">60,000 and above</option>
                                                </select>
                                            </td>
                                            <td id="monthly_income_score">0</td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td style="padding-top:0;padding-bottom:0;">
                                                <small class="text_xs text-muted d-block text-start">(Ratio of monthly
                                                    installment to net
                                                    disposable income should be 20% to 50%)</small>
                                            </td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                4
                                            </td>
                                            <td style="text-align: left !important;padding-bottom:3px;">
                                                <select onchange="Calculate()" name="profession" id="profession"
                                                    class="form-control">
                                                    <option value="">PROFESSION</option>
                                                    <option value="6">Business</option>
                                                    <option value="8">Private Job</option>
                                                    <option value="10">Govt. Job</option>
                                                    <option value="8">Others</option>
                                                </select>
                                            </td>
                                            <td id="profession_score">0</td>
                                        </tr>
                                        <tr>
                                            <td style="padding: 0;"></td>
                                            <td style="padding-top:0;padding-bottom:0;">
                                                <input type="text" id="otherProfession" name="other_profession"
                                                    class="form-control" style="display: none;"
                                                    placeholder="Enter Other Profession">
                                            </td>
                                            <td style="padding: 0;"></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                5
                                            </td>
                                            <td style="text-align: left !important;">
                                                <select onchange="Calculate()" name="length_profession" id="prof_length"
                                                    class="form-control">
                                                    <option value="">LENGTH OF PROFESSION</option>
                                                    <option value="6">Bellow 5 years</option>
                                                    <option value="8">5 years to 10 years</option>
                                                    <option value="10">10 years and above</option>
                                                </select>
                                            </td>
                                            <td id="prof_length_score">0</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                6
                                            </td>
                                            <td style="text-align: left !important;">
                                                <select onchange="Calculate()" name="family_size" id="family_size"
                                                    class="form-control">
                                                    <option value="">FAMILY SIZE(NUMBERS OF FAMILY MEMBERS)</option>
                                                    <option value="5">6 and above</option>
                                                    <option value="8">Up to 5</option>
                                                    <option value="10">Bellow 5</option>
                                                </select>
                                            </td>
                                            <td id="family_size_score">0</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                7
                                            </td>
                                            <td style="text-align: left !important;">
                                                <select onchange="Calculate()" name="residence_status" id="res_status"
                                                    class="form-control">
                                                    <option value="">RESIDENCE STATUS</option>
                                                    <option value="6">Rented (Staying bellow 02 years)</option>
                                                    <option value="8">Rented (Staying above 02 years)</option>
                                                    <option value="10">Own</option>
                                                    <option value="2">Permanent address of the applicant mentioned in
                                                        the application form</option>
                                                </select>
                                            </td>
                                            <td id="res_status_score">0</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                8
                                            </td>
                                            <td style="text-align: left !important;">
                                                <div class="select-style2">
                                                    <div style="height: 40px !important;"
                                                        class="form-control d-flex gap-3 align-items-center">
                                                        <div class="d-flex align-items-center flex-nowrap gap-2"><input
                                                                onclick="Calculate()" name="permanent_address_mentioned"
                                                                id="mn_padrs" value="2" type="checkbox" />
                                                            <label class="mt-0 text-uppercase" for="mn_padrs">Permanent
                                                                address of the applicant mentioned in the application
                                                                form?</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td id="permanent_address_mentioned_score">0</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                9
                                            </td>
                                            <td style="text-align: left !important;">
                                                <select onchange="Calculate()" name="distance" id="cus_distance"
                                                    class="form-control">
                                                    <option value="">DISTANCE OF CUSTOMER'S RESIDENCE FROM
                                                        CTP/PRODUCT USE</option>
                                                    <option value="10">Within 5km radius</option>
                                                    <option value="8">Within 10km radius</option>
                                                    <option value="0">Out of CTP authorized teritory</option>
                                                </select>
                                            </td>
                                            <td id="cus_distance_score">0</td>

                                        </tr>
                                        <tr>
                                            <td>
                                                10
                                            </td>
                                            <td style="text-align: left !important;">
                                                <select onchange="Calculate()" name="gaurantors" id="gurantors"
                                                    class="form-control">
                                                    <option value="">GUARANTORS</option>
                                                    <option value="0">Financially Insolvent</option>
                                                    <option value="6">Responsible solvent relative</option>
                                                    <option value="8">Local resposible solvent person</option>
                                                    <option value="10">Govt/Non Govt/Semi Govt Service holder office
                                                        colleague</option>
                                                </select>
                                            </td>
                                            <td id="gurantors_score">0</td>

                                        </tr>
                                        <tr>
                                            <td>
                                                11
                                            </td>
                                            <td style="text-align: left !important;">
                                                <select onchange="Calculate()" name="educational_qualification"
                                                    id="edu_qualify" class="form-control">
                                                    <option value="">EDUCATIONAL QUALIFICATIONS</option>
                                                    <option value="5">Bellow SSC of SSC</option>
                                                    <option value="8">Bellow HSC or HSC</option>
                                                    <option value="10">Graduate and above</option>
                                                </select>
                                            </td>
                                            <td id="edu_qualify_score">0</td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td>Total <span id="total_score">0</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="form-basic pt-3">
                                    <div id="capable_action" class="mb-3" style="display: none">Sorry, your credit
                                        score is too low. Only authorized individuals can process this offer</div>
                                    <div id="capable_action_msg" class="mb-3" style="display: none"> Congratulations!
                                        You are eligible for our exclusive Buy It Pay Later offer.</div>
                                    <div class="align-items-center flex-nowrap gap-2" id="approve_cust_id"
                                        style="display: none">
                                        <input name="is_approved_id" id="approve_cust" onclick="approveBySalesman()"
                                            type="checkbox" />
                                        <label class="my-0 text-uppercase" for="approve_cust"> <span
                                                id="sales_man_name"></span> have approved this consumer to receive the Buy
                                            It Pay Later offer</label>
                                    </div>
                                    {{-- <input type="text" id="approve_cs" name="approve_cs" class="form-control mt-2 mb-4 w-50" style="height:40px !important;" placeholder="Authorized Person"> --}}
                                    <button type="submit" id="sumit_btn"
                                        class="btn btn-lg btn-primary customr-btn btn-submit ms-auto">Save And
                                        Continue</button>
                                </div>
                                {{-- </form> --}}
                            </div>
                        </div>


                    </form>

                </div>
            </div>
        </div>
    </div>

    <script>
        function ReceivedSalesman() {
            var selectedOption = $('#showroom_user_id option:selected');
            var selectedName = selectedOption.text();
            var salesmanId = selectedOption.val();

            $("#sales_man_name").html(selectedName);
            $("#approve_cust").val(salesmanId);

        }


        function Calculate() {
            var age = $("#age").val() || 0;
            $("#age_score").html(age);

            var customer_status_score = $("#customer_status").val() || 0;
            $("#customer_status_score").html(customer_status_score);
            var monthly_income_score = $("#monthly_income").val() || 0;
            $("#monthly_income_score").html(monthly_income_score);
            var profession_score = $("#profession").val() || 0;
            $("#profession_score").html(profession_score);
            var prof_length_score = $("#prof_length").val() || 0;
            $("#prof_length_score").html(prof_length_score);
            var family_size_score = $("#family_size").val() || 0;
            $("#family_size_score").html(family_size_score);
            var res_status_score = $("#res_status").val() || 0;
            $("#res_status_score").html(res_status_score);
            var cus_distance_score = $("#cus_distance").val() || 0;
            $("#cus_distance_score").html(cus_distance_score);
            var gurantors_score = $("#gurantors").val() || 0;
            $("#gurantors_score").html(gurantors_score);
            var edu_qualify_score = $("#edu_qualify").val() || 0;
            $("#edu_qualify_score").html(edu_qualify_score);
            var permanent_address_mentioned_score = 0;
            if ($("#mn_padrs").is(":checked")) {
                permanent_address_mentioned_score = parseInt($("#mn_padrs").val());
                $("#permanent_address_mentioned_score").html(permanent_address_mentioned_score);
            }

            var total_score = parseInt(age) + parseInt(customer_status_score) + parseInt(monthly_income_score) + parseInt(
                profession_score) + parseInt(prof_length_score) + parseInt(family_size_score) + parseInt(
                res_status_score) + parseInt(cus_distance_score) + parseInt(gurantors_score) + parseInt(
                edu_qualify_score) + permanent_address_mentioned_score;


            $("#total_score").html(total_score);

            if (total_score < 60) {
                $("#capable_action").css({
                    'display': 'block',
                });
                $("#approve_cust_id").css({
                    'display': 'block'
                });
                $("#sumit_btn").css({
                    'display': 'none'
                });
                $("#capable_action_msg").css({
                    'display': 'none'
                });
            } else {

                $("#capable_action").css({
                    'display': 'none',
                });
                $("#approve_cust_id").css({
                    'display': 'none'
                });
                $("#sumit_btn").css({
                    'display': 'block'
                });
                $("#capable_action_msg").css({
                    'display': 'block'
                });

            }


        }

        function approveBySalesman() {

            if ($("#approve_cust").is(":checked")) {
                $("#sumit_btn").css({
                    'display': 'block'
                });
            } else {
                $("#sumit_btn").css({
                    'display': 'none'
                });
            }
        }

        $(document).ready(function() {
            // $('input[name="is_blacklist"], input[name="bad_creditor"], input[name="is_nid"]').click(function() {
            //     var anyYes = false;

            //     $('input[name="is_blacklist"], input[name="bad_creditor"], input[name="is_nid"]').each(function() {
            //         if ($(this).is(':checked') && $(this).val() === '1') {
            //             anyYes = true;
            //         }else{

            //         }
            //     });

            //     if (anyYes) {
            //         $('#step_two_form').hide();
            //     } else {
            //         $('#step_two_form').show();
            //     }
            // });

            $('input[name="blacklist"], input[name="bad_creditor"], input[name="is_nid"]').click(function() {
                // Initialize flag to check if any radio button is set to "yes"
                var anyYes = false;

                // Check each radio button group
                $('input[name="blacklist"], input[name="bad_creditor"], input[name="is_nid"]').each(
                    function() {
                        if ($(this).is(':checked') && $(this).val() === '1') {
                            anyYes = true; // If "yes" is selected, set flag to true
                        }
                    });

                // Show the form only if none of the radio buttons are set to "yes"
                if (!anyYes) {
                    $('#step_two_form').show();
                } else {
                    $('#step_two_form').hide();
                }
            });



        });


        $(document).ready(function() {
            $('#profession').change(function() {

                var selectedOption = $('#profession option:selected');
                var selectedName = selectedOption.text();

                if (selectedName == 'Others') {
                    $('#otherProfession').show().focus();
                } else {
                    $('#otherProfession').hide();
                }
            });
        });
    </script>

@endsection
