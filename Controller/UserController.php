<?php

namespace Controller;

use Model\User;

class UserController extends Controller
{
    /**
     * @var User $model
     */
    private $model;

    public function __construct()
    {
        $this->model = new User();
    }

    public function index()
    {
        $this->model->test();
    }
}