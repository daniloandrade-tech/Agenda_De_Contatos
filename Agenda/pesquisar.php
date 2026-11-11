<?php include "conexao.php"; ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Agenda</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Pesquisar Contatos</h1>
        <br><br>
        
        <form method="get" action="">
            <input 
                type="text" name="nome" id="nome" class="campo-pesquisa" 
                placeholder="Digite o nome do contato"
                value="<?php echo h(trim($_GET['nome'] ?? '')); ?>">
            <div class="grupo-botoes">
                <button type="submit" class="btn btn-pesquisar">
                    Pesquisar
                </button>

                <!-- Limpar: esvazia o campo e remove os resultados da tela -->
                <button type="button" class="btn btn-limpar" onclick="window.location.href='pesquisar.php'">
                    Limpar
                </button>

                <!-- margin-left:auto no CSS empurra o Voltar para a direita -->
                <a href="index.php" class="btn btn-voltar">
                    Voltar
                </a>
            </div>
        </form>
        
    <?php 
    if(isset($_GET['nome'])){
        $busca = "%" . trim($_GET['nome']) . "%";
        
        $stmt = mysqli_prepare($conexao, "SELECT id, nome, telefone 
                FROM contatos
                WHERE nome LIKE ?
                ORDER BY id");
        mysqli_stmt_bind_param($stmt, "s", $busca);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);
        $total = mysqli_num_rows($resultado);
    ?>
        <div class='total-registros'>Foram encontrados <?php echo $total;?> contato(s)</div>
        
        <?php if($total > 0){ ?>
            <div class="resultados">
                <?php while($contato = mysqli_fetch_assoc($resultado)){ ?>
                    <!-- Cada contato aparece em uma linha única usando esta div -->
                    <div class="contato-item" style="margin: 8px 0; padding: 5px; border-bottom: 1px solid #ddd;">
                        <strong><?php echo h($contato['nome']); ?></strong>: 
                        <span><?php echo h(formatar_telefone($contato['telefone'])); ?></span>
                    </div>
                <?php } ?>
            </div>
        <?php } else { ?>
            <div class="erro-pesquisa">
                Nenhum contato encontrado.
            </div>
        <?php } ?>
    <?php } ?>
    </div>
</body>
</html>
