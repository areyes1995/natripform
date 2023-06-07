-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 07-06-2023 a las 00:28:30
-- Versión del servidor: 10.6.13-MariaDB
-- Versión de PHP: 8.1.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `agenciad_consulation`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `answers`
--

CREATE TABLE `answers` (
  `answer_id` int(11) NOT NULL,
  `consultation_id` bigint(20) NOT NULL,
  `ask_id` bigint(20) NOT NULL,
  `answer` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consultations`
--

CREATE TABLE `consultations` (
  `consultation_id` int(255) NOT NULL,
  `name` varchar(50) NOT NULL,
  `last_name` int(50) NOT NULL,
  `cedula` varchar(50) NOT NULL,
  `phone` varchar(17) NOT NULL,
  `cellphone` varchar(17) NOT NULL,
  `natrip_id` bigint(20) NOT NULL,
  `approved_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `consultations`
--

INSERT INTO `consultations` (`consultation_id`, `name`, `last_name`, `cedula`, `phone`, `cellphone`, `natrip_id`, `approved_at`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'abiezer', 0, '03105686210', '8498757724', '', 1000000, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 'abiezer', 0, '03105686210', '8498757724', '', 1000000, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 'abiezer', 0, '03105686210', '8498757724', '', 1000000, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 'abiezer', 0, '03105686210', '8498757724', '', 1000000, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `preguntas`
--

CREATE TABLE `preguntas` (
  `pregunta_id` int(11) NOT NULL,
  `ask` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `correct` text NOT NULL,
  `type` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `preguntas`
--

INSERT INTO `preguntas` (`pregunta_id`, `ask`, `correct`, `type`) VALUES
(1, 'Â¿CuÃ¡l es el propÃ³sito principal de tu viaje a Estados Unidos?', '', ''),
(2, 'Â¿CuÃ¡nto tiempo planeas quedarte en Estados Unidos?', '', ''),
(3, 'Â¿Tienes algÃºn familiar o amigo en Estados Unidos que te pueda proporcionar apoyo durante tu estadÃ­a?', '', ''),
(4, 'Â¿Tienes algÃºn plan especÃ­fico para tu visita a Estados Unidos?', '', ''),
(5, 'Â¿QuÃ© actividades o eventos tienes planeados durante tu estancia en Estados Unidos?', '', ''),
(6, 'Â¿Has visitado Estados Unidos anteriormente? Si es asÃ­, Â¿CuÃ¡ntas veces y por quÃ© motivo?', '', ''),
(7, 'Â¿Tienes empleo o negocios estables en tu paÃ­s de origen?', '', ''),
(8, 'Â¿Has viajado a otros paÃ­ses anteriormente? Si es asÃ­, Â¿puedes proporcionar detalles sobre esos viajes?', '', ''),
(9, 'Â¿Posees propiedades o bienes en tu paÃ­s de origen?', '', 'check'),
(10, 'Â¿CuÃ¡l es tu profesiÃ³n actual y en quÃ© empresa trabajas?', '', ''),
(11, 'Â¿Has realizado estudios o cursos de formaciÃ³n relevantes para tu ocupaciÃ³n actual?', '', ''),
(12, 'Â¿Tienes algÃºn tÃ­tulo acadÃ©mico o certificaciÃ³n profesional?', '', ''),
(13, 'Â¿Has sido invitado a participar en conferencias, seminarios o eventos en Estados Unidos?', '', ''),
(14, 'Â¿CuÃ¡l es tu historial de empleo y cuÃ¡nto tiempo has trabajado en tu empleo actual?', '', ''),
(15, 'Â¿Has participado en actividades comunitarias o benÃ©ficas en tu paÃ­s de origen?', '', ''),
(16, 'Â¿CuÃ¡les son tus lazos familiares y sociales en tu paÃ­s de origen?', '', ''),
(17, 'Â¿Cuentas con recursos financieros suficientes para cubrir los gastos de tu viaje y estancia en Estados Unidos?', '', ''),
(18, 'Â¿Has cumplido con las leyes de inmigraciÃ³n en tus viajes anteriores a otros paÃ­ses?', '', ''),
(19, 'Â¿Has recibido alguna beca o premio acadÃ©mico o profesional?', '', ''),
(20, 'Â¿Tienes algÃºn plan de regreso establecido a tu paÃ­s de origen despuÃ©s de tu visita a Estados Unidos?', '', ''),
(21, 'Â¿Tienes intenciones de buscar empleo en Estados Unidos durante tu estadÃ­a?', '0', 'check'),
(22, 'Â¿Has sido deportado o expulsado de algÃºn paÃ­s en el pasado?', '0', 'check'),
(23, 'Â¿Has permanecido mÃ¡s tiempo del permitido en otro paÃ­s durante visitas anteriores?', '0', 'check'),
(24, 'Â¿Has estado involucrado en actividades delictivas en tu paÃ­s de origen o en otros paÃ­ses?', '0', 'check'),
(25, 'Â¿Tienes antecedentes penales o has sido arrestado alguna vez?', '0', 'check'),
(26, 'Â¿Has intentado ingresar ilegalmente a algÃºn paÃ­s en el pasado?', '0', 'check'),
(27, 'Â¿Has sido rechazado previamente para obtener una visa a Estados Unidos u otro paÃ­s?', '0', 'check'),
(28, 'Â¿Tienes algÃºn tipo de enfermedad o condiciÃ³n mÃ©dica que pueda representar un riesgo para la salud pÃºblica en Estados Unidos?', '0', 'check'),
(29, 'Â¿Has sido investigado o acusado de estar involucrado en actividades terroristas?', '0', 'check'),
(30, 'Â¿Has sido investigado o acusado de estar involucrado en actividades terroristas?', '0', 'check'),
(31, 'Â¿Has mentido o proporcionado informaciÃ³n falsa en solicitudes de visa anteriores?', '0', 'check'),
(32, 'Â¿Tienes vÃ­nculos con organizaciones criminales o grupos extremistas?', '0', 'check'),
(33, 'Â¿Has trabajado o realizado actividades no autorizadas en Estados Unidos durante visitas anteriores?', '0', 'check'),
(34, 'Â¿Has violado las leyes de inmigraciÃ³n en otros paÃ­ses?', '0', 'check'),
(35, 'Â¿Has solicitado asilo en algÃºn paÃ­s anteriormente?', '0', 'check'),
(36, 'Â¿Has utilizado documentos de identidad falsos o fraudulentos?', '0', 'check'),
(37, 'Â¿Has estado implicado en casos de fraude o corrupciÃ³n en tu paÃ­s de origen?', '0', 'check'),
(38, 'Â¿Tienes deudas significativas o problemas financieros graves?', '0', 'check'),
(39, 'Â¿Has participado en actividades ilegales relacionadas con drogas o sustancias controladas?', '0', 'check'),
(40, 'Â¿Has sido previamente denegado en solicitudes de visa a Estados Unidos por razones de inmigraciÃ³n?', '0', 'check'),
(41, 'Â¿Has falsificado documentos o proporcionado informaciÃ³n falsa en tu solicitud de visa actual?', '0', 'check');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`answer_id`);

--
-- Indices de la tabla `consultations`
--
ALTER TABLE `consultations`
  ADD PRIMARY KEY (`consultation_id`);

--
-- Indices de la tabla `preguntas`
--
ALTER TABLE `preguntas`
  ADD PRIMARY KEY (`pregunta_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `answers`
--
ALTER TABLE `answers`
  MODIFY `answer_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `consultations`
--
ALTER TABLE `consultations`
  MODIFY `consultation_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `preguntas`
--
ALTER TABLE `preguntas`
  MODIFY `pregunta_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
