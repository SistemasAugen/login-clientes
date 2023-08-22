<template lang="html">
  <div id="home-page">

    <section class="banner-section">
      <swiper class="swiper desktop" :options="bannersOptions">
        <swiper-slide v-for="(b, bhInx) in banners" :key="'bhInx-'+bhInx">
          <div class="placed-backg box" v-bind:style="{ backgroundImage: 'url('+b.imageUrl+')' }">
            <img src="public/images/pages/home/banner.png">
          </div>
        </swiper-slide>

        <div class="swiper-button-prev" slot="button-prev"></div>
        <div class="swiper-button-next" slot="button-next"></div>
      </swiper>

      <swiper class="swiper mobile" :options="bannersOptions">
        <swiper-slide v-for="(b, bhmInx) in banners" :key="'bhmInx-'+bhmInx">
          <div class="placed-backg box" v-bind:style="{ backgroundImage: 'url('+b.imageMobUrl+')' }">
            <img src="public/images/pages/home/banner-m.png">
          </div>
        </swiper-slide>

        <div class="swiper-button-prev" slot="button-prev"></div>
        <div class="swiper-button-next" slot="button-next"></div>
      </swiper>
    </section>

    <section class="search-section">
      <div class="container oversized-container">
        <div class="row">
          <div class="col-lg col-form">
            <b-form class="form-search-s1" @submit="onSubmit" inline>
              <b-form-group>
                <b-form-input
                  v-model="formSearch.keywords"
                  type="text"
                  placeholder="Buscar productos..."
                  required
                ></b-form-input>
              </b-form-group>

              <b-button type="submit" class="btn-s1 bg-red txt-lg">Buscar</b-button>
            </b-form>
          </div>

          <div class="col-lg-5 col-buttons">
            <router-link class="btn btn-s1 outline-red ic ic-star" to="/productos">Lo más popular</router-link>
            <router-link class="btn btn-s1 outline-red ic ic-prom" to="/productos">Promociones</router-link>
            <router-link class="btn btn-s1 outline-red ic ic-sold" to="/productos">Más vendido</router-link>
          </div>
        </div>
      </div>
    </section>

    <section class="products-section">
      <div class="container oversized-container">
        <div class="d-block mb-1">
          <h2 class="title-s1">Todos los productos</h2>
          <p>
            <router-link class="f-w-600 link-s1 redl" to="/productos">Ver todos</router-link>
          </p>
        </div>

        <div class="row row-prd-xxl-5">
          <div class="col-sm-6 col-lg-4 col-xl-3 box-product-sample-s1" v-for="(p, pInx) in products" :key="'pInx-'+pInx">
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
        </div>
      </div>
    </section>

    <section class="services-section">
      <div class="container oversized-container">
        <div class="d-block mb-3">
          <h2 class="title-s1">Servicios</h2>
          <p>
            <router-link class="f-w-600 link-s1 redl" to="/servicios">Ver todos</router-link>
          </p>
        </div>

        <div class="box-services">
          <swiper class="swiper" :options="servicesOptions">
            <swiper-slide v-for="(s, shInx) in services" :key="'shInx-'+shInx">
              <div class="col-12 px-0 box-service-sample-1">
                <router-link class="placed-backg box" v-bind:style="{ backgroundImage: 'url('+s.imageUrl+')' }" to="">
                  <div class="placed-backg box-text">
                    <h5>{{ s.name }}</h5>
                  </div>
                </router-link>
              </div>
            </swiper-slide>

            <div class="swiper-pagination" slot="pagination"></div>
          </swiper>
        </div>
      </div>
    </section>

    <section class="extra-banner-section">
      <a href="#">
        <img class="desktop" src="public/images/pages/home/banner-extra-1.jpg">
        <img class="mobile" src="public/images/pages/home/banner-extra-1-m.jpg">
      </a>
    </section>
  </div>
</template>

<script>
export default {
  data() {
    return {
      banners: [
        { imageUrl: 'public/images/pages/home/banner-1.jpg', imageMobUrl: 'public/images/pages/home/banner-1-m.jpg' },
      ],

      products: [
        { imageUrl: 'public/images/pages/products/product-1.jpg', price: '180' },
        { imageUrl: 'public/images/pages/products/product-2.jpg', price: '89' },
        { imageUrl: 'public/images/pages/products/product-1.jpg', price: '196' },
        { imageUrl: 'public/images/pages/products/product-2.jpg', price: '119' },
        { imageUrl: 'public/images/pages/products/product-1.jpg', price: '169' },
        { imageUrl: 'public/images/pages/products/product-2.jpg', price: '169' },
        { imageUrl: 'public/images/pages/products/product-1.jpg', price: '169' },
        { imageUrl: 'public/images/pages/products/product-2.jpg', price: '169' },
        { imageUrl: 'public/images/pages/products/product-1.jpg', price: '169' },
        { imageUrl: 'public/images/pages/products/product-2.jpg', price: '169' },
      ],

      services: [
        { imageUrl: 'public/images/pages/services/service-1.jpg', name: 'Veterinarias' },
        { imageUrl: 'public/images/pages/services/service-2.jpg', name: 'Estéticas' },
        { imageUrl: 'public/images/pages/services/service-3.jpg', name: 'Spa' },
        { imageUrl: 'public/images/pages/services/service-4.jpg', name: 'Hoteles' },
        { imageUrl: 'public/images/pages/services/service-5.jpg', name: 'Reportar perdido' },
      ],

      benefitOpt: 1,

      formSearch: {
        keywords: null,
      },

      // == Carousel options ==
      bannersOptions: {
        loop: true,
        speed: 700,

        navigation: {
          nextEl: '.swiper-button-next',
          prevEl: '.swiper-button-prev'
        },

        autoplay: {
          delay: 4000,
          disableOnInteraction: false
        },
      },

      servicesOptions: {
        slidesPerView: 4,
        spaceBetween: 30,

        pagination: {
          el: '.swiper-pagination',
          clickable: true
        },

        breakpoints: {
          1600: {
            slidesPerView: 4,
          },
          992: {
            slidesPerView: 3,
          },
          768: {
            slidesPerView: 2,
          },
          1: {
            slidesPerView: 1,
          },
        }
      }
      // == ==
    }
  },

  methods: {
    onSubmit(event) {
      event.preventDefault();
    },
  }
}
</script>
