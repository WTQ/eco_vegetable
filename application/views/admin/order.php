<!-- 订单管理页面 -->
<?php load_view('admin/common/header'); ?>	
		<div class="content">
			<div class="content1">
            	<a href="<?php echo base_url('/admin/order/gen_excel/?'.$keywords); ?>">导出</a>
        	</div>	

			<div class="content2">
				<form action="<?php echo base_url('admin/order/'); ?>" method="get">
					<table width="100%">
						<tr>
							<td width="90%">订单状态：
								<select name="stage" style="width:90%">
									<option value="0">请选择</option>
									<option value="1" <?php if($stage == 1) echo 'selected'?> >已提交</option>
									<option value="2" <?php if($stage == 2) echo 'selected'?> >已发货</option>
									<option value="3" <?php if($stage == 3) echo 'selected'?> >已完成</option>
									<option value="4" <?php if($stage == 4) echo 'selected'?> >已取消</option>
									<option value="5" <?php if($stage == 5) echo 'selected'?> >已确认</option>
								</select>
							</td>
							<td>
								<input type="submit" value="搜索" style="font-size: 14px; border: 1px solid #A6B4FF; height:26px; width: 60px;" />
							</td>
						</tr>
					</table>
				</form>
			</div>

			<div class="content2">
				<table width="100%">
					<tr>
						<td width="6%">订单号</td>
						<td width="28%">订单商品</td>
						<td width="8%">姓名</td>
						<td width="10%">联系方式</td>
						<td width="15%">配送地址</td>
						<td width="8%">订单金额</td>
						<td width="10%">下单时间</td>
						<td width="6%">状态</td>
						<td>操作</td>
					</tr>
					<?php foreach ($orders as $order): ?>
					<tr>
						<td><?php echo $order['order_id'];?></td>
						<td>
							<?php foreach ($order['items'] as $item): ?>
	        						<?php echo $item['name']?> <font color="red">单价：<?php echo '￥' . $item['price']; ?></font> x <?php echo $item['quantity']?><br />
	        						<?php endforeach; ?>
	        					</td>
								<td><?php echo $order['username'];?></td>
						<td><?php echo $order['phone']; ?></td>
						<td><?php echo $order['address'];?></td>
						<td><?php echo '￥' . $order['total_prices'];?></td>
						<td><?php echo date('Y-m-d H:i:s', $order['add_time']);?></td>
						<td><?php echo get_stage($order['stage']); ?></td>
						<td>
							<a href="<?php echo base_url('/admin/order/edit_v/?order_id=' . $order['order_id']); ?>">编辑状态</a>
						</td>
					</tr>
					<?php endforeach;?>
				</table>
				<div class="page">
					<?php echo $page_html; ?>
	
				</div>
			</div>

		</div>
		
<?php load_view('admin/common/footer'); ?>