@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
          <div class="panel-heading">Users</div>
          <div class="panel-body">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            <div class="list-group">
              @if ($users->count() > 0)
                @foreach ($users as $user)
                	<li class="list-group-item">
                    <a href="{{ url('/users/' . $user->getHashid()) }}">
                      {{ $user->name }}
                    </a>
                    @if (Auth::user()->admin)
                      <span class="pull-right">
                        <a href="{{ url('/users/' . $user->getHashid()) }}" title="Edit">
                          <span class="glyphicon glyphicon-edit"></span>
                        </a>
                        @if (Auth::user()->id !== $user->id)
                          &nbsp;
                          <a href="{{ url('/users/' . $user->getHashid() . '/delete') }}" title="Delete">
                            <span class="glyphicon glyphicon-remove"></span>
                          </a>
                        @endif
                      </span>
                    @endif
                  </li>
                @endforeach
              @else
                <li class="list-group-item">
                  No users found
                </li>
              @endif
            </div>
            @if (Auth::user()->admin)
              <div class="col-md-8">
                <a class="btn btn-primary" href="{{ url('/users/new') }}">
                  New User
                </a>
              </div>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
