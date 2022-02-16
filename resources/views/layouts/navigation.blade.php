<!DOCTYPE html>
<html lang="en">

<head>
  <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"> -->
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>

<body>
  <header id="nav-wrapper">
    <nav id="nav">
      <div class="nav">
        <span class="gradient skew " style="width:200px;">
          <a href="#home">
            <div>
              <div>
                <span><img height="35" style="padding: 0px 5px ;margin-left:25px; position: relative;top: -5px; transform: skew(20deg);" src="{{url('image/icons8-presentation-64.png')}}" alt="hh"></span>
                <span> <a class="nav-link-span" style="color: white;" href="{{ url('/') }}">
                    <h4>Classroom</h4>
                  </a></span>
              </div>
            </div>

            <!--  -->
          </a>
        </span>

        <button id="menu" class="btn-nav"><span class="fas fa-bars"> </span></button>
      </div>
      @if (Auth::user())
      <div class="nav right">

        <a href="{{ url('/profile') }}" class="nav-link active"><span class="nav-link-span"><span class="u-nav">Profile</span></span></a>

        @if (Auth::user()->role == 'teacher')
        <a href="{{ url('/student/avatar') }}" class="nav-link"><span class="nav-link-span"><span class="u-nav">Students Classifications</span></span></a>
        <a href="{{ url('/course/create') }}" class="nav-link"><span class="nav-link-span"><span class="u-nav">Add Course</span></span></a>
        <a href="{{ url('/projet/addProject') }}" class="nav-link"><span class="nav-link-span"><span class="u-nav">Add Projet</span></span></a>
        @elseif(Auth::user()->role == 'entreprise')
        <a href="{{ url('/student/avatar') }}" class="nav-link"><span class="nav-link-span"><span class="u-nav">Students Classifications</span></span></a>
        <a href="{{ url('/project/addProject') }}" class="nav-link"><span class="nav-link-span"><span class="u-nav">Add Projet</span></span></a>
        @endif
      </div>
      @endif




      <!-- Authentication links -->
      @if (Auth::guest())
      <div class="nav right">
        <a href="{{ url('/login') }}" class="nav-link active"><span class="nav-link-span"><span class="u-nav">Login</span></span></a>
        <a href="{{ url('/register') }}" class="nav-link"><span class="nav-link-span"><span class="u-nav">Register</span></span></a>
      </div>
      @else
      <div>
        <p class="navbar-text ">Signed in as
          <a href="{{ url('/profile') }}" class="white">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</a>
        </p>
      </div>
      <div class="navbar-text ">
        <a href="{{ url('/logout') }}" style="padding: 0; padding-left: 15px;"><button type="button" class="">Logout</button></a>
      </div>
      @endif

    </nav>
  </header>
  <main>



  </main>

</body>

</html>