<?php $this->load->view('user/common/header'); ?>

<div class="page"  data-role="page">
    <div class="header" data-page="header" data-position="fixed">
        <div class="header5">
            <a href="<?php echo base_url('/user/article')?>" data-transition="slide"><img align="absmiddle" src="<?php echo base_url('/static/user/image/houtui.gif')?>"></a>
        </div>
        <div class="header6"><?php echo ($article->title)?></div>
        <div class="cl"></div>
   </div>
   <div class="article" data-role="content">
   &nbsp;&nbsp;&nbsp;&nbsp;<?php echo ($article->content)?>
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
      <a href="Cart_index.html" data-transition="slide"><div class="footer3"></div>
      <div>购物车</div></a>
    </div>
    <div>
      <div class="footer7"></div>
      <div>我的订单</div>
    </div>
    <div class="cl"> </div> 
  </div>
</div>
</body>
</html>
