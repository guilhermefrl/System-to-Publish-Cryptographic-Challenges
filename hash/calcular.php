<?php
error_reporting(0);
require "../header/head.php";
include "../conn/conn.php";
session_start();
$id_user = $_SESSION['ID_UTILIZADOR'];
$USERNAME=  htmlspecialchars($_SESSION["ID_UTILIZADOR"]);
if(isset($_POST['decifrar_hash'])){
  $mensagem = $_POST['mensagem'];
  $id = $_POST['desafio'];

$IDU = "SELECT * FROM desafio_hash WHERE id_dh = '"; 
$IDU .= $id;
$IDU .= "';";
$result = mysqli_query($link,$IDU);
$col = mysqli_fetch_array($result);
$hash = $col['hash'];
$cifra12 =  $col['tipo_cifra'];


$calculado = openssl_digest($mensagem, $cifra12); 
if($calculado==$hash){
  $sql = "INSERT INTO hash_resolvido (id_dh, id_participante) values('$id','$id_user')";
    $result = mysqli_query($link,$sql);
    $sql3= "UPDATE desafio_hash SET mensagem = '";
    $sql3 .= $mensagem;
    $sql3 .="'WHERE id_dh='";
    $sql3 .= $id;
    $sql3 .="'";
    $result = mysqli_query($link,$sql3);

    $result = mysqli_query($link,$sql2);


    header("Location: /SI/hash/descobrir.php?acertou");      //Mensagem de sucesso
                exit();
}else{
  header("Location: /SI/hash/descobrir.php?errou");      //Mensagem de sucesso
  exit();

}
echo "</div>";
}
?>