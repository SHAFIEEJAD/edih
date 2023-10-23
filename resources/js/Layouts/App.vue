<template>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <img src="/assets/logo.svg" alt="Logo" class="navbar-logo" style="max-height: 3rem;"> 
            edih-swipe
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse mx-5" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
                <Link href="/dashboard" 
                    :class="['nav-link', {'active': $page.component === 'admin/dashboard' }]">Home</Link>
            </li>
            <li class="nav-item" v-if=" $page.props.permissions.user_manage">
                <Link href="/dashboard/users" 
                    :class="['nav-link', {'active': $page.url.includes('/user')}]">Admins</Link>
            </li>
            <li class="nav-item" v-if=" $page.props.permissions.test_manage">
                <Link href="/dashboard/tests" 
                    :class="['nav-link', {'active': $page.url.includes('/test')}]">Tests</Link>
            </li>
            <li class="nav-item" v-if=" $page.props.permissions.email_manage">
                <Link href="/dashboard/emails" 
                    :class="['nav-link', {'active': $page.url.includes('/email')}]">Emails</Link>
            </li>
            <li class="nav-item" v-if=" $page.props.permissions.department_manage">
                <Link href="/dashboard/departments" 
                    :class="['nav-link', {'active': $page.url.includes('/department')}]">Departments</Link>
            </li>



        </ul>

        <div class="d-flex mx-5">
            Hi, {{ $page.props.user.name }}
        </div>

        <div class="d-flex">
          <Link href="/dashboard/logout" method="post" class="btn btn-danger">Logout</Link>
        </div>

        </div>
    </div>
    </nav>

<div class="container-fluied p-3 pt-0">
    
    <div v-if="$page.props.flash.message" 
         :class="['alert', 'col-4', 'my-2', 'mx-auto', 'text-center', 
         { 'alert-success': $page.props.flash.type === 'success',
          'alert-danger': $page.props.flash.type === 'error' }]" 
         role="alert">
        {{ $page.props.flash.message }}
    </div>

    <div class="p-3 w-90">
    <slot></slot>

    </div>
</div>



</template>

<script setup>
import { Link, router } from '@inertiajs/vue3';


defineProps({
    permissions: Object
});

</script>