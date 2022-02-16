<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Classroom - @yield('title')</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round" rel="stylesheet">


    <!-- CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  </head>

  <body>
    <!-- Include the navigation -->
    @include('layouts.navigation')

    <div class="container">
      @if (Auth::user())
        <div class="page-header" style="margin: -10px 0px 20px 0px;">
          <h2 class="text-right">@yield('page-header')</h2>
        </div>
        <div class="row">
          <div class="col-xs-12 col-md-4">
            @include('layouts.side-content')
          </div>

          <div class="col-xs-12 col-md-8">
            @yield('content')
          </div>
        </div>
      @else
        <div class="col-xs-12 col-md-8 col-md-offset-2">
          @yield('content')
        </div>
      @endif
    </div>

    <!-- JavaScript -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

    <!-- JavaScript Files That May Be Needed For Specific Purposes -->
    @stack('scripts')
  </body>
</html>