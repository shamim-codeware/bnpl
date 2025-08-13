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
                                    {{-- <a class="mx-2 fw-bold excel-btn" href="{{ url('/showroom-export') }}">Export</a> --}}

                                </div>
                                @if (Auth::user()->user_action(1))
                                <a class="btn btn-primary" href="{{ route('product.create') }}">Add Product</a>
                            @endif
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
                        <div class="row row-cols-3 w-100 align-items-center">
                                <div class="col">
                                   <form action="{{ url('/product') }}" method="GET" class="filter-support-order-search__form">
                                    <div class=" select-style2">
                                        <div class="dm-select select_district_2">
                                            <select onchange="Filter()" name="category_id" id="select-category-filter" class="form-control category-control " required>
                                                <option value="">Select Category</option>
                                                @foreach($category as $key=>$item)
                                                <option  @if($item->id == request('category_id') ) selected @endif value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    </form>
                               </div>

                            <div class="col">
                                <form action="{{ url('/product') }}" method="GET" class="filter-support-order-search__form_gourp">
                                    <div class=" select-style2">
                                        <div class="dm-select select_district_2">
                                            <select onchange="FilterGroup()" name="type_id" id="select-type-filter" class="form-control type-control " required>
                                                <option value="">Select Product Group</option>
                                                @foreach($types as $key=>$item)
                                                <option @if($item->id == request('type_id') ) selected @endif value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col d-flex justify-content-end "> <div class="support-form__search">
                                <div class="support-order-search">
                                    <form action="{{ url('/product') }}" method="GET" class="support-order-search__form">
                                        <img src="{{ asset('assets/img/svg/search.svg') }}" alt="search" class="svg">
                                        <input type="search" name="keyword" value="{{ Request::get('keyword') }}" class="form-control border-0 box-shadow-none" placeholder="Search" aria-label="Search">
                                        <input class="search-btn-btn" type="submit" value="Search">
                                    </form>
                                </div>
                            </div></div>
                        </div>

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

<script>
    function Filter(){

        $(".filter-support-order-search__form").submit();
    }

    function FilterGroup(){

        $(".filter-support-order-search__form_gourp").submit();
    }
</script>
@endsection
