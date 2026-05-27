<div align="center">

<img src="https://img.shields.io/badge/Projeto%20de%20Extens%C3%A3o-DSM%202%C2%BA%20Semestre-0d1b2a?style=for-the-badge&labelColor=0d1b2a&color=4e9e9e" />
<img src="https://img.shields.io/badge/FATEC-Praia%20Grande-0d1b2a?style=for-the-badge&labelColor=0d1b2a&color=1a3a5c" />
<img src="https://img.shields.io/badge/2026-Ciclo%20II-0d1b2a?style=for-the-badge&labelColor=0d1b2a&color=6c8ebf" />

<br>

# 🪨 Marmoraria Nova Canaã

### Sistema de Gestão Integrado - Projeto Integrador Ciclo II

*Desenvolvimento de Software Multiplataforma · FATEC Praia Grande*

<br />

[![PHP](https://img.shields.io/badge/PHP_8.0-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://www.php.net/)
[![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://www.mysql.com/)
[![MariaDB](https://img.shields.io/badge/MariaDB_10.4-003545?style=for-the-badge&logo=mariadb&logoColor=white)](https://mariadb.org/)
[![HTML5](https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white)](https://developer.mozilla.org/pt-BR/docs/Web/HTML)
[![CSS3](https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white)](https://developer.mozilla.org/pt-BR/docs/Web/CSS)
[![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)](https://developer.mozilla.org/pt-BR/docs/Web/JavaScript)
[![XAMPP](https://img.shields.io/badge/XAMPP-F37623?style=for-the-badge&logo=xampp&logoColor=white)](https://www.apachefriends.org/)

<br />

[![Slides](https://img.shields.io/badge/🎨_Apresentação-Canva-00C4CC?style=for-the-badge)](https://canva.link/kmpega1aa24lcdk)
[![Relatório](https://img.shields.io/badge/📄_Relatório_Técnico-Google_Docs-4285F4?style=for-the-badge)](https://docs.google.com/document/d/17L3Zqg331bdQRjyOCTHz4DDb26GAySzY/edit?usp=sharing)
[![WhatsApp](https://img.shields.io/badge/📞_Nova_Canaã-WhatsApp-25D366?style=for-the-badge)](https://wa.me/5513997982047)

</div>

---

## 📋 Sumário

- [Sobre o Projeto](#-sobre-o-projeto)
- [O Problema Real](#-o-problema-real)
- [A Solução](#-a-solução)
- [Funcionalidades](#-funcionalidades)
- [Arquitetura e Banco de Dados](#️-arquitetura-e-banco-de-dados)
- [Estrutura de Pastas](#-estrutura-de-pastas)
- [Tecnologias](#️-tecnologias)
- [Como Executar](#️-como-executar)
- [Documentação](#-documentação)
- [Equipe](#-equipe)
- [Contexto Acadêmico](#-contexto-acadêmico)

---

## 🏢 Sobre o Projeto

A **Marmoraria Nova Canaã** é uma empresa familiar de mármore e granito localizada em **Praia Grande, SP**. No dia a dia, ela gerencia orçamentos personalizados, pedidos de pedras, controle de materiais e agendamento de serviços — tudo isso dependendo de **anotações em papel e planilhas isoladas**, gerando erros e retrabalho constante.

Este sistema foi construído como **Projeto Integrador de Extensão do Ciclo II** do curso de **DSM na FATEC Praia Grande**, com o objetivo de digitalizar e centralizar 100% da operação da empresa em uma única plataforma web.

---

## 🔴 O Problema Real

> *"Cada orçamento era anotado num papel. Se o papel sumia, o pedido sumia junto."*

| # | Problema | Impacto |
|---|---|---|
| 1 | 📋 **Inconsistências nos Orçamentos** | Papel e planilhas diferentes geravam erros, retrabalho e perda de informações críticas |
| 2 | 💸 **Pagamentos sem Controle** | Sem rastreio de entrada e saldo, era impossível saber o que ainda estava em aberto |
| 3 | 📦 **Estoque no Escuro** | Sem histórico de movimentações, compras desnecessárias e falta de material na hora errada eram frequentes |
| 4 | 📅 **Agenda Dispersa** | Visitas e entregas não tinham ligação com os pedidos, gerando desencontros e atrasos |

---

## ✅ A Solução

Um sistema interno completo com **site institucional + painel de gestão**, integrando todos os processos da marmoraria:

```
Centralizar  →  Digitalizar  →  Automatizar  →  Monitorar  →  Controlar
```

| Objetivo | Como foi implementado |
|---|---|
| 🎯 **Centralizar** | Uma única plataforma acessível por toda a equipe |
| ⚙️ **Automatizar** | Triggers no banco geram vendas e atualizam estoque sem intervenção humana |
| 📊 **Monitorar** | Dashboard com KPIs carregados via Fetch API em tempo real |
| 🔒 **Controlar** | Dois perfis de acesso — Administrador e Vendedor — com permissões distintas |

---

## 🚀 Funcionalidades

### 🔐 Login e Controle de Acesso

Autenticação com `password_verify()`, sessões PHP e opção de "lembrar e-mail" via cookie de 7 dias. O `AuthController` protege todas as rotas redirecionando para o login caso não haja sessão ativa.

```php
// AuthController.php — Destrói a sessão mas mantém o cookie para preencher o e-mail
public function logout(): void {
    session_unset();
    session_destroy();
    header('Location: Login.php');
}
```

| Perfil | Acesso |
|---|---|
| 👑 **Administrador** | Dashboard completo · Orçamentos · Estoque · Relatórios · Usuários |
| 🧑‍💼 **Vendedor** | Orçamentos · Estoque · Agenda · Consulta de pedras e produtos |

---

### 📊 Dashboard com KPIs em Tempo Real

O dashboard consome uma **API JSON interna** (`getDashboardData.php`) via Fetch, populando os indicadores sem recarregar a página. Os dados são calculados direto no banco com queries otimizadas.

```
┌─────────────────┐  ┌─────────────────┐  ┌─────────────────┐  ┌─────────────────┐
│  Orçamentos     │  │  Faturamento    │  │  Produtos em    │  │  Compromissos   │
│  Ativos         │  │  do Mês (R$)    │  │  Estoque        │  │  Hoje           │
│                 │  │                 │  │  ⚠ badge baixo  │  │                 │
└─────────────────┘  └─────────────────┘  └─────────────────┘  └─────────────────┘
```

Além dos KPIs, o painel exibe:
- 📈 Gráfico de **faturamento dos últimos 6 meses**
- 🪨 **Top 3 pedras mais vendidas** com percentual
- 📋 **Últimos 4 orçamentos** com status e valor
- 💼 **Comissão por vendedor** calculada automaticamente

---

### 📝 Orçamentos

Módulo central do sistema. Cada orçamento registra cliente, pedra, acabamento, cuba, saia, vista, valor total e datas de pedido e entrega.

**Ciclo de vida completo:**

```
  ┌─────────┐     aprova      ┌──────────┐    conclui    ┌────────────┐
  │  Aberto │ ─────────────► │ Aprovado │ ────────────► │ Finalizado │
  └─────────┘                └──────────┘               └────────────┘
       │                          │
       │ cancela                  │ [TRIGGER gerar_venda dispara]
       ▼                          ▼
  ┌───────────┐            Registro inserido
  │ Cancelado │            automaticamente em
  └───────────┘            tabela `venda`
```

- Badges coloridos por status na listagem (`badge-aberto`, `badge-aprovado`, etc.)
- Modal de detalhe com strip de valor, metadados e histórico de pagamento
- Filtros por status, cliente e período
- Criação automática do cadastro de cliente se o telefone ainda não existir

---

### 🪨 Pedras

Catálogo de pedras com descrição, preço de compra e preço de venda calculado automaticamente pelo banco.

```sql
-- TRIGGER calcular_venda_pedra
-- BEFORE INSERT ON pedra
SET NEW.vl_venda_pedra = NEW.vl_compra_pedra * 5;
```

> Ao cadastrar uma pedra com valor de compra de `R$ 200,00`, o sistema já define automaticamente o preço de venda como `R$ 1.000,00` — sem digitar nada a mais.

**Pedras disponíveis no catálogo:**

| Pedra | Compra | Venda |
|---|---|---|
| Granito Verde Ubatuba | R$ 110,00 | R$ 550,00 |
| Granito Preto Absoluto | R$ 420,00 | R$ 2.100,00 |
| Dekton Sirius | R$ 610,00 | R$ 3.050,00 |
| Nano Glass | R$ 520,00 | R$ 2.600,00 |
| ... | ... | ... |

---

### 📦 Estoque

Controle de produtos (ferramentas, insumos, cubas, EPIs etc.) organizados em **11 categorias**. O saldo é gerenciado automaticamente por trigger — nenhuma atualização manual necessária.

```sql
-- TRIGGER atualizar_estoque
-- AFTER INSERT ON movimentacao_estoque
IF NEW.tp_movimentacao = 'Entrada' THEN
    UPDATE estoque SET qt_estoque = qt_estoque + NEW.qt_movimentacao ...
ELSEIF NEW.tp_movimentacao = 'Saída' THEN
    UPDATE estoque SET qt_estoque = qt_estoque - NEW.qt_movimentacao ...
END IF;
```

**Alertas automáticos:**
- A view `vw_estoque_baixo` retorna todos os produtos com `qt_estoque < 5`
- O Dashboard exibe um badge de atenção no KPI de estoque quando há itens críticos

**Categorias cadastradas:** Ferramentas · Insumos de Acabamento · Fixação e Instalação · Consumíveis · Cubas · Limpeza · Ferragens · Adesivos · Equipamentos Elétricos · EPIs · Acessórios Decorativos

---

### 💳 Pagamentos

Cada orçamento possui um registro de pagamento vinculado com controle de **entrada** e **saldo restante**:

| Campo | Descrição |
|---|---|
| `vl_pagamento_entrada` | Sinal pago no momento do pedido |
| `dt_pagamento_entrada` | Data do sinal |
| `vl_pagamento_saida` | Valor pago na entrega |
| `dt_pagamento_saida` | Data do pagamento final |

O saldo restante é calculado na camada de apresentação: `vl_total − vl_pagamento_entrada`.

---

### 📅 Agenda

Compromissos de visita, medição e entrega vinculados ao cliente e ao orçamento, com controle de status (`Pendente` / `Concluído`) e listagem por data.

```php
// Agenda.php — constantes para evitar "números mágicos"
const STATUS_PENDENTE  = 1;
const STATUS_CONCLUIDO = 0;

// Lista apenas os compromissos de um dia específico, ordenados por hora
public function listarPorData($data): array { ... }

// Marca um compromisso como concluído
public function marcarComoConcluido(): bool { ... }
```

A view `vw_agendamentos_proximos` retorna automaticamente os orçamentos com entrega nos **próximos 7 dias**, alimentando o painel do dashboard.

---

### 📈 Relatórios *(exclusivo Administrador)*

Módulo restrito ao perfil Administrador. Permite filtrar o histórico de vendas por **período** e **status**, visualizar faturamento e exportar os dados em **PDF**.

Baseado na view `vw_vendas_periodo`:

```sql
SELECT o.id_orcamento, c.nm_cliente, o.dt_pedido, o.vl_total, o.st_orcamento
FROM orcamento o
JOIN cliente c ON c.cd_cliente = o.cd_cliente;
```

---

## 🗄️ Arquitetura e Banco de Dados

### Diagrama de Tabelas

```
cliente ──────────────────────────────┐
                                      │
usuario ──► vendedor ──► venda ◄── orcamento ──► pagamento
                                      │       ◄── agenda
                                      │
                            pedra ◄───┘
                            
produto ──► categoria_produto
produto ──► estoque ◄── movimentacao_estoque
```

### 12 Tabelas

```
agenda              categoria_produto     cliente
estoque             movimentacao_estoque  orcamento
pagamento           pedra                 produto
usuario             venda                 vendedor
```

### 3 Triggers

| Trigger | Evento | O que faz |
|---|---|---|
| `calcular_venda_pedra` | `BEFORE INSERT ON pedra` | `vl_venda = vl_compra × 5` automático |
| `gerar_venda` | `AFTER UPDATE ON orcamento` | Insere em `venda` quando status → `'Aprovado'` |
| `atualizar_estoque` | `AFTER INSERT ON movimentacao_estoque` | Soma ou subtrai `qt_estoque` conforme tipo |

### 4 Views

| View | Finalidade |
|---|---|
| `vw_estoque_baixo` | Produtos com `qt_estoque < 5` → alerta no dashboard |
| `vw_agendamentos_proximos` | Entregas nos próximos 7 dias |
| `vw_orcamento_aberto` | Todos os orçamentos com status `'Aberto'` |
| `vw_vendas_periodo` | Histórico completo de vendas com dados do cliente |

### Padrão de Arquitetura — MVC + Interfaces

```
back/
├── interfaces/
│   ├── ICrud.php          → salvar · atualizar · deletar · buscarPorId · listarTodos
│   ├── IAutenticavel.php  → autenticar · logout · temPermissao
│   ├── IRelatorio.php     → gerarRelatorio · filtrarPorPeriodo · exportar
│   └── INotificavel.php
│
├── models/
│   └── Model.php (abstract)  → implements ICrud
│       └── Orcamento.php     → extends Model, implements IRelatorio
│       └── Usuario.php       → implements IAutenticavel
│       └── ... (demais models)
│
└── controller/
    └── [Entidade]Controller.php  → orquestra Model + resposta JSON/redirect
```

---

## 📂 Estrutura de Pastas

```
Projeto-Integrador-Ciclo-II/
│
├── back/
│   ├── config/
│   │   └── database.php                   # Conexão PDO centralizada
│   ├── controller/
│   │   ├── AuthController.php             # Login, logout, verificação de sessão e cookie
│   │   ├── OrcamentoController.php        # CRUD de orçamentos + pagamento + venda
│   │   ├── EstoqueController.php
│   │   ├── MovimentacaoEstoqueController.php
│   │   ├── ProdutoController.php
│   │   ├── CategoriaProdutoController.php
│   │   └── UsuarioController.php
│   ├── interfaces/
│   │   ├── ICrud.php                      # Contrato CRUD base
│   │   ├── IAutenticavel.php              # Contrato de autenticação
│   │   ├── IRelatorio.php                 # gerarRelatorio · filtrarPorPeriodo · exportar
│   │   └── INotificavel.php
│   ├── models/
│   │   ├── Model.php                      # Base abstrata com PDO + CRUD genérico
│   │   ├── Orcamento.php                  # implements IRelatorio
│   │   ├── Usuario.php                    # implements IAutenticavel
│   │   ├── Agenda.php                     # STATUS_PENDENTE · STATUS_CONCLUIDO · listarPorData
│   │   ├── Estoque.php                    # buscarSaldoPorProduto · listarTodos (com JOIN)
│   │   ├── Pedra · Produto · Cliente
│   │   ├── Pagamento · Venda · Vendedor
│   │   ├── MovimentacaoEstoque · CategoriaProduto
│   │   ├── Pessoa.php                     # Classe base para Cliente/Vendedor
│   │   └── RegistroFinanceiro.php
│   └── tests/
│       ├── teste_crud.php
│       └── teste_sistema_completo.php
│
├── banco/
│   └── database/
│       └── marmoraria_db.sql              # Script completo: tabelas · triggers · views · seeds
│
└── front/
    ├── api/
    │   └── getDashboardData.php           # API JSON: KPIs · faturamento · pedras · vendedores
    ├── assets/
    │   ├── css/                           # Design system com CSS custom properties (tokens)
    │   │   ├── base.css · dashboard.css · login.css
    │   │   ├── orc.css · norc.css · agenda.css
    │   │   └── relatorio.css · perfil.css
    │   └── favicon.ico
    ├── public/css/                        # Estilos alternativos por página
    └── view/
        ├── Login.php · Dashboard.php
        ├── Orcamentos.php · NovoOrcamento.php
        ├── Estoque.php · MovimentacoesEstoque.php
        ├── Agenda.php · Relatorio.php
        ├── Produtos.php · Categorias.php · Perfil.php
        ├── index.html                     # Site institucional
        ├── includes/
        │   ├── layout.php                 # Sidebar e estrutura global
        │   ├── usuario.php                # Verificação de sessão + dados do usuário logado
        │   ├── filtrosOrcamento.php       # Lógica de filtro e paginação
        │   └── ...
        └── gerar/
            └── criarUmUsuario.php
```

---

## 🛠️ Tecnologias

| Camada | Tecnologia | Detalhes |
|---|---|---|
| **Back-end** | PHP 8.0 | MVC · Sessões · Cookies · PDO · API JSON |
| **Banco de Dados** | MariaDB 10.4 | 12 tabelas · 3 triggers · 4 views · Integridade referencial |
| **Front-end** | HTML5 + CSS3 + JS | CSS tokens · Fetch API · Gráficos dinâmicos · Modais |
| **Ambiente** | XAMPP | Apache 2.4 · phpMyAdmin · PHP built-in |
| **Segurança** | PDO Prepared Statements | Proteção contra SQL Injection · `password_hash` / `password_verify` |
| **Padrão** | MVC + Interfaces | `ICrud` · `IAutenticavel` · `IRelatorio` · `INotificavel` |
| **Versionamento** | Git + GitHub | Branches: `back` · `front` · `banco` · `testefinal` · `main` |

---

## ⚙️ Como Executar

### Pré-requisitos

- [XAMPP](https://www.apachefriends.org/) com **Apache** e **MySQL** ativos
- PHP 8.0+

### Passo a passo

```bash
# 1. Clone o repositório
git clone https://github.com/Carlosjun1or/Projeto-Integrador-Ciclo-II.git

# 2. Mova para a pasta do servidor
#    Windows → C:\xampp\htdocs\
#    Linux   → /opt/lampp/htdocs/
```

```sql
-- 3. No phpMyAdmin, crie o banco e importe o script
-- Arquivo: banco/database/marmoraria_db.sql
-- Isso cria todas as tabelas, triggers, views e insere os dados de exemplo
```

```php
// 4. Verifique as credenciais em back/config/database.php
$host   = 'localhost';
$dbname = 'marmoraria_db';
$user   = 'root';
$pass   = '';
```

```
5. Acesse no navegador:
   http://localhost/Projeto-Integrador-Ciclo-II/front/view/Login.php
```

### Credenciais de Teste

| Perfil | E-mail | Senha |
|---|---|---|
| 👑 Administrador | `admin@marmoraria.com` | `admin123` |
| 🧑‍💼 Vendedor | `ricardo.mendes@marmoraria.com` | `vendedor123` |

---

## 📚 Documentação

<div align="center">

| | Documento | Descrição |
|---|---|---|
| 🎨 | [**Apresentação — Canva**](https://canva.link/kmpega1aa24lcdk) | Slides da apresentação do projeto com empresa, problema, solução, diagrama e fluxos |
| 📄 | [**Relatório Técnico — Google Docs**](https://docs.google.com/document/d/17L3Zqg331bdQRjyOCTHz4DDb26GAySzY/edit?usp=sharing) | Relatório completo do Projeto Integrador II — Nova Canaã |

</div>

---

## 👥 Equipe

<div align="center">

| Nome | GitHub | Contribuições |
|---|---|---|
| **Carlos Roberto** | [@Carlosjun1or](https://github.com/Carlosjun1or) | Back-end · Models · Views · Controllers · MVC · Front-end · Apresentação |
| **Carolina Ribeiro** | [@caroldvlribeiro](https://github.com/caroldvlribeiro) | Banco de Dados · Back-end · Models · Views · Controllers · MVC · Apresentação · Documentação |
| **Danilo** | [@niludev02](https://github.com/niludev02) | Front-end · Design · API · Apresentação |
| **Rubia** | [@rubiaturci](https://github.com/rubiaturci) | Back-end · Controllers · Views · Documentação · Apresentação |
| **Isabela** | — | Documentação · Apresentação |

</div>

---

## 🎓 Contexto Acadêmico

Este sistema é um **Projeto Integrador de Extensão** — uma modalidade que vai além da sala de aula, aplicando os conhecimentos do semestre na resolução de um problema real de uma empresa da comunidade local.

As disciplinas integradas neste Ciclo II:

| Disciplina | Aplicação no Projeto |
|---|---|
| **Desenvolvimento Web 2** | Arquitetura MVC · PHP orientado a objetos · Sessões · Cookies · Fetch API |
| **Banco de Dados** | Modelagem relacional · Triggers · Views · Integridade referencial · Queries avançadas |
| **Engenharia de Software II** | Documentação · Fluxo de sistema · Boas práticas · Controle de versão por branches |
| **Técnicas de Programação** | Interfaces · Classes abstratas · Herança (`Pessoa → Cliente/Vendedor`) · Polimorfismo |

> *"Não basta aprender a programar. É preciso programar para transformar."*

---

<div align="center">

**DSM 2º Semestre · FATEC Praia Grande · 2026**

[![WhatsApp Nova Canaã](https://img.shields.io/badge/📞_Marmoraria_Nova_Canaã_(13)_99798--2047-25D366?style=for-the-badge&logo=whatsapp&logoColor=white)](https://wa.me/5513997982047)

</div>