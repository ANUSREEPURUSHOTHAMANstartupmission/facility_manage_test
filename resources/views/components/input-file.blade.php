<div class="mb-3">
    <label class="form-label">{{$label}}</label>
    <input 
        type="file"
        accept=".csv" 
        class="form-control @error($name) is-invalid @enderror" 
        placeholder="{{$placeholder}}" 
        name="{{$name}}" 
        {{$required=='true'?'required':''}}
    >
    @if($value)
        <a href="{{$value?$value:old($name)}}">View File</a>
    @endif
    @error($name)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>