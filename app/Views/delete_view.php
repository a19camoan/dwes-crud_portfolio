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
    <h2>Borrar de tu perfil</h2>
    <form action="" method="post">
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
                                echo "<label>" . $proyecto["titulo"] . " </label>";
                                echo "<input type='checkbox' name='proyectos[]' value='" . $proyecto["id"] . "'>";
                                echo "</div>";
                            }
                        } else {
                            echo "<label>" . $proyectos["titulo"] . " </label>";
                            echo "<input type='checkbox' name='proyectos[]' value='" . $proyectos["id"] . "'>";
                        }
                        echo "<input type='submit' name='del_project' value='Borrar'>";
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
                                echo "<label>" . $trabajo["titulo"] . " </label>";
                                echo "<input type='checkbox' name='trabajos[]' value='" . $trabajo["id"] . "'>";
                                echo "</div>";
                            }
                        } else {
                            echo "<label>" . $trabajos["titulo"] . " </label>";
                            echo "<input type='checkbox' name='trabajos[]' value='" . $trabajos["id"] . "'>";
                        }
                        echo "<input type='submit' name='del_job' value='Borrar'>";
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
                                echo "<label>" . $skill["habilidades"] . " </label>";
                                echo "<input type='checkbox' name='skills[]' value='" . $skill["id"] . "'>";
                                echo "</div>";
                            }
                        } else {
                            echo "<label>" . $skills["habilidades"] . " </label>";
                            echo "<input type='checkbox' name='skills[]' value='" . $skills["id"] . "'>";
                        }
                        echo "<input type='submit' name='del_skill' value='Borrar'>";
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
                    $redes = $data["redesSociales"];

                    if (is_null($redes)) {
                        echo "<p>Sin redes</p>";
                    } else {
                        if (isset($redes[0])) {
                            foreach ($redes as $red) {
                                echo "<div>";
                                echo "<label>" . $red["redes_sociales"] . " </label>";
                                echo "<input type='checkbox' name='redes[]' value='" . $red["id"] . "'>";
                                echo "</div>";
                            }
                        } else {
                            echo "<label>" . $redes["redes_sociales"] . " </label>";
                            echo "<input type='checkbox' name='redes[]' value='" . $redes["id"] . "'>";
                        }
                        echo "<input type='submit' name='del_rss' value='Borrar'>";
                    }
                } else {
                    echo "<p>Sin redes</p>";
                }
            ?>
        </fieldset>
    </form>
    <div>
        <a class="nav" href="../edit">
            <p>Añadir datos</p>
        </a>
        <a class="nav" href="../edit_data">
            <p>Editar datos</p>
        </a>
    </div>
</main>

<?php
    include_once "includes/footer.php";
?>
