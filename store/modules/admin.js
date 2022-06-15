const state = {
    user: {
        name: "",
        id: null
    }
};

const getters = {
    USER: state => {
        return state.user;
    }
};

const mutations = {
    setName: function (state, name) {
        state.user.name = name;
        localStorage.setItem('username', name);
    },
    removeName: function (state) {
        state.user.name = "";
        localStorage.removeItem('username');
    },
    setId: function (state, id) {
        state.user.id = id;
        localStorage.setItem('userId', id);
    },
    removeId: function (state) {
        state.user.id = null;
        localStorage.removeItem('userId');
    },
};

const actions = {
    login: function (context, authData) {
        let formData = new FormData();
        formData.append('email', authData.email);
        formData.append('password', authData.password);
        return new Promise((resolve, reject) => {
            axios.post('/authorizeToAdminPanel', formData)
                .then(response => {
                    context.commit('setName', response.data.data.name);
                    context.commit('setId', response.data.data.id);
                    window.location.href = '/adminPanel';
                })
                .catch(error => {
                    reject(error);
                })
        })
    },
    logout: function (context) {
        axios.get('/logout')
            .then(() => {
                context.commit('removeName');
                context.commit('removeId');
                window.location.href = "/adminAuthorization";
            })
    }
};

export default {
    state,
    getters,
    mutations,
    actions,
};
