<template lang="html">
  <div id="promotions-page">

    <section class="container oversized-container main-section">
      <div class="row">
        <div class="col-12 col-page-title">
          <h6 class="title-s1">Promociones</h6>
        </div>

        <div class="col-12 col-promo">
          <div class="box-promo">
            <div class="col-lg-6 col-info">
              <h4 class="title">Título de la promoción</h4>
              <h5 class="subtitle">Subtítulo de la promoción</h5>
              <p>
                <router-link class="btn btn-s2 bg-redl" to="/promociones/1">Ver promoción</router-link>
              </p>
            </div>

            <div class="col-lg-6 placed-backg col-image" v-bind:style="{ backgroundImage: 'url(public/images/pages/promotions/promo-1.jpg)' }"></div>
          </div>
        </div>

        <div class="col-12 col-promo">
          <div class="box-promo">
            <div class="col-lg-7 col-xl-6 col-info">
              <h4 class="title">Título de la promoción</h4>
              <h5 class="subtitle">Subtítulo de la promoción</h5>
              <p>
                <router-link class="btn btn-s2 bg-redl" to="/promociones/1">Ver promoción</router-link>
              </p>
            </div>

            <div class="col-lg-5 col-xl-6 placed-backg col-image" v-bind:style="{ backgroundImage: 'url(public/images/pages/promotions/promo-2.jpg)' }"></div>
          </div>
        </div>

        <div class="col-12 col-promo">
          <div class="box-promo">
            <div class="col-lg-7 col-xl-6 col-info">
              <h4 class="title">Título de la promoción</h4>
              <h5 class="subtitle">Subtítulo de la promoción</h5>
              <p>
                <router-link class="btn btn-s2 bg-redl" to="/promociones/1">Ver promoción</router-link>
              </p>
            </div>

            <div class="col-lg-5 col-xl-6 placed-backg col-image" v-bind:style="{ backgroundImage: 'url(public/images/pages/promotions/promo-3.jpg)' }"></div>
          </div>
        </div>
      </div>
    </section>

  </div>
</template>

<script>
export default {
}
</script>
