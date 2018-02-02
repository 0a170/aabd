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

	var comment = $("#nD").val();

	$("#editDescModal").on("hide.bs.modal", function() {
		$("#editDescStatus").css({'color': 'red', 'visibility': 'hidden'});
	});

	//$("#upd_desc").on('submit', function(e) {
	$("#upDescButton").on('click', function(e) {
		e.preventDefault();
		var comment = $("#nD").val();

		if(comment == "") {
			$("#editDescStatus").html("Description cannot Be Empty");
			$("#editDescStatus").css({'color': 'red', 'visibility': 'visible'});
		}
		else
		if(comment.length > 300) {
			$("#editDescStatus").html("Description Must Be Less Than 300 Characters");
			$("#editDescStatus").css({'color': 'red', 'visibility': 'visible'});
		}
		else {
			$("#upd_desc").submit();
		}
	});


	$('.aForm').on('submit', function(e) {

		e.preventDefault();
		var theForm = $(this);

		var fID = theForm.attr('id');
		var dID = $('#' + fID).parent().attr('id');

		var ansVal = $('#' + fID + ' :nth-child(1)').val();
	   var questID = $('#' + fID + ' :hidden:eq(0)').attr('id');
		var questVal = $('#' + questID).val();
		var primaryQuesKey = $('#' + fID + ' :hidden:eq(1)').val();

		var ansStatus = $('#' + fID + ' :nth-child(8)').attr('id');

		var statusID = $('#' + dID).nextAll().eq(0).attr('id');
		var token = $('#' + fID + ' :hidden:eq(2)').attr('id');

		if(ansVal == '') {
			$('#' + ansStatus).html('Answer Cannot Be Empty');
			$('#' + ansStatus).css('color', 'red');
			$('#' + ansStatus).css('visibility', 'visible');
		}
		else
		if(charCount(ansVal) > 150) {
			$('#' + ansStatus).html('150 characters or less, buddy');
			$('#' + ansStatus).css('color', 'red');
			$('#' + ansStatus).css('visibility', 'visible');
		}
		else {

			$.ajax({

				type: "POST",
				url: "answer",
				data: {'quesId': primaryQuesKey, 'answerInput': ansVal, 'ques': questVal, '_token': token},
				datatype: "json",
				cache: false,

				success: function(data) {
					$('#' + ansStatus).text(data.successfulAnswer);
					$('#' + ansStatus).css('color', 'green');
					$('#' + ansStatus).css('visibility', 'visible');

					$('#' + dID).closest('div').fadeTo(500,0).animate({width: '0px'}, 500, function(){
        				$('#' + dID).remove();
    				});
				},
				error: function(data) {
					$('#' + ansStatus).html(dataJSObject.responseText);
					$('#' + ansStatus).css('color', 'red');

					$('#' + ansStatus).css('visibility', 'visible');
					$('#' + ansStatus).fadeTo(3000, 0);
				}

			});

		}

	});

});
