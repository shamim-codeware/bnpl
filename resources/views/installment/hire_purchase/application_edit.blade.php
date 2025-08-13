@section('title', $title)
@section('description', $description)
@extends('layout.app')

@section('content')
    <div class="container-fluid">
        <div class="form-element">
            <form action="{{ url('product_update') }}" method="post" enctype="multipart/form-data" class="parent-assign">
                @csrf
                
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card card-default card-md mb-4 purchase_app">
                            <div class="card-header">
                                <h6>Buy Now Pay Later Form</h6>
                            </div>
                            <div class="card-body py-md-30">
                                <div class="form-group">
                                    <fieldset class="">
                                        <legend>Personal Information:</legend>
                                        <div class="row">
                                            {{-- <div class="col-md-6 mb-25">
                                                <select name="showroom_user_id" id="showroom_user_id" class="form-control">
                                                    <option value="">Select Show Room User</option>
                                                    @foreach ($showroomusers as $key => $showroomuser)
                                                    <option value="{{ $showroomuser->id }}">{{ $showroomuser->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div> --}}

                                            <div class="col-md-6 mb-25">
                                                <div class="holder">
                                                    <div class="input-holder">
                                                        <input type="hidden" name="hirepurchase_id" value="{{ $hirepurchase->id }}">
                                                        <input required name="name" id="name" class="input"
                                                            type="text" value="{{ old('name', $hirepurchase->name) }}"
                                                            placeholder=" " />
                                                        <div class="placeholder">
                                                            <p class="m-0">Applicant's full name (With Surename)<span
                                                                    class="text-danger">*</span></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-25">
                                                <div class="holder">
                                                    <div class="input-holder">
                                                        <input required name="fathers_name" id="name" class="input"
                                                            type="text"
                                                            value="{{ old('fathers_name', $hirepurchase->fathers_name )}}"
                                                            placeholder=" " />
                                                        <div class="placeholder">
                                                            <p class="m-0">Father's Name<span
                                                                    class="text-danger">*</span></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-25">
                                                <div class="holder">
                                                    <div class="input-holder">
                                                        <input name="mothers_name" id="name" class="input"
                                                            type="text"
                                                            value="{{ old('mothers_name', $hirepurchase->mothers_name) }}"
                                                            placeholder=" " />
                                                        <div class="placeholder">
                                                            <p class="m-0">Mother's Name</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-25">
                                                <div class="holder">
                                                    <div class="input-holder">
                                                        <input name="spouse_name" id="name" class="input" type="text"
                                                            value="{{ old('spouse_name', $hirepurchase->spouse_name) }}"
                                                            placeholder=" " />
                                                        <div class="placeholder">
                                                            <p class="m-0">Spouse Name</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-25">
                                                <select required name="age" id="age" class="form-control">
                                                    <option value="">Age</option>
                                                    @for ($i = 18; $i <= 80; $i++)
                                                        <option value="{{ $i }}"
                                                            @if ($hirepurchase->age == $i) selected @endif>
                                                            {{ $i }}
                                                        </option>
                                                    @endfor
                                                </select>

                                            </div>
                                            <div class="col-md-3 mb-25">
                                               <select required onchange="maritalStatusChange()" name="marital_status" id="marital_status" class="form-control">
                                                    <option value="">Marital status</option>
                                                    <option value="Unmarried" @if(old('marital_status', $hirepurchase->marital_status) == 'Unmarried') selected @endif>Unmarried</option>
                                                    <option value="married" @if(old('marital_status', $hirepurchase->marital_status) == 'married') selected @endif>Married</option>
                                                    <option value="divorced" @if(old('marital_status', $hirepurchase->marital_status) == 'divorced') selected @endif>Divorced</option>
                                                    <option value="widowed" @if(old('marital_status', $hirepurchase->marital_status) == 'widowed') selected @endif>Widowed</option>
                                                    <option value="separated" @if(old('marital_status', $hirepurchase->marital_status) == 'separated') selected @endif>Separated</option>
                                                </select>


                                            </div>
                                            <div class="col-md-6 mb-25">
                                                <div class="row align-items-center">
                                                    <div class="col-md-7 pe-0">
                                                        <div class="holder">
                                                            <div class="input-holder">
                                                                <input required name="nid" id="nid"
                                                                    class="input rounded-r-0" type="number" value="{{ old('nid', $hirepurchase->nid) }}"
                                                                    placeholder=" " />
                                                                <div class="placeholder">
                                                                    <p class="m-0">National ID No:<span
                                                                            class="text-danger">*</span></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-5 ps-0">
                                                        <div class="holder">
                                                            <div class="input-holder input border-start-0 rounded-l-0 upload_holder">
                                                               
                                                                <input type="file" name="file" id="file" onchange="document.getElementById('preview').src = window.URL.createObjectURL(this.files[0])
                                                                    class="inputfile"
                                                                    data-multiple-caption="{count} files selected"
                                                                    multiple />
                                                                      <img id="preview" src="{{ asset($hirepurchase->nid_image) }}" alt="your image" width="100" height="100" />
                                                                <label for="file"><span><i class="uil uil-upload"></i></span></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-25 d-flex align-items-center">
                                                <span>Upload PDF JPG or PNG format.</span>
                                            </div>
                                        </div>
                                    </fieldset>
                                    <fieldset class="mt-4">
                                        <legend>Present Address:</legend>
                                        <div class="row">
                                            <div class="col-md-4 mb-25">
                                                <div class="holder">
                                                    <div class="input-holder">
                                                        <input required name="pr_house_no" value="{{ old('pr_house_no', $hirepurchase->pr_house_no) }}" id="pr_village" class="input"
                                                            type="text" placeholder=" " />
                                                        <div class="placeholder">
                                                            <p class="m-0">House No and Village<span
                                                                    class="text-danger">*</span></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-25">
                                                <div class="holder">
                                                    <div class="input-holder">
                                                        <input required name="pr_road_no" id="pr_postoffice" value="{{ old('pr_road_no', $hirepurchase->pr_road_no) }}"
                                                            class="input" type="text" placeholder=" " />
                                                        <div class="placeholder">
                                                            <p class="m-0">Road No and Postoffice<span
                                                                    class="text-danger">*</span></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-25">
                                                <select required name="pr_district_id" onchange="FindDistrictPre('rs')"
                                                    id="rs_district" class="form-control select-district">
                                                 <option value="">Select District</option>
                                                @foreach($all_district as $district)
                                                    <option value="{{ $district->id }}" @if(old('pr_district_id', $pr_district->id) == $district->id) selected @endif>
                                                        {{ $district->en_name }}
                                                    </option>
                                                @endforeach

                                                </select>
                                            </div>
                                            <div class="col-md-3 mb-25">
                                                <select required name="pr_upazila_id" id="rs_thana"
                                                    class="form-control Select-upazila">
                                                    <option value="">Select Thana</option>
                                                    @foreach($all_upazilas as $upazila)
                                                    <option value="{{ $upazila->id }}" @if(old('pr_upazila_id', $pr_upazilapr->id) == $upazila->id) selected @endif>{{ $upazila->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-3 mb-25">
                                                <div class="holder">
                                                    <div class="input-holder">
                                                        <input required name="pr_phone" id="pr_mobile" value="{{ old('pr_phone', $hirepurchase->pr_phone) }}" class="input"
                                                            type="number" placeholder="Enter 11 digit Mobile Number" />
                                                        <div class="placeholder">
                                                            <p class="m-0">Mobile No:<span class="text-danger">*</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-25">
                                                <select required name="pr_residence_status" id="rs_status"
                                                    class="form-control">
                                                    <option value="">Residence Status</option>
                                                    <option value="rent" @if($hirepurchase->pr_residence_status == "rent") selected @endif>Rent</option>
                                                    <option value="own" @if($hirepurchase->pr_residence_status == "own") selected @endif>Own</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3 mb-25">
                                                <div class="holder">
                                                    <div class="input-holder">
                                                        <input required name="pr_duration_staying" value="{{ old('pr_duration_staying', $hirepurchase->pr_duration_staying) }}" id="d_staying"
                                                            class="input" type="text" placeholder="Months/Years" />
                                                        <div class="placeholder">
                                                            <p class="m-0">Duration of staying:<span
                                                                    class="text-danger">*</span></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>

                                    <fieldset class="mt-4">
                                        <legend style="white-space: nowrap;" class="d-flex align-items-center gap-2">
                                            Permanent Address:
                                            <div class="form-control d-flex gap-3 align-items-center">
                                                <p class="mb-0">Same as Present Address?:</p>
                                                <div><input id="same_p_addrs" name="same_p_addrs" value="1"
                                                        type="checkbox" /> <label for="same_p_addrs">Yes</label></div>
                                            </div>
                                        </legend>
                                        <div class="row mt-2 permanent_adrs_row">
                                            <div class="col-md-3 mb-25">
                                                <div class="holder">
                                                    <div class="input-holder">
                                                        <input name="pa_house_no" value="{{ old('pa_house_no', $hirepurchase->pa_house_no) }}" id="pa_village" class="input"
                                                            type="text" placeholder=" " />
                                                        <div class="placeholder">
                                                            <p class="m-0">House No and Village<span
                                                                    class="text-danger">*</span></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-25">
                                                <div class="holder">
                                                    <div class="input-holder">
                                                        <input name="pa_road_no" value="{{ old('pa_road_no', $hirepurchase->pa_road_no) }}" id="pr_postoffice" class="input"
                                                            type="text" placeholder=" " />
                                                        <div class="placeholder">
                                                            <p class="m-0">Road No and Postoffice<span
                                                                    class="text-danger">*</span></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-25">
                                                <select name="pa_district_id" onchange="FindDistrictPre('padrs')"
                                                    id="padrs_district" class="form-control select-district">
                                                    <option value="">Select District</option>
                                                  @foreach($all_district as $district)
                                                    <option value="{{ $district->id }}" @if(old('pa_district_id', $pa_district->id ) == $district->id) selected @endif>{{ $district->en_name }}   </option>
                                                   @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-3 mb-25">
                                                <select name="pa_upazila_id" id="padrs_thana" class="form-control">
                                                    <option value="">Select Thana</option>
                                                     @foreach($all_upazilas as $upazila)
                                                    <option value="{{ $upazila->id }}" @if(old('pa_upazila_id', $pa_upazilapa->id ) == $upazila->id) selected @endif>{{ $upazila->name }}   </option>
                                                   @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-3 mb-25">
                                                <div class="holder">
                                                    <div class="input-holder">
                                                        <input name="pa_phone" value="{{ old('pa_phone', $hirepurchase->pa_phone) }}" id="pa_mobile" class="input"
                                                            type="number" placeholder="Enter 11 digit Mobile Number" />
                                                        <div class="placeholder">
                                                            <p class="m-0">Mobile No:<span class="text-danger">*</span>
                                                            </p>
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
                                                <select required name="profession_id" id="profession"
                                                    class="form-control">
                                               <option value="">Select Profession</option>
                                                    @foreach ($all_customer_profession as $profession)
                                                        <option value="{{ $profession->id }}" @if(old('profession_id', $customer_profession->id) == $profession->id) selected @endif>{{ $profession->name }}</option>
                                                    @endforeach
                                                </select>

                                            </div>
                                            <div class="col-md-3 mb-25">
                                                <div class="holder">
                                                    <div class="input-holder">
                                                        <input required name="designation" value="{{ old('designation', $hirepurchase->designation) }}" id="designation"
                                                            class="input" type="text" placeholder="" />
                                                        <div class="placeholder">
                                                            <p class="m-0">Designation<span
                                                                    class="text-danger">*</span></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-25">
                                                <div class="holder">
                                                    <div class="input-holder">
                                                        <input required name="duration_current_profe" value="{{ old('duration_current_profe',$hirepurchase->duration_current_profe) }}" id="current_prof"
                                                            class="input" type="text" placeholder="" />
                                                        <div class="placeholder">
                                                            <p class="m-0">Duration of Current Profession
                                                                (Months/Years)<span class="text-danger">*</span></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-25">
                                                <div class="holder">
                                                    <div class="input-holder">
                                                        <input required name="organization_name" value="{{ old('organization_name', $hirepurchase->organization_name) }}" id="organization"
                                                            class="input" type="text" placeholder="" />
                                                        <div class="placeholder">
                                                            <p class="m-0">Organization Name<span
                                                                    class="text-danger">*</span></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-25">
                                                <div class="holder">
                                                    <div class="input-holder">
                                                        <input required name="organization_short_desc" value="{{ old('organization_short_desc', $hirepurchase->organization_short_desc) }}" id="job_desc"
                                                            class="input" type="text" placeholder=" " />
                                                        <div class="placeholder">
                                                            <p class="m-0">Organization Short Description:<span
                                                                    class="text-danger">*</span></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-25">
                                                <div class="holder">
                                                    <div class="input-holder">
                                                        <input required name="org_house_no" value="{{ old('org_house_no', $hirepurchase->org_house_no) }}" id="org_village"
                                                            class="input" type="text" placeholder=" " />
                                                        <div class="placeholder">
                                                            <p class="m-0">House No and Village<span
                                                                    class="text-danger">*</span></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-25">
                                                <div class="holder">
                                                    <div class="input-holder">
                                                        <input required name="org_road_no" value="{{ old('org_road_no', $hirepurchase->org_road_no) }}" id="org_postoffice"
                                                            class="input" type="text" placeholder=" " />
                                                        <div class="placeholder">
                                                            <p class="m-0">Road No and Postoffice<span
                                                                    class="text-danger">*</span></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-25">
                                                <select required name="org_district_id" onchange="FindDistrictPre('prof')"
                                                    id="prof_district" class="form-control">
                                                    <option value="">Select District</option>
                                                    @foreach ($all_district as $district)
                                                        <option value="{{ $district->id }}" @if(old('org_district_id', $district_org->id) == $district->id) selected @endif>{{ $district->en_name }}</option>
                                                    @endforeach

                                                </select>
                                            </div>
                                            <div class="col-md-4 mb-25">
                                                <select required name="org_upazila_id" id="prof_thana"
                                                    class="form-control">
                                                    <option value="">Select Thana</option>
                                                    @foreach ($all_upazilas as $upazila)
                                                     <option value="{{ $upazila->id }}" @if(old('org_upazila_id', $upazila_org->id) == $upazila->id) selected @endif>{{ $upazila->name }}</option>
                    
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-3 mb-25">
                                                <div class="holder">
                                                    <div class="input-holder">
                                                        <input required name="org_phone" value="{{ old('org_phone', $hirepurchase->org_phone) }}" id="org_mobile" class="input"
                                                            type="number" placeholder="Enter 11 digit Mobile Number" />
                                                        <div class="placeholder">
                                                            <p class="m-0">Mobile No:<span class="text-danger">*</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-25">
                                                <div class="holder">
                                                    <div class="input-holder">
                                                        <input required name="month_income" value="{{ old('month_income', $hirepurchase->month_income) }}" id="month_income"
                                                            class="input" type="number" placeholder=" " />
                                                        <div class="placeholder">
                                                            <p class="m-0">Monthly Income (BDT):<span
                                                                    class="text-danger">*</span></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                    <fieldset class="mt-4">
                                        <legend>Family Details:</legend>
                                        <div class="row">
                                            <div class="col-md-4 mb-25">
                                                <div class="holder">
                                                    <div class="input-holder">
                                                        <input required name="other_family_member" value="{{ old('other_family_member', $hirepurchase->other_family_member) }}" id="other_pets"
                                                            class="input" type="number" placeholder="" />
                                                        <div class="placeholder">
                                                            <p class="m-0">Other Family Members:<span
                                                                    class="text-danger">*</span></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-25">
                                                <div class="holder">
                                                    <div class="input-holder" id="number_ofChilder_showing">
                                                        <input name="number_of_children" value="{{ old('number_ofChilder_showing', $hirepurchase->number_of_children) }}" id="children_num" class="input"
                                                            type="number" placeholder="" />
                                                        <div class="placeholder">
                                                            <p class="m-0">Number of children:
                                                                <span class="text-danger">*</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @php $family = json_decode($hirepurchase->name_age_family_member) @endphp
                                            {{-- @dd($family ) --}}
                                            <div class="col-md-12 mb-25">
                                                <div class="card p-3" id="number_of_children_container">
                                                    <h6 class="mb-1 fw-normal">Names and Ages of Spouse and children:</h6>
                                                    
                                                   @foreach ($family as $member)
                                                   {{-- <input type="hidden" name="member_ids[]" value="{{ $member->id }}"> --}}
                                                        <div class="row mt-3 align-items-center" id="number_of_children">
                                                                <div class="col-md-3">
                                                                    <div class="holder">
                                                                        <div class="input-holder">
                                                                            <input name="mem_name[]" value="{{ old('mem_name', $member->name) }}" id="name[]"
                                                                                class="input" type="text" placeholder="" />
                                                                            <div class="placeholder">
                                                                                <p class="m-0">Name:<span
                                                                                        class="text-danger">*</span></p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <select name="mem_relation[]" id="relation[]"
                                                                        class="form-control relation_select">
                                                                        <option class="rel_option" value="">Relation *
                                                                        </option>
                                                                        <option value="husband" @if(old('mem_relation', $member->relation) ==  "husband") selected @endif>Husband</option>
                                                                        <option value="wife" @if(old('mem_relation', $member->relation) ==  "wife") selected @endif>Wife</option>
                                                                        <option value="children" @if(old('mem_relation', $member->relation) ==  "children") selected @endif>Children</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="holder">
                                                                        <div class="input-holder">
                                                                            <input name="mem_age[]" value="{{ old('mem_age', $member->age) }}" id="age[]" class="input"
                                                                                type="text" placeholder="" />
                                                                            <div class="placeholder">
                                                                                <p class="m-0">Age:<span
                                                                                        class="text-danger">*</span></p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <button type="button"
                                                                        class="btn btn-primary w-30 add-row">Add more</button>
                                                                </div>
                                                        </div>
                                                   @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                    <fieldset class="mt-4">
                                        <legend>Product Information:</legend>
                                        <div class="row">
                                            {{-- <div class="col-md-4 mb-25">
                                                        <select name="product_name" id="purchs_item" class="form-control">
                                                            <option value="">Product Name</option>
                                                            @foreach ($products as $key => $product)
                                                            <option value="{{ $product->name }}">{{ $product->name }}</option>
                                                             @endforeach 
                                                        </select>
                                                    </div> --}}
                                            {{-- <div class="col-md-3 mb-25">
                                                        <div class="holder">
                                                            <div class="input-holder">
                                                                <input required name="sell_price" id="selling_price"
                                                                    class="input" type="number" placeholder=" " />
                                                                <div class="placeholder">
                                                                    <p class="m-0">Selling price<span
                                                                            class="text-danger">*</span></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div> --}}
                                            <div class="col-md-9 mb-25">
                                                <div class="select-style2">
                                                    <div class="form-control d-flex gap-3 align-items-center">
                                                        <p class="mb-0">Has any Rang's products been previously purchased
                                                            through rent or instalment plans?:</p>
                                                      <div>
                                                            <input id="yes" name="previously_purchased" value="1" type="radio" @if($hirepurchase->previously_purchased == 1) checked @endif /> 
                                                            <label for="yes">Yes</label>
                                                        </div>
                                                        <div>
                                                            <input id="no" name="previously_purchased" value="0" type="radio" @if($hirepurchase->previously_purchased == 0) checked @endif /> 
                                                            <label for="no">No</label>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12 previously_bought" style="display: none;">
                                                <!-- Your previously bought content here -->
                                                <div class="row">
                                                    <div class="col-md-4 mb-25">
                                                        <select name="pre_b_product_id" id="product_bought"
                                                            class="form-control">
                                                            <option value="">Product Name</option>

                                                            <option value="others">Others</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3" id="type_product" style="display: none">
                                                        <input type="text" class="form-control" name="type_product"
                                                            placeholder="Please Enter Product Name ">
                                                    </div>
                                                    <div class="col-md-3 mb-25">
                                                        <div class="holder">
                                                            <div class="input-holder">
                                                                <input name="pre_purchase_date" id="cus_selling_price"
                                                                    class="input" type="date" placeholder=" " />
                                                                <div class="placeholder">
                                                                    <p class="m-0">Date of purchase:<span
                                                                            class="text-danger">*</span></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-5 mb-25">
                                                        <select name="pp_showroom_id" id="showroom"
                                                            class="form-control">
                                                            <option value="">Showroom</option>

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-25">
                                                <div class="holder">
                                                    <div class="input-holder">
                                                        <input name="shipping_address" value="{{ old('shipping_address', $hirepurchase->shipping_address) }}" id="s_address" class="input"
                                                            type="text" placeholder=" " />
                                                        <div class="placeholder">
                                                            <p class="m-0">Address that you will use for this
                                                                purchase?:<span class="text-danger">*</span></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-25">
                                                <div class="holder">
                                                    <div class="input-holder">
                                                        <input name="distance_from_showroom" value="{{ old('distance_from_showroom', $hirepurchase->distance_from_showroom) }}" id="distance"
                                                            class="input" type="number" placeholder="Kilometer" />
                                                        <div class="placeholder">
                                                            <p class="m-0">Showroom distance from the mentioned
                                                                address?:<span class="text-danger">*</span></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
    
                                    </fieldset>
                            
                                    <fieldset class="mt-4">
                                        <legend>Guarantor Information:</legend>
                                        <p>Names and addresses of 2 persons who are not your relatives who will be your
                                            guarantors or sureties willing to pay the dues in the absence of the customer
                                        </p>
                                       
                                        @foreach ($guarenter_info as $key => $info)
                                          <input type="hidden" name="gaurenter_ids[]" value="{{ $info->id }}">
                                            <div class="card p-3 mb-25 lgnd_card">
                                                <h6 class="lgnd_text">{{ ucfirst(\App\Helpers\Helper::ordinal($loop->iteration)) }} Guarantor:</h6>
                                                <div class="row mt-2">
                                                    <div class="col-md-3 mb-25">
                                                        <div class="holder">
                                                            <div class="input-holder">
                                                                <input required name="guarater_name[]" value="{{ old('guarater_name', $info->guarater_name) }}" id="guarater_one_name"
                                                                    class="input" type="text" placeholder=" " />
                                                                <div class="placeholder">
                                                                    <p class="m-0">Name Mr/Mrs/Ms:<span
                                                                            class="text-danger">*</span>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-5 mb-25">
                                                        <div class="row align-items-center">
                                                            <div class="col-md-4 pe-0 rounded-r-0">
                                                                <select required name="guarater_relation[]" id="g_fhw_name"
                                                                    class="form-control">
                                                                    <option value="">Select</option>
                                                                    <option value="father" @if($info->guarater_relation == "father") selected @endif>Father</option>
                                                                    <option value="husband" @if($info->guarater_relation == "husband") selected @endif>Husband</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-8 ps-0">
                                                                <div class="holder">
                                                                    <div class="input-holder">
                                                                        <input required name="guarater_relation_name[]" value="{{ old('guarater_relation_name', $info->guarater_relation_name) }}"
                                                                            id="name"
                                                                            class="input border-start-0 rounded-l-0"
                                                                            type="text" placeholder=" " />
                                                                        <div class="placeholder">
                                                                            <p class="m-0">Father/Husband name<span
                                                                                    class="text-danger">*</span></p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="holder">
                                                            <div class="input-holder">
                                                                <input required name="guarater_address_present[]" value="{{ old('guarater_address_present', $info->guarater_address_present) }}"
                                                                    id="s_address" class="input" type="text"
                                                                    placeholder=" " />
                                                                <div class="placeholder">
                                                                    <p class="m-0">Address:<span
                                                                            class="text-danger">*</span></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <div class="row align-items-center">
                                                            <div class="col-md-7 pe-0">
                                                                <div class="holder">
                                                                    <div class="input-holder">
                                                                        <input required name="guarater_nid[]" value="{{ old('guarater_nid', $info->guarater_nid) }}" id="nid"
                                                                            class="input rounded-r-0" type="number"
                                                                            placeholder=" " />
                                                                        <div class="placeholder">
                                                                            <p class="m-0">National ID No:<span
                                                                                    class="text-danger">*</span>
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-5 ps-0">
                                                                <div class="holder">
                                                                    <div
                                                                        class="input-holder input border-start-0 rounded-l-0 upload_holder">
                                                                        <input type="file" name="guarantor_file" id="file2"
                                                                            class="inputfile"
                                                                            data-multiple-caption="{count} files selected"
                                                                            multiple />
                                                                        <label for="file2"><span><i
                                                                                    class="uil uil-upload"></i></span></label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 d-flex align-items-center">
                                                        <span>Upload PDF JPG or PNG format.</span>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="holder">
                                                            <div class="input-holder">
                                                                <input required name="guarater_phone[]" value="{{ old('guarater_phone', $info->guarater_phone) }}" id="org_mobile"
                                                                    class="input" type="number"
                                                                    placeholder="Enter 11 digit Mobile Number" />
                                                                <div class="placeholder">
                                                                    <p class="m-0">Mobile No:<span
                                                                            class="text-danger">*</span></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                         @endforeach
                                      
                                    </fieldset>
                                    <fieldset class="mt-4">
                                        <legend>Others:</legend>
                                        <div class="row">
                                            <div class="col-md-4 mb-25">
                                                <div class="holder">
                                                    <div class="input-holder">
                                                        <input name="facebook_url" value="{{ old('facebook_url', $hirepurchase->facebook_url) }}" id="fb_url" class="input"
                                                            type="text" placeholder=" " />
                                                        <div class="placeholder">
                                                            <p class="m-0">Facebook Profile URL:</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-25">
                                                <div class="holder">
                                                    <div class="input-holder">
                                                        <input name="whatsapp_number" value="{{ old('whatsapp_number', $hirepurchase->whatsapp_number) }}" id="whatsapp" class="input"
                                                            type="number" placeholder=" " />
                                                        <div class="placeholder">
                                                            <p class="m-0">Whatsapp Number:</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-25">
                                                <div class="holder">
                                                    <div class="input-holder">
                                                        <input name="email" value="{{ old('email', $hirepurchase->email) }}" id="mail" class="input"
                                                            type="email" placeholder=" " />
                                                        <div class="placeholder">
                                                            <p class="m-0">Email:</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>

                                    <fieldset class="mt-4">
                                        <legend>Bank Information:</legend>
                                        <div class="row">
                                            <div class="col-md-3 mb-25">
                                                <div class="holder">
                                                    <div class="input-holder">

                                                        <select name="bank_id" id="bank_name" class="form-control">
                                                            @foreach ($all_banks as $bank)
                                                                <option value="{{ $bank->id }}" @if(old('bank_id', $bank->id) == $bank->id) selected @endif>{{ $bank->name }}</option>
                                                            @endforeach

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-25">
                                                <div class="holder">
                                                    <div class="input-holder">
                                                        <input name="bank_account_number" value="{{ old('bank_account_number', $hirepurchase->bank_account_number) }}" id="bank_account_number"
                                                            class="input" type="number" placeholder=" " />
                                                        <div class="placeholder">
                                                            <p class="m-0">Bank Account Number:</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-25">
                                                <div class="holder">
                                                    <div class="input-holder">
                                                        <input name="branch_name" value="{{ old('branch_name', $hirepurchase->branch_name) }}" id="branch_name" class="input"
                                                            type="text" placeholder=" " />
                                                        <div class="placeholder">
                                                            <p class="m-0">Branch Name :</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3 mb-25">
                                                <div class="holder">
                                                    <div class="input-holder">
                                                        <input name="checkque_number" value="{{ old('', $hirepurchase->checkque_number) }}" id="checkque_number" class="input"
                                                            type="text" placeholder=" " />
                                                        <div class="placeholder">
                                                            <p class="m-0">Cheque Number :</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                        </div>
                    
                        <div class="row">
                            <div class="col-md-6">
                                <div id="capable_action" class="mb-3" style="display: none">Sorry,Monthly Installment
                                    Must Be 3000 Taka Then You Are Applicable </div>

                                <span id="credit_validation" style="color: red"></span>
                            </div>
                            <div class="col-md-6">
                                <button id="save_button" class="btn btn-lg btn-primary customr-btn btn-submit ms-auto"
                                    type="submit">Save And Continue</button>
                            </div>
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </div>


@endsection
