<template>
  <main-layout>
    <v-container fill-height justify-center class="flex-column">
      <v-col class="shrink">
        <v-col class="d-flex shrink py-0 justify-space-between">
          <v-btn v-if="$vuetify.theme.dark" color="yellow" @click="$vuetify.theme.dark=!$vuetify.theme.dark" icon><v-icon>mdi-white-balance-sunny</v-icon></v-btn>
          <v-btn v-if="!$vuetify.theme.dark" color="blue" @click="$vuetify.theme.dark=!$vuetify.theme.dark" icon><v-icon>mdi-moon-waxing-crescent</v-icon></v-btn>
          <v-menu 
              offset-y
              bottom
              left
            >
            <template v-slot:activator="{ on, attrs }">
              <v-btn
                dark
                v-bind="attrs"
                v-on="on"
                class="text-capitalize"
              >
                <div>Download CSV Files</div>
                <v-icon>mdi-menu-down</v-icon>
              </v-btn>
            </template>

            <v-list>
              <v-list-item @click="handle_function_call(item.functionName)" v-for="(item,index) in downloads" :key="index">
                <v-col class="pa-0">
                  <div class="d-flex">
                    <v-list-item-avatar><v-icon color="green">mdi-file-delimited-outline</v-icon></v-list-item-avatar>
                    <v-list-item-content>
                      <v-list-item-title>{{item.name}}</v-list-item-title>
                    </v-list-item-content>
                    <v-list-item-avatar><v-icon color="orange">mdi-download</v-icon></v-list-item-avatar>
                  </div>
                  <div v-if="item.divider" class="d-flex">
                    <v-divider class="my-0"></v-divider>
                  </div>
                </v-col>
              </v-list-item>
            </v-list>
          </v-menu>
        </v-col>
      </v-col>
      <v-col class="flex-1">
        <v-container fill-height justify-center>
          <v-data-table
            class="col-12 pa-0 elevation-2"
            :headers="headers"
            :items="books"
            sort-by="Title"
            :search="search"
          >
            <template v-slot:top>
              <v-toolbar
                flat
                rounded
                color="green darken-1"
              >
                <v-toolbar-title>Books</v-toolbar-title>
                <v-spacer></v-spacer>
                <v-btn
                  dark
                  @click="dialog=!dialog"
                >
                  Add Book
                </v-btn>
                    
              </v-toolbar>
              <v-container>
                <v-text-field
                  gitv-model="search"
                  outlined
                  dense
                  append-icon="mdi-magnify"
                  label="Search"
                  hide-details
                ></v-text-field>             
              </v-container>
            </template>
            <template v-slot:[`item.actions`]="{ item }">
              <v-icon
                color="orange"
              
                class="mr-2"
                @click="editItem(item)"
              >
                mdi-pencil
              </v-icon>
              <v-icon
                color="red"
                
                @click="deleteItem(item)"
              >
                mdi-delete
              </v-icon>
            </template>
            <template v-slot:no-data>
              <v-btn
                color="blue-grey darken-4"
                @click="initialize"
              >
                Reset
              </v-btn>
            </template>
          </v-data-table>
        </v-container>
      </v-col>
      <v-snackbar
        v-model="snackbar"
        :multi-line="multiLine"
        outlined
      >
        {{ text }}

        <template v-slot:action="{ attrs }">
          <v-btn
            :color="snackbarColor"
            text
            v-bind="attrs"
            @click="snackbar = false"
          >
            Close
          </v-btn>
        </template>
      </v-snackbar>
    </v-container>
    <v-dialog v-model="dialog"
      content-class="col-12 col-md-6 pa-0"                   
    >
      <v-card :color="$vuetify.theme.dark?'blue-grey darken-4':''">
        <v-card-title>
          <span class="headline">{{ formTitle }}</span>
        </v-card-title>

        <v-form @submit.prevent="sendFormTo">
          <v-card-text>
            <v-container>
              <v-text-field v-model="editedItem.title" outlined name="title" label="Book Title"></v-text-field>
              <v-text-field v-model="editedItem.author" outlined name="author" label="Author"></v-text-field>
            </v-container>
          </v-card-text>

          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn
              
              text
              @click="close"
            >
              Cancel
            </v-btn>
            <v-btn
              
              text
              type="submit"
            >
              Save
            </v-btn>
          </v-card-actions>
        </v-form>
      </v-card>
    </v-dialog>
    <v-dialog v-model="dialogDelete"
      content-class="col-12 col-md-6 pa-0" 
      >
      <v-card color="blue-grey darken-4">
        <v-card-title class="headline">Are you sure you want to delete this item?</v-card-title>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" text @click="closeDelete">Cancel</v-btn>
          <v-btn color="blue darken-1" text @click="deleteItemConfirm">OK</v-btn>
          <v-spacer></v-spacer>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </main-layout>
</template>

<script>

import MainLayout from '../layouts/MainLayout'

export default {

  components:{
    MainLayout
  },

  data:()=>({
    books:[],
    search:'',
    headers: [
      { text: 'Title', value: 'title', sortable:true, filterable:true },
      { text: 'Author', value: 'author',sortable:true, filterable:true },
      { text: 'Actions', value: 'actions', sortable:false, filterable:false }
    ],
    dialog: false,
    dialogDelete: false,
    editedIndex: -1,
    editedItem: {
      title:'',
      author:''
    },
    defaultItem: {
      title:'',
      author:''
    },
    snackbar: false,
    snackbarColor : "success",
    text : "No Change Detected",
    multiLine:true,

    dark:true,

    downloads:[
      {
        name:'Titles.csv',
        functionName:'d_title',
        divider:true
      },
      {
        name:'Authors.csv',
        functionName:'d_author',
        divider:true
      },
      {
        name:'Titles & Authors.csv',
        functionName:'d_title_w_author',
        divider:false
      },
    ]

  }),

  computed: {
    formTitle () {
      return this.editedIndex === -1 ? 'Add Book' : 'Edit Book'
    },
  },

  watch: {
    dialog (val) {
      val || this.close()
    },
    dialogDelete (val) {
      val || this.closeDelete()
    },
  },

  

  beforeCreate () {
    axios.get('/books')
    .then(res=>{
      // console.log(res.data)
      res.data.forEach(element => {
        this.books.push(element)        
      });      
    })
    .catch(err=>{
      console.log(err.response)
    })
  },

  methods: {
    initialize () {
      this.books=[]
      axios.get('/books')
      .then(res=>{
        console.log(res.data)
        res.data.forEach(element => {
          this.books.push(element)        
        });      
      })
      .catch(err=>{
        console.log(err.response)
      })
      console.log(this.books)
    },

    handle_function_call(function_name) {
      this[function_name]()
    },

    editItem (item) {
      this.editedIndex = this.books.indexOf(item)
      this.editedItem = Object.assign({}, item)
      this.dialog = true
    },

    sendFormTo(){
      if(this.formTitle==='Add Book')
        this.add()
      else if(this.formTitle==='Edit Book')
        this.edit()
    },

    edit(){
      let formData = new FormData;
      formData.append('title',this.editedItem.title)
      formData.append('author',this.editedItem.author)
      axios.put('/books/'+ this.editedItem.id, {'title':this.editedItem.title, 'author':this.editedItem.author})
      .then(res=>{
        console.log(res.data)
        if(res.data.message==="No Change"){
          this.text = "No Change Detected"
          this.snackbarColor="red"
          this.snackbar=true
        }
        else{
          this.text = "Changes Saved"
          this.snackbarColor="success"
          this.snackbar=true
          this.initialize()
        }
      })
      .catch(err=>{
        console.log(err.response.data)
      })

      this.close()
    },

    deleteItem (item) {
      this.editedIndex = this.books.indexOf(item)
      this.editedItem = Object.assign({}, item)
      this.dialogDelete = true
    },

    deleteItemConfirm () {
      // this.books.splice(this.editedIndex, 1)
      axios.delete('/books/' + this.editedItem.id)
      .then(res=>{
        console.log(res.data)
        this.initialize()
      })
      this.closeDelete()
    },

    close () {
      this.dialog = false
      this.$nextTick(() => {
        this.editedItem = Object.assign({}, this.defaultItem)
        this.editedIndex = -1
      })
    },

    closeDelete () {
      this.dialogDelete = false
      this.$nextTick(() => {
        this.editedItem = Object.assign({}, this.defaultItem)
        this.editedIndex = -1
      })
    },

    add () {
      let formData = new FormData;
      formData.append('title',this.editedItem.title)
      formData.append('author',this.editedItem.author)

      console.log(formData)

      axios.post('/books', formData)
      .then(res=>{
        console.log(res.data)
      })
      .catch(err=>{
        console.log(err.response.data)
      })
      this.initialize()
      this.close()
    },

    downloadFunction(list, fileName){
      var str = '';
      for (var i = 0; i < list.length; i++) { 
        let line = '';
        line = list[i].join(",");
        str += line + '\r\n';
      }
      var blob = new Blob([str], { type: 'text/csv;charset=utf-8;' });
      var link = document.createElement('a');
      var url = URL.createObjectURL(blob);
      link.setAttribute('href', url);
      link.setAttribute('download', fileName);
      link.style.visibility = 'hidden';
      document.body.appendChild(link);
      link.click();
      document.body.removeChild(link);
    },

    d_title_w_author(){
      let list = [['Titles', 'Authors']]
      this.books.forEach(book => {
        list.push([book.title, book.author])
      });    
      
      this.downloadFunction(list,'titles_w_author.csv')      
    },

    d_title(){
      let list = [['Titles']]
      this.books.forEach(book => {
        list.push([book.title])
      });    
      
      this.downloadFunction(list, 'title.csv') 
    },

    d_author(){
      let list = [['Authors']]
      this.books.forEach(book => {
        list.push([book.author])
      });    
      
      this.downloadFunction(list,'author.csv') 
    }

  }

}
</script>

<style>
.v-btn:focus {
  outline:none;
  box-shadow: none;
  border: none;
}

</style>