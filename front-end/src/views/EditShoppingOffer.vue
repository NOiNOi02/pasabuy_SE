<template>
  <div
    v-on:click.self="close1"
    class="z-50 bg-black bg-opacity-25 fixed inset-0 flex justify-center items-center ssm:px-2 sm:px-2 vs:px-2"
  >
    <div
      class="inline-flex flex-col space-y-2 bg-white shadow rounded-xl h-auto w-550 ssm:w-full vs:w-full sm:w-full"
    >
      <div class="flex flex-col mt-4">
        <!--Create Post section-->
        <h1
          class="items-center justify-center sm:ml-8 se:pl-14 se:ml-0 ssm:pl-11 ssm:ml-0 ssm:text-lg vs:ml-0 sm:ml-12 ml-12 pb-4 text-gray-900 leading-normal vs:pl-22 pl-24 text-2xl vs:text-xl font-bold text-center"
        >
          Edit Shopping Offer
          <button
            @click.prevent="close1"
            class="vs:ml-4 ml-20 sm:ml-14 se:ml-4 ssm:ml-3 ssm:text-xs focus:outline-none text-sm vs:text-xs mb-1 leading-none text-indigo-900"
          >
            Close
          </button>
        </h1>
        <!--end-->
        <hr />

        <!--User Profile-->
        <div class="inline-flex space-x-2 items-center justify-start p-4">
          <img
            class="w-14 h-full vs:w-12 ssm:w-10 border rounded-full border-gray-200"
            :src="btnText.user.profilePicture"
          />
          <p
            class="text-base ssm:text-sm vs:text-sm lvs:text-base font-bold leading-none text-gray-900"
          >
            {{ btnText.user.firstName }} {{ btnText.user.lastName }}
          </p>
        </div>
        <!--end-->

        <!--Delivery information list-->
        <!--<form @submit.prevent='createOfferPost'>-->
        <div
          class="flex flex-col mt-1 sm:px-2 ssm:px-2 vs:px-2 justify-center items-center"
        >
          <div
            class="flex flex-row ssm:flex-col ssm:space-x-0 se:space-x-1 ssm:space-y-2 space-x-4 w-full justify-center"
          >
            <div class="flex space-x-2 sm:w-full">
              <span class="mt-1.5 rounded-full material-icons text-red-600">
                delivery_dining
              </span>
              <div class="sm:w-full">
                <button
                  @click="
                    (deliveryAreaModal = !delyveryAreaModal),
                      (dropdown2 = false),
                      (dropdown3 = false),
                      (dropdown4 = false)
                  "
                  class="focus:outline-none flex sm:w-full ssm:w-full ssm:h-auto ssm:text-xs vs:w-full w-52 h-11 py-2.5 px-4 items-center bg-gray-100 rounded-xl text-sm vs:text-xs lvs:text-sm leading-none text-gray-500"
                >
                  {{ shop_info.deliveryArea }}
                </button>
              </div>
            </div>
            <div
              @click.self="
                (deliveryAreaModal = !deliveryAreaModal),
                  (this.areaError = null),
                  (this.selectedBrgy = 'Brgy'),
                  (this.selectedProvince = 'Province'),
                  (this.selectedCity = 'City')
              "
              v-if="deliveryAreaModal"
              class="z-50 bg-black bg-opacity-25 fixed inset-0 flex justify-center items-center ssm:px-2 vs:px-2"
            >
              <div
                class="inline-flex flex-col bg-white p-4 space-y-4 shadow rounded-xl h-auto w-80"
              >
                <h1 class="font-bold text-center">
                  Select an area of delivery
                </h1>
                <p class="text-center text-red-500">{{ areaError }}</p>
                <div class="flex flex-col">
                  <span class="ml-2">Province:</span>
                  <select
                    id="Province"
                    @change="getProvCode()"
                    v-model="selectedProvince"
                    class="focus:outline-none rounded-xl h-10 pl-2 bg-transparent bg-gray-200"
                  >
                    <option value="Province" disabled>Choose Province</option>
                    <option
                      v-for="province in refProvince"
                      v-bind:key="province.id"
                      v-bind:value="province.provCode"
                    >
                      {{ province.provDesc }}
                    </option>
                  </select>
                </div>

                <div class="flex flex-col">
                  <span class="ml-2">City/Municaplity: </span>
                  <select
                    id="City"
                    @change="getCityCode()"
                    v-model="selectedCity"
                    class="focus:outline-none rounded-xl h-10 pl-2 bg-transparent bg-gray-200"
                  >
                    <option value="City" disabled>
                      Choose City/Municipality
                    </option>
                    <option
                      v-for="city in refCity"
                      v-bind:key="city.id"
                      v-bind:value="city.citymunCode"
                    >
                      {{ city.citymunDesc }}
                    </option>
                  </select>
                </div>

                <div class="flex flex-col">
                  <span class="ml-2">Barangay: </span>
                  <select
                    v-model="selectedBrgy"
                    class="focus:outline-none rounded-xl h-10 pl-2 bg-transparent bg-gray-200"
                  >
                    <option value="Brgy" disabled>Choose Baranggay</option>
                    <option
                      v-for="brgy in refBaranggay"
                      v-bind:key="brgy.id"
                      v-bind:value="brgy.brgyDesc"
                    >
                      {{ brgy.brgyDesc }}
                    </option>
                  </select>
                </div>
                <div class="justify-center flex">
                  <button
                    @click="addDeliveryArea()"
                    class="inline-flex items-center justify-center focus:outline-none px-4 vs:py-2 bg-red-700 rounded-full w-full h-6"
                  >
                    <p
                      class="text-base font-bold leading-normal text-center text-white"
                    >
                      Add
                    </p>
                  </button>
                </div>
              </div>
            </div>

            <div class="flex space-x-2 sm:w-full">
              <span class="mt-1.5 rounded-full material-icons text-red-600">
                shopping_cart
              </span>
              <div class="sm:w-full">
                <input
                  @click="
                    (dropdown4 = !dropdown4),
                      (dropdown2 = false),
                      (dropdown3 = false),
                      (dropdown1 = false)
                  "
                  type="text"
                  id="myInputSP"
                  v-on:keyup="myFunctionSP()"
                  placeholder="Search for place"
                  title="Shopping Place"
                  class="focus:outline-none flex sm:w-full ssm:w-full ssm:h-auto ssm:text-xs vs:w-full w-52 h-11 px-4 items-center py-2.5 bg-gray-100 rounded-xl text-sm vs:text-xs lvs:text-sm leading-none text-gray-500"
                  v-model="shop_info.shoppingPlace"
                />
                <!-- {{shoppingPlace}} -->
                <!-- </button> -->
                <div class="relative">
                  <div
                    v-if="dropdown4"
                    class="absolute py-3 bg-white rounded-lg shadow-xl right-0 h-35.1 sm:w-full w-52"
                  >
                    <div
                      class="flex flex-col w-full px-2 justify-start items-start"
                    >
                      <div
                        id="scroll1"
                        class="flex px-2 flex-col overflow-y-scroll w-full h-24"
                      >
                        <ul id="myUL" class="space-y-1">
                          <li
                            v-for="(sp, index) in shoppingPlaces"
                            :key="index"
                            @click="
                              setShoppingPlace(index);
                              dropdown4 = !dropdown4;
                            "
                          >
                            <a href="#" :id="'sp' + index">{{
                              sp.shoppingPlace
                            }}</a>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div
            class="flex flex-row pt-3 ssm:pt-2 ssm:flex-col ssm:space-x-0 se:space-x-1 ssm:space-y-2 space-x-4 w-full justify-center"
          >
            <div class="flex flex-row space-x-2 sm:w-full">
              <span class="rounded-lg mt-1.5 material-icons text-red-700">
                alarm
              </span>
              <div
                class="flex items-center justify-start sm:w-full ssm:px-2 ssm:h-auto ssm:w-full vs:w-full w-52 h-12 vs:h-12 px-4 vs:px-2 bg-gray-100 rounded-xl"
              >
                <div
                  class="flex flex-col items-start justify-start h-full py-1.5 vs:w-full rounded-2xl"
                >
                  <span>
                    <input
                      v-model="shop_info.deliverySchedule"
                      name="deliverySchedule"
                      type="datetime-local"
                      class="ssm:text-xs block bg-gray-100 text-sm focus:outline-none leading-loose text-gray-900 w-44 sm:w-full vs:w-full h-auto"
                    />
                  </span>
                </div>
              </div>
            </div>

            <div class="flex space-x-2 sm:w-full">
              <span class="mt-1.5 rounded-full material-icons text-red-600">
                directions_car
              </span>
              <div class="sm:w-full">
                <input
                  @click="
                    (dropdown3 = !dropdown3),
                      (dropdown2 = false),
                      (dropdown1 = false),
                      (dropdown4 = false)
                  "
                  class="focus:outline-none flex sm:w-full ssm:w-full ssm:h-auto ssm:text-xs vs:w-full w-52 h-11 py-2.5 px-4 items-center bg-gray-100 rounded-xl text-sm vs:text-xs lvs:text-sm leading-none text-gray-500"
                  type="text"
                  id="myInputTM"
                  v-on:keyup="myFunctionTM()"
                  placeholder="Mode of transport.."
                  title="Transport Mode"
                  v-model="shop_info.transportMode"
                />

                <div class="relative">
                  <div
                    v-if="dropdown3"
                    class="absolute py-3 bg-white rounded-lg shadow-xl right-0 h-35.1 sm:w-full w-52"
                  >
                    <div
                      class="flex flex-col w-full px-2 justify-start items-start"
                    >
                      <div
                        id="scroll1"
                        class="flex px-2 flex-col overflow-y-scroll w-full h-24"
                      >
                        <ul id="myUL" class="space-y-1">
                          <li
                            v-for="(tm, index) in transportModes"
                            :key="index"
                            @click="
                              setTransportMode(index);
                              dropdown3 = !dropdown3;
                            "
                          >
                            <a href="#" :id="'tm' + index">{{
                              tm.transportMode
                            }}</a>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div
            class="flex flex-row pt-3 ssm:pt-2 ssm:flex-col se:space-x-1 ssm:space-x-0 ssm:space-y-2 space-x-4 w-full justify-center"
          >
            <div class="flex flex-row space-x-2 sm:w-full">
              <span class="rounded-lg mt-1.5 material-icons text-red-700">
                shopping_bag
              </span>
              <div
                class="flex items-center justify-start sm:w-full ssm:px-2 ssm:h-auto ssm:w-full vs:w-full w-52 h-12 vs:h-12 px-4 vs:px-2 bg-gray-100 rounded-xl"
              >
                <div
                  class="flex flex-col items-start justify-start w-full h-full py-1.5 rounded-2xl"
                >
                  <span>
                    <input
                      type="text"
                      v-model="shop_info.capacity"
                      name="capacity"
                      class="ssm:text-xs block bg-gray-100 text-sm focus:outline-none leading-7 text-gray-900 w-44 sm:w-full vs:w-full h-auto"
                    />
                  </span>
                </div>
              </div>
            </div>

            <div class="flex space-x-2 sm:w-full">
              <span class="mt-1.5 rounded-full material-icons text-red-600">
                payments
              </span>
              <div class="sm:w-full">
                <button
                  @click="
                    (dropdown2 = !dropdown2),
                      (dropdown1 = false),
                      (dropdown3 = false),
                      (dropdown4 = false)
                  "
                  class="focus:outline-none flex sm:w-full ssm:w-full ssm:h-auto ssm:text-xs vs:w-full w-52 h-11 py-2.5 px-4 items-center bg-gray-100 rounded-xl text-sm vs:text-xs lvs:text-sm leading-none text-gray-500"
                >
                  {{ shop_info.paymentMethod }}
                </button>
                <div class="relative">
                  <div
                    v-if="dropdown2"
                    class="absolute py-3 bg-white rounded-lg shadow-xl right-0 h-35.1 sm:w-full w-52"
                  >
                    <div
                      v-for="(pm, index) in Payments"
                      :key="index"
                      class="flex flex-col w-full space-y-3 px-2 justify-start items-start"
                    >
                      <button
                        @click="
                          setPayment(index);
                          dropdown2 = !dropdown2;
                        "
                        class="flex w-full focus:outline-none justify-start items-start px-2"
                      >
                        <p
                          :id="'pm' + index"
                          class="text-sm tracking-wide leading-none text-gray-900"
                        >
                          {{ pm }}
                        </p>
                      </button>
                      <hr class="flex w-full" />
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!--end-->

        <!--Comment section-->
        <div class="justify-center flex ssm:px-2 mt-3 sm:px-2 vs:px-2">
          <textarea
            rows="3"
            v-model="shop_info.caption"
            name="caption"
            class="p-4 bg-gray-100 shadow-sm text-sm ssm:text-xs vs:text-xs lvs:text-sm rounded-2xl rounded-md outline-none h-auto w-31.75 ssm:w-full vs:w-full"
            placeholder="Enter your post message here..."
          ></textarea>
        </div>
        <!--end-->

        <!--Post button-->
        <div class="justify-center flex mt-3 pb-3 px-2">
          <button
            @click="submit"
            class="inline-flex items-center justify-center focus:outline-none px-4 py-2 bg-red-700 rounded-full w-31.75 ssm:w-full ssm:h-8 vs:w-full h-10"
          >
            <p
              class="text-base ssm:text-sm vs:text-sm font-bold leading-normal text-center text-white"
            >
              Post
            </p>
          </button>
        </div>
        <!--end-->
      </div>
    </div>
  </div>
  <!--end-->
</template>

<script>
import api from "../api";
import store from "../store/index";
// import VueSimpleAlert from "vue-simple-alert";
import moment from "moment";
export default {
  props: ["btnText"],
  created() {
    this.shop_info.deliveryArea = this.btnText.offer_post.deliveryArea;
    this.shop_info.caption = this.btnText.offer_post.caption;
    this.shop_info.shoppingPlace = this.btnText.offer_post.shoppingPlace;
    this.shop_info.capacity = this.btnText.offer_post.capacity;
    this.shop_info.transportMode = this.btnText.offer_post.transportMode;
    this.shop_info.deliverySchedule = moment(
      this.btnText.offer_post.deliverySchedule
    ).format("YYYY-MM-DDThh:mm");
    this.shop_info.postStatus = this.btnText.offer_post.postStatus;
    this.shop_info.postNumber = this.btnText.offer_post.postNumber;
    this.shop_info.paymentMethod = this.btnText.offer_post.paymentMethod;
    this.shop_info.indexShoppingOfferPost = this.btnText.offer_post.indexShoppingOfferPost;
    console.log(this.shop_info);
    api
      .get("/api/refProvince")
      .then((res) => {
        this.refProvince = res.data;
      })
      .catch((error) => {
        console.log(error);
      });
      
  },
  data() {
    return {
      isVisible: true,
      hidden: false,
      shop_info: {
        indexShoppingOfferPost: "",
        postNumber: "",
        postStatus: "",
        deliveryArea: "",
        shoppingPlace: "",
        deliverySchedule: "",
        transportMode: "",
        capacity: "",
        paymentMethod: "",
        caption: "",
      },
      payment: "Payment Method",
      Payments: ["Cash on Delivery", "Gcash", "PayMaya", "Online Banking"],
      dropdown2: false,
      dropdown1: false,
      dropdown3: false,
      dropdown4: false,
      selectedProvince: "Province",
      selectedCity: "City",
      selectedBrgy: "Brgy",
      refProvince: [],
      refCity: [],
      newrefCity: [],
      refBaranggay: [],
      newrefBaranggay: [],
      areaError: null,
      deliveryAreaModal: false,
    };
  },
  methods: {
    close1() {
      this.$emit("closeModal1");
    },
    myFunctionSP() {
      var input, filter, ul, li, a, i, txtValue;
      input = document.getElementById("myInputSP");
      filter = input.value.toUpperCase();
      ul = document.getElementById("myUL");
      li = ul.getElementsByTagName("li");
      console.log(li[0].getElementsByTagName("a")[0]);
      for (i = 0; i < li.length; i++) {
        a = li[i].getElementsByTagName("a")[0];
        txtValue = a.textContent || a.innerText;
        if (txtValue.toUpperCase().search(filter) > -1) {
          li[i].style.display = "";
        } else {
          li[i].style.display = "none";
        }
      }
    },
    myFunctionTM() {
      var input, filter, ul, li, a, i, txtValue;
      input = document.getElementById("myInputTM");
      filter = input.value.toUpperCase();
      ul = document.getElementById("myUL");
      li = ul.getElementsByTagName("li");
      console.log(li[0].getElementsByTagName("a")[0]);
      for (i = 0; i < li.length; i++) {
        a = li[i].getElementsByTagName("a")[0];
        txtValue = a.textContent || a.innerText;
        if (txtValue.toUpperCase().search(filter) > -1) {
          li[i].style.display = "";
        } else {
          li[i].style.display = "none";
        }
      }
    },
    addDeliveryArea() {
      if (this.selectedProvince == "Province") {
        this.areaError = "Please select atleast Province";
        this.selectedBrgy = "Brgy";
        this.selectedProvince = "Province";
        this.selectedCity = "City";
        return;
      }
      if (this.selectedCity == "City") {
        document.getElementById("City").options[
          document.getElementById("City").selectedIndex
        ].text = "";
      }
      if (this.selectedBrgy == "Brgy") {
        this.selectedBrgy = "";
      }

      this.shop_info.deliveryArea =
        document.getElementById("Province").options[
          document.getElementById("Province").selectedIndex
        ].text +
        " " +
        document.getElementById("City").options[
          document.getElementById("City").selectedIndex
        ].text +
        " " +
        this.selectedBrgy;
      this.deliveryAreaModal = false;
      this.areaError = null;
      this.selectedBrgy = "Brgy";
      this.selectedProvince = "Province";
      this.selectedCity = "City";
    },
    getProvCode() {
      var getProvCode = document.getElementById("Province").value;
      api
        .get("api/refcityMunicipality", { params: { provCode: getProvCode } })
        .then((res) => {
          this.refCity = res.data;
        })
        .catch((errors) => {
          console.log(errors);
        });
    },
    getCityCode() {
      var getCityCode = document.getElementById("City").value;
      console.log(getCityCode);
      api
        .get("api/refBrgy", { params: { cityCode: getCityCode } })
        .then((res) => {
          console.log("brgy", res.data);
          this.refBaranggay = res.data;
        })
        .catch((errors) => {
          console.log(errors);
        });
    },
    setTransportMode(index) {
      this.shop_info.transportMode = document.getElementById(
        "tm" + index
      ).innerHTML;
    },
    setShoppingPlace(index) {
      this.shop_info.shoppingPlace = document.getElementById(
        "sp" + index
      ).innerHTML;
    },
    // editOfferPost:function(){
    //     api.post("api/editshoppingoffers", this.shop_info)
    //     .then((response) => {
    //     console.log("offer",this.shoppingOffer_infos)
    //             console.log(response.data.message)
    //             window.location.reload();
    //         })
    //         .catch((errors) => {
    //             console.log(errors)
    //         })
    // },
    submit() {
      //       var info = {
      //     indexShoppingOfferPost: this.shop_info.indexShoppingOfferPost,
      //     postNumber: this.shop_info.postNumber,
      //     postStatus: this.shop_info.postStatus,
      //     deliveryArea: this.shop_info.deliveryArea,
      //     shoppingPlace: this.shop_info.shoppingPlace,
      //     deliverySchedule: this.shop_info.deliverySchedule,
      //     transportMode: this.shop_info.transportMode,
      //     capacity: this.shop_info.offer_post,
      //     paymentMethod: this.shop_info.paymentMethod,
      //     caption: this.shop_info.caption,
      //   };
      api
        .post("/api/editshoppingoffers", this.shop_info)
        .then(() => {
          //this.user = res.data;
          //VueSimpleAlert.alert(res.data.message,"Success","success")
          //this will get the updated version of posts state from the states

          store.dispatch("getPosts").then(() => {
            store.dispatch("getShoppingPlaces");
            store.dispatch("getTransportModes");
            this.$emit("getSortPosts");
            this.$emit("closeModal1");
            
          });
          // window.location.reload();
        })
        .catch((errors) => {
          console.log(errors);
        });
      //this.toggle=false;
    },
    setPayment(index) {
      this.shop_info.paymentMethod = document.getElementById(
        "pm" + index
      ).innerHTML;
    },

    // update: function() {
    //     var indexShoppingOfferPost = indexShoppingOfferPost;
    //     var postNumber = this.btnText.postNumber;
    //     var postStatus = this.btnText.postStatus;
    //     var deliveryArea = this.btnText.deliveryArea;
    //     var shoppingPlace = this.btnText.shoppingPlace;
    //     var deliverySchedule = this.btnText.deliverySchedule;
    //     var transportMode = this.btnText.transportMode;
    //     var capacity = this.btnText.capacity;
    //     var paymentMethod = this.btnText.paymentMethod;
    //     var caption = this.btnText.caption;

    //     api.post("api/shoppingoffers/update",{
    //         indexShoppingOfferPost: indexShoppingOfferPost,
    //         postNumber: postNumber,
    //         postStatus: postStatus,
    //         deliveryArea: deliveryArea,
    //         shoppingPlace: shoppingPlace,
    //         deliverySchedule: deliverySchedule,
    //         transportMode: transportMode,
    //         capacity: capacity,
    //         paymentMethod: paymentMethod,
    //         caption: caption
    //     });
    // },
  },
  computed: {
    transportModes() {
      return store.getters.getTransportModes;
    },
    shoppingPlaces() {
      return store.getters.getShoppingPlaces;
    },
  },
};
</script>
