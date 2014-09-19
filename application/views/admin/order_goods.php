<!-- 订单商品统计页面 -->
<?php load_view('admin/common/header'); ?>
		<div class="content">
			<div class="content1 content_row">
            	<a href="<?php echo base_url('/admin/order/'); ?>">订单统计</a>
        	</div>
        	<div class="content1 content_row">
            	<a href="<?php echo base_url('/admin/order/order_goods/'); ?>">订单商品统计</a>
        	</div>	
        	<!--<div class="content11">
            	<a href="javascript:printme()" target="_self">打印</a>
            	<a href="javascript:;" onClick="doPrint()">打印</a> 
        	</div>-->	
        	<!--startprint-->
				<div class="content2">
					<form action="<?php echo base_url('admin/order/order_goods/'); ?>" method="get">
						<table width="100%">
							<tr>
								<td width="90%">订单状态：
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
							</tr>
						</table>
					</form>
				</div>
	
				<div class="content2">
					<table width="100%">
						<tr>
							<th width="33%">订单商品</th>
							<th width="33%">商品数量</th>
							<th>商品分类</th>
						</tr>
						<?php foreach ($orders as $order): ?>
						<tr>							
							<td>									
			        			<?php echo $order['name']?><br />				
		        			</td>
							<td>
								<?php echo $order['SUM(quantity)']?>
							</td>
							<td>
								<?php echo $order['class_name']?>
							</td>
						</tr>
						<?php endforeach;?>
					</table>
				</div>
			<!--endprint-->
		</div>
	</div>
		
<?php load_view('admin/common/footer'); ?>