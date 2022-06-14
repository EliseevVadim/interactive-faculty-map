const state = {
    secondaryObjects : []
};

const getters = {
    SECONDARY_OBJECTS: state => {
        return state.secondaryObjects;
    }
};

const mutations = {
    setSecondaryObjects(state, payload) {
        state.secondaryObjects = payload;
    }
};

const actions = {
    loadAllSecondaryObjects: async (context) => {
        await axios.get('/api/secondary-objects')
            .then((response) => {
                context.commit('setSecondaryObjects', response.data.data);
            })
    },
    addSecondaryObject: (context, payload) => {
        return new Promise(async (resolve, reject) => {
            let formData = new FormData();
            formData.append('object_name', payload.object_name);
            formData.append('position_info', JSON.stringify(payload.position_info));
            formData.append('floor_id', payload.floor_id);
            formData.append('object_type_id', payload.object_type_id);
            await axios.post('/api/secondary-objects', formData)
                .then((response) => {
                    resolve(response);
                })
                .catch((error) => {
                    reject(error);
                })
        })
    },
    loadSecondaryObjectById: (context, id) => {
        return new Promise(async (resolve, reject) => {
            await axios.get('/api/secondary-objects/' + id)
                .then((response) => {
                    resolve(response);
                })
                .catch((error) => {
                    reject(error);
                })
        });
    },
    updateSecondaryObject: (context, payload) => {
        return new Promise(async (resolve, reject) => {
            let formData = new FormData();
            formData.append('object_name', payload.object_name);
            formData.append('position_info', JSON.stringify(payload.position_info));
            formData.append('floor_id', payload.floor_id);
            formData.append('object_type_id', payload.object_type_id);
            formData.append('_method', 'PUT')
            await axios.post('/api/secondary-objects/' + payload.id, formData)
                .then((response) => {
                    resolve(response);
                })
                .catch((error) => {
                    reject(error);
                })
        })
    },
    deleteSecondaryObject: (context, id) => {
        return new Promise(async (resolve, reject) => {
            await axios.delete('/api/secondary-objects/' + id)
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
