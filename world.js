document.addEventListener('DOMContentLoaded', () => {
    const lookupBtn = document.getElementById('lookup');
    const lookupCitiesBtn = document.getElementById('lookup-cities');
    const countryInput = document.getElementById('country');
    const resultDiv = document.getElementById('result');

    // Helper function to handle fetch and error management
    function performFetch(url) {
        fetch(url)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response failed');
                }
                return response.text();
            })
            .then(data => {
                resultDiv.innerHTML = data;
            })
            .catch(error => {
                console.error('Error:', error);
                resultDiv.innerHTML = '<p>Error loading data.</p>';
            });
    }

    // Country lookup button
    lookupBtn.addEventListener('click', () => {
        const query = countryInput.value.trim();
        const encodedQuery = encodeURIComponent(query);
        performFetch(`world.php?country=${encodedQuery}`);
    });

    // Cities lookup button (Exercise 5)
    lookupCitiesBtn.addEventListener('click', () => {
        const query = countryInput.value.trim();
        const encodedQuery = encodeURIComponent(query);
        performFetch(`world.php?country=${encodedQuery}&lookup=cities`);
    });
});