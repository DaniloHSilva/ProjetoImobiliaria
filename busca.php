<?php 
include("conn.php");

// Definir charset
$mysqli->set_charset("utf8mb4");

// Buscar cidades
$cidades_query = "SELECT id, nome FROM cidades ORDER BY nome";
$cidades_result = $mysqli->query($cidades_query);

// Buscar bairros
$bairros_query = "SELECT id, nome, cidade_id FROM bairros ORDER BY nome";
$bairros_result = $mysqli->query($bairros_query);

$bairros = [];
if ($bairros_result->num_rows > 0) {
    while ($row = $bairros_result->fetch_assoc()) {
        $bairros[$row['cidade_id']][] = $row;
    }
}

// Processar a busca
$imoveis = [];
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['negocio'])) {
    $negocio = $mysqli->real_escape_string($_GET['negocio']);
    $categ = $mysqli->real_escape_string($_GET['categ']);
    $cidade_nome = $mysqli->real_escape_string($_GET['cidade_nome']);
    $bairro = $mysqli->real_escape_string($_GET['bairro']);

    $table = ($negocio === 'venda') ? 'venda' : 'aluguel';
    $query = "SELECT * FROM $table WHERE 1=1";

    if ($categ !== 'SemCategoria') {
        $query .= " AND categoria = '$categ'";
    }
    if (!empty($cidade_nome)) {
        $query .= " AND cidade = '$cidade_nome'";
    }
    if (!empty($bairro)) {
        $query .= " AND bairro = '$bairro'";
    }

    $result = $mysqli->query($query);
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $imoveis[] = $row;
        }
    } else {
        echo "<pre>Error: " . $mysqli->error . "</pre>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Busca de Imóveis</title>
    <link href="css/icofont/icofont.min.css" rel="stylesheet">
  <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        body { font-family: Arial, sans-serif; background-color: #f8f9fa; }
        header { background-color: #343a40; padding: 20px; color: #fff; }
        footer { background-color: #343a40; color: #ffffff; padding: 40px 0; text-align: center; }
        .property-image { max-width: 100%; height: auto; border-radius: 10px; }
        .search-form { background-color: #212529; padding: 20px; border-radius: 5px; }
        .card { transition: transform 0.2s; }
        .card:hover { transform: scale(1.05); }
        .btn-primary { background-color: #007bff; border-color: #007bff; }
        .btn-primary:hover { background-color: #0056b3; border-color: #0056b3; }
		
		
		
		
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

<header>
    <div class="container d-flex justify-content-between align-items-center">
        <a href="#" class="logo"><img src="images/logotiago.png" alt="Logo" style="width: 250px;"></a>
        <nav class="nav-bar">
            <a href="index.php" class="text-white">Início</a>
        </nav>
    </div>
</header>

<div class="container mt-4">
    <h2 class="text-center">Resultados da Busca</h2>
    <div class="row">
        <?php if (count($imoveis) > 0): ?>
            <?php foreach ($imoveis as $imovel): ?>
                <div class="col-md-4 mb-4">
                    <div class="card shadow">
                        <img src="fotos/<?php echo $imovel['foto']; ?>" class="property-image" alt="<?php echo htmlspecialchars($imovel['titulo'], ENT_QUOTES, 'UTF-8'); ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($imovel['titulo'], ENT_QUOTES, 'UTF-8'); ?></h5>
                            <p class="card-text"><?php echo htmlspecialchars($imovel['descricao'], ENT_QUOTES, 'UTF-8'); ?></p>
                            <a href="detalhe.php?id=<?php echo $imovel['id']; ?>&status=<?php echo $negocio; ?>" class="btn btn-primary">Saiba Mais</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-center">Nenhum imóvel encontrado.</p>
        <?php endif; ?>
    </div>
    <div class="text-center">
        <a href="index.php#imoveis" class="btn btn-lg btn-success">Nova Busca</a>
    </div>
</div><br>


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
