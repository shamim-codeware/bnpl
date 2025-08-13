@section('title', $title)
@section('description', $description)
@extends('layout.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="breadcrumb-main">
                <h4 class="text-capitalize breadcrumb-title">{{ $title }}</h4>
                <div class="breadcrumb-action justify-content-center flex-wrap">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="las la-home"></i>Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">                            <thead>
                                <tr>
                                    <th>Order No</th>
                                    <th>Customer Name</th>
                                    <th>Product Model</th>
                                    <th>Showroom</th>
                                    <th>Sale Date</th>
                                    <th>Hire Price</th>
                                    <th>Down Payment</th>
                                    <th>Monthly Installment</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($hirePurchases as $hire)
                                    <tr>
                                        <td>{{ $hire->order_no }}</td>
                                        <td>{{ $hire->name }}</td>
                                        <td>{{ $hire->purchase_product->product->product_model ?? 'N/A' }}</td>
                                        <td>{{ $hire->show_room->name }}</td>
                                        <td>{{ $hire->approval_date ? date('d M Y', strtotime($hire->approval_date)) : 'N/A' }}</td>
                                        <td>{{ number_format($hire->purchase_product->hire_price, 2) }}</td>
                                        <td>{{ number_format($hire->purchase_product->down_payment, 2) }}</td>
                                        <td>{{ number_format($hire->purchase_product->monthly_installment, 2) }}</td>                                        <td>
                                            <a href="{{ url('erp-view/'.($hire->erplog->id ?? '')) }}" class="btn btn-sm btn-info">View</a>
                                            {{-- <a href="javascript:void(0)" onclick="resendToErp({{ $hire->id }})" class="btn btn-sm btn-warning">Resend to ERP</a> --}}
                                        </td>
                                    </tr>
                                @endforeach
                                @if(count($hirePurchases) == 0)
                                    <tr>
                                        <td colspan="9" class="text-center">No unsent hire purchase records found</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
