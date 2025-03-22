import axios from "axios";

const apiClient = axios.create({
  baseURL: "http://127.0.0.1:8000/api", // Add the baseURL key
  headers: {
    "Content-Type": "application/json",
  },
  withCredentials: true, // Ensure credentials are sent with requests
});

export default apiClient;