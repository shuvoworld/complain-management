/*
 Navicat Premium Data Transfer

 Source Server         : Localhost
 Source Server Type    : MySQL
 Source Server Version : 100406
 Source Host           : localhost:3306
 Source Schema         : complain-management

 Target Server Type    : MySQL
 Target Server Version : 100406
 File Encoding         : 65001

 Date: 31/01/2020 01:34:28
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for brand
-- ----------------------------
DROP TABLE IF EXISTS `brand`;
CREATE TABLE `brand`  (
  `brand_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `brand_name` varchar(250) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `brand_status` enum('active','inactive') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`brand_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 25 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of brand
-- ----------------------------
INSERT INTO `brand` VALUES (1, 1, 'Finibus', 'active');
INSERT INTO `brand` VALUES (2, 1, 'Lorem', 'active');
INSERT INTO `brand` VALUES (3, 1, 'Ipsum', 'active');
INSERT INTO `brand` VALUES (4, 8, 'Dolor', 'active');
INSERT INTO `brand` VALUES (5, 8, 'Amet', 'active');
INSERT INTO `brand` VALUES (6, 6, 'Aliquam', 'active');
INSERT INTO `brand` VALUES (7, 6, 'Maximus', 'active');
INSERT INTO `brand` VALUES (8, 10, 'Venenatis', 'active');
INSERT INTO `brand` VALUES (9, 10, 'Ligula', 'active');
INSERT INTO `brand` VALUES (10, 3, 'Vitae', 'active');
INSERT INTO `brand` VALUES (11, 3, 'Auctor', 'active');
INSERT INTO `brand` VALUES (12, 5, 'Luctus', 'active');
INSERT INTO `brand` VALUES (13, 5, 'Justo', 'active');
INSERT INTO `brand` VALUES (14, 2, 'Phasellus', 'active');
INSERT INTO `brand` VALUES (15, 2, 'Viverra', 'active');
INSERT INTO `brand` VALUES (16, 4, 'Elementum', 'active');
INSERT INTO `brand` VALUES (17, 4, 'Odio', 'active');
INSERT INTO `brand` VALUES (18, 7, 'Tellus', 'active');
INSERT INTO `brand` VALUES (19, 7, 'Curabitur', 'active');
INSERT INTO `brand` VALUES (20, 9, 'Commodo', 'active');
INSERT INTO `brand` VALUES (21, 9, 'Nullam', 'active');
INSERT INTO `brand` VALUES (22, 11, 'Quisques', 'active');
INSERT INTO `brand` VALUES (24, 11, 'XYZ', 'active');

-- ----------------------------
-- Table structure for category
-- ----------------------------
DROP TABLE IF EXISTS `category`;
CREATE TABLE `category`  (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(250) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `category_status` enum('active','inactive') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`category_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of category
-- ----------------------------
INSERT INTO `category` VALUES (1, 'Printer', 'active');
INSERT INTO `category` VALUES (2, 'Scanner', 'active');
INSERT INTO `category` VALUES (3, 'Desktop', 'active');
INSERT INTO `category` VALUES (4, 'Laptop', 'active');
INSERT INTO `category` VALUES (5, 'Internet and Cable', 'active');

-- ----------------------------
-- Table structure for client
-- ----------------------------
DROP TABLE IF EXISTS `client`;
CREATE TABLE `client`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `status` enum('active','inactive') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of client
-- ----------------------------
INSERT INTO `client` VALUES (1, 'Ministry of Home Affairs', 'active');

-- ----------------------------
-- Table structure for complain
-- ----------------------------
DROP TABLE IF EXISTS `complain`;
CREATE TABLE `complain`  (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `category_id` int(10) NULL DEFAULT NULL,
  `category_name` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `subject` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `contact_no` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `user_id` int(20) NULL DEFAULT NULL,
  `employee_id` int(20) NULL DEFAULT NULL,
  `status` enum('','Pending','Solved') CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `created_at` datetime(0) NULL DEFAULT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of complain
-- ----------------------------
INSERT INTO `complain` VALUES (2, 5, 'Internet and Cable', 'Speed low', 'My speed is very low', '01675000148', 1, 2, 'Pending', '2019-12-25 05:40:17', '2020-01-04 15:31:42');
INSERT INTO `complain` VALUES (3, 2, 'Scanner', 'Speed low', '', '252525252', 1, 1, 'Pending', '2020-01-02 20:24:54', '2020-01-03 08:20:58');
INSERT INTO `complain` VALUES (4, 1, 'Printer', 'sdsd', 'sdsd', '232323', 1, 2, 'Pending', '2020-01-02 20:30:30', '2020-01-04 15:31:36');
INSERT INTO `complain` VALUES (5, 4, 'Laptop', 'sasas', 'dfdfd', '343434', 1, 1, 'Pending', '2020-01-02 20:32:44', '2020-01-26 09:48:59');
INSERT INTO `complain` VALUES (6, 5, 'Internet and Cable', 'sdsdsd', 'sds', '11111111111', 1, 2, 'Solved', '2020-01-04 14:35:49', '2020-01-26 09:35:16');
INSERT INTO `complain` VALUES (9, 3, 'Desktop', 'dfdf', 'dfdfd', '455656565', 3, NULL, 'Pending', '2020-01-26 11:28:59', '2020-01-26 11:28:59');
INSERT INTO `complain` VALUES (10, 2, 'Scanner', 'fgfgfgf', 'dfdf5fgfg', '5555555555', 3, NULL, 'Pending', '2020-01-26 11:31:12', '2020-01-26 11:31:12');

-- ----------------------------
-- Table structure for employee
-- ----------------------------
DROP TABLE IF EXISTS `employee`;
CREATE TABLE `employee`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `contact_no` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `email` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `department_id` int(10) NULL DEFAULT NULL,
  `status` enum('engaged','free','inactive') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of employee
-- ----------------------------
INSERT INTO `employee` VALUES (1, 'Rashed', '01400664953', 'rashed@support.com', NULL, 'free');
INSERT INTO `employee` VALUES (2, 'Habib', '0126653235', 'habib@gmail.com', NULL, 'free');

-- ----------------------------
-- Table structure for user_details
-- ----------------------------
DROP TABLE IF EXISTS `user_details`;
CREATE TABLE `user_details`  (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_email` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `user_password` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `user_name` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `user_type_id` int(11) NULL DEFAULT NULL,
  `user_type` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `user_status` enum('Active','Inactive') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `user_phone` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `client_id` int(10) NULL DEFAULT NULL,
  `client_name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `employee_id` int(10) NULL DEFAULT NULL,
  `employee_name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`user_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of user_details
-- ----------------------------
INSERT INTO `user_details` VALUES (1, 'admin@gmail.com', '$2y$10$0Yo2F.EetL3yhB8l6MNvcOH8AYNS0SuXLOoAQr1qXJa3uPASWV0NC', 'Admin', 1, 'master', 'Active', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `user_details` VALUES (2, 'employee@gmail.com', '$2y$10$0Yo2F.EetL3yhB8l6MNvcOH8AYNS0SuXLOoAQr1qXJa3uPASWV0NC', 'Employee', 2, 'employee', 'Active', NULL, NULL, NULL, 1, 'Rashed', NULL);
INSERT INTO `user_details` VALUES (3, 'user@gmail.com', '$2y$10$0Yo2F.EetL3yhB8l6MNvcOH8AYNS0SuXLOoAQr1qXJa3uPASWV0NC', 'User', 3, 'user', 'Active', NULL, 1, 'Ministry of Home Affairs', NULL, NULL, NULL);

-- ----------------------------
-- Table structure for user_types
-- ----------------------------
DROP TABLE IF EXISTS `user_types`;
CREATE TABLE `user_types`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of user_types
-- ----------------------------
INSERT INTO `user_types` VALUES (1, 'master');
INSERT INTO `user_types` VALUES (2, 'employee');
INSERT INTO `user_types` VALUES (3, 'user');

SET FOREIGN_KEY_CHECKS = 1;
