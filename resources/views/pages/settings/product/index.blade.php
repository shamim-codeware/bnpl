@section('title',$title)
@section('description',$description)
@extends('layout.app')

@section('content')


<style>
    .select2-container--default .select2-selection--multiple, .select2-container--default .select2-selection--single {

    height: 40px;

}

.support-form .support-order-search .support-order-search__form {

    border: 1px solid #ddd;

}
.search-btn-btn {
    border-radius: 0px 5px 5px 0px;
}
.product-filter-panel {
    background: #f8f9fb;
    border: 1px solid #e7eaf0;
    border-radius: 14px;
    padding: 18px;
    box-shadow: 0 6px 20px rgba(31, 41, 55, 0.04);
}
.product-filter-panel .form-label {
    font-size: 12px;
    font-weight: 600;
    color: #5f6877;
    margin-bottom: 6px;
}
.product-filter-panel .form-control {
    height: 44px;
    border-radius: 10px;
    border-color: #d9dee8;
}
.product-filter-panel .support-order-search {
    position: relative;
}
.product-filter-actions {
    display: flex;
    gap: 10px;
    align-items: flex-end;
}
.product-filter-actions .btn {
    height: 44px;
    border-radius: 10px;
    min-width: 110px;
}
.product-filter-actions .btn-primary {
    box-shadow: 0 10px 20px rgba(13, 110, 253, 0.18);
}
.product-filter-actions .btn-success {
    box-shadow: 0 10px 20px rgba(25, 135, 84, 0.18);
}
.product-header-actions {
    display: flex;
    align-items: center;
    gap: 12px;
    flex-wrap: wrap;
}
.product-header-actions .excel-btn {
    margin: 0 !important;
    padding: 9px 16px;
    border-radius: 999px;
    border: 1px solid #0b6d67;
    background: #fff;
    color: #0b6d67;
}
.product-header-actions .btn-primary {
    border-radius: 999px;
    padding-left: 18px;
    padding-right: 18px;
}
</style>

<div class="container-fluid">
    <div class="form-element">

         <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card card-default card-md mb-4">
                            <div class="card-header">
                                <div class="d-flex align-items-center flex-wrap">
                                    <h6>Product </h6>

                                </div>
                                <div class="product-header-actions">
                                    <a class="mx-2 fw-bold excel-btn" href="{{ route('product.export', request()->query()) }}">Export</a>
                                    @if (Auth::user()->user_action(1))
                                        <a class="btn btn-primary" href="{{ route('product.create') }}">Add Product</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 mb-30">
                <div class="support-ticket-system support-ticket-system--search">
                    <div class="support-form datatable-support-form d-flex justify-content-xxl-end justify-content-center align-items-center flex-wrap">
                        <form action="{{ url('/product') }}" method="GET" class="support-order-search__form w-100">
                            <div class="product-filter-panel">
                                <div class="row g-3 align-items-end">
                                <div class="col-xl-2 col-lg-3 col-md-6">
                                    <label class="form-label mb-1">Product Group</label>
                                    <select name="type_id" id="select-type-filter" class="form-control type-control">
                                        <option value="">All Groups</option>
                                        @foreach($types as $key => $item)
                                            <option {{ request('type_id') == $item->id ? 'selected' : '' }} value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-xl-2 col-lg-3 col-md-6">
                                    <label class="form-label mb-1">Category</label>
                                    <select name="category_id" id="select-category-filter" class="form-control category-control">
                                        <option value="">All Categories</option>
                                        @foreach($category as $key => $item)
                                            <option {{ request('category_id') == $item->id ? 'selected' : '' }} value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-xl-2 col-lg-3 col-md-6">
                                    <label class="form-label mb-1">From Date</label>
                                    <input type="date" name="from_date" value="{{ request('from_date') }}" class="form-control">
                                </div>

                                <div class="col-xl-2 col-lg-3 col-md-6">
                                    <label class="form-label mb-1">To Date</label>
                                    <input type="date" name="to_date" value="{{ request('to_date') }}" class="form-control">
                                </div>

                                <div class="col-xl-3 col-lg-6 col-md-8">
                                    <label class="form-label mb-1">Search</label>
                                    <div class="support-order-search">
                                        <input type="search" name="keyword" value="{{ request('keyword') }}" class="form-control border-0 box-shadow-none" placeholder="Search product model" aria-label="Search">
                                    </div>
                                </div>

                                <div class="col-xl-1 col-lg-6 col-md-4">
                                    <div class="product-filter-actions">
                                        <button type="submit" class="btn btn-primary w-100">Filter</button>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="userDatatable userDatatable--ticket userDatatable--ticket--2 mt-1">
                        <div class="table-responsive custom-data-table-wrapper2">
                            <table class="table mb-0 table-borderless custom-data-table zxc">
                                <thead>
                                    <tr class="userDatatable-header">
                                        <th>
                                            <span class="userDatatable-title">Sl</span>
                                        </th>

                                        {{-- <th>
                                            <span class="userDatatable-title">Name</span>
                                        </th> --}}
                                        <th>
                                            <span class="userDatatable-title">Product Model</span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title">Price</span>
                                        </th>
                                          <th>
                                            <span class="userDatatable-title">Product Group </span>
                                        </th>
                                          <th>
                                            <span class="userDatatable-title">Product Category  </span>
                                        </th>

                                        <th>
                                            <span class="userDatatable-title">Created Date</span>
                                        </th>
                                      <th>
                                            <span class="userDatatable-title">Status</span>
                                        </th>
                                        <th class="actions">
                                            <span class="userDatatable-title">Action
                                            </span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($products as $key=>$product)
                                    <tr>
                                        <td>{{ ($products->currentpage()-1) * $products->perpage() + $key + 1 }}</td>

                                        {{-- <td>
                                            {{ $product->name }}

                                        </td> --}}
                                        <td>{{ $product->product_model }}</td>
                                        <td>{{ $product->hire_price }}</td>

                                         <td>
                                            {{ @$product->types->name }}
                                        </td>
                                        <td>{{ @$product->categories->name }}</td>
                                        <td>
                                            <div class="userDatatable-content--priority">
                                                {{ date('d/m/Y', strtotime($product->created_at)) }}
                                            </div>
                                        </td>

                                        <td>
                                            <div class="userDatatable-content--subject status-check">
                                                @if ($product->status == "publish")
                                                    <p style="background-color: #0e890e">Active</p>
                                                @else
                                                    <p style="background-color: #ff0000">Inactive</p>
                                                @endif
                                            </div>
                                        </td>

                                        <td>
                                            <ul class="orderDatatable_actions mb-0 d-flex justify-content-center align-items-center flex-wrap">
                                             @if (Auth::user()->user_action(4))
                                                <li>
                                                    <a href="{{ url('product-status/'.$product->id) }}" class="view">
                                                        <i class="las la-history"></i>
                                                    </a>
                                                </li>
                                                @endif
                                                @if (Auth::user()->user_action(2))
                                                <li>
                                                    <a href="{{url('product/'.$product->id.'/edit')}}" class="edit">
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
                         <div class="pt-2 pb-4">
                            {{ $products->links() }}
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
