<script setup>

import { useForm, router, Head } from '@inertiajs/vue3';
import { defineComponent } from 'vue';
import Layout from '../../../Layouts/App.vue';


const LayoutComponent = defineComponent({
  components: { Layout }
});


defineProps({
    errors:Object
});

const form = useForm({
    name:null,
    created_by:1,
    active:false
});

function submit() {
    router.post('/dashboard/department/store', form)
}


</script>

<template>

<Head title="Create Test" />

    <Layout>
        <h2 class="display-3 text-center mb-5">
            Create a new department
        </h2>
        <form @submit.prevent="submit" class="row g-3 mt-3">
            <div class="mb-3 lg-col-8 ">
                <label for="name" class="form-label">Department Name</label>
                <input type="name" v-model="form.name" class="form-control" id="name">
                <div class="text-danger text-sm" v-if="errors.name"> {{ errors.name }}</div>
            </div>
            <button type="submit" class="btn btn-primary mt-4">Create</button>
        </form>
    </Layout>  


</template>
