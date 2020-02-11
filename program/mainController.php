<?php

    class Controller
    {
        
        private $controllerPath;
        private $viewPath;

        public function chargement(string $name = 'Home') {
            $controllerPath = ROOT_PATH. '/controllers/'. $name. 'Controller.class.php';
            $viewPath =       ROOT_PATH. '/views/'. $name. 'View/'. $name. 'View.phtml';
            if (file_exists($controllerPath) && file_exists($viewPath)) {
                include $controllerPath;
                return  $viewPath;
            }
            else {
                throw new Exception("La page ". $viewPath. " n'a pas pu être chargé");
            }
        }
    }

?>