// JavaScript Document
$(document).ready(function() {
	item_display();
	user();
	
});

function item_display(){
	$(".item").hover(
		function(){
			$(this).addClass('menuitem_hover');
			$(".menuitem",$(this)).css('display','block');
		},
		function(){
			$(".menuitem",$(this)).css('display','none');
			$(this).removeClass('menuitem_hover');
		}
	);
}

function user(){
	$(".pic").hover(
		function(){
			$(".user").css('display','block');
		},
		function(){
			$(".user").css('display','none');
		}
	);
}

function del_alert() {
    return confirm('删除操作不可恢复，确认删除吗？');
}