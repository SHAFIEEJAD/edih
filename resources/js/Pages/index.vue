<script setup>
import { ref, watch, watchEffect , computed, onUpdated } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { router, useForm } from '@inertiajs/vue3';
import { defineComponent, onMounted } from 'vue';
import Layout from '../Layouts/Guest.vue';
import { Head } from '@inertiajs/vue3';

const LayoutComponent = defineComponent({
  components: { Layout }
});

const { test, emails, departments } = defineProps({
                            test:Object,
                            emails:Object,
                            departments:Object
                        });

const form = useForm({
                        test_id: null,
                        department_id: null,
                        answers: [],
                     });

const quizz = ref({
    department:null,
    test:null,
    emails:[]
});
const selectedEmail = ref({
    id:null,
    answer:null
});
const temp_emails = ref([]);
const phase = ref(0);
const emailUpdate = ref(false);

onMounted(() => {

    setTimeout(() => { 
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        tooltipTriggerList.forEach(tooltipTriggerEl => {
        new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }, 200);

    // Initialize tooltips after component is mounted


    if (emails) {
        temp_emails.value = emails;
        quizz.value.test = test.id;

    }
});



const selectDepartment = () => {

    setTimeout(() => {
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        tooltipTriggerList.forEach(tooltipTriggerEl => {
          new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }, 100);

    if (temp_emails.value.length > 0) {
        selectedEmail.value = temp_emails.value.pop();
        selectedEmail.value.answer = null;
        phase.value = 1; 
        emailUpdate.value = true;
    }


}

const saveAnswer = (answer) => {

    emailUpdate.value = false;

    selectedEmail.value.answer = answer == '1' ? 1 : 0;
    form.answers.push({
        id: selectedEmail.value.id,
        answer: selectedEmail.value.answer,
    });

    quizz.value.emails.push(selectedEmail);

    if (temp_emails.value.length > 0) {
        selectedEmail.value = temp_emails.value.pop();
        selectedEmail.value.answer = null;
    } else {

        // complete and fill the form here
        form.test_id = quizz.value.test;
        form.department_id = quizz.value.department;

        router.post('/store', form)
        phase.value = 2;
    }


    setTimeout(() => {
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        tooltipTriggerList.forEach(tooltipTriggerEl => {
          new bootstrap.Tooltip(tooltipTriggerEl);
        });
      }, 200);

      setTimeout(() => { 
        emailUpdate.value = true;
      }, 200);



}

</script>

<template>

    <Head title="Quiz" />
    
        <Layout>
                <div v-show="phase == 0" class="row justify-content-center">
                <div class="col-md-6">
                <div class="card p-3 mt-5 c-card">
                    <!-- Select your Department -->
                    <h3 class="my-3"><strong>Wählen Sie Ihre Abteilung aus</strong></h3>
                    <div class="">
                    <form @submit.prevent="selectDepartment">
                        <div class="mb-4">
                            <!-- Department -->
                            <label class="form-check-label mb-3" for="role">Abteilung</label>
                            <select v-model="quizz.department" 
                                class="form-select" aria-label="Default select example">
                                <!-- Not Selected -->
                                <option selected disabled>Noch nicht ausgewählt</option>
                                <option  v-for="department in departments" :key="department.id" :value="department.id" >
                                {{ department.name }} 
                                </option>
                            </select>
                        </div>
                        <!-- Start Quiz  -->
                        <button type="submit" class="btn btn-primary">Quiz starten</button>
                    </form>
                    </div>
                </div>
                </div>

                </div>
                
                <div v-show="phase == 1"  class="row justify-content-center">
                    <div class="col-md-12" v-if="phase == 1">
                        <Transition name="mails">
                            <div  v-if="emailUpdate == true" class="card  px-3 c-card" >

                                <div v-if="selectedEmail">
                                    
                                    <div class=""  >

                                        <div class="sender ">
                                            <b>Absender: </b> 
                                            <button 
                                                type="button" class="btn btn-transparent border-transparent custom-tooltip mx-1 mb-0" data-bs-toggle="tooltip" 
                                                data-bs-placement="bottom" :data-bs-title="selectedEmail.sender_address.email">
                                                {{ selectedEmail.sender_address.name }}
                                            </button>


                                        </div>
                                        <div class="sender cc_list text-muted" style="opacity: 0.7;font-size: .8rem !important;">
                                            <b class="mr-1">CC: </b> 
                                            <button v-for="(cc, i) in selectedEmail.cc_addresses_list" :key="i" style="font-size: .8rem; padding: 0 !important;"
                                                type="button" class="btn btn-transparent btm-sm border-transparent custom-tooltip text-muted" data-bs-toggle="tooltip" 
                                                data-bs-placement="bottom" :data-bs-title="cc.email">
                                                {{ cc.name }}

                                                {{ i < selectedEmail.cc_addresses_list.length -1 ? ';' : '' }}
                                            </button>


                                        </div>

                                        <div class="subject mt-2">
                                        <b> Betreff: </b> {{ selectedEmail.title }}
                                        </div>

                                    </div>

                                    <hr>

                                    <div class="card-customized-body max-vh-80 overflow-auto mt-2" v-html="selectedEmail.body">
                                    </div>

                                </div>

                            </div>
                        </Transition>
                    </div>
                    <div class="col-12 row my-3 justify-content-center">
                            <div class="col-2 col-md-3 px-4">
                                <button style="min-width: 7rem !important;" type="button btn-custumized" class="btn btn-success" @click="saveAnswer('1')">
                                <i class="bi bi-check-lg"></i> Richtig </button>
                            </div>  
                            <div class="col-2 col-md-3 px-4">
                                <button style="min-width: 7rem !important;" type="button btn-custumized" class="btn btn-danger" @click="saveAnswer('0')">
                                <i class="bi bi-x-lg"></i> Phishing </button>
                            </div> 
                    </div>

                </div>
                
                <div v-show="phase == 2" class="row justify-content-center">
                <div class="col-md-6">
                <div class="card p-5 mt-5 c-card text-center">
                    <h1 class="dispaly-1"> Vielen Dank! </h1>
                    <p class="h5"> Für Ihre Teilnahme an diesem Quiz. </p>
                    
                </div>
                </div>

                </div>

        </Layout>
    </template>

<style scoped>

.card {
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.mails-enter-active {
  transition: all 0.3s ease-in-out;
}
.mails-enter-from{
  opacity: 0;
  transform: translateY(30px);
}
.mails-enter-to {
  opacity: 1;
  transform: cubic-bezier(0, 0, 0, 1);
}
.mails-leave-from {
  opacity: 1;
  transform: cubic-bezier(0, 0, 0, 1);
}
.mails-leave-to {
  opacity: 0;
  transform: translateY(30px);
}
.mails-leave-active {
    transition: all 0.3s ease-in-out;
}


.slide-fade-enter-active {
  transition: all 0.5s ease-out;
}

.slide-fade-leave-active {
  transition: all 0.5s cubic-bezier(1, 0.5, 0.8, 1);
}

.slide-fade-enter-from, .slide-fade-leave-to {
  transform: translateX(20px);
  opacity: 0;
}

.card-body {
    position: absolute;
    top: 0;
    right: 0; /* or any other value */
}
.card-customized-body{
    height: 65vh !important;
    min-height: 65vh !important;
    max-height: 65vh !important;
    overflow-y: auto !important;
}
.btn-custumized{
    min-width: 8rem !important;
}

.tooltip-inner {
    background-color: #657280;
    box-shadow: 0px 0px 4px rgb(46, 46, 72);
    font-size: 1rem !important; 
    min-width: none;
    opacity: 1 !important;
}
.tooltip.bs-tooltip-right .tooltip-arrow::before {
    border-right-color: #657280 !important;
}
.tooltip.bs-tooltip-left .tooltip-arrow::before {
    border-left-color: #657280 !important;
}
.tooltip.bs-tooltip-bottom .tooltip-arrow::before {
    border-bottom-color: #657280 !important;
}
.tooltip.bs-tooltip-top .tooltip-arrow::before {
    border-top-color: #657280 !important;
}
.custom-tooltip{
  border-radius: 3rem;
}


</style>