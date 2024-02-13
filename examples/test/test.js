// Set up your API endpoint URL here
const apiUrl = 'https://jsonplaceholder.typicode.com/posts';

// Fetch function to make API call
async function fetchData() {
    try {
        // Make the API request using Fetch
        const response = await fetch(apiUrl);
        const data = await response.json();

        // Process the data as needed
        console.log('Posts:', data);
    } catch (error) {
        console.error('Error:', error);
    }
}

// Call the function to make API request
fetchData();