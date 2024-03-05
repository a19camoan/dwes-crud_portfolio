<?php
    include_once "includes/header.php";
?>

<header>
    <h1>Borra tu perfil</h1>
    <nav>
        <ul>
            <a href="../">
                <li>Cancelar</li>
            </a>
            <a href="../logout">
                <li>Cerrar sesión</li>
            </a>
        </ul>
    </nav>
</header>
<main>
    <h2>¿Estás seguro de querer borrar tu cuenta?</h2>
    <table>
        <caption>Datos de la cuenta</caption>
        <tr>
            <th>Nombre</th>
            <th>Apellidos</th>
            <th>Email</th>
            <th>Descripción</th>
        </tr>
        <tr>
            <td><?php echo $data["usuario"]["nombre"]; ?></td>
            <td><?php echo $data["usuario"]["apellidos"]; ?></td>
            <td><?php echo $data["usuario"]["email"]; ?></td>
            <td><?php echo $data["usuario"]["resumen_perfil"]; ?></td>
        </tr>
    </table>
    <form method="post" action="http://<?php echo $_SERVER["HTTP_HOST"]; ?>/delete">
        <input type="submit" name="del" value="Borrar">
    </form>
</main>

<?php
    include_once "includes/footer.php";
?>
