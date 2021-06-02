<template>
  <div
    v-on:click.self="close3"
    class="z-50 bg-black bg-opacity-25 fixed inset-0 flex justify-center items-center ssm:px-2 vs:px-2"
  >
    <div
      class="inline-flex flex-col bg-white shadow rounded-xl h-auto w-95 ssm:w-full vs:w-full"
    >
      <div class="flex flex-row w-full justify-center items-center py-3">
        <h1
          class="text-gray-900 pr-10 pl-20 ssm:pr-4 se:pr-6 se:pl-14 ssm:pl-14 ssm:text-sm leading-normal vs:text-base lvs:text-xl text-xl font-bold"
        >
          Update Order Request
        </h1>

        <button
          @click.prevent="close3"
          class="mt-2 focus:outline-none text-sm ssm:text-xs ssm:mb-2 vs:text-xs lvs:text-sm mb-1 leading-none text-indigo-900"
        >
          Close
        </button>
      </div>
      <hr />
      <div class="flex flex-col space-y-3 mt-4 mb-4">
        <div class="ml-5 flex w-full">
          <label class="inline-flex items-center">
            <input
              type="radio"
              class="form-radio w-4 h-4 vs:w-3 vs:h-3 lvs:w-4 lvs:h-4"
              name="accountType"
              id="C"
              value="Cancelled"
            />
            <span class="ml-5 text-base ssm:text-xs vs:text-sm lvs:text-base"
              >Cancel Order</span
            >
          </label>
        </div>
      </div>
      <hr />
      <div class="flex mt-4 mb-4 items-center justify-center ssm:px-2 vs:px-2">
        <button @click="updateStatus">
          <div
            class="inline-flex items-center justify-center px-4 py-2 bg-red-700 rounded-full w-88 ssm:h-8 ssm:w-full vs:w-full"
          >
            <p
              class="text-base ssm:text-sm vs:text-sm lvs:text-base font-bold leading-normal text-center text-white"
            >
              Update Status
            </p>
          </div>
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import VueSimpleAlert from "vue-simple-alert";
import api from "../api";
import store from "../store/index";
export default {
  props: ["post"],
  data() {
    return {
      isVisible: true,
    };
  },

  methods: {
    close3() {
      this.$emit("closeModal3");
    },
    updateStatus() {
      var C = document.getElementById("C").checked;

      var status = null;
      if (C) {
        status = "Cancelled";
         api
        .post("api/editPostStatus", {
          status: status,
          postNumber: this.post.postNumber,
        })
        .then((res) => {
          console.log(res.data)
          store.dispatch("getPosts").then(() => {
            store.dispatch("getUserTransactions")
            store.dispatch("getAllTransactions")
            VueSimpleAlert.alert(res.data.message, "Success", "success");
            this.$emit("getSortPosts");
            this.close3()
          });
        })
        .catch((error) => {
          VueSimpleAlert.alert(error.response.data.error, "Error", "error");
        });
      }

     
    },
  },
};
</script>