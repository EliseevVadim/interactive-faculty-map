const state = {
    pairRepeatings : []
};

const getters = {
    PAIR_REPEATINGS: state => {
        return state.pairRepeatings;
    }
};

const mutations = {
    setPairRepeatings(state, payload) {
        state.pairRepeatings = payload;
    }
};

const actions = {
    loadAllPairRepeatings: async (context) => {
        await axios.get('/api/pairs-repeatings')
            .then((response) => {
                context.commit('setPairRepeatings', response.data.data);
            })
    }
};

export default {
    state,
    getters,
    mutations,
    actions,
};
