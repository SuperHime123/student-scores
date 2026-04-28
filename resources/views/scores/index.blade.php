<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>学生成绩</title>
    <style>
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
    </style>
</head>
<body>
    <div class="container">
        <h1>📊 sxhu's 学生成绩表</h1>
        
        <table>
            <thead>
                <tr>
                    <th>姓名</th>
                    <th>成绩</th>
                </tr>
            </thead>
            <tbody>
                @forelse($scores as $score)
                    <tr>
                        <td>{{ $score->name }}</td>
                        <td class="score">{{ $score->score }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" style="text-align: center; color: #999;">
                            暂无数据
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        
        <p style="text-align: center; color: #666; margin-top: 20px;">
            共 {{ count($scores) }} 条记录
        </p>
    </div>
</body>
</html>
