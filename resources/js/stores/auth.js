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
            const response = await apiClient.post("/user/update", formData, {
                headers: { "Content-Type": "multipart/form-data" },
            });
    
            user.value = response.data.user;
            console.log("Profile updated successfully!");
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
