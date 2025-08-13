@section('title',$title)
@section('description',$description)
@extends('layout.app')

@section('content')
<div class="container-fluid">
    
    <div class="form-element">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card card-default card-md mb-4">
                            <div class="card-header">
                                <h6>Update Interest Rate </h6>
                            </div>
                            <div class="card-body py-md-30">
                                <form action="{{url('interest-rate/'.$InterestRate->id)}}" method="post">
                                    @method('put')
                                    @csrf 

                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    <div class="form-group row mb-n25">
                                        <div class="col-md-4 mb-25">
                                            <div class="with-icon">
                                                <label for="">Month </label>
                                                <input type="text" value="{{ $InterestRate->month }}" name="month" class="form-control  ih-medium ip-lightradius-xs b-light" id="inputNameIcon1" placeholder="Enquiry Type">
                                            </div>
                                        </div>
                                          <div class="col-md-4">
                                            <label for="">Interest Rate</label>
                                            <input style="padding: 0 20px !important" required type="text" name="interest_rate" value="{{ $InterestRate->interest_rate }}"  class="form-control px-2  " id="" placeholder="Interest Rate ">
                                        </div>
                                        <div class="col-md-4 form-basic pb-4">
                                            <label for=""></label>
                                            <button  type="submit" class="btn btn-lg btn-primary customr-btn btn-submit">Update</button>
            
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
</div>
@endsection
