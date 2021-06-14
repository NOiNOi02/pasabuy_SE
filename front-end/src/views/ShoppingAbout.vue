<template>
  <!--About-->
  <div class="bg-gray-100 font-nunito w-full">
  <div class="flex  h-auto w-full vs:px-1 sm:px-6 pb-6  ssm:flex-col vs:flex-col sm:flex-col md:flex-col justify-center vs:items-center sm:items-center ssm:items-center ssm:space-x-0 vs:space-x-0 sm:space-x-0 space-x-10">

  <!--Section 2-->
    <div class="flex flex-col ssm:w-full ssm:px-2 ssm:h-auto md:h-auto vs:h-auto sm:h-auto">

    <!--section 2.1-->
    <div class="flex py-6">
      <div class="flex flex-col py-8 space-x-4 items-center justify-center p-6 bg-white shadow rounded-xl h-auto w-74">  
        <div class="flex flex-row space-x-4 ssm:space-x-2">
          <div class="inline-flex flex-col " >
            <div class="inline-flex space-x-1 items-center justify-center">
              <span v-if="ratings=='No Ratings'" class="text-2xl ssm:text-xl vs:text-xl lvs:text-2xl font-bold leading-normal text-gray-900">0</span>
              <span v-if="ratings!='No Ratings'" class="text-2xl ssm:text-xl vs:text-xl lvs:text-2xl font-bold leading-normal text-gray-900">{{ratings}}</span>
               <span class="text-yellow-500 align-middle material-icons md-24">
                  star_rate
                </span>
          </div>
            <div class="inline-flex">
              <span class="text-xs pl-1 font-semibold tracking-wide ssm:tracking-normal vs:tracking-normal lvs:tracking-wide leading-none text-gray-500 uppercase">Rating</span>
            </div>
          </div>

          <div class="inline-flex flex-col" >
            <div class="inline-flex space-x-1 items-center justify-center">
              <p class="text-2xl ssm:text-xl vs:text-xl lvs:text-2xl font-bold leading-normal text-gray-900">{{deliveries}}</p>
              <span class="text-red-600 align-middle material-icons md-24">
                  delivery_dining
                </span>
          </div>
            <div class="inline-flex ">
              <span class="text-xs ssm:tracking-normal vs:tracking-normal lvs:tracking-wide font-semibold tracking-wide leading-none text-gray-500 uppercase">Deliveries</span>
            </div>
          </div>
          <div class="inline-flex flex-col" >
            <div class="inline-flex space-x-1 items-center justify-center">
              <p class="text-2xl ssm:text-xl vs:text-xl lvs:text-2xl font-bold leading-normal text-gray-900">{{orders}}</p>
              <span class="text-red-600 align-middle material-icons md-24">
                  shopping_bag
                </span>
            </div>
            <div class="inline-flex">
              <p class="text-xs ssm:tracking-normal vs:tracking-normal lvs:tracking-wide pl-1 font-semibold tracking-wide leading-none text-gray-500 uppercase">Orders</p>
            </div>
          </div>
        </div> 
    </div>
  </div>
  <!--end-->

  <!--section 2.2-->
  <div class="flex">
    <div class="flex flex-col space-x-4 items-center justify-center p-6 bg-white shadow rounded-xl h-auto w-74 ssm:w-full">     
      <div class="flex-col">
        <div class="flex flex-col">
          <div class="inline-flex justify-between">
            <p class="text-base ssm:text-sm vs:text-sm lvs:text-base font-bold tracking-wide leading-none text-center text-gray-900 capitalize">Education</p>
            <button v-if="userPersonal.email == account_infos.email" @click="$router.push('/account-settings')" class="text-sm ssm:text-xs vs:text-xs lvs:text-sm font-bold leading-none text-center text-indigo-900">Edit</button>
          </div>
          <div class="flex flex-col py-4">
          <div v-for="userEduc in userEducs"
            :key="userEduc" class="inline-flex space-x-2">
            <img  class="w-6 h-6 rounded-full" src="img/graduation_cap.svg"/>
            <p v-if="userEduc.schoolStatus === 'Current'" class="text-sm  ssm:text-xs vs:text-xs lvs:text-sm leading-normal text-gray-900 py-1">Studied at <span class="ssm:text-xs vs:text-xs lvs:text-sm font-bold">{{ userEduc.schoolName }}</span> </p>
            <p v-if="userEduc.schoolStatus === 'Previous'" class="text-sm  ssm:text-xs vs:text-xs lvs:text-sm leading-normal text-gray-900 py-1">Went to <span class="ssm:text-xs vs:text-xs lvs:text-sm font-bold">{{ userEduc.schoolName }}</span> </p>
          </div>
          </div>
          <div class="py-3">
            <hr class="border-gray-200 w-full" style=" height: 1px;">
          </div>
        </div>

        <div class="flex flex-col">
          <div class="inline-flex justify-between">
            <p class="text-base ssm:text-sm vs:text-sm lvs:text-base font-bold tracking-wide leading-none text-center text-gray-900 capitalize">Places Lived</p>
            <button v-if="userPersonal.email == account_infos.email" @click="$router.push('/account-settings')" class="text-sm ssm:text-xs vs:text-xs lvs:text-sm font-bold leading-none text-center text-indigo-900">Edit</button>
          </div>
          <div class="inline-flex space-x-2 py-4">
           <span class="rounded-full material-icons text-gray-500">
              location_on
              </span>
            <p class="text-sm ssm:text-xs vs:text-xs lvs:text-sm leading-normal text-gray-900 py-1">From <span class="ssm:text-xs vs:text-xs lvs:text-sm font-bold">{{accountaddress.barangay}}, {{accountaddress.cityMunicipality}}</span></p>
          </div>
          <!-- <div class="inline-flex space-x-2">
            <span class="rounded-full material-icons text-gray-500">
              location_on
              </span>
            <p class="text-sm ssm:text-xs vs:text-xs lvs:text-sm leading-normal text-gray-900 py-1">Lives in <span class="ssm:text-xs vs:text-xs lvs:text-sm font-bold">{{accountaddress.barangay}}, {{accountaddress.cityMunicipality}}</span></p>
          </div> -->
        </div>
      </div> 
    </div>
  </div>
  <!--end-->

  <!--section 2.3-->
  <div class="flex py-6">
   <div class="flex flex-col space-x-4 items-center justify-center p-6 bg-white shadow rounded-xl h-auto w-74 ssm:w-full">     
    <div class="flex-col">
      <div class="flex flex-col">
        <div class="inline-flex justify-between">
          <p class="text-base ssm:text-sm vs:text-sm lvs:text-base font-bold tracking-wide leading-none text-center text-gray-900 capitalize">Basic Info</p>
          <button v-if="userPersonal.email == account_infos.email" @click="$router.push('/account-settings')" class="text-sm ssm:text-xs vs:text-xs lvs:text-sm font-bold leading-none text-center text-indigo-900">Edit</button>
        </div>
        <div class="flex flex-row space-x-4 py-4">
          <div class="flex flex-col space-y-1.5">
            <div class="inline-flex space-x-2 items-start justify-start">
            <span class="rounded-full material-icons text-gray-500 md-18">
              work
              </span>
            <p class="text-xs font-bold py-0.5 tracking-wide ssm:tracking-normal vs:tracking-normal lvs:tracking-wide leading-none text-gray-500 uppercase">Work</p>
          </div>
          <div class="inline-flex space-x-2 items-start justify-start">
            <span class="rounded-full material-icons text-gray-500 md-18">
              account_circle
              </span>
            <p class="text-xs font-bold py-0.5 tracking-wide ssm:tracking-normal vs:tracking-normal lvs:tracking-wide leading-none text-gray-500 uppercase">Gender</p>
          </div>
          <div class="inline-flex space-x-2 items-start justify-start">
            <span class="rounded-full material-icons text-gray-500 md-18">
              cake
              </span>
            <p class="text-xs font-bold py-0.5 tracking-wide ssm:tracking-normal vs:tracking-normal lvs:tracking-wide leading-none text-gray-500 mt-0.5 uppercase">Birthday</p>
          </div>
          <div class="inline-flex space-x-2 items-start justify-start">
            <span class="rounded-full material-icons text-gray-500 md-18">
              language
              </span>
            <p class="text-xs font-bold py-0.5 tracking-wide ssm:tracking-normal vs:tracking-normal lvs:tracking-wide leading-none text-gray-500 uppercase">Languages</p>
          </div>
          </div>
          <div class="flex flex-col space-y-2.5 ssm:space-y-1 ">
            <div class="inline-flex">
              <p class="text-sm ssm:text-xs vs:text-xs lvs:text-sm leading-none text-gray-900">{{account_infos.work}}</p>
            </div>
            <div class="inline-flex">
              <p class="text-sm ssm:text-xs vs:text-xs lvs:text-sm leading-none text-gray-900">{{account_infos.gender}}</p>
            </div>
            <div class="inline-flex">
              <p class="text-sm ssm:text-xs vs:text-xs lvs:text-sm leading-none text-gray-900">{{timestamp(account_infos.birthDate)}}</p>
            </div>
            <div class="inline-flex">
              <p class="text-sm ssm:text-xs vs:text-xs lvs:text-sm leading-none text-gray-900">{{account_infos.language}}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>
  <!--end-->

  <!--idk the term buttons-->
  <div class="sm:hidden vs:hidden ssm:hidden flex flex-col pb-6 h-auto w-74 space-y-2">
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
<!--section 2 end-->

<!--Section 1-->
   <!-- <div class="flex flex-col space-x-4 items-center justify-center p-6 bg-white shadow rounded-xl h-auto w-74 ssm:w-full">      -->

<div class="flex flex-col ssm:px-2 h-auto ssm:h-auto sm:h-auto vs:h-auto ssm:w-full vs:w-full sm:w-full">
<div class="flex py-6 sm:py-0 ssm:py-0 ssm:pb-6 sm:pb-6 vs:py-0 vs:pb-6">
  <div class="inline-flex space-x-4 items-start justify-start p-6 bg-white shadow rounded-xl h-auto w-608 ssm:w-full vs:w-74 sm:w-74 ssm:ml-6 vs:ml-6 sm:ml-6">     
    <div class="flex flex-col w-full">

      <!--Skills section-->
      <div class="flex flex-col py-6">
        <div class="h-10 inline-flex items-start justify-between">
          <p class="text-base ssm:text-sm vs:text-sm lvs:text-base font-bold tracking-wide leading-none text-center text-gray-900 capitalize">Skills</p>
           <button v-if="userPersonal.email == account_infos.email" @click="toggleSkillsModal" class="text-sm focus:outline-none ssm:text-xs vs:text-xs lvs:text-sm font-bold leading-none text-center text-indigo-900">Edit</button>
          <!--Modal-->
          <EditSkillsModal v-if="postModalVisible" @closeEditSkillsModal="listener"/>
          <!--end-->
        </div>
        <div v-for="userAbout in userAbouts" v-bind:key="userAbout.indexUserAbout " class="flex-1 space-y-6 flex-row justify-start item-start space-x-4">
            <div v-if="userAbout.skills!=null" class="overflow-y-auto space-y-4">
              <div v-for="skill in (userAbout.skills.split(','))" v-bind:key="skill.skills " class="ml-4 inline-flex space-x-4 items-center justify-start px-4 py-1 bg-gray-100 rounded-full mr-3">
                <p class="text-sm ssm:text-xs vs:text-xs lvs:text-sm leading-loose text-center text-gray-900">{{skill}}</p>
              </div>
            </div>
        </div>
      </div>
      <hr class="border-gray-200 h-2 w-full">
      <!--end-->

      <!--Interest section-->
      <div class="flex flex-col py-6">
        <div class="h-10 inline-flex items-start justify-between">
          <p class="text-base ssm:text-sm vs:text-sm lvs:text-base font-bold tracking-wide leading-none text-center text-gray-900 capitalize">Interest</p>
          <button v-if="userPersonal.email == account_infos.email" @click="toggleInterestModal1" class="text-sm focus:outline-none ssm:text-xs vs:text-xs lvs:text-sm font-bold leading-none text-center text-indigo-900">Edit</button>
          <!--Modal-->
          <EditInterestModal v-if="postModalVisible1" @closeEditInterestModal="listener1"/>
          <!--end-->
        </div>
        <div v-for="userAbout in userAbouts" v-bind:key="userAbout.indexUserAbout " class="flex-1 space-y-6 flex-row justify-start item-start space-x-4">
            <div v-if="userAbout.interests!=null" class="overflow-y-auto space-y-4">
              <div v-for="interest in (userAbout.interests.split(','))" v-bind:key="interest.interests " class="ml-4 inline-flex space-x-4 items-center justify-start px-4 py-1 bg-gray-100 rounded-full mr-3">
                <p class="text-sm ssm:text-xs vs:text-xs lvs:text-sm leading-loose text-center text-gray-900">{{interest}}</p>
              </div>
            </div>
        </div>
      </div>
      <hr class="border-gray-200 h-2 w-full">
      <!--end-->
    
      <!--Visited place section-->
      <div class="flex flex-col py-6">
        <div class="h-10 inline-flex items-start justify-between">
          <p class="text-base ssm:text-sm vs:text-sm lvs:text-base font-bold tracking-wide leading-none text-center text-gray-900 capitalize">Visited Place</p>
          <button v-if="userPersonal.email == account_infos.email" @click="toggleVisitedPlaceModal2" class="text-sm focus:outline-none ssm:text-xs vs:text-xs lvs:text-sm font-bold leading-none text-center text-indigo-900">Edit</button>
          <!--Modal-->
          <EditVisitedPlaceModal v-if="postModalVisible2" @closeEditVisitedPlaceModal="listener2"/>
          <!--end-->
        </div>
        <div v-for="userAbout in userAbouts" v-bind:key="userAbout.indexUserAbout " class="flex-1 space-y-6 flex-row justify-start item-start space-x-4">
            <div v-if="userAbout.visitedPlace!=null" class="overflow-y-auto space-y-4">
              <div v-for="visitedPlaces in (userAbout.visitedPlace.split(','))" v-bind:key="visitedPlaces.visitedPlace " class="ml-4 inline-flex space-x-4 items-center justify-start px-4 py-1 bg-gray-100 rounded-full mr-3">
                <p class="text-sm ssm:text-xs vs:text-xs lvs:text-sm leading-loose text-center text-gray-900">{{visitedPlaces}}</p>
              </div>
            </div>
        </div>
        <div v-for="userTransaction in userTransactions" v-bind:key="userTransaction.indexTransactionPost  " class="overflow-y-auto space-y-4">
              
                <p class="text-sm ssm:text-xs vs:text-xs lvs:text-sm leading-loose text-center text-gray-900">{{userTransaction}}</p>
              
            </div>
      </div>
      <!--end-->
      </div>
    </div>    
</div>

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
<!--Section 1 end-->
</div>
</div>
<!--About end-->
<component :is="component" :userID="userID"/>
</template>

<script>
import EditSkillsModal from './profileEditSkillsModal'
import EditInterestModal from './profileEditInterestModal'
import EditVisitedPlaceModal from './profileEditVisitedPlaceModal'
import store from "../store/index"
import moment from 'moment'
// import api from '../api'
export default {
  data(){
    return{
      // rating: '4.9',
      deliveries: 0,
      orders: 0,
      postModalVisible: false,
      postModalVisible1: false,
      postModalVisible2: false,
      education_info:{
            school1: 'Bicol University',
            school2: 'Banquerohan High School'
          },
      basic_info:{
            work:'Self-employed',
            gender:'Male',
            language:'Japanese and Filipino',
            birdate: 'September 17, 1992'
      },
      address_info:{
            city:'Legaspi City',
            barangay:'Banquerohan'
          },
      userID:null,
      interests: [],
      listinterests: [],
      listSkills: [],
      skilled: [],
      pasabuyers: '20',
      rating: 0,
      counter: 0

    }
  },
  mounted(){
    this.userID =  atob(this.$route.query.ID)
  },
   components: {
    EditSkillsModal,
    EditInterestModal,
    EditVisitedPlaceModal,
  },
  methods:{
    toggleSkillsModal(){
      this.postModalVisible = !this.postModalVisible
    },
    listener(){
      this.postModalVisible = false;
  },
    toggleInterestModal1(){
      this.postModalVisible1 = !this.postModalVisible1
    },
    listener1(){
      this.postModalVisible1 = false;
  },
   toggleVisitedPlaceModal2(){
      this.postModalVisible2 = !this.postModalVisible2
    },
    listener2(){
      this.postModalVisible2 = false;
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
    timestampSched(datetime) {
      var schedDate = moment(datetime);
      const today = moment();
      const startOfTomorrow = moment().add(1, "day").startOf("day");
      const endOfTomorrow = moment().add(1, "day").endOf("day");
     
      if (moment(schedDate).isBefore(today)) {
        return moment(datetime).format("[From] MMM DD, YYYY [at] h:mm a");
      }
      if (moment(schedDate).isAfter(today)) {
        if (moment(schedDate).isAfter(endOfTomorrow))
          return moment(datetime).format("[From] MMM DD, YYYY [at] h:mm a");
        if (moment(schedDate).isBefore(startOfTomorrow))
          return moment(datetime).format("[Today at] h:mm a");
        else return moment(datetime).format("[Tommorow at] h:mm a");
      }
    },
      
    
  },
  computed:{
    account_infos(){
      return store.getters.getUserInfo
    },
    accountaddress(){
      return store.getters.getNotAuthUserAddress
    },
    userPersonal(){
      return store.getters.getPersonal
    },
    userAbouts(){
      return store.getters.getAllUserAbout.filter((userAbout) => {return (userAbout.email ==  this.account_infos.email)})
    },
    reviews(){
        //console.log('user',this.store.getters.getPersonal)
        return store.getters.getAllReviews.filter((rev)=>{
          return (rev.revieweeEmail == this.account_infos.email)
        })
      },
      ratings(){
        //console.log('user',this.store.getters.getPersonal)
        if(this.reviews == 0)
          return "No Ratings"
        this.reviews.filter((rev)=>{
            this.rating = this.rating + rev.rate
            this.counter++
        })
        return (this.rating/this.counter).toFixed(1)
      },
      
    userEducs(){
      console.log("ssssss", store.getters.getAuthEducation);
      return store.getters.getAuthEducation.filter((value) => {return (value.email ==  this.account_infos.email)})
    },
      allTransactions() {
      return store.getters.getAllTransactions.filter((x) => {
        return (
          (x.transactionStatus == "Completed" &&
            x.transactionReceiver == this.account_infos.email) ||
          (x.transactionStatus == "Completed" &&
            x.emailCustomerShopper == this.account_infos.email)
        );
      });
    },
    
  },
  created(){
    let arr = [];

    this.allTransactions.forEach((value, index) => {
    arr.push(value);
    console.log("transaction",value);
    console.log(index);
    if(value!=null){
      if(value.post.postIdentity == "post_offer")
      this.deliveries = this.deliveries+1;
      else 
      this.orders = this.orders+1;
    }
    });
  },
  
}
</script>