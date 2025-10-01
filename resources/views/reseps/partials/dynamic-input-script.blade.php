<script>
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('add-item-btn')) {
        const name = e.target.dataset.name;
        const wrapper = document.getElementById(name + '-wrapper');
        const newItem = document.createElement('div');
        newItem.classList.add('input-group', 'mb-2');
        newItem.innerHTML = `
            <div class="field has-addons mb-2">
                <div class="control is-expanded">
                    <input type="text" name="${name}[]" class="input" required>
                </div>
                <div class="control">
                    <button class="button is-danger remove-item-btn" type="button">Hapus</button>
                </div>
            </div>
        `;
        wrapper.appendChild(newItem);
    }

    if (e.target.classList.contains('remove-item-btn')) {
        const wrapper = e.target.closest('[id$="-wrapper"]');
        if (wrapper.children.length > 1) {
            e.target.closest('.input-group').remove();
        } else {
            alert('Minimal harus ada satu item.');
        }
    }
});
</script>
