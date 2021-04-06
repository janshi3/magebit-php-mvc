<?php

class Pages extends Controller {
    public function __construct() {

    }

    // Index page
    public function index() {
        $data = [
            'email' => '',
            'terms' => '',
            'emailError' => '',
            'termsError' => ''
        ];

        $this->view('index', $data);
    }

    // Success page
    public function success() {
        $this->view('success');
    }
}