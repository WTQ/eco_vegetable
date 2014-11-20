<!-- 订单编辑页面 -->
<?php load_view('admin/common/header'); ?>
	<div id="right">
		<div id="content">
			<div class="content1"></div>
			<div class="content2">
				<div>
					<?php echo form_open($form_url);?>
						<table width="100%">
							<tr class="title_3">
								<td colspan="2">编辑订单内容</td>
							</tr>
							<tr>
								<td width="12%">订单号</td>
								<td><?php echo $Order->order_id;?></td>
							</tr>
							<tr>
								<td>总价</td>
								<td>￥<?php echo $Order->total_prices; ?></td>
							</tr>
							<tr>
								<td>姓名</td>
								<td><?php echo $Order->username;?></td>
							</tr>
							<tr>
								<td>电话</td>
								<td><?php echo $Order->phone;?></td>
							</tr>
							<tr>
								<td>配送地址</td>
								<td><?php echo $Order->address;?></td>
							</tr>
							<tr>
								<td>订单状态</td>
								<td>
									<select name="stage">
										<option value="1" <?php if($Order->stage == 1) echo 'selected'?> >已下单</option>
										<option value="2" <?php if($Order->stage == 2) echo 'selected'?> >已发货</option>
										<option value="3" <?php if($Order->stage == 3) echo 'selected'?> >已完成</option>
										<option value="4" <?php if($Order->stage == 4) echo 'selected'?> >用户已取消</option>
										<option value="5" <?php if($Order->stage == 5) echo 'selected'?> >商家已取消</option>
										<option value="6" <?php if($Order->stage == 6) echo 'selected'?> >未完成</option>
										<option value="7" <?php if($Order->stage == 7) echo 'selected'?> >在线未付款</option>
										<option value="8" <?php if($Order->stage == 8) echo 'selected'?> >已在线付款</option>
									</select>
								</td>
							</tr>
						</table>
						<div class="button"><button type="submit">提交</button></div>
					</form>
				</div>
			</div>
		</div>
	</div>
<?php load_view('admin/common/footer'); ?>
