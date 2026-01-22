<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\RecipeRequest;
use App\Models\Recipe;
use App\Models\Ingredient;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
//use Illuminate\Support\Facades\Storage;

class RecipeController extends Controller
{
    /**
     * Danh sách công thức Approved (public)
     */
    public function index(Request $request)
    {
        // Lấy công thức đã duyệt, kèm steps + ingredients, phân trang 10/c trang
        $recipes = Recipe::with(['steps', 'ingredients'])
            ->where('status', 'Published')
            ->orderByDesc('created_at')
            ->paginate(10);

        // Trả về JSON: data + pagination
        return response()->json([
            'message' => 'Danh sách công thức đã duyệt',
            'data' => $recipes->items(), // danh sách công thức trang hiện tại
            'pagination' => [
                'current_page' => $recipes->currentPage(), // biết đang ở trang số mấy
                'last_page'    => $recipes->lastPage(), // tổng số trang để tính toán nút cuối
                'per_page'     => $recipes->perPage(), // số item mỗi trang
                'total'        => $recipes->total(), // tổng số công thức
                'has_more'     => $recipes->hasMorePages(), // bật/tắt nút “Next”
                'next_page_url' => $recipes->nextPageUrl(), // điều hướng qua lại
                'prev_page_url' => $recipes->previousPageUrl(), // điều hướng qua lại
            ]
        ], 200);
    }

    /**
     * =========================
     * LẤY CHI TIẾT CÔNG THỨC
     * =========================
     * - Trả về đầy đủ thông tin công thức, nguyên liệu, bước nấu
     * - Trang chi tiết công thức - public
     */
    public function show(Request $request, $id)
    {
        $recipe = Recipe::with(['steps', 'ingredients', 'user'])->find($id);

        // Nếu không tìm thấy => trả về 404 + message 
        if (!$recipe) {
            return response()->json(['message' => 'Không tìm thấy công thức'], 404);
        }

        // Nếu công thức chưa duyệt hoặc bị từ chối
        if (in_array($recipe->status, ['Pending', 'Rejected'])) {
            // Chỉ cho chủ sở hữu xem - khách và member ko sở hữu công thức ko đc xem
            if ($recipe->user_id !== $request->user()?->id) {
                return response()->json(['message' => 'Công thức này chưa được duyệt hoặc đã bị từ chối'], 403); // 403 Forbidden
            }
        }

        // Nếu Approved thì ai cũng xem được
        return response()->json([
            'message' => 'Xem chi tiết công thức thành công',
            'data' => $recipe,
            // FE hiển thị rõ ràng: có thể show badge “Pending”, “Approved”, “Rejected” ngay trên giao diện.
            'status' => $recipe->status //Tránh nhầm lẫn: không cần suy luận từ mã lỗi 403/200.
        ], 200);
    }

    /**
     * =========================
     * HÀM ĐĂNG CÔNG THỨC
     * =========================
     * - Chỉ user đã đăng nhập mới được dùng
     * - Công thức sau khi tạo sẽ ở trạng thái Pending (chờ duyệt)
     */
    public function store(RecipeRequest $request)
    {
        /**
         * =========================
         * 1. KIỂM TRA DỮ LIỆU
         * =========================
         * validate() giúp:
         * - Không cho dữ liệu sai lọt vào DB
         * - Giảm lỗi chạy
         * - Phát hiện lỗi sớm cho frontend
         */

        Log::info('Request all data:', $request->all());
        $validated = $request->validated(); // xử lý lưu recipe
        Log::info('Validated data:', $validated);
        /**
         * =========================
         * 2. BẮT ĐẦU (Khởi Tạo) TRANSACTION
         * =========================
         * Sau đó sẽ có:
         *  + DB::commit(); => nếu mọi thứ chạy ổn thì lưu toàn bộ.
         *  + DB::rollBack(); => nếu có exception thì hủy toàn bộ thay đổi.
         * - Nếu có lỗi ở bất kỳ bước nào => rollback
         * - Tránh lưu dữ liệu bị thiếu
         */
        DB::beginTransaction();

        try {

            /**
             * =========================
             * 3. UPLOAD ẢNH MÓN ĂN
             * =========================
             */
            $imagePath = null;

            /**
             * hasFile():
             * - kiểm tra người dùng có upload ảnh không
             */
            if ($request->hasFile('main_image')) {

                /**
                 * store():
                 * - lưu ảnh vào storage/app/public/recipes
                 * - chỉ lưu đường dẫn vào DB
                 */
                $imagePath = $request->file('main_image')->store('recipes', 'public');
            }

            /**
             * =========================
             * 4. TẠO CÔNG THỨC (user_id lấy từ token Sanctum)
             * =========================
             * create(): 
             * - dùng mass assignment
             * - chỉ hoạt động với các cột có trong $fillable
             */
            $recipe = Recipe::create([

                // có thể dùng cái này 'user_id' => Auth::id(), => lấy user từ session hiện tại (guard mặc định), phụ thuộc vào guard config.

                // user_id lấy từ token (Sanctum)
                'user_id' => $request->user()->id, // nên là cái này nếu là Scantum => An toàn hơn trong API vì nó gắn trực tiếp với token của request.

                'category_id' => $validated['category_id'],
                'title' => $validated['title'],
                'description' => $validated['description'] ?? null,
                'servings' => $validated['servings'] ?? null,
                'cooking_time' => $validated['cooking_time'] ?? null,
                'difficulty' => $validated['difficulty'],

                // lưu đường dẫn ảnh món ăn
                'main_image' => $imagePath,

                // trạng thái mặc định
                'status' => 'Pending',
            ]);

            /**
             * =========================
             * 5. LƯU NGUYÊN LIỆU
             * =========================
             * - Ingredient dùng chung
             * - quantity, unit nằm ở bảng trung gian
             */
            // Kiểm tra xem có dữ liệu nguyên liệu gửi lên không 
            if (!empty($validated['ingredients'])) {

                // Lặp qua từng nguyên liệu trong mảng 
                foreach ($validated['ingredients'] as $item) {

                    // Nếu cả 3 field (name, quantity, unit) đều rỗng thì bỏ qua, không lưu DB 
                    if (empty($item['name']) && empty($item['quantity']) && empty($item['unit'])) {
                        continue;
                    }

                    /**
                     * firstOrCreate():
                     * - có rồi thì lấy
                     * - chưa có thì tạo mới
                     */

                    // Tìm hoặc tạo mới nguyên liệu theo tên (tránh trùng lặp tên nguyên liệu)
                    $ingredient = Ingredient::firstOrCreate([
                        'name' => strtolower(trim($item['name']))
                    ]);

                    /**
                     * attach():
                     * - lưu vào bảng trung gian
                     * - kèm quantity, unit
                     */

                    // Gắn nguyên liệu vào công thức (recipe) với số lượng và đơn vị 
                    // Nếu quantity hoặc unit rỗng thì gán null 
                    $recipe->ingredients()->attach($ingredient->id, [
                        'quantity' => $item['quantity'] ?? null,
                        'unit' => $item['unit'] ?? null,
                    ]);
                }
            }

            /**
             * =========================
             * 6. LƯU CÁC BƯỚC NẤU + ẢNH
             * =========================
             */
            foreach ($validated['steps'] as $index => $step) {

                /**
                 * $index:
                 * - là vị trí của bước trong mảng steps
                 * - dùng để lấy đúng file ảnh của bước đó
                 */
                $stepImagePath = null;

                /**
                 *  hasFile("steps.$index.media_url"):
                 * - truy cập mảng lồng nhau
                 * - kiểm tra bước này có upload ảnh không
                 */
                if ($request->hasFile("steps.$index.media_url")) {

                    /**
                     * store():
                     * - lưu ảnh từng bước
                     * - trả về đường dẫn
                     */

                    // Nếu có file ảnh thì lưu vào storage
                    $stepImagePath = $request
                        ->file("steps.$index.media_url")
                        ->store('recipe_steps', 'public');
                }

                /**
                 * steps() là quan hệ hasMany
                 * create() tự gán recipe_id
                 */

                // Tạo từng step trong DB
                $recipe->steps()->create([
                    'step_order' => $step['step_order'],
                    'instruction' => $step['instruction'],
                    'media_url' => $stepImagePath,
                ]);
            }

            /**
             * =========================
             * 7. HOÀN TẤT
             * =========================
             */
            DB::commit(); // nếu thành công thì lưu

            return response()->json([
                // Thông báo cho frontend biết tạo thành công
                'message' => 'Đăng công thức thành công, chờ duyệt',

                // Trả về luôn dữ liệu công thức vừa tạo (kèm steps, ingredients)
                // Lưu ý: vì status mặc định là Pending nên chỉ chủ sở hữu mới xem được chi tiết này
                // Người khác hoặc khách sẽ bị từ chối khi gọi show()
                'recipe' => $recipe->load(['ingredients', 'steps', 'category', 'user'])
            ], 201); // 201 = Created ---- đẫ tạo thành công nha mấy fen

        } catch (\Exception $e) {

            /**
             * Nếu có lỗi => hủy toàn bộ
             */
            DB::rollBack(); // nếu lỗi thì hủy toàn bộ, quay lại trạng thái trước khi giao dịch, ko lưu vĩnh viễn vào DB 
            //Log::error('Store recipe error: ' . $e->getMessage());
            Log::error('Store recipe error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json([
                'message' => 'Lỗi đăng công thức'
            ], 500);
        }
    }

    // Trang "Công thức của tôi" - dành cho member đã đăng nhập 
    // Dùng để lấy danh sách công thức của chính user (Pending / Published / Hidden)
    public function myRecipes(Request $request)
    {
        $user = $request->user()->id; // lấy user từ Sanctum token

        $recipes = Recipe::with([
            'category:id,name,slug',
            'ingredients:id,name',
            'steps:id,recipe_id,step_order'
        ])
            ->where('user_id', $user)
            ->orderByDesc('created_at')
            ->get();

        return response()->json([
            'message' => 'Danh sách công thức của bạn',
            'data' => $recipes->map(function ($recipe) {
                return [
                    'id' => $recipe->id,
                    'title' => $recipe->title,
                    'main_image' => $recipe->main_image,
                    'status' => $recipe->status, // Pending / Published / Hidden
                    'difficulty' => $recipe->difficulty,
                    'cooking_time' => $recipe->cooking_time,
                    'servings' => $recipe->servings,
                    'category' => $recipe->category,
                    'ingredients_count' => $recipe->ingredients->count(),
                    'steps_count' => $recipe->steps->count(),
                    'created_at' => $recipe->created_at->format('d/m/Y'),
                ];
            })->values(), // RẤT QUAN TRỌNG – để FE nhận array chuẩn
        ], 200);
    }

    /**
     * =========================
     * HÀM CẬP NHẬT CÔNG THỨC (XÓA HẾT RỒI THÊM LẠI)
     * =========================
     * - Chỉ cho phép chủ sở hữu công thức chỉnh sửa
     * - Validate dữ liệu bằng RecipeRequest (giống store)
     * - Nếu có ảnh mới thì upload lại, thay thế ảnh cũ
     * - Cập nhật các trường cơ bản
     * - Xóa steps/ingredients cũ rồi thêm lại từ payload mới
     * - Dùng transaction để đảm bảo toàn vẹn dữ liệu
     */
    public function update(RecipeRequest $request, $id)
    {
        // 1. Tìm công thức theo id và user_id (chỉ chủ sở hữu mới được sửa)
        $recipe = Recipe::where('id', $id)
            ->where('user_id', $request->user()->id)
            ->first();

        if (!$recipe) {
            return response()->json(['message' => 'Không tìm thấy công thức hoặc bạn không có quyền'], 404);
        }

        // 2. Lấy dữ liệu đã validate từ RecipeRequest
        $validated = $request->validated();

        // 3. Bắt đầu transaction
        DB::beginTransaction();

        try {
            /**
             * 4. Upload ảnh mới nếu có
             * - Nếu có ảnh mới thì thay thế ảnh cũ
             * - Nếu không thì giữ nguyên ảnh cũ
             */
            $imagePath = $recipe->main_image;
            if ($request->hasFile('main_image')) {
                // Xóa ảnh cũ để tránh rác trong storage
                // if ($recipe->main_image) {
                //     Storage::disk('public')->delete($recipe->main_image);
                // }
                $imagePath = $request->file('main_image')->store('recipes', 'public');
            }

            /**
             * 5. Cập nhật thông tin cơ bản
             * - Các trường: category_id, title, description, servings, cooking_time, difficulty
             * - main_image: đường dẫn ảnh mới (hoặc giữ ảnh cũ)
             * - status: reset về Pending để admin duyệt lại
             */
            $recipe->update([
                'category_id'  => $validated['category_id'],
                'title'        => $validated['title'],
                'description'  => $validated['description'] ?? null,
                'servings'     => $validated['servings'] ?? null,
                'cooking_time' => $validated['cooking_time'] ?? null,
                'difficulty'   => $validated['difficulty'],
                'main_image'   => $imagePath,
                'status'       => 'Pending',
            ]);

            /**
             * 6. Cập nhật nguyên liệu (Ingredients)
             * - detach(): xóa toàn bộ pivot cũ
             * - Lặp qua mảng ingredients mới
             * - firstOrCreate(): tránh trùng tên nguyên liệu
             * - attach(): gắn lại với quantity và unit
             */
            $recipe->ingredients()->detach();
            if (!empty($validated['ingredients'])) {
                foreach ($validated['ingredients'] as $item) {
                    if (empty($item['name']) && empty($item['quantity']) && empty($item['unit'])) {
                        continue;
                    }
                    $ingredient = Ingredient::firstOrCreate(['name' => strtolower(trim($item['name']))]);
                    $recipe->ingredients()->attach($ingredient->id, [
                        'quantity' => $item['quantity'] ?? null,
                        'unit'     => $item['unit'] ?? null,
                    ]);
                }
            }

            /**
             * 7. Cập nhật các bước nấu (Steps)
             * - delete(): xóa toàn bộ steps cũ
             * - Xóa cả ảnh cũ trong storage nếu có
             * - Lặp qua mảng steps mới
             * - Nếu có ảnh thì upload, lưu đường dẫn
             * - create(): thêm step mới vào DB
             */

            /**foreach ($recipe->steps as $oldStep) {
                if ($oldStep->media_url && Storage::disk('public')->exists($oldStep->media_url)) {
                    Storage::disk('public')->delete($oldStep->media_url);
                }
                $oldStep->delete();
            }*/

            $recipe->steps()->delete();
            foreach ($validated['steps'] as $index => $step) {
                $stepImagePath = null;
                if ($request->hasFile("steps.$index.media_url")) {
                    $stepImagePath = $request->file("steps.$index.media_url")->store('recipe_steps', 'public');
                }
                $recipe->steps()->create([
                    'step_order'   => $step['step_order'],
                    'instruction'  => $step['instruction'],
                    'media_url'    => $stepImagePath,
                ]);
            }

            // 8. Hoàn tất transaction
            DB::commit();

            // Trả về response JSON cho frontend
            return response()->json([
                'message' => 'Cập nhật công thức thành công, chờ duyệt',
                'recipe'  => $recipe->load(['ingredients', 'steps', 'category', 'user'])
            ], 200);
        } catch (\Exception $e) {
            // Nếu có lỗi thì rollback toàn bộ
            DB::rollBack();
            Log::error('Update recipe error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json(['message' => 'Lỗi cập nhật công thức'], 500);
        }
    }

    /**
     * =========================
     * HÀM XOÁ CÔNG THỨC (CHỦ SỞ HỮU)
     * =========================
     * Logic:
     * 1. Tìm công thức theo id.
     * 2. Kiểm tra quyền: chỉ chủ sở hữu mới được xoá.
     * 3. Nếu hợp lệ → gọi delete().
     *    - Nhờ migration đã set onDelete('cascade'):
     *      + steps sẽ tự xoá.
     *      + pivot ingredients cũng tự xoá.
     * 4. Không xoá ảnh trong storage (giữ nguyên).
     * 5. Trả về JSON thông báo.
     */
    public function destroy(Request $request, $id)
    {
        // 1. Tìm công thức theo id
        $recipe = Recipe::find($id);

        // 2. Nếu không tìm thấy => trả về 404
        if (!$recipe) {
            return response()->json(['message' => 'Không tìm thấy công thức'], 404);
        }

        // 3. Kiểm tra quyền: chỉ chủ sở hữu mới được xoá
        if ($recipe->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Bạn không có quyền xoá công thức này'], 403);
        }

        // 4. Xoá công thức (cascade sẽ lo phần steps + ingredients pivot)
        try {
            $recipe->delete();

            return response()->json([
                'message'    => 'Xoá công thức thành công',
                'deleted_id' => $recipe->id
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Lỗi khi xoá công thức'], 500);
        }
    }
}
