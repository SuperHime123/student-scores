## 一、分页功能（Pagination）

**后端（Laravel Controller）**

- 在控制器的 `index()` 方法中，使用 Laravel 内置的 `paginate(8)` 方法替代 `get()`，每页返回 8 条学生成绩记录。
- 将分页对象（`LengthAwarePaginator`）传递至 Blade 视图。

**前端（Blade 视图）**

- 调用 

  ```
  $students->links()
  ```

   渲染分页导航，或自定义分页组件，满足以下 UI 要求：

  - 显示「上一页」与「下一页」按钮，当处于第一页时「上一页」禁用，最后一页时「下一页」禁用；
  - 根据 `$students->lastPage()` 计算总页数；当总页数过多时，采用省略号（`...`）策略，仅显示当前页附近若干页码及首页、末页页码；
  - 分页组件需携带当前搜索关键词参数（`keyword`），通过 `$students->appends(request()->query())->links()` 保持搜索状态与分页联动。

------

## 二、添加学生成绩功能（Add Record）

**页面布局**

- 在 `<h1>学生成绩表</h1>` 标题与成绩 `<table>` 之间插入一个「添加」按钮（`<button>`）；
- 该按钮使用 `float: right` 或 Flexbox/Grid 布局，使其右侧与表格右侧对齐。

**前端交互（Modal 对话框）**

- 点击「添加」按钮，触发 JavaScript 显示一个 Modal 弹窗，包含：
  - 姓名输入框：`<input type="text" id="name" name="name">`；
  - 成绩输入框：`<input type="number" id="score" name="score">`；
  - Modal 打开后，使用 JavaScript 自动将焦点定位到姓名输入框（`document.getElementById('name').focus()`）；
  - 「确定」按钮：仅当姓名与成绩两个字段均非空时可激活（通过监听 `input` 事件动态切换按钮的 `disabled` 状态）；
  - 「取消」按钮：点击后关闭 Modal，不提交任何数据。

**后端（Laravel Route + Controller）**

- 定义路由：`POST /students`，指向 `StudentController@store`；
- 在 `store()` 方法中，使用 `Validator` 或 `FormRequest` 对 `name`（`required|string`）与 `score`（`required|numeric`）进行验证；
- 验证通过后，调用 `Student::create([...])` 将新记录写入数据库；
- 返回重定向响应或 JSON 响应（如使用 AJAX 提交）。

------

## 三、操作列：删除与编辑功能（Delete & Edit）

**表格结构**

- 在现有「姓名」和「成绩」两列之后，新增第三列「操作」（`<th>操作</th>`）；
- 每行的「操作」列渲染两个按钮：「删除」与「编辑」。

### 3.1 删除功能（Delete）

**前端交互**

- 点击「删除」按钮，触发确认 Modal 弹窗，显示文字：「确定要删除当前条目数据么？」；
- Modal 包含「确定」和「取消」两个按钮：
  - 点击「确定」：通过 JavaScript 提交一个 `DELETE` 请求（可使用隐藏表单 `<input type="hidden" name="_method" value="DELETE">` 配合 `POST`，或使用 `fetch`/`axios` 发起 AJAX 请求）至对应路由，删除成功后页面自动刷新（`window.location.reload()` 或服务端重定向）；
  - 点击「取消」：仅关闭 Modal，不执行任何操作。

**后端（Laravel Route + Controller）**

- 定义路由：`DELETE /students/{id}`，指向 `StudentController@destroy`；
- 在 `destroy()` 方法中，通过 `Student::findOrFail($id)->delete()` 删除指定记录；
- 返回重定向至列表页或 JSON 成功响应。

### 3.2 编辑功能（Edit）

**前端交互**

- 点击「编辑」按钮，触发编辑 Modal 弹窗；
- Modal 的两个输入框自动填充当前行数据：
  - 姓名输入框（`readonly` 或 `disabled`，不可修改）；
  - 成绩输入框（可编辑）；
- 「确定」按钮：提交修改后的成绩数据；
- 「取消」按钮：关闭 Modal，不提交数据。

**后端（Laravel Route + Controller）**

- 定义路由：`PUT /students/{id}` 或 `PATCH /students/{id}`，指向 `StudentController@update`；
- 在 `update()` 方法中，对 `score` 字段进行验证（`required|numeric`），通过后调用 `Student::findOrFail($id)->update([...])` 更新数据库记录；
- 返回重定向响应或 JSON 响应。

------

## 四、按姓名搜索功能（Search by Name）

**页面布局**

- 在 `<h1>学生成绩表</h1>` 标题正下方，插入一个搜索输入框（`<input type="text" name="keyword" placeholder="输入姓名搜索...">`）；
- 建议使用实时搜索（监听 `input` 事件，通过 AJAX 发起请求）或表单提交（`GET` 方式，携带 `keyword` 参数）触发搜索。

**后端（Laravel Controller）**

- 在 `index()` 方法中，读取请求参数 `$keyword = $request->input('keyword')`；
- 若 `$keyword` 非空，则在查询中附加条件：`->where('name', 'like', "%{$keyword}%")`；
- 最终结合分页：`->paginate(8)`，返回过滤后的分页数据；
- 将 `$keyword` 回传至视图，用于保持搜索框中的输入状态，并通过 `$students->appends(['keyword' => $keyword])->links()` 确保分页链接携带搜索参数。

------

## 五、路由汇总（RESTful Resource Routes）

可使用 Laravel 资源路由一键生成上述所有路由：

```php
Route::resource('students', StudentController::class);
```

对应生成的关键路由如下：

| Method    | URI              | Controller Action | 功能               |
| --------- | ---------------- | ----------------- | ------------------ |
| GET       | `/students`      | `index`           | 列表 + 搜索 + 分页 |
| POST      | `/students`      | `store`           | 新增记录           |
| PUT/PATCH | `/students/{id}` | `update`          | 编辑记录           |
| DELETE    | `/students/{id}` | `destroy`         | 删除记录           |