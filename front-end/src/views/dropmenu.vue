<template>
  <div class="border-black">
    <button
      @click="isOpen = !isOpen"
      class="focus:outline-none h-10 w-10 border-2 rounded-full border-red-700"
    >
      <img class="h-9.7 w-10 rounded-full" :src="userPersonal.profilePicture" />
    </button>
  </div>
  <div class="w-full">
    <div
      v-if="isOpen"
      class="shadow-xl fixed bg-white space-y-2 h-auto w-30 ring-2 ring-gray-200 right-0 rounded-lg py-2 pl-4 pr-4 pt-2 mr-16 mt-2"
    >
      <button
        @click="setDispatches(userPersonal.email)"
        class="flex flex-row gap-x-2 text-black"
      >
        <span class="material-icons text-gray-500">account_circle</span>Profile
      </button>
      <router-link :class="{ disabled: !ifUserVerified(user.email) }" to="/orders" class="flex flex-row gap-x-2 text-black"
        ><div class="flex items-center space-x-2">
          <span class="material-icons text-gray-500">shopping_bag</span
          ><a>Orders</a>
          <span
            class="left-24 right-0 absolute items-center w-6 h-6 bg-red-buttons text-white rounded-full flex justify-center"
            ><p>{{ confirmedOrders.length }}</p></span
          ><span class="pl-5 text-gray-400" v-if="!ifUserVerified(user.email)">Get Verified</span>
        </div></router-link
      >
      <router-link :class="{ disabled: !ifUserVerified(user.email) }" class='flex flex-row gap-x-2 text-black' to="/deliver" 
        ><div class="flex items-center space-x-2">
          <span class="material-icons text-gray-500">delivery_dining</span
          ><a>Deliveries</a
          ><span
            class="left-28 right-0 absolute items-center w-6 h-6 bg-red-buttons text-white rounded-full flex justify-center"
            ><p>{{ confirmedDeliveries.length }}</p></span
          >
          <span class="pl-5 text-gray-400" v-if="!ifUserVerified(user.email)">Get Verified</span>
        </div>
      </router-link>
      <router-link  to="/shopping-list" class="flex flex-row gap-x-2 text-black"
        ><span class="material-icons text-gray-500">list</span>Shopping
        Lists  <span class="pl-5 text-gray-400" v-if="!ifUserVerified(user.email)">Get Verified</span>
         </router-link
      >
       
      <router-link
        to="/account-settings"
        class="flex flex-row gap-x-2 text-black"
        ><span class="material-icons text-gray-500">manage_accounts</span
        >Account Setting</router-link
      >
      <button @click="logout" class="flex flex-row gap-x-2 text-black">
        <span class="material-icons text-gray-500">logout</span>Log out
      </button>
      <p class="text-gray-500 text-sm">
        Privacy Policy-Cookies Policy-Terms and Conditions<br />
        Return and Refund Policy-PasaBuy 2021
      </p>
    </div>
  </div>
</template>


<script>
import api from "../api";
import store from "../store/index";
export default {
  data() {
    return {
      active_order: 2,
      active_delivery: 2,
      isOpen: false,
    };
  },
  components: {},
  methods: {
    logout() {
      console.log("logout");
      window.Echo.leave("App.Models.User." + this.user.indexUserAuthentication);
      window.Echo.leave("public.123");
      api.post("api/logout").then(() => {
        sessionStorage.removeItem("vuex");
        sessionStorage.removeItem("isLoggedIn");
        sessionStorage.removeItem("sessionCookieNotify");
        sessionStorage.removeItem("Authorization");
        this.$router.push({ name: "Home" });
      });
    },
    toEncrypt(val) {
      return btoa(val);
    },
    setDispatches(email) {
      store.dispatch("getUserInfo", email).then(() => {
        store.dispatch("getNotAuthUserAddress", email).then(() => {
          store.dispatch("getUserFollow", email).then(() => {
            this.$router.push({
              name: "Profile",
              query: { ID: this.toEncrypt(email) },
            });
          });
        });
      });
    },
    ifUserVerified(email) {
      var temp = this.verifiedUsers.filter((x) => {
        return x.email === email && x.verifyStatus == "verified";
      });
      if (temp.length <= 0) {
        return false;
      } else {
        return true;
      }
    },
  },
  computed: {
    verifiedUsers() {
      return store.getters.getVerifiedUsers;
    },
    user() {
      return store.getters.getUser;
    },
    userPersonal() {
      return store.getters.getPersonal;
    },
    confirmedOrders() {
      return store.getters.getUserTransactions.filter((x) => {
        return (
          (x.transactionStatus == "Confirmed" ||
            x.transactionStatus == "In Transit") &&
          ((x.post.postIdentity == "request_post" &&
            x.post.email == this.user.email) ||
            (x.post.postIdentity == "offer_post" &&
              x.post.email != this.user.email))
        );
      });
    },
    confirmedDeliveries() {
      return store.getters.getUserTransactions.filter((x) => {
        return (
          (x.transactionStatus == "Confirmed" ||
            x.transactionStatus == "In Transit") &&
          ((x.post.postIdentity == "request_post" &&
            x.post.email != this.user.email) ||
            (x.post.postIdentity == "offer_post" &&
              x.post.email == this.user.email))
        );
      });
    },
  },
};
</script>
<style scoped>
.disabled {
    opacity: 0.5;
    pointer-events: none;
}
</style>