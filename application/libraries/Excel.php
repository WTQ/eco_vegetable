<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* 
 *  ======================================= 
 *  Author     : Muhammad Surya Ikhsanudin 
 *  License    : Protected 
 *  Email      : mutofiyah@gmail.com 
 *   
 *  Dilarang merubah, mengganti dan mendistribusikan 
 *  ulang tanpa sepengetahuan Author 
 *  ======================================= 
 */  
require_once APPPATH."third_party/PHPExcel/PHPExcel.php"; 
 
class Excel_conf
{
	public $a = 0;
	public $b = 0;
	public $c = 0;
	public $d = 0;
	public $e = 0;
	public $f = 0;
	public $g = 0;
	public $h = 0;
	public $i = 0;
	public $j = 0;
	public $k = 0;
	public $l = 0;
	public $m = 0;

	/**
	 * 构造函数
	 *
	 * @param integer $uid
	 */
	public function __construct()
	{

	}
}

class Excel extends PHPExcel { 
	
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
    	$this->getActiveSheet()->setTitle('订单汇总表');
/*     	echo $this->ReaderPHPExcel->getSheet(0)->getColumnDimension('A')->getWidth().'xxx';
    	echo $this->ReaderPHPExcel->getSheet(0)->getColumnDimension('B')->getWidth().'xxx';
    	echo $this->ReaderPHPExcel->getSheet(0)->getColumnDimension('C')->getWidth().'xxx';
    	echo $this->ReaderPHPExcel->getSheet(0)->getColumnDimension('D')->getWidth().'xxx';
    	echo $this->ReaderPHPExcel->getSheet(0)->getColumnDimension('E')->getWidth().'xxx';
    	echo $this->ReaderPHPExcel->getSheet(0)->getColumnDimension('F')->getWidth().'xxx';
    	echo $this->ReaderPHPExcel->getSheet(0)->getColumnDimension('G')->getWidth().'xxx';
    	echo $this->ReaderPHPExcel->getSheet(0)->getColumnDimension('H')->getWidth().'xxx';
    	echo $this->ReaderPHPExcel->getSheet(0)->getColumnDimension('I')->getWidth().'xxx';
    	echo $this->ReaderPHPExcel->getSheet(0)->getColumnDimension('J')->getWidth().'xxx';
    	echo $this->ReaderPHPExcel->getSheet(0)->getColumnDimension('K')->getWidth().'xxx';
    	echo $this->ReaderPHPExcel->getSheet(0)->getColumnDimension('L')->getWidth().'xxx';
    	echo $this->ReaderPHPExcel->getSheet(0)->getColumnDimension('M')->getWidth().'xxx';
    	exit; */
    	// 设置列宽
     	$this->getActiveSheet()->getColumnDimension('A')->setWidth($this->ReaderPHPExcel->getSheet(0)->getColumnDimension('A')->getWidth());
    	$this->getActiveSheet()->getColumnDimension('B')->setWidth($this->ReaderPHPExcel->getSheet(0)->getColumnDimension('B')->getWidth());
    	$this->getActiveSheet()->getColumnDimension('C')->setWidth($this->ReaderPHPExcel->getSheet(0)->getColumnDimension('C')->getWidth());
    	$this->getActiveSheet()->getColumnDimension('D')->setWidth($this->ReaderPHPExcel->getSheet(0)->getColumnDimension('D')->getWidth() + 10);
    	$this->getActiveSheet()->getColumnDimension('E')->setWidth($this->ReaderPHPExcel->getSheet(0)->getColumnDimension('E')->getWidth() + 3);
    	$this->getActiveSheet()->getColumnDimension('F')->setWidth($this->ReaderPHPExcel->getSheet(0)->getColumnDimension('F')->getWidth());
    	$this->getActiveSheet()->getColumnDimension('G')->setWidth($this->ReaderPHPExcel->getSheet(0)->getColumnDimension('G')->getWidth()+1);
    	$this->getActiveSheet()->getColumnDimension('H')->setWidth($this->ReaderPHPExcel->getSheet(0)->getColumnDimension('H')->getWidth());
    	$this->getActiveSheet()->getColumnDimension('I')->setWidth($this->ReaderPHPExcel->getSheet(0)->getColumnDimension('I')->getWidth());
    	$this->getActiveSheet()->getColumnDimension('J')->setWidth($this->ReaderPHPExcel->getSheet(0)->getColumnDimension('J')->getWidth());
    	$this->getActiveSheet()->getColumnDimension('K')->setWidth($this->ReaderPHPExcel->getSheet(0)->getColumnDimension('K')->getWidth() + 10);
    	$this->getActiveSheet()->getColumnDimension('L')->setWidth($this->ReaderPHPExcel->getSheet(0)->getColumnDimension('L')->getWidth());
    	$this->getActiveSheet()->getColumnDimension('M')->setWidth($this->ReaderPHPExcel->getSheet(0)->getColumnDimension('M')->getWidth()+2); 
    	
    	 
    	// 设置行高度
    	$this->getActiveSheet()->getRowDimension('1')->setRowHeight(30);
//    	$this->getActiveSheet()->getRowDimension('2')->setRowHeight(90);   	
//    	$this->getActiveSheet()->getRowDimension('3')->setRowHeight(40);
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
    	$this->getActiveSheet()->getStyle('A2:M2')->getFont()->setSize(11)->setName('宋体')->setBold(true);
    	//设置水平居中
//    	$this->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    }
    
    public function set_table_header($shop)
    {
 //   	$shopinfo = $shop['manager']."\r\n".$shop['address']."\r\n".$shop['shop_hours']."\r\n".$shop['distribution'];
    	//合并cell
    	$this->getActiveSheet()->mergeCells('A1:M1');
    	    	
    	$this->setActiveSheetIndex(0)
    	->setCellValue('A1', '生态蔬菜'. date("Y-m-d"). '购买清单')
    	->setCellValue('A2', "系统单号")
    	->setCellValue('B2', '姓名')
    	->setCellValue('C2', '电话')
    	->setCellValue('D2', '商品名称')
    	->setCellValue('E2', '单价')
    	->setCellValue('F2', '数量')
    	->setCellValue('G2', '计价单位')
    	->setCellValue('H2', '总价约')
    	->setCellValue('I2', '实收金额')
    	->setCellValue('J2', '合计')
    	->setCellValue('K2', '地址')
    	->setCellValue('L2', '买家备注')
    	->setCellValue('M2', '是否配送');
    	$this->getActiveSheet()->getStyle('A2:M2')->getAlignment()->setWrapText(true)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
    	$this->getActiveSheet()->getStyle('A2:M2')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
    	$this->getActiveSheet()->getStyle('A1:M1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
    	$this->getActiveSheet()->getStyle('A1:M1')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
//    	$this->getActiveSheet()->getStyle('A2:M2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
//    	$this->getActiveSheet()->getStyle('A2:M2')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
    }
    
    public function order_add($Orders)
    {
    	// Miscellaneous glyphs, UTF-8
    		$row = 3;
    	for($i=0; $i < count($Orders); $i++ ){
    		$merge_start = $row;
    		$this->getActiveSheet(0)->setCellValue('A'.($row), $Orders[$i]['order_id']);
     		$this->getActiveSheet(0)->setCellValue('B'.($row), $Orders[$i]['username']);
    		$this->getActiveSheet(0)->setCellValue('C'.($row), $Orders[$i]['phone']);
//    		$this->getActiveSheet(0)->setCellValue('J'.($row), $Orders[$i]['total_prices']);
    		$this->getActiveSheet(0)->setCellValue('K'.($row), $Orders[$i]['address']);
    		//$this->getActiveSheet(0)->setCellValue('L'.($row), $Orders[$i]['remarks']);
    		$this->getActiveSheet(0)->setCellValue('L'.($row), (!empty($Orders[$i]['remarks'])) ? $Orders[$i]['remarks'] : '');
//     		$this->getActiveSheet(0)->setCellValue('M'.($row), $Orders[$i]['home_delivery'] == 1? '是':'否');
    		
    		foreach($Orders[$i]['items'] as $item) {
    			$this->getActiveSheet()->getRowDimension($row)->setRowHeight(20);
    			$this->getActiveSheet()->setCellValue('D'.($row), $item['name']);
    			$this->getActiveSheet()->setCellValue('E'.($row), $item['price']);
    			$this->getActiveSheet()->setCellValue('F'.($row), $item['quantity']);
    			$this->getActiveSheet()->setCellValue('G'.($row), $item['unit']);
    			$this->getActiveSheet()->setCellValue('H'.($row), $item['total_prices']);
    			$this->getActiveSheet()->setCellValue('I'.($row++), '');
    			$this->getActiveSheet()->getStyle('A'.($row-1).':M'.($row-1))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
    			$this->getActiveSheet()->getStyle('A'.($row-1).':M'.($row-1))->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
    		}
    		$merge_end = $row-1;
    		
    		$this->getActiveSheet()->mergeCells('A' . $merge_start . ':A' . $merge_end)
    		->mergeCells('B' . $merge_start . ':B' . $merge_end)
    		->mergeCells('C' . $merge_start . ':C' . $merge_end)
    		->mergeCells('J' . $merge_start . ':J' . $merge_end)
    		->mergeCells('K' . $merge_start . ':K' . $merge_end)
    		->mergeCells('L' . $merge_start . ':L' . $merge_end)
    		->mergeCells('M' . $merge_start . ':M' . $merge_end);
//    		$this->getActiveSheet()->getStyle('A'.($row).':M'.($i+4))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
//    		$this->getActiveSheet()->getStyle('A'.($row).':M'.($i+4))->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
//    		$this->getActiveSheet()->getRowDimension($i+4)->setRowHeight(16);
    	}
    	
    }
    
    public function set_active()
    {
    	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
    	$this->setActiveSheetIndex(0);
    }
    
    public function write($shop)
    {
    	$filename = '生态蔬菜'. date("Y-m-d"). '购买清单'.'.xls'; //save our workbook as this file name
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