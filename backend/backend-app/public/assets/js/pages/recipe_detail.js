var el = document.getElementById("wrapper");
        var toggleButton = document.getElementById("menu-toggle");
        toggleButton.onclick = function () { el.classList.toggle("toggled"); };

        // Xử lý nút Lưu món ăn
        function toggleSave() {
            const btn = document.getElementById('btnSave');
            const icon = btn.querySelector('i');
            const span = btn.querySelector('span');
            
            if (span.innerText === "Lưu món ăn") {
                span.innerText = "Đã lưu";
                icon.classList.remove('fa-regular');
                icon.classList.add('fa-solid');
                btn.classList.replace('btn-primary-cookpad', 'btn-secondary');
            } else {
                span.innerText = "Lưu món ăn";
                icon.classList.remove('fa-solid');
                icon.classList.add('fa-regular');
                btn.classList.replace('btn-secondary', 'btn-primary-cookpad');
            }
        }