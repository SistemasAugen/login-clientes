<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<style>
		.imagen_logo{

		}



		.img-container{
			width: 100%;
			text-align: center;
		}

		.title{
			color: black;
			font-size: 12px;
			font-family: Arial,Helvetica Neue,Helvetica,sans-serif;
			font-weight: bold;
		}
		.cuerpo{
			font-size: 12px;
			text-align: justify;
		}

		.pie{
			font-size: 12px;
			font-family: Arial,Helvetica Neue,Helvetica,sans-serif; 
			text-align: left;
		}

		body{
			
			font-family: Arial,Helvetica Neue,Helvetica,sans-serif; 
			font-size: 12px;
			background-color: white;
		}


        .img-producto{
            max-width: 100px;
            max-height: 100px;
            width: 100%;
            height: 100%;
        }

		.derecha{
			text-align: right;
		}

		.text-center {
			text-align: center;
		}

		.hr_1{
			border-top: 1px solid #8c8b8b;
		}
		.hr_2 {
			border-top: 1px dashed #8c8b8b;
		}

		.hr_2 {
			background-color: #fff;
			border-top: 2px dotted #8c8b8b;
		}
		h1{
		  text-align:center;
		}
		table {
			  font-family: arial, sans-serif;
			  border-collapse: collapse;
			  width: 100%;
			}

			td, th {
			  border: 1px solid #dddddd;
			  text-align: left;
			  padding: 8px;
			}
		/*@page {
                margin: 0cm 0cm;
            }*/
			.header,

			.header {
				top: 0px;
			}
			
				
	</style>
</head>
<body>
	<div class="img-container" style="text-align: center;">		
		<img src="https://sistema.augenlabs.com/public/images/logo.png" alt="" class="imagen_logo" width="250px" >
	</div>
	<br>
	<table style="text-align:center;width: 100%;color: gray;">

		<tr>
		    <th style="text-align:center;">RX</th>
            <td style="text-align:center;">{{ $inputs['rx_rx'] }} </td>
        </tr>
        <tr>
		    <th style="text-align:center;">Fecha</th>
            <td style="text-align:center;">{{ $inputs['rx_fecha'] }} </td>
        </tr>
        <tr>
		    <th style="text-align:center;">Cliente</th>
            <td style="text-align:center;">{{ $inputs['rx_cliente'] }} </td>
        </tr>

        <tr>
		    <th style="text-align:center;">OD Esfera</th>
            <td style="text-align:center;">{{ $inputs['rx_od_esfera'] }} </td>
        </tr>
        <tr>
		    <th style="text-align:center;">OD Clilindro</th>
            <td style="text-align:center;">{{ $inputs['rx_od_cilindro'] }} </td>
        </tr>
        <tr>
		    <th style="text-align:center;">OD Eje</th>
            <td style="text-align:center;">{{ $inputs['rx_od_eje'] }} </td>
        </tr>
        <tr>
		    <th style="text-align:center;">OD Adición</th>
            <td style="text-align:center;">{{ $inputs['rx_od_adicion'] }} </td>
        </tr>
        <tr>
		    <th style="text-align:center;">OD Dip</th>
            <td style="text-align:center;">{{ $inputs['rx_od_dip'] }} </td>
        </tr>
        <tr>
		    <th style="text-align:center;">OD Altura</th>
            <td style="text-align:center;">{{ $inputs['rx_od_altura'] }} </td>
        </tr>

        <tr>
		    <th style="text-align:center;">OD Esfera</th>
            <td style="text-align:center;">{{ $inputs['rx_od_esfera_dos'] }} </td>
        </tr>
        <tr>
		    <th style="text-align:center;">OD Clilindro</th>
            <td style="text-align:center;">{{ $inputs['rx_od_cilindro_dos'] }} </td>
        </tr>
        <tr>
		    <th style="text-align:center;">OD Eje</th>
            <td style="text-align:center;">{{ $inputs['rx_od_eje_dos'] }} </td>
        </tr>
        <tr>
		    <th style="text-align:center;">OD Adición</th>
            <td style="text-align:center;">{{ $inputs['rx_od_adicion_dos'] }} </td>
        </tr>
        <tr>
		    <th style="text-align:center;">OD Dip</th>
            <td style="text-align:center;">{{ $inputs['rx_od_dip_dos'] }} </td>
        </tr>
        <tr>
		    <th style="text-align:center;">OD Altura</th>
            <td style="text-align:center;">{{ $inputs['rx_od_altura_dos'] }} </td>
        </tr>

        <tr>
		    <th style="text-align:center;">Diseño</th>
            <td style="text-align:center;">{{ $inputs['rx_diseno'] }} </td>
        </tr>
        <tr>
		    <th style="text-align:center;">Material</th>
            <td style="text-align:center;">{{ $inputs['rx_material'] }} </td>
        </tr>
        <tr>
		    <th style="text-align:center;">Tipo AR</th>
            <td style="text-align:center;">{{ $inputs['rx_tipo_ar'] }} </td>
        </tr>
        <tr>
		    <th style="text-align:center;">Tallado</th>
            <td style="text-align:center;">{{ $inputs['rx_tallado'] }} </td>
        </tr>
        <tr>
		    <th style="text-align:center;">Tipo de armazón</th>
            <td style="text-align:center;">{{ $inputs['rx_tipo_armazon'] }} </td>
        </tr>
        <tr>
		    <th style="text-align:center;">Horizontal "A"</th>
            <td style="text-align:center;">{{ $inputs['rx_horizontal_a'] }} </td>
        </tr>
        <tr>
		    <th style="text-align:center;">Vertical "B"</th>
            <td style="text-align:center;">{{ $inputs['rx_vertical_b'] }} </td>
        </tr>
        <tr>
		    <th style="text-align:center;">Diagonal "ED"</th>
            <td style="text-align:center;">{{ $inputs['rx_diagonal_ed'] }} </td>
        </tr>
        <tr>
		    <th style="text-align:center;">Puente</th>
            <td style="text-align:center;">{{ $inputs['rx_puente'] }} </td>
        </tr>
        <tr>
		    <th style="text-align:center;">Observaciones</th>
            <td style="text-align:center;">{{ $inputs['rx_observaciones'] }} </td>
        </tr>
       
	</table> 

    
		
</body>

</html>
