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

function del_some() {
	var order_id = new Array();
	var objTable=document.getElementById("order_list");
    if(objTable)
    {
       for(var i=1;i<objTable.rows.length;i++)
       {
    	   order_id[i-1] = objTable.rows[i].cells[0].innerText;
       }
    }
    var get = {
			'order_id'	: order_id,
    	};
	$.getJSON('/admin/order/del_some', get, function(data) {
		if(data.result == true) {
			window.location.reload();
		}
	});
}

function printme() {
	document.body.innerHTML=document.getElementById('print').innerHTML;
	window.print();
}


function pagesetup_null(){
	var hkey_root,hkey_path,hkey_key
	hkey_root="HKEY_CURRENT_USER"
	hkey_path="\\Software\\Microsoft\\Internet Explorer\\PageSetup\\"
	//设置网页打印的页眉页脚为空
	try{
	var RegWsh = new ActiveXObject("WScript.Shell")
	hkey_key="header" 
	RegWsh.RegWrite(hkey_root+hkey_path+hkey_key,"")
	hkey_key="footer"
	RegWsh.RegWrite(hkey_root+hkey_path+hkey_key,"")
	}catch(e){}
}

function doPrint() { 
	bdhtml=window.document.body.innerHTML; 
	sprnstr="<!--startprint-->"; //开始打印标识字符串有17个字符
	eprnstr="<!--endprint-->"; //结束打印标识字符串
	prnhtml=bdhtml.substr(bdhtml.indexOf(sprnstr)+17); //从开始打印标识之后的内容
	prnhtml=prnhtml.substring(0,prnhtml.indexOf(eprnstr)); //截取开始标识和结束标识之间的内容
	window.document.body.innerHTML=prnhtml; //把需要打印的指定内容赋给body.innerHTML
	pagesetup_null();
	window.print(); //调用浏览器的打印功能打印指定区域
	window.document.body.innerHTML=bdhtml; // 最后还原页面
}