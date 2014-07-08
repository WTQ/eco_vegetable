<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>O2O后台管理</title>
<link rel="stylesheet" href="<?php echo base_url('/static/admin/css/manager.css'); ?>">
<link rel=stylesheet href="<?php echo base_url('/static/ueditor/themes/default/ueditor.css'); ?>" />
<script src="<?php echo base_url('/static/admin/js/jquery.js'); ?>"></script>
<script src="<?php echo base_url('/static/admin/js/manager.js'); ?>"></script>
</head>

<body>
<div class="manager">
	<?php load_view('admin/common/left');?>
	
    <div class="right">
     	<div class="header">
    		<div class="pic">
            	<div class="user">
                	<div class="userimage"></div>
                    <div class="userinfo">
                    	<div class="username">
                        	用户名：<?php echo $username;?><br />
                            用户组：管理员
                        </div>
                        <a href="<?php echo base_url('admin/logout'); ?>" class="usersign">
                        	退出登录</a>
                    </div>
                    <div class="cl"></div>
                </div>
            </div>
        	<div class="item1">
            	About Us
            </div>
        	<div class="item">
            	我的消息
                <div class="menuitem">
        	   	        <div class="menuitem1">
            	        	<table width="400" border="0">
  					    	<tr>
    							<td><a href="#">4</a></td>
  							</tr>
  							<tr>
   						 		<td><a href="#">5</a></td>
  							</tr>
							</table>

            			</div>
       			    </div>
            </div>
        	<div class="item">
            	Menu Item
                	<div class="menuitem">
        	   	        <div class="menuitem1">
            	        	<table width="400" border="0">
  					    	<tr>
    						<td><a href="#">1</a></td>
  							</tr>
  							<tr>
   						 	<td><a href="#">2</a></td>
  							</tr>
  							<tr>
    						<td><a href="#">3</a></td>
 					 		</tr>
							</table>

            			</div>
       			    </div>
            </div>
       	    <div class="cl"></div>
    	</div>