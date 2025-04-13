{{-- <label for="name">Name</label>
<input type="text" id="name" name="name" value="{{ old('name', $category->name) }}"
    class="form-control @error('name') is-invalid @enderror">

@error('name')
    <p class="invalid-feedback">{{ $errors->first('name') }}</p>
@enderror --}}

@props(['id', 'type'=>'text', 'name', 'label', 'value'])

{{-- <label for="{{ $id }}">{{ $label }}</label> --}}
@if (isset($label))
<label for="{{ $id }}">{{ $label }}</label>
@endif
<input type="{{ $type ?? 'text' }}" id="{{ $id }}" name="{{ $name }}" value="{{ old($name, $value) }}"
    class="form-control @error($name) is-invalid @enderror"
    {{ $attributes->class(['form-control', 'is-invalid' => $errors->has('name')]) }} />

@error($name)
    <p class="invalid-feedback">{{ $message }}</p>
@enderror
