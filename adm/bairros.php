<?php
include ("../conn.php");

// Definir charset
$mysqli->set_charset("utf8mb4");

// Buscar cidades
$cidades_query = "SELECT id, nome FROM cidades ORDER BY nome";
$cidades_result = $mysqli->query($cidades_query);

// Buscar bairros
$selectedCidadeId = isset($_GET['cidade']) ? (int)$_GET['cidade'] : 0;

// Criar bairro
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create'])) {
    $nome = $_POST['nome'];
    $cidade_id = $_POST['cidade_id'];
    $sql = "INSERT INTO bairros (nome, cidade_id) VALUES (?, ?)";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('si', $nome, $cidade_id);
    $stmt->execute();
    header('Location: ' . $_SERVER['PHP_SELF'] . '?cidade=' . $cidade_id);
    exit();
}

// Atualizar bairro
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $sql = "UPDATE bairros SET nome = ? WHERE id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('si', $nome, $id);
    $stmt->execute();
    header('Location: ' . $_SERVER['PHP_SELF'] . '?cidade=' . $_POST['cidade_id']);
    exit();
}

// Deletar bairro
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $cidade_id = (int)$_GET['cidade_id'];
    $sql = "DELETE FROM bairros WHERE id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    header('Location: ' . $_SERVER['PHP_SELF'] . '?cidade=' . $cidade_id);
    exit();
}

// Buscar bairros com filtro
$searchTerm = isset($_POST['search']) ? $_POST['search'] : '';
$bairros_query = "SELECT id, nome FROM bairros WHERE cidade_id = ?";

if ($searchTerm) {
    $bairros_query .= " AND nome LIKE ?";
}

$bairros_query .= " ORDER BY nome";
$stmt = $mysqli->prepare($bairros_query);

if ($searchTerm) {
    $searchTerm = "%$searchTerm%";
    $stmt->bind_param('is', $selectedCidadeId, $searchTerm);
} else {
    $stmt->bind_param('i', $selectedCidadeId);
}

$stmt->execute();
$bairros_result = $stmt->get_result();
$bairros = $bairros_result->fetch_all(MYSQLI_ASSOC);

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
        .btn-custom {
            border-radius: 12px;
            padding: 20px;
            font-size: 16px;
            font-weight: bold;
            color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: background-color 0.3s, transform 0.3s, box-shadow 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            width: 100%;
            height: 100px;
            box-sizing: border-box;
        }
        .btn-primary-custom {
            background: linear-gradient(135deg, #007bff, #0056b3);
        }
        .btn-primary-custom:hover {
            background: linear-gradient(135deg, #0056b3, #003d7a);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
            transform: translateY(-2px);
        }
        .btn-success-custom {
            background: linear-gradient(135deg, #28a745, #218838);
        }
        .btn-success-custom:hover {
            background: linear-gradient(135deg, #218838, #1e7e34);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
            transform: translateY(-2px);
        }
        .btn-secondary-custom {
            background: linear-gradient(135deg, #6c757d, #5a6268);
        }
        .btn-secondary-custom:hover {
            background: linear-gradient(135deg, #5a6268, #4e555b);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
            transform: translateY(-2px);
        }
        .btn-danger-custom {
            background: linear-gradient(135deg, #dc3545, #c82333);
        }
        .btn-danger-custom:hover {
            background: linear-gradient(135deg, #c82333, #a71d2a);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
            transform: translateY(-2px);
        }
        .btn-dark-custom {
            background: linear-gradient(135deg, #343a40, #23272b);
        }
        .btn-dark-custom:hover {
            background: linear-gradient(135deg, #23272b, #1d2124);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
            transform: translateY(-2px);
        }
        .btn-info-custom {
            background: linear-gradient(135deg, #17a2b8, #138496);
        }
        .btn-info-custom:hover {
            background: linear-gradient(135deg, #138496, #117a8b);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
            transform: translateY(-2px);
        }
        .btn-row {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }
        .btn-col {
            flex: 1 1 calc(33.333% - 20px);
            max-width: calc(33.333% - 20px);
        }
        @media (max-width: 768px) {
            .btn-col {
                flex: 1 1 calc(50% - 20px);
                max-width: calc(50% - 20px);
            }
        }
        @media (max-width: 576px) {
            .btn-col {
                flex: 1 1 100%;
                max-width: 100%;
            }
        }
    </style>
    <script>
        function updateBairros() {
            var cidadeId = document.getElementById('cidade').value;
            window.location.href = '?cidade=' + cidadeId;
        }

        function confirmDelete() {
            return confirm('Você tem certeza que deseja deletar este bairro?');
        }
    </script>
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
    <!-- Selecionar Cidade -->
    <h2>Gerenciar Bairros</h2>
    <div class="mb-3">
        <label for="cidade" class="form-label">Cidade</label>
        <select name="cidade" id="cidade" class="form-select" onchange="updateBairros()">
            <option value="" selected>Selecione a cidade</option>
            <?php
            if ($cidades_result->num_rows > 0) {
                while ($row = $cidades_result->fetch_assoc()) {
                    $selected = ($selectedCidadeId == $row['id']) ? 'selected' : '';
                    echo "<option value=\"{$row['id']}\" $selected>{$row['nome']}</option>";
                }
            }
            ?>
        </select>
    </div>

    <!-- Criar/Editar Bairro -->
    <?php if ($selectedCidadeId): ?>
    <h3 class="mt-4"><?php echo isset($_GET['edit']) ? 'Editar Bairro' : 'Cadastrar Bairro'; ?></h3>
    <form method="post" action="">
        <input type="hidden" name="cidade_id" value="<?php echo htmlspecialchars($selectedCidadeId); ?>">
        <?php if (isset($_GET['edit'])): ?>
            <?php
            $bairroId = (int)$_GET['edit'];
            $bairro_query = "SELECT * FROM bairros WHERE id = ?";
            $stmt = $mysqli->prepare($bairro_query);
            $stmt->bind_param('i', $bairroId);
            $stmt->execute();
            $bairro_result = $stmt->get_result();
            $bairroParaEditar = $bairro_result->fetch_assoc();
            ?>
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($bairroParaEditar['id']); ?>">
        <?php endif; ?>
        <div class="mb-3">
            <input type="text" name="nome" class="form-control" placeholder="Nome do bairro" value="<?php echo htmlspecialchars($bairroParaEditar['nome'] ?? ''); ?>" required>
        </div>
        <button type="submit" name="<?php echo isset($_GET['edit']) ? 'update' : 'create'; ?>" class="btn btn-<?php echo isset($_GET['edit']) ? 'info' : 'success'; ?>">
            <?php echo isset($_GET['edit']) ? 'Atualizar' : 'Cadastrar'; ?>
        </button>
    </form>

    <!-- Buscar Bairros -->
    <form method="post" class="mb-4 mt-4">
        <div class="mb-3">
            <input type="text" name="search" class="form-control" placeholder="Buscar por nome" value="<?php echo htmlspecialchars($searchTerm); ?>">
        </div>
        <button type="submit" class="btn btn-primary">Buscar</button>
    </form>

    <!-- Lista de Bairros -->
    <table class="table table-bordered mb-4">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($bairros as $bairro): ?>
            <tr>
                <td><?php echo htmlspecialchars($bairro['id']); ?></td>
                <td><?php echo htmlspecialchars($bairro['nome']); ?></td>
                <td>
                    <a href="?edit=<?php echo $bairro['id']; ?>&cidade=<?php echo $selectedCidadeId; ?>" class="btn btn-info btn-sm">Editar</a>
                    <a href="?delete=<?php echo $bairro['id']; ?>&cidade_id=<?php echo $selectedCidadeId; ?>" class="btn btn-danger btn-sm" onclick="return confirmDelete();">Deletar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif; ?>

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

<!-- Bootstrap JS and dependencies -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

</body>
</html>
