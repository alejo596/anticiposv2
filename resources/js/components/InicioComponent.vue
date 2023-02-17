<template>
	<div class="container">
		<div class="card">
			<div class="card-body">
				<div class="row">
					<div class="col-12">
						<h3>Bienvendo al sistema de Fondos Fijos Don(a): {{name}}</h3>

						<div class="d-flex justify-content-center">
							<img :src="'assets/img/fondo.png'">
						</div>
						
					</div>
					
				</div>
				
			</div>
			
		</div>
		
	</div>
	
</template>
<script>
	export default {
	props: ['id_session','name'],

		data(){

			return {

                    }
               }     
	  }
</script>