const state = {
    pairs: []
};

const getters = {
    PAIRS: state => {
        return state.pairs;
    }
};

const mutations = {
    setPairs(state, payload) {
        state.pairs = payload;
    }
};

const actions = {
    loadAllPairs: async(context) => {
        await axios.get('/api/pairs')
            .then((response) => {
                context.commit('setPairs', response.data.data);
            })
    },
    addPair: (context, payload) => {
        return new Promise(async (resolve, reject) => {
            let formData = new FormData();
            formData.append('pair_name', payload.pair_name);
            formData.append('pair_info_id', payload.pair_info_id);
            formData.append('teacher_id', payload.teacher_id);
            formData.append('auditorium_id', payload.auditorium_id);
            formData.append('discipline_id', payload.discipline_id);
            formData.append('day_of_week_id', payload.day_of_week_id);
            formData.append('repeating_id', payload.repeating_id);
            await axios.post('/api/pairs', formData)
                .then((response) => {
                    resolve(response);
                })
                .catch((error) => {
                    reject(error);
                })
        })
    },
    loadPairById: (context, id) => {
        return new Promise(async (resolve, reject) => {
            await axios.get('/api/pairs/' + id)
                .then((response) => {
                    resolve(response);
                })
                .catch((error) => {
                    reject(error);
                })
        });
    },
    updatePair: (context, payload) => {
        return new Promise(async (resolve, reject) => {
            let formData = new FormData();
            formData.append('pair_name', payload.pair_name);
            formData.append('pair_info_id', payload.pair_info_id);
            formData.append('teacher_id', payload.teacher_id);
            formData.append('auditorium_id', payload.auditorium_id);
            formData.append('discipline_id', payload.discipline_id);
            formData.append('day_of_week_id', payload.day_of_week_id);
            formData.append('repeating_id', payload.repeating_id);
            formData.append('_method', 'PUT')
            console.log(formData);
            await axios.post('/api/pairs/' + payload.id, formData)
                .then((response) => {
                    resolve(response);
                })
                .catch((error) => {
                    reject(error);
                })
        })
    },
    deletePair: (context, id) => {
        return new Promise(async (resolve, reject) => {
            await axios.delete('/api/pairs/' + id)
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
