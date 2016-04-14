SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

----odelovac---

SET time_zone = "+00:00";


----odelovac---

 SET NAMES utf8 

----odelovac---


CREATE TABLE IF NOT EXISTS `admin_ci_sessions` (
  `session_id` varchar(40) COLLATE utf8_bin NOT NULL DEFAULT '0',
  `ip_address` varchar(16) COLLATE utf8_bin NOT NULL DEFAULT '0',
  `user_agent` varchar(150) COLLATE utf8_bin NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

----odelovac---

CREATE TABLE IF NOT EXISTS `admin_emailnastavenia` (
  `id` tinyint(4) NOT NULL,
  `email_odosielania` varchar(80) NOT NULL,
  `email_pre_odpoved` varchar(80) NOT NULL,
  `protocol` varchar(15) NOT NULL COMMENT 'mail, sendmail, or smtp',
  `email_odosielania_meno` varchar(250) NOT NULL,
  `smtp_server` varchar(250) NOT NULL,
  `smtp_port` varchar(10) NOT NULL,
  `smtp_user` varchar(200) NOT NULL,
  `smtp_pass` varchar(200) NOT NULL,
  `smtp_secure` varchar(20) NOT NULL,
  `mailtype` varchar(4) NOT NULL,
  `charset` varchar(10) NOT NULL,
  `priority` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

----odelovac---

INSERT INTO `admin_emailnastavenia` (`id`, `email_odosielania`, `email_pre_odpoved`, `protocol`, `email_odosielania_meno`, `smtp_server`, `smtp_port`, `smtp_user`, `smtp_pass`, `smtp_secure`, `mailtype`, `charset`, `priority`) VALUES
(1, 'no-reply@your-site.com', 'yourmail@your-site.com', 'mail', 'KF cms', '', '', '', '', '', 'html', 'utf-8', 3);

-- --------------------------------------------------------

----odelovac---

CREATE TABLE IF NOT EXISTS `admin_language` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dir` varchar(25) NOT NULL,
  `name` varchar(100) NOT NULL,
  `active` tinyint(4) NOT NULL,
  `default` tinyint(4) NOT NULL,
  `icon` varchar(100) NOT NULL,
  `iso_code` varchar(10) NOT NULL,
  `code` varchar(2) NOT NULL,
  `poradie` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=21 ;

----odelovac---

INSERT INTO `admin_language` (`id`, `dir`, `name`, `active`, `default`, `icon`, `iso_code`, `code`, `poradie`) VALUES
(1, 'dutch', 'Nederlands', 0, 0, 'nl.png', 'nl_NL', 'nl', 0),
(2, 'french', 'Français', 0, 0, 'fr.png', 'fr_FR', 'fr', 0),
(3, 'slovak', 'Slovenčina', 1, 0, 'sk.png', 'sk_SK', 'sk', 2),
(4, 'english', 'English', 1, 1, 'en.png', 'en_US', 'en', 4),
(5, 'czech', 'Čeština', 0, 0, 'cs.png', 'cs_CS', 'cs', 0),
(6, 'finnish', 'Suomi', 0, 0, 'fi.png', 'fi_FI', 'fi', 0),
(7, 'greek', 'ελληνικά', 0, 0, 'el.png', 'el_EL', 'el', 0),
(8, 'finnish', 'Suomi', 0, 0, 'fi.png', 'fi_FI', 'fi', 0),
(9, 'french', 'Français', 0, 0, 'fr.png', 'fr_FR', 'fr', 0),
(10, 'danish', 'Dansk', 0, 0, 'da.png', 'da_DA', 'da', 0),
(11, 'hungarian', 'Magyar', 0, 0, 'hu.png', 'hu_HU', 'hu', 0),
(12, 'chinese_simplified', '汉语', 0, 0, 'zh.png', 'zh_ZH', 'zh', 0),
(13, 'indonesian', 'Bahasa Indonesia', 0, 0, 'id.png', 'id_ID', 'id', 0),
(14, 'italian', 'Italiano', 0, 0, 'it.png', 'it_IT', 'it', 0),
(15, 'polish', 'Polszczyzna', 0, 0, 'pl.png', 'pl_PL', 'pl', 0),
(16, 'portuguese', 'Português', 0, 0, 'pt.png', 'pt_PT', 'pt', 0),
(17, 'russian', 'Pусский язык', 0, 0, 'ru.png', 'ru_RU', 'ru', 0),
(18, 'slovenian', 'Slovenski jezik', 0, 0, 'sl.png', 'sl_SL', 'sl', 0),
(19, 'spanish', 'Español', 0, 0, 'es.png', 'es_ES', 'es', 0),
(20, 'swedish', 'Svenska', 0, 0, 'sv.png', 'sv_SV', 'sv', 0);

----odelovac---

CREATE TABLE IF NOT EXISTS `admin_login_attempts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(40) COLLATE utf8_bin NOT NULL,
  `login` varchar(50) COLLATE utf8_bin NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

----odelovac---

CREATE TABLE IF NOT EXISTS `admin_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kontroler` varchar(200) NOT NULL,
  `id_parrent` int(11) NOT NULL,
  `icon` varchar(100) NOT NULL,
  `poradie` int(11) DEFAULT '0',
  `type` tinyint(4) NOT NULL COMMENT '0 - kontroler, 1 - user page',
  `options` varchar(250) NOT NULL,
  `zobrazit` tinyint(4) NOT NULL,
  `url` varchar(240) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=124 ;

----odelovac---

INSERT INTO `admin_menu` (`id`, `kontroler`, `id_parrent`, `icon`, `poradie`, `type`, `options`, `zobrazit`, `url`) VALUES
(1, '#', 0, '', 0, 0, '', 1, 'pages'),
(2, '#', 32, '', 14, 0, '', 1, 'documents'),
(3, '#', 32, '', 19, 0, '', 1, 'fotogalleries'),
(4, '#', 32, '', 29, 0, '', 1, 'allsliders'),
(5, '#', 32, '', 38, 0, '', 1, 'navblocks'),
(6, '#', 32, '', 44, 0, '', 1, 'partners'),
(7, '#', 0, 'icon-wrench', 56, 0, '', 1, 'settings'),
(8, 'stranky/uprava', 1, 'icon-plus', 6, 0, '', 1, 'edit'),
(9, 'stranky', 1, 'icon-list', 5, 0, '', 1, 'view'),
(10, 'dokumenty/pridatdokument/novy', 2, 'icon-plus', 17, 0, '', 1, 'add-document'),
(11, 'dokumenty', 2, 'icon-list', 15, 0, '', 1, 'view'),
(12, 'fotogaleria/novy', 3, 'icon-plus', 25, 0, '', 1, 'add-new'),
(13, 'fotogaleria', 3, 'icon-list', 20, 0, '', 1, 'view'),
(14, 'sliders/novy_slider/novy', 4, 'icon-plus', 33, 0, '', 1, 'add-new'),
(15, 'sliders', 4, 'icon-list', 30, 0, '', 1, 'view'),
(16, 'navbloky/pridajnavblok/novy', 5, 'icon-plus', 42, 0, '', 1, 'add-new'),
(17, 'navbloky/', 5, 'icon-list', 39, 0, '', 1, 'view'),
(18, 'partnery/pridatpartnera/novy', 6, 'icon-plus', 47, 0, '', 1, 'add-new'),
(19, 'partnery', 6, 'icon-list', 45, 0, '', 1, 'view'),
(20, 'opravneniaskupiny', 7, 'icon-lock', 102, 0, '', 1, 'group-permissions'),
(21, '#', 7, 'icon-fire', 95, 0, '', 1, 'system-setting'),
(22, 'spravajazykovweb', 25, 'icon-globe', 90, 0, '', 1, 'manage-language-web'),
(23, 'spravapouzivatelov', 7, 'icon-user', 105, 0, '', 1, 'manage-admin-users'),
(24, 'spravajazykovadmin', 25, 'icon-globe', 85, 0, '', 1, 'manage-language-admin'),
(25, '#', 7, 'icon-globe', 84, 0, '', 1, 'manage-language'),
(28, 'filemanager/zobraz', 1, 'icon-th', 1, 0, 'class=''dsfdsfdsfd''', 1, 'browser-filemanager'),
(31, 'adminmenu', 36, 'icon-list-alt', 69, 0, '', 1, 'manage-admin-menu'),
(32, '#', 0, '', 13, 0, '', 1, 'manage-modules'),
(35, 'adminwebmenuall', 36, 'icon-list-alt', 75, 0, '', 1, 'manage-web-menu'),
(36, '#', 7, 'icon-list-alt', 68, 0, '', 1, 'menu-manager'),
(37, '#', 7, 'icon-shopping-cart', 57, 0, '', 1, 'pay-modules-manager'),
(38, 'platobnemoduly/paypal_pevne_platby', 37, '', 58, 0, '', 1, 'pay-pal-manage'),
(39, 'platobnemoduly/skrill_pevne_platby', 37, '', 63, 0, '', 1, 'skrill-manage'),
(40, 'nastavenia', 21, '', 98, 0, '', 1, 'main-settings'),
(41, 'emailnastavenia', 21, '', 96, 0, '', 1, 'email-settings'),
(42, 'dashboard', 0, '', 12, 0, '', 0, 'dashboard'),
(43, 'stranky/zmazat', 1, '', 7, 0, '', 0, 'delete'),
(45, '#', 0, '', 0, 0, '', 0, 'auth'),
(46, 'auth/login', 45, '', 0, 0, '', 0, 'login'),
(51, 'platobnemoduly/paypal_nastavenia', 38, '', 59, 0, '', 0, 'pay-pal-settings'),
(52, 'platobnemoduly/paypal_pevne_platby_uprava', 38, '', 60, 0, '', 0, 'pay-pal-payedit'),
(53, 'platobnemoduly/paypal_pevne_platby_zmazat', 38, '', 61, 0, '', 0, 'paypal-delete-pay'),
(54, 'platobnemoduly/skrill_nastavenia', 39, '', 64, 0, '', 0, 'skrill-settings'),
(55, 'platobnemoduly/skrill_pevne_platby_uprava', 39, '', 65, 0, '', 0, 'skrill-payedit'),
(56, 'platobnemoduly/skrill_pevne_platby_zmazat', 39, '', 66, 0, '', 0, 'skrill-delete-pay'),
(58, 'adminmenu/saveForm', 31, '', 73, 0, '', 0, 'save-admin-menu'),
(59, 'adminmenu/delMenu', 31, '', 70, 0, '', 0, 'delete-admin-menu'),
(60, 'adminmenu/editMenu', 31, '', 71, 0, '', 0, 'edit-admin-menu'),
(61, 'adminmenu/save', 31, '', 72, 0, '', 0, 'save-admin-menu-ajax'),
(62, 'adminmenu/savePoradie', 31, '', 74, 0, '', 0, 'saveposicion-admin-menu'),
(63, 'adminwebmenu/saveForm', 35, '', 79, 0, '', 0, 'saveform-web-menu'),
(64, 'adminwebmenu/delMenu', 35, '', 76, 0, '', 0, 'delete-web-menu'),
(65, 'adminwebmenu/editMenu', 35, '', 77, 0, '', 0, 'edit-web-menu'),
(66, 'adminwebmenu/save', 35, '', 78, 0, '', 0, 'save-web-menu'),
(67, 'adminwebmenu/saveporadie', 35, '', 80, 0, '', 0, 'saveposicion-web-menu'),
(68, 'adminwebmenuall/zmazat', 36, '', 83, 0, '', 0, 'delete-type-web-menu'),
(69, 'adminwebmenuall/uprava', 36, '', 82, 0, '', 0, 'edit-type-web-menu'),
(70, '#', 36, '', 0, 0, '', 0, 'admin-web-menu'),
(71, 'adminwebmenu/zobraz', 35, '', 81, 0, '', 0, 'view-web-menu'),
(72, 'opravneniaskupiny/zmazat', 20, '', 104, 0, '', 0, 'delete-perrmision'),
(73, 'opravneniaskupiny/uprava', 20, '', 103, 0, '', 0, 'edit-permison'),
(74, 'spravapouzivatelov/zmazat', 23, '', 107, 0, '', 0, 'del-user'),
(75, 'spravapouzivatelov/uprava', 23, '', 106, 0, '', 0, 'edit-user'),
(76, 'emailnastavenia/upravit', 41, '', 97, 0, '', 0, 'edit-emailsetting'),
(77, 'nastavenia/upravitObecne', 40, '', 100, 0, '', 0, 'edit-main-setting'),
(78, 'nastavenia/upravitKontakt', 40, '', 99, 0, '', 0, 'edit-emailcontact-setting'),
(79, 'spravajazykovadmin/deactive', 24, '', 87, 0, '', 0, 'deactivate-language'),
(81, 'spravajazykovadmin/active', 24, '', 86, 0, '', 0, 'activate-language'),
(82, 'spravajazykovadmin/recreate', 24, '', 88, 0, '', 0, 'recreate-language'),
(83, 'spravajazykovadmin/uprava', 24, '', 89, 0, '', 0, 'edit-language'),
(84, 'spravajazykovweb/active', 22, '', 91, 0, '', 0, 'activate-language'),
(85, 'spravajazykovweb/deactive', 22, '', 92, 0, '', 0, 'deactivate-language'),
(86, 'spravajazykovweb/recreate', 22, '', 93, 0, '', 0, 'recreate-language'),
(87, 'spravajazykovweb/uprava', 22, '', 94, 0, '', 0, 'edit-language'),
(88, 'dokumenty/odstranit', 2, '', 16, 0, '', 0, 'delete-document'),
(89, 'dokumenty/ulozit', 2, '', 18, 0, '', 0, 'save-document'),
(90, 'fotogaleria/pridajobrazky', 3, '', 26, 0, '', 0, 'add-new-images'),
(91, 'fotogaleria/ajaxUpload', 3, '', 22, 0, '', 0, 'ajax-upload-images'),
(92, 'fotogaleria/ajaxPoradie', 3, '', 21, 0, '', 0, 'ajax-position-images'),
(93, 'fotogaleria/zmazat', 3, '', 28, 0, '', 0, 'delete-gallery'),
(94, 'fotogaleria/ajaxZmazFotku', 3, '', 23, 0, '', 0, 'delete-images'),
(95, 'fotogaleria/editFoto', 3, '', 24, 0, '', 0, 'edit-image'),
(96, 'fotogaleria/ulozitObrazok', 3, '', 27, 0, '', 0, 'save-edit-image'),
(97, 'sliders/ulozit', 4, '', 36, 0, '', 0, 'save-slider'),
(98, 'sliders/ulozitfoto', 4, '', 37, 0, '', 0, 'save-image-slider'),
(99, 'sliders/pridajfotoslider', 4, '', 35, 0, '', 0, 'add-image-slider'),
(100, 'sliders/editfotoslider', 4, '', 32, 0, '', 0, 'edit-image-slider'),
(101, 'sliders/ajaxPoradie', 4, '', 31, 0, '', 0, 'ajax-position-slider'),
(102, 'sliders/odstranfoto', 4, '', 34, 0, '', 0, 'delete-image-slider'),
(103, 'navbloky/ulozit', 5, '', 43, 0, '', 0, 'save-nav-block'),
(104, 'navbloky/odstranit', 5, '', 41, 0, '', 0, 'delete-nav-block'),
(105, 'navbloky/ajaxporadie', 5, '', 40, 0, '', 0, 'ajax-save-nav-block'),
(106, 'partnery/ulozit', 6, '', 48, 0, '', 0, 'save-new'),
(107, 'partnery/deletpartner', 6, '', 46, 0, '', 0, 'delete-partner'),
(109, 'filemanager/manage', 28, '', 4, 0, 'class=dsfdsfdsfd', 0, 'upload-file'),
(110, 'filemanager/createnewfolder', 28, '', 2, 0, 'class=dsfdsfdsfd', 0, 'create-folder'),
(111, 'filemanager/del', 28, '', 3, 0, 'class=dsfdsfdsfd', 0, 'delete-file'),
(113, 'nastavenia/upravitga', 21, '', 101, 0, '', 0, 'google-analytics-setting'),
(118, 'platobnemoduly/paypal_logy', 37, '', 62, 0, '', 0, 'pay-pal-logy'),
(119, 'platobnemoduly/skrill_logy', 37, '', 67, 0, '', 0, 'skrill-logy'),
(120, 'platobnemoduly/show_transactions', 37, '', 0, 0, '', 1, 'show-transactions'),
(121, 'fotogalerianastavenia', 3, 'icon-cog', 0, 0, '', 1, 'gallery-setting'),
(122, 'fotogalerianastavenia/rozlisenie', 3, '', 0, 0, '', 0, 'resolution'),
(123, 'fotogalerianastavenia/zmazat', 3, '', 0, 0, '', 0, 'delete-resolution');

----odelovac---

CREATE TABLE IF NOT EXISTS `admin_menu_langs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_admin_language` int(11) NOT NULL,
  `id_admin_menu` int(11) NOT NULL,
  `nazov` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=235 ;

----odelovac---

INSERT INTO `admin_menu_langs` (`id`, `id_admin_language`, `id_admin_menu`, `nazov`) VALUES
(1, 4, 1, 'Pages'),
(2, 4, 2, 'Dokuments'),
(3, 4, 3, 'Photogallery'),
(4, 4, 4, 'Sliders'),
(5, 4, 5, 'Navigation'),
(6, 4, 6, 'Partners'),
(7, 4, 7, 'Settings'),
(8, 4, 8, 'Add page'),
(9, 4, 9, 'List pages'),
(10, 4, 10, 'Add document'),
(11, 4, 11, 'Show documents'),
(12, 4, 12, 'Add new'),
(13, 4, 13, 'Show all'),
(14, 4, 14, 'Add slider'),
(15, 4, 15, 'Show '),
(16, 4, 16, 'Add navigation block'),
(17, 4, 17, 'Show All'),
(18, 4, 18, 'Add partner'),
(19, 4, 19, 'Show partners'),
(20, 4, 20, 'Group permissions'),
(21, 4, 21, 'Settings systems'),
(22, 4, 22, 'Web languages administration'),
(23, 4, 23, 'Users administration'),
(24, 4, 24, 'Admin languages administration'),
(25, 3, 1, 'Stránky'),
(26, 3, 2, 'Dokumenty'),
(27, 3, 3, 'Fotogalérie'),
(28, 3, 4, 'Slidery'),
(29, 3, 5, 'Navigácia'),
(30, 3, 6, 'Partnery'),
(31, 3, 7, 'Nastavenia'),
(32, 3, 8, 'Pridať stránku'),
(33, 3, 9, 'Zobraziť stránky'),
(34, 3, 10, 'Pridať dokument'),
(35, 3, 11, 'Zobraziť dokumenty'),
(36, 3, 12, 'Pridať novú'),
(37, 3, 13, 'Zobraziť všetky'),
(38, 3, 14, 'Pridať slider'),
(39, 3, 15, 'Zobraziť'),
(40, 3, 16, 'Pridať navigačný blok'),
(41, 3, 17, 'Zobraziť všetky'),
(42, 3, 18, 'Pridať partnera'),
(43, 3, 19, 'Zobraziť partnerov'),
(44, 3, 20, 'Skupiny oprávnenia'),
(45, 3, 21, 'Nastavenie systému'),
(46, 3, 22, 'Nastavenia jazykov web'),
(47, 3, 23, 'Administrácia používateľov'),
(48, 3, 24, 'Nastavenia jazykov admin'),
(49, 3, 25, 'Správa Jazykov'),
(52, 3, 28, 'Zobraziť súbory'),
(53, 4, 28, 'Browse Files'),
(54, 4, 25, 'Language manager'),
(56, 1, 28, 'nemecky'),
(57, 2, 28, 'francuzky'),
(60, 3, 31, 'Administrácia menu'),
(61, 4, 31, 'Admin menu'),
(62, 4, 32, 'Modules'),
(63, 3, 32, 'Moduly'),
(69, 4, 35, 'Web Menu manager'),
(70, 3, 35, 'Web menu manager'),
(71, 4, 36, 'Menu Manager'),
(72, 3, 36, 'Menu Manager'),
(73, 4, 37, 'Platobné moduly'),
(74, 3, 37, 'Platobné moduly'),
(75, 4, 38, 'PayPal'),
(76, 3, 38, 'PayPal'),
(77, 4, 39, 'Skrill MoneyBookes'),
(78, 3, 39, 'Skrill MoneyBookes'),
(79, 4, 40, 'Main Settings'),
(80, 3, 40, 'Hlavné Nastavenia'),
(81, 4, 41, 'Email Settings'),
(82, 3, 41, 'Nastevenia Email-u'),
(83, 4, 71, 'View web menu'),
(84, 4, 70, 'Web menu admin'),
(85, 4, 69, 'Edit web menu type'),
(86, 4, 68, 'Delete web menu typ'),
(87, 4, 67, 'Edit web menu position'),
(88, 4, 66, 'Save web menu'),
(89, 4, 65, 'Edit web menu'),
(90, 4, 64, 'Delete web menu'),
(91, 4, 63, 'Add web menu'),
(92, 4, 62, 'Change admin menu position'),
(93, 4, 61, 'Save admin menu'),
(94, 4, 60, 'Edit admin menu'),
(95, 4, 59, 'Delete admin menu'),
(96, 4, 58, 'Add admin menu'),
(97, 4, 56, 'Delete skrill pay'),
(98, 4, 55, 'Edit skrill pay '),
(99, 4, 54, 'Skrill settings'),
(100, 4, 53, 'Delete pay paypal'),
(101, 4, 52, 'Edit pay paypal'),
(102, 4, 51, 'Edit paypal settings'),
(107, 4, 43, 'Delete page'),
(108, 4, 42, 'Dashboard'),
(110, 3, 43, 'Zmazať Stránku'),
(111, 3, 42, 'Úvodná obrazovka'),
(116, 3, 51, 'Upraviť paypal nastavenia'),
(117, 3, 52, 'Upraviť pevnú platbu'),
(118, 3, 53, 'Zmazať pevnú paypal platbu'),
(119, 3, 54, 'Skrill nastavenia'),
(120, 3, 55, 'Upraviť Skrill pevnú platbu'),
(121, 3, 56, 'Zmazať Skrill pevnú platbu'),
(122, 3, 59, 'Zmazať admin menu'),
(123, 3, 60, 'Upraviť admin menu'),
(124, 3, 61, 'Uložiť admin menu'),
(125, 3, 58, 'Pridať Admin menu'),
(126, 3, 62, 'Zmeniť Admin menu'),
(127, 3, 69, 'Upraviť web menu tipy'),
(128, 3, 68, 'Zmazať typ web menu'),
(129, 3, 64, 'Zmazať web menu'),
(130, 3, 65, 'Upraviť web menu'),
(131, 3, 66, 'Uloziť web menu'),
(132, 3, 63, 'Pridať/Upraviť web menu'),
(133, 3, 67, 'Upraviť poradie web menu'),
(134, 3, 71, 'Zobraziť web menu'),
(135, 4, 72, 'Delete perrmision'),
(136, 3, 72, 'Zmazať Opravnenie'),
(137, 4, 73, 'Edit permission'),
(138, 3, 73, 'Editovať oprávnenia'),
(139, 4, 74, 'Delete user'),
(140, 3, 74, 'Zmazať Používateľa'),
(141, 4, 75, 'Edit User'),
(142, 3, 75, 'Upraviť Používateľa'),
(143, 4, 76, 'Edit Email Setting'),
(144, 3, 76, 'Upraviť Email Nastavenia'),
(145, 4, 77, 'Edit Main setting'),
(146, 3, 77, 'Upraviť Hlavné Nastavenia'),
(147, 4, 78, 'Edit email contact Setting'),
(148, 3, 78, 'Upraviť email kontakt nastavenia'),
(149, 4, 79, 'Deactivate language'),
(150, 3, 79, 'Deaktivovať jazyk'),
(153, 4, 81, 'Activate language'),
(154, 3, 81, 'Aktivovať jazyk'),
(155, 4, 82, 'Recreate language'),
(156, 3, 82, 'Znovu vytvorenie jazyka'),
(157, 4, 83, 'Edit language'),
(158, 3, 83, 'Úprava jazyka'),
(159, 4, 84, 'Activate language'),
(160, 3, 84, 'Aktivovať jazyk'),
(161, 4, 85, 'Deactivate language'),
(162, 3, 85, 'Deaktivovať jazyk'),
(163, 4, 86, 'Recreate language'),
(164, 3, 86, 'Znovu vytvorenie jazyka'),
(165, 4, 87, 'Edit language'),
(166, 3, 87, 'Úprava jazyka'),
(167, 4, 88, 'Delete document'),
(168, 3, 88, 'Zmazať dokument'),
(169, 4, 89, 'Save document'),
(170, 3, 89, 'Uložiť dokument'),
(171, 4, 90, 'Add images'),
(172, 3, 90, 'Pridať obrazky'),
(173, 4, 91, 'Ajax Upload'),
(174, 3, 91, 'Ajax nahrávanie'),
(175, 4, 92, 'Ajax Position'),
(176, 3, 92, 'Ajax úprava pozície'),
(177, 4, 93, 'Delete gallery'),
(178, 3, 93, 'Zmazať fotogaleriu'),
(179, 4, 94, 'Delete image'),
(180, 3, 94, 'Zmazať fotku'),
(181, 4, 95, 'Edit image'),
(182, 3, 95, 'Upraviť obrazok'),
(183, 4, 96, 'Edit/Save image'),
(184, 3, 96, 'Uloziť obrazok'),
(185, 4, 97, 'Save slider'),
(186, 3, 97, 'Uloziť slider'),
(187, 4, 98, 'Save Image slider'),
(188, 3, 98, 'Uloziť obrázok slidera'),
(189, 4, 99, 'Add Image slider'),
(190, 3, 99, 'Pridať obrázok slidera'),
(191, 4, 100, 'Edit Image slider'),
(192, 3, 100, 'Upraviť obrázok slidera'),
(193, 4, 101, 'Ajax Position'),
(194, 3, 101, 'Ajax úprava pozície'),
(195, 4, 102, 'Delete Image'),
(196, 3, 102, 'Zmazať obrázok slidera'),
(197, 4, 103, 'Save navigation block'),
(198, 3, 103, 'Uloziť navigačný blok'),
(199, 4, 104, 'Delete navigation block'),
(200, 3, 104, 'Zmazať navigačný blok'),
(201, 4, 105, 'Ajax Position'),
(202, 3, 105, 'Ajax úprava pozície'),
(203, 4, 106, 'Save partner'),
(204, 3, 106, 'Uložiť partnera'),
(205, 4, 107, 'Delete partner'),
(206, 3, 107, 'Zmazať partnera'),
(207, 4, 109, 'Upload/Delete file'),
(208, 3, 109, 'Nahrať/Zmazať súbory'),
(209, 4, 110, 'Create Folder'),
(210, 3, 110, 'Vytvoriť Priečinok'),
(211, 4, 111, 'Delete files'),
(212, 3, 111, 'Zmazať Súbory'),
(213, 4, 113, 'Google analytics Settings'),
(214, 3, 113, 'Google analytics nastavenia'),
(223, 4, 118, 'PayPal logy'),
(224, 3, 118, 'PayPal logy'),
(225, 4, 119, 'Skrill Logy'),
(226, 3, 119, 'Skrill Logy'),
(227, 4, 120, 'Transactions'),
(228, 3, 120, 'Transakcie'),
(229, 4, 121, 'Resolution Settings'),
(230, 3, 121, 'Nastavenie Rozlíšenia'),
(231, 4, 122, 'Edit Resolution'),
(232, 3, 122, 'Uprava Rozlíšenia'),
(233, 4, 123, 'Delete Resolution'),
(234, 3, 123, 'Zmazať Rozlíšenie');

----odelovac---

CREATE TABLE IF NOT EXISTS `admin_mod_dokumenty` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nazov` varchar(50) NOT NULL,
  `dokument` varchar(250) NOT NULL,
  `popis` text,
  `modifikacia` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `poradie` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

----odelovac---

CREATE TABLE IF NOT EXISTS `admin_mod_fotogaleria_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nazov` varchar(250) NOT NULL,
  `popis` text NOT NULL,
  `small_nazov` varchar(250) NOT NULL,
  `small_popis` varchar(250) NOT NULL,
  `meta_desc` varchar(200) DEFAULT NULL,
  `meta_tags` varchar(200) DEFAULT NULL,
  `url_adresa` varchar(250) DEFAULT NULL,
  `poradie` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

----odelovac---

CREATE TABLE IF NOT EXISTS `admin_mod_fotogaleria_nastavenia` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cesta_k_obrazkom` varchar(250) NOT NULL,
  `cesta_k_obrazkom_tumbs` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

----odelovac---

INSERT INTO `admin_mod_fotogaleria_nastavenia` (`id`, `cesta_k_obrazkom`, `cesta_k_obrazkom_tumbs`) VALUES
(1, 'uploads/gallery', 'uploads/gallery/tumbs');

----odelovac---

CREATE TABLE IF NOT EXISTS `admin_mod_fotogaleria_obrazky` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_admin_mod_fotogaleria_data` int(11) NOT NULL,
  `nazov` varchar(250) NOT NULL,
  `popis` text NOT NULL,
  `adresa` varchar(250) NOT NULL,
  `poradie` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

----odelovac---

CREATE TABLE IF NOT EXISTS `admin_mod_fotogaleria_rozlisenia` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nazov` varchar(250) NOT NULL,
  `vyska` int(11) NOT NULL,
  `sirka` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

----odelovac---

INSERT INTO `admin_mod_fotogaleria_rozlisenia` (`id`, `nazov`, `vyska`, `sirka`) VALUES
(1, 'Medium', 200, 200);

----odelovac---

CREATE TABLE IF NOT EXISTS `admin_mod_navbloky` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nadpis` varchar(45) NOT NULL,
  `odkaz_na_stranku` varchar(250) NOT NULL,
  `icon` varchar(100) NOT NULL,
  `text` text NOT NULL,
  `poradie` int(11) NOT NULL DEFAULT '0',
  `modifikacia` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

----odelovac---

CREATE TABLE IF NOT EXISTS `admin_mod_pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_parent` int(11) NOT NULL DEFAULT '0',
  `nazov` varchar(45) NOT NULL,
  `obsah` text NOT NULL,
  `seo_popis` varchar(250) DEFAULT NULL,
  `seo_tagy` varchar(250) DEFAULT NULL,
  `seo_url` varchar(250) DEFAULT NULL,
  `kod_pre_zavolanie` varchar(250) DEFAULT NULL,
  `modifikacia` int(11) NOT NULL,
  `pevna` tinyint(4) NOT NULL COMMENT '1 ak sa neda zmazat cez admina',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

----odelovac---

INSERT INTO `admin_mod_pages` (`id`, `id_parent`, `nazov`, `obsah`, `seo_popis`, `seo_tagy`, `seo_url`, `kod_pre_zavolanie`, `modifikacia`, `pevna`) VALUES
(1, 0, 'Page 404', '', '', '', '', 'page404', 1370512970, 1),
(2, 0, 'Test page', '', '', '', 'testpage', '', 1370513286, 0);

----odelovac---

CREATE TABLE IF NOT EXISTS `admin_mod_pages_langs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_admin_web_language` int(11) NOT NULL,
  `id_admin_mod_pages` int(11) NOT NULL,
  `obsah` text NOT NULL,
  `seo_popis` varchar(250) NOT NULL,
  `seo_tagy` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

----odelovac---

INSERT INTO `admin_mod_pages_langs` (`id`, `id_admin_web_language`, `id_admin_mod_pages`, `obsah`, `seo_popis`, `seo_tagy`) VALUES
(1, 4, 1, '<h1>404 Error</h1>', '', ''),
(2, 3, 1, '<h1>404 Chyba</h1>', '', ''),
(3, 4, 2, '<h1>Test page</h1>', '', ''),
(4, 3, 2, '<h1>Testovacia Stranka</h1>', '', '');

----odelovac---

CREATE TABLE IF NOT EXISTS `admin_mod_partnery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nazov` varchar(100) NOT NULL,
  `logo` varchar(100) DEFAULT NULL,
  `url` text,
  `popis` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

----odelovac---

CREATE TABLE IF NOT EXISTS `admin_mod_sliders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nazov` varchar(50) NOT NULL,
  `umiestnenie` varchar(50) NOT NULL,
  `popis` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

----odelovac---

CREATE TABLE IF NOT EXISTS `admin_mod_sliders_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_mod_sliders` int(11) NOT NULL,
  `name` varchar(40) NOT NULL,
  `image` text NOT NULL,
  `popis` text NOT NULL,
  `poradie` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

----odelovac---

CREATE TABLE IF NOT EXISTS `admin_nastavenia` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nazov_webu` varchar(50) NOT NULL,
  `meta_desc` varchar(250) NOT NULL,
  `meta_tags` varchar(250) NOT NULL,
  `zahlavie_webu` text NOT NULL,
  `footer_webu` text NOT NULL,
  `google_gode` text NOT NULL,
  `date_format` varchar(100) NOT NULL,
  `time_zone` varchar(100) NOT NULL,
  `email_pre_kontakt` varchar(250) NOT NULL,
  `ga_user` varchar(100) NOT NULL,
  `ga_pass` varchar(50) NOT NULL,
  `ga_profil` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

----odelovac---

INSERT INTO `admin_nastavenia` (`id`, `nazov_webu`, `meta_desc`, `meta_tags`, `zahlavie_webu`, `footer_webu`, `google_gode`, `date_format`, `time_zone`, `email_pre_kontakt`, `ga_user`, `ga_pass`, `ga_profil`) VALUES
(1, 'KF CMS sample page', 'SEO desc', 'SEO tags', 'Header from settings', 'Footer from settings', '', 'd.m.Y, H:i:s', 'Europe/Belgrade', '', '', '', '');

----odelovac---

CREATE TABLE IF NOT EXISTS `admin_pages_language` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `active` tinyint(4) NOT NULL,
  `iso_code` varchar(15) NOT NULL,
  `icon` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='tato tabulka sa asi nebude vyuzivat' AUTO_INCREMENT=3 ;

----odelovac---

INSERT INTO `admin_pages_language` (`id`, `name`, `active`, `iso_code`, `icon`) VALUES
(2, 'Slovak', 1, 'sk_SK', 'sk.png');

----odelovac---

CREATE TABLE IF NOT EXISTS `admin_permission` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nazov` varchar(50) NOT NULL,
  `popis` text NOT NULL,
  `time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

----odelovac---

INSERT INTO `admin_permission` (`id`, `nazov`, `popis`, `time`) VALUES
(1, 'System Admin', 'Main Admin', 1370443356);

----odelovac---

CREATE TABLE IF NOT EXISTS `admin_permission_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_permission` int(11) NOT NULL,
  `admin_menu` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

----odelovac---

CREATE TABLE IF NOT EXISTS `admin_platobnemoduly_paypal` (
  `id` tinyint(4) NOT NULL,
  `paypal_email` varchar(250) NOT NULL,
  `paypal_currency_code` varchar(10) NOT NULL,
  `paypal_live` tinyint(4) NOT NULL,
  `language` varchar(5) NOT NULL,
  `ipn_log` tinyint(4) NOT NULL,
  `logo_url` varchar(240) NOT NULL,
  `form_title` varchar(200) NOT NULL,
  `form_text` text NOT NULL,
  `form_submit` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

----odelovac---

INSERT INTO `admin_platobnemoduly_paypal` (`id`, `paypal_email`, `paypal_currency_code`, `paypal_live`, `language`, `ipn_log`, `logo_url`, `form_title`, `form_text`, `form_submit`) VALUES
(1, 'mail@gmail.com', 'EUR', 1, 'EN', 1, '', 'Processing....', 'Please wait, your order is being processed and you will be redirected to the paypal website.', 'Click here if you\\''re not automatically redirected...');

----odelovac---

CREATE TABLE IF NOT EXISTS `admin_platobnemoduly_paypal_log` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT,
  `log_data` text,
  `log_created` datetime DEFAULT NULL,
  PRIMARY KEY (`log_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

----odelovac---

CREATE TABLE IF NOT EXISTS `admin_platobnemoduly_paypal_pevne_platby` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `identifikator` varchar(100) NOT NULL,
  `popis` text NOT NULL,
  `item_name` varchar(250) NOT NULL,
  `amount` varchar(25) NOT NULL,
  `mena` varchar(15) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT '1',
  `return` text NOT NULL,
  `cancel_return` text NOT NULL,
  `notify_url` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

----odelovac---

CREATE TABLE IF NOT EXISTS `admin_platobnemoduly_skrill` (
  `id` int(11) NOT NULL,
  `pay_to_email` varchar(50) NOT NULL,
  `hashovacieSlovo` varchar(240) NOT NULL,
  `language` varchar(2) NOT NULL,
  `currency` varchar(5) NOT NULL,
  `recipient_description` varchar(30) NOT NULL,
  `logo_url` varchar(240) NOT NULL,
  `logovanie` tinyint(4) NOT NULL,
  `form_title` varchar(250) NOT NULL,
  `form_submit` varchar(250) NOT NULL,
  `form_text` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

----odelovac---

INSERT INTO `admin_platobnemoduly_skrill` (`id`, `pay_to_email`, `hashovacieSlovo`, `language`, `currency`, `recipient_description`, `logo_url`, `logovanie`, `form_title`, `form_submit`, `form_text`) VALUES
(1, 'mail@gmail.com', '', 'EN', 'EUR', '', '', 1, 'Processing....', 'Click here if youre not automatically redirected...', '');

----odelovac---

CREATE TABLE IF NOT EXISTS `admin_platobnemoduly_skrill_log` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT,
  `log_data` text NOT NULL,
  `log_created` datetime NOT NULL,
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

----odelovac---

CREATE TABLE IF NOT EXISTS `admin_platobnemoduly_skrill_pevne_platby` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `identifikator` varchar(100) NOT NULL,
  `popis` text NOT NULL,
  `detail1_description` varchar(240) NOT NULL,
  `detail1_text` varchar(240) NOT NULL,
  `amount` varchar(25) NOT NULL,
  `currency` varchar(3) NOT NULL,
  `return_url` text NOT NULL,
  `confirmation_note` varchar(240) NOT NULL,
  `cancel_url` text NOT NULL,
  `status_url` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

----odelovac---

CREATE TABLE IF NOT EXISTS `admin_platobnemoduly_transactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `txn_id` varchar(150) NOT NULL,
  `user_id` int(11) NOT NULL,
  `amount` varchar(250) NOT NULL,
  `currency` varchar(10) NOT NULL,
  `date` int(11) NOT NULL,
  `gateway` varchar(50) NOT NULL,
  `ip` varchar(20) NOT NULL,
  `status` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

----odelovac---

CREATE TABLE IF NOT EXISTS `admin_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8_bin NOT NULL,
  `password` varchar(255) COLLATE utf8_bin NOT NULL,
  `email` varchar(100) COLLATE utf8_bin NOT NULL,
  `activated` tinyint(1) NOT NULL DEFAULT '1',
  `banned` tinyint(1) NOT NULL DEFAULT '0',
  `ban_reason` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `new_password_key` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `new_password_requested` datetime DEFAULT NULL,
  `new_email` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `new_email_key` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `last_ip` varchar(40) COLLATE utf8_bin NOT NULL,
  `last_login` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `admin_permission` int(11) NOT NULL DEFAULT '300',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

----odelovac---

CREATE TABLE IF NOT EXISTS `admin_user_autologin` (
  `key_id` char(32) COLLATE utf8_bin NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `user_agent` varchar(150) COLLATE utf8_bin NOT NULL,
  `last_ip` varchar(40) COLLATE utf8_bin NOT NULL,
  `last_login` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`key_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

----odelovac---

CREATE TABLE IF NOT EXISTS `admin_user_profiles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `country` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `website` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

----odelovac---

CREATE TABLE IF NOT EXISTS `admin_web_language` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dir` varchar(25) NOT NULL,
  `name` varchar(100) NOT NULL,
  `active` tinyint(4) NOT NULL,
  `default` tinyint(4) NOT NULL,
  `icon` varchar(100) NOT NULL,
  `iso_code` varchar(10) NOT NULL,
  `code` varchar(2) NOT NULL,
  `poradie` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=21 ;

----odelovac---

INSERT INTO `admin_web_language` (`id`, `dir`, `name`, `active`, `default`, `icon`, `iso_code`, `code`, `poradie`) VALUES
(1, 'dutch', 'Nederlands', 0, 0, 'nl.png', 'nl_NL', 'nl', 0),
(2, 'french', 'Français', 0, 0, 'fr.png', 'fr_FR', 'fr', 0),
(3, 'slovak', 'Slovenčina', 1, 0, 'sk.png', 'sk_SK', 'sk', 2),
(4, 'english', 'English', 1, 1, 'en.png', 'en_US', 'en', 4),
(5, 'czech', 'Čeština', 0, 0, 'cs.png', 'cs_CS', 'cs', 0),
(6, 'finnish', 'Suomi', 0, 0, 'fi.png', 'fi_FI', 'fi', 0),
(7, 'greek', 'ελληνικά', 0, 0, 'el.png', 'el_EL', 'el', 0),
(8, 'finnish', 'Suomi', 0, 0, 'fi.png', 'fi_FI', 'fi', 0),
(9, 'french', 'Français', 0, 0, 'fr.png', 'fr_FR', 'fr', 0),
(10, 'danish', 'Dansk', 0, 0, 'da.png', 'da_DA', 'da', 0),
(11, 'hungarian', 'Magyar', 0, 0, 'hu.png', 'hu_HU', 'hu', 0),
(12, 'chinese_simplified', '汉语', 0, 0, 'zh.png', 'zh_ZH', 'zh', 0),
(13, 'indonesian', 'Bahasa Indonesia', 0, 0, 'id.png', 'id_ID', 'id', 0),
(14, 'italian', 'Italiano', 0, 0, 'it.png', 'it_IT', 'it', 0),
(15, 'polish', 'Polszczyzna', 0, 0, 'pl.png', 'pl_PL', 'pl', 0),
(16, 'portuguese', 'Português', 0, 0, 'pt.png', 'pt_PT', 'pt', 0),
(17, 'russian', 'Pусский язык', 0, 0, 'ru.png', 'ru_RU', 'ru', 0),
(18, 'slovenian', 'Slovenski jezik', 0, 0, 'sl.png', 'sl_SL', 'sl', 0),
(19, 'spanish', 'Español', 0, 0, 'es.png', 'es_ES', 'es', 0),
(20, 'swedish', 'Svenska', 0, 0, 'sv.png', 'sv_SV', 'sv', 0);

----odelovac---

CREATE TABLE IF NOT EXISTS `admin_web_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kontroler` varchar(200) NOT NULL,
  `id_parrent` int(11) NOT NULL,
  `icon` varchar(100) NOT NULL,
  `poradie` int(11) DEFAULT '0',
  `type` tinyint(4) NOT NULL COMMENT '0 - kontroler, 1 - user page',
  `options` varchar(250) NOT NULL,
  `typ_menu` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

----odelovac---

CREATE TABLE IF NOT EXISTS `admin_web_menu_all` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `identifikator` varchar(100) NOT NULL COMMENT 'sluzi pre volanie menu v kontexte',
  `popis` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

----odelovac---

CREATE TABLE IF NOT EXISTS `admin_web_menu_langs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_admin_language` int(11) NOT NULL,
  `id_admin_menu` int(11) NOT NULL,
  `nazov` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
