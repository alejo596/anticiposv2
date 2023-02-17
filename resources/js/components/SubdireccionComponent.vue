<template>
	<div>
		<div class="container">
			<div class="card">
				<div class="card-body">
					<div class="row">
						<div class="col-12">
							<input type="" name="" v-model="cr_cc" class="form-control" style="text-align: center;font-size: 20px" disabled="disabled">
						</div>
						
					</div>

					<ul class="nav nav-tabs mt-4" id="myTab" role="tablist">
						<li class="nav-item" role="presentation">
							<a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Ordenes de Compras <span class="badge badge-danger">{{totalcompras}}</span></a>
						</li>
						<li class="nav-item" role="presentation">
							<a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Viaticos</a>
						</li>
						<li class="nav-item" role="presentation">
							<a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Solicitud de Fondos Fijos</a>
						</li>
					</ul>
					<div class="tab-content" id="myTabContent">
						<div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
							<v-client-table :columns="columns_productos_sub" v-model="data_productos_sub" :options="options_productos_sub">

								<a slot="acciones" slot-scope="props">
									
									<button class="btn btn-primary" @click="visualizar(props.row.compra_numero,props.row.compra_id,props.row.compra_amio,props.row.cc_nombre,props.row.per_nombre,props.row.cr_nombre,props.row.compra_telefono,props.row.compra_fecha_guardada,props.row.compra_id,props.row.cc_cr_id,props.row.cc_id,props.row.compra_encargado_cc_rut,props.row.compra_encargado_cc_aprueba_fecha,props.row.compra_jefatura_sub_rut,props.row.compra_jefatura_sub_aprueba_fecha)">Visualizar</button>

								</a>

							</v-client-table>

						</div>
						<div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
							<v-client-table :columns="columns_productos_sub1" v-model="data_productos_sub1" :options="options_productos_sub1">



							</v-client-table>
						</div>
						<div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
							<v-client-table :columns="columns_productos_sub2" v-model="data_productos_sub2" :options="options_productos_sub2">




							</v-client-table>
						</div>
					</div>


				</div>
			</div>


		</div>




		<div class="modal" tabindex="-1" role="dialog" id="modalaceptar">
			<div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 1400px !important;">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">{{titulomodal}}</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-6">
								<h5>{{titulomodal}}</h5>
							</div>
							<div class="col-2">
								<h5> N° {{numero}}</h5>
							</div>
							<div class="col-2">
								<h5>Año:{{year}}</h5>
							</div>
						</div>
						<div class="row mt-1">
							<div class="col-3">
								<label>Nombre Usuario:</label>
							</div>
							<div class="col-3">
								<input type="" name="" class="form-control" v-model="nombre_usuario" readonly="readonly">
							</div>
							<div class="col-3">
								<label>Fecha Orden De Compra:</label>
							</div>
							<div class="col-3">
								<input type="" name="" class="form-control" v-model="fecha_orden" readonly="readonly">
							</div>
						</div>
						<div class="row mt-1">
							<div class="col-3">
								<label>Centro de Responsabilidad:</label>
							</div>
							<div class="col-3">
								<input type="" name="" class="form-control" v-model="centro_res" readonly="readonly">
							</div>
							<div class="col-3">
								<label>Telefono Contacto:</label>
							</div>
							<div class="col-3">
								<input type="" name="" class="form-control" v-model="contacto" readonly="readonly">
							</div>
						</div>
						<div class="row mt-2">
							<div class="col-3">
								<label>Centro de Costo:</label>
							</div>
							<div class="col-3">
								<input type="" name="" class="form-control" v-model="centro_costo" readonly="readonly">
							</div>
							<div class="col-3">
								<label>Precio Total O.T. (Referencial):</label>
							</div>
							<div class="col-3">
								<input type="" name="" class="form-control" v-model="precio_total" readonly="readonly">
							</div>
						</div>
						<div class="row mt-2">
							<div class="col-12">
								<div class="card" >
									<div class="card-header text-white bg-success" >Firmas</div>
									<div class="card-body">
										<div class="row">
											<div class="col-2">
												<label>Centros</label>  
											</div>
											<div class="col-2">
												<label>Firma</label>
											</div>
											<div class="col-6">
												<label> Nombre/Fecha /Hora</label>
											</div>
											<div class="col-2">
												<label> Accion</label>
											</div>
										</div>
										<div class="row" v-show="ver_jefatura">
											<div class="col-2">
												<label>Jefatura Directa</label>  
											</div>
											<div class="col-2">
												<label></label>
											</div>
											<div class="col-6">
												<input type="" name="" class="form-control" v-model="firma_jef_encargado" readonly="readonly">
											</div>
											<div class="col-2">
												<a href="#"><img :src="url_imagen_jef" width="30" height="30"></a>
											</div>
										</div>
										<div class="row">
											<div class="col-2">
												<label>C.C.</label>  
											</div>
											<div class="col-2">
												<input type="" name="" v-model="cc_firmas" class="form-control" readonly="readonly" >
											</div>
											<div class="col-6">
												<input type="" name="" class="form-control" v-model="firma_cc_encargado" readonly="readonly">
											</div>
											<div class="col-2">
												<a href="#"><img :src="url_imagen_cc" width="30" height="30"></a>
											</div>
										</div>
										<div class="row">
											<div class="col-2">
												<label>C.R.</label>  
											</div>
											<div class="col-2">
												<input type="" name=""  class="form-control" v-model="cr_firmas" readonly="readonly" >
											</div>
											<div class="col-6">
												<input type="" name="" class="form-control" v-model="firma_cr_encargado" readonly="readonly">
											</div>
											<div class="col-2">
												<a href="#"><img :src="url_imagen_cr" width="30" height="30"></a>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row mt-2">
							<div class="col-12">
								<div class="card" >
									<div class="card-header text-white bg-info" >PRESUPUESTO</div>
									<div class="card-body">
										<div class="row">
											<div class="col-2">
												<label>CENTROS</label>  
											</div>
											<div class="col-3">
												<label>PPTO</label>  
											</div>
											<div class="col-2">
												<label>GASTOS COMPRO</label>
											</div>
											<div class="col-3">
												<label> SALDO</label>
											</div>
											<div class="col-2">
												<label> GASTADO</label>
											</div>
										</div>
										<div class="row">
											<div class="col-2">
												<label>C.C.</label>  
											</div>
											<div class="col-3">
												<input type="" name="" class="form-control" readonly="readonly"  v-model="presupuesto_cc" style="font-size:20px;">
											</div>
											<div class="col-3">
												<input type="" name="" class="form-control" readonly="readonly" v-model="totalcentros"  style="font-size:20px;">
											</div>
											<div class="col-2">
												<input type="" name="" class="form-control" readonly="readonly" v-model="saldo_cc"  style="font-size:20px;">
											</div>
											<div class="col-2">
												<input type="" name="" class="form-control" readonly="readonly" v-model="porcentaje_cc">
											</div>
										</div>
										<div class="row">
											<div class="col-2">
												<label>C.R.</label>  
											</div>
											<div class="col-3">
												<input type="" name="" class="form-control" readonly="readonly" v-model="presucentros" style="font-size:20px;">
											</div>
											<div class="col-3">
												<input type="" name="" class="form-control" readonly="readonly" v-model="gastocentros" style="font-size:20px;">
											</div>
											<div class="col-2">
												<input type="" name="" class="form-control" readonly="readonly" v-model="saldo_cr" style="font-size:20px;">
											</div>
											<div class="col-2">
												<input type="" name="" v-model="porcentaje_gastado_cr" class="form-control" readonly="readonly">
											</div>
										</div>
										<input type="hidden" name=""  v-model="idcomprar">
										<div class="row">
											<div class="col-12">
												<label class="text-danger">* Nota: Los montos presentados, pertenecen a las cuentas del subtitulo 22.</label>
											</div>
										</div>
										<div class="row mt-2">
											<div class="col-12">
												<v-client-table :columns="columns_productos" v-model="data_productos" :options="options_productos">
													<a slot="pro_id" slot-scope="props" >
														{{props.index}}
													</a>  
													<a slot="pro_descripcion"  slot-scope="{row, update, setEditing, isEditing, revertValue}">
														<span @click="setEditing(true)" v-if="!isEditing()">
															{{row.pro_descripcion}}
														</span>
														<span v-else>
															<textarea v-model="row.pro_descripcion" class="form-control" cols="400" rows="15">
															</textarea>
															<button type="button" class="btn btn-info btn-xs" @click="updatedescripcion(row.pro_id,row.pro_descripcion,row.pro_id_oc,row.pro_justificacion); setEditing(false)">Actualizar</button>
															<button type="button" class="btn btn-default btn-xs" @click="revertValue(); setEditing(false)">Cancelar</button>
														</span>
													</a>
													<a slot="pro_justificacion"  slot-scope="{row, update, setEditing, isEditing, revertValue}">
														<span @click="setEditing(true)" v-if="!isEditing()">
															{{row.pro_justificacion}}
														</span>
														<span v-else>
															<textarea v-model="row.pro_justificacion" class="form-control" cols="500" rows="15">
															</textarea>
															<button type="button" class="btn btn-info btn-xs" @click="updatedescripcion(row.pro_id,row.pro_descripcion,row.pro_id_oc,row.pro_justificacion); setEditing(false)">Actualizar</button>
															<button type="button" class="btn btn-default btn-xs" @click="revertValue(); setEditing(false)">Cancelar</button>
														</span>
													</a>
													<a slot="accionnes" slot-scope="props">
														<a @click="eliminarproducto(props.row.pro_id,props.row.pro_nombre_producto,props.row.pro_id_oc)"><img :src="'../assets/img/eliminar.png'" width="30" height="30"></a>
													</a>
													<a slot="adjunto" slot-scope="props" >
														<a href="#"> <img :src="'../assets/img/pdf.png'" width="50" height="50" @click="verPdf(props.row.pro_id)"></a>
													</a>
												</v-client-table>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary">Autorizar</button>
						<button type="button" class="btn btn-danger">Cancelar</button>
						<button type="button" class="btn btn-success">Actualizar</button>
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
					</div>
				</div>
			</div>
		</div>
		<BlockUI :message="msg"  v-if="bloqueo">
			<img :src="'../assets/img/745.gif'">

		</BlockUI>


	</div>

</template>
<script>

	export default {
		props: ['id_session','cr','sub_cc'],

		data(){

			return {
				totalcompras:'',
				cc_firmas:'',
				cr_firmas:'',
				firma_jef_encargado:'',
				firma_cr_encargado:'',
				url_imagen_jef:'../assets/img/cruzado.png',
				url_imagen_cc:'../assets/img/cruzado.png',
				url_imagen_cr:'../assets/img/cruzado.png',
				firma_cc_encargado:'',
				ver_jefatura:false,
				columns: ['cc_nombre', 'compra_numero', 'compra_amio','fondo','accion'],
				data: [],
				options: {
					perPage: 15,
					texts: {
						count: "Mostrando {from} a {to} de {count} registros|{count} registros|Un registro",
						first: 'Primero',
						last: 'Ultimo',
						filter: "Busqueda:",
						filterPlaceholder: "Registro a Buscar",
						limit: "Limite de registros:",
						page: "Pagina:",
						noResults: "No hay registros coincidentes",
						filterBy: "Filtrado por {column}",
						loading: 'Cargando...',
						defaultOption: 'Seleccionar {column}',
						columns: 'Columnas',
					},
					sortIcon: {
						is: "glyphicon-sort",
						base: "glyphicon",
						up: "glyphicon-chevron-up",
						down: "glyphicon-chevron-down"
					},
					headings: {
						cc_nombre: 'Centro de Costo',
						compra_numero: 'N°',                 
						compra_amio: 'Año', 
						fondo:'Categoria' ,
						accion:'Acciones'                    

					},
					sortable:  ['cc_nombre', 'nombre'],
					filterable: ['cc_nombre', 'nombre'],
				},
				porcentaje_cc:'',
				saldo_cc:'',
				totalcentros:'',
				presupuesto_cc:'',
				totalcentros_1:'',
				presupuesto_cc_1:'',
				bloqueo:false,
				msg: 'Espere un Momento...',
				isLoading: false,
				fullPage: true,
				porcentaje_gastado_cr:'',
				saldo_cr:'',
				gastocentros_1:'',
				presucentros_1:'',
				gastocentros:'',
				presucentros:'',
				id_cc_cr:'',
				idcomprar:'',
				precio_total:'',
				nombre_usuario:'',
				fecha_orden:'',
				centro_res:'',
				contacto:'',
				centro_costo:'',
				year:'',
				numero:'',
				cr_cc:'',
				columns_productos_sub2: ['pro_id', 'pro_nombre_producto', 'pro_uindad_medida','pro_cantidad','pro_precio','pro_descripcion','pro_justificacion','adjunto','accionnes'],
				data_productos_sub2:[],
				options_productos_sub2: {
					perPage: 15,
					texts: {
						count: "Mostrando {from} a {to} de {count} registros|{count} registros|Un registro",
						first: 'Primero',
						last: 'Ultimo',
						filter: "Busqueda:",
						filterPlaceholder: "Registro a Buscar",
						limit: "Limite de registros:",
						page: "Pagina:",
						noResults: "No hay registros coincidentes",
						filterBy: "Filtrado por {column}",
						loading: 'Cargando...',
						defaultOption: 'Seleccionar {column}',
						columns: 'Columnas',
					},
					sortIcon: {
						is: "glyphicon-sort",
						base: "glyphicon",
						up: "glyphicon-chevron-up",
						down: "glyphicon-chevron-down"
					},
					headings: {
						pro_id: 'N°',
						pro_nombre_producto: 'Producto',                 
						pro_uindad_medida: 'U.M', 
						pro_cantidad:'Cantidad' ,
						pro_precio:'Precio',
						pro_descripcion:'Descripcion',
						pro_justificacion:'Justificacion',
						adjunto:'Adjunto',
						acciones:'Accion'


					},
					sortable:  ['cc_nombre', 'nombre'],
					filterable: ['cc_nombre', 'nombre'],
				},
				columns_productos_sub1: ['pro_id', 'pro_nombre_producto', 'pro_uindad_medida','pro_cantidad','pro_precio','pro_descripcion','pro_justificacion','adjunto','accionnes'],
				data_productos_sub1:[],
				options_productos_sub1: {
					perPage: 15,
					texts: {
						count: "Mostrando {from} a {to} de {count} registros|{count} registros|Un registro",
						first: 'Primero',
						last: 'Ultimo',
						filter: "Busqueda:",
						filterPlaceholder: "Registro a Buscar",
						limit: "Limite de registros:",
						page: "Pagina:",
						noResults: "No hay registros coincidentes",
						filterBy: "Filtrado por {column}",
						loading: 'Cargando...',
						defaultOption: 'Seleccionar {column}',
						columns: 'Columnas',
					},
					sortIcon: {
						is: "glyphicon-sort",
						base: "glyphicon",
						up: "glyphicon-chevron-up",
						down: "glyphicon-chevron-down"
					},
					headings: {
						pro_id: 'N°',
						pro_nombre_producto: 'Producto',                 
						pro_uindad_medida: 'U.M', 
						pro_cantidad:'Cantidad' ,
						pro_precio:'Precio',
						pro_descripcion:'Descripcion',
						pro_justificacion:'Justificacion',
						adjunto:'Adjunto',
						acciones:'Accion'


					},
					sortable:  ['cc_nombre', 'nombre'],
					filterable: ['cc_nombre', 'nombre'],
				},
				columns_productos_sub: ['compra_numero', 'compra_amio', 'cc_nombre','compra_proyecto','estado_nombre','acciones'],
				data_productos_sub:[],
				options_productos_sub: {
					perPage: 15,
					texts: {
						count: "Mostrando {from} a {to} de {count} registros|{count} registros|Un registro",
						first: 'Primero',
						last: 'Ultimo',
						filter: "Busqueda:",
						filterPlaceholder: "Registro a Buscar",
						limit: "Limite de registros:",
						page: "Pagina:",
						noResults: "No hay registros coincidentes",
						filterBy: "Filtrado por {column}",
						loading: 'Cargando...',
						defaultOption: 'Seleccionar {column}',
						columns: 'Columnas',
					},
					sortIcon: {
						is: "glyphicon-sort",
						base: "glyphicon",
						up: "glyphicon-chevron-up",
						down: "glyphicon-chevron-down"
					},
					headings: {
						compra_numero: 'N°',
						compra_amio: 'AÑO',                 
						cc_nombre: 'Centros de Costos', 
						compra_proyecto:'Proyecto',
						estado_nombre:'Estado',						
						acciones:'Accion'


					},
					sortable:  ['cc_nombre', 'nombre'],
					filterable: ['cc_nombre', 'nombre'],
				},
				titulomodal:'',
				devol:[],
				viaticos_jt:'',
				id_categoria:'',
				categoria:'',
				columns_productos: ['pro_id', 'pro_nombre_producto', 'pro_uindad_medida','pro_cantidad','pro_precio','pro_descripcion','pro_justificacion','adjunto','accionnes'],
				data_productos:[],
				options_productos: {
					perPage: 15,
					texts: {
						count: "Mostrando {from} a {to} de {count} registros|{count} registros|Un registro",
						first: 'Primero',
						last: 'Ultimo',
						filter: "Busqueda:",
						filterPlaceholder: "Registro a Buscar",
						limit: "Limite de registros:",
						page: "Pagina:",
						noResults: "No hay registros coincidentes",
						filterBy: "Filtrado por {column}",
						loading: 'Cargando...',
						defaultOption: 'Seleccionar {column}',
						columns: 'Columnas',
					},
					sortIcon: {
						is: "glyphicon-sort",
						base: "glyphicon",
						up: "glyphicon-chevron-up",
						down: "glyphicon-chevron-down"
					},
					headings: {
						pro_id: 'N°',
						pro_nombre_producto: 'Producto',                 
						pro_uindad_medida: 'U.M', 
						pro_cantidad:'Cantidad' ,
						pro_precio:'Precio',
						pro_descripcion:'Descripcion',
						pro_justificacion:'Justificacion',
						adjunto:'Adjunto',
						acciones:'Accion'


					},
					sortable:  ['pro_id', 'pro_nombre_producto'],
					filterable: ['pro_id', 'pro_nombre_producto'],
					editableColumns:['pro_descripcion','pro_justificacion']
				},



			}

		},
		created:function(){
			this.getcrrut();
			this.getAgregarNombre();


		},
		mounted(){

        this.getTotalcc();
		},
		methods:{

			getTotalcc(){
				this.bloqueo=true;
				if(this.cr == 1){
					var id_cc_sub2=14;

				}else  if(this.cr == 3){
                   var 	id_cc_sub2=138;
				}else{
					var id_cc_sub2=0;
				}

				var d={
					id_sub:this.cr,
					id_cc_sub:this.sub_cc,
					id_cc_sub2:id_cc_sub2
				}

				axios.post('../ot_por_asignar',d).then(response=>{
					let ins=this;
					if(response.data != ''){
						ins.data_productos_sub=response.data
                        this.totalcompras=response.data.length;
                        this.bloqueo=false;

					}else{
						this.totalcompras=0;
						this.bloqueo=false;
					}					

				});

			},
			getFirmas(id){


				axios.get('../firmas/'+id).then(response=>{
					if(response.data !=''){
						this.ver_jefatura=true;
						this.firma_jef_encargado=response.data[0].nombre_aprobar+'  '+response.data[0].fecha_de_aprobado_o_rechazado;
						this.url_imagen_jef='../assets/img/check.png';
					}

				});

			},
			getNombreusuario(id,fecha,cc,cr){
				axios.get('../persona/'+id).then(response=>{
					if(response.data != ''){

						if(cc == 1){
							this.url_imagen_cc='';
							this.firma_cc_encargado=response.data[0].per_nombre+'   '+fecha;
							this.url_imagen_cc='../assets/img/check.png';

						}else{
							this.url_imagen_cr='';
							this.firma_cr_encargado=response.data[0].per_nombre+'   '+fecha;
							this.url_imagen_cr='../assets/img/check.png';

						}

					}

				});
				

			},
			visualizar(numero,id,year,nombre,usuario,cr_nombre,contacto,fecha,id_compra,id_cc_cr,id_cc,rut_encargado,fecha_compra,rut_cr,fecha_sub){
				this.bloqueo=true;
				setTimeout(()=>{

					this.titulomodal='Solicitud de Compra';
					this.year=year;
					this.numero=numero;
					this.centro_costo=nombre;
					this.cc_firmas=nombre;
					this.cr_firmas=cr_nombre;
					this.centro_res=cr_nombre;
					this.nombre_usuario=usuario;
					this.contacto=contacto;
					this.fecha_orden=fecha;
					this.idcomprar=id_compra;
					this.id_cc_cr=id_cc_cr;

					if(rut_encargado != null){

						var nombre_func=this.getNombreusuario(rut_encargado,fecha_compra,1,0);
					}

					if(rut_cr != null){

					this.getNombreusuario(rut_cr,fecha_sub,0,1);

					}
					this.getPresupuesto(id_cc_cr,id_cc);     

					this.getProductos(id_compra);
					this.getFirmas(id_compra);

					;} , 3000);

				$("#modalaceptar").modal();

			},
			getAgregarNombre(){
				if(this.cr == 1){
					this.cr_cc="DIRECCION"
				}else if(this.cr == 2){
					this.cr_cc="SDRFYF";

				}else if(this.cr == 3){
					this.cr_cc="SDGA";
				}else if(this.cr == 4){
					this.cr_cc="SDRRHH";

				}
				
			},
			async  getcrrut(){
				if(this.cr == 1){
					var id_cc_sub2=14;

				}else  if(this.cr == 3){
                   var 	id_cc_sub2=138;
				}else{
					var id_cc_sub2=0;
				}

				var d={
					id_sub:this.cr,
					id_cc_sub:this.sub_cc,
					id_cc_sub2:id_cc_sub2
				}

				await axios.post('../ot_por_asignar',d).then(response=>{
					let ins=this;
					if(response.data != ''){
						ins.data_productos_sub=response.data

					}else{
						axios.get('../ot_aprobar_persona/'+this.id_session).then(response2=>{
                                ins.data_productos=response2.data;
						});

					}					

				});
			},
			formatPrice(value) {
				let val = (value/1).toFixed(0).replace('.', '.')
				return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
			},    getCalculo_2(id,id2){
				var cal=(id2/id)*100;



				return cal;

			},

			getCalculo_1(id,id2){

				var cal=id-id2;

				return cal;

			},
			getProductos(id){

				axios.get('../productos/'+id).then(response=>{

					this.data_productos=response.data;
					for (var i = 0; i < this.data_productos.length; i++) {
						this.precio_total='$'+this.data_productos[i].pro_total;
					}

				});

			},
			verPdf(idpro){
				axios.get('../ajuntos_ot/'+this.idcomprar).then(response=>{
					console.log(response.data);

					if(response.data.length === 0){
						Swal.fire(
							'No existe!',
							'No existe documentos adjuntos!',
							'error'
							)

					}else{

						for (var i = 0; i < response.data.length; i++) {

							var fecha=response.data[i].adj_fecha.split("-");
							var y=fecha[0];
							var m=fecha[1];

							var nombre= response.data[i].adj_nombre;
						}
						window.open('../../PDFS/'+y+'/'+m+'/'+nombre,'_blank');

					}

				});

			},

			getPresupuesto(id,id_cc){
				axios.get('../presucentros/'+id).then(response=>{
					this.presucentros='$'+ this.formatPrice(response.data);
					this.presucentros_1=response.data;

					axios.get('../gastocentros/'+id).then(response1=>{
						this.gastocentros_1=response1.data;
						this.gastocentros='$'+ this.formatPrice(response1.data);

						this.saldo_cr=this.presucentros_1-this.gastocentros_1;
						this.porcentaje_gastado_cr = this.getCalculo_2(this.presucentros_1,this.gastocentros_1);

						this.saldo_cr='$'+this.formatPrice(this.saldo_cr);
						this.porcentaje_gastado_cr='% '+ Math.round(this.porcentaje_gastado_cr);

						axios.get('../presupustoscentros/'+id_cc).then(response2=>{
							this.presupuesto_cc=response2.data;
							this.presupuesto_cc='$ '+this.formatPrice(this.presupuesto_cc);
							this.presupuesto_cc_1=response2.data;

							axios.get('../totalcentros/'+id_cc).then(response3=>{
								console.log('totalcentros',response3.data[0]['total']);
								this.totalcentros='$ '+this.formatPrice(response3.data[0]['total']);
								this.totalcentros_1=response3.data[0]['total'];

								this.saldo_cc= this.presupuesto_cc_1-response3.data[0]['total'];
								this.saldo_cc='$ '+this.formatPrice(this.saldo_cc);

								this.porcentaje_cc='% '+Math.round(this.getCalculo_2(this.presupuesto_cc_1,response3.data[0]['total']) );

								this.bloqueo=false;
							});




						});



					});


				});



			},
		}

	}

</script>