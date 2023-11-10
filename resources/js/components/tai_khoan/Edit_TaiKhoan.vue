<style scoped>
.ant-input-number {
    width: 100%;
}
</style>

<template>
    <div class="content">
        <a-form :form="form" :label-col="{ span: 12 }" :wrapper-col="{ span: 12 }">
            <a-collapse v-model="activeKey">
                <a-collapse-panel key="1" header="Thông tin cá nhân">
                    <a-row :gutter="gutter">
                        <a-col :span="colSpan_3">
                            <a-form-item label="Tên Thánh">
                                <a-input v-model="form.ten_thanh" allowClear placeholder="Vui lòng nhập"/>
                            </a-form-item>
                        </a-col>
                        <a-col :span="colSpan_3">
                            <a-form-item label="Tên gọi">
                                <a-input v-model="form.ten_goi" allowClear placeholder="Vui lòng nhập"/>
                            </a-form-item>
                        </a-col>
                        <a-col :span="colSpan_3">
                            <a-form-item label="Tên đầy đủ">
                                <a-input v-model="form.name" allowClear placeholder="Vui lòng nhập"/>
                            </a-form-item>
                        </a-col>
                    </a-row>
                    <a-row :gutter="gutter">
                        <a-col :span="colSpan_3">
                            <a-form-item label="Mật khẩu">
                                <a-input v-model="form.password" allowClear placeholder="Vui lòng nhập"/>
                            </a-form-item>
                        </a-col>
                        <a-col :span="colSpan_3">
                            <a-form-item label="Email">
                                <a-input v-model="form.email" allowClear html-type="email"
                                         placeholder="Vui lòng nhập"/>
                            </a-form-item>
                        </a-col>
                    </a-row>
                    <a-row :gutter="gutter">
                        <a-col :span="colSpan_3">
                            <a-form-item label="Số điện thoại">
                                <a-input-number v-model="form.so_dien_thoai" allowClear placeholder="Vui lòng nhập"/>
                            </a-form-item>
                        </a-col>
                        <a-col :span="colSpan_3">
                            <a-form-item label="Trạng thái">
                                <a-input v-model="form.status" allowClear placeholder="Vui lòng nhập"/>
                            </a-form-item>
                        </a-col>
                        <a-col :span="colSpan_3">
                            <a-form-item label="Ảnh đại diện">
                                <a-upload
                                    v-model="form.anh_dai_dien"
                                    :headers="headers"
                                    :multiple="true"
                                    name="file"
                                    @change="handleChange"
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
                                <a-date-picker v-model="form.ngay_thang_nam_sinh" allowClear
                                               placeholder="Vui lòng chọn"/>
                            </a-form-item>
                        </a-col>
                        <a-col :span="colSpan_3">
                            <a-form-item label="Ngày bổn mạng">
                                <a-date-picker v-model="form.ngay_bon_mang" allowClear placeholder="Vui lòng chọn"/>
                            </a-form-item>
                        </a-col>
                    </a-row>
                    <a-row :gutter="gutter">
                        <a-col :span="colSpan_3">
                            <a-form-item label="Ngày rửa tội">
                                <a-date-picker v-model="form.ngay_rua_toi" allowClear placeholder="Vui lòng chọn"/>
                            </a-form-item>
                        </a-col>
                        <a-col :span="colSpan_3">
                            <a-form-item label="Người ban Bí tích Rửa tội">
                                <a-input v-model="form.nguoi_rua_toi" allowClear placeholder="Vui lòng nhập"/>
                            </a-form-item>
                        </a-col>
                        <a-col :span="colSpan_3">
                            <a-form-item label="Người đỡ đầu rửa tội">
                                <a-input v-model="form.nguoi_do_dau_rua_toi" allowClear placeholder="Vui lòng nhập"/>
                            </a-form-item>
                        </a-col>
                    </a-row>
                    <a-row :gutter="gutter">
                        <a-col :span="colSpan_3">
                            <a-form-item label="Ngày xưng tội lần đầu">
                                <a-date-picker v-model="form.ngay_xung_toi" allowClear placeholder="Vui lòng chọn"/>
                            </a-form-item>
                        </a-col>
                        <a-col :span="colSpan_3">
                            <a-form-item label="Người ban Bí tích Giải tội">
                                <a-input v-model="form.nguoi_giai_toi" allowClear placeholder="Vui lòng nhập"/>
                            </a-form-item>
                        </a-col>
                    </a-row>
                    <a-row :gutter="gutter">
                        <a-col :span="colSpan_3">
                            <a-form-item label="Ngày thêm sức">
                                <a-date-picker v-model="form.ngay_them_suc" allowClear placeholder="Vui lòng chọn"/>
                            </a-form-item>
                        </a-col>
                        <a-col :span="colSpan_3">
                            <a-form-item label="Người ban Bí tích Thêm sức">
                                <a-input v-model="form.nguoi_them_suc" allowClear placeholder="Vui lòng nhập"/>
                            </a-form-item>
                        </a-col>
                        <a-col :span="colSpan_3">
                            <a-form-item label="Người đỡ đầu thêm sức">
                                <a-input v-model="form.nguoi_do_dau_them_suc" allowClear placeholder="Vui lòng nhập"/>
                            </a-form-item>
                        </a-col>
                    </a-row>
                </a-collapse-panel>
                <a-collapse-panel key="4" header="Thông tin phụ huynh">
                    <a-row :gutter="gutter">
                        <a-col :span="colSpan_3">
                            <a-form-item label="Tên bố">
                                <a-input v-model="form.ten_bo" allowClear placeholder="Vui lòng nhập"/>
                            </a-form-item>
                        </a-col>
                        <a-col :span="colSpan_3">
                            <a-form-item label="Số điện thoại bố">
                                <a-input-number v-model="form.sdt_bo" allowClear placeholder="Vui lòng nhập"/>
                            </a-form-item>
                        </a-col>
                        <a-col :span="colSpan_3">
                            <a-form-item label="Nghề nghiệp bố">
                                <a-input v-model="form.nghe_nghiep_bo" allowClear placeholder="Vui lòng nhập"/>
                            </a-form-item>
                        </a-col>
                    </a-row>
                    <a-row :gutter="gutter">
                        <a-col :span="colSpan_3">
                            <a-form-item label="Tên mẹ">
                                <a-input v-model="form.ten_me" allowClear placeholder="Vui lòng nhập"/>
                            </a-form-item>
                        </a-col>
                        <a-col :span="colSpan_3">
                            <a-form-item label="Số điện thoại mẹ">
                                <a-input-number v-model="form.sdt_me" allowClear placeholder="Vui lòng nhập"/>
                            </a-form-item>
                        </a-col>
                        <a-col :span="colSpan_3">
                            <a-form-item label="Nghề nghiệp mẹ">
                                <a-input v-model="form.nghe_nghiep_me" allowClear placeholder="Vui lòng nhập"/>
                            </a-form-item>
                        </a-col>

                    </a-row>
                </a-collapse-panel>
                <a-collapse-panel key="3" header="Địa chỉ liên lạc">
                    <a-row :gutter="gutter">
                        <a-col :span="colSpan_3">
                            <a-form-item label="Địa chỉ hành chính">
                                <a-input v-model="form.dia_chi_hanh_chinh" allowClear placeholder="Vui lòng nhập"/>
                            </a-form-item>
                        </a-col>
                        <a-col :span="colSpan_3">
                            <a-form-item label="Địa chỉ giáo xứ">
                                <a-input v-model="form.ma_giao_xu" allowClear placeholder="Vui lòng nhập"/>
                            </a-form-item>
                        </a-col>
                    </a-row>
                </a-collapse-panel>
            </a-collapse>
            <a-button type="primary" @click="goBack">Quay lại</a-button>
            <a-button html-type="submit" type="primary" @click="handleSubmit">Lưu</a-button>
        </a-form>
    </div>
</template>

<script>
import api from '../../api.js'

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
        handleSubmit() {
            if (this.$gate.isAdmin()) {
                let url = this.$baseUrl + api.API_USER
                axios.put(url + this.form.id, this.form)
                    .then((data) => {
                        console.log(data)
                    });
            }
        },

    },
    mounted() {

    },
    created() {
        this.$Progress.start();
        this.form.id = this.$route.params.userId;
        console.log()
        this.$Progress.finish();
    },

    watch: {
        activeKey(key) {
        },
    },

}
</script>
