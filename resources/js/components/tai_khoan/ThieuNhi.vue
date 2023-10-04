<template>
    <section class="content">
        <div class="container-fluid">
            <div class="row">

                <div class="col-12">

                    <div v-if="this.$gate.isAdmin()">
                        <a-card style="margin-bottom: 25px">
                            <a-form class="ant-advanced-search-form" layout="inline" :form="form"
                                    @submit="handleSearch">
                                <a-row :gutter="24">
                                    <a-col
                                        v-for="i in 10"
                                        :key="i"
                                        :span="8"
                                        :style="{ display: i < count ? 'block' : 'none' }"
                                    >
                                        <a-form-item addonBefore="true" :label="`Field ${i}`">
                                            <a-input
                                                placeholder="placeholder"
                                            />
                                        </a-form-item>
                                    </a-col>
                                </a-row>
                                <a-row>
                                    <a-col :span="24" :style="{ textAlign: 'right' }">
                                        <a-button type="primary" html-type="submit">
                                            Search
                                        </a-button>
                                        <a-button :style="{ marginLeft: '8px' }" @click="handleReset">
                                            Clear
                                        </a-button>
                                        <a :style="{ marginLeft: '8px', fontSize: '12px' }" @click="toggle">
                                            Collapse
                                            <a-icon :type="expand ? 'up' : 'down'"/>
                                        </a>
                                    </a-col>
                                </a-row>
                            </a-form>
                        </a-card>

                        <a-card title="Danh sách đoàn sinh">
                            <a-button type="primary" @click="newModal"><i class="fa fa-plus-square"></i> Thêm mới
                            </a-button>
                            <a-table :columns="columns" :data-source="users.data.data"
                                     :scroll="{ x: 1500, y: 300 }">
                                <a slot="stt" slot-scope="text, record, index">{{ index + 1 }}</a>
                                <a slot="action" slot-scope="text, record, index">
                                    <a-dropdown>
                                        <a class="ant-dropdown-link" @click="e => e.preventDefault()">
                                            <a-icon type="menu"/>
                                        </a>
                                        <a-menu slot="overlay">
                                            <a-menu-item>
                                                <router-link
                                                    :to="{ name: 'SuaTaiKhoan', params: { userId: record.id } }">
                                                    Cập nhật thông tin
                                                </router-link>
                                            </a-menu-item>
                                            <a-menu-item>
                                                <a href="javascript:;">Thay đổi mật khẩu</a>
                                            </a-menu-item>
                                            <a-menu-item>
                                                <a href="javascript:;">3rd menu item</a>
                                            </a-menu-item>
                                        </a-menu>
                                    </a-dropdown>
                                </a>
                            </a-table>

                        </a-card>
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
                                    <input v-model="form.name" :class="{ 'is-invalid': form.errors.has('name') }"
                                           class="form-control"
                                           name="name" type="text">
                                    <has-error :form="form" field="name"></has-error>
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input v-model="form.email" :class="{ 'is-invalid': form.errors.has('email') }"
                                           class="form-control"
                                           name="email" type="text">
                                    <has-error :form="form" field="email"></has-error>
                                </div>

                                <div class="form-group">
                                    <label>Password</label>
                                    <input v-model="form.password"
                                           :class="{ 'is-invalid': form.errors.has('password') }" autocomplete="false"
                                           class="form-control" name="password"
                                           type="password">
                                    <has-error :form="form" field="password"></has-error>
                                </div>

                                <div class="form-group">
                                    <label>User Role</label>
                                    <select id="type" v-model="form.type"
                                            :class="{ 'is-invalid': form.errors.has('type') }" class="form-control"
                                            name="type">
                                        <option value="">Select User Role</option>
                                        <option value="admin">Admin</option>
                                        <option value="user">Standard User</option>
                                    </select>
                                    <has-error :form="form" field="type"></has-error>
                                </div>
                                <div class="form-group">
                                    <label>Trạng thái</label>
                                    <select id="status" v-model="form.status"
                                            :class="{ 'is-invalid': form.errors.has('status') }" class="form-control"
                                            name="status">
                                        <option :value="ACTIVE" selected>{{ ACTIVE }}</option>
                                        <option :value="INACTIVE">{{ INACTIVE }}</option>
                                    </select>
                                    <has-error :form="form" field="status"></has-error>
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
            expand: false,
            form: new Form({
                id: '',
                type: '',
                name: '',
                email: '',
                password: '',
                email_verified_at: '',
                status: '',
            }),
            // ACTIVE: this.$status.ACTIVE,
            ACTIVE: 1,
            INACTIVE: 2,
            columns: [
                {
                    title: 'STT',
                    width: 100,
                    key: 'stt',
                    scopedSlots: {customRender: 'stt'},
                    fixed: 'left',
                    align: 'center'
                },
                {title: 'Tên Thánh', width: 100, dataIndex: 'ten_thanh', key: 'name', fixed: 'left'},
                {title: 'Tên gọi', width: 100, dataIndex: 'name', key: 'age', fixed: 'left'},
                {title: 'Lớp', dataIndex: 'lop_hoc_id', key: '5', width: 150},
                {title: 'Ngành', dataIndex: 'address', key: '6', width: 150},
                {title: 'Email', dataIndex: 'email', key: '7', width: 150},
                {title: 'SDT', dataIndex: 'so_dien_thoai', key: '8', width: 150},
                {
                    title: 'Thao tác',
                    key: 'operation',
                    fixed: 'right',
                    width: 100,
                    scopedSlots: {customRender: 'action'},
                    align: 'center'
                },
            ]
        }
    },
    computed: {
        count() {
            return this.expand ? 11 : 7;
        },
    },
    methods: {
        handleSearch(e) {
            e.preventDefault();
            this.form.validateFields((error, values) => {
                console.log('error', error);
                console.log('Received values of form: ', values);
            });
        },

        handleReset() {
            this.form.resetFields();
        },

        toggle() {
            this.expand = !this.expand;
        },
        getResults(page = 1) {

            this.$Progress.start();

            axios.get('api/user?page=' + page).then(({data}) => (this.users = data.data));

            this.$Progress.finish();
        },
        updateUser() {
            this.$Progress.start();
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
                axios.get("api/user").then((data) => {
                    this.users = data.data;
                })
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
    },
    created() {
        this.$Progress.start();
        this.loadUsers();
        this.$Progress.finish();
    }
}
</script>
