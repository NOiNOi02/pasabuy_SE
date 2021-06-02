<template>
  <div class="ring-1 ring-gray-300 bg-white p-5 rounded-2xl shadow-sm">
    <div class="flex justify-between">
      <div class="flex gap-4">
        <p class="font-bold font-nunito text-sm">Education Info</p>
      </div>
      <div>
        <label
          for="sub"
          id="edt3"
          @click="toggle = !toggle"
          class="text-blue-800 w-min font-bold text-sm cursor-pointer"
          >Edit</label
        >
      </div>
    </div>
    <div
      class="text-sm w-full gap-x-10 pt-8 space-y-8 xl:w-97 2xl:w-97 lg:w-97"
      v-for="userEduc in userEducs"
      :key="userEduc"
    >
      <span class="font-raleways font-bold grid grid-cols-1">
        <p v-if="userEduc.schoolStatus === 'Current'" class="text-gray-500">
          Studied at
          <strong class="text-black">{{ userEduc.schoolName }}</strong>
        </p>
        <p v-if="userEduc.schoolStatus === 'Previous'" class="text-gray-500">
          Went to <strong class="text-black">{{ userEduc.schoolName }}</strong>
        </p>

        <p></p>
      </span>
    </div>
    <div
      v-if="toggle"
      class="fixed bg-black z-100 h-max w-screen bg-opacity-75 overflow-y-auto items-center inset-0"
    >
      <div class="flex mt-4 w-full p-3 items-center justify-center py-20">
        <div
          class="bg-white ring-1 ring-gray-300 w-full rounded-xl 2xl:w-97 lg:w-97 xl:w-97 xl:mr-16 md:w-8/12 sm:w-10/12 shadow-2xl h-auto p-5"
        >
          <div class="flex flex-row items-center justify-between p-3">
            <p class="hidden lg:block 2xl:block xl:block"></p>
            <p class="text-lg font-extrabold xl:ml-8 lg:ml-8 2xl:ml-8">
              Update Education Info
            </p>
            <p
              class="font-bold text-blue-700 cursor-pointer left-10"
              @click="toggle = false"
            >
              Close
            </p>
          </div>
          <div @click="addSchool" class="flex items-center space-x-3 font-bold">
            <p
              class="material-icons font-bold text-3xl text-blue-800 select-none cursor-pointer"
            >
              add_circle
            </p>
            <p
              class="font-bold text-md font-nunito_sans text-blue-800 select-none"
            >
              Add School
            </p>
          </div>
          <div class=" ">
            <div id="school" class="flex flex-col space-y-5">
              <div class="flex flex-col space-y-2" id="schoolInput">
                <input
                  type="text"
                  id="schoolName"
                  v-model="schoolName"
                  class="focus:outline-none rounded-xl h-10 pl-2 bg-transparent bg-gray-200"
                />
                <div class="flex items-center space-x-3 font-bold">
                  <input
                    type="radio"
                    v-model="status_ed"
                    name="status_eds"
                    value="Current"
                    class="text-black"
                  />
                  <p>Current</p>
                  <input
                    type="radio"
                    v-model="status_ed"
                    name="status_eds"
                    value="Previous"
                  />
                  <p>Previous</p>
                </div>
              </div>
            </div>

            <div id="school" class="flex flex-col space-y-5">
              <br />
              <span class="ml-2 uppercase font-bold text-sm text-gray-500"
                >School</span
              >
              <div
                v-for="schools in schoolsList"
                :key="schools"
                class="flex flex-col space-y-2"
                id="schoolInput"
              >
                <input
                  :id="schools.id"
                  v-model="schools.school"
                  class="focus:outline-none rounded-xl h-10 pl-2 bg-transparent bg-gray-200"
                />
                <div class="flex items-center space-x-3 font-bold">
                  <input
                    type="radio"
                    :checked="schools.status === 'Current'"
                    :name="schools.id"
                    v-model="schools.status"
                    value="Current"
                    class="text-black"
                  />
                  <p>Current</p>
                  <input
                    type="radio"
                    :checked="schools.status === 'Previous'"
                    :name="schools.id"
                    v-model="schools.status"
                    value="Previous"
                  />
                  <p>Previous</p>
                  <!-- <button @click="deleteSkill(skill)" class="focus:outline-none">
                  <span class="md-14 mt-2">Edit</span>
                </button> -->
                </div>
              </div>
            </div>

            <div class="flex justify-between items-center mt-4 space-x-4">
              <button
                @click="toggle = false"
                class="px-3 focus:outline-none h-6 w-full bg-white ring-1 ring-black rounded-2xl"
              >
                Cancel
              </button>
              <button
                @click="(toggle = false), save_data()"
                class="focus:outline-none px-5 bg-red-700 text-white w-full h-7 shadow-xl ring-1 ring-gray-300 rounded-2xl"
              >
                Save
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import store from "../store/index";
import VueSimpleAlert from "vue-simple-alert";
import api from "../api";
export default {
  data() {
    return {
      toggle: false,
      disabled: 0,
      hidden: false,
      show: true,
      show2: true,

      college: null,
      junior_high: "Legaspi City Science High School",
      senior_high: "Legaspi City Science High School",
      // schoolName:null,
      schoolStatus: null,
      educationLevel: null,
      schoolsList: [],
      schools: [],
    };
  },
  methods: {
    addSchool() {
      if (this.schoolName != null && this.status_ed != null) {
        this.schools = {
          id: this.schoolsList.length + 1,
          version: null,
          school: this.schoolName,
          status: this.status_ed,
        };
        this.schoolsList.push(this.schools);
        console.log("Schools", this.schoolsList);
        this.schoolName = null;
        document.getElementsByName("status_eds").checked = false;
      }
    },
    save_data() {
      var info = {
        // indexUserAbout:this.userindex,
        email: this.userPersonal.email,
        schoolList: this.schoolsList,
        // visitedPlace:this.uservisitedPlace,
      };

      api
        .post("/api/updateEduc", info)
        .then(() => {
          console.log("infor", info);
          // this.schoolsList = [];
          store.dispatch("getAuthEducation");
          VueSimpleAlert.alert(
            "Schools created successfully",
            "Sucess",
            "success"
          );
          // this.$emit('closeEditSkillsModal')
        })
        .catch((errors) => {
          console.log(errors);
        });
    },
  },
  mounted() {},
  computed: {
    
    userEducs() {
      console.log("sss", store.getters.getAuthEducation);
      return store.getters.getAuthEducation.filter((value) => {return (value.email ==  this.userPersonal.email)})
    },

    userPersonal() {
      return store.getters.getPersonal;
    }
  },
  created() {
    // this.loadskills();
    let arr = [];
    this.userEducs.forEach((value, index) => {
      arr.push(value);
      console.log("usereducation", value);
      console.log(index);

      if (value != null) {
        this.schools = {
          id: this.schoolsList.length + 1,
          version: value.indexUserEducation,
          school: value.schoolName,
          status: value.schoolStatus,
        };
        this.schoolsList.push(this.schools);
        console.log("hey", this.schoolsList);
      }
    });
  },
};
</script>
<style scoped>
</style>
