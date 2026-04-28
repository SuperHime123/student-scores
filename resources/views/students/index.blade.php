<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>学生成绩</title>
    <style>
/* Force cache refresh - 2026-04-28 */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
        }
        h1 {
            color: #333;
            text-align: center;
            margin-bottom: 30px;
        }
        .search-box {
            margin-bottom: 20px;
        }
        .search-box input {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            width: 300px;
        }
        .search-box button {
            padding: 10px 20px;
            background: #667eea;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-left: 10px;
        }
        .search-box button:hover {
            background: #5a67d8;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background: #667eea;
            color: white;
        }
        tr:hover {
            background: #f5f5f5;
        }
        .score {
            font-weight: bold;
            color: #667eea;
        }
        .actions {
            display: flex;
            gap: 10px;
        }
        .actions button {
            padding: 5px 10px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            font-size: 12px;
        }
        .edit-btn {
            background: #48bb78;
            color: white;
        }
        .edit-btn:hover {
            background: #38a169;
        }
        .delete-btn {
            background: #f56565;
            color: white;
        }
        .delete-btn:hover {
            background: #e53e3e;
        }
        .add-btn {
            float: right;
            background: #48bb78;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            margin-bottom: 20px;
        }
        .add-btn:hover {
            background: #38a169;
        }
        .back-btn {
            float: left;
            background: #718096;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            margin-bottom: 20px;
        }
        .back-btn:hover {
            background: #4a5568;
        }
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 1000;
        }
        .modal-content {
            background: white;
            margin: 100px auto;
            padding: 30px;
            width: 450px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        }
        .modal-buttons {
            text-align: right;
            margin-top: 20px;
        }
        .modal-buttons button {
            padding: 8px 20px;
            margin-left: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .confirm-btn {
            background: #f56565;
            color: white;
        }
        .cancel-btn {
            background: #999;
            color: white;
        }
        .pagination {
            margin-top: 30px;
        }
        .pagination-container {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 6px;
            flex-wrap: wrap;
        }
        .page-numbers {
            display: flex;
            gap: 4px;
        }
        .pagination-btn,
.pagination-btn:link,
.pagination-btn:visited,
.pagination-btn:hover,
.pagination-btn:active {
            padding: 6px 10px !important;
            border: 1px solid #e2e8f0 !important;
            background: #ffffff !important;
            color: #4a5568 !important;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            text-decoration: none !important;
            transition: all 0.2s ease;
            min-width: 50px !important;
            height: 36px !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            margin: 0 !important;
            vertical-align: middle !important;
        }
        .pagination-btn:hover:not(.disabled):not(.active) {
            background: #667eea !important;
            color: white !important;
            border-color: #667eea !important;
        }
        .pagination-btn.active {
            background: #667eea !important;
            color: #ffffff !important;
            border-color: #667eea !important;
            height: 36px !important;
            min-width: 50px !important;
            padding: 6px 10px !important;
        }
        .pagination-btn.disabled {
            background: #f7fafc !important;
            color: #a0aec0 !important;
            cursor: not-allowed !important;
            border-color: #e2e8f0 !important;
        }
        .pagination-btn.disabled:hover {
            background: #f7fafc !important;
            border-color: #e2e8f0 !important;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>📊 sxhu's 学生成绩表</h1>

        <div class="search-box">
            <form method="GET" action="{{ route('students.index') }}">
                <input type="text" name="keyword" placeholder="输入姓名搜索..." value="{{ $keyword }}">
                <button type="submit">搜索</button>
            </form>
        </div>

        @if(request()->input('keyword'))
            <button class="back-btn" onclick="window.location.href='{{ route('students.index') }}'">返回</button>
        @endif
        <button class="add-btn" onclick="showAddModal()">添加</button>

        <table>
            <thead>
                <tr>
                    <th>姓名</th>
                    <th>成绩</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                @forelse($students as $student)
                    <tr>
                        <td>{{ $student->name }}</td>
                        <td class="score">{{ $student->score }}</td>
                        <td class="actions">
                            <button class="edit-btn" onclick="editStudent({{ $student->id }}, '{{ $student->name }}', {{ $student->score }})">编辑</button>
                            <button class="delete-btn" onclick="confirmDelete({{ $student->id }})">删除</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" style="text-align: center; color: #999;">
                            暂无数据
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{ $students->links('pagination.custom') }}

        <p style="text-align: center; color: #666; margin-top: 20px;">
            共 {{ $students->total() }} 条记录
        </p>
    </div>

    <!-- 添加/编辑 Modal -->
    <div id="addModal" class="modal">
        <div class="modal-content">
            <h2 id="modalTitle">添加学生</h2>
            <form id="studentForm" method="POST" action="">
                @csrf
                <input type="hidden" id="methodField" name="_method" value="POST">
                <input type="hidden" id="studentId" name="id" value="">
                <div style="margin-bottom: 15px;">
                    <label>姓名：</label><br>
                    <input type="text" id="name" name="name" required readonly style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 3px; background-color: #f5f5f5;">
                </div>
                <div style="margin-bottom: 15px;">
                    <label>成绩：</label><br>
                    <input type="number" id="score" name="score" required step="0.1" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 3px;">
                </div>
                <div class="modal-buttons">
                    <button type="submit" class="confirm-btn">确定</button>
                    <button type="button" class="cancel-btn" onclick="document.getElementById('addModal').style.display='none'">取消</button>
                </div>
            </form>
        </div>
    </div>

    <!-- 删除确认 Modal -->
    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <h2>确认删除</h2>
            <p>确定要删除当前条目数据么？</p>
            <form id="deleteForm" method="POST" action="{{ route('students.destroy', ':id') }}">
                @csrf
                <input type="hidden" name="_method" value="DELETE">
                <input type="hidden" id="deleteId" name="id" value="">
                <div class="modal-buttons">
                    <button type="submit" class="confirm-btn">确定</button>
                    <button type="button" class="cancel-btn" onclick="document.getElementById('deleteModal').style.display='none'">取消</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // 编辑学生
        function editStudent(id, name, score) {
            document.getElementById('modalTitle').textContent = '编辑学生';
            document.getElementById('studentForm').action = '{{ route('students.update', ':id') }}'.replace(':id', id);
            document.getElementById('methodField').value = 'PUT';
            document.getElementById('studentId').value = id;
            document.getElementById('name').value = name;
            document.getElementById('score').value = score;
            document.getElementById('addModal').style.display = 'block';
        }

        // 添加学生
        function showAddModal() {
            document.getElementById('modalTitle').textContent = '添加学生';
            document.getElementById('studentForm').action = '{{ route('students.store') }}';
            document.getElementById('methodField').value = 'POST';
            document.getElementById('studentId').value = '';
            document.getElementById('name').value = '';
            document.getElementById('name').readOnly = false;
            document.getElementById('name').style.backgroundColor = 'white';
            document.getElementById('score').value = '';
            document.getElementById('addModal').style.display = 'block';
        }

        // 确认删除
        function confirmDelete(id) {
            document.getElementById('deleteId').value = id;
            document.getElementById('deleteForm').action = '{{ route('students.destroy', ':id') }}'.replace(':id', id);
            document.getElementById('deleteModal').style.display = 'block';
        }

        // 点击 Modal 外部关闭
        window.onclick = function(event) {
            if (event.target.className === 'modal') {
                event.target.style.display = 'none';
            }
        }
    </script>
</body>
</html>