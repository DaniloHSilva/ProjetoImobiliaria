<?php
    include('protect.php');
    include('../conn.php');
    
    $consulta = "SELECT * FROM aluguel";
    $con = $mysqli->query($consulta) or die($mysqli->error);


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

        .home {
            background: url('images/background.jpg') no-repeat center center;
            background-size: cover;
            height: 80vh;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .about .container {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 15px;
        }

        .portfolio .img-card {
            position: relative;
            overflow: hidden;
            border-radius: 10px;
            transition: all 0.3s ease-in-out;
        }

        .img-card img {
            width: 100%;
            height: auto;
            transition: transform 0.3s ease;
        }

        .img-card:hover img {
            transform: scale(1.1);
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

        .footer-container .group h4, .footer-container .group h5 {
            margin-bottom: 15px;
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

        .btn-go {
            background-color: #0069d9;
            color: #fff;
            border-radius: 20px;
            padding: 10px 20px;
            border: none;
            transition: 0.3s;
        }

        .btn-go:hover {
            background-color: #0056b3;
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
                        <a href="upload.php">Cadastrar Imóveis</a>
                        <a href="logout.php">Sair</a>
                    </div>
                </nav>
            </div>
        </div>
    </header>

  <main class="container mt-4">
    <h1 class="text-center">Bem-vindo, <?php echo $_SESSION['user']; ?></h1>
    <div id="content">
        <h2 class="text-center my-4">Lista de Imóveis Cadastrados para Locação</h2>

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Título</th>
                        <th scope="col">Imagem</th>
                        <th scope="col">Categoria</th>
                        <th scope="col">Valor</th>
                        <th scope="col">Excluir</th>
                        <th scope="col">Editar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($dado = $con->fetch_array()){ ?>
                    <?php
                        $query = "SELECT foto FROM aluguel WHERE id=$dado[id];";
                        $fire = mysqli_query($mysqli, $query);
                        $data = mysqli_fetch_array($fire);
                        $res = $data['foto'];
                        $res = explode(" ", $res);
                    ?>
                    <tr>
                        <td><?php echo $dado["id"]; ?></td>
                        <td><?php echo $dado["titulo"]; ?></td>
                        <td><img src="../fotos/<?php echo $res[0]; ?>" alt="Imagem do Imóvel" class="img-fluid" style="max-width: 100px;"></td>
                        <td><?php echo $dado["categoria"]; ?></td>
                        <td>R$<?php echo $dado["valor"]; ?></td>
                        <td>
                            <a href="javascript: if(confirm('Tem certeza que deseja deletar o Cadastro desse imóvel?')) location.href='del_aluguel.php?id=<?php echo $dado["id"];?>'" class="btn btn-danger btn-sm">
                                EXCLUIR
                            </a>
                        </td>
                        <td>
                            <a href="edit_aluguel.php?id=<?php echo $dado["id"]; ?>" class="btn btn-primary btn-sm">
                                Editar
                            </a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
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

</body>
</html>

