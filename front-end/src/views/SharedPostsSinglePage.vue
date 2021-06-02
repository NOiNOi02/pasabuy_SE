<template>
  <Navbar />
  <div
    class="flex flex-col bg-gray-100 pt-122 font-nunito h-scrren pb-6 bg-gray-bgcolor"
  >
    <div class="flex flex-col items-center justify-center pt-6">
      <div
        class="flex flex-col h-auto bg-white rounded-lg vs:w-full ssm:w-full w-608"
      >
        <div class="flex items-center justify-between px-2 py-4 pt-4">
          <div class="flex items-center space-x-4 focus:outline-none">
            <p
              @click="setDispatches(currentPost.sharerEmail)"
              class="text-base italic leading-none text-gray-900"
            >
              <span class="font-bold"
                >{{ currentPost.user.firstName }}
                {{ currentPost.user.lastName }}</span
              >
              shared this post
            </p>
          </div>
        </div>
        <hr class="w-full" />

        <!--user post-->
        <div class="flex" v-if="currentPost.post.postIdentity === 'offer_post'">
          <div
            class="h-auto p-6 space-x-4 bg-white shadow vs:p-4 mv:w-full ssm:p-2 ssm:w-full vs:w-full sm:w-full w-608 rounded-xl"
          >
            <div class="flex flex-col items-start justify-start">
              <!--section 1-->
              <div class="flex flex-row justify-between flex-grow w-full">
                <div class="inline-flex">
                  <img
                    class="rounded-full x-v:absolute w-14 h-14 vs:w-10 vs:h-10 ssm:w-10 ssm:h-10"
                    :src="currentPost.post.user.profilePicture"
                  />
                  <div
                    class="flex flex-col items-start w-full px-4 vs:px-1 se:px-2 ssm:px-2"
                  >
                    <div
                      class="flex mt-1 space-x-4 ssm:space-x-0 se:space-x-0 vs:space-x-1 sm:space-x-2"
                    >
                      <h5
                        class="text-base font-bold leading-none text-gray-900 x-v:pl-10 vsv:text-xs ssm:text-sm vs:text-sm lvs:text-sm"
                      >
                        {{ currentPost.post.user.firstName }}
                        {{ currentPost.post.user.lastName }}
                        <span
                          class="inline-block text-blue-900 align-middle material-icons-round md-18"
                        >
                          verified
                        </span>
                        <label
                          class="pl-1 font-normal text-gray-500 align-top vs:font-light"
                          >posted a shopping offer</label
                        >
                      </h5>
                    </div>
                    <div
                      class="vs:flex vs:w-full ssm:w-full ssm:flex vs:pb-2 x-v:ml-10"
                    >
                      <span
                        class="text-sm leading-none text-gray-500 ssm:text-xs vs:text-xs lvs:text-sm"
                        >{{ timestamp(currentPost.post.dateCreated) }}</span
                      >
                    </div>
                  </div>
                </div>
              </div>
              <!--end-->

              <!--section 2-->
              <div
                v-if="currentPost.post.postStatus != 'Accepting Requests'"
                class="inline-flex mt-4 items-center space-x-2 justify-start px-2 py-1 bg-gray-100 rounded-full"
              >
                <span class="rounded-full material-icons text-red-600">
                  remove_circle_outline
                </span>
                <p
                  class="text-sm vs:text-xs ssm:text-xs lvs:text-sm font-bold leading-none items-center text-red-600"
                >
                  {{ currentPost.post.postStatus }}
                </p>
              </div>
              <div
                v-else
                class="inline-flex mt-4 items-center space-x-2 justify-start px-2 py-1 bg-gray-100 rounded-full"
              >
                <span class="rounded-full material-icons text-green-600">
                  check_circle_outline
                </span>
                <p
                  class="text-sm vs:text-xs ssm:text-xs lvs:text-sm font-bold leading-none items-center text-green-600"
                >
                  {{ currentPost.post.postStatus }}
                </p>
              </div>
              <!--end-->

              <!--section 3-->
              <div
                class="flex items-center justify-start w-full mt-4 space-x-4 ssm:flex-col ssm:items-start ssm:space-x-0 vs:flex-col vs:items-start vs:space-x-0"
              >
                <div class="flex-col items-start w-full">
                  <div class="flex space-x-2">
                    <span
                      class="w-6 h-6 text-red-600 rounded-full material-icons"
                    >
                      delivery_dining
                    </span>
                    <p
                      class="py-1 text-sm leading-none text-gray-900 ssm:text-xs vs:text-xs lvs:text-sm"
                    >
                      {{ currentPost.post.offer_post.deliveryArea }}
                    </p>
                  </div>
                  <div class="flex py-2 space-x-2">
                    <span
                      class="w-6 h-6 text-red-600 rounded-full material-icons"
                    >
                      alarm
                    </span>
                    <p
                      class="py-1 text-sm leading-none text-gray-900 ssm:text-xs vs:text-xs lvs:text-sm"
                    >
                      {{ currentPost.post.offer_post.deliverySchedule }}
                    </p>
                  </div>
                  <div class="flex space-x-2">
                    <span
                      class="w-6 h-6 text-red-600 rounded-full material-icons"
                    >
                      shopping_bag
                    </span>
                    <p
                      class="py-1 text-sm leading-none text-gray-900 ssm:text-xs vs:text-xs lvs:text-sm"
                    >
                      {{ currentPost.post.offer_post.capacity }}
                    </p>
                  </div>
                </div>
                <div class="flex-col w-full ssm:py-2 vs:py-3">
                  <div class="flex space-x-2">
                    <span
                      class="w-6 h-6 text-red-600 rounded-full material-icons"
                    >
                      shopping_cart
                    </span>
                    <p
                      class="py-1 text-sm leading-none text-gray-900 ssm:text-xs vs:text-xs lvs:text-sm"
                    >
                      {{ currentPost.post.offer_post.shoppingPlace }}
                    </p>
                  </div>
                  <div class="flex py-2 space-x-2">
                    <span
                      class="w-6 h-6 text-red-600 rounded-full material-icons"
                    >
                      directions_car
                    </span>
                    <p
                      class="py-1 text-sm leading-none text-gray-900 ssm:text-xs vs:text-xs lvs:text-sm"
                    >
                      {{ currentPost.post.offer_post.transportMode }}
                    </p>
                  </div>
                  <div class="flex space-x-2">
                    <span
                      class="w-6 h-6 text-red-600 rounded-full material-icons"
                    >
                      payments
                    </span>
                    <p
                      class="py-1 text-sm leading-none text-gray-900 ssm:text-xs vs:text-xs lvs:text-sm"
                    >
                      {{ currentPost.post.offer_post.paymentMethod }}
                    </p>
                  </div>
                </div>
              </div>
              <!--end-->

              <!--section 4-->
              <div
                v-if="currentPost.post.offer_post.caption != null"
                class="flex items-start justify-start flex-grow-0 w-full p-4 mt-4 bg-gray-100 ssm:mt-2 vs:mt-2 rounded-xl"
              >
                <p
                  class="w-full h-auto text-sm leading-loose text-gray-900 ssm:text-xs vs:text-xs lvs:text-sm vs:min-w-0 vs:px-2"
                >
                  {{ currentPost.post.offer_post.caption }}
                </p>
              </div>
              <!--section 4-->

              <!--section 5-->
              <!--end-->
            </div>
          </div>
        </div>
        <div class="flex" v-else>
          <div
            class="h-auto p-6 space-x-4 bg-white shadow vs:p-4 mv:w-full ssm:p-2 ssm:w-full vs:w-full sm:w-full w-608 rounded-xl"
          >
            <div class="flex flex-col items-start justify-start">
              <!--section 1-->
              <div class="flex flex-row justify-between flex-grow w-full">
                <div class="inline-flex">
                  <img
                    class="rounded-full x-v:absolute w-14 h-14 vs:w-10 vs:h-10 ssm:w-10 ssm:h-10"
                    :src="currentPost.post.user.profilePicture"
                  />
                  <div
                    class="flex flex-col items-start w-full px-4 vs:px-1 se:px-2 ssm:px-2"
                  >
                    <div
                      class="flex mt-1 space-x-4 ssm:space-x-0 se:space-x-0 vs:space-x-1 sm:space-x-2"
                    >
                      <h5
                        class="text-base font-bold leading-none text-gray-900 x-v:pl-10 vsv:text-xs ssm:text-sm vs:text-sm lvs:text-sm"
                      >
                        {{ currentPost.post.user.firstName }}
                        {{ currentPost.post.user.lastName }}
                        <span
                          class="inline-block text-blue-900 align-middle material-icons-round md-18"
                        >
                          verified
                        </span>
                        <label
                          class="pl-1 font-normal text-gray-500 align-top vs:font-light"
                          >posted a shopping offer</label
                        >
                      </h5>
                    </div>
                    <div
                      class="vs:flex vs:w-full ssm:w-full ssm:flex vs:pb-2 x-v:ml-10"
                    >
                      <span
                        class="text-sm leading-none text-gray-500 ssm:text-xs vs:text-xs lvs:text-sm"
                        >{{ timestamp(currentPost.post.dateCreated) }}</span
                      >
                    </div>
                  </div>
                </div>
              </div>
              <!--end-->

              <!--section 2-->
              <div
                v-if="currentPost.post.postStatus != 'Accepting Offer'"
                class="inline-flex mt-4 items-center space-x-2 justify-start px-2 py-1 bg-gray-100 rounded-full"
              >
                <span class="rounded-full material-icons text-red-600">
                  remove_circle_outline
                </span>
                <p
                  class="text-sm vs:text-xs ssm:text-xs lvs:text-sm font-bold leading-none items-center text-red-600"
                >
                  {{ currentPost.post.postStatus }}
                </p>
              </div>
              <div
                v-else
                class="inline-flex mt-4 items-center space-x-2 justify-start px-2 py-1 bg-gray-100 rounded-full"
              >
                <span class="rounded-full material-icons text-green-600">
                  check_circle_outline
                </span>
                <p
                  class="text-sm vs:text-xs ssm:text-xs lvs:text-sm font-bold leading-none items-center text-green-600"
                >
                  {{ currentPost.post.postStatus }}
                </p>
              </div>
              <!--end-->

              <!--section 3-->
              <div
                class="flex ssm:flex-col ssm:items-start ssm:space-x-0 vs:flex-col vs:items-start items-center justify-start mt-4 w-full vs:space-x-0 space-x-2"
              >
                <div class="flex-col items-start w-full pr-12">
                  <div class="flex space-x-2">
                    <span
                      class="w-6 h-6 rounded-full material-icons text-red-600"
                    >
                      location_on
                    </span>
                    <p
                      class="text-sm ssm:text-xs vs:text-xs lvs:text-sm leading-none text-gray-900 py-1"
                    >
                      {{ currentPost.post.request_post.deliveryAddress }}
                    </p>
                  </div>
                  <div class="flex space-x-2 py-2">
                    <span
                      class="w-6 h-6 rounded-full material-icons text-red-600"
                    >
                      alarm
                    </span>
                    <p
                      class="text-sm ssm:text-xs vs:text-xs lvs:text-sm leading-none text-gray-900 py-1"
                    >
                      {{
                        timestampSched(
                          currentPost.post.request_post.deliverySchedule
                        )
                      }}
                    </p>
                  </div>
                </div>
                <div class="flex-col vs:py-1 w-full">
                  <div class="flex space-x-2">
                    <span
                      class="w-6 h-6 rounded-full material-icons text-red-600"
                    >
                      shopping_cart
                    </span>
                    <p
                      class="text-sm ssm:text-xs vs:text-xs lvs:text-sm leading-none text-gray-900 py-1"
                    >
                      {{ currentPost.post.request_post.shoppingPlace }}
                    </p>
                  </div>
                  <div class="flex space-x-2 py-2">
                    <span
                      class="w-6 h-6 rounded-full material-icons text-red-600"
                    >
                      payments
                    </span>
                    <p
                      class="text-sm ssm:text-xs vs:text-xs lvs:text-sm leading-none text-gray-900 py-1"
                    >
                      {{ currentPost.post.request_post.paymentMethod }}
                    </p>
                  </div>
                </div>
              </div>
              <!--end-->

              <!--section 4-->
              <div v-if="currentPost.post.request_post.shoppingListContent!=null"
                class="flex flex-col ssm:mt-2 vs:mt-2 mt-3 w-full items-start justify-start h-auto vs:pr-0 vs:min-w-0 vs:px-2 ssm:pr-0 ssm:min-w-0 ssm:px-2 p-4 bg-gray-100 rounded-xl"
              >
                <div class="inline-flex flex-row space-x-4">
                  <span class="text-base ssm:text-sm leading-none text-gray-900"
                    >Shopping List</span
                  >
                  <span class="text-base ssm:text-sm leading-none text-gray-500"
                    >{{
                      computedShopItemLists(
                        currentPost.post.request_post.shoppingListContent
                      ).length
                    }}
                    items</span
                  >
                </div>
                <div
                  class="inline-flex flex-col ssm:px-0 w-full vs:px-0 space-y-2 py-4 px-4"
                >
                  <li
                    v-for="shoppingItems in computedShopItemList()"
                    :key="shoppingItems"
                    class="text-sm leading-none text-gray-900"
                  >
                    {{ shoppingItems.product }} ({{ shoppingItems.quantity }}) ·
                    {{ shoppingItems.brand }} [{{ shoppingItems.size }}]
                  </li>
                </div>
              </div>
              <!--section 4-->

              <!--section 5-->
              <div
                class="inline-flex items-start ssm:px-2 justify-start mt-3 rounded-xl h-auto bg-white w-full"
              >
                <p
                  class="text-sm ssm:text-xs vs:text-xs lvs:text-sm leading-loose w-auto text-gray-900"
                >
                  {{ currentPost.post.request_post.caption }}
                </p>
              </div>
              <!--section 4-->

              <!--section 5-->
              <!--end-->
            </div>
          </div>
        </div>
        <!--end of user post-->
      </div>
    </div>
  </div>
</template>

<script>
import Navbar from "./Navbar";
import moment from "moment";
import store from "../store/index";
export default {
  data() {
    return {
      delivery_info: {
        delivery_area: "Naga City",
        shopping_place: "SM City Legazpi",
        schedule: "2021-04-28 13:12:01",
        public_transit: "Public Transit",
        capacity: "2 Big Plastic Bag",
        payment_method: "Cash on Delivery",
        comment:
          "Hi! If there's anyone who can help me and sabuy my groceries, I would greatly appreciate it. Send me an offer if you are willing. Thanks!",
        status: "No Longer Accepting Requests",
      },
      datePosted: "3 hours ago",
      user_info: {
        firstname: "Jane",
        lastname: "Doe",
      },
    };
  },
  components: {
    Navbar,
  },
  methods: {
    computedShopItemLists(list) {
      if (list != null) {
        var temp = list.filter((x) => {
          return x.status == 1;
        });
        return temp;
      }
      return null;
    },
    computedShopItemList() {
      var temp = this.currentPost.request_post.shoppingListContent.filter(
        (x) => {
          return x.status == 1;
        }
      );
      return temp;
    },
    toEncrypt(val) {
      return btoa(val);
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
  },
  computed: {
    currentPost() {
      var postNumber = JSON.parse(atob(this.$route.query.post));
      var temp = this.shares.filter((x) => {
        return x.postNumber === postNumber;
      });
      return temp[0];
    },
    shares() {
      return store.getters.getAllShares;
    },
    user() {
      return store.getters.getPersonal;
    },
  },
};
</script>

<style scoped>
</style>