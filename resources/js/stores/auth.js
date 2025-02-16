import { defineStore } from 'pinia';
import { ref } from 'vue';
import apiClient from "../../axios";

export const useAuthStore = defineStore('auth', () => {
    const user = ref(null);
    const token = ref(null);
    const isAuthenticated = ref(false);
  
    const login = async (email, password) => {
      try {
        const response = await apiClient.post('/login', { email, password });
    
        // Update state
        user.value = response.data.user;
        token.value = response.data.token;
        isAuthenticated.value = true;
    
        // Store the token in localStorage
        localStorage.setItem('token', token.value);
    
        console.log('Logged in successfully!');
      } catch (error) {
        console.error('Login failed:', error);
        throw error;
      }
    };
    
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
    
        console.log('Registered successfully!');
      } catch (error) {
        console.error('Registration failed:', error);
        throw error;
      }
    };
  
    const logout = async () => {
      try {
        await apiClient.post('/logout', null, {
          headers: {
            Authorization: `Bearer ${localStorage.getItem('token')}`,
          },
        });
    
        // Clear state
        user.value = null;
        token.value = null;
        isAuthenticated.value = false;
    
        // Remove the token from localStorage
        localStorage.removeItem('token');
    
        console.log('Logged out successfully!');
      } catch (error) {
        console.error('Logout failed:', error);
        throw error;
      }
    };
    const fetchUser = async () => {
      try {
        const token = localStorage.getItem('token');
        if (!token) {
          throw new Error('No token found');
        }
    
        // Set the token in the Axios headers
        apiClient.defaults.headers.common['Authorization'] = `Bearer ${token}`;
    
        // Fetch the authenticated user
        const response = await apiClient.get('/user');
        user.value = response.data;
        isAuthenticated.value = true;
      } catch (error) {
        user.value = null;
        isAuthenticated.value = false;
        localStorage.removeItem('token'); // Clear invalid token
      }
    };
  
    return {
      user,
      token,
      isAuthenticated,
      login,
      register,
      logout,
      fetchUser,
    };
  });

// export const useAuthStore = defineStore('auth', () => {
//   const user = ref(null);
//   const isAuthenticated = ref(false);

//   const login = async (email, password) => {
//     try {
//       await apiClient.get('/sanctum/csrf-cookie'); // Get CSRF cookie
//       await apiClient.post('/login', { email, password });

//       // Fetch the authenticated user
//       const response = await apiClient.get('/api/user');
//       user.value = response.data;
//       isAuthenticated.value = true;

//       console.log('Logged in successfully!');
//     } catch (error) {
//       console.error('Login failed:', error);
//       throw error;
//     }
//   };

//   const register = async (name, email, password, passwordConfirmation) => {
//     try {
//       await apiClient.get('/sanctum/csrf-cookie'); // Get CSRF cookie
//       await apiClient.post('/register', {
//         name,
//         email,
//         password,
//         password_confirmation: passwordConfirmation,
//       });
  
//       // Fetch the authenticated user
//       const response = await apiClient.get('/user');
//       user.value = response.data;
//       isAuthenticated.value = true;
  
//       console.log('Registered successfully!');
//     } catch (error) {
//       console.error('Registration failed:', error);
//       throw error;
//     }
//   };
  
//   const logout = async () => {
//     try {
//       await apiClient.post('/logout');
//       user.value = null;
//       isAuthenticated.value = false;

//       console.log('Logged out successfully!');
//     } catch (error) {
//       console.error('Logout failed:', error);
//       throw error;
//     }
//   };

//   const fetchUser = async () => {
//     try {
//       const response = await apiClient.get('/user');
//       user.value = response.data;
//       isAuthenticated.value = true;
//     } catch (error) {
//       user.value = null;
//       isAuthenticated.value = false;
//     }
//   };

//   return {
//     user,
//     isAuthenticated,
//     login,
//     register,
//     logout,
//     fetchUser,
//   };
// });
