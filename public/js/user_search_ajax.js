$(document).ready(function() {

   $('.itemName').select2({
     placeholder: 'Search for a user',
     ajax: {
       //url: '/userSearch',
       url: 'search-test',
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

   });


   $("#goUser").on('click', function(){

      userValue = $("#itemNameID").val();

      if(userValue != "" || userValue !== null || userValue !== "null") {

         window.location.href = "http://aabd.herokuapp.com/user/" + userValue;

      }

      else if(userValue == "" || userValue == null || userValue == "null") {

         //alert("empty");
         $('#failedRequest').show().html("empty");

      }

      else {

         alert("something isn't right here");

      }

   });





});
