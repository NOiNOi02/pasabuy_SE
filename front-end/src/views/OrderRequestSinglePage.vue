<template>
<Navbar/>
<div class="flex flex-col bg-gray-100 pt-122 font-nunito h-scrren pb-6 bg-gray-bgcolor vs:px-2 sm:px-2 ssm:px-2">

  <!--user post-->
  <div class="flex items-center justify-center pt-6">
    <div class="space-x-4 h-auto ssm:p-2 ssm:w-full p-6 vs:p-4 vs:w-full sm:w-full w-608 bg-white shadow rounded-xl">
      <div class="flex flex-col items-start justify-start">

        <!--section 1-->
        <div class="flex flex-grow flex-wrap flex-row w-full justify-between">
          <div class="inline-flex">
            <img class="w-14 h-14 vs:w-10 vs:h-10 ssm:w-10 ssm:h-10 rounded-full" src="img/yami.jpg"/>
            <div class="flex flex-col items-start w-full vs:px-1 se:px-2 ssm:px-2 px-4">
              <div class="space-x-4 ssm:space-x-0 ssm:flex-col se:flex-col se:space-x-0 vs:space-x-1 sm:space-x-2 flex flex-row mt-1">
                <p class="ssm:text-xs vs:text-xs lvs:text-sm text-base font-bold leading-none text-gray-900">{{user_info.firstname}} {{user_info.lastname}}
                  <span class="text-blue-900 align-middle material-icons md-18 vs:md-14">
                  verified
                </span>
                </p>
                <p class="ssm:text-xs vs:text-xs lvs:text-sm text-base leading-none text-gray-500">{{postStatus}} an order request</p>
              </div>
              <div class="vs:flex vs:w-full ssm:w-full ssm:flex vs:pb-2">
                <span class="text-sm ssm:text-xs vs:text-xs lvs:text-sm leading-none text-gray-500">{{datePosted}}</span>
              </div>
            </div>
          </div>
          <div id="3dotmenu" class="vs:mt-1">
            <button @click="EditModal" class="focus:outline-none">
              <img class="w-6 vs:w-4 lvs:w-5 ssm:w-4 h-auto" src="img/3dot.svg"/>
            </button>
          <div class="flex w-full">
            <div v-if="edit1" class="absolute py-2 pt-2 pl-2 pr-4 leading-loose bg-white rounded-lg shadow-xl ssm:right-5 vs:right-5 sm:right-5 lg:right-56 md:right-24 xl:right-91 h-min w-30">
             <EditOrderRequest v-if="postModalVisible2" @closeModal2="listener2"/>
                <button  @click="togglePostModal2" class="flex flex-row gap-x-2 text-base focus:outline-none">
                 <span class="font-medium text-gray-500 material-icons ">
                  mode
                  </span>
                  Edit Post
                </button>
              <UpdateOrderStatus v-if="postModalVisible3" @closeModal3="listener3"/>
                <button  @click="togglePostModal3" class="flex flex-row text-base font-normal focus:outline-none gap-x-2">
                  <span class="font-normal text-gray-500 material-icons">
                   autorenew
                  </span>
                   Update Status
                </button>
              <button class="flex flex-row gap-x-2 text-base"> 
                <span class="text-gray-500 material-icons">delete</span>Delete</button>
              </div>
              </div>
          </div>
        </div>
        <!--end-->

        <!--section 2-->
        <div class="inline-flex mt-4 items-center space-x-2 justify-start  px-2 py-1 bg-gray-100 rounded-full">
          <span class="rounded-full material-icons text-blue-600">
              check_circle_outline
              </span>
          <p class="text-sm ssm:text-xs vs:text-xs lvs:text-sm font-bold leading-none items-center text-blue-600">
              {{delivery_info.status}}</p>
        </div>
        <!--end-->

        <!--section 3-->
        <div class="flex ssm:flex-col ssm:items-start ssm:space-x-0 vs:flex-col vs:items-start items-center justify-start mt-4 w-full vs:space-x-0 space-x-2">
          <div class="flex-col items-start w-full pr-12">
            <div class="flex space-x-2">
              <span class=" w-6 h-6 rounded-full material-icons text-red-600">
              location_on  
              </span>
              <p class="text-sm ssm:text-xs vs:text-xs lvs:text-sm leading-none text-gray-900 py-1">{{delivery_info.delivery_area}}</p>
            </div>
            <div class=" flex space-x-2 py-2">
              <span class=" w-6 h-6 rounded-full material-icons text-red-600">
              alarm  
              </span>
              <p class="text-sm ssm:text-xs vs:text-xs lvs:text-sm leading-none text-gray-900 py-1">{{delivery_info.schedule}}</p>
            </div>
            
          </div>
          <div class="flex-col vs:py-1 w-full">
            <div class="flex space-x-2">
              <span class=" w-6 h-6 rounded-full material-icons text-red-600">
              shopping_cart  
              </span>
              <p class="text-sm ssm:text-xs vs:text-xs lvs:text-sm leading-none text-gray-900 py-1">{{delivery_info.shopping_place}}</p>
            </div>
            <div class="flex space-x-2 py-2">
              <span class=" w-6 h-6 rounded-full material-icons text-red-600">
              payments  
              </span>
              <p class="text-sm ssm:text-xs vs:text-xs lvs:text-sm leading-none text-gray-900 py-1">{{delivery_info.payment_method}}</p>
            </div>
          </div>
        </div>
        <!--end-->

        <!--section 4-->
        <div class="flex flex-col  ssm:mt-2 vs:mt-2 mt-3 w-full items-start justify-start h-auto vs:pr-0 vs:min-w-0 vs:px-2 ssm:pr-0 ssm:min-w-0 ssm:px-2 p-4 bg-gray-100 rounded-xl">
            <div class="inline-flex flex-row space-x-4">
                <span class="text-base ssm:text-sm leading-none text-gray-900">Shopping List</span>
                <span class="text-base ssm:text-sm leading-none text-gray-500">{{shopping_info.countItems}} items</span>
            </div>
            <div class="inline-flex flex-col ssm:px-0 w-full vs:px-0 space-y-2 py-4 px-4">    
                <li v-for="shoppingItems in computedShopItemList" :key="shoppingItems" class="text-sm leading-none text-gray-900">
                  {{shoppingItems.item}} ({{shoppingItems.amount}}) · {{shoppingItems.brand}} [{{shoppingItems.unit}}]
                </li>
            </div>
            <button @click="showMoreshowLess" v-if="!isFew" class="focus:outline-none items-start justify-start text-sm text-gray-500">{{showListStatus}}</button>
        </div>
        <!--section 4-->

        <!--section 5-->
        <div class="inline-flex  items-start ssm:px-2 justify-start mt-3 rounded-xl h-auto bg-white w-full">
            <p class="text-sm ssm:text-xs vs:text-xs lvs:text-sm leading-loose w-auto text-gray-900">{{delivery_info.comment}}</p>
        </div>
        <!--end-->

       <!--section 6-->
        <div class="flex flex-col justify-start items-start w-full space-y-2.5 mt-4">
          <hr class="w-full">
          <div class="inline-flex justify-start items-center flex-row space-x-4">
            <p class="text-base font-bold leading-none text-gray-900">Offers Received</p>
            <div class="inline-flex px-2 py-1 bg-red-700 rounded-full">
              <p class="text-base font-bold leading-none text-white">{{maxOffersReceived}}</p>
            </div>
          </div>
          <div class="flex-auto flex-col w-full px-2 vs:px-0 space-y-3.5 pb-2 pt-2">
            <div v-for="Offers in computedOffersReceived" :key="Offers" class="flex flex-row justify-between">
              <div class="flex flex-row vs:space-x-1 space-x-2 items-center">
              <img class="w-10 h-10 vs:w-8 vs:h-8 rounded-full" :src="Offers.img"/>
              <div class="flex flex-col space-y-1">
                <div class="flex flex-row vs:space-x-1 space-x-2">
                  <p class="text-base vs:text-sm ssm:text-xs font-bold leading-none text-gray-900">{{Offers.userName}}</p>
                  <span class="text-blue-900 align-middle material-icons md-14 ">
                  verified
                </span>
                </div>
                <p class="text-sm vs:text-xs ssm:text-xs leading-none text-gray-500">{{Offers.time}}</p>
              </div>
              </div>
              <div class="flex flex-row items-center vs:space-x-1 space-x-2">
                <button @click="declineDisOffer" class="focus:outline-none inline-flex items-start justify-start  vs:px-2.5 px-3.5 py-1.5 vs:py-1 border-2 rounded-full border-red-700">
                <p class="text-base vs:text-xs ssm:text-xs font-bold leading-none text-gray-900">Decline</p>
                </button>
                <button @click="acceptDisOffer" class="focus:outline-none inline-flex items-start justify-start vs:px-3 px-4 vs:py-1.5 py-2 bg-red-700 rounded-full">
                <p class="text-base vs:text-xs ssm:text-xs font-bold leading-none text-white">Accept</p>
                </button>
                <div>
                <button @click="Offers.messageUser = !Offers.messageUser" class="focus:outline-none mt-1.5">
                <span class="material-icons vs:text-xs">
                  more_vert
                </span>
                </button>
                <div class="relative w-full">
              <div v-if="Offers.messageUser" class="absolute p-2 leading-loose rounded-lg border-2 border-gray-100 bg-white right-0 w-30">
              <button class="flex flex-row items-center font-normal text-base leading-none text-gray-900 focus:outline-none gap-x-2">
               <span class=" material-icons text-base  text-gray-900 ">
                forum
               </span>
                Chat
              </button>
              </div>
              </div>
                </div>
              </div>
            </div>
          </div>
          <div class="flex flex-row w-full justify-between items-center">
              <button @click="viewMoreviewLess" v-if="!isFew2" class="focus:outline-none inline-flex text-base font-bold leading-none text-gray-500">{{viewMoreStatus}}</button>
              <p class="inline-flex text-base font-bold leading-none text-gray-500">{{limitOffersDisplay2}} of {{maxOffersReceived}}</p>
          </div>
        </div>
        <!--end-->

      </div>
    </div>
  </div>
  <!--end of user post-->
  
</div>
    
</template>

<script>
import Navbar from './Navbar'
export default {
 data(){
        return{
        datePosted: '3 hours ago',
      postStatus: 'posted',
       edit1: false,
        delivery_info:{
        delivery_area: 'Banquerohan, Legazpi City',
        shopping_place: 'Shopping at SM City Legazpi',
        schedule: 'Friday 5 PM',
        payment_method: 'Payment First',
        comment: 'Hi! If there’s anyone who can help me and sabuy my groceries, I would greatly appreciate it. Send me an offer if you’re willing. Thanks!',
        status: 'Taken',
        status1: 'Accepting Offers'
      },
       user_info:{
        firstname: 'Jane',
        lastname: 'Doe'
      },
      filter_itemList: [
        {
          item: 'flour',
          amount: '1 kg',
          brand: 'Any brand',
          unit: '2 units',
        },
        {
          item: 'flour',
          amount: '1 kg',
          brand: 'Any brand',
          unit: '2 units',
        },
        {
          item: 'flour',
          amount: '1 kg',
          brand: 'Any brand',
          unit: '2 units',
        },
        {
          item: 'flour',
          amount: '1 kg',
          brand: 'Any brand',
          unit: '2 units',
        },
        {
          item: 'flour',
          amount: '1 kg',
          brand: 'Any brand',
          unit: '2 units',
        },
        {
          item: 'flour',
          amount: '1 kg',
          brand: 'Any brand',
          unit: '2 units',
        },
        {
          item: 'flour',
          amount: '1 kg',
          brand: 'Any brand',
          unit: '2 units',
        },
        {
          item: 'flour',
          amount: '1 kg',
          brand: 'Any brand',
          unit: '2 units',
        },
        
        
        ],
        limitOffersDisplay: 3,
        limitOffersDisplay2: 3,
        defaultLimitOffersDisplay: 3,
        viewMoreStatus: "View More",
        viewLessStatus: "View Less",
        limit_by: 4,
        default_limit: 4,
        showListStatus: "See More",
        showLessStatus: "See Less",
        isActive: false,
        shopping_info:{
        countItems: '8',
        item1: 'flour (1 kg)',
        item2: 'vanilla extract (50 mL)',
        item3: 'brown sugar',
        item4: 'cocoa powder',
        item5: 'baking soda',
        item6: 'chocolate syrup',
        item7: 'powdered sugar',
        item8: 'cocoa powder',       
      },
      OffersReceived:[
        {
          userName: 'Asta Staria',
          time: '5 minutes ago',
          img: 'img/asta.jpeg',
          messageUser: false
        },
        {
          userName: 'Julius Novachrono',
          time: '5 minutes ago',
          img: 'img/julius.png',
          messageUser: false
        },
        {
          userName: 'Baha-bahaha',
          time: '5 minutes ago',
          img: 'img/baha.jpg',
          messageUser: false
        },
        {
          userName: 'Asta Staria',
          time: '5 minutes ago',
          img: 'img/asta.jpeg',
          messageUser: false
        },
      ],
    }
    },
components:{
     Navbar
 }, 
computed:{
  computedShopItemList(){
    return this.limit_by ? this.filter_itemList.slice(0,this.limit_by) : this.filter_itemList
  },
  isFew: ({ filter_itemList }) => filter_itemList.length < 5,
  computedOffersReceived(){
    return this.limitOffersDisplay ? this.OffersReceived.slice(0,this.limitOffersDisplay) : this.OffersReceived
  },
  isFew2: ({ OffersReceived }) => OffersReceived.length < 4,
  maxOffersReceived: ({ OffersReceived }) => OffersReceived.length,
 
},
methods:{
    showMoreshowLess(){
      this.limit_by = null;
     if(this.showListStatus != this.showLessStatus){
        this.showListStatus = this.showLessStatus;
      }
      else{
        this.showListStatus = "See More";
        this.limit_by = this.default_limit
      }
    },
    viewMoreviewLess(){
      this.limitOffersDisplay = null;
     if(this.viewMoreStatus != this.viewLessStatus){
        this.viewMoreStatus = this.viewLessStatus;
        this.limitOffersDisplay2 = this.maxOffersReceived
      }
      else{
        this.viewMoreStatus = "View More";
        this.limitOffersDisplay = this.defaultLimitOffersDisplay
        this.limitOffersDisplay2 = this.limitOffersDisplay
      }
    }
}
}
</script>

<style scoped>
</style>