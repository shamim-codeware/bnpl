@section('title')
@section('description')
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
                                        <h6>Assign Credit Score</h6>
                                    </div>
                                    <div class="card-body py-md-30">
                                        <form action="{{ route('showroom.credit.store') }}" method="post">
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
                                            {{-- @if (session()->has('success'))
                                                <p class="alert alert-success">{{ Session::get('success') }}</p>
                                            @endif --}}
                                            <div class="form-group row mb-n25">
                                                <div class="col-md-4 mb-25">
                                                    <div class="with-icon">
                                                        <select name="showroom_id" id="" class="form-control">
                                                            <option value="">Select Showroom</option>
                                                            @foreach ($show_rooms as $item)
                                                                <option value="{{ $item->id }}">{{ $item->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mb-25">
                                                    <div class="with-icon">
                                                        <input type="number" required name="credit"
                                                            class="form-control  ih-medium ip-lightradius-xs b-light"
                                                            id="inputNameIcon1" placeholder="Credit">
                                                    </div>
                                                </div>
                                                <div class="col-md-4 form-basic pb-4">
                                                    <button type="submit"
                                                        class="btn btn-lg btn-primary customr-btn btn-submit">save</button>
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
                <div class="support-ticket-system support-ticket-system--search">
                                    <div class="form-group mb-0">
                    <form action="{{ route('showroom.credit') }}" method="GET">
                        <div class="row">
                            <div class="col-md-3">
                                <select name="showroom_id" id="showroom" class="form-control">
                                    <option value="">Select Showroom</option>
                                    @foreach ($show_rooms as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select name="zone_id" id="zone" class="form-control">
                                    <option value="">Select Zone</option>
                                    @foreach ($zones as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary w-30 h-100">Search</button>
                            </div>
                        </div>
                    </form>
                </div>
                    <div class="userDatatable userDatatable--ticket userDatatable--ticket--2 mt-1">
                        <div class="table-responsive custom-data-table-wrapper2">
                            <table class="table mb-0 table-borderless custom-data-table">
                                <thead>
                                    <tr class="userDatatable-header">
                                        <th>
                                            <span class="userDatatable-title">Sl</span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title">ShowRoom</span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title">Credit</span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title">Created By</span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title">Created At</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($showroomCredit as $key => $credit)
                                        <tr>
                                            <td>
                                                <div class="userDatatable-content--subject">
                                                    {{ $key + 1 }}
                                                </div>
                                            </td>

                                            <td>
                                                <div class="userDatatable-content--subject">
                                                    {{ $credit->show_room->name }}
                                                </div>
                                            </td>
                                            <td>
                                                <div class="userDatatable-content--priority">
                                                    {{ $credit->credit }}
                                                </div>
                                            </td>
                                            <td>
                                                <div class="userDatatable-content--priority">
                                                    {{ $credit->user->name }}
                                                </div>
                                            </td>

                                            <td>
                                                <div class="userDatatable-content--priority">
                                                    {{ $credit->created_at->format('d/m/y') }}
                                                </div>
                                            </td>

                                            {{-- <td>
                                            <ul class="orderDatatable_actions mb-0 d-flex justify-content-center align-items-center flex-wrap">
                                                @if (Auth::user()->user_action(4))
                                                    <li>
                                                        <a data-bs-toggle="tooltip" data-bs-placement="top" title="Change Status" href="{{ url('customer-profession-status/'.$type->id) }}" class="view">
                                                            <i class="las la-history"></i>
                                                        </a>
                                                    </li>
                                                @endif
                                                @if (Auth::user()->user_action(2))    
                                                    <li>
                                                        <a data-bs-toggle="tooltip" data-bs-placement="top" title="Edit" href="{{url('customer-profession/'.$type->id.'/edit')}}" class="edit">
                                                            <i class="uil uil-edit"></i>
                                                        </a>
                                                    </li>
                                                @endif    
                                            </ul>
                                        </td> --}}
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="py-5">
                            {{ $showroomCredit->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
