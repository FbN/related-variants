CREATE TABLE IF NOT EXISTS `oc_related_variant` (
  `related_variant_id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(128) NOT NULL,
  PRIMARY KEY (`related_variant_id`),
  UNIQUE KEY `product_id` (`code`)
);
CREATE TABLE IF NOT EXISTS `oc_related_variant_description` (
  `related_variant_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `title` varchar(64) NOT NULL,
  PRIMARY KEY (`related_variant_id`,`language_id`)
);
CREATE TABLE IF NOT EXISTS `oc_related_variant_to_product` (  
  `product_id` int(11) NOT NULL,
  `related_id` int(11) NOT NULL,
  `related_variant_id` int(11) NOT NULL,
  PRIMARY KEY (`product_id`,`related_id`),
  KEY (`related_variant_id`)
);