<!-- 商铺管理页面 -->
<?php load_view('admin/common/header'); ?>

        <div class="content">
        	<div class="content1">
            	<!-- <a href="<?php echo base_url('admin/shop/add_shop'); ?>"><div class="icon">添加商铺</div></a> -->
            </div>
            <div class="content2">
            	<table width="100%" border="1">
                      <tr>
                        <th width="3%">编号</th>
                        <th width="7%">商铺名称</th>
                        <th width="5%">店主</th>
                        <th width="15%">地址</th>
                        <th width="10%">电话</th>
                        <th width="10%">营业时间</th>
                        <th width="5%">营业中</th>
                        <th width="5%">操作</th>
                      </tr>
                      <?php foreach ($shop as $row): ?>
                      <tr>
                        <td><?php echo $row->shop_id; ?></td>
                        <td><?php echo $row->name; ?></td>
                        <td><?php echo $row->manager; ?></td>
                        <td><?php echo $row->address; ?></td>
                        <td><?php echo $row->phone; ?></td>
                        
                        <td><?php if ($row->shop_hours !== '') {echo ((json_decode($row->shop_hours)->start_time)), ' - ', ((json_decode($row->shop_hours)->close_time));} ?></td>
                        <td><?php if ($row->on_business == 1)
                        	{echo '是';} else {echo '否';}?>
                        </td>
                        <td><a href="<?php echo base_url('/admin/shop/edit_shop?shop_id=' .$row->shop_id); ?>">编辑</a>
                        </td>
                      </tr>
                      <?php endforeach;?>
                 </table>
                 <center><?php echo $page; ?></center>
            </div>
        </div>
        
<?php load_view('admin/common/footer'); ?>