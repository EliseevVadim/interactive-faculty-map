const state = {
    courses : []
};

const getters = {
    COURSES: state => {
        return state.courses;
    }
};

const mutations = {
    setCourses(state, payload) {
        state.courses = payload;
    }
};

const actions = {
    loadAllCourses: async (context) => {
        await axios.get('/api/courses')
            .then((response) => {
                context.commit('setCourses', response.data.data);
            })
    },
    addCourse: (context, payload) => {
        return new Promise(async (resolve, reject) => {
            let formData = new FormData();
            formData.append('course_name', payload.course_name);
            formData.append('course_number', payload.course_number);
            await axios.post('/api/courses', formData)
                .then((response) => {
                    resolve(response);
                })
                .catch((error) => {
                    reject(error);
                })
        })
    },
    loadCourseById: (context, id) => {
        return new Promise(async (resolve, reject) => {
            await axios.get('/api/courses/' + id)
                .then((response) => {
                    resolve(response);
                })
                .catch((error) => {
                    reject(error);
                })
        });
    },
    updateCourse: (context, payload) => {
        return new Promise(async (resolve, reject) => {
            let formData = new FormData();
            formData.append('course_name', payload.course_name);
            formData.append('course_number', payload.course_number);
            formData.append('_method', 'PUT')
            await axios.post('/api/courses/' + payload.id, formData)
                .then((response) => {
                    resolve(response);
                })
                .catch((error) => {
                    reject(error);
                })
        })
    },
    deleteCourse: (context, id) => {
        return new Promise(async (resolve, reject) => {
            await axios.delete('/api/courses/' + id)
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
