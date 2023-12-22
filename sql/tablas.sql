create database desis;

-- Creación de la tabla `region`
CREATE TABLE region (
  id INT NOT NULL AUTO_INCREMENT COMMENT 'ID único',
  nombre VARCHAR(60) NOT NULL,
  str_romano VARCHAR(5),
  num_provincias INT NOT NULL COMMENT 'Total provincias',
  num_comunas INT NOT NULL COMMENT 'Total de comunas',
  PRIMARY KEY (id)
) COMMENT 'Tabla de regiones de Chile';

-- Creación de la tabla `comuna`
CREATE TABLE comuna (
  id INT NOT NULL AUTO_INCREMENT,
  id_region INT NOT NULL,
  nombre VARCHAR(30) NOT NULL ,
  num_comunas INT NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (id_region) REFERENCES region(id)
) COMMENT 'Tabla de comunas de Chile';

-- Creación de la tabla `candidato`
CREATE TABLE candidato (
  id INT NOT NULL AUTO_INCREMENT,
  nombres VARCHAR(255) NOT NULL,
  apellidos VARCHAR(255) NOT NULL,
  edad INT NOT NULL,
  sexo VARCHAR(1) NOT NULL,
  PRIMARY KEY (id)
) COMMENT 'Tabla de candidatos';

-- Creación de la tabla `votacion`
CREATE TABLE votacion (
  nombres VARCHAR(255) NOT NULL,
  alias VARCHAR(255) DEFAULT NULL,
  rut VARCHAR(12) NOT NULL,
  email VARCHAR(255) NOT NULL,
  id_region INT NOT NULL,
  id_comuna INT NOT NULL,
  id_candidato INT NOT NULL,
  medio VARCHAR(255) NOT NULL,
  PRIMARY KEY (rut),
  FOREIGN KEY (id_region) REFERENCES region(id),
  FOREIGN KEY (id_comuna) REFERENCES comuna(id),
  FOREIGN KEY (id_candidato) REFERENCES candidato(id)
) COMMENT 'Tabla de votaciones';


INSERT INTO region VALUES 	(1,'ARICA Y PARINACOTA','XV',2,4),
				(2,'TARAPACÁ','I',2,7),
				(3,'ANTOFAGASTA','II',3,9),
				(4,'ATACAMA ','III',3,9),
				(5,'COQUIMBO ','IV',3,15),
				(6,'VALPARAÍSO ','V',8,38),
				(7,'DEL LIBERTADOR GRAL. BERNARDO OHIGGINS','VI',3,33),
				(8,'DEL MAULE','VII',4,30),
				(9,'DEL BIOBÍO ','VIII',4,54),
				(10,'DE LA ARAUCANÍA','IX',2,32),
				(11,'DE LOS RÍOS','XIV',2,12),
				(12,'DE LOS LAGOS','X',4,30),
				(13,'AISÉN DEL GRAL. CARLOS IBAÑEZ DEL CAMPO ','XI',4,10),
				(14,'MAGALLANES Y DE LA ANTÁRTICA CHILENA','XII',4,11),
				(15,'METROPOLITANA DE SANTIAGO','RM',6,52);

INSERT INTO comuna VALUES 	(1,1,'ARICA',2),
					(2,1,'PARINACOTA',2),
					(3,2,'IQUIQUE',2),
					(4,2,'TAMARUGAL',5),
					(5,3,'ANTOFAGASTA',4),
					(6,3,'EL LOA',3),
					(7,3,'TOCOPILLA',2),
					(8,4,'COPIAPÓ',3),
					(9,4,'CHAÑARAL',2),
					(10,4,'HUASCO',4),
					(11,5,'ELQUI',6),
					(12,5,'CHOAPA',4),
					(13,5,'LIMARÍ',5),
					(14,6,'VALPARAÍSO',7),
					(15,6,'ISLA DE PASCUA',1),
					(16,6,'LOS ANDES',4),
					(17,6,'PETORCA',5),
					(18,6,'QUILLOTA',5),
					(19,6,'SAN ANTONIO',6),
					(20,6,'SAN FELIPE DE ACONCAGUA',6),
					(21,6,'MARGA MARGA',4),
					(22,7,'CACHAPOAL',17),
					(23,7,'CARDENAL CARO',6),
					(24,7,'COLCHAGUA',10),
					(25,8,'TALCA',10),
					(26,8,'CAUQUENES',3),
					(27,8,'CURICÓ',9),
					(28,8,'LINARES',8),
					(29,9,'CONCEPCIÓN',12),
					(30,9,'ARAUCO',7),
					(31,9,'BIOBÍO',14),
					(32,9,'ÑUBLE',21),
					(33,10,'CAUTÍN',21),
					(34,10,'MALLECO',11),
					(35,11,'VALDIVIA',8),
					(36,11,'RANCO',4),
					(37,12,'LLANQUIHUE',9),
					(38,12,'CHILOÉ',10),
					(39,12,'OSORNO',7),
					(40,12,'PALENA',4),
					(41,13,'COIHAIQUE',2),
					(42,13,'AISÉN',3),
					(43,13,'CAPITÁN PRAT',3),
					(44,13,'GENERAL CARRERA',2),
					(45,14,'MAGALLANES',4),
					(46,14,'ANTÁRTICA CHILENA',2),
					(47,14,'TIERRA DEL FUEGO',3),
					(48,14,'ULTIMA ESPERANZA',2),
					(49,15,'SANTIAGO',32),
					(50,15,'CORDILLERA',3),
					(51,15,'CHACABUCO',3),
					(52,15,'MAIPO',4),
					(53,15,'MELIPILLA',5),
					(54,15,'TALAGANTE',5);


INSERT INTO candidato (nombres, apellidos, edad, sexo) VALUES
('José', 'Pérez', 45, 'M'),
('María', 'González', 38, 'F'),
('Pedro', 'Silva', 52, 'M'),
('Ana', 'López', 29, 'F');
