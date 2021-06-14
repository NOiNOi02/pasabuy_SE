<template>
  <!--notifications-->
  <div v-for="(notif, index) in allNotifications" :key="index">
    <div
      class="flex items-start px-4 py-3 -mx-2 border-b hover:bg-gray-100"
      v-if="notif.type === sharedNotif"
    >
      <img
        class="object-cover w-10 h-10 mx-1 rounded-full"
        :src="notif.data.sharerPic"
        alt="avatar"
      />
      <p class="pl-1 mx-2 text-sm text-gray-800">
        <span class="font-bold" href="#">{{ notif.data.sharer }}</span>
        <span class="font-semibold"> has shared your post</span><br />
        <button
          @click="dispatchSingleSharedPost(notif.data.postNumber)"
          class="font-bold text-blue-500"
        >
          View Post
        </button>
        <span class="text-xs text-gray-500">
          {{ timestamp(notif.created_at) }}</span
        >
      </p>
    </div>
    <div
      class="flex items-start px-4 py-3 -mx-2 border-b hover:bg-gray-100"
      v-if="notif.type === cancelledRequestNotif"
    >
      <img
        class="object-cover w-10 h-10 mx-1 rounded-full"
        :src="notif.data.cancellerPic"
        alt="avatar"
      />
      <p class="pl-1 mx-2 text-sm text-gray-800">
        <span class="font-bold" href="#">{{ notif.data.canceller }}</span>
        <span class="font-semibold">
          has cancelled their {{ notif.data.postIdentity }} to your post</span
        ><br />
        <button
          @click="dispatchSinglePagePost(notif.data.postNumber)"
          class="font-bold text-blue-500"
        >
          View Post
        </button>
        <span class="text-xs text-gray-500">
          {{ timestamp(notif.created_at) }}</span
        >
      </p>
    </div>
    <div
      class="flex items-start px-4 py-3 -mx-2 border-b hover:bg-gray-100"
      v-if="notif.type === declinedRequestNotif"
    >
      <img
        class="object-cover w-10 h-10 mx-1 rounded-full"
        :src="notif.data.declinerPic"
        alt="avatar"
      />
      <p class="pl-1 mx-2 text-sm text-gray-800">
        <span class="font-bold" href="#">{{ notif.data.decliner }}</span>
        <span class="font-semibold">
          has declined your {{ notif.data.identity }}</span
        ><br />
        <button
          @click="dispatchSinglePagePost(notif.data.postNumber)"
          class="font-bold text-blue-500"
        >
          View Post
        </button>
        <span class="text-xs text-gray-500">
          {{ timestamp(notif.created_at) }}</span
        >
      </p>
    </div>
    <div
      class="flex items-start px-4 py-3 -mx-2 border-b hover:bg-gray-100"
      v-if="notif.type === acceptRequestNotif"
    >
      <img
        class="object-cover w-10 h-10 mx-1 rounded-full"
        :src="notif.data.accepterPic"
        alt="avatar"
      />
      <p class="pl-1 mx-2 text-sm text-gray-800">
        <span class="font-bold" href="#">{{ notif.data.accepter }}</span>
        <span class="font-semibold">
          has accepted your {{ notif.data.identity }}</span
        ><br />
        <button
          @click="dispatchSinglePagePost(notif.data.postNumber)"
          class="font-bold text-blue-500"
        >
          View Post
        </button>
        <span class="text-xs text-gray-500">
          {{ timestamp(notif.created_at) }}</span
        >
      </p>
    </div>
    <div
      class="flex items-start px-4 py-3 -mx-2 border-b hover:bg-gray-100"
      v-if="notif.type === updateRequestNotif"
    >
      <img
        class="object-cover w-10 h-10 mx-1 rounded-full"
        :src="notif.data.updaterPic"
        alt="avatar"
      />
      <p class="pl-1 mx-2 text-sm text-gray-800">
        <span class="font-bold" href="#">{{ notif.data.updater }}</span>
        <span class="font-semibold" v-if="notif.data.status == 'In Transit'">
          Is now delivering your order</span
        >
        <span class="font-semibold" v-else>
          has {{ notif.data.status }} your Order.</span
        ><br />
        <button
          @click="dispatchSinglePage(notif.data.transactionNumber)"
          class="font-bold text-blue-500"
        >
          View Order
        </button>
        <span class="text-xs text-gray-500">
          {{ timestamp(notif.created_at) }}</span
        >
      </p>
    </div>
    <div
      class="flex items-start px-4 py-3 -mx-2 border-b hover:bg-gray-100"
      v-if="notif.type === postStatusNotif"
    >
      <img
        class="object-cover w-10 h-10 mx-1 rounded-full"
        :src="notif.data.userPic"
        alt="avatar"
      />
      <p class="pl-1 mx-2 text-sm text-gray-800">
        <span class="font-bold" href="#">{{ notif.data.user }}</span>
        <span class="font-semibold">
          has changed their post status to {{ notif.data.status }}</span
        ><br />
        <button
          @click="dispatchSinglePagePost(notif.data.postNumber)"
          class="font-bold text-blue-500"
        >
          View Post
        </button>
        <span class="text-xs text-gray-500">
          {{ timestamp(notif.created_at) }}</span
        >
      </p>
    </div>
    <div
      class="flex items-start px-4 py-3 -mx-2 border-b hover:bg-gray-100"
      v-if="notif.type === followNotif"
    >
      <img
        class="object-cover w-10 h-10 mx-1 rounded-full"
        :src="notif.data.followerPic"
        alt="avatar"
      />
      <p class="pl-1 mx-2 text-sm text-gray-800">
        <span class="font-bold" href="#">{{ notif.data.follower }}</span>
        <span class="font-semibold"> started following you</span><br />
        <span class="text-xs text-gray-500">
          {{ timestamp(notif.created_at) }}</span
        >
      </p>
    </div>
  </div>
</template>

<script>
// import api from "../api"
import moment from "moment";
import store from "../store/index";
import api from "../api";
export default {
  data() {
    return {
      sharedNotif: "App\\Notifications\\SharedNotification",
      cancelledRequestNotif: "App\\Notifications\\cancelledRequestNotification",
      declinedRequestNotif: "App\\Notifications\\declinedRequestNotification",
      acceptRequestNotif: "App\\Notifications\\confirmRequestNotification",
      updateRequestNotif: "App\\Notifications\\UpdateRequestNotification",
      postStatusNotif: "App\\Notifications\\postStatusNotification",
      followNotif: "App\\Notifications\\followNotification",
    };
  },
  methods: {
    toEncrypt(val) {
      return btoa(val);
    },
    dispatchSinglePage(transactNum) {
      var temp = JSON.parse(JSON.stringify(this.Orders));
      var temp2 = temp.filter((x) => {
        return x.transactionNumber === transactNum;
      });
      console.log("yrmp2", temp);

      console.log("yrmp2", temp2);
      if (temp2.length <= 0) {
        temp = JSON.parse(JSON.stringify(this.Deliveries));
        temp2 = temp.filter((x) => {
          return x.transactionNumber === transactNum;
        });
        console.log("in deliveries", temp2);
        this.$router.push({
          name: "singlePostDelivery",
          query: { transaction: this.toEncrypt(JSON.stringify(temp2)) },
        });
        return;
      }
      console.log("in orders", temp2);

      this.$router.push({
        name: "singlePostOrder",
        query: { transaction: this.toEncrypt(JSON.stringify(temp2)) },
      });
      return;
    },
    dispatchSinglePagePost(postNumber) {
      var temp = JSON.parse(JSON.stringify(this.posts));
      var temp2 = temp.filter((x) => {
        return x.postNumber === postNumber;
      });

      console.log("temp2", temp2[0]);

      if (temp2[0].postIdentity == "request_post") {
        this.$router.push({
          name: "OrderRequestSinglePage",
          query: { post: this.toEncrypt(JSON.stringify(temp2[0].postNumber)) },
        });
      } else {
        this.$router.push({
          name: "ShoppingOfferSinglePage",
          query: { post: this.toEncrypt(JSON.stringify(temp2[0].postNumber)) },
        });
      }
    },
    dispatchSingleSharedPost(postNumber) {
      var temp = JSON.parse(JSON.stringify(this.shares));
      var temp2 = temp.filter((x) => {
        return x.postNumber === postNumber;
      });

      console.log("temp2", temp2[0]);

      this.$router.push({
        name: "SharedPostsSinglePage",
        query: { post: this.toEncrypt(JSON.stringify(temp2[0].postNumber)) },
      });
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
  },
  computed: {
    allNotifications() {
      return store.getters.getAllNotif;
    },
    user() {
      return store.getters.getUser;
    },
    shares() {
      return store.getters.getAllShares;
    },
    Orders() {
      return store.getters.getUserTransactions.filter((x) => {
        return (
          (x.post.postIdentity == "request_post" &&
            x.post.email == this.user.email) ||
          (x.post.postIdentity == "offer_post" &&
            x.post.email != this.user.email)
        );
      });
    },
    Deliveries() {
      return store.getters.getUserTransactions.filter((x) => {
        return (
          (x.post.postIdentity == "request_post" &&
            x.post.email != this.user.email) ||
          (x.post.postIdentity == "offer_post" &&
            x.post.email == this.user.email)
        );
      });
    },
    posts() {
      return store.getters.getPosts;
    },
  },
  created() {
    api
      .post("/api/readNotif")
      .then(() => {
        store.dispatch("getUnreadNotifications");
      })
      .catch((errors) => {
        console.log(errors);
      });
  },
};
</script>