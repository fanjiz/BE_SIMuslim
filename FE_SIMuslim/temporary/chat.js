// Fungsi untuk mengambil pesan dari grup tertentu dan menampilkan di halaman chat
async function fetchMessages() {
    try {
        // Ambil ID grup dari URL
        const urlParams = new URLSearchParams(window.location.search);
        const group_id = urlParams.get('group_id');

        // Fetch data pesan dari server
        const response = await fetch(`../Controller/chat.php?group_id=${group_id}`);
        if (!response.ok) throw new Error('Gagal mengambil pesan dari server');
        
        const messages = await response.json();

        // Bersihkan chat box sebelum menambahkan pesan baru
        const chatBox = document.getElementById('chatBox');
        chatBox.innerHTML = '';

        // Tampilkan setiap pesan di dalam chat box
        messages.forEach(msg => {
            const messageElement = document.createElement('div');
            messageElement.classList.add('message');
            messageElement.innerHTML = `
                <strong>${msg.username}</strong>: 
                ${msg.message} 
                <span class="time">${new Date(msg.created_at).toLocaleString()}</span>
            `;
            chatBox.appendChild(messageElement);
        });

        // Scroll otomatis ke bawah
        chatBox.scrollTop = chatBox.scrollHeight;
    } catch (error) {
        console.error('Error fetching messages:', error);
    }
}

// Fungsi untuk mengirim pesan baru
async function sendMessage(username, message) {
    try {
        // Ambil ID grup dari URL
        const urlParams = new URLSearchParams(window.location.search);
        const group_id = urlParams.get('group_id');

        // Kirim data pesan ke server
        const response = await fetch('../Controller/chat.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `group_id=${group_id}&username=${encodeURIComponent(username)}&message=${encodeURIComponent(message)}`,
        });

        const result = await response.json();

        // Cek respons server
        if (result.status === 'success') {
            // Refresh pesan setelah berhasil mengirim
            fetchMessages();

            // Kosongkan input field
            const messageInput = document.getElementById('messageInput');
            if (messageInput) messageInput.value = '';
        } else {
            alert('Gagal mengirim pesan: ' + (result.error || 'Kesalahan tidak diketahui'));
        }
    } catch (error) {
        console.error('Error sending message:', error);
        alert('Terjadi kesalahan saat mengirim pesan');
    }
}

// Fungsi untuk inisialisasi chat, termasuk tombol kirim dan auto-refresh
function initializeChat() {
    // Set auto-refresh pesan setiap 3 detik
    setInterval(fetchMessages, 3000);

    // Event listener untuk tombol kirim
    const sendButton = document.getElementById('sendButton');
    const messageInput = document.getElementById('messageInput');
    const usernameInput = document.getElementById('usernameInput');

    sendButton.addEventListener('click', () => {
        const username = usernameInput.value.trim();
        const message = messageInput.value.trim();

        if (username && message) {
            sendMessage(username, message);
        } else {
            alert('Mohon isi username dan pesan');
        }
    });

    // Optional: Kirim pesan dengan tombol Enter
    messageInput.addEventListener('keypress', (event) => {
        if (event.key === 'Enter') {
            const username = usernameInput.value.trim();
            const message = messageInput.value.trim();

            if (username && message) {
                sendMessage(username, message);
                event.preventDefault(); // Hindari submit form
            }
        }
    });
}

// Jalankan fungsi inisialisasi ketika halaman selesai dimuat
document.addEventListener('DOMContentLoaded', initializeChat);
