-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 13-Abr-2021 às 14:09
-- Versão do servidor: 10.4.11-MariaDB
-- versão do PHP: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `estoque`
--

DELIMITER $$
--
-- Procedimentos
--
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
-- Estrutura da tabela `Vendas`
--

CREATE TABLE `Vendas` (
  `id_apt` int(11) NOT NULL,
  `nome` varchar(45) NOT NULL,
  `status` int(11) NOT NULL,
  `caixa` int(11) DEFAULT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `Vendas`
--

INSERT INTO `Vendas` (`id_apt`, `nome`, `status`, `caixa`, `createdAt`) VALUES
(1, 'APT 01', 1, 15, '2021-04-11 13:40:25'),
(2, 'APT 02', 0, 12, '2021-04-11 13:40:25'),
(3, 'APT 03', 0, NULL, '2021-04-11 13:40:25'),
(4, 'APT 04', 0, NULL, '2021-04-11 13:40:25');

-- --------------------------------------------------------

--
-- Estrutura da tabela `caixa`
--

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
(4, 'APT 01', '2021-03-09', NULL, 1, '2021-04-11 13:39:50'),
(8, 'APT 02', '2021-03-10', NULL, 1, '2021-04-11 13:39:50'),
(9, 'APT 02', '2021-03-10', NULL, 1, '2021-04-11 13:39:50'),
(10, 'APT 01', '2021-03-10', NULL, 1, '2021-04-11 13:39:50'),
(11, 'APT 02', '2021-03-10', NULL, 1, '2021-04-11 13:39:50'),
(12, 'APT 02', '2021-03-19', '2021-04-11', 1, '2021-04-11 13:39:50'),
(13, 'APT 01', '2021-03-22', '2021-03-30', 1, '2021-04-11 13:39:50'),
(14, 'APT 01', '2021-04-11', '2021-04-13', 1, '2021-04-11 13:39:50'),
(15, 'APT 01', '2021-04-13', NULL, 0, '2021-04-13 11:58:58');

--
-- Acionadores `caixa`
--
DELIMITER $$
CREATE TRIGGER `Trigger_caixa_update` AFTER UPDATE ON `caixa` FOR EACH ROW BEGIN
IF (new.status<>0) THEN
UPDATE Vendas SET status=0 where caixa=new.id_caixa; 
END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `categoria`
--

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
(1, 'teste', 'true', 'a04110cfebdabdf1a646836a49e3b177.png', '2021-04-11 13:40:57'),
(2, 'teste', 'true', '44b2217c7a427325f2ca2f175580f375.png', '2021-04-11 13:40:57'),
(3, 'Bebidas', 'true', '55fa6d68d6e22c1e1e7561c4c78925f9.png', '2021-04-11 13:40:57'),
(4, 'drinks', 'true', '0087bb618e6408228aa2edaf5b4c6960.png', '2021-04-11 13:40:57'),
(5, 'Salgados', 'true', '561cdadf88f53f9b7baa283e9a4c3d2b.jpg', '2021-04-11 13:40:57'),
(6, 'Cervejas', 'true', '529f952237e721591a314c50b6eca218.png', '2021-04-11 13:40:57'),
(7, 'Refrigerante', 'true', '7df446fefcf3e21aa9102c464c65335b.png', '2021-04-11 13:40:57'),
(8, 'Refrigerante lata', 'true', 'bd6c2ae905b0dddf36c1e00abb5dc212.png', '2021-04-11 13:40:57'),
(9, 'Cerveja Litrinho', 'true', '7a7ba68796ed7e7838374dcc2d5f3216.png', '2021-04-11 13:40:57'),
(10, 'Petiscos', 'true', 'a827e166c6e607f160fef94e726ce639.png', '2021-04-11 13:40:57'),
(11, 'Bolos', 'true', '', '2021-04-11 13:40:57'),
(12, 'Doces', 'true', 'c03d3dcb0f145396e74680913c197a2b.png', '2021-04-11 13:40:57'),
(13, 'testeaas', 'true', '058485d07d584eab703df85ccdd4debd.png', '2021-04-11 13:40:57'),
(14, 'pizza', 'true', '1bb7a6fbb1703b7f48364e3b15dc85a3.jpg', '2021-04-11 13:40:57');

-- --------------------------------------------------------

--
-- Estrutura da tabela `consumo`
--

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
(4, 4, '20.00', 1, '2021-03-09', 1, '2021-04-11 10:42:21'),
(6, 4, '20.00', 1, '2021-03-09', 2, '2021-04-11 10:42:21'),
(7, 4, '20.00', 10, '2021-03-09', 1, '2021-04-11 10:42:21'),
(8, 8, '20.00', 20, '2021-03-10', 1, '2021-04-11 10:42:21'),
(10, 8, '5.50', 1, '2021-03-10', 2, '2021-04-11 10:42:21'),
(11, 8, '34.00', 2, '2021-03-10', 3, '2021-04-11 10:42:21'),
(12, 8, '5.00', 1, '2021-03-10', 2, '2021-04-11 10:42:21'),
(16, 11, '4.50', 1, '2021-03-10', 2, '2021-04-11 10:42:21'),
(17, 11, '5.00', 1, '2021-03-10', 1, '2021-04-11 10:42:21'),
(18, 11, '34.00', 2, '2021-03-10', 3, '2021-04-11 10:42:21'),
(20, 10, '5.00', 1, '2021-03-11', 1, '2021-04-11 10:42:21'),
(22, 10, '5.00', 1, '2021-03-11', 1, '2021-04-11 10:42:21'),
(23, 10, '5.00', 1, '2021-03-14', 1, '2021-04-11 10:42:21'),
(28, 12, '5.00', 1, '2021-03-19', 1, '2021-04-11 10:42:21'),
(29, 12, '4.50', 1, '2021-03-19', 2, '2021-04-11 10:42:21'),
(30, 12, '17.00', 1, '2021-03-19', 3, '2021-04-11 10:42:21'),
(31, 13, '5.00', 1, '2021-03-22', 4, '2021-04-11 10:42:21'),
(32, 13, '5.00', 1, '2021-03-30', 4, '2021-04-11 10:42:21'),
(33, 13, '4.50', 1, '2021-03-30', 2, '2021-04-11 10:42:21'),
(34, 13, '5.00', 1, '2021-03-30', 1, '2021-04-11 10:42:21'),
(35, 14, '4.50', 1, '2021-04-11', 2, '2021-04-11 10:42:21'),
(36, 14, '50.00', 10, '2021-04-13', 4, '2021-04-13 08:58:03'),
(37, 15, '5.00', 1, '2021-04-13', 4, '2021-04-13 08:59:05');

--
-- Acionadores `consumo`
--
DELIMITER $$
CREATE TRIGGER `Trigger_consumo_delete` AFTER DELETE ON `consumo` FOR EACH ROW CALL Atualiza_estoque(old.produto,old.quantidade)
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `Trigger_cosumo_insert` AFTER INSERT ON `consumo` FOR EACH ROW CALL Atualiza_estoque(new.produto,new.quantidade * (-1))
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `Trigger_cosumo_update` AFTER UPDATE ON `consumo` FOR EACH ROW CALL Atualiza_estoque(new.produto,old.quantidade - new.quantidade)
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `entrada_estoque`
--

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
(1, 4, '2021-03-14', 100, '2021-04-11 10:43:13'),
(2, 2, '2021-03-09', 10, '2021-04-11 10:43:13'),
(4, 2, '2021-03-10', 100, '2021-04-11 10:43:13'),
(5, 3, '2021-03-10', 10, '2021-04-11 10:43:13'),
(6, 1, '2021-03-10', 20, '2021-04-11 10:43:13'),
(7, 3, '2021-03-10', 10, '2021-04-11 10:43:13'),
(8, 2, '2021-03-10', 15, '2021-04-11 10:43:13'),
(9, 2, '2021-03-10', 15, '2021-04-11 10:43:13'),
(10, 4, '2021-03-19', 200, '2021-04-11 10:43:13');

--
-- Acionadores `entrada_estoque`
--
DELIMITER $$
CREATE TRIGGER `Trigger_delete` AFTER DELETE ON `entrada_estoque` FOR EACH ROW CALL Atualiza_estoque(old.id_prod,old.quantidade)
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `Trigger_insert` AFTER INSERT ON `entrada_estoque` FOR EACH ROW CALL Atualiza_estoque(new.id_prod,new.quantidade)
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `Trigger_update` AFTER UPDATE ON `entrada_estoque` FOR EACH ROW CALL Atualiza_estoque(new.id_prod,new.quantidade-old.quantidade)
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `estoque`
--

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
(1, 1, 191, 192),
(2, 2, 134, 135),
(3, 3, 13, 14),
(4, 4, 92, 93);

-- --------------------------------------------------------

--
-- Estrutura da tabela `produto`
--

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
(1, 'Coca-Cola', 'Coca-Cola', 'true', '5.00', '2.50', 3, 8, 'f4b627c3b101a6ebf61376abb14e0a22.png', '2021-04-11 10:43:58'),
(2, 'Fanta', 'Coca-Cola', 'true', '4.50', '2.50', 5, 8, '31007d0827415e3a8bdaaa7b7e54536f.png', '2021-04-11 10:43:58'),
(3, 'Petiscos', 'eua', 'true', '17.00', '15.00', 1, 10, 'c918df695b0c08974acf3f61b2a24ab4.png', '2021-04-11 10:43:58'),
(4, 'Cerveja Litrinho', 'Skol', 'true', '5.00', '0.00', 5, 9, '8e2eecffe857b16a2aadcae5c5d46def.png', '2021-04-11 10:43:58');

--
-- Acionadores `produto`
--
DELIMITER $$
CREATE TRIGGER `Trigger_produto_insert` AFTER INSERT ON `produto` FOR EACH ROW CALL Atualiza_estoque(new.id_prod,new.quantidade)
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `saida_estoque`
--

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
(5, 'mauricio@hotmail.com', 'mauricio ', '81dc9bdb52d04dc20036dbd8313ed055', 'admin', '2021-04-11 10:44:31');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `Vendas`
--
ALTER TABLE `Vendas`
  ADD PRIMARY KEY (`id_apt`);

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
-- Índices para tabela `produto`
--
ALTER TABLE `produto`
  ADD PRIMARY KEY (`id_prod`);

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
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `Vendas`
--
ALTER TABLE `Vendas`
  MODIFY `id_apt` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `caixa`
--
ALTER TABLE `caixa`
  MODIFY `id_caixa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de tabela `categoria`
--
ALTER TABLE `categoria`
  MODIFY `id_cat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de tabela `consumo`
--
ALTER TABLE `consumo`
  MODIFY `id_consumo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT de tabela `entrada_estoque`
--
ALTER TABLE `entrada_estoque`
  MODIFY `id_entra` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `estoque`
--
ALTER TABLE `estoque`
  MODIFY `id_est` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `produto`
--
ALTER TABLE `produto`
  MODIFY `id_prod` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `saida_estoque`
--
ALTER TABLE `saida_estoque`
  MODIFY `id_saida` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
