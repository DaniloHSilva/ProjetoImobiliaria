<?php
include ("../conn.php");

// Inicializar variáveis
$search = isset($_POST['search']) ? $_POST['search'] : '';
$usuarioParaEditar = null;

// Consultar usuários
$sql = "SELECT * FROM usuarios";
if ($search) {
    $sql .= " WHERE user LIKE ?";
}
$stmt = $mysqli->prepare($sql);

if ($search) {
    $searchParam = "%$search%";
    $stmt->bind_param('s', $searchParam);
}

$stmt->execute();
$result = $stmt->get_result();
$usuarios = $result->fetch_all(MYSQLI_ASSOC);

// Criar usuário
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create'])) {
    $user = $_POST['user'];
    $pass = password_hash($_POST['pass'], PASSWORD_BCRYPT); // Hash da senha
    $sql = "INSERT INTO usuarios (user, pass) VALUES (?, ?)";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('ss', $user, $pass);
    $stmt->execute();
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}

// Atualizar usuário
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $id = $_POST['id'];
    $user = $_POST['user'];
    $pass = isset($_POST['pass']) ? password_hash($_POST['pass'], PASSWORD_BCRYPT) : null;

    if ($pass) {
        $sql = "UPDATE usuarios SET user = ?, pass = ? WHERE id = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param('ssi', $user, $pass, $id);
    } else {
        $sql = "UPDATE usuarios SET user = ? WHERE id = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param('si', $user, $id);
    }

    $stmt->execute();
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}

// Deletar usuário
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM usuarios WHERE id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}

// Editar usuário
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $sql = "SELECT * FROM usuarios WHERE id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $usuarioParaEditar = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciamento de Usuários</title>
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
</head>
<body>

<!-- Navbar -->
<header>
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <a href="#" class="logo">
                <img src="../images/logotiago.png" alt="Logo">
            </a>
            <nav>
                <div>
                    <a href="../index.php" class="text-white">Início</a>
                    <a href="upload.php" class="text-white ms-3">Cadastrar Imóveis</a>
                    <a href="logout.php" class="text-white ms-3">Sair</a>
                </div>
            </nav>
        </div>
    </div>
</header>

<main class="container mt-4">

    <!-- Criar/Editar Usuário -->
    <h2 class="mt-4"><?php echo $usuarioParaEditar ? 'Editar Usuário' : 'Cadastrar Novo Usuário'; ?></h2>
    <form method="post" action="">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($usuarioParaEditar['id'] ?? ''); ?>">
        <div class="mb-3">
            <input type="text" name="user" class="form-control" placeholder="Nome do usuário" value="<?php echo htmlspecialchars($usuarioParaEditar['user'] ?? ''); ?>" required>
        </div>
        <div class="mb-3">
            <input type="password" name="pass" class="form-control" placeholder="Nova senha (deixe em branco para manter a atual)">
        </div>
        <button type="submit" name="<?php echo $usuarioParaEditar ? 'update' : 'create'; ?>" class="btn btn-<?php echo $usuarioParaEditar ? 'info' : 'success'; ?>">
            <?php echo $usuarioParaEditar ? 'Atualizar' : 'Cadastrar'; ?>
        </button>
    </form><br>
    
    <!-- Busca -->
    <h2>Buscar Usuários</h2>
    <form method="post" action="">
        <div class="mb-3">
            <input type="text" name="search" class="form-control" placeholder="Buscar por nome" value="<?php echo htmlspecialchars($search); ?>">
        </div>
        <button type="submit" class="btn btn-primary">Buscar</button>
    </form>

    <!-- Lista de Usuários -->
    <h2 class="mt-4">Usuários</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Usuário</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($usuarios as $usuario): ?>
            <tr>
                <td><?php echo htmlspecialchars($usuario['id']); ?></td>
                <td><?php echo htmlspecialchars($usuario['user']); ?></td>
                <td>
                    <a href="?edit=<?php echo $usuario['id']; ?>" class="btn btn-info btn-sm">Editar</a>
                    <a href="?delete=<?php echo $usuario['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirmDelete();">Deletar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

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

<script>
function confirmDelete() {
    return confirm('Você tem certeza que deseja deletar este usuário?');
}
</script>

</body>
</html>
