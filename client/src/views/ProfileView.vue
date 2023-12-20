<template>
  <div class="container">
    <div class="card" style="width: 100%">
      <div
        class="card-header"
        style="
          display: flex;
          align-items: center;
          justify-content: space-between;
        "
      >
        <h4>All Borrowed books</h4>
        <div
          style="
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
          "
        >
          <RouterLink to="/books/create" class="btn btn-info float-end">
            {{ user?.name }}
          </RouterLink>
        </div>
      </div>
      <div class="card-body">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>Name</th>
              <th>penalty_amount</th>
              <th>status</th>
              <th>Borrow date</th>
              <th>return date</th>
              <th>extension_date</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody v-if="this.books.length > 0">
            <template v-for="(book, index) in books" :key="index">
              <tr v-if="parseInt(book.user_id) === user?.id && book.penalty_status !=1">
                <td>{{ book.name }}</td>
                <td>{{ book.penalty_amount }}</td>
                <td>{{ book.status ? "Approved" : "Pending" }}</td>
                <td>{{ book.loan_date }}</td>
                <td>{{ book.return_date }}</td>
                <td>{{ book.extension_date }}</td>
                <td style="display: flex; gap: 2rem">
                  <button @click="deleteBook(book.id)" class="btn btn-danger">
                    Delete
                  </button>
                  <button @click="approveBook(book.id)" class="btn btn-info">
                    Return
                  </button>
                  <div
                    v-if="this.isDateExceededForBook(book.id)"
                    style="color: red; margin-bottom: 1rem"
                  >
                    Deadline Exceeded!! fine is 200ksh
                  </div>
                </td>
              </tr>
              <tr v-else></tr>
            </template>
          </tbody>
          <tbody v-else>
            <tr>
              <td colspan="6">Loading ...</td>
            </tr>
          </tbody>
        </table>
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
    };
  },
  computed: {
    isDateExceededForBook() {
      return (bookId) => {
        const book = this.books.find((book) => book.id === bookId);
        if (book) {
          const returnDate = book.return_date;
          const currentDate = new Date().toISOString().split("T")[0];
          console.log(returnDate); // Log the return date for the specific book
          return returnDate <= currentDate;
        }
        return false; // Return false if the book with the specified ID is not found
      };
    },
  },

  mounted() {
    this.getBooks();
    this.loadUser();
  },
  methods: {
    getBooks() {
      axios.get("http://127.0.0.1:8000/api/borrow").then((res) => {
        this.books = res.data.books;
      });
    },
    deleteBook(bookId) {
      if (confirm("Are you sure you want to delete?")) {
        axios
          .delete(`http://127.0.0.1:8000/api/borrow/${bookId}`)
          .then((res) => {
            alert(res.data.message);
            this.getBooks();
          })
          .catch((error) => {
            console.error("Error deleting book:", error);
            alert("Error deleting book: " + error.message);
          });
      } else {
        alert("Deletion canceled");
      }
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
          console.log("res", this.user);
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
    approveBook(bookId) {
      if (confirm("Are you sure you want to return this book?")) {
        axios
          .put(`http://127.0.0.1:8000/api/borrow/${bookId}`, {
            penalty_status: true,
          })
          .then((res) => {
            alert(res.data.message);
            this.getBooks();
          })
          .catch((error) => {
            console.error("Error updating book status:", error);
            alert("Error updating book status: " + error.message);
          });
      } else {
        alert("Approval canceled");
      }
    },
    returnBook(bookId) {
      // Add logic to handle book return
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
</style>
