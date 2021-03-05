<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class StudentController extends Controller
{


    /**
     * Lấy danh sách sinh viên
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index() {

        $students = Student::all();

        return $this->apiResponse(true, 'Lấy danh sách ok', $students);
    }

    /**
     * Lấy thông tin 1 sinh viên
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function read($id) {

        $student = Student::query()->find($id);
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
                'first_name' => 'required|string|min:1',
                'last_name' => 'required|string|min:1',
                'birth_day' => 'required|date_format:Y-m-d',
                'student_code' => 'required|string|min:1|max:8',
                'sex' => 'required|string',
                'vnu_mail' => 'required|string',
                'other_mail' => 'nullable|string',
                'contacts' => 'nullable|array',
                'contacts.*.name' => 'required|string',
                'contacts.*.address' => 'required|string',
            ]);
        } catch (ValidationException $e) {
            return $this->apiResponse(false, $e->getMessage(), $e, 400);
        }

        $student = Student::query()->create($request->all());

        if ($student) {
            return $this->apiResponse(true, 'Thêm mới sinh viên thành công', $student);
        }
        return $this->apiResponse(false, 'Lỗi thêm sinh viên', null, 500);
    }

    /**
     * Cập nhật thông tin sinh viên
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id) {
        try {
            $this->validate($request, [
                'first_name' => 'nullable|string|min:1',
                'last_name' => 'nullable|string|min:1',
                'birth_day' => 'nullable|date_format:Y-m-d',
                'student_code' => 'nullable|string|min:8|max:8',
                'sex' => 'nullable|in:male,female',
                'vnu_mail' => 'nullable|mail',
                'other_mail' => 'nullable|mail',
                'contacts' => 'nullable|array',
                'contacts.*.name' => 'required|string',
                'contacts.*.address' => 'required|string',
            ]);
        } catch (ValidationException $e) {
            return $this->apiResponse(false, $e->getMessage(), null, 400);
        }

        $student = Student::query()->find($id);

        if ($student) {
            if($request->get('first_name', false)) $student->first_name = $request->first_name;
            if($request->get('last_name', false)) $student->last_name = $request->last_name;
            if($request->get('birth_day', false)) $student->birth_day = $request->birth_day;
            if($request->get('student_code', false)) $student->student_code = $request->student_code;
            if($request->get('sex', false)) $student->sex = $request->sex;
            if($request->get('vnu_mail', false)) $student->vnu_mail = $request->vnu_mail;
            if($request->get('other_mail', false)) $student->other_mail = $request->other_mail;
            if($request->get('contacts', false)) $student->contacts = $request->contacts;

            $student->save();

            return $this->apiResponse(true, 'Cập nhật sinh viên thành công', $student);
        }

        return $this->apiResponse(false, 'Lỗi cập nhật sinh viên', null, 500);
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

        return $this->apiResponse(false, 'Lỗi xóa sinh viên', null, 500);
    }
}
