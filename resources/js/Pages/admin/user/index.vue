<script setup>
import { ref, computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3';
import { defineComponent } from 'vue';
import Layout from '../../../Layouts/App.vue';
import { Head } from '@inertiajs/vue3';

const LayoutComponent = defineComponent({
  components: { Layout }
});

const { $inertia } = usePage();

defineProps({
    users:Object,
    permissions: Object
});


const roleMapping = {
  1: 'Super Admin',
  2: 'Admin',
  3: 'Content Manager',
};

const mappedRole = (role) => {
  return roleMapping[role] || 'Unknown Role';
};

const editUser =  (id) => {
     router.visit(`/dashboard/user/${id}/edit`);
};

const activateUser = async (id, role) => {
    if(role != 1){
        await router.get(`/dashboard/user/${id}/activate`);
    }
};

const deleteUser = async (id) => {
  if (confirm('Are you sure you want to delete this user?')) {
    await router.delete(`/dashboard/user/${id}`);
  }
};

const goToAddPage = () => {
    router.visit(`/dashboard/user/create`);
};


</script>

<template>

<Head title="Users index" />

    <Layout>

        <div class="row  align-items-center mb-3">
            <h2 class=" col-11 display-3 text-center">
                Admins
            </h2>
            <div v-if="permissions.user_manage" class="col-1">
                <button type="button" class="btn btn-success" @click="goToAddPage">
                <i class="bi bi-plus-circle"></i> Add </button>
            </div>
        </div>

        <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Ueer Name</th>
                <th scope="col">Email</th>
                <th scope="col">Role</th>
                <th scope="col" v-if="permissions.user_manage">Active</th>
                <th scope="col">Created at</th>
                <th scope="col" v-if="permissions.user_manage">Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="user in users.data" :key="user.id">
                <th scope="row">{{ user.id }}</th>
                <td>{{ user.username }}</td>
                <td>{{ user.email }}</td>
                <td>{{ mappedRole(user.role) }}</td>
                <td v-if="permissions.user_manage">
                    <div class="form-check form-switch"
                        v-if="permissions.user_manage"
                    >
                        <input :checked="user.active"
                        :disabled="user.role == 1"
                        @change="activateUser(user.id, user.role)"
                        class="form-check-input"
                        type="checkbox"
                        role="switch"
                        id="active_switch">                    
                    </div>
                </td>
                <td>{{ new Date(user.created_at).toLocaleString() }}</td>
                <td v-if="permissions.user_manage">
                    <button @click="editUser(user.id)" :disabled="user.role == 1"
                        type="button" class="btn btn-warning btn-sm mx-1" >Edit</button>
                    <button @click="deleteUser(user.id)" :disabled="user.role == 1"
                        type="button" class="btn btn-danger btn-sm mx-1">Delete</button>
                </td>
            </tr>
        </tbody>
        </table>

            <!-- Pagination -->
            <nav aria-label="Test" class="mt-5">
            <ul class="pagination justify-content-center">

                <li v-for="link in users.links" :key="link.url"
                :class="['page-item', {'disabled': link.url == null }]"  >
                    <Link :href="link.url" class="page-link" v-html="link.label" />
                </li>
                
            </ul>
            </nav>

    </Layout>
</template>
