<template lang="html">
    <div class="col-cart-data loggedin-cart">
        <div class="col-12 pt-3 product-list-table">
            <router-link class="btn btn-dark" style="background-color: black;color: white;float: left;" to="/usuario/receta">Solicitar Receta</router-link>
        </div>
        <div class="col-12 pt-3 product-list-table" style="overflow-x: scroll;">
            <div  v-if="!pedidos.length" style="text-align: center;">No existen movimientos en este momento.</div>
  
            <div class="row">
            <div class="panel-body" >
                <div class="col-md-10">
                    <table class="table responsive">
                                    <thead>
                                    <tr>
                                        <th>RX</th>
                                        <th>PDV</th>
                                        <th>Laboratorio</th>
                                        <th>Creado</th>
                                        <th>Diseño</th>
                                        <th>Material</th>
                                        <th>Caracteristicas</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(row, i) in pedidos" :key="i">
                                        <td>{{ row.rx }}</td>
                                        <td>{{ row.rx }}</td>
                                        <td>{{ row.branch.name }}</td>
                                        <td>{{ row.created }}</td>
                                        <td>{{ row.product.name }}</td>
                                        <td>{{ row.product.subcategory_name }}</td>
                                        <td>{{ row.product.type_name }}</td>
                                        <td>{{ row.realTotal }}</td>
                                        <td>{{ row.status }}</td>
                                    </tr>
                                    </tbody>
                                </table>
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
        pedidos: [],
        id: null,
        estatus: ''
      }
    },
  
    methods: {
      getHistorial(){
        axios.get(tools.url("/api/user/orders")).then((response)=>{
          this.pedidos = response.data;
        }).catch((error)=>{
            console.log(error);
        });
      },
    },
  
    mounted(){
      if(this.$root.logged){
          this.getHistorial();
      }
    }
  
  }
  </script>
  