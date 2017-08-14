//$(document).ready(function(){

$('.itemName').on('keyup', function() {

   $value = $(this).val();

   $.ajax({

      type: 'GET',
      url: 'search',
      data: {'search': $value},

      success: function(data) {

         //console.log(data);
         if(data != "") {

            $('.results').html(data);

         }

      }

   });

});

/*var timer;
function searchUser() {

   timer = setTimeOut(function(){

      var keywords = $('#search-input').val();

      if(keywords.length > 0){

         $.post('search', {keywords: keywords}, function(markup){

            $('.results').html(markup);

         });

      }

   }, 500);

}

function searchDown() {

   clearTimeout(timer);

} */


//});
