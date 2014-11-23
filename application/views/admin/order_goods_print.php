<!-- 订单商品统计打印页面 -->
<?php load_view('admin/common/header'); ?>	
		<div class="content">
			<div class="content1" style="width:100%!important;height:50px!important;">
				<div class="left bulk_back">
					<a href="<?php echo base_url('/admin/order/order_goods/'); ?>">返回</a>
				</div>
				<div class="left bulk_print">
					<a href="javascript:;" onClick="doPrint()">打印</a>
				</div>
				<div class="cl"></div>
        	</div>	
 
        	<!--startprint-->
				<div class="content2">
					<table width="100%" class="print_table1">
						<tr>
							<th width="30%">订单商品</th>
							<th width="15%">商品数量</th>
							<th width="30%">商品分类</th>
							<th width="15%">总金额（元）</th>
						</tr>
						<?php foreach ($orders as $order): ?>
						<tr>							
							<td>									
			        			<?php echo $order['name']?><br />				
		        			</td>
							<td>
								<?php echo $order['quantity']?>
							</td>
							<td>
								<?php echo $order['class_name']?>
							</td>
							<td>
								<?php echo $order['quantity']*$order['price'];?>
							</td>
						</tr>
						<?php endforeach;?>
					</table>
				</div>
			<!--endprint-->
		</div>
		
<?php load_view('admin/common/footer'); ?>