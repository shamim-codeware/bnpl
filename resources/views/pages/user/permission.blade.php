@section('title',$title)
@section('description',$description)
@extends('layout.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 form-element">
            <div class="card card-default card-md mb-4">
                <div class="card-header">
                    <h6>Retail User Zone Permission</h6>
                </div>
                <div class="card-body py-md-30">
                    <div class="row">
                    <div class="col-lg-12">
                        <div class="userDatatable userDatatable--ticket userDatatable--ticket--2 mt-1">
                            <div class="table-responsive custom-data-table-wrapper2">
                                <form action="{{ url('/zone-assign') }}" method="POST" class="menu-permission-form">
                                    @csrf
                                    <div class="form-group row">
                                         {{-- <label for="">Select Executive</label> --}}
                                        <div class="col-md-4">
                                           
                                            <select name="user_id" class="form-control" onchange="role_change(this.value)" id="select-option2">
                                                @foreach($exusers as $role) 
                                                    <option value=""></option>      
                                                    <option value="{{ $role->id }}">{{ $role->name }}</option>     
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4 form-basic">
                                            <button type="submit" class="btn btn-lg btn-primary customr-btn btn-submit">Submit</button>
                                        </div>
                                    </div> 
                                    <table class="table pt-3 table-borderless custom-data-table">
                                        <thead>
                                            <tr class="userDatatable-header">
                                                <th><span class="userDatatable-title">Zone Name</span></th>              
                                                <th>
                                                    <span class="userDatatable-title">Add</span>
                                                    <br>
                                                    <input type="checkbox" name="add" class="userDatatable-title all_add" onclick="all_select('add')">
                                                    <span class="userDatatable-title">(All)</span>
                                                </th>              
                                                                    
                                            </tr>
                                        </thead>
                                        <tbody id="assigndata">
                                            {{-- @foreach($allShowroom as $allShow)
                                            <tr>
                                                 <td>{{ $allShow->name }}</td>
                                                 <td>
                                                    <input type="checkbox" name="permission[]" value="{{ $allShow->id }}"  class="parent_{{ $allShow->id}}menu_1 select__1 add">
                                                 </td>
                                            </tr>
                                            @endforeach --}}
                                        </tbody>
                                    </table>
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
    function all_select(class_name){
        var checked = $('.all_'+class_name).prop("checked");
        $('.'+class_name).prop("checked", checked);
    }
    function parent_menu(menu_id, status){
        var checked = $('.parent_menu_'+menu_id+'_'+status).prop("checked");
        $('.child_menu_'+menu_id+'_'+status).prop("checked", checked);
    }
    function child_menu(menu_id, child_id, status){
        var allChildCheckboxes = $('.child_menu_'+menu_id+'_'+status);
        // 
        if (allChildCheckboxes.filter(':not(:checked)').length === allChildCheckboxes.length) {
            $('.parent_menu_'+menu_id+'_'+status).prop("checked", false);
        } else {
            $('.parent_menu_'+menu_id+'_'+status).prop("checked", true);
        }
    }
    function role_change(role_id){
        var url = "{{ url('/check-zone-permission/') }}" + '/' + role_id;
        $('input[type=checkbox]').prop("checked", false);
        // Ajax request 
        $.get(url, function(data){ 
            $("#assigndata").html(data);
            // $.each(data,function(key,value){

            //     $('.parent_'+value+'menu_1').prop("checked", true);

            // })
            // $.each(data, function(index, menu) {
            //     $.each(menu.action, function(index, action) {
            //         $('.select_'+menu.menu_id+'_'+action).prop("checked", true);
            //     });
            // });
        });
    }
    $('.menu-permission-form').on('submit', function(e){
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