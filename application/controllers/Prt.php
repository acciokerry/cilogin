<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Prt extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        //load model admin
        $this->load->model('Report');
        $this->load->library('Pdf');
		$this->load->helper('PDFHelper');
		$this->load->helper('DateHelper');
	}

	public function index()
	{

	}

	/**
	 * function to display report's form
	 */
	public function reportform(){
		$data = [
			'nama' => $this->session->get_userdata()['user_name'],
			'group' => $this->session->get_userdata()['groups'],
			'report_types' 	=> Report::getReportType(),
			'role' => $this->role
		];

		if($data['role']['admin']){
			$data['groups'] = $this->Report->getAllGroups();
		}
		
		$this->load->view('reportform', $data);
	}

	/**
	 * function to display report
	 */
	public function pcs(){
		if($this->input->post()){
			if($this->input->post('groups')!==null){
			//if(isset($this->input->post('groups'))){
				$group = $this->input->post('groups');
			}else{
				$group = $this->session->get_userdata()['groups'];
			}
			$vendor = $this->input->post('vendors');
			$from = $this->input->post('from');
			$to = $this->input->post('to');
			$type = $this->input->post('type');
			$output = $this->input->post('output');

			$this->print($type, $group, $vendor, $from, $to, $output);
		}else{
			return;
		}
		
	}

	public function print($type, $group, $vendor, $from, $to, $output){
		//ini_set("memory_limit","64M");
		// table's data
		$this->checkLogin();
		$rep_start = DateHelper::dateToString($from);
		$rep_end = DateHelper::dateToString($to);
		if($type == ReportType::SALES_VENDOR){
			$data = $this->Report->purchaseOverall($group, $vendor, $from, $to);
			$title = "Purchase Overall Report";
			$subject = "for period ".$rep_start." to ".$rep_end;
			$dataParams = $this->Report->getPurchaseOverallColumnHeader();
			$tableStyle = $this->Report->getPurchaseOverallColumnStyle();
		}else if($type==ReportType::OPEN_SALES_VENDOR){
			$data = $this->Report->openSales($group, $vendor, $from, $to);
			$title = "Open Sales Report";
			$subject = "for period ".$rep_start." to ".$rep_end;
			$dataParams = $this->Report->getOpenSalesColumnHeader();
			$tableStyle = $this->Report->getOpenSalesColumnStyle();
		}else if($type==ReportType::SHIP_TRACK_VENDOR){
			$data = $this->Report->shipmentTracking($group, $vendor, $from, $to);
			$title = "Shipment Tracking Report";
			$subject = "for period ".$rep_start." to ".$rep_end;
			$dataParams = $this->Report->getShipmentTrackingColumnHeader();
			$tableStyle = $this->Report->getShipmentTrackingColumnStyle();
		}else if($type==ReportType::SHIPMENT_VENDOR){
			$data = $this->Report->shippingDetail($group, $vendor, $from, $to);
			$title = "Shipping Report";
			$subject = "for period ".$rep_start." to ".$rep_end;
			$dataParams = $this->Report->getShippingDetailColumnHeader();
			$tableStyle = $this->Report->getShippingDetailColumnStyle();
		}else if($type==ReportType::RETURN_VENDOR){
			$data = $this->Report->returnOrder($group, $vendor, $from, $to);
			$title = "Return Report";
			$subject = "for period ".$rep_start." to ".$rep_end;
			$dataParams = $this->Report->getReturnColumnHeader();
			$tableStyle = $this->Report->getReturnColumnStyle();
		}
		
		if($output=='pdf'){
			$params = [
				'creator'=>'',
				'author'=>'',
				'company'=>'PSA Security Network',
				'company_addr' => "10170 Church Ranch Way Suite 150, Westminster, CO 80021",
				'logo'=>base_url().'img/logo_psa.png',
				'report_title'=>$title,
				'subject'=>$subject
			];
			
			$pdf = new PDFHelper('L'); // 'L' => landscape
			$pdf->setPdfParams($params)
				->callHeader()
				->setMargin(['left'=>PDF_MARGIN_LEFT,
							'top'=>PDF_MARGIN_TOP, 
							'right'=>PDF_MARGIN_RIGHT,
							'header'=>PDF_MARGIN_HEADER,
							'footer'=>PDF_MARGIN_FOOTER])
			
				->setTableData($data, $dataParams, $tableStyle)
				->callTableHtml()
				->printPdf();
		}elseif($output=='xls'){
			$data = $this->Report->dataObjectToArray($data);
			$spreadsheet = new Spreadsheet();
			$activeSheet = $spreadsheet->getActiveSheet();
			
			$activeSheet->setTitle($title);
			$activeSheet->setCellValue('A1', $title);
			$activeSheet->getStyle("A1")->getFont()->setSize(16);
			
			//output headers
			$activeSheet->fromArray(array_keys($dataParams), NULL, 'A3');
			//output values
			$activeSheet->fromArray($data, NULL, 'A4');

			$writer = new Xlsx($spreadsheet);
	 
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="'. $title .'.xlsx"'); 
			header('Cache-Control: max-age=0');
			
			$writer->save('php://output'); // download file 
		}
	}

	/**
	 * function to get vendors based on report's type/ Fact table
	 * return json
	 */
	public function getVendors($groups, $report_type){
		$vendor = $this->Report->getVendors($groups, $report_type);
		return $this->output
					->set_content_type('application/json')
					->set_output(json_encode($vendor));
	}

}
