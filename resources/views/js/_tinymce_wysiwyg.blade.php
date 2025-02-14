<script>
    $(document).ready(function() {
        tinymce.init({
            selector: '{{ $tinymceSelector }}',
            height: {{ $tinymceHeight }},
            menubar: false,
            convert_urls: false,
            plugins: [
                'advlist autolink lists link image charmap print preview anchor',
                'searchreplace visualblocks fullscreen spoiler',
                'insertdatetime media table paste {{ config('lorekeeper.extensions.tinymce_code_editor') ? 'codeeditor' : 'code' }} help wordcount'
            ],
            toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | spoiler-add spoiler-remove | removeformat | {{ config('lorekeeper.extensions.tinymce_code_editor') ? 'codeeditor' : 'code' }}',
            content_css: [
                '{{ asset('css/app.css') }}',
                '{{ asset('css/lorekeeper.css') }}'
            ],
            spoiler_caption: 'Toggle Spoiler',
            target_list: false
        });
    });
</script>