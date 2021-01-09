<template>
  <main-layout>
    <v-container fill-height justify-center>
    <!-- @{{books}} -->
    </v-container>
  </main-layout>
</template>

<script>

import MainLayout from '../layouts/MainLayout'

export default {

  props:[
    'books'
  ],

  components:{
    MainLayout
  },

  mounted(){
    console.log(this.books)
  }

}
</script>

<style>

</style>