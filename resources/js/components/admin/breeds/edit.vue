<template>
	<div class="row">
		<div class="col-md-offset-1 col-md-10">

			<div class="panel panel-primary" data-collapsed="0">

				<div class="panel-heading">
					<div class="panel-title">
						<i class="fas fa-paw"></i> Razas
					</div>
					<div class="panel-options">
						<a @click="$router.push('/breeds/')"><i class="fas fa-times"></i></a>
					</div>
				</div>

				<div class="panel-body">
					<form role="form" class="form-horizontal" @submit.prevent="newRow($event.target)">

						<input-form name="name" text="Nombre" :data.sync="row.name"></input-form>
                        
                        <div class="form-group">
							<div class="col-sm-3">
								<label class="col-sm-12 control-label">Imagen</label>
							</div>
							<div class="col-sm-9">
									<div class="fileinput fileinput-new" data-provides="fileinput">
									<div class="fileinput-new thumbnail" style="width: 200px; height: 150px;" data-trigger="fileinput">
										<img :src="row.imageUrl" alt="..." v-if="id!=''">
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
								<button type="button" class="btn btn-default pull-right" @click="$router.push('/breeds/')">Cancelar</button>
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
				row:{
					name: ''
				},
				
				id: '',
				check:false,
				subbreeds: [],
			}
		},
		methods:{

			getRow(){
				this.$parent.inPetition=true;
				axios.get(tools.url("/api/admin/breeds/"+this.id)).then((response)=>{

			    	this.row = response.data;
					this.$parent.inPetition=false;
					
			    }).catch((error)=>{
			    	this.$parent.handleErrors(error);
			       this.$parent.inPetition=false;
			    });
			},

			newRow(form){
				this.$parent.inPetition=true;
				this.$parent.validateAll(()=>{
					var data=tools.params(form, this.row);
					if(this.$route.params.id){
						axios.post(tools.url("/api/admin/breeds/"+this.id),data)
						.then((response)=>{
					    	this.getRow();
					    	this.$parent.showMessage("Registro modificado correctamente!","success");
					    	this.$parent.inPetition=false;
					    }).catch((error)=>{
					    	this.$parent.handleErrors(error);
					        this.$parent.inPetition=false;
					    });
					}
					else{
						axios.post(tools.url("/api/admin/breeds"),data).then((response)=>{
							var temp = response.data;
					    	this.$parent.showMessage("Registro agregado correctamente!","success");
					    	this.$router.push('/breeds/edit/'+temp.id);
					    	this.$parent.inPetition=false;
					    }).catch((error)=>{
					    	this.$parent.handleErrors(error);
					        this.$parent.inPetition=false;
					    });
					}
				},(e)=>{
					console.log(e);
					this.$parent.inPetition=false;
				});
			},

			deleteRow:function(){
				alertify.confirm("Alerta!","¿Seguro que deseas borrar?",()=>{
					this.$parent.inPetition=true;
					axios.delete(tools.url("/api/admin/breeds/"+this.id))
					.then((response)=>{
						this.$parent.showMessage(response.data.msg,"success");
						this.$router.push("/breeds/");
						this.$parent.inPetition=false;
					})
					.catch((error)=>{
						this.$parent.handleErrors(error);
				        this.$parent.inPetition=false;
					});
				},
				()=>{
				});
			},
		},
		mounted(){
			if(this.$route.params.id){
				this.id=this.$route.params.id;
				this.getRow();
			}
		}
	}
</script>
