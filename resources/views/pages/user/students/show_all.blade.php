@extends('layouts.app')

@section('title', 'All Students')

@section('page-header', 'All Students')

@section('content')
<!-- Display flashed session data on successful action -->
@include('common.session-data')

<div class="panel panel-primary">
  <div class="panel-heading">
    <h4 class="panel-title">
      All Students In The System
    </h4>
  </div>

  <div class="panel-body">
    @if (isset($users) && count($users) > 0 )
    <div class="col-md-10 col-md-offset-3">
      <form class="form-horizontal" role="form" method="POST" action="{{ url('/course/' . $course . '/student') }}">
        {{ csrf_field() }}


        <h3 class="panel-title">
          <a role="button" data-toggle="collapse" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">All Student in Lsi</a>
        </h3>



        <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labellledby="headingOne">
          <h3 class="panel-title">
            <a role="button" data-toggle="collapse" href="#S1" aria-expanded="true" aria-controls="collapseOne">S1</a>
          </h3>

          <div id="S1" class="panel-collapse collapse" role="tabpanel" aria-labellledby="headingOne">
            @foreach ($users as $user)
            @if ($user->filier == 'lsi' && $user->semestre=='s1' && $user->role=='student')
            <div class="checkbox">
              <label>
                <input type="checkbox" name="{{ $user->id }}" value="{{ $user->id }}">
                {{ $user->first_name }} {{ $user->last_name }} [ {{ $user->email }} ]
              </label>
            </div>
            @endif
            @endforeach
          </div>

          <h3 class="panel-title">
            <a role="button" data-toggle="collapse" href="#S2" aria-expanded="true" aria-controls="collapseOne">S2</a>
          </h3>

          <div id="S2" class="panel-collapse collapse" role="tabpanel" aria-labellledby="headingOne">
            @foreach ($users as $user)
            @if ($user->filier == 'lsi' && $user->semestre=='s2' && $user->role=='student')
            <div class="checkbox">
              <label>
                <input type="checkbox" name="{{ $user->id }}" value="{{ $user->id }}">
                {{ $user->first_name }} {{ $user->last_name }} [ {{ $user->email }} ]
              </label>
            </div>
            @endif
            @endforeach



          </div>

          <h4 class="panel-title">
            <a role="button" data-toggle="collapse" href="#S3" aria-expanded="true" aria-controls="collapseOne">S3</a>
          </h4>

          <div id="S3" class="panel-collapse collapse" role="tabpanel" aria-labellledby="headingOne">
            @foreach ($users as $user)
            @if ($user->filier == 'lsi' && $user->semestre=='s3' && $user->role=='student')
            <div class="checkbox">
              <label>
                <input type="checkbox" name="{{ $user->id }}" value="{{ $user->id }}">
                {{ $user->first_name }} {{ $user->last_name }} [ {{ $user->email }} ]
              </label>
            </div>
            @endif
            @endforeach



          </div>




          <h3 class="panel-title">
            <a role="button" data-toggle="collapse" href="#S4" aria-expanded="true" aria-controls="collapseOne">S4</a>
          </h3>


          <div id="S4" class="panel-collapse collapse" role="tabpanel" aria-labellledby="headingOne">
            @foreach ($users as $user)
            @if ($user->filier == 'lsi' && $user->semestre=='s4' && $user->role=='student')
            <div class="checkbox">
              <label>
                <input type="checkbox" name="{{ $user->id }}" value="{{ $user->id }}">
                {{ $user->first_name }} {{ $user->last_name }} [ {{ $user->email }} ]
              </label>
            </div>
            @endif
            @endforeach



          </div>



          <h3 class="panel-title">
            <a role="button" data-toggle="collapse" href="#S5" aria-expanded="true" aria-controls="collapseOne">S5</a>
          </h3>

          <div id="S5" class="panel-collapse collapse" role="tabpanel" aria-labellledby="headingOne">
            @foreach ($users as $user)
            @if ($user->filier == 'lsi' && $user->semestre=='s5' && $user->role=='student')
            <div class="checkbox">
              <label>
                <input type="checkbox" name="{{ $user->id }}" value="{{ $user->id }}">
                {{ $user->first_name }} {{ $user->last_name }} [ {{ $user->email }} ]
              </label>
            </div>
            @endif
            @endforeach



          </div>



          <h3 class="panel-title">
            <a role="button" data-toggle="collapse" href="#S6" aria-expanded="true" aria-controls="collapseOne">S6</a>
          </h3>

          <div id="S6" class="panel-collapse collapse" role="tabpanel" aria-labellledby="headingOne">
            @foreach ($users as $user)
            @if ($user->filier == 'lsi' && $user->semestre=='s6' && $user->role=='student')
            <div class="checkbox">
              <label>
                <input type="checkbox" name="{{ $user->id }}" value="{{ $user->id }}">
                {{ $user->first_name }} {{ $user->last_name }} [ {{ $user->email }} ]
              </label>
            </div>
            @endif
            @endforeach



          </div>


        </div>



        <br />




        <!-- Licence -->


        <h3 class="panel-title">
          <a role="button" data-toggle="collapse" href="#LicenceStudents" aria-expanded="true" aria-controls="collapseOne">All Student in Licence</a>
        </h3>



        <div id="LicenceStudents" class="panel-collapse collapse" role="tabpanel" aria-labellledby="headingOne">
          <h3 class="panel-title">
            <a role="button" data-toggle="collapse" href="#S5L" aria-expanded="true" aria-controls="collapseOne">S5</a>
          </h3>

          <div id="S5L" class="panel-collapse collapse" role="tabpanel" aria-labellledby="headingOne">
            @foreach ($users as $user)
            @if ($user->filier == 'licence' && $user->semestre=='s5' && $user->role=='student')
            <div class="checkbox">
              <label>
                <input type="checkbox" name="{{ $user->id }}" value="{{ $user->id }}">
                {{ $user->first_name }} {{ $user->last_name }} [ {{ $user->email }} ]
              </label>
            </div>
            @endif
            @endforeach



          </div>

          <h3 class="panel-title">
            <a role="button" data-toggle="collapse" href="#S6L" aria-expanded="true" aria-controls="collapseOne">S6</a>
          </h3>

          <div id="S6L" class="panel-collapse collapse" role="tabpanel" aria-labellledby="headingOne">
            @foreach ($users as $user)
            @if ($user->filier == 'licence' && $user->semestre=='s6' && $user->role=='student')
            <div class="checkbox">
              <label>
                <input type="checkbox" name="{{ $user->id }}" value="{{ $user->id }}">
                {{ $user->first_name }} {{ $user->last_name }} [ {{ $user->email }} ]
              </label>
            </div>
            @endif
            @endforeach



          </div>




        </div>

        <br />

        <!-- Master  -->


        <h3 class="panel-title">
          <a role="button" data-toggle="collapse" href="#MasterStudents" aria-expanded="true" aria-controls="collapseOne">All Student in Master</a>
        </h3>



        <div id="MasterStudents" class="panel-collapse collapse" role="tabpanel" aria-labellledby="headingOne">
          <h3 class="panel-title">
            <a role="button" data-toggle="collapse" href="#S1M" aria-expanded="true" aria-controls="collapseOne">S1</a>
          </h3>

          <div id="S1M" class="panel-collapse collapse" role="tabpanel" aria-labellledby="headingOne">
            @foreach ($users as $user)
            @if ($user->filier == 'master' && $user->semestre=='s1' && $user->role=='student')
            <div class="checkbox">
              <label>
                <input type="checkbox" name="{{ $user->id }}" value="{{ $user->id }}">
                {{ $user->first_name }} {{ $user->last_name }} [ {{ $user->email }} ]
              </label>
            </div>
            @endif
            @endforeach



          </div>

          <h3 class="panel-title">
            <a role="button" data-toggle="collapse" href="#S2M" aria-expanded="true" aria-controls="collapseOne">S2</a>
          </h3>

          <div id="S2M" class="panel-collapse collapse" role="tabpanel" aria-labellledby="headingOne">
            @foreach ($users as $user)
            @if ($user->filier == 'master' && $user->semestre=='s2' && $user->role=='student')
            <div class="checkbox">
              <label>
                <input type="checkbox" name="{{ $user->id }}" value="{{ $user->id }}">
                {{ $user->first_name }} {{ $user->last_name }} [ {{ $user->email }} ]
              </label>
            </div>
            @endif
            @endforeach



          </div>

          <h4 class="panel-title">
            <a role="button" data-toggle="collapse" href="#S3M" aria-expanded="true" aria-controls="collapseOne">S3</a>
          </h4>

          <div id="S3M" class="panel-collapse collapse" role="tabpanel" aria-labellledby="headingOne">
            @foreach ($users as $user)
            @if ($user->filier == 'master' && $user->semestre=='s3' && $user->role=='student')
            <div class="checkbox">
              <label>
                <input type="checkbox" name="{{ $user->id }}" value="{{ $user->id }}">
                {{ $user->first_name }} {{ $user->last_name }} [ {{ $user->email }} ]
              </label>
            </div>
            @endif
            @endforeach



          </div>




          <h3 class="panel-title">
            <a role="button" data-toggle="collapse" href="#S4M" aria-expanded="true" aria-controls="collapseOne">S4</a>
          </h3>


          <div id="S4M" class="panel-collapse collapse" role="tabpanel" aria-labellledby="headingOne">
            @foreach ($users as $user)
            @if ($user->filier == 'master' && $user->semestre=='s4' && $user->role=='student')
            <div class="checkbox">
              <label>
                <input type="checkbox" name="{{ $user->id }}" value="{{ $user->id }}">
                {{ $user->first_name }} {{ $user->last_name }} [ {{ $user->email }} ]
              </label>
            </div>
            @endif
            @endforeach



          </div>


        </div>



        <br />




        <br />

        <!-- Display all users -->
        <!-- @foreach ($users as $user)
            @if ($user->role == 'student')
              <div class="checkbox">
                <label>
                  <input type="checkbox" name="{{ $user->id }}" value="{{ $user->id }}">
                  {{ $user->first_name }} {{ $user->last_name }} [ {{ $user->email }} ]
                </label>
              </div>
            @endif
          @endforeach

          <br /> -->

        <!-- Submit Button -->
        <div class="form-group">
          <div class="col-md-offset-4">
            <button type="submit" class="btn btn-primary">Add Students</button>
          </div>
        </div>

      </form>
    </div>

    @endif
  </div>
</div>
@endsection