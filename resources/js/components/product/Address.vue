<template>

    <section class="content">
    <div class="container-fluid">
        <div class="row">

          <div class="col-12">

            <div class="card" v-if="$gate.isAdmin()">
              <div class="card-header">
                <h3 class="card-title">Danh sách Địa chỉ</h3>

                <div class="card-tools">

                  <button type="button" class="btn btn-sm btn-primary" @click="newModal">
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
                      <th>Thao tác</th>
                    </tr>
                  </thead>
                  <tbody>
                     <tr v-for="add in address" :key="add.id">

                      <td>{{add.id}}</td>
                      <td>{{add.dien_giai}}</td>
                      <td>

                        <a href="#" @click="editModal(add)">
                            <i class="fa fa-edit blue"></i>
                        </a>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
<!--              <div class="card-footer">-->
<!--                  <pagination :data="address" @pagination-change-page="getResults"></pagination>-->
<!--              </div>-->
            </div>
            <!-- /.card -->
          </div>
        </div>


        <div v-if="!$gate.isAdmin()">
            <not-found></not-found>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNew" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" v-show="!editmode">Create New Tag</h5>
                    <h5 class="modal-title" v-show="editmode">Update Tag</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form @submit.prevent="editmode ? updateTag() : createTag()">
                    <div class="modal-body">
                        <div class="form-group">
                            <a-tree-select
                                v-model="value"
                                show-search
                                style="width: 100%"
                                :dropdown-style="{ maxHeight: '400px', overflow: 'auto' }"
                                placeholder="Please select"
                                allow-clear
                                tree-default-expand-all
                            >
                                <a-tree-select-node key="0-1" value="parent 1" title="parent 1">
                                    <a-tree-select-node key="0-1-1" value="parent 1-0" title="parent 1-0">
                                        <a-tree-select-node key="random" :selectable="false" value="leaf1" title="my leaf" />
                                        <a-tree-select-node key="random1" value="leaf2" title="your leaf" />
                                    </a-tree-select-node>
                                    <a-tree-select-node key="random2" value="parent 1-1" title="parent 1-1">
                                        <a-tree-select-node key="random3" value="sss">
                                            <b slot="title" style="color: #08c">sss</b>
                                        </a-tree-select-node>
                                    </a-tree-select-node>
                                </a-tree-select-node>
                            </a-tree-select>
                        </div>
                        <div class="form-group">
                            <label>Tên</label>
                            <input v-model="form.dien_giai" type="text" name="dien_giai"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('dien_giai') }">
                            <has-error :form="form" field="dien_giai"></has-error>
                        </div>
                        <div class="form-group">
                            <label>Địa chỉ cha</label>
                            <select :class="{ 'is-invalid': form.errors.has('code')} "
                                    class="custom-select"
                                    name="code"
                                    v-model="form.code">
                                <option value="VN" selected>Không</option>
                                <option v-for="add in address" :value="add.id">{{ add.dien_giai }}</option>
                            </select>
                            <has-error :form="form" field="code"></has-error>
                        </div>
                        <div class="form-group">
                            <label>Cấp</label>
                            <select :class="{ 'is-invalid': form.errors.has('cap')} "
                                    class="custom-select"
                                    name="cap"
                                    v-model="form.cap">
                                <option v-for="add in CAP_BAC_DIA_CHI" :value="add">{{ add }}</option>
                            </select>
                            <has-error :form="form" field="cap"></has-error>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        <button v-show="editmode" type="submit" class="btn btn-success" data-dismiss="modal">Update</button>
                        <button v-show="!editmode" type="submit" class="btn btn-primary">Lưu</button>
                    </div>
                  </form>
                </div>
            </div>
        </div>
    </div>
  </section>
</template>

<script>
import ATreeSelect from 'ant-design-vue/lib/tree-select';
import { CAP_BAC_DIA_CHI } from '../../const.js'
    export default {
    components: {'a-tree-select': ATreeSelect},

        data () {
            return {
                editmode: false,
                address : {},
                addressList : {},
                form: new Form({
                    code: '',
                    dien_giai: '',
                    cap: '',
                }),
                CAP_BAC_DIA_CHI: CAP_BAC_DIA_CHI,
                treeExpandedKeys: [],
                value: undefined,
            }
        },
        methods: {

            getResults(page = 1) {

                  this.$Progress.start();

                  axios.get('/api/address?page=' + page).then(({ data }) => (this.address = data.data));

                  this.$Progress.finish();
            },
            updateTag(){
                this.$Progress.start();
                this.form.put('/api/address/'+this.form.id)
                .then((response) => {
                    // success
                    $('#addNew').modal('hide');
                    Toast.fire({
                      icon: 'success',
                      title: response.data.message
                    });
                    this.$Progress.finish();

                    this.loadAddresses();
                })
                .catch(() => {
                    this.$Progress.fail();
                });

            },
            editModal(tag){
                this.editmode = true;
                this.form.reset();
                $('#addNew').modal('show');
                this.form.fill(tag);
            },
            newModal(){
                this.editmode = false;
                this.form.reset();
                $('#addNew').modal('show');
            },

            loadAddresses(){
                if(this.$gate.isAdmin()){
                    axios.get("/api/address").then(({ data }) => (this.address = data.data));
                }
            },

            createTag(){

                this.form.post('/api/address')
                .then((response)=>{
                    $('#addNew').modal('hide');

                    Toast.fire({
                            icon: 'success',
                            title: response.data.message
                    });

                    this.$Progress.finish();
                    this.loadAddresses();

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
            console.log('Component mounted.')
        },
        created() {

            this.$Progress.start();
            this.loadAddresses();
            this.$Progress.finish();
        }
    }
</script>
