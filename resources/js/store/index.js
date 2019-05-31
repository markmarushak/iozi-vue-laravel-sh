import Vue from 'vue';
import Vuex from 'vuex';


Vue.use(Vuex);

const store = new Vuex.Store({
    state: {
        bg: false,
        preloader: {
            load: false,
            text: 'загрузка..'
        }
    },
    getters: {
        bg(state){
            let bg = state.bg
            return bg
        },
        preloader(state){
            let preloader = state.preloader
            return preloader
        }
    },
    mutations: {
        set(state, {type, items}){
            state[type] = items
        }
    },
    actions: {

    }
})

export default store