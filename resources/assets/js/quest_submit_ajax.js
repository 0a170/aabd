$(document).ready(function() {


  $.ajaxSetup({ 
  		//headers: { 'csrftoken' : '{{ csrf_token() }}' }
  		headers: { 
  		
  					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  		
  		}
  		
  });

  var form = $("#frmDemo");
	
	
	var frmToken = form.attr("data-link");
	
  $("#frmDemo").steps({
	  
	headerTag: "h3",
    bodyTag: "section",
    transitionEffect: "slideLeft",
    autoFocus: true,  
	
	/*onStepChanging: function(event, currentIndex, newIndex) 
	{
		return form.valid();
	},
	onFinishing: function(event, currentIndex) 
	{
		
		return form.valid();
		
	}, */
	onFinished: function(event, currentIndex)
	{
		//alert("here");
		var ques = $("#quest").val();
		var em = $("#em").val();
		
		if(ques == "" || ques == "Question" || em == "" || em == "Email Address") {
			
			$('#error_message').fadeIn().html("Question and Email fields must be filled in");	
			
		}
		
		else {
		
		$.ajax({
		
		//$.ajax({
		 //  headers: { 'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content') }, 
			type: "POST",
			//url: "askques-script.php",
			url: "submit",
			//data: "question="+ques+"&email="+em "&to,
			//data: { 'question': ques, 'email': em, '_token': '{{ csrf_token() }}' }, 
			data: { 'question': ques, 'email': em, '_token': $('input[name=_token]').val() }, 
			datatype: 'json',
			success: function(data){
				//alert("success");
				//data = json_decode(data); 
				//alert(data);
				console.log(data);
				$('#success_message').fadeIn().html("Blah");
				setTimeout(function() {
					$('#success_message').fadeOut("slow");
				}, 3000 );

			},
			error: function(data) {
				
				//alert("failure");
				$('#error_message').fadeIn().html("Unable to submit question, try again later");
				setTimeout(function() {
					$('#error_message').fadeOut('slow');
				}, 3000);
				console.log(data);
				
			}
			
		});
		}
		
	}
  });
  
	
 /* $("#subm").click(function() {
	
	//e.preventDefault();
	
	var ques = $("#quest").val();
	var em = $("#em").val();
	
	if(ques == "" || em == "" ) {
		$("#error_message").show().html("All Fields are Required");
	} else {
		$("#error_message").html("").hide();
		$.ajax({
			type: "POST",
			url: "askques-script.php",
			data: "question="+ques+"&email="+em,
			success: function(data){
				$('#success_message').fadeIn().html("Question submitted, we'll get back to you by email soon");
				setTimeout(function() {
					$('#success_message').fadeOut("slow");
				}, 2000 );

			}
		});
	}
	
  }); */
  
  

});