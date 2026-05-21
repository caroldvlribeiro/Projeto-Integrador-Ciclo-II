-- phpMyAdmin SQL Dump
-- Marmoraria Nova Canaã - versão limpa
-- Sem duplicatas, senhas com hash bcrypt, triggers de pedra cobrindo INSERT e UPDATE

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


-- =====================================================
-- TABELA agenda
-- =====================================================
CREATE TABLE `agenda` (
  `id_agenda` int(11) NOT NULL,
  `id_orcamento` int(11) DEFAULT NULL,
  `cd_cliente` int(11) DEFAULT NULL,
  `dt_compromisso` date NOT NULL DEFAULT curdate(),
  `hr_compromisso` time NOT NULL,
  `ds_compromisso` varchar(255) NOT NULL,
  `st_compromisso` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `agenda` (`id_agenda`, `id_orcamento`, `cd_cliente`, `dt_compromisso`, `hr_compromisso`, `ds_compromisso`, `st_compromisso`) VALUES
(1, 1, 1, '2026-04-13', '09:00:00', 'Visita para medição da cozinha', 1),
(2, 2, 2, '2026-04-13', '11:30:00', 'Avaliação do espaço para instalação', 1),
(3, 3, 3, '2026-04-13', '14:00:00', 'Confirmação de medidas da ilha', 1),
(4, 4, 4, '2026-04-13', '16:00:00', 'Revisão do orçamento com cliente', 1);


-- =====================================================
-- TABELA categoria_produto
-- =====================================================
CREATE TABLE `categoria_produto` (
  `id_categoria` int(11) NOT NULL,
  `nm_categoria` varchar(50) NOT NULL,
  `ds_categoria` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `categoria_produto` (`id_categoria`, `nm_categoria`, `ds_categoria`) VALUES
(1, 'Ferramentas', 'Ferramentas utilizadas no corte e acabamento do mármore'),
(2, 'Insumos de acabamento', 'Materiais utilizados no acabamento das peças'),
(3, 'Fixação e instalação', 'Materiais usados na instalação das pedras'),
(4, 'Consumíveis de produção', 'Materiais consumidos durante o processo produtivo');


-- =====================================================
-- TABELA cliente
-- =====================================================
CREATE TABLE `cliente` (
  `cd_cliente` int(11) NOT NULL,
  `nm_cliente` varchar(255) NOT NULL,
  `cd_telefone` varchar(20) DEFAULT NULL,
  `nm_endereco` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `cliente` (`cd_cliente`, `nm_cliente`, `cd_telefone`, `nm_endereco`) VALUES
(1, 'João Silva', '13999990001', 'Rua das Palmeiras, 120'),
(2, 'Maria Oliveira', '13999990002', 'Av. Brasil, 450'),
(3, 'Carlos Souza', '13999990003', 'Rua Afonso Pena, 78'),
(4, 'Ana Costa', '13999990004', 'Rua das Flores, 210');


-- =====================================================
-- TABELA estoque
-- =====================================================
CREATE TABLE `estoque` (
  `id_estoque` int(11) NOT NULL,
  `id_produto` int(11) NOT NULL,
  `qt_estoque` int(11) NOT NULL,
  `dt_atualizacao` date NOT NULL DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `estoque` (`id_estoque`, `id_produto`, `qt_estoque`, `dt_atualizacao`) VALUES
(1, 1, 9, '2026-04-10'),
(2, 2, 15, '2026-04-10'),
(3, 3, 8, '2026-04-10'),
(4, 4, 12, '2026-04-10'),
(5, 5, 20, '2026-04-10'),
(6, 6, 50, '2026-04-10'),
(7, 7, 25, '2026-04-10'),
(8, 8, 18, '2026-04-10');


-- =====================================================
-- TABELA movimentacao_estoque
-- =====================================================
CREATE TABLE `movimentacao_estoque` (
  `id_movimentacao` int(11) NOT NULL,
  `id_produto` int(11) NOT NULL,
  `qt_movimentacao` int(11) NOT NULL,
  `dt_movimentacao` date NOT NULL DEFAULT curdate(),
  `tp_movimentacao` enum('Entrada','Saída') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

-- Trigger: atualiza estoque automaticamente quando uma movimentação é inserida
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


-- =====================================================
-- TABELA orcamento
-- =====================================================
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

INSERT INTO `orcamento` (`id_orcamento`, `cd_cliente`, `dt_pedido`, `vl_total`, `ds_descricao`, `acabamento`, `id_pedra`, `nm_cuba`, `vista`, `saia`, `dt_entrega`, `st_orcamento`) VALUES
(1, 1, '2026-04-13', 1800.00, 'Bancada de cozinha com cuba', 'Polido', 1, 'Cuba inox', 'Frontal', 'Simples', '2026-04-20', 'Aprovado'),
(2, 2, '2026-04-13', 2500.00, 'Bancada cozinha em granito preto', 'Polido', 2, 'Cuba dupla', 'Frontal', 'Dupla', '2026-04-25', 'Aberto'),
(3, 3, '2026-04-13', 3200.00, 'Ilha de cozinha em granito branco', 'Escovado', 3, 'Cuba inox', 'Lateral', 'Simples', '2026-05-02', 'Aprovado'),
(4, 4, '2026-04-13', 1500.00, 'Pia simples cozinha', 'Polido', 1, 'Cuba simples', 'Frontal', 'Simples', '2026-04-30', 'Cancelado');

-- Trigger: gera venda automaticamente quando orçamento é aprovado
DELIMITER $$
CREATE TRIGGER `gerar_venda` AFTER UPDATE ON `orcamento` FOR EACH ROW BEGIN
    IF NEW.st_orcamento = 'Aprovado' AND OLD.st_orcamento <> 'Aprovado' THEN
        INSERT INTO venda (id_orcamento, id_vendedor, vl_total)
        VALUES (NEW.id_orcamento, 1, NEW.vl_total);
    END IF;
END
$$
DELIMITER ;


-- =====================================================
-- TABELA pagamento
-- =====================================================
CREATE TABLE `pagamento` (
  `id_pagamento` int(11) NOT NULL,
  `id_orcamento` int(11) NOT NULL,
  `dt_pagamento_entrada` date NOT NULL DEFAULT curdate(),
  `dt_pagamento_saida` date DEFAULT NULL,
  `vl_pagamento_entrada` decimal(10,2) NOT NULL,
  `vl_pagamento_saida` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `pagamento` (`id_pagamento`, `id_orcamento`, `dt_pagamento_entrada`, `dt_pagamento_saida`, `vl_pagamento_entrada`, `vl_pagamento_saida`) VALUES
(1, 1, '2026-04-13', '2026-04-20', 900.00, 900.00),
(2, 2, '2026-04-13', NULL, 1000.00, NULL),
(3, 3, '2026-04-13', '2026-05-02', 1600.00, 1600.00),
(4, 4, '2026-04-13', NULL, 500.00, NULL);


-- =====================================================
-- TABELA pedra
-- =====================================================
CREATE TABLE `pedra` (
  `id_pedra` int(11) NOT NULL,
  `nm_pedra` varchar(255) NOT NULL,
  `ds_pedra` text NOT NULL,
  `vl_compra_pedra` decimal(10,2) NOT NULL,
  `vl_venda_pedra` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `pedra` (`id_pedra`, `nm_pedra`, `ds_pedra`, `vl_compra_pedra`, `vl_venda_pedra`) VALUES
(1, 'Granito Verde Ubatuba', 'Granito verde escuro', 110.00, 550.00),
(2, 'Granito Preto São Gabriel', 'Cor preta, granito', 200.00, 1000.00),
(3, 'Granito Branco Itaúnas', 'Cor branca com veios cinza, granito', 210.00, 1050.00);

-- Trigger BEFORE INSERT: calcula vl_venda_pedra ao inserir
DELIMITER $$
CREATE TRIGGER `calcular_venda_pedra` BEFORE INSERT ON `pedra` FOR EACH ROW
    SET NEW.vl_venda_pedra = NEW.vl_compra_pedra * 5
$$
DELIMITER ;

-- Trigger BEFORE UPDATE: recalcula vl_venda_pedra ao atualizar vl_compra_pedra
DELIMITER $$
CREATE TRIGGER `calcular_venda_pedra_update` BEFORE UPDATE ON `pedra` FOR EACH ROW
    SET NEW.vl_venda_pedra = NEW.vl_compra_pedra * 5
$$
DELIMITER ;


-- =====================================================
-- TABELA produto
-- =====================================================
CREATE TABLE `produto` (
  `id_produto` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `nm_produto` varchar(255) NOT NULL,
  `ds_produto` text NOT NULL,
  `vl_produto` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `produto` (`id_produto`, `id_categoria`, `nm_produto`, `ds_produto`, `vl_produto`) VALUES
(1, 1, 'Disco de Corte Diamantado', 'Disco utilizado para corte de granito e mármore', 180.00),
(2, 1, 'Disco de Polimento', 'Disco para polimento e acabamento da pedra', 95.00),
(3, 2, 'Resina Epóxi', 'Resina para acabamento e correção de imperfeições na pedra', 120.00),
(4, 2, 'Cera para Polimento', 'Cera utilizada no acabamento final da pedra', 45.00),
(5, 3, 'Silicone Incolor', 'Silicone utilizado para vedação e fixação', 22.00),
(6, 3, 'Parafuso e Bucha', 'Conjunto para fixação de peças de mármore', 12.00),
(7, 4, 'Lixa Diamantada', 'Lixa especial para acabamento em mármore e granito', 35.00),
(8, 4, 'Pasta de Polimento', 'Pasta abrasiva para polimento de superfícies', 40.00);


-- =====================================================
-- TABELA usuario  (senhas com hash bcrypt)
-- =====================================================
CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `nm_usuario` varchar(255) NOT NULL,
  `cd_senha` varchar(255) NOT NULL,
  `tp_usuario` enum('Administrador','Vendedor') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- admin / admin123    | vendedor1 / vend123
INSERT INTO `usuario` (`id_usuario`, `nm_usuario`, `cd_senha`, `tp_usuario`) VALUES
(1, 'admin', '$2y$10$6E/xGkz0AC/ntabCm27G6en89VUYgyVEXjIdv68C/VXaHpjaVlyci', 'Administrador'),
(2, 'vendedor1', '$2y$10$67ZZsaI.eC/Va3kuCnhvwu3OnRx78/9Q9ek/DF.AnR3ZuT31N8XeG', 'Vendedor');


-- =====================================================
-- TABELA venda
-- =====================================================
CREATE TABLE `venda` (
  `id_venda` int(11) NOT NULL,
  `id_orcamento` int(11) NOT NULL,
  `id_vendedor` int(11) NOT NULL,
  `dt_venda` date NOT NULL DEFAULT curdate(),
  `vl_total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `venda` (`id_venda`, `id_orcamento`, `id_vendedor`, `dt_venda`, `vl_total`) VALUES
(1, 1, 1, '2026-04-13', 1800.00),
(2, 3, 2, '2026-04-13', 3200.00);


-- =====================================================
-- TABELA vendedor  (senhas com hash bcrypt — todos com senha "123456")
-- =====================================================
CREATE TABLE `vendedor` (
  `id_vendedor` int(11) NOT NULL,
  `nm_vendedor` varchar(255) NOT NULL,
  `cd_senha` varchar(255) NOT NULL,
  `vl_comissao` decimal(5,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `vendedor` (`id_vendedor`, `nm_vendedor`, `cd_senha`, `vl_comissao`) VALUES
(1, 'Ricardo Mendes',  '$2y$10$N.tY0ENIsYc2rZY1ZlTeReU8Ze3CdSIdJ6ikIHkW8OiF73et17hPq', 5.00),
(2, 'Fernanda Lima',   '$2y$10$v2uYqHewnb/22Zcc2fIdTONAb8I1oLiUMfUss6V3vSeaRRooKqq86', 6.50),
(3, 'Bruno Almeida',   '$2y$10$KzBBPERx2S/IHqFAdDco2etpaAxBX.D3pVPj/NVZZHuK8sLjJJQ6C', 4.75),
(4, 'Juliana Rocha',   '$2y$10$YYPGSGF88sX4OspDvzmlE.5NNXaZsKcJIf5HL71uDLM5MbIDZM4zG', 5.50);


-- =====================================================
-- VIEWS (estrutura stand-in primeiro, depois CREATE VIEW)
-- =====================================================
CREATE TABLE `vw_agendamentos_proximos` (
`id_orcamento` int(11),
`nm_cliente` varchar(255),
`dt_entrega` date,
`vl_total` decimal(10,2),
`st_orcamento` enum('Aberto','Aprovado','Cancelado','Finalizado')
);

CREATE TABLE `vw_estoque_baixo` (
`nm_produto` varchar(255),
`qt_estoque` int(11)
);

CREATE TABLE `vw_orcamento_aberto` (
`nm_cliente` varchar(255),
`dt_pedido` date,
`dt_entrega` date,
`vl_total` decimal(10,2)
);

CREATE TABLE `vw_vendas_periodo` (
`id_orcamento` int(11),
`nm_cliente` varchar(255),
`dt_pedido` date,
`vl_total` decimal(10,2),
`st_orcamento` enum('Aberto','Aprovado','Cancelado','Finalizado')
);

DROP TABLE IF EXISTS `vw_agendamentos_proximos`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_agendamentos_proximos`  AS SELECT `o`.`id_orcamento` AS `id_orcamento`, `c`.`nm_cliente` AS `nm_cliente`, `o`.`dt_entrega` AS `dt_entrega`, `o`.`vl_total` AS `vl_total`, `o`.`st_orcamento` AS `st_orcamento` FROM (`orcamento` `o` join `cliente` `c` on(`c`.`cd_cliente` = `o`.`cd_cliente`)) WHERE `o`.`dt_entrega` between curdate() and curdate() + interval 7 day ;

DROP TABLE IF EXISTS `vw_estoque_baixo`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_estoque_baixo`  AS SELECT `p`.`nm_produto` AS `nm_produto`, `e`.`qt_estoque` AS `qt_estoque` FROM (`produto` `p` join `estoque` `e` on(`p`.`id_produto` = `e`.`id_produto`)) WHERE `e`.`qt_estoque` < 5 ;

DROP TABLE IF EXISTS `vw_orcamento_aberto`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_orcamento_aberto`  AS SELECT `c`.`nm_cliente` AS `nm_cliente`, `o`.`dt_pedido` AS `dt_pedido`, `o`.`dt_entrega` AS `dt_entrega`, `o`.`vl_total` AS `vl_total` FROM (`cliente` `c` join `orcamento` `o` on(`c`.`cd_cliente` = `o`.`cd_cliente`)) WHERE `o`.`st_orcamento` = 'Aberto' ;

DROP TABLE IF EXISTS `vw_vendas_periodo`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_vendas_periodo`  AS SELECT `o`.`id_orcamento` AS `id_orcamento`, `c`.`nm_cliente` AS `nm_cliente`, `o`.`dt_pedido` AS `dt_pedido`, `o`.`vl_total` AS `vl_total`, `o`.`st_orcamento` AS `st_orcamento` FROM (`orcamento` `o` join `cliente` `c` on(`c`.`cd_cliente` = `o`.`cd_cliente`)) ;


-- =====================================================
-- ÍNDICES E PRIMARY KEYS
-- =====================================================
ALTER TABLE `agenda`
  ADD PRIMARY KEY (`id_agenda`),
  ADD KEY `id_orcamento` (`id_orcamento`),
  ADD KEY `cd_cliente` (`cd_cliente`),
  ADD KEY `idx_dt_compromisso` (`dt_compromisso`);

ALTER TABLE `categoria_produto`
  ADD PRIMARY KEY (`id_categoria`);

ALTER TABLE `cliente`
  ADD PRIMARY KEY (`cd_cliente`),
  ADD KEY `idx_cliente` (`nm_cliente`);

ALTER TABLE `estoque`
  ADD PRIMARY KEY (`id_estoque`),
  ADD KEY `id_produto` (`id_produto`);

ALTER TABLE `movimentacao_estoque`
  ADD PRIMARY KEY (`id_movimentacao`),
  ADD KEY `id_produto` (`id_produto`);

ALTER TABLE `orcamento`
  ADD PRIMARY KEY (`id_orcamento`),
  ADD KEY `cd_cliente` (`cd_cliente`),
  ADD KEY `id_pedra` (`id_pedra`),
  ADD KEY `idx_dt_orcamento` (`dt_pedido`),
  ADD KEY `idx_st_orcamento` (`st_orcamento`);

ALTER TABLE `pagamento`
  ADD PRIMARY KEY (`id_pagamento`),
  ADD KEY `id_orcamento` (`id_orcamento`);

ALTER TABLE `pedra`
  ADD PRIMARY KEY (`id_pedra`);

ALTER TABLE `produto`
  ADD PRIMARY KEY (`id_produto`),
  ADD KEY `id_categoria` (`id_categoria`),
  ADD KEY `idx_produto` (`nm_produto`);

ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`);

ALTER TABLE `venda`
  ADD PRIMARY KEY (`id_venda`),
  ADD KEY `id_orcamento` (`id_orcamento`),
  ADD KEY `id_vendedor` (`id_vendedor`);

ALTER TABLE `vendedor`
  ADD PRIMARY KEY (`id_vendedor`);


-- =====================================================
-- AUTO_INCREMENT (ajustados pros novos valores limpos)
-- =====================================================
ALTER TABLE `agenda`               MODIFY `id_agenda`       int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
ALTER TABLE `categoria_produto`    MODIFY `id_categoria`    int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
ALTER TABLE `cliente`              MODIFY `cd_cliente`      int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
ALTER TABLE `estoque`              MODIFY `id_estoque`      int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
ALTER TABLE `movimentacao_estoque` MODIFY `id_movimentacao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
ALTER TABLE `orcamento`            MODIFY `id_orcamento`    int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
ALTER TABLE `pagamento`            MODIFY `id_pagamento`    int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
ALTER TABLE `pedra`                MODIFY `id_pedra`        int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
ALTER TABLE `produto`              MODIFY `id_produto`      int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
ALTER TABLE `usuario`              MODIFY `id_usuario`      int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
ALTER TABLE `venda`                MODIFY `id_venda`        int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
ALTER TABLE `vendedor`             MODIFY `id_vendedor`     int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;


-- =====================================================
-- FOREIGN KEYS
-- =====================================================
ALTER TABLE `agenda`
  ADD CONSTRAINT `agenda_ibfk_1` FOREIGN KEY (`id_orcamento`) REFERENCES `orcamento` (`id_orcamento`),
  ADD CONSTRAINT `agenda_ibfk_2` FOREIGN KEY (`cd_cliente`) REFERENCES `cliente` (`cd_cliente`);

ALTER TABLE `estoque`
  ADD CONSTRAINT `estoque_ibfk_1` FOREIGN KEY (`id_produto`) REFERENCES `produto` (`id_produto`);

ALTER TABLE `movimentacao_estoque`
  ADD CONSTRAINT `movimentacao_estoque_ibfk_1` FOREIGN KEY (`id_produto`) REFERENCES `produto` (`id_produto`);

ALTER TABLE `orcamento`
  ADD CONSTRAINT `orcamento_ibfk_1` FOREIGN KEY (`cd_cliente`) REFERENCES `cliente` (`cd_cliente`),
  ADD CONSTRAINT `orcamento_ibfk_2` FOREIGN KEY (`id_pedra`) REFERENCES `pedra` (`id_pedra`);

ALTER TABLE `pagamento`
  ADD CONSTRAINT `pagamento_ibfk_1` FOREIGN KEY (`id_orcamento`) REFERENCES `orcamento` (`id_orcamento`);

ALTER TABLE `produto`
  ADD CONSTRAINT `produto_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categoria_produto` (`id_categoria`);

ALTER TABLE `venda`
  ADD CONSTRAINT `venda_ibfk_1` FOREIGN KEY (`id_orcamento`) REFERENCES `orcamento` (`id_orcamento`),
  ADD CONSTRAINT `venda_ibfk_2` FOREIGN KEY (`id_vendedor`) REFERENCES `vendedor` (`id_vendedor`);

COMMIT;  