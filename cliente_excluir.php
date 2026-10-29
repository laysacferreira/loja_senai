<?php
include 'conexao.php';
include 'funcoes.php';
 
$id = $_GET['id'] ?? $_POST['id'] ?? null;
 
if (!$id) {
    header('Location: clientes.php');
    exit;
}
 
// Busca os dados do cliente
$sql = $pdo->prepare('SELECT * FROM cliente WHERE id = ?');
$sql->execute([$id]);
$cliente = $sql->fetch();
 
if (!$cliente) {
    header('Location: clientes.php?msg=nao_encontrado');
    exit;
}
 
// Conta quantas vendas o cliente possui
$sql = $pdo->prepare('SELECT COUNT(*) FROM venda WHERE cliente_id = ?');
$sql->execute([$id]);
$qtd_vendas = $sql->fetchColumn();
 
// Exclui o cliente somente se não houver vendas
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $qtd_vendas == 0) {
    $sql = $pdo->prepare('DELETE FROM cliente WHERE id = ?');
    $sql->execute([$id]);
 
    header('Location: clientes.php?msg=excluido');
    exit;
}
 
$titulo = 'Excluir cliente';
$pagina = 'clientes.php';
 
include 'topo.php';
?>
 
<div class="caixa">
    <h1>Excluir cliente</h1>
 
    <?php if ($qtd_vendas > 0) { ?>
 
        <div class="aviso erro">
            <?= e($cliente['nome']) ?> tem
            <?= $qtd_vendas ?> venda(s) registrada(s)
            e não pode ser excluído. Exclua as vendas primeiro.
        </div>
 
        <div class="acoes">
            <a href="clientes.php" class="botao claro">Voltar</a>
        </div>
 
    <?php } else { ?>
 
        <p>
            Tem certeza que deseja excluir
            <b><?= e($cliente['nome']) ?></b>?
        </p>
 
        <p>Essa ação não pode ser desfeita.</p>
 
        <form method="post" class="acoes">
            <input type="hidden" name="id"
                   value="<?= e($cliente['id']) ?>">
 
            <button type="submit" class="botao perigo">
                Sim, excluir
            </button>
 
            <a href="clientes.php" class="botao claro">
                Cancelar
            </a>
        </form>
 
    <?php } ?>
</div>
 
<?php include 'rodape.php'; ?>