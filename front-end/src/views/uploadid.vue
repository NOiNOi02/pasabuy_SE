<template class="bg-gray-00 font-nunito">
  <loading v-if="logginIn" />
  <div class="flex items-center">
    <router-link to="/">
      <img src="/img/pasaBUYLogoOnly.png" class="w-16 h-16 block" />
    </router-link>
    <h1
      class="absolute text-xl font-black tracking-widest left-16 font-raleway text-red-buttons block"
    >
      pasaBUY
    </h1>
  </div>

  <div
    id="uploadedid"
    v-if="!logginIn"
    class="flex items-center w-full justify-center px-4 pb-10"
  >
    <div
      class="w-full my-12 overflow-hidden text-center bg-white shadow-md flex-grow-1 rounded-xl xl:w-2/5 lg:w-2/5 2xl:w-2/5 md:w-97 sm:w-97"
    >
      <div class="px-10 py-16">
        <h1 class="mb-3 space-x-1 space-y-1 text-2xl font-bold">
          Upload a valid ID
        </h1>
        <p class="mb-4 text-left sm:text-center lg:text-justify xl:text-center">
          Verifying your identity by presenting any of your valid IDs will help
          keep Pasabuy secure and fraud-free.
        </p>
        <div
          class="flex flex-col justify-between space-y-4 sm:flex-row sm:space-y-0 sm:space-x-8 md:flex-row md:space-y-0 md:space-x-8 lg:flex-row lg:space-y-0 lg:space-x-8 xl:flex-row xl:space-y-0 xl:space-x-8 2xl:flex-row 2xl:space-y-0 2xl:space-x-8"
        >
          <!--front id--->
          <div
            class="text-left text-gray-500 md:w-1/2 lg:w-1/2 xl:w-1/2 2xl:w-1/2 sm:w-1/2"
          >
            <span>Front of your ID</span>
            <div
              class="ring-2 rounded-xl ring-gray-500 px-3 flex flex-col justify-center pt-4 pb-2 h-44"
            >
              <div
                class="flex flex-col justify-center overflow-hidden items-center h-32"
              >
                <img :src="front_image" class="w-full" />
                <img
                  id="front_img"
                  :src="icon_front"
                  class="w-16 cursor-pointer"
                />
                <label for="front_id">
                  <span class="text-black">{{ browse1 }}</span>
                </label>
                <p class="text-xs w-full overflow-x-auto">
                  Note: .jpg and .png files only (maximum size 25mb)
                </p>
              </div>
              <div class="w-28 mt-">
                <p class="text-sm w-full overflow-x-auto">{{ filename }}</p>
              </div>
              <div class="space-x-3 flex flex-row justify-end self-end">
                <span
                  class="text-red-700 font-bold cursor-pointer"
                  @click="delete_front"
                  >{{ delete1 }}</span
                >
                <label for="front_id">
                  <span class="font-bold text-black cursor-pointer">{{
                    edit1
                  }}</span></label
                >
              </div>
            </div>
            <input
              type="file"
              id="front_id"
              @change="filechange"
              class="hidden"
            />

            <p class="text-center text-xs text-red-500 mt-3">
              {{ error_front_image }}
            </p>
          </div>

          <!--Back id-->
          <div
            class="text-left text-gray-500 md:w-1/2 lg:w-1/2 xl:w-1/2 2xl:w-1/2 sm:w-1/2"
          >
            <span>Back of your ID</span>
            <div
              class="ring-2 rounded-xl ring-gray-500 px-3 flex flex-col justify-center pt-4 pb-2 h-44"
            >
              <div
                class="flex flex-col justify-center overflow-hidden items-center h-32"
              >
                <img :src="back_image" class="w-full" />
                <img
                  id="front_img"
                  :src="icon_back"
                  class="w-16 cursor-pointer"
                />
                <label for="back_id">
                  <span class="text-black">{{ browse2 }}</span>
                </label>
                <p class="text-xs w-full overflow-x-auto">
                  Note: .jpg and .png files only (maximum size 25mb)
                </p>
              </div>
              <div class="w-28 mt-">
                <p class="text-sm w-full overflow-x-auto">{{ filename2 }}</p>
              </div>
              <div class="space-x-3 flex flex-row justify-end self-end">
                <span
                  class="text-red-700 font-bold cursor-pointer"
                  @click="delete_back"
                  >{{ delete2 }}</span
                >
                <label for="back_id">
                  <span class="font-bold text-black cursor-pointer">{{
                    edit2
                  }}</span></label
                >
              </div>
            </div>
            <input
              type="file"
              id="back_id"
              @change="filechange_back"
              class="hidden"
            />

            <p class="text-center text-xs text-red-500 mt-3">
              {{ error_back_image }}
            </p>
          </div>
        </div>
      </div>

      <!--Buttons-->
      <div class="flex justify-between mt-4 items-center">
        <router-link to="/address-book">
          <span class="font-bold">Back</span></router-link
        >
        <!-- <div class="flex justify-center py-5" v-if="logginIn">
                      <button class="relative w-full h-12 py-2 text-white transition-colors duration-150 bg-red-buttons px-7 rounded-3xl focus:outline-none" disabled>
                        <img src="/img/loading.gif" class="w-35 h-20 ml-14 absolute" style="margin-top:-7%;" /> <span class="ml-10"> Logging In</span>
                      </button>
                    </div> -->
        <div class="space-x-4">
          <button class="font-bold" @click="saveUser(true)">
            Skip for now
          </button>
          <button
            class="h-10 m-2 text-white transition-colors duration-150 bg-red-buttons px-7 rounded-3xl focus:outline-none"
            @click="saveUser(false)"
          >
            Next
          </button>
        </div>
      </div>
    </div>
  </div>
</template>


<style>
#journal-scroll::-webkit-scrollbar {
  width: 5px;
  cursor: pointer;
}

#journal-scroll::-webkit-scrollbar-track {
  background-color: rgba(229, 231, 235, var(--bg-opacity));
  cursor: pointer;
}

#journal-scroll::-webkit-scrollbar-thumb {
  cursor: pointer;
  background-color: rgba(185, 28, 28);
}
</style>
<script>
// import api from "../api";
import store from "../store/index";
import loading from "./loading";
import api from "../api-guest";
export default {
  components: {
    loading,
  },
  created: function () {
    document.body.style.backgroundColor = "rgb(235,235,235)";
  },
  data() {
    return {
      browse1: "Browse",
      browse2: "Browse",
      delete1: null,
      delete2: null,
      edit1: null,
      edit2: null,
      front_image: "",
      back_image: "",
      icon_front: "img/id-front.svg",
      icon_back: "img/id-back.svg",
      registrationData: new FormData(),
      filename: null,
      filename2: null,
      file_front: "",
      file_back: "",
      logginIn: false,
      errors: null,
      error_front_image: "",
      error_back_image: "",
    };
  },
  methods: {
    filechange(e) {
      const file_front = e.target.files[0];
      this.front_image = URL.createObjectURL(file_front);
      this.registrationData.append("front_image", file_front);
      this.icon_front = null;
      this.browse1 = null;
      this.filename = file_front.name;
      this.delete1 = "Delete";
      this.edit1 = "Edit";
    },
    delete_front() {
      this.front_image = null;
      this.filename = null;
      this.icon_front = "img/id-front.svg";
      this.browse1 = "Browse";
      this.delete1 = null;
      this.edit1 = null;
    },
    //back id
    filechange_back(e) {
      const file_back = e.target.files[0];
      this.back_image = URL.createObjectURL(file_back);
      this.registrationData.append("back_image", file_back);
      this.icon_back = null;
      this.browse2 = null;
      this.filename2 = file_back.name;
      this.delete2 = "Delete";
      this.edit2 = "Edit";
    },
    delete_back() {
      this.back_image = null;
      this.filename2 = null;
      this.icon_back = "img/id-back.svg";
      this.browse2 = "Browse";
      this.delete2 = null;
      this.edit2 = null;
    },
    saveUser(skip) {
      // this.show = !this.show;
      var dataform = {
        personal: JSON.parse(localStorage.getItem("personal")),
        account: JSON.parse(localStorage.getItem("account")),
        address: JSON.parse(localStorage.getItem("address")),
      };

      console.log("mail=", dataform.personal.email);
      this.registrationData.append("email", dataform.personal.email);
      this.registrationData.append("password", dataform.account.password);
      this.registrationData.append("firstName", dataform.personal.firstName);
      this.registrationData.append("lastName", dataform.personal.lastName);
      this.registrationData.append(
        "phoneNumber",
        dataform.personal.phoneNumber
      );
      this.registrationData.append("landMark", dataform.address.landMark);
      this.registrationData.append("houseNumber", dataform.address.houseNumber);
      this.registrationData.append("province", dataform.address.province);
      this.registrationData.append("barangay", dataform.address.barangay);
      this.registrationData.append(
        "cityMunicipality",
        dataform.address.cityMunicipality
      );
      // this.logginIn = !this.logginIn;
      console.log("back image ", this.front_image);
      if (skip == false) {
        if (
          this.back_image == "" ||
          this.back_image == null ||
          this.front_image == "" ||
          this.front_image == null
        ) {
          this.error_back_image = "This Field is required";
          this.error_front_image = "This Field is required";
          return;
        }
        console.log("Next", this.error_back_image);
      }
      api
        .post("/api/register", this.registrationData)
        .then((res) => {
          console.log(res.data);
          sessionStorage.setItem("Authorization", res.data.token);
          if (res) {
            this.dispatches().then(() => {
              //wait for the dispatches to finish
              localStorage.removeItem("personal");
              localStorage.removeItem("account");
              localStorage.removeItem("address");
              this.show = !this.show;
              sessionStorage.setItem("isLoggedIn", true);
              if (skip) {
                this.$router.push({ name: "accountsettings" });
              }else{
                this.$router.push({ name: "verifymessage" });

              }
            });
          } else {
            this.logginIn = !this.logginIn;
            console.log("informmation not saved");
          }
        })
        .catch((errors) => {
          if (errors.response.data.front_image == null)
            errors.response.data.front_image = "";
          if (errors.response.data.back_image == null)
            errors.response.data.back_image = "";
          this.errors =
            errors.response.data.front_image +
            " " +
            errors.response.data.back_image;
        });
    },
    async dispatches() {
      await store.dispatch("getAuthUser");
      await store.dispatch("getPersonal");
      await store.dispatch("getUserAddress");
      await store.dispatch("getPosts");
      await store.dispatch("getUnreadNotifications");
      await store.dispatch("getAllNotifications");
      await store.dispatch("getChatRoom");
      await store.dispatch("getUserTransactions");
      await store.dispatch("getUserShippingAddress");
      await store.dispatch("getTransportModes");
      await store.dispatch("getShoppingPlaces");
      await store.dispatch("getAllShares");
      await store.dispatch("getUserShoppingList");
      await store.dispatch("getVerifiedUsers");
    },
  },
};
</script>
