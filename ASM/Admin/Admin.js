document.addEventListener("DOMContentLoaded", () => {
    // Tìm tất cả các liên kết có class 'toggle-link'
    const toggleLinks = document.querySelectorAll('.toggle-link');
    const toggleLinks1 = document.querySelectorAll('.toggle-link-1'); // Đảm bảo tên biến đúng

    // Kiểm tra và gán sự kiện cho các phần tử có class 'toggle-link'
    if (toggleLinks.length > 0) {
        toggleLinks.forEach(link => {
            link.addEventListener('click', (event) => {
                event.preventDefault(); // Ngăn chặn hành vi mặc định của liên kết

                // Tìm menu con (submenu) liên quan
                const submenu = link.nextElementSibling;
                if (submenu && submenu.classList.contains('submenu')) {
                    submenu.classList.toggle('collapse'); // Hiển thị/ẩn menu con
                    link.classList.toggle('expanded'); // Thay đổi trạng thái mũi tên
                }
            });
        });
    } else {
        console.warn("Không tìm thấy phần tử nào với class 'toggle-link'.");
    }

    // Kiểm tra và gán sự kiện cho các phần tử có class 'toggle-link-1'
    if (toggleLinks1.length > 0) {
        toggleLinks1.forEach(link => {
            link.addEventListener('click', (event) => {
                event.preventDefault(); // Ngăn chặn hành vi mặc định của liên kết

                // Tìm menu con (submenu) liên quan
                const submenu = link.nextElementSibling;
                if (submenu && submenu.classList.contains('submenu')) {
                    submenu.classList.toggle('collapse'); // Hiển thị/ẩn menu con
                    link.classList.toggle('expanded'); // Thay đổi trạng thái mũi tên
                }
            });
        });
    } else {
        console.warn("Không tìm thấy phần tử nào với class 'toggle-link-1'.");
    }
});
