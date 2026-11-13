create database Agenda;
use Agenda;

create table contatos 
(id int(7) not null primary key auto_increment,
nome varchar(60) not null,
telefone varchar(11) not null);

create table usuario
(id_usuario int(7) not null primary key auto_increment,
usuario varchar(60) not null);

alter table contatos 
add constraint fk_id_usuario foreign key (id_usuario) 
references usuario (id_usuario);
