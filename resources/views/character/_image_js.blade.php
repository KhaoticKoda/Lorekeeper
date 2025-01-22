<script>
    $(document).ready(function() {
        $('.edit-features').on('click', function(e) {
            e.preventDefault();
            loadModal("{{ url('admin/character/image') }}/" + $(this).data('id') + "/traits", 'Edit Traits');
        });
        $('.edit-notes').on('click', function(e) {
            e.preventDefault();
            $("div.imagenoteseditingparse").load("{{ url('admin/character/image') }}/" + $(this).data('id') + "/notes", function() {
                tinymce.init({
                    selector: '.imagenoteseditingparse .wysiwyg',
                    height: 500,
                    menubar: false,
                    convert_urls: false,
                    plugins: [
                        'advlist autolink lists link image charmap print preview anchor',
                        'searchreplace visualblocks code fullscreen spoiler',
                        'insertdatetime media table paste code help wordcount toc',
                        'textpattern',
                    ],
                    toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | toc bullist numlist outdent indent | link image | spoiler-add spoiler-remove | removeformat | code',
                    content_css: [
                        '{{ asset('css/app.css') }}',
                        '{{ asset('css/lorekeeper.css') }}'
                    ],
                    spoiler_caption: 'Toggle Spoiler',
                    target_list: false,
                    textpattern_patterns: [{
                            start: '# ',
                            format: 'h1'
                        },
                        {
                            start: '## ',
                            format: 'h2'
                        },
                        {
                            start: '### ',
                            format: 'h3'
                        },
                        {
                            start: '#### ',
                            format: 'h4'
                        },
                        {
                            start: '##### ',
                            format: 'h5'
                        },
                        {
                            start: '###### ',
                            format: 'h6'
                        },
                        {
                            start: '**',
                            end: '**',
                            format: 'bold'
                        },
                        {
                            start: '__',
                            end: '__',
                            format: 'bold'
                        },
                        {
                            start: '*',
                            end: '*',
                            format: 'italic'
                        },
                        {
                            start: '_',
                            end: '_',
                            format: 'italic'
                        },
                        {
                            start: '~~',
                            end: '~~',
                            format: 'strikethrough'
                        },
                        {
                            start: '> ',
                            format: 'blockquote'
                        },
                        {
                            start: '* ',
                            cmd: 'InsertUnorderedList'
                        },
                        {
                            start: '- ',
                            cmd: 'InsertUnorderedList'
                        },
                        {
                            start: '+ ',
                            cmd: 'InsertUnorderedList'
                        },
                        {
                            start: '1. ',
                            cmd: 'InsertOrderedList'
                        },
                    ],
                });
            });
            $(".edit-notes").remove();
        });
        $('.edit-credits').on('click', function(e) {
            e.preventDefault();
            loadModal("{{ url('admin/character/image') }}/" + $(this).data('id') + "/credits", 'Edit Image Credits');
        });
        $('.reupload-image').on('click', function(e) {
            e.preventDefault();
            loadModal("{{ url('admin/character/image') }}/" + $(this).data('id') + "/reupload", 'Reupload Image');
        });
        $('.active-image').on('click', function(e) {
            e.preventDefault();
            loadModal("{{ url('admin/character/image') }}/" + $(this).data('id') + "/active", 'Set Active');
        });
        $('.delete-image').on('click', function(e) {
            e.preventDefault();
            loadModal("{{ url('admin/character/image') }}/" + $(this).data('id') + "/delete", 'Delete Image');
        });
        $('.edit-stats').on('click', function(e) {
            e.preventDefault();
            loadModal("{{ url($character->is_myo_slot ? 'admin/myo/' : 'admin/character/') }}/" + $(this).data('{{ $character->is_myo_slot ? 'id' : 'slug' }}') + "/stats", 'Edit Character Stats');
        });
        $('.edit-description').on('click', function(e) {
            e.preventDefault();
            $("div.descriptioneditingparse").load("{{ url($character->is_myo_slot ? 'admin/myo/' : 'admin/character/') }}/" + $(this).data('{{ $character->is_myo_slot ? 'id' : 'slug' }}') + "/description", function() {
                tinymce.init({
                    selector: '.descriptioneditingparse .wysiwyg',
                    height: 500,
                    menubar: false,
                    convert_urls: false,
                    plugins: [
                        'advlist autolink lists link image charmap print preview anchor',
                        'searchreplace visualblocks code fullscreen spoiler',
                        'insertdatetime media table paste code help wordcount toc',
                        'textpattern',
                    ],
                    toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | toc bullist numlist outdent indent | link image | spoiler-add spoiler-remove | removeformat | code',
                    content_css: [
                        '{{ asset('css/app.css') }}',
                        '{{ asset('css/lorekeeper.css') }}'
                    ],
                    spoiler_caption: 'Toggle Spoiler',
                    target_list: false,
                    toc_class: 'container',
                    textpattern_patterns: [{
                            start: '# ',
                            format: 'h1'
                        },
                        {
                            start: '## ',
                            format: 'h2'
                        },
                        {
                            start: '### ',
                            format: 'h3'
                        },
                        {
                            start: '#### ',
                            format: 'h4'
                        },
                        {
                            start: '##### ',
                            format: 'h5'
                        },
                        {
                            start: '###### ',
                            format: 'h6'
                        },
                        {
                            start: '**',
                            end: '**',
                            format: 'bold'
                        },
                        {
                            start: '__',
                            end: '__',
                            format: 'bold'
                        },
                        {
                            start: '*',
                            end: '*',
                            format: 'italic'
                        },
                        {
                            start: '_',
                            end: '_',
                            format: 'italic'
                        },
                        {
                            start: '~~',
                            end: '~~',
                            format: 'strikethrough'
                        },
                        {
                            start: '> ',
                            format: 'blockquote'
                        },
                        {
                            start: '* ',
                            cmd: 'InsertUnorderedList'
                        },
                        {
                            start: '- ',
                            cmd: 'InsertUnorderedList'
                        },
                        {
                            start: '+ ',
                            cmd: 'InsertUnorderedList'
                        },
                        {
                            start: '1. ',
                            cmd: 'InsertOrderedList'
                        },
                    ],
                });
            });
            $(".edit-description").remove();
        });
        $('.delete-character').on('click', function(e) {
            e.preventDefault();
            loadModal("{{ url($character->is_myo_slot ? 'admin/myo/' : 'admin/character/') }}/" + $(this).data('{{ $character->is_myo_slot ? 'id' : 'slug' }}') + "/delete", 'Delete Character');
        });

    });
</script>
