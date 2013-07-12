<?php
//   
//      This is sooooo silly.  But it takes a lat lon lat lon zoom level arguments too curl down some images and 
//      like   
//      Boston!     
//      php index.php 42.39506551565123 -71.16668701171875 42.32200108060305 -71.00326538085938 15
//
//

$args = $_SERVER['argv'];

$zoom = $args[5];

$date = strtotime("now");

$lat1 = floor((1 - log(tan(deg2rad($args[1])) + 1 / cos(deg2rad($args[1]))) / pi()) /2 * pow(2, $zoom));
$lon1 = floor((($args[2] + 180) / 360) * pow(2, $zoom));

$lat2 = floor((1 - log(tan(deg2rad($args[3])) + 1 / cos(deg2rad($args[3]))) / pi()) /2 * pow(2, $zoom));
$lon2 = floor((($args[4] + 180) / 360) * pow(2, $zoom));

// The name of THIS file
define('SELF', pathinfo(__FILE__, PATHINFO_BASENAME));

// Path to the front controller (this file)
define('FCPATH', str_replace(SELF, '', __FILE__));
if (!is_dir(FCPATH.$date)) {
    mkdir(FCPATH.$date, 0777, true); // true for recursive create
    mkdir(FCPATH.$date."/sourceimages", 0777, true); // true for recursive create
}

for( $c=$lat1; $c<($lat2+1); $c++ ) {
    for( $i=$lon1; $i<($lon2+1); $i++ ) {
        echo '.';
        $sourcecode = GetImageFromUrl("https://khms0.googleapis.com/kh?v=132&hl=en-US&x=$i&y=$c&z=$zoom"); // Google Satelitte
        //$sourcecode = GetImageFromUrl("https://a.tiles.mapbox.com/v3/bpurcell.map-im7uxt8h/$zoom/$i/$c.png");   // Mapbox

        $savefile = fopen(FCPATH.$date."/sourceimages/$c-$i.jpg", 'w');
        fwrite($savefile, $sourcecode);
        fclose($savefile);
    }
}

$canvas = imagecreatetruecolor( 256+(256*($lon2-$lon1)), 256+(256*($lat2-$lat1)));

for( $c=$lat1; $c<($lat2+1); $c++ ) {
    for( $i=$lon1; $i<($lon2+1); $i++ ) {
        echo '.';
        $$i = imagecreatefromjpeg(FCPATH.$date."/sourceimages/$c-$i.jpg");
        imagecopy($canvas,$$i,($i-$lon1)*256,($c-$lat1)*256,0,0,256,256);
        
    }
}

imagejpeg($canvas,FCPATH.$date.'/Final Image.jpg');

function GetImageFromUrl($link){

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_POST, 0);
    curl_setopt($ch,CURLOPT_URL,$link);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)"); 
    $result=curl_exec($ch);
    curl_close($ch);
    return $result;
}



?>
