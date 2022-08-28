<?php 

// Valores usados para conectar ao banco de dados
$host = "localhost";
$user = "root";
$password = "";
$nameDB = "upfitt";

// Criando a conexão com banco de dados.
$conn = mysqli_connect($host,$user,$password,$nameDB) or die(mysqli_error);

// If caso a conexão falhar
if($conn->connect_error)
{
    die('A conexão falhou! '.$conn->connect_error);
}
?>