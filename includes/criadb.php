<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require 'conexao.php';
ibase_query($conexao, 'DROP TABLE comentarios');
ibase_query($conexao,
        'create table comentarios (id int not null primary key, 
        usuario_id int not null,
        postagem_id int not null,
        texto nchar not null,
        data timestamp default current_timestamp,
        ativo smallint default 1)');
ibase_query($conexao, 'DROP TABLE usuarios');
ibase_query($conexao,
        'create table usuarios (id int not null primary key, 
        nome varchar(30) not null,
        email varchar(50) not null,
        senha varchar(40) not null,
        token varchar(40),
        data timestamp default current_timestamp,
        ativo smallint default 1)');
ibase_query($conexao, 'DROP TABLE postagens');
ibase_query($conexao,
        'create table postagens (id int not null primary key, 
        pagina_id int not null,
        autor_id int not null,
        titulo varchar(255) not null,
        texto blob sub_type 0 not null,
        tags varchar(255),
        data timestamp default current_timestamp,
        ativo smallint default 1)');
ibase_query($conexao, 'DROP TABLE paginas');
ibase_query($conexao,
        'create table paginas (id int not null primary key, 
        nome varchar(30) not null,
        menu varchar(30) not null,
        slug varchar(255) not null,
        ordenacao int default 0,
        data timestamp default current_timestamp,
        ativo smallint default 1)');
ibase_query($conexao, 'DROP TABLE newsletters');
ibase_query($conexao,
        'create table newsletters (id int not null primary key, 
        nome varchar(30) not null,
        email varchar(50) not null,
        data timestamp default current_timestamp,
        ativo smallint default 1)');
