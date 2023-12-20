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
          <!-- Your other RouterLinks can be added here if needed -->
        </div>
      </div>
      <div class="card-body">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>Name</th>
              <th>book_id</th>
              <th>penalty_amount</th>
              <th>status</th>
              <th>user_id</th>
              <th>Borrow date</th>
              <th>return date</th>
              <th>extension_date</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody v-if="this.books.length > 0">
            <template v-for="(book, index) in books" :key="index">
              <tr v-if="book.penalty_amount > 1">
                <td>{{ book.name }}</td>
                <td>{{ book.book_id }}</td>
                <td>{{ book.penalty_amount }}</td>
                <td>{{ book.status ? "Approved" : "Pending" }}</td>
                <td>{{ book.user_id }}</td>
                <td>{{ book.loan_date }}</td>
                <td>{{ book.return_date }}</td>
                <td>{{ book.extension_date }}</td>
                <td style="display: flex; gap: 2rem">
                  <button @click="approveBook(book.id)" class="btn btn-info">
                    Approve
                  </button>
                  <button
                    class="btn btn-success"
                  >
                  {{ book.penalty_status=== '1' ?'Returned':'Pending'  }} 
                  </button>
                  <button @click="deleteBook(book.id)" class="btn btn-danger">
                    Delete
                  </button>
                </td>
              </tr>
              <!-- You might want to add a row for books with penalty_amount <= 1 here -->
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
    };
  },
  mounted() {
    this.getBooks();
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
    approveBook(bookId) {
      if (confirm("Are you sure you want to approve?")) {
        axios
          .put(`http://127.0.0.1:8000/api/borrow/return/${bookId}`, {
            status: true,
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
