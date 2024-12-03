class MateriIslami {
    constructor(apiUrl) {
        this.apiUrl = apiUrl;  // Set the API URL
    }

    async fetchMateri(search = '') {
        try {
            const response = await fetch(`${this.apiUrl}?search=${search}`);
            if (!response.ok) {
                throw new Error('Failed to fetch data');
            }
            const data = await response.json();
            this.renderContent(data);
        } catch (error) {
            console.error('Error:', error);
            alert('Error fetching data');
        }
    }

    renderContent(data) {
        const title = document.getElementById('title');
        const authorInfo = document.getElementById('author-info');
        const meta = document.getElementById('meta');
        const content = document.getElementById('content');
        const tocList = document.getElementById('toc-list');
        const quote = document.getElementById('quote');

        // Clear previous content
        title.innerHTML = '';
        authorInfo.innerHTML = '';
        meta.innerHTML = '';
        content.innerHTML = '';
        tocList.innerHTML = '';
        quote.innerHTML = '';

        // If data is available, populate the view
        if (data && data.length > 0) {
            const materi = data[0];  // Use the first materi as an example

            title.textContent = materi.title;
            authorInfo.innerHTML = `Oleh ${materi.author} &nbsp;&bull;&nbsp; ${materi.date}`;
            meta.innerHTML = `<span>${materi.comments}</span> &bull; <span>${materi.views}</span> &bull; <span>${materi.readTime}</span>`;
            content.textContent = materi.content;

            // Render Table of Contents (using example data)
            const toc = materi.toc.split(';'); // Assuming toc is a semicolon-separated string
            toc.forEach(item => {
                const li = document.createElement('li');
                const a = document.createElement('a');
                a.href = '#';
                a.textContent = item;
                li.appendChild(a);
                tocList.appendChild(li);
            });

            quote.textContent = materi.quote;
        }
    }
}

// Initialize the MateriIslami class and fetch data when the page is ready
document.addEventListener("DOMContentLoaded", () => {
    const apiUrl = 'isi-materi.php';  // The API URL
    const materiIslami = new MateriIslami(apiUrl);

    // Fetch materi data without search parameter (you can add a search box for dynamic search)
    materiIslami.fetchMateri();
});
    