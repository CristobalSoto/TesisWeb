

import Dashboard from '../components/Dashboard.vue'
import NotFound from '../components/NotFoundPage.vue'

import Home from '../components/views/Home.vue'
import Graphtest from '../components/views/GraphTest.vue'
import Welcome from '../components/views/Welcome.vue'
import BuscarProducto from '../components/views/BuscarProducto.vue'

const routes = [
  {
    path: '/',
    component: Dashboard,
    redirect: '/welcome',
    children:[
      {
        path:'home',
        name:'Home',
        component: Home
      },
      {
        path:'test',
        name:'Test',
        component: Graphtest
      },
      {
        path:'welcome',
        name:'welcome',
        component: Welcome
      },
      {
        path:'buscar',
        name:'buscar producto',
        component: BuscarProducto
      }
    ]
  },
  {
    path: '*', 
    component: NotFound
  }
  ]

/**
* Asynchronously load view (Webpack Lazy loading compatible)
* The specified component must be inside the Views folder
* @param  {string} name  the filename (basename) of the view to load.
function view(name) {
 var res= require('..../components/Dashboard/Views/' + name + '');
 return res;
};**/

export default routes
