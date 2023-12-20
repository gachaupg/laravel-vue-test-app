<template>
  <div class="container mt-5">
    <div class="card">
      <div class="card-header">
        <h4>Add a book</h4>
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
          <label for="fileInput">Image</label>
          <div
            cloudName="pitz"
            uploadPreset="peter-main"
            @uploaded="handleImageChange"
          >
            <input type="file" class="form-control" id="fileInput" />
          </div>
        </div>


        <div class="mb-3">
          <button
            @click="saveBooks"
            style="width: 100%"
            class="btn btn-secondary"
          >
            Save the details
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import { Cloudinary } from 'cloudinary-vue';

export default {
  name: "booksCreate",
  components: {
    Cloudinary,
  },
  data() {
    return {
      model: {
        books: {
          name: "",
          publisher: "",
          isbn: "",
          category: "",
          sub_category: "",
          description: "",
          added_by: "",
          pages: "",
          image: null,
        },
      },
    };
  },
  methods: {
    saveBooks() {
      const formData = new FormData();

      Object.keys(this.model.books).forEach((key) => {
        formData.append(key, this.model.books[key]);
      });

      axios
        .post("http://127.0.0.1:8000/api/books", formData)
        .then((res) => {
          console.log("Response:", res);
          alert(res.data.message);
        })
        .catch((error) => {
          console.error("Error saving book:", error);
        });
    },
    handleImageChange(response) {
      const imageUrl = response.info.secure_url;
      this.model.books.image = imageUrl;
    },
  },
};
</script>
