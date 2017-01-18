@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
          <div class="panel-heading">{{ $title }}</div>
          <div class="panel-body">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            <form class="form-horizontal" role="form" method="POST" action="{{ url($form_url) }}">
              {{ csrf_field() }}

              <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                <label for="name" class="col-md-4 control-label">Name</label>

                <div class="col-md-6">
                  <input id="name" type="text" class="form-control" name="name" value="{{ old('name') ? old('name') : $folder->name }}" required autofocus>

                  @if ($errors->has('name'))
                    <span class="help-block">
                      <strong>{{ $errors->first('name') }}</strong>
                    </span>
                  @endif
                </div>
              </div>

              <div class="form-group{{ $errors->has('users[]') ? ' has-error' : '' }}">
                <label for="users[]" class="col-md-4 control-label">Users</label>
                <div class="col-md-6">
                  <select name="users[]" multiple class="col-md-1 user-select form-control"
                  style="width: 100%" data-placeholder="Select users" data-theme="bootstrap">
                    <option></option>
                    @foreach ($users as $user)
                      <option value="{{ $user->id }}" {{ old("users[$user->id]") || $folder->users->contains('id', $user->id) ? 'selected="selected"' : '' }}>{{ $user->name }}</option>
                    @endforeach
                  </select>
                </div>
              </div>

              <div class="form-group">
                <div class="col-md-8 col-md-offset-4">
                  @if (isset($delete_url))
                    <a class="btn btn-danger" href="{{ url($delete_url) }}">
                      Delete
                    </a>
                    &nbsp;
                  @endif

                  <button type="submit" class="btn btn-primary">
                    Save
                  </button>
                  &nbsp;
                  <a class="btn btn-link" href="{{ url('/folders') }}">
                    Back
                  </a>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
