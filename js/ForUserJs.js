function readURL(input)
{
	if(input.files && input.files[0])
	{
		//var input_img_id = input.querySelector("#get_image");
		var reader = new FileReader();
		reader.onload = function(e){pred_img(e)}
		reader.readAsDataURL(input.files[0]);
		chang_size(input.files[0]);

	}
}

function pred_img(e)
{
	//console.log(e);
	var img = document.querySelector("#show_img");
	img.setAttribute("src", e.target.result);
}

function chang_size(img)
{
	var img_div = document.querySelector("#show_img");
	var img_h = img.offsetHeight;
	var img_w = img.offsetWidth;

	if(img_w > img_h)
	{
		img_div.setAttribute("style","width:100%");
	}
	else
	{
		img_div.setAttribute("style","height:100%");
	}
}
function check_login()
{
	return(true);
}

function open_print()
{
	$("#print_val").show();
	$(".chose_button").animate({
		width:"100px",
		height:"100px"
	},10);
}

function closs_print()
{
	$("#print_val").hide();
	$(".chose_button").animate({
		width:"400px",
		height:"400px"
	},10);
}


function show_form_val()
{
	const form_block = $("#show_form");
	
	if(form_block.hasClass("is_show"))
	{
		form_block.hide();
		form_block.removeClass("is_show");
		closs_print();
		return;
	}
	else
	{
		$(".print_val").hide();
		$(".print_val").removeClass("is_show");
		open_print();
		form_block.show();
		form_block.addClass("is_show");
	}
}

function show_corekustion_val()
{
	const corekusion_block = $("#show_corekustion")
	
	if(corekusion_block.hasClass("is_show"))
	{
		corekusion_block.hide();
		corekusion_block.removeClass("is_show");
		closs_print();
		return;
	}
	else
	{
		$(".print_val").hide();
		$(".print_val").removeClass("is_show");
		open_print();
		corekusion_block.show();
		corekusion_block.addClass("is_show");
	}
}

function to_dict(input)
{
	const jsondata = JSON.parse(input);
	return(jsondata);
}

function get_data()
{
	$.ajax({
		url:'php_func/myfunc.php',
		data:{
			action:'test_func',
			val_a:'asd',
			val_b:123
		},
		type:'post',
		success:function(output){
			const mydata = to_dict(output);
			alert(mydata['output_b']); 
		},
		error: function(jqXHR){ alert(jqXHR); }
	});
}



