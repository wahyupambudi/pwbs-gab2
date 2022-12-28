<?php
defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . "libraries/Server.php";

class Mahasiswa extends Server
{

    // membuat constructor untuk model
    public function __construct()
    {
        parent::__construct();
        // Your own constructor code
        $this->load->model("Mmahasiswa", "model", TRUE);
    }

    // keyword service_ ada di libraries/server line 684
    // membuat fungsi GET
    function service_get()
    {

        // ambil parameter token "(npm)"
        $token = $this->delete("npm");

        // test menggunakan npm
        $npm = $this->get('npm');

        // panggil model Mmahasiswa
        // model itu alias ketika di panggil cok
        // $this->load->model("Mmahasiswa", "model", TRUE);

        if ($npm == '') {
            // panggil fungsi get_data
            $mhs = $this->model->get_data(base64_encode($token));
            $this->response(array("mahasiswa" => $mhs), 200);
        } else if ($npm != '') {
            // query where
            $this->db->where("npm", $npm);
            // panggil fungsi get_data
            $mhs = $this->model->get_data(base64_encode($token));
            $this->response(array("mahasiswa" => $mhs), 200);
        } else {
            $this->response(array("status" => "Data Tidak Ditemukan"), 404);
        }
    }


    // untuk get username
    // function service_get()
    // {
    //     $username = $this->get("username");
    //     $hasil = $this->model->get_data($username);

    //     $this->response(array("auth" => $hasil), 200);
    // }

    // membuat fungsi POST
    function service_post()
    {
        // panggil model mahasiswa
        // $this->load->model("Mmahasiswa", "model", TRUE);

        // ambil parameter data yang akan di isi
        $data = array(
            "npm" => $this->post("npm"),
            "nama" => $this->post("nama"),
            "telepon" => $this->post("telepon"),
            "jurusan" => $this->post("jurusan"),
            "token" => base64_encode($this->post("npm"))
        );

        // array prosedural contoh
        // $data["npm"] = $this->post("npm");
        // $npm = $this->post("npm");

        // panggil method save_data
        // $hasil = $this->model->save_data();

        $hasil = $this->model->save_data($data["npm"], $data["nama"], $data["telepon"], $data["jurusan"], $data["token"]);

        // jika hasil = 0
        if ($hasil == 0) {
            $this->response(array("status" => "Data Mahasiswa Berhasil di Simpan"), 200);
        }
        // jika hasil !=0
        else {
            $this->response(array("status" => "Data Mahasiswa Gagal di Simpan"), 200);
        }
    }

    // membuat fungsi PUT
    function service_put()
    {
        // panggil model mahasiswa
        // $this->load->model("Mmahasiswa", "model", TRUE);

        // ambil parameter data yang akan di isi
        $data = array(
            "npm" => $this->put("npm"),
            "nama" => $this->put("nama"),
            "telepon" => $this->put("telepon"),
            "jurusan" => $this->put("jurusan"),
            "token" => base64_encode($this->put("token"))
        );

        // panggil method update_data
        $hasil = $this->model->update_data($data["npm"], $data["nama"], $data["telepon"], $data["jurusan"], $data["token"]);

        // jika hasil = 0
        if ($hasil == 0) {
            // $mhs = $this->model->get_data();
            // $this->response(array("mahasiswa" => $mhs), 200);
            $this->response(array("status" => "Data Mahasiswa Berhasil di Update"), 200);
        }
        // jika hasil !=0
        else {
            $this->response(array("status" => "Data Mahasiswa Gagal di Update"), 200);
        }
    }

    // membuat fungsi DELETE
    function service_delete()
    {
        // panggil model mahasiswa
        // $this->load->model("Mmahasiswa", "model", TRUe);

        // ambil parameter token "(npm)"
        $token = $this->delete("npm");

        // panggil fungsi "delete_data"
        $hasil = $this->model->delete_data(base64_encode($token));

        // jika proses berhasil
        if ($hasil == 1) {
            $this->response(array("status" => "Data Mahasiswa Berhasil di Hapus"), 200);
        }
        // jika porses gagal
        else {
            $this->response(array("status" => "Data Mahasiswa Gagal di Hapus"), 200);
        }
    }
}
