@section('title',$title)
@section('description',$description)
@extends('layout.app')
@section('content')
<style>
      #select-executive option:first-line {
        color: red;
    }

</style>
<div class="crm mb-25">
    <div class="container-fluid">
        <div class="form-element mt-3">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card card-default card-md mb-4">
                                <div class="card-header">
                                    <h6>New Product</h6>
                                    <a href="{{ route('product.index') }}" class="btn btn-primary">Manage Product</a>
                                </div>
                                <div class="card-body py-md-25">
                                    <form action="{{ url('product') }}" method="post">
                                        @csrf
                                         <fieldset class="mt-2">
                                            <legend>Interested In Items <span class="text-danger">*</span> :</legend>
                                            <div class="row">
                                                <div class="col-md-3 mb-25">
                                                    <div class=" select-style2">
                                                        <div class="dm-select ">
                                                            <select required  name="type_id" id="group" class="form-control " onchange="GetCategoryP()">
                                                                <option value="">Select Group*</option>

                                                            </select>
                                                            <span style="color: red" id="group-require"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 mb-25">
                                                    <div class="">
                                                        <div class="">
                                                            <select name="category_id" id="Select-Model" onchange="GetProduct()" class="form-control category">
                                                            </select>
                                                            <span style="color: red" id="category-require"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 mb-25">
                                                    <div class=" select-style2">
                                                        <div class="dm-select ">
                                                            <select required  name="brand_id" id="brand_id" class="form-control " >
                                                                <option value="">Select Brand*</option>
                                                                @foreach($brands as $key=>$brand)
                                                                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                                                @endforeach
                                                            </select>
                                                            <span style="color: red" id="group-require"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                 {{-- <div class="col-md-3 mb-25">
                                                    <div class="">
                                                        <div class="">
                                                              <input required name="name" id="name" class="input" type="text" placeholder="Product Name ">
                                                        </div>
                                                    </div>
                                                </div>  --}}

                                                   <div class="col-md-3 mb-25">
                                                    <div class="">
                                                        <div class="">
                                                              <input required name="product_model" id="name" class="input" type="text" placeholder="Product Model">

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 mb-25">
                                                    <div class="">
                                                        <div class="">
                                                              <input  name="hire_price" id="hire_price" class="input" type="number" placeholder="Product Price">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 mb-25">
                                                    <div class="">
                                                        <div class="">
                                                              <input name="product_desc" id="name" class="input" type="text" placeholder="Product Description">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-3 mb-25">
                                                    <div class="">
                                                        <div class="">
                                                            <input required name="size" id="name" class="input" type="text" placeholder="Product Size ">
                                                        </div>
                                                    </div>
                                                </div>



                                            </div>
                                         </fieldset>

                                        <div class="d-flex gap-2 justify-content-end align-items-center mt-2">
                                            <input id="Submit" class="btn btn-primary" type="submit" >
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

<script>




$(document).ready(function(){

        var url = '{{ url('/query-type')}}';
        const selectElement = document.getElementById("group");
        $.post(url, {_token:'{{ csrf_token() }}'}, function(data){

            selectElement.innerHTML = '';
            const fixedOption = document.createElement('option');
            fixedOption.value = '';
            fixedOption.textContent = 'Select all';
            selectElement.appendChild(fixedOption);
                data.forEach(item => {
                    const option = document.createElement('option');
                    option.value = item.id; // Replace 'item.value' with the actual data field
                    option.textContent = item.name; // Replace 'item.text' with the actual data field
                    selectElement.appendChild(option);
                });
           });



    })





</script>

@endsection
