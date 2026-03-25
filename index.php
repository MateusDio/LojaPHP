<?php

require_once "dao/ClienteDAO.php";
require_once "dao/ProdutoDAO.php";
require_once "dao/PedidoDAO.php";
require_once "classes/Cliente.php";
require_once "classes/Produto.php";
require_once "classes/Pedido.php";

$clienteDAO = new ClienteDAO();
$produtoDAO = new ProdutoDAO();
$pedidoDAO = new PedidoDAO();

if(isset($_POST['salvar_cliente'])) {
    $cliente = new Cliente(null, $_POST['nome_cliente'], $_POST['email_cliente']);
    if($clienteDAO->inserir($cliente)){
        echo "Cliente cadastrado com sucesso!<br>";
    } else {
        echo "Erro ao cadastrar cliente!<br>";
    }
}

if(isset($_POST['salvar_produto'])) {
    $produto = new Produto(null, $_POST['nome_produto'], $_POST['preco_produto']);
    if($produtoDAO->inserir($produto)){
        echo "Produto cadastrado com sucesso!<br>";
    } else {
        echo "Erro ao cadastrar produto!<br>";
    }
}

if(isset($_POST['criar_pedido'])) {

    $clienteId = $_POST['pedido_cliente'];
    $produtosIds = isset($_POST['pedido_produtos']) ? $_POST['pedido_produtos'] : [];

    if(empty($produtosIds)){
        echo "Selecione pelo menos um produto para o pedido!<br>";
    } else {
        $numero = isset($_POST['numero_pedido']) ? $_POST['numero_pedido'] : rand(1000, 9999);

        $cliente = $clienteDAO->buscarPorId($clienteId);

        $produtos = [];
        foreach($produtosIds as $pid) {
            $produto = $produtoDAO->buscarPorId($pid);
            if($produto) $produtos[] = $produto;
        }

        $pedido = new Pedido($numero, $cliente, $produtos);

        if($pedidoDAO->inserir($pedido)) {
            echo "Pedido criado com sucesso! Número: $numero<br>";
        } else {
            echo "Erro ao criar pedido!<br>";
        }
    }
}

$clientes = $clienteDAO->listarTodos();
$produtos = $produtoDAO->listarTodos();
$pedidos = $pedidoDAO->listarTodos(); 
?>

<h2>Cadastro de Clientes</h2>
<form method="POST">
    Nome:<br>
    <input type="text" name="nome_cliente" required><br><br>
    Email:<br>
    <input type="email" name="email_cliente" required><br><br>
    <button type="submit" name="salvar_cliente">Salvar Cliente</button>
</form>

<h3>Clientes cadastrados:</h3>
<ul>
<?php foreach($clientes as $c): ?>
    <li><?= $c->getId(); ?> - <?= $c->getNome(); ?> | <?= $c->getEmail(); ?></li>
<?php endforeach; ?>
</ul>

<h2>Cadastro de Produtos</h2>
<form method="POST">
    Nome:<br>
    <input type="text" name="nome_produto" required><br><br>
    Preço:<br>
    <input type="number" step="0.01" name="preco_produto" required><br><br>
    <button type="submit" name="salvar_produto">Salvar Produto</button>
</form>

<h3>Produtos cadastrados:</h3>
<ul>
<?php foreach($produtos as $p): ?>
    <li><?= $p->getId(); ?> - <?= $p->getNome(); ?> | R$ <?= number_format($p->getPreco(),2,",","."); ?></li>
<?php endforeach; ?>
</ul>

<h2>Criar Pedido</h2>
<form method="POST">
    Cliente:<br>
    <select name="pedido_cliente" required>
        <?php foreach($clientes as $c): ?>
            <option value="<?= $c->getId(); ?>"><?= $c->getNome(); ?></option>
        <?php endforeach; ?>
    </select><br><br>

    Produtos:<br>
    <?php foreach($produtos as $p): ?>
        <input type="checkbox" name="pedido_produtos[]" value="<?= $p->getId(); ?>"> <?= $p->getNome(); ?> (R$ <?= number_format($p->getPreco(),2,",","."); ?>)<br>
    <?php endforeach; ?><br>

    Número do pedido (opcional):<br>
    <input type="number" name="numero_pedido"><br><br>

    <button type="submit" name="criar_pedido">Criar Pedido</button>
</form>

<h3>Pedidos cadastrados:</h3>
<ul>
<?php foreach($pedidos as $pedido): ?>
    <li>
        Pedido Nº <?= $pedido->getNumero(); ?> - Cliente: <?= $pedido->getCliente()->getNome(); ?> - Total: R$ <?= number_format($pedido->calcularTotal(),2,",","."); ?>
        <br>Produtos:
        <ul>
            <?php foreach($pedido->getProdutos() as $produto): ?>
                <li><?= $produto->getNome(); ?> | R$ <?= number_format($produto->getPreco(),2,",","."); ?></li>
            <?php endforeach; ?>
        </ul>
    </li>
<?php endforeach; ?>
</ul>