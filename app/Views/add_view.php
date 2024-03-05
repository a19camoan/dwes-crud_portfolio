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
                <li><?php echo $data["usuario"]["visible"] ? "Ocultar" : "Mostrar"; ?> perfil</li>
            </a>
        </ul>
    </nav>
</header>

<main>
    <h2>Añadir a tu perfil</h2>
    <form action="../edit" method="post" enctype="multipart/form-data">
        <fieldset>
            <legend>Datos personales</legend>
            <label for="nombre">Nombre</label>
            <input required type="text" name="nombre" id="nombre" value="<?php echo $data["usuario"]["nombre"]; ?>">
            <label for="apellidos">Apellidos</label>
            <input required type="text" name="apellidos" id="apellidos"
                value="<?php echo $data["usuario"]["apellidos"]; ?>">
            <label for="foto">Foto</label>
            <input type="file" name="foto" id="foto">
            <label for="categoria_profesional">Categoría profesional</label>
            <input required type="text" name="categoria_profesional" id="categoria_profesional"
                value="<?php echo trim($data["usuario"]["categoria_profesional"]); ?>">
            <label for="resumen_perfil">Resumen del perfil</label>
            <textarea required name="resumen_perfil" id="resumen_perfil" cols="30" rows="10">
                <?php echo $data["usuario"]["resumen_perfil"]; ?>
            </textarea>
            <input type="submit" name="update_profile" value="Actualizar">
        </fieldset>
        <fieldset>
            <legend>Proyectos</legend>
            <label for="titulo">Título</label>
            <input type="text" name="titulo" id="titulo">
            <label for="descripcion">Descripción</label>
            <textarea name="descripcion" id="descripcion" cols="30" rows="10"></textarea>
            <label for="logo">Logo</label>
            <input type="file" name="logo" id="logo">
            <label for="tecnologias">Tecnologías</label>
            <input type="text" name="tecnologias" id="tecnologias">
            <input type="submit" name="add_proyect" value="Añadir">
        </fieldset>
        <fieldset>
            <legend>Redes sociales</legend>
            <label for="redes_sociales">Red social</label>
            <input type="text" name="redes_sociales" id="redes_sociales">
            <label for="url">URL</label>
            <input type="text" name="url" id="url">
            <input type="submit" name="add_rss" value="Añadir">
        </fieldset>
        <fieldset>
            <legend>Skills</legend>
            <label for="habilidades">Habilidades</label>
            <input type="text" name="habilidades" id="habilidades">
            <label for="categorias_skills_categoria">Categoría</label>
            <select name="categorias_skills_categoria" id="categorias_skills_categoria">
                <option value="Front-end">Front-end</option>
                <option value="Back-end">Back-end</option>
                <option value="Full-stack">Full-stack</option>
            </select>
            <input type="submit" name="add_skill" value="Añadir">
        </fieldset>
        <fieldset>
            <legend>Trabajos</legend>
            <label for="titulo_trabajo">Título</label>
            <input type="text" name="titulo_trabajo" id="titulo_trabajo">
            <label for="descripcion_trabajo">Descripción</label>
            <textarea name="descripcion_trabajo" id="descripcion_trabajo" cols="30" rows="10"></textarea>
            <label for="fecha_inicio">Fecha de inicio</label>
            <input type="date" name="fecha_inicio" id="fecha_inicio">
            <label for="fecha_final">Fecha de finalización</label>
            <input type="date" name="fecha_final" id="fecha_final">
            <label for="logros">Logros</label>
            <textarea name="logros" id="logros" cols="30" rows="10"></textarea>
            <input type="submit" name="add_job" value="Añadir">
        </fieldset>
    </form>
    <div>
        <a class="nav" href="../del_data">
            <p>Eliminar datos</p>
        </a>
        <a class="nav" href="../edit_data">
            <p>Editar datos</p>
        </a>
    </div>
</main>

<?php
    include_once "includes/footer.php";
?>
