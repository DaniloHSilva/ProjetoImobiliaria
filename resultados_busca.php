<?php
include("conn.php");

// Obtém os parâmetros da busca e protege contra injeção SQL
$negocio = mysqli_real_escape_string($mysqli, $_GET['negocio']);
$categ = mysqli_real_escape_string($mysqli, $_GET['categ']);
$cidade = mysqli_real_escape_string($mysqli, $_GET['cidade']);
$valor_inicial = mysqli_real_escape_string($mysqli, $_GET['valor_inicial']);
$valor_final = mysqli_real_escape_string($mysqli, $_GET['valor_final']);
$num_quartos = mysqli_real_escape_string($mysqli, $_GET['num_quartos']);
$num_vagas = mysqli_real_escape_string($mysqli, $_GET['num_vagas']);

// Inicializa a consulta
$sql = "SELECT * FROM $negocio WHERE 1=1";

// Adiciona condições baseadas nos parâmetros fornecidos
if (!empty($categ) && $categ != 'SemCategoria') {
    $sql .= " AND categoria='$categ'";
}

if (!empty($cidade)) {
    $sql .= " AND cidade='$cidade'";
}

if (!empty($valor_inicial) && is_numeric($valor_inicial)) {
    $sql .= " AND valor >= $valor_inicial";
}

if (!empty($valor_final) && is_numeric($valor_final)) {
    $sql .= " AND valor <= $valor_final";
}

if (!empty($num_quartos) && is_numeric($num_quartos)) {
    $sql .= " AND num_quartos >= $num_quartos";
}

if (!empty($num_vagas) && is_numeric($num_vagas)) {
    $sql .= " AND num_vagas >= $num_vagas";
}

// Executa a consulta
$result = $mysqli->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tiago F Souza - Corretor de Imóveis</title>
    <script src="https://cdn.jsdelivr.net/npm/inputmask@5.0.6/dist/inputmask.min.js"></script>
    <link href="css/icofont/icofont.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
    <header>
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <a href="#" class="logo">
                    <img src="images/logo.png" alt="Logo">
                </a>
                <nav class="nav-bar">
                    <div class="nav-items">
                        <a href="#home">Início</a>
                        <a href="#about">Sobre</a>
                        <a href="#imoveis">Imóveis</a>
                    </div>
                </nav>
            </div>
        </div>
    </header>
	
	<section class="container-fluid " id="imoveis">
    <div class="container-fluid">
        <div class="row g-4">
            <div class="container-fluid">
                <div class="row justify-content-center  busca">
                    <div class="col-md-8">
                        <h2 class="text-center mb-4"> <b>Buscar Imóveis</h2>
                        <form action="resultados_busca.php" method="GET" class="formulario-busca">
                            <div class="row">
                                <!-- Tipo de Negócio -->
                                <div class="col-md-12 mb-3">
                                    <select name="negocio" id="negocio" class="form-select">
                                        <option value="" selected>Selecione</option>
                                        <option value="Venda">Venda</option>
                                        <option value="Aluguel">Locação</option>
                                    </select>
                                </div>

                                <!-- Tipo de Imóvel -->
                                <div class="col-md-6 mb-3">
                                    <label for="tipo_imovel" class="form-label">Tipo de Imóvel</label>
                                    <select name="categ" id="categ" class="form-select" required>
                                        <option value="SemCategoria" selected>Categoria</option>
                                        <option value="Apartamento">Apartamento</option>
                                        <option value="Casa">Casa</option>
                                        <option value="Casa de Condomínio">Casa de Condomínio</option>
                                        <option value="Kitnet">Kitnet</option>
                                        <option value="Sítio">Sítio</option>
                                        <option value="Sobrado">Sobrado</option>
                                        <option value="Fazenda">Fazenda</option>
                                    </select>
                                </div>

                                <!-- Cidade -->
                                <div class="col-md-6 mb-3">
                                    <label for="cidade" class="form-label">Cidade</label>
                                    <select name="cidade" id="cidade" class="form-select">
                                        <option value="" selected>Selecione a cidade</option>
                                        <option value="Arujá">Arujá</option>
                                        <option value="Biritiba-Mirim">Biritiba-Mirim</option>
                                        <option value="Ferraz de Vasconcelos">Ferraz de Vasconcelos</option>
                                        <option value="Guararema">Guararema</option>
                                        <option value="Guarulhos">Guarulhos</option>
                                        <option value="Itaquaquecetuba">Itaquaquecetuba</option>
                                        <option value="Mogi das Cruzes">Mogi das Cruzes</option>
                                        <option value="Poá">Poá</option>
                                        <option value="Salesópolis">Salesópolis</option>
                                        <option value="Santa Isabel">Santa Isabel</option>
                                        <option value="São Paulo">São Paulo</option>
                                        <option value="Suzano">Suzano</option>
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
									<label for="valor_inicial" class="form-label">Valor Inicial</label>
									<input type="text" name="valor_inicial" id="valor_inicial" class="form-control" placeholder="Digite o valor inicial">
								</div>
								<div class="col-md-6 mb-3">
									<label for="valor_final" class="form-label">Valor Final</label>
									<input type="text" name="valor_final" id="valor_final" class="form-control" placeholder="Digite o valor final">
								</div>


                                <!-- Número de Quartos e Vagas de Garagem -->
                                <div class="col-md-6 mb-3">
                                    <label for="num_quartos" class="form-label">Número de Quartos</label>
                                    <input type="number" name="num_quartos" id="num_quartos" class="form-control" placeholder="Digite o número de quartos">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="num_vagas" class="form-label">Número de Vagas de Garagem</label>
                                    <input type="number" name="num_vagas" id="num_vagas" class="form-control" placeholder="Digite o número de vagas">
                                </div>

                                <!-- Botão de Pesquisa -->
                                <div class="col-md-12 mb-3 text-center">
                                    <button type="submit" class="btn btn-primary">Buscar</button>
                                </div>
                            </div>
                        </form> <hr>
					</div>
				</div>	

    <div class="container mt-5">
        <h2>Resultados da Busca</h2>
        <?php if ($result->num_rows > 0): ?>
            <div class="row">
                <?php while($row = $result->fetch_assoc()): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <?php if (!empty($row['foto']) && file_exists($row['foto'])): ?>
                                <img src="<?php echo htmlspecialchars($row['foto']); ?>" class="card-img-top" alt="Imagem do Imóvel">
                            <?php else: ?>
                                <img src="images/default-image.jpg" class="card-img-top" alt="Imagem do Imóvel">
                            <?php endif; ?>
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($row['titulo']); ?></h5>
                                <p class="card-text"><?php echo htmlspecialchars($row['descricao']); ?></p>
                                <p class="card-text"><strong>Valor:</strong> R$ <?php echo number_format($row['valor'], 2, ',', '.'); ?></p>
                                <p class="card-text"><strong>Categoria:</strong> <?php echo htmlspecialchars($row['categoria']); ?></p>
                                <p class="card-text"><strong>Cidade:</strong> <?php echo htmlspecialchars($row['cidade']); ?></p>
                                <p class="card-text"><strong>Quartos:</strong> <?php echo htmlspecialchars($row['num_quartos']); ?></p>
                                <p class="card-text"><strong>Vagas:</strong> <?php echo htmlspecialchars($row['num_vagas']); ?></p>
                                <a href="#" class="btn btn-primary">Ver Detalhes</a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <p>Nenhum resultado encontrado.</p>
        <?php endif; ?>
    </div>

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
                    <img src="images/logo.png" alt="Logo">
                </a>
            </div>
        </div>
        <p class="text-center mt-5">&copy; 2024 Tiago F Souza - Todos os direitos reservados.</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function formatCurrency(value) {
            value = value.replace(/\D/g, '');
            let decimalPart = value.slice(-2);
            let integerPart = value.slice(0, -2);

            if (integerPart === '') {
                integerPart = '0';
            }

            integerPart = integerPart.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            if (integerPart === '0') {
                integerPart = '';
            }

            return `${integerPart}${decimalPart ? ',' + decimalPart : ',00'}`;
        }

        function onInput(event) {
            event.target.value = formatCurrency(event.target.value.replace(/\D/g, ''));
            const length = event.target.value.length;
            event.target.setSelectionRange(length, length);
        }

        document.addEventListener('DOMContentLoaded', function() {
            const valorInicial = document.getElementById('valor_inicial');
            const valorFinal = document.getElementById('valor_final');

            valorInicial.addEventListener('input', onInput);
            valorFinal.addEventListener('input', onInput);
        });
    </script>

    <div vw class="enabled">
        <div vw-access-button class="active"></div>
        <div vw-plugin-wrapper>
            <div class="vw-plugin-top-wrapper"></div>
        </div>
    </div>
    <script src="https://vlibras.gov.br/app/vlibras-plugin.js"></script>
    <script>
        new window.VLibras.Widget('https://vlibras.gov.br/app');
    </script>
</body>
</html>
