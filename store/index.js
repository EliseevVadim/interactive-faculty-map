import Vue from "vue";
import Vuex from "vuex";
import admin from "./modules/admin";

Vue.use(Vuex);

export const store = new Vuex.Store({
    state: {},
    getters: {},
    mutations: {},
    actions: {},
    modules: {
        admin
    }
});
