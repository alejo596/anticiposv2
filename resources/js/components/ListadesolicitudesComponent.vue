<template>
	<div >
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

				<button @click="modaleditarestado(props.row.id,props.row.unidad_negocio)"class="btn btn-success" v-if="props.row.estado==4" >Enviar</button>	

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
		<div class="modal fade" id="ModalPDF" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLongTitle">Documentos</h5>
						<button type="button" class="close btn btn-danger" data-dismiss="modal" aria-label="Close" >
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<object class="PDFdoc" width="100%" height="500px" type="application/pdf" :data="'../storage/app/'+url_pdf"></object>
					</div>

					<div class="modal-footer">
						<a type="button" class="btn btn-primary" download="documentos.pdf" :href="'../storage/app/'+url_pdf"><i class="far fa-file-pdf ml-1 text-white"></i>Descargar</a>
						<button type="button" class="btn btn-secondary" data-dismiss="modal" >Cerrar</button>

					</div>
				</div>
			</div>
		</div>
		<BlockUI :message="msg"  v-if="bloqueo">
			<img :src="'assets/img/745.gif'">

		</BlockUI>
		
	</div>
	
</template>
<script>
	export default 
	{
		props: ['id_session','name'],

		data()
		{

			return {
				bloqueo:false,
						msg:'Espere un momento....',
						url_pdf:'',
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
		} ,
		mounted()
		{

		},
		created:function()
		{
			this.getfondofijo_i();

		},
		methods:
		{
			getfondofijo_i()
			{
				axios.get('solicitudes_ff').then(response=>{
					this.data=response.data;

				});

			},
			formatPrice(value) 
			{
				let val = (value/1).toFixed(0).replace('.', '.')
				return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
			},
			verpdf(id){
				alert(id);
				this.url_pdf='';
				this.url_pdf=id;
				$("#ModalPDF").modal("show");

			},


		}	

	} 
	
</script>