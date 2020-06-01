/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MariaDB
 Source Server Version : 100411
 Source Host           : localhost:3306
 Source Schema         : thanghust

 Target Server Type    : MariaDB
 Target Server Version : 100411
 File Encoding         : 65001

 Date: 02/06/2020 06:45:52
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for admins
-- ----------------------------
DROP TABLE IF EXISTS `admins`;
CREATE TABLE `admins`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `avata` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of admins
-- ----------------------------
INSERT INTO `admins` VALUES (1, '', 'xxx', '123@gmail.com', 'HN', '09090909', '$2y$12$lIM2knmIIXp.dheNPETsdORfrURn98txuS5B15BW9OIVSsyBg/PhS', NULL, '2020-05-19 23:22:14', '2020-05-19 23:22:16');

-- ----------------------------
-- Table structure for categories
-- ----------------------------
DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` char(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `parent_id` char(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sort_order` tinyint(4) NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of categories
-- ----------------------------
INSERT INTO `categories` VALUES (1, 'Rượu Bia', '0', 0, '2020-05-30 04:01:22', '2020-05-30 04:01:22');
INSERT INTO `categories` VALUES (2, 'Món Nướng', '0', 0, '2020-05-31 15:54:10', '2020-05-31 15:54:10');

-- ----------------------------
-- Table structure for gallary_images
-- ----------------------------
DROP TABLE IF EXISTS `gallary_images`;
CREATE TABLE `gallary_images`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `link` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_id` int(11) NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of gallary_images
-- ----------------------------
INSERT INTO `gallary_images` VALUES (1, 'http://localhost:8000/images/product/15908114500.webp', 1, '2020-05-30 04:04:10', '2020-05-30 04:04:10');
INSERT INTO `gallary_images` VALUES (2, 'http://localhost:8000/images/product/15908116650.webp', 2, '2020-05-30 04:07:45', '2020-05-30 04:07:45');

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 52 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES (40, '2014_10_12_000000_create_users_table', 1);
INSERT INTO `migrations` VALUES (41, '2014_10_12_100000_create_password_resets_table', 1);
INSERT INTO `migrations` VALUES (42, '2018_04_26_065628_create_products_table', 1);
INSERT INTO `migrations` VALUES (44, '2018_04_26_065954_create_admins_table', 1);
INSERT INTO `migrations` VALUES (45, '2018_04_26_090104_create_gallary_images_table', 1);
INSERT INTO `migrations` VALUES (46, '2018_05_15_041738_create_categories_table', 1);
INSERT INTO `migrations` VALUES (47, '2020_05_11_034216_create_tables_table', 1);
INSERT INTO `migrations` VALUES (48, '2020_05_31_091104_create_shoppingcart_table', 2);
INSERT INTO `migrations` VALUES (49, '2018_04_26_065935_create_orders_table', 3);
INSERT INTO `migrations` VALUES (50, '2020_05_31_161845_create_waits_table', 3);
INSERT INTO `migrations` VALUES (51, '2020_06_01_155927_create_order_product_table', 3);

-- ----------------------------
-- Table structure for order_product
-- ----------------------------
DROP TABLE IF EXISTS `order_product`;
CREATE TABLE `order_product`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for orders
-- ----------------------------
DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `note` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `table_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total` int(11) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for password_resets
-- ----------------------------
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets`  (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for products
-- ----------------------------
DROP TABLE IF EXISTS `products`;
CREATE TABLE `products`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `cost` int(11) NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int(10) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of products
-- ----------------------------
INSERT INTO `products` VALUES (3, 'chivas 12', 2100000, 'Chivas 12 là một dòng blended Scotch whisky nổi tiếng trên toàn thế giới. Đó là một loại whisky hội tụ đủ tất cả các điều tốt đẹp. Trong đó bao gồm việc được sử dụng những nguyên liệu tốt nhất. Cho đến việc được phối trộn theo một công thức tuyệt vời nhất.\n\nHãy cùng winemart tìm hiểu về dòng whisky ưu việt này. Cũng như bảng giá rượu Chivas trên cả nước.', '<h2>I. Về rượu Chivas Regal 12</h2>\n\n<p><img alt=\"Ruou Chivas Regal 12\" src=\"https://winemart.vn/storage/2018/07/Chivas-Regal-12.jpg\" style=\"height:600px; width:600px\" /></p>\n\n<p>Ruou Chivas Regal 12</p>\n\n<p>Chivas 12 c&oacute; vị kh&aacute; đậm đ&agrave;, mạnh mẽ nhưng cũng rất mượt m&agrave;. Đ&acirc;y l&agrave; d&ograve;ng blended whisky được pha trộn từ những loại ngũ cốc tốt nhất. Ngo&agrave;i ra, Chivas 12 cũng được ủ để trưởng th&agrave;nh hơn trong 12 năm.</p>\n\n<p>Ch&iacute;nh những điều đ&oacute;, tạo n&ecirc;n được hương vị rất tinh tế v&agrave; sang trọng của mật ong, vani v&agrave; t&aacute;o ch&iacute;n cho Chivas 12.</p>\n\n<p><em>Bạn c&oacute; thể t&igrave;m hiểu th&ecirc;m một số th&ocirc;ng tin sau:</em></p>\n\n<ul>\n	<li><strong><a href=\"https://winemart.vn/cach-nhan-biet-ruou-chivas-that-gia-2019/\" target=\"_blank\">C&aacute;ch nhận biết rượu Chivas thật, giả 2019</a></strong></li>\n	<li><a href=\"https://winemart.vn/ruou-macallan-12/\"><strong>Gi&aacute; rượu macallan 12 gi&aacute; tốt nhất thị trường</strong></a></li>\n	<li><strong><a href=\"https://winemart.vn/phan-biet-ruou-sake-va-soju/\" target=\"_blank\">Ph&acirc;n biệt rượu Sake v&agrave; Soju</a></strong></li>\n	<li><a href=\"https://winemart.vn/cac-loai-ruou-macallan/\"><strong>C&aacute;c loại rượu Macallan nổi tiếng hiện nay</strong></a></li>\n	<li><a href=\"https://winemart.vn/whisky-hay-whiskey/\"><strong>Whisky hay Whiskey? Theo d&ograve;ng thời gian truy t&igrave;m sự kh&aacute;c biệt</strong></a></li>\n</ul>\n\n<p>Đối với nh&agrave; s&aacute;ng lập James Chivas, c&oacute; hai nguy&ecirc;n tắc cơ bản d&agrave;nh cho việc pha trộn. Đ&oacute; ch&iacute;nh l&agrave; sử dụng những nguy&ecirc;n liệu đủ trưởng th&agrave;nh. V&agrave; đặc biệt nhất l&agrave; phải sử dụng những nguy&ecirc;n liệu đặc trưng của v&ugrave;ng Speyside l&agrave;m điểm nhấn.</p>\n\n<p>Ng&agrave;y nay, bậc thầy pha chế Colin Scott đ&atilde; tu&acirc;n theo những luật lệ đ&oacute;. &Ocirc;ng sử dụng loại whisky được chưng cất &iacute;t nhất l&agrave; 12 năm. Th&ecirc;m v&agrave;o đ&oacute; l&agrave; sử dụng những loại ngũ cốc c&oacute; nguồn gốc từ Speyside. Để tạo n&ecirc;n những chai Chivas l&agrave;m say đắm l&ograve;ng người.</p>\n\n<h2>II. Hương v&agrave; vị của Chivas 12</h2>\n\n<p><img alt=\"Hương và vị của rượu Chivas 12\" src=\"https://winemart.vn/storage/2018/07/Huong-va-vi-cua-ruou-Chivas-12.jpg\" style=\"height:600px; width:600px\" /></p>\n\n<p>Hương v&agrave; vị của rượu Chivas 12</p>\n\n<ul>\n	<li>Về m&agrave;u sắc: Chivas 12 c&oacute; m&agrave;u hổ ph&aacute;ch nhạt.</li>\n	<li>Đối với hương thơm: Chivas 12 mang hương thơm dễ chịu của c&aacute;c loại thảo mộc dại, m&ugrave;i da, mật ong v&agrave; c&aacute;c loại tr&aacute;i c&acirc;y ăn quả.</li>\n	<li>Về vị: Chivas 12 tr&ograve;n vị, đậm đ&agrave; với nhiều vị mật ong v&agrave; l&ecirc; ch&iacute;n. Kết hợp với m&ugrave;i hương dễ chịu của vani, quả hạnh v&agrave; kẹo bơ.</li>\n	<li>Hậu vị: k&eacute;o d&agrave;i v&agrave; rất đậm đ&agrave;.</li>\n</ul>\n\n<h2>III. Gợi &yacute; pha c&aacute;c loại cocktail từ Chivas 12</h2>\n\n<p>&nbsp;</p>\n\n<h3><em>1. Chivas Collins</em></h3>\n\n<p><img alt=\"Cocktail Chivas Collins\" src=\"https://winemart.vn/storage/2018/07/Cocktail-Chivas-Collins.jpg\" style=\"height:600px; width:600px\" /></p>\n\n<p>Cocktail Chivas Collins</p>\n\n<p>Đ&acirc;y l&agrave; một loai cocktail mang t&iacute;nh biểu tượng. Thuộc dạng cocktail cổ điển v&agrave; được phục vụ từ những năm 1820. N&oacute; cũng giống như Chivas, được ngao du từ Anh Quốc cho tới New York v&agrave; sau đ&oacute; l&agrave; qua ngược lại Anh Quốc.</p>\n\n<p><strong>Nguy&ecirc;n liệu d&ugrave;ng để pha chế:</strong></p>\n\n<ul>\n	<li>2 l&aacute;t t&aacute;o xanh</li>\n	<li>50ml Chivas Regal 12</li>\n	<li>100ml nước chanh</li>\n	<li>50ml nước soda</li>\n	<li>1 l&aacute;t chanh</li>\n</ul>\n\n<p><strong>C&aacute;ch pha chế:</strong></p>\n\n<ol>\n	<li>Bước 1: Đặt hai l&aacute;t t&aacute;o xanh ở cuối ly v&agrave; r&oacute;t Chivas v&agrave;o ly. Để khoảng một v&agrave;i ph&uacute;t. Những l&aacute;t t&aacute;o sẽ c&oacute; cơ hội tiếp x&uacute;c với whisky để bung tỏa những hương thơm v&agrave; m&ugrave;i vị độc đ&aacute;o. Đ&oacute; l&agrave; m&ugrave;i hương của c&aacute;c loại tr&aacute;i c&acirc;y ăn quả c&oacute; trong m&ugrave;i hương của Chivas 12.</li>\n	<li>Bước 2: Đổ đầy đ&aacute; vi&ecirc;n v&agrave;o ly. Tiếp theo r&oacute;t th&ecirc;m nước chanh v&agrave;o tr&ecirc;n bề mặt. Nước chanh sẽ l&agrave;m c&acirc;n bằng lại hương vị mật ong c&oacute; trong whisky.</li>\n	<li>Bước 3: Quấy đều thức uống.</li>\n	<li>Bước 4: Th&ecirc;m soda l&ecirc;n bề mặt. Nước soda sẽ l&agrave;m lo&atilde;ng ra thức uống. Gi&uacute;p thức uống bớt ngọt v&agrave; tạo cảm gi&aacute;c thanh m&aacute;t hơn.</li>\n	<li>Bước 5: Trang tr&iacute; bằng một l&aacute;t chanh v&agrave; thưởng thức.</li>\n</ol>\n\n<h3><em>2. Rob Roy</em></h3>\n\n<p>&nbsp;</p>\n\n<p>Theo d&ograve;ng thời gian trở ngược lại năm 1894. Rob Rob được s&aacute;ng chế bởi một thợ pha chế người New York tại Waldorf. Mục đ&iacute;ch l&agrave; để phục vụ cho c&aacute;c kh&aacute;ch mời cho m&agrave;n mở m&agrave;n của đại nhạc hội Opera. Được biểu diễn bởi huyền thoại người Scotland Robert Roy MacGregor.</p>\n\n<p><img alt=\"\" src=\"https://winemart.vn/storage/2018/07/Cocktail-Rob-Roy.jpg\" style=\"height:600px; width:600px\" /></p>\n\n<p>Cocktail Rob Roy</p>\n\n<p><strong>Nguy&ecirc;n liệu để pha chế:</strong></p>\n\n<ul>\n	<li>50ml Chivas Regal 12</li>\n	<li>12.5ml Lillet Blanc</li>\n	<li>12.5ml Lillet Rouge</li>\n	<li>Dash Angostura Bitters</li>\n</ul>\n\n<p><strong>C&aacute;ch pha chế:</strong></p>\n\n<p>Chuẩn bị vỏ cam cắt xoắn. R&oacute;t Chivas Regal 12 v&agrave;o trong ly trộn. Th&ecirc;m v&agrave;o Lillet Rouge v&agrave; Lillet Blanc. Cuối c&ugrave;ng th&ecirc;m v&agrave;o Dash Angostura Bitters v&agrave; đ&aacute; vi&ecirc;n. Quậy đều v&agrave; thưởng thức.</p>\n\n<p>Bạn c&oacute; thể thưởng thức trong ly Martini v&agrave; trang tr&iacute; bằng vỏ cam cắt xoắn.</p>', 'chivas-121590812490', 1, 0, '2020-05-30 04:21:30', '2020-05-30 08:09:53', '/images/product/1590812490.webp', 12);
INSERT INTO `products` VALUES (4, 'Bia Corona Extra 355ml', 35000, 'Sản phẩm dành cho người trên 18 tuổi và không dành cho phụ nữ mang thai. Thưởng thức có trách nhiệm, đã uống đồ uống có cồn thì không lái xe!', '<p>Sản phẩm d&agrave;nh cho người tr&ecirc;n 18 tuổi v&agrave; kh&ocirc;ng d&agrave;nh cho phụ nữ mang thai. Thưởng thức c&oacute; tr&aacute;ch nhiệm, đ&atilde; uống đồ uống c&oacute; cồn th&igrave; kh&ocirc;ng l&aacute;i xe!</p>\n\n<p>Sản phẩm d&agrave;nh cho người tr&ecirc;n 18 tuổi v&agrave; kh&ocirc;ng d&agrave;nh cho phụ nữ mang thai. Thưởng thức c&oacute; tr&aacute;ch nhiệm, đ&atilde; uống đồ uống c&oacute; cồn th&igrave; kh&ocirc;ng l&aacute;i xe!Sản phẩm d&agrave;nh cho người tr&ecirc;n 18 tuổi v&agrave; kh&ocirc;ng d&agrave;nh cho phụ nữ mang thai. Thưởng thức c&oacute; tr&aacute;ch nhiệm, đ&atilde; uống đồ uống c&oacute; cồn th&igrave; kh&ocirc;ng l&aacute;i xe!</p>', 'bia-corona-extra-355ml1590924943', 1, 0, '2020-05-31 11:35:43', '2020-05-31 11:35:49', '/images/product/1590924943.jpeg', 10);

-- ----------------------------
-- Table structure for shoppingcart
-- ----------------------------
DROP TABLE IF EXISTS `shoppingcart`;
CREATE TABLE `shoppingcart`  (
  `identifier` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `instance` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`identifier`, `instance`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for tables
-- ----------------------------
DROP TABLE IF EXISTS `tables`;
CREATE TABLE `tables`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `location` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(10) NOT NULL DEFAULT 0,
  `member` int(10) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tables
-- ----------------------------
INSERT INTO `tables` VALUES (2, 'A52', '2020-05-19 16:24:16', '2020-05-19 16:24:16', 'A', 0, 1);
INSERT INTO `tables` VALUES (3, 'A54', '2020-05-19 16:24:23', '2020-05-19 16:24:23', 'A', 0, 1);
INSERT INTO `tables` VALUES (4, 'B12', '2020-05-30 15:25:06', '2020-05-31 17:36:48', 'B', 0, 1);
INSERT INTO `tables` VALUES (5, 'B10', '2020-05-31 17:43:54', '2020-06-01 05:54:51', 'B', 0, 8);

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `avata` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '/images/userDefault.png',
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, '/images/users/userDefault.png', 'thang', '123@gmail.com', 'HN', '0909090909', '$2y$10$DAGCiRkPCP6jGpb6eX0kOuxkmaxJ/VrQDo09kGGLmKuQZP0H4o84a', 1, NULL, '2020-05-19 16:25:08', '2020-05-19 16:25:08');

-- ----------------------------
-- Table structure for waits
-- ----------------------------
DROP TABLE IF EXISTS `waits`;
CREATE TABLE `waits`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `table_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

SET FOREIGN_KEY_CHECKS = 1;
