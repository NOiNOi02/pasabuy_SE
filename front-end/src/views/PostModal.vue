<template>
  <!-- Post Modal-->
  <div
    v-on:click.self="close"
    class="z-50 bg-black font-nunito bg-opacity-25 fixed inset-0 flex ssm:px-2 vs:px-2 sm:px-2 justify-center items-center"
    v-if="mainModal"
  >
    <div
      class="hideIf inline-flex flex-col space-y-2 bg-white shadow rounded-xl h-auto w-550 ssm:w-full vs:w-full sm:w-full"
    >
      <div class="flex flex-col mt-4">
        <!--Create Post section-->
        <h1
          class="items-center justify-center ml-24 sm:ml-24 ssm:ml-8 ssm:pl-8 vs:ml-6 pb-4 text-gray-900 leading-normal pl-20 text-2xl ssm:text-xl vs:text-xl font-bold text-center"
        >
          Create Post
          <button
            @click.prevent="close"
            class="pl-14 ml-20 sm:ml-14 ssm:pl-4 ssm:ml-4 vs:pl-4 vs:ml-8 focus:outline-none text-sm ssm:text-xs vs:text-xs mb-1 leading-none text-indigo-900"
          >
            Close
          </button>
        </h1>
        <!--end-->

        <!--Shopping Offer and Order Request Button-->
        <div
          class="flex flex-row items-center justify-around pb-2 space-x-2 ssm:space-x-1"
        >
          <div
            @click="isActive_function('btn1')"
            :class="{ active: activeBtn === 0 }"
            class="inline-flex"
          >
            <button
              @click="toggleOrderRequestbtn"
              class="text-base ssm:text-sm vs:text-sm font-nunito font-bold focus:outline-none leading-none text-center text-black uppercase"
            >
              Order Request
            </button>
          </div>
          <div
            @click="isActive_function('btn2')"
            :class="{ active: activeBtn === 'btn2' }"
            class="inline-flex"
          >
            <button
              @click="toggleShopOfferbtn"
              class="text-base ssm:text-sm vs:text-sm font-nunito font-bold focus:outline-none leading-none text-center text-black uppercase"
            >
              Shopping Offer
            </button>
          </div>
        </div>
        <hr />
        <!--end-->

        <!--Create Shopping Offer-->
        <!--User Profile-->
        <div v-if="showCreateShoppingOffer">
          <div
            class="inline-flex sm:px-7 space-x-2 items-center justify-start p-4 ssm:mt-0 vs:mt-1"
          >
            <img
              class="w-14 h-full vs:w-12 ssm:w-10 border rounded-full border-gray-200"
              :src="user.profilePicture"
            />
            <p
              class="text-base ssm:text-sm vs:text-sm lvs:text-base font-bold leading-none text-gray-900"
            >
              {{ user.firstName }} {{ user.lastName }}
            </p>
          </div>
          <!--end-->
          <p class="text-red-500 text-center">{{ errorOffer }}</p>
          <p class="text-red-500 text-center">{{ postError }}</p>
          <!--Delivery information list-->
          <div
            class="flex flex-col mt-1 vs:mt-1 ssm:px-2 vs:px-2 justify-center items-center"
          >
            <div
              class="flex flex-row ssm:flex-col vs:flex-col sm:flex-col vs:space-x-0 vs:space-y-2 sm:space-x-0 sm:space-y-2 ssm:space-x-0 ssm:space-y-2 ssm:pt-2 pt-3 space-x-4 w-full justify-center"
            >
              <div class="flex space-x-2 vs:w-full sm:w-full">
                <span class="mt-1.5 rounded-full material-icons text-red-600">
                  delivery_dining
                </span>
                <div class="vs:w-full sm:w-full">
                  <button
                    @click="
                      (deliveryAreaModal = !deliveryAreaModal),
                        (dropdown2 = false),
                        (dropdown3 = false),
                        (dropdown4 = false)
                    "
                    class="focus:outline-none flex sm:w-full ssm:w-full ssm:h-auto ssm:text-xs vs:w-full w-52 h-11 py-2.5 px-4 items-center bg-gray-100 rounded-xl text-sm vs:text-xs lvs:text-sm leading-none text-gray-500"
                  >
                    {{ deliveryArea }}
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
                <div class="vs:w-full sm:w-full">
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
                    placeholder="Shopping Place"
                    title="Shopping Place"
                    class="focus:outline-none flex sm:w-full ssm:w-full ssm:h-auto ssm:text-xs vs:w-full w-52 h-11 px-4 items-center py-2.5 bg-gray-100 rounded-xl text-sm vs:text-xs lvs:text-sm leading-none text-gray-500"
                    v-model="shoppingPlace"
                  />
                  <!-- {{shoppingPlace}} -->
                  <!-- </button> -->
                  <div class="relative md:w-full">
                    <div
                      v-if="dropdown4"
                      class="absolute md:w-full py-3 bg-white rounded-lg shadow-xl right-0 h-35.1 sm:w-full w-52"
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
              class="flex flex-row sm:px-7 ssm:flex-col vs:flex-col sm:flex-col vs:space-x-0 vs:space-y-2 sm:space-x-0 sm:space-y-2 ssm:space-x-0 ssm:space-y-2 ssm:pt-2 pt-3 space-x-4 w-full justify-center"
            >
              <div class="flex space-x-2 vs:w-full sm:w-full">
                <span class="mt-1.5 rounded-full material-icons text-red-600">
                  alarm
                </span>
                <input
                  type="datetime-local"
                  class="focus:outline-none flex sm:w-full ssm:w-full ssm:h-auto ssm:text-xs vs:w-full w-52 h-11 py-2.5 px-4 items-center bg-gray-100 rounded-xl text-sm vs:text-xs lvs:text-sm leading-none text-gray-500"
                  placeholder="Schedule"
                  v-model="sched"
                />
              </div>

              <div class="flex space-x-2 vs:w-full sm:w-full">
                <span class="mt-1.5 rounded-full material-icons text-red-600">
                  directions_car
                </span>
                <div class="vs:w-full sm:w-full">
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
                    v-model="transport"
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
              class="flex flex-row sm:px-7 ssm:flex-col vs:flex-col sm:flex-col vs:space-x-0 vs:space-y-2 sm:space-x-0 sm:space-y-2 ssm:space-x-0 ssm:space-y-2 ssm:pt-2 pt-3 space-x-4 w-full justify-center"
            >
              <div class="flex space-x-2 sm:px-7 vs:w-full sm:w-full">
                <span class="mt-1.5 rounded-full material-icons text-red-600">
                  shopping_bag
                </span>
                <input
                  class="focus:outline-none flex sm:w-full ssm:w-full ssm:h-auto ssm:text-xs vs:w-full w-52 h-11 py-2.5 px-4 items-center bg-gray-100 rounded-xl text-sm vs:text-xs lvs:text-sm leading-none text-gray-500"
                  placeholder="Capacity"
                  v-model="capacity"
                />
              </div>

              <div class="flex space-x-2 vs:w-full sm:w-full">
                <span class="mt-1.5 rounded-full material-icons text-red-600">
                  payments
                </span>
                <div class="sm:w-full vs:w-full">
                  <button
                    @click="
                      (dropdown2 = !dropdown2),
                        (dropdown1 = false),
                        (dropdown3 = false),
                        (dropdown4 = false)
                    "
                    class="focus:outline-none flex sm:w-full ssm:w-full ssm:h-auto ssm:text-xs vs:w-full w-52 h-11 py-2.5 px-4 items-center bg-gray-100 rounded-xl text-sm vs:text-xs lvs:text-sm leading-none text-gray-500"
                  >
                    {{ payment }}
                  </button>
                  <div class="relative">
                    <div
                      v-if="dropdown2"
                      class="absolute py-3 bg-white rounded-lg shadow-xl right-0 h-35.1 vs:w-full sm:w-full w-52"
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
          <div class="justify-center flex mt-3 px-2">
            <textarea
              id="postMessage"
              name="postMessage"
              rows="3"
              v-model="caption"
              class="p-4 bg-gray-100 shadow-sm text-sm ssm:text-xs vs:text-xs lvs:text-sm rounded-2xl rounded-md outline-none h-auto w-31.75 vs:w-full"
              placeholder="Enter your post message here..."
            ></textarea>
          </div>
          <!--end-->

          <!--Post button-->
          <div class="justify-center flex mt-3 pb-3 px-2">
            <button
              @click="postOffer"
              class="inline-flex items-center justify-center focus:outline-none px-4 vs:py-2 bg-red-700 rounded-full w-31.75 ssm:w-full vs:w-full h-10"
            >
              <p
                class="text-base ssm:text-sm vs:text-sm sm:text-sm font-bold leading-normal text-center text-white"
              >
                Post
              </p>
            </button>
          </div>
          <!--end-->
        </div>
        <!--end of Create Shopping Offer-->

        <!--Create Order Request-->
        <!--User profile section-->
        <div v-if="showCreateOrderRequest">
          <div class="inline-flex space-x-2 items-center justify-start p-4">
            <img
              class="w-14 h-full vs:w-12 ssm:w-10 border rounded-full border-gray-200"
              :src="user.profilePicture"
            />
            <p
              class="text-base ssm:text-sm vs:text-sm lvs:text-base font-bold leading-none text-gray-900"
            >
              {{ user.firstName }} {{ user.lastName }}
            </p>
          </div>
          <!--end-->
          <p class="text-red-500 text-center">{{ errorOrder }}</p>

          <!--Delivery Information List-->
          <div
            class="flex flex-col ssm:px-2 sm:px-2 justify-center items-center vs:px-2"
          >
            <div
              class="flex flex-row ssm:flex-col vs:flex-col sm:flex-col vs:space-x-0 vs:space-y-2 sm:space-x-0 sm:space-y-2 ssm:space-x-0 ssm:space-y-2 space-x-4 w-full justify-center"
            >
              <div class="flex space-x-2 vs:w-full sm:w-full">
                <span class="mt-1.5 rounded-full material-icons text-red-600">
                  delivery_dining
                </span>
                <div class="sm:w-full vs:w-full">
                  <button
                    @click="
                      (dropdown1 = !dropdown1),
                        (dropdown2 = false),
                        (dropdown3 = false),
                        (dropdown4 = false)
                    "
                    class="focus:outline-none flex vs:w-full sm:w-full ssm:w-full ssm:h-auto ssm:text-xs ssm:pr-0 vs:w-full w-52 h-11 py-2.5 px-4 items-center bg-gray-100 rounded-xl text-sm vs:text-xs lvs:text-sm leading-none text-gray-500"
                  >
                    {{ deliveryAddress }}
                  </button>
                  <div class="relative">
                    <div
                      v-if="dropdown1"
                      class="absolute p-2 bg-white rounded-lg shadow-xl right-0 h-40 sm:w-full w-52"
                    >
                      <div
                        id="scroll1"
                        class="flex-auto overflow-y-scroll h-28"
                      >
                        <div class="flex flex-col items-start space-y-1.5">
                          <div
                            @click="
                              getHomeAddressValue();
                              dropdown1 = !dropdown1;
                            "
                            class="flex flex-col w-full space-y-1 px-2"
                            style="cursor: pointer"
                          >
                            <p
                              class="text-sm font-bold tracking-wide leading-none text-gray-900"
                            >
                              Home Address
                            </p>
                            <div class="flex-1 w-full px-2">
                              <p
                                id="homeAdd"
                                class="text-sm tracking-wide leading-none text-gray-900"
                              >
                                {{ userHomeAddress.province }},
                                {{ userHomeAddress.cityMunicipality }},
                                {{ userHomeAddress.barangay }},
                                {{ userHomeAddress.houseNumber }}
                              </p>
                            </div>
                          </div>
                          <hr class="flex w-full" />
                          <div
                            v-for="(shipAdd, index) in userShippingAddress"
                            :key="index"
                          >
                            <div
                              @click="
                                getShipAddressValue(index);
                                dropdown1 = !dropdown1;
                              "
                              class="flex flex-col w-full space-y-1 px-2"
                              style="cursor: pointer"
                            >
                              <p
                                class="text-sm font-bold tracking-wide leading-none text-gray-900"
                              >
                                Shipping Address {{ index + 1 }}
                              </p>
                              <div class="flex-1 w-full px-2">
                                <p
                                  :id="'shipAdd' + index"
                                  class="text-sm tracking-wide leading-none text-gray-900"
                                >
                                  {{ shipAdd.province }},
                                  {{ shipAdd.cityMunicipality }},
                                  {{ shipAdd.barangay }},
                                  {{ shipAdd.houseNumber }}
                                </p>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div
                        @click="addAddress = !addAddress"
                        class="flex text-base items-center focus:outline-none p-2 space-x-1"
                        style="cursor: pointer"
                      >
                        <span class="text-red-700 material-icons">
                          add_circle
                        </span>
                        <div class="flex-1 w-full">
                          <p
                            class="text-sm font-bold tracking-wide leading-none text-red-700"
                          >
                            Add New Shipping Address
                          </p>
                        </div>
                      </div>
                      <div
                        @click.self="openAddModal"
                        v-if="addAddress"
                        class="z-50 bg-black bg-opacity-25 fixed inset-0 flex justify-center items-center ssm:px-2 vs:px-2"
                      >
                        <div
                          class="inline-flex flex-col bg-white p-4 space-y-4 shadow rounded-xl h-auto w-80"
                        >
                          <div
                            class="flex flex-row w-full items-center space-x-2"
                          >
                            <label
                              class="block text-sm font-bold tracking-wide leading-none text-gray-900"
                              >Title</label
                            >
                            <input
                              class="appearance-none focus:outline-none border rounded w-full py-1 px-3 text-grey-darker"
                              id="addressTitle"
                              type="text"
                              placeholder="Your shipping address title"
                            />
                          </div>
                          <div
                            class="flex flex-row w-full items-center space-x-2"
                          >
                            <label
                              class="block text-sm font-bold tracking-wide leading-none text-gray-900"
                              >Address</label
                            >
                            <input
                              class="appearance-none focus:outline-none border rounded w-full py-1 px-3 text-grey-darker"
                              id="addressTitle"
                              type="text"
                              placeholder="Your shipping address"
                            />
                          </div>
                          <div class="justify-center flex">
                            <button
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
                    </div>
                  </div>
                </div>
              </div>
              <div class="flex sm:px-7 space-x-2 sm:w-full vs:w-full">
                <span class="mt-1.5 rounded-full material-icons text-red-600">
                  shopping_cart
                </span>
                <div class="sm:w-full vs:w-full">
                  <input
                    @click="
                      (dropdown4 = !dropdown4),
                        (dropdown2 = false),
                        (dropdown3 = false),
                        (dropdown1 = false)
                    "
                    type="text"
                    id="myInput"
                    v-on:keyup="myFunction()"
                    placeholder="Shopping Place"
                    title="Shopping Place"
                    class="focus:outline-none flex sm:w-full ssm:w-full ssm:h-auto ssm:text-xs vs:w-full w-52 h-11 px-3 items-center py-2.5 bg-gray-100 rounded-xl text-sm vs:text-xs lvs:text-sm leading-none text-gray-500"
                    v-model="shoppingPlaceRequest"
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
                                setShoppingPlaceRequest(index);
                                dropdown4 = !dropdown4;
                              "
                            >
                              <a href="#" :id="'spR' + index">{{
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
              class="flex flex-row ssm:flex-col vs:flex-col sm:flex-col vs:space-x-0 vs:space-y-2 sm:space-x-0 sm:space-y-2 ssm:space-x-0 ssm:space-y-2 space-x-4 w-full justify-center"
            >
              <div class="flex sm:px-7 space-x-2 sm:w-full vs:w-full">
                <span class="mt-1.5 rounded-full material-icons text-red-600">
                  alarm
                </span>
                <input
                  type="datetime-local"
                  class="focus:outline-none vs:w-full sm:w-full ssm:w-full ssm:h-auto ssm:text-xs flex vs:w-full w-52 h-11 py-2.5 px-4 items-center vs:pr-0 bg-gray-100 rounded-xl text-sm vs:text-xs lvs:text-sm leading-none text-gray-500"
                  placeholder="Schedule"
                  v-model="schedRequest"
                />
              </div>

              <div class="flex sm:px-7 space-x-2 sm:w-full vs:w-full">
                <span class="mt-1.5 rounded-full material-icons text-red-600">
                  payments
                </span>
                <div class="sm:w-full vs:w-full">
                  <button
                    @click="
                      (dropdown8 = !dropdown8),
                        (dropdown6 = false),
                        (dropdown3 = false),
                        (dropdown4 = false)
                    "
                    class="focus:outline-none flex vs:w-full sm:w-full ssm:w-full ssm:h-auto ssm:text-xs vs:w-full w-52 h-11 py-2.5 px-4 items-center bg-gray-100 rounded-xl text-sm vs:text-xs lvs:text-sm leading-none text-gray-500"
                  >
                    {{ paymentRequest }}
                  </button>
                  <div class="relative">
                    <div
                      v-if="dropdown8"
                      class="absolute py-3 bg-white rounded-lg shadow-xl right-0 h-35.1 sm:w-full w-52"
                    >
                      <div
                        v-for="(pm, index) in Payments"
                        :key="index"
                        class="flex flex-col w-full space-y-3 px-2 justify-start items-start"
                      >
                        <button
                          @click="
                            setPaymentRequest(index);
                            dropdown8 = !dropdown8;
                          "
                          class="flex w-full focus:outline-none justify-start items-start px-2"
                        >
                          <p
                            :id="'pmR' + index"
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

          <!--Select Shopping List button-->
          <div
            v-if="showShopListButton"
            class="flex justify-center items-center ssm:px-2 mt-3 sm:px-2 vs:px-2"
          >
            <button
              @click="hidePrevious"
              class="focus:outline-none inline-flex items-center justify-center p-4 bg-gray-100 rounded-full w-31.75 ssm:w-full vs:w-full h-14 ssm:h-10 vs:h-12"
            >
              <div class="flex space-x-2 items-center">
                <img class="w-6 h-full rounded-lg" src="img/add.svg" />
                <p
                  class="text-base ssm:text-sm vs:text-sm lvs:text-base font-bold leading-none text-gray-900"
                >
                  Select Shopping List
                </p>
              </div>
            </button>
          </div>
          <!--end-->

          <!--Shopping List-->
          <div v-if="showItemList" class="flex px-6 mt-3 w-full">
            <div class="flex flex-col w-full bg-gray-100 pb-4 px-4 rounded-xl">
              <div class="flex mt-4 flex-row justify-between items-start">
                <div class="flex flex-row space-x-2">
                  <p
                    class="text-base ssm:text-sm font-bold leading-none text-gray-900"
                  >
                    {{ selectedList.shoppingListTitle }}
                  </p>
                  <p class="text-base ssm:text-sm leading-none text-gray-500">
                    ({{ isFew() }} items)
                  </p>
                </div>
                <div>
                  <button
                    @click="listEdit = !listEdit"
                    class="focus:outline-none"
                  >
                    <span class="material-icons text-lg vs:text-sm ssm:text-sm">
                      more_vert
                    </span>
                  </button>
                  <div class="relative w-full">
                    <div
                      v-if="listEdit"
                      class="absolute flex flex-col space-y-2 p-2 leading-loose rounded-lg border-2 border-gray-100 bg-white right-0 w-30"
                    >
                      <button
                        @click="editShopList"
                        class="flex flex-row items-center font-normal text-base leading-none text-gray-900 focus:outline-none gap-x-2"
                      >
                        <span class="material-icons text-base text-gray-900">
                          mode
                        </span>
                        Edit
                      </button>
                      <button
                        @click="hidePrevious"
                        class="flex flex-row items-center font-normal text-base leading-none text-gray-900 focus:outline-none gap-x-2"
                      >
                        <span class="material-icons text-base text-gray-900">
                          autorenew
                        </span>
                        Change
                      </button>
                    </div>
                  </div>
                </div>
              </div>
              <div
                id="scroll1"
                class="flex flex-col justify-start items-start px-4 text-sm w-full overflow-y-auto space-y-4 mt-4 h-22"
              >
                <span
                  v-for="shoppingItems in computedShopItemList"
                  :key="shoppingItems"
                >
                  <li
                    class="text-base w-full vs:text-sm ssm:text-sm leading-none text-gray-900"
                    v-if="shoppingItems.status == 1"
                  >
                    {{ shoppingItems.product }} ({{ shoppingItems.size }}) ·
                    {{ shoppingItems.brand }} [{{ shoppingItems.quantity }}]
                  </li>
                </span>
              </div>
              <button
                @click="showMoreshowLess"
                v-if="isFew() > 4"
                class="focus:outline-none flex justify-start items-start text-sm text-gray-500"
              >
                {{ showListStatus }}
              </button>
            </div>
          </div>
          <!--end-->

          <!--Comment Section-->
          <div class="justify-center flex mt-3 ssm:px-2 vs:px-2 sm:px-2">
            <textarea
              id="postMessage"
              name="postMessage"
              rows="3"
              v-model="captionRequest"
              class="p-4 bg-gray-100 shadow-sm text-sm ssm:text-xs vs:text-xs lvs:text-sm rounded-2xl rounded-md outline-none h-auto w-31.75 ssm:w-full vs:w-full"
              placeholder="Enter your post message here..."
            ></textarea>
          </div>
          <!--end-->

          <!--Post button-->
          <div class="justify-center flex mt-3 pb-3 ssm:px-2 vs:px-2 sm:px-2">
            <button
              @click="postRequest"
              class="inline-flex items-center justify-center focus:outline-none px-4 py-2 bg-red-700 rounded-full w-31.75 ssm:w-full vs:w-full h-10"
            >
              <p
                class="text-base ssm:text-sm vs:text-sm sm:text-sm font-bold leading-normal text-center text-white"
              >
                Post
              </p>
            </button>
          </div>
          <!--end-->
        </div>
        <!--end of Create Order Request-->
      </div>
    </div>
  </div>
  <!--end of Post Modal-->

  <!--Select Shopping List Modal-->
  <transition name="fadeSlide">
    <div
      v-if="showSelectShopListModal"
      class="hideIf2 font-nunito fixed z-50 inset-0 flex ssm:px-2 vs:px-2 sm:px-2 justify-center items-center"
    >
      <div
        class="flex flex-col bg-white shadow rounded-xl h-auto w-550 ssm:w-full vs:w-full sm:w-full"
      >
        <div class="flex justify-between items-center p-4 flex-row">
          <button
            @click="showPreviousModal1"
            class="focus:outline-none text-sm font-bold leading-none text-right text-indigo-900"
          >
            Back
          </button>
          <p
            class="text-2xl ssm:text-sm se:text-base vs:text-lg font-bold leading-normal text-center text-gray-900"
          >
            Select Shopping List
          </p>
          <button
            class="invisible text-sm font-bold leading-none text-right text-indigo-900"
          >
            Close</button
          ><!--invisible, used only for auto margin header. If design need close button just delete the invisible class-->
        </div>
        <hr class="w-full" />
        <div class="flex w-full px-4 pt-4">
          <div class="flex flex-col overflow-y-auto h-72 w-full space-y-3">
            <div
              class="flex flex-row w-full justify-between items-center"
              v-for="list in shoppingLists"
              :key="list.shoppingListNumber"
            >
              <div class="space-x-2">
                <label class="inline-flex items-center">
                  <input
                    type="radio"
                    name="list"
                    class="form-radio w-4 h-4 vs:w-3 vs:h-3 lvs:w-4 lvs:h-4"
                    :id="'listNumber' + list.shoppingListNumber"
                  />
                  <span
                    class="ml-5 text-base ssm:text-xs vs:text-sm lvs:text-base"
                    >{{ list.shoppingListTitle }}</span
                  >
                </label>
              </div>
              <div>
                <button
                  @click="
                    edit2 = list.shoppingListNumber;
                    edit3 = !edit3;
                  "
                  class="focus:outline-none"
                >
                  <span class="material-icons vs:text-xs"> more_vert </span>
                </button>
                <div class="relative w-full">
                  <div
                    v-if="edit2 == list.shoppingListNumber && edit3"
                    class="absolute p-2 leading-loose rounded-lg border-2 border-gray-100 bg-white right-0 w-30"
                  >
                    <button
                      @click="editShopListAtSelectShopList"
                      class="flex flex-row items-center font-normal text-base leading-none text-gray-900 focus:outline-none gap-x-2"
                    >
                      <span class="material-icons text-base text-gray-900">
                        mode
                      </span>
                      Edit
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div
          class="flex flex-row w-full justify-around vs:space-x-2 sm:space-x-4 items-center p-4"
        >
          <button
            @click="
              createNewShopList();
              ctr = 0;
            "
            class="focus:outline-none flex items-center justify-center w-56 h-full px-4 py-2 border-2 rounded-full border-red-700"
          >
            <p class="text-base font-bold leading-none text-gray-900">
              Create New
            </p>
          </button>
          <button
            @click="confirmShopList"
            class="focus:outline-none flex items-center justify-center w-56 h-full px-4 py-2.5 bg-red-700 rounded-full"
          >
            <p class="text-base font-bold leading-none text-white">Confirm</p>
          </button>
        </div>
      </div>
    </div>
  </transition>
  <!--end-->

  <!--Create New Shopping List Modal-->
  <transition name="fadeSlide">
    <div
      v-if="showCreateNewShopListModal"
      class="z-50 font-nunito fixed inset-0 flex ssm:px-2 vs:px-2 sm:px-2 justify-center items-center"
    >
      <div
        class="flex flex-col bg-white shadow rounded-xl h-auto w-550 ssm:w-full vs:w-full sm:w-full"
      >
        <div class="flex justify-between items-center p-4 flex-row">
          <button
            @click="showPreviousModal2"
            class="focus:outline-none text-sm font-bold leading-none text-right text-indigo-900"
          >
            Back
          </button>
          <p
            class="text-2xl ssm:text-sm se:text-base vs:text-lg font-bold leading-normal text-center text-gray-900"
          >
            Create New Shopping List
          </p>
          <button
            class="invisible text-sm font-bold leading-none text-right text-indigo-900"
          >
            Close</button
          ><!--invisible, used only for auto margin header. If design need close button just delete the invisible class-->
        </div>
        <hr class="w-full" />
        <div class="flex flex-col w-full space-y-2 p-4">
          <div class="flex flex-row items-center space-y-1 w-full">
            <input
              id="createTitle"
              type="text"
              placeholder="Title"
              class="w-10 focus:outline-none"
              oninput='this.style.width = 0; this.style.width = this.scrollWidth + "px";'
            />
            <button
              @click="toggleInputField('createTitle')"
              class="focus:outline-none pl-1 pb-1"
            >
              <span class="material-icons mt-1 md-18 text-gray-600">
                mode_edit
              </span>
            </button>
          </div>
          <div class="flex space-y-2 flex-col w-full overflow-y-auto h-64 px-4">
            <div class="flex flex-row items-center space-x-3 select-none pl-3">
              <span
                @click="new_item = !new_item"
                class="cursor-pointer material-icons"
              >
                add_circle
              </span>
              <p class="">Add new item</p>
            </div>
            <div
              v-if="new_item"
              class="ring-1 ring-gray-400 p-5 space-y-3 rounded-xl"
            >
              <input
                id="product"
                type="text"
                placeholder="Product"
                class="rounded-xl pl-5 w-full focus:outline-none h-10 bg-gray-100"
              />
              <div class="flex flex-row space-x-2">
                <input
                  id="brand"
                  type="text"
                  placeholder="Brand"
                  class="rounded-xl pl-5 w-full focus:outline-none h-10 bg-gray-100"
                />
                <input
                  id="size"
                  type="text"
                  placeholder="Size"
                  class="w-40 rounded-xl pl-5 focus:outline-none h-10 bg-gray-100"
                />
              </div>
              <div class="flex flex-row space-x-2">
                <p class="font-bold">Quantity</p>
                <span
                  @click="quantity++"
                  class="material-icons select-none cursor-pointer text-red-700"
                >
                  add
                </span>
                <p id="quants">{{ quantity }}</p>
                <span
                  @click="quantity = minusQty(quantity)"
                  class="material-icons select-none cursor-pointer text-red-700"
                >
                  remove
                </span>
              </div>
              <div class="flex justify-end">
                <div class="space-x-3">
                  <button
                    @click="new_item = false"
                    class="ring-2 rounded-2xl h-6 w-20 font-bold ring-red-buttons focus:outline-none"
                  >
                    Cancel
                  </button>
                  <button
                    @click="add_newItem1()"
                    class="ring-2 rounded-2xl h-6 w-20 font-bold text-white ring-red-buttons focus:outline-none bg-red-buttons"
                  >
                    Add
                  </button>
                </div>
              </div>
            </div>
            <div
              class="flex flex-row w-full justify-between items-center space-x-3"
              v-for="item in new_items"
              :key="item.id"
            >
              <div class="flex flex-row vs:space-x-2 ssm:space-x-1 space-x-4">
                <div
                  class="itemButtons bg-white border-2 rounded-none w-4 h-4 flex flex-shrink-0 justify-center items-center mr-2 border-gray-900"
                >
                  <input
                    type="checkbox"
                    class="opacity-0"
                    :checked="item.status === 1"
                    :id="'check' + item.id"
                  />
                  <img
                    src="img/check-mark.svg"
                    class="fill-current hidden w-3 h-3 text-black mr-3 font-bold pointer-events-none"
                  />
                </div>
                <div class="flex flex-col space-y-2">
                  <p
                    class="text-base ssm:text-sm se:text-sm leading-none text-gray-900"
                  >
                    {{ item.product }} ({{ item.size }})
                  </p>
                  <p
                    class="text-base ssm:text-sm se:text-sm leading-none text-gray-900"
                  >
                    {{ item.brand }}
                  </p>
                </div>
              </div>
              <div class="flex flex-row space-x-2 items-center">
                <button
                  class="focus:outline-none flex"
                  @click="item.quantity++"
                >
                  <span class="material-icons bg-gray-100 text-red-700">
                    add
                  </span>
                </button>
                <p
                  class="text-base ssm:text-sm se:text-sm items-center flex leading-none text-gray-900"
                >
                  {{ item.quantity }}
                </p>
                <button
                  class="focus:outline-none flex"
                  @click="item.quantity = minusQty(item.quantity)"
                >
                  <span class="material-icons bg-gray-100 text-red-700">
                    remove
                  </span>
                </button>
                <button class="focus:outline-none flex">
                  <span class="material-icons"> more_vert </span>
                </button>
              </div>
            </div>
          </div>

          <div class="flex px-4 justify-end items-center">
            <p class="text-xs leading-none text-gray-500">Updated 7:13 PM</p>
          </div>
        </div>
        <div
          class="flex flex-row w-full justify-around vs:space-x-2 sm:space-x-4 items-center p-4"
        >
          <button
            @click="showPreviousModal2"
            class="focus:outline-none flex items-center justify-center w-56 h-full px-4 py-2 border-2 rounded-full border-red-700"
          >
            <p class="text-base font-bold leading-none text-gray-900">Cancel</p>
          </button>
          <button
            @click="saveList"
            class="focus:outline-none flex items-center justify-center w-56 h-full px-4 py-2.5 bg-red-700 rounded-full"
          >
            <p class="text-base font-bold leading-none text-white">Save</p>
          </button>
        </div>
      </div>
    </div>
  </transition>
  <!--end-->

  <!--Edit Shopping List Modal-->
  <transition name="fadeSlide">
    <div
      v-if="showEditShopListModal"
      class="z-50 font-nunito fixed inset-0 vs:px-2 ssm:px-2 vs:px-2 sm:px-2 flex justify-center items-center"
    >
      <div
        class="flex flex-col bg-white shadow rounded-xl h-auto w-550 ssm:w-full px-4 vs:w-full sm:w-full"
      >
        <div class="flex justify-between items-center py-4 flex-row">
          <button
            @click="showPreviousModal3"
            class="focus:outline-none text-sm font-bold leading-none text-right text-indigo-900"
          >
            Back
          </button>
          <p
            class="text-2xl ssm:text-sm se:text-base vs:text-lg font-bold leading-normal text-center text-gray-900"
          >
            Edit Shopping List
          </p>
          <button
            class="invisible text-sm font-bold leading-none text-right text-indigo-900"
          >
            Close</button
          ><!--invisible, used only for auto margin header. If design need close button just delete the invisible class-->
        </div>
        <hr class="w-full" />
        <div class="flex flex-col w-full space-y-2 py-4">
          <div class="flex flex-row items-center space-x-1 w-full">
            <input
              id="editTitle"
              type="text"
              v-model="selectedList.shoppingListTitle"
              class="w-46 text-gray-900 font-bold text-lg focus:outline-none"
              oninput='this.style.width = 0; this.style.width = this.scrollWidth + "px";'
            />
            <button
              @click="toggleInputField('editTitle')"
              class="focus:outline-none pl-1"
            >
              <span class="material-icons mt-1 md-18 text-gray-600">
                mode_edit
              </span>
            </button>
          </div>
          <div class="flex flex-row items-center space-x-3 select-none pl-3">
            <span
              @click="new_item = !new_item"
              class="cursor-pointer material-icons"
            >
              add_circle
            </span>
            <p class="">Add new item</p>
          </div>
          <div
            v-if="new_item"
            class="ring-1 ring-gray-400 p-5 space-y-3 rounded-xl"
          >
            <input
              id="product1"
              type="text"
              placeholder="Product"
              class="rounded-xl pl-5 w-full focus:outline-none h-10 bg-gray-100"
            />
            <div class="flex flex-row space-x-2">
              <input
                id="brand1"
                type="text"
                placeholder="Brand"
                class="rounded-xl pl-5 w-full focus:outline-none h-10 bg-gray-100"
              />
              <input
                id="size1"
                type="text"
                placeholder="Size"
                class="w-40 rounded-xl pl-5 focus:outline-none h-10 bg-gray-100"
              />
            </div>
            <div class="flex flex-row space-x-2">
              <p class="font-bold">Quantity</p>
              <span
                @click="quantity++"
                class="material-icons select-none cursor-pointer text-red-700"
              >
                add
              </span>
              <p id="quants">{{ quantity }}</p>
              <span
                @click="quantity = minusQty(quantity)"
                class="material-icons select-none cursor-pointer text-red-700"
              >
                remove
              </span>
            </div>
            <div class="flex justify-end">
              <div class="space-x-3">
                <button
                  @click="new_item = false"
                  class="ring-2 rounded-2xl h-6 w-20 font-bold ring-red-buttons focus:outline-none"
                >
                  Cancel
                </button>
                <button
                  @click="add_newItem()"
                  class="ring-2 rounded-2xl h-6 w-20 font-bold text-white ring-red-buttons focus:outline-none bg-red-buttons"
                >
                  Add
                </button>
              </div>
            </div>
          </div>
        </div>
        <div
          id="scroll1"
          class="flex flex-col py-1 px-2 vs:px-2 ssm:px-1 overflow-y-auto h-40 vs:h-36 ssm:space-y-1 vs:space-y-2 space-y-4 w-full"
        >
          <div
            class="flex flex-row w-full justify-between items-center space-x-3"
            v-for="item in selectedList.shoppingListContent"
            :key="item.id"
          >
            <div class="flex flex-row vs:space-x-2 ssm:space-x-1 space-x-4">
              <div
                class="itemButtons bg-white border-2 rounded-none w-4 h-4 flex flex-shrink-0 justify-center items-center mr-2 border-gray-900"
              >
                <input
                  type="checkbox"
                  class="opacity-0"
                  :checked="item.status === 1"
                  :id="'check' + item.id"
                />
                <img
                  src="img/check-mark.svg"
                  class="fill-current hidden w-3 h-3 text-black mr-3 font-bold pointer-events-none"
                />
              </div>
              <div class="flex flex-col space-y-2">
                <p
                  class="text-base ssm:text-sm se:text-sm leading-none text-gray-900"
                >
                  {{ item.product }} ({{ item.size }})
                </p>
                <p
                  class="text-base ssm:text-sm se:text-sm leading-none text-gray-900"
                >
                  {{ item.brand }}
                </p>
              </div>
            </div>
            <div class="flex flex-row space-x-2 items-center">
              <button class="focus:outline-none flex" @click="item.quantity++">
                <span class="material-icons bg-gray-100 text-red-700">
                  add
                </span>
              </button>
              <p
                class="text-base ssm:text-sm se:text-sm items-center flex leading-none text-gray-900"
              >
                {{ item.quantity }}
              </p>
              <button
                class="focus:outline-none flex"
                @click="item.quantity = minusQty(item.quantity)"
              >
                <span class="material-icons bg-gray-100 text-red-700">
                  remove
                </span>
              </button>
              <button class="focus:outline-none flex">
                <span class="material-icons"> more_vert </span>
              </button>
            </div>
          </div>
        </div>
        <div
          class="flex flex-row w-full justify-around vs:space-x-2 ssm:space-x-1 sm:space-x-4 items-center py-4"
        >
          <button
            @click="showPreviousModal3"
            class="focus:outline-none flex items-center justify-center w-56 h-full px-4 py-2 border-2 rounded-full border-red-700"
          >
            <p
              class="text-base ssm:text-sm se:text-sm font-bold leading-none text-gray-900"
            >
              Cancel
            </p>
          </button>
          <button
            @click="editShoppingList"
            class="focus:outline-none flex items-center justify-center w-56 h-full px-4 py-2.5 bg-red-700 rounded-full"
          >
            <p
              class="text-base ssm:text-sm se:text-sm font-bold leading-none text-white"
            >
              Save Changes
            </p>
          </button>
        </div>
      </div>
    </div>
  </transition>
  <!--end-->
</template>

<script>
import store from "../store/index";
// import VueSimpleAlert from "vue-simple-alert";
import $ from "jquery";
import api from "../api";
export default {
  props: ["activeList", "showList"],
  data() {
    return {
      listEdit: false,
      component: "shopOfferPost",
      component2: "orderRequestPost",
      isVisible: true,
      activeBtn: 0,
      hidden: false,
      showOfferPost: true,
      showOrderPost: false,
      showSelectShopListModal: false,
      showCreateNewShopListModal: false,
      showCreateShoppingOffer: false,
      showCreateOrderRequest: true,
      showShopListButton: !this.showList,
      showItemList: this.showList,
      selectedList: this.activeList,
      countItems: 8,
      ShoppingListTitle: "Weekly Grocery List",
      showEditShopListModal: false,
      Quantity: 1,
      postError: "",
      //Create Shop Offer Data
      addAddress: false,
      dropdown1: false,
      dropdown2: false,
      dropdown3: false,
      dropdown4: false,
      shoppingPlace: "",
      transport: "",
      payment: "Payment Method",
      Payments: ["Cash on Delivery", "Gcash", "PayMaya", "Online Banking"],
      caption: null,
      capacity: null,
      sched: null,
      deliveryArea: "Delivery Area",
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
      //end

      //Create Order Request Data
      isOpen: false,
      addAddress2: false,
      dropdown5: false,
      dropdown6: false,
      dropdown7: false,
      dropdown8: false,
      shoppingPlaceRequest: "",
      captionRequest: null,
      schedRequest: null,
      paymentRequest: "Payment Method",
      deliveryAddress: "Delivery Address",
      address1: "Banquerohan,Legazpi City",
      address2: "Buraguis Legazpi City",
      address3: "United State of Bicol",
      address4: "Maski Sain City",
      //end

      //ShopList Items temporary data
      filter_itemList: [
        {
          item: "Flour",
          amount: "1 kg",
          brand: "Any brand",
          unit: "2 units",
        },
        {
          item: "Flour",
          amount: "1 kg",
          brand: "Any brand",
          unit: "2 units",
        },
        {
          item: "Flour",
          amount: "1 kg",
          brand: "Any brand",
          unit: "2 units",
        },
        {
          item: "Flour",
          amount: "1 kg",
          brand: "Any brand",
          unit: "2 units",
        },
        {
          item: "Flour",
          amount: "1 kg",
          brand: "Any brand",
          unit: "2 units",
        },
        {
          item: "Flour",
          amount: "1 kg",
          brand: "Any brand",
          unit: "2 units",
        },
        {
          item: "Flour",
          amount: "1 kg",
          brand: "Any brand",
          unit: "2 units",
        },
        {
          item: "Flour",
          amount: "1 kg",
          brand: "Any brand",
          unit: "2 units",
        },
      ],
      limit_by: 3,
      default_limit: 3,
      showListStatus: "See More",
      showLessStatus: "See Less",
      new_item: false,
      new_items: [],
      quantity: 1,
      ctr: 0,
      oldList: [],
      edit2: null,
      edit3: false,
      editListFlag: false,
      mainModal: true,
      errorOffer: null,
      errorOrder: null,

      //end
    };
  },
  created() {
    console.log("fter", this.selectedList, this.showList);
  },
  methods: {
    saveList() {
      for (var i = 0; i < this.new_items.length; i++) {
        if (!document.getElementById("check" + this.new_items[i].id).checked) {
          //if true check the status
          this.new_items[i].status = 0;
        }
      }
      console.log(document.getElementById("createTitle").value,'title')
      let obj = {
        listName: document.getElementById("createTitle").value,
        list: this.new_items,
      };
      console.log(this.new_items);
      // this.shopping_list.push(obj);
      api
        .post("api/createList", obj)
        .then((res) => {
          store.dispatch("getUserShoppingList").then(() => {
            this.selectedList = res.data;
            this.new_items = [];
            this.showPreviousModal2()
          });
        })
        .catch(() => {
          //if encountered error means the user will not add a new shopping list
          this.new_items = [];
          
        });
    },
    postOffer() {
      if (this.deliveryArea == "Delivery Area") {
        this.postError = "Please Choose a Delivery Area";
      } else {
        var form = {
          postIdentity: "offer_post",
          postStatus: "Accepting Requests",
          deliveryArea: this.deliveryArea,
          shoppingPlace: this.shoppingPlace,
          deliverySchedule: this.sched,
          transportMode: this.transport,
          capacity: this.capacity,
          paymentMethod: this.payment,
          caption: this.caption,
        };
        console.log(form);

        api
          .post("api/post/offer", form)
          .then(() => {
            store.dispatch("getPosts").then(() => {
              store.dispatch("getShoppingPlaces");
              store.dispatch("getTransportModes");
              this.$emit("popUpPost");
              this.$emit("sortPosts");
              this.$emit("closeModal");
              this.errorOffer = "";
              this.postError = "";
            });
          })
          .catch((errors) => {
            console.log("errross", errors.response.data.errors);
            if (errors.response.data.errors.shoppingPlace == null)
              errors.response.data.errors.shoppingPlace = "";
            if (errors.response.data.errors.deliverySchedule == null)
              errors.response.data.errors.deliverySchedule = "";
            if (errors.response.data.errors.deliverArea == null)
              errors.response.data.errors.deliverArea = "";
            if (errors.response.data.errors.paymentMethod == null)
              errors.response.data.errors.paymentMethod = "";
            if (errors.response.data.errors.transportMode == null)
              errors.response.data.errors.transportMode = "";
            if (errors.response.data.errors.capacity == null)
              errors.response.data.errors.capacity = "";
            this.errorOffer =
              errors.response.data.errors.shoppingPlace +
              " " +
              errors.response.data.errors.deliverySchedule +
              " " +
              errors.response.data.errors.deliveryArea +
              " " +
              errors.response.data.errors.paymentMethod +
              " " +
              errors.response.data.errors.capacity +
              " " +
              errors.response.data.errors.transportMode;
            this.postError = "";

            //     this.deliveryAddress = "Delivery Address"
            // this.paymentRequest = "Payment Method";
          });
      }
    },
    postRequest() {
      if (this.deliveryAddress === "Delivery Address") {
        this.deliveryAddress = "";
      }
      if (this.paymentRequest === "Payment Method") {
        this.paymentRequest = "";
      }
      var form = {
        postIdentity: "request_post",
        postStatus: "Accepting Offer",
        deliveryAddress: this.deliveryAddress,
        shoppingPlace: this.shoppingPlaceRequest,
        deliverySchedule: this.schedRequest,
        paymentMethod: this.paymentRequest,
        caption: this.captionRequest,
        shoppingListTitle: this.selectedList.shoppingListTitle,
        shoppingListContent: this.selectedList.shoppingListContent,
      };

      console.log("request form", form);
      api
        .post("api/post/request", form)
        .then(() => {
          store.dispatch("getPosts").then(() => {
            store.dispatch("getShoppingPlaces");
            this.$emit("popUpPost");
            this.$emit("sortPosts");
            this.$emit("closeModal");
            this.errorOrder = "";
          });
        })
        .catch((errors) => {
          console.log("errross", errors.response.data.errors);
          if (errors.response.data.errors.shoppingPlace == null)
            errors.response.data.errors.shoppingPlace = "";
          if (errors.response.data.errors.deliverySchedule == null)
            errors.response.data.errors.deliverySchedule = "";
          if (errors.response.data.errors.deliveryAddress == null)
            errors.response.data.errors.deliveryAddress = "";
          if (errors.response.data.errors.paymentMethod == null)
            errors.response.data.errors.paymentMethod = "";
          this.errorOrder =
            errors.response.data.errors.shoppingPlace +
            " " +
            errors.response.data.errors.deliverySchedule +
            " " +
            errors.response.data.errors.deliveryAddress +
            " " +
            errors.response.data.errors.paymentMethod;

          this.deliveryAddress = "Delivery Address";
          this.paymentRequest = "Payment Method";
        });
    },
    editShoppingList() {
      for (var i = 0; i < this.selectedList.shoppingListContent.length; i++) {
        console.log(this.selectedList.shoppingListContent[i].id);
        console.log(
          !document.getElementById(
            "check" + this.selectedList.shoppingListContent[i].id
          ).checked
        );

        if (
          !document.getElementById(
            "check" + this.selectedList.shoppingListContent[i].id
          ).checked
        ) {
          //if true uncheck the status
          this.selectedList.shoppingListContent[i].status = 0;
        } else {
          this.selectedList.shoppingListContent[i].status = 1;
        }
      }
      console.log("asdadadadsw", this.selectedList);
      api
        .post("api/editList/" + this.selectedList.shoppingListNumber, {
          listName: this.selectedList.shoppingListTitle,
          list: this.selectedList.shoppingListContent,
        })
        .then(() => {
          store.dispatch("getUserShoppingList").then(() => {
            this.showEditShopListModal = !this.showEditShopListModal;
            this.mainModal = true;
            $(".hideIf").fadeIn();
          });
        })
        .catch(() => {
          console.log("error editing lsit");
        });
    },
    add_newItem() {
      let x = document.getElementById("product1").value;
      let y = document.getElementById("brand1").value;
      let z = document.getElementById("size1").value;
      let n = this.quantity;
      if (x == "") {
        alert("Empty Field");
        return false;
      } else {
        let datax = {
          id: this.ctr,
          product: x,
          brand: y,
          size: z,
          quantity: n,
          status: 1,
          statusDeliver: 0,
        };
        this.ctr++;
        this.selectedList.shoppingListContent.push(datax);
        // this.new_items.push(datax);
        this.new_item = false;
        console.log("new list", this.selectedList.shoppingListContent);
      }
    },
    add_newItem1() {
      let x = document.getElementById("product").value;
      let y = document.getElementById("brand").value;
      let z = document.getElementById("size").value;
      let n = this.quantity;
      if (x == "") {
        alert("Empty Field");
        return false;
      } else {
        let datax = {
          id: this.ctr,
          product: x,
          brand: y,
          size: z,
          quantity: n,
          status: 1,
          statusDeliver: 0,
        };
        this.ctr++;
        this.new_items.push(datax);
        // this.new_items.push(datax);
        this.new_item = false;
        console.log("new list", this.selectedList.shoppingListContent);
      }
    },
    minusQty(q) {
      q--;
      if (q <= 0) return 1;
      return q;
    },
    setShoppingPlaceRequest(index) {
      this.shoppingPlaceRequest = document.getElementById(
        "spR" + index
      ).innerHTML;
    },
    setPaymentRequest(index) {
      this.paymentRequest = document.getElementById("pmR" + index).innerHTML;
    },
    toggleShopOfferbtn() {
      this.showCreateShoppingOffer = true;
      this.showCreateOrderRequest = false;
    },
    toggleOrderRequestbtn() {
      this.showCreateShoppingOffer = false;
      this.showCreateOrderRequest = true;
    },
    close() {
      this.$emit("closeModal");
    },
    isActive_function(el) {
      if (el == "btn1") {
        this.activeBtn = 0;
      } else {
        this.activeBtn = el;
      }
    },
    hidePrevious() {
      this.showSelectShopListModal = !this.showSelectShopListModal;
      $(".hideIf").fadeOut();
      this.listEdit = false;
    },
    showPreviousModal1() {
      this.showSelectShopListModal = false;
      $(".hideIf").fadeIn();
    },
    createNewShopList() {
      $(".hideIf2").fadeOut();
      this.showCreateNewShopListModal = !this.showCreateNewShopListModal;
    },
    showPreviousModal2() {
      this.showCreateNewShopListModal = !this.showCreateNewShopListModal;
      // this.showCreateNewShopListModal = !this.showCreateNewShopListModal;
      $(".hideIf2").fadeIn();
      console.log("exiting", this.selectedList);
    },
    confirmShopList() {
      this.showShopListButton = false;
      var tempList = this.shoppingLists;
      for (var i = 0; i < tempList.length; i++) {
        if (
          document.getElementById("listNumber" + tempList[i].shoppingListNumber)
            .checked
        ) {
          this.selectedList = tempList[i];
          //  this.selectedList.shoppingListContent = filtered_list
        }
      }
      console.log("selected List", this.selectedList);
      this.showItemList = true;
      this.showSelectShopListModal = !this.showSelectShopListModal;
      $(".hideIf").fadeIn();
    },
    editShopListAtSelectShopList() {
      this.showShopListButton = false;
      this.showItemList = true;
      var tempList = this.shoppingLists;
      var temp;
      console.log("selected List before 0 or 1", this.selectedList);
      console.log(this.selectedList == null, "asldfalsdfl");
      if (this.selectedList == null) {
        temp = tempList.filter((x) => {
          return x.shoppingListNumber === this.edit2;
        });
        this.selectedList = temp[0];
        console.log("selected List on 0", this.selectedList);
        this.showSelectShopListModal = !this.showSelectShopListModal;
        this.showEditShopListModal = !this.showEditShopListModal;
        this.mainModal = !this.mainModal;
        this.ctr = this.selectedList.shoppingListContent.id + 1;
        this.oldList = [];
        $(".hideIf").fadeIn();
      } else {
        temp = tempList.filter((x) => {
          return x.shoppingListNumber === this.edit2;
        });
        this.selectedList = temp[0];
        console.log("selected List on > 0", this.selectedList);
        this.showSelectShopListModal = !this.showSelectShopListModal;
        this.showEditShopListModal = !this.showEditShopListModal;
        this.mainModal = !this.mainModal;
        this.ctr = this.selectedList.shoppingListContent.id + 1;
        this.oldList = JSON.parse(JSON.stringify(this.selectedList));
        $(".hideIf").fadeIn();
      }
    },
    showPreviousModal3() {
      this.showEditShopListModal = !this.showEditShopListModal;
      if (this.selectedList.length <= 0) {
        this.showShopListButton = true;
        this.showItemList = false;
      }
      $(".hideIf").fadeIn();
      console.log("exiting selected", this.selectedList);
      this.selectedList = this.oldList;
      console.log("exiting active", this.selectedList);
      this.mainModal = true;
      this.edit2 = false;
    },
    editShopList() {
      $(".hideIf").fadeOut();
      this.showEditShopListModal = !this.showEditShopListModal;
      this.ctr = this.selectedList.shoppingListContent.id + 1;
      this.oldList = JSON.parse(JSON.stringify(this.selectedList));
    },
    showMoreshowLess() {
      this.isActive = !this.isActive;
      this.limit_by = null;
      if (this.showListStatus != this.showLessStatus) {
        this.showListStatus = this.showLessStatus;
      } else {
        this.showListStatus = "See More";
        this.limit_by = this.default_limit;
      }
    },
    toggleInputField(id) {
      var textbox = document.getElementById(id);

      if (textbox.disabled) {
        // If disabled, do this
        document.getElementById(id).disabled = false;
      } else {
        // Enter code here
        document.getElementById(id).disabled = true;
      }
    },

    //Create Shopping Offer methods
    openAddModal() {
      this.addAddress = !this.addAddress;
    },
    getHomeAddressValue() {
      this.deliveryAddress = document.getElementById("homeAdd").innerHTML;
      console.log(document.getElementById("homeAdd").innerHTML);
    },
    getShipAddressValue(index) {
      this.deliveryAddress = document.getElementById(
        "shipAdd" + index
      ).innerHTML;
      console.log(document.getElementById("shipAdd" + index).innerHTML);
    },

    // getAddressValue() {
    //   this.deliveryAddress = this.address1;
    // },

    myFunction() {
      var input, filter, ul, li, a, i, txtValue;
      input = document.getElementById("myInput");
      filter = input.value.toUpperCase();
      ul = document.getElementById("myUL");
      li = ul.getElementsByTagName("li");
      for (i = 0; i < li.length; i++) {
        a = li[i].getElementsByTagName("a")[0];
        txtValue = a.textContent || a.innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
          li[i].style.display = "";
        } else {
          li[i].style.display = "none";
        }
      }
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
    setTransportMode(index) {
      this.transport = document.getElementById("tm" + index).innerHTML;
    },
    setShoppingPlace(index) {
      this.shoppingPlace = document.getElementById("sp" + index).innerHTML;
    },
    setPayment(index) {
      this.payment = document.getElementById("pm" + index).innerHTML;
    },

    dropdown1modal() {
      this.dropdown1 = !this.dropdown1;
      this.dropdown2 = false;
      this.dropdown3 = false;
      this.dropdown4 = false;
    },
    dropdown2modal() {
      this.dropdown1 = false;
      this.dropdown2 = !this.dropdown2;
      this.dropdown3 = false;
      this.dropdown4 = false;
    },
    dropdown3modal() {
      this.dropdown1 = false;
      this.dropdown2 = false;
      this.dropdown3 = !this.dropdown3;
      this.dropdown4 = false;
    },
    dropdown4modal() {
      this.dropdown1 = false;
      this.dropdown2 = false;
      this.dropdown3 = false;
      this.dropdown4 = !this.dropdown4;
    },
    //end

    //Create Order Request methods
    openAddModal1() {
      this.addAddress = !this.addAddress;
    },

    // getAddressValue1() {
    //   this.deliveryAddress = this.address1;
    // },

    myFunction1() {
      var input, filter, ul, li, a, i, txtValue;
      input = document.getElementById("myInput");
      filter = input.value.toUpperCase();
      ul = document.getElementById("myUL");
      li = ul.getElementsByTagName("li");
      for (i = 0; i < li.length; i++) {
        a = li[i].getElementsByTagName("a")[0];
        txtValue = a.textContent || a.innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
          li[i].style.display = "";
        } else {
          li[i].style.display = "none";
        }
      }
    },

    dropdown5modal() {
      this.dropdown5 = !this.dropdown5;
      this.dropdown6 = false;
      this.dropdown7 = false;
      this.dropdown8 = false;
    },
    dropdown6modal() {
      this.dropdown5 = false;
      this.dropdown6 = !this.dropdown6;
      this.dropdown7 = false;
      this.dropdown8 = false;
    },
    dropdown7modal() {
      this.dropdown5 = false;
      this.dropdown6 = false;
      this.dropdown7 = !this.dropdown8;
      this.dropdown8 = false;
    },
    dropdown8modal() {
      this.dropdown5 = false;
      this.dropdown6 = false;
      this.dropdown7 = false;
      this.dropdown8 = !this.dropdown8;
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

      this.deliveryArea =
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
    isFew() {
      var temp = this.selectedList.shoppingListContent;
      var temp1 = temp.filter((x) => {
        return x.status == 1;
      });
      return temp1.length;
    },
    //end
  },
  mounted() {
    api
      .get("/api/refProvince")
      .then((res) => {
        this.refProvince = res.data;
      })
      .catch((error) => {
        console.log(error);
      });
  },
  computed: {
    computedShopItemList() {
      var temp = this.selectedList.shoppingListContent.filter((x) => {
        return x.status == 1;
      });
      return this.limit_by ? temp.slice(0, this.limit_by) : temp;
    },
    user() {
      console.log("user personal", store.getters.getPersonal);
      return store.getters.getPersonal;
    },
    userPersonal() {
      return store.getters.getPersonal;
    },
    userHomeAddress() {
      return store.getters.getAddress;
    },
    userShippingAddress() {
      return store.getters.getUserShippingAddress;
    },
    transportModes() {
      return store.getters.getTransportModes;
    },
    shoppingPlaces() {
      return store.getters.getShoppingPlaces;
    },
    shoppingLists() {
      return store.getters.getUserShoppingList;
    },
  },
};
</script>


<style scoped>
.fadeSlide-enter-from {
  transform: translateX(100%);
  transform: translateX(150px);
  opacity: 0;
}
.fadeSlide-enter-to {
  transform: translateX(0);
  opacity: 1;
}
.fadeSlide-enter-active {
  transition: all 0.3s ease-in-out;
}

.fadeSlide-leave-from {
  transform: translateX(0);
  opacity: 1;
}
.fadeSlide-leave-to {
  transform: translateX(100%);
  transform: translateX(150px);
  opacity: 0;
}
.fadeSlide-leave-active {
  transition: all 0.3s ease-in-out;
}
.fadeSlide2-enter-from {
  transform: translate(-30%, -50%) !important;
  -webkit-transform: translate(-30%, -50%) !important;
  opacity: 0;
}
.fadeSlide2-enter-to {
  transform: translate(-50%, -50%) !important;
  -webkit-transform: translate(-50%, -50%) !important;
  opacity: 1;
}
.fadeSlide2-enter-active {
  transition: all 0.3s ease-in-out;
}

.fadeSlide2-leave-from {
  transform: translate(-50%, -50%) !important;
  -webkit-transform: translate(-50%, -50%) !important;
  opacity: 1;
}
.fadeSlide2-leave-to {
  transform: translate(-30%, -50%) !important;
  -webkit-transform: translate(-30%, -50%) !important;
  opacity: 0;
}
.fadeSlide2-leave-active {
  transition: all 0.3s ease-in-out;
}
.uncheckedMe {
  display: none;
}

#txt {
  min-width: 50px !important;
  max-width: 99.99% !important;
  transition: width 0.25s;
  text-align: start;
}

.modal-body {
  max-height: 100vh;
  overflow-y: auto;
}

.active {
  color: red;
  border-bottom: solid red 5px;
}
.active button {
  color: red;
}
#scroll1::-webkit-scrollbar-track {
  border-radius: none;
}
#scroll1::-webkit-scrollbar {
  width: 6px;
}
#scroll1::-webkit-scrollbar-thumb {
  border-radius: 10px;
  background-color: grey;
}
#button1 {
  padding: 0;
  margin: 0;
}

#postMessge::-webkit-scrollbar-track {
  border-radius: none;
}
#postMessage::-webkit-scrollbar {
  width: 6px;
}
#postMessage::-webkit-scrollbar-thumb {
  border-radius: 10px;
  background-color: grey;
}

textarea {
  resize: none;
}

/*Create Shopping Offer CSS */
#myUL {
  list-style-type: none;
  padding: 0;
  margin: 0;
}

#myUL li a {
  margin-top: -1px; /* Prevent double borders */
  text-decoration: none;
  color: black;
  display: block;
}

#myUL li a:hover:not(.header) {
  background-color: #eee;
}

#myInput {
  background-position: 8px 4px;
  background-repeat: no-repeat;
  background-size: 24px;
  width: 100%;
  padding: 4px 0px 4px 35px;
  border: 1px solid #ddd;
  margin-bottom: 6px;
}
/*end */

#myUL1 {
  list-style-type: none;
  padding: 0;
  margin: 0;
}

#myUL1 li a {
  margin-top: -1px; /* Prevent double borders */
  text-decoration: none;
  color: black;
  display: block;
}

#myUL1 li a:hover:not(.header) {
  background-color: #eee;
}

#myInput1 {
  background-position: 8px 4px;
  background-repeat: no-repeat;
  background-size: 24px;
  width: 100%;
  padding: 4px 0px 4px 35px;
  border: 1px solid #ddd;
  margin-bottom: 6px;
}
/*end */

.itemButtons input:checked + img {
  display: block;
}

#createTitle {
  font-weight: bold;
  font-size: 1.125rem;
  line-height: 1.75rem;
  --tw-text-opacity: 1;
  color: rgba(17, 24, 39, var(--tw-text-opacity));
}

#createTitle::placeholder {
  font-weight: bold;
  font-size: 1.125rem;
  line-height: 1.75rem;
  --tw-text-opacity: 1;
  color: rgba(17, 24, 39, var(--tw-text-opacity));
}

#editTitle::placeholder {
  font-weight: bold;
  font-size: 1.125rem;
  line-height: 1.75rem;
  --tw-text-opacity: 1;
  color: rgba(17, 24, 39, var(--tw-text-opacity));
}

::placeholder {
  /* Chrome, Firefox, Opera, Safari 10.1+ */
  --tw-text-opacity: 1;
  color: rgba(107, 114, 128, var(--tw-text-opacity));
}
</style>