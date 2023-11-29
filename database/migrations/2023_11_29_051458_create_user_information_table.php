<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_information', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');

            $table->date('ngay_rua_toi')->nullable();
            $table->string('nguoi_rua_toi')->nullable();
            $table->string('nguoi_do_dau_rua_toi')->nullable();

            $table->date('ngay_xung_toi')->nullable();
            $table->string('nguoi_giai_toi')->nullable();

            $table->date('ngay_them_suc')->nullable();
            $table->string('nguoi_them_suc')->nullable();
            $table->string('nguoi_do_dau_them_suc')->nullable();

            $table->date('ngay_bon_mang')->nullable();
            $table->mediumText('anh_dai_dien')->nullable();

            $table->string('ten_bo')->nullable();
            $table->string('sdt_bo')->nullable();
            $table->string('nghe_nghiep_bo')->nullable();

            $table->string('ten_me')->nullable();
            $table->string('sdt_me')->nullable();
            $table->string('nghe_nghiep_me')->nullable();

            $table->string('dia_chi_hanh_chinh')->nullable();
            $table->string('ma_giao_xu')->nullable();
            $table->string('lop_hoc_id')->nullable();
            $table->string('nganh_id')->nullable();
            $table->string('cap_bac_id')->nullable();
            $table->string('trang_thai_hoc_tap')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_information');
    }
}
