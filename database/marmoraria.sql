CREATE DATABASE marmoraria_db;

USE marmoraria_db;

-- CLIENTE
CREATE TABLE cliente (
    cd_cliente INT AUTO_INCREMENT PRIMARY KEY,
    nm_cliente VARCHAR(255) NOT NULL,
    cd_telefone VARCHAR(20),
    nm_endereco VARCHAR(255)
);

-- PEDRA
CREATE TABLE pedra(
    id_pedra INT AUTO_INCREMENT PRIMARY KEY,
    nm_pedra VARCHAR(255) NOT NULL,
    ds_pedra TEXT NOT NULL,
    vl_compra_pedra DECIMAL(10, 2) NOT NULL,
    vl_venda_pedra DECIMAL(10, 2) NOT NULL
);

-- CATEGORIA PRODUTO 
CREATE TABLE categoria_produto(
    id_categoria INT AUTO_INCREMENT PRIMARY KEY,
    nm_categoria VARCHAR(50) NOT NULL,
    ds_categoria TEXT NOT NULL
);

-- PRODUTO
CREATE TABLE produto(
    id_produto INT AUTO_INCREMENT PRIMARY KEY,
    id_categoria INT NOT NULL,
    nm_produto VARCHAR(255) NOT NULL,
    ds_produto TEXT NOT NULL,
    vl_produto DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (id_categoria) REFERENCES categoria_produto(id_categoria)
);

-- ESTOQUE
CREATE TABLE estoque(
    id_estoque INT AUTO_INCREMENT PRIMARY KEY,
    id_produto INT NOT NULL,
    qt_estoque INT NOT NULL,
    dt_atualizacao DATE NOT NULL DEFAULT CURRENT_DATE,
    FOREIGN KEY (id_produto) REFERENCES produto(id_produto)
);

-- MOVIMENTAÇÃO DE ESTOQUE
CREATE TABLE movimentacao_estoque(
    id_movimentacao INT AUTO_INCREMENT PRIMARY KEY,
    id_produto INT NOT NULL,
    qt_movimentacao INT NOT NULL,
    dt_movimentacao DATE NOT NULL DEFAULT CURRENT_DATE,
    tp_movimentacao ENUM('Entrada', 'Saída') NOT NULL,
    FOREIGN KEY (id_produto) REFERENCES produto(id_produto)
); 

-- ORÇAMENTO 
CREATE TABLE orcamento (
    id_orcamento INT AUTO_INCREMENT PRIMARY KEY,
    cd_cliente INT NOT NULL,
    dt_pedido DATE NOT NULL DEFAULT CURRENT_DATE,
    vl_total DECIMAL(10, 2) NOT NULL,
    ds_descricao TEXT NOT NULL,
    acabamento VARCHAR(30) NOT NULL,
    id_pedra INT NOT NULL,
    nm_cuba VARCHAR(30) NULL,
    vista VARCHAR(30) NULL,
    saia VARCHAR(30) NULL,
    dt_entrega DATE,
    st_orcamento ENUM('Aberto','Aprovado','Cancelado') NOT NULL DEFAULT 'Aberto',
    FOREIGN KEY (cd_cliente) REFERENCES cliente(cd_cliente),
    FOREIGN KEY (id_pedra) REFERENCES pedra(id_pedra)
);

-- PAGAMENTO
CREATE TABLE pagamento (
    id_pagamento INT AUTO_INCREMENT PRIMARY KEY,
    id_orcamento INT NOT NULL,
    dt_pagamento_entrada DATE NOT NULL DEFAULT CURRENT_DATE,
    dt_pagamento_saida DATE,
    vl_pagamento_entrada DECIMAL(10, 2) NOT NULL,
    vl_pagamento_saida DECIMAL(10, 2),
    FOREIGN KEY (id_orcamento) REFERENCES orcamento(id_orcamento)
);

-- AGENDA
CREATE TABLE agenda(
    id_agenda INT AUTO_INCREMENT PRIMARY KEY,
    id_orcamento INT NULL,
    cd_cliente INT NULL,
    dt_compromisso DATE NOT NULL DEFAULT CURRENT_DATE,
    hr_compromisso TIME NOT NULL,
    ds_compromisso VARCHAR(255) NOT NULL,
    st_compromisso TINYINT(1) NOT NULL DEFAULT 1,
    FOREIGN KEY (id_orcamento) REFERENCES orcamento(id_orcamento),
    FOREIGN KEY (cd_cliente) REFERENCES cliente(cd_cliente)
);

--USUÁRIO
create table usuario(
    id_usuario int auto_increment primary key,
    nm_usuario varchar(255) not null,
    cd_senha varchar(255) not null,
    tp_usuario enum('Administrador', 'Vendedor') not null
);

-- VENDEDOR
CREATE TABLE vendedor(
    id_vendedor INT AUTO_INCREMENT PRIMARY KEY,
    nm_vendedor VARCHAR(255) NOT NULL,
    cd_senha VARCHAR(255) NOT NULL,
    vl_comissao DECIMAL(5, 2) NOT NULL
);

-- VENDA
CREATE TABLE venda(
    id_venda INT AUTO_INCREMENT PRIMARY KEY,
    id_orcamento INT NOT NULL,
    id_vendedor INT NOT NULL,
    dt_venda DATE NOT NULL DEFAULT CURRENT_DATE,
    vl_total DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (id_orcamento) REFERENCES orcamento(id_orcamento),
    FOREIGN KEY (id_vendedor) REFERENCES vendedor(id_vendedor)
);