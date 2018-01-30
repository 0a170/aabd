$(document).ready(function() {

   $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
   });

   //$('.commentForm').on('submit', function(e) {
   $("#createCommentForm").on('submit', function(e) {

      e.preventDefault();

      var commenterId = $("#commenterId").val();
      var userId = $("#userId").val();
      //var cCommenterIcon = $("#cCommenterIconId").val();
      var comment = $("#newCommentId").val();
      var token = $("#commentToken").val();

      if(comment == "Enter Comment" || comment == "") {
         $("#comStatus").html("Comment Cannot Be Empty");
         $("#comStatus").css('color', 'red');
         $("#comStatus").css('visibility', 'visible');
      }
      else {

      $.ajax({

         type: 'POST',
         url: userId + '/makeComment',
         dataType: 'JSON',
         data: { 'commenterId': commenterId, 'userId': userId, 'comment': comment, '_token': token },
         cache: false,

         success: function(response) {

            if(response.success) {
               $("#comStatus").html(response.success);
               $("#comStatus").css('color', 'green');
            }
            else
            if(response.failure) {
               $("#comStatus").html(response.success);
               $("#comStatus").css('color', 'red');
            }

            $("#comStatus").css('visibility', 'visible');

            setTimeout(function() {
               document.location.reload(true);
            }, 1500);

         }


      });
      }

   });

   $("#editCommentForm").on('submit', function(e) {

      e.preventDefault();

      var commentId = $("#eCommentId").val();
      var userId = $("#eUserPageId").val();
      var newComment = $("#newCommentTextId").val();

      var editCommentToken = $("#editCommentToken").val();

      if(newComment == "") {
         $("#editCommentStatus").html("Comment Cannot Be Empty");
         $("#editCommentStatus").css('color', 'red');
         $("#editCommentStatus").css('visibility', 'visible');
      }

      else {

         $.ajax({
            url: userId + '/editComment',
            type: 'POST',
            dataType: 'JSON',
            data: { 'commentId': commentId, 'userId': userId, 'newComment': newComment, '_token': editCommentToken },
            cache: false,

            success: function(response) {

               if(response.editSuccess) {
                  $("#editCommentStatus").html(response.editSuccess);
                  $("#editCommentStatus").css('color', 'green');
               }
               else
               if(response.editFailure) {
                  $("#editCommentStatus").html(response.editFailure);
                  $("#editCommentStatus").css('color', 'red');
               }

               $("#editCommentStatus").css('visibility', 'visible');

               setTimeout(function() {
                  document.location.reload(true);
               }, 1500);

            },


            error: function(response) {
               $("#editCommentStatus").html(response);
               $("#editCommentStatus").css('color', 'red');
               $("#editCommentStatus").css('visibility', 'visible');
            }
         });

      }

   });


});
