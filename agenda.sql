create database agenda;
use agenda;

create table contactos (
	id int auto_increment primary key,
    nombre varchar(30) not null,
    direccion varchar(100) null,
    email varchar(255) null,
    foto varchar(255) null);
    
create table telefonos(
	id int auto_increment primary key,
    id_Contacto int not null,
    telefono varchar(20) not null,
    descripcion varchar(50) not null,
    foreign key(id_Contacto) references contactos(id) on delete cascade);
    
    select * from contactos;
    select * from telefonos;
    
    SET FOREIGN_KEY_CHECKS = 0; 
TRUNCATE contactos;
truncate telefonos; 
SET FOREIGN_KEY_CHECKS = 1;
