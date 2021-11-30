-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 30-Nov-2021 às 11:29
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
-- Banco de dados: `estoquebbconfort`
--
CREATE DATABASE IF NOT EXISTS `estoquebbconfort` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `estoquebbconfort`;

DELIMITER $$
--
-- Procedimentos
--
DROP PROCEDURE IF EXISTS `Atualiza_estoque`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `Atualiza_estoque` (IN `id_produto` INT, IN `quantidade` INT)  NO SQL
BEGIN
declare contador int(11);

SELECT COUNT(*) INTO contador FROM estoque WHERE id_prod=id_produto;

IF contador > 0 THEN
	UPDATE estoque SET saldo_Anterior=saldo_Atual,saldo_Atual=saldo_Atual+quantidade WHERE id_prod=id_produto;
    ELSE
    INSERT INTO estoque (id_prod,saldo_Anterior,saldo_Atual) VALUES (id_produto,0,quantidade);
    END IF;
    END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `caixa`
--

DROP TABLE IF EXISTS `caixa`;
CREATE TABLE `caixa` (
  `id_caixa` int(11) NOT NULL,
  `caixa` varchar(45) DEFAULT NULL,
  `abertura` date NOT NULL,
  `fechamento` date DEFAULT NULL,
  `status` int(11) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `caixa`
--

INSERT INTO `caixa` (`id_caixa`, `caixa`, `abertura`, `fechamento`, `status`, `createdAt`) VALUES
(30, '17', '2021-11-30', NULL, 0, '2021-11-30 09:24:24');

--
-- Acionadores `caixa`
--
DROP TRIGGER IF EXISTS `Trigger_caixa_update`;
DELIMITER $$
CREATE TRIGGER `Trigger_caixa_update` AFTER UPDATE ON `caixa` FOR EACH ROW BEGIN
IF (new.status<>0) THEN
UPDATE vendas SET status=0 where caixa=new.id_caixa; 
END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `categoria`
--

DROP TABLE IF EXISTS `categoria`;
CREATE TABLE `categoria` (
  `id_cat` int(11) NOT NULL,
  `categoria` varchar(45) NOT NULL,
  `status` varchar(11) NOT NULL,
  `imagem` text NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `categoria`
--

INSERT INTO `categoria` (`id_cat`, `categoria`, `status`, `imagem`, `createdAt`) VALUES
(16, 'BICO 01', 'true', '4e8be590d398dfb1f980789d18d06559.png', '2021-11-30 09:14:27'),
(17, 'BICO 02', 'true', '51c06f02e358fcf031091d4f13b40098.png', '2021-11-30 09:14:51'),
(18, 'BICO 03', 'true', 'ff2b2017c25c1180e7fe677ee6221e2a.png', '2021-11-30 09:15:06');

-- --------------------------------------------------------

--
-- Estrutura da tabela `cliente`
--

DROP TABLE IF EXISTS `cliente`;
CREATE TABLE `cliente` (
  `id_cliente` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `endereco` text NOT NULL,
  `telefone` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `credito` decimal(7,2) NOT NULL,
  `created_At` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `cliente`
--

INSERT INTO `cliente` (`id_cliente`, `nome`, `endereco`, `telefone`, `email`, `status`, `credito`, `created_At`) VALUES
(4, 'Mauricio ', 'centro', '(75) 99287-2929', 'macedo.mauricio@gmail.com', 1, '0.00', '2021-11-30 06:13:19');

-- --------------------------------------------------------

--
-- Estrutura da tabela `consumo`
--

DROP TABLE IF EXISTS `consumo`;
CREATE TABLE `consumo` (
  `id_consumo` int(11) NOT NULL,
  `id_caixa` int(11) NOT NULL,
  `valor` decimal(7,2) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `data` date NOT NULL,
  `produto` int(11) NOT NULL,
  `createdAt` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `consumo`
--

INSERT INTO `consumo` (`id_consumo`, `id_caixa`, `valor`, `quantidade`, `data`, `produto`, `createdAt`) VALUES
(117, 30, '116.00', 20, '2021-11-30', 6, '2021-11-30 07:05:17');

--
-- Acionadores `consumo`
--
DROP TRIGGER IF EXISTS `Trigger_consumo_delete`;
DELIMITER $$
CREATE TRIGGER `Trigger_consumo_delete` AFTER DELETE ON `consumo` FOR EACH ROW CALL Atualiza_estoque(old.produto,old.quantidade)
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `Trigger_cosumo_insert`;
DELIMITER $$
CREATE TRIGGER `Trigger_cosumo_insert` AFTER INSERT ON `consumo` FOR EACH ROW CALL Atualiza_estoque(new.produto,new.quantidade * (-1))
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `Trigger_cosumo_update`;
DELIMITER $$
CREATE TRIGGER `Trigger_cosumo_update` AFTER UPDATE ON `consumo` FOR EACH ROW CALL Atualiza_estoque(new.produto,old.quantidade - new.quantidade)
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `entrada_estoque`
--

DROP TABLE IF EXISTS `entrada_estoque`;
CREATE TABLE `entrada_estoque` (
  `id_entra` int(11) NOT NULL,
  `id_prod` int(11) NOT NULL,
  `data` date NOT NULL,
  `quantidade` int(11) NOT NULL,
  `createdAt` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `entrada_estoque`
--

INSERT INTO `entrada_estoque` (`id_entra`, `id_prod`, `data`, `quantidade`, `createdAt`) VALUES
(13, 9, '2021-11-30', 1000, '2021-11-30 07:14:10');

--
-- Acionadores `entrada_estoque`
--
DROP TRIGGER IF EXISTS `Trigger_delete`;
DELIMITER $$
CREATE TRIGGER `Trigger_delete` AFTER DELETE ON `entrada_estoque` FOR EACH ROW CALL Atualiza_estoque(old.id_prod,old.quantidade)
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `Trigger_insert`;
DELIMITER $$
CREATE TRIGGER `Trigger_insert` AFTER INSERT ON `entrada_estoque` FOR EACH ROW CALL Atualiza_estoque(new.id_prod,new.quantidade)
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `Trigger_update`;
DELIMITER $$
CREATE TRIGGER `Trigger_update` AFTER UPDATE ON `entrada_estoque` FOR EACH ROW CALL Atualiza_estoque(new.id_prod,new.quantidade-old.quantidade)
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `estoque`
--

DROP TABLE IF EXISTS `estoque`;
CREATE TABLE `estoque` (
  `id_est` int(11) NOT NULL,
  `id_prod` int(11) NOT NULL,
  `saldo_Atual` int(11) NOT NULL,
  `saldo_Anterior` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `estoque`
--

INSERT INTO `estoque` (`id_est`, `id_prod`, `saldo_Atual`, `saldo_Anterior`) VALUES
(6, 6, 180, 200),
(7, 7, 200, 0),
(8, 8, 200, 0),
(9, 9, 1200, 200);

-- --------------------------------------------------------

--
-- Estrutura da tabela `historicocategoria`
--

DROP TABLE IF EXISTS `historicocategoria`;
CREATE TABLE `historicocategoria` (
  `codigo` int(11) NOT NULL,
  `Fechamento` int(11) NOT NULL,
  `codigoCategoria` int(11) NOT NULL,
  `data` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `pagamento`
--

DROP TABLE IF EXISTS `pagamento`;
CREATE TABLE `pagamento` (
  `id_pagamento` int(11) NOT NULL,
  `valor` decimal(7,2) NOT NULL,
  `tipo` varchar(40) NOT NULL,
  `status` int(11) NOT NULL,
  `id_caixa` int(11) NOT NULL,
  `created_at` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `pagamento`
--

INSERT INTO `pagamento` (`id_pagamento`, `valor`, `tipo`, `status`, `id_caixa`, `created_at`) VALUES
(82, '100.00', 'Carteira', 0, 30, '2021-11-30'),
(83, '16.00', 'Carteira', 0, 30, '2021-11-30');

-- --------------------------------------------------------

--
-- Estrutura da tabela `produto`
--

DROP TABLE IF EXISTS `produto`;
CREATE TABLE `produto` (
  `id_prod` int(11) NOT NULL,
  `descricao` varchar(45) NOT NULL,
  `fornecedor` varchar(200) NOT NULL,
  `status` varchar(5) NOT NULL,
  `precoVenda` decimal(7,2) NOT NULL,
  `precoCompra` decimal(7,2) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `categoria` int(11) NOT NULL,
  `imagem` text NOT NULL,
  `createdAt` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `produto`
--

INSERT INTO `produto` (`id_prod`, `descricao`, `fornecedor`, `status`, `precoVenda`, `precoCompra`, `quantidade`, `categoria`, `imagem`, `createdAt`) VALUES
(6, 'Gasolina Comum', 'Brasil', 'true', '5.80', '4.30', 200, 16, '464ee2a61d7d36b61c64265eaf297be3.png', '2021-11-30 06:16:18'),
(7, 'Gasolina ADITIVADA', 'Brasil', 'true', '5.80', '4.30', 200, 17, 'bd4a3c7ec9cceb0e14f2713a7ba59d80.png', '2021-11-30 06:16:34'),
(8, 'Alcool', 'Brasil', 'true', '5.80', '4.30', 200, 18, '656c78b640fd1d3047584bba0a1ad0c5.png', '2021-11-30 06:16:45'),
(9, 'Gasolina Comum', 'Brasil', 'true', '5.00', '4.00', 200, 16, '1f92c79ffcab485c8fd3493825032c9e.png', '2021-11-30 06:17:14');

--
-- Acionadores `produto`
--
DROP TRIGGER IF EXISTS `Trigger_produto_insert`;
DELIMITER $$
CREATE TRIGGER `Trigger_produto_insert` AFTER INSERT ON `produto` FOR EACH ROW CALL Atualiza_estoque(new.id_prod,new.quantidade)
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `saida`
--

DROP TABLE IF EXISTS `saida`;
CREATE TABLE `saida` (
  `id_saida` int(11) NOT NULL,
  `descricao` varchar(60) NOT NULL,
  `valor` int(11) NOT NULL,
  `data` date NOT NULL DEFAULT current_timestamp(),
  `observacao` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `created_at` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `saida_estoque`
--

DROP TABLE IF EXISTS `saida_estoque`;
CREATE TABLE `saida_estoque` (
  `id_saida` int(11) NOT NULL,
  `cliente` varchar(100) NOT NULL,
  `id_pag` int(11) NOT NULL,
  `data` date NOT NULL,
  `id_prod` int(11) NOT NULL,
  `quantidade` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios` (
  `id_user` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `nome` varchar(45) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `acesso` varchar(10) NOT NULL,
  `createdAt` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id_user`, `email`, `nome`, `senha`, `acesso`, `createdAt`) VALUES
(1, 'macedo@hotmail.com', 'Mauricio Macedo', 'ed3831389108737760f657d1087b8569', 'admin', '2021-04-11 10:44:31'),
(4, 'macedos@hotmail.com', 'Mauricio Macedo', '202cb962ac59075b964b07152d234b70', 'admin', '2021-04-11 10:44:31'),
(5, 'mauricio@hotmail.com', 'mauricio ', '81dc9bdb52d04dc20036dbd8313ed055', 'admin', '2021-04-11 10:44:31'),
(6, 'macedo@pitstop', 'mauricio', '202cb962ac59075b964b07152d234b70', 'admin', '2021-11-28 09:59:32');

-- --------------------------------------------------------

--
-- Estrutura da tabela `vendas`
--

DROP TABLE IF EXISTS `vendas`;
CREATE TABLE `vendas` (
  `id_venda` int(11) NOT NULL,
  `nome` varchar(45) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `caixa` int(11) DEFAULT NULL,
  `cliente` int(11) NOT NULL DEFAULT 1,
  `createdAt` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `vendas`
--

INSERT INTO `vendas` (`id_venda`, `nome`, `status`, `caixa`, `cliente`, `createdAt`) VALUES
(17, 'Caixa 01', 1, 30, 4, '2021-11-30');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `caixa`
--
ALTER TABLE `caixa`
  ADD PRIMARY KEY (`id_caixa`);

--
-- Índices para tabela `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id_cat`);

--
-- Índices para tabela `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`id_cliente`);

--
-- Índices para tabela `consumo`
--
ALTER TABLE `consumo`
  ADD PRIMARY KEY (`id_consumo`),
  ADD KEY `caixa` (`id_caixa`),
  ADD KEY `produto` (`produto`);

--
-- Índices para tabela `entrada_estoque`
--
ALTER TABLE `entrada_estoque`
  ADD PRIMARY KEY (`id_entra`);

--
-- Índices para tabela `estoque`
--
ALTER TABLE `estoque`
  ADD PRIMARY KEY (`id_est`);

--
-- Índices para tabela `historicocategoria`
--
ALTER TABLE `historicocategoria`
  ADD PRIMARY KEY (`codigo`);

--
-- Índices para tabela `pagamento`
--
ALTER TABLE `pagamento`
  ADD PRIMARY KEY (`id_pagamento`);

--
-- Índices para tabela `produto`
--
ALTER TABLE `produto`
  ADD PRIMARY KEY (`id_prod`);

--
-- Índices para tabela `saida`
--
ALTER TABLE `saida`
  ADD PRIMARY KEY (`id_saida`);

--
-- Índices para tabela `saida_estoque`
--
ALTER TABLE `saida_estoque`
  ADD PRIMARY KEY (`id_saida`);

--
-- Índices para tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_user`);

--
-- Índices para tabela `vendas`
--
ALTER TABLE `vendas`
  ADD PRIMARY KEY (`id_venda`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `caixa`
--
ALTER TABLE `caixa`
  MODIFY `id_caixa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de tabela `categoria`
--
ALTER TABLE `categoria`
  MODIFY `id_cat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de tabela `cliente`
--
ALTER TABLE `cliente`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `consumo`
--
ALTER TABLE `consumo`
  MODIFY `id_consumo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=118;

--
-- AUTO_INCREMENT de tabela `entrada_estoque`
--
ALTER TABLE `entrada_estoque`
  MODIFY `id_entra` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de tabela `estoque`
--
ALTER TABLE `estoque`
  MODIFY `id_est` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `historicocategoria`
--
ALTER TABLE `historicocategoria`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `pagamento`
--
ALTER TABLE `pagamento`
  MODIFY `id_pagamento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT de tabela `produto`
--
ALTER TABLE `produto`
  MODIFY `id_prod` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `saida`
--
ALTER TABLE `saida`
  MODIFY `id_saida` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `saida_estoque`
--
ALTER TABLE `saida_estoque`
  MODIFY `id_saida` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `vendas`
--
ALTER TABLE `vendas`
  MODIFY `id_venda` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `consumo`
--
ALTER TABLE `consumo`
  ADD CONSTRAINT `caixa` FOREIGN KEY (`id_caixa`) REFERENCES `caixa` (`id_caixa`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `produto` FOREIGN KEY (`produto`) REFERENCES `produto` (`id_prod`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
