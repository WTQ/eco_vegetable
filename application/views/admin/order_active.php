<!-- 订单管理页面 -->
<?php load_view('admin/common/header'); ?>
		<div class="content">
			<div class="content1" style="width:100%!important;height:50px!important;">
				<div class="left content1_print">
					<a href="<?php echo base_url('/admin/order/order_goods'); ?>">订单商品统计</a>
				</div>
				<div class="cl"></div>
        	</div>	
			<div class="content2">
				<form action="<?php echo base_url('admin/order/order_goods/'); ?>" method="get">
					<table width="100%">
						<tr>
							<td width="80%">订单状态：
								<select name="month">
										<option value="0" <?php if($month == 0) echo 'selected'?>>全部</option>
										<option value="1" <?php if($month == 1) echo 'selected'?> >一月</option>
										<option value="2" <?php if($month == 2) echo 'selected'?> >二月</option>
										<option value="3" <?php if($month == 3) echo 'selected'?> >三月</option>
										<option value="4" <?php if($month == 4) echo 'selected'?> >四月</option>
										<option value="5" <?php if($month == 5) echo 'selected'?> >五月</option>
										<option value="6" <?php if($month == 6) echo 'selected'?> >六月</option>
										<option value="7" <?php if($month == 7) echo 'selected'?> >七月</option>
										<option value="8" <?php if($month == 8) echo 'selected'?> >八月</option>
										<option value="9" <?php if($month == 9) echo 'selected'?> >九月</option>
										<option value="10" <?php if($month == 10) echo 'selected'?>>十月</option>
										<option value="11" <?php if($month == 11) echo 'selected'?>>十一月</option>
										<option value="12" <?php if($month == 12) echo 'selected'?>>十二月</option>
								</select>
								<select name="month_type">
									<option value="0" <?php if($month_type == 0) echo 'selected'?> >全部</option>
									<option value="1" <?php if($month_type == 1) echo 'selected'?> >前半个月</option>
									<option value="2" <?php if($month_type == 2) echo 'selected'?> >后半个月</option>
								</select>
								&nbsp;&nbsp;&nbsp;&nbsp;
								<input class="Wdate" name="date" placeholder="选择日期" onClick="WdatePicker()">
								<input type="submit" value="搜索" style="font-size: 14px; border: 1px solid #A6B4FF; height:26px; width: 60px;" />
							</td>
						</tr>
					</table>
				</form>
			</div>
				<div class="content2">
					<table width="100%" id="order_list">
						<tr>
							<th width="10%">用户名</th>
							<th width="30%">配送地址</th>
							<th width="10%">商品分类</th>
							<th width="25%">商品名称</th>
							<th width="5%">商品数量</th>
							<th width="5%">金额（元）</th>
							<th width="5%">总金额</th>
						</tr>
						<?php $phone = '';$class = '';$total_prices = '';?>
						<?php foreach ($orders as $order): ?>
						<tr>
							<td><?php if($phone != $order['phone']):
							 			echo $order['phone'];
										$phone = $order['phone'];
										else: echo '';endif;?>
							</td>
							<td><?php echo $order['address'];?></td>
							<td><?php echo $order['class']; ?></td>
							<td><?php echo $order['name'];?></td>
							<td><?php echo $order['quantity'];?></td>
							<td><?php echo $order['quantity']*$order['price'];?></td>
							<td><?php if($class != $order['class']||$total_prices != $order['total_prices']):
							 			echo $order['total_prices'];
										$class = $order['class'];
										$total_prices = $order['total_prices'];
									  else: echo ''; endif; ?></td>
						</tr>
						<?php endforeach;?>
					</table>
				</div>
			<!--endprint-->
		</div>
	</div>

<?php load_view('admin/common/footer'); ?>
