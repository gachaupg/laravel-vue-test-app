<template>
  <div class="book">
    <div class="card">
      <div class="card-header">
        <h4>
          All books
          
        </h4>
      </div>
      <div class="card-body card-body-card">
        <div  v-for="(book, index) in books" :key="index"  class="card mb-3" style="max-width: 300px">
          <div class="row g-0">
              <img
                src="https://m.media-amazon.com/images/I/5161-7Fgd8L.jpg"
               class="img"
                alt="..."
              />
         
              <div class="card-body">
                <h5 class="card-title">{{ book.name }}</h5>
                <hr>
                <p style="display: flex;
                align-items: center;justify-content: space-between;"> 
                <p>Publisher :</p> <p> {{ book.publisher }}</p> </p>
                <p style="display: flex;
                align-items: center;justify-content: space-between;"> 
                <p>Isbn :</p> <p> {{ book.isbn }}</p> </p>
                <p style="display: flex;
                align-items: center;justify-content: space-between;"> 
                <p>{{ book.category }} :</p> <p> {{ book.sub_category }}</p> </p>
                <hr>
                <p style="display: flex; align-items: center; justify-content: space-between;" class="card-text">
                  <p>{{ book.pages }}pages</p>
                  <button class="btn btn-info">
                    Borrow
                  </button>
                  <p>{{  }}</p>
                </p>
                
              </div>
          </div>
        </div>
 
        <!-- <table class="table table-bordered">
          <thead>
            <tr>
              <th>Name</th>
              <th>Public</th>
              <th>Name</th>
              <th>Name</th>
              <th>Name</th>
              <th>Name</th>
              <th>Name</th>
            </tr>
          </thead>
        </table> -->
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
  },
};
</script>
<style>
.card-body-card{
  display: flex;
  flex-direction: row ;
  align-items: center;
  justify-content: center;
  gap: 2rem;
  flex-wrap: wrap;
}.img{
  height: 10rem !important;
  object-fit: cover;
}
</style>
