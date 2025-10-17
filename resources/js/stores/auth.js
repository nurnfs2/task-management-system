// import axios from "axios";
import { defineStore } from "pinia";
import axiosInstance from "@/services/AxiosService";

export const useAuth = defineStore("auth", {
    state: () => ({
      user: {},
      loading: false,
    }),

    persist: {
      // storage: sessionStorage,
      paths: ['user'],
    },

  actions: {
    async login(formData) {

      try {
        const res = await axiosInstance.post("/login", formData);
        if(res.status==200){
            console.log(res.data);
            this.user = res.data;

            return new Promise((resolve)=>{
                resolve(res.data);
            });
        }
      } catch (error) {
        if (error.response.data) {
            // this.errors = error.response.data.errors;
            return new Promise((reject)=>{
                reject(error.response.data.errors);
            });
        }
        // console.log(error);
      }

    },

    async register(formData) {
      try {
        const res = await axiosInstance.post("/register", formData);
        if(res.status==201){
         //   this.user = res.data;
            return new Promise((resolve)=>{
                resolve(res.data);
            });
        }
      } catch (error) {
        if (error.response.data) {
            return new Promise((reject)=>{
                reject(error.response.data.errors);
            });
        }
      }
    },

    async logout() {
      this.loading = true;
      try {

        const res = await axiosInstance.post("/logout");
        console.log(res);

        if (res.data.response_code === 200) {
          this.user = {};
          return new Promise((resolve) => {
            resolve(res);
          });
        }
      } catch (error) {
        if (error.response) {
          return new Promise((reject) => {
            reject(error.response);
          });
        }
      } finally {
        this.loading = false;
      }
    },



  },
});
