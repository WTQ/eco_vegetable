<!-- 订单管理页面 -->
<?php load_view('admin/common/header'); ?>
		<div class="content">
			<div class="content1" style="width:100%!important;height:50px!important;">
				<div class="left content1_print">
					<a href="<?php echo base_url('/admin/order/order_goods'); ?>">订单商品统计</a>
				</div>
				<div class="cl"></div>
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
								<td width="80%">订单状态：
									<select name="stage">
										<option value="0">全部</option>
										<!-- <option value="1" <?php if($stage == 1) echo 'selected'?> >已下单</option>
										<option value="2" <?php if($stage == 2) echo 'selected'?> >已发货</option>
										<option value="3" <?php if($stage == 3) echo 'selected'?> >已完成</option>
										<option value="4" <?php if($stage == 4) echo 'selected'?> >用户已取消</option>
										<option value="5" <?php if($stage == 5) echo 'selected'?> >商家已取消</option>
										<option value="6" <?php if($stage == 6) echo 'selected'?> >未完成</option> -->
										<option value="7" <?php if($stage == 7) echo 'selected'?> >在线未付款</option>
										<option value="8" <?php if($stage == 8) echo 'selected'?> >已在线付款</option>
									</select>
									<input autocomplete="off" id="search_input" name="search_input" type="search" placeholder="可输入配送地址" value = "<?php echo $search_input; ?>">
									&nbsp;&nbsp;&nbsp;&nbsp;
									<select name="date_type">
										<option value="0" <?php if($date_type == 0) echo 'selected'?> >0:00~24：00</option>
										<option value="1" <?php if($date_type == 1) echo 'selected'?> >11:00~23:00</option>
										<option value="2" <?php if($date_type == 2) echo 'selected'?> >昨23：00~今11:00</option>
										<option value="8" <?php if($date_type == 8) echo 'selected'?> >8:00~9:00</option>
										<option value="9" <?php if($date_type == 9) echo 'selected'?> >9:00~10:00</option>
										<option value="10" <?php if($date_type == 10) echo 'selected'?> >10：00~11:00</option>
										<option value="11" <?php if($date_type == 11) echo 'selected'?> >11：00~12:00</option>
										<option value="12" <?php if($date_type == 12) echo 'selected'?> >12：00~13:00</option>
										<option value="13" <?php if($date_type == 13) echo 'selected'?> >13：00~14:00</option>
										<option value="14" <?php if($date_type == 14) echo 'selected'?> >14：00~15:00</option>
										<option value="15" <?php if($date_type == 15) echo 'selected'?> >15：00~16:00</option>
										<option value="16" <?php if($date_type == 16) echo 'selected'?> >16：00~17:00</option>
										<option value="17" <?php if($date_type == 17) echo 'selected'?> >17：00~19:00</option>
										<option value="19" <?php if($date_type == 19) echo 'selected'?> >19：00~23:00</option>
									</select>
									<input class="Wdate" name="date" placeholder="选择日期" value="<?php echo $date; ?>" onClick="WdatePicker()">
									<input type="submit" value="搜索" style="font-size: 14px; border: 1px solid #A6B4FF; height:26px; width: 60px;" />
								</td>
								<td>
									<a href="<?php echo base_url('/admin/order/gen_excel?'.$keywords); ?>">导出表格</a>&nbsp;&nbsp;&nbsp;&nbsp;
									<!-- <a href="<?php echo base_url('/admin/order/gen_word?'.$keywords); ?>">批量打印</a> -->
									<a href="<?php echo base_url('/admin/order?print=1&'.$keywords); ?>">批量打印</a>
									<a onclick="return del_some()" href="#">批量删除</a>
								</td>
							</tr>
						</table>
					</form>
				</div>

				<div class="content2">
					<table width="100%" id="order_list">
						<tr>
							<th width="5%">订单号</th>
							<th width="20%">订单商品</th>
							<th width="5%">联系方式</th>
							<th width="10%">配送地址</th>
							<th width="10%">配送时间</th>
							<th width="6%">订单金额</th>
							<th width="18%">下单时间</th>
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
							<td><?php echo $order['delivery_time'];?></td>
							<td><?php echo '￥' . $order['total_prices'];?></td>
							<td><?php echo date('Y-m-d H:i:s', $order['add_time']);?></td>
							<td><?php echo get_stage($order['stage']); ?></td>
							<td style="text-align:center;">
								<a href="<?php echo base_url('/admin/order/edit_v/?p='.$p.'&order_id=' . $order['order_id']); ?>">编辑</a>&nbsp;
								<a href="<?php echo base_url('/admin/order/detail?id='.$order['order_id']); ?>">打印</a>
								<a onclick="return del_alert()" href="<?php echo base_url('/admin/order/del?p='.$p.'&id='.$order['order_id'])?>">删除</a>
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
