<?php

namespace App\Http\Controllers;

use App\Models\Scorename;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * 显示学生成绩列表
     */
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');

        $query = Scorename::query();

        if ($keyword) {
            $query->where('name', 'like', "%{$keyword}%");
        }

        $students = $query->paginate(8);

        return view('students.index', compact('students', 'keyword'));
    }

    /**
     * 存储新学生成绩
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'score' => 'required|numeric',
        ]);

        Scorename::create($validated);

        return redirect()->route('students.index')->with('success', '添加成功！');
    }

    /**
     * 更新学生成绩
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'score' => 'required|numeric',
        ]);

        $student = Scorename::findOrFail($id);
        $student->update($validated);

        return redirect()->route('students.index')->with('success', '更新成功！');
    }

    /**
     * 删除学生成绩
     */
    public function destroy($id)
    {
        $student = Scorename::findOrFail($id);
        $student->delete();

        return redirect()->route('students.index')->with('success', '删除成功！');
    }
}
