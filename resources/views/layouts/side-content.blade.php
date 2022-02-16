
@if(Auth::User()->role!="entreprise")
<div style="margin-top: 50px;" class="well">
  <h4>Courses</h4>
  @if (count(Auth::user()->courses()->get()) > 0)
  <div class="list-group">
    @foreach (Auth::user()->courses()->get() as $course)
    <a 
    style="
    margin-top: 10px;
    margin-bottom: 10px;
    
    "
    href="{{ url('course/' . $course->id) }}" class="list-group-item list-group-item-info">
      <h4 class="list-group-item-heading">
        {{ $course->subject }} {{ $course->course }}-{{ $course->section }}
      </h4>
      <p class="list-group-item-text">{{ $course->title }}</p>
    </a>
    @endforeach
  </div>
  @else
  @if (Auth::user()->role == 'teacher')
  <div class="alert alert-danger" role="alert">You do not have any active courses.</div>
  @else
  <div class="alert alert-danger" role="alert">You are no taking any courses.</div>
  @endif
  @endif
</div>
@endif

<?php
use App\Models\Project;
use App\Models\Projet;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
?>
@if(Auth::User()->role!="entreprise")
<div class="well">
  <h4>Projets</h4>
  @if(Auth::user()->role== 'student')
  @if (count(Projet::where('user_id',Auth::user()->id)->get())> 0)
  <div class="list-group">
    @foreach (Projet::where('user_id', Auth::user()->id)->get() as $projet)

    <a
    style=" margin-top: 10px;margin-bottom: 10px;"
    href="{{ url('projet/' . $projet->id. '/teacher/' . $projet->teacher_id) }}" class="list-group-item list-group-item-info">
      <h4 class="list-group-item-heading">
        Type: {{ $projet->type }}
      </h4>
      
    </a>

    @endforeach
  </div>
  @else
  <div class="alert alert-danger" role="alert">You are no taking any projects.</div>
  @endif


  @else
  @if (count(Projet::All()->where('teacher_id',Auth::user()->id))> 0)
  <div class="list-group">
    @foreach (Projet::All()->where('teacher_id', Auth::user()->id) as $projet)

    <a
    style="
    margin-top: 10px;
    margin-bottom: 10px;
    
    "
    href="{{ url('projet/' . $projet->id. '/student/' . $projet->user_id) }}" class="list-group-item list-group-item-info">
      <h4 class="list-group-item-heading">
        {{ $projet->type }}
      </h4>
      <h4>Nom complet: {{User::find($projet->user_id)->first_name }} {{User::find($projet->user_id)->last_name }}</h4>
      <h4>filière: {{User::find($projet->user_id)->filier }}</h4>
    </a>

    @endforeach
  </div>
  @else
  <div class="alert alert-danger" role="alert">You do not have any active projects.</div>
  @endif
  @endif


  <!-- <p>{{count(Auth::user()->projets()->get())}}</p> -->



</div>

@if (isset($assignments))
@if (count($assignments) > 0)
<div class="well">
  <h4>Assignments</h4>
  <div class="list-group">
    @foreach ($assignments as $assignment)
    <a href="{{ url('/course/' . $course_id . '/assignment/' . $assignment->id) }}" class="list-group-item list-group-item-info">
      <h4 class="list-group-item-heading">{{ $assignment->title }}</h4>
      <p class="list-group-item-text">Due Date: <u>{{ date('F jS Y \a\t h:i A', strtotime($assignment->due_date)) }}</u></p>
    </a>
    @endforeach
  </div>
</div>
@endif
@endif
@endif
@if(Auth::user()->role== 'student' || Auth::user()->role== 'entreprise' )
<div class="well">
  <h4>Entreprise Project</h4>
  @if(Auth::user()->role== 'student' || Auth::user()->role== 'entreprise' )
  <?php $target=(Auth::user()->role== 'student' ? "user_id":"entreprise_id") ?>
  @if (count(Project::where($target,Auth::user()->id)->get())> 0)
  <div class="list-group">
    @foreach (Project::where($target, Auth::user()->id)->get() as $projet)

    <a style=" margin-top: 10px;margin-bottom: 10px;" href="{{ url('project/' . $projet->id. '/teacher/' . $projet->entreprise_id) }}" class="list-group-item list-group-item-info">
      <h4 class="list-group-item-heading"> Titre: {{ $projet->titre }}</h4>  </a>

    @endforeach
  </div>
  @else
  <div class="alert alert-danger" role="alert">You are no taking any projects.</div>
  @endif


  @if (count(Projet::All()->where('teacher_id',Auth::user()->id))> 0)
  <div class="list-group">
    @foreach (Projet::All()->where('teacher_id', Auth::user()->id) as $projet)

    <a
    style="
    margin-top: 10px;
    margin-bottom: 10px;
    
    "
    href="{{ url('projet/' . $projet->id. '/student/' . $projet->user_id) }}" class="list-group-item list-group-item-info">
      <h4 class="list-group-item-heading">
        {{ $projet->type }}
      </h4>
      <h4>Nom complet: {{User::find($projet->user_id)->first_name }} {{User::find($projet->user_id)->last_name }}</h4>
      <h4>filière: {{User::find($projet->user_id)->filier }}</h4>
    </a>

    @endforeach
  </div>
  @endif
  @else
  <div class="alert alert-danger" role="alert">You do not have any active projects.</div>

  @endif


  <!-- <p>{{count(Auth::user()->projets()->get())}}</p> -->



</div>

@endif