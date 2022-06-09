const state = {
    ranks: []
};

const getters = {
    RANKS: state => {
        return state.ranks;
    }
};

const mutations = {
    setRanks(state, payload) {
        state.ranks = payload;
    }
};

const actions = {
    loadAllRanks: async(context) => {
        await axios.get('/api/science-ranks')
            .then((response) => {
                context.commit('setRanks', response.data.data);
            })
    }
};

export default {
    state,
    getters,
    mutations,
    actions,
};
