<template>
  <Nav />
  <div
    class="flex flex-col w-full ssm:w-max xsm:w-max justify-center font-nunito"
  >
    <div
      class="w-608 2xl:block 2xl:mt-24 lg:block lg:mt-24 lg:w-6/12 xl:block xl:mt-24 justify-center self-center gap-y-5 mt-16 hidden"
    >
      <p class="text-2xl font-nunito font-bold uppercase">orders</p>
    </div>

    <div
      class="mt-20 self-center px-2 w-full flex flex-col pb-4 2xl:flex-row 2xl:mt-0 2xl:self-center 2xl:justify-items-center 2xl:items-center lg:flex-row lg:self-center lg:justify-items-center lg:mt-0 xl:flex-row xl:self-center xl:justify-items-center xl:mt-0 md:flex-row md:mt-24 md:pl-4 md:items-center sm:flex-row space-y-3 2xl:w-608 2xl:px-0 lg:w-608 lg:px-0 xl:w-608 xl:px-0 md:w-10/12 md:px-0 sm:w-10/12"
    >
      <div class="mt-3 2xl:mr-2 xl:mr-2 lg:mr-2 md:mr-2">
        <button
          @click="isActive_function('btn1'), filter_obj('Orders')"
          :class="{ active: activeBtn === 0 }"
          type="button"
          class="font-bold focus:outline-none text-red-buttons px-3 py-1 shadow rounded-2xl bg-white w-full h-full"
        >
          <a> All Orders</a>
        </button>
      </div>
      <div class="flex items-center justify-between space-x-2">
        <button
          @click="isActive_function('btn2'), filter_obj('Completed')"
          :class="{ active: activeBtn === 'btn2' }"
          type="button"
          class="font-bold focus:outline-none text-green-150 px-3 py-1 shadow rounded-2xl bg-white w-full h-full"
        >
          <a>Complete</a>
        </button>
        <button
          @click="isActive_function('btn3'), filter_obj('Confirmed')"
          :class="{ active: activeBtn === 'btn3' }"
          type="button"
          class="font-bold focus:outline-none text-blue-700 px-3 py-1 shadow rounded-2xl bg-white w-full h-full"
        >
          <a>Confirmed</a>
        </button>
        <button
          @click="isActive_function('btn4'), filter_obj('Cancelled')"
          :class="{ active: activeBtn === 'btn4' }"
          type="button"
          class="font-bold focus:outline-none text-yellow-600 px-3 py-1 shadow rounded-2xl bg-white w-full h-full"
        >
          <a>Cancelled</a>
        </button>
      </div>
      <div class="mt-3 2xl:ml-2 xl:ml-2 lg:ml-2 md:ml-2">
        <button
          @click="isActive_function('btn5'), filter_obj('In Transit')"
          :class="{ active: activeBtn === 'btn5' }"
          type="button"
          class="font-bold focus:outline-none text-yellow-600 px-3 py-1 shadow rounded-2xl bg-white w-full h-full"
        >
          <a> In Transit</a>
        </button>
      </div>
    </div>
    <div v-for="itemx in allOrders" :key="itemx.indexTransactionPost">
      <div
        class="p-5 w-full flex flex-col space-y-4 items-center 2xl:p-0 xl:p-0 lg:p-0"
      >
        <div
          class="flex flex-col justify-center self-center 2xl:w-608 2xl:mb-4 lg:w-608 xl:mb-4 xl:w-608 lg:mb-4 md:w-10/12 sm:w-10/12 w-full bg-white ring-1 ring-gray-300 p-5 rounded-2xl"
        >
          <div class="flex justify-between">
            <div class="flex flex-col gap-4">
              <span class="flex vs:flex-col gap-x-3">
                <p class="font-bold font-nunito">
                  Transaction #{{ itemx.transactionNumber }}
                </p>
                <div>
                  <p
                    v-if="itemx.transactionStatus == 'Completed'"
                    class="text-center rounded-md tracking-wider text-green-150 ring-1 ring-green-150 bg-white text-xs h-min w-18 self-center p-1 font-nunito font-bold"
                  >
                    {{ itemx.transactionStatus }}
                  </p>
                  <p
                    v-else-if="itemx.transactionStatus == 'Confirmed'"
                    class="text-center rounded-md tracking-wider text-blue-700 ring-1 ring-blue-700 bg-gray-200 text-xs h-min w-18 self-center p-1 font-nunito font-bold"
                  >
                    {{ itemx.transactionStatus }}
                  </p>
                  <p
                    v-else
                    class="text-center tracking-wider text-yellow-600 rounded-md bg-white ring-1 ring-yellow-600 text-xs h-min w-18 self-center p-1 font-nunito font-bold"
                  >
                    {{ itemx.transactionStatus }}
                  </p>
                </div>
              </span>
            </div>
           
          </div>
          <span class="text-gray-500 mt-2"
            >Place on {{ timestamp(itemx.dateCreated) }}</span
          >
          <div
            class="flex items-start gap-x-8 my-3 flex-col 2xl:items-center 2xl:flex-row xl:items-center xl:flex-row lg:items-center lg:flex-row md:flex-row"
          >
            <p class="uppercase font-bold text-gray-500">customer:</p>
            <div class="flex gap-x-3 items-center space-x-3" v-if="itemx.post.email != user.email">
              <img
                class="w-8 h-8 border rounded-full border-gray-700 shadow-md"
                :src="itemx.post.user.profilePicture"
              /><!--Profile Pic-->
              <span class="flex flex-col">
                <p class="font-bold">{{ itemx.post.user.firstName }} {{ itemx.post.user.lastName }}</p>
                <!--name-->
                <span class="flex gap-x-1">
                  <p class="font-bold text-gray-500 text-sm">
                     {{ starRate(userReviews(itemx.transaction_sender.email )) }}
                  </p>
                  <p class="material-icons text-sm text-red-700">star</p>
                </span>
              </span>
              <!--chat button-->
              <router-link :to="'/messages/?ID='+toEncrypt(itemx.post.email)"
                class="flex items-center gap-x-2 focus:outline-none bg-green-150 rounded-2xl p-2"
              >
                <p class="material-icons text-white text-sm">chat</p>
                <p class="font-bold text-white text-sm">Chat Shopper</p>
              </router-link>
              <!--/chat button-->
            </div>
            <div class="flex gap-x-3 items-center space-x-3" v-else>
              <img
                class="w-8 h-8 border rounded-full border-gray-700 shadow-md"
                :src="itemx.transaction_sender.profilePicture"
              /><!--Profile Pic-->
              <span class="flex flex-col">
                <p class="font-bold">{{ itemx.transaction_sender.firstName }} {{ itemx.transaction_sender.lastName }}</p>
                <!--name-->
                <span class="flex gap-x-1">
                  <p class="font-bold text-gray-500 text-sm">
                    {{ starRate(userReviews(itemx.transaction_sender.email )) }}
                  </p>
                  <p class="material-icons text-sm text-red-700">star</p>
                </span>
              </span>
              <!--chat button-->
              <router-link :to="'/messages/?ID='+toEncrypt(itemx.transaction_sender.email)"
                class="flex items-center gap-x-2 focus:outline-none bg-green-150 rounded-2xl p-2"
              >
                <p class="material-icons text-white text-sm">chat</p>
                <p class="font-bold text-white text-sm">Chat Shopper</p>
              </router-link>
              <!--/chat button-->
            </div>
          </div>
          <div
            v-if="itemx.transactionStatus == 'Completed'"
            class="space-y-2 w-full p-4 ring-2 ring-gray-300 rounded-xl"
          >
            <p class="text-sm select-none">
              Transaction marked as completed on {{ timestamp(itemx.dateModified) }}
            </p>
            <span class="flex space-x-2"
              ><p class="text-gray-400">
                Would you like to review the shopper?
              </p>
              <button @click="setDispatches(itemx.transaction_sender.email)" class="cursor-pointer">Write a review.</button></span
            >
          </div>
          <div class="grid grid-cols-2 p-5 gap-y-4 text-sm">
            <div class="flex items-center space-x-2">
              <span class="material-icons text-red-buttons"> fmd_good </span>
              <p>{{ itemx.transactionData.deliveryAddress }}</p>
            </div>
            <div class="flex items-center space-x-2">
              <span class="material-icons text-red-buttons">
                shopping_cart
              </span>
              <p>{{ itemx.transactionData.shoppingPlace }}</p>
            </div>
            <div class="flex items-center space-x-2">
              <span class="material-icons text-red-buttons"> watch_later </span>
              <p>{{ timestampSched(itemx.transactionData.deliverySchedule) }}</p>
            </div>
            <div class="flex items-center space-x-2">
              <span class="material-icons text-red-buttons"> payments </span>
              <p>{{ itemx.transactionData.paymentMethod }}</p>
            </div>
          </div>
          <div class="bg-gray-200 py-1 px-3 rounded-2xl">
            <div class="flex text-sm sm: space-x-2">
              <p>Shopping List</p>
              <p class="text-gray-500">{{
                              computedShopItemList(
                                itemx.transactionShoppingList
                              ).length
                           }}</p>
              <p v-if=" computedShopItemList(
                                itemx.transactionShoppingList
                              ).length
                             > 1" class="text-gray-500">items</p>
              <p v-else class="text-gray-500">item</p>
            </div>
            <ul
              id="example-1"
              class="list-disc text-sm space-y-2 list-inside p-5"
            >
              <li
                v-for="item in computedShopItemList(itemx.transactionShoppingList)"
                :key="item.id"
                class="list-disc items-center"
              >
                <label v-if="item.status===1" class="text-md" style="font-size: 16px"
                  >{{ item.product }}({{ item.size }})-{{ item.brand }} [{{
                    item.quantity
                  }}unit/s]</label
                >
              </li>
            </ul>
          </div>
        </div>
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
          <p class="text-lg font-extrabold xl:ml-8 lg:ml-8 2xl:ml-8">
            Update Order Status
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
              ><input type="radio" name="status" value="Completed" /><span
                >Completed</span
              ></span
            >
            <span class="flex items-center space-x-2"
              ><input type="radio" name="status" value="Confirmed" /><span
                >Confirmed</span
              ></span
            >
            <span class="flex items-center space-x-2"
              ><input type="radio" name="status" value="Cancelled" /><span
                >Cancelled</span
              ></span
            >
            <span class="flex items-center space-x-2"
              ><input type="radio" name="status" value="In Transit" /><span
                >In Transit</span
              ></span
            >
          </div>
        </div>
        <div
          class="flex justify-between mt-4 px-5 text-2xlspace-x-4 items-center"
        >
          <button
            @click="updateStatus()"
            class="px-4 bg-red-buttons text-white focus:outline-none w-full h-7 shadow-xl ring-1 ring-gray-300 rounded-2xl"
          >
            Update
          </button>
        </div>
      </div>
    </div>
  </div>

  <div class="w-full flex justify-center">
    <div
      class="text-left flex self-center 2xl:w-608 lg:w-608 xl:w-608 md:w-10/12 sm:w-10/12 p-2"
    >
      <p class="text-gray-500 text-sm">
        Privacy Policy-Cookies Policy-Terms and Conditions Return and Refund
        Policy-PasaBuy 2021
      </p>
    </div>
  </div>
</template>
<script>
import Nav from "../views/Navbar.vue";
import store from "../store/index";
import moment from "moment";
import api from "../api";
import VueSimpleAlert from "vue-simple-alert";

export default {
  name: "Order",
  components: {
    Nav,
  },
  data() {
    return {
      activeBtn: 0,
      toggle_status: false,
      location: "",
      date: "February 26 2021 12:30pm",
      store: "",
      name: "Yamete",
      rate: "4.5",
      payments: "",
      order_number: "12453",
      status: "Completed",
      items: [{ list: "Milk" }, { list: "Milk" }],
      allOrders: [],
      updatingTransaction: null,
      updatingPost: null,
      trans_id: "",
      transaction_filter: [],
      transaction: [
        {
          id: 1,
          street: "Rizal Street",
          city: "Legazpi City",
          store: "SM City Legazpi",
          payment: "Payment First",
          profile_image:
            "https://i.pinimg.com/564x/80/e2/f6/80e2f60c9e41907b97300c337a40fa45.jpg",
          name: "Yamete",
          rate: "4.5",
          order_number: "1234",
          date: "February 23,2021",
          time: "12:31 PM",
          currenTime: "",
          currentDate: "",
          selected: "Confirmed",
          items: [
            {
              list: "Pork",
              size: "1kl",
              brand: "Anybrand",
              quantity: 2,
            },
          ],
        },
        {
          id: 2,
          street: "Rizal Street",
          city: "Legazpi City",
          store: "SM City Legazpi",
          payment: "Payment First",
          profile_image:
            "https://i.pinimg.com/564x/80/e2/f6/80e2f60c9e41907b97300c337a40fa45.jpg",
          name: "Yamete",
          rate: "4.5",
          order_number: "1234",
          date: "February 23,2021",
          time: "12:31 PM",
          currenTime: "",
          currentDate: "",
          selected: "Confirmed",
          items: [
            {
              list: "Pork",
              size: "1kl",
              brand: "Anybrand",
              quantity: 2,
            },
          ],
        },
        {
          id: 3,
          street: "Rizal Street",
          city: "Legazpi City",
          store: "SM City Legazpi",
          payment: "Payment First",
          profile_image:
            "https://i.pinimg.com/564x/80/e2/f6/80e2f60c9e41907b97300c337a40fa45.jpg",
          name: "Yamete",
          rate: "4.5",
          order_number: "1234",
          date: "February 23,2021",
          time: "12:31 PM",
          currenTime: "",
          currentDate: "",
          selected: "Confirmed",
          items: [
            {
              list: "Pork",
              size: "1kl",
              brand: "Anybrand",
              quantity: 2,
            },
          ],
        },
        {
          id: 4,
          street: "Rizal Street",
          city: "Legazpi City",
          store: "SM City Legazpi",
          payment: "Payment First",
          profile_image:
            "https://i.pinimg.com/564x/6d/0b/9b/6d0b9bf23569450a8f93d4e0d44741d1.jpg",
          name: "Asta",
          rate: "4.5",
          order_number: "12345",
          date: "February 23,2021",
          time: "12:31 PM",
          currenTime: "",
          currentDate: "",
          selected: "Completed",
          items: [
            {
              list: "Milk",
              size: "1kl",
              brand: "Anybrand",
              quantity: 1,
            },
            {
              list: "Pork",
              size: "1kl",
              brand: "Anybrand",
              quantity: 2,
            },
          ],
        },
      ],
    };
  },
  methods: {
    computedShopItemList(list) {
      if (list != null) {
        var temp = list.filter((x) => {
          return x.status == 1;
        });
        return this.limit_by ? temp.slice(0, this.limit_by) : temp;
      }
      return null;
    },
      setDispatches(email) {
      store.dispatch("getUserInfo", email).then(() => {
        store.dispatch("getNotAuthUserAddress", email).then(() => {
          store.dispatch("getUserFollow", email).then(() => {
            this.$router.push({
              name: "Profile",
              query: { ID: this.toEncrypt(email)},
            });
          });
        });
      });
    },
    filter_obj(e) {
      if (e == "Orders") {
        this.transaction_filter = [];
        return (this.transaction_filter = this.transaction);
      }
      this.transaction_filter = this.transaction.filter(
        (trans) => trans.selected == e
      );
    },
    update_stat() {
      let new_time = new Date();
      const index = this.transaction.findIndex((x) => x.id == this.trans_id);
      this.transaction[index].currenTime = new_time.toLocaleTimeString();
      this.transaction[index].currentDate = new_time.toDateString();
      this.transaction[index].selected = document.querySelector(
        'input[name="status"]:checked'
      ).value;
    },
    isActive_function(el) {
      if (el == "btn4") {
        this.activeBtn = el;
        this.allOrders = this.orders.filter((x) => {
          return (
            x.transactionStatus == "Cancelled" ||
            x.transactionStatus == "Declined"
          );
        });
        console.log("cancelled ", this.allOrders);
      } else if (el == "btn3") {
        this.activeBtn = el;
        this.allOrders = this.orders.filter((x) => {
          return x.transactionStatus == "Confirmed";
        });
        console.log("confirmed ", this.allOrders);
      } else if (el == "btn2") {
        this.activeBtn = el;
        this.allOrders = this.orders.filter((x) => {
          return x.transactionStatus == "Completed";
        });
        console.log("completed ", this.allOrders);
      } else if (el == "btn5") {
        this.activeBtn = el;
        this.allOrders = this.orders.filter((x) => {
          return x.transactionStatus == "In Transit";
        });
        console.log("completed ", this.allOrders);
      }
       else {
        this.activeBtn = 0;
        this.allOrders = this.orders;
      }
    },
    timestampSched(datetime) {
      var schedDate = new Date(datetime);
      var dateToday = new Date();
      var dateDiff = schedDate.getTime() - dateToday.getTime();
      dateDiff = dateDiff / (1000 * 3600 * 24);
      console.log(dateDiff);
      if (dateDiff < 1 && dateDiff > 0)
        return moment(datetime).format("[Today at] h:mm a");
      else if (dateDiff >= 1 && dateDiff < 2)
        return moment(datetime).format("[Tommorow at] h:mm a");
      else return moment(datetime).format("[From] MMM DD, YYYY [at] h:mm a");
    },
    timestamp(datetime) {
      return moment(datetime).format("MMM DD, YYYY [at] h:mm a");
    },
    toEncrypt(val) {
      return btoa(val);
    },
    updateStatus() {
      var complete = document.getElementById("complete").checked;
      var cancel = document.getElementById("cancel").checked;
      if (complete) {
        api
          .post("api/updateTransaction", {
            userNotif: this.userNotif,
            status: "Completed",
            ID: this.updatingTransaction,
            postNumber: this.updatingPost,
          })
          .then((res) => {
            store.dispatch("getUserTransactions").then(() => {
              this.toggle_status = false;
              this.updatingTransaction = null;
              this.updatingPost = null;
              this.allOrders = this.orders;
              VueSimpleAlert.alert(res.data.message, "Sucess", "success");
            });
          })
          .catch((error) => {
            VueSimpleAlert.alert(error.response.data.error, "Error", "error");
          });
      } else if (cancel) {
        api
          .post("api/updateTransaction", {
            userNotif: this.userNotif,
            status: "Cancelled",
            ID: this.updatingTransaction,
            postNumber: this.updatingPost,
          })
          .then((res) => {
            store.dispatch("getUserTransactions").then(() => {
              this.toggle_status = false;
              this.updatingTransaction = null;
              this.updatingPost = null;
              this.allOrders = this.orders;
              VueSimpleAlert.alert(res.data.message, "Sucess", "success");
            });
          })
          .catch((error) => {
            VueSimpleAlert.alert(error.response.data.error, "Error", "error");
          });
      }
    },
    setDataToSave(email, indexTransactionPost, postNumber) {
      this.userNotif = email;
      this.updatingTransaction = indexTransactionPost;
      this.updatingPost = postNumber;
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
  },
  mounted() {
    this.allOrders = this.orders;
    console.log("all orders", this.allOrders);
  },
  computed: {
    user() {
      return store.getters.getUser;
    },
    reviews(){
            return store.getters.getAllReviews;

    },
    orders() {
      return store.getters.getUserTransactions.filter((x) => {
        return (
          (x.post.postIdentity == "request_post" &&
            x.post.email == this.user.email) ||
          (x.post.postIdentity == "offer_post" &&
            x.post.email != this.user.email)
        );
      });
    },
  },
};
</script>
<style scoped>
.active {
  background-color: currentColor;
}
.active a {
  color: white;
}
</style>

