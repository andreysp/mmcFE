<?php
$includeDirectory = "/var/www/pool/www/includes/";
//required functions
include($includeDirectory."requiredFunctions.php");




$starttime = timer();
connectToDb();

if (isset($argv[1])) {
	$myFile = $argv[1];
	$fh = fopen($myFile, 'w') or die("unable to write to $myFile");
}

echo "Checking winning_shares against Ledger for missing payout (lastnshares: $lastNshares)\n";

// go thru ledger v1
$unpaid = 0;
$wsql = mysql_query("SELECT * FROM `winning_shares` ORDER by id DESC LIMIT 0, 250");
while ($wrow = mysql_fetch_assoc($wsql)) {
	$bsql = mysql_query("SELECT count(userId) as count from ledger WHERE assocBlock LIKE '$wrow[blockNumber]'");
	$brow = mysql_fetch_assoc($bsql);
	$perblock = 50;
	$csql = mysql_query("SELECT confirms FROM networkBlocks WHERE blockNumber LIKE $wrow[blockNumber]");
	$cr = mysql_fetch_assoc($csql);
	if (@$brow[count] == 0 && $cr["confirms"] > 121 && $cr["confirms"] > 0) { // 121 to avoid conflicting with the cronjob if it just havent got to it yet

		// count
		if (!isset($unpaid))
		$unpaid = 1;
		else
		$unpaid++;
		// string
		$stringData = "Nr. $unpaid #$wrow[id] Block: $wrow[blockNumber] Payments: $brow[count] c: $cr[confirms] -\n";
		echo $stringData;

		// payout ...

		//exec("php -f /PATHTO/scripts/estimate-pplns.php $lastNshares $wrow[blockNumber] payout"); // adding "payout" makes it payout .. good for blocks it misses payment on ..


		// log
		if (isset($argv[1]))
		fwrite($fh, $stringData);

		//echo "$stringData";
	}
	echo "checking...\r";

}
echo "\n\n DONE .. $unpaid unpaid blocks = ".$unpaid*$perblock." LTC \n";
?>
