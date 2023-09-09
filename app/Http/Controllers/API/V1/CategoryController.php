<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Category;
use Illuminate\Http\Request;
use ReflectionClass;

class CategoryController extends BaseController
{
    protected $category = '';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Category $category)
    {
        $this->middleware('auth:api');
        $this->category = $category;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = $this->category->latest()->paginate(10);

        return $this->sendResponse($categories, 'Category list');
    }

    public function getListTypeCategory()
    {
        $reflection = new ReflectionClass('\App\Enum\CategoriesEnum');
        $constants = $reflection->getConstants();

        $categoryArray = array_values($constants);
        return $this->sendResponse($categoryArray, 'List Type Category');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
        $categories = $this->category->pluck('name', 'id');

        return $this->sendResponse($categories, 'Category list');
    }


    /**
     * Store a newly created resource in storage.
     *
     *
     * @param $id
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $tag = $this->category->create([
            'name' => $request->get('name'),
            'loai' => $request->get('loai'),
        ]);

        return $this->sendResponse($tag, 'Tạo mới Tham số thành công');
    }

    /**
     * Update the resource in storage
     *
     * @param $id
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $id)
    {
        $tag = $this->category->findOrFail($id);

        $tag->update($request->all());

        return $this->sendResponse($tag, 'Thông tin Tham số đã được cập nhật');
    }

    public function destroy($id)
    {

        $this->authorize('isAdmin');

        $cate = Category::findOrFail($id);

        $cate->delete();

        return $this->sendResponse([$cate], 'Tham số đã được xóa');
    }
}
