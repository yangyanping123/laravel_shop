/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 50717
 Source Host           : localhost:3306
 Source Schema         : jwt

 Target Server Type    : MySQL
 Target Server Version : 50717
 File Encoding         : 65001

 Date: 21/06/2019 14:27:59
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for admins
-- ----------------------------
DROP TABLE IF EXISTS `admins`;
CREATE TABLE `admins`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `name` varchar(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '用户名称',
  `password` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '密码',
  `last_token` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '登陆时的token',
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '用户状态 -1代表已删除 0代表正常 1代表冻结',
  `created_at` timestamp(0) NULL DEFAULT NULL COMMENT '创建时间',
  `updated_at` timestamp(0) NULL DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of admins
-- ----------------------------
INSERT INTO `admins` VALUES (1, 'wangwu', '$2y$10$DACsXPde0cKdCx65ByQVH.uFBNibrLKdtXenl4IQ1yb8QQC44wkIW', NULL, 0, '2019-06-21 03:59:04', '2019-06-21 03:59:04');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `name` varchar(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '用户名称',
  `password` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '密码',
  `last_token` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '登陆时的token',
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '用户状态 -1代表已删除 0代表正常 1代表冻结',
  `created_at` timestamp(0) NULL DEFAULT NULL COMMENT '创建时间',
  `updated_at` timestamp(0) NULL DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, 'zhangsan', '$2y$10$izkEx9rdop3XKpWImrUX3O1lObLBvlC22Ew5mfVNTfCVwj2Zw29dO', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0L2hpc3RvcnkvcHVibGljL2FwaS92MS9sb2dpbiIsImlhdCI6MTU2MTA5NTcwOSwiZXhwIjoxNTYxMDk5MzA5LCJuYmYiOjE1NjEwOTU3MDksImp0aSI6InVjUEtOWWxqQ0RXUUZ0NHQiLCJzdWIiOjEsInBydiI6IjE0ZjE0MzRiNjUyOWFiOWM0ZTdhNzQ5ZDk4YTZjMTdlZWE4ZGQ5MDYiLCJndWFyZCI6ImFwaSJ9.Dt_KWsnBVAyzHO0JL9VP3TwJAlA1JuwZZq3NPev39ks', 0, '2019-06-21 04:07:01', '2019-06-21 05:41:49');

SET FOREIGN_KEY_CHECKS = 1;
