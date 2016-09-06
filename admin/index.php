<?php

include("session.php");
if(cek_login()){
}else{
header("location: ../");
}
	if (isset($_SESSION['level']) AND isset($_SESSION['nama']) AND isset($_SESSION['login']))
	{
	}
else if (!isset($_SESSION['level']) AND !isset($_SESSION['nama']) AND !isset($_SESSION['login']))
{
	header('location:../index.php');
}
?>

<!DOCTYPE html>
<html>
<!-- head -->
<?php
include("head.php");
 ?>
<!--  -->
<body>
    <div id="wrapper">
    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav" id="side-menu">
                <li class="nav-header">
                    <div class="dropdown profile-element"> <span>
                            <!-- <img alt="image" class="img-circle" src="../img/2.jpg" /> -->
                             </span>
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold"><?php echo $_SESSION['nama'] ?></strong>
														</span> <span class="text-muted text-xs block"><?php if ($_SESSION['level']==1) { echo "Super Admin"; }else { echo "Admin"; } ?>
														<b class="caret"></b></span> </span> </a>
                        <ul class="dropdown-menu animated fadeInRight m-t-xs">
                            <li><a onclick="document.location='index?page=ganti_password'">Ganti Password</a></li>
                            <li class="divider"></li>
                            <li><a onclick="document.location='logout.php'">Logout</a></li>
                        </ul>
                    </div>
                    <div class="logo-element">
                        Menu
                    </div>
                </li>
                <li>
                    <a onclick="document.location='index?page=home'"><i class="fa fa-th-large"></i> <span class="nav-label">Home</span></a>
                </li>

								<?php if ($_SESSION['level'] == "2" OR $_SESSION['level'] == "1") {?>
                <li>
                    <a><i class="fa fa-database"></i> <span class="nav-label">Data</span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li><a onclick="document.location='index?page=ksm'">KSM</a></li>
                        <li><a onclick="document.location='index?page=calon_penerima'">Calon Penerima</a></li>
                        <li><a onclick="document.location='index?page=penilaian'">Penilaian Profile</a></li>
												<?php if ($_SESSION['level'] == "2") {?>
                        <li><a onclick="document.location='index?page=data_hasil_analisa_periode'">Hasil Analisa</a></li>
												<?php }else{} ?>
                        <li><a onclick="document.location='index?page=galery'">Galery</a></li>
                        <li><a onclick="document.location='index?page=lokasi'">Lokasi</a></li>
                    </ul>
                </li>
								<?php }else{} ?>

								<?php if ($_SESSION['level'] == "1") {?>
								<li>
                    <a onclick="document.location='index?page=analisis'"><i class="fa fa-dashboard"></i> <span class="nav-label">Analisa SPK</span></a>
                </li>
                <li>
                    <a><i class="fa fa-gears"></i> <span class="nav-label">Pengaturan SPK</span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li><a onclick="document.location='index?page=kriteria'">Kriteria</a></li>
                        <!-- <li><a onclick="document.location='index?page=sub_kriteria'">Sub Kriteria</a></li> -->
                        <li><a onclick="document.location='index?page=standar_profile'">Standar Profile</a></li>
                    </ul>
                </li>

                <li>
                    <a><i class="fa fa-tasks"></i> <span class="nav-label">Laporan</span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li><a onclick="document.location='index?page=lap_penerima'">Penerima</a></li>
		                    <li><a onclick="document.location='index?page=lap_ditolak'">Ditolak</a></li>
                        <li><a onclick="document.location='index?page=lap_ksm'">KSM</a></li>
                        <li><a onclick="document.location='index?page=lap_hasil_analisa'">Hasil Analisa</a></li>
                    </ul>
                </li>
								<?php }else{} ?>

								<li>
                    <a><i class="fa fa-bar-chart-o"></i> <span class="nav-label">Statistik</span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li><a onclick="document.location='index?page=chart_seleksi'">Hasil Seleksi</a></li>
                        <li><a onclick="document.location='index?page=chart_dana'">Dana Tahunan</a></li>
                        <!-- <li><a onclick="document.location='index?page=chart_ksm'">Dana Pnpm dan Swadaya</a></li> -->
                        <!-- <li><a onclick="document.location='index?page=chart_dana_ksm'">Dana KSM</a></li> -->
                        <li><a onclick="document.location='index?page=chart_ksm_pnpm'">Dana Pnpm</a></li>
                        <li><a onclick="document.location='index?page=chart_ksm_swadaya'">Dana Swadaya</a></li>
                    </ul>
                </li>

								<li>
                    <a><i class="fa fa-user"></i> <span class="nav-label">User</span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
											<?php if ($_SESSION['level'] == "1") {?>
                        <li><a onclick="document.location='index?page=user'">Manajemen User</span></a></li>
												<?php } else{}?>
                        <li><a onclick="document.location='index?page=ganti_password'">Ganti Password</span></a></li>
                    </ul>
                </li>
            </ul>

        </div>
    </nav>

    <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
        <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
            <form role="search" class="navbar-form-custom" method="post" action="search_results.html">
                <div class="form-group">
                    <!-- <input type="text" placeholder="Search for something..." class="form-control" name="top-search" id="top-search"> -->
                </div>
            </form>
        </div>
            <ul class="nav navbar-top-links navbar-right">
                
                <li>
                    <a href="logout.php">
                        <i class="fa fa-sign-out"></i> Log out
                    </a>
                </li>
            </ul>
        </nav>
        </div>

				<!--batas-->
            <?php
              if (@$_GET['page'] != "")
              {
								if( !file_exists($filename = $_GET['page'].".php")) {
								include("404.php");
								}else{
	                include(@$_GET['page'].".php");
								}
              } else {
                include("home.php");
              }
            ?>

						<div class="wrapper wrapper-content animated fadeInRight">
						</div>
        <div class="footer">
            <div class="pull-right">
							<strong>Copyright</strong> Lustria Ebis &copy; 2016
            </div>
            <div>

            </div>
        </div>

        </div>
        </div>

<!--  -->
<?php
include("foo.php")
?>
<!--  -->
    <script>
        $(document).ready(function() {
            $('.dataTables-example').dataTable({
                responsive: true,
                "dom": 'T<"clear">lfrtip',
                "tableTools": {
                    "sSwfPath": "../js/plugins/dataTables/swf/copy_csv_xls_pdf.swf"
                }
            });

            /* Init DataTables */
            var oTable = $('#editable').dataTable();

            /* Apply the jEditable handlers to the table */
            oTable.$('td').editable( '../example_ajax.php', {
                "callback": function( sValue, y ) {
                    var aPos = oTable.fnGetPosition( this );
                    oTable.fnUpdate( sValue, aPos[0], aPos[1] );
                },
                "submitdata": function ( value, settings ) {
                    return {
                        "row_id": this.parentNode.getAttribute('id'),
                        "column": oTable.fnGetPosition( this )[2]
                    };
                },

                "width": "90%",
                "height": "100%"
            } );


        });

        function fnClickAddRow() {
            $('#editable').dataTable().fnAddData( [
                "Custom row",
                "New row",
                "New row",
                "New row",
                "New row" ] );

        }
    </script>

    <script>
        $(document).ready(function(){
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });
        });

				$(document).ready(function(){
						$("#wizard").steps();
						$("#form").steps({
								bodyTag: "fieldset",
								onStepChanging: function (event, currentIndex, newIndex)
								{
										// Always allow going backward even if the current step contains invalid fields!
										if (currentIndex > newIndex)
										{
												return true;
										}

										// Forbid suppressing "Warning" step if the user is to young
										if (newIndex === 3 && Number($("#age").val()) < 18)
										{
												return false;
										}

										var form = $(this);

										// Clean up if user went backward before
										if (currentIndex < newIndex)
										{
												// To remove error styles
												$(".body:eq(" + newIndex + ") label.error", form).remove();
												$(".body:eq(" + newIndex + ") .error", form).removeClass("error");
										}

										// Disable validation on fields that are disabled or hidden.
										form.validate().settings.ignore = ":disabled,:hidden";

										// Start validation; Prevent going forward if false
										return form.valid();
								},
								onStepChanged: function (event, currentIndex, priorIndex)
								{
										// Suppress (skip) "Warning" step if the user is old enough.
										if (currentIndex === 2 && Number($("#age").val()) >= 18)
										{
												$(this).steps("next");
										}

										// Suppress (skip) "Warning" step if the user is old enough and wants to the previous step.
										if (currentIndex === 2 && priorIndex === 3)
										{
												$(this).steps("previous");
										}
								},
								onFinishing: function (event, currentIndex)
								{
										var form = $(this);

										// Disable validation on fields that are disabled.
										// At this point it's recommended to do an overall check (mean ignoring only disabled fields)
										form.validate().settings.ignore = ":disabled";

										// Start validation; Prevent form submission if false
										return form.valid();
								},
								onFinished: function (event, currentIndex)
								{
										var form = $(this);

										// Submit form input
										form.submit();
								}
						}).validate({
												errorPlacement: function (error, element)
												{
														element.before(error);
												},
												rules: {
														confirm: {
																equalTo: "#password"
														}
												}
										});
			 });
    </script>

		<script>
        $(document).ready(function(){

            Dropzone.options.myAwesomeDropzone = {

                autoProcessQueue: false,
                uploadMultiple: true,
                parallelUploads: 100,
                maxFiles: 100,

                // Dropzone settings
                init: function() {
                    var myDropzone = this;

                    this.element.querySelector("button[type=submit]").addEventListener("click", function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        myDropzone.processQueue();
                    });
                    this.on("sendingmultiple", function() {
                    });
                    this.on("successmultiple", function(files, response) {
                    });
                    this.on("errormultiple", function(files, response) {
                    });
                }

            }

       });
    </script>

		<script>
	$(document).ready(function(){

			var $image = $(".image-crop > img")
			$($image).cropper({
					aspectRatio: 1.618,
					preview: ".img-preview",
					done: function(data) {
							// Output the result data for cropping image.
					}
			});

			var $inputImage = $("#inputImage");
			if (window.FileReader) {
					$inputImage.change(function() {
							var fileReader = new FileReader(),
											files = this.files,
											file;

							if (!files.length) {
									return;
							}

							file = files[0];

							if (/^image\/\w+$/.test(file.type)) {
									fileReader.readAsDataURL(file);
									fileReader.onload = function () {
											$inputImage.val("");
											$image.cropper("reset", true).cropper("replace", this.result);
									};
							} else {
									showMessage("Please choose an image file.");
							}
					});
			} else {
					$inputImage.addClass("hide");
			}


			$('#data_1 .input-group.date').datepicker({
					todayBtn: "linked",
					keyboardNavigation: false,
					forceParse: false,
					calendarWeeks: true,
					autoclose: true
			});

			$('#data_2 .input-group.date').datepicker({
					startView: 1,
					todayBtn: "linked",
					keyboardNavigation: false,
					forceParse: false,
					autoclose: true
			});

			$('#data_3 .input-group.date').datepicker({
					startView: 2,
					todayBtn: "linked",
					keyboardNavigation: false,
					forceParse: false,
					autoclose: true
			});

			$('#data_4 .input-group.date').datepicker({
					minViewMode: 1,
					keyboardNavigation: false,
					forceParse: false,
					autoclose: true,
					todayHighlight: true
			});

			$('#data_5 .input-daterange').datepicker({
					keyboardNavigation: false,
					forceParse: false,
					autoclose: true
			});

			var elem = document.querySelector('.js-switch');
			var switchery = new Switchery(elem, { color: '#1AB394' });

			var elem_2 = document.querySelector('.js-switch_2');
			var switchery_2 = new Switchery(elem_2, { color: '#ED5565' });

			var elem_3 = document.querySelector('.js-switch_3');
			var switchery_3 = new Switchery(elem_3, { color: '#1AB394' });

			$('.i-checks').iCheck({
					checkboxClass: 'icheckbox_square-green',
					radioClass: 'iradio_square-green',
			});

			$('.demo1').colorpicker();

			var divStyle = $('.back-change')[0].style;
			$('#demo_apidemo').colorpicker({
					color: divStyle.backgroundColor
			}).on('changeColor', function(ev) {
									divStyle.backgroundColor = ev.color.toHex();
							});


	});
	var config = {
					'.chosen-select'           : {},
					'.chosen-select-deselect'  : {allow_single_deselect:true},
					'.chosen-select-no-single' : {disable_search_threshold:10},
					'.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
					'.chosen-select-width'     : {width:"95%"}
			}
			for (var selector in config) {
					$(selector).chosen(config[selector]);
			}

	$("#ionrange_1").ionRangeSlider({
			min: 0,
			max: 5000,
			type: 'double',
			prefix: "$",
			maxPostfix: "+",
			prettify: false,
			hasGrid: true
	});

	$("#ionrange_2").ionRangeSlider({
			min: 0,
			max: 10,
			type: 'single',
			step: 0.1,
			postfix: " carats",
			prettify: false,
			hasGrid: true
	});

	$("#ionrange_3").ionRangeSlider({
			min: -50,
			max: 50,
			from: 0,
			postfix: "°",
			prettify: false,
			hasGrid: true
	});

	$("#ionrange_4").ionRangeSlider({
			values: [
					"January", "February", "March",
					"April", "May", "June",
					"July", "August", "September",
					"October", "November", "December"
			],
			type: 'single',
			hasGrid: true
	});

	$("#ionrange_5").ionRangeSlider({
			min: 10000,
			max: 100000,
			step: 100,
			postfix: " km",
			from: 55000,
			hideMinMax: true,
			hideFromTo: false
	});



</script>

<style>
    body.DTTT_Print {
        background: #fff;

    }
    .DTTT_Print #page-wrapper {
        margin: 0;
        background:#fff;
    }

    button.DTTT_button, div.DTTT_button, a.DTTT_button {
        border: 1px solid #e7eaec;
        background: #fff;
        color: #676a6c;
        box-shadow: none;
        padding: 6px 8px;
    }
    button.DTTT_button:hover, div.DTTT_button:hover, a.DTTT_button:hover {
        border: 1px solid #d2d2d2;
        background: #fff;
        color: #676a6c;
        box-shadow: none;
        padding: 6px 8px;
    }

    .dataTables_filter label {
        margin-right: 5px;

    }
</style>
</body>

</html>
