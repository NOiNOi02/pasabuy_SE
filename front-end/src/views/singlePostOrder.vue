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
            }}[Order]</span
          >
          <span
            class="text-green-150 ring-1 text-xs w-max px-2 py-1 rounded-md font-bold ring-green-150"
            >{{ currentTransaction.transactionStatus }}</span
          >
        </div>
        <div v-if="false" class="w-1/2 flex justify-end">
          <span class="text-gray-500 opacity-75 font-semibold"
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
        <p class="uppercase font-semibold text-gray-500">Shopper</p>
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
</template>

<script>
import Nav from "../views/Navbar.vue";
import store from "../store/index";
import moment from "moment";
export default {
  created: function () {
    document.body.style.backgroundColor = "#EBEBEB";
  },
  components: {
    Nav,
  },
  data() {
    return {
      selected: "Completed",
      currentTransaction: JSON.parse(atob(this.$route.query.transaction))[0],
      items: [
        {
          list: "Pork",
          size: "1kl",
          brand: "Anybrand",
          quantity: 2,
        },
      ],
    };
  },
  methods: {
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
      var postedDate = new Date(datetime);
      const today = moment().endOf("day");
      const yesterday = moment().add(-1, "day").endOf("day");

      if (postedDate < today)
        return moment(datetime).format("[Today at] h:mm a");
      if (postedDate > yesterday)
        return moment(datetime).format("[Yesterday at] h:mm a");
      else return moment(datetime).format("MMM DD, YYYY [at] h:mm a");
    },
    starRate(reviews) {
          var temp = reviews;
      var ctr = 0;
      for (var i = 0; i < temp.length; i++) {
        ctr = ctr + temp[i].rate;
        // console.log(temp[i])
      }
      var rate = ctr / (i).toFixed(1);
            return (rate == null) || isNaN(rate) ? 0 : rate;

    },
    userReviews(userEmail) {
      return this.reviews.filter((x) => {
        return x.revieweeEmail == userEmail;
      });
    },
    timestampSched(datetime) {
      var schedDate = new Date(datetime);
      const today = moment().endOf("day");
      const tomorrow = moment().add(1, "day").endOf("day");
      if (schedDate < today) {
        return moment(datetime).format("[Today at] h:mm a");
      }
      if (schedDate < tomorrow) {
        return moment(datetime).format("[Tommorow at] h:mm a");
      }

      return moment(datetime).format("[From] MMM DD, YYYY [at] h:mm a");
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
    // var trans = JSON.parse(JSON.stringify(this.transactions));
    // var temp = this.transactions.filter((x) => {
    //   return x.transactionNumber === atob(this.$route.query.transactionNumber);
    // });
    // this.currentTransaction = temp[0];
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