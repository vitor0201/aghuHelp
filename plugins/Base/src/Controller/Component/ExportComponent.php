<?php
namespace Base\Controller\Component;

use Cake\Controller\Component;

class ExportComponent extends Component
{
	
	public $the_controller = null;
	
	public $config = [
		'delimiter' =>';',
		'escape_char'=> "\\",
		'enclosure'	=> '"',
		'max_time' 	=> 0
	];
	
	public $columns_witdh = [];
	
	public function initialize(array $config=[]) {
		
		parent::initialize($config);
		
		$this->config = $config + $this->config; 
		$this->the_controller = $this->_registry->getController();
	}
	
	public function CSV($name, $query, $columns=[], $callback){
		
		ini_set('max_execution_time', $this->config['max_time']);
		set_time_limit($this->config['max_time']);
		
		$this->the_controller->autoRender = false;
		header('Content-type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename='.$name);
		
		$out = fopen('php://output', 'w');
		
		if(!empty($columns)) {
			$columns = array_map("utf8_decode", $columns);
			$columns = str_replace(array("\n\r", "\n", "\r"), '', $columns);
			fputcsv($out, $columns, $this->config['delimiter'], $this->config['enclosure']);
		}
		
		foreach ($query as $data) {
			$row = $callback($data);
			$row = array_map("utf8_decode", $row);
			$row = str_replace(array("\n\r", "\n", "\r"), '', $row);
			fputcsv($out, $row, $this->config['delimiter'], $this->config['enclosure']);
		}
		fclose($out);
		//debug($name);
		//$this->the_controller->response->type('text/csv');
		//$this->the_controller->viewBuilder()->layout('Base.csv');
		//$this->the_controller->response->download($name);
		exit;
		
	}
	
	public function PDF($name, $query, $columns=[], $callback){
		$pdf = new \fpdf\FPDF();
		 
		$pdf->SetMargins(10,10,10);
		$pdf->AddPage();
		$pdf->SetFont('arial','',9);
		
// 		if(!empty($columns)) {
// 			$columns = array_map("utf8_decode", $columns);
// 			$columns = str_replace(array("\n\r", "\n", "\r"), '', $columns);
// 			fputcsv($out, $columns, $this->config['delimiter'], $this->config['enclosure']);
// 		}
		$i = 0;
		
		$defaultSize = 190 / count($columns);
		
		foreach ($query as $data) {
			$width = isset($this->columns_witdh[$i]) ? $this->columns_witdh[$i] : $defaultSize;
			
			$row = $callback($data);
			$row = array_map("utf8_decode", $row);
			foreach($row as $value) {
				$pdf->Cell($width,6,$value,1,0,'L');
			}
			$pdf->ln();
// 			$row = str_replace(array("\n\r", "\n", "\r"), '', $row);
// 			fputcsv($out, $row, $this->config['delimiter'], $this->config['enclosure']);
		}
		
		
		$pdf->Output($name.".pdf","D");

		$this->the_controller->response->type('pdf');
		$this->the_controller->viewBuilder()->layout('Base.pdf');
	}
		
}