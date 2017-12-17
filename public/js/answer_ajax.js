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

	$('.aForm').on('submit', function(e) {


		//alert("clicked");
		//e1.stopPropagation();
		e.preventDefault();
		var theForm = $(this);
		//alert(theForm);


		var fID = theForm.attr('id');
		var dID = $('#' + fID).parent().attr('id');
		//alert(fID);

	   //alert("The form ID: " + fID);

		//var ansID = $('#' + fID + ' textarea').attr('id');
		var ansID = $('#' + fID + ' :nth-child(1)').attr('id');
		var ansVal = $('#' + ansID).val();
		var questID = $('#' + fID + ' :hidden:eq(0)').attr('id');
		var questVal = $('#' + questID).val();
		var emailID = $('#' + fID + ' :hidden:eq(1)').attr('id');
		var emailVal = $('#' + emailID).val();
		//var userID = $('#' + fID + ' :hidden:eq(2)').attr('id');

		var ansStatus = $('#' + fID + ' :nth-child(7)').attr('id');


		//var failureID = $('#' + fID + ' :nth-child(8)').attr('id');
		//var failureID = $('#' + dID + ' :nth-child(3)').attr('id');
		var statusID = $('#' + dID).nextAll().eq(0).attr('id');
		//var successID = $('#' + fID + ' :nth-child(9)').attr('id');
		//var successID = $('#' + dID + ' :nth-child(4)').attr('id');
		//var servFailureID = $('#' + fID + ' :nth-child(10)').attr('id');
      //var servFailureID = $('#' + dID + ' :nth-child(5)').attr('id');

		//var token = $('#' + fID + ' :nth-child(4)').attr('id');
		var token = $('#' + fID + ' :hidden:eq(2)').attr('id');

		if(ansVal == '') {

			$('#' + ansStatus).html('Answer Cannot Be Empty');
			$('#' + ansStatus).css('color', 'red');

			$('#' + ansStatus).css('visibility', 'visible');

		} else if(charCount(ansVal) > 150) {

			$('#' + ansStatus).html('150 characters or less, buddy');
			$('#' + ansStatus).css('color', 'red');

			$('#' + ansStatus).css('visibility', 'visible');

		} else {

			$.ajax({

				type: "POST",
				url: "answer",
				data: {'answerInput': ansVal, 'ques': questVal, 'ema': emailVal, '_token': token},
				//datatype: 'text',
				cache: false,

				success: function(data) {

					//alert(data);

					$('#' + ansStatus).text(data);
					$('#' + ansStatus).css('color', 'green');
					$('#' + ansStatus).css('visibility', 'visible');

					/*$('#' + statusID).html(data);
					$('#' + statusID).css('visibility', 'visible'); */
					//setTimeout(function() {

					$('#' + dID).fadeOut(3000, function() {
						$('#' + dID).remove();
					});

				},
				error: function(data) {

					//alert(ansVal);
					$('#' + servFailureID).show().html("Server Issue: " + data + " try again later");
					//setTimeout(function() {
					$('#' + servFailureID).fadeOut(3000, function() {
						$('#' + servFailureID).remove();
					});

				}

			});

			//return false;
		}

	});


});
