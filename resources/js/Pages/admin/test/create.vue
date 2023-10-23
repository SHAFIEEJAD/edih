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
    title:null,
    created_by:1,
    active:false
});

function submit() {
    router.post('/dashboard/test/store', form)
}


</script>

<template>

<Head title="Create Test" />

    <Layout>
        <h2 class="display-3 text-center mb-5">
            Create a new test
        </h2>
        <form @submit.prevent="submit" class="row g-3 mt-3">
            <div class="mb-3 lg-col-8 ">
                <label for="name" class="form-label">Test Title</label>
                <input type="name" v-model="form.title" class="form-control" id="name">
                <div class="text-danger text-sm" v-if="errors.title"> {{ errors.title }}</div>
            </div>
            <div class="mb-3 lg-col-8 ">
                <label class="form-check-label" for="role">Active</label>
                <div class="form-check form-switch d-flex align-items-end">
                        <input 
                        v-model="form.active"
                        class="form-check-input"
                        type="checkbox"
                        role="switch"
                        id="active_switch">                    
                    </div>
                <div class="text-danger text-sm" v-if="errors.active"> {{ errors.active }}</div>
            </div>

            <button type="submit" class="btn btn-primary mt-4">Create</button>
        </form>
    </Layout>  


</template>
