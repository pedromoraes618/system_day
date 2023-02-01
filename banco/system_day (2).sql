-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 01-Fev-2023 às 01:33
-- Versão do servidor: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `system_day`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_acessos`
--

CREATE TABLE IF NOT EXISTS `tb_acessos` (
  `cl_id` int(11) NOT NULL AUTO_INCREMENT,
  `cl_usuario_id` varchar(10) DEFAULT NULL,
  `cl_subcategoria` varchar(10) NOT NULL,
  `cl_acesso_ativo` int(2) DEFAULT NULL,
  PRIMARY KEY (`cl_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=80 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_categorias`
--

CREATE TABLE IF NOT EXISTS `tb_categorias` (
  `cl_id` int(11) NOT NULL AUTO_INCREMENT,
  `cl_categoria` varchar(50) DEFAULT NULL,
  `cl_subcategoria_id` varchar(10) DEFAULT NULL,
  `cl_icone` varchar(100) DEFAULT NULL,
  `cl_ordem` int(11) NOT NULL,
  PRIMARY KEY (`cl_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_empresa`
--

CREATE TABLE IF NOT EXISTS `tb_empresa` (
  `cl_id` int(11) NOT NULL AUTO_INCREMENT,
  `cl_site` varchar(50) DEFAULT NULL,
  `cl_empresa` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`cl_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_log`
--

CREATE TABLE IF NOT EXISTS `tb_log` (
  `cl_id` int(11) NOT NULL AUTO_INCREMENT,
  `cl_data_modificacao` timestamp NULL DEFAULT NULL,
  `cl_usuario` varchar(50) DEFAULT NULL,
  `cl_descricao` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`cl_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=425 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_menus`
--

CREATE TABLE IF NOT EXISTS `tb_menus` (
  `cl_id` int(11) NOT NULL AUTO_INCREMENT,
  `cl_menu` varchar(50) DEFAULT NULL,
  `cl_url` varchar(80) DEFAULT NULL,
  PRIMARY KEY (`cl_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_parametros`
--

CREATE TABLE IF NOT EXISTS `tb_parametros` (
  `cl_id` int(11) NOT NULL AUTO_INCREMENT,
  `cl_descricao` varchar(50) DEFAULT NULL,
  `cl_valor` varchar(50) NOT NULL,
  PRIMARY KEY (`cl_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_subcategorias`
--

CREATE TABLE IF NOT EXISTS `tb_subcategorias` (
  `cl_id` int(11) NOT NULL AUTO_INCREMENT,
  `cl_subcategoria` varchar(50) DEFAULT NULL,
  `cl_ordem_menu` varchar(3) DEFAULT NULL,
  `cl_diretorio` varchar(50) DEFAULT NULL,
  `cl_url` varchar(50) DEFAULT NULL,
  `cl_categoria` float DEFAULT NULL,
  `cl_diretorio_bd` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`cl_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=22 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_users`
--

CREATE TABLE IF NOT EXISTS `tb_users` (
  `cl_id` int(11) NOT NULL AUTO_INCREMENT,
  `cl_data_cadastro` timestamp NULL DEFAULT NULL,
  `cl_nome` varchar(100) DEFAULT NULL,
  `cl_usuario` varchar(50) DEFAULT NULL,
  `cl_senha` varchar(50) DEFAULT NULL,
  `cl_email` varchar(30) DEFAULT NULL,
  `cl_tipo` varchar(10) DEFAULT NULL,
  `cl_ativo` int(2) NOT NULL,
  `cl_chave_aleatoria` varchar(80) DEFAULT NULL,
  PRIMARY KEY (`cl_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=51 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
