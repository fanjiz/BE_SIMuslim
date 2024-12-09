// Fetch messages for the specific group
async function fetchMessages(groupId) {
    try {
        const response = await fetch(`../Controller/chat.php?groupId=${groupId}`);
        const messages = await response.json();

        const chatBox = document.getElementById('chatBox');
        chatBox.innerHTML = ''; // Clear the chat box

        messages.forEach(msg => {
            const messageElement = document.createElement('div');
            messageElement.classList.add('message');
            messageElement.innerHTML = `<strong>${msg.username}:</strong> ${msg.message}`;
            chatBox.appendChild(messageElement);
        });

        chatBox.scrollTop = chatBox.scrollHeight; // Scroll to the bottom
    } catch (error) {
        console.error('Error fetching messages:', error);
        alert('Failed to load messages');
    }
}

// Send a message
async function sendMessage(username, message, groupId) {
    try {
        const response = await fetch('../Controller/chat.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `username=${encodeURIComponent(username)}&message=${encodeURIComponent(message)}&groupId=${groupId}`
        });

        const result = await response.json();
        if (result.status === 'success') {
            fetchMessages(groupId); // Refresh the chat box
        } else {
            alert(result.message || 'Failed to send message');
        }
    } catch (error) {
        console.error('Error sending message:', error);
        alert('Failed to send message');
    }
}

// Initialize chat functionality
document.addEventListener('DOMContentLoaded', () => {
    const urlParams = new URLSearchParams(window.location.search);
    const groupId = urlParams.get('groupId');

    if (groupId) {
        fetchMessages(groupId);

        document.getElementById('chatForm').addEventListener('submit', async (e) => {
            e.preventDefault();

            const username = document.getElementById('username').value.trim();
            const message = document.getElementById('message').value.trim();

            if (username && message) {
                await sendMessage(username, message, groupId);
                document.getElementById('message').value = ''; // Clear the message input
            }
        });
    } else {
        alert('No group ID provided!');
        window.location.href = 'group.html';
    }
});
