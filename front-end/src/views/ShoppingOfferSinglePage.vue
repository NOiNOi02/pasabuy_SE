<template>
  <Navbar />
  <div
    class="flex flex-col bg-gray-100 pt-122 font-nunito h-scrren pb-6 bg-gray-bgcolor sm:px-2 ssm:px-2 vs:px-2"
  >
    <!--user post-->
    <div class="flex items-center justify-center pt-6">
      <div
        class="space-x-4 h-auto p-6 vs:p-4 ssm:p-2 ssm:w-full vs:w-full sm:w-full w-608 bg-white shadow rounded-xl"
      >
        <div class="flex flex-col items-start justify-start">
          <!--section 1-->
          <div class="flex flex-grow flex-wrap flex-row w-full justify-between">
            <div class="inline-flex">
              <img
                class="w-14 h-14 vs:w-10 vs:h-10 ssm:w-10 ssm:h-10 rounded-full"
                :src="currentPost.user.profilePicture"
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
                    {{ currentPost.user.firstName }}
                    {{ currentPost.user.lastName }}
                    <span
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
                    >{{ timestamp(currentPost.dateCreated) }}</span
                  >
                </div>
              </div>
            </div>
            <div
              id="3dotmenu"
              class="vs:mt-1"
              v-if="currentPost.email === user.email"
            >
              <button
                @click="EditModal = !EditModal"
                class="focus:outline-none"
              >
                <img
                  class="w-6 vs:w-4 lvs:w-5 ssm:w-4 h-auto"
                  src="img/3dot.svg"
                />
              </button>
              <div class="flex w-full">
                <div
                  v-if="EditModal"
                  class="absolute py-2 pt-2 pl-2 pr-4 leading-loose bg-white rounded-lg shadow-xl ssm:right-5 vs:right-5 sm:right-5 lg:right-56 md:right-24 xl:right-91 h-min w-30"
                >
                  <EditShoppingOfferPostVue
                    v-if="postModalVisible2"
                    @closeModal1="postModalVisible2 = !postModalVisible2"
                    :btnText="currentPost"
                  />
                  <button
                    @click="postModalVisible2 = !postModalVisible2"
                    class="flex flex-row gap-x-2 text-base focus:outline-none"
                  >
                    <span class="font-medium text-gray-500 material-icons">
                      mode
                    </span>
                    Edit Post
                  </button>
                  <UpdateOfferStatus
                    v-if="postModalVisible3"
                    @closeModal2="postModalVisible3 = !postModalVisible3"
                    :post="currentPost"
                  />
                  <button
                    @click="postModalVisible3 = !postModalVisible3"
                    class="flex flex-row font-normal text-base focus:outline-none gap-x-2"
                  >
                    <span class="font-normal text-gray-500 material-icons">
                      autorenew
                    </span>
                    Update Status
                  </button>
                  <button
                    @click="deletePost(currentPost.postNumber)"
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
            v-if="currentPost.postStatus != 'Accepting Requests'"
            class="inline-flex mt-4 items-center space-x-2 justify-start px-2 py-1 bg-gray-100 rounded-full"
          >
            <span class="rounded-full material-icons text-red-600">
              remove_circle_outline
            </span>
            <p
              class="text-sm vs:text-xs ssm:text-xs lvs:text-sm font-bold leading-none items-center text-red-600"
            >
              {{ currentPost.postStatus }}
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
              {{ currentPost.postStatus }}
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
                  {{ currentPost.offer_post.deliveryArea }}
                </p>
              </div>
              <div class="flex space-x-2 py-2">
                <span class="w-6 h-6 rounded-full material-icons text-red-600">
                  alarm
                </span>
                <p
                  class="text-sm ssm:text-xs vs:text-xs lvs:text-sm leading-none text-gray-900 py-1"
                >
                  {{ timestampSched(currentPost.offer_post.deliverySchedule) }}
                </p>
              </div>
              <div class="flex space-x-2">
                <span class="w-6 h-6 rounded-full material-icons text-red-600">
                  shopping_bag
                </span>
                <p
                  class="text-sm ssm:text-xs vs:text-xs lvs:text-sm leading-none text-gray-900 py-1"
                >
                  {{ currentPost.offer_post.capacity }}
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
                  {{ currentPost.offer_post.shoppingPlace }}
                </p>
              </div>
              <div class="flex space-x-2 py-2">
                <span class="w-6 h-6 rounded-full material-icons text-red-600">
                  directions_car
                </span>
                <p
                  class="text-sm ssm:text-xs vs:text-xs lvs:text-sm leading-none text-gray-900 py-1"
                >
                  {{ delivery_info.public_transit }}
                </p>
              </div>
              <div class="flex space-x-2">
                <span class="w-6 h-6 rounded-full material-icons text-red-600">
                  payments
                </span>
                <p
                  class="text-sm ssm:text-xs vs:text-xs lvs:text-sm leading-none text-gray-900 py-1"
                >
                  {{ currentPost.offer_post.paymentMethod }}
                </p>
              </div>
            </div>
          </div>
          <!--end-->

          <!--section 4-->
          <div
            class="flex flex-grow-0 mt-4 ssm:mt-2 vs:mt-2 w-full items-start justify-start p-4 bg-gray-100 rounded-xl"
          >
            <p
              class="text-sm ssm:text-xs vs:text-xs lvs:text-sm leading-loose text-gray-900 h-auto w-full vs:min-w-0 vs:px-2"
            >
              {{ currentPost.offer_post.caption }}
            </p>
          </div>
          <!--section 4-->

          <!-- requests received-->
          <div
            class="flex flex-col justify-start items-start w-full space-y-2.5 mt-4"
            v-show="currentPost.email == user.email"
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
                  {{ filteredTransacation(currentPost.postNumber).length }}
                </p>
              </div>
            </div>

            <div
              class="flex-auto flex-col w-full vs:px-0 px-2 space-y-3.5 pb-2 pt-2"
            >
              <div
                class="flex flex-row justify-between"
                v-for="(transaction, index) in filteredTransacation(
                  currentPost.postNumber
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

            <div
              class="flex flex-row w-full justify-between items-center"
              v-if="filteredTransacation(currentPost.postNumber).length > 0"
            >
              <!-- <button
                class="focus:outline-none inline-flex text-base font-bold leading-none text-gray-500"
              >
                View more
              </button>
              <p
                class="inline-flex text-base font-bold leading-none text-gray-500"
              >
                3 of 5
              </p> -->
            </div>
          </div>
          <!-- end of requests received -->
          <!--section 5-->
          <div
            v-if="currentPost.email != user.email"
            class="flex justify-evenly w-full vs:space-x-3 vs:min-w-0 vs:px-2 ssm:space-x-1 ssm:px-0 pr-8 ssm:pr-0 vs:pr-0 mt-4 space-x-6"
          >
            <SendRequest
              v-if="toggleSendModal"
              @closeSendRequest="toggleSendModal = !toggleSendModal"
              :post="currentPost"
            />
            <button
              @click="toggleSendModal = !toggleSendModal"
              class="flex focus:outline-none items-center space-x-2 ssm:space-x-1"
            >
              <span class="pr-2 ssm:pr-0 material-icons md-24"> send </span>
              <p
                class="text-base ssm:text-xs vs:text-xs lvs:text-sm font-bold leading-none text-gray-600"
              >
                Send Request
              </p>
            </button>
            <router-link :to="'/messages/?ID=' + toEncrypt(currentPost.email)">
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
                @click="share = !share"
                class="flex focus:outline-none items-center space-x-2 ssm:space-x-1"
              >
                <span class="pr-2 ssm:pr-0 material-icons md-24"> share </span>
                <p
                  class="text-base ssm:text-xs vs:text-xs lvs:text-sm font-bold leading-none text-gray-500"
                >
                  Share
                </p>
              </button>
              <div class="flex w-full">
                <div
                  v-if="share"
                  class="target absolute py-2 pt-2 pl-2 pr-4 leading-loose bg-white rounded-lg shadow-xl ssm:right-5 vs:right-5 sm:right-5 lg:right-56 md:right-24 xl:right-91 h-min w-30"
                >
                  <button
                    @click="shareThis(currentPost.postNumber)"
                    class="flex flex-row gap-x-2 text-base focus:outline-none"
                  >
                    <span class="font-medium text-gray-500 material-icons">
                      share
                    </span>
                    Share on Feed
                  </button>
                  <button
                    class="flex py-2 flex-row font-normal text-base focus:outline-none gap-x-2"
                  >
                    <span class="font-normal text-gray-500 material-icons">
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
    <!--end of user post-->
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
              <span class="text-blue-900 align-middle material-icons text-base">
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
            @click="decline_transact()"
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
              @click="decline=!decline; toggleViewDetails=!toggleViewDetails"
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
              @click="decline=!decline,
              toggleViewDetails=!toggleViewDetails"
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
  </div>
</template>

<script>
import Navbar from "./Navbar";
import EditShoppingOfferPostVue from "./EditShoppingOffer";
import moment from "moment";
import store from "../store/index";
import UpdateOfferStatus from "./updateOfferStatus";
import SendRequest from "./sendRequest.vue";
import api from "../api";
import $ from "jquery";
import Axios from "axios";
export default {
  data() {
    return {
      acceptReqNotiPop: false,
      declineReqNotiPop: false,
      decline: false,
      accept: false,
      threeDotUser: null,
      threeDot: false,
      ctrProp: 0,
      share: false,
      toggleSendModal: false,
      EditModal: false,
      postModalVisible3: false,
      postModalVisible2: false,
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
      currentPostViewDetails: [],
      toggleViewDetails: false,
    };
  },
  components: {
    Navbar,
    EditShoppingOfferPostVue,
    UpdateOfferStatus,
    SendRequest,
  },
  methods: {
    accept_transact() {
      $(".hideMe1").fadeOut();
      this.accept = !this.accept;
    },
    decline_transact() {
      $(".hideMe1").fadeOut();
      this.decline = !this.decline;
    },
    computedShopItemList(list) {
      return this.limit_by ? list.slice(0, this.limit_by) : list;
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
    viewDetailsBtn(transactionNumber) {
      var temp = this.transactions.filter((x) => {
        return x.transactionNumber == transactionNumber;
      });
      this.currentPostViewDetails = temp[0];
      this.toggleViewDetails = !this.toggleViewDetails;
    },
    filteredTransacation(postNum) {
      return this.transactions.filter((x) => {
        return x.postNumber == postNum;
      });
    },
    shareThis(postNumber) {
      var shareData = { postNum: postNumber };
      api
        .post("/api/share", shareData)
        .then(() => {
          // this.popUp3 = true;
          this.share = false;
          store.dispatch("getAllShares");
        })
        .catch((error) => {
          // VueSimpleAlert.alert("An error occured", "Error", "error");
          console.log(error);
        });
    },
    toEncrypt(val) {
      return btoa(val);
    },
    deletePost(postNum) {
      api.delete("api/post/" + postNum + "/delete").then(() => {
        store.dispatch("getPosts").then(() => {
          this.sortPosts();
          this.changeFilter();
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
  },
  computed: {
    currentPost() {
      var postNumber = JSON.parse(atob(this.$route.query.post));
      var temp = this.posts.filter((x) => {
        return x.postNumber === postNumber;
      });
      return temp[0];
    },
    user() {
      return store.getters.getPersonal;
    },
    posts() {
      return store.getters.getPosts;
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
};
</script>

<style scoped>
</style>