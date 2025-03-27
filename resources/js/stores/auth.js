import { defineStore } from 'pinia';
import { ref } from 'vue';
import apiClient from "../../axios";

export const useAuthStore = defineStore('auth', () => {
    const user = ref(null);
    const token = ref(localStorage.getItem('token') || null);
    const isAuthenticated = ref(!!token.value);

    // Login Function
    const login = async (email, password) => {
        try {
            const response = await apiClient.post('/login', { email, password });

            // Update state
            user.value = response.data.user;
            token.value = response.data.token;
            isAuthenticated.value = true;

            // Store token in localStorage
            localStorage.setItem('token', token.value);

            // Set token in Axios headers
            apiClient.defaults.headers.common['Authorization'] = `Bearer ${token.value}`;

            console.log('Logged in successfully!');
        } catch (error) {
            console.error('Login failed:', error.response?.data || error.message);
            throw error;
        }
    };

    // Register Function
    const register = async (name, email, password, passwordConfirmation) => {
        try {
            const response = await apiClient.post('/register', {
                name,
                email,
                password,
                password_confirmation: passwordConfirmation,
            });

            // Update state
            user.value = response.data.user;
            token.value = response.data.token;
            isAuthenticated.value = true;

            // Store the token in localStorage
            localStorage.setItem('token', token.value);

            // Set token in Axios headers
            apiClient.defaults.headers.common['Authorization'] = `Bearer ${token.value}`;

            console.log('Registered successfully!');
        } catch (error) {
            console.error('Registration failed:', error.response?.data || error.message);
            throw error;
        }
    };
    const updateProfile = async (formData) => {
        try {
            // Store current token before update
            const currentToken = token.value;
            
            // Make sure the token is in the headers
            apiClient.defaults.headers.common['Authorization'] = `Bearer ${currentToken}`;
            
            // Create a new FormData instance to prevent browser interference
            const cleanFormData = new FormData();
            for (let [key, value] of formData.entries()) {
                cleanFormData.append(key, value);
            }
            
            const response = await apiClient.post("/user/update", cleanFormData, {
                headers: { 
                    "Content-Type": "multipart/form-data",
                    "X-Requested-With": "XMLHttpRequest" // Add this to indicate AJAX request
                },
            });
    
            // Update user data while maintaining authentication
            user.value = response.data.user;
            token.value = currentToken;
            isAuthenticated.value = true;
            
            // Ensure token is set in localStorage and API client
            localStorage.setItem('token', currentToken);
            
            console.log("Profile updated successfully!");
            return response.data;
        } catch (error) {
            console.error("Profile update failed:", error.response?.data || error.message);
            throw error;
        }
    };
    

    // Logout Function
    const logout = async () => {
        try {
            await apiClient.post('/logout', null, {
                headers: {
                    Authorization: `Bearer ${token.value}`,
                },
            });

            // Clear state
            user.value = null;
            token.value = null;
            isAuthenticated.value = false;

            // Remove token from storage and Axios headers
            localStorage.removeItem('token');
            delete apiClient.defaults.headers.common['Authorization'];

            console.log('Logged out successfully!');
        } catch (error) {
            console.error('Logout failed:', error.response?.data || error.message);
            throw error;
        }
    };
    

    // Fetch Authenticated User
    const fetchUser = async () => {
        try {
            if (!token.value) {
                throw new Error('No token found');
            }

            // Set the token in the Axios headers
            apiClient.defaults.headers.common['Authorization'] = `Bearer ${token.value}`;

            // Fetch the authenticated user
            const response = await apiClient.get('/user');
            user.value = response.data;
            isAuthenticated.value = true;
        } catch (error) {
            console.error('Failed to fetch user:', error.response?.data || error.message);
            user.value = null;
            isAuthenticated.value = false;
            localStorage.removeItem('token'); // Clear invalid token
        }
    };

    return {
        user,
        token,
        isAuthenticated,
        updateProfile,
        login,
        register,
        logout,
        fetchUser,
    };
});