import { defineStore } from "pinia";
import { ref } from "vue";
import apiClient from "../../axios";

export const useCategoryStore = defineStore('category', () => {
    const categories = ref([]); 
    const loading = ref(false); 
    const error = ref(null); 

    const fetchCategories = async () => {
      loading.value = true;
      error.value = null;
      try {
        const response = await apiClient.get('/categories');

        categories.value = response.data.map(category => ({
          id: category.id, 
          title: category.title, 
          image: category.image,
        }));

      } catch (err) {
        console.error('Error fetching categories:', err);
        error.value = 'Failed to load categories';
      } finally {
        loading.value = false;
      }
    };
  
    return { categories, loading, error, fetchCategories };
});