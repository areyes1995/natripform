-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         8.0.30 - MySQL Community Server - GPL
-- SO del servidor:              Win64
-- HeidiSQL Versión:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Volcando estructura para tabla consulations.answers
CREATE TABLE IF NOT EXISTS `answers` (
  `answer_id` int NOT NULL AUTO_INCREMENT,
  `consultation_id` bigint NOT NULL,
  `ask_id` bigint NOT NULL,
  `answer` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime NOT NULL,
  PRIMARY KEY (`answer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla consulations.answers: ~0 rows (aproximadamente)

-- Volcando estructura para tabla consulations.consultations
CREATE TABLE IF NOT EXISTS `consultations` (
  `consultation_id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `last_name` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `cedula` varchar(50) NOT NULL,
  `phone` varchar(17) NOT NULL,
  `cellphone` varchar(17) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `email` varchar(50) NOT NULL,
  `natrip_id` bigint DEFAULT NULL,
  `status` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `approved_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`consultation_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla consulations.consultations: ~0 rows (aproximadamente)

-- Volcando estructura para tabla consulations.preguntas
CREATE TABLE IF NOT EXISTS `preguntas` (
  `pregunta_id` int NOT NULL AUTO_INCREMENT,
  `ask` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `correct` text NOT NULL,
  `type` text CHARACTER SET latin1 COLLATE latin1_swedish_ci,
  PRIMARY KEY (`pregunta_id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla consulations.preguntas: ~41 rows (aproximadamente)
REPLACE INTO `preguntas` (`pregunta_id`, `ask`, `correct`, `type`) VALUES
	(1, '¿Cuál es el propósito principal de tu viaje a Estados Unidos?', '', ''),
	(2, '¿Cuánto tiempo planeas quedarte en Estados Unidos?', '', ''),
	(3, '¿Tienes algún familiar o amigo en Estados Unidos que te pueda proporcionar apoyo durante tu estadía?', '', ''),
	(4, '¿Tienes algún plan específico para tu visita a Estados Unidos?', '', ''),
	(5, '¿Qué actividades o eventos tienes planeados durante tu estancia en Estados Unidos?', '', ''),
	(6, '¿Has visitado Estados Unidos anteriormente? Si es así, ¿Cuántas veces y por qué motivo?', '', ''),
	(7, '¿Tienes empleo o negocios estables en tu país de origen?', '', ''),
	(8, '¿Has viajado a otros países anteriormente? Si es así, ¿puedes proporcionar detalles sobre esos viajes?', '', ''),
	(9, '¿Posees propiedades o bienes en tu país de origen?', '', 'radio'),
	(10, '¿Cuál es tu profesión actual y en qué empresa trabajas?', '', ''),
	(11, '¿Has realizado estudios o cursos de formación relevantes para tu ocupación actual?', '', ''),
	(12, '¿Tienes algún título académico o certificación profesional?', '', ''),
	(13, '¿Has sido invitado a participar en conferencias, seminarios o eventos en Estados Unidos?', '', ''),
	(14, '¿Cuál es tu historial de empleo y cuánto tiempo has trabajado en tu empleo actual?', '', ''),
	(15, '¿Has participado en actividades comunitarias o benéficas en tu país de origen?', '', ''),
	(16, '¿CuÃ¡les son tus lazos familiares y sociales en tu país de origen?', '', ''),
	(17, '¿Cuentas con recursos financieros suficientes para cubrir los gastos de tu viaje y estancia en Estados Unidos?', '', ''),
	(18, '¿Has cumplido con las leyes de inmigración en tus viajes anteriores a otros países?', '', ''),
	(19, '¿Has recibido alguna beca o premio académico o profesional?', '', ''),
	(20, '¿Tienes algún plan de regreso establecido a tu país de origen después de tu visita a Estados Unidos?', '', ''),
	(21, '¿Tienes intenciones de buscar empleo en Estados Unidos durante tu estadía?', '0', 'radio'),
	(22, '¿Has sido deportado o expulsado de algún país en el pasado?', '0', 'radio'),
	(23, '¿Has permanecido más tiempo del permitido en otro país durante visitas anteriores?', '0', 'radio'),
	(24, '¿Has estado involucrado en actividades delictivas en tu país de origen o en otros países?', '0', 'radio'),
	(25, '¿Tienes antecedentes penales o has sido arrestado alguna vez?', '0', 'radio'),
	(26, '¿Has intentado ingresar ilegalmente a algín país en el pasado?', '0', 'radio'),
	(27, '¿Has sido rechazado previamente para obtener una visa a Estados Unidos u otro país?', '0', 'radio'),
	(28, '¿Tienes algún tipo de enfermedad o condiciún médica que pueda representar un riesgo para la salud pública en Estados Unidos?', '0', 'radio'),
	(29, '¿Has sido investigado o acusado de estar involucrado en actividades terroristas?', '0', 'radio'),
	(30, '¿Has sido investigado o acusado de estar involucrado en actividades terroristas?', '0', 'radio'),
	(31, '¿Has mentido o proporcionado información falsa en solicitudes de visa anteriores?', '0', 'radio'),
	(32, '¿Tienes vínculos con organizaciones criminales o grupos extremistas?', '0', 'radio'),
	(33, '¿Has trabajado o realizado actividades no autorizadas en Estados Unidos durante visitas anteriores?', '0', 'radio'),
	(34, '¿Has violado las leyes de inmigración en otros países?', '0', 'radio'),
	(35, '¿Has solicitado asilo en algún país anteriormente?', '0', 'radio'),
	(36, '¿Has utilizado documentos de identidad falsos o fraudulentos?', '0', 'radio'),
	(37, '¿Has estado implicado en casos de fraude o corrupción en tu país de origen?', '0', 'radio'),
	(38, '¿Tienes deudas significativas o problemas financieros graves?', '0', 'radio'),
	(39, '¿Has participado en actividades ilegales relacionadas con drogas o sustancias controladas?', '0', 'radio'),
	(40, '¿Has sido previamente denegado en solicitudes de visa a Estados Unidos por razones de inmigración?', '0', 'radio'),
	(41, '¿Has falsificado documentos o proporcionado información falsa en tu solicitud de visa actual?', '0', 'radio');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
