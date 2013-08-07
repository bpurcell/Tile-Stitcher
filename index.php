<?php

/**
 * Tile Stitcher
 *
 * A library to interface with the NoSQL database MongoDB. For more information see http://www.mongodb.org
 *
 * @author		Bennington Purcell | www.benningtonpurcell.com
 * @copyright	Copyright (c) 2013, Bennington Purcell.
 * @license		http://www.opensource.org/licenses/mit-license.php
 * @link		http://bpurcell.github.io/Tile-Stitcher
 * @version		Version 0.0.1
 *
 *  This is sooooo silly.  But it takes a lat lon lat lon zoom-level and name arguments too curl down some images and then awesomely stitch them into hi-res maps for printing.  
 *  php index.php 42.39506551565123 -71.16668701171875 42.32200108060305 -71.00326538085938 15 boston
 */


//  THE GD lib needs a lot of memory in order to stitch the photos together.  Remember to run this from the commandline.
ini_set('memory_limit', '2560M');
define('SELF', pathinfo(__FILE__, PATHINFO_BASENAME));
define('FCPATH', str_replace(SELF, '', __FILE__));
$maptype = 'terrain';

//
// Processing the CLI args
//
$args = $_SERVER['argv'];
$location = (isset($args[6]))? $args[6] :strtotime("now");
foreach($args as &$arg)$arg = (float) $arg;

//
//  Set up the X and Ys to grab tiles from.
//
$zoom = $args[5];
$y1 = floor((1 - log(tan(deg2rad($args[1])) + 1 / cos(deg2rad($args[1]))) / pi()) /2 * pow(2, $zoom));
$x1 = floor((($args[2] + 180) / 360) * pow(2, $zoom));

$y2 = floor((1 - log(tan(deg2rad($args[3])) + 1 / cos(deg2rad($args[3]))) / pi()) /2 * pow(2, $zoom));
$x2 = floor((($args[4] + 180) / 360) * pow(2, $zoom));

//
//  Check to make sure you really want to curl down all those images.... it is kinda tricky and sometimes naughty
//
$question =  'this is going to curl '.(($x2-$x1)+1) * (($y2-$y1)+1).' images.  Are you sure you want to continue? (Y)';
$response = getInput($question);
if($response == 'n' || $response == 'no') return;

//
//  Set up the location to put the image.
//
if (!is_dir(FCPATH.$location)):
    mkdir(FCPATH.$location, 0777, true); // Create Folder For images
    mkdir(FCPATH.$location."/sourceimages", 0777, true); // Create source image folder
else:
    $location = $location.rand();
    mkdir(FCPATH.$location, 0777, true); // Create Folder For images
    mkdir(FCPATH.$location."/sourceimages", 0777, true); // Create source image folder
endif;



//
//  Loop over every Y and then every X and the Z you specfified and grab every image included.
//
for( $c=$y1; $c<($y2+1); $c++ ) {
    for( $i=$x1; $i<($x2+1); $i++ ) {
        echo '.';
        
        $sources['satellite'] = "https://khms0.googleapis.com/kh?v=132&hl=en-US&x=$i&y=$c&z=$zoom"; // Google Satelitte
        $sources['terrain'] = "http://server.arcgisonline.com/ArcGIS/rest/services/USA_Topo_Maps/MapServer/tile/$zoom/$c/$i"; // ESRI Terrain
        $sources['road'] = "https://a.tiles.mapbox.com/v3/bpurcell.map-im7uxt8h/$zoom/$i/$c.png"; // mapbox gray
        

        $img = GetImageFromUrl($sources[$maptype]);
        $savefile = fopen(FCPATH.$location."/sourceimages/$c-$i.jpg", 'w');
        fwrite($savefile, $img);
        fclose($savefile);
    }
}

//
//      Start the Stitching phase
//

// Create the big ol' canvas to copy the images into
$canvas = imagecreatetruecolor( 256+(256*($x2-$x1)), 256+(256*($y2-$y1)));


//
//  Same loop as before to place the images and shift their location in the canvas.
//
for( $c=$y1; $c<($y2+1); $c++ ) {
    for( $i=$x1; $i<($x2+1); $i++ ) {
        echo '<>';
        $$i = imagecreatefromjpeg(FCPATH.$location."/sourceimages/$c-$i.jpg");
        imagecopy($canvas,$$i,($i-$x1)*256,($c-$y1)*256,0,0,256,256);
        
    }
}

//  Write the image
imagejpeg($canvas,FCPATH.$location.'/Final Image.jpg');

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
