<script setup>
import { ref, computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3';
import { defineComponent } from 'vue';
import Layout from '../../Layouts/App.vue';
import { Head } from '@inertiajs/vue3';

const LayoutComponent = defineComponent({
  components: { Layout }
});

const { $inertia } = usePage();

defineProps({
    permissions: Object,
    tests_count: Object,
    active_test_title: Object,
    emails_count: Object,
    active_emails_count: Object,
    departments_count: Object,
    answers_count: Object,
    answers_depmartments_count: Object,
    admins_count: Object,
    content_managers_count: Object,
});

const goToAddPage = (page) => {
    router.visit(`/dashboard/` + page );
};

</script>

<template>

<Head title="Dashboard" />

    <Layout>

        <div class="row  align-items-center mb-3">
            <h2 class=" col-12 display-3 text-center">
                Dashboard
            </h2>
        </div>

        <!-- Cards section -->
        <div class="row">
            <div class="col-4">
                <div class="card border-primary mb-3">
                    <div class="card-header bg-primary text-light">
                        <b class="h4">Tests:</b>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><b>Available Tests:</b> {{ tests_count }}</li>
                        <li class="list-group-item"><b>Active Test Title:</b> {{  active_test_title }}</li>
                    </ul>
                    <div class="card-footer bg-transparent">
                        <a href="#" class="btn btn-primary"  @click="goToAddPage('tests')">more</a>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card bg-transparent border-danger text-light mb-3">
                    <div class="card-header bg-danger">
                        <b class="h4">Emails:</b>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><b>Available Emails:</b> {{ emails_count }}</li>
                        <li class="list-group-item"><b>Active Test's Emails:</b> {{  active_emails_count }}</li>
                    </ul>
                    <div class="card-footer bg-transparent">
                        <a href="#" class="btn btn-danger"  @click="goToAddPage('emails')">more</a>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card bg-transparent border-success text-light mb-3">
                    <div class="card-header bg-success">
                        <b class="h4">Answers:</b>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><b>Answers Count:</b> {{ answers_count }}</li>
                        <li class="list-group-item"><b>Participatory Departments:</b> 
                            {{  answers_depmartments_count + ' out of total: ' + departments_count }}</li>
                    </ul>
                    <div class="card-footer bg-transparent">
                        <a href="#" class="btn btn-success"  @click="goToAddPage('departments')">more</a>
                    </div>
                </div>
            </div>
            <div class="col-4" v-if="permissions.user_manage">
                <div class="card bg-transparent border-warning mb-3">
                    <div class="card-header bg-warning">
                        <b class="h4">Users:</b>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><b>Admins Count:</b> {{ admins_count }}</li>
                        <li class="list-group-item"><b>Content Managers Count:</b> {{ content_managers_count }} </li>
                    </ul>
                    <div class="card-footer bg-transparent">
                        <a href="#" class="btn btn-warning"  @click="goToAddPage('users')">more</a>
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>
