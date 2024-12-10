document.addEventListener("DOMContentLoaded", () => {
    const fetchAndDisplayData = async (type, tableId) => {
        try {
            const response = await fetch(`../Controller/admin.php?type=${type}`);
            if (!response.ok) throw new Error("Gagal memuat data");

            const data = await response.json();
            displayData(data, tableId);
        } catch (error) {
            console.error("Error:", error);
            document.querySelector(`#${tableId} tbody`).innerHTML = `
                <tr><td colspan="7">Gagal memuat data</td></tr>`; // Update jumlah kolom jika gagal
        }
    };

    const displayData = (data, tableId) => {
        const tableBody = document.querySelector(`#${tableId} tbody`);
        tableBody.innerHTML = "";

        data.forEach((item) => {
            const row = document.createElement("tr");

            if (tableId === "materiTable") {
                row.innerHTML = `
                    <td>${item.id}</td>
                    <td>${item.title}</td>
                    <td>${item.description}</td>
                    <td>${item.author}</td>
                    <td>${new Date(item.date).toLocaleString()}</td>
                    <td>
                        <button class="lihat-button" data-id="${item.id}">Lihat</button>
                    </td>
                    <td>
                        <img src="${item.image}" alt="Image" style="max-width: 100px; height: auto;">
                    </td>`;
            }
            
            
            tableBody.appendChild(row);
        });
    };

    // Memuat data dari tabel materi
    fetchAndDisplayData("materi", "materiTable");

    document.addEventListener("click", (event) => {
        if (event.target.classList.contains("lihat-button")) {
            const materiId = event.target.getAttribute("data-id");
            // Redirect ke halaman detail materi
            window.location.href = `../Controller/isi-materi.php?id=${materiId}`;
        }
    });
    
});
