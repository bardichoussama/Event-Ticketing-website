<script setup>
import { ref, onMounted, computed, watch } from "vue";
import { useAuthStore } from "../../stores/auth";
import { useReservationStore } from "../../stores/reservation";
import { useRoute, useRouter } from "vue-router";
import { X, Receipt, Download, Printer } from "lucide-vue-next";
import jsPDF from "jspdf";
import autoTable from "jspdf-autotable";

import {
  Table,
  TableBody,
  TableCaption,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from "@/components/ui/table";
import {
  Card,
  CardContent,
  CardDescription,
  CardFooter,
  CardHeader,
  CardTitle,
} from "@/components/ui/card";
import {
  Dialog,
  DialogContent,
  DialogDescription,
  DialogFooter,
  DialogHeader,
  DialogTitle,
  DialogTrigger,
} from "@/components/ui/dialog";
import { Button } from "@/components/ui/button";
import { Badge } from "@/components/ui/badge";

const authStore = useAuthStore();
const reservationStore = useReservationStore();
const route = useRoute();
const router = useRouter();
const dialogOpen = ref(false);
const userId = computed(() => authStore.user?.id);
const purchases = ref([]);
const loading = ref(true);
const selectedPurchase = ref(null);

const formatDate = (dateString) => {
  if (!dateString) return '';
  const date = new Date(dateString);
  return date.toLocaleDateString() + ' ' + date.toLocaleTimeString();
};

// Format currency safely
const formatCurrency = (value) => {
  // Convert to number if it's a string, or default to 0
  const num = typeof value === 'string' ? parseFloat(value) : (typeof value === 'number' ? value : 0);
  return num.toFixed(2);
};

// Calculate price per ticket
// const getPricePerTicket = (totalPrice, ticketCount) => {
//   if (!ticketCount || ticketCount <= 0) return 0;
//   return totalPrice / ticketCount;
// };

const fetchReservations = async () => {
  loading.value = true;
  try {
    if (userId.value) {
      await reservationStore.getUserReservations(userId.value);
      purchases.value = reservationStore.reservation || [];
      
      // Ensure all price fields are numbers
      purchases.value = purchases.value.map(purchase => ({
        ...purchase,
        total_price: typeof purchase.total_price === 'string' ? parseFloat(purchase.total_price) : purchase.total_price,
        regular_price: typeof purchase.regular_price === 'string' ? parseFloat(purchase.regular_price) : purchase.regular_price,
        discount_price: typeof purchase.discount_price === 'string' ? parseFloat(purchase.discount_price) : purchase.discount_price,
      }));
    } else {
      purchases.value = [];
    }
  } catch (err) {
    console.error("Error getting user reservations:", err);
  } finally {
    loading.value = false;
  }
};

const showDetails = (purchase) => {
  // Create a deep copy with proper number types
  selectedPurchase.value = {
    ...purchase,
    total_price: typeof purchase.total_price === 'string' ? parseFloat(purchase.total_price) : purchase.total_price,
    regular_price: typeof purchase.regular_price === 'string' ? parseFloat(purchase.regular_price) : purchase.regular_price,
    discount_price: typeof purchase.discount_price === 'string' ? parseFloat(purchase.discount_price) : purchase.discount_price,
  };
  
  // Open dialog after setting the purchase
  setTimeout(() => {
    dialogOpen.value = true;
  }, 0);
};

// Close dialog function
const closeDialog = () => {
  dialogOpen.value = false;
};

// Function to download invoice as PDF
const downloadInvoice = () => {
  if (!selectedPurchase.value) return;
  
  // Create PDF document
  const doc = new jsPDF();
  
  // Add company logo/header
  doc.setFontSize(20);
  doc.setTextColor(44, 62, 80);
  doc.text("INVOICE", 105, 15, { align: "center" });
  
  // Add receipt icon as a simple circle with text
  doc.setFillColor(66, 139, 202);
  doc.circle(105, 30, 8, "F");
  doc.setTextColor(255, 255, 255);
  doc.setFontSize(12);
  doc.text("R", 105, 33, { align: "center" });
  
  // Reset text color for remaining content
  doc.setTextColor(44, 62, 80);
  doc.setFontSize(10);
  
  // Add invoice details
  doc.text(`Booking #${selectedPurchase.value.reservation_id}`, 105, 45, { align: "center" });
  
  // Add user and event information
  doc.setFontSize(11);
  doc.text("Customer Details:", 20, 60);
  doc.setFontSize(10);
  doc.text(`Name: ${selectedPurchase.value.user_name}`, 20, 65);
  doc.text(`Purchase Date: ${formatDate(selectedPurchase.value.purchase_date)}`, 20, 70);
  
  doc.setFontSize(11);
  doc.text("Event Details:", 120, 60);
  doc.setFontSize(10);
  doc.text(`Name: ${selectedPurchase.value.event_title}`, 120, 65);
  doc.text(`Date: ${formatDate(selectedPurchase.value.event_date)}`, 120, 70);
  
  // Calculate price per ticket
 
  
  // Add ticket table
  autoTable(doc, {
    startY: 80,
    head: [['Ticket Type', 'Quantity', 'Price per Ticket', 'Total']],
    body: [
      ['Regular Tickets', 
       selectedPurchase.value.regular_tickets_count, 
       ` ${formatCurrency(selectedPurchase.value.regular_price)} €`,
       `${formatCurrency(selectedPurchase.value.regular_tickets_count * selectedPurchase.value.regular_price)} €`
      ],
      ['Discount Tickets', 
       selectedPurchase.value.discount_tickets_count,
       ` ${formatCurrency(selectedPurchase.value.discount_price)} €`,
       `${formatCurrency(selectedPurchase.value.discount_tickets_count * selectedPurchase.value.discount_price)} €`
      ],
    ],
    foot: [['', '', 'Total Amount', `${formatCurrency(selectedPurchase.value.total_price)} €`]],
    theme: 'striped',
    headStyles: { fillColor: [66, 139, 202] },
    footStyles: { fillColor: [240, 240, 240], textColor: [44, 62, 80], fontStyle: 'bold' }
  });
  
  // Add footer text
  const pageHeight = doc.internal.pageSize.height;
  doc.setFontSize(8);
  doc.setTextColor(128, 128, 128);
  doc.text("This is an automatically generated invoice. For questions contact customer support.", 105, pageHeight - 10, { align: "center" });
  
  // Save PDF
  doc.save(`Invoice-${selectedPurchase.value.reservation_id}.pdf`);
};

// Handle auth changes
watch(() => authStore.user, (newUser) => {
  if (newUser?.id) {
    fetchReservations();
  } else {
    purchases.value = [];
  }
}, { immediate: true });

// Check auth status on mount
onMounted(async () => {
  if (!authStore.isAuthenticated) {
    try {
      await authStore.checkAuthStatus();
    } catch (error) {
      console.error("Authentication check failed:", error);
    }
  }
  
  if (authStore.isAuthenticated && userId.value) {
    fetchReservations();
  }
});
</script>

<template>
  <div class="p-6 mx-52">
    <h1 class="text-2xl font-bold mb-1">My Purchases</h1>
    <p class="text-gray-500 mb-4">View all your event reservations and tickets</p>
    
    <Card class="w-full">
      <CardContent class="p-4">
        <div v-if="loading" class="flex justify-center items-center h-32">
          <div class="animate-spin h-8 w-8 border-4 border-blue-500 rounded-full border-t-transparent"></div>
        </div>

        
        <div v-else-if="purchases.length === 0" class="text-center py-8">
          <p class="text-gray-500">You haven't made any purchases yet.</p>
        </div>
        
        <div v-else class="overflow-x-auto">
          <Table class="border-collapse">
            <TableCaption>A list of your recent purchases</TableCaption>
            <TableHeader>
              <TableRow class="border-b border-gray-200">
                <TableHead class="w-16">ID</TableHead>
                <TableHead>Event</TableHead>
                <TableHead>Date</TableHead>
                <TableHead class="text-center">Regular Tickets</TableHead>
                <TableHead class="text-center">Discount Tickets</TableHead>
                <TableHead class="text-right">Total Price</TableHead>
                <TableHead class="text-center">Actions</TableHead>
              </TableRow>
            </TableHeader>
            <TableBody class="bg-white">
              <TableRow v-for="purchase in purchases" :key="purchase.reservation_id" 
                class="hover:bg-gray-50 border-none">
                <TableCell class="font-medium">{{ purchase.reservation_id }}</TableCell>
                <TableCell>{{ purchase.event_title }}</TableCell>
                <TableCell>{{ formatDate(purchase.purchase_date) }}</TableCell>
                <TableCell class="text-center">
                  <Badge variant="outline" class="font-mono">{{ purchase.regular_tickets_count }}</Badge>
                </TableCell>
                <TableCell class="text-center">
                  <Badge variant="outline" class="font-mono">{{ purchase.discount_tickets_count }}</Badge>
                </TableCell>
                <TableCell class="text-right font-medium">
                  {{ formatCurrency(purchase.total_price) }} €
                </TableCell>
                <TableCell class="text-center">
                  <Button variant="outline" size="sm" @click="showDetails(purchase)">
                    Details
                  </Button>
                </TableCell>
              </TableRow>
            </TableBody>
          </Table>
        </div>
      </CardContent>
      <CardFooter>
        <p class="text-sm text-gray-500">
          For any issues with your purchases, please contact customer support.
        </p>
      </CardFooter>
    </Card>
    
    <!-- Separate Dialog from the table to avoid rendering issues -->
    <Dialog v-model:open="dialogOpen">
      <DialogContent class="sm:max-w-md">
        <DialogHeader v-if="selectedPurchase">
          <div class="relative h-24 bg-gradient-to-r from-primary to-primary/80 rounded-t-lg">
          </div>
          
          <!-- Receipt Icon -->
          <div class="relative -mt-12 flex justify-center">
            <div class="flex items-center justify-center h-16 w-16 rounded-full border-4 border-white bg-blue-50 text-primary">
              <Receipt class="h-8 w-8" />
            </div>
          </div>
          
          <DialogTitle class="text-lg font-semibold text-center mt-2">
            Reservation Details
          </DialogTitle>
          <DialogDescription class="text-center">
            Booking #{{ selectedPurchase.reservation_id }}
          </DialogDescription>
        </DialogHeader>
        
        <div v-if="selectedPurchase" class="space-y-4 py-4">
          <!-- User & Event Info -->
          <div class="grid grid-cols-2 gap-4">
            <div>
              <h4 class="text-xs font-semibold uppercase text-gray-500">Customer</h4>
              <p class="text-sm font-medium">{{ selectedPurchase.user_name }}</p>
            </div>
            <div>
              <h4 class="text-xs font-semibold uppercase text-gray-500">Purchase Date</h4>
              <p class="text-sm font-medium">{{ formatDate(selectedPurchase.purchase_date) }}</p>
            </div>
            <div>
              <h4 class="text-xs font-semibold uppercase text-gray-500">Event</h4>
              <p class="text-sm font-medium">{{ selectedPurchase.event_title }}</p>
            </div>
            <div>
              <h4 class="text-xs font-semibold uppercase text-gray-500">Event Date</h4>
              <p class="text-sm font-medium">{{ formatDate(selectedPurchase.event_date) }}</p>
            </div>
          </div>
          
          <!-- Ticket Details -->
          <div>
            <h4 class="text-xs font-semibold uppercase text-gray-500 mb-2">Ticket Summary</h4>
            <ul class="space-y-2 border border-gray-200 rounded-lg divide-y divide-gray-200">
              <li class="flex justify-between p-3">
                <span class="text-sm">Regular Tickets ({{ selectedPurchase.regular_tickets_count }})</span>
                <div class="text-right">
                  <div class="text-xs text-gray-500">{{ selectedPurchase.regular_price }} € per ticket</div>
                  <div class="text-sm font-medium">{{ formatCurrency(selectedPurchase.regular_tickets_count * selectedPurchase.regular_price) }} €</div>
                </div>
              </li>
              <li class="flex justify-between p-3">
                <span class="text-sm">Discount Tickets ({{ selectedPurchase.discount_tickets_count }})</span>
                <div class="text-right">
                  <div class="text-xs text-gray-500">{{  selectedPurchase.discount_price }} € per ticket</div>
                  <div class="text-sm font-medium">{{ formatCurrency(selectedPurchase.discount_tickets_count * selectedPurchase.discount_price) }} €</div>
                </div>
              </li>
              <li class="flex justify-between p-3 bg-gray-50 font-medium">
                <span class="text-sm">Total Amount</span>
                <span class="text-sm">{{ formatCurrency(selectedPurchase.total_price) }} €</span>
              </li>
            </ul>
          </div>
        </div>
        
        <DialogFooter class="flex justify-end gap-2">
          <Button variant="default" class="gap-1 text-white" @click="downloadInvoice">
            <Download class="h-4 w-4" />
            Download PDF
          </Button>
        </DialogFooter>
      </DialogContent>
    </Dialog>
  </div>
</template>