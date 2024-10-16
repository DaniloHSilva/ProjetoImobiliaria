<?php
include('../conn.php');

if(isset($_POST['login']) || isset($_POST['pass'])){
    if(strlen($_POST['login']) == 0){
        echo "Preencha o campo Usuário";
    } else if (strlen($_POST['pass']) == 0){
        echo "Preencha o campo Senha";
    } else {
        $login = $mysqli->real_escape_string($_POST['login']);
        $pass = $mysqli->real_escape_string($_POST['pass']);

        $sql_code = "SELECT * FROM usuarios WHERE user = '$login' AND pass = '$pass'";
        $sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);
        
        $quantidade = $sql_query->num_rows;

        if($quantidade == 1){
            $usuario = $sql_query->fetch_assoc();

            if(!isset($_SESSION)){
                session_start();
            }
            $_SESSION['id'] = $usuario['id'];
            $_SESSION['user'] = $usuario['user'];

            header("Location: painel.php");
        }else{
           echo "Usuário ou senha incorretos!";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="pt-BR">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tiago F Souza - Corretor de Imóveis</title>
	
	 <link href="css/icofont/icofont.min.css" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }

        header {
            background-color: #343a40;
            padding: 20px;
            color: #fff;
        }

        .logo img {
            width: 250px;
        }

        .nav-bar .nav-items a {
            color: #fff;
            margin-right: 15px;
            text-decoration: none;
        }

        main {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 80vh;
        }

        form.box {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        .form-control {
            margin-bottom: 15px;
        }

        footer {
            background-color: #343a40;
            color: #ffffff;
            padding: 40px 0;
            text-align: center;
        }

        .footer-container {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            flex-wrap: wrap;
            gap: 20px;
        }

        .footer-container .group {
            flex: 1;
            text-align: left;
            max-width: 400px;
        }

        .follow ul {
            list-style: none;
            display: flex;
            gap: 10px;
            padding: 0;
        }

        .follow ul li a {
            color: white;
            font-size: 24px;
            text-decoration: none;
        }

        @media (max-width: 768px) {
            .footer-container {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }
        }
    </style>
  </head>

  <body>

    <!-- Navbar -->
    <header>
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <a href="#" class="logo">
                    <img src="../images/logotiago.png" alt="Logo">
                </a>
                <nav class="nav-bar">
                    <div class="nav-items">
                        <a href="../index.php">Início</a>
                    </div>
                </nav>
            </div>
        </div>
    </header>

    <!-- Login Form -->
    <main>
        <form class="box" action="" method="POST">
            <h1 class="text-center mb-4">Acessar conta</h1>
            <div class="mb-3">
                <label for="login" class="form-label">Usuário</label>
                <input type="text" name="login" class="form-control" id="login" placeholder="Digite seu usuário">
            </div>
            <div class="mb-3">
                <label for="pass" class="form-label">Senha</label>
                <input type="password" name="pass" class="form-control" id="pass" placeholder="Digite sua senha">
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Login</button>
            </div>
        </form>
    </main>

  <!-- Footer -->
    <footer>
        <div class="container footer-container">
            <div class="group">
                <h4>Tiago F Souza - Corretor de Imóveis</h4>
                <p>Contato: (11) 1234-5678</p>
                <p>Email: emailcontato@exemplo.com</p>
                <p>Endereço: R: Estevão Leão Burroul, 1378, Franca, SP, CEP: 14400-750</p>
            </div>
            <div class="follow group">
                <h5>Siga nas redes sociais</h5>
                <ul>
                    <li><a href="#"><i class="icofont-facebook text-white"></i></a></li>
					 <li><a href="#"><i class="icofont-instagram text-white"></i></a></li>
					  <li><a href="#"><i class="icofont-whatsapp text-white"></i></a></li>
					 
               
                </ul>
				
				 <a href="#" class="logo">
                    <img src="../images/logotiago.png" alt="Logo">
                </a>
				
            </div>
        </div>
        <p class="text-center mt-5">&copy; 2024 Tiago F Souza - Todos os direitos reservados.</p>
    </footer>


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
