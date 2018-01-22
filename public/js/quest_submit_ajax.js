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

      $('#em').click(function() {
         $('#em').css('background', 'white');
      });

      $('#quest').click(function() {
         $('#quest').css('background', 'white');
      });

		if(ques == "" || em == "") {
         $('#question_status').css('opacity', '1');
         $('#question_status').css('background', '#d9534f').html('All fields must be filled in');

         if(ques == "") {
            $('#quest').css('background', '#d9534f');
         }
         if(em == "") {
            $('#em').css('background', '#d9534f');
         }

		}

      else

      if(em.match(emailReg) == null) {
         $('#question_status').css('opacity', '1');
         $('#question_status').css('background', '#ff6666').html("Invalid Email Address");
         $('#em').css('background', '#d9534f');
      }

      else

      if(charCount(ques) > 140) {
         $('#question_status').css('opacity', '1');
         $('#question_status').css('background', '#ff6666').html("Question must be 140 characters or less");
         $('#em').css('background', '#d9534f');
      }

		else {

		$.ajax({

			type: 'POST',
			url: 'submit',
			data: { 'question': ques, 'email': em, '_token': token },
			cache: false,
			success: function(response){

				if(response.success) {
               $('#question_status').css('opacity', '1');
				   $('#question_status').css('background', '#5cb85c').html(response.success);
               $('#question_status').fadeTo(4000, 0);
            }
            else
            if(response.failure) {
               $('#question_status').css('opacity', '1');
               $('#question_status').css('background', '#d9534f').html(response.failure);
               $('#question_status').fadeTo(4000, 0);
            }

			},
			error: function(response) {

            $('#question_status').css('opacity', '1');
            $('#question_status').css('background', '#d9534f').html(response);
            $('#question_status').fadeTo(4000, 0);
				/*setTimeout(function() {
					$('#question_status').fadeOut('slow');
				}, 3000);*/
				console.log(response);

			}

		});
		}

	}
  });





});
