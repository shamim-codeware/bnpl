@section('title',$title)
@section('description',$description)
@extends('layout.app')
@section('content')
<div class="crm mb-25">
    <div class="container-fluid">
        <div class="form-element mt-3">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card card-default card-md mb-4">
                                <div class="card-header">
                                    <h6>Profile</h6>
                                </div>
                                <div class="card-body py-md-25">
                                    <form action="{{ url('user/profile-update',$users->id) }}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <fieldset class="mt-2">
                                            <legend>Update Information:</legend>
                                        <div class="row"> 
                                            <div class="row-md-3">
                                                <div class="card card-default card-md mb-4">
                                                    <div class="card-header  py-20">
                                                    <h6>Profile Image</h6>
                                                    </div>
                                                    <div class="card-body">
                                                    <div class="dm-tag-wrap">
                                                        <div class="dm-upload position-relative">
                                                            <div class="dm-upload-avatar">
                                                                <img class="avatrSrc" src="{{ $users->profile_photo_path ? url($users->profile_photo_path) : 'https://i.postimg.cc/3xwWQ2PP/upload.png' }}" alt="Avatar Upload" >
                                                            </div>
                                                            <div class="avatar-up">
                                                                <input id="profile-img" accept="image/png, image/gif, image/jpeg" type="file" name="profile_photo" class="upload-avatar-input">
                                                            </div>
                                                            <label for="profile-img" style="top: 65px;
                                                            background: green;
                                                            color: #fff;
                                                            height: 20px;
                                                            width: 20px;
                                                            text-align: center;
                                                            line-height: 18px;
                                                            border-radius: 50%;cursor: pointer;" class="position-absolute">+</label>
                                                        </div>
                                                      </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-25">
                                                <div class="holder">
                                                    <div class="input-holder">
                                                    <input required onkeyup="CheckNumber()" name="name" id="name" class="input" type="text" value="{{ $users->name }}" placeholder=" ">
                                                    <div class="placeholder"><p class="m-0">Name</p></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-25">
                                                <div class="holder">
                                                    <div class="input-holder">
                                                    <input name="email" id="email" class="input" value="{{ $users->email }}" type="email" placeholder=" ">
                                                    <div class="placeholder"><p class="m-0">Email</p></div>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- <div class="col-md-3 mb-25">
                                                <div class="holder">
                                                    <div class="input-holder">
                                                    <input required name="name" id="name" class="input" type="password" placeholder=" ">
                                                    <div class="placeholder"><p class="m-0">Password</p></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-25">
                                                <div class="holder">
                                                    <div class="input-holder">
                                                    <input required name="name" id="name" class="input" type="password" placeholder=" ">
                                                    <div class="placeholder"><p class="m-0">New Password</p></div>
                                                    </div>
                                                </div>
                                            </div> --}}
                                        </div>
                                        </fieldset>
                                        <div class="d-flex gap-2 justify-content-end align-items-center mt-2">
                                        <input id="Submit" class="btn btn-primary"  type="submit" >
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
</div>
@endsection