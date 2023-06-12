<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
	function curl_get_file_contents($URL)
	{
		$c = curl_init();
		curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($c, CURLOPT_URL, $URL);
		$contents = curl_exec($c);
		curl_close($c);

		if ($contents) return $contents;
		else return FALSE;
	}

	$allAsk = 	curl_get_file_contents("https://" . $_SERVER['SERVER_NAME'].'/backend/validate.php?allAsk');

	if ($allAsk === null) {
		$allAsk = json_encode([]);
		return;
	}

	$askCount = round(json_decode($allAsk)->data->total/4);
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Consulado | Agencia de viajes | solicita tu Visado aquí</title>
	<!-- Mobile Specific Metas -->
	<link rel="icon" type="image/x-icon" href="images/logo.ico">

	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<!-- Font-->
	<link rel="stylesheet" type="text/css" href="css/muli-font.css">
	<link rel="stylesheet" type="text/css" href="fonts/material-design-iconic-font/css/material-design-iconic-font.min.css">
	<!-- datepicker -->
	<link rel="stylesheet" type="text/css" href="css/jquery-ui.min.css">
	<!-- Main Style Css -->
	<link rel="stylesheet" type="text/css" href="css/fontawesome/css/all.css">
    <link rel="stylesheet" href="css/style.css"/>

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" >
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" ></script>
</head>
<body>
	<div class="page-content" style="background: #0075DF;">
		<div>
			<div style="position: absolute;left: 10px;top:10px">
				<button href="#historial" class="btn-solid" data-bs-toggle="modal" data-bs-target="#historialModal">Ver Historial</button>
			</div>

			<div style="position: absolute;right: 20px;top:10px">
				<button href="#solicitar" class="btn-solid" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Solicitar Autorización</button>
			</div>
		</div>
		<!-- <div style="position: absolute;left:5px;bottom: -5px">
			<img src="images/form-wizard.png" alt="form-wizard" />
		</div> -->
		<div class="wizard-v2-content">
			<div class="wizard-image">
			</div>
			
			<!-- background-image: url('images/form-wizard.png') -->
			<div class="wizard-form">
				<div class="wizard-header">
					<h3>Formulario de admisiones</h3>
					<p>Adquiere tu visa. El primer paso está aquí.</p>
				</div>

		        <form class="form-register form-main" action="#" method="post">
		        	<div id="form-total">
		        		<!-- SECTION 1 -->
			            <h2>1</h2>
			            <section>
			                <div class="inner">
								<div class="form-row">
									<div class="form-holder">
										<label for="id">Codigo de autorización</label>
										<input type="text" placeholder="Codigo de autorización" class="form-control" name="natrip_id">
									</div>
									<div class="form-holder">
										<label for="cedula">Cédula</label>
										<input type="text" placeholder="Cédula" class="form-control" name="cedula_">
									</div>
								</div>
								<div class="form-row">
									
								</div>
							</div>
			            </section>
						<!-- SECTION 2 -->
			            <h2>2</h2>
						<section>
			                <div class="inner">
								<b style="position: absolute;">Tu información</b>
								<div class="form-row table-responsive">
									<table class="table">
										<tbody>
											<tr class="space-row">
												<th>Nombre Completo:</th>
												<td id="fullname-val"></td>
											</tr>
											<tr class="space-row">
												<th>Phone:</th>
												<td id="phone-val"></td>
											</tr>
											<tr class="space-row">
												<th>Email:</th>
												<td id="email-val"></td>
											</tr>
											<tr class="space-row">
												<th>Status de solicitud:</th>
												<td id="status-val"></td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
			            </section>

						<h2>3</h2>
			            <section>
			                <div class="inner questions">
								
							</div>
			            </section>
			            <!-- SECTION 3 -->
		        	</div>
		        </form>
				<div class="form-error"></div>
				<div style="position: absolute;right: 10px;bottom: 63px;width: 175px" class="autorizar-2">
						<button href="#solicitar" class="btn-solid" data-bs-toggle="modal" data-bs-target="#staticBackdrop" style="color: #000 !important">Solicitar Autorización</button>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="historialModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="historialModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-xl">
				<div class="modal-content">
				<div class="modal-header">
					<h1 class="modal-title fs-5" id="historialModalLabel">Access</h1>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<form action="" class="form-history" onsubmit="return false;">
						<div class="userform">
							<div class="input-group mb-3">
								<span class="input-group-text" id="basic-addon1">Usuario *</span>
								<input type="text" class="form-control" placeholder="Usuario" aria-label="Usuario" aria-describedby="basic-addon1" name="user">
							</div>
							<div class="input-group mb-3">
								<span class="input-group-text" id="basic-addon1">Contraseña *</span>
								<input type="password" class="form-control" placeholder="Contraseña" aria-label="Contraseña" aria-describedby="basic-addon1" name="password">
							</div>
						</div>
						
						<div class="list-history">
							<table id="myTable" class="display">
								<thead>
									<tr>
										<th>Natrip_id</th>
										<th>Tipo Visa</th>
										<th>Nombres</th>
										<th>Apellidos</th>
										<th>Cedula</th>
										<th>Teléfono</th>
										<th>Estatus</th>
										<th>Creacion</th>
										<th>Acciones</th>
									</tr>
									<tbody></tbody>
								</thead>
							</table>
						</div>

						<center class="error-form-modal"></center>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary close" data-bs-dismiss="modal">Cerrar</button>
					<button type="button" class="btn btn-primary" onclick="accesss()">Acceder</button>
				</div>
				</div>
			</div>

	</div>

	<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
				<div class="modal-header">
					<h1 class="modal-title fs-5" id="staticBackdropLabel">Solicitar Nuevo ingreso</h1>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<b class="modal-title" style="opacity: 0.7;font-size: 12px" id="staticBackdropLabel">Solicitando tu acceso a tu visa americana</bcsqrt>
					<form action="" class="form-register form-register2">
						<div class="input-group mb-3">
						<span class="input-group-text" id="basic-addon1">Tipo Visa *</span>
							<select name="visa_type" class="form-select form-select-lg">
								<option value="b1/b2">Visa Americana B1/B2</option>
								<option value="canada">Visa Canada</option>
								<option value="Schenger">Visa Europea Schenger</option>
							</select>
						</div>
						<div class="input-group mb-3">
							<span class="input-group-text" id="basic-addon1">Nombres *</span>
							<input type="text" class="form-control" placeholder="Nombres" aria-label="Nombres" aria-describedby="basic-addon1" name="name">
						</div>
						<div class="input-group mb-3">
							<span class="input-group-text" id="basic-addon1">Apellidos *</span>
							<input type="text" class="form-control" placeholder="Apellidos" aria-label="Apellidos" aria-describedby="basic-addon1" name="last_name">
						</div>
						<div class="input-group mb-3">
							<span class="input-group-text" id="basic-addon1">Cedula *</span>
							<input type="text" class="form-control" placeholder="Cedula" aria-label="Cedula" aria-describedby="basic-addon1" name="cedula">
						</div>
						<div class="input-group mb-3">
							<span class="input-group-text" id="basic-addon1">Email *</span>
							<input type="text" class="form-control" placeholder="Email" aria-label="Email" aria-describedby="basic-addon1" name="email">
						</div>
						<div class="input-group mb-3">
							<span class="input-group-text" id="basic-addon1">Teléfono *</span>
							<input type="text" class="form-control" placeholder="Teléfono" aria-label="Teléfono" aria-describedby="basic-addon1" name="phone">
						</div>
						<!-- <div class="input-group mb-3">
							<span class="input-group-text" id="basic-addon1">Celular</span>
							<input type="text" class="form-control" placeholder="Celular (Opcional)" aria-label="Celular" aria-describedby="basic-addon1" name="cellphone">
						</div> -->

						<center><b>Para más información llamar al (809)-475-8831 o enviar un email a Info@agenciadeviajes.do</b></center>
						<center class="error-form-modal"></center>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-warning" onclick="clearData()">Limpiar</button>
					<button type="button" class="btn btn-secondary close" data-bs-dismiss="modal">Cerrar</button>
					<button type="button" class="btn btn-primary" onclick="solicitar()">Solicitar</button>
				</div>
				</div>
			</div>
	</div>

	<script src="//cdnjs.cloudflare.com/ajax/libs/validate.js/0.13.1/validate.min.js"></script>
	<script src="js/jquery-3.3.1.min.js"></script>
	<script src="js/jquery.steps.js"></script>
	<script src="js/jquery-ui.min.js"></script>
	<script src="js/main.js"></script>

	<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />
  
	<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>

	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.all.min.js"></script>
	<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.min.css" rel="stylesheet">

	<script>
		$('document').ready(function() {
			let knowhere = false;
			let title = '';

			const ask = `<?php echo $allAsk;?> `;
			
			addSections(JSON.parse(ask).data)
		});

		const clearData=()=> {
			$('.form-register input').val('');
			$(`.error-form-modal`).html('');
		}

		const accesss=()=> {
			let data = $('.form-history').serializeArray();
			$.post('backend/validate.php?access', data, function(data) {
				data = JSON.parse(data);
				if (data.data.length > 0) {
					$('.userform').hide();
					for (item of data.data) {
						$('.list-history tbody').append(`
							<tr>
								<td>${item.natrip_id !== null ? 'natrip'+item.natrip_id : ''}</td>
								<td>${item.visa_type}</td>
								<td>${item.name}</td>
								<td>${item.last_name}</td>
								<td>${item.cedula}</td>
								<td>${item.phone}</td>
								<td>${item.status !== null ? item.status : 'pending'}</td>
								<td>${item.created_at}</td>
								<td>
									${item.natrip_id === null ? `<button onclick='approve(${item.consultation_id}, "${item.email}")' class="btn btn-info">Aprobar</button>` : 'Aprobado'}
								</td>
							</tr>
						`);
					}
					
					$('.list-history').show();
					$('#myTable').DataTable();
				} else {
					alert('No hay data en el historial, trata en otro momento');
				}
			});
		}

		const approve=(napID, email)=> {
			let data = $('.form-history').serializeArray();
			data.push({name: 'consultation_id', 'value': napID});
			data.push({name: 'email', 'value': email});

			$.post('backend/validate.php?crearNap', data, function(data) {
				data = JSON.parse(data);
				if (data.data == 1) {
					$('.list-history tbody').html(null);

					setTimeout(() => {
						accesss();
					}, 2000);
				}

				if (data.data == 0) {
					alert('Error al aprobar');
				}
			});
		}

		const solicitar=()=> {
			let data = $('.form-register2').serializeArray();

			var constraints = {
				name: {
					presence: true,
					length: {
						minimum: 3,
						message: "must be at least 3 characters"
					}
				},
				last_name: {
					presence: true,
					length: {
						minimum: 3,
						message: "must be at least 3 characters"
					}
				},
				cedula: {
					presence: true,
					format: {
						pattern: /^[0-9]*$/,
					},
					length: {
						minimum: 10,
						message: "must be at least 10 characters and no special characters"
					}
				},
				email: {
					presence: true,
					format: {
						pattern: /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/,
					},
					length: {
						minimum: 10,
						message: "must be at least 10 characters and no special characters"
					}
				},
				phone: {
					presence: true,
					format: {
						pattern: /^(\+)?(\d{1,2})?[( .-]*(\d{3})[) .-]*(\d{3,4})[ .-]?(\d{4})$/,
					},
					length: {
						minimum: 9,
						message: "must be at least 9 characters, format 809-xxx-xxxx"
					}
				},
				// cellphone: {
				// 	presence: false,
				// 	format: {
				// 		pattern: /^(\+)?(\d{1,2})?[( .-]*(\d{3})[) .-]*(\d{3,4})[ .-]?(\d{4})$/,
				// 	},
				// 	length: {
				// 		minimum: 9,
				// 		message: "must be at least 9 characters, format 809-xxx-xxxx"
				// 	}
				// },
			};

			$('.error-form-modal').html(null);
			let formData = [];
			for (item of data) {
				if (constraints.hasOwnProperty(item.name)) {
					formData[item.name] = item.value;
				}
			}

			formData = validate(formData, constraints);

			if (formData !== undefined) {
				for (item in formData) {
					$('.error-form-modal').append('<i class="far fa-engine-warning"></i> <b>'+formData[item][0]+'</b><br>').css({'display': 'block'});
					break;
				}
			} else {
				$.post('backend/validate.php?store_new', data, function(res) {
					res = JSON.parse(res);

					if (res.data.hasOwnProperty('error')) {
						$(`.error-form-modal`).html('').append(`<h2>${res.data.error}</h2><section><div class="inner questions"></div></section>`);
					}

					if (res.data.hasOwnProperty('done')) {
						Swal.fire({
							title: 'Guardado',
							text: 'Un representante verificará tu solicitud y te enviara los datos necesarios vía Email Info@agenciadeviajes.do. Para más información contactenos al 809-475-8831.',
							icon: 'success',
							confirmButtonText: 'Completar y cerrar',
						});

						setTimeout(() => {
							$(".close").click();
						}, 2000);
					}
				});
			}
		}

		const addSections=(data)=> {
			let n = 0;
			let section = 3;
			let section_ask = 0;
			const limit = 4;

			const last_input = data.total;
			for (item in data) {
				if (n <= limit && data[item].pregunta_id <= last_input) {
					let content = `<input type="text" placeholder="Campo obligatorio" class="form-control" name="ask-${data[item].pregunta_id}">`;

					if (data[item].type == 'radio') {
						content = `
						<div class="form-holder form-holder-2">
							<label class="ml-2"><b>Selecciona Sí o No<b><span>*</span></label>
							<select name="ask-${data[item].pregunta_id}" class="form-control">
								<option value="null">Seleccionar</option>
								<option value="1">Sí</option>
								<option value="0">No</option>
							</select>
						</div>
						`;
					}
					
					$(`.questions`).eq(section_ask).append(`
					    <div>
					        <label>${Number(item)+1})<b> ${data[item].ask}<b><span>*</span></label>
					        ${content}
					    </div>
					`);
				}
				
				if (n == limit && data[item].pregunta_id < last_input) {
					let semicolum = '';
					if (data[item].pregunta_id >= last_input-5) {
						semicolum = '..';
					}

					$(`#form-total`).append(`<h2>${semicolum}${section+1}</h2><section><div class="inner questions"></div></section>`);

					n=0;
					section++;
					section_ask++;
				}

				n++;
			}
		}
	</script>
	<style>
		.steps li:nth-of-type(1n+<?php echo $askCount+2;?>) {
			opacity: 1;
			position: relative;
		}
	</style>
</body>
</html>