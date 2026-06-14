-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 27/05/2026 às 17:57
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `marmoraria_db`
--
CREATE DATABASE marmoraria_db;

USE marmoraria_db;
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
(5, 'Cubas', 'Cubas de Inox e Porcelana'),
(6, 'Produtos de Limpeza', 'Produtos para limpeza e conservação de mármores e granitos'),
(7, 'Ferragens', 'Ferragens utilizadas na instalação de pedras'),
(8, 'Adesivos e Colas', 'Materiais para fixação e acabamento'),
(9, 'Equipamentos Elétricos', 'Equipamentos usados na produção'),
(10, 'EPIs', 'Equipamentos de proteção individual'),
(11, 'Acessórios Decorativos', 'Itens decorativos para acabamento de ambientes');

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
(14, 'Carlos Henrique Souza', '(15) 99711-2456', 'Rua das Palmeiras, 120 - Sorocaba/SP'),
(15, 'Ana Julia', '13998069688', 'ddfsff'),
(16, 'Fernanda Oliveira Lima', '(15) 99845-7741', 'Av. São Paulo, 450 - Sorocaba/SP'),
(17, 'Ricardo Mendes Silva', '(15) 99632-8810', 'Rua Antônio Perez Hernandez, 88 - Votorantim/SP'),
(18, 'Juliana Martins Costa', '(15) 99124-3367', 'Rua do Sol, 501 - Sorocaba/SP'),
(19, 'André Felipe Moraes', '(15) 99773-1102', 'Alameda Campolim, 220 - Sorocaba/SP'),
(20, 'Camila Ribeiro Alves', '(15) 99281-5590', 'Rua Maria Aparecida, 76 - Itu/SP'),
(21, 'Lucas Fernandes Rocha', '(15) 99812-6644', 'Rua Central, 311 - Sorocaba/SP'),
(22, 'Patrícia Gomes Ferreira', '(15) 99177-4020', 'Av. Ipanema, 920 - Sorocaba/SP'),
(23, 'Eduardo Nunes Barbosa', '(15) 99654-7821', 'Rua Chile, 654 - Sorocaba/SP'),
(24, 'Mariana Lopes Santana', '(15) 99321-5588', 'Rua XV de Novembro, 77 - Sorocaba/SP'),
(25, 'Thiago Almeida Prado', '(15) 99902-7731', 'Rua Benedito Ferreira, 198 - Votorantim/SP'),
(26, 'Renata Cardoso Mendes', '(15) 99445-8812', 'Rua Professora Maria, 412 - Sorocaba/SP'),
(27, 'Gustavo Henrique Dias', '(15) 99112-6400', 'Av. Itavuvu, 1590 - Sorocaba/SP'),
(28, 'Larissa Monteiro Silva', '(15) 99780-1122', 'Rua Goiás, 140 - Itu/SP'),
(29, 'Bruno César Teixeira', '(15) 99671-2234', 'Rua Santa Clara, 901 - Sorocaba/SP'),
(30, 'Vanessa Cristina Rocha', '(15) 99876-4450', 'Rua Aparecida, 250 - Sorocaba/SP'),
(31, 'Felipe Augusto Martins', '(15) 99214-9901', 'Rua Espanha, 100 - Votorantim/SP'),
(32, 'Aline Pereira Gomes', '(15) 99955-7832', 'Rua Atanázio Soares, 665 - Sorocaba/SP'),
(33, 'Rodrigo Vieira Campos', '(15) 99345-2281', 'Av. Barão de Tatuí, 300 - Sorocaba/SP'),
(34, 'Tatiane Moreira Lopes', '(15) 99618-4500', 'Rua Arthur Bernardes, 720 - Sorocaba/SP'),
(35, 'Marcelo Ribeiro Costa', '(15) 99741-8820', 'Rua Joaquim Nabuco, 86 - Itu/SP'),
(36, 'Ana Maria', '13998069689', 'rua maria isabel n255'),
(37, 'Maria', '13998069687', 'rua maria isabel n255'),
(38, 'Maria', '13998069685', 'rua maria isabel n255'),
(39, 'jacqueline da silva ribeiro', '(13)99865369562', 'rua silva oliveira'),
(40, 'priscila', '(13)99865369564', 'rua silva oliveira'),
(41, 'jose', '(13)99865369569', 'rua silva oliveira');

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
(6, 6, 50, '2026-04-10'),
(8, 8, 18, '2026-04-10'),
(11, 18, 30, '2026-05-26'),
(12, 19, 20, '2026-05-26'),
(13, 20, 38, '2026-05-26'),
(14, 21, 40, '2026-05-26'),
(15, 22, 300, '2026-05-26'),
(16, 23, 45, '2026-05-26'),
(17, 24, 120, '2026-05-26'),
(18, 25, 100, '2026-05-26'),
(19, 26, 12, '2026-05-26'),
(20, 27, 8, '2026-05-26'),
(21, 28, 60, '2026-05-26'),
(22, 29, 40, '2026-05-26'),
(23, 30, 70, '2026-05-26'),
(24, 31, 55, '2026-05-26'),
(25, 32, 90, '2026-05-26'),
(27, 34, 6, '2026-05-26'),
(28, 35, 3, '2026-05-26'),
(29, 48, 9, '2026-05-27');

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
(6, 6, 50, '2026-04-10', 'Entrada'),
(8, 8, 18, '2026-04-10', 'Entrada'),
(10, 1, 3, '2026-04-10', 'Saída'),
(11, 1, 3, '2026-04-10', 'Saída'),
(13, 1, 1, '2026-05-23', 'Entrada'),
(15, 1, 1, '2026-05-23', 'Entrada'),
(16, 1, 2, '2026-05-23', 'Saída'),
(17, 1, 2, '2026-05-23', 'Entrada'),
(18, 17, 3, '2026-05-23', 'Entrada'),
(20, 18, 35, '2026-01-10', 'Entrada'),
(21, 19, 20, '2026-01-15', 'Entrada'),
(22, 20, 50, '2026-01-20', 'Entrada'),
(23, 21, 40, '2026-02-02', 'Entrada'),
(24, 22, 300, '2026-02-05', 'Entrada'),
(25, 23, 45, '2026-02-10', 'Entrada'),
(26, 24, 120, '2026-02-14', 'Entrada'),
(27, 25, 100, '2026-02-18', 'Entrada'),
(28, 26, 12, '2026-03-01', 'Entrada'),
(29, 27, 8, '2026-03-05', 'Entrada'),
(30, 28, 60, '2026-03-10', 'Entrada'),
(31, 29, 40, '2026-03-15', 'Entrada'),
(32, 30, 70, '2026-03-20', 'Entrada'),
(33, 31, 55, '2026-03-25', 'Entrada'),
(34, 32, 90, '2026-04-02', 'Entrada'),
(36, 34, 6, '2026-04-10', 'Entrada'),
(37, 35, 3, '2026-04-12', 'Entrada'),
(38, 18, 5, '2026-04-18', 'Saída'),
(39, 20, 12, '2026-04-25', 'Saída'),
(40, 48, 3, '2026-05-27', 'Entrada'),
(41, 48, 3, '2026-05-27', 'Entrada'),
(42, 48, 3, '2026-05-27', 'Entrada');

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
(1, 15, '2026-01-05', 4200.00, 'Bancada de cozinha com ilha', 'Polido', 1, 'Cuba Gourmet Inox', 'Reta', '10cm', '2026-01-25', 'Aprovado'),
(2, 16, '2026-01-08', 2850.00, 'Lavabo planejado', 'Escovado', 2, 'Cuba Esculpida', 'Reta', '8cm', '2026-01-28', 'Finalizado'),
(3, 17, '2026-01-10', 5100.00, 'Cozinha completa em quartzo', 'Polido', 3, 'Cuba Gourmet Inox', 'Dupla', '12cm', '2026-02-05', 'Aprovado'),
(4, 18, '2026-01-15', 1900.00, 'Pia simples para área gourmet', 'Fosco', 4, 'Cuba Simples', 'Reta', '6cm', '2026-02-02', 'Aberto'),
(5, 19, '2026-01-20', 7600.00, 'Escada em mármore', 'Polido', 6, NULL, 'Reta', '5cm', '2026-02-20', 'Aprovado'),
(6, 20, '2026-01-25', 3300.00, 'Bancada de banheiro', 'Levigado', 5, 'Cuba Esculpida', 'Reta', '7cm', '2026-02-15', 'Finalizado'),
(7, 21, '2026-02-02', 9800.00, 'Área gourmet completa', 'Polido', 8, 'Cuba Gourmet Inox', 'Dupla', '15cm', '2026-03-01', 'Aprovado'),
(8, 22, '2026-02-04', 2500.00, 'Nichos decorativos', 'Fosco', 4, NULL, 'Reta', '4cm', '2026-02-22', 'Cancelado'),
(9, 23, '2026-02-10', 6200.00, 'Balcão para cozinha americana', 'Polido', 7, 'Cuba Gourmet Inox', 'Curva', '10cm', '2026-03-03', 'Finalizado'),
(10, 24, '2026-02-14', 14200.00, 'Projeto completo de cozinha', 'Polido', 10, 'Cuba Gourmet Inox', 'Dupla', '18cm', '2026-03-20', 'Aprovado'),
(11, 25, '2026-02-18', 3100.00, 'Lavatório em mármore', 'Escovado', 2, 'Cuba Esculpida', 'Reta', '6cm', '2026-03-05', 'Aberto'),
(12, 26, '2026-02-22', 4700.00, 'Bancada gourmet externa', 'Fosco', 5, 'Cuba Inox', 'Reta', '8cm', '2026-03-15', 'Aprovado'),
(13, 27, '2026-03-01', 8900.00, 'Revestimento de escada', 'Polido', 9, NULL, 'Reta', '5cm', '2026-03-28', 'Finalizado'),
(14, 28, '2026-03-05', 5300.00, 'Pia dupla de cozinha', 'Levigado', 3, 'Cuba Gourmet Inox', 'Dupla', '12cm', '2026-03-30', 'Aprovado'),
(15, 29, '2026-03-08', 2200.00, 'Mesa em granito', 'Polido', 1, NULL, 'Reta', '4cm', '2026-03-25', 'Finalizado'),
(16, 30, '2026-03-12', 6800.00, 'Bancadas para escritório', 'Escovado', 7, NULL, 'Reta', '7cm', '2026-04-05', 'Aberto'),
(17, 31, '2026-03-18', 3950.00, 'Lavanderia planejada', 'Fosco', 4, 'Tanque Inox', 'Reta', '6cm', '2026-04-08', 'Aprovado'),
(18, 32, '2026-03-22', 11200.00, 'Cozinha premium', 'Polido', 8, 'Cuba Gourmet Inox', 'Tripla', '20cm', '2026-04-20', 'Finalizado'),
(19, 33, '2026-04-02', 2600.00, 'Bancada de banheiro simples', 'Levigado', 5, 'Cuba Esculpida', 'Reta', '5cm', '2026-04-25', 'Cancelado'),
(20, 34, '2026-04-05', 7400.00, 'Projeto de churrasqueira', 'Polido', 1, 'Cuba Gourmet Inox', 'Dupla', '14cm', '2026-05-02', 'Aprovado'),
(21, 35, '2026-05-02', 4850.00, 'Bancada em L para cozinha', 'Polido', 3, 'Cuba Gourmet Inox', 'Dupla', '10cm', '2026-05-25', 'Aprovado'),
(22, 36, '2026-05-04', 3200.00, 'Lavatório planejado', 'Escovado', 2, 'Cuba Esculpida', 'Reta', '6cm', '2026-05-20', 'Finalizado'),
(23, 37, '2026-05-06', 9100.00, 'Área gourmet externa completa', 'Polido', 8, 'Cuba Gourmet Inox', 'Tripla', '15cm', '2026-06-02', 'Aprovado'),
(24, 38, '2026-05-08', 2700.00, 'Mesa de jantar em granito', 'Fosco', 1, NULL, 'Reta', '4cm', '2026-05-28', 'Aberto'),
(36, 39, '2026-05-27', 2500.00, 'balcão de 2,5', 'polido', 6, NULL, NULL, '15', '2026-06-16', 'Cancelado'),
(37, 40, '2026-05-27', 5500.00, 'balcão de 4,5', 'polido', 6, NULL, NULL, '15', '2026-06-17', 'Aprovado'),
(38, 41, '2026-05-27', 5500.00, 'balcão', 'polido', 10, NULL, NULL, '15', '2026-06-17', 'Aberto'),
(39, 39, '2026-05-27', 2500.00, 'balcão de 2,5', 'polido', 10, NULL, NULL, '15', '2026-06-16', 'Aprovado');

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
(11, 14, '2026-03-06', '2026-03-28', 2700.00, 2600.00),
(12, 15, '2026-03-09', '2026-03-20', 1200.00, 1000.00),
(13, 16, '2026-03-13', '2026-04-02', 3400.00, 3400.00),
(14, 17, '2026-03-19', '2026-04-05', 2000.00, 1950.00),
(15, 18, '2026-03-23', '2026-04-18', 6000.00, 5200.00),
(16, 19, '2026-04-03', '2026-04-20', 1300.00, 1300.00),
(17, 20, '2026-04-06', '2026-04-28', 3800.00, 3600.00),
(18, 4, '2026-01-16', '2026-01-30', 950.00, 950.00),
(19, 8, '2026-02-05', '2026-02-18', 1250.00, 1250.00),
(20, 11, '2026-02-19', '2026-03-02', 1600.00, 1500.00),
(21, 21, '2026-05-03', '2026-05-22', 2500.00, 2350.00),
(22, 22, '2026-05-05', '2026-05-18', 1700.00, 1500.00),
(23, 23, '2026-05-07', '2026-05-30', 5000.00, 4100.00),
(24, 24, '2026-05-09', '2026-05-26', 1400.00, 1300.00),
(30, 36, '2026-05-27', '0000-00-00', 1750.00, 0.00),
(31, 37, '2026-05-28', NULL, 5750.00, NULL),
(32, 38, '2026-05-28', NULL, 5750.00, NULL),
(33, 39, '2026-05-27', NULL, 1750.00, NULL);

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
(4, 'Granito Preto São Gabriel', 'Pedra polida', 350.00, 1750.00),
(5, 'Granito Verde Ubatuba', 'Granito verde escuro resistente', 240.00, 1200.00),
(6, 'Mármore Travertino', 'Mármore bege clássico', 330.00, 1650.00),
(7, 'Quartzo Cinza', 'Quartzo moderno para cozinhas', 310.00, 1550.00),
(8, 'Granito Preto Absoluto', 'Granito premium preto intenso', 420.00, 2100.00),
(9, 'Nano Glass', 'Superfície branca sofisticada', 520.00, 2600.00),
(10, 'Dekton Sirius', 'Superfície ultracompacta preta', 610.00, 3050.00);

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
(6, 3, 'Parafuso e Bucha', 'Conjunto para fixação de peças de mármore', 12.00),
(8, 4, 'Pasta de Polimento', 'Pasta abrasiva para polimento de superfícies', 40.00),
(13, 3, 'Silicone Incolor', 'Silicone utilizado para vedação e fixação', 22.00),
(15, 4, 'Lixa Diamantada', 'Lixa especial para acabamento em mármore e granito', 35.00),
(17, 5, 'Cuba Inox Luxo', 'Cuba de embutir', 260.00),
(18, 1, 'Disco Turbo Diamantado', 'Disco de alta precisão para corte', 189.90),
(19, 1, 'Serra Copo Diamantada', 'Serra para perfuração em pedras', 129.50),
(20, 2, 'Selador Impermeabilizante', 'Proteção contra manchas', 89.90),
(21, 2, 'Pasta de Polimento Premium', 'Acabamento brilhante', 64.90),
(22, 3, 'Parafuso Inox 8mm', 'Fixação de estruturas', 1.80),
(23, 3, 'Suporte Metálico Reforçado', 'Suporte para bancadas', 38.90),
(24, 4, 'Lixa D\'Água 400', 'Lixa para acabamento fino', 6.50),
(25, 4, 'Lixa D\'Água 1200', 'Lixa superfina para polimento', 8.90),
(26, 5, 'Cuba Gourmet Inox 70cm', 'Cuba de cozinha gourmet', 649.90),
(27, 5, 'Cuba Esculpida Branca', 'Cuba elegante para banheiro', 520.00),
(28, 6, 'Limpa Mármore Concentrado', 'Produto de limpeza profissional', 42.50),
(29, 6, 'Removedor de Manchas', 'Remove manchas em granito', 58.90),
(30, 7, 'Cantoneira Alumínio', 'Estrutura de apoio metálica', 24.90),
(31, 7, 'Perfil de Acabamento', 'Perfil metálico decorativo', 34.50),
(32, 8, 'Cola PU Extra Forte', 'Fixação de pedras e cubas', 49.90),
(34, 9, 'Politriz Angular', 'Equipamento para polimento', 589.00),
(35, 9, 'Cortadora Elétrica', 'Máquina de corte profissional', 2890.00),
(36, 10, 'Luva Anticorte', 'Proteção para manuseio', 29.90),
(37, 10, 'Óculos de Segurança', 'Proteção ocular profissional', 18.90),
(38, 11, 'Rodapé em Granito', 'Acabamento decorativo', 120.00),
(39, 11, 'Nicho Decorativo', 'Nicho em pedra natural', 280.00),
(40, 2, 'Resina Cristal', 'Resina para acabamento brilhante', 74.90),
(41, 4, 'Esponja Abrasiva', 'Acabamento de superfícies', 12.50),
(42, 3, 'Bucha de Fixação', 'Fixação para instalação', 2.50),
(48, 2, 'Lixa 900', 'lixa d\'agua pra preparação e nivelamento', 10.00),
(49, 2, 'Lixa 400', 'lixa d\'agua pra preparação e nivelamento', 10.00);

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
(1, 1, 1, '2026-01-06', 4200.00),
(2, 2, 2, '2026-01-09', 2850.00),
(3, 3, 1, '2026-01-12', 5100.00),
(4, 5, 2, '2026-01-22', 7600.00),
(5, 6, 1, '2026-01-27', 3300.00),
(6, 7, 2, '2026-02-05', 9800.00),
(7, 9, 1, '2026-02-11', 6200.00),
(8, 10, 2, '2026-02-16', 14200.00),
(9, 12, 1, '2026-02-24', 4700.00),
(10, 13, 2, '2026-03-02', 8900.00),
(11, 21, 1, '2026-05-03', 4850.00),
(12, 22, 2, '2026-05-05', 3200.00),
(13, 23, 1, '2026-05-07', 9100.00),
(53, 36, 2, '2026-05-27', 2500.00),
(54, 37, 1, '2026-05-27', 5500.00),
(55, 38, 2, '2026-05-27', 5500.00),
(56, 39, 2, '2026-05-27', 2500.00);

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
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de tabela `cliente`
--
ALTER TABLE `cliente`
  MODIFY `cd_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT de tabela `estoque`
--
ALTER TABLE `estoque`
  MODIFY `id_estoque` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de tabela `movimentacao_estoque`
--
ALTER TABLE `movimentacao_estoque`
  MODIFY `id_movimentacao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT de tabela `orcamento`
--
ALTER TABLE `orcamento`
  MODIFY `id_orcamento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT de tabela `pagamento`
--
ALTER TABLE `pagamento`
  MODIFY `id_pagamento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de tabela `pedra`
--
ALTER TABLE `pedra`
  MODIFY `id_pedra` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `produto`
--
ALTER TABLE `produto`
  MODIFY `id_produto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `venda`
--
ALTER TABLE `venda`
  MODIFY `id_venda` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

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
