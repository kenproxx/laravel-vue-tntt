<template>
    <section class="content">
        <div class="container-fluid">
            <div class="row">

                <div class="col-12">

                    <div v-if="$gate.isAdmin()" class="card">
                        <div class="card-header">
                            <h3 class="card-title">Danh sách Tham số</h3>

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
                                    <th>Name</th>
                                    <th>Loại</th>
                                    <th>Ngày tạo</th>
                                    <th>Thao tác</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="category in categories.data" :key="category.id">

                                    <td>{{ category.id }}</td>
                                    <td class="text-capitalize">{{ category.name }}</td>
                                    <td>{{ category.loai }}</td>
                                    <td>{{ category.created_at }}</td>
                                    <td>

                                        <a href="#" @click="editModal(category)">
                                            <i class="fa fa-edit blue"></i>
                                        </a>
                                        /
                                        <a href="#" @click="deleteCate(category.id)">
                                            <i class="fa fa-trash red"></i>
                                        </a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <pagination :data="categories" @pagination-change-page="getResults"></pagination>
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
                            <h5 v-show="!editmode" class="modal-title">Tạo mới</h5>
                            <h5 v-show="editmode" class="modal-title">Sửa</h5>
                            <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <!-- <form @submit.prevent="createUser"> -->

                        <form @submit.prevent="editmode ? updateCategory() : createCategory()">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Tên</label>
                                    <input v-model="form.name" :class="{ 'is-invalid': form.errors.has('name') }" class="form-control"
                                           name="name" type="text">
                                    <has-error :form="form" field="name"></has-error>
                                </div>
                                <div class="form-group">
                                    <label>Loại</label>
                                    <input v-model="form.loai" :class="{ 'is-invalid': form.errors.has('loai') }" class="form-control"
                                           name="loai" type="text">
                                    <has-error :form="form" field="loai"></has-error>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary" data-dismiss="modal" type="button">Đóng</button>
                                <button v-show="editmode" class="btn btn-success" type="submit">Cập nhật</button>
                                <button v-show="!editmode" class="btn btn-primary" type="submit">Lưu</button>
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
            categories: {},
            form: new Form({
                id: '',
                name: '',
                loai: '',
            })
        }
    },
    methods: {

        getResults(page = 1) {

            this.$Progress.start();

            axios.get('/api/category?page=' + page).then(({data}) => (this.categories = data.data));

            this.$Progress.finish();
        },
        updateCategory() {
            this.$Progress.start();
            this.form.put('/api/category/' + this.form.id)
                .then((response) => {
                    // success
                    $('#addNew').modal('hide');
                    Toast.fire({
                        icon: 'success',
                        title: response.data.message
                    });
                    this.$Progress.finish();
                    //  Fire.$emit('AfterCreate');

                    this.loadCategories();
                })
                .catch(() => {
                    this.$Progress.fail();
                });

        },
        editModal(category) {
            this.editmode = true;
            this.form.reset();
            $('#addNew').modal('show');
            this.form.fill(category);
        },
        newModal() {
            this.editmode = false;
            this.form.reset();
            $('#addNew').modal('show');
        },

        loadCategories() {
            if (this.$gate.isAdmin()) {
                axios.get("/api/category").then(({data}) => (this.categories = data.data));
            }
        },
        deleteCate(id) {
            Swal.fire({
                title: 'Bạn có chắc chắn không?',
                text: "Bạn sẽ không thể khôi phục lại!",
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Có',
                cancelButtonText: 'Hủy',
            }).then((result) => {

                if (result.value) {
                    axios.delete("/api/category/" + id).then((data) => {
                        Swal.fire(
                            'Thành công',
                            'Tham số đã được xóa',
                            'success'
                        );
                        this.loadCategories();
                    }).catch((data) => {
                        Swal.fire("Thất bại!", data.message, "warning");
                    });
                }
            })
        },

        createCategory() {

            this.form.post('/api/category')
                .then((response) => {
                    $('#addNew').modal('hide');

                    Toast.fire({
                        icon: 'success',
                        title: response.data.message
                    });

                    this.$Progress.finish();
                    this.loadCategories();
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
        console.log('Component mounted.')
    },
    created() {

        this.$Progress.start();
        this.loadCategories();
        this.$Progress.finish();
    }
}
</script>
