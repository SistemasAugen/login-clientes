/*
 *
 * Estos componentes estan presentes solo en el website
 *
 */

const page="./page/";
// import slick from 'vue-slick';
import BootstrapVue from 'bootstrap-vue';
import VueAwesomeSwiper from 'vue-awesome-swiper';
// import VueSweetalert2 from 'vue-sweetalert2';
import SweetModal from 'sweet-modal-vue/src/plugin.js'; // https://sweet-modal-vue.adepto.as/

function plugin (Vue) {
	//Componentes llamados
  Vue.component('my-header', require(page+'shared/header.vue').default);
  Vue.component('my-footer', require(page+'shared/footer.vue').default);
  Vue.component('loading-component-s1', require(page+'shared/loading-component-s1.vue').default);
	// Vue.component('slick',slick);
  Vue.use(BootstrapVue);
  Vue.use(VueAwesomeSwiper, /* { default options with global component } */);
  Vue.use(SweetModal);
  // Vue.use(VueSweetalert2);
}

// Install by default if using the script tag
if (typeof window !== 'undefined' && window.Vue) {
  window.Vue.use(plugin)
}

export default plugin
