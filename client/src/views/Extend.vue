<template>
    <div class="container mt-5">
      <div class="card">
        <div class="card-header">
          <h4>Extend the dates</h4>
  
          <div class="mb-3">
            <label for="">Extension date</label>
            <input v-model="model.books.return_date" type="date" class="form-control" />
          </div>
  
          <div class="mb-3">
            <button @click="saveBooks" style="width: 100%" class="btn btn-secondary">
              Extend the dates
            </button>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import axios from "axios";
  
  export default {
    name: "books",
    data() {
      return {
        model: {
          books: {
            return_date: "",
          },
        },
        user: null,
        bookId: null, // Declare bookId in data
      };
    },
  
    mounted() {
      this.loadUser();
      this.bookId = this.$route.params.id;
      this.getBooksData(this.$route.params.id);
    },
    methods: {
      loadUser() {
        axios
          .get("http://127.0.0.1:8000/api/user", {
            headers: {
              Authorization: `Bearer ${localStorage.getItem("token")}`,
            },
          })
          .then((response) => {
            this.user = response.data;
          })
          .catch((error) => {
            console.error("Failed to load user:", error.response.data.message);
          });
      },
      logout() {
        axios
          .post("http://127.0.0.1:8000/api/logout")
          .then(() => {
            localStorage.removeItem("token");
            this.$router.push("/login");
          })
          .catch((error) => {
            console.error("Logout failed:", error.response.data.message);
          });
      },
  
      getBooksData(bookId) {
        axios.get(`http://127.0.0.1:8000/api/books/${bookId}`).then((res) => {
          this.model.books = res.data.book;
        });
      },
  
      saveBooks() {
        // Modify user_id and penalty_amount before sending the request
        // Update with the desired penalty_amount
        axios
        .put(`http://127.0.0.1:8000/api/books/${this.bookId}`, this.model.books)
          .then((res) => {
            alert(res.data.message);
          });
      },
    },
  };
  </script>
  
  <style>
  .card-body-card {
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: center;
    gap: 2rem;
    flex-wrap: wrap;
  }
  
  .img {
    height: 10rem !important;
    object-fit: cover;
  }
  </style>
  