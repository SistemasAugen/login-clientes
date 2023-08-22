<template lang="html">
  <div id="services-page">

    <section class="container oversized-container main-section">
      <div class="row">
        <div class="col-12 col-title">
          <h6 class="title-s1">Servicios</h6>
        </div>

        <div class="col-12 col-md-6 col-lg-4 col-xl-3 box-service-sample-1 x-h" v-for="(s, shInx) in services" :key="'shInx-'+shInx">
          <router-link class="placed-backg box" v-bind:style="{ backgroundImage: 'url('+s.imageUrl+')' }" to="">
            <div class="placed-backg box-text">
              <h5>{{ s.name }}</h5>
            </div>
          </router-link>
        </div>
      </div>
    </section>

  </div>
</template>

<script>
export default {
  data() {
    return {
      services: [
        { imageUrl: 'public/images/pages/services/service-1.jpg', name: 'Veterinarias' },
        { imageUrl: 'public/images/pages/services/service-2.jpg', name: 'Estéticas' },
        { imageUrl: 'public/images/pages/services/service-3.jpg', name: 'Spa' },
        { imageUrl: 'public/images/pages/services/service-4.jpg', name: 'Hoteles' },
        { imageUrl: 'public/images/pages/services/service-5.jpg', name: 'Reportar perdido' },
        { imageUrl: 'public/images/pages/services/service-6.jpg', name: 'Paseos' },
        { imageUrl: 'public/images/pages/services/service-7.jpg', name: 'Vacunas' },
        { imageUrl: 'public/images/pages/services/service-8.jpg', name: 'Limpieza dental' },
      ],
    }
  }
}
</script>
