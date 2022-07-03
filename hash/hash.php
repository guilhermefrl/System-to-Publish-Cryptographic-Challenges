<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/SI/conn/conn.php";             //Incluir a conexão com o servidor MySQL
    session_start();

    if(isset($_POST['cifrar_mensagem'])){
        //Guardar nas variáveis os dados inseridos pelo utilizador
        $titulo = $_POST['titulo'];
        $mensagem = $_POST['mensagem'];
        $cifra = $_POST['cifra'];
        $id_user = $_SESSION['ID_UTILIZADOR'];
        if($cifra=="DFLT"){
            header("Location: /SI/hash/index.php?error1");   
        }else{
            echo $cifra;
            

                                           //Caso a cifra escolhida seja a md5
            $hash = openssl_digest($mensagem,$cifra);      //Cifrar a mensagem
            $id1=0;
            $id2="";
            echo $hash;
            //Inserir na base de dados o titulo do desafio, a cifra, o criptograma, o hmac e o ID do utilizador
            $sql = "INSERT INTO desafio_hash (nome, id_enviado,mensagem,tipo_cifra,hash) values('$titulo','$id_user','$id2','$cifra','$hash')";
            $result = mysqli_query($link, $sql);                           //Executar a query na base de dados

            if ($result) {                                                 //Caso não tenha ocorrido erros a executar a query
              header("Location: /SI/hash/index.php?success");             //Mensagem de sucesso
                exit();
            }
            else {
                header("Location: /SI/hash/index.php?error");               //Mensagem de erro
                exit();
            }
    }
}
    else {
        header("Location: /SI/hash/index.php?error");                //Mensagem de erro
        exit();
    }
?>
