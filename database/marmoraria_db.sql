-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 10/04/2026 às 23:57
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


-- Banco de dados: `marmoraria_db`
-- tabela agenda
CREATE TABLE `agenda` (
  `id_agenda` int(11) NOT NULL,
  `id_orcamento` int(11) DEFAULT NULL,
  `cd_cliente` int(11) DEFAULT NULL,
  `dt_compromisso` date NOT NULL DEFAULT curdate(),
  `hr_compromisso` time NOT NULL,
  `ds_compromisso` varchar(255) NOT NULL,
  `st_compromisso` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- tabela categoria_produto


CREATE TABLE `categoria_produto` (
  `id_categoria` int(11) NOT NULL,
  `nm_categoria` varchar(50) NOT NULL,
  `ds_categoria` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- insert categoria_produto


INSERT INTO `categoria_produto` (`id_categoria`, `nm_categoria`, `ds_categoria`) VALUES
(1, 'Ferramentas', 'Ferramentas utilizadas no corte e acabamento do mármore'),
(2, 'Insumos de acabamento', 'Materiais utilizados no acabamento das peças'),
(3, 'Fixação e instalação', 'Materiais usados na instalação das pedras'),
(4, 'Consumíveis de produção', 'Materiais consumidos durante o processo produtivo');

-- tabela cliente

CREATE TABLE `cliente` (
  `cd_cliente` int(11) NOT NULL,
  `nm_cliente` varchar(255) NOT NULL,
  `cd_telefone` varchar(20) DEFAULT NULL,
  `nm_endereco` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- tabela estoque


CREATE TABLE `estoque` (
  `id_estoque` int(11) NOT NULL,
  `id_produto` int(11) NOT NULL,
  `qt_estoque` int(11) NOT NULL,
  `dt_atualizacao` date NOT NULL DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- insert estoque

INSERT INTO `estoque` (`id_estoque`, `id_produto`, `qt_estoque`, `dt_atualizacao`) VALUES
(1, 1, 9, '2026-04-10'),
(2, 2, 15, '2026-04-10'),
(3, 3, 8, '2026-04-10'),
(4, 4, 12, '2026-04-10'),
(5, 5, 20, '2026-04-10'),
(6, 6, 50, '2026-04-10'),
(7, 7, 25, '2026-04-10'),
(8, 8, 18, '2026-04-10');

-- tabela movimentacao_estoque

CREATE TABLE `movimentacao_estoque` (
  `id_movimentacao` int(11) NOT NULL,
  `id_produto` int(11) NOT NULL,
  `qt_movimentacao` int(11) NOT NULL,
  `dt_movimentacao` date NOT NULL DEFAULT curdate(),
  `tp_movimentacao` enum('Entrada','Saída') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- insert movimentacao_estoque

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
(11, 1, 3, '2026-04-10', 'Saída');

-- trigger `atualizar_estoque`

DELIMITER $$
CREATE TRIGGER `atualizar_estoque` AFTER INSERT ON `movimentacao_estoque` FOR EACH ROW BEGIN
    IF NEW.tp_movimentacao = 'Entrada' THEN
        UPDATE estoque
        SET qt_estoque = qt_estoque + NEW.qt_movimentacao,
            dt_atualizacao = CURRENT_DATE
        WHERE id_produto = NEW.id_produto;
    ELSEIF NEW.tp_movimentacao = 'Saída' THEN
        UPDATE estoque
        SET qt_estoque = qt_estoque - NEW.qt_movimentacao,
            dt_atualizacao = CURRENT_DATE
        WHERE id_produto = NEW.id_produto;
    END IF;
END
$$
DELIMITER ;

-- tabela `orcamento`

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
  `st_orcamento` enum('Aberto','Aprovado','Cancelado') NOT NULL DEFAULT 'Aberto'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- trigger `gerar_venda`
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
-- tabela `pagamento`
--

CREATE TABLE `pagamento` (
  `id_pagamento` int(11) NOT NULL,
  `id_orcamento` int(11) NOT NULL,
  `dt_pagamento_entrada` date NOT NULL DEFAULT curdate(),
  `dt_pagamento_saida` date DEFAULT NULL,
  `vl_pagamento_entrada` decimal(10,2) NOT NULL,
  `vl_pagamento_saida` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- tabela `pedra`

CREATE TABLE `pedra` (
  `id_pedra` int(11) NOT NULL,
  `nm_pedra` varchar(255) NOT NULL,
  `ds_pedra` text NOT NULL,
  `vl_compra_pedra` decimal(10,2) NOT NULL,
  `vl_venda_pedra` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- insert `pedra`

INSERT INTO `pedra` (`id_pedra`, `nm_pedra`, `ds_pedra`, `vl_compra_pedra`, `vl_venda_pedra`) VALUES
(1, 'Granito Verde Ubatuba', 'Granito verde escuro', 110.00, 550.00),
(2, 'Granito Preto São Gabriel', 'Cor preta, granito', 200.00, 1000.00),
(3, 'Granito Branco Itaúnas', 'Cor branca com veios cinza, granito', 210.00, 1050.00);

--
-- trigger `calcular_venda_pedra`
--
DELIMITER $$
CREATE TRIGGER `calcular_venda_pedra` BEFORE INSERT ON `pedra` FOR EACH ROW set new.vl_venda_pedra = new.vl_compra_pedra * 5
$$
DELIMITER ;

-- tabela `produto`
--

CREATE TABLE `produto` (
  `id_produto` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `nm_produto` varchar(255) NOT NULL,
  `ds_produto` text NOT NULL,
  `vl_produto` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- insert `produto`
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
(16, 4, 'Pasta de Polimento', 'Pasta abrasiva para polimento de superfícies', 40.00);


-- tabela `usuario`


CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `nm_usuario` varchar(255) NOT NULL,
  `cd_senha` varchar(255) NOT NULL,
  `tp_usuario` enum('Administrador','Vendedor') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- tabela `venda`

CREATE TABLE `venda` (
  `id_venda` int(11) NOT NULL,
  `id_orcamento` int(11) NOT NULL,
  `id_vendedor` int(11) NOT NULL,
  `dt_venda` date NOT NULL DEFAULT curdate(),
  `vl_total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- tabela `vendedor`

CREATE TABLE `vendedor` (
  `id_vendedor` int(11) NOT NULL,
  `nm_vendedor` varchar(255) NOT NULL,
  `cd_senha` varchar(255) NOT NULL,
  `vl_comissao` decimal(5,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tabelas despejadas
--

--
-- index de tabela `agenda`
ALTER TABLE `agenda`
  ADD PRIMARY KEY (`id_agenda`),
  ADD KEY `id_orcamento` (`id_orcamento`),
  ADD KEY `cd_cliente` (`cd_cliente`),
  ADD KEY `idx_dt_compromisso` (`dt_compromisso`);

--
-- index de tabela `categoria_produto`
--
ALTER TABLE `categoria_produto`
  ADD PRIMARY KEY (`id_categoria`);

--
-- index de tabela `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`cd_cliente`),
  ADD KEY `idx_cliente` (`nm_cliente`);

--
-- index de tabela `estoque`
--
ALTER TABLE `estoque`
  ADD PRIMARY KEY (`id_estoque`),
  ADD KEY `id_produto` (`id_produto`);

--
-- index de tabela `movimentacao_estoque`
--
ALTER TABLE `movimentacao_estoque`
  ADD PRIMARY KEY (`id_movimentacao`),
  ADD KEY `id_produto` (`id_produto`);

--
-- index de tabela `orcamento`
--
ALTER TABLE `orcamento`
  ADD PRIMARY KEY (`id_orcamento`),
  ADD KEY `cd_cliente` (`cd_cliente`),
  ADD KEY `id_pedra` (`id_pedra`),
  ADD KEY `idx_dt_orcamento` (`dt_pedido`),
  ADD KEY `idx_st_orcamento` (`st_orcamento`);

--
-- index de tabela `pagamento`
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
  ADD PRIMARY KEY (`id_vendedor`);

--
-- AUTO_INCREMENT para tabelas despejadas

-- AUTO_INCREMENT de tabela `agenda`
--
ALTER TABLE `agenda`
  MODIFY `id_agenda` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `categoria_produto`
--
ALTER TABLE `categoria_produto`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `cliente`
--
ALTER TABLE `cliente`
  MODIFY `cd_cliente` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `estoque`
--
ALTER TABLE `estoque`
  MODIFY `id_estoque` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `movimentacao_estoque`
--
ALTER TABLE `movimentacao_estoque`
  MODIFY `id_movimentacao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de tabela `orcamento`
--
ALTER TABLE `orcamento`
  MODIFY `id_orcamento` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `pagamento`
--
ALTER TABLE `pagamento`
  MODIFY `id_pagamento` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `pedra`
--
ALTER TABLE `pedra`
  MODIFY `id_pedra` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `produto`
--
ALTER TABLE `produto`
  MODIFY `id_produto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `venda`
--
ALTER TABLE `venda`
  MODIFY `id_venda` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `vendedor`
--
ALTER TABLE `vendedor`
  MODIFY `id_vendedor` int(11) NOT NULL AUTO_INCREMENT;

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
COMMIT;