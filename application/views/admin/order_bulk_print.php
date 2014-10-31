<!-- 订单管理页面 -->
<?php load_view('admin/common/header'); ?>	
		<div class="content">
			<div class="content1" style="width:100%!important;height:50px!important;">
				<div class="left bulk_back">
					<a href="<?php echo base_url('/admin/order?'.$keywords); ?>">返回</a>
				</div>
				<div class="left bulk_print">
					<a href="javascript:;" onClick="doPrint()">批量打印</a>
				</div>
				<div class="cl"></div>
        	</div>	
 
        	<!--startprint-->
			<div class="content2">
				<table width="100%" class="print_table1">
					<tr>
						<th width="10%">订单号</th>
						<th width="30%">订单商品</th>
						<th width="5%">联系方式</th>
						<th width="15%">配送地址</th>
						<th width="15%">配送时间</th>
						<th width="5%">订单金额</th>
						<th width="20%">下单时间</th>
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
						<td><?php echo $order['delivery_time'];?></td>
						<td><?php echo '￥' . $order['total_prices'];?></td>
						<td><?php echo date('Y-m-d H:i:s', $order['add_time']);?></td>
					</tr>
					<?php endforeach;?>
				</table>
			</div>
			<!--endprint-->
		</div>
		
<?php load_view('admin/common/footer'); ?>