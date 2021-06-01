<template>
  <div class="flex">
    <!-- mobile menu bar -->
    <div class="w-full bg-gray-800 text-gray-100 flex justify-between">
      <!-- logo -->
      <!-- mobile menu button -->
      <nav
        class="z-40 h-20 bg-red-buttons w-full fixed flex items-center justify-between font-nunito p-0 2xl:bg-white 2xl:shadow-md xl:bg-white xl:shadow-md lg:bg-white lg:shadow-md mt-0"
      >
        <!--Logo-->
        <div class="flex items-center">
          <button
            class="material-icons 2xl:hidden xl:hidden lg:hidden ml-4 text-white block"
            @click="toggle_event()"
          >
            menu
          </button>
          <p
            class="uppercase font-bold 2xl:hidden xl:hidden lg:hidden block text-white h-full"
          >
            {{ currentRoute }}
          </p>
          <div class="flex items-center">
            <img
              src="/img/pasaBUYLogoOnly.png"
              class="w-16 h-16 hidden 2xl:block xl:block lg:block"
            />
            <h1
              class="absolute text-xl font-black tracking-widest top-6 left-16 font-raleway 2xl:text-red-700 xl:text-red-700 lg:text-red-700 hidden 2xl:block xl:block lg:block"
            >
              pasaBUY
            </h1>
          </div>
        </div>
        <img
          v-if="currentRoute == ''"
          src="/img/pasaBUYwhiteLogo.png"
          class="2xl:hidden xl:hidden lg:hidden block"
        />
        <div
          class="hidden 2xl:flex 2xl:ml-60 xl:flex xl:ml-72 lg:flex lg:ml-48 lg:space-x-0 lg:px-3 lg:w-97 w-608 justify-center items-center font-bold gap-x-10 text-gray-500"
        >
          <router-link to="/dashboard">
            <div class="flex gap-x-4 py-4">
              <span class="material-icons"> home </span>
              <p class="text text-gray-500">Home</p>
            </div>
          </router-link>

          <router-link to="/messages">
            <div class="flex gap-x-4 py-4 relative">
              <span class="material-icons cursor-pointer"> chat </span>
              <span
                class="absolute left-3 top-2 rounded-full font-semibold bg-balticsea text-white text-xs px-1 h-4"
                >{{ unreadNotifChat.length }}</span
              >
              <p class="text-gray-500">Messages</p>
            </div></router-link
          >

          <div
            class="flex gap-x-4 py-4 relative cursor-pointer items-center"
            @click="(activeBtn = !activeBtn), (show = !show)"
            :class="{ active_notif: activeBtn }"
          >
            <span id="notif" class="text-gray-500 material-icons \">
              notifications
            </span>
            <span
              id="btn_notif"
              class="text-base font-bold leading-none tracking-wide text-gray-500 outline-none"
              >Notifications</span
            >
            <span
              class="absolute left-3 top-2 rounded-full font-semibold bg-balticsea text-white text-xs px-1 h-4"
              >{{ unreadNotif.length }}</span
            >
          </div>
        </div>
        <div class="flex mr-2 gap-x-5">
          <button class="material-icons mr-2 text-white w-full">search</button>

          <div
            class="items-center hidden ring-2 ring-gray-400 rounded-2xl bg-white 2xl:flex xl:flex lg:flex"
          >
            <input
              type="search"
              class="focus:outline-none text-black lg:w-28 pl-3 rounded-2xl h-5"
              placeholder="Search"
              id="searchInput"
              @keyup.enter="dispatchSearch()"
            />
            <button class="material-icons mr-2 text-gray-400 w-full">
              <button @click="dispatchSearch()">search</button>
            </button>
          </div>
          <div class="hidden 2xl:block lg:block xl:block">
            <Dropdown />
          </div>
        </div>
        <div
          v-if="show"
          class="fixed hidden xl:block lg:block pb-24 2xl:block overflow-y-auto top-20 h-full right-60 pt-2 bg-white rounded-lg shadow-lg left--1"
          style="min-width: 370px"
        >
          <h1
            class="mt-4 mb-4 ml-4 text-black font-bold border-b align-text-leftCorner cursor-pointer"
          >
            Notifications
          </h1>

          <Notification />
        </div>
      </nav>
    </div>

    <!-- sidebar -->
    <div
      class="z-40 sidebar overscroll-y-contain overflow-auto lg:hidden 2xl:hidden border-r-2 h-max ssm:h-auto xl:hidden mt-20 bg-white font-bold text-gray-600 w-64 space-y-4 py-7 px-2 fixed inset-y-0 left-0 transform -translate-x-full transition duration-200 ease-in-out"
    >
      <!-- logo -->
      <div class="flex mt-0">
        <img src="/img/pasaBUYLogoOnly.png" class="w-12 h-10" />
        <p class="text-2xl text-red-700 font-extrabold">pasaBUY</p>
      </div>
      <!-- nav -->
      <nav class="space-y-8">
        <router-link to="/dashboard" class="rounded-2xl">
          <div class="mobile rounded-2xl items-center flex pl-2 h-10 space-x-2">
            <span class="material-icons"> home </span>
            <p class="text text-gray-500">Home</p>
          </div>
        </router-link>

        <router-link to="/messages" class="rounded-2xl">
          <div class="mobile rounded-2xl items-center flex h-10 space-x-2 pl-2">
            <span class="material-icons cursor-pointer"> chat </span>
            <p class="text-gray-500">Messages</p>
          </div></router-link
        >
        <router-link to="/notification" class="rounded-2xl">
          <div class="mobile rounded-2xl items-center flex h-10 space-x-2 pl-2">
            <span class="material-icons"> notifications </span>
            <p class="text-gray-500">Notifications</p>
          </div></router-link
        >
        <router-link to="/edit-profile" class="rounded-2xl">
          <div class="mobile rounded-2xl items-center flex h-10 pl-2 space-x-2">
            <span class="material-icons"> account_circle </span>
            <p class="text-gray-500">Profile</p>
          </div>
        </router-link>
        <hr />
        <router-link to="/orders" class="rounded-2xl">
          <div
            class="mobile rounded-2xl items-center flex h-10 mt-4 pl-2 space-2-x-4"
          >
            <span class="material-icons"> shopping_bag </span>
            <p class="text-gray-500">Orders</p>
          </div></router-link
        >
        <router-link to="/deliver" class="rounded-2xl">
          <div class="mobile rounded-2xl items-center flex h-10 space-x-2 pl-2">
            <span class="material-icons"> delivery_dining </span>
            <p class="text-gray-500">Deliveries</p>
          </div></router-link
        >
        <router-link to="/shopping-list" class="rounded-2xl">
          <div class="mobile rounded-2xl items-center flex h-10 space-x-2 pl-2">
            <span class="material-icons"> list </span>
            <p class="text-gray-500">Shopping Lists</p>
          </div></router-link
        >
        <router-link to="/account-settings" class="rounded-2xl">
          <div class="mobile rounded-2xl items-center flex h-10 space-x-2 pl-2">
            <span class="material-icons"> manage_accounts </span>
            <p class="text-gray-500">Account Settings</p>
          </div></router-link
        >
        <button @click="logout" class="rounded-2xl">
          <div class="mobile rounded-2xl items-center flex h-10 space-x-2 pl-2">
            <span class="material-icons"> logout </span>
            <p class="text-gray-500">Log Out</p>
          </div>
        </button>
      </nav>
      <p class="text-gray-500 text-sm">
        Privacy Policy-Cookies Policy-Terms and Conditions Return and Refund
        Policy-PasaBuy 2021
      </p>
    </div>
  </div>
</template>
<script>
import { computed } from "vue";
import { useRoute } from "vue-router";
import Dropdown from "./dropmenu.vue";
import Notification from "./Notification.vue";
import api from "../api";
import store from "../store/index";
import _ from "lodash";
import Axios from "axios";
export default {
  name: "navBar",
  components: {
    Dropdown,
    Notification,
  },
  beforeCreate: function () {
    document.body.className = "account";
  },
  data() {
    return {
      isOpen: false,
      show: false,
      activeBtn: false,
    };
  },
  methods: {
    dispatchSearch() {
      var input = document.getElementById("searchInput").value;
      var temp = JSON.parse(JSON.stringify(this.posts));
      console.log(temp);
      console.log(input);

      var result = temp.filter((x) => {
        if (x.postIdentity == "offer_post") {
          if (x.offer_post.caption != null) {
            return (
              x.offer_post.postStatus.toLowerCase().includes(input.toLowerCase()) ||
              x.offer_post.deliveryArea.toLowerCase().includes(input.toLowerCase()) ||
              x.offer_post.shoppingPlace.toLowerCase().includes(input.toLowerCase()) ||
              x.offer_post.transportMode.toLowerCase().includes(input.toLowerCase()) ||
              x.offer_post.paymentMethod.toLowerCase().includes(input.toLowerCase()) ||
              x.offer_post.capacity.toLowerCase().includes(input.toLowerCase()) ||
              x.offer_post.caption.toLowerCase().includes(input.toLowerCase()) ||
              x.user.firstName.toLowerCase().includes(input.toLowerCase()) ||
              x.user.lastName.toLowerCase().includes(input.toLowerCase())
            );
          } else {
            return (
              x.offer_post.postStatus.toLowerCase().includes(input.toLowerCase()) ||
              x.offer_post.deliveryArea.toLowerCase().includes(input.toLowerCase()) ||
              x.offer_post.shoppingPlace.toLowerCase().includes(input.toLowerCase()) ||
              x.offer_post.transportMode.toLowerCase().includes(input.toLowerCase()) ||
              x.offer_post.paymentMethod.toLowerCase().includes(input.toLowerCase()) ||
              x.offer_post.capacity.toLowerCase().includes(input.toLowerCase()) ||
              x.user.firstName.toLowerCase().includes(input.toLowerCase()) ||
              x.user.lastName.toLowerCase().includes(input.toLowerCase())
            );
          }
        } else if (x.postIdentity == "request_post") {
          if (x.request_post.caption != null) {
            return (
              x.request_post.postStatus.toLowerCase().includes(input.toLowerCase()) ||
              x.request_post.deliveryAddress.toLowerCase().includes(input.toLowerCase()) ||
              x.request_post.shoppingPlace.toLowerCase().includes(input.toLowerCase()) ||
              x.request_post.paymentMethod.toLowerCase().includes(input.toLowerCase()) ||
              x.request_post.caption.toLowerCase().includes(input.toLowerCase()) ||
              JSON.stringify(x.request_post.shoppingListContent).includes(
                input
              ) ||
              x.user.firstName.toLowerCase().includes(input.toLowerCase()) ||
              x.user.lastName.toLowerCase().includes(input.toLowerCase())
            );
          } else {
            return (
              x.request_post.postStatus.toLowerCase().includes(input.toLowerCase()) ||
              x.request_post.deliveryAddress.toLowerCase().includes(input.toLowerCase()) ||
              x.request_post.shoppingPlace.toLowerCase().includes(input.toLowerCase()) ||
              x.request_post.paymentMethod.toLowerCase().includes(input.toLowerCase()) ||
              JSON.stringify(x.request_post.shoppingListContent).includes(
                input
              ) ||
              x.user.firstName.toLowerCase().includes(input.toLowerCase()) ||
              x.user.lastName.toLowerCase().includes(input.toLowerCase())
            );
          }
        } else {
          console.log("not found");
        }
      });

       this.$router.push({
              name: "search",
              query: { search: this.toEncrypt(JSON.stringify(result)) },
            });
      console.log(result);
    },
    toggle_event() {
      const sidebar = document.querySelector(".sidebar");
      // add our event listener for the click
      sidebar.classList.toggle("-translate-x-full");
    },
    notif() {
      this.activeBtn = !this.activeBtn;
      this.show = !this.show;
    },
    debounceMethod: _.debounce((notif) => {
      if (
        notif == "App\\Notifications\\newTransactionNotification" ||
        notif == "App\\Notifications\\newMessageNotification"
      ) {
        api.get("api/getChatroom").then((res) => {
          store.commit("FETCH_ROOMS", res.data);
        });
      }
      Axios.all([
        api.get("api/getUnreadNotifications"),
        api.get("api/getNotifications"),
        api.get("api/getTransaction"),
      ]).then((resArr) => {
        store.commit("setUnreadNotifications", resArr[0].data);
        store.commit("setNotifications", resArr[1].data);
        store.commit("setUserTransactions", resArr[2].data);
      });
    }, 2000),
    debounceMethodGetPosts: _.debounce(() => {
      Axios.all([api.get("api/getPosts"), api.get("api/getShares")]).then(
        (resArr) => {
          store.commit("FETCH_POSTS", resArr[0].data);
          store.commit("setAllShares", resArr[1].data);
        }
      );
    }, 2000),
    clearNotif() {
      api.delete("api/clearNotif/").then(() => {
        store.dispatch("getAllNotifications");
      });
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
    logout() {
      console.log("logout");
      window.Echo.leave("App.Models.User." + this.user.indexUserAuthentication);
      window.Echo.leave("public.123");
      api.post("api/logout").then(() => {
        sessionStorage.removeItem("vuex");
        sessionStorage.removeItem("isLoggedIn");
        this.$router.push({ name: "Home" });
      });
    },
    toEncrypt(val) {
      return btoa(val);
    },
  },
  setup() {
    const currentRoute = computed(() => {
      return useRoute().name;
    });
    return { currentRoute };
  },
  mounted() {
    var roomId = 123;
    window.Echo.join(`public.${roomId}`)
      .here((users) => {
        //set the users who's already online before you online
        for (var i = 0; i < users.length; i++) {
          store.commit("setOnlineUsers", users[i].email);
        }
        console.log("users online are", users);
      })
      .joining((user) => {
        //add the user who just logged in tpo online
        store.commit("setOnlineUsers", user.email);
        console.log(user.email, " is online");
      })
      .leaving((user) => {
        //remove users who leave the channel to online
        store.commit("removeFromOnlineUsers", user.email);
        console.log(user.email, " leaved");
      })
      .listen(".post.new", () => {
        //
        this.debounceMethodGetPosts();
      })
      .error((error) => {
        console.error(error);
      });

    window.Echo.private(
      "App.Models.User." + this.user.indexUserAuthentication
    ).notification((notification) => {
      this.debounceMethod(notification.type);
    });
  },

  computed: {
    posts() {
      return store.getters.getPosts;
    },
    unreadNotif() {
      return store.getters.getUnreadNotif.filter((x) => {
        return (
          x.type != "App\\Notifications\\newTransactionNotification" &&
          x.type != "App\\Notifications\\newMessageNotification"
        );
      });
    },
    unreadNotifChat() {
      return store.getters.getUnreadNotif.filter((x) => {
        return (
          x.type == "App\\Notifications\\newTransactionNotification" ||
          x.type == "App\\Notifications\\newMessageNotification"
        );
      });
    },
    user() {
      return store.getters.getUser;
    },
    userPersonal() {
      return store.getters.getPersonal;
    },
  },
};
</script>
<style scoped>
.router-link-active .mobile {
  background-color: rgba(236, 233, 233, 0.705);
}
.router-link-active .mobile p {
  color: #cd0f0f;
}
.router-link-active {
  color: #cd0f0f;
}
.router-link-active {
  color: #cd0f0f;
  border-bottom: 5px solid #cd0f0f;
}
.router-link-active p {
  color: #cd0f0f;
}
.active_notif #notif {
  color: #cd0f0f;
}
.active_notif #btn_notif {
  color: #cd0f0f;
}
</style>
 