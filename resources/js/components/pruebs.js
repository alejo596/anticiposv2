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
					return this.dulcealert('No existen rendiciones');

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
						var d=new FormData();
						d.append('total',this.monto_total_envio);
						d.append('descuento',this.monto_descuento);
						d.append('despacho',0);
						d.append('impuesto',0);
						d.append('oc',0);
						d.append('proveedor',this.idprofia);						
						d.append('tipo',5);
						d.append('estado',1);
						d.append('iva',0);
						d.append('observacion','creado por fondo fijo anticipo N°'+id);
						d.append('year',añoActual);
						d.append('usuario',this.id_session);
						
						axios.post('cpp',d).then(response1=>{
							this.addproductos(response1.data,5)
							this.addcppanticipos(response1.data,id)
							this.updatefondo(id,response1.data)
							this.addfirma(id)

						}).catch(err=>{

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

		});

	},
	addcppanticipos(cpp,anticipo)
	{
		var anti=new FormData();
		anti.append('cpp',cpp);
		anti.append('anticipo',anticipos);
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
				p.append('cuenta',i)
				p.append('total',this.rendiciones_cpp[i].monto)
				p.append('unidad','UD')
				p.append('nombre_sigfe',null)
				p.append('nombre_producto',this.rendiciones_cpp[i].produNombre)
				p.append('sub_item_sigfe',null)
				p.append('estado',0)
				p.append('justificacion',null)
				p.append('cc',this.rendiciones_cpp[i].cc_id)
				p.append('convenio',0)
				p.append('precio_todo',this.rendiciones_cpp[i].monto)
				p.append('pro_id_cpp',id)
				p.append('pro_precio_unitario',this.rendiciones_cpp[i].monto)
				p.append('pro_cantidad_unitario',this.rendiciones_cpp[i].cantidad_producto)
				p.append('sigfe_item',null)
				p.append('zgen',0)
				p.append('oc',0) 
				axios.post('productos',p).then( respo=>{	
					this.addarchivos(respo.data,this.rendiciones_cpp[i].url,this.rendiciones_cpp[i].nombre_archivo,tipo,id)


				});

			}

		}

	},
	addarchivos(id,url,nombrearchivo,tipo,numero){
		var d=new FormData(),
		d.append('nombre',nombrearchivo)
		d.append('url',url)
		d.append('tipo',tipo)
		d.append('id',numero)

		axios.post('',d).then(response=>{

		}).catch(err=>{

		});


	}