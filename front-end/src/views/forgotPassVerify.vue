<template class="font-nunito">
    <div class="absolute vs:left-5 left-12 top-3 ">
        <router-link to="/">
            <img src="/img/pasaBUYLogoOnly.png" class="w-20 h-16 "/>
        </router-link>
        <label for="" class="absolute text-xl font-black tracking-widest top-4 left-16 font-raleway text-red-buttons">
            pasaBUY
        </label>
    </div>
    <div id="forgotPassword" class="flex items-center justify-center pt-20 pb-32 bg-gray-100">
      <div class="w-4/12 my-12 overflow-hidden text-center bg-white shadow-md vs:w-10/12 flex-grow-1 md:w-4/12 rounded-xl">
            <div class="px-10 py-16">
                <h2 class="items-center justify-center mb-5 text-2xl font-bold md:flex font-raleways ">
                    Email has been sent!</h2>
                <p class="text-left  md:text-right lg:text-justify xl:text-center">
                Please check your email and click on the received link to reset you password.</p>
                <p class="text-center text-red-600">{{error}}</p>
                <div class="flex justify-center py-5">
                    <button class="w-full h-12 px-5 py-2 text-white transition-colors duration-150 bg-red-700 rounded-3xl focus:shadow-outline hover:bg-red-700">
                         <router-link to="/log-in">Log-In</router-link></button>
                </div>
                <div class="mt-4 text-left text-grey-dark">
                    Did you received the link?
                    <button @click="resend()" class="font-bold" href="#">
                        Resend
                    </button> 
                </div>
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
        background-color: rgba(185, 28, 28)
    
    }

#iCheck{
  font-size:16px;
  color:rgb(22, 22, 141);
}
#iMessage{
  font-size:24px;
  color:rgb(22, 22, 141);
}
img{ 
  max-width: 100px;
  width:11%;
 
}
</style>


<script>
import api from '../api-guest'
export default {
    data(){
        return{
          forgot:{
            email:null,
          },
          error:null
        }
    }, 
    methods:{
        resend(){
            api.post('/api/password/email',{email:localStorage.getItem("forgotPassEmail")}).then((res)=>{
              console.log(res.data)
            }).catch((errors)=>{
              this.error = errors.response.data.error;
            })
        
        }
    },
}

</script>

