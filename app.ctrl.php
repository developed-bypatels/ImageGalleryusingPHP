
<?php
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING | E_DEPRECATED));  

// Auto-discover the photos, thumbnails and description files
$photoData = [];
$numGal = 0;

// open the photos folder
$fp = opendir("photos");
while( false !== ( $DIR = readdir($fp) ) ) {
 
  // read any directory that isn't . or ..
  if (($DIR !== (".")) && ($DIR !== (".."))) {

  	// get the description.txt file contents
    $photoData[$numGal]["description"] = 
      file_get_contents("photos/" . $DIR . "/description.txt");

	// gallery directory
    $photoData[$numGal]["directory"] = $DIR;
	  
    // open the gallery folder, get the photo names and sort them
    $fpdir = opendir("photos/" . $DIR);
    while ($file = readdir($fpdir)) {
      if (($file !== (".")) && ($file !== ("..")) && 
      	  ($file !== "thumbs") && ($file !== "description.txt")) {
        $photoData[$numGal]["photos"][] = $file;        
      }
    }
    sort($photoData[$numGal]["photos"]);
  }

  $numGal++;
}
    
    $TPL['photoData'] = $photoData;
    $TPL['tpl'] = array("allphotos"=>0);
    
    switch($_REQUEST['act'])
    {
        case 'more':
            $TPL['tpl']["allphotos"] = 0;
            $TPL['tpl'] += ["id"=>$_REQUEST["id"]];
            break;
        case 'enlarge':
            $TPL['tpl']["allphotos"] = 2;
            $TPL['tpl']["id"] = $_REQUEST["id"];
            $TPL['tpl'] += ["enlargeid"=>$_REQUEST["enlargeid"]];
            break;
        default:
            $TPL['tpl']["allphotos"] = 1;
    }
    
    
include 'app.view.php';
?>

<!-- Let's look at the contents of $photoData...  -->





