@extends('layouts.app')

@section('title', 'Project Detail')



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
                ">l'étudiant encadré : </h3>
                <h4 style="
                font-family:Arial, Helvetica, sans-serif;
                padding:0px;
                display:block;
                margin:16px;
                font-weight: bold;
                "> Nom : {{$student->first_name }} {{$student->last_name }}</h4>
                <h4 style="
                font-family:Arial, Helvetica, sans-serif;
                padding:0px;
                display:block;
                margin:16px;
                font-weight: bold;
                ">Email : {{$student->email }}</h4>

                <br />
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
                        <iframe src="{{url('/fichiers/project/'.$projet_id.'/entreprise/'.$Projet->entreprise_id.'/'.$Projet->fichier)}}" style="border-style: none; border-radius: 15px;border: 1px solid black; width: 100%; height:250px;" frameborder="0"></iframe>
                    </div>
                    <form method="post" action="{{ url('/project/'.$projet_id.'/entreprise/'.$Projet->entreprise_id.'/downlaodProjet/' .$Projet->fichier) }}">
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
            affected Project
        </h4>
    </div>
    <div style="padding-top: 5px;" class="panel-heading">
        <div class="panel-body">
            <div class="col-xs-12 col-md-10 col-md-offset-1">
                <div class="well">
                    <!-- affected project-->
                    <div>
                        <label class="control-label">add your file</label>
                        <div class="">
                            <form method="post" action="{{ url('/projet/' . $projet_id .  '/student/'.Auth::user()->id.'/teacher/'.$Projet->teacher_id) }}" enctype="multipart/form-data">
                                <input type="file" name="fichier">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="submit"></input>
                            </form>
                        </div>
                        <div>

                            <label class="control-label">
                                your affected Project
                            </label>

                            @if($affected_project != null)
                            <div>
                               <iframe src="{{ url('/fichiers/project/' . $projet_id . '/student/'. $teacher_id.'/'.$affected_project) }}" style="border-style: none; border-radius: 15px;border: 1px solid black; width: 100%; height:250px;" frameborder="0"></iframe>
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

    <div style="margin-top: 50px;" class="panel panel-primary">
        <div class="panel-heading">
            <h4 class="panel-title">
                Student Response
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
    </div>
    <div class="panel-body">
        <div class="col-xs-12 col-md-10 col-md-offset-1">
            <div class="well">
                @if($affected_project == null)
                <p style="font-size: x-large;color: red;">unsigned</p>
                @endif
                @if($affected_project != null)

                <iframe src="{{ url('/fichiers/project/' . $projet_id . '/student/'.$student_id.'/'.$affected_project) }}" style="border-style: none; border-radius: 15px;border: 1px solid black; width: 100%; height:250px;" frameborder="0"></iframe>
                <form method="post" action="{{ url('/project/'.$projet_id.'/student/'.$student_id.'/downlaodStuProjet/' .$affected_project) }}">
                    <div style="display: flex;"> <button style="margin:auto ! important;" type="submit" class="button-36 ">Download Response<i class="fa-solid fa-download"></i></button></div>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                </form>
                @if($noteactuelle==null)
                <div style="font-size: x-large; color: red; margin-top: 10px;">-Pas encore corrigé</div>
                @else
                <div style="font-size: x-large; color: green;margin: 10px;">
                    La note actuel est: {{$noteactuelle}}
                </div>
                @endif
                @endif
            </div>
        </div>
    </div>
</div>
@endsection