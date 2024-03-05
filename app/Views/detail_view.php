<?php
    include_once "includes/header.php";
    define("SERVER", $_SERVER["HTTP_HOST"]);
?>

<header>
    <h1>
        <?php echo $data["usuario"]["nombre"] . " " . $data["usuario"]["apellidos"]; ?>
    </h1>
    <nav>
        <ul>
            <?php
                if ($data["perfil"] === "invitado") {
                    echo "<a href='http://" . SERVER . "/register'><li>Crear cuenta</li></a>";
                    echo "<a href='http://" . SERVER . "/login'><li>Iniciar sesión</li></a>";
                } else {
                    echo "<a href='http://" . SERVER . "/edit'><li>Editar perfil</li></a>";
                    echo "<a href='http://" . SERVER . "/logout'><li>Cerrar sesión</li></a>";
                }
            ?>
            <a href="../">
                <li>Atrás</li>
            </a>
        </ul>
    </nav>
</header>
<main>
    <section>
        <article class="jobs">
            <h2>Trabajos</h2>
            <?php
            # Verificar si existe la clave 'trabajos' en $data
            if (sizeof($data["trabajos"]) > 0) {
                $trabajos = $data["trabajos"];

                # Verificar si $trabajos es nulo o no
                if (is_null($trabajos)) {
                    echo "<p>Sin experiencia laboral</p>";
                } else {
                    # Verificar si $trabajos es un array o un solo trabajo
                    if (isset($trabajos[0])) {
                        foreach ($trabajos as $trabajo) {
                            if ($trabajo["visible"] == 1) {
                                echo "<h3>" . $trabajo["titulo"] . "</h3>";
                                echo "<p><strong>Descripción:</strong> " . $trabajo["descripcion"] . "</p>";
                                $fechaInicio = date("d-m-Y", strtotime($trabajo["fecha_inicio"]));
                                $fechaFinal = $trabajo["fecha_final"] === null
                                    ? "Actualidad" : date("d-m-Y", strtotime($trabajo["fecha_final"]));
                                echo "<p>" . $fechaInicio . " / " . $fechaFinal . "</p>";
                                echo "<p><strong>Logros:</strong> " . $trabajo["logros"] . "</p>";
                            }
                        }
                    } else {
                        # Si $trabajos es solo un trabajo, mostrar la información directamente
                        if ($trabajos["visible"] == 1) {
                            echo "<h3>" . $trabajos["titulo"] . "</h3>";
                            echo "<p><strong>Descripción:</strong> " . $trabajos["descripcion"] . "</p>";
                            $fechaInicio = date("d-m-Y", strtotime($trabajos["fecha_inicio"]));
                            $fechaFinal = $trabajos["fecha_final"] === null
                                ? "Actualidad" : date("d-m-Y", strtotime($trabajos["fecha_final"]));
                            echo "<p>" . $fechaInicio . " - " . $fechaFinal ?? "" . "</p>";
                            echo "<p><strong>Logros:</strong> " . $trabajos["logros"] . "</p>";
                        } else {
                            echo "<p>Sin experiencia laboral</p>";
                        }
                    }
                }
            } else {
                echo "<p>Sin experiencia laboral</p>";
            }
            ?>
        </article>
        <article class="jobs">
            <h2>Proyectos</h2>
            <?php
                if (sizeof($data["proyectos"]) > 0) {
                    $proyectos = $data["proyectos"];

                    if (is_null($proyectos)) {
                        echo "<p>Sin proyectos</p>";
                    } else {
                        if (isset($proyectos[0])) {
                            foreach ($proyectos as $proyecto) {
                                if ($proyecto["visible"] == 1) {
                                    if ($proyecto["logo"] === null) {
                                        $proyecto["logo"] = "default.jpg";
                                    }
                                    echo "<h3>" . $proyecto["titulo"] . "</h3>";
                                    echo "<img src='http://" . SERVER . "/img/" . $proyecto["logo"]
                                        . "' alt='Imagen de " . $proyecto["titulo"] . "'>";
                                    echo "<p><strong>Descripción:</strong> " . $proyecto["descripcion"] . "</p>";
                                    echo "<p><strong>Tecnologías:</strong> " . $proyecto["tecnologias"] . "</p>";
                                }
                            }
                        } else {
                            if ($proyectos["visible"] == 1) {
                                if ($proyectos["logo"] === null) {
                                    $proyectos["logo"] = "default.jpg";
                                }
                                echo "<h3>" . $proyectos["titulo"] . "</h3>";
                                echo "<img src='http://" . SERVER . "/img/" . $proyectos["logo"]
                                    . "' alt='Imagen de " . $proyectos["titulo"] . "'>";
                                echo "<p><strong>Descripción:</strong> " . $proyectos["descripcion"] . "</p>";
                                echo "<p><strong>Tecnologías:</strong> " . $proyectos["tecnologias"] . "</p>";
                            } else {
                                echo "<p>Sin proyectos</p>";
                            }
                        }
                    }
                } else {
                    echo "<p>Sin proyectos</p>";
                }
            ?>
        </article>
        <article class="jobs">
            <h2>Redes sociales</h2>
            <?php
                if (sizeof($data["redesSociales"]) > 0) {
                    $redesSociales = $data["redesSociales"];

                    if (is_null($redesSociales)) {
                        echo "<p>Sin redes sociales</p>";
                    } else {
                        if (isset($redesSociales[0])) {
                            foreach ($redesSociales as $redSocial) {
                                echo "<h3>" . $redSocial["redes_sociales"] . "</h3>";
                                echo "<p><a target='_blank' href='" . $redSocial["url"] . "'>"
                                    . $redSocial["url"] . "</a></p>";
                            }
                        } else {
                            echo "<h3>" . $redesSociales["redes_sociales"] . "</h3>";
                            echo "<p><a target='_blank' href='" . $redesSociales["url"]
                                . "'>" . $redesSociales["url"] . "</a></p>";
                        }
                    }
                } else {
                    echo "<p>Sin redes sociales</p>";
                }
            ?>
        </article>
        <article class="jobs">
            <h2>Skills</h2>
            <?php
                if (sizeof($data["skills"]) > 0) {
                    $skills = $data["skills"];

                    if (is_null($skills)) {
                        echo "<p>Sin habilidades</p>";
                    } else {
                        if (isset($skills[0])) {
                            $categorias = [];
                            foreach ($skills as $skill) {
                                if ($skill["visible"] == 1) {
                                    $categoria = $skill["categorias_skills_categoria"];
                                    if (!in_array($categoria, $categorias)) {
                                        array_push($categorias, $categoria);
                                    }
                                }
                            }
                            foreach ($categorias as $categoria) {
                                echo "<h3>" . $categoria . "</h3>";
                                foreach ($skills as $skill) {
                                    if ($skill["categorias_skills_categoria"] === $categoria) {
                                        echo "<p>" . $skill["habilidades"] . "</p>";
                                    }
                                }
                            }
                        } else {
                            if ($skills["visible"] == 1) {
                                echo "<h3>" . $skills["categorias_skills_categoria"] . "</h3>";
                                echo "<p>" . $skills["habilidades"] . "</p>";
                            } else {
                                echo "<p>Sin habilidades</p>";
                            }
                        }
                    }
                } else {
                    echo "<p>Sin habilidades</p>";
                }
            ?>
        </article>
    </section>
</main>

<?php
    include_once "includes/footer.php";
?>

