<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class StudentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }


    /**
     * Lấy danh sách sinh viên
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index() {

        $students = Student::all();

        return $this->apiResponse(true, 'ok', $students);
    }

    /**
     * Lấy thông tin 1 sinh viên
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function read($id) {

        $student = Student::find($id);
        if($student) {
            return $this->apiResponse(true, 'ok', $student);
        }
        return $this->apiResponse(false, 'Không tìm thấy thông tin sinh viên', null, 404);
    }
    /**
     * Thêm mới 1 sinh viên
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request) {
        try {
            $this->validate($request, [
                'first_name' => 'nullable|numeric',
                'last_name' => 'nullable|array',
                'birth_day' => 'nullable|array',
                'student_code' => 'nullable|string',
                'sex' => 'nullable|string',
                'withs' => 'nullable|string',
                'per_page' => 'nullable|numeric|min:1',
                'page' => 'nullable|numeric|min:1',
            ]);
        } catch (ValidationException $e) {
            return $this->responseApi(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Cập nhật thông tin sinh viên
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id) {

    }

    /**
     * Xoa sinh vien
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id) {

        if(Student::destroy($id)) {
            return $this->apiResponse(true, 'Xóa sinh viên thành công');
        }

        return $this->apiResponse(false, 'Lỗi xóa sinh viên', null, 400);
    }
}
