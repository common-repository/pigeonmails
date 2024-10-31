	$("#userform").submit(function(e){
		e.preventDefault();
		if($("#username").val() == ""){
			alert("username is required");
			return false;
		}
		
		if($("#password").val() == ""){
			alert("password is required");
			return false;
		}
		
		if($("#fromname").val() == ""){
			alert("fromname is required");
			return false;
		}
		
		if($("#fromemail").val() == ""){
			alert("fromemail is required");
			return false;
		}
		$("#message").replaceWith("<p id='message'>We are authenticating your details</p>");
		var data = "";
		data+="userid="+$("#userid").val()+"&";
		data+="username="+$("#username").val()+"&";
		data+="password="+$("#password").val()+"&";
		data+="fromname="+$("#fromname").val()+"&";
		data+="_wpnonce="+$("input[name=_wpnonce]").val()+"&";
		data+="fromemail="+$("#fromemail").val();
		
		
		var post_data = "action=authenticate_pigeonmails&"+data;
		$.post(ajaxurl,post_data,function(data){
			var data = JSON.parse(data);
			$("#message").replaceWith("<p id='message'>"+data.message+"</p>");
		});		
	});
	
	$(document).ready(function() { 
		data="data=data&";
		data+="_wpnonce="+$("input[name=_wpnonce]").val()+"&";
		if($("#fetchanalytics").length){
			data+="username="+$("#username").val()+"&";
			data+="password="+$("#password").val();
			getanalytics(data);	
		}
		
		if($("#fetchdata").length){
			getdata(data);					
		}
		
		
	});

	function getdata(data){
		var element = '<tbody id="fetchdata"><tr><td colspan="7"> Please Wait........</td></tr></tbody>';
		$("#fetchdata").replaceWith(element);
		var post_data = "action=inbox_pigeonmails&"+data;
		$.post(ajaxurl,post_data,function(data){
			console.log(data);
			var data = JSON.parse(data);
			$("#fetchdata").replaceWith(data.element);
			data.prev = $("#prev").val(data.prev);
			data.next = $("#next").val(data.next);
			data.page = $("#page").val(data.page);
			data.rowlist = $("#rowlist").val(data.limit);
		});
	}
	
	function getanalytics(data){
		
		var element = '<tbody id="fetchanalytics"><tr><td colspan="8"> Please Wait........</td></tr></tbody>';
		$("#fetchanalytics").replaceWith(element);
		
		var post_data = "action=analytics_pigeonmails&data="+data;
		$.post(ajaxurl,post_data,function(data){
			var data = JSON.parse(data);
			$("#fetchanalytics").replaceWith(data.element);
			data.prev = $("#prev").val(data.prev);
			data.next = $("#next").val(data.next);
			data.page = $("#page").val(data.page);
			data.rowlist = $("#rowlist").val(data.limit);
			
		});
	}
	
	function prevPegination(){
		var previous = $("#prev").val();
		if(previous == 0){
			$("#page").val(previous);
		}else{
			$("#page").val(parseInt(previous));
		}
		var data = "";
		data+="prev="+$("#prev").val()+"&";
		data+="next="+$("#next").val()+"&";
		data+="_wpnonce="+$("input[name=_wpnonce]").val()+"&";	
		data+="page="+$("#page").val()+"&";

		if($("#fetchanalytics").length){
			data+="rowlist="+$("#rowlist").val()+"&";
			data+="username="+$('#username').val()+"&";
			data+="password="+$("#password").val();
			getanalytics(data);	
		}
		
		if($("#fetchdata").length){
			data+="rowlist="+$("#rowlist").val();
			getdata(data);					
		}
	}
	
	function nextPegination(){
		var next = $("#next").val();		
		$("#page").val(parseInt(next)+1);
		var data = "";
		data+="prev="+$("#prev").val()+"&";
		data+="next="+$("#next").val()+"&";
		data+="_wpnonce="+$("input[name=_wpnonce]").val()+"&";	
		data+="page="+$("#page").val()+"&";

		if($("#fetchanalytics").length){
			data+="rowlist="+$("#rowlist").val()+"&";
			data+="username="+$('#username').val()+"&";
			data+="password="+$("#password").val();
			getanalytics(data);	
		}
		
		if($("#fetchdata").length){
			data+="rowlist="+$("#rowlist").val();
			getdata(data);					
		}
	}
	
	$(document).ready(function(){
		
		$('#rowlist').change(function(){          
			var data = "";
			data+="prev="+$("#prev").val()+"&";
			data+="next="+$("#next").val()+"&";
			data+="page="+$("#page").val()+"&";
			data+="_wpnonce="+$("input[name=_wpnonce]").val()+"&";
	
			if($("#fetchanalytics").length){
				data+="rowlist="+$("#rowlist").val()+"&";
				data+="username="+$('#username').val()+"&";
				data+="password="+$("#password").val();
				getanalytics(data);	
			}
			
			if($("#fetchdata").length){
				data+="rowlist="+$("#rowlist").val();
				getdata(data);					
			}
		})
	});