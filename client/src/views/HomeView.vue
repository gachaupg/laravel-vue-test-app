<template>
  <div class="book">
    <div class="card">
      <div class="card-header">
        <h4>All books</h4>
        <p v-if="user">Welcome, {{ user?.name }}</p>
      </div>
      <div class="card-body card-body-card">
        <div v-if="loading">
          <p>Loading...</p>
        </div>
        <div v-else>
          <div v-if="books.length === 0">
            <p>No posted books</p>
          </div>
          <div style="display: flex; flex-wrap: wrap;gap: 2px;" v-else>
            <div v-for="(book, index) in books" :key="index" class="card mb-3" style="max-width: 300px">
              <div class="row g-0">
                <img
                :src="book.image ? book.image : 'https://images.pexels.com/photos/1181671/pexels-photo-1181671.jpeg?auto=compress&cs=tinysrgb&w=600'"
                  class="img"
                  :alt="book.name"
                />
                <div class="card-body">
                  <h5 class="card-title">{{ book.name }}</h5>
                  <hr>
                  <p style="display: flex; align-items: center;justify-content: space-between;">
                    <p>Publisher :</p> <p> {{ book.publisher }}</p>
                  </p>
                  <p style="display: flex; align-items: center;justify-content: space-between;">
                    <p>Isbn :</p> <p> {{ book.isbn }}</p>
                  </p>
                  <p style="display: flex; align-items: center;justify-content: space-between;">
                    <p>category:</p> <p> {{ book.category }}</p>
                  </p>
                  <hr>
                  <p style="display: flex; align-items: center; justify-content: space-between;" class="card-text">
                    <p>{{ book.pages }} pages</p>
         
                    <div>
    <RouterLink
      v-if="book.penalty_amount === 0"
      style="width: 100%; margin-bottom: 1px;"
      :to="{ path: '/books/' + book.id + '/borrow' }"
      class="btn btn-success"
    >
      Borrow a book
    </RouterLink>
    <p style="color: brown;" v-else>Book already borrowed </p>
    
  </div>
                  </p>
                  
                </div>
              </div>
            </div>
          </div>
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
      books: [],
      user: null,
      loading: true, // Add loading state
    };
  },
  mounted() {
    this.getBooks();
    this.loadUser();
  },
  methods: {
    getBooks() {
      axios
        .get("http://127.0.0.1:8000/api/books")
        .then((res) => {
          this.books = res.data.books;
          this.loading = false; // Set loading to false after fetching books
        })
        .catch((error) => {
          console.error("Error fetching books:", error);
          this.loading = false; // Set loading to false in case of an error
        });
    },
    imageLoaded() {
      console.log('Image loaded successfully');
    },
    loadUser() {
      axios
        .get("http://127.0.0.1:8000/api/user", {
          headers: {
            Authorization: `Bearer ${localStorage.getItem("token")}`,
          },
        })
        .then((response) => {
          this.user = response.data;
          console.log('res', this.user);
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
