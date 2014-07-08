<?php load_view('admin/common/header'); ?>

        <div class="content">
        	<div class="content1">
            	<a href="<?php echo base_url('admin/zone/add')?>">添加</a>
            </div>
            <div class="content2">
            	<table width="100%">
                      <tr>
                        <th>小区名称</th>
                        <th>所属商业区</th>
                        <th>所属行政区</th>
                        <th>操作</th>
                      </tr>
                <?php foreach ($community as $row): ?>
                      <tr>
                        <td><?php echo ($row->name)?></td>
                        <td><?php echo ($block[$row->community_id]->name) ?></td>
                        <td><?php echo ($district[$row->community_id]->name) ?></td>
                        <td><a href="<?php echo base_url('admin/zone/edit?id='.$row->community_id)?>">修改</a> &nbsp;&nbsp;&nbsp;
                        <a onclick="return del_alert()" href="<?php echo base_url('admin/zone/del?id='.$row->community_id)?>">删除</a></td>
                      </tr>
                <?php endforeach;?>
                 </table>
                 <?php echo $page_html; ?>
            </div>
        </div>
        
<?php load_view('admin/common/footer'); ?>
