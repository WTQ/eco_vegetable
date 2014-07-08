<?php load_view('/user/common/header');?>

<body>
<div class="page" data-role="page">
  <div class="header" data-role="header" data-position="fixed">
    <div class="header5">
     <a href="javascript:window.history.back();"><img align="absmiddle" src="<?php echo base_url('static/user/image/houtui.gif'); ?>"></a>
    </div>
    <div class="header6">确认订单</div>
  </div>
  <div class="content4" data-role="content" data-theme="c">
	<div style="color: red;line-height: 30px;" id="order_msg"></div>
    <div class="content7">
    联系电话: <span style="color: red;" id="phone_error"></span>
    <input id="phone-verify" type="number" type="text" name="phone" value ="<?php echo isset($user->phone) ? $user->phone : ''; ?>">

    <div class = "phone-captcha" style="display:none">
      <botton id="get-captcha" href="#" class="ui-btn">验证短信已发送（60）</botton>
      <br />
      验证码: 
      <input type="text" name="captcha" id="captcha" value =""/>
      <br />
    </div>
    收货地址: 
    <input type="text" name="address" id="address" value ="<?php echo isset($user->address) ? $user->address : ''; ?>">


    付款方式：  <span>到货现金付款</span><br />
    优惠信息： <span>暂无优惠可用</span><br />
    <span class ="order_total">商品总价：￥<?php echo $this->cart->total();?></span><br>
    <span class ="deliver">送货费：￥0.00<br /></span>
    <?php $shop_id = cookie('shop_id');?>
    <?php $shop = $this->shop_m->get_by('shop_id', $shop_id);?>
    送货商家： <span><?php echo $this->shop_m->get_name($shop_id);?></span><br>
    <span><?php echo $shop->discript?></span>
    </div>
    
  </div>
  <div class="footer9" data-role="footer"  data-position="fixed" data-theme="b">
      <div class="footer10">
          <div>总金额</div>
          <div class = "total_prices"><?php echo $this->cart->total();?>元</div>
      </div>
      <div class="footer11"><button type="botton" class="ui-btn goods1" id="order_submit">提交订单</button></div>
  </div>
</div>


</body>
</html>
