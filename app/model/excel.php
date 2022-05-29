<?php

$file		= $_FILES['excel']['name'];
$_UP['folder']	= '../../';
move_uploaded_file($_FILES['excel']['tmp_name'], $_UP['folder'] . 'Fluxo_de_Trabalho.xlsx');

sleep(3);

use Shuchkin\SimpleXLSX;

ini_set('error_reporting', E_ALL);
ini_set('display_errors', true);

require_once '../../app/vendor/simplexlsx/src/SimpleXLSX.php';

$sql = 'INSERT INTO charts (date, client, collaborator, status) VALUES ';

if ($xlsx = SimpleXLSX::parse('../../Fluxo_de_Trabalho.xlsx')) {
  $fetch = $xlsx->rows();
  $count = (count($fetch)-1);
  for($i=1;$i<$count;$i++){
    $sql .= "(";
    //$sql .= "'".date("Y-m-d", strtotime(substr($fetch[$i][1], 0, -6)))."', ";
    $sql .= "'".date("Y-m-d", strtotime(str_replace("/", "-", substr($fetch[$i][1], 0, -6))))."', ";
    $sql .= "'".str_replace("'", "", $fetch[$i][8])."', ";
    $sql .= "'".$fetch[$i][11]."', ";
    $sql .= "'".$fetch[$i][13]."', ";
    $sql = rtrim($sql, ", ");
    $sql .= "), ";
  }
  $sql = rtrim($sql, ", ");


} else {
    echo SimpleXLSX::parseError();
}

include '../../app/config/database.php';

$conn		= db();
$query	= $conn->prepare("TRUNCATE TABLE charts");
$query->execute();

$query	= $conn->prepare($sql);
$query->execute();


header("Location:/report/charts");






?>
