<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* 
 *  ======================================= 
 *  Author     :  
 *  ======================================= 
 */  
require_once APPPATH . "third_party/PHPWord/PHPWord.php"; 

class Word extends PHPWord {
	public function __construct() {
		parent::__construct();
	}
	
	public function  index($Orders) 
	{
		foreach ($Orders as $order)
		{
			$section = $this->createSection();
			$this->add_table1($order,$section);
			$this->add_table2($order['items'],$section);
			$this->add_table3($order,$section);
			//$section->addPageBreak();
		}
		
		// Save File
		$objWriter = PHPWord_IOFactory::createWriter($this, 'Word2007');
		$filename = '生态蔬菜'. date("Y-m-d"). '批量打印订单'.'.doc'; //save our workbook as this file name
		$filename = iconv("UTF-8","GB2312//IGNORE",$filename);
		header('Content-Type: application/vnd.ms-word'); //mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
		
		$objWriter->save('php://output');
	}
	
	public function add_table1($order,$section)
	{
		$styleTable = array(
			'border'        => 0,
			'cellMarginTop' => 100,
			'cellMarginBottom' => 100,
			'alignMent'     => 'left',
		);
		$fontStyle1 = array(
			'size'  => 10,
			'bold'  => true,
		    'color' => '000000',
			'align' => 'left'
		);
		$fontStyle2 = array(
				'size'  => 10,
				'bold'  => true,
				'color' => '000000',
				'align' => 'right'
		);
		$this->addTableStyle('myTable1', $styleTable);
		$this->addFontStyle('Font1', $fontStyle1);
		$this->addFontStyle('Font2', $fontStyle2);
		$table = $section->addTable('myTable1');
		$table->addRow(300);
		$table->addCell(1500)->addText('订单号：' . $order['order_id'], 'Font1');
		$table->addCell(3600)->addText('下单时间：' . date('Y-m-d H:i:s', $order['add_time']), 'Font1');
		$table->addCell(3200)->addText('客户姓名：' . $order['username'], 'Font1');
		$table->addCell(1500)->addText('商品总数：' . $order['num'], 'Font2');
		$table->addRow(300);
		$table->addCell(1500,array('cellMerge' => 'restart', 'valign' => "center"))->addText('配送地址：' . $order['address'], 'Font1');
		$table->addCell(3600,array('cellMerge' => 'continue', 'valign' => "center"));
		$table->addCell(3200,array('cellMerge' => 'continue', 'valign' => "center"));
		$table->addCell(1500,array('cellMerge' => 'continue', 'valign' => "center"));
	}
	
	public function add_table2($items,$section)
	{
		$styleTable = array(
				'borderSize'  => 1,
				'borderColor' => '000000'
				
		);
		$styleCell = array('valign'=>'center');
		$styleCellBTLR = array('valign'=>'center','textDirection'=>PHPWord_Style_Cell::TEXT_DIR_BTLR);
		$fontStyle3 = array(
				'size'  => 12,
				'bold'  => true,
				'color' => '000000',
				'align' => 'center'
		);
		$fontStyle4 = array(
				'size'  => 12,
				'bold'  => false,
				'color' => '000000',
				'align' => 'left'
		);
		$this->addTableStyle('myTable2', $styleTable);
		$this->addFontStyle('Font3', $fontStyle3);
		$this->addFontStyle('Font4', $fontStyle4);
		$table = $section->addTable('myTable2');
		$table->addRow(600);
		$table->addCell(1200,$styleCell)->addText('商品编号', 'Font3');
		$table->addCell(5000,$styleCell)->addText('商品名称', 'Font3');
		$table->addCell(800,$styleCell)->addText('数量', 'Font3');
		$table->addCell(1400,$styleCell)->addText('价格（元）', 'Font3');
		$table->addCell(1400,$styleCell)->addText('小计（元）', 'Font3');
		foreach ($items as $item)
		{
			$table->addRow(600);
			$table->addCell(1200,$styleCell)->addText('     '. $item['goods_id'], 'Font4');
			$table->addCell(5000,$styleCell)->addText('   '. $item['name'], 'Font4');
			$table->addCell(800,$styleCell)->addText('    '. $item['quantity'], 'Font4');
			$table->addCell(1400,$styleCell)->addText('   '. $item['price'], 'Font4');
			$table->addCell(1400,$styleCell)->addText('   '. $item['total_prices'], 'Font4');
		}
	}
	
	public function add_table3($order,$section)
	{
		$styleTable = array(
				'border' => 0,
				'cellMarginTop' => 100,
				'alignMent' => 'right',
		);
		$fontStyle5 = array(
				'size'  => 10,
				'bold'  => true,
				'color' => '000000',
				'align' => 'right'
		);
		$fontStyle6 = array(
				'size'  => 10,
				'bold'  => true,
				'color' => '000000',
				'align' => 'center'
		);
		$this->addTableStyle('myTable3', $styleTable);
		$this->addFontStyle('Font5', $fontStyle5);
		$this->addFontStyle('Font6', $fontStyle6);
		$table = $section->addTable('myTable3');
		$table->addRow(300);
		$table->addCell(1600);
		$table->addCell(3000);
		$table->addCell(2500);
		$table->addCell(1200)->addText('订单总价：', 'Font5');
		$table->addCell(1000)->addText($order['total_prices'] . '元', 'Font6');
	}
}
