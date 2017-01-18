@extends('layouts.app')
@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <div class="panel panel-default">
        <div class="panel-heading">File Uploader</div>
        <div class="panel-body">
          <div class="form-group">
          <a class="btn btn-default" href="{{ url('/folders/' . $folder->getHashid()) }}">
            Back
            </a>
            &nbsp;
            <span class="btn btn-success fileinput-button">
              <i class="glyphicon glyphicon-plus"></i>
            <span>Select files...</span>
            <input type="file" name="uploads[]" class="file-uploader" data-url="{{ url($form_url) }}" multiple>
            </span>
          </div>
          <div id="progress" class="progress form-group">
            <div class="progress-bar progress-bar-success"></div>
          </div>
          <div id="files" class="files"></div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
