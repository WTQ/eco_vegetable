<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=0">
<meta name="format-detection" content="telephone=no">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="default">

<title>用户端</title>
<script type="text/javascript" charset="utf-8" src="<?php echo base_url('static/newuser/js/appframework.min.js'); ?>"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo base_url('static/newuser/js/appframework.ui.min.js'); ?>"></script>

<script type="text/javascript" charset="utf-8" src="<?php echo base_url('static/newuser/js/plugins/af.touchEvents.js'); ?>"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo base_url('static/newuser/js/plugins/af.touchLayer.js'); ?>"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo base_url('static/newuser/js/plugins/af.css3animate.js'); ?>"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo base_url('static/newuser/js/plugins/af.scroller.js'); ?>"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo base_url('static/newuser/js/plugins/af.slidemenu.js'); ?>"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo base_url('static/newuser/js/plugins/af.selectBox.js'); ?>"></script>
<!--<script type="text/javascript" charset="utf-8" src="<?php echo base_url('static/newuser/js/plugins/af.desktopBrowsers.js'); ?>"></script>-->

<link rel="stylesheet" type="text/css" href="<?php echo base_url('static/newuser/css/af.ui.css'); ?>" title="default" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url('static/newuser/css/icons.css'); ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url('static/newuser/css/user.css'); ?>" />
<script>

$.ui.ready(function() {
	myscroller = $('#body1_image').scroller();
	myscroller.enable();
});	

$.ui.ready(function() {
	var t = $(".number");
	
	$(".increase").click(function(n) {
		n.stopPropagation();
		var i = $(".increase").index($(this));
		$(t[i]).text(parseInt($(t[i]).text()) + 1);
		return false;
	})
	$(".decrease").click(function(n){
		n.stopPropagation();
		var i = $(".decrease").index($(this));
		if ($(t[i]).text() > 1) {
			$(t[i]).text($(t[i]).text() - 1);
			
		}
		return false;
	})
});
$.ui.ready(function() {
	function hide_confirm() {
		$(".order_info").css("display","none");
		$(".cancel").css("display","none");
		$(".confirm_order").removeClass("new_confirm");
	}
	
	$(".confirm_order").click(function() {
		if ($(".confirm_order").hasClass("new_confirm")) {
			hide_confirm();
			$.ui.loadContent('#verify', false, false, 'fade');
		} else {
			$(".order_info").css("display","block");
			$(".cancel").css("display","block");
			$(".confirm_order").addClass("new_confirm");
		}
	});
	
	$(".cancel").click(function() {
		if ($(".confirm_order").hasClass("new_confirm")) {
			hide_confirm();
		}
	});
});

function load_verify() {
	setTimeout(function() {
		$.ui.loadContent('#index', false, false, 'fade');
	}, 2000);
}

function load_cart() {
	
}
$.ui.ready(function() {
	$('form').submit(function() {
		return false;
	});
	
	$(".search2").blur(function(){
		$("#search_content").addClass("search_change");
  
	});
	$(".search2").focus(function(){
		$("#search_content").removeClass("search_change");
  
	});
});


</script>
</head>

<body>
<div id="afui">
	<div id="content">
	
	
    	<!--首页-->
    	<div id="index" title="" class="panel" selected="true" data-footer="common_footer" data-header="none" data-tab="tab_index" scrolling="no">
        	<div class="header_index">
            	<div class="top_bar">
                	<div class="search"><a href="#search_index" data-transition="fade" class="bu_search"></a></div>
                </div>
                <div class="shop_statu">
                	<span class="shop">颐东苑-水果店</span>
                    <div class="open">营业中</div>
                    <span class="time">8:00-20:00</span>
                    <div class="cl"></div>
                </div>
            </div>
            <div id="body1_image">
                <a href="#sort"><div class="body1"><img src="<?php echo base_url('static/newuser/image/body1.png'); ?>"></div></a>
                <a href="#sort"><div class="body1"><img src="<?php echo base_url('static/newuser/image/body2.png'); ?>"></div></a>
                <a href="#sort"><div class="body1"><img src="<?php echo base_url('static/newuser/image/body3.png'); ?>"></div></a>
                <a href="#sort"><div class="body1"><img src="<?php echo base_url('static/newuser/image/body4.png'); ?>"></div></a>
                <a href="#sort"><div class="body2"><img src="<?php echo base_url('static/newuser/image/body5.png'); ?>"></div></a>
                <a href="#sort"><div class="body1"><img src="<?php echo base_url('static/newuser/image/body1.png'); ?>"></div></a>
                <a href="#sort"><div class="body1"><img src="<?php echo base_url('static/newuser/image/body4.png'); ?>"></div></a>
            </div>
        </div>
        
        
        <!--搜索页面-->
        <div id="search_index" title="" class="panel" data-footer="none">
        	<header class="header_search">
            	<div>
                	<form><input type="search" placeholder="搜索" class="search2"></form>
                    <!--<input type="search" placeholder="search" class="">-->
                </div>
                <div><a href="#index" class="cancel_search" data-transition="fade">取消</a></div>
            </header>
            <div id="search_content">
                <div class="hist_list">
                    <ul class="list">
                        <li><a href="#">111111</a></li>
                        <li><a href="#">222222</a></li>
                        <li><a href="#">333333</a></li>
                        <li><a href="#">444444</a></li>
                        <li><a href="#">555555</a></li>
                    </ul>
                </div>
                <div class="search_goods">
                     <a href="#goods_index">
                        <div class="goods">
                            <div class="goods_image"><img src="<?php echo base_url('static/newuser/image/wine.png'); ?>"></div>
                            <div class="goods_detail">
                                <div class="goods_title">爱你中国科罗娜特特特级啤酒330ML（进口）</div>
                                <div class="goods_price">
                                    <div class="price">
                                        <div class="unit_price">单价</div>
                                        <div class="cost">8.5&nbsp;&nbsp;<span>元</span></div>
                                    </div>
                                </div>
                            </div>
                            <div class="add"></div>
                        </div>
                    </a>
                    <a href="#goods_index">
                        <div class="goods">
                            <div class="goods_image"><img src="<?php echo base_url('static/newuser/image/yuanyi.png'); ?>"></div>
                            <div class="goods_detail">
                                <div class="goods_title">玖枝苑 园艺三件套</div>
                                <div class="goods_price">
                                    <div class="price">
                                        <div class="unit_price">单价</div>
                                        <div class="p_before">
                                            <span class="before">10.0</span><span class="zero">0</span>
                                            &nbsp;&nbsp;<span class="now_price">8.5</span>&nbsp;&nbsp;<span class="unit">元</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="add"></div>
                        </div>
                    </a>
                    <a href="#goods_index">
                        <div class="goods">
                            <div class="goods_image"><img src="<?php echo base_url('static/newuser/image/wine.png'); ?>"></div>
                            <div class="goods_detail">
                                <div class="goods_title">爱你中国科罗娜特特特级啤酒330ML（进口）</div>
                                <div class="goods_price">
                                    <div class="price">
                                        <div class="unit_price">单价</div>
                                        <div class="cost">8.5&nbsp;&nbsp;<span>元</span></div>
                                    </div>
                                </div>
                            </div>
                            <div class="add"></div>
                        </div>
                    </a>
                    <a href="#goods_index">
                        <div class="goods">
                            <div class="goods_image"><img src="<?php echo base_url('static/newuser/image/yuanyi.png'); ?>"></div>
                            <div class="goods_detail">
                                <div class="goods_title">玖枝苑 园艺三件套</div>
                                <div class="goods_price">
                                    <div class="price">
                                        <div class="unit_price">单价</div>
                                        <div class="before_price">
                                            <span class="before">10.0</span><span class="zero">0</span>
                                            &nbsp;&nbsp;<span class="now_price">8.5</span>&nbsp;&nbsp;<span class="unit">元</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="add"></div>
                        </div>
                    </a>		
                </div>
            </div>
        </div>
        
        
        <!--分类页面-->
        <div id="sort" title="" class="panel" data-footer="common_footer" data-tab="tab_sort">
        	<!--分类页面的header-->
            <header class="header_sort">
            	<div class="search_sort">
                	<div class="menuButton" onclick="af.ui.toggleSideMenu()" style="float:left">
                    	<nav id="goods_list">
                        	<ul class="list">
                            	<li><a href="#sort">全部</a></li>
                                <li><a href="#sort">零食素食</a></li>
                                <li><a href="#sort">烟酒饮料</a></li>
                                <li><a href="#sort">粮油调料</a></li>
                                <li><a href="#sort">日化清洁</a></li>
                                <li><a href="#sort">百货杂物</a></li>
                                <li><a href="#sort">生鲜蔬菜</a></li>
                                <li><a href="#sort">其他扩展</a></li>
                            </ul>
                        </nav>  
                    </div>
                    <div><a href="#search_index" data-transition="fade" class="button block search1"></a></div>
                    <div class="cl"></div>
                </div>
                <div class="text_sort">订单满20元免费送货上门</div>	
            </header>
            
            
            <!--商品列表-->
            <div id="goods_all">
                <a href="#goods_index">
                    <div class="goods">
                        <div class="goods_image"><img src="<?php echo base_url('static/newuser/image/wine.png'); ?>"></div>
                        <div class="goods_detail">
                            <div class="goods_title">爱你中国科罗娜特特特级啤酒330ML（进口）</div>
                            <div class="goods_price">
                                <div class="price">
                                    <div class="unit_price">单价</div>
                                    <div class="cost">8.5&nbsp;&nbsp;<span>元</span></div>
                                </div>
                            </div>
                        </div>
                        <div class="add"></div>
                    </div>
                </a>
                <a href="#goods_index">
                    <div class="goods">
                        <div class="goods_image"><img src="<?php echo base_url('static/newuser/image/yuanyi.png'); ?>"></div>
                        <div class="goods_detail">
                            <div class="goods_title">玖枝苑 园艺三件套</div>
                            <div class="goods_price">
                                <div class="price">
                                    <div class="unit_price">单价</div>
                                    <div class="p_before">
                                    	<span class="before">10.0</span><span class="zero">0</span>
                                    	&nbsp;&nbsp;<span class="now_price">8.5</span>&nbsp;&nbsp;<span class="unit">元</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="add"></div>
                    </div>
                </a>
                <a href="#goods_index">
                    <div class="goods">
                        <div class="goods_image"><img src="<?php echo base_url('static/newuser/image/wine.png'); ?>"></div>
                        <div class="goods_detail">
                            <div class="goods_title">爱你中国科罗娜特特特级啤酒330ML（进口）</div>
                            <div class="goods_price">
                                <div class="price">
                                    <div class="unit_price">单价</div>
                                    <div class="cost">8.5&nbsp;&nbsp;<span>元</span></div>
                                </div>
                            </div>
                        </div>
                        <div class="add"></div>
                    </div>
                </a>
                <a href="#goods_index">
                    <div class="goods">
                        <div class="goods_image"><img src="<?php echo base_url('static/newuser/image/yuanyi.png'); ?>"></div>
                        <div class="goods_detail">
                            <div class="goods_title">玖枝苑 园艺三件套</div>
                            <div class="goods_price">
                                <div class="price">
                                	<div class="unit_price">单价</div>
                                    <div class="before_price">
                                    	<span class="before">10.0</span><span class="zero">0</span>
                                    	&nbsp;&nbsp;<span class="now_price">8.5</span>&nbsp;&nbsp;<span class="unit">元</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="add"></div>
                    </div>
                </a>
                <a href="#goods_index">
                    <div class="goods">
                        <div class="goods_image"><img src="<?php echo base_url('static/newuser/image/wine.png'); ?>"></div>
                        <div class="goods_detail">
                            <div class="goods_title">爱你中国科罗娜特特特级啤酒330ML（进口）</div>
                            <div class="goods_price">
                                <div class="price">
                                    <div class="unit_price">单价</div>
                                    <div class="cost">8.5&nbsp;&nbsp;<span>元</span></div>
                                </div>
                            </div>
                        </div>
                        <div class="add"></div>
                    </div>
                </a>
                <a href="#goods_index">
                    <div class="goods">
                        <div class="goods_image"><img src="<?php echo base_url('static/newuser/image/yuanyi.png'); ?>"></div>
                        <div class="goods_detail">
                            <div class="goods_title">玖枝苑 园艺三件套</div>
                            <div class="goods_price">
                                <div class="price">
                                	<div class="unit_price">单价</div>
                                    <div class="before_price">
                                    	<span class="before">10.0</span><span class="zero">0</span>
                                    	&nbsp;&nbsp;<span class="now_price">8.5</span>&nbsp;&nbsp;<span class="unit">元</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="add"></div>
                    </div>
                </a>
                <a href="#goods_index">
                    <div class="goods">
                        <div class="goods_image"><img src="<?php echo base_url('static/newuser/image/wine.png'); ?>"></div>
                        <div class="goods_detail">
                            <div class="goods_title">爱你中国科罗娜特特特级啤酒330ML（进口）</div>
                            <div class="goods_price">
                                <div class="price">
                                    <div class="unit_price">单价</div>
                                    <div class="cost">8.5&nbsp;&nbsp;<span>元</span></div>
                                </div>
                            </div>
                        </div>
                        <div class="add"></div>
                    </div>
                </a>
                <a href="#goods_index">
                    <div class="goods">
                        <div class="goods_image"><img src="<?php echo base_url('static/newuser/image/yuanyi.png'); ?>"></div>
                        <div class="goods_detail">
                            <div class="goods_title">玖枝苑 园艺三件套</div>
                            <div class="goods_price">
                                <div class="price">
                                    <div class="unit_price">单价</div>
                                    <div class="before_price">
                                    	<span class="before">10.0</span><span class="zero">0</span>
                                    	&nbsp;&nbsp;<span class="now_price">8.5</span>&nbsp;&nbsp;<span class="unit">元</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="add"></div>
                    </div>
                </a>
            </div>
        </div>
        
        <!--购物车-->
        <div id="cart" title="" class="panel" data-load="load_cart" data-footer="account_footer" data-tab="tab_cart">
        	<header>
                <a id="backButton" onClick="$.ui.goBack()"></a>
                <div class="h_header">购物车</div>
            </header>
            <footer id="account_footer">
                <div class="total_amount">
                 	<div class="total">总金额</div>
                    <div class="total_price">125.8&nbsp;元</div>   
                </div>
                <div class="account_goods">
                	<div class="confirm_order">确认订单</div>
                    <div class="cancel"></div>
                </div>
                <div class="order_info">
                	<div class="order_info1">
                    	<table width="100%" border="0">
                          <tr>
                            <td>配送地址</td>
                          </tr>
                          <tr>
                            <td>联系电话</td>
                          </tr>
                          <tr>
                            <td>付款方式</td>
                          </tr>
                          <tr>
                            <td>优惠信息</td>
                          </tr> 
                        </table>
                    </div>
                    <div class="order_info2">
                    	<table width="100%" border="0">
                          <tr>
                            <td>奥格瑞玛暗影巷4-1503</td>
                          </tr>
                          <tr>
                            <td>15210827778</td>
                          </tr>
                          <tr>
                            <td>现金</td>
                          </tr>
                          <tr>
                            <td class="fav">
                            <select id="test" class="fav_select">
                                <option value="1">首次下单送雪碧</option>
                                <option value="2">满100减5元</option>
                                <option value="3">春节免单大抽奖</option>
                                <option value="4">首次下单送可乐</option>
                            </select>
                            </td>
                          </tr> 
                        </table>
                    </div>
                </div>
        	</footer>
            <div id="cartgoods_all">
            	<a href="#goods_index">
                    <div class="cart_goods">
                         <div class="goods_image"><img src="<?php echo base_url('static/newuser/image/wine.png'); ?>"></div>
                         <div class="goods_detail">
                              <div class="goods_title">爱你中国科罗娜特特特级啤酒330ML（进口）</div>
                              <div class="goods_price">
                                  <div class="price1">
                                      <div class="unit_price">单价</div>
                                      <div class="cost">8.5&nbsp;&nbsp;<span>元</span></div>
                                  </div>
                                  <div class="goods_num">
                                      <div class="quantity">数量</div>
                                      <div class="num">
                                          <div class="number">1</div>
                                          <div class="increase"></div>
                                          <div class="decrease"></div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                    </div>
                </a>
                <a href="#goods_index">
                    <div class="cart_goods">
                         <div class="goods_image"><img src="<?php echo base_url('static/newuser/image/cup.png'); ?>"></div>
                         <div class="goods_detail">
                              <div class="goods_title">CUPTIME可以记录下你每次喝了多少水</div>
                              <div class="goods_price">
                                  <div class="price1">
                                      <div class="unit_price">单价</div>
                                      <div class="cost">28.5&nbsp;&nbsp;<span>元</span></div>
                                  </div>
                                  <div class="goods_num">
                                      <div class="quantity">数量</div>
                                      <div class="num">
                                          <div class="number">1</div>
                                          <div class="increase"></div>
                                          <div class="decrease"></div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                    </div>
                </a>
                <a href="#goods_index">
                    <div class="cart_goods">
                         <div class="goods_image"><img src="<?php echo base_url('static/newuser/image/wine.png'); ?>"></div>
                         <div class="goods_detail">
                              <div class="goods_title">爱你中国科罗娜特特特级啤酒330ML（进口）</div>
                              <div class="goods_price">
                                  <div class="price1">
                                      <div class="unit_price">单价</div>
                                      <div class="cost">8.5&nbsp;&nbsp;<span>元</span></div>
                                  </div>
                                  <div class="goods_num">
                                      <div class="quantity">数量</div>
                                      <div class="num">
                                          <div class="number">1</div>
                                          <div class="increase"></div>
                                          <div class="decrease"></div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                    </div>
                </a>
                <a href="#goods_index">
                    <div class="cart_goods">
                         <div class="goods_image"><img src="<?php echo base_url('static/newuser/image/cup.png'); ?>"></div>
                         <div class="goods_detail">
                              <div class="goods_title">CUPTIME可以记录下你每次喝了多少水</div>
                              <div class="goods_price">
                                  <div class="price1">
                                      <div class="unit_price">单价</div>
                                      <div class="cost">28.5&nbsp;&nbsp;<span>元</span></div>
                                  </div>
                                  <div class="goods_num">
                                      <div class="quantity">数量</div>
                                      <div class="num">
                                          <div class="number">1</div>
                                          <div class="increase"></div>
                                          <div class="decrease"></div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                    </div>
                </a>
                <a href="#goods_index">
                    <div class="cart_goods">
                         <div class="goods_image"><img src="<?php echo base_url('static/newuser/image/wine.png'); ?>"></div>
                         <div class="goods_detail">
                              <div class="goods_title">爱你中国科罗娜特特特级啤酒330ML（进口）</div>
                              <div class="goods_price">
                                  <div class="price1">
                                      <div class="unit_price">单价</div>
                                      <div class="cost">8.5&nbsp;&nbsp;<span>元</span></div>
                                  </div>
                                  <div class="goods_num">
                                      <div class="quantity">数量</div>
                                      <div class="num">
                                          <div class="number">1</div>
                                          <div class="increase"></div>
                                          <div class="decrease"></div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                    </div>
                </a>
                <a href="#goods_index">
                    <div class="cart_goods">
                         <div class="goods_image"><img src="<?php echo base_url('static/newuser/image/cup.png'); ?>"></div>
                         <div class="goods_detail">
                              <div class="goods_title">CUPTIME可以记录下你每次喝了多少水</div>
                              <div class="goods_price">
                                  <div class="price1">
                                      <div class="unit_price">单价</div>
                                      <div class="cost">28.5&nbsp;&nbsp;<span>元</span></div>
                                  </div>
                                  <div class="goods_num">
                                      <div class="quantity">数量</div>
                                      <div class="num">
                                          <div class="number">1</div>
                                          <div class="increase"></div> 
                                          <div class="decrease"></div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                    </div>
                </a>
                <a href="#goods_index">
                    <div class="cart_goods">
                         <div class="goods_image"><img src="<?php echo base_url('static/newuser/image/wine.png'); ?>"></div>
                         <div class="goods_detail">
                              <div class="goods_title">爱你中国科罗娜特特特级啤酒330ML（进口）</div>
                              <div class="goods_price">
                                  <div class="price1">
                                      <div class="unit_price">单价</div>
                                      <div class="cost">8.5&nbsp;&nbsp;<span>元</span></div>
                                  </div>
                                  <div class="goods_num">
                                      <div class="quantity">数量</div>
                                      <div class="num">
                                          <div class="number">1</div>
                                          <div class="increase"></div> 
                                          <div class="decrease"></div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                    </div>
                </a>
            </div>
        </div>
        
        
        <!--订单确认页面-->
        <div id="verify" title="" class="panel" data-footer="none" data-load="load_verify" data-header="none" scrolling="no">
        	<div class="verify_index">
                <div class="total_amount1">
                    <div class="total">总金额</div>
                    <div class="total_price">125.8&nbsp;元</div>  
                </div>
                <div class="order_text">
                    <p>订单已发送 等待商家处理</p>
                    <div>
                        超出营业时间的订单<br />
                        预计于次日8:30送到
                    </div>
                </div>
            </div>
        </div>
        
        
        <!--商品页面-->
         <div id="goods_index" title="" class="panel" data-footer="footer_goods">
         	<header>
            	<a id="backButton" onClick="$.ui.goBack()"></a>
                <div class="h_header">商品信息</div>
            </header>
            <div class="bigimage">
            	<img src="<?php echo base_url('static/newuser/image/goods1.png'); ?>">
            </div>
            <div class="goods_text">
            	<div class="goods_title1">
                	爱你中国科罗娜特特特级啤酒330ML（进口）
                </div>
                <div class="price_goods">
                    <div class="price2">
                        <div class="unit_price">单价</div>
                        <div class="cost1">8.5&nbsp;<span>元</span></div>
                    </div>
                    <div class="goods_intr">
                    	品牌： CORONA EXTRA科罗娜直接饮用，冷藏后口感更佳直接饮用，冷藏后口感更佳直接饮用，冷藏后口感更佳
                    </div>
                </div>
            </div>
            <footer id="footer_goods">
            	<a href="#cart"><div class="add_cart">加入购物车</div></a>
            </footer>
         </div>
         
         
        <!--更多-->
        <div id="more" title="" class="panel" data-footer="common_footer" data-tab="tab_more">
        	<header>
            	<div class="h_header">更多</div>
            </header>
            
        </div>
    </div>
    <footer id="common_footer">
    	<a href="#index" id="tab_index">
        	<div class="index_image"></div>
            <div class="footer_text">首页</div>
        </a>
        <a href="#sort" id="tab_sort">
        	<div class="sort_image"></div>
            <div class="footer_text">分类</div>
        </a>
        <a href="#cart" id="tab_cart">
            <!--<span class="af-badge">88</span>-->
       		<div class="cart_image"></div>
            <div class="footer_text">购物车</div>
        </a>
        <a href="#more" id="tab_more">
        	<div class="more_image"></div>
            <div class="footer_text">更多</div>
        </a>
    </footer>
    
</div>

</body>
</html>
