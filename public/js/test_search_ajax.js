//$(document).ready(function(){
var timer;
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

}


//});
