<option 
  value="{{$value}}" 
  {{(old($name)==$value||$selected=='true'||$selected==$value)?'selected':''}}
>
  {{$label}}
</option>