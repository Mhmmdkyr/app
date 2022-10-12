SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `shown` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `color` varchar(12) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `language_id` int(11) NOT NULL DEFAULT 1,
  `uniq_id` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `fullname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_ip` varchar(55) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `content_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text NOT NULL,
  `ip_address` varchar(100) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `favorites` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `languages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `default` tinyint(1) NOT NULL DEFAULT 0,
  `flag` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rtl` tinyint(1) NOT NULL DEFAULT 0,
  `active` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `languages` (`id`, `title`, `slug`, `default`, `flag`, `rtl`, `active`, `created_at`, `updated_at`) VALUES
(1, 'Türkçe', 'tr', 1, NULL, 0, 1, '2022-08-05 19:41:19', '2022-08-05 19:41:19');

CREATE TABLE `newsletters` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `pages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shown` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `language_id` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'en',
  `visibility` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'all',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `pages`
--

INSERT INTO `pages` (`id`, `slug`, `title`, `description`, `content`, `meta`, `image`, `shown`, `language_id`, `visibility`, `created_at`, `updated_at`) VALUES
(1, 'hakkimizda', 'Hakkımızda', NULL, '<p>Hakkımızda</p>', '{\"meta_title\":\"Hakk\\u0131m\\u0131zda\",\"meta_description\":null,\"meta_keywords\":null}', NULL, '{\"menu\":\"1\",\"footer\":\"1\"}', '1', 'all', '2022-06-27 13:48:54', '2022-09-06 19:31:30');

CREATE TABLE `posts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL DEFAULT 1,
  `type` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT 'article',
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `content_json` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `categories` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reactions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `images` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `features` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tags` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hit` int(11) NOT NULL DEFAULT 0,
  `short_link` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `publish_date` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'published',
  `visibility` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'all'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `post_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `post_id` int(11) NOT NULL,
  `category_id` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `role` varchar(128) NOT NULL,
  `access` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `panel_login` tinyint(1) DEFAULT NULL,
  `language_id` int(11) NOT NULL DEFAULT 1,
  `uniq_id` varchar(50) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


INSERT INTO `roles` (`id`, `role`, `access`, `panel_login`, `language_id`, `uniq_id`, `created_at`, `updated_at`) VALUES
(1, 'Kullanıcı', '{\"posts\":\"1\",\"pages\":\"1\"}', 1, 1, 'r.62ba12e167c76', NULL, '2022-07-17 16:11:38'),
(2, 'Yönetici', '{\"all\": true}', 1, 1, 'r.62ba12e1697e3', NULL, '2022-06-27 20:28:17');

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payload` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `keyword` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `language_id` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `settings` (`id`, `keyword`, `value`, `language_id`, `created_at`, `updated_at`) VALUES
(1, 'title', 'Incore - Gelişmiş Blog ve Haber Yazılımı', 1, '2022-07-22 16:26:50', '2022-09-06 19:40:55'),
(2, 'short_title', 'Incore', 1, '2022-07-22 16:26:50', '2022-07-29 11:46:04'),
(3, 'description', 'Incore - Gelişmiş Blog ve Haber Yazılımı açıklama metni', 1, '2022-07-22 16:26:50', '2022-09-06 19:40:55'),
(4, 'keywords', 'incore, php yazılım, codefabs, haber, news, blog, yazılım, satın al', 1, '2022-07-22 16:26:50', '2022-09-06 19:40:55'),
(5, 'footer_text', 'Incore - Gelişmiş Blog ve Haber Yazılımı açıklama metni', 1, '2022-07-22 16:26:50', '2022-09-06 19:40:55'),
(6, 'footer_subtitle', 'Copyright 2022© - Allright reserved.', 1, '2022-07-22 16:26:50', '2022-07-22 16:46:52'),
(7, 'timezone', 'UTC', 0, '2022-07-22 16:26:50', '2022-07-22 16:26:50'),
(8, 'color', '#ef233c', 0, '2022-07-22 16:26:50', '2022-07-27 11:59:26'),
(9, 'recaptcha', '{\"key\":null,\"secret\":null"}', 0, '2022-07-22 16:26:50', '2022-07-22 16:26:50'),
(10, 'logo', 'others/165910574734.png', 1, '2022-07-22 16:26:50', '2022-07-29 11:47:10'),
(11, 'footer_logo', 'others/165910579318.png', 1, '2022-07-22 16:26:50', '2022-07-29 11:47:10'),
(12, 'favicon', 'others/165910594031.png', 1, '2022-07-22 16:26:50', '2022-07-29 11:46:04'),
(13, 'contact', '{\"address\":\"\\u00d6rnek mah. Deneme cad. Demo Sk No:26\",\"phone\":\"+90 123 456 7896\",\"email\":\"help@neto.com.tr\",\"coordinates\":\"48.8534951,2.3483915\"}', 1, '2022-07-22 16:26:50', '2022-09-06 19:42:48'),
(14, 'socials', '{\"facebook\":\"https:\\/\\/facebook.com\\/\",\"twitter\":\"https:\\/\\/twitter.com\\/\",\"instagram\":\"https:\\/\\/instagram.com\\/\",\"youtube\":\"https:\\/\\/youtube.com\\/\",\"pinterest\":\"https:\\/\\/pinterest.com\\/\",\"linkedin\":\"https:\\/\\/linkedin.com\\/\",\"vk\":\"https:\\/\\/vk.com\\/\",\"telegram\":\"https:\\/\\/telegram.com\\/\"}', 1, '2022-07-22 16:26:50', '2022-09-06 19:42:48'),
(15, 'mail', '{\"verification\":\"1\",\"host\":\"mail.neto.com.tr\",\"username\":\"help@neto.com.tr\",\"password\":\"1234567\",\"port\":\"465\",\"encryption\":\"SSL\",\"show_name\":\"incore Blog ve Haber Yaz\\u0131l\\u0131m\\u0131\"}', 0, '2022-07-22 16:26:50', '2022-09-06 19:42:48'),
(16, 'shortener', '1', 0, '2022-07-22 16:26:50', '2022-07-23 07:27:05'),
(17, 'shortener_domain', '', 0, '2022-07-22 16:26:50', '2022-07-22 16:26:50'),
(18, 'select_domain', '0', 0, '2022-07-23 06:59:49', '2022-07-24 11:43:01'),
(19, 'cookie_text', 'İçeriği kişiselleştirmek ve web trafiğini analiz etmek için kendi ve üçüncü taraf çerezlerimizi kullanıyoruz.', 1, '2022-07-23 08:41:28', '2022-09-06 19:40:55'),
(20, 'header_html', NULL, 0, '2022-07-26 14:26:17', '2022-07-26 14:28:30'),
(21, 'footer_html', NULL, 0, '2022-07-26 14:28:02', '2022-07-26 14:28:02'),
(22, 'cookie_alert', '1', 0, '2022-07-29 11:46:04', '2022-07-29 11:46:04'),
(23, 'newsletter_modal', '1', 0, '2022-07-29 11:46:04', '2022-07-29 11:46:04'),
(24, 'ads', '{\"home_top_desktop\":\"<a href=\\\"https:\\/\\/incore.neto.com.tr\\\"  class=\\\"ad-item\\\" data-sponsor=\\\"SPONSOR\\\" target=\\\"_blank\\\" rel=\\\"nofollow\\\"><img src=\\\"https:\\/\\/incore.neto.com.tr\\/uploads\\/ads\\/165765922023.jpg\\\" alt=\\\"ad image\\\" \\/><\\/a>\",\"home_top_mobile\":\"<a href=\\\"https:\\/\\/incore.neto.com.tr\\\"  class=\\\"ad-item\\\" data-sponsor=\\\"SPONSOR\\\" target=\\\"_blank\\\" rel=\\\"nofollow\\\"><img src=\\\"https:\\/\\/incore.neto.com.tr\\/uploads\\/ads\\/165765922073.jpg\\\" alt=\\\"ad image\\\" \\/><\\/a>\",\"home_middle_desktop\":\"<a href=\\\"https:\\/\\/incore.neto.com.tr\\\"  class=\\\"ad-item\\\" data-sponsor=\\\"SPONSOR\\\" target=\\\"_blank\\\" rel=\\\"nofollow\\\"><img src=\\\"https:\\/\\/incore.neto.com.tr\\/uploads\\/ads\\/165765922023.jpg\\\" alt=\\\"ad image\\\" \\/><\\/a>\",\"home_middle_mobile\":\"<a href=\\\"https:\\/\\/incore.neto.com.tr\\\"  class=\\\"ad-item\\\" data-sponsor=\\\"SPONSOR\\\" target=\\\"_blank\\\" rel=\\\"nofollow\\\"><img src=\\\"https:\\/\\/incore.neto.com.tr\\/uploads\\/ads\\/165765922073.jpg\\\" alt=\\\"ad image\\\" \\/><\\/a>\",\"home_bottom_desktop\":\"<a href=\\\"https:\\/\\/incore.neto.com.tr\\\"  class=\\\"ad-item\\\" data-sponsor=\\\"SPONSOR\\\" target=\\\"_blank\\\" rel=\\\"nofollow\\\"><img src=\\\"https:\\/\\/incore.neto.com.tr\\/uploads\\/ads\\/165765922031.jpg\\\" alt=\\\"ad image\\\" \\/><\\/a>\",\"home_bottom_mobile\":\"<a href=\\\"https:\\/\\/incore.neto.com.tr\\\"  class=\\\"ad-item\\\" data-sponsor=\\\"SPONSOR\\\" target=\\\"_blank\\\" rel=\\\"nofollow\\\"><img src=\\\"https:\\/\\/incore.neto.com.tr\\/uploads\\/ads\\/165765922073.jpg\\\" alt=\\\"ad image\\\" \\/><\\/a>\",\"post_bottom_desktop\":\"<a href=\\\"https:\\/\\/incore.neto.com.tr\\\"  class=\\\"ad-item\\\" data-sponsor=\\\"SPONSOR\\\" target=\\\"_blank\\\" rel=\\\"nofollow\\\"><img src=\\\"https:\\/\\/incore.neto.com.tr\\/uploads\\/ads\\/165765922023.jpg\\\" alt=\\\"ad image\\\" \\/><\\/a>\",\"post_bottom_mobile\":\"<a href=\\\"https:\\/\\/incore.neto.com.tr\\\"  class=\\\"ad-item\\\" data-sponsor=\\\"SPONSOR\\\" target=\\\"_blank\\\" rel=\\\"nofollow\\\"><img src=\\\"https:\\/\\/incore.neto.com.tr\\/uploads\\/ads\\/165765922073.jpg\\\" alt=\\\"ad image\\\" \\/><\\/a>\",\"post_middle_desktop\":\"<a href=\\\"https:\\/\\/incore.neto.com.tr\\\"  class=\\\"ad-item\\\" data-sponsor=\\\"SPONSOR\\\" target=\\\"_blank\\\" rel=\\\"nofollow\\\"><img src=\\\"https:\\/\\/incore.neto.com.tr\\/uploads\\/ads\\/165765922023.jpg\\\" alt=\\\"ad image\\\" \\/><\\/a>\",\"post_middle_mobile\":\"<a href=\\\"https:\\/\\/incore.neto.com.tr\\\"  class=\\\"ad-item\\\" data-sponsor=\\\"SPONSOR\\\" target=\\\"_blank\\\" rel=\\\"nofollow\\\"><img src=\\\"https:\\/\\/incore.neto.com.tr\\/uploads\\/ads\\/165765922073.jpg\\\" alt=\\\"ad image\\\" \\/><\\/a>\",\"category_bottom_desktop\":\"<a href=\\\"https:\\/\\/incore.neto.com.tr\\\"  class=\\\"ad-item\\\" data-sponsor=\\\"SPONSOR\\\" target=\\\"_blank\\\" rel=\\\"nofollow\\\"><img src=\\\"https:\\/\\/incore.neto.com.tr\\/uploads\\/ads\\/165765922023.jpg\\\" alt=\\\"ad image\\\" \\/><\\/a>\",\"category_bottom_mobile\":\"<a href=\\\"https:\\/\\/incore.neto.com.tr\\\"  class=\\\"ad-item\\\" data-sponsor=\\\"SPONSOR\\\" target=\\\"_blank\\\" rel=\\\"nofollow\\\"><img src=\\\"https:\\/\\/incore.neto.com.tr\\/uploads\\/ads\\/165765922073.jpg\\\" alt=\\\"ad image\\\" \\/><\\/a>\",\"category_middle_desktop\":\"<a href=\\\"https:\\/\\/incore.neto.com.tr\\\"  class=\\\"ad-item\\\" data-sponsor=\\\"SPONSOR\\\" target=\\\"_blank\\\" rel=\\\"nofollow\\\"><img src=\\\"https:\\/\\/incore.neto.com.tr\\/uploads\\/ads\\/165765922023.jpg\\\" alt=\\\"ad image\\\" \\/><\\/a>\",\"category_middle_mobile\":\"<a href=\\\"https:\\/\\/incore.neto.com.tr\\\"  class=\\\"ad-item\\\" data-sponsor=\\\"SPONSOR\\\" target=\\\"_blank\\\" rel=\\\"nofollow\\\"><img src=\\\"https:\\/\\/incore.neto.com.tr\\/uploads\\/ads\\/165765922073.jpg\\\" alt=\\\"ad image\\\" \\/><\\/a>\",\"sidebar_top_desktop\":\"<a href=\\\"https:\\/\\/incore.neto.com.tr\\\"  class=\\\"ad-item\\\" data-sponsor=\\\"SPONSOR\\\" target=\\\"_blank\\\" rel=\\\"nofollow\\\"><img src=\\\"https:\\/\\/incore.neto.com.tr\\/uploads\\/ads\\/165765922049.jpg\\\" alt=\\\"ad image\\\" \\/><\\/a>\",\"sidebar_bottom_desktop\":\"<a href=\\\"https:\\/\\/incore.neto.com.tr\\\"  class=\\\"ad-item\\\" data-sponsor=\\\"SPONSOR\\\" target=\\\"_blank\\\" rel=\\\"nofollow\\\"><img src=\\\"https:\\/\\/incore.neto.com.tr\\/uploads\\/ads\\/165765922049.jpg\\\" alt=\\\"ad image\\\" \\/><\\/a>\"}', 0, '2022-09-20 19:12:30', '2022-09-20 19:12:30');

CREATE TABLE `themes` (
  `id` int(11) NOT NULL,
  `theme_name` varchar(300) NOT NULL,
  `path` varchar(300) NOT NULL,
  `author` varchar(300) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image_sizes` varchar(300) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


INSERT INTO `themes` (`id`, `theme_name`, `path`, `author`, `description`, `image_sizes`, `active`, `created_at`, `updated_at`) VALUES
(1, 'OctoMag', 'octomag', 'Neto.com.tr', 'incore blog ve haber yazılımı için geliştirilen ilk temadır.', NULL, 1, '2022-06-27 20:15:59', '2022-07-26 17:28:16');

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `about` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `role_id` int(11) NOT NULL DEFAULT 1,
  `status` tinyint(1) DEFAULT 0,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `users` (`id`, `avatar`, `name`, `email`, `about`, `email_verified_at`, `role_id`, `status`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, null, 'Super Admin', 'admin@admin.com', '{\"bio\":\"It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum\",\"facebook\":\"https:\\/\\/fb.com\",\"twitter\":\"https:\\/\\/twitter.com\",\"instagram\":null,\"youtube\":\"https:\\/\\/youtube.com\",\"pinterest\":null,\"linkedin\":null,\"vk\":null,\"telegram\":null}', '2022-02-10 14:40:03', 2, 1, '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'dQEBUkEUAq3mcnIBt2rRgHEs2OWYDq01wp0lIKpAa503b5dBkdgpF8STAMq6', '2022-02-10 14:40:03', '2022-07-24 12:44:07');

ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `favorites`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `newsletters`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `newsletters_email_unique` (`email`);

ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `short_link` (`short_link`);

ALTER TABLE `post_categories`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `themes`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `email` (`email`);

ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `favorites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `languages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE `newsletters`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `pages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE `posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `post_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

ALTER TABLE `themes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;
