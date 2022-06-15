import Vue from "vue";
import Vuex from "vuex";
import admin from "./modules/admin";
import scienceRanks from "./modules/scienceRanks";
import teachers from "./modules/teachers";
import disciplines from "./modules/disciplines";
import pairInfos from "./modules/pairInfos";
import floors from "./modules/floors";
import auditoriums from "./modules/auditoriums";
import secondaryObjectTypes from "./modules/secondaryObjectTypes";
import secondaryObjects from "./modules/secondaryObjects";
import pairs from "./modules/pairs";
import pairRepeatings from "./modules/pairRepeatings";
import daysOfWeek from "./modules/daysOfWeek";
import teachersDisciplines from "./modules/teachersDisciplines";

Vue.use(Vuex);

export const store = new Vuex.Store({
    state: {},
    getters: {},
    mutations: {},
    actions: {},
    modules: {
        admin,
        scienceRanks,
        teachers,
        disciplines,
        pairInfos,
        floors,
        auditoriums,
        secondaryObjectTypes,
        secondaryObjects,
        pairs,
        pairRepeatings,
        daysOfWeek,
        teachersDisciplines
    }
});
