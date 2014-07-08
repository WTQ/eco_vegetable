<?php $this->load->view('user/common/header'); ?>

<div class="page" data-role="page">
      <div class="list_search">
      <form method="get" action="<?php echo base_url('user/zone/select_community')?>">
        <div class="search1">
          <input type="text" name="name" data-corners="false" placeholder="<?php echo $keyword; ?>" value="">
        </div>
        <div class="submit">
        	<button type="submit" id="submit-8" class="ui-shadow ui-btn ui-mini tijiao"></button>
        </div>
        <div class="cl"></div>
      </form> 
      </div>
   
   
   
   <div class="zone" data-role="content">
    <ul data-role="listview" data-inset="ture">
    <?php if($result):?>
	<?php foreach ($result as $row):?>
	<?php $row['name'] = preg_replace("/$keyword/i", "<font color=red><b>$keyword</b></font>", $row['name']); ?>
      <li>
          <div class="xiaoqu"><a href="<?php echo base_url('user/zone/search_shop/?community_id=' . $row['community_id']); ?>"><?php echo $row['name']?></a></div>
          <div class="quyu"><?php echo $row['belong']['district_name']; echo '-'; echo $row['belong']['block_name'];?></div>
          <div class="cl"></div>
      </li>
    <?php endforeach;?>
    <?php endif;?>
    </ul>
   </div>
</div>
</body>
</html>
