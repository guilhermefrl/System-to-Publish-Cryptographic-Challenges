<?php
// Include o ficheiro de conexao  e o header e define varáveis usadas na página
require_once "conn/conn.php";
require_once "header/head.php";
session_start();
if (isset($_SESSION['ID_UTILIZADOR']) && ($_SESSION['tipo'] == 0)) {    // Caso o utilizador já tenha iniciado sessão
    header("Location: /SI/user/home.php");
    exit(); 
}

if (isset($_SESSION['ID_UTILIZADOR']) && ($_SESSION['tipo'] == 1)) {    // Caso o utilizador já tenha iniciado sessão e seja administrador
    header("Location: /SI/home_admin.php");
    exit(); 
}

$username = $password = $confirm_password  = $email = $salt = "";
$username_err = $password_err = $confirm_password_err = $email_err  = $salt_err="";
 

if($_SERVER["REQUEST_METHOD"] == "POST"){// Processa o formulário quando ele é enviado
 
    // Validar o username
    if(empty(trim($_POST["username"]))){
    //    $username_err = "Please enter a name.";
    } else{
       
        $sql = "SELECT idu FROM users WHERE username = ?";  // Prepara um sql para selecionar o idu igual ao nome
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* guarda result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){ // Dá erro se o nome já estiver a ser usado
                  //   $username_err = "This username is in use.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } 

            // Fecha o statement
            mysqli_stmt_close($stmt);
        }
    }
    //Validate email
    if(empty(trim($_POST["email"]))){ // Verifica se o campo do email não é vazio
    //    $email_err = "Please enter a email.";
    } else{
        if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {  // Verifica se  o email tem um formato válido
            $email_err = "Invalid email format"; // Erro se for invalido
          }
        // Faz um select para visualizar se o email ja existe na base de dados
        $sql = "SELECT idu FROM users WHERE email = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
         
            mysqli_stmt_bind_param($stmt, "s", $param_email);
            
          
            $param_email = trim($_POST["email"]); //Tira os espaços existentes no email e guarda o valor no param_email
            
      
            if(mysqli_stmt_execute($stmt)){
        
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){ //Se já estiver em uso dá erro
                    $email_err = "This email is already in use."; //Email em uso erro
                } else{
                    $email = trim($_POST["email"]);
                }
            } 

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

 
    // Validate password
    if(empty(trim($_POST["password"]))){ //Valida a palavra passe
      //  $password_err = "Please enter a password.";     //Se o parâmetro for vazio 
    }  else{
        $password = trim($_POST["password"]); // Em caso contrário guarda a palavra passe na variável password
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){  // Se o parâmetro de confirmação não estiver vazio
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    
     // Verifica se os erros das variáveis estão todos vazios
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($email_err)){
                    // Verifica se os erros das variáveis estão todos vazios
 //Sql para inserir
        $sql = "INSERT INTO users (username,password,email,salt) VALUES (?,?,?,?)"; //Sql para inserir
        if($stmt = mysqli_prepare($link, $sql)){ //Prepara a execução dos parâmetros
            // Faz bind das variáveis para depois as introduzir na base de dados
            mysqli_stmt_bind_param($stmt,'ssss', $param_username, $param_password, $param_email,$param_salt);
            $iterations = 1000;
            // Set parameters
            $salt = openssl_random_pseudo_bytes(16);
            $param_salt = bin2hex($salt);
            $param_username = $username;
           
            $param_email = $email;
           // $param_password = password_hash($password,PASSWORD_DEFAULT);
             $param_password = hash_pbkdf2("sha256", $password, $param_salt, $iterations, 150);
            $redirectUrl = 'login.php';
            // Executa os comandos sql e os statments para inserir
            if(mysqli_stmt_execute($stmt)){
             //    Redirect to login page
                header("location: login.php");
                echo '<script type="application/javascript">alert("Registered"); window.location.href = "'.$redirectUrl.'";</script>';
           } else{
                echo "Something went wrong. Please try again later.";
            }
            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="icon" type="image/icon" sizes="16x16" href="img/logo.ico">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 365px; padding: 30px; }
    </style>
</head>
<body class="bg-light">
<div class="row mt-5">
  <img src="img/fundo.png" class="rounded mx-auto d-block" alt="Responsive image"> 
  </div>
<div class="d-flex justify-content-center">
<div class="bg-white mt-5">
<div class="shadow p-3 mb-5 bg-white rounded">
    <div class="wrapper">
        <h2>Registo</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> <!-- Form para preencher os campos do registo-->
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>"> <!-- Form grupo para o nome -->
                <label>Nome de Utilizador</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>" required>
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>"> <!-- Form grupo para o email-->
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="<?php echo $email; ?>" required>
                <span class="help-block"><?php echo $email_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>"> <!-- Form grupo para a password -->
                <label>Palavra Passe</label>
                <input type="password" name="password" class="form-control" value="<?php echo $password; ?> required" > <!-- Input da palavra passe -->
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label>Confirme a Palavra Passe</label>
                <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>" required>
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="container">
            <div class="row">
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submeter"> <!-- Botão de Registo -->
            </div>
        
            <div class="col-md-4 ml-auto">
            <a href="login.php">   <button  type="button"  class="btn btn-secondary">Login</button> </a> <!--Botão para quem já tem conta -->
        </form>
    </div> </div> </div> </div> </div> </div> </div> 
</body>
</html>
