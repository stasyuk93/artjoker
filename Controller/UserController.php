<?php

namespace Controller;

use Model\User;
use View\UserView;
use Model\Region;

class UserController extends Controller
{
    /**
     * @var User $model
     */
    private $model;

    private $view;

    public function __construct()
    {
        $this->model = new User();
        $this->view = new UserView();
    }

    public function index()
    {
       $user = $this->model->paginate();
       $this->view->index(['users' => $user, 'links' => $this->model->getPaginate()->links()]);
    }

    public function registerForm()
    {
        $region = new Region();
        $this->view->register(['regions' => $region->getAll()]);
    }

    public function create()
    {
        $data = $this->getPostData(['name','email','city_id']);
        $user = $this->model->where('email',$data['email'])->first();
        if($user){
            $array = $user->toArray();
            $array['territory'] = $user->territory()->ter_address;
            setError("Пользователь с email: {$data['email']} существует.", ['user'=>$array]);
            redirect('register');
        }
        unsetError();
        $this->model->save($data);
        redirect('/');
    }
}