const state = {
    auditoriums : []
};

const getters = {
    AUDITORIUMS: state => {
        return state.auditoriums;
    }
};

const mutations = {
    setAuditoriums(state, payload) {
        state.auditoriums = payload;
    }
};

const actions = {
    loadAllAuditoriums: async (context) => {
        await axios.get('/api/auditoriums')
            .then((response) => {
                context.commit('setAuditoriums', response.data.data);
            })
    },
    addAuditorium: (context, payload) => {
        return new Promise(async (resolve, reject) => {
            let formData = new FormData();
            formData.append('auditorium_name', payload.auditorium_name);
            formData.append('position_info', JSON.stringify(payload.position_info));
            formData.append('floor_id', payload.floor_id);
            formData.append('holder_id', payload.holder_id);
            await axios.post('/api/auditoriums', formData)
                .then((response) => {
                    resolve(response);
                })
                .catch((error) => {
                    reject(error);
                })
        })
    },
    loadAuditoriumById: (context, id) => {
        return new Promise(async (resolve, reject) => {
            await axios.get('/api/auditoriums/' + id)
                .then((response) => {
                    resolve(response);
                })
                .catch((error) => {
                    reject(error);
                })
        });
    },
    updateAuditorium: (context, payload) => {
        return new Promise(async (resolve, reject) => {
            let formData = new FormData();
            formData.append('auditorium_name', payload.auditorium_name);
            formData.append('position_info', JSON.stringify(payload.position_info));
            formData.append('floor_id', payload.floor_id);
            formData.append('holder_id', payload.holder_id);
            formData.append('_method', 'PUT')
            console.log(formData);
            await axios.post('/api/auditoriums/' + payload.id, formData)
                .then((response) => {
                    resolve(response);
                })
                .catch((error) => {
                    reject(error);
                })
        })
    },
    deleteAuditorium: (context, id) => {
        return new Promise(async (resolve, reject) => {
            await axios.delete('/api/auditoriums/' + id)
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
