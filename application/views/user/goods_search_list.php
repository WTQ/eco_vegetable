<?php load_view('user/common/header'); ?>

<div class="page" data-role="page" data-theme="b">
  <div class="content11"></div>
    <div class="content12">
      <form action="/user/search/search_goods" method="get">
        <div class="search">
          <label for="search-4" class="ui-hidden-accessible">Search Input:</label>
          <input type="search" name="keyword" id="search-4" value="" placeholder="输入名称或关键搜索">
        </div>
      </form>
        <a href="/user/search/"><div class="quxiao">取消</div></a>
        <div class="cl"></div> 
    </div>
  
    <div class="content14" data-role="content" data-theme="b">
    <?php if (isset($goods)): ?>
	<?php foreach ($goods as $row): ?>
		<li>
			<?php $row['name'] = preg_replace("/$keyword/i", "<font color=red><b>$keyword</b></font>", $row['name']); ?>
			
      		<div>
        		<div class="content2"><a href="/user/goods/info?goods_id=<?php echo $row['goods_id']; ?>"><img src="<?php echo base_url('/static/user/image/jiu2.gif'); ?>"></a></div>
        			<div class="content3">
          				<div class="cc"><?php echo $row['name']; ?><br /></div>
          				
          				<div class="dd">
            			<div class="d1">单价<?php echo $row['price']; ?></div>
            			<div class="d2"><a href="Cart_index.html"><button class="ui-btn">加入购物车</button></a></div>
           				<div class="cl"></div>
          			</div>
        		</div>
        		<div class="cl"></div>
      		</div>
		</li>
	<?php endforeach;?>
	<?php endif;?>  
	
    </div>
  </div> 
</div>

</body>
</html>
