-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 22-Ago-2017 às 05:46
-- Versão do servidor: 10.1.22-MariaDB
-- PHP Version: 7.1.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `academia`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `academia`
--

CREATE TABLE IF NOT EXISTS `academia` (
  `ID_ACADEMIA` int(11) NOT NULL AUTO_INCREMENT,
  `NOME` varchar(100) CHARACTER SET latin1 NOT NULL,
  `CEP` varchar(8) CHARACTER SET latin1 NOT NULL,
  `LOGRADOURO` varchar(100) CHARACTER SET latin1 NOT NULL,
  `NUMERO` int(9) NOT NULL,
  `COMPLEMENTO` varchar(100) CHARACTER SET latin1 NOT NULL,
  `BAIRRO` varchar(50) CHARACTER SET latin1 NOT NULL,
  `CIDADE` varchar(50) CHARACTER SET latin1 NOT NULL,
  `UF` varchar(2) CHARACTER SET latin1 NOT NULL,
  `STATUS` int(1) NOT NULL,
  PRIMARY KEY (`NOME`),
  UNIQUE KEY `ID_ACADEMIA` (`ID_ACADEMIA`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `academia`
--

INSERT INTO `academia` (`ID_ACADEMIA`, `NOME`, `CEP`, `LOGRADOURO`, `NUMERO`, `COMPLEMENTO`, `BAIRRO`, `CIDADE`, `UF`, `STATUS`) VALUES
(1, 'BOREFIT', '21531710', 'Rua Wilson', 30, 'BLOCO X', 'Coelho Neto', 'Rio de Janeiro', 'RJ', 1),
(2, 'FITNESS TOP', '21531710', 'Rua Justino de AraÃºjo', 300, '', 'Padre Miguel', 'Rio de Janeiro', 'RJ', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `aluno`
--

CREATE TABLE IF NOT EXISTS `aluno` (
  `ID_ALUNO` int(9) NOT NULL AUTO_INCREMENT,
  `NOME` varchar(100) CHARACTER SET latin1 NOT NULL,
  `DATA_NASC` date NOT NULL,
  `CEP` varchar(8) CHARACTER SET latin1 NOT NULL,
  `LOGRADOURO` varchar(100) CHARACTER SET latin1 NOT NULL,
  `NUMERO` int(11) NOT NULL,
  `COMPLEMENTO` varchar(100) CHARACTER SET latin1 NOT NULL,
  `BAIRRO` varchar(50) CHARACTER SET latin1 NOT NULL,
  `CIDADE` varchar(50) CHARACTER SET latin1 NOT NULL,
  `UF` varchar(2) CHARACTER SET latin1 NOT NULL,
  `DATA_INSCR` date NOT NULL,
  `CPF` varchar(11) CHARACTER SET latin1 NOT NULL,
  `RG` varchar(15) CHARACTER SET latin1 DEFAULT NULL,
  `EMAIL` varchar(250) CHARACTER SET latin1 NOT NULL,
  `CELULAR` varchar(15) CHARACTER SET latin1 NOT NULL,
  `foto` varchar(250) CHARACTER SET latin1 DEFAULT NULL,
  PRIMARY KEY (`ID_ALUNO`),
  UNIQUE KEY `CPF` (`CPF`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `aluno`
--

INSERT INTO `aluno` (`ID_ALUNO`, `NOME`, `DATA_NASC`, `CEP`, `LOGRADOURO`, `NUMERO`, `COMPLEMENTO`, `BAIRRO`, `CIDADE`, `UF`, `DATA_INSCR`, `CPF`, `RG`, `EMAIL`, `CELULAR`, `foto`) VALUES
(1, 'Livia Fialho', '1984-11-08', '21775800', 'Rua Justino de AraÃºjo', 431, 'lote 4', 'Padre Miguel', 'Rio de Janeiro', 'RJ', '2017-03-28', '11425135722', '', 'livia.fialho@gmail.com', '(021) 980807702', '1502511416.png'),
(2, 'dalila marina estafanio', '1959-09-20', '21775800', 'Rua Justino de AraÃºjo', 10, '', 'Padre Miguel', 'Rio de Janeiro', 'RJ', '2016-01-01', '01357261748', '', 'dalila@gmail.com', '21981490783', '1503254660.jpg'),
(4, 'dinho oliveira', '1992-05-03', '21531710', 'Rua Wilson', 10, '', 'Coelho Neto', 'Rio de Janeiro', 'RJ', '2017-04-01', '13570394760', '', 'dinhooliveira.mma@gmail.com', '21981490783', ''),
(5, 'JoÃ£o Victor Teixeira da Silva', '0000-00-00', '21775240', 'Rua Alto D\\\'Ouro', 25, '', 'Padre Miguel', 'Rio de Janeiro', 'RJ', '1321-03-12', '12774021758', '', 'victor.cp2.uerj@gmail.com', '2197408766', ''),
(6, 'gdx', '1992-04-04', '21775240', 'Rua Alto D\\\'Ouro', 10, '', 'Padre Miguel', 'Rio de Janeiro', 'RJ', '1992-01-01', '06886886169', '1213', 'teste@gmail.com', '(212) 121323213', ''),
(7, 'juca', '2017-07-18', '21531710', 'Rua Wilson', 10, 'casa 03', 'Coelho Neto', 'Rio de Janeiro', 'RJ', '2017-07-27', '11410644723', '20321524545', 'oliveiracienciacomputacao@gmail.com', '(212) 112121112', '1500422810.png'),
(8, 'teste', '2017-07-18', '21531710', 'Rua Wilson', 10, '', 'Coelho Neto', 'Rio de Janeiro', 'RJ', '2017-07-18', '35468611082', '', 'juca@gmail.com', '(021) 000000000', 'Erro 4'),
(9, 'adereldo da costa oliveira', '2017-07-18', '21531710', 'Rua Wilson', 10, '', 'Coelho Neto', 'Rio de Janeiro', 'RJ', '2017-07-18', '23438014521', '', 'oliveiracienciacomputacao@gmail.com', '21981490783', 'Erro 4'),
(10, '121', '2017-07-18', '21531710', 'Rua Wilson', 10, '', 'Coelho Neto', 'Rio de Janeiro', 'RJ', '2017-07-18', '10670572500', '321', 'dinhooliveira.mma@gmail.com', '132', '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `aula`
--

CREATE TABLE IF NOT EXISTS `aula` (
  `cod_contrato` varchar(200) CHARACTER SET latin1 NOT NULL,
  `seg` int(1) NOT NULL,
  `ter` int(1) NOT NULL,
  `qua` int(1) NOT NULL,
  `qui` int(1) NOT NULL,
  `sex` int(1) NOT NULL,
  `sab` int(1) NOT NULL,
  `horario` varchar(100) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`cod_contrato`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `aula`
--

INSERT INTO `aula` (`cod_contrato`, `seg`, `ter`, `qua`, `qui`, `sex`, `sab`, `horario`) VALUES
('11142513572228032017', 0, 0, 1, 1, 0, 0, '11:00'),
('20135726174828032017', 1, 0, 1, 1, 0, 0, '18:00'),
('41357039476001042017', 1, 0, 1, 0, 1, 1, '09:00'),
('41357039476004042017', 1, 0, 1, 0, 0, 0, '20:00');

-- --------------------------------------------------------

--
-- Estrutura da tabela `contrato`
--

CREATE TABLE IF NOT EXISTS `contrato` (
  `COD_CONTRATO` varchar(50) CHARACTER SET latin1 NOT NULL,
  `ID_ALUNO` int(9) NOT NULL,
  `ID_ACADEMIA` int(9) NOT NULL,
  `ID_SERVICO` int(9) NOT NULL,
  `STATUS` int(1) NOT NULL,
  `DATA_VENC` int(11) NOT NULL,
  `ATUALIZACAO` datetime NOT NULL,
  `OBSERVACAO` varchar(250) CHARACTER SET latin1 NOT NULL,
  `ACEITO` int(1) NOT NULL,
  `IP` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`ID_ALUNO`,`ID_ACADEMIA`),
  UNIQUE KEY `COD_CONTRATO` (`COD_CONTRATO`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `contrato`
--

INSERT INTO `contrato` (`COD_CONTRATO`, `ID_ALUNO`, `ID_ACADEMIA`, `ID_SERVICO`, `STATUS`, `DATA_VENC`, `ATUALIZACAO`, `OBSERVACAO`, `ACEITO`, `IP`) VALUES
('11142513572228032017', 1, 1, 1, 1, 10, '2017-04-03 22:12:11', 'ver se funcionou', 0, NULL),
('20135726174828032017', 2, 1, 1, 1, 1, '2017-03-28 22:08:36', '', 0, NULL),
('41357039476001042017', 4, 1, 2, 1, 8, '2017-04-03 20:22:27', 'teste', 0, NULL),
('41357039476004042017', 4, 2, 1, 1, 12, '2017-04-04 18:44:43', '', 0, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `login`
--

CREATE TABLE IF NOT EXISTS `login` (
  `ID` int(9) NOT NULL AUTO_INCREMENT,
  `CPF` varchar(11) CHARACTER SET latin1 NOT NULL,
  `NOME` varchar(100) CHARACTER SET latin1 NOT NULL,
  `EMAIL` varchar(100) CHARACTER SET latin1 NOT NULL,
  `SENHA` varchar(100) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `CPF` (`CPF`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `login`
--

INSERT INTO `login` (`ID`, `CPF`, `NOME`, `EMAIL`, `SENHA`) VALUES
(1, '14416962703', 'Andre Felipe da Silva Feitosa', 'andrefelipe131@gmail.com', 'boxdigital');

-- --------------------------------------------------------

--
-- Estrutura da tabela `pagamentos`
--

CREATE TABLE IF NOT EXISTS `pagamentos` (
  `ID_PAGAMENTO` int(11) NOT NULL AUTO_INCREMENT,
  `COD_CONTRATO` varchar(50) CHARACTER SET latin1 NOT NULL,
  `DATA_PAG` date NOT NULL,
  `DATA_VENC` date NOT NULL,
  `STATUS` int(11) NOT NULL,
  `ID_SERVICO` int(11) NOT NULL,
  `VALOR` float NOT NULL,
  PRIMARY KEY (`COD_CONTRATO`,`DATA_VENC`),
  UNIQUE KEY `ID_PAGAMENTO` (`ID_PAGAMENTO`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `pagamentos`
--

INSERT INTO `pagamentos` (`ID_PAGAMENTO`, `COD_CONTRATO`, `DATA_PAG`, `DATA_VENC`, `STATUS`, `ID_SERVICO`, `VALOR`) VALUES
(1, '11142513572228032017', '2017-03-28', '2017-05-01', 1, 3, 140),
(5, '11142513572228032017', '2017-03-28', '2017-08-10', 1, 9, 160),
(13, '11142513572228032017', '2017-04-03', '2017-09-10', 1, 1, 80),
(7, '20135726174828032017', '2017-03-28', '2017-03-28', 1, 1, 80),
(8, '31357039476001042017', '2017-04-01', '2017-05-01', 1, 1, 80),
(9, '41357039476001042017', '2017-04-01', '2017-07-08', 1, 6, 128),
(14, '41357039476004042017', '2017-04-04', '2017-05-12', 1, 1, 80);

-- --------------------------------------------------------

--
-- Estrutura da tabela `servico`
--

CREATE TABLE IF NOT EXISTS `servico` (
  `ID_SERVICO` int(9) NOT NULL AUTO_INCREMENT,
  `TIPO` varchar(50) NOT NULL,
  `DESCRICAO` varchar(250) NOT NULL,
  `VALOR` float NOT NULL,
  `STATUS` int(11) NOT NULL,
  PRIMARY KEY (`ID_SERVICO`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `servico`
--

INSERT INTO `servico` (`ID_SERVICO`, `TIPO`, `DESCRICAO`, `VALOR`, `STATUS`) VALUES
(1, 'MENSAL', 'FUNCIONAL 2X', 80, 1),
(2, 'MENSAL', 'FUNCIONAL 3X', 100, 1),
(3, 'MENSAL', 'FUNCIONAL 5X', 140, 1),
(5, 'TRIMESTRAL', 'FUNCIONAL 2X + MUSCULAÇÃO', 112, 1),
(6, 'TRIMESTRAL', 'FUNCIONAL 3X + MUSCULAÇÃO', 128, 1),
(9, 'TRIMESTRAL', 'FUNCIONAL 5X + MUSCULAÇÃO', 160, 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
