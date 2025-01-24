<label class="form-label">{{$label}}</label>
<div class="crop-image" data-crop="{{$name}}" data-width="{{$width}}" data-height="{{$height}}" data-target="{{$target}}">
    <input type="file" class="form-control mb-3">
    @if ($value||old($target))
        <img src="{{old($target)?old($target):$value}}" id="final_{{$name}}">
    @endif
</div>

@error($target)
    <div class="invalid-feedback">{{ $message }}</div>
@enderror