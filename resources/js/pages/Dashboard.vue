<script setup>
import { Modal } from "@/components";
import { useAuth, useNotification, useModal, useTask } from '@/stores';
import { storeToRefs } from 'pinia';
import { useRouter } from 'vue-router';
import { ElMessage, ElMessageBox } from 'element-plus';

const auth = useAuth();
const { user, loading } = storeToRefs(auth);
const router = useRouter();


import { onMounted, reactive, ref } from 'vue';

const modal = useModal();

const task = useTask();
const { alltask } = storeToRefs(task);

onMounted(()=>{

    loadAllTask();
});

const loadAllTask = async () => {
    task.getAllTask();
}


const status = [
  {
    value: 'start',
    label: 'Start',
  },
  {
    value: 'incomplete',
    label: 'Incomplete',
  },
  {
    value: 'complete',
    label: 'Complete',
  }
]

const errors = ref([]);
const editMode = ref(false);
const taskId = ref("");

const form = reactive({
      title: "",
      description: "",
      status: "start"
});

const resetForm = () => {
    editMode.value = false;
    taskId.value = "";
    form.title= "";
    form.description= "";
    form.status= "start";
};

const taskHeadTitle = ref("");
const performBTN = ref("");

const openNewTask = () => {
    resetForm();
    taskHeadTitle.value = 'New Task';
    performBTN.value = 'Create New Task';
    modal.toggleModal();
}


const saveInformation = async () => {

    if(editMode.value == false){
        const res = await task.insertData(form);
        console.log(res);

        if (res) {
               notify.Success(res.title+' Task Added');
               resetForm();
               modal.hideModal();
               loadAllTask();
        }else{
            notify.Warning('Task Duplicate found!');
        }
    }else{
        let id = taskId.value;
      //  console.log(form);
        const res = await task.updateData(id, form);
        if (res) {
                notify.Success(res.task.title+' Task Updated');
                resetForm();
                modal.hideModal();
                loadAllTask();
        }
    }
};



const editTask = async (id) => {
    editMode.value = true;
    taskId.value = id;

    const res = await task.getTaskById(id);
    if (res) {
        form.title = res.title;
        form.description = res.description;
        form.status = res.status;
        taskHeadTitle.value = 'Update Task';
        performBTN.value = 'Update Task';
        modal.toggleModal();
    }else{
        setErrors(res);
    }

}


const deleteTask = (id, name) => {
    ElMessageBox.confirm(
        'You want to Delete '+name,
        'Warning',
        {
            confirmButtonText: 'OK',
            cancelButtonText: 'Cancel',
            type: 'warning',
            center: true,
        }
    )
    .then( async () => {
        const res = await task.deleteTask(id);
        if (res) {
            ElMessage({
                type: 'success',
                message: 'Task Deleted',
            });
            loadAllTask();
        }

    })
    .catch(() => {
        ElMessage({
            type: 'info',
            message: 'Delete canceled',
        })
    })

}





const notify = useNotification();
const userLogout = async () => {
  const res = await auth.logout();
//   console.log(res);
  if (res) {
   // alert("Login Success");
    router.push({name: 'login'});
    notify.Success('Successfully logged out');
  }
};



</script>

<template>
    <div>


<div class="sidebar d-flex flex-column">
    <h4 class="mb-5"><i class="bi bi-diamond logo"></i> TaskMinder.</h4>
    <nav class="nav flex-column mt-5">
      <a href="#" class="nav-link mb-3"><i class="bi bi-ui-checks-grid me-2"></i> Dashboard</a>
      <a href="#" class="nav-link mb-3"><i class="bi bi-folder2-open me-2"></i> Projects</a>
      <a href="#" class="nav-link mb-3 active"><i class="bi bi-list-task me-2"></i> Tasks</a>
      <a href="#" class="nav-link mb-3"><i class="bi bi-calendar2-check me-2"></i> Calendar</a>
    </nav>
    <div class="mt-auto">
      <a href="#" class="btn btn-outline-danger logout w-100 mt-3" @click="userLogout"><i class="bi bi-arrow-return-left"></i> Log out</a>
    </div>
  </div>

  <div class="main-content">
    <div class="topbar d-flex justify-content-between align-items-center px-3 py-2 border-bottom bg-white">
      <!-- Search Box -->
      <div class="search-box d-flex align-items-center border rounded px-2">
        <input type="text" placeholder="Search" class="form-control border-0 shadow-none">
        <i class="bi bi-search me-2"></i>
      </div>

      <!-- Right Section -->
      <div class="d-flex align-items-center gap-3">
        <i class="bi bi-bell fs-5"></i>

        <!-- Profile Dropdown -->
        <div class="dropdown">
          <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="@/assets/images/avater/default.png" class="rounded-circle user-img" alt="user" width="40" height="40">
          </a>
          <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="userDropdown">
            <li><h6 class="dropdown-header">Hello, {{ user.data.name }}</h6></li>
            <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i>Profile</a></li>
            <li><a class="dropdown-item" href="#"><i class="bi bi-gear me-2"></i>Settings</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item text-danger" href="#" @click="userLogout"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
          </ul>
        </div>
      </div>
    </div>




    <div class="mt-5 pt-5 d-flex justify-content-between align-items-center">
      <h4>Tasks</h4>


      <div class="d-flex align-items-center gap-5">
        <div class="d-flex align-items-center gap-2 menu-icon">
          <a href="#" class="btn btn-sm arrow"><i class="bi bi-arrow-return-left"></i></a>
          <a href="#" class="btn btn-sm arrow"><i class="bi bi-arrow-return-right arrow"></i></a>
          <a href="#" class="btn btn-sm"><i class="bi bi-people-fill"></i></a>
          <a href="#" class="btn btn-sm"><i class="bi bi-sliders"></i></a>
        </div>


        <button class="btn btn-primary" @click.prevent="openNewTask();">New Task <i class="bi bi-plus"></i></button>
      </div>
    </div>






<Modal>

<div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">{{ taskHeadTitle }}</h5>
        </div>
        <form>
        <div class="modal-body p-4">
            <div class="row">
                <div class="col-md-11">
                    <div class="form-group row pb-2">
                        <label for="title" class="col-sm-3 col-form-label" >Title</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="title" v-model="form.title" placeholder="Title">
                        </div>
                    </div>
                    <div class="form-group row pb-2">
                        <label for="description" class="col-sm-3 col-form-label" >Description</label>
                        <div class="col-sm-9">
                            <textarea rows="6" class="form-control" id="description" v-model="form.description" placeholder="Description"></textarea>
                        </div>
                    </div>
                    <div class="form-group row pb-2">
                        <label for="Status" class="col-sm-3 col-form-label" >Status</label>
                        <div class="col-sm-9">
                            <el-select v-model="form.status" filterable placeholder="Select Status" required>
                                <el-option v-for="item in status" :key="item.value" :label="item.label" :value="item.value" />
                            </el-select>
                        </div>
                    </div>



                </div>

            </div>



        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary" @click.prevent="saveInformation">{{ performBTN }}</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" @click.prevent="modal.toggleModal()">Close</button>
        </div>
        </form>
    </div>
</div>
</Modal>






    <div class="row mt-3 g-3">
      <div class="col-lg-4">
        <div class="task-column bg-info">
          <h5 class="text-primary"><i class="bi bi-app"></i> To do</h5>

            <div v-if="alltask && alltask.length">
            <template v-for="(task, index) in alltask" :key="index">
                <div v-if="task.status === 'start'" class="task-card">
                    <div class="task-header">
                        <div class="task-left d-flex align-items-center gap-5">
                        <img src="@/assets/images/avater/default.png" alt="user" class="task-avatar" />
                        <div class="task-left d-flex align-items-center gap-1">
                            <a href="#" class="btn btn-sm" @click.prevent="editTask(task.id)"><i class="fa-solid fa-pen" title="Edit"></i></a>
                            <a href="#" class="btn btn-sm" @click.prevent="deleteTask(task.id, task.title)"><i class="fa-solid fa-trash" title="Delete"></i></a>
                        </div>
                        </div>
                    </div>

                    <div class="task-body">
                        <p class="task-title mt-1 mb-1">{{ task.title }}</p>
                        <p>{{ task.description }}</p>
                        <p class="written-by"><i class="fa fa-user"></i> {{ task.user.name }}</p>
                    </div>
                </div>
            </template>
            </div>



        </div>
      </div>

      <div class="col-lg-4">
        <div class="task-column bg-warning">
          <h5 class="text-warning"><i class="bi bi-hourglass"></i> In progress</h5>

            <div v-if="alltask && alltask.length">
            <template v-for="(task, index) in alltask" :key="index">
                <div v-if="task.status === 'incomplete'" class="task-card">
                    <div class="task-header">
                        <div class="task-left d-flex align-items-center gap-5">
                        <img src="@/assets/images/avater/default.png" alt="user" class="task-avatar" />
                        <div class="task-left d-flex align-items-center gap-1">
                            <a href="#" class="btn btn-sm" @click.prevent="editTask(task.id)"><i class="fa-solid fa-pen" title="Edit"></i></a>
                            <a href="#" class="btn btn-sm" @click.prevent="deleteTask(task.id, task.title)"><i class="fa-solid fa-trash" title="Delete"></i></a>
                        </div>
                        </div>
                    </div>

                    <div class="task-body">
                        <p class="task-title mt-1 mb-1">{{ task.title }}</p>
                        <p>{{ task.description }}</p>
                        <p class="written-by"><i class="fa fa-user"></i> {{ task.user.name }}</p>
                    </div>
                </div>
            </template>
            </div>

        </div>
      </div>

      <div class="col-lg-4">
        <div class="task-column bg-danger">
          <h5 class="text-danger"><i class="bi bi-check2-square"></i> Done</h5>


            <div v-if="alltask && alltask.length">
            <template v-for="(task, index) in alltask" :key="index">
                <div v-if="task.status === 'complete'" class="task-card">
                    <div class="task-header">
                        <div class="task-left d-flex align-items-center gap-5">
                        <img src="@/assets/images/avater/default.png" alt="user" class="task-avatar" />
                        <div class="task-left d-flex align-items-center gap-1">
                            <a href="#" class="btn btn-sm" @click.prevent="editTask(task.id)"><i class="fa-solid fa-pen" title="Edit"></i></a>
                            <a href="#" class="btn btn-sm" @click.prevent="deleteTask(task.id, task.title)"><i class="fa-solid fa-trash" title="Delete"></i></a>
                        </div>
                        </div>
                    </div>

                    <div class="task-body">
                        <p class="task-title mt-1 mb-1">{{ task.title }}</p>
                        <p>{{ task.description }}</p>
                        <p class="written-by"><i class="fa fa-user"></i> {{ task.user.name }}</p>
                    </div>
                </div>
            </template>
            </div>

        </div>
      </div>
    </div>
  </div>


    </div>
</template>

<style scoped>
body {
      background-color: #f9fafc;
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

    .task-left a{
        color: #999;
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
        padding: 15px;
        margin-bottom: 15px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }


    .task-card img {
        width: 44px;
        height: 44px;
        border-radius: 50%;
    }

    .task-left {
        font-size: 14px;
        color: #b9b9b9;
        cursor: pointer;
    }

    .task-title{
        font-weight: bold;
    }

    .task-left .fa-pen:hover {
        color: #2b4cc0;
        transform: scale(1.1);
        transition: 0.2s ease;
    }

    .task-left .fa-trash:hover {
        color: #c02b2b;
        transform: scale(1.1);
        transition: 0.2s ease;
    }

    .task-body {
        margin-top: -1px;
    }

    .task-body p{
        margin-bottom: 5px;
    }

    .written-by{
        font-size: 12px;
        font-style: italic;
        color: #999;
        margin-bottom: -1px !important;
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
