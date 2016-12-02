@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
          <div class="panel-heading">
            Folders
          </div>
          <div class="panel-body">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            <div class="list-group">
              @if ($folders->count() > 0)
                @foreach ($folders as $folder)
                	<li class="list-group-item">
                    <a href="{{ url('/folders/' . $folder->id) }}">
                      {{ $folder->name }}
                    </a>
                    @if (Auth::user()->admin)
                      <span class="pull-right">
                        <a href="{{ url('/folders/' . $folder->id . '/edit') }}" title="Edit">
                          <span class="glyphicon glyphicon-edit"></span>
                        </a>
                        &nbsp;
                        <a href="{{ url('/folders/' . $folder->id . '/upload') }}" title="Upload">
                          <span class="glyphicon glyphicon-cloud-upload"></span>
                        </a>
                        &nbsp;
                        <a href="{{ url('/folders/' . $folder->id . '/delete') }}" title="Delete">
                          <span class="glyphicon glyphicon-remove"></span>
                        </a>
                      </span>
                    @endif
                  </li>
                @endforeach
              @else
                <li class="list-group-item">
                  No folders found
                </li>
              @endif
            </div>
            @if (Auth::user()->admin)
              <div class="col-md-8">
                <a class="btn btn-primary" href="{{ url('/folders/new') }}">
                  New Folder
                </a>
              </div>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
