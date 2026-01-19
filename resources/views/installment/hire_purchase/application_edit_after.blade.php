@section('title', $title)
@section('description', $description)
@extends('layout.app')

@section('content')
    <div class="container-fluid">
        <div class="form-element">
            <form action="{{ url('product_update_after') }}" method="post" enctype="multipart/form-data" class="parent-assign">
                @csrf

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card card-default card-md mb-4 purchase_app">
                            <div class="card-header">
                                <h6>Buy Now Pay Later Form - After Approval</h6>
                            </div>
                            <div class="card-body py-md-30">
                                <div class="form-group">
                                    <fieldset class="">
                                        <legend>Personal Information:</legend>
                                        <div class="row">

                                            <div class="col-md-6 mb-25">
                                                <div class="holder">
                                                    <div class="input-holder">
                                                        <input type="hidden" name="hirepurchase_id"
                                                            value="{{ $hirepurchase->id }}">
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
                                                            value="{{ old('fathers_name', $hirepurchase->fathers_name) }}"
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
                                                        <input name="spouse_name" id="name" class="input"
                                                            type="text"
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
                                                <select required onchange="maritalStatusChange()" name="marital_status"
                                                    id="marital_status" class="form-control">
                                                    <option value="">Marital status</option>
                                                    <option value="Unmarried"
                                                        @if (old('marital_status', $hirepurchase->marital_status) == 'Unmarried') selected @endif>Unmarried</option>
                                                    <option value="married"
                                                        @if (old('marital_status', $hirepurchase->marital_status) == 'married') selected @endif>Married</option>
                                                    <option value="divorced"
                                                        @if (old('marital_status', $hirepurchase->marital_status) == 'divorced') selected @endif>Divorced</option>
                                                    <option value="widowed"
                                                        @if (old('marital_status', $hirepurchase->marital_status) == 'widowed') selected @endif>Widowed</option>
                                                    <option value="separated"
                                                        @if (old('marital_status', $hirepurchase->marital_status) == 'separated') selected @endif>Separated</option>
                                                </select>


                                            </div>
                                            <div class="col-md-6 mb-25">
                                                <div class="row align-items-center">
                                                    <div class="col-md-7 pe-0">
                                                        <div class="holder">
                                                            <div class="input-holder">
                                                                <input required name="nid" id="nid"
                                                                    class="input rounded-r-0" type="number"
                                                                    value="{{ old('nid', $hirepurchase->nid) }}"
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
                                                            <div
                                                                class="input-holder input border-start-0 rounded-l-0 upload_holder">

                                                                <input type="file" name="file" id="file"
                                                                    onchange="document.getElementById('preview').src = window.URL.createObjectURL(this.files[0])
                                                                    class="inputfile"
                                                                    data-multiple-caption="{count} files selected"
                                                                    multiple />
                                                                <img id="preview"
                                                                    src="{{ asset($hirepurchase->nid_image) }}"
                                                                    alt="your image" width="100" height="100" />
                                                                <label for="file"><span><i
                                                                            class="uil uil-upload"></i></span></label>
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
                                                        <input required name="pr_house_no"
                                                            value="{{ old('pr_house_no', $hirepurchase->pr_house_no) }}"
                                                            id="pr_village" class="input" type="text"
                                                            placeholder=" " />
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
                                                        <input required name="pr_road_no" id="pr_postoffice"
                                                            value="{{ old('pr_road_no', $hirepurchase->pr_road_no) }}"
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
                                                    @foreach ($all_district as $district)
                                                        <option value="{{ $district->id }}"
                                                            @if (old('pr_district_id', $pr_district->id) == $district->id) selected @endif>
                                                            {{ $district->en_name }}
                                                        </option>
                                                    @endforeach

                                                </select>
                                            </div>
                                            <div class="col-md-3 mb-25">
                                                <select required name="pr_upazila_id" id="rs_thana"
                                                    class="form-control Select-upazila">
                                                    <option value="">Select Thana</option>
                                                    @foreach ($all_upazilas as $upazila)
                                                        <option value="{{ $upazila->id }}"
                                                            @if (old('pr_upazila_id', $pr_upazilapr->id) == $upazila->id) selected @endif>
                                                            {{ $upazila->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-3 mb-25">
                                                <div class="holder">
                                                    <div class="input-holder">
                                                        <input required name="pr_phone" id="pr_mobile"
                                                            value="{{ old('pr_phone', $hirepurchase->pr_phone) }}"
                                                            class="input" type="number"
                                                            placeholder="Enter 11 digit Mobile Number" />
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
                                                    <option value="rent"
                                                        @if ($hirepurchase->pr_residence_status == 'rent') selected @endif>Rent</option>
                                                    <option value="own"
                                                        @if ($hirepurchase->pr_residence_status == 'own') selected @endif>Own</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3 mb-25">
                                                <div class="holder">
                                                    <div class="input-holder">
                                                        <input required name="pr_duration_staying"
                                                            value="{{ old('pr_duration_staying', $hirepurchase->pr_duration_staying) }}"
                                                            id="d_staying" class="input" type="text"
                                                            placeholder="Months/Years" />
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
                                                        <input name="pa_house_no"
                                                            value="{{ old('pa_house_no', $hirepurchase->pa_house_no) }}"
                                                            id="pa_village" class="input" type="text"
                                                            placeholder=" " />
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
                                                        <input name="pa_road_no"
                                                            value="{{ old('pa_road_no', $hirepurchase->pa_road_no) }}"
                                                            id="pr_postoffice" class="input" type="text"
                                                            placeholder=" " />
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
                                                    @foreach ($all_district as $district)
                                                        <option value="{{ $district->id }}"
                                                            @if (old('pa_district_id', $pa_district->id) == $district->id) selected @endif>
                                                            {{ $district->en_name }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-3 mb-25">
                                                <select name="pa_upazila_id" id="padrs_thana" class="form-control">
                                                    <option value="">Select Thana</option>
                                                    @foreach ($all_upazilas as $upazila)
                                                        <option value="{{ $upazila->id }}"
                                                            @if (old('pa_upazila_id', $pa_upazilapa->id) == $upazila->id) selected @endif>
                                                            {{ $upazila->name }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-3 mb-25">
                                                <div class="holder">
                                                    <div class="input-holder">
                                                        <input name="pa_phone"
                                                            value="{{ old('pa_phone', $hirepurchase->pa_phone) }}"
                                                            id="pa_mobile" class="input" type="number"
                                                            placeholder="Enter 11 digit Mobile Number" />
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
                                                        <option value="{{ $profession->id }}"
                                                            @if (old('profession_id', $customer_profession->id) == $profession->id) selected @endif>
                                                            {{ $profession->name }}</option>
                                                    @endforeach
                                                </select>

                                            </div>
                                            <div class="col-md-3 mb-25">
                                                <div class="holder">
                                                    <div class="input-holder">
                                                        <input required name="designation"
                                                            value="{{ old('designation', $hirepurchase->designation) }}"
                                                            id="designation" class="input" type="text"
                                                            placeholder="" />
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
                                                        <input required name="duration_current_profe"
                                                            value="{{ old('duration_current_profe', $hirepurchase->duration_current_profe) }}"
                                                            id="current_prof" class="input" type="text"
                                                            placeholder="" />
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
                                                        <input required name="organization_name"
                                                            value="{{ old('organization_name', $hirepurchase->organization_name) }}"
                                                            id="organization" class="input" type="text"
                                                            placeholder="" />
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
                                                        <input required name="organization_short_desc"
                                                            value="{{ old('organization_short_desc', $hirepurchase->organization_short_desc) }}"
                                                            id="job_desc" class="input" type="text"
                                                            placeholder=" " />
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
                                                        <input required name="org_house_no"
                                                            value="{{ old('org_house_no', $hirepurchase->org_house_no) }}"
                                                            id="org_village" class="input" type="text"
                                                            placeholder=" " />
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
                                                        <input required name="org_road_no"
                                                            value="{{ old('org_road_no', $hirepurchase->org_road_no) }}"
                                                            id="org_postoffice" class="input" type="text"
                                                            placeholder=" " />
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
                                                        <option value="{{ $district->id }}"
                                                            @if (old('org_district_id', $district_org->id) == $district->id) selected @endif>
                                                            {{ $district->en_name }}</option>
                                                    @endforeach

                                                </select>
                                            </div>
                                            <div class="col-md-4 mb-25">
                                                <select required name="org_upazila_id" id="prof_thana"
                                                    class="form-control">
                                                    <option value="">Select Thana</option>
                                                    @foreach ($all_upazilas as $upazila)
                                                        <option value="{{ $upazila->id }}"
                                                            @if (old('org_upazila_id', $upazila_org->id) == $upazila->id) selected @endif>
                                                            {{ $upazila->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-3 mb-25">
                                                <div class="holder">
                                                    <div class="input-holder">
                                                        <input required name="org_phone"
                                                            value="{{ old('org_phone', $hirepurchase->org_phone) }}"
                                                            id="org_mobile" class="input" type="number"
                                                            placeholder="Enter 11 digit Mobile Number" />
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
                                                        <input required name="month_income"
                                                            value="{{ old('month_income', $hirepurchase->month_income) }}"
                                                            id="month_income" class="input" type="number"
                                                            placeholder=" " />
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
                                                        <input required name="other_family_member"
                                                            value="{{ old('other_family_member', $hirepurchase->other_family_member) }}"
                                                            id="other_pets" class="input" type="number"
                                                            placeholder="" />
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
                                                        <input name="number_of_children"
                                                            value="{{ old('number_ofChilder_showing', $hirepurchase->number_of_children) }}"
                                                            id="children_num" class="input" type="number"
                                                            placeholder="" />
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
                                                                        <input name="mem_name[]"
                                                                            value="{{ old('mem_name', $member->name) }}"
                                                                            id="name[]" class="input" type="text"
                                                                            placeholder="" />
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
                                                                    <option value="husband"
                                                                        @if (old('mem_relation', $member->relation) == 'husband') selected @endif>
                                                                        Husband</option>
                                                                    <option value="wife"
                                                                        @if (old('mem_relation', $member->relation) == 'wife') selected @endif>
                                                                        Wife</option>
                                                                    <option value="children"
                                                                        @if (old('mem_relation', $member->relation) == 'children') selected @endif>
                                                                        Children</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="holder">
                                                                    <div class="input-holder">
                                                                        <input name="mem_age[]"
                                                                            value="{{ old('mem_age', $member->age) }}"
                                                                            id="age[]" class="input" type="text"
                                                                            placeholder="" />
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
                                                            <input id="yes" name="previously_purchased"
                                                                value="1" type="radio"
                                                                @if ($hirepurchase->previously_purchased == 1) checked @endif />
                                                            <label for="yes">Yes</label>
                                                        </div>
                                                        <div>
                                                            <input id="no" name="previously_purchased"
                                                                value="0" type="radio"
                                                                @if ($hirepurchase->previously_purchased == 0) checked @endif />
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
                                                        <input name="shipping_address"
                                                            value="{{ old('shipping_address', $hirepurchase->shipping_address) }}"
                                                            id="s_address" class="input" type="text"
                                                            placeholder=" " />
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
                                                        <input name="distance_from_showroom"
                                                            value="{{ old('distance_from_showroom', $hirepurchase->distance_from_showroom) }}"
                                                            id="distance" class="input" type="number"
                                                            placeholder="Kilometer" />
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
                                                <h6 class="lgnd_text">
                                                    {{ ucfirst(\App\Helpers\Helper::ordinal($loop->iteration)) }}
                                                    Guarantor:</h6>
                                                <div class="row mt-2">
                                                    <div class="col-md-3 mb-25">
                                                        <div class="holder">
                                                            <div class="input-holder">
                                                                <input required name="guarater_name[]"
                                                                    value="{{ old('guarater_name', $info->guarater_name) }}"
                                                                    id="guarater_one_name" class="input" type="text"
                                                                    placeholder=" " />
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
                                                                <select required name="guarater_relation[]"
                                                                    id="g_fhw_name" class="form-control">
                                                                    <option value="">Select</option>
                                                                    <option value="father"
                                                                        @if ($info->guarater_relation == 'father') selected @endif>
                                                                        Father</option>
                                                                    <option value="husband"
                                                                        @if ($info->guarater_relation == 'husband') selected @endif>
                                                                        Husband</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-8 ps-0">
                                                                <div class="holder">
                                                                    <div class="input-holder">
                                                                        <input required name="guarater_relation_name[]"
                                                                            value="{{ old('guarater_relation_name', $info->guarater_relation_name) }}"
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
                                                                <input required name="guarater_address_present[]"
                                                                    value="{{ old('guarater_address_present', $info->guarater_address_present) }}"
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
                                                                        <input required name="guarater_nid[]"
                                                                            value="{{ old('guarater_nid', $info->guarater_nid) }}"
                                                                            id="nid" class="input rounded-r-0"
                                                                            type="number" placeholder=" " />
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
                                                                        <input type="file" name="guarantor_file"
                                                                            id="file2" class="inputfile"
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
                                                                <input required name="guarater_phone[]"
                                                                    value="{{ old('guarater_phone', $info->guarater_phone) }}"
                                                                    id="org_mobile" class="input" type="number"
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
                                                        <input name="facebook_url"
                                                            value="{{ old('facebook_url', $hirepurchase->facebook_url) }}"
                                                            id="fb_url" class="input" type="text"
                                                            placeholder=" " />
                                                        <div class="placeholder">
                                                            <p class="m-0">Facebook Profile URL:</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-25">
                                                <div class="holder">
                                                    <div class="input-holder">
                                                        <input name="whatsapp_number"
                                                            value="{{ old('whatsapp_number', $hirepurchase->whatsapp_number) }}"
                                                            id="whatsapp" class="input" type="number"
                                                            placeholder=" " />
                                                        <div class="placeholder">
                                                            <p class="m-0">Whatsapp Number:</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-25">
                                                <div class="holder">
                                                    <div class="input-holder">
                                                        <input name="email"
                                                            value="{{ old('email', $hirepurchase->email) }}"
                                                            id="mail" class="input" type="email"
                                                            placeholder=" " />
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
                                                                <option value="{{ $bank->id }}"
                                                                    @if (old('bank_id', $bank->id) == $bank->id) selected @endif>
                                                                    {{ $bank->name }}</option>
                                                            @endforeach

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-25">
                                                <div class="holder">
                                                    <div class="input-holder">
                                                        <input name="bank_account_number"
                                                            value="{{ old('bank_account_number', $hirepurchase->bank_account_number) }}"
                                                            id="bank_account_number" class="input" type="number"
                                                            placeholder=" " />
                                                        <div class="placeholder">
                                                            <p class="m-0">Bank Account Number:</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-25">
                                                <div class="holder">
                                                    <div class="input-holder">
                                                        <input name="branch_name"
                                                            value="{{ old('branch_name', $hirepurchase->branch_name) }}"
                                                            id="branch_name" class="input" type="text"
                                                            placeholder=" " />
                                                        <div class="placeholder">
                                                            <p class="m-0">Branch Name :</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3 mb-25">
                                                <div class="holder">
                                                    <div class="input-holder">
                                                        <input name="checkque_number"
                                                            value="{{ old('', $hirepurchase->checkque_number) }}"
                                                            id="checkque_number" class="input" type="text"
                                                            placeholder=" " />
                                                        <div class="placeholder">
                                                            <p class="m-0">Cheque Number :</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>

                                    <div class="card card-default card-md mb-4 purchase_app">
                                        <div class="card-body py-md-30">
                                            <div class="form-group">
                                                <fieldset class="">
                                                    <legend>Office Use Only:</legend>
                                                    <div class="row">
                                                        <!-- Delivery Showroom -->
                                                        <div class="col-md-3">
                                                            <select required name="delivery_showroom_id"
                                                                id="delivery_showroom_id" class="form-control">
                                                                <option value="">Select Show Room</option>
                                                                @foreach ($showrooms as $item)
                                                                    <option value="{{ $item->id }}"
                                                                        @if (old('delivery_showroom_id', $hirepurchase->delivery_showroom_id) == $item->id) selected @endif>
                                                                        {{ $item->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <!-- Sale Type -->
                                                        <div class="col-md-3">
                                                            <select required name="sale_type" id="sale_type"
                                                                class="form-control" onchange="toggleSaleType()">
                                                                <option value="">Select Sale Type</option>
                                                                <option value="single"
                                                                    @if (old('sale_type', $hirepurchase->sale_type ?? 'single') == 'single') selected @endif>
                                                                    Single Product
                                                                </option>
                                                                <option value="package"
                                                                    @if (old('sale_type', $hirepurchase->sale_type ?? 'single') == 'package') selected @endif>
                                                                    Package
                                                                </option>
                                                            </select>
                                                        </div>

                                                        <!-- Package Selection -->
                                                        <div class="col-md-3 package-section"
                                                            style="display:{{ old('sale_type', $hirepurchase->sale_type ?? 'single') == 'package' ? 'block' : 'none' }};">
                                                            <select name="package_id" id="package_id"
                                                                class="form-control" onchange="loadPackageDetails()">
                                                                <option value="">Select Package</option>
                                                                @foreach ($packages as $package)
                                                                    <option value="{{ $package->id }}"
                                                                        @if (old('package_id', $hirepurchase->package_id ?? null) == $package->id) selected @endif>
                                                                        {{ $package->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <!-- Single Product Group -->
                                                        <div class="col-md-3 single-product-section"
                                                            style="display:{{ old('sale_type', $hirepurchase->sale_type ?? 'single') == 'single' ? 'block' : 'none' }};">
                                                            <select name="product_group_id" onchange="GetCategory()"
                                                                id="group" class="form-control">
                                                                <option value="">Product Group</option>
                                                                @foreach ($product_type as $type)
                                                                    <option value="{{ $type->id }}"
                                                                        @if (old('product_group_id', $hirepurchase_product->product_group_id ?? null) == $type->id) selected @endif>
                                                                        {{ $type->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <!-- Single Product Details -->
                                                    <div class="single-product-section"
                                                        style="display:{{ old('sale_type', $hirepurchase->sale_type ?? 'single') == 'single' ? 'block' : 'none' }};">
                                                        <div class="row mt-3">
                                                            <div class="col-md-3 mb-25">
                                                                <select name="product_category_id" id="Select-Model"
                                                                    class="form-control category">
                                                                    @if (old('product_category_id', $hirepurchase_product->product_category_id ?? null))
                                                                        <option
                                                                            value="{{ old('product_category_id', $hirepurchase_product->product_category_id) }}"
                                                                            selected>
                                                                            {{ optional($hirepurchase_product->product_category)->name }}
                                                                        </option>
                                                                    @endif
                                                                </select>
                                                                <span style="color: red" id="category-require"></span>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <select onchange="GetProduct()" name="product_brand_id"
                                                                    id="prod_brand" class="form-control">
                                                                    <option value="">Product Brand</option>
                                                                    @foreach ($brands as $brand)
                                                                        <option value="{{ $brand->id }}"
                                                                            @if (old('product_brand_id', $hirepurchase_product->product_brand_id ?? null) == $brand->id) selected @endif>
                                                                            {{ $brand->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <select onchange="GetPrice()" name="product_model_id"
                                                                    id="Select-color" class="form-control">
                                                                    <option value="">Product Model:</option>
                                                                    @if (old('product_model_id', $hirepurchase_product->product_model_id ?? null))
                                                                        <option
                                                                            value="{{ old('product_model_id', $hirepurchase_product->product_model_id) }}"
                                                                            selected>
                                                                            {{ optional($hirepurchase_product->product)->product_model }}
                                                                        </option>
                                                                    @endif
                                                                </select>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <input type="text" name="product_size_id"
                                                                    id="product_size" class="form-control"
                                                                    value="{{ old('product_size_id', $hirepurchase_product->product_size_id ?? '') }}"
                                                                    placeholder="Product Size">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Package Items (Static for Edit – dynamic load not needed) -->
                                                    <div class="row package-section"
                                                        style="display:{{ old('sale_type', $hirepurchase->sale_type ?? 'single') == 'package' ? 'block' : 'none' }};">
                                                        <div class="col-md-12">
                                                            <div id="package-items-container" class="mt-3">
                                                                <h6>Package Items:</h6>
                                                                <table class="table table-bordered">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Product</th>
                                                                            <th>Serial No</th>
                                                                            <th>Product Size</th>
                                                                            <th>Price</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody id="package-items-body">
                                                                        @php
                                                                            $packageProducts =
                                                                                $hirepurchase->purchase_products ??
                                                                                collect();
                                                                        @endphp
                                                                        @foreach ($packageProducts as $index => $item)
                                                                            <tr>
                                                                                <td>{{ optional($item->product)->product_model }}
                                                                                </td>
                                                                                <td>
                                                                                    <input type="text"
                                                                                        name="package_products[{{ $index }}][serial_no]"
                                                                                        class="form-control form-control-sm"
                                                                                        value="{{ old("package_products.$index.serial_no", $item->serial_no) }}"
                                                                                        required>
                                                                                    <input type="hidden"
                                                                                        name="package_products[{{ $index }}][product_id]"
                                                                                        value="{{ $item->product_model_id }}">
                                                                                </td>
                                                                                <td>
                                                                                    <input type="text"
                                                                                        name="package_products[{{ $index }}][product_size_id]"
                                                                                        class="form-control form-control-sm"
                                                                                        value="{{ old("package_products.$index.product_size_id", $item->product_size_id) }}"
                                                                                        placeholder="Size">
                                                                                </td>
                                                                                <td>{{ $item->cash_price }}</td>
                                                                            </tr>
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Common Fields -->
                                                    <div class="row mt-3">
                                                        <!-- Serial No (Single only) -->
                                                        <div class="col-md-3 mb-25 single-product-section"
                                                            style="display:{{ old('sale_type', $hirepurchase->sale_type ?? 'single') == 'single' ? 'block' : 'none' }};">
                                                            <div class="holder">
                                                                <div class="input-holder">
                                                                    <input name="serial_no" id="serial_no" class="input"
                                                                        value="{{ old('serial_no', $hirepurchase_product->serial_no ?? '') }}"
                                                                        type="text" placeholder=" " />
                                                                    <div class="placeholder">
                                                                        <p class="m-0">Serial No:<span
                                                                                class="text-danger">*</span></p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Cash Price -->
                                                        <div class="col-md-3 mb-25">
                                                            <div class="holder">
                                                                <div class="input-holder">
                                                                    <input required name="cash_price" id="cash_price"
                                                                        class="input"
                                                                        value="{{ old('cash_price', $hirepurchase_product->cash_price ?? ($hirepurchase->cash_price ?? 0)) }}"
                                                                        readonly type="number" placeholder=" " />
                                                                    <div class="placeholder">
                                                                        <p class="m-0">Cash Price:<span
                                                                                class="text-danger">*</span></p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Down Payment % -->
                                                        <div class="col-md-3 mb-25">
                                                            <div class="holder">
                                                                <div class="input-holder">
                                                                    <select required onchange="calculate()"
                                                                        name="down_payment_parcentage"
                                                                        id="down_payment_parcentage" class="form-control">
                                                                        <option value="">Down Payment %</option>
                                                                        {{-- @foreach ($down_payment_parcentage as $item)
                                                                            <option
                                                                                value="{{ $item->payment_percentage }}"
                                                                                @if (old('down_payment_parcentage', $hirepurchase->down_payment_parcentage ?? 40) == $item->payment_percentage) selected @endif>
                                                                                {{ $item->payment_percentage }}%
                                                                            </option>
                                                                        @endforeach --}}
                                                                        @foreach ($down_payment_parcentage as $item)
                                                                            <option
                                                                                value="{{ $item->payment_percentage }}"
                                                                                @if (round(($hirepurchase->down_payment / $hirepurchase->hire_price) * 100) == $item->payment_percentage) selected @endif>
                                                                                {{ $item->payment_percentage }}%
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Installment Month -->
                                                        <div class="col-md-3 mb-25">
                                                            <div class="holder">
                                                                <div class="input-holder">
                                                                    @foreach ($interestrate as $interest_hid)
                                                                        <input type="hidden"
                                                                            id="interest_rate_{{ $interest_hid->month }}"
                                                                            value="{{ $interest_hid->interest_rate }}">
                                                                    @endforeach
                                                                    <select required onchange="calculate()"
                                                                        name="installment_month" id="installment_month"
                                                                        class="form-control">
                                                                        <option value="">Installment Month</option>
                                                                        @foreach ($interestrate as $interest)
                                                                            <option value="{{ $interest->month }}"
                                                                                @if (old('installment_month', $hirepurchase->installment_month ?? null) == $interest->month) selected @endif>
                                                                                {{ $interest->month }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Hire Price -->
                                                        <div class="col-md-3 mb-25">
                                                            <div class="holder">
                                                                <div class="input-holder">
                                                                    <input required name="hire_price" id="hire_price"
                                                                        class="input"
                                                                        value="{{ old('hire_price', $hirepurchase->hire_price ?? 0) }}"
                                                                        readonly type="text" placeholder=" " />
                                                                    <div class="placeholder">
                                                                        <p class="m-0">Hire Price:<span
                                                                                class="text-danger">*</span></p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Down Payment -->
                                                        <div class="col-md-3 mb-25">
                                                            <div class="holder">
                                                                <div class="input-holder">
                                                                    <input readonly required name="down_payment"
                                                                        id="down_payment" class="input"
                                                                        value="{{ old('down_payment', $hirepurchase->down_payment ?? 0) }}"
                                                                        type="text" placeholder=" " />
                                                                    <div class="placeholder">
                                                                        <p class="m-0">Down Payment:<span
                                                                                class="text-danger">*</span></p>
                                                                    </div>
                                                                    <span id="alert_downpayment"
                                                                        class="text-danger"></span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Monthly Installment -->
                                                        <div class="col-md-3 mb-25">
                                                            <div class="holder">
                                                                <div class="input-holder">
                                                                    <input readonly required name="monthly_installment"
                                                                        id="monthly_inst" class="input"
                                                                        value="{{ old('monthly_installment', $hirepurchase->monthly_installment ?? 0) }}"
                                                                        type="text" placeholder=" " />
                                                                    <div class="placeholder">
                                                                        <p class="m-0">Monthly Inst. Tk:<span
                                                                                class="text-danger">*</span></p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- EMI Warning -->
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div id="emi-warning" class="alert alert-warning"
                                                                style="display:none;">
                                                                <i class="fas fa-exclamation-triangle"></i>
                                                                <strong>Note:</strong> Single product sales are limited to
                                                                maximum 3 months EMI.
                                                            </div>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <script>
                            function toggleSaleType() {
                                const saleType = document.getElementById('sale_type').value;
                                const singleSections = document.querySelectorAll('.single-product-section');
                                const packageSections = document.querySelectorAll('.package-section');
                                const installmentMonth = document.getElementById('installment_month');
                                const emiWarning = document.getElementById('emi-warning');

                                // Reset fields
                                document.getElementById('cash_price').value = '';
                                document.getElementById('hire_price').value = '';
                                document.getElementById('down_payment').value = '';
                                document.getElementById('monthly_inst').value = '';

                                if (saleType === 'single') {
                                    singleSections.forEach(section => section.style.display = 'block');
                                    packageSections.forEach(section => section.style.display = 'none');

                                    // ✅ RESTORE ALL INSTALLMENT OPTIONS (remove restriction)
                                    Array.from(installmentMonth.options).forEach(option => {
                                        option.disabled = false;
                                        option.style.display = 'block';
                                    });

                                    // Optional: hide or remove EMI warning if no restriction
                                    if (emiWarning) emiWarning.style.display = 'none';

                                    document.getElementById('serial_no').required = true;
                                    document.getElementById('package_id').required = false;

                                } else if (saleType === 'package') {
                                    singleSections.forEach(section => section.style.display = 'none');
                                    packageSections.forEach(section => section.style.display = 'block');

                                    // ✅ Also restore all options for package (no restriction needed)
                                    Array.from(installmentMonth.options).forEach(option => {
                                        option.disabled = false;
                                        option.style.display = 'block';
                                    });

                                    if (emiWarning) emiWarning.style.display = 'none';

                                    document.getElementById('serial_no').required = false;
                                    document.getElementById('package_id').required = true;

                                } else {
                                    singleSections.forEach(section => section.style.display = 'none');
                                    packageSections.forEach(section => section.style.display = 'none');
                                    if (emiWarning) emiWarning.style.display = 'none';
                                }
                            }

                            function loadPackageDetails() {
                                const packageId = document.getElementById('package_id').value;

                                if (!packageId) {
                                    document.getElementById('package-items-body').innerHTML = '';
                                    return;
                                }

                                // AJAX call to load package items
                                fetch(`/api/packages/${packageId}/items`)
                                    .then(response => response.json())
                                    .then(data => {
                                        console.log(data);
                                        let html = '';
                                        let totalPrice = 0;

                                        data.items.forEach((item, index) => {
                                            totalPrice += parseFloat(item.product.cash_price);
                                            html += `
                    <tr>
                        <td>
                            ${item.product.product_model}
                            <input type="hidden" name="package_products[${index}][product_id]" value="${item.product_id}">
                        </td>
                        <td>
                            <input type="text" name="package_products[${index}][serial_no]"
                                class="form-control form-control-sm" required
                                placeholder="Enter Serial No">
                        </td>
                        <td>
                          <input type="text" name="package_products[${index}][product_size_id]"
                                class="form-control form-control-sm"
                                placeholder="Product Size">
                        </td>
                        <td>${item.product.product_group}</td>
                        <td>${item.product.product_category}</td>
                        <td>${item.product.cash_price}</td>
                    </tr>
                `;
                                        });

                                        document.getElementById('package-items-body').innerHTML = html;
                                        document.getElementById('cash_price').value = totalPrice.toFixed(2);

                                        // Trigger calculation
                                        calculate();
                                    })
                                    .catch(error => {
                                        console.error('Error loading package items:', error);
                                        alert('Failed to load package items');
                                    });
                            }
                        </script>

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

    <script>
        @php
            $down_payment = App\Models\DownPaymentSetting::orderBy('id', 'ASC')->first();
        @endphp


        function calculateMonthlyInstallment() {
            var installment_month = $("#installment_month").val();
            var hire_price = parseFloat($("#hire_price").val()) || 0;
            var down_payment = parseFloat($("#down_payment").val()) || 0;

            if (installment_month == 0) {
                $("#down_payment").val(0);
                return;
            }

            var test = parseFloat($("#down_payment_parcentage").val()) || 0;
            var payment = (hire_price * test / 100);

            // Calculate monthly installment with proper decimal formatting
            var monthly_install = 0;
            if (installment_month > 1) {
                monthly_install = (hire_price - down_payment) / (installment_month - 1);
                // Format to 2 decimal places
                monthly_install = monthly_install.toFixed(2);
            }

            // Check if monthly installment is less than minimum required
            if (parseFloat(monthly_install) < 3000) {
                $("#capable_action").css({
                    'display': 'block'
                });
                $("#save_button").prop('disabled', true).css({
                    'display': 'none'
                });
            } else {
                $("#capable_action").css({
                    'display': 'none'
                });
                $("#save_button").prop('disabled', false).css({
                    'display': 'block'
                });
            }

            $("#monthly_inst").val(monthly_install);

            calculateCreditScoreWithHirePrice();
        }

        function calculateDownPayment() {
            var installment_month = $("#installment_month").val();
            var hire_price = parseFloat($("#hire_price").val()) || 0;

            // Get selected down payment percentage
            var selectedPercentage = parseFloat($("#down_payment_parcentage").val()) || 0;
            var payment = (hire_price * selectedPercentage / 100);

            var monthly_install = parseFloat($("#monthly_inst").val()) || 0;
            var down_payment = (hire_price - (monthly_install * (installment_month - 1)));
            $("#down_payment").val(down_payment.toFixed(2));

            if (payment >= down_payment) {
                var alert_message = "You must pay at least " + selectedPercentage + "% down payment: " + payment.toFixed(
                    2) + " BDT";
                $("#alert_downpayment").html(alert_message);
                $("#save_button").css({
                    'display': 'none'
                });
            } else {
                $("#alert_downpayment").html('');
                $("#save_button").css({
                    'display': 'block'
                });
            }

            calculateCreditScoreWithHirePrice();
        }

        // Event listeners
        $("#down_payment").on("input", calculateMonthlyInstallment);
        $("#monthly_inst").on("input", calculateDownPayment);
        $("#down_payment_parcentage").on("change", function() {
            // Recalculate when percentage changes
            calculate();
        });

        function calculateCreditScoreWithHirePrice() {
            var downPayment = parseFloat($('#down_payment').val());
            var hirePrice = parseFloat($('#hire_price').val());

            var showroom_credit = <?php echo $showroom_credit->remaining_credit; ?>;
            var credit = parseFloat(showroom_credit);
            var due = hirePrice - downPayment;

            // Check credit validation
            var isCreditValid = true;
            if (due > credit) {
                var alert_message =
                    "You have exceeded your credit limitation. Your current credit is " + credit;
                $('#credit_validation').html(alert_message);
                isCreditValid = false;
            } else {
                $("#credit_validation").html("");
                isCreditValid = true;
            }

            // Check other validations
            var monthly_install = parseFloat($("#monthly_inst").val());
            var isMonthlyInstallmentValid = monthly_install >= 3000;

            var selectedPercentage = parseFloat($("#down_payment_parcentage").val());
            var hirePrice = parseFloat($("#hire_price").val());
            var requiredDownPayment = (hirePrice * selectedPercentage / 100);
            var isDownPaymentValid = downPayment >= requiredDownPayment;

            // Update button state based on all validations
            if (isMonthlyInstallmentValid && isCreditValid) {
                $("#save_button").prop('disabled', false).css({
                    'display': 'block'
                });
            } else {
                $("#save_button").prop('disabled', true).css({
                    'display': 'none'
                });
            }

            // Call comprehensive validation to ensure consistency
            setTimeout(function() {
                validateFormAndUpdateButton();
            }, 100);
        }

        // Comprehensive validation function to check all conditions
        function validateFormAndUpdateButton() {
            var monthly_install = parseFloat($("#monthly_inst").val()) || 0;
            var downPayment = parseFloat($('#down_payment').val()) || 0;
            var hirePrice = parseFloat($('#hire_price').val()) || 0;
            var selectedPercentage = parseFloat($("#down_payment_parcentage").val()) || 0;

            // Check monthly installment validation
            var isMonthlyInstallmentValid = monthly_install >= 3000;

            // Check down payment validation
            var requiredDownPayment = (hirePrice * selectedPercentage / 100);
            var isDownPaymentValid = downPayment >= requiredDownPayment;

            // Check credit validation
            var showroom_credit = <?php echo $showroom_credit->remaining_credit; ?>;
            var credit = parseFloat(showroom_credit);
            var due = hirePrice - downPayment;
            var isCreditValid = due <= credit;

            // Update button state based on all validations
            if (isMonthlyInstallmentValid && isCreditValid) {
                $("#save_button").prop('disabled', false).css({
                    'display': 'block'
                });
            } else {
                $("#save_button").prop('disabled', true).css({
                    'display': 'none'
                });
            }
        }

        function calculate() {
            var installment_month = $("#installment_month").val();
            var cash_price = parseInt($("#cash_price").val());
            var interest_rate = parseFloat($("#interest_rate_" + installment_month).val());
            var interest_amount = (interest_rate * cash_price) / 100;
            var interest_amount = interest_amount.toFixed(2);
            installment_month -= 1;

            $("#interest_amount").val(interest_amount);
            var hire_price = parseFloat(interest_amount) + cash_price;

            $("#hire_price").val(hire_price);

            // Get selected down payment percentage
            var selectedPercentage = parseFloat($("#down_payment_parcentage").val());
            var payment = (hire_price * selectedPercentage / 100);

            if (installment_month == -1) {
                $("#down_payment").val(0);
                $("#hire_price").val(0);
                $("#interest_amount").val(0);
            } else {
                $("#down_payment").val(payment.toFixed(2));
                $("#hire_price").val(hire_price);
                $("#interest_amount").val(interest_amount);
            }

            var down_payment = parseFloat($("#down_payment").val());

            if (!installment_month) {
                installment_month = 1;
            }
            var monthly_install = (hire_price - down_payment) / installment_month;
            monthly_install = monthly_install.toFixed(2);

            if ((cash_price == "NaN") || (installment_month == -1)) {
                $("#interest_rate_show").html(0);
                $("#monthly_inst").val(0);
            } else {
                $("#interest_rate_show").html(interest_rate);
                $("#monthly_inst").val(monthly_install);
            }

            // Initialize validation flags
            var isMonthlyInstallmentValid = true;
            var isDownPaymentValid = true;

            // Check if monthly installment is less than minimum required
            if (parseFloat(monthly_install) < 3000) {
                $("#capable_action").css({
                    'display': 'block'
                });
                $("#save_button").prop('disabled', true).css({
                    'display': 'none'
                });
            } else {
                $("#capable_action").css({
                    'display': 'none'
                });
                $("#save_button").prop('disabled', false).css({
                    'display': 'block'
                });
            }


            console.log("payment" + payment.toFixed(2) + " down_payment" + down_payment.toFixed(2) + " selectedPercentage" +
                selectedPercentage);

            calculateCreditScoreWithHirePrice();

            // Call comprehensive validation to ensure all conditions are checked
            setTimeout(function() {
                validateFormAndUpdateButton();
            }, 100);
        }



        function GetPrice() {

            product = $("#Select-color").val();

            $.post('{{ url('/get-price') }}', {
                _token: '{{ csrf_token() }}',
                id: product
            }, function(data) {
                $("#cash_price").val(data.price);
                $("#product_size").val(data.size);
                calculate();

            });

        }

        $(document).ready(function() {
            $('#product_bought').change(function() {

                var selectedOption = $('#product_bought option:selected');
                var selectedName = selectedOption.val();

                if (selectedName == 'others') {
                    $('#type_product').css({
                        'display': 'block'
                    }).focus();
                } else {
                    $('#type_product').css({
                        'display': 'none'
                    }).focus();
                }
            });

        });

        function maritalStatusChange() {
            var marital_status = $("#marital_status").val();
            if (marital_status == 'married') {

                $("#number_ofChilder_showing").show();
                $("#number_of_children").show();
            } else {

                $("#number_ofChilder_showing").hide();
                $("#number_of_children").hide();
            }
        }

        function guaraterMaritalStatusChange() {
            var marital_status = $("#guarater_marital_status").val();
            if (marital_status == 'married') {

                $("#guarater_number_ofChilder_showing").show();
                $("#guarater_number_of_children").show();
            } else {

                $("#guarater_number_ofChilder_showing").hide();
                $("#guarater_number_of_children").hide();
            }
        }


        function FindDistrictPre(type) {

            var district_id = $("#" + type + "_district").val();
            const selectElement = $("#" + type + "_thana")[0];
            $.post('{{ url('/find-upazila') }}', {
                _token: '{{ csrf_token() }}',
                district_id: district_id
            }, function(data) {
                data = JSON.parse(data);
                console.log(data);
                selectElement.innerHTML = '';
                data.forEach(item => {
                    const option = document.createElement('option');
                    option.value = item.id;
                    option.textContent = item.name;
                    selectElement.appendChild(option);
                });
            });
        }


        $(document).ready(function() {
            // Add Row
            $(document).on('click', '.add-row', function() {
                var newChildDiv = $('#number_of_children').first()
                    .clone(); // Clone the entire number_of_children div
                newChildDiv.find('.add-row').remove(); // Remove "Add more" button from the cloned div
                newChildDiv.find('input').val(''); // Clear input values
                var deleteBtn = $('<i/>', {
                    class: 'text-danger delete-row fa fa-trash-alt dlt_more',
                    text: ''
                });
                deleteBtn.click(function() {
                    $(this).closest('.row')
                        .remove(); // Remove the div when delete button is clicked
                });
                newChildDiv.find('.col-md-3:last-child').empty().append(deleteBtn); // Append delete button
                $('#number_of_children_container').append(
                    newChildDiv); // Append the new div to the container
            });

            // Delete Row
            $(document).on('click', '.delete-row', function() {
                $(this).closest('.row').remove();
            });

            // previously bought rangs products
            $('.previously_bought').hide();
            // Show/hide previously_bought section based on radio button selection
            $('input[name="previously_purchased"]').change(function() {
                if ($(this).val() == '1') {
                    $('.previously_bought').show();
                } else {
                    $('.previously_bought').hide();
                }
            });

            if ($('#same_p_addrs').is(':checked')) {
                $('.permanent_adrs_row').hide();
            }

            // Show/hide permanent_adrs_row based on checkbox selection
            $('#same_p_addrs').change(function() {
                if ($(this).is(':checked')) {
                    $('.permanent_adrs_row').hide();
                } else {
                    $('.permanent_adrs_row').show();
                }
            });
        });
    </script>

@endsection
