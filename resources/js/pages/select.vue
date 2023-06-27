<template>
    <div>
                           
    </div>

  </template>

  <script>
  import axios from 'axios';

  export default {
    data() {
      return {
        searchTerm: '',
        results: [],
      };
    },
    methods: {
      fetchResults() {
        axios
          .get(`states?search=${this.searchTerm}`)
          .then(response => {
            this.results = response.data;
          })
          .catch(error => {
            console.error(error);
          });
      },
      selectResult(result) {
        console.log(result);
      },
    },
  };
  </script>
