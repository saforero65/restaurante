<?php
session_start();

if (!isset($_SESSION['username'])) {
	$_SESSION['msg'] = "You must log in first";
	header('location: login.php');
}
if (isset($_GET['logout'])) {
	session_destroy();
	unset($_SESSION['username']);
	header("location: login.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>CodePen - Contact Us Page Design - Contact Form Design</title>
	<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css'>
	<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css'>
	<link rel="stylesheet" href="style3.css">

</head>

<body>
	<!-- partial:index.partial.html -->
	<section class="contact_us">
		<div class="container">

			<div class="todo ">
				<div class="contact_inner">
					<div class="row">
						<div class="col-md-10">
							<div class="contact_form_inner">
								<?php
								$estudiante = "";
								$grado = "";
								$grupo = "";
								?>
								<form id="form" class="contact_field" method="POST">
									<h3>Ingreso de ESTUDIANTES</h3>
									<p>Porfavor escanee su tarjeta en el lector
									</p>
									<div class="row">
										<input type="text" name="codigo" id="codigo" value="" class="form-control form-group" placeholder="Codigo" />
										<input type="text" class="form-control form-group" placeholder="Nombre Estudiante" id="estudiante" value="<?php echo $estudiante; ?>" />
									</div>
									<div class="row">
										<input type="text" id="grupo" class="form-control form-group col-md-5" placeholder="Curso" value="<?php echo $grupo; ?>" />
										<input type="text" class="form-control form-group col-md-5" placeholder="Grado" id="grado" value="<?php echo $grado; ?>" />
									</div>
									<!-- <textarea class="form-control form-group" placeholder=" "></textarea> -->
									<input type="submit" style="visibility: hidden;" name="btn" />
								</form>
								<script>
									// document.getElementById("form").addEventListener("submit", (e) => {
									//     // e.preventDefault();
									// })
								</script>
							</div>
						</div>

						<div class="col-md-2">
							<div class="right_conatct_social_icon d-flex align-items-end">

							</div>
						</div>
					</div>
					<div class="contact_info_sec">
						<!-- <h4>Estudiante</h4> -->

						<img class="img_student" id="img1" src="img/blanco.jpeg" alt="imagen_estudiante">



					</div>
				</div>
			</div>

		</div>
	</section>
	<?php
	if (isset($_POST["btn"])) {
		include "con.php";

		$codigo = $_POST["codigo"];
		$sql = "SELECT * FROM `estudiantes`WHERE codigo=$codigo";

		// echo $sql;
		$result = mysqli_query($con, $sql);
		if ($result = mysqli_query($con, $sql)) {
			while ($row = mysqli_fetch_array($result)) {
				$estudiante = $row["estudiante"];
				$grado = $row["grado"];
				$grupo = $row["grupo"];
				$img = $row["foto"];

	?>
				<script>
					// console.log(document.getElementById("estudiante"));
					document.getElementById("estudiante").value = " <?php echo $estudiante; ?>";
					document.getElementById("grado").value = " <?php echo $grado; ?>";
					document.getElementById("grupo").value = " <?php echo $grupo; ?>";
					document.getElementById("img1").src = "img/<?php echo $img; ?>";
				</script>
			<?
			}

			$sql3 = "SELECT * FROM registros WHERE DATE_FORMAT(fecha, '%Y-%m-%d') = CURDATE() AND estudiante= '$estudiante'";
			$result3 = mysqli_query($con, $sql3);
			// echo $sql3;
			// echo $result3;
			if ($row = mysqli_fetch_array($result3)) {
				// echo $row["estudiante"];
				// echo "ya se metio al restaurante hoy";
			?>
				<div class="background" id="background"></div>
				<div id="modal" class="modal" style=" display: block " tabindex="-1">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title"> <b>¡ADVERTENCIA!</b></h5>

							</div>
							<div class="modal-body">
								<p>El estudiante <b> <?php echo $estudiante; ?> </b> ya ingreso el dia de hoy</p>
							</div>

						</div>
					</div>
				</div>
				<script>
					setTimeout(() => {
						document.getElementById("modal").style.display = "none"
						document.getElementById("background").style.display = "none"
					}, 3000);
				</script>
	<?php



			} else {

				// echo "no se ha metido al restaurante hoy";
				$sql2 = "INSERT INTO registros ( estudiante, fecha,hora )
            VALUES ( '$estudiante',NOW(), NOW() )";
				$result2 = mysqli_query($con, $sql2);
			}
		}
	}

	?>

	<!-- partial -->
	<script src="app.js"></script>
</body>

</html>