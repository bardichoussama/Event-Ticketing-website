<script setup>
import Button   from 'primevue/button';
</script>
<template>
    <div>
        <nav class="flex gap-4 justify-center items-center self-stretch my-auto text-sm text-neutral-300">
            <Button label="Login" class="bg-red-500 text-white !important" />
            <!-- <button class="flex gap-4 justify-center items-center self-stretch px-2 my-auto w-24 whitespace-nowrap rounded-xl border border-solid shadow-sm bg-stone-950 border-stone-900 min-h-[42px]">
            <span class="gap-2.5 self-stretch p-2.5 my-auto">Login</span>
          </button> -->
          <button class="flex gap-2 justify-center items-center self-stretch px-5 py-1 my-auto rounded-xl shadow-lg bg-fuchsia-950">
            <span class="gap-2.5 self-stretch p-2.5 my-auto">Sign up</span>
          </button>
        </nav>
    </div>
</template>