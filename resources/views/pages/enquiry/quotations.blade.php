@section('title',$title)
@section('description',$description)
@extends('layout.app')

@section('content')

<h2>Follow-up</h2>

<div class="conatiner-fluid">
    <div class="form-element">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card card-default card-md mb-4">
                            <div class="card-header">
                                <h6>Follow-up</h6>
                            </div>
                            <div class="card-body py-md-30">
                                <form action="#">
                                    <div class="form-group row mb-n25">
                                        <div class="col-md-4 mb-25">
                                            <div class="with-icon">
                                                <span class="la-user lar color-light"></span>
                                                <input type="text" class="form-control  ih-medium ip-lightradius-xs b-light" id="inputNameIcon1" placeholder="Full name">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-25 select-style2">
                                                <div class="dm-select ">
            
                                                    <select  name="select-alerts2" id="select-alerts2" class="form-control ">
                                                        <option disabled hidden selected value="01">Follow-Up Information </option>
                                                        <option value="02">Purchase Tomorrow</option>
                                                        <option value="03">Next Week</option>
                                                        <option value="04">Next Month</option>
                                                        <option value="05">Others</option>
                                                    </select>
            
                                                </div>
            
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="with-icon">
                                                {{-- <span class="lar la-calendar-plus color-light"></span> --}}
                                                <div class="form-group form-group-calender mb-20">
                                                    <input placeholder="Next Follow-up date & time" class="form-control" onfocus="(this.type='datetime-local')"
                                                    onblur="(this.type='text')">
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-4">
                                            <div class="mb-25 select-style2">
                                                <div class="dm-select ">          
                                                    <select  name="select-alerts2" id="select-alerts2" class="form-control ">
                                                        <option value="01">Next Follow-up method</option>
                                                        <option value="02">Phone</option>
                                                        <option value="03">SMS</option>
                                                        <option value="04">Email</option>
                                                        <option value="05">Physical</option>
                                                    </select>          
                                                </div>           
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-25 select-style2">
                                                <div class="dm-select ">          
                                                    <select  name="select-alerts2" id="select-alerts2" class="form-control ">
                                                        <option value="01">Status</option>
                                                        <option value="02">Open</option>
                                                        <option value="03">Closed</option>
                                                        <option value="04">Purchased</option>
                                                        <option value="05">Lost</option>
                                                    </select>          
                                                </div>           
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-25 select-style2">
                                                <div class="dm-select ">          
                                                    <select  name="select-alerts2" id="select-alerts2" class="form-control ">
                                                        <option value="01">It will appear</option>
                                                        <option value="02">In case of Child status</option>
                                                        <option value="02">In case of Child status</option>
                                                  
                                                    </select>          
                                                </div>           
                                            </div>
                                        </div>


                                        <div class="col-md-4">
                                            <div class="mb-25">
                                                <textarea placeholder="Note" class="w-100 p-3">                                              
                                                </textarea>            
                                            </div>
                                        </div>



            
                                            </div>
                                        <div class="col-md-4 form-basic mt-3">
                                            <button type="button" class="btn btn-lg btn-primary customr-btn btn-submit">save</button>
            
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



<!-- <div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="breadcrumb-main">
                <h4 class="text-capitalize breadcrumb-title">{{ trans('menu.form-component') }}</h4>
                <div class="breadcrumb-action justify-content-center flex-wrap">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#"><i class="las la-home"></i>Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ trans('menu.form-component') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="form-element">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card card-default card-md mb-4">
                            <div class="card-header">
                                <h6>New Quotations</h6>
                            </div>
                            <div class="card-body py-md-30">
                                <form action="#">
                                    <div class="form-group row mb-n25">
                                        <div class="col-md-4">
                                            <div class="with-icon">
                                                <span class="lar la-calendar-plus color-light"></span>
                                                <div class="form-group form-group-calender mb-20">
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control  ih-medium ip-gray radius-xs b-light" id="datepicker8" placeholder="01/10/2021">
                                                        <a href="#"><img class="svg" src="{{ asset('assets/img/svg/calendar.svg') }}" alt="calendar"></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-25">
                                            <div class="with-icon">
                                                <span class="lab la-centercode color-light"></span>
                                                <input type="text" class="form-control  ih-medium ip-lightradius-xs b-light" id="inputNameIcon1" placeholder="Event Code">
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-25">
                                            <div class="with-icon position-relative">
                                                <span class="la-user lar color-light"></span>
                                                <input readonly type="text" class="form-control  ih-medium ip-lightradius-xs b-light" id="inputNameIcon1" placeholder="Customer Name">
                                                <div class="action-btn customer-btn-position">
                                                    <a href="#" class="btn add-btn btn-primary" data-bs-toggle="modal" data-bs-target="#new-member">
                                                        <i class="las la-user-plus"></i></a>
                                                    <div class="modal fade new-member" id="new-member" role="dialog" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content  radius-xl">
                                                                <div class="modal-header">
                                                                    <h6 class="modal-title fw-500" id="staticBackdropLabel">Create customer</h6>
                                                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                                        <i class="uil uil-times"></i>
                                                                    </button>
                                                                </div>
                                                                {{-- modal body --}}
                                                                <div class="modal-body">
                                                                    <div class="new-member-modal">
                                                                        <form class="">
                                                                            <div class="row row-cols-2">
                                                                                <div class="col mb-25">
                                                                                    <div class="with-icon">
                                                                                        <span class="la-user lar color-light"></span>
                                                                                        <input  type="text" class="form-control  ih-medium ip-lightradius-xs b-light" id="inputNameIcon1" placeholder="Full name">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col mb-25">
                                                                                    <div class="with-icon">
                                                                                        <span class="la-phone las color-light"></span>
                                                                                        <input type="text" class="form-control  ih-medium ip-lightradius-xs b-light" id="inputNameIcon1" placeholder="Mobile">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col mb-25">
                                                                                    <div class="with-icon">
                                                                                        <span class="la-phone las color-light"></span>
                                                                                        <input type="text" class="form-control  ih-medium ip-lightradius-xs b-light" id="inputNameIcon1" placeholder="Mobile">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group select-px-15">
                                              
                                                                                    <select class="form-control px-15" id="countryOption">
                                                                                        <option selected>Division</option>
                                                                                        <option>2</option>
                                                                                        <option>3</option>
                                                                                        <option>4</option>
                                                                                        <option>5</option>
                                                                                    </select>
                                                                                </div>
                                                                                <div class="col mb-25">
                                                                                    <div class="with-icon">
                                                                                        <span class="la-phone las color-light"></span>
                                                                                        <input type="text" class="form-control  ih-medium ip-lightradius-xs b-light" id="inputNameIcon1" placeholder="Alternative Mobile">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group select-px-15">
                                              
                                                                                    <select class="form-control px-15" id="countryOption">
                                                                                        <option selected>District</option>
                                                                                        <option>2</option>
                                                                                        <option>3</option>
                                                                                        <option>4</option>
                                                                                        <option>5</option>
                                                                                    </select>
                                                                                </div>
                                                                                <div class="col mb-25">
                                                                                    <div class="with-icon">
                                                                                        <span class="lar la-envelope color-light"></span>
                                                                                        <input type="text" class="form-control  ih-medium ip-lightradius-xs b-light" id="inputNameIcon1" placeholder="Email ">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col">
                                                                                    <div class="form-group select-px-15">
                                              
                                                                                        <select class="form-control px-15" id="countryOption">
                                                                                            <option selected>Thana/Upazila</option>
                                                                                            <option>2</option>
                                                                                            <option>3</option>
                                                                                            <option>4</option>
                                                                                            <option>5</option>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col mb-25">
                                                                                    <div class="with-icon">
                                                                                        <span class="lab la-accessible-icon color-light"></span>
                                                                                        <input type="text" class="form-control  ih-medium ip-lightradius-xs b-light" id="inputNameIcon1" placeholder="Occupation">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col mb-25">
                                                                                    <div class="with-icon">
                                                                                        <span class="la-lock las color-light"></span>
                                                                                        <input type="text" class="form-control  ih-medium ip-lightradius-xs b-light" id="inputNameIcon4" placeholder="Address
                                                                                        ">
                                                                                    </div>
                                                                                </div>
                                                                               

                                                                            </div>
                                                                            
                                                                            
                                                                           
                                                                         
                                                                            
                                                                            <div class="button-group d-flex pt-25">
                                                                                <button class="btn btn-primary btn-default btn-squared text-capitalize">add new customer
                                                                                </button>
                                                                                <button  data-bs-dismiss="modal" aria-label="Close" class="btn btn-light btn-default btn-squared fw-400 text-capitalize b-light color-light">cancel
                                                                                </button>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                                {{-- modal body end --}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-25">
                                            <div class="with-icon">
                                                <span class="la-phone las color-light"></span>
                                                <input type="text" class="form-control  ih-medium ip-lightradius-xs b-light" id="inputNameIcon1" placeholder="Mobile Number">
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-25">
                                            <div class="with-icon">
                                                <span class="lar la-envelope color-light"></span>
                                                <input type="text" class="form-control  ih-medium ip-lightradius-xs b-light" id="inputNameIcon1" placeholder="Email ">
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-25">
                                            <div class="with-icon">
                                                <span class="la-lock las color-light"></span>
                                                <input type="text" class="form-control  ih-medium ip-lightradius-xs b-light" id="inputNameIcon1" placeholder="Address ">
                                            </div>
                                        </div>
                                            <div class="col mb-25">
                                               <div class="form-control d-flex items-center justify-content-sm-start ih-medium ip-lightradius-xs b-light">
                                                   <label class="gender-postion d-block" for="">Gender:</label>
                                                   <div class="d-flex align-center align-items-center gap-1">
                                                       <div class="radio-theme-default custom-radio ">
                                                           <input class="radio" type="radio" name="radio-vertical" value=0 id="radio-vl5">
                                                           <label for="radio-vl5">
                                                               <span class="radio-text">Male</span>
                                                           </label>
                                                       </div>
                                                       <div class="radio-theme-default custom-radio ">
                                                           <input class="radio" type="radio" name="radio-vertical" value=0 id="radio-vl6">
                                                           <label for="radio-vl6">
                                                               <span class="radio-text">Female</span>
                                                           </label>
                                                       </div>
                                                    
                                                   </div>

                                               </div>
                                            </div>
                                            <div class="col-md-4 mb-25">
                                                <div class="with-icon">
                                                    <span class="las la-blind color-light"></span>
                                                    <input type="text" class="form-control  ih-medium ip-lightradius-xs b-light" id="inputNameIcon1" placeholder="Profession ">
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-25">
                                                <div class="with-icon">
                                                    <span class="lar la-handshake color-light"></span>
                                                    <input type="text" class="form-control  ih-medium ip-lightradius-xs b-light" id="inputNameIcon1" placeholder="Type of Buyer ">
                                                </div>
                                            </div>

                                         <div class="col-md-4">
                                            <div class="row mb-25">
                                                <div class="col-6">
                                                  <div class="with-icon">
                                                      <span class="las la-retweet color-light"></span>
                                                      <input type="text" class="form-control  ih-medium ip-lightradius-xs b-light" id="inputNameIcon1" placeholder="Customer Type ">
                                                  </div>
                                              </div>      
                                              <div class="col-6">
                                                <div class="with-icon">
                                                    <span class="las la-people-carry"></span>
                                                    <input type="text" class="form-control  ih-medium ip-lightradius-xs b-light" id="inputNameIcon1" placeholder="Buying Aspect">
                                                </div>
                                            </div>    
                                              </div>
                                         </div>
                                       
                                        
                                       
                                        <div class="col-md-4">
                                            <div class="mb-25 select-style2">
                                                <div class="dm-select ">
            
                                                    <select  name="select-alerts2" id="select-alerts2" class="form-control ">
                                                        <option selected value="01">Item</option>
                                                        <option value="02">Option 2</option>
                                                        <option value="03">Option 3</option>
                                                        <option value="04">Option 4</option>
                                                        <option value="05">Option 5</option>
                                                    </select>
            
                                                </div>
            
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="row mb-25">
                                                <div class="col-6">
                                                  <div class="with-icon">
                                                      <span class="las la-exchange-alt"></span>
                                                      <input type="text" class="form-control  ih-medium ip-lightradius-xs b-light" id="inputNameIcon1" placeholder="Exchange Brand ">
                                                  </div>
                                              </div>      
                                              <div class="col-6">
                                                <div class="with-icon">
                                                    <span class="las la-people-carry"></span>
                                                    <input type="text" class="form-control  ih-medium ip-lightradius-xs b-light" id="inputNameIcon1" placeholder="Model">
                                                </div>
                                            </div>    
                                              </div>
                                         </div>
                                    <div class="col-md-4">
                                        <div class="row mb-25">
                                            <div class="col-6">
                                              <div class="with-icon">
                                                  <span class="las la-exchange-alt"></span>
                                                  <input type="text" class="form-control  ih-medium ip-lightradius-xs b-light" id="inputNameIcon1" placeholder="Exchange Brand ">
                                              </div>
                                          </div>      
                                          <div class="col-6">
                                            <div class="with-icon">
                                                <span class="las la-people-carry"></span>
                                                <input type="text" class="form-control  ih-medium ip-lightradius-xs b-light" id="inputNameIcon1" placeholder="Model">
                                            </div>
                                        </div>    
                                          </div>

                                    </div>
                                    
                                        <div class="col-md-4 form-basic pb-4">
                                            <button type="button" class="btn btn-lg btn-primary customr-btn btn-submit">Add</button>
            
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
        <div class="row">
            <div class="col-12 mb-30">
                <div class="support-ticket-system support-ticket-system--search">
                   
                   
                    <div class="userDatatable userDatatable--ticket userDatatable--ticket--2 mt-1">
                        <div class="table-responsive">
                            <table class="table mb-0 table-borderless pb-0">
                                <thead>
                                    <tr class="userDatatable-header">
                                        <th>
                                            <span class="userDatatable-title">ID</span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title">Product </span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title">Model </span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title">Color </span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title">UOM </span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title">Price</span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title">Qty </span>
                                        </th>
                                        <th class="text-center">
                                            <span class="userDatatable-title">Amount
                                            </span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>01</td>
                                        <td>
                                            <div class="d-flex">
                                                <div class="userDatatable-inline-title">
                                                    <a href="#" class="text-dark fw-500">
                                                        <h6>Apache</h6>
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="userDatatable-content--subject">
                                                RTR 160 DD
                                            </div>
                                        </td>
                                        <td>
                                            <div class="userDatatable-content--subject">
                                                Red
                                            </div>
                                        </td>
                                        <td>
                                            <div class="userDatatable-content--priority">
                                                PCS
                                            </div>
                                        </td>
                                        <td>
                                            <div class="userDatatable-content--priority">
                                                2,21,000.00
                                            </div>
                                        </td>
                                        <td>
                                            <div class="userDatatable-content--priority">
                                            1
                                             </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="userDatatable-content--priority">
                                                10000
                                                 </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>01</td>
                                        <td>
                                            <div class="d-flex">
                                                <div class="userDatatable-inline-title">
                                                    <a href="#" class="text-dark fw-500">
                                                        <h6>Apache</h6>
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="userDatatable-content--subject">
                                                RTR 160 DD
                                            </div>
                                        </td>
                                        <td>
                                            <div class="userDatatable-content--subject">
                                                Red
                                            </div>
                                        </td>
                                        <td>
                                            <div class="userDatatable-content--priority">
                                                PCS
                                            </div>
                                        </td>
                                        <td>
                                            <div class="userDatatable-content--priority">
                                                2,21,000.00
                                            </div>
                                        </td>
                                        <td>
                                            <div class="userDatatable-content--priority">
                                            1
                                             </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="userDatatable-content--priority">
                                                10000
                                                 </div>
                                        </td>
                                    </tr>
                                   
                                 
                                </tbody>
                                <tfoot class="border-tfoot">
                                    <tr class="">
                                        <td colspan="6">

                                        </td>
                                        <td class="">
                                             <div class="fw-600">Total</div>
                                        </td>
                                        <td class="text-center">
                                             <div class="fw-500">120000</div>
                                        </td>
                                    </tr>
                                    <tr class="">
                                          <td colspan="4">
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="mb-25 select-style2">
                                                        <div class="dm-select ">
                    
                                                            <select  name="select-alerts2" id="select-Purchase-mode" class="form-control ">
                                                                <option value="01">Purchase Mode</option>
                                                                <option value="02">Option 2</option>
                                                                <option value="03">Option 3</option>
                                                                <option value="04">Option 4</option>
                                                                <option value="05">Option 5</option>
                                                            </select>
                    
                                                        </div>
                    
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="dm-tag-wrap">
                                                        <div class="dm-upload">
                                                            <div class="dm-upload__button">
                                                                <a href="javascript:void(0)" class="btn btn-lg btn-outline-lighten btn-upload" onclick="$('#upload-3').click()"> <img src="{{ asset('assets/img/svg/upload.svg') }}" alt="upload" class="svg"> Upload</a>
                                                                <input type="file" name="upload-3" class="upload-one" id="upload-3">
                                                            </div>
                                                            <div class="dm-upload__file">
                                                                <ul>
                                                                   
                                                                    
                                                                   
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="pt-sm-3">
                                                <div class="form-group form-element-textarea mb-20">
                                                    
                                                    <textarea placeholder="Note" class="form-control px-2 py-2" id="exampleFormControlTextarea1" rows="3"></textarea>
                                                </div>
                                            </div>
                                          </td>
                                          <td colspan="2"></td>
                                    <td colspan="2">
                                        <div class="d-flex subtotal-box justify-content-center">
                                            <div class="subtotal-td border-0 ">
                                                <div class="total-order subtotal-title text-center fs-14 fw-500">
                                                    <div class="">
                                                        <p>Discount :</p>
                                                    </div>
                                                    <p>Shipping : </p>
                                                    <p>Grand Total :</p>
                                                   
                                                </div>
                                            </div>

                                            <div class="subtotal-td">
                                                <div class="total-order  text-center fs-14 fw-500">
                                                    <p>$1,690.26</p>
                                                    <p>-$126.30</p>
                                                    <p>$46.30</p>
                                                  
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                      
                                    </tr>
                                </tfoot>
                            </table>
                            <div class="d-flex gap-2 pt-4">
                                <button class="btn btn-primary px-5">Save</button>
                                <button class="btn btn-secondary px-5">Draft</button>
                            </div>
                                                  
                        </div>
                     
                    </div>
                </div>
            </div>
         
        </div>
    </div>
</div> -->
@endsection
