// Function to add a new group
async function addGroup(groupName) {
    try {
        const response = await fetch('../Controller/group.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `name=${encodeURIComponent(groupName)}`,
        });

        const result = await response.json();
        if (result.status === 'success') {
            alert('Group added successfully!');
            fetchGroups(); // Refresh the group list
        } else {
            alert(result.message || 'Failed to add group');
        }
    } catch (error) {
        console.error('Error adding group:', error);
        alert('Failed to add group');
    }
}

// Event listener for adding a group
document.getElementById('addGroupForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    const groupNameInput = document.getElementById('groupName');
    const groupName = groupNameInput.value.trim();

    if (groupName === '') {
        alert('Please enter a group name');
        return;
    }

    await addGroup(groupName);
    groupNameInput.value = ''; // Reset the input
});

// Function to fetch and display groups
async function fetchGroups() {
    try {
        const response = await fetch('../Controller/group.php');
        const groups = await response.json();

        const groupList = document.getElementById('groupList');
        groupList.innerHTML = ''; // Clear the group list

        groups.forEach(group => {
            const groupElement = document.createElement('div');
            groupElement.classList.add('group-item');
            groupElement.innerText = group.name;
            groupElement.setAttribute('data-group-id', group.id);

            // Add event listener to navigate to the chat page
            groupElement.addEventListener('click', () => {
                window.location.href = `chat.html?groupId=${group.id}`;
            });

            groupList.appendChild(groupElement);
        });
    } catch (error) {
        console.error('Error fetching groups:', error);
        alert('Failed to load groups');
    }
}

// Fetch groups when the page loads
document.addEventListener('DOMContentLoaded', fetchGroups);
