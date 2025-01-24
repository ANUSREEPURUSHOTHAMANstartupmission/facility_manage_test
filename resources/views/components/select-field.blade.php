<div class="mb-3 @error($name) is-invalid @enderror">
    <label class="form-label">{{$label}}</label>
    <select 
        name="{{ $name }}" 
        id="select-{{ $name }}" 
        class="form-select select-choice"
        {{$required=='true'?'required':''}}
        
        @if ($model)
            x-model="{{$model}}"
        @endif

    >
        {{-- <option disabled selected>--select--</option> --}}
        {{$slot}}
    </select>
    @error($name)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>