<?php

$res=file_get_contents("https://api.steemjs.com/get_accounts?names[]=%5B%22astrizak%22%5D");
$r=json_decode($res,$assoc=true);

$val=$r[0]["reputation"];

if($val > 0)
{
    $rep = (max(log10($val) - 9, 0) * 9 + 25); 
}
else
{
    $rep=max(log10(-$val) - 9, 0) * -9 + 25;
}


$pwr=round($r[0]["voting_power"]/100);


echo "document.getElementById('sbd').innerHTML='".$r[0]["sbd_balance"]."';";
echo "document.getElementById('steem').innerHTML='".$r[0]["balance"]."';";
echo "document.getElementById('vest').innerHTML='".round($r[0]["vesting_shares"]/1000000,2)." VESTS';";
echo "document.getElementById('vpwr').innerHTML='".$pwr." %';";
echo "document.getElementById('rate').innerHTML='".round($rep,1)."';";
echo "document.getElementById('informer').innerHTML='';";
  

$color="green";

if($pwr<=80)
{
    $color="yellow";
}
else if($pwr<60)
{
    $color="red";
}

$slider='<div style="width:'.$pwr.'%; height:18px; background-color:'.$color.';"></div>';

echo "document.getElementById('slider').innerHTML='".$slider."';";

?>




