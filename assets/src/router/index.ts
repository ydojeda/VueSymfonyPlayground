import {createRouter, createWebHashHistory} from "vue-router";
import HomeScreen from "@pages/HomeScreen.vue";

const About = { template: '<div>About</div>' }

// 2. Define some router
// Each route should map to a component.
// We'll talk about nested router later.
export default createRouter({
  history: createWebHashHistory(),
  routes: [
    { path: '/', name: 'Home', component: HomeScreen },
    { path: '/about', name: 'About', component: About },
  ]
})