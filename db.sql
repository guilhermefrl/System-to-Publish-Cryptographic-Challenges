-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 14-Maio-2021 às 22:20
-- Versão do servidor: 10.4.18-MariaDB
-- versão do PHP: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `projeto_si`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `chave_secreta`
--

CREATE TABLE `chave_secreta` (
  `id` int(11) NOT NULL,
  `chave` varchar(500) NOT NULL,
  `data` date NOT NULL,
  `pk` text NOT NULL,
  `sk` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `chave_secreta`
--

INSERT INTO `chave_secreta` (`id`, `chave`, `data`, `pk`, `sk`) VALUES
(1, '69f61348f76a8416055728b5891009a9', '2021-05-14', '-----BEGIN PUBLIC KEY-----\r\nMIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA1jExhDgXq+/U8VgTBkoq\r\nipl5kawhnRuVVH4lWWJr1h5w1lomKNmn6IHXPHjSsYnUh47FlUtlNCT5EjbSyicB\r\nbmixDKr+/sVZaxukxU5m01go+ZLG29+swPiSV4tb2RYEuq7YdCFkcsjvp/rpUYJc\r\n7oFJO/CJ1Si9n1GFt2LYbqFTaagCLSssqEfrRh6TYP90pqnMh26PEX4SGIp5y9Dv\r\n+9AUMPdgIAru1jC9HXldHQ9XzlTReI3JJOKtqOvs9bj7quDeSacPTk9dthwm1sYJ\r\nX6rdoyFR2Dqjs2kSxnsHlnnVe+SlM4gtfZUMQKTe2T5gnf05PMlF9EbZ4iQ25J0B\r\n7QIDAQAB\r\n-----END PUBLIC KEY-----', '-----BEGIN RSA PRIVATE KEY-----\r\nMIIEowIBAAKCAQEA1jExhDgXq+/U8VgTBkoqipl5kawhnRuVVH4lWWJr1h5w1lom\r\nKNmn6IHXPHjSsYnUh47FlUtlNCT5EjbSyicBbmixDKr+/sVZaxukxU5m01go+ZLG\r\n29+swPiSV4tb2RYEuq7YdCFkcsjvp/rpUYJc7oFJO/CJ1Si9n1GFt2LYbqFTaagC\r\nLSssqEfrRh6TYP90pqnMh26PEX4SGIp5y9Dv+9AUMPdgIAru1jC9HXldHQ9XzlTR\r\neI3JJOKtqOvs9bj7quDeSacPTk9dthwm1sYJX6rdoyFR2Dqjs2kSxnsHlnnVe+Sl\r\nM4gtfZUMQKTe2T5gnf05PMlF9EbZ4iQ25J0B7QIDAQABAoIBABxzQlF+pd5Hp/A6\r\ns6Q1O7tXMWehBoH4xPgJHWrnAM3bEz/Vj5YDeyMOBAnbPpkoZptu4l23OwUXGCJM\r\nN+l0DuOcck/tcptimUL51AQFKvFNl3u2/ET+S9MB8WZBc3y9SPmG+edK/C2m9PZK\r\nBK239CIV+CVHCPfQRoef63P1ZCwlcTf8KL5yCaoSwpSUcrOJaQDdBjmLO7fnHjHF\r\ndMzOOhDP84XUISaGBN1wUmVfbddwYUtZP5SKjYOkhmsSlIZdWMYFjVTxjdIdji7K\r\nz7parvI2U/YChzIw2cJ6JeOcGq14bqLht4iBotO+Nja1GTNN4Jyn36D4npbJSzVK\r\nToHJSgECgYEA+i/TKmJnGojyW3B2C0iU/Ximoxv3M3SkEZ9AlLqewNM7sFgunZTn\r\naKr+h5Af7ZHJr3G+2Pvv68/2DHGdYZsvPrqVerRaVB+SnDGQyUiEvtbX4xkN41Z5\r\nmCwZMXC/rweXqKPm2jnph4dYAg78sVW63uI7MN8oV85wGKjWPTkS2G0CgYEA2ytD\r\nXhydqQN41Stpj1wUz/wqEQYF84/UFoEBAQbfdlNeTFOaluHb7sLKdhVHsjd7KMvK\r\n2Vl4P+ckRMSVsfBoLdOcmsSmjSOFjDCr/lOSvlkHBsNoanTuP0cWOqA5NJMk/OYY\r\n1h1B+QAAOXwrKlrthsand/IasaSQJTl+zJWT34ECgYEA2XKxxXfrhwuaIdF4N8xo\r\n+nlf1Aqda5Koe0x/9ATTsGKn0ViDg6EFFFryiN7CcViyBBQHvU4TtFB22U/yawBX\r\nKt0+yHxyugULB0ipP9kQz1GqKA8BnCLv4kwJxYfqgnVF4mQ6ZFfLWmlPG9Ls3DDY\r\nD5pvucVrqg2aLkSomGO/tm0CgYA0URN3t6T631VMrVw5WGWvcCYqgiGRjle2N30h\r\n3Z4iBKyR07MnKSryx5TEsze2FwBTMLJvR6gouOgzcim5nAWCSu0rFJ4dOsl6OXQU\r\n9aYlweKnfqXCI79rY3Cu9egx4J4HsHVlRv6kjZeAIV+8cJAah/kZ7LTqirnN6PeX\r\npmzyAQKBgForXU0h+ySfHABuru1/vdTPw3kOB/2VndNzmeNe4Ne27rpJw1DmQfjs\r\nqsGVN4Qem2O1HV6ds6m7fDX+GK4t7N+7b/sfmuY76Y4ncrm+SQim0Zv/diw0xi8S\r\nkq1Z7D6XUkJxq2vqkYQMXmDfaYkZS3QXgQa9HUvO6uDhOn5X+zVJ\r\n-----END RSA PRIVATE KEY-----');

-- --------------------------------------------------------

--
-- Estrutura da tabela `desafio_elgamal`
--

CREATE TABLE `desafio_elgamal` (
  `id_del` int(11) NOT NULL,
  `nome` text NOT NULL,
  `id_enviado` int(11) NOT NULL,
  `x_min` int(11) NOT NULL,
  `x_mas` int(255) NOT NULL,
  `y_min` int(255) NOT NULL,
  `y_mas` int(255) NOT NULL,
  `hmac` text NOT NULL,
  `criptograma` text NOT NULL,
  `g` int(255) NOT NULL,
  `p` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `desafio_elgamal`
--

INSERT INTO `desafio_elgamal` (`id_del`, `nome`, `id_enviado`, `x_min`, `x_mas`, `y_min`, `y_mas`, `hmac`, `criptograma`, `g`, `p`) VALUES
(1, 'Novo teste', 22, 21, 31, 3, 19, '369b138fa82ae27830fde20b5bfd91c7a701830cd572348387e63f5610f81bfe', 'mC2+Tes9WurdyARkd0wtlw==', 37, 97);

-- --------------------------------------------------------

--
-- Estrutura da tabela `desafio_ficheiro`
--

CREATE TABLE `desafio_ficheiro` (
  `id_df` int(11) NOT NULL,
  `id_enviado` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `hmac` text NOT NULL,
  `assinatura` text NOT NULL,
  `tipo_cifra` varchar(50) NOT NULL,
  `mensagem_cifrada` text NOT NULL,
  `iv` text NOT NULL,
  `data_envio` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `desafio_hash`
--

CREATE TABLE `desafio_hash` (
  `id_dh` int(11) NOT NULL,
  `id_enviado` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `mensagem` varchar(500) NOT NULL,
  `tipo_cifra` varchar(50) NOT NULL,
  `hash` varchar(500) NOT NULL,
  `data_envio` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `desafio_hash`
--

INSERT INTO `desafio_hash` (`id_dh`, `id_enviado`, `nome`, `mensagem`, `tipo_cifra`, `hash`, `data_envio`) VALUES
(1, 22, 'Novo teste', 'user', 'MD5', '92f993a3d16c374f38588b5906202cf3', '0000-00-00'),
(2, 22, 'Segundp Teste', '', 'SHA256', 'f21d8a4f1f93e8abd047bc92fc4f36be7a1a17da212c3833480466db2f192e6e', '0000-00-00'),
(3, 22, 'Parte 3', '', 'SHA512', '02de593f5210b582763ba9c6e46226c208753bb01135505a5e44fde49883266937dbf89bcd26622a76e434e2021983f7035b33e746a9f4a51182e5ac0819869f', '0000-00-00');

-- --------------------------------------------------------

--
-- Estrutura da tabela `elgamal_param`
--

CREATE TABLE `elgamal_param` (
  `idc` int(11) NOT NULL,
  `G` int(11) NOT NULL,
  `P` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `elgamal_param`
--

INSERT INTO `elgamal_param` (`idc`, `G`, `P`) VALUES
(1, 37, 97);

-- --------------------------------------------------------

--
-- Estrutura da tabela `elgamal_resolvido`
--

CREATE TABLE `elgamal_resolvido` (
  `idt` int(11) NOT NULL,
  `id_del` int(11) NOT NULL,
  `id_participante` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `elgamal_resolvido`
--

INSERT INTO `elgamal_resolvido` (`idt`, `id_del`, `id_participante`) VALUES
(2, 1, 22);

-- --------------------------------------------------------

--
-- Estrutura da tabela `ficheiro_resolvido`
--

CREATE TABLE `ficheiro_resolvido` (
  `id_df` int(11) NOT NULL,
  `id_participante` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `hash_resolvido`
--

CREATE TABLE `hash_resolvido` (
  `id_dh` int(11) NOT NULL,
  `id_participante` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `hash_resolvido`
--

INSERT INTO `hash_resolvido` (`id_dh`, `id_participante`) VALUES
(1, 22);

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE `users` (
  `idu` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(500) NOT NULL,
  `username` varchar(50) NOT NULL,
  `salt` varchar(50) NOT NULL,
  `tipo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`idu`, `email`, `password`, `username`, `salt`, `tipo`) VALUES
(19, 'user@gmail.com', '66be18b669ad7f7247ea288d1d08f163aa8937ff53cd0493271017ce2348ac59c29a20478b29d6dfbb109dc0c072964c6a1c83671b44e4765eb77beadf8d1622fe327591572151cd293aed', 'user', '83dca1f6401ccfdba126fe7bfd2a920a', 0),
(20, 'admin@ubi.pt', 'aeadcd302414f67cf6acd0dcc1f048c030436d62094b5069ae0b749313fb720997ac98ec523c79d4192821c033f88c3d73452158a261a2c9c77c1a61fa39270f3efddb86cef7a6964d5770', 'admin', 'f6b36eac4112194d8646cd9fcad0f112', 1),
(22, 'user2@gmail.com', '803de59b667895c41687f0395d59c5d0c93eddd501a089d5b6503ea824aee7d2669bcdb2e3dbe7eb9db1329242426bf384e77abc0456ae4615a52af6460fdfe4ffdca024a9dd0c86eed8cc', 'user2', '3d5409c6253c78dfdda4aed9de71f176', 0);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `desafio_elgamal`
--
ALTER TABLE `desafio_elgamal`
  ADD PRIMARY KEY (`id_del`);

--
-- Índices para tabela `desafio_ficheiro`
--
ALTER TABLE `desafio_ficheiro`
  ADD PRIMARY KEY (`id_df`),
  ADD KEY `id_enviado` (`id_enviado`);

--
-- Índices para tabela `desafio_hash`
--
ALTER TABLE `desafio_hash`
  ADD PRIMARY KEY (`id_dh`);

--
-- Índices para tabela `elgamal_param`
--
ALTER TABLE `elgamal_param`
  ADD PRIMARY KEY (`idc`);

--
-- Índices para tabela `elgamal_resolvido`
--
ALTER TABLE `elgamal_resolvido`
  ADD PRIMARY KEY (`idt`);

--
-- Índices para tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`idu`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `desafio_elgamal`
--
ALTER TABLE `desafio_elgamal`
  MODIFY `id_del` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `desafio_ficheiro`
--
ALTER TABLE `desafio_ficheiro`
  MODIFY `id_df` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `desafio_hash`
--
ALTER TABLE `desafio_hash`
  MODIFY `id_dh` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `elgamal_param`
--
ALTER TABLE `elgamal_param`
  MODIFY `idc` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `elgamal_resolvido`
--
ALTER TABLE `elgamal_resolvido`
  MODIFY `idt` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `idu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `desafio_ficheiro`
--
ALTER TABLE `desafio_ficheiro`
  ADD CONSTRAINT `desafio_ficheiro_ibfk_1` FOREIGN KEY (`id_enviado`) REFERENCES `users` (`idu`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
