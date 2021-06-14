<template class="font-nunito">
  <Navbar />

  <div class="desktopVersion min-h-screen">
    <div
      class="bg-gray-50 flex h-screen justify-center divide-x divide-light-gray-700 px-2"
    >
      <!--Inbox Corner-->
      <div
        class="mt-20 shadow-md vsv:w-full vsvs:w-full x-v:w-full se:w-full vvs:w-full lvs:w-full vs:w-full ssm:w-full xsm:w-full sm:w-full mt-20 md:w-2/5 w-1/4 relative"
      >
        <div
          id="msgheader"
          class="flex justify-items-center relative shadow pt-5 pb-1"
        >
          <button
            class="focus:outline-none pl-5 hover:text-red-700"
            @click="backbtn()"
            type="button"
          >
            <span class="material-icons pt-1" id="iMessage"> chat</span>
          </button>
          <h4 class="tracking-wider text-base font-bold pl-4">Message</h4>
        </div>
        <!--search for users-->
        <div
          v-if="searchMessageInactive"
          class="flex justify-center w-full relative py-1 mt-2 pt-2"
        >
          <input
            type="text"
            class="h-8 w-11/12 pl-5 border font-normal text-sm focus:outline-none focus:ring-1 focus:ring-gray-300 rounded-full"
            placeholder="Search"
            @keyup="searchBtn()"
            v-model="searchInput"
          />
          <button
            @click="searchBtn()"
            class="align-middle absolute right-8 pt-1 h-7 focus:outline-none hover:text-red-700"
          >
            <span class="material-icons" style="font-size: 22px"> search </span>
          </button>
        </div>
        <!---end of search bar-->
        <!-- show results of search-->
        <button
          v-if="showSearchResults"
          class="flex justify-center w-full relative py-1 mt-2 pt-2 focus:outline-none"
        >
          <input
            type="text"
            class="h-8 w-10/12 pl-5 border font-normal text-sm focus:outline-none focus:ring-1 focus:ring-gray-300 rounded-full"
            placeholder="Mark"
            id="search"
          />
          <button
            class="align-middle mt-1 ml-1 flex items-center h-6 w-6 rounded-full bg-gray-300 focus:outline-none hover:text-red-700"
          >
            <span
              @click="closeSearchResults"
              class="material-icons pl-1"
              style="font-size: 17px"
            >
              close
            </span>
          </button></button
        ><!---end of results search bar-->
        <!-- start of loop for rooms/users-->
        <div
          class="overflow-auto overflow-x-hidden px-0 py-1 h-4/5"
          id="scrollInbox"
        >
          <div v-if="searchMessageInactive && activeRoom != null">
            <button
              v-for="(chatRoom, index) in chatRooms"
              :key="index"
              @click="
                setRoom(
                  chatRoomNames[index],
                  chatRoom.messageRoomNumber,
                  chatRoom.email1,
                  chatRoom.email2
                )
              "
              type="button"
              class="focus:bg-gray-200 relative w-full sm:pr-8 flex focus:outline-none justify-between items-center mt-2 p-2 hover:shadow-lg cursor-pointer transition"
            >
              <div class="flex ml-2">
                <div v-if="ifOnline(chatRoom.email1, chatRoom.email2)">
                  <img
                    src="/img/online.png"
                    alt="sunil"
                    class="rounded-sm h-2 w-2 pb-0 mt-3 mr-2"
                  />
                </div>
                <img
                  :src="chatRoomPic[index]"
                  alt="sunil"
                  class="rounded-lg h-8 w-7 pt-1"
                />
                <div
                  class="flex flex-col justify-between items-start ml-2"
                  v-if="chatRoom.get_messages.length != 0"
                >
                  <span class="font-medium text-sm" id="mark">
                    {{ chatRoomNames[index] }}
                    <span v-if="chatRoom.email1 === authUser.email">
                      <span
                        v-show="ifUserVerified(chatRoom.email2)"
                        class="material-icons pl-2"
                        id="iCheck"
                      >
                        check_circle
                      </span>
                    </span>
                    <span v-else>
                      <span
                        v-show="ifUserVerified(chatRoom.email1)"
                        class="material-icons pl-2"
                        id="iCheck"
                      >
                        check_circle
                      </span></span
                    >
                  </span>
                  <span
                    class="text-xs text-gray-400 truncate w-36 flex items-end"
                    v-if="
                      chatRoom.get_messages[chatRoom.get_messages.length - 1]
                        .messageSender === authUser.email
                    "
                  >
                    You :
                    <strong
                      v-if="
                        hasPostNum(
                          chatRoom.get_messages[
                            chatRoom.get_messages.length - 1
                          ].messageText
                        ) == -1 &&
                        hasTransactionMessage(
                          chatRoom.get_messages[
                            chatRoom.get_messages.length - 1
                          ].messageText
                        ) == -1
                      "
                      >{{
                        chatRoom.get_messages[chatRoom.get_messages.length - 1]
                          .messageText
                      }}</strong
                    >
                    <strong
                      v-else-if="
                        hasTransactionMessage(
                          chatRoom.get_messages[
                            chatRoom.get_messages.length - 1
                          ].messageText
                        ) == -1
                      "
                    >
                      {{
                        parseString(
                          chatRoom.get_messages[
                            chatRoom.get_messages.length - 1
                          ].messageText
                        )[0].message
                      }}
                    </strong>
                    <strong v-else>
                      You
                      {{
                        parseString(
                          chatRoom.get_messages[
                            chatRoom.get_messages.length - 1
                          ].messageText
                        )[0].status
                      }}
                      {{
                        parseString(
                          chatRoom.get_messages[
                            chatRoom.get_messages.length - 1
                          ].messageText
                        )[0].receiver
                      }}'s offer/post
                    </strong>
                  </span>
                  <span
                    class="text-xs text-gray-400 truncate w-36 flex items-end"
                    v-else
                  >
                    {{
                      chatRoom.get_messages[chatRoom.get_messages.length - 1]
                        .get_message_sender.firstName
                    }}
                    {{
                      chatRoom.get_messages[chatRoom.get_messages.length - 1]
                        .get_message_sender.lastName
                    }}:
                    <strong
                      v-if="
                        hasPostNum(
                          chatRoom.get_messages[
                            chatRoom.get_messages.length - 1
                          ].messageText
                        ) == -1 &&
                        hasTransactionMessage(
                          chatRoom.get_messages[
                            chatRoom.get_messages.length - 1
                          ].messageText
                        ) == -1
                      "
                      >{{
                        chatRoom.get_messages[chatRoom.get_messages.length - 1]
                          .messageText
                      }}</strong
                    >
                    <strong
                      v-else-if="
                        hasTransactionMessage(
                          chatRoom.get_messages[
                            chatRoom.get_messages.length - 1
                          ].messageText
                        ) == -1
                      "
                    >
                      {{
                        parseString(
                          chatRoom.get_messages[
                            chatRoom.get_messages.length - 1
                          ].messageText
                        )[0].message
                      }}
                    </strong>
                    <strong v-else>
                      {{
                        parseString(
                          chatRoom.get_messages[
                            chatRoom.get_messages.length - 1
                          ].messageText
                        )[0].receiver
                      }}
                      {{
                        parseString(
                          chatRoom.get_messages[
                            chatRoom.get_messages.length - 1
                          ].messageText
                        )[0].status
                      }}
                      your offer/post
                    </strong>
                  </span>
                </div>
                <div
                  class="flex flex-col justify-between items-start ml-2"
                  v-else
                >
                  <span class="font-medium text-sm" id="mark">
                    {{ chatRoomNames[index] }}
                    <span v-if="chatRoom.email1 === authUser.email">
                      <span
                        v-show="ifUserVerified(chatRoom.email2)"
                        class="material-icons pl-2"
                        id="iCheck"
                      >
                        check_circle
                      </span>
                    </span>
                    <span v-else>
                      <span
                        v-show="ifUserVerified(chatRoom.email1)"
                        class="material-icons pl-2"
                        id="iCheck"
                      >
                        check_circle
                      </span></span
                    >
                  </span>
                </div>
              </div>
              <div
                class="flex flex-col items-start"
                v-if="chatRoom.get_messages.length != 0"
              >
                <span class="text-gray-700 text-xs">
                  <span class="font-bold pl-1 pr-1">· </span>
                  {{
                    timestampRoom(
                      chatRoom.get_messages[chatRoom.get_messages.length - 1]
                        .dateCreated
                    )
                  }}
                </span>
              </div>
            </button>
          </div>
          <!---------------navigation message------------>

          <!--show message search users-->
          <!-- <div v-if="showSearchResults" class="divide-y divide-gray-300">
            <div class="py-2 flex justify-center font-normal text-xs italic">
              <span>Search Results</span>
            </div>
            <div>
              <button
                @click="Void"
                type="button"
                class="focus:bg-gray-200 relative w-full flex sm:pr-8 focus:outline-none justify-between items-center mt-2 p-2 hover:shadow-lg cursor-pointer transition"
              >
                <div class="flex ml-2">
                  <img
                    src="https://ptetutorials.com/images/user-profile.png"
                    alt="sunil"
                    class="rounded-lg h-8 w-7 pt-1"
                  />
                  <div class="flex flex-col justify-between items-start ml-2">
                    <span class="font-medium text-sm italic" id="mark">
                      <span class="text-red-700">Mark</span> Aral
                      <span class="material-icons pl-2" id="iCheck">
                        check_circle
                      </span></span
                    >
                    <span
                      class="text-xs text-gray-400 truncate md:w-28 w-36 lvs:w-64 sm:w-72 ssm:w-24"
                    >
                      {{ inbox[0].message }}
                    </span>
                  </div>
                </div>
                <div class="flex flex-col items-start">
                  <span class="text-gray-700 text-xs">
                    <span class="font-bold pl-1 pr-1">·</span
                    >{{ inbox[0].time }}</span
                  >
                </div>
              </button>
            </div>
          </div> -->
          <!---------------search message results------------>
        </div>
      </div>
      <!--end of left corner-->

      <!------------------------------------------------------>

      <!---Chat Corner-->
      <div
        class="mt-20 shadow-md relative vsv:w-full vsvs:w-full x-v:w-full se:w-full vvs:w-full lvs:w-full vs:w-full ssm:w-full xsm:w-full sm:w-full mt-20 w-5/12 md:w-3/5"
      >
        <div v-if="activeRoom != null">
          <div
            class="relative flex justify-items-center md:justify-items-center shadow py-3"
          >
            <div class="flex flex-row justify-between">
              <div class="flex flex-row">
                <button
                  id="backNavigator"
                  class="focus:outline-none pl-5 hover:text-red-700"
                  @click="backChat"
                  type="button"
                >
                  <span class="material-icons pt-2" id="iMessage">
                    keyboard_backspace</span
                  >
                </button>

                <h4 class="text-base font-bold pt-2 pl-4">{{ activeName }}</h4>
                <span v-if="activeEmail1 === authUser.email">
                  <span
                    v-show="ifUserVerified(activeEmail2)"
                    class="material-icons pl-3 pt-3"
                    id="iCheck"
                  >
                    check_circle
                  </span>
                </span>
                <span v-else>
                  <span
                    v-show="ifUserVerified(activeEmail1)"
                    class="material-icons pl-3 pt-3"
                    id="iCheck"
                  >
                    check_circle
                  </span></span
                >
              </div>

              <div class="align-middle absolute right-2">
                <button
                  @click="threedots"
                  class="focus:bg-gray-300 hover:bg-gray-300 rounded-full px-1 h-6 mr-3 focus:outline-none hover:text-red-700"
                  type="button"
                >
                  <span class="material-icons"> more_horiz</span>
                </button>
              </div>
            </div>
          </div>
        </div>

        <div class="overflow-auto overflow-x-hidden h-4/5" id="journal-scroll">
          <div
            class="sticky top-0 w-full p-3 flex justify items-center shadow-lg bg-white border"
            v-for="transaction in transactions"
            :key="transaction.postNumber"
            v-show="
              ifHide &&
              (transaction.emailCustomerShopper == activeEmail1 ||
                transaction.emailCustomerShopper == activeEmail2) &&
              (transaction.transactionReceiver == activeEmail1 ||
                transaction.transactionReceiver == activeEmail2) &&
              activeDisplayingTransaction == transaction.transactionNumber
            "
          >
            <!-- sent offer 1--->
            <div
              v-if="
                transaction.emailCustomerShopper == authUser.email &&
                (transaction.transactionReceiver == activeEmail1 ||
                  transaction.transactionReceiver == activeEmail2)
              "
            >
              <div
                class="text-sm w-full"
                v-if="
                  transaction.transactionStatus == 'pending' &&
                  isRequestPost(transaction.transactionData) != -1
                "
              >
                <div class="flex justify-between items-center">
                  <span
                    >You sent an offer to
                    <span class="font-semibold ml-2">{{ recipient }}</span>
                    <span class="ml-2">for</span>
                    <span class="font-semibold ml-2"
                      >Post {{ transaction.postNumber }}
                    </span></span
                  >

                  <button
                    @click="vertiDots"
                    class="w-4 h-6 py-1 pb-1 pr-1 rounded-full focus:outline-none hover:text-red-700 hover:bg-gray-300 active:bg-gray-300"
                    type="button"
                  >
                    <span class="material-icons" style="font-size: 17px">
                      more_verti</span
                    >
                  </button>
                </div>
                <div class="flex justify-end pr-3">
                  <button
                    @click="
                      cancel_transact(
                        transaction.postNumber,
                        transaction.indexTransactionPost,
                        'offer'
                      )
                    "
                    class="mx-2 mt-2 h-7 px-2 hover:text-white hover:bg-gray-300 rounded-full border border-gray-700"
                  >
                    <span>Cancel Offer</span>
                  </button>
                  <button
                    @click="viewDetailsBtn(transaction.transactionNumber)"
                    class="mx-2 mt-2 h-7 px-2 hover:bg-gray-300 rounded-full bg-red-700 text-white"
                  >
                    <span>View Post</span>
                  </button>
                </div>
              </div>

              <!------->
              <!-- sent request 1--->
              <div
                v-if="
                  transaction.transactionStatus == 'pending' &&
                  isRequestPost(transaction.transactionData) == -1
                "
                class="text-sm w-full"
              >
                <div class="flex justify-between items-center">
                  <span
                    >You sent a request to
                    <span class="font-semibold ml-2">{{ recipient }}</span>
                    <span class="ml-2">for</span>
                    <span class="font-semibold ml-2"
                      >Post {{ transaction.postNumber }}
                    </span></span
                  >

                  <button
                    @click="vertiDots"
                    class="w-4 h-6 py-1 pb-1 pr-1 rounded-full focus:outline-none hover:text-red-700 hover:bg-gray-300 active:bg-gray-300"
                    type="button"
                  >
                    <span class="material-icons" style="font-size: 17px">
                      more_verti</span
                    >
                  </button>
                </div>
                <div class="flex justify-end pr-3">
                  <button
                    @click="
                      cancel_transact(
                        transaction.postNumber,
                        transaction.indexTransactionPost,
                        'request'
                      )
                    "
                    class="mx-2 mt-2 h-7 px-2 hover:text-white hover:bg-gray-300 rounded-full border border-gray-700"
                  >
                    <span>Cancel Request</span>
                  </button>
                  <button
                    @click="viewDetailsBtn(transaction.transactionNumber)"
                    class="mx-2 mt-2 h-7 px-2 hover:bg-gray-300 rounded-full bg-red-700 text-white"
                  >
                    <span>View Post</span>
                  </button>
                </div>
              </div>
            </div>
            <!------->
            <!-- received offer 1--->
            <div
              v-if="
                transaction.transactionReceiver == authUser.email &&
                (transaction.emailCustomerShopper == activeEmail1 ||
                  transaction.emailCustomerShopper == activeEmail2)
              "
            >
              <div
                class="text-sm w-full"
                v-if="
                  transaction.transactionStatus == 'pending' &&
                  isRequestPost(transaction.transactionData) != -1
                "
              >
                <div class="flex justify-between items-center">
                  <span
                    ><span class="font-semibold mr-2"
                      >{{ transaction.transaction_sender.firstName }}
                      {{ transaction.transaction_sender.lastName }}</span
                    >sent you an offer
                    <span class="ml-2">for your </span>
                    <span class="font-semibold ml-2"
                      >Post {{ transaction.postNumber }}
                    </span></span
                  >
                  <button
                    @click="vertiDots"
                    class="w-4 h-6 py-1 pb-1 pr-1 rounded-full focus:outline-none hover:text-red-700 hover:bg-gray-300 active:bg-gray-300"
                    type="button"
                  >
                    <span class="material-icons" style="font-size: 17px">
                      more_verti</span
                    >
                  </button>
                </div>
                <div class="flex justify-end pr-3">
                  <button
                    @click="
                      decline_transact(
                        transaction.postNumber,
                        transaction.indexTransactionPost,
                        transaction.emailCustomerShopper,
                        'offer'
                      )
                    "
                    class="mx-2 mt-2 h-7 px-2 hover:text-white hover:bg-gray-300 focus:outline-none rounded-full border border-gray-700"
                  >
                    <span>Decline</span>
                  </button>
                  <button
                    @click="
                      accept_transact(
                        transaction.postNumber,
                        transaction.indexTransactionPost,
                        transaction.emailCustomerShopper,
                        'offer'
                      )
                    "
                    class="mx-2 mt-2 h-7 px-2 hover:bg-gray-300 rounded-full focus:outline-none bg-red-700 text-white"
                  >
                    <span>Accept</span>
                  </button>
                </div>
              </div>

              <!------->
              <!-- received request 1--->
              <div
                v-if="
                  transaction.transactionStatus == 'pending' &&
                  isRequestPost(transaction.transactionData) == -1
                "
                class="text-sm w-full"
              >
                <div class="flex justify-between items-center">
                  <span
                    ><span class="font-semibold mr-2"
                      >{{ transaction.transaction_sender.firstName }}
                      {{ transaction.transaction_sender.lastName }}</span
                    >sent you a request
                    <span class="ml-2">for your </span>
                    <span class="font-semibold ml-2"
                      >Post {{ transaction.postNumber }}
                    </span></span
                  >
                  <button
                    @click="vertiDots"
                    class="w-4 h-6 py-1 pb-1 pr-1 rounded-full focus:outline-none hover:text-red-700 hover:bg-gray-300 active:bg-gray-300"
                    type="button"
                  >
                    <span class="material-icons" style="font-size: 17px">
                      more_verti</span
                    >
                  </button>
                </div>
                <div class="flex justify-end pr-3">
                  <button
                    @click="
                      decline_transact(
                        transaction.postNumber,
                        transaction.indexTransactionPost,
                        transaction.emailCustomerShopper,
                        'request'
                      )
                    "
                    class="mx-2 mt-2 h-7 px-2 hover:text-white hover:bg-gray-300 focus:outline-none rounded-full border border-gray-700"
                  >
                    <span>Decline</span>
                  </button>
                  <button
                    @click="
                      accept_transact(
                        transaction.postNumber,
                        transaction.indexTransactionPost,
                        transaction.emailCustomerShopper,
                        'request'
                      )
                    "
                    class="mx-2 mt-2 h-7 px-2 hover:bg-gray-300 rounded-full focus:outline-none bg-red-700 text-white"
                  >
                    <span>Accept</span>
                  </button>
                </div>
              </div>
            </div>
            <!------->

            <!--------------transaction details confirmed------>

            <div
              v-if="
                transaction.transactionStatus === 'Confirmed' ||
                transaction.transactionStatus === 'confirmed' ||
                transaction.transactionStatus === 'In Transit'
              "
              class="text-sm w-full"
            >
              <div class="flex flex-row justify-between">
                <span
                  >Transaction
                  <span class="font-semibold ml-2"
                    >#{{ transaction.transactionNumber }}
                  </span>
                </span>

                <div class="flex items-center ml-2">
                  <span class="rounded border h-6 border-blue-700 px-1">{{
                    transaction.transactionStatus
                  }}</span>

                  <button
                    @click="vertiDots"
                    class="w-4 h-6 py-1 pb-1 pr-1 rounded-full focus:outline-none hover:text-red-700 hover:bg-gray-300 active:bg-gray-300"
                    type="button"
                  >
                    <span class="material-icons" style="font-size: 17px">
                      more_verti</span
                    >
                  </button>
                </div>
              </div>
              <div class="flex justify-end pr-3">
                <button
                  @click="viewDetailsBtn(transaction.transactionNumber)"
                  class="mx-2 mt-2 h-7 px-2 hover:text-white hover:bg-gray-300 focus:outline-none rounded-full border border-gray-700"
                >
                  <span>View Details</span>
                </button>
                <button
                  class="mx-2 mt-2 h-7 px-2 hover:bg-gray-300 rounded-full focus:outline-none bg-red-700 text-white"
                >
                  <span>Update</span>
                </button>
              </div>
            </div>
            <!------------------->

            <!--------------transaction details cancelled------>

            <div
              v-if="
                transaction.transactionStatus === 'Cancelled' ||
                transaction.transactionStatus === 'Declined'
              "
              class="text-sm w-full"
            >
              <div class="flex flex-row justify-between">
                <span
                  >Transaction
                  <span class="font-semibold ml-2"
                    >#{{ transaction.transactionNumber }}
                  </span>
                </span>
                <div class="flex items-center ml-2">
                  <span class="rounded border h-6 px-1">{{
                    transaction.transactionStatus
                  }}</span>
                  <button
                    @click="vertiDots"
                    class="w-4 h-6 py-1 pb-1 pr-1 rounded-full focus:outline-none hover:text-red-700 hover:bg-gray-300 active:bg-gray-300"
                    type="button"
                  >
                    <span class="material-icons" style="font-size: 17px">
                      more_verti</span
                    >
                  </button>
                </div>
              </div>
              <div class="flex justify-end pr-3">
                <button
                  @click="viewDetailsBtn(transaction.transactionNumber)"
                  class="mx-2 mt-2 h-7 px-2 hover:text-white hover:bg-gray-300 focus:outline-none rounded-full border border-gray-700"
                >
                  <span>View Details</span>
                </button>
                <button
                  class="mx-2 mt-2 h-7 px-2 hover:bg-gray-300 rounded-full focus:outline-none bg-red-700 text-white"
                >
                  <span>Update</span>
                </button>
              </div>
            </div>
            <!------------------->

            <!-----vertical-dot  options-->
            <div
              v-if="toggleVerti"
              id="vertiOPTIONS"
              class="md:absolute md:right-4 md:top-2 fixed top-36 right-0 px-2 mr-4 bg-gray-200 w-2/5 shadow-inner rounded-lg border-solid border-2 border-white"
              style="width: 220px"
            >
              <div class="flex flex-col">
                <div class="flex flex-row items-center">
                  <button
                    @click="hideVertiOptions"
                    class="w-full flex py-1 hover:bg-white hover:text-crimsonRed justify-start mt-2 border border-gray-300 rounded-lg items-center"
                  >
                    <span class="material-icons pl-3" style="font-size: 20px"
                      >visibility</span
                    >
                    <span class="font-semibold pl-2">Hide</span>
                  </button>
                </div>
                <div class="divide-y divide-gray-300">
                  <div class="flex flex-col pb-2">
                    <span
                      class="pl-1 font-semibold py-1 text-gray-500 py-1 text-xs tracking-wide"
                      >Request(s)/Offers RECEIVED</span
                    >
                    <button
                      v-for="(received, index) in transactionsReceived"
                      :key="index"
                      @click="active_transact(received.transactionNumber)"
                      class="h-6 flex items-center tracking-wide rounded py-1 flex text-xs hover:bg-gray-400 hover:text-white justify-start pl-4"
                    >
                      <span v-if="isRequestPost(received.transactionData) != -1"
                        >Offer #{{ index + 1 }}</span
                      >
                      <span v-else>Request #{{ index + 1 }}</span>
                    </button>
                  </div>

                  <div class="flex flex-col pb-2">
                    <span
                      class="pl-1 font-semibold text-gray-500 py-1 py-1 text-xs tracking-wide"
                      >Request(s)/Offers SENT</span
                    >
                    <button
                      v-for="(received, index) in transactionsSent"
                      :key="index"
                      @click="active_transact(received.transactionNumber)"
                      class="h-6 flex items-center tracking-wide rounded py-1 flex text-xs hover:bg-gray-400 hover:text-white justify-start pl-4"
                    >
                      <span v-if="isRequestPost(received.transactionData) != -1"
                        >Offer #{{ index + 1 }}</span
                      >
                      <span v-else>Request #{{ index + 1 }}</span>
                    </button>
                  </div>

                  <div class="flex flex-col pb-2">
                    <span
                      class="pl-1 font-semibold text-gray-500 py-1 py-1 text-xs tracking-wide"
                      >OTHER TRANSACTIONS</span
                    >
                    <button
                      v-for="(transact, index) in transactions"
                      :key="index"
                      @click="active_transact(transact.transactionNumber)"
                    >
                      <span
                        v-if="
                          transact.transactionStatus === 'Confirmed' ||
                          transact.transactionStatus === 'confirmed' ||
                          transact.transactionStatus === 'In Transit'
                        "
                        class="h-6 flex items-center tracking-wide rounded py-1 flex text-xs hover:bg-gray-400 hover:text-white text-blue-500 justify-start pl-4"
                        >Transaction #{{ index + 1 }}</span
                      >
                      <span
                        v-else-if="
                          transact.transactionStatus === 'Cancelled' ||
                          transact.transactionStatus === 'Declined'
                        "
                        class="h-6 flex items-center tracking-wide rounded py=1 flex text-xs hover:bg-gray-400 hover:text-white text-crimsonRed justify-start pl-4"
                        >Transaction #{{ index + 1 }}</span
                      >
                    </button>
                    <span
                      class="pl-4 font-semibold italic text-gray-400 py-1 py-1 text-xs"
                      >No other transactions</span
                    >
                  </div>
                </div>
              </div>
            </div>
            <!-----end of toggle verti options--->
          </div>
          <!----------3 dots convo options--------->
          <div
            v-show="toggle"
            id="delBtn"
            class="absolute top-14 right-1.5 shadow-lg bg-gray-100 border-2 rounded w-auto flex flex-col justify-center text-sm"
          >
            <button
              class="tracking-wide py-2 px-10 bg-gray-100 font-semibold hover:border-white hover:bg-crimsonRed hover:text-white p-2"
            >
              Delete
            </button>
            <button
              v-if="!ifHide"
              @click="showVertiOptions"
              class="tracking-wide py-2 px-10 bg-gray-100 font-semibold hover:border-white hover:bg-crimsonRed hover:text-white p-2"
            >
              Show Transactions
            </button>
          </div>
          <!--------end --3 dots convo options--------->

          <!-- start of convesation-->
          <!-- incoming message-->
          <div class="p-1 pl-2" v-for="(chat, index) in chatRooms" :key="index">
            <div v-if="chat.messageRoomNumber === activeRoom">
              <div v-for="(msg, index) in chat.get_messages" :key="index">
                <div v-if="msg.messageSender != authUser.email">
                  <!--your incoming messages-->
                  <div
                    v-if="
                      hasPostNum(msg.messageText) == -1 &&
                      hasTransactionMessage(msg.messageText) == -1
                    "
                  >
                    <div class="flex items-end pr-10 mt-1">
                      <img
                        :src="msg.get_message_sender.profilePicture"
                        class="rounded-lg h-8 w-8"
                      />
                      <div class="rounded-lg">
                        <div
                          class="ml-4 mr-10 p-3 bg-gray-100 text-sm rounded-lg"
                        >
                          <p>{{ msg.messageText }}</p>

                          <span
                            class="text-gray-500 pl-1"
                            style="font-size: 10.5px"
                            >{{ timestamp(msg.dateCreated) }}</span
                          >
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- if the message transaction status--->
                  <div v-else-if="hasTransactionMessage(msg.messageText) != -1">
                    <div
                      class="flex justify-center"
                      v-for="(msgStatus, index) in parseString(msg.messageText)"
                      :key="index"
                    >
                      <div class="ml-4 mr-10 p-3 text-gray-400 text-sm">
                        <p
                          v-if="
                            msgStatus.sender ==
                              this.userPersonal.firstName +
                                ' ' +
                                this.userPersonal.lastName &&
                            msgStatus.status === 'Cancelled'
                          "
                        >
                          You {{ msgStatus.status }} your
                          {{ msgStatus.postIdentity }}
                        </p>
                        <p
                          v-else-if="
                            msgStatus.sender ==
                              this.userPersonal.firstName +
                                ' ' +
                                this.userPersonal.lastName &&
                            (msgStatus.status === 'Declined' ||
                              msgStatus.status === 'Accepted')
                          "
                        >
                          You {{ msgStatus.status }} {{ msgStatus.receiver }}'s
                          {{ msgStatus.postIdentity }}
                        </p>
                        <p
                          v-else-if="
                            msgStatus.receiver ==
                              this.userPersonal.firstName +
                                ' ' +
                                this.userPersonal.lastName &&
                            msgStatus.status == 'Cancelled'
                          "
                        >
                          {{ msgStatus.sender }} {{ msgStatus.status }} their
                          {{ msgStatus.postIdentity }}
                        </p>
                        <p v-else>
                          {{ msgStatus.sender }} {{ msgStatus.status }} your
                          {{ msgStatus.postIdentity }}
                        </p>
                      </div>
                    </div>
                  </div>
                  <div v-else>
                    <!-- if the message is a post--->
                    <!-----------------incoming post message------------------------>
                    <div
                      v-for="(msgPost, index) in parseString(msg.messageText)"
                      :key="index"
                    >
                      <div class="flex items-end pr-10 mt-1">
                        <img
                          :src="msg.get_message_sender.profilePicture"
                          class="rounded-lg h-8 w-8 mr-3"
                        />
                        <div class="flex flex-col bg-gray-100 py-2 rounded-lg">
                          <div>
                            <div class="mx-4 mb-2 text-sm font-semibold">
                              <span>Order Details</span>
                            </div>
                            <div class="mx-4 pr-2 pt-3 pb-3 text-sm">
                              <div class="flex flex-col px-2">
                                <div class="flex items-start">
                                  <span
                                    class="text-red-700 material-icons"
                                    style="font-size: 18px"
                                    >place</span
                                  >
                                  <span class="pl-2 pb-1">{{
                                    msgPost.deliveryAddress
                                  }}</span>
                                </div>
                                <div class="flex items-start">
                                  <span
                                    class="text-red-700 material-icons"
                                    style="font-size: 18px"
                                    >shopping_cart</span
                                  >
                                  <span class="pl-2 pb-1">{{
                                    msgPost.shoppingPlace
                                  }}</span>
                                </div>
                                <div class="flex items-start">
                                  <span
                                    class="text-red-700 material-icons"
                                    style="font-size: 16px"
                                    >watch_later</span
                                  >
                                  <span class="pl-2 pb-1">{{
                                    timestampSched(msgPost.deliverySchedule)
                                  }}</span>
                                </div>
                                <div class="flex items-start">
                                  <span
                                    class="text-red-700 material-icons"
                                    style="font-size: 16px"
                                    >payments</span
                                  >
                                  <span class="pl-2">{{
                                    msgPost.paymentMethod
                                  }}</span>
                                </div>
                              </div>
                            </div>
                            <div class="mx-4 p-2 bg-white rounded-lg text-sm">
                              <div>
                                <span class="font-semibold"
                                  >Shopping List<span class="ml-3 text-gray-500"
                                    >{{
                                      computedShopItemList(
                                        msgPost.shoppingListContent
                                      ).length
                                    }}
                                    items</span
                                  ></span
                                >
                              </div>
                              <div>
                                <ul
                                  class="text-gray-600 list-disc list-inside pl-4"
                                >
                                  <li
                                    v-for="items in computedShopItemList(
                                      msgPost.shoppingListContent
                                    )"
                                    :key="items.id"
                                  >
                                    <span>
                                      {{ items.product }} ·
                                      {{ items.brand }} [{{ items.quantity }}
                                      units]
                                    </span>
                                  </li>
                                </ul>
                              </div>
                            </div>
                          </div>
                          <div class="ml-0 mr-10 pb-1">
                            <span
                              class="time_date text-gray-500"
                              style="font-size: 10.5px"
                            >
                              {{ timestamp(msg.dateCreated) }}
                            </span>
                          </div>
                        </div>
                      </div>
                      <div
                        class="flex items-end pr-10 mt-1"
                        v-if="msgPost.message != null"
                      >
                        <img
                          :src="msg.get_message_sender.profilePicture"
                          class="rounded-lg h-8 w-8"
                        />
                        <div class="rounded-lg">
                          <div
                            class="ml-4 mr-10 p-3 bg-gray-100 text-sm rounded-lg"
                          >
                            <p>{{ msgPost.message }}</p>

                            <span
                              class="text-gray-500 pl-1"
                              style="font-size: 10.5px"
                              >{{ timestamp(msg.dateCreated) }}</span
                            >
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- end of post message -->
                  </div>
                  <!--end of incoming message-->
                </div>
                <div v-else>
                  <!--your outgoing messages-->
                  <div
                    v-if="
                      hasPostNum(msg.messageText) == -1 &&
                      hasTransactionMessage(msg.messageText) == -1
                    "
                  >
                    <div class="p-2 flex justify-end">
                      <div
                        class="ml-32 pt-2 pl-4 pb-3 pr-4 bg-gray-200 text-sm rounded-lg"
                      >
                        <p>{{ msg.messageText }}</p>
                        <span
                          class="time_date text-gray-500 pl-1"
                          style="font-size: 10.5px"
                          >{{ timestamp(msg.dateCreated) }}</span
                        >
                      </div>
                    </div>
                  </div>
                  <div v-else-if="hasTransactionMessage(msg.messageText) != -1">
                    <div
                      class="flex justify-center"
                      v-for="(msgStatus, index) in parseString(msg.messageText)"
                      :key="index"
                    >
                      <div
                        class="ml-4 items-center mr-10 p-3 text-gray-400 text-sm"
                      >
                        <p
                          v-if="
                            msgStatus.sender ==
                              this.userPersonal.firstName +
                                ' ' +
                                this.userPersonal.lastName &&
                            msgStatus.status === 'Cancelled'
                          "
                        >
                          You {{ msgStatus.status }} your
                          {{ msgStatus.postIdentity }}
                        </p>
                        <p
                          v-else-if="
                            msgStatus.sender ==
                              this.userPersonal.firstName +
                                ' ' +
                                this.userPersonal.lastName &&
                            (msgStatus.status === 'Declined' ||
                              msgStatus.status === 'Accepted')
                          "
                        >
                          You {{ msgStatus.status }} {{ msgStatus.receiver }}'s
                          {{ msgStatus.postIdentity }}
                        </p>
                        <p
                          v-else-if="
                            msgStatus.receiver ==
                              this.userPersonal.firstName +
                                ' ' +
                                this.userPersonal.lastName &&
                            msgStatus.status == 'Cancelled'
                          "
                        >
                          {{ msgStatus.sender }} {{ msgStatus.status }} their
                          {{ msgStatus.postIdentity }}
                        </p>
                        <p v-else>
                          {{ msgStatus.sender }} {{ msgStatus.status }} your
                          {{ msgStatus.postIdentity }}
                        </p>
                      </div>
                    </div>
                  </div>
                  <div v-else>
                    <!--if the outgoing message is a post-->
                    <div
                      v-for="(msgPost, index) in parseString(msg.messageText)"
                      :key="index"
                    >
                      <div class="flex justify-end mt-2">
                        <div class="ml-32 bg-gray-100 text-sm rounded-lg">
                          <div
                            class="flex flex-col bg-gray-200 py-2 rounded-lg"
                          >
                            <div class="mx-4 mb-2 text-sm font-semibold">
                              <span>Order Details</span>
                            </div>
                            <div class="mx-4 pr-2 pt-3 pb-3 text-sm">
                              <div class="flex flex-col px-2">
                                <div class="flex items-start">
                                  <span
                                    class="text-red-700 material-icons"
                                    style="font-size: 18px"
                                    >place</span
                                  >
                                  <span class="pl-2 pb-1">
                                    {{ msgPost.deliveryAddress }}</span
                                  >
                                </div>
                                <div class="flex items-start">
                                  <span
                                    class="text-red-700 material-icons"
                                    style="font-size: 18px"
                                    >shopping_cart</span
                                  >
                                  <span class="pl-2 pb-1">{{
                                    msgPost.shoppingPlace
                                  }}</span>
                                </div>
                                <div class="flex items-start">
                                  <span
                                    class="text-red-700 material-icons"
                                    style="font-size: 16px"
                                    >watch_later</span
                                  >
                                  <span class="pl-2 pb-1">{{
                                    timestampSched(msgPost.deliverySchedule)
                                  }}</span>
                                </div>
                                <div class="flex items-start">
                                  <span
                                    class="text-red-700 material-icons"
                                    style="font-size: 16px"
                                    >payments</span
                                  >
                                  <span class="pl-2">{{
                                    msgPost.paymentMethod
                                  }}</span>
                                </div>
                              </div>
                            </div>
                            <div class="mx-4 p-2 bg-white rounded-lg text-sm">
                              <div>
                                <span class="font-semibold"
                                  >Shopping List<span class="ml-3 text-gray-500"
                                    >{{
                                      computedShopItemList(
                                        msgPost.shoppingListContent
                                      ).length
                                    }}
                                    items</span
                                  ></span
                                >
                              </div>
                              <div>
                                <ul
                                  class="text-gray-600 list-disc list-inside pl-4"
                                >
                                  <li
                                    v-for="items in computedShopItemList(
                                      msgPost.shoppingListContent
                                    )"
                                    :key="items.ShoppingList"
                                  >
                                    <span>
                                      {{ items.product }} ·
                                      {{ items.brand }} [{{ items.quantity }}
                                      units]
                                    </span>
                                  </li>
                                </ul>
                              </div>
                            </div>
                            <div class="ml-32 pt-2 pl-4 pb-1 pr-4">
                              <span
                                class="time_date text-gray-500"
                                style="font-size: 10.5px"
                              >
                                {{ timestamp(msg.dateCreated) }}
                              </span>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div
                        class="flex justify-end p-2"
                        v-if="msgPost.message != null"
                      >
                        <div class="rounded-lg">
                          <div
                            class="ml-32 pt-2 pl-4 pb-3 pr-4 bg-gray-200 text-sm rounded-lg"
                          >
                            <p>{{ msgPost.message }}</p>

                            <span
                              class="text-gray-500 pl-1"
                              style="font-size: 10.5px"
                              >{{ timestamp(msg.dateCreated) }}</span
                            >
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- end of post meessage outgoiung-->
                  </div>
                  <!--end of outgoing messages-->
                </div>
              </div>
            </div>
          </div>

          <div id="chatmsg-DESKTOP"></div>
        </div>

        <div
          class="pr-4 w-full absolute bottom-3 flex flex-cols justify-between items-center"
          style="min-width: 400"
        >
          <input
            type="text"
            class="w-10/12 h-8 flex pl-4 border focus:outline-none focus:ring-1 focus:ring-gray-400 rounded-full"
            placeholder="Type a message"
            id="typemsg-DESKTOP"
            v-model="message"
            @keyup.enter="sendbtn"
          />
          <button
            @click="sendbtn"
            class="w-8 h-8 flex items-center pl-1 rounded-full focus:outline-none hover:text-red-700"
            type="button"
          >
            <span class="material-icons"> send</span>
          </button>
        </div>
      </div>
      <!--end of chat corner-->
    </div>
  </div>

  <!---------------------------------------------------------------------------------------------------------->
  <!---MOBILE VERSION---->
  <div class="mobileVersion">
    <div v-show="toggleChat">
      <div
        class="bg-gray-50 flex h-full min-h-screen max-h-screen justify-center"
      >
        <!---Chat Corner-->
        <div
          class="mt-20 shadow-md relative vsv:w-full vsvs:w-full x-v:w-full se:w-full vvs:w-full lvs:w-full vs:w-full ssm:w-full xsm:w-full sm:w-full mt-20 w-5/12 md:w-2/3"
        >
          <div
            class="relative flex justify-items-center md:justify-items-center shadow py-3"
          >
            <div class="flex flex-row justify-between">
              <div class="flex flex-row">
                <button
                  id="backNavigator"
                  class="focus:outline-none pl-5 hover:text-red-700"
                  @click="backChat"
                  type="button"
                >
                  <span class="material-icons pt-2" id="iMessage">
                    keyboard_backspace</span
                  >
                </button>

                <h4 class="text-base font-bold pt-2 pl-4">{{ activeName }}</h4>
                <span class="material-icons pl-3 pt-3" id="iCheck">
                  check_circle
                </span>
              </div>

              <div class="align-middle absolute right-2">
                <button
                  @click="threedots"
                  class="focus:bg-gray-300 hover:bg-gray-300 rounded-full px-1 h-6 mr-3 focus:outline-none hover:text-red-700"
                  type="button"
                >
                  <span class="material-icons"> more_horiz</span>
                </button>
              </div>
            </div>
          </div>

          <div
            class="overflow-auto overflow-x-hidden h-4/5"
            id="journal-scrollMobile"
          >
            <div
              class="sticky top-0 w-full p-3 flex justify items-center shadow-lg bg-white border"
              v-for="transaction in transactions"
              :key="transaction.postNumber"
              v-show="
                ifHide &&
                (transaction.emailCustomerShopper == activeEmail1 ||
                  transaction.emailCustomerShopper == activeEmail2) &&
                (transaction.transactionReceiver == activeEmail1 ||
                  transaction.transactionReceiver == activeEmail2) &&
                activeDisplayingTransaction == transaction.transactionNumber
              "
            >
              <!-- sent offer 1--->
              <div
                v-if="
                  transaction.emailCustomerShopper == authUser.email &&
                  (transaction.transactionReceiver == activeEmail1 ||
                    transaction.transactionReceiver == activeEmail2)
                "
              >
                <div
                  class="text-sm w-full"
                  v-if="
                    (transaction.transactionStatus == 'pending' || toggle1) &&
                    isRequestPost(transaction.transactionData) == -1
                  "
                >
                  <div class="flex justify-between items-center">
                    <span
                      >You sent an offer to
                      <span class="font-semibold ml-2">{{ recipient }}</span>
                      <span class="ml-2">for</span>
                      <span class="font-semibold ml-2"
                        >Post {{ transaction.postNumber }}
                      </span></span
                    >

                    <button
                      @click="vertiDots"
                      class="w-4 h-6 py-1 pb-1 pr-1 rounded-full focus:outline-none hover:text-red-700 hover:bg-gray-300 active:bg-gray-300"
                      type="button"
                    >
                      <span class="material-icons" style="font-size: 17px">
                        more_verti</span
                      >
                    </button>
                  </div>
                  <div class="flex justify-end pr-3">
                    <button
                      @click="
                        cancel_transact(
                          transaction.postNumber,
                          transaction.indexTransactionPost,
                          'offer'
                        )
                      "
                      class="mx-2 mt-2 h-7 px-2 hover:text-white hover:bg-gray-300 rounded-full border border-gray-700"
                    >
                      <span>Cancel Offer</span>
                    </button>
                    <button
                      @click="viewDetailsBtn(transaction.transactionNumber)"
                      class="flex items-center mx-2 mt-2 h-7 px-2 hover:bg-gray-300 rounded-full bg-red-700 text-white"
                    >
                      <span>View Post</span>
                    </button>
                  </div>
                </div>

                <!------->
                <!-- sent request 1--->
                <div
                  v-if="
                    (transaction.transactionStatus == 'pending' || toggle2) &&
                    isRequestPost(transaction.transactionData) != -1
                  "
                  class="text-sm w-full"
                >
                  <div class="flex justify-between items-center">
                    <span
                      >You sent a request to
                      <span class="font-semibold ml-2">{{ recipient }}</span>
                      <span class="ml-2">for</span>
                      <span class="font-semibold ml-2"
                        >Post {{ transaction.postNumber }}
                      </span></span
                    >

                    <button
                      @click="vertiDots"
                      class="w-4 h-6 py-1 pb-1 pr-1 rounded-full focus:outline-none hover:text-red-700 hover:bg-gray-300 active:bg-gray-300"
                      type="button"
                    >
                      <span class="material-icons" style="font-size: 17px">
                        more_verti</span
                      >
                    </button>
                  </div>
                  <div class="flex justify-end pr-3">
                    <button
                      @click="
                        cancel_transact(
                          transaction.postNumber,
                          transaction.indexTransactionPost,
                          'request'
                        )
                      "
                      class="mx-2 mt-2 h-7 px-2 hover:text-white hover:bg-gray-300 rounded-full border border-gray-700"
                    >
                      <span>Cancel Request</span>
                    </button>
                    <button
                      @click="viewDetailsBtn(transaction.transactionNumber)"
                      class="flex items-center mx-2 mt-2 h-7 px-2 hover:bg-gray-300 rounded-full bg-red-700 text-white"
                    >
                      <span>View Post</span>
                    </button>
                  </div>
                </div>
              </div>

              <!-- received offer 1--->
              <div
                v-if="
                  (transaction.transactionReceiver == authUser.email &&
                    (transaction.emailCustomerShopper == activeEmail1 ||
                      transaction.emailCustomerShopper == activeEmail2)) ||
                  toggle3
                "
              >
                <div
                  class="text-sm w-full"
                  v-if="
                    (transaction.transactionStatus == 'pending' || toggle3) &&
                    isRequestPost(transaction.transactionData) == -1
                  "
                >
                  <div class="flex justify-between items-center">
                    <span
                      ><span class="font-semibold mr-2"
                        >{{ transaction.transaction_sender.firstName }}
                        {{ transaction.transaction_sender.lastName }}</span
                      >sent you an offer
                      <span class="ml-2">for your </span>
                      <span class="font-semibold ml-2"
                        >Post {{ transaction.postNumber }}
                      </span></span
                    >
                    <button
                      @click="vertiDots"
                      class="w-4 h-6 py-1 pb-1 pr-1 rounded-full focus:outline-none hover:text-red-700 hover:bg-gray-300 active:bg-gray-300"
                      type="button"
                    >
                      <span class="material-icons" style="font-size: 17px">
                        more_verti</span
                      >
                    </button>
                  </div>
                  <div class="flex justify-end pr-3">
                    <button
                      @click="
                        decline_transact(
                          transaction.postNumber,
                          transaction.indexTransactionPost,
                          transaction.emailCustomerShopper,
                          'offer'
                        )
                      "
                      class="mx-2 mt-2 h-7 px-2 hover:text-white hover:bg-gray-300 focus:outline-none rounded-full border border-gray-700"
                    >
                      <span>Decline</span>
                    </button>
                    <button
                      @click="
                        accept_transact(
                          transaction.postNumber,
                          transaction.indexTransactionPost,
                          transaction.emailCustomerShopper,
                          'offer'
                        )
                      "
                      class="mx-2 mt-2 h-7 px-2 hover:bg-gray-300 rounded-full focus:outline-none bg-red-700 text-white"
                    >
                      <span>Accept</span>
                    </button>
                  </div>
                </div>

                <!------->
                <!-- received request 1--->
                <div
                  v-if="
                    (transaction.transactionStatus == 'pending' || toggle4) &&
                    isRequestPost(transaction.transactionData) != -1
                  "
                  class="text-sm w-full"
                >
                  <div class="flex justify-between items-center">
                    <span
                      ><span class="font-semibold mr-2">{{ sender }}</span
                      >sent you a request
                      <span class="ml-2">for your </span>
                      <span class="font-semibold ml-2"
                        >Post {{ postNum2 }}
                      </span></span
                    >
                    <button
                      @click="vertiDots"
                      class="w-4 h-6 py-1 pb-1 pr-1 rounded-full focus:outline-none hover:text-red-700 hover:bg-gray-300 active:bg-gray-300"
                      type="button"
                    >
                      <span class="material-icons" style="font-size: 17px">
                        more_verti</span
                      >
                    </button>
                  </div>
                  <div class="flex justify-end pr-3">
                    <button
                      @click="
                        decline_transact(
                          transaction.postNumber,
                          transaction.indexTransactionPost,
                          transaction.emailCustomerShopper,
                          'request'
                        )
                      "
                      class="mx-2 mt-2 h-7 px-2 hover:text-white hover:bg-gray-300 focus:outline-none rounded-full border border-gray-700"
                    >
                      <span>Decline</span>
                    </button>
                    <button
                      @click="
                        accept_transact(
                          transaction.postNumber,
                          transaction.indexTransactionPost,
                          transaction.emailCustomerShopper,
                          'request'
                        )
                      "
                      class="mx-2 mt-2 h-7 px-2 hover:bg-gray-300 rounded-full focus:outline-none bg-red-700 text-white"
                    >
                      <span>Accept</span>
                    </button>
                  </div>
                </div>
              </div>
              <!--------------transaction details confirmed------>
              <div
                v-else-if="
                  transaction.transactionStatus === 'Confirmed' ||
                  transaction.transactionStatus === 'confirmed'
                "
                class="text-sm w-full"
              >
                <div class="flex flex-row justify-between">
                  <span
                    >Transaction
                    <span class="font-semibold ml-2"
                      >#{{ transaction.transactionNumber }}
                    </span>
                  </span>

                  <div class="flex items-center">
                    <span class="rounded border h-6 border-blue-700 px-1"
                      >Confirmed</span
                    >

                    <button
                      @click="vertiDots"
                      class="w-4 h-6 py-1 pb-1 pr-1 rounded-full focus:outline-none hover:text-red-700 hover:bg-gray-300 active:bg-gray-300"
                      type="button"
                    >
                      <span class="material-icons" style="font-size: 17px">
                        more_verti</span
                      >
                    </button>
                  </div>
                </div>
                <div class="flex justify-end pr-3">
                  <button
                    @click="viewDetailsBtn(transaction.transactionNumber)"
                    class="mx-2 mt-2 h-7 px-2 hover:text-white hover:bg-gray-300 focus:outline-none rounded-full border border-gray-700"
                  >
                    <span>View Details</span>
                  </button>
                  <button
                    @click="
                      (toggle_status = !toggle_status), (trans_id = itemx.id)
                    "
                    class="mx-2 mt-2 h-7 px-2 hover:bg-gray-300 rounded-full focus:outline-none bg-red-700 text-white"
                  >
                    <span>Update</span>
                  </button>
                </div>
              </div>
              <!------------------->

              <!--------------transaction details cancelled------>
              <div
                v-else-if="transaction.transactionStatus === 'Cancelled'"
                class="text-sm w-full"
              >
                <div class="flex flex-row justify-between">
                  <span
                    >Transaction
                    <span class="font-semibold ml-2"
                      >#{{ transaction.postNumber }}
                    </span>
                  </span>

                  <div class="flex items-center">
                    <span
                      class="rounded border h-6 border-crimsonRed text-crimsonRed px-1"
                      >Cancelled</span
                    >

                    <button
                      @click="vertiDots"
                      class="w-4 h-6 py-1 pb-1 pr-1 rounded-full focus:outline-none hover:text-red-700 hover:bg-gray-300 active:bg-gray-300"
                      type="button"
                    >
                      <span class="material-icons" style="font-size: 17px">
                        more_verti</span
                      >
                    </button>
                  </div>
                </div>
                <div class="flex justify-end pr-3">
                  <button
                    @click="viewDetailsBtn(transaction.transactionNumber)"
                    class="mx-2 mt-2 h-7 px-2 hover:text-white hover:bg-gray-300 focus:outline-none rounded-full border border-gray-700"
                  >
                    <span>View Details</span>
                  </button>
                  <button
                    @click="VOID"
                    class="bg-opacity-50 mx-2 mt-2 h-7 px-2 rounded-full focus:outline-none bg-red-700 text-white"
                  >
                    <span>Update</span>
                  </button>
                </div>
              </div>
              <!------------------->
              <!-----vertical-dot  options-->
              <div
                v-if="toggleVerti"
                id="vertiOPTIONS-MOBILE"
                class="absolute right-4 top-2 xl:fixed xl:top-36 xl:right-16 px-2 mr-4 bg-gray-200 w-2/5 shadow-inner rounded-lg border-solid border-2 border-white"
                style="width: 220px"
              >
                <div class="flex flex-col">
                  <div class="flex flex-row items-center">
                    <button
                      @click="hideVertiOptions"
                      class="w-full items-center flex py-1 hover:bg-white hover:text-crimsonRed justify-start mt-2 border border-gray-300 rounded-lg"
                    >
                      <span class="material-icons pl-3" style="font-size: 20px"
                        >visibility</span
                      >
                      <span class="font-semibold pl-2">Hide</span>
                    </button>
                  </div>
                  <div class="divide-y divide-gray-300 tracking-wide">
                    <div class="flex flex-col pb-2">
                      <span
                        class="pl-1 font-semibold py-1 text-gray-500 py-1 text-xs"
                        >Request(s)/Offers RECEIVED</span
                      >
                      <button
                        v-for="(received, index) in transactionsReceived"
                        :key="index"
                        @click="active_transact(received.transactionNumber)"
                        class="h-6 flex items-center rounded tracking-wide py-1 flex text-xs hover:bg-gray-400 hover:text-white justify-start pl-4"
                      >
                        <span
                          v-if="isRequestPost(received.transactionData) != -1"
                          >Offer #{{ index + 1 }}</span
                        >
                        <span v-else>Request #{{ index + 1 }}</span>
                      </button>
                    </div>

                    <div class="flex flex-col pb-2">
                      <span
                        class="pl-1 font-semibold text-gray-500 py-1 py-1 text-xs"
                        >Request(s)/Offers SENT</span
                      >
                      <button
                        v-for="(sent, index) in transactionsSent"
                        :key="index"
                        @click="active_transact(sent.transactionNumber)"
                        class="h-6 flex items-center rounded tracking-wide py-1 flex text-xs hover:bg-gray-400 hover:text-white justify-start pl-4"
                      >
                        <span v-if="isRequestPost(sent.transactionData) != -1"
                          >Offer #{{ index + 1 }}</span
                        >
                        <span v-else>Request #{{ index + 1 }}</span>
                      </button>
                    </div>

                    <div class="flex flex-col pb-2">
                      <span
                        class="pl-1 font-semibold text-gray-500 py-1 py-1 text-xs"
                        >OTHER TRANSACTIONS</span
                      >
                      <button
                        v-for="(transact, index) in transactions"
                        :key="index"
                        @click="active_transact(transact.transactionNumber)"
                      >
                        <span
                          v-if="
                            transact.transactionStatus === 'Confirmed' ||
                            transact.transactionStatus === 'confirmed' ||
                            transact.transactionStatus === 'In Transit'
                          "
                          class="h-6 flex items-center tracking-wide rounded py-1 flex text-xs hover:bg-gray-400 hover:text-white text-blue-500 justify-start pl-4"
                          >Transaction #{{ index + 1 }}</span
                        >
                        <span
                          v-else-if="
                            transact.transactionStatus === 'Cancelled' ||
                            transact.transactionStatus === 'Declined'
                          "
                          class="h-6 flex items-center tracking-wide rounded py=1 flex text-xs hover:bg-gray-400 hover:text-white text-crimsonRed justify-start pl-4"
                          >Transaction #{{ index + 1 }}</span
                        >
                      </button>
                      <span
                        class="pl-4 font-semibold italic text-gray-400 py-1 py-1 text-xs"
                        >No other transactions</span
                      >
                    </div>
                  </div>
                </div>
              </div>
              <!-----end of transaction options--->
              <!------------------->
            </div>
            <!--end of vfor transaction-->
            <div
              v-show="toggle"
              id="delBtn-MOBILE"
              class="absolute top-16 right-1.5 shadow-lg bg-gray-100 border-2 rounded w-56 flex flex-col justify-center text-sm"
            >
              <button
                class="tracking-wide bg-gray-100 font-semibold hover:border-white hover:bg-crimsonRed hover:text-white p-2"
              >
                Delete
              </button>
              <button
                v-if="!ifHide"
                @click="showVertiOptions"
                class="tracking-wide bg-gray-100 font-semibold hover:border-white hover:bg-crimsonRed hover:text-white p-2"
              >
                Show Transactions
              </button>
            </div>

            <!-- start opf mobile convo-->
            <!--incoming message-->
            <div
              class="p-1 pl-2"
              v-for="(chat, index) in chatRooms"
              :key="index"
            >
              <div v-if="chat.messageRoomNumber === activeRoom">
                <div v-for="(msg, index) in chat.get_messages" :key="index">
                  <div v-if="msg.messageSender != authUser.email">
                    <!--your incoming messages-->
                    <div
                      v-if="
                        hasPostNum(msg.messageText) == -1 &&
                        hasTransactionMessage(msg.messageText) == -1
                      "
                    >
                      <div class="p-1 pl-2">
                        <div class="flex items-end pr-10 mt-1">
                          <img
                            :src="msg.get_message_sender.profilePicture"
                            alt="sunil"
                            class="rounded-lg h-8 w-8"
                          />
                          <div class="rounded-lg">
                            <div
                              class="ml-4 mr-10 p-3 bg-gray-100 text-sm rounded-lg"
                            >
                              <p>{{ msg.messageText }}</p>
                              <span
                                class="text-gray-500 pl-1"
                                style="font-size: 10.5px"
                                >{{ timestamp(msg.dateCreated) }}</span
                              >
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- if the message is transaction status --->
                    <div
                      v-else-if="hasTransactionMessage(msg.messageText) != -1"
                    >
                      <div
                        class="flex justify-center"
                        v-for="(msgStatus, index) in parseString(
                          msg.messageText
                        )"
                        :key="index"
                      >
                        <div class="ml-4 mr-10 p-3 text-gray-400 text-sm">
                          <p
                            v-if="
                              msgStatus.sender ==
                              this.userPersonal.firstName +
                                ' ' +
                                this.userPersonal.lastName
                            "
                          >
                            You {{ msgStatus.status }}
                            {{ msgStatus.receiver }}'s
                            {{ msgStatus.postIdentity }}
                          </p>
                          <p
                            v-else-if="
                              msgStatus.receiver ==
                                this.userPersonal.firstName +
                                  ' ' +
                                  this.userPersonal.lastName &&
                              msgStatus == 'Cancelled'
                            "
                          >
                            {{ msgStatus.sender }} {{ msgStatus.status }} their
                            {{ msgStatus.postIdentity }}
                          </p>
                          <p v-else>
                            {{ msgStatus.sender }} {{ msgStatus.status }} your
                            {{ msgStatus.postIdentity }}
                          </p>
                        </div>
                      </div>
                    </div>
                    <!-- if the message is a post--->
                    <!-----------------incoming post message------------------------>
                    <div v-else>
                      <div
                        v-for="(msgPost, index) in parseString(msg.messageText)"
                        :key="index"
                      >
                        <div class="flex items-end pr-10 mt-1">
                          <img
                            :src="msg.get_message_sender.profilePicture"
                            class="rounded-lg h-8 w-8 mr-2"
                          />
                          <div
                            class="flex flex-col bg-gray-100 py-2 rounded-lg"
                          >
                            <div>
                              <div class="mx-4 mb-2 text-sm font-semibold">
                                <span>Order Details</span>
                              </div>
                              <div class="mx-4 pr-2 pt-3 pb-3 text-sm">
                                <div class="flex flex-col px-2">
                                  <div class="flex items-start">
                                    <span
                                      class="text-red-700 material-icons"
                                      style="font-size: 18px"
                                      >place</span
                                    >
                                    <span class="pl-2 pb-1">{{
                                      msgPost.deliveryAddress
                                    }}</span>
                                  </div>
                                  <div class="flex items-start">
                                    <span
                                      class="text-red-700 material-icons"
                                      style="font-size: 18px"
                                      >shopping_cart</span
                                    >
                                    <span class="pl-2 pb-1">{{
                                      msgPost.shoppingPlace
                                    }}</span>
                                  </div>
                                  <div class="flex items-start">
                                    <span
                                      class="text-red-700 material-icons"
                                      style="font-size: 16px"
                                      >watch_later</span
                                    >
                                    <span class="pl-2 pb-1">{{
                                      timestampSched(msgPost.deliverySchedule)
                                    }}</span>
                                  </div>
                                  <div class="flex items-start">
                                    <span
                                      class="text-red-700 material-icons"
                                      style="font-size: 16px"
                                      >payments</span
                                    >
                                    <span class="pl-2">{{
                                      msgPost.paymentMethod
                                    }}</span>
                                  </div>
                                </div>
                              </div>
                              <div class="mx-4 p-2 bg-white rounded-lg text-sm">
                                <div>
                                  <span class="font-semibold"
                                    >Shopping List<span
                                      class="ml-3 text-gray-500"
                                      >{{
                                        computedShopItemList(
                                          msgPost.shoppingListContent
                                        ).length
                                      }}
                                      items</span
                                    ></span
                                  >
                                </div>
                                <div>
                                  <ul
                                    class="text-gray-600 list-disc list-inside pl-4"
                                  >
                                    <li
                                      v-for="items in computedShopItemList(
                                        msgPost.shoppingListContent
                                      )"
                                      :key="items.id"
                                    >
                                      <span>
                                        {{ items.product }} ·
                                        {{ items.brand }} [{{ items.quantity }}
                                        units]
                                      </span>
                                    </li>
                                  </ul>
                                </div>
                              </div>
                            </div>
                            <div class="ml-0 mr-10 pb-1">
                              <span
                                class="time_date text-gray-500"
                                style="font-size: 10.5px"
                              >
                                {{ timestamp(msg.dateCreated) }}
                              </span>
                            </div>
                          </div>
                        </div>
                        <div
                          class="flex items-end pr-10 mt-1"
                          v-if="msgPost.message != null"
                        >
                          <img
                            :src="msg.get_message_sender.profilePicture"
                            class="rounded-lg h-8 w-8"
                          />
                          <div class="rounded-lg">
                            <div
                              class="ml-4 mr-10 p-3 bg-gray-100 text-sm rounded-lg"
                            >
                              <p>{{ msgPost.message }}</p>

                              <span
                                class="text-gray-500 pl-1"
                                style="font-size: 10.5px"
                                >{{ timestamp(msg.dateCreated) }}</span
                              >
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- end of post message -->
                    </div>
                    <!--end of incoming message-->
                  </div>
                  <div v-else>
                    <!--start of outgoing message-->
                    <div
                      v-if="
                        hasPostNum(msg.messageText) == -1 &&
                        hasTransactionMessage(msg.messageText) == -1
                      "
                    >
                      <div class="p-2 flex justify-end">
                        <div
                          class="ml-32 pt-2 pl-4 pb-3 pr-4 bg-gray-200 text-sm rounded-lg"
                        >
                          <p>{{ msg.messageText }}</p>
                          <span
                            class="time_date text-gray-500 pl-1"
                            style="font-size: 10.5px"
                            >{{ timestamp(msg.dateCreated) }}</span
                          >
                        </div>
                      </div>
                    </div>
                    <!--if message is a transation update-->
                    <div
                      v-else-if="hasTransactionMessage(msg.messageText) != -1"
                    >
                      <div
                        class="flex justify-center"
                        v-for="(msgStatus, index) in parseString(
                          msg.messageText
                        )"
                        :key="index"
                      >
                        <div
                          class="ml-4 items-center mr-10 p-3 text-gray-400 text-sm"
                        >
                          <p
                            v-if="
                              msgStatus.sender ==
                              this.userPersonal.firstName +
                                ' ' +
                                this.userPersonal.lastName
                            "
                          >
                            You {{ msgStatus.status }}
                            {{ msgStatus.receiver }}'s
                            {{ msgStatus.postIdentity }}
                          </p>
                          <p
                            v-else-if="
                              msgStatus.receiver ==
                                this.userPersonal.firstName +
                                  ' ' +
                                  this.userPersonal.lastName &&
                              msgStatus.status == 'Cancelled'
                            "
                          >
                            {{ msgStatus.sender }} {{ msgStatus.status }} their
                            {{ msgStatus.postIdentity }}
                          </p>
                          <p v-else>
                            {{ msgStatus.sender }} {{ msgStatus.status }} your
                            {{ msgStatus.postIdentity }}
                          </p>
                        </div>
                      </div>
                    </div>
                    <div v-else>
                      <!--if the outgoing message is a post-->
                      <div
                        v-for="(msgPost, index) in parseString(msg.messageText)"
                        :key="index"
                      >
                        <div class="flex justify-end mt-2">
                          <div class="ml-32 bg-gray-100 text-sm rounded-lg">
                            <div
                              class="flex flex-col bg-gray-200 py-2 rounded-lg"
                            >
                              <div class="mx-4 mb-2 text-sm font-semibold">
                                <span>Order Details</span>
                              </div>
                              <div class="mx-4 pr-2 pt-3 pb-3 text-sm">
                                <div class="flex flex-col px-2">
                                  <div class="flex items-start">
                                    <span
                                      class="text-red-700 material-icons"
                                      style="font-size: 18px"
                                      >place</span
                                    >
                                    <span class="pl-2 pb-1">
                                      {{ msgPost.deliveryAddress }}</span
                                    >
                                  </div>
                                  <div class="flex items-start">
                                    <span
                                      class="text-red-700 material-icons"
                                      style="font-size: 18px"
                                      >shopping_cart</span
                                    >
                                    <span class="pl-2 pb-1">{{
                                      msgPost.shoppingPlace
                                    }}</span>
                                  </div>
                                  <div class="flex items-start">
                                    <span
                                      class="text-red-700 material-icons"
                                      style="font-size: 16px"
                                      >watch_later</span
                                    >
                                    <span class="pl-2 pb-1">{{
                                      timestampSched(msgPost.deliverySchedule)
                                    }}</span>
                                  </div>
                                  <div class="flex items-start">
                                    <span
                                      class="text-red-700 material-icons"
                                      style="font-size: 16px"
                                      >payments</span
                                    >
                                    <span class="pl-2">{{
                                      msgPost.paymentMethod
                                    }}</span>
                                  </div>
                                </div>
                              </div>
                              <div class="mx-4 p-2 bg-white rounded-lg text-sm">
                                <div>
                                  <span class="font-semibold"
                                    >Shopping List<span
                                      class="ml-3 text-gray-500"
                                      >{{
                                        computedShopItemList(
                                          msgPost.shoppingListContent
                                        ).length
                                      }}
                                      items</span
                                    ></span
                                  >
                                </div>
                                <div>
                                  <ul
                                    class="text-gray-600 list-disc list-inside pl-4"
                                  >
                                    <li
                                      v-for="items in computedShopItemList(
                                        msgPost.shoppingListContent
                                      )"
                                      :key="items.ShoppingList"
                                    >
                                      <span>
                                        {{ items.product }} ·
                                        {{ items.brand }} [{{ items.quantity }}
                                        units]
                                      </span>
                                    </li>
                                  </ul>
                                </div>
                              </div>
                              <div class="ml-32 pt-2 pl-4 pb-1 pr-4">
                                <span
                                  class="time_date text-gray-500"
                                  style="font-size: 10.5px"
                                >
                                  {{ timestamp(msg.dateCreated) }}
                                </span>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div
                          class="flex justify-end pr-0 mt-1"
                          v-if="msgPost.message != null"
                        >
                          <div class="rounded-lg">
                            <div
                              class="ml-4 mr-10 p-3 bg-gray-100 text-sm rounded-lg"
                            >
                              <p>{{ msgPost.message }}</p>

                              <span
                                class="text-gray-500 pl-1"
                                style="font-size: 10.5px"
                                >{{ timestamp(msg.dateCreated) }}</span
                              >
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- end of post meessage outgoiung-->
                      <div>
                        <!--end of outgoing messages-->
                      </div>
                    </div>
                  </div>
                </div>

                <div id="chatmsg-MOBILE"></div>
              </div>
            </div>

            <div
              class="pr-4 w-full absolute bottom-3 flex flex-cols justify-between items-center"
              style="min-width: 400"
            >
              <button
                class="h-6 w-6 ml-4 mr-1 bg-gray-400 rounded-full focus:outline-none hover:text-white"
                @click="attachbtn"
                type="button"
              >
                <span class="material-icons" id="attach2"> {{ attach }}</span>
              </button>
              <input
                type="text"
                class="w-10/12 h-8 flex pl-4 border focus:outline-none focus:ring-1 focus:ring-gray-400 rounded-full"
                placeholder="Type a message"
                id="typemsg-MOBILE"
                v-model="message2"
                @keyup.enter="sendbtn"
              />
              <button
                @click="sendbtn"
                class="w-8 h-8 flex items-center pl-1 rounded-full focus:outline-none hover:text-red-700"
                type="button"
              >
                <span class="material-icons"> send</span>
              </button>
            </div>
          </div>
          <!--end of right corner-->
        </div>
      </div>
    </div>
    <!-------------end chatbox------------->
    <div v-show="toggleInbox">
      <div
        class="bg-gray-50 flex h-full min-h-screen max-h-screen w-full justify-center pb-2"
      >
        <!--Inbox Corner-->
        <div
          class="mt-20 shadow-md vsv:w-full vsvs:w-full x-v:w-full se:w-full vvs:w-full lvs:w-full vs:w-full ssm:w-full xsm:w-full sm:w-full mt-20 md:w-1/3 relative"
        >
          <div
            id="msgheader"
            class="flex justify-items-center relative shadow pt-5 pb-1"
          >
            <button
              class="focus:outline-none pl-5 hover:text-red-700"
              @click="backbtn()"
              type="button"
            >
              <span class="material-icons pt-1" id="iMessage"> chat</span>
            </button>
            <h4 class="tracking-wider text-base font-bold pl-4">Message</h4>
          </div>
          <!--search for users-->
          <div
            v-if="searchMessageInactive"
            class="flex justify-center w-full relative py-1 mt-2 pt-2"
          >
            <input
              type="text"
              class="h-8 w-11/12 pl-5 border font-normal text-sm focus:outline-none focus:ring-1 focus:ring-gray-300 rounded-full"
              placeholder="Search"
              v-model="searchInput"
              @keyup="searchBtn()"
            />
            <button
              @click="searchBtn()"
              class="align-middle absolute right-8 pt-1 h-7 focus:outline-none hover:text-red-700"
            >
              <span class="material-icons" style="font-size: 22px">
                search
              </span>
            </button>
          </div>
          <!---end of search bar-->
          <!-- show results of search-->
          <button
            v-if="showSearchResults"
            class="flex justify-center w-full relative py-1 mt-2 pt-2 focus:outline-none"
          >
            <input
              type="text"
              class="h-8 w-10/12 pl-5 border font-normal text-sm focus:outline-none focus:ring-1 focus:ring-gray-300 rounded-full"
              placeholder="Mark"
              id="search"
            />
            <button
              class="align-middle mt-1 ml-1 flex items-center h-6 w-6 rounded-full bg-gray-300 focus:outline-none hover:text-red-700"
            >
              <span
                @click="closeSearchResults"
                class="material-icons pl-1"
                style="font-size: 17px"
              >
                close
              </span>
            </button></button
          ><!---end of search bar-->
          <!-- start of loop for rooms/users-->

          <div
            class="overflow-auto overflow-x-hidden px-0 py-1 h-4/5"
            id="scrollInbox"
          >
            <div
              v-if="
                (searchMessageInactive && activeRoom != null) || toggleInbox
              "
            >
              <button
                v-for="(chatRoom, index) in chatRooms"
                :key="index"
                @click="
                  setRoom(
                    chatRoomNames[index],
                    chatRoom.messageRoomNumber,
                    chatRoom.email1,
                    chatRoom.email2
                  )
                "
                type="button"
                class="focus:bg-gray-200 relative w-full sm:pr-8 flex focus:outline-none justify-between items-center mt-2 p-2 hover:shadow-lg cursor-pointer transition"
              >
                <div class="flex ml-2">
                  <div v-if="ifOnline(chatRoom.email1, chatRoom.email2)">
                    <img
                      src="/img/online.png"
                      alt="sunil"
                      class="rounded-sm h-2 w-2 pb-0 mt-3 mr-2"
                    />
                  </div>
                  <img
                    :src="chatRoomPic[index]"
                    alt="sunil"
                    class="rounded-lg h-8 w-7 pt-1"
                  />
                  <div
                    class="flex flex-col justify-between items-start ml-2"
                    v-if="chatRoom.get_messages.length != 0"
                  >
                    <span class="font-medium text-sm" id="mark">
                      {{ chatRoomNames[index] }}
                      <span
                        class="material-icons pl-2"
                        id="iCheck"
                        style="font-size: 14px"
                      >
                        check_circle
                      </span></span
                    >
                    <span
                      class="text-xs text-gray-400 truncate w-36 md:w-28 lvs:w-64 sm:w-64 ssm:w-24 flex items-end"
                      v-if="
                        chatRoom.get_messages[chatRoom.get_messages.length - 1]
                          .messageSender === authUser.email
                      "
                    >
                      You :
                      <strong
                        v-if="
                          hasPostNum(
                            chatRoom.get_messages[
                              chatRoom.get_messages.length - 1
                            ].messageText
                          ) == -1 &&
                          hasTransactionMessage(
                            chatRoom.get_messages[
                              chatRoom.get_messages.length - 1
                            ].messageText
                          ) == -1
                        "
                        >{{
                          chatRoom.get_messages[
                            chatRoom.get_messages.length - 1
                          ].messageText
                        }}</strong
                      >
                      <strong
                        v-else-if="
                          hasTransactionMessage(
                            chatRoom.get_messages[
                              chatRoom.get_messages.length - 1
                            ].messageText
                          ) == -1
                        "
                      >
                        {{
                          parseString(
                            chatRoom.get_messages[
                              chatRoom.get_messages.length - 1
                            ].messageText
                          )[0].message
                        }}
                      </strong>
                      <strong v-else>
                        You
                        {{
                          parseString(
                            chatRoom.get_messages[
                              chatRoom.get_messages.length - 1
                            ].messageText
                          )[0].status
                        }}
                        {{
                          parseString(
                            chatRoom.get_messages[
                              chatRoom.get_messages.length - 1
                            ].messageText
                          )[0].receiver
                        }}'s offer/post
                      </strong>
                    </span>
                    <span
                      class="text-xs text-gray-400 truncate w-36 md:w-28 lvs:w-64 sm:w-64 ssm:w-24 flex items-end"
                      v-else
                    >
                      {{
                        chatRoom.get_messages[chatRoom.get_messages.length - 1]
                          .get_message_sender.firstName
                      }}
                      {{
                        chatRoom.get_messages[chatRoom.get_messages.length - 1]
                          .get_message_sender.lastName
                      }}:
                      <strong
                        v-if="
                          hasPostNum(
                            chatRoom.get_messages[
                              chatRoom.get_messages.length - 1
                            ].messageText
                          ) == -1 &&
                          hasTransactionMessage(
                            chatRoom.get_messages[
                              chatRoom.get_messages.length - 1
                            ].messageText
                          ) == -1
                        "
                        >{{
                          chatRoom.get_messages[
                            chatRoom.get_messages.length - 1
                          ].messageText
                        }}</strong
                      >
                      <strong
                        v-else-if="
                          hasTransactionMessage(
                            chatRoom.get_messages[
                              chatRoom.get_messages.length - 1
                            ].messageText
                          ) == -1
                        "
                      >
                        {{
                          parseString(
                            chatRoom.get_messages[
                              chatRoom.get_messages.length - 1
                            ].messageText
                          )[0].message
                        }}
                      </strong>
                      <strong v-else>
                        {{
                          parseString(
                            chatRoom.get_messages[
                              chatRoom.get_messages.length - 1
                            ].messageText
                          )[0].receiver
                        }}
                        {{
                          parseString(
                            chatRoom.get_messages[
                              chatRoom.get_messages.length - 1
                            ].messageText
                          )[0].status
                        }}
                        your offer/post
                      </strong>
                    </span>
                  </div>
                  <div
                    class="flex flex-col justify-between items-start ml-2"
                    v-else
                  >
                    <span class="font-medium text-sm" id="mark">
                      {{ chatRoomNames[index] }}
                      <span class="material-icons pl-2" id="iCheck">
                        check_circle
                      </span>
                    </span>
                  </div>
                </div>
                <div
                  class="flex flex-col items-start"
                  v-if="chatRoom.get_messages.length != 0"
                >
                  <span class="text-gray-700 text-xs">
                    <span class="font-bold pl-1 pr-1">· </span>
                    {{
                      timestampRoom(
                        chatRoom.get_messages[chatRoom.get_messages.length - 1]
                          .dateCreated
                      )
                    }}
                  </span>
                </div>
              </button>
            </div>
            <!---------------navigation message------------>
            <!--show message search users-->
            <!-- <div v-if="showSearchResults" class="divide-y divide-gray-300">
              <div class="py-2 flex justify-center font-normal text-xs italic">
                <span>Search Results</span>
              </div>
              <div>
                <button
                  @click="Void"
                  type="button"
                  class="focus:bg-gray-200 relative w-full flex sm:pr-8 focus:outline-none justify-between items-center mt-2 p-2 hover:shadow-lg cursor-pointer transition"
                >
                  <div class="flex ml-2">
                    <img
                      src="https://ptetutorials.com/images/user-profile.png"
                      alt="sunil"
                      class="rounded-lg h-8 w-7 pt-1"
                    />
                    <div class="flex flex-col justify-between items-start ml-2">
                      <span class="font-medium text-sm italic" id="mark">
                        <span class="text-red-700">Mark</span> Aral
                        <span class="material-icons pl-2" id="iCheck">
                          check_circle
                        </span></span
                      >
                      <span
                        class="text-xs text-gray-400 truncate md:w-28 w-36 lvs:w-64 sm:w-72 ssm:w-24"
                      >
                        {{ inbox[0].message }}
                      </span>
                    </div>
                  </div>
                  <div class="flex flex-col items-start">
                    <span class="text-gray-700 text-xs">
                      <span class="font-bold pl-1 pr-1">·</span
                      >{{ inbox[0].time }}</span
                    >
                  </div>
                </button>
              </div>
            </div> -->
            <!---------------search message results------------>
          </div>
        </div>
        <!--end of left corner-->
      </div>
    </div>
  </div>
  <!--close mobile view-->

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

        <div
          v-if="
            currentPostViewDetails.transaction_sender.email != authUser.email
          "
        >
          <p
            v-if="currentPostViewDetails.post.request_post != null"
            class="text-lg ssm:text-sm vs:text-base font-bold leading-normal text-center text-gray-900"
          >
            Offer from {{ recipient }}
          </p>
          <p
            v-else
            class="text-lg ssm:text-sm vs:text-base font-bold leading-normal text-center text-gray-900"
          >
            Request from {{ recipient }}
          </p>
        </div>
        <div v-else>
          <p
            v-if="currentPostViewDetails.post.request_post != null"
            class="text-lg ssm:text-sm vs:text-base font-bold leading-normal text-center text-gray-900"
          >
            Offer from you
          </p>
          <p
            v-else
            class="text-lg ssm:text-sm vs:text-base font-bold leading-normal text-center text-gray-900"
          >
            Request from you
          </p>
        </div>

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
        <div
          v-if="
            currentPostViewDetails.transaction_sender.email != authUser.email
          "
        >
          <img
            :src="currentPostViewDetails.transaction_sender.profilePicture"
            class="rounded-full w-10 h-10"
          />
        </div>
        <div v-else>
          <img
            :src="currentPostViewDetails.post.user.profilePicture"
            class="rounded-full w-10 h-10"
          />
        </div>

        <div class="flex flex-col">
          <div class="flex-row flex space-x-1 items-center">
            <p class="text-base font-bold leading-none text-gray-900">
              {{ currentPostViewDetails.post.user.firstName }}
              {{ currentPostViewDetails.post.user.lastName }}
            </p>

            <span
              v-show="
                ifUserVerified(currentPostViewDetails.transaction_sender.email)
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
        class="flex flex-col ssm:mt-2 vs:mt-2 mt-3 w-full items-start justify-start h-auto vs:pr-0 vs:min-w-0 vs:px-2 ssm:pr-0 ssm:min-w-0 ssm:px-2 p-4 bg-gray-100 rounded-xl"
      >
        <div class="inline-flex flex-row space-x-4">
          <span class="text-base ssm:text-sm leading-none text-gray-900"
            >Shopping List</span
          >
          <span class="text-base ssm:text-sm leading-none text-gray-500"
            >{{
              computedShopItemList(
                currentPostViewDetails.transactionShoppingList
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
          v-if="isFew(currentPostViewDetails.transactionShoppingList)"
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
        v-if="
          currentPostViewDetails.transactionStatus == 'pending' &&
          currentPostViewDetails.post.postIdentity == 'request_post'
        "
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
          @click="acceptDisRequest"
          class="focus:outline-none inline-flex items-center justify-center w-52 px-3 py-1 bg-red-700 rounded-full"
        >
          <p class="text-base font-bold leading-normal text-center text-white">
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
      v-if="accept && currentPostIdentity == 'request'"
      class="z-50 fixed inset-0 flex justify-center items-center ssm:px-2 vs:px-2"
    >
      <div
        class="inline-flex flex-col bg-white shadow rounded-xl h-auto w-95 space-y-4 p-4 ssm:w-full vs:w-full"
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
            Accept {{ recipient }}'s Request
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
            Are you sure you want to accept {{ recipient }}'s request?
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
  </transition>
  <!--end-->

  <!--Decline User Request Button Modal-->
  <transition name="fadeSlide">
    <div
      v-if="decline && currentPostIdentity === 'request'"
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
            Decline {{ recipient }}'s Request
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
            Are you sure you want to decline {{ recipient }}'s request? You can
            not undo this.
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
            @click="confirmDeclineDisRequest"
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
  <!--end-->

  <!--Accept Offer Modal-->
  <div
    v-if="accept && currentPostIdentity == 'offer'"
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
          Accept {{ recipient }}'s Offer
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
          Are you sure you want to accept {{ recipient }}'s Offer? This would
          decline all other offers you received for this post and will
          automatically update your post status
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
          <p class="text-base font-bold leading-normal text-center text-white">
            Confirm
          </p>
        </button>
      </div>
    </div>
  </div>
  <!--end-->

  <!--Decline Offer Modal-->
  <div
    v-if="decline && currentPostIdentity == 'offer'"
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
          Decline {{ recipient }}'s Offer
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
          Are you sure you want to decline {{ recipient }}'s Offer? You can not
          undo this.
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
          @click="confirmDeclineDisRequest"
          class="focus:outline-none inline-flex items-center justify-center w-52 px-3 py-1 bg-red-700 rounded-full"
        >
          <p class="text-base font-bold leading-normal text-center text-white">
            Confirm
          </p>
        </button>
      </div>
    </div>
  </div>
  <!--end-->

  <!--Cancellation Modal-->
  <div
    v-if="cancel"
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
          Cancel {{ currentPostIdentity }}
        </p>
        <button
          @click="cancel = !cancel"
          class="focus:outline-none text-sm font-bold leading-none text-right text-indigo-900"
        >
          Close
        </button>
      </div>
      <hr class="w-full" />
      <div class="flex w-full">
        <p class="block items-start leading-normal text-base text-gray-900">
          Are you sure you want to cancel your {{ currentPostIdentity }} to
          {{ recipient }}'s post? You can not undo this.
        </p>
      </div>
      <div class="justify-between flex flex-row space-x-2 w-full">
        <button
          @click="cancel = !cancel"
          class="focus:outline-none inline-flex items-center justify-center w-52 px-3 py-1 border-2 rounded-full border-red-700"
        >
          <p
            class="text-base font-bold leading-normal text-center text-gray-900"
          >
            Cancel
          </p>
        </button>
        <button
          @click="confirmCancellation"
          class="focus:outline-none inline-flex items-center justify-center w-52 px-3 py-1 bg-red-700 rounded-full"
        >
          <p class="text-base font-bold leading-normal text-center text-white">
            Confirm
          </p>
        </button>
      </div>
    </div>
  </div>
  <!--end-->

  <!--Accept PopUp Notification-->
  <div class="z-100 fixed inset-x-0 bottom-2 flex justify-center items-center">
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
            Successfully Accepted {{ recipient }}'s {{ currentPostIdentity }}
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

  <!--Decline PopUp Notification-->
  <div class="z-100 fixed inset-x-0 bottom-2 flex justify-center items-center">
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
            Successfully Declined {{ recipient }}'s {{ currentPostIdentity }}
          </p>
        </div>
        <button
          @click="closeDeclineRequestNotiPop"
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

  <!--Cancel PopUp Notification-->
  <div class="z-100 fixed inset-x-0 bottom-2 flex justify-center items-center">
    <div
      v-if="confirmCancel"
      class="declineRequestNotiPop bg-gray-900 text-white px-4 py-2 rounded-xl w-95 h-auto"
      role="alert"
    >
      <div class="flex w-full flex-row justify-between items-center">
        <div class="flex flex-row w-full space-x-2">
          <span class="w-6 h-6 rounded-full material-icons text-white">
            check_circle
          </span>
          <p class="text-base leading-normal text-white">
            Successfully cancelled your {{ currentPostIdentity }} to
            {{ recipient }}'s {{ activePostNum }}
          </p>
        </div>
        <button
          @click="
            confirmCancel = false;
            this.currentPostIdentity = null;
            this.activePostNum = null;
            this.activeIndexTransNum = null;
          "
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

  <!----update status--->
  <div
    v-if="false"
    class="fixed bg-black z-100 h-max w-screen bg-opacity-75 overflow-y-auto items-center inset-0"
  >
    <div class="flex mt-4 w-full p-3 items-center justify-center py-20">
      <div
        class="bg-white ring-1 ring-gray-300 p-5 w-full rounded-xl 2xl:w-97 lg:w-97 xl:w-97 xl:mr-16 md:w-8/12 sm:w-10/12 shadow-2xl h-auto"
      >
        <div class="flex flex-row items-center justify-between p-3">
          <p class="hidden lg:block 2xl:block xl:block"></p>
          <p class="text-lg font-bold xl:ml-8 lg:ml-8 2xl:ml-8">
            Update Transaction Status
          </p>
          <p
            class="font-bold text-blue-700 cursor-pointer left-10"
            @click="toggle_status = false"
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
              ><input type="radio" name="status" value="Comfirmed" /><span
                >Confirmed</span
              ></span
            >
            <span class="flex items-center space-x-2"
              ><input type="radio" name="status" value="In Transit" /><span
                >In Transit</span
              ></span
            >
            <span class="flex items-center space-x-2"
              ><input type="radio" name="status" value="Cancelled" /><span
                >Cancelled</span
              ></span
            >
          </div>
        </div>
        <div class="flex justify-between mt-4 items-center">
          <button
            @click="toggle_status = false"
            class="bg-red-buttons text-white focus:outline-none w-full h-7 shadow-xl ring-1 ring-gray-300 rounded-2xl"
          >
            Update
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Navbar from "./Navbar";
import api from "../api";
import moment from "moment";
import store from "../store/index";
import Axios from "axios";
import _ from "lodash";
import $ from "jquery";
// var file = "";
export default {
  components: {
    Navbar,
  },
  props: {
    //message: String
  },
  data() {
    return {
      //buttons
      tempUsers: null,
      searchInput: null,
      toggle: false,
      toggleInbox: true,
      toggleChat: false,
      toggleVerti: false,
      searchMessageInactive: true,
      showSearchResults: false,
      attachment: false,
      ifHide: true,
      toggle1: false,
      toggle2: false,
      toggle3: false,
      toggle4: false,
      toggle5: false,
      toggle6: false,
      toggle7: false,
      attach: "add",
      active: "toggle1",
      //chat room variables
      chatRooms: [],
      chatRoomNames: [],
      chatRoomPic: [],

      //inbox
      inbox: [],
      //chat
      activeName: null,
      activeRoom: null,
      chatIncoming: [
        {
          received:
            "Yeah, sure! No problem. I am already on my way to SM City Legazpi.",
          timeReceived: "1:26 PM    |    Today",
        },
        {
          received:
            "Sorry, it took me a while. I had to shop for three orders. Anyway, I am already in my car. I will deliver these two orders first here in Legazpi.",
          timeReceived: "2:40 PM    |    Today",
        },
        {
          received: "I am two mins away from your house. ",
          timeReceived: "3:12 PM    |    Today",
        },
        {
          received: "No problem. Thanks as well for the handsome pay!",
          timeReceived: "3:39 PM    |    Today",
        },
      ],
      chatOutgoing: [
        {
          sent:
            "Do you think you can do it in time? I need it before 4 pm so I hope you can deliver it in time.",
          timeSent: "1:24 PM    |    Today",
        },
        {
          sent: "Thank you so much! Let me know when you are on your way.",
          timeSent: "1:31 PM    |    Today",
        },
        {
          sent: "No problem, chat me when you are near my house already",
          timeSent: "2:45 PM    |    Today",
        },
        { sent: "Thanks for help", timeSent: "3:36  | Today" },
      ],
      message: null,
      message2: null,
      out: [],
      incoming: [],
      chat: [],
      activeEmail1: null,
      activeEmail2: null,

      //sent a request
      activity: "You sent a request to to",
      recipient: "Mark Aral",
      sender: "Monica Rambeau",
      postNum: "#2021352",
      postNum2: "#130317",
      placeFrom: "Banquerohan, Legazpi City",
      destination: "SM City ",
      timeAlloted: "Tomorrow, 5 PM",
      paymentMethod: "Payment First via GCash transfer",
      //shoppingList
      shoppingList: [
        { items: "Baking Soda" },
        { items: "Choco Syrup" },
        { items: "cocoa powder" },
        { items: "flour 1 kg" },
        { items: "brown sugar" },
        { items: "cocoa powder" },
      ],
      shoppingListSize: 8,
      userQueryID: null,
      cancel: false,
      currentPostIdentity: null,
      activePostNum: null,
      activeIndexTransNum: null,
      decline: null,
      activeUser: null,
      accept: null,
      activeDisplayingTransaction: null,
      toggleViewDetails: false,
      currentPostViewDetails: [],
      limit_by: 4,
      default_limit: 4,
      showListStatus: "See More",
      showLessStatus: "See Less",
      isActive: false,
    };
  },
  watch: {
    activeRoom(val, oldval) {
      if (oldval) this.disconnect(oldval);
      this.connect();
    },
    room() {
      console.log("room changed");
      this.getChatRooms();
    },
    transactions() {
      this.getChatRooms();
    },
    onlineUsers() {
      console.log(this.onlineUsers);
    },
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
    isRequestPost(transactionData) {
      return JSON.stringify(transactionData).search("indexOrderRequestPost");
    },
    connect() {
      if (this.activeRoom != null) {
        // console.log("will connect to =====", this.activeRoom)
        let vm = this;
        // vm.getChatRooms();
        window.Echo.private("chat." + this.activeRoom).listen(
          ".message.new",
          (res) => {
            //optimize check if what is the return value, if itcontains transaction then get transaction and get chat rooms, otherwise get only chatroom
            if (this.hasPostNum(res.chatMessage.messageText) != -1) {
              this.debounceMethod(vm);
            } else {
              this.debounceMethodGetMessages(vm);
            }
          }
        );
      }
    },

    debounceMethod: _.debounce((vm) => {
      Axios.all([
        api.get("api/getTransaction"),
        api.get("api/getChatroom"),
      ]).then((res) => {
        // console.log(res[0].data)
        
          store.commit("setUserTransactions", res[0].data);
          store.commit("FETCH_ROOMS", res[1].data);
          vm.getChatRooms();
        
      });
    }, 2000),

    debounceMethodGetMessages: _.debounce((vm) => {
      api.get("api/getChatroom").then(() => {
        console.log("get message");
        vm.getChatRooms();
      });
    }, 2000),

    disconnect(oldval) {
      window.Echo.leave("chat." + oldval);
    },
    sendbtn() {
      var dataMessage;
      var printtext = document.getElementById("chatmsg-DESKTOP");
      var printtext2 = document.getElementById("chatmsg-MOBILE");
      if (this.message != null) {
        var printnow =
          '<div class="p-2 flex justify-end ">' +
          '<div class="ml-32 pt-2 pl-4 pb-3 pr-4 bg-gray-200 text-sm rounded-lg">' +
          this.message +
          '<span class="time_date text-gray-500 pl-1" style="font-size: 10.5px;" >' +
          "<br>" +
          "Sending..." +
          "</span>" +
          "</div> " +
          "</div>";
        console.log(printtext);
        printtext.insertAdjacentHTML("beforeend", printnow);
        dataMessage = { roomID: this.activeRoom, message: this.message };
        console.log(dataMessage);
        this.message = null;
      } else if (this.message2 != null) {
        var printnow2 =
          '<div class="p-2 flex justify-end ">' +
          '<div class="ml-32 pt-2 pl-4 pb-3 pr-4 bg-gray-200 text-sm rounded-lg">' +
          this.message2 +
          '<span class="time_date text-gray-500 pl-1" style="font-size: 10.5px;" >' +
          "<br>" +
          "Sending..." +
          "</span>" +
          "</div> " +
          "</div>";
        console.log(printtext2);
        // printtext2.innerHTML = printnow2;
        printtext2.insertAdjacentHTML("beforeend", printnow2);
        dataMessage = { roomID: this.activeRoom, message: this.message2 };
        console.log(dataMessage);
        this.message2 = null;
      } else {
        return;
      }
      this.scrollToEnd();
      //send message
      Axios.all([
        api.post("/api/sendMessage", dataMessage),
        // api.get("api/getChatroom"),
      ]).then((res) => {
        store.commit("FETCH_ROOMS", res[0].data);
        printtext.innerHTML = " ";
        printtext2.innerHTML = " ";
      });
      // this.debounceMethodSendMessages(dataMessage);
    }, //end sendbtn
    scrollToEnd: function () {
      var container = document.querySelector("#journal-scroll");
      container.scrollTop = container.scrollHeight;

      var container1 = document.querySelector("#journal-scrollMobile");
      container1.scrollTop = container1.scrollHeight;
    },
    // sendbtn() {
    //   const fileInputBtn = document.getElementById("fileInput");
    //   var printtext = document.getElementById("chatmsg-DESKTOP");
    //   var printtext2 = document.getElementById("chatmsg-MOBILE");
    //   var copytext = document.getElementById("typemsg-DESKTOP");
    //   var copytext2 = document.getElementById("typemsg-MOBILE");
    //   var copiedtext = copytext.value;
    //   var copiedtext2 = copytext2.value;

    //   if (copiedtext !== "") {
    //     var printnow =
    //       '<div class="p-2 flex justify-end ">' +
    //       '<div class="ml-32 pt-2 pl-4 pb-3 pr-4 bg-gray-100 text-sm rounded-lg">' +
    //       copiedtext +
    //       '<span class="time_date text-gray-500 pl-1" style="font-size: 10.5px;" >' +
    //       "<br>" +
    //       "3:45 PM" +
    //       " | " +
    //       "Today" +
    //       "</span>" +
    //       "</div> ";
    //     printtext.insertAdjacentHTML("beforeend", printnow);
    //     document.getElementById("typemsg-DESKTOP").value = "";
    //     printtext2.insertAdjacentHTML("beforeend", printnow2);
    //     document.getElementById("typemsg-MOBILE").value = "";
    //   }
    //   if (copiedtext2 !== "") {
    //     var printnow2 =
    //       '<div class="p-2 flex justify-end ">' +
    //       '<div class="ml-32 pt-2 pl-4 pb-3 pr-4 bg-gray-100 text-sm rounded-lg">' +
    //       copiedtext +
    //       '<span class="time_date text-gray-500 pl-1" style="font-size: 10.5px;" >' +
    //       "<br>" +
    //       "3:45 PM" +
    //       " | " +
    //       "Today" +
    //       "</span>" +
    //       "</div> ";
    //     printtext2.insertAdjacentHTML("beforeend", printnow2);
    //     document.getElementById("typemsg-MOBILE").value = "";
    //     printtext.insertAdjacentHTML("beforeend", printnow);
    //     document.getElementById("typemsg-DESKTOP").value = "";
    //   }
    //   if (fileInputBtn.value) {
    //     //alert(file);
    //     var printFile =
    //       '<div class="p-2 flex justify-end ">' +
    //       '<div class="ml-32 pt-2 pl-4 pb-3 pr-4 bg-gray-100 text-sm rounded-lg">' +
    //       file +
    //       "</div> ";
    //     printtext.insertAdjacentHTML("beforeend", printFile);
    //     printtext2.insertAdjacentHTML("beforeend", printFile);
    //     document.getElementById("typemsg-MOBILE").value = "";
    //     document.getElementById("typemsg-DESKTOP").value = "";
    //     this.attachment = !this.attachment;
    //     if (this.attachment == true) {
    //       document.getElementById("attach").innerHTML = "close";
    //     } else if (this.attachment == false) {
    //       document.getElementById("attach").innerHTML = "add";
    //     }
    //   } //end if
    // }, //end sendbtn
    setRoom(name, room_ID, email1, email2) {
      if (this.transactions.length > 0) {
        console.log(this.transactions[0]);
        this.activeDisplayingTransaction = this.transactions[0].transactionNumber;
      }
      this.toggleInbox = !this.toggleInbox;
      this.toggleChat = !this.toggleChat;
      console.log(this.toggleInbox, this.toggleChat);
      this.activeName = name;
      this.activeRoom = room_ID;
      this.recipient = name;
      this.activeEmail1 = email1;
      this.activeEmail2 = email2;
      console.log(this.activeEmail1, this.activeEmail2, this.authUser.email);
      console.log("set room");
      this.debounceReadChatNotif(email1, email2, this.authUser.email);
      this.$nextTick(() => this.scrollToEnd());
    },
    debounceReadChatNotif: _.debounce((email1, email2, authEmail) => {
      var email = null;
      console.log("asdfaf", email1, email2, authEmail);
      if (email1 === authEmail) {
        email = email2;
      } else {
        email = email1;
      }
      api
        .post("/api/readMessageNotif", { email: email })
        .then(() => {
          store.dispatch("getUnreadNotifications");
        })
        .catch((errors) => {
          console.log(errors);
        });
    }, 1000),

    backChat() {
      this.toggleInbox = !this.toggleInbox;
      this.toggleChat = !this.toggleChat;
      console.log(this.toggleInbox, this.toggleChat);
    },
    async getChatRooms() {
      //filtering the message room where there are no message and not the active room if there is
      var z = 0;
      for (i = 0; i < this.room.length; i++) {
        console.log("chatroom temp", this.transactions);
        var temp = this.transactions.filter((x) => {
          return (
            (x.emailCustomerShopper == this.room[i].email1 ||
              x.emailCustomerShopper == this.room[i].email2) &&
            (x.transactionReceiver == this.room[i].email1 ||
              x.transactionReceiver == this.room[i].email2)
          );
        });
        console.log("chatroom temp", temp);
        console.log(
          this.room[i].get_messages.length == 0 && !(temp.length > 0)
        );
        if (this.room[i].get_messages.length == 0 && !(temp.length > 0)) {
          //means epmty messages on room
          if (
            (this.authUser.email === this.room[i].email1 ||
              this.authUser.email === this.room[i].email2) &&
            (this.userQueryID === this.room[i].email1 ||
              this.userQueryID === this.room[i].email2)
          ) {
            //filtering only the user with messages and the active chatroom
            this.chatRooms[z] = this.room[i];
            z++;
            continue;
          }
        } else {
          this.chatRooms[z] = this.room[i];
          z++;
        }
      }
      var i;
      //var x=0;
      for (i = 0; i < this.chatRooms.length; i++) {
        //setting the picture and name of the chatrooms
        if (this.chatRooms[i].email1.localeCompare(this.authUser.email) == 0) {
          this.chatRoomNames[i] =
            this.chatRooms[i].get_email2.firstName +
            " " +
            this.chatRooms[i].get_email2.lastName;
          this.chatRoomPic[i] = this.chatRooms[i].get_email2.profilePicture;
        } else {
          this.chatRoomNames[i] =
            this.chatRooms[i].get_email1.firstName +
            " " +
            this.chatRooms[i].get_email1.lastName;
          this.chatRoomPic[i] = this.chatRooms[i].get_email1.profilePicture;
        }

        //check if the auth user and passed email is on the list
        if (
          (this.authUser.email == this.chatRooms[i].email1 ||
            this.authUser.email == this.chatRooms[i].email2) &&
          (this.userQueryID === this.chatRooms[i].email1 ||
            this.userQueryID === this.chatRooms[i].email2)
        )
          if (this.activeRoom == null)
            //filtering only the user with messages and the active chatroom
            this.setRoom(
              this.chatRoomNames[i],
              this.chatRooms[i].messageRoomNumber,
              this.chatRooms[i].email1,
              this.chatRooms[i].email2
            );
      }
      console.log(screen.width);
      if (screen.width >= 639)
        if (this.activeRoom == null && this.chatRooms.length != 0)
          this.setRoom(
            this.chatRoomNames[0],
            this.chatRooms[0].messageRoomNumber,
            this.chatRooms[0].email1,
            this.chatRooms[0].email2
          );
        else {
          this.toggleInbox = true;
          this.toggleChat = false;
        }

      this.$nextTick(() => this.scrollToEnd());
    },
    timestampRoom(datetime) {
      var postedDate = new Date(datetime);
      var dateToday = new Date();
      var dateDiff = dateToday.getTime() - postedDate.getTime();
      dateDiff = dateDiff / (1000 * 3600 * 24);
      if (dateDiff < 1) return moment(datetime).fromNow();
      else if (dateDiff >= 1 && dateDiff < 2)
        return moment(datetime).format("[Yesterday at]");
      else return moment(datetime).format("MMM DD, YYYY [at] h:mm a");
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
    getUrlQuery() {
      var tempRoom, temp;
      // var dataMessage = [];
      var transactionDetails = [];
      //only for chat button, no transaction sent
      if (this.$route.query.ID != null) {
        this.userQueryID = atob(this.$route.query.ID);
        let params = { userEmail: this.userQueryID };

        //check if the room exists
        tempRoom = this.room;
        // temp;
        temp = tempRoom.filter((x) => {
          return x.email1 == params.userEmail || x.email2 == params.userEmail;
        });
        //if null execute create chat room, if exists, set room an render rooms
        if (temp.length == 0) {
          Axios.all([
            api.get("/sanctum/csrf-cookie"),
            api.post("api/createChatRoom", params),
            api.get("api/getChatroom"),
          ]).then((responseArr) => {
            store.commit("FETCH_ROOMS", responseArr[2].data);
          });
        } else {
          this.getChatRooms();
        }
      }
      //transaction sent
      else if (this.$route.query.postNum != null) {
        var params = [];
        params = this.$route.query.postNum.split("/?p=");
        var postNum = atob(params[0]);
        var email = atob(params[1]);
        this.userQueryID = email;
        var requestData = { message: JSON.parse(atob(params[2])) };
        params = { userEmail: email };
        console.log(requestData);
        if (requestData.message.shopping_list != null) {
          requestData.message.shopping_list = JSON.parse(
            requestData.message.shopping_list
          );
        }
        //check if the room exists
        tempRoom = this.room;
        temp = tempRoom.filter((x) => {
          return x.email1 == params.userEmail || x.email2 == params.userEmail;
        });
        //if null execute create chat room, if exists, set room an render rooms
        console.log("temp room", temp);
        if (temp.length == 0) {
          //if dont exists, create room
          Axios.all([api.post("api/createChatRoom", params)]).then(() => {
            var foundPost = this.posts.find((x) => x.postNumber === postNum); //find the passed post in the stored objects in vuex
            if (foundPost.offer_post != null) {
              // dataMessage = {
              //   roomID: responseArr[1].data.messageRoomNumber,
              //   message: JSON.stringify(requestData.message),
              // };
              transactionDetails = {
                email: email,
                postNumber: postNum,
                transactionData: requestData.message,
                transactionShoppingList:
                  requestData.message.shoppingListContent,
              };
            } else {
              foundPost.request_post["message"] = requestData.message.message;
              foundPost.request_post["param"] = requestData.message.param;
              // dataMessage = {
              //   roomID: responseArr[1].data.messageRoomNumber,
              //   message: JSON.stringify(foundPost.request_post),
              // };
              transactionDetails = {
                email: email,
                postNumber: postNum,
                transactionData: foundPost.request_post,
                transactionShoppingList:
                  foundPost.request_post.shoppingListContent,
              };
            }

            Axios.all([
              // api.post("/api/sendMessage", dataMessage),
              api.post("/api/createTransaction", transactionDetails),
              api.get("/api/getChatroom"),
            ])
              .then((responseArr) => {
                store.commit("setUserTransactions", responseArr[0].data);
                store.commit("FETCH_ROOMS", responseArr[1].data);
                // this.getChatRooms();
                console.log("response rooms", responseArr[1].data);
                console.log("rooms", this.room);
              })
              .catch(() => {
                console.log("error in creating transaction");
              });
          });
        } else {
          //otherwise, set room and send transaction
          // dataMessage = [];
          transactionDetails = [];
          var foundPost = this.posts.find((x) => x.postNumber === postNum); //find the passed post in the stored objects in vuex
          if (foundPost.offer_post != null) {
            // dataMessage = {
            //   roomID: temp[0].messageRoomNumber,
            //   message: JSON.stringify(requestData.message),
            // };
            transactionDetails = {
              email: email,
              postNumber: postNum,
              transactionData: requestData.message,
              transactionShoppingList: requestData.message.shoppingListContent,
            };
          } else {
            foundPost.request_post["message"] = requestData.message.message;
            foundPost.request_post["param"] = requestData.message.param;
            // dataMessage = {
            //   roomID: temp[0].messageRoomNumber,
            //   message: JSON.stringify(foundPost.request_post),
            // };
            transactionDetails = {
              email: email,
              postNumber: postNum,
              transactionData: foundPost.request_post,
              transactionShoppingList:
                foundPost.request_post.shoppingListContent,
            };
          }
          console.log("asdfas", transactionDetails);
          Axios.all([
            // api.post("/api/sendMessage", dataMessage),
            api.post("/api/createTransaction", transactionDetails),
            // api.get("/api/getTransaction")
          ])
            .then((responseArr) => {
              store.commit("setUserTransactions", responseArr[0].data);
              // store.commit("FETCH_ROOMS", responseArr[0].data);
              // this.getChatRooms();
            })
            .catch(() => {
              console.log("error in creating transaction");
            });
        }
        this.ifHide = true;
      }
      //nothing is sent in query url
      else {
        this.getChatRooms();
      }
    },
    hasPostNum(text) {
      return text.search('"param":"this_is_a_parameter_post_message"');
    },
    hasTransactionMessage(text) {
      return text.search('"param":"this_is_a_message_transaction"');
    },
    parseString(string) {
      var data = [];
      data[0] = JSON.parse(string);
      return data;
    },

    decline_transact(postNum, indexTransactionPost, user, postIdentity) {
      this.decline = !this.decline;
      this.activePostNum = postNum;
      this.activeIndexTransNum = indexTransactionPost;
      this.activeUser = user;
      this.currentPostIdentity = postIdentity;
    },
    accept_transact(postNum, indexTransactionPost, user, postIdentity) {
      $(".hideMe1").fadeOut();
      this.accept = !this.accept;
      this.activePostNum = postNum;
      this.activeIndexTransNum = indexTransactionPost;
      this.activeUser = user;
      this.currentPostIdentity = postIdentity;
    },
    ifOnline(email1, email2) {
      var authUser = this.authUser.email;
      var chatRoomEmail;
      if (email1 != authUser) {
        chatRoomEmail = email1;
      } else {
        chatRoomEmail = email2;
      }
      var online = this.onlineUsers.find((m) => {
        return chatRoomEmail === m;
      });
      if (online != null) {
        return true;
      } else {
        return false;
      }
    },
    searchBtn() {
      // this.showSearchResults = !this.showSearchResults;
      // this.searchMessageInactive = !this.searchMessageInactive;
      var val = this.searchInput;

      this.searchUser(val, this.room, this.authUser, this);
    },
    searchUser: _.debounce((val, users, currentUser, vm) => {
      var temp = users;
      if (val == null) {
        vm.getChatRooms();
      } else {
        var res = temp.filter((x) => {
          if (x.get_email1.email != currentUser.email) {
            if (
              (x.get_email1.firstName + " " + x.get_email1.lastName)
                .toLowerCase()
                .includes(val.toLowerCase())
            ) {
              return x;
            }
          } else {
            if (
              (x.get_email2.firstName + " " + x.get_email2.lastName)
                .toLowerCase()
                .includes(val.toLowerCase())
            ) {
              return x;
            }
          }
        });
        vm.getChatSearch(res);
        console.log(res);
      }
    }, 2000),
    getChatSearch(result) {
      //filtering the message room where there are no message and not the active room if there is
      var z = 0;
      this.chatRooms = [];
      this.chatRoomNames = [];
      this.activeRoom = null;
      for (i = 0; i < result.length; i++) {
        console.log("chatroom temp", this.transactions);
        var temp = this.transactions.filter((x) => {
          return (
            (x.emailCustomerShopper == result[i].email1 ||
              x.emailCustomerShopper == result[i].email2) &&
            (x.transactionReceiver == result[i].email1 ||
              x.transactionReceiver == result[i].email2)
          );
        });
        console.log("chatroom temp", temp);
        console.log(result[i].get_messages.length == 0 && !(temp.length > 0));
        if (result[i].get_messages.length == 0 && !(temp.length > 0)) {
          //means epmty messages on room
          if (
            (this.authUser.email === result[i].email1 ||
              this.authUser.email === result[i].email2) &&
            (this.userQueryID === result[i].email1 ||
              this.userQueryID === result[i].email2)
          ) {
            //filtering only the user with messages and the active chatroom
            this.chatRooms[z] = result[i];
            z++;
            continue;
          }
        } else {
          this.chatRooms[z] = result[i];
          z++;
        }
      }
      var i;
      //var x=0;
      for (i = 0; i < this.chatRooms.length; i++) {
        //setting the picture and name of the chatrooms
        if (this.chatRooms[i].email1.localeCompare(this.authUser.email) == 0) {
          this.chatRoomNames[i] =
            this.chatRooms[i].get_email2.firstName +
            " " +
            this.chatRooms[i].get_email2.lastName;
          this.chatRoomPic[i] = this.chatRooms[i].get_email2.profilePicture;
        } else {
          this.chatRoomNames[i] =
            this.chatRooms[i].get_email1.firstName +
            " " +
            this.chatRooms[i].get_email1.lastName;
          this.chatRoomPic[i] = this.chatRooms[i].get_email1.profilePicture;
        }
      }
      console.log(screen.width);
      if (screen.width >= 639)
        if (this.activeRoom == null && this.chatRooms.length != 0)
          this.setRoom(
            this.chatRoomNames[0],
            this.chatRooms[0].messageRoomNumber,
            this.chatRooms[0].email1,
            this.chatRooms[0].email2
          );
        else {
          this.toggleInbox = true;
          this.toggleChat = false;
        }

      this.$nextTick(() => this.scrollToEnd());
    },
    alert() {
      alert("called");
    },
    closeSearchResults() {
      if (this.searchMessageInactive == false) {
        this.searchMessageInactive = !this.searchMessageInactive;
        this.showSearchResults = !this.showSearchResults;
      }
    },
    searchBackBtn() {
      this.showSearchResults = !this.showSearchResults;
      this.searchMessageInactive = !this.searchMessageInactive;
    },
    attachbtn() {
      this.attachment = !this.attachment;
      if (this.attachment == true) {
        document.getElementById("attach").innerHTML = "close";
        document.getElementById("attach2").innerHTML = "close";
      } else if (this.attachment == false) {
        document.getElementById("attach").innerHTML = "add";
        document.getElementById("attach2").innerHTML = "add";
      }
    },
    navigate() {
      this.toggleInbox = !this.toggleInbox;
      this.toggleChat = !this.toggleChat;
      var b = document.getElementById("mark");
      var bText = b.textContent;
      var bLen = bText.length;
      var res = bText.substring(0, bLen - 13);
      document.getElementById("active").innerHTML = res;
    },
    active_convo(el) {
      this.toggleInbox = !this.toggleInbox;
      this.toggleChat = !this.toggleChat;
      //console.log(el);
      this.activeName = el;
    },
    threedots() {
      this.toggle = !this.toggle;
    }, //end threedots
    vertiDots() {
      this.toggleVerti = !this.toggleVerti;
    }, //end funtion vertiDots
    // attachPhoto() {
    //   const fileInputBtn = document.getElementById("photoInput");
    //   const fileholder = document.getElementById("photo");
    //   fileInputBtn.click();
    //   fileInputBtn.addEventListener("change", function () {
    //     if (fileInputBtn.value) {
    //       fileholder.innerHTML = fileInputBtn.value;
    //     } else {
    //       fileholder.innerhtml = "";
    //     }
    //   });
    // },
    // attachFile() {
    //   const fileInputBtn = document.getElementById("fileInput");
    //   //const fileholder = document.getElementById('file');
    //   fileInputBtn.click();

    //   $(document).ready(function () {
    //     $('input[type="file"]').change(function (e) {
    //       var geekss = e.target.files[0].name;
    //       file = geekss;
    //       $("label").text(geekss);
    //       //alert(this.fileName);
    //     });
    //   });
    // },
    hideVertiOptions() {
      this.ifHide = false;
    },
    showVertiOptions() {
      this.ifHide = true;
      this.toggle = false;
      this.toggleVerti = false;
    },
    active_transact(e) {
      console.log("active transact", e);
      this.activeDisplayingTransaction = e;
      // if (this.active === "toggle1") this.toggle1 = false;
      // else if (this.active === "toggle2") this.toggle2 = false;
      // else if (this.active === "toggle3") this.toggle3 = false;
      // else if (this.active === "toggle4") this.toggle4 = false;
      // else if (this.active === "toggle5") this.toggle5 = false;
      // else if (this.active === "toggle6") this.toggle6 = false;

      // switch (e) {
      //   case "toggle1": {
      //     if (this.toggle1 !== true) {
      //       this.toggle1 = !this.toggle1;
      //       this.active = "toggle1";
      //     }
      //     break;
      //   }
      //   case "toggle2": {
      //     if (this.toggle2 !== true) {
      //       this.toggle2 = !this.toggle2;
      //       this.active = "toggle2";
      //     }
      //     break;
      //   }
      //   case "toggle3": {
      //     if (this.toggle3 !== true) {
      //       this.toggle3 = !this.toggle3;
      //       this.active = "toggle3";
      //     }
      //     break;
      //   }
      //   case "toggle4": {
      //     if (this.toggle4 !== true) {
      //       this.toggle4 = !this.toggle4;
      //       this.active = "toggle4";
      //     }
      //     break;
      //   }
      //   case "toggle5": {
      //     if (this.toggle5 !== true) {
      //       this.toggle5 = !this.toggle5;
      //       this.active = "toggle5";
      //     }
      //     break;
      //   }
      //   case "toggle6": {
      //     if (this.toggle6 !== true) {
      //       this.toggle6 = !this.toggle;
      //       this.active = "toggle6";
      //     }
      //     break;
      //   }
      //   default:
      //     this.toggle1 = true;
      // } //end switch
    },
    declineDisRequest() {
      $(".hideMe1").fadeOut();
      this.declineRequest = !this.declineRequest;
    },
    acceptDisRequest1() {
      this.acceptRequest = !this.acceptRequest;
      $(".hideMe1").fadeIn();
    },
    confirmAcceptTransact() {
      this.accept = !this.accept;
      this.toggleViewDetails = false;
      var dataMessage = {
        roomID: this.activeRoom,
        message: JSON.stringify({
          param: "this_is_a_message_transaction",
          sender:
            this.userPersonal.firstName + " " + this.userPersonal.lastName,
          receiver: this.activeName,
          status: "Accepted",
          postIdentity: this.currentPostIdentity,
        }),
      };
      var currTrans = this.transactionsReceived.filter((x) => {
        return x.indexTransactionPost == this.activeIndexTransNum;
      });
      console.log(currTrans);
      var dataMessage2 = {
        roomID: this.activeRoom,
        message: JSON.stringify(currTrans[0].transactionData),
        transaction: true,
        transactionSender: this.activeUser,
      };
      console.log(dataMessage, dataMessage2);
      Axios.all([
        api.post("api/confirmRequest", {
          postNumber: this.activePostNum,
          ID: this.activeIndexTransNum,
          userNotif: this.activeUser,
          postIdentity: this.currentPostIdentity,
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
        }, 4000);
        this.activePostNum = null;
        this.activeIndexTransNum = null;
        this.activeUser = null;
        this.currentPostIdentity = null;
      });
    },
    confirmAcceptDisRequest2() {
      this.acceptOffer = !this.acceptOffer;
      setTimeout(() => {
        $(".acceptOfferNotiPop").fadeIn(), (this.acceptReqNotiPop = true);
      }, 500);
      setTimeout(function () {
        this.acceptOffer = false;
        $(".acceptOfferNotiPop").fadeOut();
      }, 4000);
    },
    closeAcceptRequestNotiPop() {
      this.acceptReqNotiPop = false;
      $(".acceptRequestNotiPop").fadeOut();
    },
    confirmDeclineDisRequest() {
      this.decline = !this.decline;
      this.toggleViewDetails = false;
      var dataMessage = {
        roomID: this.activeRoom,
        message: JSON.stringify({
          param: "this_is_a_message_transaction",
          sender:
            this.userPersonal.firstName + " " + this.userPersonal.lastName,
          receiver: this.activeName,
          status: "Declined",
          postIdentity: this.currentPostIdentity,
        }),
      };
      Axios.all([
        api.post("api/declineRequest", {
          postNumber: this.activePostNum,
          ID: this.activeIndexTransNum,
          userNotif: this.activeUser,
          postIdentity: this.currentPostIdentity,
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
        }, 4000);
        this.activePostNum = null;
        this.activeIndexTransNum = null;
        this.activeUser = null;
        this.currentPostIdentity = null;
      });
    },

    closeDeclineRequestNotiPop() {
      this.declineReqNotiPop = false;
      $(".declineRequestNotiPop").fadeOut();
    },
    declineDisRequest1() {
      this.decline = !this.decline;
      $(".hideMe1").fadeIn();
    },
    showMoreshowLess() {
      this.limit_by = null;
      if (this.showListStatus != this.showLessStatus) {
        this.showListStatus = this.showLessStatus;
      } else {
        this.showListStatus = "See More";
        this.limit_by = this.default_limit;
      }
    },
    acceptDisOffer(e) {
      this.acceptOffer = !this.acceptOffer;
      this.transaction = e;
    },
    declineDisOffer(e) {
      this.declineOffer = !this.declineOffer;
      this.transaction = e;
    },
    cancel_transact(postNum, indexTransactionPost, postIdentity) {
      this.cancel = !this.cancel;
      console.log(postNum, indexTransactionPost, postIdentity);
      //  this.transaction = postNum;
      this.currentPostIdentity = postIdentity;
      this.activePostNum = postNum;
      this.activeIndexTransNum = indexTransactionPost;
    },
    confirmCancellation() {
      var dataMessage = {
        roomID: this.activeRoom,
        message: JSON.stringify({
          param: "this_is_a_message_transaction",
          sender:
            this.userPersonal.firstName + " " + this.userPersonal.lastName,
          receiver: this.activeName,
          status: "Cancelled",
          postIdentity: this.currentPostIdentity,
        }),
      };
      Axios.all([
        api.post("api/cancelTransaction", {
          postNumber: this.activePostNum,
          ID: this.activeIndexTransNum,
          postIdentity: this.currentPostIdentity,
        }),
        api.post("/api/sendMessage", dataMessage),
        api.get("/api/getTransaction"),
      ]).then((resArr) => {
        store.commit("setUserTransactions", resArr[2].data);
        store.commit("FETCH_ROOMS", resArr[1].data);
        setTimeout(() => {
          $(".declineRequestNotiPop").fadeIn(), (this.confirmCancel = true);
        }, 500);
        setTimeout(function () {
          this.confirmCancel = false;
          $(".declineRequestNotiPop").fadeOut();
        }, 4000);
        this.cancel = !this.cancel;
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
  }, //end methods
  mounted() {
    this.getUrlQuery();
    console.log(this.onlineUsers);
  },
  computed: {
    verifiedUsers() {
      return store.getters.getVerifiedUsers;
    },
    authUser() {
      return store.getters.getUser;
    },
    userPersonal() {
      return store.getters.getPersonal;
    },
    room() {
      return store.getters.getRooms;
    },
    rooms() {
      return store.getters.getRooms;
    },
    posts() {
      return store.getters.getPosts;
    },
    transactions() {
      return store.getters.getUserTransactions.filter((x) => {
        return x.transactionStatus != "Completed";
      });
    },
    onlineUsers() {
      return store.getters.getOnlineUsers;
    },
    transactionsReceived() {
      var temp = this.transactions;
      return temp.filter((x) => {
        return (
          x.transactionReceiver === this.authUser.email &&
          x.transactionStatus === "pending"
        );
      });
    },
    transactionsSent() {
      var temp = this.transactions;
      return temp.filter((x) => {
        return (
          x.transaction_sender.email === this.authUser.email &&
          x.transactionStatus === "pending"
        );
      });
    },
  },
}; //end export default
$(document).mouseup(function (e) {
  //desktop
  var delBtn = $("#delBtn");
  var vertiOPTIONS = $("#vertiOPTIONS");
  // If the target of the click isn't the container
  if (!delBtn.is(e.target) && delBtn.has(e.target).length === 0) {
    delBtn.hide();
  }
  if (!vertiOPTIONS.is(e.target) && vertiOPTIONS.has(e.target).length === 0) {
    vertiOPTIONS.hide();
  }
  //mobile
  var delBtn_MOBILE = $("#delBtn-MOBILE");
  var vertiOPTIONS_MOBILE = $("#vertiOPTIONS-MOBILE");
  // If the target of the click isn't the container
  if (!delBtn_MOBILE.is(e.target) && delBtn_MOBILE.has(e.target).length === 0) {
    delBtn_MOBILE.hide();
  }
  if (
    !vertiOPTIONS_MOBILE.is(e.target) &&
    vertiOPTIONS_MOBILE.has(e.target).length === 0
  ) {
    vertiOPTIONS_MOBILE.hide();
  }
});
</script>
<style>
.hide {
  display: none;
}
#journal-scroll::-webkit-scrollbar {
  width: 3px;
  cursor: pointer;
}
#journal-scroll::-webkit-scrollbar-track {
  background-color: rgba(229, 231, 235, var(--bg-opacity));
  cursor: pointer;
}
#journal-scrollMobile::-webkit-scrollbar {
  width: 3px;
  cursor: pointer;
}
#journal-scrollMobile::-webkit-scrollbar-track {
  background-color: rgba(229, 231, 235, var(--bg-opacity));
  cursor: pointer;
}
#scrollInbox::-webkit-scrollbar-thumb {
  cursor: pointer;
  background-color: rgba(185, 28, 28);
}
#scrollInbox::-webkit-scrollbar {
  width: 2px;
  cursor: pointer;
}
#scrollInbox::-webkit-scrollbar-track {
  background-color: rgba(219, 216, 216, var(--bg-opacity));
  cursor: pointer;
}
#scrollInbox::-webkit-scrollbar-thumb {
  cursor: pointer;
  background-color: rgb(219, 216, 216);
}
/*minimized desktop version and mobile version
screen sizes lesser than 639px*/
.desktopVersion {
  display: none;
}
.mobileVersion {
  display: inline;
}
#backNavigator {
  display: inline;
}
#msgheader {
  display: none;
}
#vertiOPTIONS-MOBILE {
  box-shadow: 1px 1px 1px 1px #888888;
}
/*for screen sizes 639px++*/
@media only screen and (min-width: 639px) {
  .desktopVersion {
    display: inline;
  }
  .mobileVersion {
    display: none;
  }
  #backNavigator {
    display: none;
  }
  #msgheader {
    display: flex;
  }
}
#iCheck {
  font-size: 16px;
  color: rgb(22, 22, 141);
}
#iMessage {
  font-size: 24px;
  color: rgb(22, 22, 141);
}
.material-icons {
  font-family: "Material Icons";
  font-weight: normal;
  font-style: normal;
  line-height: 1;
  text-transform: none;
  letter-spacing: normal;
  word-wrap: normal;
  white-space: nowrap;
  direction: ltr;
  /* Support for all WebKit browsers. */
  -webkit-font-smoothing: antialiased;
  /* Support for Safari and Chrome. */
  text-rendering: optimizeLegibility;
  /* Support for Firefox. */
  -moz-osx-font-smoothing: grayscale;
  /* Support for IE. */
  font-feature-settings: "liga";
}
</style>