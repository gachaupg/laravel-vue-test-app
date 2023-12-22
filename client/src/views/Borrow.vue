<template>
  <div class="container mt-5">
    <div class="card">
      <div class="card-header">
        <h4>Borrow a book</h4>
        <h4>{{ user?.name }} hhhh</h4>
      </div>
      <div class="card-body">
        <div class="mb-3">
          <label for="">Name of the book</label>
          <input v-model="model.books.name" type="text" class="form-control" />
        </div>
        <!-- <div class="mb-3">
          <label for="">Extended</label>
          <input v-model="model.books.extended" type="text" class="form-control" />
        </div> -->
        <div class="mb-3">
          <label for="">Borrowed at</label>
          <input v-model="model.books.loan_date" type="date" class="form-control" />
        </div>
        <div class="mb-3">
          <label for="">Return Date</label>
          <input v-model="model.books.return_date" type="date" class="form-control" />
        </div>
        <!-- <div class="mb-3">
          <label for="">Extension date</label>
          <input v-model="model.books.extension_date" type="date" class="form-control" />
        </div> -->
        <div class="mb-3">
          <label for="">Added by</label>
          <input v-model="model.books.added_by" type="text" class="form-control" />
        </div>
        <div class="mb-3">
          <label for="">Number of pages</label>
          <input v-model="model.books.pages" type="number" class="form-control" />
        </div>
        <!-- <div class="mb-3">
          <label for="">Image</label>
          <input v-model="model.books.image" type="text" class="form-control" />
        </div> -->

        <div class="mb-3">
          <button @click="saveBooks" style="width: 100%" class="btn btn-secondary">
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
  name: "books",
  data() {
    return {
      model: {
        books: {
          bookId: "",
          name: "",
          book_id: this.$route.params.id,
          // extended: "",
          // extension_date: "",
          penalty_amount: "200",
          added_by: "",
          user_id: "", // Initialize with an empty string
          loan_date: "",
          return_date: "",
          pages: 0,
          // image: "",
        },
      },

      user: null,
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
          // console.log("res", this.user);
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
        // console.log(res.data);
        this.model.books = res.data.book;
      });
    },

    saveBooks() {
      // Modify user_id and penalty_amount before sending the request
      this.model.books.user_id = "2"; // Update with the desired user_id
      this.model.books.penalty_amount = "300"; // Update with the desired penalty_amount
      this.model.books.book_id = this.$route.params.id; // Update with the desired penalty_amount
      this.model.books.user_id = this.user?.id; // Update with the desired penalty_amount

      axios
        .put(`http://127.0.0.1:8000/api/books/${this.bookId}`, this.model.books)
        .then((res) => {
          alert(res.data.message);
          //   this.model.books = {};
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
