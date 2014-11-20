<?php load_view('admin/common/header'); ?>

        <div class="content">
        	<div class="content1">
            	<a href="<?php echo base_url('admin/article_type/add')?>">添加</a>
            </div>
            <div class="content2">
            	<table width="100%">
                      <tr>
                        <th>tid</th>
                        <th>类别名称</th>
                        <th>操作</th>
                      </tr>
                <?php foreach ($types as $type): ?>
                      <tr>
                      	<td><?php echo $type['tid']?></td>
						<td><?php if($type['level'] == 2) echo '|——';if($type['level']==3) echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|——'?><?php echo $type['name']?></td>
						<td>
						<a href="<?php echo base_url('admin/article_type/edit/?tid=' . $type['tid']); ?>">编辑</a> | 
						<a  onclick="return del_alert()" href="<?php echo base_url('/admin/article_type/del/?tid=' . $type['tid']); ?>">删除</a>
						</td>
					  </tr>
                <?php endforeach;?>
                 </table>
            </div>
        </div>
        
<?php load_view('admin/common/footer'); ?>
