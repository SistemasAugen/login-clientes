<template>
	<div class="row">
		<div class="col-md-offset-1 col-md-10">
			
			<div class="panel panel-primary" data-collapsed="0">
			
				<div class="panel-heading">
					<div class="panel-title">
						<i class="fa fa-user"></i> Cliente
					</div>
					<div class="panel-options">
						<a @click="$router.push('/customers/')"><i class="fas fa-times"></i></a>
					</div>
				</div>
				
				<div class="panel-body">
					<form role="form" class="form-horizontal" @submit.prevent="newCustomer($event.target)">

						<input-form name="nombre" text="Nombre" :data.sync="customer.name" validate="required|min:3"></input-form>
						<input-form name="nombre" text="Apellidos" :data.sync="customer.lastname" validate="required|min:3"></input-form>
						<input-form name="email" text="Email" :data.sync="customer.email" validate="email|required"></input-form>
						<input-form type="password" name="password" text="Password" :data.sync="customer.password" :validate="rule_password" place="Solo si desea cambiarla"></input-form>
						<input-form type="tel" name="telefono" text="Telefono" :data.sync="customer.phone" validate="digits:10"></input-form>

						<input-form name="street" text="Calle" :data.sync="customer.street"></input-form>
						<input-form name="num_ext" text="Numero exterior" :data.sync="customer.num_ext"></input-form>
						<input-form name="num_int" text="Numero Interior" :data.sync="customer.num_init"></input-form>
						<input-form name="neighborhood" text="Colonia" :data.sync="customer.neighborhood"></input-form>
						<input-form name="cp" text="Código postal" :data.sync="customer.zipcode"></input-form>

						<div class="form-group">
							<label class="col-sm-3 control-label">Estado:</label>
							<div class="col-sm-7">
								<v-select v-model="customer.state_id" :options="estados" label="name" index="id" @change="getTowns" required/>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 control-label">Ciudad:</label>
							<div class="col-sm-7">
								<v-select v-model="customer.town_id" :options="ciudades" label="name" index="id" required/>
							</div>
						</div>
						
						<div class="form-group">
							<div class="col-sm-12">
								<button type="button" class="btn btn-danger" @click="deleteRow" v-show="$route.params.id"><i class="fa fa-trash"></i> Borrar</button>
								<button type="submit" class="btn btn-success pull-right"><i class="far fa-save"></i> Guardar</button> 
								<button type="button" class="btn btn-default pull-right" @click="$router.push('/customers/')">Cancelar</button>			
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
				customer:{
					name:'',
					lastname: '',
					email: '',
					password: '',
					phone: '',

					street: '',
					num_ext: '',
					num_int: '',
					neighborhood: '',
					state_id: null,
					town_id: null,
					zipcode: ''
				},

				estados: [],
				ciudades: [],
				id: null
			}
		},
		computed:{
			rule_password:function(){
				if(this.customer.password==undefined || this.customer.password.length==0){
					return '';
				}
				else{
					return 'min:6|required';
				}
			},
		},

		methods:{

			getCustomer(){
				axios.get(tools.url("/api/admin/customers/"+this.id)).then((response)=>{
			    	this.customer = response.data;
			    }).catch((error)=>{
			    	this.$parent.handleErrors(error);
			    });
			},

			newCustomer(form){
				this.$parent.validateAll(()=>{

					var data = tools.params(form, this.customer);
					if(this.$route.params.id){
						axios.post(tools.url("/api/admin/customers/"+this.id),data).then((response)=>{
					    	this.getCustomer();
					    	this.$parent.showMessage("Cliente "+this.customer.name+" modificado correctamente!","success");
					    }).catch((error)=>{
					    	this.$parent.handleErrors(error);
					    });
					}
					else{
						axios.post(tools.url("/api/admin/customers"),data)
						.then((response)=>{
							var customer = response.data;
					    	this.$parent.showMessage("Cliente "+customer.name+" agregado correctamente!","success");
					    	this.$router.push('/customers/edit/'+customer.id);
					    }).catch((error)=>{
					    	this.$parent.handleErrors(error);
					    });
					}
				},(e)=>{
					console.log(e);
				});				
			},

			deleteRow:function(){
				alertify.confirm("Alerta!","¿Seguro que deseas borrar este cliente?",()=>{
					axios.delete(tools.url("/api/admin/customers/"+this.id))
					.then((response)=>{
						this.$parent.showMessage(response.data.msg,"success");
						this.$router.push("/customers/");
					})
					.catch((error)=>{
						this.$parent.handleErrors(error);
					});
				},
				()=>{
					
				});
			},

			getEstados(){
				axios.get(tools.url('/api/admin/states')).then((response)=>{
					this.estados = response.data;
				}).catch((error)=>{
					this.$parent.handleErrors(error);
				});
			},

			getTowns(state_id){
				axios.get(tools.url('/api/admin/towns/' + state_id)).then((response)=>{
					this.ciudades = response.data;
				}).catch((error)=>{
					this.$parent.handleErrors(error);
				});
			},

		},
		
		mounted(){
			this.getEstados();

			if(this.$route.params.id){
				this.id = this.$route.params.id;
				this.getCustomer();
			}

			if(this.customer.state_id){
				this.getTowns(this.customer.state_id);
			}
		}
	}
</script>