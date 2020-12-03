<script>
    import queryString from 'query-string'; // import the queryString class
</script>

<!DOCTYPE html>
<html>

<head>
    <?php //$this->load->view('_partial/header.php'); 
    ?>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $judul; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <link rel="stylesheet" href="assets/css/font-awesome.css"> -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <style type="text/css">
        .container-fluid {
            width: auto !important;
            margin-right: 0 !important;
            margin-left: 0 !important;
            margin-top: 10px !important;
        }

        .inner {
            background: brown;
        }

        #key_id {
            position: fixed;
            top: -100px;
        }
    </style>

    <link rel="icon" href="../assets/img/logo.png">

<body onload="resetform()">

    <!--
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">      
      <a class="navbar-brand" href="./">Aplikasi Absensi ASTEL GROUP</a>
    </div>
    <div class="navbar-body">      
      <a class="navbar-brand" href="./">Aplikasi Absensi ASTEL GROUP</a>
    </div>
  </div>
</nav>
-->
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-11 text-left">
                <h1><?php echo $gedung; ?></h1>
            </div>
            <div class="col-md-1 text-left">
                <center><a class="btn btn-danger" href="login/logout"><i class="glyphicon glyphicon-off"></i>&nbsp;Logout</a></center>
            </div>

        </div>
        <div class="row">
            <div class="col-md-12 text-left">
                <h3"><?php echo $gedung_alamat; ?></h3>
            </div>
        </div>
    </div>

    <div class="container-fluid">

        <div class="row">

            <div class="col-md-6">
                <div class="panel panel-danger">
                    <div class="panel-heading">
                        <h3 class="panel-title">Arahkan Kode QR Ke Kamera!</h3>
                    </div>
                    <div class="panel-body text-center">
                        <canvas></canvas>
                        <hr>
                        <select></select>
                    </div>
                    <div class="panel-footer">
                        <center><a class="btn btn-danger" onclick="resetform()">Reset</a></center>
                    </div>
                </div>
            </div>

            <div class="col-md-6">

                <div class="row col-md-12">
                    <input type="text" name="key_id" id="key_id">
                    <!-- <input type="text" name="key_id_" id="key_id_">
                    <button id="scanEnable">Scan</button> -->
                    <!-- buka panel -->
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <h3 class="panel-title">Informasi : </h3>
                        </div>
                        <div class="panel-body text-center">
                            <div class="row">
                                <div class="col-md-12 text-center" id="divimg">
                                    <img src="" class="img-rounded" alt="Absen Image" style="width: 200px; height: 200px;" id="imgabsen">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3 text-left">
                                    <label class="col-md-12">Nama</label>
                                </div>
                                <div class="col-md-1">
                                    <label class="col-md-12">:</label>
                                </div>
                                <div class="col-md-8 text-left" id="divnama">

                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3 text-left">
                                    <label class="col-md-12">Company</label>
                                </div>
                                <div class="col-md-1">
                                    <label class="col-md-12">:</label>
                                </div>
                                <div class="col-md-8 text-left" id="divcompany">

                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3 text-left">
                                    <label class="col-md-12">Divisi</label>
                                </div>
                                <div class="col-md-1">
                                    <label class="col-md-12">:</label>
                                </div>
                                <div class="col-md-8 text-left" id="divdivisi">

                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3 text-left">
                                    <label class="col-md-12">Department</label>
                                </div>
                                <div class="col-md-1">
                                    <label class="col-md-12">:</label>
                                </div>
                                <div class="col-md-8 text-left" id="divdept">

                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3 text-left">
                                    <label class="col-md-12">Score</label>
                                </div>
                                <div class="col-md-1">
                                    <label class="col-md-12">:</label>
                                </div>
                                <div class="col-md-8 text-left" id="divscore">

                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3 text-left">
                                    <label class="col-md-12">Risiko</label>
                                </div>
                                <div class="col-md-1">
                                    <label class="col-md-12">:</label>
                                </div>
                                <div class="col-md-8 text-left" id="divrisiko">

                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3 text-left">
                                    <label class="col-md-12">Jam</label>
                                </div>
                                <div class="col-md-1">
                                    <label class="col-md-12">:</label>
                                </div>
                                <div class="col-md-8 text-left" id="divjam">

                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3 text-left">
                                    <label class="col-md-12">Keterangan</label>
                                </div>
                                <div class="col-md-1">
                                    <label class="col-md-12">:</label>
                                </div>
                                <div class="col-md-8 text-left" id="divketerangan">

                                </div>
                            </div>


                        </div>
                        <div class="panel-footer" id="divpesan">

                        </div>
                    </div>
                    <!-- tutup panel -->
                </div>


                <!------------------------------------------------------->
                <!------------------------------------------------------- disable karena hitung gedung menggunakan aplikasi mediatek
                <div class="row col-md-12">
                
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title">Kapasitas Gedung : </h3>
                        </div>
                        <div class="panel-body text-center">
                            <div class="row">
                                <div class="col-md-4">
                                    <button type="button" class="btn btn-primary">
                                        <strong>TOTAL KAPASITAS</strong> <span class="badge badge-light" id="maksimal_kapasitas">0</span>
                                    </button>
                                </div>
                                <div class="col-md-4">
                                    <button type="button" class="btn btn-success">
                                        <strong>TOTAL MASUK</strong> <span class="badge badge-light" id="total_masuk">0</span>
                                    </button>
                                </div>
                                <div class="col-md-4">
                                    <button type="button" class="btn btn-warning">
                                        <strong>SISA KAPASITAS</strong> <span class="badge badge-light" id="sisa_kapasitas">0</span>
                                    </button>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="progress">
                                    <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuemax="100" aria-valuemin="0" style="width: 45%" id="persentase">
                                        45%
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    
                </div>
                --------------------------------------------------------------->

            </div>

        </div>




    </div>

    <!-- Audio -->
    <audio id="myAudioTrue">
        <source src="assets/audio/thankyou_female.oga" type="audio/ogg">
        <source src="assets/audio/thankyou_female.mp3" type="audio/mpeg">
        Your browser does not support the audio element.
    </audio>

    <audio id="myAudioFalse">
        <source src="assets/audio/tryagain_female_fix.oga" type="audio/ogg">
        <source src="assets/audio/tryagain_female_fix.mp3" type="audio/mpeg">
        Your browser does not support the audio element.
    </audio>
    <!-- Audio -->

    <!-- Js Lib -->
    <script type="text/javascript" src="assets/js/jquery.js"></script>
    <script type="text/javascript" src="assets/js/qrcodelib.js"></script>
    <script type="text/javascript" src="assets/js/webcodecamjquery.js"></script>
    <script type="text/javascript">
        const rootfolder = "eca";
        let scanstatus = false;

        var arg = {
            resultFunction: function(result) {

                //alert("Hai, "+result.code);
                if (!scanstatus) {
                    scanstatus = true;
                    decoder.stop();
                    $.ajax({
                        type: "POST",
                        data: {
                            data_id: result.code
                        },
                        url: "Main/post_scan",
                        dataType: "json",
                        success: function(data) {
                            var keterangan = "";
                            var pesan = "";
                            var tglskg = data.tglskg;
                            if (!data.error) {
                                $('#divnama').html(data.nama);
                                $('#divcompany').html(data.companyid);
                                $('#divdivisi').html(data.divid);
                                $('#divdept').html(data.deptid);
                                $('#divscore').html(data.score);
                                $('#divrisiko').html(data.risiko);
                                $('#divjam').html(data.jam);
                                if (data.keterangan == "IN") {
                                    keterangan = '<span class="label label-success">IN</span>';
                                    pesan = '<center><label>.: SELAMAT DATANG DI ' + data.gedungname + ' :.</label></center>';
                                    //pesan = '<strong><i class="fa fa-warning"></i> Danger!</strong> <marquee><p style="font-family: Impact; font-size: 18pt">.: SELAMAT DATANG DI ' + data.gedungname + ' :.</p></marquee>'
                                } else {
                                    keterangan = '<span class="label label-danger">OUT</span>';
                                    pesan = '<center><label>.: HATI - HATI DALAM PERJALANAN :.</label></center>';
                                }

                                $('#divketerangan').html(keterangan);
                                $('#divpesan').html(pesan);
                                pathname = window.location.origin + "/" + rootfolder + "/assets/images/absen/" + tglskg + "/" + data.image_in;
                                playAudio('berhasil');
                            } else {
                                pesan = '<span class="label label-danger">' + data.errormsg + '</span>';
                                $('#divpesan').html(pesan);
                                pathname = window.location.origin + "/" + rootfolder + "/assets/images/qrcode/noimage.png";
                                playAudio('gagal');
                            }



                            var src1 = pathname;
                            $("#imgabsen").attr("src", src1);

                            setTimeout(function() {
                                resetform();
                            }, 5000);
                            scanstatus = false;
                        },
                        error: function(XMLHttpRequest, textStatus, errorThrown) {
                            playAudio('gagal');
                            console.log(XMLHttpRequest);
                            console.log(textStatus);
                            console.log(errorThrown);
                            alert("Terdapat error pada aplikasi !!!");
                            scanstatus = false;
                        }

                    });
                }

                //$('.hasilscan').append($('<input name="noijazah" value=' + result.code + ' readonly><input type="submit" value="Cek"/>'));
                // $.post("../cek.php", { noijazah: result.code} );

                /* script awal nya 
                 var redirect = '../cek.php';
                 $.redirectPost(redirect, {noijazah: result.code});
                */
            }
        };



        // New FETCH

        const key_el = document.querySelector("#key_id");
        const key_length = 32;


        key_el.focus();
        key_el.addEventListener("keyup", async function() {
            const key_id = key_el.value;
            console.log(key_id.length);
            console.log(scanstatus);
            if (!scanstatus) {
                if (key_id.length <= key_length) {
                    if (key_id.length == key_length) {
                        console.log(key_id);
                        scanstatus = true;
                        try {
                            decoder.stop();
                            const result = await GetResult(key_id);
                            UpdateUI(result);
                        } catch (error) {
                            playAudio('gagal');
                            console.log(error);
                            alert("Terdapat error pada aplikasi !!!");
                        }
                        scanstatus = false;
                    }
                } else {
                    return;
                }
            }
        });

        function GetResult(key_id) {
            const formData = new FormData();
            formData.append('data_id', key_id);

            return fetch("Main/post_scan", {
                method: 'POST',
                // headers: {
                //     // 'Accept': 'application/json',
                //     // 'Content-Type': 'application/json'
                //     'Content-Type': 'application/x-www-form-urlencoded'
                // },
                body: formData
                // body: {
                //     data_id: key_id
                // }
            }).then((response) => {
                if (!response.ok) {
                    throw new Error(response.statusText);
                }
                return response.json();
                // console.log(response);
            }).then((response) => {
                // console.log(response);
                return response;
            })
        }

        function UpdateUI(data) {

            const timesuccess = 5000;
            const timefailed = 2000;
            var keterangan = "";
            var pesan = "";
            var tglskg = data.tglskg;
            if (!data.error) {
                $('#divnama').html(data.nama);
                $('#divcompany').html(data.companyid);
                $('#divdivisi').html(data.divid);
                $('#divdept').html(data.deptid);
                $('#divscore').html(data.score);
                $('#divrisiko').html(data.risiko);
                $('#divjam').html(data.jam);
                if (data.keterangan == "IN") {
                    keterangan = '<span class="label label-success">IN</span>';
                    pesan = '<center><label>.: SELAMAT DATANG DI ' + data.gedungname + ' :.</label></center>';
                } else {
                    keterangan = '<span class="label label-danger">OUT</span>';
                    pesan = '<center><label>.: HATI - HATI DALAM PERJALANAN :.</label></center>';
                }

                $('#divketerangan').html(keterangan);
                $('#divpesan').html(pesan);
                pathname = window.location.origin + "/" + rootfolder + "/assets/images/absen/" + tglskg + "/" + data.image_in;
                playAudio('berhasil');
                setTimeout(function() {
                    resetform();
                }, timesuccess);
            } else {
                pesan = '<span class="label label-danger">' + data.errormsg + '</span>';
                $('#divpesan').html(pesan);
                pathname = window.location.origin + "/" + rootfolder + "/assets/images/qrcode/noimage.png";
                playAudio('gagal');
                setTimeout(function() {
                    resetform();
                }, timefailed);
            }

            var src1 = pathname;
            $("#imgabsen").attr("src", src1);


        }
        //  END NEW FETCH

        function playAudio(status) {
            console.log(status);
            if (status == "berhasil") {
                var x = document.getElementById("myAudioTrue");
            } else {
                var x = document.getElementById("myAudioFalse");
            }
            x.play();
        }

        var decoder = $("canvas").WebCodeCamJQuery(arg).data().plugin_WebCodeCamJQuery;
        decoder.buildSelectMenu("select");
        // decoder.play();
        //Without visible select menu
        // decoder.buildSelectMenu(document.createElement('select'), 'environment|back').init(arg).play();


        function resetform() {
            // var rootfolder = "eca_dev_new";
            var pathname = window.location.origin + "/" + rootfolder + "/assets/images/qrcode/noimage.png";
            const pesan = '<div class="alert alert-danger alert-dismissible" role="alert"><marquee><p style="font-family: Impact; font-size: 14pt">.: WINNERS NEVER QUIT, QUITTERS NEVER WIN :.</p></marquee></label></div>'
            $('#divnama').html("");
            $('#divcompany').html("");
            $('#divdivisi').html("");
            $('#divdept').html("");
            $('#divscore').html("");
            $('#divrisiko').html("");
            $('#divjam').html("");
            $('#divketerangan').html("");
            $('#divpesan').html(pesan);
            $("#imgabsen").attr("src", pathname);
            const key_el = document.querySelector("#key_id");
            key_el.value = "";
            key_el.focus();
            checkkapasitas();
            decoder.play();
        }

        function checkkapasitas() {
            $.ajax({
                type: "POST",
                url: "Main/cek_kapasitas_gedung",
                dataType: "json",
                success: function(data) {
                    var keterangan = "";
                    var pesan = "";
                    $('#maksimal_kapasitas').html(data.total_kapasitas);
                    $('#total_masuk').html(data.total_masuk);
                    $('#sisa_kapasitas').html(data.sisa_kapasitas);
                    $("#persentase").attr("aria-valuenow", data.persentase);
                    $("#persentase").html(data.persentase + "%");
                    //$("#persentase").width(data.persentase+"%");
                },
                error: function(status) {
                    alert("Terdapat error pada aplikasi !!!");
                }

            });
        }
    </script>
</body>
<?php //$this->load->view('_partial/footer.php'); 
?>

</html>