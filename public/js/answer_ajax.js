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

		e.preventDefault();
		var theForm = $(this);

		var fID = theForm.attr('id');
		var dID = $('#' + fID).parent().attr('id');

		var ansID = $('#' + fID + ' :nth-child(1)').attr('id');
		var ansVal = $('#' + ansID).val();
		var questID = $('#' + fID + ' :hidden:eq(0)').attr('id');
		var questVal = $('#' + questID).val();
		var emailID = $('#' + fID + ' :hidden:eq(1)').attr('id');
		var emailVal = $('#' + emailID).val();

		var ansStatus = $('#' + fID + ' :nth-child(7)').attr('id');

		var statusID = $('#' + dID).nextAll().eq(0).attr('id');
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

					$('#' + dID).closest('div').fadeTo(500,0).animate({width: '0px'}, 500, function(){
        				$('#' + dID).remove();
    				});
					//$('#' + ansStatus).css('visibility', 'visible');

					//$('#' + dID).toggle('slide', {direction: 'right'}, 1000);


					/*$('#' + dID).fadeOut(3000, function() {
						$('#' + dID).remove();
					});*/

				},
				error: function(data) {

					$('#' + servFailureID).show().html("Server Issue: " + data + " try again later");
					//setTimeout(function() {
					$('#' + servFailureID).fadeOut(3000, function() {
						$('#' + servFailureID).remove();
					});

				}

			});


		}

	});


});
