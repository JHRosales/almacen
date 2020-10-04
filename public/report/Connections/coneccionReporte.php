<?php
$db ="dhlalmacen";

$ConeccionRatania = mssql_connect("192.168.1.28","sa","ucv")or die('La conexion fall�. Error: ' . mssql_get_last_message());
mssql_select_db($db,$ConeccionRatania);
/*if(@!mssql_connect("127.0.0.1","sa","ucv")){
	//$this->connection = pg_connect(self::$driver2);
	//$ConeccionRatania = pg_connect($cnString2) or die('La conexion fall�. Error: ' . pg_last_error());
	$ConeccionRatania = mssql_connect("127.0.0.1","sa","ucvs");
	mssql_select_db($db,$ConeccionRatania);

}else{

	//$ConeccionRatania = pg_connect($cnString) or die('La conexion fall�. Error: ' . pg_last_error());
}*/
?>
