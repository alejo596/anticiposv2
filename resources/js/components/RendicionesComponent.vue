<template>
	<div>
		<input type="" name="" v-model="csrf">
		<div class="card mt-3 ">
			<div class="card-header text-white" style="background-color: #005EAD !important;"> 
				<i class="far fa-id-card" style="font-size: 15px;"></i> Listar Anticipos
			</div>  
			<div class="card-body ">

				<v-client-table :columns="columns_anticipos" v-model="data_anticipos" :options="options_anticipos">	
					<div slot="monto" slot-scope="props">
						{{formatPrice(props.row.monto)}}

					</div>	
					<div slot="ultimaren" slot-scope="props"> 
						<select class="form-control" v-model="seleculti">
							<option value="1">SI</option>
							<option value="2">NO</option>
						</select>

					</div>	
					<div slot="revisar" slot-scope="props" >
						
						<button class="btn btn-warning btn-sm"  v-if="props.row.revision == 0" @click="RevisarAnticipo(props.row.id)">Revisar</button>
						<label v-if="props.row.revision == 1"> Revisado </label>
					</div>	

					<div slot="acciones" slot-scope="props" class="container" >


						<div class="row">


							<div class="col-6" >
								<button  class="btn btn-primary btn-sm" @click="rendir(props.row.id,props.row.monto,props.row.cc_id,props.row.cc_nombre)" :disabled="props.row.estado == 11"> Rendir</button>

							</div>
							<div class="col-6">												

								<!--<img  @click="verRendicionfinalizado(props.row.id)" :src="'../img/history.png'" width="80" height="60">-->
							</div>

						</div>

					</div>

					<div slot="enviar" slot-scope="props" >

						<button  type="button" class="btn btn-success btn-sm "  v-show="botonenviar" @click="enviarRendicioncomprmiso(props.row.id,props.row.monto,props.row.cc_id,props.row.run,props.row.nombre,props.row.id_solicitud,props.row.id_proveedor)" :disabled="props.row.estado == 11">Enviar</button>
						<button  type="button" class="btn btn-success btn-sm " v-show="botonenviar2" @click="enviarRendicionsinautorizar()" :disabled="props.row.estado == 11">Enviar</button>
						
					</div>


					<div slot="asignar" slot-scope="props" >
						<button class="btn btn-info btn-sm " @click="asignar(props.row.id,props.row.fiador_id)" v-show="vistaboton" :disabled="props.row.estado == 11">Asignar</button>
						<button class="btn btn-warning btn-sm" v-show="vistaboton_para_revisar" @click="revisarrendiciones(props.row.id,props.row.monto,props.row.cc_nombre)">Autorizar</button>
						
					</div>
					<div slot="ultima" slot-scope="props">

						<toggle-button @change="onChangeEventHandler(props.row.id,$event)" :value="(props.row.ultima_rendicion == 0 ? false: true)" :labels="{checked: 'SI', unchecked: 'NO'}" :color="{checked: '#38c172', unchecked: '#FF0000', disabled: '#CCCCCC'}"    />
						
					</div>
					

					<div slot="enviada" slot-scope="props" >

						<img v-if="props.row.estado == 11"  :src="'assets/img/enviado.png'" width="50" height="50">
					</div>
					<div slot="historial" slot-scope="props" >
						<img v-if="props.row.estado == 11"  @click="verRendicionfinalizado(props.row.id)" :src="'assets/img/history.png'" width="80" height="60">-
					</div>


				</v-client-table>



			</div>
		</div>
		<!-- Modal -->
		<div class="modal fade " tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="form_rendicion" aria-hidden="true" style="overflow-y: scroll !important;">
			<div class="modal-dialog modal-xl" style="max-width: 1500px !important;">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Formulario de Rendición  Anticipo N° {{titulomodal}}   Centro de Costo: {{centromodal}}</h5> <label class="text-rigth offset-3 border border-success rounded">Monto a Rendir: $ {{formatPrice(monto_total)}}</label>
						<label class="border border-danger rounded">Monto Rendido: ${{formatPrice(monto_total_rendiciones)}}</label>
						<button type="button" class="close btn btn-danger" data-dismiss="modal" aria-label="Close">
							<input type="hidden" name="" v-model="titulomodal">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					{{nombre_sigfe}}
					{{cuenta_sigfe}}
					{{sub_item_sigfe}}
					{{sigfe_item}}
					<div class="modal-body">
						<div class="row mt-2">

							<div class="col-2">							
								<div class="input-group mb-4">
									<div class="input-group-prepend">
										<label class="input-group-text" for="inputGroupSelect01">Tipo de Doc.</label>
									</div>
									<select class="custom-select form-control"  v-model="tipo_documento" @change="cambiodetipodoc($event)" style="font-size: 12px">

										<option value="1"  style="font-size: 12px">BOLETA </option>
										<option value="2" style="font-size: 12px">DEPOSITO</option>


									</select>
								</div>

							</div>
							<div class="col-4">

								<label class="sr-only" for="inlineFormInputGroup">Buscar Productos</label>
								<div class="input-group mb-2">
									<div class="input-group-prepend">
										<div class="input-group-text">Productos</div>
									</div>
									<input type="text" oncopy="return false" onpaste="return false" placeholder="Buscar Producto"  :ref="'nombre_producto'" v-model="search_producto" @blur="toggle_producto = false" @focus="toggle_producto = true" class="form-control" id="inlineFormInputGroup" :readonly="bloquearinput" autocomplete="off">

								</div>

								<div class="results_producto" v-if="toggle_producto " style="
								z-index: 1;
								position: absolute;
								background-color: #ffff;
								width: 73%;
								text-align: right;							     
								" >






								<div class="result_producto" v-for="book_producto in newBooks_producto2" >
									<span @click="selectResult_producto(book_producto.codigo,book_producto.nombre,book_producto.nombre_sigfe,book_producto.cuenta_sigfe,book_producto.sub_item_sigfe,book_producto.sigfe_item)" class="elecciondeproducto" @mousedown.prevent>
										{{ book_producto.nombre}}
									</span>
								</div>
							</div>	
							<input type="hidden" name="" v-model="id_producto">			

						</div>


						<div class="col-2">

							<label class="sr-only" for="inlineFormInputGroup">Username</label>
							<div class="input-group mb-2">
								<div class="input-group-prepend">
									<div class="input-group-text">Cantidad</div>
								</div>
								<input type="number" class="form-control" id="inlineFormInputGroup" placeholder="Cantidad" v-model="cantidad_productos" @change="format24($event)">
							</div>



						</div>


						<div class="col-2">						
							<label class="sr-only" for="inlineFormInputGroup">Username</label>
							<div class="input-group mb-2">
								<div class="input-group-prepend">
									<div class="input-group-text">Valor Unit.</div>
								</div>
								<input readonly="readonly"  type="number" class="form-control" id="inlineFormInputGroup" placeholder="unit." v-model="cantidad_divisora">						
							</div>

						</div>

						<div class="col-2">						
							<label class="sr-only" for="inlineFormInputGroup">Username</label>
							<div class="input-group mb-2">
								<div class="input-group-prepend">
									<div class="input-group-text">Monto</div>
								</div>
								<input type="number" class="form-control" id="inlineFormInputGroup" placeholder="Monto" v-model="monto_productos"  @change="format23($event)">
							</div>



						</div>

					</div>
					<div class="row mt-2">
						<div class="col-6">

							<label class="sr-only" for="inlineFormInputGroup">Username</label>
							<div class="input-group mb-2">
								<div class="input-group-prepend">
									<div class="input-group-text">Descripcion Compra:</div>
								</div>
								<input type="text" class="form-control" id="inlineFormInputGroup" placeholder="Descripcion" v-model="descripcion_docu">
							</div>

						</div>
						<div class="col-2">

							<label class="sr-only" for="inlineFormInputGroup">Username</label>
							<div class="input-group mb-2">
								<div class="input-group-prepend">
									<div class="input-group-text">N° Doc.  </div>
								</div>
								<input type="number" class="form-control" id="inlineFormInputGroup" placeholder="Numero" v-model="numero_docu">
							</div>

						</div>
						<div class="col-4">

							<label class="sr-only" for="inlineFormInputGroup">Username</label>
							<div class="input-group mb-2">
								<div class="input-group-prepend">
									<div class="input-group-text">RUT Proveedor</div>
								</div>

								<input type="text" oncopy="return false" onpaste="return false" placeholder=" Ej:(11111111-1)" v-model="search_proveedor" @blur="toggle_proveedor = false" @focus="toggle_proveedor = true" class="form-control" id="inlineFormInputGroup" v-on:keyup.enter="enter_search_proveedor" autocomplete="off" >
							</div>
							<div class="results_proveedor offset-4" v-if="toggle_proveedor" style="
							z-index: 1;
							position: absolute;
							background-color: #ffff;
							width: 60%;							
							float: right;
							">

							<div class="result_producto border border-success rounded" v-for="book_producto in newBooks_proveedor2" >
								<div class="elegirproveedor" @mousedown.prevent  @click="selectResult_proveedor(book_producto.id,book_producto.nombre,book_producto.rut,book_producto.apellido_paterno,book_producto.apellido_materno,book_producto.tipo_de_empresa,book_producto.razon_social)" >
									<span class="offset-5 ">
										{{ book_producto.nombre}} {{ book_producto.razon_social}} {{ book_producto.apellido_paterno}} {{ book_producto.apellido_materno}}
									</span>
								</div>
							</div>
							<input type="hidden" name="" v-model="id_proveedor">

						</div>				



					</div> 
					


				</div>
				<div class="row mt-1">
					<div class="col-12">

						<label class="sr-only" for="inlineFormInputGroup">Username</label>
						<div class="input-group mb-2">
							<div class="input-group-prepend">
								<div class="input-group-text">Nombre Proveedor </div>
							</div>

							<input type="text" class="form-control" id="inlineFormInputGroup" placeholder="Nombre Proveedor" v-model="nombre_proveedor">
						</div>
					</div>

					
				</div>
				<div class="row mt-2">	

					<div class="col-4">

						<label class="sr-only" for="inlineFormInputGroup">Username</label>
						<div class="input-group mb-2">
							<div class="input-group-prepend">
								<div class="input-group-text">Apellido Paterno</div>

							</div>

							<input type="text" class="form-control" id="inlineFormInputGroup" placeholder="Apellido Paterno Proveedor" v-model="apellido_pat_proveedor" :disabled="readonlyr_social">
						</div>
					</div> 	

					<div class="col-4">

						<label class="sr-only" for="inlineFormInputGroup">Username</label>
						<div class="input-group mb-2">
							<div class="input-group-prepend">
								<div class="input-group-text">Apellido Materno</div>
							</div>

							<input type="text" class="form-control" id="inlineFormInputGroup" placeholder="Apellido Proveedor" v-model="apellido_mate_proveedor" :disabled="readonlyr_social">
						</div>
					</div> 	
					<div class="col-4">

						<label class="sr-only" for="inlineFormInputGroup">Username</label>
						<div class="input-group mb-2">
							<div class="input-group-prepend">
								<div class="input-group-text">Fecha Doc.</div>
							</div>

							<input type="date" class="form-control" id="inlineFormInputGroup" placeholder="Nombre Proveedor" v-model="fecha_doc">
						</div>
					</div> 	

				</div>
				<input type="hidden" name="" v-model="razonsocial">

				<div class="row mt-2">

					<div class="col-12">
						<div class="input-group mb-3 offset-5">
							<div class="input-group-prepend">
								<span class="input-group-text">Subir </span>
							</div>
							<div class="custom-file">
								<div class="text-bold-600 font-medium-2 btn btn-primary" @click="getFile()" >
									SUBIR DOCUMENTOS
								</div>
								<input name="MAX_FILE_SIZE" type="hidden" id="imageA"  value="3000000" />
								<div style='height: 0px;width: 0px; overflow:hidden;'><input name="imagen" type="file"  id="upfile" ref="file"  @change="sub($event)"/></div>


							</div>
						</div>

					</div>

				</div>
				<div class="row">
					<div class="col-12">

						<div v-for="(f,index) in files2" v-bind:key="f.id">

							<a data-fancybox="gallery" v-bind:href="file.thumb" v-if="file.thumb"><img   v-if="file.thumb" :src="file.thumb" width="40" height="20" /></a>
							<div class="row">								
								<div class="col-4 offset-2 text-right">{{f.name}}</div>
								<div class="col-2"><a href="#"  @click="vermodalimagen()"><i class="far fa-eye"></i></a><a href="#" @click="eliminar_imagen(index)"><i class="far fa-times-circle"></i></a> </div>
								<div class="col-2"></div>
							</div>	
							

						</div>


					</div>
				</div>
			</div>

			<div class="modal fade" id="imagenentrada" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="staticBackdropLabel">Imagen</h5>
							<button type="button" class="btn-close" @click="cerramodalver()" aria-label="Close"></button>
						</div>
						<div class="modal-body">
							<div id="preview" class="offset-4"></div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" @click="cerramodalver()">Cerrar</button>

						</div>
					</div>
				</div>
			</div>

			<div class="modal-footer">
				<button type="button" :disabled="validated" class="btn btn-primary" @click="guardarrendicion()"><i class="far fa-save"></i>Guardar</button>
				<!-- <button type="button" :disabled="validarenviar" class="btn btn-success" @click="enviarrendicion(anticipo_n,total_monto,monto_red)"><i class="far fa-share-square"></i>Enviar</button> -->
				<button type="button" class="btn btn-secondary" data-dismiss="modal"
				>Cerrar</button>
			</div>
			<div class="row" v-if="textrevisar">
				<div class="col-12">
					<label style="font-size: 20px" class="offset-5 rounded-2  border border-success">Rendicion Revisada</label>

				</div>
				<div class="col-12 mt-2" v-if="botonabrirrendicion">
					<button class="btn btn-info offset-10" @click="abrirrendicion()">Abrir Rendicion</button>

				</div>
			</div>
			<div class="alert alert-success" role="alert">
				Nota : Para la busqueda del proveedor debe  ingresar el run en campo <img :src="'assets/img/input_proveedor.png'"> y presionar enter 
			</div>
			<div class="alert alert-info" role="alert">
				Nota : Si  no le aparace un servcio que necesita , se debe ingresar "COMPRA DE SERVICIO (ESPECIALIZADO)" PPT0009

			</div>
			<v-client-table :columns="columns_anticipos_2" v-model="data_anticipos_2" :options="options_anticipos_2">				
				<div slot="monto" slot-scope="props">
					{{formatPrice(props.row.monto)}}

				</div>
				<div slot="url" slot-scope="props">
					<a  :href="'../storage/app/'+props.row.url" target="_blank"><i class="far fa-images offset-5"></i></a>

				</div>
				

				<div slot="editar" slot-scope="props">


					<div >

						<button class="btn btn-primary" :disabled="validated" @click="modaleditar(props.row.id,props.row,props.row.producto_id,props.row.produNombre,props.row.id_adjuntos,props.row.proveedores_id,props.row.anticipo_id)"> Editar</button>
					</div>
				</div>

				<div slot="eliminar" slot-scope="props">
					<div >
						<button class="btn btn-danger" :disabled="validated" @click="eliminaridrndicion(props.row.id,props.row.anticipo_id)"> Eliminar</button>

					</div>
				</div>

			</v-client-table>

			

		</div>
	</div>
	<!-- Modal -->

</div>

<div class="modal" tabindex="-1" id="rendicionesporid">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">{{titulodetodas}}   </h5>&nbsp;&nbsp;&nbsp;&nbsp;<div><h5> Monto Total: {{formatPrice(monto_total_por_fondo)}}</h5></div>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<v-client-table :columns="columns_anticipos_23" v-model="data_anticipos_23" :options="options_anticipos_23">				
					<div slot="monto" slot-scope="props">
						{{formatPrice(props.row.monto)}}

					</div>
					<div slot="url" slot-scope="props">
						<a :href="'../storage/app/'+props.row.url" target="_blank"><i class="far fa-images offset-5"></i></a>

					</div>
				</v-client-table>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>

			</div>
		</div>
	</div>
</div>
<div class="modal" tabindex="-1" id="modal_buscador">
	<div class="modal-dialog modal-dialog-centered modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Buscar Funcionario Para que Revise su Rendición</h5><div class="alert alert-info" role="alert"><label>Funcionario Asignado:  {{funcionarioelegido}}</label></div>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-6 mt-3">
						<input type="" name="" class="form-control" v-model="nombre_funcionario">
						<ul class="list-group" v-show="vista_modal_buscar">
							<li class="list-group-item" v-for="p in person" style="cursor: pointer;" @click="elegirfuncionario(p.per_rut,p.per_nombre)">{{p.per_nombre}}</li>
							
						</ul>
						
					</div>
					<div class="col-6">
						<button class="btn btn-primary" @click="funcionario_firma">Buscar</button>
					</div>
					
				</div>
				<div class="row">
					<div class="col-12">
						<label>Funcionario Elegido: {{mensaje}}</label>
						
					</div>
					
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
				<button type="button" class="btn btn-primary" @click="guardarRevision">Guardar Funcionario</button>
			</div>
		</div>
	</div>
</div>
<div class="modal" tabindex="-1" role="dialog" id="revisar_rendicion">
	<div class="modal-dialog  modal-dialog-centered " role="document" style="max-width:1450px !important;">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">{{titulo_modal_rendicion}}</h5> 
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<label>MONTO RENDICIONES:  ${{formatPrice(monto_total_rendicionesv)}}</label>
				<v-client-table :columns="columns_rendiciones" v-model="data_rendiciones" :options="options_Rendiciones">	
					<div slot="url" slot-scope="props">
						<a :href="'../storage/app/'+props.row.url" target="_blank"><img :src="'assets/img/pdf.png'" width="50" height="50"></a>
						
					</div>
					<div slot="monto" slot-scope="props">
						${{ formatPrice(props.row.monto)}}
						
					</div>
				</v-client-table>

				
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" @click="autorizar">Autorizar</button>
				<button type="button" class="btn btn-danger">Rechazar</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>

<BlockUI :message="msg"  v-if="bloqueo">
	<img :src="'assets/img/745.gif'">

</BlockUI>
<div class="modal fade" id="modaleditar2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content rounded-1">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">{{tituloeditar}}</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-3">
						<label>Numero de Doc.</label>
						
					</div>
					<div class="col-3">
						<input type="" name="" v-model="arramodaleditar.numero_doc" class="form-control">
						
					</div>
					
					<div class="col-3">
						<label>Monto</label>
						
					</div>
					<div class="col-3">
						<input type="" name="" v-model="arramodaleditar.monto" class="form-control">
						
					</div>
					
				</div>
				<div class="row mt-1">
					<div class="col-3">
						<label>Cantidad.</label>
						
					</div>
					<div class="col-3">
						<input type="" name="" v-model="arramodaleditar.cantidad_producto" class="form-control">
						
					</div>
					
					<div class="col-3">
						<label>Productos</label>
						
					</div>
					<div class="col-3">
						<input type="" name="" v-model="modalproducto" class="form-control" @keyup="buscarproductosmodal(modalproducto)">
						<div style="z-index: 1;background-color:#ffff;width: 100%;position: absolute;" v-show="productos_hide">
							<div v-for="p_modal in  productos_modal">
								<span class="elecciondeproducto" @click="selccionmodalproductod(p_modal.produCodInt,p_modal.produNombre)">{{p_modal.produNombre}}</span>
								
							</div>
							
						</div>
						<input type="hidden" name="" v-model="productos_modal_id">
						
					</div>
					
				</div>
				
				<div class="row mt-2">
					<div class="col-12 text-center" v-show="botonsubirimagenmodal2">
						<a :href="'../storage/app/'+arramodaleditar.url" target="_blank"><img :src="'assets/img/pdf.png'" width="60" height="50"> </a>
						<a href="#" @click="eliminarelmento(arramodaleditar.id_adjuntos)"><i class="fa fa-trash"></i></a>
						
					</div>
					<div class="text-center col-12" v-show="botonsubirimagenmodal">
						<div class="input-group-prepend">
							<span class="input-group-text">Subir </span>
						</div>
						<div class="custom-file">
							<div class="text-bold-600 font-medium-2 btn btn-primary" @click="getFilemodal()" >
								SUBIR DOCUMENTOS
							</div>
							<input name="MAX_FILE_SIZE" type="hidden" id="imageA"  value="3000000" />
							<div style='height: 0px;width: 0px; overflow:hidden;'><input name="imagen" type="file"  id="upfilemodal" ref="filemodal"  @change="submodal($event)"/></div>

							<div >
								{{archivomodal.name}}
								
							</div>
							

							
						</div>
					</div>
					
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
				<button type="button" class="btn btn-primary" @click="guardarmodaleditar(productos_modal_id,modalproducto,arramodaleditar.cantidad_producto,arramodaleditar.numero_doc,arramodaleditar.monto)">Guardar</button>
			</div>
		</div>
	</div>
</div>


</div>


</template>
<style type="text/css">
	.list-group{
		max-height: 300px;
		margin-bottom: 10px;
		overflow:scroll;
		-webkit-overflow-scrolling: touch;
	}
	.elecciondeproducto:hover{
		cursor: pointer;
		color:#f96332;

	}
	.elegirproveedor:hover{
		cursor: pointer;
		color:#f96332;
	}
</style>
<script >

	export default {
		props: ['id_session','name'],

		data(){

			return {
				nombre_sigfe:'',
				cuenta_sigfe:'',
				sub_item_sigfe:'',
				sigfe_item:'',
				csrf:document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
				modal_proveedore:'',
				modal_anticipo:'',
				flag_adjuntos:'',
				id_modal_ren:'',
				nombre_ad_modal:'',
				botonsubirimagenmodal2:true,
				botonsubirimagenmodal:false,
				productos_hide:false,
				productos_modal_id:'',
				productos_modal:[],
				modalproducto:'',
				arramodaleditar:[],
				tituloeditar:'',
				nuevo_cpp:'',
				descripcion_docu:'Compra de Productos',
				fondo_id_revision:'',
				botonenviar:true,
				botonenviar2:false,
				botonenviar3:false,
				id_p_a:'',
				monto_total_rendicionesv:0,
				columns_rendiciones: ['id', 'fecha_doc', 'nombre','numero_doc','monto','nombre_estado','produNombre','url'],
				data_rendiciones:[],
				options_Rendiciones: {

					headings: {
						id: 'Id Rendicion',
						fecha_doc: 'Fecha',
						nombre: 'Tipo de Doc.',
						numero_doc: 'Numero de Doc.',
						monto:'Monto',
						nombre_estado:'Estado', 
						produNombre:'Producto',					
						url:'Ver Documento',         



					},
					editableColumns:['id'],
					sortable: ['id'],
					filterable: ['id']
				},
				titulo_modal_rendicion:'',
				vistaboton:'',
				vistaboton_para_revisar:'',
				funcionarioelegido:'No existe Funcionario',
				fiador_tercera_firma:'',
				vista_modal_buscar:false,
				run_funcionario:'',
				person:[],
				mensaje:'',
				nombre_funcionario:'',
				monto_total_por_fondo:0,
				columns_anticipos_23: ['id', 'fecha_doc', 'nombre','numero_doc','monto','nombre_estado','produNombre','url'],
				data_anticipos_23:[],
				options_anticipos_23: {

					headings: {
						id: 'Id Rendicion',
						fecha_doc: 'Fecha',
						nombre: 'Tipo de Doc.',
						numero_doc: 'Numero de Doc.',
						monto:'Monto',
						nombre_estado:'Estado', 
						produNombre:'Producto',					
						url:'Ver Documento',         



					},
					editableColumns:['id'],
					sortable: ['id'],
					filterable: ['id']
				},
				titulodetodas:'',
				inputbloqueo:0,
				id_pro_fondo:'',
				nombre_adjunto:'',
				id_adjunto:'',	
				url_adjuntos:'',			
				rendiciones_cpp:[],
				monto_descuento:0,
				monto_mas_monto_rend:0,
				monto_total_envio:0,
				monto_total_rendiciones:0,
				centro_id_modal:'',
				centromodal:'',
				archivo:[],
				archivomodal:[],
				newBooks_proveedor2:[],
				id_proveedor:'',
				newBooks_producto2:[],
				verresultado:false,
				textrevisar:false,
				validated:false,
				files2:[],
				razonsocial:'',
				id_producto:null,
				bloquearinput:false,
				monto_total:'',
				titulomodal:'',
				msg: 'Espere un Momento...',
				bloqueo:false,
				columns_anticipos_2: ['id', 'created_at', 'nombre','numero_doc','monto','cantidad_producto','nombre_estado','produNombre','cpp_num','url','editar','eliminar','enviar'],
				data_anticipos_2:[],
				options_anticipos_2: {
					rowClassCallback: function(row) { 
						if(row.id_max_saldo ==0){
							return 'colornaraja text-dark'
						}

					},
					headings: {
						id: 'Id Rendicion',
						created_at: 'Fecha',
						nombre: 'Tipo de Doc.',
						numero_doc: 'Numero de Doc.',
						monto:'Monto',
						cantidad_producto:'Cantidad',
						nombre_estado:'Estado', 
						produNombre:'Producto',
						cpp_num:'CPP',						
						url:'Ver Documento', 					       
						editar:'Editar',
						enviar:'Enviar',
						elinimar:'Eliminar',
					},
					editableColumns:['id'],
					sortable: ['id'],
					filterable: ['id'],texts: {
						count: "Demostración {from} to {to} of {count} registros|{count} registros|un registro",
						first: 'First',
						last: 'Last',
						filter: "Filtros:",
						filterPlaceholder: "Buscar",
						limit: "Records:",
						page: "Paginas:",
						noResults: "No existen productos agregados",
						filterBy: "Filter by {column}",
						loading: 'Loading...',
						defaultOption: 'Select {column}',
						columns: 'Columnas'
					},
				},
				fecha_doc:'',
				apellido_mate_proveedor:'',
				readonlyr_social:false,
				apellido_pat_proveedor:'',
				nombre_proveedor:'',
				search_proveedor: '',
				toggle_proveedor: false,
				newBooks_s: [],
				id_personas_s:'',
				search_s: '',
				toggle_s: false,
				books_s: [
					{name: 'Liste des livres de Chair de poule'},
					{name: 'Les Cent Meilleurs Romans policiers de tous les temps'},
					{name: 'Liste des livres publiés par Champ libre'}
					],
				numero_docu:'',
				monto_productos:'',
				cantidad_divisora:'',
				cantidad_productos:'',
				tipo_documento:'',
				search_producto: '',
				toggle_producto: false,
				books_producto: [
					{name: 'Liste des livres de Chair de poule'},
					{name: 'Les Cent Meilleurs Romans policiers de tous les temps'},
					{name: 'Liste des livres publiés par Champ libre'}
					],
				rendiciones:[],
				columns_anticipos: ['id', 'numero','monto','created_at','nombre','estado_anticipo','cc_nombre','motivo_rechazo','revisar','acciones','asignar','enviar','ultima','historial','enviada'],
				data_anticipos:[],
				options_anticipos: {

					headings: {
						id: 'id',
						numero: 'Numero',            
						monto: 'Monto',
						created_at:'Fecha',
						nombre:'Nombre Fiador',
						estado_anticipo: 'Estado',
						motivo_rechazo:'Observacion',
						cc_nombre:'Centro de Costo',           
						acciones:'Rendir',
						asignar:'Revisor',
						revisar:'Revisar',
						historial:'Historial',
						enviar:'Enviar',
						enviada:'Enviada',
						ultima:'Ultima Rend.'

					},
					editableColumns:['id'],
					sortable: ['id'],
					filterable: ['id'],
					descOrderColumns:['id'],
					texts: {
						count: "Demostración {from} to {to} of {count} registros|{count} registros|un registro",
						first: 'First',
						last: 'Last',
						filter: "Filtros:",
						filterPlaceholder: "Buscar",
						limit: "Records:",
						page: "Paginas:",
						noResults: "No existen anticipos agregados",
						filterBy: "Filter by {column}",
						loading: 'Loading...',
						defaultOption: 'Select {column}',
						columns: 'Columnas'
					},

				},



			}





		},
		created(){
			this.getAnticipos();

		},
		mounted() {

			

			axios.get('persona_anticipo/'+this.id_session).then(resp=>{
				if(resp.data.length != 0)
				{
					if(resp.data[0].estado == 0){
						this.vistaboton=false;
						this.vistaboton_para_revisar=true;
						this.id_p_a=resp.data[0].id;
						this.botonenviar=false;
						this.botonenviar2=true;

					}else{
						this.botonenviar='';				
						this.botonenviar2='';
						console.log('estoyaqui');
						this.botonenviar=true;				
						this.botonenviar2=false;
						this.vistaboton=true;
						this.vistaboton_para_revisar=false;
					}
					
				}else{
					this.botonenviar='';				
					this.botonenviar2='';
					console.log('estoyaqui');
					this.botonenviar=true;				
					this.botonenviar2=false;
					this.vistaboton=true;
					this.vistaboton_para_revisar=false;

				}


			});


		},
		watch: {

			search_proveedor(val)
			{
				console.log(val.includes('-'));
				
				if(val.includes('-') == true)
				{
					var largo=val.length;
					
				}
			},
			search_producto(val) 
			{
				console.log(val);
				this.newBooks_producto2 = []; 
				if(val.length > 3) { 

					axios.get('http://localhost/gestion_ordenes/public/crearproductos/'+val).then(response=>{
						this.newBooks_producto2 =response.data;


					}); 
				}

			}    


		},
		methods:{
			guarRendicion(id,nombre,cantidad,numero,monto,adjunto)
			{
				var url='rendiciones_fondo/'+this.id_modal_ren;
				var d={
					id:this.id_modal_ren,
					id_adjuntos:adjunto,
					numero_doc:numero,
					cantidad_producto:cantidad,
					producto_id:id,
					monto:monto,
					_method:'patch'
				}

				axios.post(url,d).then(response=>{
					$("#modaleditar2").modal('hide');
					this.bloqueo=false;
					this.getRendiciones(this.modal_anticipo);
					this.nombre_ad_modal='';
					this.archivomodal=[];

				});
			},
			guardarmodaleditar(id,nombre,cantidad,numero,monto)
			{ 
				this.bloqueo=true;

				
				var fecha = new Date();
				var hoy = fecha.getDate();
				var añoActual = fecha.getFullYear()
				var mesActual = fecha.getMonth() + 1; 
				var d=new FormData();
				d.append('file',this.archivomodal);
				d.append('year',añoActual);
				d.append('mes',mesActual);
				d.append('anticipo',this.modal_anticipo);
				d.append('id_proveedor',this.modal_proveedore);
				d.append('numero',numero);

				axios.post('adjunto',d).then(response=>{

					this.guarRendicion(id,nombre,cantidad,numero,monto,response.data);

				}).catch(err=>{
					this.bloqueo=false;
				});
				
				

			},
			eliminarelmento(id)
			{
				axios.post('adjunto/'+id,{_method:'delete'}).then(response=>{
					var url='rendiciones_fondo/'+this.id_modal_ren;
					var d={
						id:this.id_modal_ren,
						id_adjuntos:0,
						_method:'patch'
					}

					axios.post(url,d).then(response=>{

					});
					this.botonsubirimagenmodal=true;
					this.botonsubirimagenmodal2=false;

				});
			},
			selccionmodalproductod(id,nombre){
				this.modalproducto=nombre;
				this.productos_modal_id=id

				this.productos_hide=false;
			},
			buscarproductosmodal(id)
			{
				axios.get('productos_aba/'+id).then(response=>{
					this.productos_hide=true;
					this.productos_modal=response.data;
					
				});
			},
			modaleditar(id,array,producto_id,nombre,id_adjuntos,proveedores_id,anticipo_id)
			{
				this.archivomodal=[];
				this.flag_adjuntos='';
				this.flag_adjuntos=id_adjuntos;
				if(this.flag_adjuntos == 0){
					this.botonsubirimagenmodal=true;
					this.botonsubirimagenmodal2=false;
				}else{
					this.botonsubirimagenmodal=false;
					this.botonsubirimagenmodal2=true;
				}
				console.log(array);
				this.modal_proveedore=proveedores_id
				this.modal_anticipo=anticipo_id
				this.modalproducto=nombre;
				this.productos_modal_id=producto_id
				this.arramodaleditar=array;
				this.tituloeditar="Editar Rendicion N°"+id;
				this.id_modal_ren=id;
				$("#modaleditar2").modal();
			},
			onChangeEventHandler(id,event)
			{
				console.log(event.value);
				var url='fondo_fijo/'+id
				if(event.value == false){
					var d={
						id:id,
						ultima_rendicion:0,
						_method:'patch'
					}

					axios.post(url,d).then(response=>{
						this.getAnticipos();

					});

				}else{
					var d={
						id:id,
						ultima_rendicion:1,
						_method:'patch'
					}
					axios.post(url,d).then(response=>{
						this.dulcealert('Esta Realizando su Ultima Rendicion','success');
						this.getAnticipos();

					});
				}
			},
			enviarRendicionsinautorizar()
			{
				return this.dulcealert('Debe autorizar la rendicion para enviar','error');
			},
			autorizar()
			{

				Swal.fire({
					title: 'Desea Autorizar La rendición?',          
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Aceptar'
				}).then((result) => {
					if (result.isConfirmed) {
						this.bloqueo=true;
						var url='persona_anticipo/'+this.id_p_a;
						var d={
							id:this.id_p_a,
							estado:1,
							_method:'patch'
						}
						
						axios.post(url,d).then(response=>{
							this.bloqueo=false;
							this.botonenviar=true;
							this.botonenviar2=false;
							location.reload();

						});


					}

				});
				
			},
			revisarrendiciones(id,monto,centro)
			{
				this.titulo_modal_rendicion="Listado Rendicion Anticipo N°"+id+" Centro de Costo: "+centro+" Monto Anticipo: $"+this.formatPrice(monto);
				this.bloqueo=true;
				axios.get('rendiciones_fondo/'+id).then(response=>{
					this.monto_total_rendicionesv=0;
					for (var i = 0; i < response.data.length; i++) {
						this.monto_total_rendicionesv=this.monto_total_rendicionesv+response.data[i].monto;	
					}
					

					this.data_rendiciones=response.data;
					this.bloqueo=false;

				});
				$("#revisar_rendicion").modal();
			},
			guardarRevision()
			{
				this.bloqueo=true;
				axios.get('persona_anticipo/'+this.fondo_id_revision).then(resp=>{

					if(resp.data.length != 0){
						var d={
							id:resp.data[0].id,
							nombre:this.nombre_funcionario,
							run:this.run_funcionario,
							fiador:this.fiador_tercera_firma,
							estado:0,
							anticipo:this.fondo_id_revision,
							_method:'patch'
						}
						var url='persona_anticipo/'+resp.data[0].id;
						axios.post(url,d).then(response=>{
							this.dulcealert('Funcionario Guardado','success');
							$("#modal_buscador").modal('hide');
							this.limpiarFormulariorendicionmensaje();
							this.bloqueo=false;
						});
					}else{
						var d=new FormData();
						d.append('nombre',this.nombre_funcionario);
						d.append('run',this.run_funcionario);
						d.append('fiador',this.fiador_tercera_firma);
						d.append('estado',0);
						d.append('anticipo',this.fondo_id_revision);
						axios.post('persona_anticipo',d).then(response=>{

							this.dulcealert('Funcionario Guardado','success');
							this.limpiarFormulariorendicionmensaje();
							$("#modal_buscador").modal('hide');
							this.bloqueo=false;
						});
					}

					
				});

			},
			
			elegirfuncionario(id,nombre)
			{   this.vista_modal_buscar=false;
			this.mensaje=nombre;
			this.run_funcionario=id;
			this.nombre_funcionario=nombre;

		},
		funcionario_firma()
		{
			if(this.nombre_funcionario.length > 4){
				axios.get('persona/'+this.nombre_funcionario).then(response=>{
					this.vista_modal_buscar=true;
					this.person=response.data;

				});
			}

		},
		verRendicionfinalizado(id)
		{
			this.titulodetodas='Lista de todas las rendiciones anticipos N°'+id;
			this.monto_total_por_fondo=0;
			axios.get('rendiciones_fondo/'+id).then(response=>{
				this.data_anticipos_23=response.data;
				for (var i = 0; i < response.data.length; i++) {
					this.monto_total_por_fondo=this.monto_total_por_fondo+response.data[i].monto
				}

			});
			$("#rendicionesporid").modal();

		},
		asignar(id,fiador)
		{
			this.fiador_tercera_firma=fiador;
			axios.get('persona_anticipo/'+id).then(response=>{
				if(response.data.length == 0){

					$("#modal_buscador").modal();
				}else{
					if(response.data[0].estado == 1){

						return this.dulcealert('Ya se Asigno un Funcionario y se reviso','warning');

					}
					this.funcionarioelegido=response.data[0].nombre;
					$("#modal_buscador").modal();
				}


			});


		},
		enviarRendicion(id,monto,cc,run_fiador,nombre_fiador,id_solicitud,idprofia)
		{

			Swal.fire({
				title: 'No Olvide marcar si es su Ultima Rendición',          
				icon: 'warning',
				showCancelButton: true,					
				html:  "<img src='assets/img/checktoggle.png' style='width:150px;'>",
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Aceptar'
			}).then((result) => {
				if (result.isConfirmed) {

					this.bloqueo=true
					axios.get('rendiciones_fondo/'+id).then(response=>{

						this.rendiciones_cpp=response.data;
						this.monto_total_envio=0;
						this.monto_mas_monto_rend=monto;
						if(response.data.length === 0)
						{
							return this.dulcealert('No existen rendiciones');
							this.bloqueo=false
						}
						for (var i = 0; i < response.data.length; i++) 
						{
							this.monto_total_envio=this.monto_total_envio+response.data[i].monto;



						}	

						if(monto>this.monto_total_envio)
						{
							return this.dulcealert('La rendicion no puede menor al monto del anticipo','error');
						}	

						if(monto<this.monto_total_envio)
						{
							this.monto_descuento=this.monto_total_envio-monto;
							this.monto_mas_monto_rend=this.monto_total_envio-this.monto_descuento;
						}
						this.bloqueo=false;
						Swal.fire({
							title: 'Desea enviar la rendición por el monto de: $'+this.formatPrice(this.monto_total_envio),          
							icon: 'warning',
							showCancelButton: true,
							confirmButtonColor: '#3085d6',
							cancelButtonColor: '#d33',
							confirmButtonText: 'Aceptar'
						}).then((result) => {
							if (result.isConfirmed) {
								var rendic=new FormData();
								rendic.append('anticipo_id',id)
								rendic.append('estados',3)
								rendic.append('envio',1)

								axios.post('rendiciones_fondoupdate',rendic).then(responserendicion=>{

								}).catch(err=>{
									this.bloqueo=false;
                                                                 this.dulcealert('Error en servidor comuniquese con informatica  '+err,'error');  // NOTE - use "error.response.data` (not "error")

                                                             });
								this.bloqueo=true;
								var fecha = new Date();
								var hoy = fecha.getDate();
								var añoActual = fecha.getFullYear()
								var mesActual = fecha.getMonth() + 1; 
								var d=new FormData();
								d.append('monto',this.monto_total_envio);
								d.append('descuento',this.monto_descuento);
								d.append('cc',cc);
								d.append('fiador',run_fiador);
								d.append('tipo',5);
								d.append('estado',1);
								d.append('iva',1);
								d.append('observacion','creado por fondo fijo anticipo N°'+id);
								d.append('year',añoActual);
								d.append('nombre_fiador',nombre_fiador);
								d.append('solicitud',id_solicitud);
								axios.post('cpp',d).then(response1=>{
									this.nuevo_cpp=response1.data;
									for (let i = 0; i < this.rendiciones_cpp.length; i++) 
									{

										if(this.rendiciones_cpp[i].tipo_doc == 2)
										{
											var extension=this.rendiciones_cpp[i].url.split(".");
											var d={
												correo:'antoniovp18@gmail.com',
												text:'Hola',
												url:this.rendiciones_cpp[i].url,
												tipo:extension[1],
												subject:'Deposito',
												numero:this.rendiciones_cpp[i].anticipo_id,
												fecha:this.rendiciones_cpp[i].fecha_doc

											}
											axios.post('mail',d).then(response=>{

											});

										}
										if(this.rendiciones_cpp[i].tipo_doc != 2){
											var adjuntos=new FormData();
											adjuntos.append('url',this.rendiciones_cpp[i].url);
											adjuntos.append('nombre',this.rendiciones_cpp[i].nombre_archivo);
											adjuntos.append('id',this.rendiciones_cpp[i].id_adjuntos);
											adjuntos.append('adj_id_cpp',response1.data);
											axios.post('adjuntos_productos',adjuntos).then(responseproductos=>{
													// var ftp=new FormData();
													// ftp.append('url',this.rendiciones_cpp[i].url);
													// ftp.append('nombre_original',responseproductos.data);
													// axios.post('ftp',ftp).then(responseftp=>{

													// });
											});
											console.log('url',this.rendiciones_cpp[i].url);
											this.nombre_adjunto=this.rendiciones_cpp[i].nombre_archivo;
											this.id_adjunto=this.rendiciones_cpp[i].id_adjuntos;
											this.url_adjuntos=this.rendiciones_cpp[i].url;
											this.id_pro_fondo=this.rendiciones_cpp[i].id;
											var p=new FormData();
											p.append('nombre',this.rendiciones_cpp[i].produNombre)
											p.append('cantidad',this.rendiciones_cpp[i].cantidad_producto)
											p.append('precio',this.rendiciones_cpp[i].monto)
											p.append('id_aba',this.rendiciones_cpp[i].producto_id)
											p.append('cpp',response1.data)
											p.append('pro_total',this.rendiciones_cpp[i].monto)
											p.append('estado_pro',0)
											p.append('costo_unitario',this.rendiciones_cpp[i].monto)
											p.append('pro_cc',this.rendiciones_cpp[i].cc_id)
											p.append('pro_amio',añoActual)
											p.append('precio_unitario',this.rendiciones_cpp[i].monto)
											p.append('cantidad_unitario',this.rendiciones_cpp[i].cantidad_producto)
											p.append('url',this.rendiciones_cpp[i].url)
											p.append('id_rendiciones',this.rendiciones_cpp[i].id)
											axios.post('productos',p).then( respo=>{	

											});

										}

										}// finb deñ for
										var anti=new FormData();
										anti.append('cpp',this.nuevo_cpp);
										anti.append('anticipo',id);
										anti.append('usuario',this.id_session);

										axios.post('cpp_anticipos',anti).then(responseanticipos=>{
											var ins=this;
											var ur_rendi='rendiciones_fondo/'+ins.id_pro_fondo;
											var rendic={
												id:ins.id_pro_fondo,
												estados:3,
												_method:'patch'
											}
											axios.post(ur_rendi,rendic).then(responserendicion=>{
												var url_ant='fondo_fijo/'+id;
												var anti={
													id:id,
													estado:11,
													id_cpp:response1.data,
													_method:'patch'
												}
												axios.post(url_ant,anti).then(respanticipo=>{
													var firma=new FormData();
													firma.append('usuario','');
													firma.append('estado',0);
													firma.append('unidad',4);
													firma.append('id_anticipo',id);

													axios.post('firma_anticipo',firma).then(respofirma=>{

														this.bloqueo=false;
														this.dulcealert('Rendicion enviada','success');
														this.getAnticipos();
													});


												});

											});

										});




									});
							}

						});

});

}

});




},
RevisarAnticipo(id)
{
	if(this.rendiciones.length === 0){

		return this.dulcealert('Debe ingresar Rendiciones','error');

	}
	Swal.fire({
		title: 'Desea cambiar de estado a revisado?',          
		icon: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Aceptar'
	}).then((result) => {
		if (result.isConfirmed) {
			this.bloqueo=true;
			var d={
				id:id,
				revision:1,
				_method:'patch'
			}
			var url="fondo_fijo/"+id;
			axios.post(url,d).then(response=>{
				this.getAnticipos();
				this.bloqueo=false;

			});

		}

	});
},
format24(input)
{
	this.monto_productos='';
	this.cantidad_divisora='';
},
format23(input)
{

	if(this.tipo_documento == 1){

		if(this.monto_productos <=25000){


		}else{


			if(this.cantidad_productos > 1){
				this.cantidad_divisora=this.monto_productos/this.cantidad_productos;
				this.cantidad_divisora= Math.round(this.cantidad_divisora);

			}else if(this.cantidad_productos == 1){
				this.cantidad_divisora=this.monto_productos;

			}

                            }//fin del if de validacion menor a 20


                        }else if(this.tipo_d == 2){

                        }

                    },

                    dulcealert(text,icono)
                    {
                    	Swal.fire({
                    		icon: icono,
                    		title: 'Oops...',
                    		text: text,

                    	})


                    },
                    enviarrendicionfinanza(id,monto,cc,run_fiador,nombre_fiador,ultima,id_solicitud)
                    {
                    	if(ultima ===0) {
                    		Swal.fire({
                    			title: 'No Olvide marcar si es su Ultima Rendición',          
                    			icon: 'warning',
                    			showCancelButton: true,					
                    			html:  "<img src='assets/img/checktoggle.png' style='width:150px;'>",
                    			confirmButtonColor: '#3085d6',
                    			cancelButtonColor: '#d33',
                    			confirmButtonText: 'Aceptar'
                    		}).then((result) => {
                    			if (result.isConfirmed) {

                    				axios.get('rendiciones_fondo/'+id).then(response=>{

                    					this.rendiciones_cpp=response.data;
                    					this.monto_total_envio=0;
                    					this.monto_mas_monto_rend=monto;
                    					for (var i = 0; i < response.data.length; i++) {
                    						this.monto_total_envio=this.monto_total_envio+response.data[i].monto;

                    					}	

                    					if(this.monto_total_envio ==0)
                    					{
                    						return this.dulcealert('Debe ingresar Rendiciones','error');
                    					}	

                    					if(monto<this.monto_total_envio){
                    						this.monto_descuento=this.monto_total_envio-monto;
                    						this.monto_mas_monto_rend=this.monto_total_envio-this.monto_descuento;
                    					}else{
                    						this.monto_mas_monto_rend=this.monto_total_envio;
                    					}	


                    				});

                    			}

                    		});


                    	}else{

                    		this.enviarRendicion(id,monto,cc,run_fiador,nombre_fiador,id_solicitud);

                    	}
                    	


                    },


                    guardarrendicion()
                    {     

                    	console.log(this.tipo_documento);
                    	if(this.tipo_documento == '')
                    	{
                    		return this.dulcealert('debe ingresar el tipo de documento','error')
                    	}

                    	if(!this.id_producto){
                    		
                    		return this.dulcealert('debe ingresar un producto','error')

                    	} 
                    	if(!this.cantidad_productos){
                    		return this.dulcealert('debe ingresar un cantidad','error')
                    	}
                    	if(!this.monto_productos){
                    		return this.dulcealert('debe ingresar un monto','error')
                    	}
                    	if(!this.numero_docu){
                    		return this.dulcealert('debe ingresar un numero de Documento','error')
                    	}
                    	if(!this.id_proveedor){
                    		return this.dulcealert('debe ingresar el proveedor','error')
                    	}
                    	if(this.id_proveedor =='0')
                    	{
                    		var a={
                    			apellido_m:this.apellido_mate_proveedor,
                    			apellido_p:this.apellido_pat_proveedo,
                    			run:this.search_proveedor,
                    			tipo:this.razonsocial,
                    			nombre_proveedor:this.nombre_proveedor
                    		}
                    		axios.post('proveedor_anticipos',a).then(response=>{
                    			this.id_proveedor=response.data;
                    			var fecha = new Date();
                    			var hoy = fecha.getDate();
                    			var añoActual = fecha.getFullYear()
                    			var mesActual = fecha.getMonth() + 1; 
                    			var d=new FormData();
                    			d.append('anticipo',this.titulomodal)
                    			d.append('tipo',this.tipo_documento)
                    			d.append('id_producto',this.id_producto)
                    			d.append('cantidad',this.cantidad_productos)
                    			d.append('monto',this.monto_productos)
                    			d.append('numero',this.numero_docu)
                    			d.append('id_proveedor',response.data)
                    			d.append('fecha',this.fecha_doc)
                    			d.append('file',this.archivo)
                    			d.append('mes',mesActual)
                    			d.append('year',añoActual)
                    			d.append('cc',this.id_centro)
                    			d.append('descripcion',this.descripcion_docu)
                    			d.append('sub_item_sigfe',this.sub_item_sigfe)
                    			d.append('sigfe_item',this.sigfe_item)
                    			d.append('nombre_sigfe',this.nombre_sigfe)
                    			d.append('cuenta_sigfe',this.cuenta_sigfe)



                    			axios.post('rendiciones_fondo',d).then(response=>{
                    				this.dulcealert('Rendicion Guardada','success');
                    				this.getRendiciones(this.titulomodal);
                    				this.limpiarformulariorendicion();

                    			}).catch(err=>{
                                   this.dulcealert('Error en servidor comuniquese con informatica  '+err,'error');  // NOTE - use "error.response.data` (not "error")
                                   
                               });

                    		});
                    	}else{
                    		var fecha = new Date();
                    		var hoy = fecha.getDate();
                    		var añoActual = fecha.getFullYear()
                    		var mesActual = fecha.getMonth() + 1; 
                    		var d=new FormData();
                    		d.append('anticipo',this.titulomodal)
                    		d.append('tipo',this.tipo_documento)
                    		d.append('id_producto',this.id_producto)
                    		d.append('cantidad',this.cantidad_productos)
                    		d.append('monto',this.monto_productos)
                    		d.append('numero',this.numero_docu)
                    		d.append('id_proveedor',this.id_proveedor)
                    		d.append('fecha',this.fecha_doc)
                    		d.append('file',this.archivo)
                    		d.append('mes',mesActual)
                    		d.append('year',añoActual)
                    		d.append('cc',this.id_centro)
                    		d.append('descripcion',this.descripcion_docu)
                    		d.append('sub_item_sigfe',this.sub_item_sigfe)
                    		d.append('sigfe_item',this.sigfe_item)
                    		d.append('nombre_sigfe',this.nombre_sigfe)
                    		d.append('cuenta_sigfe',this.cuenta_sigfe)


                    		axios.post('rendiciones_fondo',d).then(response=>{
                    			this.dulcealert('Rendicion Guardada','success');
                    			this.getRendiciones(this.titulomodal);
                    			this.limpiarformulariorendicion();

                    		}).catch(err=>{
                                   this.dulcealert('Error en servidor comuniquese con informatica  '+err,'error');  // NOTE - use "error.response.data` (not "error")
                                   
                               });



                    	}

                    	
                    },
                    limpiarFormulariorendicionmensaje()
                    {
                    	this.mensaje='';
                    	this.run_funcionario='';
                    	this.nombre_funcionario='';
                    },
                    limpiarformulariorendicion()
                    {
                    	this.fecha_doc='';
                    	this.search_producto='';
                    	this.search_proveedor='';
                    	this.nombre_proveedor='';
                    	this.id_producto='';
                    	this.cantidad_productos='';
                    	this.monto_productos='';
                    	this.numero_docu='';
                    	this.apellido_mate_proveedor='';
                    	this.apellido_pat_proveedor='';
                    	this.files2=[];
                    	this.resetImage2();


                    },
                    resetImage2 () {
                    	this.file = '';
                    	this.$refs.file.value=null;

                    },
                    cambiodetipodoc(event)
                    {
                    	if(this.tipo_documento == 2)
                    	{
                    		this.search_producto="Deposito";
                    		this.id_producto="0";
                    		this.bloquearinput=true;
                    		this.verresultado=false;
                    		$('.results_producto').hide();
                    	}else{
                    		this.search_producto="";
                    		this.id_producto=null;
                    		this.bloquearinput=false;
                    	}
                    },
                    formato:function (size) 
                    {
                    	if (size > 1024 * 1024 * 1024 * 1024) {
                    		return (size / 1024 / 1024 / 1024 / 1024).toFixed(2) + ' TB'
                    	} else if (size > 1024 * 1024 * 1024) {
                    		return (size / 1024 / 1024 / 1024).toFixed(2) + ' GB'
                    	} else if (size > 1024 * 1024) {
                    		return (size / 1024 / 1024).toFixed(2) + ' MB'
                    	} else if (size > 1024) {
                    		return (size / 1024).toFixed(2) + ' KB'
                    	}
                    	return size.toString() + ' B'
                    },
                    sub:function(e)
                    {
                    	let reader = new FileReader();
                // Leemos el archivo subido y se lo pasamos a nuestro fileReader
                    	reader.readAsDataURL(e.target.files[0]);
                    	reader.onload = function(){
                    		let preview = document.getElementById('preview'),
                    		image = document.createElement('img');
                    		image.setAttribute("width", "120");
                    		image.setAttribute("height", "120");

                    		image.src = reader.result;

                    		preview.innerHTML = '';
                    		preview.append(image);
                    	};
                    	this.file = this.$refs.file.files[0];
                    	console.log(this.file);
                    	this.archivo=this.file; 
                    	$('#fichero_seleccionado').text(this.archivo.name);
                    	this.forma=this.formato(this.archivo.size);
                    	$('#fichero_peso').text(this.forma);
                    	let datos={
                    		name:this.archivo.name,      
                    		size:this.forma
                    	}
                    	this.files2.push(datos);
                    	var parsedobj = JSON.parse(JSON.stringify(this.files2));
                    	this.files=(parsedobj[0]);
                    	var final=this.files.name.split(".").pop();
                    	console.log(final);
                    	console.log('final:',final);
                    },
                    submodal:function(e){

                    	let reader = new FileReader();
                // Leemos el archivo subido y se lo pasamos a nuestro fileReader
                    	reader.readAsDataURL(e.target.files[0]);
                    	reader.onload = function(){
                    		let preview = document.getElementById('preview'),
                    		image = document.createElement('img');
                    		image.setAttribute("width", "120");
                    		image.setAttribute("height", "120");

                    		image.src = reader.result;

                    		preview.innerHTML = '';
                    		preview.append(image);
                    	};
                    	this.botonsubirimagenmodal=true;
                    	this.filemodal = this.$refs.filemodal.files[0];
                    	console.log(this.filemodal);
                    	this.archivomodal=this.filemodal; 
                    	$('#fichero_seleccionadomodal').text(this.archivomodal.name);
                    	this.nombre_ad_modal=this.archivomodal.name;
                    	this.forma=this.formato(this.archivomodal.size);
                    	$('#fichero_peso').text(this.forma);
                    	let datos={
                    		name:this.archivomodal.name,      
                    		size:this.forma
                    	}



                    },
                    validaRut: function(rutCompleto) 
                    {
                    	rutCompleto = rutCompleto.replace("‐","-");
                    	if (!/^[0-9]+[-|‐]{1}[0-9kK]{1}$/.test( rutCompleto ))
                    		return false;
                    	var tmp     = rutCompleto.split('-');
                    	var digv    = tmp[1];
                    	var rut     = tmp[0];
                    	if ( digv == 'K' ) digv = 'k' ;

                    	return (this.dv(rut) == digv );
                    },
                    dv : function(T)
                    {
                    	var M=0,S=1;
                    	for(;T;T=Math.floor(T/10))
                    		S=(S+T%10*(9-M++%6))%11;
                    	return S?S-1:'k';
                    },
                    enter_search_proveedor(val) 
                    {
                    	console.log(this.search_proveedor);
                    	var val=this.search_proveedor;
                    	this.newBooks_proveedor2 = [];  

                    	axios.get('proveedor_anticipos/'+val).then(response=>{
                    		if(response.data != ''){
                    			var run_f = val.split('-');
                    			if(run_f[0] < 50000000){

                    				this.newBooks_proveedor2=response.data;

                    			}else{

                    				this.newBooks_proveedor2=response.data;


                    			}

                    		}else{
                    			var run_f = val.split('-');
                    			if(run_f[0] < 50000000){
                    				this.razonsocial=1;
                    				this.readonlyr_social=false;

                    			}else{

                    				this.razonsocial=2;
                    				this.readonlyr_social=true;
                    			}
                    			var r=this.validaRut(val);
                    			if(r === true){

                    				this.dulcealert('No se encuentra el Proveedor! ','error');
                    				this.id_proveedor="0";
                    				this.nombre_proveedor='';
                    				this.apellido_pat_proveedor='';
                    				this.apellido_mate_proveedor='';


                    			}else{
                    				swal({
                    					title:'Error',
                    					text:'Run invalido! ',
                    					icon:'error',
                    					button:'Ok!'
                    				})

                    			}


                    		}


                    	});  



                    },

                    rendir(id,monto,id_centro,nombre_centro)
                    {   this.bloqueo=true;
                    this.titulomodal=id;
                    this.monto_total=monto;
                    this.centromodal=nombre_centro;
                    this.id_centro=id_centro;
                    this.getRendiciones(id);

                    $("#form_rendicion").modal();

                    this.bloqueo=false;

                },
                eliminaridrndicion(id,id_anticipo)
                {
                	Swal.fire({
                		title: 'Desea Eliminar Rendicion?',          
                		icon: 'warning',
                		showCancelButton: true,
                		confirmButtonColor: '#3085d6',
                		cancelButtonColor: '#d33',
                		confirmButtonText: 'Aceptar'
                	}).then((result) => {
                		if (result.isConfirmed) {
                			this.bloqueo=true;

                			axios.post('rendiciones_fondo/'+id,{_method:'delete'}).then(response=>{
                				this.getRendiciones(id_anticipo);
                				this.dulcealert('Se elimino la rendicion','success');
                				this.bloqueo=false;
                			});

                		}

                	});
                },
                selectResult_proveedor(id,nombre,run,apellid_paterno,apellid_materno,tipo,razon)
                {

                	this.search_proveedor='';
                	this.search_proveedor = run;
                	this.nombre_proveedor=nombre;
                	if(tipo!=2){
                		this.apellido_pat_proveedor=apellid_paterno;
                		this.apellido_mate_proveedor=apellid_materno;
                	}else{
                		this.nombre_proveedor=razon;
                		this.apellido_pat_proveedor='';
                		this.apellido_mate_proveedor='';
                	}

                	this.id_proveedor=id;
                	var run_f = run.split('-');
                	if(run_f[0] < 50000000){
                		this.razonsocial=1;
                		this.readonlyr_social=false;

                	}else{

                		this.razonsocial=2;
                		this.readonlyr_social=true;
                	}

                	this.toggle_proveedor=false;


                },
                selectResult_producto(id,nombre,nombre_sigfe,cuenta_sigfe,sub_item_sigfe,sigfe_item)
                {

                	this.search_producto = nombre;
                	this.id_producto=id;
                	this.toggle_producto=false
                	this.nombre_sigfe=nombre_sigfe
                	this.cuenta_sigfe=cuenta_sigfe
                	this.sub_item_sigfe=sub_item_sigfe
                	this.sigfe_item=sigfe_item

                },
                getAnticipos()
                {
                	axios.get('fondo_fijo/'+this.id_session).then(response=>{
                		console.log(response.data);

                		this.data_anticipos=response.data;

                	});
                },
                getRendicionesvalidacion(id)
                {
                	axios.get('rendiciones_fondo/'+id).then(response=>{
                		this.rendiciones=response.data;
                		this.monto_total_rendiciones=0;
                		for (var i = 0; i < this.rendiciones.length; i++) {
                			this.monto_total_rendiciones=this.monto_total_rendiciones+this.rendiciones[i].monto;
                		}
                		return this.monto_total_rendiciones;
                		this.data_anticipos_2=response.data;
                	});


                },
                getRendiciones(id)
                {
                	axios.get('rendiciones_fondo/'+id).then(response=>{
                		this.rendiciones=response.data;
                		this.monto_total_rendiciones=0;
                		for (var i = 0; i < this.rendiciones.length; i++) {
                			this.monto_total_rendiciones=this.monto_total_rendiciones+this.rendiciones[i].monto;
                		}
                		this.data_anticipos_2=response.data;

                	});
                },
                formatPrice(value) 
                {
                	let val = (value/1).toFixed(0).replace('.', '.')
                	return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
                },
                getFile:function()
                {
                	var arch=document.getElementById("upfile").click();
                },
                getFilemodal(){
                	var arch=document.getElementById("upfilemodal").click();
                },
                eliminar_imagen(index)
                {

                	this.files2=[];
                	this.resetImage2();

                },
                enviarRendicioncomprmiso(id,monto,cc,run_fiador,nombre_fiador,id_solicitud,idprofia){

                	Swal.fire({
                		title: 'No Olvide marcar si es su Ultima Rendición',          
                		icon: 'warning',
                		showCancelButton: true,					
                		html:  "<img src='assets/img/checktoggle.png' style='width:150px;'>",
                		confirmButtonColor: '#3085d6',
                		cancelButtonColor: '#d33',
                		confirmButtonText: 'Aceptar'
                	}).then((result) => {
                		if (result.isConfirmed) {
                			this.bloqueo=true
                			axios.get('rendiciones_fondo/'+id).then(response=>{

                				this.rendiciones_cpp=response.data;
                				this.monto_total_envio=0;
                				this.monto_mas_monto_rend=monto;
                				if(response.data.length === 0)
                				{
                					this.bloqueo=false;
                					return this.dulcealert('No existen rendiciones');


                				}
                				for (var i = 0; i < response.data.length; i++) 
                				{
                					this.monto_total_envio=this.monto_total_envio+response.data[i].monto;

                				}
                				console.log(this.monto_total_envio);	

                				if(monto>this.monto_total_envio)
                				{
                					this.bloqueo=false;
                					return this.dulcealert('La rendicion no puede menor al monto del anticipo','error');

                				}	

                				if(monto<this.monto_total_envio)
                				{
                					this.monto_descuento=this.monto_total_envio-monto;
                					this.monto_mas_monto_rend=this.monto_total_envio-this.monto_descuento;
                				}
                				this.bloqueo=false;
                				Swal.fire({
                					title: 'Desea enviar la rendición por el monto de: $'+this.formatPrice(this.monto_total_envio),          
                					icon: 'warning',
                					showCancelButton: true,
                					confirmButtonColor: '#3085d6',
                					cancelButtonColor: '#d33',
                					confirmButtonText: 'Aceptar'
                				}).then((result) => {
                					if (result.isConfirmed) {
                						var rendic=new FormData();
                						rendic.append('anticipo_id',id)
                						rendic.append('estados',3)
                						rendic.append('envio',1)
                						axios.post('rendiciones_fondoupdate',rendic).then(responserendicion=>{

                						}).catch(err=>{
                							this.bloqueo=false;
                            this.dulcealert('Error en servidor comuniquese con informatica  '+err,'error');  // NOTE - use "error.response.data` (not "error")

                        });
                						this.bloqueo=true;
                						var fecha = new Date();
                						var hoy = fecha.getDate();
                						var añoActual = fecha.getFullYear()
                						var mesActual = fecha.getMonth() + 1; 
                						var d=new FormData();
            						/*if(this.monto_total_envio >0){
            							this.bloqueo=false;
            							return this.dulcealert(this.monto_mas_monto_rend,'success')


            						}*/
                						var valortotal=this.monto_descuento != 0 ? (this.monto_total_envio-this.monto_descuento) : this.monto_total_envio
                						d.append('total',this.monto_mas_monto_rend);
                						d.append('total_neto',this.monto_mas_monto_rend);
                						d.append('descuento',this.monto_descuento);
                						d.append('despacho',0);
                						d.append('impuesto',0);
                						d.append('oc',0);
                						d.append('proveedor',idprofia);						
                						d.append('tipo',4);
                						d.append('estado',1);
                						d.append('iva',0);
                						d.append('observacion','creado por fondo fijo anticipo N°'+id);
                						d.append('year',añoActual);
                						d.append('usuario',this.id_session);
                						d.append('_token',this.csrf);
                						axios.post('../../gestion_ordenes/public/crearcpp',d,{headers: {
                							'Content-Type': 'multipart/form-data',
                							'Access-Control-Allow-Credentials': true,
                							'_token': this.csrf
                						}
                					}).then(response1=>{

                						this.addproductos(response1.data,5)
                						this.addcppanticipos(response1.data,id)
                						this.updatefondo(id,response1.data)
                						this.addfirma(id)
                						this.bloqueo=false
                						this.dulcealert('Rendicion Enviada','success')

                					}).catch(err=>{
                						if (err.response && 419 === err.response.status) {

                						}

                						return Promise.reject(err)


                						this.bloqueo=false
                					});




                				}




                			});




                			});


}
});        



},
addfirma(id){
	var firma=new FormData();
	firma.append('usuario','');
	firma.append('estado',0);
	firma.append('unidad',4);
	firma.append('id_anticipo',id);

	axios.post('firma_anticipo',firma).then(respofirma=>{
	});

},
updatefondo(id,cpp){
	var url_ant='fondo_fijo/'+id;
	var anti={	
		estado:11,
		id_cpp:cpp,
		_method:'patch'
	}
	axios.post(url_ant,anti).then(respanticipo=>{
		this.getAnticipos();


	});

},
addcppanticipos(cpp,anticipo)
{
	var anti=new FormData();
	anti.append('cpp',cpp);
	anti.append('anticipo',anticipo);
	anti.append('usuario',this.id_session);

	axios.post('cpp_anticipos',anti).then(responseanticipos=>{
	});

},
updaterendicion(id){
	var ur_rendi='rendiciones_fondo/'+id;
	var rendic={		
		estados:3,
		_method:'patch'
	}
	axios.post(ur_rendi,rendic).then(responserendicion=>{
	});

},
addproductos(id,tipo){

	for (let i = 0; i < this.rendiciones_cpp.length; i++) {

		if(this.rendiciones_cpp[i].tipo_doc == 2)
		{
			var extension=this.rendiciones_cpp[i].url.split(".");
			var d={
				correo:'antoniovp18@gmail.com',
				text:'Hola',
				url:this.rendiciones_cpp[i].url,
				tipo:extension[1],
				subject:'Deposito',
				numero:this.rendiciones_cpp[i].anticipo_id,
				fecha:this.rendiciones_cpp[i].fecha_doc

			}
			axios.post('mail',d).then(response=>{

			});

		}else{
			this.updaterendicion(this.rendiciones_cpp[i].id)
			var p=new FormData();
			p.append('nombre',this.rendiciones_cpp[i].produNombre)
			p.append('cantidad',this.rendiciones_cpp[i].cantidad_producto)
			p.append('detalle',null)
			p.append('precio',this.rendiciones_cpp[i].monto)
			p.append('id_aba',this.rendiciones_cpp[i].producto_id)
			p.append('orden',i)
			p.append('cuenta',this.rendiciones_cpp[i].cuenta_sigfe)
			p.append('total',this.rendiciones_cpp[i].monto)
			p.append('unidad','UD')
			p.append('nombre_sigfe',this.rendiciones_cpp[i].nombre_sigfe)
			p.append('nombre_producto',this.rendiciones_cpp[i].produNombre)
			p.append('sub_item_sigfe',this.rendiciones_cpp[i].sub_item_sigfe)
			p.append('estado',0)
			p.append('justificacion',null)
			p.append('cc',this.rendiciones_cpp[i].cc_id)
			p.append('convenio',0)
			p.append('precio_todo',this.rendiciones_cpp[i].monto)
			p.append('pro_id_cpp',id)
			p.append('pro_precio_unitario',this.rendiciones_cpp[i].monto)
			p.append('pro_cantidad_unitario',this.rendiciones_cpp[i].cantidad_producto)
			p.append('sigfe_item',this.rendiciones_cpp[i].sigfe_item)
			p.append('zgen',0)
			p.append('oc',0) 
			axios.post('../../gestion_ordenes/public/crearproductos',p).then( respo=>{	
				this.addarchivos(respo.data,this.rendiciones_cpp[i].url,this.rendiciones_cpp[i].nombre_archivo,tipo,id,respo.data)


			});

		}

	}

},
addarchivos(id,url,nombrearchivo,tipo,numero,idproducto){
	var d=new FormData()
	d.append('nombre',nombrearchivo)
	d.append('url',url)
	d.append('tipo',tipo)
	d.append('id',numero)
	d.append('idproducto',idproducto)
	axios.post('../../gestion_ordenes/public/crearadjuntos',d).then(response=>{

	}).catch(err=>{

	});


}



}

} 

</script>