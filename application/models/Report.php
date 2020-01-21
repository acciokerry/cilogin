<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Model{

	private $datadb;
	const LEFT	= 'left';
	const RIGHT = 'right';
	const CENTER = 'center';
	const JUSTIFY = 'justify';
	const VENDOR_ALL = "0";
	
	function __construct(){
		// create database instance
		$this->datadb = $this->load->database('mssql', TRUE);
		$this->load->helper('ReportType');
		
		$this->cust_group = $this->session->get_userdata()['groups'];
		
	}

	/**
	 * purchase overall
	 */
	function purchaseOverall($group, $vendor, $from, $to){
		$q = "SELECT DimCustomers.Customer_Group, 
			DimVendors.Vendor_Name , 
			SUBSTRING(DimDate.StandardDate,1,10) AS Purchase_Date, 
			Customer_PO AS Integrator_PO_Number, 
			Customer_Project_Number AS Project_Number, 
			[Item_Part_Number] AS Part_Number,  
			Line_Comment,
			Amount
			FROM FactSales
			INNER JOIN DimVendors
			ON DimVendors.Vendors_SK = FactSales.Vendors_SK
			INNER JOIN DimDate
			ON DimDate.Date_SK = FactSales.Date_SK
			INNER JOIN DimAccounts
			ON DimAccounts.Account_SK=FactSales.Account_SK
			INNER JOIN DimItems
			ON DimItems.Item_SK = FactSales.Item_SK
			INNER JOIN DimCustomers
			ON DimCustomers.Customer_SK = FactSales.Customer_SK
			WHERE Customer_Group = '".$group."'"; //nanti yg diutak atik
		if($vendor != $this::VENDOR_ALL){
			$q .= " AND FactSales.Vendors_SK = '".$vendor."'"; 
		}
		$q .= " AND DimDate.Date BETWEEN ('".$from."') AND ('".$to."') ORDER BY DimDate.Date";
			 //echo $q;
		$query = $this->datadb->query($q); 
		$result = $query->result();
		
		return $result;
	}

	function getPurchaseOverallColumnHeader(){
		return ['Customer Group' => 'Customer_Group', 
				'Vendor' => 'Vendor_Name', 
				'Purchase Date' => 'Purchase_Date', 
				'PO' => 'Integrator_PO_Number', 
				'Project Number' => 'Project_Number', 
				'Part Number' => 'Part_Number', 
				'Line Comment' => 'Line_Comment',
				'Amount' => 'Amount'];
	}

	function getPurchaseOverallColumnStyle(){
		return [
			'size' => ['Customer_Group' => 3, 
				'Vendor_Name' => 3, 
				'Purchase_Date' => 2, 
				'Integrator_PO_Number' => 2, 
				'Project_Number' => 1, 
				'Part_Number' => 1, 
				'Amount' => 1, 
				'Line_Comment' => 2
			],
			'align' => ['Customer_Group' => $this::LEFT, 
				'Vendor_Name' => $this::LEFT, 
				'Purchase_Date' => $this::CENTER, 
				'Integrator_PO_Number' => $this::CENTER, 
				'Project_Number' => $this::CENTER, 
				'Part_Number' => $this::CENTER, 
				'Amount' => $this::RIGHT, 
				'Line_Comment' => $this::LEFT
			]
		];
	}

	/**
	 * open order
	 */
	function openSales($group, $vendor, $from, $to){
		$q = "SELECT DimCustomers.Customer_Group, 
				DimVendors.Vendor_Name , 
				SUBSTRING(DimDate.StandardDate,1,10) AS Order_Date, 
				Document_Number AS PO_Number, 
				[Item_Part_Number] AS Part_Number, 
				Customer_Project_Number AS Project_Number, 
				[Status],
				Open_Amount
				FROM FactOpenSales
				INNER JOIN DimVendors
				ON DimVendors.Vendors_SK = FactOpenSales.Vendors_SK
				INNER JOIN DimDate
				ON DimDate.Date_SK = FactOpenSales.Date_SK
				INNER JOIN DimAccounts
				ON DimAccounts.Account_SK=FactOpenSales.Account_SK
				INNER JOIN DimItems
				ON DimItems.Item_SK = FactOpenSales.Item_SK
				INNER JOIN DimCustomers
				ON DimCustomers.Customer_SK = FactOpenSales.Customer_SK
				WHERE Customer_Group = '".$group."'";
			if($vendor!=$this::VENDOR_ALL){ 
				$q .= " AND FactOpenSales.Vendors_SK = '".$vendor."'";
			}
			$q .= " AND DimDate.Date BETWEEN ('".$from."') AND ('".$to."') ORDER BY DimDate.Date";
		//echo $q;
		$query = $this->datadb->query($q); 
		
		$result = $query->result();
		return $result;
	}

	public function getOpenSalesColumnHeader(){
		return [
			'Customer Group' => 'Customer_Group', 
			'Vendor' => 'Vendor_Name', 
			'Order Date' => 'Order_Date', 
			'PO' => 'PO_Number', 
			'Item part' => 'Part_Number', 
			'Project Number' => 'Project_Number', 
			'Status' => 'Status',
			'Open Amount' => 'Open_Amount'
		];
	}

	public function getOpenSalesColumnStyle(){
		return [
			'size' => [
				'Customer_Group'=>3, 
				'Vendor_Name'=>3, 
				'Order_Date'=>2, 
				'PO_Number'=>2, 
				'Part_Number'=>1, 
				'Project_Number'=>2, 
				'Open_Amount'=>2, 
				'Status'=>2
			],
			'align' => [
				'Customer_Group'=>$this::LEFT, 
				'Vendor_Name'=>$this::LEFT, 
				'Order_Date'=>$this::CENTER, 
				'PO_Number'=>$this::RIGHT, 
				'Part_Number'=>$this::CENTER, 
				'Project_Number'=>$this::LEFT, 
				'Open_Amount'=>$this::RIGHT, 
				'Status'=>$this::CENTER
			]
		];
	}

	/**
	 * shipment tracking
	 */
	function shipmentTracking($group, $vendor, $from, $to){
		$q = "SELECT DimCustomers.Customer_Group, 
				SUBSTRING(DimDate.StandardDate,1,10) AS Order_Date, 
				Document_Number AS PO_Number, 
				Tracking_Number,  
				DimDate2.StandardDate AS Ship_Date, 
				SO_Number AS PSA_SO_Number, 
				ISNULL(Customer_Project_Number,'-') AS Project_Number, 
				DimVendors.Vendor_Name, 
				DimItems.Item_Name, 
				ISNULL(Part_Number,'-') AS Part_Number, 
				Ship_Address, 
				ISNULL(Order_Memo,'-') AS Order_Memo, 
				ISNULL(Line_Comment,'-') AS Line_Comment, 
				Quantity, 
				Amount
				FROM FactShipTrack
				INNER JOIN DimVendors
				ON DimVendors.Vendors_SK = FactShipTrack.Vendors_SK
				INNER JOIN DimDate
				ON DimDate.Date_SK = FactShipTrack.Date_SK
				INNER JOIN DimItems
				ON DimItems.Item_SK = FactShipTrack.Item_SK
				INNER JOIN DimCustomers
				ON DimCustomers.Customer_SK = FactShipTrack.Customer_SK
				INNER JOIN DimDate DimDate2
				ON DimDate.Date_SK = FactShipTrack.Ship_Date
				WHERE Customer_Group = '".$group."'";
			if($vendor != $this::VENDOR_ALL){
				$q .= " AND FactShipTrack.Vendors_SK = '".$vendor."'";
			}
			$q .= " AND DimDate.Date BETWEEN ('".$from."') AND ('".$to."') ORDER BY DimDate.Date";
		//echo $q;
		$query = $this->datadb->query($q); 
		$result = $query->result();
		return $result;
	}

	public function getShipmentTrackingColumnHeader(){
		return ['Customer Group' => 'Customer_Group', 
				'Order Date' => 'Order_Date', 
				'PO' => 'PO_Number', 
				'Tracking Number' => 'Tracking_Number',  
				'Ship Date' => 'Ship_Date', 
				'SO' => 'PSA_SO_Number', 
				'Project Number' => 'Project_Number', 
				'Vendor' => 'Vendor_Name', 
				'Item' => 'Item_Name', 
				'Part' => 'Part_Number', 
				'Ship Address' => 'Ship_Address', 
				'Order Memo' => 'Order_Memo', 
				'Comment' => 'Line_Comment', 
				'Quantity' => 'Quantity', 
				'Amount' => 'Amount'];
	}

	public function getShipmentTrackingColumnStyle(){
		return [
			'size' => [
				'Customer_Group' => 3, 
				'Order_Date' => 2, 
				'PO_Number' => 2, 
				'Tracking_Number' => 3,  
				'Ship_Date' => 2, 
				'PSA_SO_Number' => 2, 
				'Project_Number' => 1, 
				'Vendor_Name' => 2, 
				'Item_Name' => 2, 
				'Part_Number' => 1, 
				'Ship_Address' => 3, 
				'Order_Memo' => 1, 
				'Line_Comment' => 1, 
				'Quantity' => 1, 
				'Amount' => 2
			],
			'align' => [
				'Customer_Group' => $this::LEFT, 
				'Order_Date' => $this::CENTER, 
				'PO_Number' => $this::CENTER, 
				'Tracking_Number' => $this::CENTER,  
				'Ship_Date' => $this::CENTER, 
				'PSA_SO_Number' => $this::CENTER, 
				'Project_Number' => $this::CENTER, 
				'Vendor_Name' => $this::LEFT, 
				'Item_Name' => $this::CENTER, 
				'Part_Number' => $this::CENTER, 
				'Ship_Address' => $this::LEFT, 
				'Order_Memo' => $this::CENTER, 
				'Line_Comment' => $this::CENTER, 
				'Quantity' => $this::CENTER, 
				'Amount' => $this::RIGHT
			]
		];
	}

	/**
	 * shipping detail
	 */
	function shippingDetail($group, $vendor, $from, $to){
		$q = "SELECT DimCustomers.Customer_Group, 
		SUBSTRING(DimDate.StandardDate,1,10) AS Order_Date, 
		Customer_PO AS PO_Number, 
		Customer_Project_Number AS Project_Number, 
		Shipping.Item_Name AS Shipping_Method, 
		DimVendors.Vendor_Name, 
		Lead_Time,
		LineCount,
		ItemTotal,  
		Quantity, 
		ShippingAmount
		FROM FactShipment
		INNER JOIN DimVendors
		ON DimVendors.Vendors_SK = FactShipment.Vendors_SK
		INNER JOIN DimDate
		ON DimDate.Date_SK = FactShipment.Date_SK
		INNER JOIN DimItems
		ON DimItems.Item_SK = FactShipment.Item_SK
		INNER JOIN DimCustomers
		ON DimCustomers.Customer_SK = FactShipment.Customer_SK
		INNER JOIN DimItems Shipping
		ON Shipping.Item_SK = FactShipment.Shipping_SK
		WHERE Customer_Group = '".$group."'";
		if($vendor != $this::VENDOR_ALL){ 
			$q .= " AND FactShipment.Vendors_SK = '".$vendor."'";
		} 
		$q .= " AND DimDate.Date BETWEEN ('".$from."') AND ('".$to."') ORDER BY DimDate.Date";
		$query = $this->datadb->query($q); 
		$result = $query->result();
		return $result;
	}

	public function getShippingDetailColumnHeader(){
		return [
				'Customer Group' => 'Customer_Group', 
				'Order Date' => 'Order_Date', 
				'PO' => 'PO_Number', 
				'Project Number' => 'Project_Number', 
				'Shipping Method' => 'Shipping_Method', 
				'Vendor' => 'Vendor_Name', 
				'Lead Time' => 'Lead_Time',
				'Line Count' => 'LineCount',
				'Item Total' => 'ItemTotal', 
				'Quantity' => 'Quantity', 
				'Shipping Amount' => 'ShippingAmount'
		];
	}

	public function getShippingDetailColumnStyle(){
		return [
			'size' => [
				'Customer_Group' => 3, 
				'Order_Date' => 1, 
				'PO_Number' => 1, 
				'Project_Number' => 1, 
				'Shipping_Method' => 2, 
				'Vendor_Name' => 3, 
				'ItemTotal' => 1, 
				'LineCount' => 1, 
				'Quantity' => 1, 
				'ShippingAmount' => 1, 
				'Lead_Time' => 1
			],
			'align' => [
				'Customer_Group' => $this::LEFT, 
				'Order_Date' => $this::CENTER, 
				'PO_Number' => $this::CENTER, 
				'Project_Number' => $this::CENTER, 
				'Shipping_Method' => $this::CENTER, 
				'Vendor_Name' => $this::LEFT, 
				'ItemTotal' => $this::RIGHT, 
				'LineCount' => $this::CENTER, 
				'Quantity' => $this::CENTER, 
				'ShippingAmount' => $this::RIGHT, 
				'Lead_Time' => $this::CENTER
			],
		];
	}

	/**
	 * return order
	 */
	function returnOrder($group, $vendor, $from, $to){
		$q = "SELECT DimCustomers.Customer_Group, 
		SUBSTRING(DimDate.StandardDate,1,10) AS [Date], 
		PO_Number,
		DimItems.Item_SK AS Item_Name,
		File_Number AS RMA, 				  
		DimReturnReasons.Reason_Name, 
		DimVendors.Vendor_Name, 
		Descriptions,
		Quantity, 
		Amount
		FROM FactReturn
		INNER JOIN DimVendors
		ON DimVendors.Vendors_SK = FactReturn.Vendors_SK
		INNER JOIN DimDate
		ON DimDate.Date_SK = FactReturn.Date_SK
		INNER JOIN DimItems
		ON DimItems.Item_SK = FactReturn.Item_SK
		INNER JOIN DimCustomers
		ON DimCustomers.Customer_SK = FactReturn.Customer_SK
		INNER JOIN DimReturnReasons
		ON DimReturnReasons.Reason_SK = FactReturn.Reason_SK
		WHERE Customer_Group = '".$group."'";
		if($vendor!=$this::VENDOR_ALL){ 
			$q .= " AND FactReturn.Vendors_SK = '".$vendor."'"; 
		}
		$q .= " AND DimDate.Date BETWEEN ('".$from."') AND ('".$to."')  
			ORDER BY DimDate.Date";
		
		$query = $this->datadb->query($q); 
		$result = $query->result();
		return $result;
	}

	public function getReturnColumnHeader(){
		return [
			'Customer Group' => 'Customer_Group', 
				'Date' => 'Date', 
				'PO#' => 'PO_Number',
				'Item Name' => 'Item_Name', 
				'RMA' => 'RMA',  
				'Reason' => 'Reason_Name', 
				'Vendor' => 'Vendor_Name', 
				'Desc' => 'Descriptions',
				'Quantity' => 'Quantity',
				'Amount' => 'Amount'
		];
	}

	public function getReturnColumnStyle(){
		return [
			'size' => [
				'Customer_Group' => 3, 
				'Date' => 1, 
				'PO_Number' => 3, 
				'Item_Name' => 3,
				'RMA' => 1, 
				'Amount' => 1, 
				'Quantity' => 1,  
				'Reason_Name' => 3, 
				'Vendor_Name' => 3, 
				'Descriptions' => 5
			],
			'align' => [
				'Customer_Group' => $this::LEFT, 
				'Date' => $this::CENTER, 
				'PO_Number' => $this::LEFT, 
				'Item_Name' => $this::LEFT,
				'RMA' => $this::CENTER, 
				'Amount' => $this::RIGHT, 
				'Quantity' => $this::CENTER,  
				'Reason_Name' => $this::LEFT, 
				'Vendor_Name' => $this::LEFT, 
				'Descriptions' => $this::LEFT
			]
		];
	}

	/**
	 * function to get vendors based on report's type/ Fact table
	 */
	public function getVendors($group, $param){
		$table = "FactSales";
		if($param == ReportType::SALES_VENDOR){
			$table = "FactSales";
		}else if($param==ReportType::OPEN_SALES_VENDOR){
			$table = "FactOpenSales";
		}else if($param==ReportType::SHIP_TRACK_VENDOR){
			$table = "FactShipTrack";
		}else if(ReportType::SHIPMENT_VENDOR){
			$table = "FactShipment";
		}else if($param==ReportType::RETURN_VENDOR){
			$table = "FactReturn";
		}else{
			return false;
		}

		$group = $this->decoding($group);
		$q = "SELECT DISTINCT(".$table.".Vendors_SK),
				DimVendors.Vendor_Name,
				DimVendors.Vendor_Ship_Address
				FROM ".$table."  
				INNER JOIN DimVendors
				ON ".$table.".Vendors_SK = DimVendors.Vendors_SK
				INNER JOIN DimCustomers
				ON ".$table.".Customer_SK = DimCustomers.Customer_SK
				WHERE DimCustomers.Customer_Group = '".$group."'
				ORDER BY Vendor_Name";
		//echo $q;
		$query = $this->datadb->query($q);
		$result = $query->result();
		return $result;
	}

	private function decoding($group){
		$group = str_replace('%20',' ', $group);
		$group = str_replace('%21','!', $group);
		$group = str_replace('%22','"', $group);
		$group = str_replace('%23','#', $group);
		$group = str_replace('%24','$', $group);
		$group = str_replace('%25','%', $group);
		$group = str_replace('%26','&', $group);
		$group = str_replace('%27','\'', $group);
		$group = str_replace('%28','(', $group);
		$group = str_replace('%29',')', $group);
		$group = str_replace('%2A','*', $group);
		$group = str_replace('%2B','+', $group);
		$group = str_replace('%2C',',', $group);
		$group = str_replace('%2D','-', $group);
		$group = str_replace('%2E','.', $group);
		$group = str_replace('%2F','/', $group);
		$group = str_replace('%3A',':', $group);
		$group = str_replace('%3B',';', $group);
		$group = str_replace('%3C','<', $group);
		$group = str_replace('%3D','=', $group);
		$group = str_replace('%3E','>', $group);
		$group = str_replace('%3F','?', $group);
		$group = str_replace('%40','@', $group);
		$group = str_replace('%5C','\\', $group);
		$group = str_replace('%5B','[', $group);
		$group = str_replace('%5D',']', $group);
		$group = str_replace('%5E','^', $group);

		return $group;
	}

	/**
	 * 
	 */
	public function getAllGroups(){
		$q = "SELECT DISTINCT(Customer_Group) FROM DimCustomers ORDER BY Customer_Group";
		$query = $this->datadb->query($q);
		return $query->result();
	}

	/**
	 * report's types
	 */
	public static function getReportType(){
		$reportType = [
			'Purchase Overall' 		=> 1,
			'Open Order (Backlog)' 	=> 2,
			'Shipment Tracking' 	=> 3,
			'Shipment Detail' 		=> 4,
			'Return' 				=> 5
		];
		return $reportType;
	}

	public function dataObjectToArray($obj){
		$data = array();
		foreach($obj as $key => $value){
			$temp = [];
			foreach($value as $k => $v){
				$temp[$k] = $v;
			}
			$data[] = $temp;
		}
		return $data;
	}

	function __destruct(){
		$this->datadb->close();
	}


}