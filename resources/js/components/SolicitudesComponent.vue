<template>
	<div class="">
		<div class="row">
			<div class="col-12">		

				<div class="card">
					<div class="card-header text-white" style="background-color: #193659 !important;"> 
						<i class="far fa-id-card" style="font-size: 15px;"></i> Solicitud de Fondo Fijo
					</div>        
					<div class="card-body "> 
						<div class="row mt-2">
							<div class="col-12">
								<div class="row">
									<div class="col-2">
										<label>Solicita:</label>

									</div>
									<div class="col-4">
										<input type="text" class="form-control " id="solicitante" name="solicitante" v-model="nombre_usuario" readonly>
										<input name="rut_usuario" type="hidden" id="rut_usuario" v-model="rut_usuario"  />
									</div>
									<div class="col-2">
										<label>Fiador:</label> 

									</div>
									<div class="col-4 ">

										<input type="text" placeholder="Buscar Fiador"  class="form-control"v-model="search" @blur="toggle = false" @focus="toggle = true">
										<div class="results" v-if="toggle"  style="
										z-index: 1;
										position: absolute;
										background-color: #ffff;
										width: 32%;
										">
										<div class="result" v-for="book in newBooks" >
											<span @click="selectResult(book.per_rut,book.per_nombre,book.id)" @mousedown.prevent>
												{{book.per_nombre}}
											</span>
										</div>
									</div> 
									<input type="hidden" name="" v-model="id_personas">
									<input type="hidden" name="" v-model="idprofia">

								</div>

							</div> 
							<div class="row mt-1">
								<div class="col-2">
									<label>Centro de Costo:</label>

								</div>
								<div class="col-4">			

									<input type="text" placeholder="Buscar Centro Costo"  class="form-control"v-model="search_centro" @blur="toggle_centro = false" @focus="toggle_centro = true">
									<div class="results" v-if="toggle_centro"  style="
									z-index: 1;
									position: absolute;
									background-color: #ffff;
									width: 32%;
									">
									<div class="result" v-for="book in newBooks_centro" >
										<span @click="selectResult_centro(book.cc_id,book.cc_nombre,book.cc_cr_id)" @mousedown.prevent>
											{{ book.cc_nombre }}
										</span>
									</div>
								</div> 
								<input type="hidden" name="" v-model="id_personas_centro">
							</div>
							<div class="col-2">
								<label>$ Monto:</label>

							</div>
							<div class="col-4">
								<input type="number" class="form-control " v-model="monto" name="monto">
							</div>

						</div>
						<div class="row mt-1">
							<div class="col-2">
								<label>Revisor:</label>
							</div>
							<div class="col-4">
								<input type="text" placeholder="Buscar Persona" class="form-control"v-model="search_persona" @blur="toggle_persona = false" @focus="toggle_persona = true">
								<div class="results" v-if="toggle_persona"  style="
								z-index: 1;
								position: absolute;
								background-color: #ffff;
								width: 32%;
								">
								<div class="result" v-for="book in newBooks_persona" >
									<span @click="selectResult_persona(book.per_rut,book.per_nombre)" @mousedown.prevent>
										{{ book.per_nombre}}
									</span>
								</div>
							</div> 
							<input type="hidden" name="" v-model="id_personas_persona">

						</div>
						<div class="col-2">
							<label>Seleccione:</label>

						</div>
						<div class="col-4">
							<select class="form-control" v-model="cc_pre_extra">
								<option value="1" :selected="selectedextra_1">Extrapresupuestaria</option>
								<option value="2" :selected="selectedextra">Presupuestaria</option>
							</select>

						</div>


					</div>
					<div class="row mt-3">
						<div class="col-12 offset-5">
							<div class="custom-file">
								<form method="POST" enctype="multipart/form-data" name="myForm">
									<div class="text-bold-600 font-medium-2 btn btn-success" @click="getFile_2()">
										<i class="far fa-upload"></i> SUBIR DOCUMENTOS
									</div>
									<input name="MAX_FILE_SIZE" type="hidden" id="imageA"  value="3000000" />
									<div style='height: 0px;width: 0px; overflow:hidden;'><input name="imagen" type="file"  id="upfile_documentos" ref="file_documento"  @change="sub_documento($event)" accept="application/pdf" /></div>
								</form>					

							</div>

						</div>
					</div>
					<div class="row">
						<div class="col-12 offset-4">
							<ul id="lista" style="display:none;">
								<li >
									<span id="fichero_seleccionado"></span>
									<span id="fichero_peso"></span>
									<span><a @click="limpiar()"><i class="far fa-trash-alt"></i></a></span>
								</li>
							</ul>


						</div>

					</div>
					<div class="row mt-1">
						<div class="col-12 ">
							<button type="button" class="btn btn-primary offset-11" v-on:click="solicita()">Solicitar</button>
						</div>

					</div>
				</div>

			</div>  



		</div>
	</div>
</div>
</div>
<div class="row justify-content">
	<div class="col-md-12">
		<div class="card mt-5">
			<div class="card-header">
				<h2>Solicitudes Fondo Fijo</h2>
			</div>

			<input type="hidden" name="" v-model="ct_l">
			<div class="card-body">
				
				<div v-cloak class="mt-4">
					<v-client-table :columns="columns" v-model="data" :options="options">
						<div slot="url" slot-scope="props">
							<a :href="'../storage/app/'+props.row.url" target="_blank"><i class="far fa-file-pdf offset-4"></i></a>
							
						</div>	

						<div slot="monto" slot-scope="props">

							{{formatPrice(props.row.monto)}}
							
						</div>	
						<div slot="motivo" slot-scope="props">
							{{props.row.motivo_rechazo}}
							

						</div>	
						<div slot="enviar" slot-scope="props">
						
							<button @click="modaleditarestado(props.row.id,props.row.unidad_negocio,props.row.cc)"class="btn btn-success" v-if="props.row.estado==4" >Enviar</button>	

						</div >
						
						<div slot="eliminar" slot-scope="props" v-if="props.row.estado_firma == 0" >
							
							<button @click="elimnarsolicitud(props.row.id,props.row.adjuntos_id)"class="btn btn-danger" >Eliminar</button>
						</div>
						<div slot="autorizar" slot-scope="props" v-if="props.row.unidad_negocio == 3 & props.row.estado_firma == 0">

							<button class="btn btn-info" v-if="props.row.firma == id_session" @click="autorizarsolicitud(props.row.id)">Autorizar</button>

							
						</div>

						
						<div slot="acciones" slot-scope="props" v-if="props.row.estado_firma == 0" >		
							

							<button type="button" class="btn btn-primary btn-xs"  @click="updatesolicitar_i(props.row.id,props.row.monto,props.row.fiador_id,props.row.fiador_nombre,props.row.run,props.row.cc,props.row.adjuntos_id,props.row.estado_firma,props.row.unidad_negocio,props.row.firma,props.row.url)">Editar</button>	
						</div>

					</v-client-table>

				</div>
				

			</div>


		</div>

	</div>
	
</div>
<div class="modal" tabindex="-1" role="dialog" id="modal_editar_solicitud">
	<div class="modal-dialog modal-dialog-centered " role="document" style="max-width: 80%;">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Editar Solicitud Fondo Fijo </h5>
				<button type="button" class="close btn btn-danger"  data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<input type="hidden" name="" v-model="id_editar_solicitud">
				<div class="row">
					<div class="col-1">
						<label>Monto:</label>
					</div>
					<div class="col-2">
						<input type="number" name="" v-model="editar_monto" class="form-control">
					</div>

					<div class="col-1">
						<label>Fiador:</label>
					</div>
					<div class="col-3 autocompleteBS">

						<input type="text"  v-model="search2" @blur="toggle2 = false" @focus="toggle2 = true" class="form-control">
						<div class="results2" v-if="toggle2">
							<div class="result2" v-for="book2 in newBooks2" >
								<span @click="selectResult2(book2.per_rut,book2.per_nombre)" @mousedown.prevent>
									{{ book2.per_nombre }}
								</span>
							</div>
						</div> 
						<input type="hidden" name="" v-model="id_personas2">                     

					</div>
					<div class="col-2">
						<label>Centro costo:</label>
					</div>
					<div class="col-3">

						<select name="centros_compra2"  class="form-control" v-model="centrocosto" >							

							<option v-for="cc2 in centro_costos" :value="cc2.cc_id" :selected="centrocosto === cc2.cc_id ? 'selected' : ''">{{cc2.cc_nombre}}</option>                    

						</select>
						<input type="hidden" name="" id="selecccion_cc">

					</div>

				</div>
				<div class="row mt-2">
					<div class="col-1">
						<label>Revisor:</label>

					</div>
					<div class="col-4">
						<input type="text" placeholder="Buscar Persona" v-model="search_persona" @blur="toggle_persona = false" @focus="toggle_persona = true" class="form-control">
						<div class="results" v-if="toggle_persona"  style="
						z-index: 1;
						position: absolute;
						background-color: #ffff;
						width: 32%;
						">
						<div class="result" v-for="book in newBooks_persona" >
							<span @click="selectResult_persona(book.per_rut,book.per_nombre)" @mousedown.prevent>
								{{ book.per_nombre}}
							</span>
						</div>
					</div> 
					<input type="hidden" name="" v-model="id_personas_persona">
					
				</div>
				<div class="col-6">
					<div class="row">
						<div class="col-2" v-show="url_vista">
							<a :href="urleditar" target="_blank"><img src="assets/img/pdf.png" width="50" height="50"></a><a @click="limpiar_imagen(id_editar_solicitud)"><i class="far fa-trash-alt"></i></a>
						</div>
						
						<div class="col-4">

							<div class="custom-file" v-show="url_vista2">
								<form method="POST" enctype="multipart/form-data" name="myForm">
									<div class="text-bold-600 font-medium-2 btn btn-success" @click="getFile_3()">
										<i class="far fa-upload"></i> ADJUNTAR DOCUMENTOS
									</div>
									<input name="MAX_FILE_SIZE" type="hidden" id="imageA"  value="3000000" />
									<div style='height: 0px;width: 0px; overflow:hidden;'><input name="imagen" type="file"  id="upfile_documentos3" ref="file_documento3"  @change="sub_documento3($event)" accept="application/pdf" /></div>
								</form>					

							</div>


							
						</div>
						<div class="col-2">
							<ul id="lista3" style="display:none;">
								<li >
									<span id="fichero_seleccionado3"></span>
									<span id="fichero_peso3"></span>
									<span><a @click="limpiar()"><i class="far fa-trash-alt"></i></a></span>
								</li>
							</ul>

						</div>
						
					</div>

					

				</div>


				
			</div>

		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-primary" @click="guardar_editar">Guardar</button>
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
		</div>
	</div>
</div>
</div>
<div class="modal fade" id="ModalPDF" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle">Documentos</h5>
				<button type="button" class="close btn btn-danger" data-dismiss="modal" aria-label="Close" @click="cerrarPdf">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<object class="PDFdoc" width="100%" height="500px" type="application/pdf" :data="'../storage/app/'+url_pdf"></object>
			</div>

			<div class="modal-footer">
				<a type="button" class="btn btn-primary" download="documentos.pdf" :href="url_pdf"><i class="far fa-file-pdf ml-1 text-white"></i>Descargar</a>
				<button type="button" class="btn btn-secondary" data-dismiss="modal" @click="cerrarPdf">Cerrar</button>

			</div>
		</div>
	</div>
</div>
<BlockUI :message="msg"  v-if="bloqueo">
	<img :src="'assets/img/745.gif'">

</BlockUI>

</div>

</template>
<script >
	export default {
		props: ['id_session','name'],

		data(){

			return {
				idprofia:'',
				cr_id:'',
				msg: 'Espere un Momento...',
				bloqueo:false,
				id_url_archivo:'',
				url_vista:true,
				url_vista2:false,
				urleditar:'',
				id_url:'',
				id_editar_solicitud:'',
				monto:'',
				editar_monto:'',
				id_personas2:'',
				newBooks2: [],
				id_personas:'',
				search2: '',
				toggle2: false,
				books2: [
				{name: 'Liste des livres de Chair de poule'},
				{name: 'Les Cent Meilleurs Romans policiers de tous les temps'},
				{name: 'Liste des livres publiés par Champ libre'}
				],
				ct_l:'',
				url_pdf:'',
				selecccion_cc:'',
				toggle_persona:'',
				selectedextra:'',
				selectedextra_1:'',
				cc_pre_extra:'',
				search_persona:'',
				id_personas:'',
				id_personas_persona:'',
				formEditar:{},
				userPost:'',
				centrocosto:'',
				centro_costo:[],
				centro_costos:[],
				centros_compras:'',
				centros_compra2:'',
				editar_monto:'',
				id_editar_solicitud:'',
				nombre_usuario:'',
				rut_usuario:'',
				search_centro: '',
				toggle_centro: false,
				id_personas_centro:'',
				newBooks_centro:[],
				newBooks:[],
				newBooks_persona:[],
				search: '',
				toggle: false,
				books: [
				{name: 'Liste des livres de Chair de poule'},
				{name: 'Les Cent Meilleurs Romans policiers de tous les temps'},
				{name: 'Liste des livres publiés par Champ libre'}
				],
				columns: ['id', 'amio', 'fecha_ingresada','monto','centro_costo','estado_nombre','motivo_rechazo','fiador_nombre','url','acciones','eliminar','enviar','autorizar'],
				data:[],
				options: {

					headings: {
						id: 'solicitud',
						amio: 'Año',
						fecha_ingresada: 'Fecha Ingresada',
						monto: 'Monto',
						centro_costo:'Centro de Costo',
						estado_nombre:'Estado',
						fiador_nombre: 'Fiador',
						motivo_rechazo:'Motivo',
						url:'Documento',
						acciones:'Acciones',
						eliminar:'Eliminar',
						enviar:'Enviar',
						autorizar:'Autorizar'


					},
					editableColumns:['id'],
					sortable: ['id'],
					filterable: ['id']
				},


			}
		},
		mounted(){

			this.nombre_usuario=this.name;
			this.rut_usuario=this.id_session;

		},

		created:function(){
			this.getfondofijo_i();
			this.getCentrosCostos();


		},
		watch:{
			search_persona(val) {
				console.log(val);
				this.newBooks_persona = [];      


				axios.get('persona'+val).then(response=>{
					this.newBooks_persona=response.data;
				});
			},
			search_centro(val) {
				console.log(val);
				this.newBooks_centro = []; 

				axios.get('centros/'+val).then(response=>{
					this.newBooks_centro =response.data;


				}); 


			},
			search(val) {
				console.log(val);
				this.newBooks = [];      


				axios.get('persona/'+val).then(response=>{
					this.newBooks=response.data;
				});
			},
			search_persona(val) {
				console.log(val);
				this.newBooks_persona = [];      


				axios.get('persona/'+val).then(response=>{
					this.newBooks_persona=response.data;
				});
			},
			search2(val) {
				console.log(val);
				this.newBooks2 = [];  
				axios.get('persona/'+val).then(response=>{
					this.newBooks2=response.data;
				});


				
			},
		},
		methods:{
			autorizarsolicitud(id){
				
				Swal.fire({
					title: 'Desea Autorizar la solicitud N° '+id,          
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Aceptar'
				}).then((result) => {
					if (result.isConfirmed) {
						this.bloqueo=true;
						var url='firma/'+id;
						var d={
							estado:1,
							id:id,
							estado_f:0,
							_method:'patch'

						}
						axios.post(url,d).then(response=>{
							var f=new FormData();
							f.append('unidad',2);
							f.append('estado',0);							
							f.append('id_solciitud',id);
							f.append('firma',this.id_session);

							axios.post('firma',f).then(rs=>{
								this.getfondofijo_i();
								this.bloqueo=false;

							});


						});
						

					}

				});

			},
			postsolicitud(id,numero,estado,cc,year)
			{
				var d=new FormData();
				d.append('tipo',3)
				d.append('estado',estado)
				d.append('usuario',this.id_session)
				d.append('year',year)
				d.append('cc',cc)
				d.append('numero',numero)
				d.append('id',id)
				axios.post('../../gestion_ordenes/public/crearsolicitudes',d).then(response=>{}).catch(err=>{

				});

			},
			selectResult_centro(id,nombre,cr_id){

				this.search_centro=nombre;
				this.id_personas_centro=id;
				this.cr_id=cr_id;

				if(parseInt(id) === 30){

					this.cc_pre_extra=1;
					this.selectedextra_1=true;

				}else if(parseInt(id)=== 31){
					this.cc_pre_extra=1;
					this.selectedextra_1=true;

				}else if(parseInt(id) === 147){
					this.cc_pre_extra=1;
					this.selectedextra_1=true;

				}else if(parseInt(id) === 104){
					this.cc_pre_extra=1;
					this.selectedextra_1=true;

				}else{
					this.cc_pre_extra=2;
					this.selectedextra=true;

				}

			},
			limpiar:function(){
				this.lis.style.display = 'none';
				this.resetImage();

			},
			selectResult_persona(id,nombre){
				this.id_personas_persona=id
				this.run_persona_firma=id;
				this.search_persona=nombre;

			},
			selectResult(id,nombre,id2) {

				this.search = nombre;
				this.id_personas=id;
				this.idprofia=id2

			},
			limpiar_imagen(id){
				Swal.fire({
					title: 'Desea Elimnar archivo?',          
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Aceptar'
				}).then((result) => {
					if (result.isConfirmed) {
						axios.post('adjunto/'+this.id_url_archivo,{_method:'delete'}).then(response=>{ 							
							
							var url='solicitudes_ff/'+this.id_editar_solicitud;

							var d={                              	
								adjuntos_id:0,
								_method:'patch'
							}
							axios.post(url,d).then(respons=>{
								this.url_vista=false;
								this.url_vista2=true;

							});


						});


					}

				});

			},
			modaleditarestado(id,unidad,cc){
				if(unidad == 4){
                 var estado=3;
				}else{
                  var estado=1;
				}

				Swal.fire({
					title: 'Desea Devolver la Solicitud N°'+id,          
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Aceptar'
				}).then((result) => {
					if (result.isConfirmed) {
						var currentTime = new Date();
									var year = currentTime.getFullYear();
									var mes=currentTime.getMonth() + 1;

						var f=new FormData();
						
						var f={
							estado:estado,
							id:id,
							motivo_rechazo:'',
							_method:'patch'
						 }
                          var url="solicitudes_ff/"+id;
						axios.post(url,f).then(response=>{
                             this.postsolicitud(id,id,3,cc,year)
							var d={
							estado:0,
							id:id,
							estado_f:4,
							firma:'',
							_method:'patch'

						   }
						   var firma='firma/'+id;
							axios.post(firma,d).then(rs=>{


								Swal.fire(
								'Excelete!',
								'Se cmabio de Estado su solicitud.',
								'success'
								)
							this.getfondofijo_i()


							});
							
						});


					}

				});

                },

				selectResult2(id,nombre) {

					this.search2 = nombre;
					this.id_personas=id;
				},
				guardar_editar(){
					this.bloqueo=true;

					var f={
						id:this.id_editar_solicitud,
						cc:this.centrocosto,
						monto:this.editar_monto,
						fiador_id:this.id_personas2,
						_method:'patch'

					}
					var url='solicitudes_ff/'+this.id_editar_solicitud;			
					axios.post(url,f).then(response=>{
						this.getfondofijo_i()

						Swal.fire(
							'Exito',
							'Se Actualizo la solicitud',
							'success'
							)			
						this.bloqueo=false;
						$("#modal_editar_solicitud").modal("hide");
						this.editar_monto='';
						this.id_personas2='';
						this.centrocosto='';
						this.newBooks=[];
						this.centro_costo=[];


					}).catch(error=>{

						Swal.fire(
							'Error',
							'Error al actualizar la solicitud! '+error,
							'error'
							)	

					});


				},
				getFile_2:function(){
					var arch=document.getElementById("upfile_documentos").click();

				},
				sub_documento(){
					this.file_documento2 = this.$refs.file_documento.files[0];
					console.log(this.file_documento2);
					this.archivo=this.file_documento2;
					this.lis = document.getElementById('lista');
					this.lis.style.display = '';
					$('#fichero_seleccionado').text(this.archivo.name);
					this.forma=this.formato(this.archivo.size);
					$('#fichero_peso').text(this.forma);

				},
				formatPrice(value) {
					let val = (value/1).toFixed(0).replace('.', '.')
					return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
				},
				verpdf(id){
					this.url_pdf='';
					this.url_pdf=id;
					$("#ModalPDF").modal("show");

				},
				cerrarPdf(){
					$("#ModalPDF").modal("hide");


				},
				adjuntartodosdocuemntos(id,id2){

					Swal.fire({
						title: 'Desea Adjuntar los documentos?',          
						icon: 'warning',
						showCancelButton: true,
						confirmButtonColor: '#3085d6',
						cancelButtonColor: '#d33',
						confirmButtonText: 'Aceptar'
					}).then((result) => {
						if (result.isConfirmed) {
							axios.get('../api/crud/getListarRendicionesFinalizadas.php?id='+id).then(response=>{
								console.log(response.data);
								for (var i = 0; i < response.data.length; i++) {

									var f=new FormData();
									f.append('url',response.data[i].url);
									f.append('id_cpp',id2);
									f.append('nombre',response.data[i].nombre_archivo);

									axios.post('../api/crud/postfilesubir.php',f).then(response1=>{




									});
									if( i >= response.data.length)
									{

										Swal.fire(
											'Excelente!',
											'YArchivos subidos!',
											'success'
											)
									}
								}

							});

						}

					});



				},
				updatesolicitar_i(id,monto,fiador_id,fiador_nombre,run,cc,adjuntos_id,estado_firma,unidad,firma,url){


					this.id_editar_solicitud=id;
					this.editar_monto=monto;
					this.search2=fiador_nombre;
					this.centrocosto=cc;
					this.urleditar=url;
					this.id_url_archivo=adjuntos_id;
					this.id_personas2=fiador_id;

					if(unidad == 3){
						axios.get('persona/'+firma).then(response=>{
							this.search_persona=response.data[0].per_nombre;

						});

					}




					$("#modal_editar_solicitud").modal("show");

				},
				elimnarsolicitud(id,id2){

					Swal.fire({
						title: 'Desea Elimnar la solicitud N°'+id,            
						icon: 'warning',
						showCancelButton: true,
						confirmButtonColor: '#3085d6',
						cancelButtonColor: '#d33',
						confirmButtonText: 'Eliminar'
					}).then((result) => {
						if (result.isConfirmed) {
							this.bloqueo=true;
							axios.post('solicitudes_ff/'+id,{_method:'delete'}).then(response=>{
								axios.post('adjunto/'+id2,{_method:'delete'}).then(res=>{
									Swal.fire(
										'Elimnado!',
										'Solicitud.',
										'success'
										)
									this.bloqueo=false;


								});



							});

						}
					})


				},
				resetImage () {
					this.file = '';
					this.$refs.file_documento.value=null;

				},
				resetImage2 () {
					this.file = '';
					this.$refs.file.value=null;

				},
				formato:function (size) {
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
				getfondofijo_i(){
					axios.get('solicitudes_ff/'+this.id_session).then(response=>{
						this.data=response.data;

					});

				},
				getCentrosCostos(){
					axios.get('centros').then(response=>{
						this.centro_costos=response.data;
					});
				},
				solicita(){
					if(this.monto > 0){
						this.bloqueo=true;

						axios.get('fiadores/'+this.id_personas).then(res=>{
							if(res.data.length == 0){
								var d=new FormData();
								d.append('run',this.id_personas);
								d.append('nombre',this.search);
								d.append('centro_costo',this.id_personas_centro);
								d.append('cc_extra',this.cc_pre_extra);
								d.append('id',this.idprofia);
								axios.post('fiadores',d).then(response=>{
									var currentTime = new Date();
									var year = currentTime.getFullYear();
									var mes=currentTime.getMonth() + 1;
									var c_s=new FormData();
									c_s.append('monto',this.monto);
									c_s.append('cc',this.id_personas_centro);
									c_s.append('id_fiador',response.data);								
									c_s.append('cr',this.cr_id);
									c_s.append('usuario', this.id_session);
									c_s.append('archivo',this.archivo);     
									c_s.append('run_firma',this.id_personas_persona);
									c_s.append('cc_extra',this.cc_pre_extra);
									c_s.append('year',year);
									c_s.append('mes',mes);
									axios.post('solicitudes_ff',c_s).then(resp0=>{
										this.postsolicitud(resp0.data,resp0.data,3,this.id_personas_centro,year)
										console.log(resp0.data);    
										this.monto='';
										this.id_personas_centro='';
										this.search_centro='';
										this.search='';
										this.lis.style.display = 'none';
										this.resetImage();


										Swal.fire(
											'Exito',
											'Se creo la solicitud N'+resp0.data,
											'success'
											)
										this.bloqueo=false;
										this.getfondofijo_i();
								// var log= new FormData();
								// log.append('usuario',this.rut_usuario);
								// log.append('motivo','creacion de solicitud n'+resp0.data);

								// axios.post('../api/crud/postLog_anticipos.php',log).then(response=>{});



							}).catch(error => {
								Swal.fire(
									'No existe!',
									'Error al crear la solicitud!'+error,
									'error'
									)

								
                                  }); // post cerrar solicitud


						});
							}else{
								var currentTime = new Date();
								var year = currentTime.getFullYear();
								var mes=currentTime.getMonth() + 1;
								var c_s=new FormData();
								c_s.append('monto',this.monto);
								c_s.append('cc',this.id_personas_centro);
								c_s.append('id_fiador',res.data[0].id);
								c_s.append('cr',this.cr_id);
								c_s.append('usuario', this.id_session);
								c_s.append('archivo',this.archivo);     
								c_s.append('run_firma',this.id_personas_persona);
								c_s.append('cc_extra',this.cc_pre_extra);
								c_s.append('year',year);
								c_s.append('mes',mes);
								axios.post('solicitudes_ff',c_s).then(resp0=>{
									this.postsolicitud(resp0.data,resp0.data,3,this.id_personas_centro,year);
									console.log(resp0.data);    
									this.monto='';
									this.id_personas_centro='';
									this.search_centro='';
									this.search='';
									this.lis.style.display = 'none';
									this.resetImage();


									Swal.fire(
										'Exito',
										'Se creo la solicitud N'+resp0.data,
										'success'
										)
									this.bloqueo=false;
									this.getfondofijo_i();
								// var log= new FormData();
								// log.append('usuario',this.rut_usuario);
								// log.append('motivo','creacion de solicitud n'+resp0.data);

								// axios.post('../api/crud/postLog_anticipos.php',log).then(response=>{});



							}).catch(error => {
								Swal.fire(
									'No existe!',
									'Error al crear la solicitud!'+error,
									'error'
									)

								
                                  }); // post cerrar solicitud




						}
					});
					}


				},
			}

		} 	   


	</script>