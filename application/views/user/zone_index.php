<?php $this->load->view('user/common/header'); ?>
<div class="page"  data-role="page">
  <div class="header8" data-role="header">
      请选择小区
  </div>   
  
  <div class="list" data-role="content">
      <div class="list_search">
      <form method="get" action="<?php echo base_url('user/zone/select_community')?>">
        <div class="search1">
          <input type="text" name="name" data-corners="false" placeholder="请输入小区名" value="">
        </div>
        <div class="submit">
        	<button type="submit" id="submit-8" class="ui-shadow ui-btn ui-mini tijiao"></button>
        </div>
        <div class="cl"></div>
      </form> 
      </div>
  

      <div data-role="collapsibleset"  class="qu" data-inset="false">
        <?php foreach ($district as $data):?>
          <div data-role="collapsible" data-iconpos="right">
              <h4><?php echo ($data->name)?></h4>
        	  <ul data-role="listview" data-inset="true" data-icon="false">
        	    <?php $result = $block[$data->district_id];?>
                <?php if($result):?>
                <?php foreach ($result as $row):?>
          	      <li>
                      <span class="list_qu"><?php echo ($row->name)?></span>
                      <ul>
                        <?php $result2 = $community[$row->block_id]?>
                  	    <?php if($result2):?>
                  		<?php foreach ($result2 as $row2):?>
                          <li><a href="<?php echo base_url('user/zone/search_shop/?community_id=' . ($row2->community_id)); ?>"/><?php echo ($row2->name)?></a></li>
                        <?php endforeach;?>
                        <?php endif;?>
                      </ul>
                  </li>
                <?php endforeach;?>
                <?php endif;?>
               </ul>                  
          </div> 
        <?php endforeach;?>         
      </div>
  </div>
</div>
</body>
</html>
