import axios from "axios";

const apiClient = axios.create({
  baseURL: process.env.NODE_ENV === "production" 
    ? "https://event-ticketing-website-main-eowjp7.laravel.cloud/api"  
    : "http://127.0.0.1:8000/api",
  headers: {
    "Content-Type": "application/json",
  },
  withCredentials: true,
});

export default apiClient;