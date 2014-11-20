<?php load_view('admin/common/header'); ?>

        <div class="content">
        	<div class="content1">
        	<a href="/admin/article">返回</a>
        	</div>
            <div class="content2">
	            <?php echo form_open_multipart($form_url); ?>
	            	<table width="100%">
						<tr>
							<td width="9%">文章标题</td>
							<td><input class="list_select" name="title" type="text" value="<?php echo $title;?>" size="80" /></td>
						</tr>
						<tr>
							<td>文章类别</td>
							<td>
								<select class="list_select" name="type">
									<?php foreach ($types as $type): ?>
									<option <?php if($tid == $type['tid']) echo 'selected="selected"';?>  value="<?php echo $type['tid'];?>"><?php if($type['level'] == 2) echo '|--';if($type['level']==3) echo '&nbsp;&nbsp;&nbsp;&nbsp;|--'?><?php echo $type['name']; ?></option>
									<?php endforeach;?>
								</select>
							</td>
						</tr>
						<tr>
							<td>文章内容</td>
							<td width="91%"><script type="text/plain" id="ue_content" name="ue_content"><?php echo $content;?></script></td>
						</tr>
					</table>
	                 <div class="button"><button class="list_select" type="submit">提交</button></div>
	            </form>
	            <script type=text/javascript src="<?php echo base_url('/static/ueditor/editor_config.js'); ?>"></script>
				<script type=text/javascript src="<?php echo base_url('/static/ueditor/editor_all_min.js'); ?>"></script>
				<script type="text/javascript">
			    	var ue = new UE.ui.Editor();
				    $(function() {
						ue.render('ue_content');
						if(0){//navigator.userAgent.indexOf("Firefox") != -1) {
					    	setTimeout(function() {
									var ue_iframe = document.getElementById('baidu_editor_0').contentWindow.document;
									ue_iframe.designMode="off";
									ue_iframe.execCommand('enableObjectResizing', false, 'false');
								}
								,1500
					    	);
						}
				    })
				</script>
            </div>
        </div>
        
<?php load_view('admin/common/footer'); ?>
