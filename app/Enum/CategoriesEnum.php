<?php

namespace App\Enum;

use Illuminate\Validation\Rules\Enum;

final class CategoriesEnum extends Enum
{
    const GIOI_TINH = "Giới tính";
    const NGANH = "Ngành";
    const CAP_BAC = "Cấp bậc";
    const GIAO_PHAN = "Giáo phận";
    const GIAO_HAT = "Giáo hạt";
    const GIAO_XU = "Giáo xứ";
    const GIAO_HO = "Giáo họ";
}
