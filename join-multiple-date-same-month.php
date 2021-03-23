<?php
$dates = array( 
        0 => '2021-06-25', 
        1 => '2021-07-02',
        2 => '2021-07-09',
        3 => '2020-05-19',
);

//Sort and Create arrays
sort($dates);

$groupes = $helper = [];
foreach($dates as $date){
  list($year,$month,$day) = explode('-',$date);
  $groupes[(int)$year][(int)$month][] = (int)$day;
} 

foreach($groupes as $year => $arr){
  foreach($arr as $month => $dayArr){
    $monthName = date('F',strtotime('2000-'.$month.'-01'));
    $helper[$year][] = implode(',',$dayArr).' '. $monthName;
  }
}
//Make Output
foreach($helper as $year => $dateStrings){
  echo implode(' & ',$dateStrings).' '.$year."<br>\n";
}













//version 2
$dates = array(
        0 => '2020-06-25',
        1 => '2021-06-25',
        2 => '2021-07-02',
        3 => '2021-07-09'
);

$years = array();

foreach($dates as $date) {
    $day = date('j', strtotime($date));
    $month = date('F', strtotime($date));
    $year = date('Y', strtotime($date));

    if(array_key_exists($year, $years)) {
        if(array_key_exists($month, $years[$year])) {
            $years[$year][$month] .= ',' . $day;
        } else {
            $years[$year][$month] = $day;
        }

    } else {
        $years[$year] = array($month => $day);
    }
}

$showYearSepartor = false;
$showMonthSepartor = false;


foreach($years as $year => $months) {
    if($showYearSepartor) {
        echo ' - ';
    }

    $showYearSepartor = true;

    foreach($months as $month => $day) {
        if($showMonthSepartor) {
            echo ' & ';
        }

        echo $day . ' ' . $month . ' ';

        $showMonthSepartor = true;
    }

    $showMonthSepartor = false;

    echo $year;
}
