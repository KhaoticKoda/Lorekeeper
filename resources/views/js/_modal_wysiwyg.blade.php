
<script>
    $(document).ready(function() {
        tinymce.init({
            selector: '#modal .wysiwyg',
            height: 500,
            menubar: false,
            plugins: [
                'advlist autolink lists link image charmap print preview anchor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table paste code help wordcount toc'
            ],
            toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | toc bullist numlist outdent indent | removeformat | code',
            content_css: [
                '//www.tiny.cloud/css/codepen.min.css',
                '{{ asset('css/app.css') }}',
                '{{ asset('css/lorekeeper.css') }}'
            ],
            toc_class: 'container',
        });
    });
</script>
