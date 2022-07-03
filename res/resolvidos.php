<?php
require_once $_SERVER['DOCUMENT_ROOT']."/SI/conn/conn.php";
require_once $_SERVER['DOCUMENT_ROOT']."/SI/header/head.php";

session_start();
if (!(isset($_SESSION['ID_UTILIZADOR']) && ($_SESSION['tipo'] == 0))) {    // Caso o utilizador já tenha iniciado sessão
  header("Location: /SI/login.php");
  exit(); 
}

if ( ($_SESSION['tipo'] == 1)) {    // Caso o utilizador já tenha iniciado sessão e seja administrador
  header("Location: /SI/home_admin.php");
  exit(); 
}

$EMAIL=  htmlspecialchars($_SESSION["EMAIL"]);
$USERNAME=  htmlspecialchars($_SESSION["USERNAME"]);
$idu=  htmlspecialchars($_SESSION["ID_UTILIZADOR"]);


?>
<!DOCTYPE html>
<head>
</head>
<body class="bg-light">
<div class="d-flex justify-content-left mt-3" >
<img src="/SI/img/fundo.png" class="rounded float-left" id="teste" alt="img-thumbnail" style="height:120px;">
<div class="ml-5">
<h1 class="display-4 mt-3" id="teste"><strong><p class="text-info">Challenge Accepted</p></strong></h1> </div> <!--Titulo -->

</div>
<div class="btn-group dropdown float-right mr-5" id="teste"> <!--Botão do menu do utilizador -->
<button class="btn btn-info dropdown-toggle" type="button" onClick="abrir()" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
  <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-person-circle" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
  <path d="M13.468 12.37C12.758 11.226 11.195 10 8 10s-4.757 1.225-5.468 2.37A6.987 6.987 0 0 0 8 15a6.987 6.987 0 0 0 5.468-2.63z"/>
  <path fill-rule="evenodd" d="M8 9a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
  <path fill-rule="evenodd" d="M8 1a7 7 0 1 0 0 14A7 7 0 0 0 8 1zM0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8z"/>
</svg>
<?php echo $USERNAME ?> <!--Print do nome do utilizador no botão da conta -->
  </button>
  <div class="dropdown-menu" id="opcoes" aria-labelledby="dropdownMenuButton"> 
  <a class="dropdown-item" href="/SI/res/resolvidos.php">Desafios Hash</a>
  <a class="dropdown-item" href="/SI/user/perfil.php">Perfil Pessoal</a>
    <li><hr class="dropdown-divider"></li>
    <a class="dropdown-item" href="/SI/logout.php">Terminar Sessão</a>
    
  </div>
</div></div>
</div>


<div class="bg-white mt-0" id="teste"> <!--Menu Principal -->
  <ul class="nav nav-pills">
    <li class="nav-item"> <!--Item do menu -->
      <a class="nav-link" href="/SI/user/home.php">Adicionar mensagens</a> <!-- Item ativo para aparecer preenchido a azul-->
    </li>
    <li class="nav-item">
      <a class="nav-link" href="/SI/user/descobrir.php">Decifrar mensagens </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="/SI/hash/index.php">Adicionar mensagens Hash</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="/SI/hash/descobrir.php">Descobrir mensagens Hash</a>
    </li>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="/SI/elgamal/index.php">Adicionar Desafio El Gamal</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="/SI/elgamal/descobrir.php">Resolver Desafio El Gamal</a>
    </li>
  </ul> 
</div>

</br>
</br>
</br>
<div class="row">
  <div class="card mx-auto w-75 p-5">
      <h4><p class="text-info">Desafios de Hash que eu resolvi</p></h4>

<?php
      $sql = "SELECT * FROM desafio_hash;"; 
      $result2 = mysqli_query($link,$sql); //Executa o comando sql
    while($row = mysqli_fetch_array($result2)){  //Guarda os valores na variavel row
     $id = $row['id_dh'];
     $IDU = "SELECT * FROM hash_resolvido WHERE id_dh = '"; 
     $IDU .= $id;
     $IDU .= "' and id_participante= '";
     $IDU .= $idu;
     $IDU .="'";
     $result = mysqli_query($link,$IDU);
     $row1 = mysqli_fetch_array($result);
       if(!empty($row1)){
       echo "
       <div class=\"card mt-2\">
       <div class=\"card-header\">
        ".$row['nome']." 
        
        </div>
        <div class=\"card-body\">
        <h5 class=\"card-title\"><strong>Modo de Cifra Hash: ".$row['tipo_cifra']." </strong></h5>
         <p class=\"text-secondary\">
         ".$row['mensagem']." </p>
          </div>
          </div>
 ";
}
    }
    ?>
  </div>  <!--Fim do div da coluna os desafios -->
      </div> <!-- Fim do div da coluna das da esquerda  -->

</br>
</br>
</br>

<?php
  if(isset($_GET['success'])){    //Mensagem de sucesso
    echo '<script type="text/javascript"> window.onload = function(){ if(!alert("Desafio adicionado com sucesso!")) document.location = "/SI/hash/index.php";}</script>';
  }
  if(isset($_GET['error'])){      //Mensagem de erro
    echo '<script type="text/javascript"> window.onload = function(){ if(!alert("Erro!")) document.location = "/SI/hash/index.php";}</script>';
  }  
  if(isset($_GET['error1'])){      //Mensagem de erro
    echo '<script type="text/javascript"> window.onload = function(){ if(!alert("Por favor escolha um metodo de hash")) document.location = "/SI/hash/descobrir.php";}</script>';
  }  
  if(isset($_GET['acertou'])){      //Mensagem de erro
    echo '<script type="text/javascript"> window.onload = function(){ if(!alert("Parabéns! Acertou na mensagem")) document.location = "/SI/hash/descobrir.php";}</script>';
  } 
  if(isset($_GET['errou'])){      //Mensagem de erro
    echo '<script type="text/javascript"> window.onload = function(){ if(!alert("Este não era a resposta correta!")) document.location = "/SI/hash/descobrir.php";}</script>';
  } 

  ?>
