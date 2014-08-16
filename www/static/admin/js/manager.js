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

function printme() {
	document.body.innerHTML=document.getElementById('print').innerHTML;
	window.print();
}

function doPrint() { 
	bdhtml=window.document.body.innerHTML; 
	sprnstr="<!--startprint-->"; //开始打印标识字符串有17个字符
	eprnstr="<!--endprint-->"; //结束打印标识字符串
	prnhtml=bdhtml.substr(bdhtml.indexOf(sprnstr)+17); //从开始打印标识之后的内容
	prnhtml=prnhtml.substring(0,prnhtml.indexOf(eprnstr)); //截取开始标识和结束标识之间的内容
	window.document.body.innerHTML=prnhtml; //把需要打印的指定内容赋给body.innerHTML
	window.print(); //调用浏览器的打印功能打印指定区域
	window.document.body.innerHTML=bdhtml; // 最后还原页面
}