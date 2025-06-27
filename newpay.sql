/*
 Navicat MySQL Data Transfer

 Source Server         : 165.154.229.207
 Source Server Type    : MySQL
 Source Server Version : 50744
 Source Host           : 165.154.229.207:3306
 Source Schema         : newpay

 Target Server Type    : MySQL
 Target Server Version : 50744
 File Encoding         : 65001

 Date: 28/06/2025 02:55:47
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for attachment
-- ----------------------------
DROP TABLE IF EXISTS `attachment`;
CREATE TABLE `attachment`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '文件信息ID',
  `storage_mode` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'local' COMMENT '存储模式:local=本地,oss=阿里云,qiniu=七牛云,cos=腾讯云',
  `origin_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '原文件名',
  `object_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '新文件名',
  `hash` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '文件hash',
  `mime_type` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT 'MIME类型',
  `storage_path` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL COMMENT '存储路径',
  `base_path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '基础存储路径',
  `suffix` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '文件扩展名',
  `url` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '文件访问地址',
  `size_byte` bigint(20) NULL DEFAULT NULL COMMENT '文件大小，单位字节',
  `size_info` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '文件大小，有单位',
  `remark` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL COMMENT '附加属性备注',
  `created_at` datetime NULL DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime NULL DEFAULT NULL COMMENT '更新时间',
  `created_by` bigint(20) NULL DEFAULT NULL COMMENT '创建用户',
  `updated_by` bigint(20) NULL DEFAULT 0 COMMENT '更新用户',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 21 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = '上传文件信息表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of attachment
-- ----------------------------
INSERT INTO `attachment` VALUES (1, 'local', 'dsfsdfsd', 'dddd', NULL, NULL, NULL, '', NULL, 'ddd', NULL, NULL, NULL, NULL, NULL, NULL, 0);
INSERT INTO `attachment` VALUES (2, 'local', 'bg1.png', '5fd6828a9b2ebd70c162ec2707791dd2.png', '5fd6828a9b2ebd70c162ec2707791dd2', 'image/png', '/upload/5fd6828a9b2ebd70c162ec2707791dd2.png', '/upload/5fd6828a9b2ebd70c162ec2707791dd2.png', 'png', 'http://127.0.0.1:9501/upload/5fd6828a9b2ebd70c162ec2707791dd2.png', 4721405, '4.5 MB', NULL, '2025-06-11 19:23:28', '2025-06-11 19:23:28', NULL, 0);
INSERT INTO `attachment` VALUES (3, 'local', '微信图片_20231208210744.jpg', 'c9f0129e4429f63e3b9e0a5da07a48ad.jpg', 'c9f0129e4429f63e3b9e0a5da07a48ad', 'image/jpeg', '/data/project/byapay/newpay/public/upload/c9f0129e4429f63e3b9e0a5da07a48ad.jpg', '/upload/c9f0129e4429f63e3b9e0a5da07a48ad.jpg', 'jpg', 'http://127.0.0.1:8899/upload/c9f0129e4429f63e3b9e0a5da07a48ad.jpg', 660521, '645.04 KB', NULL, '2025-06-11 19:30:25', '2025-06-11 19:30:25', NULL, 0);
INSERT INTO `attachment` VALUES (4, 'local', 'bg.png', '57f0e5984eb485d460e4ee7a3c381096.png', '57f0e5984eb485d460e4ee7a3c381096', 'image/png', '/data/project/byapay/newpay/public/upload/57f0e5984eb485d460e4ee7a3c381096.png', '/upload/57f0e5984eb485d460e4ee7a3c381096.png', 'png', 'http://127.0.0.1:9501/upload/57f0e5984eb485d460e4ee7a3c381096.png', 4195473, '4 MB', NULL, '2025-06-11 19:33:52', '2025-06-11 19:33:52', NULL, 0);
INSERT INTO `attachment` VALUES (5, 'local', 'ca1349540923dd54e0eaaccf24ba0adb9d824831.jpeg', '03f2c3108d6d9f48e64d13f4d92ea209.jpeg', '03f2c3108d6d9f48e64d13f4d92ea209', 'image/jpeg', '/data/project/byapay/newpay/public/upload/03f2c3108d6d9f48e64d13f4d92ea209.jpeg', '/upload/03f2c3108d6d9f48e64d13f4d92ea209.jpeg', 'jpeg', 'http://127.0.0.1:9501/upload/03f2c3108d6d9f48e64d13f4d92ea209.jpeg', 39310, '38.39 KB', NULL, '2025-06-17 08:30:07', '2025-06-17 08:30:07', NULL, 0);
INSERT INTO `attachment` VALUES (6, 'local', 'ChMkK2VuiYOIAt4fAADe7KV_wZgAAX6mQLS-ysAAN8E319.jpg', '473a077cb76edab1d3525751ec25d236.jpg', '473a077cb76edab1d3525751ec25d236', 'image/jpeg', '/data/project/byapay/newpay/public/upload/473a077cb76edab1d3525751ec25d236.jpg', '/upload/473a077cb76edab1d3525751ec25d236.jpg', 'jpg', 'http://127.0.0.1:9501/upload/473a077cb76edab1d3525751ec25d236.jpg', 37963, '37.07 KB', NULL, '2025-06-17 08:30:33', '2025-06-17 08:30:33', NULL, 0);
INSERT INTO `attachment` VALUES (7, 'local', 'ChMkK2VuiYOIAt4fAADe7KV_wZgAAX6mQLS-ysAAN8E319.jpg', '473a077cb76edab1d3525751ec25d236.jpg', '473a077cb76edab1d3525751ec25d236', 'image/jpeg', '/data/project/byapay/newpay/public/upload/473a077cb76edab1d3525751ec25d236.jpg', '/upload/473a077cb76edab1d3525751ec25d236.jpg', 'jpg', 'http://127.0.0.1:9501/upload/473a077cb76edab1d3525751ec25d236.jpg', 37963, '37.07 KB', NULL, '2025-06-17 08:30:45', '2025-06-17 08:30:45', NULL, 0);
INSERT INTO `attachment` VALUES (8, 'local', 'e931da44bf3132d76ce2cf1659b73a885e8930f0.jpg', '5b39c23f91a54676f01507664031a6b0.jpg', '5b39c23f91a54676f01507664031a6b0', 'image/jpeg', '/data/project/byapay/newpay/public/upload/5b39c23f91a54676f01507664031a6b0.jpg', '/upload/5b39c23f91a54676f01507664031a6b0.jpg', 'jpg', 'http://127.0.0.1:9501/upload/5b39c23f91a54676f01507664031a6b0.jpg', 198416, '193.77 KB', NULL, '2025-06-17 08:31:42', '2025-06-17 08:31:42', NULL, 0);
INSERT INTO `attachment` VALUES (9, 'local', '503d269759ee3d6d44bb596fd79ac9244e4adeac.jpeg', '54832c49bb0b7211be78de3699948702.jpeg', '54832c49bb0b7211be78de3699948702', 'image/jpeg', '/data/project/byapay/newpay/public/upload/54832c49bb0b7211be78de3699948702.jpeg', '/upload/54832c49bb0b7211be78de3699948702.jpeg', 'jpeg', 'http://127.0.0.1:9501/upload/54832c49bb0b7211be78de3699948702.jpeg', 19420, '18.96 KB', NULL, '2025-06-17 15:41:50', '2025-06-17 15:41:50', NULL, 0);
INSERT INTO `attachment` VALUES (10, 'local', 'e931da44bf3132d76ce2cf1659b73a885e8930f0.jpg', '5b39c23f91a54676f01507664031a6b0.jpg', '5b39c23f91a54676f01507664031a6b0', 'image/jpeg', '/data/project/byapay/newpay/public/upload/5b39c23f91a54676f01507664031a6b0.jpg', '/upload/5b39c23f91a54676f01507664031a6b0.jpg', 'jpg', 'http://127.0.0.1:9501/upload/5b39c23f91a54676f01507664031a6b0.jpg', 198416, '193.77 KB', NULL, '2025-06-17 15:42:49', '2025-06-17 15:42:49', NULL, 0);
INSERT INTO `attachment` VALUES (11, 'local', 'ca1349540923dd54e0eaaccf24ba0adb9d824831.jpeg', '03f2c3108d6d9f48e64d13f4d92ea209.jpeg', '03f2c3108d6d9f48e64d13f4d92ea209', 'image/jpeg', '/data/project/byapay/newpay/public/upload/03f2c3108d6d9f48e64d13f4d92ea209.jpeg', '/upload/03f2c3108d6d9f48e64d13f4d92ea209.jpeg', 'jpeg', 'http://127.0.0.1:9501/upload/03f2c3108d6d9f48e64d13f4d92ea209.jpeg', 39310, '38.39 KB', NULL, '2025-06-17 15:50:10', '2025-06-17 15:50:10', NULL, 0);
INSERT INTO `attachment` VALUES (12, 'local', 'R-C.jpg', 'c9f0129e4429f63e3b9e0a5da07a48ad.jpg', 'c9f0129e4429f63e3b9e0a5da07a48ad', 'image/jpeg', '/data/project/byapay/newpay/public/upload/c9f0129e4429f63e3b9e0a5da07a48ad.jpg', '/upload/c9f0129e4429f63e3b9e0a5da07a48ad.jpg', 'jpg', 'http://127.0.0.1:9501/upload/c9f0129e4429f63e3b9e0a5da07a48ad.jpg', 660521, '645.04 KB', NULL, '2025-06-17 15:52:25', '2025-06-17 15:52:25', NULL, 0);
INSERT INTO `attachment` VALUES (13, 'local', '060828381f30e9244d0cd00a0e3905031d95f71c.jpeg', 'dd942666582b70fb29b5b57aa8d00c82.jpeg', 'dd942666582b70fb29b5b57aa8d00c82', 'image/jpeg', '/data/project/byapay/newpay/public/upload/dd942666582b70fb29b5b57aa8d00c82.jpeg', '/upload/dd942666582b70fb29b5b57aa8d00c82.jpeg', 'jpeg', 'http://127.0.0.1:9501/upload/dd942666582b70fb29b5b57aa8d00c82.jpeg', 55076, '53.79 KB', NULL, '2025-06-17 15:53:38', '2025-06-17 15:53:38', NULL, 0);
INSERT INTO `attachment` VALUES (14, 'local', '1496310615-7581415540694987.jpg', 'ffda6f9ea824b07d64cf074d25232acf.jpg', 'ffda6f9ea824b07d64cf074d25232acf', 'image/jpeg', '/data/project/byapay/newpay/public/upload/ffda6f9ea824b07d64cf074d25232acf.jpg', '/upload/ffda6f9ea824b07d64cf074d25232acf.jpg', 'jpg', 'http://127.0.0.1:9501/upload/ffda6f9ea824b07d64cf074d25232acf.jpg', 49671, '48.51 KB', NULL, '2025-06-17 15:55:22', '2025-06-17 15:55:22', NULL, 0);
INSERT INTO `attachment` VALUES (15, 'local', 'wuhuarou.webp', '362234e233ddf148079b2f7f738cc986.webp', '362234e233ddf148079b2f7f738cc986', 'image/webp', '/data/project/byapay/newpay/public/upload/362234e233ddf148079b2f7f738cc986.webp', '/upload/362234e233ddf148079b2f7f738cc986.webp', 'webp', 'http://127.0.0.1:9501/upload/362234e233ddf148079b2f7f738cc986.webp', 24120, '23.55 KB', NULL, '2025-06-17 15:57:07', '2025-06-17 15:57:07', NULL, 0);
INSERT INTO `attachment` VALUES (16, 'local', '503d269759ee3d6d44bb596fd79ac9244e4adeac.jpeg', '54832c49bb0b7211be78de3699948702.jpeg', '54832c49bb0b7211be78de3699948702', 'image/jpeg', '/data/project/byapay/newpay/public/upload/54832c49bb0b7211be78de3699948702.jpeg', '/upload/54832c49bb0b7211be78de3699948702.jpeg', 'jpeg', 'http://127.0.0.1:9501/upload/54832c49bb0b7211be78de3699948702.jpeg', 19420, '18.96 KB', NULL, '2025-06-17 15:59:26', '2025-06-17 15:59:26', NULL, 0);
INSERT INTO `attachment` VALUES (17, 'local', 'ChMkK2VuiYOIAt4fAADe7KV_wZgAAX6mQLS-ysAAN8E319.jpg', '473a077cb76edab1d3525751ec25d236.jpg', '473a077cb76edab1d3525751ec25d236', 'image/jpeg', '/data/project/byapay/newpay/public/upload/473a077cb76edab1d3525751ec25d236.jpg', '/upload/473a077cb76edab1d3525751ec25d236.jpg', 'jpg', 'http://127.0.0.1:9501/upload/473a077cb76edab1d3525751ec25d236.jpg', 37963, '37.07 KB', NULL, '2025-06-17 15:59:43', '2025-06-17 15:59:43', NULL, 0);
INSERT INTO `attachment` VALUES (18, 'local', 'rw_1.png', 'c7500dd23143ecfe03cd700d4c685231.png', 'c7500dd23143ecfe03cd700d4c685231', 'image/png', '/opt/www/public/upload/c7500dd23143ecfe03cd700d4c685231.png', '/upload/c7500dd23143ecfe03cd700d4c685231.png', 'png', 'http://127.0.0.1:9501/upload/c7500dd23143ecfe03cd700d4c685231.png', 44631, '43.58 KB', NULL, '2025-06-21 08:57:52', '2025-06-21 08:57:52', NULL, 0);
INSERT INTO `attachment` VALUES (19, 'local', 'zhu.png', '4a2a2bbef37178f660ba8c7f6c8ed7f0.png', '4a2a2bbef37178f660ba8c7f6c8ed7f0', 'image/png', '/opt/www/public/upload/4a2a2bbef37178f660ba8c7f6c8ed7f0.png', '/upload/4a2a2bbef37178f660ba8c7f6c8ed7f0.png', 'png', 'http://127.0.0.1:9501/upload/4a2a2bbef37178f660ba8c7f6c8ed7f0.png', 250460, '244.59 KB', NULL, '2025-06-21 09:01:15', '2025-06-21 09:01:15', NULL, 0);
INSERT INTO `attachment` VALUES (20, 'local', 'Loading1.png', '7a8d99685b2b0b1ab94afd4926138211.png', '7a8d99685b2b0b1ab94afd4926138211', 'image/png', '/opt/www/public/upload/7a8d99685b2b0b1ab94afd4926138211.png', '/upload/7a8d99685b2b0b1ab94afd4926138211.png', 'png', 'https://server.bug.it.com/upload/7a8d99685b2b0b1ab94afd4926138211.png', 1367874, '1.3 MB', NULL, '2025-06-21 09:05:08', '2025-06-21 09:05:08', NULL, 0);

-- ----------------------------
-- Table structure for callback_queue
-- ----------------------------
DROP TABLE IF EXISTS `callback_queue`;
CREATE TABLE `callback_queue`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `callback_id` bigint(20) UNSIGNED NOT NULL COMMENT '回调记录ID',
  `execute_status` tinyint(2) NOT NULL DEFAULT 0 COMMENT '执行状态:\r\n    0-待执行 1-执行中 2-成功 3-失败',
  `execute_count` tinyint(4) NOT NULL DEFAULT 0 COMMENT '执行次数',
  `next_execute_time` datetime NOT NULL COMMENT '下次执行时间',
  `last_execute_time` datetime NULL DEFAULT NULL COMMENT '最后执行时间',
  `error_message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '错误信息',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `uniq_callback_id`(`callback_id`) USING BTREE,
  INDEX `idx_status_time`(`execute_status`, `next_execute_time`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '回调队列执行状态表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of callback_queue
-- ----------------------------

-- ----------------------------
-- Table structure for callback_record
-- ----------------------------
DROP TABLE IF EXISTS `callback_record`;
CREATE TABLE `callback_record`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue_id` bigint(20) UNSIGNED NULL DEFAULT NULL COMMENT '队列ID',
  `tenant_id` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '租户编号',
  `app_id` bigint(20) NOT NULL COMMENT '应用ID',
  `order_id` bigint(20) UNSIGNED NOT NULL COMMENT '订单ID',
  `callback_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '回调地址',
  `callback_type` tinyint(2) NOT NULL COMMENT '回调类型:1-支付结果 2-退款结果 3-账单通知',
  `request_data` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '请求数据',
  `response_status` int(11) NULL DEFAULT NULL COMMENT '响应状态码',
  `response_data` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '响应数据',
  `retry_count` smallint(6) NOT NULL DEFAULT 0 COMMENT '重试次数',
  `next_retry_time` datetime NULL DEFAULT NULL COMMENT '下次重试时间',
  `callback_status` tinyint(2) NOT NULL DEFAULT 0 COMMENT '回调状态:0-待回调 1-成功 2-失败 3-重试中',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_tenant_order`(`tenant_id`, `order_id`) USING BTREE,
  INDEX `idx_retry_time`(`next_retry_time`) USING BTREE,
  INDEX `idx_status`(`callback_status`) USING BTREE,
  INDEX `idx_queue_id`(`queue_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '回调记录表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of callback_record
-- ----------------------------

-- ----------------------------
-- Table structure for collection_order
-- ----------------------------
DROP TABLE IF EXISTS `collection_order`;
CREATE TABLE `collection_order`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `platform_order_no` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '平台订单号',
  `merchant_order_no` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '下游订单号',
  `upstream_order_no` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '上游订单号',
  `amount` decimal(12, 4) NOT NULL COMMENT '订单金额',
  `payable_amount` decimal(12, 4) NOT NULL COMMENT '订单应付金额',
  `paid_amount` decimal(12, 4) NULL DEFAULT NULL COMMENT '订单实付金额',
  `fixed_fee` decimal(12, 4) NOT NULL DEFAULT 0.0000 COMMENT '固定手续费',
  `rate_fee` decimal(12, 4) NOT NULL DEFAULT 0.0000 COMMENT '费率手续费',
  `total_fee` decimal(12, 4) GENERATED ALWAYS AS ((`fixed_fee` + `rate_fee`)) STORED COMMENT '总手续费' NULL,
  `upstream_fee` decimal(12, 4) NULL DEFAULT NULL COMMENT '上游手续费',
  `upstream_settlement_amount` decimal(12, 4) NULL DEFAULT NULL COMMENT '上游结算金额',
  `settlement_amount` decimal(12, 4) NULL DEFAULT NULL COMMENT '租户入账金额',
  `settlement_type` tinyint(1) NOT NULL DEFAULT 0 COMMENT '入账结算类型:0-未入账 1-实付金额 2-订单金额',
  `collection_type` tinyint(2) NOT NULL COMMENT '收款类型:1-银行卡 2-UPI 3-第三方支付',
  `collection_channel_id` bigint(20) UNSIGNED NULL DEFAULT NULL COMMENT '收款渠道ID',
  `pay_time` datetime NULL DEFAULT NULL COMMENT '支付时间',
  `expire_time` datetime NULL DEFAULT NULL COMMENT '订单失效时间',
  `order_source` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '订单来源:APP-API 管理后台 导入',
  `recon_type` tinyint(2) NOT NULL DEFAULT 0 COMMENT '核销类型:\r\n    0-未核销 \r\n    1-自动核销 \r\n    2-人工核销 \r\n    3-接口核销 \r\n    4-机器人核销',
  `callback_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '回调地址',
  `callback_count` smallint(6) NOT NULL DEFAULT 0 COMMENT '回调次数',
  `notify_status` tinyint(2) NOT NULL DEFAULT 0 COMMENT '通知状态:0-未通知 1-通知成功 2-通知失败 3-回调中',
  `checkout_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '收银台地址',
  `return_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '支付成功后跳转地址',
  `tenant_id` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '租户编号',
  `app_id` bigint(20) NOT NULL COMMENT '应用ID',
  `payer_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '付款方名称',
  `payer_account` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '付款账号',
  `payer_bank` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '付款方银行',
  `payer_ifsc` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '付款方IFSC代码',
  `payer_upi` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '付款方UPI账号',
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '订单描述',
  `status` tinyint(2) NOT NULL DEFAULT 0 COMMENT '订单状态:\r\n    0-创建 10-处理中 20-成功 30-挂起 40-失败 \r\n    41-已取消 43-已失效 44-已退款 ',
  `channel_transaction_no` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '渠道交易号',
  `error_code` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '错误代码',
  `error_message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '错误信息',
  `request_id` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '关联API请求ID',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `uniq_platform_order_no`(`platform_order_no`) USING BTREE,
  UNIQUE INDEX `uniq_merchant_order`(`tenant_id`, `merchant_order_no`) USING BTREE,
  UNIQUE INDEX `uniq_request_id`(`request_id`) USING BTREE COMMENT '防止重复订单',
  INDEX `idx_tenant_app`(`tenant_id`, `app_id`) USING BTREE,
  INDEX `idx_status_expire`(`status`, `expire_time`) USING BTREE,
  INDEX `idx_payer_account`(`payer_account`) USING BTREE,
  INDEX `idx_created_at`(`created_at`) USING BTREE,
  INDEX `idx_pay_time`(`pay_time`) USING BTREE COMMENT '支付时间索引',
  INDEX `idx_recon_type`(`recon_type`) USING BTREE COMMENT '核销类型索引'
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '代收订单表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of collection_order
-- ----------------------------

-- ----------------------------
-- Table structure for collection_order_queue
-- ----------------------------
DROP TABLE IF EXISTS `collection_order_queue`;
CREATE TABLE `collection_order_queue`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `request_id` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '请求ID',
  `order_data` json NOT NULL COMMENT '订单数据',
  `process_status` tinyint(2) NOT NULL DEFAULT 0 COMMENT '处理状态:\r\n    0-待处理 1-处理中 2-成功 3-失败',
  `retry_count` tinyint(4) NOT NULL DEFAULT 0 COMMENT '重试次数',
  `next_retry_time` datetime NULL DEFAULT NULL COMMENT '下次重试时间',
  `error_message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '错误信息',
  `created_at` datetime NOT NULL,
  `processed_at` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `uniq_request_id`(`request_id`) USING BTREE,
  INDEX `idx_status_retry`(`process_status`, `next_retry_time`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '代收订单核销处理队列' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of collection_order_queue
-- ----------------------------

-- ----------------------------
-- Table structure for data_permission_policy
-- ----------------------------
DROP TABLE IF EXISTS `data_permission_policy`;
CREATE TABLE `data_permission_policy`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL DEFAULT 0 COMMENT '用户ID（与角色二选一）',
  `position_id` bigint(20) NOT NULL DEFAULT 0 COMMENT '岗位ID（与用户二选一）',
  `policy_type` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '策略类型（DEPT_SELF, DEPT_TREE, ALL, SELF, CUSTOM_DEPT, CUSTOM_FUNC）',
  `is_default` tinyint(1) NOT NULL DEFAULT 1 COMMENT '是否默认策略（默认值：true）',
  `value` json NULL COMMENT '策略值',
  `created_at` datetime NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = '数据权限策略' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of data_permission_policy
-- ----------------------------

-- ----------------------------
-- Table structure for department
-- ----------------------------
DROP TABLE IF EXISTS `department`;
CREATE TABLE `department`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '部门名称',
  `parent_id` bigint(20) NOT NULL DEFAULT 0 COMMENT '父级部门ID',
  `created_at` datetime NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = '部门表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of department
-- ----------------------------
INSERT INTO `department` VALUES (1, '运营部门', 0, '2025-06-11 18:23:32', '2025-06-11 18:23:32', NULL);
INSERT INTO `department` VALUES (2, '运营部门1', 0, '2025-06-11 18:25:17', '2025-06-11 18:25:17', NULL);
INSERT INTO `department` VALUES (3, '运营1', 1, '2025-06-26 07:09:49', '2025-06-26 07:09:49', NULL);

-- ----------------------------
-- Table structure for dept_leader
-- ----------------------------
DROP TABLE IF EXISTS `dept_leader`;
CREATE TABLE `dept_leader`  (
  `dept_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `created_at` datetime NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = '部门领导表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of dept_leader
-- ----------------------------

-- ----------------------------
-- Table structure for disbursement_order
-- ----------------------------
DROP TABLE IF EXISTS `disbursement_order`;
CREATE TABLE `disbursement_order`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `platform_order_no` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '平台订单号',
  `merchant_order_no` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '下游订单号',
  `upstream_order_no` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '上游订单号',
  `pay_time` datetime NULL DEFAULT NULL COMMENT '支付时间',
  `order_source` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '订单来源:App-API 管理后台 导入',
  `disbursement_channel_id` bigint(20) UNSIGNED NULL DEFAULT NULL COMMENT '代付渠道D',
  `disbursement_bank_id` bigint(20) UNSIGNED NULL DEFAULT NULL COMMENT '代付银行卡ID',
  `amount` decimal(12, 4) NOT NULL COMMENT '订单金额',
  `paid_amount` decimal(12, 4) NULL DEFAULT NULL COMMENT '订单实付金额',
  `fixed_fee` decimal(12, 4) NOT NULL DEFAULT 0.0000 COMMENT '固定手续费',
  `rate_fee` decimal(12, 4) NOT NULL DEFAULT 0.0000 COMMENT '费率手续费',
  `total_fee` decimal(12, 4) GENERATED ALWAYS AS ((`fixed_fee` + `rate_fee`)) STORED COMMENT '总手续费' NULL,
  `settlement_amount` decimal(12, 4) NULL DEFAULT NULL COMMENT '租户入账金额',
  `upstream_fee` decimal(12, 4) NULL DEFAULT NULL COMMENT '上游手续费',
  `upstream_settlement_amount` decimal(12, 4) NULL DEFAULT NULL COMMENT '上游结算金额',
  `payment_type` tinyint(2) NOT NULL COMMENT '付款类型:1-银行卡 2-UPI',
  `payee_bank_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '收款人银行名称',
  `payee_bank_code` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '收款人银行编码',
  `payee_account_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '收款人账户姓名',
  `payee_account_no` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '收款人银行卡号',
  `payee_upi` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '收款人UPI账号',
  `pre_utr` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '预订交易的凭证/UTR',
  `final_utr` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '实际交易的凭证/UTR',
  `tenant_id` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '租户编号',
  `app_id` bigint(20) NOT NULL COMMENT '应用ID',
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '订单描述',
  `status` tinyint(2) NOT NULL DEFAULT 0 COMMENT '订单状态:\r\n    0-创建 10-待支付 11-待回填 20-成功 30-挂起 \r\n    40-失败 41-已取消 43-已失效 44-已退款',
  `expire_time` datetime NULL DEFAULT NULL COMMENT '订单失效时间',
  `callback_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '回调地址',
  `callback_count` smallint(6) NOT NULL DEFAULT 0 COMMENT '回调次数',
  `notify_status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '通知状态:0-未通知 1-通知成功 2-通知失败 3-回调中',
  `channel_transaction_no` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '渠道交易号',
  `error_code` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '错误代码',
  `error_message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '错误信息',
  `request_id` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '关联API请求ID',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `uniq_platform_order_no`(`platform_order_no`) USING BTREE,
  UNIQUE INDEX `uniq_merchant_order`(`tenant_id`, `merchant_order_no`) USING BTREE,
  UNIQUE INDEX `uniq_request_id`(`request_id`) USING BTREE COMMENT '防止重复订单',
  INDEX `idx_tenant_app`(`tenant_id`, `app_id`) USING BTREE,
  INDEX `idx_status_expire`(`status`, `expire_time`) USING BTREE,
  INDEX `idx_payee_account`(`payee_account_no`) USING BTREE,
  INDEX `idx_utr`(`final_utr`) USING BTREE COMMENT 'UTR索引',
  INDEX `idx_created_at`(`created_at`) USING BTREE,
  INDEX `idx_pay_time`(`pay_time`) USING BTREE COMMENT '支付时间索引'
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '代付订单表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of disbursement_order
-- ----------------------------

-- ----------------------------
-- Table structure for disbursement_order_queue
-- ----------------------------
DROP TABLE IF EXISTS `disbursement_order_queue`;
CREATE TABLE `disbursement_order_queue`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `request_id` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '请求ID',
  `order_data` json NOT NULL COMMENT '订单数据',
  `process_status` tinyint(2) NOT NULL DEFAULT 0 COMMENT '处理状态:\r\n    0-待处理 1-处理中 2-成功 3-失败',
  `retry_count` tinyint(4) NOT NULL DEFAULT 0 COMMENT '重试次数',
  `next_retry_time` datetime NULL DEFAULT NULL COMMENT '下次重试时间',
  `error_message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '错误信息',
  `created_at` datetime NOT NULL,
  `processed_at` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `uniq_request_id`(`request_id`) USING BTREE,
  INDEX `idx_status_retry`(`process_status`, `next_retry_time`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '代付订单核销处理队列' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of disbursement_order_queue
-- ----------------------------

-- ----------------------------
-- Table structure for menu
-- ----------------------------
DROP TABLE IF EXISTS `menu`;
CREATE TABLE `menu`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键',
  `parent_id` bigint(20) UNSIGNED NOT NULL COMMENT '父ID',
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '菜单名称',
  `meta` json NULL COMMENT '附加属性',
  `path` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '路径',
  `component` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '组件路径',
  `redirect` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '重定向地址',
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '状态:1=正常,2=停用',
  `sort` smallint(6) NOT NULL DEFAULT 0 COMMENT '排序',
  `created_by` bigint(20) NOT NULL DEFAULT 0 COMMENT '创建者',
  `updated_by` bigint(20) NOT NULL DEFAULT 0 COMMENT '更新者',
  `created_at` datetime NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  `remark` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '备注',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `menu_name_unique`(`name`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 83 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = '菜单信息表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of menu
-- ----------------------------
INSERT INTO `menu` VALUES (1, 0, 'permission', '{\"i18n\": \"baseMenu.permission.index\", \"icon\": \"ri:git-repository-private-line\", \"type\": \"M\", \"affix\": false, \"cache\": true, \"title\": \"权限管理\", \"hidden\": false, \"copyright\": true, \"componentPath\": \"modules/\", \"componentSuffix\": \".vue\", \"breadcrumbEnable\": true}', '/permission', '', '', 1, 0, 0, 0, '2025-06-05 05:30:30', '2025-06-05 05:30:30', '');
INSERT INTO `menu` VALUES (2, 1, 'permission:user', '{\"i18n\": \"baseMenu.permission.user\", \"icon\": \"material-symbols:manage-accounts-outline\", \"type\": \"M\", \"affix\": false, \"cache\": true, \"title\": \"用户管理\", \"hidden\": false, \"copyright\": true, \"componentPath\": \"modules/\", \"componentSuffix\": \".vue\", \"breadcrumbEnable\": true}', '/permission/user', 'base/views/permission/user/index', '', 1, 0, 0, 0, '2025-06-05 05:30:31', '2025-06-05 05:30:31', '');
INSERT INTO `menu` VALUES (3, 2, 'permission:user:index', '{\"i18n\": \"baseMenu.permission.userList\", \"type\": \"B\", \"title\": \"用户列表\"}', '', '', '', 1, 0, 0, 0, '2025-06-05 05:30:31', '2025-06-05 05:30:31', '');
INSERT INTO `menu` VALUES (4, 2, 'permission:user:save', '{\"i18n\": \"baseMenu.permission.userSave\", \"type\": \"B\", \"title\": \"用户保存\"}', '', '', '', 1, 0, 0, 0, '2025-06-05 05:30:31', '2025-06-05 05:30:31', '');
INSERT INTO `menu` VALUES (5, 2, 'permission:user:update', '{\"i18n\": \"baseMenu.permission.userUpdate\", \"type\": \"B\", \"title\": \"用户更新\"}', '', '', '', 1, 0, 0, 0, '2025-06-05 05:30:31', '2025-06-05 05:30:31', '');
INSERT INTO `menu` VALUES (6, 2, 'permission:user:delete', '{\"i18n\": \"baseMenu.permission.userDelete\", \"type\": \"B\", \"title\": \"用户删除\"}', '', '', '', 1, 0, 0, 0, '2025-06-05 05:30:31', '2025-06-05 05:30:31', '');
INSERT INTO `menu` VALUES (7, 2, 'permission:user:password', '{\"i18n\": \"baseMenu.permission.userPassword\", \"type\": \"B\", \"title\": \"用户初始化密码\"}', '', '', '', 1, 0, 0, 0, '2025-06-05 05:30:31', '2025-06-05 05:30:31', '');
INSERT INTO `menu` VALUES (8, 2, 'permission:user:getRole', '{\"i18n\": \"baseMenu.permission.getUserRole\", \"type\": \"B\", \"title\": \"获取用户角色\"}', '', '', '', 1, 0, 0, 0, '2025-06-05 05:30:32', '2025-06-05 05:30:37', '');
INSERT INTO `menu` VALUES (9, 2, 'permission:user:setRole', '{\"i18n\": \"baseMenu.permission.setUserRole\", \"type\": \"B\", \"title\": \"用户角色赋予\"}', '', '', '', 1, 0, 0, 0, '2025-06-05 05:30:32', '2025-06-05 05:30:37', '');
INSERT INTO `menu` VALUES (10, 1, 'permission:menu', '{\"i18n\": \"baseMenu.permission.menu\", \"icon\": \"ph:list-bold\", \"type\": \"M\", \"affix\": false, \"cache\": true, \"title\": \"菜单管理\", \"hidden\": false, \"copyright\": true, \"componentPath\": \"modules/\", \"componentSuffix\": \".vue\", \"breadcrumbEnable\": true}', '/permission/menu', 'base/views/permission/menu/index', '', 1, 0, 0, 0, '2025-06-05 05:30:32', '2025-06-05 05:30:32', '');
INSERT INTO `menu` VALUES (11, 10, 'permission:menu:index', '{\"i18n\": \"baseMenu.permission.menuList\", \"type\": \"B\", \"title\": \"菜单列表\"}', '', '', '', 1, 0, 0, 0, '2025-06-05 05:30:32', '2025-06-05 05:30:32', '');
INSERT INTO `menu` VALUES (12, 10, 'permission:menu:create', '{\"i18n\": \"baseMenu.permission.menuSave\", \"type\": \"B\", \"title\": \"菜单保存\"}', '', '', '', 1, 0, 0, 0, '2025-06-05 05:30:32', '2025-06-05 05:30:32', '');
INSERT INTO `menu` VALUES (13, 10, 'permission:menu:save', '{\"i18n\": \"baseMenu.permission.menuUpdate\", \"type\": \"B\", \"title\": \"菜单更新\"}', '', '', '', 1, 0, 0, 0, '2025-06-05 05:30:33', '2025-06-05 05:30:33', '');
INSERT INTO `menu` VALUES (14, 10, 'permission:menu:delete', '{\"i18n\": \"baseMenu.permission.menuDelete\", \"type\": \"B\", \"title\": \"菜单删除\"}', '', '', '', 1, 0, 0, 0, '2025-06-05 05:30:33', '2025-06-05 05:30:33', '');
INSERT INTO `menu` VALUES (15, 1, 'permission:role', '{\"i18n\": \"baseMenu.permission.role\", \"icon\": \"material-symbols:supervisor-account-outline-rounded\", \"type\": \"M\", \"affix\": false, \"cache\": true, \"title\": \"角色管理\", \"hidden\": false, \"copyright\": true, \"componentPath\": \"modules/\", \"componentSuffix\": \".vue\", \"breadcrumbEnable\": true}', '/permission/role', 'base/views/permission/role/index', '', 1, 0, 0, 0, '2025-06-05 05:30:33', '2025-06-05 05:30:33', '');
INSERT INTO `menu` VALUES (16, 15, 'permission:role:index', '{\"i18n\": \"baseMenu.permission.roleList\", \"type\": \"B\", \"title\": \"角色列表\"}', '', '', '', 1, 0, 0, 0, '2025-06-05 05:30:33', '2025-06-05 05:30:33', '');
INSERT INTO `menu` VALUES (17, 15, 'permission:role:save', '{\"i18n\": \"baseMenu.permission.roleSave\", \"type\": \"B\", \"title\": \"角色保存\"}', '', '', '', 1, 0, 0, 0, '2025-06-05 05:30:33', '2025-06-05 05:30:33', '');
INSERT INTO `menu` VALUES (18, 15, 'permission:role:update', '{\"i18n\": \"baseMenu.permission.roleUpdate\", \"type\": \"B\", \"title\": \"角色更新\"}', '', '', '', 1, 0, 0, 0, '2025-06-05 05:30:33', '2025-06-05 05:30:33', '');
INSERT INTO `menu` VALUES (19, 15, 'permission:role:delete', '{\"i18n\": \"baseMenu.permission.roleDelete\", \"type\": \"B\", \"title\": \"角色删除\"}', '', '', '', 1, 0, 0, 0, '2025-06-05 05:30:34', '2025-06-05 05:30:34', '');
INSERT INTO `menu` VALUES (20, 15, 'permission:role:getMenu', '{\"i18n\": \"baseMenu.permission.getRolePermission\", \"type\": \"B\", \"title\": \"获取角色权限\"}', '', '', '', 1, 0, 0, 0, '2025-06-05 05:30:34', '2025-06-05 05:30:36', '');
INSERT INTO `menu` VALUES (21, 15, 'permission:role:setMenu', '{\"i18n\": \"baseMenu.permission.setRolePermission\", \"type\": \"B\", \"title\": \"赋予角色权限\"}', '', '', '', 1, 0, 0, 0, '2025-06-05 05:30:34', '2025-06-05 05:30:37', '');
INSERT INTO `menu` VALUES (22, 0, 'log', '{\"i18n\": \"baseMenu.log.index\", \"icon\": \"ph:instagram-logo\", \"type\": \"M\", \"affix\": false, \"cache\": true, \"title\": \"日志管理\", \"hidden\": false, \"copyright\": true, \"componentPath\": \"modules/\", \"componentSuffix\": \".vue\", \"breadcrumbEnable\": true}', '/log', '', '', 1, 0, 0, 0, '2025-06-05 05:30:34', '2025-06-05 05:30:34', '');
INSERT INTO `menu` VALUES (23, 22, 'log:userLogin', '{\"i18n\": \"baseMenu.log.userLoginLog\", \"icon\": \"ph:user-list\", \"type\": \"M\", \"affix\": false, \"cache\": true, \"title\": \"用户登录日志管理\", \"hidden\": false, \"copyright\": true, \"componentPath\": \"modules/\", \"componentSuffix\": \".vue\", \"breadcrumbEnable\": true}', '/log/userLoginLog', 'base/views/log/userLogin', '', 1, 0, 0, 0, '2025-06-05 05:30:34', '2025-06-05 05:30:34', '');
INSERT INTO `menu` VALUES (24, 23, 'log:userLogin:list', '{\"i18n\": \"baseMenu.log.userLoginLogList\", \"type\": \"B\", \"title\": \"用户登录日志列表\"}', '/log/userLoginLog', '', '', 1, 0, 0, 0, '2025-06-05 05:30:35', '2025-06-05 05:30:35', '');
INSERT INTO `menu` VALUES (25, 23, 'log:userLogin:delete', '{\"i18n\": \"baseMenu.log.userLoginLogDelete\", \"type\": \"B\", \"title\": \"删除用户登录日志\"}', '', '', '', 1, 0, 0, 0, '2025-06-05 05:30:35', '2025-06-05 05:30:35', '');
INSERT INTO `menu` VALUES (26, 22, 'log:userOperation', '{\"i18n\": \"baseMenu.log.operationLog\", \"icon\": \"ph:list-magnifying-glass\", \"type\": \"M\", \"affix\": false, \"cache\": true, \"title\": \"操作日志管理\", \"hidden\": false, \"copyright\": true, \"componentPath\": \"modules/\", \"componentSuffix\": \".vue\", \"breadcrumbEnable\": true}', '/log/operationLog', 'base/views/log/userOperation', '', 1, 0, 0, 0, '2025-06-05 05:30:35', '2025-06-05 05:30:35', '');
INSERT INTO `menu` VALUES (27, 26, 'log:userOperation:list', '{\"i18n\": \"baseMenu.log.userOperationLog\", \"type\": \"B\", \"title\": \"用户操作日志列表\"}', '', '', '', 1, 0, 0, 0, '2025-06-05 05:30:35', '2025-06-05 05:30:35', '');
INSERT INTO `menu` VALUES (28, 26, 'log:userOperation:delete', '{\"i18n\": \"baseMenu.log.userOperationLogDelete\", \"type\": \"B\", \"title\": \"删除用户操作日志\"}', '', '', '', 1, 0, 0, 0, '2025-06-05 05:30:35', '2025-06-05 05:30:35', '');
INSERT INTO `menu` VALUES (29, 0, 'dataCenter', '{\"i18n\": \"baseMenu.dataCenter.index\", \"icon\": \"ri:database-line\", \"type\": \"M\", \"affix\": false, \"cache\": true, \"title\": \"数据中心\", \"hidden\": false, \"copyright\": true, \"componentPath\": \"modules/\", \"componentSuffix\": \".vue\", \"breadcrumbEnable\": true}', '/dataCenter', '', '', 1, 0, 0, 0, '2025-06-05 05:30:35', '2025-06-05 05:30:35', '');
INSERT INTO `menu` VALUES (30, 29, 'dataCenter:attachment', '{\"i18n\": \"baseMenu.dataCenter.attachment\", \"icon\": \"ri:attachment-line\", \"type\": \"M\", \"affix\": false, \"cache\": true, \"title\": \"附件管理\", \"hidden\": false, \"copyright\": true, \"componentPath\": \"modules/\", \"componentSuffix\": \".vue\", \"breadcrumbEnable\": true}', '/dataCenter/attachment', 'base/views/dataCenter/attachment/index', '', 1, 0, 0, 0, '2025-06-05 05:30:36', '2025-06-05 05:30:36', '');
INSERT INTO `menu` VALUES (31, 30, 'dataCenter:attachment:list', '{\"i18n\": \"baseMenu.dataCenter.attachmentList\", \"type\": \"B\", \"title\": \"附件列表\"}', '', '', '', 1, 0, 0, 0, '2025-06-05 05:30:36', '2025-06-05 05:30:36', '');
INSERT INTO `menu` VALUES (32, 30, 'dataCenter:attachment:upload', '{\"i18n\": \"baseMenu.dataCenter.attachmentUpload\", \"type\": \"B\", \"title\": \"上传附件\"}', '', '', '', 1, 0, 0, 0, '2025-06-05 05:30:36', '2025-06-05 05:30:36', '');
INSERT INTO `menu` VALUES (33, 30, 'dataCenter:attachment:delete', '{\"i18n\": \"baseMenu.dataCenter.attachmentDelete\", \"type\": \"B\", \"title\": \"删除附件\"}', '', '', '', 1, 0, 0, 0, '2025-06-05 05:30:36', '2025-06-05 05:30:36', '');
INSERT INTO `menu` VALUES (34, 1, 'permission:department', '{\"i18n\": \"baseMenu.permission.department\", \"icon\": \"mingcute:department-line\", \"type\": \"M\", \"affix\": 0, \"cache\": 1, \"title\": \"部门管理\", \"hidden\": 0, \"copyright\": 1, \"componentPath\": \"modules/\", \"componentSuffix\": \".vue\", \"breadcrumbEnable\": 1}', '/permission/departments', 'base/views/permission/department/index', '', 1, 0, 0, 0, '2025-06-05 05:30:37', '2025-06-05 05:30:37', '');
INSERT INTO `menu` VALUES (35, 34, 'permission:department:index', '{\"i18n\": \"baseMenu.permission.departmentList\", \"type\": \"B\", \"affix\": 0, \"cache\": 1, \"title\": \"部门列表\", \"hidden\": 1}', '/permission/departments', '', '', 1, 0, 0, 0, '2025-06-05 05:30:37', '2025-06-05 05:30:37', '');
INSERT INTO `menu` VALUES (36, 34, 'permission:department:save', '{\"i18n\": \"baseMenu.permission.departmentCreate\", \"type\": \"B\", \"affix\": 0, \"cache\": 1, \"title\": \"部门新增\", \"hidden\": 1}', '/permission/departments', '', '', 1, 0, 0, 0, '2025-06-05 05:30:38', '2025-06-05 05:30:38', '');
INSERT INTO `menu` VALUES (37, 34, 'permission:department:update', '{\"i18n\": \"baseMenu.permission.departmentSave\", \"type\": \"B\", \"affix\": 0, \"cache\": 1, \"title\": \"部门编辑\", \"hidden\": 1}', '/permission/departments', '', '', 1, 0, 0, 0, '2025-06-05 05:30:38', '2025-06-05 05:30:38', '');
INSERT INTO `menu` VALUES (38, 34, 'permission:department:delete', '{\"i18n\": \"baseMenu.permission.departmentDelete\", \"type\": \"B\", \"affix\": 0, \"cache\": 1, \"title\": \"部门删除\", \"hidden\": 1}', '/permission/departments', '', '', 1, 0, 0, 0, '2025-06-05 05:30:38', '2025-06-05 05:30:38', '');
INSERT INTO `menu` VALUES (39, 34, 'permission:position:index', '{\"i18n\": \"baseMenu.permission.positionList\", \"type\": \"B\", \"affix\": 0, \"cache\": 1, \"title\": \"岗位列表\", \"hidden\": 1}', '/permission/departments', '', '', 1, 0, 0, 0, '2025-06-05 05:30:38', '2025-06-05 05:30:38', '');
INSERT INTO `menu` VALUES (40, 34, 'permission:position:save', '{\"i18n\": \"baseMenu.permission.positionCreate\", \"type\": \"B\", \"affix\": 0, \"cache\": 1, \"title\": \"岗位新增\", \"hidden\": 1}', '/permission/departments', '', '', 1, 0, 0, 0, '2025-06-05 05:30:38', '2025-06-05 05:30:38', '');
INSERT INTO `menu` VALUES (41, 34, 'permission:position:update', '{\"i18n\": \"baseMenu.permission.positionSave\", \"type\": \"B\", \"affix\": 0, \"cache\": 1, \"title\": \"岗位编辑\", \"hidden\": 1}', '/permission/departments', '', '', 1, 0, 0, 0, '2025-06-05 05:30:38', '2025-06-05 05:30:38', '');
INSERT INTO `menu` VALUES (42, 34, 'permission:position:delete', '{\"i18n\": \"baseMenu.permission.positionDelete\", \"type\": \"B\", \"affix\": 0, \"cache\": 1, \"title\": \"岗位删除\", \"hidden\": 1}', '/permission/departments', '', '', 1, 0, 0, 0, '2025-06-05 05:30:39', '2025-06-05 05:30:39', '');
INSERT INTO `menu` VALUES (43, 34, 'permission:position:data_permission', '{\"i18n\": \"baseMenu.permission.positionDataScope\", \"type\": \"B\", \"affix\": 0, \"cache\": 1, \"title\": \"设置岗位数据权限\", \"hidden\": 1}', '/permission/departments', '', '', 1, 0, 0, 0, '2025-06-05 05:30:39', '2025-06-05 05:30:39', '');
INSERT INTO `menu` VALUES (44, 34, 'permission:leader:index', '{\"i18n\": \"baseMenu.permission.leaderList\", \"type\": \"B\", \"affix\": 0, \"cache\": 1, \"title\": \"部门领导列表\", \"hidden\": 1}', '/permission/departments', '', '', 1, 0, 0, 0, '2025-06-05 05:30:39', '2025-06-05 05:30:39', '');
INSERT INTO `menu` VALUES (45, 34, 'permission:leader:save', '{\"i18n\": \"baseMenu.permission.leaderCreate\", \"type\": \"B\", \"affix\": 0, \"cache\": 1, \"title\": \"新增部门领导\", \"hidden\": 1}', '/permission/departments', '', '', 1, 0, 0, 0, '2025-06-05 05:30:39', '2025-06-05 05:30:39', '');
INSERT INTO `menu` VALUES (46, 34, 'permission:leader:delete', '{\"i18n\": \"baseMenu.permission.leaderDelete\", \"type\": \"B\", \"affix\": 0, \"cache\": 1, \"title\": \"部门领导移除\", \"hidden\": 1}', '/permission/departments', '', '', 1, 0, 0, 0, '2025-06-05 05:30:39', '2025-06-05 05:30:39', '');
INSERT INTO `menu` VALUES (47, 0, 'system:ConfigGroup', '{\"i18n\": \"systemMenu.systemSetting.name\", \"icon\": \"ant-design:setting-outlined\", \"type\": \"M\", \"affix\": false, \"cache\": true, \"title\": \"系统设置\", \"hidden\": false, \"copyright\": true, \"componentPath\": \"plugins/\", \"componentSuffix\": \".vue\", \"breadcrumbEnable\": true}', '/system', 'west/sys-settings/views/index', '', 1, 0, 0, 0, '2025-06-13 18:03:20', '2025-06-13 18:03:20', '');
INSERT INTO `menu` VALUES (48, 47, 'system:config:group:list', '{\"i18n\": \"systemMenu.systemSetting.actions.index\", \"type\": \"B\", \"title\": \"系统分组列表\"}', '', '', '', 1, 0, 0, 0, '2025-06-13 18:03:20', '2025-06-13 18:03:20', '');
INSERT INTO `menu` VALUES (49, 47, 'system:config:group:create', '{\"i18n\": \"systemMenu.systemSetting.actions.create\", \"type\": \"B\", \"title\": \"系统分组创建\"}', '', '', '', 1, 0, 0, 0, '2025-06-13 18:03:20', '2025-06-13 18:03:20', '');
INSERT INTO `menu` VALUES (50, 47, 'system:config:group:update', '{\"i18n\": \"systemMenu.systemSetting.actions.update\", \"type\": \"B\", \"title\": \"系统分组更新\"}', '', '', '', 1, 0, 0, 0, '2025-06-13 18:03:20', '2025-06-13 18:03:20', '');
INSERT INTO `menu` VALUES (51, 47, 'system:config:group:delete', '{\"i18n\": \"systemMenu.systemSetting.actions.delete\", \"type\": \"B\", \"title\": \"系统分组删除\"}', '', '', '', 1, 0, 0, 0, '2025-06-13 18:03:20', '2025-06-13 18:03:20', '');
INSERT INTO `menu` VALUES (52, 47, 'system:config:list', '{\"i18n\": \"systemMenu.systemSetting.actions.configIndex\", \"type\": \"B\", \"title\": \"系统配置列表\"}', '', '', '', 1, 0, 0, 0, '2025-06-13 18:03:20', '2025-06-13 18:03:20', '');
INSERT INTO `menu` VALUES (53, 47, 'system:config:details', '{\"i18n\": \"systemMenu.systemSetting.actions.configDetails\", \"type\": \"B\", \"title\": \"系统配置详情\"}', '', '', '', 1, 0, 0, 0, '2025-06-13 18:03:20', '2025-06-13 18:03:20', '');
INSERT INTO `menu` VALUES (54, 47, 'system:config:create', '{\"i18n\": \"systemMenu.systemSetting.actions.configCreate\", \"type\": \"B\", \"title\": \"系统配置创建\"}', '', '', '', 1, 0, 0, 0, '2025-06-13 18:03:20', '2025-06-13 18:03:20', '');
INSERT INTO `menu` VALUES (55, 47, 'system:config:update', '{\"i18n\": \"systemMenu.systemSetting.actions.configUpdate\", \"type\": \"B\", \"title\": \"系统配置更新\"}', '', '', '', 1, 0, 0, 0, '2025-06-13 18:03:20', '2025-06-13 18:03:20', '');
INSERT INTO `menu` VALUES (56, 47, 'system:config:delete', '{\"i18n\": \"systemMenu.systemSetting.actions.configDelete\", \"type\": \"B\", \"title\": \"系统配置删除\"}', '', '', '', 1, 0, 0, 0, '2025-06-13 18:03:20', '2025-06-13 18:03:20', '');
INSERT INTO `menu` VALUES (57, 47, 'system:config:batchUpdate', '{\"i18n\": \"systemMenu.systemSetting.actions.configBatchUpdate\", \"type\": \"B\", \"title\": \"系统配置批量更新\"}', '', '', '', 1, 0, 0, 0, '2025-06-13 18:03:20', '2025-06-13 18:03:20', '');
INSERT INTO `menu` VALUES (58, 29, 'recycleBin', '{\"i18n\": \"recycleBin.index\", \"icon\": \"mdi:recycle-variant\", \"type\": \"M\", \"affix\": false, \"cache\": true, \"title\": \"回收站\", \"hidden\": false, \"copyright\": true, \"componentPath\": \"modules/\", \"componentSuffix\": \".vue\", \"breadcrumbEnable\": true}', '/recycleBin', 'base/views/RecycleBin/index', '', 1, 0, 0, 1, '2025-06-19 06:01:00', '2025-06-21 09:09:48', '');
INSERT INTO `menu` VALUES (59, 58, 'recycleBin:list', '{\"i18n\": \"recycleBin.list\", \"type\": \"B\", \"title\": \"回收站列表\"}', '', '', '', 1, 0, 0, 0, '2025-06-19 06:01:00', '2025-06-21 09:09:48', '');
INSERT INTO `menu` VALUES (60, 58, 'recycleBin:update', '{\"i18n\": \"recycleBin.restore\", \"type\": \"B\", \"title\": \"回收站恢复\"}', '', '', '', 1, 0, 0, 0, '2025-06-19 06:01:00', '2025-06-21 09:09:48', '');
INSERT INTO `menu` VALUES (61, 0, 'tenant', '{\"i18n\": \"tenant.index\", \"icon\": \"mdi:store-outline\", \"type\": \"M\", \"affix\": false, \"cache\": true, \"title\": \"租户管理\", \"hidden\": false, \"copyright\": true, \"componentPath\": \"modules/\", \"componentSuffix\": \".vue\", \"breadcrumbEnable\": true}', '/tenant', 'tenant/views/Tenant/index', '', 1, 0, 0, 1, '2025-06-19 18:21:40', '2025-06-22 04:01:41', '');
INSERT INTO `menu` VALUES (62, 61, 'tenant:tenant', '{\"i18n\": \"tenant.index\", \"icon\": \"mdi:store-cog-outline\", \"type\": \"M\", \"affix\": false, \"cache\": true, \"title\": \"租户管理\", \"hidden\": false, \"copyright\": true, \"componentPath\": \"modules/\", \"componentSuffix\": \".vue\", \"breadcrumbEnable\": true}', '/tenant', 'tenant/views/Tenant/index', '', 1, 0, 0, 1, '2025-06-19 18:21:40', '2025-06-22 04:33:28', '');
INSERT INTO `menu` VALUES (63, 62, 'tenant:tenant:list', '{\"i18n\": \"tenantMenu.tenant.list\", \"type\": \"B\", \"title\": \"租户管理列表\"}', '', '', '', 1, 0, 0, 0, '2025-06-19 18:21:40', '2025-06-22 04:33:28', '');
INSERT INTO `menu` VALUES (64, 62, 'tenant:tenant:create', '{\"i18n\": \"tenantMenu.tenant.create\", \"type\": \"B\", \"title\": \"租户管理新增\"}', '', '', '', 1, 0, 0, 0, '2025-06-19 18:21:40', '2025-06-22 04:33:29', '');
INSERT INTO `menu` VALUES (65, 62, 'tenant:tenant:update', '{\"i18n\": \"tenantMenu.tenant.update\", \"type\": \"B\", \"title\": \"租户管理编辑\"}', '', '', '', 1, 0, 0, 0, '2025-06-19 18:21:40', '2025-06-22 04:33:29', '');
INSERT INTO `menu` VALUES (66, 62, 'tenant:tenant:delete', '{\"i18n\": \"tenantMenu.tenant.delete\", \"type\": \"B\", \"title\": \"租户管理删除\"}', '', '', '', 1, 0, 0, 0, '2025-06-19 18:21:40', '2025-06-22 04:33:29', '');
INSERT INTO `menu` VALUES (67, 62, 'tenant:tenant:recovery', '{\"i18n\": \"tenantMenu.tenant.recovery\", \"type\": \"B\", \"title\": \"租户回收站恢复\"}', '', '', '', 1, 0, 0, 0, '2025-06-19 18:21:40', '2025-06-22 04:33:29', '');
INSERT INTO `menu` VALUES (68, 62, 'tenant:tenant:realDelete', '{\"i18n\": \"tenantMenu.tenant.realDelete\", \"type\": \"B\", \"title\": \"清空回收站\"}', '', '', '', 1, 0, 0, 0, '2025-06-19 18:21:40', '2025-06-22 04:33:29', '');
INSERT INTO `menu` VALUES (69, 61, 'tenant:tenantApp', '{\"i18n\": \"tenantApp.index\", \"icon\": \"ri:apps-line\", \"type\": \"M\", \"affix\": false, \"cache\": true, \"title\": \"租户应用\", \"hidden\": false, \"copyright\": true, \"componentPath\": \"modules/\", \"componentSuffix\": \".vue\", \"breadcrumbEnable\": true}', '/tenantapp', 'tenant/views/TenantApp/Index', '', 1, 0, 0, 1, '2025-06-19 22:38:31', '2025-06-22 04:34:07', '');
INSERT INTO `menu` VALUES (70, 69, 'tenant:tenantApp:list', '{\"i18n\": \"tenantMenu.tenantApp.list\", \"type\": \"B\", \"title\": \"租户应用列表\"}', '', '', '', 1, 0, 0, 0, '2025-06-19 22:38:31', '2025-06-22 04:34:07', '');
INSERT INTO `menu` VALUES (71, 69, 'tenant:tenantApp:create', '{\"i18n\": \"tenantMenu.tenantApp.create\", \"type\": \"B\", \"title\": \"租户应用新增\"}', '', '', '', 1, 0, 0, 0, '2025-06-19 22:38:31', '2025-06-22 04:34:07', '');
INSERT INTO `menu` VALUES (72, 69, 'tenant:tenantApp:update', '{\"i18n\": \"tenantMenu.tenantApp.update\", \"type\": \"B\", \"title\": \"租户应用编辑\"}', '', '', '', 1, 0, 0, 0, '2025-06-19 22:38:31', '2025-06-22 04:34:07', '');
INSERT INTO `menu` VALUES (73, 69, 'tenant:tenantApp:delete', '{\"i18n\": \"tenantMenu.tenantApp.delete\", \"type\": \"B\", \"title\": \"租户应用删除\"}', '', '', '', 1, 0, 0, 0, '2025-06-19 22:38:31', '2025-06-22 04:34:07', '');
INSERT INTO `menu` VALUES (74, 69, 'tenant:tenantApp:recovery', '{\"i18n\": \"tenantMenu.tenantApp.recovery\", \"type\": \"B\", \"title\": \"租户应用回收站恢复\"}', '', '', '', 1, 0, 0, 0, '2025-06-19 18:21:40', '2025-06-22 04:33:29', '');
INSERT INTO `menu` VALUES (75, 69, 'tenant:tenantApp:realDelete', '{\"i18n\": \"tenantMenu.tenantApp.realDelete\", \"type\": \"B\", \"title\": \"清空回收站\"}', '', '', '', 1, 0, 0, 0, '2025-06-19 18:21:40', '2025-06-22 04:33:29', '');
INSERT INTO `menu` VALUES (76, 61, 'TenantUser', '{\"i18n\": \"tenantUser.index\", \"icon\": \"heroicons:user-group\", \"type\": \"M\", \"affix\": false, \"cache\": true, \"title\": \"租户成员\", \"hidden\": false, \"copyright\": true, \"componentPath\": \"modules/\", \"componentSuffix\": \".vue\", \"breadcrumbEnable\": true}', '/tenant/TenantUser', 'tenant/views/TenantUser/Index', '', 1, 0, 0, 1, '2025-06-22 16:14:06', '2025-06-23 01:08:39', '');
INSERT INTO `menu` VALUES (77, 76, 'tenant:tenantUser:list', '{\"i18n\": \"tenantMenu.tenantUser.list\", \"type\": \"B\", \"title\": \"租户成员列表\"}', '', '', '', 1, 0, 0, 0, '2025-06-22 16:14:06', '2025-06-23 01:08:39', '');
INSERT INTO `menu` VALUES (78, 76, 'tenant:tenantUser:create', '{\"i18n\": \"tenantMenu.tenantUser.create\", \"type\": \"B\", \"title\": \"租户成员新增\"}', '', '', '', 1, 0, 0, 0, '2025-06-22 16:14:06', '2025-06-23 01:08:39', '');
INSERT INTO `menu` VALUES (79, 76, 'tenant:tenantUser:update', '{\"i18n\": \"tenantMenu.tenantUser.update\", \"type\": \"B\", \"title\": \"租户成员编辑\"}', '', '', '', 1, 0, 0, 0, '2025-06-22 16:14:06', '2025-06-23 01:08:39', '');
INSERT INTO `menu` VALUES (80, 76, 'tenant:tenantUser:delete', '{\"i18n\": \"tenantMenu.tenantUser.delete\", \"type\": \"B\", \"title\": \"租户成员删除\"}', '', '', '', 1, 0, 0, 0, '2025-06-22 16:14:06', '2025-06-23 01:08:40', '');
INSERT INTO `menu` VALUES (81, 76, 'tenant:tenantUser:recovery', '{\"i18n\": \"tenantMenu.tenantUser.recovery\", \"type\": \"B\", \"title\": \"租户用户回收站恢复\"}', '', '', '', 1, 0, 0, 0, '2025-06-19 18:21:40', '2025-06-22 04:33:29', '');
INSERT INTO `menu` VALUES (82, 76, 'tenant:tenantUser:realDelete', '{\"i18n\": \"tenantMenu.tenantUser.realDelete\", \"type\": \"B\", \"title\": \"清空回收站\"}', '', '', '', 1, 0, 0, 0, '2025-06-19 18:21:40', '2025-06-22 04:33:29', '');

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES (1, '2020_07_22_213202_create_rules_table', 1);
INSERT INTO `migrations` VALUES (2, '2021_04_12_160526_create_user_table', 1);
INSERT INTO `migrations` VALUES (3, '2021_04_18_215320_create_menu_table', 1);
INSERT INTO `migrations` VALUES (4, '2021_04_18_215515_create_role_table', 1);
INSERT INTO `migrations` VALUES (5, '2021_06_24_111216_create_attachment_table', 1);
INSERT INTO `migrations` VALUES (6, '2024_09_22_205304_create_user_login_log', 1);
INSERT INTO `migrations` VALUES (7, '2024_09_22_205631_create_user_operation_log', 1);
INSERT INTO `migrations` VALUES (8, '2024_10_31_193302_create_user_belongs_role', 1);
INSERT INTO `migrations` VALUES (9, '2024_10_31_204004_create_role_belongs_menu', 1);
INSERT INTO `migrations` VALUES (10, '2025_02_24_195620_create_department_tables', 2);

-- ----------------------------
-- Table structure for open_api_interface
-- ----------------------------
DROP TABLE IF EXISTS `open_api_interface`;
CREATE TABLE `open_api_interface`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `api_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '接口名称',
  `api_uri` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '接口URI',
  `http_method` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '请求方式:GET,POST',
  `request_params` json NOT NULL COMMENT '请求参数说明',
  `request_example` json NOT NULL COMMENT '请求参数示例',
  `response_params` json NOT NULL COMMENT '响应参数说明',
  `response_example` json NOT NULL COMMENT '响应参数示例',
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '接口描述',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '状态:1-启用 0-停用',
  `rate_limit` int(11) NOT NULL DEFAULT 100 COMMENT '每秒请求限制',
  `auth_mode` tinyint(1) NOT NULL DEFAULT 1 COMMENT '认证模式 (0不需要认证 1简易签名 2复杂)',
  `created_by` bigint(20) NOT NULL COMMENT '创建人',
  `updated_by` bigint(20) NULL DEFAULT NULL COMMENT '更新人',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `uniq_api_uri_method`(`api_uri`, `http_method`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '开放API接口表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of open_api_interface
-- ----------------------------
INSERT INTO `open_api_interface` VALUES (1, '创建代收订单', '/v1/collection/orders', 'POST', '[{\"desc\": \"商户订单号\", \"name\": \"merchant_order_no\", \"type\": \"string\", \"required\": 1}, {\"desc\": \"订单金额\", \"name\": \"amount\", \"type\": \"decimal\", \"required\": 1}, {\"desc\": \"币种，默认INR\", \"name\": \"currency\", \"type\": \"string\", \"required\": 0}, {\"desc\": \"付款人姓名\", \"name\": \"payer_name\", \"type\": \"string\", \"required\": 1}, {\"desc\": \"付款人账号\", \"name\": \"payer_account\", \"type\": \"string\", \"required\": 1}, {\"desc\": \"付款人银行\", \"name\": \"payer_bank\", \"type\": \"string\", \"required\": 1}, {\"desc\": \"付款人IFSC代码\", \"name\": \"payer_ifsc\", \"type\": \"string\", \"required\": 1}, {\"desc\": \"回调地址\", \"name\": \"callback_url\", \"type\": \"string\", \"required\": 0}]', '{\"amount\": 1000.5, \"currency\": \"INR\", \"payer_bank\": \"ICICI Bank\", \"payer_ifsc\": \"ICIC0000001\", \"payer_name\": \"Rahul Sharma\", \"callback_url\": \"https://example.com/callback\", \"payer_account\": \"123456789012\", \"merchant_order_no\": \"ORD202307210001\"}', '[{\"desc\": \"响应码:200-成功\", \"name\": \"code\", \"type\": \"int\"}, {\"desc\": \"响应消息\", \"name\": \"message\", \"type\": \"string\"}, {\"desc\": \"平台订单号\", \"name\": \"data.order_no\", \"type\": \"string\"}, {\"desc\": \"收银台地址\", \"name\": \"data.collection_url\", \"type\": \"string\"}]', '{\"code\": 200, \"data\": {\"order_no\": \"COL20230721123456\", \"collection_url\": \"https://pay.newpay.com/collect/COL20230721123456\"}, \"message\": \"success\"}', '创建代收订单接口，用于发起收款请求', 1, 100, 1, 1, NULL, '2025-06-28 00:58:12', '2025-06-28 00:58:12');

-- ----------------------------
-- Table structure for position
-- ----------------------------
DROP TABLE IF EXISTS `position`;
CREATE TABLE `position`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '岗位名称',
  `dept_id` bigint(20) NOT NULL COMMENT '部门ID',
  `created_at` datetime NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = '岗位表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of position
-- ----------------------------

-- ----------------------------
-- Table structure for recycle_bin
-- ----------------------------
DROP TABLE IF EXISTS `recycle_bin`;
CREATE TABLE `recycle_bin`  (
  `id` bigint(20) UNSIGNED NOT NULL COMMENT 'ID',
  `tenant_id` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT '000000' COMMENT '租户编号',
  `data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '回收的数据',
  `table_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '数据表',
  `table_prefix` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '表前缀',
  `enabled` tinyint(1) UNSIGNED NOT NULL DEFAULT 2 COMMENT '是否已还原(1已还原，2未还原)',
  `ip` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT '' COMMENT '操作者IP',
  `operate_by` bigint(20) UNSIGNED NOT NULL DEFAULT 0 COMMENT '操作管理员',
  `created_at` datetime NULL DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime NULL DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `recycle_bin_tenant_id_index`(`tenant_id`) USING BTREE,
  INDEX `recycle_bin_table_name_index`(`table_name`) USING BTREE,
  INDEX `recycle_bin_operate_by_created_at_index`(`operate_by`, `created_at`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = '数据回收记录表' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of recycle_bin
-- ----------------------------

-- ----------------------------
-- Table structure for role
-- ----------------------------
DROP TABLE IF EXISTS `role`;
CREATE TABLE `role`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '角色名称',
  `code` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '角色代码',
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '状态:1=正常,2=停用',
  `sort` smallint(6) NOT NULL DEFAULT 0 COMMENT '排序',
  `created_by` bigint(20) NOT NULL DEFAULT 0 COMMENT '创建者',
  `updated_by` bigint(20) NOT NULL DEFAULT 0 COMMENT '更新者',
  `created_at` datetime NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  `remark` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '备注',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `role_code_unique`(`code`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = '角色信息表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of role
-- ----------------------------
INSERT INTO `role` VALUES (1, '超级管理员', 'SuperAdmin', 1, 0, 0, 0, '2025-06-05 05:30:40', '2025-06-05 05:30:40', '');
INSERT INTO `role` VALUES (2, 'test', 'test', 1, 0, 0, 0, NULL, NULL, '');
INSERT INTO `role` VALUES (3, 'ddd', 'wwe', 1, 2, 1, 1, NULL, NULL, '');
INSERT INTO `role` VALUES (5, 'haha', 'hahas', 1, 2, 1, 0, NULL, NULL, '');
INSERT INTO `role` VALUES (6, 'ddd', 'ww', 1, 4, 1, 0, NULL, NULL, '');

-- ----------------------------
-- Table structure for role_belongs_menu
-- ----------------------------
DROP TABLE IF EXISTS `role_belongs_menu`;
CREATE TABLE `role_belongs_menu`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `role_id` bigint(20) NOT NULL COMMENT '角色id',
  `menu_id` bigint(20) NOT NULL COMMENT '菜单id',
  `created_at` datetime NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `role_id_index`(`role_id`) USING BTREE,
  INDEX `menu_id_index`(`menu_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 215 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of role_belongs_menu
-- ----------------------------
INSERT INTO `role_belongs_menu` VALUES (1, 5, 1, NULL, NULL);
INSERT INTO `role_belongs_menu` VALUES (2, 5, 22, NULL, NULL);
INSERT INTO `role_belongs_menu` VALUES (3, 5, 24, NULL, NULL);
INSERT INTO `role_belongs_menu` VALUES (4, 5, 29, NULL, NULL);
INSERT INTO `role_belongs_menu` VALUES (6, 5, 2, NULL, NULL);
INSERT INTO `role_belongs_menu` VALUES (7, 5, 3, NULL, NULL);
INSERT INTO `role_belongs_menu` VALUES (8, 5, 4, NULL, NULL);
INSERT INTO `role_belongs_menu` VALUES (9, 5, 5, NULL, NULL);
INSERT INTO `role_belongs_menu` VALUES (10, 5, 6, NULL, NULL);
INSERT INTO `role_belongs_menu` VALUES (11, 5, 7, NULL, NULL);
INSERT INTO `role_belongs_menu` VALUES (12, 5, 8, NULL, NULL);
INSERT INTO `role_belongs_menu` VALUES (13, 5, 9, NULL, NULL);
INSERT INTO `role_belongs_menu` VALUES (14, 5, 10, NULL, NULL);
INSERT INTO `role_belongs_menu` VALUES (15, 5, 11, NULL, NULL);
INSERT INTO `role_belongs_menu` VALUES (16, 5, 12, NULL, NULL);
INSERT INTO `role_belongs_menu` VALUES (17, 5, 13, NULL, NULL);
INSERT INTO `role_belongs_menu` VALUES (18, 5, 14, NULL, NULL);
INSERT INTO `role_belongs_menu` VALUES (19, 5, 15, NULL, NULL);
INSERT INTO `role_belongs_menu` VALUES (20, 5, 16, NULL, NULL);
INSERT INTO `role_belongs_menu` VALUES (21, 5, 17, NULL, NULL);
INSERT INTO `role_belongs_menu` VALUES (22, 5, 18, NULL, NULL);
INSERT INTO `role_belongs_menu` VALUES (23, 5, 19, NULL, NULL);
INSERT INTO `role_belongs_menu` VALUES (24, 5, 20, NULL, NULL);
INSERT INTO `role_belongs_menu` VALUES (25, 5, 21, NULL, NULL);
INSERT INTO `role_belongs_menu` VALUES (26, 5, 23, NULL, NULL);
INSERT INTO `role_belongs_menu` VALUES (27, 5, 25, NULL, NULL);
INSERT INTO `role_belongs_menu` VALUES (28, 5, 26, NULL, NULL);
INSERT INTO `role_belongs_menu` VALUES (29, 5, 27, NULL, NULL);
INSERT INTO `role_belongs_menu` VALUES (30, 5, 28, NULL, NULL);
INSERT INTO `role_belongs_menu` VALUES (31, 5, 30, NULL, NULL);
INSERT INTO `role_belongs_menu` VALUES (32, 5, 31, NULL, NULL);
INSERT INTO `role_belongs_menu` VALUES (33, 5, 32, NULL, NULL);
INSERT INTO `role_belongs_menu` VALUES (34, 5, 33, NULL, NULL);
INSERT INTO `role_belongs_menu` VALUES (35, 5, 34, NULL, NULL);
INSERT INTO `role_belongs_menu` VALUES (36, 5, 35, NULL, NULL);
INSERT INTO `role_belongs_menu` VALUES (37, 5, 36, NULL, NULL);
INSERT INTO `role_belongs_menu` VALUES (38, 5, 37, NULL, NULL);
INSERT INTO `role_belongs_menu` VALUES (39, 5, 38, NULL, NULL);
INSERT INTO `role_belongs_menu` VALUES (40, 5, 39, NULL, NULL);
INSERT INTO `role_belongs_menu` VALUES (41, 5, 40, NULL, NULL);
INSERT INTO `role_belongs_menu` VALUES (42, 5, 41, NULL, NULL);
INSERT INTO `role_belongs_menu` VALUES (43, 5, 42, NULL, NULL);
INSERT INTO `role_belongs_menu` VALUES (44, 5, 43, NULL, NULL);
INSERT INTO `role_belongs_menu` VALUES (45, 5, 44, NULL, NULL);
INSERT INTO `role_belongs_menu` VALUES (46, 5, 45, NULL, NULL);
INSERT INTO `role_belongs_menu` VALUES (47, 5, 46, NULL, NULL);
INSERT INTO `role_belongs_menu` VALUES (48, 5, 58, NULL, NULL);
INSERT INTO `role_belongs_menu` VALUES (49, 5, 59, NULL, NULL);
INSERT INTO `role_belongs_menu` VALUES (50, 5, 60, NULL, NULL);
INSERT INTO `role_belongs_menu` VALUES (103, 6, 29, NULL, NULL);
INSERT INTO `role_belongs_menu` VALUES (104, 6, 30, NULL, NULL);
INSERT INTO `role_belongs_menu` VALUES (105, 6, 31, NULL, NULL);
INSERT INTO `role_belongs_menu` VALUES (106, 6, 32, NULL, NULL);
INSERT INTO `role_belongs_menu` VALUES (107, 6, 33, NULL, NULL);
INSERT INTO `role_belongs_menu` VALUES (108, 6, 58, NULL, NULL);
INSERT INTO `role_belongs_menu` VALUES (109, 6, 59, NULL, NULL);
INSERT INTO `role_belongs_menu` VALUES (110, 6, 60, NULL, NULL);
INSERT INTO `role_belongs_menu` VALUES (163, 6, 1, NULL, NULL);
INSERT INTO `role_belongs_menu` VALUES (164, 6, 2, NULL, NULL);
INSERT INTO `role_belongs_menu` VALUES (165, 6, 3, NULL, NULL);
INSERT INTO `role_belongs_menu` VALUES (166, 6, 4, NULL, NULL);
INSERT INTO `role_belongs_menu` VALUES (167, 6, 5, NULL, NULL);
INSERT INTO `role_belongs_menu` VALUES (168, 6, 6, NULL, NULL);
INSERT INTO `role_belongs_menu` VALUES (169, 6, 7, NULL, NULL);
INSERT INTO `role_belongs_menu` VALUES (170, 6, 8, NULL, NULL);
INSERT INTO `role_belongs_menu` VALUES (171, 6, 9, NULL, NULL);
INSERT INTO `role_belongs_menu` VALUES (172, 6, 10, NULL, NULL);
INSERT INTO `role_belongs_menu` VALUES (173, 6, 11, NULL, NULL);
INSERT INTO `role_belongs_menu` VALUES (174, 6, 12, NULL, NULL);
INSERT INTO `role_belongs_menu` VALUES (175, 6, 13, NULL, NULL);
INSERT INTO `role_belongs_menu` VALUES (176, 6, 14, NULL, NULL);
INSERT INTO `role_belongs_menu` VALUES (177, 6, 15, NULL, NULL);
INSERT INTO `role_belongs_menu` VALUES (178, 6, 16, NULL, NULL);
INSERT INTO `role_belongs_menu` VALUES (179, 6, 17, NULL, NULL);
INSERT INTO `role_belongs_menu` VALUES (180, 6, 18, NULL, NULL);
INSERT INTO `role_belongs_menu` VALUES (181, 6, 19, NULL, NULL);
INSERT INTO `role_belongs_menu` VALUES (182, 6, 20, NULL, NULL);
INSERT INTO `role_belongs_menu` VALUES (183, 6, 21, NULL, NULL);
INSERT INTO `role_belongs_menu` VALUES (184, 6, 34, NULL, NULL);
INSERT INTO `role_belongs_menu` VALUES (185, 6, 35, NULL, NULL);
INSERT INTO `role_belongs_menu` VALUES (186, 6, 36, NULL, NULL);
INSERT INTO `role_belongs_menu` VALUES (187, 6, 37, NULL, NULL);
INSERT INTO `role_belongs_menu` VALUES (188, 6, 38, NULL, NULL);
INSERT INTO `role_belongs_menu` VALUES (189, 6, 39, NULL, NULL);
INSERT INTO `role_belongs_menu` VALUES (190, 6, 40, NULL, NULL);
INSERT INTO `role_belongs_menu` VALUES (191, 6, 41, NULL, NULL);
INSERT INTO `role_belongs_menu` VALUES (192, 6, 42, NULL, NULL);
INSERT INTO `role_belongs_menu` VALUES (193, 6, 43, NULL, NULL);
INSERT INTO `role_belongs_menu` VALUES (194, 6, 44, NULL, NULL);
INSERT INTO `role_belongs_menu` VALUES (195, 6, 45, NULL, NULL);
INSERT INTO `role_belongs_menu` VALUES (196, 6, 46, NULL, NULL);
INSERT INTO `role_belongs_menu` VALUES (197, 6, 61, NULL, NULL);
INSERT INTO `role_belongs_menu` VALUES (198, 6, 62, NULL, NULL);
INSERT INTO `role_belongs_menu` VALUES (199, 6, 63, NULL, NULL);
INSERT INTO `role_belongs_menu` VALUES (200, 6, 64, NULL, NULL);
INSERT INTO `role_belongs_menu` VALUES (201, 6, 65, NULL, NULL);
INSERT INTO `role_belongs_menu` VALUES (202, 6, 66, NULL, NULL);
INSERT INTO `role_belongs_menu` VALUES (203, 6, 67, NULL, NULL);
INSERT INTO `role_belongs_menu` VALUES (204, 6, 68, NULL, NULL);
INSERT INTO `role_belongs_menu` VALUES (205, 6, 69, NULL, NULL);
INSERT INTO `role_belongs_menu` VALUES (206, 6, 70, NULL, NULL);
INSERT INTO `role_belongs_menu` VALUES (207, 6, 71, NULL, NULL);
INSERT INTO `role_belongs_menu` VALUES (208, 6, 72, NULL, NULL);
INSERT INTO `role_belongs_menu` VALUES (209, 6, 73, NULL, NULL);
INSERT INTO `role_belongs_menu` VALUES (210, 6, 74, NULL, NULL);
INSERT INTO `role_belongs_menu` VALUES (211, 6, 75, NULL, NULL);
INSERT INTO `role_belongs_menu` VALUES (212, 6, 76, NULL, NULL);
INSERT INTO `role_belongs_menu` VALUES (213, 6, 77, NULL, NULL);
INSERT INTO `role_belongs_menu` VALUES (214, 6, 78, NULL, NULL);

-- ----------------------------
-- Table structure for rules
-- ----------------------------
DROP TABLE IF EXISTS `rules`;
CREATE TABLE `rules`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `ptype` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `v0` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `v1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `v2` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `v3` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `v4` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `v5` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of rules
-- ----------------------------

-- ----------------------------
-- Table structure for setting_config
-- ----------------------------
DROP TABLE IF EXISTS `setting_config`;
CREATE TABLE `setting_config`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `group_id` bigint(20) NOT NULL DEFAULT 0 COMMENT '组id',
  `key` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '配置键名',
  `value` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '配置值',
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '配置名称',
  `input_type` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '数据输入类型',
  `config_select_data` json NULL COMMENT '配置选项数据',
  `sort` smallint(5) UNSIGNED NOT NULL DEFAULT 0 COMMENT '排序',
  `remark` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '备注',
  `created_by` bigint(20) NULL DEFAULT NULL COMMENT '创建者',
  `updated_by` bigint(20) NULL DEFAULT NULL COMMENT '更新者',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `system_setting_config_key_unique`(`key`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 19 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of setting_config
-- ----------------------------
INSERT INTO `setting_config` VALUES (11, 1, 'site_open', '0', '站点开启', 'switch', '[]', 101, '是否对外提供网络服务', 1, NULL, '2025-06-14 00:20:11', '2025-06-14 00:20:11');
INSERT INTO `setting_config` VALUES (12, 1, 'site_name', '3333es', '站点名称', 'input', '[]', 99, NULL, 1, NULL, '2025-06-14 00:28:47', '2025-06-16 18:44:09');
INSERT INTO `setting_config` VALUES (13, 1, 'site_logo', 'https://server.bug.it.com/upload/7a8d99685b2b0b1ab94afd4926138211.png', '站点Logo', 'imageUpload', '[]', 0, NULL, 1, NULL, '2025-06-14 00:30:48', '2025-06-14 00:30:48');
INSERT INTO `setting_config` VALUES (14, 2, 'upload_mode', 'local', '上传模式', 'select', '[{\"label\": \"私有云(本地)\", \"value\": \"local\"}, {\"label\": \"阿里云\", \"value\": \"oss\"}, {\"label\": \"腾讯云\", \"value\": \"cos\"}, {\"label\": \"七牛云\", \"value\": \"qiniu\"}, {\"label\": \"亚马逊(S3)\", \"value\": \"s3\"}]', 0, NULL, 1, NULL, '2025-06-14 08:33:36', '2025-06-14 08:33:36');
INSERT INTO `setting_config` VALUES (15, 2, 'upload_single_limit', '1024', '上传大小', 'input', '[]', 0, NULL, 1, NULL, '2025-06-14 08:34:58', '2025-06-14 08:34:58');
INSERT INTO `setting_config` VALUES (16, 2, 'upload_nums', '10', '数量限制', 'input', '[]', 0, NULL, 1, NULL, '2025-06-14 08:36:00', '2025-06-14 08:36:00');
INSERT INTO `setting_config` VALUES (17, 2, 'upload_exclude', 'php,ext,exe', '不允许文件类型', 'textarea', '[]', 0, '英文逗号分割多个文件后缀', 1, NULL, '2025-06-14 08:37:03', '2025-06-14 08:37:03');
INSERT INTO `setting_config` VALUES (18, 2, 'upload_include', 'png', '允许文件类型', 'textarea', '[]', 0, '英文逗号分割多个文件后缀', 1, NULL, '2025-06-14 08:37:03', '2025-06-14 08:37:03');

-- ----------------------------
-- Table structure for setting_config_group
-- ----------------------------
DROP TABLE IF EXISTS `setting_config_group`;
CREATE TABLE `setting_config_group`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '配置组名称',
  `code` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '配置组标识',
  `icon` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '配置组图标',
  `created_by` bigint(20) NULL DEFAULT NULL COMMENT '创建者',
  `updated_by` bigint(20) NULL DEFAULT NULL COMMENT '更新者',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `remark` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `code_unique_index`(`code`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of setting_config_group
-- ----------------------------
INSERT INTO `setting_config_group` VALUES (1, '站点设置', 'site_setting', 'vscode-icons:file-type-aspx', 1, NULL, '2025-06-14 16:06:45', '2025-06-14 16:06:45', '网站基础信息配置');
INSERT INTO `setting_config_group` VALUES (2, '上传设置', 'upload_setting', 'ant-design:cloud-upload-outlined', 1, NULL, '2025-06-14 16:16:12', '2025-06-14 16:16:12', '文件上传配置');

-- ----------------------------
-- Table structure for tenant
-- ----------------------------
DROP TABLE IF EXISTS `tenant`;
CREATE TABLE `tenant`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id',
  `tenant_id` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '租户编号',
  `contact_user_name` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '联系人',
  `contact_phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '联系电话',
  `company_name` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '企业名称',
  `license_number` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '企业代码',
  `address` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '地址',
  `intro` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '企业简介',
  `domain` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '域名',
  `account_count` int(11) NULL DEFAULT -1 COMMENT '用户数量（-1不限制）',
  `is_enabled` tinyint(1) NULL DEFAULT 2 COMMENT '启用状态(1正常 0停用)',
  `created_by` bigint(20) UNSIGNED NOT NULL DEFAULT 0 COMMENT '创建管理员',
  `created_at` datetime NULL DEFAULT NULL COMMENT '创建时间',
  `expired_at` datetime NULL DEFAULT NULL COMMENT '过期时间',
  `updated_by` bigint(20) NULL DEFAULT 0 COMMENT '更新者',
  `updated_at` datetime NULL DEFAULT NULL COMMENT '更新时间',
  `safe_level` tinyint(3) NOT NULL DEFAULT 0 COMMENT '安全等级(0-99)',
  `deleted_by` bigint(20) NULL DEFAULT 0 COMMENT '删除者',
  `deleted_at` datetime NULL DEFAULT NULL COMMENT '删除时间',
  `remark` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL COMMENT '备注',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `tenant_id_unique_index`(`tenant_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = '租户表' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tenant
-- ----------------------------
INSERT INTO `tenant` VALUES (1, '000000', 'haha', '12345', 'w', '', '', '', '', 1, 1, 1, '2025-06-23 09:22:28', NULL, 1, '2025-06-25 07:25:47', 1, 0, NULL, NULL);
INSERT INTO `tenant` VALUES (2, '000001', 'gaxx', '11', 'd', '', '', '', '', 1, 1, 1, '2025-06-23 09:33:50', NULL, 1, '2025-06-26 06:40:06', 1, 1, NULL, NULL);

-- ----------------------------
-- Table structure for tenant_account
-- ----------------------------
DROP TABLE IF EXISTS `tenant_account`;
CREATE TABLE `tenant_account`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `account_id` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '账号ID',
  `tenant_id` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '租户编号',
  `balance_available` decimal(12, 4) NOT NULL DEFAULT 0.0000 COMMENT '可用余额',
  `balance_frozen` decimal(12, 4) NOT NULL DEFAULT 0.0000 COMMENT '冻结金额',
  `account_type` tinyint(2) NOT NULL DEFAULT 1 COMMENT '账户类型:10-收款账户 20-付款账户',
  `currency` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'CNY' COMMENT '币种',
  `version` int(11) NOT NULL DEFAULT 0 COMMENT '乐观锁版本',
  `created_at` datetime NULL DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime NULL DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `uk_account_id`(`account_id`) USING BTREE,
  INDEX `idx_tenant_id`(`tenant_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '租户账户表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tenant_account
-- ----------------------------

-- ----------------------------
-- Table structure for tenant_app
-- ----------------------------
DROP TABLE IF EXISTS `tenant_app`;
CREATE TABLE `tenant_app`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键',
  `tenant_id` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '000000' COMMENT '租户编号',
  `app_name` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '应用名称',
  `app_key` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '应用ID',
  `app_secret` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '应用密钥',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '状态 (1正常 2停用)',
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL COMMENT '应用介绍',
  `created_by` bigint(20) NOT NULL DEFAULT 0 COMMENT '创建者',
  `created_at` datetime NULL DEFAULT NULL COMMENT '创建时间',
  `updated_by` bigint(20) NULL DEFAULT 0 COMMENT '更新者',
  `updated_at` datetime NULL DEFAULT NULL COMMENT '更新时间',
  `deleted_by` bigint(20) NULL DEFAULT 0 COMMENT '删除者',
  `deleted_at` datetime NULL DEFAULT NULL COMMENT '删除时间',
  `remark` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '备注',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `tenant_app_tenant_id_index`(`tenant_id`) USING BTREE,
  INDEX `tenant_app_app_key_index`(`app_key`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = '租户应用表' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tenant_app
-- ----------------------------
INSERT INTO `tenant_app` VALUES (1, '000001', 'ee', 'Cjikn5IRJiYJIvSC', 'f594848f6a4db258bb2ad46ce978e84a', 1, 'ssss', 1, '2025-06-26 14:29:08', 1, '2025-06-26 15:56:56', 1, NULL, 'w');

-- ----------------------------
-- Table structure for tenant_app_log
-- ----------------------------
DROP TABLE IF EXISTS `tenant_app_log`;
CREATE TABLE `tenant_app_log`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键',
  `tenant_id` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '000000' COMMENT '租户编号',
  `api_name` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '接口名称',
  `access_path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '接口访问路径',
  `request_id` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '请求id',
  `request_data` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL COMMENT '请求数据',
  `response_code` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT '' COMMENT '响应状态码',
  `response_success` tinyint(1) NOT NULL DEFAULT 1 COMMENT '状态 (1成功 2失败)',
  `response_message` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '响应信息',
  `response_data` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL COMMENT '响应数据',
  `ip` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '访问IP地址',
  `ip_location` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT 'IP所属地',
  `access_time` timestamp NULL DEFAULT NULL COMMENT '访问时间',
  `remark` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `tenant_app_log_tenant_id_index`(`tenant_id`) USING BTREE,
  INDEX `tenant_app_log_access_path_index`(`access_path`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6837332 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = '租户接口访问日志表' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tenant_app_log
-- ----------------------------

-- ----------------------------
-- Table structure for tenant_config
-- ----------------------------
DROP TABLE IF EXISTS `tenant_config`;
CREATE TABLE `tenant_config`  (
  `id` bigint(20) NOT NULL COMMENT '配置ID',
  `tenant_id` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '租户编号',
  `group_code` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '分组编码',
  `code` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '唯一编码',
  `name` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '配置名称',
  `content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '配置内容',
  `enabled` tinyint(1) NOT NULL DEFAULT 1 COMMENT '是否启用',
  `intro` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '介绍说明',
  `option` json NULL COMMENT '备用选项',
  `created_by` bigint(20) NOT NULL DEFAULT 0 COMMENT '创建者',
  `updated_by` bigint(20) NULL DEFAULT 0 COMMENT '更新者',
  `deleted_by` bigint(20) NULL DEFAULT 0 COMMENT '删除者',
  `created_at` datetime NULL DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime NULL DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_config_code`(`code`) USING BTREE,
  INDEX `idx_config_group_code`(`group_code`) USING BTREE,
  INDEX `idx_tenant_id`(`tenant_id`) USING BTREE,
  UNIQUE INDEX `idx_tenant_id_code`(`tenant_id`, `code`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '租户配置' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tenant_config
-- ----------------------------

-- ----------------------------
-- Table structure for tenant_user
-- ----------------------------
DROP TABLE IF EXISTS `tenant_user`;
CREATE TABLE `tenant_user`  (
  `user_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `tenant_id` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '000000' COMMENT '租户编号',
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '用户名',
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '密码',
  `phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '手机号码',
  `avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '头像',
  `last_login_ip` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '最后登陆IP',
  `last_login_time` datetime NULL DEFAULT NULL COMMENT '最后登陆时间',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '状态(1正常 2停用)',
  `is_enabled_google` tinyint(1) NOT NULL DEFAULT 1 COMMENT 'google验证(1正常 2停用)',
  `google_secret` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'Google验证密钥',
  `is_bind_google` tinyint(1) NOT NULL DEFAULT 2 COMMENT '是否已绑定Google验证(1yes 2no)',
  `created_by` bigint(20) NOT NULL DEFAULT 0 COMMENT '创建者',
  `created_at` datetime NULL DEFAULT NULL COMMENT '创建时间',
  `updated_by` bigint(20) NULL DEFAULT 0 COMMENT '更新者',
  `updated_at` datetime NULL DEFAULT NULL COMMENT '更新时间',
  `deleted_by` bigint(20) NULL DEFAULT 0 COMMENT '删除者',
  `deleted_at` datetime NULL DEFAULT NULL COMMENT '删除时间',
  `ip_whitelist` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL COMMENT 'IP白名单',
  `remark` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '备注',
  PRIMARY KEY (`user_id`) USING BTREE,
  UNIQUE INDEX `idx_username`(`username`) USING BTREE,
  INDEX `tenant_app_tenant_id_index`(`tenant_id`) USING BTREE,
  INDEX `idx_phone`(`phone`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 31 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = '租户用户表' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tenant_user
-- ----------------------------
INSERT INTO `tenant_user` VALUES (29, '000000', 'ss', '', 'ss', '', '', NULL, 1, 1, '', 2, 1, '2025-06-26 20:42:57', 1, '2025-06-27 02:31:52', 0, NULL, NULL, '');

-- ----------------------------
-- Table structure for tenant_user_login_log
-- ----------------------------
DROP TABLE IF EXISTS `tenant_user_login_log`;
CREATE TABLE `tenant_user_login_log`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键',
  `tenant_id` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '000000' COMMENT '租户编号',
  `username` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '用户名',
  `ip` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '登录IP地址',
  `os` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '操作系统',
  `browser` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '浏览器',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '登录状态 (1成功 2失败)',
  `message` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '提示消息',
  `login_time` datetime NOT NULL COMMENT '登录时间',
  `remark` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `tenant_user_login_log_tenant_id_index`(`tenant_id`) USING BTREE,
  INDEX `tenant_user_login_log_username_index`(`username`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 27 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = '租户登录日志表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tenant_user_login_log
-- ----------------------------

-- ----------------------------
-- Table structure for tenant_user_operation_log
-- ----------------------------
DROP TABLE IF EXISTS `tenant_user_operation_log`;
CREATE TABLE `tenant_user_operation_log`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tenant_id` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '000000' COMMENT '租户编号',
  `username` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '用户名',
  `method` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '请求方式',
  `router` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '请求路由',
  `service_name` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '业务名称',
  `ip` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '请求IP地址',
  `created_at` timestamp NULL DEFAULT NULL COMMENT '创建时间',
  `updated_at` timestamp NULL DEFAULT NULL COMMENT '更新时间',
  `remark` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '备注',
  `request_params` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL COMMENT '请求参数',
  `response_status` int(11) NULL DEFAULT NULL COMMENT '响应状态码',
  `is_success` tinyint(1) NULL DEFAULT 1 COMMENT '操作是否成功(1:成功,0:失败)',
  `response_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL COMMENT '响应数据',
  `operator_id` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '操作者ID',
  `request_id` varchar(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT '' COMMENT 'uuid',
  `request_duration` bigint(20) UNSIGNED NULL DEFAULT NULL COMMENT '请求耗时(毫秒)',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `tenant_user_operation_log_tenant_id_index`(`tenant_id`) USING BTREE,
  INDEX `tenant_user_operation_log_username_index`(`username`) USING BTREE,
  INDEX `tenant_user_operation_log_created_at_index`(`created_at`) USING BTREE,
  INDEX `tenant_user_operation_log_service_name_index`(`service_name`) USING BTREE,
  INDEX `tenant_user_operation_log_operator_id_index`(`operator_id`) USING BTREE,
  INDEX `tenant_user_operation_log_operator_id_created_at_index`(`operator_id`, `created_at`) USING BTREE,
  INDEX `tenant_user_operation_log_created_at_service_name_index`(`created_at`, `service_name`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 78 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = '操作日志表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tenant_user_operation_log
-- ----------------------------

-- ----------------------------
-- Table structure for transaction_queue_status
-- ----------------------------
DROP TABLE IF EXISTS `transaction_queue_status`;
CREATE TABLE `transaction_queue_status`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `transaction_no` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '关联交易流水号',
  `transaction_type` tinyint(2) NOT NULL COMMENT '冗余业务交易类型（便于按类型调度）',
  `queue_type` tinyint(2) NOT NULL COMMENT '队列类型:1-即时 2-延时 3-重试 4-冲正 5-定时',
  `process_status` tinyint(2) NOT NULL DEFAULT 0 COMMENT '状态:0-待处理 1-处理中 2-成功 3-失败 4-挂起 5-等待中',
  `scheduled_execute_time` datetime NULL DEFAULT NULL COMMENT '计划执行时间',
  `next_retry_time` datetime NULL DEFAULT NULL COMMENT '下次重试时间',
  `retry_count` int(11) NOT NULL DEFAULT 0 COMMENT '重试次数',
  `lock_version` int(11) NOT NULL DEFAULT 0 COMMENT '乐观锁版本号',
  `error_code` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '错误代码',
  `error_detail` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL COMMENT '错误详情',
  `created_at` datetime NOT NULL COMMENT '创建时间',
  `updated_at` datetime NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `uk_transaction_process`(`transaction_no`, `queue_type`) USING BTREE,
  INDEX `idx_type_status`(`transaction_type`, `process_status`) USING BTREE,
  INDEX `idx_schedule_time`(`scheduled_execute_time`) USING BTREE,
  INDEX `idx_retry_schedule`(`next_retry_time`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = '交易队列状态表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of transaction_queue_status
-- ----------------------------

-- ----------------------------
-- Table structure for transaction_record
-- ----------------------------
DROP TABLE IF EXISTS `transaction_record`;
CREATE TABLE `transaction_record`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `transaction_no` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '全局唯一交易流水号',
  `tenant_account_id` bigint(20) NOT NULL COMMENT '关联租户账户ID',
  `account_id` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '冗余账号ID',
  `tenant_id` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '冗余租户编号',
  `amount` decimal(10, 4) NOT NULL DEFAULT 0.0000 COMMENT '交易金额（正：收入，负：支出）',
  `fee_amount` decimal(10, 4) NOT NULL DEFAULT 0.0000 COMMENT '手续费金额',
  `net_amount` decimal(10, 4) GENERATED ALWAYS AS ((`amount` - `fee_amount`)) VIRTUAL COMMENT '净额（计算列）' NULL,
  `balance_before` decimal(10, 4) NOT NULL DEFAULT 0.0000 COMMENT '交易前余额',
  `balance_after` decimal(10, 4) NOT NULL DEFAULT 0.0000 COMMENT '交易后余额',
  `account_type` tinyint(2) NOT NULL COMMENT '账户变动类型（继承tenant_account类型）',
  `transaction_type` smallint(3) NOT NULL COMMENT '业务交易类型：# 基础交易类型 (1XX)\r\n100: 收款\r\n110: 付款\r\n120: 转账\r\n\r\n# 退款相关 (2XX)\r\n200: 收款退款\r\n210: 付款退款\r\n\r\n# 手续费类 (3XX)\r\n300: 收款手续费\r\n310: 付款手续费\r\n320: 转账手续费\r\n\r\n# 资金调整 (4XX)\r\n400: 资金调增（人工）\r\n410: 资金调减（人工）\r\n420: 冻结资金\r\n430: 解冻资金\r\n\r\n# 特殊交易 (9XX)\r\n900: 冲正交易\r\n910: 差错调整',
  `settlement_delay_mode` tinyint(2) NOT NULL DEFAULT 1 COMMENT '延迟模式:1-D0(立即) 2-D(自然日) 3-T(工作日)',
  `expected_settlement_time` datetime NULL DEFAULT NULL COMMENT '预计结算时间',
  `settlement_delay_days` smallint(5) UNSIGNED NOT NULL DEFAULT 0 COMMENT '延迟天数',
  `holiday_adjustment` tinyint(1) NOT NULL DEFAULT 1 COMMENT '节假日调整:0-不调整 1-顺延 2-提前',
  `actual_settlement_time` datetime NULL DEFAULT NULL COMMENT '实际结算时间',
  `counterparty` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '交易对手方标识',
  `order_no` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '关联业务订单号',
  `ref_transaction_no` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '关联原交易流水号',
  `transaction_status` tinyint(2) NOT NULL DEFAULT 0 COMMENT '交易状态:0-处理中 1-成功 2-失败 3-已冲正 4-等待结算',
  `remark` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '交易备注',
  `created_at` datetime NOT NULL COMMENT '创建时间',
  `updated_at` datetime NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `uk_transaction_no`(`transaction_no`) USING BTREE,
  INDEX `idx_tenant_account`(`tenant_account_id`) USING BTREE,
  INDEX `idx_tenant_transaction`(`tenant_id`, `created_at`) USING BTREE,
  INDEX `idx_transaction_type`(`transaction_type`) USING BTREE,
  INDEX `idx_ref_transaction`(`ref_transaction_no`) USING BTREE,
  INDEX `idx_settlement_time`(`expected_settlement_time`) USING BTREE,
  INDEX `idx_account_status`(`tenant_account_id`, `transaction_status`, `transaction_type`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = '交易记录表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of transaction_record
-- ----------------------------

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '用户ID,主键',
  `username` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '用户名',
  `password` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '密码',
  `user_type` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '100' COMMENT '用户类型:100=系统用户',
  `nickname` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '用户昵称',
  `phone` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '手机',
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '用户邮箱',
  `avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '用户头像',
  `signed` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '个人签名',
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '状态:1=正常,2=停用',
  `login_ip` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '127.0.0.1' COMMENT '最后登陆IP',
  `login_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '最后登陆时间',
  `backend_setting` json NULL COMMENT '后台设置数据',
  `created_by` bigint(20) NOT NULL DEFAULT 0 COMMENT '创建者',
  `updated_by` bigint(20) NOT NULL DEFAULT 0 COMMENT '更新者',
  `created_at` datetime NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  `remark` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '备注',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `user_username_unique`(`username`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 14 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = '用户信息表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES (1, 'admin', '$2y$10$5ueag8DJh3ScVEhSkUXZUuAyBL8iJHmTiqNsY9WKYoz/6ldA34ifu', '100', '创始人1', '16858888988', 'admin@adminmine.com', '', '广阔天地，大有所为', 1, '127.0.0.1', '2025-06-05 12:30:40', '{\"app\": {\"layout\": \"columns\", \"asideDark\": false, \"colorMode\": \"autoMode\", \"useLocale\": \"zh_CN\", \"whiteRoute\": [\"login\"], \"pageAnimate\": \"ma-slide-down\", \"primaryColor\": \"#2563EB\", \"watermarkText\": \"MineAdmin\", \"showBreadcrumb\": true, \"enableWatermark\": false, \"loadUserSetting\": true}, \"tabbar\": {\"mode\": \"rectangle\", \"enable\": true}, \"subAside\": {\"showIcon\": true, \"showTitle\": true, \"fixedAsideState\": false, \"showCollapseButton\": true}, \"copyright\": {\"dates\": \"2025\", \"enable\": false, \"company\": \"MineAdmin Team\", \"website\": \"https://www.mineadmin.com\", \"putOnRecord\": \"豫ICP备00000000号-1\"}, \"mainAside\": {\"showIcon\": true, \"showTitle\": true, \"enableOpenFirstRoute\": false}, \"welcomePage\": {\"icon\": \"icon-park-outline:jewelry\", \"name\": \"welcome\", \"path\": \"/welcome\", \"title\": \"欢迎页\"}}', 0, 0, '2025-06-05 05:30:40', '2025-06-05 05:48:12', '');
INSERT INTO `user` VALUES (4, 'test2', '$2y$10$mT//LwEu4mrwVuFVRa2anekjwsAnK3mcDMeBt1QshAJ4/lWqMYy5u', '200', '张三', '', '', '', '', 1, '127.0.0.1', '2025-06-11 01:51:48', NULL, 1, 0, NULL, '2025-06-11 03:16:31', '');
INSERT INTO `user` VALUES (5, 'test3', '$2y$10$gqrlgxdJ1jtzn92X3JaNPOK/CPMti5yeqo6XxitBfGSrQOA3JeAQi', '200', '张三', '', '', '', '', 1, '127.0.0.1', '2025-06-11 01:54:27', NULL, 1, 0, '2025-06-11 02:54:28', '2025-06-11 02:54:28', '');
INSERT INTO `user` VALUES (6, 'test6', '$2y$10$scdrkdlthmXiMYzbO/bff.Bh/MTpBhhu6Derb5dVK/3VllavPk3tK', '200', '张三', '', '', '', '', 1, '127.0.0.1', '2025-06-11 04:11:27', NULL, 1, 0, '2025-06-11 05:11:27', '2025-06-11 05:11:27', '');
INSERT INTO `user` VALUES (7, 'test7', '$2y$10$JoEi4Z5Joxh7vsOeYtDRjuZDJv5F/5Y4fPqvCp.ZUlVsl9ItJv1u2', '200', '张三', '', '', '', '', 1, '127.0.0.1', '2025-06-11 04:15:19', NULL, 1, 0, '2025-06-11 05:15:19', '2025-06-11 05:15:19', '');
INSERT INTO `user` VALUES (8, 'test0', '$2y$10$QijZN6iI/LnjNg.DgKXzgu/qh/HJn2IO.hTEIKqq7gxKjLy1RCsq2', '200', '张三', '', '', '', '', 1, '127.0.0.1', '2025-06-11 04:17:33', NULL, 1, 0, '2025-06-11 05:17:33', '2025-06-11 05:17:33', '');
INSERT INTO `user` VALUES (10, 'test23', '$2y$10$TCicjhrgEcjP.l0S2oMLUexYS1GzlggxZXbzuCr3c7CGkjBls/JNe', '200', '张三', '', '', '', '', 1, '127.0.0.1', '2025-06-11 04:41:30', NULL, 1, 0, '2025-06-11 05:41:30', '2025-06-11 05:41:30', '');
INSERT INTO `user` VALUES (13, 'test31', '$2y$10$wiv.BzXRJ6909PsUFaHGnuZufWzbbhwstmpPg2icpNrswXZcYCxrC', '200', '张三', '', '', '', '', 1, '127.0.0.1', '2025-06-13 03:43:12', NULL, 1, 0, '2025-06-13 04:43:12', '2025-06-13 04:43:12', '');

-- ----------------------------
-- Table structure for user_belongs_role
-- ----------------------------
DROP TABLE IF EXISTS `user_belongs_role`;
CREATE TABLE `user_belongs_role`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL COMMENT '用户id',
  `role_id` bigint(20) NOT NULL COMMENT '角色id',
  `created_at` datetime NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of user_belongs_role
-- ----------------------------
INSERT INTO `user_belongs_role` VALUES (1, 1, 1, NULL, NULL);
INSERT INTO `user_belongs_role` VALUES (2, 4, 2, NULL, NULL);
INSERT INTO `user_belongs_role` VALUES (3, 5, 2, NULL, NULL);

-- ----------------------------
-- Table structure for user_dept
-- ----------------------------
DROP TABLE IF EXISTS `user_dept`;
CREATE TABLE `user_dept`  (
  `user_id` bigint(20) NOT NULL,
  `dept_id` bigint(20) NOT NULL,
  `created_at` datetime NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = '用户-部门关联表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of user_dept
-- ----------------------------

-- ----------------------------
-- Table structure for user_login_log
-- ----------------------------
DROP TABLE IF EXISTS `user_login_log`;
CREATE TABLE `user_login_log`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键',
  `username` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '用户名',
  `ip` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '登录IP地址',
  `os` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '操作系统',
  `browser` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '浏览器',
  `status` smallint(6) NOT NULL DEFAULT 1 COMMENT '登录状态 (1成功 2失败)',
  `message` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '提示消息',
  `login_time` datetime NOT NULL COMMENT '登录时间',
  `remark` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `user_login_log_username_index`(`username`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 137 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = '登录日志表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of user_login_log
-- ----------------------------
INSERT INTO `user_login_log` VALUES (1, 'admin', '172.17.0.1', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 1, NULL, '2025-06-05 05:37:25', NULL);
INSERT INTO `user_login_log` VALUES (2, 'admin', '172.17.0.1', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 1, NULL, '2025-06-05 05:49:57', NULL);
INSERT INTO `user_login_log` VALUES (3, 'admin', '172.17.0.1', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36 Edg/137.0.0.0', 1, NULL, '2025-06-06 01:24:41', NULL);
INSERT INTO `user_login_log` VALUES (4, 'superAdmin', '172.17.0.1', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36 Edg/137.0.0.0', 1, NULL, '2025-06-12 02:15:00', NULL);
INSERT INTO `user_login_log` VALUES (5, 'superAdmin', '172.17.0.1', 'Other', 'PostmanRuntime-ApipostRuntime/1.1.0', 1, NULL, '2025-06-12 16:37:01', NULL);
INSERT INTO `user_login_log` VALUES (6, 'superAdmin', '172.17.0.1', 'Other', 'PostmanRuntime-ApipostRuntime/1.1.0', 1, NULL, '2025-06-12 17:39:48', NULL);
INSERT INTO `user_login_log` VALUES (7, 'superAdmin', '172.17.0.1', 'Other', 'PostmanRuntime-ApipostRuntime/1.1.0', 1, NULL, '2025-06-12 19:05:48', NULL);
INSERT INTO `user_login_log` VALUES (8, 'superAdmin', '172.17.0.1', 'Other', 'PostmanRuntime-ApipostRuntime/1.1.0', 1, NULL, '2025-06-12 19:33:53', NULL);
INSERT INTO `user_login_log` VALUES (9, 'superAdmin', '172.17.0.1', 'Other', 'PostmanRuntime-ApipostRuntime/1.1.0', 1, NULL, '2025-06-12 19:38:33', NULL);
INSERT INTO `user_login_log` VALUES (10, 'superAdmin', '172.17.0.1', 'Other', 'PostmanRuntime-ApipostRuntime/1.1.0', 1, NULL, '2025-06-12 19:41:55', NULL);
INSERT INTO `user_login_log` VALUES (11, 'superAdmin', '172.17.0.1', 'Other', 'PostmanRuntime-ApipostRuntime/1.1.0', 1, NULL, '2025-06-12 19:42:59', NULL);
INSERT INTO `user_login_log` VALUES (12, 'superAdmin', '172.17.0.1', 'Other', 'PostmanRuntime-ApipostRuntime/1.1.0', 1, NULL, '2025-06-13 02:55:04', NULL);
INSERT INTO `user_login_log` VALUES (13, 'superAdmin', '172.17.0.1', 'Other', 'PostmanRuntime-ApipostRuntime/1.1.0', 1, NULL, '2025-06-13 03:54:20', NULL);
INSERT INTO `user_login_log` VALUES (14, 'superAdmin', '172.17.0.1', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 1, NULL, '2025-06-14 01:41:58', NULL);
INSERT INTO `user_login_log` VALUES (15, 'superAdmin', '172.17.0.1', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 1, NULL, '2025-06-14 01:42:57', NULL);
INSERT INTO `user_login_log` VALUES (16, 'superAdmin', '172.17.0.1', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 1, NULL, '2025-06-14 01:43:35', NULL);
INSERT INTO `user_login_log` VALUES (17, 'admin', '172.17.0.1', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 1, NULL, '2025-06-14 01:45:33', NULL);
INSERT INTO `user_login_log` VALUES (18, 'admin', '172.17.0.1', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36 Edg/137.0.0.0', 1, NULL, '2025-06-13 17:52:41', NULL);
INSERT INTO `user_login_log` VALUES (19, 'admin', '172.17.0.1', 'Other', 'PostmanRuntime-ApipostRuntime/1.1.0', 1, NULL, '2025-06-14 14:40:44', NULL);
INSERT INTO `user_login_log` VALUES (20, 'admin', '172.17.0.1', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36 Edg/137.0.0.0', 1, NULL, '2025-06-14 15:06:57', NULL);
INSERT INTO `user_login_log` VALUES (21, 'admin', '172.17.0.1', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 1, NULL, '2025-06-14 15:50:19', NULL);
INSERT INTO `user_login_log` VALUES (22, 'admin', '172.17.0.1', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 1, NULL, '2025-06-14 16:23:06', NULL);
INSERT INTO `user_login_log` VALUES (23, 'admin', '172.17.0.1', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36 Edg/137.0.0.0', 1, NULL, '2025-06-17 08:29:26', NULL);
INSERT INTO `user_login_log` VALUES (24, 'admin', '172.17.0.1', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 1, NULL, '2025-06-17 15:32:19', NULL);
INSERT INTO `user_login_log` VALUES (25, 'admin', '172.17.0.1', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 1, NULL, '2025-06-17 15:41:31', NULL);
INSERT INTO `user_login_log` VALUES (26, 'admin', '172.17.0.1', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 1, NULL, '2025-06-17 16:57:00', NULL);
INSERT INTO `user_login_log` VALUES (27, 'admin', '172.17.0.1', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36 Edg/137.0.0.0', 1, NULL, '2025-06-20 13:55:17', NULL);
INSERT INTO `user_login_log` VALUES (28, 'admin', '172.17.0.1', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36 Edg/137.0.0.0', 1, NULL, '2025-06-20 13:55:26', NULL);
INSERT INTO `user_login_log` VALUES (29, 'admin', '160.30.128.222', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 1, NULL, '2025-06-21 07:15:04', NULL);
INSERT INTO `user_login_log` VALUES (30, 'admin', '160.30.128.223', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 1, NULL, '2025-06-21 07:16:25', NULL);
INSERT INTO `user_login_log` VALUES (31, 'admin', '160.30.128.222', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 1, NULL, '2025-06-21 07:22:04', NULL);
INSERT INTO `user_login_log` VALUES (32, 'admin', '160.30.128.222', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 1, NULL, '2025-06-21 07:22:26', NULL);
INSERT INTO `user_login_log` VALUES (33, 'admin', '160.30.128.223', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 1, NULL, '2025-06-21 07:28:29', NULL);
INSERT INTO `user_login_log` VALUES (34, 'admin', '160.30.128.223', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 1, NULL, '2025-06-21 07:32:47', NULL);
INSERT INTO `user_login_log` VALUES (35, 'admin', '160.30.128.223', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 1, NULL, '2025-06-21 07:33:01', NULL);
INSERT INTO `user_login_log` VALUES (36, 'admin', '160.30.128.224', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 1, NULL, '2025-06-21 07:39:02', NULL);
INSERT INTO `user_login_log` VALUES (37, 'admin', '103.43.162.133', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 1, NULL, '2025-06-21 07:43:13', NULL);
INSERT INTO `user_login_log` VALUES (38, 'admin', '103.43.162.134', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 1, NULL, '2025-06-21 07:44:17', NULL);
INSERT INTO `user_login_log` VALUES (39, 'admin', '103.43.162.133', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 1, NULL, '2025-06-21 07:49:10', NULL);
INSERT INTO `user_login_log` VALUES (40, 'admin', '103.43.162.135', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 1, NULL, '2025-06-21 07:49:15', NULL);
INSERT INTO `user_login_log` VALUES (41, 'admin', '103.43.162.135', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 1, NULL, '2025-06-21 07:49:19', NULL);
INSERT INTO `user_login_log` VALUES (42, 'admin', '103.43.162.133', 'Other', 'PostmanRuntime-ApipostRuntime/1.1.0', 1, NULL, '2025-06-21 08:07:23', NULL);
INSERT INTO `user_login_log` VALUES (43, 'admin', '103.43.162.135', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 1, NULL, '2025-06-21 08:07:37', NULL);
INSERT INTO `user_login_log` VALUES (44, 'admin', '103.43.162.135', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 1, NULL, '2025-06-21 08:18:02', NULL);
INSERT INTO `user_login_log` VALUES (45, 'admin', '103.43.162.137', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 1, NULL, '2025-06-21 08:19:00', NULL);
INSERT INTO `user_login_log` VALUES (46, 'admin', '103.43.162.136', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 1, NULL, '2025-06-21 08:27:49', NULL);
INSERT INTO `user_login_log` VALUES (47, 'admin', '103.43.162.135', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 1, NULL, '2025-06-21 08:28:41', NULL);
INSERT INTO `user_login_log` VALUES (48, 'admin', '103.43.162.136', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 1, NULL, '2025-06-21 08:29:21', NULL);
INSERT INTO `user_login_log` VALUES (49, 'admin', '103.43.162.136', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 1, NULL, '2025-06-21 08:29:38', NULL);
INSERT INTO `user_login_log` VALUES (50, 'admin', '103.43.162.134', 'Other', 'PostmanRuntime-ApipostRuntime/1.1.0', 1, NULL, '2025-06-21 08:30:24', NULL);
INSERT INTO `user_login_log` VALUES (51, 'admin', '103.43.162.135', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 1, NULL, '2025-06-21 08:37:04', NULL);
INSERT INTO `user_login_log` VALUES (52, 'admin', '103.43.162.134', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 1, NULL, '2025-06-21 08:39:19', NULL);
INSERT INTO `user_login_log` VALUES (53, 'admin', '185.36.195.248', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 1, NULL, '2025-06-21 08:52:53', NULL);
INSERT INTO `user_login_log` VALUES (54, 'admin', '185.36.195.248', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 1, NULL, '2025-06-21 08:55:21', NULL);
INSERT INTO `user_login_log` VALUES (55, 'admin', '185.36.195.254', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36 Edg/137.0.0.0', 1, NULL, '2025-06-21 09:07:41', NULL);
INSERT INTO `user_login_log` VALUES (56, 'admin', '185.36.195.248', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 1, NULL, '2025-06-21 09:11:54', NULL);
INSERT INTO `user_login_log` VALUES (57, 'admin', '101.44.81.5', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36 Edg/137.0.0.0', 1, NULL, '2025-06-22 02:27:27', NULL);
INSERT INTO `user_login_log` VALUES (58, 'admin', '172.17.0.1', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36 Edg/137.0.0.0', 1, NULL, '2025-06-22 02:53:06', NULL);
INSERT INTO `user_login_log` VALUES (59, 'admin', '172.17.0.1', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36 Edg/137.0.0.0', 1, NULL, '2025-06-22 02:53:14', NULL);
INSERT INTO `user_login_log` VALUES (60, 'admin', '172.17.0.1', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36 Edg/137.0.0.0', 1, NULL, '2025-06-22 03:00:09', NULL);
INSERT INTO `user_login_log` VALUES (61, 'admin', '172.17.0.1', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36 Edg/137.0.0.0', 1, NULL, '2025-06-22 04:01:09', NULL);
INSERT INTO `user_login_log` VALUES (62, 'admin', '160.30.128.220', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 1, NULL, '2025-06-22 04:43:53', NULL);
INSERT INTO `user_login_log` VALUES (63, 'admin', '172.17.0.1', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36 Edg/137.0.0.0', 1, NULL, '2025-06-23 01:06:56', NULL);
INSERT INTO `user_login_log` VALUES (64, 'admin', '172.17.0.1', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 1, NULL, '2025-06-23 08:15:29', NULL);
INSERT INTO `user_login_log` VALUES (65, 'admin', '172.17.0.1', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 1, NULL, '2025-06-23 09:18:42', NULL);
INSERT INTO `user_login_log` VALUES (66, 'admin', '172.17.0.1', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 1, NULL, '2025-06-23 10:33:37', NULL);
INSERT INTO `user_login_log` VALUES (67, 'admin', '101.44.80.31', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 1, NULL, '2025-06-23 11:33:13', NULL);
INSERT INTO `user_login_log` VALUES (68, 'admin', '172.17.0.1', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 1, NULL, '2025-06-23 12:35:24', NULL);
INSERT INTO `user_login_log` VALUES (69, 'admin', '172.17.0.1', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36 Edg/137.0.0.0', 1, NULL, '2025-06-23 12:40:03', NULL);
INSERT INTO `user_login_log` VALUES (70, 'admin', '172.17.0.1', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 1, NULL, '2025-06-23 12:40:18', NULL);
INSERT INTO `user_login_log` VALUES (71, 'admin', '172.17.0.1', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36 Edg/137.0.0.0', 1, NULL, '2025-06-23 12:41:56', NULL);
INSERT INTO `user_login_log` VALUES (72, 'admin', '172.17.0.1', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 1, NULL, '2025-06-23 14:12:07', NULL);
INSERT INTO `user_login_log` VALUES (73, 'admin', '172.17.0.1', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36 Edg/137.0.0.0', 1, NULL, '2025-06-23 14:13:14', NULL);
INSERT INTO `user_login_log` VALUES (74, 'admin', '165.154.157.237', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 1, NULL, '2025-06-24 01:43:57', NULL);
INSERT INTO `user_login_log` VALUES (75, 'admin', '172.17.0.1', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36 Edg/137.0.0.0', 1, NULL, '2025-06-24 02:10:54', NULL);
INSERT INTO `user_login_log` VALUES (76, 'admin', '172.17.0.1', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36 Edg/137.0.0.0', 1, NULL, '2025-06-24 02:26:01', NULL);
INSERT INTO `user_login_log` VALUES (77, 'admin', '172.17.0.1', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36 Edg/137.0.0.0', 1, NULL, '2025-06-24 07:39:10', NULL);
INSERT INTO `user_login_log` VALUES (78, 'admin', '172.17.0.1', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36 Edg/137.0.0.0', 1, NULL, '2025-06-24 08:41:02', NULL);
INSERT INTO `user_login_log` VALUES (79, 'admin', '172.17.0.1', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 1, NULL, '2025-06-24 08:42:44', NULL);
INSERT INTO `user_login_log` VALUES (80, 'admin', '172.17.0.1', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 1, NULL, '2025-06-24 09:43:37', NULL);
INSERT INTO `user_login_log` VALUES (81, 'admin', '172.17.0.1', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36 Edg/137.0.0.0', 1, NULL, '2025-06-24 09:55:19', NULL);
INSERT INTO `user_login_log` VALUES (82, 'admin', '172.17.0.1', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 1, NULL, '2025-06-24 09:56:40', NULL);
INSERT INTO `user_login_log` VALUES (83, 'admin', '103.97.2.8', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 1, NULL, '2025-06-24 15:09:18', NULL);
INSERT INTO `user_login_log` VALUES (84, 'admin', '172.17.0.1', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36 Edg/137.0.0.0', 1, NULL, '2025-06-24 19:53:32', NULL);
INSERT INTO `user_login_log` VALUES (85, 'admin', '172.17.0.1', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36 Edg/137.0.0.0', 1, NULL, '2025-06-25 04:09:53', NULL);
INSERT INTO `user_login_log` VALUES (86, 'admin', '172.17.0.1', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36 Edg/137.0.0.0', 1, NULL, '2025-06-25 05:10:13', NULL);
INSERT INTO `user_login_log` VALUES (87, 'admin', '172.17.0.1', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36 Edg/137.0.0.0', 1, NULL, '2025-06-25 06:12:32', NULL);
INSERT INTO `user_login_log` VALUES (88, 'admin', '172.17.0.1', 'Other', 'PostmanRuntime-ApipostRuntime/1.1.0', 1, NULL, '2025-06-25 06:16:33', NULL);
INSERT INTO `user_login_log` VALUES (89, 'admin', '172.17.0.1', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36 Edg/137.0.0.0', 1, NULL, '2025-06-25 06:28:32', NULL);
INSERT INTO `user_login_log` VALUES (90, 'admin', '172.17.0.1', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36 Edg/137.0.0.0', 1, NULL, '2025-06-25 07:33:09', NULL);
INSERT INTO `user_login_log` VALUES (91, 'admin', '172.17.0.1', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36 Edg/137.0.0.0', 1, NULL, '2025-06-25 12:29:04', NULL);
INSERT INTO `user_login_log` VALUES (92, 'admin', '172.17.0.1', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36 Edg/137.0.0.0', 1, NULL, '2025-06-25 17:59:14', NULL);
INSERT INTO `user_login_log` VALUES (93, 'admin', '172.17.0.1', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 1, NULL, '2025-06-25 17:59:32', NULL);
INSERT INTO `user_login_log` VALUES (94, 'admin', '172.17.0.1', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36 Edg/137.0.0.0', 1, NULL, '2025-06-25 18:03:15', NULL);
INSERT INTO `user_login_log` VALUES (95, 'admin', '172.17.0.1', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 1, NULL, '2025-06-25 18:05:59', NULL);
INSERT INTO `user_login_log` VALUES (96, 'admin', '172.17.0.1', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36 Edg/137.0.0.0', 1, NULL, '2025-06-25 18:09:49', NULL);
INSERT INTO `user_login_log` VALUES (97, 'admin', '172.17.0.1', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 1, NULL, '2025-06-25 18:12:51', NULL);
INSERT INTO `user_login_log` VALUES (98, 'admin', '172.17.0.1', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 1, NULL, '2025-06-25 23:46:47', NULL);
INSERT INTO `user_login_log` VALUES (99, 'admin', '172.17.0.1', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36 Edg/137.0.0.0', 1, NULL, '2025-06-25 23:47:14', NULL);
INSERT INTO `user_login_log` VALUES (100, 'admin', '172.17.0.1', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 1, NULL, '2025-06-26 00:39:15', NULL);
INSERT INTO `user_login_log` VALUES (101, 'admin', '172.17.0.1', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36 Edg/137.0.0.0', 1, NULL, '2025-06-26 00:43:42', NULL);
INSERT INTO `user_login_log` VALUES (102, 'admin', '172.17.0.1', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 1, NULL, '2025-06-26 00:45:30', NULL);
INSERT INTO `user_login_log` VALUES (103, 'admin', '172.17.0.1', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36 Edg/137.0.0.0', 1, NULL, '2025-06-26 00:46:19', NULL);
INSERT INTO `user_login_log` VALUES (104, 'admin', '172.17.0.1', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36 Edg/137.0.0.0', 1, NULL, '2025-06-26 00:54:54', NULL);
INSERT INTO `user_login_log` VALUES (105, 'admin', '172.17.0.1', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 1, NULL, '2025-06-26 00:56:06', NULL);
INSERT INTO `user_login_log` VALUES (106, 'admin', '172.17.0.1', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36 Edg/137.0.0.0', 1, NULL, '2025-06-26 01:01:29', NULL);
INSERT INTO `user_login_log` VALUES (107, 'admin', '172.17.0.1', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 1, NULL, '2025-06-26 01:01:40', NULL);
INSERT INTO `user_login_log` VALUES (108, 'admin', '172.17.0.1', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36 Edg/137.0.0.0', 1, NULL, '2025-06-26 01:02:44', NULL);
INSERT INTO `user_login_log` VALUES (109, 'admin', '172.17.0.1', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 1, NULL, '2025-06-26 01:03:02', NULL);
INSERT INTO `user_login_log` VALUES (110, 'admin', '172.17.0.1', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 1, NULL, '2025-06-26 05:46:18', NULL);
INSERT INTO `user_login_log` VALUES (111, 'admin', '172.17.0.1', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 1, NULL, '2025-06-26 05:49:44', NULL);
INSERT INTO `user_login_log` VALUES (112, 'admin', '172.17.0.1', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 1, NULL, '2025-06-26 06:53:37', NULL);
INSERT INTO `user_login_log` VALUES (113, 'admin', '172.17.0.1', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36 Edg/137.0.0.0', 1, NULL, '2025-06-26 08:09:25', NULL);
INSERT INTO `user_login_log` VALUES (114, 'admin', '172.17.0.1', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 1, NULL, '2025-06-26 08:09:49', NULL);
INSERT INTO `user_login_log` VALUES (115, 'admin', '172.17.0.1', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36 Edg/137.0.0.0', 1, NULL, '2025-06-26 08:13:02', NULL);
INSERT INTO `user_login_log` VALUES (116, 'admin', '172.17.0.1', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36 Edg/137.0.0.0', 1, NULL, '2025-06-26 08:16:41', NULL);
INSERT INTO `user_login_log` VALUES (117, 'admin', '172.17.0.1', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 1, NULL, '2025-06-26 08:17:01', NULL);
INSERT INTO `user_login_log` VALUES (118, 'admin', '172.17.0.1', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36 Edg/137.0.0.0', 1, NULL, '2025-06-26 08:33:31', NULL);
INSERT INTO `user_login_log` VALUES (119, 'admin', '172.17.0.1', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 1, NULL, '2025-06-26 08:34:06', NULL);
INSERT INTO `user_login_log` VALUES (120, 'admin', '172.17.0.1', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36 Edg/137.0.0.0', 1, NULL, '2025-06-26 08:41:12', NULL);
INSERT INTO `user_login_log` VALUES (121, 'admin', '172.17.0.1', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 1, NULL, '2025-06-26 08:43:13', NULL);
INSERT INTO `user_login_log` VALUES (122, 'admin', '172.17.0.1', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36 Edg/137.0.0.0', 1, NULL, '2025-06-26 09:33:20', NULL);
INSERT INTO `user_login_log` VALUES (123, 'admin', '172.17.0.1', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 1, NULL, '2025-06-26 09:46:16', NULL);
INSERT INTO `user_login_log` VALUES (124, 'admin', '172.17.0.1', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36 Edg/137.0.0.0', 1, NULL, '2025-06-26 10:32:08', NULL);
INSERT INTO `user_login_log` VALUES (125, 'admin', '172.17.0.1', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 1, NULL, '2025-06-26 10:35:33', NULL);
INSERT INTO `user_login_log` VALUES (126, 'admin', '172.17.0.1', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 1, NULL, '2025-06-26 13:36:42', NULL);
INSERT INTO `user_login_log` VALUES (127, 'admin', '172.17.0.1', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 1, NULL, '2025-06-26 13:56:25', NULL);
INSERT INTO `user_login_log` VALUES (128, 'admin', '172.17.0.1', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36 Edg/137.0.0.0', 1, NULL, '2025-06-26 18:44:57', NULL);
INSERT INTO `user_login_log` VALUES (129, 'admin', '172.17.0.1', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 1, NULL, '2025-06-26 18:57:21', NULL);
INSERT INTO `user_login_log` VALUES (130, 'admin', '172.17.0.1', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 1, NULL, '2025-06-26 19:05:31', NULL);
INSERT INTO `user_login_log` VALUES (131, 'admin', '172.17.0.1', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36 Edg/137.0.0.0', 1, NULL, '2025-06-26 23:50:31', NULL);
INSERT INTO `user_login_log` VALUES (132, 'admin', '172.17.0.1', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 1, NULL, '2025-06-27 00:02:50', NULL);
INSERT INTO `user_login_log` VALUES (133, 'admin', '172.17.0.1', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 1, NULL, '2025-06-27 02:13:01', NULL);
INSERT INTO `user_login_log` VALUES (134, 'admin', '172.17.0.1', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36 Edg/137.0.0.0', 1, NULL, '2025-06-27 02:21:46', NULL);
INSERT INTO `user_login_log` VALUES (135, 'admin', '172.17.0.1', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 1, NULL, '2025-06-27 02:23:41', NULL);
INSERT INTO `user_login_log` VALUES (136, 'admin', '222.182.112.77', 'Other', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 1, NULL, '2025-06-27 02:44:48', NULL);

-- ----------------------------
-- Table structure for user_operation_log
-- ----------------------------
DROP TABLE IF EXISTS `user_operation_log`;
CREATE TABLE `user_operation_log`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '用户名',
  `method` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '请求方式',
  `router` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '请求路由',
  `service_name` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '业务名称',
  `ip` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '请求IP地址',
  `created_at` timestamp NULL DEFAULT NULL COMMENT '创建时间',
  `updated_at` timestamp NULL DEFAULT NULL COMMENT '更新时间',
  `remark` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '备注',
  `request_params` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL COMMENT '请求参数',
  `response_status` int(11) NULL DEFAULT NULL COMMENT '响应状态码',
  `is_success` tinyint(1) NULL DEFAULT 1 COMMENT '操作是否成功(1:成功,0:失败)',
  `response_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL COMMENT '响应数据',
  `operator_id` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '操作者ID',
  `request_id` varchar(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT '' COMMENT 'uuid',
  `request_duration` bigint(20) UNSIGNED NULL DEFAULT NULL COMMENT '请求耗时(毫秒)',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `user_operation_log_username_index`(`username`) USING BTREE,
  INDEX `user_operation_log_created_at_index`(`created_at`) USING BTREE,
  INDEX `user_operation_log_service_name_index`(`service_name`) USING BTREE,
  INDEX `user_operation_log_operator_id_index`(`operator_id`) USING BTREE,
  INDEX `user_operation_log_operator_id_created_at_index`(`operator_id`, `created_at`) USING BTREE,
  INDEX `user_operation_log_created_at_service_name_index`(`created_at`, `service_name`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 214 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = '操作日志表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of user_operation_log
-- ----------------------------
INSERT INTO `user_operation_log` VALUES (1, 'admin', 'GET', '/admin/department/list', '部门列表', '172.17.0.1', '2025-06-05 05:41:42', '2025-06-05 05:41:42', '', NULL, NULL, 1, NULL, NULL, NULL, NULL);
INSERT INTO `user_operation_log` VALUES (2, 'admin', 'GET', '/admin/department/list', '部门列表', '172.17.0.1', '2025-06-05 05:41:50', '2025-06-05 05:41:50', '', NULL, NULL, 1, NULL, NULL, NULL, NULL);
INSERT INTO `user_operation_log` VALUES (3, 'admin', 'GET', '/admin/attachment/list', '附件列表', '172.17.0.1', '2025-06-05 05:42:16', '2025-06-05 05:42:16', '', NULL, NULL, 1, NULL, NULL, NULL, NULL);
INSERT INTO `user_operation_log` VALUES (4, 'admin', 'POST', '/admin/attachment/upload', '上传附件', '172.17.0.1', '2025-06-05 05:43:17', '2025-06-05 05:43:17', '', NULL, NULL, 1, NULL, NULL, NULL, NULL);
INSERT INTO `user_operation_log` VALUES (5, 'admin', 'GET', '/admin/attachment/list', '附件列表', '172.17.0.1', '2025-06-05 05:43:19', '2025-06-05 05:43:19', '', NULL, NULL, 1, NULL, NULL, NULL, NULL);
INSERT INTO `user_operation_log` VALUES (6, 'admin', 'DELETE', '/admin/attachment/1', '@OA\\Generator::UNDEFINED🙈', '172.17.0.1', '2025-06-05 05:43:38', '2025-06-05 05:43:38', '', NULL, NULL, 1, NULL, NULL, NULL, NULL);
INSERT INTO `user_operation_log` VALUES (7, 'admin', 'GET', '/admin/attachment/list', '附件列表', '172.17.0.1', '2025-06-05 05:43:39', '2025-06-05 05:43:39', '', NULL, NULL, 1, NULL, NULL, NULL, NULL);
INSERT INTO `user_operation_log` VALUES (8, 'admin', 'POST', '/admin/attachment/upload', '上传附件', '172.17.0.1', '2025-06-05 05:43:59', '2025-06-05 05:43:59', '', NULL, NULL, 1, NULL, NULL, NULL, NULL);
INSERT INTO `user_operation_log` VALUES (9, 'admin', 'GET', '/admin/attachment/list', '附件列表', '172.17.0.1', '2025-06-05 05:44:01', '2025-06-05 05:44:01', '', NULL, NULL, 1, NULL, NULL, NULL, NULL);
INSERT INTO `user_operation_log` VALUES (10, 'admin', 'GET', '/admin/attachment/list', '附件列表', '172.17.0.1', '2025-06-05 05:44:23', '2025-06-05 05:44:23', '', NULL, NULL, 1, NULL, NULL, NULL, NULL);
INSERT INTO `user_operation_log` VALUES (11, 'admin', 'GET', '/admin/attachment/list', '附件列表', '172.17.0.1', '2025-06-05 05:44:27', '2025-06-05 05:44:27', '', NULL, NULL, 1, NULL, NULL, NULL, NULL);
INSERT INTO `user_operation_log` VALUES (12, 'admin', 'GET', '/admin/attachment/list', '附件列表', '172.17.0.1', '2025-06-05 05:44:29', '2025-06-05 05:44:29', '', NULL, NULL, 1, NULL, NULL, NULL, NULL);
INSERT INTO `user_operation_log` VALUES (13, 'admin', 'GET', '/admin/attachment/list', '附件列表', '172.17.0.1', '2025-06-05 05:50:01', '2025-06-05 05:50:01', '', NULL, NULL, 1, NULL, NULL, NULL, NULL);
INSERT INTO `user_operation_log` VALUES (14, 'admin', 'GET', '/admin/attachment/list', '附件列表', '172.17.0.1', '2025-06-05 05:54:51', '2025-06-05 05:54:51', '', NULL, NULL, 1, NULL, NULL, NULL, NULL);
INSERT INTO `user_operation_log` VALUES (15, 'admin', 'GET', '/admin/user/list', '用户列表', '172.17.0.1', '2025-06-05 05:55:56', '2025-06-05 05:55:56', '', NULL, NULL, 1, NULL, NULL, NULL, NULL);
INSERT INTO `user_operation_log` VALUES (16, 'admin', 'GET', '/admin/department/list', '部门列表', '172.17.0.1', '2025-06-05 05:55:56', '2025-06-05 05:55:56', '', NULL, NULL, 1, NULL, NULL, NULL, NULL);
INSERT INTO `user_operation_log` VALUES (17, 'admin', 'GET', '/admin/attachment/list', '附件列表', '172.17.0.1', '2025-06-06 01:25:41', '2025-06-06 01:25:41', '', NULL, NULL, 1, NULL, NULL, NULL, NULL);
INSERT INTO `user_operation_log` VALUES (18, 'no_login_user', 'GET', '/admin/role/list', '获取角色', '172.17.0.1', '2025-06-12 19:16:07', '2025-06-12 19:16:07', NULL, '[]', 200, 0, '{\"request_id\":\"a7a45d84-31db-4bb2-a4c8-585a00b2078e\",\"path\":\"\\/admin\\/role\\/list\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\",\"data\":{\"list\":[{\"id\":1,\"name\":\"\\u8d85\\u7ea7\\u7ba1\\u7406\\u5458\",\"code\":\"SuperAdmin\",\"status\":1,\"sort\":0,\"created_by\":0,\"updated_by\":0,\"created_at\":\"2025-06-04T21:30:40.000000Z\",\"updated_at\":\"2025-06-04T21:30:40.000000Z\",\"remark\":\"\"},{\"id\":2,\"name\":\"test\",\"code\":\"test\",\"status\":1,\"sort\":0,\"created_by\":0,\"updated_by\":0,\"created_at\":null,\"updated_at\":null,\"remark\":\"\"},{\"id\":3,\"name\":\"ddd\",\"code\":\"wwe\",\"status\":1,\"sort\":2,\"created_by\":1,\"updated_by\":1,\"created_at\":null,\"updated_at\":null,\"remark\":\"\"},{\"id\":5,\"name\":\"haha\",\"code\":\"hahas\",\"status\":1,\"sort\":2,\"created_by\":1,\"updated_by\":0,\"created_at\":null,\"updated_at\":null,\"remark\":\"\"},{\"id\":6,\"name\":\"ddd\",\"code\":\"ww\",\"status\":1,\"sort\":4,\"created_by\":1,\"updated_by\":0,\"created_at\":null,\"updated_at\":null,\"remark\":\"\"}],\"total\":5}}', 0, NULL, NULL);
INSERT INTO `user_operation_log` VALUES (19, 'no_login_user', 'GET', '/admin/role/list', '获取角色', '172.17.0.1', '2025-06-12 19:16:10', '2025-06-12 19:16:10', NULL, '[]', 200, 0, '{\"request_id\":\"c3c24768-4683-411f-80be-cd4afeb69998\",\"path\":\"\\/admin\\/role\\/list\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\",\"data\":{\"list\":[{\"id\":1,\"name\":\"\\u8d85\\u7ea7\\u7ba1\\u7406\\u5458\",\"code\":\"SuperAdmin\",\"status\":1,\"sort\":0,\"created_by\":0,\"updated_by\":0,\"created_at\":\"2025-06-04T21:30:40.000000Z\",\"updated_at\":\"2025-06-04T21:30:40.000000Z\",\"remark\":\"\"},{\"id\":2,\"name\":\"test\",\"code\":\"test\",\"status\":1,\"sort\":0,\"created_by\":0,\"updated_by\":0,\"created_at\":null,\"updated_at\":null,\"remark\":\"\"},{\"id\":3,\"name\":\"ddd\",\"code\":\"wwe\",\"status\":1,\"sort\":2,\"created_by\":1,\"updated_by\":1,\"created_at\":null,\"updated_at\":null,\"remark\":\"\"},{\"id\":5,\"name\":\"haha\",\"code\":\"hahas\",\"status\":1,\"sort\":2,\"created_by\":1,\"updated_by\":0,\"created_at\":null,\"updated_at\":null,\"remark\":\"\"},{\"id\":6,\"name\":\"ddd\",\"code\":\"ww\",\"status\":1,\"sort\":4,\"created_by\":1,\"updated_by\":0,\"created_at\":null,\"updated_at\":null,\"remark\":\"\"}],\"total\":5}}', 0, NULL, NULL);
INSERT INTO `user_operation_log` VALUES (20, 'no_login_user', 'GET', '/admin/role/list', '获取角色', '172.17.0.1', '2025-06-12 19:16:44', '2025-06-12 19:16:44', NULL, '[]', 200, 0, '{\"request_id\":\"d321197b-e1ff-46de-96ff-ffa58265b589\",\"path\":\"\\/admin\\/role\\/list\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\",\"data\":{\"list\":[{\"id\":1,\"name\":\"\\u8d85\\u7ea7\\u7ba1\\u7406\\u5458\",\"code\":\"SuperAdmin\",\"status\":1,\"sort\":0,\"created_by\":0,\"updated_by\":0,\"created_at\":\"2025-06-04T21:30:40.000000Z\",\"updated_at\":\"2025-06-04T21:30:40.000000Z\",\"remark\":\"\"},{\"id\":2,\"name\":\"test\",\"code\":\"test\",\"status\":1,\"sort\":0,\"created_by\":0,\"updated_by\":0,\"created_at\":null,\"updated_at\":null,\"remark\":\"\"},{\"id\":3,\"name\":\"ddd\",\"code\":\"wwe\",\"status\":1,\"sort\":2,\"created_by\":1,\"updated_by\":1,\"created_at\":null,\"updated_at\":null,\"remark\":\"\"},{\"id\":5,\"name\":\"haha\",\"code\":\"hahas\",\"status\":1,\"sort\":2,\"created_by\":1,\"updated_by\":0,\"created_at\":null,\"updated_at\":null,\"remark\":\"\"},{\"id\":6,\"name\":\"ddd\",\"code\":\"ww\",\"status\":1,\"sort\":4,\"created_by\":1,\"updated_by\":0,\"created_at\":null,\"updated_at\":null,\"remark\":\"\"}],\"total\":5}}', 0, NULL, NULL);
INSERT INTO `user_operation_log` VALUES (21, 'no_login_user', 'GET', '/admin/role/list', '获取角色', '172.17.0.1', '2025-06-12 19:19:41', '2025-06-12 19:19:41', NULL, '[]', 200, 0, '{\"request_id\":\"5e8f8c90-bd37-45c9-9639-301ce9ef2be1\",\"path\":\"\\/admin\\/role\\/list\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\",\"data\":{\"list\":[{\"id\":1,\"name\":\"\\u8d85\\u7ea7\\u7ba1\\u7406\\u5458\",\"code\":\"SuperAdmin\",\"status\":1,\"sort\":0,\"created_by\":0,\"updated_by\":0,\"created_at\":\"2025-06-04T21:30:40.000000Z\",\"updated_at\":\"2025-06-04T21:30:40.000000Z\",\"remark\":\"\"},{\"id\":2,\"name\":\"test\",\"code\":\"test\",\"status\":1,\"sort\":0,\"created_by\":0,\"updated_by\":0,\"created_at\":null,\"updated_at\":null,\"remark\":\"\"},{\"id\":3,\"name\":\"ddd\",\"code\":\"wwe\",\"status\":1,\"sort\":2,\"created_by\":1,\"updated_by\":1,\"created_at\":null,\"updated_at\":null,\"remark\":\"\"},{\"id\":5,\"name\":\"haha\",\"code\":\"hahas\",\"status\":1,\"sort\":2,\"created_by\":1,\"updated_by\":0,\"created_at\":null,\"updated_at\":null,\"remark\":\"\"},{\"id\":6,\"name\":\"ddd\",\"code\":\"ww\",\"status\":1,\"sort\":4,\"created_by\":1,\"updated_by\":0,\"created_at\":null,\"updated_at\":null,\"remark\":\"\"}],\"total\":5}}', 0, NULL, NULL);
INSERT INTO `user_operation_log` VALUES (22, 'no_login_user', 'GET', '/admin/role/list', '获取角色', '172.17.0.1', '2025-06-12 19:22:44', '2025-06-12 19:22:44', NULL, '[]', 200, 0, '{\"request_id\":\"37896a59-16d4-4420-a362-98ba3e610816\",\"path\":\"\\/admin\\/role\\/list\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\",\"data\":{\"list\":[{\"id\":1,\"name\":\"\\u8d85\\u7ea7\\u7ba1\\u7406\\u5458\",\"code\":\"SuperAdmin\",\"status\":1,\"sort\":0,\"created_by\":0,\"updated_by\":0,\"created_at\":\"2025-06-04T21:30:40.000000Z\",\"updated_at\":\"2025-06-04T21:30:40.000000Z\",\"remark\":\"\"},{\"id\":2,\"name\":\"test\",\"code\":\"test\",\"status\":1,\"sort\":0,\"created_by\":0,\"updated_by\":0,\"created_at\":null,\"updated_at\":null,\"remark\":\"\"},{\"id\":3,\"name\":\"ddd\",\"code\":\"wwe\",\"status\":1,\"sort\":2,\"created_by\":1,\"updated_by\":1,\"created_at\":null,\"updated_at\":null,\"remark\":\"\"},{\"id\":5,\"name\":\"haha\",\"code\":\"hahas\",\"status\":1,\"sort\":2,\"created_by\":1,\"updated_by\":0,\"created_at\":null,\"updated_at\":null,\"remark\":\"\"},{\"id\":6,\"name\":\"ddd\",\"code\":\"ww\",\"status\":1,\"sort\":4,\"created_by\":1,\"updated_by\":0,\"created_at\":null,\"updated_at\":null,\"remark\":\"\"}],\"total\":5}}', 0, NULL, NULL);
INSERT INTO `user_operation_log` VALUES (23, 'no_login_user', 'GET', '/admin/role/list', '获取角色', '172.17.0.1', '2025-06-12 19:24:26', '2025-06-12 19:24:26', NULL, '[]', 200, 0, '{\"request_id\":\"3e06e931-27f5-400e-a967-899018f3991f\",\"path\":\"\\/admin\\/role\\/list\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\",\"data\":{\"list\":[{\"id\":1,\"name\":\"\\u8d85\\u7ea7\\u7ba1\\u7406\\u5458\",\"code\":\"SuperAdmin\",\"status\":1,\"sort\":0,\"created_by\":0,\"updated_by\":0,\"created_at\":\"2025-06-04T21:30:40.000000Z\",\"updated_at\":\"2025-06-04T21:30:40.000000Z\",\"remark\":\"\"},{\"id\":2,\"name\":\"test\",\"code\":\"test\",\"status\":1,\"sort\":0,\"created_by\":0,\"updated_by\":0,\"created_at\":null,\"updated_at\":null,\"remark\":\"\"},{\"id\":3,\"name\":\"ddd\",\"code\":\"wwe\",\"status\":1,\"sort\":2,\"created_by\":1,\"updated_by\":1,\"created_at\":null,\"updated_at\":null,\"remark\":\"\"},{\"id\":5,\"name\":\"haha\",\"code\":\"hahas\",\"status\":1,\"sort\":2,\"created_by\":1,\"updated_by\":0,\"created_at\":null,\"updated_at\":null,\"remark\":\"\"},{\"id\":6,\"name\":\"ddd\",\"code\":\"ww\",\"status\":1,\"sort\":4,\"created_by\":1,\"updated_by\":0,\"created_at\":null,\"updated_at\":null,\"remark\":\"\"}],\"total\":5}}', 0, NULL, NULL);
INSERT INTO `user_operation_log` VALUES (24, 'superAdmin', 'GET', '/admin/role/list', '获取角色', '172.17.0.1', '2025-06-12 19:30:18', '2025-06-12 19:30:18', NULL, '[]', 200, 0, '{\"request_id\":\"866ff41a-f204-4b78-9604-063d4e18e38c\",\"path\":\"\\/admin\\/role\\/list\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\",\"data\":{\"list\":[{\"id\":1,\"name\":\"\\u8d85\\u7ea7\\u7ba1\\u7406\\u5458\",\"code\":\"SuperAdmin\",\"status\":1,\"sort\":0,\"created_by\":0,\"updated_by\":0,\"created_at\":\"2025-06-04T21:30:40.000000Z\",\"updated_at\":\"2025-06-04T21:30:40.000000Z\",\"remark\":\"\"},{\"id\":2,\"name\":\"test\",\"code\":\"test\",\"status\":1,\"sort\":0,\"created_by\":0,\"updated_by\":0,\"created_at\":null,\"updated_at\":null,\"remark\":\"\"},{\"id\":3,\"name\":\"ddd\",\"code\":\"wwe\",\"status\":1,\"sort\":2,\"created_by\":1,\"updated_by\":1,\"created_at\":null,\"updated_at\":null,\"remark\":\"\"},{\"id\":5,\"name\":\"haha\",\"code\":\"hahas\",\"status\":1,\"sort\":2,\"created_by\":1,\"updated_by\":0,\"created_at\":null,\"updated_at\":null,\"remark\":\"\"},{\"id\":6,\"name\":\"ddd\",\"code\":\"ww\",\"status\":1,\"sort\":4,\"created_by\":1,\"updated_by\":0,\"created_at\":null,\"updated_at\":null,\"remark\":\"\"}],\"total\":5}}', 1, NULL, NULL);
INSERT INTO `user_operation_log` VALUES (25, 'superAdmin', 'GET', '/admin/role/list', '获取角色', '172.17.0.1', '2025-06-12 19:31:35', '2025-06-12 19:31:35', NULL, '[]', 200, 0, '{\"request_id\":\"7f184ac5-ea67-440a-8476-d3da4469bdb1\",\"path\":\"\\/admin\\/role\\/list\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\",\"data\":{\"list\":[{\"id\":1,\"name\":\"\\u8d85\\u7ea7\\u7ba1\\u7406\\u5458\",\"code\":\"SuperAdmin\",\"status\":1,\"sort\":0,\"created_by\":0,\"updated_by\":0,\"created_at\":\"2025-06-04T21:30:40.000000Z\",\"updated_at\":\"2025-06-04T21:30:40.000000Z\",\"remark\":\"\"},{\"id\":2,\"name\":\"test\",\"code\":\"test\",\"status\":1,\"sort\":0,\"created_by\":0,\"updated_by\":0,\"created_at\":null,\"updated_at\":null,\"remark\":\"\"},{\"id\":3,\"name\":\"ddd\",\"code\":\"wwe\",\"status\":1,\"sort\":2,\"created_by\":1,\"updated_by\":1,\"created_at\":null,\"updated_at\":null,\"remark\":\"\"},{\"id\":5,\"name\":\"haha\",\"code\":\"hahas\",\"status\":1,\"sort\":2,\"created_by\":1,\"updated_by\":0,\"created_at\":null,\"updated_at\":null,\"remark\":\"\"},{\"id\":6,\"name\":\"ddd\",\"code\":\"ww\",\"status\":1,\"sort\":4,\"created_by\":1,\"updated_by\":0,\"created_at\":null,\"updated_at\":null,\"remark\":\"\"}],\"total\":5}}', 1, NULL, NULL);
INSERT INTO `user_operation_log` VALUES (26, 'superAdmin', 'GET', '/admin/role/list', '获取角色', '172.17.0.1', '2025-06-12 19:32:02', '2025-06-12 19:32:02', NULL, '[]', 200, 0, '{\"request_id\":\"5780baa5-4232-4d89-beac-544c28e7a83c\",\"path\":\"\\/admin\\/role\\/list\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\",\"data\":{\"list\":[{\"id\":1,\"name\":\"\\u8d85\\u7ea7\\u7ba1\\u7406\\u5458\",\"code\":\"SuperAdmin\",\"status\":1,\"sort\":0,\"created_by\":0,\"updated_by\":0,\"created_at\":\"2025-06-04T21:30:40.000000Z\",\"updated_at\":\"2025-06-04T21:30:40.000000Z\",\"remark\":\"\"},{\"id\":2,\"name\":\"test\",\"code\":\"test\",\"status\":1,\"sort\":0,\"created_by\":0,\"updated_by\":0,\"created_at\":null,\"updated_at\":null,\"remark\":\"\"},{\"id\":3,\"name\":\"ddd\",\"code\":\"wwe\",\"status\":1,\"sort\":2,\"created_by\":1,\"updated_by\":1,\"created_at\":null,\"updated_at\":null,\"remark\":\"\"},{\"id\":5,\"name\":\"haha\",\"code\":\"hahas\",\"status\":1,\"sort\":2,\"created_by\":1,\"updated_by\":0,\"created_at\":null,\"updated_at\":null,\"remark\":\"\"},{\"id\":6,\"name\":\"ddd\",\"code\":\"ww\",\"status\":1,\"sort\":4,\"created_by\":1,\"updated_by\":0,\"created_at\":null,\"updated_at\":null,\"remark\":\"\"}],\"total\":5}}', 1, NULL, NULL);
INSERT INTO `user_operation_log` VALUES (27, 'superAdmin', 'GET', '/admin/role/list', '获取角色', '172.17.0.1', '2025-06-12 19:33:57', '2025-06-12 19:33:57', NULL, '[]', 200, 0, '{\"request_id\":\"cc573d2b-3783-41ee-8658-ec4fe82a9f42\",\"path\":\"\\/admin\\/role\\/list\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\",\"data\":{\"list\":[{\"id\":1,\"name\":\"\\u8d85\\u7ea7\\u7ba1\\u7406\\u5458\",\"code\":\"SuperAdmin\",\"status\":1,\"sort\":0,\"created_by\":0,\"updated_by\":0,\"created_at\":\"2025-06-04T21:30:40.000000Z\",\"updated_at\":\"2025-06-04T21:30:40.000000Z\",\"remark\":\"\"},{\"id\":2,\"name\":\"test\",\"code\":\"test\",\"status\":1,\"sort\":0,\"created_by\":0,\"updated_by\":0,\"created_at\":null,\"updated_at\":null,\"remark\":\"\"},{\"id\":3,\"name\":\"ddd\",\"code\":\"wwe\",\"status\":1,\"sort\":2,\"created_by\":1,\"updated_by\":1,\"created_at\":null,\"updated_at\":null,\"remark\":\"\"},{\"id\":5,\"name\":\"haha\",\"code\":\"hahas\",\"status\":1,\"sort\":2,\"created_by\":1,\"updated_by\":0,\"created_at\":null,\"updated_at\":null,\"remark\":\"\"},{\"id\":6,\"name\":\"ddd\",\"code\":\"ww\",\"status\":1,\"sort\":4,\"created_by\":1,\"updated_by\":0,\"created_at\":null,\"updated_at\":null,\"remark\":\"\"}],\"total\":5}}', 1, NULL, NULL);
INSERT INTO `user_operation_log` VALUES (28, 'superAdmin', 'GET', '/admin/role/list', '获取角色', '172.17.0.1', '2025-06-12 19:37:22', '2025-06-12 19:37:22', NULL, '[]', 200, 0, '{\"request_id\":\"c302743c-fda8-467b-b3e3-eeb4a59fdf06\",\"path\":\"\\/admin\\/role\\/list\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\",\"data\":{\"list\":[{\"id\":1,\"name\":\"\\u8d85\\u7ea7\\u7ba1\\u7406\\u5458\",\"code\":\"SuperAdmin\",\"status\":1,\"sort\":0,\"created_by\":0,\"updated_by\":0,\"created_at\":\"2025-06-04T21:30:40.000000Z\",\"updated_at\":\"2025-06-04T21:30:40.000000Z\",\"remark\":\"\"},{\"id\":2,\"name\":\"test\",\"code\":\"test\",\"status\":1,\"sort\":0,\"created_by\":0,\"updated_by\":0,\"created_at\":null,\"updated_at\":null,\"remark\":\"\"},{\"id\":3,\"name\":\"ddd\",\"code\":\"wwe\",\"status\":1,\"sort\":2,\"created_by\":1,\"updated_by\":1,\"created_at\":null,\"updated_at\":null,\"remark\":\"\"},{\"id\":5,\"name\":\"haha\",\"code\":\"hahas\",\"status\":1,\"sort\":2,\"created_by\":1,\"updated_by\":0,\"created_at\":null,\"updated_at\":null,\"remark\":\"\"},{\"id\":6,\"name\":\"ddd\",\"code\":\"ww\",\"status\":1,\"sort\":4,\"created_by\":1,\"updated_by\":0,\"created_at\":null,\"updated_at\":null,\"remark\":\"\"}],\"total\":5}}', 1, NULL, NULL);
INSERT INTO `user_operation_log` VALUES (29, 'superAdmin', 'GET', '/admin/role/list', '获取角色', '172.17.0.1', '2025-06-12 19:37:53', '2025-06-12 19:37:53', NULL, '[]', 200, 0, '{\"request_id\":\"7f49e84b-b3b4-4f0f-a24a-71d4f587903b\",\"path\":\"\\/admin\\/role\\/list\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\",\"data\":{\"list\":[{\"id\":1,\"name\":\"\\u8d85\\u7ea7\\u7ba1\\u7406\\u5458\",\"code\":\"SuperAdmin\",\"status\":1,\"sort\":0,\"created_by\":0,\"updated_by\":0,\"created_at\":\"2025-06-04T21:30:40.000000Z\",\"updated_at\":\"2025-06-04T21:30:40.000000Z\",\"remark\":\"\"},{\"id\":2,\"name\":\"test\",\"code\":\"test\",\"status\":1,\"sort\":0,\"created_by\":0,\"updated_by\":0,\"created_at\":null,\"updated_at\":null,\"remark\":\"\"},{\"id\":3,\"name\":\"ddd\",\"code\":\"wwe\",\"status\":1,\"sort\":2,\"created_by\":1,\"updated_by\":1,\"created_at\":null,\"updated_at\":null,\"remark\":\"\"},{\"id\":5,\"name\":\"haha\",\"code\":\"hahas\",\"status\":1,\"sort\":2,\"created_by\":1,\"updated_by\":0,\"created_at\":null,\"updated_at\":null,\"remark\":\"\"},{\"id\":6,\"name\":\"ddd\",\"code\":\"ww\",\"status\":1,\"sort\":4,\"created_by\":1,\"updated_by\":0,\"created_at\":null,\"updated_at\":null,\"remark\":\"\"}],\"total\":5}}', 1, NULL, NULL);
INSERT INTO `user_operation_log` VALUES (30, 'no_login_user', 'GET', '/admin/role/list', '获取角色', '172.17.0.1', '2025-06-12 19:38:06', '2025-06-12 19:38:06', NULL, '[]', 401, 0, '{\"request_id\":\"14d9d16a-d613-44e7-80f1-fc81036fab06\",\"path\":\"\\/admin\\/role\\/list\",\"success\":false,\"code\":100401,\"message\":\"The token is in blacklist\"}', 0, NULL, NULL);
INSERT INTO `user_operation_log` VALUES (31, 'no_login_user', 'GET', '/admin/role/list', '获取角色', '172.17.0.1', '2025-06-12 19:38:21', '2025-06-12 19:38:21', NULL, '[]', 401, 0, '{\"request_id\":\"0b4843f6-dc18-44b4-b9cc-91ad6334029d\",\"path\":\"\\/admin\\/role\\/list\",\"success\":false,\"code\":100401,\"message\":\"The token is in blacklist\"}', 0, NULL, NULL);
INSERT INTO `user_operation_log` VALUES (32, 'superAdmin', 'GET', '/admin/role/list', '获取角色', '172.17.0.1', '2025-06-12 19:38:36', '2025-06-12 19:38:36', NULL, '[]', 200, 0, '{\"request_id\":\"85e947a2-06cd-4831-a6ca-11b574b1326e\",\"path\":\"\\/admin\\/role\\/list\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\",\"data\":{\"list\":[{\"id\":1,\"name\":\"\\u8d85\\u7ea7\\u7ba1\\u7406\\u5458\",\"code\":\"SuperAdmin\",\"status\":1,\"sort\":0,\"created_by\":0,\"updated_by\":0,\"created_at\":\"2025-06-04T21:30:40.000000Z\",\"updated_at\":\"2025-06-04T21:30:40.000000Z\",\"remark\":\"\"},{\"id\":2,\"name\":\"test\",\"code\":\"test\",\"status\":1,\"sort\":0,\"created_by\":0,\"updated_by\":0,\"created_at\":null,\"updated_at\":null,\"remark\":\"\"},{\"id\":3,\"name\":\"ddd\",\"code\":\"wwe\",\"status\":1,\"sort\":2,\"created_by\":1,\"updated_by\":1,\"created_at\":null,\"updated_at\":null,\"remark\":\"\"},{\"id\":5,\"name\":\"haha\",\"code\":\"hahas\",\"status\":1,\"sort\":2,\"created_by\":1,\"updated_by\":0,\"created_at\":null,\"updated_at\":null,\"remark\":\"\"},{\"id\":6,\"name\":\"ddd\",\"code\":\"ww\",\"status\":1,\"sort\":4,\"created_by\":1,\"updated_by\":0,\"created_at\":null,\"updated_at\":null,\"remark\":\"\"}],\"total\":5}}', 1, NULL, NULL);
INSERT INTO `user_operation_log` VALUES (33, 'superAdmin', 'GET', '/admin/role/list', '获取角色', '172.17.0.1', '2025-06-12 19:41:18', '2025-06-12 19:41:18', NULL, '[]', 200, 0, '{\"request_id\":\"45789feb-9a6d-4b2e-9d47-6ba6419d086a\",\"path\":\"\\/admin\\/role\\/list\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\",\"data\":{\"list\":[{\"id\":1,\"name\":\"\\u8d85\\u7ea7\\u7ba1\\u7406\\u5458\",\"code\":\"SuperAdmin\",\"status\":1,\"sort\":0,\"created_by\":0,\"updated_by\":0,\"created_at\":\"2025-06-04T21:30:40.000000Z\",\"updated_at\":\"2025-06-04T21:30:40.000000Z\",\"remark\":\"\"},{\"id\":2,\"name\":\"test\",\"code\":\"test\",\"status\":1,\"sort\":0,\"created_by\":0,\"updated_by\":0,\"created_at\":null,\"updated_at\":null,\"remark\":\"\"},{\"id\":3,\"name\":\"ddd\",\"code\":\"wwe\",\"status\":1,\"sort\":2,\"created_by\":1,\"updated_by\":1,\"created_at\":null,\"updated_at\":null,\"remark\":\"\"},{\"id\":5,\"name\":\"haha\",\"code\":\"hahas\",\"status\":1,\"sort\":2,\"created_by\":1,\"updated_by\":0,\"created_at\":null,\"updated_at\":null,\"remark\":\"\"},{\"id\":6,\"name\":\"ddd\",\"code\":\"ww\",\"status\":1,\"sort\":4,\"created_by\":1,\"updated_by\":0,\"created_at\":null,\"updated_at\":null,\"remark\":\"\"}],\"total\":5}}', 1, NULL, NULL);
INSERT INTO `user_operation_log` VALUES (34, 'no_login_user', 'GET', '/admin/role/list', '获取角色', '172.17.0.1', '2025-06-12 19:41:34', '2025-06-12 19:41:34', NULL, '[]', 401, 0, '{\"request_id\":\"d37f9ea7-23a4-40fe-bb70-934186d50b64\",\"path\":\"\\/admin\\/role\\/list\",\"success\":false,\"code\":100401,\"message\":\"The token is in blacklist\"}', 0, NULL, NULL);
INSERT INTO `user_operation_log` VALUES (35, 'superAdmin', 'GET', '/admin/role/list', '获取角色', '172.17.0.1', '2025-06-12 19:43:06', '2025-06-12 19:43:06', NULL, '[]', 200, 0, '{\"request_id\":\"10a42897-cc1d-4023-8cb3-af30f21da4a9\",\"path\":\"\\/admin\\/role\\/list\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\",\"data\":{\"list\":[{\"id\":1,\"name\":\"\\u8d85\\u7ea7\\u7ba1\\u7406\\u5458\",\"code\":\"SuperAdmin\",\"status\":1,\"sort\":0,\"created_by\":0,\"updated_by\":0,\"created_at\":\"2025-06-04T21:30:40.000000Z\",\"updated_at\":\"2025-06-04T21:30:40.000000Z\",\"remark\":\"\"},{\"id\":2,\"name\":\"test\",\"code\":\"test\",\"status\":1,\"sort\":0,\"created_by\":0,\"updated_by\":0,\"created_at\":null,\"updated_at\":null,\"remark\":\"\"},{\"id\":3,\"name\":\"ddd\",\"code\":\"wwe\",\"status\":1,\"sort\":2,\"created_by\":1,\"updated_by\":1,\"created_at\":null,\"updated_at\":null,\"remark\":\"\"},{\"id\":5,\"name\":\"haha\",\"code\":\"hahas\",\"status\":1,\"sort\":2,\"created_by\":1,\"updated_by\":0,\"created_at\":null,\"updated_at\":null,\"remark\":\"\"},{\"id\":6,\"name\":\"ddd\",\"code\":\"ww\",\"status\":1,\"sort\":4,\"created_by\":1,\"updated_by\":0,\"created_at\":null,\"updated_at\":null,\"remark\":\"\"}],\"total\":5}}', 1, NULL, NULL);
INSERT INTO `user_operation_log` VALUES (36, 'no_login_user', 'GET', '/admin/role/list', '获取角色', '172.17.0.1', '2025-06-12 19:43:19', '2025-06-12 19:43:19', NULL, '[]', 401, 0, '{\"request_id\":\"a5af44b4-1a00-4c93-bda4-c7af36fc2f5d\",\"path\":\"\\/admin\\/role\\/list\",\"success\":false,\"code\":100401,\"message\":\"The token is in blacklist\"}', 0, NULL, NULL);
INSERT INTO `user_operation_log` VALUES (37, 'no_login_user', 'GET', '/admin/role/list', '获取角色', '172.17.0.1', '2025-06-12 19:43:55', '2025-06-12 19:43:55', NULL, '[]', 401, 0, '{\"request_id\":\"63589d69-59e2-4a52-97db-47789ca5dc86\",\"path\":\"\\/admin\\/role\\/list\",\"success\":false,\"code\":100401,\"message\":\"The token is in blacklist\"}', 0, NULL, NULL);
INSERT INTO `user_operation_log` VALUES (38, 'no_login_user', 'GET', '/admin/role/list', '获取角色', '172.17.0.1', '2025-06-13 02:54:40', '2025-06-13 02:54:40', NULL, '[]', 401, 2, '{\"request_id\":\"4cf1457e-7ee0-40d7-a7d1-8739e73248b5\",\"path\":\"\\/admin\\/role\\/list\",\"success\":false,\"code\":100401,\"message\":\"The token is expired.\"}', 0, NULL, NULL);
INSERT INTO `user_operation_log` VALUES (39, 'superAdmin', 'GET', '/admin/role/list', '获取角色', '172.17.0.1', '2025-06-13 02:55:09', '2025-06-13 02:55:09', NULL, '[]', 200, 2, '{\"request_id\":\"864818f4-d095-48ed-84e8-cc496a443113\",\"path\":\"\\/admin\\/role\\/list\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\",\"data\":{\"list\":[{\"id\":1,\"name\":\"\\u8d85\\u7ea7\\u7ba1\\u7406\\u5458\",\"code\":\"SuperAdmin\",\"status\":1,\"sort\":0,\"created_by\":0,\"updated_by\":0,\"created_at\":\"2025-06-04T21:30:40.000000Z\",\"updated_at\":\"2025-06-04T21:30:40.000000Z\",\"remark\":\"\"},{\"id\":2,\"name\":\"test\",\"code\":\"test\",\"status\":1,\"sort\":0,\"created_by\":0,\"updated_by\":0,\"created_at\":null,\"updated_at\":null,\"remark\":\"\"},{\"id\":3,\"name\":\"ddd\",\"code\":\"wwe\",\"status\":1,\"sort\":2,\"created_by\":1,\"updated_by\":1,\"created_at\":null,\"updated_at\":null,\"remark\":\"\"},{\"id\":5,\"name\":\"haha\",\"code\":\"hahas\",\"status\":1,\"sort\":2,\"created_by\":1,\"updated_by\":0,\"created_at\":null,\"updated_at\":null,\"remark\":\"\"},{\"id\":6,\"name\":\"ddd\",\"code\":\"ww\",\"status\":1,\"sort\":4,\"created_by\":1,\"updated_by\":0,\"created_at\":null,\"updated_at\":null,\"remark\":\"\"}],\"total\":5}}', 1, NULL, NULL);
INSERT INTO `user_operation_log` VALUES (40, 'superAdmin', 'GET', '/admin/role/list', '获取角色', '172.17.0.1', '2025-06-13 03:17:43', '2025-06-13 03:17:43', NULL, '[]', 200, 2, '{\"request_id\":\"a76854e6-f706-4794-98d3-977105f7112d\",\"path\":\"\\/admin\\/role\\/list\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\",\"data\":{\"list\":[{\"id\":1,\"name\":\"\\u8d85\\u7ea7\\u7ba1\\u7406\\u5458\",\"code\":\"SuperAdmin\",\"status\":1,\"sort\":0,\"created_by\":0,\"updated_by\":0,\"created_at\":\"2025-06-04T21:30:40.000000Z\",\"updated_at\":\"2025-06-04T21:30:40.000000Z\",\"remark\":\"\"},{\"id\":2,\"name\":\"test\",\"code\":\"test\",\"status\":1,\"sort\":0,\"created_by\":0,\"updated_by\":0,\"created_at\":null,\"updated_at\":null,\"remark\":\"\"},{\"id\":3,\"name\":\"ddd\",\"code\":\"wwe\",\"status\":1,\"sort\":2,\"created_by\":1,\"updated_by\":1,\"created_at\":null,\"updated_at\":null,\"remark\":\"\"},{\"id\":5,\"name\":\"haha\",\"code\":\"hahas\",\"status\":1,\"sort\":2,\"created_by\":1,\"updated_by\":0,\"created_at\":null,\"updated_at\":null,\"remark\":\"\"},{\"id\":6,\"name\":\"ddd\",\"code\":\"ww\",\"status\":1,\"sort\":4,\"created_by\":1,\"updated_by\":0,\"created_at\":null,\"updated_at\":null,\"remark\":\"\"}],\"total\":5}}', 1, 'a76854e6-f706-4794-98d3-977105f7112d', 2647);
INSERT INTO `user_operation_log` VALUES (41, 'superAdmin', 'GET', '/admin/role/list', '获取角色', '172.17.0.1', '2025-06-13 03:17:55', '2025-06-13 03:17:55', NULL, '[]', 200, 2, '{\"request_id\":\"03490d1c-dad2-40c8-8585-8e9031552c55\",\"path\":\"\\/admin\\/role\\/list\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\",\"data\":{\"list\":[{\"id\":1,\"name\":\"\\u8d85\\u7ea7\\u7ba1\\u7406\\u5458\",\"code\":\"SuperAdmin\",\"status\":1,\"sort\":0,\"created_by\":0,\"updated_by\":0,\"created_at\":\"2025-06-04T21:30:40.000000Z\",\"updated_at\":\"2025-06-04T21:30:40.000000Z\",\"remark\":\"\"},{\"id\":2,\"name\":\"test\",\"code\":\"test\",\"status\":1,\"sort\":0,\"created_by\":0,\"updated_by\":0,\"created_at\":null,\"updated_at\":null,\"remark\":\"\"},{\"id\":3,\"name\":\"ddd\",\"code\":\"wwe\",\"status\":1,\"sort\":2,\"created_by\":1,\"updated_by\":1,\"created_at\":null,\"updated_at\":null,\"remark\":\"\"},{\"id\":5,\"name\":\"haha\",\"code\":\"hahas\",\"status\":1,\"sort\":2,\"created_by\":1,\"updated_by\":0,\"created_at\":null,\"updated_at\":null,\"remark\":\"\"},{\"id\":6,\"name\":\"ddd\",\"code\":\"ww\",\"status\":1,\"sort\":4,\"created_by\":1,\"updated_by\":0,\"created_at\":null,\"updated_at\":null,\"remark\":\"\"}],\"total\":5}}', 1, '03490d1c-dad2-40c8-8585-8e9031552c55', 406);
INSERT INTO `user_operation_log` VALUES (42, 'superAdmin', 'GET', '/admin/role/list', '获取角色', '172.17.0.1', '2025-06-13 03:20:50', '2025-06-13 03:20:50', NULL, '[]', 200, 2, '{\"request_id\":\"109b47ff-5723-42c1-a973-317359993649\",\"path\":\"\\/admin\\/role\\/list\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\",\"data\":{\"list\":[{\"id\":1,\"name\":\"\\u8d85\\u7ea7\\u7ba1\\u7406\\u5458\",\"code\":\"SuperAdmin\",\"status\":1,\"sort\":0,\"created_by\":0,\"updated_by\":0,\"created_at\":\"2025-06-04T21:30:40.000000Z\",\"updated_at\":\"2025-06-04T21:30:40.000000Z\",\"remark\":\"\"},{\"id\":2,\"name\":\"test\",\"code\":\"test\",\"status\":1,\"sort\":0,\"created_by\":0,\"updated_by\":0,\"created_at\":null,\"updated_at\":null,\"remark\":\"\"},{\"id\":3,\"name\":\"ddd\",\"code\":\"wwe\",\"status\":1,\"sort\":2,\"created_by\":1,\"updated_by\":1,\"created_at\":null,\"updated_at\":null,\"remark\":\"\"},{\"id\":5,\"name\":\"haha\",\"code\":\"hahas\",\"status\":1,\"sort\":2,\"created_by\":1,\"updated_by\":0,\"created_at\":null,\"updated_at\":null,\"remark\":\"\"},{\"id\":6,\"name\":\"ddd\",\"code\":\"ww\",\"status\":1,\"sort\":4,\"created_by\":1,\"updated_by\":0,\"created_at\":null,\"updated_at\":null,\"remark\":\"\"}],\"total\":5}}', 1, '109b47ff-5723-42c1-a973-317359993649', 2869);
INSERT INTO `user_operation_log` VALUES (43, 'superAdmin', 'GET', '/admin/role/list', '获取角色', '172.17.0.1', '2025-06-13 03:21:25', '2025-06-13 03:21:25', NULL, '[]', 200, 2, '{\"request_id\":\"dc04b365-f054-4145-8861-9460ccddb4ef\",\"path\":\"\\/admin\\/role\\/list\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\",\"data\":{\"list\":[{\"id\":1,\"name\":\"\\u8d85\\u7ea7\\u7ba1\\u7406\\u5458\",\"code\":\"SuperAdmin\",\"status\":1,\"sort\":0,\"created_by\":0,\"updated_by\":0,\"created_at\":\"2025-06-04T21:30:40.000000Z\",\"updated_at\":\"2025-06-04T21:30:40.000000Z\",\"remark\":\"\"},{\"id\":2,\"name\":\"test\",\"code\":\"test\",\"status\":1,\"sort\":0,\"created_by\":0,\"updated_by\":0,\"created_at\":null,\"updated_at\":null,\"remark\":\"\"},{\"id\":3,\"name\":\"ddd\",\"code\":\"wwe\",\"status\":1,\"sort\":2,\"created_by\":1,\"updated_by\":1,\"created_at\":null,\"updated_at\":null,\"remark\":\"\"},{\"id\":5,\"name\":\"haha\",\"code\":\"hahas\",\"status\":1,\"sort\":2,\"created_by\":1,\"updated_by\":0,\"created_at\":null,\"updated_at\":null,\"remark\":\"\"},{\"id\":6,\"name\":\"ddd\",\"code\":\"ww\",\"status\":1,\"sort\":4,\"created_by\":1,\"updated_by\":0,\"created_at\":null,\"updated_at\":null,\"remark\":\"\"}],\"total\":5}}', 1, 'dc04b365-f054-4145-8861-9460ccddb4ef', 2759);
INSERT INTO `user_operation_log` VALUES (44, 'superAdmin', 'GET', '/admin/role/list', '获取角色', '172.17.0.1', '2025-06-13 03:25:08', '2025-06-13 03:25:08', NULL, '[]', 200, 1, '{\"request_id\":\"d6050918-8105-4131-9907-b80a6308cfc1\",\"path\":\"\\/admin\\/role\\/list\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\",\"data\":{\"list\":[{\"id\":1,\"name\":\"\\u8d85\\u7ea7\\u7ba1\\u7406\\u5458\",\"code\":\"SuperAdmin\",\"status\":1,\"sort\":0,\"created_by\":0,\"updated_by\":0,\"created_at\":\"2025-06-04T21:30:40.000000Z\",\"updated_at\":\"2025-06-04T21:30:40.000000Z\",\"remark\":\"\"},{\"id\":2,\"name\":\"test\",\"code\":\"test\",\"status\":1,\"sort\":0,\"created_by\":0,\"updated_by\":0,\"created_at\":null,\"updated_at\":null,\"remark\":\"\"},{\"id\":3,\"name\":\"ddd\",\"code\":\"wwe\",\"status\":1,\"sort\":2,\"created_by\":1,\"updated_by\":1,\"created_at\":null,\"updated_at\":null,\"remark\":\"\"},{\"id\":5,\"name\":\"haha\",\"code\":\"hahas\",\"status\":1,\"sort\":2,\"created_by\":1,\"updated_by\":0,\"created_at\":null,\"updated_at\":null,\"remark\":\"\"},{\"id\":6,\"name\":\"ddd\",\"code\":\"ww\",\"status\":1,\"sort\":4,\"created_by\":1,\"updated_by\":0,\"created_at\":null,\"updated_at\":null,\"remark\":\"\"}],\"total\":5}}', 1, 'd6050918-8105-4131-9907-b80a6308cfc1', 2842);
INSERT INTO `user_operation_log` VALUES (45, 'superAdmin', 'GET', '/admin/role/list', '获取角色', '172.17.0.1', '2025-06-13 03:25:24', '2025-06-13 03:25:24', NULL, '[]', 200, 1, '{\"request_id\":\"c5f54061-bd8e-4957-bb1c-65e2a3e1b137\",\"path\":\"\\/admin\\/role\\/list\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\",\"data\":{\"list\":[{\"id\":1,\"name\":\"\\u8d85\\u7ea7\\u7ba1\\u7406\\u5458\",\"code\":\"SuperAdmin\",\"status\":1,\"sort\":0,\"created_by\":0,\"updated_by\":0,\"created_at\":\"2025-06-04T21:30:40.000000Z\",\"updated_at\":\"2025-06-04T21:30:40.000000Z\",\"remark\":\"\"},{\"id\":2,\"name\":\"test\",\"code\":\"test\",\"status\":1,\"sort\":0,\"created_by\":0,\"updated_by\":0,\"created_at\":null,\"updated_at\":null,\"remark\":\"\"},{\"id\":3,\"name\":\"ddd\",\"code\":\"wwe\",\"status\":1,\"sort\":2,\"created_by\":1,\"updated_by\":1,\"created_at\":null,\"updated_at\":null,\"remark\":\"\"},{\"id\":5,\"name\":\"haha\",\"code\":\"hahas\",\"status\":1,\"sort\":2,\"created_by\":1,\"updated_by\":0,\"created_at\":null,\"updated_at\":null,\"remark\":\"\"},{\"id\":6,\"name\":\"ddd\",\"code\":\"ww\",\"status\":1,\"sort\":4,\"created_by\":1,\"updated_by\":0,\"created_at\":null,\"updated_at\":null,\"remark\":\"\"}],\"total\":5}}', 1, 'c5f54061-bd8e-4957-bb1c-65e2a3e1b137', 457);
INSERT INTO `user_operation_log` VALUES (46, 'admin', 'POST', '/admin/setting/ConfigGroup', '创建系统配置分组', '172.17.0.1', '2025-06-14 16:06:45', '2025-06-14 16:06:45', NULL, '{\"code\":\"site_setting\",\"name\":\"\\u7ad9\\u70b9\\u8bbe\\u7f6e\",\"icon\":\"vscode-icons:file-type-aspx\",\"remark\":\"\\u7f51\\u7ad9\\u57fa\\u7840\\u4fe1\\u606f\\u914d\\u7f6e\"}', 200, 1, '{\"request_id\":\"d08bd712-a03f-4dbf-aa7f-c06094a1a1c0\",\"path\":\"\\/admin\\/setting\\/ConfigGroup\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\"}', 1, 'd08bd712-a03f-4dbf-aa7f-c06094a1a1c0', 107);
INSERT INTO `user_operation_log` VALUES (47, 'admin', 'POST', '/admin/setting/ConfigGroup', '创建系统配置分组', '172.17.0.1', '2025-06-14 16:09:25', '2025-06-14 16:09:25', NULL, '{\"code\":\"site_setting\",\"name\":\"\\u7ad9\\u70b9\\u8bbe\\u7f6e\",\"icon\":\"vscode-icons:file-type-aspx\",\"remark\":\"\\u7f51\\u7ad9\\u57fa\\u7840\\u4fe1\\u606f\\u914d\\u7f6e\"}', 200, 1, '{\"request_id\":\"4ef58251-63be-4529-bd57-d55328bc46a2\",\"path\":\"\\/admin\\/setting\\/ConfigGroup\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\"}', 1, '4ef58251-63be-4529-bd57-d55328bc46a2', 352);
INSERT INTO `user_operation_log` VALUES (48, 'admin', 'POST', '/admin/setting/ConfigGroup', '创建系统配置分组', '172.17.0.1', '2025-06-14 16:16:12', '2025-06-14 16:16:12', NULL, '{\"code\":\"upload_setting\",\"name\":\"\\u4e0a\\u4f20\\u8bbe\\u7f6e\",\"icon\":\"ant-design:cloud-upload-outlined\",\"remark\":\"\\u6587\\u4ef6\\u4e0a\\u4f20\\u914d\\u7f6e\"}', 200, 1, '{\"request_id\":\"216adc8d-dadd-4f38-9918-7039d87d2377\",\"path\":\"\\/admin\\/setting\\/ConfigGroup\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\"}', 1, '216adc8d-dadd-4f38-9918-7039d87d2377', 86);
INSERT INTO `user_operation_log` VALUES (49, 'admin', 'POST', '/admin/setting/config', '创建系统配置', '172.17.0.1', '2025-06-14 16:20:11', '2025-06-14 16:20:11', NULL, '{\"group_id\":1,\"sort\":0,\"input_type\":\"switch\",\"config_select_data\":[],\"name\":\"\\u7ad9\\u70b9\\u5f00\\u542f\",\"key\":\"site_open\",\"remark\":\"\\u662f\\u5426\\u5bf9\\u5916\\u63d0\\u4f9b\\u7f51\\u7edc\\u670d\\u52a1\"}', 200, 1, '{\"request_id\":\"0392c9b6-60cc-4528-9dd3-47f5f735ad34\",\"path\":\"\\/admin\\/setting\\/config\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\"}', 1, '0392c9b6-60cc-4528-9dd3-47f5f735ad34', 130);
INSERT INTO `user_operation_log` VALUES (50, 'admin', 'POST', '/admin/setting/config', '创建系统配置', '172.17.0.1', '2025-06-14 16:28:47', '2025-06-14 16:28:47', NULL, '{\"group_id\":1,\"sort\":0,\"input_type\":\"input\",\"config_select_data\":[],\"name\":\"\\u7ad9\\u70b9\\u540d\\u79f0\",\"key\":\"site_name\",\"value\":\"new pay\"}', 200, 1, '{\"request_id\":\"b0837c53-443c-4166-9aaf-bba225c77c28\",\"path\":\"\\/admin\\/setting\\/config\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\"}', 1, 'b0837c53-443c-4166-9aaf-bba225c77c28', 89);
INSERT INTO `user_operation_log` VALUES (51, 'admin', 'POST', '/admin/setting/config', '创建系统配置', '172.17.0.1', '2025-06-14 16:30:48', '2025-06-14 16:30:48', NULL, '{\"group_id\":1,\"sort\":0,\"input_type\":\"imageUpload\",\"config_select_data\":[],\"key\":\"site_logo\",\"name\":\"\\u7ad9\\u70b9Logo\"}', 200, 1, '{\"request_id\":\"892b9c7d-cd0b-490c-bd54-c04ac02c2758\",\"path\":\"\\/admin\\/setting\\/config\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\"}', 1, '892b9c7d-cd0b-490c-bd54-c04ac02c2758', 90);
INSERT INTO `user_operation_log` VALUES (52, 'admin', 'POST', '/admin/setting/config', '创建系统配置', '172.17.0.1', '2025-06-14 16:33:36', '2025-06-14 16:33:36', NULL, '{\"group_id\":2,\"sort\":0,\"input_type\":\"select\",\"config_select_data\":[{\"label\":\"\\u79c1\\u6709\\u4e91(\\u672c\\u5730)\",\"value\":\"local\"},{\"label\":\"\\u963f\\u91cc\\u4e91\",\"value\":\"oss\"},{\"label\":\"\\u817e\\u8baf\\u4e91\",\"value\":\"cos\"},{\"label\":\"\\u4e03\\u725b\\u4e91\",\"value\":\"qiniu\"},{\"label\":\"\\u4e9a\\u9a6c\\u900a(S3)\",\"value\":\"s3\"}],\"key\":\"upload_mode\",\"name\":\"\\u4e0a\\u4f20\\u6a21\\u5f0f\"}', 200, 1, '{\"request_id\":\"ac08210b-5ec9-46f3-961a-8708fef532d3\",\"path\":\"\\/admin\\/setting\\/config\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\"}', 1, 'ac08210b-5ec9-46f3-961a-8708fef532d3', 88);
INSERT INTO `user_operation_log` VALUES (53, 'admin', 'POST', '/admin/setting/config', '创建系统配置', '172.17.0.1', '2025-06-14 16:34:58', '2025-06-14 16:34:58', NULL, '{\"group_id\":2,\"sort\":0,\"input_type\":\"input\",\"config_select_data\":[],\"key\":\"upload_single_limit\",\"name\":\"\\u4e0a\\u4f20\\u5927\\u5c0f\",\"value\":\"1024\"}', 200, 1, '{\"request_id\":\"03add4ab-42c4-4d8b-98aa-70538a859e41\",\"path\":\"\\/admin\\/setting\\/config\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\"}', 1, '03add4ab-42c4-4d8b-98aa-70538a859e41', 103);
INSERT INTO `user_operation_log` VALUES (54, 'admin', 'POST', '/admin/setting/config', '创建系统配置', '172.17.0.1', '2025-06-14 16:36:00', '2025-06-14 16:36:00', NULL, '{\"group_id\":2,\"sort\":0,\"input_type\":\"input\",\"config_select_data\":[],\"key\":\"upload_nums\",\"name\":\"\\u6570\\u91cf\\u9650\\u5236\",\"value\":\"10\"}', 200, 1, '{\"request_id\":\"85598308-bc19-4c66-bdbc-7f601732b2c8\",\"path\":\"\\/admin\\/setting\\/config\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\"}', 1, '85598308-bc19-4c66-bdbc-7f601732b2c8', 89);
INSERT INTO `user_operation_log` VALUES (55, 'admin', 'POST', '/admin/setting/config', '创建系统配置', '172.17.0.1', '2025-06-14 16:37:03', '2025-06-14 16:37:03', NULL, '{\"group_id\":2,\"sort\":0,\"input_type\":\"textarea\",\"config_select_data\":[],\"key\":\"upload_exclude\",\"name\":\"\\u4e0d\\u5141\\u8bb8\\u6587\\u4ef6\\u7c7b\\u578b\",\"value\":\"php,ext,exe\",\"remark\":\"\\u82f1\\u6587\\u9017\\u53f7\\u5206\\u5272\\u591a\\u4e2a\\u6587\\u4ef6\\u540e\\u7f00\"}', 200, 1, '{\"request_id\":\"a5db4e9e-4603-44a0-991d-3e6e17a522e6\",\"path\":\"\\/admin\\/setting\\/config\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\"}', 1, 'a5db4e9e-4603-44a0-991d-3e6e17a522e6', 91);
INSERT INTO `user_operation_log` VALUES (56, 'admin', 'POST', '/admin/setting/config/batchUpdate', '批量更新系统配置', '172.17.0.1', '2025-06-14 16:37:47', '2025-06-14 16:37:47', NULL, '[{\"id\":17,\"group_id\":2,\"key\":\"upload_exclude\",\"value\":\"php,ext,exe\",\"name\":\"\\u4e0d\\u5141\\u8bb8\\u6587\\u4ef6\\u7c7b\\u578b\",\"input_type\":\"textarea\",\"config_select_data\":[],\"sort\":0,\"remark\":\"\\u82f1\\u6587\\u9017\\u53f7\\u5206\\u5272\\u591a\\u4e2a\\u6587\\u4ef6\\u540e\\u7f00\",\"created_by\":1,\"updated_by\":null,\"created_at\":\"2025-06-14T08:37:03.000000Z\",\"updated_at\":\"2025-06-14T08:37:03.000000Z\"},{\"id\":16,\"group_id\":2,\"key\":\"upload_nums\",\"value\":\"10\",\"name\":\"\\u6570\\u91cf\\u9650\\u5236\",\"input_type\":\"input\",\"config_select_data\":[],\"sort\":0,\"remark\":null,\"created_by\":1,\"updated_by\":null,\"created_at\":\"2025-06-14T08:36:00.000000Z\",\"updated_at\":\"2025-06-14T08:36:00.000000Z\"},{\"id\":15,\"group_id\":2,\"key\":\"upload_single_limit\",\"value\":\"1024\",\"name\":\"\\u4e0a\\u4f20\\u5927\\u5c0f\",\"input_type\":\"input\",\"config_select_data\":[],\"sort\":0,\"remark\":null,\"created_by\":1,\"updated_by\":null,\"created_at\":\"2025-06-14T08:34:58.000000Z\",\"updated_at\":\"2025-06-14T08:34:58.000000Z\"},{\"id\":14,\"group_id\":2,\"key\":\"upload_mode\",\"value\":\"local\",\"name\":\"\\u4e0a\\u4f20\\u6a21\\u5f0f\",\"input_type\":\"select\",\"config_select_data\":[{\"label\":\"\\u79c1\\u6709\\u4e91(\\u672c\\u5730)\",\"value\":\"local\"},{\"label\":\"\\u963f\\u91cc\\u4e91\",\"value\":\"oss\"},{\"label\":\"\\u817e\\u8baf\\u4e91\",\"value\":\"cos\"},{\"label\":\"\\u4e03\\u725b\\u4e91\",\"value\":\"qiniu\"},{\"label\":\"\\u4e9a\\u9a6c\\u900a(S3)\",\"value\":\"s3\"}],\"sort\":0,\"remark\":null,\"created_by\":1,\"updated_by\":null,\"created_at\":\"2025-06-14T08:33:36.000000Z\",\"updated_at\":\"2025-06-14T08:33:36.000000Z\"}]', 200, 1, '{\"request_id\":\"99ccb3b0-f5c2-4ac6-81c1-a52a752e9130\",\"path\":\"\\/admin\\/setting\\/config\\/batchUpdate\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\"}', 1, '99ccb3b0-f5c2-4ac6-81c1-a52a752e9130', 695);
INSERT INTO `user_operation_log` VALUES (57, 'admin', 'POST', '/admin/setting/config/batchUpdate', '批量更新系统配置', '172.17.0.1', '2025-06-14 16:38:03', '2025-06-14 16:38:03', NULL, '[{\"id\":13,\"group_id\":1,\"key\":\"site_logo\",\"value\":null,\"name\":\"\\u7ad9\\u70b9Logo\",\"input_type\":\"imageUpload\",\"config_select_data\":[],\"sort\":0,\"remark\":null,\"created_by\":1,\"updated_by\":null,\"created_at\":\"2025-06-14T08:30:48.000000Z\",\"updated_at\":\"2025-06-14T08:30:48.000000Z\"},{\"id\":12,\"group_id\":1,\"key\":\"site_name\",\"value\":\"new pay\",\"name\":\"\\u7ad9\\u70b9\\u540d\\u79f0\",\"input_type\":\"input\",\"config_select_data\":[],\"sort\":99,\"remark\":null,\"created_by\":1,\"updated_by\":null,\"created_at\":\"2025-06-14T08:28:47.000000Z\",\"updated_at\":\"2025-06-14T08:28:47.000000Z\"},{\"id\":11,\"group_id\":1,\"key\":\"site_open\",\"value\":true,\"name\":\"\\u7ad9\\u70b9\\u5f00\\u542f\",\"input_type\":\"switch\",\"config_select_data\":[],\"sort\":101,\"remark\":\"\\u662f\\u5426\\u5bf9\\u5916\\u63d0\\u4f9b\\u7f51\\u7edc\\u670d\\u52a1\",\"created_by\":1,\"updated_by\":null,\"created_at\":\"2025-06-14T08:20:11.000000Z\",\"updated_at\":\"2025-06-14T08:20:11.000000Z\"}]', 200, 1, '{\"request_id\":\"a6658887-f439-438d-a7ef-e73caaba9f17\",\"path\":\"\\/admin\\/setting\\/config\\/batchUpdate\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\"}', 1, 'a6658887-f439-438d-a7ef-e73caaba9f17', 514);
INSERT INTO `user_operation_log` VALUES (58, 'admin', 'POST', '/admin/attachment/upload', '上传附件', '172.17.0.1', '2025-06-17 08:30:07', '2025-06-17 08:30:07', NULL, '[]', 200, 1, '{\"request_id\":\"7a139271-1ee7-444b-92cd-5c04c831451c\",\"path\":\"\\/admin\\/attachment\\/upload\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\"}', 1, '7a139271-1ee7-444b-92cd-5c04c831451c', 638);
INSERT INTO `user_operation_log` VALUES (59, 'admin', 'POST', '/admin/attachment/upload', '上传附件', '172.17.0.1', '2025-06-17 08:30:33', '2025-06-17 08:30:33', NULL, '[]', 200, 1, '{\"request_id\":\"f28e0de5-986b-48d5-8fd1-01910e659382\",\"path\":\"\\/admin\\/attachment\\/upload\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\"}', 1, 'f28e0de5-986b-48d5-8fd1-01910e659382', 445);
INSERT INTO `user_operation_log` VALUES (60, 'admin', 'POST', '/admin/attachment/upload', '上传附件', '172.17.0.1', '2025-06-17 08:30:45', '2025-06-17 08:30:45', NULL, '[]', 200, 1, '{\"request_id\":\"29311dd5-91d6-4799-b04d-d2ff060a412a\",\"path\":\"\\/admin\\/attachment\\/upload\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\"}', 1, '29311dd5-91d6-4799-b04d-d2ff060a412a', 444);
INSERT INTO `user_operation_log` VALUES (61, 'admin', 'POST', '/admin/attachment/upload', '上传附件', '172.17.0.1', '2025-06-17 08:31:42', '2025-06-17 08:31:42', NULL, '[]', 200, 1, '{\"request_id\":\"3831fcbc-ff04-40f7-953f-c94f5801d6d5\",\"path\":\"\\/admin\\/attachment\\/upload\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\"}', 1, '3831fcbc-ff04-40f7-953f-c94f5801d6d5', 436);
INSERT INTO `user_operation_log` VALUES (62, 'admin', 'POST', '/admin/attachment/upload', '上传附件', '172.17.0.1', '2025-06-17 15:41:50', '2025-06-17 15:41:50', NULL, '[]', 200, 1, '{\"request_id\":\"1ccedfde-823d-4323-9cab-2fa35765ee86\",\"path\":\"\\/admin\\/attachment\\/upload\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\"}', 1, '1ccedfde-823d-4323-9cab-2fa35765ee86', 707);
INSERT INTO `user_operation_log` VALUES (63, 'admin', 'POST', '/admin/attachment/upload', '上传附件', '172.17.0.1', '2025-06-17 15:42:50', '2025-06-17 15:42:50', NULL, '[]', 200, 1, '{\"request_id\":\"1a9543ac-3c84-4e97-949b-37a11bb22170\",\"path\":\"\\/admin\\/attachment\\/upload\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\",\"data\":[]}', 1, '1a9543ac-3c84-4e97-949b-37a11bb22170', 968);
INSERT INTO `user_operation_log` VALUES (64, 'admin', 'POST', '/admin/attachment/upload', '上传附件', '172.17.0.1', '2025-06-17 15:42:52', '2025-06-17 15:42:52', NULL, '{\"file\":\"undefined\"}', 500, 2, '{\"request_id\":\"a748511a-b84e-4233-b49c-3239d969bfae\",\"path\":\"\\/admin\\/attachment\\/upload\",\"success\":false,\"code\":100500,\"message\":\"\\u672a\\u627e\\u5230\\u7b26\\u5408\\u6761\\u4ef6\\u7684\\u6587\\u4ef6\\u8d44\\u6e90\"}', 1, 'a748511a-b84e-4233-b49c-3239d969bfae', 507);
INSERT INTO `user_operation_log` VALUES (65, 'admin', 'POST', '/admin/attachment/upload', '上传附件', '172.17.0.1', '2025-06-17 15:50:10', '2025-06-17 15:50:10', NULL, '[]', 200, 1, '{\"request_id\":\"3d421cea-493a-4a71-8545-a7acc30d5e5b\",\"path\":\"\\/admin\\/attachment\\/upload\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\",\"data\":[]}', 1, '3d421cea-493a-4a71-8545-a7acc30d5e5b', 879);
INSERT INTO `user_operation_log` VALUES (66, 'admin', 'POST', '/admin/attachment/upload', '上传附件', '172.17.0.1', '2025-06-17 15:52:25', '2025-06-17 15:52:25', NULL, '[]', 200, 1, '{\"request_id\":\"4d965ece-a06b-4e2b-96ae-31883d1f9173\",\"path\":\"\\/admin\\/attachment\\/upload\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\",\"data\":[]}', 1, '4d965ece-a06b-4e2b-96ae-31883d1f9173', 848);
INSERT INTO `user_operation_log` VALUES (67, 'admin', 'POST', '/admin/attachment/upload', '上传附件', '172.17.0.1', '2025-06-17 15:53:39', '2025-06-17 15:53:39', NULL, '[]', 200, 1, '{\"request_id\":\"1e5a6ecb-4829-4e63-9334-6f4d934c2f1d\",\"path\":\"\\/admin\\/attachment\\/upload\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\",\"data\":[]}', 1, '1e5a6ecb-4829-4e63-9334-6f4d934c2f1d', 889);
INSERT INTO `user_operation_log` VALUES (68, 'admin', 'POST', '/admin/attachment/upload', '上传附件', '172.17.0.1', '2025-06-17 15:55:22', '2025-06-17 15:55:22', NULL, '[]', 200, 1, '{\"request_id\":\"e3cba27f-b6aa-4101-9f46-1364722abe53\",\"path\":\"\\/admin\\/attachment\\/upload\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\",\"data\":[]}', 1, 'e3cba27f-b6aa-4101-9f46-1364722abe53', 923);
INSERT INTO `user_operation_log` VALUES (69, 'admin', 'POST', '/admin/attachment/upload', '上传附件', '172.17.0.1', '2025-06-17 15:57:08', '2025-06-17 15:57:08', NULL, '[]', 200, 1, '{\"request_id\":\"1562c7cd-8371-4efc-a191-cacfb8908b50\",\"path\":\"\\/admin\\/attachment\\/upload\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\",\"data\":[]}', 1, '1562c7cd-8371-4efc-a191-cacfb8908b50', 847);
INSERT INTO `user_operation_log` VALUES (70, 'admin', 'POST', '/admin/attachment/upload', '上传附件', '172.17.0.1', '2025-06-17 15:59:27', '2025-06-17 15:59:27', NULL, '[]', 200, 1, '{\"request_id\":\"167e0fad-a2f3-41f3-bcb0-2abdfc1db0da\",\"path\":\"\\/admin\\/attachment\\/upload\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\",\"data\":{\"storage_mode\":0,\"origin_name\":\"503d269759ee3d6d44bb596fd79ac9244e4adeac.jpeg\",\"object_name\":\"54832c49bb0b7211be78de3699948702.jpeg\",\"hash\":\"54832c49bb0b7211be78de3699948702\",\"mime_type\":\"image\\/jpeg\",\"base_path\":\"\\/upload\\/54832c49bb0b7211be78de3699948702.jpeg\",\"suffix\":\"jpeg\",\"size_byte\":19420,\"size_info\":\"18.96 KB\",\"url\":\"http:\\/\\/127.0.0.1:9501\\/upload\\/54832c49bb0b7211be78de3699948702.jpeg\",\"storage_path\":\"\\/data\\/project\\/byapay\\/newpay\\/public\\/upload\\/54832c49bb0b7211be78de3699948702.jpeg\",\"updated_at\":\"2025-06-17T07:59:26.000000Z\",\"created_at\":\"2025-06-17T07:59:26.000000Z\",\"id\":16}}', 1, '167e0fad-a2f3-41f3-bcb0-2abdfc1db0da', 909);
INSERT INTO `user_operation_log` VALUES (71, 'admin', 'POST', '/admin/attachment/upload', '上传附件', '172.17.0.1', '2025-06-17 15:59:43', '2025-06-17 15:59:43', NULL, '[]', 200, 1, '{\"request_id\":\"7d368bea-25ed-4e54-ab08-90b779050cda\",\"path\":\"\\/admin\\/attachment\\/upload\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\",\"data\":{\"storage_mode\":0,\"origin_name\":\"ChMkK2VuiYOIAt4fAADe7KV_wZgAAX6mQLS-ysAAN8E319.jpg\",\"object_name\":\"473a077cb76edab1d3525751ec25d236.jpg\",\"hash\":\"473a077cb76edab1d3525751ec25d236\",\"mime_type\":\"image\\/jpeg\",\"base_path\":\"\\/upload\\/473a077cb76edab1d3525751ec25d236.jpg\",\"suffix\":\"jpg\",\"size_byte\":37963,\"size_info\":\"37.07 KB\",\"url\":\"http:\\/\\/127.0.0.1:9501\\/upload\\/473a077cb76edab1d3525751ec25d236.jpg\",\"storage_path\":\"\\/data\\/project\\/byapay\\/newpay\\/public\\/upload\\/473a077cb76edab1d3525751ec25d236.jpg\",\"updated_at\":\"2025-06-17T07:59:43.000000Z\",\"created_at\":\"2025-06-17T07:59:43.000000Z\",\"id\":17}}', 1, '7d368bea-25ed-4e54-ab08-90b779050cda', 534);
INSERT INTO `user_operation_log` VALUES (72, 'admin', 'POST', '/admin/attachment/upload', '上传附件', '172.17.0.1', '2025-06-17 16:00:33', '2025-06-17 16:00:33', NULL, '[]', 500, 2, '{\"request_id\":\"528152a8-d6ca-4d25-a992-7c7f642bcd06\",\"path\":\"\\/admin\\/attachment\\/upload\",\"success\":false,\"code\":100500,\"message\":\"app\\\\service\\\\AttachmentService::upload(): Return value must be of type ?array, Illuminate\\\\Database\\\\Eloquent\\\\Collection returned\"}', 1, '528152a8-d6ca-4d25-a992-7c7f642bcd06', 744);
INSERT INTO `user_operation_log` VALUES (73, 'admin', 'POST', '/admin/attachment/upload', '上传附件', '172.17.0.1', '2025-06-17 16:01:23', '2025-06-17 16:01:23', NULL, '[]', 200, 1, '{\"request_id\":\"785e8561-b5ae-42ca-b517-6e007577843f\",\"path\":\"\\/admin\\/attachment\\/upload\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\",\"data\":[{\"id\":15,\"storage_mode\":0,\"origin_name\":\"wuhuarou.webp\",\"object_name\":\"362234e233ddf148079b2f7f738cc986.webp\",\"hash\":\"362234e233ddf148079b2f7f738cc986\",\"mime_type\":\"image\\/webp\",\"storage_path\":\"\\/data\\/project\\/byapay\\/newpay\\/public\\/upload\\/362234e233ddf148079b2f7f738cc986.webp\",\"base_path\":\"\\/upload\\/362234e233ddf148079b2f7f738cc986.webp\",\"suffix\":\"webp\",\"url\":\"http:\\/\\/127.0.0.1:9501\\/upload\\/362234e233ddf148079b2f7f738cc986.webp\",\"size_byte\":24120,\"size_info\":\"23.55 KB\",\"remark\":null,\"created_at\":\"2025-06-17T07:57:07.000000Z\",\"updated_at\":\"2025-06-17T07:57:07.000000Z\",\"created_by\":null,\"updated_by\":0}]}', 1, '785e8561-b5ae-42ca-b517-6e007577843f', 899);
INSERT INTO `user_operation_log` VALUES (74, 'admin', 'POST', '/admin/attachment/upload', '上传附件', '172.17.0.1', '2025-06-17 16:01:46', '2025-06-17 16:01:46', NULL, '[]', 200, 1, '{\"request_id\":\"0f631df5-ae58-46e4-9191-a648f78145c5\",\"path\":\"\\/admin\\/attachment\\/upload\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\",\"data\":[{\"id\":9,\"storage_mode\":0,\"origin_name\":\"503d269759ee3d6d44bb596fd79ac9244e4adeac.jpeg\",\"object_name\":\"54832c49bb0b7211be78de3699948702.jpeg\",\"hash\":\"54832c49bb0b7211be78de3699948702\",\"mime_type\":\"image\\/jpeg\",\"storage_path\":\"\\/data\\/project\\/byapay\\/newpay\\/public\\/upload\\/54832c49bb0b7211be78de3699948702.jpeg\",\"base_path\":\"\\/upload\\/54832c49bb0b7211be78de3699948702.jpeg\",\"suffix\":\"jpeg\",\"url\":\"http:\\/\\/127.0.0.1:9501\\/upload\\/54832c49bb0b7211be78de3699948702.jpeg\",\"size_byte\":19420,\"size_info\":\"18.96 KB\",\"remark\":null,\"created_at\":\"2025-06-17T07:41:50.000000Z\",\"updated_at\":\"2025-06-17T07:41:50.000000Z\",\"created_by\":null,\"updated_by\":0},{\"id\":16,\"storage_mode\":0,\"origin_name\":\"503d269759ee3d6d44bb596fd79ac9244e4adeac.jpeg\",\"object_name\":\"54832c49bb0b7211be78de3699948702.jpeg\",\"hash\":\"54832c49bb0b7211be78de3699948702\",\"mime_type\":\"image\\/jpeg\",\"storage_path\":\"\\/data\\/project\\/byapay\\/newpay\\/public\\/upload\\/54832c49bb0b7211be78de3699948702.jpeg\",\"base_path\":\"\\/upload\\/54832c49bb0b7211be78de3699948702.jpeg\",\"suffix\":\"jpeg\",\"url\":\"http:\\/\\/127.0.0.1:9501\\/upload\\/54832c49bb0b7211be78de3699948702.jpeg\",\"size_byte\":19420,\"size_info\":\"18.96 KB\",\"remark\":null,\"created_at\":\"2025-06-17T07:59:26.000000Z\",\"updated_at\":\"2025-06-17T07:59:26.000000Z\",\"created_by\":null,\"updated_by\":0}]}', 1, '0f631df5-ae58-46e4-9191-a648f78145c5', 536);
INSERT INTO `user_operation_log` VALUES (75, 'admin', 'POST', '/admin/attachment/upload', '上传附件', '172.17.0.1', '2025-06-17 16:04:14', '2025-06-17 16:04:14', NULL, '[]', 200, 1, '{\"request_id\":\"c7d3a15e-4df6-4add-9467-06f0bc9da3e4\",\"path\":\"\\/admin\\/attachment\\/upload\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\",\"data\":{\"id\":13,\"storage_mode\":0,\"origin_name\":\"060828381f30e9244d0cd00a0e3905031d95f71c.jpeg\",\"object_name\":\"dd942666582b70fb29b5b57aa8d00c82.jpeg\",\"hash\":\"dd942666582b70fb29b5b57aa8d00c82\",\"mime_type\":\"image\\/jpeg\",\"storage_path\":\"\\/data\\/project\\/byapay\\/newpay\\/public\\/upload\\/dd942666582b70fb29b5b57aa8d00c82.jpeg\",\"base_path\":\"\\/upload\\/dd942666582b70fb29b5b57aa8d00c82.jpeg\",\"suffix\":\"jpeg\",\"url\":\"http:\\/\\/127.0.0.1:9501\\/upload\\/dd942666582b70fb29b5b57aa8d00c82.jpeg\",\"size_byte\":55076,\"size_info\":\"53.79 KB\",\"remark\":null,\"created_at\":\"2025-06-17T07:53:38.000000Z\",\"updated_at\":\"2025-06-17T07:53:38.000000Z\",\"created_by\":null,\"updated_by\":0}}', 1, 'c7d3a15e-4df6-4add-9467-06f0bc9da3e4', 634);
INSERT INTO `user_operation_log` VALUES (76, 'admin', 'POST', '/admin/attachment/upload', '上传附件', '172.17.0.1', '2025-06-17 16:05:12', '2025-06-17 16:05:12', NULL, '[]', 200, 1, '{\"request_id\":\"436f1e4e-9c91-433c-8d78-b855de1fdfa3\",\"path\":\"\\/admin\\/attachment\\/upload\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\",\"data\":{\"id\":9,\"storage_mode\":0,\"origin_name\":\"503d269759ee3d6d44bb596fd79ac9244e4adeac.jpeg\",\"object_name\":\"54832c49bb0b7211be78de3699948702.jpeg\",\"hash\":\"54832c49bb0b7211be78de3699948702\",\"mime_type\":\"image\\/jpeg\",\"storage_path\":\"\\/data\\/project\\/byapay\\/newpay\\/public\\/upload\\/54832c49bb0b7211be78de3699948702.jpeg\",\"base_path\":\"\\/upload\\/54832c49bb0b7211be78de3699948702.jpeg\",\"suffix\":\"jpeg\",\"url\":\"http:\\/\\/127.0.0.1:9501\\/upload\\/54832c49bb0b7211be78de3699948702.jpeg\",\"size_byte\":19420,\"size_info\":\"18.96 KB\",\"remark\":null,\"created_at\":\"2025-06-17T07:41:50.000000Z\",\"updated_at\":\"2025-06-17T07:41:50.000000Z\",\"created_by\":null,\"updated_by\":0}}', 1, '436f1e4e-9c91-433c-8d78-b855de1fdfa3', 512);
INSERT INTO `user_operation_log` VALUES (77, 'admin', 'POST', '/admin/attachment/upload', '上传附件', '172.17.0.1', '2025-06-17 16:05:20', '2025-06-17 16:05:20', NULL, '[]', 200, 1, '{\"request_id\":\"65788dec-8d21-4446-bfcd-4c4daeefc493\",\"path\":\"\\/admin\\/attachment\\/upload\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\",\"data\":{\"id\":14,\"storage_mode\":0,\"origin_name\":\"1496310615-7581415540694987.jpg\",\"object_name\":\"ffda6f9ea824b07d64cf074d25232acf.jpg\",\"hash\":\"ffda6f9ea824b07d64cf074d25232acf\",\"mime_type\":\"image\\/jpeg\",\"storage_path\":\"\\/data\\/project\\/byapay\\/newpay\\/public\\/upload\\/ffda6f9ea824b07d64cf074d25232acf.jpg\",\"base_path\":\"\\/upload\\/ffda6f9ea824b07d64cf074d25232acf.jpg\",\"suffix\":\"jpg\",\"url\":\"http:\\/\\/127.0.0.1:9501\\/upload\\/ffda6f9ea824b07d64cf074d25232acf.jpg\",\"size_byte\":49671,\"size_info\":\"48.51 KB\",\"remark\":null,\"created_at\":\"2025-06-17T07:55:22.000000Z\",\"updated_at\":\"2025-06-17T07:55:22.000000Z\",\"created_by\":null,\"updated_by\":0}}', 1, '65788dec-8d21-4446-bfcd-4c4daeefc493', 527);
INSERT INTO `user_operation_log` VALUES (78, 'admin', 'PUT', '/admin/menu/58', '编辑菜单', '172.17.0.1', '2025-06-20 14:04:14', '2025-06-20 14:04:14', NULL, '{\"dataType\":\"edit\",\"id\":58,\"parent_id\":0,\"name\":\"recycleBin\",\"path\":\"\\/recycleBin\",\"meta\":{\"i18n\":\"recycleBin.index\",\"icon\":\"mdi:recycle-variant\",\"type\":\"M\",\"affix\":false,\"cache\":true,\"title\":\"\\u56de\\u6536\\u7ad9\",\"hidden\":false,\"copyright\":true,\"componentPath\":\"modules\\/\",\"componentSuffix\":\".vue\",\"breadcrumbEnable\":true},\"component\":\"base\\/views\\/RecycleBin\\/index\",\"sort\":0,\"status\":1,\"btnPermission\":[{\"id\":59,\"code\":\"recycleBin:list\",\"title\":\"\\u56de\\u6536\\u7ad9\\u5217\\u8868\",\"i18n\":\"recycleBin.list\",\"type\":\"B\"},{\"id\":60,\"code\":\"recycleBin:update\",\"title\":\"\\u56de\\u6536\\u7ad9\\u6062\\u590d\",\"i18n\":\"recycleBin.restore\",\"type\":\"B\"}],\"redirect\":\"\",\"created_by\":0,\"updated_by\":1,\"created_at\":\"2025-06-18T22:01:00.000000Z\",\"updated_at\":\"2025-06-19T14:53:12.000000Z\",\"remark\":\"\"}', 200, 1, '{\"request_id\":\"ac6eb704-fbdf-42bb-a488-7801c6ce2698\",\"path\":\"\\/admin\\/menu\\/58\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\"}', 1, 'ac6eb704-fbdf-42bb-a488-7801c6ce2698', 690);
INSERT INTO `user_operation_log` VALUES (79, 'admin', 'POST', '/admin/attachment/upload', '上传附件', '185.36.195.248', '2025-06-21 08:57:39', '2025-06-21 08:57:39', NULL, '[]', 200, 1, '{\"request_id\":\"53861054-4291-4524-99a3-6eb71f85eb7a\",\"path\":\"\\/admin\\/attachment\\/upload\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\",\"data\":{\"id\":13,\"storage_mode\":0,\"origin_name\":\"060828381f30e9244d0cd00a0e3905031d95f71c.jpeg\",\"object_name\":\"dd942666582b70fb29b5b57aa8d00c82.jpeg\",\"hash\":\"dd942666582b70fb29b5b57aa8d00c82\",\"mime_type\":\"image\\/jpeg\",\"storage_path\":\"\\/data\\/project\\/byapay\\/newpay\\/public\\/upload\\/dd942666582b70fb29b5b57aa8d00c82.jpeg\",\"base_path\":\"\\/upload\\/dd942666582b70fb29b5b57aa8d00c82.jpeg\",\"suffix\":\"jpeg\",\"url\":\"http:\\/\\/127.0.0.1:9501\\/upload\\/dd942666582b70fb29b5b57aa8d00c82.jpeg\",\"size_byte\":55076,\"size_info\":\"53.79 KB\",\"remark\":null,\"created_at\":\"2025-06-17T07:53:38.000000Z\",\"updated_at\":\"2025-06-17T07:53:38.000000Z\",\"created_by\":null,\"updated_by\":0}}', 1, '53861054-4291-4524-99a3-6eb71f85eb7a', 13);
INSERT INTO `user_operation_log` VALUES (80, 'admin', 'POST', '/admin/attachment/upload', '上传附件', '185.36.195.248', '2025-06-21 08:57:52', '2025-06-21 08:57:52', NULL, '[]', 200, 1, '{\"request_id\":\"f46d4ccd-db3c-45a8-a084-b9539a944750\",\"path\":\"\\/admin\\/attachment\\/upload\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\",\"data\":{\"storage_mode\":0,\"origin_name\":\"rw_1.png\",\"object_name\":\"c7500dd23143ecfe03cd700d4c685231.png\",\"hash\":\"c7500dd23143ecfe03cd700d4c685231\",\"mime_type\":\"image\\/png\",\"base_path\":\"\\/upload\\/c7500dd23143ecfe03cd700d4c685231.png\",\"suffix\":\"png\",\"size_byte\":44631,\"size_info\":\"43.58 KB\",\"url\":\"http:\\/\\/127.0.0.1:9501\\/upload\\/c7500dd23143ecfe03cd700d4c685231.png\",\"storage_path\":\"\\/opt\\/www\\/public\\/upload\\/c7500dd23143ecfe03cd700d4c685231.png\",\"updated_at\":\"2025-06-21T00:57:52.000000Z\",\"created_at\":\"2025-06-21T00:57:52.000000Z\",\"id\":18}}', 1, 'f46d4ccd-db3c-45a8-a084-b9539a944750', 11);
INSERT INTO `user_operation_log` VALUES (81, 'admin', 'POST', '/admin/attachment/upload', '上传附件', '185.36.195.242', '2025-06-21 09:01:15', '2025-06-21 09:01:15', NULL, '[]', 200, 1, '{\"request_id\":\"c8e0c8db-611a-47fc-8d43-d2087dd935a0\",\"path\":\"\\/admin\\/attachment\\/upload\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\",\"data\":{\"storage_mode\":0,\"origin_name\":\"zhu.png\",\"object_name\":\"4a2a2bbef37178f660ba8c7f6c8ed7f0.png\",\"hash\":\"4a2a2bbef37178f660ba8c7f6c8ed7f0\",\"mime_type\":\"image\\/png\",\"base_path\":\"\\/upload\\/4a2a2bbef37178f660ba8c7f6c8ed7f0.png\",\"suffix\":\"png\",\"size_byte\":250460,\"size_info\":\"244.59 KB\",\"url\":\"http:\\/\\/127.0.0.1:9501\\/upload\\/4a2a2bbef37178f660ba8c7f6c8ed7f0.png\",\"storage_path\":\"\\/opt\\/www\\/public\\/upload\\/4a2a2bbef37178f660ba8c7f6c8ed7f0.png\",\"updated_at\":\"2025-06-21T01:01:15.000000Z\",\"created_at\":\"2025-06-21T01:01:15.000000Z\",\"id\":19}}', 1, 'c8e0c8db-611a-47fc-8d43-d2087dd935a0', 17);
INSERT INTO `user_operation_log` VALUES (82, 'admin', 'POST', '/admin/attachment/upload', '上传附件', '185.36.195.240', '2025-06-21 09:05:08', '2025-06-21 09:05:08', NULL, '[]', 200, 1, '{\"request_id\":\"b5e788ea-fe9c-4048-8bc9-8710fbb10076\",\"path\":\"\\/admin\\/attachment\\/upload\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\",\"data\":{\"storage_mode\":0,\"origin_name\":\"Loading1.png\",\"object_name\":\"7a8d99685b2b0b1ab94afd4926138211.png\",\"hash\":\"7a8d99685b2b0b1ab94afd4926138211\",\"mime_type\":\"image\\/png\",\"base_path\":\"\\/upload\\/7a8d99685b2b0b1ab94afd4926138211.png\",\"suffix\":\"png\",\"size_byte\":1367874,\"size_info\":\"1.3 MB\",\"url\":\"https:\\/\\/server.bug.it.com\\/upload\\/7a8d99685b2b0b1ab94afd4926138211.png\",\"storage_path\":\"\\/opt\\/www\\/public\\/upload\\/7a8d99685b2b0b1ab94afd4926138211.png\",\"updated_at\":\"2025-06-21T01:05:08.000000Z\",\"created_at\":\"2025-06-21T01:05:08.000000Z\",\"id\":20}}', 1, 'b5e788ea-fe9c-4048-8bc9-8710fbb10076', 25);
INSERT INTO `user_operation_log` VALUES (83, 'admin', 'POST', '/admin/setting/config/batchUpdate', '批量更新系统配置', '185.36.195.240', '2025-06-21 09:05:14', '2025-06-21 09:05:14', NULL, '[{\"id\":13,\"group_id\":1,\"key\":\"site_logo\",\"value\":\"https:\\/\\/server.bug.it.com\\/upload\\/7a8d99685b2b0b1ab94afd4926138211.png\",\"name\":\"\\u7ad9\\u70b9Logo\",\"input_type\":\"imageUpload\",\"config_select_data\":[],\"sort\":0,\"remark\":null,\"created_by\":1,\"updated_by\":null,\"created_at\":\"2025-06-14T00:30:48.000000Z\",\"updated_at\":\"2025-06-14T00:30:48.000000Z\"},{\"id\":12,\"group_id\":1,\"key\":\"site_name\",\"value\":\"3333es\",\"name\":\"\\u7ad9\\u70b9\\u540d\\u79f0\",\"input_type\":\"input\",\"config_select_data\":[],\"sort\":99,\"remark\":null,\"created_by\":1,\"updated_by\":null,\"created_at\":\"2025-06-14T00:28:47.000000Z\",\"updated_at\":\"2025-06-16T18:44:09.000000Z\"},{\"id\":11,\"group_id\":1,\"key\":\"site_open\",\"value\":false,\"name\":\"\\u7ad9\\u70b9\\u5f00\\u542f\",\"input_type\":\"switch\",\"config_select_data\":[],\"sort\":101,\"remark\":\"\\u662f\\u5426\\u5bf9\\u5916\\u63d0\\u4f9b\\u7f51\\u7edc\\u670d\\u52a1\",\"created_by\":1,\"updated_by\":null,\"created_at\":\"2025-06-14T00:20:11.000000Z\",\"updated_at\":\"2025-06-14T00:20:11.000000Z\"}]', 200, 1, '{\"request_id\":\"24a4742b-f8c1-4fa0-9730-e42c2309520b\",\"path\":\"\\/admin\\/setting\\/config\\/batchUpdate\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\"}', 1, '24a4742b-f8c1-4fa0-9730-e42c2309520b', 11);
INSERT INTO `user_operation_log` VALUES (84, 'admin', 'PUT', '/admin/menu/58', '编辑菜单', '185.36.195.248', '2025-06-21 09:09:48', '2025-06-21 09:09:48', NULL, '{\"dataType\":\"edit\",\"id\":58,\"parent_id\":29,\"name\":\"recycleBin\",\"path\":\"\\/recycleBin\",\"meta\":{\"i18n\":\"recycleBin.index\",\"icon\":\"mdi:recycle-variant\",\"type\":\"M\",\"affix\":false,\"cache\":true,\"title\":\"\\u56de\\u6536\\u7ad9\",\"hidden\":false,\"copyright\":true,\"componentPath\":\"modules\\/\",\"componentSuffix\":\".vue\",\"breadcrumbEnable\":true},\"component\":\"base\\/views\\/RecycleBin\\/index\",\"sort\":0,\"status\":1,\"btnPermission\":[{\"id\":59,\"code\":\"recycleBin:list\",\"title\":\"\\u56de\\u6536\\u7ad9\\u5217\\u8868\",\"i18n\":\"recycleBin.list\",\"type\":\"B\"},{\"id\":60,\"code\":\"recycleBin:update\",\"title\":\"\\u56de\\u6536\\u7ad9\\u6062\\u590d\",\"i18n\":\"recycleBin.restore\",\"type\":\"B\"}],\"redirect\":\"\",\"created_by\":0,\"updated_by\":1,\"created_at\":\"2025-06-18T22:01:00.000000Z\",\"updated_at\":\"2025-06-20T06:04:14.000000Z\",\"remark\":\"\"}', 200, 1, '{\"request_id\":\"3be23a33-5a08-4049-8fdd-8187c04b7f49\",\"path\":\"\\/admin\\/menu\\/58\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\"}', 1, '3be23a33-5a08-4049-8fdd-8187c04b7f49', 15);
INSERT INTO `user_operation_log` VALUES (85, 'admin', 'PUT', '/admin/menu/61', '编辑菜单', '172.17.0.1', '2025-06-22 03:57:26', '2025-06-22 03:57:26', NULL, '{\"dataType\":\"edit\",\"id\":61,\"parent_id\":0,\"name\":\"tenant\",\"path\":\"\\/tenant\",\"meta\":{\"i18n\":\"tenant\",\"icon\":\"\",\"type\":\"M\",\"affix\":false,\"cache\":true,\"title\":\"\\u79df\\u6237\\u7ba1\\u7406\",\"hidden\":false,\"copyright\":true,\"componentPath\":\"modules\\/\",\"componentSuffix\":\".vue\",\"breadcrumbEnable\":true},\"component\":\"tenant\\/views\\/Tenant\\/index\",\"sort\":0,\"status\":1,\"btnPermission\":[{\"id\":62,\"code\":\"tenant:tenant:list\",\"title\":\"\\u79df\\u6237\\u7ba1\\u7406\\u5217\\u8868\",\"i18n\":\"tenant.tenant.list\",\"type\":\"B\"},{\"id\":63,\"code\":\"tenant:tenant:create\",\"title\":\"\\u79df\\u6237\\u7ba1\\u7406\\u65b0\\u589e\",\"i18n\":\"tenant.tenant.create\",\"type\":\"B\"},{\"id\":64,\"code\":\"tenant:tenant:update\",\"title\":\"\\u79df\\u6237\\u7ba1\\u7406\\u7f16\\u8f91\",\"i18n\":\"tenant.tenant.update\",\"type\":\"B\"},{\"id\":65,\"code\":\"tenant:tenant:delete\",\"title\":\"\\u79df\\u6237\\u7ba1\\u7406\\u5220\\u9664\",\"i18n\":\"tenant.tenant.delete\",\"type\":\"B\"}],\"redirect\":\"\",\"created_by\":0,\"updated_by\":1,\"created_at\":\"2025-06-19T10:21:40.000000Z\",\"updated_at\":\"2025-06-19T14:52:44.000000Z\",\"remark\":\"\"}', 200, 1, '{\"request_id\":\"50721f30-9844-42a9-85a5-c2b930ef169d\",\"path\":\"\\/admin\\/menu\\/61\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\"}', 1, '50721f30-9844-42a9-85a5-c2b930ef169d', 1185);
INSERT INTO `user_operation_log` VALUES (86, 'admin', 'PUT', '/admin/menu/61', '编辑菜单', '172.17.0.1', '2025-06-22 04:01:42', '2025-06-22 04:01:42', NULL, '{\"dataType\":\"edit\",\"id\":61,\"parent_id\":0,\"name\":\"tenant\",\"path\":\"\\/tenant\",\"meta\":{\"i18n\":\"tenant.index\",\"icon\":\"mdi:store-outline\",\"type\":\"M\",\"affix\":false,\"cache\":true,\"title\":\"\\u79df\\u6237\\u7ba1\\u7406\",\"hidden\":false,\"copyright\":true,\"componentPath\":\"modules\\/\",\"componentSuffix\":\".vue\",\"breadcrumbEnable\":true},\"component\":\"tenant\\/views\\/Tenant\\/index\",\"sort\":0,\"status\":1,\"btnPermission\":[{\"id\":62,\"code\":\"tenant:tenant:list\",\"title\":\"\\u79df\\u6237\\u7ba1\\u7406\\u5217\\u8868\",\"i18n\":\"tenant.tenant.list\",\"type\":\"B\"},{\"id\":63,\"code\":\"tenant:tenant:create\",\"title\":\"\\u79df\\u6237\\u7ba1\\u7406\\u65b0\\u589e\",\"i18n\":\"tenant.tenant.create\",\"type\":\"B\"},{\"id\":64,\"code\":\"tenant:tenant:update\",\"title\":\"\\u79df\\u6237\\u7ba1\\u7406\\u7f16\\u8f91\",\"i18n\":\"tenant.tenant.update\",\"type\":\"B\"},{\"id\":65,\"code\":\"tenant:tenant:delete\",\"title\":\"\\u79df\\u6237\\u7ba1\\u7406\\u5220\\u9664\",\"i18n\":\"tenant.tenant.delete\",\"type\":\"B\"}],\"redirect\":\"\",\"created_by\":0,\"updated_by\":1,\"created_at\":\"2025-06-19T10:21:40.000000Z\",\"updated_at\":\"2025-06-21T19:57:25.000000Z\",\"remark\":\"\"}', 200, 1, '{\"request_id\":\"8148d771-4df3-471d-8bb4-37eeef7b4434\",\"path\":\"\\/admin\\/menu\\/61\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\"}', 1, '8148d771-4df3-471d-8bb4-37eeef7b4434', 895);
INSERT INTO `user_operation_log` VALUES (87, 'admin', 'PUT', '/admin/menu/66', '编辑菜单', '172.17.0.1', '2025-06-22 04:04:52', '2025-06-22 04:04:52', NULL, '{\"dataType\":\"edit\",\"id\":66,\"parent_id\":0,\"name\":\"tenantApp\",\"path\":\"\\/tenantapp\",\"meta\":{\"i18n\":\"tenantApp.index\",\"icon\":\"ri:apps-line\",\"type\":\"M\",\"affix\":false,\"cache\":true,\"title\":\"\\u79df\\u6237\\u5e94\\u7528\",\"hidden\":false,\"copyright\":true,\"componentPath\":\"modules\\/\",\"componentSuffix\":\".vue\",\"breadcrumbEnable\":true},\"component\":\"tenant\\/views\\/TenantApp\\/Index\",\"sort\":0,\"status\":1,\"btnPermission\":[{\"id\":67,\"code\":\"tenantapp:tenant_app:list\",\"title\":\"\\u79df\\u6237\\u5e94\\u7528\\u5217\\u8868\",\"i18n\":\"tenantapp.tenant_app.list\",\"type\":\"B\"},{\"id\":68,\"code\":\"tenantapp:tenant_app:create\",\"title\":\"\\u79df\\u6237\\u5e94\\u7528\\u65b0\\u589e\",\"i18n\":\"tenantapp.tenant_app.create\",\"type\":\"B\"},{\"id\":69,\"code\":\"tenantapp:tenant_app:update\",\"title\":\"\\u79df\\u6237\\u5e94\\u7528\\u7f16\\u8f91\",\"i18n\":\"tenantapp.tenant_app.update\",\"type\":\"B\"},{\"id\":70,\"code\":\"tenantapp:tenant_app:delete\",\"title\":\"\\u79df\\u6237\\u5e94\\u7528\\u5220\\u9664\",\"i18n\":\"tenantapp.tenant_app.delete\",\"type\":\"B\"}],\"redirect\":\"\",\"created_by\":0,\"updated_by\":1,\"created_at\":\"2025-06-19T14:38:31.000000Z\",\"updated_at\":\"2025-06-19T14:52:25.000000Z\",\"remark\":\"\"}', 200, 1, '{\"request_id\":\"8c183699-cc14-43d6-82d0-98fe1c22b2fa\",\"path\":\"\\/admin\\/menu\\/66\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\"}', 1, '8c183699-cc14-43d6-82d0-98fe1c22b2fa', 888);
INSERT INTO `user_operation_log` VALUES (88, 'admin', 'PUT', '/admin/menu/67', '编辑菜单', '172.17.0.1', '2025-06-22 04:32:20', '2025-06-22 04:32:20', NULL, '{\"dataType\":\"edit\",\"id\":67,\"parent_id\":61,\"name\":\"tenantApp\",\"path\":\"\\/tenantapp\",\"meta\":{\"i18n\":\"tenantApp.index\",\"icon\":\"\",\"type\":\"M\",\"affix\":false,\"cache\":true,\"title\":\"\\u79df\\u6237\\u5e94\\u7528\",\"hidden\":false,\"copyright\":true,\"componentPath\":\"modules\\/\",\"componentSuffix\":\".vue\",\"breadcrumbEnable\":true},\"component\":\"tenant\\/views\\/TenantApp\\/Index\",\"sort\":0,\"status\":1,\"btnPermission\":[{\"id\":68,\"code\":\"tenantapp:tenant_app:list\",\"title\":\"\\u79df\\u6237\\u5e94\\u7528\\u5217\\u8868\",\"i18n\":\"tenantapp.tenant_app.list\",\"type\":\"B\"},{\"id\":69,\"code\":\"tenantapp:tenant_app:create\",\"title\":\"\\u79df\\u6237\\u5e94\\u7528\\u65b0\\u589e\",\"i18n\":\"tenantapp.tenant_app.create\",\"type\":\"B\"},{\"id\":70,\"code\":\"tenantapp:tenant_app:update\",\"title\":\"\\u79df\\u6237\\u5e94\\u7528\\u7f16\\u8f91\",\"i18n\":\"tenantapp.tenant_app.update\",\"type\":\"B\"},{\"id\":71,\"code\":\"tenantapp:tenant_app:delete\",\"title\":\"\\u79df\\u6237\\u5e94\\u7528\\u5220\\u9664\",\"i18n\":\"tenantapp.tenant_app.delete\",\"type\":\"B\"}],\"redirect\":\"\",\"created_by\":0,\"updated_by\":1,\"created_at\":\"2025-06-19T14:38:31.000000Z\",\"updated_at\":\"2025-06-19T14:52:25.000000Z\",\"remark\":\"\"}', 200, 1, '{\"request_id\":\"c9bafbc4-0922-4c13-9648-c8c7064d689d\",\"path\":\"\\/admin\\/menu\\/67\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\"}', 1, 'c9bafbc4-0922-4c13-9648-c8c7064d689d', 1135);
INSERT INTO `user_operation_log` VALUES (89, 'admin', 'PUT', '/admin/menu/62', '编辑菜单', '172.17.0.1', '2025-06-22 04:32:27', '2025-06-22 04:32:27', NULL, '{\"dataType\":\"edit\",\"id\":62,\"parent_id\":61,\"name\":\"tenant:tenant\",\"path\":\"\\/tenant\",\"meta\":{\"i18n\":\"tenant.index\",\"icon\":\"\",\"type\":\"M\",\"affix\":false,\"cache\":true,\"title\":\"\\u79df\\u6237\\u7ba1\\u7406\",\"hidden\":false,\"copyright\":true,\"componentPath\":\"modules\\/\",\"componentSuffix\":\".vue\",\"breadcrumbEnable\":true},\"component\":\"tenant\\/views\\/Tenant\\/index\",\"sort\":0,\"status\":1,\"btnPermission\":[{\"id\":63,\"code\":\"tenant:tenant:list\",\"title\":\"\\u79df\\u6237\\u7ba1\\u7406\\u5217\\u8868\",\"i18n\":\"tenant.tenant.list\",\"type\":\"B\"},{\"id\":64,\"code\":\"tenant:tenant:create\",\"title\":\"\\u79df\\u6237\\u7ba1\\u7406\\u65b0\\u589e\",\"i18n\":\"tenant.tenant.create\",\"type\":\"B\"},{\"id\":65,\"code\":\"tenant:tenant:update\",\"title\":\"\\u79df\\u6237\\u7ba1\\u7406\\u7f16\\u8f91\",\"i18n\":\"tenant.tenant.update\",\"type\":\"B\"},{\"id\":66,\"code\":\"tenant:tenant:delete\",\"title\":\"\\u79df\\u6237\\u7ba1\\u7406\\u5220\\u9664\",\"i18n\":\"tenant.tenant.delete\",\"type\":\"B\"}],\"redirect\":\"\",\"created_by\":0,\"updated_by\":1,\"created_at\":\"2025-06-19T10:21:40.000000Z\",\"updated_at\":\"2025-06-21T19:57:25.000000Z\",\"remark\":\"\"}', 200, 1, '{\"request_id\":\"f24b96d7-c335-4ecb-8d26-e51ef54aa5eb\",\"path\":\"\\/admin\\/menu\\/62\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\"}', 1, 'f24b96d7-c335-4ecb-8d26-e51ef54aa5eb', 950);
INSERT INTO `user_operation_log` VALUES (90, 'admin', 'PUT', '/admin/menu/62', '编辑菜单', '172.17.0.1', '2025-06-22 04:33:29', '2025-06-22 04:33:29', NULL, '{\"dataType\":\"edit\",\"id\":62,\"parent_id\":61,\"name\":\"tenant:tenant\",\"path\":\"\\/tenant\",\"meta\":{\"i18n\":\"tenant.index\",\"icon\":\"mdi:store-cog-outline\",\"type\":\"M\",\"affix\":false,\"cache\":true,\"title\":\"\\u79df\\u6237\\u7ba1\\u7406\",\"hidden\":false,\"copyright\":true,\"componentPath\":\"modules\\/\",\"componentSuffix\":\".vue\",\"breadcrumbEnable\":true},\"component\":\"tenant\\/views\\/Tenant\\/index\",\"sort\":0,\"status\":1,\"btnPermission\":[{\"id\":63,\"code\":\"tenant:tenant:list\",\"title\":\"\\u79df\\u6237\\u7ba1\\u7406\\u5217\\u8868\",\"i18n\":\"tenant.tenant.list\",\"type\":\"B\"},{\"id\":64,\"code\":\"tenant:tenant:create\",\"title\":\"\\u79df\\u6237\\u7ba1\\u7406\\u65b0\\u589e\",\"i18n\":\"tenant.tenant.create\",\"type\":\"B\"},{\"id\":65,\"code\":\"tenant:tenant:update\",\"title\":\"\\u79df\\u6237\\u7ba1\\u7406\\u7f16\\u8f91\",\"i18n\":\"tenant.tenant.update\",\"type\":\"B\"},{\"id\":66,\"code\":\"tenant:tenant:delete\",\"title\":\"\\u79df\\u6237\\u7ba1\\u7406\\u5220\\u9664\",\"i18n\":\"tenant.tenant.delete\",\"type\":\"B\"}],\"redirect\":\"\",\"created_by\":0,\"updated_by\":1,\"created_at\":\"2025-06-19T10:21:40.000000Z\",\"updated_at\":\"2025-06-21T19:57:25.000000Z\",\"remark\":\"\"}', 200, 1, '{\"request_id\":\"79a4f057-86cf-499a-8729-7b40ab44d2d8\",\"path\":\"\\/admin\\/menu\\/62\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\"}', 1, '79a4f057-86cf-499a-8729-7b40ab44d2d8', 891);
INSERT INTO `user_operation_log` VALUES (91, 'admin', 'PUT', '/admin/menu/67', '编辑菜单', '172.17.0.1', '2025-06-22 04:34:07', '2025-06-22 04:34:07', NULL, '{\"dataType\":\"edit\",\"id\":67,\"parent_id\":61,\"name\":\"tenantApp\",\"path\":\"\\/tenantapp\",\"meta\":{\"i18n\":\"tenantApp.index\",\"icon\":\"ri:apps-line\",\"type\":\"M\",\"affix\":false,\"cache\":true,\"title\":\"\\u79df\\u6237\\u5e94\\u7528\",\"hidden\":false,\"copyright\":true,\"componentPath\":\"modules\\/\",\"componentSuffix\":\".vue\",\"breadcrumbEnable\":true},\"component\":\"tenant\\/views\\/TenantApp\\/Index\",\"sort\":0,\"status\":1,\"btnPermission\":[{\"id\":68,\"code\":\"tenantapp:tenant_app:list\",\"title\":\"\\u79df\\u6237\\u5e94\\u7528\\u5217\\u8868\",\"i18n\":\"tenantapp.tenant_app.list\",\"type\":\"B\"},{\"id\":69,\"code\":\"tenantapp:tenant_app:create\",\"title\":\"\\u79df\\u6237\\u5e94\\u7528\\u65b0\\u589e\",\"i18n\":\"tenantapp.tenant_app.create\",\"type\":\"B\"},{\"id\":70,\"code\":\"tenantapp:tenant_app:update\",\"title\":\"\\u79df\\u6237\\u5e94\\u7528\\u7f16\\u8f91\",\"i18n\":\"tenantapp.tenant_app.update\",\"type\":\"B\"},{\"id\":71,\"code\":\"tenantapp:tenant_app:delete\",\"title\":\"\\u79df\\u6237\\u5e94\\u7528\\u5220\\u9664\",\"i18n\":\"tenantapp.tenant_app.delete\",\"type\":\"B\"}],\"redirect\":\"\",\"created_by\":0,\"updated_by\":1,\"created_at\":\"2025-06-19T14:38:31.000000Z\",\"updated_at\":\"2025-06-21T20:32:19.000000Z\",\"remark\":\"\"}', 200, 1, '{\"request_id\":\"b7cf6ac2-ab79-41e6-bad7-4f5f129c8859\",\"path\":\"\\/admin\\/menu\\/67\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\"}', 1, 'b7cf6ac2-ab79-41e6-bad7-4f5f129c8859', 887);
INSERT INTO `user_operation_log` VALUES (92, 'admin', 'PUT', '/admin/menu/72', '编辑菜单', '172.17.0.1', '2025-06-23 01:08:40', '2025-06-23 01:08:40', NULL, '{\"dataType\":\"edit\",\"id\":72,\"parent_id\":61,\"name\":\"TenantUser\",\"path\":\"\\/tenant\\/TenantUser\",\"meta\":{\"i18n\":\"tenantUser.index\",\"icon\":\"heroicons:user-group\",\"type\":\"M\",\"affix\":false,\"cache\":true,\"title\":\"\\u79df\\u6237\\u6210\\u5458\",\"hidden\":false,\"copyright\":true,\"componentPath\":\"modules\\/\",\"componentSuffix\":\".vue\",\"breadcrumbEnable\":true},\"component\":\"tenant\\/views\\/TenantUser\\/Index\",\"sort\":0,\"status\":1,\"btnPermission\":[{\"id\":73,\"code\":\"tenant:tenant_user:list\",\"title\":\"\\u79df\\u6237\\u6210\\u5458\\u5217\\u8868\",\"i18n\":\"tenant.tenant_user.list\",\"type\":\"B\"},{\"id\":74,\"code\":\"tenant:tenant_user:create\",\"title\":\"\\u79df\\u6237\\u6210\\u5458\\u65b0\\u589e\",\"i18n\":\"tenant.tenant_user.create\",\"type\":\"B\"},{\"id\":75,\"code\":\"tenant:tenant_user:update\",\"title\":\"\\u79df\\u6237\\u6210\\u5458\\u7f16\\u8f91\",\"i18n\":\"tenant.tenant_user.update\",\"type\":\"B\"},{\"id\":76,\"code\":\"tenant:tenant_user:delete\",\"title\":\"\\u79df\\u6237\\u6210\\u5458\\u5220\\u9664\",\"i18n\":\"tenant.tenant_user.delete\",\"type\":\"B\"}],\"redirect\":\"\",\"created_by\":0,\"updated_by\":0,\"created_at\":\"2025-06-22T08:14:06.000000Z\",\"updated_at\":\"2025-06-22T08:14:06.000000Z\",\"remark\":\"\"}', 200, 1, '{\"request_id\":\"3112c75f-924e-4cdb-8491-9c9e662b7614\",\"path\":\"\\/admin\\/menu\\/72\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\"}', 1, '3112c75f-924e-4cdb-8491-9c9e662b7614', 1167);
INSERT INTO `user_operation_log` VALUES (93, 'admin', 'POST', '/admin/tenant/tenant', '创建租户', '172.17.0.1', '2025-06-23 09:20:58', '2025-06-23 09:20:58', NULL, '{\"is_enabled\":true,\"account_count\":1,\"safe_level\":1,\"company_name\":\"wuha\",\"contact_user_name\":\"haha\",\"contact_phone\":\"12345\"}', 500, 2, '{\"request_id\":\"6a4f791f-b935-4724-9ddc-dd2e9851cf42\",\"path\":\"\\/admin\\/tenant\\/tenant\",\"success\":false,\"code\":100500,\"message\":\"SQLSTATE[42S22]: Column not found: 1054 Unknown column \'created_by\' in \'field list\' (Connection: mysql, SQL: insert into `tenant` (`contact_user_name`, `contact_phone`, `account_count`, `is_enabled`, `safe_level`, `created_by`, `updated_at`, `created_at`) values (haha, 12345, 1, 1, 1, 1, 2025-06-23 09:20:58, 2025-06-23 09:20:58))\"}', 1, '6a4f791f-b935-4724-9ddc-dd2e9851cf42', 268);
INSERT INTO `user_operation_log` VALUES (94, 'admin', 'POST', '/admin/tenant/tenant', '创建租户', '172.17.0.1', '2025-06-23 09:21:10', '2025-06-23 09:21:10', NULL, '{\"is_enabled\":true,\"account_count\":1,\"safe_level\":1,\"company_name\":\"wuha\",\"contact_user_name\":\"haha\",\"contact_phone\":\"12345\"}', 500, 2, '{\"request_id\":\"60f72c0e-8108-4be3-8e84-8be20fb0fe93\",\"path\":\"\\/admin\\/tenant\\/tenant\",\"success\":false,\"code\":100500,\"message\":\"SQLSTATE[42S22]: Column not found: 1054 Unknown column \'created_by\' in \'field list\' (Connection: mysql, SQL: insert into `tenant` (`contact_user_name`, `contact_phone`, `account_count`, `is_enabled`, `safe_level`, `created_by`, `updated_at`, `created_at`) values (haha, 12345, 1, 1, 1, 1, 2025-06-23 09:21:10, 2025-06-23 09:21:10))\"}', 1, '60f72c0e-8108-4be3-8e84-8be20fb0fe93', 91);
INSERT INTO `user_operation_log` VALUES (95, 'admin', 'POST', '/admin/tenant/tenant', '创建租户', '172.17.0.1', '2025-06-23 09:22:28', '2025-06-23 09:22:28', NULL, '{\"is_enabled\":true,\"account_count\":1,\"safe_level\":1,\"company_name\":\"wuha\",\"contact_user_name\":\"haha\",\"contact_phone\":\"12345\"}', 200, 1, '{\"request_id\":\"279cf17a-d295-421b-883b-7f4ba2872360\",\"path\":\"\\/admin\\/tenant\\/tenant\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\"}', 1, '279cf17a-d295-421b-883b-7f4ba2872360', 117);
INSERT INTO `user_operation_log` VALUES (96, 'admin', 'POST', '/admin/tenant/tenant', '创建租户', '172.17.0.1', '2025-06-23 09:33:50', '2025-06-23 09:33:50', NULL, '{\"is_enabled\":true,\"account_count\":1,\"safe_level\":1,\"company_name\":\"haha\",\"contact_user_name\":\"gaxx\",\"contact_phone\":\"11\"}', 200, 1, '{\"request_id\":\"9ac9319a-7369-4e1f-98d8-16d4d5aa9089\",\"path\":\"\\/admin\\/tenant\\/tenant\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\"}', 1, '9ac9319a-7369-4e1f-98d8-16d4d5aa9089', 485);
INSERT INTO `user_operation_log` VALUES (97, 'admin', 'POST', '/admin/tenant/tenant', '创建租户', '172.17.0.1', '2025-06-23 09:35:52', '2025-06-23 09:35:52', NULL, '{\"is_enabled\":true,\"account_count\":1,\"safe_level\":1,\"company_name\":\"dd\",\"contact_user_name\":\"ee\",\"contact_phone\":\"11\"}', 500, 2, '{\"request_id\":\"b96a1da3-e681-4e45-9733-0137082e2560\",\"path\":\"\\/admin\\/tenant\\/tenant\",\"success\":false,\"code\":100500,\"message\":\"Using $this when not in object context\"}', 1, 'b96a1da3-e681-4e45-9733-0137082e2560', 244);
INSERT INTO `user_operation_log` VALUES (98, 'admin', 'POST', '/admin/tenant/tenant', '创建租户', '172.17.0.1', '2025-06-23 09:36:52', '2025-06-23 09:36:52', NULL, '{\"is_enabled\":true,\"account_count\":1,\"safe_level\":1,\"company_name\":\"dd\",\"contact_user_name\":\"ee\",\"contact_phone\":\"11\"}', 500, 2, '{\"request_id\":\"28a6eb96-b687-449f-9bb5-570606a086ab\",\"path\":\"\\/admin\\/tenant\\/tenant\",\"success\":false,\"code\":100500,\"message\":\"A facade root has not been set.\"}', 1, '28a6eb96-b687-449f-9bb5-570606a086ab', 280);
INSERT INTO `user_operation_log` VALUES (99, 'admin', 'POST', '/admin/tenant/tenant', '创建租户', '172.17.0.1', '2025-06-23 09:40:10', '2025-06-23 09:40:10', NULL, '{\"is_enabled\":true,\"account_count\":1,\"safe_level\":1,\"company_name\":\"dd\",\"contact_user_name\":\"ee\",\"contact_phone\":\"11\"}', 200, 1, '{\"request_id\":\"982ab364-7930-46ba-a4b1-b19adfa95c90\",\"path\":\"\\/admin\\/tenant\\/tenant\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\"}', 1, '982ab364-7930-46ba-a4b1-b19adfa95c90', 660);
INSERT INTO `user_operation_log` VALUES (100, 'admin', 'POST', '/admin/tenant/tenant', '创建租户', '172.17.0.1', '2025-06-23 09:47:36', '2025-06-23 09:47:36', NULL, '{\"is_enabled\":true,\"account_count\":1,\"safe_level\":1,\"company_name\":\"fcgdg\",\"contact_user_name\":\"fff\",\"contact_phone\":\"444\"}', 200, 1, '{\"request_id\":\"74afda7e-da2a-4d4c-9873-9d6868df2332\",\"path\":\"\\/admin\\/tenant\\/tenant\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\"}', 1, '74afda7e-da2a-4d4c-9873-9d6868df2332', 347);
INSERT INTO `user_operation_log` VALUES (101, 'admin', 'PUT', '/admin/tenant/tenant/4', '编辑租户', '172.17.0.1', '2025-06-23 09:48:03', '2025-06-23 09:48:03', NULL, '{\"id\":4,\"tenant_id\":\"000003\",\"contact_user_name\":\"fff\",\"contact_phone\":\"444\",\"company_name\":\"fcgdg\",\"license_number\":\"\",\"address\":\"\",\"intro\":\"\",\"domain\":\"\",\"account_count\":1,\"is_enabled\":false,\"created_by\":1,\"created_at\":\"2025-06-23T01:47:35.000000Z\",\"expired_at\":null,\"updated_by\":0,\"updated_at\":\"2025-06-23T01:47:35.000000Z\",\"safe_level\":1,\"deleted_by\":0,\"deleted_at\":null,\"remark\":null}', 500, 2, '{\"request_id\":\"c90640bb-f7ef-4451-9fd5-a4e4cf91b6c6\",\"path\":\"\\/admin\\/tenant\\/tenant\\/4\",\"success\":false,\"code\":100422,\"message\":\"is enabled \\u5fc5\\u987b\\u662f\\u6574\\u6570\\u3002\"}', 1, 'c90640bb-f7ef-4451-9fd5-a4e4cf91b6c6', 5);
INSERT INTO `user_operation_log` VALUES (102, 'admin', 'PUT', '/admin/tenant/tenant/4', '编辑租户', '172.17.0.1', '2025-06-23 09:49:01', '2025-06-23 09:49:01', NULL, '{\"id\":4,\"tenant_id\":\"000003\",\"contact_user_name\":\"fff\",\"contact_phone\":\"444\",\"company_name\":\"fcgdg\",\"license_number\":\"\",\"address\":\"\",\"intro\":\"\",\"domain\":\"\",\"account_count\":1,\"is_enabled\":false,\"created_by\":1,\"created_at\":\"2025-06-23T01:47:35.000000Z\",\"expired_at\":null,\"updated_by\":0,\"updated_at\":\"2025-06-23T01:47:35.000000Z\",\"safe_level\":1,\"deleted_by\":0,\"deleted_at\":null,\"remark\":null}', 200, 1, '{\"request_id\":\"af7eaaa6-f669-4e04-947c-1462dbf4c5e3\",\"path\":\"\\/admin\\/tenant\\/tenant\\/4\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\"}', 1, 'af7eaaa6-f669-4e04-947c-1462dbf4c5e3', 598);
INSERT INTO `user_operation_log` VALUES (103, 'admin', 'DELETE', '/admin/tenant/tenant', '删除租户', '172.17.0.1', '2025-06-23 10:12:19', '2025-06-23 10:12:19', NULL, '[2]', 200, 1, '{\"request_id\":\"d1e71cda-fd30-4d41-875a-dda35dbe574f\",\"path\":\"\\/admin\\/tenant\\/tenant\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\"}', 1, 'd1e71cda-fd30-4d41-875a-dda35dbe574f', 172);
INSERT INTO `user_operation_log` VALUES (104, 'admin', 'DELETE', '/admin/tenant/tenant', '删除租户', '172.17.0.1', '2025-06-23 10:33:48', '2025-06-23 10:33:48', NULL, '[2]', 200, 1, '{\"request_id\":\"58967163-86db-435b-9c12-0c96745dd1ee\",\"path\":\"\\/admin\\/tenant\\/tenant\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\"}', 1, '58967163-86db-435b-9c12-0c96745dd1ee', 172);
INSERT INTO `user_operation_log` VALUES (105, 'admin', 'DELETE', '/admin/tenant/tenant', '删除租户', '172.17.0.1', '2025-06-23 10:35:00', '2025-06-23 10:35:00', NULL, '[2]', 200, 1, '{\"request_id\":\"2d8dbec7-0cd1-413b-99da-29cd7301fed9\",\"path\":\"\\/admin\\/tenant\\/tenant\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\"}', 1, '2d8dbec7-0cd1-413b-99da-29cd7301fed9', 183);
INSERT INTO `user_operation_log` VALUES (106, 'admin', 'DELETE', '/admin/tenant/tenant', '删除租户', '172.17.0.1', '2025-06-23 10:36:24', '2025-06-23 10:36:24', NULL, '[2]', 200, 1, '{\"request_id\":\"57d40192-2498-4850-881f-7c04079e9137\",\"path\":\"\\/admin\\/tenant\\/tenant\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\"}', 1, '57d40192-2498-4850-881f-7c04079e9137', 174);
INSERT INTO `user_operation_log` VALUES (107, 'admin', 'DELETE', '/admin/tenant/tenant', '删除租户', '172.17.0.1', '2025-06-23 11:06:42', '2025-06-23 11:06:42', NULL, '[2]', 200, 1, '{\"request_id\":\"2f48da7d-7d9b-44c8-9b57-a66998eb5f87\",\"path\":\"\\/admin\\/tenant\\/tenant\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\"}', 1, '2f48da7d-7d9b-44c8-9b57-a66998eb5f87', 176);
INSERT INTO `user_operation_log` VALUES (108, 'admin', 'DELETE', '/admin/tenant/tenant', '删除租户', '172.17.0.1', '2025-06-23 11:08:36', '2025-06-23 11:08:36', NULL, '[2]', 200, 1, '{\"request_id\":\"f2fa98d5-7b33-4500-b5c5-e707b5100f8c\",\"path\":\"\\/admin\\/tenant\\/tenant\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\"}', 1, 'f2fa98d5-7b33-4500-b5c5-e707b5100f8c', 187);
INSERT INTO `user_operation_log` VALUES (109, 'admin', 'PUT', '/admin/tenant/tenant/4', '编辑租户', '172.17.0.1', '2025-06-23 11:09:16', '2025-06-23 11:09:16', NULL, '{\"id\":4,\"tenant_id\":\"000003\",\"contact_user_name\":\"fffr\",\"contact_phone\":\"444\",\"company_name\":\"fcgdg\",\"license_number\":\"\",\"address\":\"\",\"intro\":\"\",\"domain\":\"\",\"account_count\":1,\"is_enabled\":false,\"created_by\":1,\"created_at\":\"2025-06-23T01:47:35.000000Z\",\"expired_at\":null,\"updated_by\":1,\"updated_at\":\"2025-06-23T01:49:00.000000Z\",\"safe_level\":1,\"deleted_by\":0,\"deleted_at\":null,\"remark\":null}', 200, 1, '{\"request_id\":\"c671d1c4-cdaf-495a-9a49-da96602683e2\",\"path\":\"\\/admin\\/tenant\\/tenant\\/4\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\"}', 1, 'c671d1c4-cdaf-495a-9a49-da96602683e2', 373);
INSERT INTO `user_operation_log` VALUES (110, 'admin', 'PUT', '/admin/tenant/tenant/4', '编辑租户', '172.17.0.1', '2025-06-23 11:14:33', '2025-06-23 11:14:33', NULL, '{\"id\":4,\"tenant_id\":\"000003\",\"contact_user_name\":\"fffrw\",\"contact_phone\":\"444\",\"company_name\":\"fcgdg2\",\"license_number\":\"\",\"address\":\"\",\"intro\":\"\",\"domain\":\"\",\"account_count\":1,\"is_enabled\":false,\"created_by\":1,\"created_at\":\"2025-06-23T01:47:35.000000Z\",\"expired_at\":null,\"updated_by\":1,\"updated_at\":\"2025-06-23T03:09:16.000000Z\",\"safe_level\":1,\"deleted_by\":0,\"deleted_at\":null,\"remark\":null}', 200, 1, '{\"request_id\":\"dfb02826-7e50-40d3-ad51-a75c354afc96\",\"path\":\"\\/admin\\/tenant\\/tenant\\/4\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\"}', 1, 'dfb02826-7e50-40d3-ad51-a75c354afc96', 627);
INSERT INTO `user_operation_log` VALUES (111, 'admin', 'PUT', '/admin/tenant/tenant/4', '编辑租户', '172.17.0.1', '2025-06-23 11:15:04', '2025-06-23 11:15:04', NULL, '{\"id\":4,\"tenant_id\":\"000003\",\"contact_user_name\":\"fffrwds\",\"contact_phone\":\"444\",\"company_name\":\"fcgdg2\",\"license_number\":\"\",\"address\":\"\",\"intro\":\"\",\"domain\":\"\",\"account_count\":1,\"is_enabled\":false,\"created_by\":1,\"created_at\":\"2025-06-23T01:47:35.000000Z\",\"expired_at\":null,\"updated_by\":1,\"updated_at\":\"2025-06-23T03:14:33.000000Z\",\"safe_level\":1,\"deleted_by\":0,\"deleted_at\":null,\"remark\":null}', 200, 1, '{\"request_id\":\"1738b943-5275-4fef-940c-20410db05413\",\"path\":\"\\/admin\\/tenant\\/tenant\\/4\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\"}', 1, '1738b943-5275-4fef-940c-20410db05413', 174);
INSERT INTO `user_operation_log` VALUES (112, 'admin', 'PUT', '/admin/tenant/tenant/recovery', '租户回收站恢复', '172.17.0.1', '2025-06-24 20:21:41', '2025-06-24 20:21:41', NULL, '{\"data\":[2]}', 500, 2, '{\"request_id\":\"a0228443-6569-4739-822d-7879443f4453\",\"path\":\"\\/admin\\/tenant\\/tenant\\/recovery\",\"success\":false,\"code\":100503,\"message\":\"\\u5931\\u8d25\"}', 1, 'a0228443-6569-4739-822d-7879443f4453', 0);
INSERT INTO `user_operation_log` VALUES (113, 'admin', 'PUT', '/admin/tenant/tenant/recovery', '租户回收站恢复', '172.17.0.1', '2025-06-24 20:24:25', '2025-06-24 20:24:25', NULL, '{\"ids\":[2]}', 200, 1, '{\"request_id\":\"86882220-c216-492d-937a-e1d32b7e2a57\",\"path\":\"\\/admin\\/tenant\\/tenant\\/recovery\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\"}', 1, '86882220-c216-492d-937a-e1d32b7e2a57', 256);
INSERT INTO `user_operation_log` VALUES (114, 'admin', 'DELETE', '/admin/tenant/tenant', '删除租户', '172.17.0.1', '2025-06-24 20:28:19', '2025-06-24 20:28:19', NULL, '[2]', 200, 1, '{\"request_id\":\"9d509c7c-4f6c-42a0-8764-26b2ba38ddb2\",\"path\":\"\\/admin\\/tenant\\/tenant\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\"}', 1, '9d509c7c-4f6c-42a0-8764-26b2ba38ddb2', 251);
INSERT INTO `user_operation_log` VALUES (115, 'admin', 'DELETE', '/admin/tenant/tenant', '删除租户', '172.17.0.1', '2025-06-24 20:29:10', '2025-06-24 20:29:10', NULL, '[3]', 200, 1, '{\"request_id\":\"7bfcd524-6742-43a3-b78a-edcce228e926\",\"path\":\"\\/admin\\/tenant\\/tenant\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\"}', 1, '7bfcd524-6742-43a3-b78a-edcce228e926', 384);
INSERT INTO `user_operation_log` VALUES (116, 'admin', 'DELETE', '/admin/tenant/tenant/realDelete', '清空回收站', '172.17.0.1', '2025-06-24 20:29:16', '2025-06-24 20:29:16', NULL, '[]', 500, 2, '{\"request_id\":\"e12e61a1-f8dc-436f-83de-c9e29dbe6791\",\"path\":\"\\/admin\\/tenant\\/tenant\\/realDelete\",\"success\":false,\"code\":100503,\"message\":\"\\u5931\\u8d25\"}', 1, 'e12e61a1-f8dc-436f-83de-c9e29dbe6791', 0);
INSERT INTO `user_operation_log` VALUES (117, 'admin', 'DELETE', '/admin/tenant/tenant/realDelete', '清空回收站', '172.17.0.1', '2025-06-24 20:31:05', '2025-06-24 20:31:05', NULL, '[3]', 200, 1, '{\"request_id\":\"8473918d-8f7f-42fd-93c0-c0dd535bba21\",\"path\":\"\\/admin\\/tenant\\/tenant\\/realDelete\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\"}', 1, '8473918d-8f7f-42fd-93c0-c0dd535bba21', 139);
INSERT INTO `user_operation_log` VALUES (118, 'admin', 'PUT', '/admin/tenant/tenant/recovery', '租户回收站恢复', '172.17.0.1', '2025-06-24 20:31:34', '2025-06-24 20:31:34', NULL, '{\"ids\":[2]}', 200, 1, '{\"request_id\":\"8ac3862e-e5a5-4a0c-b1db-9cee63858693\",\"path\":\"\\/admin\\/tenant\\/tenant\\/recovery\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\"}', 1, '8ac3862e-e5a5-4a0c-b1db-9cee63858693', 139);
INSERT INTO `user_operation_log` VALUES (119, 'admin', 'PUT', '/admin/role/5/permissions', '赋予角色权限', '172.17.0.1', '2025-06-25 05:21:21', '2025-06-25 05:21:21', NULL, '{\"permissions\":[\"permission\",\"log\",\"log:userLogin:list\",\"dataCenter\",\"system:ConfigGroup\"]}', 500, 2, '{\"request_id\":\"538040da-2220-4cd7-b88f-8b418f32c2af\",\"path\":\"\\/admin\\/role\\/5\\/permissions\",\"success\":false,\"code\":100500,\"message\":\"Presence verifier has not been set.\"}', 1, '538040da-2220-4cd7-b88f-8b418f32c2af', 315);
INSERT INTO `user_operation_log` VALUES (120, 'admin', 'PUT', '/admin/role/5/permissions', '赋予角色权限', '172.17.0.1', '2025-06-25 05:24:03', '2025-06-25 05:24:03', NULL, '{\"permissions\":[\"permission\",\"log\",\"log:userLogin:list\",\"dataCenter\",\"system:ConfigGroup\"]}', 500, 2, '{\"request_id\":\"ddf979ee-da8d-4ae3-b01a-ee08e868cb15\",\"path\":\"\\/admin\\/role\\/5\\/permissions\",\"success\":false,\"code\":100422,\"message\":\"permissions.2 \\u683c\\u5f0f\\u4e0d\\u6b63\\u786e\\u3002\"}', 1, 'ddf979ee-da8d-4ae3-b01a-ee08e868cb15', 772);
INSERT INTO `user_operation_log` VALUES (121, 'admin', 'PUT', '/admin/role/5/permissions', '赋予角色权限', '172.17.0.1', '2025-06-25 05:24:54', '2025-06-25 05:24:54', NULL, '{\"permissions\":[\"permission\",\"log\",\"log:userLogin:list\",\"dataCenter\",\"system:ConfigGroup\"]}', 200, 1, '{\"request_id\":\"51f1e116-130d-4aba-b524-f67a6c3a73d8\",\"path\":\"\\/admin\\/role\\/5\\/permissions\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\"}', 1, '51f1e116-130d-4aba-b524-f67a6c3a73d8', 2549);
INSERT INTO `user_operation_log` VALUES (122, 'admin', 'PUT', '/admin/role/5/permissions', '赋予角色权限', '172.17.0.1', '2025-06-25 05:26:28', '2025-06-25 05:26:28', NULL, '{\"permissions\":[\"permission\",\"permission:user\",\"permission:user:index\",\"permission:user:save\",\"permission:user:update\",\"permission:user:delete\",\"permission:user:password\",\"permission:user:getRole\",\"permission:user:setRole\",\"permission:menu\",\"permission:menu:index\",\"permission:menu:create\",\"permission:menu:save\",\"permission:menu:delete\",\"permission:role\",\"permission:role:index\",\"permission:role:save\",\"permission:role:update\",\"permission:role:delete\",\"permission:role:getMenu\",\"permission:role:setMenu\",\"permission:department\",\"permission:department:index\",\"permission:department:save\",\"permission:department:update\",\"permission:department:delete\",\"permission:position:index\",\"permission:position:save\",\"permission:position:update\",\"permission:position:delete\",\"permission:position:data_permission\",\"permission:leader:index\",\"permission:leader:save\",\"permission:leader:delete\",\"log\",\"log:userLogin\",\"log:userLogin:list\",\"log:userLogin:delete\",\"log:userOperation\",\"log:userOperation:list\",\"log:userOperation:delete\",\"dataCenter\",\"dataCenter:attachment\",\"dataCenter:attachment:list\",\"dataCenter:attachment:upload\",\"dataCenter:attachment:delete\",\"recycleBin\",\"recycleBin:list\",\"recycleBin:update\"]}', 200, 1, '{\"request_id\":\"696101f7-b312-46a4-a293-5f8a485cf85a\",\"path\":\"\\/admin\\/role\\/5\\/permissions\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\"}', 1, '696101f7-b312-46a4-a293-5f8a485cf85a', 12976);
INSERT INTO `user_operation_log` VALUES (123, 'admin', 'PUT', '/admin/role/5/permissions', '赋予角色权限', '172.17.0.1', '2025-06-25 05:27:07', '2025-06-25 05:27:07', NULL, '{\"permissions\":[\"permission\",\"permission:user\",\"permission:user:index\",\"permission:user:save\",\"permission:user:update\",\"permission:user:delete\",\"permission:user:password\",\"permission:user:getRole\",\"permission:user:setRole\",\"permission:menu\",\"permission:menu:index\",\"permission:menu:create\",\"permission:menu:save\",\"permission:menu:delete\",\"permission:role\",\"permission:role:index\",\"permission:role:save\",\"permission:role:update\",\"permission:role:delete\",\"permission:role:getMenu\",\"permission:role:setMenu\",\"permission:department\",\"permission:department:index\",\"permission:department:save\",\"permission:department:update\",\"permission:department:delete\",\"permission:position:index\",\"permission:position:save\",\"permission:position:update\",\"permission:position:delete\",\"permission:position:data_permission\",\"permission:leader:index\",\"permission:leader:save\",\"permission:leader:delete\",\"log\",\"log:userLogin\",\"log:userLogin:list\",\"log:userLogin:delete\",\"log:userOperation\",\"log:userOperation:list\",\"log:userOperation:delete\",\"dataCenter\",\"dataCenter:attachment\",\"dataCenter:attachment:list\",\"dataCenter:attachment:upload\",\"dataCenter:attachment:delete\",\"recycleBin\",\"recycleBin:list\",\"recycleBin:update\"]}', 200, 1, '{\"request_id\":\"9eef78ad-bbdd-47c6-8d15-ef6231d59565\",\"path\":\"\\/admin\\/role\\/5\\/permissions\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\"}', 1, '9eef78ad-bbdd-47c6-8d15-ef6231d59565', 711);
INSERT INTO `user_operation_log` VALUES (124, 'admin', 'PUT', '/admin/role/6/permissions', '赋予角色权限', '172.17.0.1', '2025-06-25 05:27:46', '2025-06-25 05:27:46', NULL, '{\"permissions\":[\"permission\",\"permission:user\",\"permission:user:index\",\"permission:user:save\",\"permission:user:update\",\"permission:user:delete\",\"permission:user:password\",\"permission:user:getRole\",\"permission:user:setRole\",\"permission:menu\",\"permission:menu:index\",\"permission:menu:create\",\"permission:menu:save\",\"permission:menu:delete\",\"permission:role\",\"permission:role:index\",\"permission:role:save\",\"permission:role:update\",\"permission:role:delete\",\"permission:role:getMenu\",\"permission:role:setMenu\",\"permission:department\",\"permission:department:index\",\"permission:department:save\",\"permission:department:update\",\"permission:department:delete\",\"permission:position:index\",\"permission:position:save\",\"permission:position:update\",\"permission:position:delete\",\"permission:position:data_permission\",\"permission:leader:index\",\"permission:leader:save\",\"permission:leader:delete\",\"tenant\",\"tenant:tenant\",\"tenant:tenant:list\",\"tenant:tenant:create\",\"tenant:tenant:update\",\"tenant:tenant:delete\",\"tenant:tenant:recovery\",\"tenant:tenant:realDelete\",\"tenantApp\",\"tenantapp:tenantApp:list\",\"tenantapp:tenantApp:create\",\"tenantapp:tenantApp:update\",\"tenantapp:tenantApp:delete\",\"TenantUser\",\"tenant:tenantUser:list\",\"tenant:tenantUser:create\",\"tenant:tenant_user:update\",\"tenant:tenant_user:delete\"]}', 200, 1, '{\"request_id\":\"dc6d170a-1116-4d8e-a03f-1e3671f2e496\",\"path\":\"\\/admin\\/role\\/6\\/permissions\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\"}', 1, 'dc6d170a-1116-4d8e-a03f-1e3671f2e496', 5941);
INSERT INTO `user_operation_log` VALUES (125, 'admin', 'PUT', '/admin/role/6/permissions', '赋予角色权限', '172.17.0.1', '2025-06-25 05:29:12', '2025-06-25 05:29:12', NULL, '{\"permissions\":[\"permission\",\"permission:user\",\"permission:user:index\",\"permission:user:save\",\"permission:user:update\",\"permission:user:delete\",\"permission:user:password\",\"permission:user:getRole\",\"permission:user:setRole\",\"permission:menu\",\"permission:menu:index\",\"permission:menu:create\",\"permission:menu:save\",\"permission:menu:delete\",\"permission:role\",\"permission:role:index\",\"permission:role:save\",\"permission:role:update\",\"permission:role:delete\",\"permission:role:getMenu\",\"permission:role:setMenu\",\"permission:department\",\"permission:department:index\",\"permission:department:save\",\"permission:department:update\",\"permission:department:delete\",\"permission:position:index\",\"permission:position:save\",\"permission:position:update\",\"permission:position:delete\",\"permission:position:data_permission\",\"permission:leader:index\",\"permission:leader:save\",\"permission:leader:delete\",\"dataCenter\",\"dataCenter:attachment\",\"dataCenter:attachment:list\",\"dataCenter:attachment:upload\",\"dataCenter:attachment:delete\",\"recycleBin\",\"recycleBin:list\",\"recycleBin:update\",\"tenant\",\"tenant:tenant\",\"tenant:tenant:list\",\"tenant:tenant:create\",\"tenant:tenant:update\",\"tenant:tenant:delete\",\"tenant:tenant:recovery\",\"tenant:tenant:realDelete\",\"tenantApp\",\"tenantapp:tenantApp:list\",\"tenantapp:tenantApp:create\",\"tenantapp:tenantApp:update\",\"tenantapp:tenantApp:delete\",\"TenantUser\",\"tenant:tenantUser:list\",\"tenant:tenantUser:create\",\"tenant:tenant_user:update\",\"tenant:tenant_user:delete\"]}', 200, 1, '{\"request_id\":\"a772a180-5ae9-4231-b525-aff17a228276\",\"path\":\"\\/admin\\/role\\/6\\/permissions\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\"}', 1, 'a772a180-5ae9-4231-b525-aff17a228276', 1268);
INSERT INTO `user_operation_log` VALUES (126, 'admin', 'PUT', '/admin/role/6/permissions', '赋予角色权限', '172.17.0.1', '2025-06-25 05:29:29', '2025-06-25 05:29:29', NULL, '{\"permissions\":[\"dataCenter\",\"dataCenter:attachment\",\"dataCenter:attachment:list\",\"dataCenter:attachment:upload\",\"dataCenter:attachment:delete\",\"recycleBin\",\"recycleBin:list\",\"recycleBin:update\"]}', 200, 1, '{\"request_id\":\"013300e7-47e2-4097-a351-b24fe98eb509\",\"path\":\"\\/admin\\/role\\/6\\/permissions\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\"}', 1, '013300e7-47e2-4097-a351-b24fe98eb509', 414);
INSERT INTO `user_operation_log` VALUES (127, 'admin', 'PUT', '/admin/role/6/permissions', '赋予角色权限', '172.17.0.1', '2025-06-25 05:29:59', '2025-06-25 05:29:59', NULL, '{\"permissions\":[\"permission\",\"permission:user\",\"permission:user:index\",\"permission:user:save\",\"permission:user:update\",\"permission:user:delete\",\"permission:user:password\",\"permission:user:getRole\",\"permission:user:setRole\",\"permission:menu\",\"permission:menu:index\",\"permission:menu:create\",\"permission:menu:save\",\"permission:menu:delete\",\"permission:role\",\"permission:role:index\",\"permission:role:save\",\"permission:role:update\",\"permission:role:delete\",\"permission:role:getMenu\",\"permission:role:setMenu\",\"permission:department\",\"permission:department:index\",\"permission:department:save\",\"permission:department:update\",\"permission:department:delete\",\"permission:position:index\",\"permission:position:save\",\"permission:position:update\",\"permission:position:delete\",\"permission:position:data_permission\",\"permission:leader:index\",\"permission:leader:save\",\"permission:leader:delete\",\"dataCenter\",\"dataCenter:attachment\",\"dataCenter:attachment:list\",\"dataCenter:attachment:upload\",\"dataCenter:attachment:delete\",\"recycleBin\",\"recycleBin:list\",\"recycleBin:update\",\"tenant\",\"tenant:tenant\",\"tenant:tenant:list\",\"tenant:tenant:create\",\"tenant:tenant:update\",\"tenant:tenant:delete\",\"tenant:tenant:recovery\",\"tenant:tenant:realDelete\",\"tenantApp\",\"tenantapp:tenantApp:list\",\"tenantapp:tenantApp:create\",\"tenantapp:tenantApp:update\",\"tenantapp:tenantApp:delete\",\"TenantUser\",\"tenant:tenantUser:list\",\"tenant:tenantUser:create\",\"tenant:tenant_user:update\",\"tenant:tenant_user:delete\"]}', 200, 1, '{\"request_id\":\"8b710d81-87ed-4fac-a4cb-cfdcfb47e9d7\",\"path\":\"\\/admin\\/role\\/6\\/permissions\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\"}', 1, '8b710d81-87ed-4fac-a4cb-cfdcfb47e9d7', 5673);
INSERT INTO `user_operation_log` VALUES (128, 'admin', 'PUT', '/admin/role/6/permissions', '赋予角色权限', '172.17.0.1', '2025-06-25 05:31:44', '2025-06-25 05:31:44', NULL, '{\"permissions\":[\"dataCenter\",\"dataCenter:attachment\",\"dataCenter:attachment:list\",\"dataCenter:attachment:upload\",\"dataCenter:attachment:delete\",\"recycleBin\",\"recycleBin:list\",\"recycleBin:update\"]}', 200, 1, '{\"request_id\":\"f7a11ac3-9668-4f0a-91f5-2eb51954c452\",\"path\":\"\\/admin\\/role\\/6\\/permissions\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\"}', 1, 'f7a11ac3-9668-4f0a-91f5-2eb51954c452', 568);
INSERT INTO `user_operation_log` VALUES (129, 'admin', 'PUT', '/admin/role/6/permissions', '赋予角色权限', '172.17.0.1', '2025-06-25 05:32:03', '2025-06-25 05:32:03', NULL, '{\"permissions\":[\"permission\",\"permission:user\",\"permission:user:index\",\"permission:user:save\",\"permission:user:update\",\"permission:user:delete\",\"permission:user:password\",\"permission:user:getRole\",\"permission:user:setRole\",\"permission:menu\",\"permission:menu:index\",\"permission:menu:create\",\"permission:menu:save\",\"permission:menu:delete\",\"permission:role\",\"permission:role:index\",\"permission:role:save\",\"permission:role:update\",\"permission:role:delete\",\"permission:role:getMenu\",\"permission:role:setMenu\",\"permission:department\",\"permission:department:index\",\"permission:department:save\",\"permission:department:update\",\"permission:department:delete\",\"permission:position:index\",\"permission:position:save\",\"permission:position:update\",\"permission:position:delete\",\"permission:position:data_permission\",\"permission:leader:index\",\"permission:leader:save\",\"permission:leader:delete\",\"dataCenter\",\"dataCenter:attachment\",\"dataCenter:attachment:list\",\"dataCenter:attachment:upload\",\"dataCenter:attachment:delete\",\"recycleBin\",\"recycleBin:list\",\"recycleBin:update\",\"tenant\",\"tenant:tenant\",\"tenant:tenant:list\",\"tenant:tenant:create\",\"tenant:tenant:update\",\"tenant:tenant:delete\",\"tenant:tenant:recovery\",\"tenant:tenant:realDelete\",\"tenantApp\",\"tenantapp:tenantApp:list\",\"tenantapp:tenantApp:create\",\"tenantapp:tenantApp:update\",\"tenantapp:tenantApp:delete\",\"TenantUser\",\"tenant:tenantUser:list\",\"tenant:tenantUser:create\",\"tenant:tenant_user:update\",\"tenant:tenant_user:delete\"]}', 200, 1, '{\"request_id\":\"11072f80-aae6-4752-a414-2d38625783e1\",\"path\":\"\\/admin\\/role\\/6\\/permissions\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\"}', 1, '11072f80-aae6-4752-a414-2d38625783e1', 5739);
INSERT INTO `user_operation_log` VALUES (130, 'admin', 'PUT', '/admin/tenant/tenant/1', '编辑租户', '172.17.0.1', '2025-06-25 07:17:49', '2025-06-25 07:17:49', NULL, '{\"id\":1,\"tenant_id\":\"000000\",\"contact_user_name\":\"haha\",\"contact_phone\":\"12345\",\"company_name\":\"\",\"license_number\":\"\",\"address\":\"\",\"intro\":\"\",\"domain\":\"\",\"account_count\":1,\"is_enabled\":330,\"created_by\":1,\"created_at\":\"2025-06-23T01:22:28.000000Z\",\"expired_at\":null,\"updated_by\":0,\"updated_at\":\"2025-06-23T01:22:28.000000Z\",\"safe_level\":1,\"deleted_by\":0,\"deleted_at\":null,\"remark\":null}', 500, 2, '{\"request_id\":\"b2add6fc-d578-4412-8996-4cf7a90f560f\",\"path\":\"\\/admin\\/tenant\\/tenant\\/1\",\"success\":false,\"code\":100422,\"message\":\"company name \\u4e0d\\u80fd\\u4e3a\\u7a7a\\u3002\"}', 1, 'b2add6fc-d578-4412-8996-4cf7a90f560f', 163);
INSERT INTO `user_operation_log` VALUES (131, 'admin', 'PUT', '/admin/tenant/tenant/4', '编辑租户', '172.17.0.1', '2025-06-25 07:17:50', '2025-06-25 07:17:50', NULL, '{\"id\":4,\"tenant_id\":\"000003\",\"contact_user_name\":\"fffrwds\",\"contact_phone\":\"444\",\"company_name\":\"fcgdg2\",\"license_number\":\"\",\"address\":\"\",\"intro\":\"\",\"domain\":\"\",\"account_count\":1,\"is_enabled\":330,\"created_by\":1,\"created_at\":\"2025-06-23T01:47:35.000000Z\",\"expired_at\":null,\"updated_by\":1,\"updated_at\":\"2025-06-23T03:15:04.000000Z\",\"safe_level\":1,\"deleted_by\":0,\"deleted_at\":null,\"remark\":null}', 500, 2, '{\"request_id\":\"38d79c86-6617-4427-8cc8-38be6d027da3\",\"path\":\"\\/admin\\/tenant\\/tenant\\/4\",\"success\":false,\"code\":100422,\"message\":\"is enabled \\u5fc5\\u987b\\u4e3a\\u5e03\\u5c14\\u503c\\u3002\"}', 1, '38d79c86-6617-4427-8cc8-38be6d027da3', 73);
INSERT INTO `user_operation_log` VALUES (132, 'admin', 'PUT', '/admin/tenant/tenant/2', '编辑租户', '172.17.0.1', '2025-06-25 07:17:50', '2025-06-25 07:17:50', NULL, '{\"id\":2,\"tenant_id\":\"000001\",\"contact_user_name\":\"gaxx\",\"contact_phone\":\"11\",\"company_name\":\"\",\"license_number\":\"\",\"address\":\"\",\"intro\":\"\",\"domain\":\"\",\"account_count\":1,\"is_enabled\":330,\"created_by\":1,\"created_at\":\"2025-06-23T01:33:50.000000Z\",\"expired_at\":null,\"updated_by\":1,\"updated_at\":\"2025-06-24T12:31:34.000000Z\",\"safe_level\":1,\"deleted_by\":1,\"deleted_at\":null,\"remark\":null}', 500, 2, '{\"request_id\":\"e030ad24-3fba-4667-8b9f-d6deae872328\",\"path\":\"\\/admin\\/tenant\\/tenant\\/2\",\"success\":false,\"code\":100422,\"message\":\"company name \\u4e0d\\u80fd\\u4e3a\\u7a7a\\u3002\"}', 1, 'e030ad24-3fba-4667-8b9f-d6deae872328', 1);
INSERT INTO `user_operation_log` VALUES (133, 'admin', 'PUT', '/admin/tenant/tenant/1', '编辑租户', '172.17.0.1', '2025-06-25 07:18:16', '2025-06-25 07:18:16', NULL, '{\"id\":1,\"tenant_id\":\"000000\",\"contact_user_name\":\"haha\",\"contact_phone\":\"12345\",\"company_name\":\"\",\"license_number\":\"\",\"address\":\"\",\"intro\":\"\",\"domain\":\"\",\"account_count\":1,\"is_enabled\":330,\"created_by\":1,\"created_at\":\"2025-06-23T01:22:28.000000Z\",\"expired_at\":null,\"updated_by\":0,\"updated_at\":\"2025-06-23T01:22:28.000000Z\",\"safe_level\":1,\"deleted_by\":0,\"deleted_at\":null,\"remark\":null}', 500, 2, '{\"request_id\":\"03aa0838-f169-4df4-bde1-be37a01f60a4\",\"path\":\"\\/admin\\/tenant\\/tenant\\/1\",\"success\":false,\"code\":100422,\"message\":\"company name \\u4e0d\\u80fd\\u4e3a\\u7a7a\\u3002\"}', 1, '03aa0838-f169-4df4-bde1-be37a01f60a4', 1);
INSERT INTO `user_operation_log` VALUES (134, 'admin', 'PUT', '/admin/tenant/tenant/2', '编辑租户', '172.17.0.1', '2025-06-25 07:18:18', '2025-06-25 07:18:18', NULL, '{\"id\":2,\"tenant_id\":\"000001\",\"contact_user_name\":\"gaxx\",\"contact_phone\":\"11\",\"company_name\":\"\",\"license_number\":\"\",\"address\":\"\",\"intro\":\"\",\"domain\":\"\",\"account_count\":1,\"is_enabled\":330,\"created_by\":1,\"created_at\":\"2025-06-23T01:33:50.000000Z\",\"expired_at\":null,\"updated_by\":1,\"updated_at\":\"2025-06-24T12:31:34.000000Z\",\"safe_level\":1,\"deleted_by\":1,\"deleted_at\":null,\"remark\":null}', 500, 2, '{\"request_id\":\"e9d5303d-ff1d-4615-932e-720d232eaab8\",\"path\":\"\\/admin\\/tenant\\/tenant\\/2\",\"success\":false,\"code\":100422,\"message\":\"company name \\u4e0d\\u80fd\\u4e3a\\u7a7a\\u3002\"}', 1, 'e9d5303d-ff1d-4615-932e-720d232eaab8', 81);
INSERT INTO `user_operation_log` VALUES (135, 'admin', 'PUT', '/admin/tenant/tenant/4', '编辑租户', '172.17.0.1', '2025-06-25 07:18:18', '2025-06-25 07:18:18', NULL, '{\"id\":4,\"tenant_id\":\"000003\",\"contact_user_name\":\"fffrwds\",\"contact_phone\":\"444\",\"company_name\":\"fcgdg2\",\"license_number\":\"\",\"address\":\"\",\"intro\":\"\",\"domain\":\"\",\"account_count\":1,\"is_enabled\":330,\"created_by\":1,\"created_at\":\"2025-06-23T01:47:35.000000Z\",\"expired_at\":null,\"updated_by\":1,\"updated_at\":\"2025-06-23T03:15:04.000000Z\",\"safe_level\":1,\"deleted_by\":0,\"deleted_at\":null,\"remark\":null}', 500, 2, '{\"request_id\":\"829a5fb1-b704-466d-a100-ddafaca7a494\",\"path\":\"\\/admin\\/tenant\\/tenant\\/4\",\"success\":false,\"code\":100422,\"message\":\"is enabled \\u5fc5\\u987b\\u4e3a\\u5e03\\u5c14\\u503c\\u3002\"}', 1, '829a5fb1-b704-466d-a100-ddafaca7a494', 80);
INSERT INTO `user_operation_log` VALUES (136, 'admin', 'PUT', '/admin/tenant/tenant/4', '编辑租户', '172.17.0.1', '2025-06-25 07:20:04', '2025-06-25 07:20:04', NULL, '{\"id\":4,\"tenant_id\":\"000003\",\"contact_user_name\":\"fffrwds\",\"contact_phone\":\"444\",\"company_name\":\"fcgdg2\",\"license_number\":\"\",\"address\":\"\",\"intro\":\"\",\"domain\":\"\",\"account_count\":1,\"is_enabled\":330,\"created_by\":1,\"created_at\":\"2025-06-23T01:47:35.000000Z\",\"expired_at\":null,\"updated_by\":1,\"updated_at\":\"2025-06-23T03:15:04.000000Z\",\"safe_level\":1,\"deleted_by\":0,\"deleted_at\":null,\"remark\":null}', 500, 2, '{\"request_id\":\"540498df-564f-435e-bbdb-b114619a7a6f\",\"path\":\"\\/admin\\/tenant\\/tenant\\/4\",\"success\":false,\"code\":100422,\"message\":\"is enabled \\u5fc5\\u987b\\u4e3a\\u5e03\\u5c14\\u503c\\u3002\"}', 1, '540498df-564f-435e-bbdb-b114619a7a6f', 0);
INSERT INTO `user_operation_log` VALUES (137, 'admin', 'PUT', '/admin/tenant/tenant/2', '编辑租户', '172.17.0.1', '2025-06-25 07:20:05', '2025-06-25 07:20:05', NULL, '{\"id\":2,\"tenant_id\":\"000001\",\"contact_user_name\":\"gaxx\",\"contact_phone\":\"11\",\"company_name\":\"\",\"license_number\":\"\",\"address\":\"\",\"intro\":\"\",\"domain\":\"\",\"account_count\":1,\"is_enabled\":330,\"created_by\":1,\"created_at\":\"2025-06-23T01:33:50.000000Z\",\"expired_at\":null,\"updated_by\":1,\"updated_at\":\"2025-06-24T12:31:34.000000Z\",\"safe_level\":1,\"deleted_by\":1,\"deleted_at\":null,\"remark\":null}', 500, 2, '{\"request_id\":\"e83c0fa8-937b-4aaa-8622-46749ff71251\",\"path\":\"\\/admin\\/tenant\\/tenant\\/2\",\"success\":false,\"code\":100422,\"message\":\"company name \\u4e0d\\u80fd\\u4e3a\\u7a7a\\u3002\"}', 1, 'e83c0fa8-937b-4aaa-8622-46749ff71251', 1);
INSERT INTO `user_operation_log` VALUES (138, 'admin', 'PUT', '/admin/tenant/tenant/2', '编辑租户', '172.17.0.1', '2025-06-25 07:20:05', '2025-06-25 07:20:05', NULL, '{\"id\":2,\"tenant_id\":\"000001\",\"contact_user_name\":\"gaxx\",\"contact_phone\":\"11\",\"company_name\":\"\",\"license_number\":\"\",\"address\":\"\",\"intro\":\"\",\"domain\":\"\",\"account_count\":1,\"is_enabled\":330,\"created_by\":1,\"created_at\":\"2025-06-23T01:33:50.000000Z\",\"expired_at\":null,\"updated_by\":1,\"updated_at\":\"2025-06-24T12:31:34.000000Z\",\"safe_level\":1,\"deleted_by\":1,\"deleted_at\":null,\"remark\":null}', 500, 2, '{\"request_id\":\"99508013-9b8f-4958-ae14-9057bafa38c5\",\"path\":\"\\/admin\\/tenant\\/tenant\\/2\",\"success\":false,\"code\":100422,\"message\":\"company name \\u4e0d\\u80fd\\u4e3a\\u7a7a\\u3002\"}', 1, '99508013-9b8f-4958-ae14-9057bafa38c5', 1);
INSERT INTO `user_operation_log` VALUES (139, 'admin', 'PUT', '/admin/tenant/tenant/4', '编辑租户', '172.17.0.1', '2025-06-25 07:20:05', '2025-06-25 07:20:05', NULL, '{\"id\":4,\"tenant_id\":\"000003\",\"contact_user_name\":\"fffrwds\",\"contact_phone\":\"444\",\"company_name\":\"fcgdg2\",\"license_number\":\"\",\"address\":\"\",\"intro\":\"\",\"domain\":\"\",\"account_count\":1,\"is_enabled\":330,\"created_by\":1,\"created_at\":\"2025-06-23T01:47:35.000000Z\",\"expired_at\":null,\"updated_by\":1,\"updated_at\":\"2025-06-23T03:15:04.000000Z\",\"safe_level\":1,\"deleted_by\":0,\"deleted_at\":null,\"remark\":null}', 500, 2, '{\"request_id\":\"5bcf7a4a-af91-4ffb-8f37-71e6fde5e249\",\"path\":\"\\/admin\\/tenant\\/tenant\\/4\",\"success\":false,\"code\":100422,\"message\":\"is enabled \\u5fc5\\u987b\\u4e3a\\u5e03\\u5c14\\u503c\\u3002\"}', 1, '5bcf7a4a-af91-4ffb-8f37-71e6fde5e249', 1);
INSERT INTO `user_operation_log` VALUES (140, 'admin', 'PUT', '/admin/tenant/tenant/1', '编辑租户', '172.17.0.1', '2025-06-25 07:20:05', '2025-06-25 07:20:05', NULL, '{\"id\":1,\"tenant_id\":\"000000\",\"contact_user_name\":\"haha\",\"contact_phone\":\"12345\",\"company_name\":\"\",\"license_number\":\"\",\"address\":\"\",\"intro\":\"\",\"domain\":\"\",\"account_count\":1,\"is_enabled\":330,\"created_by\":1,\"created_at\":\"2025-06-23T01:22:28.000000Z\",\"expired_at\":null,\"updated_by\":0,\"updated_at\":\"2025-06-23T01:22:28.000000Z\",\"safe_level\":1,\"deleted_by\":0,\"deleted_at\":null,\"remark\":null}', 500, 2, '{\"request_id\":\"af1c496f-e646-4822-924b-2a7f04bfcab0\",\"path\":\"\\/admin\\/tenant\\/tenant\\/1\",\"success\":false,\"code\":100422,\"message\":\"company name \\u4e0d\\u80fd\\u4e3a\\u7a7a\\u3002\"}', 1, 'af1c496f-e646-4822-924b-2a7f04bfcab0', 0);
INSERT INTO `user_operation_log` VALUES (141, 'admin', 'PUT', '/admin/tenant/tenant/1', '编辑租户', '172.17.0.1', '2025-06-25 07:20:05', '2025-06-25 07:20:05', NULL, '{\"id\":1,\"tenant_id\":\"000000\",\"contact_user_name\":\"haha\",\"contact_phone\":\"12345\",\"company_name\":\"\",\"license_number\":\"\",\"address\":\"\",\"intro\":\"\",\"domain\":\"\",\"account_count\":1,\"is_enabled\":330,\"created_by\":1,\"created_at\":\"2025-06-23T01:22:28.000000Z\",\"expired_at\":null,\"updated_by\":0,\"updated_at\":\"2025-06-23T01:22:28.000000Z\",\"safe_level\":1,\"deleted_by\":0,\"deleted_at\":null,\"remark\":null}', 500, 2, '{\"request_id\":\"54cccc8a-d010-4c8e-bcd1-5aba183accae\",\"path\":\"\\/admin\\/tenant\\/tenant\\/1\",\"success\":false,\"code\":100422,\"message\":\"company name \\u4e0d\\u80fd\\u4e3a\\u7a7a\\u3002\"}', 1, '54cccc8a-d010-4c8e-bcd1-5aba183accae', 1);
INSERT INTO `user_operation_log` VALUES (142, 'admin', 'PUT', '/admin/tenant/tenant/1', '编辑租户', '172.17.0.1', '2025-06-25 07:20:10', '2025-06-25 07:20:10', NULL, '{\"id\":1,\"tenant_id\":\"000000\",\"contact_user_name\":\"haha\",\"contact_phone\":\"12345\",\"company_name\":\"\",\"license_number\":\"\",\"address\":\"\",\"intro\":\"\",\"domain\":\"\",\"account_count\":1,\"is_enabled\":110,\"created_by\":1,\"created_at\":\"2025-06-23T01:22:28.000000Z\",\"expired_at\":null,\"updated_by\":0,\"updated_at\":\"2025-06-23T01:22:28.000000Z\",\"safe_level\":1,\"deleted_by\":0,\"deleted_at\":null,\"remark\":null}', 500, 2, '{\"request_id\":\"cdf90ef8-7cd7-4e67-abb4-b0b58b9d4f04\",\"path\":\"\\/admin\\/tenant\\/tenant\\/1\",\"success\":false,\"code\":100422,\"message\":\"company name \\u4e0d\\u80fd\\u4e3a\\u7a7a\\u3002\"}', 1, 'cdf90ef8-7cd7-4e67-abb4-b0b58b9d4f04', 0);
INSERT INTO `user_operation_log` VALUES (143, 'admin', 'PUT', '/admin/tenant/tenant/1', '编辑租户', '172.17.0.1', '2025-06-25 07:20:12', '2025-06-25 07:20:12', NULL, '{\"id\":1,\"tenant_id\":\"000000\",\"contact_user_name\":\"haha\",\"contact_phone\":\"12345\",\"company_name\":\"\",\"license_number\":\"\",\"address\":\"\",\"intro\":\"\",\"domain\":\"\",\"account_count\":1,\"is_enabled\":110,\"created_by\":1,\"created_at\":\"2025-06-23T01:22:28.000000Z\",\"expired_at\":null,\"updated_by\":0,\"updated_at\":\"2025-06-23T01:22:28.000000Z\",\"safe_level\":1,\"deleted_by\":0,\"deleted_at\":null,\"remark\":null}', 500, 2, '{\"request_id\":\"757884da-b9fa-4e8b-a926-949bfe550e37\",\"path\":\"\\/admin\\/tenant\\/tenant\\/1\",\"success\":false,\"code\":100422,\"message\":\"company name \\u4e0d\\u80fd\\u4e3a\\u7a7a\\u3002\"}', 1, '757884da-b9fa-4e8b-a926-949bfe550e37', 0);
INSERT INTO `user_operation_log` VALUES (144, 'admin', 'PUT', '/admin/tenant/tenant/2', '编辑租户', '172.17.0.1', '2025-06-25 07:20:13', '2025-06-25 07:20:13', NULL, '{\"id\":2,\"tenant_id\":\"000001\",\"contact_user_name\":\"gaxx\",\"contact_phone\":\"11\",\"company_name\":\"\",\"license_number\":\"\",\"address\":\"\",\"intro\":\"\",\"domain\":\"\",\"account_count\":1,\"is_enabled\":110,\"created_by\":1,\"created_at\":\"2025-06-23T01:33:50.000000Z\",\"expired_at\":null,\"updated_by\":1,\"updated_at\":\"2025-06-24T12:31:34.000000Z\",\"safe_level\":1,\"deleted_by\":1,\"deleted_at\":null,\"remark\":null}', 500, 2, '{\"request_id\":\"870994e2-ede1-4a87-b104-5ac50aa801fd\",\"path\":\"\\/admin\\/tenant\\/tenant\\/2\",\"success\":false,\"code\":100422,\"message\":\"company name \\u4e0d\\u80fd\\u4e3a\\u7a7a\\u3002\"}', 1, '870994e2-ede1-4a87-b104-5ac50aa801fd', 1);
INSERT INTO `user_operation_log` VALUES (145, 'admin', 'PUT', '/admin/tenant/tenant/2', '编辑租户', '172.17.0.1', '2025-06-25 07:22:15', '2025-06-25 07:22:15', NULL, '{\"id\":2,\"tenant_id\":\"000001\",\"contact_user_name\":\"gaxx\",\"contact_phone\":\"11\",\"company_name\":\"\",\"license_number\":\"\",\"address\":\"\",\"intro\":\"\",\"domain\":\"\",\"account_count\":1,\"is_enabled\":2,\"created_by\":1,\"created_at\":\"2025-06-23T01:33:50.000000Z\",\"expired_at\":null,\"updated_by\":1,\"updated_at\":\"2025-06-24T12:31:34.000000Z\",\"safe_level\":1,\"deleted_by\":1,\"deleted_at\":null,\"remark\":null}', 500, 2, '{\"request_id\":\"a5536624-c75b-4883-aea9-20f18c9b8cd2\",\"path\":\"\\/admin\\/tenant\\/tenant\\/2\",\"success\":false,\"code\":100422,\"message\":\"company name \\u4e0d\\u80fd\\u4e3a\\u7a7a\\u3002\"}', 1, 'a5536624-c75b-4883-aea9-20f18c9b8cd2', 1);
INSERT INTO `user_operation_log` VALUES (146, 'admin', 'PUT', '/admin/tenant/tenant/1', '编辑租户', '172.17.0.1', '2025-06-25 07:22:15', '2025-06-25 07:22:15', NULL, '{\"id\":1,\"tenant_id\":\"000000\",\"contact_user_name\":\"haha\",\"contact_phone\":\"12345\",\"company_name\":\"\",\"license_number\":\"\",\"address\":\"\",\"intro\":\"\",\"domain\":\"\",\"account_count\":1,\"is_enabled\":2,\"created_by\":1,\"created_at\":\"2025-06-23T01:22:28.000000Z\",\"expired_at\":null,\"updated_by\":0,\"updated_at\":\"2025-06-23T01:22:28.000000Z\",\"safe_level\":1,\"deleted_by\":0,\"deleted_at\":null,\"remark\":null}', 500, 2, '{\"request_id\":\"708cb2b7-18ca-4a3e-b8f3-ff412bf3d4c4\",\"path\":\"\\/admin\\/tenant\\/tenant\\/1\",\"success\":false,\"code\":100422,\"message\":\"company name \\u4e0d\\u80fd\\u4e3a\\u7a7a\\u3002\"}', 1, '708cb2b7-18ca-4a3e-b8f3-ff412bf3d4c4', 1);
INSERT INTO `user_operation_log` VALUES (147, 'admin', 'PUT', '/admin/tenant/tenant/4', '编辑租户', '172.17.0.1', '2025-06-25 07:22:15', '2025-06-25 07:22:15', NULL, '{\"id\":4,\"tenant_id\":\"000003\",\"contact_user_name\":\"fffrwds\",\"contact_phone\":\"444\",\"company_name\":\"fcgdg2\",\"license_number\":\"\",\"address\":\"\",\"intro\":\"\",\"domain\":\"\",\"account_count\":1,\"is_enabled\":2,\"created_by\":1,\"created_at\":\"2025-06-23T01:47:35.000000Z\",\"expired_at\":null,\"updated_by\":1,\"updated_at\":\"2025-06-23T03:15:04.000000Z\",\"safe_level\":1,\"deleted_by\":0,\"deleted_at\":null,\"remark\":null}', 500, 2, '{\"request_id\":\"0816e551-e4c4-4f77-8092-469bb911768e\",\"path\":\"\\/admin\\/tenant\\/tenant\\/4\",\"success\":false,\"code\":100422,\"message\":\"is enabled \\u5fc5\\u987b\\u4e3a\\u5e03\\u5c14\\u503c\\u3002\"}', 1, '0816e551-e4c4-4f77-8092-469bb911768e', 1);
INSERT INTO `user_operation_log` VALUES (148, 'admin', 'PUT', '/admin/tenant/tenant/4', '编辑租户', '172.17.0.1', '2025-06-25 07:22:16', '2025-06-25 07:22:16', NULL, '{\"id\":4,\"tenant_id\":\"000003\",\"contact_user_name\":\"fffrwds\",\"contact_phone\":\"444\",\"company_name\":\"fcgdg2\",\"license_number\":\"\",\"address\":\"\",\"intro\":\"\",\"domain\":\"\",\"account_count\":1,\"is_enabled\":2,\"created_by\":1,\"created_at\":\"2025-06-23T01:47:35.000000Z\",\"expired_at\":null,\"updated_by\":1,\"updated_at\":\"2025-06-23T03:15:04.000000Z\",\"safe_level\":1,\"deleted_by\":0,\"deleted_at\":null,\"remark\":null}', 500, 2, '{\"request_id\":\"c04852f2-2bf3-4017-a72e-d6fcedb7f48a\",\"path\":\"\\/admin\\/tenant\\/tenant\\/4\",\"success\":false,\"code\":100422,\"message\":\"is enabled \\u5fc5\\u987b\\u4e3a\\u5e03\\u5c14\\u503c\\u3002\"}', 1, 'c04852f2-2bf3-4017-a72e-d6fcedb7f48a', 0);
INSERT INTO `user_operation_log` VALUES (149, 'admin', 'PUT', '/admin/tenant/tenant/1', '编辑租户', '172.17.0.1', '2025-06-25 07:22:16', '2025-06-25 07:22:16', NULL, '{\"id\":1,\"tenant_id\":\"000000\",\"contact_user_name\":\"haha\",\"contact_phone\":\"12345\",\"company_name\":\"\",\"license_number\":\"\",\"address\":\"\",\"intro\":\"\",\"domain\":\"\",\"account_count\":1,\"is_enabled\":2,\"created_by\":1,\"created_at\":\"2025-06-23T01:22:28.000000Z\",\"expired_at\":null,\"updated_by\":0,\"updated_at\":\"2025-06-23T01:22:28.000000Z\",\"safe_level\":1,\"deleted_by\":0,\"deleted_at\":null,\"remark\":null}', 500, 2, '{\"request_id\":\"2fa82f50-a201-4ed3-b2a8-ae98aec07eb9\",\"path\":\"\\/admin\\/tenant\\/tenant\\/1\",\"success\":false,\"code\":100422,\"message\":\"company name \\u4e0d\\u80fd\\u4e3a\\u7a7a\\u3002\"}', 1, '2fa82f50-a201-4ed3-b2a8-ae98aec07eb9', 1);
INSERT INTO `user_operation_log` VALUES (150, 'admin', 'PUT', '/admin/tenant/tenant/2', '编辑租户', '172.17.0.1', '2025-06-25 07:22:16', '2025-06-25 07:22:16', NULL, '{\"id\":2,\"tenant_id\":\"000001\",\"contact_user_name\":\"gaxx\",\"contact_phone\":\"11\",\"company_name\":\"\",\"license_number\":\"\",\"address\":\"\",\"intro\":\"\",\"domain\":\"\",\"account_count\":1,\"is_enabled\":2,\"created_by\":1,\"created_at\":\"2025-06-23T01:33:50.000000Z\",\"expired_at\":null,\"updated_by\":1,\"updated_at\":\"2025-06-24T12:31:34.000000Z\",\"safe_level\":1,\"deleted_by\":1,\"deleted_at\":null,\"remark\":null}', 500, 2, '{\"request_id\":\"afe1aced-db77-4a31-aff7-4e82067ec667\",\"path\":\"\\/admin\\/tenant\\/tenant\\/2\",\"success\":false,\"code\":100422,\"message\":\"company name \\u4e0d\\u80fd\\u4e3a\\u7a7a\\u3002\"}', 1, 'afe1aced-db77-4a31-aff7-4e82067ec667', 0);
INSERT INTO `user_operation_log` VALUES (151, 'admin', 'PUT', '/admin/tenant/tenant/1', '编辑租户', '172.17.0.1', '2025-06-25 07:24:01', '2025-06-25 07:24:01', NULL, '{\"id\":1,\"tenant_id\":\"000000\",\"contact_user_name\":\"haha\",\"contact_phone\":\"12345\",\"company_name\":\"\",\"license_number\":\"\",\"address\":\"\",\"intro\":\"\",\"domain\":\"\",\"account_count\":1,\"is_enabled\":true,\"created_by\":1,\"created_at\":\"2025-06-23T01:22:28.000000Z\",\"expired_at\":null,\"updated_by\":0,\"updated_at\":\"2025-06-23T01:22:28.000000Z\",\"safe_level\":1,\"deleted_by\":0,\"deleted_at\":null,\"remark\":null}', 500, 2, '{\"request_id\":\"1a3597ce-4b12-4ace-adfa-a47b2826e23a\",\"path\":\"\\/admin\\/tenant\\/tenant\\/1\",\"success\":false,\"code\":100422,\"message\":\"company name \\u4e0d\\u80fd\\u4e3a\\u7a7a\\u3002\"}', 1, '1a3597ce-4b12-4ace-adfa-a47b2826e23a', 0);
INSERT INTO `user_operation_log` VALUES (152, 'admin', 'PUT', '/admin/tenant/tenant/4', '编辑租户', '172.17.0.1', '2025-06-25 07:24:37', '2025-06-25 07:24:37', NULL, '{\"id\":4,\"tenant_id\":\"000003\",\"contact_user_name\":\"fffrwds\",\"contact_phone\":\"444\",\"company_name\":\"fcgdg2\",\"license_number\":\"\",\"address\":\"\",\"intro\":\"\",\"domain\":\"\",\"account_count\":1,\"is_enabled\":true,\"created_by\":1,\"created_at\":\"2025-06-23T01:47:35.000000Z\",\"expired_at\":null,\"updated_by\":1,\"updated_at\":\"2025-06-23T03:15:04.000000Z\",\"safe_level\":1,\"deleted_by\":0,\"deleted_at\":null,\"remark\":null}', 200, 1, '{\"request_id\":\"e521b7aa-f807-4acf-a8c6-3e18be8512f5\",\"path\":\"\\/admin\\/tenant\\/tenant\\/4\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\"}', 1, 'e521b7aa-f807-4acf-a8c6-3e18be8512f5', 212);
INSERT INTO `user_operation_log` VALUES (153, 'admin', 'PUT', '/admin/tenant/tenant/4', '编辑租户', '172.17.0.1', '2025-06-25 07:24:50', '2025-06-25 07:24:50', NULL, '{\"id\":4,\"tenant_id\":\"000003\",\"contact_user_name\":\"fffrwds\",\"contact_phone\":\"444\",\"company_name\":\"fcgdg2\",\"license_number\":\"\",\"address\":\"\",\"intro\":\"\",\"domain\":\"\",\"account_count\":1,\"is_enabled\":true,\"created_by\":1,\"created_at\":\"2025-06-23T01:47:35.000000Z\",\"expired_at\":null,\"updated_by\":1,\"updated_at\":\"2025-06-24T23:24:37.000000Z\",\"safe_level\":1,\"deleted_by\":0,\"deleted_at\":null,\"remark\":null}', 200, 1, '{\"request_id\":\"4f40c85e-0093-456c-9358-52a76024dd7e\",\"path\":\"\\/admin\\/tenant\\/tenant\\/4\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\"}', 1, '4f40c85e-0093-456c-9358-52a76024dd7e', 111);
INSERT INTO `user_operation_log` VALUES (154, 'admin', 'PUT', '/admin/tenant/tenant/4', '编辑租户', '172.17.0.1', '2025-06-25 07:25:18', '2025-06-25 07:25:18', NULL, '{\"id\":4,\"tenant_id\":\"000003\",\"contact_user_name\":\"fffrwds\",\"contact_phone\":\"444\",\"company_name\":\"fcgdg2\",\"license_number\":\"\",\"address\":\"\",\"intro\":\"\",\"domain\":\"\",\"account_count\":1,\"is_enabled\":false,\"created_by\":1,\"created_at\":\"2025-06-23T01:47:35.000000Z\",\"expired_at\":null,\"updated_by\":1,\"updated_at\":\"2025-06-24T23:24:37.000000Z\",\"safe_level\":1,\"deleted_by\":0,\"deleted_at\":null,\"remark\":null}', 200, 1, '{\"request_id\":\"72d938c4-5fd6-4655-aeee-5c874fdb8b1c\",\"path\":\"\\/admin\\/tenant\\/tenant\\/4\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\"}', 1, '72d938c4-5fd6-4655-aeee-5c874fdb8b1c', 213);
INSERT INTO `user_operation_log` VALUES (155, 'admin', 'PUT', '/admin/tenant/tenant/4', '编辑租户', '172.17.0.1', '2025-06-25 07:25:27', '2025-06-25 07:25:27', NULL, '{\"id\":4,\"tenant_id\":\"000003\",\"contact_user_name\":\"fffrwds\",\"contact_phone\":\"444\",\"company_name\":\"fcgdg2\",\"license_number\":\"\",\"address\":\"\",\"intro\":\"\",\"domain\":\"\",\"account_count\":1,\"is_enabled\":true,\"created_by\":1,\"created_at\":\"2025-06-23T01:47:35.000000Z\",\"expired_at\":null,\"updated_by\":1,\"updated_at\":\"2025-06-24T23:25:18.000000Z\",\"safe_level\":1,\"deleted_by\":0,\"deleted_at\":null,\"remark\":null}', 200, 1, '{\"request_id\":\"f8125cb2-3f84-416e-a629-9d1101e1ef9c\",\"path\":\"\\/admin\\/tenant\\/tenant\\/4\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\"}', 1, 'f8125cb2-3f84-416e-a629-9d1101e1ef9c', 213);
INSERT INTO `user_operation_log` VALUES (156, 'admin', 'PUT', '/admin/tenant/tenant/2', '编辑租户', '172.17.0.1', '2025-06-25 07:25:34', '2025-06-25 07:25:34', NULL, '{\"id\":2,\"tenant_id\":\"000001\",\"contact_user_name\":\"gaxx\",\"contact_phone\":\"11\",\"company_name\":\"\",\"license_number\":\"\",\"address\":\"\",\"intro\":\"\",\"domain\":\"\",\"account_count\":1,\"is_enabled\":false,\"created_by\":1,\"created_at\":\"2025-06-23T01:33:50.000000Z\",\"expired_at\":null,\"updated_by\":1,\"updated_at\":\"2025-06-24T12:31:34.000000Z\",\"safe_level\":1,\"deleted_by\":1,\"deleted_at\":null,\"remark\":null}', 500, 2, '{\"request_id\":\"f4fe3d22-0471-4b81-8d26-3c247a98b24d\",\"path\":\"\\/admin\\/tenant\\/tenant\\/2\",\"success\":false,\"code\":100422,\"message\":\"company name \\u4e0d\\u80fd\\u4e3a\\u7a7a\\u3002\"}', 1, 'f4fe3d22-0471-4b81-8d26-3c247a98b24d', 1);
INSERT INTO `user_operation_log` VALUES (157, 'admin', 'PUT', '/admin/tenant/tenant/2', '编辑租户', '172.17.0.1', '2025-06-25 07:25:42', '2025-06-25 07:25:42', NULL, '{\"id\":2,\"tenant_id\":\"000001\",\"contact_user_name\":\"gaxx\",\"contact_phone\":\"11\",\"company_name\":\"d\",\"license_number\":\"\",\"address\":\"\",\"intro\":\"\",\"domain\":\"\",\"account_count\":1,\"is_enabled\":true,\"created_by\":1,\"created_at\":\"2025-06-23T01:33:50.000000Z\",\"expired_at\":null,\"updated_by\":1,\"updated_at\":\"2025-06-24T12:31:34.000000Z\",\"safe_level\":1,\"deleted_by\":1,\"deleted_at\":null,\"remark\":null}', 200, 1, '{\"request_id\":\"0640d9ce-9f1f-4550-8d38-81f09f3b927d\",\"path\":\"\\/admin\\/tenant\\/tenant\\/2\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\"}', 1, '0640d9ce-9f1f-4550-8d38-81f09f3b927d', 213);
INSERT INTO `user_operation_log` VALUES (158, 'admin', 'PUT', '/admin/tenant/tenant/1', '编辑租户', '172.17.0.1', '2025-06-25 07:25:47', '2025-06-25 07:25:47', NULL, '{\"id\":1,\"tenant_id\":\"000000\",\"contact_user_name\":\"haha\",\"contact_phone\":\"12345\",\"company_name\":\"w\",\"license_number\":\"\",\"address\":\"\",\"intro\":\"\",\"domain\":\"\",\"account_count\":1,\"is_enabled\":true,\"created_by\":1,\"created_at\":\"2025-06-23T01:22:28.000000Z\",\"expired_at\":null,\"updated_by\":0,\"updated_at\":\"2025-06-23T01:22:28.000000Z\",\"safe_level\":1,\"deleted_by\":0,\"deleted_at\":null,\"remark\":null}', 200, 1, '{\"request_id\":\"2e0d4c4b-2254-4f05-8746-583e9c127607\",\"path\":\"\\/admin\\/tenant\\/tenant\\/1\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\"}', 1, '2e0d4c4b-2254-4f05-8746-583e9c127607', 217);
INSERT INTO `user_operation_log` VALUES (159, 'admin', 'DELETE', '/admin/tenant/tenant', '删除租户', '172.17.0.1', '2025-06-26 06:05:14', '2025-06-26 06:05:14', NULL, '[2]', 200, 1, '{\"request_id\":\"999880d4-728a-4e1a-b537-2d5d79c70e7d\",\"path\":\"\\/admin\\/tenant\\/tenant\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\"}', 1, '999880d4-728a-4e1a-b537-2d5d79c70e7d', 204);
INSERT INTO `user_operation_log` VALUES (160, 'admin', 'PUT', '/admin/tenant/tenant/recovery', '租户回收站恢复', '172.17.0.1', '2025-06-26 06:40:06', '2025-06-26 06:40:06', NULL, '{\"ids\":[2]}', 200, 1, '{\"request_id\":\"6fe838f4-1170-47d7-a639-606999914fc5\",\"path\":\"\\/admin\\/tenant\\/tenant\\/recovery\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\"}', 1, '6fe838f4-1170-47d7-a639-606999914fc5', 201);
INSERT INTO `user_operation_log` VALUES (161, 'admin', 'POST', '/admin/department', '创建部门', '172.17.0.1', '2025-06-26 07:09:50', '2025-06-26 07:09:50', NULL, '{\"parent_id\":1,\"name\":\"\\u8fd0\\u84251\"}', 200, 1, '{\"request_id\":\"ee6ab112-e3d1-463d-aa4c-5f9430a50008\",\"path\":\"\\/admin\\/department\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\"}', 1, 'ee6ab112-e3d1-463d-aa4c-5f9430a50008', 753);
INSERT INTO `user_operation_log` VALUES (162, 'admin', 'POST', '/admin/tenant/tenant_app', '创建租户应用', '172.17.0.1', '2025-06-26 14:21:41', '2025-06-26 14:21:41', NULL, '{\"tenant_id\":\"000000\",\"app_name\":\"s\",\"description\":\"s\",\"remark\":\"s\"}', 500, 2, '{\"request_id\":\"c2b7f48e-9b43-4df1-937b-4111b88d0da5\",\"path\":\"\\/admin\\/tenant\\/tenant_app\",\"success\":false,\"code\":100422,\"message\":\"status \\u4e0d\\u80fd\\u4e3a\\u7a7a\\u3002\"}', 1, 'c2b7f48e-9b43-4df1-937b-4111b88d0da5', 365);
INSERT INTO `user_operation_log` VALUES (163, 'admin', 'POST', '/admin/tenant/tenant_app', '创建租户应用', '172.17.0.1', '2025-06-26 14:23:54', '2025-06-26 14:23:54', NULL, '{\"tenant_id\":\"000000\",\"app_name\":\"s\",\"description\":\"s\",\"remark\":\"s\"}', 422, 2, '{\"request_id\":\"6cd45361-90b4-4c02-9507-0f3c0eb59e75\",\"path\":\"\\/admin\\/tenant\\/tenant_app\",\"success\":false,\"code\":100422,\"message\":\"status \\u4e0d\\u80fd\\u4e3a\\u7a7a\\u3002\"}', 1, '6cd45361-90b4-4c02-9507-0f3c0eb59e75', 359);
INSERT INTO `user_operation_log` VALUES (164, 'admin', 'POST', '/admin/tenant/tenant_app', '创建租户应用', '172.17.0.1', '2025-06-26 14:27:40', '2025-06-26 14:27:40', NULL, '{\"status\":true,\"tenant_id\":\"000001\",\"app_name\":\"ee\",\"description\":\"ww\",\"remark\":\"w\"}', 500, 2, '{\"request_id\":\"ff9007f9-14e7-45a4-9693-c7612d6a9d90\",\"path\":\"\\/admin\\/tenant\\/tenant_app\",\"success\":false,\"code\":100500,\"message\":\"Call to undefined function app\\\\model\\\\str_random()\"}', 1, 'ff9007f9-14e7-45a4-9693-c7612d6a9d90', 278);
INSERT INTO `user_operation_log` VALUES (165, 'admin', 'POST', '/admin/tenant/tenant_app', '创建租户应用', '172.17.0.1', '2025-06-26 14:29:08', '2025-06-26 14:29:08', NULL, '{\"status\":true,\"tenant_id\":\"000001\",\"app_name\":\"ee\",\"description\":\"ww\",\"remark\":\"w\"}', 200, 1, '{\"request_id\":\"4f46bd45-7354-42fe-9850-8147964eb52b\",\"path\":\"\\/admin\\/tenant\\/tenant_app\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\"}', 1, '4f46bd45-7354-42fe-9850-8147964eb52b', 513);
INSERT INTO `user_operation_log` VALUES (166, 'admin', 'PUT', '/admin/tenant/tenant_app/1', '编辑租户应用', '172.17.0.1', '2025-06-26 14:37:18', '2025-06-26 14:37:18', NULL, '{\"id\":1,\"tenant_id\":\"000001\",\"app_name\":\"ee\",\"app_key\":\"Cjikn5IRJiYJIvSC\",\"app_secret\":\"f594848f6a4db258bb2ad46ce978e84a\",\"status\":true,\"description\":\"e\",\"created_by\":1,\"created_at\":\"2025-06-26T06:29:08.000000Z\",\"updated_by\":0,\"updated_at\":\"2025-06-26T06:29:08.000000Z\",\"deleted_by\":0,\"deleted_at\":null,\"remark\":\"w\"}', 200, 1, '{\"request_id\":\"d3cf2cb0-a37e-4be0-96ab-563e037f88e9\",\"path\":\"\\/admin\\/tenant\\/tenant_app\\/1\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\"}', 1, 'd3cf2cb0-a37e-4be0-96ab-563e037f88e9', 229);
INSERT INTO `user_operation_log` VALUES (167, 'admin', 'PUT', '/admin/tenant/tenant_app/1', '编辑租户应用', '172.17.0.1', '2025-06-26 15:29:36', '2025-06-26 15:29:36', NULL, '{\"id\":1,\"tenant_id\":\"000001\",\"app_name\":\"ee\",\"app_key\":\"Cjikn5IRJiYJIvSC\",\"app_secret\":\"f594848f6a4db258bb2ad46ce978e84a\",\"status\":false,\"description\":null,\"created_by\":1,\"created_at\":\"2025-06-26 14:29:08\",\"updated_by\":1,\"updated_at\":\"2025-06-26 14:37:18\",\"deleted_by\":0,\"deleted_at\":null,\"remark\":\"w\"}', 500, 2, '{\"request_id\":\"f503759d-35e9-43b4-ac52-bd41c8871822\",\"path\":\"\\/admin\\/tenant\\/tenant_app\\/1\",\"success\":false,\"code\":100422,\"message\":\"status \\u5fc5\\u987b\\u662f\\u6574\\u6570\\u3002\"}', 1, 'f503759d-35e9-43b4-ac52-bd41c8871822', 190);
INSERT INTO `user_operation_log` VALUES (168, 'admin', 'PUT', '/admin/tenant/tenant_app/1', '编辑租户应用', '172.17.0.1', '2025-06-26 15:29:43', '2025-06-26 15:29:43', NULL, '{\"id\":1,\"tenant_id\":\"000001\",\"app_name\":\"ee\",\"app_key\":\"Cjikn5IRJiYJIvSC\",\"app_secret\":\"f594848f6a4db258bb2ad46ce978e84a\",\"status\":false,\"description\":null,\"created_by\":1,\"created_at\":\"2025-06-26 14:29:08\",\"updated_by\":1,\"updated_at\":\"2025-06-26 14:37:18\",\"deleted_by\":0,\"deleted_at\":null,\"remark\":\"w\"}', 500, 2, '{\"request_id\":\"57854e67-764e-4f70-9922-72bb57df6bbc\",\"path\":\"\\/admin\\/tenant\\/tenant_app\\/1\",\"success\":false,\"code\":100422,\"message\":\"status \\u5fc5\\u987b\\u662f\\u6574\\u6570\\u3002\"}', 1, '57854e67-764e-4f70-9922-72bb57df6bbc', 1);
INSERT INTO `user_operation_log` VALUES (169, 'admin', 'PUT', '/admin/tenant/tenant_app/1', '编辑租户应用', '172.17.0.1', '2025-06-26 15:30:27', '2025-06-26 15:30:27', NULL, '{\"id\":1,\"tenant_id\":\"000001\",\"app_name\":\"ee\",\"app_key\":\"Cjikn5IRJiYJIvSC\",\"app_secret\":\"f594848f6a4db258bb2ad46ce978e84a\",\"status\":false,\"description\":null,\"created_by\":1,\"created_at\":\"2025-06-26 14:29:08\",\"updated_by\":1,\"updated_at\":\"2025-06-26 14:37:18\",\"deleted_by\":0,\"deleted_at\":null,\"remark\":\"w\"}', 200, 1, '{\"request_id\":\"6927545f-4b92-4deb-b1f1-8afc19bb2e11\",\"path\":\"\\/admin\\/tenant\\/tenant_app\\/1\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\"}', 1, '6927545f-4b92-4deb-b1f1-8afc19bb2e11', 589);
INSERT INTO `user_operation_log` VALUES (170, 'admin', 'PUT', '/admin/tenant/tenant_app/1', '编辑租户应用', '172.17.0.1', '2025-06-26 15:31:42', '2025-06-26 15:31:42', NULL, '{\"id\":1,\"tenant_id\":\"000001\",\"app_name\":\"ee\",\"app_key\":\"Cjikn5IRJiYJIvSC\",\"app_secret\":\"f594848f6a4db258bb2ad46ce978e84a\",\"status\":true,\"description\":null,\"created_by\":1,\"created_at\":\"2025-06-26 14:29:08\",\"updated_by\":1,\"updated_at\":\"2025-06-26 15:30:27\",\"deleted_by\":0,\"deleted_at\":null,\"remark\":\"w\"}', 200, 1, '{\"request_id\":\"fd9d2ed7-8798-4b03-948d-b67d49a5ab1b\",\"path\":\"\\/admin\\/tenant\\/tenant_app\\/1\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\"}', 1, 'fd9d2ed7-8798-4b03-948d-b67d49a5ab1b', 173);
INSERT INTO `user_operation_log` VALUES (171, 'admin', 'PUT', '/admin/tenant/tenant_app/1', '编辑租户应用', '172.17.0.1', '2025-06-26 15:31:45', '2025-06-26 15:31:45', NULL, '{\"id\":1,\"tenant_id\":\"000001\",\"app_name\":\"ee\",\"app_key\":\"Cjikn5IRJiYJIvSC\",\"app_secret\":\"f594848f6a4db258bb2ad46ce978e84a\",\"status\":false,\"description\":null,\"created_by\":1,\"created_at\":\"2025-06-26 14:29:08\",\"updated_by\":1,\"updated_at\":\"2025-06-26 15:31:42\",\"deleted_by\":0,\"deleted_at\":null,\"remark\":\"w\"}', 200, 1, '{\"request_id\":\"deed3a34-f8e1-40e6-945c-d058272cca8d\",\"path\":\"\\/admin\\/tenant\\/tenant_app\\/1\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\"}', 1, 'deed3a34-f8e1-40e6-945c-d058272cca8d', 167);
INSERT INTO `user_operation_log` VALUES (172, 'admin', 'PUT', '/admin/tenant/tenant_app/1', '编辑租户应用', '172.17.0.1', '2025-06-26 15:32:35', '2025-06-26 15:32:35', NULL, '{\"id\":1,\"tenant_id\":\"000001\",\"app_name\":\"ee\",\"app_key\":\"Cjikn5IRJiYJIvSC\",\"app_secret\":\"f594848f6a4db258bb2ad46ce978e84a\",\"status\":true,\"description\":null,\"created_by\":1,\"created_at\":\"2025-06-26 14:29:08\",\"updated_by\":1,\"updated_at\":\"2025-06-26 15:31:44\",\"deleted_by\":0,\"deleted_at\":null,\"remark\":\"w\"}', 200, 1, '{\"request_id\":\"9eb9dc0a-f261-4d8a-9bae-4b9096340ab6\",\"path\":\"\\/admin\\/tenant\\/tenant_app\\/1\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\"}', 1, '9eb9dc0a-f261-4d8a-9bae-4b9096340ab6', 169);
INSERT INTO `user_operation_log` VALUES (173, 'admin', 'PUT', '/admin/tenant/tenant_app/1', '编辑租户应用', '172.17.0.1', '2025-06-26 15:32:37', '2025-06-26 15:32:37', NULL, '{\"id\":1,\"tenant_id\":\"000001\",\"app_name\":\"ee\",\"app_key\":\"Cjikn5IRJiYJIvSC\",\"app_secret\":\"f594848f6a4db258bb2ad46ce978e84a\",\"status\":false,\"description\":null,\"created_by\":1,\"created_at\":\"2025-06-26 14:29:08\",\"updated_by\":1,\"updated_at\":\"2025-06-26 15:32:34\",\"deleted_by\":0,\"deleted_at\":null,\"remark\":\"w\"}', 200, 1, '{\"request_id\":\"16ebcfac-278b-4d8a-9fd3-d14075d726dc\",\"path\":\"\\/admin\\/tenant\\/tenant_app\\/1\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\"}', 1, '16ebcfac-278b-4d8a-9fd3-d14075d726dc', 178);
INSERT INTO `user_operation_log` VALUES (174, 'admin', 'DELETE', '/admin/tenant/tenant_app', '删除租户应用', '172.17.0.1', '2025-06-26 15:32:53', '2025-06-26 15:32:53', NULL, '[1]', 200, 1, '{\"request_id\":\"acadcb64-0602-42db-aa6a-56ab465fca4a\",\"path\":\"\\/admin\\/tenant\\/tenant_app\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\"}', 1, 'acadcb64-0602-42db-aa6a-56ab465fca4a', 167);
INSERT INTO `user_operation_log` VALUES (175, 'admin', 'PUT', '/admin/tenant/tenant_app/recovery', '租户回收站恢复', '172.17.0.1', '2025-06-26 15:32:59', '2025-06-26 15:32:59', NULL, '{\"ids\":[1]}', 200, 1, '{\"request_id\":\"fa613959-975c-473f-ab1a-0ceb53d4a29b\",\"path\":\"\\/admin\\/tenant\\/tenant_app\\/recovery\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\"}', 1, 'fa613959-975c-473f-ab1a-0ceb53d4a29b', 171);
INSERT INTO `user_operation_log` VALUES (176, 'admin', 'DELETE', '/admin/tenant/tenant_app', '删除租户应用', '172.17.0.1', '2025-06-26 15:33:06', '2025-06-26 15:33:06', NULL, '[1]', 200, 1, '{\"request_id\":\"0011513c-4491-47ad-b7d9-0d2a7ae5bf2c\",\"path\":\"\\/admin\\/tenant\\/tenant_app\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\"}', 1, '0011513c-4491-47ad-b7d9-0d2a7ae5bf2c', 170);
INSERT INTO `user_operation_log` VALUES (177, 'admin', 'PUT', '/admin/tenant/tenant_app/recovery', '租户回收站恢复', '172.17.0.1', '2025-06-26 15:33:11', '2025-06-26 15:33:11', NULL, '{\"ids\":[1]}', 200, 1, '{\"request_id\":\"c4c8fed6-1b96-49af-9787-cb666a4766ea\",\"path\":\"\\/admin\\/tenant\\/tenant_app\\/recovery\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\"}', 1, 'c4c8fed6-1b96-49af-9787-cb666a4766ea', 171);
INSERT INTO `user_operation_log` VALUES (178, 'admin', 'PUT', '/admin/tenant/tenant_app/1', '编辑租户应用', '172.17.0.1', '2025-06-26 15:33:46', '2025-06-26 15:33:46', NULL, '{\"id\":1,\"tenant_id\":\"000001\",\"app_name\":\"ee\",\"app_key\":\"Cjikn5IRJiYJIvSC\",\"app_secret\":\"f594848f6a4db258bb2ad46ce978e84a\",\"status\":true,\"description\":null,\"created_by\":1,\"created_at\":\"2025-06-26 14:29:08\",\"updated_by\":1,\"updated_at\":\"2025-06-26 15:33:11\",\"deleted_by\":1,\"deleted_at\":null,\"remark\":\"w\"}', 200, 1, '{\"request_id\":\"0dabc1d3-e5f0-4726-86bf-9f6a59d50319\",\"path\":\"\\/admin\\/tenant\\/tenant_app\\/1\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\"}', 1, '0dabc1d3-e5f0-4726-86bf-9f6a59d50319', 172);
INSERT INTO `user_operation_log` VALUES (179, 'admin', 'PUT', '/admin/tenant/tenant_app/1', '编辑租户应用', '172.17.0.1', '2025-06-26 15:54:55', '2025-06-26 15:54:55', NULL, '{\"id\":1,\"tenant_id\":\"000001\",\"app_name\":\"ee\",\"app_key\":\"Cjikn5IRJiYJIvSC\",\"app_secret\":\"f594848f6a4db258bb2ad46ce978e84a\",\"status\":true,\"description\":\"ddd\",\"created_by\":1,\"created_at\":\"2025-06-26 14:29:08\",\"updated_by\":1,\"updated_at\":\"2025-06-26 15:33:46\",\"deleted_by\":1,\"deleted_at\":null,\"remark\":\"w\"}', 200, 1, '{\"request_id\":\"ff062211-d4f2-4dea-852d-57d4cb14cad9\",\"path\":\"\\/admin\\/tenant\\/tenant_app\\/1\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\"}', 1, 'ff062211-d4f2-4dea-852d-57d4cb14cad9', 84);
INSERT INTO `user_operation_log` VALUES (180, 'admin', 'PUT', '/admin/tenant/tenant_app/1', '编辑租户应用', '172.17.0.1', '2025-06-26 15:55:05', '2025-06-26 15:55:05', NULL, '{\"id\":1,\"tenant_id\":\"000001\",\"app_name\":\"ee\",\"app_key\":\"Cjikn5IRJiYJIvSC\",\"app_secret\":\"f594848f6a4db258bb2ad46ce978e84a\",\"status\":true,\"description\":\"dddd\",\"created_by\":1,\"created_at\":\"2025-06-26 14:29:08\",\"updated_by\":1,\"updated_at\":\"2025-06-26 15:33:46\",\"deleted_by\":1,\"deleted_at\":null,\"remark\":\"w\"}', 200, 1, '{\"request_id\":\"922ad75c-e780-4d86-a075-923459e594f6\",\"path\":\"\\/admin\\/tenant\\/tenant_app\\/1\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\"}', 1, '922ad75c-e780-4d86-a075-923459e594f6', 81);
INSERT INTO `user_operation_log` VALUES (181, 'admin', 'PUT', '/admin/tenant/tenant_app/1', '编辑租户应用', '172.17.0.1', '2025-06-26 15:56:56', '2025-06-26 15:56:56', NULL, '{\"id\":1,\"tenant_id\":\"000001\",\"app_name\":\"ee\",\"app_key\":\"Cjikn5IRJiYJIvSC\",\"app_secret\":\"f594848f6a4db258bb2ad46ce978e84a\",\"status\":true,\"description\":\"ssss\",\"created_by\":1,\"created_at\":\"2025-06-26 14:29:08\",\"updated_by\":1,\"updated_at\":\"2025-06-26 15:33:46\",\"deleted_by\":1,\"deleted_at\":null,\"remark\":\"w\"}', 200, 1, '{\"request_id\":\"dcad4908-af30-4be5-b1a9-3ee10dfaa69b\",\"path\":\"\\/admin\\/tenant\\/tenant_app\\/1\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\"}', 1, 'dcad4908-af30-4be5-b1a9-3ee10dfaa69b', 488);
INSERT INTO `user_operation_log` VALUES (182, 'admin', 'POST', '/admin/attachment/upload', '上传附件', '172.17.0.1', '2025-06-26 20:42:44', '2025-06-26 20:42:44', NULL, '[]', 200, 1, '{\"request_id\":\"9cb414c7-4c08-48c0-8c25-0a178fb14e4f\",\"path\":\"\\/admin\\/attachment\\/upload\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\",\"data\":{\"id\":20,\"storage_mode\":0,\"origin_name\":\"Loading1.png\",\"object_name\":\"7a8d99685b2b0b1ab94afd4926138211.png\",\"hash\":\"7a8d99685b2b0b1ab94afd4926138211\",\"mime_type\":\"image\\/png\",\"storage_path\":\"\\/opt\\/www\\/public\\/upload\\/7a8d99685b2b0b1ab94afd4926138211.png\",\"base_path\":\"\\/upload\\/7a8d99685b2b0b1ab94afd4926138211.png\",\"suffix\":\"png\",\"url\":\"https:\\/\\/server.bug.it.com\\/upload\\/7a8d99685b2b0b1ab94afd4926138211.png\",\"size_byte\":1367874,\"size_info\":\"1.3 MB\",\"remark\":null,\"created_at\":\"2025-06-21 09:05:08\",\"updated_at\":\"2025-06-21 09:05:08\",\"created_by\":null,\"updated_by\":0}}', 1, '9cb414c7-4c08-48c0-8c25-0a178fb14e4f', 662);
INSERT INTO `user_operation_log` VALUES (183, 'admin', 'POST', '/admin/tenant/tenant_user', '添加租户成员', '172.17.0.1', '2025-06-26 20:42:57', '2025-06-26 20:42:57', NULL, '{\"password\":\"123456\",\"status\":2,\"is_enabled_google\":1,\"tenant_id\":\"000000\",\"avatar\":\"https:\\/\\/server.bug.it.com\\/upload\\/7a8d99685b2b0b1ab94afd4926138211.png\",\"username\":\"ss\",\"phone\":\"ss\"}', 200, 1, '{\"request_id\":\"63e420a4-034a-4e42-9421-61b506ff6c53\",\"path\":\"\\/admin\\/tenant\\/tenant_user\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\"}', 1, '63e420a4-034a-4e42-9421-61b506ff6c53', 134);
INSERT INTO `user_operation_log` VALUES (184, 'admin', 'POST', '/admin/tenant/tenant_user', '添加租户成员', '172.17.0.1', '2025-06-26 20:43:37', '2025-06-26 20:43:37', NULL, '{\"password\":\"123456\",\"status\":true,\"tenant_id\":\"000001\",\"username\":\"wwq\",\"phone\":\"ww\",\"is_enabled_google\":1}', 200, 1, '{\"request_id\":\"5ce662bb-aab1-446b-9309-bc621264fc56\",\"path\":\"\\/admin\\/tenant\\/tenant_user\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\"}', 1, '5ce662bb-aab1-446b-9309-bc621264fc56', 79);
INSERT INTO `user_operation_log` VALUES (185, 'admin', 'DELETE', '/admin/tenant/tenant', '删除租户', '172.17.0.1', '2025-06-27 01:42:26', '2025-06-27 01:42:26', NULL, '[4]', 200, 1, '{\"request_id\":\"7d1acb20-ba39-4cde-b6f1-5579383fa916\",\"path\":\"\\/admin\\/tenant\\/tenant\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\"}', 1, '7d1acb20-ba39-4cde-b6f1-5579383fa916', 768);
INSERT INTO `user_operation_log` VALUES (186, 'admin', 'DELETE', '/admin/tenant/tenant', '删除租户', '172.17.0.1', '2025-06-27 01:42:40', '2025-06-27 01:42:40', NULL, '[4]', 200, 1, '{\"request_id\":\"60c11fe1-8460-4b33-9116-09853af0ec7b\",\"path\":\"\\/admin\\/tenant\\/tenant\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\"}', 1, '60c11fe1-8460-4b33-9116-09853af0ec7b', 382);
INSERT INTO `user_operation_log` VALUES (187, 'admin', 'DELETE', '/admin/tenant/tenant/real_delete', '清空回收站', '172.17.0.1', '2025-06-27 01:49:08', '2025-06-27 01:49:08', NULL, '[4]', 200, 1, '{\"request_id\":\"e878f28f-9090-42a3-a96b-206671c598fd\",\"path\":\"\\/admin\\/tenant\\/tenant\\/real_delete\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\"}', 1, 'e878f28f-9090-42a3-a96b-206671c598fd', 761);
INSERT INTO `user_operation_log` VALUES (188, 'admin', 'DELETE', '/admin/tenant/tenant_user', '删除租户成员', '172.17.0.1', '2025-06-27 01:54:50', '2025-06-27 01:54:50', NULL, '[null]', 200, 1, '{\"request_id\":\"d0924a8d-e657-41ee-a368-0316d676d364\",\"path\":\"\\/admin\\/tenant\\/tenant_user\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\"}', 1, 'd0924a8d-e657-41ee-a368-0316d676d364', 400);
INSERT INTO `user_operation_log` VALUES (189, 'admin', 'DELETE', '/admin/tenant/tenant_user', '删除租户成员', '172.17.0.1', '2025-06-27 01:55:27', '2025-06-27 01:55:27', NULL, '[null]', 200, 1, '{\"request_id\":\"faac226e-9ffc-47ae-8540-b17cffa1465e\",\"path\":\"\\/admin\\/tenant\\/tenant_user\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\"}', 1, 'faac226e-9ffc-47ae-8540-b17cffa1465e', 373);
INSERT INTO `user_operation_log` VALUES (190, 'admin', 'DELETE', '/admin/tenant/tenant_user', '删除租户成员', '172.17.0.1', '2025-06-27 01:56:33', '2025-06-27 01:56:33', NULL, '[null]', 200, 1, '{\"request_id\":\"97ab49d2-5dac-4ed0-83e2-5c10889d66c4\",\"path\":\"\\/admin\\/tenant\\/tenant_user\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\"}', 1, '97ab49d2-5dac-4ed0-83e2-5c10889d66c4', 392);
INSERT INTO `user_operation_log` VALUES (191, 'admin', 'DELETE', '/admin/tenant/tenant_user', '删除租户成员', '172.17.0.1', '2025-06-27 01:57:34', '2025-06-27 01:57:34', NULL, '[30]', 200, 1, '{\"request_id\":\"eb6d0d2e-c99f-4155-b775-bded969bdee8\",\"path\":\"\\/admin\\/tenant\\/tenant_user\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\"}', 1, 'eb6d0d2e-c99f-4155-b775-bded969bdee8', 741);
INSERT INTO `user_operation_log` VALUES (192, 'admin', 'PUT', '/admin/tenant/tenant_user/recovery', '编辑租户成员', '172.17.0.1', '2025-06-27 01:57:47', '2025-06-27 01:57:47', NULL, '{\"ids\":[30]}', 400, 2, '{\"request_id\":\"52d31621-f057-4aca-8812-9ba89364449a\",\"path\":\"\\/admin\\/tenant\\/tenant_user\\/recovery\",\"success\":false,\"code\":100400,\"message\":\"Input :parameter must be of type :exceptType, :actualType given\"}', 1, '52d31621-f057-4aca-8812-9ba89364449a', 151);
INSERT INTO `user_operation_log` VALUES (193, 'admin', 'PUT', '/admin/tenant/tenant_user/recovery', '租户回收站恢复', '172.17.0.1', '2025-06-27 02:01:29', '2025-06-27 02:01:29', NULL, '{\"ids\":[30]}', 200, 1, '{\"request_id\":\"e79238c4-0602-4d05-9e29-6ada5f1ac597\",\"path\":\"\\/admin\\/tenant\\/tenant_user\\/recovery\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\"}', 1, 'e79238c4-0602-4d05-9e29-6ada5f1ac597', 1047);
INSERT INTO `user_operation_log` VALUES (194, 'admin', 'DELETE', '/admin/tenant/tenant_user', '删除租户成员', '172.17.0.1', '2025-06-27 02:01:47', '2025-06-27 02:01:47', NULL, '[30]', 200, 1, '{\"request_id\":\"a7ddb2c7-719b-453c-b1d3-3397e422944f\",\"path\":\"\\/admin\\/tenant\\/tenant_user\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\"}', 1, 'a7ddb2c7-719b-453c-b1d3-3397e422944f', 778);
INSERT INTO `user_operation_log` VALUES (195, 'admin', 'DELETE', '/admin/tenant/tenant_user/real_delete', '清空回收站', '172.17.0.1', '2025-06-27 02:02:06', '2025-06-27 02:02:06', NULL, '[30]', 200, 1, '{\"request_id\":\"f7b7f005-633b-4cd6-9a4a-ab7bb3ee2b9a\",\"path\":\"\\/admin\\/tenant\\/tenant_user\\/real_delete\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\"}', 1, 'f7b7f005-633b-4cd6-9a4a-ab7bb3ee2b9a', 779);
INSERT INTO `user_operation_log` VALUES (196, 'admin', 'PUT', '/admin/tenant/tenant_user/undefined', '编辑租户成员', '172.17.0.1', '2025-06-27 02:16:47', '2025-06-27 02:16:47', NULL, '{\"user_id\":29,\"tenant_id\":\"000000\",\"username\":\"ss\",\"password\":\"\",\"phone\":\"ss\",\"avatar\":\"\",\"last_login_ip\":\"\",\"last_login_time\":null,\"status\":false,\"is_enabled_google\":1,\"google_secret\":\"\",\"is_bind_google\":2,\"created_by\":1,\"created_at\":\"2025-06-26 20:42:57\",\"updated_by\":0,\"updated_at\":\"2025-06-26 20:42:57\",\"deleted_by\":0,\"deleted_at\":null,\"ip_whitelist\":null,\"remark\":\"\"}', 400, 2, '{\"request_id\":\"9168a338-8f04-42d2-a2e7-db28b9a438d9\",\"path\":\"\\/admin\\/tenant\\/tenant_user\\/undefined\",\"success\":false,\"code\":100400,\"message\":\"Input :parameter must be of type :exceptType, :actualType given\"}', 1, '9168a338-8f04-42d2-a2e7-db28b9a438d9', 92);
INSERT INTO `user_operation_log` VALUES (197, 'admin', 'PUT', '/admin/tenant/tenant_user/undefined', '编辑租户成员', '172.17.0.1', '2025-06-27 02:17:14', '2025-06-27 02:17:14', NULL, '{\"user_id\":29,\"tenant_id\":\"000000\",\"username\":\"ss\",\"password\":\"\",\"phone\":\"ss\",\"avatar\":\"\",\"last_login_ip\":\"\",\"last_login_time\":null,\"status\":false,\"is_enabled_google\":1,\"google_secret\":\"\",\"is_bind_google\":2,\"created_by\":1,\"created_at\":\"2025-06-26 20:42:57\",\"updated_by\":0,\"updated_at\":\"2025-06-26 20:42:57\",\"deleted_by\":0,\"deleted_at\":null,\"ip_whitelist\":null,\"remark\":\"\"}', 400, 2, '{\"request_id\":\"ecb269d2-5c79-41c6-964e-ece494cea62c\",\"path\":\"\\/admin\\/tenant\\/tenant_user\\/undefined\",\"success\":false,\"code\":100400,\"message\":\"Input :parameter must be of type :exceptType, :actualType given\"}', 1, 'ecb269d2-5c79-41c6-964e-ece494cea62c', 0);
INSERT INTO `user_operation_log` VALUES (198, 'admin', 'PUT', '/admin/tenant/tenant_user/undefined', '编辑租户成员', '172.17.0.1', '2025-06-27 02:17:18', '2025-06-27 02:17:18', NULL, '{\"user_id\":29,\"tenant_id\":\"000000\",\"username\":\"ss\",\"password\":\"\",\"phone\":\"ss\",\"avatar\":\"\",\"last_login_ip\":\"\",\"last_login_time\":null,\"status\":true,\"is_enabled_google\":1,\"google_secret\":\"\",\"is_bind_google\":2,\"created_by\":1,\"created_at\":\"2025-06-26 20:42:57\",\"updated_by\":0,\"updated_at\":\"2025-06-26 20:42:57\",\"deleted_by\":0,\"deleted_at\":null,\"ip_whitelist\":null,\"remark\":\"\"}', 400, 2, '{\"request_id\":\"952a2cb9-00f3-4d6a-b7ff-d4f484d754ca\",\"path\":\"\\/admin\\/tenant\\/tenant_user\\/undefined\",\"success\":false,\"code\":100400,\"message\":\"Input :parameter must be of type :exceptType, :actualType given\"}', 1, '952a2cb9-00f3-4d6a-b7ff-d4f484d754ca', 30);
INSERT INTO `user_operation_log` VALUES (199, 'admin', 'PUT', '/admin/tenant/tenant_user/undefined', '编辑租户成员', '172.17.0.1', '2025-06-27 02:17:47', '2025-06-27 02:17:47', NULL, '{\"user_id\":29,\"tenant_id\":\"000000\",\"username\":\"ss\",\"password\":\"\",\"phone\":\"ss\",\"avatar\":\"\",\"last_login_ip\":\"\",\"last_login_time\":null,\"status\":true,\"is_enabled_google\":1,\"google_secret\":\"\",\"is_bind_google\":2,\"created_by\":1,\"created_at\":\"2025-06-26 20:42:57\",\"updated_by\":0,\"updated_at\":\"2025-06-26 20:42:57\",\"deleted_by\":0,\"deleted_at\":null,\"ip_whitelist\":null,\"remark\":\"\"}', 400, 2, '{\"request_id\":\"014cb52b-78d9-4d8a-a571-b52d8cdeb533\",\"path\":\"\\/admin\\/tenant\\/tenant_user\\/undefined\",\"success\":false,\"code\":100400,\"message\":\"Input :parameter must be of type :exceptType, :actualType given\"}', 1, '014cb52b-78d9-4d8a-a571-b52d8cdeb533', 0);
INSERT INTO `user_operation_log` VALUES (200, 'admin', 'PUT', '/admin/tenant/tenant_user/undefined', '编辑租户成员', '172.17.0.1', '2025-06-27 02:21:44', '2025-06-27 02:21:44', NULL, '{\"user_id\":29,\"tenant_id\":\"000000\",\"username\":\"ss\",\"password\":\"\",\"phone\":\"ss\",\"avatar\":\"\",\"last_login_ip\":\"\",\"last_login_time\":null,\"status\":false,\"is_enabled_google\":1,\"google_secret\":\"\",\"is_bind_google\":2,\"created_by\":1,\"created_at\":\"2025-06-26 20:42:57\",\"updated_by\":0,\"updated_at\":\"2025-06-26 20:42:57\",\"deleted_by\":0,\"deleted_at\":null,\"ip_whitelist\":null,\"remark\":\"\"}', 400, 2, '{\"request_id\":\"a8d2e047-48c9-4d3a-a468-0854e2eb7029\",\"path\":\"\\/admin\\/tenant\\/tenant_user\\/undefined\",\"success\":false,\"code\":100400,\"message\":\"Input :parameter must be of type :exceptType, :actualType given\"}', 1, 'a8d2e047-48c9-4d3a-a468-0854e2eb7029', 0);
INSERT INTO `user_operation_log` VALUES (201, 'admin', 'PUT', '/admin/tenant/tenant_user/undefined', '编辑租户成员', '172.17.0.1', '2025-06-27 02:22:05', '2025-06-27 02:22:05', NULL, '{\"user_id\":29,\"tenant_id\":\"000000\",\"username\":\"ss\",\"password\":\"\",\"phone\":\"ss\",\"avatar\":\"\",\"last_login_ip\":\"\",\"last_login_time\":null,\"status\":false,\"is_enabled_google\":1,\"google_secret\":\"\",\"is_bind_google\":2,\"created_by\":1,\"created_at\":\"2025-06-26 20:42:57\",\"updated_by\":0,\"updated_at\":\"2025-06-26 20:42:57\",\"deleted_by\":0,\"deleted_at\":null,\"ip_whitelist\":null,\"remark\":\"\"}', 400, 2, '{\"request_id\":\"d375fc09-0b3a-4df7-8497-2ab8fce02a02\",\"path\":\"\\/admin\\/tenant\\/tenant_user\\/undefined\",\"success\":false,\"code\":100400,\"message\":\"Input :parameter must be of type :exceptType, :actualType given\"}', 1, 'd375fc09-0b3a-4df7-8497-2ab8fce02a02', 0);
INSERT INTO `user_operation_log` VALUES (202, 'admin', 'PUT', '/admin/tenant/tenant_user/undefined', '编辑租户成员', '172.17.0.1', '2025-06-27 02:23:53', '2025-06-27 02:23:53', NULL, '{\"user_id\":29,\"tenant_id\":\"000000\",\"username\":\"ss\",\"password\":\"\",\"phone\":\"ss\",\"avatar\":\"\",\"last_login_ip\":\"\",\"last_login_time\":null,\"status\":false,\"is_enabled_google\":1,\"google_secret\":\"\",\"is_bind_google\":2,\"created_by\":1,\"created_at\":\"2025-06-26 20:42:57\",\"updated_by\":0,\"updated_at\":\"2025-06-26 20:42:57\",\"deleted_by\":0,\"deleted_at\":null,\"ip_whitelist\":null,\"remark\":\"\"}', 400, 2, '{\"request_id\":\"0c9480e3-b3ba-4068-925e-56f0c2291652\",\"path\":\"\\/admin\\/tenant\\/tenant_user\\/undefined\",\"success\":false,\"code\":100400,\"message\":\"Input :parameter must be of type :exceptType, :actualType given\"}', 1, '0c9480e3-b3ba-4068-925e-56f0c2291652', 0);
INSERT INTO `user_operation_log` VALUES (203, 'admin', 'PUT', '/admin/tenant/tenant_user/undefined', '编辑租户成员', '172.17.0.1', '2025-06-27 02:23:57', '2025-06-27 02:23:57', NULL, '{\"user_id\":29,\"tenant_id\":\"000000\",\"username\":\"ss\",\"password\":\"\",\"phone\":\"ss\",\"avatar\":\"\",\"last_login_ip\":\"\",\"last_login_time\":null,\"status\":true,\"is_enabled_google\":1,\"google_secret\":\"\",\"is_bind_google\":2,\"created_by\":1,\"created_at\":\"2025-06-26 20:42:57\",\"updated_by\":0,\"updated_at\":\"2025-06-26 20:42:57\",\"deleted_by\":0,\"deleted_at\":null,\"ip_whitelist\":null,\"remark\":\"\"}', 400, 2, '{\"request_id\":\"b4a3a279-f40f-4152-b5af-f75cf2d09506\",\"path\":\"\\/admin\\/tenant\\/tenant_user\\/undefined\",\"success\":false,\"code\":100400,\"message\":\"Input :parameter must be of type :exceptType, :actualType given\"}', 1, 'b4a3a279-f40f-4152-b5af-f75cf2d09506', 0);
INSERT INTO `user_operation_log` VALUES (204, 'admin', 'PUT', '/admin/tenant/tenant_user/undefined', '编辑租户成员', '172.17.0.1', '2025-06-27 02:25:10', '2025-06-27 02:25:10', NULL, '{\"user_id\":29,\"tenant_id\":\"000000\",\"username\":\"ss\",\"password\":\"\",\"phone\":\"ss\",\"avatar\":\"\",\"last_login_ip\":\"\",\"last_login_time\":null,\"status\":true,\"is_enabled_google\":1,\"google_secret\":\"\",\"is_bind_google\":2,\"created_by\":1,\"created_at\":\"2025-06-26 20:42:57\",\"updated_by\":0,\"updated_at\":\"2025-06-26 20:42:57\",\"deleted_by\":0,\"deleted_at\":null,\"ip_whitelist\":null,\"remark\":\"\"}', 400, 2, '{\"request_id\":\"457f187d-dda0-47eb-9e93-fabdb390f7a8\",\"path\":\"\\/admin\\/tenant\\/tenant_user\\/undefined\",\"success\":false,\"code\":100400,\"message\":\"Input :parameter must be of type :exceptType, :actualType given\"}', 1, '457f187d-dda0-47eb-9e93-fabdb390f7a8', 0);
INSERT INTO `user_operation_log` VALUES (205, 'admin', 'PUT', '/admin/tenant/tenant_user/undefined', '编辑租户成员', '172.17.0.1', '2025-06-27 02:25:27', '2025-06-27 02:25:27', NULL, '{\"user_id\":29,\"tenant_id\":\"000000\",\"username\":\"ss\",\"password\":\"\",\"phone\":\"ss\",\"avatar\":\"\",\"last_login_ip\":\"\",\"last_login_time\":null,\"status\":false,\"is_enabled_google\":1,\"google_secret\":\"\",\"is_bind_google\":2,\"created_by\":1,\"created_at\":\"2025-06-26 20:42:57\",\"updated_by\":0,\"updated_at\":\"2025-06-26 20:42:57\",\"deleted_by\":0,\"deleted_at\":null,\"ip_whitelist\":null,\"remark\":\"\"}', 400, 2, '{\"request_id\":\"eeb4b2f7-1982-4b05-ba42-bd5a5630db77\",\"path\":\"\\/admin\\/tenant\\/tenant_user\\/undefined\",\"success\":false,\"code\":100400,\"message\":\"Input :parameter must be of type :exceptType, :actualType given\"}', 1, 'eeb4b2f7-1982-4b05-ba42-bd5a5630db77', 0);
INSERT INTO `user_operation_log` VALUES (206, 'admin', 'PUT', '/admin/tenant/tenant_user/undefined', '编辑租户成员', '172.17.0.1', '2025-06-27 02:26:52', '2025-06-27 02:26:52', NULL, '{\"user_id\":29,\"tenant_id\":\"000000\",\"username\":\"ss\",\"password\":\"\",\"phone\":\"ss\",\"avatar\":\"\",\"last_login_ip\":\"\",\"last_login_time\":null,\"status\":false,\"is_enabled_google\":1,\"google_secret\":\"\",\"is_bind_google\":2,\"created_by\":1,\"created_at\":\"2025-06-26 20:42:57\",\"updated_by\":0,\"updated_at\":\"2025-06-26 20:42:57\",\"deleted_by\":0,\"deleted_at\":null,\"ip_whitelist\":null,\"remark\":\"\"}', 400, 2, '{\"request_id\":\"c893d807-f277-4a5d-9cbe-f91712fbd91a\",\"path\":\"\\/admin\\/tenant\\/tenant_user\\/undefined\",\"success\":false,\"code\":100400,\"message\":\"Input :parameter must be of type :exceptType, :actualType given\"}', 1, 'c893d807-f277-4a5d-9cbe-f91712fbd91a', 0);
INSERT INTO `user_operation_log` VALUES (207, 'admin', 'PUT', '/admin/tenant/tenant_user/29', '编辑租户成员', '172.17.0.1', '2025-06-27 02:27:20', '2025-06-27 02:27:20', NULL, '{\"user_id\":29,\"tenant_id\":\"000000\",\"username\":\"ss\",\"password\":\"\",\"phone\":\"ss\",\"avatar\":\"\",\"last_login_ip\":\"\",\"last_login_time\":null,\"status\":false,\"is_enabled_google\":1,\"google_secret\":\"\",\"is_bind_google\":2,\"created_by\":1,\"created_at\":\"2025-06-26 20:42:57\",\"updated_by\":0,\"updated_at\":\"2025-06-26 20:42:57\",\"deleted_by\":0,\"deleted_at\":null,\"ip_whitelist\":null,\"remark\":\"\"}', 422, 2, '{\"request_id\":\"d84f4ae5-ac0e-41d2-9ae3-b375efcc4ecc\",\"path\":\"\\/admin\\/tenant\\/tenant_user\\/29\",\"success\":false,\"code\":100422,\"message\":\"status \\u5fc5\\u987b\\u662f\\u6574\\u6570\\u3002\"}', 1, 'd84f4ae5-ac0e-41d2-9ae3-b375efcc4ecc', 79);
INSERT INTO `user_operation_log` VALUES (208, 'admin', 'PUT', '/admin/tenant/tenant_user/29', '编辑租户成员', '172.17.0.1', '2025-06-27 02:27:25', '2025-06-27 02:27:25', NULL, '{\"user_id\":29,\"tenant_id\":\"000000\",\"username\":\"ss\",\"password\":\"\",\"phone\":\"ss\",\"avatar\":\"\",\"last_login_ip\":\"\",\"last_login_time\":null,\"status\":true,\"is_enabled_google\":1,\"google_secret\":\"\",\"is_bind_google\":2,\"created_by\":1,\"created_at\":\"2025-06-26 20:42:57\",\"updated_by\":0,\"updated_at\":\"2025-06-26 20:42:57\",\"deleted_by\":0,\"deleted_at\":null,\"ip_whitelist\":null,\"remark\":\"\"}', 200, 1, '{\"request_id\":\"acf51c19-c229-4401-8d88-bec777c7e326\",\"path\":\"\\/admin\\/tenant\\/tenant_user\\/29\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\"}', 1, 'acf51c19-c229-4401-8d88-bec777c7e326', 762);
INSERT INTO `user_operation_log` VALUES (209, 'admin', 'PUT', '/admin/tenant/tenant_user/29', '编辑租户成员', '172.17.0.1', '2025-06-27 02:27:45', '2025-06-27 02:27:45', NULL, '{\"user_id\":29,\"tenant_id\":\"000000\",\"username\":\"ss\",\"password\":\"\",\"phone\":\"ss\",\"avatar\":\"\",\"last_login_ip\":\"\",\"last_login_time\":null,\"status\":true,\"is_enabled_google\":1,\"google_secret\":\"\",\"is_bind_google\":2,\"created_by\":1,\"created_at\":\"2025-06-26 20:42:57\",\"updated_by\":1,\"updated_at\":\"2025-06-27 02:27:24\",\"deleted_by\":0,\"deleted_at\":null,\"ip_whitelist\":null,\"remark\":\"\"}', 200, 1, '{\"request_id\":\"74c256c7-bf02-42b9-b544-b411be942920\",\"path\":\"\\/admin\\/tenant\\/tenant_user\\/29\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\"}', 1, '74c256c7-bf02-42b9-b544-b411be942920', 397);
INSERT INTO `user_operation_log` VALUES (210, 'admin', 'PUT', '/admin/tenant/tenant_user/29', '编辑租户成员', '172.17.0.1', '2025-06-27 02:29:39', '2025-06-27 02:29:39', NULL, '{\"user_id\":29,\"tenant_id\":\"000000\",\"username\":\"ss\",\"password\":\"\",\"phone\":\"ss\",\"avatar\":\"\",\"last_login_ip\":\"\",\"last_login_time\":null,\"status\":false,\"is_enabled_google\":true,\"google_secret\":\"\",\"is_bind_google\":true,\"created_by\":1,\"created_at\":\"2025-06-26 20:42:57\",\"updated_by\":1,\"updated_at\":\"2025-06-27 02:27:24\",\"deleted_by\":0,\"deleted_at\":null,\"ip_whitelist\":null,\"remark\":\"\"}', 422, 2, '{\"request_id\":\"d4bb4466-ad46-44df-8a4b-4a3bfc6f4f54\",\"path\":\"\\/admin\\/tenant\\/tenant_user\\/29\",\"success\":false,\"code\":100422,\"message\":\"status \\u5fc5\\u987b\\u662f\\u6574\\u6570\\u3002\"}', 1, 'd4bb4466-ad46-44df-8a4b-4a3bfc6f4f54', 344);
INSERT INTO `user_operation_log` VALUES (211, 'admin', 'PUT', '/admin/tenant/tenant_user/29', '编辑租户成员', '172.17.0.1', '2025-06-27 02:29:55', '2025-06-27 02:29:55', NULL, '{\"user_id\":29,\"tenant_id\":\"000000\",\"username\":\"ss\",\"password\":\"\",\"phone\":\"ss\",\"avatar\":\"\",\"last_login_ip\":\"\",\"last_login_time\":null,\"status\":false,\"is_enabled_google\":true,\"google_secret\":\"\",\"is_bind_google\":true,\"created_by\":1,\"created_at\":\"2025-06-26 20:42:57\",\"updated_by\":1,\"updated_at\":\"2025-06-27 02:27:24\",\"deleted_by\":0,\"deleted_at\":null,\"ip_whitelist\":null,\"remark\":\"\"}', 422, 2, '{\"request_id\":\"b4c6735c-08c8-4406-8b51-fc8ca16a0ccf\",\"path\":\"\\/admin\\/tenant\\/tenant_user\\/29\",\"success\":false,\"code\":100422,\"message\":\"status \\u5fc5\\u987b\\u662f\\u6574\\u6570\\u3002\"}', 1, 'b4c6735c-08c8-4406-8b51-fc8ca16a0ccf', 87);
INSERT INTO `user_operation_log` VALUES (212, 'admin', 'PUT', '/admin/tenant/tenant_user/29', '编辑租户成员', '172.17.0.1', '2025-06-27 02:31:36', '2025-06-27 02:31:36', NULL, '{\"user_id\":29,\"tenant_id\":\"000000\",\"username\":\"ss\",\"password\":\"\",\"phone\":\"ss\",\"avatar\":\"\",\"last_login_ip\":\"\",\"last_login_time\":null,\"status\":false,\"is_enabled_google\":true,\"google_secret\":\"\",\"is_bind_google\":true,\"created_by\":1,\"created_at\":\"2025-06-26 20:42:57\",\"updated_by\":1,\"updated_at\":\"2025-06-27 02:27:24\",\"deleted_by\":0,\"deleted_at\":null,\"ip_whitelist\":null,\"remark\":\"\"}', 200, 1, '{\"request_id\":\"c69d5252-58b0-41c4-8ed8-c76a6db88b19\",\"path\":\"\\/admin\\/tenant\\/tenant_user\\/29\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\"}', 1, 'c69d5252-58b0-41c4-8ed8-c76a6db88b19', 1195);
INSERT INTO `user_operation_log` VALUES (213, 'admin', 'PUT', '/admin/tenant/tenant_user/29', '编辑租户成员', '172.17.0.1', '2025-06-27 02:31:53', '2025-06-27 02:31:53', NULL, '{\"user_id\":29,\"tenant_id\":\"000000\",\"username\":\"ss\",\"password\":\"\",\"phone\":\"ss\",\"avatar\":\"\",\"last_login_ip\":\"\",\"last_login_time\":null,\"status\":true,\"is_enabled_google\":true,\"google_secret\":\"\",\"is_bind_google\":true,\"created_by\":1,\"created_at\":\"2025-06-26 20:42:57\",\"updated_by\":1,\"updated_at\":\"2025-06-27 02:31:35\",\"deleted_by\":0,\"deleted_at\":null,\"ip_whitelist\":null,\"remark\":\"\"}', 200, 1, '{\"request_id\":\"1f65c7b1-0e38-48dd-9f2a-ebb85619685d\",\"path\":\"\\/admin\\/tenant\\/tenant_user\\/29\",\"success\":true,\"code\":200,\"message\":\"\\u6210\\u529f\"}', 1, '1f65c7b1-0e38-48dd-9f2a-ebb85619685d', 777);

-- ----------------------------
-- Table structure for user_position
-- ----------------------------
DROP TABLE IF EXISTS `user_position`;
CREATE TABLE `user_position`  (
  `user_id` bigint(20) NOT NULL,
  `position_id` bigint(20) NOT NULL,
  `created_at` datetime NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = '用户-岗位关联表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of user_position
-- ----------------------------

SET FOREIGN_KEY_CHECKS = 1;
