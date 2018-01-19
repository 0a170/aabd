$(document).ready(function() {

   $(".loader").hide();
   /*$('.itemName').select2({
     placeholder: 'Search for a user',
     ajax: {
       //url: '/userSearch',
       url: 'search',
       dataType: 'json',
       delay: 250,
       processResults: function (data) {
         return {
           results:  $.map(data, function (item) {
                 return {
                     text: item.user_name,
                     id: item.id
                 }
             })
         };
       },
       cache: true
     }

  }); */



   /*$("#goUser").on('click', function(){

      var userValue = $("#itemNameID").val();

      if(userValue === null || userValue == "") {

         $('#failedRequest').show().html("Please select a user");

      }

      else {

         window.location.href = "http://aabd.herokuapp.com/user/" + userValue;

      }

   }); */

   $(".userNClass").on('keyup', function() {

      var minLength = 3;

      var userInput = this;

      var userValue = userInput.value;

      if(userValue.length < minLength) {
         $(".response-table").html("");
      }

      if(userValue.length >= minLength) {

         $(".loader").show();

         $.ajax({
            type: "GET",
            url: 'search',
            //data: userValue,
            data:{'user_input': userValue},
            success: function(response) {
               $(".response-table").empty();
               if(response == "") {
                  $(".loader").hide();
                  $(".response-table").html('<tr class="user-row"><td> Found Nothing </td></tr>');
               }
               else
               if(response != ""){
                  $(".loader").hide();
                  $(".response-table").html(response);
               }
            }


         });

      }


   });

   var topBGFlag = 0;
   var newestBGFlag = 0;

   $("#topBG").on ('click', function() {

      var buttonClicked = this;

      //$(".loader").show();

      if(topBGFlag == 0) {
      $.ajax({
        type: "GET",
        dataType: 'JSON',
        url: 'topUsers',
        success: function(response) {
          $(".loader").hide();
          $("#button-results").empty();
          var retStr = "";
          for(var i=0; i < response.length; i++) {

            //retStr += '<div class="userDiv">' + response[i].username +
            retStr += '<a href="user/' + response[i].id + '"><div class="userDiv"><img src="' + response[i].profileImage + '" style="display: inline-block;"> <p style="display: inline-block;">' + response[i].username +
                      ' and ' + response[i].score + '</div></a><br>';
          }
          $("#button-results").html(retStr);
        }

      });

      topBGFlag = 1;
      newestBGFlag = 0;

      }

    });

    $("#newestBG").on('click', function() {

      //$(".loader").show();
        if(newestBGFlag == 0) {

        $.ajax({
          type: "GET",
          dataType: 'JSON',
          url: 'newestUsers',
          success: function(response) {
            $(".loader").hide();
            $("#button-results").empty();
            var retStr = "";
            for(var i=0; i < response.length; i++) {

              //retStr += '<div class="userDiv"><img src="{{ Storage::disk(\'s3\')->url(\'thumbnails/thumbnail_' + response[i].profileImage + '\') }}"> <p>' + response[i].username +
              retStr += '<a href="user/' + response[i].id + '"><div class="userDiv"><img src="' + response[i].profileImage + '" style="display: inline-block;"> <p style="display: inline-block;">' + response[i].username +
                        ' and ' + response[i].score + '</p></div></a><br>';
            }
            $("#button-results").html(retStr);
          }

        });

        newestBGFlag = 1;
        topBGFlag = 0;

        }

      });

});
