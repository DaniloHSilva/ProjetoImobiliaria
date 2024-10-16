<?php
include('protect.php');

if(!empty($_GET['id'])){
    include('../conn.php');

    $id = $_GET['id'];
    
    $sqlSelect = "SELECT * FROM aluguel WHERE id=$id";
    $resultad = $mysqli->query($sqlSelect);

    if($resultad->num_rows > 0){
        while($post_data = mysqli_fetch_array($resultad)){
            $vTitulo = $post_data["titulo"];
            $vDesc = $post_data["descricao"];
            $vCat = $post_data["categoria"];
            $vValue = $post_data["valor"];
            $vEndereco = $post_data["endereco"];
            $vBairro = $post_data["bairro"];
            $vCidade = $post_data["cidade"];
            $vEstado = $post_data["estado"];
            $vCep = $post_data["cep"];
            $vAreaTotal = $post_data["area_total"];
            $vAreaConstruida = $post_data["area_construida"];
            $vNumQuartos = $post_data["num_quartos"];
            $vNumBanheiros = $post_data["num_banheiros"];
            $vNumVagas = $post_data["num_vagas"];
        }
    } else {
        header("Location: painel.php");
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
                    <img src="../images/logo.png" alt="Logo">
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
    
<main class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1 class="text-center mb-4">Editar Imóvel</h1>
            <form action="savedit_aluguel.php" method="POST" enctype="multipart/form-data">
                
                <!-- Campo Título -->
                <div class="form-group mb-3">
                    <label for="titulo">Título</label>
                    <input type="text" class="form-control" name="titulo" id="titulo" value="<?php echo $vTitulo;?>" placeholder="Título">
                </div>

                <!-- Campo Descrição -->
                <div class="form-group mb-3">
                    <label for="descp">Descrição</label>
                    <textarea class="form-control" name="descp" id="descp" rows="5" placeholder="Descrição"><?php echo $vDesc;?></textarea>
                </div>

                <!-- Campo Categoria -->
                <div class="form-group mb-3">
                    <label for="categ">Categoria</label>
                    <select class="form-select" name="categ" id="categ">
                        <option value="<?php echo $vCat;?>" selected><?php echo $vCat;?></option>
                        <option value="Apartamento">Apartamento</option>
                        <option value="Casa">Casa</option>
                        <option value="Sitio">Sítio</option>
                        <option value="Fazenda">Fazenda</option>
                    </select>
                </div>

                <!-- Campo Valor -->
                <div class="form-group mb-3">
                    <label for="valor">Valor</label>
                    <input type="text" class="form-control" name="valor" id="valor" value="<?php echo $vValue;?>" placeholder="Valor">
                </div>

                <!-- Campo Endereço -->
                <div class="form-group mb-3">
                    <label for="endereco">Endereço</label>
                    <input type="text" class="form-control" name="endereco" id="endereco" value="<?php echo $vEndereco;?>" placeholder="Endereço">
                </div>

                <!-- Campo Bairro -->
                <div class="form-group mb-3">
                    <label for="bairro">Bairro</label>
                    <input type="text" class="form-control" name="bairro" id="bairro" value="<?php echo $vBairro;?>" placeholder="Bairro">
                </div>

                <!-- Campo Cidade -->
                <div class="form-group mb-3">
                    <label for="cidade">Cidade</label>
                    <input type="text" class="form-control" name="cidade" id="cidade" value="<?php echo $vCidade;?>" placeholder="Cidade">
                </div>

                <!-- Campo Estado -->
                <div class="form-group mb-3">
                    <label for="estado">Estado</label>
                    <input type="text" class="form-control" name="estado" id="estado" value="<?php echo $vEstado;?>" placeholder="Estado">
                </div>

                <!-- Campo CEP -->
                <div class="form-group mb-3">
                    <label for="cep">CEP</label>
                    <input type="text" class="form-control" name="cep" id="cep" value="<?php echo $vCep;?>" placeholder="CEP">
                </div>

                <!-- Campo Área Total -->
                <div class="form-group mb-3">
                    <label for="area_total">Área Total (m²)</label>
                    <input type="text" class="form-control" name="area_total" id="area_total" value="<?php echo $vAreaTotal;?>" placeholder="Área Total">
                </div>

                <!-- Campo Área Construída -->
                <div class="form-group mb-3">
                    <label for="area_construida">Área Construída (m²)</label>
                    <input type="text" class="form-control" name="area_construida" id="area_construida" value="<?php echo $vAreaConstruida;?>" placeholder="Área Construída">
                </div>

                <!-- Campo Número de Quartos -->
                <div class="form-group mb-3">
                    <label for="num_quartos">Número de Quartos</label>
                    <input type="number" class="form-control" name="num_quartos" id="num_quartos" value="<?php echo $vNumQuartos;?>" placeholder="Número de Quartos">
                </div>

                <!-- Campo Número de Banheiros -->
                <div class="form-group mb-3">
                    <label for="num_banheiros">Número de Banheiros</label>
                    <input type="number" class="form-control" name="num_banheiros" id="num_banheiros" value="<?php echo $vNumBanheiros;?>" placeholder="Número de Banheiros">
                </div>

                <!-- Campo Número de Vagas -->
                <div class="form-group mb-3">
                    <label for="num_vagas">Número de Vagas</label>
                    <input type="number" class="form-control" name="num_vagas" id="num_vagas" value="<?php echo $vNumVagas;?>" placeholder="Número de Vagas">
                </div>

                <!-- Campo oculto para ID -->
                <input type="hidden" name="id" value="<?php echo $id?>">

                <!-- Botões de ação -->
                <div class="d-flex justify-content-between">
                    <input type="submit" name="update" class="btn btn-primary" value="Editar">
                    <button type="button" class="btn btn-secondary" onclick="window.location.href='painel.php'">Cancelar</button>
                </div>

            </form>
        </div>
    </div> <br>
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
                    <img src="../images/logo.png" alt="Logo">
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
