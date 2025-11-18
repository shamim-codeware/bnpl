@section('title',$title)
@section('description',$description)
@extends('layout.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 form-element">
            <div class="card card-default card-md mb-4">
                <div class="card-header">
                    <h6>Permission</h6>
                </div>
                <div class="card-body py-md-30">
                    <div class="row">
                    <div class="col-lg-12">
                        <div class="userDatatable userDatatable--ticket userDatatable--ticket--2 mt-1">
                            <div class="table-responsive custom-data-table-wrapper2">
                                <form action="{{ url('/menu-permission-assign') }}" method="POST" class="menu-permission-form">
                                    @csrf
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <select name="role_id" class="form-control" onchange="role_change(this.value)" id="select-option2">
                                                @foreach($roles as $role)
                                                    <option value=""></option>
                                                    <option value="{{ $role['id'] }}">{{ $role['name'] }}</option>
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
                                                <th><span class="userDatatable-title">Module</span></th>
                                                <th>
                                                    <span class="userDatatable-title">Add</span>
                                                    <br>
                                                    <input type="checkbox" name="add" class="userDatatable-title all_add" onclick="all_select('add')">
                                                    <span class="userDatatable-title">(All)</span>
                                                </th>
                                                <th>
                                                    <span class="userDatatable-title">Edit</span>
                                                    <br>
                                                    <input type="checkbox" name="edit" class="userDatatable-title all_edit" onclick="all_select('edit')">
                                                    <span class="userDatatable-title">(All)</span>
                                                </th>
                                                <th>
                                                    <span class="userDatatable-title">view</span>
                                                    <br>
                                                    <input type="checkbox" name="view" class="userDatatable-title all_view" onclick="all_select('view')">
                                                    <span class="userDatatable-title">(All)</span>
                                                </th>
                                                <th>
                                                    <span class="userDatatable-title">Status</span>
                                                    <br>
                                                    <input type="checkbox" name="status" class="userDatatable-title all__status" onclick="all_select('_status')">
                                                    <span class="userDatatable-title">(All)</span>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($menus as $m)
                                                <tr class="text-start">
                                                    <td>{{ $m['title'] }}</td>
                                                    <td><input type="checkbox" name="permission[{{ $m['id'] }}][]" value="1" onchange="parent_menu({{ $m['id'] }},1)" class="parent_menu_{{ $m['id'] }}_1 select_{{ $m['id'] }}_1 add"></td>
                                                    <td><input type="checkbox" name="permission[{{ $m['id'] }}][]" value="2" onchange="parent_menu({{ $m['id'] }},2)" class="parent_menu_{{ $m['id'] }}_2 select_{{ $m['id'] }}_2 edit"></td>
                                                    <td><input type="checkbox" name="permission[{{ $m['id'] }}][]" value="3" onchange="parent_menu({{ $m['id'] }},3)" class="parent_menu_{{ $m['id'] }}_3 select_{{ $m['id'] }}_3 view"></td>
                                                    <td><input type="checkbox" name="permission[{{ $m['id'] }}][]" value="4" onchange="parent_menu({{ $m['id'] }},4)" class="parent_menu_{{ $m['id'] }}_4 select_{{ $m['id'] }}_4 _status"></td>
                                                </tr>
                                                @foreach ($m['children'] as $child)
                                                    <tr>
                                                        <td>-----{{ $child['title'] }}</td>
                                                        <td><input type="checkbox" name="permission[{{ $child['id'] }}][]" value="1" onchange="child_menu({{ $m['id'] }},{{ $child['id'] }},1)" class="child_menu_{{ $m['id'] }}_1 select_{{ $child['id'] }}_1 add"></td>
                                                        <td><input type="checkbox" name="permission[{{ $child['id'] }}][]" value="2" onchange="child_menu({{ $m['id'] }},{{ $child['id'] }},2)" class="child_menu_{{ $m['id'] }}_2 select_{{ $child['id'] }}_2 edit"></td>
                                                        <td><input type="checkbox" name="permission[{{ $child['id'] }}][]" value="3" onchange="child_menu({{ $m['id'] }},{{ $child['id'] }},3)" class="child_menu_{{ $m['id'] }}_3 select_{{ $child['id'] }}_3 view"></td>
                                                        <td><input type="checkbox" name="permission[{{ $child['id'] }}][]" value="4" onchange="child_menu({{ $m['id'] }},{{ $child['id'] }},4)" class="child_menu_{{ $m['id'] }}_4 select_{{ $child['id'] }}_4 _status"></td>
                                                    </tr>
                                                @endforeach
                                            @endforeach
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
        var url = "{{ url('/menu-assign/') }}" + '/' + role_id;
        $('input[type=checkbox]').prop("checked", false);
        // Ajax request
        $.get(url, function(data){
            $.each(data, function(index, menu) {
                $.each(menu.action, function(index, action) {
                    $('.select_'+menu.menu_id+'_'+action).prop("checked", true);
                });
            });
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






















