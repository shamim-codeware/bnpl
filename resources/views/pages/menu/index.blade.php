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
                                <div class="d-flex align-items-center flex-wrap">
                                    <h6>Menu </h6>
                                    <a class="mx-2 fw-bold excel-btn" href="{{ url('/showroom-export') }}">Export</a>
                                 
                                </div>   
                                @if (Auth::user()->user_action(1))
                                <a class="btn btn-primary" href="{{ route('show-rooms.create') }}">Add Showroom</a>
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
                        <div class="row row-cols-3 w-100">
                            <div class="col">
                            </div>
                            <div class="col"></div>
                            <div class="col d-flex justify-content-end "> <div class="support-form__search">
                                <div class="support-order-search">
                                    <form action="/show-rooms" class="support-order-search__form" method="get">
                                        <img src="{{ asset('assets/img/svg/search.svg') }}" alt="search" class="svg">
                                        <input name="keyword" class="form-control border-0 box-shadow-none" type="search" placeholder="Search" aria-label="Search">
                                        <input class="search-btn-btn" type="submit" value="Search">
                                    </form>
                                </div>
                            </div></div>
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
                                            <span class="userDatatable-title">Title</span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title">URL </span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title">Status </span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title">Priority </span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title">Icon</span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title">Action</span>
                                        </th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($menus as $key=>$menu)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>
                                           {{ $menu->title  }}
                                        </td>
                                        <td>
                                           {{ $menu->url }}
                                        </td>
                                        <td>
                                           {{ $menu->parent_id == 0 ? "Parent" : 'Child' }}
                                        </td>
                                     
                                 
                                        <td>
                                            {{ $menu->priority }}
                                        </td>
                                        {{-- <td>
                                            <div class="userDatatable-content--subject">
                                                {{ $menu->users ? $menu->users->name : '' }}
                                            </div>
                                        </td> --}}
                                        <td>
                                            <div class="userDatatable-content--priority">
                                               {{ $menu->icon }}
                                            </div>
                                        </td>
                                        <td>
                                            <ul class="orderDatatable_actions mb-0 d-flex justify-content-center align-items-center flex-wrap">
                                                @if (Auth::user()->user_action(4))
                                                    <li>
                                                        <a data-bs-toggle="tooltip" data-bs-placement="top" title="Change status" href="{{ url('showroom-status/'.$menu->id) }}" class="view">
                                                            <i class="las la-history"></i>
                                                        </a>
                                                       
                                                    </li>
                                                @endif
                                                @if (Auth::user()->user_action(2))
                                                    <li>
                                                        <a data-bs-toggle="tooltip" data-bs-placement="top" title="Edit" href="{{url('menus/'.$menu->id.'/edit')}}" class="edit">
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
