$(document).ready(function() {

   function charCount(str) {
      var count = 0;
      var charArr = str.split("");
      for(var i = 0; i < charArr.length; i++) {
         count += 1;
      }
      return count;
   }

  $.ajaxSetup({
  		headers: {
  					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  		}
  });

  var form = $("#frmDemo");
  var emailReg = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;

  $("#frmDemo").steps({

	 headerTag: "h3",
    bodyTag: "section",
    transitionEffect: "slideLeft",
    autoFocus: true,
    labels: {
      previous: "Back",
      finish: "Done"
    },

	onFinished: function(event, currentIndex)
	{
		var ques = $("#quest").val();
		var em = $("#em").val();
		var token = $(":hidden").val();
		var tokenClass = $("#frmDemo:hidden").attr('class');
      var statusClass = $("#question_status").data('class');

      $('#em').click(function() {
         $('#em').css('background', 'white');
      });

      $('#quest').click(function() {
         $('#quest').css('background', 'white');
      });

		if(ques == "" || em == "") {
         $('#question_status').addClass('alert-danger').html('<strong> Empty Fields! </strong> All fields must be filled in');

         if(ques == "") {
            $('#quest').css('background', '#d9534f');
         }
         if(em == "") {
            $('#em').css('background', '#d9534f');
         }
		}

      else

      if(em.match(emailReg) == null) {
         $('#question_status').addClass('alert-danger').html('<strong> Invalid Email! </strong> Enter a valid email address');
         $('#em').css('background', '#d9534f');
      }

      else

      if(charCount(ques) > 140) {
         $('#question_status').addClass('alert-danger').html('<strong> Too Long! </strong> Question must be 140 characters or less');
         $('#em').css('background', '#d9534f');
      }

		else {

		$.ajax({
			type: 'POST',
			url: 'submit',
			data: { 'question': ques, 'email': em, '_token': token },
         dataType: 'json',
			cache: false,
			success: function(response){
				if(response.success) {
               //$('#question_status').removeClass(statusClass);
               $('#question_status').addClass('alert-success').html('<strong>' + response.success + '</strong> A bored guy will get back to you soon');
            }
            else
            if(response.failure) {
               //$('#question_status').removeClass(statusClass);
               $('#question_status').addClass('alert-danger').html('<strong> Error! </strong>' + response.failure);
            }
			},
			error: function(response) {
            //$('#question_status').removeClass(statusClass);
            $('#question_status').addClass('alert-danger').html('<strong>' + response.statusText + '!</strong> Try again in 60 seconds');
				console.log(response);
			}
		});
		}
	}
  });
});
