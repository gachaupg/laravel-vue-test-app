<template>
    <div class="container mt-5">
      <div class="card">
        <div class="card-header">
          <h4>Update a book</h4>
        </div>
        <div class="card-body">
          <div class="mb-3">
            <label for="">Name of the user</label>
            <input v-model="model.books.name" type="text" class="form-control" />
          </div>
          <div class="mb-3">
            <label for="">email of the user</label>
            <input
              v-model="model.books.email"
              type="text"
              class="form-control"
            />
          </div>
          <div class="mb-3">
            <label for="">Password</label>
            <input v-model="model.books.password" type="text" class="form-control" />
          </div>
          
  
          <div class="mb-3">
            <button
              @click="saveBooks"
              style="width: 100%"
              class="btn btn-secondary"
            >
              Update the details
            </button>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import axios from "axios";
  
  export default {
    name: "booksCreate",
    data() {
      return {
        model: {
          books: {
            
            name: "",
            email: "",
            password: "",
            
          },
        },
      };
    },
    mounted() {
      // console.log(this.$route.params.id);
      this.bookId=this.$route.params.id;
      // console.log(this.bookId);
      this.getBooksData(this.$route.params.id);
    },
    methods: {
      getBooksData(bookId) {
        axios.get(`http://127.0.0.1:8000/api/user/${bookId}`).then((res) => {
          console.log(res.data);
          this.model.books = res.data.user;
        });
      },
  
      saveBooks() {
        axios
          .put(`http://127.0.0.1:8000/api/users/update/${this.bookId}`, this.model.books)
          .then((res) => {
            alert(res.data.message);
            this.model.student = {
            };
          });
      },
    },
  };
  </script>
  