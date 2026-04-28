# 学生成绩管理系统
基于 Laravel + LNMP (Linux, Nginx, MySQL, PHP) 技术栈的学生成绩展示项目。

## 当前功能
- ✅ 数据库连接配置（MySQL）
- ✅ 学生成绩列表展示
- ✅ 基础美观的响应式页面
- ✅ MVC 架构实现

## 技术栈
- **框架**: Laravel 10.x
- **后端**: PHP 8.1+
- **数据库**: MySQL
- **前端**: Blade 模板 + 原生 CSS
- **Web 服务器**: Laravel 内置服务器

## 快速开始

### 开发环境
- Ubuntu 22.04 (或其他 Linux 发行版)
- PHP 8.1+
- Composer
- MySQL

### 安装步骤

```bash
# 1. 克隆项目后安装依赖
composer install

# 2. 配置数据库（编辑 .env）
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=scores
DB_USERNAME=test
DB_PASSWORD=11112222

# 3. 设置目录权限
chmod -R 775 storage bootstrap/cache

# 4. 启动开发服务器
php artisan serve

# 5. 项目结构
student-scores/
├── app/
│   ├── Http/Controllers/
│   │   └── ScoreController.php      # 成绩查询控制器
│   └── Models/
│       └── Scorename.php            # 成绩数据模型
├── resources/
│   └── views/
│       └── scores/
│           └── index.blade.php      # 成绩列表视图
├── routes/
│   └── web.php                      # 路由定义
└── .env                             # 环境配置

# 6. 数据库表结构
表名: scorename
| 字段    | 类型        | 说明       |
| ----- | --------- | -------- |
| id    | int       | 主键（假设存在） |
| name  | varchar   | 学生姓名     |
| score | int/float | 成绩分数     |

# 7. 核心代码说明
1. 数据模型 (app/Models/Scorename.php)
protected $table = 'scorename';    // 指定表名
public $timestamps = false;        // 无时间戳字段
protected $fillable = ['name', 'score'];

2. 控制器 (app/Http/Controllers/ScoreController.php)
public function index()
{
    $scores = Scorename::all();    // Eloquent 查询所有记录
    return view('scores.index', compact('scores'));
}

3. 路由 (routes/web.php)
Route::get('/scores', [ScoreController::class, 'index']);
```