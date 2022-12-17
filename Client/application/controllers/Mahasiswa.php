<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mahasiswa extends CI_Controller {

	public function index()
	{
		$data["tampil"] = json_decode(
			$this->client->simple_get(APIMAHASISWA)
		);

		// foreach($data["tampil"] -> mahasiswa as $result) {
		// 	echo $result->npm_mhs."<br>";
		// }

		$this->load->view('vw_mahasiswa', $data);
	}

	function setDelete() {
		// buat variabel json
		$json = file_get_contents("php://input");
		$hasil = json_decode($json);

		$delete = json_decode(
			$this->client->simple_delete(
				APIMAHASISWA,
				array("npm" => $hasil -> npmnya)
			)
		);

		// isi nilai err
		// $err = 0;

		// kirim hasil ke vw_mahasiswa
		// status ini dapat dari file server controller mahasiswa 
		// dari response ketika hasil == 1, diambil parameter status.
		echo json_encode(array("statusnya" => $delete -> status));
	}

	function addMahasiswa() {
		$this->load->view('en_mahasiswa');
	}

	// fungsi untuk simpan data
	function setSave() {
		// baca nilai dari fetch
		// menggunakan $data array
		$data = array(
			"npm" => $this->input->post("npmnya"),
			"nama" => $this->input->post("namanya"),
			"telepon" => $this->input->post("teleponnya"),
			"jurusan" => $this->input->post("jurusannya"),
			"token" => $this->input->post("npmnya")
		);

		$save = json_decode(
			$this->client->simple_post(APIMAHASISWA, $data)
		);

		echo json_encode(array("statusnya" => $save -> status));
	}

	// fungsi untuk update data
	function updateMahasiswa() {
		// membaca segment dari url, di hitung setelah index.php
		// $token = $this->uri->total_segments(); -> total = 3

		// ambil nilai npm
		$token = $this->uri->segment(3);
		// echo $token;

		$tampil = json_decode(
			$this->client->simple_get(APIMAHASISWA, array("npm" => $token))
		);

		foreach($tampil -> mahasiswa as $result) {
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
	function setUpdate() {
		// baca nilai dari fetch
		// menggunakan $data array
		$data = array(
			"npm" => $this->input->post("npmnya"),
			"nama" => $this->input->post("namanya"),
			"telepon" => $this->input->post("teleponnya"),
			"jurusan" => $this->input->post("jurusannya"),
			"token" => $this->input->post("tokennya"),
		);

		$update = json_decode(
			$this->client->simple_put(APIMAHASISWA, $data)
		);

		echo json_encode(array("statusnya" => $update -> status));
	}

}
?>