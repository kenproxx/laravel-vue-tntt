<template>
    <section class="content">
        <div class="container-fluid">
            <div class="row">

                <div class="col-12">

                    <div v-if="this.$gate.isAdmin()" class="card">
                        <div class="card-header">
                            <h3 class="card-title">Danh sách đoàn sinh</h3>

                            <div class="card-tools">

                                <button class="btn btn-sm btn-primary" type="button" @click="newModal">
                                    <i class="fa fa-plus-square"></i>
                                    Thêm mới
                                </button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Tên</th>
                                    <th>Email</th>
                                    <th>Cấp bậc</th>
                                    <th>Email Verified?</th>
                                    <th>Created</th>
                                    <th>Thao tác</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="user in users.data" :key="user.id">

                                    <td>{{ user.id }}</td>
                                    <td class="text-capitalize">{{ user.name }}</td>
                                    <td>{{ user.email }}</td>
                                    <td class="text-capitalize">{{ user.type }}</td>
                                    <td :inner-html.prop="user.email_verified_at | yesno"></td>
                                    <td>{{ user.created_at }}</td>

                                    <td>

                                        <a href="#" @click="editModal(user)">
                                            <i class="fa fa-edit blue"></i>
                                        </a>
                                        /
                                        <a href="#" @click="deleteUser(user.id)">
                                            <i class="fa fa-trash red"></i>
                                        </a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <pagination :data="users" @pagination-change-page="getResults"></pagination>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
            </div>


            <div v-if="!$gate.isAdmin()">
                <not-found></not-found>
            </div>

            <!-- Modal -->
            <div id="addNew" aria-hidden="true" aria-labelledby="addNew" class="modal fade" role="dialog" tabindex="-1">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 v-show="!editmode" class="modal-title">Create New User</h5>
                            <h5 v-show="editmode" class="modal-title">Update User's Info</h5>
                            <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <!-- <form @submit.prevent="createUser"> -->

                        <form @submit.prevent="editmode ? updateUser() : createUser()">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input v-model="form.name" :class="{ 'is-invalid': form.errors.has('name') }" class="form-control"
                                           name="name" type="text">
                                    <has-error :form="form" field="name"></has-error>
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input v-model="form.email" :class="{ 'is-invalid': form.errors.has('email') }" class="form-control"
                                           name="email" type="text">
                                    <has-error :form="form" field="email"></has-error>
                                </div>

                                <div class="form-group">
                                    <label>Password</label>
                                    <input v-model="form.password" :class="{ 'is-invalid': form.errors.has('password') }" autocomplete="false"
                                           class="form-control" name="password"
                                           type="password">
                                    <has-error :form="form" field="password"></has-error>
                                </div>

                                <div class="form-group">
                                    <label>User Role</label>
                                    <select id="type" v-model="form.type" :class="{ 'is-invalid': form.errors.has('type') }" class="form-control"
                                            name="type">
                                        <option value="">Select User Role</option>
                                        <option value="admin">Admin</option>
                                        <option value="user">Standard User</option>
                                    </select>
                                    <has-error :form="form" field="type"></has-error>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary" data-dismiss="modal" type="button">Đóng</button>
                                <button v-show="editmode" class="btn btn-success" type="submit">Update</button>
                                <button v-show="!editmode" class="btn btn-primary" type="submit">Create</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
export default {
    data() {
        return {
            editmode: false,
            users: {},
            form: new Form({
                id: '',
                type: '',
                name: '',
                email: '',
                password: '',
                email_verified_at: '',
            })
        }
    },
    methods: {

        getResults(page = 1) {

            this.$Progress.start();

            axios.get('api/user?page=' + page).then(({data}) => (this.users = data.data));

            this.$Progress.finish();
        },
        updateUser() {
            this.$Progress.start();
            // console.log('Editing data');
            this.form.put('api/user/' + this.form.id)
                .then((response) => {
                    // success
                    $('#addNew').modal('hide');
                    Toast.fire({
                        icon: 'success',
                        title: response.data.message
                    });
                    this.$Progress.finish();
                    //  Fire.$emit('AfterCreate');

                    this.loadUsers();
                })
                .catch(() => {
                    this.$Progress.fail();
                });

        },
        editModal(user) {
            this.editmode = true;
            this.form.reset();
            $('#addNew').modal('show');
            this.form.fill(user);
        },
        newModal() {
            this.editmode = false;
            this.form.reset();
            $('#addNew').modal('show');
        },
        deleteUser(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {

                // Send request to the server
                if (result.value) {
                    this.form.delete('api/user/' + id).then(() => {
                        Swal.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                        );
                        // Fire.$emit('AfterCreate');
                        this.loadUsers();
                    }).catch((data) => {
                        Swal.fire("Failed!", data.message, "warning");
                    });
                }
            })
        },
        loadUsers() {
            this.$Progress.start();

            if (this.$gate.isAdmin()) {
                axios.get("api/user").then(({data}) => (this.users = data.data));
            }

            this.$Progress.finish();
        },

        createUser() {

            this.form.post('api/user')
                .then((response) => {
                    $('#addNew').modal('hide');

                    Toast.fire({
                        icon: 'success',
                        title: response.data.message
                    });

                    this.$Progress.finish();
                    this.loadUsers();

                })
                .catch(() => {

                    Toast.fire({
                        icon: 'error',
                        title: 'Some error occured! Please try again'
                    });
                })
        }

    },
    mounted() {
        console.log('User Component mounted.')
    },
    created() {

        this.$Progress.start();
        this.loadUsers();
        this.$Progress.finish();
    }
}
</script>
