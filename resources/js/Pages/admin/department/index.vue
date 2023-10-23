<script setup>
import { ref, computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { router, useForm } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';
import { defineComponent } from 'vue';
import Layout from '../../../Layouts/App.vue';
import { Head } from '@inertiajs/vue3';


const LayoutComponent = defineComponent({
  components: { Layout }
});

const { $inertia } = usePage();
const editDepartmentData = ref({id:null,name:null});

defineProps({
    departments:Object,
    permissions: Object
});

const form = useForm({
    name:null,
});

const openEditModal =  (id, name) => {
    editDepartmentData.value.id = id;
    editDepartmentData.value.name = name;
};

const editDepartment =  async () => {

    form.name = editDepartmentData.value.name;



    await router.post(`/dashboard/department/${editDepartmentData.value.id}/update`, form)
    
            // Trigger modal close
            const modal = document.getElementById('closeModal');
    modal.click();

};

const activateDepartment = async (id) => {
    await router.get(`/dashboard/department/${id}/activate`);
    
};

const deleteDepartment = async (id) => {
  if (confirm('Are you sure you want to delete this department?')) {
    await router.delete(`/dashboard/department/${id}`);
  }
};

const goToAddPage = () => {
    router.visit(`/dashboard/department/create`);
};

</script>

<template>

    <Head title="Departments index" />
    <Layout>

        <div class="row  align-items-center mb-3">
            <h2 class=" col-11 display-3 text-center">
                Departments
            </h2>
            <div class="col-1"  v-if="permissions.department_manage">
                <button type="button" class="btn btn-success" @click="goToAddPage">
                <i class="bi bi-plus-circle"></i> Add </button>
            </div>
        </div>


            <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Department Title</th>
                    <th scope="col">Created By</th>
                    <th scope="col">Created at</th>
                    <th scope="col" v-if="permissions.department_manage">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="department in departments.data" :key="department.id">
                    <th scope="row">{{ department.id }}</th>
                    <td>{{ department.name }}</td>
                    <td>{{ department.created_by }}</td>
                    <td>{{ new Date(department.created_at).toLocaleString() }}</td>
                    <td v-if="permissions.department_manage">
                        <button @click="openEditModal(department.id, department.name)"
                            type="button" class="btn btn-warning btn-sm mx-1" 
                            data-bs-toggle="modal" data-bs-target="#exampleModal">Edit</button>
                        <button @click="deleteDepartment(department.id)"
                            type="button" class="btn btn-danger btn-sm mx-1">Delete</button>
                    </td>
                </tr>
            </tbody>
            </table>

            <!-- Pagination -->
            <nav aria-label="Test" class="mt-5">
            <ul class="pagination justify-content-center">

                <li v-for="link in departments.links" :key="link.url"
                :class="['page-item', {'disabled': link.url == null }]"  >
                    <Link :href="link.url" class="page-link" v-html="link.label" />
                </li>
                
            </ul>
            </nav>


            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Edit department name</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                    <div class="mb-3">
                        <label for="new-name" class="col-form-label">Title:</label>
                        <input type="text" v-model="editDepartmentData.name" class="form-control" id="new-name">
                    </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" id="closeModal" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" @click="editDepartment" class="btn btn-primary">Save changes</button>
                </div>
                </div>
            </div>
            </div>


    </Layout>


</template>
