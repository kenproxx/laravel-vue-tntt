<template>
  <section class="content">
    <div class="container-fluid">
        <div class="row">

          <div class="col-12">

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Danh sách tham số</h3>

                <div class="card-tools" >

                  <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#addProduct">
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
                      <th>ID</th>
                      <th>Tên</th>
                      <th>Loại</th>
                      <th>Thao tác</th>
                    </tr>
                  </thead>
                  <tbody>
                     <tr v-for="product in products.data" :key="product.id">

                      <td>{{product.id}}</td>
                      <td>{{product.name}}</td>
                      <td>{{product.loai | truncate(30, '...')}}</td>
                      <td>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNew" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Create New Product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form @submit.prevent="createProduct">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Tên</label>
                            <input v-model="form.name" type="text" name="name"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                            <has-error :form="form" field="name"></has-error>
                        </div>
                        <div class="form-group">
                            <label>Loại</label>
                            <input v-model="form.description" type="text" name="loai"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('loai') }">
                            <has-error :form="form" field="loai"></has-error>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Lưu</button>
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
        data () {
            return {
              categories : {},
              // Create a new form instance
              form: new Form({
                  id : '',
                  name: '',
                  description: '',
              })
            }
        },
        methods: {

          loadCategories(){
            // if(this.$gate.isAdmin()){
              axios.get("api/category").then(({ data }) => (this.categories = data.data));
            // }
          },

          createCategory(){
              this.$Progress.start();

              this.form.post('api/category')
              .then((data)=>{
                  $('#addNew').modal('hide');

                  Toast.fire({
                        icon: 'success',
                        title: data.data.message
                    });
                  this.$Progress.finish();
                  this.loadCategories();

              })
              .catch(()=>{

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

            this.loadCategories();

            this.$Progress.finish();
        }
    }
</script>
