<?php
include("conn.php");

// Recupera os detalhes da propriedade com base no ID da URL
$pag = $_GET['id'];
$consulta = "SELECT * FROM venda WHERE id = ?";
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
        .property-info { display: flex; flex-wrap: wrap; gap: 20px; list-style: none; padding: 0; }
        .property-info li { flex: 1 1 calc(33.333% - 20px); }
        .search-form { background-color: #212529; padding: 20px; border-radius: 5px; }
        .form-container { max-width: 400px; }
        .btn-contact { background-color: #28a745; color: white; }
        @media (min-width: 768px) {
            .form-container { flex-direction: column; }
            .property-details { flex: 1; }
        }
    </style>
</head>

<body>

<!-- Navbar -->
<header>
    <div class="container d-flex justify-content-between align-items-center">
        <a href="#" class="logo"><img src="images/logo.png" alt="Logo"></a>
        <nav class="nav-bar">
            <a href="index.php" class="text-white">Início</a>
        </nav>
    </div>
</header>

<div class="container mt-5">

    <div class="row mb-5">

        <!-- Search Form -->
        <div class="col-md-4">
            <div class="form-container">
                <form action="sca.php" method="GET" class="search-form">
                    <div class="mb-3">
                        <center><h4 class="text-white mb-3">Buscar Novo Imóvel</h4></center>
                        <label class="form-label text-white">Você Deseja:</label>
                        <div class="btn-group" role="group">
                            <input type="radio" class="btn-check" name="negocio" id="venda-btn" value="Venda" required>
                            <label class="btn btn-outline-light" for="venda-btn">Comprar</label>
                            <input type="radio" class="btn-check" name="negocio" id="aluguel-btn" value="Aluguel">
                            <label class="btn btn-outline-light" for="aluguel-btn">Alugar</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="tipo_imovel" class="form-label text-white">Tipo de Imóvel</label>
                        <select name="categ" id="categ" class="form-select" required>
                            <option value="" selected>Categoria</option>
                            <option value="Apartamento">Apartamento</option>
                            <option value="Casa">Casa</option>
                            <option value="Casa de Condomínio">Casa de Condomínio</option>
                            <option value="Kitnet">Kitnet</option>
                            <option value="Sítio">Sítio</option>
                            <option value="Sobrado">Sobrado</option>
                            <option value="Fazenda">Fazenda</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="cidade" class="form-label text-white">Cidade</label>
                        <select name="cidade" id="cidade" class="form-select" onchange="updateBairros()">
                            <option value="" selected>Selecione a cidade</option>
                            <?php
                            $cidades_result = $mysqli->query("SELECT * FROM cidades");
                            while ($row = $cidades_result->fetch_assoc()) {
                                echo "<option value=\"{$row['id']}\">{$row['nome']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="bairro" class="form-label text-white">Bairros</label>
                        <select name="bairro" id="bairro" class="form-select">
                            <option value="" selected>Selecione o bairro</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="num_quartos" class="form-label text-white">Número de Quartos</label>
                        <input type="number" name="num_quartos" id="num_quartos" class="form-control" placeholder="Digite o número de quartos">
                    </div>
                    <div class="mb-3">
                        <label for="num_vagas" class="form-label text-white">Vagas de Garagem</label>
                        <input type="number" name="num_vagas" id="num_vagas" class="form-control" placeholder="Digite o número de vagas">
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Buscar</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Property Details -->
        <?php if ($data) { ?>
            <div class="col-md-8">
                <div class="text-center mb-4">
                    <h1 class="mb-4"><?php echo $data["titulo"]; ?></h1>
                    <img id="post" class="property-image mb-2" src="fotos/<?php echo $res[$position]; ?>" alt="Imagem do Imóvel">
                    <p id="pic" class="text-muted">Foto: <?= $position + 1 ?>/<?= $count ?></p>
                    <form method="POST" class="d-flex justify-content-between w-50 mx-auto">
                        <input type="hidden" name="position" value="<?= $position ?>">
                        <button name="minus" class="btn btn-outline-secondary">Anterior</button>
                        <button name="add" class="btn btn-outline-secondary">Próximo</button>
                    </form>
                </div>
                <div class="property-details">
                    <h3 class="mb-3">Detalhes do Imóvel</h3>
                    <div class="property-info">
                        <li><strong>Categoria:</strong> <?php echo $data["categoria"]; ?></li>
                        <li><strong>Valor:</strong> R$<?php echo number_format($data["valor"], 2, ',', '.'); ?></li>
                        <li><strong>Bairro:</strong> <?php echo $data["bairro"]; ?></li>
                        <li><strong>Cidade:</strong> <?php echo $data["cidade"]; ?></li>
                        <li><strong>Estado:</strong> <?php echo $data["estado"]; ?></li>
                        <li><strong>CEP:</strong> <?php echo $data["cep"]; ?></li>
                        <li><strong>Área Total:</strong> <?php echo $data["area_total"]; ?> m²</li>
                        <li><strong>Área Construída:</strong> <?php echo $data["area_construida"]; ?> m²</li>
                        <li><strong>Nº Quartos:</strong> <?php echo $data["num_quartos"]; ?></li>
                        <li><strong>Nº Banheiros:</strong> <?php echo $data["num_banheiros"]; ?></li>
                        <li><strong>Nº Vagas:</strong> <?php echo $data["num_vagas"]; ?></li>
                    </div>
                    <p><?php echo $data["descricao"]; ?></p>
                    <a href="https://api.whatsapp.com/send?phone=5511XXXXXXXXX&text=Gostaria de saber mais sobre o imóvel <?php echo $data["titulo"]; ?>. Valor: R$<?php echo number_format($data["valor"], 2, ',', '.'); ?>" class="btn btn-contact">Contato pelo WhatsApp</a>
                </div>
            </div>
        <?php } else { ?>
            <div class="col-md-8">
                <p>Dados não encontrados.</p>
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
            <p>Endereço: R: Estevão Leão Burroul, 1378, Franca, SP, CEP: 14400-750</p>
        </div>
        <div class="follow group">
            <h5>Siga nas redes sociais</h5>
            <ul class="list-inline">
                <li class="list-inline-item"><a href="#"><i class="icofont-facebook text-white"></i></a></li>
                <li class="list-inline-item"><a href="#"><i class="icofont-instagram text-white"></i></a></li>
                <li class="list-inline-item"><a href="#"><i class="icofont-whatsapp text-white"></i></a></li>
            </ul>
            <a href="#" class="logo"><img src="images/logo.png" alt="Logo"></a>
        </div>
    </div>
    <p class="text-center mt-5">&copy; 2024 Tiago F Souza - Todos os direitos reservados.</p>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    const bairros = <?php echo json_encode($bairros); ?>;

    function updateBairros() {
        const cidadeId = document.getElementById('cidade').value;
        const bairroSelect = document.getElementById('bairro');
        
        bairroSelect.innerHTML = '<option value="" selected>Selecione o bairro</option>';
        
        if (cidadeId && bairros[cidadeId]) {
            bairros[cidadeId].forEach(bairro => {
                const option = document.createElement('option');
                option.value = bairro.id;
                option.textContent = bairro.nome;
                bairroSelect.appendChild(option);
            });
        }
    }
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
