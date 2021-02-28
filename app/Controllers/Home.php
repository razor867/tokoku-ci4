<?php

namespace App\Controllers;

class Home extends BaseController
{
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
		return view('home/v_users', $data);
	}
}

