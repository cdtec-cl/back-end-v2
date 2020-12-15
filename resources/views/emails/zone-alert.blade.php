<html>
	<head>
		<title>Alerta de zona</title>
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
		<div>  
		  <!--Signature-->
		  <p class="signature">
		    <span class="name">
		    	{{$alertMessage["title"]}}
		    </span>
		    <br>   
		  </p>
		  <p class="signature">
		    <span class="name">
		    	Estimados;
		    </span>
		    <br>
		    Junto con saludar, informamos lo siguiente: <br> {{$alertMessage["content"]}}    
		  </p>
		  <p class="signature">
		    <span class="name">Saludos</span><br>		    
		  </p>
		  <!--Logo-->
		  <!-- <img src="http://www.alimsag.cl/wp-content/uploads/2019/05/nutraline-logo.png" class="logo" alt="Company Logo" title="Go to our website"> -->
		</div>
	</body>
</html>