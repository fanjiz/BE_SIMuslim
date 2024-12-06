document.addEventListener('DOMContentLoaded', function() {
    const groupId = new URLSearchParams(window.location.search).get('groupId');
    document.getElementById('groupId').value = groupId;
    fetchMessages(groupId);
});

// Function to fetch messages
async function fetchMessages(groupId) {
    try {
        const response = await fetch(`../Controller/chat.php?group_id=${groupId}`);
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        const messages = await response.json();

        const chatBox = document.getElementById('chatBox');
        chatBox.innerHTML = '';

        messages.forEach(msg => {
            const messageElement = document.createElement('div');
            messageElement.classList.add('message');
            messageElement.innerHTML = `<strong>${msg.username}:</strong> ${msg.message}`;
            chatBox.appendChild(messageElement);
        });

        chatBox.scrollTop = chatBox.scrollHeight;
    } catch (error) {
        console.error('Error fetching messages:', error);
        alert('Failed to load messages');
    }
}

// Function to send a message
document.getElementById('chatForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    const userId = document.getElementById('userId').value;
    const groupId = document.getElementById('groupId').value;
    const message = document.getElementById('chatMessage').value.trim();

    if (message === '') {
        alert('Please enter a message');
        return;
    }

    try {
        const response = await fetch('../Controller/chat.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `group_id=${groupId}&user_id=${userId}&message=${encodeURIComponent(message)}`,
        });

        const result = await response.json();
        if (result.status === 'success') {
            document.getElementById('chatMessage').value = '';
            fetchMessages(groupId);
        } else {
            alert(result.message || 'Failed to send message');
        }
    } catch (error) {
        console.error('Error sending message:', error);
        alert('Failed to send message');
    }
});
