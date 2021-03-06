$(document).ready(function() {

   $(".loader").hide();

   $('body').click(function(e) {
      if(!(e.target.id == 'userNId')) {
         $(".response-table").html("");
      }
   });

   $(".userNClass").on('keyup', function() {

      var minLength = 3;
      var userInput = this;
      var userValue = userInput.value;

      if(userValue.length < minLength) {
         $(".response-table").html("");
      }

      if(userValue.length >= minLength) {
         $.ajax({
            type: "GET",
            url: 'search',
            data:{'user_input': userValue},
            success: function(response) {
               $(".response-table").empty();
               if(response == "") {
                  $(".loader").hide();
                  $(".response-table").html('<tr class="user-row"><td><h3> Found Nothing </h3></td></tr>');
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

   $("#closeBG").on('click', function() {
      if(topBGFlag == 1 || newestBGFlag == 1) {
         var allUsers = $("#button-results").children();

         $.each(allUsers, function(index, allUser) {
            $(allUser).removeClass('userDiv').addClass('userDivRemove');
         });
         setTimeout(function() {
            $("#button-results").empty();
         }, 500);
      }
      topBGFlag = 0;
   });

   $("#topBG").on ('click', function() {
      var buttonClicked = this;
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
            retStr += '<a href="user/' + response[i].id + '" class="userDiv" style="margin-bottom: 15px;"><div><img src="' + response[i].profileImage + '" style="display: inline-block;"> <p style="display: inline-block;">' + response[i].username +
                      ' and ' + response[i].score + '</div></a>';
          }
          $("#button-results").html(retStr);
        }
      });
      topBGFlag = 1;
      newestBGFlag = 0;
      }
    });

    $("#newestBG").on('click', function() {
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
               retStr += '<a href="user/' + response[i].id + '" class="userDiv" style="margin-bottom: 15px;"><div><img src="' + response[i].profileImage + '" style="display: inline-block;"> <p style="display: inline-block;">' + response[i].username +
                         ' and ' + response[i].score + '</p></div></a>';
            }
            $("#button-results").html(retStr);
          }
        });
        newestBGFlag = 1;
        topBGFlag = 0;
        }
      });
});
