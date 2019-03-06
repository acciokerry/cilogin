<?php

class DateHelper{
    
    public static function dateToString($date){
        $dateSplit = explode("/",$date);

        return self::month($dateSplit[0])." ".$dateSplit[1].", ".$dateSplit[2];
    }

    private static function month($month){
        switch($month){
            case "01":
                return 'January';
                //return 'Jan';
            case '02':
                return 'February';
                //return 'Feb';
            case '03':
                return 'March';
                //return 'Mar';
            case '04':
                return 'April';
                //return 'Apr';
            case '05':
                return 'May';
            case '06':
                return 'June';
                //return 'Jun';
            case '07':
                return 'July';
                //return 'Jul';
            case '08':
                return 'August';
                //return 'Aug';
            case '09':
                return 'September';
                //return 'Sep';
            case '10':
                return 'October';
                //return 'Oct';
            case '11':
                return 'November';
                //return 'Nov';
            case '12':
                return 'December';
                //return 'Dec';
            default:
                break;
        }

    }
}