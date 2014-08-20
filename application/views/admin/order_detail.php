<!-- 订单管理页面 -->
<?php load_view('admin/common/header'); ?>	
		<div class="content">
			<div class="content1">
            	<a href="javascript:;" onClick="doPrint()">打印</a>
        	</div>	
 
        	<!--startprint-->
        	<div id="print">
				<div class="content3">
					<table width="100%">
						<tr>
							<th width="12%">订单号：<?php echo $orders['order_id'];?></th>
							<th width="35%">下单时间：<?php echo date('Y-m-d H:i:s', $orders['add_time']);?></th>
							<th width="40%">客户姓名：<?php echo $orders['username'];?></th>
							<th>商品总数：<?php echo $orders['num'];?></th>
						</tr>
					</table>
				</div>
                
                <div class="content3">
					<table width="100%">
						<tr>
							<th width="100%" style="padding-bottom:10px">配送地址：<?php echo $orders['address'];?></th>
						</tr>
					</table>
				</div>
	
				<div class="content2">
					<table width="100%">
						<tr>
							<th width="8%">商品编号</th>
							<th width="56%">商品名称</th>
							<th width="8%">数量</th>
							<th width="14%">价格（元）</th>
							<th>小计（元）</th>
						</tr>
						<?php foreach ($orders['items'] as $item): ?>
							<tr>
								<td><?php echo $item['goods_id'];?></td>
								<td><?php echo $item['name'];?></td>
								<td><?php echo $item['quantity'];?></td>
								<td><?php echo $item['price']; ?></td>
								<td><?php echo $item['total_prices'];?></td>
							</tr>
						<?php endforeach;?>
						
					</table>
				</div>
				
				<div class="content3">
						<table width="100%">
							<tr>
								<th width="90%" style="text-align: right;">订单总价：</th>
								<th style="text-align: center;"><?php echo $orders['total_prices'];?>&nbsp;&nbsp;元</th>
							</tr>
						</table>
					</div>
			</div>
			<!--endprint-->
		</div>
		
<?php load_view('admin/common/footer'); ?>