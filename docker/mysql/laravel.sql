-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: setup-mysql
-- Tempo de geração: 04-Jun-2024 às 01:34
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
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
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
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
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
(10, '2024_04_25_175254_create_unit_service_table', 5),
(11, '2024_05_04_212413_create_schedules_table', 6),
(12, '2024_05_07_231326_create_schedules_table', 7),
(13, '2024_05_08_131104_add_profile_image_to_users_table', 8),
(14, '2024_05_08_212202_add_is_admin_to_users_table', 9),
(15, '2024_05_09_140100_add_fields_to_schedules_table', 10),
(16, '2024_05_30_093049_add_phone_to_users_table', 11),
(17, '2024_06_01_145810_create_notifications_table', 12);

-- --------------------------------------------------------

--
-- Estrutura da tabela `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint UNSIGNED NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('6c0ff510-c85c-4738-9e24-8bb009177476', 'App\\Notifications\\ScheduleCreatedNotification', 'App\\Models\\User', 2, '{\"unit_id\":101,\"service_id\":2,\"month\":\"09\",\"day\":\"03\",\"hour\":\"09:30\",\"chosen_date\":\"2024-09-03 09:30:00\",\"user_name\":\"Gabriel Castro\",\"procedure_name\":\"Checkup Dent\\u00e1rio\"}', NULL, '2024-06-01 16:09:28', '2024-06-01 16:09:28'),
('74bda3ae-77c2-450d-b76d-991f04951d86', 'App\\Notifications\\ScheduleCreatedNotification', 'App\\Models\\User', 2, '{\"unit_id\":100,\"service_id\":1,\"month\":\"09\",\"day\":\"02\",\"hour\":\"09:00\",\"chosen_date\":\"2024-09-02 09:00:00\",\"user_name\":\"Gabriel Castro\",\"procedure_name\":\"Limpeza Dent\\u00e1ria Profissional\"}', NULL, '2024-06-01 16:10:55', '2024-06-01 16:10:55'),
('b44d09e7-2665-4922-af44-04340b5d6884', 'App\\Notifications\\ScheduleCreatedNotification', 'App\\Models\\User', 3, '{\"unit_id\":100,\"service_id\":3,\"month\":\"06\",\"day\":\"04\",\"hour\":\"11:20\",\"chosen_date\":\"2024-06-04 11:20:00\",\"user_name\":\"Administrador\",\"procedure_name\":\"Tratamento de C\\u00e1ries\"}', NULL, '2024-06-01 21:24:53', '2024-06-01 21:24:53');

-- --------------------------------------------------------

--
-- Estrutura da tabela `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('gabriel.developerxxx@gmail.com', '$2y$10$cjnu7mb5VDdlqYZfuFmRLOp/60BASxJPGURqjYDy0JP71xY2S./.S', '2024-05-08 15:41:39');

-- --------------------------------------------------------

--
-- Estrutura da tabela `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `schedules`
--

CREATE TABLE `schedules` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `unit_id` bigint UNSIGNED NOT NULL,
  `service_id` bigint UNSIGNED NOT NULL,
  `month` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `day` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `hour` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `finished` tinyint(1) NOT NULL DEFAULT '0',
  `canceled` tinyint(1) NOT NULL DEFAULT '0',
  `chosen_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `schedules`
--

INSERT INTO `schedules` (`id`, `user_id`, `unit_id`, `service_id`, `month`, `day`, `hour`, `created_at`, `updated_at`, `finished`, `canceled`, `chosen_date`) VALUES
(85, 2, 100, 2, '11', '01', '10:30', '2024-05-29 19:35:51', '2024-05-29 19:35:51', 0, 0, '2024-11-01 10:30:00'),
(87, 2, 100, 4, '08', '21', '11:50', '2024-05-29 19:50:35', '2024-05-29 19:50:35', 0, 0, '2024-08-21 11:50:00'),
(88, 2, 101, 2, '09', '18', '13:30', '2024-05-29 19:50:54', '2024-05-29 19:50:54', 0, 0, '2024-09-18 13:30:00'),
(89, 2, 101, 1, '09', '03', '14:00', '2024-05-29 19:51:11', '2024-05-29 19:51:11', 0, 0, '2024-09-03 14:00:00'),
(104, 3, 101, 2, '06', '04', '20:00', '2024-06-01 14:22:53', '2024-06-01 14:22:53', 0, 0, '2024-06-04 20:00:00'),
(105, 2, 101, 2, '08', '06', '14:00', '2024-06-01 15:00:40', '2024-06-01 15:00:40', 0, 0, '2024-08-06 14:00:00'),
(106, 2, 100, 1, '06', '19', '10:20', '2024-06-01 15:01:50', '2024-06-01 15:01:50', 0, 0, '2024-06-19 10:20:00'),
(107, 2, 101, 1, '10', '01', '11:00', '2024-06-01 15:12:42', '2024-06-01 15:12:42', 0, 0, '2024-10-01 11:00:00'),
(108, 2, 100, 1, '06', '12', '09:00', '2024-06-01 15:56:37', '2024-06-01 15:56:37', 0, 0, '2024-06-12 09:00:00'),
(109, 2, 101, 2, '09', '03', '09:30', '2024-06-01 16:09:28', '2024-06-01 16:09:28', 0, 0, '2024-09-03 09:30:00'),
(110, 2, 100, 1, '09', '02', '09:00', '2024-06-01 16:10:55', '2024-06-01 16:10:55', 0, 0, '2024-09-02 09:00:00'),
(111, 3, 100, 3, '06', '04', '11:20', '2024-06-01 21:24:53', '2024-06-01 21:24:53', 0, 0, '2024-06-04 11:20:00');

-- --------------------------------------------------------

--
-- Estrutura da tabela `services`
--

CREATE TABLE `services` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 => Não, 1 => Sim',
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `services`
--

INSERT INTO `services` (`id`, `name`, `active`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Limpeza Dentária Profissional', 1, NULL, '2024-04-24 13:21:26', '2024-05-29 19:52:53', NULL),
(2, 'Checkup Dentário', 1, NULL, '2024-04-24 15:08:37', '2024-05-29 19:53:09', NULL),
(3, 'Tratamento de Cáries', 1, NULL, '2024-04-24 15:09:00', '2024-05-29 19:53:20', NULL),
(4, 'Tratamento de Canal Endodontia', 1, NULL, '2024-04-24 15:09:21', '2024-05-29 19:53:38', NULL),
(5, 'Extrações Dentárias', 1, NULL, '2024-04-24 15:09:35', '2024-05-29 19:53:52', NULL),
(47, 'Texteporraaaa', 0, NULL, '2024-04-25 16:14:04', '2024-04-25 17:12:05', '2024-04-25 17:12:05'),
(48, 'ww', 0, NULL, '2024-04-25 17:11:41', '2024-04-25 17:11:59', '2024-04-25 17:11:59'),
(49, 'Serviço novo', 0, NULL, '2024-04-25 17:29:10', '2024-04-28 16:19:27', '2024-04-28 16:19:27'),
(50, '2222', 0, NULL, '2024-04-25 18:11:18', '2024-04-25 18:19:39', '2024-04-25 18:19:39'),
(51, 'Tratamento de Doenças Gengivais Periodontia', 1, NULL, '2024-05-29 19:54:08', '2024-05-29 19:54:08', NULL),
(52, 'Próteses Dentárias', 1, NULL, '2024-05-29 19:54:23', '2024-05-29 19:54:23', NULL),
(53, 'Implantes Dentários', 1, NULL, '2024-05-29 19:54:33', '2024-05-29 19:54:33', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `units`
--

CREATE TABLE `units` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `coordinator` varchar(70) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Coordenador',
  `address` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Endereço da unidade',
  `services` json DEFAULT NULL COMMENT 'Conterá os identificadores dos serviços. Exemplo: ["1", "2", "...."]',
  `starttime` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Horário em que a unidade finaliza o expediente. Exemplo: 08:00',
  `endtime` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Horário em que a unidade inicia o expediente. Exemplo: 18:00',
  `servicetime` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Tempo necessário para cada atendimento. Exemplo: 1 hour, 10 minutes, 2 hours',
  `active` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 => Não, 1 => Sim',
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `units`
--

INSERT INTO `units` (`id`, `name`, `email`, `email_verified_at`, `password`, `phone`, `coordinator`, `address`, `services`, `starttime`, `endtime`, `servicetime`, `active`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(100, 'Unidade Central', 'unidade@gmail.com', NULL, '123', '(91)92928-2200', 'João', 'Centro São Paulo', '[\"2\", \"5\", \"53\", \"1\", \"52\", \"4\", \"3\", \"51\"]', '09:00', '22:00', '10 minutes', 1, NULL, '2024-04-25 23:11:00', '2024-05-30 10:01:04', NULL),
(101, 'Unidade Metropolitana', 'metropolitana@gmail.com', NULL, '123', '(91) 98400-7852', 'Gabriel', 'Belém - PA', '[\"2\", \"5\", \"53\", \"1\", \"52\", \"4\", \"3\", \"51\"]', '09:30', '22:00', '30 minutes', 1, NULL, '2024-04-25 23:11:56', '2024-05-30 10:01:14', NULL);

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
(17, 100, 51, NULL, NULL),
(18, 101, 51, NULL, NULL),
(19, 100, 52, NULL, NULL),
(20, 101, 52, NULL, NULL),
(21, 100, 53, NULL, NULL),
(22, 101, 53, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `profile_image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `phone`, `remember_token`, `created_at`, `updated_at`, `profile_image`, `is_admin`) VALUES
(1, 'Gabriel Castro', 'gabriel@gmail.com', NULL, '$2y$10$BhAsUlboFLrVLMbqqXIUl.5ziDuCp3WnDwK4jKFucHhxVbi40QJXK', '91984007852', 'zsVmjwDtYjM0eeYOtFIHX6AvjYXaAzWeC9cVlsIxSW5bw7B3VXApP7W7CzY4', '2024-04-20 12:37:21', '2024-04-20 12:37:21', NULL, 0),
(2, 'Gabriel Castro', 'gabriel.developerxxx@gmail.com', NULL, '$2y$10$z2G8GDqhhQiNHSL6ywDpKuJ8l8H4/Cx5kMylRPeU0QAFnoKKkqWtu', '91984007852', 'QLFfs3EM0mwlc0hZeOshqiYnig6xaxpFwrX6nXBhbrT0QMo9XJ3VHfI26Gnc', '2024-05-07 20:33:43', '2024-06-01 09:30:45', 'profile_images/2vNC81l9pvsqhgbl87ya5pgbj9gaiXy7kdY8NaHS.png', 0),
(3, 'Administrador', 'admin@email.com', '2024-05-08 21:43:05', '$2y$10$ZTgY8SY2nOGizK/B9QAEc.HH6dIDY4q2/YFE4Per2/4..rkC74t9i', '91984007852', NULL, '2024-05-08 21:43:05', '2024-05-31 22:30:00', 'profile_images/keY7bZNe87276QnF8WFtblLRNsUCoo0FZLyH8vOE.png', 1),
(4, 'João', 'joao@gmail.com', NULL, '$2y$10$bqRW4jkkALXocKwj6XgMeeOIUvrtXpFkrZ6Lg52rj2ksdPHEXgT/e', '91983734145', NULL, '2024-05-30 10:20:05', '2024-05-30 10:21:00', 'profile_images/GQKn7eiF6Zh7lcLFhQoIuIswp2tXl8vsTUB4B5gT.png', 0);

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
-- Índices para tabela `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

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
-- Índices para tabela `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `schedules_user_id_foreign` (`user_id`),
  ADD KEY `schedules_unit_id_foreign` (`unit_id`),
  ADD KEY `schedules_service_id_foreign` (`service_id`);

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
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de tabela `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `schedules`
--
ALTER TABLE `schedules`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;

--
-- AUTO_INCREMENT de tabela `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT de tabela `units`
--
ALTER TABLE `units`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT de tabela `unit_service`
--
ALTER TABLE `unit_service`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `schedules`
--
ALTER TABLE `schedules`
  ADD CONSTRAINT `schedules_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`),
  ADD CONSTRAINT `schedules_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`),
  ADD CONSTRAINT `schedules_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

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
