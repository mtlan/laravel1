@props(['class' => '', 'for', 'field', 'required' => false])


<label for="{{ $for }}" class="{{ $class }}">
    {{ $slot }}
    @if ($required)
        <span style="color: red">*</span>
    @endif
</label>
