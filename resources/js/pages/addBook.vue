<template>
  <main-layout>
    <v-container fill-height justify-center class="d-flex flex-column">
      <v-col class="shrink">
        <h1>Add Books</h1>
      </v-col>
      <v-col>
        <v-container fill-height>
          <v-form @submit.prevent="addBook">
            <v-text-field v-model="title" outlined name="title" label="Book Title"></v-text-field>
            <v-text-field v-model="author" outlined name="author" label="Author"></v-text-field>
            <v-btn type="submit">Add New Book</v-btn>
          </v-form>
        </v-container>
      </v-col>
    </v-container>
  </main-layout>
</template>

<script>
import MainLayout from '../layouts/MainLayout'
export default {
  components:{
    MainLayout
  },

  data:()=>({
    title:'',
    author:''
  }),

  methods:{
    addBook(){
      let formData = new FormData;
      formData.append('title',this.title)
      formData.append('author',this.author)

      console.log(formData)

      axios.post('/books', formData)
      .then(res=>{
        console.log(res.data)
      })
      .catch(err=>{
        console.log(err.response.data)
      })
    }
  }
}
</script>

<style>

</style>