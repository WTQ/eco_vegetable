-- phpMyAdmin SQL Dump
-- version 3.4.10.1
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2014 年 07 月 08 日 13:44
-- 服务器版本: 5.5.20
-- PHP 版本: 5.3.10

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `eco_vegetable`
--

-- --------------------------------------------------------

--
-- 表的结构 `yf_address`
--

CREATE TABLE IF NOT EXISTS `yf_address` (
  `address_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `name` varchar(100) NOT NULL,
  `community_id` int(10) unsigned NOT NULL,
  `default` int(10) unsigned NOT NULL,
  `community_name` varchar(100) NOT NULL,
  PRIMARY KEY (`address_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `yf_address`
--

INSERT INTO `yf_address` (`address_id`, `user_id`, `name`, `community_id`, `default`, `community_name`) VALUES
(2, 1, '21#楼17层1703', 5, 0, '世纪金源'),
(3, 1, '22#楼17层1703', 5, 1, '世纪金源'),
(4, 1, '23#楼17层1703', 5, 0, '世纪金源');

-- --------------------------------------------------------

--
-- 表的结构 `yf_admin_user`
--

CREATE TABLE IF NOT EXISTS `yf_admin_user` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` char(40) NOT NULL,
  `salt` varchar(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `power` int(11) NOT NULL,
  `last_ip` varchar(48) NOT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- 转存表中的数据 `yf_admin_user`
--

INSERT INTO `yf_admin_user` (`uid`, `username`, `password`, `salt`, `name`, `power`, `last_ip`) VALUES
(3, 'wangte', '7edec1ff2d4a904a4f19ce92cd648253', '422996', '王特', 0, '');

-- --------------------------------------------------------

--
-- 表的结构 `yf_article`
--

CREATE TABLE IF NOT EXISTS `yf_article` (
  `aid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `type` int(11) unsigned NOT NULL,
  `title` varchar(200) NOT NULL,
  `content` text NOT NULL,
  `add_date` date NOT NULL,
  `add_time` int(11) NOT NULL,
  `add_user` varchar(30) NOT NULL,
  PRIMARY KEY (`aid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `yf_article`
--

INSERT INTO `yf_article` (`aid`, `type`, `title`, `content`, `add_date`, `add_time`, `add_user`) VALUES
(2, 2, '北京各大高校区招聘啦~~', 'aaa', '2014-04-10', 1397119621, 'Kung'),
(3, 2, '吾家店校园团购网招商令', 'aaa', '2014-04-10', 1397119621, 'Kung');

-- --------------------------------------------------------

--
-- 表的结构 `yf_article_type`
--

CREATE TABLE IF NOT EXISTS `yf_article_type` (
  `tid` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`tid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `yf_article_type`
--

INSERT INTO `yf_article_type` (`tid`, `pid`, `name`) VALUES
(1, 0, '新鲜水果重磅来袭'),
(2, 1, '吴家店新闻'),
(3, 1, '通知公告');

-- --------------------------------------------------------

--
-- 表的结构 `yf_category`
--

CREATE TABLE IF NOT EXISTS `yf_category` (
  `class_id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL,
  `class_name` varchar(50) NOT NULL,
  `deleted` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`class_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='商品分类表' AUTO_INCREMENT=8 ;

--
-- 转存表中的数据 `yf_category`
--

INSERT INTO `yf_category` (`class_id`, `parent_id`, `class_name`, `deleted`) VALUES
(1, 0, '零食素食', 0),
(2, 0, '烟酒饮料', 0),
(3, 0, '粮油调料', 0),
(4, 0, '日化清洁', 0),
(5, 0, '百货杂物', 0),
(6, 0, '生鲜蔬菜', 0),
(7, 0, '其他扩展', 0);

-- --------------------------------------------------------

--
-- 表的结构 `yf_comment`
--

CREATE TABLE IF NOT EXISTS `yf_comment` (
  `cmt_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) unsigned NOT NULL,
  `shop_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL COMMENT '买家用户id',
  `title` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `content` text NOT NULL,
  `time` int(11) unsigned NOT NULL,
  `deleted` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`cmt_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='评论反馈表' AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `yf_comment`
--

INSERT INTO `yf_comment` (`cmt_id`, `parent_id`, `shop_id`, `user_id`, `title`, `username`, `content`, `time`, `deleted`) VALUES
(1, 0, 0, 0, '好评', 'abc', '东西不错', 1396355171, 0),
(2, 1, 0, 0, '', '', '谢谢惠顾', 1396355987, 0);

-- --------------------------------------------------------

--
-- 表的结构 `yf_coupon`
--

CREATE TABLE IF NOT EXISTS `yf_coupon` (
  `coupon_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主id，自增',
  `shop_id` int(10) unsigned NOT NULL COMMENT '商家id （id=0时优惠为全局）',
  `type` int(4) unsigned NOT NULL DEFAULT '1' COMMENT '优惠券类别',
  `content` varchar(200) NOT NULL COMMENT '优惠信息',
  PRIMARY KEY (`coupon_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `yf_coupon`
--

INSERT INTO `yf_coupon` (`coupon_id`, `shop_id`, `type`, `content`) VALUES
(1, 1, 1, '{"full":100,"discount":1,"reduce":10,"present":""}'),
(2, 1, 2, '{"full":100,"discount":1,"reduce":0,"present":"\\u5927\\u74f6\\u88c5\\u767e\\u4e8b\\u53ef\\u4e50"}'),
(3, 1, 3, '{"full":100,"discount":8.5,"reduce":0,"present":""}');

-- --------------------------------------------------------

--
-- 表的结构 `yf_db_goods`
--

CREATE TABLE IF NOT EXISTS `yf_db_goods` (
  `goods_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '商品库主id',
  `name` varchar(100) NOT NULL COMMENT '商品名称',
  `pic` varchar(500) NOT NULL COMMENT '图片路径',
  `price` varchar(20) NOT NULL COMMENT '商品价格',
  `unit` varchar(20) NOT NULL COMMENT '商品规格',
  `barcode` varchar(20) NOT NULL COMMENT '条形码',
  `intro` text NOT NULL COMMENT '商品介绍',
  PRIMARY KEY (`goods_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `yf_db_goods`
--

INSERT INTO `yf_db_goods` (`goods_id`, `name`, `pic`, `price`, `unit`, `barcode`, `intro`) VALUES
(1, '', '{"default":"uploads\\/goods_img\\/20140514\\/20140514145536wnhyvwcn.jpg","more":{"pic1":"","pic2":"","pic3":"","pic4":""}}', '', '500g/', '123456789', ''),
(2, '', '{"default":"uploads\\/depot_img\\/20140514\\/20140514151811okhkodfc.jpeg","more":{"pic1":"","pic2":"","pic3":"","pic4":""}}', '', '500ML/ƿ', '', ''),
(3, '', '{"default":"uploads\\/depot_img\\/20140514\\/20140514151432efscvmgw.jpg","more":{"pic1":"","pic2":"","pic3":"","pic4":""}}', '', '', '524876215', 'Ʈ'),
(4, '苹果大苹果', '{"default":"uploads\\/depot_img\\/20140515\\/20140515230010ypjlhwag.png","more":{"pic1":"","pic2":"","pic3":"","pic4":""}}', '10.00', '斤', '', '又大又红的苹果');

-- --------------------------------------------------------

--
-- 表的结构 `yf_db_user`
--

CREATE TABLE IF NOT EXISTS `yf_db_user` (
  `depot_uid` int(11) NOT NULL AUTO_INCREMENT COMMENT '商品库操作员id',
  `depot_username` varchar(50) NOT NULL COMMENT '用户名',
  `depot_password` char(50) NOT NULL COMMENT '密码',
  `salt` varchar(11) NOT NULL COMMENT '加盐',
  PRIMARY KEY (`depot_uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `yf_db_user`
--

INSERT INTO `yf_db_user` (`depot_uid`, `depot_username`, `depot_password`, `salt`) VALUES
(1, 'wangte', '7edec1ff2d4a904a4f19ce92cd648253', '422996');

-- --------------------------------------------------------

--
-- 表的结构 `yf_goods`
--

CREATE TABLE IF NOT EXISTS `yf_goods` (
  `goods_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键，自增',
  `shop_id` int(11) NOT NULL COMMENT '商家id',
  `class_id` int(11) NOT NULL COMMENT '分类id',
  `name` varchar(100) NOT NULL COMMENT '商品名',
  `pic` varchar(500) NOT NULL COMMENT '图片',
  `price` varchar(20) NOT NULL COMMENT '价格',
  `unit` varchar(20) NOT NULL COMMENT '计量单位',
  `barcode` varchar(20) NOT NULL COMMENT '条形码',
  `intro` text NOT NULL COMMENT '商品介绍',
  `stock` int(11) NOT NULL DEFAULT '1' COMMENT '库存',
  `sale` int(10) unsigned NOT NULL COMMENT '销量',
  `rank` int(11) NOT NULL COMMENT '销量排名',
  `is_today` tinyint(4) NOT NULL COMMENT '今日推荐',
  `sold` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '0为下架；1为在售',
  PRIMARY KEY (`goods_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=42 ;

--
-- 转存表中的数据 `yf_goods`
--

INSERT INTO `yf_goods` (`goods_id`, `shop_id`, `class_id`, `name`, `pic`, `price`, `unit`, `barcode`, `intro`, `stock`, `sale`, `rank`, `is_today`, `sold`) VALUES
(1, 1, 1, '福建特产 友臣 金丝肉松饼', '{"default":"uploads\\/goods_img\\/20140609\\/20140609194632huqodmhi.jpg","more":{"pic1":"","pic2":"","pic3":"","pic4":""}}', '9.9', '208g', '', '掰开一看，满满的肉松足显诚意，香酥的饼皮，一口咬下去，会很有满足感哦 ！掰开烘烤成金色的外皮，露出里面同样烘烤成金色的肉松美味势不可挡。金丝肉松饼销量足以见证它是今年最流行的小吃哦，吃货们不能错过啊，吃过一个还想第二个！', 1, 0, 0, 1, 0),
(2, 1, 1, '好丽友 薯愿三连包', '{"default":"uploads\\/goods_img\\/20140609\\/20140609194802erozixpr.jpg","more":{"pic1":"","pic2":"","pic3":"","pic4":""}}', '21.8', '312g/组', '', '薯愿 3种美味超值装，1853年春天,海军上尉范德比尔特到纽约的一个旅游胜地度假。有一天,他在晚餐的时候向厨师抱怨马铃薯片太厚了。厨师决定和范德比尔特开个玩笑,他将马铃薯切成像纸一样的薄片,在热油中油炸,然后撒上调料。本来想开个玩笑,没想到上尉大赞好吃，这就成了今天的薯片。', 0, 0, 0, 1, 0),
(3, 1, 1, '越南进口利葡面包干', '{"default":"uploads\\/goods_img\\/20140609\\/20140609195015koxwzevu.jpg","more":{"pic1":"","pic2":"","pic3":"","pic4":""}}', '25.6', '300g*2袋', '', '【配料】小麦面粉，鸡蛋，白砂糖，棕榈油，奶粉，食盐，碳酸氢钠，碳酸氢铵 【净含量】300克 【原产国】越南 【生产日期】年 月 日（见包装封口处） 【贮存条件】阴凉干燥处 【生产商】ALPHA INTERNATIONAL FOOD JOINT STOCK COMPANY', 1, 0, 0, 1, 0),
(4, 1, 1, '波力海苔罐装', '{"default":"uploads\\/goods_img\\/20140609\\/20140609195134shxtdtxt.jpg","more":{"pic1":"","pic2":"","pic3":"","pic4":""}}', '27.5', '75g', '', '来自海洋的蔬菜-鲜美脆嫩的波力海苔，自北纬33度附近的纯净海域，浓缩了大海的精华，波力海苔鱼片夹心脆是海苔与渔趣的完美组合，每一片波力海苔都可以带来浓浓海的感受，美味诱惑难以抵挡！\r\n波力海苔为休闲、娱乐、聚会、课间、工休时间的美味零食，香脆完美，让您享受一份回味无穷的温馨。', 1, 0, 0, 1, 0),
(5, 1, 1, '武汉特产 周黑鸭鸭脖', '{"default":"uploads\\/goods_img\\/20140609\\/20140609195238wkdysgcl.jpg","more":{"pic1":"","pic2":"","pic3":"","pic4":""}}', '28.80', '210g', '', '源于1997年的“周黑鸭”美食诞生于湖北武汉，“入口微甜爽辣，吃后回味悠长”的独特口味深得年轻白领亲睐。经过十余年的发展，“周黑鸭”品牌专卖店已经遍布全国。我们将致力于打造美食新风尚，让全世界的美食爱好者享受中国的传统美食。', 1, 0, 0, 1, 0),
(6, 1, 1, '麦德好营养麦片巧克力', '{"default":"uploads\\/goods_img\\/20140609\\/20140609195409druaydjz.jpg","more":{"pic1":"","pic2":"","pic3":"","pic4":""}}', '19.90', '468g', '', '配料：奶粉、代可可脂、燕麦片、乳糖、脆米、食用盐\r\n净含量：468g\r\n原产地：福建省泉州市\r\n保质期：12个月\r\n存储方法：置于阴凉干燥处，避免阳光直射！', 1, 0, 0, 1, 0),
(7, 1, 1, '黄飞红麻辣花生', '{"default":"uploads\\/goods_img\\/20140609\\/20140609195529nmqhwcpu.jpg","more":{"pic1":"","pic2":"","pic3":"","pic4":""}}', '8.9', '210g', '', '配料：花生，辣椒，一级豆油，食用盐，香辛料，食品添加剂（谷氨酸钠，维生素E） \r\n净含量：210g\r\n产品标准号：Q/XSJ0001S\r\n生产许可：QS370118010472\r\n保质期：10个月\r\n贮存方法：避光，密封保存', 1, 0, 0, 1, 0),
(8, 1, 1, '菲律宾进口Cebu宿雾芒果干', '{"default":"uploads\\/goods_img\\/20140609\\/20140609195703ruropgva.jpg","more":{"pic1":"","pic2":"","pic3":"","pic4":""}}', '11.8', '100g', '', '品名：宿雾牌芒果干100克配料：芒果，白砂糖，二氧化硫净含量：100克保质期：2年原产国：菲律宾原装进口，品质保证！贮藏方法：通风、干燥、避光处注意事项：本品为芒果制成，温度较高时，包装袋内会出现雾气，属自然返潮现象，请安心享用。', 1, 0, 0, 1, 0),
(9, 1, 1, '马来西亚进口Yame果爱什锦布丁(六种口味)', '{"default":"uploads\\/goods_img\\/20140609\\/20140609195851itiwbiut.jpg","more":{"pic1":"","pic2":"","pic3":"","pic4":""}}', '12.9', '110g*6杯', '', '商品名称：果爱什锦果冻（果味型 六种口味)\r\n商品产地：马来西亚\r\n保质期限：18个月\r\n商品规格：110gx6/盒\r\n储存方式：置于阴凉，通风，干燥处\r\n配料：水，白砂糖，酪蛋白酸钠，海藻酸钾，柠檬酸，柠檬酸钠，防腐剂：（山梨酸钾），人造水果香料，着色剂：（日落黄，柠檬黄，亮蓝），椰果。', 1, 0, 0, 1, 0),
(10, 1, 1, '重庆特产 有友泡凤爪山椒味', '{"default":"uploads\\/goods_img\\/20140609\\/20140609200012xovvhcnl.jpg","more":{"pic1":"","pic2":"","pic3":"","pic4":""}}', '19.90', '100g*5袋', '', '【商品名称】：重庆特产 有友泡凤爪山椒味100g*5袋\r\n【规格】：100g*5\r\n【生产许可证号】：501204015424\r\n【保质期】：200天\r\n【贮藏方法】：阴凉干燥处 【食用方法】：开袋即食', 1, 0, 0, 1, 0),
(11, 1, 1, '中国台湾进口北田蒟蒻糙米卷（海苔口味）', '{"default":"uploads\\/goods_img\\/20140609\\/20140609200152qugrqzkx.jpg","more":{"pic1":"","pic2":"","pic3":"","pic4":""}}', '11.50', '160g', '', '北田蒟蒻糙米卷海苔口味（膨化食品）\r\n【配料】糙米、棕榈油、麦芽糊精、白米、玉米、白砂糖、海苔、酱油粉（大豆、小麦、食用盐、白砂糖）、蒟蒻粉 【致敏物质提示】含有麸质的谷物及其制品、大豆及其制品 【净含量】160克 【原产地】中国台湾 【生产日期】标于包装（日/月/年） 【贮存条件】常温保存 【制造商】北田食品股份有限公司', 1, 0, 0, 1, 0),
(12, 1, 1, '中国台湾进口张君雅小妹妹巧克力甜甜圈', '{"default":"uploads\\/goods_img\\/20140609\\/20140609200318wyjboatw.jpg","more":{"pic1":"","pic2":"","pic3":"","pic4":""}}', '6.80', '45g', '', '香香的巧克力饼，裹上浓浓的巧克力酱，绝对物超所值的浓郁感。\r\n巧克力酱几乎快渗透整个甜甜圈了，並非只在外面抹了薄薄的一层，而且甜甜圈有滋润感，不会感觉硬，好吃~~~ ！', 1, 0, 0, 1, 0),
(13, 1, 1, '美国Kirkland柯可蓝整粒蓝莓干', '{"default":"uploads\\/goods_img\\/20140609\\/20140609200415rbtfsicm.jpg","more":{"pic1":"","pic2":"","pic3":"","pic4":""}}', '99.00', '567g', '', 'Kirkland柯可蓝整粒蓝莓干\r\n原产国：美国 配料：蓝莓，白砂糖，苹果酸，食用香料，柠檬酸，植物油（葵花子油）。 食用方法：开封后直接食用。 净含量：567g 保质期：12个月 注意事项：放置阴凉干燥处，密封保存。', 1, 0, 0, 1, 0),
(14, 1, 1, '旺旺仙贝经济包', '{"default":"uploads\\/goods_img\\/20140609\\/20140609200724rzdrpnut.jpg","more":{"pic1":"","pic2":"","pic3":"","pic4":""}}', '19.90', '520g', '', '配料：大米，棕榈油，白砂糖，淀粉，葡萄糖，酱油粉（酱油，麦芽糊糖，食用盐，水解植物蛋白，酵母提取物，昆布提取物）食用盐，食品添加剂（甘氨酸，5‘呈味核苷酸二钠）味精\r\n净含量：520g\r\n保质期：9个月\r\n生产许可证号：QS110012010032\r\n产品执行标准：GB/T22699\r\n储存方法：常温储存', 1, 0, 0, 1, 0),
(15, 1, 1, '太阳小米锅巴麻辣味', '{"default":"uploads\\/goods_img\\/20140609\\/20140609200916cmwdgntl.jpg","more":{"pic1":"","pic2":"","pic3":"","pic4":""}}', '1.90', '50g', '', '配料：大米 小米 黄豆 棕榈油 淀粉 调味料\r\n净含量：50g\r\n保质期：12个月\r\n生产许可证：QS610112010029\r\n产品标准号：GB/T22699\r\n储存方法：置于干燥阴凉处,避免阳光直射', 1, 0, 0, 1, 0),
(16, 1, 1, '天津特产 十佳牛肉干', '{"default":"uploads\\/goods_img\\/20140609\\/20140609201104tkpqnunf.jpg","more":{"pic1":"","pic2":"","pic3":"","pic4":""}}', '7.90', '60g', '', '配料：精选牛肉、白砂糖、辣椒粉、五香粉、食盐、料酒、白酒、大茴、味精\r\n净含量：60g\r\n生产许可证：QS12100401147\r\n产品标准号：GB/T23969\r\n保质期：8个月\r\n储存方法：放置通风干燥的地方', 1, 0, 0, 1, 0),
(17, 1, 1, '明珠 舟山水产 海鲜小鱿鱼仔', '{"default":"uploads\\/goods_img\\/20140609\\/20140609201302oxdzmbpk.jpg","more":{"pic1":"","pic2":"","pic3":"","pic4":""}}', '25.00', '300g', '', '独立真空包装，小巧方便，保证干净卫生的同时，也最大限度的保留了鱼仔的鲜香味。精选深海鱿鱼仔精心加工而成，肉质饱满，丰厚细腻，有嚼劲，吃过之后，口中久久留香，回味无穷，越吃越有味。\r\n选用东海特产鱼类鱿鱼为原料，采用现代加工工艺精制而成,保持了海产品的营养成分，富含多种不饱和脂肪酸，优质蛋白质及多种矿物质,让你不在海边也可以尝到新鲜的大海滋味！', 1, 0, 0, 1, 0),
(18, 1, 1, '韩国进口海地村鳕鱼肠', '{"default":"uploads\\/goods_img\\/20140609\\/20140609201549ggsezzuz.jpg","more":{"pic1":"","pic2":"","pic3":"","pic4":""}}', '9.90', '90g（10g*9根)', '', '配料:鲟鱼、奶酪、鸡蛋、食用盐、糖等\r\n规格：90克\r\n保质期：12个月\r\n产地：韩国\r\n储存方式：置于阴凉干燥处', 1, 0, 0, 1, 0),
(19, 1, 1, '好巴食豆腐干混合装', '{"default":"uploads\\/goods_img\\/20140609\\/20140609201754moskyhlp.jpg","more":{"pic1":"","pic2":"","pic3":"","pic4":""}}', '8.80', '200g', '', '‘好巴食’豆腐干是以南溪县得天独厚的天然原料加以历史传承的传统生产工艺，配合现代新技术，生产出的新一代豆制品休闲小食品。豆腐干营养丰富，含有大量蛋白质、脂肪、碳水化合物，还有钙、磷、铁等多种人体所需的矿物质。\r\n豆腐干在制作过程中会添加食盐、茴香、花椒、大料、干姜等调料，既香又鲜，久吃不厌，被誉为‘素火腿’。', 1, 0, 0, 1, 0),
(20, 1, 1, '乐事薯片美国经典原味', '{"default":"uploads\\/goods_img\\/20140609\\/20140609201934jmcbksyz.jpg","more":{"pic1":"","pic2":"","pic3":"","pic4":""}}', '10.90', '165g', '', '配料：马铃薯，植物油，食用盐，食品添加剂(谷氨酸钠，5 -呈味核苷酸二钠)。\r\n净含量：165克\r\n保质期：9个月\r\n生产许可证：QS3117 1202 0001(SJ)；QS1124 1202 0001(QY)；QS4201 1202 0011(WH)以包装背面表示为准 \r\n产品标准号：QB/T 2686 \r\n储存方法：请置于干燥凉爽处，避免阳光直射，开口后请即食，以免受潮。', 1, 0, 0, 1, 0),
(21, 1, 2, '古井贡酒 红运H3 50度 ', '{"default":"uploads\\/goods_img\\/20140609\\/20140609202213snobbrje.jpg","more":{"pic1":"","pic2":"","pic3":"","pic4":""}}', '138.00', '500ml', '', '古井企业文化建设以“中华第一贡”为旗帜，以“贡”字为核心，以“忠诚、贡献、共享” 为特征。古井集团是中国老八大名酒企业，是中国第一家同时发行A、B两支股票的白酒类上市公司，在2010年第二届中国酒类品牌价值评议活动中，古井贡以81.72亿元摘得“中华白酒十大全球代表性品牌“，同时古井集团被授予”中国白酒申请国家暨世界非物质文化遗产“发起人', 1, 0, 0, 1, 0),
(22, 1, 2, 'BLACK ROBERTS 罗伯特船长白朗姆酒 ', '{"default":"uploads\\/goods_img\\/20140609\\/20140609202827gbazigie.jpg","more":{"pic1":"","pic2":"","pic3":"","pic4":""}}', '45.00', '750ml', '', '原产国：美国\r\n酒种：蒸馏酒\r\n净含量：750ML\r\n酒精度：40%vol\r\n色泽：透明\r\n配料：纯净水、甘蔗蒸馏液\r\n保质期：10年\r\n饮用方法：调酒饮用，如加冰块，兑各种果汁饮料或碳酸饮料饮用\r\n产品特点：酒香气突出，口味猛烈。', 1, 0, 0, 1, 0),
(23, 1, 2, '加多宝凉茶', '{"default":"uploads\\/goods_img\\/20140609\\/20140609203019ebzwevyo.jpg","more":{"pic1":"","pic2":"","pic3":"","pic4":""}}', '78.90', '310ml*24罐 整箱', '', '商品名称：加多宝凉茶 配 料：水、白砂糖、仙草、鸡蛋花、布渣叶、菊花、金银花、夏枯草、甘草 保存方法：阴凉干燥处贮存 保 质 期：2年', 1, 0, 0, 1, 0),
(24, 1, 2, '恒大冰泉 长白山天然矿泉水', '{"default":"uploads\\/goods_img\\/20140609\\/20140609203252elefjtkm.jpg","more":{"pic1":"","pic2":"","pic3":"","pic4":""}}', '105.00', '500ml*24罐 整箱', '', '恒大冰泉源于长白山上原始森林中的天然深层矿泉，是直接从深层火山岩中取水，无空气接触灌装生产而成。\r\n长白山深层矿泉：是世界三大黄金水源之一。是经过地下千年深层火山岩磨砺，百年循环、吸附、溶滤而成，属火山岩冷泉。', 1, 0, 0, 1, 0),
(25, 1, 3, 'AGRIC阿格利司 高配比橄榄葵花调和油 ', '{"default":"uploads\\/goods_img\\/20140609\\/20140609203937jahplwzj.jpg","more":{"pic1":"","pic2":"","pic3":"","pic4":""}}', '9.90', '420ml', '', '含60%橄榄油，单不饱和脂肪酸和橄榄油基本相同；不含胆固醇；6 : 4专利；营养健康类食用油；营养、安全、健康；低油烟，香味浓郁，色泽通透、味纯，金黄透绿；不添加任何防腐剂和人工抗氧化剂。 6:4橄榄葵花调和油它含有丰富的单不饱和脂肪酸与ω-3和ω-6必需脂肪酸。 6:4橄榄葵花调和油属营养健康类食用油，安全、健康、营养，老少皆宜。 6:4橄榄葵花调和油经过科学的配方，提高了烟点，稳定性好。', 1, 0, 0, 1, 0),
(26, 1, 3, '金龙鱼 葵花籽油 ', '{"default":"uploads\\/goods_img\\/20140609\\/20140609204131wuczfyap.jpg","more":{"pic1":"","pic2":"","pic3":"","pic4":""}}', '49.90', '4L', '', '净含量：4L；\r\n保质期：18个月；\r\n是否非转基因：非；\r\n使用方法：适宜煎炒、煮、炸、凉拌；', 1, 0, 0, 1, 0),
(27, 1, 3, '陶华碧老干妈 风味豆豉油制辣椒 ', '{"default":"uploads\\/goods_img\\/20140609\\/20140609204257etwwhiej.jpg","more":{"pic1":"","pic2":"","pic3":"","pic4":""}}', '7.70', '280g', '', '老干妈几十年来，一直沿用传统工艺精心酿造，具有优雅细腻，香辣突出，回味悠长等特点。老干妈系列产品是居家必备，馈赠亲友之良品。1984年，陶华碧女士凭借自己独特的炒制技术，推出了别具风味的佐餐调料，令广大顾客大饱口福，津津乐道。1996年批量生产后在全国迅速成为销售热点。老干妈是国内生产及销售量最大的辣椒制品生产企业，主要生产风味豆豉、风味鸡油辣椒、香辣菜、风味腐乳等20余个系列产品。', 1, 0, 0, 1, 0),
(28, 1, 3, '太太乐 鸡精 ', '{"default":"uploads\\/goods_img\\/20140609\\/20140609204532wgqfwxar.jpg","more":{"pic1":"","pic2":"","pic3":"","pic4":""}}', '15.6', '454g', '', '太太乐利用“佛跳墙”和新的鲜味科学原理，研制出太太乐鸡精，它由天然鲜鸡提炼而成，运用高新工艺，配以鸡蛋、呈味核苷酸、谷氨酸钠、蔬菜粉等复合而成，集鲜味、香味和营养于一体，加入任何菜肴均不串味，食后不觉口干，鲜度更是普通99%味精的1.8-2倍。', 1, 0, 0, 1, 0),
(29, 1, 4, '威露士 衣物家居消毒液', '{"default":"uploads\\/goods_img\\/20140609\\/20140609204843hzbwnlyb.jpg","more":{"pic1":"","pic2":"","pic3":"","pic4":""}}', '129.80', '3LX2', '', '【产品名称】：威露士 衣物家居消毒液 3L\r\n【保质期】：2年\r\n【产地】：中国\r\n【产品规格】：3L\r\n【产品功效】：1.有效杀灭99.999%的大肠杆菌，金黄色葡萄球 菌，白色念珠菌。 2.能去除汗味等异味，衣物用后，气味尤为清新。 3.适用于皮肤，伤口等的消毒杀菌。', 1, 0, 0, 1, 0),
(30, 1, 4, '白猫柠檬红茶洗洁精', '{"default":"uploads\\/goods_img\\/20140609\\/20140609205041revyhuot.jpg","more":{"pic1":"","pic2":"","pic3":"","pic4":""}}', '12.90', '1.5kg', '', '【品牌】：白猫\r\n【品名】：白猫柠檬红茶洗洁精1.5kg\r\n【储存方法】：避光，阴凉，干燥\r\n【克重】：1.5KG\r\n【保质期】：1095', 1, 0, 0, 1, 0),
(31, 1, 4, '维达3层280节卷筒卫生纸', '{"default":"uploads\\/goods_img\\/20140609\\/20140609205337eegecnpe.jpg","more":{"pic1":"","pic2":"","pic3":"","pic4":""}}', '19.90', '12卷', '', '【品牌】：维达\r\n【产品名称】：柔滑系列280节有芯卫生卷纸\r\n【原材料】：100%原生木浆\r\n【产品规格】：280节/卷*（10+2）卷\r\n【纸张层数】：3层\r\n【纸张尺寸】：112mm*100mm/节\r\n【有无香味】：自然无香', 1, 0, 0, 1, 0),
(32, 1, 4, '妙洁神奇抹布', '{"default":"uploads\\/goods_img\\/20140609\\/20140609205557asigwpvw.jpg","more":{"pic1":"","pic2":"","pic3":"","pic4":""}}', '9.90', '3片', '', '商品品牌： 妙洁 \r\n商品名称： 神奇抹布 \r\n商品货号： MTA2X1\r\n商品材质： 优质天然植物纤维\r\n商品规格： B层（30cmX30cm）\r\n商品数量：\r\n3片X1袋\r\n执行标准： Q/320201 GDK09', 1, 0, 0, 1, 0),
(33, 1, 5, '美居客日式便携烫衣板', '{"default":"uploads\\/goods_img\\/20140609\\/20140609205839qswltimb.jpg","more":{"pic1":"","pic2":"","pic3":"","pic4":""}}', '69.00', '60*37*20cm', '', '美居客日式便携烫衣板\r\n颜色：花布\r\n材质：表面100%棉布,塑料台面,金属支撑脚\r\n规格：60*37*20cm\r\n重量：约1.2kg', 1, 0, 0, 0, 0),
(34, 1, 5, '禧天龙Citylong 时尚环保塑料五层收纳整理柜', '{"default":"uploads\\/goods_img\\/20140609\\/20140609210148rpbiecel.jpg","more":{"pic1":"","pic2":"","pic3":"","pic4":""}}', '219.00', '70L（卡其）5027', '', '产品尺寸：43*32.2*87 产品容积：70L 材质：PP', 1, 0, 0, 1, 0),
(35, 1, 5, '明高室内外温湿度计', '{"default":"uploads\\/goods_img\\/20140609\\/20140609210425paruvkmr.jpg","more":{"pic1":"","pic2":"","pic3":"","pic4":""}}', '36.00', 'TH101B', '', '远距离能读取每一度高精度及舒适度彩色区分高质用料，拱形玻璃表面，不易划花\r\n温度：－30℃～50℃ 湿度：20%～100%温度准确度：±2℃(－30℃～50℃)湿度准确度：±5%\r\n明高五金拥有塑胶模具制造、注塑加工、五金模具制作、冲压及车削加工、印刷喷涂、产品装配(包括塑胶五金产品和电子产品装配)等综合生产能力，并且熟悉国内、欧美日等地的各种认证标准和流程\r\n特殊说明:\r\n可用于家居、写字楼、学校、酒店、车间、实验室等安装有空调的环境\r\nQB/440307N411-2002', 1, 0, 0, 1, 0),
(36, 1, 5, 'Philips飞利浦 30074 酷捷LED护眼台灯银色', '{"default":"uploads\\/goods_img\\/20140609\\/20140609210623vvfltlxh.jpg","more":{"pic1":"","pic2":"","pic3":"","pic4":""}}', '269.00', '380X40X460mm', '', '型号：30074\r\n功率：6W\r\n材质：高品质合成材料\r\n产品尺寸：380X40X460mm\r\n光源：LED（含光源）\r\n电源：220V\r\n颜色：银 色 \r\n色温：5500K\r\n电源线长度：1.8m\r\n适用空间：客厅、卧室、书房 等', 1, 0, 0, 0, 0),
(37, 1, 6, '中小苹果 山东烟台栖霞苹果水果新鲜 红富士苹果', '{"default":"uploads\\/goods_img\\/20140609\\/20140609210819tjuviamc.jpg","more":{"pic1":"","pic2":"","pic3":"","pic4":""}}', '75.00', '10斤24个', '', '苹果个数：5千克/箱/24粒\r\n苹果品类：红富士\r\n单个大小：180-240克左右，最大直径70-80MM左右', 1, 0, 0, 1, 0),
(38, 1, 6, '1号生鲜 精选黄秋葵 ', '{"default":"uploads\\/goods_img\\/20140609\\/20140609211139wjztwvhj.jpg","more":{"pic1":"","pic2":"","pic3":"","pic4":""}}', '23.50', '200g/盒', '', '产      地：云南\r\n类      别：黄秋葵\r\n产品简介：黄秋葵，别名秋葵夹、羊角豆，是锦葵科一年生的草本植物，果实浓绿，品质好\r\n储存方法：建议放置在冰箱中冷藏储存并尽快食用', 1, 0, 0, 1, 0),
(39, 1, 6, '1号生鲜 精选甜玉米 ', '{"default":"uploads\\/goods_img\\/20140609\\/20140609211254bxmpdyaa.jpg","more":{"pic1":"","pic2":"","pic3":"","pic4":""}}', '25.50', '1kg/盒', '', '产      地：上海/北京\r\n类      别：玉米\r\n产品简介：甜玉米，又称蔬菜玉米。玉米的甜质型亚种。因其具有丰富的营养、甜、鲜、脆、嫩的特色而深受各阶层消费者青睐\r\n储存方法：建议放置在冰箱中冷藏储存并尽快食用', 1, 0, 0, 1, 0),
(40, 1, 6, '1号生鲜 精选胡萝卜 ', '{"default":"uploads\\/goods_img\\/20140609\\/20140609211407xlzdflec.jpg","more":{"pic1":"","pic2":"","pic3":"","pic4":""}}', '14.50', '1kg/盒', '', '产      地：上海/北京\r\n类      别：胡萝卜\r\n产品简介：胡萝卜是一种质脆味美、营养丰富的家常蔬菜，素有“小人参”之称。\r\n储存方法：建议放置在冰箱中冷藏储存并尽快食用', 1, 0, 0, 1, 0),
(41, 1, 7, '联想（Lenovo） U330P 13.3英寸超极本暮光灰', '{"default":"uploads\\/goods_img\\/20140609\\/20140609211936cmenykfq.jpg","more":{"pic1":"","pic2":"","pic3":"","pic4":""}}', '4499.00', 'i5-4200U 4G 500G 16G', '', '- 第四代智能英特尔® 酷睿?处理器(Haswell)，超前感受性能至尊\r\n- 四倍系统加速、闪电存储，游戏、办公酣畅淋漓\r\n- 匹配新一代显卡，享受高清影视', 1, 0, 0, 1, 0);

-- --------------------------------------------------------

--
-- 表的结构 `yf_order`
--

CREATE TABLE IF NOT EXISTS `yf_order` (
  `order_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `total_prices` varchar(20) NOT NULL,
  `remarks` varchar(100) NOT NULL,
  `shop` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` varchar(250) NOT NULL,
  `add_time` int(11) unsigned NOT NULL,
  `stage` tinyint(4) NOT NULL,
  `canceled` tinyint(3) unsigned NOT NULL,
  `cancel_reason` varchar(250) NOT NULL,
  `order_deleted` tinyint(4) DEFAULT '0',
  `coupon` varchar(250) NOT NULL,
  PRIMARY KEY (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `yf_order_items`
--

CREATE TABLE IF NOT EXISTS `yf_order_items` (
  `item_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `goods_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `price` varchar(20) NOT NULL,
  `quantity` varchar(20) NOT NULL,
  `unit` varchar(20) NOT NULL,
  `total_prices` varchar(20) NOT NULL,
  `shop` varchar(50) NOT NULL,
  `item_deleted` tinyint(3) unsigned DEFAULT '0',
  PRIMARY KEY (`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `yf_sessions`
--

CREATE TABLE IF NOT EXISTS `yf_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(16) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `yf_sessions`
--

INSERT INTO `yf_sessions` (`session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`) VALUES
('029f2bf59f57998d1535434af4d9289e', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.114 Safari/537.36', 1402584862, ''),
('0de7b28225371a94249f722b7e29dfed', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.114 Safari/537.36', 1402584862, ''),
('306204d1dd338b2e2c4f8b27395c294b', '127.0.0.1', 'Mozilla/5.0 (iPhone; CPU iPhone OS 5_0 like Mac OS X) AppleWebKit/534.46 (KHTML, like Gecko) Version/5.1 Mobile/9A334 Sa', 1402585510, ''),
('3d0187f8346aaff5c5420cb7cf72564d', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.114 Safari/537.36', 1402584520, ''),
('6e7bbbd212d4f5285ede8911f348b2c9', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.114 Safari/537.36', 1402584862, ''),
('8827cf9d390aeccab86cf961c81a3240', '127.0.0.1', 'Mozilla/5.0 (iPhone; CPU iPhone OS 5_0 like Mac OS X) AppleWebKit/534.46 (KHTML, like Gecko) Version/5.1 Mobile/9A334 Sa', 1402585510, ''),
('95af5f0e37d5f56f7424edb3f9a1a998', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.114 Safari/537.36', 1402585510, ''),
('d2f61bd4708cccb6047b4955535aa053', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.114 Safari/537.36', 1402584862, ''),
('f586e4caa5371a4437a13e09ef3d11a0', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.114 Safari/537.36', 1402584862, '');

-- --------------------------------------------------------

--
-- 表的结构 `yf_shops`
--

CREATE TABLE IF NOT EXISTS `yf_shops` (
  `shop_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `community_id` int(10) NOT NULL,
  `shop_char` varchar(20) NOT NULL,
  `name` varchar(20) NOT NULL,
  `manager` varchar(50) NOT NULL,
  `address` varchar(200) NOT NULL,
  `phone` varchar(20) NOT NULL COMMENT '电话号码',
  `shop_hours` varchar(50) NOT NULL,
  `low_price` varchar(10) NOT NULL COMMENT '起送价',
  `discript` text NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `salt` varchar(50) NOT NULL,
  `token` varchar(50) NOT NULL,
  `view_today` int(10) NOT NULL,
  `view_yesterday` int(10) NOT NULL,
  `viewall` int(10) NOT NULL,
  `order` int(11) NOT NULL,
  `shop_ad` text NOT NULL COMMENT '商铺首页推荐信息',
  PRIMARY KEY (`shop_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `yf_shops`
--

INSERT INTO `yf_shops` (`shop_id`, `community_id`, `shop_char`, `name`, `manager`, `address`, `phone`, `shop_hours`, `low_price`, `discript`, `username`, `password`, `salt`, `token`, `view_today`, `view_yesterday`, `viewall`, `order`, `shop_ad`) VALUES
(1, 1, 'fruit shop', '便利店', '', '', '15210579218', '{"start_time":"8:30","close_time":"21:30"}', '19', '应有尽有', '', '', '', '', 0, 0, 0, 0, '<p><a href="#sort"></a></p><p><a href="#sort"><img src="/static/user/image/body2.png" /></a><a href="#sort"><img src="/static/user/image/body3.png" /></a><a href="#sort"><img src="/static/user/image/body4.png" /></a><a href="#sort"><img src="/static/user/image/body5.png" /></a><a href="#sort"><img src="/static/user/image/body1.png" /></a></p>');

-- --------------------------------------------------------

--
-- 表的结构 `yf_users`
--

CREATE TABLE IF NOT EXISTS `yf_users` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(32) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `token` varchar(40) NOT NULL,
  `salt` varchar(11) NOT NULL,
  `password` char(50) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `yf_zone_block`
--

CREATE TABLE IF NOT EXISTS `yf_zone_block` (
  `block_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `district_id` int(10) NOT NULL,
  `sort` int(10) NOT NULL,
  PRIMARY KEY (`block_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- 转存表中的数据 `yf_zone_block`
--

INSERT INTO `yf_zone_block` (`block_id`, `name`, `district_id`, `sort`) VALUES
(1, '牡丹园', 4, 100),
(2, '北下关', 4, 100),
(3, '大钟寺', 4, 100),
(4, '苏州街', 4, 100),
(5, '知春路', 4, 100),
(6, '五棵松', 4, 100),
(7, '航天桥', 4, 100),
(8, '颐和园', 4, 100);

-- --------------------------------------------------------

--
-- 表的结构 `yf_zone_community`
--

CREATE TABLE IF NOT EXISTS `yf_zone_community` (
  `community_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `block_id` int(10) unsigned NOT NULL,
  `sort` int(10) unsigned NOT NULL,
  PRIMARY KEY (`community_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- 转存表中的数据 `yf_zone_community`
--

INSERT INTO `yf_zone_community` (`community_id`, `name`, `block_id`, `sort`) VALUES
(1, '颐东苑', 1, 100),
(3, '万寿小区', 1, 100),
(4, '世纪城春荫园', 1, 100),
(5, '世纪金源', 1, 100),
(6, '西山壹号院', 1, 100),
(7, '保利西山林语', 2, 100),
(8, '世纪城三期晴雪园', 2, 100),
(9, '世纪城远大园六区', 2, 100),
(10, '世纪城晴波园', 3, 100),
(11, '世纪城垂虹园', 3, 100);

-- --------------------------------------------------------

--
-- 表的结构 `yf_zone_district`
--

CREATE TABLE IF NOT EXISTS `yf_zone_district` (
  `district_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(11) NOT NULL,
  `province_id` int(10) unsigned NOT NULL,
  `sort` int(10) unsigned NOT NULL,
  PRIMARY KEY (`district_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- 转存表中的数据 `yf_zone_district`
--

INSERT INTO `yf_zone_district` (`district_id`, `name`, `province_id`, `sort`) VALUES
(4, '海淀区', 1, 100),
(6, '西城区', 1, 100),
(7, '东城区', 1, 100),
(8, '宣武区', 1, 100),
(9, '房山区', 1, 100),
(10, '丰台区', 1, 100),
(11, '石景山区', 1, 100);

-- --------------------------------------------------------

--
-- 表的结构 `yf_zone_province`
--

CREATE TABLE IF NOT EXISTS `yf_zone_province` (
  `province_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `sort` int(10) unsigned NOT NULL,
  PRIMARY KEY (`province_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `yf_zone_province`
--

INSERT INTO `yf_zone_province` (`province_id`, `name`, `sort`) VALUES
(1, '北京', 100),
(3, '广东', 100);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
