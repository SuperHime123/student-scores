<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scorename extends Model
{
    use HasFactory;

    // 指定表名（如果表名不是复数形式）
    protected $table = 'scorename';

    // 如果你的表没有 created_at 和 updated_at 字段
    public $timestamps = false;

    // 允许批量赋值的字段
    protected $fillable = ['name', 'score'];
}
