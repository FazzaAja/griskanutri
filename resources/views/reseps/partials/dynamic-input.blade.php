<div>
    <label class="form-label"><strong>{{ $label }}:</strong></label>
    <div id="{{ $name }}-wrapper">
        @if(isset($items) && !empty($items))
            @foreach($items as $item)
            <div class="input-group mb-2">
                <input type="text" name="{{ $name }}[]" class="form-control" value="{{ $item }}" required>
                <button class="btn btn-outline-danger remove-item-btn" type="button">Hapus</button>
            </div>
            @endforeach
        @else
            <div class="input-group mb-2">
                <input type="text" name="{{ $name }}[]" class="form-control" required>
                <button class="btn btn-outline-danger remove-item-btn" type="button">Hapus</button>
            </div>
        @endif
    </div>
    <button class="btn btn-outline-success btn-sm mt-2 add-item-btn" type="button" data-name="{{ $name }}">Tambah {{ Str::singular($label) }}</button>
</div>
