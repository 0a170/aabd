$(document).ready(function() {

	$.ajaxSetup({
   	headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    	}
	});

	$('Button').on('click', function(e) {

		e.preventDefault();

		var btn = $(this);
		var btnVal = $(this).val();
		var theForm = btn.parent();
		var theFormClass = theForm.attr('class');
		var theFormID = theForm.attr('id');

		var User_ID = $('#' + theFormID + ' :hidden:eq(0)').val();
		var Answer_Score = $('#' + theFormID + ' :hidden:eq(1)').val();
		var Answer_Question = $('#' + theFormID + ' :hidden:eq(2)').val();
		var upVal = $('#' + theFormID + ' :hidden:eq(3)').val();
		var downVal = $('#' + theFormID + ' :hidden:eq(4)').val();
		var Answer_ID = $('#' + theFormID + ' :hidden:eq(5)').val();
		var token = $('#' + theFormID + ' :hidden:eq(6)').val();

		var span = $(':first-child', this);

		var failureID = $('#' + theFormID).last().attr('id');
		//var failureID = $('#' + theFormID + ' :last-child').attr('id');

		if(btnVal == "upButtonVal") {



			$.ajax({

				type: 'POST',
				url: 'like',
				data: { 'UIDName': User_ID, 'answerScoreName': Answer_Score,
				        'upVoteName': upVal, 'answeredQuestionName': Answer_Question,
				        'AIDName': Answer_ID, '_token': token },
				dataType: "text",
				cache: false,

				success: function(data) {

					if(data == "Already voted") {

						//$('#' + failureID).show();
						$('#' + failureID).text(data);

					}
					else if(data != "Already voted") {

						data = JSON.parse(data);
					   $(span).text(" " + data.up_votes);
						//$(span).text(" " + data);

					}

				},
				error: function(data) {

					$('#' + failureID).text(data);

				}

			});

		}

		else

		if(btnVal == "downButtonVal") {

			$.ajax({

				type: "POST",
				url: 'dislike',
				data: {'UIDName': User_ID, 'answerScoreName': Answer_Score,
						 'downVoteValName': downVal, 'answeredQuestionName': Answer_Question,
						 'AIDName': Answer_ID, '_token': token },
				dataType: "text",
				cache: false,

				success: function(data) {

			   	if(data == "Already voted") {

						//$('#' + failureID).show();
						$('#' + failureID).text(data);

					}

					else {

						data = JSON.parse(data);
						$(span).text(" " + data.down_votes);
						//$(span).text(" " + data);

		         }

				}

			});


		}


	});


});
