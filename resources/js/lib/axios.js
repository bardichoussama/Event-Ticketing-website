import axios from 'axios';

const apiClient = axios.create({
    baseURL: 'https://event-ticketing-website-main-f1hgvp.laravel.cloud/api',
    headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
    },
    withCredentials: true
});

// Add request interceptor for debugging
apiClient.interceptors.request.use(request => {
    console.log('Request:', request);
    return request;
});

// Add response interceptor for debugging
apiClient.interceptors.response.use(
    response => {
        console.log('Response:', response);
        return response;
    },
    error => {
        console.error('API Error:', error);
        return Promise.reject(error);
    }
);

export default apiClient; 