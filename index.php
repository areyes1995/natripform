<?php
	$allAsk = 	file_get_contents('http://localhost/form/backend/validate.php?allAsk');
	
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
	<title>Wizard-v2</title>
	<!-- Mobile Specific Metas -->
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
			<a href="#solicitar" class="btn-solid">Solicitar Autorización</a>
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

		        <form class="form-register" action="#" method="post">
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
										<input type="text" placeholder="Cédula" class="form-control" name="cedula">
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
			</div>
		</div>
	</div>
	<script src="//cdnjs.cloudflare.com/ajax/libs/validate.js/0.13.1/validate.min.js"></script>
	<script src="js/jquery-3.3.1.min.js"></script>
	<script src="js/jquery.steps.js"></script>
	<script src="js/jquery-ui.min.js"></script>
	<script src="js/main.js"></script>

	<script>
		$('document').ready(function() {
			let knowhere = false;
			let title = '';
			$('.btn-solid').click(function() {
				if (knowhere) {
					title = 'Formulario de admisiones';
					knowhere = false;
				} else {
					title = 'Solicitar Autorización - Natrips';
					knowhere = true;
				}
				
				$('.wizard-header h3').text(title);	
			});

			const ask = `<?php echo $allAsk;?> `;
			
			addSections(JSON.parse(ask).data)
		});

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
								<option value="default">Seleccionar</option>
								<option value="Sí">Sí</option>
								<option value="No">No</option>
							</select>
						</div>
						`;
					}
					
					$(`.questions`).eq(section_ask).append(`
					    <div>
					        <label><b>${data[item].ask}<b><span>*</span></label>
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