@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
          <div class="panel-heading">File Uploader</div>
          <div class="panel-body">
            <form class="form-horizontal" role="form" method="POST" action="{{ url($form_url) }}" enctype="multipart/form-data">
              {{ csrf_field() }}
              <div class="form-group{{ $errors->has('upload') ? ' has-error' : '' }}">
                <label for="upload" class="col-md-4 control-label">Upload</label>

                <div class="col-md-8">
                  <input id="upload" type="file" class="form-control" name="upload" value="{{ old('upload') ? old('upload') : '' }}" required autofocus>

                  @if ($errors->has('upload'))
                    <span class="help-block">
                      <strong>{{ $errors->first('upload') }}</strong>
                    </span>
                  @endif
                </div>
              </div>
              <div class="col-md-8">
                @if (Auth::user()->admin)
                  <input type="submit" value="Upload" class="btn btn-primary">
                  &nbsp;
                  <a class="btn btn-default" href="{{ url('/folders/' . $folder->id) }}">
                    Back
                  </a>
                @endif
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
