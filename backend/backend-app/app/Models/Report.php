<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Report
 *
 * Đây là model đại diện cho bảng `reports`.
 * - Dùng để quản lý báo cáo vi phạm.
 * - Một user có thể gửi nhiều report.
 */
class Report extends Model
{
    use HasFactory;

    /**
     * Các cột cho phép gán giá trị hàng loạt.
     * - sender_id: ID người gửi báo cáo
     * - target_id: ID đối tượng bị báo cáo
     * - target_type: loại đối tượng (Comment/Recipe/Blog)
     * - reason: lý do báo cáo
     * - status: trạng thái xử lý (Pending/Resolved)
     */
    protected $fillable = ['sender_id','target_id','target_type','reason','status'];

    /**
     * Quan hệ n-1 với User (người gửi báo cáo).
     */
    public function sender()
    {
        return $this->belongsTo(User::class,'sender_id');
    }
}
