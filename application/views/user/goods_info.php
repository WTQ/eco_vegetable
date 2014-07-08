<?php load_view('user/common/header'); ?>

<div class="page" data-role="page" data-theme="b">
  <div class="header" data-page="header" data-position="fixed">
    <div class="header5">
      <a href="javascript:window.history.back();"><img align="absmiddle" src="<?php echo base_url('/static/user/image/houtui.gif'); ?>"></a>
    </div>
    <div class="header6"><?php echo $goods->name; ?></div>
    <div class="cl"></div>
  </div>
  <div class="content9" data-role="content">
    <div class="content10"><img src="<?php echo base_url($goods->pic); ?>"></div>
    <div>
      <p><?php echo $goods->intro; ?><br />
      </p>
      <p>品牌：CORONA EXTRA 科罗娜<br />
        直接饮用，冷藏后饮用口感更佳</p>
      <span><?php echo $goods->price; ?></span>
    </div>
  </div>
  <a href="#" class="cart_add" goods-id="<?php echo $goods->goods_id; ?>" data-transition="slide"><div data-role="footer" class="goods" data-position="fixed"><h4>加入购物车</h4></div></a>
</div>
</body>
</html>
