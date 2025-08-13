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
                                    <h6>New Enquiry</h6>
                                    <a href="{{ route('enquiry.index') }}" class="btn btn-primary">Manage Enquiry</a>
                                </div>

                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <div class="card-body py-md-25">
                                    <form action="{{ url('enquiry') }}" method="post">
                                        @csrf 
                                        @if((Auth::user()->role_id == 1) OR (Auth::user()->role_id == 3) OR (Auth::user()->role_id == 6))
                                    <fieldset>
                                            <legend>Manage Showroom <span class="text-danger">*</span>:</legend>
                                        <div class="form-group row row-cols-lg-4 row-cols-1">                                     
                                          @if((Auth::user()->role_id == 1) OR (Auth::user()->role_id == 6))
                                            <div class="col mb-25">
                                                <div class="select-style2">
                                                    <div class="dm-select req">
                                                        <select onchange="findExecutive()" required name="showroom_id" id="select-showroom" class="form-control ">
                                                            <option value=""></option>
                                                            @foreach($showrooms as $key=>$showroom)
                                                            <option value="{{ $showroom->id }}">{{ $showroom->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div> 
                                          @endif 
                                            <div class="col mb-25">
                                                <div class="select-style2">
                                                    <div class="dm-select req">
                                                        <select required name="assign" id="select-executive" class="form-control ">
                                                            <option value="">Select Executive <span>*</span></option>
                                                            @foreach($executives as $key=>$executive)
                                                            <option value="{{ $executive->id }}">{{ $executive->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div> 
                                           
                                            </div>
                                        </fieldset>  

                                        @endif

                                        <fieldset class="mt-2">
                                            <legend>Customer:</legend>
                                        <div class="row"> 
                                            <div class="col-md-3 mb-25">
                                                <div class="holder">
                                                    <div class="input-holder">
                                                    <input required onkeyup="CheckNumber()" name="number" id="number" class="input" type="number" placeholder="+880123456789">
                                                    <div class="placeholder"><p class="m-0">Mobile <span class="text-danger">*</span></p></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3 mb-25">
                                                <div class="holder">
                                                    <div class="input-holder">
                                                    <input name="alt_number" id="alt_number" class="input" type="number" placeholder="+880123456789">
                                                    <div class="placeholder"><p class="m-0">Alternative Mobile</p></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-25">
                                                <div class="holder">
                                                    <div class="input-holder">
                                                    <input required name="name" id="name" class="input" type="text" placeholder=" ">
                                                    <div class="placeholder"><p class="m-0">Full Name<span class="text-danger">*</span></p></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-25">
                                                <div class="holder">
                                                    <div class="input-holder">
                                                    <input name="email" id="email" class="input" type="email" placeholder="Example@gmail.com">
                                                    <div class="placeholder"><p class="m-0">Email</p></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-25">
                                                <div class=" select-style2">
                                                    <div class="dm-select req">
                                                        <select  id="customer_profession" name="profession" id="select-customer-type" class="form-control ">
                                                            {{-- <option value="">*</option> --}}
                                                            @foreach($customers_professions as $key=>$customers_profession)
                                                            <option value="{{ $customers_profession->id }}">{{ $customers_profession->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-25">
                                                <div class="select-style2">
                                                    <div class="dm-select req">
                                                        <select name="gender" id="gender" class="form-control ">
                                                            <option value="">Gender</option>
                                                            <option value="Male">Male</option>
                                                            <option value="Female">Female</option>
                                                            <option value="Unisex">Unisex</option>
                                                            <option value="Others">Others</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3 mb-25">
                                                <div class="select-style2">
                                                    <div class="dm-select req">
                                                        <select name="age" id="age" class="form-control ">
                                                            <option value="">Age</option>
                                                            @for($i=12;$i<=80;$i++)
                                                            <option value="{{ $i }}">{{ $i }}</option>
                                                           @endfor
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-3 mb-25">
                                                <div class=" select-style2">
                                                    <div class="dm-select req">
                                                        <select  id="customer_type" name="type_id" class="form-control ">
                                                            <option value="">Customer Type</option>
                                                            @foreach($customer_types as $key=>$customer_type)
                                                            <option value="{{ $customer_type->id }}">{{ $customer_type->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-25">
                                                <div class=" select-style2">
                                                    <div class="dm-select ">
                                                        <select onchange="FindDistrict()" name="district_id" id="select-district" class="form-control ">
                                                            <option value="">Select District</option>
                                                            @foreach($districts as $key=>$district)
                                                            <option value="{{ $district->id }}">{{ $district->en_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        <div class="col-md-3 mb-25">
                                                <div class=" select-style2">
                                                    <div class="dm-select ">
                                                        <select  name="upazila_id" id="Select-upazila" class="form-control " >
                                                         <option value="">Select Upazila</option>
                                                   
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        </fieldset>
                                        <fieldset>
                                            <legend>Enquiry <span class="text-danger">*</span>:</legend>
                                        <div class="form-group row row-cols-lg-4 row-cols-1">
                                            <div class="col mb-25">
                                                <div class="select-style">
                                                    <div class="dm-select req">
                                                        <select required onchange="Source()" name="source_parent" id="Select-awareness" class="form-control ">
                                                            <option value="">Source of awareness*</option>
                                                            @foreach($sources_awerness as $key=>$sources_awerne)
                                                            <option value="{{ $sources_awerne->id }}">{{ $sources_awerne->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col mb-25" id="source" style="display: none">
                                                <div class="select-style2">
                                                    <div class="dm-select ">
                                                        <select required name="source_child" id="Select-follower" class="form-control ">
                                                            <option value="">Select Source </option>
                                                            
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col mb-25">
                                               <div class="select-style2">
                                                  <div class="dm-select req">
                                                      <select required name="buying_aspect" id="select-buying-aspect" class="form-control ">
                                                            <option value="">Buying Aspect*</option>
                                                            <option value="1">High</option>
                                                            <option value="2">Medium</option>
                                                            <option value="3">Low</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>  
                                            <div class="col">
                                                {{-- <span class="text-danger">*</span> --}}
                                                <div class="with-icon">
                                                    
                                                    <span class="lar la-calendar-plus color-light"></span>
                                                    <div class="form-group form-group-calender mb-20">
                                                        <div class="position-relative req1">
                                                            <input style="padding: 0 35px !important" autocomplete="off" required  type="text" name="sales_date" class="form-control ih-medium ip-gray radius-xs b-light" id="datepicker8" placeholder="Expected Sales Date">
                                                            {{-- <a href="#"><img class="svg" src="{{ asset('assets/img/svg/calendar.svg') }}" alt="calendar"></a> --}}
                                                            {{-- <span style="top: 25px;
                                                            left: 140px;" class="text-danger position-absolute">*</span> --}}
                                                        </div>
                                                        
                                                    </div>
                                                    
                                                </div>
                                                
                                            </div>

                                            <div class="col mb-25">
                                                <div class=" select-style2">
                                                    <div class="dm-select req">
                                                        <select required name="purchase_mode" id="select-Type-1" class="form-control purchase_mode">
                                                            <option value="">Purchase Mode</option>
                                                            @foreach($purchasemods as $key=>$purchasemod)
                                                            <option value="{{ $purchasemod->id }}">{{ $purchasemod->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div> 
                                           
                                            <div class="col mb-25">
                                                <div class=" select-style2">
                                                    <div class="form-control d-flex gap-3 align-items-center">
                                                        <p class="mb-0">Offers : </p>
                                                        <div onclick="yes()" id="yes">
                                                            <input name="offer" value="1" type="radio"> <label for="Yes">Yes</label> 
                                                        </div>
                                                        <div onclick="no()" id="no">
                                                            <input name="offer" value="0" checked type="radio"> <label for="no">No</label> 
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div id="Offerpage"  class="col mb-25 custom-height" style="display: none;">
                                                    <div class="wrapper-block card p-2">
                                                        <div class="col-lg-4">
                                                            <div class="d-flex gap-1">
                                                                <input id="Exchange" name="type_of_offer[]" value="Exchange" type="checkbox">
                                                                <label class="text-dark" for="Exchange">Exchange</label>
                                                            </div>
                                                         
                                                        </div>
                                                        <div class="col-lg-2">
                                                            <div class="d-flex gap-1">
                                                                <input name="type_of_offer[]" id="EMI" type="checkbox" value="EMI">
                                                                <label class="text-dark" for="EMI">EMI</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="d-flex gap-1">
                                                                <input name="type_of_offer[]" id="Discount" value="Discount" type="checkbox">
                                                                <label class="text-dark" for="Discount">Discount</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-2">
                                                            <div class="d-flex gap-1">
                                                                <input value="Gift" name="type_of_offer[]" id="Gift" type="checkbox">
                                                                <label class="text-dark" for="Gift">Gift</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                               </div>
                                            </div>
                                        </fieldset>

   
                                        
                                        <fieldset class="mt-2">
                                            <legend>Interested In Items <span class="text-danger">*</span> :</legend>
                                            <div class="row">
                                              <div class="col-md-3 mb-25">
                                                  <div class=" select-style2">
                                                      <div class="dm-select ">
                                                          <select required  name="group" id="group" class="form-control " onchange="GetCategory()">
                                                              <option value="">Select Group*</option>
                                                             
                                                          </select>
                                                          <span style="color: red" id="group-require"></span>
                                                      </div>
                                                  </div>
                                              </div>
                                              <div class="col-md-3 mb-25">
                                                  <div class="">
                                                      <div class="">
                                                          <select name="category" id="Select-Model" onchange="GetProduct()" class="form-control category">
                                                          </select>
                                                          <span style="color: red" id="category-require"></span>
                                                      </div>
                                                  </div>
                                              </div> 
                                              <div class="col-md-4 mb-25">
                                                  <div class=" select-style2">
                                                      <div class="dm-select ">
                                                          <select name="product" id="Select-color"  class="form-control ">
                                                              <option value="">Product Name</option>
                                                             
                                                          </select>
                                                          <span style="color: red" id="product-require"></span>
                                                      </div>
                                                  </div>
                                              </div> 
                                              <div class="col-md-2 mb-25">
                                                   <button type="button" onclick="AddItem()" class="btn btn-primary w-30">Add Item</button>
                                              </div>
                                              <div class="col-12">
  
                                                  <div class="userDatatable userDatatable--ticket userDatatable--ticket--2 mt-1">
                                                      <div class="table-responsive custom-data-table-wrapper2">
                                                          <table class="table mb-0 table-bordered custom-data-table">
                                                              <thead>
                                                                  <tr class="userDatatable-header">
                                                                      <th>
                                                                          <span class="userDatatable-title">SL</span>
                                                                      </th>
                                                                      <th>
                                                                          <span class="userDatatable-title">Group </span>
                                                                      </th>
                                                                      <th>
                                                                          <span class="userDatatable-title">Category</span>
                                                                      </th>
                                                                      <th>
                                                                          <span class="userDatatable-title">Product Name
                                                                              </span>
                                                                      </th>
                                                                      <th>
                                                                          <span class="userDatatable-title">Action
                                                                          </span>
                                                                      </th>
                                                                      
                                                                  </tr>
                                                              </thead>
                                                              <tbody id="tableBody">
                                                                
                                                              </tbody>
                                                          </table>
                                                      </div>
                                                  </div>
                                              </div>
                                            </div>
                                         </fieldset>
                                <fieldset class="mt-2">
                                        <legend>Next Follow-up <span class="text-danger">*</span> :</legend>
                                    <div class="row row-cols-1 row-cols-lg-5">  
                                        <div class="col-md-3">
                                            <div class="with-icon position-relative">
                                               
                                                <?php
                                                    date_default_timezone_set('Asia/Dhaka');

                                                    $currentDateTime = date('m/d/Y H:i:s');  // Get the current date and time
                                                    $oneDayLater = date('m/d/Y H:i:s', strtotime($currentDateTime . ' +1 day'));
                                                    //dd($oneDayLater);
                                                   
                                                 ?>
                                                <div class="form-group req1 form-group-calender mb-20">
                                                    <input  type="text"  name="next_follow_up_date" placeholder="Follow-up date & time" class="flatpickr form-control" required>
                                                </div>
                                                {{-- <span style="top: 25px;
                                                            left: 150px;" class="text-danger position-absolute">*</span> --}}
                                                             {{-- <span class=" px-3 lar la-calendar-plus color-light"></span> --}}
                                            </div>
                                        </div>
                                        <div class="col mb-25">
                                            <div class="select-style2">
                                                <div class="dm-select">
                                                    <select required name="next_follow_up_method" class="form-control next_follow_up_method">
                                                        <option value="">Follow-up method</option>
                                                        @foreach($methods as $row=>$method)
                                                        <option value="{{ $method->id }}">{{ $method->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </fieldset>
                                    <div class="d-flex gap-2 justify-content-end align-items-center mt-2">
                                        {{-- <input class="btn btn-warning" type="submit" value="Draft"> --}}
                                        <input id="Submit" class="btn btn-primary" disabled type="submit" >
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
   

function findExecutive(){
        var parent_id = $("#select-showroom").val();
        if((parent_id == 4) && $("#next_follow_up_date").val() == undefined){
        $("#required").show();
    }else{
        $("#required").hide();
    }
      
        const selectElement = document.getElementById("select-executive");
        $.post('{{ url('/select-executive')}}', {_token:'{{ csrf_token() }}',parent_id:parent_id}, function(data){
           data = JSON.parse(data);
            selectElement.innerHTML = '';
            const fixedOption = document.createElement('option');
            fixedOption.value = '';
            fixedOption.textContent = 'select all';
            selectElement.appendChild(fixedOption);
                data.forEach(item => {
                    const option = document.createElement('option');
                    option.value = item.id; 
                    option.textContent = item.name;
                    selectElement.appendChild(option);
                });
        });
    }


function yes() {  
        $("#Offerpage").show();
    }
function no() {
    $("#Offerpage").hide();
 }
    function Source(){
        var parent_id = $("#Select-awareness").val();
        const selectElement = document.getElementById("Select-follower");
        $.post('{{ url('/source-awareness')}}', {_token:'{{ csrf_token() }}',parent_id:parent_id}, function(data){

            if(data.length > 2 ){
                $("#source").show();
            }else{
                $("#source").hide();
           }
            data = JSON.parse(data);
            selectElement.innerHTML = '';
            const fixedOption = document.createElement('option');
            fixedOption.value = '';
            fixedOption.textContent = 'select all';
            selectElement.appendChild(fixedOption);
                data.forEach(item => {
                    const option = document.createElement('option');
                    option.value = item.id; 
                    option.textContent = item.name;
                    selectElement.appendChild(option);
                });
        });
    }

    function CheckNumber(){
        var number = $("#number").val();
        $.post('{{ url('/customer-enquiry')}}', {_token:'{{ csrf_token() }}',number:number}, function(data){
            var data = JSON.parse(data);
            if(data != null){
                $("#name").val(data.name);
                $("#customer_type").val(data.type_id);
                $("#email").val(data.email);
                $("#alt_number").val(data.alt_number);
                $("#profession").val(data.profession);
                $("#gender").val(data.gender);
            }else{
                $("#name").val('');
                $("#customer_type").val('');
                $("#email").val('');
                $("#alt_number").val('');
                $("#profession").val('');
                $("#gender").val('');
            }
      });
    }

function addTableRow(data1, data2,data3,data4,data5) {
    var tableBody = document.getElementById("tableBody");
    var row = tableBody.insertRow();
    row.setAttribute("data-id", data1);
    var cell1 = row.insertCell(0);
    cell1.innerHTML = data1;
    var cell2 = row.insertCell(1);
    cell2.innerHTML = data2;
    var cell3 = row.insertCell(2);
    cell3.innerHTML = data3;
    var cell4 = row.insertCell(3);
    cell4.innerHTML = data4;
    var cell5 = row.insertCell(4);
    cell5.innerHTML = data5;

}

function deleteTableRow(rowId) {
    var tableBody = document.getElementById("tableBody");
    var rowToDelete = tableBody.querySelector('[data-id="' + rowId + '"]');
    if (rowToDelete) {
        rowToDelete.remove();
    }
}


$(document).ready(function(){
        var url = '{{ url('/query-type')}}';
        const selectElement = document.getElementById("group");
        $.post(url, {_token:'{{ csrf_token() }}'}, function(data){
            // console.log(data);
            selectElement.innerHTML = '';
            const fixedOption = document.createElement('option');
            fixedOption.value = '';
            fixedOption.textContent = 'select all';
            selectElement.appendChild(fixedOption);
                data.forEach(item => {
                    const option = document.createElement('option');
                    option.value = item.name+'-'+item.id; // Replace 'item.value' with the actual data field
                    option.textContent = item.name; // Replace 'item.text' with the actual data field
                    selectElement.appendChild(option);
                });
           });
    })

function GetCategory(){
            var parentElement = document.getElementById("Select-Model");
            var url = '{{ url('/query-category')}}';
            var grp_id = $("#group").val();
            const myArray = grp_id.split("-");
            $.post(url, {_token:'{{ csrf_token() }}',type:myArray[1]}, function(data){
            parentElement.innerHTML = '';
            const fixedOption = document.createElement('option');
            fixedOption.value = '';
            fixedOption.textContent = 'select all';
            parentElement.appendChild(fixedOption);
          
            data.forEach(item => {
                const option = document.createElement('option');
            option.value = item.name+'-'+item.id; // Replace 'item.value' with the actual data field
            option.textContent = item.name; // Replace 'item.text' with the actual data field
            parentElement.appendChild(option);
         });
      });

}


var count = 1;
function AddItem(){

    $("#Submit").removeAttr("disabled");
    var grp_id = $("#group").val();
    var category = $("#Select-Model").val();
    var product = $("#Select-color").val();
    console.log(product);
    var cat_info  = category.split("-");
    const groupt = grp_id.split("-");

    var product_with_id = product.split("@");
   // console.log(product_with_id);

    if(grp_id == ''){

        $("#group-require").html("Please Fill Up This field");
        return false;
    }else if(category == ''){
        $("#category-require").html("Please Fill Up This field");
        return false;
    }else if(product == null)
    {
        $("#product-require").html("Please Fill Up This field");
        return false;

    }
    $("#product-require").html("");
    $("#category-require").html("");
    $("#group-require").html("");
    addTableRow(
        count,'<input type="hidden" name="group_name[]" value="'+groupt[0]+'"><input type="hidden" name="group_id[]" value="'+groupt[1]+'">'+groupt[0],'<input type="hidden" name="category_name[]" value="'+cat_info[0]+'"><input type="hidden" name="category_id[]" value="'+cat_info[1]+'">'+cat_info[0],'<input type="hidden" name="product_name[]" value="'+product_with_id[0]+'"><input type="hidden" name="product_id[]" value="'+product_with_id[1]+'">'+product_with_id[0],'<div class="d-flex"><button type="button" title="edit" onclick="deleteTableRow('+count+')" class="remove"><i class="uil uil-trash-alt"></i></button></div>'
        );
    count++;



   // $("#Select-Model").val('');
    $("#Select-color").val('');


}



</script>

@endsection