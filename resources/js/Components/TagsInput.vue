<template>
    <div>

      <div class="input-group mb-3">

            <span class="input-group-text">@</span>

            <input v-model="tag.name"
              @keyup.enter="addTag"
              type="text" class="form-control" placeholder="Apearing Name" aria-label="Appearing Name">

            <span class="input-group-text">@</span>

            <input v-model="tag.email"
              @keyup.enter="addTag"
              type="email" class="form-control" placeholder="Email Address" aria-label="Email Address">

        <button @click="addTag" class="btn btn-outline-primary" type="button">Add</button>
      </div>


      <div class="mt-2">  
        
      <button v-for="(tag, index) in tags"
              :key="index"
              type="button" class="btn btn-primary custom-tooltip mx-1 mb-1" data-bs-toggle="tooltip" 
              data-bs-placement="bottom" :data-bs-title="tag.email">
        {{ tag.name }}
        <button @click="removeTag(index)" type="button" class="btn-close btn-close-white"></button>


      </button>

      </div>
    </div>
  </template>
  
  <script setup>
  
  import { ref, defineEmits, defineProps, onMounted} from 'vue';

const props = defineProps(['cc_list']);
// const cc_list = ref(props.cc_addresses_list)


  const emits = defineEmits();
  const tag = ref({ name: '', email: '' });
  const tags = ref([]);


  onMounted(() => {
    // Initialize tooltips after component is mounted
  const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    tooltipTriggerList.forEach(tooltipTriggerEl => {
      new bootstrap.Tooltip(tooltipTriggerEl);
    });

  setTimeout(() => {
    if (props.cc_list) {
      props.cc_list.forEach((v) => {
        tags.value.push(v);
      })
    }
  }, 1000);


  });


  const addTag = () => {
    const Email = tag.value.email.trim();
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (Email !== '' && emailRegex.test(Email)) {
      tags.value.push({ ...tag.value });
      tag.value.name =  '' ;
      tag.value.email =  '' ;

      emits('update:cc_addresses_list', tags);


      // Add the new tag and then initialize the tooltip
      // with a slight delay to ensure it's in the DOM
      setTimeout(() => {
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        tooltipTriggerList.forEach(tooltipTriggerEl => {
          new bootstrap.Tooltip(tooltipTriggerEl);
        });
      }, 0);

    } else {
      alert('Please enter a valid email address');
    }
  };

  const removeTag = (index) => {
    tags.value.splice(index, 1);
    emits('update:cc_addresses_list', tags);

  };




  </script>
  
  <style>
  
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
  