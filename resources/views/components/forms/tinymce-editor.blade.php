@props(['name', 'value' => '', 'id' => null])

<textarea 
    id="{{ $id ?? 'tinymce-editor-' . $name }}"
    name="{{ $name }}"
    class="block w-full border-gray-300 rounded-md shadow-sm"
>{{ $value }}</textarea>

@push('scripts')
<script src="https://cdn.tiny.cloud/1/{{ config('services.tinymce.api_key') }}/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        tinymce.init({
            selector: '#{{ $id ?? 'tinymce-editor-' . $name }}',
            plugins: 'link lists table image code preview',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat | code preview',
            menubar: false,
            min_height: 500,
            branding: false,
            setup: function(editor) {
                editor.on('change', function() {
                    editor.save();
                });
            }
        });
    });
</script>
@endpush