@if (!isset($tinymceScript) || $tinymceScript)
<script>
    $(document).ready(function() {
@endif
        tinymce.init({
            selector: '{{ $tinymceSelector ?? ".wysiwyg" }}',
            height: {{ $tinymceHeight ?? 500 }},
            menubar: false,
            convert_urls: false,
            plugins: [
                'advlist autolink lists link image charmap print preview anchor',
                'searchreplace visualblocks code fullscreen spoiler',
                'insertdatetime media table paste {{ config('lorekeeper.extensions.tinymce_code_editor') ? 'codeeditor' : 'code' }} help wordcount toc mention',
                'textpattern',
            ],
            toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | toc bullist numlist outdent indent | link image | spoiler-add spoiler-remove | removeformat | {{ config('lorekeeper.extensions.tinymce_code_editor') ? 'codeeditor' : 'code' }}',
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
            toc_class: 'container',
            mentions: {
                delimiter: JSON.parse('{!! json_encode(config('lorekeeper.mentions.delimiters')) !!}'),
                source: function(query, process, delimiter) {
                    $.get('{{ url('mentions') }}', {
                        query: query,
                        delimiter: delimiter
                    }, function(data) {
                        process(data);
                    });
                },
                highlighter: function(text) {
                    //make matched block strong (make case insensitive)
                    return text.replace(new RegExp('(' + this.query + ')', 'ig'), function($1, match) {
                        return '<strong>' + match + '</strong>';
                    });
                },
                insert: function(item) {
                    let content = item.mention_display_name;
                    const editor = tinyMCE.activeEditor;
                    editor.insertContent(content + '&#8203;')

                    const rng = editor.selection.getRng();
                    rng.setStart(rng.endContainer, rng.endOffset);
                    rng.collapse(true);
                    editor.selection.setRng(rng);

                    return '';
                },
                render: function(item) {
                    return '<li class="pl-2">' +
                        '<a href="javascript:;">' +
                        (item.image ? '<img src="' + item.image + '" class="rounded mr-1" style="height: 25px; width: 25px;" />' : '') +
                        '<span>' + item.name + '</span>' +
                        '</a>' +
                        '</li>';
                },
            },
        });
@if (!isset($tinymceScript) || $tinymceScript)
    });
</script>
@endif