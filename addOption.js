//$(document).ready(function(){
	$(".addOption").click(function(){
		var optionCount = Number($(".addOption").attr("id"));
		$(".delOption").prop('disabled', false);
		if(optionCount < 10){
			var optionCount = Number($(".addOption").attr("id"));
			
			var optionHtmlAppend = "Option Name:<br>" +
				"<input type=\"text\" name=\"optionName"+optionCount+"\"><br>" +
				"Selection Type:<br>" +
				"<select name=\"selectionType"+optionCount+"\" id=\"type_selector\">" +
					"<option value=\"radio\">Multiple Choice</option>" +
					"<option value=\"checkbox\">Checkbox</option>" +
				"</select><br>" +
				"Number of Choices (Between 1 and 9): <br>" +
				"<input type=\"number\" class=\"addChoice\" id=\""+optionCount+"\" step=\"1\" value=\"1\" name=\"numChoices"+optionCount+"\"><br>" +
				"<div id=\"choiceFieldOption"+optionCount+"_1\">Choice: <input type=\"text\" class=\"choiceFieldOption"+optionCount+"\"  name=\"choiceFieldOption"+optionCount+"_1\" ><br></div>" +
				"<div id=\"choiceFieldOption"+optionCount+"_2\"style=\"display: none;\">Choice: <input type=\"text\" class=\"choiceFieldOption"+optionCount+"\"  name=\"choiceFieldOption"+optionCount+"_2\"><br></div>" +
				"<div id=\"choiceFieldOption"+optionCount+"_3\"style=\"display: none;\">Choice: <input type=\"text\" class=\"choiceFieldOption"+optionCount+"\"  name=\"choiceFieldOption"+optionCount+"_3\"><br></div>" +
				"<div id=\"choiceFieldOption"+optionCount+"_4\"style=\"display: none;\">Choice: <input type=\"text\" class=\"choiceFieldOption"+optionCount+"\"  name=\"choiceFieldOption"+optionCount+"_4\"><br></div>" +
				"<div id=\"choiceFieldOption"+optionCount+"_5\"style=\"display: none;\">Choice: <input type=\"text\" class=\"choiceFieldOption"+optionCount+"\"  name=\"choiceFieldOption"+optionCount+"_5\"><br></div>" +
				"<div id=\"choiceFieldOption"+optionCount+"_6\"style=\"display: none;\">Choice: <input type=\"text\" class=\"choiceFieldOption"+optionCount+"\"  name=\"choiceFieldOption"+optionCount+"_6\"><br></div>" +
				"<div id=\"choiceFieldOption"+optionCount+"_7\"style=\"display: none;\">Choice: <input type=\"text\" class=\"choiceFieldOption"+optionCount+"\"  name=\"choiceFieldOption"+optionCount+"_7\"><br></div>" +
				"<div id=\"choiceFieldOption"+optionCount+"_8\"style=\"display: none;\">Choice: <input type=\"text\" class=\"choiceFieldOption"+optionCount+"\"  name=\"choiceFieldOption"+optionCount+"_8\"><br></div>" +
				"<div id=\"choiceFieldOption"+optionCount+"_9\"style=\"display: none;\">Choice: <input type=\"text\" class=\"choiceFieldOption"+optionCount+"\"  name=\"choiceFieldOption"+optionCount+"_9\"><br></div>" ;
				
			var optionHtmlAfter = "</div>" +
				"<div id=\"option"+(optionCount+1)+"\"></div>";
			$("#option" + optionCount).append(optionHtmlAppend);
			$("#option" + (optionCount).toString()).after(optionHtmlAfter);
			$(".addOption").attr("id", (optionCount+1).toString());
		}
		if(optionCount > 8){
			$(".addOption").prop('disabled', true);
		}
	});

	$(".delOption").click(function(){
		var optionCount = Number($(".addOption").attr("id"));
		if (optionCount < 11){
			$(".addOption").prop('disabled', false);
		}
		if(optionCount > 1){
			$("#option" + optionCount).remove();
			$("#option" + (optionCount-1).toString()).empty();
			$(".addOption").attr("id", (optionCount-1).toString());		
		}
		if(optionCount < 3){
			$(".delOption").prop('disabled', true);
		}
	});
//});
