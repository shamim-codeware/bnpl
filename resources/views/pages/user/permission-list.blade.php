  @foreach($allzone as $allShow)
        <tr>
                <td>{{ $allShow->name }}</td>
                <td>
                <input type="checkbox" @if(in_array($allShow->id,$permission)) checked  @endif name="showroom_id[]" value="{{ $allShow->id }}"  class="parent_{{ $allShow->id}}menu_1 select__1 add">
                </td>
        </tr>
  @endforeach