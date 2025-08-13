@section('title', $title)
@section('description', $description)
@extends('layout.app')

@section('content')
    <div class="conatiner-fluid">
        <div class="form-element">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card card-default card-md mb-4">
                                <div class="card-header">
                                    <h6>Add User</h6>
                                    <a class="btn btn-primary" href="{{ url('user') }}">Users</a>
                                </div>
                                <div class="card-body py-md-30">
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    <form action="{{ url('user') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group row mb-n25">
                                            <div class="col-md-6">
                                                <div class="mb-25 select-style2">
                                                    <div class="dm-select ">
                                                        <select required onchange="CheckRole()" name="role_id" id="select-role"
                                                            class="form-control ">
                                                            <option value="">Select Role</option>
                                                            @foreach ($roles as $key => $role)
                                                                <option value="{{ $role->id }}">{{ $role->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="with-icon">
                                                    <div class="form-group form-group-calender mb-20">
                                                        <input required type="text" value="{{ old('name') }}"
                                                            name="name" placeholder="Name" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="with-icon">
                                                    <div class="form-group form-group-calender mb-20">
                                                        <input type="email" value="{{ old('email') }}" name="email"
                                                            placeholder="Email" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="with-icon">
                                                    <div class="form-group form-group-calender mb-20">
                                                        <input required type="number" value="{{ old('phone') }}"
                                                            name="phone" placeholder="Phone" class="form-control">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6" id="zone_hide">
                                                <div class="mb-25 select-style2">
                                                    <div class="dm-select ">
                                                        <select  name="zone_id" id="Select-zone"
                                                            class="form-control ">
                                                            <option value="">Select Zone</option>
                                                            @foreach ($zones as $key => $zone)
                                                                <option value="{{ $zone->id }}">{{ $zone->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6" id="show_room">
                                                <div class="mb-25 select-style2">
                                                    <div class="dm-select ">
                                                        <select  name="showroom_id" id="select-show-rooms"
                                                            class="form-control ">
                                                            <option value="">Select Show Rooms</option>
                                                            @foreach ($showrooms as $key => $showroom)
                                                                <option value="{{ $showroom->id }}">{{ $showroom->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <div class="form-group mb-15">
                                                    <div class="position-relative">
                                                        <input id="password-field" type="password" class="form-control"
                                                            name="password" placeholder="Password">
                                                        <span toggle="#password-field"
                                                            class="uil uil-eye-slash text-lighten fs-15 field-icon toggle-password2"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-15">
                                                    <div class="position-relative">
                                                        <input id="password-field" type="password" class="form-control"
                                                            name="c_password" placeholder="Confirm Password">
                                                        <span toggle="#password-field"
                                                            class="uil uil-eye-slash text-lighten fs-15 field-icon toggle-password2"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4 form-basic mt-4">
                                            <button type="submit" class="btn btn-lg btn-primary customr-btn btn-submit">save</button>
                                        </div>
                                       </div>
                                    
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        function CheckRole(){
            var role_id =  $("#select-role").val();
            if((role_id == 1) || (role_id == 6) ){

                $("#show_room").hide();
                $("#zone_hide").hide();
            }else if(role_id == 2){
                $("#zone_hide").show();
                $("#show_room").hide();
            }
            else{
                $("#show_room").show();
                $("#zone_hide").hide();
            }

        }
    </script>

@endsection
