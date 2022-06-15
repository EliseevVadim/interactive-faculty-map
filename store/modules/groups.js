const state = {
    groups : []
};

const getters = {
    GROUPS: state => {
        return state.groups;
    }
};

const mutations = {
    setGroups(state, payload) {
        state.groups = payload;
    }
};

const actions = {
    loadAllGroups: async (context) => {
        await axios.get('/api/groups')
            .then((response) => {
                context.commit('setGroups', response.data.data);
            })
    },
    addGroup: (context, payload) => {
        return new Promise(async (resolve, reject) => {
            let formData = new FormData();
            formData.append('group_name', payload.group_name);
            formData.append('course_id', payload.course_id);
            await axios.post('/api/groups', formData)
                .then((response) => {
                    resolve(response);
                })
                .catch((error) => {
                    reject(error);
                })
        })
    },
    loadGroupById: (context, id) => {
        return new Promise(async (resolve, reject) => {
            await axios.get('/api/groups/' + id)
                .then((response) => {
                    resolve(response);
                })
                .catch((error) => {
                    reject(error);
                })
        });
    },
    updateGroup: (context, payload) => {
        return new Promise(async (resolve, reject) => {
            let formData = new FormData();
            formData.append('group_name', payload.group_name);
            formData.append('course_id', payload.course_id);
            formData.append('_method', 'PUT')
            await axios.post('/api/groups/' + payload.id, formData)
                .then((response) => {
                    resolve(response);
                })
                .catch((error) => {
                    reject(error);
                })
        })
    },
    deleteGroup: (context, id) => {
        return new Promise(async (resolve, reject) => {
            await axios.delete('/api/groups/' + id)
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
