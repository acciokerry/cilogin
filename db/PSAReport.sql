----Purchases Overall Report----
SELECT DimCustomers.Customer_Group, DimVendors.Vendor_Name , DimDate.StandardDate AS Purchase_Date, Customer_PO AS Integrator_PO_Number, Customer_Project_Number AS Project_Number, [Item_Part_Number] AS Part_Number, Amount, Line_Comment
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
WHERE Customer_Group = '' ------Dari session-----
AND FactSales.Vendors_SK = '' ----Dari Drop Down-----
AND DimDate.StandardDate BETWEEN ('') AND ('') -----Dari Drop Down-----

----Open Order (Backlog) Report----
SELECT DimCustomers.Customer_Group, DimVendors.Vendor_Name , DimDate.StandardDate AS Order_Date, Document_Number AS PO_Number, [Item_Part_Number] AS Part_Number, Customer_Project_Number AS Project_Number, Open_Amount, [Status]
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
WHERE Customer_Group = '' ------Dari session-----
AND FactOpenSales.Vendors_SK = '' ----Dari Drop Down-----
AND DimDate.StandardDate BETWEEN ('') AND ('') -----Dari Drop Down-----


----Shipment Tracking Report----
SELECT DimCustomers.Customer_Group, DimDate.StandardDate AS Order_Date, Document_Number AS PO_Number, Tracking_Number,  DimDate2.StandardDate AS Ship_Date, SO_Number AS PSA_SO_Number, Customer_Project_Number AS Project_Number, DimVendors.Vendor_Name, DimItems.Item_Name, Part_Number, Ship_Address, Order_Memo, Line_Comment, Quantity, Amount
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
WHERE Customer_Group = '' ------Dari session-----
AND FactShipTrack.Vendors_SK = '' ----Dari Drop Down-----
AND DimDate.StandardDate BETWEEN ('') AND ('') -----Dari Drop Down-----

----Shipping Detail Report----
SELECT DimCustomers.Customer_Group, DimDate.StandardDate AS Order_Date, Customer_PO AS PO_Number, Customer_Project_Number AS Project_Number, Shipping.Item_Name AS Shipping_Method, DimVendors.Vendor_Name, ItemTotal, LineCount, Quantity, ShippingAmount, Lead_Time
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
WHERE Customer_Group = '' ------Dari session-----
AND FactShipment.Vendors_SK = '' ----Dari Drop Down-----
AND DimDate.StandardDate BETWEEN ('') AND ('') -----Dari Drop Down-----


----
SELECT DimCustomers.Customer_Group, DimDate.StandardDate AS [Date], PO_Number, File_Number AS RMA, Amount, Quantity,  DimReturnReasons.Reason_Name, DimVendors.Vendor_Name, Descriptions
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
WHERE Customer_Group = '' ------Dari session-----
AND FactReturn.Vendors_SK = '' ----Dari Drop Down-----
AND DimDate.StandardDate BETWEEN ('') AND ('') -----Dari Drop Down-----