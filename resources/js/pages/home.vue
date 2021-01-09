<template>
  <main-layout>
    <v-container fill-height justify-center>
      <v-data-table
        :headers="headers"
        :items="books"
      >
        <template v-slot:top>
          <v-toolbar
            flat
          >
            <v-toolbar-title>Books</v-toolbar-title>

            <v-spacer></v-spacer>
            <v-dialog
              v-model="dialog"
              max-width="500px"
            >
              <template v-slot:activator="{ on, attrs }">
                <v-btn
                  color="primary"
                  dark
                  class="mb-2"
                  v-bind="attrs"
                  v-on="on"
                >
                  Add Book
                </v-btn>
              </template>
              <v-card>
                <v-card-title>
                  <span class="headline">{{ formTitle }}</span>
                </v-card-title>

                <v-card-text>
                  <v-container>
                    <v-row>
                      <v-col
                        cols="12"
                        sm="6"
                        md="4"
                      >
                        <v-text-field
                          v-model="editedItem.title"
                          label="Title"
                        ></v-text-field>
                      </v-col>
                      <v-col
                        cols="12"
                        sm="6"
                        md="4"
                      >
                        <v-text-field
                          v-model="editedItem.author"
                          label="Author"
                        ></v-text-field>
                      </v-col>
                    </v-row>
                  </v-container>
                </v-card-text>

                <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn
                    color="blue darken-1"
                    text
                    @click="close"
                  >
                    Cancel
                  </v-btn>
                  <v-btn
                    color="blue darken-1"
                    text
                    @click="save"
                  >
                    Save
                  </v-btn>
                </v-card-actions>
              </v-card>
            </v-dialog>
            <v-dialog v-model="dialogDelete" max-width="500px">
              <v-card>
                <v-card-title class="headline">Are you sure you want to delete this item?</v-card-title>
                <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn color="blue darken-1" text @click="closeDelete">Cancel</v-btn>
                  <v-btn color="blue darken-1" text @click="deleteItemConfirm">OK</v-btn>
                  <v-spacer></v-spacer>
                </v-card-actions>
              </v-card>
            </v-dialog>
          </v-toolbar>
        </template>
        <template v-slot:[`item.actions`]="{ item }">
          <v-icon
            small
            class="mr-2"
            @click="editItem(item)"
          >
            mdi-pencil
          </v-icon>
          <v-icon
            small
            @click="deleteItem(item)"
          >
            mdi-delete
          </v-icon>
        </template>
        <template v-slot:no-data>
          <v-btn
            color="primary"
            @click="initialize"
          >
            Reset
          </v-btn>
        </template>
      </v-data-table>
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
    books:[],
    headers: [
      { text: 'Title', value: 'title', sortable:true },
      { text: 'Author', value: 'author',sortable:true },
      { text: 'Actions', value: 'actions', sortable:false }
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
  }),

  computed: {
    formTitle () {
      return this.editedIndex === -1 ? 'Add Book' : 'Edit'
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
    axios.get('/getBooks')
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

  methods: {
    initialize () {
      axios.get('/getBooks')
      .then(res=>{
        console.log(res.data)
        res.data.forEach(element => {
          this.books.push(element)        
        });      
      })
      .catch(err=>{
        console.log(err.response)
      })
      // this.books = books
      console.log(this.books)
    },

    editItem (item) {
        this.editedIndex = this.books.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialog = true
      },

      deleteItem (item) {
        this.editedIndex = this.books.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialogDelete = true
      },

      deleteItemConfirm () {
        this.books.splice(this.editedIndex, 1)
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

      save () {
        if (this.editedIndex > -1) {
          Object.assign(this.books[this.editedIndex], this.editedItem)
        } else {
          this.books.push(this.editedItem)
        }
        this.close()
      },
  }

}
</script>

<style>

</style>