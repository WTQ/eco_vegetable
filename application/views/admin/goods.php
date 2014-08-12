<!-- 商品管理页面 -->
<?php load_view('admin/common/header'); ?>
		<div class="content">
        	<div class="content1">
            	<a href="<?php echo base_url('/admin/goods/add_goods'); ?>">添加商品</a>
            </div>
            
            <div class="content2">
				<form action="<?php echo base_url('admin/goods/'); ?>" method="get">
					<table width="100%">
						<tr>
							<td width="90%">产品分类：
								<select name="stage">
									<option value="0" <?php if($stage == 0) echo 'selected'?>>全部</option>
									<option value="1" <?php if($stage == 1) echo 'selected'?> >特价蔬菜</option>
									<option value="2" <?php if($stage == 2) echo 'selected'?> >时令蔬菜</option>
									<option value="3" <?php if($stage == 3) echo 'selected'?> >有机蔬菜</option>
									<option value="4" <?php if($stage == 4) echo 'selected'?> >土特产品</option>
									<option value="5" <?php if($stage == 5) echo 'selected'?> >加工产品</option>
									<option value="6" <?php if($stage == 6) echo 'selected'?> >进口蔬菜</option>
									<option value="7" <?php if($stage == 7) echo 'selected'?> >其他扩展</option>
								</select>
								<input type="submit" value="搜索" style="font-size: 14px; border: 1px solid #A6B4FF; height:26px; width: 60px;" />
							</td>
						</tr>
					</table>
				</form>
			</div>
            <div class="content2">
            	<table width="100%">
                      <tr>
                        <th width="5%">编号</th>
                        <th width="10%">品名</th>
                        <th width="10%">图片</th>
                        <th width="10%">商家</th>
                        <th width="5%">分类</th>
                        <th width="5%">规格</th>
                        <th width="5%">价格</th>
                        <th width="5%">库存</th>
                        <th width="5%">推荐</th>
                        <th width="5%">上架</th>
                        <th width="8%">操作</th>
                      </tr>
                      <?php foreach ($goods as $row): ?>
                      <tr>
                        <td><?php echo $row->goods_id; ?></td>
                        <td><?php echo $row->name; ?></td>

                        <td><img src="<?php if ($row->pic) echo base_url(json_decode($row->pic)->default); ?>" width="60" /></td>
                        <td><?php echo $shop[$row->shop_id]->name; ?></td>
                        <td><?php echo $category[$row->class_id]->class_name; ?></td>
                        <td><?php echo $row->unit; ?></td>
                        <td><?php echo $row->price; ?></td>
                        <td><?php if ($row->stock === '0') {
                        	echo '无'; } else {echo '有';}?>
						</td>
                        <td><?php if ($row->is_today === '1') {
                        	echo '是'; } else {echo '否';}?>
						</td>
						<td><?php if ($row->sold === '1') {
                        	echo '是'; } else {echo '否';}?>
						</td>
                        <td><a href="<?php echo base_url('/admin/goods/edit_goods?goods_id=' .$row->goods_id); ?>">编辑</a>
                        	<a onclick="return del_alert()" href="<?php echo base_url('/admin/goods/del_goods?goods_id=' .$row->goods_id); ?>">删除</a>
                        	<a href="<?php echo base_url('/admin/goods/in_out_stock?goods_id=' .$row->goods_id); ?>">
                        	<?php if ($row->stock === '0') {
                        	echo '有货';} else {echo '缺货';}?></a>
                        </td>
                      </tr>
                      <?php endforeach;?>
                 </table>
                 <center><?php echo $page; ?></center>
            </div>
        </div>

<?php load_view('admin/common/footer'); ?>