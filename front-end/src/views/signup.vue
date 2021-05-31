<template class=" bg-gray-bgcolor font-nunito">
  <div class="flex items-center">
    <router-link to="/">
      <img src="/img/pasaBUYLogoOnly.png" class="block w-16 h-16" />
    </router-link>
    <h1
      class="absolute block text-xl font-black tracking-widest left-16 font-raleway text-red-buttons"
    >
      pasaBUY
    </h1>
  </div>
  <div id="signup" class="flex items-center justify-center px-4 pb-10">
    <div
      class="w-full my-12 overflow-hidden text-center bg-white shadow-md flex-grow-1 rounded-xl xl:w-2/5 lg:w-2/5 2xl:w-2/5 md:w-97 sm:w-97"
    >
      <div class="px-10 py-16">
        <h1 class="pb-5 space-x-1 space-y-1 text-2xl font-bold">
          Create an account
        </h1>
        <form action="#">
          <!-- <div class="flex flex-row mb-4"> -->
          <div
            class="flex flex-col sm:flex-row sm:justify-between sm:space-x-6 xl:flex-row xl:justify-between 2xl:flex-row 2xl:justify-between lg:flex-row lg:justify-between lg:space-x-6"
          >
            <div class="w-full">
              <div
                class="relative flex justify-between mb-2 md:mb-1 mr-2 md:mr-0 sm:mr-0 vs:mr-0 ssm:mr-0"
              >
                <input
                  @input="capitalizeFName"
                  name=""
                  type="firstname"
                  required
                  class="capitalize relative block w-full px-3 py-2 mt-4 font-semibold tracking-wide text-gray-900 placeholder-gray-500 bg-gray-200 border rounded-lg appearance-none h-14 focus:outline-none focus:z-10 focus:border-blue-300"
                  placeholder="First Name"
                  v-model="PersonalInfo.firstName"
                  v-on:keypress="isLetter($event)"
                />
               
              </div>
               <p
                  v-show="error_firstname.length > 0"
                  v-for="(err, index) in error_firstname"
                  :key="index"
                  class="frmValidation flex relative relative"
                >
                  <i class="frmIcon fas"></i>
                  {{ err }}
                </p>
            </div>

            <div class="w-full">
              <div
                class="relative flex justify-between mb-2 ml-2 md:ml-0 sm:ml-0 vs:ml-0 ssm:ml-0"
              >
                <input
                  @input="capitalizeLName"
                  aria-label="Last Name"
                  name=""
                  type="name"
                  required
                  class="capitalize relative block w-full px-3 py-2 mt-4 sm:mt-2 vs:mt-2 ssm:mt-2 font-semibold tracking-wide text-gray-900 placeholder-gray-500 bg-gray-200 border rounded-lg appearance-none h-14 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 focus:z-10 sm:text-sm"
                  placeholder="Last Name"
                  v-model="PersonalInfo.lastName"
                  v-on:keypress="isLetter($event)"
                />
              </div>
                <p
                  v-show="error_lastname.length > 0"
                  v-for="(err, index) in error_lastname"
                  :key="index"
                  class="frmValidation flex relative relative"
                >
                  <i class="frmIcon fas"></i>
                  {{ err }}
                </p>
            </div>
          </div>

          <div v-show="false" class="mt-1 bottom-0 flex flex-row items-center">
            <span class="material-icons text-xs text-crimsonRed"> warning</span>
            <span
              ><p
                class="ml-1 text-xs leading-none text-crimsonRed font-semibold"
              >
                Are you sure you typed your name correctly?
              </p></span
            >
          </div>

          <div class="flex flex-row mb-4">
            <input
              @input="ValidateEmail"
              @click="showReqEmail"
              @blur="hideReqEmail"
              aria-label="Email"
              name=""
              type="email"
              required
              class="relative block w-full px-3 py-2 font-semibold tracking-wide text-gray-900 placeholder-gray-500 bg-gray-200 border rounded-lg appearance-none h-14 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 focus:z-10 sm:text-sm"
              placeholder="Email (Eg. name@email.com)"
              v-model="PersonalInfo.email"
            />
          </div>
          <div
            v-if="displayReqEmail"
            class="frmValidation mt-2 ml-5 sm:ml-5 vs:ml-5 ssm:ml-5 w-full relative"
          >
            <p
              class="frmValidation flex relative relative"
              :class="{ 'frmValidation--passed': emailvalidation }"
            >
              <i
                class="frmIcon fas"
                :class="emailvalidation ? 'fa-check' : 'fa-times'"
              ></i>
              Valid email
            </p>
            <p
              v-show="error_email.length > 0"
              v-for="(err, index) in error_email"
              :key="index"
              class="frmValidation flex relative relative"
            >
              <i class="frmIcon fas"></i>
              {{ err }}
            </p>
          </div>
          <div v-show="false" class="mt-1 bottom-0 flex flex-row items-center">
            <span class="material-icons text-xs text-crimsonRed"> warning</span>
            <span
              ><p
                class="ml-1 text-xs leading-none text-crimsonRed font-semibold"
              >
                Please enter a valid email
              </p></span
            >
          </div>

          <div class="relative flex mb-4 mt-2">
            <span class="absolute z-20 bg-gray-200 top-2.5 left-4 flex"
              ><img class="w-9 h-9" src="img/philippines.png"
            /></span>
            <input
              @input="ValidateNumber"
              @click="showReqPNumber"
              @blur="hideReqPNumber"
              name=""
              type="text"
              class="w-full px-3 py-2 pl-16 font-semibold tracking-wide text-gray-900 placeholder-gray-500 bg-gray-200 border rounded-lg appearance-none h-14 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 focus:z-10 sm:text-sm"
              placeholder="Phone Number (+63 999 999 9999)"
              v-model="PersonalInfo.phoneNumber"
              v-on:keypress="isNumber($event)"
              :maxlength="max"
              v-mask="'+63 ### ### ####'"
            />
          </div>
          <div
            v-if="displayReqPNumber"
            class="frmValidation mb-2 ml-5 w-full relative"
          >
            <p
              class="frmValidation flex relative relative"
              :class="{ 'frmValidation--passed': numbervalidation }"
            >
              <i
                class="frmIcon fas"
                :class="numbervalidation ? 'fa-check' : 'fa-times'"
              ></i>
              Valid Phone Number
            </p>
            <!-- <p
              v-show="error_phonenumber.length > 0"
              v-for="(err, index) in error_phonenumber"
              :key="index"
              class="frmValidation flex relative relative"
            >
              <i class="frmIcon fas"></i>
              {{ err }}
            </p> -->
          </div>

          <div
            class="flex flex-col sm:flex-row sm:justify-between sm:space-x-6 xl:flex-row xl:justify-between 2xl:flex-row 2xl:justify-between lg:flex-row lg:justify-between lg:space-x-6"
          >
            <div class="w-full">
              <div
                class="relative flex justify-between mb-2 mr-2 md:mr-0 sm:mr-0 vs:mr-0 ssm:mr-0"
              >
                <input
                  @click="passShowValidation"
                  @blur="passHideValidation"
                  placeholder="Enter your password"
                  show="!showPass"
                  id="input_showpass"
                  name="password"
                  class="relative block w-full px-3 py-2 mb-2 font-semibold tracking-wide text-gray-900 placeholder-gray-500 bg-gray-200 border rounded-lg appearance-none h-14 focus:outline-none focus:z-10 focus:border-blue-300"
                  type="password"
                  @input="password_check"
                  v-model="PersonalInfo.password"
                  v-show="!showPass"
                />
                <input
                  @click="passShowValidation"
                  @blur="passHideValidation"
                  placeholder="Enter your password"
                  show="showPass"
                  name="password"
                  class="relative block w-full px-3 py-2 mb-2 font-semibold tracking-wide text-gray-900 placeholder-gray-500 bg-gray-200 border rounded-lg appearance-none h-14 focus:outline-none focus:z-10 focus:border-blue-300"
                  type="text"
                  @input="password_check"
                  v-model="PersonalInfo.password"
                  v-show="showPass"
                />
                <span
                  @click="(showPass = !showPass), (displayPass = true)"
                  @blur="passHideValidation"
                  id="showpass"
                >
                  <span
                    v-show="!showPass"
                    class="fa fa-eye absolute z-20 bg-gray-200 top-5 right-4"
                  ></span>
                  <span
                    v-show="showPass"
                    class="fa fa-eye-slash absolute z-20 bg-gray-200 top-5 right-4"
                  ></span
                ></span>
              </div>
              <div
                v-if="displayPass"
                class="frmValidation ml-5 mb-2 mr-5 sm:mr-0 vs:mr-0 ssm:mr-0 w-full relative"
              >
                <p
                  class="frmValidation flex relative relative"
                  :class="{
                    'frmValidation--passed': PersonalInfo.password.length > 8,
                  }"
                >
                  <i
                    class="frmIcon fas"
                    :class="
                      PersonalInfo.password.length > 8 ? 'fa-check' : 'fa-times'
                    "
                  ></i>
                  Longer than 8 characters
                </p>
                <p
                  class="frmValidation flex relative relative"
                  :class="{ 'frmValidation--passed': has_uppercase }"
                >
                  <i
                    class="frmIcon fas"
                    :class="has_uppercase ? 'fa-check' : 'fa-times'"
                  ></i>
                  Has a capital letter
                </p>
                <p
                  class="frmValidation flex relative relative"
                  :class="{ 'frmValidation--passed': has_lowercase }"
                >
                  <i
                    class="frmIcon fas"
                    :class="has_lowercase ? 'fa-check' : 'fa-times'"
                  ></i>
                  Has a lowercase letter
                </p>
                <p
                  class="frmValidation flex relative relative"
                  :class="{ 'frmValidation--passed': has_number }"
                >
                  <i
                    class="frmIcon fas"
                    :class="has_number ? 'fa-check' : 'fa-times'"
                  ></i>
                  Has a number
                </p>

                <!-- <p
                  v-show="error_password.length > 0"
                  v-for="(err, index) in error_password"
                  :key="index"
                  class="frmValidation flex relative relative"
                >
                  <i class="frmIcon fas"></i>
                  {{ err }}
                </p> -->
              </div>
            </div>
            <div class="w-full">
              <div
                class="relative flex justify-between mb-2 ml-2 md:ml-0 sm:ml-0 vs:ml-0 ssm:ml-0"
              >
                <input
                  @click="passConfirmShowValidation"
                  @blur="passConfirmHideValidation"
                  aria-label="Confirm Password"
                  name=""
                  type="password"
                  required
                  class="relative block w-full px-3 py-2 mb-2 font-semibold tracking-wide text-gray-900 placeholder-gray-500 bg-gray-200 border rounded-lg appearance-none h-14 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 focus:z-10 sm:text-sm"
                  placeholder="Confirm Password"
                  v-model="PersonalInfo.password_confirmation"
                  v-show="!showPass1"
                />
                <input
                  @click="passConfirmShowValidation"
                  @blur="passConfirmHideValidation"
                  aria-label="Confirm Password"
                  name=""
                  type="text"
                  required
                  class="relative block w-full px-3 py-2 mb-2 font-semibold tracking-wide text-gray-900 placeholder-gray-500 bg-gray-200 border rounded-lg appearance-none h-14 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 focus:z-10 sm:text-sm"
                  placeholder="Confirm Password"
                  v-model="PersonalInfo.password_confirmation"
                  v-show="showPass1"
                />
                <span
                  @click="(showPass1 = !showPass1), (displayPassConfirm = true)"
                  id="showpass"
                >
                  <span
                    v-show="!showPass1"
                    class="fa fa-eye absolute z-20 bg-gray-200 top-5 right-4"
                  ></span>
                  <span
                    v-show="showPass1"
                    class="fa fa-eye-slash absolute z-20 bg-gray-200 top-5 right-4"
                  ></span
                ></span>
              </div>
              <div
                v-if="displayPassConfirm"
                class="frmValidation ml-6 sm:ml-5 vs:ml-5 ssm:ml-5 w-full relative"
              >
                <p
                  class="frmValidation flex relative relative"
                  :class="{
                    'frmValidation--passed':
                      PersonalInfo.password ==
                        PersonalInfo.password_confirmation &&
                      PersonalInfo.password,
                  }"
                >
                  <i
                    class="frmIcon fas"
                    :class="
                      PersonalInfo.password ==
                        PersonalInfo.password_confirmation &&
                      PersonalInfo.password
                        ? 'fa-check'
                        : 'fa-times'
                    "
                  ></i>
                  Match Password
                </p>
                <p
                  v-show="error_password_confirmation.length > 0"
                  v-for="(err, index) in error_password_confirmation"
                  :key="index"
                  class="frmValidation flex relative relative"
                >
                  <i class="frmIcon fas"></i>
                  {{ err }}
                </p>
              </div>
            </div>

            <div class="absolute invisible inline-flex right-0">
              <!--cant fit sa screen so tig set ko lng na invi for the mean time-->
              <div
                class="arrowLeft inline-flex items-center justify-start p-4 bg-red-600 rounded-lg"
              >
                <p class="text-base leading-none text-white">
                  Use 8 or more characters.
                </p>
              </div>
            </div>
          </div>

          <div class="flex mb-2 -mx-1">
            <div
              v-show="false"
              class="mt-1 bottom-0 flex flex-row items-center"
            >
              <span class="material-icons text-xs text-crimsonRed">
                warning</span
              >
              <span
                ><p
                  class="ml-1 text-xs leading-none text-crimsonRed font-semibold"
                >
                  Those passwords did not match. Try again
                </p></span
              >
            </div>
          </div>
          <div class="flex mb-2 -mx-1 mt-6">
            <div
              class="w-1/2 px-1 mt-6 text-lg font-bold text-left text-grey-dark text-blue"
            >
              <router-link to="/log-in">Log In instead</router-link>
            </div>
            <div class="flex justify-end w-1/2 px-1 mt-3">
              <button
                @click="nextPage"
                v-if="!next"
                class="h-10 m-2 text-white transition-colors duration-150 bg-red-buttons px-7 rounded-3xl focus:outline-none"
              >
                NEXT
              </button>
            </div>
            <div class="flex justify-end w-1/2 px-1 mt-3" v-if="next">
              <button
                class="relative h-10 m-2 text-white transition-colors duration-150 bg-red-buttons px-7 rounded-3xl focus:outline-none"
                disabled
              >
                <img
                  src="/img/loading.gif"
                  class="w-40 h-20 absolute"
                  style="margin-top: -28%; margin-left: 30px"
                />
                <span> NEXT</span>
              </button>
            </div>
          </div>
          <div
            class="mt-4 text-xs font-bold tracking-wide text-left text-gray-500 text-grey-dark"
          >
            By signing up, you agree to the
            <router-link to="/terms-and-condition" class="font-bold text-black">
              Terms of Service
            </router-link>
            and
            <router-link to="/privacy-policy" class="font-bold text-black">
              Privacy Policy
            </router-link>
          </div>

          <!--<VueCustomTooltip label="This is a tooltip" position="is-bottom" class="rounded-full p-2 bg-gray-200">This is a tooltip
                    <span>some text</span>
                </VueCustomTooltip>-->
        </form>
      </div>
    </div>
  </div>
</template>

<style>
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

.arrowLeft::before {
  content: "";
  position: absolute;
  display: block;
  width: 0px;
  left: 0;
  top: 50%;
  border: 10px solid transparent;
  border-left: 0;
  border-right: 15px solid rgba(220, 38, 38, 1);
  transform: translate(calc(-100%), -50%);
}

.container {
  width: 400px;
  margin: 50px auto;
  background: white;
  padding: 10px;
  font-family: Arial, Helvetica, sans-serif, sans-serif;
  border-radius: 3px;
}
h1 {
  font-size: 24px;
  text-align: center;
  text-transform: uppercase;
}
.frmField {
  background-color: white;
  color: #495057;
  line-height: 1.25;
  font-size: 16px;
  font-family: "Roboto", sans-serif;
  border: 0;
  padding: 10px;
  border: 1px solid #dbdbdb;
  border-radius: 3px;
  width: 90%;
}
.frmLabel {
  display: block;
  margin-bottom: 10px;
  font-weight: bold;
}
.frmValidation {
  font-size: 13px;
}
.frmValidation--passed {
  color: #717b85;
}
.frmIcon {
  color: #eb0029;
}
.frmValidation--passed .frmIcon {
  color: #0fa140;
}

.howToBuild {
  text-align: center;
  color: purple;
}
.howToBuild a {
  color: grey;
  font-weight: bold;
  text-decoration: none;
  text-transform: uppercase;
}

.showpass {
  float: right;
  overflow: visible;
}
.input_showpass {
  float: left;
}
</style>

<script>
import api from "../api-guest"
export default {
  data() {
    return {
      max: 16,
      next: false,
      showPass: false,
      showPass1: false,
      has_number: false,
      has_lowercase: false,
      has_uppercase: false,
      has_letter_name: false,
      has_letter_Lname: false,
      PersonalInfo: {
        firstName: null,
        lastName: null,
        email: null,
        phoneNumber: null,
        password: "",
        password_confirmation: "",
        valid: false,
      },

      errors: null,
      error_firstname: [],
      error_lastname: [],
      error_email: [],
      error_phonenumber: [],
      error_password: [],
      error_password_confirmation: [],
      displayPass: false,
      displayPassConfirm: false,
      displayReqFname: false,
      displayReqLname: false,
      displayReqPNumber: false,
      displayReqEmail: false,
      emailvalidation: false,
      numbervalidation: false,
      // displayReqPNumber:false,
    };
  },

  methods: {
    capitalizeTheFirstLetterOfEachWord(words) {
      var separateWord = words.toLowerCase().split(" ");
      for (var i = 0; i < separateWord.length; i++) {
        separateWord[i] =
          separateWord[i].charAt(0).toUpperCase() +
          separateWord[i].substring(1);
      }
      return separateWord.join(" ");
    },
    showReqFname() {
      this.displayReqFname = true;
      // this.displayReqLname=true;
    },
    hideReqFname() {
      this.displayReqFname = false;
      //this.displayReqLname=true;
    },
    showReqLname() {
      this.displayReqLname = true;
    },
    hideReqLname() {
      this.displayReqLname = false;
    },
    showReqPNumber() {
      this.displayReqPNumber = true;
    },
    hideReqPNumber() {
      this.displayReqPNumber = false;
    },
    showReqEmail() {
      this.displayReqEmail = true;
    },
    hideReqEmail() {
      this.displayReqEmail = false;
    },
    passShowValidation() {
      this.displayPass = true;
    },
    passHideValidation() {
      this.displayPass = false;
    },
    passConfirmShowValidation() {
      this.displayPassConfirm = true;
    },
    passConfirmHideValidation() {
      this.displayPassConfirm = false;
    },

    password_check: function () {
      this.has_number = /\d/.test(this.PersonalInfo.password);
      this.has_lowercase = /[a-z]/.test(this.PersonalInfo.password);
      this.has_uppercase = /[A-Z]/.test(this.PersonalInfo.password);
    },
    letter_check: function () {
      this.has_letter_name = /[a-zA-Z]/.test(this.PersonalInfo.firstName);
    },
    letter_checkL: function () {
      this.has_letter_Lname = /[a-zA-Z]/.test(this.PersonalInfo.lastName);
    },
    email_check: function () {
      this.has_special = /[/@ /.]/.test(this.PersonalInfo.email);
    },
    isLetter(e) {
      let char = String.fromCharCode(e.keyCode); // Get the character
      if (/^[A-Za-z ]+$/.test(char)) return true;
      // Match with regex
      else e.preventDefault(); // If not match, don't add to input text
    },
    isNumber(e) {
      let char = String.fromCharCode(e.keyCode); // Get the character
      if (/^[0-9]+$/.test(char)) return true;
      // Match with regex
      else e.preventDefault(); // If not match, don't add to input text
    },
    nextPage() {
      this.next = true;
      api
        .get("/sanctum/csrf-cookie")
        .then(() => {
          api
            .post("/api/postPersonal", this.PersonalInfo)
            .then((res) => {
              if (res != null) {
                localStorage.setItem(
                  "personal",
                  JSON.stringify(res.data.personalInfo)
                );
                localStorage.setItem(
                  "account",
                  JSON.stringify(res.data.account)
                );
                console.log(res.data.personalInfo);
                localStorage.setItem("code", res.data.code);
                this.$router.push({ name: "Verification" });
              } // end if
              else {
                console.log(res.data.personalInfo);
                console.log("error, email not sent");
              } //end else
            })
            .catch((errors) => {
              this.next = false;
              console.log(errors);
              if (errors.response.data.firstName == undefined)
                errors.response.data.firstName = "";
              if (errors.response.data.lastName == undefined)
                errors.response.data.lastName = "";
              if (errors.response.data.phoneNumber == undefined)
                errors.response.data.phoneNumber = "";
              if (errors.response.data.password == undefined)
                errors.response.data.password = "";
              if (errors.response.data.email == undefined)
                errors.response.data.email = "";
              this.errors =
                errors.response.data.firstName +
                " " +
                errors.response.data.lastName +
                " " +
                errors.response.data.email +
                " " +
                errors.response.data.phoneNumber +
                " " +
                errors.response.data.password;
              this.error_firstname = errors.response.data.firstName;
              this.error_lastname = errors.response.data.lastName;
              this.error_email = errors.response.data.email;
              this.error_password = errors.response.data.password;
              this.error_phonenumber = errors.response.data.phoneNumber;
              this.displayReqFname = true;
              this.displayReqLname = true;
              this.displayReqPNumber = true;
              this.displayReqEmail = true;
              this.displayPass = true;
              this.displayPassConfirm = true;
            }); //end catch
        });
    },
    ValidateEmail() {
      var mailformat = /\S+@\S+\.\S+/;
      this.emailvalidation = mailformat.test(this.PersonalInfo.email);
    },
    ValidateNumber() {
      var numberformat = /^(\+?[6][3]?[ ]?[9]\d{2}[ ]?\d{3}[ ]?\d{4})$/;
      this.numbervalidation = numberformat.test(this.PersonalInfo.phoneNumber);
    },
    capitalizeFName: function () {
      // if (!this.PersonalInfo.firstName) return ''
      // this.PersonalInfo.firstName.toLowerCase().split(' ');
      // var hi= this.PersonalInfo.firstName.charAt(0).toUpperCase() + this.PersonalInfo.firstName.slice(1);
      this.PersonalInfo.firstName = this.capitalizeTheFirstLetterOfEachWord(this.PersonalInfo.firstName);
      console.log(
        this.capitalizeTheFirstLetterOfEachWord(this.PersonalInfo.firstName)
      );
    },

    capitalizeLName: function () {

      this.PersonalInfo.lastName = this.capitalizeTheFirstLetterOfEachWord(this.PersonalInfo.lastName);
      console.log(
        this.capitalizeTheFirstLetterOfEachWord(this.PersonalInfo.lastName)
      );
    },
  },
  created() {
    document.body.style.backgroundColor = "rgb(235,235,235)";
    if (
      localStorage.getItem("personal") != null &&
      localStorage.getItem("account") != null
    ) {
      console.log("has value");
      var dataPersonal = JSON.parse(localStorage.getItem("personal"));
      this.PersonalInfo.firstName = dataPersonal.firstName;
      this.PersonalInfo.lastName = dataPersonal.lastName;
      this.PersonalInfo.email = dataPersonal.email;
      this.PersonalInfo.phoneNumber = dataPersonal.phoneNumber;
    }
  },
};
</script>
