const state = {
    teachers_disciplines: []
};

const getters = {
    TEACHERS_DISCIPLINES: state => {
        return state.teachers_disciplines;
    }
};

const mutations = {
    setTeachersDisciplines(state, payload) {
        state.teachers_disciplines = payload;
    }
};

const actions = {
    loadAllTeachersDisciplines: async(context) => {
        await axios.get('/api/teachers-disciplines')
            .then((response) => {
                context.commit('setTeachersDisciplines', response.data.data);
            })
    },
    addTeacherDiscipline: (context, payload) => {
        return new Promise(async (resolve, reject) => {
            let formData = new FormData();
            formData.append('discipline_id', payload.discipline_id);
            formData.append('teacher_id', payload.teacher_id);
            await axios.post('/api/teachers-disciplines', formData)
                .then((response) => {
                    resolve(response);
                })
                .catch((error) => {
                    reject(error);
                })
        })
    },
    loadTeacherDisciplineById: (context, id) => {
        return new Promise(async (resolve, reject) => {
            await axios.get('/api/teachers-disciplines/' + id)
                .then((response) => {
                    resolve(response);
                })
                .catch((error) => {
                    reject(error);
                })
        });
    },
    updateTeacherDiscipline: (context, payload) => {
        return new Promise(async (resolve, reject) => {
            let formData = new FormData();
            formData.append('discipline_id', payload.discipline_id);
            formData.append('teacher_id', payload.teacher_id);
            formData.append('_method', 'PUT')
            await axios.post('/api/teachers-disciplines/' + payload.id, formData)
                .then((response) => {
                    resolve(response);
                })
                .catch((error) => {
                    reject(error);
                })
        })
    },
    deleteTeacherDiscipline: (context, id) => {
        return new Promise(async (resolve, reject) => {
            await axios.delete('/api/teachers-disciplines/' + id)
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
