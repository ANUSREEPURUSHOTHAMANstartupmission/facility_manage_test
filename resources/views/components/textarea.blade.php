<div class="mb-3">
    <label class="form-label">{{$label}}</label>
    <textarea 
        class="form-control @error($name) is-invalid @enderror" 
        name="{{$name}}" 
        placeholder="{{$placeholder}}"
        {{$required=='true'?'required':''}}
        >{{$value?$value:old($name)}}</textarea>
    <small class="form-hint">
        {{$help}}
    </small>
    @error($name)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>