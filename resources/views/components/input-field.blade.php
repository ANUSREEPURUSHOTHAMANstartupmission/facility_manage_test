<div class="mb-3">
    <label class="form-label">{{$label}}</label>
    <input 
        type="{{$type}}" 
        class="form-control @error($name) is-invalid @enderror" 
        placeholder="{{$placeholder}}" 
        name="{{$name}}" 
        value="{{$value?$value:old($name)}}"
        {{$required=='true'?'required':''}}
    >
    @error($name)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>