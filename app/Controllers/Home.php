<?php

namespace App\Controllers;

use App\Models\Users_model;
use Myth\Auth\Entities\User;

class Home extends BaseController
{
	protected $model_user;
	protected $validation;
	protected $config;

	public function __construct()
	{
		$this->model_user = new Users_model();
		$this->validation = \Config\Services::validation();
		$this->config = config('Auth');
	}
	public function index()
	{
		$data['title'] = 'Dashboard';
		return view('home/v_dashboard', $data);
	}

	public function profile()
	{
		$data['title'] = 'Profile';
		return view('home/v_profile', $data);
	}

	public function users()
	{
		$data['title'] = 'Users';
		$data['modaltitle'] = 'Add User';
		$data['validation'] = $this->validation;
		$data['roles'] = $this->model_user->getRoles();
		$data['user_data'] = $this->model_user->findAll();

		return view('home/v_users', $data);
	}

	public function add_new_user()
	{
		if (!$this->validate($this->validation->getRuleGroup('add_user'))) {
			session()->setFlashdata('info', 'error_add');
			return redirect()->to('/home/users')->withInput();
		}

		$allowedPostFields = array_merge(['password'], $this->config->validFields, $this->config->personalFields);
		$user = new User($this->request->getPost($allowedPostFields));

		$this->config->requireActivation !== false ? $user->generateActivateHash() : $user->activate();
		$this->model_user->save($user);
		$id_newUser = $this->model_user->orderBy('id', 'DESC')->first();
		$this->model_user->addUserToGroup($id_newUser->id, $this->request->getPost('roles'));
		session()->setFlashdata('info', 'User berhasil ditambahkan');
		return redirect()->to('/home/users');
	}
}
