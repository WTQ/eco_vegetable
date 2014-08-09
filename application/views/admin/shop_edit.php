<!-- 商铺编辑/添加页面 -->
<?php load_view('admin/common/header'); ?>

<div class="content">
	<div class="content1">
		<a href="<?php echo base_url('admin/shop'); ?>">返回</a>
	</div>
        <div class="content2">
        <?php echo form_open_multipart($shop['form_url']); ?>
        	<table width="100%" border="1" height="400">
				<!--<tr>
					<td class="name">选择社区</td>
					 TODO  联动下拉列表 
					<td class="detail">
						<select name="district" class="list_select">
						<?php foreach ($district as $row): ?>
							<option value="<?php echo $row->district_id?>" <?php echo ($row->district_id == $shop['district']) ? 'selected':'' ;?>><?php echo ($row->name)?></option>
							
						<?php endforeach;?>
						</select>
						<select name="block" class="list_select">
						<?php foreach ($block as $row): ?>
							<option value="<?php echo $row->block_id?>" <?php echo ($row->block_id == $shop['block']) ? 'selected':'' ;?>><?php echo ($row->name)?></option>
							
						<?php endforeach;?>
						</select>
						<select name="community" class="list_select">
						<?php foreach ($community as $row): ?>
							<option value="<?php echo $row->community_id?>" <?php echo ($row->community_id == $shop['community']) ? 'selected':'' ;?>><?php echo ($row->name)?></option>
							
						<?php endforeach;?>
						</select>
					</td>
				</tr>-->
				<tr>
					<td class="name">商铺名称</td>
					<td class="detail"><input name="shop_name" type="text" class="list_select" value="<?php echo $shop['name'];?>" size="80" /></td>
				</tr>
				<tr>
					<td class="name">负责人</td>
					<td class="detail" width="91%"><input name="manager" type="text" class="list_select" value="<?php echo $shop['manager'];?>" size="80" /></td>
				</tr>
				<tr>
					<td class="name">地址</td>
					<td class="detail" width="91%"><input name="address" type="text" class="list_select" value="<?php echo $shop['address'];?>" size="80" /></td>
				</tr>
				<tr>
					<td class="name">电话</td>
					<td class="detail" width="91%"><input name="phone" type="text" class="list_select" value="<?php echo $shop['phone'];?>" size="80" /></td>
				</tr>
				<tr>
					<td class="name">营业时间</td>
					<td class="detail" width="91%">
						<span class="red">*如营业上午8点至晚上20点，则上下栏分别输入 8:00 和 20:00（英文输入状态）</span><br />
						开始营业时间：<input name=start_time type="text" class="list_select" value="<?php if ($shop['shop_hours'] !== '') echo ( (json_decode($shop['shop_hours'])->start_time) ); ?>" size="10" /><br />
						结束营业时间：<input name=close_time type="text" class="list_select" value="<?php if ($shop['shop_hours'] !== '') echo ( (json_decode($shop['shop_hours'])->close_time) ); ?>" size="10" />
					</td>
				</tr>
				<tr>
					<td class="name">商家介绍</td>
					<td class="detail" width="91%"><textarea class="list_select" name="discript" rows="4" cols="70"><?php echo $shop['discript'];?></textarea></td>
				</tr>
				<!-- <tr>
					<td class="name">商铺图片</td>
					<td class="detail"><input name="shop_pic" type="file" class="list_select" value="" size="80" /></td>
				</tr> -->
            </table>
            <div class="button"><button type="submit" class="submit">提交</button></div>
        </div>
	</div>

<?php load_view('admin/common/footer'); ?>