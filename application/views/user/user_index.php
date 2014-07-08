<?php load_view('user/common/header'); ?>

<div class="page"  data-role="page">
  <div class="header7" data-role="header" data-position="fixed">我的小卖部 </div>
  <div class="content1" data-role="content">
    <ul data-role="listview">
    <li><a href="#">我的账户</a></li>
    <li><a href="Order_list.html" data-transition="slide">我的订单</a></li>
    <li><a href="#">我的优惠</a></li>
    <li><a href="Article_list.html" data-transition="slide">寻求帮助</a></li>
    <li><a href="#">问题反馈</a></li>
    <li><a href="#">邀请朋友注册</a></li>
    </ul>
  </div>
  <div class="footer" data-role="footer" data-position="fixed">
     <div>
       <a href="Shop_index.html" data-transition="slide"><div class="footer5"></div>
      <div>主页</div></a>
    </div>
    <div>
      <a href="Shop_list.html" data-transition="slide"><div class="footer2"></div>
      <div>分类</a></div>
    </div>
    <div>
      <a href="<?php echo base_url('user/cart/');?>" data-transition="slide"><div class="footer3"></div>
      <div>购物车</div></a>
    </div>
    
    <div>
      <a href="<?php echo base_url('user/order/');?>" data-transition="slide"><div class="footer4"></div>
      <div>我的订单</div></a>
    </div>
    <div class="cl"> </div> 
  </div>
</div>
</body>
</html>
