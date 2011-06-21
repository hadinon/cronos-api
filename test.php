<?php
require_once( 'cronos.php' );

$c = new CRONOS( '2a46c43c6354e1eb94b1303d8af9b923641fde35780d688a1a8c915b8e3c4' ); // Replace with your API key.

// Collect data from COOP, CoCoRaHS, AWOS and ASOS networks for SECC states and filter out the COOP (pointless but testing)
$results = $c->listStations( array( 'COOP', 'CoCoRaHS', 'AWOS', 'ASOS' ), array( 'AL', 'FL', 'GA', 'NC', 'SC' ), array( 'COOP' ), true );

echo "====================\nStart run\n====================\n";

// Collect the stations by network.
$networks = array();
foreach( $results as $r ) {
  $networks[$r['network']][] = $r['station'];
}

// Get daily weather information for the last week from ASOS network only.
$startdate = date('Y-m-d', strtotime( '-1 week' ) );
$daily = $c->getDailyData( $networks['ASOS'], $startdate );
// print_r( $daily ); // Uncomment for raw data from $daily

// Display the average tempurature per station per day (simple loop)
foreach( $daily as $d ) {
  echo 'Average tempurature for station '.$d['station'].' on '.$d['ob'].' was '.$d['tempavg'].".\n";
}
echo "====================\nEnd run\n====================\n";
?>
