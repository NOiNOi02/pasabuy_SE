<template>
  <div
    v-on:click.self="close2"
    class="
      z-50
      bg-black bg-opacity-25
      fixed
      inset-0
      flex
      justify-center
      items-center
      sm:px-2
      ssm:px-2
      vs:px-2
      vs:w-full
    "
  >
    <div
      class="
        hideIf
        inline-flex
        flex-col
        space-y-2
        bg-white
        shadow
        rounded-xl
        h-auto
        w-550
        ssm:w-full
        sm:w-full
        vs:w-full
      "
      v-if="mainModal"
    >
      <div class="flex flex-col mt-4">
        <!--Create Post section-->
        <h1
          class="
            items-center
            justify-center
            vs:ml-0
            ml-12
            sm:ml-8
            se:pl-14
            se:ml-0
            ssm:pl-11
            ssm:ml-0
            ssm:text-lg
            pb-4
            text-gray-900
            leading-normal
            vs:pl-22
            pl-24
            text-2xl
            vs:text-xl
            font-bold
            text-center
          "
        >
          Edit Order Request
          <button
            @click.prevent="close2"
            class="
              vs:ml-6
              ml-20
              sm:ml-14
              se:ml-4
              ssm:ml-3
              ssm:text-xs
              focus:outline-none
              text-sm
              vs:text-xs
              mb-1
              leading-none
              text-indigo-900
            "
          >
            Close
          </button>
        </h1>
        <!--end-->
        <hr />

        <!--User Profile-->
        <div class="inline-flex space-x-2 items-center justify-start p-4">
          <img
            class="
              w-14
              h-full
              vs:w-12
              ssm:w-10
              border
              rounded-full
              border-gray-200
            "
            :src="post.user.profilePicture"
          />
          <p
            class="
              text-base
              ssm:text-sm
              vs:text-sm
              lvs:text-base
              font-bold
              leading-none
              text-gray-900
            "
          >
            {{ post.user.firstName }} {{ post.user.lastName }}
          </p>
        </div>
        <!--end-->

        <!--Delivery information list-->
        <div
          class="
            flex flex-col
            mt-1
            vs:mt-1
            sm:px-2
            ssm:px-2
            vs:mt-0
            justify-center
            items-center
            vs:px-2
          "
        >
          <div
            class="
              flex flex-row
              ssm:flex-col
              ssm:space-x-0 ssm:space-y-2
              se:space-x-1
              space-x-4
              w-full
              justify-center
            "
          >
            <div class="flex flex-row space-x-2 sm:w-full">
              <span class="rounded-lg mt-1.5 material-icons text-red-700">
                delivery_dining
              </span>
              <div class="sm:w-full">
                <button
                  @click="
                    (dropdown1 = !dropdown1),
                      (dropdown2 = false),
                      (dropdown3 = false),
                      (dropdown4 = false)
                  "
                  class="
                    focus:outline-none
                    flex
                    sm:w-full
                    ssm:w-full
                    ssm:h-auto
                    ssm:text-xs
                    ssm:pr-0
                    vs:w-full
                    w-52
                    h-11
                    py-2.5
                    px-4
                    items-center
                    bg-gray-100
                    rounded-xl
                    text-sm
                    vs:text-xs
                    lvs:text-sm
                    leading-none
                    text-gray-500
                  "
                >
                  {{ delivery_info.deliveryAddress }}
                </button>
                <div class="relative">
                  <div
                    v-if="dropdown1"
                    class="
                      absolute
                      p-2
                      bg-white
                      rounded-lg
                      shadow-xl
                      right-0
                      h-40
                      sm:w-full
                      w-52
                    "
                  >
                    <div id="scroll1" class="flex-auto overflow-y-scroll h-28">
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
                            class="
                              text-sm
                              font-bold
                              tracking-wide
                              leading-none
                              text-gray-900
                            "
                          >
                            Home Address
                          </p>
                          <div class="flex-1 w-full px-2">
                            <p
                              id="homeAdd"
                              class="
                                text-sm
                                tracking-wide
                                leading-none
                                text-gray-900
                              "
                            >
                              {{ userHomeAddress.province }},
                              {{ userHomeAddress.cityMunicipality }},
                              {{ userHomeAddress.barangay }},
                              {{ userHomeAddress.houseNumber }}
                            </p>
                          </div>
                        </div>
                        <hr class="flex w-full px-2" />
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
                              class="
                                text-sm
                                font-bold
                                tracking-wide
                                leading-none
                                text-gray-900
                              "
                            >
                              Shipping Address {{ index + 1 }}
                            </p>
                            <div class="flex-1 w-full px-2">
                              <p
                                :id="'shipAdd' + index"
                                class="
                                  text-sm
                                  tracking-wide
                                  leading-none
                                  text-gray-900
                                "
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
                      class="
                        flex
                        text-base
                        items-center
                        focus:outline-none
                        p-2
                        space-x-1
                      "
                      style="cursor: pointer"
                    >
                      <span class="text-red-700 material-icons">
                        add_circle
                      </span>
                      <div class="flex-1 w-full">
                        <p
                          class="
                            text-sm
                            font-bold
                            tracking-wide
                            leading-none
                            text-red-700
                          "
                        >
                          Add New Shipping Address
                        </p>
                      </div>
                    </div>
                    <div
                      @click.self="openAddModal"
                      v-if="addAddress"
                      class="
                        z-50
                        bg-black bg-opacity-25
                        fixed
                        inset-0
                        flex
                        justify-center
                        items-center
                        ssm:px-2
                        vs:px-2
                      "
                    >
                      <div
                        class="
                          inline-flex
                          flex-col
                          bg-white
                          p-4
                          space-y-4
                          shadow
                          rounded-xl
                          h-auto
                          w-80
                        "
                      >
                        <div
                          class="flex flex-row w-full items-center space-x-2"
                        >
                          <label
                            class="
                              block
                              text-sm
                              font-bold
                              tracking-wide
                              leading-none
                              text-gray-900
                            "
                            >Title</label
                          >
                          <input
                            class="
                              appearance-none
                              focus:outline-none
                              border
                              rounded
                              w-full
                              py-1
                              px-3
                              text-grey-darker
                            "
                            id="addressTitle"
                            type="text"
                            placeholder="Your shipping address title"
                          />
                        </div>
                        <div
                          class="flex flex-row w-full items-center space-x-2"
                        >
                          <label
                            class="
                              block
                              text-sm
                              font-bold
                              tracking-wide
                              leading-none
                              text-gray-900
                            "
                            >Address</label
                          >
                          <input
                            class="
                              appearance-none
                              focus:outline-none
                              border
                              rounded
                              w-full
                              py-1
                              px-3
                              text-grey-darker
                            "
                            id="addressTitle"
                            type="text"
                            placeholder="Your shipping address"
                          />
                        </div>
                        <div class="justify-center flex">
                          <button
                            class="
                              inline-flex
                              items-center
                              justify-center
                              focus:outline-none
                              px-4
                              vs:py-2
                              bg-red-700
                              rounded-full
                              w-full
                              h-6
                            "
                          >
                            <p
                              class="
                                text-base
                                font-bold
                                leading-normal
                                text-center text-white
                              "
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
                  id="myInput"
                  v-on:keyup="myFunction()"
                  placeholder="Search for place"
                  title="Shopping Place"
                  class="
                    focus:outline-none
                    flex
                    sm:w-full
                    ssm:w-full
                    ssm:h-auto
                    ssm:text-xs
                    vs:w-full
                    w-52
                    h-11
                    px-4
                    items-center
                    py-2.5
                    bg-gray-100
                    rounded-xl
                    text-sm
                    vs:text-xs
                    lvs:text-sm
                    leading-none
                    text-gray-500
                  "
                  v-model="delivery_info.shoppingPlace"
                />
                <!-- {{shoppingPlace}} -->
                <!-- </button> -->
                <div class="relative">
                  <div
                    v-if="dropdown4"
                    class="
                      absolute
                      py-3
                      bg-white
                      rounded-lg
                      shadow-xl
                      right-0
                      h-35.1
                      sm:w-full
                      w-52
                    "
                  >
                    <div
                      class="
                        flex flex-col
                        w-full
                        px-2
                        justify-start
                        items-start
                      "
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
            class="
              flex flex-row
              pt-3
              ssm:pt-2
              ssm:flex-col
              ssm:space-x-0
              se:space-x-1
              ssm:space-y-2
              space-x-4
              w-full
              justify-center
            "
          >
            <div class="flex flex-row space-x-2 vs:w-full sm:w-full">
              <span class="rounded-lg mt-1.5 material-icons text-red-700">
                alarm
              </span>
              <div
                class="
                  flex
                  items-center
                  justify-start
                  sm:w-full
                  ssm:px-2
                  ssm:h-auto
                  ssm:w-full
                  vs:w-full
                  w-52
                  h-12
                  vs:h-12
                  px-4
                  vs:px-2
                  bg-gray-100
                  rounded-xl
                "
              >
                <div
                  class="
                    flex flex-col
                    items-start
                    justify-start
                    vs:w-full
                    h-full
                    py-1.5
                    rounded-2xl
                  "
                >
                  <span>
                    <input
                      type="datetime-local"
                      id="input_name"
                      v-model="delivery_info.deliverySchedule"
                      class="
                        sm:w-full
                        ssm:text-xs
                        block
                        bg-gray-100
                        text-sm
                        focus:outline-none
                        leading-7
                        text-gray-900
                        w-44
                        vs:w-full
                        h-auto
                      "
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
                  class="
                    focus:outline-none
                    flex
                    sm:w-full
                    ssm:w-full
                    ssm:h-auto
                    ssm:text-xs
                    vs:w-full
                    w-52
                    h-11
                    py-2.5
                    px-4
                    items-center
                    bg-gray-100
                    rounded-xl
                    text-sm
                    vs:text-xs
                    lvs:text-sm
                    leading-none
                    text-gray-500
                  "
                >
                  {{ delivery_info.paymentMethod }}
                </button>
                <div class="relative">
                  <div
                    v-if="dropdown2"
                    class="
                      absolute
                      py-3
                      bg-white
                      rounded-lg
                      shadow-xl
                      right-0
                      h-35.1
                      sm:w-full
                      w-52
                    "
                  >
                    <div
                      v-for="(pm, index) in Payments"
                      :key="index"
                      class="
                        flex flex-col
                        w-full
                        space-y-3
                        px-2
                        justify-start
                        items-start
                      "
                    >
                      <button
                        @click="
                          setPayment(index);
                          dropdown2 = !dropdown2;
                        "
                        class="
                          flex
                          w-full
                          focus:outline-none
                          justify-start
                          items-start
                          px-2
                        "
                      >
                        <p
                          :id="'pm' + index"
                          class="
                            text-sm
                            tracking-wide
                            leading-none
                            text-gray-900
                          "
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
        <div
          v-if="shopping_infoDisplay.items == null"
          class="flex justify-center items-center ssm:px-2 mt-3 sm:px-2 vs:px-2"
        >
          <button
            @click="
              (openSelectShoppingList = !openSelectShoppingList),
                (mainModal = !mainModal)
            "
            class="
              focus:outline-none
              inline-flex
              items-center
              justify-center
              p-4
              bg-gray-100
              rounded-full
              w-31.75
              ssm:w-full
              vs:w-full
              h-14
              ssm:h-10
              vs:h-12
            "
          >
            <div class="flex space-x-2 items-center">
              <img class="w-6 h-full rounded-lg" src="img/add.svg" />
              <p
                class="
                  text-base
                  ssm:text-sm
                  vs:text-sm
                  lvs:text-base
                  font-bold
                  leading-none
                  text-gray-900
                "
              >
                Select Shopping List
              </p>
            </div>
          </button>
        </div>
        <div
          class="justify-center flex sm:px-2 ssm:px-2 vs:px-2"
          v-if="shopping_infoDisplay.items != null"
        >
          <div
            class="
              flex flex-col
              se:h-36
              ssm:h-36
              mt-3
              w-31.75
              items-start
              p-4
              ssm:p-2
              vs:p-2
              bg-gray-100
              rounded-xl
              h-auto
              ssm:w-full
              vs:w-full
            "
          >
            <div
              class="
                flex
                w-full
                flex-row
                justify-between
                items-center
                ssm:space-x-0
                vs:space-x-0
              "
            >
              <p
                class="
                  flex
                  text-base
                  ssm:text-sm
                  vs:text-sm
                  lvs:text-base
                  leading-none
                  text-gray-900
                "
              >
                Shopping List ({{
                  computedShopItemList(shopping_infoDisplay.items).length
                }}
                items)
              </p>
              <div>
                <button
                  @click="listEdit = !listEdit"
                  class="flex focus:outline-none"
                >
                  <span class="material-icons text-lg vs:text-sm ssm:text-sm">
                    more_vert
                  </span>
                </button>
                <div class="relative w-full">
                  <div
                    v-if="listEdit"
                    class="
                      absolute
                      flex flex-col
                      space-y-2
                      p-2
                      leading-loose
                      rounded-lg
                      border-2 border-gray-100
                      bg-white
                      right-0
                      w-30
                    "
                  >
                    <button
                      @click="showEditShopListModalMethod()"
                      class="
                        flex flex-row
                        items-center
                        font-normal
                        text-base
                        leading-none
                        text-gray-900
                        focus:outline-none
                        gap-x-2
                      "
                    >
                      <span class="material-icons text-base text-gray-900">
                        mode
                      </span>
                      Edit
                    </button>
                    <button
                      @click="
                        (openSelectShoppingList = !openSelectShoppingList),
                          (mainModal = !mainModal)
                      "
                      class="
                        flex flex-row
                        items-center
                        font-normal
                        text-base
                        leading-none
                        text-gray-900
                        focus:outline-none
                        gap-x-2
                      "
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
              class="
                inline-flex
                overflow-y-auto
                h-28.5
                flex-col
                ssm:px-0
                w-full
                vs:px-0
                space-y-2
                py-4
                px-4
              "
            >
              <li
                v-for="shoppingItems in computedShopItemList(
                  shopping_infoDisplay.items
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
              v-if="!isFew"
              class="
                focus:outline-none
                items-start
                justify-start
                text-sm text-gray-500
              "
            >
              {{ showListStatus }}
            </button>
          </div>
        </div>

        <!--Comment section-->
        <div class="justify-center flex mt-3 sm:px-2 vs:px-2">
          <textarea
            id="postMessage"
            name="postMessage"
            rows="3"
            class="
              p-4
              bg-gray-100
              shadow-sm
              ssm:text-xs
              se:text-xs
              text-sm
              rounded-2xl rounded-md
              outline-none
              h-auto
              w-31.75
              ssm:w-fullvs:w-full
            "
            placeholder="Enter your post message here..."
            v-model="delivery_info.caption"
          ></textarea>
        </div>
        <!--end-->

        <!--Post button-->
        <div class="justify-center flex mt-3 pb-3 sm:px-2 ssm:px-2 vs:px-2">
          <button
            @click="saveChanges"
            class="
              inline-flex
              items-center
              justify-center
              focus:outline-none
              px-4
              py-2
              bg-red-700
              rounded-full
              h-10
              w-31.75
              ssm:h-full
              vs:w-full
            "
          >
            <p
              class="
                text-base
                ssm:text-xs
                font-bold
                leading-normal
                text-center text-white
              "
            >
              Save Changes
            </p>
          </button>
        </div>
        <!--end-->
      </div>
    </div>
    <!--end-->

    <!--Select Shopping List Modal-->
    <transition name="fadeSlide">
      <div
        v-if="openSelectShoppingList"
        class="
          hideIf2
          font-nunito
          fixed
          z-50
          inset-0
          flex
          ssm:px-2
          vs:px-2
          sm:px-2
          justify-center
          items-center
        "
      >
        <div
          class="
            flex flex-col
            bg-white
            shadow
            rounded-xl
            h-auto
            w-550
            ssm:w-full
            vs:w-full
            sm:w-full
          "
        >
          <div class="flex justify-between items-center p-4 flex-row">
            <button
              @click="
                (openSelectShoppingList = !openSelectShoppingList),
                  (mainModal = true)
              "
              class="
                focus:outline-none
                text-sm
                font-bold
                leading-none
                text-right text-indigo-900
              "
            >
              Back
            </button>
            <p
              class="
                text-2xl
                ssm:text-sm
                se:text-base
                vs:text-lg
                font-bold
                leading-normal
                text-center text-gray-900
              "
            >
              Select Shopping List
            </p>
            <button
              class="
                invisible
                text-sm
                font-bold
                leading-none
                text-right text-indigo-900
              "
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
                      name="shoplist"
                      class="form-radio w-4 h-4 vs:w-3 vs:h-3 lvs:w-4 lvs:h-4"
                      :id="'listNumber' + list.shoppingListNumber"
                    />
                    <span
                      class="
                        ml-5
                        text-base
                        ssm:text-xs
                        vs:text-sm
                        lvs:text-base
                      "
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
                      class="
                        absolute
                        p-2
                        leading-loose
                        rounded-lg
                        border-2 border-gray-100
                        bg-white
                        right-0
                        w-30
                      "
                    >
                      <button
                        @click="editShopListAtSelectShopList"
                        class="
                          flex flex-row
                          items-center
                          font-normal
                          text-base
                          leading-none
                          text-gray-900
                          focus:outline-none
                          gap-x-2
                        "
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
            class="
              flex flex-row
              w-full
              justify-around
              vs:space-x-2
              sm:space-x-4
              items-center
              p-4
            "
          >
            <button
              @click="
                (createNewShopList = !createNewShopList),
                  (mainModal = false),
                  (openSelectShoppingList = false)
              "
              class="
                focus:outline-none
                flex
                items-center
                justify-center
                w-56
                h-full
                px-4
                py-2
                border-2
                rounded-full
                border-red-700
              "
            >
              <p class="text-base font-bold leading-none text-gray-900">
                Create New
              </p>
            </button>
            <button
              @click="confirmShopList"
              class="
                focus:outline-none
                flex
                items-center
                justify-center
                w-56
                h-full
                px-4
                py-2.5
                bg-red-700
                rounded-full
              "
            >
              <p class="text-base font-bold leading-none text-white">Confirm</p>
            </button>
          </div>
        </div>
      </div>
    </transition>
    <!--end-->

    <!--Create New Shopping List Modal-->
    <transition name="fadeSlide2">
      <div
        v-if="createNewShopList"
        class="z-50 ssm:px-2 fixed vs:px-2 sm:px-2 scrolledCenterMe"
      >
        <div
          class="
            flex flex-col
            bg-white
            shadow
            rounded-xl
            h-auto
            w-550
            ssm:w-full
            vs:w-full
            sm:w-full
          "
        >
          <div class="flex justify-between items-center p-4 flex-row">
            <button
              @click="
                createNewShopList = !createNewShopList;
                openSelectShoppingList = !openSelectShoppingList;
              "
              class="
                focus:outline-none
                text-sm
                font-bold
                leading-none
                text-right text-indigo-900
              "
            >
              Back
            </button>
            <p
              class="
                text-2xl
                ssm:text-sm
                se:text-base
                vs:text-lg
                font-bold
                leading-normal
                text-center text-gray-900
              "
            >
              Create New Shopping List
            </p>
            <button
              class="
                invisible
                text-sm
                font-bold
                leading-none
                text-right text-indigo-900
              "
            >
              Close</button
            ><!--invisible, used only for auto margin header. If design need close button just delete the invisible class-->
          </div>
          <hr class="w-full" />
          <div class="flex flex-col w-full space-y-2 p-4">
            <div class="flex flex-row items-center space-y-1 w-full">
              <input
                id="new_title"
                type="text"
                placeholder="New Shopping List"
                class="w-42 focus:outline-none"
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
            <div class="flex space-y-3 flex-col w-full px-4">
              <button
                @click="addnew()"
                v-if="!editItem1"
                class="flex items-center flex-row space-x-2"
              >
                <span class="text-gray-900 material-icons"> add_circle </span>
                <p class="text-base leading-none text-gray-900">Add new item</p>
              </button>

              <div
                v-if="editItem1"
                class="
                  flex flex-col
                  space-y-2
                  h-auto
                  w-full
                  rounded-xl
                  border-2
                  p-4
                  border-gray-200
                  bg-white
                "
              >
                <div
                  class="
                    flex
                    bg-gray-100
                    rounded-xl
                    w-full
                    flex-col
                    space-y-1
                    h-auto
                    p-2
                  "
                >
                  <p class="text-sm leading-3 text-gray-500">Product</p>
                  <input
                    v-model="editingProduct.product"
                    class="
                      bg-gray-100
                      w-full
                      h-4
                      focus:outline-none
                      text-base
                      leading-none
                      text-gray-900
                    "
                  />
                </div>
                <div class="flex flex-row space-x-2">
                  <div
                    class="
                      flex
                      bg-gray-100
                      rounded-xl
                      w-full
                      flex-col
                      space-y-1
                      h-auto
                      p-2
                    "
                  >
                    <p class="text-sm leading-3 text-gray-500">Brand</p>
                    <input
                      v-model="editingProduct.brand"
                      class="
                        bg-gray-100
                        w-full
                        h-4
                        focus:outline-none
                        text-base
                        leading-none
                        text-gray-900
                      "
                    />
                  </div>
                  <div
                    class="
                      flex
                      bg-gray-100
                      rounded-xl
                      w-full
                      flex-col
                      space-y-1
                      h-auto
                      p-2
                    "
                  >
                    <p class="text-sm leading-3 text-gray-500">Size</p>
                    <input
                      v-model="editingProduct.size"
                      class="
                        bg-gray-100
                        w-full
                        h-4
                        focus:outline-none
                        text-base
                        leading-none
                        text-gray-900
                      "
                    />
                  </div>
                </div>
                <div class="flex flex-row items-center pt-2 space-x-4">
                  <p
                    class="
                      text-base
                      ssm:text-sm
                      se:text-sm
                      leading-7
                      text-gray-900
                    "
                  >
                    Quantity
                  </p>
                  <div class="flex flex-row space-x-2">
                    <button
                      @click="editingProduct.quantity++"
                      class="focus:outline-none"
                    >
                      <span class="material-icons bg-gray-100 text-red-700">
                        add
                      </span>
                    </button>
                    <p
                      class="
                        text-base
                        ssm:text-sm
                        se:text-sm
                        items-center
                        flex
                        leading-none
                        text-gray-900
                      "
                    >
                      {{ Quantity }}
                    </p>
                    <button
                      @click="
                        editingProduct.quantity = minusQty(
                          editingProduct.quantity
                        )
                      "
                      class="focus:outline-none"
                    >
                      <span class="material-icons bg-gray-100 text-red-700">
                        remove
                      </span>
                    </button>
                  </div>
                </div>
                <div
                  class="
                    flex flex-row
                    justify-end
                    items-center
                    ssm:space-x-1
                    space-x-2
                  "
                >
                  <button
                    @click="editItem1 = !editItem1"
                    class="
                      focus:outline-none
                      inline-flex
                      px-4
                      py-2
                      border-2
                      rounded-full
                      border-red-700
                    "
                  >
                    <p
                      class="
                        text-base
                        ssm:text-sm
                        se:text-sm
                        font-bold
                        leading-none
                        text-gray-900
                      "
                    >
                      Cancel
                    </p>
                  </button>
                  <button
                    @click="saveEditingItem(true)"
                    class="
                      focus:outline-none
                      inline-flex
                      px-4
                      py-2.5
                      bg-red-700
                      rounded-full
                    "
                  >
                    <p
                      class="
                        text-base
                        ssm:text-sm
                        se:text-sm
                        font-bold
                        leading-none
                        text-white
                      "
                    >
                      Save
                    </p>
                  </button>
                </div>
              </div>
              <div
                v-if="addnewButton1 && !editItem1"
                class="
                  flex flex-col
                  space-y-2
                  h-auto
                  w-full
                  rounded-xl
                  border-2
                  p-4
                  border-gray-200
                  bg-white
                "
              >
                <div
                  class="
                    flex
                    bg-gray-100
                    rounded-xl
                    w-full
                    flex-col
                    space-y-1
                    h-auto
                    p-2
                  "
                >
                  <p class="text-sm leading-3 text-gray-500">Product</p>
                  <input
                    v-model="product"
                    class="
                      bg-gray-100
                      w-full
                      h-4
                      focus:outline-none
                      text-base
                      leading-none
                      text-gray-900
                    "
                  />
                </div>
                <div class="flex flex-row space-x-2">
                  <div
                    class="
                      flex
                      bg-gray-100
                      rounded-xl
                      w-full
                      flex-col
                      space-y-1
                      h-auto
                      p-2
                    "
                  >
                    <p class="text-sm leading-3 text-gray-500">Brand</p>
                    <input
                      v-model="brand"
                      class="
                        bg-gray-100
                        w-full
                        h-4
                        focus:outline-none
                        text-base
                        leading-none
                        text-gray-900
                      "
                    />
                  </div>
                  <div
                    class="
                      flex
                      bg-gray-100
                      rounded-xl
                      w-full
                      flex-col
                      space-y-1
                      h-auto
                      p-2
                    "
                  >
                    <p class="text-sm leading-3 text-gray-500">Size</p>
                    <input
                      v-model="size"
                      class="
                        bg-gray-100
                        w-full
                        h-4
                        focus:outline-none
                        text-base
                        leading-none
                        text-gray-900
                      "
                    />
                  </div>
                </div>
                <div class="flex flex-row items-center pt-2 space-x-4">
                  <p
                    class="
                      text-base
                      ssm:text-sm
                      se:text-sm
                      leading-7
                      text-gray-900
                    "
                  >
                    Quantity
                  </p>
                  <div class="flex flex-row space-x-2">
                    <button @click="Quantity++" class="focus:outline-none">
                      <span class="material-icons bg-gray-100 text-red-700">
                        add
                      </span>
                    </button>
                    <p
                      class="
                        text-base
                        ssm:text-sm
                        se:text-sm
                        items-center
                        flex
                        leading-none
                        text-gray-900
                      "
                    >
                      {{ Quantity }}
                    </p>
                    <button
                      @click="Quantity = minusQty(Quantity)"
                      class="focus:outline-none"
                    >
                      <span class="material-icons bg-gray-100 text-red-700">
                        remove
                      </span>
                    </button>
                  </div>
                </div>
                <div
                  class="
                    flex flex-row
                    justify-end
                    items-center
                    ssm:space-x-1
                    space-x-2
                  "
                >
                  <button
                    @click="addnewButton1 = !addnewButton1"
                    class="
                      focus:outline-none
                      inline-flex
                      px-4
                      py-2
                      border-2
                      rounded-full
                      border-red-700
                    "
                  >
                    <p
                      class="
                        text-base
                        ssm:text-sm
                        se:text-sm
                        font-bold
                        leading-none
                        text-gray-900
                      "
                    >
                      Cancel
                    </p>
                  </button>
                  <button
                    @click="savedItem2"
                    class="
                      focus:outline-none
                      inline-flex
                      px-4
                      py-2.5
                      bg-red-700
                      rounded-full
                    "
                  >
                    <p
                      class="
                        text-base
                        ssm:text-sm
                        se:text-sm
                        font-bold
                        leading-none
                        text-white
                      "
                    >
                      Save
                    </p>
                  </button>
                </div>
              </div>

              <div
                v-show="addNewListFlag"
                v-for="(item, index) in new_items"
                :key="index"
                class="
                  flex flex-row
                  w-full
                  justify-between
                  items-start
                  vs:space-x-2
                  ssm:space-x-1
                  space-x-4
                  px-0.5
                "
              >
                <div class="flex flex-row vs:space-x-2 ssm:space-x-1 space-x-4">
                  <div
                    class="
                      itemButtons
                      bg-white
                      border-2
                      rounded-none
                      w-4
                      h-4
                      flex flex-shrink-0
                      justify-center
                      items-center
                      mr-2
                      border-gray-900
                    "
                  >
                    <input
                      type="checkbox"
                      :checked="item.status === 1"
                      :id="'check' + item.id"
                    />
                    <!-- <img src="img/check-mark.svg" class="fill-current hidden w-3 h-3 text-black font-bold pointer-events-none"> -->
                  </div>
                  <div class="flex flex-col space-y-2">
                    <p
                      class="
                        text-base
                        ssm:text-sm
                        se:text-sm
                        leading-none
                        text-gray-900
                      "
                    >
                      {{ item.product }} ({{ item.size }})
                    </p>
                    <p
                      class="
                        text-base
                        ssm:text-sm
                        se:text-sm
                        leading-none
                        text-gray-900
                      "
                    >
                      {{ item.brand }}
                    </p>
                  </div>
                </div>
                <div class="flex items-center flex-row space-x-2">
                  <button
                    @click="item.quantity++"
                    class="flex focus:outline-none"
                  >
                    <span class="material-icons bg-gray-100 text-red-700">
                      add
                    </span>
                  </button>
                  <p
                    class="
                      text-base
                      ssm:text-sm
                      se:text-sm
                      items-center
                      flex
                      leading-none
                      text-gray-900
                    "
                  >
                    1
                  </p>
                  <button
                    @clik="item.quantity = minusQty(item.quantity)"
                    class="flex focus:outline-none"
                  >
                    <span class="material-icons bg-gray-100 text-red-700">
                      remove
                    </span>
                  </button>
                  <div>
                    <button
                      @click="productOptions(item)"
                      class="focus:outline-none flex"
                    >
                      <span class="material-icons"> more_vert </span>
                    </button>
                    <div class="relative w-full">
                      <div
                        v-if="
                          editCreatedItem1 && editCreatedItemFlagId == item.id
                        "
                        class="
                          absolute
                          p-2
                          leading-loose
                          rounded-lg
                          border-2 border-gray-100
                          bg-white
                          right-0
                          w-30
                        "
                      >
                        <button
                          @click="editItem(item)"
                          class="
                            flex flex-row
                            items-center
                            font-normal
                            text-base
                            leading-none
                            text-gray-900
                            focus:outline-none
                            gap-x-2
                          "
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
            <!-- <div class="flex px-4 justify-end items-center">
              <p class="text-xs leading-none text-gray-500">Updated 7:13 PM</p>
            </div> -->
          </div>
          <div
            class="
              flex flex-row
              w-full
              justify-around
              vs:space-x-2
              sm:space-x-4
              items-center
              p-4
            "
          >
            <button
              @click="
                createNewShopList = !createNewShopList;
                openSelectShoppingList = !openSelectShoppingList;
              "
              class="
                focus:outline-none
                flex
                items-center
                justify-center
                w-56
                h-full
                px-4
                py-2
                border-2
                rounded-full
                border-red-700
              "
            >
              <p class="text-base font-bold leading-none text-gray-900">
                Cancel
              </p>
            </button>
            <button
              @click="saveNewList"
              class="
                focus:outline-none
                flex
                items-center
                justify-center
                w-56
                h-full
                px-4
                py-2.5
                bg-red-700
                rounded-full
              "
            >
              <p class="text-base font-bold leading-none text-white">Save</p>
            </button>
          </div>
        </div>
      </div>
    </transition>
    <!--end-->

    <!--Edit Shopping List Modal-->
    <transition name="fadeSlide2">
      <div
        v-if="showEditShopListModal"
        class="
          z-50
          scrolledCenterMe
          fixed
          font-nunito
          vs:px-2
          ssm:px-2
          vs:px-2
          sm:px-2
        "
      >
        <div
          class="
            flex flex-col
            bg-white
            shadow
            rounded-xl
            h-auto
            w-550
            ssm:w-full
            px-4
            vs:w-full
            sm:w-full
          "
        >
          <div class="flex justify-between items-center py-4 flex-row">
            <button
              @click="showEditShopListModalMethod()"
              class="
                focus:outline-none
                text-sm
                font-bold
                leading-none
                text-right text-indigo-900
              "
            >
              Back
            </button>
            <p
              class="
                text-2xl
                ssm:text-sm
                se:text-base
                vs:text-lg
                font-bold
                leading-normal
                text-center text-gray-900
              "
            >
              Edit Shopping List
            </p>
            <button
              class="
                invisible
                text-sm
                font-bold
                leading-none
                text-right text-indigo-900
              "
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
                v-model="shopping_info.shoppingListName"
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
            <button
              @click="addnew()"
              v-if="!editItem1"
              class="flex items-center flex-row px-2 space-x-2"
            >
              <span class="text-gray-900 material-icons"> add_circle </span>
              <p class="text-base leading-none text-gray-900">Add new item</p>
            </button>

            <div
              v-if="editItem1"
              class="
                flex flex-col
                space-y-2
                h-auto
                w-full
                rounded-xl
                border-2
                p-4
                border-gray-200
                bg-white
              "
            >
              <div
                class="
                  flex
                  bg-gray-100
                  rounded-xl
                  w-full
                  flex-col
                  space-y-1
                  h-auto
                  p-2
                "
              >
                <p class="text-sm leading-3 text-gray-500">Product</p>
                <input
                  v-model="editingProduct.product"
                  class="
                    bg-gray-100
                    w-full
                    h-4
                    focus:outline-none
                    text-base
                    leading-none
                    text-gray-900
                  "
                />
              </div>
              <div class="flex flex-row space-x-2">
                <div
                  class="
                    flex
                    bg-gray-100
                    rounded-xl
                    w-full
                    flex-col
                    space-y-1
                    h-auto
                    p-2
                  "
                >
                  <p class="text-sm leading-3 text-gray-500">Brand</p>
                  <input
                    v-model="editingProduct.brand"
                    class="
                      bg-gray-100
                      w-full
                      h-4
                      focus:outline-none
                      text-base
                      leading-none
                      text-gray-900
                    "
                  />
                </div>
                <div
                  class="
                    flex
                    bg-gray-100
                    rounded-xl
                    w-full
                    flex-col
                    space-y-1
                    h-auto
                    p-2
                  "
                >
                  <p class="text-sm leading-3 text-gray-500">Size</p>
                  <input
                    v-model="editingProduct.size"
                    class="
                      bg-gray-100
                      w-full
                      h-4
                      focus:outline-none
                      text-base
                      leading-none
                      text-gray-900
                    "
                  />
                </div>
              </div>
              <div class="flex flex-row items-center pt-2 space-x-4">
                <p
                  class="
                    text-base
                    ssm:text-sm
                    se:text-sm
                    leading-7
                    text-gray-900
                  "
                >
                  Quantity
                </p>
                <div class="flex flex-row space-x-2">
                  <button
                    @click="editingProduct.quantity++"
                    class="focus:outline-none"
                  >
                    <span class="material-icons bg-gray-100 text-red-700">
                      add
                    </span>
                  </button>
                  <p
                    class="
                      text-base
                      ssm:text-sm
                      se:text-sm
                      items-center
                      flex
                      leading-none
                      text-gray-900
                    "
                  >
                    {{ editingProduct.quantity }}
                  </p>
                  <button
                    @click="
                      editingProduct.quantity = minusQty(
                        editingProduct.quantity
                      )
                    "
                    class="focus:outline-none"
                  >
                    <span class="material-icons bg-gray-100 text-red-700">
                      remove
                    </span>
                  </button>
                </div>
              </div>
              <div
                class="
                  flex flex-row
                  justify-end
                  items-center
                  ssm:space-x-1
                  space-x-2
                "
              >
                <button
                  @click="editItem1 = !editItem1"
                  class="
                    focus:outline-none
                    inline-flex
                    px-4
                    py-2
                    border-2
                    rounded-full
                    border-red-700
                  "
                >
                  <p
                    class="
                      text-base
                      ssm:text-sm
                      se:text-sm
                      font-bold
                      leading-none
                      text-gray-900
                    "
                  >
                    Cancel
                  </p>
                </button>
                <button
                  @click="saveEditingItem(false)"
                  class="
                    focus:outline-none
                    inline-flex
                    px-4
                    py-2.5
                    bg-red-700
                    rounded-full
                  "
                >
                  <p
                    class="
                      text-base
                      ssm:text-sm
                      se:text-sm
                      font-bold
                      leading-none
                      text-white
                    "
                  >
                    Save
                  </p>
                </button>
              </div>
            </div>

            <div
              v-if="addnewButton1 && !editItem1"
              class="flex space-y-3 flex-col w-full px-4"
            >
              <div
                class="
                  flex flex-col
                  space-y-2
                  h-auto
                  w-full
                  rounded-xl
                  border-2
                  p-4
                  border-gray-200
                  bg-white
                "
              >
                <div
                  class="
                    flex
                    bg-gray-100
                    rounded-xl
                    w-full
                    flex-col
                    space-y-1
                    h-auto
                    p-2
                  "
                >
                  <p class="text-sm leading-3 text-gray-500">Product</p>
                  <input
                    v-model="product"
                    class="
                      bg-gray-100
                      w-full
                      h-4
                      focus:outline-none
                      text-base
                      leading-none
                      text-gray-900
                    "
                  />
                </div>
                <div class="flex flex-row space-x-2">
                  <div
                    class="
                      flex
                      bg-gray-100
                      rounded-xl
                      w-full
                      flex-col
                      space-y-1
                      h-auto
                      p-2
                    "
                  >
                    <p class="text-sm leading-3 text-gray-500">Brand</p>
                    <input
                      @keyup="brandsearch()"
                      @click="brandsearch()"
                      v-model="brand"
                      class="
                        bg-gray-100
                        w-full
                        h-4
                        focus:outline-none
                        text-base
                        leading-none
                        text-gray-900
                      "
                    />

                    <div class="relative">
                      <div
                        v-if="brandSearchTag"
                        class="
                          absolute
                          py-3
                          bg-white
                          rounded-lg
                          shadow-xl
                          right-0
                          h-35.1
                          sm:w-full
                          w-full
                        "
                      >
                        <div
                          class="
                            flex flex-col
                            w-full
                            px-2
                            justify-start
                            items-start
                          "
                        >
                          <div
                            id="scroll1"
                            class="
                              flex
                              px-2
                              flex-col
                              overflow-y-scroll
                              w-full
                              h-24
                            "
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
                  <div
                    class="
                      flex
                      bg-gray-100
                      rounded-xl
                      w-full
                      flex-col
                      space-y-1
                      h-auto
                      p-2
                    "
                  >
                    <p class="text-sm leading-3 text-gray-500">Size</p>
                    <input
                      v-model="size"
                      class="
                        bg-gray-100
                        w-full
                        h-4
                        focus:outline-none
                        text-base
                        leading-none
                        text-gray-900
                      "
                    />
                  </div>
                </div>
                <div class="flex flex-row items-center pt-2 space-x-4">
                  <p
                    class="
                      text-base
                      ssm:text-sm
                      se:text-sm
                      leading-7
                      text-gray-900
                    "
                  >
                    Quantity
                  </p>
                  <div class="flex flex-row space-x-2">
                    <button @click="Quantity++" class="focus:outline-none">
                      <span class="material-icons bg-gray-100 text-red-700">
                        add
                      </span>
                    </button>
                    <p
                      class="
                        text-base
                        ssm:text-sm
                        se:text-sm
                        items-center
                        flex
                        leading-none
                        text-gray-900
                      "
                    >
                      {{ Quantity }}
                    </p>
                    <button
                      @click="Quantity = minusQty(Quantity)"
                      class="focus:outline-none"
                    >
                      <span class="material-icons bg-gray-100 text-red-700">
                        remove
                      </span>
                    </button>
                  </div>
                </div>
                <div
                  class="
                    flex flex-row
                    justify-end
                    items-center
                    ssm:space-x-1
                    space-x-2
                  "
                >
                  <button
                    @click="addnewButton1 = !addnewButton1"
                    class="
                      focus:outline-none
                      inline-flex
                      px-4
                      py-2
                      border-2
                      rounded-full
                      border-red-700
                    "
                  >
                    <p
                      class="
                        text-base
                        ssm:text-sm
                        se:text-sm
                        font-bold
                        leading-none
                        text-gray-900
                      "
                    >
                      Cancel
                    </p>
                  </button>
                  <button
                    @click="savedItem1"
                    class="
                      focus:outline-none
                      inline-flex
                      px-4
                      py-2.5
                      bg-red-700
                      rounded-full
                    "
                  >
                    <p
                      class="
                        text-base
                        ssm:text-sm
                        se:text-sm
                        font-bold
                        leading-none
                        text-white
                      "
                    >
                      Save
                    </p>
                  </button>
                </div>
              </div>
            </div>

            <div class="flex px-4 justify-end items-center">
              <p
                v-if="selectedList != null"
                class="text-xs leading-none text-gray-500"
              >
                Last updated at {{ timestamp(selectedList.dateModified) }}
              </p>
            </div>
          </div>
          <div
            id="scroll1"
            class="
              flex flex-col
              py-1
              px-2
              vs:px-2
              ssm:px-1
              overflow-y-auto
              h-40
              vs:h-36
              ssm:space-y-1
              vs:space-y-2
              space-y-4
              w-full
            "
          >
            <div
              class="
                flex flex-row
                w-full
                justify-between
                items-center
                space-x-3
              "
              v-for="item in shopping_info.items"
              :key="item.id"
            >
              <div class="flex flex-row vs:space-x-2 ssm:space-x-1 space-x-4">
                <div
                  class="
                    itemButtons
                    bg-white
                    border-2
                    rounded-none
                    w-4
                    h-4
                    flex flex-shrink-0
                    justify-center
                    items-center
                    mr-2
                    border-gray-900
                  "
                >
                  <input
                    type="checkbox"
                    :checked="item.status === 1"
                    :id="'check' + item.id"
                  />
                </div>
                <div class="flex flex-col space-y-2">
                  <p
                    class="
                      text-base
                      ssm:text-sm
                      se:text-sm
                      leading-none
                      text-gray-900
                    "
                  >
                    {{ item.product }} ({{ item.size }})
                  </p>
                  <p
                    class="
                      text-base
                      ssm:text-sm
                      se:text-sm
                      leading-none
                      text-gray-900
                    "
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
                  class="
                    text-base
                    ssm:text-sm
                    se:text-sm
                    items-center
                    flex
                    leading-none
                    text-gray-900
                  "
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
                <button
                  @click="productOptions(item)"
                  class="focus:outline-none flex"
                >
                  <span class="material-icons"> more_vert </span>
                </button>
                <div class="relative w-full">
                  <div
                    v-if="editCreatedItem1 && editCreatedItemFlagId == item.id"
                    class="
                      absolute
                      p-2
                      leading-loose
                      rounded-lg
                      border-2 border-gray-100
                      bg-white
                      right-0
                      w-30
                    "
                  >
                    <button
                      @click="editItem(item)"
                      class="
                        flex flex-row
                        items-center
                        font-normal
                        text-base
                        leading-none
                        text-gray-900
                        focus:outline-none
                        gap-x-2
                      "
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
          <div
            class="
              flex flex-row
              w-full
              justify-around
              vs:space-x-2
              ssm:space-x-1
              sm:space-x-4
              items-center
              py-4
            "
          >
            <button
              @click="showEditShopListModalMethod()"
              class="
                focus:outline-none
                flex
                items-center
                justify-center
                w-56
                h-full
                px-4
                py-2
                border-2
                rounded-full
                border-red-700
              "
            >
              <p
                class="
                  text-base
                  ssm:text-sm
                  se:text-sm
                  font-bold
                  leading-none
                  text-gray-900
                "
              >
                Cancel
              </p>
            </button>
            <button
              @click="saveList"
              class="
                focus:outline-none
                flex
                items-center
                justify-center
                w-56
                h-full
                px-4
                py-2.5
                bg-red-700
                rounded-full
              "
            >
              <p
                class="
                  text-base
                  ssm:text-sm
                  se:text-sm
                  font-bold
                  leading-none
                  text-white
                "
              >
                Save Changes
              </p>
            </button>
          </div>
        </div>
      </div>
    </transition>
    <!--Select Shopping List Modal-->
    <transition name="fadeSlide">
      <div
        v-if="showSelectShopListModal"
        class="
          hideIf2
          font-nunito
          fixed
          z-50
          inset-0
          flex
          ssm:px-2
          vs:px-2
          sm:px-2
          justify-center
          items-center
        "
      >
        <div
          class="
            flex flex-col
            bg-white
            shadow
            rounded-xl
            h-auto
            w-550
            ssm:w-full
            vs:w-full
            sm:w-full
          "
        >
          <div class="flex justify-between items-center p-4 flex-row">
            <button
              @click="
                (showSelectShopListModal = !showSelectShopListModal),
                  (mainModal = true)
              "
              class="
                focus:outline-none
                text-sm
                font-bold
                leading-none
                text-right text-indigo-900
              "
            >
              Back
            </button>
            <p
              class="
                text-2xl
                ssm:text-sm
                se:text-base
                vs:text-lg
                font-bold
                leading-normal
                text-center text-gray-900
              "
            >
              Select Shopping List
            </p>
            <button
              class="
                invisible
                text-sm
                font-bold
                leading-none
                text-right text-indigo-900
              "
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
                      class="form-radio w-4 h-4 vs:w-3 vs:h-3 lvs:w-4 lvs:h-4"
                      :id="'listNumber' + list.shoppingListNumber"
                    />
                    <span
                      class="
                        ml-5
                        text-base
                        ssm:text-xs
                        vs:text-sm
                        lvs:text-base
                      "
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
                      class="
                        absolute
                        p-2
                        leading-loose
                        rounded-lg
                        border-2 border-gray-100
                        bg-white
                        right-0
                        w-30
                      "
                    >
                      <button
                        @click="editShopListAtSelectShopList"
                        class="
                          flex flex-row
                          items-center
                          font-normal
                          text-base
                          leading-none
                          text-gray-900
                          focus:outline-none
                          gap-x-2
                        "
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
            class="
              flex flex-row
              w-full
              justify-around
              vs:space-x-2
              sm:space-x-4
              items-center
              p-4
            "
          >
            <button
              @click="createNewShopList"
              v-if="false"
              class="
                focus:outline-none
                flex
                items-center
                justify-center
                w-56
                h-full
                px-4
                py-2
                border-2
                rounded-full
                border-red-700
              "
            >
              <p class="text-base font-bold leading-none text-gray-900">
                Create New
              </p>
            </button>
            <button
              @click="confirmShopList"
              class="
                focus:outline-none
                flex
                items-center
                justify-center
                w-56
                h-full
                px-4
                py-2.5
                bg-red-700
                rounded-full
              "
            >
              <p class="text-base font-bold leading-none text-white">Confirm</p>
            </button>
          </div>
        </div>
      </div>
    </transition>
  </div>
  <!--end-->
</template>

<script>
import store from "../store/index";
// import VueSimpleAlert from "vue-simple-alert";
import api from "../api";
import moment from "moment";
import axios from "axios";
import _ from "lodash";
import $ from "jquery";

export default {
  props: ["post", "ctrProp"],
  data() {
    return {
      editCreatedItem1: false,
      editCreatedItemFlagId: null,
      createNewShopList: false,
      openSelectShoppingList: false,
      Quantity: 1,
      product: null,
      brand: null,
      size: null,
      new_item: false,
      addnewButton1: false,
      createList1: false,
      myItem1OnList: false,
      mainModal: true,
      isVisible: true,
      listEdit: false,
      hidden: false,
      show: true,
      Payments: ["Cash on Delivery", "Gcash", "PayMaya", "Online Banking"],
      delivery_info: {
        postIdentity: this.post.postIdentity,
        postStatus: this.post.request_post.postStatus,
        deliveryArea: "none",
        shoppingPlace: this.post.request_post.shoppingPlace,
        deliverySchedule: moment(
          this.post.request_post.deliverySchedule
        ).format("YYYY-MM-DDThh:mm"),
        dateModified: moment(this.post.request_post.dateModified).format(
          "YYYY-MM-DDThh:mm"
        ),
        transportMode: "none",
        capacity: "none",
        paymentMethod: this.post.request_post.paymentMethod,
        caption: this.post.request_post.caption,
        deliveryAddress: this.post.request_post.deliveryAddress,
        shoppingList: null,
      },
      shopping_info: {
        items: JSON.parse(
          JSON.stringify(this.post.request_post.shoppingListContent)
        ),
        shoppingListName: JSON.parse(
          JSON.stringify(this.post.request_post.shoppingListTitle)
        ),
      },
      shopping_infoDisplay: {
        items: JSON.parse(
          JSON.stringify(this.post.request_post.shoppingListContent)
        ),
        shoppingListName: JSON.parse(
          JSON.stringify(this.post.request_post.shoppingListTitle)
        ),
      },
      addAddress: false,
      dropdown1: false,
      dropdown2: false,
      dropdown3: false,
      dropdown4: false,
      limit_by: 4,
      default_limit: 4,
      showListStatus: "See More",
      showLessStatus: "See Less",
      isActive: false,
      showEditShopListModal: false,
      oldList: null,
      selectedList: null,
      ctr: this.ctrProp,
      brandSearchTag: false,
      brands: null,
      new_items: [],
      ctr1: 0,
      addNewListFlag: false,
      edit2: null,
      edit3: false,
      editingProduct: null,
      editItem1: false,
    };
  },
  methods: {
    saveEditingItem(isNewItem) {
      var i;
      if (isNewItem) {
        for (i = 0; i < this.new_items.length; i++) {
          if (this.new_items[i].id == this.editingProduct.id) {
            this.new_items[i] = this.editingProduct;
          }
        }
      } else {
        for (i = 0; i < this.shopping_info.items.length; i++) {
          if (this.shopping_info.items[i].id == this.editingProduct.id) {
            this.shopping_info.items[i] = this.editingProduct;
          }
        }
      }

      this.editItem1 = !this.editItem1;
    },
    editItem(item) {
      console.log(item);
      this.editItem1 = !this.editItem1;
      this.editingProduct = JSON.parse(JSON.stringify(item));
      this.editCreatedItem1 = !this.editCreatedItem1;
    },
    productOptions(item) {
      console.log("product");
      this.editCreatedItem1 = !this.editCreatedItem1;
      this.editCreatedItemFlagId = item.id;
    },
    saveNewList() {
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
      api
        .post("api/createList", obj)
        .then((res) => {
          store.dispatch("getUserShoppingList").then(() => {
            this.selectedList = res.data;
            // this.showItemList = true;
            // console.log("before", this.selectedList, this.showItemList);
            // this.new_items = [];
            // // this.addlist = false;
            // if (this.listToggleFlag) this.togglePostModal();
            // this.listToggleFlag = false;
            this.createNewShopList = !this.createNewShopList;
            this.openSelectShoppingList = !this.openSelectShoppingList;
          });
        })
        .catch(() => {
          //if encountered error means the user will not add a new shopping list
          this.new_items = [];
          this.createNewShopList = !this.createNewShopList;
          this.openSelectShoppingList = !this.openSelectShoppingList;
        });
    },
    saveList() {
      for (var i = 0; i < this.shopping_info.items.length; i++) {
        if (document.getElementById("check" + i).checked) {
          this.shopping_info.items[i].status = 1;
        } else {
          this.shopping_info.items[i].status = 0;
        }
      }
      this.shopping_infoDisplay = this.shopping_info;
      this.mainModal = !this.mainModal;
      this.openSelectShoppingList = !this.openSelectShoppingList;
      this.showEditShopListModal = !this.showEditShopListModal;
    },
    confirmShopList() {
      this.showShopListButton = false;
      var tempList = this.shoppingLists;
      for (var i = 0; i < tempList.length; i++) {
        if (
          document.getElementById("listNumber" + tempList[i].shoppingListNumber)
            .checked
        ) {
          this.shopping_info.items = tempList[i].shoppingListContent;
          this.shopping_info.shoppingListName = tempList[i].shoppingListTitle;
          this.shopping_infoDisplay.items = tempList[i].shoppingListContent;
          this.shopping_infoDisplay.shoppingListName =
            tempList[i].shoppingListTitle;
          //  this.selectedList.shoppingListContent = filtered_list
        }
      }
      console.log("selected List", this.selectedList);
      // openSelectShoppingList=!openSelectShoppingList, mainModal=!mainModal
      this.mainModal = !this.mainModal;
      this.openSelectShoppingList = !this.openSelectShoppingList;
      $(".hideIf").fadeIn();
    },

    setBrand(index) {
      this.brand = document.getElementById("brand" + index).innerHTML;
    },
    brandsearch() {
      let vm = this;
      console.log("brand", this.brand);
      this.debounceSearchBrand(vm, this.brand);
      console.log("brandssssssssssssss", this.brands);
      if (this.brands != null) this.brandSearchTag = true;
      else this.brandSearchTag = false;
    },
    debounceSearchBrand: _.debounce((vm, brandParam) => {
      var data = brandParam;
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
            returnBrands.push(res.data.hints[i].food.brand);
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
    savedItem1() {
      let productx = this.product;
      let brandx = this.brand;
      let sizex = this.size;
      let quantx = this.Quantity;
      if (productx == null || brandx == null || sizex == null || quantx <= 0) {
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
      this.shopping_info.items.push(obj);
      // console.log(this.shoppingLists[0].shoppingListContent);
      this.product = "";
      this.brand = "";
      this.size = "";
      this.Quantity = 1;
      this.new_item = false;
    },
    savedItem2() {
      let productx = this.product;
      let brandx = this.brand;
      let sizex = this.size;
      let quantx = this.Quantity;
      if (productx == null || brandx == null || sizex == null || quantx <= 0) {
        alert("Empty Field");
        return false;
      }
      let obj = {
        id: this.ctr1,
        product: productx,
        brand: brandx,
        size: sizex,
        quantity: parseInt(quantx),
        status: 1,
        statusDeliver: 0,
      };
      this.ctr1++;
      this.new_items.push(obj);
      // console.log(this.shoppingLists[0].shoppingListContent);
      this.product = "";
      this.brand = "";
      this.size = "";
      this.Quantity = 1;
      this.addNewListFlag = true;
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

    minusQty(q) {
      q--;
      if (q <= 0) return 1;
      return q;
    },
    addnew() {
      this.addnewButton1 = !this.addnewButton1;
    },
    showEditShopListModalMethod() {
      if (this.openSelectShoppingList) {
        this.openSelectShoppingList = !this.openSelectShoppingList;
      }
      this.showEditShopListModal = !this.showEditShopListModal;
      // console.log( this.showEditShopListModal,this.openSelectShoppingList,this.mainModal,'b4')
      this.mainModal = !this.mainModal;
      // console.log( this.showEditShopListModal,this.openSelectShoppingList,this.mainModal,'after')
      if (this.oldList != null) {
        this.shopping_info = JSON.parse(JSON.stringify(this.oldList));
      }
      console.log("old list", this.selectedList);
    },
    editShopListAtSelectShopList() {
      this.oldList = JSON.parse(JSON.stringify(this.shopping_info));
      var tempList = this.shoppingLists;
      console.log("selected List", tempList, this.edit2);
      var temp = tempList.filter((x) => {
        return x.shoppingListNumber === this.edit2;
      });
      this.selectedList = JSON.parse(JSON.stringify(temp[0]));
      console.log("selected List", this.selectedList);
      this.shopping_info.items = JSON.parse(
        JSON.stringify(this.selectedList.shoppingListContent)
      );
      this.shopping_info.shoppingListName = this.selectedList.shoppingListTitle;
      this.showSelectShopListModal = !this.showSelectShopListModal;
      this.showEditShopListModal = !this.showEditShopListModal;
      this.ctr = this.selectedList.shoppingListContent.id + 1;

      // $(".hideIf").fadeIn();
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
      var temp = list.filter((x) => {
        return x.status == 1;
      });
      return this.limit_by ? temp.slice(0, this.limit_by) : temp;
    },
    isFew(filter_itemList) {
      filter_itemList.length < 5;
    },
    close2() {
      this.$emit("closeModal1");
    },
    Edit(pars) {
      let x = document.getElementById(pars).innerHTML;
      if (x == "Change") {
        document.getElementById(pars).innerHTML = "Save";
      } else {
        document.getElementById(pars).innerHTML = "Change";
      }
    },
    saveChanges() {
      // var list = document.getElementById("userList").getElementsByTagName("li");
      // var newList = "";
      // for (var i = 0; i < list.length; i++) {
      //   newList = newList + ", ".concat(list[i].outerText);
      // }

      // var stringList = newList.substr(2);
      this.delivery_info.shoppingList = this.shopping_info;
      // for(var i=0;i<this.shopping_info.items.length;i++){
      //   if(document.getElementById("check"+i).checked){
      //     this.shopping_info.items[i].status = 1
      //   }else{
      //     this.shopping_info.items[i].status = 0
      //   }
      // }

      api
        .put("api/post/" + this.post.postNumber + "/edit", this.delivery_info)
        .then(() => {
          store.dispatch("getPosts").then(() => {
            store.dispatch("getShoppingPlaces");
            this.$emit("getSortPosts");
          });
          this.close2();
        });
    },
    openAddModal() {
      this.addAddress = !this.addAddress;
    },

    getHomeAddressValue() {
      this.delivery_info.deliveryAddress =
        document.getElementById("homeAdd").innerHTML;
      console.log(document.getElementById("homeAdd").innerHTML);
    },
    getShipAddressValue(index) {
      this.delivery_info.deliveryAddress = document.getElementById(
        "shipAdd" + index
      ).innerHTML;
      console.log(document.getElementById("shipAdd" + index).innerHTML);
    },
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
    setShoppingPlace(index) {
      this.delivery_info.shoppingPlace = document.getElementById(
        "sp" + index
      ).innerHTML;
    },
    setPayment(index) {
      this.delivery_info.paymentMethod = document.getElementById(
        "pm" + index
      ).innerHTML;
    },
  },
  computed: {
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
    shoppingLists() {
      return store.getters.getUserShoppingList;
    },
    shoppingPlaces() {
      return store.getters.getShoppingPlaces;
    },
  },
};
</script>
