@section('title', $title)
@section('description', $description)
@extends('layout.app')

@section('content')
    <div class="container-fluid">
        <div class="form-element">
            <form action="{{ url('resend-erp') }}" method="post" enctype="multipart/form-data" class="parent-assign">
                @csrf
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card card-default card-md mb-4 purchase_app">
                            <div class="card-header">
                                <h6>Erp Api Status</h6>
                                <p>
                                    Status : {{ @$response->status }}
                                    <br>
                                    Message : {{ @$response->msg }}
                                </p>
                            </div>
                            <div class="card-body py-md-30">
                                <div class="form-group">
                                    <fieldset>
                                        <legend>Personal Information:</legend>
                                        <div class="row">
                                            <!-- Name -->
                                            <div class="col-md-6 mb-25">
                                                <div class="holder">
                                                    <div class="input-holder">
                                                        <input required name="name" id="name" class="input" type="text"
                                                            value="{{ $customer_info->name }}" placeholder=" " />
                                                        <div class="placeholder">
                                                            <p class="m-0">Applicant's full name (With Surname)<span class="text-danger">*</span></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Mobile -->
                                            <div class="col-md-6 mb-25">
                                                <div class="holder">
                                                    <div class="input-holder">
                                                        <input required name="mobile" id="mobile" class="input" type="text"
                                                            value="{{ $customer_info->mobile }}" placeholder=" " />
                                                        <div class="placeholder">
                                                            <p class="m-0">Mobile Number<span class="text-danger">*</span></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Email -->
                                            <div class="col-md-6 mb-25">
                                                <div class="holder">
                                                    <div class="input-holder">
                                                        <input type="hidden" value="{{ $id }}" name="id">
                                                        <input required name="email" id="email" class="input" type="email"
                                                            value="{{ @$customer_info->email }}" placeholder=" " />
                                                        <div class="placeholder">
                                                            <p class="m-0">Email Address<span class="text-danger">*</span></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Address -->
                                            <div class="col-md-6 mb-25">
                                                <div class="holder">
                                                    <div class="input-holder">
                                                        <input required name="address" id="address" class="input" type="text"
                                                            value="{{ @$customer_info->address }}" placeholder=" " />
                                                        <div class="placeholder">
                                                            <p class="m-0">Address<span class="text-danger">*</span></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                             <!-- Address -->
                                             <div class="col-md-6 mb-25">
                                                <div class="holder">
                                                    <div class="input-holder">
                                                        <input required name="city" id="city" class="input" type="text"
                                                            value="{{ @$customer_info->city }}" placeholder=" " />
                                                        <div class="placeholder">
                                                            <p class="m-0">City<span class="text-danger">*</span></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Date of Birth -->
                                            <div class="col-md-6 mb-25">
                                                <div class="holder">
                                                    <div class="input-holder">
                                                        <input required name="date_of_birth" id="date_of_birth" class="input" type="date"
                                                            value="{{ @$customer_info->date_of_birth }}" placeholder=" " />
                                                        <div class="placeholder">
                                                            <p class="m-0">Date of Birth<span class="text-danger">*</span></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Designation -->
                                            <div class="col-md-6 mb-25">
                                                <div class="holder">
                                                    <div class="input-holder">
                                                        <input required name="designation" id="designation" class="input" type="text"
                                                            value="{{ @$customer_info->designation }}" placeholder=" " />
                                                        <div class="placeholder">
                                                            <p class="m-0">Designation<span class="text-danger">*</span></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Profession -->
                                            <div class="col-md-6 mb-25">
                                                <div class="holder">
                                                    <div class="input-holder">
                                                        <input required name="profession" class="input" type="text"
                                                            value="{{ @$customer_info->profession }}" placeholder=" " />

                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Organization -->
                                            <div class="col-md-6 mb-25">
                                                <div class="holder">
                                                    <div class="input-holder">
                                                        <input required name="org" id="org" class="input" type="text"
                                                            value="{{ @$customer_info->org }}" placeholder=" " />
                                                        <div class="placeholder">
                                                            <p class="m-0">Organization<span class="text-danger">*</span></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                        </div>

                        <div class="card card-default card-md mb-4 purchase_app">
                            <div class="card-body py-md-30">
                                <div class="form-group">
                                    <fieldset class="">
                                        <legend>Order Info:</legend>
                                        <div class="row">
                                            <div class="col-md-3 mb-25">
                                                <div class="holder">
                                                    <div class="input-holder">
                                                        <input  name="eorder_no" id="eorder_no" class="input"
                                                            value="{{ $order_info->eorder_no }}" type="text" placeholder=" " />
                                                        <div class="placeholder">
                                                            <p class="m-0">Order No:<span
                                                                    class="text-danger">*</span></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-25">
                                                <div class="holder">
                                                    <div class="input-holder">
                                                        <input  name="entry_date" id="entry_date" class="input"
                                                            value="{{ $order_info->entry_date }}" type="text" placeholder=" " />
                                                        <div class="placeholder">
                                                            <p class="m-0">Entry Date:<span
                                                                    class="text-danger">*</span></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-25">
                                                <div class="holder">
                                                    <div class="input-holder">
                                                        <input required name="down_payment" id="down_payment" class="input"
                                                            value="{{ $order_info->down_payment }}" type="text" placeholder=" " />
                                                        <div class="placeholder">
                                                            <p class="m-0">Down Payment:<span
                                                                    class="text-danger">*</span></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-25">
                                                <div class="holder">
                                                    <div class="input-holder">
                                                        <input required name="instalments_rate" id="instalments_rate" class="input"
                                                            value="{{ @$order_info->instalments_rate }}" type="text" placeholder=" " />
                                                        <div class="placeholder">
                                                            <p class="m-0">Installment Rate:<span
                                                                    class="text-danger">*</span></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-25">
                                                <div class="holder">
                                                    <div class="input-holder">
                                                        <input required name="no_instalments" id="no_instalments" class="input"
                                                            value="{{ $order_info->no_instalments }}" type="number" placeholder=" " />
                                                        <div class="placeholder">
                                                            <p class="m-0">Number Of Installment :<span
                                                                    class="text-danger">*</span></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-25">
                                                <div class="holder">
                                                    <div class="input-holder">
                                                        <input required name="sales_from" id="sales_from" class="input"
                                                            value="{{ $order_info->sales_from }}" type="text" placeholder=" " />
                                                        <div class="placeholder">
                                                            <p class="m-0">Sales From :<span
                                                                    class="text-danger">*</span></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3 mb-25">
                                                <div class="holder">
                                                    <div class="input-holder">
                                                        <input required name="delivery_from" id="delivery_from" class="input"
                                                            value="{{ $order_info->delivery_from }}" type="text" placeholder=" " />
                                                        <div class="placeholder">
                                                            <p class="m-0">Delivery From  :<span
                                                                    class="text-danger">*</span></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-25">
                                                <div class="holder">
                                                    <div class="input-holder">
                                                        <input name="note" id="note" class="input"
                                                            value="{{ @$order_info->note }}" type="text" placeholder=" " />
                                                        <div class="placeholder">
                                                            <p class="m-0">Note :<span
                                                                    class="text-danger">*</span></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                        </div>

                        <div class="card card-default card-md mb-4 purchase_app">
                            <div class="card-body py-md-30">
                                <div class="form-group">
                                    @foreach ($order_details as $key=>$item )
                                    <fieldset class="">
                                        <legend>Order Details:</legend>
                                        <div class="row">
                                            <div class="col-md-3">
                                               <input type="text" name="item_model" placeholder="item model" class="form-control" value="{{ $item->item_model }}">
                                            </div>
                                            <div class="col-md-3 mb-25">
                                                <div class="holder">
                                                    <div class="input-holder">
                                                        <input required name="unit_rate" id="unit_rate" class="input"
                                                            value="{{ $item->unit_rate }}" type="text" placeholder=" " />
                                                        <div class="placeholder">
                                                            <p class="m-0">Unit Rate:<span
                                                                    class="text-danger">*</span></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-25">
                                                <div class="holder">
                                                    <div class="input-holder">
                                                        <input readonly name="item_qty" id="item_qty" class="input"
                                                            value="{{ $item->item_qty }}" type="number" placeholder=" " />
                                                        <div class="placeholder">
                                                            <p class="m-0">Item Quantity:<span
                                                                    class="text-danger">*</span></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-25">
                                                <div class="holder">
                                                    <div class="input-holder">
                                                        <input readonly name="unit_wise_disc" id="unit_wise_disc" class="input"
                                                            value="{{ $item->unit_wise_disc }}" type="number" placeholder=" " />
                                                        <div class="placeholder">
                                                            <p class="m-0">Unit Wise Disc:<span
                                                                    class="text-danger">*</span></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div id="capable_action" class="mb-3" style="display: none">Sorry,Monthly Installment
                                    Must Be 3000 Taka Then You Are Applicable </div>
                                    <span id="credit_validation" style="color: red"></span>
                            </div>
                            <div class="col-md-6">
                                <button id="save_button" class="btn btn-lg btn-primary customr-btn btn-submit ms-auto"
                                    type="submit">Save And Continue</button>
                            </div>
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
