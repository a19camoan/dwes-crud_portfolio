<?php
    namespace App\Controllers;

    use App\Models\Usuarios;
    use App\Models\Proyectos;
    use App\Models\RedesSociales;
    use App\Models\Skills;
    use App\Models\Trabajos;

    define("DIR_UPLOAD", "./img/");
    define("MAX_SIZE", 200000);
    define("EXTENSIONS", ["png", "jpg", "jpeg"]);
    define("FORMATS", ["image/png", "image/jpg", "image/jpeg"]);

    class UsuariosController extends BaseController
    {
        /**
         * This method is responsible for handling the index action.
         *
         * @param mixed $request The request object.
         * @return void
         */
        public function indexAction($request): void
        {
            $usuario = Usuarios::getInstancia();
            $data = ["usuarios" => $usuario->getAll()];
            $data["perfil"] = $_SESSION["perfil"];
            $this->renderHTML("../app/Views/index_view.php", $data);
        }

        /**
         * Performs a search action.
         *
         * This method is responsible for performing a search action in the application.
         * It can be used to search for users based on certain criteria.
         *
         * @return void
         */
        public function searchAction(): void
        {
            $data["perfil"] = $_SESSION["perfil"];
            $usuarios = Usuarios::getInstancia();
            $data = ["usuarios" => $usuarios->getByAll($_GET["q"])];
            $data["perfil"] = $_SESSION["perfil"];
            $data["q"] = $_GET["q"];
            $this->renderHTML("../app/Views/index_view.php", $data);
        }

        /**
         * This method is responsible for handling the detail action for the UsuariosController.
         * It retrieves and displays detailed information about a specific user.
         */
        public function detailAction(): void
        {
            $usuario = Usuarios::getInstancia();

            if (!$usuario->getById($_GET["q"])) {
                header(REDIRECT_URL);
                exit();
            }

            if ($usuario->getById($_GET["q"])["visible"] === 0) {
                header(REDIRECT_URL);
                exit();
            }

            $data["perfil"] = $_SESSION["perfil"];
            $data["usuario"] = $usuario->getById($_GET["q"]);
            $data["proyectos"] = Proyectos::getInstancia()->get($_GET["q"]);
            $data["redesSociales"] = RedesSociales::getInstancia()->get($_GET["q"]);
            $data["skills"] = Skills::getInstancia()->get($_GET["q"]);
            $data["trabajos"] = Trabajos::getInstancia()->get($_GET["q"]);
            $this->renderHTML("../app/Views/detail_view.php", $data);
        }

        /**
         * Sets the visibility of the user's profile.
         */
        public function visibilityAction() : void
        {
            ob_start();
            $usuario = Usuarios::getInstancia();
            $mail = $_SESSION["email"];
            $usuario->get($mail);
            $usuario->changeVisibility($usuario->getId());
            header(REDIRECT_URL . "edit");
            ob_end_flush();
        }

        /**
         * Deletes a user.
         *
         * This method is responsible for deleting a user from the system.
         * It performs the necessary operations to remove the user's data from the database.
         *
         * @return void
         */
        public function deleteAccountAction(): void
        {
            if (isset($_POST["del"])) {
                ob_start();
                $usuario = Usuarios::getInstancia();
                $mail = $_SESSION["email"];
                $usuario->get($mail);
                $id = $usuario->getId();
                $usuario->delete($id);
                header(REDIRECT_URL . "logout");
                ob_end_flush();
            } else {
                $usuario = Usuarios::getInstancia();
                $mail = $_SESSION["email"];
                $usuario->get($mail);
                $data["usuario"] = $usuario->get($mail);
                $this->renderHTML("../app/Views/delete_account_view.php", $data);
            }
        }

        /**
         * Adds jobs, skills, social networks, and projects to the user's profile.
         * Also, it allows the user to edit their profile.
         *
         * @return void
         */
        public function addAction() : void
        {
            if ($_POST) {
                ob_start();

                $this->addData($_POST);

                header(REDIRECT_URL . "edit");
                ob_end_flush();
            } else {
                $usuario = Usuarios::getInstancia();
                $mail = $_SESSION["email"];
                $usuario->get($mail);
                $id = $usuario->getId();
                $data["usuario"] = $usuario->get($mail);
                $data["proyectos"] = Proyectos::getInstancia()->get($id);
                $data["redesSociales"] = RedesSociales::getInstancia()->get($id);
                $data["skills"] = Skills::getInstancia()->get($id);
                $data["trabajos"] = Trabajos::getInstancia()->get($id);
                $this->renderHTML("../app/Views/add_view.php", $data);
            }
        }

        /**
         * Allows the user to delete a project, skill, social network, or job from their profile.
         */
        public function deleteAction(): void
        {
            if ($_POST) {
                ob_start();

                $this->deleteData($_POST);

                header(REDIRECT_URL . "del_data");
                ob_end_flush();
            } else {
                $usuario = Usuarios::getInstancia();
                $mail = $_SESSION["email"];
                $id = $_SESSION["id"];
                $usuario->get($mail);
                $data["usuario"] = $usuario->get($mail);
                $data["proyectos"] = Proyectos::getInstancia()->get($id);
                $data["redesSociales"] = RedesSociales::getInstancia()->get($id);
                $data["skills"] = Skills::getInstancia()->get($id);
                $data["trabajos"] = Trabajos::getInstancia()->get($id);
                $this->renderHTML("../app/Views/delete_view.php", $data);
            }
        }

        /**
         * Edit an existing user.
         *
         * This method is responsible for editing an existing user in the application.
         * It performs the necessary actions to update the user's information.
         *
         * @return void
         */
        public function editAction(): void
        {
            if ($_POST) {
                ob_start();

                $this->editData($_POST);

                header(REDIRECT_URL . "edit_view");
                ob_end_flush();
            } else {
                $usuario = Usuarios::getInstancia();
                $mail = $_SESSION["email"];
                $usuario->get($mail);
                $id = $usuario->getId();
                $data["usuario"] = $usuario->get($mail);
                $data["proyectos"] = Proyectos::getInstancia()->get($id);
                $data["redesSociales"] = RedesSociales::getInstancia()->get($id);
                $data["skills"] = Skills::getInstancia()->get($id);
                $data["trabajos"] = Trabajos::getInstancia()->get($id);
                $this->renderHTML("../app/Views/edit_view.php", $data);
            }
        }

        /**
         * Uploads a file to the server.
         *
         * This method is responsible for uploading a file to the server.
         * It performs the necessary operations to move the file to the appropriate directory.
         *
         * @param mixed $file The file to upload.
         * @return string|null The name of the file if it was uploaded successfully, null otherwise.
         */
        private function uploadFile($file, $nombre, $tipo): ?string
        {
            try {
                $aux = explode(".", $file["name"]);
                $extension = strtolower(end($aux));

                if ($file["size"] <= MAX_SIZE && in_array($extension, EXTENSIONS) && in_array($file["type"], FORMATS)) {
                    if ($file["error"] > 0) {
                        throw new \Exception("Error uploading file: " . $file["error"]);
                    } else {
                        $file_name = $tipo . "_" . $nombre . "_" . $_SESSION["id"]
                            . "." . pathinfo($file["name"], PATHINFO_EXTENSION);
                        move_uploaded_file($file["tmp_name"], DIR_UPLOAD . "/" . $file_name);
                    }
                } else {
                    throw new \Exception("Invalid file format or size exceeded.");
                }
                return $file_name ?? null;
            } catch (\Exception $e) {
                echo "Error uploading file: " . $e->getMessage();
                return null;
            }
        }

        /**
         * Adds data to the controller.
         *
         * @param array $data The data to be added.
         * @return void
         */
        private function addData($data): void
        {
            if (isset($data["update_profile"])) {
                $usuario = Usuarios::getInstancia();
                $usuario->get($_SESSION["email"]);
                $usuario->setNombre(trim(htmlspecialchars($data["nombre"])));
                $usuario->setApellidos(trim(htmlspecialchars($data["apellidos"])));
                $usuario->setCatProfesional(trim(htmlspecialchars($data["categoria_profesional"])));
                $usuario->setResumen(trim(htmlspecialchars($data["resumen_perfil"])));
                if (isset($_FILES["foto"]) && $_FILES["foto"]["name"] != "") {
                    $usuario->setFoto($this->uploadFile($_FILES["foto"], $usuario->getNombre(), "foto"));
                }
                $usuario->edit();
            }

            if (isset($data["add_proyect"])) {
                $nombre = explode(" ", trim(htmlspecialchars($data["titulo"])))[0];
                $proyecto = Proyectos::getInstancia();
                $proyecto->setTitulo(trim(htmlspecialchars($data["titulo"])));
                $proyecto->setDescripcion(trim(htmlspecialchars($data["descripcion"])));
                $proyecto->setLogo($this->uploadFile($_FILES["logo"], $nombre, "logo"));
                $proyecto->setTecnologias(trim(htmlspecialchars($data["tecnologias"])));
                $proyecto->setIdUsuario($_SESSION["id"]);
                $proyecto->set();
            }

            if (isset($data["add_rss"])) {
                $redesSociales = RedesSociales::getInstancia();
                $redesSociales->setRed(trim(htmlspecialchars($data["redes_sociales"])));
                $redesSociales->setUrl(trim(htmlspecialchars($data["url"])));
                $redesSociales->setIdUsuario($_SESSION["id"]);
                $redesSociales->set();
            }

            if (isset($data["add_skill"])) {
                $skills = Skills::getInstancia();
                $skills->setHabilidad(trim(htmlspecialchars($data["habilidades"])));
                $skills->setCategoria(trim(htmlspecialchars($data["categorias_skills_categoria"])));
                $skills->setIdUsuario($_SESSION["id"]);
                $skills->set();
            }

            if (isset($data["add_job"])) {
                $trabajos = Trabajos::getInstancia();
                if ($data["fecha_final"] === "") {
                    $trabajos->setFechaFinal(null);
                } else {
                    $trabajos->setFechaFinal(trim(htmlspecialchars($data["fecha_final"])));
                }
                $trabajos->setTitulo(trim(htmlspecialchars($data["titulo_trabajo"])));
                $trabajos->setDescripcion(trim(htmlspecialchars($data["descripcion_trabajo"])));
                $trabajos->setFechaInicio(trim(htmlspecialchars($data["fecha_inicio"])));
                $trabajos->setLogros(trim(htmlspecialchars($data["logros"])));
                $trabajos->setIdUsuario($_SESSION["id"]);
                $trabajos->set();
            }
        }

        /**
         * Deletes the specified data.
         *
         * @param array $data The data to be deleted.
         * @return void
         */
        private function deleteData($data) : void
        {
            if (isset($data["del_project"])) {
                $proyectos = Proyectos::getInstancia();
                $ids = $data["proyectos"];
                foreach ($ids as $id) {
                    $proyectos->delete($id);
                }
            }

            if (isset($data["del_rss"])) {
                $redesSociales = RedesSociales::getInstancia();
                $ids = $data["redes"];
                foreach ($ids as $id) {
                    $redesSociales->delete($id);
                }
            }

            if (isset($data["del_skill"])) {
                $skills = Skills::getInstancia();
                $ids = $data["skills"];
                foreach ($ids as $id) {
                    $skills->delete($id);
                }
            }

            if (isset($data["del_job"])) {
                $trabajos = Trabajos::getInstancia();
                $ids = $data["trabajos"];
                foreach ($ids as $id) {
                    $trabajos->delete($id);
                }
            }
        }

        /**
         * Edit the data.
         *
         * @param mixed $data The data to be edited.
         * @return void
         */
        private function editData($data) : void
        {
            /*
            Visible puede ser 'on' o no existir ya que si lo desmarcas no se crea el elemento.
            Lo que hay después de la segunda "_" es el id del elemento en su tabla. Lo sacamos con explode.
            El usuario puede ser que no tenga un proyecto, trabajo, skill o red social.
            No instanciaremos las clases si no hay datos que editar.
            project_* para proyectos, job_* para trabajos, skill_* para habilidades y social_* para redes sociales.
            EL submit name también tiene el id del elemento.
                "job_edit_{id}", "project_edit_{id}", "skill_edit_{id}" y "social_edit_{id}".
            */
            $regexProject = "/^project_edit_\d+$/";
            $regexJob = "/^job_edit_\d+$/";
            $regexSkill = "/^skill_edit_\d+$/";
            $regexSocial = "/^social_edit_\d+$/";
            # Si existe el submit name, es que se ha editado un elemento.
            foreach ($data as $key => $value) {
                if (preg_match($regexProject, $key)) {
                    $id = explode("_", $key)[2];
                    $proyecto = Proyectos::getInstancia();
                    $proyecto->getById($id);
                    $proyecto->setTitulo(trim(htmlspecialchars($data["project_titulo_" . $id])));
                    $proyecto->setDescripcion(trim(htmlspecialchars($data["project_descripcion_" . $id])));
                    if (isset($_FILES["project_logo_" . $id]) && $_FILES["project_logo_" . $id]["name"] != "") {
                        /* el nombre del proyecto es la primera palabra del título.
                            pueden ser varias palabras, pero solo queremos la primera.
                        */
                        $nombreProyecto = explode(" ", trim(htmlspecialchars($data["project_titulo_" . $id])))[0];
                        $proyecto->setLogo($this->uploadFile($_FILES["project_logo_" . $id], $nombreProyecto, "logo"));
                    }
                    $proyecto->setTecnologias(trim(htmlspecialchars($data["project_tecnologias_" . $id])));
                    if (isset($data["project_visible_" . $id])) {
                        $proyecto->setVisible(1);
                    } else {
                        $proyecto->setVisible(0);
                    }
                    $proyecto->edit($id);
                }

                if (preg_match($regexJob, $key)) {
                    $id = explode("_", $key)[2];
                    $trabajo = Trabajos::getInstancia();
                    $trabajo->getById($id);
                    $trabajo->setTitulo(trim(htmlspecialchars($data["job_titulo_" . $id])));
                    $trabajo->setDescripcion(trim(htmlspecialchars($data["job_descripcion_" . $id])));
                    $trabajo->setFechaInicio(trim(htmlspecialchars($data["job_fecha_inicio_" . $id])));
                    if ($data["job_fecha_final_" . $id] === "") {
                        $trabajo->setFechaFinal(null);
                    } else {
                        $trabajo->setFechaFinal(trim(htmlspecialchars($data["job_fecha_final_" . $id])));
                    }
                    $trabajo->setLogros(trim(htmlspecialchars($data["job_logros_" . $id])));
                    if (isset($data["job_visible_" . $id])) {
                        $trabajo->setVisible(1);
                    } else {
                        $trabajo->setVisible(0);
                    }
                    $trabajo->edit($id);
                }

                if (preg_match($regexSkill, $key)) {
                    $id = explode("_", $key)[2];
                    $skill = Skills::getInstancia();
                    $skill->getById($id);
                    $skill->setHabilidad(trim(htmlspecialchars($data["skill_habilidades_" . $id])));
                    $skill->setCategoria(trim(htmlspecialchars($data["skill_categorias_skills_categoria_" . $id])));
                    if (isset($data["skill_visible_" . $id])) {
                        $skill->setVisible(1);
                    } else {
                        $skill->setVisible(0);
                    }
                    $skill->edit($id);
                }

                if (preg_match($regexSocial, $key)) {
                    $id = explode("_", $key)[2];
                    $redSocial = RedesSociales::getInstancia();
                    $redSocial->getById($id);
                    $redSocial->setRed(trim(htmlspecialchars($data["social_red_social_" . $id])));
                    $redSocial->setUrl(trim(htmlspecialchars($data["social_url_" . $id])));
                    $redSocial->edit($id);
                }
            }
        }
    }
