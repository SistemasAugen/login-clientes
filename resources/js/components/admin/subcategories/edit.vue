<template>
	<div class="row">
		<div class="col-md-offset-1 col-md-10">

			<div class="panel panel-primary" data-collapsed="0">

				<div class="panel-heading">
					<div class="panel-title">
						<i class="fas fa-image"></i> Subcategorias
					</div>
					<div class="panel-options">
						<a @click="$router.push('/subcategories/')"><i class="fas fa-times"></i></a>
					</div>
				</div>

				<div class="panel-body">
					<form role="form" class="form-horizontal" @submit.prevent="newSubcategoria($event.target)">

						<input-form name="name" text="Nombre" :data.sync="subcategoria.name"></input-form>

						<div class="form-group">
							<label class="col-sm-3 control-label">Categoria:</label>
							<div class="col-sm-7">
								<v-select v-model="subcategoria.category_id" :options="categories" label="name" index="id"/>
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-3">
								<label class="col-sm-12 control-label">Imagen</label>
							</div>
							<div class="col-sm-9">
									<div class="fileinput fileinput-new" data-provides="fileinput">
									<div class="fileinput-new thumbnail" style="width: 200px; height: 150px;" data-trigger="fileinput">
										<img :src="subcategoria.imageUrl" alt="..." v-if="id!=''">
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
						
						<div class="form-group">
							<div class="col-sm-12">
								<button type="button" class="btn btn-danger" @click="deleteRow" v-show="$route.params.id"><i class="fa fa-trash"></i> Borrar</button>
								<button type="submit" class="btn btn-success pull-right"><i class="far fa-save"></i> Guardar</button>
								<button type="button" class="btn btn-default pull-right" @click="$router.push('/subcategories/')">Cancelar</button>
							</div>
						</div>

					</form>
				</div>
			</div>
		</div>

	</div>
</template>
<script type="text/javascript">
	export default {
		data(){
			return {
				subcategoria:{
					name: '',
					categor_id: null
				},

				categories:[],
				
				id: '',
				check:false
			}
		},
		methods:{

			getSubcategoria(){
				axios.get(tools.url("/api/admin/subcategories/"+this.id)).then((response)=>{
			    	this.subcategoria = response.data;
			    }).catch((error)=>{
			    	this.$parent.handleErrors(error);
			    });
			},

			getCategories(){
				axios.get(tools.url("/api/admin/categories/")).then((response)=>{
			    	this.categories = response.data;
			    }).catch((error)=>{
			    	this.$parent.handleErrors(error);
			    });
			},

			newSubcategoria(form){
				this.$parent.validateAll(()=>{
					var data = tools.params(form, this.subcategoria);
					if(this.$route.params.id){
						axios.post(tools.url("/api/admin/subcategories/"+this.id),data).then((response)=>{
					    	this.getSubcategoria();
					    	this.$parent.showMessage("Subcategoria "+ this.subcategoria.name +" modificada correctamente!","success");
					    }).catch((error)=>{
					    	this.$parent.handleErrors(error);
					    });
					}
					else{
						axios.post(tools.url("/api/admin/subcategories"),data).then((response)=>{
							var temp = response.data;
					    	this.$parent.showMessage("Subcategoria "+ temp.name +" agregado correctamente!","success");
					    	this.$router.push('/subcategories/edit/'+temp.id);
					    }).catch((error)=>{
					    	this.$parent.handleErrors(error);
					    });
					}
				},(e)=>{
					console.log(e);
				});
			},

			deleteRow:function(){
				alertify.confirm("Alerta!","¿Seguro que deseas borrar?",()=>{
					axios.delete(tools.url("/api/admin/subcategories/"+this.id)).then((response)=>{
						this.$parent.showMessage(response.data.msg,"success");
						this.$router.push("/subcategories/");
					}).catch((error)=>{
						this.$parent.handleErrors(error);
					});
				},
				()=>{
				});
			},
		},
		
		mounted(){
			this.getCategories();
			if(this.$route.params.id){
				this.id = this.$route.params.id;
				this.getSubcategoria();
			}
		}
	}
</script>
