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
          class="inline-flex space-x-4 ssm:space-x-2 items-center vs:w-full ssm:w-full ssm:p-2 sm:w-full justify-center vs:p-4 p-6 bg-white shadow rounded-xl h-25"
        >
          <img
            class="w-14 h-14 vs:w-10 vs:h-10 ssm:w-10 ssm:h-10 rounded-full"
            :src="user.profilePicture"
          />
          <button
            @click="togglePostModal"
            class="flex items-center justify-start text-base ssm:text-xs lvs:text-sm vs:text-xs outline-none leading-none text-gray-500 py-5 pl-6 bg-gray-100 rounded-full ssm:h-10 vs:h-12 h-14 w-448 ssm:w-full vs:w-full"
          >
            Post an order request
          </button>
        </div>
      </div>
    </div>
    <!--end-->

    <!--user post-->
    <div
      v-for="shoppingOrder_info in shoppingOrder_infos"
      v-bind:key="shoppingOrder_info.request_post.indexOrderRequestPost"
      class="flex items-center justify-center pt-6"
    >
      <div
        class="space-x-4 h-auto ssm:p-2 ssm:w-full p-6 vs:p-4 vs:w-full sm:w-full w-608 bg-white shadow rounded-xl"
      >
        <div class="flex flex-col items-start justify-start">
          <!--section 1-->
          <div class="flex flex-grow flex-wrap flex-row w-full justify-between">
            <div class="inline-flex">
              <img
                class="w-14 h-14 vs:w-10 vs:h-10 ssm:w-10 ssm:h-10 rounded-full"
                :src="shoppingOrder_info.user.profilePicture"
              />
              <div
                class="flex flex-col items-start w-full vs:px-1 se:px-2 ssm:px-2 px-4"
              >
                <div
                  class="space-x-4 ssm:space-x-0 ssm:flex-col se:flex-col se:space-x-0 vs:space-x-1 sm:space-x-2 flex flex-row mt-1"
                >
                  <p
                    class="ssm:text-xs vs:text-xs lvs:text-sm text-base font-bold leading-none text-gray-900"
                  >
                    {{ shoppingOrder_info.user.firstName }}
                    {{ shoppingOrder_info.user.lastName }}
                    <span
                      v-show="ifUserVerified(shoppingOrder_info.email)"
                      class="text-blue-900 align-middle material-icons md-18 vs:md-14"
                    >
                      verified
                    </span>
                  </p>
                  <p
                    class="ssm:text-xs vs:text-xs lvs:text-sm text-base leading-none text-gray-500"
                  >
                    {{ postStatus }} an order request
                  </p>
                </div>
                <div class="vs:flex vs:w-full ssm:w-full ssm:flex vs:pb-2">
                  <span
                    class="text-sm ssm:text-xs vs:text-xs lvs:text-sm leading-none text-gray-500"
                    >{{ timestamp(shoppingOrder_info.dateCreated) }}</span
                  >
                </div>
              </div>
            </div>
            <div
              id="3dotmenu"
              class="vs:mt-1"
              v-if="
                shoppingOrder_info.email == user.email &&
                shoppingOrder_info.request_post != null
              "
            >
              <button
                @click="
                  edit1 = !edit1;
                  edit2 = shoppingOrder_info.postNumber;
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
                  v-if="edit1 && edit2 == shoppingOrder_info.postNumber"
                  class="absolute py-2 pt-2 pl-2 pr-4 leading-loose bg-white rounded-lg shadow-xl ssm:right-5 vs:right-5 sm:right-5 lg:right-56 md:right-24 xl:right-91 h-min w-30"
                >
                  <EditOrderRequest
                    v-if="postModalVisible3"
                    @closeModal1="listener3"
                    :post="shoppingOrder_info"
                  />
                  <button
                    @click="togglePostModal3"
                    v-if="shoppingOrder_info.postStatus == 'Accepting Offer'"
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
                    v-if="postModalVisible2"
                    @closeModal3="listener2"
                    :post="shoppingOrder_info"
                  />
                  <button
                    @click="togglePostModal2"
                    v-if="shoppingOrder_info.postStatus == 'Accepting Offer'"
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
                    @click="deletePost(shoppingOrder_info.postNumber)"
                    class="flex flex-row text-base gap-x-2 vs:text-sm vs:md-14"
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
            v-if="shoppingOrder_info.postStatus !== 'Accepting Offer'"
          >
            <span class="rounded-full material-icons text-red-600">
              remove_circle_outline
            </span>
            <p
              class="text-sm vs:text-xs ssm:text-xs lvs:text-sm font-bold leading-none items-center text-red-600"
            >
              {{ shoppingOrder_info.postStatus }}
            </p>
          </div>

          <div
            class="inline-flex mt-4 items-center space-x-2 justify-start px-2 py-1 bg-gray-100 rounded-full text-green-600"
            v-if="shoppingOrder_info.postStatus === 'Accepting Offer'"
          >
            <span class="rounded-full material-icons">
              remove_circle_outline
            </span>
            <p
              class="text-sm vs:text-xs ssm:text-xs lvs:text-sm font-bold leading-none items-center"
            >
              {{ shoppingOrder_info.postStatus }}
            </p>
          </div>
          <!--end-->

          <!--section 3-->
          <div
            class="flex ssm:flex-col ssm:items-start ssm:space-x-0 vs:flex-col vs:items-start items-center justify-start mt-4 w-full vs:space-x-0 space-x-2"
          >
            <div class="flex-col items-start w-full pr-12">
              <div class="flex space-x-2">
                <span class="w-6 h-6 rounded-full material-icons text-red-600">
                  location_on
                </span>
                <p
                  class="text-sm ssm:text-xs vs:text-xs lvs:text-sm leading-none text-gray-900 py-1"
                >
                  {{ shoppingOrder_info.request_post.deliveryAddress }}
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
                      shoppingOrder_info.request_post.deliverySchedule
                    )
                  }}
                </p>
              </div>
            </div>
            <div class="flex-col vs:py-1 w-full">
              <div class="flex space-x-2">
                <span class="w-6 h-6 rounded-full material-icons text-red-600">
                  shopping_cart
                </span>
                <p
                  class="text-sm ssm:text-xs vs:text-xs lvs:text-sm leading-none text-gray-900 py-1"
                >
                  {{ shoppingOrder_info.request_post.shoppingPlace }}
                </p>
              </div>
              <div class="flex space-x-2 py-2">
                <span class="w-6 h-6 rounded-full material-icons text-red-600">
                  payments
                </span>
                <p
                  class="text-sm ssm:text-xs vs:text-xs lvs:text-sm leading-none text-gray-900 py-1"
                >
                  {{ shoppingOrder_info.request_post.paymentMethod }}
                </p>
              </div>
            </div>
          </div>
          <!--end-->

          <!--section 4-->
          <!--section 4-->
          <div
            v-if="shoppingOrder_info.request_post.shoppingListContent != null"
            class="flex flex-col ssm:mt-2 vs:mt-2 mt-3 w-full items-start justify-start h-auto vs:pr-0 vs:min-w-0 vs:px-2 ssm:pr-0 ssm:min-w-0 ssm:px-2 p-4 bg-gray-100 rounded-xl"
          >
            <div class="inline-flex flex-row space-x-4">
              <span class="text-base ssm:text-sm leading-none text-gray-900"
                >Shopping List</span
              >
              <span class="text-base ssm:text-sm leading-none text-gray-500"
                >{{
                  computedShopItemList(
                    shoppingOrder_info.request_post.shoppingListContent
                  ).length
                }}
                items</span
              >
            </div>
            <div
              class="inline-flex flex-col ssm:px-0 w-full vs:px-0 space-y-2 py-4 px-4"
            >
              <li
                v-for="shoppingItems in computedShopItemList(
                  shoppingOrder_info.request_post.shoppingListContent
                )"
                :key="shoppingItems.id"
                class="text-sm leading-none text-gray-900"
              >
                {{ shoppingItems.product }} ({{ shoppingItems.size }}) ·
                {{ shoppingItems.brand }} [{{ shoppingItems.quantity }}]
              </li>
            </div>
            <button
              @click="showMoreshowLess"
              v-if="!isFew(shoppingOrder_info.request_post.shoppingListContent)"
              class="focus:outline-none items-start justify-start text-sm text-gray-500"
            >
              {{ showListStatus }}
            </button>
          </div>
          <!--section 4-->
          <!--section 4-->
          <div v-if="shoppingOrder_info.request_post.caption !=null"
            class="inline-flex items-start ssm:px-2 justify-start mt-3 rounded-xl h-auto bg-white w-full"
          >
            <p
              class="text-sm ssm:text-xs vs:text-xs lvs:text-sm leading-loose w-auto text-gray-900"
            >
              {{ shoppingOrder_info.request_post.caption }}
            </p>
          </div>
          <!-- offers receiedceved-->
          <div
            class="flex flex-col justify-start items-start w-full space-y-2.5 mt-4"
            v-if="shoppingOrder_info.email == user.email"
          >
            <hr class="w-full" />
            <div
              class="inline-flex justify-start items-center flex-row space-x-4"
            >
              <p class="text-base font-bold leading-none text-gray-900">
                Offers Received
              </p>
              <div class="inline-flex px-2 py-1 bg-red-700 rounded-full">
                <p class="text-base font-bold leading-none text-white">
                  {{
                    maxOffersReceived(shoppingOrder_info.postNumber)
                  }}
                </p>
              </div>
            </div>

            <div
              class="flex-auto flex-col w-full px-2 vs:px-0 space-y-3.5 pb-2 pt-2"
            >
              <div
                class="flex flex-row justify-between"
                v-for="(transaction, index) in computedOffersReceived(
                  shoppingOrder_info.postNumber
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
                        class="text-base vs:text-sm ssm:text-xs font-bold leading-none text-gray-900"
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
                    @click="decline_transact(transaction)"
                    class="focus:outline-none inline-flex items-start justify-start vs:px-2.5 px-3.5 py-1.5 vs:py-1 border-2 rounded-full border-red-700"
                  >
                    <p
                      class="text-base vs:text-xs ssm:text-xs font-bold leading-none text-gray-900"
                    >
                      Decline
                    </p>
                  </button>
                  <button
                    @click="accept_transact(transaction)"
                    class="focus:outline-none inline-flex items-start justify-start vs:px-3 px-4 vs:py-1.5 py-2 bg-red-700 rounded-full"
                  >
                    <p
                      class="text-base vs:text-xs ssm:text-xs font-bold leading-none text-white"
                    >
                      Accept
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
                @click="viewMoreviewLess(shoppingOrder_info.postNumber)"
                v-if="!isFew2(shoppingOrder_info.postNumber)"
                class="focus:outline-none inline-flex text-base font-bold leading-none text-gray-500"
              >
                {{ viewMoreStatus }}
              </button>
              <p
                class="inline-flex text-base font-bold leading-none text-gray-500"
              >
                {{ computedOffersReceived(
                  shoppingOrder_info.postNumber
                ).length }} of {{ maxOffersReceived(shoppingOrder_info.postNumber) }}
              </p>
            </div>
          </div>

          <!--section 5-->
          <div
            v-if="
              shoppingOrder_info.email !== user.email &&
              shoppingOrder_info.postStatus === 'Accepting Offer'
            "
            class="flex justify-evenly w-full ssm:space-x-1 ssm:px-0 ssm:pr-0 vs:space-x-3 vs:min-w-0 vs:px-2 pr-8 vs:pr-0 mt-4 space-x-6"
          >
            <SendOffer
              v-if="
                postSendModal &&
                sendOfferOrRequestpostNum ==
                  shoppingOrder_info.request_post.postNumber
              "
              @closeSendOffer="listener4"
              :post="shoppingOrder_info"
            />
            <button
              @click="
                toggleSendModal();
                sendOfferOrRequestpostNum =
                  shoppingOrder_info.request_post.postNumber;
              "
              class="flex focus:outline-none items-center space-x-2 ssm:space-x-1"
            >
              <span class="pr-2 ssm:pr-0 material-icons md-24"> send </span>
              <p
                class="text-base ssm:text-xs vs:text-xs lvs:text-sm font-bold leading-none text-gray-600"
              >
                Send Offer
              </p>
            </button>
            <router-link
              :to="'/messages/?ID=' + toEncrypt(shoppingOrder_info.email)"
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
                  share2 = shoppingOrder_info.postNumber;
                "
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
                  v-show="share2 == shoppingOrder_info.postNumber && share1"
                  class="target absolute py-2 pt-2 pl-2 pr-4 leading-loose bg-white rounded-lg shadow-xl ssm:right-5 vs:right-5 sm:right-5 lg:right-56 md:right-24 xl:right-91 h-min w-30"
                >
                  <button
                    @click="share(shoppingOffer_info.postNumber)"
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

          <!--end of user post-->

          <!--user post-->

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
          <!--end-->
        </div>
      </div>
    </div>

    <!--Accept Offer Modal-->
    <div
      v-if="accept"
      class="z-50 fixed bg-black bg-opacity-25 inset-0 flex justify-center items-center ssm:px-2 vs:px-2"
    >
      <div
        class="inline-flex flex-col bg-white shadow rounded-xl h-auto w-96.5 space-y-4 p-4 ssm:w-full vs:w-full"
      >
        <div class="flex justify-between items-center flex-row">
          <button
            @click="accept = false"
            class="invisible focus:outline-none text-sm font-bold leading-none text-right text-indigo-900"
          >
            Back</button
          ><!--invisible, used only for auto margin header. If design need close button just delete the invisible class-->
          <p
            class="text-lg ssm:text-sm vs:text-base font-bold leading-normal text-center text-gray-900"
          >
            Accept {{ currentPostViewDetails.transaction_sender.firstName }}
            {{ currentPostViewDetails.transaction_sender.lastName }}'s Offer
          </p>
          <button
            @click="accept = false"
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
            {{ currentPostViewDetails.transaction_sender.lastName }}'s Offer?
            This would decline all other offers you received for this post and
            will automatically update your post status
            <span class="font-bold text-green-600 leading-normal"
              >Order Taken</span
            >.
          </p>
        </div>
        <div class="justify-between flex flex-row space-x-2 w-full">
          <button
            @click="accept = false"
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
    <!--end-->

    <!--Decline Offer Modal-->
    <div
      v-if="decline"
      class="z-50 fixed bg-black bg-opacity-25 inset-0 flex justify-center items-center ssm:px-2 vs:px-2"
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
            {{ currentPostViewDetails.transaction_sender.lastName }}'s Offer
          </p>
          <button
            @click="declineDisRequest1"
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
            {{ currentPostViewDetails.transaction_sender.lastName }}'s Offer?
            You can not undo this.
          </p>
        </div>
        <div class="justify-between flex flex-row space-x-2 w-full">
          <button
            @click="declineDisRequest1"
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
    <!--end-->

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
              {{ currentPostViewDetails.transaction_sender.lastName }}'s Offer
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
              {{ currentPostViewDetails.transaction_sender.lastName }}'s Offer
            </p>
          </div>
          <button
            @click="acceptReqNotiPop = !acceptReqNotiPop"
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
  <!--end-->
</template>


<script>
// import api from '../api'
import store from "../store/index";
import PostModal from "./PostModal";
import EditOrderRequest from "./EditOrderRequest";
import UpdateOrderStatus from "./updateOrderStatus";
import SendOffer from "./sendOffer";
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
      currentPostViewDetails: null,
      sendOfferOrRequestpostNum: null,
      acceptReqNotiPop: false,
      declineReqNotiPop: false,
      decline: null,
      accept: false,
      threeDotUser: null,
      threeDot: false,
      postModalVisible: false,
      postModalVisible2: false,
      postModalVisible3: false,
      postSendModal: false,
      edit1: false,
      share1: false,
      share2: null,
      datePosted: "3 hours ago",
      postStatus: "posted",
      user_info: {
        firstname: "Yami",
        lastname: "Sukehiro",
      },
      delivery_info: {
        delivery_area: "Banquerohan, Legazpi City",
        shopping_place: "Shopping at SM City Legazpi",
        schedule: "Friday 5 PM",
        payment_method: "Payment First",
        comment:
          "Hi! If there’s anyone who can help me and sabuy my groceries, I would greatly appreciate it. Send me an offer if you’re willing. Thanks!",
        status: "Taken",
        status1: "Accepting Offers",
      },
      shopping_info: {
        countItems: "8",
        item1: "flour (1 kg)",
        item2: "vanilla extract (50 mL)",
        item3: "brown sugar",
        item4: "cocoa powder",
        item5: "baking soda",
        item6: "chocolate syrup",
        item7: "powdered sugar",
        item8: "cocoa powder",
      },
      filter_itemList: [
        {
          item: "flour",
          amount: "1 kg",
          brand: "Any brand",
          unit: "2 units",
        },
        {
          item: "flour",
          amount: "1 kg",
          brand: "Any brand",
          unit: "2 units",
        },
        {
          item: "flour",
          amount: "1 kg",
          brand: "Any brand",
          unit: "2 units",
        },
        {
          item: "flour",
          amount: "1 kg",
          brand: "Any brand",
          unit: "2 units",
        },
        {
          item: "flour",
          amount: "1 kg",
          brand: "Any brand",
          unit: "2 units",
        },
        {
          item: "flour",
          amount: "1 kg",
          brand: "Any brand",
          unit: "2 units",
        },
        {
          item: "flour",
          amount: "1 kg",
          brand: "Any brand",
          unit: "2 units",
        },
        {
          item: "flour",
          amount: "1 kg",
          brand: "Any brand",
          unit: "2 units",
        },
      ],
      limit_by: 4,
      default_limit: 4,
      showListStatus: "See More",
      showLessStatus: "See Less",
      isActive: false,
      currentPostIdentity: null,
      activePostNum: null,
      activeIndexTransNum: null,
      activeUser: null,
      activeDisplayingTransaction: null,
    };
  },
  components: {
    PostModal,
    EditOrderRequest,
    UpdateOrderStatus,
    SendOffer,
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
    declineDisRequest1() {
      this.decline = !this.decline;
      $(".hideMe1").fadeIn();
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
          postIdentity: "offer",
        }),
      };
      var dataMessage2 = {
        roomID: activeRoom,
        message: JSON.stringify(this.currentPostViewDetails.transactionData),
        transaction: true,
        transactionSender: this.currentPostViewDetails.transaction_sender.email,
      };
      console.log(dataMessage, dataMessage2);
      Axios.all([
        api.post("api/confirmRequest", {
          postNumber: this.currentPostViewDetails.postNumber,
          ID: this.currentPostViewDetails.indexTransactionPost,
          userNotif: this.currentPostViewDetails.transaction_sender.email,
          postIdentity: "offer",
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
          postIdentity: "offer",
        }),
      };
      Axios.all([
        api.post("api/declineRequest", {
          postNumber: this.currentPostViewDetails.postNumber,
          ID: this.currentPostViewDetails.indexTransactionPost,
          userNotif: this.currentPostViewDetails.transaction_sender.email,
          postIdentity: "offer",
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
    accept_transact(transact) {
      $(".hideMe1").fadeOut();
      this.accept = !this.accept;
      this.currentPostViewDetails = transact;
      console.log("accept");
    },
    decline_transact(transact) {
      this.decline = !this.decline;
      this.currentPostViewDetails = transact;
      console.log("decline");
    },
    filteredTransacation(postNum) {
      return this.transactions.filter((x) => {
        return x.postNumber == postNum;
      });
    },
    togglePostModal() {
      this.postModalVisible = !this.postModalVisible;
    },
    togglePostModal2() {
      this.postModalVisible2 = !this.postModalVisible2;
    },
    togglePostModal3() {
      this.postModalVisible3 = !this.postModalVisible3;
    },
    toggleSendModal() {
      this.postSendModal = !this.postSendModal;
    },
    listener() {
      this.postModalVisible = false;
      this.edit1 = false;
    },
    listener2() {
      this.postModalVisible2 = false;
      this.edit1 = false;
    },
    listener3() {
      this.postModalVisible3 = false;
      this.edit1 = false;
    },
    listener4() {
      this.postSendModal = false;
      this.edit1 = false;
    },

    EditModal() {
      this.edit1 = !this.edit1;
    },
    // loadShoppingOrder_infos(){
    //   api.get("api/shoppingorders").then((data) => {this.shoppingOrder_infos = data.data; console.log("order",this.shoppingOrder_infos)});
    // },
 
    showShareModal() {
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
      this.share = !this.share;
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
    share(postNumber) {
      var shareData = { postNum: postNumber };
      api
        .post("/api/share", shareData)
        .then(() => {
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
    toEncrypt(val) {
      return btoa(val);
    },
    deletePost(postNum) {
      api.delete("api/post/" + postNum + "/delete").then(() => {
        store.dispatch("getPosts").then(() => {});
      });
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
      } else {
        return [];
      }
    },
    isFew(filter_itemList) {
      filter_itemList.length < 5;
    },
    maxOffersReceived(post) {
      return this.transactions.filter((x) => {
        return x.postNumber == post;
      }).length;
    },
  },
  // created(){
  //   this.loadShoppingOrder_infos();
  //   //api.get("api/user").then((data) => {this.user_email = data.data.email; console.log("email",this.user_email)});
  // },
  created() {
    console.log("posts", this.request_post);
  },
  computed: {
  
    verifiedUsers() {
      return store.getters.getVerifiedUsers;
    },
    user() {
      return store.getters.getPersonal;
    },
    posts() {
      return store.getters.getPosts;
    },
    shoppingOrder_infos() {
      return this.posts.filter((post) => {
        return post.email == this.userID && post.request_post != null;
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
</style>
