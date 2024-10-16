-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 15-Out-2024 às 20:51
-- Versão do servidor: 10.4.32-MariaDB
-- versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `tiagoimoveisdb`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `aluguel`
--

CREATE TABLE `aluguel` (
  `id` int(11) NOT NULL,
  `titulo` varchar(300) NOT NULL,
  `descricao` varchar(5000) NOT NULL,
  `foto` varchar(1000) NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `categoria` varchar(100) NOT NULL,
  `endereco` varchar(255) NOT NULL,
  `bairro` varchar(150) NOT NULL,
  `cidade` varchar(100) NOT NULL,
  `estado` varchar(50) NOT NULL,
  `cep` varchar(20) NOT NULL,
  `area_total` varchar(50) DEFAULT NULL,
  `area_construida` varchar(50) DEFAULT NULL,
  `num_quartos` int(11) DEFAULT NULL,
  `num_banheiros` int(11) DEFAULT NULL,
  `num_vagas` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `aluguel`
--

INSERT INTO `aluguel` (`id`, `titulo`, `descricao`, `foto`, `valor`, `categoria`, `endereco`, `bairro`, `cidade`, `estado`, `cep`, `area_total`, `area_construida`, `num_quartos`, `num_banheiros`, `num_vagas`) VALUES
(8, 'Teste', 'teste', '5f97ad001a7fd57c6889e0d7f97ece24.jpeg b6232f5524e5803b74b7097d102505f3.jpeg f28c453e75ad033158db56b3d487955d.jpeg ad769eb388dacc1ebbdddd92077d34ac.jpeg df8c23e0d8905f03860b5ff443acec07.jpeg 4f4a321f6e692b1453c8551f912ab112.jpeg 281f12cdf5a31830219d438ea9c177b6.jpg ', 1.40, 'Apartamento', 'rua Itaquera', 'São Mateus', 'São Paulo', 'SP', '', '', '', 0, 0, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `bairros`
--

CREATE TABLE `bairros` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `cidade_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `bairros`
--

INSERT INTO `bairros` (`id`, `nome`, `cidade_id`) VALUES
(1, 'Jardim do Lago', 1),
(2, 'Vila Arujá', 1),
(3, 'Jardim Real', 1),
(4, 'Parque Rodrigo Barreto', 1),
(5, 'Jardim Nova Arujá', 1),
(6, 'Centro', 1),
(7, 'Jardim Imperador', 1),
(8, 'Jardim Rincão', 1),
(9, 'Jardim Paulista', 1),
(10, 'Jardim Santos Dumont', 1),
(11, 'Jardim Primavera', 1),
(12, 'Jardim Fazenda Rincão', 1),
(13, 'Vila Suíssa', 1),
(14, 'Vila Real', 1),
(15, 'Vila Progresso', 1),
(16, 'Centro', 2),
(17, 'Jardim Biritiba', 2),
(18, 'Jardim Flórida', 2),
(19, 'Jardim São Vicente', 2),
(20, 'Vila São João', 2),
(21, 'Vila São Luís', 2),
(22, 'Vila América', 2),
(23, 'Vila Morada do Sol', 2),
(24, 'Parque das Laranjeiras', 2),
(25, 'Jardim Paraíso', 2),
(26, 'Jardim Paulista', 2),
(27, 'Jardim Primavera', 2),
(28, 'Vila Pimentas', 2),
(29, 'Jardim do Sol', 2),
(30, 'Jardim Santa Tereza', 2),
(31, 'Centro', 3),
(32, 'Jardim São Paulo', 3),
(34, 'Jardim Planalto', 3),
(36, 'Jardim Bela Vista', 3),
(37, 'Jardim Parada XIV', 3),
(41, 'Jardim Tietê', 3),
(43, 'Jardim Rincão', 3),
(44, 'Jardim São Rafael', 3),
(45, 'Jardim Europa', 3),
(48, 'Vila São Francisco', 3),
(50, 'Vila Romanópolis', 3),
(53, 'Vila São Luís', 3),
(54, 'Jardim Nova Era', 3),
(55, 'Vila Pimentas', 3),
(57, 'Vila São João', 3),
(61, 'Centro', 4),
(62, 'Jardim Novo Horizonte', 4),
(63, 'Jardim Primavera', 4),
(64, 'Vila São João', 4),
(65, 'Vila Macedo', 4),
(66, 'Jardim das Acácias', 4),
(67, 'Jardim Bela Vista', 4),
(68, 'Vila Progresso', 4),
(69, 'Jardim Brasil', 4),
(70, 'Vila Aracati', 4),
(71, 'Jardim Paraíso', 4),
(72, 'Jardim Eldorado', 4),
(73, 'Vila Abranches', 4),
(74, 'Vila Cardoso', 4),
(75, 'Jardim Sônia', 4),
(76, 'Centro', 5),
(77, 'Vila Galvão', 5),
(78, 'Jardim Maia', 5),
(79, 'Vila Progresso', 5),
(80, 'Jardim São João', 5),
(81, 'Gopouva', 5),
(82, 'Jardim São Luís', 5),
(83, 'Vila Rosália', 5),
(84, 'Jardim Guarulhos', 5),
(85, 'Jardim Cumbica', 5),
(86, 'Vila São Rafael', 5),
(87, 'Jardim Paraíso', 5),
(88, 'Jardim Palmeiras', 5),
(89, 'Vila Augusta', 5),
(90, 'Vila Arapongas', 5),
(91, 'Jardim Fontoura', 5),
(92, 'Vila Floresta', 5),
(93, 'Jardim Taboão', 5),
(94, 'Jardim Bom Clima', 5),
(95, 'Vila São Jorge', 5),
(96, 'Centro', 6),
(97, 'Vila Bressane', 6),
(98, 'Jardim Cumbica', 6),
(99, 'Parque Alvorada', 6),
(100, 'Jardim Jacinto', 6),
(101, 'Vila Maria', 6),
(102, 'Jardim São Carlos', 6),
(103, 'Vila Nova Itaqua', 6),
(104, 'Parque Itamarati', 6),
(105, 'Jardim Itaim', 6),
(106, 'Vila Pereira', 6),
(107, 'Jardim São Francisco', 6),
(108, 'Vila Santa Maria', 6),
(109, 'Vila São João', 6),
(110, 'Jardim Dona Laura', 6),
(111, 'Jardim Cruzeiro', 6),
(112, 'Vila Monte Belo', 6),
(113, 'Centro', 7),
(114, 'Vila Brasileira', 7),
(115, 'Jardim Universo', 7),
(116, 'Vila Industrial', 7),
(117, 'Jardim São Francisco', 7),
(118, 'Vila Moraes', 7),
(119, 'Jardim Dourado', 7),
(120, 'Parque das Garças', 7),
(121, 'Jardim Cordeiro', 7),
(122, 'Vila Nova Mogilar', 7),
(123, 'Centro', 8),
(124, 'Vila Oliva', 8),
(125, 'Jardim Nova Poá', 8),
(126, 'Vila Giannini', 8),
(127, 'Jardim São José', 8),
(128, 'Vila Jundiapeba', 8),
(129, 'Jardim Célia', 8),
(130, 'Vila Rubens', 8),
(131, 'Vila Ester', 8),
(132, 'Vila Maria', 8),
(133, 'Centro', 9),
(134, 'Vila São João', 9),
(135, 'Jardim das Palmeiras', 9),
(136, 'Vila Pedreira', 9),
(137, 'Jardim da Serra', 9),
(138, 'Vila Nova', 9),
(139, 'Vila Nova Salesópolis', 9),
(140, 'Jardim Alto da Serra', 9),
(141, 'Vila Santa Maria', 9),
(142, 'Jardim Itamarati', 9),
(143, 'Centro', 10),
(144, 'Vila São João', 10),
(145, 'Jardim Brasília', 10),
(146, 'Vila Maria', 10),
(147, 'Jardim Santa Isabel', 10),
(148, 'Vila São José', 10),
(149, 'Jardim São Paulo', 10),
(150, 'Jardim Nova Santa Isabel', 10),
(151, 'Vila Nova', 10),
(152, 'Jardim São Francisco', 10),
(153, 'Centro', 11),
(154, 'Vila Maluf', 11),
(155, 'Jardim Dona Benta', 11),
(156, 'Vila Amorim', 11),
(157, 'Jardim Elite', 11),
(158, 'Vila São Francisco', 11),
(159, 'Jardim Palmeiras', 11),
(160, 'Jardim Belém', 11),
(161, 'Vila dos Advogados', 11),
(162, 'Jardim Colorado', 11),
(163, 'Tatuapé', 12),
(164, 'Mooca', 12),
(165, 'Vila Carrão', 12),
(166, 'Vila Formosa', 12),
(167, 'Penha', 12),
(168, 'Itaquera', 12),
(169, 'São Mateus', 12),
(170, 'São Rafael', 12),
(171, 'Jardim Helena', 12),
(172, 'Vila Prudente', 12),
(173, 'Aricanduva', 12),
(174, 'Jardim Anália Franco', 12),
(175, 'Vila Zelina', 12),
(176, 'Jardim São Paulo', 12),
(177, 'Vila Oratório', 12),
(178, 'Vila Esperança', 12),
(179, 'Vila Ré', 12),
(180, 'Jardim Aricanduva', 12),
(181, 'Vila São Jorge', 12),
(182, 'Jardim Iva', 12),
(183, 'Itaim Paulista', 12),
(184, 'Ermelino Matarazzo', 12),
(185, 'Guaianases', 12),
(186, 'Cidade Tiradentes', 12);

-- --------------------------------------------------------

--
-- Estrutura da tabela `cidades`
--

CREATE TABLE `cidades` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `cidades`
--

INSERT INTO `cidades` (`id`, `nome`) VALUES
(1, 'Arujá'),
(2, 'Biritiba-Mirim'),
(3, 'Ferraz de Vasconcelos'),
(4, 'Guararema'),
(5, 'Guarulhos'),
(6, 'Itaquaquecetuba'),
(7, 'Mogi das Cruzes'),
(8, 'Poá'),
(9, 'Salesópolis'),
(10, 'Santa Isabel'),
(12, 'São Paulo'),
(11, 'Suzano');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `user` varchar(30) NOT NULL,
  `pass` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `user`, `pass`) VALUES
(1, 'adm', '1234'),
(2, 'user', 'e10adc3949ba59abbe56e057f20f883e');

-- --------------------------------------------------------

--
-- Estrutura da tabela `venda`
--

CREATE TABLE `venda` (
  `id` int(11) NOT NULL,
  `titulo` varchar(300) NOT NULL,
  `descricao` varchar(5000) NOT NULL,
  `foto` varchar(1000) NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `categoria` varchar(100) NOT NULL,
  `endereco` varchar(255) NOT NULL,
  `bairro` varchar(150) NOT NULL,
  `cidade` varchar(100) NOT NULL,
  `estado` varchar(50) NOT NULL,
  `cep` varchar(20) NOT NULL,
  `area_total` varchar(50) DEFAULT NULL,
  `area_construida` varchar(50) DEFAULT NULL,
  `num_quartos` int(11) DEFAULT NULL,
  `num_banheiros` int(11) DEFAULT NULL,
  `num_vagas` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `venda`
--

INSERT INTO `venda` (`id`, `titulo`, `descricao`, `foto`, `valor`, `categoria`, `endereco`, `bairro`, `cidade`, `estado`, `cep`, `area_total`, `area_construida`, `num_quartos`, `num_banheiros`, `num_vagas`) VALUES
(26, 'Casa Itaquaquecetuba', 'Grande', 'df0bc198212da81eede235d7faab1079.jpeg ', 50.00, 'Casa', 'rua Itaquera', 'Vila Monte Belo', 'Itaquaquecetuba', 'SP', '', '', '', 0, 0, 0);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `aluguel`
--
ALTER TABLE `aluguel`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `bairros`
--
ALTER TABLE `bairros`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cidade_id` (`cidade_id`);

--
-- Índices para tabela `cidades`
--
ALTER TABLE `cidades`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nome` (`nome`);

--
-- Índices para tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `venda`
--
ALTER TABLE `venda`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `aluguel`
--
ALTER TABLE `aluguel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `bairros`
--
ALTER TABLE `bairros`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=188;

--
-- AUTO_INCREMENT de tabela `cidades`
--
ALTER TABLE `cidades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `venda`
--
ALTER TABLE `venda`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `bairros`
--
ALTER TABLE `bairros`
  ADD CONSTRAINT `bairros_ibfk_1` FOREIGN KEY (`cidade_id`) REFERENCES `cidades` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
