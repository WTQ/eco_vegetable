<?php load_view('admin/common/header'); ?>

        <div class="content">
            <div class="content1">
        	<a href="http://o2o/admin/zone">返回</a>
        	</div>
            <div class="content2">
	            <?php echo form_open_multipart($form_url); ?>
	            	<table width="100%">
						<tr>
							<td>排行</td>
							<td><input class="list_select" size="30" type="text" name="rank" value="<?php echo $now['rank'] ?>"/></td>
						</tr>
						<tr>
							<td>行政区</td>
							<td>
								<select class="list_select" name="district">
								<?php foreach ($district as $row):?>
								<option value="<?php echo $row->district_id?>" <?php echo ($row->district_id == $now['district']) ? 'selected':'' ;?>><?php echo ($row->name)?></option>
								<?php endforeach;?>
								</select>
							</td>
						</tr>
						<tr>
							<td>商业区</td>
							<td>
								<select class="list_select" name="block">
								<?php foreach ($block as $row):?>
								<option value="<?php echo $row->block_id?>" <?php echo ($row->block_id == $now['block']) ? 'selected':'' ;?>><?php echo ($row->name)?></option>
								<?php endforeach;?>		
								</select>					
							</td>
						</tr>
						<tr>
							<td>小区</td>
							<td><input class="list_select" size="30" type="text" name="community" value="<?php echo $now['community']?>" /></td>
						</tr>
	                 </table>
	                 <div class="button"><button class="list_select" type="submit">提交</button></div>
	            </form>
            </div>
        </div>
        
<?php load_view('admin/common/footer'); ?>
