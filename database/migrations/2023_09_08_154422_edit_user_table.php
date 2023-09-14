<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('ma_so_ca_nhan')->nullable();
            $table->string('ten_thanh')->nullable();
            $table->string('ten_goi')->nullable();
            $table->date('ngay_thang_nam_sinh')->nullable();
            $table->string('so_dien_thoai')->nullable();
            $table->date('ngay_rua_toi')->nullable();
            $table->string('nguoi_rua_toi')->nullable();
            $table->string('nguoi_do_dau_rua_toi')->nullable();
            $table->date('ngay_them_suc')->nullable();
            $table->string('nguoi_them_suc')->nullable();
            $table->string('nguoi_do_dau_them_suc')->nullable();
            $table->date('ngay_bon_mang')->nullable();
            $table->mediumText('anh_dai_dien')->nullable();
            $table->string('ten_bo')->nullable();
            $table->string('sdt_bo')->nullable();
            $table->string('ten_me')->nullable();
            $table->string('sdt_me')->nullable();
            $table->string('dia_chi_hanh_chinh')->nullable();
            $table->string('ma_giao_xu')->nullable();
            $table->string('lop_hoc_id')->nullable();
            $table->string('nganh_id')->nullable();
            $table->string('cap_bac_id')->nullable();
            $table->string('trang_thai_hoc_tap')->nullable();
            $table->integer('status')->default(1);

            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
