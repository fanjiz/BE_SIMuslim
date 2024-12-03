document.addEventListener("DOMContentLoaded", () => {
    const contentContainer = document.getElementById("content-container");
    const searchInput = document.getElementById("search-input");
    const searchButton = document.getElementById("search-button");

    // Function to render content dynamically
    const renderContent = (data) => {
        contentContainer.innerHTML = ""; // Clear container

        if (data.length === 0) {
            contentContainer.innerHTML = `<div class="col-12 text-center">No content found.</div>`;
            return;
        }

        // Loop through data and create cards
        data.forEach(item => {
            const card = document.createElement("div");
            card.className = "col-md-4";

            card.innerHTML = `
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">${item.title}</h5>
                        <p class="card-text">${item.description}</p>
                        <button class="btn btn-primary">Read More</button>
                    </div>
                </div>
            `;

            contentContainer.appendChild(card);
        });
    };

    // Function to fetch data from the API
    const fetchAndRenderContent = async (searchTerm = "") => {
        try {
            const response = await fetch(`api.php?search=${encodeURIComponent(searchTerm)}`);
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            const data = await response.json();
            console.log("API Response:", data); // Debugging step
            renderContent(data);
        } catch (error) {
            console.error("Error fetching content:", error.message);
            contentContainer.innerHTML = `<div class="col-12 text-center text-danger">Failed to load content.</div>`;
        }
    };

    // Initial fetch on page load
    fetchAndRenderContent();

    // Search functionality
    searchButton.addEventListener("click", () => {
        const searchTerm = searchInput.value.trim();
        fetchAndRenderContent(searchTerm);
    });

    searchInput.addEventListener("keyup", (event) => {
        if (event.key === "Enter") {
            const searchTerm = searchInput.value.trim();
            fetchAndRenderContent(searchTerm);
        }
    });
});
