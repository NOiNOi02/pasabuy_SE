<template class="bg-gray-bgcolor">
  <Navbar />
  <div
    class="flex flex-wrap pt-4 pb-24 overflow-hidden lg:h-screen xl:h-screen llg:justify-center llg:px-10 mv:pt-5 vs:pt-9 bg-gray-bgcolor vs:flex-col sm:flex-col font-nunito md:flex-col"
  >
    <div
      class="flex w-3/5 xl:h-screen 2xl:h-screen lg:h-screen xl:overflow-hidden lg:overflow-hidden 2xl:overflow-hidden llg:w-65 vs:w-full xsm:w-full sm:w-full md:w-full ssm:w-full"
    >
      <div
        class="pt-4 xl:overflow-y-scroll lg:overflow-y-scroll 2xl:overflow-y-scroll bg-gray-bgcolor mv:pt-1 font-nunito rounded-xl llg:pl-5"
      >
        <div
          class="w-full min-w-0 px-2 ssm:h-auto ssm:pb-6 vs:h-auto vs:pb-6 sm:pb-6 rounded-xl"
        >
          <!--Modal-->
          <PostModal
            v-if="postModalVisible"
            @closeModal="listener"
            @popUpPost="popUpPost = !popUpPost"
            @sortPosts="sortPosts"
            :activeList="selectedList"
            :showList="showItemList"
          />
          <!--end-->

          <div class="flex items-center justify-center pt-16 dv:float-right">
            <div
              class="inline-flex items-center justify-center p-6 space-x-4 bg-white shadow w-608 rounded-xl ssm:space-x-2 vs:w-full sm:w-full ssm:w-full ssm:p-2 vs:p-4 rounded-x md:w-full"
            >
              <img
                class="rounded-full w-14 h-14 vs:w-10 vs:h-10 ssm:w-10 ssm:h-10"
                :src="userPersonal.profilePicture"
              />
              <button
                @click="togglePostModal"
                :disabled="!ifUserVerified(user.email)"
                class="flex items-center justify-start py-5 pl-6 text-base leading-none text-gray-500 bg-gray-100 rounded-full outline-none md:w-full focus:outline-none lvs:text-sm vs:text-xs ssm:text-xs vs:h-12 ssm:h-10 h-14 w-448 vs:w-full ssm:w-full x-v:text-sm"
              >
                <span v-if="ifUserVerified(user.email)"
                  >Post a Shopping Offer or an Order Request</span
                >
                <span v-else>Get verified to unlock this feature</span>
              </button>
            </div>
          </div>
          <!--end-->

          <!--FILTER--->
          <div
            class="relative flex items-center justify-center pt-6 ssm:justify-around x-v:pt-2 dv:float-right"
          >
            <div
              class="justify-center h-auto bg-transparent ssm:px-0 dv:space-x-4 mv:w-full ssm:p-2 ssm:w-full dv:w-608 rounded-xl"
            >
              <div
                class="flex items-start justify-start dv:flex-wrap ssm:space-x-0 ssm:space-y-2 ssm:flex-col ssm:justify-start"
              >
                <button
                  type="button"
                  class="mr-4 vs:mr-2 inline-flex ssm:float-left 2xl:w-50 ssm:px-0 justify-around px-3 py-1.5 text-sm font-bold text-black align-bottom bg-white vsv:text-xs vs:text-xs ssm:text-xs font-nunito border border-gray-300 rounded-full shadow-sm w-44 sm:w-full mv-filterbutton1 hover:bg-gray-50 focus:outline-none"
                  id="options-menu x-v:text-sm"
                  @click="filter = !filter"
                >
                  <span
                    class="pr-1 mt-0.5 ssm:pr-0 x-v:mt-0 align-bottom material-icons-round md-24 vsv:pr-0.5"
                  >
                    {{ filter1Logo }}
                  </span>
                  <label
                    for=""
                    class="pt-1 vs:py-1 se:py-1.5 cursor-pointer se:text-xs x-v:text-sm"
                  >
                    {{ filter1Value }}</label
                  >
                  <span
                    class="pt-1 x-v:pt-0.5 ssm:pl-0 vsv:pl-1 pl-2 text-gray-500 align-middle md-24 material-icons"
                  >
                    arrow_drop_down
                  </span>
                </button>
                <!---------OPTIONS----------->
                <div
                  class="absolute z-20 font-bold origin-top-right bg-white rounded-lg shadow-lg top-15 w-44 focus:outline-none x-v:leading-tight"
                  role="menu"
                  aria-orientation="vertical"
                  aria-labelledby="options-menu"
                >
                  <div class="py-1" role="none" v-if="filter">
                    <a
                      href="#"
                      class="block px-4 py-2 text-xs font-light tracking-wider text-gray-500 font-raleway"
                      aria-disabled
                      role="menuitem"
                    >
                      <label for=""> POST TYPE</label>
                    </a>
                    <a
                      @click="
                        (filter = !filter),
                          (filter1Value = 'All Posts'),
                          (filter1Logo = 'view_stream'),
                          changeFilter()
                      "
                      href="#"
                      class="block px-4 py-2 text-sm text-gray-900"
                      role="menuitem"
                    >
                      <span
                        class="pr-3 x-v:mt-0 mt-0.5 align-bottom material-icons-round text-gray-600"
                      >
                        view_stream
                      </span>
                      <label for="" class="cursor-pointer"> All Posts</label>
                    </a>
                    <a
                      @click="
                        (filter = !filter),
                          (filter1Value = 'Shopping Offer'),
                          (filter1Logo = 'delivery_dining'),
                          changeFilter()
                      "
                      href="#"
                      class="block px-4 py-2 text-sm text-gray-900"
                      role="menuitem"
                    >
                      <span
                        class="pr-3 mt-0.5 align-bottom material-icons text-gray-600"
                      >
                        delivery_dining </span
                      >Shopping Offer</a
                    >
                    <a
                      @click="
                        (filter = !filter),
                          (filter1Value = 'Order Requests'),
                          (filter1Logo = 'shopping_bag'),
                          changeFilter()
                      "
                      href="#"
                      class="block px-4 py-2 text-sm hover:text-gray-900"
                      role="menuitem"
                    >
                      <span
                        class="pr-3 mt-0.5 align-bottom material-icons text-gray-600"
                      >
                        shopping_bag </span
                      >Order Requests</a
                    >
                  </div>
                </div>
                <!---------END OF OPTIONS---------->

                <button
                  type="button"
                  class="2xl:w-64 inline-flex px-3 vs:px-0 sm:px-0 mv:right-0 mv:float-right justify-around w-48 lvs:w-48 sm:w-full py-1.5 text-sm font-bold text-black bg-white s-sm:float-right border-gray-300 vs:w-56 mv-filterbutton1 rounded-full vs:ml-0 shadow-sm align-bottom x-v:text-sm hover:bg-gray-50 vvs:px-0 vvs:w-44 focus:outline-none vsv:text-xs"
                  id="options-menu x-v:text-sm"
                  @click="filter2 = !filter2"
                >
                  <span
                    class="pt-1 pr-2 lvs:pr-1 se:pt-0.5 se:pl-1 se:pr-0 vs:pl-2 align-middle vvs:pr-1 material-icons x-v:pt-0"
                  >
                    {{ filter2Logo }}
                  </span>
                  <label
                    for=""
                    class="pt-1 cursor-pointer vs:py-1 se:text-xs vs:text-sm"
                  >
                    {{ filter2Value }}</label
                  >
                  <span
                    class="pt-1 pl-2 vs:pl-0 se:pt-0.5 x-v:pt-0.5 text-gray-500 align-middle vvs:pl-1 md-24 x-v:md-18 material-icons"
                  >
                    arrow_drop_down
                  </span>
                </button>

                <!---------OPTIONS----------->
                <div
                  class="absolute z-20 font-bold origin-top-right bg-white rounded-lg shadow-lg ssm:float-left ssm:right-0 ssm:left-0 right-60 lvs:left-48 w-44 top-15 ssm:top-266 2xl:left-58 2xl:w-60 focus:outline-none mv:right-2"
                  role="menu"
                  aria-orientation="vertical"
                  aria-labelledby="options-menu"
                >
                  <div class="py-1" role="none" v-if="filter2">
                    <a
                      href="#"
                      class="block px-4 py-2 text-xs font-light tracking-wider text-gray-500 font-raleway"
                      aria-disabled
                      role="menuitem"
                    >
                      <label for=""> POST FROM</label>
                    </a>
                    <a
                      @click="
                        (filter2 = !filter2),
                          (filter2Value = 'Following Only'),
                          (filter2Logo = 'people_alt'),
                          changeFilter()
                      "
                      href="#"
                      class="block px-4 py-2 text-sm text-gray-600"
                      role="menuitem"
                      ><span class="pr-2 align-bottom material-icons">
                        people_alt
                      </span>
                      <label for="" class="pt-1 text-gray-900 cursor-pointer">
                        Following Only</label
                      ></a
                    >
                    <a
                      @click="
                        (filter2 = !filter2),
                          (filter2Value = 'Nearby'),
                          (filter2Logo = 'near_me'),
                          changeFilter()
                      "
                      href="#"
                      class="block px-4 py-2 text-sm text-gray-600"
                      role="menuitem"
                      ><span class="pr-2 align-bottom material-icons">
                        near_me
                      </span>
                      <label for="" class="pt-1 text-gray-900 cursor-pointer">
                        Nearby</label
                      ></a
                    >
                  </div>
                </div>
                <!---------END OF OPTIONS---------->
              </div>
            </div>
          </div>

          <!--user post-->
          <div v-for="(post_info, index) in sortedAllPosts" :key="index">
            <div v-if="post_info.indexShare == null">
              <div
                id="shopOffer-UserPost"
                class="flex items-center justify-center pt-6 x-v:pt-2 dv:float-right"
              >
                <div
                  id="changeBoxRadius"
                  class="h-auto p-6 space-x-4 bg-white shadow vs:p-4 mv:w-full ssm:p-2 ssm:w-full vs:w-full sm:w-full w-608 rounded-xl"
                >
                  <div class="flex flex-col items-start justify-start">
                    <!--section 1-->
                    <div class="flex flex-row justify-between flex-grow w-full">
                      <div class="inline-flex">
                        <img
                          class="rounded-full x-v:absolute w-14 h-14 vs:w-10 vs:h-10 ssm:w-10 ssm:h-10"
                          :src="post_info.user.profilePicture"
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
                              <button
                                class="font-bold"
                                @click="setDispatches(post_info.user.email)"
                              >
                                {{ post_info.user.firstName }}
                                {{ post_info.user.lastName }}
                              </button>
                              <span
                                v-if="ifUserVerified(post_info.user.email)"
                                class="pl-1 inline-block text-blue-900 align-middle material-icons-round md-18"
                              >
                                verified
                              </span>
                              <label
                                v-if="post_info.offer_post != null"
                                class="pl-1 font-normal text-gray-500 align-top vs:font-light"
                                >posted a shopping offer</label
                              >
                              <label
                                v-if="post_info.request_post != null"
                                class="pl-1 font-normal text-gray-500 align-top vs:font-light"
                                >posted an order request</label
                              >
                            </h5>
                          </div>
                          <div
                            class="vs:flex vs:w-full ssm:w-full ssm:flex vs:pb-2 x-v:ml-10"
                          >
                            <span
                              class="text-sm leading-none text-gray-500 ssm:text-xs vs:text-xs lvs:text-sm"
                              >{{ timestamp(post_info.dateCreated) }}</span
                            >
                          </div>
                        </div>
                      </div>
                      <div
                        id="3dotmenu"
                        class="vs:mt-1 relative"
                        v-if="
                          post_info.email == user.email &&
                          post_info.offer_post != null
                        "
                      >
                        <button
                          @click="
                            edit1 = !edit1;
                            edit2 = post_info.postNumber;
                          "
                          class="focus:outline-none"
                        >
                          <img
                            class="w-6 h-auto vs:w-4 lvs:w-5 ssm:w-4"
                            src="img/3dot.svg"
                          />
                        </button>

                        <div class="flex w-full">
                          <div
                            v-if="edit1 && edit2 == post_info.postNumber"
                            class="absolute py-2 pt-2 pl-2 pr-4 leading-loose bg-white rounded-lg shadow-xl ssm:right-5 vs:right-5 sm:right-5 lg:right-0 md:right-5 xl:right-0 h-min w-40"
                          >
                            <EditShoppingOfferPostVue
                              v-if="postModalVisible1"
                              @closeModal1="listener1"
                              :btnText="post_info"
                              @getSortPosts="sortPosts"
                            />

                            <button
                              @click="togglePostModal1"
                              class="flex flex-row text-base vs:text-sm gap-x-2 focus:outline-none"
                            >
                              <span
                                class="font-medium text-gray-500 material-icons vs:md-14"
                              >
                                mode
                              </span>
                              Edit post
                            </button>

                            <UpdateOfferStatus
                              v-if="postModalVisible2"
                              @closeModal2="listener2"
                              :post="post_info"
                              @getSortPosts="sortPosts"
                            />

                            <button
                              @click="togglePostModal2"
                              class="flex flex-row text-base font-normal vs:text-sm focus:outline-none gap-x-2"
                            >
                              <span
                                class="font-normal text-gray-500 material-icons vs:md-14"
                              >
                                autorenew
                              </span>
                              Update Status
                            </button>

                            <button
                              @click="deletePost(post_info.postNumber)"
                              class="flex flex-row text-base gap-x-2 vs:text-sm vs:md-14"
                            >
                              <span class="text-gray-500 material-icons"
                                >delete</span
                              >Delete
                            </button>
                          </div>
                        </div>
                      </div>
                      <div
                        id="3dotmenu"
                        class="vs:mt-1 relative"
                        v-if="
                          post_info.email == user.email &&
                          post_info.request_post != null
                        "
                      >
                        <button
                          @click="
                            edit1 = !edit1;
                            edit2 = post_info.postNumber;
                          "
                          class="focus:outline-none"
                        >
                          <img
                            class="w-6 h-auto vs:w-4 lvs:w-5 ssm:w-4"
                            src="img/3dot.svg"
                          />
                        </button>
                        <div class="flex w-full">
                          <div
                            v-if="edit1 && edit2 == post_info.postNumber"
                            class="absolute py-2 pt-2 pl-2 pr-4 leading-loose bg-white rounded-lg shadow-xl ssm:right-5 vs:right-5 sm:right-5 lg:right-0 md:right-5 xl:right-0 h-min w-40"
                          >
                            <span
                              v-if="
                                post_info.request_post.shoppingListContent !=
                                null
                              "
                              hidden
                              >{{
                                (ctrProp =
                                  post_info.request_post.shoppingListContent[
                                    post_info.request_post.shoppingListContent
                                      .length - 1
                                  ].id + 1)
                              }}</span
                            ><span hidden>{{ (ctrProp = 1) }}</span>
                            <EditOrderRequest
                              v-if="postModalVisible1"
                              @closeModal1="listener1"
                              :post="post_info"
                              :ctrProp="ctrProp"
                              @getSortPosts="sortPosts"
                            />
                            <button
                              @click="togglePostModal1"
                              class="flex flex-row text-base vs:text-sm gap-x-2 focus:outline-none"
                            >
                              <span
                                class="font-medium text-gray-500 material-icons vs:md-14"
                              >
                                mode
                              </span>
                              Edit post
                            </button>
                            <UpdateOrderStatus
                              v-if="postModalVisible3"
                              @closeModal3="
                                postModalVisible3 = !postModalVisible3
                              "
                              :post="post_info"
                              @getSortPosts="sortPosts"
                            />
                            <button
                              @click="
                                postModalVisible3 = !postModalVisible3;
                                edit1 != edit1;
                              "
                              class="flex flex-row text-base font-normal vs:text-sm focus:outline-none gap-x-2"
                            >
                              <span
                                class="font-normal text-gray-500 material-icons vs:md-14"
                              >
                                autorenew
                              </span>
                              Update Status
                            </button>
                            <button
                              @click="deletePost(post_info.postNumber)"
                              class="flex flex-row text-base gap-x-2 vs:text-sm vs:md-14"
                            >
                              <span class="text-gray-500 material-icons"
                                >delete</span
                              >Delete
                            </button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!--end-->

                    <!--section 2-->
                    <div
                      class="inline-flex mt-4 items-center space-x-2 justify-start px-2 py-1 bg-gray-100 rounded-full text-green-600"
                      v-if="
                        post_info.postStatus != 'Accepting Requests' &&
                        post_info.postStatus != 'Accepting Offer'
                      "
                    >
                      <span class="rounded-full material-icons text-red-600">
                        remove_circle_outline
                      </span>
                      <p
                        class="text-sm vs:text-xs ssm:text-xs lvs:text-sm font-bold leading-none items-center text-red-600"
                      >
                        {{ post_info.postStatus }}
                      </p>
                    </div>

                    <div
                      class="inline-flex mt-4 items-center space-x-2 justify-start px-2 py-1 bg-gray-100 rounded-full text-green-600"
                      v-if="
                        post_info.postStatus === 'Accepting Requests' ||
                        post_info.postStatus === 'Accepting Offer'
                      "
                    >
                      <span class="rounded-full material-icons">
                        check_circle_outline
                      </span>
                      <p
                        class="text-sm vs:text-xs ssm:text-xs lvs:text-sm font-bold leading-none items-center"
                      >
                        {{ post_info.postStatus }}
                      </p>
                    </div>
                    <!--end-->

                    <!--section 3-->
                    <div
                      class="flex items-center justify-start w-full mt-4 space-x-4 ssm:flex-col ssm:items-start ssm:space-x-0 vs:flex-col vs:items-start vs:space-x-0"
                      v-if="post_info.offer_post != null"
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
                            {{ post_info.offer_post.deliveryArea }}
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
                            {{
                              timestampSched(
                                post_info.offer_post.deliverySchedule
                              )
                            }}
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
                            {{ post_info.offer_post.capacity }}
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
                            {{ post_info.offer_post.shoppingPlace }}
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
                            {{ post_info.offer_post.transportMode }}
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
                            {{ post_info.offer_post.paymentMethod }}
                          </p>
                        </div>
                      </div>
                    </div>
                    <!--end-->
                    <!--section 3 for request post-->
                    <div
                      v-if="post_info.request_post != null"
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
                            {{ post_info.request_post.deliveryAddress }}
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
                            {{
                              timestampSched(
                                post_info.request_post.deliverySchedule
                              )
                            }}
                          </p>
                        </div>
                      </div>
                      <div class="flex-col w-full">
                        <div class="flex space-x-2">
                          <span
                            class="w-6 h-6 text-red-600 rounded-full material-icons"
                          >
                            shopping_cart
                          </span>
                          <p
                            class="py-1 text-sm leading-none text-gray-900 ssm:text-xs vs:text-xs lvs:text-sm"
                          >
                            {{ post_info.request_post.shoppingPlace }}
                          </p>
                        </div>
                        <div class="flex py-2 space-x-2">
                          <span
                            class="w-6 h-6 text-red-600 rounded-full material-icons"
                          >
                            payments
                          </span>
                          <p
                            class="py-1 text-sm leading-none text-gray-900 ssm:text-xs vs:text-xs lvs:text-sm"
                          >
                            {{ post_info.request_post.paymentMethod }}
                          </p>
                        </div>
                      </div>
                    </div>
                    <!--end-->

                    <!--section 4-->
                    <div
                      class="flex flex-col ssm:mt-2 vs:mt-2 mt-3 w-full items-start justify-start h-auto vs:pr-0 vs:min-w-0 vs:px-2 ssm:pr-0 ssm:min-w-0 ssm:px-2 p-4 bg-gray-100 rounded-xl"
                      v-if="
                        post_info.request_post != null &&
                        post_info.request_post.shoppingListContent != null
                      "
                    >
                      <div class="flex-col items-start w-full">
                        <span
                          class="pb-2 pl-2 text-sm font-bold vs:text-sm sm:text-sm sm:font-bold"
                          >Shopping List
                          <label class="font-normal text-gray-500"
                            >{{
                              computedShopItemList(
                                post_info.request_post.shoppingListContent
                              ).length
                            }}
                            items</label
                          >
                        </span>
                        <ul
                          id="shop-list"
                          class="pl-4 leading-loose list-disc list-inside"
                        >
                          <li
                            v-for="(
                              shoppingList, index
                            ) in computedShopItemList(
                              post_info.request_post.shoppingListContent
                            )"
                            :key="index"
                            class="text-xl"
                          >
                            <span class="text-sm"
                              >{{ shoppingList.product }} ·
                              {{ shoppingList.brand }} [{{
                                shoppingList.quantity
                              }}
                              units]</span
                            >
                          </li>
                        </ul>
                      </div>
                      <button
                        @click="showMoreshowLess"
                        v-if="isFew(post_info.request_post.shoppingListContent)"
                        class="focus:outline-none items-start justify-start text-sm text-gray-500"
                      >
                        {{ showListStatus }}
                      </button>
                    </div>
                    <div
                      class="flex items-start justify-start flex-grow-0 w-full p-4 mt-4 bg-gray-100 ssm:mt-2 vs:mt-2 rounded-xl"
                      v-if="
                        post_info.offer_post != null &&
                        post_info.offer_post.caption != null
                      "
                    >
                      <p
                        class="w-full h-auto text-sm leading-loose text-gray-900 ssm:text-xs vs:text-xs lvs:text-sm vs:min-w-0 vs:px-2"
                      >
                        {{ post_info.offer_post.caption }}
                      </p>
                    </div>
                    <div
                      class="flex items-start justify-start flex-grow-0 w-full p-4 mt-4 bg-gray-100 ssm:mt-2 vs:mt-2 rounded-xl"
                      v-if="
                        post_info.request_post != null &&
                        post_info.request_post.caption != null
                      "
                    >
                      <p
                        class="w-full h-auto text-sm leading-loose text-gray-900 ssm:text-xs vs:text-xs lvs:text-sm vs:min-w-0 vs:px-2"
                      >
                        {{ post_info.request_post.caption }}
                      </p>
                    </div>
                    <!--section 4-->

                    <!--section 5-->
                    <div
                      class="relative flex w-full pr-8 mt-4 space-x-6 justify-evenly vs:space-x-3 vs:min-w-0 vs:px-2 ssm:space-x-1 ssm:px-0 ssm:pr-0 vs:pr-0"
                    >
                      <div
                        v-if="
                          post_info.email != user.email &&
                          post_info.offer_post != null
                        "
                      >
                        <SendRequest
                          v-if="
                            postSendModal &&
                            sendOfferOrRequestpostNum ==
                              post_info.offer_post.postNumber
                          "
                          @closeSendRequest="listener3"
                          :post="post_info"
                        />
                      </div>
                      <div
                        v-if="
                          post_info.email != user.email &&
                          post_info.request_post != null
                        "
                      >
                        <SendOffer
                          v-if="
                            postSendModal &&
                            sendOfferOrRequestpostNum ==
                              post_info.request_post.postNumber
                          "
                          @closeSendOffer="listener3"
                          :post="post_info"
                        />
                      </div>
                      <button
                        v-if="
                          post_info.email != user.email &&
                          post_info.offer_post != null
                        "
                        @click="
                          toggleSendModal();
                          sendOfferOrRequestpost = post_info.postIdentity;
                          sendOfferOrRequestpostNum =
                            post_info.offer_post.postNumber;
                        "
                        :disabled="!ifUserVerified(user.email)"
                        class="flex items-center space-x-2 focus:outline-none ssm:space-x-1"
                      >
                        <span
                          class="pr-2 ssm:pr-0 material-icons md-24 ssm:md-18 xsm:md-18 vs:md-18"
                        >
                          send
                        </span>
                        <p
                          class="text-base font-bold leading-none text-gray-600 ssm:text-xs vs:text-xs lvs:text-sm"
                        >
                          Send Request
                        </p>
                      </button>
                      <button
                        v-if="
                          post_info.email != user.email &&
                          post_info.request_post != null
                        "
                        @click="
                          toggleSendModal();
                          sendOfferOrRequestpost = post_info.postIdentity;
                          sendOfferOrRequestpostNum =
                            post_info.request_post.postNumber;
                        "
                        :disabled="!ifUserVerified(user.email)"
                        class="flex items-center space-x-2 focus:outline-none ssm:space-x-1"
                      >
                        <span
                          class="pr-2 ssm:pr-0 material-icons md-24 ssm:md-18 xsm:md-18 vs:md-18"
                        >
                          send
                        </span>
                        <p
                          class="text-base font-bold leading-none text-gray-600 ssm:text-xs vs:text-xs lvs:text-sm"
                        >
                          Send Offer
                        </p>
                      </button>
                      <router-link
                        v-if="post_info.email != user.email"
                        :to="'/messages/?ID=' + toEncrypt(post_info.user.email)"
                      >
                        <button
                          class="flex items-center space-x-2 focus:outline-none ssm:space-x-1"
                        >
                          <span class="pr-2 ssm:pr-0 material-icons md-24">
                            forum
                          </span>
                          <p
                            class="text-base font-bold leading-none text-gray-600 ssm:text-xs vs:text-xs lvs:text-sm"
                          >
                            Chat
                          </p>
                        </button>
                      </router-link>
                      <div>
                        <button
                          @click="
                            share1 = !share1;
                            share2 = post_info.postNumber;
                          "
                          class="flex items-center space-x-2 focus:outline-none ssm:space-x-1"
                        >
                          <span
                            class="pr-2 x-v:pr-1 ssm:pr-0 material-icons md-24 x-v:md-16"
                          >
                            share
                          </span>
                          <p
                            class="text-base font-bold leading-none text-gray-500 ssm:text-xs vs:text-xs lvs:text-sm"
                          >
                            Share
                          </p>
                        </button>
                        <div class="flex w-full">
                          <div
                            v-show="share2 == post_info.postNumber && share1"
                            class="absolute z-30 py-2 pt-2 pl-2 pr-4 leading-loose bg-white rounded-lg shadow-xl target ssm:right-5 vs:right-5 sm:right-5 lg:right-95 md:right-5 h-min w-30"
                          >
                            <button
                              @click="share(post_info.postNumber)"
                              class="flex flex-row text-base gap-x-2 vs:text-sm ssm:text-sm xsm:text-sm focus:outline-none"
                            >
                              <span
                                class="font-medium text-gray-500 material-icons x-v:md-16"
                              >
                                share
                              </span>
                              Share on Feed
                            </button>
                            <input
                              hidden
                              :value="copyThisLink(post_info.postNumber)"
                              :id="'myInput' + post_info.postNumber"
                            />
                            <button
                              @click="copyLink(post_info.postNumber)"
                              class="flex flex-row py-2 text-base font-normal x-v:text-sm focus:outline-none gap-x-2"
                            >
                              <span
                                class="font-normal text-gray-500 material-icons x-v:md-16 x-v:inline-block x-v:align-top"
                              >
                                link
                              </span>
                              Copy link to this post
                            </button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!--end-->
                  </div>
                </div>
              </div>
            </div>
            <!-- for shared posts-->
            <div v-else>
              <div
                class="pt-6 flex-col dv:float-right justify-center items-center"
              >
                <div
                  class="flex-col w-608 space-y-4 bg-white h-auto rounded-lg"
                >
                  <div class="flex pt-4 px-2 justify-between items-center">
                    <div class="focus:outline-none flex items-center space-x-4">
                      <button @click="setDispatches(post_info.sharerEmail)">
                        <p class="text-base italic leading-none text-gray-900">
                          <span class="font-bold"
                            >{{ post_info.user.firstName }}
                            {{ post_info.user.lastName }}</span
                          >
                          shared this post
                        </p>
                      </button>
                    </div>
                    <div
                      id="3dotmenu"
                      class="vs:mt-1 relative"
                      v-if="post_info.sharerEmail == user.email"
                    >
                      <button
                        @click="
                          share3dot = !share3dot;
                          share3dotPostNum = post_info.postNumber;
                        "
                        class="focus:outline-none"
                      >
                        <img
                          class="w-6 h-auto vs:w-4 lvs:w-5 ssm:w-4"
                          src="img/3dot.svg"
                        />
                      </button>

                      <div class="flex w-full">
                        <div
                          v-if="
                            share3dot &&
                            share3dotPostNum == post_info.postNumber
                          "
                          class="absolute py-2 pt-2 pl-2 pr-4 leading-loose bg-white rounded-lg shadow-xl ssm:right-5 vs:right-5 sm:right-5 lg:right-0 md:right-5 xl:right-0 h-min w-40"
                        >
                          <button
                            @click="deleteShared(post_info.postNumber)"
                            class="flex flex-row text-base gap-x-2 vs:text-sm vs:md-14"
                          >
                            <span class="text-gray-500 material-icons"
                              >delete</span
                            >Delete
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div
                    id="changeBoxRadius"
                    class="h-auto p-6 space-x-4 bg-white shadow vs:p-4 mv:w-full ssm:p-2 ssm:w-full vs:w-full sm:w-full w-608 rounded-xl"
                  >
                    <div class="flex flex-col items-start justify-start">
                      <!--section 1-->
                      <div
                        class="flex flex-row justify-between flex-grow w-full"
                      >
                        <div class="inline-flex">
                          <img
                            class="rounded-full x-v:absolute w-14 h-14 vs:w-10 vs:h-10 ssm:w-10 ssm:h-10"
                            :src="post_info.post.user.profilePicture"
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
                                <button
                                  class="font-bold"
                                  @click="
                                    setDispatches(post_info.post.user.email)
                                  "
                                >
                                  {{ post_info.post.user.firstName }}
                                  {{ post_info.post.user.lastName }}
                                </button>
                                <span
                                  class="pl-1 inline-block text-blue-900 align-middle material-icons-round md-18"
                                >
                                  verified
                                </span>
                                <label
                                  v-if="post_info.post.offer_post != null"
                                  class="pl-1 font-normal text-gray-500 align-top vs:font-light"
                                  >posted a shopping offer</label
                                >
                                <label
                                  v-if="post_info.post.request_post != null"
                                  class="pl-1 font-normal text-gray-500 align-top vs:font-light"
                                  >posted an order request</label
                                >
                              </h5>
                            </div>
                            <div
                              class="vs:flex vs:w-full ssm:w-full ssm:flex vs:pb-2 x-v:ml-10"
                            >
                              <span
                                class="text-sm leading-none text-gray-500 ssm:text-xs vs:text-xs lvs:text-sm"
                                >{{
                                  timestamp(post_info.post.dateCreated)
                                }}</span
                              >
                            </div>
                          </div>
                        </div>
                      </div>
                      <!--end-->

                      <!--section 2-->
                      <div
                        class="inline-flex mt-4 items-center space-x-2 justify-start px-2 py-1 bg-gray-100 rounded-full text-green-600"
                        v-if="
                          post_info.post.postStatus !== 'Accepting Requests' &&
                          post_info.post.postStatus !== 'Accepting Offer'
                        "
                      >
                        <span class="rounded-full material-icons text-red-600">
                          remove_circle_outline
                        </span>
                        <p
                          class="text-sm vs:text-xs ssm:text-xs lvs:text-sm font-bold leading-none items-center text-red-600"
                        >
                          {{ post_info.post.postStatus }}
                        </p>
                      </div>

                      <div
                        class="inline-flex mt-4 items-center space-x-2 justify-start px-2 py-1 bg-gray-100 rounded-full text-green-600"
                        v-if="
                          post_info.post.postStatus === 'Accepting Requests' ||
                          post_info.post.postStatus === 'Accepting Offer'
                        "
                      >
                        <span class="rounded-full material-icons">
                          check_circle_outline
                        </span>
                        <p
                          class="text-sm vs:text-xs ssm:text-xs lvs:text-sm font-bold leading-none items-center"
                        >
                          {{ post_info.post.postStatus }}
                        </p>
                      </div>
                      <!--end-->

                      <!--section 3-->
                      <div
                        class="flex items-center justify-start w-full mt-4 space-x-4 ssm:flex-col ssm:items-start ssm:space-x-0 vs:flex-col vs:items-start vs:space-x-0"
                        v-if="post_info.post.offer_post != null"
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
                              {{ post_info.post.offer_post.deliveryArea }}
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
                              {{
                                timestampSched(
                                  post_info.post.offer_post.deliverySchedule
                                )
                              }}
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
                              {{ post_info.post.offer_post.capacity }}
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
                              {{ post_info.post.offer_post.shoppingPlace }}
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
                              {{ post_info.post.offer_post.transportMode }}
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
                              {{ post_info.post.offer_post.paymentMethod }}
                            </p>
                          </div>
                        </div>
                      </div>
                      <!--end-->
                      <!--section 3 for request post-->
                      <div
                        v-if="post_info.post.request_post != null"
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
                              {{ post_info.post.request_post.deliveryAddress }}
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
                              {{
                                timestampSched(
                                  post_info.post.request_post.deliverySchedule
                                )
                              }}
                            </p>
                          </div>
                        </div>
                        <div class="flex-col w-full">
                          <div class="flex space-x-2">
                            <span
                              class="w-6 h-6 text-red-600 rounded-full material-icons"
                            >
                              shopping_cart
                            </span>
                            <p
                              class="py-1 text-sm leading-none text-gray-900 ssm:text-xs vs:text-xs lvs:text-sm"
                            >
                              {{ post_info.post.request_post.shoppingPlace }}
                            </p>
                          </div>
                          <div class="flex py-2 space-x-2">
                            <span
                              class="w-6 h-6 text-red-600 rounded-full material-icons"
                            >
                              payments
                            </span>
                            <p
                              class="py-1 text-sm leading-none text-gray-900 ssm:text-xs vs:text-xs lvs:text-sm"
                            >
                              {{ post_info.post.request_post.paymentMethod }}
                            </p>
                          </div>
                        </div>
                      </div>
                      <!--end-->

                      <!--section 4-->
                      <div
                        class="flex flex-col ssm:mt-2 vs:mt-2 mt-3 w-full items-start justify-start h-auto vs:pr-0 vs:min-w-0 vs:px-2 ssm:pr-0 ssm:min-w-0 ssm:px-2 p-4 bg-gray-100 rounded-xl"
                        v-if="
                          post_info.post.request_post != null &&
                          post_info.post.request_post.shoppingListContent !=
                            null
                        "
                      >
                        <div class="flex-col items-start w-full">
                          <span
                            class="pb-2 pl-2 text-sm font-bold vs:text-sm sm:text-sm sm:font-bold"
                            >Shopping List
                            <label class="font-normal text-gray-500"
                              >{{
                                computedShopItemList(
                                  post_info.post.request_post
                                    .shoppingListContent
                                ).length
                              }}
                              items</label
                            >
                          </span>
                          <ul
                            id="shop-list"
                            class="pl-4 leading-loose list-disc list-inside"
                          >
                            <li
                              v-for="(
                                shoppingList, index
                              ) in computedShopItemList(
                                post_info.post.request_post.shoppingListContent
                              )"
                              :key="index"
                              class="text-xl"
                            >
                              <span class="text-sm"
                                >{{ shoppingList.product }} ·
                                {{ shoppingList.brand }} [{{
                                  shoppingList.quantity
                                }}
                                units]</span
                              >
                            </li>
                          </ul>
                        </div>
                        <button
                          @click="showMoreshowLess"
                          v-if="
                            isFew(
                              post_info.post.request_post.shoppingListContent
                            )
                          "
                          class="focus:outline-none items-start justify-start text-sm text-gray-500"
                        >
                          {{ showListStatus }}
                        </button>
                      </div>
                      <div
                        class="flex items-start justify-start flex-grow-0 w-full p-4 mt-4 bg-gray-100 ssm:mt-2 vs:mt-2 rounded-xl"
                        v-if="
                          post_info.post.offer_post != null &&
                          post_info.post.offer_post.caption != null
                        "
                      >
                        <p
                          class="w-full h-auto text-sm leading-loose text-gray-900 ssm:text-xs vs:text-xs lvs:text-sm vs:min-w-0 vs:px-2"
                        >
                          {{ post_info.post.offer_post.caption }}
                        </p>
                      </div>
                      <div
                        class="flex items-start justify-start flex-grow-0 w-full p-4 mt-4 bg-gray-100 ssm:mt-2 vs:mt-2 rounded-xl"
                        v-if="
                          post_info.post.request_post != null &&
                          post_info.post.request_post.caption != null
                        "
                      >
                        <p
                          class="w-full h-auto text-sm leading-loose text-gray-900 ssm:text-xs vs:text-xs lvs:text-sm vs:min-w-0 vs:px-2"
                        >
                          {{ post_info.post.request_post.caption }}
                        </p>
                      </div>
                      <!--section 4-->
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!--end of user post-->

          <!--Share Modal-->
          <div
            @click.self="hideShareModal"
            id="modal-background"
            class="z-50 bg-opacity-25"
          >
            <div
              id="modal-content"
              class="flex-col h-auto space-y-4 bg-white rounded-lg w-608"
            >
              <div
                id="modal-header"
                class="flex flex-row items-center justify-between px-2 pt-4 space-x-4"
              >
                <button
                  @click="$router.push('edit-profile')"
                  class="flex items-center space-x-4 focus:outline-none"
                >
                  <img class="w-12 h-12 rounded-full" src="img/asta.jpeg" />
                  <p class="text-base font-bold leading-none text-gray-900">
                    Asta Staria
                  </p>
                </button>
                <button
                  @click="hideShareModal"
                  class="flex items-center focus:outline-none"
                >
                  <span
                    class="text-gray-500 material-icons allign-middle"
                    style="font-size: 36px"
                  >
                    cancel
                  </span>
                </button>
              </div>
              <div
                id="fkmouse"
                class="px-2 cursor-not-allowed modal-body"
              ></div>
              <div
                id="modal-footer"
                class="flex items-center justify-center px-2 pb-4 ssm:px-2 vs:px-2"
              >
                <button
                  class="inline-flex items-center justify-center w-full px-4 py-2 bg-red-700 rounded-full focus:outline-none ssm:h-8 ssm:w-full vs:w-full"
                >
                  <p
                    class="text-base font-bold leading-normal text-center text-white ssm:text-sm vs:text-sm lvs:text-base"
                  >
                    Share Post
                  </p>
                </button>
              </div>
            </div>
          </div>
          <!--end-->

          <!--Display Shared Post-->
          <div
            id="display-sharedPost"
            class="flex-col items-center justify-center pt-6 dv:float-right"
          >
            <div
              id="display-content"
              class="flex-col h-auto bg-white rounded-lg vs:w-full ssm:w-full w-608"
            >
              <div
                id="display-header"
                class="flex items-center justify-between px-2 py-4 pt-4"
              >
                <div class="flex items-center space-x-4 focus:outline-none">
                  <p
                    @click="$router.push('edit-profile')"
                    class="text-base italic leading-none text-gray-900"
                  >
                    <span class="font-bold">Asta Staria</span> shared this post
                  </p>
                </div>
              </div>
              <hr class="w-full" />
              <div id="fkmouse" class="cursor-not-allowed display-body"></div>
            </div>
          </div>
          <!--end-->
        </div>
      </div>
    </div>

    <!----------------------------START OF SHOPPING LISTS--------------------->
    <div
      class="flex flex-1 w-2/5 h-screen overflow-hidden llg:w-35 pl-7 vs:hidden ssm:hidden md:hidden sm:hidden xsm:hidden"
    >
      <div class="flex-1 overflow-y-scroll">
        <!-----------ACTIVE ORDERS---------------------->
        <div class="mt-20 mb-6 bg-white shadow-md w-72 rounded-2xl">
          <header
            class="py-3 pl-4 text-sm font-semibold tracking-wide text-gray-500"
          >
            ACTIVE ORDERS
            <span
              v-if="or_shift > 0"
              @click="prev_swap_order"
              class="inline-flex pl-20 pr-3 align-bottom cursor-pointer material-icons-round md-18"
            >
              navigate_before
            </span>
            <span
              v-else
              class="inline-flex pl-20 pr-3 text-gray-300 align-bottom cursor-pointer material-icons-round md-18"
            >
              navigate_before
            </span>

            <span
              v-if="or_shift < confirmedOrders.length - 1"
              @click="next_swap_order"
              class="inline-flex align-bottom cursor-pointer material-icons-round md-18"
            >
              navigate_next
            </span>
            <span
              v-else
              class="inline-flex text-gray-300 align-bottom cursor-pointer material-icons-round md-18"
            >
              navigate_next
            </span>
          </header>
          <hr />
          <div v-if="confirmedOrders.length > 0">
            <div class="px-2 pt-2 text-base bg-white rounded-b-xl">
              <label for="" class="pt-2 pl-3 font-bold">
                Transaction #{{ confirmedOrders[0].transactionNumber }}
              </label>
            </div>

            <div class="text-base bg-white rounded-b-xl">
              <label for="" class="pl-6 font-normal text-gray-500">
                {{ confirmedOrders[0].transactionShoppingList.length }} items
              </label>

              <label
                for=""
                class="float-right px-3 m-2 py-0.5 text-sm font-semibold border rounded-md border-waterloo text-waterloo"
              >
                {{ confirmedOrders[0].transactionStatus }}
              </label>
            </div>

            <div
              class="z-0 flex p-1 pl-2 mt-6 ml-2 text-sm font-semibold uppercase rounded-t-xl w-220 bg-gray-bgcolor"
            >
              <span>Shopper</span>
            </div>
            <div
              v-if="confirmedOrders[0].post.email != user.email"
              class="relative z-0 flex items-center w-220 p-1.5 rounded-b-xl ml-2 bg-gray-bgcolor"
            >
              <button class="top-0 left-0 pl-2 rounded-full border-1">
                <img
                  class="w-10 h-10 rounded-full"
                  :src="confirmedOrders[0].post.user.profilePicture"
                  alt=""
                />
              </button>
              <div class="ml-2">
                <h5 class="text-sm font-bold">
                  {{ confirmedOrders[0].post.user.firstName }}
                  {{ confirmedOrders[0].post.user.lastName }}
                  <span
                    class="inline-block text-blue-900 align-middle material-icons-round md-18"
                  >
                    verified
                  </span>
                </h5>

                <p class="text-sm font-normal font-nunito">
                  <span class="inline-block align-middle"
                    >{{ starRate(userReviews(confirmedOrders[0].post.email)) }}
                  </span>
                  <span
                    class="top-0 inline-block text-red-700 align-top material-icons-round md-20"
                  >
                    star_rate
                  </span>
                </p>
              </div>

              <div
                class="absolute h-10 p-2 mr-2 rounded-full right-2 bg-success"
              >
                <span
                  class="inline-flex text-white align-middle material-icons"
                >
                  chat
                </span>
                <router-link
                  :to="'/messages/?ID=' + confirmedOrders[0].post.email"
                  class="font-bold align-top cursor-pointer mmd:text-base mmd:inline-block"
                ></router-link>
              </div>
            </div>
            <div
              v-else
              class="relative z-0 flex items-center w-220 p-1.5 rounded-b-xl ml-2 bg-gray-bgcolor"
            >
              <button class="top-0 left-0 pl-2 rounded-full border-1">
                <img
                  class="w-10 h-10 rounded-full"
                  :src="confirmedOrders[0].transaction_sender.profilePicture"
                  alt=""
                />
              </button>
              <div class="ml-2">
                <h5 class="text-sm font-bold">
                  {{ confirmedOrders[0].transaction_sender.firstName }}
                  {{ confirmedOrders[0].transaction_sender.lastName }}
                  <span
                    class="inline-block text-blue-900 align-middle material-icons-round md-18"
                  >
                    verified
                  </span>
                </h5>

                <p class="text-sm font-normal font-nunito">
                  <span class="inline-block align-middle"
                    >{{
                      starRate(
                        userReviews(confirmedOrders[0].transaction_sender.email)
                      )
                    }}
                  </span>
                  <span
                    class="top-0 inline-block text-red-700 align-top material-icons-round md-20"
                  >
                    star_rate
                  </span>
                </p>
              </div>

              <div
                class="absolute h-10 p-2 mr-2 rounded-full right-2 bg-success"
              >
                <span
                  class="inline-flex text-white align-middle material-icons"
                >
                  chat
                </span>
                <router-link
                  :to="'/messages/?ID=' + confirmedOrders[0].transaction_sender"
                  class="font-bold align-top cursor-pointer mmd:text-base mmd:inline-block"
                ></router-link>
              </div>
            </div>

            <div
              class="pt-2 pb-8 pr-3 text-sm tracking-wide bg-white rounded-b-xl"
            >
              <button
                @click="
                  dispatchSinglePage(confirmedOrders[0].transactionNumber)
                "
                class="float-right font-bold"
              >
                View Full Details
              </button>
            </div>
          </div>
          <div v-else>
            <p v-if="ifUserVerified(user.email)" class="text-center">
              No active Orders
            </p>
            <p v-else class="text-center">Get verified</p>
          </div>
        </div>
        <!-----------END OF ACTIVE ORDERS---------------->

        <!-----------ACTIVE DELIVERIES---------------------->
        <div
          class="z-0 mb-6 bg-white w-72 rounded-xl vs:hidden xsm:hidden ssm:hidden"
        >
          <header
            class="py-3 pl-4 text-sm font-semibold tracking-wide text-gray-500"
          >
            ACTIVE DELIVERIES
            <span
              v-if="shift > 0"
              @click="prev_swap_deliver()"
              class="inline-flex pl-16 pr-3 align-bottom cursor-pointer select-none material-icons-round md-18"
            >
              navigate_before
            </span>
            <span
              v-else
              class="inline-flex pl-16 pr-3 text-gray-300 align-bottom cursor-pointer select-none material-icons-round md-18"
            >
              navigate_before
            </span>

            <span
              v-if="shift < confirmedDeliveries.length - 1"
              @click="next_swap_deliver()"
              class="inline-flex align-bottom cursor-pointer select-none material-icons-round md-18"
            >
              navigate_next
            </span>
            <span
              v-else
              class="inline-flex text-gray-300 align-bottom cursor-pointer select-none material-icons-round md-18"
            >
              navigate_next
            </span>
          </header>
          <hr />
          <div v-if="confirmedDeliveries.length > 0">
            <div class="px-2 pt-2 text-base bg-white rounded-b-xl">
              <label for="" class="pt-2 pl-3 font-bold">
                Transaction #{{ confirmedDeliveries[0].transactionNumber }}
              </label>
            </div>

            <div class="text-base bg-white rounded-b-xl">
              <label for="" class="pl-6 font-normal text-gray-500">
                {{ confirmedDeliveries[0].transactionShoppingList.length }}
                items
              </label>

              <label
                for=""
                class="float-right px-3 m-2 py-0.5 text-sm font-semibold border rounded-md border-waterloo text-waterloo"
              >
                {{ confirmedDeliveries[0].transactionStatus }}
              </label>
            </div>

            <div
              class="z-0 flex p-1 pl-2 mt-6 ml-2 text-sm font-semibold uppercase rounded-t-xl w-220 bg-gray-bgcolor"
            >
              <span>Customer</span>
            </div>
            <div
              v-if="confirmedDeliveries[0].post.user.email != user.email"
              class="relative flex items-center w-220 z-0 p-1.5 rounded-b-xl ml-2 bg-gray-bgcolor"
            >
              <button class="top-0 left-0 pl-2 rounded-full border-1">
                <img
                  class="w-10 h-10 rounded-full"
                  :src="confirmedDeliveries[0].post.user.profilePicture"
                  alt=""
                />
              </button>
              <div class="ml-2">
                <h5 class="text-sm font-bold">
                  {{ confirmedDeliveries[0].post.user.firstName }}
                  {{ confirmedDeliveries[0].post.user.lastName }}
                  <span
                    class="inline-block text-blue-900 align-middle material-icons-round md-18"
                  >
                    verified
                  </span>
                </h5>
                <p class="text-sm font-normal font-nunito">
                  <span class="inline-block align-middle"
                    >{{
                      starRate(userReviews(confirmedDeliveries[0].post.email))
                    }}
                  </span>
                  <span
                    class="top-0 inline-block text-red-700 align-top material-icons-round md-20"
                  >
                    star_rate
                  </span>
                </p>
              </div>

              <div
                class="absolute h-10 p-2 mr-2 rounded-full bg-success right-2"
              >
                <span class="inline-flex text-white align-middle material-icons"
                  >chat</span
                >
                <router-link
                  :to="'/messages/?ID=' + confirmedDeliveries[0].post.email"
                  class="font-bold align-top cursor-pointer mmd:text-base mmd:inline-block"
                ></router-link>
              </div>
            </div>
            <div
              v-else
              class="relative flex items-center w-220 z-0 p-1.5 rounded-b-xl ml-2 bg-gray-bgcolor"
            >
              <button class="top-0 left-0 pl-2 rounded-full border-1">
                <img
                  class="w-10 h-10 rounded-full"
                  :src="
                    confirmedDeliveries[0].transaction_sender.profilePicture
                  "
                  alt=""
                />
              </button>
              <div class="ml-2">
                <h5 class="text-sm font-bold">
                  {{ confirmedDeliveries[0].transaction_sender.firstName }}
                  {{ confirmedDeliveries[0].transaction_sender.lastName }}
                  <span
                    class="inline-block text-blue-900 align-middle material-icons-round md-18"
                  >
                    verified
                  </span>
                </h5>
                <p class="text-sm font-normal font-nunito">
                  <span class="inline-block align-middle"
                    >{{
                      starRate(
                        userReviews(
                          confirmedDeliveries[0].transaction_sender.email
                        )
                      )
                    }}
                  </span>
                  <span
                    class="top-0 inline-block text-red-700 align-top material-icons-round md-20"
                  >
                    star_rate
                  </span>
                </p>
              </div>

              <div
                class="absolute h-10 p-2 mr-2 rounded-full bg-success right-2"
              >
                <span class="inline-flex text-white align-middle material-icons"
                  >chat</span
                >
                <router-link
                  :to="
                    '/messages/?ID=' +
                    confirmedDeliveries[0].transaction_sender.email
                  "
                  class="font-bold align-top cursor-pointer mmd:text-base mmd:inline-block"
                ></router-link>
              </div>
            </div>
            <div class="pt-2">
              <span
                class="inline-block pl-3 text-gray-500 align-top material-icons-round md-18"
              >
                room
              </span>
              <label
                for=""
                class="inline-block pl-2 text-sm tracking-wide align-text-top"
              >
                {{ confirmedDeliveries[0].transactionData.deliveryAddress }}
              </label>
            </div>
            <div class="pb-8 pr-3 text-sm tracking-wide bg-white rounded-b-xl">
              <button
                @click="
                  dispatchSinglePage(confirmedDeliveries[0].transactionNumber)
                "
                class="float-right font-bold"
              >
                View Full Details
              </button>
            </div>
          </div>
          <div v-else>
            <p v-if="ifUserVerified(user.email)" class="text-center">
              No active Deliveries
            </p>
            <p v-else class="text-center">Get verified</p>
          </div>
        </div>
        <!-----------END OF ACTIVE DELIVERIES---------------->

        <div
          class="flex flex-wrap float-left font-nunito md:block vs:hidden xsm:hidden ssm:hidden"
        >
          <div class="bg-white w-72 h-56 rounded-xl">
            <header
              class="py-3 pl-4 text-sm font-semibold tracking-wide text-gray-500"
            >
              SHOPPING LIST
              <span
                v-if="s_shift > 0"
                @click="prev_swap_list()"
                class="inline-flex pl-24 pr-3 align-bottom cursor-pointer select-none material-icons-round md-18"
              >
                navigate_before
              </span>
              <span
                v-else
                class="inline-flex pl-24 pr-3 text-gray-300 align-bottom cursor-pointer select-none material-icons-round md-18"
              >
                navigate_before
              </span>

              <span
                v-if="s_shift < shoppingLists.length - 1"
                @click="next_swap_list()"
                class="inline-flex align-bottom cursor-pointer select-none material-icons-round md-18"
              >
                navigate_next
              </span>
              <span
                v-else
                class="inline-flex text-gray-300 align-bottom cursor-pointer select-none material-icons-round md-18"
              >
                navigate_next
              </span>
            </header>

            <hr />

            <!--SHOPPING LIST-->
            <div>
              <div
                class="relative pt-2 pl-5 text-lg font-bold leading-loose tracking-wide"
              >
                <span v-if="shoppingLists.length > 0">{{
                  shoppingLists[0].shoppingListTitle
                }}</span>

                <div
                  v-if="shoppingLists.length > 0"
                  class="absolute bottom-0 pt-2 pr-2 ml-2 text-sm font-bold right-1 top-2 focus:outline-none"
                >
                  <span
                    @click="option_more = !option_more"
                    class="cursor-pointer select-none material-icons md-18"
                  >
                    more_vert
                  </span>
                  <div
                    v-if="option_more"
                    class="absolute bg-white drop-shadow-2xl right-3 rounded-xl shadow-2xl p-1"
                  >
                    <div
                      @click="editListFromDashboard()"
                      class="flex cursor-pointer items-center space-x-2"
                    >
                      <span class="material-icons text-gray-400"> mode </span>
                      <p class="select-none">Edit</p>
                    </div>
                    <div
                      @click="(toggle_delete = true), (option_more = false)"
                      class="flex cursor-pointer items-center space-x-2"
                    >
                      <span class="material-icons text-gray-400"> delete </span>
                      <p class="select-none">Delete</p>
                    </div>
                  </div>
                </div>
              </div>

              <div class="overflow-y-auto h-20">
                <span
                  v-if="shoppingLists.length < 1"
                  class="font-bold pl-5 text-center"
                  >No shopping List Available</span
                >

                <ul
                  v-else
                  id="shop-list"
                  class="overflow-hidden text-sm leading-loose list-none pl-9"
                >
                  <li
                    v-for="item in shoppingLists[0].shoppingListContent"
                    :key="item.product"
                  >
                    <input
                      type="checkbox"
                      name=""
                      id=""
                      disabled
                      class="pr-4 overflow-hidden truncate whitespace-nowrap"
                      :checked="item.status === 1"
                    />
                    {{ item.product }} · {{ item.brand }} · [{{
                      item.quantity
                    }}]
                  </li>
                </ul>
              </div>
              <hr />
              <div class="items-center justify-center p-3 pl-4">
                <createShopList
                  v-if="createShopList"
                  @closeshopListModal="listener6"
                />
                <button
                  v-show="ifUserVerified(user.email)"
                  @click="addlist = !addlist"
                  class="w-64 h-8 px-5 text-sm font-bold text-red-600 transition-colors duration-150 border-2 border-red-600 rounded-3xl focus:outline-none"
                >
                  <span>Create New</span>
                </button>
                <router-link
                  v-show="!ifUserVerified(user.email)"
                  to="/account-settings"
                >
                  <button
                    class="w-64 h-8 px-5 text-sm font-bold text-red-600 transition-colors duration-150 border-2 border-red-600 rounded-3xl focus:outline-none"
                  >
                    <span>Get verified</span>
                  </button>
                </router-link>
              </div>
              <!--Add new Shopping list-->
              <div
                v-if="addlist"
                @click.self="addlist = !addlist"
                class="fixed z-100 bg-black bg-opacity-75 overflow-y-auto inset-0"
              >
                <div
                  class="flex mt-4 w-full p-3 items-center justify-center py-20"
                >
                  <div
                    class="self-center bg-white ring-1 ring-gray-300 py-2 w-full rounded-xl 2xl:w-608 2xl:mt-0 lg:w-608 lg:mt-0 xl:w-608 xl:mt-0 md:w-10/12 md:mt-0 sm:w-11/12 p-5 space-y-3 h-auto"
                  >
                    <div class="flex flex-row items-center space-x-2">
                      <input
                        type="text"
                        placeholder="Title"
                        id="new_title"
                        class="pl-3 focus:outline-none h-10 text-base"
                      />
                      <span
                        @click="
                          document.getElementbyId('new_title').disable = false
                        "
                        class="cursor-pointer select-none material-icons text-md text-gray-500"
                      >
                        mode
                      </span>
                    </div>
                    <div
                      class="flex flex-row items-center space-x-3 select-none pl-3"
                    >
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
                        <div
                          class="rounded-xl pl-5 w-full focus:outline-none h-10 bg-gray-100"
                        >
                          <input
                            id="brand"
                            type="text"
                            placeholder="Brand"
                            class="rounded-xl pl-5 w-full focus:outline-none h-10 bg-gray-100"
                            @keyup="brand(), (brandSearchTag = true)"
                            @click="brand(), (brandSearchTag = !brandSearchTag)"
                          />
                          <div class="relative">
                            <div
                              v-if="brandSearchTag"
                              class="absolute py-3 bg-white rounded-lg shadow-xl right-0 h-35.1 sm:w-full w-full"
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
                                      v-for="(brand, index) in brands"
                                      :key="index"
                                      @click="
                                        setBrand(index);
                                        brandSearchTag = !brandSearchTag;
                                      "
                                    >
                                      <a href="#" :id="'brand' + index">{{
                                        brand
                                      }}</a>
                                    </li>
                                  </ul>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
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
                            @click="add_newItem()"
                            class="ring-2 rounded-2xl h-6 w-20 font-bold text-white ring-red-buttons focus:outline-none bg-red-buttons"
                          >
                            Add
                          </button>
                        </div>
                      </div>
                    </div>
                    <!-- <div class="flex text-gray-400 text-xs justify-end">
                      <p>Updated</p>
                      {{ time }}
                    </div> -->
                    <hr class="bg-black" />
                    <p class="text-center text-red-500">{{ listError }}</p>
                    <div class="flex justify-between">
                      <ul
                        id="example-1"
                        class="text-sm list-inside space-y-2 p-5 w-full"
                      >
                        <li
                          v-for="item in new_items"
                          :key="item.id"
                          class="grid-cols-2 w-ful list-none"
                        >
                          <div class="flex flex-row justify-between w-full">
                            <div class="flex flex-col">
                              <div
                                class="flex flex-row text-md items-center space-x-3"
                              >
                                <input
                                  type="checkbox"
                                  class=""
                                  :id="'check' + item.id"
                                  :value="item.product"
                                  :checked="item.status === 1"
                                />
                                <label class=""
                                  >{{ item.product }}({{ item.size }})</label
                                >
                              </div>
                              <div class="flex justify-start pl-8">
                                <p class="text-sm">{{ item.brand }}</p>
                              </div>
                            </div>

                            <div class="flex flex-row space-x-5">
                              <span
                                @click="item.quantity++"
                                class="material-icons select-none cursor-pointer text-red-700"
                              >
                                add
                              </span>
                              <div class="w-3 h-3">
                                <p>{{ item.quantity }}</p>
                              </div>
                              <span
                                @click="item.quantity = minusQty(item.quantity)"
                                class="material-icons select-none cursor-pointer text-red-700"
                              >
                                remove
                              </span>
                              <button @click="productOptions(item.id); " class="focus:outline-none flex">
                                <span class="material-icons"> more_vert </span>
                              </button>
                            </div>
                          </div>
                        </li>
                      </ul>
                    </div>
                    <div class="flex flex-row items-center justify-between">
                      <div class="space-x-3 text-gray-500">
                        <span
                          @click="deleteList"
                          class="material-icons cursor-pointer select-none"
                        >
                          delete
                        </span>
                        <span
                          @click="
                            addlist = false;
                            listToggleFlag = true;
                            add_shopping_list();
                          "
                          class="material-icons cursor-pointer select-none"
                        >
                          post_add
                        </span>
                      </div>
                      <p
                        @click="
                          (addlist = false),
                            add_shopping_list(),
                            (selectedList = [])
                        "
                        class="cursor-pointer text-blue-700 font-bold select-none"
                      >
                        Close
                      </p>
                    </div>
                  </div>
                </div>
              </div>
              <!--End -->
              <!--Edit Shopping List-->
              <div
                v-if="Editlist"
                class="fixed z-100 bg-black bg-opacity-75 overflow-y-auto inset-0"
              >
                <div
                  class="flex mt-4 w-full p-3 items-center justify-center py-20"
                >
                  <div
                    class="self-center bg-white ring-1 ring-gray-300 py-2 w-full rounded-xl 2xl:w-608 2xl:mt-0 lg:w-608 lg:mt-0 xl:w-608 xl:mt-0 md:w-10/12 md:mt-0 sm:w-11/12 p-5 space-y-3 h-auto"
                  >
                    <div class="flex flex-row items-center space-x-2">
                      <input
                        :value="shoppingLists[0].shoppingListTitle"
                        type="text"
                        id="new_title"
                        class="focus:outline-none h-10 pl-3 bg-gray-100"
                      />
                      <span
                        class="cursor-pointer select-none material-icons text-md text-gray-500"
                      >
                        mode
                      </span>
                    </div>
                    <div
                      class="flex flex-row items-center space-x-3 select-none pl-3"
                    >
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
                        id="s_product"
                        type="text"
                        placeholder="Product"
                        class="rounded-xl pl-5 w-full focus:outline-none h-10 bg-gray-100"
                      />
                      <div class="flex flex-row space-x-2">
                        <input
                          id="s_brand"
                          type="text"
                          placeholder="Brand"
                          class="rounded-xl pl-5 w-full focus:outline-none h-10 bg-gray-100"
                        />
                        <input
                          id="s_size"
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
                        <p id="s_quants">{{ quantity }}</p>
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
                            @click="
                              add_item_shopping_list(
                                's_product',
                                's_brand',
                                's_size',
                                's_quants'
                              )
                            "
                            class="ring-2 rounded-2xl h-6 w-20 font-bold text-white ring-red-buttons focus:outline-none bg-red-buttons"
                          >
                            Add
                          </button>
                        </div>
                      </div>
                    </div>
                    <div class="flex text-gray-400 text-xs justify-end">
                      <p>
                        Last updated
                        {{ timestamp(shoppingLists[0].dateModified) }}
                      </p>
                    </div>
                    <hr class="bg-black" />
                    <p class="text-center text-red-500">{{ listError }}</p>
                    <div class="flex justify-between h-50 overflow-y-auto">
                      <ul
                        id="example-1"
                        class="text-sm list-inside space-y-2 p-5 w-full"
                      >
                        <li
                          v-for="item in new_items"
                          :key="item.product"
                          class="grid-cols-2 w-ful list-none"
                        >
                          <div class="flex flex-row justify-between w-full">
                            <div class="flex flex-col">
                              <div
                                class="flex flex-row text-md items-center space-x-3"
                              >
                                <input
                                  type="checkbox"
                                  class=""
                                  :id="'checkEdit' + item.id"
                                  :value="item.product"
                                  :checked="item.status === 1"
                                />
                                <label class=""
                                  >{{ item.product }}({{ item.size }})</label
                                >
                              </div>
                              <div class="flex justify-start pl-8">
                                <p class="text-sm">{{ item.brand }}</p>
                              </div>
                            </div>

                            <div class="flex flex-row space-x-5">
                              <span
                                @click="item.quantity++"
                                class="material-icons select-none cursor-pointer text-red-700"
                              >
                                add
                              </span>
                              <div class="w-3 h-3">
                                <p>{{ item.quantity }}</p>
                              </div>
                              <span
                                @click="item.quantity = minusQty(item.quantity)"
                                class="material-icons select-none cursor-pointer text-red-700"
                              >
                                remove
                              </span>
                              <button class="focus:outline-none flex">
                                <span class="material-icons"> more_vert </span>
                              </button>
                            </div>
                          </div>
                        </li>
                      </ul>
                    </div>
                    <div class="flex flex-row items-center justify-between">
                      <div class="space-x-3 text-gray-500">
                        <span
                          @click="deleteList"
                          class="material-icons cursor-pointer select-none"
                        >
                          delete
                        </span>
                        <span
                          @click="
                            (listToggleFlag = true),
                              updateShoppinglist(
                                shoppingLists[0].shoppingListNumber
                              )
                          "
                          class="material-icons cursor-pointer select-none"
                        >
                          post_add
                        </span>
                      </div>
                      <p
                        @click="
                          updateShoppinglist(
                            shoppingLists[0].shoppingListNumber
                          ),
                            (selectedList = [])
                        "
                        class="cursor-pointer text-blue-700 font-bold select-none"
                      >
                        Close
                      </p>
                    </div>
                  </div>
                </div>
              </div>
              <!--End Edit Shopping List-->
              <!--Toggle Delete -->
              <div
                v-if="toggle_delete"
                class="fixed bg-black z-100 h-max w-screen bg-opacity-75 overflow-y-auto items-center inset-0"
              >
                <div
                  class="flex mt-4 w-full p-3 items-center justify-center py-20"
                >
                  <div
                    class="bg-white ring-1 ring-gray-300 p-5 w-full rounded-xl 2xl:w-97 lg:w-97 xl:w-97 xl:mr-16 md:w-8/12 sm:w-10/12 shadow-2xl h-auto"
                  >
                    <div class="flex flex-row items-center justify-between p-3">
                      <p class="hidden lg:block 2xl:block xl:block"></p>
                      <p
                        class="text-lg font-extrabold xl:ml-8 lg:ml-8 2xl:ml-8"
                      >
                        Delete Shopping List
                      </p>
                      <p
                        class="font-bold text-blue-700 cursor-pointer left-10"
                        @click="toggle_delete = false"
                      >
                        Close
                      </p>
                    </div>
                    <div class="text-center pb-5">
                      <p class="text-lg">
                        Are you sure you want to remove this shopping list?
                      </p>
                    </div>
                    <hr />
                    <div class=" ">
                      <div
                        class="flex justify-between mt-4 px-5 space-x-4 items-center"
                      >
                        <button
                          @click="toggle_delete = false"
                          class="px-4 bg-white text-black focus:outline-none w-full h-7 shadow-xl ring-1 ring-gray-300 rounded-2xl"
                        >
                          Cancel
                        </button>

                        <button
                          @click="deleteListFrom()"
                          class="px-4 bg-red-buttons text-white focus:outline-none w-full h-7 shadow-xl ring-1 ring-gray-300 rounded-2xl"
                        >
                          Delete
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!--end toggle delete-->
          </div>
        </div>

        <!-- <div
          class="flex flex-wrap float-left font-nunito md:block vs:hidden xsm:hidden ssm:hidden"
        >
          <div
            class="mt-2 mb-6 text-xs leading-relaxed text-gray-500 bg-transparent w-72 rounded-xl"
          >
            Privacy Policy · Cookies Policy · Terms and Conditions Return and
            refund Policy Help Center <br />
            Pasabuy © 2021
          </div>
        </div> -->
      </div>
    </div>
  </div>

  <!-----pop ups--->
  <div class="bg-transparent fixed bottom-3 w-full flex flex-col items-end">
    <div
      v-if="false"
      :TogglePopup="() => TogglePopup('popUpUp1')"
      class="transition delay-150 mb-1 sm:w-z md:w-z lg:w-z llg:w-z xl:w-z xll:w-z 2xl:w-z 2xxl:w-z md:right-7 lg:right-7 llg:right-7 xl:right-7 xll:right-7 2xl:right-7 2xxl:right-7 mx-2 rounded-xl flex justify-between flex-row shadow-lg bg-black text-white border px-4 pb-4 pt-4 xsm:h-auto ssm:h-auto vsv:h-auto vsvs:h-auto lvs:h-auto sm:h-auto md:h-auto"
    >
      <div class="flex items-center">
        <img
          src="https://ptetutorials.com/images/user-profile.png"
          alt="sunil"
          class="rounded-full h-w w-w xsm:h-8 ssm:h-8 vsv:h-8 vsvs:h-8 lvs:h-8 sm:h-8 xsm:w-8 ssm:w-8 vsv:w-8 vsvs:w-8 lvs:w-8 sm:w-8"
        />
        <span class="ml-2 text-sm flex flex-col justify-start">
          <span> Mark Aral sent you an order request.</span>
          <span class="font-bold">View Request</span>
        </span>
      </div>
      <div class="flex items-center">
        <button
          @click="popupTriggers.popUp1 = false"
          class="focus:outline-none hover:text-red-700 hover:bg-white rounded-full h-6 ml-2 xsm:ml-2 ssm: vsv: vsvs: lvs: sm: md:"
          type="button"
        >
          <span class="material-icons"> cancel</span>
        </button>
      </div>
    </div>
    <div
      v-if="false"
      :TogglePopup="() => TogglePopup('popUpUp2')"
      class="mb-1 sm:w-z md:w-z lg:w-z llg:w-z xl:w-z xll:w-z 2xl:w-z 2xxl:w-z md:right-7 lg:right-7 llg:right-7 xl:right-7 xll:right-7 2xl:right-7 2xxl:right-7 mx-2 rounded-xl flex justify-between flex-row shadow-lg bg-black text-white border px-4 pb-4 pt-4 xsm:h-auto ssm:h-auto vsv:h-auto vsvs:h-auto lvs:h-auto sm:h-auto md:h-auto"
    >
      <div class="flex items-center">
        <span class="icons material-icons" style="color: #9ca3af"
          >check_circle</span
        >
        <span class="ml-2 text-sm">
          Request successfully sent to
          <span class="font-bold">Mark Aral</span></span
        >
      </div>
      <div class="flex items-center">
        <button
          @click="popupTriggers.popUp2 = false"
          class="focus:outline-none hover:text-red-700 hover:bg-white rounded-full h-6"
          type="button"
        >
          <span class="material-icons"> cancel</span>
        </button>
      </div>
    </div>
    <div
      v-if="popUp3"
      class="sm:w-z md:w-z lg:w-z llg:w-z xl:w-z xll:w-z 2xl:w-z 2xxl:w-z md:right-7 lg:right-7 llg:right-7 xl:right-7 xll:right-7 2xl:right-7 2xxl:right-7 mx-2 rounded-xl flex justify-between flex-row shadow-lg bg-black text-white border px-4 pb-4 pt-4 xsm:h-auto ssm:h-auto vsv:h-auto vsvs:h-auto lvs:h-auto sm:h-auto md:h-auto"
    >
      <div class="flex items-center">
        <span class="icons material-icons" style="color: #9ca3af"
          >check_circle</span
        >
        <span class="ml-2 text-sm">
          Post successfully shared on your profile.</span
        >
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
    <div
      v-if="popUpPost"
      class="sm:w-z md:w-z lg:w-z llg:w-z xl:w-z xll:w-z 2xl:w-z 2xxl:w-z md:right-7 lg:right-7 llg:right-7 xl:right-7 xll:right-7 2xl:right-7 2xxl:right-7 mx-2 rounded-xl flex justify-between flex-row shadow-lg bg-black text-white border px-4 pb-4 pt-4 xsm:h-auto ssm:h-auto vsv:h-auto vsvs:h-auto lvs:h-auto sm:h-auto md:h-auto"
    >
      <div class="flex items-center">
        <span class="icons material-icons" style="color: #9ca3af"
          >check_circle</span
        >
        <span class="ml-2 text-sm"> Your post is ready to view </span>
      </div>
      <div class="flex items-center">
        <button
          @click="popUpPost = false"
          class="focus:outline-none hover:text-red-700 hover:bg-white rounded-full h-6"
          type="button"
        >
          <span class="material-icons"> cancel</span>
        </button>
      </div>
    </div>
    <!---popup cookies--->
    <!---popup cookies--->
    <div
      v-if="popupTriggers.timedTrigger"
      :TogglePopup="() => TogglePopup('timedTrigger')"
      class="md:w-z lg:w-z sm:w-z llg:w-z xl:w-z xll:w-z 2xl:w-z 2xxl:w-z md:right-3 lg:right-3 llg:right-3 xl:right-3 xll:right-3 2xl:right-3 2xxl:right-3 h-u mx-2 rounded-xl flex justify items-center shadow-lg bg-black text-white border px-4 pb-4 pt-4 xsm:h-auto ssm:h-auto vsv:h-auto vsvs:h-auto lvs:h-auto sm:h-auto md:h-auto"
    >
      <div class="text-sm w-full h-full px-3 rounded pt-4">
        <h1 class="font-semibold text-lg">This website use cookies</h1>
        <p class="text-justify font-normal pt-1">
          We use cookies to personalise content and ads, to provide social media
          features and to analyse our traffic. We also share information about
          your use of our site with our social media, advertising and analytics
          partners who may combine it with other information that you’ve
          provided to them or that they’ve collected from your use of their
          services
        </p>
        <div class="flex justify-end relative">
          <button
            @click="setCookie"
            class="mx-2 mt-2 h-7 px-2 mb-2 bg-gray-100 text-black hover:text-white hover:bg-gray-400 focus:outline-none rounded-full border border-gray-700"
          >
            <span>Accept all cookies</span>
          </button>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import Navbar from "./Navbar";
import EditShoppingOfferPostVue from "./EditShoppingOffer.vue";
import PostModal from "./PostModal";
import UpdateOfferStatus from "./updateOfferStatus";
import UpdateOrderStatus from "./updateOrderStatus";
import SendRequest from "./sendRequest";
import createShopList from "./createShopList";
import EditOrderRequest from "./EditOrderRequest";
import $ from "jquery";
import { ref } from "vue";
import api from "../api";
import SendOffer from "./sendOffer.vue";
import store from "../store/index";
import moment from "moment";
import VueSimpleAlert from "vue-simple-alert";
import axios from "axios";
import _ from "lodash";

export default {
  el: "#shop-list",
  setup() {
    const popupTriggers = ref({
      timedTrigger: false,
      popUp1: false,
      popUp2: false,
    });
    const TogglePopup = (trigger) => {
      popupTriggers.value[trigger] = !popupTriggers.value[trigger];
    };
    setTimeout(() => {
      popupTriggers.value.popUp1 = true;
    }, 10000);
    setTimeout(() => {
      popupTriggers.value.popUp2 = true;
    }, 5000);
    setTimeout(() => {
      if (sessionStorage.getItem("sessionCookieNotify") === "true") {
        popupTriggers.value.timedTrigger = true;
      } else {
        popupTriggers.value.timedTrigger = false;
      }
      console.log("cookie", popupTriggers.value.timedTrigger);
    }, 3500);
    return {
      popupTriggers,
      TogglePopup,
    };
  },
  data() {
    return {
      share3dot: false,
      share3dotPostNum: null,
      ctrProp: 0,
      brandSearchTag: false,
      popUp3: false,
      popUpPost: false,
      shift: 0,
      toggle_delete: false,
      option_more: false,
      hide_title: true,
      Editlist: false,
      or_shift: 0,
      s_shift: 0,
      postModalVisible: false,
      postModalVisible1: false,
      postModalVisible2: false,
      postModalVisible3: false,
      postSendModal: false,
      postChatModal: false,
      editVisible: false,
      edit1: false,
      edit2: false,
      share1: false,
      share2: false,
      filter: false,
      filter2: false,
      hidden_list: false,
      hidden: false,
      hide_input: false,
      label_title: true,
      addtitle: false,
      addlist: false,
      new_item: false,
      quantity: 1,
      n: 2,
      id_num: 3,
      new_title: "",
      list_number: 0,
      new_items: [],
      createShopList: false,
      editOrderRequest: false,
      datePosted: "3 hours ago",
      datePosted1: "13 hours ago",
      postStatus: "posted",
      user_info: {
        firstname: "Yami",
        lastname: "Yami",
      },
      delivery_info: {
        delivery_area: "Naga City",
        shopping_place: "SM City Legazpi",
        schedule: "2021-04-28 13:12:01",
        public_transit: "Public Transit",
        capacity: "2 Big Plastic Bag",
        payment_method: "Cash on Delivery",
        comment: "Let me Know",
        status: "No Longer Accepting Requests",
      },
      user_info1: {
        firstname: "Jane",
        lastname: "Doe",
      },
      delivery_info1: {
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
      activeDeliveries: [
        {
          transNo: "61913174",
          address: "Ligao",
          firstName: "Hanbin",
          lastName: "Kim",
          rate: "4.9",
          stats: "Confirmed",
        },
        {
          transNo: "61913175",
          address: "Ligazpi",
          firstName: "Hanbina",
          lastName: "Kim0",
          rate: "4.9",
          stats: "Confirmed",
        },
        {
          transNo: "61913176",
          address: "Daraga",
          firstName: "Utetsu",
          lastName: "monk",
          rate: "4.9",
          stats: "Confirmed",
        },
      ],
      activeOrders: [
        {
          transactNo: "1267643764",
          address: "Legazpi",
          first_name: "Go Eun",
          last_name: "Na",
          rating: "4.9",
          stat: "Confirmed",
        },
        {
          transactNo: "1267643765",
          address: "Naga",
          first_name: "Kyoko",
          last_name: "Hori",
          rating: "4.9",
          stat: "Confirmed",
        },
        {
          transactNo: "1267643766",
          address: "Ginubatab",
          first_name: "Erza",
          last_name: "Scarlet",
          rating: "4.9",
          stat: "Confirmed",
        },
      ],
      shopping_list: [],
      shopList: [
        {
          name: "Weekly Shopping List",
          items: "Sugar  (1kg)",
          brand: "Any brand",
          units: "2 units",
        },
        {
          name: "Birthday Shopping List",
          items: "Ketchup",
          brand: "Any brand",
        },
        {
          items: "Pork",
          brand: "Any brand",
        },
        { items: "Beef", brand: "Any brand" },
        { items: "Pork", brand: "Any brand" },
        { items: "Beef", brand: "Any brand" },
      ],
      shopListPost: [
        {
          item: "Flour (1kg)",
          brand: "Any brand",
          units: "2",
        },
        {
          item: "Flour (1kg)",
          brand: "Any brand",
          units: "2",
        },
        {
          item: "Flour (1kg)",
          brand: "Any brand",
          units: "2",
        },
        {
          item: "Flour (1kg)",
          brand: "Any brand",
          units: "2",
        },
      ],
      shopListRequest1: [
        { items: "Flour (1kg)" },
        { items: "Vanilla extract (50ml)" },
        { items: "brown sugar" },
        { items: "cocoa powder" },
      ],
      shopListRequest2: [
        { items: "baking soda" },
        { items: "Chocolate syrup" },
        { items: "powdered sugar" },
        { items: "cocoa powder" },
      ],
      popUp: [{ pop: true }, { pop: true }, { pop: true }],
      sendOfferOrRequestpost: null,
      sendOfferOrRequestpostNum: null,
      sortedAllPosts: [],
      filteringPosts: [],
      filter2Value: "Nearby",
      filter1Value: "All Posts",
      filter1Logo: "view_stream",
      filter2Logo: "near_me", //popUp.pop[0]
      selectedList: [],
      showItemList: false,
      listToggleFlag: false,
      listError: "",
      ctr: 0,
      limit_by: 4,
      default_limit: 4,
      showListStatus: "See More",
      showLessStatus: "See Less",
      isActive: false,
      brands: null,
    };
  },
  components: {
    Navbar,
    PostModal,
    EditShoppingOfferPostVue,
    UpdateOfferStatus,
    SendRequest,
    createShopList,
    EditOrderRequest,
    UpdateOrderStatus,
    SendOffer,
  },
  watch: {
    posts() {
      this.sortPosts();
      this.changeFilter();
    },
    allShares() {
      this.sortPosts();
      this.changeFilter();
    },
  },
  methods: {
    deleteShared(postNum) {
      api.delete("api/sharedPost/" + postNum + "/delete").then(() => {
        store.dispatch("getAllShares").then(() => {
          this.sortPosts();
          this.changeFilter();
        });
      });
    },
    copyThisLink(postNumber) {
      var temp = JSON.parse(JSON.stringify(this.posts));
      var temp2 = temp.filter((x) => {
        return x.postNumber === postNumber;
      });

      console.log("temp2", temp2[0]);

      if (temp2[0].postIdentity == "request_post") {
        var link =
          "http://localhost:8080/OrderRequestSinglePage?post=" +
          this.toEncrypt(JSON.stringify(postNumber));
        return link;
      } else {
        var link2 =
          "http://localhost:8080/ShoppingOfferSinglePage?post=" +
          this.toEncrypt(JSON.stringify(postNumber));
        return link2;
      }
    },
    copyLink(postNum) {
      var copyText = document.getElementById("myInput" + postNum);

      const textToCopy = copyText.value;
      navigator.clipboard
        .writeText(textToCopy)
        .then(() => {
          alert(`Copied!`);
        })
        .catch((error) => {
          alert(`Copy failed! ${error}`);
        });
    },
    setCookie() {
      this.popupTriggers.timedTrigger = false;
      sessionStorage.setItem("sessionCookieNotify", false);
    },
    setBrand(index) {
      document.getElementById("brand").value = document.getElementById(
        "brand" + index
      ).innerHTML;
    },
    brand() {
      let vm = this;
      this.debounceSearchBrand(vm);
      console.log("brandssssssssssssss", this.brands);
    },
    debounceSearchBrand: _.debounce((vm) => {
      var data = document.getElementById("brand").value;
      var brand = data.replace(" ", "%20");
      var returnBrands = [];
      console.log(brand);
      var link =
        "https://api.edamam.com/api/food-database/v2/parser?ingr=" +
        brand +
        "&app_id=df56563c&app_key=2ac03d7a37a55354a941d0e1289ac4b2";
      //get the mathced brand names from product brands api
      axios
        .get(link)
        .then((res) => {
          //then set the result to array
          console.log("search res: ", res.data);
          for (var i = 0; i < res.data.hints.length; i++) {
            console.log("brands: ", res.data.hints[i].food.brand);
            returnBrands.push(res.data.hints[i].food.label);
          }
          var temp = returnBrands;
          returnBrands = [];
          $.each(temp, function (i, el) {
            if ($.inArray(el, returnBrands) === -1) returnBrands.push(el);
          });
          console.log("returnint this", returnBrands);
          vm.brands = returnBrands;
        })
        .catch(() => {
          vm.brands = null;
        });
    }, 1000),
    editListFromDashboard() {
      this.Editlist = true;
      this.option_more = false;
      this.new_items = this.shoppingLists[0].shoppingListContent;
      this.ctr =
        this.shoppingLists[0].shoppingListContent[
          this.shoppingLists[0].shoppingListContent.length - 1
        ].id + 1;
    },
    deleteList() {
      this.new_items = [];
      console.log(this.new_items);
    },
    minusQty(q) {
      q--;
      if (q <= 0) return 1;
      return q;
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
    computedShopItemList(list) {
      if (list != null) {
        var temp = list.filter((x) => {
          return x.status == 1;
        });
        return this.limit_by ? temp.slice(0, this.limit_by) : temp;
      }
      return null;
    },
    isFew(filter_itemList) {
      filter_itemList.length < 5;
    },
    next_swap_order() {
      let x = this.or_shift;
      let y = this.confirmedOrders.length;
      if (x < y - 1) {
        [this.confirmedOrders[0], this.confirmedOrders[x + 1]] = [
          this.confirmedOrders[x + 1],
          this.confirmedOrders[0],
        ];
        this.or_shift++;
      }
    },
    prev_swap_order() {
      if (this.or_shift > 0) {
        [this.confirmedOrders[0], this.confirmedOrders[this.or_shift]] = [
          this.confirmedOrders[this.or_shift],
          this.confirmedOrders[0],
        ];
        this.or_shift--;
      }
    },
    next_swap_deliver() {
      let x = this.shift;
      let y = this.confirmedDeliveries.length;
      if (x < y - 1) {
        [this.confirmedDeliveries[0], this.confirmedDeliveries[x + 1]] = [
          this.confirmedDeliveries[x + 1],
          this.confirmedDeliveries[0],
        ];
        this.shift++;
      }
    },
    prev_swap_deliver() {
      if (this.shift > 0) {
        [this.confirmedDeliveries[0], this.confirmedDeliveries[this.shift]] = [
          this.confirmedDeliveries[this.shift],
          this.confirmedDeliveries[0],
        ];
        this.shift--;
      }
    },

    view_list(e) {
      let x = document.getElementById(e);
      if (x.style.display === "none") {
        x.style.display = "block";
      } else {
        x.style.display = "none";
      }
    },
    add_newItem() {
      let x = document.getElementById("product").value;
      let y = document.getElementById("brand").value;
      let z = document.getElementById("size").value;
      let n = this.quantity;
      if (x != "") {
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
        this.new_item = false;
        this.list_number++;
        console.log(this.new_items);
      } else {
        alert("Empty Field");
        return false;
      }
    },
    title_edit(e, m) {
      //const index = this.shopping_list.findIndex(x=>x.id==e);
      let x = document.getElementById(e);
      let n = document.getElementById(m);
      if (x.style.display === "none") {
        x.style.display = "block";
        n.style.display = "none";
      } else {
        x.style.display = "none";
        n.style.display = "block";
      }
      //alert(index);
    },
    updateShoppinglist(listNumber) {
      // let new_time = new Date();
      // let timex = new_time.toLocaleTimeString();
      // let datex = new_time.toDateString();
      // let new_date = datex + " " + timex;
      if (this.new_items.length <= 0) {
        this.listError = "Please add at least one item";
        return;
      }
      for (var i = 0; i < this.new_items.length; i++) {
        if (
          !document.getElementById("checkEdit" + this.new_items[i].id).checked
        ) {
          //if true check the status
          this.new_items[i].status = 0;
        } else {
          this.new_items[i].status = 1;
        }
      }
      let obj = {
        listName: document.getElementById("new_title").value,
        list: this.new_items,
      };

      this.shopping_list.push(obj);
      api
        .post("api/editList/" + listNumber, obj)
        .then((res) => {
          console.log("edit", res.data);
          store.dispatch("getUserShoppingList").then(() => {
            this.selectedList = res.data;
            this.showItemList = true;
            this.new_items = [];
            this.Editlist = false;
            if (this.listToggleFlag) this.togglePostModal();
            this.listToggleFlag = false;
            this.listError = "";
          });
        })
        .catch((error) => {
          if (error.response.data.list == null) error.response.data.list = "";
          if (error.response.data.listName == null)
            error.response.data.listName = "";
          this.listError =
            error.response.data.list + error.response.data.listName;
        });
    },
    deleteListFrom() {
      console.log("delete");
      this.toggle_delete = false;
      api
        .delete("api/deleteList/" + this.shoppingLists[0].shoppingListNumber)
        .then(() => {
          store.dispatch("getUserShoppingList");
          this.shoppingLists.shift();
        })
        .catch((e) => {
          console.log(e.response.data.error);
        });
    },
    add_item_shopping_list(a, b, c, e) {
      let productx = document.getElementById(a).value;
      let brandx = document.getElementById(b).value;
      let sizex = document.getElementById(c).value;
      let quantx = document.getElementById(e).innerHTML;
      if (productx == "") {
        alert("Empty Field");
        return false;
      }
      let obj = {
        id: this.ctr,
        product: productx,
        brand: brandx,
        size: sizex,
        quantity: parseInt(quantx),
        status: 1,
        statusDeliver: 0,
      };
      this.ctr++;
      this.new_items.push(obj);
      // console.log(this.shoppingLists[0].shoppingListContent);
      document.getElementById(a).value = "";
      document.getElementById(b).value = "";
      document.getElementById(c).value = "";
      this.new_item = false;
    },
    add_shopping_list() {
      // let bagotitle = document.getElementById("new_title").value;

      // let new_time = new Date();
      // let timex = new_time.toLocaleTimeString();
      // let datex = new_time.toDateString();
      // let new_date = datex + " " + timex;

      for (var i = 0; i < this.new_items.length; i++) {
        if (!document.getElementById("check" + this.new_items[i].id).checked) {
          //if true check the status
          this.new_items[i].status = 0;
        }
      }
      let obj = {
        listName: document.getElementById("new_title").value,
        list: this.new_items,
      };
      console.log(this.new_items);
      this.shopping_list.push(obj);
      api
        .post("api/createList", obj)
        .then((res) => {
          store.dispatch("getUserShoppingList").then(() => {
            this.selectedList = res.data;
            this.showItemList = true;
            console.log("before", this.selectedList, this.showItemList);
            this.new_items = [];
            this.addlist = false;
            if (this.listToggleFlag) this.togglePostModal();
            this.listToggleFlag = false;
          });
        })
        .catch(() => {
          //if encountered error means the user will not add a new shopping list
          this.new_items = [];
          this.addlist = false;
        });
    },

    togglePostModal() {
      this.postModalVisible = !this.postModalVisible;
    },
    togglePostModal1() {
      this.postModalVisible1 = !this.postModalVisible1;
    },
    togglePostModal2() {
      this.postModalVisible2 = !this.postModalVisible2;
    },
    toggleSendModal() {
      this.postSendModal = !this.postSendModal;
    },
    toggleChatModal() {
      this.postChatModal = !this.postChatModal;
    },
    listener() {
      this.postModalVisible = false;
      this.showItemList = false;
      this.selectedList = [];
    },
    listener1() {
      this.postModalVisible1 = false;
      this.edit1 = !this.edit1;
    },
    listener2() {
      this.postModalVisible2 = false;
      this.edit1 = !this.edit1;
    },
    listener3() {
      this.postSendModal = false;
    },
    toggleeditShopList() {
      this.editVisible = !this.editVisible;
    },
    editlistener() {
      this.editVisible = false;
    },
    togglecreateShopList() {
      this.createShopList = !this.createShopList;
    },
    listener6() {
      this.createShopList = false;
    },
    toggleEditOrderRequest() {
      this.editOrderRequest = !this.editOrderRequest;
    },
    listener5() {
      this.editOrderRequest = false;
    },
    share(postNumber) {
      var shareData = { postNum: postNumber };
      api
        .post("/api/share", shareData)
        .then(() => {
          this.popUp3 = true;
          this.share1 = false;
          store.dispatch("getAllShares").then(() => {
            this.sortPosts();
            this.changeFilter();
          });
        })
        .catch((error) => {
          VueSimpleAlert.alert("An error occured", "Error", "error");
          console.log(error);
        });
    },
    toEncrypt(val) {
      return btoa(val);
    },
    dispatchSinglePage(transactNum) {
      var temp = JSON.parse(JSON.stringify(this.confirmedOrders));
      var temp2 = temp.filter((x) => {
        return x.transactionNumber === transactNum;
      });
      console.log("yrmp2", temp2);
      if (temp2.length <= 0) {
        temp = JSON.parse(JSON.stringify(this.confirmedDeliveries));
        temp2 = temp.filter((x) => {
          return x.transactionNumber === transactNum;
        });
        console.log("in deliveries", temp2);
        this.$router.push({
          name: "singlePostDelivery",
          query: { transaction: this.toEncrypt(JSON.stringify(temp2)) },
        });
        return;
      }
      console.log("in orders", temp2);

      this.$router.push({
        name: "singlePostOrder",
        query: { transaction: this.toEncrypt(JSON.stringify(temp2)) },
      });
      return;
    },
    changeFilter() {
      var i;
      if (this.filter1Value === "All Posts") {
        if (this.filter2Value === "Nearby") {
          // all posts nearby
          this.sortedAllPosts = this.filteringPosts.filter((x) => {
            if (x.indexShare == null) {
              //for posts
              if (x.postIdentity == "offer_post") {
                return (
                  x.offer_post.deliveryArea.includes(
                    this.userHomeAddress.province
                  ) || x.email == this.user.email
                );
              } else {
                return (
                  x.request_post.deliveryAddress.includes(
                    this.userHomeAddress.province
                  ) || x.email == this.user.email
                );
              }
            } else {
              //for shared posts
              if (x.post.postIdentity == "offer_post") {
                return (
                  x.post.offer_post.deliveryArea.includes(
                    this.userHomeAddress.province
                  ) || x.email == this.user.email
                );
              } else {
                return (
                  x.post.request_post.deliveryAddress.includes(
                    this.userHomeAddress.province
                  ) || x.email == this.user.email
                );
              }
            }
          });
        } else {
          //all posts following
          this.sortedAllPosts = this.filteringPosts.filter((x) => {
            if (x.indexShare == null) {
              //for posts
              for (i = 0; i < this.authfollowing.length; i++) {
                if (this.authfollowing[i].email1.email === this.user.email) {
                  return x.email === this.authfollowing[i].email2.email;
                } else {
                  return x.email === this.authfollowing[i].email1.email;
                }
              }
            } else {
              //for shares
              for (i = 0; i < this.authfollowing.length; i++) {
                if (this.authfollowing[i].email1.email === this.user.email) {
                  return x.sharerEmail === this.authfollowing[i].email2.email;
                } else {
                  return x.sharerEmail === this.authfollowing[i].email1.email;
                }
              }
            }
          });
        }
      } else if (this.filter1Value === "Shopping Offer") {
        if (this.filter2Value === "Nearby") {
          // shopping offer nearby
          this.sortedAllPosts = this.filteringPosts.filter((x) => {
            if (x.indexShare == null) {
              //for posts
              if (x.postIdentity == "offer_post") {
                return x.offer_post.deliveryArea.includes(
                  this.userHomeAddress.province
                );
              }
            } else {
              //for shared posts
              if (x.post.postIdentity == "offer_post") {
                return x.post.offer_post.deliveryArea.includes(
                  this.userHomeAddress.province
                );
              }
            }
          });
        } else {
          //shopping offer following
          this.sortedAllPosts = this.filteringPosts.filter((x) => {
            if (x.indexShare == null) {
              //for posts
              if (x.postIdentity === "offer_post") {
                for (i = 0; i < this.authfollowing.length; i++) {
                  if (this.authfollowing[i].email1.email === this.user.email) {
                    return x.email === this.authfollowing[i].email2.email;
                  } else {
                    return x.email === this.authfollowing[i].email1.email;
                  }
                }
              }
            } else {
              //for shares
              if (x.post.postIdentity === "offer_post") {
                for (i = 0; i < this.authfollowing.length; i++) {
                  if (this.authfollowing[i].email1.email === this.user.email) {
                    return x.sharerEmail === this.authfollowing[i].email2.email;
                  } else {
                    return x.sharerEmail === this.authfollowing[i].email1.email;
                  }
                }
              }
            }
          });
        }
      } else if (this.filter1Value === "Order Requests") {
        if (this.filter2Value === "Nearby") {
          // shopping offer nearby
          this.sortedAllPosts = this.filteringPosts.filter((x) => {
            if (x.indexShare == null) {
              //for posts
              if (x.postIdentity == "request_post") {
                return x.request_post.deliveryAddress.includes(
                  this.userHomeAddress.province
                );
              }
            } else {
              //for shared posts
              if (x.post.postIdentity == "request_post") {
                return x.post.request_post.deliveryAddress.includes(
                  this.userHomeAddress.province
                );
              }
            }
          });
        } else {
          //shopping offer following
          this.sortedAllPosts = this.filteringPosts.filter((x) => {
            if (x.indexShare == null) {
              //for posts
              if (x.postIdentity === "request_post") {
                for (i = 0; i < this.authfollowing.length; i++) {
                  if (this.authfollowing[i].email1.email === this.user.email) {
                    return x.email === this.authfollowing[i].email2.email;
                  } else {
                    return x.email === this.authfollowing[i].email1.email;
                  }
                }
              }
            } else {
              //for shares
              if (x.post.postIdentity === "request_post") {
                for (i = 0; i < this.authfollowing.length; i++) {
                  if (this.authfollowing[i].email1.email === this.user.email) {
                    return x.sharerEmail === this.authfollowing[i].email2.email;
                  } else {
                    return x.sharerEmail === this.authfollowing[i].email1.email;
                  }
                }
              }
            }
          });
        }
      }
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
    selectionSort(arr) {
      var minldx,
        temp,
        len = arr.length;
      for (var i = 0; i < len; i++) {
        minldx = i;
        for (var j = i + 1; j < len; j++) {
          if (arr[j].dateCreated > arr[minldx].dateCreated) {
            minldx = j;
          }
        }
        temp = arr[i];
        arr[i] = arr[minldx];
        arr[minldx] = temp;
      }
      return arr;
    },
    sortPosts() {
      var allPosts = this.posts.concat(this.allShares);
      this.sortedAllPosts = this.selectionSort(allPosts);
      this.filteringPosts = this.sortedAllPosts;
      console.log("mark: ", this.posts);
    },
    deletePost(postNum) {
      api.delete("api/post/" + postNum + "/delete").then(() => {
        store.dispatch("getPosts").then(() => {
          this.sortPosts();
          this.changeFilter();
        });
      });
    },
    next_swap_list() {
      let x = this.s_shift;
      let y = this.shoppingLists.length;
      if (x < y - 1) {
        [this.shoppingLists[0], this.shoppingLists[x + 1]] = [
          this.shoppingLists[x + 1],
          this.shoppingLists[0],
        ];
        this.s_shift++;
      }
    },
    prev_swap_list() {
      if (this.s_shift > 0) {
        [this.shoppingLists[0], this.shoppingLists[this.s_shift]] = [
          this.shoppingLists[this.s_shift],
          this.shoppingLists[0],
        ];
        this.s_shift--;
      }
    },
    showOfferShareModal() {
      ////without 3 dot menu when share post modal is open
      var container = $("#shopOffer-UserPost");
      var clonedContainer = container
        .clone()
        .css({ padding: "0", float: "none" });
      clonedContainer.find("#3dotmenu").remove();
      clonedContainer.appendTo(".modal-body");

      ////with 3 dot menu when share post modal is open
      //$('#shopOffer-UserPost').clone().css({padding: '0', float: 'none'}).appendTo('.modal-body');

      $("#modal-background").css({ display: "flex" });
      $(".target").hide();
      this.share1 = !this.share1;
    },
    showOrderShareModal() {
      //without 3 dot menu when share post modal is open
      var container = $("#shopOrder-UserPost");
      var clonedContainer = container
        .clone()
        .css({ padding: "0", float: "none" });
      clonedContainer.find("#3dotmenu").remove();
      clonedContainer.appendTo(".modal-body");
      //with 3 dot menu when share post modal is open
      //$('#shopOrder-UserPost').clone().css({padding: '0', float: 'none'}).appendTo('.modal-body');
      $("#modal-background").css({ display: "flex" });
      $(".target").hide();
      this.share2 = !this.share2;
    },
    hideShareModal() {
      $("#modal-background").css({ display: "none" });
      $("#modal-background").find(".modal-body").empty();
    },
    showShareDisplay() {
      //without 3dot menu when shared
      var container = $("#shopOffer-UserPost");
      var clonedContainer = container
        .clone()
        .css({ padding: "0", float: "none" });
      clonedContainer.find("#3dotmenu").remove();
      clonedContainer.find("#changeBoxRadius").css({
        "border-top-left-radius": "0px",
        "border-top-right-radius": "0px",
        "box-shadow": "none",
      });
      $("display-header").find("#closeButton").remove();
      $("#display-footer").css({ padding: "0" }).remove();
      clonedContainer.appendTo(".display-body");
      $("#display-sharedPost").css({ display: "flex" });
      //with 3dot menu when shared
      //$('#shopOffer-UserPost').find('#changeBoxRadius').css({"border-top-left-radius": "0px","border-top-right-radius": "0px"})
      //$('#shopOffer-UserPost').find('#3dotmenu').remove()
      //$('#shopOffer-UserPost').clone().css({padding: '0', float: 'none'}).appendTo('.display-body');
      //$('display-header').find('#closeButton').empty();
      //$('#display-footer').css({padding: '0'}).empty();
      $(".target").hide();
      this.share1 = !this.share1;
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
    posts() {
      return store.getters.getPosts.filter((x) => {
        return (
          x.postStatus == "Accepting Requests" ||
          x.postStatus == "Accepting Offer"
        );
      });
    },
    allShares() {
      return store.getters.getAllShares.filter((x) => {
        return (
          x.post.postStatus == "Accepting Requests" ||
          x.post.postStatus == "Accepting Offer"
        );
      });
    },
    shoppingLists() {
      return store.getters.getUserShoppingList;
    },
    authfollowing() {
      return store.getters.getAuthUserFollow.filter((x) => {
        if (x.email1.email == this.user.email) {
          return x.email1FollowEmail2 == 1;
        } else if (x.email2.email == this.user.email) {
          return x.email2FollowEmail1 == 1;
        }
      });
    },
    confirmedOrders() {
      return store.getters.getUserTransactions.filter((x) => {
        return (
          (x.transactionStatus == "Confirmed" ||
            x.transactionStatus == "confirmed" ||
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
            x.transactionStatus == "confirmed" ||
            x.transactionStatus == "In Transit") &&
          ((x.post.postIdentity == "request_post" &&
            x.post.email != this.user.email) ||
            (x.post.postIdentity == "offer_post" &&
              x.post.email == this.user.email))
        );
      });
    },
    reviews() {
      return store.getters.getAllReviews;
    },
    userHomeAddress() {
      return store.getters.getAddress;
    },
  },
  mounted() {
    this.sortPosts();
    this.changeFilter();
  },
};
</script>
<style scoped>
#fkmouse {
  pointer-events: none;
}
#modal-background {
  display: none;
  position: fixed;
  justify-content: center;
  align-items: center;
  background-color: rgba(0, 0, 0, 0.3);
  top: 0;
  bottom: 0;
  right: 0;
  left: 0;
}
#display-sharedPost {
  display: none;
}
::-webkit-scrollbar {
  width: 0px;
  background: transparent; /* make scrollbar transparent */
}
</style>