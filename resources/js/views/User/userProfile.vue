<template>
    <div class="p-8 max-w-4xl mx-auto bg-white">
      <h1 class="text-3xl font-bold mb-6 text-gray-800">User Profile</h1>
      
      <!-- Profile Card -->
      <Card className="bg-violet-50 rounded-lg">    
        <CardHeader>
          <CardTitle className="text-xl">Personal Information</CardTitle>
          <CardDescription>View and manage your account details</CardDescription>
        </CardHeader>
        
        <CardContent>
          <div class="flex flex-col md:flex-row gap-6">
            <!-- Profile Image -->
            <div class="flex flex-col items-center">
              <div class="relative w-32 h-32 mb-4">
                <img 
                  :src="authStore.user?.img ? `/assets/imgs/${authStore.user.img}` : '/api/placeholder/128/128'" 
                  alt="Profile" 
                  class="w-32 h-32 rounded-full object-cover border-4 border-gray-100 shadow-sm"
                />
                <div class="absolute bottom-0 right-0 bg-primary text-white p-1 rounded-full shadow-lg cursor-pointer" @click="openEditModal">
                  <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/><path d="m15 5 4 4"/></svg>
                </div>
              </div>
            </div>
            
            <!-- User Information -->
            <div class="flex-1 space-y-4">
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                  <h3 class="text-sm font-medium text-gray-500">Name</h3>
                  <p class="text-lg font-medium">{{ authStore.user?.name || 'Not set' }}</p>
                </div>
                
                <div>
                  <h3 class="text-sm font-medium text-gray-500">Email</h3>
                  <p class="text-lg font-medium">{{ authStore.user?.email || 'Not set' }}</p>
                </div>
                
                <div>
                  <h3 class="text-sm font-medium text-gray-500">Phone Number</h3>
                  <p class="text-lg font-medium">{{ authStore.user?.phone || 'Not set' }}</p>
                </div>
                
                <div>
                  <h3 class="text-sm font-medium text-gray-500">Member Since</h3>
                  <p class="text-lg font-medium">{{ formatDate(authStore.user?.created_at) || 'Not set' }}</p>
                </div>
              </div>
              
              <Button @click="openEditModal" class="mt-4 w-full md:w-auto text-white">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/><path d="m15 5 4 4"/></svg>
                Edit Profile
              </Button>
            </div>
          </div>
        </CardContent>
      </Card>
      
      <!-- Edit Profile Modal -->
      <Dialog :open="isEditModalOpen" @update:open="isEditModalOpen = $event">
        <DialogContent class="sm:max-w-md">
          <DialogHeader>
            <DialogTitle>Edit Profile</DialogTitle>
            <DialogDescription>
              Update your information
            </DialogDescription>
          </DialogHeader>
          
          <form @submit.prevent="updateUser" enctype="multipart/form-data" class="space-y-4" autocomplete="off">
            <div class="grid gap-4 py-4">
              <div class="flex justify-center mb-4">
                <div class="relative">
                  <img 
                    :src="previewImage || (authStore.user?.img ? `/assets/imgs/${authStore.user.img}` : '/api/placeholder/128/128')" 
                    alt="Profile" 
                    class="w-24 h-24 rounded-full object-cover"
                  />
                  <Label 
                    for="img" 
                    class="absolute bottom-0 right-0 bg-primary text-white p-1 rounded-full cursor-pointer shadow"
                  >
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                    <input 
                      type="file" 
                      id="img" 
                      class="hidden" 
                      @change="handleFileUpload" 
                      accept="image/*"
                      autocomplete="off"
                    />
                  </Label>
                </div>
              </div>
              
              <div class="grid grid-cols-1 gap-4">
                <div>
                  <Label for="name" class="text-sm font-medium">Name</Label>
                  <Input 
                    v-model="form.name" 
                    id="name" 
                    placeholder="Your full name"
                    required
                    autocomplete="off"
                    :class="{ 'border-primary': isFieldChanged('name') }"
                  />
                  <p class="text-xs text-gray-500 mt-1">Current: {{ authStore.user?.name || 'Not set' }}</p>
                </div>
                
                <div>
                  <Label for="email" class="text-sm font-medium">Email</Label>
                  <Input 
                    v-model="form.email" 
                    id="email" 
                    type="email" 
                    placeholder="your.email@example.com"
                    required
                    autocomplete="off"
                    :class="{ 'border-primary': isFieldChanged('email') }"
                  />
                  <p class="text-xs text-gray-500 mt-1">Current: {{ authStore.user?.email || 'Not set' }}</p>
                </div>
                
                <div>
                  <Label for="phone" class="text-sm font-medium">Phone Number (optional)</Label>
                  <Input 
                    v-model="form.phone" 
                    id="phone" 
                    type="tel" 
                    placeholder="+1 (555) 123-4567"
                    autocomplete="off"
                    :class="{ 'border-primary': isFieldChanged('phone') }"
                  />
                  <p class="text-xs text-gray-500 mt-1">Current: {{ authStore.user?.phone || 'Not set' }}</p>
                </div>
                
                <div>
                  <Label for="password" class="text-sm font-medium">New Password (optional)</Label>
                  <Input 
                    v-model="form.password" 
                    id="password" 
                    type="password" 
                    placeholder="Leave blank to keep current password"
                    autocomplete="new-password"
                    :class="{ 'border-primary': form.password }"
                  />
                </div>
              </div>
            </div>
            
            <DialogFooter>
              <Button type="button" variant="outline" @click="closeEditModal">Cancel</Button>
              <Button 
                type="submit" 
                class="ml-2 text-white" 
                :disabled="!hasChanges"
              >
                Save Changes
              </Button>
            </DialogFooter>
          </form>
        </DialogContent>
      </Dialog>
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted, computed } from "vue";
  import { useAuthStore } from "../../stores/auth";
  import { 
    Card, 
    CardContent, 
    CardHeader,
    CardTitle,
    CardDescription
  } from "@/components/ui/card";
  import { 
    Dialog, 
    DialogContent, 
    DialogHeader, 
    DialogTitle, 
    DialogDescription,
    DialogFooter
  } from "@/components/ui/dialog";
  import { Input } from "@/components/ui/input";
  import { Button } from "@/components/ui/button";
  import { Label } from "@/components/ui/label";
  import { useToast } from "@/components/ui/toast";
  
  const authStore = useAuthStore();
  const { toast } = useToast();
  const isEditModalOpen = ref(false);
  const previewImage = ref(null);
  const originalForm = ref({});
  
  const form = ref({
    name: "",
    email: "",
    phone: "",
    password: "",
    img: null
  });
  
  // Check if we have any changes to save
  const hasChanges = computed(() => {
    return form.value.img !== null || 
      form.value.password !== "" || 
      form.value.name !== originalForm.value.name ||
      form.value.email !== originalForm.value.email ||
      form.value.phone !== originalForm.value.phone;
  });
  
  // Check if specific field has changed
  const isFieldChanged = (field) => {
    return form.value[field] !== originalForm.value[field];
  };
  
  // Format date helper function
  const formatDate = (dateString) => {
    if (!dateString) return 'N/A';
    const date = new Date(dateString);
    return date.toLocaleDateString('en-US', { 
      year: 'numeric', 
      month: 'long', 
      day: 'numeric' 
    });
  };
  
  // Open edit modal and populate form with current user data
  const openEditModal = () => {
    form.value = {
      name: authStore.user?.name || "",
      email: authStore.user?.email || "",
      phone: authStore.user?.phone || "",
      password: "",
      img: null
    };
    
    // Store original values to compare for changes
    originalForm.value = { ...form.value };
    
    previewImage.value = null;
    isEditModalOpen.value = true;
  };
  
  // Close edit modal
  const closeEditModal = () => {
    isEditModalOpen.value = false;
  };
  
  // Handle file upload
  const handleFileUpload = (event) => {
    const file = event.target.files[0];
    if (file) {
      form.value.img = file;
      
      // Show image preview
      const reader = new FileReader();
      reader.onload = (e) => {
        previewImage.value = e.target.result;
      };
      reader.readAsDataURL(file);
    }
  };
  
  // Update user profile
  const updateUser = async () => {
    try {
      // If nothing has changed, don't submit
      if (!hasChanges.value) {
        toast({
          title: "No Changes",
          description: "No changes were made to your profile.",
          variant: "info"
        });
        closeEditModal();
        return;
      }

      // Create FormData object
      const formData = new FormData();
      formData.append('_method', 'PATCH');
      
      // Always send required fields (name and email)
      formData.append("name", form.value.name);
      formData.append("email", form.value.email);
      
      // Optional fields
      if (form.value.phone || form.value.phone === "") {
        formData.append("phone", form.value.phone);
      }
      
      if (form.value.password) {
        formData.append("password", form.value.password);
      }
      
      if (form.value.img) {
        formData.append("img", form.value.img);
      }
      
      // Update profile
      const response = await authStore.updateProfile(formData);
      
      // Update the form with the response data
      form.value = {
        name: response.user.name,
        email: response.user.email,
        phone: response.user.phone || "",
        password: "",
        img: null
      };
      
      // Update original form values
      originalForm.value = { ...form.value };
      
      toast({
        title: "Success",
        description: "Your profile has been updated successfully.",
        variant: "success"
      });
      closeEditModal();
    } catch (error) {
      console.error("Update error:", error);
      let errorMessage = "Failed to update profile. Please try again.";
      
      // Get more detailed error message if available
      if (error.response?.data?.message) {
        errorMessage = error.response.data.message;
      }
      
      toast({
        title: "Error",
        description: errorMessage,
        variant: "destructive"
      });
    }
  };
  
  onMounted(() => {
    // If needed, you could load user data here
    // authStore.fetchUserProfile();
  });
  </script>