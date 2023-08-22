<template lang="html">
    <div>
        <div>
            <b-form @submit.prevent="onSubmit()" style="overflow-x: scroll;">
                <h6>Solicitar receta</h6>
                <hr class="c-hr" />

                <div v-if="step == 1">                
                    <div class="col-md-4" style="float: right;">
                        <a class="btn btn-success" @click="selectType"><i class="fa fa-search"></i> Buscar producto</a>
                    </div>
                    <br><br><br><br>
                    <div class="panel-body" >
                        <div class="col-md-10">
                            <table class="table responsive">
                                <thead>
                                <tr>
                                    <th>RX</th>
                                    <th>Diseño</th>
                                    <th>Material</th>
                                    <th>Caracteristica</th>
                                    <th v-if="!isAugenLabs">Antireflejante</th>
                                    <th v-else>Cantidad</th>
                                    <th>Costo</th>
                                    <th v-if="!isAugenLabs">Servicio</th>
                                    <th>Subtotal</th>
                                    <th>RX</th>
                                    <th>Eliminar</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(cart, i) in sale.cart" :key="i">
                                    <td>{{ cart.rx }}</td>
                                    <td>{{ cart.product.name }}</td>
                                    <td>{{ cart.product.category_name }}</td>
                                    <td>{{ cart.product.type_name }}</td>
                                    <td v-if="!isAugenLabs && cart.extras[0]">
                                    {{
                                        cart.extras
                                        .map((row) => {
                                            return row.name;
                                        })
                                        .join(", ")
                                    }}
                                    <a
                                        class="btn btn-sm btn-warning"
                                        @click="selectOrder(cart)"
                                    >
                                        <i class="fa fa-plus"></i>
                                    </a>
                                    </td>
                                    <!-- <td v-else>
                                                            <button class="btn btn-sm btn-warning" @click="selectOrder(cart.product)">
                                                                <i class="fa fa-plus" v-show="cart.product.extras[0]"></i>
                                                            </button>
                                                        </td>
                                                        El sig bloque else-if, else-if, valida la presencia del campo No AR, si esta presente, no permite agregar ningun antireflejante,
                                                        corrobar el v-else anterior si es necesario tenerlo presente o escribrilo despues de esta validacion. -->
                                    <td
                                    v-else-if="
                                        !isAugenLabs && (cart.not_ar != 1 || cart.ar != 1)
                                    "
                                    >
                                    <a
                                        class="btn btn-sm btn-warning"
                                        @click="selectOrder(cart)"
                                    >
                                        <i class="fa fa-plus"></i>
                                    </a>
                                    </td>
                                    <td
                                    v-else-if="
                                        !isAugenLabs && cart.not_ar == 1 && cart.ar == 1
                                    "
                                    >
                                    No AR activo.
                                    </td>
                                    <td v-else>
                                    <input
                                        
                                        class="form-control"
                                        v-model="cart.service"
                                        @change="getDiscounts"
                                        
                                        @keypress="isNumber($event)"
                                    />
                                    </td>
                                    <td>${{ cart.price }}</td>
                                    <td v-if="!isAugenLabs">
                                    <input
                                        
                                        v-model="cart.service"
                                        @change="getDiscounts"
                                        
                                        @keypress="isNumber($event)"
                                        width="50px"
                                        id="aaaa"
                                    />
                                    </td>
                                    <td>${{ cart.total }}</td>
                                    <td>
                                    <a
                                        class="btn btn-info btn-sm"
                                        @click="openModalRx(i)"
                                    >
                                        RX
                                    </a>
                                    </td>

                                    <td>
                                    <a
                                        class="btn btn-danger btn-sm"
                                        @click="deleteProduct(i)"
                                    >
                                        Borrar
                                    </a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    
                    </div>

                    <a type="button" class="btn btn-red btn-form" variant="primary" @click="step = 2" style="color:white">Siguiente</a>
                </div>
                <div v-else-if="step == 2"> 
                    
                    <div class="panel-body" >
                        <div class="col-md-10">
                            <table class="table responsive">
                                <thead>
                                <tr>
                                    <th>RX</th>
                                    <th>Diseño</th>
                                    <th>Material</th>
                                    <th>Caracteristica</th>
                                    <th v-if="!isAugenLabs">Antireflejante</th>
                                    <th v-else>Cantidad</th>
                                    <th>Costo</th>
                                    <th v-if="!isAugenLabs">Servicio</th>
                                    <th>Descuento</th>
                                    <th>Subtotal</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(cart, i) in sale.cart" :key="i">
                                    <td>{{ cart.rx }}</td>
                                    <td>{{ cart.product.name }}</td>
                                    <td>{{ cart.product.category_name }}</td>
                                    <td>{{ cart.product.type_name }}</td>
                                    <td v-if="cart.extras[0]">
                                        {{
                                        cart.extras
                                            .map((row) => {
                                            return row.name;
                                            })
                                            .join(", ")
                                        }}
                                    </td>
                                    <td v-else>-</td>
                                    <td>${{ cart.price }}</td>
                                    <td v-if="!isAugenLabs">${{ cart.service }}</td>
                                    <td v-else>{{ cart.service }}</td>
                                    <td>{{ cart.percent_discount }}%</td>
                                    <td>${{ parseFloat(cart.total - cart.discount) }}</td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                    <td colspan="8" class="text-right">Descuentos:</td>
                                    <td>${{ sale.discounts }}</td>
                                    </tr>
                                    <tr>
                                    <td colspan="8" class="text-right">IVA:</td>
                                    <td>${{ sale.ivas }}</td>
                                    </tr>
                                    <tr>
                                    <td
                                        colspan="8"
                                        class="text-right"
                                        style="font-size: 27px; letter-spacing: 2px"
                                    >
                                        Total:
                                    </td>
                                    <td
                                        style="font-size: 28px;position: absolute;font-weight: bold;margin-left: -12px;"
                                        v-if="isAugenLabs"
                                    >
                                        ${{
                                        Math.ceil(
                                            sale.total -
                                            sale.discounts +
                                            parseFloat(sale.ivas)
                                        ).toFixed(2)
                                        }}
                                    </td>
                                    <td
                                        style="font-size: 28px;position: absolute;font-weight: bold; margin-left: -12px;"
                                        v-else
                                    >
                                        ${{
                                        (
                                            sale.total -
                                            sale.discounts +
                                            parseFloat(sale.ivas)
                                        ).toFixed(2)
                                        }}
                                    </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    
                    </div>
                    
                    <b-button type="button" class="btn-red btn-form" variant="primary" @click="step = 1">Regresar</b-button>
                    <b-button type="submit" class="btn-red btn-form" variant="primary" >Solicitar receta</b-button>
                </div>
                
        
                
            </b-form>
        </div>
        <div>
            <sweet-modal :icon="modal.icon" :blocking="modal.block" :hide-close-button="modal.block" ref="modal">
                    <div class="fa-3x" v-if="modal.icon== ''"><i class="fas fa-spinner fa-pulse"></i></div><br/>
                    {{modal.msg}}
                    <div class="col-12 text-center" style="padding-top: 20px;" v-if="modal.icon == 'success'">
                    <b-button class="btn btn-primary" slot="button" v-on:click.prevent="closeModal">OK</b-button>
                    </div>
            </sweet-modal>

            <sweet-modal ref="modalWriteRx">
                    <b-form @submit.prevent="checkDuplicate()">
                        <b-form-group class="custom-input" label="Escribe el RX:" label-for="i-nombre">
                            <b-form-input id="i-nombre" type="text" v-model="rx" size="sm" required placeholder="Escribe el RX" />
                        </b-form-group>

                        <b-button type="submit" class="btn-red btn-form" variant="primary">Aceptar</b-button>
                        <b-button class="btn-red btn-form" variant="primary" style="background-color: #c7cbcc;border-color: #c7cbcc;" @click="$refs.modalWriteRx.close()">Cancelar</b-button>
                    </b-form>
            </sweet-modal>

            <sweet-modal ref="modalProductType">
                <div id="types_table">
                    <div class="row">
                        <div class="col-md-12">
                            <h3>Elige un tipo de producto:</h3>
                        </div>
                        <div class="col-md-12 col-md-offset-3" v-for="(type,indx) in types" :key="type.id">
                            <!-- <br> -->
                            <!-- <br> -->
                            <button class="btn btn-default btn-block" @click="selectProduct(type)">
                                {{ type.name }}
                            </button>
                        </div>
                    </div>
                </div>
            </sweet-modal>

            <sweet-modal ref="modalTableProducts" width="90%">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                        <th rowspan="2" width="15%" style="color: black">
                            {{ type.name }}
                        </th>
                        <th
                            v-for="category in categories"
                            :key="category.id"
                            :colspan="category.subcategories.length"
                            :style="{ color: 'black', backgroundColor: category.color }"
                        >
                            {{ category.name }}
                        </th>
                        </tr>
                        <tr>
                        <template v-for="category in categories">
                            <th
                            v-for="subcategory in category.subcategories"
                            :key="subcategory.id + category.name"
                            :style="{ color: 'black', backgroundColor: category.color }"
                            :title="subcategory.description"
                            >
                            {{ subcategory.name }}
                            </th>
                        </template>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(product, i) in products" :key="product.id + i">
                        <td>{{ product.name }}</td>
                        <template v-for="category in categories">
                            <td
                            v-for="subcategory in category.subcategories"
                            :key="subcategory.id + category.name"
                            :title="subcategory.description"
                            >
                            <button
                                class="btn btn-sm btn-block"
                                v-if="
                                filterProduct(product, category.id, subcategory.id)
                                    .price != 0
                                "
                                @click="
                                addProduct(
                                    filterProduct(product, category.id, subcategory.id),
                                    category,
                                    subcategory
                                )
                                "
                            >
                                ${{
                                filterProduct(product, category.id, subcategory.id).price
                                }}
                            </button>
                            <p v-else>-</p>
                            </td>
                        </template>
                        </tr>
                    </tbody>
                </table>
                <small>*Precios sin I.V.A.</small>
            </sweet-modal>

            <sweet-modal ref="extrasTable">

                <div id="extras_table">
                    <div class="row">
                    <div class="col-md-12">
                        <h3>Seleccionar antireflejante:</h3>
                    </div>

                    <div
                        class="col-md-12 col-md-offset-3"
                        v-for="extra in extras"
                        :key="extra.id"
                    >
                        <br />
                        <br />
                        <button class="btn btn-default btn-block" @click="addExtra(extra)">
                        {{ extra.name }} - ${{ extra.price }}
                        </button>
                    </div>
                    <br>
                    <div class="col-md-12 col-md-offset-3">
                        <br />
                        <br />
                        <button class="btn btn-warning btn-block" @click="addExtra()">
                        Omitir
                        </button>
                    </div>
                    </div>
                </div>
            </sweet-modal>
         
            <sweet-modal ref="modalRx" width="900">
                <form role="form" class="form-horizontal" @submit.prevent="newBranch($event.target)" v-if="index_prod != null">
                    <p><b>Captura de datos</b></p>
                    <div class="form-group row">
                        <label class="col-sm-3 control-label">RX:</label>
                        <input class="col-sm-7 form-control" name="rx" v-model="sale.cart[index_prod].rx_data.rx_rx">    
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 control-label">Fecha:</label>
                        <input class="col-sm-7 form-control" name="fecha" v-model="sale.cart[index_prod].rx_data.rx_fecha" type="date">    
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 control-label">Cliente:</label>
                        <input class="col-sm-7 form-control" name="cliente" v-model="sale.cart[index_prod].rx_data.rx_cliente">    
                    </div>

                    <p><b>Graduación</b></p>
                    <div class="form-group row">
                        <label class="col-sm-3 control-label">OD Esfera:</label>
                        <input class="col-sm-7 form-control" name="rx_od_esfera" v-model="sale.cart[index_prod].rx_data.rx_od_esfera">    
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 control-label">OD Clilindro:</label>
                        <input class="col-sm-7 form-control" name="od_cilindro" v-model="sale.cart[index_prod].rx_data.od_cilindro">    
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 control-label">OD Eje:</label>
                        <input class="col-sm-7 form-control" name="od_eje" v-model="sale.cart[index_prod].rx_data.rx_od_eje">    
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 control-label">OD Adición:</label>
                        <input class="col-sm-7 form-control" name="od_adicion" v-model="sale.cart[index_prod].rx_data.rx_od_adicion">    
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 control-label">OD Dip:</label>
                        <input class="col-sm-7 form-control" name="od_dip" v-model="sale.cart[index_prod].rx_data.rx_od_dip">    
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 control-label">OD Altura:</label>
                        <input class="col-sm-7 form-control" name="od_altura" v-model="sale.cart[index_prod].rx_data.rx_od_altura">    
                    </div>
                    
                    
                    <hr>
                    <div class="form-group row">
                        <label class="col-sm-3 control-label">OD Esfera:</label>
                        <input class="col-sm-7 form-control" name="rx_od_esfera_dos" v-model="sale.cart[index_prod].rx_data.rx_od_esfera_dos">    
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 control-label">OD Clilindro:</label>
                        <input class="col-sm-7 form-control" name="rx_od_cilindro_dos" v-model="sale.cart[index_prod].rx_data.rx_od_cilindro_dos">    
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 control-label">OD Eje:</label>
                        <input class="col-sm-7 form-control" name="rx_od_eje_dos" v-model="sale.cart[index_prod].rx_data.rx_od_eje_dos">    
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 control-label">OD Adición:</label>
                        <input class="col-sm-7 form-control" name="rx_od_adicion_dos" v-model="sale.cart[index_prod].rx_data.rx_od_adicion_dos">    
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 control-label">OD Dip:</label>
                        <input class="col-sm-7 form-control" name="rx_od_dip_dos" v-model="sale.cart[index_prod].rx_data.rx_od_dip_dos">    
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 control-label">OD Altura:</label>
                        <input class="col-sm-7 form-control" name="rx_od_altura_dos" v-model="sale.cart[index_prod].rx_data.rx_od_altura_dos">    
                    </div>
                    
                    

                    <div class="form-group row">
                        <label class="col-sm-3 control-label">Diseño:</label>                
                        <v-select class="col-sm-7" v-model="sale.cart[index_prod].rx_data.rx_diseno" :options="disenoOpcs" label="label" index="value"/>
                    </div>

                    <div class="form-group row">
                                    <label class="col-sm-3 control-label">Material:</label>
                                    <div class="col-sm-7">
                                            <v-select v-model="sale.cart[index_prod].rx_data.rx_material" :options="materialOpcs" label="label" index="value"/>
                                    </div>
                            </div>

                    <div class="form-group row">
                                    <label class="col-sm-3 control-label">Tipo AR:</label>
                                    <div class="col-sm-7">
                                            <v-select v-model="sale.cart[index_prod].rx_data.rx_tipo_ar" :options="tipoarOpcs" label="label" index="value"/>
                                    </div>
                            </div>

                    <div class="form-group row">
                                    <label class="col-sm-3 control-label">Tallado:</label>
                                    <div class="col-sm-7">
                                            <v-select v-model="sale.cart[index_prod].rx_data.rx_tallado" :options="talladoOpcs" label="label" index="value"/>
                                    </div>
                            </div>


                    <p><b>Armazón</b></p>
                    <div class="form-group row">
                        <label class="col-sm-3 control-label">Tipo de armazón:</label>
                        <div class="col-sm-7">
                            <v-select v-model="sale.cart[index_prod].rx_data.rx_tipo_armazon" :options="tipo_armazonOpcs" label="label" index="value"/>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label class="col-sm-3 control-label">Horizontal "A":</label>
                        <input class="col-sm-7 form-control" name="horizontal_a" v-model="sale.cart[index_prod].rx_data.rx_horizontal_a">    
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 control-label">Vertical "B":</label>
                        <input class="col-sm-7 form-control" name="rx_vertical_b" v-model="sale.cart[index_prod].rx_data.rx_vertical_b">    
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 control-label">Diagonal "ED":</label>
                        <input class="col-sm-7 form-control" name="rx_diagonal_ed" v-model="sale.cart[index_prod].rx_data.rx_diagonal_ed">    
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 control-label">Puente:</label>
                        <input class="col-sm-7 form-control" name="rx_puente" v-model="sale.cart[index_prod].rx_data.rx_puente">    
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 control-label">Observaciones:</label>
                        <textarea class="col-sm-7 form-control" name="rx_observaciones" v-model="sale.cart[index_prod].rx_data.rx_observaciones"></textarea>
                    </div>
                  
                    <div class="form-group row">
                        <div class="col-sm-12">        
                            <button type="button" class="btn btn-dark" style="background-color: black;color: white;float: left;" @click="requestRx(index_prod)">Solicitar RX</button>
                            <button type="submit" class="btn btn-success" style="float: right;" @click="$refs.modalRx.close()"><i class="far fa-save"></i> Guardar</button>
                            <button type="button" class="btn btn-default" style="float: right;" @click="$refs.modalRx.close()">Cancelar</button>
                        </div>
                    </div>

                </form>    
            </sweet-modal>
            
        </div>
    </div>
    
    

    
  </template>
  
  <script>
  export default {
    data(){
      return{
        step:1,
        form:{
            name:null
        },
        modal:{
            msg:'',
            icon:'',
            block:false,
        },

        types:[],
        rx:"",
        type: {},

        categories:[],
        products:[],

        order:{},
        extras:{},
        sale:{
            cart:[],
            client_id:"",
            total:0,
            observation:"",
            discounts:0,
            ivas:0,
        },
        index_prod:null,

        disenoOpcs:[
            {value:'Monofocal HD',label:'Monofocal HD'},
            {value:'Monofocal Asferico HD',label:'Monofocal Asferico HD'},
            {value:'Flat-Top HD',label:'Flat-Top HD'},
            {value:'Progresivo HD',label:'Progresivo HD'},
            {value:'Progresivo Trinity 11-15 HD',label:'Progresivo Trinity 11-15 HD'},
            {value:'Progresivo Trinity 13-17 Freshman HD',label:'Progresivo Trinity 13-17 Freshman HD'},
            {value:'Progresivo Trinity 13-17 Hypersoft HD',label:'Progresivo Trinity 13-17 Hypersoft HD'},
            {value:'Progresivo Trinity 13-17 Profesional HD',label:'Progresivo Trinity 13-17 Profesional HD'},
            {value:'Progresivo 15-20 Urban HD',label:'Progresivo 15-20 Urban HD'},
            {value:'Progresivo Trinity 8-12 Mini HD',label:'Progresivo Trinity 8-12 Mini HD'},
            {value:'Progresivo Trinity Spacia HD',label:'Progresivo Trinity Spacia HD'},
        ],
        materialOpcs:[
            {value:'Alto Índice',label:'Alto Índice'},
            {value:'Parasol',label:'Parasol'},
            {value:'Trivex',label:'Trivex'},
            {value:'Trivex Parasol',label:'Trivex Parasol'},
            {value:'Polarizado',label:'Polarizado'},
            {value:'B BLOCK',label:'B BLOCK'},
        ],
        tipoarOpcs:[
            {value:'Ninguno',label:'Ninguno'},
            {value:'Matiz-e',label:'Matiz-e'},
            {value:'Gold',label:'Gold'},
            {value:'Azul',label:'Azul'},
            
        ],
        talladoOpcs:[
            {value:'Digital',label:'Digital'},
            {value:'Free Form',label:'Free Form'},
        ],
        tipo_armazonOpcs:[
            {value:'Metálico',label:'Metálico'},
            {value:'Perforado',label:'Perforado'},
            {value:'Plástico',label:'Plástico'},
            {value:'Ranurado',label:'Ranurado'},
        ],

        isAugenLabs:false,
        
      }
    },
    watch:{
        "sale.cart": {
            handler: function (v) {
                this.getDiscounts();
            },
            deep: false,
        },
        "client.discounts": {
            handler: function () {
                this.getDiscounts();
            },
            deep: true,
        },
    },
    methods: {
        selectType: async function () {
            this.getTypes();
            this.$refs.modalWriteRx.open();  
        },


        getTypes: function () {
            axios.get(tools.url("/api/types")).then((response) => {
                    let types = response.data;
                    const CHAPULTEPEC_LAB = 46;
                    /*let isPDV = false;
                    for (let role of this.user.roles)
                        if (role.name == "punto de ventas") {
                        isPDV = true;
                        break;
                        }

                    for (let i = 0; i < types.length; i++) {
                        if (!isPDV) {
                            types[i].canSee = true;
                            continue;
                        }
                        if ([25, 34, 46].includes(this.user.id)) {
                            types[i].canSee = true;
                        } else {
                            if (types[i].id == 10) types[i].canSee = false;
                            else types[i].canSee = true;
                        }
                    }*/

                    this.types = types;
                    
                })
                .catch((error) => {
                    
                    
                });
        },
        checkDuplicate(){

            axios.get(tools.url("/api/orders/check_duplicates/"+this.rx)).then((response) => {
                    if(response.data == true){
                        alert('Ya hay una receta ingresada con ese folio, ¿quieres continuar?');
                    }
                    else{
                        this.$refs.modalWriteRx.close();
                        this.$refs.modalProductType.open();
                    }
            })
            .catch((error) => {
                        
            });
        },
        getSubcategories: function (v) {
            this.categories = [];
            this.inPetition = true;
            axios.get(tools.url("/api/subcategories/type/" + v)).then((response) => {
                let subcategories = response.data;
                let categories = {};

                subcategories.forEach((sub, key) => {
                    sub.categories.forEach((cat, k) => {
                    if (categories[cat.name]) {
                        categories[cat.name].subcategories.push(sub);
                    } else {
                        categories[cat.name] = cat;

                        categories[cat.name].subcategories = [sub];
                    }
                    });
                });

                jQuery.each(categories, (k, v) => {
                    v.subcategories.sort((a, b) => {
                    return a.id - b.id;
                    });
                    this.categories.push(v);
                });

                this.categories.sort((a, b) => {
                    return a.id - b.id;
                });

                this.inPetition = false;
            })
            .catch((error) => {
               
            });
        },
        getProducts: function (type_id) {
            axios.get(tools.url("/api/product/type/" + type_id)).then((response) => {
                this.products = response.data;
                this.products.forEach((v, k) => {
                this.products[k].prices.sort((a, b) => {
                    return a.id - b.id;
                });
                });
            });
        },
        selectProduct: function (type) {
            this.getSubcategories(type.id);
            this.getProducts(type.id);
            this.type = type;

            this.$refs.modalTableProducts.open();
            //alertify.productsDialog(document.getElementById("products_table"));
        },
        filterProduct: function (product, category_id, subcategory_id) {
            let data = product.prices.find((r) => {
                if (
                r.category_id == category_id &&
                r.subcategory_id == subcategory_id
                ) {
                return true;
                }
            });

            if (data) return data;
            else return { price: 0 };
        },

        addProduct: function (price, category, subcategory) {
            var no_AR = 0;
            var ar = 0;
            let product = this.products.find((r) => {
                if (r.id == price.product_id) return true;
            });
            product.category_name = category.name;
            product.type_name = subcategory.name;
            let order = {
                product_has_subcategory_id: price.id,
                price: price.price,
                discount: 0,
                total: price.price,
                service: 0,
                extras: [],
                product: product,
                rx: this.rx,
                not_ar: 0,
                rx_data:{
                rx_rx:null,
                rx_fecha:null,
                rx_cliente:null,

                rx_od_esfera:null,
                rx_od_cilindro:null,
                rx_od_eje:null,
                rx_od_adicion:null,
                rx_od_dip:null,
                rx_od_altura:null,
                rx_od_esfera:null,

                rx_od_esfera_dos:null,
                rx_od_cilindro_dos:null,
                rx_od_eje_dos:null,
                rx_od_adicion_dos:null,
                rx_od_dip_dos:null,
                rx_od_altura_dos:null,
                rx_od_esfera_dos:null,
                
                rx_diseno:null,
                rx_material:null,
                rx_tipo_ar:null,
                rx_tallado:null,
                rx_tipo_armazon:null,
                rx_horizontal_a:null,
                rx_vertical_b:null,
                rx_diagonal_ed:null,
                rx_puente:null,
                rx_observaciones:null,

                }
            };

            if (this.isAugenLabs) order.service = 1;

            product.subcategories.forEach((subcategory) => {
                if (subcategory.id == price.subcategory_id) {
                no_AR = subcategory.no_antireflective;
                ar = subcategory.antireflective;
                }
            });

            order.not_ar = no_AR;
            order.ar = ar;

            if (product.extras.length == 0 || (no_AR == 1 && ar == 1)) {
                alertify.closeAll();
                this.sale.cart.push(order);
                this.getDiscounts();
                this.rx = "";
            } else if (product.extras.length != 0 && ar == 1) {
                this.order = order;
                this.extras = product.extras.filter((row) => {
                return row.free_form == 1;
                });
                this.$refs.extrasTable.open();
               // alertify.extrasDialog(document.getElementById("extras_table"));
            } else if (product.extras.length != 0 && no_AR == 1) {
                this.order = order;
                this.extras = product.extras.filter((row) => {
                return row.free_form == 1;
                });
                this.$refs.extrasTable.open();
                //alertify.extrasDialog(document.getElementById("extras_table"));
            } else {
                this.order = order;
                this.extras = product.extras;
                this.$refs.extrasTable.open();
                //alertify.extrasDialog(document.getElementById("extras_table"));
            }
        },
        getDiscounts: function (event) {
            // if('target' in event) {
            //     let value = parseFloat(event.target.value);
            //     if(value < 0) {
            //
            //     }
            // }
            let total = 0;
            let discounts = 0;
            let ivas = 0;

            /*if (this.isAugenLabs) {
                // In this case v.service will be used as qty option.
                this.sale.cart.forEach((v, k) => {
                this.sale.cart[k].percent_discount = 0;
                this.sale.cart[k].total = (
                    window.parseFloat(v.price) * window.parseFloat(v.service)
                ).toFixed(2);
                this.sale.cart[k].discount = 0;
                this.sale.cart[k].iva = window.parseFloat(
                    this.sale.cart[k].total * 0.16
                );
                });
            } else {*/
                this.sale.cart.forEach((v, k) => {
                let discount = this.$root.user.discounts.find((row) => {
                    return row.type_id == v.product.type_id;
                });

                if (discount) {
                    this.sale.cart[k].percent_discount = discount.discount;
                    this.sale.cart[k].total = (
                    window.parseFloat(v.price) + window.parseFloat(v.service)
                    ).toFixed(2);
                    this.sale.cart[k].discount = window.parseFloat(
                    (discount.discount / 100) * this.sale.cart[k].total
                    );
                    this.sale.cart[k].iva = window.parseFloat(
                    (this.sale.cart[k].total -
                        this.sale.cart[k].discount) *
                        0.16
                    );
                } else {
                    this.sale.cart[k].percent_discount = 0;
                    this.sale.cart[k].total = (
                    window.parseFloat(v.price) + window.parseFloat(v.service)
                    ).toFixed(2);
                    this.sale.cart[k].discount = window.parseFloat(
                    (0 / 100) * this.sale.cart[k].total
                    );
                    this.sale.cart[k].iva = window.parseFloat(
                    (this.sale.cart[k].total -
                        this.sale.cart[k].discount) *
                        0.16
                    );
                }
                });
            //}

            this.sale.cart.forEach((v, k) => {
                total += window.parseFloat(v.total);
                discounts += window.parseFloat(v.discount);
                ivas += window.parseFloat(v.iva);
            });

            this.sale.total = total.toFixed(2);
            this.sale.discounts = discounts.toFixed(2);
            this.sale.ivas = ivas.toFixed(2);
        },
        addExtra: function (extra) {
            var flag = 1;

            if (extra) {
                this.order.extras.forEach((tempExtra) => {
                if (extra.id == tempExtra.id) {
                    flag = 0;
                }
                if (extra.free_form == tempExtra.free_form) {
                    flag = 0;
                }
                });
                if (flag == 1) {
                this.order.extras.push(extra);
                this.order.price =
                    window.parseFloat(this.order.price) +
                    window.parseFloat(extra.price);
                } else {
                    alert("No se puede agregar otro Antireflejante de este tipo.");
                }
            }
            this.sale.cart.push(this.order);
            this.order = {};

            this.$refs.extrasTable.close();
            this.$refs.modalTableProducts.close();
            this.$refs.modalProductType.close();
        },
        selectOrder: function (cart) {
            let product = cart.product;
            let no_AR = cart.not_ar;
            let ar = cart.ar;
            let indexProduct = this.sale.cart.findIndex((row) => {
                if (row.product_has_subcategory_id == cart.product_has_subcategory_id)
                return true;
            });
            let order = this.sale.cart[indexProduct];
            this.sale.cart.splice(indexProduct, 1);

            if (product.extras.length == 0 || (no_AR == 1 && ar == 1)) {
                alertify.closeAll();
                this.sale.cart.push(order);
                this.getDiscounts();
                this.rx = "";
            } else if (product.extras.length != 0 && ar == 1) {
                this.order = order;
                this.extras = product.extras.filter((row) => {
                return row.free_form == 1;
                });
                alertify.extrasDialog(document.getElementById("extras_table"));
            } else if (product.extras.length != 0 && no_AR == 1) {
                this.order = order;
                this.extras = product.extras.filter((row) => {
                return row.free_form == 1;
                });
                alertify.extrasDialog(document.getElementById("extras_table"));
            } else {
                this.order = order;
                this.extras = product.extras;
                alertify.extrasDialog(document.getElementById("extras_table"));
            }
            // if(cart.product.extras.length==0){
            //     this.showMessage("No puedes agregar antireflejante a este diseño.");
            // }
            // else{
            //     let indexProduct = this.sale.cart.findIndex(row=>{
            //         if(row.product_has_subcategory_id==cart.product_has_subcategory_id)
            //             return true;
            //     });
            //     this.order = this.sale.cart[indexProduct];
            //     this.sale.cart.splice(indexProduct,1);
            //     this.extras=cart.product.extras;
            //     alertify.extrasDialog(document.getElementById('extras_table'));
            // }
        },
        isNumber: function(evt) {
            evt = (evt) ? evt : window.event;
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode !== 46) {
                evt.preventDefault();
            } else {
                return true;
            }
        },
        openModalRx(indx){
            this.index_prod = indx;
            this.$refs.modalRx.open();
        },
        deleteProduct: function (index) {
            this.sale.cart.splice(index, 1);
        },
        getDiscounts: function (event) {
            // if('target' in event) {
            //     let value = parseFloat(event.target.value);
            //     if(value < 0) {
            //
            //     }
            // }
            let total = 0;
            let discounts = 0;
            let ivas = 0;

            if (this.isAugenLabs) {
                // In this case v.service will be used as qty option.
                this.sale.cart.forEach((v, k) => {
                this.sale.cart[k].percent_discount = 0;
                this.sale.cart[k].total = (
                    window.parseFloat(v.price) * window.parseFloat(v.service)
                ).toFixed(2);
                this.sale.cart[k].discount = 0;
                this.sale.cart[k].iva = window.parseFloat(
                    this.sale.cart[k].total * 0.16
                );
                });
            } else {
                this.sale.cart.forEach((v, k) => {
                let discount = this.$root.user.discounts.find((row) => {
                    return row.type_id == v.product.type_id;
                });

                if (discount) {
                    this.sale.cart[k].percent_discount = discount.discount;
                    this.sale.cart[k].total = (
                    window.parseFloat(v.price) + window.parseFloat(v.service)
                    ).toFixed(2);
                    this.sale.cart[k].discount = window.parseFloat(
                    (discount.discount / 100) * this.sale.cart[k].total
                    );
                    this.sale.cart[k].iva = window.parseFloat(
                    (this.sale.cart[k].total -
                        this.sale.cart[k].discount) *
                        0.16
                    );
                } else {
                    this.sale.cart[k].percent_discount = 0;
                    this.sale.cart[k].total = (
                    window.parseFloat(v.price) + window.parseFloat(v.service)
                    ).toFixed(2);
                    this.sale.cart[k].discount = window.parseFloat(
                    (0 / 100) * this.sale.cart[k].total
                    );
                    this.sale.cart[k].iva = window.parseFloat(
                    (this.sale.cart[k].total -
                        this.sale.cart[k].discount) *
                        0.16
                    );
                }
                });
            }

            this.sale.cart.forEach((v, k) => {
                total += window.parseFloat(v.total);
                discounts += window.parseFloat(v.discount);
                ivas += window.parseFloat(v.iva);
            });

            this.sale.total = total.toFixed(2);
            this.sale.discounts = discounts.toFixed(2);
            this.sale.ivas = ivas.toFixed(2);
            },
        onSubmit(){
            
            let text = "¿Seguro que deseas realizar este pedido?";
            if (confirm(text) == true) {
                this.sale.client_id = this.$root.user.id;
                let params = window._.cloneDeep(this.sale);
                this.modal.block = true;
                this.modal.msg = 'Cargando ...';
                this.modal.icon = '';
                this.$refs.modal.open();
                
                params.cart = params.cart.map((row) => {
                    let extras = row.extras.map((r) => {
                    return { extra_id: r.id, price: r.price };
                    });
                    return {
                    product_has_subcategory_id: row.product_has_subcategory_id,
                    price: row.price,
                    discount: row.discount,
                    service: row.service,
                    total: row.total,
                    iva: row.iva,
                    rx: row.rx,
                    percent_discount: row.percent_discount,
                    extras: extras,
                    rx_data: row.rx_data
                    };
                });
                
                axios.post(tools.url("/api/order"), params).then((response) => {
                    this.modal.block = false;
                    this.modal.msg = 'Pedido realizado correctamente.';
                    this.modal.icon = 'success';

                }).catch((err) => {
                    this.modal.block = false;
                    this.modal.msg = err.response.data;
                    this.modal.icon = 'error';
                });

            }
            else{
                this.modal.block = false;
                this.$refs.modal.close();
                this.$router.push('/usuario/recetas');
            }
  
        },
        requestRx(indx){
        
            var dataform = {
            'rx':this.sale.cart[indx].rx_data,
            'user':this.$root.user
            };
            axios.post(tools.url("/api/orders/requestrx"),dataform).then((response)=>{
                alert('RX eviada correctamente...');
            }).catch((error)=>{
                alert(error.data.msg);            
            });
        },
        closeModal(){

        }
    }
  }
  </script>
  