let counter = 0;

// Hàm mô phỏng xử lý dữ liệu
function processData() {
    counter++;

    // Mô phỏng tính toán phức tạp
    let result = {
        count: counter,
        timestamp: new Date().toISOString(),
        data: Math.random() * 1000
    };

    // Gửi kết quả về main thread
    postMessage(result);
}

// Lắng nghe message từ main thread
self.onmessage = function(e) {
    if (e.data === 'start') {
        // Thực hiện xử lý mỗi giây
        setInterval(processData, 1000);
    }
};
