<!DOCTYPE html>
<html>
<body>

<head>

   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

   <link rel="stylesheet" type="text/css" href="{{ asset('css/email_style.css') }}">

</head>

<body style="text-align: center;">

<div class="container">

   <table style="width: 100%; max-width: 600px;" border="1" cellpadding="0" cellspacing="0">

    <tr>
     <td style="background: #80bfff">
       <h1 style="text-align: center; color: #00008B;"> Ask A Bored Guy <h1>
     </td>
    </tr>

    <tr>
     <td>
      <br>
      <br>
      <br>
      <h2 style="color: #00008B;"> {{ $body }} </h2>
      <br>
      <br>
      <br>
      <div class="color: #ffffff; background: #611BBD; border-color: #130269;">

         <a href="{{ url('/ask') }}">Ask Again</a>

      </div>

      <br>
      <br>
     </td>
    </tr>

    <tr>
     <td class="footer">
        <br>
        <br>
        <br>
        <br>
        <br>
     </td>
    </tr>

   </table>

</div>

</body>
</html>
