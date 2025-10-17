<script setup>
    import { useModal } from "@/stores";
    const modal = useModal();

</script>

<template>
  <div v-show="modal.isOpen">
    <div class="modal fade show" style="display: block;">
      
          

          <slot />

        
    </div>
  </div>
</template>

<style scoped>
.modal{
    background-color: rgba(10, 10, 10, 0.5);
}
</style>