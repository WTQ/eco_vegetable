<!-- 订单管理页面 -->
<?php load_view('admin/common/header'); ?>	
		<div class="content">
			<div class="content1">
            	<a href="<?php echo base_url('/admin/order/order_goods/'); ?>">商品统计</a>
        	</div>	
        	<!--<div class="content11">
            	<a href="javascript:printme()" target="_self">打印</a>
            	<a href="javascript:;" onClick="doPrint()">打印</a> 
        	</div>-->	
        	<!--startprint-->
				<div class="content2">
					<form action="<?php echo base_url('admin/order/'); ?>" method="get">
						<table width="100%">
							<tr>
								<td width="81%">订单状态：
									<select name="stage">
										<option value="0">全部</option>
										<option value="1" <?php if($stage == 1) echo 'selected'?> >已提交</option>
										<option value="2" <?php if($stage == 2) echo 'selected'?> >已发货</option>
										<option value="3" <?php if($stage == 3) echo 'selected'?> >已完成</option>
										<option value="4" <?php if($stage == 4) echo 'selected'?> >已取消</option>
										<option value="5" <?php if($stage == 5) echo 'selected'?> >已确认</option>
									</select>
									<input type="submit" value="搜索" style="font-size: 14px; border: 1px solid #A6B4FF; height:26px; width: 60px;" />
								</td>
								<td>
									<a href="<?php echo base_url('/admin/order/gen_excel/?'.$keywords); ?>">导出excel表格</a>
								</td>
							</tr>
						</table>
					</form>
				</div>
	
				<div class="content2">
					<table width="100%">
						<tr>
							<th width="7%">订单号</th>
							<th width="32%">订单商品</th>
							<th width="6%">联系方式</th>
							<th width="15%">配送地址</th>
							<th width="6%">订单金额</th>
							<th width="11%">下单时间</th>
							<th width="7%">状态</th>
							<th>操作</th>
						</tr>
						<?php foreach ($orders as $order): ?>
						<tr>
							<td><?php echo $order['order_id'];?></td>
							<td>
								<?php foreach ($order['items'] as $item): ?>
		        						<?php echo $item['name']?> <font color="red">单价：<?php echo '￥' . $item['price']; ?></font> x <?php echo $item['quantity']?><br />
		        						<?php endforeach; ?>
		        					</td>
							<td><?php echo $order['phone']; ?></td>
							<td><?php echo $order['address'];?></td>
							<td><?php echo '￥' . $order['total_prices'];?></td>
							<td><?php echo date('Y-m-d H:i:s', $order['add_time']);?></td>
							<td><?php echo get_stage($order['stage']); ?></td>
							<td>
								<a href="<?php echo base_url('/admin/order/edit_v/?order_id=' . $order['order_id']); ?>">编辑</a>&nbsp;&nbsp;<a href="<?php echo base_url('/admin/order/detail?id='.$order['order_id']); ?>">打印</a>
							</td>
						</tr>
						<?php endforeach;?>
					</table>
					<div class="page">
						<?php echo $page_html; ?>
		
					</div>
				</div>
			<!--endprint-->
		</div>
	</div>
		
<?php load_view('admin/common/footer'); ?>