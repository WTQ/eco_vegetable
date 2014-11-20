<?php load_view('admin/common/header'); ?>

        <div class="content">
        	<div class="content1">
            	<a href="<?php echo base_url('admin/article/add')?>">添加文章</a>
            	<a href="<?php echo base_url('admin/article_type')?>">类型管理</a>
            </div>
            <div class="content2">
            	<table width="100%">
                      <tr>
                        <th>时间</th>
                        <th>标题</th>
                        <th>分类</th>
                        <th>添加人</th>
                        <th>操作</th>
                      </tr>
					<?php foreach ($articles as $article): ?>
					<tr>
						<td><?php echo $article['add_date']; ?></td>
						<td><?php echo $article['title']; ?></td>
						<td><?php echo $article['type_name']; ?></td>
						<td><?php echo $article['add_user']; ?></td>
						<td>
							<a href="<?php echo base_url('/user/article/?aid=' . $article['aid']); ?>" target="_blank">查看</a>
							<a href="<?php echo base_url('/admin/article/edit/?aid=' . $article['aid']); ?>">编辑</a>
							<a onclick="return del_alert()" href="<?php echo base_url('/admin/article/del/?aid=' . $article['aid']); ?>">删除</a>
						</td>
					</tr>
					<?php endforeach;?>
                 </table>
                 <div><?php echo $page_html; ?></div>
            </div>
        </div>
        
<?php load_view('admin/common/footer'); ?>
