import axios from "axios";

// Dynamically set the baseURL based on the environment
const apiClient = axios.create({
  baseURL: import.meta.env.VITE_API_BASE_URL || "http://127.0.0.1:8000/api",  // Default to localhost for dev
  headers: {
    "Content-Type": "application/json",
  },
  withCredentials: true,
});

export default apiClient;
