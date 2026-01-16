<div class="modal fade" id="aiModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg">
          <div class="modal-header bg-light border-0">
            <h5 class="modal-title fw-bold text-primary">
              <i class="fa-solid fa-robot me-2"></i>Trợ lý Bếp A.I
            </h5>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
            ></button>
          </div>
          <div class="modal-body p-4">
            <div class="row">
              <div class="col-md-6 border-end">
                <label class="form-label fw-bold"
                  >Trong tủ lạnh bạn có gì?</label
                >
                <textarea
                  class="form-control mb-3"
                  rows="4"
                  placeholder="Ví dụ: 2 quả trứng, 1 mớ rau muống, thịt bò thừa..."
                ></textarea>

                <label class="form-label fw-bold">Bạn muốn ăn kiểu gì?</label>
                <select class="form-select mb-4">
                  <option selected>Tất cả</option>
                  <option>Món nhanh (dưới 15p)</option>
                  <option>Eat Clean / Healthy</option>
                  <option>Món nhậu</option>
                </select>

                <button
                  class="btn btn-ai-magic w-100 py-2 rounded-3 justify-content-center"
                >
                  <i class="fa-solid fa-wand-magic-sparkles"></i> Phân tích &
                  Gợi ý ngay
                </button>
              </div>
              <div class="col-md-6 ps-md-4 mt-4 mt-md-0 text-center">
                <img
                  src="https://cdn-icons-png.flaticon.com/512/4712/4712009.png"
                  width="100"
                  class="mb-3 opacity-50"
                />
                <h6 class="text-muted">A.I đang chờ nguyên liệu từ bạn...</h6>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
