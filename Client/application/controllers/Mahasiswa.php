<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mahasiswa extends CI_Controller
{

	// variabel global
	// soon get from who is are login
	// konfigurasi di backend cokk
	// ex ketika user regis langsung kasih key
	var $key_name = 'GAB2-API';
	var $key_value = 'RESTAPI-GAB1';


	public function index()
	{

		// setup basic auth dengan username n password
		$this->client->http_login("pwbs", "rest");

		$data["tampil"] = json_decode(
			$this->client->simple_get(APIMAHASISWA, [$this->key_name => $this->key_value])
		);

		// foreach($data["tampil"] -> mahasiswa as $result) {
		// 	echo $result->npm_mhs."<br>";
		// }

		$this->load->view('vw_mahasiswa', $data);
	}

	function setDelete()
	{
		// setup basic auth dengan username n password
		$this->client->http_login("pwbs", "rest");

		// buat variabel json
		$json = file_get_contents("php://input");
		$hasil = json_decode($json);

		$delete = json_decode(
			$this->client->simple_delete(
				APIMAHASISWA,
				array(
					"npm" => $hasil->npmnya,
					$this->key_name => $this->key_value
				)
			)
		);

		// isi nilai err
		// $err = 0;

		// kirim hasil ke vw_mahasiswa
		// status ini dapat dari file server controller mahasiswa 
		// dari response ketika hasil == 1, diambil parameter status.
		echo json_encode(array("statusnya" => $delete->status));
	}

	function addMahasiswa()
	{
		$this->load->view('en_mahasiswa');
	}

	// fungsi untuk simpan data
	function setSave()
	{
		// setup basic auth dengan username n password
		$this->client->http_login("pwbs", "rest");

		// baca nilai dari fetch
		// menggunakan $data array
		$data = array(
			"npm" => $this->input->post("npmnya"),
			"nama" => $this->input->post("namanya"),
			"telepon" => $this->input->post("teleponnya"),
			"jurusan" => $this->input->post("jurusannya"),
			"token" => $this->input->post("npmnya"),
			$this->key_name => $this->key_value
		);

		$save = json_decode(
			$this->client->simple_post(APIMAHASISWA, $data)
		);

		echo json_encode(array("statusnya" => $save->status));
	}

	// fungsi untuk update data menampilkan data
	function updateMahasiswa()
	{
		// setup basic auth dengan username n password
		$this->client->http_login("pwbs", "rest");

		// membaca segment dari url, di hitung setelah index.php
		// $token = $this->uri->total_segments(); -> total = 3

		// ambil nilai npm
		$token = $this->uri->segment(3);
		// echo $token;

		$tampil = json_decode(
			$this->client->simple_get(
				APIMAHASISWA,
				array(
					"npm" => $token,
					$this->key_name => $this->key_value
				)
			)
		);

		foreach ($tampil->mahasiswa as $result) {
			// echo $result->npm_mhs."<br>";
			$data = array(
				"npm" => $result->npm_mhs,
				"nama" => $result->nama_mhs,
				"telepon" => $result->telepon_mhs,
				"jurusan" => $result->jurusan_mhs,
				"token" => $token
			);
		}
		$this->load->view('up_mahasiswa', $data);
	}

	// fungsi update mahasiswa
	function setUpdate()
	{
		// setup basic auth dengan username n password
		$this->client->http_login("pwbs", "rest");

		// baca nilai dari fetch
		// menggunakan $data array
		$data = array(
			"npm" => $this->input->post("npmnya"),
			"nama" => $this->input->post("namanya"),
			"telepon" => $this->input->post("teleponnya"),
			"jurusan" => $this->input->post("jurusannya"),
			"token" => $this->input->post("tokennya"),
			$this->key_name => $this->key_value
		);

		$update = json_decode(
			$this->client->simple_put(APIMAHASISWA, $data)
		);

		echo json_encode(array("statusnya" => $update->status));
	}
}
