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
const editTestData = ref({id:null,title:null});

defineProps({
    tests:Object,
    permissions: Object
});

const form = useForm({
    title:null,
});

const openEditModal =  (id, title) => {
    editTestData.value.id = id;
    editTestData.value.title = title;
};

const editTest =  async () => {

    form.title = editTestData.value.title;



    await router.post(`/dashboard/test/${editTestData.value.id}/update`, form)
    
            // Trigger modal close
            const modal = document.getElementById('closeModal');
    modal.click();

};

const activateTest = async (id) => {
    await router.get(`/dashboard/test/${id}/activate`);
    
};

const deleteTest = async (id) => {
  if (confirm('Are you sure you want to delete this test?')) {
    await router.delete(`/dashboard/test/${id}`);
  }
};

const goToAddPage = () => {
    router.visit(`/dashboard/test/create`);
};

</script>

<template>

    <Head title="Tests index" />
    <Layout>

        <div class="row  align-items-center mb-3">
            <h2 class=" col-11 display-3 text-center">
                Tests
            </h2>
            <div class="col-1" v-if="permissions.test_manage">
                <button type="button" class="btn btn-success" @click="goToAddPage">
                <i class="bi bi-plus-circle"></i> Add </button>
            </div>
        </div>


            <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Test Title</th>
                    <th scope="col">Created By</th>
                    <th scope="col" v-if="permissions.test_manage">Active</th>
                    <th scope="col">Created at</th>
                    <th scope="col" v-if="permissions.test_manage">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="test in tests.data" :key="test.id">
                    <th scope="row">{{ test.id }}</th>
                    <td>{{ test.title }}</td>
                    <td>{{ test.created_by }}</td>
                    <td v-if="permissions.test_manage">
                        <div class="form-check form-switch">
                            <input :checked="test.active"
                            :disabled="test.role == 1"
                            @change="activateTest(test.id)"
                            class="form-check-input"
                            type="checkbox"
                            role="switch"
                            id="active_switch">                    
                        </div>
                    </td>
                    <td>{{ new Date(test.created_at).toLocaleString() }}</td>
                    <td v-if="permissions.test_manage">
                        <button @click="openEditModal(test.id, test.title)"
                            type="button" class="btn btn-warning btn-sm mx-1" 
                            data-bs-toggle="modal" data-bs-target="#exampleModal">Edit</button>
                        <button @click="deleteTest(test.id)"
                            type="button" class="btn btn-danger btn-sm mx-1">Delete</button>
                    </td>
                </tr>
            </tbody>
            </table>

            <!-- Pagination -->
            <nav aria-label="Test" class="mt-5">
            <ul class="pagination justify-content-center">

                <li v-for="link in tests.links" :key="link.url"
                :class="['page-item', {'disabled': link.url == null }]"  >
                    <Link :href="link.url" class="page-link" v-html="link.label" />
                </li>
                
            </ul>
            </nav>

            <!-- Modal -->
            <div class="modal fade" id="exampleModal"  v-if="permissions.test_manage"
             tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Edit test title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                    <div class="mb-3">
                        <label for="new-title" class="col-form-label">Title:</label>
                        <input type="text" v-model="editTestData.title" class="form-control" id="new-title">
                    </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" id="closeModal" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" @click="editTest" class="btn btn-primary">Save changes</button>
                </div>
                </div>
            </div>
            </div>


    </Layout>


</template>
