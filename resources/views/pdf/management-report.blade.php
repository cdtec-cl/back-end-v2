<html>
	<head>
		<title>Reporte</title>

		<style>
			/*@import url("https://fonts.googleapis.com/css2?family=Archivo+Narrow:wght@500&family=Ubuntu&display=swap");*/

			table {
			  width: 100%;
			  max-width: 100%;
			  border-collapse: collapse;
			  font-size: 10px;
			}
			h1 {
    			font-size: 10px;
				color: #1f4278;
				font-family: Arial, Helvetica, sans-serif;
			  	/*font-family: "Ubuntu", sans-serif;*/
			}
			.section-title-1{
				border-bottom: 2px solid #164170;
			}
			.section-title-2{
    			font-size: 15px;
				color: #77b1cd;
			  	font-family: "Ubuntu", sans-serif;
				border-bottom: 2px solid #164170;
			}
			.info-table tbody tr th{
			  	font-family: "Ubuntu", sans-serif;
				font-weight: bold;
				text-align: left;
			}
			.info-table tbody tr td{
				text-align: right;
				color: #52869e;
			}
			.table-bg-blue{
			  border-collapse: separate;
				border-spacing: 2px;
			}
			.table-bg-blue thead tr td,
			.table-bg-blue thead tr th,
			.table-bg-blue tbody tr td,
			.table-bg-blue tbody tr th{
				background-color: #bfd8f2;
			}
			h2 {
			  font-size: 1.3rem;
			}
			h3 {
			  font-size: 1.1rem;
			}
			h4 {
			  font-size: 1.2rem;
			  font-family: "Ubuntu", sans-serif;
			}
			h5 {
			  font-size: 1rem;
			}
			h6 {
			  font-size: 0.8rem;
			}
			body {
			  font-size: 1.2rem;
			}

			.table-style caption {
			  font-weight: 400;
			  text-transform: uppercase;
			  font-family: "Ubuntu", sans-serif;
			  line-height: 1;
			  margin-bottom: 0.75em;
			}
			.table-style th {
			  font-weight: 400;
			  text-transform: capitalize;
			  font-family: "Ubuntu", sans-serif;
			  padding: 5px;
			  line-height: 1.333;
			  background-color: #1f4278;
			  color: #ffffff;
			}

			.table-style td,
			.table-style th {
			  text-align: left;
			}
			.table-style td {
			  padding: 5px;
			  font-family: "Archivo Narrow", sans-serif;
			}
			.table-style tbody tr:nth-of-type(even) {
			  background-color: #cccccc;
			}
			.table-style tbody tr:nth-of-type(odd) {
			  background-color: #e6e6e6;
			}
			.table-style tbody th {
			  border-top: 1px solid #d5d5d2;
			}
			.table-style tbody td {
			  border-top: 1px solid #d5d5d2;
			}
			.table-style.wdn_responsive_table thead th abbr {
			  border-bottom: none;
			}
			/*other styles*/
			.d-flex{
				display: flex;

			}
			.w-50{
				width: 50%;	
			}
			.w-25{
				width: 25%;
			}
			.img-logo{
				width: 100%;
				height:50px;
			}
			.main-title{
			    font-size: 20px;
			    text-align: center;
			}
			.p-05{
				padding: 5%;
			}

			table {
	            font-size: 10px;
	            border-collapse: collapse;
	            margin: 30px 0px;
	        }

	        td, th {
	            /*border: 1px solid;*/
	            padding: 0 10px;
	            /*text-align: center;*/
	        }

	        /* style one */
	        .table-style.makeit_rwd_default {
	            margin: 0 auto;
	            border-collapse: collapse;
	            font-family: Agenda-Light, sans-serif;
	            font-weight: 100;
	            background: #333;
	            color: #fff;
	            text-rendering: optimizeLegibility;
	            border-radius: 5px;
	        }

	        .table-style.makeit_rwd_default caption {
	            font-size: 2rem;
	            color: #444;
	            margin: 1rem;
	        }

	        .table-style.makeit_rwd_default thead th {
	            font-weight: 600;
	        }

	        .table-style.makeit_rwd_default thead th, table.makeit_rwd_default tbody td {
	            padding: 5px;
	            font-size: 1.4rem;
	        }

	        .table-style.makeit_rwd_default tbody td {
	            padding: 5px;
	            font-size: 1.4rem;
	            color: #444;
	            background: #eee;
	        }

	        .table-style.makeit_rwd_default tbody tr:not(:last-child) {
	            border-top: 1px solid #ddd;
	            border-bottom: 1px solid #ddd;
	        }

	        /* STYLE 2 */
	        .table-style.makeit_rwd_default2 {
	            margin: 0 auto;
	            border-collapse: collapse;
	            font-family: Agenda-Light, sans-serif;
	            font-weight: 100;
	            background: #333;
	            color: #fff;
	            text-rendering: optimizeLegibility;
	            border-radius: 5px;
	        }

	        .table-style.makeit_rwd_default2 caption {
	            font-size: 2rem;
	            color: #444;
	            margin: 1rem;
	        }

	        .table-style.makeit_rwd_default2 thead th {
	            font-weight: 600;
	        }

	        .table-style.makeit_rwd_default2 thead th, table.makeit_rwd_default2 tbody td {
	            padding: 5px;
	            font-size: 1.4rem;
	        }

	        .table-style.makeit_rwd_default2 tbody td {
	            padding: 5px;
	            font-size: 1.4rem;
	            color: #444;
	            background: #eee;
	        }

	        .table-style.makeit_rwd_default2 tbody tr:not(:last-child) {
	            border-top: 1px solid #ddd;
	            border-bottom: 1px solid #ddd;
	        }
	        .d-flex{
	        	display: flex;
	        }
	        .w-50{
	        	width: 50%;
	        }
	        .w-100{
	        	width: 100%;
	        }
	        .d-flex{
	        	display: flex;
	        }
	        .paragraph-container{
	        	background-color: #3ab3eb;
				padding: 20px;
	        }
	        .danger-text{
	        	color:red;
	        	font-size:40px;
	        }
	        p{
	        	font-size:10px;
	        }
		</style>
	</head>
	<body>
		<div class="">
			<table class="table-style wdn_responsive_table flush-left" id="t182720">
	   			<tbody>  
	   				<tr>
			            <th scope="row" data-header=" " style="font-weight:bold;">Informe de gestión de riego/productividad</th>
						<td data-header="Deposit" style="
							background-color:blue;
							color:#fff;
							font-weight:bold;
							text-align: center;">
							Certificado por CDTEC
						</td>
					</tr>  
					<tr>
						<th scope="row" data-header=" " style="
						background-color:#d5d5d2;
						color: #52869e;
						padding:2px;">
							Fecha
						</th>
						<td data-header="Deposit" style="
						background-color:#fff;
						text-align: center;
						padding:2px;">
							{{$data['created_at']}}
						</td>
					</tr>
	  			</tbody>
	  		</table>
	  		<table class="" id="">
	   			<tbody>  
			        <tr>
			            <th scope="row" data-header=" " style="width: 400px;">
			            	<img src="{{ asset('images/logo.jpg') }}" alt="" class="img-logo">
			            </th>
			            <td data-header="Deposit">
			            	<h1 class="main-title">
								{{$data['zone_name']}}
							</h1>
						</td>
			        </tr> 
	  			</tbody>
	  		</table>
	  	</div>
	  	<div>
	  		<h1 class="section-title-1">Objetivos, interpretación y generalidades para mejorar la gestión de riego</h1>
	  		<div class="paragraph-container">
	  			<strong>
	  				Los 3 Objetivo de CDTEC al hacer Gestión de Riego son, productividad, eficiencia en el uso de los recursos y sustentabilidad. Integrar información dinámica de agua, planta, riego, clima con productividad, diferenciado por etapa fenológica (fechas aprox).
	  			</strong>
				Dinámica de agua en el suelo (humedad de suelo), contenido y volumen de agua asociado a sondas. 
	  			<strong>(Frecuencia/Tiempo.)</strong>
				Planta y productividad (Raíces, foliar y fruta), potenciales xilemáticos.				
				Riego, cantidades de agua/ha (huella de agua).				
				Clima, ETo, humedad, temperatura, DPV, etc.
	  			<strong>
	  				Generación de coeficientes planta (valores de Kc Sonda por fenología), que permiten manejar por sectores de riego.Auditoría del sistema de riego con seguimiento a la variabilidad de riego mensual (mm/hr), uniformidad.
	  			</strong>
	  			<h4>INTERPRETACIÓN DE GRÁFICOS</h4>
	  			<strong>
	  				Buscamos interpretar la dinámica de agua por fenología evaluando el estatus de humedad, frecuencia y tiempo de riego.
					Círculos y líneas en rojos muestran problemas específicos a mejorar por fenología, en azul se asocia a una estrategia correcta.
					Kc, busca la lógica por fenología más que valores absolutos.
					Técnica y su administración, busca definir si falta técnica o administración.
	  			</strong>
	  			Técnica, definir puntos críticos (Mínimo y máximo), por fenología.
	  			Administración de la técnica, respetar puntos críticos con estrategia de frecuencia y tiempo.
	  			<h4>IMPORTANTE PARA HACER UNA BUENA GESTIÓN DE RIEGO</h4>
	  			<strong>
	  				El regar lo justo permite sobrellevar mejor un problema de falta de agua.  				
					La ciencia del riego está en llegar a manejar un estanque o bulbo de humedad montado sobre un bulbo radicular (rizosfera).
					Nuestras estrategias de riego frecuencia y tiempo definen la calidad, cantidad y ubicación de las raíces.
					La sustentabilidad y vida del suelo (física, química y biología del suelo), son el resultado de nuestras estrategias de riego y nutrición.
					Una mala definición de tiempo de riego genera problemas con la ubicación y calidad de la rizosfera afectando la frecuencia de riego.
	  			</strong>
	  		</div>
	  	</div>
	  	<div>
  			<h1 class="section-title-1">Información</h1>
			<table class="info-table" id="t182720">
				<tbody>  
					<tr>
					    <th scope="row" data-header=" " >Campo</th>
					    <td data-header="Deposit" >{{$data['farm_name']}}</td>
					</tr>  
					<tr>
					    <th scope="row" data-header=" " >Contacto</th>
					    <td data-header="Deposit" >{{$data['account_name']}}</td>
					</tr>  
					<tr>
					    <th scope="row" data-header=" " >Teléfono</th>
					    <td data-header="Deposit" >{{$data['account_telefono']}}</td>
					</tr>  
					<tr>
					    <th scope="row" data-header=" " >Correo</th>
					    <td data-header="Deposit" >{{$data['account_email']}}</td>
					</tr>  
				</tbody>
			</table>
		</div>
		<div>
			<h1 class="section-title-2">Dinamica de agua por fenología</h1>
			<h1 class="section-title-1">Observaciones Generales</h1>
			<div>
				<p id="primer-parrafo-0" class="danger-text">
					{{$data['first_general_remarks']}}
				</p>
			</div>
		</div>
		<div>
			<table class="table-style wdn_responsive_table flush-left" id="t182720" style="
			  border-collapse: separate;
			  border-spacing: 0px 20px;">
				<tbody>  
					<tr>
					    <th scope="row" data-header=" " style="background-color:#d5d5d2;color:#000;width:30%;">Sector</th>
					    <td data-header="Deposit" style="background-color: #bfd8f2;text-align:right;width:70%;">{{$data['zone_name']}}</td>
					</tr>  
					<tr>
					    <th scope="row" data-header=" " style="background-color:#d5d5d2;color:#000;width:30%;">Poscosecha 2019</th>
					    <td data-header="Deposit" style="background-color: #bfd8f2;text-align:right;width:70%;">{{$data['poscosecha_2019']}}</td>
					</tr>  
					<tr>
					    <th scope="row" data-header=" " style="background-color:#d5d5d2;color:#000;width:30%;">Caída de hoja</th>
					    <td data-header="Deposit" style="background-color: #bfd8f2;text-align:right;width:70%;">{{$data['caida_de_hoja']}}</td>
					</tr>  
					<tr>
					    <th scope="row" data-header=" " style="background-color:#d5d5d2;color:#000;width:30%;">Brotación</th>
					    <td data-header="Deposit" style="background-color: #bfd8f2;text-align:right;width:70%;">{{$data['brotacion']}}</td>
					</tr> 
					<tr>
					    <th scope="row" data-header=" " style="background-color:#d5d5d2;color:#000;width:30%;">Cuaja</th>
					    <td data-header="Deposit" style="background-color: #bfd8f2;text-align:right;width:70%;">{{$data['cuaja']}}</td>
					</tr>   
					<tr>
					    <th scope="row" data-header=" " style="background-color:#d5d5d2;color:#000;width:30%;">Maduración</th>
					    <td data-header="Deposit" style="background-color: #bfd8f2;text-align:right;width:70%;">{{$data['maduracion']}}</td>
					</tr>  
					<tr>
					    <th scope="row" data-header=" " style="background-color:#d5d5d2;color:#000;width:30%;">Raíces</th>
					    <td data-header="Deposit" style="background-color: #bfd8f2;text-align:right;width:70%;">{{$data['raices']}}</td>
					</tr> 
					<tr>
					    <th scope="row" data-header=" " style="background-color:#d5d5d2;color:#000;width:30%;">Técnica y su administración</th>
					    <td data-header="Deposit" style="background-color: #bfd8f2;text-align:right;width:70%;">{{$data['tecnica_y_administracion']}}</td>
					</tr>  
				</tbody>
			</table>
		</div>
		<div>
			<h1  class="section-title-1">Gráfica Sonda Monitoreo de Suelo</h1>
			<div class="">
				<img style="width: 100%;" src="{{$data['graph1_url']}}"> 
			</div>
		</div>
		<div>
			<h1 class="section-title-1">Observaciones Generales</h1>
			<div>
				<p id="primer-parrafo-1" class="danger-text">
					{{$data['second_general_remarks']}}
				</p>
			</div>
		</div>
		<div>
			<h1  class="section-title-1">Balance hídrico</h1>
			<table class="table-style wdn_responsive_table flush-left" id="t182720" style="
			  border-collapse: separate;
			  border-spacing: 0px 20px;">
				<tbody>  
					<tr>
					    <th scope="row" data-header=" " style="background-color:#d5d5d2;color:#000;width:30%;">KC sonda</th>
					    <td data-header="Deposit" style="background-color: #bfd8f2;text-align:right;width:70%;">{{$data['kc_sonda']}}</td>
					</tr>  
					<tr>
					    <th scope="row" data-header=" " style="background-color:#d5d5d2;color:#000;width:30%;">Huella del agua</th>
					    <td data-header="Deposit" style="background-color: #bfd8f2;text-align:right;width:70%;">{{$data['huella_agua']}}</td>
					</tr>  
					<tr>
					    <th scope="row" data-header=" " style="background-color:#d5d5d2;color:#000;width:30%;">Técnica y su administración</th>
					    <td data-header="Deposit" style="background-color: #bfd8f2;text-align:right;width:70%;">{{$data['tecnica_administracion']}}</td>
					</tr>  				
				</tbody>
			</table>
		</div>
		<div>
			<h1 class="section-title-1">Operación de Equipos</h1>
			<table class="table-style wdn_responsive_table flush-left" id="t182720" style="
			  border-collapse: separate;
			  border-spacing: 0px 20px;">
				<tbody>  
					<tr>
					    <th scope="row" data-header=" " style="background-color:#d5d5d2;color:#000;width:30%;">Estación de Clima</th>
					    <td data-header="Deposit" style="background-color: #bfd8f2;text-align:right;width:70%;">{{$data['estacion_de_clima']}}</td>
					</tr>  
					<tr>
					    <th scope="row" data-header=" " style="background-color:#d5d5d2;color:#000;width:30%;">Equipo de Riego</th>
					    <td data-header="Deposit" style="background-color: #bfd8f2;text-align:right;width:70%;">{{$data['equipo_de_riego']}}</td>
					</tr>  
					<tr>
					    <th scope="row" data-header=" " style="background-color:#d5d5d2;color:#000;width:30%;">Raíces</th>
					    <td data-header="Deposit" style="background-color: #bfd8f2;text-align:right;width:70%;">{{$data['raices']}}</td>
					</tr>  
					<tr>
					    <th scope="row" data-header=" " style="background-color:#d5d5d2;color:#000;width:30%;">Técnica y su administración</th>
					    <td data-header="Deposit" style="background-color: #bfd8f2;text-align:right;width:70%;">{{$data['tecnica_y_administracion']}}</td>
					</tr>  
				</tbody>
			</table>
		</div>
		<div>
			<h1 class="section-title-1">Observaciones Generales</h1>
			<div>
				<p id="primer-parrafo-2" class="danger-text">
					{{$data['third_general_remarks']}}
				</p>
			</div>
		</div>
		<div style="position: relative;">
			<div style="width: 300px;position: absolute;bottom: 5px;right: 50px;">
				<img src="{{ asset('images/Imagen1logo.png') }}" alt="" class="w-100">
			</div>
		</div>
  	</body>
</html>