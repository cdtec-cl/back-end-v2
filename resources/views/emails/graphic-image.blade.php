<html>
	<head>
		<title>Imagen de edición de gráfica en formato .SVG</title>
		<style>
			body {
			  font-family: Helvetica, Arial, sans-serif;
			  font-size: 11pt;
			  font-weight: 300;
			  /* color: OliveDrab; */
			}
			.signature {
			  font-size: 11pt;
			}
			.signature .name {
			  font-weight: 300;
			  font-style: italic;
			  /* color: DarkGreen; */
			}
			.signature .title {
			  font-weight: 500;
			  font-style: italic;
			  /* color: OliveDrab; */
			}
			img {
			  width: 200px;
			  max-width: 100vw;
			}
			a {
			  text-decoration: none;
			  color: black;
			}
			.label,
			.website {
			  font-weight: 400;
			  /* color: OliveDrab; */
			}
			@media (max-width: 450px) {
			  body {
			    font-size: 11pt;
			  }
			}
		</style>
	</head>
	<body>
		<div >
  
		  <!--Signature-->
		  <p class="signature">
		    <span class="name">Estimados;</span><br>
		    Junto con saludar, se le adjunta archivo de gráfica editada en formato "<span class="title"><em>SVG</em></span>" puede descargarlo y visualizarlo con  "<span class="title"><em>Google Chrome</em></span>", 		    
		  </p>
		  <p>
		    <!--Phone Numbers-->
		
			<span style="color:#00000">Fecha de evento: <strong>{{$eventDate?$eventDate:'Sin fecha de evento'}} </strong> </span><br> 
			<span style="color:#00000">Hora de evento:  <strong>{{$eventTime?$eventTime:'Sin hora de evento'}}</strong></span> <br>  
			<span style="color:#00000">Comentario: <strong>{{$comment?$comment:'Sin comentario'}}</strong></span> 
		  </p>
		  <!--Logo-->
		  <!-- <img src="http://www.alimsag.cl/wp-content/uploads/2019/05/nutraline-logo.png" class="logo" alt="Company Logo" title="Go to our website"> -->
		</div>
	</body>
</html>