const state = {
    floors : []
};

const getters = {
    FLOORS: state => {
        return state.floors;
    }
};

const mutations = {
    setFloors(state, payload) {
        state.floors = payload;
    }
};

const actions = {
    loadAllFloors: async (context) => {
        await axios.get('/api/floors')
            .then((response) => {
                context.commit('setFloors', response.data.data);
            })
    },
    addFloor: (context, payload) => {
        return new Promise(async (resolve, reject) => {
            let formData = new FormData();
            formData.append('name', payload.name);
            formData.append('bounds', payload.bounds);
            await axios.post('/api/floors', formData)
                .then((response) => {
                    resolve(response);
                })
                .catch((error) => {
                    reject(error);
                })
        })
    },
    loadFloorById: (context, id) => {
        return new Promise(async (resolve, reject) => {
            await axios.get('/api/floors/' + id)
                .then((response) => {
                    resolve(response);
                })
                .catch((error) => {
                    reject(error);
                })
        });
    },
    updateFloor: (context, payload) => {
        return new Promise(async (resolve, reject) => {
            let formData = new FormData();
            formData.append('name', payload.name);
            formData.append('bounds', payload.bounds);
            formData.append('_method', 'PUT')
            await axios.post('/api/floors/' + payload.id, formData)
                .then((response) => {
                    resolve(response);
                })
                .catch((error) => {
                    reject(error);
                })
        })
    },
    deleteFloor: (context, id) => {
        return new Promise(async (resolve, reject) => {
            await axios.delete('/api/floors/' + id)
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
