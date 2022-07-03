<?php
require_once "conn/conn.php";
require_once "header/head.php";

session_start();
if (isset($_SESSION['ID_UTILIZADOR']) && ($_SESSION['tipo'] == 0)) {    // Caso o utilizador já tenha iniciado sessão
    header("Location: /SI/home.php");
    exit(); 
}

if (!isset($_SESSION['ID_UTILIZADOR']) && ($_SESSION['tipo'] == 1)) {    // Caso o utilizador já tenha iniciado sessão e seja administrador
   header("Location: /SI/login.php");
    exit(); 
}

$EMAIL=  htmlspecialchars($_SESSION["EMAIL"]);
$USERNAME=  htmlspecialchars($_SESSION["USERNAME"]);
$new_chave = $confirm_chave = "";
$new_chave_err = $confirm_chave_err = "";
$new_p = $new_g = $new_p_err = $new_g_err = "";

if(isset($_POST['chave'])){ //Se for submetido o formulário de alteração da palavra passe
 
  if(empty(trim($_POST["new_chave"]))){ //Verifica se o new_password não é vazio
      $new_chave_err = "Por favor insira a chave secreta";   //Se for vazio dá erro  
  }  else{
      $new_chave = trim($_POST["new_chave"]); //Senão for vazio então recebe o parâmetro
  }
  
  // Validate confirm password
  if(empty(trim($_POST["confirm_chave"]))){
      $confirm_chave_err = "Por favor confirme a chave secreta"; //Se o confirm_password for vazio
  } else{
      $confirm_chave = trim($_POST["confirm_chave"]);
      if(empty($new_chave_err) && ($new_chave != $confirm_chave)){ //Se as palavras passes forem diferentes e o erro do segundo for vazio então é porque não correspondem
          $confirm_chave_err = "As chaves não correspondem";
      }
  }

if(empty($new_chave_err) && empty($confirm_chave_err)){ //Se as variaveis de erro forem vazias então continuamos com a alteração
    
  $sql = "UPDATE chave_secreta SET chave = ?,data = ? WHERE id = ?"; //Sql de update
  
  if($stmt = mysqli_prepare($link, $sql)){

      mysqli_stmt_bind_param($stmt, "ssi", $param_chave,$data, $param_id);
     $param_id = 1;
     $param_chave =$new_chave;
     $data = date("Y-m-d");

      if(mysqli_stmt_execute($stmt)){ //Executa o statment de substituição da antiga chave pela nova
  
          header("location: home_admin.php?sucesso");
          exit();
      } else{
        header("location: home_admin.php?error");
        exit();
      }
      mysqli_stmt_close($stmt);
  }
} }
if(isset($_POST['newpg'])){ //Se for submetido o formulário de alteração da palavra passe
 
  if(empty(trim($_POST["new_p"]))){ //Verifica se o new_password não é vazio
      $new_p_err = "Por favor insira o valor de P";   //Se for vazio dá erro  
  }  else{
      $new_p = trim($_POST["new_p"]); //Senão for vazio então recebe o parâmetro
  }
  
  // Validate confirm password
  if(empty(trim($_POST["new_g"]))){
      $new_g_err = "Por favor insira o valor de G"; //Se o confirm_password for vazio
  } else{
      $new_g = trim($_POST["new_g"]);
  }

if(empty($new_p_err) && empty($new_g_err)){ //Se as variaveis de erro forem vazias então continuamos com a alteração
    
  $sql = "UPDATE elgamal_param SET P = ?,G = ? WHERE idc = ?"; //Sql de update
  
  if($stmt = mysqli_prepare($link, $sql)){

      mysqli_stmt_bind_param($stmt, "ssi", $param_p,$param_g, $param_id);
     $param_id = 1;
     $param_p = $new_p;
     $param_g = $new_g;

      if(mysqli_stmt_execute($stmt)){ //Executa o statment de substituição da antiga chave pela nova
  
          header("location: home_admin.php?sucesso");
          exit();
      } else{
        header("location: home_admin.php?error");
        exit();
      }
      mysqli_stmt_close($stmt);
  }
} }
?>
<!DOCTYPE html>
<head>
</head>
<body class="bg-light">
<div class="d-flex justify-content-left mt-3" >
<img src="img/fundo.png" class="rounded float-left" id="teste" alt="img-thumbnail" style="height:120px;">
<div class="ml-5">
<h1 class="display-4 mt-3" id="teste"><strong><p class="text-info">Challenge Accepted -- Administrador</p></strong></h1> </div> <!--Titulo -->

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
  <a class="dropdown-item" href="admin.php">Perfil Pessoal</a>
    <li><hr class="dropdown-divider"></li>
    <a class="dropdown-item" href="logout.php">Terminar Sessão</a>
    
  </div>
</div></div>
</div>


<div class="bg-white mt-0" id="teste"> <!--Menu Principal -->
<ul class="nav nav-pills">
  <li class="nav-item"> <!--Item do menu -->
    <a class="nav-link active" href="home_admin.php">Home</a> <!-- Item ativo para aparecer preenchido a azul-->
  </li>
 
</ul> 
</div>

<div class="row mt-2 ml-5 mr-2">
    <div class="col-sm-6">  
    <h2>Alterar a chave secreta</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> <!--Form da palavra passe com action para esta página -->
            <div class="form-group <?php echo (!empty($new_chave_err)) ? 'has-error' : ''; ?>">
                <label>Nova chave secreta</label>
                <input type="text" name="new_chave" class="form-control" value="<?php echo $new_chave; ?>" style="width: 250px;"> <!-- Parâmetro da nova palavra passe-->
                <span class="help-block"><?php echo $new_chave_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_chave_err)) ? 'has-error' : ''; ?>"> <!--Form para confirmar a nova palavra passe -->
                <label>Confirme a chave secreta</label>
                <input type="text" name="confirm_chave" class="form-control" style="width: 250px;">
                <span class="help-block"><?php echo $confirm_chave_err; ?></span> <!-- span para mostrar os erros da nova palavra passe-->
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" name="chave" value="Alterar"> <!-- Botão de envio-->
                <input class="btn btn-danger" value="Reset" type="reset"> <!--Botao de reset -->
            </div>
        </form>

    </div>
    <div class="col-sm-6">  
    <h2>Alterar P e G das cifras de El Gamal</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> <!--Form da palavra passe com action para esta página -->
            <div class="form-group <?php echo (!empty($new_p_err)) ? 'has-error' : ''; ?>">
                <label>Novo valor de P</label>
                <input type="number" name="new_p" class="form-control" value="<?php echo $new_p; ?>" style="width: 250px;"> <!-- Parâmetro da nova palavra passe-->
                <span class="help-block"><?php echo $new_p_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($new_g_err)) ? 'has-error' : ''; ?>"> <!--Form para confirmar a nova palavra passe -->
                <label>Novo valor de G</label>
                <input type="number" name="new_g" class="form-control" style="width: 250px;">
                <span class="help-block"><?php echo $new_g_err; ?></span> <!-- span para mostrar os erros da nova palavra passe-->
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" name="newpg" value="Alterar"> <!-- Botão de envio-->
                <input class="btn btn-danger" value="Reset" type="reset"> <!--Botao de reset -->
            </div>
        </form>


    </div>  
    </div>  
    </body>
    <?php
  if(isset($_GET['sucesso'])){    //Mensagem de sucesso
    echo '<script type="text/javascript"> window.onload = function(){ if(!alert("Alterado com sucesso")) document.location = "/SI/home_admin.php";}</script>';
  }
  if(isset($_GET['error'])){      //Mensagem de erro
    echo '<script type="text/javascript"> window.onload = function(){ if(!alert("Erro!")) document.location = "/SI/home_admin.php";}</script>';
  }  
?>
