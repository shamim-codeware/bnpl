@section('title',$title)
@section('description',$description)
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
                                <h6>Create User</h6>
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
                                <form action="{{ route('user.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                                    @method('put')
                                    @csrf 
                                    <div class="form-group row mb-n25">

                                        <div class="col-md-6">
                                            <div class="mb-25 select-style2">
                                                <div class="dm-select ">          
                                                    <select onchange="CheckRole()" name="role_id" id="select-role" class="form-control ">
                                                        <option value="{{ $user->role_id }}">{{ $user->role_id ? $user->roles->name : '' }}</option>
                                                    @foreach($roles as $key=>$role_f)
                                                    @if($role_f->id == $user->role_id )
                                                    @continue
                                                    @else 
                                                        <option value="{{ $role_f->id }}">{{ $role_f->name }}</option>
                                                        @endif
                                                       @endforeach
                                                    </select>          
                                                </div>           
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="with-icon">
                                                <div class="form-group form-group-calender mb-20">
                                                    <input type="text" value="{{ $user->name }}" name="name" placeholder="Name" class="form-control" >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="with-icon">
                                                <div class="form-group form-group-calender mb-20">
                                                    <input type="email" value="{{ $user->email }}" name="email" placeholder="Email" class="form-control" >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="with-icon">
                                                <div class="form-group form-group-calender mb-20">
                                                    <input type="number" value="{{ $user->phone }}" name="phone" placeholder="phone" class="form-control" >
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-md-6" id="zone_hide">
                                            <div class="mb-25 select-style2">
                                                <div class="dm-select ">
                                                    <select  name="zone_id" id="Select-zone"
                                                        class="form-control ">
                                                        <option value="{{ $user->zone_id }}">{{ $user->zone_id ? @$user->zones->name : 'Select Zone' }} </option>
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
                                                    <select name="showroom_id" id="select-show-rooms" class="form-control ">
                                                        <option value="{{ $user->showroom_id }}">{{ $user->showroom_id ? @$user->showrooms->name : '' }}</option>
                                                    @foreach($showrooms as $key=>$showroom)
                                                      @if($user->showroom_id == $showroom->id)
                                                      continue;
                                                      @else 
                                                      <option value="{{ $showroom->id }}">{{ $showroom->name }}</option>
                                                      @endif
                                                       
                                                       @endforeach
                                                    </select>          
                                                </div>           
                                            </div>
                                        </div>

                                       
                                       
                                        <!-- <div class="col-md-6">
                                            <div class="with-icon">
                                                <div class="form-group form-group-calender mb-20">
                                                    <input type="text" value="{{ $user->address }}" name="address" placeholder="Address" class="form-control" >
                                                </div>
                                            </div>
                                        </div>
                                       -->
                                        <!-- <div class="col-md-6">
                                            <div class="with-icon">
                                                <div class="form-group form-group-calender mb-20">
                                                    <input type="file" accept=".jpg,.jpeg,.png,.PNG,.svg,.webp" name="profile_photo" placeholder="phone" class="form-control" >
                                                </div>
                                            </div>
                                        </div> -->
                                       </div>
                                        <div class="col-md-4 form-basic mt-3">
                                            <button type="submit" class="btn btn-lg btn-primary customr-btn btn-submit">save</button>
                                            </div>
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


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script>
    $(document).ready(function(){
        
        CheckRole();
    });


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
