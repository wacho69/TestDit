create table examen(
	idexamen int not null primary key auto_increment,
	nombre varchar(255) not null,
	numero_preguntas int not null,
	fecha_registro datetime
);	


create table detalle_examen_preguntas(
	idddetalle_examen_preguntas int not null primary key auto_increment,
	idexamen int not null,
	descripcion_pregunta text not null,
	fecha_registro datetime
);



create table detalle_examen_respuesta(
	iddetalle_examen_respuesta int not null primary key auto_increment,
	idddetalle_examen_preguntas int not null,
	idexamen int not null,
	descripcion_respuesta text not null,
	correcta int default '0',
	respuesta int null,
	fecha_registro datetime
);