<?php

      class login{

        public function __construct(){
          $this->dbh = new PDO('mysql:host=localhost; dbname=rancangan_spk','root','');
        }

        public function login($username){
          $sql= "SELECT*FROM login_biz WHERE username='$username'";
          $query=$this->dbh->query($sql);
          return $query;
        }

        public function update_password($username, $password){
          $sql= "UPDATE login_biz SET password='$password'  WHERE username='$username'";
          $query=$this->dbh->query($sql);
          return $query;
        }

        public function input_form($string) {
          $string = stripslashes($string);
          $string = strip_tags($string);
          // $string = mysql_real_escape_string($string);
          return $string;
        }

        public function add_user($username, $password, $level){
          $stmt = $this->dbh->prepare("INSERT INTO login_biz (username, password, level) VALUES(:username, :password,:level)");
          $stmt->bindparam(":username",$username);
          $stmt->bindparam(":password",$password);
          $stmt->bindparam(":level",$level);
          $stmt->execute();
        }

        public function del_user($username){
          $sql = "DELETE FROM login_biz WHERE username='$username'";
          $query = $this->dbh->query($sql);
        }

        public function cek_username($username){
          $sql="SELECT * FROM login_biz WHERE username='$username'";
          $query=$this->dbh->query($sql);
          return $query;
        }

        public function users(){
          $sql="SELECT * FROM login_biz";
          $query=$this->dbh->query($sql);
          while ($data_user = $query->fetch(PDO::FETCH_ASSOC))
          $data[]=$data_user;
          return $data;
        }

        public function encrypt($pass){
          $sha1=sha1($pass, "Ebiz");
          $base64_encode=base64_encode($sha1);
          $crypt=crypt($base64_encode,"Ebiz");
          $md5=md5($crypt, "Ebiz");
          return $md5;
        }

        // public function random(){
        //   $angka=range(0,9);
        //   shuffle($angka); //acak angka
        //   $ambil_angka=array_rand($angka,6); //ambil 6 digit
        //   $code=$ambil_angka;
        //   return $code;
        // }

      }

class individu{

      public function __construct(){
        $this->dbh = new PDO('mysql:host=localhost; dbname=rancangan_spk','root','');
      }

      public function chart_ksm(){
          $sql= "SELECT nama_ksm, SUM(pnpm_mp) AS total_pnpm_mp, SUM(swadaya) AS total_swadaya FROM ksm_biz GROUP BY nama_ksm";
          $query=$this->dbh->query($sql);
          return $query;
        }

      public function chart_ksm_pnpm($nama_ksm){
        $sql="SELECT*FROM ksm_biz WHERE nama_ksm='$nama_ksm'";
        $query= $this->dbh->query($sql);
        return $query;
      }

      // tabel calon_penerima
      public function add_calon_penerima($id_ksm_nya,$no_ktp,$no_warmis, $long,$lat,$tanggal){
        $stmt = $this->dbh->prepare("INSERT INTO calon_penerima_biz (id_ksm, no_ktp, no_warmis,longitude, latitude, tanggal) VALUES
        (:id_ksm_nya,:no_ktp,:no_warmis, :long,:lat,:tanggal)");
        $stmt->bindparam(":id_ksm_nya",$id_ksm_nya);
        $stmt->bindparam(":no_ktp",$no_ktp);
        $stmt->bindparam(":no_warmis",$no_warmis);
        $stmt->bindparam(":long",$long);
        $stmt->bindparam(":lat",$lat);
        $stmt->bindparam(":tanggal",$tanggal);
        $stmt->execute();
        }

        public function update_biaya($id_calon_penerima, $biaya){
          $stmt = $this->dbh->prepare("UPDATE calon_penerima_biz SET biaya=:biaya WHERE id_calon_penerima=:id_calon_penerima");
          $stmt->bindparam(":id_calon_penerima",$id_calon_penerima);
          $stmt->bindparam(":biaya",$biaya);
          $stmt->execute();
        }

        public function status_penilaian($id_calon_penerima){
          $stmt = $this->dbh->prepare("UPDATE calon_penerima_biz SET status_penilaian='Y' WHERE id_calon_penerima=:id_calon_penerima");
          $stmt->bindparam(":id_calon_penerima",$id_calon_penerima);
          $stmt->execute();
        }


        public function show_calon_penerima($status){
          $stmt = $this->dbh->prepare("SELECT * FROM calon_penerima_biz WHERE status_diterima=:status ORDER BY id_calon_penerima");
          $stmt->bindparam(":status",$status);
          $stmt->execute();
          return $stmt;
        }

        public function show_calon_penerima_analisa($status, $status_penilaian){
          $stmt = $this->dbh->prepare("SELECT * FROM calon_penerima_biz WHERE status_penilaian=:status_penilaian AND status_diterima=:status ORDER BY id_calon_penerima");
          $stmt->bindparam(":status",$status);
          $stmt->bindparam(":status_penilaian",$status_penilaian);
          $stmt->execute();
          return $stmt;
        }

        public function show_riwayat_penerima($no_ktp){
          $sql = "SELECT * FROM calon_penerima_biz WHERE no_ktp='$no_ktp' ORDER BY tanggal DESC";
          $query = $this->dbh->query($sql);
          return $query;
        }

        public function cari_penerima($start, $end, $status){
          $sql = "SELECT * FROM calon_penerima_biz WHERE tanggal_proses BETWEEN '$start' AND '$end' AND status_diterima='$status' ORDER BY id_calon_penerima";
          $query = $this->dbh->query($sql);
          return $query;
        }

        public function detail_calon_penerima($id_calon_penerima){
          $sql = "SELECT * FROM calon_penerima_biz WHERE id_calon_penerima='$id_calon_penerima'";
          $query = $this->dbh->query($sql);
          return $query;
        }

        public function sql_where($pilih){
          $sql_where = "'".@implode("','", $pilih)."'";
          $sql = "SELECT * FROM calon_penerima_biz WHERE id_calon_penerima IN ($sql_where) ORDER BY id_calon_penerima";
          $query = $this->dbh->query($sql);
          return $query;
        }

        public function update_status_calon_penerima($status, $id_calon_penerima, $tanggal){
          $sql="UPDATE calon_penerima_biz SET status_diterima ='$status', tanggal_proses='$tanggal' WHERE id_calon_penerima ='$id_calon_penerima'";
          $query= $this->dbh->query($sql);
          return $query;
        }

        public function update_id_analisa($id, $id_calon_penerima){
          $sql="UPDATE calon_penerima_biz SET id_analisa ='$id' WHERE id_calon_penerima ='$id_calon_penerima'";
          $query= $this->dbh->query($sql);
          return $query;
        }

        // public function lap_update_id_analisa($id){
        //   $sql="SELECT*FROM calon_penerima_biz WHERE id_analisa ='$id' ORDER BY tot_nilai DESC";
        //   $query= $this->dbh->query($sql);
        //   return $query;
        // }

        public function update_tot_nilai_calon_penerima($id_calon_penerima, $nilai){
          $sql="UPDATE calon_penerima_biz SET tot_nilai ='$nilai' WHERE id_calon_penerima ='$id_calon_penerima'";
          $query= $this->dbh->query($sql);
          return $query;
        }

        public function update_calon_penerima($id_calon_penerima, $lat, $long, $no_warmis){
          $sql="UPDATE calon_penerima_biz SET latitude='$lat', longitude='$long', no_warmis='$no_warmis' WHERE id_calon_penerima ='$id_calon_penerima'";
          $query= $this->dbh->query($sql);
          return $query;
        }

        public function detail_calon_penerima_ksm($id_ksm){
          $sql = "SELECT * FROM calon_penerima_biz WHERE id_ksm='$id_ksm' ORDER BY id_calon_penerima";
          $query = $this->dbh->query($sql);
          return $query;
        }

        public function cek_calon_penerimanya($id_ksm, $no_ktp){
          $sql = "SELECT * FROM calon_penerima_biz WHERE id_ksm='$id_ksm' AND no_ktp='$no_ktp' ORDER BY id_calon_penerima";
          $query = $this->dbh->query($sql);
          return $query;
        }

        public function delete_calon_penerima($id_calon_penerima){
          $sql = "DELETE FROM calon_penerima_biz WHERE id_calon_penerima='$id_calon_penerima'";
          $query = $this->dbh->query($sql);
        }

        public function chart_biaya(){
          $sql="SELECT SUM(biaya) as total,tanggal_proses from calon_penerima_biz WHERE status_diterima='Y' GROUP BY tanggal_proses";
          $query=$this->dbh->query($sql);
          return $query;
        }

        public function chart_penerima($status){
          $sql="SELECT*FROM calon_penerima_biz WHERE status_diterima='$status' ORDER BY id_calon_penerima";
          $query= $this->dbh->query($sql);
          $jumlah=$query->rowCount();
          return $jumlah;
        }

        public function chart_hasil_seleksi(){
        $sql="SELECT SUM(jumlah_diterima) AS diterima, SUM(jumlah_ditolak) AS ditolak FROM analisa_biz";
        $query= $this->dbh->query($sql);
        return $query;
        }

      // tabel foto

      public function add_foto($nama,$id_calon_penerima,$kondisi,$keterangan,$nama_file){
         $stmt = $this->dbh->prepare("INSERT INTO foto_biz (nama_foto, id_calon_penerima, kondisi, keterangan, foto) VALUES (:nama,:id_calon_penerima,:kondisi,:keterangan,:nama_file)");
         $stmt->bindparam(":nama",$nama);
         $stmt->bindparam(":id_calon_penerima",$id_calon_penerima);
         $stmt->bindparam(":kondisi",$kondisi);
         $stmt->bindparam(":keterangan",$keterangan);
         $stmt->bindparam(":nama_file",$nama_file);
         $stmt->execute();
      }

      public function show_foto($id_calon_penerima){
        $sql = "SELECT * FROM foto_biz WHERE id_calon_penerima='$id_calon_penerima'";
        $query = $this->dbh->query($sql);
        return $query;
      }

      public function show_galery_foto(){
        $sql = "SELECT * FROM foto_biz ";
        $query = $this->dbh->query($sql);
        return $query;
      }

      public function detail_foto($id_foto){
        $sql = "SELECT * FROM foto_biz WHERE id_foto='$id_foto'";
        $query = $this->dbh->query($sql);
        return $query;
      }

      public function del_foto($id_foto){
        $sql = "DELETE FROM foto_biz WHERE id_foto='$id_foto'";
        $query = $this->dbh->query($sql);
      }

      // tabel ksm
      public function del_ksm($id_ksm){
        $sql = "DELETE FROM ksm_biz WHERE id_ksm='$id_ksm'";
        $query = $this->dbh->query($sql);
      }

      public function show_ksm(){
        $sql="SELECT*FROM ksm_biz ORDER BY id_ksm";
        $query= $this->dbh->query($sql);
        return $query;
      }

      public function show_ksm_status($status){
        $sql="SELECT*FROM ksm_biz WHERE status='$status' ORDER BY id_ksm";
        $query= $this->dbh->query($sql);
        return $query;
      }

      public function cari_ksm($start, $end){
        $sql = "SELECT * FROM ksm_biz WHERE status='Y' AND tanggal BETWEEN '$start' AND '$end' ORDER BY id_ksm";
        $query = $this->dbh->query($sql);
        return $query;
      }

      public function detail_ksm($id_ksm){
        $sql="SELECT*FROM ksm_biz WHERE id_ksm='$id_ksm'";
        $query= $this->dbh->query($sql);
        return $query;
      }

      public function detail_penduduk($nik){
        $sql="SELECT*FROM penduduk WHERE nik='$nik'";
        $query= $this->dbh->query($sql);
        return $query;
      }

      public function cek_ksm($nama_ksm, $no_ktp_ketua, $lokasi){
        $sql="SELECT*FROM ksm_biz WHERE nama_ksm='$nama_ksm' AND lokasi='$lokasi' AND no_ktp_ketua='$no_ktp_ketua' ORDER BY id_ksm";
        $query= $this->dbh->query($sql);
        return $query;
      }

      public function add_ksm($id_periode, $nama_ksm, $pnpm_mp, $swadaya, $jenis_pekerjaan, $lokasi, $no_ktp_ketua, $no_ktp_sekertaris,$no_ktp_bendahara, $tanggal){
        $stmt = $this->dbh->prepare("INSERT INTO ksm_biz (id_periode, nama_ksm, pnpm_mp, swadaya, jenis_pekerjaan, lokasi, no_ktp_ketua, no_ktp_sekertaris, no_ktp_bendahara, tanggal)
        VALUES(:id_periode, :nama_ksm, :pnpm_mp, :swadaya, :jenis_pekerjaan, :lokasi, :no_ktp_ketua, :no_ktp_sekertaris, :no_ktp_bendahara, :tanggal)");
        $stmt->bindparam(":id_periode",$id_periode);
        $stmt->bindparam(":nama_ksm",$nama_ksm);
        $stmt->bindparam(":pnpm_mp",$pnpm_mp);
        $stmt->bindparam(":swadaya",$swadaya);
        $stmt->bindparam(":jenis_pekerjaan",$jenis_pekerjaan);
        $stmt->bindparam(":lokasi",$lokasi);
        $stmt->bindparam(":no_ktp_ketua",$no_ktp_ketua);
        $stmt->bindparam(":no_ktp_sekertaris",$no_ktp_sekertaris);
        $stmt->bindparam(":no_ktp_bendahara",$no_ktp_bendahara);
        $stmt->bindparam(":tanggal",$tanggal);
        $stmt->execute();
      }

      public function update_ksm($id_ksm, $nama_ksm, $pnpm_mp, $swadaya, $jenis_pekerjaan, $lokasi, $no_ktp_ketua, $no_ktp_sekertaris, $no_ktp_bendahara){
        $sql= "UPDATE ksm_biz SET nama_ksm='$nama_ksm', pnpm_mp='$pnpm_mp', swadaya='$swadaya', jenis_pekerjaan='$jenis_pekerjaan', lokasi='$lokasi', no_ktp_ketua='$no_ktp_ketua', no_ktp_sekertaris='$no_ktp_sekertaris', no_ktp_bendahara='$no_ktp_bendahara' WHERE id_ksm='$id_ksm'";
        $query= $this->dbh->query($sql);
      }

      public function update_status_ksm($status, $id_ksm){
        $sql="UPDATE ksm_biz SET status = '$status' WHERE id_ksm = '$id_ksm'";
        $query= $this->dbh->query($sql);
        return $query;
      }

      public function hasil_chart_dana($values){
        $sql="SELECT SUM(pnpm_mp) AS pnpm, SUM(swadaya) AS swadaya FROM ksm_biz WHERE status='Y' AND id_periode='$values'";
        $query= $this->dbh->query($sql);
        return $query;
      }

      public function hasil_chart_coba($values){
        $sql="SELECT SUM(pnpm_mp) AS pnpm, SUM(swadaya) AS swadaya FROM ksm_biz WHERE status='Y' AND id_ksm='$values'";
        $query= $this->dbh->query($sql);
        return $query;
      }

      //
      public function lap_hasil_analisa($id_analisa){
        $sql = "SELECT * FROM log_penilaian_biz WHERE id_analisa='$id_analisa' GROUP BY id_calon_penerima ORDER BY id_calon_penerima";
        $query = $this->dbh->query($sql);
        return $query;
      }

      // tabel penduduk
      public function penduduk($nik){
        $sql="SELECT * FROM penduduk WHERE nik='$nik'";
        $query=$this->dbh->query($sql);
        return $query;
      }

      public function list_penduduk(){
        $sql="SELECT nik FROM penduduk";
        $query=$this->dbh->query($sql);
        return $query;
      }

      // tabel periode
      public function cek_tahun($tahun){
        $sql="SELECT*FROM periode_biz WHERE tahun='$tahun' ORDER BY id_periode";
        $query= $this->dbh->query($sql);
        return $query;
      }

      public function add_periode(){
        $tahun=date("Y");
        $sql="INSERT INTO periode_biz (tahun) VALUES ($tahun)";
        $query= $this->dbh->query($sql);
        return true;
      }

      public function data_chart_periode(){
        $sql="SELECT * FROM periode_biz GROUP BY tahun";
        $query= $this->dbh->query($sql);
        return $query;
      }

      public function data_chart_coba(){
        $sql="SELECT * FROM ksm_biz GROUP BY nama_ksm";
        $query= $this->dbh->query($sql);
        return $query;
      }
      //

      public function hasil_chart_seleksi($values){
        $sql="SELECT SUM(jumlah_diterima) AS diterima, SUM(jumlah_ditolak) AS ditolak FROM analisa_biz WHERE id_periode='$values'";
        $query= $this->dbh->query($sql);
        return $query;
      }

      // ===========> extract or foreach
      public function det_penduduk($nik){
        $stmt = $this->dbh->prepare("SELECT*FROM penduduk WHERE nik=:nik");
        $stmt->execute(array(":nik"=>$nik));
    		$data=$stmt->fetch(PDO::FETCH_ASSOC);
    		return $data;
      }

      public function det_calon_penerima($id_calon_penerima){
        $stmt = $this->dbh->prepare("SELECT * FROM calon_penerima_biz WHERE id_calon_penerima=:id_calon_penerima");
        $stmt->execute(array(":id_calon_penerima"=>$id_calon_penerima));
    		$data=$stmt->fetch(PDO::FETCH_ASSOC);
    		return $data;
      }

      public function lap_update_id_analisa($id){
      $sql="SELECT*FROM calon_penerima_biz WHERE id_analisa ='$id' ORDER BY tot_nilai DESC";
      $query= $this->dbh->query($sql);
      while ($data = $query->fetch(PDO::FETCH_ASSOC))
      $tampil[]=$data;
      return $tampil;
      }
      // ===========> end <============

  }

 class profile_matching{

        public function __construct(){
          $this->dbh = new PDO('mysql:host=localhost; dbname=rancangan_spk','root','');
        }

        public function del_analisa($id_analisa){
          $stmt= $this->dbh->prepare("DELETE FROM analisa_biz WHERE id_analisa=:id_analisa ");
          $stmt->bindparam(":id_analisa",$id_analisa);
          $stmt->execute();
          return true;
        }

        public function update_status_diterima($id_analisa){
          $sql="UPDATE calon_penerima_biz SET status_diterima ='P' WHERE id_analisa ='$id_analisa'";
          $query= $this->dbh->query($sql);
          return true;
        }

        // tabel kriteria
        public function show_kriteria(){
          $sql= "SELECT*FROM kriteria_biz ORDER BY id_kriteria";
          $query=$this->dbh->query($sql);
          return $query;
        }

        public function show_kriteria_jenis($jenis){
          $sql= "SELECT*FROM kriteria_biz WHERE jenis_kriteria='$jenis' ORDER BY id_kriteria";
          $query=$this->dbh->query($sql);
          return $query;
        }
        //Analisa_Baru
        public function show_kriteria_analisa(){
          $sql= "SELECT*FROM kriteria_biz ORDER BY jenis_kriteria, id_kriteria";
          $query=$this->dbh->query($sql);
          return $query;
        }

        public function add_kriteria($nama_kriteria,$jenis_kriteria){
           $stmt = $this->dbh->prepare("INSERT INTO kriteria_biz (nama_kriteria,jenis_kriteria) VALUES(:nama_kriteria, :jenis_kriteria)");
           $stmt->bindparam(":nama_kriteria",$nama_kriteria);
           $stmt->bindparam(":jenis_kriteria",$jenis_kriteria);
           $stmt->execute();
        }

        public function edit_kriteria($id_kriteria){
          $sql= "SELECT*FROM kriteria_biz WHERE id_kriteria='$id_kriteria' ";
          $query=$this->dbh->query($sql);
          return $query;
        }

        public function cek_kriteria($nama_kriteria){
          $sql= "SELECT*FROM kriteria_biz WHERE nama_kriteria='$nama_kriteria' ";
          $query=$this->dbh->query($sql);
          return $query;
        }

        public function update_kriteria($id_kriteria, $nama_kriteria,$jenis_kriteria){
          $stmt = $this->dbh->prepare("UPDATE kriteria_biz SET nama_kriteria=:nama_kriteria, jenis_kriteria=:jenis_kriteria WHERE id_kriteria=:id_kriteria ");
          $stmt->bindparam(":nama_kriteria",$nama_kriteria);
          $stmt->bindparam(":jenis_kriteria",$jenis_kriteria);
          $stmt->bindparam(":id_kriteria",$id_kriteria);
          $stmt->execute();
          return true;
        }

        public function delete_kriteria($id_kriteria){
          $stmt= $this->dbh->prepare("DELETE FROM kriteria_biz WHERE id_kriteria=:id_kriteria ");
          $stmt->bindparam(":id_kriteria",$id_kriteria);
          $stmt->execute();
          return true;
        }
        // ============================================================

        // tabel sub kriteria

        public function show_sub_kriteria($id_kriteria){
          $sql= "SELECT*FROM sub_kriteria_biz WHERE id_kriteria='$id_kriteria' ORDER BY nilai";
          $query=$this->dbh->query($sql);
          return $query;
        }

        public function detail_sub_kriteria($id_sub_kriteria){
          $sql= "SELECT*FROM sub_kriteria_biz WHERE id_sub_kriteria='$id_sub_kriteria' ORDER BY id_sub_kriteria";
          $query=$this->dbh->query($sql);
          return $query;
        }

        public function cek_sub_kriteria($nama_sub_kriteria){
          $sql= "SELECT*FROM sub_kriteria_biz WHERE nama_sub_kriteria='$nama_sub_kriteria' ORDER BY id_sub_kriteria";
          $query=$this->dbh->query($sql);
          return $query;
        }

        public function delete_sub_ktiteria($id_sub_kriteria){
          $stmt= $this->dbh->prepare("DELETE FROM sub_kriteria_biz WHERE id_sub_kriteria=:id_sub_kriteria ");
          $stmt->bindparam(":id_sub_kriteria",$id_sub_kriteria);
          $success=$stmt->execute();
          if (!$success){
            return "N";
          }else{
            return "Y";
          }
        }

        public function update_sub_kriteria($id_sub_kriteria, $nama_sub_kriteria, $id_kriteria, $nilai){
          $stmt= $this->dbh->prepare("UPDATE sub_kriteria_biz SET nama_sub_kriteria=:nama_sub_kriteria, id_kriteria=:id_kriteria, nilai=:nilai WHERE id_sub_kriteria=:id_sub_kriteria ");
          $stmt->bindparam(":id_sub_kriteria",$id_sub_kriteria);
          $stmt->bindparam(":nama_sub_kriteria",$nama_sub_kriteria);
          $stmt->bindparam(":id_kriteria",$id_kriteria);
          $stmt->bindparam(":nilai",$nilai);
          $stmt->execute();
          return true;
        }

        public function add_sub_kriteria( $nama_sub_kriteria, $id_kriteria, $nilai){
          $stmt= $this->dbh->prepare("INSERT INTO sub_kriteria_biz (nama_sub_kriteria, id_kriteria, nilai) VALUES (:nama_sub_kriteria, :id_kriteria,:nilai)");
          $stmt->bindparam(":nama_sub_kriteria",$nama_sub_kriteria);
          $stmt->bindparam(":id_kriteria",$id_kriteria);
          $stmt->bindparam(":nilai",$nilai);
          $stmt->execute();
          return true;
        }

        public function relasi_sub_kriteria($id_kriteria){
          $sql= "SELECT * FROM sub_kriteria_biz WHERE id_kriteria='$id_kriteria' ORDER BY id_sub_kriteria ";
          $query = $this->dbh->query($sql);
          return $query;
        }

        // validasi sub kriteria
        public function validasi_sub_kriteria_nilai($id_kriteria, $nilai){
          $sql= "SELECT * FROM sub_kriteria_biz WHERE id_kriteria='$id_kriteria'AND nilai='$nilai'";
          $query = $this->dbh->query($sql);
          return $query;
        }

        public function validasi_sub_kriteria_nama($id_kriteria, $nama){
          $sql= "SELECT * FROM sub_kriteria_biz WHERE id_kriteria='$id_kriteria'AND nama_sub_kriteria='$nama'";
          $query = $this->dbh->query($sql);
          return $query;
        }
        //

        // validasi kriteria

        public function validasi_kriteria_nama($id_kriteria, $nama){
          $sql= "SELECT * FROM sub_kriteria_biz WHERE id_kriteria='$id_kriteria'AND nama_sub_kriteria='$nama'";
          $query = $this->dbh->query($sql);
          return $query;
        }
        //

        // ======================================================

        // tabel log penilaian
        //lap perhitungan
        public function lap_perhitungan_kriteria($id_analisa){
          $sql= "SELECT*FROM log_penilaian_biz WHERE id_analisa='$id_analisa' GROUP BY nama_kriteria ORDER BY jenis_kriteria, id_log_penilaian";
          $query=$this->dbh->query($sql);
          return $query;
        }

        public function lap_perhitungan_nilai_individu($id_analisa, $id_calon_penerima, $nama_kriteria){
          $sql= "SELECT*FROM log_penilaian_biz WHERE id_analisa='$id_analisa' AND id_calon_penerima='$id_calon_penerima' AND nama_kriteria='$nama_kriteria'";
          $query=$this->dbh->query($sql);
          return $query;
        }

        public function del_log_penilaian($id_calon_penerima){
          $sql= "DELETE FROM log_penilaian_biz WHERE id_calon_penerima='$id_calon_penerima'";
          $query=$this->dbh->query($sql);
        }

         public function add_log_penilaian($id_calon_penerima, $last_id, $nama_kriteria, $jenis_kriteria, $nilai_profil_penerima, $nilai_standar_profile, $tanggal){
         $sql = "INSERT INTO log_penilaian_biz (id_calon_penerima, id_analisa, nama_kriteria, jenis_kriteria, nilai_profile_individu, nilai_standar_profile, tanggal) VALUES ('$id_calon_penerima', '$last_id', '$nama_kriteria','$jenis_kriteria', '$nilai_profil_penerima', '$nilai_standar_profile','$tanggal')";
         $query=$this->dbh->query($sql);
        }

        public function rata_rata_nilai($jenis_kriteria, $id_calon_penerima, $total_gap){
          $sql= "SELECT*FROM log_penilaian_biz WHERE jenis_kriteria='$jenis_kriteria' AND id_calon_penerima='$id_calon_penerima' ORDER BY id_log_penilaian";
          $query= $this->dbh->query($sql);
          $jumlah=$query->rowCount();//hitung jumlah jenis kriteria
          $rata_rata=$total_gap/$jumlah;//hitung nilai rata-rata
          return $rata_rata;
        }

        public function log_penilaian($id_calon_penerima){
          $sql= "SELECT*FROM log_penilaian_biz WHERE id_calon_penerima='$id_calon_penerima' ORDER BY jenis_kriteria";
          $query= $this->dbh->query($sql);
          return $query;
        }
        // baru
        public function log_penilaiannya($id_calon_penerima){
          $sql= "SELECT*FROM log_penilaian_biz WHERE id_calon_penerima='$id_calon_penerima' ORDER BY jenis_kriteria, id_log_penilaian";
          $query= $this->dbh->query($sql);
          return $query;
        }
        // batu

        public function log_penilaian_periode($id_analisa){
          $sql= "SELECT*FROM log_penilaian_biz WHERE id_analisa='$id_analisa' GROUP BY nama_kriteria ORDER BY id_log_penilaian";
          $query= $this->dbh->query($sql);
          return $query;
        }

        // ========================================================

        // nilai_profile_calon_penerima
        //Analisa_Baru
        public function nilai_profile_analisis($id_calon_penerima, $id_kriteria){
          $sql= "SELECT*FROM nilai_profil_penerima_biz WHERE id_calon_penerima='$id_calon_penerima' AND id_kriteria='$id_kriteria'";
          $query= $this->dbh->query($sql);
          return $query;
        }

        public function cek_penilaian($id_calon_penerima){
          $sql= "SELECT*FROM nilai_profil_penerima_biz WHERE id_calon_penerima='$id_calon_penerima' ORDER BY id_kriteria";
          $query= $this->dbh->query($sql);
          return $query;
        }

        public function update_tot_nilai($id_calon_penerima, $tot_nilai){
          $i=0;
          $sql = "UPDATE calon_penerima_biz SET tot_nilai='$tot_nilai[$i]' WHERE id_calon_penerima='$id_calon_penerima' ";
          $query= $this->dbh->query($sql);
          return $query;
        }

        public function del_nilai_profil($id_calon_penerima){
          $sql= "DELETE FROM nilai_profil_penerima_biz WHERE id_calon_penerima='$id_calon_penerima'";
          $query=$this->dbh->query($sql);
        }

        public function add_nilai_profile_penerima($id_calon_penerima, $id_kriteria, $id_sub_kriteria){
        $sql = "INSERT INTO nilai_profil_penerima_biz (id_calon_penerima, id_kriteria, id_sub_kriteria) VALUES ('$id_calon_penerima', '$id_kriteria', '$id_sub_kriteria' )";
        $query=$this->dbh->query($sql);
        if (!$query){
          return "Failed";
        }else{
          return "Success";
        }
       }

      public function nilai_profile($id_calon, $id_kriteria, $id_sub_kriterianya){
        $sql= "SELECT*FROM nilai_profil_penerima_biz WHERE id_calon_penerima='$id_calon' AND id_kriteria='$id_kriteria' AND  id_sub_kriteria='$id_sub_kriterianya'";
        $query= $this->dbh->query($sql);
        return $query;
      }
      // =====================================================================

        public function add_analisa($jumlah_diterima, $jumlah_ditolak, $tahun, $tanggal){
           $stmt = $this->dbh->prepare("INSERT INTO analisa_biz (jumlah_diterima, jumlah_ditolak,id_periode, tanggal_proses) VALUES(:jumlah_diterima, :jumlah_ditolak, :tahun,:tanggal)");
           $stmt->bindparam(":jumlah_diterima",$jumlah_diterima);
           $stmt->bindparam(":jumlah_ditolak",$jumlah_ditolak);
           $stmt->bindparam(":tahun",$tahun);
           $stmt->bindparam(":tanggal",$tanggal);
           $stmt->execute();
        }

        public function lap_analisa(){
          $sql= "SELECT*FROM analisa_biz ORDER BY id_analisa";
          $query= $this->dbh->query($sql);
          return $query;
        }

        public function invoice_analisa($id_analisa){
          $sql= "SELECT*FROM analisa_biz WHERE id_analisa='$id_analisa'";
          $query= $this->dbh->query($sql);
          return $query;
        }
        // ================================================================

        public function del_standar_profile(){
          $sql = "DELETE FROM standar_profile_biz";
          $query = $this->dbh->query($sql);
          return $query;
        }

        public function add_standar_profile($i, $id_kriteria, $id_sub){
          $sql="INSERT INTO standar_profile_biz (id_standar_profile, id_kriteria, id_sub_kriteria) VALUES ('$i', '$id_kriteria', '$id_sub')";
          $query = $this->dbh->query($sql);
          if (!$query){
            return "Failed";
          }else{
            return "Success";
          }
        }

        public function standar_profile($id_kriteria, $id_sub_kriteria){
          $sql= "SELECT*FROM standar_profile_biz WHERE id_kriteria='$id_kriteria' AND  id_sub_kriteria='$id_sub_kriteria'";
          $query= $this->dbh->query($sql);
          return $query;
        }

        public function show_standar_profile(){
          $sql= "SELECT*FROM standar_profile_biz ORDER BY id_kriteria";
          $query= $this->dbh->query($sql);
          return $query;
        }

        //Analisa
        public function lihat_standar_profile($id_kriteria){
          $sql= "SELECT*FROM standar_profile_biz WHERE id_kriteria='$id_kriteria'";
          $query= $this->dbh->query($sql);
          return $query;
        }

        // ===============================================================================

        public function status_penilaian($id_calon_penerima){
          $cek_status=$this->cek_penilaian($id_calon_penerima);
          $status_nilai=$cek_status->fetch(PDO::FETCH_OBJ);
          $cek_id=empty($status_nilai->id_calon_penerima)?'':$status_nilai->id_calon_penerima;
          if ($id_calon_penerima==$cek_id) {
            $status ="Y";
          }else{
            $status="N";
          }
          return $status;
        }

        public function bobot_nilai_gap($Gap){
          $Nilai_Gap=0;
          if ($Gap==0) {
            $Nilai_Gap=5;
          }elseif ($Gap==1) {
            $Nilai_Gap=4.5;
          }elseif ($Gap==2) {
            $Nilai_Gap=3.5;
          }elseif ($Gap==3) {
            $Nilai_Gap=2.5;
          }elseif ($Gap==4) {
            $Nilai_Gap=1.5;
          }elseif ($Gap==-1) {
            $Nilai_Gap=4;
          }elseif ($Gap==-2) {
            $Nilai_Gap=3;
          }elseif ($Gap==-3) {
            $Nilai_Gap=2;
          }elseif ($Gap==-4) {
            $Nilai_Gap=1;
          }
          return $Nilai_Gap;
        }

        public function rata_rata_analisa($jumlah_kriteria, $total_gap){  //hasil_analisa.php
          $rata_rata=$total_gap/$jumlah_kriteria;
          return $rata_rata;
        }

        public function total_nilai($rata_core, $rata_secondary){
          $total_nilai=($rata_core*0.6)+($rata_secondary*0.4);
          return $total_nilai;
        }

        public function gap($nilai_profile_calon_penerima, $nilai_standar_profile){
          $gap=$nilai_profile_calon_penerima-$nilai_standar_profile;
          return $gap;
        }

        public function tambah($a, $b){
          $hasil=$a+$b;
          return $hasil;
        }

        // foreach
        public function view_sub_kriteria($id_kriteria){
          $sql= "SELECT*FROM sub_kriteria_biz WHERE id_kriteria='$id_kriteria' ORDER BY nilai";
          $query=$this->dbh->query($sql);
          while ($datasub_kriteria=$query->fetch(PDO::FETCH_ASSOC))
          $data[]=$datasub_kriteria;
          return $data;
        }
        //

    }
      ?>
