$(document).ready(function() {


  $.ajaxSetup({
  		//headers: { 'csrftoken' : '{{ csrf_token() }}' }
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

	/*onStepChanging: function(event, currentIndex, newIndex)
	{
		if(currentIndex > 0) {

			$('.actions > ul > li:first-child').attr('style', 'display:none');

		}
		//return form.valid();
	}, */
	/*
	onFinishing: function(event, currentIndex)
	{

		return form.valid();

	}, */
	onFinished: function(event, currentIndex)
	{
		//alert("here");
		var ques = $("#quest").val();
		var em = $("#em").val();
		var token = $(":hidden").val();
		var tokenClass = $("#frmDemo:hidden").attr('class');

		if(ques == "" || ques == "Question" || em == "" || em == "Email Address") {

			$('#error_message').fadeIn().html("Question and Email fields must be filled in");
         setTimeout(function() {
            $('#error_message').fadeOut('slow');
         }, 3000);

		}
      else if(!emailReg(em)) {

         $('#error_message').fadeIn().html("Invalid Email Address");
         setTimeout(function() {
            $('#error_message').fadeOut('slow');
         }, 3000);

      }


		else {

		$.ajax({

		//$.ajax({
		 //  headers: { 'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content') },
			type: 'POST',
			//url: "askques-script.php",
			url: 'submit',
			//data: "question="+ques+"&email="+em "&to,
			data: { 'question': ques, 'email': em, '_token': token },
			//data: { 'question': ques, 'email': em, '_token': $('input[name=_token]').val() },
			//dataType: 'text',
			cache: false,
			success: function(data){
				//alert("success");
				//data = json_decode(data);
				//alert(data);
				console.log(data);
				$('#success_message').fadeIn().html(data);
				setTimeout(function() {
					$('#success_message').fadeOut("slow");
				}, 3000 );

			},
			error: function(data) {

				//alert("failure");
				$('#error_message').fadeIn().html(tokenClass + ": not working");
				setTimeout(function() {
					$('#error_message').fadeOut('slow');
				}, 3000);
				console.log(data);

			}

		});
		}

	}
  });





});
