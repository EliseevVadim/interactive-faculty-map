const state = {
    pairInfos : []
};

const getters = {
    PAIR_INFOS: state => {
        return state.pairInfos;
    }
};

const mutations = {
    setPairInfos(state, payload) {
        state.pairInfos = payload;
    }
};

const actions = {
    loadAllPairInfos: async (context) => {
        await axios.get('/api/pair-infos')
            .then((response) => {
                context.commit('setPairInfos', response.data.data);
            })
    },
    addPairInfo: (context, payload) => {
        return new Promise(async (resolve, reject) => {
            let formData = new FormData();
            formData.append('pair_number', payload.pair_number);
            formData.append('start_time', payload.start_time);
            formData.append('end_time', payload.end_time);
            await axios.post('/api/pair-infos', formData)
                .then((response) => {
                    resolve(response);
                })
                .catch((error) => {
                    reject(error);
                })
        })
    },
    loadPairInfoById: (context, id) => {
        return new Promise(async (resolve, reject) => {
            await axios.get('/api/pair-infos/' + id)
                .then((response) => {
                    resolve(response);
                })
                .catch((error) => {
                    reject(error);
                })
        });
    },
    updatePairInfo: (context, payload) => {
        return new Promise(async (resolve, reject) => {
            let formData = new FormData();
            formData.append('pair_number', payload.pair_number);
            formData.append('start_time', payload.start_time);
            formData.append('end_time', payload.end_time);
            formData.append('_method', 'PUT')
            await axios.post('/api/pair-infos/' + payload.id, formData)
                .then((response) => {
                    resolve(response);
                })
                .catch((error) => {
                    reject(error);
                })
        })
    },
    deletePairInfo: (context, id) => {
        return new Promise(async (resolve, reject) => {
            await axios.delete('/api/pair-infos/' + id)
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
