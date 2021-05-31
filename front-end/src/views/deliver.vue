<template>
  <Nav />
  <div
    class="flex flex-col w-full ssm:w-max xsm:w-max justify-center font-nunito"
  >
    <div
      class="w-608 2xl:block 2xl:mt-24 lg:block lg:mt-24 lg:w-6/12 xl:block xl:mt-24 justify-center self-center gap-y-5 mt-16 hidden"
    >
      <p class="text-2xl font-nunito font-bold uppercase">Deliveries</p>
    </div>
    <div
      class="mt-20 self-center px-2 w-full flex flex-col pb-4 2xl:flex-row 2xl:mt-0 2xl:self-center 2xl:justify-items-center 2xl:items-center lg:flex-row lg:self-center lg:justify-items-center lg:mt-0 xl:flex-row xl:self-center xl:justify-items-center xl:mt-0 md:flex-row md:mt-24 md:pl-4 md:items-center sm:flex-row space-y-3 2xl:w-608 2xl:px-0 lg:w-608 lg:px-0 xl:w-608 xl:px-0 md:w-10/12 md:px-0 sm:w-10/12"
    >
      <div class="mt-3 2xl:mr-2 xl:mr-2 lg:mr-2 md:mr-2">
        <button
          @click="isActive_function('btn1'), filter_obj('Deliveries')"
          :class="{ active: activeBtn === 0 }"
          type="button"
          class="font-bold focus:outline-none text-red-buttons px-3 py-1 shadow rounded-2xl bg-white w-full h-full"
        >
          <a> All Deliveries</a>
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

    <div v-for="itemx in allDeliveries" :key="itemx.id">
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
            <div
              class="vs:flex-col vs:space-x-2"
              v-if="
                (itemx.transactionStatus == 'Confirmed' ||
                  itemx.transactionStatus == 'In Transit') &&
                itemx.post.email != user.email
              "
            >
              <span
                class="text-blue-600 font-bold cursor-pointer"
                @click="
                  (toggle_status = !toggle_status),
                    setDataToSave(
                      itemx.post.email,
                      itemx.indexTransactionPost,
                      itemx.postNumber
                    )
                "
                >Update Status</span
              >
            </div>
            <div
              class="vs:flex-col vs:space-x-2"
              v-else-if="
                itemx.transactionStatus == 'Confirmed' ||
                itemx.transactionStatus == 'In Transit'
              "
            >
              <span
                class="text-blue-600 font-bold cursor-pointer"
                @click="
                  (toggle_status = !toggle_status),
                    setDataToSave(
                      itemx.transaction_sender.email,
                      itemx.indexTransactionPost,
                      itemx.postNumber
                    )
                "
                >Update Status</span
              >
            </div>
          </div>
          <span class="text-gray-500 mt-2"
            >Place on {{ timestamp(itemx.dateCreated) }}</span
          >
          <div
            class="flex items-start gap-x-8 my-3 flex-col 2xl:items-center 2xl:flex-row xl:items-center xl:flex-row lg:items-center lg:flex-row md:flex-row"
          >
            <p class="uppercase font-bold text-gray-500">customer</p>
            <div
              class="flex gap-x-3 items-center space-x-3"
              v-if="itemx.post.email != user.email"
            >
              <img
                class="w-8 h-8 border rounded-full border-gray-700 shadow-md"
                :src="itemx.post.user.profilePicture"
              /><!--Profile Pic-->
              <span class="flex flex-col">
                <p class="font-bold">
                  {{ itemx.post.user.firstName }} {{ itemx.post.user.lastName }}
                </p>
                <!--name-->
                <span class="flex gap-x-1">
                  <p class="font-bold text-gray-500 text-sm">
                    {{ starRate(userReviews(itemx.post.email)) }}
                  </p>
                  <p class="material-icons text-sm text-red-700">star</p>
                </span>
              </span>
              <!--chat button-->
              <router-link
                :to="'/messages/?ID=' + toEncrypt(itemx.post.email)"
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
                <p class="font-bold">
                  {{ itemx.transaction_sender.firstName }}
                  {{ itemx.transaction_sender.lastName }}
                </p>
                <!--name-->
                <span class="flex gap-x-1">
                  <p class="font-bold text-gray-500 text-sm">
                    {{ starRate(userReviews(itemx.transaction_sender.email)) }}
                  </p>
                  <p class="material-icons text-sm text-red-700">star</p>
                </span>
              </span>
              <!--chat button-->
              <router-link
                :to="
                  '/messages/?ID=' + toEncrypt(itemx.transaction_sender.email)
                "
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
              Transaction marked as completed on
              {{ timestamp(itemx.dateModified) }}
            </p>
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
              <p>
                {{ timestampSched(itemx.transactionData.deliverySchedule) }}
              </p>
            </div>
            <div class="flex items-center space-x-2">
              <span class="material-icons text-red-buttons"> payments </span>
              <p>{{ itemx.transactionData.paymentMethod }}</p>
            </div>
          </div>
          <div class="bg-gray-200 py-1 px-3 rounded-2xl">
            <div class="flex text-sm sm: space-x-2">
              <p>Shopping List</p>
              <p class="text-gray-500">
                {{ computedShopItemList(itemx.transactionShoppingList).length }}
              </p>
              <p
                v-if="
                  computedShopItemList(itemx.transactionShoppingList).length > 1
                "
                class="text-gray-500"
              >
                items
              </p>
              <p v-else class="text-gray-500">item</p>
            </div>
            <ul
              id="example-1"
              class="list-disc text-sm list-inside space-y-2 grid grid-cols-1 p-5"
            >
              <li
                v-for="item in computedShopItemList(
                  itemx.transactionShoppingList
                )"
                :key="item.id"
                class="list-none"
              >
                <div class="flex items-center">
                  <input
                    @click="
                      checkDeliver(
                        item,
                        itemx.transactionNumber,
                        itemx.transactionShoppingList
                      )
                    "
                    type="checkbox"
                    :id="item.id"
                    :value="itemx.product"
                    :checked="item.statusDeliver == 1"
                    :disabled="itemx.transactionStatus != 'Confirmed'"
                  />
                  <label
                    v-if="item.status === 1"
                    class="ml-3 text-md"
                    style="font-size: 16px"
                    >{{ item.product }}({{ item.size }})-{{ item.brand }} [{{
                      item.quantity
                    }}unit/s]</label
                  >
                </div>
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
            <label class="flex items-center space-x-2"
              ><input
                type="radio"
                name="status"
                value="Completed"
                id="completedDeliver"
              /><span>Completed</span></label
            >
            <label class="flex items-center space-x-2"
              ><input
                type="radio"
                name="status"
                value="In Transit"
                id="inTransitDeliver"
              /><span>In Transit</span></label
            >
            <label class="flex items-center space-x-2"
              ><input
                type="radio"
                name="status"
                value="Cancelled"
                id="cancelledDeliver"
              /><span>Cancelled</span></label
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
import Nav from "../views/Navbar.vue";
import store from "../store/index";
import moment from "moment";
import api from "../api";
// import VueSimpleAlert from "vue-simple-alert";
import _ from "lodash";
export default {
  name: "Deliver",
  components: {
    Nav,
  },
  data() {
    return {
      popUp3: false,
      toggle_status: false,
      activeBtn: 0,
      name: "Yamete",
      rate: "4.5",
      items: [{ list: "Pork" }, { list: "Pork" }],
      hide_selected: false,
      order_number: "1234",
      selected: "Confirmed",
      options: [
        { text: "Completed", value: "Completed" },
        { text: "Cancelled", value: "Cancalled" },
      ],
      allDeliveries: [],
      updatingTransaction: null,
      updatingPost: null,
      userNotif: null,
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

    debounceCheckDeliver: _.debounce((item, transactionNumber, list) => {
      for (var i = 0; i < list.length; i++) {
        console.log(list[i].id);
        if (document.getElementById(list[i].id).checked) {
          list[i].statusDeliver = 1;
        } else {
          list[i].statusDeliver = 0;
        }
      }
      api
        .post("/api/editListDeliverStatus/" + transactionNumber, { list: list })
        .then(() => {
          store.dispatch("getUserTransactions");
          console.log("scuess in check unchec dliver");
        });
    }, 2000),

    checkDeliver(item, transactionNumber, list) {
      this.debounceCheckDeliver(item, transactionNumber, list);
    },
    isActive_function(el) {
      if (el == "btn4") {
        this.activeBtn = el;
        this.allDeliveries = this.deliveries.filter((x) => {
          return (
            x.transactionStatus == "cancelled" ||
            x.transactionStatus == "Cancelled" ||
            x.transactionStatus == "declined" ||
            x.transactionStatus == "Declined"
          );
        });
        console.log("cancelled ", this.allDeliveries);
      } else if (el == "btn3") {
        this.activeBtn = el;
        this.allDeliveries = this.deliveries.filter((x) => {
          return x.transactionStatus == "Confirmed";
        });
        console.log("confirmed ", this.allDeliveries);
      } else if (el == "btn2") {
        this.activeBtn = el;
        this.allDeliveries = this.deliveries.filter((x) => {
          return x.transactionStatus == "Completed";
        });
        console.log("completed ", this.allDeliveries);
      } else if (el == "btn5") {
        this.activeBtn = el;
        this.allDeliveries = this.deliveries.filter((x) => {
          return x.transactionStatus == "In Transit";
        });
        console.log("completed ", this.allDeliveries);
      } else {
        this.activeBtn = 0;
        this.allDeliveries = this.deliveries;
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
    this.allDeliveries = this.deliveries;
    console.log("all deliveries ", this.allDeliveries);
  },
  computed: {
    user() {
      return store.getters.getUser;
    },
    reviews() {
      return store.getters.getAllReviews;
    },
    deliveries() {
      return store.getters.getUserTransactions.filter((x) => {
        return (
          (x.post.postIdentity == "request_post" &&
            x.post.email != this.user.email) ||
          (x.post.postIdentity == "offer_post" &&
            x.post.email == this.user.email)
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
input[type="checkbox"] {
  outline-style: none;
  appearance: none;
  -webkit-appearance: none;
  height: 17px;
  width: 17px;
  border: 2px solid #1c1720;
  display: flex;
  align-items: center;
  justify-content: center;
}
input[type="checkbox"]:after {
  font-family: "Font Awesome 5 free";
  font-weight: 900;
  content: "\f00c";
  font-size: 10px;
  color: white;
  display: none;
  outline-style: none;
}
input:checked + label {
  color: #747474;
  text-decoration: line-through;
}
input[type="checkbox"]:checked {
  background-color: #1c1720;
}

input[type="checkbox"]:checked::after {
  display: block;
}
</style>

