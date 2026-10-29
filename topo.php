<?php
 
$menu = [
    'index.php' => 'Vitrine',
    'clientes.php' => 'Clientes',
    'produtos.php' => "Produtos",
    'vendas.php' => 'Vendas'
];
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $titulo ?> | Minha loja </title>
    <link rel="stylesheet" href="assets/css/estilo.css">
</head>
<body>
    <div class="pagina">
 
    <div class="topo">
        <a href="index.php" class="logo">
            <img src="assets/imagens/logo.png" alt="Logo da Loja">
            Minha loja
        </a>
    <div class="menu">
        <?php foreach ($menu as $arquivo => $texto){
            $classe= '';
            if ($arquivo == $pagina){
                $classe = 'ativo';
           
            }
        ?>
            <a href="<?= $arquivo ?>" class="<?= $classe ?>"><?= $texto ?></a>
            <?php } ?>  
</div>
</div>
<div class="conteudo">    
 
