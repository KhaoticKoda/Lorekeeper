@extends('account.layout')

@section('account-title')
    Quicklinks
@endsection

@section('account-content')
    {!! breadcrumbs(['My Account' => Auth::user()->url, 'Quicklinks' => 'account/quicklinks']) !!}

    <h1>Quicklinks</h1>
    <p>Quicklinks allow you to save URLs to pages both on-site and off-site that you would like to have quick access to via the site's navigation bar.</p>

    <div class="card p-3 mb-2">
        <h3>Your Quicklinks</h3>
        @if (Auth::user()->quicklinks()->get()->count())
            <div class="logs-table">
                <div class="logs-table-header">
                    <div class="row no-gutters">
                        <!-- The 0 opacity elements are just to keep the header aligned with the body... -->
                        <div class="col-auto px-1">
                            <span class="fas fa-arrows-alt-v" style="opacity: 0; pointer-events: none;" aria-hidden="true"></span>
                        </div>
                        <div class="row no-gutters align-items-center col">
                            <div class="col">
                                <div class="logs-table-cell">Link Name</div>
                            </div>
                            <div class="col">
                                <div class="logs-table-cell">Link URL</div>
                            </div>
                            <div class="col-auto">
                                <div class="logs-table-cell">
                                    <span class="btn btn-sm btn-primary" style="opacity: 0; pointer-events: none;" aria-hidden="true">Edit</span>
                                </div>
                            </div>
                        </div>
                        <div class="d-none d-md-block col-md-auto">
                            <div class="logs-table-cell">
                                <span class="btn btn-sm btn-primary" style="opacity: 0; pointer-events: none;" aria-hidden="true">Delete</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="logs-table-body" id="sortable" class="sortable">
                    @foreach (Auth::user()->quicklinks()->orderBy('sort', 'DESC')->get() as $link)
                        <div class="logs-table-row sort-item" data-id="{{ $link->id }}">
                            <div class="row no-gutters align-items-center flex-wrap">
                                <div class="col-auto text-center px-1">
                                    <a class="fas fa-arrows-alt-v handle" href="#"></a>
                                </div>
                                {!! Form::open(['url' => 'account/quicklinks/edit/' . $link->id, 'class' => 'row no-gutters align-items-center col']) !!}
                                <div class="col">
                                    <div class="logs-table-cell">
                                        {!! Form::text('link_name', $link->name, ['class' => 'form-control', 'placeholder' => 'Enter link name here...']) !!}
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="logs-table-cell">
                                        {!! Form::text('link_url', $link->url, ['class' => 'form-control', 'placeholder' => 'Enter the link\'s URL here...']) !!}
                                    </div>
                                </div>
                                <div class="col-auto text-right">
                                    <div class="logs-table-cell">
                                        {!! Form::submit('Edit', ['class' => 'btn btn-sm btn-primary']) !!}
                                    </div>
                                </div>
                                {!! Form::close() !!}
                                <div class="col-12 col-md-auto">
                                    {!! Form::open(['url' => 'account/quicklinks/delete/' . $link->id, 'class' => 'text-right']) !!}
                                    <div class="logs-table-cell">
                                        {!! Form::submit('Delete', ['class' => 'btn btn-sm btn-danger']) !!}
                                    </div>
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            {!! Form::open(['url' => 'account/quicklinks/sort', 'class' => 'text-right border-top pt-2']) !!}
            {!! Form::hidden('sort', null, ['id' => 'sortableOrder']) !!}
            {!! Form::submit('Save Order', ['class' => 'btn btn-primary']) !!}
            {!! Form::close() !!}
        @else
            <p>You currently have no quicklinks.</p>
        @endif

        <hr>

        <h5>New Quicklink</h5>
        {!! Form::open(['url' => 'account/quicklinks/new']) !!}
        <div class="row no-gutters mb-1">
            <div class="col-md-4 pr-md-1 pb-1">
                {!! Form::label('name', 'Link Name') !!}
                {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Enter link name here...']) !!}
            </div>
            <div class="col-md-8 pl-md-1 pb-1">
                {!! Form::label('url', 'Link URL') !!}
                {!! Form::text('url', null, ['class' => 'form-control', 'placeholder' => 'Enter the link\'s URL here...']) !!}
            </div>
        </div>
        <div class="text-right">
            {!! Form::submit('Add Link', ['class' => 'btn btn-primary']) !!}
        </div>
        {!! Form::close() !!}
    </div>
@endsection

@section('scripts')
    @parent
    <script>
        $(document).ready(function() {
            $('.handle').on('click', function(e) {
                e.preventDefault();
            });
            $("#sortable").sortable({
                items: '.sort-item',
                handle: ".handle",
                placeholder: "sortable-placeholder",
                stop: function(event, ui) {
                    $('#sortableOrder').val($(this).sortable("toArray", {
                        attribute: "data-id"
                    }));
                },
                create: function() {
                    $('#sortableOrder').val($(this).sortable("toArray", {
                        attribute: "data-id"
                    }));
                }
            });
            $("#sortable").disableSelection();
        });
    </script>
@endsection
