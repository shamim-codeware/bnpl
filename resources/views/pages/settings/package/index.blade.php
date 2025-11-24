@section('title', $title)
@section('description', $description)
@extends('layout.app')

@section('content')
    <div class="container-fluid">
        <div class="form-element">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card card-default card-md mb-4">
                                @if (Auth::user()->user_action(1))
                                    <div class="card-header">
                                        <h6>Add Product Package</h6>
                                    </div>
                                    <div class="card-body py-md-30">
                                        <a href="{{ route('package.create') }}" class="btn btn-primary">Add New Package</a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 mb-30">
                    <div class="support-ticket-system support-ticket-system--search">
                        <div
                            class="support-form datatable-support-form d-flex justify-content-xxl-end justify-content-center align-items-center flex-wrap">
                            <div class="row row-cols-3 w-100">
                                <div class="col"></div>
                                <div class="col"></div>
                                <div class="col d-flex justify-content-end">
                                    <div class="support-form__search">
                                        <div class="support-order-search">
                                            <form action="{{ route('package.index') }}" method="GET"
                                                class="support-order-search__form">
                                                <img src="{{ asset('assets/img/svg/search.svg') }}" alt="search"
                                                    class="svg">
                                                <input type="search" name="keyword" value="{{ request('keyword') }}"
                                                    class="form-control border-0 box-shadow-none" placeholder="Search"
                                                    aria-label="Search">
                                                <input class="search-btn-btn" type="submit" value="Search">
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="userDatatable userDatatable--ticket userDatatable--ticket--2 mt-1">
                            <div class="table-responsive custom-data-table-wrapper2">
                                <table class="table mb-0 table-borderless custom-data-table">
                                    <thead>
                                        <tr class="userDatatable-header">
                                            <th><span class="userDatatable-title">Sl</span></th>
                                            <th><span class="userDatatable-title">Package Name</span></th>
                                            <th><span class="userDatatable-title">Created By</span></th>
                                            <th class="actions"><span class="userDatatable-title">Action</span></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($packages as $key => $package)
                                            <tr>
                                                <td>{{ $packages->firstItem() + $key }}</td>
                                                <td>
                                                    <div class="d-flex justify-content-center">
                                                        <div class="userDatatable-inline-title">
                                                            <a href="#" class="text-dark fw-500">
                                                                <h6>{{ $package->name }}</h6>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex justify-content-center">
                                                        <div class="userDatatable-inline-title">
                                                            <a href="#" class="text-dark fw-500">
                                                                <h6>{{ optional($package->users)->name ?? 'N/A' }}</h6>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    {{-- <ul
                                                        class="orderDatatable_actions mb-0 d-flex justify-content-center align-items-center flex-wrap">
                                                        @if (Auth::user()->user_action(2))
                                                            <li>
                                                                <a href="{{ route('package.edit', $package->id) }}"
                                                                    class="edit">
                                                                    <i class="uil uil-edit"></i>
                                                                </a>
                                                            </li>
                                                        @endif

                                                        <li class="ml-2">
                                                            <a href="{{ route('package.items', $package->id) }}"
                                                                class="view">
                                                                <i class="uil uil-list-ul"></i> Items
                                                            </a>
                                                        </li>
                                                    </ul> --}}
                                                    <ul
                                                        class="orderDatatable_actions mb-0 d-flex justify-content-center align-items-center flex-wrap">
                                                        @if (Auth::user()->user_action(2))
                                                            <li>
                                                                <a href="{{ route('package.edit', $package->id) }}"
                                                                    class="edit">
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
                                {{ $packages->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
