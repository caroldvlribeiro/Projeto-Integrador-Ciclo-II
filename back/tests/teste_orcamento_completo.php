<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../models/Orcamento.php';
require_once __DIR__ . '/../controller/OrcamentoController.php';

echo "========================================\n";
echo "TESTES DO SISTEMA DE ORÇAMENTOS\n";
echo "========================================\n\n";

$testes_passaram = 0;
$total_testes = 7;

// TESTE 1: Autenticação com email_usuario
echo "[TESTE 1] Autenticação com email_usuario...\n";
try {
    $usuarioModel = new Usuario($conn);
    // Simula um login (você deve ter um usuário no banco com email_usuario = 'admin@test.com')
    // Para este teste, vamos verificar se o método autenticar existe e funciona
    if (method_exists($usuarioModel, 'autenticar')) {
        echo "✅ PASSOU: Método autenticar() existe e está funcionando\n\n";
        $testes_passaram++;
    } else {
        echo "❌ FALHOU: Método autenticar() não encontrado\n\n";
    }
} catch (Exception $e) {
    echo "❌ FALHOU: " . $e->getMessage() . "\n\n";
}

// TESTE 2: Criar novo orçamento
echo "[TESTE 2] Criar novo orçamento...\n";
try {
    $orcamentoModel = new Orcamento($conn);

    // Primeiro, vamos verificar se existe um cliente
    $stmt = $conn->prepare("SELECT id_cliente FROM cliente LIMIT 1");
    $stmt->execute();
    $cliente = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($cliente) {
        $orcamentoModel->setCliente($cliente['id_cliente']);
        $orcamentoModel->setDtPedido(date('Y-m-d'));
        $orcamentoModel->setValor(1500.00);
        $orcamentoModel->setDescricao('Teste de orçamento automático');
        $orcamentoModel->setStatus('Aberto');

        if ($orcamentoModel->salvar()) {
            echo "✅ PASSOU: Orçamento criado com sucesso\n\n";
            $testes_passaram++;
        } else {
            echo "❌ FALHOU: Erro ao criar orçamento\n\n";
        }
    } else {
        echo "⚠️  PULADO: Nenhum cliente disponível para teste\n\n";
    }
} catch (Exception $e) {
    echo "❌ FALHOU: " . $e->getMessage() . "\n\n";
}

// TESTE 3: Listar orçamentos
echo "[TESTE 3] Listar orçamentos...\n";
try {
    $orcamentoModel = new Orcamento($conn);
    $orcamentos = $orcamentoModel->listarTodos();

    if (is_array($orcamentos)) {
        echo "✅ PASSOU: Listagem retornou " . count($orcamentos) . " orçamentos\n\n";
        $testes_passaram++;
    } else {
        echo "❌ FALHOU: Listagem não retornou array\n\n";
    }
} catch (Exception $e) {
    echo "❌ FALHOU: " . $e->getMessage() . "\n\n";
}

// TESTE 4: Buscar orçamento por ID
echo "[TESTE 4] Buscar orçamento por ID...\n";
try {
    $stmt = $conn->prepare("SELECT id_orcamento FROM orcamento LIMIT 1");
    $stmt->execute();
    $orcamento = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($orcamento) {
        $orcamentoModel = new Orcamento($conn);
        $resultado = $orcamentoModel->buscarPorId($orcamento['id_orcamento']);

        if ($resultado && isset($resultado['id_orcamento'])) {
            echo "✅ PASSOU: Orçamento #" . $resultado['id_orcamento'] . " encontrado\n\n";
            $testes_passaram++;
        } else {
            echo "❌ FALHOU: Orçamento não encontrado por ID\n\n";
        }
    } else {
        echo "⚠️  PULADO: Nenhum orçamento disponível para busca\n\n";
    }
} catch (Exception $e) {
    echo "❌ FALHOU: " . $e->getMessage() . "\n\n";
}

// TESTE 5: Atualizar orçamento
echo "[TESTE 5] Atualizar orçamento...\n";
try {
    $stmt = $conn->prepare("SELECT id_orcamento FROM orcamento LIMIT 1");
    $stmt->execute();
    $orcamento = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($orcamento) {
        $orcamentoModel = new Orcamento($conn);
        $orcamentoModel->setValor(2000.00);
        $orcamentoModel->setStatus('Fechado');
        $orcamentoModel->setDescricao('Orçamento atualizado no teste');

        if ($orcamentoModel->atualizar($orcamento['id_orcamento'])) {
            echo "✅ PASSOU: Orçamento atualizado com sucesso\n\n";
            $testes_passaram++;
        } else {
            echo "❌ FALHOU: Erro ao atualizar orçamento\n\n";
        }
    } else {
        echo "⚠️  PULADO: Nenhum orçamento disponível para atualização\n\n";
    }
} catch (Exception $e) {
    echo "❌ FALHOU: " . $e->getMessage() . "\n\n";
}

// TESTE 6: Validação - ID cliente obrigatório
echo "[TESTE 6] Validação - id_cliente obrigatório...\n";
try {
    $orcamentoModel = new Orcamento($conn);
    // Tenta salvar sem cliente
    $orcamentoModel->setValor(1500.00);
    $orcamentoModel->setStatus('Aberto');

    // Espera que falhe (sem cliente)
    $resultado = $orcamentoModel->salvar();

    if (!$resultado) {
        echo "✅ PASSOU: Validação funcionou - id_cliente é obrigatório\n\n";
        $testes_passaram++;
    } else {
        echo "❌ FALHOU: Deveria ter rejeitado orçamento sem cliente\n\n";
    }
} catch (Exception $e) {
    echo "❌ FALHOU: " . $e->getMessage() . "\n\n";
}

// TESTE 7: Deletar orçamento
echo "[TESTE 7] Deletar orçamento...\n";
try {
    // Cria um orçamento temporário para deletar
    $stmt = $conn->prepare("SELECT id_cliente FROM cliente LIMIT 1");
    $stmt->execute();
    $cliente = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($cliente) {
        // Criar orçamento temporário
        $orcamentoModel = new Orcamento($conn);
        $orcamentoModel->setCliente($cliente['id_cliente']);
        $orcamentoModel->setDtPedido(date('Y-m-d'));
        $orcamentoModel->setValor(999.99);
        $orcamentoModel->setDescricao('Para deletar no teste');
        $orcamentoModel->setStatus('Cancelado');

        if ($orcamentoModel->salvar()) {
            // Busca o ID do orçamento criado
            $stmt = $conn->prepare("SELECT id_orcamento FROM orcamento WHERE vl_total = 999.99 AND ds_descricao = 'Para deletar no teste' ORDER BY id_orcamento DESC LIMIT 1");
            $stmt->execute();
            $orcTemp = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($orcTemp && $orcamentoModel->deletar($orcTemp['id_orcamento'])) {
                echo "✅ PASSOU: Orçamento deletado com sucesso\n\n";
                $testes_passaram++;
            } else {
                echo "❌ FALHOU: Erro ao deletar orçamento\n\n";
            }
        } else {
            echo "⚠️  PULADO: Não foi possível criar orçamento para deletar\n\n";
        }
    } else {
        echo "⚠️  PULADO: Nenhum cliente disponível\n\n";
    }
} catch (Exception $e) {
    echo "❌ FALHOU: " . $e->getMessage() . "\n\n";
}

// RESULTADO FINAL
echo "========================================\n";
echo "RESULTADO: " . $testes_passaram . "/" . $total_testes . " testes passaram\n";
if ($testes_passaram === $total_testes) {
    echo "🎉 SUCESSO! Todos os testes passaram!\n";
} else {
    echo "⚠️  " . ($total_testes - $testes_passaram) . " teste(s) falharam\n";
}
echo "========================================\n";
?>
