<script setup>

import { useForm, router, Head } from '@inertiajs/vue3';
import { defineProps, defineComponent, computed, onMounted, watch } from 'vue';
import Layout from '../../../Layouts/App.vue';

import { QuillEditor } from '@vueup/vue-quill'
import '@vueup/vue-quill/dist/vue-quill.snow.css';

import TagsInput from '../../../Components/TagsInput.vue';


const LayoutComponent = defineComponent({
  components: { Layout, QuillEditor, TagsInput }
});


const { email, tests, errors } = defineProps(['email', 'tests', 'errors']);




const form = useForm({
    title:null,
    subject:null,
    body:null,
    test_id:null,
    sender_address:{name:'',email:''},
    cc_addresses_list:[],
    created_by:1,
    is_correct:false,
    active:true
});

const setEmailData = (email) => {

        form.title = email ? email.title : null;
        form.subject = email ? email.subject : null;
        form.body = email ? email.body : null;
        form.test_id = email ? email.test_id : null;
        form.sender_address = email
            ? { name: email.sender_address.name, email: email.sender_address.email }
            : { name: '', email: '' };
        form.cc_addresses_list = email ? email.cc_addresses_list : [];
        form.created_by = email ? email.created_by : 1;
        form.is_correct = email ? email.is_correct : false;
        form.active = email ? email.active : true;
      };

onMounted(() => {
  if (email) {
    setEmailData(email);
  }
});



const isCorrectText = computed(() => {
  return form.is_correct
    ? 'It is an authenticated Email'
    : 'It is a phishing email!';
});

const updateCcAddressesList = (newValue) => {
  form.cc_addresses_list = newValue;
};

function submit() {
    router.post(`/dashboard/email/${email.id}/update`, form)
}



</script>

<template>

<Head :title="`Edit Email - ${email.title}`" />

    <Layout>
        <h2 class="display-3 text-center mb-5">
            Edit Email
        </h2>
        <form @submit.prevent="submit" class="row g-3 mt-3">
            <div class="mb-3 col-8 pe-3">
                <label for="name" class="form-label">Email Title</label>
                <input type="text" v-model="form.title" class="form-control" id="name">
                <div class="text-danger text-sm" v-if="errors.title"> {{ errors.title }}</div>
            </div>

            <div class="mb-3 col-4 ">
                <label class="form-check-label" for="role">Related Test</label>
                <div class="form-check d-flex align-items-end mt-2">
                  <select v-model="form.test_id" 
                      class="form-select" aria-label="Default select example">
                    <option selected disabled>Not Active</option>
                    <option  v-for="test in tests" :key="test.id" :value="test.id" >
                      {{ test.title }} 
                    </option>
                  </select>
                </div>
                <div class="text-danger text-sm" v-if="errors.test_id"> {{ errors.test_id }}</div>
            </div>

            <div class="mb-3 col-8 ">
                <label for="name" class="form-label">Email Subject</label>
                <input type="text" v-model="form.subject" class="form-control" id="name">
                <div class="text-danger text-sm" v-if="errors.subject"> {{ errors.subject }}</div>
            </div>
            <div class="mb-3 col-4 ">
                <label for="name" class="form-label">Validity</label>
                <div class="form-check form-switch">
                            <input :checked="form.is_correct"
                            v-model="form.is_correct"
                            class="form-check-input"
                            type="checkbox"
                            role="switch"
                            id="is_correct"> {{ isCorrectText }}                    
                        </div>

                <div class="text-danger text-sm" v-if="errors.is_correct"> {{ errors.is_correct }}</div>
            </div>

            <div class="mb-3 col-6 sm-col-12">
                <label for="name" class="form-label">Sender Email Address</label>
                <div class="input-group mb-3">
                  <span class="input-group-text">@</span>
                  <input v-model="form.sender_address.name" type="text" class="form-control" placeholder="Apearing Name" aria-label="Username">
                  <span class="input-group-text">@</span>
                  <input v-model="form.sender_address.email" type="email" class="form-control" placeholder="Email Address" aria-label="Server">
                </div>
                <div class="text-danger text-sm" v-if="errors.sender_address"> {{ errors.sender_address }}</div>
            </div>

            <div class="mb-3 col-6 sm-col-12">
                <label for="name" class="form-label">Caron Copy Email Addresses (CC)</label>

                <TagsInput :cc_list="form.cc_addresses_list"  @update:cc_addresses_list="updateCcAddressesList" />

                <div class="text-danger text-sm" v-if="errors.cc_addresses_list"> {{ errors.cc_addresses_list }}</div>
            </div>





            <div class="mb-3 lg-col-8 ">
                <label for="name" class="form-label">Email Content</label>

                <QuillEditor theme="snow" toolbar="full" content-type="html" v-model:content="form.body" />
                <!-- <input type="name" v-model="form.title" class="form-control" id="name"> -->

                <div class="text-danger text-sm" v-if="errors.body"> {{ errors.body }}</div>
            </div>


            <button type="submit" class="btn btn-primary mt-4">Update</button>
        </form>
    </Layout>  


</template>

<style>
/* Assuming you have a class 'quill-editor' on your Quill editor container */
.quill-editor .ql-editor {
  min-height: 5rem !important; /* Adjust the max height as needed */
  overflow-y: auto; /* Enable vertical scrolling if content overflows */
  border: 1px solid #ccc; /* Add a border for better separation */
}

.ql-container {
  height: auto !important;
}

.ql-container .ql-editor {
  min-height: 8rem !important;
}


</style>
