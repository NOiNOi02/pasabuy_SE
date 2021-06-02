<template>
  <!--post comment-->
  <div
    class="flex flex-col bg-gray-100 pt-6 font-nunito h-scrren ssm:h-auto pb-6 ssm:pb-6 vs:h-auto vs:pb-6 sm:pb-6 w-full min-w-0 px-2"
  >
    <!--Modal-->
    <div v-if="userID === user.email">
      <PostModal v-if="postModalVisible" @closeModal="listener" />
      <!--end-->
      <div class="flex items-center justify-center">
        <div
          class="inline-flex space-x-4 ssm:space-x-2 items-center vs:w-full sm:w-full ssm:w-full ssm:p-2 justify-center vs:p-4 p-6 bg-white shadow rounded-xl"
        >
          <img
            class="w-14 h-14 vs:w-10 vs:h-10 ssm:w-10 ssm:h-10 rounded-full"
            :src="user.profilePicture"
          />
          <button
            @click="togglePostModal"
            class="flex items-center focus:outline-none justify-start lvs:text-sm vs:text-xs ssm:text-xs text-base outline-none leading-none text-gray-500 py-5 pl-6 bg-gray-100 rounded-full vs:h-12 ssm:h-10 h-14 w-448 vs:w-full ssm:w-full"
          >
            Post a shopping offer
          </button>
        </div>
      </div>
    </div>
    <!--end-->

    <!--user post-->
    <div
      v-for="shoppingOffer_info in shoppingOffer_infos"
      v-bind:key="shoppingOffer_info.offer_post.indexShoppingOfferPost"
      class="flex items-center justify-center pt-6"
    >
      <div
        class="space-x-4 h-auto p-6 vs:p-4 ssm:p-2 ssm:w-full vs:w-full sm:w-full w-608 bg-white shadow rounded-xl"
      >
        <div class="flex flex-col items-start justify-start">
          <!--section 1-->
          <div class="flex flex-grow flex-wrap flex-row w-full justify-between">
            <div class="inline-flex">
              <img
                class="w-14 h-14 vs:w-10 vs:h-10 ssm:w-10 ssm:h-10 rounded-full"
                :src="shoppingOffer_info.user.profilePicture"
              />
              <div
                class="flex flex-col items-start w-full vs:px-1 se:px-2 ssm:px-2 px-4"
              >
                <div
                  class="space-x-4 ssm:space-x-0 se:flex-col se:space-x-0 ssm:flex-col vs:space-x-1 sm:space-x-2 flex flex-row mt-1"
                >
                  <p
                    class="ssm:text-xs vs:text-xs lvs:text-sm text-base font-bold leading-none text-gray-900"
                  >
                    <router-link to="/edit-profile"
                      >{{ shoppingOffer_info.user.firstName }}
                      {{ shoppingOffer_info.user.lastName }}</router-link
                    >
                    <span
                      v-show="ifUserVerified(shoppingOffer_info.email)"
                      class="text-blue-900 align-middle material-icons md-18"
                    >
                      verified
                    </span>
                  </p>
                  <p
                    class="ssm:text-xs vs:text-xs lvs:text-sm text-base leading-none text-gray-500"
                  >
                    posted a shopping offer
                  </p>
                </div>
                <div class="vs:flex vs:w-full ssm:w-full ssm:flex vs:pb-2">
                  <span
                    class="text-sm ssm:text-xs vs:text-xs lvs:text-sm leading-none text-gray-500"
                    >{{ timestamp(shoppingOffer_info.dateCreated) }}</span
                  >
                </div>
              </div>
            </div>
            <!--- 3 dots, show only for owner of post-->
            <div v-if="userID === user.email" class="vs:mt-1">
              <button
                @click="
                  (edit1 = !edit1),
                    (shoppingOffer_postNumber =
                      shoppingOffer_info.offer_post.indexShoppingOfferPost)
                "
                class="focus:outline-none"
              >
                <img
                  class="w-6 vs:w-4 lvs:w-5 ssm:w-4 h-auto"
                  src="img/3dot.svg"
                />
              </button>
              <div class="flex w-full">
                <div
                  v-if="
                    edit1 &&
                    shoppingOffer_postNumber ==
                      shoppingOffer_info.offer_post.indexShoppingOfferPost
                  "
                  class="absolute py-2 pt-2 pl-2 pr-4 leading-loose bg-white rounded-lg shadow-xl ssm:right-5 vs:right-5 sm:right-5 lg:right-56 md:right-24 xl:right-91 h-min w-30"
                >
                  <EditShoppingOfferPostVue
                    v-if="
                      postModalVisible1 &&
                      shoppingOffer_postNumber ==
                        shoppingOffer_info.offer_post.indexShoppingOfferPost
                    "
                    :btnText="shoppingOffer_info"
                    @closeModal1="listener1"
                  />
                  <!-- show only if the post is accepting requests-->
                  <button
                    v-if="shoppingOffer_info.postStatus == 'Accepting Requests'"
                    @click="togglePostModal1"
                    class="flex flex-row gap-x-2 text-base focus:outline-none"
                  >
                    <span class="font-medium text-gray-500 material-icons">
                      mode
                    </span>
                    Edit Post
                  </button>
                  <UpdateOfferStatus
                    v-if="
                      postModalVisible2 &&
                      shoppingOffer_postNumber ==
                        shoppingOffer_info.offer_post.indexShoppingOfferPost
                    "
                    :post="shoppingOffer_info"
                    @closeModal2="listener2"
                  />
                  <button
                    @click="togglePostModal2"
                    v-if="shoppingOffer_info.postStatus == 'Accepting Requests'"
                    class="flex flex-row font-normal text-base focus:outline-none gap-x-2"
                  >
                    <span class="font-normal text-gray-500 material-icons">
                      autorenew
                    </span>
                    Update Status
                  </button>
                  <button
                    @click="deletePost(shoppingOffer_info.postNumber)"
                    class="flex flex-row gap-x-2 text-base"
                  >
                    <span class="text-gray-500 material-icons">delete</span
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
            v-if="shoppingOffer_info.postStatus != 'Accepting Requests'"
          >
            <span class="rounded-full material-icons text-red-600">
              remove_circle_outline
            </span>
            <p
              class="text-sm vs:text-xs ssm:text-xs lvs:text-sm font-bold leading-none items-center text-red-600"
            >
              {{ shoppingOffer_info.postStatus }}
            </p>
          </div>
          <div
            class="inline-flex mt-4 items-center space-x-2 justify-start px-2 py-1 bg-gray-100 rounded-full text-green-600"
            v-if="shoppingOffer_info.postStatus == 'Accepting Requests'"
          >
            <span class="rounded-full material-icons">
              remove_circle_outline
            </span>
            <p
              class="text-sm vs:text-xs ssm:text-xs lvs:text-sm font-bold leading-none items-center"
            >
              {{ shoppingOffer_info.postStatus }}
            </p>
          </div>
          <!--end-->

          <!--section 3-->
          <div
            class="flex ssm:flex-col ssm:items-start ssm:space-x-0 vs:flex-col vs:items-start items-center justify-start mt-4 w-full space-x-4 vs:space-x-0"
          >
            <div class="flex-col items-start w-full">
              <div class="flex space-x-2">
                <span class="w-6 h-6 rounded-full material-icons text-red-600">
                  delivery_dining
                </span>
                <p
                  class="text-sm ssm:text-xs vs:text-xs lvs:text-sm leading-none text-gray-900 py-1"
                >
                  {{ shoppingOffer_info.offer_post.deliveryArea }}
                </p>
              </div>
              <div class="flex space-x-2 py-2">
                <span class="w-6 h-6 rounded-full material-icons text-red-600">
                  alarm
                </span>
                <p
                  class="text-sm ssm:text-xs vs:text-xs lvs:text-sm leading-none text-gray-900 py-1"
                >
                  {{
                    timestampSched(
                      shoppingOffer_info.offer_post.deliverySchedule
                    )
                  }}
                </p>
              </div>
              <div class="flex space-x-2">
                <span class="w-6 h-6 rounded-full material-icons text-red-600">
                  shopping_bag
                </span>
                <p
                  class="text-sm ssm:text-xs vs:text-xs lvs:text-sm leading-none text-gray-900 py-1"
                >
                  {{ shoppingOffer_info.offer_post.capacity }}
                </p>
              </div>
            </div>
            <div class="flex-col w-full ssm:py-2 vs:py-3">
              <div class="flex space-x-2">
                <span class="w-6 h-6 rounded-full material-icons text-red-600">
                  shopping_cart
                </span>
                <p
                  class="text-sm ssm:text-xs vs:text-xs lvs:text-sm leading-none text-gray-900 py-1"
                >
                  {{ shoppingOffer_info.offer_post.shoppingPlace }}
                </p>
              </div>
              <div class="flex space-x-2 py-2">
                <span class="w-6 h-6 rounded-full material-icons text-red-600">
                  directions_car
                </span>
                <p
                  class="text-sm ssm:text-xs vs:text-xs lvs:text-sm leading-none text-gray-900 py-1"
                >
                  {{ shoppingOffer_info.offer_post.transportMode }}
                </p>
              </div>
              <div class="flex space-x-2">
                <span class="w-6 h-6 rounded-full material-icons text-red-600">
                  payments
                </span>
                <p
                  class="text-sm ssm:text-xs vs:text-xs lvs:text-sm leading-none text-gray-900 py-1"
                >
                  {{ shoppingOffer_info.offer_post.paymentMethod }}
                </p>
              </div>
            </div>
          </div>
          <!--end-->

          <!--section 4-->
          <div
            v-if="shoppingOffer_info.offer_post.caption != null"
            class="flex flex-grow-0 mt-4 ssm:mt-2 vs:mt-2 w-full items-start justify-start p-4 bg-gray-100 rounded-xl"
          >
            <p
              class="text-sm ssm:text-xs vs:text-xs lvs:text-sm leading-loose text-gray-900 h-auto w-full vs:min-w-0 vs:px-2"
            >
              {{ shoppingOffer_info.offer_post.caption }}
            </p>
          </div>
          <!--section 4-->
          <!--section 5: Request Received-->

          <div
            class="flex flex-col justify-start items-start w-full space-y-2.5 mt-4"
            v-show="shoppingOffer_info.email == user.email"
          >
            <hr class="w-full" />
            <div
              class="inline-flex justify-start items-center flex-row space-x-4"
            >
              <p class="text-base font-bold leading-none text-gray-900">
                Requests Received
              </p>
              <div class="inline-flex px-2 py-1 bg-red-700 rounded-full">
                <p class="text-base font-bold leading-none text-white">
                  {{
                    maxOffersReceived(shoppingOffer_info.postNumber)
                  }}
                </p>
              </div>
            </div>

            <div
              class="flex-auto flex-col w-full vs:px-0 px-2 space-y-3.5 pb-2 pt-2"
            >
              <div
                class="flex flex-row justify-between"
                v-for="(transaction, index) in computedOffersReceived(
                  shoppingOffer_info.postNumber
                )"
                :key="index"
              >
                <div class="flex flex-row vs:space-x-1 space-x-2 items-center">
                  <img
                    class="w-10 h-10 vs:w-8 vs:h-8 rounded-full"
                    :src="transaction.transaction_sender.profilePicture"
                  />
                  <div class="flex flex-col space-y-1">
                    <div class="flex flex-row vs:space-x-1 space-x-2">
                      <p
                        class="text-base vs:text-xs ssm:text-xs font-bold leading-none text-gray-900"
                      >
                        {{ transaction.transaction_sender.firstName }}
                        {{ transaction.transaction_sender.lastName }}
                      </p>
                      <span
                        v-show="
                          ifUserVerified(transaction.transaction_sender.email)
                        "
                        class="text-blue-900 align-middle material-icons md-14"
                      >
                        verified
                      </span>
                    </div>
                    <p
                      class="text-sm vs:text-xs ssm:text-xs leading-none text-gray-500"
                    >
                      {{ timestamp(transaction.dateCreated) }}
                    </p>
                  </div>
                </div>
                <div class="flex flex-row items-center vs:space-x-1 space-x-2">
                  <button
                    @click="viewDetailsBtn(transaction.transactionNumber)"
                    class="focus:outline-none inline-flex items-start justify-start vs:px-2 vs:py-1 px-3 py-2 bg-red-700 rounded-full"
                  >
                    <p
                      class="text-sm vs:text-xs ssm:text-xs font-bold leading-none text-white"
                    >
                      View Details
                    </p>
                  </button>
                  <div>
                    <button
                      @click="
                        threeDotUser = transaction.transactionNumber;
                        threeDot = !threeDot;
                      "
                      class="focus:outline-none mt-1.5"
                    >
                      <span class="material-icons vs:text-xs"> more_vert </span>
                    </button>
                    <div class="relative w-full">
                      <div
                        v-if="
                          threeDotUser == transaction.transactionNumber &&
                          threeDot
                        "
                        class="absolute p-2 leading-loose rounded-lg border-2 border-gray-100 bg-white right-0 w-30"
                      >
                        <router-link
                          :to="
                            '/messages/?ID=' +
                            toEncrypt(transaction.transaction_sender.email)
                          "
                          class="flex flex-row items-center font-normal text-base leading-none text-gray-900 focus:outline-none gap-x-2"
                        >
                          <span class="material-icons text-base text-gray-900">
                            forum
                          </span>
                          Chat
                        </router-link>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="flex flex-row w-full justify-between items-center">
              <button
                @click="viewMoreviewLess(shoppingOffer_info.postNumber)"
                v-if="!isFew2(shoppingOffer_info.postNumber)"
                class="focus:outline-none inline-flex text-base font-bold leading-none text-gray-500"
              >
                {{ viewMoreStatus }}
              </button>
              <p
                class="inline-flex text-base font-bold leading-none text-gray-500"
              >
                {{
                  computedOffersReceived(shoppingOffer_info.postNumber).length
                }}
                of {{ maxOffersReceived(shoppingOffer_info.postNumber) }}
              </p>
            </div>
          </div>

          <!--section 5-->
          <div
            v-if="
              shoppingOffer_info.email != user.email &&
              shoppingOffer_info.postStatus === 'Accepting Requests'
            "
            class="flex justify-evenly w-full vs:space-x-3 vs:min-w-0 vs:px-2 ssm:space-x-1 ssm:px-0 pr-8 ssm:pr-0 vs:pr-0 mt-4 space-x-6"
          >
            <SendRequest
              v-if="
                postSendModal &&
                sendOfferOrRequestpostNum ==
                  shoppingOffer_info.offer_post.postNumber
              "
              @closeSendRequest="listener3"
              :post="shoppingOffer_info"
            />
            <button
              @click="
                toggleSendModal();
                sendOfferOrRequestpostNum =
                  shoppingOffer_info.offer_post.postNumber;
              "
              class="flex focus:outline-none items-center space-x-2 ssm:space-x-1"
            >
              <span class="pr-2 ssm:pr-0 material-icons md-24"> send </span>
              <p
                class="text-base ssm:text-xs vs:text-xs lvs:text-sm font-bold leading-none text-gray-600"
              >
                Send Request
              </p>
            </button>
            <router-link
              :to="'/messages/?ID=' + toEncrypt(shoppingOffer_info.email)"
            >
              <button
                class="flex focus:outline-none items-center space-x-2 ssm:space-x-1"
              >
                <span class="pr-2 ssm:pr-0 material-icons md-24"> forum </span>
                <p
                  class="text-base ssm:text-xs vs:text-xs lvs:text-sm font-bold leading-none text-gray-600"
                >
                  Chat
                </p>
              </button>
            </router-link>
            <div>
              <button
                @click="
                  share1 = !share1;
                  share2 = shoppingOffer_info.postNumber;
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
                  v-show="share2 == shoppingOffer_info.postNumber && share1"
                  class="absolute z-30 py-2 pt-2 pl-2 pr-4 leading-loose bg-white rounded-lg shadow-xl ssm:right-5 vs:right-5 sm:right-5 lg:right-2 md:right-24 xl:right-91 h-min w-30"
                >
                  <button
                    @click="share(shoppingOffer_info.postNumber)"
                    class="flex flex-row text-base gap-x-2 vs:text-sm ssm:text-sm xsm:text-sm focus:outline-none"
                  >
                    <span
                      class="font-medium text-gray-500 material-icons x-v:md-16"
                    >
                      share
                    </span>
                    Share on Feed
                  </button>
                  <button
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
          <!--    
    -->
        </div>
      </div>
    </div>
    <!--end of user post-->

    <!--Share Modal-->
    <div
      @click.self="hideShareModal"
      id="modal-background"
      class="bg-opacity-25 z-50"
    >
      <div
        id="modal-content"
        class="flex-col w-608 space-y-4 px-2 bg-white h-auto rounded-lg"
      >
        <div
          id="modal-header"
          class="flex flex-row pt-4 space-x-4 px-2 justify-between items-center"
        >
          <button
            @click="$router.push('edit-profile')"
            class="focus:outline-none flex items-center space-x-4"
          >
            <img class="w-12 h-12 rounded-full" src="img/asta.jpeg" />
            <p class="text-base font-bold leading-none text-gray-900">
              Asta Staria
            </p>
          </button>
          <button
            @click="hideShareModal"
            class="focus:outline-none flex items-center"
          >
            <span
              class="text-gray-500 material-icons allign-middle"
              style="font-size: 36px"
            >
              cancel
            </span>
          </button>
        </div>
        <div id="fkmouse" class="modal-body cursor-not-allowed"></div>
        <div
          id="modal-footer"
          class="flex px-2 pb-4 items-center justify-center ssm:px-2 vs:px-2"
        >
          <button
            class="focus:outline-none inline-flex items-center justify-center px-4 py-2 bg-red-700 rounded-full w-full ssm:h-8 ssm:w-full vs:w-full"
          >
            <p
              class="text-base ssm:text-sm vs:text-sm lvs:text-base font-bold leading-normal text-center text-white"
            >
              Share Post
            </p>
          </button>
        </div>
      </div>
    </div>

    <!--view details/post Modal-->
    <div
      v-if="toggleViewDetails"
      class="z-50 fixed bg-black bg-opacity-25 inset-0 flex justify-center items-center ssm:px-2 vs:px-2"
    >
      <div
        class="hideMe1 inline-flex flex-col bg-white shadow rounded-xl h-auto w-97 space-y-4 p-4 ssm:w-full vs:w-full"
      >
        <div class="flex justify-between items-center flex-row">
          <button
            class="invisible focus:outline-none text-sm font-bold leading-none text-right text-indigo-900"
          >
            Back</button
          ><!--invisible, used only for auto margin header. If design need close button just delete the invisible class-->
          <p
            v-if="currentPostViewDetails.post.request_post != null"
            class="text-lg ssm:text-sm vs:text-base font-bold leading-normal text-center text-gray-900"
          >
            Offer from
            {{ currentPostViewDetails.transaction_sender.firstName }}
            {{ currentPostViewDetails.transaction_sender.lastName }}
          </p>
          <p
            v-else
            class="text-lg ssm:text-sm vs:text-base font-bold leading-normal text-center text-gray-900"
          >
            Request from
            {{ currentPostViewDetails.transaction_sender.firstName }}
            {{ currentPostViewDetails.transaction_sender.lastName }}
          </p>
          <button
            @click="
              toggleViewDetails = !toggleViewDetails;
              currentPostViewDetails = [];
            "
            class="focus:outline-none text-sm font-bold leading-none text-right text-indigo-900"
          >
            Close
          </button>
        </div>
        <hr class="w-full" />
        <div class="flex w-full flex-row items-center space-x-4">
          <img
            :src="currentPostViewDetails.transaction_sender.profilePicture"
            class="rounded-full w-10 h-10"
          />
          <div class="flex flex-col">
            <div class="flex-row flex space-x-1 items-center">
              <p class="text-base font-bold leading-none text-gray-900">
                {{ currentPostViewDetails.transaction_sender.firstName }}
                {{ currentPostViewDetails.transaction_sender.lastName }}
              </p>
              <span
                v-show="
                  ifUserVerified(
                    currentPostViewDetails.transaction_sender.email
                  )
                "
                class="text-blue-900 align-middle material-icons text-base"
              >
                verified
              </span>
            </div>
            <p class="text-sm leading-none text-gray-500">
              {{ timestamp(currentPostViewDetails.dateCreated) }}
            </p>
          </div>
        </div>
        <div class="flex flex-col w-full">
          <div class="flex space-x-2">
            <span class="w-6 h-6 rounded-full material-icons text-red-600">
              location_on
            </span>
            <p
              class="text-sm ssm:text-xs vs:text-xs lvs:text-sm leading-none text-gray-900 py-1"
            >
              {{ currentPostViewDetails.transactionData.deliveryAddress }}
            </p>
          </div>

          <div class="flex space-x-2 py-2">
            <span class="w-6 h-6 rounded-full material-icons text-red-600">
              alarm
            </span>
            <p
              class="text-sm ssm:text-xs vs:text-xs lvs:text-sm leading-none text-gray-900 py-1"
            >
              {{
                timestampSched(
                  currentPostViewDetails.transactionData.deliverySchedule
                )
              }}
            </p>
          </div>
          <div class="flex space-x-2">
            <span class="w-6 h-6 rounded-full material-icons text-red-600">
              shopping_cart
            </span>
            <p
              class="text-sm ssm:text-xs vs:text-xs lvs:text-sm leading-none text-gray-900 py-1"
            >
              {{ currentPostViewDetails.transactionData.shoppingPlace }}
            </p>
          </div>
          <div class="flex space-x-2 py-2">
            <span class="w-6 h-6 rounded-full material-icons text-red-600">
              payments
            </span>
            <p
              class="text-sm ssm:text-xs vs:text-xs lvs:text-sm leading-none text-gray-900 py-1"
            >
              {{ currentPostViewDetails.transactionData.paymentMethod }}
            </p>
          </div>
        </div>
        <div
          v-if="currentPostViewDetails.transactionShoppingList != null"
          class="flex flex-col ssm:mt-2 vs:mt-2 mt-3 w-full items-start justify-start h-auto vs:pr-0 vs:min-w-0 vs:px-2 ssm:pr-0 ssm:min-w-0 ssm:px-2 p-4 bg-gray-100 rounded-xl"
        >
          <div class="inline-flex flex-row space-x-4">
            <span class="text-base ssm:text-sm leading-none text-gray-900"
              >Shopping List</span
            >
            <span class="text-base ssm:text-sm leading-none text-gray-500"
              >{{
                currentPostViewDetails.transactionShoppingList.length
              }}
              items</span
            >
          </div>
          <div
            class="inline-flex flex-col ssm:px-0 w-full vs:px-0 space-y-2 py-4 px-4"
          >
            <li
              v-for="shoppingItems in computedShopItemList(
                currentPostViewDetails.transactionShoppingList
              )"
              :key="shoppingItems"
              class="text-sm leading-none text-gray-900"
            >
              {{ shoppingItems.product }} ({{ shoppingItems.size }}) ·
              {{ shoppingItems.brand }} [{{ shoppingItems.quantity }}]
            </li>
          </div>
          <button
            @click="showMoreshowLess"
            v-if="isFew"
            class="focus:outline-none items-start justify-start text-sm text-gray-500"
          >
            {{ showListStatus }}
          </button>
        </div>
        <div
          v-if="currentPostViewDetails.transactionData.caption != null"
          class="inline-flex items-start ssm:px-2 justify-start mt-3 rounded-xl h-auto bg-white w-full"
        >
          <p
            class="text-sm ssm:text-xs vs:text-xs lvs:text-sm leading-normal w-auto text-gray-900"
          >
            {{ currentPostViewDetails.transactionData.caption }}
          </p>
        </div>
        <div
          v-if="currentPostViewDetails.transactionStatus == 'pending'"
          class="justify-between flex flex-row vs:space-x-2 ssm:space-x-2 sm:space-x-2 w-full"
        >
          <button
            @click="declineDisRequest"
            class="focus:outline-none inline-flex items-center justify-center w-52 px-3 py-1 border-2 rounded-full border-red-700"
          >
            <p
              class="text-base font-bold leading-normal text-center text-gray-900"
            >
              Decline
            </p>
          </button>
          <button
            @click="accept_transact()"
            class="focus:outline-none inline-flex items-center justify-center w-52 px-3 py-1 bg-red-700 rounded-full"
          >
            <p
              class="text-base font-bold leading-normal text-center text-white"
            >
              Accept
            </p>
          </button>
        </div>
      </div>
    </div>
    <!--end-->
    <!--Accept User Request Button Modal-->
    <transition name="fadeSlide">
      <div
        v-if="accept"
        class="z-50 fixed inset-0 flex justify-center items-center ssm:px-2 vs:px-2"
      >
        <div
          class="inline-flex flex-col bg-white shadow rounded-xl h-auto w-95 space-y-4 p-4 ssm:w-full vs:w-full"
        >
          <div class="flex justify-between items-center flex-row">
            <button
              @click="
                accept = false;
                toggleViewDetails = false;
              "
              class="invisible focus:outline-none text-sm font-bold leading-none text-right text-indigo-900"
            >
              Back</button
            ><!--invisible, used only for auto margin header. If design need close button just delete the invisible class-->
            <p
              class="text-lg ssm:text-sm vs:text-base font-bold leading-normal text-center text-gray-900"
            >
              Accept {{ currentPostViewDetails.transaction_sender.firstName }}
              {{ currentPostViewDetails.transaction_sender.lastName }}'s Request
            </p>
            <button
              @click="
                accept = false;
                toggleViewDetails = false;
              "
              class="focus:outline-none text-sm font-bold leading-none text-right text-indigo-900"
            >
              Close
            </button>
          </div>
          <hr class="w-full" />
          <div class="flex w-full">
            <p class="block items-start leading-normal text-base text-gray-900">
              Are you sure you want to accept
              {{ currentPostViewDetails.transaction_sender.firstName }}
              {{ currentPostViewDetails.transaction_sender.lastName }}'s
              request?
            </p>
          </div>
          <div class="justify-between flex flex-row space-x-2 w-full">
            <button
              @click="
                accept = false;
                toggleViewDetails = false;
              "
              class="focus:outline-none inline-flex items-center justify-center w-52 px-3 py-1 border-2 rounded-full border-red-700"
            >
              <p
                class="text-base font-bold leading-normal text-center text-gray-900"
              >
                Cancel
              </p>
            </button>
            <button
              @click="confirmAcceptTransact"
              class="focus:outline-none inline-flex items-center justify-center w-52 px-3 py-1 bg-red-700 rounded-full"
            >
              <p
                class="text-base font-bold leading-normal text-center text-white"
              >
                Confirm
              </p>
            </button>
          </div>
        </div>
      </div>
    </transition>
    <!--Accept PopUp Notification-->
    <div
      class="z-100 fixed inset-x-0 bottom-2 flex justify-center items-center"
    >
      <div
        v-if="acceptReqNotiPop"
        class="acceptRequestNotiPop bg-gray-900 text-white px-4 py-2 rounded-xl w-95 h-auto"
        role="alert"
      >
        <div class="flex w-full flex-row justify-between items-center">
          <div class="flex flex-row w-full space-x-2">
            <span class="w-6 h-6 rounded-full material-icons text-white">
              check_circle
            </span>
            <p class="text-base leading-normal text-white">
              Successfully Accepted
              {{ currentPostViewDetails.transaction_sender.firstName }}
              {{ currentPostViewDetails.transaction_sender.lastName }}'s request
            </p>
          </div>
          <button
            @click="closeAcceptRequestNotiPop"
            class="focus:outline-none flex"
          >
            <span class="w-6 h-6 rounded-full material-icons text-white">
              cancel
            </span>
          </button>
        </div>
      </div>
    </div>
    <!--end-->
    <!--Decline User Request Button Modal-->
    <transition name="fadeSlide">
      <div
        v-if="decline"
        class="z-50 fixed inset-0 flex justify-center items-center ssm:px-2 vs:px-2"
      >
        <div
          class="inline-flex flex-col bg-white shadow rounded-xl h-auto w-95 space-y-4 p-4 ssm:w-full vs:w-full"
        >
          <div class="flex justify-between items-center flex-row">
            <button
              class="invisible focus:outline-none text-sm font-bold leading-none text-right text-indigo-900"
            >
              Back</button
            ><!--invisible, used only for auto margin header. If design need close button just delete the invisible class-->
            <p
              class="text-lg ssm:text-sm vs:text-base font-bold leading-normal text-center text-gray-900"
            >
              Decline {{ currentPostViewDetails.transaction_sender.firstName }}
              {{ currentPostViewDetails.transaction_sender.lastName }}'s Request
            </p>
            <button
              @click="declineDisRequest"
              class="focus:outline-none text-sm font-bold leading-none text-right text-indigo-900"
            >
              Close
            </button>
          </div>
          <hr class="w-full" />
          <div class="flex w-full">
            <p class="block items-start leading-normal text-base text-gray-900">
              Are you sure you want to decline
              {{ currentPostViewDetails.transaction_sender.firstName }}
              {{ currentPostViewDetails.transaction_sender.lastName }}'s
              request? You can not undo this.
            </p>
          </div>
          <div class="justify-between flex flex-row space-x-2 w-full">
            <button
              @click="declineDisRequest"
              class="focus:outline-none inline-flex items-center justify-center w-52 px-3 py-1 border-2 rounded-full border-red-700"
            >
              <p
                class="text-base font-bold leading-normal text-center text-gray-900"
              >
                Cancel
              </p>
            </button>
            <button
              @click="confirmDeclineTransact"
              class="focus:outline-none inline-flex items-center justify-center w-52 px-3 py-1 bg-red-700 rounded-full"
            >
              <p
                class="text-base font-bold leading-normal text-center text-white"
              >
                Confirm
              </p>
            </button>
          </div>
        </div>
      </div>
    </transition>

    <!--Decline PopUp Notification-->
    <div
      class="z-100 fixed inset-x-0 bottom-2 flex justify-center items-center"
    >
      <div
        v-if="declineReqNotiPop"
        class="declineRequestNotiPop bg-gray-900 text-white px-4 py-2 rounded-xl w-95 h-auto"
        role="alert"
      >
        <div class="flex w-full flex-row justify-between items-center">
          <div class="flex flex-row w-full space-x-2">
            <span class="w-6 h-6 rounded-full material-icons text-white">
              check_circle
            </span>
            <p class="text-base leading-normal text-white">
              Successfully Declined
              {{ currentPostViewDetails.transaction_sender.firstName }}
              {{ currentPostViewDetails.transaction_sender.lastName }}'s request
            </p>
          </div>
          <button
            @click="declineReqNotiPop = !declineReqNotiPop"
            class="focus:outline-none flex"
          >
            <span class="w-6 h-6 rounded-full material-icons text-white">
              cancel
            </span>
          </button>
        </div>
      </div>
    </div>
    <!--end-->
  </div>
</template>

<script>
// import api from '../api'
import store from "../store/index";
import EditShoppingOfferPostVue from "./EditShoppingOffer.vue";
import PostModal from "./PostModal";
import UpdateOfferStatus from "./updateOfferStatus";
import SendRequest from "./sendRequest";
import moment from "moment";
import api from "../api";
import VueSimpleAlert from "vue-simple-alert";
import $ from "jquery";
import Axios from "axios";
export default {
  props: ["userID"],
  data() {
    return {
          limitOffersDisplay: 3,
      limitOffersDisplay2: 3,
      defaultLimitOffersDisplay: 3,
      viewMoreStatus: "View More",
      viewLessStatus: "View Less",
      sendOfferOrRequestpostNum: null,
      acceptReqNotiPop: false,
      declineReqNotiPop: false,
      decline: null,
      accept: false,
      threeDotUser: null,
      threeDot: false,
      postModalVisible: false,
      postModalVisible1: false,
      postModalVisible2: false,
      postSendModal: false,
      postChatModal: false,
      edit1: false,
      share1: false,
      share2: null,
      shareIt: false,
      datePosted: "3 hours ago",
      postStatus: "posted",
      user_info: {
        firstname: "Yami",
        lastname: "Sukehiro",
      },
      delivery_info: {
        delivery_area: "Delivering to Banquerohan area only",
        shopping_place: "Shopping at SM City Legazpi",
        schedule: "Tomorrow at 2 PM",
        public_transit: "Public Transit",
        capacity: "Up to 3 medium bags or 2 large bags",
        payment_method: "Payment First",
        comment:
          "Hi! I’ll be  going to SM City Legazpi tomorrow. If there’s anyone who wants to pasabuy their groceries, I am willing to help out. Just send me a request!",
        status: "No Longer Accepting Requests",
      },
      shoppingOffer_postNumber: null,
      user_email: null,
      currentPostViewDetails: [],
      limit_by: 4,
      default_limit: 4,
      showListStatus: "See More",
      showLessStatus: "See Less",
      isActive: false,
      toggleViewDetails: false,
    };
  },
  components: {
    PostModal,
    EditShoppingOfferPostVue,
    UpdateOfferStatus,
    SendRequest,
  },
  methods: {
     isFew2(post) {
      return (
        this.transactions.filter((x) => {
          return x.postNumber == post;
        }).length < 4
      );
    },
       computedOffersReceived(post) {
      var temp = this.transactions.filter((x) => {
        return x.postNumber == post;
      });
      return this.limitOffersDisplay
        ? temp.slice(0, this.limitOffersDisplay)
        : temp;
    },
       maxOffersReceived(post) {
      return this.transactions.filter((x) => {
        return x.postNumber == post;
      }).length;
    },
         viewMoreviewLess(post) {
      this.limitOffersDisplay = null;
      if (this.viewMoreStatus != this.viewLessStatus) {
        this.viewMoreStatus = this.viewLessStatus;
        this.limitOffersDisplay2 = this.maxOffersReceived(post);
        console.log("if");
      } else {
        this.viewMoreStatus = "View More";
        this.limitOffersDisplay = this.defaultLimitOffersDisplay;
        this.limitOffersDisplay2 = this.limitOffersDisplay;
        console.log("else");
      }
    },
    declineDisRequest() {
      this.decline = !this.decline;
      this.toggleViewDetails = false;
      $(".hideMe1").fadeIn();
    },
    closeAcceptRequestNotiPop() {
      this.acceptReqNotiPop = false;
      $(".acceptRequestNotiPop").fadeOut();
    },
    confirmAcceptTransact() {
      this.accept = !this.accept;
      this.toggleViewDetails = !this.toggleViewDetails;
      var temp = this.rooms.filter((x) => {
        return (
          (x.email1 == this.user.email || x.email2 == this.user.email) &&
          (x.email1 == this.currentPostViewDetails.transaction_sender.email ||
            x.email2 == this.currentPostViewDetails.transaction_sender.email)
        );
      });
      var activeRoom = temp[0].messageRoomNumber;
      var dataMessage = {
        roomID: activeRoom,
        message: JSON.stringify({
          param: "this_is_a_message_transaction",
          sender: this.user.firstName + " " + this.user.lastName,
          receiver:
            this.currentPostViewDetails.transaction_sender.firstName +
            " " +
            this.currentPostViewDetails.transaction_sender.lastName,
          status: "Accepted",
          postIdentity: "request",
        }),
      };
      var dataMessage2 = {
        roomID: activeRoom,
        message: JSON.stringify(this.currentPostViewDetails.transactionData),
      };
      console.log(dataMessage, dataMessage2);
      Axios.all([
        api.post("api/confirmRequest", {
          postNumber: this.currentPostViewDetails.postNumber,
          ID: this.currentPostViewDetails.indexTransactionPost,
          userNotif: this.currentPostViewDetails.transaction_sender.email,
          postIdentity: "request",
        }),
        api.post("/api/sendMessage", dataMessage),
        api.post("/api/sendMessage", dataMessage2),
        api.get("/api/getTransaction"),
      ]).then((resArr) => {
        store.commit("setUserTransactions", resArr[3].data);
        store.commit("FETCH_ROOMS", resArr[2].data);
        store.dispatch("getPosts");
        $(".acceptRequestNotiPop").fadeIn(), (this.acceptReqNotiPop = true);
        setTimeout(function () {
          this.acceptReqNotiPop = false;
          $(".acceptRequestNotiPop").fadeOut();
          this.currentPostViewDetails = null;
        }, 4000);
      });
    },
    confirmDeclineTransact() {
      this.decline = !this.decline;
      this.toggleViewDetails = false;
      var temp = this.rooms.filter((x) => {
        return (
          (x.email1 == this.user.email || x.email2 == this.user.email) &&
          (x.email1 == this.currentPostViewDetails.transaction_sender.email ||
            x.email2 == this.currentPostViewDetails.transaction_sender.email)
        );
      });
      var activeRoom = temp[0].messageRoomNumber;
      var dataMessage = {
        roomID: activeRoom,
        message: JSON.stringify({
          param: "this_is_a_message_transaction",
          sender: this.user.firstName + " " + this.user.lastName,
          receiver:
            this.currentPostViewDetails.transaction_sender.firstName +
            " " +
            this.currentPostViewDetails.transaction_sender.lastName,
          status: "Declined",
          postIdentity: "request",
        }),
      };
      Axios.all([
        api.post("api/declineRequest", {
          postNumber: this.currentPostViewDetails.postNumber,
          ID: this.currentPostViewDetails.indexTransactionPost,
          userNotif: this.currentPostViewDetails.transaction_sender.email,
          postIdentity: "request",
        }),
        api.post("/api/sendMessage", dataMessage),
        api.get("/api/getTransaction"),
      ]).then((resArr) => {
        store.commit("setUserTransactions", resArr[2].data);
        store.commit("FETCH_ROOMS", resArr[1].data);
        setTimeout(() => {
          $(".declineRequestNotiPop").fadeIn(), (this.declineReqNotiPop = true);
        }, 500);
        setTimeout(function () {
          this.declineReqNotiPop = false;
          $(".declineRequestNotiPop").fadeOut();
          this.currentPostViewDetails = null;
        }, 4000);
      });
    },
    accept_transact() {
      $(".hideMe1").fadeOut();
      this.accept = !this.accept;
    },

    decline_transact() {
      this.decline = !this.decline;
    },
    computedShopItemList(list) {
      return this.limit_by ? list.slice(0, this.limit_by) : list;
    },
    isFew(filter_itemList) {
      filter_itemList.length < 5;
    },
    viewDetailsBtn(transactionNumber) {
      var temp = this.transactions.filter((x) => {
        return x.transactionNumber == transactionNumber;
      });
      this.currentPostViewDetails = temp[0];
      this.toggleViewDetails = !this.toggleViewDetails;
      console.log("detailss");
    },
    filteredTransacation(postNum) {
      return this.transactions.filter((x) => {
        return x.postNumber == postNum;
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
      this.edit1 = false;
      this.share = false;
    },
    listener1() {
      this.postModalVisible1 = false;
      this.edit1 = false;
      this.share = false;
    },
    listener2() {
      this.postModalVisible2 = false;
      this.edit1 = false;
      this.share = false;
    },
    listener3() {
      this.postSendModal = false;
      this.edit1 = false;
      this.share = false;
    },
    toEncrypt(val) {
      return btoa(val);
    },
    // loadShoppingOffer_infos(){
    //   api.get("api/shoppingoffers").then((data) => {this.shoppingOffer_infos = data.data; console.log("offer",this.shoppingOffer_infos)});
    // },
    timestampSched(datetime) {
      var schedDate = new Date(datetime);
      var dateToday = new Date();
      var dateDiff = schedDate.getTime() - dateToday.getTime();
      dateDiff = dateDiff / (1000 * 3600 * 24);
      if (dateDiff < 1 && dateDiff > 0)
        return moment(datetime).format("[Today at] h:mm a");
      else if (dateDiff >= 1 && dateDiff < 2)
        return moment(datetime).format("[Tommorow at] h:mm a");
      else return moment(datetime).format("[From] MMM DD, YYYY [at] h:mm a");
    },
    timestamp(datetime) {
      var postedDate = new Date(datetime);
      var dateToday = new Date();
      var dateDiff = dateToday.getTime() - postedDate.getTime();
      dateDiff = dateDiff / (1000 * 3600 * 24);
      if (dateDiff < 1) return moment(datetime).format("[Today at] h:mm a");
      else if (dateDiff >= 1 && dateDiff < 2)
        return moment(datetime).format("[Yesterday at] h:mm a");
      else return moment(datetime).format("MMM DD, YYYY [at] h:mm a");
    },
    share(postNumber) {
      var shareData = { postNum: postNumber };
      api
        .post("/api/share", shareData)
        .then((res) => {
          VueSimpleAlert.alert(res.data.message, "Success", "success");
          this.share1 = false;
          store.dispatch("getAllShares").then(() => {
            this.sortPosts();
          });
        })
        .catch((error) => {
          VueSimpleAlert.alert("An error occured", "Error", "error");
          console.log(error);
        });
    },

    closeOpen() {
      this.share = !this.share;
      this.edit1 = false;
    },

    EditModal() {
      this.edit1 = !this.edit1;
      this.share = false;
    },

    showShareModal() {
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
      this.share = !this.share;
    },
    deletePost(postNum) {
      api.delete("api/post/" + postNum + "/delete").then(() => {
        store.dispatch("getPosts").then(() => {});
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
  // created(){
  //   this.loadShoppingOffer_infos();
  //   //api.get("api/user").then((data) => {this.user_email = data.data.email; console.log("email",this.user_email)});
  // },
  created() {
    console.log("posts", this.shoppingOffer_infos);
  },
  computed: {
    verifiedUsers() {
      return store.getters.getVerifiedUsers;
    },
    user() {
      //console.log('user',this.store.getters.getPersonal)
      return store.getters.getPersonal;
    },
    posts() {
      return store.getters.getPosts;
    },
    shoppingOffer_infos() {
      return this.posts.filter((post) => {
        return post.email == this.userID && post.offer_post != null;
      }); //filtering only the offer posts opf the current user
    },
    transactions() {
      return store.getters.getUserTransactions.filter((x) => {
        return x.transactionStatus == "pending";
      });
    },
    rooms() {
      return store.getters.getRooms;
    },
  },

  //   computed: {
  //     //  filterOffers: function() {
  //     //    return this.shoppingOffer_infos.filter(function(value) {
  //     //      if (value.posts.email == this.user_email) {
  //     //        return value
  //     //      }
  //     //   })
  //       filterOffers: function() {
  //        api.get("api/user").then((data) => {this.shoppingOffer_infos = data.data; console.log("offer",this.shoppingOffer_infos)});
  //        return this.shoppingOffer_infos.user.filter(function(value) {
  //          if (value.postStatus == 'Accepting Request') {
  //            return value.postStatus
  //          }
  //       })
  //     },
  //  }
  // computed: {
  //      filterOffers: function() {
  //        return this.shoppingOffer_infos.filter(function(value) {
  //          if (value.postStatus == 'Accepting Request') {
  //            return value.postStatus
  //          }
  //       })
  //     }
  //  }
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
</style>
