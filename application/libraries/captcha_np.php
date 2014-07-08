<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 用于产生验证码的类
 * Auther -- NPDONKEY
 * Copyright -- BIT NetPioneer
 * @class   NpVerifyImg
 * @package NP
 * @method  create
 * @method  display
 */
class Captcha_np {
    # 所使用的数组
    private $char   =   array(
        'a', 'b', 'c', 'd', 'e',
        'f', 'g', 'h', 'i', 'j',
        'k', 'l', 'm', 'n', 'o',
        'p', 'q', 'r', 's', 't',
        'u', 'v', 'w', 'x', 'y',
        'z'
    );
    # 使用样式
    private $style  =   0;
    # 验证码字符个数
    private $len    =   5;
    # 图片宽高
    private $width  =   70;
    private $height =   25;
    # 使用的字符串
    private $str    =   '';
    # 保存图像
    private $image  =   null;
    # 图片类型
    private $type   =   'png';
    # 图片背景颜色
    private $bg_color   =   array(255, 255, 255);
    # 图片字体颜色
    private $f_color    =   array(255, 255, 255);
    # 构造函数
    public function __construct ($str = '', $width = 122, $height = 40, $style = 0, $len = 5) {
        $this->width    =   ($width > 10 * $len) ? $width : 10 * ($len + 1);
        $this->height   =   $height;
        $this->style    =   $style;
        $this->len      =   $len;
        $this->str      =   ($str) ? $str : $this->getRandStr($this->len);
    }
    private function getRandStr ($len) {
        $str    =   '';
		$num = count($this->char);
        for ($i = 0; $i < $len; ++$i) {
            $str    .=  $this->char[rand(0, $num-1)];
        }
        return  $str;
    }
    private function getRandNum ($len) {
        $num    =   '';
        for ($i = 0; $i < $len; ++$i) {
            $num    .=  rand(0, 9);
        }
        return  $num;
    }
    private function getRandHex ($len) {
        $hex    =   '';
        for ($i = 0; $i < $len; ++$i) {
            $hex    .=  dechex(rand(1, 15));
        }
        return  $hex;
    }
    private function getMixedStr ($len) {
        $mix    =   '';
        for ($i = 0; $i < $len; ++$i) {
            $mix    .=  ($i % 2 != 0) ? $this->getRandNum(1) : $this->getRandStr(1);
        }
        return  $mix;
    }
    private function _createImage () {
        $this->image        =   imagecreate($this->width, $this->height);
        $background_color   =   imagecolorallocate($this->image, $this->bg_color[0], $this->bg_color[1], $this->bg_color[2]);
        $font_color         =   imagecolorallocate($this->image, $this->f_color[0], $this->f_color[1], $this->f_color[2]);
        switch ($this->style) {
            case 1:
                // 线条干扰
                $this->getMixedLine($this->image);
                break;
            case 2:
                // 雪花干扰
                $this->getMixedSnow($this->image);
                break;
            case 3:
                // 双重干扰
                $this->getMixedSnow($this->image);
                $this->getMixedLine($this->image);
                break;
            default:
        }
        imagettftext($this->image, 18, 0, 8, 23, $font_color, dirname(__FILE__) . '/arialbi.ttf', $this->str);
    }
    private function getMixedLine ($image) {
        if ($image) {
            for ($i = 0; $i < 10; ++$i) {
                $x1     =   rand(0, 100);
                $y1     =   ($x1 == 0) ? rand(0, 30) : 0;
                $x2     =   rand(0, 100);
                $y2     =   ($x2 == 100) ? rand(0, 30) : 30;
                imageline($image, $x1, $y1, $x2, $y2, imagecolorallocate($image, rand(0, 255), rand(0, 255), rand(0, 255)));
            }
        }
    }
    private function getMixedSnow ($image) {
        if ($image) {
            for ($i = 0; $i < 200; ++$i) {
                imagesetpixel($image, rand()%100, rand()%30, imagecolorallocate($image, rand(0, 255), rand(0, 255), rand(0, 255)));
            }
        }
    }
    public function display () {
        $this->_createImage();
        if ($this->image) {
            switch ($this->type) {
                case 'jpeg':
                    header("Content-type: image/jpeg");
                    imagejpeg($this->image);
                    break;
                case 'png':
                default:
                    header("Content-type: image/png");
                    imagepng($this->image);
            }
        } else {
            echo $this->str;
        }
    }
    public function setStyle ($num) {
        if (is_int($num) && $num < 4 && $num >= 0) {
            $this->style    =   $num;
        }
    }
    public function setBgColor ($color = array()) {
        if (is_array($color) && count($color) != 0) {
            $this->bg_color[0]  =   ($color[0] > 0 && $color[0] < 256) ? $color[0] : $this->bg_color[0];
            $this->bg_color[1]  =   ($color[1] > 0 && $color[1] < 256) ? $color[1] : $this->bg_color[1];
            $this->bg_color[2]  =   ($color[2] > 0 && $color{2} < 256) ? $color[2] : $this->bg_color[2];
        }
    }
    public function setFontColor ($color = array()) {
        if (is_array($color) && count($color) != 0) {
            $this->f_color[0]   =   ($color[0] > 0 && $color[0] < 256) ? $color[0] : $this->f_color[0];
            $this->f_color[1]   =   ($color[1] > 0 && $color[1] < 256) ? $color[1] : $this->f_color[1];
            $this->f_color[2]   =   ($color[2] > 0 && $color[2] < 256) ? $color[2] : $this->f_color[2];
        }
    }
    public function getStr () {
        return  $this->str;
    }
}
# 测试
# session_start();
# $img    =   new NpVerifyImg();
# $img->setStyle(3);
# $img->setBgColor(array(0, 23, 33));
# $img->setFontColor(array(255, 255, 235));
# $_SESSION['check'] = $img->getStr();
# $img->display();
# echo $_SESSION['d'];
# 使用方法，首先要开启session_start()
# 之后实例化一个图片验证对象，设置相关属性，将$_SESSION设置为$img->getStr()
# 最后执行$img->display()方法

