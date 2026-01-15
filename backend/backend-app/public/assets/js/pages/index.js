document.addEventListener("DOMContentLoaded", function() {
    
    // --- 1. Xử lý Toggle Sidebar ---
    const el = document.getElementById("wrapper");
    const toggleButton = document.getElementById("menu-toggle");

    if (toggleButton) {
        toggleButton.onclick = function () {
            el.classList.toggle("toggled");
        };
    }

    // --- 2. Giả lập Đăng nhập / Đăng xuất ---
    const btnLogin = document.getElementById("btnLogin");
    const btnLogout = document.getElementById("btnLogout");
    const body = document.body;

    // Kiểm tra trạng thái đăng nhập từ LocalStorage (để khi F5 không bị mất)
    const isLoggedIn = localStorage.getItem("isLoggedIn") === "true";
    if (isLoggedIn) {
        setLoggedInState();
    } else {
        setGuestState();
    }

    // Sự kiện Đăng nhập
    if (btnLogin) {
        btnLogin.onclick = function(e) {
            e.preventDefault(); // Ngăn chuyển trang
            // Giả lập loading hoặc chuyển hướng nếu cần
            // Ở đây ta chuyển trạng thái trực tiếp
            localStorage.setItem("isLoggedIn", "true");
            setLoggedInState();
            alert("Đăng nhập thành công! Chào mừng Thoại Developer.");
        };
    }

    // Sự kiện Đăng xuất
    if (btnLogout) {
        btnLogout.onclick = function(e) {
            e.preventDefault();
            localStorage.setItem("isLoggedIn", "false");
            setGuestState();
            alert("Đã đăng xuất.");
        };
    }

    // Hàm chuyển giao diện sang Đã đăng nhập
    function setLoggedInState() {
        body.classList.remove("guest");
        body.classList.add("logged-in");
    }

    // Hàm chuyển giao diện sang Khách
    function setGuestState() {
        body.classList.remove("logged-in");
        body.classList.add("guest");
    }

    // --- 3. Xử lý nút A.I Gợi ý (Demo animation) ---
    const aiButton = document.querySelector(".btn-ai-magic");
    if(aiButton) {
        aiButton.addEventListener("click", function() {
            // Có thể thêm logic reset form trong modal tại đây
            console.log("Mở trợ lý AI...");
        });
    }
});

 (function() {
            const isLoggedIn = localStorage.getItem("isLoggedIn") === "true";
            if (isLoggedIn) {
                document.documentElement.classList.add('logged-in');
                document.documentElement.classList.remove('guest');
            } else {
                document.documentElement.classList.add('guest');
                document.documentElement.classList.remove('logged-in');
            }
        })();