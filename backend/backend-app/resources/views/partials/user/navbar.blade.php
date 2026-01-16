
    <nav class="navbar navbar-expand-lg navbar-light bg-transparent border-bottom-0 mb-3">
        <div class="container-fluid ps-0">
            <button
              class="btn btn-outline-secondary border-0 d-md-none me-2"
              id="mobile-menu-toggle"
            >
              <i class="fa-solid fa-bars fs-5"></i>
            </button>

            <div class="ms-auto d-flex align-items-center gap-3">
              <div class="guest-only d-flex gap-2">
                <a
                  href="login.html"
                  id="btnLogin"
                  class="btn btn-outline-secondary"
                  >Đăng nhập</a
                >
                <a href="login.html" class="btn btn-primary-cookpad">Đăng ký</a>
              </div>

                <div class="user-only d-flex align-items-center gap-3">
                    <button
                    class="btn btn-ai-magic rounded-pill px-3"
                    data-bs-toggle="modal"
                    data-bs-target="#aiModal"
                    >
                    <i class="fa-solid fa-wand-magic-sparkles"></i>
                    <span class="d-none d-md-inline">A.I Gợi ý</span>
                    </button>

                    <div class="dropdown">
                        <div
                            data-bs-toggle="dropdown"
                            aria-expanded="false"
                            style="cursor: pointer"
                        >
                            <img
                            src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?w=100&q=80"
                            alt="Avatar"
                            class="user-avatar"
                            />
                        </div>
                    <ul
                        class="dropdown-menu dropdown-menu-end shadow border-0 mt-2"
                    >
                        <li class="px-3 py-2 border-bottom mb-2">
                        <div class="fw-bold text-dark">Thoại Developer</div>
                        <small class="text-muted">thoai@example.com</small>
                        </li>
                        <li>
                        <a class="dropdown-item" href="cookbook.html"
                            ><i class="fa-solid fa-book-bookmark me-2"></i> Quản lý
                            Cookbook</a
                        >
                        </li>
                        <li>
                        <a class="dropdown-item" href="my_recipes.html"
                            ><i class="fa-solid fa-utensils me-2"></i> Quản lý Công
                            thức</a
                        >
                        </li>
                        <li>
                        <a class="dropdown-item" href="profile.html"
                            ><i class="fa-regular fa-id-card me-2"></i> Hồ sơ của
                            tôi</a
                        >
                        </li>
                        <li><hr class="dropdown-divider" /></li>
                        <li>
                        <a
                            href="#"
                            id="btnLogout"
                            class="dropdown-item text-danger"
                        >
                            <i class="fa-solid fa-right-from-bracket me-2"></i> Đăng
                            xuất
                        </a>
                        </li>
                    </ul>
                </div>

                <a href="create-recipe.html" class="btn btn-primary-cookpad">
                  <i class="fa-solid fa-plus"></i>
                  <span class="d-none d-md-inline">Viết món</span>
                </a>
              </div>
            </div>
        </div>
    </nav>
