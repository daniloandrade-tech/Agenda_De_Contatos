-- APENAS PARA BANCO DE TESTE: apaga e recria o banco agenda.
DROP DATABASE IF EXISTS `agenda`;

CREATE DATABASE `agenda`
  DEFAULT CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE `agenda`;

CREATE TABLE `usuarios` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(60) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `senha` VARCHAR(255) NOT NULL,
  `foto` VARCHAR(255) NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB DEFAULT CHARACTER SET=utf8mb4;

CREATE TABLE `contatos` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `usuario_id` INT NOT NULL,
  `nome` VARCHAR(60) NOT NULL,
  `email` VARCHAR(100) NULL,
  `telefone` VARCHAR(11) NOT NULL,
  `cidade` VARCHAR(60) NULL,
  `estado` CHAR(2) NULL,
  PRIMARY KEY (`id`),
  KEY `idx_contatos_usuario_id` (`usuario_id`),
  CONSTRAINT `fk_contatos_usuarios`
    FOREIGN KEY (`usuario_id`)
    REFERENCES `usuarios` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARACTER SET=utf8mb4;
