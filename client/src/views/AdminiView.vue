<template>
  <div class="dash-top">
    <div class="dash">
      
    Total Books:  {{ books.length }}
     
    </div>
    <div class="dash">
      
      Total Users:  {{ users.length }}
       
      </div>
      <div class="dash">
      
      Borrowed Books:  {{ borrowedbooks.length }}
       
      </div>
  </div>
 
  <div class="">
    <div class="card" style="width: 98%; margin-left: 1rem;">
      <div
        class="card-header"
        style="
          display: flex;
          align-items: center;
          justify-content: space-between;
        "
      >
        <h4>All books</h4>
        <div
          style="
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
          "
        >
          <RouterLink to="/books/create" class="btn btn-info float-end">
            Add a book
          </RouterLink>
          <RouterLink to="/allUsers" class="btn btn-success float-end">
            All Users
          </RouterLink>
          <RouterLink to="/borrowed" class="btn btn-warning float-end">
            Borrowed Books
          </RouterLink>
        </div>


        
      </div>
      <div class="card-body">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>Name</th>
              <th>Publisher</th>
              <th>isbn</th>
              <th>added-by</th>
              <!-- <th>pages</th> -->
              <th>CreatedAt</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody v-if="this.books.length > 0">
            <tr v-for="(book, index) in books" :key="index">
              <!-- Content for each table row goes here -->
              <td>{{ book.name }}</td>
              <td>{{ book.publisher }}</td>
              <td>{{ book.isbn }}</td>
              <!-- <td>{{ book.category }}</td> -->
              <td>{{ book.added_by }}</td>
              <td>{{ book.created_at }}</td>
              <td style="display: flex; justify-content: space-between">
                <RouterLink
                  style="width: 4.5rem; margin-bottom: 1px"
                  :to="{ path: '/books/' + book.id + '/edit' }"
                  class="btn btn-success"
                >
                  Edit
                </RouterLink>
                <button @click="deleteBook(book.id)" class="btn btn-danger">
                  Delete
                </button>
              </td>
            </tr>
          </tbody>
          <tbody v-else>
            <tr>
              <td colspan="6">Loading ...</td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="charts">
    charts
    <canvas width="400" height="100" id="myChart"></canvas>

  </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import Chart from 'chart.js/auto';

export default {
  name: "books",
  data() {
    return {
      books: [],
      users: [],
      borrowedbooks: [],
    };
  },
  mounted() {
    this.getBooks();
    this.getUsers();
    this.getBorrowedBooks()
    const ctx = document.getElementById('myChart');

    const myChart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: ['users', 'books', 'borrowedBooks'],
        datasets: [{
          label: '# starts',
          data: [this.users.length, this.books.length, this.borrowedbooks.length],
          borderWidth: 0.5
        }]
      },
      options: {
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    });
myChart
  },
  
  methods: {
    getBooks() {
      axios.get("http://127.0.0.1:8000/api/books").then((res) => {
        this.books = res.data.books;
      });
    },
    getUsers() {
      axios.get("http://127.0.0.1:8000/api/users").then((res) => {
        this.users = res.data.users;
        console.log('data');
      });
    },
    getBorrowedBooks() { // Corrected method name
      axios.get("http://127.0.0.1:8000/api/borrow").then((res) => {
        this.borrowedbooks = res.data.books;
      });
    },
    deleteBook(bookId) {
      if (confirm("Are you sure you want to delete?")) {
        axios.delete(`http://127.0.0.1:8000/api/books/${bookId}`).then((res) => {
          alert(res.data.message);
          this.getBooks();
        });
      } else {
        alert("No ID found");
      }
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
.dash-top {
  margin-left: 1rem;

  width: 98%;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 1rem;
  background-color: beige;
  flex-wrap: wrap;
  gap: 1rem;
}
.dash {
  background-color: #fff;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Adjust the values as needed */
  width: 20%;
  display: flex;
  align-items: center;
  justify-content: center;
  height: 4rem;
  border-radius: 1rem;
}
.charts{

}
</style>
