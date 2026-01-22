<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Report
 *
 * Model đại diện cho bảng `reports`.
 *  - Dùng để quản lý báo cáo vi phạm.
 *  - Báo cáo vi phạm nội dung
 *  - Một user có thể gửi nhiều report.
 */
class Report extends Model
{
    use HasFactory;

    /**
     * Các cột cho phép gán giá trị hàng loạt.
     * - target_id: đối tượng bị báo cáo
     * - target_type: loại đối tượng (Recipe/Blog/Comment/QuestionAnswer)
     * - reason: lý do báo cáo
     */
    protected $fillable = ['target_id', 'target_type', 'reason'];

    /** Người gửi báo cáo */
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
    /** Nội dung bị báo cáo (polymorphic) */
    public function target()
    {
        return $this->morphTo();
    }
}
