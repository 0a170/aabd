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

   <table style="width: 100%; max-width: 600px;" border="0" cellpadding="0" cellspacing="0">

    <tr>
     <td style="background: #80bfff">
      <img src="{{ asset('logo.png') }}" style="display: block; margin: auto;">
     </td>
    </tr>

    <tr>
     <td>
      <br>
      <br>
      <br>
      {{ $body }}
      <br>
      <br>

      <div class="color: #ffffff; background-color: #611BBD; border-color: #130269;">

         <a href="{{ url('/ask') }}" class="btn btn-primary btn-lg">Ask Again</a>

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
