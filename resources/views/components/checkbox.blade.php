<label class="form-check {{$type=="switch"?'form-switch':''}}">
    <input
        type="{{$type=="switch"?'checkbox':$type}}" 
        class="form-check-input" 
        name="{{$name}}" 
        value="{{$value}}" 
        {{(old($name)==$value||$checked=='true'||$checked==$value)?'checked':''}}
    >
    <span class="form-check-label">{{$label}}</span>
</label>