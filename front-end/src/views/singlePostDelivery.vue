<template>
<Nav/>
 
  <div class=" mt-28 flex  justify-center px-4 py-2 h-full self-center">
    <div class=" w-full space-y-2 xl:w-100 2xl:w-100 lg:w-100 bg-white rounded-lg shadow-sm px-6 py-4">
        <div class="flex justify-between">
          <div class=" flex flex-col w-full space-y-2 items-start
          xl:flex-row xl:space-y-0 xl:space-x-4
          ">
            <span class="font-bold ">Transaction #123095[Delivery]</span>
            <span class="text-green-150 ring-1 text-xs w-max px-2 py-1  rounded-md font-bold  ring-green-150 ">Completed</span>
          </div>
          <div class="w-1/2  flex justify-end">
            <span class="text-gray-500 opacity-75 font-semibold" >Update Status</span>
          </div>
        </div>
        <div>
        <span class="top-6 text-gray-500">Placed on February 11, 2021 5:05 PM</span>
       </div>
       <div class="flex  items-start gap-x-8 my-3  flex-col
            2xl:items-center 2xl:flex-row
            xl:items-center  xl:flex-row
            lg:items-center  lg:flex-row
            md:flex-row 
           ">
            <p class="uppercase font-semibold text-gray-500 ">Customer</p>
            <div class=" flex gap-x-3 items-center space-x-3">
           <img class="w-8 h-8 border rounded-full border-gray-700 shadow-md  " src="https://i.pinimg.com/564x/80/e2/f6/80e2f60c9e41907b97300c337a40fa45.jpg" /><!--Profile Pic-->
            <div class="flex flex-col">
              <div class="flex items-center space-x-2">
              <p class="font-bold">Mark Aral</p>
              <span class="material-icons text-md text-blue-800">
              verified
              </span>
              </div>
               <!--name-->
              <span class="flex gap-x-1">
              <p class="font-bold text-gray-500 text-sm">4.5</p>
              <p class="material-icons text-sm text-red-700">star</p>
              </span>
            </div>
            <!--chat button-->
             
              <!--/chat button-->
            </div>
             <button class="  flex items-center gap-x-2 focus:outline-none  bg-green-150 rounded-2xl p-2">
                <p class="material-icons text-white text-sm">chat</p>
                <p class=" font-bold text-white text-sm "> Chat Shopper</p>
              </button>
        </div>
         <div v-if="selected=='Completed'" class=" space-y-2 w-full p-4 ring-2 ring-gray-300 rounded-xl">
              <p class="text-sm select-none">Transaction marked as completed on February 26, 2021, 5:36 PM.</p>
              <span class="flex space-x-2"><p class=" text-gray-400">Would you like to review the shopper?</p><b class="cursor-pointer">Write a review.</b></span>
        </div>
        <div class="  grid grid-cols-2  px-4 py-2 gap-y-4 text-sm">
          <div class="flex items-center space-x-2"><span class="material-icons  text-red-buttons ">
          fmd_good
          </span><p>Banquerohan, Legazpi City</p>
          </div>
          <div class="flex items-center space-x-2"><span class="material-icons text-red-buttons">
          shopping_cart
          </span><p>SM City Legazpi</p></div>
          <div class="flex items-center space-x-2"><span class="material-icons text-red-buttons">
          watch_later
          </span><p>Februay 12, 2021, 2 PM</p></div>
          <div class="flex items-center space-x-2"><span class="material-icons text-red-buttons">
         payments
          </span><p>Payment first</p></div>
        </div>
        <div class="bg-gray-200  py-1 px-3 rounded-2xl">
        <div class="flex  text-sm   space-x-2">
          <p>Shopping List</p>
        <div class="flex"><p class=" text-gray-500">{{items.length}}</p>
        <p v-if="items.length>1" class="text-gray-500">items</p>
         <p v-else class="text-gray-500">item</p>
         </div>
        </div>
        <ul id="example-1" class="list-disc text-sm space-y-2 list-inside p-5">
       <li v-for="item in items" :key="item.list" class="list-disc items-center">
         <label class=" text-md" style="font-size:16px">{{ item.list }}</label> 
       </li>
        </ul>
        </div>
    </div>
  </div>
</template>

<script>
import Nav from './Navbar.vue'
import store from '../store/index'
import moment from "moment"
export default {
  created:function(){
     document.body.style.backgroundColor = "#EBEBEB";
  },
  components: {
    Nav,
  },
  data(){
    return{
      selected:'Completed',
      items:[
            {
              list:'Pork',size:'1kl',brand:'Anybrand',quantity:2
            }
          ]
    }
  },
  methods:{
        timestamp(datetime) {
      var postedDate = new Date(datetime);
      const today = moment().endOf("day");
      const yesterday = moment().add(-1, "day").endOf("day");

      if (postedDate < today) return moment(datetime).format("[Today at] h:mm a");
      if (postedDate > yesterday)   return moment(datetime).format("[Yesterday at] h:mm a");
      else return moment(datetime).format("MMM DD, YYYY [at] h:mm a");
    },
  },
  mounted(){
    console.log(this.$route.query.postNum)
  },
  computed:{
    posts(){
      return store.getters.getPosts
    }
  }
}
</script>

<style>
</style>