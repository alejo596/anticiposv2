<template>
    <div class="container">
        <div class="row justify-content">
            <div class="col-md-12">
                <div class="card mt-5">
                    <div class="card-header">
                     <h2>Solicitudes Centro de Costos(Solcitudes Fondo Fijo)</h2>
                 </div>
            
                <input type="hidden" name="" v-model="ct_l">
                <div class="card-body">
                    <div class="table-responsive">
                        <div v-cloak class="mt-4">
                           <v-client-table :columns="columns" v-model="data" :options="options">
                            <a slot="fondo" slot-scope="props" >

                             {{categoria}}
                         </a>                                            

                         <a slot="accion" slot-scope="props">
                            <button class="btn btn-success" @click="visualizar(props.row.compra_numero,props.row.compra_amio,props.row.estado_nombre,props.row.monto,props.row.fecha_ingresada,props.row.cc_nombre,props.row.fiador_nombre)">Visualizar</button>

                        </a>


                    </v-client-table>

                </div>
            </div>


        </div>


    </div>

</div>
<div class="col-4">

</div>
</div>
<div class="modal" tabindex="-1" role="dialog" id="modalaceptar">
  <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 1200px !important;">
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
        <label>Nombre Fiador:</label>
    </div>
    <div class="col-3">
        <input type="" name="" class="form-control" v-model="nombre_usuario" readonly="readonly">

    </div>
    <div class="col-3">
        <label>Fecha Solicitud:</label>
    </div>
    <div class="col-3">
        <input type="" name="" class="form-control" v-model="fecha_orden" readonly="readonly">

    </div>


</div>
<div class="row mt-1">
    <div class="col-3">
        <label>Monto:</label>
    </div>
    <div class="col-3">
        <input type="" name="" class="form-control" v-model="monto" readonly="readonly">

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
        <label>Estado:</label>
    </div>
    <div class="col-3">
        <input type="" name="" class="form-control" v-model="estado" readonly="readonly">

    </div>


</div>

</div>
<div class="modal-footer">
    <button type="button" class="btn btn-primary">Autorizar</button>
    <button type="button" class="btn btn-danger">Cancelar</button>
    
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
</div>
</div>
</div>
</div>
</div>
</template>

<script>
 export default {
    props: ['id_session'],

    data(){

        return {
            idcomprar:'',
            estado:'',
            nombre_usuario:'',
            fecha_orden:'',
            monto:'',
            contacto:'',
            centro_costo:'',
            year:'',
            numero:'',
            ct_l:0,
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
                sortable:  ['cc_nombre', 'nombre'],
                filterable: ['cc_nombre', 'nombre'],
            },
            titulomodal:'',
            devol:[],
            viaticos_jt:'',
            id_categoria:'',
            categoria:'',
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

        }

    },
    methods:{
        verPdf(idpro){
            axios.get('ajuntos_ot/'+this.idcomprar).then(response=>{
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
                    window.open('../PDFS/'+y+'/'+m+'/'+nombre,'_blank');

                }

            });

        },
        visualizar(numero,year,nombre,monto,fecha,cc_nombre,fiador_nombre){
            if(this.ct_l == 0){
                this.titulomodal='Solicitud Fondo Fijo';
                this.year=year;
                this.numero=numero;
                this.estado=nombre;
                this.centro_costo=cc_nombre;
                this.monto=monto;
                this.nombre_usuario=fiador_nombre;
                //this.contacto=contacto;
                this.fecha_orden=fecha;
                //this.idcomprar=id_compra;

            }

            

            $("#modalaceptar").modal();

        },
        getProductos(id){

            axios.get('productos/'+id).then(response=>{

                this.data_productos=response.data;
                for (var i = 0; i < this.data_productos.length; i++) {
                    this.precio_total='$'+this.data_productos[i].pro_total;
                }

            });

        },
        getEncargados_cc(){
            axios.get('encargados_cc/'+this.id_session).then(response=>{
               return this.devol=response.data;

           });


        },
        elegircategoria(event){
            this.data=[];
            if(this.id_categoria == 1){
                this.ct_l=0;
                this.getCentroCosto();

            }else if(this.id_categoria == 2){
               this.ct_l=1;
               this.getViaticos();


           }else if(this.id_categoria == 3){
               this.ct_l=2;
               this.getFondo();

           }else if(this.id_categoria == 4){
               this.ct_l=3;
               this.getFondo_rendicion();

           }

       },
       getViaticos(){   

        axios.get('viaticos_jt/'+this.id_session).then(response=>{
            this.data=response.data;
            this.categoria="Viaticos";
        }); 
    },
    getFondo(){

       axios.get('fondo_j/'+this.id_session).then(response=>{
           this.data=response.data;
           this.categoria="Solicitudes Fondo Fijos";

       });
   },
   getFondo_rendicion(){

   },       
   getCentroCosto(){

    axios.get('centro_jt/'+this.id_session).then(response=>{
        this.data=response.data;
        this.categoria="Ordenes de Compras";
        console.log(response.data[0].id_cc);

    });
}
},
created:function(){

    this.getFondo();

},

}
</script>
