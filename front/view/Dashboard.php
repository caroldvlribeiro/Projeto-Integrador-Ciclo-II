<?php
    include './includes/usuario.php';
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Dashboard - Marmoraria</title>
    <link rel="stylesheet" href="../assets/css/base.css">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
</head>

<body>
    <div class="app">
      <header class="header">
        <div class="logo">
            <svg width="36" height="36" viewBox="0 0 80 80" xmlns="http://www.w3.org/2000/svg">
                <rect x="2"  y="2"  width="52" height="52" fill="none" stroke="#EFF2F4" stroke-width="1.5"/>
                <rect x="12" y="12" width="52" height="52" fill="none" stroke="#EFF2F4" stroke-width="1.5"/>
                <rect x="22" y="22" width="52" height="52" fill="none" stroke="#EFF2F4" stroke-width="1.5"/>
                <rect x="46" y="46" width="14" height="14" fill="#EFF2F4"/>
             </svg>
               <div class="title-header">
                     Nova Canaã
                    <small>Marmoraria</small>
                </div>  
            </div>

            <ul class="nav-links">
                <li><a href="Dashboard.php" class="active">Dashboard</a></li>
                <li><a href="Orcamentos.php">Orçamentos</a></li>
                <li><a href="Estoque.php">Estoque</a></li>
                <li><a href="Agenda.php">Agenda</a></li>
                <li><a href="Produtos.php">Produtos</a></li>
            </ul>

            <div class="user">
                <?= $_SESSION['email'] ?>
            </div>
        </header>

        <aside class="sidebar">
            <div class="nav-label">Menu</div>
            <a href="home.php"        class="nav-item active"><i class="ti ti-layout-dashboard"></i> Dashboard</a>
            <a href="Orcamentos.php"  class="nav-item"><i class="ti ti-file-text"></i> Orçamentos</a>
            <a href="NovoOrcamento.php" class="nav-item"><i class="ti ti-plus"></i> Novo Orçamento</a>
            <a href="Estoque.php"     class="nav-item"><i class="ti ti-stack"></i> Estoque</a>
            <a href="Agenda.php"      class="nav-item"><i class="ti ti-calendar"></i> Agenda</a>
            <a href="Produtos.php"    class="nav-item"><i class="ti ti-package"></i> Produtos</a>
        </aside>        

        <main>
            <header class="dashboard-header">
                <div class="welcome-text">
                    <h1>Painel de Controle</h1>
                    <p>Bem-vindo!</p>
                </div>
                <a href="Dashboard.php?acao=logout" class="logout-link">
                    <span>🚪 Sair do Sistema</span>
                </a>
            </header>

            <div class="kpi-grid">
                <div class="kpi">
                    <div class="kpi-top">
                        <div class="kpi-icon blue"><i class="ti ti-file-text" aria-hidden="true"></i></div>
                        <span class="kpi-trend up"><i class="ti ti-trending-up" aria-hidden="true"></i> +2</span>
                    </div>
                    <div class="kpi-val">8</div>
                    <div class="kpi-label">Orçamentos ativos</div>
                </div>
                <div class="kpi">
                    <div class="kpi-top">
                        <div class="kpi-icon green"><i class="ti ti-currency-dollar" aria-hidden="true"></i></div>
                        <span class="kpi-trend up"><i class="ti ti-trending-up" aria-hidden="true"></i> +12%</span>
                    </div>
                    <div class="kpi-val">R$ 9.000</div>
                    <div class="kpi-label">Faturamento do mês</div>
                </div>
                <div class="kpi">
                    <div class="kpi-top">
                        <div class="kpi-icon amber"><i class="ti ti-stack" aria-hidden="true"></i></div>
                        <span class="kpi-trend warn"><i class="ti ti-alert-triangle" aria-hidden="true"></i> 1 baixo</span>
                    </div>
                    <div class="kpi-val">8</div>
                    <div class="kpi-label">Produtos em estoque</div>
                </div>
                <div class="kpi">
                    <div class="kpi-top">
                        <div class="kpi-icon purple"><i class="ti ti-calendar" aria-hidden="true"></i></div>
                        <span class="kpi-trend up">hoje</span>
                    </div>
                    <div class="kpi-val">4</div>
                    <div class="kpi-label">Compromissos hoje</div>
                </div>
            </div>

            <div class="quick-actions">
                <a href="NovoOrcamento.php" class="btn-action">
                    <i>+</i> Novo Orçamento
                </a>
            </div>

            <div class="dashboard-grid">
                <a href="Orcamentos.php" class="stat-card">
                    <div class="stat-icon">📋</div>
                    <div class="stat-content">
                        <h3>Orçamentos</h3>
                        <div class="value">Gerenciar</div>
                    </div>
                </a>
                <a href="Estoque.php" class="stat-card">
                    <div class="stat-icon">📦</div>
                    <div class="stat-content">
                        <h3>Estoque</h3>
                        <div class="value">Consultar</div>
                    </div>
                </a>
            </div>
            <div class="sec-label">Orçamentos & Pedras</div>

            <div class="grid-3">
                <div class="panel">
                    <div class="panel-head">
                        <div class="panel-title"><i class="ti ti-chart-bar" aria-hidden="true"></i> Faturamento por mês</div>
                    </div>
                    <div class="chart-area" id="chart"></div>
                </div>
                <div class="panel">
                    <div class="panel-head">
                        <div class="panel-title"><i class="ti ti-diamond" aria-hidden="true"></i> Pedras mais vendidas</div>
                    </div>
                    <div class="pedra-list">
                        <div class="pedra-row">
                            <div class="pedra-swatch" style="background:#2a2c2a;"></div>
                            <div class="pedra-info">
                                <div class="pedra-nome">Granito Verde Ubatuba</div>
                                <div class="pedra-bar-wrap"><div class="pedra-bar-fill" style="width:80%"></div></div>
                            </div>
                            <div class="pedra-pct">80%</div>
                        </div>
                        <div class="pedra-row">
                            <div class="pedra-swatch" style="background:#1a1c1a;"></div>
                            <div class="pedra-info">
                                <div class="pedra-nome">Granito Preto São Gabriel</div>
                                <div class="pedra-bar-wrap"><div class="pedra-bar-fill" style="width:60%"></div></div>
                            </div>
                            <div class="pedra-pct">60%</div>
                        </div>
                        <div class="pedra-row">
                            <div class="pedra-swatch" style="background:#ddd8d0;"></div>
                            <div class="pedra-info">
                                <div class="pedra-nome">Granito Branco Itaúnas</div>
                                <div class="pedra-bar-wrap"><div class="pedra-bar-fill" style="width:45%"></div></div>
                            </div>
                            <div class="pedra-pct">45%</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="sec-label">Estoque de produtos</div>

            <div class="panel" style="padding:var(--lg);">
                <div class="panel-head">
                    <div class="panel-title"><i class="ti ti-stack" aria-hidden="true"></i> Quantidade em estoque</div>
                    <span style="font-size:11px;color:#791F1F;display:flex;align-items:center;gap:4px;">
                        <i class="ti ti-alert-triangle" aria-hidden="true"></i> 1 produto com estoque baixo
                    </span>
                </div>
                <div class="estoque-grid" id="estoque-grid"></div>
            </div>

            <div class="sec-label">Produtos cadastrados</div>

            <div class="grid-2">
                <div class="panel">
                    <div class="panel-head">
                        <div class="panel-title"><i class="ti ti-tool" aria-hidden="true"></i> Ferramentas & Consumíveis</div>
                    </div>
                    <div class="prod-list" id="prod-ferr"></div>
                </div>
                <div class="panel">
                    <div class="panel-head">
                        <div class="panel-title"><i class="ti ti-package" aria-hidden="true"></i> Insumos & Fixação</div>
                    </div>
                    <div class="prod-list" id="prod-insu"></div>
                </div>
            </div>

            <div class="sec-label">Orçamentos</div>

            <div class="grid-2">
                <div class="panel">
                    <div class="panel-head">
                        <div class="panel-title"><i class="ti ti-file-text" aria-hidden="true"></i> Orçamentos recentes</div>
                    </div>
                    <div class="orc-list">
                        <div class="orc-row">
                            <div class="orc-info">
                                <div class="orc-cliente">João Silva</div>
                                <div class="orc-pedra">Granito Verde Ubatuba · Bancada</div>
                            </div>
                            <div class="orc-right">
                                <div class="orc-val">R$ 1.800</div>
                                <span class="badge aprovado">Aprovado</span>
                            </div>
                        </div>
                        <div class="orc-row">
                            <div class="orc-info">
                                <div class="orc-cliente">Maria Oliveira</div>
                                <div class="orc-pedra">Granito Preto São Gabriel · Bancada</div>
                            </div>
                            <div class="orc-right">
                                <div class="orc-val">R$ 2.500</div>
                                <span class="badge aberto">Aberto</span>
                            </div>
                        </div>
                        <div class="orc-row">
                            <div class="orc-info">
                                <div class="orc-cliente">Carlos Souza</div>
                                <div class="orc-pedra">Granito Branco Itaúnas · Ilha</div>
                            </div>
                            <div class="orc-right">
                                <div class="orc-val">R$ 3.200</div>
                                <span class="badge aprovado">Aprovado</span>
                            </div>
                        </div>
                        <div class="orc-row">
                            <div class="orc-info">
                                <div class="orc-cliente">Ana Costa</div>
                                <div class="orc-pedra">Granito Verde Ubatuba · Pia</div>
                            </div>
                            <div class="orc-right">
                                <div class="orc-val">R$ 1.500</div>
                                <span class="badge cancelado">Cancelado</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="display:flex;flex-direction:column;gap:var(--md);">
                    <div class="panel">
                        <div class="panel-head">
                            <div class="panel-title"><i class="ti ti-users" aria-hidden="true"></i> Vendedores</div>
                        </div>
                        <div class="vend-list">
                            <div class="vend-row">
                                <div class="vend-av" style="background:var(--cpd);">RM</div>
                                <div class="vend-info">
                                    <div class="vend-nome">Ricardo Mendes</div>
                                    <div class="vend-com">Comissão 5%</div>
                                </div>
                                <div class="vend-val">R$ 90</div>
                            </div>
                            <div class="vend-row">
                                <div class="vend-av" style="background:var(--ca);">FL</div>
                                <div class="vend-info">
                                    <div class="vend-nome">Fernanda Lima</div>
                                    <div class="vend-com">Comissão 6,5%</div>
                                </div>
                                <div class="vend-val">R$ 208</div>
                            </div>
                            <div class="vend-row">
                                <div class="vend-av" style="background:#3C3489;">BA</div>
                                <div class="vend-info">
                                    <div class="vend-nome">Bruno Almeida</div>
                                    <div class="vend-com">Comissão 4,75%</div>
                                </div>
                                <div class="vend-val">R$ 152</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <a href="Dashboard.php?acao=logout" class="logout-link">
                <span>🚪 Sair do Sistema</span>
            </a>
        </main>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">

<script>
// Fetch dados do backend
fetch('../api/getDashboardData.php')
  .then(r => r.json())
  .then(dados => {
    const kpi = dados.kpis;

    // 0. ATUALIZAR KPI CARDS
    // KPI 1 - Orçamentos ativos
    document.querySelectorAll('.kpi')[0].querySelector('.kpi-val').textContent = kpi.orcamentos_ativos;
    document.querySelectorAll('.kpi')[0].querySelector('.kpi-trend').innerHTML = `<i class="ti ti-trending-up" aria-hidden="true"></i> ${kpi.crescimento_orc > 0 ? '+' : ''}${kpi.crescimento_orc}%`;
    
    // KPI 2 - Faturamento do mês
    document.querySelectorAll('.kpi')[1].querySelector('.kpi-val').textContent = 'R$ ' + kpi.faturamento_mes.toLocaleString('pt-BR', {minimumFractionDigits: 2, maximumFractionDigits: 2});
    
    // KPI 3 - Produtos em estoque
    document.querySelectorAll('.kpi')[2].querySelector('.kpi-val').textContent = kpi.produtos_estoque;
    const trendProdutos = kpi.produtos_baixo > 0 ? `<i class="ti ti-alert-triangle" aria-hidden="true"></i> ${kpi.produtos_baixo} baixo` : 'OK';
    document.querySelectorAll('.kpi')[2].querySelector('.kpi-trend').innerHTML = trendProdutos;
    
    // KPI 4 - Compromissos hoje
    document.querySelectorAll('.kpi')[3].querySelector('.kpi-val').textContent = kpi.compromissos_hoje;

    // 1. FATURAMENTO POR MÊS
    const meses = dados.faturamento.meses;
    const vals = dados.faturamento.vals;
    const max = Math.max(...vals);
    document.getElementById('chart').innerHTML = vals.map((v,i)=>{
      const h = Math.round((v/max)*130);
      return `<div class="bar-g"><div class="bar ${i%2===0?'blue':'teal'}" style="height:${h}px"><span class="bar-top">R$${(v/1000).toFixed(1)}k</span></div><span class="bar-lbl">${meses[i]}</span></div>`;
    }).join('');

    // 2. PEDRAS MAIS VENDIDAS
    const pedrasHTML = dados.pedras.map(p => `
      <div class="pedra-row">
        <div class="pedra-swatch" style="background:${p.cor};"></div>
        <div class="pedra-info">
          <div class="pedra-nome">${p.nome}</div>
          <div class="pedra-bar-wrap"><div class="pedra-bar-fill" style="width:${p.pct}%"></div></div>
        </div>
        <div class="pedra-pct">${p.pct}%</div>
      </div>
    `).join('');
    document.querySelectorAll('.panel .pedra-list')[0].innerHTML = pedrasHTML;

    // 3. ORÇAMENTOS RECENTES
    const orcHTML = dados.orcamentos.map(o => `
      <div class="orc-row">
        <div class="orc-info">
          <div class="orc-cliente">${o.cliente}</div>
          <div class="orc-pedra">${o.pedra}</div>
        </div>
        <div class="orc-right">
          <div class="orc-val">${o.valor}</div>
          <span class="badge ${o.status.toLowerCase()}">${o.status}</span>
        </div>
      </div>
    `).join('');
    document.querySelector('.orc-list').innerHTML = orcHTML;

    // 4. VENDEDORES
    const vendHTML = dados.vendedores.map((v,i) => {
      const cores = ['var(--cpd)', 'var(--ca)', '#3C3489'];
      return `
        <div class="vend-row">
          <div class="vend-av" style="background:${cores[i] || 'var(--ca)'};">${v.nome.substring(0,2).toUpperCase()}</div>
          <div class="vend-info">
            <div class="vend-nome">${v.nome}</div>
            <div class="vend-com">Comissão ${v.comissao}</div>
          </div>
          <div class="vend-val">${v.valor}</div>
        </div>
      `;
    }).join('');
    document.querySelector('.vend-list').innerHTML = vendHTML;

  })
  .catch(e => console.error('Erro ao carregar dados:', e));

const estoque = [
  {nome:'Disco de Corte',cat:'Ferramentas',qt:9},
  {nome:'Disco de Polimento',cat:'Ferramentas',qt:15},
  {nome:'Resina Epóxi',cat:'Insumos',qt:8},
  {nome:'Cera para Polimento',cat:'Insumos',qt:12},
  {nome:'Silicone Incolor',cat:'Fixação',qt:20},
  {nome:'Parafuso e Bucha',cat:'Fixação',qt:50},
  {nome:'Lixa Diamantada',cat:'Consumíveis',qt:25},
  {nome:'Pasta de Polimento',cat:'Consumíveis',qt:3},
];
document.getElementById('estoque-grid').innerHTML = estoque.map(e=>{
  const baixo = e.qt < 5;
  return `<div class="estoque-card${baixo?' alerta':''}">
    <div class="est-cat">${e.cat}</div>
    <div class="est-nome">${e.nome}</div>
    <div class="est-qt">${e.qt}</div>
    <div class="est-unit">unidades</div>
    ${baixo?`<div class="est-alerta-badge"><i class="ti ti-alert-triangle" aria-hidden="true"></i> Estoque baixo</div>`:''}
  </div>`;
}).join('');

const iconMap = {
  'Ferramentas':'ferr','Insumos de acabamento':'acab',
  'Fixação e instalação':'fix','Consumíveis de produção':'cons'
};
const iconTi = {
  'Ferramentas':'ti-tool','Insumos de acabamento':'ti-droplet',
  'Fixação e instalação':'ti-bolt','Consumíveis de produção':'ti-layers-subtract'
};
const produtos = [
  {nome:'Disco de Corte Diamantado',cat:'Ferramentas',vl:180},
  {nome:'Disco de Polimento',cat:'Ferramentas',vl:95},
  {nome:'Lixa Diamantada',cat:'Consumíveis de produção',vl:35},
  {nome:'Pasta de Polimento',cat:'Consumíveis de produção',vl:40},
];
const insumos = [
  {nome:'Resina Epóxi',cat:'Insumos de acabamento',vl:120},
  {nome:'Cera para Polimento',cat:'Insumos de acabamento',vl:45},
  {nome:'Silicone Incolor',cat:'Fixação e instalação',vl:22},
  {nome:'Parafuso e Bucha',cat:'Fixação e instalação',vl:12},
];
const renderProd = (lista) => lista.map(p=>`
  <div class="prod-row">
    <div class="prod-icon ${iconMap[p.cat]||'ferr'}"><i class="ti ${iconTi[p.cat]||'ti-tool'}" aria-hidden="true"></i></div>
    <div class="prod-info">
      <div class="prod-nome">${p.nome}</div>
      <div class="prod-cat">${p.cat}</div>
    </div>
    <div class="prod-val">R$ ${p.vl.toFixed(2).replace('.',',')}</div>
  </div>
`).join('');
document.getElementById('prod-ferr').innerHTML = renderProd(produtos);
document.getElementById('prod-insu').innerHTML = renderProd(insumos);
</script>
        </main>
    </div>
</body>

</html>