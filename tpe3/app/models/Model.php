<?php

class Model {
    protected $db;

    function __construct() {
            $this->db = new PDO('mysql:host='. MYSQL_HOST .';dbname='. MYSQL_DB .';charset=utf8', MYSQL_USER, MYSQL_PASS);
            $this->deploy();

    }

    private function deploy() {
        $query = $this->db->query('SHOW TABLES');
        $tables = $query->fetchAll();
        if(count($tables) == 0) {
            $sql =<<<END
            --
            -- Estructura de tabla para la tabla `albumes`
            --

            CREATE TABLE `albumes` (
            `id` int(11) NOT NULL,
            `nombre` varchar(150) NOT NULL,
            `anio_lanzamiento` int(150) NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

            --
            -- Volcado de datos para la tabla `albumes`
            --

            INSERT INTO `albumes` (`id`, `nombre`, `anio_lanzamiento`) VALUES
            (31, 'abbey road', 1969);

            -- --------------------------------------------------------

            --
            -- Estructura de tabla para la tabla `canciones`
            --

            CREATE TABLE `canciones` (
            `id` int(11) NOT NULL,
            `id_album` int(11) NOT NULL,
            `nombre` varchar(150) NOT NULL,
            `duracion` int(11) NOT NULL,
            `letra_explicita` tinyint(1) NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

            --
            -- Volcado de datos para la tabla `canciones`
            --

            INSERT INTO `canciones` (`id`, `id_album`, `nombre`, `duracion`, `letra_explicita`) VALUES
            (74, 31, 'oh darling', 33, 0);

            -- --------------------------------------------------------

            --
            -- Estructura de tabla para la tabla `comentarios`
            --

            CREATE TABLE `comentarios` (
            `id` int(11) NOT NULL,
            `fecha` date NOT NULL,
            `autor` varchar(200) NOT NULL,
            `mensaje` varchar(500) NOT NULL,
            `valoracion` int(11) NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

            --
            -- Volcado de datos para la tabla `comentarios`
            --

            INSERT INTO `comentarios` (`id`, `fecha`, `autor`, `mensaje`, `valoracion`) VALUES
            (3, '2030-12-12', 'Maxy Machado', 'Muy buena selección de álbumes', 8),
            (4, '2028-11-03', 'Facundo Machado', 'La interfaz es simple y cómoda.', 10);

            -- --------------------------------------------------------

            --
            -- Estructura de tabla para la tabla `usuarios`
            --

            CREATE TABLE `usuarios` (
            `id` int(11) NOT NULL,
            `nombre` varchar(150) NOT NULL,
            `email` varchar(150) NOT NULL,
            `contrasenia` varchar(250) NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

            --
            -- Volcado de datos para la tabla `usuarios`
            --

            INSERT INTO `usuarios` (`id`, `nombre`, `email`, `contrasenia`) VALUES
            (1, 'webadmin', '', '$2y$10\$LAhEQvdSkFR51Lo98oAM6uIG4vedZwY9RgOmSrxmv3CCbnQ7RgaFK');
            
                                
            --
            -- Índices para tablas volcadas
            --

            --
            -- Indices de la tabla `albumes`
            --
            ALTER TABLE `albumes`
            ADD PRIMARY KEY (`id`);

            --
            -- Indices de la tabla `canciones`
            --
            ALTER TABLE `canciones`
            ADD PRIMARY KEY (`id`),
            ADD KEY `id_album` (`id_album`);

            --
            -- Indices de la tabla `comentarios`
            --
            ALTER TABLE `comentarios`
            ADD PRIMARY KEY (`id`);

            --
            -- Indices de la tabla `usuarios`
            --
            ALTER TABLE `usuarios`
            ADD PRIMARY KEY (`id`),
            ADD UNIQUE KEY `email` (`email`);

            --
            -- AUTO_INCREMENT de las tablas volcadas
            --

            --
            -- AUTO_INCREMENT de la tabla `albumes`
            --
            ALTER TABLE `albumes`
            MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

            --
            -- AUTO_INCREMENT de la tabla `canciones`
            --
            ALTER TABLE `canciones`
            MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

            --
            -- AUTO_INCREMENT de la tabla `comentarios`
            --
            ALTER TABLE `comentarios`
            MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

            --
            -- AUTO_INCREMENT de la tabla `usuarios`
            --
            ALTER TABLE `usuarios`
            MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

            --
            -- Restricciones para tablas volcadas
            --

            --
            -- Filtros para la tabla `canciones`
            --
            ALTER TABLE `canciones`
            ADD CONSTRAINT `canciones_ibfk_1` FOREIGN KEY (`id_album`) REFERENCES `albumes` (`id`) ON UPDATE CASCADE;
            COMMIT;

            /*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
            /*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
            /*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

            END;
            $this->db->query($sql);
        }
    }

}