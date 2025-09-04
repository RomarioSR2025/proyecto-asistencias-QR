CREATE DATABASE IF NOT EXISTS asistencia;
USE asistencia;

-- 1
CREATE TABLE IF NOT EXISTS personas (
    idpersona INT AUTO_INCREMENT PRIMARY KEY,
    apepaterno VARCHAR(50),
    apematerno VARCHAR(50),
    nombres VARCHAR(100),
    tipodoc VARCHAR(20),
    numerodoc VARCHAR(20) UNIQUE,
    direccion VARCHAR(150),
    telefono VARCHAR(20),
    email VARCHAR(100),
    fecha_nacimiento DATE,
    sexo ENUM('M','F','Otro'),
    imagenperfil TEXT
) ENGINE = INNODB;

-- 2
CREATE TABLE IF NOT EXISTS usuarios (
    idusuario INT AUTO_INCREMENT PRIMARY KEY,
    idpersona INT,
    nomuser VARCHAR(50) UNIQUE,
    passuser VARCHAR(100),
    estado ENUM('Activo','Inactivo') DEFAULT 'Activo',
    FOREIGN KEY (idpersona) REFERENCES personas(idpersona)
) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS roles (
    idrol INT AUTO_INCREMENT PRIMARY KEY,
    rol VARCHAR(50) NOT NULL,
    descripcion VARCHAR(150)
) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS usuario_rol (
    idusuario INT,
    idrol INT,
    PRIMARY KEY (idusuario, idrol),
    FOREIGN KEY (idusuario) REFERENCES usuarios(idusuario),
    FOREIGN KEY (idrol) REFERENCES roles(idrol)
) ENGINE = InnoDB;

-- 3
CREATE TABLE IF NOT EXISTS calendarizaciones (
    idcalendarizacion INT AUTO_INCREMENT PRIMARY KEY,
    fechainicio DATE,
    fechafin DATE,
    horainicio TIME,
    horafin TIME
) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS grupos (
    idgrupo INT AUTO_INCREMENT PRIMARY KEY,
    alectivo VARCHAR(20),
    nivel VARCHAR(20),
    grado VARCHAR(20),
    seccion VARCHAR(10),
    idcalendarizacion INT,
    FOREIGN KEY (idcalendarizacion) REFERENCES calendarizaciones(idcalendarizacion)
) ENGINE = InnoDB;

-- 4
CREATE TABLE IF NOT EXISTS matriculas (
    idmatricula INT AUTO_INCREMENT PRIMARY KEY,
    idalumno INT,
    idgrupo INT,
    fechamatricula DATE,
    estado ENUM('Activo','Inactivo') DEFAULT 'Activo',
    idapoderado INT,
    parentesco VARCHAR(50),
    anio_escolar YEAR,
    turno ENUM('Mañana','Tarde'),
    codigo_qr VARCHAR(100) UNIQUE,   -- código QR para fotocheck
    FOREIGN KEY (idalumno) REFERENCES personas(idpersona),
    FOREIGN KEY (idapoderado) REFERENCES personas(idpersona),
    FOREIGN KEY (idgrupo) REFERENCES grupos(idgrupo)
) ENGINE = InnoDB;

-- 5
CREATE TABLE IF NOT EXISTS asistencia (
    idasistencia INT AUTO_INCREMENT PRIMARY KEY,
    idmatricula INT,
    fecha DATE NOT NULL,
    hentrada TIME,
    hsalida TIME,
    mintardanza INT,
    estado ENUM('Asistió','Falta','Tardanza','Justificado') DEFAULT 'Asistió',
    metodo ENUM('QR','Manual') DEFAULT 'QR',
    UNIQUE (idmatricula, fecha), -- evita doble registro el mismo día
    FOREIGN KEY (idmatricula) REFERENCES matriculas(idmatricula)
) ENGINE = InnoDB;

-- 6
CREATE TABLE IF NOT EXISTS justificaciones (
    idjustificacion INT AUTO_INCREMENT PRIMARY KEY,
    justificacion VARCHAR(150)
) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS permisos (
    idpermiso INT AUTO_INCREMENT PRIMARY KEY,
    idasistencia INT,
    idjustificacion INT,
    idusuarioaprueba INT,
    idapoderado INT,
    parentesco VARCHAR(50),
    comentarios TEXT,
    tipo_permiso ENUM('Salud','Familiar','Cita médica','Viaje'),
    hora_salida TIME,
    hora_retorno TIME,
    archivo VARCHAR(255),
    FOREIGN KEY (idasistencia) REFERENCES asistencia(idasistencia),
    FOREIGN KEY (idjustificacion) REFERENCES justificaciones(idjustificacion),
    FOREIGN KEY (idusuarioaprueba) REFERENCES usuarios(idusuario),
    FOREIGN KEY (idapoderado) REFERENCES personas(idpersona)
) ENGINE = InnoDB;

-- 7
CREATE TABLE IF NOT EXISTS tutorias (
    idtutoria INT AUTO_INCREMENT PRIMARY KEY,
    idmatricula INT,
    idusuario INT, -- tutor responsable
    fecha DATE,
    area ENUM('Académica','Personal-Social','Vocacional','Salud','Convivencia','Cultura'),
    descripcion TEXT,
    observaciones TEXT,
    estado ENUM('Pendiente','Atendida','Derivada') DEFAULT 'Pendiente',
    proxima_cita DATE,
    FOREIGN KEY (idmatricula) REFERENCES matriculas(idmatricula),
    FOREIGN KEY (idusuario) REFERENCES usuarios(idusuario)
) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS tutoria_detalles (
    iddetalle INT AUTO_INCREMENT PRIMARY KEY,
    idtutoria INT,
    tipo ENUM('Test','Informe','Derivación médica','Actividad cultural','Reporte disciplinario'),
    resultado TEXT,
    archivo VARCHAR(255),
    observaciones TEXT,
    FOREIGN KEY (idtutoria) REFERENCES tutorias(idtutoria)
) ENGINE = InnoDB;

-- 8
CREATE TABLE IF NOT EXISTS actividades (
    idactividad INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100),
    descripcion TEXT,
    fecha DATE,
    responsable INT,
    tipo ENUM('Deportivo','Cultural','Científico','Social'),
    lugar VARCHAR(100),
    FOREIGN KEY (responsable) REFERENCES usuarios(idusuario)
) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS actividad_alumno (
    idactividad INT,
    idmatricula INT,
    participacion ENUM('Sí','No'),
    resultado TEXT,
    PRIMARY KEY (idactividad, idmatricula),
    FOREIGN KEY (idactividad) REFERENCES actividades(idactividad),
    FOREIGN KEY (idmatricula) REFERENCES matriculas(idmatricula)
) ENGINE = InnoDB;

-- 9

CREATE TABLE IF NOT EXISTS qr_logs (
    idlog INT AUTO_INCREMENT PRIMARY KEY,
    idmatricula INT,
    fecha DATE,
    hora TIME,
    tipo ENUM('Entrada','Salida'),
    dispositivo VARCHAR(50),
    FOREIGN KEY (idmatricula) REFERENCES matriculas(idmatricula)
) ENGINE = InnoDB;

INSERT INTO personas (apepaterno, apematerno, nombres, tipodoc, numerodoc, direccion, telefono, email, fecha_nacimiento, sexo, imagenperfil)
VALUES 
('García', 'López', 'Juan Carlos', 'DNI', '12345678', 'Av. Principal 123', '987654321', 'juan.garcia@email.com', '2005-04-15', 'M', NULL),
('Martínez', 'Rojas', 'Ana María', 'DNI', '87654321', 'Jr. Las Flores 456', '912345678', 'ana.martinez@email.com', '2006-09-22', 'F', NULL),
('Pérez', 'Ramírez', 'Luis Alberto', 'DNI', '11223344', 'Av. Siempre Viva 789', '999111222', 'luis.perez@email.com', '1980-01-10', 'M', NULL);

INSERT INTO usuarios (idpersona, nomuser, passuser, estado)
VALUES 
(3, 'lperez', '123456', 'Activo'); -- este sería un profesor/tutor

INSERT INTO roles (rol, descripcion)
VALUES 
('Administrador', 'Acceso total al sistema'),
('Docente', 'Encargado de clases y asistencias'),
('Apoderado', 'Padre o tutor del alumno');

INSERT INTO usuario_rol (idusuario, idrol)
VALUES 
(1, 1),  -- lperez es Administrador
(1, 2);  -- y también Docente

INSERT INTO calendarizaciones (fechainicio, fechafin, horainicio, horafin)
VALUES ('2025-03-01', '2025-12-15', '07:30:00', '13:30:00');

INSERT INTO grupos (alectivo, nivel, grado, seccion, idcalendarizacion)
VALUES ('2025', 'Secundaria', '5to', 'A', 1);

INSERT INTO matriculas (idalumno, idgrupo, fechamatricula, estado, idapoderado, parentesco, anio_escolar, turno, codigo_qr)
VALUES 
(1, 1, '2025-02-15', 'Activo', 2, 'Madre', 2025, 'Mañana', 'QR001JUAN'),
(2, 1, '2025-02-15', 'Activo', 3, 'Padre', 2025, 'Mañana', 'QR002ANA');

INSERT INTO asistencia (idmatricula, fecha, hentrada, hsalida, mintardanza, estado, metodo)
VALUES 
(1, '2025-03-01', '07:40:00', '13:25:00', 10, 'Tardanza', 'QR'),
(2, '2025-03-01', '07:28:00', '13:30:00', 0, 'Asistió', 'QR');

INSERT INTO justificaciones (justificacion)
VALUES ('Enfermedad con certificado médico');

INSERT INTO permisos (idasistencia, idjustificacion, idusuarioaprueba, idapoderado, parentesco, comentarios, tipo_permiso, hora_salida, hora_retorno, archivo)
VALUES 
(1, 1, 1, 2, 'Madre', 'El alumno presentó fiebre', 'Salud', '10:00:00', '12:00:00', 'certificado.pdf');

INSERT INTO tutorias (idmatricula, idusuario, fecha, area, descripcion, observaciones, estado, proxima_cita)
VALUES 
(1, 1, '2025-03-05', 'Académica', 'Dificultad en matemáticas', 'Se recomienda refuerzo', 'Pendiente', '2025-03-12');

INSERT INTO actividades (nombre, descripcion, fecha, responsable, tipo, lugar)
VALUES 
('Campeonato de Fútbol', 'Competencia interescolar', '2025-06-20', 1, 'Deportivo', 'Estadio Municipal');

INSERT INTO actividad_alumno (idactividad, idmatricula, participacion, resultado)
VALUES 
(1, 1, 'Sí', 'Goleador del equipo'),
(1, 2, 'No', NULL);

INSERT INTO qr_logs (idmatricula, fecha, hora, tipo, dispositivo)
VALUES 
(1, '2025-03-01', '07:40:05', 'Entrada', 'Lector-1'),
(1, '2025-03-01', '13:25:10', 'Salida', 'Lector-1');

-- Verificar que los datos se insertaron correctamente
SELECT * FROM personas;
SELECT * FROM usuarios;
SELECT * FROM roles;
SELECT * FROM usuario_rol;
SELECT * FROM calendarizaciones;
SELECT * FROM grupos;
SELECT * FROM matriculas;
SELECT * FROM asistencia;
SELECT * FROM justificaciones;
SELECT * FROM permisos;
SELECT * FROM tutorias;
SELECT * FROM tutoria_detalles;
SELECT * FROM actividades;
SELECT * FROM actividad_alumno;
SELECT * FROM qr_logs;