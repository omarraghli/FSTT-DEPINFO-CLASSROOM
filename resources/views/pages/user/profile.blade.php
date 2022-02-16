@extends('layouts.app')

@section('title', 'Profile')

@section('page-header', 'General Account Information')

@section('content')
  <!-- Display flashed session data on successful update -->
  @include('common.session-data')



<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Bootstrap Elegant Modal Login Modal Form with Avatar Icon</title>
<link href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round" rel="stylesheet">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>


<!– Modal HTML –>
<div id="myModal" class="modal fade">
<div class="modal-dialog modal-login">
<div class="modal-content">
<div class="modal-header">

@if ($user->id == Auth::user()->id && $user->role=='student' && $score<=10 )
<div class="avatar">
<img src="{{url('image/icons8-medal-64.png')}}"  alt="Avatar">
</div>
@elseif ($user->id == Auth::user()->id && $user->role=='student' && $score>10 && $score<=16  )
<div class="avatar">
<img src="{{url('image/icons8-military-medal-96.png')}}"  alt="Avatar">
</div>
@elseif ($user->id == Auth::user()->id && $user->role=='student' && $score>16 && $score<=19  )
<div class="avatar">
<img src="{{url('image/icons8-diamond-64.png')}}"  alt="Avatar">
</div>
@elseif ($user->id == Auth::user()->id && $user->role=='student' && $score==20  )
<div class="avatar">
<img src="{{url('image/icons8-crown-85.png')}}"  alt="Avatar">
</div>
@endif

@if ($user->id == Auth::user()->id && $user->role=='student' && $score<=10 )
<h4 class="modal-title">Silver student </h4>
@elseif ($user->id == Auth::user()->id && $user->role=='student' && $score>10 && $score<=16  )
<h4 class="modal-title">Gold student </h4>
@elseif ($user->id == Auth::user()->id && $user->role=='student' && $score>16 && $score<=19  )
<h4 class="modal-title">Diamond student </h4>
@elseif ($user->id == Auth::user()->id && $user->role=='student' && $score==20 )
<h4 class="modal-title">King student </h4>
@endif

<h4 class="modal-title">Score {{ $score }} </h4>
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
</div>

@if ($user->id == Auth::user()->id && $user->role=='student' && $score<=10 ) 
<div class="modal-body">
    <h5 style="text-align: center;"> You are great , Make sure to move and get the next one , GOLD is waiting for you </h5>
</div>
@elseif ($user->id == Auth::user()->id && $user->role=='student' && $score>=10 && $score<=16  )
<div class="modal-body">
    <h5 style="text-align: center;"> Great Job, You are a Gold now , Make sure to move and get the next one , Diamond is waiting for you </h5>
</div>
@elseif ($user->id == Auth::user()->id && $user->role=='student' && $score>10 && $score<=19  )
<div class="modal-body">
    <h5 style="text-align: center;"> You are magnificent, and highly skilled ,One step to become king developper </h5>
</div>
@elseif ($user->id == Auth::user()->id && $user->role=='student' && $score==20 )
<div class="modal-body">
    <h5 style="text-align: center;"> Now ,You are ready to become a highly skilled developer in any companys </h5>
</div>
@endif

</div>
</div>
</div>
</body>
</html>

  <div style="margin-top: 50px;" class="panel panel-primary">
    <div class="panel-heading">
      <h4 class="panel-title">
        @if ($user->id == Auth::user()->id)
          Your profile's information, <strong> {{ $user->first_name }}</strong>.
        @else 
          Profile of  {{ $user->first_name }} {{ $user->last_name }}.
        @endif
      </h4>
    </div>
    <div class="panel-body">
      <div class="col-xs-12 col-md-12">
          @if ($user->id == Auth::user()->id)
         
          <div class="holder">

  @if ($user->id == Auth::user()->id && $user->role=='student' && $score<=10 )         
	<div class="avatar">
		<a >
			<img  href="#myModal"  data-toggle="modal" src="{{url('image/icons8-medal-64.png')}}"  class="user"/>
		</a>
	</div>
  @elseif ($user->id == Auth::user()->id && $user->role=='student' && $score>10 && $score<=16  )
  <div class="avatar">
		<a >
			<img  href="#myModal"  data-toggle="modal" src="{{url('image/icons8-military-medal-96.png')}}"  class="user"/>
		</a>
	</div>
  @elseif ($user->id == Auth::user()->id && $user->role=='student' && $score>16 && $score<=19  )
  <div class="avatar">
		<a >
			<img  href="#myModal"  data-toggle="modal" src="{{url('image/icons8-diamond-64.png')}}"  class="user"/>
		</a>
	</div>
  @elseif ($user->id == Auth::user()->id && $user->role=='student' && $score==20 )
  <div class="avatar">
		<a >
			<img  href="#myModal"  data-toggle="modal" src="{{url('image/icons8-crown-85.png')}}"  class="user"/>
		</a>
	</div>
  @endif
  
</div>
            <p><strong>First name:</strong> {{ $user->first_name }}</p>
            <p><strong>Last name:</strong> {{ $user->last_name }}</p>
            <p><strong>Role:</strong> {{ $user->role }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Updated:</strong> {{ $user->updated_at }}</p>
          @else
            <h3>Contact Form</h3>
            <hr>

            <!-- Private Message -->
            <form class="form-horizontal" role="form" method="POST" action="{{ url('/user/' . $user->id . '/message') }}">
              {{ csrf_field() }}

              <!-- Title -->
                <div class="form-group {{ $errors->has('title') ? ' has-error': ''}}">
                  <label class="col-md-3 control-label">Title</label>

                  <div class="col-md-6">
                    <input type="text" class="form-control" name="title" value="{{ $errors->has('title') ? old('title') : '' }}" placeholder="Question about this weeks homework...">

                    @if ($errors->has('title'))
                      <span class="help-block"><strong>{{ $errors->first('title') }}</strong></span>
                    @endif
                  </div>
                </div>

              <!-- Message -->
                <div class="form-group {{ $errors->has('message') ? ' has-error': ''}}">
                  <label class="col-md-3 control-label">Message</label>

                  <div class="col-md-6">
                    <textarea class="form-control" name="message" rows="3">{{ $errors->has('message') ? old('message') : '' }}</textarea>

                    @if ($errors->has('message'))
                      <span class="help-block"><strong>{{ $errors->first('message') }}</strong></span>
                    @endif
                  </div>
                </div>

                <!-- Submit Button -->
                <div class="form-group">
                  <div class="col-md-4 col-md-offset-7">
                    <button type="submit" class="btn btn-primary">Send</button>
                  </div>
                </div>

            </form>
          @endif

          @if ($user->id == Auth::user()->id)
            <h3>Edit Form</h3>
            <hr>

            <!-- Edit Form -->
            <form class="form-horizontal" role="form" method="POST" action="{{ url('/profile/update') }}">
              {{ csrf_field() }}

              <!-- First Name -->
              <div class="form-group{{ $errors->has('first_name') ? ' has-error': ''}}">
                <label class="col-md-3 col-md-offset-1 control-label">First Name</label>
                <div class="col-md-6">
                  <input type="text" class="form-control" name="first_name" value="{{ $errors->has('first_name') ? old('first_name') : $user->first_name }}">

                  @if ($errors->has('first_name'))
                    <span class="help-block"><strong>{{ $errors->first('last_name') }}</strong></span>
                  @endif
                </div>
              </div>

              <!-- Last Name -->
              <div class="form-group{{ $errors->has('last_name') ? ' has-error': ''}}">
                <label class="col-md-3 col-md-offset-1 control-label">Last Name</label>
                <div class="col-md-6">
                  <input type="text" class="form-control" name="last_name" value="{{ $errors->has('last_name') ? old('last_name') : $user->last_name }}">

                  @if ($errors->has('last_name'))
                    <span class="help-block"><strong>{{ $errors->first('last_name') }}</strong></span>
                  @endif
                </div>
              </div>

              <!-- Submit Button -->
              <div class="form-group">
                <div class="col-md-4 col-md-offset-8">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </div>
            </form>
          @endif

      </div>
    </div>
  </div>
@endsection