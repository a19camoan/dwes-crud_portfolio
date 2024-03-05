<?php
    namespace App\Controllers;

    use App\Models\Usuarios;

    define("LOGIN_VIEW", "../app/Views/login_view.php");
    define("CREATE_USER_VIEW", "../app/Views/create_user_view.php");

    /**
     * Class AuthController
     *
     * This class is responsible for handling authentication related functionality.
     * It extends the BaseController class.
     */
    class AuthController extends BaseController
    {
        /**
         * Handles the login action.
         *
         * @param mixed $request The request object.
         * @return void
         */
        public function loginAction($request)
        {
            ob_start();
            if ($_POST) {
                $usuario = Usuarios::getInstancia();
                $email = trim(htmlspecialchars($_POST["email"]));
                $password = trim(htmlspecialchars($_POST["password"]));
                $data = $usuario->get($email);
                if ($data) {
                    if ($password === $data["password"]) {
                        $cuentaActiva = $usuario->getCuentaActiva();
                        if ($cuentaActiva === 0) {
                            $fecha = strtotime($usuario->getFechaCreacionToken());
                            $fechaActual = strtotime(date("Y-m-d H:i:s"));
                            $diferencia = $fechaActual - $fecha;
                            if ($diferencia > 86400) {
                                $this->createToken($email);
                                $data = ["error" => "El tiempo de activación ha expirado. Revise su correo"];
                                $this->renderHTML(LOGIN_VIEW, $data);
                                exit;
                            }

                            $data = ["error" => "La cuenta no está activa. Revise su correo"];
                            $this->renderHTML(LOGIN_VIEW, $data);
                            exit;
                        }

                        $_SESSION["perfil"] = "usuario";
                        $_SESSION["email"] = $data["email"];
                        $_SESSION["id"] = $data["id"];
                        header(REDIRECT_URL);
                    } else {
                        $data = ["error" => "Usuario o contraseña incorrectos"];
                        $this->renderHTML(LOGIN_VIEW, $data);
                    }
                } else {
                    $data = ["error" => "Usuario o contraseña incorrectos"];
                    $this->renderHTML(LOGIN_VIEW, $data);
                }
            } else {
                $this->renderHTML(LOGIN_VIEW);
            }
            ob_end_flush();
        }

        /**
         * Creates a new user account.
         *
         * @param mixed $request The request object.
         * @return void
         */
        public function createAccountAction($request)
        {
            ob_start();
            if ($_POST) {
                $usuario = Usuarios::getInstancia();
                $email = trim(htmlspecialchars($_POST["email"]));
                $data = $usuario->get($email);
                if ($data) {
                    $data = ["error" => "El email ya existe"];
                    $this->renderHTML(CREATE_USER_VIEW, $data);
                } else {
                    $usuario->set([
                        "nombre" => trim(htmlspecialchars($_POST["nombre"])),
                        "apellidos" => trim(htmlspecialchars($_POST["apellidos"])),
                        "foto" => null,
                        "categoria_profesional" => trim(htmlspecialchars($_POST["categoria_profesional"])),
                        "email" => trim(htmlspecialchars($_POST["email"])),
                        "resumen_perfil" => trim(htmlspecialchars($_POST["resumen_perfil"])),
                        "password" => trim(htmlspecialchars($_POST["password"])),
                        "visible" => 1,
                        "cuenta_activa" => 0
                    ]);
                    $this->createToken($email);
                    $data = ["message" => "Se ha enviado un correo de activación"];
                    $this->renderHTML(CREATE_USER_VIEW, $data);
                }
            } else {
                $this->renderHTML(CREATE_USER_VIEW);
            }
        }

        /**
         * Activate user account.
         *
         * This method is responsible for activating a user account based on the provided token.
         *
         * @param mixed $request The request object.
         * @return void
         */
        public function activateAction($request)
        {
            $usuario = Usuarios::getInstancia();
            $token = str_replace(" ", "+", $_GET["token"]);
            $id = $usuario->getIdByToken($token);
            $usuario->getById($id);
            $fecha = strtotime($usuario->getFechaCreacionToken());
            $fechaActual = strtotime(date("Y-m-d H:i:s"));
            $diferencia = $fechaActual - $fecha;
            if ($diferencia > 86400) {
                $this->createToken($usuario->getEmail());
                $data = ["error" => "El tiempo de activación ha expirado. Revise su correo"];
                $this->renderHTML(LOGIN_VIEW, $data);
                exit;
            }
            $usuario->activarCuenta($token);
            header(REDIRECT_URL . "login");
        }

        /**
         * Logout action.
         *
         * This method is responsible for logging out the user by clearing the session data and destroying the session.
         *
         * @param mixed $request The request object.
         * @return void
         */
        public function logoutAction($request)
        {
            session_unset();
            session_destroy();
            header(REDIRECT_URL);
        }

        /**
         * Generates a secure token for the given email and associates it with the user.
         * Sends an email to the user with the secure token.
         *
         * @param string $email The email of the user.
         * @return void
         */
        private function createToken($email)
        {
            $rb = random_bytes(32);
            $token = base64_encode($rb);
            $secureToken = uniqid("", true) . $token;
            $usuario = Usuarios::getInstancia();
            $usuario->setToken($email, $secureToken);
            $usuario->sendEmail($email, $secureToken);
        }
    }
