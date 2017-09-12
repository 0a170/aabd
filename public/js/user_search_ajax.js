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

      var userValue = $("#itemNameID").val();

      alert(userValue);

      if(userValue === null) {

         $('#failedRequest').show().html("empty");

      }

      else {

         window.location.href = "http://aabd.herokuapp.com/user/" + userValue;

      }

   });





});
