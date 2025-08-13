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
                                <div class="card-header">
                                    <div class="wrapper d-flex align-items-center gx-3">
                                        <h6>Users</h6>
                                        <a class="mx-2 fw-bold excel-btn" href="{{ url('/user-export') }}">Export Excel<i class="px-2 far fa-file-excel"></i></a>
                                    </div>
                                    <a class="btn btn-primary" href="{{ url('user/create') }}">Add User</a>
                                </div>
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
                                <div class="col d-flex justify-content-end ">
                                    <div class="support-form__search">
                                        <div class="support-order-search">
                                            <form action="{{ url('user') }}" method="GET" class="support-order-search__form">
                                                <img src="{{ asset('assets/img/svg/search.svg') }}" alt="search" class="svg">
                                                <input type="search" name="keyword" value="{{ Request::get('keyword') }}" class="form-control border-0 box-shadow-none" placeholder="Search(Name/Email/Phone)" aria-label="Search">
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
                                            <th>
                                                <span class="userDatatable-title">SL</span>
                                            </th>
                                            <th>
                                                <span class="userDatatable-title">Name</span>
                                            </th>
                                            <th>
                                                <span class="userDatatable-title">Number</span>
                                            </th>
                                            <th>
                                                <span class="userDatatable-title">Role</span>
                                            </th>
                                            <th>
                                                <span class="userDatatable-title">Showroom/Zone</span>
                                            </th>
                                            <th>
                                                <span class="userDatatable-title">Status</span>
                                            </th>
                                            <th>
                                                <span class="userDatatable-title">Created by</span>
                                            </th>
                                            <th>
                                                <span class="userDatatable-title">Created Date</span>
                                            </th>
                                            <th>
                                                <span class="userDatatable-title">Last Login </span>
                                            </th>
                                            <th class="actions">
                                                <span class="userDatatable-title">Action</span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $key => $type)
                                            <tr>
                                                <td>{{ ($users->currentpage()-1) * $users->perpage() + $key + 1 }}</td>
                                                <td>
                                                    <div class="d-flex justify-content-center">
                                                        <div class="userDatatable-inline-title">
                                                            <a href="#" class="text-dark fw-500">
                                                                <h6>{{ $type->name }}</h6>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="userDatatable-content--subject">
                                                        {{ $type->phone }}
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="userDatatable-content--subject">
                                                        {{ @$type->roles->name }}
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="userDatatable-content--subject">
                                                        @if($type->role_id == 2)
                                                        {{ @$type->zones->name }}
                                                        @else 
                                                        {{ @$type->showrooms->name }}
                                                        @endif 
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="userDatatable-content--subject status-check">
                                                        @if ($type->status == 1)
                                                            <p style="background-color: #0e890e">Active</p>  
                                                        @else
                                                            <p style="background-color: #ff0000">Inactive</p>  
                                                        @endif
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="userDatatable-content--subject">
                                                        {{ @$type->users->name }}
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="userDatatable-content--priority">
                                                        {{ date('d/m/Y', strtotime($type->created_at)) }}
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="userDatatable-content--priority">
                                                        {{ $type->last_seen ? date('d/m/Y h:i:h', strtotime($type->last_seen)) : '' }}
                                                    </div>
                                                </td>
                                                <td>
                                                    <ul class="orderDatatable_actions mb-0 d-flex justify-content-center align-items-center flex-wrap">
                                                        @if (Auth::user()->user_action(4))
                                                        <li>
                                                            <a data-bs-toggle="tooltip" data-bs-placement="top" title="Status Change" href="{{ url('user-status/' . $type->id) }}"
                                                                class="view">
                                                                <i class="las la-history"></i>
                                                            </a>
                                                        </li>
                                                        @endif
                                                        @if (Auth::user()->user_action(2))
                                                        <li>
                                                            <a data-bs-toggle="tooltip" data-bs-placement="top" title="Edit" href="{{ url('user/' . $type->id.'/edit') }}" class="edit">
                                                                <i class="uil uil-edit"></i>
                                                            </a>
                                                        </li>
                                                        @endif

                                                        @if (Auth::user()->user_action(2))
                                                        <li>
                                                            <a data-bs-toggle="tooltip" data-bs-placement="top" title="Change Password" href="{{ url('user-pass-change/' . $type->id) }}" class="edit">
                                                                <i class="uil uil-lock"></i>
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
                                {{ $users->links()  }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
