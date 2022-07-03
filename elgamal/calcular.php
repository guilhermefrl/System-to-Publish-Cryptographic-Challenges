<?php
error_reporting(0);
require "../header/head.php";
include "../conn/conn.php";
session_start();
$id_user = $_SESSION['ID_UTILIZADOR'];

$USERNAME=  htmlspecialchars($_SESSION["ID_UTILIZADOR"]);
if(isset($_POST['decifrar_elgamal'])){
    $id = $_POST['desafio'];
    $k = $_POST['valorx'];
    $IDU = "SELECT * FROM desafio_elgamal WHERE id_del = '"; 
    $IDU .= $id;
    $IDU .= "';";
    $result = mysqli_query($link,$IDU);
    $col = mysqli_fetch_array($result);
    $X1=$col['x_mas'];
    $hm=$col['hmac'];
    $c=$col['criptograma'];
    $k2 = hash_hmac('sha256', $X1, $k);

    if($hm ==$k2){
        $dir="acertos";
        $ra= rand(1, 3000); 
        $msg = openssl_decrypt($c, "AES-128-ECB", $k2); 
        $idj=rand(1,250); 
      file_put_contents("$dir/acertos.txt", $msg);
      $sql = "INSERT INTO elgamal_resolvido (id_del, id_participante) values('$id','$id_user')";
      $result = mysqli_query($link,$sql);
           //Mensagem de sucesso
           header("Location: /SI/elgamal/descobrir.php?acertou");   
          

      exit();
    }else{
        header("Location: /SI/elgamal/descobrir.php?errou");      //Mensagem de sucesso
      exit();
    }


}
?>


