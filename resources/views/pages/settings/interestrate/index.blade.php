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
                            @if (Auth::user()->user_action(1))
                                <div class="card-header">
                                    <h6>Add Interest Rate </h6>
                                </div>
                                <div class="card-body py-md-30">
                                    <form action="{{ url('interest-rate') }}" method="post">
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
                                                    <input style="padding: 0 20px !important" required type="text" name="month" class="form-control px-2  ih-medium ip-lightradius-xs b-light" id="inputNameIcon1" placeholder="Month">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                               <input style="padding: 0 20px !important" required type="text" name="interest_rate" class="form-control px-2  " id="" placeholder="Interest Rate ">
                                            </div>
                                            <div class="col-md-4 form-basic pb-4">
                                                <button  type="submit" class="btn btn-lg btn-primary customr-btn btn-submit">save</button>

                                                </div>
                                            </div>

                                        </div>
                                    </form>
                                </div>
                            @endif
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
                                            <span class="userDatatable-title">Month </span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title">Interest Rate </span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title">Created by</span>
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
                                    @foreach($interestrates as $key=>$type)
                                    <tr>
                                        <td>{{ ($interestrates->currentpage()-1) * $interestrates->perpage() + $key + 1 }}</td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <div class="userDatatable-inline-title">
                                                    <a href="#" class="text-dark fw-500">
                                                        <h6>{{ $type->month }}</h6>
                                                    </a>
                                                </div>
                                            </div>
                                        </td>

                                          <td>
                                            <div class="userDatatable-content--subject">
                                                {{ @$type->interest_rate }}
                                            </div>
                                        </td>

                                        <td>
                                            <div class="userDatatable-content--subject">
                                                {{ @$type->users->name }}
                                            </div>
                                        </td>


                                        <td>
                                            <div class="userDatatable-content--subject">
                                                {{ @$type->updateusers->name }}
                                            </div>
                                        </td>

                                        <td>
                                            <div class="userDatatable-content--priority">
                                                {{ date('d/m/Y', strtotime($type->created_at)) }}
                                            </div>
                                        </td>
                                        <td>
                                            <ul class="orderDatatable_actions mb-0 d-flex justify-content-center align-items-center flex-wrap">
                                                {{-- @if (Auth::user()->user_action(4))
                                                <li>
                                                    <a data-bs-toggle="tooltip" data-bs-placement="top" title="Change Status" href="{{ url('enquiry-source-status/'.$type->id) }}" class="view">
                                                        <i class="las la-history"></i>
                                                    </a>
                                                </li>
                                                @endif --}}
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
                            {{ $interestrates->links()  }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
