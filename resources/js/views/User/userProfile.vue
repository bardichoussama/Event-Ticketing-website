<template>
  <div class="p-6 max-w-lg mx-auto">
      <h1 class="text-2xl font-bold mb-4">User Profile</h1>
      
      <Card>
          <CardContent>
              <form @submit.prevent="updateUser" enctype="multipart/form-data">
                  <div class="mb-4">
                      <Label for="name">Name</Label>
                      <Input v-model="form.name" id="name" required />
                  </div>

                  <div class="mb-4">
                      <Label for="email">Email</Label>
                      <Input v-model="form.email" id="email" type="email" required />
                  </div>

                  <div class="mb-4">
                      <Label for="password">New Password (optional)</Label>
                      <Input v-model="form.password" id="password" type="password" />
                  </div>

                  <div class="mb-4">
                      <Label for="phone">Phone Number (optional)</Label>
                      <Input v-model="form.phone" id="phone" type="tel" />
                  </div>

                  <div class="mb-4">
                      <Label for="img">Profile Image</Label>
                      <input type="file" @change="handleFileUpload" class="border p-2 w-full" />
                  </div>

                  <div>
                      <img :src="previewImage" alt="Avatar" class="w-16 h-16 rounded-full">
                  </div>

                  <Button type="submit">Update Profile</Button>
              </form>
          </CardContent>
      </Card>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { useAuthStore } from "../../stores/auth";
import { Card, CardContent } from "@/components/ui/card";
import { Input } from "@/components/ui/input";
import { Button } from "@/components/ui/button";
import { Label } from "@/components/ui/label";

const authStore = useAuthStore();
const form = ref({
  name: "",
  email: "",
  phone: "",
  password: "",
  img: null
});
const previewImage = ()=>{
  return `/assets/imgs/${authStore.user.img}`;

}

onMounted(() => {
  
});

// Handle file upload
const handleFileUpload = (event) => {
  const file = event.target.files[0];
  form.value.img = file;

  // Show image preview
  if (file) {
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
      const formData = new FormData();
      formData.append("name", form.value.name);
      formData.append("email", form.value.email);
      formData.append("phone", form.value.phone);
      if (form.value.password) {
          formData.append("password", form.value.password);
      }
      if (form.value.img) {
          formData.append("img", form.value.img);
      }

      await authStore.updateProfile(formData);
      alert("Profile updated successfully!");
  } catch (error) {
      alert("Failed to update profile.");
  }
};
</script>
