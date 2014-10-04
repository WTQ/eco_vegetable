-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2014-10-04 14:57:24
-- 服务器版本： 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `eco_vegetable`
--

-- --------------------------------------------------------

--
-- 表的结构 `yf_order_online`
--

CREATE TABLE IF NOT EXISTS `yf_order_online` (
  `flow_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '流水号',
  `order_id` int(11) NOT NULL COMMENT '订单号，和order表关联',
  `total_fee` varchar(20) NOT NULL COMMENT '订单金额',
  `out_trade_no` varchar(30) NOT NULL COMMENT '商户唯一订单号',
  `status` varchar(20) NOT NULL COMMENT '订单状态',
  `trade_no` varchar(20) NOT NULL COMMENT '流水号',
  `create_time` int(20) NOT NULL,
  `done_time` int(20) NOT NULL,
  `payer` varchar(20) NOT NULL COMMENT '买家',
  PRIMARY KEY (`flow_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
