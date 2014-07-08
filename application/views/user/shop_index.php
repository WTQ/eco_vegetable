<?php load_view('user/common/header'); ?>


<div class="page" data-role="page">
  <div class="header" data-position="fixed">
    <div class="header1">
      <div class="header1left"><img src="<?php echo base_url('/static/user/image/header_r1_c1.gif'); ?>"></div>
      <a href="/user/search/"><div class="sousuo">
        <label for="search-4" class="ui-hidden-accessible">Search Input:</label>
        <input type="search" name="search-4" id="search-4" value="" placeholder="输入名称或关键搜索"> 
      </div></a>
      <div class="cl"></div>
    </div>
    <div class="header2"><?php if (isset($community) && isset($shop)) {
    	echo $community->name;echo ' - ';echo $shop->name;echo ' 营业时间 ', ((json_decode($shop->shop_hours)->start_time)), ' - ', ((json_decode($shop->shop_hours)->close_time));
    } ?></div>
    
    <div class="header3">订单满20元免费送货上门（不含香烟） </div>
  </div>
  <div class="content">
  <?php if (isset($goods)): ?>
  	<?php foreach ($goods as $row): ?>
  	<li>
  		<div><a href="/user/goods/?goods_id=<?php echo $row->goods_id; ?>"><img src="<?php echo base_url('/static/user/image/content1.gif'); ?>">
  			<div><span><?php echo $row->name; ?><br /></span><?php echo $row->intro; ?></a>
  		</div>
  	</li>
  </div>
  	<?php endforeach;?>
  <?php endif;?>
    
</div>
  <div class="footer" data-role="footer" data-position="fixed">
    <div>
      <div class="footer1"></div>
      <div>主页</div>
    </div>
    
    <div>
      <a href="/user/category"><div class="footer2"></div>
      <div>分类</div></a>
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
