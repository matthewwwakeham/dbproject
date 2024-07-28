document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('searchForm');
    const input = document.getElementById('search-bar');
    const resultsContainer = document.getElementById('results-container');

    form.addEventListener('submit', function(event) {
        event.preventDefault(); // Prevents the default form submission behavior
        const query = input.value.trim();
        if (query) {
            fetch(`search.php?query=${encodeURIComponent(query)}`)
                .then(response => response.text())
                .then(data => {
                    resultsContainer.innerHTML = data;
                })
                .catch(error => {
                    console.error('Error:', error);
                    resultsContainer.innerHTML = 'An error occurred while searching.';
                });
        } else {
            resultsContainer.innerHTML = '';
        }
    });
});