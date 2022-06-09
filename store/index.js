import Vue from "vue";
import Vuex from "vuex";
import admin from "./modules/admin";
import scienceRanks from "./modules/scienceRanks";
import teachers from "./modules/teachers";

Vue.use(Vuex);

export const store = new Vuex.Store({
    state: {},
    getters: {},
    mutations: {},
    actions: {},
    modules: {
        admin,
        scienceRanks,
        teachers
    }
});
