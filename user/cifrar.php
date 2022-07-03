<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/SI/conn/conn.php";             //Incluir a conexão com o servidor MySQL
    session_start();

    if(isset($_POST['cifrar_mensagem'])){
        //Guardar nas variáveis os dados inseridos pelo utilizador
        $titulo = $_POST['titulo'];
        $mensagem = $_POST['mensagem'];
        $pass = $_POST['pass'];
        $cifra = $_POST['cifra'];
        $id_user = $_SESSION['ID_UTILIZADOR'];

        $sql1 = "SELECT chave FROM chave_secreta";      //Query para ir buscar a chave do administrador
        $result1 = mysqli_query($link, $sql1);          //Executar a query na base de dados
        $row = mysqli_fetch_assoc($result1);
        $chave_admin=$row['chave'];                     //Guadar a chave do admin

        $sql2 = "SELECT sk FROM chave_secreta";         //Query para ir buscar a chave privada do administrador
        $result2 = mysqli_query($link, $sql2);          //Executar a query na base de dados
        $row2 = mysqli_fetch_assoc($result2);
        $private_key=$row2['sk'];                       //Guadar a chave privada do admin

        if($result1 && $result2){       //Caso não tenha ocorrido erros a executar as queries

            $hmac = hash_hmac('sha256', $mensagem, $chave_admin);              //Calcular o hmac da mensagem

            $sign = openssl_sign($mensagem, $binary_signature, $private_key, OPENSSL_ALGO_SHA256);      //Assinar a mensagem com a chave privada RSA
            $assinatura = bin2hex($binary_signature);                                                   //Passar a assinatura para hexadecimal

            if($cifra == "AES-128-ECB"){                                       //Caso a cifra escolhida seja a AES-128-ECB
                $criptograma = openssl_encrypt($mensagem, $cifra, $pass);      //Cifrar a mensagem

                //Inserir na base de dados o titulo do desafio, a cifra, o criptograma, o hmac, a assinatura e o ID do utilizador
                $sql = "INSERT INTO desafio_ficheiro (id_enviado, nome, hmac, assinatura, tipo_cifra, mensagem_cifrada, iv) values($id_user, '$titulo', '$hmac', '$assinatura', '$cifra', '$criptograma', '')";
                $result = mysqli_query($link, $sql);                           //Executar a query na base de dados

                if ($result) {                                                 //Caso não tenha ocorrido erros a executar a query
                    header("Location: /SI/user/home.php?success");             //Mensagem de sucesso
                    exit();
                }
                else {
                    header("Location: /SI/user/home.php?error");               //Mensagem de erro
                    exit();
                }
            }
            elseif ($cifra == "AES-128-CBC"){                                                   //Caso a cifra escolhida seja a AES-128-CBC
                $ivlen = openssl_cipher_iv_length($cifra);                                      //Tamanho do vetor de inicialização
                $iv = openssl_random_pseudo_bytes($ivlen);                                      //Gerar o vetor de inicialização
                $criptograma = openssl_encrypt($mensagem, $cifra, $pass, $options=0, $iv);      //Cifrar a mensagem

                $iv_hex = bin2hex($iv);     //Passar o vetor de inicialização para hexadecimal

                //Inserir na base de dados o titulo do desafio, a cifra, o criptograma, o iv, o hmac, a assinatura e o ID do utilizador
                $sql = "INSERT INTO desafio_ficheiro (id_enviado, nome, hmac, assinatura, tipo_cifra, mensagem_cifrada, iv) values($id_user, '$titulo', '$hmac', '$assinatura', '$cifra', '$criptograma', '$iv_hex')";
                $result = mysqli_query($link, $sql);                    //Executar a query na base de dados

                if ($result) {                                          //Caso não tenha ocorrido erros a executar a query
                    header("Location: /SI/user/home.php?success");      //Mensagem de sucesso
                    exit();
                }
                else {
                    header("Location: /SI/user/home.php?error");        //Mensagem de erro
                    exit();
                }
            }
            elseif ($cifra == "AES-128-CTR"){                                                   //Caso a cifra escolhida seja a AES-128-CTR
                $ivlen = openssl_cipher_iv_length($cifra);                                      //Tamanho do vetor de inicialização
                $iv = openssl_random_pseudo_bytes($ivlen);                                      //Gerar o vetor de inicialização
                $criptograma = openssl_encrypt($mensagem, $cifra, $pass, $options=0, $iv);      //Cifrar a mensagem

                $iv_hex = bin2hex($iv);     //Passar o vetor de inicialização para hexadecimal

                //Inserir na base de dados o titulo do desafio, a cifra, o criptograma, o iv, o hmac, a assinatura e o ID do utilizador
                $sql = "INSERT INTO desafio_ficheiro (id_enviado, nome, hmac, assinatura, tipo_cifra, mensagem_cifrada, iv) values($id_user, '$titulo', '$hmac', '$assinatura', '$cifra', '$criptograma', '$iv_hex')";
                $result = mysqli_query($link, $sql);                    //Executar a query na base de dados

                if ($result) {                                          //Caso não tenha ocorrido erros a executar a query
                    header("Location: /SI/user/home.php?success");      //Mensagem de sucesso
                    exit();
                }
                else {
                    header("Location: /SI/user/home.php?error");        //Mensagem de erro
                    exit();
                }
            }
        }
        else{
            header("Location: /SI/user/home.php?error");                //Mensagem de erro
            exit();
        }
    }
    else {
        header("Location: /SI/user/home.php?error");                //Mensagem de erro
        exit();
    }
?>
