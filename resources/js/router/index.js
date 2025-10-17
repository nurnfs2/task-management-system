import { createRouter, createWebHistory } from "vue-router";
import NProgress from 'nprogress';
import { useAuth } from "@/stores";
import { Login, Dashboard } from "@/pages";

const routes = [
  {
    path: "/",
    name: "login",
    component: Login,
    meta: { title: "TaskMinder Login", guest: true }
  },
  {
    path: "/dashboard",
    name: "dashboard",
    component: Dashboard,
    meta: { title: "Dashboard", requiresAuth: true }
  },


];




const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  linkExactActiveClass: "active",
  scrollBehavior() {
      document.getElementById('app').scrollIntoView({ behavior: 'smooth' });
  },
  routes,
});

const DEFAULT_TITLE = "404";

router.beforeEach((to, from, next) => {
  document.title = to.meta.title || DEFAULT_TITLE;
  NProgress.start();

  const loggedIn = useAuth();

  console.log(loggedIn);


  if (to.matched.some((record) => record.meta.requiresAuth)) {
      if (!loggedIn.user.meta) {
        next({name: 'login'});
      }else{
        next();
      }
  }else if (to.matched.some((record) => record.meta.guest)) {
      if (loggedIn.user.meta) {
        next({name: 'dashboard'});
      }else{
        next();
      }
  }else{
    next();
  }


});


router.afterEach(() => {
  NProgress.done();
});
export default router;
