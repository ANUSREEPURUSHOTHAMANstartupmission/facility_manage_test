<div class="mb-3">
    <label class="form-label">{{$label}}</label>
    <select 
        name="{{ $name }}" 
        id="select-{{ $name }}" 
        class="form-select select-search @error($name) is-invalid @enderror"
        {{$required=='true'?'required':''}}
        data-route="{{route($route)}}"
        data-selected="{{$selected}}"
    >
    </select>
    @error($name)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>