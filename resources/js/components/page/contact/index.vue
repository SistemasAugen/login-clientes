<template lang="html">
  <div id="contact-page">

    <section class="container contact-form">
      <b-form class="row justify-content-center" @submit="onSubmit">
        <div class="col-12 col-title">
          <h2 class="title-s1"><span>Contacto</span></h2>
        </div>

        <div class="col-lg-7">
          <b-form-group class="form-group-s1"
            label="Nombre:">
            <b-form-input
              v-model="form.name"
              type="text"
              placeholder="Escriba su nombre y apellido"
              required
            ></b-form-input>
          </b-form-group>
        </div>

        <div class="col-lg-7">
          <b-form-group class="form-group-s1"
            label="Correo electrónico:">
            <b-form-input
              v-model="form.email"
              type="email"
              placeholder="ejemplo@email.com"
              required
            ></b-form-input>
          </b-form-group>
        </div>

        <div class="col-lg-7">
          <b-form-group class="form-group-s1"
            label="Teléfono:">
            <b-form-input
              v-model="form.phone"
              type="text"
              minlength="10"
              maxlength="10"
              placeholder="Escriba su teléfono"
              required
            ></b-form-input>
          </b-form-group>
        </div>

        <div class="col-lg-7">
          <b-form-group class="form-group-s1"
            label="Mensaje:">
            <b-form-textarea
              v-model="form.msg"
              placeholder="Escriba un mensaje"
              rows="4"
              max-rows="4"
              required
            ></b-form-textarea>
          </b-form-group>
        </div>

        <div class="col-lg-7 text-right pt-2">
          <b-button type="submit" class="btn-s1 bg-red txt-lg w-auto px-4"><i class="fal fa-envelope"></i> Enviar formulario</b-button>
        </div>
      </b-form>
    </section>

  </div>
</template>

<script>
export default {
  data() {
    return {
      form: {
        name: null,
        email: null,
        phone: null,
        msg: null,
      }
    }
  },

  methods: {
    makeToast(variant = null, msg, title) {
      this.$bvToast.toast(msg, {
        title: title,
        variant: variant,
        solid: true,
        toaster: 'b-toaster-bottom-center',
        appendToast: true
      })
    },

    onSubmit(event) {
      event.preventDefault();

      var params = this.form;
      var apiURL = tools.url("/api/contact");

      axios.post( apiURL,params )
      .then( (response) => {
        // alert(response.data.response);
        this.makeToast('success', response.data.response, 'Mensaje enviado');
        // alert(response.data.response);

        for (let prop in this.form) {
          this.form[prop] = '';
        }
      })
      .catch( (error) => {
        // console.log(error.response.data);
        let errors = error.response.data;

        for (let prop in errors) {
          // console.log(errors[prop]);
          this.makeToast('danger', errors[prop], '¡Error!');
        }
      });
    },
  }
}
</script>
