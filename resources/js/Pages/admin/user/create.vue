<script setup>

import { useForm } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3';
import { defineComponent } from 'vue';
import Layout from '../../../Layouts/App.vue';
import { Head } from '@inertiajs/vue3';

const LayoutComponent = defineComponent({
  components: { Layout }
});


defineProps({
    errors:Object
});

const form = useForm({
    username:null,
    email:null,
    password:null,
    password_confirmation:null,
    role:null,
    active:true
});

function submit() {
    router.post('/dashboard/user/store', form)
}


</script>

<template>

<Head title="Create User" />

    <Layout>
        <h2 class="display-3 text-center mb-5">
            Create a new admin
        </h2>
        <form @submit.prevent="submit" class="row g-3 mt-3">
            <div class="mb-3 col-6 ">
                <label for="name" class="form-label">User Name</label>
                <input type="name" v-model="form.username" class="form-control" id="name">
                <div class="text-danger text-sm" v-if="errors.username"> {{ errors.username }}</div>
            </div>
            <div class="mb-3 col-6 ">
                <label for="email" class="form-label">Email address</label>
                <input type="email" v-model="form.email" class="form-control" id="email">
                <div class="text-danger text-sm" v-if="errors.email"> {{ errors.email }}</div>
            </div>
            <div class="mb-3 col-6 ">
                <label for="password" class="form-label">Passowrd</label>
                <input type="password" v-model="form.password" class="form-control" id="password">
                <div class="text-danger text-sm" v-if="errors.password"> {{ errors.password }}</div>
            </div>
            <div class="mb-3 col-6 ">
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

            <button type="submit" class="btn btn-primary mt-4">Create</button>
        </form>
    </Layout>

</template>
