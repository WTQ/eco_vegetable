<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=0">
<meta name="format-detection" content="telephone=no">

<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="default">

<title>商家服务端</title>

<!-- 模板解析的JS -->
<script type="text/javascript" charset="utf-8" src="<?php echo base_url('static/shop/js/template.js'); ?>"></script>

<!-- 基础的appframework框架 -->
<script type="text/javascript" charset="utf-8" src="<?php echo base_url('static/shop/js/appframework.min.js'); ?>"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo base_url('static/shop/js/appframework.ui.min.js'); ?>"></script>

<!-- 插件 -->
<script type="text/javascript" charset="utf-8" src="<?php echo base_url('static/shop/js/plugins/af.touchEvents.js'); ?>"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo base_url('static/shop/js/plugins/af.touchLayer.js'); ?>"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo base_url('static/shop/js/plugins/af.css3animate.js'); ?>"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo base_url('static/shop/js/plugins/af.scroller.js'); ?>"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo base_url('static/shop/js/plugins/af.slidemenu.js'); ?>"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo base_url('static/shop/js/plugins/af.desktopBrowsers.js'); ?>"></script>

<!-- 开发的JS -->
<script type="text/javascript" charset="utf-8" src="<?php echo base_url('static/shop/js/main.js'); ?>"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo base_url('static/shop/js/tab.js'); ?>"></script>

<link rel="stylesheet" type="text/css" href="<?php echo base_url('static/shop/css/af.ui.css'); ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url('static/shop/css/icons.css'); ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url('static/shop/css/shop.css'); ?>" />

</head>

<body>
<div id="afui">
	<div id="content">
		<!-- 首页空白页面 -->
		<div id="index" title="" class="panel" data-header="none" data-footer="none"></div>
		
		<!-- 登录页面 -->
		<div id="login" title="" class="panel" data-footer="none">
	        <header>
	        	<h1>登录</h1>
	        </header>
	        <div class="h10px"></div>
	        <form action="" onSubmit="return false">
	            <div class="username">
	                <span>用户名：</span>
	                <div><input type="text" name="username" placeholder="用户名" id="username"></div>
	                <div class="cl"></div>
	            </div>
	            <div class="pwd">
	                <span>密码：</span>
	                <div><input type="password" name="password" placeholder="密码" id="password"></div>
	                <div class="cl"></div>
	            </div>
	            <div class="verify">
	            	<span class="verifytext">验证码：</span>
	            	<div class="verifycode">
	                	<input type="text" name="verifytext" placeholder="请输入" id="verifytext">
	                </div>
	                <div class="verifyimg"><a class="change_verify" href="#"><img id="captcha_img" src="<?php echo base_url('shop/captcha'); ?>"></a></div>
	                <span class="change"><a class="change_verify" href="#">换一换</a></span>
	                <div class="cl"></div>
	            </div>
	            <div class="submit">
	            	 <button type="submit" name="submit" value="登陆" id="userlogin">登录</button>
	            </div>
	        </form>
        </div>
        
        <!-- 订单管理页面 -->
    	<div id="order" title="" class="panel" data-load="load_order_new" data-footer="common_footer">
    		<header>
	    		<h1>订单</h1>
	   	    </header>
        	<div class="tab button-grouped flex tabbed">
            	<a id="title_new" class="button pressed order_item" data-ignore-pressed="true">
                	新订单
                    
                </a>
                <a id="title_processing" class="button" data-ignore-pressed="true" >
                	进行中的订单
                	
                </a>
                <a class="button" data-ignore-pressed="true" >历史订单</a>
            </div>
            <div class="tab_icon">
            	<div id="new_order">

                	<div class="order_detail" >
                    	订单时间：14:05 21/04/2014<br />送货地址：春畅园4号楼2403<br />收货人电话：13800138000<br />订单金额：86.00元<br />订单编号：01CY0011014042	
                    </div>
                    <div class="order_detail">
                    	订单时间：14:05 21/04/2014<br />送货地址：春畅园4号楼2403<br />收货人电话：13800138000<br />订单金额：86.00元<br />订单编号：01CY0011014042	
                    </div>
                	<div class="order_detail" >
                    	订单时间：14:05 21/04/2014<br />送货地址：春畅园4号楼2403<br />收货人电话：13800138000<br />订单金额：86.00元<br />订单编号：01CY0011014042	
                    </div>
                    <div class="order_detail">
                    	订单时间：14:05 21/04/2014<br />送货地址：春畅园4号楼2403<br />收货人电话：13800138000<br />订单金额：86.00元<br />订单编号：01CY0011014042	
                    </div>
                	<div class="order_detail" >
                    	订单时间：14:05 21/04/2014<br />送货地址：春畅园4号楼2403<br />收货人电话：13800138000<br />订单金额：86.00元<br />订单编号：01CY0011014042	
                    </div>
                    <div class="order_detail">
                    	订单时间：14:05 21/04/2014<br />送货地址：春畅园4号楼2403<br />收货人电话：13800138000<br />订单金额：86.00元<br />订单编号：01CY0011014042	
                    </div>
                	<div class="order_detail" >
                    	订单时间：14:05 21/04/2014<br />送货地址：春畅园4号楼2403<br />收货人电话：13800138000<br />订单金额：86.00元<br />订单编号：01CY0011014042	
                    </div>
                    <div class="order_detail">
                    	订单时间：14:05 21/04/2014<br />送货地址：春畅园4号楼2403<br />收货人电话：13800138000<br />订单金额：86.00元<br />订单编号：01CY0011014042	
                    </div>
                	<div class="order_detail" >
                    	订单时间：14:05 21/04/2014<br />送货地址：春畅园4号楼2403<br />收货人电话：13800138000<br />订单金额：86.00元<br />订单编号：01CY0011014042	
                    </div>
                    <div class="order_detail">
                    	订单时间：14:05 21/04/2014<br />送货地址：春畅园4号楼2403<br />收货人电话：13800138000<br />订单金额：86.00元<br />订单编号：01CY0011014042	
                    </div>
                	<div class="order_detail" >
                    	订单时间：14:05 21/04/2014<br />送货地址：春畅园4号楼2403<br />收货人电话：13800138000<br />订单金额：86.00元<br />订单编号：01CY0011014042	
                    </div>
                    <div class="order_detail">
                    	订单时间：14:05 21/04/2014<br />送货地址：春畅园4号楼2403<br />收货人电话：13800138000<br />订单金额：86.00元<br />订单编号：01CY0011014042	
                    </div>
                </div>
                <div id="processing_order" class="hide" style="display:none">

                </div>
                <div id="histroy_order" class="hide" style="display:none">

                </div>
            </div>	
        </div>
        
        <div title="Scroller" class="panel" id="webslider">
		</div>
        
        
        <!-- 商品管理页面 -->
   		<div id="goods" title="" class="panel" data-footer="common_footer">
   			<header>
	    		<h1>商品</h1>
	    	</header>
	    		<div id="testa">
                	<div class="order_detail" >
                    	订单时间：14:05 21/04/2014<br />送货地址：春畅园4号楼2403<br />收货人电话：13800138000<br />订单金额：86.00元<br />订单编号：01CY0011014042	
                    </div>
                    <div class="order_detail">
                    	订单时间：14:05 21/04/2014<br />送货地址：春畅园4号楼2403<br />收货人电话：13800138000<br />订单金额：86.00元<br />订单编号：01CY0011014042	
                    </div>
                    <div class="order_detail">
                    	订单时间：14:05 21/04/2014<br />送货地址：春畅园4号楼2403<br />收货人电话：13800138000<br />订单金额：86.00元<br />订单编号：01CY0011014042	
                    </div>
                    <div class="order_detail">
                    	订单时间：14:05 21/04/2014<br />送货地址：春畅园4号楼2403<br />收货人电话：13800138000<br />订单金额：86.00元<br />订单编号：01CY0011014042	
                    </div>
                    <div class="order_detail">
                    	订单时间：14:05 21/04/2014<br />送货地址：春畅园4号楼2403<br />收货人电话：13800138000<br />订单金额：86.00元<br />订单编号：01CY0011014042	
                    </div>
                    <div class="order_detail">
                    	订单时间：14:05 21/04/2014<br />送货地址：春畅园4号楼2403<br />收货人电话：13800138000<br />订单金额：86.00元<br />订单编号：01CY0011014042	
                    </div>
                    <div class="order_detail">
                    	订单时间：14:05 21/04/2014<br />送货地址：春畅园4号楼2403<br />收货人电话：13800138000<br />订单金额：86.00元<br />订单编号：01CY0011014042	
                    </div>
                    <div class="order_detail">
                    	订单时间：14:05 21/04/2014<br />送货地址：春畅园4号楼2403<br />收货人电话：13800138000<br />订单金额：86.00元<br />订单编号：01CY0011014042	
                    </div>
                    <div class="order_detail">
                    	订单时间：14:05 21/04/2014<br />送货地址：春畅园4号楼2403<br />收货人电话：13800138000<br />订单金额：86.00元<br />订单编号：01CY0011014042	
                    </div>
                </div>
        </div>
        
        <!-- 商户更多页面 -->
        <div id="more" title="" class="panel" data-footer="common_footer">
        	<header>
	    		<h1>更多</h1>
	    	</header>
            <ul class="list">
            	<li>
                	<a href="#" class="icon home big" data-transition="fade">百达利便利店<br />地址：XXXXX<br />电话：12323232</a>
                </li>
                <li>
                	<a href="#" class="icon graph big" data-transition="fade">统计中心</a>
                </li>
                <li>
                	<a href="#" class="icon basket big" data-transition="fade">营销管理</a>
                </li>
                <li>
                	<a href="#" class="icon folder big" data-transition="fade">数据管理</a>
                </li>
                <li>
                	<a href="#" class="icon settings big" data-transition="fade">设置</a>
                </li>
            </ul>
        </div>
    
    	<!-- 页面的公共footer -->
    	<footer id="common_footer">
            <a href='#order' class="icon home big pressed" data-transition="fade">
            	订单
            </a>
            <a href='#goods' class="icon stack big" data-transition="fade">商品</a>
            <a href='#more' class="icon folder big" data-transition="fade">更多</a>
    	</footer>
    	
<script id="tmp_order" type="text/html">

<% for (var i = 0; i < orders.length; i++) { %>
	<div class="order_detail">
		订单时间：<%= orders[i]["add_time_str"] %><br />
		送货地址：<%= orders[i]["address"] %><br />
		收货人电话：<%= orders[i]["phone"] %><br />
	</div>
<% } %>

</script>


<script id="num" type="text/html">
<span class="af-badge lr"><%= num %></span>
</script>
</div>
</div>
</body>
</html>
