<template>
  <div class="container mt-5">
    <div class="card">
      <div class="card-header">
        <h4>Update a book</h4>
      </div>
      <div class="card-body">
        <div class="mb-3">
          <label for="">Name of the book</label>
          <input v-model="model.books.name" type="text" class="form-control" />
        </div>
        <div class="mb-3">
          <label for="">Name of the publisher</label>
          <input
            v-model="model.books.publisher"
            type="text"
            class="form-control"
          />
        </div>
        <div class="mb-3">
          <label for="">Isbn</label>
          <input v-model="model.books.isbn" type="text" class="form-control" />
        </div>
        <div class="mb-3">
          <label for="">Category</label>
          <input
            v-model="model.books.category"
            type="text"
            class="form-control"
          />
        </div>
        <div class="mb-3">
          <label for="">Sub Category</label>
          <input
            v-model="model.books.sub_category"
            type="text"
            class="form-control"
          />
        </div>
        <div class="mb-3">
          <label for="">Description</label>
          <input
            v-model="model.books.description"
            type="text"
            class="form-control"
          />
        </div>
        <div class="mb-3">
          <label for="">Number of pages</label>
          <input
            v-model="model.books.pages"
            type="number"
            class="form-control"
          />
        </div>
        <div class="mb-3">
          <label for="">Added by</label>
          <input
            v-model="model.books.added_by"
            type="text"
            class="form-control"
          />
        </div>
        <div class="mb-3">
          <label for="">image</label>
          <input
            v-model="model.books.image"
            type="test"
            class="form-control"
          />
        </div>

        <div class="mb-3">
          <button
            @click="saveBooks"
            style="width: 100%"
            class="btn btn-secondary"
          >
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
  name: "booksCreate",
  data() {
    return {
      model: {
        books: {
            bookId:'',
          name: "",
          publisher: "",
          isbn: "",
          category: "",
          sub_category: "",
          description: "",
          added_by: "",
          pages: "",
          image:''
        },
      },
    };
  },
  mounted() {
    // console.log(this.$route.params.id);
    this.bookId=this.$route.params.id;
    // console.log(this.bookId);
    this.getBooksData(this.$route.params.id);
  },
  methods: {
    getBooksData(bookId) {
      axios.get(`http://127.0.0.1:8000/api/books/${bookId}`).then((res) => {
        console.log(res.data);
        this.model.books = res.data.book;
      });
    },

    saveBooks() {
      axios
        .put(`http://127.0.0.1:8000/api/books/${this.bookId}`, this.model.books)
        .then((res) => {
          alert(res.data.message);
          this.model.student = {
          };
        });
    },
  },
};
</script>
