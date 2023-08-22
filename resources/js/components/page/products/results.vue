<template lang="html">
  <b-form id="products-results-page" @submit="onSubmit">

    <loading-component-s1 v-if="loading"></loading-component-s1>

    <section class="banner-section">
      <a href="#">
        <img class="desktop" src="public/images/pages/products/banner-1.jpg">
        <img class="mobile" src="public/images/pages/products/banner-1-m.jpg">
      </a>
    </section>

    <section class="search-section">
      <div class="container oversized-container">
        <div class="row">
          <div class="col-lg col-form">
            <div class="form-search-s1" inline>
              <b-form-group>
                <b-form-input
                  v-model="formSearch.keywords"
                  type="text"
                  placeholder="Buscar productos..."
                  required
                ></b-form-input>
              </b-form-group>

              <b-button type="submit" class="btn-s1 bg-red txt-lg">Buscar</b-button>
            </div>
          </div>

          <div class="col-lg col-order">
            <span class="label">Ordenar por</span>
            <b-form-select v-model="formSearch.order">
              <b-form-select-option value="1">Lo más vendido</b-form-select-option>
              <b-form-select-option value="2">Lo más popular</b-form-select-option>
              <b-form-select-option value="3">Mayor precio</b-form-select-option>
              <b-form-select-option value="4">Menor precio</b-form-select-option>
              <b-form-select-option value="5">Nombre (ascendente)</b-form-select-option>
            </b-form-select>
          </div>
        </div>
      </div>
    </section>

    <section class="products-section">
      <div class="container oversized-container">
        <div class="row">
          <div class="col-12 box-breadcrumb-s1">
            <span>Home</span>
            <span>Productos</span>
            <router-link to="">Alimentos</router-link>
          </div>
        </div>

        <div class="row">
          <!-- Mobile filters -->
          <div class="col-12 col-filters-mobile">
            <div class="bg-filter-mv" v-if="showFilters == true" @click="showFilters = false"></div>
            <a class="btn-filters" @click="showFilters = !showFilters">
              <i class="fas fa-filter"></i><span>Ver filtros</span>
            </a>
          </div>
          <!--  -->

          <!-- Col filters -->
          <div class="col-lg col-filters" v-bind:class="{ 'show-filters': showFilters == true }">
            <h4 class="d-lg-none _title">
              <span><strong>Filtrar</strong></span>
              <a class="btn-hide" @click="showFilters = false"><i class="fas fa-chevron-left"></i></a>
            </h4>

            <div class="filters-container">
              <div class="box-filters">
                <h6 class="group-f-title">Categoría</h6>

                <b-form-group class="box-filters-group" v-slot="{ ariaDescribedby }">
                  <b-form-checkbox-group
                    v-model="formSearch.category"
                    :aria-describedby="ariaDescribedby"
                    name="fil-1">
                    <b-form-checkbox
                      :value="c.id"
                      v-for="(c, cInx) in categories"
                      :key="'cInx-'+cInx">
                      {{ c.name }}
                    </b-form-checkbox>
                  </b-form-checkbox-group>
                </b-form-group>
              </div>

              <div class="box-filters">
                <h6 class="group-f-title">Marca</h6>

                <b-form-group class="box-filters-group" v-slot="{ ariaDescribedby }">
                  <b-form-checkbox-group
                    v-model="formSearch.brand"
                    :aria-describedby="ariaDescribedby"
                    name="fil-2">
                    <b-form-checkbox
                      :value="b.id"
                      v-for="(b, bInx) in brands"
                      :key="'bInx-'+bInx">
                      {{ b.name }}
                    </b-form-checkbox>
                  </b-form-checkbox-group>
                </b-form-group>
              </div>

              <div class="box-filters">
                <h6 class="group-f-title">Precio</h6>

                <b-form-group class="box-filters-group" v-slot="{ ariaDescribedby }">
                  <b-form-radio-group
                    v-model="formSearch.price"
                    :aria-describedby="ariaDescribedby"
                    name="fil-3">
                    <b-form-radio
                      :value="p.id"
                      v-for="(p, pInx) in price"
                      :key="'pInx-'+pInx">
                      {{ p.name }}
                    </b-form-radio>
                  </b-form-radio-group>
                </b-form-group>
              </div>

              <div class="box-filters">
                <h6 class="group-f-title">Descuentos</h6>

                <b-form-group class="box-filters-group" v-slot="{ ariaDescribedby }">
                  <b-form-radio-group
                    v-model="formSearch.discount"
                    :aria-describedby="ariaDescribedby"
                    name="fil-4">
                    <b-form-radio
                      :value="d.id"
                      v-for="(d, dInx) in discounts"
                      :key="'dInx-'+dInx">
                      {{ d.name }}
                    </b-form-radio>
                  </b-form-radio-group>
                </b-form-group>
              </div>

            </div>
          </div>
          <!--  -->

          <!-- Col products -->
          <div class="col-lg col-results">
            <div class="row">
              <div class="col-12 col-title">
                <h2 class="title-s1">Todos los productos</h2>
              </div>

              <div class="col-sm-6 col-lg-4 box-product-sample-s1" v-for="(p, pInx) in products" :key="'pInx-'+pInx">
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

            <div class="row mt-4" v-if="pagination.total_products > 6">
              <div class="col-12 text-center">
                <div class="d-inline-block mx-0 col-pagination-sample-1">
                  <b-pagination-nav :link-gen="linkGen" :number-of-pages="pagination.total" use-router></b-pagination-nav>
                </div>
              </div>
            </div>
          </div>
          <!--  -->

        </div>
      </div>
    </section>

  </b-form>
</template>

<script>
export default {
  data() {
    return {
      loading: false,
      showFilters: false,

      categories: [
        { id: 1, name: 'Alimentos' },
        { id: 10, name: 'Accesorios' },
        { id: 3, name: 'Juguetes' },
        { id: 4, name: 'Jaulas' },
        { id: 5, name: 'Muebles' },
        { id: 6, name: 'Medicinas' },
        { id: 7, name: 'Premios' },
        { id: 8, name: 'Reptiles' },
        { id: 9, name: 'Ratones y más' },
      ],

      brands: [
        { id: 1, name: 'Royal Canin' },
        { id: 2, name: 'Hils' },
        { id: 3, name: 'Purina Pro Plan' },
        { id: 4, name: 'Pal perro' },
        { id: 5, name: 'Instinct' },
        { id: 6, name: 'Dog Chow' },
        { id: 7, name: 'Nupec' },
      ],

      price: [
        { id: 1, name: '$0 - $199' },
        { id: 2, name: '$200 - $599' },
        { id: 3, name: '$600 - $999' },
        { id: 4, name: '$1,000 - $1,999' },
        { id: 5, name: '$2,000 - $2,999' },
        { id: 6, name: '$3,000 o más' },
      ],

      discounts: [
        { id: 1, name: '10%' },
        { id: 2, name: '20%' },
        { id: 3, name: '30%' },
      ],

      formSearch: {
        keywords: null,
        order: 1,
        category: [],
        price: null,
        discount: null,
      },

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
        { imageUrl: 'public/images/pages/products/product-1.jpg', price: '269' },
        { imageUrl: 'public/images/pages/products/product-2.jpg', price: '169' },
      ],

      pagination:{
        currentpage: 1,
        total: 1,
        total_products: 16,
        number: 10
      },
    }
  },

  methods: {
    linkGen(pageNum) {
      return pageNum === 1 ? '?' : `?page=${pageNum}`
    },

    onSubmit(event) {
      event.preventDefault();
    },
  },

  mounted() {
    this.loading = true;

    setTimeout(()=> {
      this.loading = false;
    }, 2000);
  }
}
</script>
