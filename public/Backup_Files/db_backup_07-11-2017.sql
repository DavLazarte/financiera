DROP TABLE IF EXISTS compra;

CREATE TABLE `compra` (
  `idcompra` int(11) NOT NULL AUTO_INCREMENT,
  `idproveedor` int(11) NOT NULL,
  `tipo_pago` varchar(25) DEFAULT NULL,
  `num_recibo` varchar(10) NOT NULL,
  `fecha_hora` datetime DEFAULT NULL,
  `total` decimal(11,2) NOT NULL,
  `estado` varchar(10) NOT NULL,
  PRIMARY KEY (`idcompra`),
  KEY `idproveedor` (`idproveedor`),
  CONSTRAINT `idproveedor` FOREIGN KEY (`idproveedor`) REFERENCES `persona` (`idpersona`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



DROP TABLE IF EXISTS detalle_compra;

CREATE TABLE `detalle_compra` (
  `iddetalle_compra` int(11) NOT NULL AUTO_INCREMENT,
  `idproyecto` int(11) NOT NULL,
  `idcompra` int(11) NOT NULL,
  `idmaterial` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_unitario` decimal(11,2) NOT NULL,
  `idrubro` int(11) NOT NULL,
  PRIMARY KEY (`iddetalle_compra`),
  KEY `idcompra` (`idcompra`),
  KEY `idmaterial` (`idmaterial`),
  KEY `idproyecto_idx` (`idproyecto`),
  CONSTRAINT `idcompra` FOREIGN KEY (`idcompra`) REFERENCES `compra` (`idcompra`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `idmaterial` FOREIGN KEY (`idmaterial`) REFERENCES `material` (`idmaterial`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `idproyecto` FOREIGN KEY (`idproyecto`) REFERENCES `proyecto` (`idproyecto`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



DROP TABLE IF EXISTS detalle_presupuesto;

CREATE TABLE `detalle_presupuesto` (
  `iddetalle_presupuesto` int(11) NOT NULL AUTO_INCREMENT,
  `idpresupuesto` int(11) NOT NULL,
  `idtipologia` int(11) NOT NULL,
  `medidas` decimal(11,2) DEFAULT NULL,
  `cantidad` int(11) NOT NULL,
  `precio` decimal(11,2) NOT NULL,
  PRIMARY KEY (`iddetalle_presupuesto`),
  KEY `idpresupuesto` (`idpresupuesto`),
  KEY `idtopologia` (`idtipologia`),
  CONSTRAINT `idpresupuesto` FOREIGN KEY (`idpresupuesto`) REFERENCES `presupuesto` (`idpresupuesto`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `idtopologia` FOREIGN KEY (`idtipologia`) REFERENCES `tipologia` (`idtipologia`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



DROP TABLE IF EXISTS material;

CREATE TABLE `material` (
  `idmaterial` int(11) NOT NULL AUTO_INCREMENT,
  `idrubro` int(11) NOT NULL,
  `codigo` varchar(50) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `precio` decimal(11,2) DEFAULT NULL,
  `descripcion` text,
  `imagen` varchar(50) DEFAULT NULL,
  `estado` varchar(20) NOT NULL,
  PRIMARY KEY (`idmaterial`),
  KEY `idrubro` (`idrubro`),
  CONSTRAINT `idrubro` FOREIGN KEY (`idrubro`) REFERENCES `rubro` (`idrubro`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



DROP TABLE IF EXISTS migrations;

CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



DROP TABLE IF EXISTS otras__salidas;

CREATE TABLE `otras__salidas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fecha_hora` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `para` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `monto` decimal(11,2) NOT NULL,
  `concepto` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `observaciones` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



DROP TABLE IF EXISTS password_resets;

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



DROP TABLE IF EXISTS persona;

CREATE TABLE `persona` (
  `idpersona` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_persona` varchar(20) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `tipo_documento` varchar(10) NOT NULL,
  `num_documento` varchar(15) NOT NULL,
  `direccion` varchar(75) DEFAULT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idpersona`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



DROP TABLE IF EXISTS presupuesto;

CREATE TABLE `presupuesto` (
  `idpresupuesto` int(11) NOT NULL AUTO_INCREMENT,
  `fecha_sol` datetime NOT NULL,
  `idcliente` int(11) NOT NULL,
  `total` decimal(11,2) NOT NULL,
  `costo_material` decimal(11,2) DEFAULT NULL,
  `ganancia` decimal(11,2) DEFAULT NULL,
  `fecha_entrega` datetime DEFAULT NULL,
  `estado` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`idpresupuesto`),
  KEY `idcliente` (`idcliente`),
  CONSTRAINT `idcliente` FOREIGN KEY (`idcliente`) REFERENCES `persona` (`idpersona`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



DROP TABLE IF EXISTS proyecto;

CREATE TABLE `proyecto` (
  `idproyecto` int(11) NOT NULL AUTO_INCREMENT,
  `idpresupuesto` int(11) NOT NULL,
  `fecha_inicio` datetime NOT NULL,
  `tipo_pago` varchar(20) NOT NULL,
  `monto` decimal(11,2) NOT NULL,
  `saldo` decimal(11,2) NOT NULL,
  `costo` decimal(11,2) DEFAULT NULL,
  `fecha_entre` datetime DEFAULT NULL,
  `ganancia` decimal(11,2) DEFAULT NULL,
  `estado` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`idproyecto`),
  KEY `idpresupuesto_idx` (`idpresupuesto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



DROP TABLE IF EXISTS rubro;

CREATE TABLE `rubro` (
  `idrubro` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `descripcion` varchar(256) DEFAULT NULL,
  `condicion` tinyint(1) NOT NULL,
  PRIMARY KEY (`idrubro`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



DROP TABLE IF EXISTS tipologia;

CREATE TABLE `tipologia` (
  `idtipologia` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `descripcion` varchar(260) NOT NULL,
  `marca` varchar(45) DEFAULT NULL,
  `linea` varchar(45) DEFAULT NULL,
  `estado` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`idtipologia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



DROP TABLE IF EXISTS users;

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO users VALUES("1","Enzo Olivera","enzo-olivera@hotmail.com","$2y$10$zgKwJsGkvOJz0q0M7fb9RuRd2j13tr9KS7p2enqwKEp4tm3l0tL/a","UrdNDqpowwBj2OeE6OlMfwNuri0rS4rDQAz4ZlWLGdP65QrHmlvUYCiHP7VX","2017-04-05 11:26:39","2017-06-26 16:29:50");


