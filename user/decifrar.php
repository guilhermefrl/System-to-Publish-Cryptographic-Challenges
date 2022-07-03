<?php
error_reporting(0);
require "../header/head.php";
include "../conn/conn.php";
session_start();

$USERNAME=  htmlspecialchars($_SESSION["ID_UTILIZADOR"]);
if(isset($_POST['decifrar_ficheiro'])){
  $pass = $_POST['pass'];
  $id = $_POST['desafio'];

  $IDU = "SELECT * FROM desafio_ficheiro WHERE id_df = '"; 
  $IDU .= $id;
  $IDU .= "';";
  $result = mysqli_query($link,$IDU);
  $col = mysqli_fetch_array($result);
  $msg = $col['mensagem_cifrada'];
  $cifra1 =  $col['tipo_cifra'];
  $hmac1= $col['hmac'];
  $iv= $col['iv'];

  $iduser=$_SESSION["ID_UTILIZADOR"];


  $sql1 = "SELECT chave, pk FROM chave_secreta";    //Query para ir buscar a chave e chave pública do administrador
  $result1 = mysqli_query($link, $sql1);      //Executar a query na base de dados
  $row = mysqli_fetch_assoc($result1);
  $chave_admin=$row['chave'];
  $public_key=$row['pk'];

  $assinatura=$col['assinatura'];
  $binary_signature = hex2bin($assinatura); //Passar a assinatura para binário

  if($cifra1 == "AES-128-ECB"){
    $calculado1 = openssl_decrypt($msg, $cifra1, $pass);
  }
  elseif ($cifra1 == "AES-128-CBC"){
    $iv_bin = hex2bin($iv);
    $calculado1 = openssl_decrypt($msg, $cifra1, $pass, $options=0, $iv_bin);
  }
  elseif ($cifra1 == "AES-128-CTR"){    
    $iv_bin = hex2bin($iv);
    $calculado1 = openssl_decrypt($msg, $cifra1, $pass, $options=0, $iv_bin);
  }

  $calculado2 = hash_hmac('sha256', $calculado1, $chave_admin);

  $verify = openssl_verify($calculado1, $binary_signature, $public_key, "sha256WithRSAEncryption");   //Verificar assinatura

  if(($calculado2==$hmac1) && ($verify == 1)){
    $sql = "INSERT INTO ficheiro_resolvido (id_df, id_participante) values('$id','$iduser')";
    $result = mysqli_query($link,$sql);

    file_put_contents('acerto.txt',$calculado1);

    if($result){
      header("Location: /SI/user/descobrir.php?acertou");      //Mensagem de sucesso
      exit();
    }
    else{
      header("Location: /SI/user/descobrir.php?error"); 
      exit();
    }
  }else{
    header("Location: /SI/user/descobrir.php?errou");      //Mensagem de sucesso
    exit();

  }
  echo "</div>";
}
?>
