create database siga;
use siga;

create table atividade(
id int auto_increment primary key,
descricao varchar(250),
peso decimal(16,2),
anexo varchar(250) );


create table usuario(
id int auto_increment primary key,
nome varchar(250),
email varchar(250),
senha varchar(250),
matricula varchar(250),
contato varchar(250) );

create table filme(
id int auto_increment primary key,
titulo varchar(250),
diretor varchar(250),
ano int,
genero varchar (250),
avaliacao decimal(16,2),
poster varchar(250)
);

select * from atividade;
-- script de criação do banco de dados