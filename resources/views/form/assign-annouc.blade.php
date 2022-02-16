<div id="forms">
  <div id="assignment-form" class="forms">
    <form class="form-horizontal" role="form" method="POST" enctype="multipart/form-data" action="{{ url('/course/' . $course_id . '/assignment')}}">
      {{ csrf_field() }}

      <!-- Title -->
      <div class="form-group{{ $errors->has('title') ? ' has-error': ''}}">
        <label class="col-md-3 control-label">Title</label>
        <div class="col-md-5">
          <input type="text" class="form-control" name="title" value="{{ old('title') }}" placeholder="Chapter 1 Assignment">

          @if ($errors->has('title'))
          <span class="help-block"><strong>{{ $errors->first('title') }}</strong></span>
          @endif
        </div>
      </div>

      <!-- Due Date -->
      <div class="form-group{{ $errors->has('due_date') ? ' has-error': ''}}">
        <label class="col-md-3 control-label">Due Date</label>
        <div class="col-md-5">
          <input type="datetime-local" class="form-control" name="due_date" value="{{ old('due_date') }}">

          @if ($errors->has('due_date'))
          <span class="help-block"><strong>{{ $errors->first('due_date') }}</strong></span>
          @endif
        </div>
      </div>

      <!-- Description -->
      <div class="form-group{{ $errors->has('description') ? ' has-error': ''}}">
        <label class="col-md-3 control-label">Description</label>
        <div class="col-md-5">
          <textarea class="form-control" name="description" value="{{ old('description') }}" placeholder="Type in the description here..." rows="4"></textarea>

          @if ($errors->has('description'))
          <span class="help-block"><strong>{{ $errors->first('description') }}</strong></span>
          @endif
        </div>
      </div>
      <!-- Upload Assignment PDF -->
      <div>
        <label class="col-md-3 control-label">Assignment Questions </label>
        <input class="form-check-input" type="file" name="fichier" value="DownloadAssignementQuestions">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
      </div>

      <!-- Submit Button -->
      <div class="form-group">
        <div class="col-md-4 col-md-offset-6">
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </div>

    </form>
  </div>

  <div id="annoucement-form" class="forms">
    <form class="form-horizontal" role="form" method="POST" action="{{ url('/course/' . $course_id . '/annoucement') }}">
      {{ csrf_field() }}

      <!-- Title -->
      <div class="form-group{{ $errors->has('title') ? ' has-error': ''}}">
        <label class="col-md-3 control-label">Title</label>
        <div class="col-md-5">
          <input type="text" class="form-control" name="title" value="{{ old('title') }}" placeholder="Important Annoucement">

          @if ($errors->has('title'))
          <span class="help-block"><strong>{{ $errors->first('title') }}</strong></span>
          @endif
        </div>
      </div>

      <!-- Message -->
      <div class="form-group{{ $errors->has('message') ? ' has-error': ''}}">
        <label class="col-md-3 control-label">Message</label>
        <div class="col-md-5">
          <textarea class="form-control" name="message" value="{{ old('message') }}" placeholder="Type in your message here..." rows="3"></textarea>

          @if ($errors->has('message'))
          <span class="help-block"><strong>{{ $errors->first('message') }}</strong></span>
          @endif
        </div>
      </div>


      <!-- Submit Button -->
      <div class="form-group">
        <div class="col-md-4 col-md-offset-6">
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </div>

    </form>
  </div>
</div>