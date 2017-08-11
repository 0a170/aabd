$(document).ready(function() {

   $('.itemName').select2({
     placeholder: 'Select an item',
     ajax: {
       url: '/userSearch',
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

});
