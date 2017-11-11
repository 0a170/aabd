<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</head>
<body>

<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">Logo</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li class="active"><a href="#">Dashboard</a></li>
        <li><a href="#">Age</a></li>
        <li><a href="#">Gender</a></li>
        <li><a href="#">Geo</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="container-fluid">


    <div class="col-sm-9">

      <div class="well">
        <h4>Dashboard</h4>
        <p>Some text..</p>
      </div>



      <div class="row">
        <div class="col-sm-6">
           <h4>image</h4>
           <p>for user</p>
        </div>
        <div class="col-sm-6">
           <h4>stats</h4>
           <p>for user</p>
        </div>
      </div>


      <div class="row">
        <div class="col-sm-6">
           <p>Question</p>
        </div>
      </div>

    </div>



    <div class="col-sm-3">
      <div class="well">
        <p>Text</p>
        <p>Text</p>
        <p>Text</p>
        <p>Text</p>
      </div>
      <div class="well">
        <p>Text</p>
        <p>Text</p>
        <p>Text</p>
        <p>Text</p>
      </div>
      <div class="well">
        <p>Text</p>
        <p>Text</p>
        <p>Text</p>
        <p>Text</p>
      </div>
    </div>

</div>


</body>
</html>
