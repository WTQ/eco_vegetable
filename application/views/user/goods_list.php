<?php load_view('user/common/header'); ?>

<div class="page" data-role="page">
  <div class="header" data-page="header" data-position="fixed">
       <div class="header5">
           <a href="javascript:window.history.back();"><img align="absmiddle" src="<?php echo base_url('/static/user/image/houtui.gif'); ?>"></a>
       </div>
       <div class="header6">分类导航</div>
       <div class="cl"></div>
  </div>
  
  
  <div class="content14" data-role="content" data-theme="b">
  <?php if (isset($goods)): ?>
  	<?php foreach ($goods as $row): ?>
  		
  			<div>
  				<div class="content2"><a href="/user/goods/?goods_id=<?php echo $row->goods_id; ?>"><img src="<?php echo base_url($row->pic); ?>"></a></div>
  				<div class="content3">
  					<div class="cc"><?php echo $row->name; ?><br /></div>
  					<div class="dd">
  						<div class="d1"><?php echo $row->price; ?></div>
  						<div class="d2"><a href="#" class="cart_add" goods-id="<?php echo $row->goods_id; ?>" data-transition="slide"><button class="ui-btn">加入购物车</button></a></div>
  						<div class="cl"></div>
  					</div>
  				</div>
  				<div class="cl"></div>
  			</div>
  		
  	<?php endforeach;?>
  <?php endif;?>
 
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
      <a href="<?php echo base_url('user/cart');?>" data-transition="slide"><div class="footer3"></div>
      <div>购物车</div></a>
    </div>
    
    <div>
      <a href="<?php echo base_url('user/order');?>" data-transition="slide"><div class="footer4"></div>
      <div>我的订单</div></a>
    </div>
    <div class="cl"> </div>
  </div>
</div>
</body>
</html>
