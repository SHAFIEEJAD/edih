<template>

<Head title="Login" />

<AuthLayout>

      <div class="row justify-content-center">
        <div class="col-md-6">
          <div class="card">
            <div class="card-header">Login</div>
            <div class="card-body">
              <form @submit.prevent="submitForm">
                <div class="mb-3">
                  <label for="email" class="form-label">Email Address</label>
                  <input v-model="login.email" type="email" class="form-control" id="email" required autofocus>
                </div>
                <div class="mb-3">
                  <label for="password" class="form-label">Password</label>
                  <input v-model="login.password" type="password" class="form-control" id="password" required>
                </div>
                <!-- <div class="mb-3 form-check">
                  <input v-model="login.remember" type="checkbox" class="form-check-input" id="remember">
                  <label class="form-check-label" for="remember">Remember Me</label>
                </div> -->
                <button type="submit" class="btn btn-primary">Login</button>
              </form>
            </div>
          </div>
        </div>
      </div>


</AuthLayout>
</template>

<script setup>
import { defineComponent } from 'vue';
import AuthLayout from '../../Layouts/Auth.vue';
import { ref } from 'vue';
import { Head, router, useForm } from '@inertiajs/vue3';


const LayoutComponent = defineComponent({
  components: { AuthLayout }
});

defineProps({
    errors:Object
});

const login = useForm({
  email: '',
  password: '',
  remember: false,
});


function submitForm() {
    router.post('login', login)
}



</script>