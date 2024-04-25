-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: setup-mysql
-- Tempo de geração: 25-Abr-2024 às 23:05
-- Versão do servidor: 8.0.36
-- versão do PHP: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `laravel`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `homes`
--

CREATE TABLE `homes` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `home_controllers`
--

CREATE TABLE `home_controllers` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_04_20_013032_create_home_controllers_table', 1),
(6, '2024_04_20_013339_create_homes_table', 2),
(7, '2024_04_20_043808_create_units_table', 3),
(8, '2024_04_24_043709_create_table_services', 4),
(10, '2024_04_25_175254_create_unit_service_table', 5);

-- --------------------------------------------------------

--
-- Estrutura da tabela `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `services`
--

CREATE TABLE `services` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 => Não, 1 => Sim',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `services`
--

INSERT INTO `services` (`id`, `name`, `active`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'New Service', 1, NULL, '2024-04-24 13:21:26', '2024-04-25 17:26:18', NULL),
(2, 'Segunda Via Documentos atualizado', 1, NULL, '2024-04-24 15:08:37', '2024-04-24 15:08:37', NULL),
(3, 'Abertura de MEI', 0, NULL, '2024-04-24 15:09:00', '2024-04-24 15:09:00', NULL),
(4, 'Orientação profissional', 1, NULL, '2024-04-24 15:09:21', '2024-04-24 15:09:21', NULL),
(5, 'Segunda via documentos', 1, NULL, '2024-04-24 15:09:35', '2024-04-24 15:09:35', NULL),
(47, 'Texteporraaaa', 0, NULL, '2024-04-25 16:14:04', '2024-04-25 17:12:05', '2024-04-25 17:12:05'),
(48, 'ww', 0, NULL, '2024-04-25 17:11:41', '2024-04-25 17:11:59', '2024-04-25 17:11:59'),
(49, 'Serviço novo', 0, NULL, '2024-04-25 17:29:10', '2024-04-25 17:29:10', NULL),
(50, '2222', 0, NULL, '2024-04-25 18:11:18', '2024-04-25 18:19:39', '2024-04-25 18:19:39');

-- --------------------------------------------------------

--
-- Estrutura da tabela `units`
--

CREATE TABLE `units` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `coordinator` varchar(70) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Coordenador',
  `address` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Endereço da unidade',
  `services` json DEFAULT NULL COMMENT 'Conterá os identificadores dos serviços. Exemplo: ["1", "2", "...."]',
  `starttime` varchar(6) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Horário em que a unidade finaliza o expediente. Exemplo: 08:00',
  `endtime` varchar(6) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Horário em que a unidade inicia o expediente. Exemplo: 18:00',
  `servicetime` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Tempo necessário para cada atendimento. Exemplo: 1 hour, 10 minutes, 2 hours',
  `active` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 => Não, 1 => Sim',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `units`
--

INSERT INTO `units` (`id`, `name`, `email`, `email_verified_at`, `password`, `phone`, `coordinator`, `address`, `services`, `starttime`, `endtime`, `servicetime`, `active`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(3, 'zwTexte-121sx', 'texte123@email.com', NULL, '123', '(11)92928-2200', '1', 'texte121', NULL, '00:11', '11:01', '10 minutes', 1, NULL, '2024-04-20 15:07:28', '2024-04-24 01:27:55', '2024-04-24 01:27:55'),
(48, 'Texte22', 'texte22@gmail.com', NULL, '123', '(92)92928-2200', '2', '2', NULL, '22:22', '22:22', '30 minutos', 0, NULL, '2024-04-21 16:22:09', '2024-04-24 01:28:04', '2024-04-24 01:28:04'),
(49, 'Texte3', 'email13@example.com', NULL, '123', '(91)92928-2200', '', '', NULL, '08:00', '18:00', '35 minutos', 0, NULL, '2024-04-21 15:07:28', '2024-04-24 01:30:37', '2024-04-24 01:30:37'),
(50, 'Texte4', 'email14@example.com', NULL, '123', '(91) 003892829', '', '', NULL, '08:32', '10:23', '14 minutos', 0, NULL, '2024-04-21 16:27:23', '2024-04-24 01:32:21', '2024-04-24 01:32:21'),
(51, 'Texte5', 'texte5@gmail.com', NULL, '123', '(91)92928-2200', '1', 'Rua Rui Barata, 23', NULL, '08:00', '16:00', '10 minutes', 1, NULL, '2024-04-15 16:35:02', '2024-04-24 01:33:04', '2024-04-24 01:33:04'),
(52, 'Texte6', 'texte6@gmail.com', NULL, '123', '(91)92928-2200', '', '', NULL, '03:00', '13:00', '13 minutos', 0, NULL, '2024-04-16 16:35:10', '2024-04-24 01:34:00', '2024-04-24 01:34:00'),
(53, 'Texte7', 'texte7@gmail.com', NULL, '123', '(91)92928-2200', '', '', NULL, '07:00', '17:00', '17 minutos', 0, NULL, '2024-04-16 16:35:10', '2024-04-24 01:34:06', '2024-04-24 01:34:06'),
(54, 'Texte8', 'texte8@gmail.com', NULL, '123', '(91)92928-2200', '', '', NULL, '08:00', '18:48', '18 minutos', 0, NULL, '2024-04-16 16:35:10', '2024-04-24 01:34:11', '2024-04-24 01:34:11'),
(55, 'Texte9', 'texte9@gmail.com', NULL, '123', '(91)92928-2200', '', '', NULL, '09:00', '09:00', '19 minutos', 1, NULL, '2024-04-16 16:35:10', '2024-04-24 01:49:16', '2024-04-24 01:49:16'),
(56, 'Texte10', 'texte10@gmail.com', NULL, '123', '(91)92928-2200', '', '', NULL, '10:00', '11:00', '11 minutos', 0, NULL, '2024-04-16 16:35:10', '2024-04-24 01:49:22', '2024-04-24 01:49:22'),
(57, 'Gabriel Castro0', 'gabriel@gmail.com', NULL, '@Gc983734145', '(11)92928-2200', '1', 'Rua Rui Barata, 23', NULL, '03:33', '03:33', '10 minutes', 1, NULL, '2024-04-22 22:00:31', '2024-04-24 02:58:54', '2024-04-24 02:58:54'),
(58, 'João', 'joao@gmail.com', NULL, '@Gc983734145', '(92)92928-2200', '1', 'Rua Rui Barata, 23', NULL, '22:02', '22:02', '23', 0, NULL, '2024-04-22 22:01:51', '2024-04-24 03:02:58', '2024-04-24 03:02:58'),
(59, 'new', 'new@gmail.com', NULL, '@Gc983734145', '(91)92928-2200', '12', 'Rua Rui Barata, 23', NULL, '22:22', '22:22', '15 minutes', 1, NULL, '2024-04-22 23:40:35', '2024-04-24 03:07:05', '2024-04-24 03:07:05'),
(60, 'new-2', 'new-2@gmail.com', NULL, '@Gc983734145', '(91)12928-2200', '13', 'Rua Rui Barata, 23', NULL, '22:02', '22:22', '10 minutes', 1, NULL, '2024-04-22 23:55:00', '2024-04-24 03:42:13', '2024-04-24 03:42:13'),
(61, 'new-3', 'new-3@gmail.com', NULL, '@Gc983734145', '(91) 98400-7852', 'new-3', 'new-3', NULL, '22:22', '22:22', '2 hours', 1, NULL, '2024-04-23 00:33:16', '2024-04-24 11:50:16', '2024-04-24 11:50:16'),
(63, 'Gabriel Castro3', 'gabriel@gmail.com2', NULL, '@Gc983734145', '(91) 98400-78523', '1', 'Rua Rui Barata, 23', NULL, '22:22', '22:22', '15 minutes', 1, NULL, '2024-04-23 01:02:23', '2024-04-24 03:03:08', '2024-04-24 03:03:08'),
(64, 'new4', 'new4gmailcom', NULL, 'Gc983734145', '92929282200', '1324', 'Rua Rui Barata 23', NULL, '', '', '10 minutes', 0, NULL, '2024-04-23 14:48:07', '2024-04-24 14:59:29', '2024-04-24 14:59:29'),
(65, 'Unidade Central', 'central@gmail.com', NULL, '@Gc983734145', '(91)92928-2200', 'Gabriel', 'São Paulo', '[\"3\", \"1\", \"4\", \"5\", \"2\", \"49\"]', '20:46', '21:45', '30 minutes', 1, NULL, '2024-04-23 18:02:17', '2024-04-25 23:04:29', NULL),
(66, 'Unidade de campus', 'campus@gmail.com', NULL, '@Gc983734145', '(91) 98420-7852', 'Maria Helena', 'Belém - PA', '[\"3\", \"1\", \"4\", \"5\", \"2\", \"49\"]', '15:19', '15:19', '10 minutes', 1, NULL, '2024-04-23 18:18:44', '2024-04-25 23:01:24', NULL),
(67, 'new-7', 'new-7@gmail.com', NULL, '@Gc983734145', '(91) 98400-7852', '2', 'Rua Rui Barata, 23', NULL, '16:32', '16:31', '1 hour', 1, NULL, '2024-04-23 18:31:37', '2024-04-24 04:09:47', '2024-04-24 04:09:47'),
(71, 'Unidade Metropolitana', 'metropolitana@gmail.com', NULL, '@Gc983734145', '(91) 98400-7233', 'Carlos Augusto', 'Rio de Janeiro', '[\"3\"]', '16:36', '16:36', '15 minutes', 1, NULL, '2024-04-23 18:37:01', '2024-04-25 23:02:18', NULL),
(72, 'Unidade Região Norte', 'unidade-norte@gmail.com', NULL, '@Gc983734145', '(91) 98400-0022', 'Mario Couto', 'São Paulo - Zona Norte', '[\"3\", \"1\", \"4\", \"5\", \"2\", \"49\"]', '19:09', '20:08', '10 minutes', 1, NULL, '2024-04-23 22:09:00', '2024-04-25 23:04:40', NULL),
(73, 'Unidade Região Sul', 'unidade-sul@gmail.com', NULL, '@Gc983734145', '(93) 98400-2021', 'Kleber Castro', 'São Paulo - Zona Sul', '[\"3\", \"1\", \"4\", \"5\", \"2\", \"49\"]', '22:14', '21:13', '10 minutes', 1, NULL, '2024-04-23 22:13:18', '2024-04-25 23:04:47', NULL),
(74, 'new-12', 'new-12@gmail.com', NULL, '@Gc983734145', '(91) 98400-7852', '1', 'Rua Rui Barata, 23', NULL, '19:18', '20:17', '15 minutes', 1, NULL, '2024-04-23 22:17:22', '2024-04-23 22:17:22', NULL),
(75, 'new-13', 'new-13@gmail.com', NULL, '@Gc983734145', '(91) 98400-7852', '1', 'Rua Rui Barata, 23', NULL, '22:22', '22:22', '10 minutes', 1, NULL, '2024-04-23 22:18:48', '2024-04-23 22:18:48', NULL),
(80, 'new-33', 'new-33@gmail.com', NULL, '@Gc983734145', '(91) 98400-7852', '1', 'Rua Rui Barata, 23', NULL, '20:39', '11:11', '15 minutes', 1, NULL, '2024-04-23 22:40:10', '2024-04-23 22:40:10', NULL),
(82, 'new-34', 'new-34@gmail.com', NULL, '@Gc983734145', '(91) 98400-7852', '1', 'Rua Rui Barata, 23', NULL, '22:25', '21:25', '10 minutes', 1, NULL, '2024-04-23 23:25:13', '2024-04-23 23:25:13', NULL),
(86, 'new-333', '3333@gmail.com', NULL, '@Gc98373414533', '3333', '33', '33', NULL, '03:33', '03:33', '15 minutes', 1, NULL, '2024-04-24 03:20:58', '2024-04-24 03:20:58', NULL),
(87, '33333', 'gabr333iel@gmail.com', NULL, '3333@Gc983734145', '3333', '33', '333', NULL, '03:33', '03:33', '30 minutes', 1, NULL, '2024-04-24 03:21:37', '2024-04-24 03:21:37', NULL),
(88, 'new-15', 'new-15@gmail.com', NULL, 'new-15', '(91) 98400-7852', '1', 'Rua Rui Barata, 23', NULL, '11:11', '22:33', '10 minutes', 1, NULL, '2024-04-24 03:40:28', '2024-04-24 03:40:28', NULL),
(89, '<script>alert(\"Eu sou um alert!\");</script>', 'xxxxx@gmail.com', NULL, '@Gc983734145xxx', '(91) 98400-7852', '1', 'Rua Rui Barata, 23', NULL, '22:22', '22:02', '10 minutes', 1, NULL, '2024-04-24 03:41:06', '2024-04-24 04:01:28', '2024-04-24 04:01:28'),
(90, 'new-333333', '33gabriel@gmail.com', NULL, '@Gc98373414533', '(91) 98400-7852', '1', 'Rua Rui Barata, 23', NULL, '03:03', '03:33', '10 minutes', 1, NULL, '2024-04-24 03:48:18', '2024-04-24 03:48:18', NULL),
(91, 'alertEu sou um alert', 'xxxxxxgmailcom', NULL, 'Gc983734145xxxx', '91 984007852', '1', 'Rua Rui Barata 23', NULL, '1111', '1101', '10 minutes', 1, NULL, '2024-04-24 03:57:08', '2024-04-24 12:26:16', '2024-04-24 12:26:16'),
(92, 'alertEu sou um alert', 'xxxxgmailcom', NULL, 'Gc983734145xx', '91 984007852', '2', 'Rua Rui Barata 23', NULL, '2202', '2222', '10 minutes', 0, NULL, '2024-04-24 04:01:14', '2024-04-24 04:02:04', '2024-04-24 04:02:04'),
(93, 'alertEu sou um alert', 'xxxxxxxxxxxxxgmailcom', NULL, 'Gc983734145xx', '91 984007852', 'x', 'Rua Rui Barata 23', NULL, '2202', '2202', '10 minutes', 0, NULL, '2024-04-24 04:01:55', '2024-04-24 04:02:13', '2024-04-24 04:02:13'),
(95, 'alertEu sou um alert', '1111gmailcom', NULL, 'Gc9837341452', '91 984007852', '22', '22', NULL, '2202', '2222', '15 minutes', 0, NULL, '2024-04-24 04:05:29', '2024-04-24 04:09:56', '2024-04-24 04:09:56'),
(96, 'new-3www', 'gabrwiel@gmail.com', NULL, '$2y$10$ZIT36S1RfGr3zWDeBvJTLuGEVUwEWOh1ZG41ZBkr32vLbDVx17Vp6', '(91)192928-2200', 'w', 'w', NULL, '22:22', '22:02', '15 minutes', 1, NULL, '2024-04-25 12:05:15', '2024-04-25 12:05:15', NULL),
(97, 'wwwwwwwwwww', 'wwwww@gmail.com', NULL, '$2y$10$BdWQb2PvuQdyA2Ela5AsJ.xZMtHNcPCLuBQaL.ix55gVUHUF43mKW', '(91) 98400-7852', 'wwwwwwww', 'wwwwwww', '[\"1\", \"4\", \"5\", \"2\"]', '22:22', '22:22', '10 minutes', 1, NULL, '2024-04-25 12:05:57', '2024-04-25 12:06:33', NULL),
(98, 'alert(Eu sou um alert)', 'vai@gmail.com', NULL, '$2y$10$SlTCbrnQhdtGeGMxymRHpeMqlC6U1gjbOiGGNvK/9/TdtmItWg7CS', '(91) 98400-7852', 'vai', 'vai', NULL, '12:22', '11:01', '10 minutes', 1, NULL, '2024-04-25 14:11:05', '2024-04-25 14:11:05', NULL),
(99, 'Texte-porraaaawwe2222', 'gabriel@gmail.com22', NULL, '$2y$10$PtGmWvVfd7Hr0ru23ui/3u0LMuABjcYRcqjfnWvcQAU48pLvIp9CW', '(91) 98400-7852', '33', '222', NULL, '22:22', '22:22', '10 minutes', 1, NULL, '2024-04-25 18:11:02', '2024-04-25 18:11:09', '2024-04-25 18:11:09');

-- --------------------------------------------------------

--
-- Estrutura da tabela `unit_service`
--

CREATE TABLE `unit_service` (
  `id` bigint UNSIGNED NOT NULL,
  `unit_id` bigint UNSIGNED NOT NULL,
  `service_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `unit_service`
--

INSERT INTO `unit_service` (`id`, `unit_id`, `service_id`, `created_at`, `updated_at`) VALUES
(1, 65, 50, NULL, NULL),
(2, 66, 50, NULL, NULL),
(3, 71, 50, NULL, NULL),
(4, 72, 50, NULL, NULL),
(5, 73, 50, NULL, NULL),
(6, 74, 50, NULL, NULL),
(7, 75, 50, NULL, NULL),
(8, 80, 50, NULL, NULL),
(9, 82, 50, NULL, NULL),
(10, 86, 50, NULL, NULL),
(11, 87, 50, NULL, NULL),
(12, 88, 50, NULL, NULL),
(13, 90, 50, NULL, NULL),
(14, 96, 50, NULL, NULL),
(15, 97, 50, NULL, NULL),
(16, 98, 50, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Gabriel Castro', 'gabriel@gmail.com', NULL, '$2y$10$BhAsUlboFLrVLMbqqXIUl.5ziDuCp3WnDwK4jKFucHhxVbi40QJXK', 'nD7tXtiQDSjflqefVLbTCVtuHbuYmEPfV9CNrVrpRdag5AX2RMA4YLMee9kx', '2024-04-20 12:37:21', '2024-04-20 12:37:21');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Índices para tabela `homes`
--
ALTER TABLE `homes`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `home_controllers`
--
ALTER TABLE `home_controllers`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`email`);

--
-- Índices para tabela `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Índices para tabela `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `units_email_unique` (`email`);

--
-- Índices para tabela `unit_service`
--
ALTER TABLE `unit_service`
  ADD PRIMARY KEY (`id`),
  ADD KEY `unit_service_unit_id_foreign` (`unit_id`),
  ADD KEY `unit_service_service_id_foreign` (`service_id`);

--
-- Índices para tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `homes`
--
ALTER TABLE `homes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `home_controllers`
--
ALTER TABLE `home_controllers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT de tabela `units`
--
ALTER TABLE `units`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT de tabela `unit_service`
--
ALTER TABLE `unit_service`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `unit_service`
--
ALTER TABLE `unit_service`
  ADD CONSTRAINT `unit_service_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `unit_service_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
