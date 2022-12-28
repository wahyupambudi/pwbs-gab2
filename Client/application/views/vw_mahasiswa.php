<?php
$key = str_shuffle("!@#$%^&*()+_ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789");
// membatasi key
$random_key = substr($key, 0, 10);
echo $random_key;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tampil Data Mahasiswa</title>

    <!-- import font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- import file style.css -->
    <!-- base url di load pada page yang sama -->
    <link rel="stylesheet" href="<?php echo base_url("/ext/style.css") ?>">
</head>

<body>
    <!-- membuat area menu -->
    <nav class="area-menu">
        <button id="btn-tambah" class="btn-primary">Tambah Data</button>
        <button id="btn-refresh" class="btn-secondary" onclick="return setRefresh()">Refresh Data</button>
    </nav>
    <!-- buat area table -->
    <table>
        <!-- judul table -->
        <!-- juduls -->
        <thead>
            <tr>
                <!-- th*6 untuk membuat th 6 -->
                <th style="width: 10%;">Aksi</th>
                <th style="width: 5%;">No.</th>
                <th style="width: 10%;">NPM</th>
                <th style="width: 50%;">Nama</th>
                <th style="width: 15%;">Telepon</th>
                <th style="width: 10%;">Jurusan</th>
            </tr>
        </thead>
        <!-- data table -->
        <tbody>

            <!-- proses looping get data -->
            <?php
            $no = 1;
            foreach ($tampil->mahasiswa as $result) {
                // set nilai awal nomor
            ?>
                <tr>
                    <td style="text-align:center">
                        <nav class="area-aksi">
                            <button class="btn_ubah" id="btn_ubah" title="Ubah Data" onclick="return gotoUpdate('<?php echo $result->npm_mhs; ?>')">
                                <i class="fa-solid fa-pen"></i>
                            </button>
                            <button class="btn_hapus" id="btn_hapus" title="Hapus Data" onclick="return gotoDelete('<?php echo $result->npm_mhs; ?>')">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </nav>
                    </td>
                    <td style="text-align:center"><?= $no ?></td>
                    <td style="text-align:center"><?= $result->npm_mhs ?></td>
                    <td style="text-align:justify"><?= $result->nama_mhs ?></td>
                    <td style="text-align:center"><?= $result->telepon_mhs ?></td>
                    <td style="text-align:center"><?= $result->jurusan_mhs ?></td>
                </tr>

            <?php $no++;
            } ?>

        </tbody>
    </table>

    <!-- import font awesome js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/js/all.min.js" integrity="sha512-naukR7I+Nk6gp7p5TMA4ycgfxaZBJ7MO5iC3Fp6ySQyKFHOGfpkSZkYVWV5R7u7cfAicxanwYQ5D1e17EfJcMA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        // inisialisasi object
        let btn_tambah = document.getElementById("btn-tambah");

        // membuat event untuk tambah // membuat dom
        btn_tambah.addEventListener('click', function() {
            // alert("Tambah Data");

            // dom css manipulasi css property dan value
            // btn_tambah.style.background="red";
            // this.style.borderRadius="10px";
            // this.style.fontSize="30px";

            // manipulasi classname, jika property nya banyak
            // this.className = "btn-secondary";

            // manipulasi html
            // innerHTML pake untuk tambah tag html
            // this.innerHTML = "<strong>ADD DATA</strong>";
            // innerText cuma ganti teks doang
            // this.innerText = "ADD DATA";

            // redirect page/controller (Mahasiswa) fungsi "addMahasiswa"
            // site_url untuk 1 controller beda fungsi
            location.href = '<?php echo site_url("Mahasiswa/addMahasiswa") ?>'
        });


        // implementasi fungsi di object yang berbeda
        // btn_tambah.addEventListener("click", setRefresh)

        // membuat function refresh
        function setRefresh() {
            location.href = '<?php echo base_url(); ?>';
        }

        // membuat function untuk ke halaman update
        function gotoUpdate(npm) {
            // enkripsi javascript
            // npm = "MTkzMTIzMDI=";
            // let npmx = btoa(npm);
            // let npmx = atob(npm);
            location.href = '<?php echo site_url("Mahasiswa/updateMahasiswa"); ?>' + '/' + npm;
        }

        // membuat function untuk delete
        function gotoDelete(npm) {
            if (confirm("Data Mahasiswa " + npm + " Ingin di Hapus?") === true) {
                // alert("Data Berhasil di Hapus");

                // panggil fungsi setDelete
                setDelete(npm);
            }
        }

        function setDelete(npm) {
            // membuat variable / konstanta data
            const data = {
                "npmnya": npm
            }
            // kirim data async dengan fetch
            fetch('<?php echo site_url("Mahasiswa/setDelete"); ?>', {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify(data)
                })
                .then((response) => {
                    return response.json()
                })
                .then(function(data) {
                    // // jika nilai "err" = 0
                    // if(data.err === 0) {
                    //     alert("data berhasil di hapus")
                    // }
                    // // jika anilai err = 1
                    // else {
                    //     alert("data gagal di hapus")
                    // }

                    // menggunakan alert data dari Controller mahasiswa ambil dari statusnya
                    alert(data.statusnya);
                    // panggil fungsi setrefresh
                    setRefresh();
                })
        }
    </script>
</body>

</html>