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

if($_SERVER["REQUEST_METHOD"] == "POST"){// Processa o formulário quando ele é enviado
    // Faz um select para visualizar se o email ja existe na base de dados
    $sql = "SELECT idu FROM users WHERE email = ?";
        
    if($stmt = mysqli_prepare($link, $sql)){
        
        mysqli_stmt_bind_param($stmt, "s", $param_email);
        
        $param_email = trim($_POST["email"]); //Tira os espaços existentes no email e guarda o valor no param_email
        
        if(mysqli_stmt_execute($stmt)){
    
            mysqli_stmt_store_result($stmt);
            
            if(mysqli_stmt_num_rows($stmt) == 0){ //Se não existir email
                $redirectUrl = 'login.php';
                // Close statement
                mysqli_stmt_close($stmt);
                echo '<script type="application/javascript">alert("O email não existe!"); window.location.href = "'.$redirectUrl.'";</script>';
            }
            else{
                // Faz um select da palavra-passe, salt, do id e do username
                $sql = "SELECT password, salt, idu, username, tipo FROM users WHERE email = ?";

                if($stmt = mysqli_prepare($link, $sql)){
                    mysqli_stmt_bind_param($stmt, "s", $param_email1);

                    $param_email1 = trim($_POST["email"]); //Tira os espaços existentes no email e guarda o valor no param_email1

                    if(mysqli_stmt_execute($stmt)){
                        $result = mysqli_stmt_get_result($stmt);
                        $row = mysqli_fetch_assoc($result);

                        // Set parameters
                        $iterations = 1000;
                        $salt = $row["salt"];
                        $password = $_POST['password'];

                        // $pass = password_hash($password,PASSWORD_DEFAULT);
                        $pass = hash_pbkdf2("sha256", $password, $salt, $iterations, 150);

                        if($pass == $row["password"] && $row["tipo"] == 0 && empty($_POST['ToggleSwitchAdmin'])){     //Caso seja um utilizador
                            //Guardar no array da sessão os dados do utilizador
                            $_SESSION['ID_UTILIZADOR'] = $row["idu"];
                            $_SESSION['USERNAME'] = $row["username"];
                            $_SESSION['EMAIL'] = $_POST["email"];
                            $_SESSION['tipo'] = $row["tipo"];

                            // Close statement
                            mysqli_stmt_close($stmt);
                            header("Location: /SI/user/home.php");
                        }
                        elseif($pass == $row["password"] && $row["tipo"] == 1 && !empty($_POST['ToggleSwitchAdmin'])) {   //Caso seja um administrador
                            //Guardar no array da sessão os dados do administrador
                            $_SESSION['ID_UTILIZADOR'] = $row["idu"];
                            $_SESSION['USERNAME'] = $row["username"];
                            $_SESSION['EMAIL'] = $_POST["email"];
                            $_SESSION['tipo'] = $row["tipo"];

                            // Close statement
                            mysqli_stmt_close($stmt);
                            header("Location: /SI/home_admin.php");
                        }
                        else{       //Caso os dados inseridos sejam incorretos
                            mysqli_stmt_close($stmt);
                            $redirectUrl = 'login.php';
                            echo '<script type="application/javascript">alert("Dados incorretos!"); window.location.href = "'.$redirectUrl.'";</script>';
                        }
                    }
                }
            }
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
    <title>Login</title>
    <link rel="icon" type="image/icon" sizes="16x16" href="img/logo.ico">
    <style type="text/css">
        .wrapper{ width: 365px; padding: 30px; }
    </style>
</head>
<body class="bg-light" style="font-family: sans-serif; font-size: 14px;">
<div class="row mt-5">
  <img src="img/fundo.png" class="rounded mx-auto d-block" alt="Responsive image"> 
  </div>
<div class="d-flex justify-content-center">
<div class="bg-white mt-5">
<div class="shadow p-3 mb-5 bg-white rounded">
    <div class="wrapper">
        <h2>Login</h2>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> <!-- Form para preencher os campos do login-->
            <div class="form-row">
                <div class="col-md-12 mb-3">
                    <label>Email</label>
                    <input type="email" class="form-control" name="email" required> <!-- Campo para o email -->
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-12 mb-3">
                    <label>Palavra-passe</label>
                    <input type="password" class="form-control" name="password" required> <!-- Campo para a palavra-passe-->
                </div>
            </div>

            <div class="form-row">
                <div class="col-md-12 mb-3">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="Switch" name="ToggleSwitchAdmin">
                        <label class="custom-control-label" for="Switch" style="font-size: 15px;">Admin</label> <!-- Toggle Switch para ir para a conta do admin-->
                    </div>
                </div>
            </div>
            
            <div class="container">
            <div class="row">
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login"> <!-- Botão de Login -->
            </div>
        
            <div class="col-md-4 ml-auto">
            <a href="registo.php">   <button  type="button"  class="btn btn-secondary">Registo</button> </a> <!--Botão para se registar -->
        </form>
    </div> </div> </div> </div> </div> </div> </div> 
</body>
</html>
