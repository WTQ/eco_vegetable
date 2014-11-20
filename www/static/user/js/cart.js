/**
 * 购物车操作的封装，采用html5本地存储，优化用户体验
 *
 * 暂不购买的处理
 * 1、新增字段settle=1表示要结算=0表示暂不购买
 * 2、计算total_price和total_item时自动会剔除settle=0的部分
 * 3、生成http_param时会剔除settle=0的部分
 * 4、cart_destroy时表示结算成功后销毁本地购物车，会自动将settle=0改变为settle=1
 * 5、增加函数cart_unset_settle来处理暂不购买的商品
 *
 * @author 风格独特
 * @version 1.0 2014-06-17
 */

/**
 * 插入购物车，适用于在购物车中更新商品，无论购物车中是否存在都可以更新
 */
function cart_insert(goods_info) {
    var item = {
        'goods_id'  : '' + goods_info.goods_id,
        'price'     : '' + goods_info.price,
        'name'      : '' + goods_info.name,
        'qty'       : '' + goods_info.qty,
        'settle'	: 1,   // settle = 0为下次购买的标识
    };

    // 获取本地的cart数据
    if (typeof(localStorage['cart']) != 'undefined') {
        var cart  = $.parseJSON(localStorage['cart']);
        var index = cart_item(item.goods_id);
        if (index == -1) {
            cart[cart.length] = item;
        } else {
            cart[index] = item;
        }
    } else {
        var cart = new Array;
        cart[0]  = item;
    }

    // 将新增的item存入localStorage
    localStorage['cart'] = JSON.stringify(cart);
}

/**
 * 更新购物车，适用于购物车中已经具有该商品，需要更新其数量，如不存在则更新失败
 */
function cart_update(goods_id, qty) {
    if (typeof(localStorage['cart']) != 'undefined') {
        var cart  = $.parseJSON(localStorage['cart']);

        // 获取该商品在购物车中的index
        var index = cart_item(goods_id);

        if (index == -1) {
        	return false;
        }

        cart[index].qty = '' + qty;

        // 将更新的item存入localStorage
        localStorage['cart'] = JSON.stringify(cart);
    } else {
        return false;
    }
}

/**
 * 添加至购物车，qty数量是增加的数量
 */
function cart_add(goods_info) {
	var item = {
        'goods_id' : '' + goods_info.goods_id,
        'price'    : '' + goods_info.price,
        'name'     : '' + goods_info.name,
        'qty'      : '' + goods_info.qty
    };

	var index = cart_item(item.goods_id);
	if (index != -1) {
        var cart = $.parseJSON(localStorage['cart']);
        var qty  = parseInt(item.qty) + parseInt(cart[index].qty);
		if (qty < 1) {
			item.qty = 1;
		} else {
			item.qty = qty;
		}
	}

	cart_insert(item);
}

/**
 * 在购物车中删除指定goods_id的内容
 */
function cart_delete(goods_id) {
	if (typeof(localStorage['cart']) != 'undefined') {
        var cart  = $.parseJSON(localStorage['cart']);

        // 获取该商品在购物车中的index
        var index = cart_item(goods_id);

        if (index != -1) {
            cart.splice(index, 1);

            // 将cart存入localStorage
            localStorage['cart'] = JSON.stringify(cart);
        }
	}
}

/**
 * 获取购物车中的总价格
 */
function cart_total_price() {
	var total_price = 0;
    if (typeof(localStorage['cart']) != 'undefined') {
        var cart = $.parseJSON(localStorage['cart']);

        for (var i = 0; i < cart.length; ++i) {
        	if (cart[i].settle == 1) {
        		var temp = (cart[i].price * 10000) * cart[i].qty;
        		total_price = (total_price * 10000 + temp) / 10000;
        	}
        }
    }
    return total_price;
}

/**
 * 获取goods_id的购物车item的index，没有返回-1
 */
function cart_item(goods_id) {
	if (typeof(localStorage['cart']) != 'undefined') {
        var cart = $.parseJSON(localStorage['cart']);

        for (var i = 0; i < cart.length; ++i) {
            if (goods_id == cart[i].goods_id) {
            	return i;
            }
        }
    }
    return -1;
}

/**
 * 获取购物车中本次购买的total_item
 */
function cart_total_items() {
    var total_items = 0;
    if (typeof(localStorage['cart']) != 'undefined') {
        var cart = $.parseJSON(localStorage['cart']);

        for (var i = 0; i < cart.length; ++i) {
        	if (cart[i].settle == 1) {
        		total_items += parseInt(cart[i].qty);
        	}
        }
    }
    return total_items;
}

/**
 * 生成购物车发送到服务器的参数
 */
function cart_http_param() {
	var http_param = new Array;
	var item;
    if (typeof(localStorage['cart']) != 'undefined') {
        var cart = $.parseJSON(localStorage['cart']);

        for (var i = 0; i < cart.length; ++i) {
        	if (cart[i].settle == 1) {
	        	item = {
	        		goods_id : parseInt(cart[i].goods_id),
	        		qty      : parseInt(cart[i].qty)
	        	};
	        	http_param.push(item);
        	}
        }
    }
    // 把字符串作为URI进行编码
    return encodeURI(JSON.stringify(http_param));
}

/**
 * 更新所有购物车内容，用于从服务器校验购物车
 */
function cart_update_all(items) {
	for (var i = 0; i < items.length; ++i) {
		cart_insert(items[i]);
	}
}

/**
 * 设置商品暂时不购买
 */
function cart_unset_settle(goods_id) {
	var index = cart_item(goods_id);
	if (index != -1) {
		var cart = $.parseJSON(localStorage['cart']);
		cart[index].settle = 0;
		localStorage['cart'] = JSON.stringify(cart);
	}
}

/**
 * 设置暂时不购买的商品进入购物车
 */
function cart_set_settle() {
    if (typeof(localStorage['cart']) != 'undefined') {
        var cart = $.parseJSON(localStorage['cart']);

        for (var i = 0; i < cart.length; ++i) {
            cart[i].settle = 1;
        }

        localStorage['cart'] = JSON.stringify(cart);
    }
}

/**
 * 结算后清除购物车，会使暂不购买的商品恢复购买
 */
function cart_destroy() {
	if (typeof(localStorage['cart']) != 'undefined') {
        var cart     = $.parseJSON(localStorage['cart']);
        var new_cart = new Array;

        for (var i = 0; i < cart.length; ++i) {
        	if (cart[i].settle != 1) {
        	    // cart[i].settle = 1;
        		new_cart.push(cart[i]);
        	}
        }

        if (new_cart.length > 0) {
    		localStorage['cart'] = JSON.stringify(new_cart);
    	} else {
    		localStorage.removeItem('cart');
    	}
    }
}

/**
 * 将本地存储的购物车信息JSON解码，并容错
 */
function cart_dejson(all) {
    var all = arguments[0] || false;

    if (typeof(localStorage['cart']) != 'undefined') {
        var cart = $.parseJSON(localStorage['cart']);
        if (all != false) {
            return cart;
        }

        var new_cart = new Array;
        for (var i = 0; i < cart.length; ++i) {
            if (cart[i].settle == 1) {
                new_cart.push(cart[i]);
            }
        }

        return new_cart;
    } else {
        var cart = new Array;
        return cart;
    }
}

/**
 * 更新footer中的购物车items和总金额
 */
function cart_badge() {
    localStorage['total_price'] = cart_total_price();
    // 更新总金额
    $(".total_price").text(localStorage['total_price'] + " 元");
    // 更新footer_badge
    var total_items = cart_total_items();
    $.ui.updateBadge("#total_items", total_items, 'tr', '#FFF');
}

/**
 * 测试用代码
 */
$.ui.ready(function() {
   // var item = {
   //     'goods_id'  : '2',
   //     'price'     : '9.9',
   //     'name'      : '测试',
   //     'qty'       : 3
   // };


   // var item2 = {
   //     'goods_id'  : '32',
   //     'price'     : '18.19',
   //     'name'      : '测试',
   //     'qty'       : 5
   // };

   // var items = new Array;
   // items[0] = item;
   // items[1] = item2;

   // cart_insert(item);
   // cart_insert(item2);
   // cart_add(item);


   // alert(cart_total_items());
   // alert(cart_total_price());
   // alert(decodeURI(cart_http_param()));

   // cart_unset_settle(32);

   //  cart_destroy();

   //  cart_update(2, 15);
   //  cart_update(32, 18);

   //  cart_delete(32);
   //  alert(cart_total_items());
   //  alert(cart_total_price());
   //  alert(decodeURI(cart_http_param()));
   //  cart_update_all(items);
});
