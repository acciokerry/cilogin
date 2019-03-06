<?php

abstract class ReportType{
    const __default = self::SALES_VENDOR; 

    const SALES_VENDOR      = 1;
    const OPEN_SALES_VENDOR = 2;
    const SHIP_TRACK_VENDOR = 3;
    const SHIPMENT_VENDOR   = 4;
    const RETURN_VENDOR     = 5;
}