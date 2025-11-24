@extends('layout.app')
@section('title', $title)
@section('description', $description)

@section('content')
<div class="container-fluid">
    <div class="form-element">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-default card-md mb-4">
                    @if (Auth::user()->user_action(1))
                        <div class="card-header">
                            <h6>Add Package Product</h6>
                        </div>
                        <div class="card-body py-md-30">
                            <a href="{{ route('package-product.create') }}" class="btn btn-primary">Add New Product</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 mb-30">
                <div class="support-ticket-system">
                    <div class="support-form datatable-support-form d-flex justify-content-between mb-3">
                        <form method="GET" class="d-flex">
                            <select name="package_id" class="form-control me-2" onchange="this.form.submit()">
                                <option value="">— Filter by Package —</option>
                                @foreach($packages as $pkg)
                                    <option value="{{ $pkg->id }}" {{ request('package_id') == $pkg->id ? 'selected' : '' }}>
                                        {{ $pkg->name }}
                                    </option>
                                @endforeach
                            </select>
                        </form>
                    </div>

                    <div class="table-responsive custom-data-table-wrapper2">
                        <table class="table mb-0 table-borderless custom-data-table">
                            <thead>
                                <tr class="userDatatable-header">
                                    <th><span class="userDatatable-title">Sl</span></th>
                                    <th><span class="userDatatable-title">Package</span></th>
                                    <th><span class="userDatatable-title">Product</span></th>
                                    <th><span class="userDatatable-title">Product Group</span></th>
                                    <th><span class="userDatatable-title">Product Category</span></th>
                                    <th><span class="userDatatable-title">Price</span></th>
                                    <th><span class="userDatatable-title">Added By</span></th>
                                    <th class="actions"><span class="userDatatable-title">Action</span></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($packageItems as $key => $item)
                                    <tr>
                                        <td>{{ $packageItems->firstItem() + $key }}</td>
                                        <td>{{ $item->package->name ?? 'N/A' }}</td>
                                        <td>{{ $item->product->product_model ?? 'N/A' }}</td>
                                        <td>{{ $item->product->types->name ?? 'N/A' }}</td>
                                        <td>{{ $item->product->categories->name ?? 'N/A' }}</td>
                                        <td>{{ $item->product->hire_price ?? 'N/A' }}</td>
                                        <td>{{ optional($item->users)->name ?? 'N/A' }}</td>
                                        <td>
                                            <ul class="orderDatatable_actions mb-0 d-flex justify-content-center align-items-center flex-wrap">
                                                @if (Auth::user()->user_action(2))
                                                    <li>
                                                        <a href="{{ route('package-product.edit', $item->id) }}" class="edit">
                                                            <i class="uil uil-edit"></i>
                                                        </a>
                                                    </li>
                                                @endif
                                                <li class="ml-2">
                                                    <form action="{{ route('package-product.destroy', $item->id) }}" method="POST" style="display:inline;">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="border-0 bg-transparent text-danger"
                                                            onclick="return confirm('Are you sure you want to delete this item?')">
                                                            <i class="uil uil-trash-alt"></i>
                                                        </button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="pt-2">
                        {{ $packageItems->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
