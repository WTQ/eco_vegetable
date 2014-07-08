<?php load_view('user/common/header'); ?>

<div class="page" data-role="page">
  <div class="header4" data-position="fixed"> 
    分类导航
  </div>
  <div class="content1" data-role="content"> 
    <ul data-role="listview" >
      <li><a href="/user/category/cate_info?class_id=1" data-transition="slide">零食素食</a></li>
      <li><a href="/user/category/cate_info?class_id=2" data-transition="slide">烟酒饮料</a></li>
      <li><a href="/user/category/cate_info?class_id=3" data-transition="slide">粮油调料</a></li>
      <li><a href="/user/category/cate_info?class_id=4" data-transition="slide">日化清洁</a></li>
      <li><a href="/user/category/cate_info?class_id=5" data-transition="slide">百货杂物</a></li>
      <li><a href="/user/category/cate_info?class_id=6" data-transition="slide">生鲜蔬菜</a></li>
    </ul>
  </div>
  <div class="footer" data-role="footer" data-position="fixed">
    <div>
       <a href="/user/shop/" data-transition="slide"><div class="footer5"></div>
      <div>主页</div></a>
    </div>
    <div>
     <div class="footer6"></div>
      <div>分类</div>
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
