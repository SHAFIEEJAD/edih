<template>


<div class="container-fluied  pt-0" style="height: 100vh !important;">

    <div class="" href="#">
        <img src="/assets/logo.svg" alt="Logo" class="navbar-logo" style="max-height: 3rem;"> 
        edih-swipe
    </div>

    <div class="bg-light d-flex align-items-center" style="height: 93vh !important;">

            <div class="container">
                
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


    </div>

</div>



</template>

<script setup>
import { Link } from '@inertiajs/vue3';


</script>