<template lang="html">
  <header id="header">
    <div class="header-content">
      <b-navbar toggleable="lg" type="light" variant="light">
        <div class="container oversized-container">
          <b-navbar-brand to="/">
            <img src="public/images/logo.png" alt="Augen">
          </b-navbar-brand>

          <b-navbar-toggle target="nav-collapse" class="t-150">
            <i class="far fa-bars"></i>
          </b-navbar-toggle>

          
        </div>
      </b-navbar>
    </div>



  </header>
</template>

<script>
export default {
  data() {
    return {
      
    }
  },

  watch: {
    $route (to, from){
  
    }
  }
}
</script>
