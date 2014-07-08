<?php load_view('depot/common/header'); ?>

		<div class="content">
        	<div class="content1">
            	<a href="<?php echo base_url('depot/goods/add_goods'); ?>">添加商品</a>
            </div>
            <div class="content2">
            	<table width="100%">
                      <tr>
                        <th width="2%">编号</th>
                        <th width="5%">品名</th>
                        <th width="5%">图片</th>
                        <th width="5%">条形码</th>
                        <th width="2%">规格</th>
                        <th width="2%">价格</th>
                        <th width="10%">介绍</th>
                        <th width="3%">操作</th>
                      </tr>
                      <?php foreach ($goods as $row): ?>
                      <tr>
                        <td><?php echo $row->goods_id; ?></td>
                        <td><?php echo $row->name; ?></td>
                        <td><img src="<?php if ($row->pic) echo base_url(json_decode($row->pic)->default); ?>" width="60" /></td>
                        <td><?php echo $row->barcode; ?></td>
                        <td><?php echo $row->unit; ?></td>
                        <td><?php echo $row->price; ?></td>
                        <td><?php echo $row->intro; ?></td>
                        <td><a href="<?php echo base_url('/depot/goods/edit_goods?goods_id=' .$row->goods_id); ?>">编辑</a>
                        	<a onclick="return del_alert()" href="<?php echo base_url('/depot/goods/del_goods?goods_id=' .$row->goods_id); ?>">删除</a>
                        </td>
                      </tr>
                      <?php endforeach;?>
                 </table>
                 <center><?php echo $page; ?></center>
            </div>
        </div>

<?php load_view('depot/common/footer'); ?>