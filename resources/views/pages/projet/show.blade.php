@extends('layouts.app')

@section('title', 'Project Detail')

@section('page-header', 'Project Information')

@section('content')
<!-- Display flashed session data on successful action -->
@include('common.session-data')

<div style="margin-top: 50px;" class="panel panel-primary">
  <div class="panel-heading">
    <h4 class="panel-title">
      Details About Project
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
                ">{{ $Projet->type }}</h3>
        <h3 style="font-size: 25px;
                text-shadow: 1px 1px #59adeb;
                font-family:Arial, Helvetica, sans-serif;
                color: #59adeb;
                padding:0px;
                display:block;
                margin:16px;
                ">Encadrant du projet : </h3>
        <h4 style="
                font-family:Arial, Helvetica, sans-serif;
                padding:0px;
                display:block;
                margin:16px;
                font-weight: bold;
                "> {{$teacher->first_name }} {{$teacher->last_name }}</h4>
        <h4 style="
                font-family:Arial, Helvetica, sans-serif;
                padding:0px;
                display:block;
                margin:16px;
                font-weight: bold;
                ">{{$teacher->email }}</h4>
        <p> </p>


        <!-- assignement file -->
        <div>
          <h3 style="font-size: 25px;
                    text-shadow: 1px 1px #59adeb;
                    font-family:Arial, Helvetica, sans-serif;
                    color: #59adeb;
                    padding:0px;
                    display:block;
                    margin:16px;
                    " class="control-label">Project file</h3>
          <div class="">
            <!-- <p>{{$projet_id}}  {{$Projet->fichier}}</p> -->
            <iframe src="{{url('/fichiers/projet/'.$projet_id.'/teacher/'.$Projet->teacher_id.'/'.$Projet->fichier)}}" style="border-style: none; border-radius: 15px;border: 1px solid black; width: 100%; height:250px;" frameborder="0"></iframe>
          </div>
          <form method="post" action="{{ url('/projet/'.$projet_id.'/teacher/'.$Projet->teacher_id.'/downlaodProjet/' .$Projet->fichier) }}">
            <div style="display: flex;"> <button style="margin:auto ! important;" type="submit" class="button-36 ">Download project<i class="fa-solid fa-download"></i></button></div>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
          </form>
        </div>

      </div>



    </div>
  </div>
</div>

<!-- affected Project -->
@if (Auth::user()->role == "student")
<div class="panel panel-primary">
  <div class="panel-heading">
    <h4 class="panel-title">
      Affected Project
    </h4>
    @if($affas != null)

    @if(($affas->created_at) < ($Projet->due_date))
      <span style="float: right ;margin-top: -25px;padding: 5px ;border-radius: 15px; background-color: green;font-weight: bold; margin-bottom: 15px;">In Time!!</span>
      @else
      <span style="float: right ;margin-top: -25px;padding: 5px ;border-radius: 15px; background-color: red;font-weight: bold; margin-bottom: 15px;">Too late</span>
      @endif
      @endif
      @if(date("D M d, Y G:i") > $Projet->due_date && $affected_project == null)
      <span style="float: right ;margin-top: -25px;padding: 5px ;border-radius: 15px; background-color:gray;font-weight: bold; margin-bottom: 15px;">Not assigned</span>
      @endif
  </div>

  <div class="panel-body">
    <div class="col-xs-12 col-md-10 col-md-offset-1">
      <div class="well">
        @if($noteactuelle >= 10 )
        <div style="color: green;font-size: x-large;">Vous avez eu: {{$noteactuelle}}/20 impressionnant!</div>
        @endif
        @if($noteactuelle < 10 && $noteactuelle> 0) <div style="color: red;font-size: x-large;">Vous avez eu: {{$noteactuelle}}/20
          </div>
          @endif
          @if($noteactuelle == null )
          <div style="color: blue;font-size: x-large;">Pas enore corrigé</div>
          @endif
          <!-- affected project-->
          <div>
            <label style="font-size: 20px;
                    font-family:Arial, Helvetica, sans-serif;
                    color: #59adeb;
                    padding:0px;
                    display:block;
                    margin:16px;
                    " class="control-label">Add your file</label>


            <div class="" style="
          
          
          margin-left: 15px; ">


              <form method="post" action="{{ url('/projet/' . $projet_id .  '/student/'.Auth::user()->id.'/teacher/'.$Projet->teacher_id) }}" enctype="multipart/form-data">

                <div class="custom-file">
                  <input name="fichier" type="file" class="custom-file-input" id="customFile">
                </div>
                <br />
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <br />
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
                Your affected Project
              </label>

              @if($affected_project != null)
              <div>
                <iframe src="{{ url('/fichiers/projet/' . $projet_id . '/student/'.Auth::user()->id.'/'.$affected_project) }}" style="border-style: none; border-radius: 15px;border: 1px solid black; width: 100%; height:250px;" frameborder="0"></iframe>
              </div>
              @endif
              @if($affected_project == null)
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


@endsection