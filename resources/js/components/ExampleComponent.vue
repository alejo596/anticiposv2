<template>
  <div class="container">
    <div class="row justify-content">
      <div class="col-md-12">
        <div class="card mt-5">
          <div class="card-header">
           <h2>Solicitudes Centro de Costos(Ordenes de Compras)</h2>
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
              <button class="btn btn-success" @click="visualizar(props.row.compra_numero,props.row.compra_id,props.row.compra_amio,props.row.cc_nombre,props.row.per_nombre,props.row.cr_nombre,props.row.compra_telefono,props.row.compra_fecha_guardada,props.row.compra_id,props.row.cc_cr_id,props.row.id_cc)">Visualizar</button>

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
         <div class="row">
          <div class="col-2">
           <label>C.C.</label>  
         </div>
         <div class="col-2">
          <label>informatica</label>
        </div>
        <div class="col-6">
         <input type="" name="" class="form-control" readonly="readonly">
       </div>   
       <div class="col-2">
         <a href="#"><img :src="'../assets/img/cruzado.png'" width="30" height="30"></a>
       </div>  


     </div>

     <div class="row">
      <div class="col-2">
       <label>C.R.</label>  
     </div>
     <div class="col-2">
      <label>SDRFYF</label>
    </div>
    <div class="col-6">
     <input type="" name="" class="form-control" readonly="readonly">
   </div>  
   <div class="col-2">
    <a href="#"><img :src="'../assets/img/cruzado.png'" width="30" height="30"></a>

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
  props: ['id_session'],
  
  data(){

    return {
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
        sortable:  ['pro_id', 'pro_nombre_producto'],
        filterable: ['pro_id', 'pro_nombre_producto'],
        editableColumns:['pro_descripcion','pro_justificacion']
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
    eliminarproducto(id,nombre,id_cc){
      axios.get('../productos/'+id_cc).then(response1=>{
        console.log(response1.data.length);

        if(response1.data.length > 1){
         Swal.fire({
          title: 'Desea Eliminar El Producto '+nombre+'?',          
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Aceptar'
        }).then((result) => {
          if (result.isConfirmed) {
            this.bloqueo=true;

            axios.post('../productoupdate',id).then(response=>{
              this.getProductos(id_cc);
                this.bloqueo=false;
              Swal.fire(
                'Excelente !',
                'Se Elimino el producto!',
                'success'
                )
            



            });

          }

        });


      }else{
       Swal.fire({
        title: 'Si Eliminar El Producto se Anular La OT '+ this.numero,          
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Aceptar'
      }).then((result) => {
        if (result.isConfirmed) {
          this.bloqueo=true;
             axios.post('../productoupdate',id).then(response=>{

           var da={
            compra_id:id_cc,
            compra_estado:8

          }
          var url2='ordenesdecompra/'+id_cc;
          axios.put(url2,da).then(response2=>{
           $("#modalaceptar").modal('hide');
           this.bloqueo=false;
           this.getCentroCosto();

         });
        });

        }

      });




    }


  });

      



    },
    updatedescripcion(id,descripcion,id_cc,pro_justificacion){

      var d={
        pro_id:id,
        pro_descripcion:descripcion,
        pro_justificacion:pro_justificacion

      }
      var url='productos/'+id;
      this.bloqueo=true;
      axios.put(url,d).then(response=>{
        this.getProductos(id_cc);
        this.bloqueo=false;

      });

    },
    formatPrice(value) {
      let val = (value/1).toFixed(0).replace('.', '.')
      return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
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
    getGasto(id){

    },
    getCalculo_2(id,id2){
      var cal=(id2/id)*100;



      return cal;

    },

    getCalculo_1(id,id2){

      var cal=id-id2;

      return cal;

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
    visualizar(numero,id,year,nombre,usuario,cr_nombre,contacto,fecha,id_compra,id_cc_cr,id_cc){
      this.bloqueo=true;
      setTimeout(()=>{

        if(this.ct_l == 0){
          this.titulomodal='Solicitud de Compra';
          this.year=year;
          this.numero=numero;
          this.centro_costo=nombre;
          this.centro_res=cr_nombre;
          this.nombre_usuario=usuario;
          this.contacto=contacto;
          this.fecha_orden=fecha;
          this.idcomprar=id_compra;
          this.id_cc_cr=id_cc_cr;

        }

        this.getPresupuesto(id_cc_cr,id_cc);      

        this.getProductos(id_compra);



        ;} , 3000);

      $("#modalaceptar").modal();

      



    },
    getProductos(id){

      axios.get('../productos/'+id).then(response=>{

        this.data_productos=response.data;
        for (var i = 0; i < this.data_productos.length; i++) {
          this.precio_total='$'+this.data_productos[i].pro_total;
        }

      });

    },
    getEncargados_cc(){
      axios.get('../encargados_cc/'+this.id_session).then(response=>{
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

    axios.get('../viaticos_jt/'+this.id_session).then(response=>{
      this.data=response.data;
      this.categoria="Viaticos";
    }); 
  },
  getFondo(){

   axios.get('../fondo_j/'+this.id_session).then(response=>{
     this.data=response.data;
     this.categoria="Solicitudes Fondo Fijos";

   });
 },
 getFondo_rendicion(){

 },       
 getCentroCosto(){

  axios.get('../centro_jt/'+this.id_session).then(response=>{
    this.data=response.data;
    this.categoria="Ordenes de Compras";
    console.log(response.data[0].id_cc);

  });
}
},
created:function(){

  this.getCentroCosto();

},

}
</script>
