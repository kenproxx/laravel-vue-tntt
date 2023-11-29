<template>

    <section class="content">
        <div class="container-fluid">
            <div class="row">

                <div class="col-12">

                    <div v-if="$gate.isAdmin()" class="card">
                        <div class="card-header">
                            <h3 class="card-title">Danh sách Địa chỉ</h3>

                            <div class="card-tools">

                                <button class="btn btn-sm btn-primary" type="button" @click="newModal">
                                    <i class="fa fa-plus-square"></i>
                                    Thêm mới
                                </button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <a-table
                                :bordered="true"
                                :columns="columns"
                                :data-source="listAddress"
                                :row-selection="rowSelection"
                                :expanded-row-keys.sync="expandedRowKeys">
<!--                                <template #action="{text, recode, index}">-->
<!--                                    <a href="#" @click="editModal(user)">-->
<!--                                        <i class="fa fa-edit blue"></i>-->
<!--                                    </a>-->
<!--                                    /-->
<!--                                    <a href="#" @click="deleteUser(user.id)">-->
<!--                                        <i class="fa fa-trash red"></i>-->
<!--                                    </a>-->
<!--                                </template>-->
                                <template v-slot:action>
                                    <a-dropdown>
                                        <a class="ant-dropdown-link" @click="e => e.preventDefault()">
                                            <a-icon type="menu"/>
                                        </a>
                                        <a-menu slot="overlay">
                                            <a-menu-item>
                                                <span @click="openModalAddUserAddress">Gắn user quản lý</span>
                                            </a-menu-item>
                                            <a-menu-item>
                                                <a href="javascript:;">Sửa địa chỉ</a>
                                            </a-menu-item>
                                            <a-menu-item>
                                                <a href="javascript:;">Xóa địa chỉ</a>
                                            </a-menu-item>
                                        </a-menu>
                                    </a-dropdown>
                                </template>
                            </a-table>
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
            <div id="addNew" aria-hidden="true" aria-labelledby="addNew" class="modal fade" role="dialog" tabindex="-1">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 v-show="!editmode" class="modal-title">Create New Tag</h5>
                            <h5 v-show="editmode" class="modal-title">Update Tag</h5>
                            <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <form @submit.prevent="editmode ? updateTag() : createTag()">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Tên</label>
                                    <input v-model="form.name"
                                           :class="{ 'is-invalid': form.errors.has('dien_giai') }" class="form-control"
                                           name="dien_giai" type="text">
                                    <has-error :form="form" field="dien_giai"></has-error>
                                </div>
                                <div class="form-group">
                                    <label>Địa chỉ cha</label>
                                    <a-tree-select
                                        v-model="form.parent_id"
                                        :dropdown-style="{ maxHeight: '400px', overflow: 'auto' }"
                                        :tree-data="treeData"
                                        placeholder="Please select"
                                        style="width: 100%"
                                        tree-default-expand-all
                                    >
                                    </a-tree-select>
                                    <has-error :form="form" field="code"></has-error>
                                </div>
                                <div class="form-group">
                                    <label>Cấp</label>
                                    <select v-model="form.cap"
                                            :class="{ 'is-invalid': form.errors.has('cap')} "
                                            class="custom-select"
                                            name="cap">
                                        <option v-for="add in CAP_BAC_DIA_CHI" :value="add">{{ add }}</option>
                                    </select>
                                    <has-error :form="form" field="cap"></has-error>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary" data-dismiss="modal" type="button">Đóng</button>
                                <button v-show="editmode" class="btn btn-success" data-dismiss="modal" type="submit">
                                    Update
                                </button>
                                <button v-show="!editmode" class="btn btn-primary" type="submit">Lưu</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <a-modal v-model:open="openModalAddUser" title="Basic Modal" >
                <a-select
                    v-model:value="value"
                    mode="tags"
                    style="width: 100%"
                    placeholder="Tags Mode"
                    :options="options"
                ></a-select>
            </a-modal>
        </div>
    </section>
</template>

<script>
import ATreeSelect from 'ant-design-vue/lib/tree-select';
import {CAP_BAC_DIA_CHI} from '../../const.js'
import {isEmpty} from "lodash";
import moment from "moment";
const options = [...Array(25)].map((_, i) => ({ value: (i + 10).toString(36) + (i + 1) }));

const rowSelection = {
    onChange: (selectedRowKeys, selectedRows) => {
        console.log(`selectedRowKeys: ${selectedRowKeys}`, 'selectedRows: ', selectedRows);
    },
    onSelect: (record, selected, selectedRows) => {
        console.log(record, selected, selectedRows);
    },
    onSelectAll: (selected, selectedRows, changeRows) => {
        console.log(selected, selectedRows, changeRows);
    },
};
export default {
    components: {'a-tree-select': ATreeSelect},

    data() {
        return {
            editmode: false,
            openModalAddUser: false,
            address: {},
            options: options,
            addressList: {},
            form: new Form({
                parent_id: '',
                name: '',
                cap: '',
            }),
            CAP_BAC_DIA_CHI: CAP_BAC_DIA_CHI,
            value: undefined,
            treeData: [],
            columns: [
                {
                    title: 'STT',
                    customRender: (text, record, index) => {
                        return index + 1;
                    },
                },
                {
                    title: 'Tên',
                    dataIndex: 'label',
                    key: 'label',
                },
                {
                    title: 'Cấp',
                    dataIndex: 'cap',
                    key: 'cap',
                },
                {
                    title: 'Nguời tạo',
                    dataIndex: 'created_by',
                    key: 'created_by',
                },
                {
                    title: 'Ngày tạo',
                    dataIndex: 'created_at',
                    key: 'created_at',
                    customRender: (text, record) => {
                        return moment(text).format('DD/MM/YYYY'); // Định dạng ngày tháng theo ý muốn
                    },
                },
                {
                    title: 'Nguời sửa',
                    dataIndex: 'updated_by',
                    key: 'updated_by',
                },
                {
                    title: 'Ngày sửa',
                    dataIndex: 'updated_at',
                    key: 'updated_at',
                    customRender: (text, record) => {
                        return moment(text).format('DD/MM/YYYY'); // Định dạng ngày tháng theo ý muốn
                    },
                },
                {
                    title: 'Thao tác',
                    dataIndex: 'action',
                    key: 'action',
                    scopedSlots: { customRender: 'action' },
                },

            ],
            listAddress: [],
            rowSelection,
            expandedRowKeys: [],
        }
    },
    methods: {
        convertKey(arrInput) {
            return arrInput.map(item => {
                let child = '';
                if (!isEmpty(item.children)) {
                    child = this.convertKey(item.children)
                    return {
                        children: child,
                        title: item.data,
                        key: item.id,
                        label: item.data,
                        value: item.id,
                        cap: item.cap,
                        created_by: item.created_by,
                        created_at: item.created_at,
                        updated_by: item.updated_by,
                        updated_at: item.updated_at,
                    }
                }
                return {
                    title: item.data,
                    key: item.id,
                    label: item.data,
                    value: item.id,
                    cap: item.cap,
                    created_by: item.created_by,
                    created_at: item.created_at,
                    updated_by: item.updated_by,
                    updated_at: item.updated_at,
                }
            });
        },
        updateTag() {
            this.$Progress.start();
            this.form.put('/api/address/' + this.form.id)
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
        editModal(tag) {
            this.editmode = true;
            this.form.reset();
            $('#addNew').modal('show');
            this.form.fill(tag);
        },
        newModal() {
            this.editmode = false;
            this.form.reset();
            $('#addNew').modal('show');
        },

        loadAddresses() {
            if (this.$gate.isAdmin()) {
                axios.get("/api/address").then((data) => {
                    let arr = data.data.data;
                    this.treeData = this.convertKey(Object.values(arr));
                    this.listAddress = this.treeData;
                })
                ;
            }
        },

        createTag() {

            this.form.post('/api/address')
                .then((response) => {
                    $('#addNew').modal('hide');

                    Toast.fire({
                        icon: 'success',
                        title: response.data.message
                    });

                    this.$Progress.finish();
                    this.loadAddresses();

                })
                .catch(() => {
                    Toast.fire({
                        icon: 'error',
                        title: 'Some error occured! Please try again'
                    });
                })
        },

        openModalAddUserAddress() {
            this.openModalAddUser = true;
        },

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
