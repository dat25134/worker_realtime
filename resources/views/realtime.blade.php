<!DOCTYPE html>
<html>
<head>
    <title>Real-time Data Processing Demo</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-2xl mx-auto">
        <h1 class="text-3xl font-bold mb-6">Real-time Data Processing Demo</h1>

        <div class="bg-white rounded-lg shadow p-6">
            <button id="startButton"
                    class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Start Processing
            </button>

            <button id="stopButton"
                    class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 ml-2">
                Stop Processing
            </button>

            <div class="mt-6">
                <h2 class="text-xl font-semibold mb-3">Results:</h2>
                <div id="results" class="space-y-2">
                    <!-- Kết quả sẽ được hiển thị ở đây -->
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let worker = null;
            const resultsDiv = document.getElementById('results');
            const startButton = document.getElementById('startButton');
            const stopButton = document.getElementById('stopButton');

            // Khởi tạo worker
            function initWorker() {
                worker = new Worker('/js/worker.js');

                // Xử lý dữ liệu nhận được từ worker
                worker.onmessage = function(e) {
                    const result = e.data;

                    // Tạo element hiển thị kết quả
                    const resultElement = document.createElement('div');
                    resultElement.className = 'bg-gray-50 p-3 rounded';
                    resultElement.innerHTML = `
                        <div class="text-sm">
                            <span class="font-semibold">Count:</span> ${result.count}
                        </div>
                        <div class="text-sm">
                            <span class="font-semibold">Time:</span> ${result.timestamp}
                        </div>
                        <div class="text-sm">
                            <span class="font-semibold">Data:</span> ${result.data.toFixed(2)}
                        </div>
                    `;

                    // Thêm vào đầu danh sách kết quả
                    resultsDiv.insertBefore(resultElement, resultsDiv.firstChild);

                    // Giới hạn số lượng kết quả hiển thị
                    if (resultsDiv.children.length > 10) {
                        resultsDiv.removeChild(resultsDiv.lastChild);
                    }
                };
            }

            // Xử lý sự kiện click nút Start
            startButton.addEventListener('click', function() {
                if (!worker) {
                    initWorker();
                    worker.postMessage('start');
                    startButton.disabled = true;
                    startButton.classList.add('opacity-50');
                }
            });

            // Xử lý sự kiện click nút Stop
            stopButton.addEventListener('click', function() {
                if (worker) {
                    worker.terminate();
                    worker = null;
                    startButton.disabled = false;
                    startButton.classList.remove('opacity-50');
                }
            });
        });
    </script>
</body>
</html>
