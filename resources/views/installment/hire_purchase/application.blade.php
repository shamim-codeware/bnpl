@section('title', $title)
@section('description', $description)
@extends('layout.app')

@section('content')
    <div class="container-fluid">
        <div class="form-element">
            <form action="{{ url('hire-purchase') }}" method="post" enctype="multipart/form-data" class="parent-assign">
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
                                                        <input required name="name" id="name" class="input"
                                                            type="text" value="{{ old('name') }}" placeholder=" " />
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
                                                            type="text" value="{{ old('fathers_name') }}"
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
                                                            type="text" value="{{ old('mothers_name') }}"
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
                                                            type="text" value="{{ old('spouse_name') }}"
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
                                                        <option value="{{ $i }}">{{ $i }}</option>
                                                    @endfor
                                                </select>
                                            </div>
                                            <div class="col-md-3 mb-25">
                                                <select required onchange="maritalStatusChange()" name="marital_status"
                                                    id="marital_status" class="form-control">
                                                    <option value="">Marital status</option>
                                                    <option value="Unmarried">Unmarried</option>
                                                    <option value="married">Married</option>
                                                    <option value="divorced">Divorced</option>
                                                    <option value="widowed">Widowed</option>
                                                    <option value="separated">Separated</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6 mb-25">
                                                <div class="row align-items-center">
                                                    <div class="col-md-7 pe-0">
                                                        <div class="holder">
                                                            <div class="input-holder">
                                                                <input name="nid" id="nid"
                                                                    class="input rounded-r-0 @error('nid') is-invalid @enderror"
                                                                    type="number" value="{{ old('nid') }}"
                                                                    placeholder="Enter at least 10 digit National ID Number" />
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
                                                                    class="inputfile"
                                                                    data-multiple-caption="{count} files selected"
                                                                    multiple />
                                                                <label for="file"><span><i
                                                                            class="uil uil-upload"></i></span></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @error('nid')
                                                        <span
                                                            class="invalid-feedback d-block text-danger"><strong>{{ $message }}</strong></span>
                                                    @enderror
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
                                                        <input required name="pr_house_no" id="pr_village" class="input"
                                                            type="text" value="{{ old('pr_house_no') }}"
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
                                                            class="input" type="text"
                                                            value="{{ old('pr_road_no') }}" placeholder=" " />
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
                                                    @foreach ($districts as $key => $district)
                                                        <option value="{{ $district->id }}">{{ $district->en_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-3 mb-25">
                                                <select required name="pr_upazila_id" id="rs_thana"
                                                    class="form-control Select-upazila">
                                                    <option value="">Select Thana</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3 mb-25">
                                                <div class="holder">
                                                    <div class="input-holder">
                                                        <input required name="pr_phone" id="pr_mobile" class="input"
                                                            type="number" value="{{ old('pr_phone') }}"
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
                                                    <option value="rent">Rent</option>
                                                    <option value="own">Own</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3 mb-25">
                                                <div class="holder">
                                                    <div class="input-holder">
                                                        <input required name="pr_duration_staying" id="d_staying"
                                                            class="input" type="text"
                                                            value="{{ old('pr_duration_staying') }}"
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
                                                        <input name="pa_house_no" id="pa_village" class="input"
                                                            type="text" value="{{ old('pa_house_no') }}"
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
                                                        <input name="pa_road_no" id="pr_postoffice" class="input"
                                                            type="text" value="{{ old('pa_road_no') }}"
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
                                                    @foreach ($districts as $key => $district)
                                                        <option value="{{ $district->id }}">{{ $district->en_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-3 mb-25">
                                                <select name="pa_upazila_id" id="padrs_thana" class="form-control">
                                                    <option value="">Select Thana</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3 mb-25">
                                                <div class="holder">
                                                    <div class="input-holder">
                                                        <input name="pa_phone" id="pa_mobile" class="input"
                                                            type="number" value="{{ old('pa_phone') }}"
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
                                                    @foreach ($customers_professions as $key => $customers_profession)
                                                        <option value="{{ $customers_profession->id }}">
                                                            {{ $customers_profession->name }}</option>
                                                    @endforeach
                                                    {{-- <option value="other">Other</option> --}}
                                                </select>
                                            </div>
                                            <div class="col-md-3 mb-25">
                                                <div class="holder">
                                                    <div class="input-holder">
                                                        <input required name="designation" id="designation"
                                                            class="input" value="{{ old('designation') }}"
                                                            type="text" placeholder="" />
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
                                                        <input required name="duration_current_profe" id="current_prof"
                                                            class="input" value="{{ old('duration_current_profe') }}"
                                                            type="text" placeholder="" />
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
                                                        <input required name="organization_name" id="organization"
                                                            class="input" value="{{ old('organization_name') }}"
                                                            type="text" placeholder="" />
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
                                                        <input required name="organization_short_desc" id="job_desc"
                                                            class="input" value="{{ old('organization_short_desc') }}"
                                                            type="text" placeholder=" " />
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
                                                        <input required name="org_house_no" id="org_village"
                                                            class="input" type="text"
                                                            value="{{ old('org_house_no') }}" placeholder=" " />
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
                                                        <input required name="org_road_no" id="org_postoffice"
                                                            class="input" type="text"
                                                            value="{{ old('org_road_no') }}" placeholder=" " />
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
                                                    @foreach ($districts as $key => $district)
                                                        <option value="{{ $district->id }}">{{ $district->en_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4 mb-25">
                                                <select required name="org_upazila_id" id="prof_thana"
                                                    class="form-control">
                                                    <option value="">Select Thana</option>

                                                </select>
                                            </div>
                                            <div class="col-md-3 mb-25">
                                                <div class="holder">
                                                    <div class="input-holder">
                                                        <input required name="org_phone" id="org_mobile" class="input"
                                                            type="number" value="{{ old('org_phone') }}"
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
                                                        <input required name="month_income" id="month_income"
                                                            class="input" value="{{ old('month_income') }}"
                                                            type="number" placeholder=" " />
                                                        <div class="placeholder">
                                                            <p class="m-0">Monthly Income (BDT):<span
                                                                    class="text-danger">*</span></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-25">
                                                <div class="holder">
                                                    <div class="input-holder">
                                                        <input name="facebook_url" id="fb_url" class="input"
                                                            type="text" value="{{ old('facebook_url') }}"
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
                                                        <input name="whatsapp_number" id="whatsapp" class="input"
                                                            type="number" value="{{ old('whatsapp_number') }}"
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
                                                        <input name="email" id="mail" class="input"
                                                            type="email" value="{{ old('email') }}" required
                                                            placeholder=" " />
                                                        <div class="placeholder">
                                                            <p class="m-0">Email <span class="text-danger">*</span>:
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                    {{-- <fieldset class="mt-4">
                                        <legend>Others:</legend>
                                        <div class="row">
                                            <div class="col-md-4 mb-25">
                                                <div class="holder">
                                                    <div class="input-holder">
                                                        <input name="facebook_url" id="fb_url" class="input"
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
                                                        <input name="whatsapp_number" id="whatsapp" class="input"
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
                                                        <input name="email" id="mail" class="input"
                                                            type="email" required placeholder=" " />
                                                        <div class="placeholder">
                                                            <p class="m-0">Email <span
                                                                class="text-danger">*</span>:</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset> --}}
                                    <fieldset class="mt-4">
                                        <legend>Family Details:</legend>
                                        <div class="row">
                                            <div class="col-md-4 mb-25">
                                                <div class="holder">
                                                    <div class="input-holder">
                                                        <input required name="other_family_member" id="other_pets"
                                                            class="input" value="{{ old('other_family_member') }}"
                                                            type="number" placeholder="" />
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
                                                        <input name="number_of_children" id="children_num" class="input"
                                                            type="number" value="{{ old('number_of_children') }}"
                                                            placeholder="" />
                                                        <div class="placeholder">
                                                            <p class="m-0">Number of children:
                                                                <span class="text-danger">*</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mb-25">
                                                <div class="card p-3" id="number_of_children_container">
                                                    <h6 class="mb-1 fw-normal">Names and Ages of Spouse and children:</h6>
                                                    <div class="row mt-3 align-items-center" id="number_of_children">
                                                        <div class="col-md-3">
                                                            <div class="holder">
                                                                <div class="input-holder">
                                                                    <input name="mem_name[]" id="name[]"
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
                                                                <option value="husband">Husband</option>
                                                                <option value="wife">Wife</option>
                                                                <option value="children">Children</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="holder">
                                                                <div class="input-holder">
                                                                    <input name="mem_age[]" id="age[]" class="input"
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
                                                        <div><input id="yes" name="previously_purchased"
                                                                value="1" type="radio" /> <label
                                                                for="yes">Yes</label></div>
                                                        <div><input id="no" name="previously_purchased"
                                                                value="0" checked="" type="radio" /> <label
                                                                for="no">No</label></div>
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
                                                            @foreach ($products as $key => $product)
                                                                <option value="{{ $product->id }}">
                                                                    {{ $product->product_model }}</option>
                                                            @endforeach
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
                                                            @foreach ($showrooms as $key => $showroom)
                                                                <option value="{{ $showroom->id }}">{{ $showroom->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-25">
                                                <div class="holder">
                                                    <div class="input-holder">
                                                        <input name="shipping_address" id="s_address" class="input"
                                                            type="text" placeholder=" " required />
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
                                                        <input name="distance_from_showroom" id="distance"
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
                                        <div class="card p-3 mb-25 lgnd_card">
                                            <h6 class="lgnd_text">First Guarantor:</h6>
                                            <div class="row mt-2">
                                                <div class="col-md-3 mb-25">
                                                    <div class="holder">
                                                        <div class="input-holder">
                                                            <input required name="guarater_name[]" id="guarater_one_name"
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
                                                                <option value="father">Father</option>
                                                                <option value="husband">Husband</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-8 ps-0">
                                                            <div class="holder">
                                                                <div class="input-holder">
                                                                    <input required name="guarater_relation_name[]"
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
                                                                    <input name="guarater_nid[]" id="nid"
                                                                        class="input rounded-r-0" type="number"
                                                                        placeholder="Enter at least 10 digit National ID Number" />
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
                                                                    <input type="file" name="file" id="file3"
                                                                        class="inputfile"
                                                                        data-multiple-caption="{count} files selected"
                                                                        multiple />
                                                                    <label for="file3"><span><i
                                                                                class="uil uil-upload"></i></span></label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @error('guarater_nid.0')
                                                            <span
                                                                class="text-danger"><strong>{{ $message }}</strong></span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-4 d-flex align-items-center">
                                                    <span>Upload PDF JPG or PNG format.</span>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="holder">
                                                        <div class="input-holder">
                                                            <input required name="guarater_phone[]" id="org_mobile"
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
                                        <div class="card p-3 mb-25 lgnd_card">
                                            <h6 class="lgnd_text">Second Guarantor:</h6>
                                            <div class="row mt-2">

                                                <div class="col-md-3 mb-25">
                                                    <div class="holder">
                                                        <div class="input-holder">
                                                            <input required name="guarater_name[]" id="guarater_one_name"
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
                                                            <select required name="guarater_relation[]" id="g2_fhw_name"
                                                                class="form-control">
                                                                <option value="">Select</option>
                                                                <option value="father">Father</option>
                                                                <option value="husband">Husband</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-8 ps-0">
                                                            <div class="holder">
                                                                <div class="input-holder">
                                                                    <input required name="guarater_relation_name[]"
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
                                                                    <input name="guarater_nid[]" id="nid"
                                                                        class="input rounded-r-0" type="number"
                                                                        placeholder="Enter at least 10 digit National ID Number" />
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
                                                                    <input type="file" name="file" id="file3"
                                                                        class="inputfile"
                                                                        data-multiple-caption="{count} files selected"
                                                                        multiple />
                                                                    <label for="file3"><span><i
                                                                                class="uil uil-upload"></i></span></label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @error('guarater_nid.1')
                                                            <span
                                                                class="text-danger"><strong>{{ $message }}</strong></span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-4 d-flex align-items-center">
                                                    <span>Upload PDF JPG or PNG format.</span>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="holder">
                                                        <div class="input-holder">
                                                            <input required name="guarater_phone[]" id="org_mobile"
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
                                    </fieldset>
                                    <fieldset class="mt-4">
                                        <legend>Bank Information:</legend>
                                        <div class="row">
                                            <div class="col-md-3 mb-25">
                                                <div class="holder">
                                                    <div class="input-holder">

                                                        <select name="bank_id" id="bank_name" class="form-control">
                                                            <option value="">Bank </option>
                                                            @foreach ($banks as $key => $item)
                                                                <option value="{{ $item->id }}">{{ $item->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-25">
                                                <div class="holder">
                                                    <div class="input-holder">
                                                        <input name="bank_account_number" id="bank_account_number"
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
                                                        <input name="branch_name" id="branch_name" class="input"
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
                                                        <input name="checkque_number" id="checkque_number" class="input"
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
                        <div class="card card-default card-md mb-4 purchase_app">
                            <div class="card-body py-md-30">
                                <div class="form-group">
                                    <fieldset class="">
                                        <legend>Office Use Only:</legend>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <select required name="delivery_showroom_id" id="delivery_showroom_id"
                                                    class="form-control">
                                                    <option value="">Select Show Room</option>
                                                    @foreach ($showrooms as $key => $item)
                                                        <option @if (Auth::user()->showroom_id == $item->id) selected @endif
                                                            value="{{ $item->id }}">{{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-3">
                                                <select required name="product_group_id" onchange="GetCategory()"
                                                    id="group" class="form-control">
                                                    <option value="">Product Group</option>
                                                    @foreach ($product_type as $key => $type)
                                                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                                                    @endforeach

                                                </select>
                                            </div>
                                            <div class="col-md-3 mb-25">
                                                <div class="">
                                                    <div class="">
                                                        <select required name="product_category_id" id="Select-Model"
                                                            class="form-control category">
                                                        </select>
                                                        <span style="color: red" id="category-require"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <select required onchange="GetProduct()" name="product_brand_id"
                                                    id="prod_brand" class="form-control">
                                                    <option value="">Product Brand</option>
                                                    @foreach ($brands as $key => $brand)
                                                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <select required onchange="GetPrice()" name="product_model_id"
                                                    id="Select-color" class="form-control">
                                                    <option value="">Product Model:</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3">

                                                <input type="text" name="product_size_id" id="product_size"
                                                    class="form-control" placeholder="Product Size">

                                            </div>

                                            <div class="col-md-3 mb-25">
                                                <div class="holder">
                                                    <div class="input-holder">
                                                        <input required name="serial_no" id="serial_no" class="input"
                                                            type="text" placeholder=" " />
                                                        <div class="placeholder">
                                                            <p class="m-0">Serial No:<span class="text-danger">*</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-25">
                                                <div class="holder">
                                                    <div class="input-holder">
                                                        <input required name="cash_price" id="cash_price" class="input"
                                                            readonly type="number" placeholder=" " />
                                                        <div class="placeholder">
                                                            <p class="m-0">Cash Price:<span
                                                                    class="text-danger">*</span></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3 mb-25">
                                                <div class="holder">
                                                    <div class="input-holder">
                                                        <select required onchange="calculate()"
                                                            name="down_payment_parcentage" id="down_payment_parcentage"
                                                            class="form-control">
                                                            @foreach ($down_payment_parcentage as $key => $item)
                                                                <option
                                                                    @if ($item->payment_percentage == 40) @selected(true) @endif
                                                                    value="{{ $item->payment_percentage }}">
                                                                    {{ $item->payment_percentage }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3 mb-25">
                                                <div class="holder">
                                                    <div class="input-holder">
                                                        @foreach ($interestrate as $key => $interest_hid)
                                                            <input type="hidden"
                                                                id="interest_rate_{{ $interest_hid->month }}"
                                                                value="{{ $interest_hid->interest_rate }}">
                                                        @endforeach
                                                        <select required onchange="calculate()" name="installment_month"
                                                            id="installment_month" class="form-control">
                                                            <option value="">Installment Month</option>
                                                            @foreach ($interestrate as $key => $interest)
                                                                <option value="{{ $interest->month }}">
                                                                    {{ $interest->month }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-25">
                                                <div class="holder">
                                                    <div class="input-holder">
                                                        <input required name="hire_price" id="hire_price" class="input"
                                                            readonly type="text" placeholder=" " />
                                                        <div class="placeholder">
                                                            <p class="m-0">Hire Price:<span
                                                                    class="text-danger">*</span></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-25">
                                                <div class="holder">
                                                    <div class="input-holder">
                                                        <input readonly required name="down_payment" id="down_payment"
                                                            class="input" type="text" placeholder=" " />
                                                        <div class="placeholder">
                                                            <p class="m-0">Down Payment:<span
                                                                    class="text-danger">*</span></p>
                                                        </div>
                                                        <span id="alert_downpayment" class="text-danger"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-25">
                                                <div class="holder">
                                                    <div class="input-holder">
                                                        <input readonly required name="monthly_installment"
                                                            id="monthly_inst" class="input" type="text"
                                                            placeholder=" " />
                                                        <div class="placeholder">
                                                            <p class="m-0">Monthly Inst. Tk:<span
                                                                    class="text-danger">*</span></p>
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
                                <div id="capable_action" class="mb-3 alert alert-danger" style="display: none">
                                    <strong>Sorry!</strong> Monthly Installment must be at least 3000 Taka for you to be
                                    eligible.
                                </div>

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
        // Enhanced version that syncs with server
        class FormDraftManagerWithSync extends FormDraftManager {
            syncDraftToServer() {
                if (this.isOnline && this.isDirty) {
                    const formData = this.serializeForm();

                    fetch('/api/save-draft', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                    'content')
                            },
                            body: JSON.stringify({
                                form_data: formData
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            console.log('Draft synced to server');
                            this.showSaveStatus('Draft synced to server', 'success');
                        })
                        .catch(error => {
                            console.error('Server sync failed:', error);
                        });
                }
            }

            saveDraft() {
                super.saveDraft(); // Save locally first
                this.syncDraftToServer(); // Then sync to server if online
            }
        }
    </script>

    <script>
        // Auto-draft save system for hire purchase form
        class FormDraftManager {
            constructor(formSelector, options = {}) {
                this.form = document.querySelector(formSelector);
                this.draftKey = options.draftKey || 'hire_purchase_draft';
                this.saveInterval = options.saveInterval || 300; // 30 seconds
                this.isOnline = navigator.onLine;
                this.saveTimer = null;
                this.isDirty = false;

                this.init();
            }

            init() {
                if (!this.form) {
                    console.error('Form not found');
                    return;
                }

                this.setupEventListeners();
                this.loadDraft();
                this.startAutoSave();
                this.showDraftNotification();
            }

            setupEventListeners() {
                // Monitor form changes
                this.form.addEventListener('input', () => {
                    this.isDirty = true;
                    this.debouncedSave();
                });

                this.form.addEventListener('change', () => {
                    this.isDirty = true;
                    this.debouncedSave();
                });

                // Monitor connection status
                window.addEventListener('online', () => {
                    this.isOnline = true;
                    this.showConnectionStatus('online');
                    this.saveDraft(); // Save when back online
                });

                window.addEventListener('offline', () => {
                    this.isOnline = false;
                    this.showConnectionStatus('offline');
                    this.saveDraft(); // Save immediately when going offline
                });

                // Save before page unload
                window.addEventListener('beforeunload', (e) => {
                    if (this.isDirty) {
                        this.saveDraft();
                        // Optional: Show confirmation dialog
                        // e.preventDefault();
                        // e.returnValue = '';
                    }
                });

                // Handle form submission
                this.form.addEventListener('submit', () => {
                    this.clearDraft(); // Clear draft on successful submission
                });
            }

            debouncedSave() {
                clearTimeout(this.saveTimer);
                this.saveTimer = setTimeout(() => {
                    this.saveDraft();
                }, 2000); // Save 2 seconds after user stops typing
            }

            startAutoSave() {
                setInterval(() => {
                    if (this.isDirty) {
                        this.saveDraft();
                    }
                }, this.saveInterval);
            }

            saveDraft() {
                try {
                    const formData = this.serializeForm();
                    const draftData = {
                        data: formData,
                        timestamp: new Date().toISOString(),
                        url: window.location.href,
                        connectionStatus: this.isOnline ? 'online' : 'offline'
                    };

                    localStorage.setItem(this.draftKey, JSON.stringify(draftData));
                    this.isDirty = false;
                    this.showSaveStatus('Draft saved automatically');

                    console.log('Draft saved:', draftData);
                } catch (error) {
                    console.error('Error saving draft:', error);
                    this.showSaveStatus('Error saving draft', 'error');
                }
            }

            loadDraft() {
                try {
                    const savedDraft = localStorage.getItem(this.draftKey);
                    if (savedDraft) {
                        const draftData = JSON.parse(savedDraft);

                        // Check if draft is recent (within 24 hours)
                        const draftAge = Date.now() - new Date(draftData.timestamp).getTime();
                        const maxAge = 7 * 24 * 60 * 60 * 1000; // ৭ দিন
                        if (draftAge < maxAge) {
                            this.showDraftRestorePrompt(draftData);
                        } else {
                            this.clearDraft(); // Clear old drafts
                        }
                    }
                } catch (error) {
                    console.error('Error loading draft:', error);
                }
            }

            restoreDraft(draftData) {
                try {
                    Object.keys(draftData.data).forEach(name => {
                        const value = draftData.data[name];
                        const elements = this.form.querySelectorAll(`[name="${name}"], [name="${name}[]"]`);

                        if (Array.isArray(value)) {
                            elements.forEach((el, index) => {
                                if (el.type === 'checkbox' || el.type === 'radio') {
                                    el.checked = value.includes(el.value);
                                } else {
                                    el.value = value[index] || '';
                                }
                                el.dispatchEvent(new Event('change', {
                                    bubbles: true
                                }));
                            });
                        } else {
                            elements.forEach(el => {
                                if (el.type === 'checkbox' || el.type === 'radio') {
                                    el.checked = el.value === value;
                                } else {
                                    el.value = value;
                                }
                                el.dispatchEvent(new Event('change', {
                                    bubbles: true
                                }));
                            });
                        }
                    });

                    this.showSaveStatus('Draft restored successfully', 'success');
                } catch (error) {
                    console.error('Error restoring draft:', error);
                    this.showSaveStatus('Error restoring draft', 'error');
                }
            }


            serializeForm() {
                const formData = {};
                const elements = this.form.querySelectorAll('input, select, textarea');

                elements.forEach(element => {
                    if (element.name) {
                        if (element.type === 'checkbox' || element.type === 'radio') {
                            if (element.checked) {
                                const name = element.name.replace('[]', '');
                                if (!formData[name]) formData[name] = [];
                                formData[name].push(element.value);
                            }
                        } else {
                            let name = element.name;
                            if (name.includes('[]')) {
                                name = name.replace('[]', '');
                                if (!formData[name]) formData[name] = [];
                                formData[name].push(element.value || '');
                            } else {
                                formData[name] = element.value || '';
                            }
                        }
                    }
                });

                return formData;
            }

            clearDraft() {
                localStorage.removeItem(this.draftKey);
                this.isDirty = false;
            }

            showDraftRestorePrompt(draftData) {
                const draftDate = new Date(draftData.timestamp).toLocaleString();
                const message = `A draft was found from ${draftDate}. Would you like to restore it?`;

                if (confirm(message)) {
                    this.restoreDraft(draftData);
                } else {
                    this.clearDraft();
                }
            }

            showConnectionStatus(status) {
                // Remove existing status elements
                const existing = document.querySelector('.connection-status');
                if (existing) existing.remove();

                const statusEl = document.createElement('div');
                statusEl.className =
                    `alert connection-status ${status === 'online' ? 'alert-success' : 'alert-warning'}`;
                statusEl.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            min-width: 200px;
            animation: slideIn 0.3s ease;
        `;

                statusEl.innerHTML = `
            <strong>${status === 'online' ? '✓ Back Online' : '⚠ Connection Lost'}</strong>
            <br><small>${status === 'online' ? 'Form data synced' : 'Draft saved locally'}</small>
        `;

                document.body.appendChild(statusEl);

                // Auto-hide after 3 seconds
                setTimeout(() => {
                    if (statusEl.parentNode) {
                        statusEl.remove();
                    }
                }, 3000);
            }

            showSaveStatus(message, type = 'info') {
                const existing = document.querySelector('.save-status');
                if (existing) existing.remove();

                const statusEl = document.createElement('div');
                statusEl.className =
                    `save-status text-${type === 'error' ? 'danger' : type === 'success' ? 'success' : 'muted'}`;
                statusEl.style.cssText = `
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: white;
            padding: 8px 12px;
            border-radius: 4px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
            font-size: 12px;
            z-index: 1000;
        `;
                statusEl.textContent = message;

                document.body.appendChild(statusEl);

                setTimeout(() => {
                    if (statusEl.parentNode) {
                        statusEl.remove();
                    }
                }, 2000);
            }

            showDraftNotification() {
                const draftExists = localStorage.getItem(this.draftKey);
                if (draftExists) {
                    const notification = document.createElement('div');
                    notification.className = 'alert alert-info';
                    notification.innerHTML = `
                <strong>Draft Available:</strong> A previous draft was found.
                <button type="button" class="btn btn-sm btn-outline-primary ms-2" onclick="draftManager.loadDraft()">
                    Load Draft
                </button>
                <button type="button" class="btn btn-sm btn-outline-secondary ms-1" onclick="draftManager.clearDraft(); this.parentElement.remove()">
                    Discard
                </button>
            `;

                    // Insert at the top of the form
                    this.form.insertBefore(notification, this.form.firstChild);
                }
            }
        }

        // Initialize the draft manager
        document.addEventListener('DOMContentLoaded', function() {
            window.draftManager = new FormDraftManager('.parent-assign', {
                draftKey: 'hire_purchase_form_draft',
                saveInterval: 30000 // Save every 30 seconds
            });
        });

        // Add CSS animation
        const style = document.createElement('style');
        style.textContent = `
    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
`;
        document.head.appendChild(style);
    </script>



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

            // Display down payment alert if necessary
            //   if (payment > down_payment) {
            //     var alert_message = "You Must be need to pay " + test + "% bdt " + payment.toFixed(2);
            //     $("#alert_downpayment").html(alert_message);
            //     $("#save_button").css({
            //       'display': 'none'
            //     });
            //   } else {
            //     $("#alert_downpayment").html('');
            //     $("#save_button").css({
            //       'display': 'block'
            //     });
            //   }

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

            // Check down payment validity
            // if (payment.toFixed(2) >= down_payment.toFixed(2)) {
            //     var alert_message = "You must pay at least " + selectedPercentage + "% down payment: " + payment.toFixed(2) + " BDT";
            //     $("#alert_downpayment").html(alert_message);
            //     isDownPaymentValid = false;
            // } else {
            //     $("#alert_downpayment").html('');
            //     isDownPaymentValid = true;
            // }

            // Update button state based on all validations
            // if (isMonthlyInstallmentValid && isDownPaymentValid) {
            //     $("#save_button").prop('disabled', false).css({
            //         'display': 'block'
            //     });
            // } else {
            //     $("#save_button").prop('disabled', true).css({
            //         'display': 'none'
            //     });
            // }

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
        // function FindDistrictPar(){
        //         var district_id = $("#padrs_distric").val();
        //         const selectElement = $("#padrs_thana")[0]; // Get the DOM element
        //         $.post('{{ url('/find-upazila') }}', {_token:'{{ csrf_token() }}', district_id: district_id}, function(data){
        //             data = JSON.parse(data);
        //             console.log(data);
        //             selectElement.innerHTML = '';
        //             data.forEach(item => {
        //                 const option = document.createElement('option');
        //                 option.value = item.id; // Replace 'item.id' with the actual data field
        //                 option.textContent = item.name; // Replace 'item.name' with the actual data field
        //                 selectElement.appendChild(option);
        //             });
        //         });
        // }


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
