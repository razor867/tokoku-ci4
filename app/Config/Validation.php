<?php

namespace Config;

use CodeIgniter\Validation\CreditCardRules;
use CodeIgniter\Validation\FileRules;
use CodeIgniter\Validation\FormatRules;
use CodeIgniter\Validation\Rules;

class Validation
{
	//--------------------------------------------------------------------
	// Setup
	//--------------------------------------------------------------------

	/**
	 * Stores the classes that contain the
	 * rules that are available.
	 *
	 * @var string[]
	 */
	public $ruleSets = [
		Rules::class,
		FormatRules::class,
		FileRules::class,
		CreditCardRules::class,
		\Myth\Auth\Authentication\Passwords\ValidationRules::class
	];

	/**
	 * Specifies the views that are used to display the
	 * errors.
	 *
	 * @var array<string, string>
	 */
	public $templates = [
		'list'   => 'CodeIgniter\Validation\Views\list',
		'single' => 'CodeIgniter\Validation\Views\single',
	];

	public $satuan = [
		'id' => [
			'rules' => 'integer',
			'errors' => [
				'integer' => 'Field harus integer'
			]
		],
		'satuan' => [
			'rules'  => 'required|alpha_space',
			'errors' => [
				'required' => 'Wajib diisi!',
				'alpha_space' => 'Harap isi dengan huruf alfabetic'
			]
		],
		'deskripsi' => [
			'rules'  => 'required|alpha_space',
			'errors' => [
				'required' => 'Wajib diisi!',
				'alpha_space' => 'Harap isi dengan huruf alfabetic'
			]
		],
	];

	public $kategori = [
		'id' => [
			'rules' => 'integer',
			'errors' => [
				'integer' => 'Field harus integer'
			]
		],
		'kategori' => [
			'rules'  => 'required|alpha_space',
			'errors' => [
				'required' => 'Wajib diisi!',
				'alpha_space' => 'Harap isi dengan huruf alfabetic'
			]
		],
		'deskripsi' => [
			'rules'  => 'required|alpha_space',
			'errors' => [
				'required' => 'Wajib diisi!',
				'alpha_space' => 'Harap isi dengan huruf alfabetic'
			]
		],
	];

	public $produk = [
		'id' => [
			'rules' => 'alpha_numeric',
			'errors' => [
				'alpha_numeric' => 'Harap isi dengan huruf alfabetic atau kombinasi angka'
			]
		],
		'nama_produk' => [
			'rules' => 'alpha_numeric_punct|required',
			'errors' => [
				'required' => 'Wajib diisi',
				'alpha_numeric_punct' => 'Harap isi dengan huruf alfabetic atau kombinasi angka'
			]
		],
		'category' => [
			'rules' => 'required|integer',
			'errors' => [
				'required' => 'Wajib diisi',
				'integer' => 'Harap isi dengan angka'
			]
		],
		'satuan' => [
			'rules' => 'required|integer',
			'errors' => [
				'required' => 'Wajib diisi',
				'integer' => 'Harap isi dengan angka'
			]
		],
		'stok' => [
			'rules' => 'required|integer',
			'errors' => [
				'required' => 'Wajib diisi',
				'integer' => 'Harap isi dengan angka'
			]
		],
		'harga' => [
			'rules' => 'required|integer',
			'errors' => [
				'required' => 'Wajib diisi',
				'integer' => 'Harap isi dengan angka'
			]
		],
		'ket' => [
			'rules' => 'permit_empty|alpha_numeric_punct',
			'errors' => [
				'alpha_numeric_punct' => 'Harap isi dengan huruf alfabetic atau kombinasi angka'
			]
		],
	];

	public $penjualan = [
		'id' => [
			'rules' => 'integer',
			'errors' => [
				'integer' => 'Field harus integer'
			]
		],
		'produk' => [
			'rules' => 'required|alpha_numeric',
			'errors' => [
				'required' => 'Wajib diisi',
				'alpha_numeric' => 'Field harus alphanumeric'
			]
		],
		'satuan' => [
			'rules' => 'required|integer',
			'errors' => [
				'required' => 'Wajib diisi',
				'integer' => 'Field harus integer'
			]
		],
		'qty' => [
			'rules' => 'required|integer',
			'errors' => [
				'required' => 'Wajib diisi',
				'integer' => 'Field harus integer'
			]
		],
		'total_jual' => [
			'rules' => 'required|integer',
			'errors' => [
				'required' => 'Wajib diisi',
				'integer' => 'Field harus integer'
			]
		]
	];

	public $pembelian = [
		'id' => [
			'rules' => 'integer',
			'errors' => [
				'integer' => 'Field harus integer'
			]
		],
		'produk' => [
			'rules' => 'required|alpha_numeric',
			'errors' => [
				'required' => 'Wajib diisi',
				'alpha_numeric' => 'Field harus alphanumeric'
			]
		],
		'satuan' => [
			'rules' => 'required|integer',
			'errors' => [
				'required' => 'Wajib diisi',
				'integer' => 'Field harus integer'
			]
		],
		'qty' => [
			'rules' => 'required|integer',
			'errors' => [
				'required' => 'Wajib diisi',
				'integer' => 'Field harus integer'
			]
		],
		'total_beli' => [
			'rules' => 'required|integer',
			'errors' => [
				'required' => 'Wajib diisi',
				'integer' => 'Field harus integer'
			]
		]
	];

	public $add_user = [
		'email' => [
			'rules' => 'required|valid_email|is_unique[users.email]',
			'errors' => [
				'required' => 'Wajib diisi',
				'valid_email' => 'Email tidak valid',
				'is_unique[users.email]' => 'Email sudah ada',
			]
		],
		'username'  	=> [
			'rules' => 'required|alpha_numeric_space|min_length[3]|is_unique[users.username]',
			'errors' => [
				'required' => 'Wajib diisi',
				'alpha_numeric_space' => 'Tidak boleh memasukkan script',
				'min_length' => 'minimal 3 karakter yang diinput',
				'is_unique[users.username]' => 'username sudah ada'
			]
		],
		'password'	 	=> [
			'rules' => 'required|strong_password',
			'errors' => [
				'required' => 'Wajib diisi',
				'strong_password' => 'Password harus mengandung huruf besar dan kecil'
			]
		],
		'pass_confirm' 	=> [
			'rules' => 'required|matches[password]',
			'errors' => [
				'required' => 'Wajib diisi',
				'matches' => 'Password tidak sama'
			]
		],
		'roles' => [
			'rules' => 'required|numeric',
			'errors' => [
				'required' => 'Wajib diisi',
				'numeric' => 'Field wajib numeric'
			]
		]
	];

	public $edit_user = [
		'photo' => [
			'rules' => 'permit_empty|is_image[photo]|max_size[photo,1048]|mime_in[photo,image/png,image/jpg,image/jpeg,image/gif]',
			'errors' => [
				'max-size' => 'File terlalu besar',
				'is_image' => 'Ini bukanlah gambar',
				'mime_in' => 'Ini bukan gambar'
			]
		],
		'firstname' => [
			'rules' => 'permit_empty|alpha_numeric_space|min_length[3]',
			'errors' => [
				'alpha_numeric_space' => 'Tidak boleh memasukkan script',
				'min_length' => 'minimal 3 karakter yang diinput',
			]
		],
		'lastname' => [
			'rules' => 'permit_empty|alpha_numeric_space|min_length[3]',
			'errors' => [
				'alpha_numeric_space' => 'Tidak boleh memasukkan script',
				'min_length' => 'minimal 3 karakter yang diinput',
			]
		],
		'about' => [
			'rules' => 'permit_empty|alpha_numeric_punct',
			'errors' => [
				'alpha_numeric_punct' => 'Tidak boleh memasukkan script'
			]
		],
		'id_user' => [
			'rules' => 'required|numeric',
			'errors' => [
				'required' => 'Wajib diisi',
				'numeric' => 'Wajib numeric'
			]
		]
	];


	//--------------------------------------------------------------------
	// Rules
	//--------------------------------------------------------------------
}
