
	<div id="right">
		<div id="content">
			<div class="title_2">订单编辑</div>
			<div class="content">
				<div>
					<?php echo form_open($form_url);?>
						<table width="100%" border="0" cellpadding="0" cellspacing="0">
							<tr class="title_3">
								<td colspan="2">编辑订单内容</td>
							</tr>
							<tr>
								<td width="12%">订单号</td>
								<td><?php echo $Order['order_id'];?></td>
							</tr>
							<tr>
								<td>总价</td>
								<td>￥<?php echo $Order['total_prices']; ?></td>
							</tr>
							<tr>
								<td>姓名</td>
								<td><?php echo $Order['user_name'];?></td>
							</tr>
							<tr>
								<td>电话</td>
								<td><?php echo $Order['phone'];?></td>
							</tr>
							<tr>
								<td>买家备注</td>
								<td><?php echo $Order['remarks'];?></td>
							</tr>
							<tr>
								<td>订单状态</td>
								<td>
									<select name="stage">
										<option value="0">请选择</option>
										<option value="1" <?php if($Order['stage'] == 1) echo 'selected'?> >已提交</option>
										<option value="2" <?php if($Order['stage'] == 2) echo 'selected'?> >已发货</option>
										<option value="3" <?php if($Order['stage'] == 3) echo 'selected'?> >已完成</option>
										<option value="4" <?php if($Order['stage'] == 4) echo 'selected'?> >已取消</option>
										<option value="5" <?php if($Order['stage'] == 5) echo 'selected'?> >已确认</option>
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