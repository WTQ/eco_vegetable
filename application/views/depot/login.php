<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>管理员登陆</title>
<link href="<?php echo base_url('/static/admin/css/login.css'); ?>" rel="stylesheet" type="text/css" />
</head>

<body>
	<div id="login">
		<h1>管理员登录</h1>
		<div class="login_error"><?php echo isset($error) ? $error : ''; ?></div>
   		<?php echo form_open(base_url('/depot/login'));?>
    
			<table width="290" border="0" align="center" cellpadding="6"
				cellspacing="0">
				<tr>
					<td width="60">用户名：</td>
					<td><label> <input name="username" type="text" class="input_1" id="username" />
					</label></td>
				</tr>
				<tr>
					<td>密&nbsp;&nbsp;&nbsp;&nbsp;码：</td>
					<td><label> <input name="password" type="password" class="input_1" id="password" />
					</label></td>
				</tr>
				<tr>
					<td>验证码：</td>
					<td><input name="admin_img_check" type="text" id="usercheck"
						class="input_1 input_2" size="7" /><img class="captcha" src="<?php echo base_url('/depot/login/captcha'); ?>" /></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td><label>
							<button type="submit" class="login_submit" value="啊啊">登&nbsp;&nbsp;录</button>
					</label></td>
				</tr>
			</table>
		</form>
	</div>
</body>
</html>