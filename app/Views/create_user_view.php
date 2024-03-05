<?php
    include_once "includes/header.php";
?>

<header>
    <h2>Creación de cuenta</h2>
    <nav>
        <ul>
            <a href="../">
                <li>Atrás</li>
            </a>
        </ul>
    </nav>
</header>
<main>
    <form class="login_form" method="post" action="http://<?php echo $_SERVER["HTTP_HOST"]; ?>/register">
        <label for="nombre">Nombre: </label>
        <input placeholder="Nombre" type="text" id="nombre" name="nombre" required autocomplete="name">
        <label for="apellidos">Apellidos: </label>
        <input placeholder="Apellidos" type="text" id="apellidos" name="apellidos" required autocomplete="family-name">
        <label for="email">Correo: </label>
        <input placeholder="Corre Electrónico" type="text" id="email" name="email" required autocomplete="email">
        <label for="password">Contraseña: </label>
        <input placeholder="Contraseña" type="password" id="password" name="password" required
            autocomplete="current-password">
        <label for="categoria_profesional">Categoría profesional: </label>
        <input placeholder="Categoría" type="text" id="categoria_profesional" name="categoria_profesional" required
            autocomplete="category">
        <label for="resumen_perfil">Breve resumen de tu perfil: </label>
        <textarea placeholder="Resumen" id="resumen_perfil" name="resumen_perfil" required
            autocomplete="profile_sumary" value="">
        </textarea>
        <input type="submit" value="Enviar correo">
    </form>
</main>

<?php
    if (isset($data["error"])) {
        echo "<h3 class='error'>" . $data["error"] . "</h3>";
    }

    if (isset($data["message"])) {
        echo "<h3 class='message'>" . $data["message"] . "</h3>";
    }

    include_once "includes/footer.php";
?>
