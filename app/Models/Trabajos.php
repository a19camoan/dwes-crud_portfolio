<?php
    namespace App\Models;

    #[\AllowDynamicProperties]
    /**
     * La tabla "trabajos" tiene las columnas "id", "titulo", "descripcion", "fecha_inicio", "fecha_final",
     *  "logros", "visible", "created_at", "updated_at" y "usuarios_id".
     */
    class Trabajos extends DBAsbtractModel
    {
        private static $instance;
        private $id;
        private $titulo;
        private $descripcion;
        private $fecha_inicio;
        private $fecha_final;
        private $logros;
        private $visible;
        private $created_at;
        private $updated_at;
        private $usuarios_id;

        /**
         * Returns an instance of the Trabajos class.
         *
         * @return Trabajos The instance of the Trabajos class.
         */
        public static function getInstancia(): Trabajos
        {
            if (!isset(self::$instance)) {
                $miclase = __CLASS__;
                self::$instance = new $miclase;
            }
            return self::$instance;
        }

        /**
         * Prevents cloning of the Trabajos object.
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
                $this->query = "SELECT * FROM trabajos WHERE usuarios_id = :id";
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
                $this->query = "SELECT * FROM trabajos WHERE id = :id";
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
                $this->query = "DELETE FROM trabajos WHERE id = :id";
                $this->params = ["id" => $id];
                $this->getResultsFromQuery();
            }
        }

        public function edit($id = "")
        {
            $this->query = "UPDATE trabajos
                SET titulo = :titulo, descripcion = :descripcion, fecha_inicio = :fecha_inicio, fecha_final = :fecha_final, logros = :logros, visible = :visible
                WHERE id = :id";
            $this->params = [
                "titulo" => $this->titulo,
                "descripcion" => $this->descripcion,
                "fecha_inicio" => $this->fecha_inicio,
                "fecha_final" => $this->fecha_final,
                "logros" => $this->logros,
                "visible" => $this->visible,
                "id" => $id
            ];
            $this->getResultsFromQuery();
        }

        public function set($data = array()) : void
        {
            $this->query = "INSERT INTO trabajos
                (titulo, descripcion, fecha_inicio, fecha_final, logros, visible, usuarios_id)
                VALUES (:titulo, :descripcion, :fecha_inicio, :fecha_final, :logros, :visible, :usuarios_id)";
            $this->params = [
                "titulo" => $this->titulo,
                "descripcion" => $this->descripcion,
                "fecha_inicio" => $this->fecha_inicio,
                "fecha_final" => $this->fecha_final,
                "logros" => $this->logros,
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

        public function setFechaInicio($fecha_inicio)
        {
            $this->fecha_inicio = $fecha_inicio;
        }

        public function setFechaFinal($fecha_final)
        {
            $this->fecha_final = $fecha_final;
        }

        public function setLogros($logros)
        {
            $this->logros = $logros;
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
