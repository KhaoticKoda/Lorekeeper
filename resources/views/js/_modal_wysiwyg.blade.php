<script>
    $(document).on('focusin', function(e) {
        if ($(e.target).closest(".tox-tinymce, .tox-tinymce-aux, .moxman-window, .tam-assetmanager-root").length) {
            e.stopImmediatePropagation();
        }
    });

    $(document).ready(function() {
        tinymce.init({
            selector: '#modal .wysiwyg',
            height: 500,
            menubar: false,
            plugins: [
                'advlist autolink lists link image charmap print preview anchor',
                'searchreplace visualblocks fullscreen',
                'insertdatetime media table paste codeeditor help wordcount'
            ],
            toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | codeeditor',
            content_css: [
                '//www.tiny.cloud/css/codepen.min.css',
                '{{ asset('css/app.css') }}',
                '{{ asset('css/lorekeeper.css') }}'
            ]
        });
    });
</script>
