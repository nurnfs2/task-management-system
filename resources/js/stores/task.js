// import axios from "axios";
import { defineStore } from "pinia";
import axiosInstance from "@/services/AxiosService";

export const useTask = defineStore("task", {
    state: () => ({
      alltask: {},
      loading: false,
    }),

  actions: {



    // Load all Task ============================================================
    async getAllTask() {
          try {
            const res = await axiosInstance.get(`/tasks`);
            if(res.status==200){
                this.alltask = res.data;
               // console.log(res.data);
                return new Promise((resolve)=>{
                    resolve(res.data);
                });
            }
          } catch (error) {
            if (error.response.data) {
                console.log(error.response.data);
            }
          }
    },


    // Insert Task ============================================================

    async insertData(formData) {
      try {
        const res = await axiosInstance.post("/tasks", formData);
        console.log(res);
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


// Get Task by ID ============================================================

    async getTaskById(id) {
      try {
        const res = await axiosInstance.get(`/tasks/${id}`);
        if(res.status==200){
            return new Promise((resolve)=>{
                resolve(res.data);
            });
        }
      } catch (error) {
        if (error.response.data) {
            console.log(error.response.data);
        }
      }
    },

// Update Task by ID ============================================================
    async updateData(id, formData) {
     console.log(formData);
      try {
        const res = await axiosInstance.put(`/tasks/${id}`, formData);
      //  console.log(res);
        if(res.status==200){
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


// Delete Task by ID ============================================================
    async deleteTask(id) {
      try {
        const res = await axiosInstance.delete(`/tasks/${id}`);
        if(res.status==200){
         //   this.user = res.data;
            return new Promise((resolve)=>{
                resolve(res);
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





  },
});
