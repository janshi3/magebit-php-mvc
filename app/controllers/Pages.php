<?php

class Pages extends Controller {
    public function __construct() {

    }

    public function index() {
        $data = [
            'email' => '',
            'terms' => '',
            'emailError' => '',
            'termsError' => ''
        ];

        $this->view('index', $data);
    }

    public function success() {
        $this->view('success');
    }
}