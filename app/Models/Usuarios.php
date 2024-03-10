<?php
    namespace App\Models;

    use Symfony\Component\Mailer\Transport;
    use Symfony\Component\Mailer\Mailer;
    use Symfony\Component\Mime\Email;

    #[\AllowDynamicProperties]
    /**
     * Represents a user in the system.
     *
     * This class extends the DBAsbtractModel class and provides functionality
     * for interacting with the "usuarios" table in the database.
     */
    class Usuarios extends DBAsbtractModel
    {
        private static $instance;
        private $id; // INT
        private $nombre; // VARCHAR(128)
        private $apellidos; // VARCHAR(128)
        private $foto; // VARCHAR(128)
        private $categoria_profesional; // VARCHAR(64)
        private $email; // VARCHAR(64)
        private $resumen_perfil; // TINYTEXT
        private $password; // VARCHAR(64)
        private $visible; // TINYINT
        private $token; // VARCHAR(128)
        private $fecha_creacion_token; // TIMESTAMP
        private $cuenta_activa; // TINYINT

        /**
         * Returns an instance of the Usuarios class.
         *
         * @return Usuarios The instance of the Usuarios class.
         */
        public static function getInstancia(): Usuarios
        {
            if (!isset(self::$instance)) {
                $miclase = __CLASS__;
                self::$instance = new $miclase;
            }
            return self::$instance;
        }

        /**
         * Prevents cloning of the Contactos object.
         *
         * @return void
         */
        public function __clone(): void
        {
            trigger_error("La clonación no está permitida", E_USER_ERROR);
        }

        # GETTERS

        /**
         * Retrieve user data based on the provided email.
         *
         * @param string $email The email of the user to retrieve. If not provided, all users will be retrieved.
         * @return array|null An array containing the user data if found, or null if no user is found.
         */
        public function get($email = ""): array | null
        {
            if ($email != "") {
                $this->query = "SELECT * FROM usuarios WHERE email = :email";
                $this->params["email"] = $email;
                $this->getResultsFromQuery();
            }

            if (count($this->rows) == 1) {
                foreach ($this->rows[0] as $propiedad => $valor) {
                    $this->$propiedad = $valor;
                }
                $this->mensaje = "Usuario encontrado";
            } else {
                $this->mensaje = "Usuario no encontrado";
            }

            return $this->rows[0] ?? null;
        }

        /**
         * Retrieves a user by their ID.
         *
         * @param int $id The ID of the user to retrieve.
         * @return array|null The user data as an array, or null if the user is not found.
         */
        public function getById($id) : array | null
        {
            if ($id != "") {
                $this->query = "SELECT * FROM usuarios WHERE id = :id";
                $this->params["id"] = $id;
                $this->getResultsFromQuery();
            }

            if (count($this->rows) == 1) {
                foreach ($this->rows[0] as $propiedad => $valor) {
                    $this->$propiedad = $valor;
                }
                $this->mensaje = "Usuario encontrado";
            } else {
                $this->mensaje = "Usuario no encontrado";
            }

            return $this->rows[0] ?? null;
        }

        /**
         * Retrieves the ID associated with a given token.
         *
         * @param string $token The token to search for.
         * @return int The ID associated with the token.
         */
        public function getIdByToken($token = ""): int
        {
            $this->query = "SELECT id FROM usuarios WHERE token = :token";
            $this->params["token"] = $token;
            $this->getResultsFromQuery();
            return $this->rows[0]["id"];
        }

        /**
         * Retrieve all users.
         *
         * @return array An array containing all the users.
         */
        public function getAll(): array
        {
            $this->query = "SELECT * FROM usuarios";
            $this->getResultsFromQuery();
            return $this->rows;
        }

        public function getByAll($nombre = ""): array
        {
            $this->query = "SELECT * FROM usuarios
                WHERE nombre LIKE :nombre OR
                apellidos LIKE :nombre OR
                categoria_profesional LIKE :nombre OR
                resumen_perfil LIKE :nombre;";
            $this->params["nombre"] = "%$nombre%";
            $this->getResultsFromQuery();
            return $this->rows;
        }

        public function getId(): int
        {
            return $this->id;
        }

        public function getNombre(): string
        {
            return $this->nombre;
        }

        public function getApellidos(): string
        {
            return $this->apellidos;
        }

        public function getFoto(): string
        {
            return $this->foto;
        }

        public function getCatProfesional(): string
        {
            return $this->categoria_profesional;
        }

        public function getEmail(): string
        {
            return $this->email;
        }

        public function getResumen(): string
        {
            return $this->resumen_perfil;
        }

        public function getPassword(): string
        {
            return $this->password;
        }

        public function getVisible(): int
        {
            return $this->visible;
        }

        public function getToken(): string
        {
            return $this->token;
        }

        public function getFechaCreacionToken(): string
        {
            return $this->fecha_creacion_token;
        }

        public function getCuentaActiva(): int
        {
            return $this->cuenta_activa;
        }

        # SETTERS
        /**
         * Set the data for the model.
         *
         * @param array $data The data to set.
         * @return void
         */
        public function set($data = array()): void
        {

            $this->query = "INSERT INTO usuarios
                                (nombre, apellidos, foto, categoria_profesional, email, resumen_perfil, password, visible, cuenta_activa)
                                VALUES
                                (:nombre, :apellidos, :foto, :categoria_profesional, :email, :resumen_perfil, :password, :visible, :cuenta_activa)";
            $this->params = [
                "nombre" => $data["nombre"],
                "apellidos" => $data["apellidos"],
                "foto" => $data["foto"],
                "categoria_profesional" => $data["categoria_profesional"],
                "email" => $data["email"],
                "resumen_perfil" => $data["resumen_perfil"],
                "password" => $data["password"],
                "visible" => $data["visible"],
                "cuenta_activa" => $data["cuenta_activa"]
            ];
            $this->getResultsFromQuery();
            $this->mensaje = "Usuario añadido";
        }

        /**
         * Set the token for the user.
         *
         * @param string $email The email of the user.
         * @param string $token The token to be set.
         * @return void
         */
        public function setToken($email = "", $token = ""): void
        {
            $this->query = "UPDATE usuarios
                                SET token = :token, fecha_creacion_token = CURRENT_TIMESTAMP
                                WHERE email = :email";
            $this->params = ["email" => $email, "token" => $token];
            $this->getResultsFromQuery();
        }

        public function setNombre(string | null $nombre): void
        {
            $this->nombre = $nombre;
        }

        public function setApellidos(string | null $apellidos): void
        {
            $this->apellidos = $apellidos;
        }

        public function setFoto(string | null $foto): void
        {
            $this->foto = $foto;
        }

        public function setCatProfesional(string $categoria_profesional): void
        {
            $this->categoria_profesional = $categoria_profesional;
        }

        public function setEmail(string $email): void
        {
            $this->email = $email;
        }

        public function setResumen(string | null $resumen_perfil): void
        {
            $this->resumen_perfil = $resumen_perfil;
        }

        /**
         * Delete the token associated with the specified email.
         *
         * @param string $email The email of the user.
         * @return void
         */
        public function deleteToken($email = ""): void
        {
            $this->query = "UPDATE usuarios
                            SET token = NULL, fecha_creacion_token = NULL, cuenta_activa = 0
                            WHERE email = :email";
            $this->params = ["email" => $email];
            $this->getResultsFromQuery();
            $this->mensaje = "Token eliminado";
        }

        /**
         * Edit the user.
         *
         * @return void
         */
        public function edit(): void
        {
            $this->query = "UPDATE usuarios SET
                                nombre = :nombre, apellidos = :apellidos, foto = :foto, categoria_profesional = :categoria_profesional, email = :email, resumen_perfil = :resumen_perfil, password = :password, visible = :visible
                                WHERE id = :id";
            $this->params = [
                "nombre" => $this->nombre,
                "apellidos" => $this->apellidos,
                "foto" => $this->foto,
                "categoria_profesional" => $this->categoria_profesional,
                "email" => $this->email,
                "resumen_perfil" => $this->resumen_perfil,
                "password" => $this->password,
                "visible" => $this->visible,
                "id" => $this->id
            ];
            $this->getResultsFromQuery();
            $this->mensaje = "Usuario modificado";
        }

        /**
         * Deletes a user from the database.
         *
         * @param string $email The email of the user to be deleted. If not provided, all users will be deleted.
         * @return void
         */
        public function delete($id = ""): void
        {
            $this->query = "DELETE FROM usuarios WHERE id = :id";
            $this->params = ["id" => $id];
            $this->getResultsFromQuery();
            $this->mensaje = "Usuario eliminado";
        }

        /**
         * Sends an email to the specified email address with the given token.
         *
         * @param string $emailTo The email address to send the email to.
         * @param string $token The token to include in the email.
         * @return void
         */
        public function sendEmail($emailTo, $token): void
        {
            $transport = Transport::fromDsn("smtp://mail:1025");
            $mailer = new Mailer($transport);

            $mensaje = "<p>Para activar su cuenta, haga clic en el siguiente enlace:</p>";
            $mensaje .= "<a href='http://" . $_SERVER["HTTP_HOST"] . "/activate?token=" . $token
                . "'>Activar cuenta</a>";

            $email = (new Email())
            ->from("gestor@portfolios.local")
            ->to($emailTo)
            ->subject("Activación de cuenta")
            ->text($mensaje)
            ->html($mensaje);
            $mailer->send($email);
        }

        /**
         * Activates the user account.
         *
         * @param string $token The activation token.
         * @return void
         */
        public function activarCuenta($token = ""): void
        {
            $this->query = "UPDATE usuarios SET cuenta_activa = 1 WHERE token = :token";
            $this->params = ["token" => $token];
            $this->getResultsFromQuery();
            $this->mensaje = "Cuenta activada";
        }

        /**
         * Logs in a user with the specified email and password.
         *
         * @param string $email The email of the user.
         * @param string $password The password of the user.
         * @return array An array containing the user's information.
         */
        public function login($email = "", $password = ""): array
        {
            $this->query = "SELECT * FROM usuarios WHERE email = :email AND password = :password";
            $this->params = ["email" => $email, "password" => $password];
            $this->getResultsFromQuery();
            return $this->rows[0] ?? null;
        }

        /**
         * Changes the visibility of a user.
         *
         * @param string $id The ID of the user. Defaults to an empty string.
         * @return void
         */
        public function changeVisibility($id = ""): void
        {
            $this->query = "UPDATE usuarios SET visible = IF(visible = 0, 1, 0) WHERE id = :id";
            $this->params = ["id" => $id];
            $this->getResultsFromQuery();
        }
    }
