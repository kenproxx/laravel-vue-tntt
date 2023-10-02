export default [
    { path: '/trang-chu', component: require('./components/Dashboard.vue').default, name: "TrangChu" },
    { path: '/trang-ca-nhan', component: require('./components/Profile.vue').default, name: "TrangCaNhan" },
    { path: '/cau-hinh', component: require('./components/Developer.vue').default, name: "CauHinh" },
    { path: '/thieu-nhi', component: require('./components/tai_khoan/ThieuNhi.vue').default, name: "ThieuNhi" },
    { path: '/sua-tai-khoan/:userId', component: require('./components/tai_khoan/Edit_TaiKhoan.vue').default, name: "SuaTaiKhoan" },
    { path: '/huynh-truong', component: require('./components/tai_khoan/HuynhTruong.vue').default, name: "HuynhTruong" },
    { path: '/products', component: require('./components/product/Products.vue').default, name: "xxx" },
    { path: '/dia-chi', component: require('./components/product/Address.vue').default, name: "DiaChi" },
    { path: '/tham-so', component: require('./components/product/Category.vue').default, name: "ThamSo" },
    { path: '*', component: require('./components/NotFound.vue').default }
];
