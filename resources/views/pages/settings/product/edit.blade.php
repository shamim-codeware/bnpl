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
                                    <h6>Edit Product</h6>
                                    <a href="{{ route('product.index') }}" class="btn btn-primary">Manage Enquiry</a>
                                </div>
                                <div class="card-body py-md-25">
                                    <form action="{{ url('product/'.$product->id) }}" method="post">
                                        @method('put')
                                        @csrf
                                         <fieldset class="mt-2">
                                            <legend>Interested In Items <span class="text-danger">*</span> :</legend>
                                            <div class="row">
                                                <div class="col-md-3 mb-25">
                                                    <div class=" select-style2">
                                                        <div class="dm-select ">
                                                            <select required  name="type_id" id="group" class="form-control " onchange="GetCategoryP()">
                                                                <option value="{{ $product->type_id ? $product->type_id : ''  }}">{{ $product->type_id ? $product->types->name : ''  }}</option>
                                                                 @foreach ($types as $type  )
                                                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                                                                      @endforeach
                                                            </select>
                                                            <span style="color: red" id="group-require"></span>
                                                        </div>
                                                    </div>
                                                </div>

                                                   <div class="col mb-25">
                                                <div class=" select-style2">
                                                    <div class="dm-select ">
                                                        <select  name="category_id" id="Select-Model" class="form-control " required>
                                                         <!--<option value="{{ $product->category_id ? $product->category_id : '' }}">{{ $product->category_id ? $product->categories->name : '' }}</option>-->
                                                           @foreach ($category as $item  )
                                                                <option @if($item->id == $product->category_id )    @endif  value="{{ $item->id }}" >{{ $item->name }}</option>
                                                                      @endforeach

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3 mb-25">
                                                <div class=" select-style2">
                                                    <div class="dm-select ">
                                                        <select   name="brand_id" id="" class="form-control " >
                                                            <option value="{{ $product->brand_id }}">{{ $product->brand_id ? @$product->brands->name : 'Product Brand' }}</option>
                                                            @foreach($brands as $key=>$brand)
                                                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        <span style="color: red" id="group-require"></span>
                                                    </div>
                                                </div>
                                            </div>

                                                   <div class="col-md-3 mb-25">
                                                    <div class="">
                                                        <div class="">
                                                              <input required name="product_model" id="name" value="{{ $product->product_model }}"  class="input" type="text" placeholder="Product Model">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-3 mb-25">
                                                    <div class="">
                                                        <div class="">
                                                              <input value="{{ $product->hire_price }}" name="hire_price" id="hire_price" class="input" type="number" placeholder="Product Price">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-3 mb-25">
                                                    <div class="">
                                                        <div class="">
                                                              <input name="product_desc" value="{{ $product->product_desc }}"  id="name" class="input" type="text" placeholder="Product Description">
                                                        </div>
                                                    </div>
                                                </div>
                                               <div class="col-md-3 mb-25">
                                                    <div class="">
                                                        <div class="">
                                                              <input required name="size" id="name" value="{{ $product->size }}" class="input" type="text" placeholder="Product Size ">
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

        // var url = '{{ url('/query-type')}}';
        // const selectElement = document.getElementById("group");
        // $.post(url, {_token:'{{ csrf_token() }}'}, function(data){

        //     selectElement.innerHTML = '';
        //     const fixedOption = document.createElement('option');
        //     fixedOption.value = '';
        //     fixedOption.textContent = 'Select all';
        //     selectElement.appendChild(fixedOption);
        //         data.forEach(item => {
        //             const option = document.createElement('option');
        //             option.value = item.id; // Replace 'item.value' with the actual data field
        //             option.textContent = item.name; // Replace 'item.text' with the actual data field
        //             selectElement.appendChild(option);
        //         });
        //    });



    })

function GetCategory(){
            var parentElement = document.getElementById("Select-Model");
            var url = '{{ url('/query-category')}}';
            var grp_id = $("#group").val();
            // const myArray = grp_id.split("-");
            $.post(url, {_token:'{{ csrf_token() }}',type:grp_id}, function(data){
            parentElement.innerHTML = '';
            const fixedOption = document.createElement('option');
            fixedOption.value = '';
            fixedOption.textContent = 'select all';
            parentElement.appendChild(fixedOption);

            data.forEach(item => {
                const option = document.createElement('option');
            option.value = item.id; // Replace 'item.value' with the actual data field
            option.textContent = item.name; // Replace 'item.text' with the actual data field
            parentElement.appendChild(option);
         });
      });

}




</script>

@endsection
