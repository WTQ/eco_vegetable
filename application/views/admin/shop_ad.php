<!-- 商家首页推荐信息 -->
<?php load_view('admin/common/header'); ?>
<script type=text/javascript src="<?php echo base_url('/static/ueditor/editor_config.js'); ?>"></script>
<script type=text/javascript src="<?php echo base_url('/static/ueditor/editor_all_min.js'); ?>"></script>
        <div class="content">
        	<div class="content1">
        	<a href="<?php echo base_url('admin/shop'); ?>">返回</a>
        	</div>
            <div class="content2">
	            <?php echo form_open_multipart($form_url); ?>
	            	<table width="100%">
						<tr>
							<td>首页内容</td>
							<td width="91%"><script type="text/plain" id="ue_content" name="ue_content"><?php echo $shop_ad; ?></script></td>
						</tr>
					</table>
	                 <div class="button"><button class="list_select" type="submit">提交</button></div>
	            </form>
	            
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
