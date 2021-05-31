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
 

  <div id="verifyemail" class="flex items-center justify-center w-full px-4">
    <div
      class="w-full my-12 overflow-hidden text-center bg-white shadow-md rounded-xl xl:w-2/5 lg:w-2/5 2xl:w-2/5 md:w-97 sm:w-97"
    >
      <div class="px-12 py-16">
        <h1 class="space-x-1 space-y-1 text-2xl font-bold pb-7">
          Verification Required
        </h1>
        <p class="pb-10 text-gray-500">
          Pasabuy wants to make sure if it is really you. Choose a way to verify
          yourself.
        </p>
        <div class="space-y-6">
          <div
            class="ring-1 ring-gray-300 px-2 overflow-auto py-3 space-y-2 rounded-lg xl:flex xl:px-6 lg:flex lg:px-6 2xl:flex 2xl:px-6 items-center justify-between"
          >
            <div class="flex flex-col items-start">
              <span class="font-bold">By email</span>
              <span class="text-gray-500">{{ email }}</span>
            </div>
            <button
              @click="nextPage('email')"
              class="flex justify-center items-center bg-red-buttons w-max px-4 py-2 h-8 text-white font-bold rounded-full focus:outline-none text-sm"
            >
              <a> Verify Now</a>
            </button>
          </div>
          <div
            class="ring-1 ring-gray-300 px-2 overflow-auto py-3 space-y-2 rounded-lg xl:flex xl:px-6 lg:flex lg:px-6 2xl:flex 2xl:px-6 items-center justify-between"
          >
            <div class="flex flex-col items-start">
              <span class="font-bold">By phone number</span>
              <span class="text-gray-500">{{ phoneNumber }}</span>
            </div>
            <button
              @click="nextPage('phone')"
              class="flex justify-center items-center bg-red-buttons w-max px-4 py-2 h-8 text-white font-bold rounded-full focus:outline-none text-sm"
            >
              <a> Verify Now</a>
            </button>
          </div>
          <br>
          <router-link to="/sign-up">
            <span class="left-auto self-start flex font-bold"
              >Back</span
            ></router-link
          >
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
export default {
  data() {
    return {
      email: JSON.parse(localStorage.getItem("personal")).email,
      phoneNumber: JSON.parse(localStorage.getItem("personal")).phoneNumber,
    };
  },
  methods: {
    nextPage(choice) {
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
              this.$router.push({ name: "VerifyPhone" });
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
  },
};
</script>\