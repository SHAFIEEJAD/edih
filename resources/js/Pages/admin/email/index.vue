<script setup>
import { ref, computed, onMounted } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';
import { defineComponent } from 'vue';
import Layout from '../../../Layouts/App.vue';
import { Head } from '@inertiajs/vue3';


defineProps({
    emails:Object,
    tests:Object,
    permissions: Object
});

onMounted(() => {
    // Initialize tooltips after component is mounted
  const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    tooltipTriggerList.forEach(tooltipTriggerEl => {
      new bootstrap.Tooltip(tooltipTriggerEl);
    });
  });


const LayoutComponent = defineComponent({
  components: { Layout }
});

const { $inertia } = usePage();



const editEmail =  (id) => {
  router.visit(`/dashboard/email/${id}/edit`);
};

// const activateTest = async (id) => {
//     await router.get(`/dashboard/test/${id}/activate`);
    
// };

const handleTestChange = async (email_id,test_id) => {
  if (confirm('Are you sure you want to change the selected test?')) {
    await router.put(`/dashboard/email/${email_id}/test/${test_id}`);
  }

};


const deleteEmail = async (id) => {
  if (confirm('Are you sure you want to delete this email?')) {
    await router.delete(`/dashboard/email/${id}`);
  }
};

const goToAddPage = () => {
    router.visit(`/dashboard/email/create`);
};

</script>

<template>

    <Head title="Emails index" />
    <Layout>

      <div class="row  align-items-center mb-3">
            <h2 class=" col-11 display-3 text-center">
                Emails
            </h2>
            <div class="col-1" v-if="permissions.email_manage">
                <button type="button" class="btn btn-success" @click="goToAddPage">
                <i class="bi bi-plus-circle"></i> Add </button>
            </div>
        </div>


            <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Title</th>
                    <th scope="col">Subject</th>
                    <th scope="col">Addresses</th>
                    <th scope="col">Validity</th>
                    <th scope="col"  v-if="permissions.email_manage">Test</th>
                    <th scope="col">Created By</th>
                    <th scope="col">Created at</th>
                    <th scope="col"  v-if="permissions.email_manage">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="email in emails.data" :key="email.id">
                    <th scope="row">{{ email.id }}</th>

                    <td>{{ email.title }}</td>
                    <td>{{ email.subject }}</td>
                    <td>
                        <button 
                                type="button" class="btn btn-primary custom-tooltip mx-1 mb-1" data-bs-toggle="tooltip" 
                                data-bs-placement="bottom" :data-bs-title="email.sender_address.email">
                            {{ email.sender_address.name }}
                        </button>

                        <button v-for="(tag, index) in email.cc_addresses_list"
                                :key="index"
                                type="button" class="btn btn-secondary custom-tooltip mx-1 mb-1" data-bs-toggle="tooltip" 
                                data-bs-placement="bottom" :data-bs-title="tag.email">
                            {{ tag.name }}
                        </button>
                    
                    </td>
                    <td>{{ email.is_correct? 'Correct' : 'Phishing' }}</td>
                    <td  v-if="permissions.email_manage">
                        <select v-model="email.test_id" @change="handleTestChange(email.id, email.test_id)"
                            class="form-select" aria-label="Default select example">
                            <option selected value="0">Not Active</option>
                            <option  v-for="test in tests" :key="test.id" :value="test.id" >
                            {{ test.title }} 
                            </option>
                        </select>    
                    </td>

                    <td>{{ email.created_by }}</td>

                    <td>{{ new Date(email.created_at).toLocaleString() }}</td>
                    <td  v-if="permissions.email_manage">
                        <button @click="editEmail(email.id)"
                            type="button" class="btn btn-warning btn-sm mx-1 mb-1">Edit</button>
                        <button @click="deleteEmail(email.id)"
                            type="button" class="btn btn-danger btn-sm mx-1 mb-1">Delete</button>
                    </td>
                </tr>
            </tbody>
            </table>

            <!-- Pagination -->
            <nav aria-label="Test" class="mt-5">
            <ul class="pagination justify-content-center">

                <li v-for="link in emails.links" :key="link.url"
                :class="['page-item', {'disabled': link.url == null }]"  >
                    <Link :href="link.url" class="page-link" v-html="link.label" />
                </li>
                
            </ul>
            </nav>

    </Layout>


</template>
