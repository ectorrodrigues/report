<?php
	function db () {
		static $conn;


		$localhost_check = $_SERVER['HTTP_HOST'];
		if (strpos($localhost_check, 'localhost') !== false) {
			$servername	= 'localhost';
			$dbname		= 'report';
			$username	= 'root';
			$password	= '';
			$port = 3306;
		} else {
			$servername	= 'localhost';
			$dbname		= 'report';
			$username	= 'root';
			$password	= '';
			$port = 3306;
		}

		try{
			$conn = new PDO("mysql:host=$servername; dbname=$dbname; port=$port", $username, $password);
			// set the PDO error mode to exception
		  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		  $conn->exec("SET NAMES 'utf8'");

		}catch(Exception $e){
		  echo "Error: " . $e->getMessage();
		  exit;
		}

		return $conn;

	}



  $conn = db();

  /*
  $x = 0;
  foreach($conn->query("SELECT date FROM report WHERE collaborator = 'Ector' GROUP BY CAST(date AS DATE) ") as $row) {
		$fetch		= $row['date'];

    $x++;
    echo $fetch.'<br>';
	}
  echo $x;
*/


  // $cot = 0;
    $conn = db();
  $x = 1;
  $last_fetch = '2021-01-01';
  foreach($conn->query("SELECT date FROM report WHERE collaborator = 'Ector'") as $row) {
		$fetch		= $row['date'];
    if($fetch === $last_fetch){
      $x++;
    } else {
      echo $last_fetch.'  --  '.$x.'  --  '.$cot.'<br>';
      $x = 1;
      //$cot++;
    }
    $last_fetch = $fetch;
	}

  //echo $cot;


?>
