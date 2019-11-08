$(".addOption").click(function(){
	$(".addChoice").change(function(){
		var optionCount = Number($(this).attr("id"));
		var num = Number($(this).val());
		if(num == NaN || num < 1 ){//||  ){
			$(this).val(1);
			num = 1;
		} else if(num > 9){
		$(this).val(9);
			num = 9;
		}
		//$(this).attr("id")
		for( i = 1; i < num + 1 && 10; i++){
			$("#choiceFieldOption"+optionCount+"_"+i).show();
		}
		for( i = num + 1; i < 10; i++){
			$("#choiceFieldOption"+optionCount+"_"+i).hide();
		}

})
});
