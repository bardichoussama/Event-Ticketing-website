// src/utils/apiClient.js
import axios from 'axios';

const apiClient = axios.create({
  baseURL: 'http://127.0.0.1:8000/api', // Set the base URL for your API
  headers: {
    'Content-Type': 'application/json', // Default headers
  },
  withCredentials: true, // Include credentials if needed (for cookies or auth tokens)
});

export default apiClient;
