 
<?php
include 'conexao.php';
include 'funcoes.php';
 
if (!isset($_GET['id'])) {
    header('Location: vendas.php');
    exit;
}
 
$id = (int) $_GET['id'];
 
// Buscar os dados da venda
$sql = $pdo->prepare(
    'SELECT venda.*, cliente.nome AS cliente, produto.nome AS produto
     FROM venda
     JOIN cliente ON cliente.id = venda.cliente_id
     JOIN produto ON produto.id = venda.produto_id
     WHERE venda.id = ?'
);
 
$sql->execute([$id]);
$venda = $sql->fetch(PDO::FETCH_ASSOC);
 
// Se a venda não existir, voltar para a lista
if (!$venda) {
    header('Location: vendas.php');
    exit;
}
 
// Excluir somente após confirmar no formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sql = $pdo->prepare('DELETE FROM venda WHERE id = ?');
    $sql->execute([$id]);
 
    header('Location: vendas.php?msg=excluido');
    exit;
}
 
$titulo = 'Excluir venda';
$pagina = 'vendas.php';
 
include 'topo.php';
?>
 
<div class="caixa">
    <h1>Excluir venda</h1>
 
    <p>Tem certeza de que deseja excluir esta venda?</p>
 
    <div class="resumo">
        <div>
            Data: <b><?= e(data_br($venda['data_venda'])) ?></b>
        </div>
 
        <div>
            Cliente: <b><?= e($venda['cliente']) ?></b>
        </div>
 
        <div>
            Produto: <b><?= e($venda['produto']) ?></b>
            × <?= (int) $venda['quantidade'] ?>
        </div>
 
        <div>
            Total: <b><?= dinheiro($venda['valor_total']) ?></b>
        </div>
    </div>
 
    <form method="post" class="acoes">
        <input
            type="hidden"
            name="id"
            value="<?= (int) $venda['id'] ?>"
        >
 
        <button type="submit" class="botao perigo">
            Sim, excluir
        </button>
 
        <a href="vendas.php" class="botao claro">
            Cancelar
        </a>
    </form>
</div>
 
<?php include 'rodape.php'; ?>
 
 