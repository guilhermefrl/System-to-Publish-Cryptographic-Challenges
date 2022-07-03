<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/SI/conn/conn.php";             //Incluir a conexão com o servidor MySQL
    session_start();
    $id_user = $_SESSION['ID_UTILIZADOR'];

    if(isset($_POST['add_elgamal'])){
    
        $sql1 = "SELECT chave FROM chave_secreta";    //Query para ir buscar a chave do administrador
        $result1 = mysqli_query($link, $sql1);      //Executar a query na base de dados
        $row = mysqli_fetch_assoc($result1);
        $chave_admin=$row['chave'];   
        $id2="";
        
        //Guardar nas variáveis os dados inseridos pelo utilizador
        $sql2 = "SELECT * FROM elgamal_param;"; 
        $result2 = mysqli_query($link,$sql2); //Executa o comando sql
        $row = mysqli_fetch_array($result2);
        $v1 = $row['P'];
        $v2 = $row['G'];
        $titulo = $_POST['titulo'];
        $x = $_POST['valorx'];
        $mensagem = $_POST['mensagem'];
      //  if($x > $v1){
         //   header("Location: /SI/elgamal/index.php?invalidox");             //Mensagem de erro no x
        //    exit();
       // }

        $tg=pow($v2,$x);
        $X1= (int)fmod($tg,$v1);   
        $y= rand(1, $v1);   
        $tg1=pow($v2,$y);
        $Y2=(int)fmod($tg1,$v1); 

        $tg3=pow($X1,$y);
        $K=(int)fmod($tg3,$v1); 
        

        $k2 =  hash_hmac('sha256', $X1, $K);
        $criptograma = openssl_encrypt($mensagem, "AES-128-ECB", $k2);  
            //Inserir na base de dados o titulo do desafio, a cifra, o criptograma, o hmac e o ID do utilizador
            $sql = "INSERT INTO desafio_elgamal (nome, id_enviado,g,p,x_min,x_mas,y_min,y_mas,hmac,criptograma) values('$titulo','$id_user','$v2','$v1','$x','$X1','$y','$Y2','$k2','$criptograma')";
            $result1 = mysqli_query($link, $sql);                           //Executar a query na base de dados

            if ($result1) {                                                 //Caso não tenha ocorrido erros a executar a query
             header("Location: /SI/elgamal/index.php?success");             //Mensagem de sucesso
                exit();
            }
            else {
                header("Location: /SI/elgamal/index.php?error1");               //Mensagem de erro
                exit();
            }
    
}
    else {
        header("Location: /SI/elgamal/index.php?error");                //Mensagem de erro
        exit();
    }
?>
