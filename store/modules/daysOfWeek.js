const state = {
    daysOfWeek : []
};

const getters = {
    DAYS_OF_WEEK: state => {
        return state.daysOfWeek;
    }
};

const mutations = {
    setDaysOfWeek(state, payload) {
        state.daysOfWeek = payload;
    }
};

const actions = {
    loadAllDaysOfWeek: async (context) => {
        await axios.get('/api/days-of-week')
            .then((response) => {
                context.commit('setDaysOfWeek', response.data.data);
            })
    }
};

export default {
    state,
    getters,
    mutations,
    actions,
};
