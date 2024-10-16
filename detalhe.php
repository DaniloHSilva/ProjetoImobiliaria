<?php
include("conn.php");

// Recupera os detalhes da propriedade com base no ID da URL
$pag = $_GET['id'];
$negocio_type = $_GET['status']; // Obtém o tipo de negócio
$table = ($negocio_type === 'venda') ? 'venda' : 'aluguel'; // Define a tabela a ser consultada

// Modifica a consulta para a tabela correta
$consulta = "SELECT * FROM $table WHERE id = ?";
$stmt = $mysqli->prepare($consulta);
$stmt->bind_param("i", $pag);
$stmt->execute();
$con = $stmt->get_result();
$data = $con->fetch_assoc();

if ($data) {
    $res = explode(" ", $data['foto']);
    $count = count($res);
    $position = isset($_POST['position']) ? (int)$_POST['position'] : 0;

    if (isset($_POST['add'])) {
        $position = ($position + 1) % $count; // Navegação pelas imagens
    }
    if (isset($_POST['minus'])) {
        $position = ($position - 1 + $count) % $count; // Volta na navegação
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: Arial, sans-serif; background-color: #f8f9fa; }
        header { background-color: #343a40; padding: 20px; color: #fff; }
        .logo img { width: 250px; }
        footer { background-color: #343a40; color: #ffffff; padding: 40px 0; text-align: center; }
        .property-image { max-width: 100%; height: auto; border-radius: 10px; }
        .property-details { font-size: 1.2em; }
        .property-info { list-style: none; padding: 0; }
        .property-info li { display: inline-block; width: 32%; margin-bottom: 10px; }
        .btn-contact { background-color: #28a745; color: white; }
        .button-container { display: flex; justify-content: space-between; gap: 10px; }
        .button-container .btn { flex-grow: 1; }
		
		
		
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
		
		.img-card img {
        width: 100%; /* Largura total do contêiner */
        height: 200px; /* Altura fixa */
        object-fit: cover; /* Corta a imagem para preencher o espaço */
    }
    .img-card {
        overflow: hidden; /* Oculta partes da imagem que estão fora do contêiner */
    }

        .nav-bar .nav-items a {
            color: #fff;
            margin-right: 15px;
            text-decoration: none;
        }

        .home {
            background: url('images/fundo.jpg') no-repeat center center;
            background-size: cover;
            height: 80vh;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
        }
		
		.busca {
            background: url('images/fundobusca.jpg') no-repeat center center;
            background-size: cover;
            height: 80vh;
            color: black;
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
    <div class="container d-flex justify-content-between align-items-center">
        <a href="#" class="logo"><img src="images/logotiago.png" alt="Logo"></a>
        <nav class="nav-bar">
            <a href="index.php" class="text-white">Início</a>
        </nav>
    </div>
</header>

<div class="container mt-5">

    <div class="row mb-5">
        <!-- Property Details -->
        <?php if ($data) { ?>
            <div class="col-md-6 text-center">
                <img id="post" class="property-image mb-2" src="fotos/<?php echo $res[$position]; ?>" alt="Imagem do Imóvel">
                <p id="pic" class="text-muted">Foto: <?= $position + 1 ?>/<?= $count ?></p>
                <form method="POST" class="d-flex justify-content-between w-50 mx-auto">
                    <input type="hidden" name="position" value="<?= $position ?>">
                    <button name="minus" class="btn btn-outline-secondary">Anterior</button>
                    <button name="add" class="btn btn-outline-secondary">Próximo</button>
                </form>

                <div class="button-container mt-4">
                    <a href="https://api.whatsapp.com/send?phone=5511XXXXXXXXX&text=Gostaria de saber mais sobre o imóvel <?php echo $data["titulo"]; ?>" class="btn btn-contact">Contato</a>
                    <a href="http://projetotiagocorretor.rf.gd/index.php#imoveis" class="btn btn-primary">Nova Busca</a>
                </div>
            </div>

            <div class="col-md-6">
                <h1 class="mb-4"><?php echo $data["titulo"]; ?></h1>
                <div class="property-details">
                    <h3 class="mb-3">Detalhes do Imóvel</h3>
                    <ul class="property-info">
                        <li><strong>Categoria:</strong> <?php echo $data["categoria"]; ?></li>
                        <li><strong>Valor:</strong> R$<?php echo number_format($data["valor"], 2, ',', '.'); ?></li>
                        <li><strong>Bairro:</strong> <?php echo $data["bairro"]; ?></li>
                    </ul>
                    <ul class="property-info">
                        <li><strong>Cidade:</strong> <?php echo $data["cidade"]; ?></li>
                        <li><strong>Estado:</strong> <?php echo $data["estado"]; ?></li>
                        <li><strong>CEP:</strong> <?php echo $data["cep"]; ?></li>
                    </ul>
                    <ul class="property-info">
                        <li><strong>Área Total:</strong> <?php echo $data["area_total"]; ?> m²</li>
                        <li><strong>Área Construída:</strong> <?php echo $data["area_construida"]; ?> m²</li>
                        <li><strong>Nº Quartos:</strong> <?php echo $data["num_quartos"]; ?></li>
                    </ul>
                    <ul class="property-info">
                        <li><strong>Nº Banheiros:</strong> <?php echo $data["num_banheiros"]; ?></li>
                        <li><strong>Nº Vagas:</strong> <?php echo $data["num_vagas"]; ?></li>
                    </ul>
                    <p><?php echo $data["descricao"]; ?></p>
                </div>
            </div>
        <?php } ?>
    </div>

    
</div>


    <!-- Footer -->
    <footer>
        <div class="container footer-container">
            <div class="group">
                <h4>Tiago F Souza - Corretor de Imóveis</h4>
                <p>Contato: (11) 1234-5678</p>
                <p>Email: emailcontato@exemplo.com</p>
                <p>Endereço: R: , 1000, Ferraz, SP, CEP: 08248-999</p>
            </div>
            <div class="follow group">
                <h5>Siga nas redes sociais</h5>
                <ul>
                    <li><a href="#"><i class="icofont-facebook text-white"></i></a></li>
					 <li><a href="#"><i class="icofont-instagram text-white"></i></a></li>
					  <li><a href="#"><i class="icofont-whatsapp text-white"></i></a></li>
					 
               
                </ul>
				
				 <a href="#" class="logo">
                     <img src="images/logotiago.png" alt="Logo" class="img-fluid">
                </a>
				
            </div>
        </div>
        <p class="text-center mt-5">&copy; 2024 Tiago F Souza - Todos os direitos reservados.</p>
    </footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
