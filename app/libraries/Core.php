<?php

class Core {
    protected $currentController = 'Pages';
    protected $currentMethod = 'index';
    protected $params = [];

    public function __construct() {
        $url = $this->getUrl();

        // Capitalise the first part of the url and look for a matching controller
        if (isset($url[0])){
            if (file_exists('../app/controllers/' . ucwords($url[0]) . '.php')) {
                
                // Set a new controller
                $this->currentController = ucwords($url[0]);
                unset($url[0]);
            }
        }

        // Require the Controller
        require_once '../app/controllers/' . $this->currentController . '.php';
        $this->currentController = new $this->currentController;

        // Check the second part of the url and look for a matching method
        if (isset($url[1])) {
            if (method_exists($this->currentController, $url[1])) {
                $this->currentMethod = $url[1];
                unset($url[1]);
            }
        }

        // Get parameters
        $this->params = $url ? array_values($url) : [];

        // Call a callback with array of params
        call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
    }

    public function getUrl() {
        if (isset($_GET['url'])) {

            // Cut out '/'
            $url = rtrim($_GET['url'], '/');

            // Filters variables as a string or number
            $url = filter_var($url, FILTER_SANITIZE_URL);

            // Convert url into an array
            $url = explode('/', $url);

            return $url;
        }
    }
}
