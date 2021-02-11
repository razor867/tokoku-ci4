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
		'nama_produk' => [
			'rules' => 'required|alpha_numeric_punct',
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
			'rules' => 'required|alpha_numeric',
			'errors' => [
				'required' => 'Wajib diisi',
				'alpha_numeric' => 'Field harus alpha numeric'
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

	//--------------------------------------------------------------------
	// Rules
	//--------------------------------------------------------------------
}
