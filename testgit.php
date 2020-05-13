<?
/*
$pv=scandir('promoventas/',1);
$imgs = array('jpg','jpge','png','gif','PNG','JPG');
$video = array('mp4','MP4');
$order=array();
for($x=0;$x<=count($pv);$x++)
{
	list($f,$e) = explode('.',$pv[$x]);
	if(in_array($e,$imgs))
		$order[$f]= "<img class='promo' style='max-width: 99px;' id='".$pv[$x]."' title='".$pv[$x]."' src='promoventas/".$pv[$x]."'  />";
	if(in_array($e,$video))
		$order[$f]= "<video class='promo' id='".$pv[$x]."' width='99' controls><source src='promoventas/".$pv[$x]."' type='video/mp4'></video>";
	if($x>=50)
		break;
}
$y=0;
$columnas=4;
$tbl="<div id='promoventas' class='no_imp' style='max-height: 270px; overflow: auto; display:none;'>";
$tbl.="<table  text-align='center' style='margin: auto; '><tr>";
for($x=count($order);$x>=1;$x--)
{
	$y++;
	$tbl.='<td>'.$order[$x].'</td>';
	if($y>=$columnas)
	{
		$y=0;
		$tbl.= '</tr><tr>';
	}
}
if($y!=$columnas)
{
	$rellenar=$columnas-$y;
	for($x=1;$x<=$rellenar;$x++)
		$tbl.='<td></td>';
	$tbl.= '</tr>';
}
$tbl.='</table></div>';
*/
if($a=='nutrifest')
{
	$pr=($pr==''||is_numeric ($pr))?'NUTRIFEST 19':$pr;
	$serial=$_GET['evento'];;
	$envia='NF';
	$clase=3;
	$psd=2019;
	$guia=intval($_GET['id_face']);
	if($status=='ppl'&&$row->name!='')
	{
		$n2=$_GET['n'];
		$m2=$_GET['e'];
	}
	else
	{
		$name=$_GET['n']; 
		$rmail=$_GET['e'];
	}	
	$ocupada="<br/><br/><center><h2> El pago esta a nombre de ".$row->name.' <br>  '.$row->n2."</h2> <p>Pedir comprobante al cliente y avisar a Manuel <br/> <a href='https://www.expedientemedicioelectronico.com/epco/paypal/pay_functions.php?id=$id&action=abrir'>Abrir venta</a></p> </center>";
	
	if($id=='')
		die('<br/><br/><center><h2>No se encontr&oacute; el pago </h2> <p>Pedir comprobante al cliente</p> </center>');
	else if ($row->guia!=''&&$row->guia>0)
		die($ocupada.' id facebook='.$row->guia);
	else if($asesor!=''&&$asesor!='App Nutrifest')
		die('<br/><br/><center><h2> Venta previamente asignada a '.$row->asesor.'</h2> <p> Realizar cambios de manera manual</p> </center>');
	else if($row->name!=''&&$status=='bmx')
		die($ocupada);
	else if($costo!=$_GET['c']&&$status=='bmx')
		die('<br/><br/><center><h2> No coincide la cantidad menciona por el cliente </h2> <p>Pedir comprobante al cliente</p> </center>');	
}
$mi_clave=$rastreo='';
$no= array('ONLI','XXXX','MKTG','','NULL','0000','NF18','NF19'); 
if($envia=='fedex')
	$rastreo="https://www.fedex.com/apps/fedextrack/?tracknumbers=$guia&cntry_code=mx";
else if($envia=='dhl')
	$rastreo="http://www.dhl.com.mx/es/express/rastreo.html?AWB=$guia&brand=DHL";

if(in_array($serial,$no)==0) 
	$mi_clave="http://www.nutrimind.net/page/mi_clave/".$serial;  

$select_iva='';
if($iva==Null&&$mov<1)
{
	$ivaholder=round($costo-($costo/1.16),2); 
		$select_iva="<select id='ivacal'>
			<option value='IVA'>IVA</option>
			<option value='0'>0</option>
			<option value='$ivaholder'>$ivaholder</option>
		</select>";
}
if($admin_name=='' || $admin_name==Null)
	die('Es necesario hecer login'); 
	
require_once('arrays.php');

$ver=array(
'new'=>array('pais'=>1,'fecha'=>1,'pr'=>1,'cos'=>1,'mon'=>1,'modo'=>1,'title'=>'Nueva venta','a'=>'crear'),	
'ml'=>array('pais'=>1,'fecha'=>1,'pr'=>1,'cos'=>1,'mon'=>1,'modo'=>0,'title'=>'Mercado Libre','a'=>'Actualizar'),
'cortesia'=>array('pais'=>1,'fecha'=>1,'pr'=>1,'cos'=>0,'mon'=>0,'modo'=>0,'title'=>'Cortesia','a'=>'Actualizar'),
'ppl'=>array('pais'=>0,'fecha'=>0,'pr'=>0,'cos'=>0,'mon'=>0,'modo'=>0,'title'=>'Paypal','a'=>'Actualizar'),
'bmx'=>array('pais'=>0,'fecha'=>0,'pr'=>1,'cos'=>0,'mon'=>0,'modo'=>0,'title'=>'Banamex','a'=>'Actualizar'),
'personal'=>array('pais'=>0,'fecha'=>1,'pr'=>1,'cos'=>1,'mon'=>1,'modo'=>0,'title'=>'pago personal','a'=>'Actualizar'),
'zona'=>array('pais'=>0,'fecha'=>1,'pr'=>1,'cos'=>1,'mon'=>1,'modo'=>0,'title'=>'pago a Zona Médica','a'=>'Actualizar'),
'vitamex'=>array('pais'=>0,'fecha'=>1,'pr'=>1,'cos'=>1,'mon'=>1,'modo'=>0,'title'=>'pago a Vitamex','a'=>'Actualizar'),
'wst'=>array('pais'=>1,'fecha'=>1,'pr'=>1,'cos'=>1,'mon'=>1,'modo'=>1,'title'=>'Western Union','a'=>'Actualizar')
);
if(is_null($asesor)||$asesor=='')
	$asesor=$admin_name;

if(is_null($f[1])||$f[1]=='')
	$f[1]=date('Y-m-d');

if($mov==0)
{
	$cat_cl=$cat_cl_gastos;
}

?>
<meta charset="UTF-8">
<center>
<img class='only_imp' src='https://www.expedientemedicioelectronico.com/epco/images/logo_uninut_color.png' />
<br/><br/>
<img id='certificar' class='no_imp' onclick="window.print();" src='img/pdf.png'/>
<div id='form'>

<p class='title'>
<span class='only_imp uppercase' >
<img src='img/certificar.png'/>
Certificado de compra
<br/></span>
<span class='no_imp'><?=$ver[$status]['title']?> <br/></span>
<? if($url):?>
	<span class='no_imp'>URL <?=$url?></span>
<?endif;?>
</p> 

<form method="post"  enctype="multipart/form-data"  action="pay_functions.php?action=<?=$ver[$status]['a']?>" >
<table>
<tr>
	<td>Fecha</td>
	<td>
	<? if($ver[$status]['fecha'])
			echo "<input type='date' name='fecha' value='".$f[1]."'>";
		else
			echo "<span id=''>".$f[0].'</span><br/>';
	?>
	</td>
</tr>
<tr>
	<td>
		<? if($mov>0): ?>Nombre <?else:?> Provedor <?endif;?>
	</td>
	<td>
		<? if($status=='ppl'||$pag)
			echo "<span class='l'>".$name."</span>";
		else
			echo "<input name='name' id='name' class='capitalize' type='text' value='".$name."'  size='50' autocomplete='off' required /><div id='campo_nombre'></div> ";
		?>
	</td>
</tr> 
<? if($mov>0): ?>
<tr>
	<td>
		Email
	</td>
	<td>
		<?if($status=='ppl'||$pag): ?>
			<span class='l'><?=$rmail?></span>  
		<?else:?>
			<input type='email'  class='lowercase' value='<?=$rmail?>' type='email' name='mail' size='50' required>
		 <?endif;?>
		 <!--<iframe src='/epco/acciones.php?q=check_user&ver=paloma&mailuser=<?=$rmail?>' scrolling='no' width='25' height='25' frameborder='0'></iframe>-->
	</td>
</tr> 
<? endif; ?>
<? if($status=='ppl'): ?>
<tr>
	<td>
		Nombre2
	</td>
	<td>
		<input name='n2' class='capitalize'  type='text' value='<?=$n2?>' size='50' />
	</td>
</tr> 
<tr>
	<td>
		Email2
	</td>
	<td>
		 <input name="m2" class='lowercase' type="email" value='<?=$m2?>'   size='50' />
		<!--<iframe src='/epco/acciones.php?q=check_user&ver=paloma&mailuser=<?=$m2?>' scrolling='no' width='30' height='30' frameborder='0'></iframe>-->
	
	</td>
</tr>
<? endif; ?>
	<? if($ver[$status]['pais']): ?>
<tr>  
	<td>País</td>
	<td><select name='pais'><?options($paises,$p);?></select>
</td>
</tr>
	<? endif; ?>
<tr>   
	<td>Producto</td>
	<td> 
		<?  if(($status=='ppl'&&$pr!='')||$pag):// if(!$ver[$status]['pr']&&$pr!=''):?>
		<span class=''><?=urldecode($pr)?></span>
		<?else:?>
		<input name='pr' id='pr' class='capitalize' value='<?=$pr?>' size='40'  type='text'  autocomplete='on' />
		<? endif; ?>
	</td>
</tr>

<tr class="no_imp">
	<td>Clase</td>
	<td>
	<select name='clase' id='clase'  pattern="^[1-20]+" required><? options($cat_cl,$clase); ?></select>	 
	</td>
</tr>
<? if($status!='new'):?>
<tr>
	<td>
		Modo de compra	
	</td>
	<td>
		<?=$ver[$status]['title']?>
		<input type='hidden' name='status'  value='<?=$status?>' />
	</td>
</tr>
	<? endif; ?>	
<tr>
	<td>
	Referencia de pago
	</td>
	<td>
	<?
		if($status=='ppl')
			echo "<a target='_blank' href='https://www.paypal.com/mx/cgi-bin/webscr?cmd=_view-a-trans&id=$ref'>$ref</a>";
		else if($status=='bmx')
			echo "<a target='_blank' href='https://mail.google.com/mail/u/0/#search/$ref'>$ref</a>";
		else
			echo "<input name='ref'  type='text'  value='$ref'  required/>";
	?>
	</td>
</tr>
<? if($status!='new'):?>
<tr>
	<td>
		Id de compra
	</td>
	<td>
		<?=$id?> 
	</td>
</tr>
<? endif; ?>
<!--
<tr class='no_imp'>
	<td>Ad_id:</td>
	
	<td>
	<?=$tbl?>
	<input  name='ad' id='ad' size='15' style='width: 270px;'  type='text'  value='<?=$row->ad?>'> 
	</td>
</tr>
-->
<tr class="no_imp">
	<td>Costo</td>
	<td>
	<? if(!$ver[$status]['cos']):
		$m=($m=='USD')?'U$':(($m=='EUR')?'&#8364':'&#36;');
		echo "<span > $m ".$costo."</span>";
		echo "<input type='hidden' name='costo' value='".$costo."' />"; 
	else: 
	?>
	<input  name='costo' size='4' type='number'  min='0' max='9999' step='.1' value='<?=$row->costo?>' required>
	<select name='moneda' <? if(!$ver[$status]['mon']) echo 'disabled';  ?>    >
			<?options($a_moneda,$m);?>
	</select>
	<?endif;?>
	</td>
</tr>

	
<? if($mov>0):?>
<tr class="no_imp"> 
	<td>Serial</td> 
	<td> 
		<input size='7' class='uppercase' name='serial' maxlength="7"   title="7 CARACTERES" type='text' value='<?=$serial?>' autocomplete='on' /> 
	</td>
</tr>
<tr class="no_imp">
	<td>Código</td> 
	<td>  
		<input size='14' name='psd' maxlength="14" placeholder='antes contraseña'  type='text' value='<?=$psd?>' autocomplete='off' required/> 
	</td>
</tr>
<tr class="no_imp">
	<td>
		Envía
	</td>
	<td>
	<select name='envia'><?options($a_envia,$envia);?></select>
	</td>
</tr>
<? endif; ?>

<? if($mov==0): ?>
<tr class="no_imp">
	<td>IVA </td>
	<td>
		<input  name='iva' id='iva'  size='4' step='.01'  type='number'  placeholder='<?=$ivaholder?>'   value='<?=$iva?>'/> 
		<?=$select_iva?>
	</td>
</tr>
<tr class="no_imp">
	<td>RFC </td>
	<td>
		<input  name='rfc' id='rfc'  style="width:150px;" size='15'  placeholder='RFC'   value='<?=$rfc?>'/> 
	</td>
</tr>
<? else: ?>
<tr class="no_imp">
	<td>Id externo </td>
	<td>
		<input  name='guia'  style="width:150px;" size='15'  placeholder='antes guia'   value='<?=$guia?>'/> 
	</td>
</tr>
<? endif;?>
<tr class="no_imp">
	<td>Factura</td>
	<td>
		<input  name='factura'  style="width:150px;" size='15'  placeholder=''   value='<?=$factura?>'/> 
	</td>
</tr>
<? if($ver[$status]['modo']): ?>
<tr>
 
	<td>Modo de compra</td>
	<td>
	<select name='modo'> 
	<?	
		for ($m=0;$m<count($mp);$m++)
		{
			$s=($status==$mp[$m][0])?'selected':'';
			echo "<option value='".$mp[$m][0]."' $s>".$mp[$m][1]."</option>";
		}
		?>
		</select>	 
	</td>
</tr>
<? endif; ?>
<? if($admin_name=='Manuel'&&$status=='new'): ?> 
<tr>
	<td>Movimiento</td>
	<td>
		<select name='movimiento'>
			<option <? if($mov==0) echo 'selected';  ?> value='0'>Egreso</option>
			<option <? if($mov>0) echo 'selected';  ?> value='1'>Ingreso</option>
		</select>
	</td>
</tr>
<? endif; ?>

</table>

<?
$disabled=($pag)?'disabled':'';
if($mov>0): ?>
<table  class="no_imp">
<tr>
	<th colspan='2'>Comisión</th>
	<th>Semana</th>
	<th>Comisión</th>
	<th colspan='2'>Screenshot</th>
</tr>
<tr>
	<td>Venta</td>
	<td> 	
		 <?if($url):?>
			<p><?=$url?> </p> 
			<input  name='url' type='hidden' value='<?=$url?>' /> 
			<input  name='asesor' type='hidden' value='<?=$url?>' />
		<?else:?>	
			<select name='asesor'  <?=$disabled?> ><?options($a_asesor,$asesor)?></select>
		<?endif;?>

	</td>
	<td>
		<input type='number' name='semana' value='<?=$semana?>'  <?=$disabled?>/>
	</td>
	<td>
		<input type='number' name='gnas' value='<?=$row->gnas?>' <?=$disabled?> />

	</td>
	<td>
		<input type='hidden' value='' name='screenshot' id='screenshot' <?=$disabled?>/>
		<img id='img' style='width:20px;height:20px' src=''>
	</td>
	<td>
		 <input name="img" type="file"  style='width:90px;'  /> 
	</td>
	

	
</tr>
<tr>
	<td>Influenser</td> 
	<td> 
		<select name='influencer' <?=$disabled?>><?options($a_influencer,$influencer)?></select>
	</td>
	<td>
		<input type='number' name='semana_influencer' value='<?=$row->semana_influencer?>' <?=$disabled?>/>
	</td>
	<td>
		<input type='number' name='gnas_influencer' value='<?=$row->gnas_influencer?>' <?=$disabled?>/>

	</td>
	<td>
	<!--
		<input type='hidden' value='' name='screenshot2' id='screenshot2' <?=$disabled?>/>
		<img id='img2' style='width:150px;height:100px' src=''>
	-->
	</td>
	<td>
		<!-- 
			<input name="img2" type="file" />  
		-->
		</td>

</tr>


</table>
	<div  class=" no_imp">
	<br	>
		<? if($admin_name=='Manuel'&&$mov>0): ?>

		<br><br>
		PAGADA <input type="checkbox" name="pagada" value="<?=$pag?>" <? if($pag==1) echo 'checked  disabled'; ?>  /> <br>
		PAGAR TODA LA SEMANA  <input type="checkbox" name="pag_sem" value="" /> 
		<? endif; ?>
		<br><br>
	


</div>
<? endif; ?>

	<input  class="no_imp" type='submit'  style='cursor:pointer;'   value='<?=$ver[$status]['a']?>'>

<? if($status!='new'): ?>
<input type='hidden' value='<?=$id?>' name='id' id='id'/> 
</form>
<br/>
</div>
<br>

<a target='_blank' href='img/ventas/<?=$id?>.jpg'><img class='screenshot no_imp' onerror="this.remove();" src="img/ventas/<?=$id?>.jpg"/>
<a target='_blank' href='img/ventas/<?=$id?>.png'><img class='screenshot no_imp' onerror="this.remove();" src="img/ventas/<?=$id?>.png"/></a>

 <? endif; ?>

<!-- Parte de subir archivos -->

<? if($admin_name=='Manuel'):?>
	<br><br>
	<form method="post" action='pay_functions.php?action=delete' class='no_imp'>
		<input type='hidden' value='<?=$id?>' name='id' id='id'/> 
		<h3>Eliminar movimiento</h3>
		<input type='submit'  value='Delete'>
		<br>
	</form>
<? endif;

//if($mov!=1&&$admin_name=='Manuel'&&$status!='new')
//	include("facturas.php");
if($mov>0): 
?>
	<div id='pdf' class='no_imp'>
		<?
		if(isset($id) && $id>0){
			$pdf="pdf/$id.pdf";
			if(file_exists($pdf)){?>
			    <embed src="<?=$pdf?>" type="application/pdf" width="800" height="600"></embed>
			<?}?>
			<form method="post"  enctype="multipart/form-data"  action="pay_functions.php?action=pdf" >
				<input type="hidden" id='pdf_id' name='pdf_id' value="<?=$id?>"/>
			  	<input type="file" name="archivo" id='inputfile' accept="application/pdf">
			  	<input type="submit" id='btn_enviar' value='Subir archivo'>
			</form>
		<?}?>
	</div> 
<? endif; ?>
<?if($rmail!=''&&$clase==1):?>
	<h3 class="no_imp"><a target='_blank' href="/epco/acciones.php?q=from_ventas&mailuser=<?=$rmail?>&ref=<?=$ref?>" scrolling='no' width='900' height='900' frameborder='0'>Ver Usuario en Ventas</a></h3>
<?endif;?>
</center>		
<?=$style?>
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
<script src="pasteimage.js"></script>
<script>


	function paste(src) {
		var sourceSplit = src.split("base64,");
		var sourceString = sourceSplit[1];
		sendBlob(src,dataURItoBlob(src));
	}
	
	$(function() {
		$.pasteimage(paste);
	});
	
	//convierte el string de la imagen en un archivo
	function dataURItoBlob(dataURI) {
		var byteString;
		if (dataURI.split(',')[0].indexOf('base64') >= 0)
			byteString = atob(dataURI.split(',')[1]);
		else
			byteString = unescape(dataURI.split(',')[1]);
		var mimeString = dataURI.split(',')[0].split(':')[1].split(';')[0];
		var ab = new ArrayBuffer(byteString.length);
		var ia = new Uint8Array(ab);
		for (var i = 0; i < byteString.length; i++) {
			ia[i] = byteString.charCodeAt(i);
		}
		var dataView = new DataView(ab);
		var blob = new Blob([dataView], {
				type : mimeString
			});
		return blob;
	}
	
	//enviamos el screenshot por post
	function sendBlob(src,blob){ 
		var formData = new FormData();
		formData.append('filename', '306');
		formData.append('filetype', 'image/png');
		formData.append('file', blob);
		formData.append('id', $('input#id').val());
		var a = 'pay_functions.php?action=blob';
		$.ajax({
			url : a,
			type : 'POST',
			data : formData,
			processData : false,
			contentType : false,
			success : function (resp) {
				console.log(resp);
				if(resp){
					$('input#screenshot').val('1');	
					$("#img").attr("src", src);
				}	
			}
		}); 
	}
	
	
$(document).ready(function(){
	var mov="<?echo $mov?>";
	console.log('Movimiento: '+mov);
	$('input#name').change(function(){
	// MARIO PUEDES CONTINUAR AQUÍ
	if(mov > 0)
		return;
	var prov=provedores();
	//console.log(prov);
	var name=$('input#name').val().toUpperCase();
	for(i=0;i < prov.length;i++)
	{
		var name_prov = prov[i][0].toUpperCase();
		if(name_prov.indexOf(name)> -1 && name!=''){
			var iva=0;
			$('input#name').val(prov[i][0]);
			$('input#pr').val(prov[i][1]);
			$('input#rfc').val(prov[i][2]);
			if(prov[i][3]==16)
				iva=$('input#iva').attr('placeholder');
			$('input#iva').val(iva);
			$('select#clase').val(prov[i][4]);
			return;
		}
	}
	});

	$('select#ivacal').change(function(){
		$('input#iva').val(this.value);
	});


	if( $('input#ad').val()=='' )
		$('div#promoventas').fadeIn();

	$(".promo").click(function(){
		var id=$(this).attr('id');
		$('input#ad').val(id);
		$('div#promoventas').fadeOut();
	});
	$('input#ad').change(function() {
		if($(this).val()=='')
			$('div#promoventas').fadeIn();
	});
	datalist();
});
function datalist(){
	var mov="<?echo $mov?>";
	if(mov > 0)
		return;
	console.log('entro a crear el datalist');
	var prov=provedores();
	var datalist='<datalist id="provedores_list">"';
	for(i=0;i < prov.length;i++)
	{
		var name_prov = prov[i][0];
		datalist+='<option value="'+name_prov+'">';
	}
	datalist+='</datalist>';
	$('#campo_nombre').append(datalist);
	$('input#name').attr('list','provedores_list');
}
function provedores()
{
	var provedores=[
		//Publicidad
		['Facebook','Publicidad','INTERNACIONAL',0,114],
		['Google México','Anuncions de Google','GOM0809114P5',0,114],
		//IMPUESTOS
		['IMSS','','IMSS',0,110],
		['INS','','ISN',0,110],
		['HACIENDA','','HACIENDA',0,110],
		// Software, tecnologia   
		['Google MontainView','G Suite Business','INTERNACIONAL',0,118],
		['Depositphots','','INTERNACIONAL',0,118],
		['Monday.com','','INTERNACIONAL',0,118],
		['APPLE OPERATIONS MEXICO','','AOM920820BEA',16,118],
		['HOSTDIME.COM.MX','','HOS061212KZ1',16,118],
		// Operativos y de oficina
		['Pak Aguascalientes','Envios: ','PAG060726UFA',16,119],
		['Uline',' ','USS000718PA0',16,119],
		['HOME DEPOT',' ','HDM00101',16,119],
		['MOISES RODRIGUEZ SANTILLAN','','ROSM4206012C6',16,119],
		['DON PULCRO S.A. DE C.V.','','DPU991209HW4',16,119],
		
		['Radiomóvil Dipsa','','RDI841003QJ4',16,119],
		['Telmex','','TME840315KT6',16,119],
		['Axtel','','FME1712225M6',16,119],
		['Servicio Petrojuelos','Gasolina','SPE021014Q30',16,115],
		//  Varios sin IVA
		['GREENPEACE MEXICO','','GME920514V69',0,106],
		['IPC','','IPC120416LU3',0,106],
		['Banorte','Hipoteca casa','IPC120416LU3',0,106],
		// Personal
		['MONICA ARRIAGA ACOSTA','','AIAM7804162D3',0,0117],
		['Leslie Rivero','','SUELDO',0,117],
		['Lucero Muñoz','','SUELDO',0,117],
		['Marcos Guerrero','','SUELDO',0,117],
		['David Macias','','SUELDO',0,117],
		['Mario Herrada','','SUELDO',0,117]
	];
	return provedores	;
}
</script>