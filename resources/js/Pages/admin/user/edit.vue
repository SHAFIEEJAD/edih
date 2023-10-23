<script setup>

import { useForm } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3';
import { defineComponent, onMounted, ref } from 'vue';
import Layout from '../../../Layouts/App.vue';
import { Head } from '@inertiajs/vue3';

const LayoutComponent = defineComponent({
  components: { Layout }
});

const change_password = ref(false);

const { user, errors } = defineProps(['user', 'errors']);


const form = useForm({
    username:null,
    email:null,
    password:null,
    password_confirmation:null,
    role:null,
    change_password:false,
    active:true
});

const setUserData = (user) => {
    form.username = user ? user.username : null;
    form.email = user ? user.email : null;
    form.role = user ? user.role : false;
    form.active = user ? user.active : true;
};

onMounted(() => {
    if (user) {
        setUserData(user);
    }
});



function submit() {
    form.change_password = change_password.value;
    router.post(`/dashboard/user/${user.id}/update`, form)
}


</script>

<template>

<Head title="Create User" />

    <Layout>

        <div class="row  align-items-center">
            <h2 class=" col-11 display-3 text-center">
                Create a new admin
            </h2>
            <div class="col-1"><button type="button" class="btn btn-success">
                <i class="bi bi-plus-circle"></i> Add </button>
            </div>
        </div>

        

        <form @submit.prevent="submit" class="row g-3 mt-3">
            <div class="mb-3 col-6 ">
                <label for="name" class="form-label">User Name</label>
                <input type="name" v-model="form.username" class="form-control" id="name">
                <div class="text-danger text-sm" v-if="errors.username"> {{ errors.username }}</div>
            </div>
            <div class="mb-3 col-6 ">
                <label for="email" class="form-label">Email address </label>
                <input type="email" v-model="form.email" class="form-control" id="email">
                <div class="text-danger text-sm" v-if="errors.email"> {{ errors.email }}</div>
            </div>
            <div class="mb-3 col-12 ">
                <div class="form-check">
                    <label for="keep_passwword" class="form-check-label">Change Password</label>
                    <input class="form-check-input" type="checkbox" v-model="change_password" id="keep_passwword">
                </div>
            </div>
            <div class="mb-3 col-6" v-show="change_password">
                <label for="password" class="form-label">Passowrd</label>
                <input type="password" v-model="form.password" class="form-control" id="password">
                <div class="text-danger text-sm" v-if="errors.password"> {{ errors.password }}</div>
            </div>
            <div class="mb-3 col-6" v-show="change_password">
                <label for="pass_confirmation" class="form-label">Password Confirmation</label>
                <input type="password" v-model="form.password_confirmation" class="form-control" id="pass_confirmation">
            </div>
            <div class="mb-3 col-6 ">
                <label class="form-check-label" for="role">Role</label>
                <select id="role" v-model="form.role" class="form-select" aria-label="Default select example" >
                    <option disabled>Choose the assigned role</option>
                    <option value="2">Admin</option>
                    <option value="3">Content Manager</option>
                </select>
                <div class="text-danger text-sm" v-if="errors.role"> {{ errors.role }}</div>
            </div>

            <button type="submit" class="btn btn-primary mt-4">Update</button>
        </form>
    </Layout>

</template>
