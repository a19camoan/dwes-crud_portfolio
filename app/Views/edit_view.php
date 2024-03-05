<?php
    include_once "includes/header.php";
?>

<header>
    <h1>Edita tu perfil</h1>
    <nav>
        <ul>
            <a href="../">
                <li>Atrás</li>
            </a>
            <a href="../logout">
                <li>Cerrar sesión</li>
            </a>
            <a href="../delete">
                <li>Borrar cuenta</li>
            </a>
            <a href="../visibility">
                <li>
                    <?php echo $data["usuario"]["visible"] ? "Ocultar" : "Mostrar"; ?> perfil
                </li>
            </a>
        </ul>
    </nav>
</header>

<main>
    <h2>Editar datos de tu perfil</h2>
    <form action="" method="post" enctype="multipart/form-data">
        <fieldset>
            <legend>Proyectos</legend>
            <?php
                if (sizeof($data["proyectos"]) > 0) {
                    $proyectos = $data["proyectos"];

                    if (is_null($proyectos)) {
                        echo "<p>Sin proyectos</p>";
                    } else {
                        if (isset($proyectos[0])) {
                            foreach ($proyectos as $proyecto) {
                                echo "<div>";
                                echo "<label>Título: </label>";
                                echo "<input type='text' name='project_titulo_" . $proyecto["id"] .
                                    "' value='" . $proyecto["titulo"] . "'>";
                                echo "<label>Descripción: </label>";
                                echo "<textarea name='project_descripcion_" . $proyecto["id"]
                                    . "' cols='30' rows='10'>" . $proyecto["descripcion"] . "</textarea>";
                                echo "<label>Logo: </label>";
                                echo "<input type='file' name='project_logo_" . $proyecto["id"] . "' id='logo'>";
                                echo "<label>Tecnologías: </label>";
                                echo "<input type='text' name='project_tecnologias_" . $proyecto["id"] .
                                    "' value='" . $proyecto["tecnologias"] . "'>";
                                echo "<label>Visible: </label>";
                                if ($proyecto["visible"] == 1) {
                                    echo "<input type='checkbox' name='project_visible_" . $proyecto["id"]
                                        . "' checked>";
                                } else {
                                    echo "<input type='checkbox' name='project_visible_" . $proyecto["id"] . "'>";
                                }
                                echo "<input type='submit' name='project_edit_" . $proyecto["id"] . "' value='Editar'>";
                                echo "</div>";
                            }
                        } else {
                            echo "<label>Título: </label>";
                            echo "<input type='text' name='project_titulo_" . $proyectos["id"] .
                                "' value='" . $proyectos["titulo"] . "'>";
                            echo "<label>Descripción: </label>";
                            echo "<textarea name='project_descripcion_" . $proyectos["id"] . "' cols='30' rows='10'>" .
                                $proyectos["descripcion"] . "</textarea>";
                            echo "<label>Logo: </label>";
                            echo "<input type='file' name='project_logo_" . $proyectos["id"] . "' id='logo'>";
                            echo "<label>Tecnologías: </label>";
                            echo "<input type='text' name='project_tecnologias_" . $proyectos["id"] .
                                "' value='" . $proyectos["tecnologias"] . "'>";
                            echo "<label>Visible: </label>";
                            if ($proyectos["visible"] == 1) {
                                echo "<input type='checkbox' name='project_visible_" . $proyectos["id"] . "' checked>";
                            } else {
                                echo "<input type='checkbox' name='project_visible_" . $proyectos["id"] . "'>";
                            }
                            echo "<input type='submit' name='project_edit_" . $proyectos["id"] . "' value='Editar'>";
                        }
                    }
                } else {
                    echo "<p>Sin proyectos</p>";
                }
            ?>
        </fieldset>
        <fieldset>
            <legend>Trabajos</legend>
            <?php
                if (sizeof($data["trabajos"]) > 0) {
                    $trabajos = $data["trabajos"];

                    if (is_null($trabajos)) {
                        echo "<p>Sin trabajos</p>";
                    } else {
                        if (isset($trabajos[0])) {
                            foreach ($trabajos as $trabajo) {
                                echo "<div>";
                                echo "<label>Título: </label>";
                                echo "<input type='text' name='job_titulo_" . $trabajo["id"] .
                                    "' value='" . $trabajo["titulo"] . "'>";
                                echo "<label>Descripción: </label>";
                                echo "<textarea name='job_descripcion_" . $trabajo["id"] . "' cols='30' rows='10'>" .
                                    $trabajo["descripcion"] . "</textarea>";
                                echo "<label>Fecha de inicio: </label>";
                                echo "<input type='date' name='job_fecha_inicio_" . $trabajo["id"] .
                                    "' value='" . $trabajo["fecha_inicio"] . "'>";
                                echo "<label>Fecha de finalización: </label>";
                                echo "<input type='date' name='job_fecha_final_" . $trabajo["id"] .
                                    "' value='" . $trabajo["fecha_final"] . "'>";
                                echo "<label>Logros: </label>";
                                echo "<textarea name='job_logros_" . $trabajo["id"] . "' cols='30' rows='10'>" .
                                    $trabajo["logros"] . "</textarea>";
                                echo "<label>Visible: </label>";
                                if ($trabajo["visible"] == 1) {
                                    echo "<input type='checkbox' name='job_visible_" . $trabajo["id"] . "' checked>";
                                } else {
                                    echo "<input type='checkbox' name='job_visible_" . $trabajo["id"] . "'>";
                                }
                                echo "<input type='submit' name='job_edit_" . $trabajo["id"] . "' value='Editar'>";
                                echo "</div>";
                            }
                        } else {
                            echo "<label>Título: </label>";
                            echo "<input type='text' name='job_titulo_" . $trabajos["id"] .
                                "' value='" . $trabajos["titulo"] . "'>";
                            echo "<label>Descripción: </label>";
                            echo "<textarea name='job_descripcion_" . $trabajos["id"] . "' cols='30' rows='10'>" .
                                $trabajos["descripcion"] . "</textarea>";
                            echo "<label>Fecha de inicio: </label>";
                            echo "<input type='date' name='job_fecha_inicio_" . $trabajos["id"] .
                                "' value='" . $trabajos["fecha_inicio"] . "'>";
                            echo "<label>Fecha de finalización: </label>";
                            echo "<input type='date' name='job_fecha_final_" . $trabajos["id"] .
                                "' value='" . $trabajos["fecha_final"] . "'>";
                            echo "<label>Logros: </label>";
                            echo "<textarea name='job_logros_" . $trabajos["id"] . "' cols='30' rows='10'>" .
                                $trabajos["logros"] . "</textarea>";
                            echo "<label>Visible: </label>";
                            if ($trabajos["visible"] == 1) {
                                echo "<input type='checkbox' name='job_visible_" . $trabajos["id"] . "' checked>";
                            } else {
                                echo "<input type='checkbox' name='job_visible_" . $trabajos["id"] . "'>";
                            }
                            echo "<input type='submit' name='job_edit_" . $trabajos["id"] . "' value='Editar'>";
                        }
                    }
                } else {
                    echo "<p>Sin trabajos</p>";
                }
            ?>
        </fieldset>
        <fieldset>
            <legend>Skills</legend>
            <?php
                if (sizeof($data["skills"]) > 0) {
                    $skills = $data["skills"];

                    if (is_null($skills)) {
                        echo "<p>Sin skills</p>";
                    } else {
                        if (isset($skills[0])) {
                            foreach ($skills as $skill) {
                                echo "<div>";
                                echo "<label>Habilidades: </label>";
                                echo "<input type='text' name='skill_habilidades_" . $skill["id"]
                                    . "' value='" . $skill["habilidades"] . "'>";
                                echo "<label>Categoría: </label>";
                                echo "<select name='skill_categorias_skills_categoria_" . $skill["id"]
                                    . "' id='categorias_skills_categoria'>";
                                echo "<option value='Front-end'" . ($skill["categorias_skills_categoria"] == "Front-end"
                                    ? " selected" : "") . ">Front-end</option>";
                                echo "<option value='Back-end'" . ($skill["categorias_skills_categoria"] == "Back-end"
                                    ? " selected" : "") . ">Back-end</option>";
                                echo "<option value='Full-stack'" . ($skill["categorias_skills_categoria"] ==
                                    "Full-stack" ? " selected" : "") . ">Full-stack</option>";
                                echo "</select>";
                                echo "<label> Visible: </label>";
                                if ($skill["visible"] == 1) {
                                    echo "<input type='checkbox' name='skill_visible_" . $skill["id"] . "' checked>";
                                } else {
                                    echo "<input type='checkbox' name='skill_visible_" . $skill["id"] . "'>";
                                }
                                echo "<input type='submit' name='skill_edit_" . $skill["id"] . "' value='Editar'>";
                                echo "</div>";
                            }
                        } else {
                            echo "<label>Habilidades: </label>";
                            echo "<input type='text' name='skill_habilidades_" . $skills["id"] .
                                "' value='" . $skills["habilidades"] . "'>";
                            echo "<label>Categoría: </label>";
                            echo "<select name='skill_categorias_skills_categoria_" . $skills["id"]
                                . "' id='categorias_skills_categoria'>";
                            echo "<option value='Front-end'" . ($skills["categorias_skills_categoria"] == "Front-end"
                                ? " selected" : "") . ">Front-end</option>";
                            echo "<option value='Back-end'" . ($skills["categorias_skills_categoria"] == "Back-end"
                                ? " selected" : "") . ">Back-end</option>";
                            echo "<option value='Full-stack'" . ($skills["categorias_skills_categoria"] ==
                                "Full-stack" ? " selected" : "") . ">Full-stack</option>";
                            echo "</select>";
                            echo "<label> Visible: </label>";
                            if ($skills["visible"] == 1) {
                                echo "<input type='checkbox' name='skill_visible_" . $skills["id"] . "' checked>";
                            } else {
                                echo "<input type='checkbox' name='skill_visible_" . $skills["id"] . "'>";
                            }
                            echo "<input type='submit' name='skill_edit_" . $skills["id"] . "' value='Editar'>";
                        }
                    }
                } else {
                    echo "<p>Sin skills</p>";
                }
            ?>
        </fieldset>
        <fieldset>
            <legend>Redes sociales</legend>
            <?php
                if (sizeof($data["redesSociales"]) > 0) {
                    $redes_sociales = $data["redesSociales"];

                    if (is_null($redes_sociales)) {
                        echo "<p>Sin redes sociales</p>";
                    } else {
                        if (isset($redes_sociales[0])) {
                            foreach ($redes_sociales as $red_social) {
                                echo "<div>";
                                echo "<label>Red social: </label>";
                                echo "<input type='text' name='social_red_social_" . $red_social["id"] .
                                    "' value='" . $red_social["redes_sociales"] . "'>";
                                echo "<label>URL: </label>";
                                echo "<input type='text' name='social_url_" . $red_social["id"] .
                                    "' value='" . $red_social["url"] . "'>";
                                echo "<input type='submit' name='social_edit_" . $red_social["id"]
                                    . "' value='Editar'>";
                                echo "</div>";
                            }
                        } else {
                            echo "<label>Red social: </label>";
                            echo "<input type='text' name='social_red_social_" . $redes_sociales["id"] .
                                "' value='" . $redes_sociales["redes_sociales"] . "'>";
                            echo "<label>URL: </label>";
                            echo "<input type='text' name='social_url_" . $redes_sociales["id"] .
                                "' value='" . $redes_sociales["url"] . "'>";
                            echo "<input type='submit' name='social_edit_" . $redes_sociales["id"]
                                . "' value='Editar'>";
                        }
                    }
                } else {
                    echo "<p>Sin redes sociales</p>";
                }
            ?>
        </fieldset>
    </form>
    <div>
        <a class="nav" href="../edit">
            <p>Añadir datos</p>
        </a>
        <a class="nav" href="../del_data">
            <p>Borrar datos</p>
        </a>
    </div>
</main>

<?php
    include_once "includes/footer.php";
?>
