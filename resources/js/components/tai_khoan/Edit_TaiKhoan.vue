<style scoped>
.ant-input-number {
    width: 100%;
}
</style>

<template>
    <div class="content">
        <a-form :form="form" :label-col="{ span: 12 }" :wrapper-col="{ span: 12 }" @submit="handleSubmit">
            <a-collapse v-model="activeKey">
                <a-collapse-panel key="1" header="Thông tin cá nhân">
                    <a-row :gutter="gutter">
                        <a-col :span="colSpan_3">
                            <a-form-item label="Tên Thánh">
                                <a-input :v-model="form.ten_thanh" placeholder="Vui lòng nhập" allowClear/>
                            </a-form-item>
                        </a-col>
                        <a-col :span="colSpan_3">
                            <a-form-item label="Tên gọi">
                                <a-input :v-model="form.ten_goi" placeholder="Vui lòng nhập" allowClear/>
                            </a-form-item>
                        </a-col>
                        <a-col :span="colSpan_3">
                            <a-form-item label="Tên đầy đủ">
                                <a-input :v-model="form.name" placeholder="Vui lòng nhập" allowClear/>
                            </a-form-item>
                        </a-col>
                    </a-row>
                    <a-row :gutter="gutter">
                        <a-col :span="colSpan_3">
                            <a-form-item label="Mật khẩu">
                                <a-input :v-model="form.password" placeholder="Vui lòng nhập" allowClear/>
                            </a-form-item>
                        </a-col>
                        <a-col :span="colSpan_3">
                            <a-form-item label="Email">
                                <a-input :v-model="form.email" html-type="email" placeholder="Vui lòng nhập"
                                         allowClear/>
                            </a-form-item>
                        </a-col>
                    </a-row>
                    <a-row :gutter="gutter">
                        <a-col :span="colSpan_3">
                            <a-form-item label="Số điện thoại">
                                <a-input-number :v-model="form.so_dien_thoai" placeholder="Vui lòng nhập" allowClear/>
                            </a-form-item>
                        </a-col>
                        <a-col :span="colSpan_3">
                            <a-form-item label="Trạng thái">
                                <a-input :v-model="form.status" placeholder="Vui lòng nhập" allowClear/>
                            </a-form-item>
                        </a-col>
                        <a-col :span="colSpan_3">
                            <a-form-item label="Ảnh đại diện">
                                <a-upload
                                    name="file"
                                    :multiple="true"
                                    :headers="headers"
                                    @change="handleChange"
                                    :v-model="form.anh_dai_dien"
                                >
                                    <a-button>
                                        <a-icon type="upload"/>
                                        Chọn ảnh
                                    </a-button>
                                </a-upload>
                            </a-form-item>
                        </a-col>
                    </a-row>
                </a-collapse-panel>
                <a-collapse-panel key="2" header="Những ngày đáng nhớ">
                    <a-row :gutter="gutter">
                        <a-col :span="colSpan_3">
                            <a-form-item label="Ngày sinh">
                                <a-date-picker :v-model="form.ngay_thang_nam_sinh" placeholder="Vui lòng chọn"
                                               allowClear/>
                            </a-form-item>
                        </a-col>
                        <a-col :span="colSpan_3">
                            <a-form-item label="Ngày bổn mạng">
                                <a-date-picker :v-model="form.ngay_bon_mang" placeholder="Vui lòng chọn" allowClear/>
                            </a-form-item>
                        </a-col>
                    </a-row>
                    <a-row :gutter="gutter">
                        <a-col :span="colSpan_3">
                            <a-form-item label="Ngày rửa tội">
                                <a-date-picker :v-model="form.ngay_rua_toi" placeholder="Vui lòng chọn" allowClear/>
                            </a-form-item>
                        </a-col>
                        <a-col :span="colSpan_3">
                            <a-form-item label="Người ban Bí tích Rửa tội">
                                <a-input :v-model="form.nguoi_rua_toi" placeholder="Vui lòng nhập" allowClear/>
                            </a-form-item>
                        </a-col>
                        <a-col :span="colSpan_3">
                            <a-form-item label="Người đỡ đầu rửa tội">
                                <a-input :v-model="form.nguoi_do_dau_rua_toi" placeholder="Vui lòng nhập" allowClear/>
                            </a-form-item>
                        </a-col>
                    </a-row>
                    <a-row :gutter="gutter">
                        <a-col :span="colSpan_3">
                            <a-form-item label="Ngày xưng tội lần đầu">
                                <a-date-picker :v-model="form.ngay_xung_toi" placeholder="Vui lòng chọn" allowClear/>
                            </a-form-item>
                        </a-col>
                        <a-col :span="colSpan_3">
                            <a-form-item label="Người ban Bí tích Giải tội">
                                <a-input :v-model="form.nguoi_giai_toi" placeholder="Vui lòng nhập" allowClear/>
                            </a-form-item>
                        </a-col>
                    </a-row>
                    <a-row :gutter="gutter">
                        <a-col :span="colSpan_3">
                            <a-form-item label="Ngày thêm sức">
                                <a-date-picker :v-model="form.ngay_them_suc" placeholder="Vui lòng chọn" allowClear/>
                            </a-form-item>
                        </a-col>
                        <a-col :span="colSpan_3">
                            <a-form-item label="Người ban Bí tích Thêm sức">
                                <a-input :v-model="form.nguoi_them_suc" placeholder="Vui lòng nhập" allowClear/>
                            </a-form-item>
                        </a-col>
                        <a-col :span="colSpan_3">
                            <a-form-item label="Người đỡ đầu thêm sức">
                                <a-input :v-model="form.nguoi_do_dau_them_suc" placeholder="Vui lòng nhập" allowClear/>
                            </a-form-item>
                        </a-col>
                    </a-row>
                </a-collapse-panel>
                <a-collapse-panel key="3" header="Thông tin phụ huynh">
                    <a-row :gutter="gutter">
                        <a-col :span="colSpan_3">
                            <a-form-item label="Tên bố">
                                <a-input :v-model="form.ten_bo" placeholder="Vui lòng nhập" allowClear/>
                            </a-form-item>
                        </a-col>
                        <a-col :span="colSpan_3">
                            <a-form-item label="Số điện thoại bố">
                                <a-input-number :v-model="form.sdt_bo" placeholder="Vui lòng nhập" allowClear/>
                            </a-form-item>
                        </a-col>
                        <a-col :span="colSpan_3">
                            <a-form-item label="Nghề nghiệp bố">
                                <a-input :v-model="form.nghe_nghiep_bo" placeholder="Vui lòng nhập" allowClear/>
                            </a-form-item>
                        </a-col>
                    </a-row>
                    <a-row :gutter="gutter">
                        <a-col :span="colSpan_3">
                            <a-form-item label="Tên mẹ">
                                <a-input :v-model="form.ten_me" placeholder="Vui lòng nhập" allowClear/>
                            </a-form-item>
                        </a-col>
                        <a-col :span="colSpan_3">
                            <a-form-item label="Số điện thoại mẹ">
                                <a-input-number :v-model="form.sdt_me" placeholder="Vui lòng nhập" allowClear/>
                            </a-form-item>
                        </a-col>
                        <a-col :span="colSpan_3">
                            <a-form-item label="Nghề nghiệp mẹ">
                                <a-input :v-model="form.nghe_nghiep_me" placeholder="Vui lòng nhập" allowClear/>
                            </a-form-item>
                        </a-col>

                    </a-row>
                </a-collapse-panel>
                <a-collapse-panel key="3" header="Địa chỉ liên lạc">
                    <a-row :gutter="gutter">
                        <a-col :span="colSpan_3">
                            <a-form-item label="Địa chỉ hành chính">
                                <a-input :v-model="form.dia_chi_hanh_chinh" placeholder="Vui lòng nhập" allowClear/>
                            </a-form-item>
                        </a-col>
                        <a-col :span="colSpan_3">
                            <a-form-item label="Địa chỉ giáo xứ">
                                <a-input :v-model="form.ma_giao_xu" placeholder="Vui lòng nhập" allowClear/>
                            </a-form-item>
                        </a-col>
                    </a-row>
                </a-collapse-panel>
            </a-collapse>
            <a-button type="primary" @click="goBack">Quay lại</a-button>
            <a-button html-type="submit" type="primary">Lưu</a-button>
        </a-form>
    </div>
</template>

<script>
export default {
    data() {
        return {
            form: {},
            colSpan_3: 8,
            colSpan_2: 12,
            gutter: 24,
            activeKey: ['1'],
            headers: {
                authorization: 'authorization-text',
            },
        }
    },
    methods: {
        goBack() {
            this.$router.back();
        },
        handleChange(info) {
            console.log(info)
        },
        next() {
            this.current++;
        },
        prev() {
            this.current--;
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
        handleSubmit() {
            console.log(this.form)
        },

    },
    mounted() {

    },
    created() {
        this.$Progress.start();
        const userId = this.$route.params.userId;
        console.log('User ID:', userId);
        this.$Progress.finish();
    },

    watch: {
        activeKey(key) {
            console.log(key);
        },
    },

}
</script>
