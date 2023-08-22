<template lang="html">
  <div class="d-flex account-page">
    <div class="container">

      <div class="row">
        <div class="col-xl-12 main-box">

          <div class="row">
            <div class="col-12 px-2">
              <h1 class="mb-3 page-title">{{ title }}</h1>
            </div>
            <div class="col-lg-4 px-2 col-menu">
              <div class="white-box">
                <div class="d-none d-lg-block box-profile">
                  <div class="d-block mt-4 pb-3">
                    <span class="fa-stack fa-4x user-icon">
                      <i class="fas fa-circle fa-stack-2x"></i>
                      <i class="fas fas fa-user fa-stack-1x fa-inverse"></i>
                    </span>

                    <h5 class="txt-username">Bienvenido {{ $root.user.name }}</h5>
                  </div>
                </div>

                <hr class="d-none d-lg-block" />

                <div class="box-menu">
                  <p class="item">
                    <router-link class="btn-menu" to="/usuario"><i class="far fa-edit"></i> Mis datos</router-link>
                  </p>
                  <p class="item">
                    <router-link class="btn-menu" to="/usuario/contrasena"><i class="fas fa-lock"></i> Mi contraseña</router-link>
                  </p>
                
                  <p class="item">
                    <router-link class="btn-menu" to="/usuario/recetas"><i class="fas fa-clipboard-list"></i> Mis recetas</router-link>
                  </p>
                  <p class="item">
                    <router-link class="btn-menu" to="/usuario/estadodecuenta"><i class="fas fa-file-invoice-dollar"></i> Estado de cuenta</router-link>
                  </p>

                  
                  <p class="item">
                    <router-link class="btn-menu" to="/usuario/pagar"><i class="fas fa-hand-holding-usd"></i> Pagar</router-link>
                  </p>
                  <p class="item">
                    <router-link class="btn-menu" to="/usuario/historialdepagos"><i class="fas fa-receipt"></i> Historial de pagos</router-link>
                  </p>

                  
                  <p class="item">
                    <router-link class="btn-menu" to="/usuario/facturar"><i class="fas fa-file-invoice"></i> Facturar</router-link>
                  </p>
                  <p class="item">
                    <router-link class="btn-menu" to="/usuario/misfacturas"><i class="far fa-money-check-edit-alt"></i> Mis facturas</router-link>
                  </p>
                  <!-- <p class="item">
                    <router-link class="btn-menu" to="/usuario/historial-compras"><i class="fas fa-clipboard-list"></i> Historial de compras</router-link>
                  </p> -->
                  <!-- <p class="item">
                    <router-link class="btn-menu" to="/"><i class="fas fa-sign-out-alt"></i> Cerrar sesión</router-link>
                  </p> -->
                  <p class="item">
                    <a class="btn-menu" v-on:click="logout()" style="cursor: pointer;"><i class="fas fa-sign-out-alt"></i> Cerrar sesión</a>
                  </p>
                </div>

              </div>
            </div>

            <div class="col-lg-8 px-2">
              <div class="white-box p-4">

                <router-view></router-view>

              </div>
            </div>
          </div>

        </div>
      </div>

    </div>
  </div>
</template>

<script>
export default {
  data(){
    return{
      title: 'Mi cuenta'
    }
  },

  methods:{
    getUrlName(){
      var urlName = this.$route.path;

      if(urlName == '/usuario'){ this.title = 'Mis datos' }
      if(urlName == '/usuario/contrasena'){ this.title = 'Cambiar contraseña' }
      if(urlName == '/usuario/recetas'){ this.title = 'Recetas' }
      if(urlName == '/usuario/estadodecuenta'){ this.title = 'Estado de cuenta' }

      // if(urlName == '/usuario/receta'){ this.title = 'Solicitar receta' }
      
      if(urlName == '/usuario/pagar'){ this.title = 'Pagar' }
      if(urlName == '/usuario/historialdepagos'){ this.title = 'Historial de pagos' }

      if(urlName == '/usuario/facturar'){ this.title = 'Facturar' }
      if(urlName == '/usuario/misfacturas'){ this.title = 'Mis facturas' }
    },

    logout(){
        axios.post(tools.url("/api/logout")).then((response)=>{
            this.$parent.user = {};
            this.$parent.logged = false;
            this.$router.push('/login');
        }).catch(()=>{});
    },
  },

  beforeMount(){
    this.getUrlName();
  },

  watch: {
    $route(to, from) {
      this.getUrlName();
    },
  },

  mounted(){
    /*if(this.$root.logged == false){
        this.$router.push("/");
    }*/
  }
}
</script>
