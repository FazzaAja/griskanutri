<div>
    <label class="form-label"><strong>{{ $label }}:</strong></label>
    <div id="{{ $name }}-wrapper">
        @if(isset($items) && !empty($items))
            @foreach($items as $item)
           <div class="field has-addons mb-2">
                <div class="control is-expanded">
                    <input type="text" name="{{ $name }}[]" class="input" value="{{ $item }}" required>
                </div>
                <div class="control">
                    <button class="button is-danger remove-item-btn" type="button">Hapus</button>
                </div>
            </div>
            @endforeach
        @else
            <div class="field has-addons mb-2">
                <div class="control is-expanded">
                    <input type="text" name="{{ $name }}[]" class="input" required>
                </div>
                <div class="control">
                    <button class="button is-danger remove-item-btn" type="button">Hapus</button>
                </div>
            </div>
        @endif
    </div>
    <button class="button is-success is-small mt-2 add-item-btn" type="button" data-name="{{ $name }}">Tambah {{ Str::singular($label) }}</button>
</div>
