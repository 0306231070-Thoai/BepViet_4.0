@extends('layouts.app') @section('title', 'Trang chủ - Mạng xã hội nấu ăn')

@section('content')
   
          <div class="search-container">
            <img
              src="https://upload.wikimedia.org/wikipedia/commons/thumb/1/1f/Cookpad_logo.svg/1200px-Cookpad_logo.svg.png"
              alt="Cookpad"
              class="cookpad-logo-main"
            />
            <div class="search-box mt-3">
              <input
                type="text"
                class="form-control form-control-lg"
                placeholder="Tìm tên món hay nguyên liệu..."
              />
              <button class="btn-search">Tìm Kiếm</button>
            </div>
          </div>

          <h5 class="mb-3 text-secondary fw-bold">
            Từ Khóa Thịnh Hành
            <small
              class="float-end text-muted fw-normal"
              style="font-size: 0.8rem"
              >Cập nhật hôm nay</small
            >
          </h5>

          <div class="row g-3">
            <div class="col-6 col-md-3">
              <div class="trend-card">
                <img
                  src="https://images.unsplash.com/photo-1606509036365-5555c478bc0f?w=400&q=80"
                  alt="Heo"
                />
                <div class="trend-card-overlay">
                  <p class="trend-text">Món ngon từ heo</p>
                </div>
              </div>
            </div>
            <div class="col-6 col-md-3">
              <div class="trend-card">
                <img
                  src="https://images.unsplash.com/photo-1578985545062-69928b1d9587?w=400&q=80"
                  alt="Bánh"
                />
                <div class="trend-card-overlay">
                  <p class="trend-text">Bánh ngọt đơn giản</p>
                </div>
              </div>
            </div>
            <div class="col-6 col-md-3">
              <div class="trend-card">
                <img
                  src="https://images.unsplash.com/photo-1544025162-d76690b67f61?w=400&q=80"
                  alt="Thịt ba chỉ"
                />
                <div class="trend-card-overlay">
                  <p class="trend-text">Thịt ba chỉ</p>
                </div>
              </div>
            </div>
            <div class="col-6 col-md-3">
              <div class="trend-card">
                <img
                  src="https://images.unsplash.com/photo-1599084993091-1cb5c0721cc6?w=400&q=80"
                  alt="Cá hồi"
                />
                <div class="trend-card-overlay">
                  <p class="trend-text">Cá hồi</p>
                </div>
              </div>
            </div>
            <div class="col-6 col-md-3">
              <div class="trend-card">
                <img
                  src="https://images.unsplash.com/photo-1518977676605-dc56455512a5?w=400&q=80"
                  alt="Khoai tây"
                />
                <div class="trend-card-overlay">
                  <p class="trend-text">Món khoai tây</p>
                </div>
              </div>
            </div>
            <div class="col-6 col-md-3">
              <div class="trend-card">
                <img
                  src="https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=400&q=80"
                  alt="Gỏi"
                />
                <div class="trend-card-overlay">
                  <p class="trend-text">Gỏi / Nộm</p>
                </div>
              </div>
            </div>
            <div class="col-6 col-md-3">
              <div class="trend-card">
                <img
                  src="https://images.unsplash.com/photo-1544511916-0148ccdeb877?w=400&q=80"
                  alt="Sườn"
                />
                <div class="trend-card-overlay">
                  <p class="trend-text">Sườn xào</p>
                </div>
              </div>
            </div>
            <div class="col-6 col-md-3">
              <div class="trend-card">
                <img
                  src="https://images.unsplash.com/photo-1565557623262-b51c2513a641?w=400&q=80"
                  alt="Tôm"
                />
                <div class="trend-card-overlay">
                  <p class="trend-text">Món tôm</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    
@endsection