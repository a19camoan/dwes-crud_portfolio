<?php
    namespace App\Models;

    #[\AllowDynamicProperties]
    /**
     * La tabla "proyectos" tiene las columnas "id", "titulo", "descripcion", "logo", "tecnologias",
     *  "visible", "created_at", "updated_at" y "usuarios_id".
     */
    class Proyectos extends DBAsbtractModel
    {
        private static $instance;
        private $id;
        private $titulo;
        private $descripcion;
        private $logo;
        private $tecnologias;
        private $visible;
        private $created_at;
        private $updated_at;
        private $usuarios_id;

        /**
         * Returns an instance of the Proyectos class.
         *
         * @return Proyectos The instance of the Proyectos class.
         */
        public static function getInstancia(): Proyectos
        {
            if (!isset(self::$instance)) {
                $miclase = __CLASS__;
                self::$instance = new $miclase;
            }
            return self::$instance;
        }

        /**
         * Prevents cloning of the Proyectos object.
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
                $this->query = "SELECT * FROM proyectos WHERE usuarios_id = :id";
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
                $this->query = "SELECT * FROM proyectos WHERE id = :id";
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
                $this->query = "DELETE FROM proyectos WHERE id = :id";
                $this->params = ["id" => $id];
                $this->getResultsFromQuery();
            }
        }

        public function edit($id = "")
        {
            $this->query = "UPDATE proyectos
                SET titulo = :titulo, descripcion = :descripcion, logo = :logo, tecnologias = :tecnologias, visible = :visible
                WHERE id = :id";
            $this->params = [
                "titulo" => $this->titulo,
                "descripcion" => $this->descripcion,
                "logo" => $this->logo,
                "tecnologias" => $this->tecnologias,
                "visible" => $this->visible,
                "id" => $id
            ];
            $this->getResultsFromQuery();
        }

        public function set()
        {
            $this->query = "INSERT INTO proyectos (titulo, descripcion, logo, tecnologias, visible, usuarios_id)
                VALUES (:titulo, :descripcion, :logo, :tecnologias, :visible, :usuarios_id)";
            $this->params = [
                "titulo" => $this->titulo,
                "descripcion" => $this->descripcion,
                "logo" => $this->logo ?? null,
                "tecnologias" => $this->tecnologias,
                "visible" => 1,
                "usuarios_id" => $this->usuarios_id
            ];
            $this->getResultsFromQuery();
        }

        public function setTitulo($titulo)
        {
            $this->titulo = $titulo;
        }

        public function setDescripcion($descripcion)
        {
            $this->descripcion = $descripcion;
        }

        public function setLogo($logo)
        {
            $this->logo = $logo;
        }

        public function setTecnologias($tecnologias)
        {
            $this->tecnologias = $tecnologias;
        }

        public function setVisible($visible)
        {
            $this->visible = $visible;
        }

        public function setIdUsuario($usuarios_id)
        {
            $this->usuarios_id = $usuarios_id;
        }
    }
