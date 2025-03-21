import axios from "axios";

const apiClient = axios.create({
  baseURL: process.env.NODE_ENV === "production" 
    ? "https://event-ticketing-website-main-eowjp7.laravel.cloud/api"  
    : "http://127.0.0.1:8000/api",
  headers: {
    "Content-Type": "application/json",
    "Accept": "application/json"
  },
  withCredentials: false, // Change this to false
});

// Then add the token to individual requests
apiClient.interceptors.request.use(config => {
  const token = localStorage.getItem('api_token');
  if (token) {
    config.headers['Authorization'] = `Bearer ${token}`;
  }
  return config;
});

export default apiClient;