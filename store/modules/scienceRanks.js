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
    },
    addScienceRank: (context, payload) => {
        return new Promise(async (resolve, reject) => {
            let formData = new FormData();
            formData.append('rank_name', payload.rank_name);
            await axios.post('/api/science-ranks', formData)
                .then((response) => {
                    resolve(response);
                })
                .catch((error) => {
                    reject(error);
                })
        })
    },
    loadScienceRankId: (context, id) => {
        return new Promise(async (resolve, reject) => {
            await axios.get('/api/science-ranks/' + id)
                .then((response) => {
                    resolve(response);
                })
                .catch((error) => {
                    reject(error);
                })
        });
    },
    updateScienceRank: (context, payload) => {
        return new Promise(async (resolve, reject) => {
            let formData = new FormData();
            formData.append('rank_name', payload.rank_name);
            formData.append('_method', 'PUT')
            await axios.post('/api/science-ranks/' + payload.id, formData)
                .then((response) => {
                    resolve(response);
                })
                .catch((error) => {
                    reject(error);
                })
        })
    },
    deleteScienceRank: (context, id) => {
        return new Promise(async (resolve, reject) => {
            await axios.delete('/api/science-ranks/' + id)
                .then((response) => {
                    resolve(response);
                })
                .catch((error) => {
                    reject(error);
                })
        });
    }
};

export default {
    state,
    getters,
    mutations,
    actions,
};
