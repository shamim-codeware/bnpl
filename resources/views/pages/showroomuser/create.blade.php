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
                                    <h6>Add Sales Representative</h6>
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
                                    <form action="{{ url('show-room-user') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group row mb-n25">

                                            @if(Auth::user()->role_id == 3)
                                            <input type="hidden" name="showroom_id" value="{{ Auth::user()->name="showroom_id" }}"> 
                                            @else
                                            <div class="col-md-6" id="show_room" >
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

                                            @endif 
                                            
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
                                                        <input type="text" value="{{ old('code') }}" name="code"
                                                            placeholder="Code  " class="form-control">
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
                                         
                                            
                                            <div class="col-md-6">
                                                <div class="form-group mb-15">
                                                    <div class="position-relative">
                                                        <input id="password-field" type="text" class="form-control"
                                                            name="address" placeholder="Address">
                                                        {{-- <span toggle="#password-field"
                                                            class="uil uil-eye-slash text-lighten fs-15 field-icon toggle-password2"></span> --}}
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


  

@endsection
