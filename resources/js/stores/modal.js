import { defineStore } from "pinia";

export const useModal = defineStore("modal", {
  state: () => ({ 
    isOpen: false 
  }),
  getters: {
    doubleCount: (state) => state.count * 2,
  },
  actions: {
    toggleModal() {
      this.isOpen = !this.isOpen;
    },
    showModal() {
      this.isOpen = true;
    },
    hideModal() {
      this.isOpen = false;
    },
  },
});
