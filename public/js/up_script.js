	$(document).ready(function() {
		
		//e.preventDefault(); 
		
		$("#upl_img").submit(function() {
			
			//e.preventDefault(); 
			var formData = new FormData(this);
			
			$.ajax({
				
				type: "POST",
				url: "img_update.php",
				data: formData,
				enctype: 'multipart/form-data',
				contentType: false, 
				cache: false,
				processData: false,
				success: function(data) {
					
					//alert("Supposedly successful.");
					$("#msg").html("Image successfully updated");
				//window.location.reload(true);
				//	setTimeout(function() {
					location.reload(); 
					//$("#popUpDesc").popup("close");
					
					//window.location.href = 'answer-mobile.php';
					
					//location.href = location.href;
						//parent.window.location.reload(true); 
						//location.reload();
						//window.opener.location.reload();
						//window.close();
						
					//}, 2000); 
					
				},
				
				error: function(error) {
					
					alert("Server error.");
					$("#msg").html(eval(error));
					
				} 
				
			});
			
			return false;
			
		});
		
		$("#upd_desc").submit(function() {
			
			//var formData2 = new FormData(this);
			var newDescription = $('#nD').val();
			
			$.ajax({
				
				type: "POST",
				url: "desc_update.php",
				//data: formData2,
				data: {'newDesc': newDescription},
				cache: false,
				//processData: false,
				
				success: function(data) {
					
					$("#msg2").html("Successfully updated"); 
					
					//window.location.reload(); 
					location.reload();
					
				},
				
				error: function(error2) {
					
					alert("Server Error 2");
					$("msg2").html(eval(error2));
					
				}
				
			});
			
			return false;
			
		});
		
		
		
	});