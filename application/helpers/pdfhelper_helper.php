<?php
define("COMPANY_LOGO","logo_psa.png");

class PDFHelper extends TCPDF{

	// header
	private $header; // [logo, company name, company]
	//private PDF_HEADER_LOGO
	// table

	//public function __construct($creator, $author, $title, $subject, $keywords){
	public function __construct($orientation=PDF_PAGE_ORIENTATION){
		
		parent::__construct($orientation, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		return $this;		
	}

	/**
	 * 
	 */
	public function setPdfParams($params){

		$this->setCreator($params['creator']);
		$this->SetAuthor($params['author']);
		$this->company_name = $params['company'];
		$this->company_addr = $params['company_addr'];
		$this->SetSubject($params['subject']);
		$this->logo =$params['logo'];
		$this->reportTitle = $params['report_title'];
		//$this->reportPeriod = $params['report_period'];
		//$this->reportDesc = $params['report_desc'];
		//echo $this->logo;
		return $this;
	}

	public function setTableData($data=array(), $columnsName=array(), $tableData=array()){
		
		$this->columnName = $columnsName;
		$this->numOfColumns = sizeof($columnsName);
		$this->tableData = $data;
		$this->columnSize = $tableData['size'];
		$this->columnAlign = $tableData['align'];
		return $this;
	}

	//Page header
    public function Header() {
        // Logo
        $image_file = K_PATH_IMAGES.COMPANY_LOGO;
        $this->Image($image_file, 15, 10, 30, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        // Set company name n addr
        $html = '<table cellspacing="0" cellpadding="1" border="0"><tr><td >'.$this->company_name.'</td></tr><tr><td style="font-size:7px;">'.$this->company_addr.'</td></tr></table>';
     	$this->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = 'top', $autopadding = true);

		$this->Line(15, $this->y, $this->w - 15, $this->y);
    }

	public function callHeader(){
		$this->SetHeaderData(COMPANY_LOGO, PDF_HEADER_LOGO_WIDTH, $this->company_name, $this->company_addr);
		return $this;
	}

	public function autoPageBreak(){
		$this->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		return $this;
	}

	public function setMargin($margin){
		$this->SetMargins($margin['left'], $margin['top'], $margin['right']);
		$this->SetHeaderMargin($margin['header']);
		$this->SetFooterMargin($margin['footer']);
		return $this;
	}

	public function callFooter(){
		$this->setFooterData(array(0,64,0), array(0,64,128));
		return $this;
	}

	public function callTableHtml($columnsWidth=null){
		
		$this->addPage();
		if(null==$this->columnSize || sizeof($this->columnSize)!=sizeof($this->columnName)){
			$size = 100/sizeof($this->columnName);
			//$columnsWidth = [];
			//for($i=0;$i<sizeof($this->columnName);$i++){
			foreach($this->columnName as $key => $value){
				$this->columnSize[$value] = $size;
			}
		}else{
			$size = 0;
			foreach($this->columnSize as $key => $value){
				$size += $value;
			}

			foreach($this->columnSize as $key => $value){
				$this->columnSize[$key] = 100*($value/$size);
			}
		}
		$numData = sizeof($this->tableData);
		if($numData>0){
			//$ndxNumCol = $this->getColumnIndexContainNumber($this->tableData[0]);
			$ndxNumCol = $this->getColumnNameIndexContainNumber($this->columnName);
		}
		$html='<h3 align="center">'.$this->reportTitle.'</h3>
				<h4 align="center">'.$this->subject.'</h4>
				<table cellspacing="1" bgcolor="#666666" cellpadding="2">
				<thead>
					<tr bgcolor="#0984e3" color="#ffffff">';
		$i = 0;
		foreach($this->columnName as $key => $value){
			$html .= '<th width="'.$this->columnSize[$value].'%" align="center">'.$key.'</th>';
			$i++;
		}
		$this->SetFont('helvetica', '', 8);
		$html .= '</tr></thead><tbody>';
		$fill = false;
		if(sizeof($this->tableData)==0){
			$html .= '<tr bgcolor="#ffffff"><td colspan="'.sizeof($this->columnSize).'" align="center"> NO DATA </td></tr>';
		}else{
			$total = [];
			$colAmount = 0;
			foreach($ndxNumCol as $value){
				$total[$value] = 0;
			}
			foreach ($this->tableData as $key => $value) 
				{
					$i = 0;
					if($fill){
						$html.='<tr bgcolor="#b2bec3" nobr="true">';//$color = "#dfe6e9";
						$fill = false;
					}else{
						$html.='<tr bgcolor="#ffffff" nobr="true">';//$color = "#ffffff";
						$fill = true;
					}
					foreach($this->columnName as $k => $v){
						if(strpos($v, 'Amount')!== false || strpos($v, 'Total')!== false){ 
							$html .= '<td align="'.$this->columnAlign[$v].'" width="'.$this->columnSize[$v].'%">$'.number_format($value->$v,0).'</td>';
							if($colAmount==0){
								$colAmount = $i;
							}
						}else{
							$html .= '<td align="'.$this->columnAlign[$v].'" width="'.$this->columnSize[$v].'%">'.utf8_encode($value->$v).'</td>';
						}
						if(in_array($i, $ndxNumCol)){
							if(array_key_exists($i,$total)){
								$total[$i] += $value->$v;
							}
						}
						$i++;
					}
							
					$html .= '</tr>';
				}
			if($numData>0){
				$html .= '<tr bgcolor="#ffffff" nobr="true" style="font-weight:bold;">';
				$html .= '<th align="center">Total</th>';
				for($i=1;$i<sizeof($this->columnSize);$i++){
					if(array_key_exists($i,$total)){
						$val = number_format($total[$i],0);
						if($i==$colAmount){
							$val = '$'.$val;
						}
						$html .= '<th align="right">'.$val.'</th>';
					}else{
						$html .= '<th ></th>';
					}
				}
				$html .= '</tr>';
			}
		}
		$html .= '</tbody></table>';
		//echo $html;
		$this->writeHTML($html);
		return $this;
	}

	private function getColumnIndexContainNumber($firstArrayofData){
		$ret = [];
		$count = 0;
		foreach($firstArrayofData as $key => $value){
			if(is_numeric($value)){
				if(substr($value,0,1)!='0'){
					$ret[] = $count++;
					continue;
				}
			}
			$count++;
		}
		return $ret;
	}

	private function getColumnNameIndexContainNumber($columnName){
		$ret = [];
		$count = 0;
		foreach($columnName as $key=>$value){
			if(strpos($value,"Amount")!==false 
				|| strpos($value,"Total")!==false
				|| strpos($value,"Quantity")!==false
				|| strpos($value,"Count")!==false){
				$ret[] = $count++;
				continue;
			}
			$count++;
		}

		return $ret;
	}

	public function printPdf(){
		$this->Output($this->reportTitle.'.pdf', 'I');
	}
	
}