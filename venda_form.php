 
<?php
include 'conexao.php';
include 'funcoes.php';
 
// Buscar clientes
$clientes = $pdo->query(
    'SELECT id, nome FROM cliente ORDER BY nome'
)->fetchAll(PDO::FETCH_ASSOC);
 
// Buscar produtos
$produtos = $pdo->query(
    'SELECT id, nome, preco FROM produto ORDER BY nome'
)->fetchAll(PDO::FETCH_ASSOC);
 
// Valores iniciais da venda
$venda = [
    'id' => '',
    'cliente_id' => '',
    'produto_id' => '',
    'quantidade' => 1,
    'data_venda' => date('Y-m-d'),
];
 
$preco = '';
$titulo = 'Nova venda';
 
// Verificar se está editando uma venda existente
if (isset($_GET['id'])) {
    $sql = $pdo->prepare(
        'SELECT * FROM venda WHERE id = ?'
    );
    $sql->execute([$_GET['id']]);
    $dados = $sql->fetch(PDO::FETCH_ASSOC);
 
    if ($dados) {
        $venda = $dados;
        $preco = $dados['valor_total'] / max(1, $dados['quantidade']);
        $titulo = 'Editar venda';
    }
}
 
$pagina = 'vendas.php';
include 'topo.php';
?>
 
<div class="caixa">
    <h1><?= e($titulo) ?></h1>
 
    <form method="post" action="venda_salvar.php" class="formulario">
 
        <input
            type="hidden"
            name="id"
            value="<?= e($venda['id']) ?>"
        >
 
        <div class="campo">
            <label for="cliente_id">Cliente</label>
 
            <select id="cliente_id" name="cliente_id" required>
                <option value="">Escolha o cliente</option>
 
                <?php foreach ($clientes as $cliente) { ?>
                    <option
                        value="<?= $cliente['id'] ?>"
                        <?= $cliente['id'] == $venda['cliente_id'] ? 'selected' : '' ?>
                    >
                        <?= e($cliente['nome']) ?>
                    </option>
                <?php } ?>
            </select>
        </div>
 
        <div class="campo">
            <label for="produto_id">Produto</label>
 
            <select id="produto_id" name="produto_id" required>
                <option value="">Escolha o produto</option>
 
                <?php foreach ($produtos as $produto) { ?>
                    <option
                        value="<?= $produto['id'] ?>"
                        data-preco="<?= e($produto['preco']) ?>"
                        <?= $produto['id'] == $venda['produto_id'] ? 'selected' : '' ?>
                    >
                        <?= e($produto['nome']) ?>
                        (<?= dinheiro($produto['preco']) ?>)
                    </option>
                <?php } ?>
            </select>
        </div>
 
        <div class="campo">
            <label for="quantidade">Quantidade</label>
 
            <input
                type="number"
                id="quantidade"
                name="quantidade"
                min="1"
                value="<?= e($venda['quantidade']) ?>"
                required
            >
        </div>
 
        <div class="campo">
            <label for="preco">Preço unitário (R$)</label>
 
            <input
                type="number"
                id="preco"
                name="preco"
                step="0.01"
                min="0"
                value="<?= e($preco) ?>"
                required
            >
        </div>
 
        <div class="campo">
            <label for="data_venda">Data da venda</label>
 
            <input
                type="date"
                id="data_venda"
                name="data_venda"
                value="<?= e($venda['data_venda']) ?>"
                required
            >
        </div>
 
        <div class="dica">
            O total é calculado ao salvar: preço do produto × quantidade.
        </div>
 
        <div class="acoes">
            <button type="submit" class="botao">
                Salvar
            </button>
 
            <a href="vendas.php" class="botao claro">
                Cancelar
            </a>
        </div>
 
    </form>
</div>
 
<script>
const produtoSelect = document.getElementById('produto_id');
const precoInput = document.getElementById('preco');
 
produtoSelect.addEventListener('change', function () {
    const opcao = this.options[this.selectedIndex];
 
    if (opcao.dataset.preco !== undefined && this.value !== '') {
        precoInput.value = Number(opcao.dataset.preco).toFixed(2);
    } else {
        precoInput.value = '';
    }
});
</script>
 
<?php include 'rodape.php'; ?>
 
 