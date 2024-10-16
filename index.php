<?php
    include ("conn.php");
    $consulta = "SELECT * FROM venda";
    $con = $mysqli->query($consulta) or die($mysqli->error);
	
	

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
	
	<script src="https://cdn.jsdelivr.net/npm/inputmask@5.0.6/dist/inputmask.min.js"></script>
	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>

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
		
		
.formulario-busca {
    background-color: rgba(240, 240, 240, 0.8); /* Cinza claro com 80% de opacidade */
    padding: 20px; /* Adiciona um pouco de espaçamento interno */
    border-radius: 8px; /* Arredonda os cantos */
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Adiciona uma sombra leve */
}

}

		
		
    </style>
	
	
  </head>

  <body>
  
   <!-- Adicione o JS do Slick -->
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>



    <!-- Navbar -->
    <header>
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <a href="#" class="logo">
                    <img src="images/logotiago.png" alt="Logo" class="img-fluid">
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

    <!-- Home Section -->
    <section class="home" id="home">
        <div class="text-center">
            <h3>Tiago F Souza - Corretor de Imóveis</h3>
            <h4>CRECI: 281.492-F</h4>
            <a href="#imoveis" class="btn btn-primary mt-3">Busque um Imóvel</a>
        </div>
    </section>

    <!-- About Section -->
    <section class="about py-5" id="about">
        <div class="container">
            <h1 class="text-center mb-5">Sobre nós</h1>
            <div class="row">
                <div class="col-md-6">
                    <img src="images/sobre.png" class="img-fluid" alt="Sobre nós">
                </div>
                <div class="col-md-6">
                    <h4>Nossa <span>Missão</span></h4>
                    <p>Proporcionar aos nossos clientes a concretização de seus sonhos imobiliários com segurança, transparência e um atendimento personalizado.</p>
                    
                    <h4><span>Visão</span></h4>
                    <p>Ser referência no mercado imobiliário, destacando-se pela excelência no atendimento e responsabilidade social.</p>
                    
                    <h4><span>Valores</span></h4>
                    <ul>
                        <li>Transparência e respeito</li>
                        <li>Compromisso com o cliente</li>
                        <li>Inovação e qualidade</li>
                        <li>Sustentabilidade</li>
                        <li>Integridade</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
<!-- Portfolio (Imóveis) Section -->
<section class="container-fluid" id="imoveis">
    <div class="container-fluid">
        <div class="row g-4">
            <div class="container-fluid">
                <div class="row justify-content-center busca">
                    <div class="col-md-8">
                        <h2 class="text-center mb-4 text-white"><b>Buscar Imóveis</h2>
                        <form action="busca.php" method="GET" class="formulario-busca">
                            <div class="row">
                                <!-- Tipo de Negócio com Botões Estilizados -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Você Deseja:</label>
                                    <div class="btn-group" role="group" aria-label="Tipo de Negócio">
                                        <input type="radio" class="btn-check" name="negocio" id="venda-btn" value="venda" onclick="enableNextFields()">
                                        <label class="btn btn-outline-primary" for="venda-btn">Comprar</label>

                                        <input type="radio" class="btn-check" name="negocio" id="aluguel-btn" value="aluguel" onclick="enableNextFields()">
                                        <label class="btn btn-outline-primary" for="aluguel-btn">Alugar</label>
                                    </div>
                                </div>

                                <!-- Tipo de Imóvel -->
                                <div class="col-md-6 mb-3">
                                    <label for="categ" class="form-label">Tipo de Imóvel</label>
                                    <select name="categ" id="categ" class="form-select" disabled onchange="enableNextFields()">
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
                            </div>

                            <div class="row">
                                <!-- Cidade -->
                                <div class="col-md-6 mb-3">
                                    <label for="cidade" class="form-label">Cidade</label>
                                    <select id="cidade" class="form-select" disabled onchange="updateBairros(); enableNextFields()">
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

                                <!-- Bairro -->
                                <div class="col-md-6 mb-3">
                                    <label for="bairro" class="form-label">Bairros</label>
                                    <select name="bairro" id="bairro" class="form-select" disabled onchange="enableNextFields()">
                                        <option value="" selected>Selecione o bairro</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Campo Oculto para Nome da Cidade -->
                            <input type="hidden" name="cidade_nome" id="cidade_nome" />

                            <!-- Botão de Pesquisa -->
                            <div class="col-md-12 mb-3 text-center">
                                <button type="submit" class="btn btn-primary" disabled id="search-btn">Buscar</button>
                            </div>
                        </form>

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
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



<style>
.formulario-busca {
    background-color: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.form-label {
    font-weight: bold;
}

.btn-group {
    margin-top: 8px;
}

.text-center {
    margin-top: 20px;
}

.btn-outline-primary {
    transition: background-color 0.3s, color 0.3s;
}

.btn-outline-primary:hover {
    background-color: #007bff;
    color: white;
}

.form-select:disabled {
    background-color: #e9ecef;
}
</style>



<hr>

					</div>
				</div>	

		<div class="col-md-12">					
	<div class="col-md-12">					
	<!-- Destaques de Venda - Carousel -->
	<h2 class="text-center mb-4 mt-4">Destaques Para Venda</h2>
	<div id="carouselCompras" class="carousel slide" data-bs-ride="carousel">
		<div class="carousel-inner">
			<?php 
			$query = "SELECT * FROM venda ORDER BY id DESC LIMIT 10;";
			$result = mysqli_query($mysqli, $query);
			$counter = 0; // contador para identificar o primeiro slide
			$totalImoveis = mysqli_num_rows($result); // contar quantos imóveis retornaram
			$colunasPorSlide = 4; // número de imóveis por slide

			while ($dado = mysqli_fetch_array($result)) { 
				$queryFoto = "SELECT foto FROM venda WHERE id = $dado[id];";
				$fire = mysqli_query($mysqli, $queryFoto);
				$data = mysqli_fetch_array($fire);
				$res = explode(" ", $data['foto']); // fotos separadas por espaços

				if ($counter % $colunasPorSlide == 0) {
					$isActive = $counter == 0 ? 'active' : ''; // marcar o primeiro item como ativo
					echo '<div class="carousel-item ' . $isActive . '"><div class="row g-3">';
				}
			?>
				<div class="col-3">
					<div class="img-card">
						<a href="detalhe.php?id=<?php echo $dado['id']; ?>&status=venda">
							<img src="fotos/<?php echo $res[0]; ?>" alt="<?php echo $dado['titulo']; ?>">
						</a>
						<div class="info mt-3 text-center">
							<h5><?php echo $dado['titulo']; ?></h5>
							<h6><?php echo $dado['categoria']; ?></h6>
							<h6><?php echo $dado['cidade']; ?></h6>
							
							<a href="detalhe.php?id=<?php echo $dado['id']; ?>&status=venda" class="btn btn-sm btn-go mt-3">Saiba Mais</a>
						</div>
					</div>
				</div>
			<?php
				$counter++;

				if ($counter % $colunasPorSlide == 0 || $counter == $totalImoveis) {
					echo '</div></div>'; // Fechar o item do carrossel
				}
			} 
			?>
		</div>
		<button class="carousel-control-prev" type="button" data-bs-target="#carouselCompras" data-bs-slide="prev">
			<span class="carousel-control-prev-icon" aria-hidden="true"></span>
			<span class="visually-hidden">Anterior</span>
		</button>
		<button class="carousel-control-next" type="button" data-bs-target="#carouselCompras" data-bs-slide="next">
			<span class="carousel-control-next-icon" aria-hidden="true"></span>
			<span class="visually-hidden">Próximo</span>
		</button>
	</div>
</div>

<hr>

<div class="col-md-12">					
	<!-- Destaques de Aluguel - Carousel -->
	<h2 class="text-center mb-4">Destaques para Locação</h2>
	<div id="carouselAluguel" class="carousel slide" data-bs-ride="carousel">
		<div class="carousel-inner">
			<?php 
			$query = "SELECT * FROM aluguel ORDER BY id DESC LIMIT 10;";
			$result = mysqli_query($mysqli, $query);
			$counter = 0; // contador para identificar o primeiro slide
			$totalImoveis = mysqli_num_rows($result); // contar quantos imóveis retornaram
			$colunasPorSlide = 4; // número de imóveis por slide

			while ($dado = mysqli_fetch_array($result)) { 
				$queryFoto = "SELECT foto FROM aluguel WHERE id = $dado[id];";
				$fire = mysqli_query($mysqli, $queryFoto);
				$data = mysqli_fetch_array($fire);
				$res = explode(" ", $data['foto']); // fotos separadas por espaços

				if ($counter % $colunasPorSlide == 0) {
					$isActive = $counter == 0 ? 'active' : ''; // marcar o primeiro item como ativo
					echo '<div class="carousel-item ' . $isActive . '"><div class="row g-3">';
				}
			?>
				<div class="col-3">
					<div class="img-card">
						<a href="detalhe.php?id=<?php echo $dado['id']; ?>&status=aluguel">
							<img src="fotos/<?php echo $res[0]; ?>" alt="<?php echo $dado['titulo']; ?>">
						</a>
						<div class="info mt-3 text-center">
							<h5><?php echo $dado['titulo']; ?></h5>
							<h6><?php echo $dado['categoria']; ?></h6>
							<h6><?php echo $dado['cidade']; ?></h6>
							<a href="detalhe.php?id=<?php echo $dado['id']; ?>&status=aluguel" class="btn btn-sm btn-go mt-3">Saiba Mais</a>
						</div>
					</div>
				</div>
			<?php
				$counter++;

				if ($counter % $colunasPorSlide == 0 || $counter == $totalImoveis) {
					echo '</div></div>'; // Fechar o item do carrossel
				}
			} 
			?>
		</div>
		<button class="carousel-control-prev" type="button" data-bs-target="#carouselAluguel" data-bs-slide="prev">
			<span class="carousel-control-prev-icon" aria-hidden="true"></span>
			<span class="visually-hidden">Anterior</span>
		</button>
		<button class="carousel-control-next" type="button" data-bs-target="#carouselAluguel" data-bs-slide="next">
			<span class="carousel-control-next-icon" aria-hidden="true"></span>
			<span class="visually-hidden">Próximo</span>
		</button>
	</div>
</div>


 </div>
 </div>
    </section>


<br>

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

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
	
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
