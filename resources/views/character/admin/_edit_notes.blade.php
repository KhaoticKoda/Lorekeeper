{!! Form::open(['url' => 'admin/character/image/' . $image->id . '/notes']) !!}
<div class="form-group">
    {!! Form::label('Image Notes') !!}
    {!! Form::textarea('description', $image->description, ['class' => 'form-control wysiwyg']) !!}
</div>

<div class="text-right">
    {!! Form::submit('Edit', ['class' => 'btn btn-primary']) !!}
</div>
{!! Form::close() !!}

<script>
    $(document).ready(function() {
        @include('js._tinymce_wysiwyg', ['tinymceSelector' => '#modal .wysiwyg', 'tinymceHeight' => '500'])
    });
</script>
