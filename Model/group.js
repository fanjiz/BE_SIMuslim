document.addEventListener("DOMContentLoaded", () => {
    const groupList = document.getElementById("groupList");
    const addGroupForm = document.getElementById("addGroupForm");

    async function fetchGroups() {
        const response = await fetch("../Controller/group.php");
        const groups = await response.json();

        groupList.innerHTML = ""; // Clear the old group list

        groups.forEach(group => {
            const groupItem = document.createElement("li");
            groupItem.className = "group-item list-group-item";
            groupItem.innerHTML = `
                <img src="../Controller/uploads/${group.profile_picture}" alt="${group.title}" class="group-img">
                <div class="group-info">
                    <h5 class="group-title">${group.title}</h5>
                    <small class="ustadz-name">${group.ustadz_name}</small>
                </div>
                <div class="group-actions">
                    <a href="chat.html?groupId=${group.id}" class="btn btn-success">Masuk</a>
                </div>
            `;
            groupList.appendChild(groupItem); // Add the group element to the list
        });
    }

    addGroupForm.addEventListener("submit", async (e) => {
        e.preventDefault();
        const formData = new FormData(addGroupForm);

        const response = await fetch("../Controller/group.php", {
            method: "POST",
            body: formData,
        });

        const result = await response.json();
        if (result.status === "success") {
            const modal = bootstrap.Modal.getInstance(document.getElementById("addGroupModal"));
            modal.hide();
            addGroupForm.reset();
            fetchGroups(); // Refresh the group list
        } else {
            alert("Failed to add group: " + result.error);
        }
    });

    fetchGroups(); // Fetch groups when the page loads
});
