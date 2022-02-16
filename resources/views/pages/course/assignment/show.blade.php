@extends('layouts.app')

@section('title', 'Assignment Detail')

@section('page-header', 'Assignment Information')

@section('content')
<!-- Display flashed session data on successful action -->
@include('common.session-data')

<div style="margin-top: 50px;" class="panel panel-primary">
  <div class="panel-heading">
    <h4 class="panel-title">
      Details About Assignment
    </h4>
  </div>

  <div class="panel-body">
    <div class="col-xs-12 col-md-10 col-md-offset-1">
      <div class="well">
        <h3 style="font-size: 32px;
                text-shadow:  1px 1px #59adeb;
                font-family:Arial, Helvetica, sans-serif;
                color: #59adeb;
                padding:16px;
                text-align:center;
                display:block;
                margin:16px;
                ">{{ $assignment->title }}</h3>
        <h4 style="font-size: 20px;
                text-shadow: 1px 1px #59adeb;
                font-family:Arial, Helvetica, sans-serif;
                color: #59adeb;
                padding:0px;
                display:block;
                margin:16px;
                ">{{ $course_name }}</h4>

        <p style="
                font-family:Arial, Helvetica, sans-serif;
                padding:0px;
                display:block;
                margin:16px;
                font-weight: bold;
                "><strong>Due Date:</strong> <u>{{ date('F jS Y \a\t h:i A', strtotime($assignment->due_date)) }}</u></p>
        <br />
        <p style="
                font-family:Arial, Helvetica, sans-serif;
                padding:0px;
                
                display:block;
                margin:16px;
                font-weight: bold;
                ">{{ $assignment->description }}</p>


        <!-- assignement file -->
        <div>
          <label class="control-label" style="font-size: 25px;
                    text-shadow: 1px 1px #59adeb;
                    font-family:Arial, Helvetica, sans-serif;
                    color: #59adeb;
                    padding:0px;
                    display:block;
                    margin:16px;">assignement file</label>
          <div class="">
            <iframe src="{{url('/fichiers/course/'.$course_id.'/assignement/'.$assignment->id.'/teacher/'.$assignment->fichier)}}" style="border-style: none; border-radius: 15px;border: 1px solid black; width: 100%; height:250px;" frameborder="0">></iframe>
          </div>
          <form method="post" action="{{ url('/course/' . $course_id . '/assignment/' . $assignment->id.'/downlaodAssignement/'.$assignment->fichier) }}">
            <div style="display: flex;"> <button style="margin:auto ! important;" type="submit" class="button-36 ">Download project<i class="fa-solid fa-download"></i></button></div>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
          </form>
        </div>

      </div>


      @if (Auth::user()->id == $course_instructor)
      <form role="form" method="post" action="{{ url('/course/' . $course_id . '/assignment/' . $assignment->id) }}">
        {{ csrf_field() }}
        {{ method_field('DELETE') }}

        <!-- Delete Button -->
        <button type="submit" class="btn btn-danger pull-right">Delete</button>
      </form>
      @endif
    </div>
  </div>
</div>

<!-- affected assignement -->
@if (Auth::user()->role == "student")
<div class="panel panel-primary">
  <div style="padding-top: 5px;" class="panel-heading">
    <span class="panel-title">
      affected Assignment
    </span>
    @if($affas != null)
    @if(($affas->created_at) < ($assignment->due_date))
      <span style="float: right ;padding: 5px ;border-radius: 15px; background-color: green;font-weight: bold; margin-bottom: 15px;">In Time!!</span>
      @else
      <span style="float: right ;padding: 5px ;border-radius: 15px; background-color: red;font-weight: bold; margin-bottom: 15px;">Too late</span>
      @endif
      @endif

      @if(date("D M d, Y G:i") > $assignment->due_date && $affected_assignement == null)
      <span style="float: right ;padding: 5px ;border-radius: 15px; background-color:gray;font-weight: bold; margin-bottom: 15px;">Not assigned</span>
      @endif
  </div>

  <div class="panel-body">
    <div class="col-xs-12 col-md-10 col-md-offset-1">
      <div class="well">
        <!-- affected assignement-->
        @if($usernote == null)
        <div style="color: red; font-size: x-large;">pas encore corrigé</div>

        @else
        @if(intval($usernote) >=10 && intval($usernote)>0)
        <div style="color: green; font-size: x-large;">Votre note est: {{$usernote}} impressionnant!</div>
        @else
        <div style="color: red; font-size: x-large;">Votre note est: {{$usernote}}</div>
        @endif
        @endif
        <div>
          <label style="font-size: 20px;
                    font-family:Arial, Helvetica, sans-serif;
                    color: #59adeb;
                    padding:0px;
                    display:block;
                    margin:16px;
                    " class="control-label">add your file</label>
          <div class="">
            <form method="post" action="{{ url('/course/' . $course_id .  '/assignment/' . $assignment->id.'/student/'.Auth::user()->id) }}" enctype="multipart/form-data">

              <div class="custom-file">
                <input name="fichier" type="file" class="custom-file-input" id="customFile">
              </div>

              <br />
              <input type="hidden" name="_token" value="{{ csrf_token() }}">


              <input style="
               font-size: 16px;
    background-color: #59adeb;
    color: white;
    width: max-content;
    cursor: pointer;
   
              " class="btn btn-default" type="submit"></input>
            </form>
          </div>
          <div>
            <label style="font-size: 20px;
                    font-family:Arial, Helvetica, sans-serif;
                    color: #59adeb;
                    padding:0px;
                    display:block;
                    margin:16px;
                    " class="control-label">
              your affected assignement
            </label>
            @if($affected_assignement != null)
            <div>
              <iframe src="{{ url('/fichiers/course/' . $course_id .  '/assignement/' . $assignment->id.'/student/'.Auth::user()->id.'/'.$affected_assignement) }}" style="border-style: none; border-radius: 15px;border: 1px solid black; width: 100%; height:250px;" frameborder="0"></iframe>
            </div>
            @endif
            @if($affected_assignement == null)
            <div>
              <h1 style="color: red;font-weight: bolder;">unassigned</h1>
            </div>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>

</div>
@endIf
@if (Auth::user()->id == $course_instructor)
<div class="panel panel-primary">
  <div class="panel-heading">
    <h4 class="panel-title">
      Edit Assignment Information
    </h4>
  </div>

  <div class="panel-body">
    <div class="col-xs-12 col-md-10 col-md-offset-1">
      <form class="form-horizontal" role="form" method="POST" action="{{ url('/course/' . $course_id . '/assignment/' . $assignment->id) }}">
        {{ csrf_field() }}
        {{ method_field('PUT') }}

        <!-- Title -->
        <div class="form-group{{ $errors->has('title') ? ' has-error': '' }}">
          <label class="col-md-3 control-label">Title</label>
          <div class="col-md-6">
            <input type="text" class="form-control" name="title" value="{{ old('title') ? old('title') : $assignment->title }}">

            @if ($errors->has('title'))
            <span class="help-block"><strong>{{ $errors->first('title') }}</strong></span>
            @endif
          </div>
        </div>


        <!-- Description -->
        <div class="form-group{{ $errors->has('description') ? ' has-error': '' }}">
          <label class="col-md-3 control-label">Description</label>
          <div class="col-md-6">
            <textarea class="form-control" name="description" rows="3">{{ old('description') ? old('description') : $assignment->description }}</textarea>

            @if ($errors->has('description'))
            <span class="help-block"><strong>{{ $errors->first('description') }}</strong></span>
            @endif
          </div>
        </div>

        <!-- Submit Button -->
        <div class="form-group">
          <div class="col-md-4 col-md-offset-7">
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
        </div>

      </form>
    </div>
  </div>
</div>
@endif

@if (Auth::user()->id == $course_instructor)
<div class="panel panel-primary">
  <div class="panel-heading">
    <h4 class="panel-title">
      Assignment affected
    </h4>
  </div>
  @foreach ($affected_assignements as $affectedAssignement)
  <div style="margin:10px;border:1px solid gray;border-radius: 15px;display: flex;justify-content: space-around;">
    <div style="margin: 10px;font-size:large;font-weight: bold;">
      @if($affectedAssignement->state == 'In time!!')
      <div style="color: green;">
        {{$affectedAssignement->state}}
      </div>
      @endif
      @if($affectedAssignement->state=='Too late')
      <div style="color: red;">
        {{$affectedAssignement->state}}
      </div>
      @endif
      @if($affectedAssignement->state=='not assigned')
      <div style="color: gray;">
        {{$affectedAssignement->state}}
      </div>
      @endif

      <div>Student : {{$affectedAssignement->user->first_name. " ".$affectedAssignement->user->last_name}} </div>
      @if($affectedAssignement->AffectedAssignement!=null)
      <div>Note actuel: {{$affectedAssignement->AffectedAssignement}}</div>
      @endif
      @if($affectedAssignement->AffectedAssignement==null)
      <div style="color: red;">Pas encore noté</div>

      @else
      <div style="color: green;">Deja noté</div>
      @endif
      <form method="post" action="{{ url('/cours/'.$course_id.'/assignment/' . $assignment->id.'/student/'.$affectedAssignement->user_id)}}">
        <div style="display: flex;"><input style="margin-top: 20px; margin-bottom: 10px;" type="text" class="form-control" placeholder="Note..." aria-label="Username" aria-describedby="basic-addon1" name="note"></div>
        <button style="margin: auto, !important;" type="submit" class="button-36 ">Entrer Note</button>
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
      </form>

      <div>
        <br />
        <form method="post" action="{{ url('/course/' . $course_id .  '/assignement/' . $assignment->id.'/student/'.$affectedAssignement->user_id.'/downlaodAssignementstu/'.$affectedAssignement->fichier) }}">
          <div style="display: flex;"> <button style="margin-bottom: 10px;" type="submit" class="btn btn-primary">Download Response<i class="fa-solid fa-download"></i></button></div>
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
        </form>
      </div>
    </div>
    <div>
      <iframe src="{{ url('/fichiers/course/' . $course_id .  '/assignement/' . $assignment->id.'/student/'.$affectedAssignement->user_id.'/'.$affectedAssignement->fichier) }}" frameborder="0"></iframe>

    </div>
  </div>
  @endforeach
  <div class="panel-body">
    <div class="col-xs-12 col-md-10 col-md-offset-1">

    </div>
  </div>
</div>
@endif
@endsection