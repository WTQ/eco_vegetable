<?php load_view('user/common/header');?>
<div class="page" data-role="page">
   <div class="header" data-page="header" data-position="fixed">
       <div class="header5">
           <a href="javascript:window.history.back();"><img align="absmiddle" src="<?php echo base_url('static/user/image/houtui.gif'); ?>"></a>
       </div>
       <div class="header6">我的订单</div>
       <div class="cl"></div>
   </div>
  
   <div class="myOrdercontent" data-role="content">
       <div>
           <div data-role="navbar">
               <ul>
                   <li><a href="<?php echo base_url('user/order?type=1'); ?>" data-ajax="false"> 近1个月之内订单</a></li>
                   <li><a href="<?php echo base_url('user/order?type=2'); ?>" data-ajax="false">1个月之前的订单</a></li>
               </ul>
           </div>
           <div id="one">
            <?php $this->config->load('order_stage', TRUE);?>
            <?php $stage = $this->config->item('order_stage');?>
            <?php if(isset($orders)) : ?>
            <?php foreach ($orders as $key => $order) : ?>
               <div class="complete">
                   <p>
                       <span class="date"><?php echo date('Y-m-d  H:i:s', $order->add_time);?></span>
                       <span class="price">￥<?php echo $order->total_prices;?></span>
                   </p>
               <a href="#"><div class="items">
                   <ul>
                      <?php foreach ($order->items as $key => $item) : ?>
                       <li><img src="<?php echo base_url($item->pic);?>"></li>
                      <?php endforeach; ?>
                       <div class="cl"></div>
                   </ul>
                   <span>1个包裹（共<?php echo $order->items_cnt;?>件）</span>
                   <div class="cl"></div>
               </div></a>
               <div class="order_info">
                   <div class="info">
                       <span>订单编号：</span>
                       <span><?php echo $order->order_id;?></span>
                       <div class="cl"></div>
                   </div>
                   <div class="status">
                       <span><?php echo $stage[$order->stage];?></span>
                   </div>
                   <div class="cl"></div>
               </div>
             </div> 
          <?php endforeach; ?>
        <?php endif; ?>
        </div>		  
       </div>
   </div>
  
  
   <div class="footer" data-role="footer" data-position="fixed">
     <div>
       <a href="<?php echo base_url('user/shop');?>"><div class="footer5"></div>
      <div>主页</div></a>
    </div>
    <div>
      <a href="<?php echo base_url('user/category');?>"><div class="footer2"></div>
      <div>分类</a></div>
    </div>
    <div>
      <a href="<?php echo base_url('user/cart');?>" data-transition="slide"><div class="footer3"></div>
      <div>购物车</div></a>
    </div>
    
    <div>
      <a href="<?php echo base_url('user/order');?>" data-transition="slide"><div class="footer4"></div>
      <div>我的订单</div></a>
    </div>
    <div class="cl"> </div> 
  </div>
  
</div>
</body>
</html>
