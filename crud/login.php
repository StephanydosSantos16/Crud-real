<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f2f2f2;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            width: 100%;
            max-width: 400px;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .login-title {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }

        .input-group {
            margin-bottom: 15px;
            text-align: left;
        }

        .input-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .input-group input {
            width: calc(100% - 22px);
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }

        #message {
            color: red;
            margin-top: 10px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <form id="login-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <h2 class="login-title">Login</h2>
            <div class="input-group">
                <label for="nome">Nome</label>
                <input type="text" id="nome" name="nome" placeholder="Nome" required>
            </div>
            <div class="input-group">
                <label for="cpf">CPF</label>
                <input type="text" id="cpf" name="cpf" placeholder="CPF" required>
            </div>
            <button type="submit">Entrar</button>
            <p id="message">
                <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    if (isset($_POST["nome"]) && isset($_POST["cpf"])) {
                        $conexao = mysqli_connect("localhost", "stephany", "12345", "crud");

                        if (mysqli_connect_errno()) {
                            die("Falha na conexão com o banco de dados: " . mysqli_connect_error());
                        }

                        $nome = $_POST["nome"];
                        $cpf = $_POST["cpf"];

                        // Prevenir SQL injection usando prepared statements
                        $query = "SELECT * FROM users WHERE nome = ? AND cpf = ?";
                        $stmt = mysqli_prepare($conexao, $query);
                        
                        if ($stmt === false) {
                            die('Erro na preparação da declaração: ' . mysqli_error($conexao));
                        }

                        mysqli_stmt_bind_param($stmt, "ss", $nome, $cpf);
                        mysqli_stmt_execute($stmt);
                        $resultado = mysqli_stmt_get_result($stmt);

                        if ($resultado && mysqli_num_rows($resultado) > 0) {
                            echo "Login feito com sucesso!";
                        } else {
                            echo "Você não possui cadastro.";
                        }

                        mysqli_stmt_close($stmt);
                        mysqli_close($conexao);
                    } else {
                        echo "Por favor, preencha todos os campos corretamente.";
                    }
                }
                ?>
            </p>
        </form>
    </div>
</body>
</html>
