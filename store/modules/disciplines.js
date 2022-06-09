const state = {
    disciplines : []
};

const getters = {
    DISCIPLINES: state => {
        return state.disciplines;
    }
};

const mutations = {
    setDisciplines(state, payload) {
        state.disciplines = payload;
    }
};

const actions = {
    loadAllDisciplines: async (context) => {
        await axios.get('/api/disciplines')
            .then((response) => {
                context.commit('setDisciplines', response.data.data);
            })
    },
    addDiscipline: (context, payload) => {
        return new Promise(async (resolve, reject) => {
            let formData = new FormData();
            formData.append('discipline_name', payload.discipline_name);
            await axios.post('/api/disciplines', formData)
                .then((response) => {
                    resolve(response);
                })
                .catch((error) => {
                    reject(error);
                })
        })
    },
    loadDisciplineById: (context, id) => {
        return new Promise(async (resolve, reject) => {
            await axios.get('/api/disciplines/' + id)
                .then((response) => {
                    resolve(response);
                })
                .catch((error) => {
                    reject(error);
                })
        });
    },
    updateDiscipline: (context, payload) => {
        return new Promise(async (resolve, reject) => {
            let formData = new FormData();
            formData.append('discipline_name', payload.discipline_name);
            formData.append('_method', 'PUT')
            console.log(formData);
            await axios.post('/api/disciplines/' + payload.id, formData)
                .then((response) => {
                    resolve(response);
                })
                .catch((error) => {
                    reject(error);
                })
        })
    },
    deleteDiscipline: (context, id) => {
        return new Promise(async (resolve, reject) => {
            await axios.delete('/api/disciplines/' + id)
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
