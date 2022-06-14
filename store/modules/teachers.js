const state = {
    teachers : [],
    selectedTeacher : null
};

const getters = {
    TEACHERS: state => {
        return state.teachers;
    },
    SELECTED_TEACHER: state => {
        return state.selectedTeacher;
    }
};

const mutations = {
    setTeachers(state, payload) {
        state.teachers = payload;
    },
    selectTeacher(state, payload) {
        state.selectedTeacher = payload;
    }
};

const actions = {
    loadAllTeachers: async (context) => {
        await axios.get('/api/teachers')
            .then((response) => {
                context.commit('setTeachers', response.data.data);
            })
    },
    addTeacher: (context, payload) => {
        return new Promise(async (resolve, reject) => {
            let formData = new FormData();
            formData.append('fio', payload.fio);
            formData.append('birth_date', payload.birth_date);
            formData.append('email', payload.email);
            formData.append('science_rank_id', payload.science_rank_id);
            formData.append('photo', payload.photo);
            await axios.post('/api/teachers', formData)
                .then((response) => {
                    resolve(response);
                })
                .catch((error) => {
                    reject(error);
                })
        })
    },
    loadTeacherById: (context, id) => {
        return new Promise(async (resolve, reject) => {
            await axios.get('/api/teachers/' + id)
                .then((response) => {
                    resolve(response);
                })
                .catch((error) => {
                    reject(error);
                })
        });
    },
    updateTeacher: (context, payload) => {
        return new Promise(async (resolve, reject) => {
            let formData = new FormData();
            formData.append('fio', payload.fio);
            formData.append('birth_date', payload.birth_date);
            formData.append('email', payload.email);
            formData.append('science_rank_id', payload.science_rank_id);
            formData.append('photo', payload.photo);
            formData.append('_method', 'PUT')
            await axios.post('/api/teachers/' + payload.id, formData)
                .then((response) => {
                    resolve(response);
                })
                .catch((error) => {
                    reject(error);
                })
        })
    },
    deleteTeacher: (context, id) => {
        return new Promise(async (resolve, reject) => {
            await axios.delete('/api/teachers/' + id)
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
