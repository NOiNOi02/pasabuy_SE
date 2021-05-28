import { createRouter, createWebHistory } from 'vue-router'
import Home from '../views/Home.vue'
import login from '../views/login.vue'
import signup from '../views/signup.vue'
import address from '../views/address.vue'
import uploadid from '../views/uploadid.vue'
import verifymessage from '../views/verifymessage.vue'
import ProfileEdit from '../views/ProfileEdit.vue'
import dashboard from '../views/dashboard.vue'
import accountsettings from '../views/accountset.vue'
import deliver from '../views/deliver.vue'
import orders from '../views/orders.vue'
import messages from '../views/messaging.vue'
import search from '../views/Search.vue'
import forgotpassword from '../views/forgotpass.vue'
import forgotPassVerify from '../views/forgotPassVerify.vue'
import verifyemail from '../views/verifyemail.vue'
import Shopping_List from '../views/shopping_list.vue'
import Notifications from '../views/mobile_notification.vue'
import forgotPasswordForm from '../views/forgot_password_form.vue'
import HelpCenter from '../views/helpCenter.vue'
import privacyPolicy from '../views/privacyPolicy.vue'
import TermsAndCondition from '../views/termsAndCon.vue'
import ReturnAndRefundPolicy from '../views/returnPolicy.vue'
import AboutUs from '../views/aboutUs.vue'
import Verification from '../views/verification.vue'
import VerifyPhone from '../views/verifyPhone.vue'
import cookies from '../views/cookiesPolicy.vue'
const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home,
    meta: {guest:true}
  },

  {
    path: '/log-in',
    name: 'login',
    component: login,
    meta: {guest:true}
  },

  {
    path: '/sign-up',
    name: 'signup',
    component: signup,
    meta: {guest:true}
  },

  {
    path: '/address-book',
    name: 'address',
    component: address,
    meta: {guest:true}
  },

  {
    path: '/upload-id',
    name: 'uploadid',
    component: uploadid,
    meta: {guest:true}
  },

  {
    path: '/verification-message',
    name: 'verifymessage',
    component: verifymessage,
    meta: {requiresAuth:true}
  },

  {
    path: '/edit-profile',
    name: 'Profile',
    component: ProfileEdit,
    meta: {requiresAuth:true}
  },

  {
    path: '/dashboard',
    name: 'dashboard',
    component: dashboard,
    meta: {requiresAuth:true}
  },

  {
    path: '/account-settings',
    name: 'accountsettings',
    component: accountsettings,
    meta: {requiresAuth:true}
  },

  {
    path: '/deliver',
    name: 'deliveries',
    component: deliver,
    meta: {requiresAuth:true}
  },

  {
    path: '/orders',
    name: 'orders',
    component: orders,
    meta: {requiresAuth:true}
  },

  {
    path: '/messages',
    name: 'messages',
    component: messages,
    meta: {requiresAuth:true}
  },

  {
    path: '/search',
    name: 'search',
    component: search,
    meta: {requiresAuth:true}
  },

  {
    path: '/forgot-password',
    name: 'forgotpassword',
    component: forgotpassword,
    meta: {guest:true}
  },

  
  {
    path: '/forgot-password-verify',
    name: 'forgotPassVerify',
    component: forgotPassVerify,
    meta: {guest:true}
  },

  {
    path: '/verify-email',
    name: 'verifyemail',
    component: verifyemail,
    meta: {guest:true}
  },
  

  {
    path: '/shopping-list',
    name: 'Shopping List',
    component: Shopping_List,
    meta: {requiresAuth:true}
  },

  {
    path: '/notification',
    name: 'Notification',
    component: Notifications,
    meta: {requiresAuth:true}
  },

  {
    path: '/forgot_password_form',
    name: 'forgotPasswordForm',
    component: forgotPasswordForm,
    meta: {guest:true}
  },

  {
    path: '/help-center',
    name: 'HelpCenter',
    component: HelpCenter
  },
  
  {
    path: '/privacy-policy',
    name: 'privacyPolicy',
    component: privacyPolicy
  },
  
  {
    path: '/cookies-policy',
    name: 'cookies',
    component:cookies 
  },


  {
    path: '/terms-and-condition',
    name: 'TermsAndCondition',
    component: TermsAndCondition
  },

  {
    path: '/return-and-refund-policy',
    name: 'ReturnAndRefundPolicy',
    component: ReturnAndRefundPolicy
  },
  {
    path: '/AboutUs',
    name: 'AboutUs',
    component: AboutUs
  },
   {
    path: '/Verification',
    name: 'Verification',
    component: Verification
  },
  {
    path: '/verifyPhone',
    name: 'VerifyPhone',
    component: VerifyPhone
  },

]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

function isLoggedIn(){
  return sessionStorage.getItem('isLoggedIn');
}

router.beforeEach((to, from, next) => {
  if (to.matched.some(record => record.meta.requiresAuth)){
    if(!isLoggedIn()){
      next({name: 'login'})
    }else{
      next()
    }
  }
  else if(to.matched.some(record => record.meta.guest)){
    if(isLoggedIn()){
      next({name: 'dashboard'})
    }else{
      next()
    }
  }else{
    next()
  }
})

export default router
