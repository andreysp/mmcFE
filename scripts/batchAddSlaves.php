<?php
$includeDirectory = "/var/www/pool/www/includes/";

//required functions
include($includeDirectory."requiredFunctions.php");
connectToDb();

if (isset($argv["1"])) { $userId = $argv["1"]; } else { print("usage: $argv[0] <userId> <workers_file.txt> <password>\n"); die(); }
if (isset($argv["2"])) { $myFile = $argv["2"]; } else { print("usage: $argv[0] <userId> <workers_file.txt> <password>\n"); die(); }
if (isset($argv["3"])) { $pass = $argv["3"]; } else { print("usage: $argv[0] <userId> <workers_file.txt> <password>\n"); die(); }

// get username
$res = mysql_query("SELECT username FROM webUsers WHERE id = ".sqlesc($userId)." LIMIT 1");
$row = mysql_fetch_assoc($res);
$username = $row["username"];

$fh = fopen($myFile, 'r');
$theData = fread($fh, filesize($myFile));
fclose($fh);

$slaves = explode("\n", $theData);

foreach ($slaves as $slave) {
  if ($slave) {
    if (mysql_query("INSERT INTO `poolx`.`pool_worker` (`id`, `associatedUserId`, `username`, `password`, `active`, `hashrate`) VALUES (NULL, '$userId', '$username.$slave', '$pass', '0', NULL);"))
    echo "Added: $username.$slave::$pass #".mysql_insert_id()."\n";
    else
    echo "Fail: $username.$slave::$pass\n";
  }
}
?>