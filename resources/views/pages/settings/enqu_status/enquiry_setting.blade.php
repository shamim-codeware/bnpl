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
                                <h6>Assign Enquiry Status Type</h6>
                            </div>
                            <div class="card-body py-md-30">
                                <form action="{{ url('enquiry-status-parent-assign') }}" method="post" class="parent-assign">
                                    @csrf
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label for="open_status">Open* </label>  
                                            <select  name="open" id="open_status" class="form-control status" required>
                                                <option value=""></option>
                                                @foreach ($enquiry_status as $status)
                                                    <option value="{{ $status->id }}" {{ @$parent_assign['open'] == $status->id? 'selected' : ''}}>{{ $status->name }}</option> 
                                                @endforeach
                                            </select> 
                                        </div>
                                        <div class="col-md-3">
                                            <label for="sale_status"> Sale*</label> 
                                            <select  name="sale" id="sale_status" class="form-control status" required>
                                                <option value=""></option>
                                                @foreach ($enquiry_status as $status)
                                                    <option value="{{ $status->id }}" {{ @$parent_assign['sale'] == $status->id? 'selected' : ''}}>{{ $status->name }}</option> 
                                                @endforeach
                                            </select> 
                                        </div>
                                        <div class="col-md-3"> 
                                            <label for="close_status">Close*</label> 
                                            @foreach ($enquiry_status as $status)
                                                <div>
                                                    <input type="checkbox" name="close[]" id="close_status" value="{{ $status->id }}" {{ @$parent_assign['close'] && in_array($status->id, $parent_assign['close'])? 'checked': '' }}> 
                                                    <label> {{ $status->name }}</label> 
                                                </div>
                                            @endforeach
                                        </div>

                                        <div class="col-md-3"> 
                                            <label for="close_status">Pending*</label> 
                                            @foreach ($enquiry_status as $status)
                                                <div>
                                                    <input type="checkbox" name="pending[]" id="pending_status" value="{{ $status->id }}" {{ @$parent_assign['pending'] && in_array($status->id, $parent_assign['pending'])? 'checked': '' }}> 
                                                    <label> {{ $status->name }}</label> 
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="col-md-4 form-basic pt-3">
                                            <button  type="submit" class="btn btn-lg btn-primary customr-btn btn-submit">save</button>  
                                        </div>
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
@endsection
@section('custom_js')
    <script>
        $('.parent-assign').on('submit',function(e){
            e.preventDefault();
            let form = $(this);
            let url  = form.attr('action');
            let type = form.attr('method');
            let data = form.serialize();
            button_disable(true); 

            $.ajax({  
                type: type,
                url: url,
                data: data,
                dataType: 'json',
                success: function (result) {
                    button_disable(false);
                    if(result.status == 0){
                        toastr.error(result.message);
                    }else{
                        toastr.success(result.message);
                    }
                },
                error: function(response){   
                    button_disable(false);
                    let errors = response.responseJSON.errors;
                    $.each( errors, function( key, value ) {
                        toastr.error(value);
                    });
                }
            });
        });
        function button_disable(status){
            $('.btn-primary').attr('disabled', status);
        }
    </script>
@endsection
