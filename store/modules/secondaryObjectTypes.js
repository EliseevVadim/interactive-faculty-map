const state = {
    object_types: []
};

const getters = {
    OBJECT_TYPES: state => {
        return state.object_types;
    }
};

const mutations = {
    setObjectTypes(state, payload) {
        state.object_types = payload;
    }
};

const actions = {
    loadAllObjectTypes: async(context) => {
        await axios.get('/api/secondary-object-types')
            .then((response) => {
                context.commit('setObjectTypes', response.data.data);
            })
    },
    addObjectType: (context, payload) => {
        return new Promise(async (resolve, reject) => {
            let formData = new FormData();
            formData.append('object_type_name', payload.object_type_name);
            formData.append('type_path', payload.type_path);
            await axios.post('/api/secondary-object-types', formData)
                .then((response) => {
                    resolve(response);
                })
                .catch((error) => {
                    reject(error);
                })
        })
    },
    loadObjectTypeById: (context, id) => {
        return new Promise(async (resolve, reject) => {
            await axios.get('/api/secondary-object-types/' + id)
                .then((response) => {
                    resolve(response);
                })
                .catch((error) => {
                    reject(error);
                })
        });
    },
    updateObjectType: (context, payload) => {
        return new Promise(async (resolve, reject) => {
            let formData = new FormData();
            formData.append('object_type_name', payload.object_type_name);
            formData.append('type_path', payload.type_path);
            formData.append('_method', 'PUT')
            await axios.post('/api/secondary-object-types/' + payload.id, formData)
                .then((response) => {
                    resolve(response);
                })
                .catch((error) => {
                    reject(error);
                })
        })
    },
    deleteObjectType: (context, id) => {
        return new Promise(async (resolve, reject) => {
            await axios.delete('/api/secondary-object-types/' + id)
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
