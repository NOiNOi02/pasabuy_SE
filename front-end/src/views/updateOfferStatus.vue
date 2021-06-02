<template>
        <div v-on:click.self="close2" class="z-50 bg-black bg-opacity-25 fixed inset-0 flex justify-center items-center ssm:px-2 vs:px-2">
      <div class="inline-flex flex-col bg-white shadow rounded-xl h-auto w-95 ssm:w-full vs:w-full" >
      <div class="flex flex-row w-full justify-center items-center py-3">
       <h1 class="text-gray-900 pr-10 se:pr-6 se:pl-14 ssm:pr-4 ssm:pl-14 pl-20 leading-normal ssm:text-sm vs:text-base lvs:text-xl text-xl font-bold">
         Update Shopping Offer
       </h1>
       <button @click.prevent="close2" class=" mt-2 focus:outline-none text-sm ssm:text-xs vs:text-xs lvs:text-sm mb-1 ssm:mb-2 leading-none text-indigo-900">
         Close
         </button>
      </div>
      <hr>
      <div class="flex flex-col space-y-3 mt-4 mb-4">
        <input v-model="shop_info.offer_post.indexShoppingOfferPost" type="hidden" name="indexShoppingOfferPost">
        <input v-model="shop_info.offer_post.postNumber" type="hidden" name="postNumber">
        <input v-model="shop_info.offer_post.deliveryArea" type="hidden" name="deliveryArea">
        <input v-model="shop_info.offer_post.shoppingPlace" type="hidden" name="shoppingPlace">
        <input v-model="shop_info.offer_post.deliverySchedule" type="hidden" name="deliverySchedule">
        <input v-model="shop_info.offer_post.transportMode" type="hidden" name="transportMode">
        <input v-model="shop_info.offer_post.capacity" type="hidden" name="capacity">
        <input v-model="shop_info.offer_post.paymentMethod" type="hidden" name="paymentMethod">
        <input v-model="shop_info.offer_post.caption" type="hidden" name="caption">
        <div class="ml-5 flex w-full" >
          <label class="inline-flex items-center">
            <input type="radio" name="offer" class="form-radio w-4 h-4 vs:w-3 vs:h-3 lvs:w-4 lvs:h-4" id="NLAR">
            <span class="ml-5 text-base ssm:text-xs vs:text-sm lvs:text-base">No Longer Accepting Requests</span>
          </label>
        </div>
        <div class="ml-5 flex w-full">
          <label class="inline-flex items-center">
            <input type="radio"  name="offer"  class="form-radio w-4 h-4 vs:w-3 vs:h-3 lvs:w-4 lvs:h-4" id="C">
            <span class="ml-5 text-base ssm:text-xs vs:text-sm lvs:text-base">Cancel Offer</span>
          </label>
        </div>
      </div>
      <hr>
      <div class="flex mt-4 mb-4 items-center justify-center ssm:px-2 vs:px-2">
        <button @click="updateStatus">
        <div class="inline-flex items-center justify-center px-4 py-2 bg-red-700 rounded-full ssm:h-8 h-10 w-88 ssm:w-full vs:w-full">
          <button @click="submit" class="inline-flex items-center justify-center focus:outline-none px-4 py-2 bg-red-700 rounded-full w-31.75 ssm:w-full ssm:h-8 vs:w-full h-10">
            <p class="text-base ssm:text-sm vs:text-sm font-bold leading-normal text-center text-white">Update Status</p>
          </button>
      </div>
        </button>
      </div>
       </div>
     </div>
</template>

<script>
import VueSimpleAlert from "vue-simple-alert";
import store from "../store/index";
import api from "../api"
export default {
  props:['post'],
    data(){
        return {
        isVisible: true,
        shop_info: this.post,
        }
    },
    
    methods: {
        close2(){
            this.$emit('closeModal2')
        },
         updateStatus() {
 
      var NLAR = document.getElementById("NLAR").checked;
      var C = document.getElementById("C").checked;

      var status = null;
     if (NLAR) {
        status = "No Longer Accepting Requests";
      } else if (C) {
        status = "Cancelled";
      }

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
            this.close2()
          });
        }).catch(error=>{
          VueSimpleAlert.alert(error.response.data.error, "Error", "error")
        })
    },
    }
}
</script>