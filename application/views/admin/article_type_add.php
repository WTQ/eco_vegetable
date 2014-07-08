<?php load_view('admin/common/header'); ?>

        <div class="content">
            <div class="content1">
        	<a href="http://o2o/admin/article_type">返回</a>
        	</div>
            <div class="content2">
	            <?php echo form_open_multipart($form_url); ?>
	            	<table width="100%">
						<tr>
							<td>父节点</td>
							<td>
								<select class="list_select" name="pid">
									<option value="0">无父节点</option>
									<?php foreach ($types as $type): ?>
									<?php if($type['level'] < 3): ?>
									<option <?php if($pid == $type['tid']) echo 'selected="selected"';?> value="<?php echo $type['tid'];?>"><?php if($type['level'] == 2) echo '|--';?><?php echo $type['name']?></option>
									<?php endif; ?>
									<?php endforeach; ?>
								</select>
							</td>
						</tr>
						<tr>
							<td>类别名称</td>
							<td><input class="list_select" size="30" type="text" name="name" value="<?php echo $name;?>" /></td>
						</tr>
					</table>
	                 <div class="button"><button class="list_select" type="submit">提交</button></div>
	            </form>
            </div>
        </div>
        
<?php load_view('admin/common/footer'); ?>
