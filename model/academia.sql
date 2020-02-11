-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 20-Dez-2017 às 22:58
-- Versão do servidor: 5.7.14
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `academia`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `academia`
--

CREATE TABLE `academia` (
  `ID_ACADEMIA` int(11) NOT NULL,
  `NOME` varchar(100) NOT NULL,
  `CEP` varchar(8) NOT NULL,
  `LOGRADOURO` varchar(100) NOT NULL,
  `NUMERO` int(9) NOT NULL,
  `COMPLEMENTO` varchar(100) NOT NULL,
  `BAIRRO` varchar(50) NOT NULL,
  `CIDADE` varchar(50) NOT NULL,
  `UF` varchar(2) NOT NULL,
  `STATUS` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `academia`
--

INSERT INTO `academia` (`ID_ACADEMIA`, `NOME`, `CEP`, `LOGRADOURO`, `NUMERO`, `COMPLEMENTO`, `BAIRRO`, `CIDADE`, `UF`, `STATUS`) VALUES
(1, 'BOREFIT', '21531710', 'Rua Wilson', 30, 'BLOCO X', 'Coelho Neto', 'Rio de Janeiro', 'RJ', 1),
(2, 'FITNESS TOP', '21531710', 'Rua Justino de Araujo', 300, '', 'Padre Miguel', 'Rio de Janeiro', 'RJ', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `aluno`
--

CREATE TABLE `aluno` (
  `ID_ALUNO` int(9) NOT NULL,
  `NOME` varchar(100) NOT NULL,
  `DATA_NASC` date NOT NULL,
  `CEP` varchar(8) NOT NULL,
  `LOGRADOURO` varchar(100) NOT NULL,
  `NUMERO` int(11) NOT NULL,
  `COMPLEMENTO` varchar(100) NOT NULL,
  `BAIRRO` varchar(50) NOT NULL,
  `CIDADE` varchar(50) NOT NULL,
  `UF` varchar(2) NOT NULL,
  `DATA_INSCR` date NOT NULL,
  `CPF` varchar(11) NOT NULL,
  `RG` varchar(15) DEFAULT NULL,
  `EMAIL` varchar(250) NOT NULL,
  `CELULAR` varchar(15) NOT NULL,
  `foto` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Estrutura da tabela `aula`
--

CREATE TABLE `aula` (
  `cod_contrato` varchar(200) NOT NULL,
  `seg` int(1) NOT NULL,
  `ter` int(1) NOT NULL,
  `qua` int(1) NOT NULL,
  `qui` int(1) NOT NULL,
  `sex` int(1) NOT NULL,
  `sab` int(1) NOT NULL,
  `horario` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



-- --------------------------------------------------------

--
-- Estrutura da tabela `contrato`
--

CREATE TABLE `contrato` (
  `COD_CONTRATO` varchar(50) NOT NULL,
  `ID_ALUNO` int(9) NOT NULL,
  `ID_ACADEMIA` int(9) NOT NULL,
  `ID_DEPENDENTE` int(9) NOT NULL,
  `ID_SERVICO` int(9) NOT NULL,
  `STATUS` int(1) NOT NULL DEFAULT 0,
  `DATA_VENC` int(11) NOT NULL,
  `ATUALIZACAO` datetime NOT NULL,
  `OBSERVACAO` varchar(250) NOT NULL,
  `ACEITO` int(1) NOT NULL,
  `IP` varchar(30) DEFAULT NULL,
  `DATA_ACEITE` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Estrutura da tabela `dependente`
--

CREATE TABLE `dependente` (
  `id` int(11) NOT NULL,
  `nome` varchar(150) NOT NULL,
  `nascimento` date NOT NULL,
  `inscricao` date DEFAULT NULL,
  `id_aluno` int(11) NOT NULL,
  `foto` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



-- --------------------------------------------------------

--
-- Estrutura da tabela `login`
--

CREATE TABLE `login` (
  `ID` int(9) NOT NULL,
  `CPF` varchar(11) NOT NULL,
  `NOME` varchar(100) NOT NULL,
  `EMAIL` varchar(100) NOT NULL,
  `SENHA` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `login`
--

INSERT INTO `login` (`ID`, `CPF`, `NOME`, `EMAIL`, `SENHA`) VALUES
(1, '11111111111', 'administrador', 'admin@gmail.com', 'admin123');

-- --------------------------------------------------------

--
-- Estrutura da tabela `pagamentos`
--

CREATE TABLE `pagamentos` (
  `ID_PAGAMENTO` int(11) NOT NULL,
  `COD_CONTRATO` varchar(50) NOT NULL,
  `DATA_PAG` date NOT NULL,
  `DATA_VENC` date NOT NULL,
  `STATUS` int(11) NOT NULL,
  `ID_SERVICO` int(11) NOT NULL,
  `VALOR` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `pagamentos`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `servico`
--

CREATE TABLE `servico` (
  `ID_SERVICO` int(9) NOT NULL,
  `TIPO` varchar(50) NOT NULL,
  `DESCRICAO` varchar(250) NOT NULL,
  `VALOR` float NOT NULL,
  `STATUS` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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

--
-- Indexes for dumped tables
--

--
-- Indexes for table `academia`
--
ALTER TABLE `academia`
  ADD PRIMARY KEY (`NOME`),
  ADD UNIQUE KEY `ID_ACADEMIA` (`ID_ACADEMIA`);

--
-- Indexes for table `aluno`
--
ALTER TABLE `aluno`
  ADD PRIMARY KEY (`ID_ALUNO`),
  ADD UNIQUE KEY `CPF` (`CPF`);

--
-- Indexes for table `aula`
--
ALTER TABLE `aula`
  ADD PRIMARY KEY (`cod_contrato`);

--
-- Indexes for table `contrato`
--
ALTER TABLE `contrato`
  ADD PRIMARY KEY (`ID_ALUNO`,`ID_ACADEMIA`,`ID_DEPENDENTE`),
  ADD UNIQUE KEY `COD_CONTRATO` (`COD_CONTRATO`);

--
-- Indexes for table `dependente`
--
ALTER TABLE `dependente`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `CPF` (`CPF`);

--
-- Indexes for table `pagamentos`
--
ALTER TABLE `pagamentos`
  ADD PRIMARY KEY (`COD_CONTRATO`,`DATA_VENC`),
  ADD UNIQUE KEY `ID_PAGAMENTO` (`ID_PAGAMENTO`);

--
-- Indexes for table `servico`
--
ALTER TABLE `servico`
  ADD PRIMARY KEY (`ID_SERVICO`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `academia`
--
ALTER TABLE `academia`
  MODIFY `ID_ACADEMIA` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `aluno`
--
ALTER TABLE `aluno`
  MODIFY `ID_ALUNO` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `dependente`
--
ALTER TABLE `dependente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `ID` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `pagamentos`
--
ALTER TABLE `pagamentos`
  MODIFY `ID_PAGAMENTO` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `servico`
--
ALTER TABLE `servico`
  MODIFY `ID_SERVICO` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;COMMIT;

SET GLOBAL sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));
