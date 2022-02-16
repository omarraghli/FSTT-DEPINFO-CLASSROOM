@extends('layouts.app')

@section('title', 'Project Detail')

@section('page-header', 'Add Project')

@section('content')
<!-- Display flashed session data on successful action -->
@include('common.session-data')

<div style="margin-top: 50px;" class="panel panel-primary">
    <div class="panel-heading">
        <h4 class="panel-title">
            Add New Project
        </h4>
    </div>

    <div class="panel-body">
        <div class="col-xs-12 col-md-12">
            <form class="form-horizontal" role="form" enctype="multipart/form-data" method="POST" action="{{ url('/projet/storeProject') }}">
                {{ csrf_field() }}

                <!-- type -->
                <div class="form-group">
                    <label class="col-md-4 control-label">type</label>
                    <div class="col-md-5">
                        <input type="text" class="form-control" name="type" placeholder="PFA PFE">
                    </div>
                </div>

                <!-- Due Date -->
                <div class="form-group{{ $errors->has('due_date') ? ' has-error': ''}}">
                    <label class="col-md-4 control-label">Due Date</label>
                    <div class="col-md-5">
                        <input type="datetime-local" class="form-control" name="due_date" value="{{ old('due_date') }}">

                        @if ($errors->has('due_date'))
                        <span class="help-block"><strong>{{ $errors->first('due_date') }}</strong></span>
                        @endif
                    </div>
                </div>


                <!-- Student -->

                <div class="form-group">
                    <label class="col-md-4 control-label">Student</label>
                    <div class="col-md-5">
                        <select name="Student" class="form-control">
                            @foreach ($users as $user)
                            @if ($user->role == 'student')
                            <option value="{{ $user->id }}">
                                {{ $user->first_name }} {{ $user->last_name }} [ {{ $user->email }}] {{$user->semestre}} {{$user->filier}}
                                @endif
                                @endforeach
                        </select>
                    </div>
                </div>
                <!-- Project Questions -->
                <div class="form-group">
                    <label class="col-md-4 control-label">Project Questions</label>
                    <input style="
    color: #00b1ca;
    font-weight: bold;
  padding:5px 15px;

  font-size: 15px;
  font-weight: bold;" class="form-check-input" type="file" name="fichier" value="DownloadAssignementQuestions">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                </div>


                <!-- Submit Button -->
                <div class="form-group">
                    <div class="col-md-4 col-md-offset-7">
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </div>

            </form>
        </div>
    </div>

</div>
@endsection