<?php
include('phpsqlajax_dbinfo_conavia.php');
include("includes/savelog.php");
session_start();

$Date_Time=date("Y-m-d H:i:s");
SaveLog($GPSUSERID,'User Loged out from the system User ID : '.$_SESSION['GPSUSERID'].'');
session_destroy();
header('location:acceso.php');
?>
