<template>
  <div style="padding: 1rem" class="">
    <div class="card" style="width: 100%">
     
      <section class="" style="background-color: #9de2ff">
        <div class="container py-5 h-100">
          <div
            class="row d-flex justify-content-center align-items-center h-100"
          >
            <div class="col col-md-9 col-lg-7 col-xl-5">
              <div class="card" style="border-radius: 15px">
                <div class="card-body p-4">
                  <div class="d-flex text-black">
                    <div class="flex-shrink-0">
                      <img
                        src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-profiles/avatar-1.webp"
                        alt="Generic placeholder image"
                        class="img-fluid"
                        style="width: 180px; border-radius: 10px"
                      />
                    </div>
                    <div class="flex-grow-1 ms-3">
                      <h5 class="mb-1">{{ user?.name }}</h5>
                      <p class="mb-2 pb-1" style="color: #2b2a2a">
                        {{ user?.email }}
                      </p>
                      <div
                        class="d-flex justify-content-start rounded-3 p-2 mb-2"
                        style="background-color: #efefef"
                      >
                        <div>
                          <p class="small text-muted mb-1">Articles</p>
                          <p class="mb-0">41</p>
                        </div>
                        <div class="px-3">
                          <p class="small text-muted mb-1">Followers</p>
                          <p class="mb-0">976</p>
                        </div>
                        <div>
                          <p class="small text-muted mb-1">Rating</p>
                          <p class="mb-0">8.5</p>
                        </div>
                      </div>
                      <div class="d-flex pt-1">
                        <button
                          type="button"
                          class="btn btn-outline-primary me-1 flex-grow-1"
                        >
                          Chat
                        </button>
                        <button
                          type="button"
                          class="btn btn-primary flex-grow-1"
                        >
                          Follow
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
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
              <!-- <th>extension_date</th> -->
              <th>Actions</th>
              <th>Updates</th>
            </tr>
          </thead>
          <tbody v-if="this.books?.length > 0">
            <template v-for="(book, index) in books" :key="index">
              <tr v-if="parseInt(book.user_id) === user?.id">
                <td>{{ book.name }}</td>
                <td>{{ book.penalty_amount }}</td>
                <td>{{ book.status ? "Approved" : "Pending" }}</td>
                <td>{{ book.loan_date }}</td>
                <td>{{ book.return_date }}</td>
                <!-- <td>{{ book.extension_date }}</td> -->
                <td style="display: flex; gap: 2rem">
                  <button @click="deleteBook(book.id)" class="btn btn-danger">
                    Delete
                  </button>
                  <button @click="approveBook(book.id)" class="btn btn-info">
                    Return
                  </button>
                </td>
                <td
                  v-if="this.isDateExceededForBook(book.id)"
                  style="color: red; margin-bottom: 1rem"
                >
                  Deadline Exceeded!! fine is 300ksh
                  <br />
                  <RouterLink :to="{ path: '/extend/' + book.id }"
                    >Extend the dates</RouterLink
                  >
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
