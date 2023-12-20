<template>
    <div class="container mt-5">
      <div class="card">
        <div class="card-header">
          <h4>Add a User</h4>
        </div>
        <div class="card-body">
          <div class="mb-3">
            <label for="">Name of the User</label>
            <input v-model="model.books.name" type="text" class="form-control" />
          </div>
          <div class="mb-3">
            <label for="">Email of the User</label>
            <input
              v-model="model.books.email"
              type="email"
              class="form-control"
            />
          </div>
          <div class="mb-3">
            <label for="">Password of the user</label>
            <input v-model="model.books.password" type="password" class="form-control" />
          </div>
          
  
          <div class="mb-3">
            <button
              @click="saveBooks"
              style="width: 100%"
              class="btn btn-secondary"
            >
              Save the details
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
    methods: {
      saveBooks() {
        axios
  .post("http://127.0.0.1:8000/api/users/register", this.model.books)
  .then((res) => {
    console.log("Response:", res);
    alert(res.data.message);
  })
  .catch((error) => {
    console.error("Error saving user:", error);
    // Check if the error has a response from the server
    if (error.response) {
      // The request was made and the server responded with a status code
      // that falls out of the range of 2xx
      alert("Server Error: " + error.response.data.message);
    } else if (error.request) {
      // The request was made but no response was received
      alert("No response received from the server.");
    } else {
      // Something happened in setting up the request that triggered an Error
      alert("Error: " + error.message);
    }
  });

  },
  
  
    },
  };
  </script>
  