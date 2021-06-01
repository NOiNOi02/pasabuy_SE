<template>
  <Nav />
  <div
    class="bg-white hidden w-full h-10 mt-24 mb-3 xl:flex justify-center lg:flex 2xl:flex"
  >
    <div
      class="w-608 mr-10 2xl:block lg:block xl:block justify-center self-center gap-y-5 hidden"
    >
      <p class="text-2xl font-nunito font-bold uppercase">Account Settings</p>
    </div>
  </div>
  <div
    class="flex justify-center self-center font-nunito mb-11 mt-24 2xl:mt-4 xl:mt-4 lg:mt-4 w-full"
  >
    <div
      class="w-full px-3 flex flex-col justify-center self-center gap-y-5 space-y-4 2xl:w-608 2xl:mr-16 lg:w-608 lg:mr-16 xl:w-608 xl:mr-16 md:w-8/12 sm:w-10/12"
    >
      <Personal />
      <Address />
      <InfoAccount />
      <Education />
      <div class="ring-1 ring-gray-300 bg-white p-5 rounded-2xl shadow-sm">
        <div class="flex justify-between">
          <div class="flex gap-4">
            <p class="font-bold font-nunito text-sm">Verification Status</p>
          </div>
        </div>
        <div class="text-sm gap-x-10 space-y-8 pt-8">
          <span class="font-raleways grid grid-cols-1" style="font-size: 16px">
            <p v-if="status == 'verified'" class="select-none text-gray-500">
            
                {{verifyMsg}}

            </p>
            <p
              v-else-if="status == 'pending'"
              class="select-none text-gray-500"
            >

                {{verifyMsg}}

            </p>
            <span v-else class="text-gray-500 space-y-2">
              <p class="text-red-700 select-none">
                {{verifyMsg}}
               
              </p>
              <p
                @click="verify_id = !verify_id"
                class="font-bold select-none cursor-pointer text-blue-900"
              >
                Verify now
              </p>
            </span>
          </span>
        </div>



        <!--Verify--->
        <div
          v-if="verify_id"
          class="fixed bg-black z-100 h-max w-screen bg-opacity-75 overflow-y-auto items-center inset-0"
        >
          <div class="flex mt-4 justify-center py-20 px-3">
            <div
              class="w-full m-0 overflow-hidden text-center bg-white shadow-md flex-grow-1 rounded-xl xl:w-608 lg:w-608 2xl:w-608 md:w-97 sm:w-97"
            >
              <div class="px-10 py-5">
                <h1 class="mb-3 space-x-1 space-y-1 text-2xl font-bold">
                  Upload a valid ID
                </h1>
                <p
                  class="mb-4 text-left sm:text-center lg:text-justify xl:text-center"
                >
                  A government ID helps us check you're really you. It also
                  helps us keep Pasabuy secure, fight fraud, and more.
                </p>
                <p class="text-red-600 text-center">{{errors}}</p>
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
                          class="w-16 cursor-not-allowed"
                        />
                        <label for="front_id">
                          <span class="font-bold cursor-pointer text-black">{{
                            browse1
                          }}</span>
                        </label>
                      </div>
                      <div class="w-28 mt-">
                        <p class="text-sm w-full overflow-x-auto">
                          {{ filename }}
                        </p>
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
                          class="w-16 cursor-not-allowed"
                        />
                        <label for="back_id">
                          <span class="font-bold cursor-pointer text-black">{{
                            browse2
                          }}</span>
                        </label>
                      </div>
                      <div class="w-28 mt-">
                        <p class="text-sm w-full overflow-x-auto">
                          {{ filename2 }}
                        </p>
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
                  </div>
                </div>

                <!--Buttons-->
                <div class="flex justify-end mt-4 items-center">
                  <div class="space-x-4">
                    <button
                      @click="verify_id = false"
                      class="h-10 m-2 text-black font-bold items-center transition-colors border-2 border-red-buttons px-5 rounded-3xl focus:outline-none"
                    >
                      Cancel
                    </button>
                    <button
                      id="confirm_next"
                      @click="
                        submitID()
                      "
                      class="h-10 m-2 text-white transition-colors bg-red-buttons px-7 font-bold rounded-3xl focus:outline-none"
                    >
                      Next
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!--End Verify-->
        <!--verify-message-->
        <div
          v-if="verify_message"
          class="fixed bg-black z-100 h-max w-screen bg-opacity-75 overflow-y-auto items-center inset-0"
        >
          <div class="flex mt-4 justify-center py-20 px-3">
            <div
              class="w-full m-0 overflow-hidden text-center bg-white shadow-md flex-grow-1 rounded-xl xl:w-608 lg:w-608 2xl:w-608 md:w-97 sm:w-97"
            >
              <div class="px-10 py-16">
                <img
                  class="w-1/4 mx-auto mb-5 2xl:mx-auto"
                  src="img/id-review.svg"
                />
                <h2
                  class="items-center justify-center mb-5 text-2xl font-bold md:flex font-raleways"
                >
                  We're still reviewing your ID
                </h2>
                <p
                  class="text-left vs:text-center lg:text-justify xl:text-center"
                >
                  This will get wrapped up as soon as possible. We'll be in
                  touch if there's anything we need.
                </p>
                <p class="pt-2 mb-4 text-center">
                  In the meantime, you can continue setting up your profile
                </p>
                <div class="justify-end flex">
                  <button
                    @click="(status = 'pending'), (verify_message = false)"
                    class="h-10 m-2 text-white transition-colors duration-150 bg-red-buttons px-7 rounded-3xl focus:outline-none"
                  >
                    Confirm
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!--end verify-message-->
      </div>

      <p class="text-gray-500 text-sm">
        Privacy Policy-Cookies Policy-Terms and Conditions Return and Refund
        Policy-PasaBuy 2021
      </p>
    </div>
  </div>
</template>
<style>
body.account {
  background: white;
}
body.home {
  background-color: white;
}
.red {
  color: red;
}
</style>

<script>
import Nav from "../views/Navbar.vue";
import Personal from "../views/personal_info.vue";
import Address from "../views/address_info.vue";
import InfoAccount from "../views/account_info.vue";
import Education from "./education";
import api from "../api";
import store from "../store/index";
export default {
  name: "Account",
  components: {
    Nav,
    Personal,
    Address,
    InfoAccount,
    Education,
  },
  created: function () {
    document.body.style.backgroundColor = "white";
  },

  data() {
    return {
      verification_status: {
        msg: "",
        unverified: true,
      },
      verify_message: false,
      verify_id: false,
      browse1: "Browse",
      browse2: "Browse",
      delete1: null,
      delete2: null,
      edit1: null,
      edit2: null,
      front_image: null,
      back_image: null,
      icon_front: "img/id-front.svg",
      icon_back: "img/id-back.svg",
      filename: null,
      filename2: null,
      status: "notVerfied",
      verifyMsg:null,
      ID:new FormData(),
      errors:null

    };
  },
  methods: {
    submitID(){
      // console.log(this.ID)
        api.post('api/postIDAccSet',this.ID).then((res)=>{
          console.log('data res ',res.data)
          store.dispatch('getVerifiedUsers').then(()=>{
            this.verify_message = !this.verify_message
            this.verify_id = false
          })
        }) .catch((errors) => {
          this.show = !this.show;
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
    submit: function () {},
    Edit: function (pars) {
      let x = document.getElementById(pars).innerHTML;
      if (x == "Edit") {
        document.getElementById(pars).innerHTML = "Save";
      } else {
        document.getElementById(pars).innerHTML = "Edit";
        this.submit();
      }
    },
    filechange(e) {
      const file = e.target.files[0];
      this.front_image = URL.createObjectURL(file);
      this.ID.append('front_image', file)
      this.icon_front = null;
      this.browse1 = null;
      this.filename = file.name;
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
      const file = e.target.files[0];
      this.back_image = URL.createObjectURL(file);
      this.ID.append('back_image', file)
      this.icon_back = null;
      this.browse2 = null;
      this.filename2 = file.name;
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
  },
  mounted() {
    var temp = this.verifiedUsers.filter((x)=>{return x.email === this.authUser.email})
console.log(temp,'temp')
    if(temp.length <=0){
      this.verifyMsg = "Your account is not verified yet. Verify now to enjoy all the features of PasaBuy."
      this.status = "unverified"
      // console.log('a')
    }else if(temp[0].verifyStatus==="verified"){
      this.verifyMsg = "  Your Account is fully verified."
      this.status = "verified"
      // console.log('b')

    }else{
      this.verifyMsg = "Account verification will get wrapped up as soon as possible. Please wait 2 to 5 business days. We’ll be in touch if there’s anything else we need."
      this.status = "pending"
      // console.log('c')

    }


    //get the user information from the laravel API
    // api
    //   .get('/api/getValidID')
    //   .then((res) => {
    //     console.log('asd',res.data);
    //     if(res.data.verifyStatus != null){
    //       if (!res.data.verifyStatus.localeCompare("unverified")) {
    //         this.verification_status.msg = "Your account is not fully verified.";
    //         this.unverified = true;
    //       } else {
    //         this.verification_status.msg = "Your account is fully verified.";
    //         this.unverified = false;
    //       }
    //     }else{
    //       this.verification_status.msg = "Your account is not fully verified.";
    //       this.unverified = true;
    //     }
    //     //this.user = res.data;
    //   })
    //   .catch((error) => {
    //     console.log(error)
    //   });
  },
  computed: {
    verifiedUsers() {
      return store.getters.getVerifiedUsers;
    },
    authUser(){
      return store.getters.getUser
    }
  },
};
</script>
<style>
body.account {
  background: white;
}
body.home {
  background-color: white;
}
.red {
  color: red;
}
</style>
}
