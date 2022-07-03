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
$new_password = $confirm_password = "";
$new_password_err = $confirm_password_err = "";
if(isset($_POST['submit'])){ //Se for submetido o formulário de alteração da palavra passe
 
    if(empty(trim($_POST["new_password"]))){ //Verifica se o new_password não é vazio
        $new_password_err = "Por favor insira a nova palavra passe";   //Se for vazio dá erro  
    }  else{
        $new_password = trim($_POST["new_password"]); //Senão for vazio então recebe o parâmetro
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Por favor confirme a palavra passe"; //Se o confirm_password for vazio
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($new_password_err) && ($new_password != $confirm_password)){ //Se as palavras passes forem diferentes e o erro do segundo for vazio então é porque não correspondem
            $confirm_password_err = "As palavras passes não correspondem";
        }
    }
        
    if(empty($new_password_err) && empty($confirm_password_err)){ //Se as variaveis de erro forem vazias então continuamos com a alteração
    
        $sql = "UPDATE users SET password = ?,salt = ? WHERE idu = ?"; //Sql de update
        
        if($stmt = mysqli_prepare($link, $sql)){

            mysqli_stmt_bind_param($stmt, "ssi", $param_password,$param_salt, $param_id);
            // Set parameters
            $iterations = 1000;
            $salt = openssl_random_pseudo_bytes(16);
            $param_salt = bin2hex($salt);
            $param_password = hash_pbkdf2("sha256", $new_password, $param_salt, $iterations, 150);//Cria um novo codigo hash para a palavra passe inserida
            $param_id = $_SESSION["ID_UTILIZADOR"];

            if(mysqli_stmt_execute($stmt)){ //Executa o statment de substituição da antiga palavra passe pela nova
                session_destroy();
                header("location: login.php");
                exit();
            } else{
                echo "Error. Please try again later.";
            }
            mysqli_stmt_close($stmt);
        }
    }
  //  mysqli_close($link);
}
?>
<!DOCTYPE html>
<head>
</head>
<body class="bg-light">
<div class="d-flex justify-content-left mt-3" >
<img src="img/fundo.png" class="rounded float-left" id="teste" alt="img-thumbnail" style="height:120px;">
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
    <a class="dropdown-item" href="admin.php">Perfil Pessoal</a>
    <li><hr class="dropdown-divider"></li>
    <a class="dropdown-item" href="logout.php">Terminar Sessão</a>
    
  </div>
</div></div>
</div>


<div class="bg-white mt-0" id="teste"> <!--Menu Principal -->
<ul class="nav nav-pills">
  <li class="nav-item"> <!--Item do menu -->
    <a class="nav-link" href="home_admin.php">Home</a> <!-- Item ativo para aparecer preenchido a azul-->
  </li>
</ul> 
</div>

<div class="row mt-2 ml-5 mr-2">

    <div class="col-sm-6"> 
        <div class="table">

<table> <!-- Tabela com as informações do utilizador -->
    <thead>
        <tr>
         <th>Meu Perfil</th> 
        </tr>
    </thead>
    <tbody>
    <?php

$sql = "SELECT * FROM users WHERE email='";
$sql .= $EMAIL;
$sql .= "';";
$result2 = mysqli_query($link,$sql); 
    while($row = mysqli_fetch_array($result2)){ // Mostra as Informações do utilizador na tabela
       echo "
           <tr>
            <td>Name: ".$row['username']."</td> 
            </tr>

            <tr>
            <td>Email: ".$row['email']." </td>
            </tr>  ";
}
    ?>
    </tbody></table>
    </div>   </div>  
    <div class="col-sm-4">
    <div class="wrapper"> <!--Formulário para mudança da palavra passe -->
        <h2>Alterar a palavra passe</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> <!--Form da palavra passe com action para esta página -->
            <div class="form-group <?php echo (!empty($new_password_err)) ? 'has-error' : ''; ?>">
                <label>Nova palavra pases</label>
                <input type="password" name="new_password" class="form-control" value="<?php echo $new_password; ?>" style="width: 250px;"> <!-- Parâmetro da nova palavra passe-->
                <span class="help-block"><?php echo $new_password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>"> <!--Form para confirmar a nova palavra passe -->
                <label>Introduza de Novo</label>
                <input type="password" name="confirm_password" class="form-control" style="width: 250px;">
                <span class="help-block"><?php echo $confirm_password_err; ?></span> <!-- span para mostrar os erros da nova palavra passe-->
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" name="submit" value="Alterar"> <!-- Botão de envio-->
                <input class="btn btn-danger" value="Reset" type="reset"> <!--Botao de reset -->
            </div>
        </form>
        </div>
    </div></body>
