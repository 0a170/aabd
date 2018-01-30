$(document).ready(function() {

	$.ajaxSetup({
   	headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    	}
	});

	//	LIKE OR DISLIKE BUTTON CLICKED
	$('.voteButtonClass').on('click', function(e) {

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

		var upVoteButtonId = $("#" + theFormID + " :eq(12)").attr('id');
		var downVoteButtonId = $("#" + theFormID + " :eq(14)").attr('id');

		var failureID = $('#' + theFormID + ' div:last-child').attr('id');
		//var failureID = $('#' + theFormID + ' :last').attr('id');

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
					data = JSON.parse(data);

					if(data.alreadyLiked) {
						$('#' + failureID).html(data.alreadyLiked);
						$('#' + failureID).css('color', 'red');
						$('#' + failureID).css('visibility', 'visible');
						$('#' + downVoteButtonId).css({'color': 'black', 'background': 'white'});
					}
					else
					//if (data.changedUp && data.changedDown) {
					if(data.changedToUp) {
						$('#' + failureID).css('visibility', 'hidden');

						$(btn).css({'color': 'white', 'background': '#5cb85c'});
						$(span).text(" " + data.changedToUp.changedUp);

						$("#" + downVoteButtonId).css({'color': 'black', 'background': 'white'});
						$("#" + downVoteButtonId + " :first-child").text(" " + data.changedToUp.changedDown);
					}
					else
					if(data.newVote) {
						//data = JSON.parse(data);
						$(btn).css({'color': 'white', 'background': '#5cb85c'});
					   $(span).text(" " + data.newVote);
					}
				},
				error: function(data) {
					$('#' + failureID).text(data);
				}

			});

		}

		//ELSE CLICKED ON VOTE DOWN
		else {

			$.ajax({

				type: "POST",
				url: 'dislike',
				data: {'UIDName': User_ID, 'answerScoreName': Answer_Score,
						 'downVoteValName': downVal, 'answeredQuestionName': Answer_Question,
						 'AIDName': Answer_ID, '_token': token },
				dataType: "text",
				cache: false,

				success: function(data) {
					data = JSON.parse(data);

			   	if(data.alreadyDisliked) {
						$('#' + failureID).html(data.alreadyDisliked);
						$('#' + failureID).css('color', 'red');
						$('#' + failureID).css('visibility', 'visible');
					}
					else
					if(data.changedToDown) {
						$('#' + failureID).css('visibility', 'hidden');

						$(btn).css({'color': 'white', 'background': '#d9534f'});
						$(span).text(" " + data.changedToDown.changedDown);

						//alert($("#" + theFormID + " :eq(13):nth-child(1)").attr('id'));
						$("#" + upVoteButtonId).css({'color': 'black', 'background': 'white'});
						$("#" + upVoteButtonId + " :first-child").text(" " + data.changedToDown.changedUp);
					}
					else
					if(data.newDislike) {
						$(btn).css({'color': 'white', 'background': '#d9534f'});
						$(span).text(" " + data.newDislike);
		         }

				}

			});


		}


	});


});
