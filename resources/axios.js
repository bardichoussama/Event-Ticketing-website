import axios from "axios";

// Dynamically set the baseURL based on the environment
const apiClient = axios.create({
  baseURL: process.env.NODE_ENV === "production" 
    ? "/api"  // Use relative path in production
    : "http://127.0.0.1:8000/api",  // Use localhost for development
  headers: {
    "Content-Type": "application/json",
  },
  withCredentials: true,
});

export default apiClient;
