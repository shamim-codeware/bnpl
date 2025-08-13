@section('title', $title)
@section('description', $description)
@extends('layout.app')

@section('content')
    <div class="container-fluid">
        <div class="form-element">
            <div class="row">
                <form action="{{ url('guarantor') }}" method="post" class="parent-assign">
                    @csrf
                    <div class="col-lg-12">
                        @foreach($gurantors as $key=>$gurantor)
                        <div class="card card-default card-md mb-4 grntr_card">
                            <div class="card-header">
                                <h6>
                                    @if($key==1) Second Guarantor @else First Guarantor @endif
                                </h6>
                                <input type="hidden" name="id[]" value="{{ $gurantor->id }}">
                            </div>
                            <div class="card-body py-md-30">
                                <div class="form-group">
                                    <fieldset>
                                        <legend>Personal Information:</legend>
                                        <div class="row">
                                            <div class="col-md-3 mb-25">
                                                <div class="holder">
                                                    <div class="input-holder">
                                                        <input required value="{{ $gurantor->guarater_name }}" name="guarater_name[]" id="name" class="input" type="text" placeholder=" " />
                                                        <div class="placeholder">
                                                            <p class="m-0">Name Mr/Mrs/Ms<span class="text-danger">*</span></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-25">
                                                <div class="row align-items-center">
                                                    <div class="col-md-3 pe-0 rounded-r-0">
                                                        <select required name="guarater_relation[]" id="fhw_name" class="form-control">
                                                            <option value="">Select</option>
                                                            <option @if($gurantor->guarater_relation == "father") @selected(true) @endif value="father">Father</option>
                                                            <option @if($gurantor->guarater_relation == "husband") @selected(true) @endif value="husband">Husband</option>
                                                            <option @if($gurantor->guarater_relation == "wife") @selected(true) @endif value="wife">Wife</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-9 ps-0">
                                                        <div class="holder">
                                                            <div class="input-holder">
                                                                <input required name="guarater_relation_name[]" value="{{ $gurantor->guarater_relation_name }}" id="name" class="input rounded-l-0 border-start-0" type="text" placeholder=" " />
                                                                <div class="placeholder">
                                                                    <p class="m-0">Father/Spouse name<span class="text-danger">*</span></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-25">
                                                <select required name="age[]" id="age_{{ $key }}" class="form-control">
                                                    <option value="">Age</option>
                                                    @for($i=12;$i<=80;$i++)
                                                    <option @if($gurantor->age == $i) @selected(true) @endif value="{{ $i }}">{{ $i }}</option>
                                                    @endfor
                                                </select>
                                            </div>
                                            <div class="col-md-3 pe-0 mb-25">
                                                <select required name="marital_status[]" onchange="maritalStatusChange({{ $key }})" id="marital_status_{{ $key }}" class="form-control">
                                                    <option value="">Marital status</option>
                                                    <option @if($gurantor->marital_status == "unmarried") @selected(true) @endif value="unmarried">Unmarried</option>
                                                    <option @if($gurantor->marital_status == "married") @selected(true) @endif value="married">Married</option>
                                                    <option @if($gurantor->marital_status == "divorced") @selected(true) @endif value="divorced">Divorced</option>
                                                    <option @if($gurantor->marital_status == "widowed") @selected(true) @endif value="widowed">Widowed</option>
                                                    <option @if($gurantor->marital_status == "separated") @selected(true) @endif value="separated">Separated</option>
                                                </select>
                                            </div>
                                                <div class="col-md-3 mb-25" id="number_children_show_{{ $key }}">
                                                    <div class="holder">
                                                        <div class="input-holder">
                                                            <input name="number_of_children[]" id="children_num" value="{{ $gurantor->number_of_children }}" class="input" type="number" placeholder="" />
                                                            <div class="placeholder">
                                                                <p class="m-0">Number of children:<span class="text-danger">*</span></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                          
                                            <div class="col-md-4 mb-25">
                                                <div class="holder">
                                                    <div class="input-holder">
                                                        <input required value="{{ $gurantor->other_family_member }}" name="other_family_member[]" id="other_pets" class="input" type="number" placeholder="" />
                                                        <div class="placeholder">
                                                            <p class="m-0">Other Family Members:<span class="text-danger">*</span></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                    <fieldset class="mt-4">
                                        <legend>Address:</legend>
                                        <div class="row">
                                            <div class="col-md-6 mb-25">
                                                <div class="holder">
                                                    <div class="input-holder">
                                                        <textarea required class="input" style="resize: none;" name="guarater_address_present[]" id="" cols="30" rows="1">{{ $gurantor->guarater_address_present }}</textarea>
                                                        <div class="placeholder">
                                                            <p class="m-0">Present Address:<span class="text-danger">*</span></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-25">
                                                <div class="holder">
                                                    <div class="input-holder">
                                                        <input required value="{{ $gurantor->guarater_phone }}" name="guarater_phone[]" id="mobile" class="input" type="number" placeholder="Enter 11 digit Mobile Number" />
                                                        <div class="placeholder">
                                                            <p class="m-0">Mobile No:<span class="text-danger">*</span></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-25">
                                                <div class="holder">
                                                    <div class="input-holder">
                                                        <input required value="{{ $gurantor->duration_of_staying }}" name="duration_of_staying[]" id="d_staying" class="input" type="text" placeholder="Months/Years" />
                                                        <div class="placeholder">
                                                            <p class="m-0">Duration of staying:<span class="text-danger">*</span></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-25">
                                                <select required name="residense_status[]" id="rs_status" class="form-control">
                                                    <option value="">Residence Status</option>
                                                    <option @if($gurantor->residense_status == "rent") @selected(true) @endif value="rent">Rent</option>
                                                    <option @if($gurantor->residense_status == "own") @selected(true) @endif value="own">Own</option>
                                                </select>
                                            </div>
                                            <div class="col-md-9 mb-25">
                                                <div class="holder">
                                                    <div class="input-holder">
                                                        <textarea required class="input" style="resize: none;" name="guarater_address_permanent[]" id="" cols="30" rows="1">{{ $gurantor->guarater_address_permanent }}</textarea>
                                                        <div class="placeholder">
                                                            <p class="m-0">Permanent Address:<span class="text-danger">*</span></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                    <fieldset class="mt-4">
                                        <legend>Professional Information:</legend>
                                        <div class="row">
                                            <div class="col-md-3 mb-25">
                                                <select required name="proffession_id[]" id="profession" class="form-control">
                                                    <option value="">Select Profession</option>
                                                    @foreach($customers_professions as $key=>$customers_profession)
                                                    <option @if($gurantor->proffession_id == $customers_profession->id) @selected(true) @endif value="{{ $customers_profession->id }}">{{ $customers_profession->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-3 mb-25">
                                                <div class="holder">
                                                    <div class="input-holder">
                                                        <input required value="{{ $gurantor->designation }}" name="designation[]" id="designation" class="input" type="text" placeholder="" />
                                                        <div class="placeholder">
                                                            <p class="m-0">Designation<span class="text-danger">*</span></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-25">
                                                <div class="holder">
                                                    <div class="input-holder">
                                                        <input value="{{ $gurantor->profession_phone }}" required name="profession_phone[]" id="mobile" class="input" type="number" placeholder="Enter 11 digit Mobile Number"/>
                                                        <div class="placeholder" >
                                                            <p class="m-0">Mobile No:<span class="text-danger">*</span></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-25">
                                                <div class="holder">
                                                    <div class="input-holder">
                                                        <input required name="monthly_income[]" id="month_income" class="input" value="{{ $gurantor->monthly_income }}" type="number" placeholder=" " />
                                                        <div class="placeholder">
                                                            <p class="m-0">Monthly Income (BDT):<span class="text-danger">*</span></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-25">
                                                <div class="holder">
                                                    <div class="input-holder">
                                                        <input required name="duration_current_profession[]" id="current_prof" class="input" value="{{ $gurantor->duration_current_profession }}" type="text" placeholder="" />
                                                        <div class="placeholder">
                                                            <p class="m-0">Duration of Current Profession (Months/Years)<span class="text-danger">*</span></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-25">
                                                <div class="holder">
                                                    <div class="input-holder">
                                                        <textarea required class="input" style="resize: none;" name="name_address_office[]" id="" cols="30" rows="1">{{ $gurantor->name_address_office }}</textarea>
                                                        <div class="placeholder">
                                                            <p class="m-0">Name and address of office/business:<span class="text-danger">*</span></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                    <fieldset class="mt-4">
                                        <legend>Acknowledgment:</legend>
                                        <div class="row">
                                            <div class="col-md-3 mb-25">
                                                <select required name="relation[]" id="cust_relation_{{ $key }}" class="form-control">
                                                    <option value="">Relation with Customer</option>
                                                    <option @if($gurantor->relation == "Brother") @selected(true) @endif value="Brother">Brother</option>
                                                    <option @if($gurantor->relation == "cousin") @selected(true) @endif value="cousin">Cousin</option>
                                                     <option @if($gurantor->relation == "friend") @selected(true) @endif value="friend">Friend</option>
                                                    <option @if($gurantor->relation == "neighbor") @selected(true) @endif value="neighbor">Neighbor</option>
                                                     <option @if($gurantor->relation == "uncle") @selected(true) @endif value="uncle">Uncle</option>
                                                     <option @if($gurantor->relation == "brother_in_law") @selected(true) @endif value="brother_in_law">Brother in law</option>
                                                </select>
                                            </div>
                                            <div class="col-md-12 mb-25">
                                                <div class="select-style2">
                                                    <div class="form-control d-flex gap-3 align-items-center">
                                                        <p class="mb-0">If the Hirer/installment receiver does not pay the amount due to the Company on time, then I will be obliged to resolve it through necessary measures and cooperation.</p>
                                                        <div class="d-flex align-items-center flex-nowrap gap-2">
                                                            <input required name="bought_before" value="1" id="yes_{{ $key }}"  type="checkbox" /> 
                                                            <label class="mt-0">Yes</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <button type="submit" class="btn btn-lg btn-primary customr-btn btn-submit ms-auto">Submit</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function maritalStatusChange(key){
            marital_status =   $("#marital_status_"+key).val()
                if(marital_status == 'married'){

                    $("#number_children_show_"+key).show();
                    // $("#number_of_children").show();
                }else{

                    $("#number_children_show_"+key).hide();
                }
            }
    </script>
@endsection
