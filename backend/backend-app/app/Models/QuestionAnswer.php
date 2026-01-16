<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class QuestionAnswer
 *
 * Đây là model đại diện cho bảng `question_answers`.
 * - Quản lý hỏi đáp của user.
 * - Có thể là câu hỏi hoặc câu trả lời (dùng parent_id).
 */
class QuestionAnswer extends Model
{
    use HasFactory;

    /**
     * Các cột cho phép gán giá trị hàng loạt.
     * - user_id: ID người đặt câu hỏi/trả lời
     * - parent_id: ID câu hỏi cha (nếu là trả lời)
     * - content: nội dung
     */
    protected $fillable = ['user_id','parent_id','content'];

    /** Quan hệ n-1 với User. */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /** Quan hệ n-1 với chính nó (câu hỏi cha). */
    public function parent()
    {
        return $this->belongsTo(QuestionAnswer::class,'parent_id');
    }

    /** Quan hệ 1-n với chính nó (câu trả lời con). */
    public function replies()
    {
        return $this->hasMany(QuestionAnswer::class,'parent_id');
    }
}
