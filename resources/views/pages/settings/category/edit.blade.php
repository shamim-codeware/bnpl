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
                                <h6>Update Product Category</h6>
                            </div>
                            <div class="card-body py-md-30">
                                <form action="{{url('category/'.$productcategory->id)}}" method="post">
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
                                                {{-- <span class="la-user lar color-light"></span> --}}
                                                <input type="text" value="{{ $productcategory->name }}" name="name" class="form-control  ih-medium ip-lightradius-xs b-light" id="inputNameIcon1" placeholder="Enquiry Type">
                                            </div>
                                        </div>
                                          <div class="col-md-4">
                                            <div class="mb-25 select-style2">
                                                <div class="dm-select ">
                                                      <select name="type_id" id="select-group" class="form-control">
                                                            <option value="{{ $productcategory->type_id ? $productcategory->type_id : '' }}">{{ $productcategory->type_id ? $productcategory->types->name : '' }}</option>
                                                            @foreach($types as $type)
                                                            <option value="{{ $type->id }}">{{ $type->name  }}</option>
                                                            @endforeach
                                                        </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 form-basic pb-4">
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
