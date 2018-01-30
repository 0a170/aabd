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

		var ansVal = $('#' + fID + ' :nth-child(1)').val();
		//var ansID = $('#' + fID + ' :nth-child(1)').attr('id');
	//	var ansVal = $('#' + ansID).val();
		var questID = $('#' + fID + ' :hidden:eq(0)').attr('id');
		var questVal = $('#' + questID).val();
		var emailID = $('#' + fID + ' :hidden:eq(1)').attr('id');
		var emailVal = $('#' + emailID).val();

		var ansStatus = $('#' + fID + ' :nth-child(8)').attr('id');

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
					//data = JSON.parse(data);

					$('#' + ansStatus).text(data.successfulAnswer);
					$('#' + ansStatus).css('color', 'green');
					$('#' + ansStatus).css('visibility', 'visible');

					$('#' + dID).closest('div').fadeTo(500,0).animate({width: '0px'}, 500, function(){
        				$('#' + dID).remove();
    				});

				},
				error: function(data) {

					//var dataJSObject = JSON.parse(JSON.stringify(data));

					$('#' + ansStatus).html(dataJSObject.responseText);
					$('#' + ansStatus).css('color', 'red');

					$('#' + ansStatus).css('visibility', 'visible');
					$('#' + ansStatus).fadeTo(3000, 0);

				}

			});

		}

	});

});
