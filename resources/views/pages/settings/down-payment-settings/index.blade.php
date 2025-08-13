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
                                <h6>Update Down Payment Parcentage</h6>
                            </div>
                            <div class="card-body py-md-30">
                                <form action="{{url('down-payment-settings/')}}" method="post">
                                    @method('POST')
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
                                                <input type="number" required name="payment_percentage" class="form-control  ih-medium ip-lightradius-xs b-light" id="inputNameIcon1" >
                                            </div>
                                        </div>

                                        <div class="col-md-4 form-basic pb-4">
                                            <button  type="submit" class="btn btn-lg btn-primary customr-btn btn-submit">Save</button>
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
                    <div class="userDatatable userDatatable--ticket userDatatable--ticket--2 mt-1">
                        <div class="table-responsive custom-data-table-wrapper2">
                            <table class="table mb-0 table-borderless custom-data-table">
                                <thead>
                                    <tr class="userDatatable-header">
                                        <th>
                                            <span class="userDatatable-title">SL</span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title">Down Payment </span>
                                        </th>

                                        <th>
                                            <span class="userDatatable-title">Updated By</span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title">Created Date</span>
                                        </th>

                                        <th class="actions">
                                            <span class="userDatatable-title">Action
                                            </span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($downpayment as $key=>$type)
                                    <tr>
                                        <td>{{  $key + 1 }}</td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <div class="userDatatable-inline-title">
                                                    <a href="#" class="text-dark fw-500">
                                                        <h6>{{ $type->payment_percentage }}</h6>
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                        <td></td>
                                        <td></td>
                                        <td>
                                            <ul class="orderDatatable_actions mb-0 d-flex justify-content-center align-items-center flex-wrap">
                                                @if (Auth::user()->user_action(2))
                                                <li>
                                                    <a data-bs-toggle="tooltip" data-bs-placement="top" title="Edit" href="{{url('interest-rate/'.$type->id.'/edit')}}" class="edit">
                                                        <i class="uil uil-edit"></i>
                                                    </a>
                                                </li>
                                                @endif
                                            </ul>
                                        </td>
                                    </tr>
                                   @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="pt-2">
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
