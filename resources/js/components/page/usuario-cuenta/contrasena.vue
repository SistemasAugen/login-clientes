<template lang="html">
  <b-form @submit="onSubmit()">
    <h6>Contraseña</h6>
    <hr class="c-hr" />

    <!-- <b-form-group class="custom-input"
      label="Escriba su actual contraseña:"
      label-for="i-password">
      <b-form-input id="i-password" type="password"
        v-model="form.password" size="sm"
        required placeholder="********" />
    </b-form-group>

    <b-form-group class="custom-input"
      label="Escriba su nueva contraseña:"
      label-for="i-npassword">
      <b-form-input id="i-npassword" type="password"
        v-model="form.npassword" size="sm"
        required placeholder="********" />
    </b-form-group>

    <b-form-group class="custom-input"
      label="Vuelva a escribir su nueva contraseña:"
      label-for="i-conpassword">
      <b-form-input id="i-conpassword" type="password"
        v-model="form.conpassword" size="sm"
        required placeholder="********" />
    </b-form-group>
 -->
     <b-form-group
      label="Escriba su actual contraseña:"
      label-for="il-1">
      <div class="eye-box" style="position:relative;">
          <b-form-input
                    id="il-1"
                    size="sm"
                    v-model="form.password"
                    type="password"
                    required
                    placeholder="********" 
                    minlength="6"
          ></b-form-input>
          <i style="background-color: #fff;cursor: pointer; padding: 6px 10px; position: absolute;right: 2px;top: 2px; z-index: 4" class="fas ic-eye" v-bind:class="{ 'fa-eye' : showpass, 'fa-eye-slash' : !showpass }"  @click="showpass = !showpass"></i>
      </div>
    </b-form-group>

    <b-form-group
      label="Escriba su nueva contraseña:"
      label-for="il-2">
      <div class="eye-box" style="position:relative;">
          <b-form-input
                    id="il-2"
                    size="sm"
                    v-model="form.npassword"
                    type="password"
                    required
                    placeholder="********" 
                    minlength="6"
          ></b-form-input>
          <i style="background-color: #fff;cursor: pointer; padding: 6px 10px; position: absolute;right: 2px;top: 2px; z-index: 4" class="fas ic-eye" v-bind:class="{ 'fa-eye' : showpass2, 'fa-eye-slash' : !showpass2 }"  @click="showpass2 = !showpass2"></i>
      </div>
    </b-form-group>

    <b-form-group
      label="Vuelva a escribir su nueva contraseña:"
      label-for="il-3">
      <div class="eye-box" style="position:relative;">
          <b-form-input
                    id="il-3"
                    size="sm"
                    v-model="form.conpassword"
                    type="password"
                    required
                    placeholder="********"
                    minlength="6" 
          ></b-form-input>
          <i style="background-color: #fff;cursor: pointer; padding: 6px 10px; position: absolute;right: 2px;top: 2px; z-index: 4" class="fas ic-eye" v-bind:class="{ 'fa-eye' : showpass3, 'fa-eye-slash' : !showpass3 }"  @click="showpass3 = !showpass3"></i>
      </div>
    </b-form-group>

    <b-button type="submit" class="btn-red btn-form" variant="primary">Cambiar contraseña</b-button>

    <sweet-modal :icon="modal.icon" :blocking="modal.block" :hide-close-button="modal.block" ref="modal">
      <div class="fa-3x" v-if="modal.icon== ''"><i class="fas fa-spinner fa-pulse"></i></div><br/>
      {{modal.msg}}
      <div class="col-12 text-center" style="padding-top: 20px;" v-if="modal.icon == 'success'">
      <b-button class="btn btn-primary" slot="button" v-on:click.prevent="$refs.modal.close();">OK</b-button>
      </div>
    </sweet-modal>
  </b-form>
</template>

<script>
export default {
  data(){
    return{
     form: {
        password: '',
        npassword: '',
        conpassword: ''
      },
      showpass:false,
      showpass2:false,
      showpass3:false,

      modal:{
        msg:'',
        icon:'',
        block:false,
      },
    }
  },
  watch:{
    'showpass':function (val) {
          if (val == true) {
              $("#il-1").prop('type','text');
          }
          else if (val == false) {
            $("#il-1").prop('type','password');
          }
      },
    'showpass2':function (val) {
          if (val == true) {
              $("#il-2").prop('type','text');
          }
          else if (val == false) {
            $("#il-2").prop('type','password');
          }
      },
      'showpass3':function (val) {
          if (val == true) {
              $("#il-3").prop('type','text');
          }
          else if (val == false) {
            $("#il-3").prop('type','password');
          }
      },
  },
  methods: {
    onSubmit(){
      
        if(this.form.npassword !== this.form.conpassword){
            
            this.modal.block = false;
            this.modal.icon = 'error';
            this.modal.msg = 'Las contrseñas no coiciden';
            this.$refs.modal.open();
            return;
        }

        this.modal.icon = "";
        this.modal.msg = 'Cargando...';
        this.modal.block = true;
        this.$refs.modal.open();

        axios.post(tools.url('/api/user/password'), this.form).then((response)=>{
            
                this.modal.block = false;
                this.modal.icon = "success";
                this.modal.msg = response.data.msg;
                
        }).catch((error)=>{
            this.modal.block = false;
            this.modal.icon = "error";
            this.modal.msg = error.response.data;

        });


    }
  }
}
</script>
