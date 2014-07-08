<?php load_view('user/common/header'); ?>

<div class="page" data-role="page" data-theme="b">
  <div class="content11" data-role="content">
    <div class="content12">
    <form action="/user/search/search_goods" method="get">
      <div class="search">
        <label for="search-4" class="ui-hidden-accessible">Search Input:</label>
        <input type="search" name="keyword" id="search-4" value="" placeholder="输入名称或关键搜索">
      </div>
    </form>
      <a href="/user/shop/"><div class="quxiao">取消</div></a>
      <div class="cl"></div>
     
    </div>
    <div class="content13">可口可乐<br />酱油<br />中华<br />啤酒<br />美极鲜味汁<br />太太乐鸡精<br />鸡蛋</div>
  </div>
  
<?php if (isset($goods)): ?>
	<?php foreach ($goods as $row): ?>
		<li>
			<?php $row['name'] = preg_replace("/$keyword/i", "<font color=red><b>$keyword</b></font>", $row['name']); ?>
			<p><?php echo $row['name']?></p>
		</li>
	<?php endforeach;?>
<?php endif;?>
</div>

</body>
</html>
