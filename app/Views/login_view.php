<?php
    include_once "includes/header.php";
?>

<header>
    <h2>Inicio de sesión</h2>
    <nav>
        <ul>
            <a href="../">
                <li>Atrás</li>
            </a>
        </ul>
    </nav>
</header>
<main>
    <form class="login_form" method="post" action="http://<?php echo $_SERVER['HTTP_HOST'] ?>/login">
        <label for="email">Correo: </label>
        <input placeholder="Correo Electrónico" type="text" id="email" name="email" required autocomplete="email">
        <label for="password">Contraseña: </label>
        <input placeholder="Contraseña" type="password" id="password" name="password" required
            autocomplete="current-password">
        <input type="submit" value="Iniciar sesión">
    </form>
</main>

<?php
    if (isset($data["error"])) {
        echo "<h3 class='error'>" . $data["error"] . "</h3>";
    }

    include_once "includes/footer.php";
?>
