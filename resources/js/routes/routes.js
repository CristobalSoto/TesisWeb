

import Dashboard from '../components/Dashboard.vue'
import NotFound from '../components/NotFoundPage.vue'

import HomeContent from '../components/DashboardContent.vue'


const Foo = { template: '<div>foo</div>' }
const Bar = { template: '<div>bar</div>' }

const routes = [
  {
    path: '/',
    component: Dashboard,
    redirect: '/home',
    children:[
      {
        path:'home',
        name:'Home',
        component: HomeContent
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
