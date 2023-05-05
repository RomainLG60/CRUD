<?php

function str_build($string,$tabValue){

  $stringReturn = "";
  $parameter = 1;

  $stringReturn = $string;

  for($i=0;$i<count($tabValue);$i++){
    $stringReturn = str_replace("{".$parameter."}",$tabValue[$i],$stringReturn);
    $parameter++;
  }

  return $stringReturn;

}


function SemaineEnCours(){

$no_semaine =date("w");

$dateDebutSemaine = date('Y-m-d', strtotime('-'.($no_semaine - 1).' days'));
$dateFinSemaine = date('Y-m-d', strtotime('+'.(7-$no_semaine).' days'));


$tabWeekPeriode = [$dateDebutSemaine,$dateFinSemaine];

return $tabWeekPeriode;
}

function SemaineAvant(){

    $no_semaine =date("w");

    $previous_week = strtotime("-1 week +1 day");

    $start_week = strtotime("last sunday midnight",$previous_week);
    $end_week = strtotime("next saturday",$start_week);

    $start_week = date("Y-m-d",$start_week);
    $end_week = date("Y-m-d",$end_week);


    $no_semaine=$no_semaine-6;

    $dateDebutSemaine = date('Y-m-d', strtotime('-'.($no_semaine - 1).' days'));
    $dateFinSemaine = date('Y-m-d', strtotime('+'.(7-$no_semaine).' days'));

    $tabWeekPeriode = [$start_week,$end_week];

    return $tabWeekPeriode;
}


function MoisEnCours(){

$mois = date('m');
$annee = date('Y');

$val = mktime( 0, 0, 0, $mois, 1, $annee );

$dateMoisDeb = date("Y-m-01",$val);
$dateMoisFin = date("Y-m-t",$val);

$tabMonthPeriode = [$dateMoisDeb,$dateMoisFin];

return $tabMonthPeriode;
}


function dates_month($month, $year) {
    $num = cal_days_in_month(CAL_GREGORIAN, $month, $year);
    $dates_month = array();

    for ($i = 1; $i <= $num; $i++) {
        $mktime = mktime(0, 0, 0, $month, $i, $year);
        $date = date("d-M-Y", $mktime);
        $day_name = date('l', strtotime($date));//Day name
        $dates_month[$i] = $day_name;
    }

    return $dates_month;
}

function weekOfMonth($date) {
    //Get the first day of the month.
    $firstOfMonth = strtotime(date("Y-m-01", $date));
    //Apply above formula.
    return weekOfYear($date) - weekOfYear($firstOfMonth) + 1;
}

function weekOfYear($date) {
    $weekOfYear = intval(date("W", $date));
    if (date('n', $date) == "1" && $weekOfYear > 51) {
        // It's the last week of the previos year.
        return 0;
    }
    else if (date('n', $date) == "12" && $weekOfYear == 1) {
        // It's the first week of the next year.
        return 53;
    }
    else {
        // It's a "normal" week.
        return $weekOfYear;
    }
}

function datediff($date1, $date2){
    $date1_ts = strtotime($date1);
    $date2_ts = strtotime($date2);
    $diff = $date2_ts - $date1_ts;
    return round($diff / 86400)+1;
}

function dateToFrench($date, $format)
{
    $english_days = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
    $french_days = array('Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche');
    $english_months = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
    $french_months = array('Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre');
    return str_replace($english_months, $french_months, str_replace($english_days, $french_days, date($format, strtotime($date) ) ) );
}

?>
