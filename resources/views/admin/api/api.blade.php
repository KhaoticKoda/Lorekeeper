@extends('admin.layout')

@section('admin-title')
    API Tokens
@endsection

@section('admin-content')
    {!! breadcrumbs(['Admin Panel' => 'admin', 'API Tokens' => 'admin/api']) !!}

    <h1>API Tokens</h1>

    <p>Here you may generate personal access tokens for your account. <b>Be warned: giving away this token is like giving away your password!</b></p>

    @if (Auth::user()->tokens->count())
        <div class="card p-3 mb-2">
            <h3>Regenerate Token</h3>
            <p>You already have an API token generated. You may regenerate this token with the button below. It will create a new token, <b>not</b> show you your current one.</p>
            {!! Form::open(['url' => 'admin/api/token']) !!}
            {!! Form::submit('Regenerate Token', ['class' => 'btn btn-warning']) !!}
            {!! Form::close() !!}
        </div>
        <div class="card p-3 mb-2">
            <h3>Revoke Token</h3>
            <p>Click the below button to <b>revoke</b> (delete) your current API token. <b>This can not be undone!</b></p>
            {!! Form::open(['url' => 'admin/api/revoke']) !!}
            {!! Form::submit('Revoke Token', ['class' => 'btn btn-danger']) !!}
            {!! Form::close() !!}

        </div>
    @else
        <div class="card p-3 mb-2">
            <h3>Generate Token</h3>
            <p>Clicking the below button will generate a token for your account. This token will only display ONCE. Be sure to copy it down!</p>
            {!! Form::open(['url' => 'admin/api/token']) !!}
            {!! Form::submit('Generate Token', ['class' => 'btn btn-primary']) !!}
            {!! Form::close() !!}
        </div>
    @endif
@endsection
