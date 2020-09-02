const middleware = `${location.origin}/vue-crud/action.php`;
var app = new Vue({

    el: '#app',
    data: {
       errorMsg: "",
       successMsg: "",
       showAddModal: false,
       showEditModal: false,
       showDeleteModal: false,
       users:[],
       newUser:{ name: "", email: "", phone: ""},
       currentUser: {}
    },
    mounted: function(){
        this.getAllUsers();
    },
    methods: {

        getAllUsers() {
            axios.get(`${middleware}?action=read`).then(function(response) {
                if (response.data.error) { 
                    app.errorMsg = response.data.message;
                }
                else {
                    app.users = response.data.users;
                }
            });
        },

        addUser() {
            var formData= app.getFormData(app.newUser);
            axios.get(`${middleware}?action=create`).then(function(response) {
                app.newUser = { name: "", email: "", phone: ""};
                if (response.data.error) { 
                    app.errorMsg = response.data.message;
                }
                else {
                    app.successMsg  = response.data.message;
                    app.getAllUsers();
                }
            });
        },

        updateUser() {
            var formData= app.getFormData(app.currentUser);
            axios.get(`${middleware}?action=update`).then(function(response) {
                app.currentUser = {};
                if (response.data.error) { 
                    app.errorMsg = response.data.message;
                }
                else {
                    app.successMsg  = response.data.message;
                    app.getAllUsers();
                }
            });
        },

        deleteUser() {
            var formData= app.getFormData(app.currentUser);
            axios.get(`${middleware}?action=delete`).then(function(response) {
                app.currentUser = {};
                if (response.data.error) { 
                    app.errorMsg = response.data.message;
                }
                else {
                    app.successMsg  = response.data.message;
                    app.getAllUsers();
                }
            });
        },     

        getFormData(obj) {
            var fd = new FormData();
            for (var i in obj) {
                fd.append(i, obj[i]);
            }
            return fd;
        },
        selectUser(user){
            app.currentUser = user;

        },
        clearMsg() {
            app.errorMsg    = "";
            app.successMsg  = "";

        }

    }
});