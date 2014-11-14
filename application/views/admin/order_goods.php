<!-- 订单商品统计页面 -->
<?php load_view('admin/common/header'); ?>
		<div class="content">
			<div class="content1" style="width:100%;">
            	<div class="left content1_print"><a href="<?php echo base_url('/admin/order/'); ?>">订单统计</a></div>
            	<form class="left form_1" action="<?php echo base_url('admin/order/order_goods?stage='.$stage.'&sort_stage='.$sort_stage)?>" method="get" >
            		<select name="type" class="left list_select">
            			<option value="0" <?php if($type=='0'): echo 'selected'; endif;?>>按商品名搜索</option>
            			<option value="1" <?php if($type=='1'): echo 'selected'; endif;?>>按地址搜索</option>
            		</select>
            		<div class="left"><input class="search_input2" size="30" type="text" name="search" value="<?php if($keywords): echo $keywords; endif;?>" onmouseover=this.focus(); onclick="value=''; this.style.color='#000'"   onBlur="if(!value){value=defaultValue; this.style.color='#999'}"style="color:#999" /></div>
            		<div class="left"><input class="search_sub2" type="submit" name="submit" value=""/></div>
            		<div class="cl"></div>
            	</form>	
            	<div class="cl"></div>
        	</div>
        	
        	<!--<div class="content11">
            	<a href="javascript:printme()" target="_self">打印</a>
            	<a href="javascript:;" onClick="doPrint()">打印</a> 
        	</div>-->	
        	
			<div class="content2">
				<form action="<?php echo base_url('admin/order/order_goods/'); ?>" method="get">
					<table width="100%">
						<tr>
							<td width="80%">订单状态：
								<select name="stage">
									<option value="0">全部</option>
									<option value="7" <?php if($stage == 7) echo 'selected'?> >在线未付款</option>
									<option value="8" <?php if($stage == 8) echo 'selected'?> >已在线付款</option>
									<!-- <option value="1" <?php if($stage == 1) echo 'selected'?> >已提交</option>
									<option value="2" <?php if($stage == 2) echo 'selected'?> >已发货</option>
									<option value="3" <?php if($stage == 3) echo 'selected'?> >已完成</option>
									<option value="4" <?php if($stage == 4) echo 'selected'?> >已取消</option>
									<option value="5" <?php if($stage == 5) echo 'selected'?> >已确认</option> -->
								</select>
								<select name="sort_stage">
										<option value="0" <?php if($sort_stage == 0) echo 'selected'?>>全部</option>
										<option value="1" <?php if($sort_stage == 1) echo 'selected'?> >田园时蔬</option>
										<option value="2" <?php if($sort_stage == 2) echo 'selected'?> >食用菌菇</option>
										<option value="3" <?php if($sort_stage == 3) echo 'selected'?> >有机蔬菜</option>
										<option value="4" <?php if($sort_stage == 4) echo 'selected'?> >时鲜水果</option>
										<option value="5" <?php if($sort_stage == 5) echo 'selected'?> >粮油副食</option>
										<option value="6" <?php if($sort_stage == 6) echo 'selected'?> >南北干货</option>
										<option value="7" <?php if($sort_stage == 7) echo 'selected'?> >营养保健</option>
										<option value="8" <?php if($sort_stage == 8) echo 'selected'?> >地方特产</option>
										<option value="9" <?php if($sort_stage == 8) echo 'selected'?> >生活用品</option>
								</select>
								<select name="month">
										<option value="0" <?php if($month == 0) echo 'selected'?>>全部</option>
										<option value="1" <?php if($month == 1) echo 'selected'?> >一月</option>
										<option value="2" <?php if($month == 2) echo 'selected'?> >二月</option>
										<option value="3" <?php if($month == 3) echo 'selected'?> >三月</option>
										<option value="4" <?php if($month == 4) echo 'selected'?> >四月</option>
										<option value="5" <?php if($month == 5) echo 'selected'?> >五月</option>
										<option value="6" <?php if($month == 6) echo 'selected'?> >六月</option>
										<option value="7" <?php if($month == 7) echo 'selected'?> >七月</option>
										<option value="8" <?php if($month == 8) echo 'selected'?> >八月</option>
										<option value="9" <?php if($month == 9) echo 'selected'?> >九月</option>
										<option value="10" <?php if($month == 10) echo 'selected'?>>十月</option>
										<option value="11" <?php if($month == 11) echo 'selected'?>>十一月</option>
										<option value="12" <?php if($month == 12) echo 'selected'?>>十二月</option>
								</select>
								<input type="submit" value="搜索" style="font-size: 14px; border: 1px solid #A6B4FF; height:26px; width: 60px;" />
							</td>
							<td>
								<a href="<?php echo base_url('/admin/order/goods_excel?'.$keywords); ?>">导出表格</a>&nbsp;&nbsp;&nbsp;&nbsp;
								<a href="<?php echo base_url('/admin/order/goods_statistic_print?'.$keywords); ?>">打印本页</a>
							</td>
						</tr>
					</table>
				</form>
			</div>
				
				<div class="content2">
					<table width="100%">
						<tr>
							<th width="30%">订单商品</th>
							<th width="30%">商品数量</th>
							<th width="30%">商品分类</th>
							<th width="10%">操作</th>
						</tr>
						<?php if(!empty($orders)):?>
						<?php foreach ($orders as $order): ?>
						<tr>							
							<td>									
			        			<?php echo $order['name']?><br />				
		        			</td>
							<td>
								<?php echo $order['quantity']?>
							</td>
							<td>
								<?php echo $order['class_name']?>
							</td>
							<td>
								<a onclick="return del_alert()" href="<?php echo base_url('/admin/order/del_all?&name='.$order['name'])?>">删除</a>
							</td>
						</tr>
						<?php endforeach;?>
						<?php endif;?>
					</table>
				</div>
		</div>
		
<?php load_view('admin/common/footer'); ?>