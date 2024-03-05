<?php
    namespace App\Models;

    #[\AllowDynamicProperties]
    /**
     * La tabla "redes_sociales" tiene las columnas "id", "redes_sociales", "url", "created_at",
     * "updated_at" y "usuarios_id".
     */
    class RedesSociales extends DBAsbtractModel
    {
        private static $instance;
        private $id;
        private $redes_sociales;
        private $url;
        private $created_at;
        private $updated_at;
        private $usuarios_id;

        /**
         * Returns an instance of the RedesSociales class.
         *
         * @return RedesSociales The instance of the RedesSociales class.
         */
        public static function getInstancia(): RedesSociales
        {
            if (!isset(self::$instance)) {
                $miclase = __CLASS__;
                self::$instance = new $miclase;
            }
            return self::$instance;
        }

        /**
         * Prevents cloning of the RedesSociales object.
         *
         * @return void
         */
        public function __clone(): void
        {
            trigger_error("La clonación no está permitida", E_USER_ERROR);
        }

        public function get($id = ""): array | null
        {
            if ($id != "") {
                $this->query = "SELECT * FROM redes_sociales WHERE usuarios_id = :id";
                $this->params["id"] = $id;
                $this->getResultsFromQuery();
            }

            if (count($this->rows) == 1) {
                return $this->rows[0];
            } else {
                return $this->rows;
            }
        }

        public function getById($id = ""): array | null
        {
            if ($id != "") {
                $this->query = "SELECT * FROM redes_sociales WHERE id = :id";
                $this->params["id"] = $id;
                $this->getResultsFromQuery();
            }

            if (count($this->rows) == 1) {
                return $this->rows[0];
            } else {
                return $this->rows;
            }
        }

        public function delete($id = "")
        {
            if ($id != "") {
                $this->query = "DELETE FROM redes_sociales WHERE id = :id";
                $this->params = ["id" => $id];
                $this->getResultsFromQuery();
            }
        }

        public function edit($id = "")
        {
            $this->query = "UPDATE redes_sociales SET redes_sociales = :redes_sociales, url = :url
                WHERE id = :id";
            $this->params = [
                "redes_sociales" => $this->redes_sociales,
                "url" => $this->url,
                "id" => $id
            ];
            $this->getResultsFromQuery();
        }

        public function set($data = array())
        {
            $this->query = "INSERT INTO redes_sociales (redes_sociales, url, usuarios_id)
                VALUES (:redes_sociales, :url, :usuarios_id)";
            $this->params = [
                "redes_sociales" => $this->redes_sociales,
                "url" => $this->url,
                "usuarios_id" => $this->usuarios_id
            ];
            $this->getResultsFromQuery();
        }

        public function setRed($redes_sociales)
        {
            $this->redes_sociales = $redes_sociales;
        }

        public function setUrl($url)
        {
            $this->url = $url;
        }

        public function setIdUsuario($usuarios_id)
        {
            $this->usuarios_id = $usuarios_id;
        }
    }
