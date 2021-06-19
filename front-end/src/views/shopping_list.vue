<template>
  <Nav />
  <div class="flex flex-col justify-center font-nunito p-3 space-y-4">
    <div
      class="
        w-608
        flex-col
        justify-center
        self-center
        mt-24
        gap-y-5
        hidden
        2xl:block
        xl:block
        lg:block
      "
    >
      <p class="text-2xl font-nunito font-bold flex uppercase">
        shopping lists
      </p>
    </div>
    <div class="flex justify-center">
      <div
        class="
          w-608
          mt-20
          2xl:w-608
          2xl:mt-0
          lg:w-608
          lg:mt-0
          xl:w-608
          xl:mt-0
          md:w-10/12
          md:mt-0
          sm:w-11/12
          p-6
          rounded-xl
          shadow-lg
          bg-white
        "
      >
        <button
          @click="addlist = !addlist"
          class="
            bg-gray-200
            rounded-2xl
            w-full
            text-left text-gray-400
            h-16
            pl-2
            focus:outline-none
          "
        >
          Create new shopping list
        </button>
        <div
          v-if="addlist"
          class="fixed z-100 bg-black bg-opacity-75 overflow-y-auto inset-0"
        >
          <div class="flex mt-4 w-full p-3 items-center justify-center py-20">
            <div
              class="
                self-center
                bg-white
                ring-1 ring-gray-300
                py-2
                w-full
                rounded-xl
                2xl:w-608
                2xl:mt-0
                lg:w-608
                lg:mt-0
                xl:w-608
                xl:mt-0
                md:w-10/12
                md:mt-0
                sm:w-11/12
                p-5
                space-y-3
                h-auto
              "
            >
              <div class="flex flex-row items-center space-x-2">
                <input
                  type="text"
                  placeholder="Title"
                  id="new_title"
                  class="font-bold h-10 pl-3 focus:outline-none bg-gray-100"
                />
                <span
                  class="
                    cursor-pointer
                    select-none
                    material-icons
                    text-md text-gray-500
                  "
                >
                  mode
                </span>
              </div>
              <div
                v-if="!editItem1"
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
                  class="
                    rounded-xl
                    pl-5
                    w-full
                    focus:outline-none
                    h-10
                    bg-gray-100
                  "
                />
                <div class="flex flex-row space-x-2">
                  <input
                    id="brand"
                    type="text"
                    placeholder="Brand"
                    class="
                      rounded-xl
                      pl-5
                      w-full
                      focus:outline-none
                      h-10
                      bg-gray-100
                    "
                  />
                  <input
                    id="size"
                    type="text"
                    placeholder="Size"
                    class="
                      w-40
                      rounded-xl
                      pl-5
                      focus:outline-none
                      h-10
                      bg-gray-100
                    "
                  />
                </div>
                <div class="flex flex-row space-x-2">
                  <p class="font-bold">Quantity</p>
                  <span
                    @click="quantity++"
                    class="
                      material-icons
                      select-none
                      cursor-pointer
                      text-red-700
                    "
                  >
                    add
                  </span>
                  <p id="quants">{{ quantity }}</p>
                  <span
                    @click="quantity = minusQty(quantity)"
                    class="
                      material-icons
                      select-none
                      cursor-pointer
                      text-red-700
                    "
                  >
                    remove
                  </span>
                </div>
                <div class="flex justify-end">
                  <div class="space-x-3">
                    <button
                      @click="new_item = false"
                      class="
                        ring-2
                        rounded-2xl
                        h-6
                        w-20
                        font-bold
                        ring-red-buttons
                        focus:outline-none
                      "
                    >
                      Cancel
                    </button>
                    <button
                      @click="add_newItem()"
                      class="
                        ring-2
                        rounded-2xl
                        h-6
                        w-20
                        font-bold
                        text-white
                        ring-red-buttons
                        focus:outline-none
                        bg-red-buttons
                      "
                    >
                      Add
                    </button>
                  </div>
                </div>
              </div>
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
                    @click="saveEditingItem(true, index)"
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

              <hr class="bg-black" />

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
                            :checked="item.status == 1"
                            :value="item.product"
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
                          @click="item.quantity = item.quantity + 1"
                          class="
                            material-icons
                            select-none
                            cursor-pointer
                            text-red-700
                          "
                        >
                          add
                        </span>
                        <div class="w-3 h-3">
                          <p>{{ item.quantity }}</p>
                        </div>
                        <span
                          @click="item.quantity = minusQty(item.quantity)"
                          class="
                            material-icons
                            select-none
                            cursor-pointer
                            text-red-700
                          "
                        >
                          remove
                        </span>
                        <div class="relative">
                          <span
                            @click="newProductOptions(item)"
                            class="cursor-pointer material-icons"
                          >
                            more_vert
                          </span>
                          <div
                            v-if="
                              editCreatedItem1 &&
                              editCreatedItemFlagId == item.id
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
                              <span
                                class="material-icons text-base text-gray-900"
                              >
                                mode
                              </span>
                              Edit
                            </button>
                            <button
                              @click="newDeleteItem(item)"
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
                              <span
                                class="material-icons text-base text-gray-900"
                              >
                                delete
                              </span>
                              Delete
                            </button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </li>
                </ul>
              </div>
              <div class="flex flex-row items-center justify-between">
                <div class="space-x-3 text-gray-500">
                  <span
                    @click="new_items = []"
                    class="material-icons cursor-pointer select-none"
                  >
                    delete
                  </span>
                  <span
                    @click="add_shopping_list()"
                    class="material-icons cursor-pointer select-none"
                  >
                    post_add
                  </span>
                </div>
                <p
                  @click="addNewList()"
                  class="cursor-pointer text-blue-700 font-bold select-none"
                >
                  Close
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div
      v-for="(item, index) in shoppingList"
      :key="item.indexShoppingList"
      class="flex flex-col justify-center"
    >
      <div
        class="
          self-center
          bg-white
          ring-1 ring-gray-300
          py-2
          w-full
          rounded-xl
          2xl:w-608
          2xl:mt-0
          lg:w-608
          lg:mt-0
          xl:w-608
          xl:mt-0
          md:w-10/12
          md:mt-0
          sm:w-11/12
          h-auto
        "
      >
        <div class="p-2 self-center">
          <div class="flex flex-row items-center space-x-2 mb-3">
            <p
              v-if="label_title"
              :id="item.indexShoppingList"
              class="font-bold select-none"
            >
              {{ item.shoppingListTitle }}
            </p>
            <input
              :id="item.shoppingListTitle"
              type="text"
              :value="item.shoppingListTitle"
              class="p-2 hidden focus:outline-none bg-gray-100"
            />
            <span
              @click="
                title_edit(
                  item.indexShoppingList,
                  item.shoppingListTitle,
                  index
                )
              "
              class="
                cursor-pointer
                select-none
                material-icons
                text-md text-gray-500
              "
            >
              mode
            </span>
          </div>
          <div
            class="flex flex-row items-center space-x-3 select-none pl-3"
            v-if="!editItem1"
          >
            <span
              @click="
                view_list(
                  item.shoppingListTitle + 'addlist' + item.indexShoppingList
                )
              "
              class="cursor-pointer material-icons"
            >
              add_circle
            </span>
            <p class="">Add new item</p>
          </div>
          <div class="addlist_x"></div>
          <div
            v-if="editItem1 && editingListID == item.indexShoppingList"
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
                class="text-base ssm:text-sm se:text-sm leading-7 text-gray-900"
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
                    editingProduct.quantity = minusQty(editingProduct.quantity)
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
                @click="saveEditingItem(false, index)"
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
            :id="item.shoppingListTitle + 'addlist' + item.indexShoppingList"
            class="ring-1 hidden ring-gray-400 p-5 mt-4 space-y-3 rounded-xl"
          >
            <input
              :id="item.indexShoppingList + 'product'"
              type="text"
              placeholder="Product"
              class="rounded-xl pl-5 w-full focus:outline-none h-10 bg-gray-100"
            />
            <div class="flex flex-row space-x-2">
              <input
                :id="item.indexShoppingList + 'brand'"
                type="text"
                placeholder="Brand"
                class="
                  rounded-xl
                  pl-5
                  w-full
                  focus:outline-none
                  h-10
                  bg-gray-100
                "
              />
              <input
                :id="item.indexShoppingList + 'size'"
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
              <p :id="item.indexShoppingList + 'quants'">{{ quantity }}</p>
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
                  @click="
                    view_list(
                      item.shoppingListTitle +
                        'addlist' +
                        item.indexShoppingList
                    )
                  "
                  class="
                    ring-2
                    rounded-2xl
                    h-6
                    w-20
                    font-bold
                    ring-red-buttons
                    focus:outline-none
                  "
                >
                  Cancel
                </button>
                <button
                  @click="
                    add_item_shopping_list(
                      item.indexShoppingList + 'product',
                      item.indexShoppingList + 'brand',
                      item.indexShoppingList + 'size',
                      item.shoppingListTitle,
                      item.indexShoppingList + 'quants',
                      index
                    )
                  "
                  class="
                    ring-2
                    rounded-2xl
                    h-6
                    w-20
                    font-bold
                    text-white
                    ring-red-buttons
                    focus:outline-none
                    bg-red-buttons
                  "
                >
                  Add
                </button>
              </div>
            </div>
          </div>
          <!---->
        </div>
        <div :id="item.shoppingListTitle + 'shop' + item.indexShoppingList">
          <ul id="example-1" class="text-sm list-inside space-y-2 p-5 w-full">
            <li
              v-for="item_list in item.shoppingListContent"
              :key="item_list.id"
              class="grid-cols-2 w-ful list-none"
            >
              <div class="flex flex-row justify-between w-full">
                <div class="flex flex-col">
                  <div class="flex flex-row text-md items-center space-x-3">
                    <input
                      :checked="item_list.status == 1"
                      type="checkbox"
                      class=""
                      :id="item.indexShoppingList + '-' + item_list.id"
                      :value="item_list.product"
                      @click="checkOrUncheck(index)"
                    />
                    <label class=""
                      >{{ item_list.product }}({{ item_list.size }})</label
                    >
                  </div>
                  <div class="flex justify-start pl-8">
                    <p class="text-sm">{{ item_list.brand }}</p>
                  </div>
                </div>

                <div class="flex flex-row space-x-5">
                  <span
                    @click="
                      item_list.quantity = addQty(item_list.quantity);
                      changeQty(index);
                    "
                    class="
                      material-icons
                      select-none
                      cursor-pointer
                      text-red-700
                    "
                  >
                    add
                  </span>
                  <div class="w-3 h-3">
                    <p>{{ item_list.quantity }}</p>
                  </div>
                  <span
                    @click="
                      item_list.quantity = minusQty(item_list.quantity);
                      changeQty(index);
                    "
                    class="
                      material-icons
                      select-none
                      cursor-pointer
                      text-red-700
                    "
                  >
                    remove
                  </span>
                  <div class="relative">
                    <button
                      @click="productOptions(item_list, item)"
                      class="focus:outline-none flex"
                    >
                      <span class="material-icons"> more_vert </span>
                    </button>
                    <div
                      v-if="
                        editCreatedItem1 &&
                        editCreatedItemFlagId ==
                          item_list.id + '-' + item.indexShoppingList
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
                        @click="editItem(item_list)"
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
                        @click="deleteItem(item_list, index)"
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
                          delete
                        </span>
                        Delete
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </li>
          </ul>
        </div>
        <div class="flex justify-end pr-2">
          <p class="self-center text-sm text-gray-400">
            Last updated {{ timestamp(item.dateModified) }}
          </p>
        </div>
        <hr />
        <div class="flex flex-row items-center justify-between px-3 pt-2">
          <div class="space-x-3 text-gray-500">
            <span
              @click="
                (toggle_delete = !toggle_delete),
                  (shoplist = item.shoppingListNumber)
              "
              class="material-icons cursor-pointer select-none"
            >
              delete
            </span>
            <span
              @click="selectList(index)"
              class="material-icons cursor-pointer select-none"
            >
              post_add
            </span>
          </div>
          <!-- <span
            @click="saveList()"
            :id="item.title + item.id + 'close'"
            class="cursor-pointer text-blue-700 font-bold select-none"
            >Save</span
          > -->
        </div>
      </div>
    </div>
    <!---->
    <div
      v-if="toggle_delete"
      class="
        fixed
        bg-black
        z-100
        h-max
        w-screen
        bg-opacity-75
        overflow-y-auto
        items-center
        inset-0
      "
    >
      <div class="flex mt-4 w-full p-3 items-center justify-center py-20">
        <div
          class="
            bg-white
            ring-1 ring-gray-300
            p-5
            w-full
            rounded-xl
            2xl:w-97
            lg:w-97
            xl:w-97
            xl:mr-16
            md:w-8/12
            sm:w-10/12
            shadow-2xl
            h-auto
          "
        >
          <div class="flex flex-row items-center justify-between p-3">
            <p class="hidden lg:block 2xl:block xl:block"></p>
            <p class="text-lg font-extrabold xl:ml-8 lg:ml-8 2xl:ml-8">
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
          <div class="">
            <div class="flex justify-between mt-4 px-5 space-x-4 items-center">
              <button
                @click="toggle_delete = false"
                class="
                  px-4
                  bg-white
                  text-black
                  focus:outline-none
                  w-full
                  h-7
                  shadow-xl
                  ring-1 ring-gray-300
                  rounded-2xl
                "
              >
                Cancel
              </button>

              <button
                @click="(toggle_delete = false), delete_shoppinglist()"
                class="
                  px-4
                  bg-red-buttons
                  text-white
                  focus:outline-none
                  w-full
                  h-7
                  shadow-xl
                  ring-1 ring-gray-300
                  rounded-2xl
                "
              >
                Delete
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!---eND--->

    <div class="text-center">
      <p class="text-gray-500 text-sm">
        Privacy Policy-Cookies Policy-Terms and Conditions Return and Refund
        Policy-PasaBuy 2021
      </p>
    </div>
  </div>
</template>
<script>
import Nav from "../views/Navbar.vue";
// import editShopListModal from "./editShopListModal";
import moment from "moment";
import api from "../api";
import store from "../store/index";
import _ from "lodash";
export default {
  name: "shopping-list",
  components: {
    Nav,
  },
  created: function () {
    document.body.style.backgroundColor = "rgb(235,235,235)";
  },
  data() {
    return {
      editingListID: null,
      editCreatedItem1: false,
      editCreatedItemFlagId: null,
      editingProduct: null,
      editItem1: false,
      toggle_delete: false,
      hidden_list: false,
      hidden: false,
      hide_input: false,
      label_title: true,
      addtitle: false,
      addlist: false,
      new_item: false,
      editVisible: false,
      quantity: 1,
      n: 2,
      shoplist: "",
      id_num: 3,
      new_title: "",
      list_number: 0,
      new_items: [],
      shopping_list: [
        {
          id: 1,
          date: "7:00 AM",
          title: "Weekly Grocery List",

          items: [
            {
              product: "Flour",
              size: "1kg",
              brand: "Brando",
              quantity: 1,
            },
            {
              product: "Flour",
              size: "1kg",
              brand: "Brando",
              quantity: 1,
            },
            {
              product: "Flour",
              size: "1kg",
              brand: "Brando",
              quantity: 1,
            },
          ],
        },
        {
          id: 2,
          date: "7:00 AM",
          title: "Birthday Party List",

          items: [
            {
              product: "Flour",
              size: "1kg",
              brand: "Brando",
              quantity: 1,
            },
            {
              product: "Flour",
              size: "1kg",
              brand: "Brando",
              quantity: 1,
            },
            {
              product: "Flour",
              size: "1kg",
              brand: "Brando",
              quantity: 1,
            },
          ],
        },
      ],
    };
  },
  methods: {
    addNewList() {
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
      this.shopping_list.push(obj);
      api
        .post("api/createList", obj)
        .then(() => {
          store.dispatch("getUserShoppingList").then(() => {
            this.new_items = [];
            this.addlist = false;
          });
        })
        .catch((error) => {
          //if encountered error means the user will not add a new shopping list
          this.addlist = false;
          console.log(error);
        });
    },
    checkOrUncheck(index) {
      for (
        var i = 0;
        i < this.shoppingList[index].shoppingListContent.length;
        i++
      ) {
        console.log(this.shoppingList[index].shoppingListContent[i].id);
        if (
          document.getElementById(
            this.shoppingList[index].indexShoppingList +
              "-" +
              this.shoppingList[index].shoppingListContent[i].id
          ).checked
        ) {
          this.shoppingList[index].shoppingListContent[i].status = 1;
        } else {
          this.shoppingList[index].shoppingListContent[i].status = 0;
        }
      }
      this.saveList(this.shoppingList[index].shoppingListNumber, this, index);
    },
    saveList: _.debounce((listNumber, vm, index) => {
      let obj = {
        listName: document.getElementById(
          vm.shoppingList[index].shoppingListTitle
        ).value,
        list: vm.shoppingList[index].shoppingListContent,
      };
      console.log(obj);
      console.log(vm.shoppingList);

      api
        .post("api/editList/" + listNumber, obj)
        .then((res) => {
          store.dispatch("getUserShoppingList").then(() => {
            console.log("sucess", res.data);
          });
        })
        .catch((error) => {
          //if encountered error means the user will not add a new shopping list
          console.log(error);
        });
    }, 1000),
    deleteItem(item, index) {
      for (
        var i = 0;
        i < this.shoppingList[index].shoppingListContent.length;
        i++
      ) {
        if (this.shoppingList[index].shoppingListContent[i].id === item.id) {
          this.shoppingList[index].shoppingListContent.splice(i, 1);
        }
      }
      this.saveList(this.shoppingList[index].shoppingListNumber, this, index);
    },
    newDeleteItem(item) {
      for (var i = 0; i < this.new_items.length; i++) {
        if (this.new_items.id === item.id) {
          this.new_items.splice(i, 1);
        }
      }
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
    saveEditingItem(isNewItem, index) {
      var i;
      if (isNewItem) {
        for (i = 0; i < this.new_items.length; i++) {
          if (this.new_items[i].id == this.editingProduct.id) {
            this.new_items[i] = this.editingProduct;
          }
        }
      } else {
        for (
          i = 0;
          i < this.shoppingList[index].shoppingListContent.length;
          i++
        ) {
          if (
            this.shoppingList[index].shoppingListContent[i].id ==
            this.editingProduct.id
          ) {
            this.shoppingList[index].shoppingListContent[i] =
              this.editingProduct;
          }
        }
      }
      this.editItem1 = !this.editItem1;
      this.saveList(this.shoppingList[index].shoppingListNumber, this, index);
    },
    editItem(item) {
      console.log(item);
      this.editItem1 = !this.editItem1;
      this.editingProduct = JSON.parse(JSON.stringify(item));
      this.editCreatedItem1 = !this.editCreatedItem1;
    },
    productOptions(item, list) {
      this.editingListID = list.indexShoppingList;
      console.log("product");
      this.editCreatedItem1 = !this.editCreatedItem1;
      this.editCreatedItemFlagId = item.id + "-" + list.indexShoppingList;
    },
    newProductOptions(item) {
      this.editCreatedItem1 = !this.editCreatedItem1;
      this.editCreatedItemFlagId = item.id;
    },
    minusQty(q) {
      q--;
      if (q <= 0) return 1;
      return q;
    },
    addQty(q) {
      q++;
      return q;
    },
    changeQty(i) {
      this.saveList(this.shoppingList[i].shoppingListNumber, this, i);
    },
    change_close(e) {
      let str = document.getElementById(e).innerHTML;
      if (str == "Close") {
        document.getElementById(e).innerHTML = "View";
      } else {
        document.getElementById(e).innerHTML = "Close";
      }
    },
    delete_shoppinglist() {
      this.toggle_delete = false;
      api
        .delete("api/deleteList/" + this.shoplist)
        .then(() => {
          store.dispatch("getUserShoppingList");
        })
        .catch((e) => {
          console.log(e.response.data.error);
        });
    },
    update_shoppinglist(e) {
      alert(e);
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
      if (x == "") {
        alert("Empty Field");
        return false;
      } else {
        let datax = {
          id: this.list_number,
          product: x,
          brand: y,
          size: z,
          quantity: n,
          status: 1,
          statusDeliver: 0,
        };
        this.new_items.push(datax);
        this.new_item = false;
        this.list_number++;
        console.log(this.new_items);
      }
    },
    title_edit(e, m, i) {
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
      if (n.style.display === "none") {
        this.saveList(this.shoppingList[i].shoppingListNumber, this, i);
      }
      //alert(index);
    },
    updateShoppinglist() {},
    add_item_shopping_list(a, b, c, d, e, i) {
      // const index = this.shopping_list.findIndex((x) => x.title == d);
      let productx = document.getElementById(a).value;
      let brandx = document.getElementById(b).value;
      let sizex = document.getElementById(c).value;
      let quantx = document.getElementById(e).innerHTML;
      if (productx == "" || brandx == "" || sizex == "") {
        alert("Empty Field");
        return false;
      }
      let obj = {
        id: this.shoppingList[i].shoppingListContent.length + 1,
        product: productx,
        brand: brandx,
        size: sizex,
        quantity: parseInt(quantx),
        status: 1,
        statusDeliver: 0,
      };
      this.shoppingList[i].shoppingListContent.push(obj);
      document.getElementById(a).value = "";
      document.getElementById(b).value = "";
      document.getElementById(c).value = "";
      this.saveList(this.shoppingList[i].shoppingListNumber, this, i);
    },
    selectList(index) {
      // this.$router.push({path: '/dashboard/?modal='+btoa(true)+'/?p='+btoa(this.shoppingList[index].shoppingListNumber)});
      this.$router.push({
        name: 'dashboard',
        query: {
          modal: btoa(true),
          list: btoa(this.shoppingList[index].shoppingListNumber),
        },
      });
    },
  },
  computed: {
    user() {
      return store.getters.getUser;
    },

    shoppingList() {
      return store.getters.getUserShoppingList;
    },
  },
};
</script>
<style scoped>
input[type="checkbox"] {
  outline-style: none;
  appearance: none;
  -webkit-appearance: none;
  height: 16px;
  width: 16px;
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
input[type="checkbox"]:checked {
  background-color: #1c1720;
}

input[type="checkbox"]:checked::after {
  display: block;
}
</style>
