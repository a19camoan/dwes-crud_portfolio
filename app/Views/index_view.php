<?php
    include_once "includes/header.php";
/*
• Como invitado tienes acceso a la parte pública.
La parte pública consiste en un buscador de perfiles en el área de las nuevas
tecnologías.
• Como invitado puedes registrarte en el sistema.
El registro mostrará un formulario de entrada de datos personales de usuario.
Al procesar el registro se generará y almacenará en la base de datos, un token de
seguridad único con validez de 24 horas.
Al procesar el registro se enviará un correo electrónico con el enlace de activación
de la cuenta, con validez de 24 horas.
Para generar el token utiliza:
- $rb = random_bytes(32)
- $token = base64_encode($rb)
- $secureToken = uniqid(‘’,true) . $token
• Como invitado tienes acceso al formulario de login. Solo los usuarios registrados y
con las cuentas activas, podrán acceder al sistema.
• Como usuario registrado podrás crear, editar y borrar tu porfolio.
• Como usuario registrado podrás acceder fácilmente a la activación/desactivación
de la visualización de los elementos del porfolio.

array (size=2)
  'usuarios' =>
    array (size=2)
      0 =>
        array (size=14)
          'id' => int 1
          'nombre' => string 'Juan' (length=4)
          'apellidos' => string 'Pérez' (length=6)
          'foto' => string 'foto_juan.jpg' (length=13)
          'categoria_profesional' => string 'Desarrollador web' (length=17)
          'email' => string 'juan@correo.com' (length=15)
          'resumen_perfil' => string 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.' (length=56)
          'password' => string '123456' (length=6)
          'visible' => int 1
          'created_at' => string '2024-02-27 21:41:40' (length=19)
          'updated_at' => string '2024-02-27 21:41:40' (length=19)
          'token' => string 'token-0.19496146235145764' (length=25)
          'fecha_creacion_token' => string '2024-02-27 21:41:40' (length=19)
          'cuenta_activa' => int 1
      1 =>
        array (size=14)
          'id' => int 2
          'nombre' => string 'María' (length=6)
          'apellidos' => string 'Gómez' (length=6)
          'foto' => string 'foto_maria.jpg' (length=14)
          'categoria_profesional' => string 'Diseñadora gráfica' (length=20)
          'email' => string 'maria@correo.com' (length=16)
          'resumen_perfil' => string 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.' (length=56)
          'password' => string '654321' (length=6)
          'visible' => int 1
          'created_at' => string '2024-02-27 21:41:40' (length=19)
          'updated_at' => string '2024-02-27 21:41:40' (length=19)
          'token' => string 'token-0.35692710462671434' (length=25)
          'fecha_creacion_token' => string '2024-02-27 21:41:40' (length=19)
          'cuenta_activa' => int 1
  'perfil' => string 'invitado' (length=8)
  */
?>
<header>
    <h1>Gestor de portfolios</h1>
    <nav>
        <ul>
        <?php
            if($data["perfil"] === "invitado") {
                echo "<a href='http://" . $_SERVER["HTTP_HOST"] . "/register'><li>Crear cuenta</li></a>";
                echo "<a href='http://" . $_SERVER["HTTP_HOST"] . "/login'><li>Iniciar sesión</li></a>";
            } else {
                echo "<a href='http://" . $_SERVER["HTTP_HOST"] . "/edit'><li>Editar perfil</li></a>";
                echo "<a href='http://" . $_SERVER["HTTP_HOST"] . "/logout'><li>Cerrar sesión</li></a>";
            }
        ?>
        </ul>
    </nav>
    <form method="get" action="http://<?php echo  $_SERVER["HTTP_HOST"] ?>/search">
        <input type="text" name="q" placeholder="Buscar"
            <?php if (isset($data["q"])) { echo "value='" . $data["q"] . "'"; } ?>>
        <input type="submit" value="Buscar">
    </form>
</header>
<main>
    <h2>Listado de portfolios</h2>
    <section>
        <?php
            foreach ($data["usuarios"] as $usuario) {
                if ($usuario["visible"] === 1) {
                    if ($usuario["foto"] === null) {
                        $usuario["foto"] = "default.jpg";
                    }
                    echo "<article>";
                    echo "<div>";
                    echo "<h3>" . $usuario["nombre"] . " " . $usuario["apellidos"] . "</h3>";
                    echo "<img src='http://" . $_SERVER["HTTP_HOST"] . "/img/" . $usuario["foto"] . "' alt='Foto de " . $usuario["nombre"] . " " . $usuario["apellidos"] . "'>";
                    echo "</div>";
                    echo "<div>";
                    echo "<p>" . $usuario["categoria_profesional"] . "</p>";
                    echo "<p>" . $usuario["resumen_perfil"] . "</p>";
                    echo "</div>";
                    echo "<a href='http://" . $_SERVER["HTTP_HOST"] . "/detail?q=" . $usuario["id"] . "'>Ver perfil</a>";
                    echo "</article>";
                }
            }
        ?>
    </section>
</main>

<?php
    include_once "includes/footer.php";
?>
