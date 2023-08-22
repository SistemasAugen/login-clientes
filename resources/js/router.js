import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

//Componentes
//import Login from './components/admin/Login.vue';

const page="./components/page/";

const MyRouter = new VueRouter({
  	routes:[
	    { path: '/', component: require(page+'user-access/login.vue').default, meta:{title:"Iniciar sesión"}},
     
    	{ path: '/login', component: require(page+'user-access/login.vue').default, meta:{title:"Iniciar sesión"}},
     
      { path: '/usuario', component: require(page+'usuario-cuenta/index.vue').default, meta:{ title: 'Mi datos' },
  			children: [
  			{
  				path: '/',
  				component: require(page+'usuario-cuenta/mis-datos.vue').default,
  				meta:{ title: 'Mis datos' }
  			},
  			{
  				path: 'contrasena',
  				component: require(page+'usuario-cuenta/contrasena.vue').default,
  				meta:{ title: 'Cambiar contraseña' }
  			},
       /* {
            path: 'historial-compras',
            component: require(page+'usuario-cuenta/historial-compras.vue').default,
            meta:{ title: 'Mis pedidos' }
        },
        {
            path: 'pedido/:id',
            component: require(page+'usuario-cuenta/orderdetails.vue').default,
            meta:{ title: 'Mis pedidos' }
        },*/
        {
            path: 'receta',
            component: require(page+'usuario-cuenta/receta.vue').default,
            meta:{ title: 'Solicitar receta' }
        },
		{
            path: 'recetas',
            component: require(page+'usuario-cuenta/recetas.vue').default,
            meta:{ title: 'Recetas' }
        },
		{
            path: 'estadodecuenta',
            component: require(page+'usuario-cuenta/estadodecuenta.vue').default,
            meta:{ title: 'Estado de cuenta' }
        },
		{
            path: 'pagar',
            component: require(page+'usuario-cuenta/pagar.vue').default,
            meta:{ title: 'Pagar' }
        },
		{
            path: 'historialdepagos',
            component: require(page+'usuario-cuenta/historialdepagos.vue').default,
            meta:{ title: 'Historial de pagos' }
        },
		{
            path: 'facturar',
            component: require(page+'usuario-cuenta/facturar.vue').default,
            meta:{ title: 'Facturar' }
        },
		{
            path: 'misfacturas',
            component: require(page+'usuario-cuenta/misfacturas.vue').default,
            meta:{ title: 'Mis facturas' }
        },
  	  	]
  		},

	    // { path: '/checkout', component: require(page+'checkout.vue').default, meta:{title:"Checkout"}},
	  ]
});

MyRouter.beforeEach((to, from, next) => {
	window.scrollTo(0,0);
	if(window.app.__vue__ && window.app.__vue__.$refs.loadingBar){
		window.app.__vue__.$refs.loadingBar.start();
	}
	next();
});

MyRouter.afterEach((to, from) => {

	if(window.app.__vue__ && window.app.__vue__.$refs.loadingBar){
		setTimeout(()=>{
			window.app.__vue__.$refs.loadingBar.done();
		},500);
	}


});

//Titulos del website
import VueDocumentTitlePlugin from "vue-document-title-plugin";
Vue.use(VueDocumentTitlePlugin, MyRouter,
	{ defTitle: "Augenlabs", filter: (title)=>{ return title+" - Augenlabs"; } }
);

// export {routes};
export default MyRouter;
