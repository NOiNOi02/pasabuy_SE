<template class=" font-nunito">
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

  <div id="verifyemail" class="flex items-center justify-center w-full px-6">
    <div
      class="w-full my-12 overflow-hidden bg-white shadow-md rounded-xl xl:w-100 lg:w-100 2xl:w-100 px-4 py-4 md:w-97 sm:w-97"
    >
      <div class="px-4">
        <div class="text-center mb-10">
          <h1 class="space-x-1 space-y-1 text-2xl font-bold pb-7">
            Verify your email
          </h1>
          <span class="pb-4 text-gray-500">
            Please enter the code that we have sent to {{ email }}
          </span>
          <p class="text-red-500 text-center">{{ errors }}</p>
        </div>
        <div action="#" class="space-y-3">
          <div class="">
            <input
              name=""
              v-model="textCode"
              type="text"
              required
              class="relative block w-full px-3 py-2 mb-6 text-base tracking-wide text-gray-900 bg-gray-200 border rounded-lg appearance-none h-14 focus:outline-none focus:shadow-outline-blue focus:border-red-600 focus:z-10"
              placeholder="Code"
            />
          </div>
          <span class="flex self-start ml-2"
            >Didn’t receive the code?
            <span class="font-bold cursor-pointer" @click="resend('email')"
              >Resend</span
            ></span
          >
          <div class="flex mb-2 -mx-1">
            <div
              class="w-1/2 px-1 mt-6 text-lg font-bold text-left text-grey-dark text-blue"
            >
              <router-link to="/Verification">Back</router-link>
            </div>
            <div class="flex justify-end w-1/2 px-1 mt-3">
              <button
                @click="nextPage"
                class="h-10 m-2 text-white transition-colors duration-150 bg-red-buttons px-7 rounded-3xl focus:outline-none"
              >
                NEXT
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
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
#iCheck {
  font-size: 16px;
  color: rgb(22, 22, 141);
}
#iMessage {
  font-size: 24px;
  color: rgb(22, 22, 141);
}
</style>

<script>
import api from "../api-guest"
// import simpleAlert from "vue-simple-alert"
export default {
  data() {
    return {
      email: JSON.parse(localStorage.getItem("personal")).email,
      code: localStorage.getItem("code"),
      textCode: null,
      errors: null,
    };
  },
  methods: {
    nextPage() {
      var params = { code: localStorage.getItem("code"), textCode: this.textCode };
      api
        .post("/api/confirmVerificationCode", params)
        .then((res) => {
          if (res.data) {
            localStorage.removeItem("code");
            this.$router.push({ name: "address" });
          }
        })
        .catch((errors) => {
          this.errors = errors.response.data.error;
        });
    },
    resend(choice) {
      var params = JSON.parse(localStorage.getItem("personal"));
      params.verificationChoice = choice;
      console.log(params);

      api
        .post("/api/sendCode", params)
        .then((res) => {
          console.log(res);
          if (res.data) {
            localStorage.setItem("code", res.data.code);
            if (choice === "email") {
              this.$router.push({ name: "verifyemail" });
            } else {
              this.$router.push({ name: "verifyPhone" });
            }
          }
        })
        .catch((errors) => {
          this.errors = errors.response.data.error;
        });
    },
  },

  created: function () {
    document.body.style.backgroundColor = "rgb(235,235,235)";
    if (localStorage.getItem("code") == null) {
      this.$router.push({ name: "signup" });
    }
  },
};
</script>
