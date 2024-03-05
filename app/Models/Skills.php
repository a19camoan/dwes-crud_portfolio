<?php
    namespace App\Models;

    #[\AllowDynamicProperties]
    /**
     * La tabla "skills" tiene las columnas "id", "habilidades", "visible", "created_at", "updated_at",
     * "categorias_skills_categoria" y "usuarios_id".
     */
    class Skills extends DBAsbtractModel
    {
        private static $instance;
        private $id;
        private $habilidades;
        private $visible;
        private $created_at;
        private $updated_at;
        private $categorias_skills_categoria;
        private $usuarios_id;

        /**
         * Returns an instance of the Skills class.
         *
         * @return Skills The instance of the Skills class.
         */
        public static function getInstancia(): Skills
        {
            if (!isset(self::$instance)) {
                $miclase = __CLASS__;
                self::$instance = new $miclase;
            }
            return self::$instance;
        }

        /**
         * Prevents cloning of the Skills object.
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
                $this->query = "SELECT * FROM skills WHERE usuarios_id = :id";
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
                $this->query = "SELECT * FROM skills WHERE id = :id";
                $this->params["id"] = $id;
                $this->getResultsFromQuery();
            }

            if (count($this->rows) == 1) {
                return $this->rows[0];
            } else {
                return $this->rows;
            }
        }

        public function set()
        {
            $this->query = "INSERT INTO skills (habilidades, visible, categorias_skills_categoria, usuarios_id)
                VALUES (:habilidades, :visible, :categorias_skills_categoria, :usuarios_id)";
            $this->params = [
                "habilidades" => $this->habilidades,
                "visible" => 1,
                "categorias_skills_categoria" => $this->categorias_skills_categoria,
                "usuarios_id" => $this->usuarios_id
            ];
            $this->getResultsFromQuery();
        }

        public function delete($id = "")
        {
            if ($id != "") {
                $this->query = "DELETE FROM skills WHERE id = :id";
                $this->params = ["id" => $id];
                $this->getResultsFromQuery();
            }
        }

        public function edit($id = "")
        {
            $this->query = "UPDATE skills
                SET habilidades = :habilidades, categorias_skills_categoria = :categorias_skills_categoria, visible = :visible
                WHERE id = :id";
            $this->params = [
                "habilidades" => $this->habilidades,
                "categorias_skills_categoria" => $this->categorias_skills_categoria,
                "visible" => $this->visible,
                "id" => $id
            ];
            $this->getResultsFromQuery();
        }

        public function setHabilidad(string $habilidades): void
        {
            $this->habilidades = $habilidades;
        }

        public function setCategoria(string $categorias_skills_categoria): void
        {
            $this->categorias_skills_categoria = $categorias_skills_categoria;
        }

        public function setIdUsuario(int $usuarios_id): void
        {
            $this->usuarios_id = $usuarios_id;
        }

        public function setVisible(int $visible): void
        {
            $this->visible = $visible;
        }
    }
