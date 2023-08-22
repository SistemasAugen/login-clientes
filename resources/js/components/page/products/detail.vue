<template lang="html">
  <div id="description-page">
    <loading-component-s1 v-if="loading"></loading-component-s1>

    <section class="breadcrumb-section">
      <div class="container oversized-container">
        <span>Producto</span>
        <span class="line">/</span>
        <span>{{ product.name }}</span>
      </div>
    </section>

    <section class="container oversized-container description-section" id="product-description" v-if="isLoading == false">
      <div class="row">

        <div class="col-lg-6 col-gallery">
          <span class="bubble">30%</span>

          <swiper :options="galleryOptions" v-if="showGallery">
            <swiper-slide v-for="(row, galIndex) in gallery" :key="galIndex">
              <div class="image-container">
                <div class="img">
                  <img :src="row">
                  <!-- <v-zoom :img="row" :width="'100%'"></v-zoom> -->
                </div>
              </div>
            </swiper-slide>

            <div class="swiper-button-prev" slot="button-prev"></div>
            <div class="swiper-button-next" slot="button-next"></div>
          </swiper>
        </div>

        <b-form class="col-lg-5 col-description" @submit="addCart">
          <h1 class="name">{{ product.name }}</h1>
          <h6 class="sku"><strong>ID:</strong> {{ product.sku }}</h6>

          <h6 class="price discount" v-if="product.price_discount != null">
            <span>$ {{ Intl.NumberFormat("en-US", { minimumFractionDigits: 2 }).format(product.price_orig) }}</span>
          </h6>
          <h4 class="price" v-if="product.price_discount != null">$ {{ Intl.NumberFormat("en-US", { minimumFractionDigits: 2 }).format(product.price_discount) }}</h4>
          <h4 class="price" v-else>$ {{ Intl.NumberFormat("en-US", { minimumFractionDigits: 2 }).format(product.price) }}</h4>

          <div class="mt-3 txt-description"  v-html="product.short_description"></div>

          <h6 class="mt-3 subtitle" v-b-toggle="'collapse-2'">Descripción <small class="fas fa-chevron-down"></small></h6>
          <b-collapse class="mt-1" id="collapse-2">
            <div class="txt-description"  v-html="product.description"></div>
          </b-collapse>

          <div v-if="stock != null">
            <h6 class="mt-4 subtitle" v-if="stock > 0">Stock disponible: <span class="txt-red">{{stock}}</span> </h6>
            <h6 class="mt-4 subtitle" v-else>Sin stock</h6>
          </div>

          <div class="d-block mt-4 mb-2" v-if="product.documentUrl">
            <a class="btn btn-submit btn-contact" v-if="product.documentUrl" :href="product.documentUrl" target="_blank" rel="noopener noreferrer">Descargar ficha técnica <i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>
          </div>

          <!-- <h6 class="mt-2 mb-1 subtitle" v-if="product.tablaPrecios">Lista de precios</h6>
          <img class="img-fluid" :src="product.tablaPrecios"> -->

          <h6 class="mt-3 subtitle" v-if="product.delivery_time_custom && product.type == 'producto'">Tiempo de entrega</h6>
          <h4 class="delivery-time" v-if="product.delivery_time_custom && product.type == 'producto'">{{ product.delivery_time_custom }}</h4>

          <h4 class="delivery-time" v-if="product.type == 'servicio'">El proveedor de este servicio se coordinará con el comprador para definir fecha y hora de inicio del servicio</h4>

          <div class="col-quantity2 mt-2" v-if="stock > 0">
            <a class="form-control btn-q" @click="changeCantidad('-')">
              <i class="fas fa-minus"></i>
            </a>
            <b-form-input class="input-q" type="number" min="0" v-model="form.quantity" @keypress="isNumber($event)" @paste="noPaste" />
            <a class="form-control btn-q" @click="changeCantidad('+')">
              <i class="fas fa-plus"></i>
            </a>
          </div>

          <div class="d-block mt-4 mb-2">
            <b-button type="submit" class="my-2 my-xl-0 btn-submit">Agregar a la cesta</b-button>
          </div>
        </b-form>
      </div>
    </section>

    <section class="container oversized-container related-products-section" id="related-products" v-if="isLoading == false">
      <div class="row">
        <div class="col-12 col-s-title">
          <h2 class="title-s1">Productos relacionados</h2>
          <hr class="mt-2 mb-2" />
        </div>
      </div>

      <div class="col-products">
        <swiper class="swiper carousel-t1 ct1-white" :options="productsOption">
          <swiper-slide v-for="(p, pInx) in products" :key="'pInx-'+pInx">
            <div class="col-12 px-0 box-product-sample-s1">
              <router-link class="box-link" to="/producto/1">
                <span class="bubble">Nuevo</span>
                <div class="placed-backg box-image" v-bind:style="{ backgroundImage: 'url('+p.imageUrl+')' }">
                  <img src="public/images/shared/empty.png">
                </div>

                <div class="box-descr">
                  <h6 class="name">Nombre de producto</h6>

                  <div class="descr">
                    <p>Producto, descripción, información extra y más va aquí</p>
                  </div>

                  <h6 class="price">$ {{ Intl.NumberFormat("en-US", { minimumFractionDigits: 2 }).format(p.price) }}</h6>
                </div>
              </router-link>
            </div>
          </swiper-slide>

          <div class="swiper-button-prev" slot="button-prev"></div>
          <div class="swiper-button-next" slot="button-next"></div>
        </swiper>
      </div>
    </section>

    <sweet-modal blocking hide-close-button ref="modalloading">
      <div>Cargando ...</div>
    </sweet-modal>

    <sweet-modal :icon="modal.icon" :blocking="modal.block" :hide-close-button="modal.block"  ref="modal">
      <div v-html="modal.msg"></div>
      <div class="col-12 text-center" style="padding-top: 20px;" v-if="modal.icon == 'success'">
          <b-button class="btn btn-primary" slot="button" v-on:click.prevent="$refs.modal.close()">Agregar mas productos</b-button>
          <b-button class="btn btn-primary" slot="button" v-on:click.prevent="$refs.modal.close(); $router.push('/cart')">Ir al carrito <i class="color-white fas fa-shopping-cart"></i></b-button>
      </div>
    </sweet-modal>

  </div>
</template>

<script>


import vZoom from 'vue-zoom'; // https://www.npmjs.com/package/vue-zoom
export default {
  components: {vZoom},

  data() {
    return {
      loading: false,
      
      id: null,
      showGallery: true,
      modalGallery: [],
      showModalGallery: false,

      form: {
        modelo: null,
        quantity: 1,
        color: null,
        models:[],
        modelo:null
      },

      product: {
        name: 'Nombre del producto',
        description: '',
        sku: 'D5A5049617B',
        price_discount: '69',
        price_orig: '80',
        price: '80',
        short_description: 'Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
        description: 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
        models:[],
      },

      category: [],

      products: [
        { imageUrl: 'public/images/pages/products/product-1.jpg', price: '180' },
        { imageUrl: 'public/images/pages/products/product-2.jpg', price: '89' },
        { imageUrl: 'public/images/pages/products/product-1.jpg', price: '196' },
        { imageUrl: 'public/images/pages/products/product-2.jpg', price: '119' },
        { imageUrl: 'public/images/pages/products/product-1.jpg', price: '169' },
        { imageUrl: 'public/images/pages/products/product-2.jpg', price: '85' },
      ],

      gallery: [
        'public/images/pages/products/product-lg-1.jpg',
        'public/images/pages/products/product-lg-1.jpg',
        'public/images/pages/products/product-lg-1.jpg',
      ],

      relatedProducts: [],

      // isLoading: true,
      isLoading: false,
      stock: 5,

      modal:{
        msg:'',
        icon:'',
        block:false
      },

      // == Carrusel options ==
      galleryOptions: {
        loop: false,
        speed: 600,

        navigation: {
          nextEl: '.swiper-button-next',
          prevEl: '.swiper-button-prev'
        }

        // autoplay: {
        //   delay: 3000,
        //   disableOnInteraction: false
        // }
      },

      productsOption: {
        loop: false,
        slidesPerView: 5,
        spaceBetween: 30,

        navigation: {
          nextEl: '.swiper-button-next',
          prevEl: '.swiper-button-prev'
        },

        breakpoints: {
          1600: {
            slidesPerView: 5,
          },
          1200: {
            slidesPerView: 4,
          },
          992: {
            slidesPerView: 3,
          },
          576: {
            slidesPerView: 2,
          },
          1: {
            slidesPerView: 1
          },
        }
      },

      modalGalleryOptions: {
        loop: true,
        speed: 750,
        // effect: 'fade',

        autoplay: {
          delay: 2000,
          disableOnInteraction: false
        },

        navigation: {
          nextEl: '.swiper-button-next',
          prevEl: '.swiper-button-prev'
        }
      }
      // == ==
    }
  },

  watch: {
        "$route.params.id" : function(v){
            //this.id = this.$route.params.id;
            this.id = this.$root._getURLID(this.$route.params.id);
            this.getProduct();
        },
        "form.modelo" : function(v){
            for (var i = 0; i < this.product.models.length; i++) {
                if(v == this.product.models[i].id){
                      this.stock = this.product.models[i].stock;
                      break;

                }
            }

        },
    },

  methods:{
    openModalGallery(galleryArray){
      this.modalGallery = galleryArray;

      this.$refs['modal-image'].show();

      setTimeout(()=>{
        this.showModalGallery = true;
      },700);
    },

    getProduct(){
      // this.isLoading = true; // DESCOMENTAR ESTO
      // this.$refs.modalloading.open(); // DESCOMENTAR ESTO
      // this.showGallery = false; // DESCOMENTAR ESTO
      axios.get(tools.url('/api/product/' + this.id)).then((response)=>{
        this.product = [];
        this.gallery = [];

        this.product = response.data;
        this.gallery = response.data.gallery;
        this.category = response.data.category;

        this.stock = this.product.stock;

        this.showGallery = true;
        this.getRelated(this.id);
        this.$refs.modalloading.close();
        this.isLoading = false;
      }).catch((error)=>{
        console.log(error);
        this.isLoading = false;
      });
    },

    getRelated(id){
      axios.get(tools.url('/api/products/related/'+id)).then((response)=>{
        this.products = response.data;

      }).catch((error)=>{
        console.log(error);
      })
    },

    addCart(evt){
      evt.preventDefault();
      var cart = [];

      if (this.product.models.length > 0) {
          if (this.form.modelo == null) {
              alert('Selecciona un modelo o talla');
              return;
          }
          else{
              if(localStorage.cart){
                  cart = JSON.parse(localStorage.getItem('cart'));

                  for(var i = 0; i < cart.length ; i++)
                  {
                      if(cart[i].id == this.id && cart[i].modelo == this.form.modelo)
                      {
                          var suma = cart[i].quantity + this.form.quantity;
                          cart[i].quantity = suma <= this.stock ? suma : this.stock;
                          encontrado = true;
                          break;
                      }
                  }

                  if(!encontrado)
                  {
                      cart.push({ id:this.id, quantity:this.form.quantity, modelo: this.form.modelo, color: this.form.color, imageUrl: this.gallery[0] });
                  }
              }
              else
              {
                  cart.push({ id:this.id, quantity:this.form.quantity, modelo: this.form.modelo, imageUrl: this.gallery[0] });
              }
          }
      }
      else{
          if(localStorage.cart){
                  cart = JSON.parse(localStorage.getItem('cart'));

                  for(var i = 0; i < cart.length ; i++)
                  {
                      if(cart[i].id == this.id && cart[i].modelo == this.form.modelo)
                      {
                          var suma = cart[i].quantity + this.form.quantity;
                          cart[i].quantity = suma <= this.stock ? suma : this.stock;
                          encontrado = true;
                          break;
                      }
                  }

                  if(!encontrado)
                  {
                      cart.push({ id:this.id, quantity:this.form.quantity, modelo: this.form.modelo, imageUrl: this.gallery[0] });
                  }
              }
              else
              {
                  cart.push({ id:this.id, quantity:this.form.quantity, modelo: this.form.modelo, imageUrl: this.gallery[0] });
              }
      }

      var encontrado = false;


      localStorage.setItem("cart",JSON.stringify(cart));
      this.$root.cartCount = cart.length;
      //this.toast();
      this.modal.msg = 'El producto <b>'+this.product.name+'</b> se agregado al carrito';
      this.modal.icon = 'success';
      this.$refs.modal.open();
    },
    noPaste(evt){
      event.preventDefault();
    },

    isNumber: function(evt) {
      evt = (evt) ? evt : window.event;
      var charCode = (evt.which) ? evt.which : evt.keyCode;
      if (charCode < 48 || charCode > 57) {
        evt.preventDefault();
      } else {
        return true;
      }
    },

    changeCantidad($type){
      this.form.quantity = parseInt(this.form.quantity);
      if ($type == '-') {
        this.form.quantity = (this.form.quantity > 1) ? --this.form.quantity : 1;
      }
      else{
        this.form.quantity = (this.form.quantity < 100) ? ++this.form.quantity : 100;
      }
    },
  },

   mounted(){
    // this.id = this.$route.params.id;
    // this.id = this.$root._getURLID(this.$route.params.id);
    // this.getProduct();

    this.loading = true;
    setTimeout(()=> {
      this.loading = false;
    }, 2000);
  }
}
</script>
