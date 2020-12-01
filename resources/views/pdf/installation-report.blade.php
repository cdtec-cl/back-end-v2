<html>
	<head>
		<title>Reporte</title>
		<style>
			/*@import url("https://fonts.googleapis.com/css2?family=Archivo+Narrow:wght@500&family=Ubuntu&display=swap");*/

			table {
			  width: 100%;
			  max-width: 100%;
			  border-collapse: collapse;
			}
			h1 {
			  font-size: 2rem;
			  color: #1f4278;
			  font-family: "Ubuntu", sans-serif;
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

			table caption {
			  font-weight: 400;
			  text-transform: uppercase;
			  font-family: "Ubuntu", sans-serif;
			  line-height: 1;
			  margin-bottom: 0.75em;
			}
			table th {
			  font-weight: 400;
			  text-transform: capitalize;
			  font-family: "Ubuntu", sans-serif;
			  padding: 1.2307em 1.0833em 1.0833em;
			  line-height: 1.333;
			  background-color: #1f4278;
			  color: #ffffff;
			}

			table td,
			table th {
			  text-align: left;
			}
			table td {
			  padding: 0.92307em 1em 0.7692em;
			  font-family: "Archivo Narrow", sans-serif;
			}
			table tbody tr:nth-of-type(even) {
			  background-color: #cccccc;
			}
			table tbody tr:nth-of-type(odd) {
			  background-color: #e6e6e6;
			}
			table tbody th {
			  border-top: 1px solid #d5d5d2;
			}
			table tbody td {
			  border-top: 1px solid #d5d5d2;
			}
			table.wdn_responsive_table thead th abbr {
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
			}
			.main-title{				
			    font-size: 70px;
			    text-align: center;
			}
			.p-05{
				padding: 5%;
			}

			table {
            border: 1px solid;
            border-collapse: collapse;
            margin: 30px 0px;
        }

        td, th {
            border: 1px solid;
            padding: 0 10px;
            /*text-align: center;*/
        }

        /* style one */
        table.makeit_rwd_default {
            margin: 0 auto;
            border-collapse: collapse;
            font-family: Agenda-Light, sans-serif;
            font-weight: 100;
            background: #333;
            color: #fff;
            text-rendering: optimizeLegibility;
            border-radius: 5px;
        }

        table.makeit_rwd_default caption {
            font-size: 2rem;
            color: #444;
            margin: 1rem;
        }

        table.makeit_rwd_default thead th {
            font-weight: 600;
        }

        table.makeit_rwd_default thead th, table.makeit_rwd_default tbody td {
            padding: .8rem;
            font-size: 1.4rem;
        }

        table.makeit_rwd_default tbody td {
            padding: .8rem;
            font-size: 1.4rem;
            color: #444;
            background: #eee;
        }

        table.makeit_rwd_default tbody tr:not(:last-child) {
            border-top: 1px solid #ddd;
            border-bottom: 1px solid #ddd;
        }

        /* STYLE 2 */
        table.makeit_rwd_default2 {
            margin: 0 auto;
            border-collapse: collapse;
            font-family: Agenda-Light, sans-serif;
            font-weight: 100;
            background: #333;
            color: #fff;
            text-rendering: optimizeLegibility;
            border-radius: 5px;
        }

        table.makeit_rwd_default2 caption {
            font-size: 2rem;
            color: #444;
            margin: 1rem;
        }

        table.makeit_rwd_default2 thead th {
            font-weight: 600;
        }

        table.makeit_rwd_default2 thead th, table.makeit_rwd_default2 tbody td {
            padding: .8rem;
            font-size: 1.4rem;
        }

        table.makeit_rwd_default2 tbody td {
            padding: .8rem;
            font-size: 1.4rem;
            color: #444;
            background: #eee;
        }

        table.makeit_rwd_default2 tbody tr:not(:last-child) {
            border-top: 1px solid #ddd;
            border-bottom: 1px solid #ddd;
        }

		</style>
	</head>
	<body>
		<table class="wdn_responsive_table flush-left" id="t182720">
   			<tbody>  
		        <tr>
		            <th scope="row" data-header=" ">Informe de Instalación CDTEC</th>
		            <td data-header="Deposit">Certificado por CDTEC</td>
		        </tr>  
		        <tr>
		            <th scope="row" data-header=" ">Fecha</th>
		            <td data-header="Deposit">{{$data['date']}}</td>
		        </tr>  
  			</tbody>
  		</table>
  		<div class="d-flex">
  			<div class="w-50">
  			 	<img src="{{ asset('images/logo.jpg') }}" alt="" class="img-logo">
  			</div>
  			<div class="w-50">
  				<h1 class="main-title">
					{{$data['zone_name']}}
				</h1>
			</div>
  		</div>
  		<h1>Información</h1>
		<table class="wdn_responsive_table flush-left" id="t182720">
			<tbody>  
				<tr>
				    <th scope="row" data-header=" ">Campo</th>
				    <td data-header="Deposit">{{$data['farm_name']}}</td>
				</tr>  
				<tr>
				    <th scope="row" data-header=" ">Contacto</th>
				    <td data-header="Deposit">{{$data['account_name']}}</td>
				</tr>  
				<tr>
				    <th scope="row" data-header=" ">Teléfono</th>
				    <td data-header="Deposit">{{$data['account_telefono']}}</td>
				</tr>  
				<tr>
				    <th scope="row" data-header=" ">Correo</th>
				    <td data-header="Deposit">{{$data['account_email']}}</td>
				</tr>  
			</tbody>
		</table>
		<h1>Detalles de Instalación</h1>
		<div>
			<p id="primer-parrafo">
				{{$data['general_detail']}}
			</p>
		</div>
		<h1>Datos Sector Sonda Monitoreo de Suelo</h1>
		<table class="wdn_responsive_table flush-left" id="t182720">
			<tbody>  
				<tr>
				    <th scope="row" data-header=" ">Sector</th>
				    <td data-header="Deposit">{{$data['zone_name']}}</td>
				</tr>  
				<tr>
				    <th scope="row" data-header=" ">Especie</th>
				    <td data-header="Deposit">{{$data['species']}}</td>
				</tr>  
				<tr>
				    <th scope="row" data-header=" ">Variedad</th>
				    <td data-header="Deposit">{{$data['variety']}}</td>
				</tr>  
				<tr>
				    <th scope="row" data-header=" ">Superficie HA</th>
				    <td data-header="Deposit">{{$data['HA_surface']}}</td>
				</tr> 
				<tr>
				    <th scope="row" data-header=" ">Año de Plantación</th>
				    <td data-header="Deposit">{{$data['planting_year']}}</td>
				</tr>   
			</tbody>
		</table>
		<table class="makeit_rwd">
			<thead>
			    <tr>
			        <th>Sonda </th>
			        <th  colspan="2">Sensores</th>
			        <th  colspan="2">Datos Visuales</th>
			    </tr>
			    <tr>
			        <th rowspan="2">Profundidad (cm)</th>
			        <th>T° y HR</th>
			        <th>Salinidad</th>
			        <th>Humedad a Mano</th>
			        <th>Textura</th>
			    </tr>
			</thead>
			<tbody>
			    <tr>
			        <td>10</td>
			        <td>SI</td>
			        <td>NO</td>
			        <td>H 3,5</td>
			        <td>Franco Arenosa</td>
			    </tr>
			    <tr>
			        <td>20</td>
			        <td>SI</td>
			        <td>NO</td>
			        <td>H 3,5</td>
			        <td>Franco Arenosa</td>
			    </tr>
			    <tr>
			        <td>50</td>
			        <td>SI</td>
			        <td>NO</td>
			        <td>H 3,5</td>
			        <td>Franco Arenosa</td>
			    </tr>
			    <tr>
			        <td>10</td>
			        <td>SI</td>
			        <td>NO</td>
			        <td>H 4</td>
			        <td>Arenosa</td>
			    </tr>
			    <tr>
			        <td>60</td>
			        <td>SI</td>
			        <td>NO</td>
			        <td>H 4</td>
			        <td>Arenosa</td>
			    </tr>
			    <tr>
			        <td>70</td>
			        <td>SI</td>
			        <td>NO</td>
			        <td>H 4</td>
			        <td>Arenosa</td>
			    </tr>
			</tbody>
		</table>
		<h1>Observaciones Generales</h1>
		<div>
			<p id="primer-parrafo-0">
				{{$data['general_remarks']}}
			</p>
		</div>
		<h1>Datos Sector de Riego</h1>
		<table class="wdn_responsive_table flush-left" id="t182720">
			<tbody>  
				<tr>
				    <th scope="row" data-header=" ">Sector</th>
				    <td data-header="Deposit">{{$data['zone_name']}}</td>
				</tr>  
				<tr>
				    <th scope="row" data-header=" ">Sistema de Riego</th>
				    <td data-header="Deposit">{{$data['irrigation_system']}}</td>
				</tr>  
				<tr>
				    <th scope="row" data-header=" ">Precipitación del sistema</th>
				    <td data-header="Deposit">{{$data['system_precipitation']}}</td>
				</tr>  
				<tr>
				    <th scope="row" data-header=" ">Distancia entre los emisores</th>
				    <td data-header="Deposit">{{$data['distance_between_emitters']}}</td>
				</tr> 
				<tr>
				    <th scope="row" data-header=" ">Marco de plantación</th>
				    <td data-header="Deposit">{{$data['sector_plantation_frame']}}</td>
				</tr>   
			</tbody>
		</table>
		<h1>Aspectos de la zona de Instalación</h1>
		<table class="wdn_responsive_table flush-left" id="t182720">
			<tbody>  
				<tr>
				    <th scope="row" data-header=" ">Planta</th>
				    <td data-header="Deposit">{{$data['plant']}}</td>
				</tr>  
				<tr>
				    <th scope="row" data-header=" ">Distancia planta - sonda</th>
				    <td data-header="Deposit">{{$data['plant_probe_distance']}}</td>
				</tr>  
				<tr>
				    <th scope="row" data-header=" ">Distancia sonda - gotero</th>
				    <td data-header="Deposit">{{$data['probe_dropper_distance']}}</td>
				</tr>  
				<tr>
				    <th scope="row" data-header=" ">Distancia entre los emisores</th>
				    <td data-header="Deposit">{{$data['distance_between_emitters']}}</td>
				</tr> 
				<tr>
				    <th scope="row" data-header=" ">Marco de plantación</th>
				    <td data-header="Deposit">{{$data['zone_plantation_frame']}}</td>
				</tr>   
			</tbody>
		</table>
		<h1>Observaciones Generales</h1>
		<div>
			<p id="primer-parrafo-0">
				{{$data['general_remarks']}}
			</p>
		</div>
		<h1>Imágenes Sector</h1>
		<div class="d-flex">
			<div class="w-25 p-05">
				<img class="" src="http://localhost:8000/images/1605389530-34.jpg" style="width: 100%;">
			</div>
			<div class="w-25 p-05">
				<img class="" src="http://localhost:8000/images/1605389530-34.jpg" style="width: 100%;">
			</div>
			<div class="w-25 p-05">
				<img class="" src="http://localhost:8000/images/1605389530-34.jpg" style="width: 100%;">
			</div>
		</div>
	</body>
</html>