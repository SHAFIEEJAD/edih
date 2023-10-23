<template>




<div class="container  pt-0" style="height: 100vh !important;">

<div class="row align-items-center" href="#">
    <img src="/assets/logo.svg" alt="Logo" class="navbar-logo col-1" style="max-height: 3rem;"> 
    <div class="col-1">edih-swipe</div>

    <div class="col-3 ms-auto  align-self-end text-center" >
        <button href="/"  class="btn btn-secondary btn-sm" @click.prevent="refreshPage">
            Neues Quiz Starten
        </button>
    </div>
</div>

<div class="align-items-center">

        <div class="container">
            
            <div v-if="$page.props.flash.message" 
                :class="['alert', 'col-4', 'my-2', 'mx-auto', 'text-center', 
                { 'alert-success': $page.props.flash.type === 'success',
                'alert-danger': $page.props.flash.type === 'error' }]" 
                role="alert">
                {{ $page.props.flash.message }}
            </div>

            <div class="px-3 pt-2 w-90">
            <slot></slot>

            </div>

        </div>


</div>

</div>

</template>

<script setup>
import { Link } from '@inertiajs/vue3';

const refreshPage = (event) => {
    event.preventDefault();
    location.reload();
}


</script>