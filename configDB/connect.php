<?php

$hostname = "servicosautonomos.mysql.database.azure.com";
$dbname = "servicos_schema";
$username = "celso019";
$password  = "Biscoit@007153";

$dir = $_SERVER['DOCUMENT_ROOT'];

$conn = mysqli_init();

mysqli_ssl_set($conn,NULL,NULL, "$dir/servicos-autonomos/certificate/DigiCertGlobalRootCA.crt.pem", NULL, NULL);
mysqli_real_connect($conn, $hostname, $username, $password, $dbname, 3306, MYSQLI_CLIENT_SSL);


if ($conn->error) {
die('Failed to connect to MySQL: ' .$conn->error);
}