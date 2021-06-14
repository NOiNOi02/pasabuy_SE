<template>
<div class="bg-gray-100  pt-6 font-nunito">
  <!--profile review-->
  <div class="flex h-auto ssm:items-center vs:items-center sm:items-center md:items-center ssm:flex-col ssm:h-auto sm:flex-col vs:flex-col md:flex-col md:h-auto vs:h-auto sm:h-auto pb-6 w-full justify-center  ssm:space-x-0 vs:space-x-0 sm:space-x-0 space-x-10">

    <!--Rating-->
    <div class=" flex flex-col ssm:h-auto vs:h-auto sm:h-auto md:h-auto h-auto">
      <div class="flex ">
        <div class="flex ssm:px-2 flex-col space-x-4 items-center justify-center py-6 ssm:py-2 vs:py-4 bg-white shadow rounded-xl h-auto w-74 ssm:w-full">     
          <div class="inline-flex mb-3">
            <p class="font-bold leading-10 text-gray-900 ssm:text-2xl vs:text-3xl lvs:text-4xl text-4xl">{{ratings}}</p>
          </div>
          <div class="inline-flex items-start space-x-1 justify-start px-4 py-2 ssm:py-1 vs:py-1 lvs:py-2 bg-gray-100 rounded-full">
            <span v-if="ratings>=1" class="text-yellow-500 align-middle material-icons md-24">star_rate</span>
            <span v-if="ratings== 'No Ratings'" class="align-middle material-icons md-24">star_rate</span>
            <span v-if="ratings>=2" class="text-yellow-500 align-middle material-icons md-24">star_rate</span>
            <span v-if="ratings<2 || ratings== 'No Ratings'" class="align-middle material-icons md-24">star_rate</span>
            <span v-if="ratings>=3" class="text-yellow-500 align-middle material-icons md-24">star_rate</span>
            <span v-if="ratings<3 || ratings== 'No Ratings'" class="align-middle material-icons md-24">star_rate</span>
            <span v-if="ratings>=4" class="text-yellow-500 align-middle material-icons md-24">star_rate</span>
            <span v-if="ratings<4 || ratings== 'No Ratings'" class="align-middle material-icons md-24">star_rate</span>
            <span v-if="ratings==5" class="text-yellow-500 align-middle material-icons md-24">star_rate</span>
            <span v-if="ratings!=5" class="align-middle material-icons md-24">star_rate</span>
          </div>
          <div class="flex py-3">
            <p class="text-xs leading-none text-gray-900">{{reviews.length}} Pasabuyers</p>
          </div>
          
          <div class="flex flex-col ">
            <div class="inline-flex flex-row space-x-2">
              <div>
                <p class="text-sm leading-normal text-gray-900">5 stars</p>
              </div>
              <div class="inline-flex py-2">
                  <div class="w-44 h-2  right-0 top-0 bg-gray-200 rounded-full">
                    <div class="w-0 h-2 left-0 top-0 bg-red-700 rounded-full" :style="{'width' : star5 + '%'}"></div>
              </div>
              </div>
            </div>
            <div class="inline-flex flex-row space-x-2">
              <div>
                <p class="text-sm leading-normal text-gray-900">4 stars</p>
              </div>
              <div class="inline-flex py-2">
                  <div class="w-44 h-2  right-0 top-0 bg-gray-200 rounded-full">
                    <div class="w-0 h-2 bg-red-700 rounded-full" :style="{'width' : star4 + '%'}"></div>
              </div>
              </div>
            </div>
            <div class="inline-flex flex-row space-x-2">
              <div>
                <p class="text-sm leading-normal text-gray-900">3 stars</p>
              </div>
              <div class="inline-flex py-2">
                  <div class="w-44 h-2  right-0 top-0 bg-gray-200 rounded-full">
                    <div class="w-0 h-2 left-0 top-0 bg-red-700 rounded-full" :style="{'width' : star3 + '%'}"></div>
                </div>
              </div>
            </div>
            <div class="inline-flex flex-row space-x-2">
              <div>
                <p class="text-sm leading-normal text-gray-900">2 stars</p>
              </div>
              <div class="inline-flex py-2">
                  <div class="w-44 h-2  right-0 top-0 bg-gray-200 rounded-full">
                    <div class="w-0 h-2 left-0 top-0 bg-red-700 rounded-full" :style="{'width' : star2 + '%'}"></div>
              </div>
              </div>
            </div>
            <div class="inline-flex flex-row space-x-2">
              <div>
                <p class="text-sm leading-normal text-gray-900">1 stars</p>
              </div>
              <div class="inline-flex py-2">
                  <div class="w-44 h-2  right-0 top-0 bg-gray-200 rounded-full">
                    <div class="w-0 h-2 left-0 top-0 bg-red-700 rounded-full" :style="{'width' : star1 + '%'}"></div>
              </div>
              </div>
            </div>
          </div>
      </div>
    </div>

  <!-- <div class="container">
    <div>{{ percent }}%</div>
    <div class="loading-bar">
      <div class="percentage" :style="{'width' : percentage + '%'}"></div>
    </div>
  </div> -->
  <!--end of rating code-->

  <!--idk the term buttons-->
  <div class="sm:hidden vs:hidden ssm:hidden flex flex-col pt-6 h-auto w-74 space-y-2">
    <div class="flex flex-row space-x-1 justify-start items-start">
      <button class="text-xs hover:underline leading-3 text-gray-500">Privacy Policy</button>
      <p class="text-xs leading-3 text-gray-500">•</p>
      <button class="text-xs hover:underline leading-3 text-gray-500">Cookies Policy</button>
      <p class="text-xs leading-3 text-gray-500">•</p>
      <button class="text-xs hover:underline leading-3 text-gray-500">Terms and Conditions</button>
    </div>
    <div class="flex flex-row space-x-1 justify-start items-start">
      <button class="text-xs hover:underline leading-3 text-gray-500">Return and Refund Policy</button>
      <p class="text-xs leading-3 text-gray-500">•</p>
      <button class="text-xs hover:underline leading-3 text-gray-500">Help Center</button>
    </div>
    <div class="flex flex-row">
          <button class="text-xs hover:underline leading-3 text-gray-500">PasaBuy ©️ 2021</button>
    </div>
  </div>
  <!--end-->

</div>



<!--user post comments about reviews-->
  <div class="flex flex-col ssm:mt-6 ssm:w-full ssm:h-auto vs:mt-6 sm:mt-6 sm:h-auto md:mt-6 md:h-auto h-auto vs:w-full min-w-0 px-2 sm:w-full vs:h-auto">
      <!--Modal-->
    <PostReviewModal v-if="postModalVisible" @closeReviewModal="listener"/>
    <!--end--> 
      
      
        <div class="flex pb-6">
        <div  v-if="reviews.length==0" class="inline-flex space-x-4 ssm:space-x-2 items-center vs:w-full sm:w-full ssm:w-full ssm:p-2 justify-center vs:p-4 p-6 bg-white shadow rounded-xl">
          <!-- <img class="w-14 h-14 ssm:w-10 ssm:h-10 rounded-full" src="img/asta.jpeg"/> -->
          <p class="flex items-center focus:outline-none justify-center lvs:text-sm vs:text-xs ssm:text-xs  text-base outline-none leading-none  py-5 pl-6 vs:h-12 ssm:h-10 h-14 w-99 vs:w-full ssm:w-full">
          NO REVIEWS</p>
        </div>
     <!-- </div> -->
      </div>
      

    <!--Modal-->
   <PostReviewModal v-if="postModalVisible" @closeReviewModal="listener"/>
   <!--end--> 
     <!-- <div class="flex pb-6"> -->
     <div v-if="transactions.length && user.email!=profile.email" class="flex pb-6">
    <div class="inline-flex space-x-4 ssm:space-x-2 items-center vs:w-full sm:w-full ssm:w-full ssm:p-2 justify-center vs:p-4 p-6 bg-white shadow rounded-xl">
        <img class="w-14 h-14 ssm:w-10 ssm:h-10 rounded-full" :src="user.profilePicture"/>
        <button @click="togglePostModal" class="flex items-center focus:outline-none justify-start lvs:text-sm vs:text-xs ssm:text-xs text-base outline-none leading-none text-gray-500 py-5 pl-6 bg-gray-100 rounded-full vs:h-12 ssm:h-10 h-14 w-448 vs:w-full ssm:w-full">
        Post a review for {{profile.firstName}} {{profile.lastName}}</button>
        
    </div>
  </div>

    <!--post 1-->
    <div v-for="review in reviews" v-bind:key="review.indexReview" class="flex pb-6 ssm:w-full vs:w-full sm:w-full">
      <div  class="inline-flex items-start justify-start p-6 vs:p-4 bg-white shadow rounded-xl h-auto w-608 ssm:w-full vs:w-full sm:w-full ">     
        <div class="flex flex-col ">
          <div class="flex flex-grow space-x-4 flex-wrap flex-row w-full justify-between">
            <div class="flex">
              <img class="w-14 h-14 ssm:w-10 ssm:h-10 rounded-full" :src="review.userreviewer.profilePicture"/>
              <div class="flex flex-col items-start px-4">
                <div class="space-x-8">
                  <span class="text-base ssm:text-sm vs:text-sm lvs:text-base font-bold leading-none text-gray-900">{{review.userreviewer.firstName}} {{review.userreviewer.lastName}}</span>
                  <!--check icon here-->
                </div>
                <div class="flex-row ssm:flex-col ssm:space-x-0 ssm:py-0 ssm:space-y-1 flex py-2 space-x-4">
                  <div class="inline-flex items-start space-x-1 justify-start">
                      <div class="inline-flex items-start space-x-1 justify-start">
                        <div class="inline-flex items-start space-x-1 justify-start">
                          <span v-if="review.rate>=1" class="text-yellow-500 align-middle material-icons md-18">
                          star_rate
                          </span>
                          <span v-if="review.rate>=2" class="text-yellow-500 align-middle material-icons md-18">
                          star_rate
                          </span>
                          <span v-if="review.rate>=3" class=" text-yellow-500 align-middle material-icons md-18">
                          star_rate
                          </span>
                          <span v-if="review.rate>=4" class=" text-yellow-500 align-middle material-icons md-18">
                          star_rate
                          </span>
                          <span v-if="review.rate==5" class="text-yellow-500 align-middle material-icons md-18">
                          star_rate
                          </span>
                          <!-- {{ review.rate }} -->
                        </div>
                      </div>
                      <div class="inline-flex">
                          <span class="text-sm ssm:text-xs vs:text-xs lvs:text-sm mt-0.5leading-none text-gray-500">{{timestamp(review.created_at)}}</span>
                      </div>
                    </div>
                  </div>
                   </div>
                   <div class="inline-flex">
                    <span class="text-sm ssm:text-xs vs:text-xs lvs:text-sm mt-0.5leading-none text-gray-500">{{timestamp(review.dateCreated)}}</span>
                   </div>
                </div>
            </div>
            <div v-if="review.feedback" class="flex items-start justify-start px-6 py-4  bg-gray-100 rounded-xl h-auto mt-3 w-99 ssm:w-full vs:w-full sm:w-full">
              <p class="text-sm ssm:text-xs vs:text-xs lvs:text-sm leading-normal text-gray-900">{{review.feedback}}</p>
            </div>
          </div>    
        </div>
      </div>
      <!--end-->
    </div>
    <!--end of user post comments about reviews-->
  </div>
  <!--end-->

<!--only shown in mobile view-->
<!--idk the term buttons-->
  <div class="sm:flex vs:flex ssm:flex hidden flex-col vs:justify-center vs:items-center sm:justify-center sm:items-center ssm:justify-center ssm:items-center pt-6 h-auto w-74 vs:w-full sm:w-full ssm:w-full space-y-2">
    <div class="flex flex-row space-x-1  justify-start items-start ">
      <button class="text-xs hover:underline leading-3 text-gray-500">Privacy Policy</button>
      <p class="text-xs leading-3 text-gray-500">•</p>
      <button class="text-xs hover:underline leading-3 text-gray-500">Cookies Policy</button>
      <p class="text-xs leading-3 text-gray-500">•</p>
      <button class="text-xs hover:underline leading-3 text-gray-500">Terms and Conditions</button>
    </div>
    <div class="flex flex-row space-x-1 justify-start items-start">
      <button class="text-xs hover:underline leading-3 text-gray-500">Return and Refund Policy</button>
      <p class="text-xs leading-3 text-gray-500">•</p>
      <button class="text-xs hover:underline leading-3 text-gray-500">Help Center</button>
    </div>
    <div class="flex flex-row">
          <button class="text-xs hover:underline leading-3 text-gray-500">PasaBuy ©️ 2021</button>
    </div>
  </div>
  <!--end-->
  </div>
<!--end of user post comments about reviews-->
<!--end of reviews-->
</template>

<script>
import store from "../store/index";
import PostReviewModal from "./postReviewModal";
import moment from "moment";
export default {
  data() {
    return {
      star1: 0,
      star2: 0,
      star3: 0,
      star4: 0,
      star5: 0,
      pasabuyers: "20",
      rating: 0,
      max_rate: 5,
      counters: {
        counter: 0,
        counter1S: 0,
        counter2S: 0,
        counter3S: 0,
        counter4S: 0,
        counter5S: 0,
      },
      postModalVisible: false,

      datePosted: {
        date1: "4 hours ago",
        date2: "February 16,2021",
        date3: "February 12, 2021",
      },
      comments: {
        comment1:
          "My items arrived complete and in safe condition. The delivery is also fast, got all the things I needed just before our party starts. Definitely recommended!",
      },
      users: {
        user1: "Asta Staria",
        user2: "Julius Novachrono",
        user3: "Baha-haha-haha",
      },
      //rates: this.reviews.length
    };
  },
  components: {
    PostReviewModal,
  },
  methods: {
    togglePostModal() {
      this.postModalVisible = !this.postModalVisible;
    },
    listener() {
      this.postModalVisible = false;
    },
    // rates(){
    //   return this.reviews.length
    // },
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

  },
  computed: {
    profile() {
      return store.getters.getUserInfo;
    },
    user() {
      //console.log('user',this.store.getters.getPersonal)
      return store.getters.getPersonal;
    },
    reviews() {
      //console.log('user',this.store.getters.getPersonal)
      return store.getters.getAllReviews.filter((rev) => {
        return rev.revieweeEmail == this.profile.email;
      });
    },
    ratings() {
      //console.log('user',this.store.getters.getPersonal)
      if (this.reviews == 0) return "No Ratings";
      this.reviews.filter((rev) => {
        this.rating = this.rating + rev.rate;
        this.counters.counter++;
      });
      return (this.rating / this.counters.counter).toFixed(1);
    },
    transactions() {
      // return store.getters.getUserTransactions
      return store.getters.getUserTransactions.filter((x) => {
        return (
          (x.emailCustomerShopper == this.profile.email ||
            x.transactionReceiver == this.profile.email) &&
          x.transactionStatus == "Completed"
        );
      });
    },
    rate1() {
      //console.log('user',this.store.getters.getPersonal)
      this.reviews.filter((rev) => {
        if (rev.rate == 1) this.counters.counter1S++;
      });
      return this.counters.counter1S;
    },
    rate2() {
      //console.log('user',this.store.getters.getPersonal)
      this.reviews.filter((rev) => {
        if (rev.rate == 2) this.counters.counter2S++;
      });
      return this.counters.counter2S;
    },
    rate3() {
      //console.log('user',this.store.getters.getPersonal)
      this.reviews.filter((rev) => {
        if (rev.rate == 3) this.counters.counter3S++;
      });
      return this.counters.counter3S;
    },
    rate4() {
      //console.log('user',this.store.getters.getPersonal)
      this.reviews.filter((rev) => {
        if (rev.rate == 4) this.counters.counter4S++;
      });
      return this.counters.counter4S;
    },
    rate5() {
      //console.log('user',this.store.getters.getPersonal)
      this.reviews.filter((rev) => {
        if (rev.rate == 5) this.counters.counter5S++;
      });
      return this.counters.counter5S;
    },
  },

  created() {
    // let i=1;
    this.star1 = ((this.rate1 / this.reviews.length) * 100).toFixed();
    this.star2 = ((this.rate2 / this.reviews.length) * 100).toFixed();
    this.star3 = ((this.rate3 / this.reviews.length) * 100).toFixed();
    this.star4 = ((this.rate4 / this.reviews.length) * 100).toFixed();
    this.star5 = ((this.rate5 / this.reviews.length) * 100).toFixed();
    //this.percentage = (this.rate1) * 10;
    //this.percentage = (this.rate1 + this.rate5) * 10;
    // let twoStar = 0;
    // let threeStar = 0;
    // let fourStar = 0;
    // let fiveStar = 0;
    //let percentage = 0;
  },
};
</script>

<style>
</style>