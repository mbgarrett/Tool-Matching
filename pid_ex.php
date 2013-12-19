<?php

$host	= "mawsqldev01\MAMSSDEVL01";
$dbase	= "prober_data";
$user	= "ProberLG";
$pass	= "tuner4v8";

$mode = $_GET["mode"];
$dsid_req = $_GET["dsid"];
$tester_req = $_GET["tester"];
$pid_req = $_GET["pid"];
$bin_req = $_GET["bin"];

// Connect to MSSQL
$db = mssql_connect($host, $user, $pass);
if (!$db || !mssql_select_db($dbase, $db)) {
    die('Unable to connect or select database!');
}

if ($mode == "ext")
    { //Extract the per test/etc info - Meat and potatoes
    $query = "select date,integrative from prober_data..bin_tool_pid_i
       where product='$dsid_req' and pid='$pid_req' and bin='$bin_req' and tester='$tester_req'
       order by date ASC";

    $resultARef = mssql_query($query);
    
    $count = mssql_num_rows($resultARef);
    
    echo "{\"label\" : ";
    echo "\"$tester_req\"";
    echo ",\"data\": ";
    echo "[";
    $first = 1;
    while ($row = mssql_fetch_array($resultARef))
        {
	list($year,$month,$day) = split('[/.-]', $row[0]);
	$date = $year . $month . $day;
        if ($first) { echo "[\"" . $date . "\", " . $row[1] . "]"; $first = 0; }
        else        { echo ",[\"" . $date . "\", " . $row[1] . "]";}
        }
    echo "]} ";
    
    
    mssql_free_result($resultARef);
    }

else if ($mode == "dsids")
    {//Get a list of available DSIDs in the DB
    $query = "select product from prober_data..bin_tool_match
        group by product
        order by product";
    
    $resultARef = mssql_query($query);
    
    $count = mssql_num_rows($resultARef);
    
    echo "{\"label\" : ";
    echo "\"DSIDS\"";
    echo ",\"data\": ";
    echo "[";
    $first = 1;
    while ($row = mssql_fetch_array($resultARef))
        {
        if ($first) { echo "[\"" . $row[0] . "\", " . 0 . "]"; $first = 0; }
        else        { echo ",[\"" . $row[0] . "\", " . 0 . "]";}
        }
    echo "]} ";
    
    
    mssql_free_result($resultARef);
    }

else if ($mode == "testers")
    {//Get a list of available DSIDs in the DB
    $query = "select distinct tester from prober_data..bin_tool_match
        where product='$dsid_req' and pid='$pid_req'
        order by tester";
    
    $resultARef = mssql_query($query);
    
    $count = mssql_num_rows($resultARef);
    
    echo "{\"label\" : ";
    echo "\"Testers\"";
    echo ",\"data\": ";
    echo "[";
    $first = 1;
    while ($row = mssql_fetch_array($resultARef))
        {
        if ($first) { echo "[\"" . $row[0] . "\", " . 0 . "]"; $first = 0; }
        else        { echo ",[\"" . $row[0] . "\", " . 0 . "]";}
        }
    echo "]} ";
    
    
    mssql_free_result($resultARef);
    }

else if ($mode == "bins")
    {//Get a list of available bins for DSID and PID combo
    $query = "select distinct bin from prober_data..bin_tool_match
        where product='$dsid_req' and pid='$pid_req'
        order by bin";
    
    $resultARef = mssql_query($query);
    
    $count = mssql_num_rows($resultARef);
    
    echo "{\"label\" : ";
    echo "\"Testers\"";
    echo ",\"data\": ";
    echo "[";
    $first = 1;
    while ($row = mssql_fetch_array($resultARef))
        {
        if ($first) { echo "[\"" . $row[0] . "\", " . 0 . "]"; $first = 0; }
        else        { echo ",[\"" . $row[0] . "\", " . 0 . "]";}
        }
    echo "]} ";
    
    
    mssql_free_result($resultARef);
    }

else if ($mode == "getpids")
    {//Get a list of available bins for DSID and PID combo
    $query = "select distinct pid from prober_data..bin_tool_match
        where product='$dsid_req'
        order by pid";
    
    $resultARef = mssql_query($query);
    
    $count = mssql_num_rows($resultARef);
    
    echo "{\"label\" : ";
    echo "\"Testers\"";
    echo ",\"data\": ";
    echo "[";
    $first = 1;
    while ($row = mssql_fetch_array($resultARef))
        {
        if ($first) { echo "[\"" . $row[0] . "\", " . 0 . "]"; $first = 0; }
        else        { echo ",[\"" . $row[0] . "\", " . 0 . "]";}
        }
    echo "]} ";
    
    
    mssql_free_result($resultARef);
    }
            
mssql_close($db);


?>

