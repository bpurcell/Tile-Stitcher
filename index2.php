<?php



$falls = ["http://www.newenglandwaterfalls.com/waterfall.php?name=Abbey Pond Cascades", "http://www.newenglandwaterfalls.com/waterfall.php?name=Bakers Falls", "http://www.newenglandwaterfalls.com/waterfall.php?name=Barnet Falls", "http://www.newenglandwaterfalls.com/waterfall.php?name=Bartlett Falls", "http://www.newenglandwaterfalls.com/waterfall.php?name=Bensons Holes", "http://www.newenglandwaterfalls.com/waterfall.php?name=Big Falls", "http://www.newenglandwaterfalls.com/waterfall.php?name=Bingham Falls", "http://www.newenglandwaterfalls.com/waterfall.php?name=Bittersweet Falls", "http://www.newenglandwaterfalls.com/waterfall.php?name=Bolton Potholes", "http://www.newenglandwaterfalls.com/waterfall.php?name=Brewster River Gorge", "http://www.newenglandwaterfalls.com/waterfall.php?name=Bristol Memorial Park Falls", "http://www.newenglandwaterfalls.com/waterfall.php?name=Browns River Falls", "http://www.newenglandwaterfalls.com/waterfall.php?name=Buttermilk Falls (Ludlow)", "http://www.newenglandwaterfalls.com/waterfall.php?name=Cascade Falls", "http://www.newenglandwaterfalls.com/waterfall.php?name=Cavendish Gorge", "http://www.newenglandwaterfalls.com/waterfall.php?name=Clarendon Gorge (Lower Falls)", "http://www.newenglandwaterfalls.com/waterfall.php?name=Clarendon Gorge (Upper Falls)", "http://www.newenglandwaterfalls.com/waterfall.php?name=Covered Bridge Falls", "http://www.newenglandwaterfalls.com/waterfall.php?name=Crystal Falls (Montgomery)", "http://www.newenglandwaterfalls.com/waterfall.php?name=Dog Team Falls", "http://www.newenglandwaterfalls.com/waterfall.php?name=Dogs Head Falls", "http://www.newenglandwaterfalls.com/waterfall.php?name=Emerson Falls", "http://www.newenglandwaterfalls.com/waterfall.php?name=Fairfax Falls", "http://www.newenglandwaterfalls.com/waterfall.php?name=Falls of Lana", "http://www.newenglandwaterfalls.com/waterfall.php?name=Glen Falls", "http://www.newenglandwaterfalls.com/waterfall.php?name=Green River Falls", "http://www.newenglandwaterfalls.com/waterfall.php?name=Hamilton Falls", "http://www.newenglandwaterfalls.com/waterfall.php?name=Hancock Brook Falls", "http://www.newenglandwaterfalls.com/waterfall.php?name=Hartshorn Falls", "http://www.newenglandwaterfalls.com/waterfall.php?name=Honey Hollow Falls", "http://www.newenglandwaterfalls.com/waterfall.php?name=Huntington Gorge", "http://www.newenglandwaterfalls.com/waterfall.php?name=Jay Branch Gorge", "http://www.newenglandwaterfalls.com/waterfall.php?name=Jeff Falls", "http://www.newenglandwaterfalls.com/waterfall.php?name=Jelly Mill Falls", "http://www.newenglandwaterfalls.com/waterfall.php?name=Jeudevine Falls", "http://www.newenglandwaterfalls.com/waterfall.php?name=Kings Hill Brook Falls", "http://www.newenglandwaterfalls.com/waterfall.php?name=Little Otter Creek Falls", "http://www.newenglandwaterfalls.com/waterfall.php?name=Lye Brook Falls", "http://www.newenglandwaterfalls.com/waterfall.php?name=Marshfield Falls", "http://www.newenglandwaterfalls.com/waterfall.php?name=Middlebury Gorge", "http://www.newenglandwaterfalls.com/waterfall.php?name=The Mill", "http://www.newenglandwaterfalls.com/waterfall.php?name=Milton Falls", "http://www.newenglandwaterfalls.com/waterfall.php?name=Moss Glen Falls (Granville)", "http://www.newenglandwaterfalls.com/waterfall.php?name=Moss Glen Falls (Stowe)", "http://www.newenglandwaterfalls.com/waterfall.php?name=North Branch Falls", "http://www.newenglandwaterfalls.com/waterfall.php?name=Northfield Falls", "http://www.newenglandwaterfalls.com/waterfall.php?name=Old City Falls", "http://www.newenglandwaterfalls.com/waterfall.php?name=Pikes Falls", "http://www.newenglandwaterfalls.com/waterfall.php?name=Proctor Falls", "http://www.newenglandwaterfalls.com/waterfall.php?name=Quechee Gorge", "http://www.newenglandwaterfalls.com/waterfall.php?name=Riverton Falls", "http://www.newenglandwaterfalls.com/waterfall.php?name=Roxbury Falls", "http://www.newenglandwaterfalls.com/waterfall.php?name=Sacketts Brook Falls", "http://www.newenglandwaterfalls.com/waterfall.php?name=Sheeps Hole", "http://www.newenglandwaterfalls.com/waterfall.php?name=Shelburne Falls (Vermont)", "http://www.newenglandwaterfalls.com/waterfall.php?name=South Branch Falls (Vermont)", "http://www.newenglandwaterfalls.com/waterfall.php?name=State Prison Hollow Falls", "http://www.newenglandwaterfalls.com/waterfall.php?name=Sterling Brook Gorge", "http://www.newenglandwaterfalls.com/waterfall.php?name=Stetson Hollow Falls", "http://www.newenglandwaterfalls.com/waterfall.php?name=Terrill Gorge", "http://www.newenglandwaterfalls.com/waterfall.php?name=Texas Falls", "http://www.newenglandwaterfalls.com/waterfall.php?name=Thatcher Brook Falls", "http://www.newenglandwaterfalls.com/waterfall.php?name=Thundering Brook Falls", "http://www.newenglandwaterfalls.com/waterfall.php?name=Trout River Falls", "http://www.newenglandwaterfalls.com/waterfall.php?name=Twenty Foot Hole", "http://www.newenglandwaterfalls.com/waterfall.php?name=Upper Crossett Brook Falls", "http://www.newenglandwaterfalls.com/waterfall.php?name=Warren Falls", "http://www.newenglandwaterfalls.com/waterfall.php?name=Willoughby Falls", "http://www.newenglandwaterfalls.com/waterfall.php?name=Woodbury Falls"];


foreach($falls as $f):

    var_dump($f);
    
    $page = GetImageFromUrl($f);
    echo $page;
    return;
endforeach;


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
