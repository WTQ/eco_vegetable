<!-- Admin端商品编辑/添加页面 -->
<?php load_view('depot/common/header'); ?>

<link rel="stylesheet" href="<?php echo base_url('/static/admin/css/uploadify.css'); ?>" type="text/css" />
<script src="<?php echo base_url('/static/admin/js/jquery.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('/static/admin/js/jquery.uploadify.min.js'); ?>"></script>

<div class="content">
	<div class="content1">
		<a href="<?php echo base_url('depot/goods'); ?>">返回</a>
	</div>
        <div class="content2">
        <?php echo form_open_multipart($goods['form_url']); ?>
        	<table width="100%" border="1" height="400">
				<tr>
					<td class="name">商品名称</td>
					<td class="detail"><input name="name" class="list_select" type="text" value="<?php echo $goods['name'];?>" size="80" /></td>
				</tr>
				<tr>
					<td class="name">商品规格</td>
					<td class="detail"><input name="unit" class="list_select" type="text" value="<?php echo $goods['unit'];?>" size="80" /></td>
				</tr>
				<tr>
					<td class="name">商品价格（元）</td>
					<td class="detail" width="91%"><input name="price" class="list_select" type="text" value="<?php echo $goods['price'];?>" size="10" /></td>
				</tr>
				<tr>
					<td class="name">商品介绍</td>
					<td class="detail" width="91%"><textarea name="intro" class="list_select" rows="8" cols="70"><?php echo $goods['intro'];?></textarea></td>
				</tr>
				<tr>
					<td class="name">商品条码</td>
					<td class="detail" width="91%"><input name="barcode" class="list_select" type="text" value="<?php echo $goods['barcode'];?>" size="80" /></td>
				</tr>
				<tr>
					<td class="name">商品图片</td>
					<td class="detail">
					<?php if( isset($goods['pic']) && ($goods['pic']->default !== '') ) {?>
					<img src="<?php echo base_url($goods['pic']->default);?>" width="60" /><?php }?>
					<input name="pic1" type="file" value="" size="5" /><br />
					<?php if( isset($goods['pic']) && ($goods['pic']->more->pic1 !== '') ) {?>
					<img src="<?php echo base_url($goods['pic']->more->pic1);?>" width="60" /><?php }?>
					<input name="pic2" type="file" value="" size="5" /><br />
					<?php if( isset($goods['pic']) && ($goods['pic']->more->pic2 !== '') ) {?>
					<img src="<?php echo base_url($goods['pic']->more->pic2);?>" width="60" /><?php }?>
					<input name="pic3" type="file" value="" size="5" /><br />
					<?php if( isset($goods['pic']) && ($goods['pic']->more->pic3 !== '') ) {?>
					<img src="<?php echo base_url($goods['pic']->more->pic3);?>" width="60" /><?php }?>
					<input name="pic4" type="file" value="" size="5" /><br />
					<?php if( isset($goods['pic']) && ($goods['pic']->more->pic4 !== '') ) {?>
					<img src="<?php echo base_url($goods['pic']->more->pic4);?>" width="60" /><?php }?>
					<input name="pic5" type="file" value="" size="5" /><br />
					</td>
				</tr>
            </table>
            <div class="button"><button type="submit">提交</button></div>
        </div>
	</div>

<?php load_view('depot/common/footer'); ?>