<script setup>
import { useAuth, useNotification } from "@/stores";

import { ref, nextTick } from "vue";
import { useRouter, useRoute } from 'vue-router';

import { Field, Form } from 'vee-validate';

import * as yup from 'yup';
const schema = yup.object({
  email: yup.string().required("Email address is required"),
  password: yup.string().required(),
});

const auth = useAuth();

const router = useRouter();
const route = useRoute();

const showPassword = ref(false);

const toggleShow = () => {
  showPassword.value = !showPassword.value
};

const notify = useNotification();
const onSubmit = async (values, { setErrors, resetForm }) => {
  const res = await auth.login(values);

  if (res) {
    resetForm();
    notify.Success('Welcome ' + res.data.name);

    await nextTick();

    console.log('Redirecting to dashboard...');
    await router.replace({ name: 'dashboard' });

  } else {
    setErrors(res);
  }
};

</script>



<template>

    <div class="login-container d-flex justify-content-center align-items-center min-vh-100">
    <div class="card login-card shadow-lg border-0 p-4">
      <div class="text-center mb-4">
        <h3 class="fw-bold text-primary">TaskMinder.</h3>
        <p class="text-muted">🔐 Sign in to continue</p>
      </div>
      <Form class="user-form" @submit="onSubmit" :validation-schema="schema" v-slot="{ errors, isSubmitting }">
        <div class="mb-3">
          <label for="email" class="form-label fw-semibold">Email address</label>
          <Field name="email" type="text" class="form-control" placeholder="Email" :class="{'is-invalid': errors.email}" />
          <span class="text-danger">{{ errors.email }}</span>
        </div>
        <div class="mb-3">
          <label for="password" class="form-label fw-semibold">Password</label>
          <div class="input-group" id="show_hide_password">
            <Field name="password" :type="showPassword ? 'text' : 'password'" class="form-control" placeholder="password" :class="{'is-invalid': errors.password}" />
                <span @click="toggleShow" class="input-group-text bg-transparent">
                    <i class="bx" :class="{'bx-show': showPassword, 'bx-hide': !showPassword}"></i >
                </span>
            </div>
            <span class="text-danger">{{ errors.password }}</span>
        </div>
        <!-- <div class="d-flex justify-content-between align-items-center mb-3">
          <div v-if="error" class="alert alert-danger mt-3 text-center">{{ error }}</div>
        </div> -->
        <!-- <button type="submit" class="btn btn-primary w-100" :disabled="loading"></button> -->
        <button type="submit" class="btn btn-danger w-100" :disabled="isSubmitting">
            <span v-show="isSubmitting" class="spinner-border spinner-border-sm mr-1"></span>
            <i class="bx bxs-lock-open"></i>{{ isSubmitting ? 'Logging in...' : 'Login' }}
        </button>
      </Form>
      <div class="text-center mt-3">

      </div>
    </div>
  </div>


</template>



<style scoped>


body {
      background: linear-gradient(135deg, #e3f2fd, #e8eaf6, #f3e5f5) !important;
      font-family: 'Poppins', sans-serif;
    }
    .logo{
      color: #2563DC;
      font-weight: bold;
    }
    .user-img{
      width: 44px;
      height: 44px;
      border-radius: 50%;
      margin-right: 10px;
      cursor: pointer;
      transition: 0.2s;
    }

    .user-img:hover {
      transform: scale(1.05);
    }

    .sidebar {
      background: #fff;
      height: 100vh;
      border-right: 1px solid #e5e5e5;
      padding: 20px;
      position: fixed;
      width: 240px;
    }
    .sidebar h4{
      font-weight: bold;
    }
    .sidebar .nav-link {
      background-color: #EEF2FC;
      color: #14367B;
      border-radius: 8px;
      margin-bottom: 8px;
    }
    .sidebar .nav-link:hover {
      background-color: #73a2ff;
      color: #ffffff;
      font-weight: 500;
    }
    .sidebar .nav-link.active {
      background-color: #2563DC;
      color: #ffffff;
      font-weight: 500;
    }

    .logout{
      background: #FDF0EC;
      color: #81290E;
    }

    .main-content {
      margin-left: 260px;
      padding: 20px;
    }

    .menu-actions {
      gap: 8px;
      font-size: 14px;
      color: #666;
      cursor: pointer;
    }

    .menu-icon i{
      font-size: 20px;
    }

    .menu-icon i:hover{
      color: #2b4cc0;
    }

    .task-column {
      background: #fff;
      border-radius: 10px;
      padding: 15px;
      min-height: 450px;
    }
    .task-column h5 {
      font-weight: 600;
      margin-bottom: 15px;
    }
    .task-card {
      background: #ffffff;
      border-radius: 8px;
      padding: 12px;
      margin-bottom: 15px;
    }

    .task-card img {
      width: 44px;
      height: 44px;
      border-radius: 50%;
      margin-right: 10px;
    }
    .topbar {
      background: #fff;
      padding: 10px 20px;
      border-bottom: 1px solid #eee;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .search-box input {
      border: none;
      outline: none;
      width: 700px;
    }

    .task-actions {
      gap: 8px;
      font-size: 14px;
      color: #666;
      cursor: pointer;
    }

    .task-actions i{
      margin-right: 10px;
    }

    .task-actions .fa-pen:hover {
      color: #2b4cc0;
      transform: scale(1.1);
      transition: 0.2s ease;
    }

    .task-actions .fa-trash:hover {
      color: #c02b2b;
      transform: scale(1.1);
      transition: 0.2s ease;
    }

    .text-primary{
      color: #14367B !important;
    }

    .text-primary{
      color: #14367B !important;
    }
    .bg-info{
      background: #EEF2FC !important;
      border: 1px solid #d8e4fc;
      box-shadow: 0 0 5px #b0bbcf8e;
    }

    .bg-info .task-card{
      border: 1px solid #d8e4fc;
      box-shadow: 0 0 3px #b0bbcf8e;
    }

    .text-warning{
      color: #8F4F00 !important;
    }

    .bg-warning{
      background: #FFF6EB !important;
      border: 1px solid #FFE4C2;
      box-shadow: 0 0 5px #cfcdb08e;
    }

    .bg-warning .task-card{
      border: 1px solid #FFE4C2;
      box-shadow: 0 0 3px #cfcdb08e;
    }

    .text-danger{
      color: #81290E !important;
    }

    .bg-danger{
      background: #FDF0EC !important;
      border: 1px solid #FAD0C6;
      box-shadow: 0 0 5px #cfb0b08e;
    }

    .bg-danger .task-card{
      border: 1px solid #FAD0C6;
      box-shadow: 0 0 3px #cfb0b08e;
    }

    .arrow{
      transform: rotateX(180deg);
    }

    @media (max-width: 992px) {
      .sidebar {
        position: relative;
        height: auto;
        width: 100%;
      }
      .main-content {
        margin-left: 0;
      }
    }

</style>
