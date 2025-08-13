@section('title',$title)
@section('description',$description)
@extends('layout.app')
@section('content')
<div class="crm mb-25">
    <div class="container-fluid">
        <div class="form-element">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card card-default card-md mb-4">
                                <div class="card-header">
                                    <h6>Update Showroom</h6>
                                </div>
                                <div class="card-body py-md-25">
                                    <form action="{{url('show-rooms/'.$showroom->id)}}" method="post">
                                        @method('PUT')
                                        @csrf

                                    <fieldset class="mt-2">
                                         <legend>Basic Info:</legend>
                                        <div class="row">
                                            <div class="col-md-3 mb-25">
                                                <div class="with-icon">
                                                    {{-- <span class="la-user lar color-light"></span> --}}
                                                    <input required value="{{ $showroom->name }}" type="text" name="name" class="form-control  ih-medium ip-lightradius-xs b-light" id="name" placeholder="Show Room Name">
                                                </div>
                                            </div>

                                            <div class="col-md-3 mb-25">
                                                <div class="with-icon">
                                                    <input required value="{{ $showroom->suffix }}" type="text" name="suffix" class="form-control  ih-medium ip-lightradius-xs b-light" id="suffix" placeholder="Show Suffix Name">
                                                </div>
                                            </div>

                                            <div class="col-md-3 mb-25">
                                                <div class="with-icon">
                                                    {{-- <span class="la-user lar color-light"></span> --}}
                                                    <input type="text" value="{{ $showroom->contact_person }}" required name="contact_person" class="form-control  ih-medium ip-lightradius-xs b-light" id="contact_person" placeholder="Contact Person Name">
                                                </div>
                                            </div>

                                            <div class="col-md-3 mb-25">
                                                <div class="with-icon">
                                                    {{-- <span class="la-phone las color-light"></span> --}}
                                                    <input type="number" value="{{ $showroom->number }}" required class="form-control  ih-medium ip-lightradius-xs b-light" name="number" id="number" placeholder="Contact Person Number">
                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-25">
                                                <div class="with-icon">
                                                    {{-- <span class="lar la-envelope color-light"></span> --}}
                                                    <input type="email" value="{{ $showroom->email }}" required name="email" class="form-control  ih-medium ip-lightradius-xs b-light" id="email" placeholder="Email ">
                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-25">
                                                <div class="with-icon">
                                                    {{-- <span class="lar la-envelope color-light"></span> --}}
                                                    <input readonly type="text" value="{{ $showroom->credit_score }}" name="credit_score" class="form-control  ih-medium ip-lightradius-xs b-light" id="credit_score" placeholder="Credit Score  ">
                                                </div>
                                            </div>
                                        </div>
                                        </fieldset>
                                        <fieldset>
                                            <legend>Show Room Address:</legend>
                                        <div class="form-group row row-cols-lg-4 row-cols-1">
                                        <div class="col-md-3 mb-25">
                                                <div class=" select-style2">
                                                    <div class="dm-select ">
                                                        <select onchange="FindDistrict()" name="district_id" id="select-district" class="form-control " required>
                                                            <option value="{{ $showroom->district_id ? $showroom->district_id : '' }}">{{ $showroom->district_id ? @$showroom->district->en_name : '' }}</option>
                                                            @foreach($districts as $key=>$district)
                                                            <option value="{{ $district->id }}">{{ $district->en_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col mb-25">
                                                <div class=" select-style2">
                                                    <div class="dm-select ">
                                                        <select  name="upazila_id" id="Select-upazila" class="form-control " required>
                                                         <option value="{{ $showroom->upazila_id ? $showroom->upazila_id : '' }}">{{ $showroom->upazila_id ? $showroom->upazila->name : '' }}</option>

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col mb-25">
                                                <div class=" select-style2">
                                                    <div class="dm-select ">
                                                        <select  name="zone_id" id="Select-zone" class="form-control " required>
                                                            <option value="{{ $showroom->zone ? $showroom->zone_id : '' }}">{{ $showroom->zone ? @$showroom->zone->name : '' }}</option>
                                                            @foreach($zones as $key=>$zone)
                                                            <option value="{{ $zone->id }}">{{ $zone->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>




                                            <div class="col-md-3 mb-25">
                                                <div class="with-icon">
                                            {{-- <span class="lar la-envelope color-light"></span> --}}
                                                    <input type="text" value="{{ $showroom->street_address }}" name="street_address" class="form-control  ih-medium ip-lightradius-xs b-light" id="street_address" placeholder="Street Address ">
                                                </div>
                                            </div>

                                            <div class="col-md-3 mb-25">
                                                <div class="with-icon">
                                                    {{-- <span class="lar la-envelope color-light"></span> --}}
                                                  Is Dealer ?   <input @if ($showroom->dealar == 1)checked

                                                  @endif type="checkbox" name="dealar" class=" " id="street_address" value="1">
                                                </div>
                                            </div>

                                            <div class="col mb-25">
                                                <div class=" select-style2">
                                                    <div class="dm-select ">

                                                    </div>
                                                </div>
                                            </div>
                                          </div>
                                    </fieldset>
                                    <div class="d-flex gap-2 justify-content-end align-items-center mt-2">
                                        {{-- <input class="btn btn-warning" type="submit" value="Draft"> --}}
                                        <input class="btn btn-primary" type="submit" >
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

<script>


    function FindDistrict(){
        var district_id = $("#select-district").val();
        const selectElement = document.getElementById("Select-upazila");
        $.post('{{ url('/find-upazila')}}', {_token:'{{ csrf_token() }}',district_id:district_id}, function(data){
           data = JSON.parse(data);
            selectElement.innerHTML = '';
                data.forEach(item => {
                    const option = document.createElement('option');
                    option.value = item.id; // Replace 'item.value' with the actual data field
                    option.textContent = item.name; // Replace 'item.text' with the actual data field
                    selectElement.appendChild(option);
                });

        });

    }

</script>

@endsection
