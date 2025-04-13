@props(['id', 'options' => [], 'name', 'label', 'selected' => ''])

{{-- <label for="{{ $id }}">{{ $label }}</label> --}}
@if (isset($label))
<label for="{{ $id }}">{{ $label }}</label>
@endif

<select id="{{ $id }}" name="{{ $name }}"
    {{ $attributes->class(['form-control']) }}>
    <option></option>
    @foreach ($options as $value => $text)
        <option value="{{ $value }}" @if ($value == old($name, $selected)) selected @endif>
            {{ $text }}
        </option>
    @endforeach
</select>

@error($name)
    <p class="invalid-feedback">{{ $message }}</p>
@enderror
