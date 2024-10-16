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
    $cidade_nome = $mysqli->real_escape_string($_GET['cidade_nome']); // Ajustado para 'cidade' para corresponder ao nome correto
    $bairro = $mysqli->real_escape_string($_GET['bairro']);

    // Selecionar da tabela correspondente
    $table = ($negocio === 'venda') ? 'venda' : 'aluguel'; // Atenção para a capitalização
    $query = "SELECT * FROM $table WHERE 1=1";

    if ($categ !== 'SemCategoria') {
        $query .= " AND categoria = '$categ'";
    }
    if (!empty($cidade_nome)) {
        $query .= " AND cidade = '$cidade_nome'"; // Certifique-se de que este campo exista
    }
    if (!empty($bairro)) {
        $query .= " AND bairro = '$bairro'"; // Ajuste para o campo correto da tabela
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: Arial, sans-serif; background-color: #f8f9fa; }
        header { background-color: #343a40; padding: 20px; color: #fff; }
        footer { background-color: #343a40; color: #ffffff; padding: 40px 0; text-align: center; }
        .property-image { max-width: 100%; height: auto; border-radius: 10px; }
        .search-form { background-color: #212529; padding: 20px; border-radius: 5px; }
    </style>
</head>
<body>

<header>
    <div class="container d-flex justify-content-between align-items-center">
        <a href="#" class="logo"><img src="images/logo.png" alt="Logo" style="width: 250px;"></a>
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
                <form action="busca.php" method="GET" class="search-form">
                    <div class="mb-3">
                        <center><h4 class="text-white mb-3">Buscar Novo Imóvel</h4></center>
                        <label class="form-label text-white">Você Deseja:</label>
                        <div class="btn-group" role="group">
                            <input type="radio" class="btn-check" name="negocio" id="venda-btn" value="venda" onclick="enableNextFields()">
                            <label class="btn btn-outline-light" for="venda-btn">Comprar</label>
                            <input type="radio" class="btn-check" name="negocio" id="aluguel-btn" value="aluguel" onclick="enableNextFields()">
                            <label class="btn btn-outline-light" for="aluguel-btn">Alugar</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="categ" class="form-label text-white">Tipo de Imóvel</label>
                        <select name="categ" id="categ" class="form-select" disabled onclick="enableNextFields()">
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
                    <div class="mb-3">
                        <label for="cidade" class="form-label text-white">Cidade</label>
                        <select name="cidade" id="cidade" class="form-select" disabled onchange="updateBairros(); enableNextFields()">
                            <option value="" selected>Selecione a cidade</option>
                             <?php
                                        if ($cidades_result->num_rows > 0) {
                                            while ($row = $cidades_result->fetch_assoc()) {
                                                // O valor é o ID, mas não será passado no GET
                                                echo "<option value=\"{$row['nome']}\" data-id=\"{$row['id']}\">{$row['nome']}</option>";
                                            }
                                        }
                                        ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="bairro" class="form-label text-white">Bairros</label>
                        <select name="bairro" id="bairro" class="form-select" disabled onchange="enableNextFields()">
                            <option value="" selected>Selecione o bairro</option>
                        </select>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Buscar</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Resultados da Busca -->
        <div class="col-md-8">
            <h2 class="text-center">Resultados da Busca</h2>
            <div class="row">
                <?php if (count($imoveis) > 0): ?>
                    <?php foreach ($imoveis as $imovel): ?>
                        <div class="col-md-4 mb-4">
                            <div class="card">
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
        </div>
    </div>
</div>

<footer>
    <div class="container">
        <p>&copy; 2024 Tiago F Souza - Todos os direitos reservados.</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

                        <script>
                            function enableNextFields() {
                                const negocio = document.querySelector('input[name="negocio"]:checked');
                                const categ = document.getElementById('categ');
                                const cidade = document.getElementById('cidade');
                                const bairro = document.getElementById('bairro');
                                const searchBtn = document.getElementById('search-btn');

                                categ.disabled = !negocio; // Habilita categoria se um negócio for selecionado
                                cidade.disabled = categ.value === "SemCategoria"; // Habilita cidade se uma categoria for selecionada
                                bairro.disabled = !cidade.value; // Habilita bairro se uma cidade for selecionada

                                // Habilita o botão de busca se tipo de imóvel e cidade estiverem selecionados
                                searchBtn.disabled = !(negocio && categ.value !== "SemCategoria" && cidade.value);
                            }
                        </script>

                        <script>
                            const bairros = <?php echo json_encode($bairros); ?>;

                            function updateBairros() {
                                const cidadeSelect = document.getElementById('cidade');
                                const cidadeNome = cidadeSelect.value; // Nome da cidade
                                const bairroSelect = document.getElementById('bairro');
                                
                                bairroSelect.innerHTML = '<option value="" selected>Selecione o bairro</option>';
                                
                                // Limpa o campo oculto de nome da cidade
                                document.getElementById('cidade_nome').value = '';

                                if (cidadeNome) {
                                    const cidadeId = cidadeSelect.options[cidadeSelect.selectedIndex].getAttribute('data-id'); // ID da cidade

                                    if (bairros[cidadeId]) {
                                        bairros[cidadeId].forEach(bairro => {
                                            const option = document.createElement('option');
                                            option.value = bairro.nome; // O valor do bairro continua sendo o nome
                                            option.textContent = bairro.nome; // Exibição do nome do bairro
                                            bairroSelect.appendChild(option);
                                        });
                                    }

                                    // Define o nome da cidade no campo oculto
                                    document.getElementById('cidade_nome').value = cidadeNome; // Armazena o nome da cidade
                                }
                            }
                        </script>

                        <script>
                            document.querySelector('form').addEventListener('submit', function (e) {
                                // No submit, o nome da cidade já está no campo oculto, não precisa fazer mais nada
                            });
                        </script>
</body>
</html>
