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
                            @if (Auth::user()->user_action(1))
                                <div class="card-header">
                                    <h6>Add Upazila/Thana</h6>
                                </div>
                                <div class="card-body py-md-30">
                                    <form action="{{ url('upazila') }}" method="post">
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
                                                    <input type="text" required name="name" class="form-control  ih-medium ip-lightradius-xs b-light" id="inputNameIcon1" placeholder="Add Upazila/Thana">
                                                </div>
                                            </div>

                                              <div class="col-md-4 mb-25">
                                                    <div class=" select-style2">
                                                        <div class="dm-select ">
                                                            <select style="height: 21px" name="district_id" id="select-district" class="form-control " required>
                                                                <option value="">Select District</option>
                                                                @foreach($districts as $key=>$district)
                                                                <option value="{{ $district->id }}">{{ $district->en_name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
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
                <div class="support-ticket-system support-ticket-system--search">
                    <div class="support-form datatable-support-form d-flex justify-content-xxl-end justify-content-center align-items-center flex-wrap">
                        <div class="row row-cols-3 w-100 align-items-center">
                         
                                <div class="col">
                                    <form action="{{ url('/upazila') }}" method="GET" class="filter-support-order-search__form">
                                    <div class=" select-style2">
                                        <div class="dm-select select_district_2">
                                            <select onchange="Filter()" name="district_id" id="select-district-filter" class="form-control district-control " required>
                                                <option value="">Select District</option>
                                                @foreach($districts as $key=>$district)
                                                <option @if(request('district_id') == $district->id) selected @endif  value="{{ $district->id }}">{{ $district->en_name }}</option>
                                                @endforeach
                                            </select>
                                           
                                        </div>
                                    </div>
                                    </form>
                               </div>
                       
                            <div class="col"></div>
                            <div class="col d-flex justify-content-end "> <div class="support-form__search">
                                <div class="support-order-search">
                                    <form action="{{ url('/upazila') }}" method="GET" class="support-order-search__form">
                                        <img src="{{ asset('assets/img/svg/search.svg') }}" alt="search" class="svg">
                                        <input type="search" name="keyword" value="{{ Request::get('keyword') }}" class="form-control border-0 box-shadow-none" placeholder="Search" aria-label="Search">
                                        <input class="search-btn-btn" type="submit" value="Search">
                                    </form>
                                </div>
                            </div></div>
                        </div>
                    </div>
                    <div class="userDatatable userDatatable--ticket userDatatable--ticket--2 mt-1">
                        <div class="table-responsive">
                            <table class="table mb-0 table-borderless">
                                <thead>
                                    <tr class="userDatatable-header">
                                        <th>
                                            <span class="userDatatable-title">Sl</span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title">Name</span>
                                        </th>
                                      
                                                                         
                                        <th>
                                            <span class="userDatatable-title">District</span>
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
                                    @foreach($types as $key=>$type)
                                    <tr>
                                        <td>{{ ($types->currentpage()-1) * $types->perpage() + $key + 1 }}</td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <div class="userDatatable-inline-title">
                                                    <a href="#" class="text-dark fw-500">
                                                        <h6>{{ @$type->name }}</h6>
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                      
                                        <td>
                                            <div class="userDatatable-content--subject">
                                                {{ @$type->district->en_name }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="userDatatable-content--priority">
                                                {{ date('d/m/Y', strtotime($type->created_at)) }}
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
                                            <ul class="orderDatatable_actions mb-0 d-flex justify-content-center align-items-center flex-wrap">
                                                {{-- @if (Auth::user()->user_action(4))
                                                <li>
                                                    <a href="{{ url('enquiry-customer-status/'.$type->id) }}" class="view">
                                                        <i class="las la-history"></i>
                                                    </a>
                                                </li>
                                                @endif --}}
                                                @if (Auth::user()->user_action(2))
                                                <li>
                                                    <a href="{{url('upazila/'.$type->id.'/edit')}}" class="edit">
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
                            {{ $types->links() }}
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
</script>
@endsection
