create database siga;
use siga;

create table if not exists atividade(
id int auto_increment primary key,
descricao varchar(250) not null,
peso decimal(16,2) not null,
anexo varchar(250) not null );


create table if not exists usuario(
id int auto_increment primary key,
nome varchar(250) not null,
email varchar(250) not null, 
senha varchar(250) not null,
matricula varchar(250) not null,
contato varchar(250) not null );

create table if not exists filme (
    id int auto_increment primary key,
    titulo varchar(250) not null,
    diretor varchar(250) not null,
    ano int not null,
    genero varchar(250) not null,
    avaliacao decimal(3,1) not null,
    poster varchar(250)
) ENGINE=InnoDB default CHARSET=utf8;

select * from atividade;
-- script de criação do banco de dados