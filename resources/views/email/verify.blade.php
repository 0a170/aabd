<!DOCTYPE html>
<html>
<body>
<head>
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

   <style>
      @import url(https://fonts.googleapis.com/css?family=Roboto:300);

      p {
   	   font-family: "Roboto", sans-serif;
   	   color: #4981ce;
   	   font-size:1em;
         font-weight: 300;
   	   text-shadow: none;
         text-align: center;
      }

      h2 {
   	   font-family: "Roboto", sans-serif;
   	   color: #4981ce;
   	   text-shadow: none;
         text-align: center;
      }

      h1 {
   	   font-family: "Roboto", sans-serif;
   	   text-align: center;
         color: #4981ce;
   	   font-size: 36px;
   	   font-weight: 300;
      }

      .ask-button {
         color: white;
         border: 1 px #4981ce;
         background: #4981ce;
         border-color: #130269;
         text-align: center;
         border: 10px solid #4981ce;
         border-radius: 5px;
         display: inline-block;
      }

      td.header {
         text-align: center;
         border-bottom: 3px solid #4981ce;
         background: #80bfff;
      }

      td.footer {
         border-top: 3px solid #4981ce;
         background: #80bfff;
      }

      a {
        text-decoration: none;
        /*color: white; */
        font-size: 20px;
        font-family: "Roboto", sans-serif;
        font-weight: normal;
      }
   </style>
</head>

<body style="text-align: center;">
<div class="container">
   <table style="width: 100%; max-width: 600px;" border="0" cellpadding="0" cellspacing="0">
       <tr>
        <td class="header">
           <h1 style="text-align: center; color: #4981ce;"> Ask A Bored Guy <h1>
        </td>
       </tr>
       <tr>
        <td><br><br><br>
         <h2 style="color: #4981ce;">
            Thank you for registering, {{ $user->user_name }}.
            Follow the link below to verify your email.
         </h2>
         <div style="text-align: center;">
            <a href="{{ url('/verify/' . $user->email_token) }}" class="ask-button" style="text-align: center; color: white;">Verify Email</a>
         </div>
         <br><br>
        </td>
       </tr>
       <tr>
        <td class="footer"><br>
           <p style="text-align: center; color: #4981ce;"> Copyright - Ask A Bored Dude </p><br>
        </td>
       </tr>
   </table>
</div>
</body>
</html>
