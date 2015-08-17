create table comentarios (id int not null primary key, 
        usuario_id int not null,
        postagem_id int not null,
        texto blob sub_type 0 not null,
        data timestamp default current_timestamp,
        ativo smallint default 1);

create table usuarios (id int not null primary key, 
        nome varchar(30) not null,
        email varchar(50) not null,
        senha varchar(40) not null,
        token varchar(40) not null,
        data timestamp default current_timestamp,
        ativo smallint default 1);

insert into usuarios (id, nome, email, senha) VALUES (1, 'Admin', 'admin@localhost.com', '10470c3b4b1fed12c3baac014be15fac67c6e815');

create table postagens (id int not null primary key, 
        pagina_id int not null,
        autor_id int not null,
        titulo varchar(255) not null,
        texto blob sub_type 0 not null,
        tags varchar(255),
        data timestamp default current_timestamp,
        ativo smallint default 1);

create table paginas (id int not null primary key, 
        nome varchar(30) not null,
        menu varchar(30) not null,
        slug varchar(255) not null,
        data timestamp default current_timestamp,
        ativo smallint default 1);

create table newsletters (id int not null primary key, 
        nome varchar(100) not null,
        email varchar(100) not null,
        data timestamp default current_timestamp,
        ativo smallint default 1);