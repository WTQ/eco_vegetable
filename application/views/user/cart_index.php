<?php load_view('/user/common/header');?>

<body>
<div class="page" data-role="page">
  <div class="header" data-role="header" data-position="fixed">
    <div class="header5">
     <a href="javascript:window.history.back();"><img align="absmiddle" src="<?php echo base_url('static/user/image/houtui.gif'); ?>"></a>
    </div>
    <div class="header6">购物车</div>
  </div>
  <div class="content4" data-role="content" data-theme="c">

    <?php if($this->cart->total_items() >= 1) : ?>
      
      <?php foreach($this->cart->contents() as $item) : ?>    
      <?php $goods_id = $item['id'];?>
      <?php $goods = $this->goods_m->get($goods_id);?> 

     <div>
       <div class="content5"><img src="<?php echo base_url($goods->pic);?>"></div>
       <div class="content6">
         <div><?php echo $goods->name;?><br /> <br />单价：<?php //echo $item->price; ?>元</div>
         <div>
            <div class="content6left">
              <span>数量：</span>
              <a href="#" goods-id = "<?php echo $item['id']?>" class="decrease">-</a>
              <div class="number"><input type="text" class="num" autocomplete="off" value="<?php echo $item['qty'];?>"></div>
              <a href="#" goods-id = "<?php echo $item['id']?>" class="increase">+</a>
              <div class="cl"></div>
            </div>
            <div class="content6right">总价： <?php echo $item['price']*$item['qty'];?>元</div>
            <div class="cl"></div>
         </div>
       </div>
       <div class="cl"></div>
     </div>
   <?php endforeach; ?>
  </div>
  <?php endif; ?>
  <div class="footer9" data-role="footer"  data-position="fixed" data-theme="b">
      <div class="footer10">
          <div>总金额</div>
          <div class = "total_prices"><?php echo $this->cart->total();?>元</div>
      </div>
      <div class="footer11"><a href="<?php echo base_url('/user/order/confirm');?>" data-transition="slide"><button class="ui-btn goods1">确认订单</button></a></div>
  </div>
  
</div>

</body>
</html>
