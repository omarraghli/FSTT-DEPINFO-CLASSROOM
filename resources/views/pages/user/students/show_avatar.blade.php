@extends('layouts.app')

@section('title', 'All Students')

@section('page-header', 'All Students')

@section('content')
<!-- Display flashed session data on successful action -->
@include('common.session-data')



<div style="margin: 50px;" class="panel panel-primary">
  <div class="panel-heading">
    <h4 class="panel-title">
      Students classification
    </h4>
  </div>
 
  <div class="panel-body">
 
  
  <h3 class="panel-title">

  <img  style="width: 30px;" data-toggle="modal" src="{{url('image/icons8-medal-64.png')}}"  class="user"/>

          <a role="button" data-toggle="collapse" href="#silver" aria-expanded="true" aria-controls="collapseOne">Silver Students</a>
        </h3>
   <br/>

   <div id="silver" class="panel-collapse collapse" role="tabpanel" aria-labellledby="headingOne">
  @foreach ($users as $user)
        @if($user->role=='student' && $user->score<=10)
        <div style="margin-left: 40px; " >
                        <span style="font-weight: bold;color: #2e8be2;">Nom : </span>
                    {{ $user->first_name }} {{ $user->last_name }} 
                    <span style="font-weight: bold;padding-left: 15px;color: #2e8be2;">Email :</span>
                          {{ $user->email }} 
                          <span style="font-weight: bold;padding-left: 15px;color: #2e8be2;"> Filière :</span>
                          {{ $user->filier }} 
                          <span style="font-weight: bold;padding-left: 15px;color: #2e8be2;"> semestre :</span>
                          {{ $user->semestre }} 
                          
            </div>
              <br/>
         @endif
  @endforeach
  
  <br/>
  </div>

  <h3 class="panel-title">
  <img  style="width: 30px;"  data-toggle="modal" src="{{url('image/icons8-military-medal-96.png')}}"  class="user"/>
          <a role="button" data-toggle="collapse" href="#gold" aria-expanded="true" aria-controls="collapseOne">Gold Students</a>
        </h3>
   <br/>
   
   <div id="gold" class="panel-collapse collapse" role="tabpanel" aria-labellledby="headingOne">
  @foreach ($users as $user)
        @if($user->role=='student' && $user->score>10 && $user->score<=16 )
        <div style="margin-left: 40px; " >
                        <span style="font-weight: bold;color: #2e8be2;">Nom : </span>
                    {{ $user->first_name }} {{ $user->last_name }} 
                    <span style="font-weight: bold;padding-left: 15px;color: #2e8be2;">Email :</span>
                          {{ $user->email }} 
                          <span style="font-weight: bold;padding-left: 15px;color: #2e8be2;"> Filière :</span>
                          {{ $user->filier }} 
                          <span style="font-weight: bold;padding-left: 15px;color: #2e8be2;"> semestre :</span>
                          {{ $user->semestre }} 
                          
            </div>
              <br/>
         @endif
  @endforeach

  <br/>
  </div>
  <h3 class="panel-title">
  <img  style="width: 30px;"  data-toggle="modal" src="{{url('image/icons8-diamond-64.png')}}"  class="user"/>
          <a role="button" data-toggle="collapse" href="#dia" aria-expanded="true" aria-controls="collapseOne">Diamond Students</a>
        </h3>
   <br/>
   
   <div id="dia" class="panel-collapse collapse" role="tabpanel" aria-labellledby="headingOne">
  @foreach ($users as $user)
        @if($user->role=='student' && $user->score>16 && $user->score<=19 )
        <div style="margin-left: 40px; " >
                        <span style="font-weight: bold;color: #2e8be2;">Nom : </span>
                    {{ $user->first_name }} {{ $user->last_name }} 
                    <span style="font-weight: bold;padding-left: 15px;color: #2e8be2;">Email :</span>
                          {{ $user->email }} 
                          <span style="font-weight: bold;padding-left: 15px;color: #2e8be2;"> Filière :</span>
                          {{ $user->filier }} 
                          <span style="font-weight: bold;padding-left: 15px;color: #2e8be2;"> semestre :</span>
                          {{ $user->semestre }} 
                          
            </div>
              <br/>
         @endif
  @endforeach

  <br/>
</div>


<h3 class="panel-title">
        <img  style="width: 30px;" data-toggle="modal" src="{{url('image/icons8-crown-85.png')}}"  class="user"/>
          <a role="button" data-toggle="collapse" href="#king" aria-expanded="true" aria-controls="collapseOne">king students</a>
        </h3>

   <div id="king" class="panel-collapse collapse" role="tabpanel" aria-labellledby="headingOne" >
  @foreach ($users as $user)
        @if($user->role=='student' && $user->score==20 )
        <div style="margin-left: 40px; " >
                        <span style="font-weight: bold;color: #2e8be2;">Nom : </span>
                    {{ $user->first_name }} {{ $user->last_name }} 
                    <span style="font-weight: bold;padding-left: 15px;color: #2e8be2;">Email :</span>
                          {{ $user->email }} 
                          <span style="font-weight: bold;padding-left: 15px;color: #2e8be2;"> Filière :</span>
                          {{ $user->filier }} 
                          <span style="font-weight: bold;padding-left: 15px;color: #2e8be2;"> semestre :</span>
                          {{ $user->semestre }} 
                          
            </div>
              <br/>
         @endif
  @endforeach
</div>
  <br/>
  

  </div>
</div>
@endsection