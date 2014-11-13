<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* 
 *  ======================================= 
 *  Author     : lizzyphy
 *  License    : Protected 
 *   
 *  Dilarang merubah, mengganti dan mendistribusikan 
 *  ulang tanpa sepengetahuan Author 
 *  ======================================= 
 */  
require_once APPPATH."third_party/PHPExcel/PHPExcel.php"; 
 
class Order_goods_excel_conf
{
	public $a = 0;
	public $b = 0;
	public $c = 0;
	/**
	 * 构造函数
	 *
	 * @param integer $uid
	 */
	public function __construct()
	{

	}
}

class Order_goods_excel extends PHPExcel { 
	
	public $ReaderPHPExcel;
	
    public function __construct() { 
        parent::__construct(); 
    } 
    
    public function index($Orders, $shop)
    {
    	$this->read();
    	$this->set_doc_property();
    	$this->set_active();
    	$this->set_table_header($shop);
    	$this->set_table_property();
    	
    	$this->order_add($Orders);	
    	$this->write($shop);
    }

    // Set document properties
    public function set_doc_property()
    {
    	$this->getProperties()->setCreator("eco")
    	->setLastModifiedBy("eco")
    	->setTitle("eco Order")
    	->setSubject("Order")
    	->setDescription("eco Order.")
    	->setKeywords("Order")
    	->setCategory("Order");
    }
    
    public function set_table_property()
    {
    	// 设置A4纸张
    	$this->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
    	 
    	// sheet命名
    	$this->getActiveSheet()->setTitle('订单商品统计表');
    	// 设置列宽
     	$this->getActiveSheet()->getColumnDimension('A')->setWidth($this->ReaderPHPExcel->getSheet(0)->getColumnDimension('A')->getWidth()+50);
    	$this->getActiveSheet()->getColumnDimension('B')->setWidth($this->ReaderPHPExcel->getSheet(0)->getColumnDimension('B')->getWidth());
    	$this->getActiveSheet()->getColumnDimension('C')->setWidth($this->ReaderPHPExcel->getSheet(0)->getColumnDimension('C')->getWidth()+10);
    	
    	 
    	// 设置行高度
    	$this->getActiveSheet()->getRowDimension('1')->setRowHeight(30);
    	$this->getActiveSheet()->getRowDimension('2')->setRowHeight(40);
    	//set font size bold
    	$this->getActiveSheet()->getDefaultStyle()->getFont()->setSize(11)->setName('宋体');
    	//设置表头标题字体
    	$this->getActiveSheet()->getStyle('A1')->getFont()->setSize(18)->setName('宋体');
    	//设置表头标题对齐方式
    	$this->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    	//设置店铺信息字体
//    	$this->getActiveSheet()->getStyle('A2')->getFont()->setSize(12)->setName('宋体');
    	//设置标题字体
//    	$this->getActiveSheet()->getStyle('A3:M3')->getFont()->setSize(11)->setName('宋体')->setBold(true);
    	$this->getActiveSheet()->getStyle('A2:C2')->getFont()->setSize(11)->setName('宋体')->setBold(true);
    	//设置水平居中
//    	$this->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    }
    
    public function set_table_header($shop)
    {
 //   	$shopinfo = $shop['manager']."\r\n".$shop['address']."\r\n".$shop['shop_hours']."\r\n".$shop['distribution'];
    	//合并cell
    	$this->getActiveSheet()->mergeCells('A1:C1');
    	    	
    	$this->setActiveSheetIndex(0)
    	->setCellValue('A1', '生态蔬菜'. date("Y-m-d"). '订单商品统计表')
    	->setCellValue('A2', "订单商品")
    	->setCellValue('B2', '商品数量')
    	->setCellValue('C2', '商品分类');
    	$this->getActiveSheet()->getStyle('A2:C2')->getAlignment()->setWrapText(true)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
    	$this->getActiveSheet()->getStyle('A2:C2')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
    	$this->getActiveSheet()->getStyle('A1:C1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
    	$this->getActiveSheet()->getStyle('A1:C1')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
//    	$this->getActiveSheet()->getStyle('A2:C2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
//    	$this->getActiveSheet()->getStyle('A2:C2')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
    }
    
    public function order_add($Orders)
    {
    	// Miscellaneous glyphs, UTF-8
    		$row = 3;
    	foreach($Orders as $order ){
    		$this->getActiveSheet(0)->setCellValue('A'.($row), $order['name']);
     		$this->getActiveSheet(0)->setCellValue('B'.($row), $order['SUM(quantity)']);
    		$this->getActiveSheet(0)->setCellValue('C'.($row), $order['class_name']);
    		$this->getActiveSheet()->getStyle('A'.($row).':C'.($row))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
    		$this->getActiveSheet()->getStyle('A'.($row).':C'.($row))->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
    		$this->getActiveSheet()->getRowDimension($row)->setRowHeight(20);
    		$row++;
    	}
    	
    }
    
    public function set_active()
    {
    	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
    	$this->setActiveSheetIndex(0);
    }
    
    public function write($shop)
    {
    	$filename = '生态蔬菜'. date("Y-m-d"). '订单商品统计表'.'.xls'; //save our workbook as this file name
    	$filename = iconv("UTF-8","GB2312//IGNORE",$filename);
    	
    	//header('Content-Type: application/octet-stream');
    	header('Content-Transfer-Encoding:binary');
    	header('Pragma: public');
    	header('Expires: 0');
		header('Cache-Control:must-revalidate, post-check=0, pre-check=0');
    	header('Content-Type:application/vnd.ms-excel'); //mime type
    	header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
    	//header('Cache-Control: max-age=0'); //no cache
    	// Save Excel 2007 file
    	$objWriter = PHPExcel_IOFactory::createWriter($this, 'Excel5');
    	//$objWriter->save(str_replace('.php', '.xlsx', __FILE__));
    	$objWriter->save('php://output');
    }
    public function read()
    {
//    	$config = new Excel_conf();
    	$excelfilename = dirname(__FILE__) . "/templates.xlsx";
    	//$excelfilename = dirname(__FILE__);
    	$reader = PHPExcel_IOFactory::createReader('Excel2007');
    	$this->ReaderPHPExcel = $reader->load($excelfilename);
    }
}