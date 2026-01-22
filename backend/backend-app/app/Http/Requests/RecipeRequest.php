<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RecipeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Cho phép tất cả user đã đăng nhập gọi request này
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */

    // rules: quy định dữ liệu phải hợp lệ như thế nào
    public function rules(): array
    {
        return [
            // Recipe info

            /**
             * =========================
             * ẢNH MÓN ĂN
             * =========================
             * main_image:
             * - nullable: có thể không upload
             * - image: phải là file ảnh
             * - mimes: chỉ chấp nhận jpg, jpeg, png
             */
            'main_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // 2MB max

            /**
             * category_id:
             * - required: bắt buộc phải có
             * - exists: kiểm tra id có tồn tại trong bảng categories không
             */
            'category_id' => 'required|exists:categories,id',

            /**
             * title:
             * - required: bắt buộc
             * - string: phải là chuỗi
             * - max:255: không vượt quá 255 ký tự
             */
            'title' => 'required|string|max:255|filled',

            /**
             * description:
             * - nullable: có thể không gửi
             * - string: nếu có thì phải là chuỗi
             */
            'description' => 'nullable|string|filled',

            /**  
             * servings: 
             *  - nullable 
             *  - integer 
             *  - min:1: thêm ràng buộc mới để tránh nhập số âm hoặc 0 
             */
            'servings' => 'nullable|integer|min:1',

            /**
             * cooking_time:
             * - nullable: không bắt buộc
             * - integer: phải là số nguyên (phút)
             * - min:1: thêm ràng buộc mới để tránh nhập số âm hoặc 0
             */
            'cooking_time' => 'nullable|integer|min:1',

            /**
             * difficulty:
             * - required: bắt buộc
             * - in: chỉ cho 3 giá trị cố định
             */
            'difficulty' => 'required|in:Easy,Medium,Hard',

            // Ingredients

            /**
             * =========================
             * NGUYÊN LIỆU (KHÔNG BẮT BUỘC)
             * =========================
             * ingredients:
             * - nullable: có thể không gửi
             * - array: nếu gửi thì phải là mảng
             */
            'ingredients' => 'nullable|array',

            /**
             * ingredients.*:
             * - validate từng nguyên liệu
             */

            // name bắt buộc nếu có quantity hoặc unit
            'ingredients.*.name' => 'nullable|string|max:255|filled|required_with:ingredients.*.quantity,ingredients.*.unit',

            // quantity bắt buộc nếu có unit
            'ingredients.*.quantity' => 'nullable|numeric|min:0.5|required_with:ingredients.*.unit,ingredients.*.name',

            // unit bắt buộc nếu có quantity
            'ingredients.*.unit' => 'nullable|string|max:50|filled|required_with:ingredients.*.quantity,ingredients.*.name',

            // Steps

            /**
             * =========================
             * BƯỚC NẤU
             * =========================
             * steps:
             * - required: bắt buộc có
             * - array: phải là mảng
             * - min:1: ít nhất 1 bước nấu
             */
            'steps' => 'required|array|min:1',

            /**
             * steps.*:
             * - dấu * đại diện cho từng phần tử trong mảng
             * - dùng để validate từng bước nấu
             */
            'steps.*.step_order' => 'required|integer|min:1|distinct',
            'steps.*.instruction' => 'required|string|filled',

            /**
             * Ảnh từng bước nấu
             * - không bắt buộc
             */
            'steps.*.media_url' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // 2MB max cho mỗi bước 
        ];
    }

    /**
     * Custom error messages
     */

    // messages: thông báo lỗi custom cho từng field 
    public function messages(): array
    {
        return [
            // main_image 
            'main_image.image' => 'Ảnh món ăn phải là file hình.',
            'main_image.mimes' => 'Ảnh món ăn chỉ chấp nhận định dạng jpg, jpeg, png.',
            'main_image.max' => 'Ảnh món ăn không được vượt quá 2MB.',

            // category_id 
            'category_id.required' => 'Danh mục là bắt buộc.',
            'category_id.exists' => 'Danh mục không tồn tại.',

            // title 
            'title.required' => 'Tiêu đề công thức là bắt buộc.',
            'title.string' => 'Tiêu đề phải là chuỗi.',
            'title.max' => 'Tiêu đề không được vượt quá 255 ký tự.',
            'title.filled' => 'Tiêu đề không được chỉ toàn khoảng trắng.',

            // description 
            'description.string' => 'Mô tả phải là chuỗi.',
            'description.filled' => 'Mô tả không được chỉ toàn khoảng trắng.',

            // servings 
            'servings.integer' => 'Số khẩu phần phải là số nguyên.',
            'servings.min' => 'Số khẩu phần phải lớn hơn 0.',

            // cooking_time 
            'cooking_time.integer' => 'Thời gian nấu phải là số nguyên (phút).',
            'cooking_time.min' => 'Thời gian nấu phải lớn hơn 0.',

            // difficulty 
            'difficulty.required' => 'Độ khó là bắt buộc.',
            'difficulty.in' => 'Độ khó chỉ chấp nhận: Easy, Medium, Hard.',

            // ingredients 
            'ingredients.array' => 'Nguyên liệu phải là mảng.',

            // ingredients.*.name 
            'ingredients.*.name.required_with' => 'Tên nguyên liệu là bắt buộc khi có số lượng hoặc đơn vị.',
            'ingredients.*.name.string' => 'Tên nguyên liệu phải là chuỗi.',
            'ingredients.*.name.max' => 'Tên nguyên liệu không được vượt quá 255 ký tự.',
            'ingredients.*.name.filled' => 'Tên nguyên liệu không được chỉ toàn khoảng trắng.',

            // ingredients.*.quantity 
            'ingredients.*.quantity.required_with' => 'Số lượng nguyên liệu là bắt buộc khi có đơn vị hoặc tên.',
            'ingredients.*.quantity.numeric' => 'Số lượng nguyên liệu phải là số (có thể số thập phân).',
            'ingredients.*.quantity.min' => 'Số lượng nguyên liệu phải từ 0.5 trở lên.',

            // ingredients.*.unit 
            'ingredients.*.unit.required_with' => 'Đơn vị nguyên liệu là bắt buộc khi có số lượng hoặc tên.',
            'ingredients.*.unit.string' => 'Đơn vị nguyên liệu phải là chuỗi.',
            'ingredients.*.unit.max' => 'Đơn vị nguyên liệu không được vượt quá 50 ký tự.',
            'ingredients.*.unit.filled' => 'Đơn vị nguyên liệu không được chỉ toàn khoảng trắng.',

            // steps 
            'steps.required' => 'Phải có ít nhất một bước nấu.',
            'steps.array' => 'Các bước nấu phải là mảng.',
            'steps.min' => 'Phải có ít nhất một bước nấu.',

            // steps.*.step_order 
            'steps.*.step_order.required' => 'Mỗi bước nấu phải có thứ tự.',
            'steps.*.step_order.integer' => 'Thứ tự bước phải là số nguyên.',
            'steps.*.step_order.min' => 'Thứ tự bước phải lớn hơn 0.',
            'steps.*.step_order.distinct' => 'Thứ tự bước nấu không được trùng lặp trong cùng một công thức.',

            // steps.*.instruction 
            'steps.*.instruction.required' => 'Mỗi bước nấu phải có hướng dẫn.',
            'steps.*.instruction.string' => 'Hướng dẫn phải là chuỗi.',
            'steps.*.instruction.filled' => 'Hướng dẫn bước nấu không được chỉ toàn khoảng trắng.',

            // steps.*.media_url 
            'steps.*.media_url.image' => 'Ảnh bước nấu phải là file hình.',
            'steps.*.media_url.mimes' => 'Ảnh bước nấu chỉ chấp nhận jpg, jpeg, png.',
            'steps.*.media_url.max' => 'Ảnh bước nấu không được vượt quá 2MB.',
        ];
    }
}
