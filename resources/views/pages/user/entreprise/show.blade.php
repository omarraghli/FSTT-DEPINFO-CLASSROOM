@extends('layouts.app')

@section('title', 'Home')

@section('page-header', 'Home')

@section('content')

  <!-- Display flashed session data on successful action -->
  @include('common.session-data')

  <div style="margin: 50px;" class="panel panel-primary">
    <div class="panel-heading">
      <h4 class="panel-title">
        Recent Activity ...
      </h4>
    </div>

    <div class="panel-body">
      <div class="col-xs-12 col-md-10 col-md-offset-1">
        @if (count($recent_activity) > 0)
          <div class="list-group">
            @foreach ($recent_activity as $activity)
                <a href="{{ url('project/' . $activity->id. '/student/' . $activity->user_id) }}" class="list-group-item list-group-item-success">
                  <h4 class="list-group-item-heading">{{ $activity->course_info }} - {{ $activity->title }}</h4>
                  <p class="list-group-item-text">
                    <p>{{ date('F jS Y \a\t h:i A', strtotime($activity->created_at)) }}</p>
                    <p>{{ $activity->description }}</p>
                  </p>
                </a>
            @endforeach
          </div>
        @else
          <div class="alert alert-danger">
            There is no recent activity. Please check back again later.
          </div>
        @endif
      </div>
    </div>
  </div>
@endsection