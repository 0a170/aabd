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





});
