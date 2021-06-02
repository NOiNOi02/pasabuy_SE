<template class="">
 <loading v-if="logginIn"/>
<div v-if="!logginIn">
 <!-- <loading
     :show="show"
     :label="label"
     event-show="show-my-full-loading"
     event-hide="hide-my-full-loading">
 </loading> -->
  <div class="flex items-center ">
        <router-link to="/">
        <img src="/img/pasaBUYLogoOnly.png" class="block w-16 h-16 ">
        </router-link>
        <h1 class="absolute block text-xl font-black tracking-widest left-16 font-raleway text-red-buttons">pasaBUY</h1>
      </div>

  <div
    id="login"
    class="items-center flex justify-center w-full mt-10 pb-16 bg-transparent px-3"
  >
    <div
      class="overflow-hidden font-bold text-center bg-white shadow-md w-full rounded-xl lg:w-97 2xl:w-97 xl:w-97 md:w-97 sm:w-97"
    >
      <div class="px-10 py-16">
        <h1 class="space-x-1 space-y-1 text-2xl">Welcome back!</h1>
        <p class="mb-5 space-y-1 font-light text-gray-500">
          Log in with your email and password
        </p>
        <form action="#" @submit.prevent="loginUser">
          <p class="w-full text-red-700">{{ errors }}</p>
          <div class="">
            <input
              v-model="dataForm.email"
              aria-label="Email"
              name=""
              type="email"
              required
              class="relative block w-full h-12 px-3 py-2 mt-8 mb-6 text-gray-900 placeholder-gray-500 bg-gray-200 border rounded-lg appearance-none focus:outline-none focus:shadow-outline-blue focus:border-blue-300 focus:z-10 sm:text-sm"
              placeholder="Email"
            />
          </div>
          <div class="text-2xl">
            <input
              v-model="dataForm.password"
              aria-label="Password"
              name=""
              type="password"
              required
              class="relative block w-full h-12 px-3 py-2 text-sm placeholder-gray-500 bg-gray-200 border rounded-lg appearance-none focus:outline-none focus:shadow-outline-blue focus:border-blue-300 focus:z-10 focus:text-l"
              placeholder="Password"
            />
          </div>
          <div class="mt-6 text-left text-md text-grey-dark">
            <a class="font-bold underline-none" href="#">
              <router-link to="/forgot-password">
                Forgot Password?
              </router-link>
            </a>
          </div>
          <div class="flex justify-center py-5" v-if="!logginIn1">
            <button
              class="w-full h-12 py-2 text-white transition-colors duration-150 bg-red-buttons px-7 rounded-3xl focus:outline-none"
            >
              Log in
            </button>
          </div>
         
              <!-- --- Loging in loading -->
                    <div class="flex justify-center py-5" v-if="logginIn1">
                      <button class="relative w-full h-12 py-2 text-white transition-colors duration-150 bg-red-buttons px-7 rounded-3xl focus:outline-none" disabled>
                        <img src="/img/loading.gif" class="w-35 h-20 ml-14 absolute" style="margin-top:-7%;" /> <span class="ml-10"> Logging In</span>
                      </button>
                    </div>
                    <!-- --- -->
        </form>
        <div
          class="mt-4 font-normal text-left text-gray-500 text-md text-grey-dark"
        >
          Need an account?
          <router-link
            class="font-bold text-black border-b border-grey-dark"
            to="/sign-up"
            >Register</router-link
          >
        </div>
      </div>
    </div>
  </div>
  </div>
  <!---End -->
</template>


<style>
#journal-scroll::-webkit-scrollbar {
  width: 5px;
  cursor: pointer;
}

#journal-scroll::-webkit-scrollbar-track {
  background-color: rgba(229, 231, 235, var(--bg-opacity));
  cursor: pointer;
}

#journal-scroll::-webkit-scrollbar-thumb {
  cursor: pointer;
  background-color: rgba(185, 28, 28);
}

#iCheck {
  font-size: 16px;
  color: rgb(22, 22, 141);
}
#iMessage {
  font-size: 24px;
  color: rgb(22, 22, 141);
}
</style>
<script>
// import api from "../api";
import store from "../store/index";
import api from "../api-guest"
// import loading from 'vue-full-loading'
import loading from './loading';
export default {
  components: {
    loading
  },
  data() {
    return {
      dataForm: {
        email: "",
        password: "",
      },
      errors: null,
      show: false,
      label: 'Loading...',
      logginIn:false,
      logginIn1:false

    };
  },
  methods: {
    loginUser() {
      this.show = !this.show
      this.logginIn1 = !this.logginIn1
      
      api.get("/sanctum/csrf-cookie").then(() => {
        // Login...
        api
          .post("/api/login", this.dataForm)
          .then((res) => {
            sessionStorage.setItem("isLoggedIn", true);
            sessionStorage.setItem("sessionCookieNotify", true)
            sessionStorage.setItem("Authorization", res.data.token)
            console.log('api token in login',sessionStorage.getItem("Authorization"))
            this.logginIn1 = !this.logginIn1
            this.logginIn = true
            this.dispatches().then(() => {
              //wait for the dispatches to finish
              this.show = !this.show
              this.$router.push({ name: "dashboard" });
            });
          })
          .catch((errors) => {
            this.show = !this.show
            this.errors = errors.response.data.invalid;
            // this.logginIn = false
            this.logginIn1 = !this.logginIn1
          });
      });
      // setTimeout(() => {
      //   this.isLoading = false;
      // }, 5000);
      
    },
    async dispatches() {
      await store.dispatch("getAuthUser");
      await store.dispatch("getPersonal");
      await store.dispatch("getUserAddress");
      await store.dispatch("getPosts");
      await store.dispatch("getUnreadNotifications");
      await store.dispatch("getAllNotifications");
      await store.dispatch("getChatRoom");
      await store.dispatch("getUserTransactions");
      await store.dispatch("getUserShippingAddress");
      await store.dispatch("getTransportModes");
      await store.dispatch("getShoppingPlaces");
      await store.dispatch("getAllShares");
      await store.dispatch("getUserShoppingList");
      await store.dispatch("getAllReviews");
      await store.dispatch("getAuthUserFollow",this.dataForm.email);
      await store.dispatch("getAllUserAbout");
      await store.dispatch("getAuthEducation");
      await store.dispatch("getVerifiedUsers");
      await store.dispatch("getAllTransactions");

    },
  },

  created: function () {
    document.body.style.backgroundColor = "rgb(235,235,235)";
  },
  computed: {
    user() {
      return store.getters.getUser;
    },
  },
};
</script>