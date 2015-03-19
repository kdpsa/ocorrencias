-- phpMyAdmin SQL Dump
-- version 4.1.4
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 04-Mar-2015 às 19:53
-- Versão do servidor: 5.6.15-log
-- PHP Version: 5.4.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `system`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `categoria`
--

CREATE TABLE IF NOT EXISTS `categoria` (
  `cat_id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_nome` varchar(100) NOT NULL,
  `cat_prazo` varchar(10) NOT NULL,
  PRIMARY KEY (`cat_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Extraindo dados da tabela `categoria`
--

INSERT INTO `categoria` (`cat_id`, `cat_nome`, `cat_prazo`) VALUES
(1, 'Atualização cadastral', '2'),
(2, 'Distribuição Rede Lojas', '2'),
(3, 'Devoluções', '7'),
(4, 'Coletas', '2'),
(5, 'Documentos Contabilidade', '1'),
(6, 'Distribuição junto aos representantes', '3'),
(7, 'Tabela representante', '1'),
(8, 'Estoque com fotos', '1'),
(9, 'Encontro de contas', '2'),
(10, '2ª via duplicata', '2'),
(11, 'Cobranças', ''),
(12, 'Reembolsos', '7'),
(13, 'Suporte', '2'),
(14, 'Configuração junto a Millenium', '2'),
(15, 'Análise de crédito', '2'),
(16, 'Saldo', '1'),
(17, 'Itens diversos', '1');

-- --------------------------------------------------------

--
-- Estrutura da tabela `cliente`
--

CREATE TABLE IF NOT EXISTS `cliente` (
  `cli_id` int(11) NOT NULL AUTO_INCREMENT,
  `cli_nome` varchar(100) NOT NULL,
  `cli_empresa` varchar(100) NOT NULL,
  `cli_email` varchar(100) NOT NULL,
  `cli_tel` varchar(11) NOT NULL,
  PRIMARY KEY (`cli_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Extraindo dados da tabela `cliente`
--

INSERT INTO `cliente` (`cli_id`, `cli_nome`, `cli_empresa`, `cli_email`, `cli_tel`) VALUES
(1, 'Ricardo Aureliano', 'RA Connect Informática', 'aureliano@raconnect.com.br', '11 56147016'),
(2, 'Ariane Fuser', 'CRC Compressores', 'arianeger@crccompressores.com.br', '11 26512042');

-- --------------------------------------------------------

--
-- Estrutura da tabela `ocorrencia`
--

CREATE TABLE IF NOT EXISTS `ocorrencia` (
  `ocorrencia_id` int(11) NOT NULL AUTO_INCREMENT,
  `cli_nome` varchar(100) NOT NULL,
  `cli_empresa` varchar(100) NOT NULL,
  `cli_categoria` varchar(100) NOT NULL,
  `cli_ocorrencia` varchar(255) NOT NULL,
  `data` date NOT NULL DEFAULT '0000-00-00',
  `hora` time NOT NULL DEFAULT '00:00:00',
  `usuario` varchar(100) NOT NULL,
  `situacao` varchar(50) NOT NULL,
  PRIMARY KEY (`ocorrencia_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Extraindo dados da tabela `ocorrencia`
--

INSERT INTO `ocorrencia` (`ocorrencia_id`, `cli_nome`, `cli_empresa`, `cli_categoria`, `cli_ocorrencia`, `data`, `hora`, `usuario`, `situacao`) VALUES
(1, 'Carlos', 'RA Connect Informática', 'Suporte', 'Teste de registro de ocorrência.', '2015-03-04', '14:57:01', 'Carlos Eduardo', 'Pendente'),
(2, 'Ricardo', 'RA Connect Informática', 'Suporte', 'Teste com apresentação de número de ocorrência.', '2015-03-04', '15:20:46', 'Carlos Eduardo', 'Pendente');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `area` varchar(50) NOT NULL,
  `ramal` varchar(5) NOT NULL,
  `login` varchar(50) NOT NULL,
  `senha` varchar(50) NOT NULL,
  `nivel` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `area`, `ramal`, `login`, `senha`, `nivel`) VALUES
(1, 'Carlos Eduardo', 'Administrativo', '15', 'carlos', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 1),
(2, 'hue', 'hue', '12', 'hue', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 2);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
