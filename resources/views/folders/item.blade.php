@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
          <div class="panel-heading">{{ $folder->name }}</div>
          <div class="panel-body">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            <div class="list-group">
              @if ($folder->files->count() > 0)
                @foreach ($folder->files as $file)
                	<li class="list-group-item">
                    <a href="{{ url('/folders/' . $folder->getHashid() . '/download/' . $file->getHashid())}}" target="_blank">
                      {{ $file->name }}
                    </a>
                    <span class="pull-right">
                      <a href="{{ url('/folders/' . $folder->getHashid() . '/download/' . $file->getHashid()) }}" title="Download" target="_blank">
                        <span class="glyphicon glyphicon-cloud-download"></span>
                      </a>
                      @if (Auth::user()->admin)
                        &nbsp;
                        <a href="{{ url('/folders/' . $folder->getHashid() . '/delete/' . $file->getHashid()) }}" title="Delete">
                          <span class="glyphicon glyphicon-remove"></span>
                        </a>
                      @endif
                    </span>
                  </li>
                @endforeach
              @else
                <li class="list-group-item">
                  No files found
                </li>
              @endif
            </div>
            <div class="col-md-12">
              @if (Auth::user()->admin)
                <a class="btn btn-primary" href="{{ url('/folders/' . $folder->getHashid() . '/upload') }}">
                  Upload
                </a>
                &nbsp;
              @endif
              @if ($folder->files->count() > 0)
                <a class="btn btn-primary" href="{{ url('/folders/' . $folder->getHashid() . '/download/zip') }}">
                  Download Zip
                </a>
              @endif
              @if (Auth::user()->admin && $folder->files->count() > 0)
                &nbsp;
                <a class="btn btn-danger" href="{{ url('/folders/' . $folder->getHashid() . '/delete/all') }}">
                  Delete all files
                </a>
              @endif
              @if (Auth::user()->admin)
                &nbsp;
                <a class="btn btn-danger" href="{{ url('/folders/' . $folder->getHashid() . '/delete') }}">
                  Delete folder
                </a>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
