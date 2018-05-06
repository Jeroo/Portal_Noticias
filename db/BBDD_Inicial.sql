CREATE DATABASE db_ejercicio CHARACTER SET utf8 COLLATE utf8_spanish_ci;
CREATE USER 'user_ejercicio';

CREATE TABLE db_ejercicio.login(  
usuario VARCHAR(40) CHARACTER SET utf8 COLLATE utf8_spanish_ci,
password VARCHAR(40) CHARACTER SET utf8 COLLATE utf8_spanish_ci,
PRIMARY KEY (usuario), UNIQUE KEY login (usuario)
)ENGINE= MyISAM DEFAULT CHARSET=utf8;

GRANT ALL PRIVILEGES ON db_ejercicio.* TO 'user_ejercicio'@'localhost' IDENTIFIED BY 'pass_ejercicio';

INSERT INTO `db_ejercicio`.`login` (`usuario` ,`password`)VALUES ('admin', 'admin');


CREATE TABLE db_ejercicio.comentarios(
nombre text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
texto  text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
tiempo datetime NOT NULL
) ENGINE= MyISAM DEFAULT CHARSET=utf8;

GRANT ALL PRIVILEGES ON db_ejercicio.* TO 'user_ejercicio'@'localhost' IDENTIFIED BY 'pass_ejercicio';


CREATE TABLE db_ejercicio.noticias(
texto text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL
) ENGINE= MyISAM CHARACTER SET utf8 COLLATE utf8_spanish_ci;



INSERT INTO db_ejercicio.noticias (texto) VALUES ('El director de la Agencia de Seguridad Nacional de Estados Unidos, (NSA, por sus siglas anglosajonas), Keith Alexander, sostuvo que la mejor manera de proteger a EEUU ante las posibles amenazas exteriores es mediante el uso de programas de vigilancia que tengan como objetivo recabar millones de comunicaciones en el mundo.

"Nadie ha encontrado una manera mejor", sostuvo Alexander ante la Judicatura del Senado, solicitando a los legisladores no abolir los programas de recogida masiva de datos de la agencia.');