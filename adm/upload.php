<?php
include('protect.php');
?>


<?php
    include ("../conn.php");
	
	

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
    <div class="row justify-content-center">
        <div class="col-md-10">
            <h1 class="text-center mb-4">Cadastrar Imóveis</h1>
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <!-- Tipo de Imóvel -->
                    <div class="col-md-6 mb-3">
                        <label for="tipo_imovel" class="form-label">Tipo de Imóvel</label>
                        <select name="tipo_imovel" id="tipo_imovel" class="form-select" required>
                            <option value="" selected>Selecione</option>
                            <option value="venda">Imóvel para Venda</option>
                            <option value="aluguel">Imóvel para Aluguel</option>
                        </select>
                    </div>
                    
                    <!-- Título -->
                    <div class="col-md-6 mb-3">
                        <label for="titulo" class="form-label">Título</label>
                        <input type="text" class="form-control" name="titulo" id="titulo" placeholder="Título" required>
                    </div>
                </div>

                <div class="row">
                    <!-- Descrição -->
                    <div class="col-md-12 mb-3">
                        <label for="descp" class="form-label">Descrição</label>
                        <textarea name="descp" id="descp" class="form-control" placeholder="Descrição" rows="5" required></textarea>
                    </div>
                </div>

                <div class="row">
                    <!-- Categoria -->
                    <div class="col-md-6 mb-3">
                        <label for="categ" class="form-label">Categoria</label>
                        <select name="categ" id="categ" class="form-select" required>
                            <option value="SemCategoria" selected>Categoria</option>
                            <option value="Apartamento">Apartamento</option>
                            <option value="Casa">Casa</option>
							<option value="Casa">Casa de Condomínio</option>
							<option value="Sitio">Kitnet</option>
                            <option value="Sitio">Sítio</option>
							<option value="Sitio">Sobrado</option>
                            <option value="Fazenda">Fazenda</option>
                        </select>
                    </div>

                    <!-- Valor -->
                    <div class="col-md-6 mb-3">
                        <label for="valor" class="form-label">Valor</label>
                        <input type="text" class="form-control" name="valor" id="valor" placeholder="Valor" required>
                    </div>
                </div>

                <div class="row">
                    <!-- Endereço -->
                    <div class="col-md-6 mb-3">
                        <label for="endereco" class="form-label">Endereço</label>
                        <input type="text" class="form-control" name="endereco" id="endereco" placeholder="Endereço">
                    </div>

                    <!-- Cidade -->
                    <div class="col-md-6 mb-3">
						  <label for="cidade" class="form-label">Cidade</label>
                <select name="cidade" id="cidade" class="form-select" onchange="updateBairros()">
                    <option value="" selected>Selecione a cidade</option>
                    <?php
                    if ($cidades_result->num_rows > 0) {
                        while ($row = $cidades_result->fetch_assoc()) {
                            echo "<option value=\"{$row['id']}\">{$row['nome']}</option>";
                        }
						
                    }
                    ?>
                </select>

                    </div>
                </div>

                <div class="row">
                    
					
					<!-- Bairro -->
                    <div class="col-md-6 mb-3">
                         <label for="bairro" class="form-label">Bairros</label>
                <select name="bairro" id="bairro" class="form-select">
                    <option value="" selected>Selecione o bairro</option>
                </select>
                    </div>

                    <!-- Estado -->
                    <div class="col-md-6 mb-3">
                        <label for="estado" class="form-label">Estado</label>
                        <input type="text" class="form-control" name="estado" id="estado" placeholder="Estado" required>
                    </div>
                </div>

                <div class="row">
                    <!-- CEP -->
                    <div class="col-md-6 mb-3">
                        <label for="cep" class="form-label">CEP</label>
                        <input type="text" class="form-control" name="cep" id="cep" placeholder="CEP">
                    </div>

                    <!-- Área Total -->
                    <div class="col-md-6 mb-3">
                        <label for="area_total" class="form-label">Área Total</label>
                        <input type="text" class="form-control" name="area_total" id="area_total" placeholder="Área Total">
                    </div>
                </div>

                <div class="row">
                    <!-- Área Construída -->
                    <div class="col-md-6 mb-3">
                        <label for="area_construida" class="form-label">Área Construída</label>
                        <input type="text" class="form-control" name="area_construida" id="area_construida" placeholder="Área Construída">
                    </div>

                    <!-- Número de Quartos -->
                    <div class="col-md-6 mb-3">
                        <label for="num_quartos" class="form-label">Número de Quartos</label>
                        <input type="number" class="form-control" name="num_quartos" id="num_quartos" placeholder="Número de Quartos">
                    </div>
                </div>

                <div class="row">
                    <!-- Número de Banheiros -->
                    <div class="col-md-6 mb-3">
                        <label for="num_banheiros" class="form-label">Número de Banheiros</label>
                        <input type="number" class="form-control" name="num_banheiros" id="num_banheiros" placeholder="Número de Banheiros">
                    </div>

                    <!-- Número de Vagas -->
                    <div class="col-md-6 mb-3">
                        <label for="num_vagas" class="form-label">Número de Vagas</label>
                        <input type="number" class="form-control" name="num_vagas" id="num_vagas" placeholder="Número de Vagas">
                    </div>
                </div>

                <div class="row">
                    <!-- Upload de Imagens -->
                    <div class="col-md-12 mb-3">
                        <label for="images" class="form-label">Upload de Imagens</label>
                        <input type="file" name="images[]" id="images" class="form-control" multiple required>
                    </div>
                </div>

                <div class="row">
                    <!-- Botões -->
                    <div class="col-md-12 d-flex justify-content-between">
                        <input type="submit" name="submit" value="Cadastrar" class="btn btn-primary">
                        <a href="painel.php" class="btn btn-secondary">Cancelar</a>
                    </div>
                </div>
            </form>
			 <script>
        const bairros = <?php echo json_encode($bairros); ?>;

        function updateBairros() {
            const cidadeId = document.getElementById('cidade').value;
            const bairroSelect = document.getElementById('bairro');
            
            bairroSelect.innerHTML = '<option value="" selected>Selecione o bairro</option>';
            
            if (cidadeId && bairros[cidadeId]) {
                bairros[cidadeId].forEach(bairro => {
                    const option = document.createElement('option');
                    option.value = bairro.nome;
                    option.textContent = bairro.nome;
                    bairroSelect.appendChild(option);
                });
            }
        }
    </script>
        </div>
    </div>
    <br>
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
	
	<script>
    function formatCurrency(value) {
        // Remove qualquer caractere que não seja número
        value = value.replace(/\D/g, '');

        // Adiciona a vírgula como separador decimal
        let decimalPart = value.slice(-2); // Últimos dois dígitos são os centavos
        let integerPart = value.slice(0, -2); // O restante é a parte inteira

        // Se a parte inteira estiver vazia, ajusta para "0"
        if (integerPart === '') {
            integerPart = '0';
        }

        // Adiciona pontos como separadores de milhar
        integerPart = integerPart.replace(/\B(?=(\d{3})+(?!\d))/g, '.');

        // Se a parte inteira for "0", remove o ponto inicial
        if (integerPart === '0') {
            integerPart = '';
        }

        // Constrói o valor formatado
        return `${integerPart}${decimalPart ? ',' + decimalPart : ',00'}`;
    }

    function onInput(event) {
        // Formata o valor atual, remove caracteres não numéricos antes de formatar
        event.target.value = formatCurrency(event.target.value.replace(/\D/g, ''));

        // Ajusta a posição do cursor para não pular para o início
        const length = event.target.value.length;
        event.target.setSelectionRange(length, length);
    }

    document.addEventListener('DOMContentLoaded', function() {
        const valor = document.getElementById('valor');

       
        valor.addEventListener('input', onInput);
    });
</script>

</body>
</html>


<?php
include('../conn.php');

if(isset($_POST['submit'])){
    // Inicializa variáveis
    $location = "../fotos/";
    $data = '';
    
    // Pega os dados do formulário
    $vTitulo = $_POST["titulo"];
    $vDesc = $_POST["descp"];
    $vCat = $_POST["categ"];
    $vValue = $_POST["valor"];
    $vEndereco = $_POST["endereco"];
    $vBairro = $_POST["bairro"];
    
    // Pega o ID da cidade
    $vCidadeId = $_POST["cidade"];

    // Consulta o nome da cidade
    $queryCidade = "SELECT nome FROM cidades WHERE id = '$vCidadeId'";
    $resultCidade = mysqli_query($mysqli, $queryCidade);
    
    // Verifica se a cidade foi encontrada
    if ($resultCidade && mysqli_num_rows($resultCidade) > 0) {
        $rowCidade = mysqli_fetch_assoc($resultCidade);
        $vCidade = $rowCidade['nome']; // Obtém o nome da cidade
    } else {
        // Caso não encontre, você pode definir um valor padrão ou lançar um erro
        $vCidade = 'Cidade não encontrada';
    }

    $vEstado = $_POST["estado"];
    $vCep = $_POST["cep"];
    $vAreaTotal = $_POST["area_total"];
    $vAreaConstruida = $_POST["area_construida"];
    $vNumQuartos = $_POST["num_quartos"];
    $vNumBanheiros = $_POST["num_banheiros"];
    $vNumVagas = $_POST["num_vagas"];

    // Verifica se os arquivos foram enviados
    if(isset($_FILES['images'])){
        foreach($_FILES['images']['name'] as $key => $val){
            // Captura o nome e o caminho temporário do arquivo
            $file = $_FILES['images']['name'][$key];
            $file_tmp = $_FILES['images']['tmp_name'][$key];

            // Gera um novo nome único para cada arquivo
            $extensao = strtolower(pathinfo($file, PATHINFO_EXTENSION)); // Obtém a extensão correta do arquivo
            $novo_nome = md5(time().$file).'.'.$extensao;

            // Move o arquivo para a pasta designada
            if(move_uploaded_file($file_tmp, $location.$novo_nome)){
                // Concatena o nome do arquivo com espaço
                $data .= $novo_nome." ";
            }
        }
    }
	
	$tipoImovel = $_POST['tipo_imovel'];

    // Exibe uma mensagem com base no valor selecionado
    if ($tipoImovel === 'venda') {
        // Insere os dados no banco de dados tabela Venda
        $query = "INSERT INTO venda (id, titulo, descricao, categoria, valor, endereco, bairro, cidade, estado, cep, area_total, area_construida, num_quartos, num_banheiros, num_vagas, foto) 
                  VALUES (null, '$vTitulo', '$vDesc', '$vCat', '$vValue', '$vEndereco', '$vBairro', '$vCidade', '$vEstado', '$vCep', '$vAreaTotal', '$vAreaConstruida', '$vNumQuartos', '$vNumBanheiros', '$vNumVagas', '$data')";
        $fire = mysqli_query($mysqli, $query);
        
        echo '<script type="text/javascript">';
        echo 'alert("Imóvel para Venda Cadastrado com Sucesso!");';
        echo 'window.location.href = "listar_venda.php";'; // Redireciona após o OK no alert
        echo '</script>';

    } elseif ($tipoImovel === 'aluguel') {
        // Insere os dados no banco de dados tabela aluguel
        $query = "INSERT INTO aluguel (id, titulo, descricao, categoria, valor, endereco, bairro, cidade, estado, cep, area_total, area_construida, num_quartos, num_banheiros, num_vagas, foto) 
                  VALUES (null, '$vTitulo', '$vDesc', '$vCat', '$vValue', '$vEndereco', '$vBairro', '$vCidade', '$vEstado', '$vCep', '$vAreaTotal', '$vAreaConstruida', '$vNumQuartos', '$vNumBanheiros', '$vNumVagas', '$data')";
        $fire = mysqli_query($mysqli, $query);
        
        echo '<script type="text/javascript">';
        echo 'alert("Imóvel para Locação Cadastrado com Sucesso!");';
        echo 'window.location.href = "listar_aluguel.php";'; // Redireciona após o OK no alert
        echo '</script>';

    } else {
        echo '<div class="alert alert-warning" role="alert">Por favor, selecione um tipo de imóvel.</div>';
    }
}
?>

