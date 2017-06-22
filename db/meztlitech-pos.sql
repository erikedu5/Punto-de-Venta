create database meztlitech_pos;
use meztlitech_pos;


create table usuarios(
id_usuario bigint unsigned auto_increment not null,
nombres varchar(45),
apellido_paterno varchar(45),
apellido_materno varchar(45),
fecha_registro timestamp,
fecha_actualizar timestamp,
primary key(id_usuario))engine = InnoDB;

create table proveedor(
id_proveedor int auto_increment not null,
nombre_proveedor varchar(60),
primary key(id_proveedor)) engine = InnoDB;


create table productos(
id_producto int unsigned auto_increment not null,
codigo_product text,
precio_unitario float default 0.00,
precio_venta float default 0.00,
id_proveedor int,
primary key(id_producto),
foreign key(id_proveedor) references proveedor(id_proveedor))engine = InnoDB;

create table compras(
id_compra bigint unsigned auto_increment not null,
total_compra float default 0.00,
fecha_compra datetime,
primary key(id_compra))engine = InnoDB;


create table detalle_compra(
id_compra bigint unsigned,
id_producto int unsigned,
cantidad int,
importe float default 0.00,
subtotal float default 0.00,
foreign key(id_compra) references compras(id_compra),
foreign key(id_producto) references productos(id_producto))engine = InnoDB;


create table ventas(
id_venta bigint unsigned auto_increment,
total_venta float default 0.00,
fecha_venta datetime,
primary key(id_venta))engine = InnoDB;

create table detalle_venta(
id_venta bigint unsigned,
id_producto int unsigned,
total float default 0.00,
fecha_venta datetime,
foreign key(id_venta) references ventas(id_venta),
foreign key(id_producto) references productos(id_producto))engine = InnoDB;