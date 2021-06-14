<template>
  <Nav />

  <div class="mt-28 flex justify-center px-4 py-2 h-full self-center">
    <div
      class="w-full space-y-2 xl:w-100 2xl:w-100 lg:w-100 bg-white rounded-lg shadow-sm px-6 py-4"
    >
      <div class="flex justify-between">
        <div
          class="flex flex-col w-full space-y-2 items-start xl:flex-row xl:space-y-0 xl:space-x-4"
        >
          <span class="font-bold"
            >Transaction #{{
              currentTransaction.transactionNumber
            }}[Delivery]</span
          >
          <span
            class="text-green-150 ring-1 text-xs w-max px-2 py-1 rounded-md font-bold ring-green-150"
            >{{ currentTransaction.transactionStatus }}</span
          >
        </div>
        <div class="w-1/4 flex justify-end">
          <span
            v-if="currentTransaction.transaction_sender.email != user.email"
            @click="
              (toggle_status = !toggle_status),
                setDataToSave(
                  currentTransaction.transaction_sender.email,
                  currentTransaction.indexTransactionPost,
                  currentTransaction.postNumber
                )
            "
            class="text-gray-500 opacity-75 font-semibold"
            >Update Status</span
          >
          <span
            v-else
            @click="
              (toggle_status = !toggle_status),
                setDataToSave(
                  currentTransaction.post.email,
                  currentTransaction.indexTransactionPost,
                  currentTransaction.postNumber
                )
            "
            class="text-gray-500 opacity-75 font-semibold"
            >Update Status</span
          >
        </div>
      </div>
      <div>
        <span class="top-6 text-gray-500"
          >Placed on {{ timestamp(currentTransaction.dateCreated) }}</span
        >
      </div>
      <div
        class="flex items-start gap-x-8 my-3 flex-col 2xl:items-center 2xl:flex-row xl:items-center xl:flex-row lg:items-center lg:flex-row md:flex-row"
      >
        <p class="uppercase font-semibold text-gray-500">Customer</p>
        <div
          class="flex gap-x-3 items-center space-x-3"
          v-if="user.email != currentTransaction.post.user.email"
        >
          <img
            class="w-8 h-8 border rounded-full border-gray-700 shadow-md"
            :src="currentTransaction.post.user.profilePicture"
          /><!--Profile Pic-->
          <div class="flex flex-col">
            <div class="flex items-center space-x-2">
              <p class="font-bold">
                {{ currentTransaction.post.user.firstName }}
                {{ currentTransaction.post.user.lastName }}
              </p>
              <span class="material-icons text-md text-blue-800">
                verified
              </span>
            </div>
            <!--name-->
            <span class="flex gap-x-1">
              <p class="font-bold text-gray-500 text-sm">
                {{ starRate(userReviews(currentTransaction.post.email)) }}
              </p>
              <p class="material-icons text-sm text-red-700">star</p>
            </span>
          </div>
          <!--chat button-->

          <!--/chat button-->
        </div>
        <div class="flex gap-x-3 items-center space-x-3" v-else>
          <img
            class="w-8 h-8 border rounded-full border-gray-700 shadow-md"
            :src="currentTransaction.transaction_sender.profilePicture"
          /><!--Profile Pic-->
          <div class="flex flex-col">
            <div class="flex items-center space-x-2">
              <p class="font-bold">
                {{ currentTransaction.transaction_sender.firstName }}
                {{ currentTransaction.transaction_sender.lastName }}
              </p>
              <span class="material-icons text-md text-blue-800">
                verified
              </span>
            </div>
            <!--name-->
            <span class="flex gap-x-1">
              <p class="font-bold text-gray-500 text-sm">
                {{
                  starRate(
                    userReviews(currentTransaction.transaction_sender.email)
                  )
                }}
              </p>
              <p class="material-icons text-sm text-red-700">star</p>
            </span>
          </div>
          <!--chat button-->

          <!--/chat button-->
        </div>
        <button
          v-if="currentTransaction.post.email != user.email"
          class="flex items-center gap-x-2 focus:outline-none bg-green-150 rounded-2xl p-2"
        >
          <p class="material-icons text-white text-sm">chat</p>
          <router-link
            :to="'/messages/?ID=' + toEncrypt(currentTransaction.post.email)"
            class="font-bold text-white text-sm"
            >Chat Shopper</router-link
          >
        </button>
        <button
          v-else
          class="flex items-center gap-x-2 focus:outline-none bg-green-150 rounded-2xl p-2"
        >
          <p class="material-icons text-white text-sm">chat</p>
          <router-link
            :to="
              '/messages/?ID=' +
              toEncrypt(currentTransaction.transaction_sender.email)
            "
            class="font-bold text-white text-sm"
            >Chat Shopper</router-link
          >
        </button>
      </div>
      <div
        v-if="currentTransaction.transactionStatus == 'Completed'"
        class="space-y-2 w-full p-4 ring-2 ring-gray-300 rounded-xl"
      >
        <p class="text-sm select-none">
          Transaction marked as completed on
          {{ timestamp(currentTransaction.dateModified) }}.
        </p>
        <span class="flex space-x-2"
          ><p class="text-gray-400">Would you like to review the shopper?</p>
          <button
            @click="setDispatches(itemx.transaction_sender.email)"
            class="cursor-pointer"
          >
            Write a review.
          </button></span
        >
      </div>
      <div class="grid grid-cols-2 px-4 py-2 gap-y-4 text-sm">
        <div class="flex items-center space-x-2">
          <span class="material-icons text-red-buttons"> fmd_good </span>
          <p>{{ currentTransaction.post.request_post.deliveryAddress }}</p>
        </div>
        <div class="flex items-center space-x-2">
          <span class="material-icons text-red-buttons"> shopping_cart </span>
          <p>{{ currentTransaction.post.request_post.shoppingPlace }}</p>
        </div>
        <div class="flex items-center space-x-2">
          <span class="material-icons text-red-buttons"> watch_later </span>
          <p>
            {{
              timestampSched(
                currentTransaction.post.request_post.deliverySchedule
              )
            }}
          </p>
        </div>
        <div class="flex items-center space-x-2">
          <span class="material-icons text-red-buttons"> payments </span>
          <p>{{ currentTransaction.post.request_post.paymentMethod }}</p>
        </div>
      </div>
      <div class="bg-gray-200 py-1 px-3 rounded-2xl">
        <div class="flex text-sm space-x-2">
          <p>Shopping List</p>
          <div class="flex">
            <p class="text-gray-500">
              {{
                computedShopItemList(currentTransaction.transactionShoppingList)
                  .length
              }}
            </p>
            <p
              v-if="
                computedShopItemList(currentTransaction.transactionShoppingList)
                  .length > 1
              "
              class="text-gray-500"
            >
              items
            </p>
            <p v-else class="text-gray-500">item</p>
          </div>
        </div>
        <ul id="example-1" class="list-disc text-sm space-y-2 list-inside p-5">
          <li
            v-for="item in computedShopItemList(
              currentTransaction.transactionShoppingList
            )"
            :key="item.id"
            class="list-disc items-center"
          >
            <label class="text-md" style="font-size: 16px"
              >{{ item.product }}({{ item.size }})-{{ item.brand }} [{{
                item.quantity
              }}unit/s]</label
            >
          </li>
        </ul>
      </div>
    </div>
  </div>

  <div
    v-if="toggle_status"
    class="fixed bg-black z-100 h-max w-screen bg-opacity-75 overflow-y-auto items-center inset-0"
  >
    <div class="flex mt-4 w-full p-3 items-center justify-center py-20">
      <div
        class="bg-white ring-1 ring-gray-300 p-5 w-full rounded-xl 2xl:w-97 lg:w-97 xl:w-97 xl:mr-16 md:w-8/12 sm:w-10/12 shadow-2xl h-auto"
      >
        <div class="flex flex-row items-center justify-between p-3">
          <p class="hidden lg:block 2xl:block xl:block"></p>
          <p class="text-lg font-bold xl:ml-8 lg:ml-8 2xl:ml-8">
            Update Delivery Status
          </p>
          <p
            class="font-bold text-blue-700 cursor-pointer left-10"
            @click="
              (toggle_status = false),
                (userNotif = null),
                (updatingTransaction = null),
                (updatingPost = null)
            "
          >
            Close
          </p>
        </div>
        <hr />
        <div class=" ">
          <div class="flex flex-col p-3 space-y-4">
            <span class="flex items-center space-x-2"
              ><label
                ><input
                  type="radio"
                  name="status"
                  value="Completed"
                  id="completedDeliver"
                />
                Completed</label
              ></span
            >
            <span class="flex items-center space-x-2"
              ><label
                ><input
                  type="radio"
                  name="status"
                  value="In Transit"
                  id="inTransitDeliver"
                />
                In Transit</label
              ></span
            >
            <span class="flex items-center space-x-2"
              ><label
                ><input
                  type="radio"
                  name="status"
                  value="Cancelled"
                  id="cancelledDeliver"
                />
                Cancelled
              </label></span
            >
          </div>
        </div>
        <div class="flex justify-between mt-4 items-center">
          <button
            @click="(toggle_status = false), updateStatus()"
            class="bg-red-buttons text-white focus:outline-none w-full h-7 shadow-xl ring-1 ring-gray-300 rounded-2xl"
          >
            Update
          </button>
        </div>
      </div>
    </div>
  </div>
  <div class="bg-transparent fixed bottom-3 w-full flex flex-col items-end">
    <div
      v-if="popUp3"
      class="sm:w-z md:w-z lg:w-z llg:w-z xl:w-z xll:w-z 2xl:w-z 2xxl:w-z md:right-7 lg:right-7 llg:right-7 xl:right-7 xll:right-7 2xl:right-7 2xxl:right-7 mx-2 rounded-xl flex justify-between flex-row shadow-lg bg-black text-white border px-4 pb-4 pt-4 xsm:h-auto ssm:h-auto vsv:h-auto vsvs:h-auto lvs:h-auto sm:h-auto md:h-auto"
    >
      <div class="flex items-center">
        <span class="icons material-icons" style="color: #9ca3af"
          >check_circle</span
        >
        <span class="ml-2 text-sm"> Successfully updated transaction.</span>
      </div>
      <div class="flex items-center">
        <button
          @click="popUp3 = false"
          class="focus:outline-none hover:text-red-700 hover:bg-white rounded-full h-6"
          type="button"
        >
          <span class="material-icons"> cancel</span>
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import Nav from "./Navbar.vue";
import store from "../store/index";
import moment from "moment";
import api from "../api";

export default {
  created: function () {
    document.body.style.backgroundColor = "#EBEBEB";
  },
  components: {
    Nav,
  },
  data() {
    return {
      popUp3: false,
      toggle_status: false,
      currentTransaction: JSON.parse(atob(this.$route.query.transaction))[0],
      selected: "Completed",
      items: [
        {
          list: "Pork",
          size: "1kl",
          brand: "Anybrand",
          quantity: 2,
        },
      ],
      updatingTransaction: null,
      updatingPost: null,
      userNotif: null,
    };
  },
  methods: {
    setDataToSave(email, indexTransactionPost, postNumber) {
      this.userNotif = email;
      this.updatingTransaction = indexTransactionPost;
      this.updatingPost = postNumber;
    },
    updateStatus() {
      var complete = document.getElementById("completedDeliver").checked;
      var cancel = document.getElementById("cancelledDeliver").checked;
      var inTransit = document.getElementById("inTransitDeliver").checked;
      if (complete) {
        api
          .post("api/updateTransaction", {
            userNotif: this.userNotif,
            status: "Completed",
            ID: this.updatingTransaction,
            postNumber: this.updatingPost,
          })
          .then(() => {
            store.dispatch("getUserTransactions").then(() => {
              this.toggle_status = false;
              this.updatingTransaction = null;
              this.updatingPost = null;
              this.allDeliveries = this.deliveries;
              this.popUp3 = true;
            });
          })
          .catch((error) => {
            console.log(error.response.data.error, "Error", "error");
          });
      } else if (cancel) {
        api
          .post("api/updateTransaction", {
            userNotif: this.userNotif,
            status: "Cancelled",
            ID: this.updatingTransaction,
            postNumber: this.updatingPost,
          })
          .then(() => {
            store.dispatch("getUserTransactions").then(() => {
              this.toggle_status = false;
              this.updatingTransaction = null;
              this.updatingPost = null;
              this.allDeliveries = this.deliveries;
              this.popUp3 = true;
            });
          })
          .catch((error) => {
            console.log(error.response.data.error, "Error", "error");
          });
      } else if (inTransit) {
        api
          .post("api/updateTransaction", {
            userNotif: this.userNotif,
            status: "In Transit",
            ID: this.updatingTransaction,
            postNumber: this.updatingPost,
          })
          .then(() => {
            store.dispatch("getUserTransactions").then(() => {
              this.toggle_status = false;
              this.updatingTransaction = null;
              this.updatingPost = null;
              this.allDeliveries = this.deliveries;
              this.popUp3 = true;
            });
          })
          .catch((error) => {
            console.log(error.response.data.error, "Error", "error");
          });
      }
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
       timestamp(datetime) {
      var postedDate = moment(datetime);
      const today = moment().endOf("day");
      const yesterday = moment().add(-1, "day").endOf("day");
      if (moment(postedDate).isBefore(yesterday))
        return moment(datetime).format("[Yesterday at] h:mm a");
      if (moment(postedDate).isBefore(today))
        return moment(datetime).format("[Today at] h:mm a");
      else return moment(datetime).format("MMM DD, YYYY [at] h:mm a");
    },
    timestampSched(datetime) {
      var schedDate = moment(datetime);
      const today = moment();
      const startOfTomorrow = moment().add(1, "day").startOf("day");
      const endOfTomorrow = moment().add(1, "day").endOf("day");
     
      if (moment(schedDate).isBefore(today)) {
        return moment(datetime).format("[From] MMM DD, YYYY [at] h:mm a");
      }
      if (moment(schedDate).isAfter(today)) {
        if (moment(schedDate).isAfter(endOfTomorrow))
          return moment(datetime).format("[From] MMM DD, YYYY [at] h:mm a");
        if (moment(schedDate).isBefore(startOfTomorrow))
          return moment(datetime).format("[Today at] h:mm a");
        else return moment(datetime).format("[Tommorow at] h:mm a");
      }
    },
    starRate(reviews) {
      var temp = reviews;
      var ctr = 0;
      for (var i = 0; i < temp.length; i++) {
        ctr = ctr + temp[i].rate;
        // console.log(temp[i])
      }
      var rate = ctr / i.toFixed(1);
      return rate == null || isNaN(rate) ? 0 : rate;
    },
    userReviews(userEmail) {
      return this.reviews.filter((x) => {
        return x.revieweeEmail == userEmail;
      });
    },
  
    computedShopItemList(list) {
      if (list != null) {
        var temp = list.filter((x) => {
          return x.status == 1;
        });
        return temp;
      }
      return null;
    },
  },
  mounted() {
    console.log(this.currentTransaction, "aa");
  },
  computed: {
    reviews() {
      return store.getters.getAllReviews;
    },
    user() {
      return store.getters.getUser;
    },
    transactions() {
      return store.getters.getUserTransactions;
    },
  },
};
</script>

<style>
</style>