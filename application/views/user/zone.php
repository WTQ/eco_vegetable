<?php $this->load->view('user/common/header'); ?>
<div class="page" data-role="page">
  <div class="content14" data-role="content">
    <div class="sousuo1">
      <label for="search-4" class="ui-hidden-accessible">Search Input:</label>
      <input type="search" name="search-4" id="search-4" value="" placeholder="请输入小区名">
    </div>
    <div class="list">
      <ul data-role="listview">
        <?php foreach ($district as $data):?>
        <li class="list_dis"> <a href="#"><?php echo ($data->name)?></a>
          <div class="cell" style="display:none;">
            <ul>
            <?php $result = $block[$data->district_id];?>
            <?php if($result):?>
            <?php foreach ($result as $row):?>
              <li class="list_dis2"> <a href="#" class="ui-btn ui-btn-inline ui-corner-all"><?php echo ($row->name)?></a>
                <div class="cell_list" style="display:none">
                  <ul>
                  <?php $result2 = $community[$row->block_id]?>
                  <?php if($result2):?>
                  <?php foreach ($result2 as $row2):?>
                    <li><a href = "zone/search_shop/?community_id=<?php echo ($row2->community_id)?>"><?php echo ($row2->name)?></a></li>
                  <?php endforeach;?>
                  <?php endif;?>
                  </ul>
                </div>
              </li>
              <?php endforeach;?>
              <?php endif;?>
              <div class="cl"></div>
            </ul>
          </div>     
    	</li>
    <?php endforeach;?>
    </ul>
  </div>
</div>
</div>
</body>
</html>
