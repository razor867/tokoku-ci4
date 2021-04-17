<?php

namespace App\Controllers;

use App\Models\Users_model;
use Myth\Auth\Entities\User;
use CodeIgniter\I18n\Time;
use App\Models\PenjualanModel;
use App\Models\PembelianModel;

class Home extends BaseController
{
	protected $model_user;
	protected $validation;
	protected $config;
	protected $permUserPage;
	protected $permUserAdd;
	protected $permUserEdit;
	protected $permUserDelete;
	protected $permProfilEdit;
	protected $model_penjualan;
	protected $model_pembelian;

	public function __construct()
	{
		$this->model_user = new Users_model();
		$this->validation = \Config\Services::validation();
		$this->config = config('Auth');
		$this->model_penjualan = new PenjualanModel();
		$this->model_pembelian = new PembelianModel();
		$this->permUserPage = has_permission('users/page');
		$this->permUserAdd = has_permission('user/add');
		$this->permUserEdit = has_permission('user/edit');
		$this->permUserDelete = has_permission('user/delete');
		$this->permProfilEdit = has_permission('profil/edit');
	}

	public function index()
	{
		if (in_groups('Super Admin') || in_groups('Admin')) {
			$data['title'] = 'Dashboard';
			$time = new Time('now', 'Asia/Jakarta', 'id_ID');
			$time = date_format($time, 'd/m/Y');
			$time = explode('/', $time);
			$search = $time[1] . '/' . $time[2];
			$total_brg_jual = count($this->model_penjualan->like('tanggal_jual', $search, 'both')->findAll());
			$total_brg_beli = count($this->model_pembelian->like('tanggal_beli', $search, 'both')->findAll());

			$data['total_penjualan'] = "Rp" . number_format($this->total_penjualan($search));
			$data['total_pembelian'] = "Rp" . number_format($this->total_pembelian($search));
			$data['total_brg_jual'] = $total_brg_jual;
			$data['total_brg_beli'] = $total_brg_beli;

			$bulan = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];
			foreach ($bulan as $bl) {
				$search = $bl . '/' . $time[2];
				$total_jual_per_month[] = ($this->total_penjualan($search) != null) ? $this->total_penjualan($search) : 0;
				$total_beli_per_month[] = ($this->total_pembelian($search) != null) ? $this->total_pembelian($search) : 0;
			}

			$data['total_jual_per_month'] = $total_jual_per_month;
			$data['total_beli_per_month'] = $total_beli_per_month;

			return view('home/v_dashboard', $data);
		} else {
			return redirect()->to('/home/profile');
		}
	}

	private function total_penjualan($search)
	{
		$data = $this->model_penjualan->selectSum('total_jual')->like('tanggal_jual', $search, 'both')->findAll();
		if ($data) {
			return $data[0]->total_jual;
		} else {
			return null;
		}
	}

	private function total_pembelian($search)
	{
		$data = $this->model_pembelian->selectSum('total_beli')->like('tanggal_beli', $search, 'both')->findAll();
		if ($data) {
			return $data[0]->total_beli;
		} else {
			return null;
		}
	}

	public function profile()
	{
		$data['title'] = 'Profile';
		$data['validation'] = $this->validation;
		return view('home/v_profile', $data);
	}

	public function users()
	{
		$this->permUserPage or exit();

		$data['title'] = 'Users';
		$data['modaltitle'] = 'Add User';
		$data['validation'] = $this->validation;
		$data['roles'] = $this->model_user->getRoles();
		$data['user_data'] = $this->model_user->findAll();

		return view('home/v_users', $data);
	}

	public function add_new_user()
	{
		$this->permUserAdd or exit();

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

	public function edit_user()
	{
		$this->permProfilEdit or exit();

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			if (!$this->validate($this->validation->getRuleGroup('edit_user'))) {
				session()->setFlashdata('info', 'error_add');
				return redirect()->to('/home/profile')->withInput();
			}

			$id_user = $this->request->getPost('id_user');
			$fileSampul = $this->request->getFile('photo');
			$fileSampulLama = $this->request->getVar('sampulLama');
			//cek gambar, apakah tetap gambar lama?
			if ($fileSampul->getError() == 4) {
				$namaSampul = $fileSampulLama;
			} else {
				//generate nama file random
				$namaSampul = $fileSampul->getRandomName();
				//pindahkan gambar
				$fileSampul->move('img', $namaSampul);
				//hapus file yang lama
				if ($fileSampulLama != 'undraw_profile.svg') {
					unlink('img/' . $fileSampulLama);
				}
			}
			$data_edit = [
				'firstname' => $this->request->getPost('firstname'),
				'lastname' => $this->request->getPost('lastname'),
				'profile_picture' => $namaSampul,
				'about_me' => $this->request->getPost('about'),
			];
			$this->model_user->edit_user($id_user, $data_edit);

			session()->setFlashdata('info', 'Edit berhasil!');
			return redirect()->to('/home/profile');
		} else {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		}
	}

	public function edit_user_page()
	{
		$this->request->isAJAX() or exit();

		$data = $this->model_user->find($this->request->getPost('id_user'));
		echo json_encode($data);
	}

	public function get_user_account()
	{
		$this->request->isAJAX() or exit();

		$data = $this->model_user->find($this->request->getPost('id_user'));
		$data_role = $this->model_user->getRoleById($data->id);
		foreach ($data_role as $dr) {
			$data->roles_id = $dr->id;
		}
		echo json_encode($data);
	}

	public function edit_user_account()
	{
		$this->permUserEdit or exit();

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			if (!$this->validate($this->validation->getRuleGroup('edit_user_account'))) {
				session()->setFlashdata('info', 'error_add');
				return redirect()->to('/home/users')->withInput();
			}

			$postData = $this->request->getPost();
			if ($postData['password'] != null && $postData['pass_confirm'] != null) {
				$allowedPostFields = array_merge(['password'], $this->config->validFields, $this->config->personalFields);
				$user = new User($this->request->getPost($allowedPostFields));
				$this->config->requireActivation !== false ? $user->generateActivateHash() : $user->activate();
				$this->model_user->update($postData['id_user'], $user);
			} else {
				$this->model_user->update($postData['id_user'], [
					'email' => $postData['email'],
					'username' => $postData['username']
				]);
			}
			$groups = $this->model_user->getUserGroup($postData['id_user']);
			$id_group = '';
			foreach ($groups as $group) {
				$id_group = $group->id;
			}
			$this->model_user->updateUserToGroup($postData['id_user'], $postData['roles']);
			session()->setFlashdata('info', 'User Account berhasil dirubah');
			return redirect()->to('/home/users');
		} else {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		}
	}

	public function deleteUserAccount($id_user)
	{
		$this->permUserDelete or exit();

		$this->model_user->delete($id_user);
		session()->setFlashdata('info', 'User Account berhasil dihapus');
		return redirect()->to('/home/users');
	}
}
