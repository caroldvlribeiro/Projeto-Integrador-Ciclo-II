-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 26/05/2026 às 06:00
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


CREATE DATABASE marmoraria_db;

USE marmoraria_db;
--
-- Banco de dados: `marmoraria_db`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `agenda`
--

CREATE TABLE `agenda` (
  `id_agenda` int(11) NOT NULL,
  `id_orcamento` int(11) DEFAULT NULL,
  `cd_cliente` int(11) DEFAULT NULL,
  `dt_compromisso` date NOT NULL DEFAULT curdate(),
  `hr_compromisso` time NOT NULL,
  `ds_compromisso` varchar(255) NOT NULL,
  `st_compromisso` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `categoria_produto`
--

CREATE TABLE `categoria_produto` (
  `id_categoria` int(11) NOT NULL,
  `nm_categoria` varchar(50) NOT NULL,
  `ds_categoria` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `categoria_produto`
--

INSERT INTO `categoria_produto` (`id_categoria`, `nm_categoria`, `ds_categoria`) VALUES
(1, 'Ferramentas', 'Ferramentas utilizadas no corte e acabamento do mármore'),
(2, 'Insumos de acabamento', 'Materiais utilizados no acabamento das peças'),
(3, 'Fixação e instalação.', 'Materiais usados na instalação das pedras!'),
(4, 'Consumíveis de produção', 'Materiais consumidos durante o processo produtivo'),
(5, 'Cubas', 'Cubas de Inox e Porcelana');

-- --------------------------------------------------------

--
-- Estrutura para tabela `cliente`
--

CREATE TABLE `cliente` (
  `cd_cliente` int(11) NOT NULL,
  `nm_cliente` varchar(255) NOT NULL,
  `cd_telefone` varchar(20) DEFAULT NULL,
  `nm_endereco` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `cliente`
--

INSERT INTO `cliente` (`cd_cliente`, `nm_cliente`, `cd_telefone`, `nm_endereco`) VALUES
(15, 'Ana Julia', '13998069688', 'ddfsff'),
(36, 'Ana Maria', '13998069689', 'rua maria isabel n255'),
(37, 'Maria', '13998069687', 'rua maria isabel n255'),
(38, 'Maria', '13998069685', 'rua maria isabel n255');

-- --------------------------------------------------------

--
-- Estrutura para tabela `estoque`
--

CREATE TABLE `estoque` (
  `id_estoque` int(11) NOT NULL,
  `id_produto` int(11) NOT NULL,
  `qt_estoque` int(11) NOT NULL,
  `dt_atualizacao` date NOT NULL DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `estoque`
--

INSERT INTO `estoque` (`id_estoque`, `id_produto`, `qt_estoque`, `dt_atualizacao`) VALUES
(1, 1, 12, '2026-05-23'),
(2, 2, 15, '2026-04-10'),
(3, 3, 8, '2026-04-10'),
(4, 4, 12, '2026-04-10'),
(5, 5, 20, '2026-04-10'),
(6, 6, 50, '2026-04-10'),
(7, 7, 25, '2026-04-10'),
(8, 8, 18, '2026-04-10'),
(9, 9, 10, '2026-05-02'),
(10, 16, 4, '2026-05-23');

-- --------------------------------------------------------

--
-- Estrutura para tabela `movimentacao_estoque`
--

CREATE TABLE `movimentacao_estoque` (
  `id_movimentacao` int(11) NOT NULL,
  `id_produto` int(11) NOT NULL,
  `qt_movimentacao` int(11) NOT NULL,
  `dt_movimentacao` date NOT NULL DEFAULT curdate(),
  `tp_movimentacao` enum('Entrada','Saída') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `movimentacao_estoque`
--

INSERT INTO `movimentacao_estoque` (`id_movimentacao`, `id_produto`, `qt_movimentacao`, `dt_movimentacao`, `tp_movimentacao`) VALUES
(1, 1, 10, '2026-04-10', 'Entrada'),
(2, 2, 15, '2026-04-10', 'Entrada'),
(3, 3, 8, '2026-04-10', 'Entrada'),
(4, 4, 12, '2026-04-10', 'Entrada'),
(5, 5, 20, '2026-04-10', 'Entrada'),
(6, 6, 50, '2026-04-10', 'Entrada'),
(7, 7, 25, '2026-04-10', 'Entrada'),
(8, 8, 18, '2026-04-10', 'Entrada'),
(9, 1, 5, '2026-04-10', 'Entrada'),
(10, 1, 3, '2026-04-10', 'Saída'),
(11, 1, 3, '2026-04-10', 'Saída'),
(12, 9, 10, '2026-05-02', ''),
(13, 1, 1, '2026-05-23', 'Entrada'),
(14, 1, 1, '2026-05-23', 'Entrada'),
(15, 1, 1, '2026-05-23', 'Entrada'),
(16, 1, 2, '2026-05-23', 'Saída'),
(17, 1, 2, '2026-05-23', 'Entrada'),
(18, 17, 3, '2026-05-23', 'Entrada'),
(19, 16, 4, '2026-05-23', 'Entrada');

--
-- Acionadores `movimentacao_estoque`
--
DELIMITER $$
CREATE TRIGGER `atualizar_estoque` AFTER INSERT ON `movimentacao_estoque` FOR EACH ROW BEGIN

    IF NEW.tp_movimentacao = 'Entrada' THEN

        IF EXISTS (
            SELECT 1
            FROM estoque
            WHERE id_produto = NEW.id_produto
        ) THEN

            UPDATE estoque
            SET 
                qt_estoque = qt_estoque + NEW.qt_movimentacao,
                dt_atualizacao = NOW()
            WHERE id_produto = NEW.id_produto;

        ELSE

            INSERT INTO estoque
            (
                id_produto,
                qt_estoque,
                dt_atualizacao
            )
            VALUES
            (
                NEW.id_produto,
                NEW.qt_movimentacao,
                NOW()
            );

        END IF;

    ELSEIF NEW.tp_movimentacao = 'Saída' THEN

        UPDATE estoque
        SET 
            qt_estoque = qt_estoque - NEW.qt_movimentacao,
            dt_atualizacao = NOW()
        WHERE id_produto = NEW.id_produto;

    END IF;

END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `orcamento`
--

CREATE TABLE `orcamento` (
  `id_orcamento` int(11) NOT NULL,
  `cd_cliente` int(11) NOT NULL,
  `dt_pedido` date NOT NULL DEFAULT curdate(),
  `vl_total` decimal(10,2) NOT NULL,
  `ds_descricao` text NOT NULL,
  `acabamento` varchar(30) NOT NULL,
  `id_pedra` int(11) NOT NULL,
  `nm_cuba` varchar(30) DEFAULT NULL,
  `vista` varchar(30) DEFAULT NULL,
  `saia` varchar(30) DEFAULT NULL,
  `dt_entrega` date DEFAULT NULL,
  `st_orcamento` enum('Aberto','Aprovado','Cancelado','Finalizado') NOT NULL DEFAULT 'Aberto'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `orcamento`
--

INSERT INTO `orcamento` (`id_orcamento`, `cd_cliente`, `dt_pedido`, `vl_total`, `ds_descricao`, `acabamento`, `id_pedra`, `nm_cuba`, `vista`, `saia`, `dt_entrega`, `st_orcamento`) VALUES
(30, 15, '2026-05-14', 1500.00, 'as', 'Polido', 1, 'Não', NULL, NULL, '2026-05-28', 'Aprovado'),
(32, 36, '2026-05-01', 2500.00, 'ghjhjh', 'Polido', 1, NULL, NULL, NULL, '2026-05-28', 'Aprovado'),
(33, 37, '2026-05-08', 2500.00, 'bnbnbbbnnnbnbbnbnbn', 'Polido', 1, NULL, NULL, NULL, '2026-05-28', 'Aprovado'),
(34, 38, '2026-05-08', 2500.00, 'adsdsdsd', 'Polido', 1, NULL, NULL, NULL, '2026-05-28', 'Aprovado');

--
-- Acionadores `orcamento`
--
DELIMITER $$
CREATE TRIGGER `gerar_venda` AFTER UPDATE ON `orcamento` FOR EACH ROW BEGIN
    IF NEW.st_orcamento = 'Aprovado' AND OLD.st_orcamento <> 'Aprovado' THEN
        INSERT INTO venda (id_orcamento, id_vendedor, vl_total)
        VALUES (NEW.id_orcamento, 1, NEW.vl_total);
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `pagamento`
--

CREATE TABLE `pagamento` (
  `id_pagamento` int(11) NOT NULL,
  `id_orcamento` int(11) NOT NULL,
  `dt_pagamento_entrada` date NOT NULL DEFAULT curdate(),
  `dt_pagamento_saida` date DEFAULT NULL,
  `vl_pagamento_entrada` decimal(10,2) NOT NULL,
  `vl_pagamento_saida` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `pagamento`
--

INSERT INTO `pagamento` (`id_pagamento`, `id_orcamento`, `dt_pagamento_entrada`, `dt_pagamento_saida`, `vl_pagamento_entrada`, `vl_pagamento_saida`) VALUES
(16, 30, '2026-05-08', '0000-00-00', 750.00, 0.00),
(18, 32, '2026-05-08', NULL, 1250.00, NULL),
(19, 33, '2026-05-08', NULL, 1250.00, NULL),
(20, 34, '2026-05-08', NULL, 1250.00, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `pedra`
--

CREATE TABLE `pedra` (
  `id_pedra` int(11) NOT NULL,
  `nm_pedra` varchar(255) NOT NULL,
  `ds_pedra` text NOT NULL,
  `vl_compra_pedra` decimal(10,2) NOT NULL,
  `vl_venda_pedra` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `pedra`
--

INSERT INTO `pedra` (`id_pedra`, `nm_pedra`, `ds_pedra`, `vl_compra_pedra`, `vl_venda_pedra`) VALUES
(1, 'Granito Verde Ubatuba', 'Granito verde escuro', 110.00, 550.00),
(2, 'Granito Preto São Gabriel', 'Cor preta, granito', 200.00, 1000.00),
(3, 'Granito Branco Itaúnas', 'Cor branca com veios cinza, granito', 210.00, 1050.00),
(4, 'Granito Preto São Gabriel', 'Pedra polida', 350.00, 1750.00);

--
-- Acionadores `pedra`
--
DELIMITER $$
CREATE TRIGGER `calcular_venda_pedra` BEFORE INSERT ON `pedra` FOR EACH ROW set new.vl_venda_pedra = new.vl_compra_pedra * 5
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `produto`
--

CREATE TABLE `produto` (
  `id_produto` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `nm_produto` varchar(255) NOT NULL,
  `ds_produto` text NOT NULL,
  `vl_produto` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `produto`
--

INSERT INTO `produto` (`id_produto`, `id_categoria`, `nm_produto`, `ds_produto`, `vl_produto`) VALUES
(1, 1, 'Disco de Corte Diamantado', 'Disco utilizado para corte de granito e mármore', 180.00),
(2, 1, 'Disco de Polimento', 'Disco para polimento e acabamento da pedra', 95.00),
(3, 2, 'Resina Epóxi', 'Resina para acabamento e correção de imperfeições na pedra', 120.00),
(4, 2, 'Cera para Polimento', 'Cera utilizada no acabamento final da pedra', 45.00),
(5, 3, 'Silicone Incolor', 'Silicone utilizado para vedação e fixação', 22.00),
(6, 3, 'Parafuso e Bucha', 'Conjunto para fixação de peças de mármore', 12.00),
(7, 4, 'Lixa Diamantada', 'Lixa especial para acabamento em mármore e granito', 35.00),
(8, 4, 'Pasta de Polimento', 'Pasta abrasiva para polimento de superfícies', 40.00),
(9, 1, 'Disco de Corte Diamantado', 'Disco utilizado para corte de granito e mármore', 180.00),
(10, 1, 'Disco de Polimento', 'Disco para polimento e acabamento da pedra', 95.00),
(11, 2, 'Resina Epóxi', 'Resina para acabamento e correção de imperfeições na pedra', 120.00),
(12, 2, 'Cera para Polimento', 'Cera utilizada no acabamento final da pedra', 45.00),
(13, 3, 'Silicone Incolor', 'Silicone utilizado para vedação e fixação', 22.00),
(14, 3, 'Parafuso e Bucha', 'Conjunto para fixação de peças de mármore', 12.00),
(15, 4, 'Lixa Diamantada', 'Lixa especial para acabamento em mármore e granito', 35.00),
(16, 4, 'Pasta de Polimento', 'Pasta abrasiva para polimento de superfícies', 40.00),
(17, 5, 'Cuba Inox Luxo', 'Cuba de embutir', 260.00);

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `email_usuario` varchar(100) DEFAULT NULL,
  `cd_senha` varchar(255) NOT NULL,
  `tp_usuario` enum('Administrador','Vendedor') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `email_usuario`, `cd_senha`, `tp_usuario`) VALUES
(1, 'admin@marmoraria.com', '$2b$12$cM83kkOpEBTNc2ik8UlqfeddTOkMWq6Xx0Uo5nz0zdcI2BfJI4U7e', 'Administrador'),
(2, 'ricardo.mendes@marmoraria.com', '$2b$12$WBchC/4iJZVmHq.a97plouAupoOWee7r0xBlAy0JkzWlzlcM/Ytp6', 'Vendedor'),
(3, 'fernanda.lima@marmoraria.com', '$2b$12$YTH34d4BbQX9I0JmEgub5uIAFYsQ8nGd2xv9dXi3.cfwfRJB4k0uC', 'Vendedor'),
(4, 'gerente@marmoraria.com', '$2b$12$Hq66trn.YJ8srn..JHSHc./0H/MaA9evOMqv8Oh5sQHnSl0Q2DY6.', 'Administrador');

-- --------------------------------------------------------

--
-- Estrutura para tabela `venda`
--

CREATE TABLE `venda` (
  `id_venda` int(11) NOT NULL,
  `id_orcamento` int(11) NOT NULL,
  `id_vendedor` int(11) NOT NULL,
  `dt_venda` date NOT NULL DEFAULT curdate(),
  `vl_total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `venda`
--

INSERT INTO `venda` (`id_venda`, `id_orcamento`, `id_vendedor`, `dt_venda`, `vl_total`) VALUES
(45, 30, 1, '2026-05-14', 1500.00),
(47, 30, 1, '2026-05-15', 1500.00),
(48, 32, 1, '2026-05-01', 2500.00),
(49, 33, 1, '2026-05-08', 2500.00),
(50, 34, 1, '2026-05-08', 2500.00);

-- --------------------------------------------------------

--
-- Estrutura para tabela `vendedor`
--

CREATE TABLE `vendedor` (
  `id_vendedor` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `nm_vendedor` varchar(255) NOT NULL,
  `vl_comissao` decimal(5,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `vendedor`
--

INSERT INTO `vendedor` (`id_vendedor`, `id_usuario`, `nm_vendedor`, `vl_comissao`) VALUES
(1, 2, 'Ricardo Mendes', 5.00),
(2, 3, 'Fernanda Lima', 6.50);

-- --------------------------------------------------------

--
-- Estrutura stand-in para view `vw_agendamentos_proximos`
-- (Veja abaixo para a visão atual)
--
CREATE TABLE `vw_agendamentos_proximos` (
`id_orcamento` int(11)
,`nm_cliente` varchar(255)
,`dt_entrega` date
,`vl_total` decimal(10,2)
,`st_orcamento` enum('Aberto','Aprovado','Cancelado','Finalizado')
);

-- --------------------------------------------------------

--
-- Estrutura stand-in para view `vw_estoque_baixo`
-- (Veja abaixo para a visão atual)
--
CREATE TABLE `vw_estoque_baixo` (
`nm_produto` varchar(255)
,`qt_estoque` int(11)
);

-- --------------------------------------------------------

--
-- Estrutura stand-in para view `vw_orcamento_aberto`
-- (Veja abaixo para a visão atual)
--
CREATE TABLE `vw_orcamento_aberto` (
`nm_cliente` varchar(255)
,`dt_pedido` date
,`dt_entrega` date
,`vl_total` decimal(10,2)
);

-- --------------------------------------------------------

--
-- Estrutura stand-in para view `vw_vendas_periodo`
-- (Veja abaixo para a visão atual)
--
CREATE TABLE `vw_vendas_periodo` (
`id_orcamento` int(11)
,`nm_cliente` varchar(255)
,`dt_pedido` date
,`vl_total` decimal(10,2)
,`st_orcamento` enum('Aberto','Aprovado','Cancelado','Finalizado')
);

-- --------------------------------------------------------

--
-- Estrutura para view `vw_agendamentos_proximos`
--
DROP TABLE IF EXISTS `vw_agendamentos_proximos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_agendamentos_proximos`  AS SELECT `o`.`id_orcamento` AS `id_orcamento`, `c`.`nm_cliente` AS `nm_cliente`, `o`.`dt_entrega` AS `dt_entrega`, `o`.`vl_total` AS `vl_total`, `o`.`st_orcamento` AS `st_orcamento` FROM (`orcamento` `o` join `cliente` `c` on(`c`.`cd_cliente` = `o`.`cd_cliente`)) WHERE `o`.`dt_entrega` between curdate() and curdate() + interval 7 day ;

-- --------------------------------------------------------

--
-- Estrutura para view `vw_estoque_baixo`
--
DROP TABLE IF EXISTS `vw_estoque_baixo`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_estoque_baixo`  AS SELECT `p`.`nm_produto` AS `nm_produto`, `e`.`qt_estoque` AS `qt_estoque` FROM (`produto` `p` join `estoque` `e` on(`p`.`id_produto` = `e`.`id_produto`)) WHERE `e`.`qt_estoque` < 5 ;

-- --------------------------------------------------------

--
-- Estrutura para view `vw_orcamento_aberto`
--
DROP TABLE IF EXISTS `vw_orcamento_aberto`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_orcamento_aberto`  AS SELECT `c`.`nm_cliente` AS `nm_cliente`, `o`.`dt_pedido` AS `dt_pedido`, `o`.`dt_entrega` AS `dt_entrega`, `o`.`vl_total` AS `vl_total` FROM (`cliente` `c` join `orcamento` `o` on(`c`.`cd_cliente` = `o`.`cd_cliente`)) WHERE `o`.`st_orcamento` = 'Aberto' ;

-- --------------------------------------------------------

--
-- Estrutura para view `vw_vendas_periodo`
--
DROP TABLE IF EXISTS `vw_vendas_periodo`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_vendas_periodo`  AS SELECT `o`.`id_orcamento` AS `id_orcamento`, `c`.`nm_cliente` AS `nm_cliente`, `o`.`dt_pedido` AS `dt_pedido`, `o`.`vl_total` AS `vl_total`, `o`.`st_orcamento` AS `st_orcamento` FROM (`orcamento` `o` join `cliente` `c` on(`c`.`cd_cliente` = `o`.`cd_cliente`)) ;

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `agenda`
--
ALTER TABLE `agenda`
  ADD PRIMARY KEY (`id_agenda`),
  ADD KEY `id_orcamento` (`id_orcamento`),
  ADD KEY `cd_cliente` (`cd_cliente`),
  ADD KEY `idx_dt_compromisso` (`dt_compromisso`);

--
-- Índices de tabela `categoria_produto`
--
ALTER TABLE `categoria_produto`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Índices de tabela `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`cd_cliente`),
  ADD KEY `idx_cliente` (`nm_cliente`);

--
-- Índices de tabela `estoque`
--
ALTER TABLE `estoque`
  ADD PRIMARY KEY (`id_estoque`),
  ADD KEY `id_produto` (`id_produto`);

--
-- Índices de tabela `movimentacao_estoque`
--
ALTER TABLE `movimentacao_estoque`
  ADD PRIMARY KEY (`id_movimentacao`),
  ADD KEY `id_produto` (`id_produto`);

--
-- Índices de tabela `orcamento`
--
ALTER TABLE `orcamento`
  ADD PRIMARY KEY (`id_orcamento`),
  ADD KEY `cd_cliente` (`cd_cliente`),
  ADD KEY `id_pedra` (`id_pedra`),
  ADD KEY `idx_dt_orcamento` (`dt_pedido`),
  ADD KEY `idx_st_orcamento` (`st_orcamento`);

--
-- Índices de tabela `pagamento`
--
ALTER TABLE `pagamento`
  ADD PRIMARY KEY (`id_pagamento`),
  ADD KEY `id_orcamento` (`id_orcamento`);

--
-- Índices de tabela `pedra`
--
ALTER TABLE `pedra`
  ADD PRIMARY KEY (`id_pedra`);

--
-- Índices de tabela `produto`
--
ALTER TABLE `produto`
  ADD PRIMARY KEY (`id_produto`),
  ADD KEY `id_categoria` (`id_categoria`),
  ADD KEY `idx_produto` (`nm_produto`);

--
-- Índices de tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`);

--
-- Índices de tabela `venda`
--
ALTER TABLE `venda`
  ADD PRIMARY KEY (`id_venda`),
  ADD KEY `id_orcamento` (`id_orcamento`),
  ADD KEY `id_vendedor` (`id_vendedor`);

--
-- Índices de tabela `vendedor`
--
ALTER TABLE `vendedor`
  ADD PRIMARY KEY (`id_vendedor`),
  ADD KEY `fk_vendedor_usuario` (`id_usuario`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `agenda`
--
ALTER TABLE `agenda`
  MODIFY `id_agenda` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `categoria_produto`
--
ALTER TABLE `categoria_produto`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `cliente`
--
ALTER TABLE `cliente`
  MODIFY `cd_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT de tabela `estoque`
--
ALTER TABLE `estoque`
  MODIFY `id_estoque` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `movimentacao_estoque`
--
ALTER TABLE `movimentacao_estoque`
  MODIFY `id_movimentacao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de tabela `orcamento`
--
ALTER TABLE `orcamento`
  MODIFY `id_orcamento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de tabela `pagamento`
--
ALTER TABLE `pagamento`
  MODIFY `id_pagamento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de tabela `pedra`
--
ALTER TABLE `pedra`
  MODIFY `id_pedra` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `produto`
--
ALTER TABLE `produto`
  MODIFY `id_produto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `venda`
--
ALTER TABLE `venda`
  MODIFY `id_venda` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT de tabela `vendedor`
--
ALTER TABLE `vendedor`
  MODIFY `id_vendedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `agenda`
--
ALTER TABLE `agenda`
  ADD CONSTRAINT `agenda_ibfk_1` FOREIGN KEY (`id_orcamento`) REFERENCES `orcamento` (`id_orcamento`),
  ADD CONSTRAINT `agenda_ibfk_2` FOREIGN KEY (`cd_cliente`) REFERENCES `cliente` (`cd_cliente`);

--
-- Restrições para tabelas `estoque`
--
ALTER TABLE `estoque`
  ADD CONSTRAINT `estoque_ibfk_1` FOREIGN KEY (`id_produto`) REFERENCES `produto` (`id_produto`);

--
-- Restrições para tabelas `movimentacao_estoque`
--
ALTER TABLE `movimentacao_estoque`
  ADD CONSTRAINT `movimentacao_estoque_ibfk_1` FOREIGN KEY (`id_produto`) REFERENCES `produto` (`id_produto`);

--
-- Restrições para tabelas `orcamento`
--
ALTER TABLE `orcamento`
  ADD CONSTRAINT `orcamento_ibfk_1` FOREIGN KEY (`cd_cliente`) REFERENCES `cliente` (`cd_cliente`),
  ADD CONSTRAINT `orcamento_ibfk_2` FOREIGN KEY (`id_pedra`) REFERENCES `pedra` (`id_pedra`);

--
-- Restrições para tabelas `pagamento`
--
ALTER TABLE `pagamento`
  ADD CONSTRAINT `pagamento_ibfk_1` FOREIGN KEY (`id_orcamento`) REFERENCES `orcamento` (`id_orcamento`);

--
-- Restrições para tabelas `produto`
--
ALTER TABLE `produto`
  ADD CONSTRAINT `produto_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categoria_produto` (`id_categoria`);

--
-- Restrições para tabelas `venda`
--
ALTER TABLE `venda`
  ADD CONSTRAINT `venda_ibfk_1` FOREIGN KEY (`id_orcamento`) REFERENCES `orcamento` (`id_orcamento`),
  ADD CONSTRAINT `venda_ibfk_2` FOREIGN KEY (`id_vendedor`) REFERENCES `vendedor` (`id_vendedor`);

--
-- Restrições para tabelas `vendedor`
--
ALTER TABLE `vendedor`
  ADD CONSTRAINT `fk_vendedor_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
