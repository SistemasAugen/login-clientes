<template>
	<div class="row">
		<div class="col-md-offset-1 col-md-10">

			<div class="panel panel-primary" data-collapsed="0">

				<div class="panel-heading">
					<div class="panel-title">
						<i class="fas fa-tags"></i> Productos  <span v-if="id"> - {{ producto.sku }} | {{ producto.name }}</span>
					</div>
					<div class="panel-options">
						<a @click="$router.push('/products/')"><i class="fas fa-times"></i></a>
					</div>
				</div>

				<div class="panel-body">
					

					<div id="tabs">
						<ul class="nav nav-tabs">
							<li :class="activeInfo"><a @click="active = 1" href="#1" data-toggle="tab">Información</a></li>
							<li :class="activeImages"><a @click="active = 2" href="#2" data-toggle="tab">Galeria</a></li>
						</ul>


						<div class="tab-content">

							<div :class=" 'tab-pane ' + activeInfo" id="1">
								<form role="form" class="form-horizontal" @submit.prevent="newProducto($event.target)">

									<div class="form-group">
										<div class="col-sm-3">
											<label class="col-sm-12 control-label">Imagen principal</label>
										</div>
										<div class="col-sm-9">
												<div class="fileinput fileinput-new" data-provides="fileinput">
												<div class="fileinput-new thumbnail" style="width: 200px; height: 150px;" data-trigger="fileinput">
													<img :src="producto.imageUrl" alt="..." v-if="id!=''">
													<img src="//placehold.it/200x150?text=Imagen" alt="..." v-else>
												</div>
												<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 400px; max-height: 300px"></div>
												<div>
													<span class="btn btn-white btn-file">
														<span class="fileinput-new">Select image</span>
														<span class="fileinput-exists">Change</span>
														<input type="file" accept="image/*" name="image">
													</span>
													<a href="#" class="btn btn-orange fileinput-exists" data-dismiss="fileinput">Remove</a>
												</div>
											</div>

										</div>
									</div>

									<input-form name="sku" text="SKU" :data.sync="producto.sku" validate="required"></input-form>
									<input-form name="nombre" text="Nombre" :data.sync="producto.name" validate="required"></input-form>

									<div class="form-group">
										<label for="editor2" class="col-sm-3 control-label">Descripción</label>
										<div class="col-sm-7">
											<vue-editor id="editor2" v-model="producto.description"
												:editor-toolbar="[['bold', 'italic', 'underline'],[{ list: 'ordered' }, { list: 'bullet' }]]">
											</vue-editor>
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-3 control-label">Categoria:</label>
										<div class="col-sm-7">
											<v-select v-model="producto.categories_id" :options="categories" label="name" index="id" @change="getSubcategories();" multiple/>
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-3 control-label">Subcategoria:</label>
										<div class="col-sm-7">
											<v-select v-model="producto.subcategories_id" :options="subcategories" label="name" index="id" multiple/>
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-3 control-label">Marca:</label>
										<div class="col-sm-7">
											<v-select v-model="producto.brands_id" :options="brands" label="name" index="id" />
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-3 control-label">Raza:</label>
										<div class="col-sm-7">
											<v-select v-model="producto.breeds_id" :options="breeds" label="name" index="id"  multiple/>
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-3 control-label">PDF</label>
											<div class="col-sm-2">
												<div class="fileinput fileinput-new" data-provides="fileinput">
													<div class="fileinput-new thumbnail" style="max-width: 200px; max-height: 150px" data-trigger="fileinput">
														<span v-if="producto.documentUrl!=''">{{ producto.documentUrl }}</span>
														<span v-else>Documento</span>
													</div>
													<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px"></div>
													<div>
														<span class="btn btn-white btn-file">
															<span class="fileinput-new">Selecccionar Documento</span>
															<span class="fileinput-exists">Cambiar</span>
															<input type="file" accept=".pdf" name="document">
														</span>
														<a href="#" class="btn btn-orange fileinput-exists" data-dismiss="fileinput">Quitar</a>
													</div>
												</div>
											</div>
											<div class="col-sm-1" v-if="producto.documentUrl">
												<a :href=" producto.documentUrl" target="_blank"><span class="btn btn-info" ><i class="fas fa-cloud-download-alt"></i></span></a>
												
												<label>DESCARGAR</label>
											</div>
									</div>

									<p style="text-align: center;">Dimensiones</p>

									<input-form name="high" text="Alto(cm)" type="number" :data.sync="producto.high"></input-form>
									<input-form name="long" text="Largo(cm)" type="number" :data.sync="producto.long"></input-form>
									<input-form name="width" text="Ancho(cm)" type="number" :data.sync="producto.width"></input-form>
									<input-form name="weigth" text="Peso(kg)" type="number" :data.sync="producto.weigth"></input-form>
									<div class="form-group">
										<div class="col-sm-12">
											<button type="submit" class="btn btn-success pull-right"><i class="far fa-save"></i>
												Guardar</button>
											<button type="button" class="btn btn-default pull-right"
												@click="$router.push('/products/')">Cancelar</button>
										</div>
									</div>

								</form>
							</div>
							<div :class=" 'tab-pane ' + activeImages" id="2">
                                <vue-dropzone ref="VueDropzone" id="dropzone" :options="dropzoneOptions" @vdropzone-complete="onUpload" :useCustomSlot=true>
									<div class="dropzone-custom-content">
										<h4 class="dropzone-custom-title">Suelta tus archivos aquí para subirlos</h4>
										
									</div>
								</vue-dropzone>
									<br><br>
								<table v-if="producto.images.length > 0" id="tableproducts">
										<tr>
											<th>Imagen</th>
											<th>Eliminar</th>
										</tr>
										<tr v-for="(image, index) in producto.images" :key="index">
											<td><img :src="image.url" class="img-thumbnail" width="100"></td>
													
											<td><button  class="btn btn-danger" @click="deleteImage(image.id)"><i class="fa fa-times"></i></button></td>
										</tr>
								</table>
                            </div>

						</div>
					</div>	




				</div>
			</div>
		</div>

	</div>
</template>
<script type="text/javascript">
	export default {
		data(){
			return {
				producto:{
					name: '',
					sku: '',
					description: '',

					high:null,
					long:null,
					width:null,
					weigth:null,
					brands_id:null,

					categories_id:[],
					subcategories_id:[],
					breeds_id:[],
					images:[]
					
				},

				categories: [],
				subcategories: [],
				brands:[],
				breeds:[],
				
				id: '',
				check:false,
				active:1,

				dropzoneOptions: {
		     		url: tools.url('/api/admin/dropzone/productsImage/' + this.$route.params.id),
		            acceptedFiles:'image/*',
		            uploadMultiple:false,
		            maxFilesize:25,
                    withCredentials:false,
		        },
			}
		},

		computed:{
			activeInfo: function()
			{
				return (this.active == 1) ? 'active' : '';
			},

			activeImages: function()
			{
				return (this.active == 2) ? 'active' : '';
			}
		},

		methods:{

			getProducto(){
				axios.get(tools.url("/api/admin/products/"+this.id)).then((response)=>{
			    	this.producto = response.data;
			    }).catch((error)=>{
			    	this.$parent.handleErrors(error);
			    });
			},

			newProducto(form){
				this.$parent.validateAll(()=>{
					var data=tools.params(form, this.producto);
					if(this.$route.params.id){
						axios.post(tools.url("/api/admin/products/"+this.id),data).then((response)=>{
					    	this.getProducto();
					    	this.$parent.showMessage("Producto "+ this.producto.name +" modificado correctamente!","success");
					    }).catch((error)=>{
					    	this.$parent.handleErrors(error);
					    });
					}
					else{
						axios.post(tools.url("/api/admin/products"),data).then((response)=>{
							var temp = response.data;
					    	this.$parent.showMessage("Producto "+ temp.name +" agregado correctamente!","success");
					    	this.$router.push('/products/edit/'+temp.id);
					    }).catch((error)=>{
					    	this.$parent.handleErrors(error);
					    });
					}
				},(e)=>{
					console.log(e);
				});
			},

			getCategories(){
				axios.get(tools.url("/api/admin/categories")).then((response)=>{
			    	this.categories = response.data;
			    }).catch((error)=>{
			    	this.$parent.handleErrors(error);
			    });
			},

			getSubcategories(){
				//if(this.producto.categories_id.length > 0){
					axios.post(tools.url("/api/admin/getSubcategories"),{ids:this.producto.categories_id}).then((response)=>{
						this.subcategories = response.data;
					}).catch((error)=>{
			    		this.$parent.handleErrors(error);
			    	});
				//}
			},
			getBreeds(){
				axios.get(tools.url("/api/admin/breeds")).then((response)=>{
					this.breeds = response.data;
				}).catch((error)=>{
				});
			},
			getBrands(){
				axios.get(tools.url("/api/admin/brands")).then((response)=>{
					this.brands = response.data;
				}).catch((error)=>{
				});
			},

			//Manejador de evento onUpload del dropZone
			onUpload(file, response) {
				setTimeout(() => {
		        	let vueDropzone = this.$refs['VueDropzone'];
					vueDropzone.removeFile(file);
					this.getProducto();
				}, 1000);

			},
			//Borrar una image de la galeria del paquete
			deleteImage(id) {
				alertify.confirm("Alerta!","¿Seguro que desea eliminar esta imagen?",() => {
					axios.delete(tools.url("/api/admin/dropzone/productsImage/" + id )).then(result => {
						this.getProducto();
						this.$parent.showMessage(result.data.msg, "success");
					}).catch(error => {
						this.$parent.handleErrors(error);
					});
				}, ()=>{});
			},
		},

		mounted(){
			this.getCategories();
			this.getBreeds();
			this.getBrands();
			if(this.$route.params.id){
				this.id = this.$route.params.id;
				this.getProducto();
				this.getSubcategories(this.producto.category_id);
			}
		}
	}
</script>
<style>
#tableproducts{
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

#tableproducts td  {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}
#tableproducts th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

#tableproducts th {
  background-color: #dddddd;
}
</style>
