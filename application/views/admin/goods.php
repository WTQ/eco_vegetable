<!-- 商品管理页面 -->
<?php load_view('admin/common/header'); ?>
		<div class="content">
        	<div class="content1 manage">
            	<a class="left" href="<?php echo base_url('/admin/goods/add_goods'); ?>">添加商品</a>
            	<form action="<?php echo base_url('admin/goods/goods_search')?>" method="get" >
	            	<div class="left"><input class="search_input2" size="30" type="text" name="search" value="<?php echo $keywords;?>" onmouseover=this.focus(); onclick="value=''; this.style.color='#000'"   onBlur="if(!value){value=defaultValue; this.style.color='#999'}"style="color:#999" /></div>
	            	<div class="left"><input class="search_sub2" type="submit" name="submit" value=""/></div>
	            	<div class="cl"></div>
	            </form>
	            <div class="cl"></div>
            </div>
            
            <div class="content2">
				<form action="<?php echo base_url('admin/goods/'); ?>" method="get">
					<table width="100%">
						<tr>商品数量：<?php echo($number);?></tr>
						<tr>
							<td width="90%">产品分类：
								<select name="stage">
									<option value="0" <?php if($stage == 0) echo 'selected'?>>全部</option>
									<option value="1" <?php if($stage == 1) echo 'selected'?> >田园时蔬</option>
									<option value="2" <?php if($stage == 2) echo 'selected'?> >食用菌菇</option>
									<option value="3" <?php if($stage == 3) echo 'selected'?> >有机蔬菜</option>
									<option value="4" <?php if($stage == 4) echo 'selected'?> >时鲜水果</option>
									<option value="5" <?php if($stage == 5) echo 'selected'?> >粮油副食</option>
									<option value="6" <?php if($stage == 6) echo 'selected'?> >南北干货</option>
									<option value="10" <?php if($stage == 10) echo 'selected'?> >牛奶乳品</option>
									<option value="7" <?php if($stage == 7) echo 'selected'?> >营养保健</option>
									<option value="8" <?php if($stage == 8) echo 'selected'?> >地方特产</option>
									<option value="11" <?php if($stage == 11) echo 'selected'?> >母婴用品</option>
									<option value="9" <?php if($stage == 9) echo 'selected'?> >生活用品</option>
								</select>
								<input type="submit" value="搜索" style="font-size: 14px; border: 1px solid #A6B4FF; height:26px; width: 60px;" />
							</td>
						</tr>
					</table>
				</form>
			</div>
            <div class="content2">
            	<table width="100%">
                      <tr>
                        <th width="7%">编号</th>
                        <th width="30%">品名</th>
                        <th width="5%">图片</th>
                        <th width="10%">分类</th>
                        <th width="8%">规格</th>
                        <th width="8%">价格</th>
                        <th width="6%">库存</th>
                        <!-- <th width="6%">推荐</th> -->
                        <th width="6%">上架</th>
                        <th>操作</th>
                      </tr>
                      <?php foreach ($goods as $row): ?>
                      <tr>
                        <td><?php echo $row->goods_id; ?></td>
                        <td><?php echo $row->name; ?></td>
                        <td><img src="<?php if ($row->pic) echo base_url(json_decode($row->pic)->default); ?>" width="60" /></td>
                        <td><?php echo $category[$row->class_id]->class_name; ?></td>
                        <td><?php echo $row->unit; ?></td>
                        <td><?php echo $row->price; ?></td>
                        <td><?php if ($row->stock === '0') {
                        	echo '无'; } else {echo '有';}?>
						</td>
                        <!--<td><?php if ($row->is_today === '1') {
                        	echo '是'; } else {echo '否';}?>
						</td> -->
						<td style="text-align:center;"><?php if ($row->sold === '1') {
                        	echo '是'; } else {echo '否';}?>
						</td>
                        <td style="text-align:center;"><a href="<?php echo base_url('/admin/goods/edit_goods?p='.$p.'&goods_id=' .$row->goods_id.'&stage='.$stage); ?>">编辑</a>
                        	<a onclick="return del_alert()" href="<?php echo base_url('/admin/goods/del_goods?goods_id=' .$row->goods_id.'&p='.$p.'&stage='.$stage); ?>">删除</a>
                        	<a href="<?php echo base_url('/admin/goods/in_out_stock?goods_id=' .$row->goods_id.'&p='.$p.'&stage='.$stage); ?>">
                        	<?php if ($row->stock === '0') {
                        	echo '有货';} else {echo '缺货';}?></a></br>
                        	<a href="<?php echo base_url('/admin/goods/edit_top_goods?p='.$p.'&goods_id=' .$row->goods_id.'&stage='.$stage); ?>"><?php if ($row->is_top === '0') {
                        	echo '置顶';} else {echo '取消置顶';}?></a>
                        	<a href="<?php echo base_url('/admin/goods/edit_parttop_goods?p='.$p.'&goods_id=' .$row->goods_id.'&stage='.$stage); ?>"><?php if ($row->is_parttop === '0') {
                        	echo '分类置顶';} else {echo '取消分类置顶';}?></a>
                        </td>
                      </tr>
                      <?php endforeach;?>
                 </table>
                 <center><?php echo $page; ?></center>
            </div>
        </div>

<?php load_view('admin/common/footer'); ?>