/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 100130
Source Host           : localhost:3306
Source Database       : bhbe_db

Target Server Type    : MYSQL
Target Server Version : 100130
File Encoding         : 65001

Date: 2018-10-23 21:45:18
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for accessibility
-- ----------------------------
DROP TABLE IF EXISTS `accessibility`;
CREATE TABLE `accessibility` (
  `access_id` int(11) NOT NULL AUTO_INCREMENT,
  `access_list_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`access_id`),
  KEY `fk_accessibility_users_1` (`user_id`),
  KEY `fk_accessibility_accessibility_list_1` (`access_list_id`),
  CONSTRAINT `fk_accessibility_accessibility_list_1` FOREIGN KEY (`access_list_id`) REFERENCES `accessibility_list` (`access_list_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_accessibility_users_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of accessibility
-- ----------------------------
INSERT INTO `accessibility` VALUES ('8', '1', '1');
INSERT INTO `accessibility` VALUES ('9', '2', '1');
INSERT INTO `accessibility` VALUES ('10', '3', '1');
INSERT INTO `accessibility` VALUES ('11', '4', '1');
INSERT INTO `accessibility` VALUES ('12', '5', '1');
INSERT INTO `accessibility` VALUES ('13', '6', '1');
INSERT INTO `accessibility` VALUES ('14', '7', '1');
INSERT INTO `accessibility` VALUES ('16', '8', '3');
INSERT INTO `accessibility` VALUES ('17', '1', '4');
INSERT INTO `accessibility` VALUES ('18', '2', '4');
INSERT INTO `accessibility` VALUES ('19', '3', '4');
INSERT INTO `accessibility` VALUES ('20', '4', '4');
INSERT INTO `accessibility` VALUES ('35', '1', '7');
INSERT INTO `accessibility` VALUES ('36', '2', '7');
INSERT INTO `accessibility` VALUES ('37', '3', '7');
INSERT INTO `accessibility` VALUES ('38', '4', '7');
INSERT INTO `accessibility` VALUES ('39', '5', '7');
INSERT INTO `accessibility` VALUES ('40', '6', '7');
INSERT INTO `accessibility` VALUES ('41', '7', '7');

-- ----------------------------
-- Table structure for accessibility_list
-- ----------------------------
DROP TABLE IF EXISTS `accessibility_list`;
CREATE TABLE `accessibility_list` (
  `access_list_id` int(11) NOT NULL,
  `access_list_portal` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`access_list_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of accessibility_list
-- ----------------------------
INSERT INTO `accessibility_list` VALUES ('1', 'supplier');
INSERT INTO `accessibility_list` VALUES ('2', 'product');
INSERT INTO `accessibility_list` VALUES ('3', 'orders');
INSERT INTO `accessibility_list` VALUES ('4', 'customer');
INSERT INTO `accessibility_list` VALUES ('5', 'reports');
INSERT INTO `accessibility_list` VALUES ('6', 'settings');
INSERT INTO `accessibility_list` VALUES ('7', 'employee');
INSERT INTO `accessibility_list` VALUES ('8', '(POS) Point of Sale');

-- ----------------------------
-- Table structure for accessibility_list_sub
-- ----------------------------
DROP TABLE IF EXISTS `accessibility_list_sub`;
CREATE TABLE `accessibility_list_sub` (
  `access_list_id` int(11) DEFAULT NULL,
  `access_sub_portal` varchar(255) DEFAULT NULL,
  KEY `access_list_id` (`access_list_id`),
  CONSTRAINT `accessibility_list_sub_ibfk_1` FOREIGN KEY (`access_list_id`) REFERENCES `accessibility_list` (`access_list_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of accessibility_list_sub
-- ----------------------------
INSERT INTO `accessibility_list_sub` VALUES ('1', 'add_supplier');
INSERT INTO `accessibility_list_sub` VALUES ('1', 'manage_supplier');
INSERT INTO `accessibility_list_sub` VALUES ('2', 'add_product');
INSERT INTO `accessibility_list_sub` VALUES ('2', 'manage_product');
INSERT INTO `accessibility_list_sub` VALUES ('2', 'damage_product');
INSERT INTO `accessibility_list_sub` VALUES ('2', 'category');
INSERT INTO `accessibility_list_sub` VALUES ('3', 'new_order');
INSERT INTO `accessibility_list_sub` VALUES ('3', 'manage_order');
INSERT INTO `accessibility_list_sub` VALUES ('3', 'manage_invoice_order');
INSERT INTO `accessibility_list_sub` VALUES ('4', 'new_customer');
INSERT INTO `accessibility_list_sub` VALUES ('4', 'manage_customer');
INSERT INTO `accessibility_list_sub` VALUES ('5', 'invoice_order');
INSERT INTO `accessibility_list_sub` VALUES ('5', 'sales_report');
INSERT INTO `accessibility_list_sub` VALUES ('5', 'purchase_order');
INSERT INTO `accessibility_list_sub` VALUES ('5', 'sales_summary_report');
INSERT INTO `accessibility_list_sub` VALUES ('7', 'add_employee');
INSERT INTO `accessibility_list_sub` VALUES ('7', 'manage_employee');
INSERT INTO `accessibility_list_sub` VALUES ('7', 'manage_logs');
INSERT INTO `accessibility_list_sub` VALUES ('6', 'business_profile');
INSERT INTO `accessibility_list_sub` VALUES ('1', 'new_invoice');
INSERT INTO `accessibility_list_sub` VALUES ('1', 'manage_invoice');
INSERT INTO `accessibility_list_sub` VALUES ('5', 'stocks_report');
INSERT INTO `accessibility_list_sub` VALUES ('6', 'control_panel');

-- ----------------------------
-- Table structure for back_up_file
-- ----------------------------
DROP TABLE IF EXISTS `back_up_file`;
CREATE TABLE `back_up_file` (
  `back_id` int(11) NOT NULL,
  `back_name` varchar(255) DEFAULT NULL,
  `back_type` varchar(255) DEFAULT NULL,
  `back_date` datetime DEFAULT NULL,
  PRIMARY KEY (`back_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of back_up_file
-- ----------------------------

-- ----------------------------
-- Table structure for barcode
-- ----------------------------
DROP TABLE IF EXISTS `barcode`;
CREATE TABLE `barcode` (
  `barcode_id` int(11) NOT NULL AUTO_INCREMENT,
  `barcode` varchar(255) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`barcode_id`),
  KEY `fk_barcode_product_1` (`product_id`),
  CONSTRAINT `fk_barcode_product_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of barcode
-- ----------------------------
INSERT INTO `barcode` VALUES ('60', '123456', '73');
INSERT INTO `barcode` VALUES ('61', '2512521', '74');
INSERT INTO `barcode` VALUES ('62', '362547', '75');
INSERT INTO `barcode` VALUES ('63', '3655214', '76');
INSERT INTO `barcode` VALUES ('64', '3658256', '77');
INSERT INTO `barcode` VALUES ('65', '9658563', '78');
INSERT INTO `barcode` VALUES ('66', '6586485', '79');
INSERT INTO `barcode` VALUES ('67', '5684741', '80');

-- ----------------------------
-- Table structure for cash_type
-- ----------------------------
DROP TABLE IF EXISTS `cash_type`;
CREATE TABLE `cash_type` (
  `cash_id` int(11) NOT NULL AUTO_INCREMENT,
  `cast_type` varchar(255) DEFAULT NULL,
  `cash_amount` varchar(255) DEFAULT NULL,
  `cash_date` datetime DEFAULT NULL,
  `cash_desc` text,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`cash_id`),
  KEY `fk_cash_type_users_1` (`user_id`),
  CONSTRAINT `fk_cash_type_users_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of cash_type
-- ----------------------------

-- ----------------------------
-- Table structure for company
-- ----------------------------
DROP TABLE IF EXISTS `company`;
CREATE TABLE `company` (
  `comp_id` int(11) NOT NULL AUTO_INCREMENT,
  `comp_name` varchar(255) DEFAULT NULL,
  `comp_abbr` varchar(255) DEFAULT NULL,
  `comp_email` varchar(255) DEFAULT NULL,
  `comp_address` text,
  `comp_start_date` date DEFAULT NULL,
  `comp_phone` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`comp_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of company
-- ----------------------------
INSERT INTO `company` VALUES ('1', 'sample inventory', 'S-INV', 'bhbe@gmail.com', 'San Vicente Butuan City\r\n', '2016-11-26', '241-256-53');

-- ----------------------------
-- Table structure for customer
-- ----------------------------
DROP TABLE IF EXISTS `customer`;
CREATE TABLE `customer` (
  `custom_id` int(11) NOT NULL AUTO_INCREMENT,
  `custom_no` text,
  `custom_firstname` varchar(255) DEFAULT NULL,
  `custom_email` varchar(120) DEFAULT NULL,
  `custom_phone` varchar(120) DEFAULT NULL,
  `custom_lastname` varchar(255) DEFAULT NULL,
  `custom_address` varchar(255) DEFAULT NULL,
  `custom_discount` varchar(10) DEFAULT NULL,
  `custom_birthdate` date DEFAULT NULL,
  `register_date` datetime DEFAULT NULL,
  PRIMARY KEY (`custom_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of customer
-- ----------------------------
INSERT INTO `customer` VALUES ('1', 'CTN-04-17-0001', 'Leron', 'james@gmail.com', '09103032120', 'James', 'Ohio USA', '12%', '2017-04-27', '2017-04-16 12:04:11');
INSERT INTO `customer` VALUES ('3', 'CTN-04-17-0002', 'Steve', 'nash@gmail.com', '3425065', 'Nash', 'Canada Totonto\r\n', null, '2017-04-24', '2017-04-24 16:04:35');

-- ----------------------------
-- Table structure for notifications
-- ----------------------------
DROP TABLE IF EXISTS `notifications`;
CREATE TABLE `notifications` (
  `noti_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) DEFAULT NULL,
  `noti_remarks` varchar(255) DEFAULT NULL,
  `pur_id` int(11) DEFAULT NULL,
  `noti_status` varchar(255) DEFAULT NULL,
  `noti_date` date DEFAULT NULL,
  `noti_time` time DEFAULT NULL,
  PRIMARY KEY (`noti_id`),
  KEY `order_id` (`order_id`),
  KEY `pur_id` (`pur_id`),
  CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `notifications_ibfk_2` FOREIGN KEY (`pur_id`) REFERENCES `purchased` (`pur_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of notifications
-- ----------------------------
INSERT INTO `notifications` VALUES ('1', '1', null, null, 'unread', '2017-06-01', '13:06:50');
INSERT INTO `notifications` VALUES ('2', '2', null, null, 'unread', '2017-06-01', '17:06:08');
INSERT INTO `notifications` VALUES ('3', '3', null, null, 'unread', '2018-10-23', '21:10:31');

-- ----------------------------
-- Table structure for orders
-- ----------------------------
DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_no` varchar(255) DEFAULT NULL,
  `order_date` date DEFAULT NULL,
  `order_payment_type` varchar(100) DEFAULT NULL,
  `order_reference` varchar(100) DEFAULT NULL,
  `order_status` varchar(100) DEFAULT NULL,
  `order_payment_status` varchar(100) DEFAULT NULL,
  `order_cheque_no` varchar(100) DEFAULT NULL,
  `order_bill` varchar(100) DEFAULT NULL,
  `order_pay_date` date DEFAULT NULL,
  `order_pay_amount` varchar(100) DEFAULT NULL,
  `order_discount` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `custom_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`order_id`),
  KEY `fk_order_supplier_1` (`supplier_id`),
  KEY `fk_order_users_1` (`user_id`),
  KEY `custom_id` (`custom_id`),
  CONSTRAINT `fk_order_users_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`custom_id`) REFERENCES `customer` (`custom_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of orders
-- ----------------------------
INSERT INTO `orders` VALUES ('1', 'ORD00001', '2017-06-01', null, '32', 'confirm', 'paid', null, '300', null, null, '0', '1', null, '3');
INSERT INTO `orders` VALUES ('2', 'ORD00001', '2017-06-01', null, '213', 'confirm', 'paid', null, '155', null, null, '0', '1', null, '3');
INSERT INTO `orders` VALUES ('3', 'ORD00002', '2018-10-23', null, '123', 'confirm', 'paid', null, '25', null, null, '3', '1', null, '1');

-- ----------------------------
-- Table structure for order_details
-- ----------------------------
DROP TABLE IF EXISTS `order_details`;
CREATE TABLE `order_details` (
  `details_id` int(11) NOT NULL AUTO_INCREMENT,
  `details_order_id` int(11) DEFAULT NULL,
  `details_order_name` varchar(255) DEFAULT NULL,
  `details_order_type` varchar(120) DEFAULT NULL,
  `details_order_quantity` varchar(255) DEFAULT NULL,
  `details_order_price` varchar(10) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`details_id`),
  KEY `fk_order_details_order_1` (`details_order_id`),
  KEY `fk_order_details_product_1` (`product_id`),
  CONSTRAINT `fk_order_details_order_1` FOREIGN KEY (`details_order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_order_details_product_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of order_details
-- ----------------------------
INSERT INTO `order_details` VALUES ('1', '1', null, 'pcs', '1', '300', '74');
INSERT INTO `order_details` VALUES ('2', '2', null, 'pcs', '1', '125', '75');
INSERT INTO `order_details` VALUES ('3', '2', null, 'pcs', '1', '30', '78');
INSERT INTO `order_details` VALUES ('4', '3', null, 'pcs', '1', '25', '73');

-- ----------------------------
-- Table structure for payment
-- ----------------------------
DROP TABLE IF EXISTS `payment`;
CREATE TABLE `payment` (
  `payment_id` int(11) NOT NULL AUTO_INCREMENT,
  `payment_amount` decimal(10,0) DEFAULT NULL,
  `payment_date` datetime DEFAULT NULL,
  `payment_type` varchar(255) DEFAULT NULL,
  `payment_desc` text,
  `payment_status` varchar(255) DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`payment_id`),
  KEY `fk_payment_users_1` (`user_id`),
  KEY `supplier_id` (`supplier_id`),
  CONSTRAINT `fk_payment_users_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`supplier_id`) REFERENCES `supplier` (`supplier_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of payment
-- ----------------------------

-- ----------------------------
-- Table structure for payment_purchased
-- ----------------------------
DROP TABLE IF EXISTS `payment_purchased`;
CREATE TABLE `payment_purchased` (
  `pp_id` int(11) NOT NULL AUTO_INCREMENT,
  `pay_pur_date` date DEFAULT NULL,
  `pay_amount` varchar(255) DEFAULT NULL,
  `pur_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`pp_id`),
  KEY `pur_id` (`pur_id`),
  CONSTRAINT `payment_purchased_ibfk_1` FOREIGN KEY (`pur_id`) REFERENCES `purchased` (`pur_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of payment_purchased
-- ----------------------------

-- ----------------------------
-- Table structure for personnel
-- ----------------------------
DROP TABLE IF EXISTS `personnel`;
CREATE TABLE `personnel` (
  `person_id` int(11) NOT NULL AUTO_INCREMENT,
  `person_no` varchar(255) DEFAULT NULL,
  `person_first` varchar(255) DEFAULT NULL,
  `person_middle` varchar(255) DEFAULT NULL,
  `person_last` varchar(255) DEFAULT NULL,
  `person_address` varchar(255) DEFAULT NULL,
  `person_birthdate` date DEFAULT NULL,
  `person_position` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`person_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of personnel
-- ----------------------------
INSERT INTO `personnel` VALUES ('1', 'admin', 'admin', 'admin', 'Unknown', '2016-09-21', '2016-10-26', 'accounting officer');
INSERT INTO `personnel` VALUES ('12', 'EMP-0002', 'cashier', 'cashier', 'cashier', 'address', '2017-04-08', 'cashier officer');
INSERT INTO `personnel` VALUES ('13', 'EMP-0013', 'staff1', 'staff1', 'staff1', 'staff1', '2017-04-24', 'staff officer');
INSERT INTO `personnel` VALUES ('14', 'EMP-0014', 'admin1', 'admin1', 'admin1', 'qw', '2016-02-16', 'qweww');
INSERT INTO `personnel` VALUES ('15', 'EMP-0015', 'sample', 'sample', 'sample', 'sample', '2018-10-23', 'asaaa');
INSERT INTO `personnel` VALUES ('16', 'EMP-0016', 'sample', 'sample', 'sample', 'sample', '2018-10-23', 'sample');

-- ----------------------------
-- Table structure for product
-- ----------------------------
DROP TABLE IF EXISTS `product`;
CREATE TABLE `product` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_code` varchar(255) DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `product_subname` varchar(255) DEFAULT NULL,
  `product_desc` text,
  `product_size` double DEFAULT NULL,
  `product_width` double DEFAULT NULL,
  `product_insert_date` date DEFAULT NULL,
  `brand_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`product_id`),
  KEY `fk_product_product_brand_1` (`brand_id`),
  CONSTRAINT `fk_product_product_brand_1` FOREIGN KEY (`brand_id`) REFERENCES `product_brand` (`brand_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=83 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of product
-- ----------------------------
INSERT INTO `product` VALUES ('73', null, 'iphone 6s', '32gb', 'What is Lorem Ipsum?\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum', null, null, '2017-05-24', '50');
INSERT INTO `product` VALUES ('74', null, 'samsumg galaxy', 's8 64 gb', 'What is Lorem Ipsum?\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum', null, null, '2017-05-24', '51');
INSERT INTO `product` VALUES ('75', null, 'teste', 'test', '', null, null, '2017-05-24', '48');
INSERT INTO `product` VALUES ('76', null, 'test1', 'test1', 'qwe', null, null, '2017-05-26', '48');
INSERT INTO `product` VALUES ('77', null, 'test2', 'test2', '1231', null, null, '2017-05-26', '51');
INSERT INTO `product` VALUES ('78', null, 'test3', 'test3', 'asdasd', null, null, '2017-05-26', '47');
INSERT INTO `product` VALUES ('79', null, 'test4', 'test4', 'asd', null, null, '2017-05-26', '49');
INSERT INTO `product` VALUES ('80', null, 'test5', 'test5', 'asd', null, null, '2017-05-26', '49');
INSERT INTO `product` VALUES ('81', null, 'iphone 6s', '32gb', 'qwe', null, null, '2017-05-26', '50');
INSERT INTO `product` VALUES ('82', null, 'samsumg galaxy', 's8 64 gb', 'asds', null, null, '2017-05-31', '51');

-- ----------------------------
-- Table structure for product_brand
-- ----------------------------
DROP TABLE IF EXISTS `product_brand`;
CREATE TABLE `product_brand` (
  `brand_id` int(11) NOT NULL AUTO_INCREMENT,
  `brand_name` varchar(255) DEFAULT NULL,
  `brand_desc` text,
  `type_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`brand_id`),
  KEY `fk_product_brand_product_type_1` (`type_id`),
  CONSTRAINT `fk_product_brand_product_type_1` FOREIGN KEY (`type_id`) REFERENCES `product_type` (`type_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of product_brand
-- ----------------------------
INSERT INTO `product_brand` VALUES ('47', 'jag', null, '30');
INSERT INTO `product_brand` VALUES ('48', 'Bench', null, '30');
INSERT INTO `product_brand` VALUES ('49', 'RRJ', null, '29');
INSERT INTO `product_brand` VALUES ('50', 'apple', null, '31');
INSERT INTO `product_brand` VALUES ('51', 'samsung', null, '31');

-- ----------------------------
-- Table structure for product_damage
-- ----------------------------
DROP TABLE IF EXISTS `product_damage`;
CREATE TABLE `product_damage` (
  `damage_id` int(11) NOT NULL AUTO_INCREMENT,
  `barcode_id` int(11) DEFAULT NULL,
  `damage_date` date DEFAULT NULL,
  `damage_quantity` varchar(120) DEFAULT NULL,
  `damage_quantity_type` varchar(120) DEFAULT NULL,
  `damage_note` text,
  `damage_decrease` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`damage_id`),
  KEY `barcode_id` (`barcode_id`),
  CONSTRAINT `product_damage_ibfk_1` FOREIGN KEY (`barcode_id`) REFERENCES `barcode` (`barcode_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of product_damage
-- ----------------------------

-- ----------------------------
-- Table structure for product_stockin
-- ----------------------------
DROP TABLE IF EXISTS `product_stockin`;
CREATE TABLE `product_stockin` (
  `stockin_id` int(11) NOT NULL AUTO_INCREMENT,
  `stockin_no` varchar(40) DEFAULT NULL,
  `stockin_quantity` decimal(20,0) DEFAULT NULL,
  `stockin_quantity_type` varchar(120) DEFAULT NULL,
  `stockin_selling_quantity` varchar(255) DEFAULT NULL,
  `stockin_status` varchar(255) DEFAULT NULL,
  `stockin_date` date DEFAULT NULL,
  `stockin_buying_price` varchar(255) DEFAULT NULL,
  `stockin_selling_price` varchar(255) DEFAULT NULL,
  `stockin_desc` text,
  `stockin_quantity_per` varchar(255) DEFAULT NULL,
  `stockin_selling_type` varchar(255) DEFAULT NULL,
  `barcode_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`stockin_id`),
  KEY `fk_product_stockin_barcode_1` (`barcode_id`),
  CONSTRAINT `fk_product_stockin_barcode_1` FOREIGN KEY (`barcode_id`) REFERENCES `barcode` (`barcode_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of product_stockin
-- ----------------------------
INSERT INTO `product_stockin` VALUES ('31', '', '10', 'pcs', '10', 'in stocks', '2017-05-24', '120', '150', null, null, 'pcs', '60');
INSERT INTO `product_stockin` VALUES ('32', 'STN00073', '100', 'pcs', '100', 'in stocks', '2017-05-24', '125', '135', null, null, 'pcs', '61');
INSERT INTO `product_stockin` VALUES ('33', 'STN00074', '10', 'box', '240', 'in stocks', '2017-05-24', '120', '125', null, '24', 'pcs', '62');
INSERT INTO `product_stockin` VALUES ('34', 'STN00075', '22', 'pcs', '22', 'in stocks', '2017-05-26', '20', '25', null, null, 'pcs', '63');
INSERT INTO `product_stockin` VALUES ('35', 'STN00076', '12', 'pcs', '12', 'in stocks', '2017-05-26', '250', '260', null, null, 'pcs', '64');
INSERT INTO `product_stockin` VALUES ('36', 'STN00077', '10', 'pcs', '52', 'in stocks', '2017-05-26', '25', '30', null, null, 'pcs', '65');
INSERT INTO `product_stockin` VALUES ('37', 'STN00078', '10', 'pcs', '10', 'in stocks', '2017-05-26', '23', '26', null, null, 'pcs', '66');
INSERT INTO `product_stockin` VALUES ('38', 'STN00079', '262', 'pcs', '230', 'in stocks', '2017-05-26', '30', '35', null, null, 'pcs', '67');
INSERT INTO `product_stockin` VALUES ('39', 'STN00080', '40', 'pcs', '40', 'in stocks', '2017-05-26', '250', '25', null, null, 'pcs', '60');
INSERT INTO `product_stockin` VALUES ('40', 'STN00081', '100', 'box', '1000', 'in stocks', '2017-05-31', '250', '300', null, '10', 'pcs', '61');

-- ----------------------------
-- Table structure for product_type
-- ----------------------------
DROP TABLE IF EXISTS `product_type`;
CREATE TABLE `product_type` (
  `type_id` int(11) NOT NULL AUTO_INCREMENT,
  `type_name` varchar(255) DEFAULT NULL,
  `type_desc` text,
  PRIMARY KEY (`type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of product_type
-- ----------------------------
INSERT INTO `product_type` VALUES ('29', 'kitchenware', null);
INSERT INTO `product_type` VALUES ('30', 'linen', null);
INSERT INTO `product_type` VALUES ('31', 'smartphone', null);

-- ----------------------------
-- Table structure for purchased
-- ----------------------------
DROP TABLE IF EXISTS `purchased`;
CREATE TABLE `purchased` (
  `pur_id` int(11) NOT NULL AUTO_INCREMENT,
  `purchase_no` varchar(255) DEFAULT NULL,
  `purchase_date` date DEFAULT NULL,
  `purchase_payment_type` varchar(255) DEFAULT NULL,
  `purchase_total_amount` varchar(255) DEFAULT NULL,
  `purchase_payment_status` varchar(255) DEFAULT NULL,
  `purchase_reference` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`pur_id`),
  KEY `supplier_id` (`supplier_id`),
  KEY `purchased_ibfk_2` (`user_id`),
  CONSTRAINT `purchased_ibfk_1` FOREIGN KEY (`supplier_id`) REFERENCES `supplier` (`supplier_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `purchased_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of purchased
-- ----------------------------

-- ----------------------------
-- Table structure for purchased_details
-- ----------------------------
DROP TABLE IF EXISTS `purchased_details`;
CREATE TABLE `purchased_details` (
  `pur_det_id` int(11) NOT NULL AUTO_INCREMENT,
  `pur_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `pur_det_name` varchar(255) DEFAULT NULL,
  `pur_det_type` varchar(255) DEFAULT NULL,
  `pur_det_quantity` varchar(255) DEFAULT NULL,
  `pur_der_price` decimal(10,0) DEFAULT NULL,
  PRIMARY KEY (`pur_det_id`),
  KEY `pur_id` (`pur_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `purchased_details_ibfk_1` FOREIGN KEY (`pur_id`) REFERENCES `purchased` (`pur_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `purchased_details_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of purchased_details
-- ----------------------------

-- ----------------------------
-- Table structure for return_product
-- ----------------------------
DROP TABLE IF EXISTS `return_product`;
CREATE TABLE `return_product` (
  `return_id` int(11) NOT NULL AUTO_INCREMENT,
  `return_quantity` int(11) DEFAULT NULL,
  `return_date` datetime DEFAULT NULL,
  `return_desc` varchar(255) DEFAULT NULL,
  `return_amount` decimal(10,0) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `custom_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`return_id`),
  KEY `fk_return_product_customer_1` (`custom_id`),
  KEY `fk_return_product_product_1` (`product_id`),
  CONSTRAINT `fk_return_product_customer_1` FOREIGN KEY (`custom_id`) REFERENCES `customer` (`custom_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_return_product_product_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of return_product
-- ----------------------------

-- ----------------------------
-- Table structure for sales
-- ----------------------------
DROP TABLE IF EXISTS `sales`;
CREATE TABLE `sales` (
  `sales_id` int(11) NOT NULL AUTO_INCREMENT,
  `sales_quantity` varchar(120) DEFAULT NULL,
  `sales_no` varchar(255) DEFAULT NULL,
  `sales_amount` varchar(120) DEFAULT NULL,
  `sales_quantity_type` varchar(120) DEFAULT NULL,
  `sales_discount` varchar(255) DEFAULT NULL,
  `stock_sum_id` int(11) DEFAULT NULL,
  `invoice_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`sales_id`),
  KEY `invoice_id` (`invoice_id`),
  KEY `stock_sum_id` (`stock_sum_id`),
  CONSTRAINT `sales_ibfk_1` FOREIGN KEY (`invoice_id`) REFERENCES `sales_invoice` (`invoice_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `sales_ibfk_2` FOREIGN KEY (`stock_sum_id`) REFERENCES `stockin_summary` (`stock_sum_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=108 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of sales
-- ----------------------------
INSERT INTO `sales` VALUES ('62', '1', 'SN-000001', null, 'pcs', null, '56', '36');
INSERT INTO `sales` VALUES ('63', '1', 'SN-000062', null, 'pcs', null, '57', '36');
INSERT INTO `sales` VALUES ('64', '1', 'SN-000063', null, 'pcs', null, '55', '37');
INSERT INTO `sales` VALUES ('65', '1', 'SN-000064', null, 'pcs', null, '54', '38');
INSERT INTO `sales` VALUES ('66', '1', null, null, 'pcs', null, '53', '39');
INSERT INTO `sales` VALUES ('67', '1', null, null, 'pcs', null, '54', '40');
INSERT INTO `sales` VALUES ('68', '1', null, null, 'pcs', null, '57', '40');
INSERT INTO `sales` VALUES ('69', '1', 'SN-000068', null, 'pcs', null, '58', '41');
INSERT INTO `sales` VALUES ('70', '1', 'SN-000069', null, 'pcs', null, '59', '41');
INSERT INTO `sales` VALUES ('71', '1', 'SN-000070', null, 'pcs', null, '59', '42');
INSERT INTO `sales` VALUES ('72', '1', 'SN-000071', null, 'pcs', null, '55', '43');
INSERT INTO `sales` VALUES ('73', '1', 'SN-000072', null, 'pcs', null, '56', '44');
INSERT INTO `sales` VALUES ('74', '1', 'SN-000073', null, 'pcs', null, '55', '45');
INSERT INTO `sales` VALUES ('75', '1', 'SN-000074', null, 'pcs', null, '57', '46');
INSERT INTO `sales` VALUES ('77', '1', 'SN-000076', null, 'pcs', null, '56', '47');
INSERT INTO `sales` VALUES ('78', '1', 'SN-000077', null, 'pcs', null, '52', '47');
INSERT INTO `sales` VALUES ('79', '1', 'SN-000078', null, 'pcs', null, '55', '48');
INSERT INTO `sales` VALUES ('81', '1', 'SN-000079', null, 'pcs', null, '58', '49');
INSERT INTO `sales` VALUES ('82', '1', 'SN-000081', null, 'pcs', null, '54', '50');
INSERT INTO `sales` VALUES ('83', '1', 'SN-000082', null, 'pcs', null, '55', '51');
INSERT INTO `sales` VALUES ('84', '3', 'SN-000083', null, 'pcs', null, '57', '51');
INSERT INTO `sales` VALUES ('85', '55', 'SN-000084', null, 'pcs', null, '54', '51');
INSERT INTO `sales` VALUES ('86', '10', 'SN-000085', null, 'pcs', null, '59', '51');
INSERT INTO `sales` VALUES ('87', '1', 'SN-000086', null, 'pcs', null, '55', '52');
INSERT INTO `sales` VALUES ('88', '3', 'SN-000087', null, 'pcs', null, '58', '52');
INSERT INTO `sales` VALUES ('89', '5', 'SN-000088', null, 'pcs', null, '59', '52');
INSERT INTO `sales` VALUES ('90', '1', 'SN-000089', null, 'pcs', null, '59', '53');
INSERT INTO `sales` VALUES ('91', '1', 'SN-000090', null, 'pcs', null, '56', '54');
INSERT INTO `sales` VALUES ('92', '11', 'SN-000091', null, 'pcs', null, '55', '55');
INSERT INTO `sales` VALUES ('93', '5', 'SN-000092', null, 'pcs', null, '54', '55');
INSERT INTO `sales` VALUES ('94', '20', 'SN-000093', null, 'pcs', null, '55', '56');
INSERT INTO `sales` VALUES ('95', '20', 'SN-000094', null, 'pcs', null, '58', '56');
INSERT INTO `sales` VALUES ('96', '20', 'SN-000095', null, 'pcs', null, '54', '56');
INSERT INTO `sales` VALUES ('97', '20', 'SN-000096', null, 'pcs', null, '52', '56');
INSERT INTO `sales` VALUES ('98', '20', 'SN-000097', null, 'pcs', null, '53', '56');
INSERT INTO `sales` VALUES ('99', '20', 'SN-000098', null, 'pcs', null, '57', '56');
INSERT INTO `sales` VALUES ('100', '1', 'SN-000099', null, 'pcs', null, '57', '57');
INSERT INTO `sales` VALUES ('101', '1', 'SN-000100', null, 'pcs', null, '56', '57');
INSERT INTO `sales` VALUES ('102', '1', 'SN-000101', null, 'pcs', null, '55', '57');
INSERT INTO `sales` VALUES ('103', '1', 'SN-000102', null, 'pcs', null, '55', '58');
INSERT INTO `sales` VALUES ('104', '1', 'SN-000103', null, 'pcs', null, '58', '58');
INSERT INTO `sales` VALUES ('105', '1', null, null, 'pcs', null, '52', '59');
INSERT INTO `sales` VALUES ('106', '1', 'SN-000105', null, 'pcs', null, '55', '60');
INSERT INTO `sales` VALUES ('107', '1', 'SN-000106', null, 'pcs', null, '59', '60');

-- ----------------------------
-- Table structure for sales_invoice
-- ----------------------------
DROP TABLE IF EXISTS `sales_invoice`;
CREATE TABLE `sales_invoice` (
  `invoice_id` int(255) NOT NULL AUTO_INCREMENT,
  `invoice_no` varchar(255) DEFAULT NULL,
  `invoice_date` date DEFAULT NULL,
  `invoice_time` time DEFAULT NULL,
  `invoice_total_amount` varchar(255) DEFAULT NULL,
  `invoice_status` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `invoice_input_amount` varchar(255) DEFAULT NULL,
  `invoice_discount` varchar(255) DEFAULT NULL,
  `custom_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`invoice_id`),
  KEY `fk_sales_invoice_users_1` (`user_id`),
  KEY `fk_sales_invoice_customer_1` (`custom_id`),
  CONSTRAINT `fk_sales_invoice_customer_1` FOREIGN KEY (`custom_id`) REFERENCES `customer` (`custom_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_sales_invoice_users_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of sales_invoice
-- ----------------------------
INSERT INTO `sales_invoice` VALUES ('36', 'SIN-0001', '2017-06-01', '12:06:30', '290', 'purchase', '3', '300', '0', null);
INSERT INTO `sales_invoice` VALUES ('37', 'SIN-0036', '2017-06-01', '12:06:46', '25', 'purchase', '3', '30', '0', null);
INSERT INTO `sales_invoice` VALUES ('38', 'SIN-0037', '2017-06-01', '12:06:06', '125', 'purchase', '3', '300', '0', null);
INSERT INTO `sales_invoice` VALUES ('39', 'SIN-0000', '2017-06-01', '13:06:03', '300', 'purchase', '1', '300', '0', '3');
INSERT INTO `sales_invoice` VALUES ('40', 'SIN-0000', '2017-06-01', '17:06:19', '155', 'purchase', '1', '100', '0', '3');
INSERT INTO `sales_invoice` VALUES ('41', 'SIN-0040', '2017-06-02', '10:06:24', '61', 'purchase', '3', '61', '0', null);
INSERT INTO `sales_invoice` VALUES ('42', 'SIN-0041', '2017-06-02', '10:06:58', '35', 'purchase', '3', '35', '0', null);
INSERT INTO `sales_invoice` VALUES ('43', 'SIN-0042', '2017-06-02', '12:06:30', '25', 'purchase', '3', '25', '0', null);
INSERT INTO `sales_invoice` VALUES ('44', 'SIN-0043', '2017-06-02', '12:06:13', '260', 'purchase', '3', '22221', '0', null);
INSERT INTO `sales_invoice` VALUES ('45', 'SIN-0044', '2017-06-02', '12:06:23', '25', 'purchase', '3', '255', '0', null);
INSERT INTO `sales_invoice` VALUES ('46', 'SIN-0045', '2017-06-02', '15:06:54', '30', 'purchase', '3', '300', '0', null);
INSERT INTO `sales_invoice` VALUES ('47', 'SIN-0046', '2017-06-02', '15:06:51', '285', 'purchase', '3', '300', '0', null);
INSERT INTO `sales_invoice` VALUES ('48', 'SIN-0047', '2017-06-02', '15:06:46', '25', 'purchase', '3', '55', '0', null);
INSERT INTO `sales_invoice` VALUES ('49', 'SIN-0048', '2017-06-02', '15:06:34', '26', 'purchase', '3', '26', '0', null);
INSERT INTO `sales_invoice` VALUES ('50', 'SIN-0049', '2017-06-10', '15:06:46', '125', 'purchase', '3', '200', '0', null);
INSERT INTO `sales_invoice` VALUES ('51', 'SIN-0050', '2017-06-10', '15:06:21', '7340', 'purchase', '3', '8000', '0', null);
INSERT INTO `sales_invoice` VALUES ('52', 'SIN-0051', '2017-06-10', '16:06:27', '278', 'purchase', '3', '300', '0', null);
INSERT INTO `sales_invoice` VALUES ('53', 'SIN-0052', '2017-06-10', '16:06:44', '35', 'purchase', '3', '35', '0', null);
INSERT INTO `sales_invoice` VALUES ('54', 'SIN-0053', '2017-06-10', '16:06:31', '260', 'purchase', '3', '300', '0', null);
INSERT INTO `sales_invoice` VALUES ('55', 'SIN-0054', '2017-06-10', '16:06:55', '900', 'purchase', '3', '1000', '0', null);
INSERT INTO `sales_invoice` VALUES ('56', 'SIN-0055', '2017-06-10', '16:06:56', '10620', 'purchase', '3', '10700', '0', null);
INSERT INTO `sales_invoice` VALUES ('57', 'SIN-0056', '2018-10-11', '23:10:23', '315', 'purchase', '3', '400', '0', null);
INSERT INTO `sales_invoice` VALUES ('58', 'SIN-0057', '2018-10-11', '23:10:19', '51', 'purchase', '3', '610', '0', null);
INSERT INTO `sales_invoice` VALUES ('59', 'SIN-0000', '2018-10-23', '21:10:57', '22', 'purchase', '1', '10', '3', '1');
INSERT INTO `sales_invoice` VALUES ('60', 'SIN-0059', '2018-10-23', '21:10:30', '60', 'purchase', '3', '100', '0', null);

-- ----------------------------
-- Table structure for sales_partial
-- ----------------------------
DROP TABLE IF EXISTS `sales_partial`;
CREATE TABLE `sales_partial` (
  `partial_id` int(11) NOT NULL AUTO_INCREMENT,
  `partial_date` date DEFAULT NULL,
  `partial_amount` varchar(255) DEFAULT NULL,
  `invoice_id` int(11) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`partial_id`),
  KEY `invoice_id` (`invoice_id`),
  CONSTRAINT `sales_partial_ibfk_1` FOREIGN KEY (`invoice_id`) REFERENCES `sales_invoice` (`invoice_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of sales_partial
-- ----------------------------
INSERT INTO `sales_partial` VALUES ('1', '2017-06-01', '300', '39', '1');
INSERT INTO `sales_partial` VALUES ('2', '2017-06-01', '100', '40', '2');
INSERT INTO `sales_partial` VALUES ('3', '2017-06-10', '55', '40', '2');
INSERT INTO `sales_partial` VALUES ('4', '2018-10-23', '10', '59', '3');
INSERT INTO `sales_partial` VALUES ('5', '2018-10-23', '12', '59', '3');

-- ----------------------------
-- Table structure for sessions
-- ----------------------------
DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
  `user_id` int(11) NOT NULL DEFAULT '0',
  `user_salt` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  CONSTRAINT `sessions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of sessions
-- ----------------------------

-- ----------------------------
-- Table structure for stockin_summary
-- ----------------------------
DROP TABLE IF EXISTS `stockin_summary`;
CREATE TABLE `stockin_summary` (
  `stock_sum_id` int(11) NOT NULL AUTO_INCREMENT,
  `stockin_sum_quantity` int(11) DEFAULT NULL,
  `stockin_sum_selling_quantity` varchar(255) DEFAULT NULL,
  `stockin_sum_buying_price` varchar(10) DEFAULT NULL,
  `stockin_sum_selling_price` varchar(10) DEFAULT NULL,
  `stockin_sum_status` varchar(40) DEFAULT NULL,
  `stockin_sum_selling_type` varchar(40) DEFAULT NULL,
  `stockin_sum_quantity_per` varchar(255) DEFAULT NULL,
  `stockin_sum_quantity_type` varchar(120) DEFAULT NULL,
  `stockin_sum_date` date DEFAULT NULL,
  `barcode_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`stock_sum_id`),
  KEY `fk_stockin_summary_barcode_1` (`barcode_id`),
  CONSTRAINT `fk_stockin_summary_barcode_1` FOREIGN KEY (`barcode_id`) REFERENCES `barcode` (`barcode_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of stockin_summary
-- ----------------------------
INSERT INTO `stockin_summary` VALUES ('52', '10', '13', '250', '25', 'In Stocks', 'pcs', '0', 'pcs', '2017-05-24', '60');
INSERT INTO `stockin_summary` VALUES ('53', '100', '905', '250', '300', 'In Stocks', 'pcs', '10', 'box', '2017-05-24', '61');
INSERT INTO `stockin_summary` VALUES ('54', '10', '101', '120', '125', 'In Stocks', 'pcs', '24', 'box', '2017-05-24', '62');
INSERT INTO `stockin_summary` VALUES ('55', '22', '83', '20', '25', 'In Stocks', 'pcs', null, 'pcs', '2017-05-26', '63');
INSERT INTO `stockin_summary` VALUES ('56', '12', '51', '250', '260', 'In Stocks', 'pcs', null, 'pcs', '2017-05-26', '64');
INSERT INTO `stockin_summary` VALUES ('57', '52', '52', '25', '30', 'In Stocks', 'pcs', null, 'pcs', '2017-05-26', '65');
INSERT INTO `stockin_summary` VALUES ('58', '10', '17', '23', '26', 'In Stocks', 'pcs', null, 'pcs', '2017-05-26', '66');
INSERT INTO `stockin_summary` VALUES ('59', '230', '229', '30', '35', 'In Stocks', 'pcs', null, 'pcs', '2017-05-26', '67');

-- ----------------------------
-- Table structure for stockout_summary
-- ----------------------------
DROP TABLE IF EXISTS `stockout_summary`;
CREATE TABLE `stockout_summary` (
  `stockout_id` int(11) NOT NULL AUTO_INCREMENT,
  `stockout_quantity` varchar(255) DEFAULT NULL,
  `stockcout_date` date DEFAULT NULL,
  `stockout_quantity_type` varchar(255) DEFAULT NULL,
  `stockout_buying_price` varchar(255) DEFAULT NULL,
  `stockout_selling_price` varchar(255) DEFAULT NULL,
  `stockout_status` varchar(255) DEFAULT NULL,
  `barcode_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`stockout_id`),
  KEY `barcode_id` (`barcode_id`),
  CONSTRAINT `stockout_summary_ibfk_1` FOREIGN KEY (`barcode_id`) REFERENCES `barcode` (`barcode_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=237 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of stockout_summary
-- ----------------------------
INSERT INTO `stockout_summary` VALUES ('30', '2', '2017-05-24', 'pcs', null, '150', 'stockout', '60');
INSERT INTO `stockout_summary` VALUES ('31', '2', '2017-05-24', 'pcs', null, '135', 'stockout', '61');
INSERT INTO `stockout_summary` VALUES ('32', '1', '2017-05-24', 'pcs', null, '150', 'stockout', '60');
INSERT INTO `stockout_summary` VALUES ('33', '1', '2017-05-24', 'pcs', null, '135', 'stockout', '61');
INSERT INTO `stockout_summary` VALUES ('34', '1', '2017-05-24', 'pcs', null, '150', 'stockout', '60');
INSERT INTO `stockout_summary` VALUES ('35', '1', '2017-05-24', 'pcs', null, '135', 'stockout', '61');
INSERT INTO `stockout_summary` VALUES ('36', '1', '2017-05-24', 'pcs', null, '135', 'stockout', '61');
INSERT INTO `stockout_summary` VALUES ('37', '1', '2017-05-24', 'pcs', null, '135', 'stockout', '61');
INSERT INTO `stockout_summary` VALUES ('38', '1', '2017-05-24', 'pcs', null, '135', 'stockout', '61');
INSERT INTO `stockout_summary` VALUES ('39', '1', '2017-05-24', 'pcs', null, '135', 'stockout', '61');
INSERT INTO `stockout_summary` VALUES ('40', '1', '2017-05-24', 'pcs', null, '135', 'stockout', '61');
INSERT INTO `stockout_summary` VALUES ('41', '1', '2017-05-24', 'pcs', null, '135', 'stockout', '61');
INSERT INTO `stockout_summary` VALUES ('42', '1', '2017-05-24', 'pcs', null, '135', 'stockout', '61');
INSERT INTO `stockout_summary` VALUES ('43', '1', '2017-05-24', 'pcs', null, '135', 'stockout', '61');
INSERT INTO `stockout_summary` VALUES ('44', '2', '2017-05-24', 'pcs', null, '125', 'stockout', '62');
INSERT INTO `stockout_summary` VALUES ('45', '2', '2017-05-24', 'pcs', null, '135', 'stockout', '61');
INSERT INTO `stockout_summary` VALUES ('46', '3', '2017-05-24', 'pcs', null, '150', 'stockout', '60');
INSERT INTO `stockout_summary` VALUES ('47', '11', '2017-05-24', 'pcs', null, '125', 'stockout', '62');
INSERT INTO `stockout_summary` VALUES ('48', '21', '2017-05-24', 'pcs', null, '135', 'stockout', '61');
INSERT INTO `stockout_summary` VALUES ('49', '12', '2017-05-24', 'pcs', null, '125', 'stockout', '62');
INSERT INTO `stockout_summary` VALUES ('50', '1', '2017-05-24', 'pcs', null, '135', 'stockout', '61');
INSERT INTO `stockout_summary` VALUES ('51', '10', '2017-05-24', 'pcs', null, '125', 'stockout', '62');
INSERT INTO `stockout_summary` VALUES ('52', '1', '2017-05-25', 'pcs', null, '125', 'stockout', '62');
INSERT INTO `stockout_summary` VALUES ('53', '1', '2017-05-25', 'pcs', null, '125', 'stockout', '62');
INSERT INTO `stockout_summary` VALUES ('54', '1', '2017-05-25', 'pcs', null, '135', 'stockout', '61');
INSERT INTO `stockout_summary` VALUES ('55', '1', '2017-05-26', 'pcs', null, '125', 'stockout', '62');
INSERT INTO `stockout_summary` VALUES ('56', '1', '2017-05-26', 'pcs', null, '135', 'stockout', '61');
INSERT INTO `stockout_summary` VALUES ('57', '1', '2017-05-26', 'pcs', null, '125', 'stockout', '62');
INSERT INTO `stockout_summary` VALUES ('58', '1', '2017-05-26', 'pcs', null, '135', 'stockout', '61');
INSERT INTO `stockout_summary` VALUES ('59', '1', '2017-05-26', 'pcs', null, '150', 'stockout', '60');
INSERT INTO `stockout_summary` VALUES ('60', '2', '2017-05-26', 'pcs', null, '150', 'stockout', '60');
INSERT INTO `stockout_summary` VALUES ('61', '3', '2017-05-26', 'pcs', null, '135', 'stockout', '61');
INSERT INTO `stockout_summary` VALUES ('62', '2', '2017-05-26', 'pcs', null, '25', 'stockout', '63');
INSERT INTO `stockout_summary` VALUES ('63', '1', '2017-05-26', 'pcs', null, '260', 'stockout', '64');
INSERT INTO `stockout_summary` VALUES ('64', '1', '2017-05-26', 'pcs', null, '30', 'stockout', '65');
INSERT INTO `stockout_summary` VALUES ('65', '2', '2017-05-26', 'pcs', null, '26', 'stockout', '66');
INSERT INTO `stockout_summary` VALUES ('66', '1', '2017-05-26', 'pcs', null, '35', 'stockout', '67');
INSERT INTO `stockout_summary` VALUES ('67', '2', '2017-05-26', 'pcs', null, '125', 'stockout', '62');
INSERT INTO `stockout_summary` VALUES ('68', '1', '2017-05-26', 'pcs', null, '25', 'stockout', '60');
INSERT INTO `stockout_summary` VALUES ('69', '1', '2017-05-26', 'pcs', null, '135', 'stockout', '61');
INSERT INTO `stockout_summary` VALUES ('70', '1', '2017-05-26', 'pcs', null, '125', 'stockout', '62');
INSERT INTO `stockout_summary` VALUES ('71', '1', '2017-05-26', 'pcs', null, '25', 'stockout', '63');
INSERT INTO `stockout_summary` VALUES ('72', '1', '2017-05-26', 'pcs', null, '26', 'stockout', '66');
INSERT INTO `stockout_summary` VALUES ('73', '1', '2017-05-27', 'pcs', null, '135', 'stockout', '61');
INSERT INTO `stockout_summary` VALUES ('74', '1', '2017-05-27', 'pcs', null, '135', 'stockout', '61');
INSERT INTO `stockout_summary` VALUES ('75', '1', '2017-05-27', 'pcs', null, '260', 'stockout', '64');
INSERT INTO `stockout_summary` VALUES ('76', '1', '2017-05-27', 'pcs', null, '125', 'stockout', '62');
INSERT INTO `stockout_summary` VALUES ('77', '1', '2017-05-27', 'pcs', null, '30', 'stockout', '65');
INSERT INTO `stockout_summary` VALUES ('78', '1', '2017-05-27', 'pcs', null, '125', 'stockout', '62');
INSERT INTO `stockout_summary` VALUES ('79', '10', '2017-05-29', 'pcs', null, '135', 'stockout', '61');
INSERT INTO `stockout_summary` VALUES ('80', '1', '2017-05-29', 'pcs', null, '135', 'stockout', '61');
INSERT INTO `stockout_summary` VALUES ('81', '5', '2017-05-29', 'pcs', null, '125', 'stockout', '62');
INSERT INTO `stockout_summary` VALUES ('82', '15', '2017-05-29', 'pcs', null, '30', 'stockout', '65');
INSERT INTO `stockout_summary` VALUES ('83', '5', '2017-05-29', 'pcs', null, '125', 'stockout', '62');
INSERT INTO `stockout_summary` VALUES ('84', '1', '2017-05-29', 'pcs', null, '25', 'stockout', '63');
INSERT INTO `stockout_summary` VALUES ('85', '1', '2017-05-29', 'pcs', null, '25', 'stockout', '63');
INSERT INTO `stockout_summary` VALUES ('86', '1', '2017-05-29', 'pcs', null, '25', 'stockout', '63');
INSERT INTO `stockout_summary` VALUES ('87', '1', '2017-05-29', 'pcs', null, '35', 'stockout', '67');
INSERT INTO `stockout_summary` VALUES ('88', '1', '2017-05-29', 'pcs', null, '260', 'stockout', '64');
INSERT INTO `stockout_summary` VALUES ('89', '1', '2017-05-29', 'pcs', null, '125', 'stockout', '62');
INSERT INTO `stockout_summary` VALUES ('90', '1', '2017-05-29', 'pcs', null, '135', 'stockout', '61');
INSERT INTO `stockout_summary` VALUES ('91', '1', '2017-05-29', 'pcs', null, '25', 'stockout', '63');
INSERT INTO `stockout_summary` VALUES ('92', '1', '2017-05-29', 'pcs', null, '25', 'stockout', '60');
INSERT INTO `stockout_summary` VALUES ('93', '1', '2017-05-29', 'pcs', null, '135', 'stockout', '61');
INSERT INTO `stockout_summary` VALUES ('94', '1', '2017-05-29', 'pcs', null, '135', 'stockout', '61');
INSERT INTO `stockout_summary` VALUES ('95', '1', '2017-05-29', 'pcs', null, '260', 'stockout', '64');
INSERT INTO `stockout_summary` VALUES ('96', '1', '2017-05-29', 'pcs', null, '25', 'stockout', '63');
INSERT INTO `stockout_summary` VALUES ('97', '1', '2017-05-29', 'pcs', null, '25', 'stockout', '60');
INSERT INTO `stockout_summary` VALUES ('98', '1', '2017-05-29', 'pcs', null, '260', 'stockout', '64');
INSERT INTO `stockout_summary` VALUES ('99', '2', '2017-05-29', 'pcs', null, '135', 'stockout', '61');
INSERT INTO `stockout_summary` VALUES ('100', '1', '2017-05-29', 'pcs', null, '25', 'stockout', '63');
INSERT INTO `stockout_summary` VALUES ('101', '1', '2017-05-29', 'pcs', null, '260', 'stockout', '64');
INSERT INTO `stockout_summary` VALUES ('102', '1', '2017-05-29', 'pcs', null, '135', 'stockout', '61');
INSERT INTO `stockout_summary` VALUES ('103', '1', '2017-05-29', 'pcs', null, '25', 'stockout', '63');
INSERT INTO `stockout_summary` VALUES ('104', '2', '2017-05-29', 'pcs', null, '30', 'stockout', '65');
INSERT INTO `stockout_summary` VALUES ('105', '4', '2017-05-29', 'pcs', null, '35', 'stockout', '67');
INSERT INTO `stockout_summary` VALUES ('106', '2', '2017-05-29', 'pcs', null, '135', 'stockout', '61');
INSERT INTO `stockout_summary` VALUES ('107', '2', '2017-05-29', 'pcs', null, '30', 'stockout', '65');
INSERT INTO `stockout_summary` VALUES ('108', '2', '2017-05-29', 'pcs', null, '26', 'stockout', '66');
INSERT INTO `stockout_summary` VALUES ('109', '4', '2017-05-29', 'pcs', null, '30', 'stockout', '65');
INSERT INTO `stockout_summary` VALUES ('110', '1', '2017-05-29', 'pcs', null, '135', 'stockout', '61');
INSERT INTO `stockout_summary` VALUES ('111', '1', '2017-05-29', 'pcs', null, '25', 'stockout', '63');
INSERT INTO `stockout_summary` VALUES ('112', '1', '2017-05-29', 'pcs', null, '135', 'stockout', '61');
INSERT INTO `stockout_summary` VALUES ('113', '1', '2017-05-29', 'pcs', null, '35', 'stockout', '67');
INSERT INTO `stockout_summary` VALUES ('114', '3', '2017-05-29', 'pcs', null, '260', 'stockout', '64');
INSERT INTO `stockout_summary` VALUES ('115', '2', '2017-05-29', 'pcs', null, '26', 'stockout', '66');
INSERT INTO `stockout_summary` VALUES ('116', '1', '2017-05-29', 'pcs', null, '135', 'stockout', '61');
INSERT INTO `stockout_summary` VALUES ('117', '1', '2017-05-29', 'pcs', null, '25', 'stockout', '63');
INSERT INTO `stockout_summary` VALUES ('118', '1', '2017-05-29', 'pcs', null, '260', 'stockout', '64');
INSERT INTO `stockout_summary` VALUES ('119', '1', '2017-05-29', 'pcs', null, '30', 'stockout', '65');
INSERT INTO `stockout_summary` VALUES ('120', '1', '2017-05-29', 'pcs', null, '125', 'stockout', '62');
INSERT INTO `stockout_summary` VALUES ('121', '1', '2017-05-29', 'pcs', null, '25', 'stockout', '63');
INSERT INTO `stockout_summary` VALUES ('122', '1', '2017-05-29', 'pcs', null, '260', 'stockout', '64');
INSERT INTO `stockout_summary` VALUES ('123', '1', '2017-05-29', 'pcs', null, '25', 'stockout', '63');
INSERT INTO `stockout_summary` VALUES ('124', '1', '2017-05-29', 'pcs', null, '25', 'stockout', '60');
INSERT INTO `stockout_summary` VALUES ('125', '1', '2017-05-29', 'pcs', null, '135', 'stockout', '61');
INSERT INTO `stockout_summary` VALUES ('126', '1', '2017-05-29', 'pcs', null, '25', 'stockout', '63');
INSERT INTO `stockout_summary` VALUES ('127', '1', '2017-05-29', 'pcs', null, '30', 'stockout', '65');
INSERT INTO `stockout_summary` VALUES ('128', '1', '2017-05-29', 'pcs', null, '35', 'stockout', '67');
INSERT INTO `stockout_summary` VALUES ('129', '1', '2017-05-29', 'pcs', null, '125', 'stockout', '62');
INSERT INTO `stockout_summary` VALUES ('130', '1', '2017-05-30', 'pcs', null, '135', 'stockout', '61');
INSERT INTO `stockout_summary` VALUES ('131', '1', '2017-05-30', 'pcs', null, '25', 'stockout', '63');
INSERT INTO `stockout_summary` VALUES ('132', '1', '2017-05-30', 'pcs', null, '25', 'stockout', '63');
INSERT INTO `stockout_summary` VALUES ('133', '1', '2017-05-30', 'pcs', null, '260', 'stockout', '64');
INSERT INTO `stockout_summary` VALUES ('134', '1', '2017-05-30', 'pcs', null, '135', 'stockout', '61');
INSERT INTO `stockout_summary` VALUES ('135', '1', '2017-05-30', 'pcs', null, '30', 'stockout', '65');
INSERT INTO `stockout_summary` VALUES ('136', '1', '2017-05-30', 'pcs', null, '135', 'stockout', '61');
INSERT INTO `stockout_summary` VALUES ('137', '1', '2017-05-30', 'pcs', null, '25', 'stockout', '63');
INSERT INTO `stockout_summary` VALUES ('138', '1', '2017-05-30', 'pcs', null, '35', 'stockout', '67');
INSERT INTO `stockout_summary` VALUES ('139', '1', '2017-05-30', 'pcs', null, '26', 'stockout', '66');
INSERT INTO `stockout_summary` VALUES ('140', '3', '2017-05-30', 'pcs', null, '260', 'stockout', '64');
INSERT INTO `stockout_summary` VALUES ('141', '4', '2017-05-30', 'pcs', null, '26', 'stockout', '66');
INSERT INTO `stockout_summary` VALUES ('142', '2', '2017-05-30', 'pcs', null, '125', 'stockout', '62');
INSERT INTO `stockout_summary` VALUES ('143', '1', '2017-05-30', 'pcs', null, '135', 'stockout', '61');
INSERT INTO `stockout_summary` VALUES ('144', '1', '2017-05-30', 'pcs', null, '30', 'stockout', '65');
INSERT INTO `stockout_summary` VALUES ('145', '1', '2017-05-30', 'pcs', null, '26', 'stockout', '66');
INSERT INTO `stockout_summary` VALUES ('146', '1', '2017-05-30', 'pcs', null, '30', 'stockout', '65');
INSERT INTO `stockout_summary` VALUES ('147', '1', '2017-05-30', 'pcs', null, '125', 'stockout', '62');
INSERT INTO `stockout_summary` VALUES ('148', '1', '2017-05-30', 'pcs', null, '26', 'stockout', '66');
INSERT INTO `stockout_summary` VALUES ('149', '1', '2017-05-30', 'pcs', null, '30', 'stockout', '65');
INSERT INTO `stockout_summary` VALUES ('150', '1', '2017-05-30', 'pcs', null, '35', 'stockout', '67');
INSERT INTO `stockout_summary` VALUES ('151', '1', '2017-05-30', 'pcs', null, '260', 'stockout', '64');
INSERT INTO `stockout_summary` VALUES ('152', '1', '2017-05-30', 'pcs', null, '30', 'stockout', '65');
INSERT INTO `stockout_summary` VALUES ('153', '1', '2017-05-30', 'pcs', null, '135', 'stockout', '61');
INSERT INTO `stockout_summary` VALUES ('154', '1', '2017-05-30', 'pcs', null, '30', 'stockout', '65');
INSERT INTO `stockout_summary` VALUES ('155', '100', '2017-05-31', 'pcs', null, '300', 'stockout', '61');
INSERT INTO `stockout_summary` VALUES ('156', '1', '2017-05-31', 'pcs', null, '300', 'stockout', '61');
INSERT INTO `stockout_summary` VALUES ('157', '1', '2017-05-31', 'pcs', null, '25', 'stockout', '63');
INSERT INTO `stockout_summary` VALUES ('158', '1', '2017-05-31', 'pcs', null, '25', 'stockout', '63');
INSERT INTO `stockout_summary` VALUES ('159', '1', '2017-05-31', 'pcs', null, '30', 'stockout', '65');
INSERT INTO `stockout_summary` VALUES ('160', '1', '2017-05-31', 'pcs', null, '30', 'stockout', '65');
INSERT INTO `stockout_summary` VALUES ('161', '1', '2017-05-31', 'pcs', null, '125', 'stockout', '62');
INSERT INTO `stockout_summary` VALUES ('162', '1', '2017-05-31', 'pcs', null, '35', 'stockout', '67');
INSERT INTO `stockout_summary` VALUES ('163', '1', '2017-05-31', 'pcs', null, '125', 'stockout', '62');
INSERT INTO `stockout_summary` VALUES ('164', '1', '2017-05-31', 'pcs', null, '26', 'stockout', '66');
INSERT INTO `stockout_summary` VALUES ('165', '1', '2017-05-31', 'pcs', null, '125', 'stockout', '62');
INSERT INTO `stockout_summary` VALUES ('166', '1', '2017-05-31', 'pcs', null, '30', 'stockout', '65');
INSERT INTO `stockout_summary` VALUES ('167', '1', '2017-05-31', 'pcs', null, '35', 'stockout', '67');
INSERT INTO `stockout_summary` VALUES ('168', '1', '2017-05-31', 'pcs', null, '26', 'stockout', '66');
INSERT INTO `stockout_summary` VALUES ('169', '1', '2017-05-31', 'pcs', null, '35', 'stockout', '67');
INSERT INTO `stockout_summary` VALUES ('170', '1', '2017-05-31', 'pcs', null, '30', 'stockout', '65');
INSERT INTO `stockout_summary` VALUES ('171', '1', '2017-05-31', 'pcs', null, '260', 'stockout', '64');
INSERT INTO `stockout_summary` VALUES ('172', '1', '2017-05-31', 'pcs', null, '26', 'stockout', '66');
INSERT INTO `stockout_summary` VALUES ('173', '1', '2017-05-31', 'pcs', null, '260', 'stockout', '64');
INSERT INTO `stockout_summary` VALUES ('174', '1', '2017-05-31', 'pcs', null, '125', 'stockout', '62');
INSERT INTO `stockout_summary` VALUES ('175', '1', '2017-05-31', 'pcs', null, '25', 'stockout', '63');
INSERT INTO `stockout_summary` VALUES ('176', '1', '2017-05-31', 'pcs', null, '25', 'stockout', '60');
INSERT INTO `stockout_summary` VALUES ('177', '1', '2017-05-31', 'pcs', null, '300', 'stockout', '61');
INSERT INTO `stockout_summary` VALUES ('178', '1', '2017-05-31', 'pcs', null, '25', 'stockout', '63');
INSERT INTO `stockout_summary` VALUES ('179', '1', '2017-05-31', 'pcs', null, '260', 'stockout', '64');
INSERT INTO `stockout_summary` VALUES ('180', '1', '2017-05-31', 'pcs', null, '30', 'stockout', '65');
INSERT INTO `stockout_summary` VALUES ('181', '1', '2017-05-31', 'pcs', null, '26', 'stockout', '66');
INSERT INTO `stockout_summary` VALUES ('182', '1', '2017-05-31', 'pcs', null, '35', 'stockout', '67');
INSERT INTO `stockout_summary` VALUES ('183', '1', '2017-05-31', 'pcs', null, '125', 'stockout', '62');
INSERT INTO `stockout_summary` VALUES ('184', '1', '2017-05-31', 'pcs', null, '25', 'stockout', '63');
INSERT INTO `stockout_summary` VALUES ('185', '1', '2017-05-31', 'pcs', null, '26', 'stockout', '66');
INSERT INTO `stockout_summary` VALUES ('186', '1', '2017-05-31', 'pcs', null, '300', 'stockout', '61');
INSERT INTO `stockout_summary` VALUES ('187', '1', '2017-05-31', 'pcs', null, '25', 'stockout', '63');
INSERT INTO `stockout_summary` VALUES ('188', '1', '2017-05-31', 'pcs', null, '26', 'stockout', '66');
INSERT INTO `stockout_summary` VALUES ('189', '1', '2017-05-31', 'pcs', null, '125', 'stockout', '62');
INSERT INTO `stockout_summary` VALUES ('190', '1', '2017-05-31', 'pcs', null, '25', 'stockout', '63');
INSERT INTO `stockout_summary` VALUES ('191', '1', '2017-06-01', 'pcs', null, '260', 'stockout', '64');
INSERT INTO `stockout_summary` VALUES ('192', '1', '2017-06-01', 'pcs', null, '30', 'stockout', '65');
INSERT INTO `stockout_summary` VALUES ('193', '1', '2017-06-01', 'pcs', null, '25', 'stockout', '63');
INSERT INTO `stockout_summary` VALUES ('194', '1', '2017-06-01', 'pcs', null, '125', 'stockout', '62');
INSERT INTO `stockout_summary` VALUES ('195', '1', '2017-06-01', 'pcs', null, '300', 'stockout', '61');
INSERT INTO `stockout_summary` VALUES ('196', '1', '2017-06-01', 'pcs', null, '125', 'stockout', '62');
INSERT INTO `stockout_summary` VALUES ('197', '1', '2017-06-01', 'pcs', null, '30', 'stockout', '65');
INSERT INTO `stockout_summary` VALUES ('198', '1', '2017-06-02', 'pcs', null, '26', 'stockout', '66');
INSERT INTO `stockout_summary` VALUES ('199', '1', '2017-06-02', 'pcs', null, '35', 'stockout', '67');
INSERT INTO `stockout_summary` VALUES ('200', '1', '2017-06-02', 'pcs', null, '35', 'stockout', '67');
INSERT INTO `stockout_summary` VALUES ('201', '1', '2017-06-02', 'pcs', null, '25', 'stockout', '63');
INSERT INTO `stockout_summary` VALUES ('202', '1', '2017-06-02', 'pcs', null, '260', 'stockout', '64');
INSERT INTO `stockout_summary` VALUES ('203', '1', '2017-06-02', 'pcs', null, '25', 'stockout', '63');
INSERT INTO `stockout_summary` VALUES ('204', '1', '2017-06-02', 'pcs', null, '30', 'stockout', '65');
INSERT INTO `stockout_summary` VALUES ('205', '1', '2017-06-02', 'pcs', null, '260', 'stockout', '64');
INSERT INTO `stockout_summary` VALUES ('206', '1', '2017-06-02', 'pcs', null, '260', 'stockout', '64');
INSERT INTO `stockout_summary` VALUES ('207', '1', '2017-06-02', 'pcs', null, '25', 'stockout', '60');
INSERT INTO `stockout_summary` VALUES ('208', '1', '2017-06-02', 'pcs', null, '25', 'stockout', '63');
INSERT INTO `stockout_summary` VALUES ('209', '1', '2017-06-02', 'pcs', null, '26', 'stockout', '66');
INSERT INTO `stockout_summary` VALUES ('210', '1', '2017-06-02', 'pcs', null, '26', 'stockout', '66');
INSERT INTO `stockout_summary` VALUES ('211', '1', '2017-06-10', 'pcs', null, '125', 'stockout', '62');
INSERT INTO `stockout_summary` VALUES ('212', '1', '2017-06-10', 'pcs', null, '25', 'stockout', '63');
INSERT INTO `stockout_summary` VALUES ('213', '3', '2017-06-10', 'pcs', null, '30', 'stockout', '65');
INSERT INTO `stockout_summary` VALUES ('214', '55', '2017-06-10', 'pcs', null, '125', 'stockout', '62');
INSERT INTO `stockout_summary` VALUES ('215', '10', '2017-06-10', 'pcs', null, '35', 'stockout', '67');
INSERT INTO `stockout_summary` VALUES ('216', '1', '2017-06-10', 'pcs', null, '25', 'stockout', '63');
INSERT INTO `stockout_summary` VALUES ('217', '3', '2017-06-10', 'pcs', null, '26', 'stockout', '66');
INSERT INTO `stockout_summary` VALUES ('218', '5', '2017-06-10', 'pcs', null, '35', 'stockout', '67');
INSERT INTO `stockout_summary` VALUES ('219', '1', '2017-06-10', 'pcs', null, '35', 'stockout', '67');
INSERT INTO `stockout_summary` VALUES ('220', '1', '2017-06-10', 'pcs', null, '260', 'stockout', '64');
INSERT INTO `stockout_summary` VALUES ('221', '11', '2017-06-10', 'pcs', null, '25', 'stockout', '63');
INSERT INTO `stockout_summary` VALUES ('222', '5', '2017-06-10', 'pcs', null, '125', 'stockout', '62');
INSERT INTO `stockout_summary` VALUES ('223', '20', '2017-06-10', 'pcs', null, '25', 'stockout', '63');
INSERT INTO `stockout_summary` VALUES ('224', '20', '2017-06-10', 'pcs', null, '26', 'stockout', '66');
INSERT INTO `stockout_summary` VALUES ('225', '20', '2017-06-10', 'pcs', null, '125', 'stockout', '62');
INSERT INTO `stockout_summary` VALUES ('226', '20', '2017-06-10', 'pcs', null, '25', 'stockout', '60');
INSERT INTO `stockout_summary` VALUES ('227', '20', '2017-06-10', 'pcs', null, '300', 'stockout', '61');
INSERT INTO `stockout_summary` VALUES ('228', '20', '2017-06-10', 'pcs', null, '30', 'stockout', '65');
INSERT INTO `stockout_summary` VALUES ('229', '1', '2018-10-11', 'pcs', null, '30', 'stockout', '65');
INSERT INTO `stockout_summary` VALUES ('230', '1', '2018-10-11', 'pcs', null, '260', 'stockout', '64');
INSERT INTO `stockout_summary` VALUES ('231', '1', '2018-10-11', 'pcs', null, '25', 'stockout', '63');
INSERT INTO `stockout_summary` VALUES ('232', '1', '2018-10-11', 'pcs', null, '25', 'stockout', '63');
INSERT INTO `stockout_summary` VALUES ('233', '1', '2018-10-11', 'pcs', null, '26', 'stockout', '66');
INSERT INTO `stockout_summary` VALUES ('234', '1', '2018-10-23', 'pcs', null, '25', 'stockout', '60');
INSERT INTO `stockout_summary` VALUES ('235', '1', '2018-10-23', 'pcs', null, '25', 'stockout', '63');
INSERT INTO `stockout_summary` VALUES ('236', '1', '2018-10-23', 'pcs', null, '35', 'stockout', '67');

-- ----------------------------
-- Table structure for supplier
-- ----------------------------
DROP TABLE IF EXISTS `supplier`;
CREATE TABLE `supplier` (
  `supplier_id` int(11) NOT NULL AUTO_INCREMENT,
  `supplier_company_name` varchar(255) DEFAULT NULL,
  `supplier_name` varchar(255) DEFAULT NULL,
  `supplier_email` varchar(255) DEFAULT NULL,
  `supplier_phone_no` varchar(120) DEFAULT NULL,
  `supplier_address` text,
  PRIMARY KEY (`supplier_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of supplier
-- ----------------------------
INSERT INTO `supplier` VALUES ('1', 'Apple Inc', 'Steve Jobs', 'job@apple.com', '3425-536-52', 'USA California');
INSERT INTO `supplier` VALUES ('2', 'Microsoft Coorporation', 'Bill Gates', 'gates@msn.com', '325-544-56', 'New York, City New York');

-- ----------------------------
-- Table structure for tempsales
-- ----------------------------
DROP TABLE IF EXISTS `tempsales`;
CREATE TABLE `tempsales` (
  `salesId` int(11) NOT NULL AUTO_INCREMENT,
  `stockSumId` int(11) DEFAULT NULL,
  `barcode` varchar(120) DEFAULT NULL,
  `productPrice` varchar(120) DEFAULT NULL,
  `productName` varchar(255) DEFAULT NULL,
  `productQuantity` varchar(255) DEFAULT NULL,
  `quantityType` varchar(255) DEFAULT NULL,
  `discount` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`salesId`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tempsales
-- ----------------------------

-- ----------------------------
-- Table structure for temp_order
-- ----------------------------
DROP TABLE IF EXISTS `temp_order`;
CREATE TABLE `temp_order` (
  `temp_order_id` int(11) NOT NULL AUTO_INCREMENT,
  `temp_order_name` varchar(150) DEFAULT NULL,
  `temp_order_quantity` varchar(100) DEFAULT NULL,
  `temp_order_quan_type` varchar(100) DEFAULT NULL,
  `temp_order_price` decimal(10,0) DEFAULT NULL,
  `temp_order_discount` varchar(255) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`temp_order_id`),
  KEY `order_id` (`order_id`),
  CONSTRAINT `temp_order_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of temp_order
-- ----------------------------

-- ----------------------------
-- Table structure for temp_payment
-- ----------------------------
DROP TABLE IF EXISTS `temp_payment`;
CREATE TABLE `temp_payment` (
  `tp_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) DEFAULT NULL,
  `sales_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`tp_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of temp_payment
-- ----------------------------

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  `user_status` varchar(255) DEFAULT NULL,
  `user_prev` varchar(255) DEFAULT NULL,
  `user_type` varchar(120) DEFAULT NULL,
  `user_salt` varchar(120) DEFAULT NULL,
  `person_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  KEY `fk_users_personnel_1` (`person_id`),
  KEY `users_ibfk_1` (`role_id`),
  CONSTRAINT `fk_users_personnel_1` FOREIGN KEY (`person_id`) REFERENCES `personnel` (`person_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `user_role` (`role_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('1', 'admin', '83cee3ac5b6fd1aedb30ea7ccc479c7914729bdfc925bd5274367efce27cd06c', '1', 'online', null, 'super_user', ' šŸ,¸”\ZjËÖ.F)f»   €÷®:ç–ÑÒ×¦o®', '1');
INSERT INTO `users` VALUES ('3', 'cashier', '93813f916b780f32ba3a028759486c21ecb40cc0e575a734580a6a3c7ad638a5', '3', 'offline', null, 'user', '±usÄ$ÍEPS`qyéŽUÕàdà^H»ÆOŽ¢', '12');
INSERT INTO `users` VALUES ('4', 'staff1', '85b5df61b6b02c10fcad607b9800dfe78410ddcbc9f1dcadf39d8131b0478960', '2', 'offline', null, 'user', 'L&-œnœÑÕx~Á“‰ØxR‰M•Ù˜©áEKý<;', '13');
INSERT INTO `users` VALUES ('7', 'sample', '7cf5c4ffc7e91f697160cdee1c5174c40368f8fd216aa1054abadc7c86710577', '2', 'offline', null, 'user', '6364d3f0f495b6ab9dcf8d3b5c6e0b01', '16');

-- ----------------------------
-- Table structure for user_logs
-- ----------------------------
DROP TABLE IF EXISTS `user_logs`;
CREATE TABLE `user_logs` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT,
  `login_date` datetime DEFAULT NULL,
  `logout_date` datetime DEFAULT NULL,
  `log_status` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`log_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `user_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=302 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of user_logs
-- ----------------------------
INSERT INTO `user_logs` VALUES ('225', '2017-05-24 10:05:36', '2018-10-23 21:10:29', 'logout', '1');
INSERT INTO `user_logs` VALUES ('226', '2017-05-24 13:05:10', '2018-10-23 21:10:29', 'logout', '1');
INSERT INTO `user_logs` VALUES ('227', '2017-05-24 15:05:58', '2018-10-23 21:10:29', 'logout', '1');
INSERT INTO `user_logs` VALUES ('228', '2017-05-25 10:05:57', '2018-10-23 21:10:29', 'logout', '1');
INSERT INTO `user_logs` VALUES ('229', '2017-05-25 12:05:58', '2018-10-23 21:10:29', 'logout', '1');
INSERT INTO `user_logs` VALUES ('230', '2017-05-25 17:05:37', '2018-10-23 21:10:29', 'logout', '1');
INSERT INTO `user_logs` VALUES ('231', '2017-05-26 10:05:25', '2018-10-23 21:10:29', 'logout', '1');
INSERT INTO `user_logs` VALUES ('232', '2017-05-26 12:05:13', '2018-10-23 21:10:29', 'logout', '1');
INSERT INTO `user_logs` VALUES ('233', '2017-05-26 13:05:39', '2018-10-23 21:10:29', 'logout', '1');
INSERT INTO `user_logs` VALUES ('234', '2017-05-26 13:05:19', '2018-10-23 21:10:29', 'logout', '1');
INSERT INTO `user_logs` VALUES ('235', '2017-05-26 16:05:44', '2018-10-23 21:10:29', 'logout', '1');
INSERT INTO `user_logs` VALUES ('236', '2017-05-26 17:05:12', '2018-10-23 21:10:29', 'logout', '1');
INSERT INTO `user_logs` VALUES ('237', '2017-05-26 17:05:07', '2018-10-23 21:10:29', 'logout', '1');
INSERT INTO `user_logs` VALUES ('238', '2017-05-27 12:05:15', '2018-10-23 21:10:29', 'logout', '1');
INSERT INTO `user_logs` VALUES ('239', '2017-05-29 11:05:37', '2018-10-23 21:10:29', 'logout', '1');
INSERT INTO `user_logs` VALUES ('240', '2017-05-29 12:05:26', '2018-10-23 21:10:29', 'logout', '1');
INSERT INTO `user_logs` VALUES ('241', '2017-05-29 14:05:02', '2018-10-23 21:10:29', 'logout', '1');
INSERT INTO `user_logs` VALUES ('242', '2017-05-29 14:05:02', '2018-10-23 21:10:29', 'logout', '1');
INSERT INTO `user_logs` VALUES ('243', '2017-05-29 17:05:46', '2018-10-23 21:10:29', 'logout', '3');
INSERT INTO `user_logs` VALUES ('244', '2017-05-29 17:05:21', '2018-10-23 21:10:29', 'logout', '3');
INSERT INTO `user_logs` VALUES ('245', '2017-05-29 17:05:35', '2018-10-23 21:10:29', 'logout', '3');
INSERT INTO `user_logs` VALUES ('246', '2017-05-29 17:05:48', '2018-10-23 21:10:29', 'logout', '3');
INSERT INTO `user_logs` VALUES ('247', '2017-05-29 17:05:02', '2018-10-23 21:10:29', 'logout', '3');
INSERT INTO `user_logs` VALUES ('248', '2017-05-29 17:05:45', '2018-10-23 21:10:29', 'logout', '3');
INSERT INTO `user_logs` VALUES ('249', '2017-05-29 17:05:41', '2018-10-23 21:10:29', 'logout', '3');
INSERT INTO `user_logs` VALUES ('250', '2017-05-29 17:05:00', '2018-10-23 21:10:29', 'logout', '1');
INSERT INTO `user_logs` VALUES ('251', '2017-05-29 17:05:19', '2018-10-23 21:10:29', 'logout', '1');
INSERT INTO `user_logs` VALUES ('252', '2017-05-29 17:05:15', '2018-10-23 21:10:29', 'logout', '1');
INSERT INTO `user_logs` VALUES ('253', '2017-05-30 16:05:43', '2018-10-23 21:10:29', 'logout', '1');
INSERT INTO `user_logs` VALUES ('254', '2017-05-31 08:05:41', '2018-10-23 21:10:29', 'logout', '1');
INSERT INTO `user_logs` VALUES ('255', '2017-05-31 10:05:03', '2018-10-23 21:10:29', 'logout', '1');
INSERT INTO `user_logs` VALUES ('256', '2017-05-31 10:05:49', '2018-10-23 21:10:29', 'logout', '1');
INSERT INTO `user_logs` VALUES ('257', '2017-05-31 14:05:38', '2018-10-23 21:10:29', 'logout', '1');
INSERT INTO `user_logs` VALUES ('258', '2017-06-01 12:06:06', '2018-10-23 21:10:29', 'logout', '1');
INSERT INTO `user_logs` VALUES ('259', '2017-06-01 16:06:09', '2018-10-23 21:10:29', 'logout', '1');
INSERT INTO `user_logs` VALUES ('260', '2017-06-01 17:06:14', '2018-10-23 21:10:29', 'logout', '1');
INSERT INTO `user_logs` VALUES ('261', '2017-06-02 12:06:21', '2018-10-23 21:10:29', 'logout', '1');
INSERT INTO `user_logs` VALUES ('262', '2017-06-02 15:06:56', '2018-10-23 21:10:29', 'logout', '1');
INSERT INTO `user_logs` VALUES ('263', '2017-06-02 15:06:26', '2018-10-23 21:10:29', 'logout', '1');
INSERT INTO `user_logs` VALUES ('264', '2017-06-03 17:06:25', '2018-10-23 21:10:29', 'logout', '1');
INSERT INTO `user_logs` VALUES ('265', '2017-06-03 17:06:09', '2018-10-23 21:10:29', 'logout', '1');
INSERT INTO `user_logs` VALUES ('266', '2017-06-05 08:06:31', '2018-10-23 21:10:29', 'logout', '1');
INSERT INTO `user_logs` VALUES ('267', '2017-06-06 09:06:11', '2018-10-23 21:10:29', 'logout', '1');
INSERT INTO `user_logs` VALUES ('268', '2017-06-09 14:06:04', '2018-10-23 21:10:29', 'logout', '1');
INSERT INTO `user_logs` VALUES ('269', '2017-06-09 16:06:27', '2018-10-23 21:10:29', 'logout', '1');
INSERT INTO `user_logs` VALUES ('270', '2017-06-10 15:06:39', '2018-10-23 21:10:29', 'logout', '1');
INSERT INTO `user_logs` VALUES ('271', '2017-06-10 16:06:19', '2018-10-23 21:10:29', 'logout', '1');
INSERT INTO `user_logs` VALUES ('272', '2018-04-08 16:04:32', '2018-10-23 21:10:29', 'logout', '1');
INSERT INTO `user_logs` VALUES ('273', '2018-05-01 19:05:46', '2018-10-23 21:10:29', 'logout', '1');
INSERT INTO `user_logs` VALUES ('274', '2018-05-21 21:05:29', '2018-10-23 21:10:29', 'logout', '1');
INSERT INTO `user_logs` VALUES ('275', '2018-05-21 21:05:52', '2018-10-23 21:10:29', 'logout', '1');
INSERT INTO `user_logs` VALUES ('276', '2018-05-21 21:05:38', '2018-10-23 21:10:29', 'logout', '1');
INSERT INTO `user_logs` VALUES ('277', '2018-05-21 22:05:54', '2018-10-23 21:10:29', 'logout', '1');
INSERT INTO `user_logs` VALUES ('278', '2018-05-21 22:05:51', '2018-10-23 21:10:29', 'logout', '1');
INSERT INTO `user_logs` VALUES ('279', '2018-05-21 22:05:43', '2018-10-23 21:10:29', 'logout', '1');
INSERT INTO `user_logs` VALUES ('280', '2018-05-21 22:05:12', '2018-10-23 21:10:29', 'logout', '1');
INSERT INTO `user_logs` VALUES ('281', '2018-05-21 22:05:11', '2018-10-23 21:10:29', 'logout', '1');
INSERT INTO `user_logs` VALUES ('282', '2018-05-21 22:05:21', '2018-10-23 21:10:29', 'logout', '1');
INSERT INTO `user_logs` VALUES ('283', '2018-05-21 22:05:34', '2018-10-23 21:10:29', 'logout', '1');
INSERT INTO `user_logs` VALUES ('284', '2018-05-21 22:05:16', '2018-10-23 21:10:29', 'logout', '1');
INSERT INTO `user_logs` VALUES ('285', '2018-05-21 22:05:15', '2018-10-23 21:10:29', 'logout', '1');
INSERT INTO `user_logs` VALUES ('286', '2018-06-06 23:06:58', '2018-10-23 21:10:29', 'logout', '1');
INSERT INTO `user_logs` VALUES ('287', '2018-06-06 23:06:11', '2018-10-23 21:10:29', 'logout', '1');
INSERT INTO `user_logs` VALUES ('288', '2018-06-06 23:06:34', '2018-10-23 21:10:29', 'logout', '1');
INSERT INTO `user_logs` VALUES ('289', '2018-06-08 23:06:18', '2018-10-23 21:10:29', 'logout', '1');
INSERT INTO `user_logs` VALUES ('290', '2018-09-02 21:09:16', '2018-10-23 21:10:29', 'logout', '1');
INSERT INTO `user_logs` VALUES ('291', '2018-09-02 22:09:37', '2018-10-23 21:10:29', 'logout', '1');
INSERT INTO `user_logs` VALUES ('292', '2018-09-09 16:09:23', '2018-10-23 21:10:29', 'logout', '1');
INSERT INTO `user_logs` VALUES ('293', '2018-10-11 23:10:19', '2018-10-23 21:10:29', 'logout', '1');
INSERT INTO `user_logs` VALUES ('294', '2018-10-11 23:10:15', '2018-10-23 21:10:29', 'logout', '1');
INSERT INTO `user_logs` VALUES ('295', '2018-10-23 20:10:07', '2018-10-23 21:10:29', 'logout', '1');
INSERT INTO `user_logs` VALUES ('296', '2018-10-23 20:10:57', '2018-10-23 21:10:29', 'logout', '1');
INSERT INTO `user_logs` VALUES ('297', '2018-10-23 21:10:27', '2018-10-23 21:10:29', 'logout', '1');
INSERT INTO `user_logs` VALUES ('298', '2018-10-23 21:10:27', '2018-10-23 21:10:29', 'logout', '1');
INSERT INTO `user_logs` VALUES ('299', '2018-10-23 21:10:39', '2018-10-23 21:10:29', 'logout', '1');
INSERT INTO `user_logs` VALUES ('300', '2018-10-23 21:10:13', '2018-10-23 21:10:29', 'logout', '1');
INSERT INTO `user_logs` VALUES ('301', '2018-10-23 21:10:42', null, 'login', '1');

-- ----------------------------
-- Table structure for user_role
-- ----------------------------
DROP TABLE IF EXISTS `user_role`;
CREATE TABLE `user_role` (
  `role_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_role` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of user_role
-- ----------------------------
INSERT INTO `user_role` VALUES ('1', 'admin');
INSERT INTO `user_role` VALUES ('2', 'staff');
INSERT INTO `user_role` VALUES ('3', 'cashier');
