<?php
	require_once '_lib/mysql.class.php';
	$ddc_db = new MySQL(true, "ddcocina", "mysql.alacor.com", "ddcocina", "D1ccionario");
// --- Query and show the data --------------------------------------
// (Note: $ddc_db->Query also returns the result set)
if ($ddc_db->Query("SELECT * FROM words ORDER BY word ")) {
    $ddc_words_array = $ddc_db->RecordsArray();
} else {
    echo "<p>Query Failed</p>";
}
	
//	$ddc_words_array = $ddc_ddc_db->get_rows('words', 'word_id ASC') ; 
	
echo '<pre>';
print_r($ddc_words_array);
echo '</pre>';

// Now you can throw exceptions and use try/catch blocks
$ddc_db->ThrowExceptions = true;

/*
try {
	// This next line will always cause an error
	$ddc_db->Query("BAD SQL QUERY TO CREATE AN ERROR");
} catch(Exception $e) {
	// If an error occurs, do this (great for transaction processing!)
	echo "We caught the error: " . $e->getMessage();
}
*/
// Or let's show a stack trace if we do not use a try/catch
// This shows the stack and tells us exactly where it failed
//$ddc_db->Query("BAD SQL QUERY TO CREATE AN ERROR");

	if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'write') {
	
/*
		// --- Insert a new record ------------------------------------------
		$sql = "INSERT INTO words (word, word_description) VALUES ('" .$_POST['wordname']. "', '" .$_POST['worddesc']. "')";
		if (! $ddc_db->Query($sql)) {
				$ddc_db->Kill();
		}	
*/	
		// --- Insert a new record ------------------------------------------
		$sql = "INSERT INTO words (word, word_description) VALUES ('" .$_POST['wordname']. "', '" .$_POST['worddesc']. "')";
		try {
			$ddc_db->Query($sql) ;

		}	catch(Exception $e) {
	// If an error occurs, update
//	echo "We caught the error: " . $e->getMessage();

			$sql = "UPDATE words SET word_description = '" .$_POST['worddesc']. "' WHERE word = '" .$_POST['wordname']. "'";
			echo $sql;
			$ddc_db->Query($sql) ;
		}
	
			
	}
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="iso-8859-1">
    <title>Diccionario de cocina - Edit</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
    <style>
      body {
        padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
      }
			
			.alfabeto {
			
				margin: 20px 10px 30px;
			}
			
			.alphaletter {
				font-size: 22px;
				line-height: 36px;
			}
			
			#wordname {
				font:normal bold 22px/36px Georgia,serif;
				width: 350px;
				height: 36px;
			}
			
			#worddesc {
				font:normal bold 14px/20px Georgia,serif;
				width: 600px;
				height: 310px;
			}

			#wordlist {
			
				width: 120px;
				min-height: 400px;
				border:1px solid #CCCCCC;
				float: left;
			}
		
			#btn_send {
				margin-top: 10px;
				width: 80px;
				height: 32px;
				font:normal bold 14px/20px arial, sans-serif;
				float: right;
			}
			
			
			#wordzone {
			
				width: 600px;
				margin-left: 20px;
				min-height: 400px;
				border: 0px solid #CCCCCC;
				float: left;
			}

			
			
			
			
    </style>
    <link href="bootstrap/css/bootstrap-responsive.css" rel="stylesheet">

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="bootstrap/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="bootstrap/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="bootstrap/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="bootstrap/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="bootstrap/ico/apple-touch-icon-57-precomposed.png">
  </head>

  <body>

    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="#">Diccionario de cocina</a>
          <div class="nav-collapse">
            <ul class="nav">
              <li class="active"><a href="/">Home</a></li>
              <li><a href="">Edit</a></li>
              <li><a href="#contact">Contact</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container">

      <h1>Diccionario de cocina de Angel Muro</h1>
				<div class="alfabeto">
<?php

function print_alpha($x) {
	print "<a href=\"$x.html\"><span class=\"alphaletter\">$x </span></a>";
	return ;
}


for ($i=65; $i<=90; $i++) {
	$x = chr($i);
	print_alpha($x) ;
	if ($x == 'N') print_alpha('Ñ') ;

}
				
?>
				</div> <!-- /alfabeto -->

				<div class="wordlist" id="wordlist">
				
					<p>			</p>

				</div> <!-- / -->
				
				<div id="wordzone">
				
					<form name="wordform" action="?action=write" method="post">
				
						<div id="wordtitle">
						
							<input type="text" name="wordname" id="wordname" value="<?php	echo $wordname ; ?>" />


						</div> <!-- / -->
						
						<div id="worddescription">
						
							<textarea type="text" name="worddesc" id="worddesc"><?php	echo $worddesc ; ?></textarea>


						</div> <!-- / -->
						
						<input id="btn_send" type="submit" value="Enviar"  />
								
					</form> <!-- /wordform -->
				</div> <!-- / -->
				
				
    </div> <!-- /container -->
		
		

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="/ckeditor/ckeditor.js"></script>
		<script type="text/javascript" src="/ckeditor/adapters/jquery.js"></script>
		
		
		<script type="text/javascript">
			CKEDITOR.replace( 'worddesc',
				{
					toolbar : 'Basic',
					uiColor : '#9AB8F3'
				}
			);
		</script>

  </body>
</html>
