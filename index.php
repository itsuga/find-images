<?php
// example of how to use basic selector to retrieve HTML contents
include('simple_html_dom.php');
function pre($arr){
	echo '<pre>';
	print_r($arr);
	echo '</pre>';
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <title>URL Image Finder</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <style>
    input#url {width:80%;font-size:2em}
    fieldset input,legend {width:100%;}
  </style>
    </head>
    <link rel="shortcut icon" type="image/x-icon" href="find.ico">
    <body>
          <header>
    <h1>URL Image Finder</h1>

	</header>

	<?php
	
	$max_img = 100;
	$search = (isset($_GET['s'])) ? $_GET['s'] : '' ;
	$search = (!empty($_POST['submit'])) ? $_POST['url'] : $search ;
	
	if( !empty($_POST['submit']) || !empty($_GET['s']) ) {
	  $url = $search;
	  $max_img = (empty($_POST['submit'])) ? '25' : $_POST['max_img'] ;
	  // get DOM from URL or file
	  $html = file_get_html($url);

	  // find all image
	  $counter = 0;
	  echo '<h3>'.count($html->find('img')).'/'.$max_img.' found images from: <a href="'.$url.'">'.$url.'</a></h3>';
	  foreach($html->find('img') as $e){
	    if($counter == $max_img) {
	      break;
	    }

		if (strpos($e->src,'://')!==false)
			$img = $e->src;
		else{
			if(substr($url, -1) == '/')
				$img = substr($url, 0, -1).$e->src;
			else
				$img = $url.$e->src;
		}


				echo '<fieldset>';
				echo '  <legend><input type="text" value="'.$img.'" readonly></legend>';
				echo '  <a href="'.$img.'">'.$e.'</a>';
				echo '</fieldset>';

		  $counter++;
		}
	}
	?>
	<hr/>
	<form method="POST" action="">
		<input type="url" name="url" id="url" placeholder="url" value="<?php echo $url;?>" required /><br/>
		<input type="submit" name="submit" value="Submit" />
		<input type="number" name="max_img"  value="<?php echo $max_img;?>" step="1" max="100" min="1" >
		
	</form>
	</body>
</html>

