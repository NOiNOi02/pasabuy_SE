import Vuex from 'vuex'
import api from '../api'
import createPersistedState from 'vuex-persistedstate'



const store = new Vuex.Store({
    plugins: [createPersistedState({
        storage: window.sessionStorage,
    })],
    state:{
        authUser:[],
        authUserPersonal:[],
        posts:[],
        allNotif:[],
        unreadNotif:[],
        userAddress:[],
        userChatRooms:[],
        userLang:[],
        userTransactions:[],
        userShippingAddress:[],
        transportModes:[],
        shoppingPlaces:[],  
        userInfo:[],
        notAuthUserAddress:[],
        allShares:[],
        allReviews: [],
        allLanguages: [],
        allUserAbout: [],
        authUserFollow: [],
        authEducation: [],
        onlineUsers: [],
        verifiedUsers:[],
        allTransactions: [],






        // userEducation:[],

    },
    mutations: {
        //syncrhonous
        setCurrentAuthUser(state, payload) {
            state.authUser = payload;
        },
        setCurrentPersonal(state, payload) {
            state.authUserPersonal = payload;
        },
        setNotifications(state, payload) {
            state.allNotif = payload;
        },
        setUnreadNotifications(state, payload) {
            state.unreadNotif = payload;
        },
        setUserAddress(state, payload) {
            state.userAddress = payload;
        },
        FETCH_POSTS(state, post) {
            state.posts = post
        },
        FETCH_ROOMS(state, rooms) {
            state.userChatRooms = rooms
        },
        CREATE_MESSAGES(state, rooms) {
            state.userChatRooms.unshift(rooms)
        },
        setUserTransactions(state, trans) {
            state.userTransactions = []
            state.userTransactions = trans
        },
        setUserShippingAddress(state, trans) {
            state.userShippingAddress = trans
        },
        setTransportModes(state, trans) {
            state.transportModes = trans
        },
        setShoppingPlaces(state, trans) {
            state.shoppingPlaces = trans
        },
        setUserInfo(state, data) {
            state.userInfo = data
        },
        setNotAuthUserAddress(state, data) {
            state.notAuthUserAddress = data
        },
        setAllShares(state, data) {
            state.allShares = data
        },
        setShoppingList(state, data) {
            state.shoppingList = data
        },
        setOnlineUsers(state, user) {
            state.onlineUsers.unshift(user)
        },
        removeFromOnlineUsers(state, user) {
            var index = state.onlineUsers.findIndex(c => c == user);
            state.onlineUsers.splice(index, 1);
        },
        setUserFollow(state, data) {
            state.userFollow = data
        },
        setAllReviews(state,data){
            state.allReviews = data
        },
        setAuthUserFollow(state,data){
            state.authUserFollow = data
        },
        setAllLanguages(state,languages){
            state.allLanguages = languages
        },
        setAllUserAbout(state,userAbout){
            state.allUserAbout = userAbout
        },
        setAuthEducation(state,data){
            state.authEducation = data
        },
        setVerifiedUsers(state,data){
            state.verifiedUsers = data
        },
        setAllTransactions(state,data){
            state.allTransactions = data
        }

    },
    actions: {
        async createPostOffer(state, post) {
            return api
                .post('api/post/offer', post)
                .then(() => {

                })
                .catch((error) => {
                    console.log(error)
                })
        },
        async createPostRequest(state, post) {
            return api
                .post('api/post/request', post)
                .then(() => {

                })
                .catch((error) => {
                    console.log(error)
                })
        },
        async getAuthUser(state) {
            return api
                .get('api/user')
                .then((res) => {
                    let user = res.data
                    state.commit('setCurrentAuthUser', user)
                })
                .catch((error) => {
                    console.log(error)
                })
        },
        async getPersonal(state) {
            return api
                .get('api/getPersonal')
                .then((res) => {

                    let user = res.data
                    state.commit('setCurrentPersonal', user)
                })
                .catch((error) => {
                    console.log(error)
                })
        },
        async getPosts(state) {
            return api
                .get('api/getPosts')
                .then((res) => {
                    let posts = res.data
                    console.log('posts',posts)
                    state.commit('FETCH_POSTS', posts)
                })
                .catch((error) => {
                    console.log(error)
                })
        },
        async getAllNotifications(state) {
            return api
                .get('api/getNotifications')
                .then((res) => {
                    let notif = res.data
                    state.commit('setNotifications', notif)
                })
                .catch((error) => {
                    console.log(error)
                })
        },
        async getUnreadNotifications(state) {
            return api
                .get('api/getUnreadNotifications')
                .then((res) => {
                    let unreadenotif = res.data
                    state.commit('setUnreadNotifications', unreadenotif)
                })
                .catch((error) => {
                    console.log(error)
                })
        },
        async getUserAddress(state) {
            return api
                .get('api/getAddress')
                .then((res) => {
                    let address = res.data
                    state.commit('setUserAddress', address)
                })
                .catch((error) => {
                    console.log(error)
                })
        },
        async getChatRoom(state) {
            return api
                .get('api/getChatroom')
                .then((res) => {
                    let room = res.data
                    state.commit('FETCH_ROOMS', room)
                })
                .catch((error) => {
                    console.log(error)
                })
        },
        async getUserTransactions(state) {
            return api
                .get('api/getTransaction')
                .then((res) => {
                    let transactions = res.data
                    state.commit('setUserTransactions', transactions)
                })
                .catch((error) => {
                    console.log(error)
                })
        },
        async getUserShippingAddress(state) {
            return api
                .get('api/getShippingAddress')
                .then((res) => {
                    let addr = res.data
                    state.commit('setUserShippingAddress', addr)
                })
                .catch((error) => {
                    console.log(error)
                })
        },
        async getTransportModes(state) {
            return api
                .get('api/getTransportModes')
                .then((res) => {
                    let tra = res.data
                    state.commit('setTransportModes', tra)
                })
                .catch((error) => {
                    console.log(error)
                })
        },
        async getAllLangauges(state){
            return api
            .get('api/allLanguages')
            .then((res)=>{
                let languages = res.data
                state.commit('setAllLanguages',languages)
            })
            .catch((error)=>{
                console.log(error)
            })
        },
        async getUserInfo(state, ID) {
            return api
                .get('api/getUserInfo', { params: { email: ID } })
                .then((res) => {
                    let data = res.data
                    state.commit('setUserInfo', data)
                })
                .catch((error) => {
                    console.log(error)
                })
        },
        async getShoppingPlaces(state) {
            return api
                .get('api/getShoppingPlaces')
                .then((res) => {
                    let data = res.data
                    state.commit('setShoppingPlaces', data)
                })
                .catch((error) => {
                    console.log(error)
                })
        },
        async getNotAuthUserAddress(state, ID) {
            return api
                .get('api/getNotAuthUserAddress', { params: { email: ID } })
                .then((res) => {
                    let data = res.data
                    state.commit('setNotAuthUserAddress', data)
                })
                .catch((error) => {
                    console.log(error)
                })
        },
        async getAllShares(state) {
            return api
                .get('api/getShares')
                .then((res) => {
                    let data = res.data
                    console.log('shares',data)
                    state.commit('setAllShares', data)
                })
                .catch((error) => {
                    console.log(error)
                })
        },
        async getUserShoppingList(state) {
            return api
                .get('api/getShoppingList')
                .then((res) => {
                    let data = res.data
                    state.commit('setShoppingList', data)
                })
                .catch((error) => {
                    console.log(error)
                })
        },
        async getUserFollow(state, ID) {
            return api
                .get('api/getUserFollow', { params: { email: ID } })
                .then((res) => {
                    let data = res.data
                    console.log("follow table", data)
                    state.commit('setUserFollow', data)
                })
        },
        async getAuthUserFollow(state, ID) {
            return api
                .get('api/getUserFollow', { params: { email: ID } })
                .then((res) => {
                    let data = res.data
                    console.log("follow table", data)
                    state.commit('setAuthUserFollow', data)
                })
        },
        async getAllReviews(state) {
            return api
                .get('api/getReviews')
                .then((res) => {
                    let data = res.data
                    state.commit('setAllReviews', data)
                })
                .catch((error) => {
                    console.log(error)
                })
        },
        async getAllUserAbout(state){
            return api
            .get('api/getUserAbout')
            .then((res)=>{
                //console.log("RESPONSE",res)
                let userAbout = res.data
                state.commit('setAllUserAbout',userAbout)
            })
            .catch((error)=>{
                console.log(error)
            })
        },
        async getAuthEducation(state){
            return api
            .get('api/getEduc')
            .then((res)=>{
                //console.log("RESPONSE",res)
                let data = res.data
                state.commit('setAuthEducation',data)
            })
            .catch((error)=>{
                console.log(error)
            })
        },
        async getVerifiedUsers(state){
            return api
            .get('api/getVerifiedUsers')
            .then((res)=>{
                //console.log("RESPONSE",res)
                let data = res.data
                state.commit('setVerifiedUsers',data)
            })
            .catch((error)=>{
                console.log(error)
            })
        },
        async getAllTransactions(state){
            return api
            .get('api/getAllTransactions')
            .then((res)=>{
                //console.log("RESPONSE",res)
                let data = res.data
                state.commit('setAllTransactions',data)
            })
            .catch((error)=>{
                console.log(error)
            })
        },
    },
    modules: {},
    getters: {
        getUser: (state) => state.authUser,
        getPersonal: (state) => state.authUserPersonal,
        getPosts: (state) => state.posts,
        getAllNotif: (state) => state.allNotif,
        getUnreadNotif: (state) => state.unreadNotif,
        getAddress: (state) => state.userAddress,
        getRooms: (state) => state.userChatRooms,
        getUserTransactions: (state) => state.userTransactions,
        getUserShippingAddress: (state) => state.userShippingAddress,
        getTransportModes: (state) => state.transportModes,
        getShoppingPlaces: (state) => state.shoppingPlaces,
        getUserInfo: (state) => state.userInfo,
        getNotAuthUserAddress: (state) => state.notAuthUserAddress,
        getAllShares: (state) => state.allShares,
        getUserShoppingList: (state) => state.shoppingList,
        getOnlineUsers: (state) => state.onlineUsers,
        getUserFollow: (state) => state.userFollow,
        getAllReviews:(state) => state.allReviews,
        getAuthUserFollow: (state) => state.authUserFollow,
        getAuthEducation: (state) => state.authEducation,
        getAllLangauges:(state) => state.allLanguages,
        getAllUserAbout:(state) => state.allUserAbout,
        getVerifiedUsers:(state) => state.verifiedUsers,
        getAllTransactions:(state) => state.allTransactions,

    }
})


export default store;