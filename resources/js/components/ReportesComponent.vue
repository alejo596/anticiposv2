
<template>
	<div>
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-body">
						<div class="row">							

								<div class="col-md-1 mt-2">
									<label>Centro Costo</label>

								</div>
								<div class="col-md-2 mt-2">
									<input type="text" placeholder="Buscar Centro Costo" v-model="search_centro"  class="form-control" @blur="toggle_centro = false" @focus="toggle_centro = true">
									<div class="results" v-if="toggle_centro"  style="
									z-index: 100000;
									position: absolute;
									background-color: #ffff;
									width: 100%;
									">
									<div class="result" v-for="book in newBooks_centro" >
										<span @click="selectResult_centro(book.cc_id,book.cc_nombre)" @mousedown.prevent>
											{{ book.cc_nombre }}
										</span>
									</div>
								</div> 
								<input type="hidden" name="" v-model="id_personas_centro">

							</div>
							<div class="col-md-1 mt-2">
								<label>Año</label>

							</div>
							<div class="col-md-1 mt-2">
						
								<select name="" id="ano" class="form-control" v-model="year_reporte2">

									<option v-for="y in year_reporte"  :selected="y.year == years ? 'selected' : ''">{{y.year}}</option>


								</select>

							</div>
							<div class="col-md-1 mt-2">
								<label>Mes</label>

							</div>
							<div class="col-md-1 mt-2">
						
								<select name="" id="mes" class="form-control" v-model="mes">

									
									<option value="1" >Enero</option>
									<option value="2" >Febrero</option>
									<option value="3" >Marzo</option>
									<option value="4" >Abril</option>
									<option value="5" >Mayo</option>
									<option value="6" >Junio</option>
									<option value="7" >Julio</option>
									<option value="8" >Agosto</option>
									<option value="9" >Septiembre</option>
									<option value="10" >Octubre</option>
									<option value="11" >Noviembre</option>
									<option value="12" >Diciembre</option>

								</select>

							</div>
							<div class="col-1 mt-2">
								<label>Ultima Rendicion</label>
							</div>
							<div class="col-2 mt-2">
								<select v-model="repor_ultima" class="form-control">
									<option value="1">NO</option>
									<option value="0">SI</option>
								</select>

							</div>
							<div class="col-2 ">
								<button class="btn btn-primary" @click="crearreporte()">Buscar</button>
								<button class="btn btn-info" @click="limpiarreporte()">Limpiar</button>
							</div>

						</div>


					
				</div>

			</div>

		</div>

	</div>
	<div class="row mt-2">
		<div class="col-12">
			<button  class="btn btn-success" @click="exportAsExcel"> Export Excel </button>	
		</div>

	</div>


	<div class="row mt-2">
		<div class="col-12">
			<vue-excel-editor v-model="jsondata"  ref="grid" :readonly="true" filter-row >
				
				<vue-excel-column :init-style="colorcelda" field="year"   label="Año" />
				<vue-excel-column field="mes"   label="Mes" />
				<vue-excel-column field="tipo_compra"  label="Tipo de Compra" />
				<vue-excel-column field="acto" label="Tipo de acto administrativo aprobatorio" />
				<vue-excel-column field="nombre"    label="Denominación del acto administrativo aprobatorio" />
				<vue-excel-column field="fecha_doc"  label="Fecha del acto administrativo aprobatorio del contrato"  />
				<vue-excel-column field="numero_doc"  label="Número del acto administrativo aprobatorio"  />
				<vue-excel-column field="razon_social"  label="Razón social"  />
				<vue-excel-column field="nombre_proveedor"  label="Nombre" width="300px" />
				<vue-excel-column field="apaterno"  label="Apellido paterno"  />
				<vue-excel-column field="amaterno"  label="Apellido materno"  />
				<vue-excel-column field="run"  label="RUT de la persona contratada (si aplica)"  />
				<vue-excel-column field="socios"  label="Socios y accionistas principales  (si corresponde)"  />
				<vue-excel-column field="detalle"  label="Objeto de la contratación o adquisición"  />
				<vue-excel-column field="fecha_doc"  label="Fecha de inicio del contrato (dd/mm/aa)"  />
				<vue-excel-column field="fecha_doc"  label="Fecha de término del contrato (dd/mm/aa)"  />
				<vue-excel-column field="monto"  label="Monto total de la operación"  />
                <vue-excel-column field="unidad"  label="Tipo unidad monetaria"  />
				<vue-excel-column field="observacion"  label="Observaciones"  />
				<vue-excel-column field="url"  label="Enlace al texto integro del contrato "  />
				<vue-excel-column field="enlace"  label="Enlace al texto integro del acto administrativo aprobatorio"  />
				<vue-excel-column field="e_modificacion"  label="Enlace al texto integro del acto administrativo aprobatorio de la modificación"  />				

			</vue-excel-editor>

		</div>

	</div>
	

</div> 
</template>
<style type="text/css">

</style>

<script>
	export default
	{
		data()
		{
			return{
				id_a:'',
				mes:'',
				years:0,
				repor_ultima:1,
				year_reporte2:'',
				year_reporte:[],
				jsondata:[],
				newBooks_centro:[],
				search_centro:'',
				id_personas_centro:'',
				toggle_centro:false,
				colorcelda:{
					color:'blue' 
				}

			}
		},
		watch:{
			search_centro(val) {
				console.log(val);
				this.newBooks_centro = []; 

				axios.get('centros/'+val).then(response=>{
					this.newBooks_centro =response.data;
						this.toggle_centro=true;


				}); 


			},

		},
		created:function(){
        this.getyear();
		},
		mounted(){

			var today = new Date();
            this.years = today.getFullYear();

		},
		methods:{
			getyear(){
				for (var i = 2022; i <= 2025; i++) {

					this.year_reporte.push({'year':i});
					
				}

			},
			exportAsExcel () {
				const format = 'xlsx'
				const exportSelectedOnly = false
				const filename = 'Reporte de Transparencia'
				this.$refs.grid.exportTable(format, exportSelectedOnly, filename)
				var d=new FormData();
				d.append('id',this.id_a);
				d.append('year',this.year_reporte2);
				d.append('mes',this.mes);
				

				axios.get('zipers/'+this.id_a).then(response=>{

				});
			},
			exportAsCsv () {
				const format = 'csv'
				const exportSelectedOnly = true
				const filename = 'test'
				this.$refs.grid.exportTable(format, exportSelectedOnly, filename)
			},
			selectResult_centro(id,nombre,cr_id){
				this.search_centro=nombre;
				this.id_personas_centro=id;
				this.cr_id=cr_id;
				this.toggle_centro=false;

			},
			crearreporte(){
				var r=new FormData();
				r.append('cc',this.id_personas_centro);
				r.append('mes',this.mes);
				r.append('year',this.year_reporte2);
				axios.post('reportes_archivo',r).then(response=>{
					this.jsondata=response.data;
					for (var i = 0; i < this.jsondata.length; i++) {
						this.id_a=this.jsondata[i].anticipo_id;
					}
				}).catch(err=>{

				});
			}

		}
	}
	
</script>