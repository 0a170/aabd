<!DOCTYPE html>
<html>
<body>

<head>

   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

   <style>

      @import url(https://fonts.googleapis.com/css?family=Roboto:300);

      table {

      }

      .header {
         background: #80bfff;
      }

      .footer {
         background: #888888;
      }

      p {
   	   font-family: "Roboto", sans-serif;
   	   color: #888888;
   	   //font-size: 20px;
   	   font-size:1.1em;
         font-weight: 300;
   	   text-shadow: none;
      }

      h2 {
   	   font-family: "Roboto", sans-serif;
   	   color: #888888;
   	   text-shadow: none;
      }

      h1 {
   	   font-family: "Roboto", sans-serif;
   	   text-align: center;
         color: #888888;
   	   font-size: 36px;
   	   font-weight: 300;
      }

      .ask-button {
         color: white;
         border: 1 px #888888;
         background: #611BBD;
         border-color: #130269;
      }

   </style>

</head>

<body style="text-align: center;">

<div class="container">

   <table style="width: 100%; max-width: 600px;" border="1" cellpadding="0" cellspacing="0">

    <tr>
     <td bgcolor="#80bfff" class="header">
       <h1> Ask A Bored Guy <h1>
     </td>
    </tr>

    <tr>
     <td>
      <br>
      <br>
      <br>
      <h2 style="color: #888888;"> {{ $body }} </h2>
      <br>
      <br>
      <br>
      <div class="ask-button">

         <a href="{{ url('/ask') }}">Ask Again</a>

      </div>

      <br>
      <br>
     </td>
    </tr>

    <tr>
     <td bgcolor="#80bfff" class="footer" >
        <br>
        <p> Copyright - Ask A Bored Dude </p>
        <br>
     </td>
    </tr>

   </table>

</div>

</body>
</html>
