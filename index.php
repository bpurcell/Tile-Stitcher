<?php
//   
//      This is sooooo silly.  But it takes a lat lon lat lon zoom level arguments too curl down some images and 
//      like   
//      Boston!     
//      php index.php 42.39506551565123 -71.16668701171875 42.32200108060305 -71.00326538085938 15
//
//
ini_set('memory_limit', '2560M');

$args = $_SERVER['argv'];
foreach($args as &$arg)$arg = (float) $arg;

$zoom = $args[5];

$date = strtotime("now");

$y1 = floor((1 - log(tan(deg2rad($args[1])) + 1 / cos(deg2rad($args[1]))) / pi()) /2 * pow(2, $zoom));
$x1 = floor((($args[2] + 180) / 360) * pow(2, $zoom));

$y2 = floor((1 - log(tan(deg2rad($args[3])) + 1 / cos(deg2rad($args[3]))) / pi()) /2 * pow(2, $zoom));
$x2 = floor((($args[4] + 180) / 360) * pow(2, $zoom));

// The name of THIS file
define('SELF', pathinfo(__FILE__, PATHINFO_BASENAME));

$question =  'this is going to curl '.(($x2-$x1)+1) * (($y2-$y1)+1).' images.  Are you sure you want to continue? (only n will stop it.  no)';
$response = getInput($question);
if($response == 'n' || $response == 'no') return;


// Path to the front controller (this file)
define('FCPATH', str_replace(SELF, '', __FILE__));
if (!is_dir(FCPATH.$date)) {
    mkdir(FCPATH.$date, 0777, true); // true for recursive create
    mkdir(FCPATH.$date."/sourceimages", 0777, true); // true for recursive create
}


for( $c=$y1; $c<($y2+1); $c++ ) {
    for( $i=$x1; $i<($x2+1); $i++ ) {
        echo '.';
        $sourcecode = GetImageFromUrl("https://khms0.googleapis.com/kh?v=132&hl=en-US&x=$i&y=$c&z=$zoom"); // Google Satelitte
        //$sourcecode = GetImageFromUrl("https://a.tiles.mapbox.com/v3/bpurcell.map-im7uxt8h/$zoom/$i/$c.png");   // Mapbox

        $savefile = fopen(FCPATH.$date."/sourceimages/$c-$i.jpg", 'w');
        fwrite($savefile, $sourcecode);
        fclose($savefile);
    }
}

$canvas = imagecreatetruecolor( 256+(256*($x2-$x1)), 256+(256*($y2-$y1)));

for( $c=$y1; $c<($y2+1); $c++ ) {
    for( $i=$x1; $i<($x2+1); $i++ ) {
        echo '.';
        $$i = imagecreatefromjpeg(FCPATH.$date."/sourceimages/$c-$i.jpg");
        imagecopy($canvas,$$i,($i-$x1)*256,($c-$y1)*256,0,0,256,256);
        
    }
}

imagejpeg($canvas,FCPATH.$date.'/Final Image.jpg');

function getInput($msg){
  fwrite(STDOUT, "$msg: ");
  $varin = trim(fgets(STDIN));
  return $varin;
}

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
