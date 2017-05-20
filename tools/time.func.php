<?php
/*
 * Created on Jul 11, 2008
 *
 * Author: Qingfeng Huang
 * Email: qingfeng@qhuang.com
 * 
 */
 
 /* input format: yyyy-mm-dd */
 function dayssince($date){
 	$date_diff = round( abs(strtotime(date('y-m-d'))-strtotime($date)) / 86400, 0 );
 	//$date_diff = abs(strtotime(date('y-m-d'))-strtotime($date)) / 86400;
 	return $date_diff;
 }
 
 //echo dayssince("2005-10-07")."<hr>"; 
 //echo dayssince("2008-02-19")."<hr>";
 //echo dayssince("2008-10-15");
 
function getdays($day1,$day2) 
{ 
  return round((strtotime($day2)-strtotime($day1))/(24*60*60),0); 
} 
 
 
function fnc_date_calc($this_date,$num_days){
    
    $my_time = strtotime ($this_date); //converts date string to UNIX timestamp
    $timestamp = $my_time + ($num_days * 86400); //calculates # of days passed ($num_days) * # seconds in a day (86400)
     $return_date = date("Y/m/d",$timestamp);  //puts the UNIX timestamp back into string format
    
    return $return_date;//exit function and return string
}//

function week($year, $week)
{
    $from = date("Y-m-d", strtotime("{$year}-W{$week}-1")); //Returns the date of monday in week
    $to = date("Y-m-d", strtotime("{$year}-W{$week}-7")); //Returns the date of sunday in week
    return "Week {$week} in {$year} is from {$from} to {$to}.";
}
//echo week(2008,27);

function getDaysBetween($startDate, $endDate, $daysstr)
{
    $days = explode(',', $daysstr);
    //var_dump ($days);
    $dates = array();
    foreach($days as $day)
    {
    	
       //echo $day."<hr>";
        $newDate = $startDate;
        switch ($day){
            case 'Su':
            case 'Sun':
                $day = 'Sun';
                break;
            case 'M':
            case 'Mon':
                $day = 'Mon';
                break;
            case 'T':
            case 'Tu':
            case 'Tue':
                $day = 'Tue';
                break;
            case 'W':
            case 'Wed':
                $day = 'Wed';
                break;
            case 'Th':
            case 'Thu':
            case 'Thur':
                $day = 'Thu';
                break;
            case 'F';
            case 'Fri';
                $day = 'Fri';
                break;
            case 'S':
            case 'Sat':
                $day = 'Sat';
                break;
            default:
                continue 2;
        }
        
        $endtime = strtotime($endDate);
        $newDate = $startDate.' next '.$day;
        while(($date = strtotime($newDate)) <= $endtime){
            $dates[] = date('Y-m-d', $date)."\n";
            $newDate = date('Y-m-d', $date).' next '.$day;
        }

    }

    $dates=array_unique($dates);
    sort($dates);
    return $dates;
} 

function getWeekdaysInMonth($year,$month,$daystr){
	$totaldays=cal_days_in_month(CAL_GREGORIAN, $month, $year);
	return count(getDaysBetween($year."-".$month."-1",$year."-".$month."-".$totaldays,$daystr));
}
//$days=getDaysBetween("2009-9-1","2009-9-30","M,W"); print_r($days);
//$days=getDaysBetween("2009-9-1","2009-10-31","W"); print_r($days);
//echo date('Y-m-t');
//echo getWeekdaysInMonth(2009,8,"M");
//$days=getDaysBetween("2009-6-1","2009-6-30","M"); print_r($days);

function findDay($x){
	if(strpos($x,'Monday')!==FALSE){
		return 'M';
	}
	if(strpos($x,'Tuesday')!==FALSE){
		return 'Tu';
	}
	if(strpos($x,'Wednesday')!==FALSE){
		return 'W';
	}
	if(strpos($x,'Thursday')!==FALSE){
		return 'Th';
	}
	if(strpos($x,'Friday')!==FALSE){
		return 'F';
	}
	if(strpos($x,'Saturday')!==FALSE){
		return 'S';
	}
	if(strpos($x,'Sunday')!==FALSE){
		return 'Su';
	}
	
}
?>
