<!DOCTYPE html>
<html>
<head>
    <title>Laravel 9 link shortener</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha/css/bootstrap.css" rel="stylesheet">
</head>
<body>
    <!-- header -->
    <header class="header">
      <nav class="navbar navbar-dark bg-dark">
        <div class="container">
          <a class="navbar-brand" href="#"> Logo </a>
        </div>
      </nav>
    </header>

    <!-- /header -->  
<div class="container">
    @yield('content')
</div>
   
</body>
</html>