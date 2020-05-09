$(document).ready(function(){
    
    $("#state").ready(function(){
		var url = "findlga";
		$.post(url, 
			{
				state: $("#state").val()
			}, function(data){
			$("#lga").html(data);
		});
	});
    
	$("#state").change(function(){
		var url = "findlga";
		$.post(url, 
			{
				state: $("#state").val()
			}, function(data){
			$("#lga").html(data);
		});
	});
});
