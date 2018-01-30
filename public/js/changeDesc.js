$(document).ready(function() {
   var comment = $("#nD").val();

   $("#editDescModal").on("hide.bs.modal", function() {
      $("#editDescStatus").css({'color': 'red', 'visibility': 'hidden'});
   });

   //$("#upd_desc").on('submit', function(e) {
   $("#upDescButton").on('click', function(e) {
      e.preventDefault();
      var comment = $("#nD").val();

      if(comment == "") {
         $("#editDescStatus").html("Description cannot Be Empty");
         $("#editDescStatus").css({'color': 'red', 'visibility': 'visible'});
      }
      else
      if(comment.length > 300) {
         $("#editDescStatus").html("Description Must Be Less Than 300 Characters");
         $("#editDescStatus").css({'color': 'red', 'visibility': 'visible'});
      }
      else {
         $("#upd_desc").submit();
      }
   });
});
