<template>
  <div class="container">
    <div class="card" style="width: 100%;">
      <div class="card-header" style="display:flex;align-items:center;justify-content:space-between;" >
        <h4>
          All books </h4>
         <div style="display:flex;align-items:center;justify-content:center;gap:1rem">
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
          <tbody v-if="this.books.length>0">
            <tr v-for="(book, index) in books" :key="index">
              <!-- Content for each table row goes here -->
              <td>{{ book.name }}</td>
              <td>{{ book.publisher }}</td>
              <td>{{ book.isbn }}</td>
              <!-- <td>{{ book.category }}</td> -->
              <td>{{ book.added_by }}</td>
              <td>{{ book.created_at }}</td>
              <td style="display: flex;justify-content: space-between;">
                <RouterLink 
                style="width: 4.5rem; margin-bottom: 1px;" 
                :to="{path:'/books/'+book.id +'/edit'}" class="btn btn-success">
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
      axios.get("http://127.0.0.1:8000/api/books").then((res) => {
        this.books = res.data.books;
      });
    },
    deleteBook(bookId){
     if(confirm('are sure you want to delete')){
      axios.delete(`http://127.0.0.1:8000/api/books/${bookId}`).then((res) => {
      alert(res.data.message)
      this.getBooks();

      });
     }else{
      alert('no id found')
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
</style>
