-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3308
-- Tempo de geração: 14/09/2026 às 14:18
-- Versão do servidor: 8.4.7
-- Versão do PHP: 8.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `showmotors_database`
--
CREATE DATABASE IF NOT EXISTS `showmotors_database` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `showmotors_database`;

-- --------------------------------------------------------

--
-- Estrutura para tabela `agendamento`
--

DROP TABLE IF EXISTS `agendamento`;
CREATE TABLE IF NOT EXISTS `agendamento` (
  `id_agendamento` int NOT NULL AUTO_INCREMENT,
  `id_usuario` int NOT NULL,
  `id_carro` int NOT NULL,
  `data_hora_servico` timestamp NOT NULL,
  `data_hora_entrega` timestamp NOT NULL,
  `descricao` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`id_agendamento`),
  UNIQUE KEY `id_carro` (`id_carro`),
  KEY `id_usuario` (`id_usuario`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura para tabela `agendamento_servicos`
--

DROP TABLE IF EXISTS `agendamento_servicos`;
CREATE TABLE IF NOT EXISTS `agendamento_servicos` (
  `id_agendamento` int NOT NULL,
  `id_servico` int NOT NULL,
  PRIMARY KEY (`id_agendamento`,`id_servico`),
  KEY `id_servico` (`id_servico`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura para tabela `carro`
--

DROP TABLE IF EXISTS `carro`;
CREATE TABLE IF NOT EXISTS `carro` (
  `id_carro` int NOT NULL AUTO_INCREMENT,
  `id_usuario` int NOT NULL,
  `marca` varchar(15) NOT NULL,
  `modelo` varchar(50) NOT NULL,
  `num_chassi` varchar(17) NOT NULL,
  `ano_fabricação` year NOT NULL,
  `ano_modelo` year NOT NULL,
  `cor` varchar(10) DEFAULT NULL,
  `placa` varchar(8) NOT NULL,
  `tipo_combustivel` varchar(20) DEFAULT NULL,
  `qtdd_portas` int DEFAULT NULL,
  `nivel_tanque` varchar(12) DEFAULT NULL,
  `km_rodados` int DEFAULT NULL,
  `direção` varchar(15) DEFAULT NULL,
  `ar` varchar(15) DEFAULT NULL,
  `motor` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id_carro`),
  KEY `id_usuario` (`id_usuario`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura para tabela `checklist`
--

DROP TABLE IF EXISTS `checklist`;
CREATE TABLE IF NOT EXISTS `checklist` (
  `id_checklist` int NOT NULL AUTO_INCREMENT,
  `id_carro` int NOT NULL,
  `id_usuario` int NOT NULL,
  `diagnostico` varchar(256) NOT NULL,
  PRIMARY KEY (`id_checklist`),
  UNIQUE KEY `id_carro` (`id_carro`),
  UNIQUE KEY `id_usuario` (`id_usuario`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura para tabela `servicos`
--

DROP TABLE IF EXISTS `servicos`;
CREATE TABLE IF NOT EXISTS `servicos` (
  `id_servico` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `preco` decimal(10,2) NOT NULL,
  `descricao` varchar(600) DEFAULT NULL,
  PRIMARY KEY (`id_servico`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario`
--

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE IF NOT EXISTS `usuario` (
  `id_usuario` int NOT NULL AUTO_INCREMENT,
  `nome_cliente` varchar(50) NOT NULL,
  `nome_usuario` varchar(50) NOT NULL,
  `senha` varchar(60) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `data_cadastro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `email` varchar(100) NOT NULL,
  `telefone` varchar(14) DEFAULT NULL,
  `celular` varchar(14) DEFAULT NULL,
  `cpf` varchar(14) DEFAULT NULL,
  `nivel_acesso` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id_usuario`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Despejando dados para a tabela `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `nome_cliente`, `nome_usuario`, `senha`, `data_cadastro`, `email`, `telefone`, `celular`, `cpf`, `nivel_acesso`) VALUES
(5, 'Felipe Arias de Morais', 'Felipe.Morais', '$2y$10$cRFupASZ5.pyG2u2Iww06uGDYBhGVAN3Vig4r.xm9vuq7uuVcfdPG', '2026-09-14 14:03:42', 'felipemorais.arias@gmail.com', '11939559644', NULL, NULL, NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
