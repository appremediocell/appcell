<!DOCTYPE html>
<html>
<head>
    <title>Login e Cadastro</title>
	<style>
		body {
			font-family: Arial, sans-serif;
			display: flex;
			justify-content: center;
			align-items: center;
			height: 100vh;
			margin: 0;
			background-color: #f0f0f0;
		}
		#message {
			position: absolute;
			top: 25%;	/* Aumente este valor para mover a mensagem para baixo */
			left: 50%;
			transform: translate(-50%, -50%);
			color: red;
			font-size: 20px;
			text-align: center;
		}
		form {
			background-color: #fff;
			padding: 20px;
			border-radius: 5px;
			box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1);
		}
		h2 {
			margin: 0 0 15px 0;
		}
		label {
			font-weight: bold;
			display: block;
		}
		input[type="text"], input[type="password"] {
			width: calc(100% - 20px);
			padding: 10px;
			margin: 5px 0 15px 0;
			border: 1px solid #ddd;
			border-radius: 5px;
		}
		.button-container {
			display: flex;
			justify-content: space-between;
		}
		input[type="submit"], button {
			padding: 10px;
			border: none;
			color: #fff;
			background-color: #007BFF;
			cursor: pointer;
			border-radius: 5px;
			margin-top: 10px;
			flex-grow: 1;
			margin-right: 5px;
		}
		input[type="submit"]:hover, button:hover {
			background-color: #0056b3;
		}
		button:last-child {
			margin-right: 0;
		}
	</style>
    <script>
        function toggleForms() {
            var loginForm = document.getElementById("loginForm");
            var registerForm = document.getElementById("registerForm");
            if (loginForm.style.display === "none") {
                loginForm.style.display = "block";
                registerForm.style.display = "none";
            } else {
                loginForm.style.display = "none";
                registerForm.style.display = "block";
            }
        }
    </script>
</head>
<body>
    <?php
    $message = "";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["register"])) {
            $username = $_POST["new_username"];
            $password = $_POST["new_password"];
            $data = "Usuário: " . $username . ", Senha: " . $password . "\n";
            file_put_contents("logins.txt", $data, FILE_APPEND);
        }
        if (isset($_POST["login"])) {
            $username = $_POST["username"];
            $password = $_POST["password"];
            $logins = file_get_contents("logins.txt");
            $pattern = "/Usuário: " . $username . ", Senha: " . $password . "/";
            if (preg_match($pattern, $logins)) {
                header("Location: painel.php");
                exit();
            } else {
                $message = "Login ou Senha errado!";
            }
        }
    }
    ?>
    <div id="message"><?php echo $message; ?></div>
    <form id="loginForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <h2>Login</h2>
        <label>Usuário:<input type="text" name="username"></label>
        <label>Senha:<input type="password" name="password"></label>
        <div class="button-container">
            <input type="submit" name="login" value="Login">
            <button type="button" onclick="toggleForms()">Cadastrar</button>
        </div>
    </form>
    <form id="registerForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" style="display:none;">
        <h2>Cadastro</h2>
        <label>Usuário:<input type="text" name="new_username"></label>
        <label>Senha:<input type="password" name="new_password"></label>
        <div class="button-container">
            <input type="submit" name="register" value="Cadastrar">
            <button type="button" onclick="toggleForms()">Voltar para Login</button>
        </div>
    </form>
</body>
</html>
