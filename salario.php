<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora de Salário</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body { 
            background-color: #003664;
            color: #ffffff;
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        img {
            width: 400px;
            margin: auto;
            display: block;
        }
        h2 {
            text-align: center;
            font-family: Arial, sans-serif;
        }
        
        form {
            max-width: 400px;
            margin: 0 auto;
            background-color: #002147;
            padding: 20px;
            border-radius: 10px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #ffffff;
        }
        input[type="text"],
        input[type="number"],
        input[type="submit"] {
            width: calc(100% - 20px); /* Alterado para deixar espaço para a margem */
            padding: 8px;
            margin-bottom: 10px;
            border: none;
            border-radius: 5px;
            font-family: Arial, sans-serif;
            margin-right: 10px; /* Adicionado espaçamento à direita */
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
            margin-right: 0; /* Removido o espaçamento à direita do botão de envio */
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        .result {
            background-color: #002147;
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
            color: #ffffff;
        }
        .result p {
            margin: 0;
        }
    </style>
</head>
<body>
    <br><br>
    <img src="logos.jpg" alt="Notebook">
    <h2>Calculadora de Salário</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <label for="nome">Nome do Funcionário:</label><br>
        <input type="text" id="nome" name="nome" required><br><br>
        <label for="semana1">Venda Semanal (Semana 1):</label><br>
        <input type="text" id="semana1" name="semana1" required oninput="formatarMoeda(this)"><br><br>
        <label for="semana2">Venda Semanal (Semana 2):</label><br>
        <input type="text" id="semana2" name="semana2" required oninput="formatarMoeda(this)"><br><br>
        <label for="semana3">Venda Semanal (Semana 3):</label><br>
        <input type="text" id="semana3" name="semana3" required oninput="formatarMoeda(this)"><br><br>
        <label for="semana4">Venda Semanal (Semana 4):</label><br>
        <input type="text" id="semana4" name="semana4" required oninput="formatarMoeda(this)"><br><br>
        <label for="total_mes">Total de Vendas no Mês:</label><br>
        <input type="text" id="total_mes" name="total_mes" required oninput="formatarMoeda(this)"><br><br>
        <br>
        <input type="submit" value="Calcular Salário">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Definindo as metas semanais e mensais
        $meta_semanal = 1000;
        $meta_mensal = 4000;

        if (isset($_POST['nome'], $_POST['semana1'], $_POST['semana2'], $_POST['semana3'], $_POST['semana4'], $_POST['total_mes'])) {
            $nome = htmlspecialchars($_POST['nome']);
            $semana1 = floatval(str_replace(',', '.', str_replace('.', '', $_POST['semana1'])));
            $semana2 = floatval(str_replace(',', '.', str_replace('.', '', $_POST['semana2'])));
            $semana3 = floatval(str_replace(',', '.', str_replace('.', '', $_POST['semana3'])));
            $semana4 = floatval(str_replace(',', '.', str_replace('.', '', $_POST['semana4'])));
            $total_mes = floatval(str_replace(',', '.', str_replace('.', '', $_POST['total_mes'])));

            $salario_minimo = 1856.94;
            $bonificacao_semanal = 0;
            $bonificacao_mensal = 0;

            if ($semana1 >= $meta_semanal && $semana2 >= $meta_semanal && $semana3 >= $meta_semanal && $semana4 >= $meta_semanal) {
                $bonificacao_semanal = ($semana1 + $semana2 + $semana3 + $semana4) * 0.05;
            }

            if ($total_mes >= $meta_mensal) {
                $bonificacao_mensal = $total_mes * 0.1;
            }

            // Calculando o salário
            $salario = $salario_minimo + $bonificacao_semanal + $bonificacao_mensal;

            // Saída do salário
            echo "<div class='result'>";
            echo "<h3>Resultado:</h3>";
            echo "<p>Nome do Funcionário: $nome</p>";
            echo "<p>Salário: R$ " . number_format($salario, 2, ',', '.') . "</p>"; // Formatação para moeda brasileira
            echo "</div>";
        }
    }
    ?>
    
    <script>
        function formatarMoeda(input) {
            var valor = input.value.replace(/\D/g, ''); // Remove caracteres não numéricos
            var valorFormatado = (parseInt(valor) / 100).toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' }); // Formata para moeda brasileira
            input.value = valorFormatado;
        }
    </script>
</body>
</html>
