tinymce.init({
    selector: '{{ $tinymceSelector }}',
    height: {{ $tinymceHeight }},
    menubar: false,
    convert_urls: false,
    plugins: [
        'advlist autolink lists link image charmap print preview anchor',
        'searchreplace visualblocks fullscreen spoiler',
        'insertdatetime media table paste codeeditor help wordcount'
    ],
    toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | spoiler-add spoiler-remove | removeformat | codeeditor',
    content_css: [
        '{{ asset('css/app.css') }}',
        '{{ asset('css/lorekeeper.css') }}'
    ],
    spoiler_caption: 'Toggle Spoiler',
    target_list: false
});