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
        <!-- <div class="mb-3">
          <label for="fileInput">Image</label>
          <div
            cloudName="pitz"
            uploadPreset="peter-main"
            @uploaded="handleImageChange"
          >
            <input type="file" class="form-control" id="fileInput" />
          </div>
        </div> -->
        <main class="main">
  

          <div>
    <button @click="onClick">Upload</button>
    <img v-if="uploadedImageUrl" :src="uploadedImageUrl" alt="Uploaded Image">
  </div>
   
</main>



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
import { ref, onMounted, defineEmits } from "vue";
import { Cloudinary } from 'cloudinary-vue';

const emit = defineEmits(["on-upload"]);

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
      cloudinary: null,
      widget: null,
      uploadedImageUrl: null,
    };
  },
  methods: {
    onMounted() {
      if (!this.cloudinary && window.cloudinary) {
        this.cloudinary = window.cloudinary;
      }

      const onIdle = () => {
        if (!this.widget) {
          this.widget = this.createWidget();
        }
      };

      "requestIdleCallback" in window
        ? requestIdleCallback(onIdle)
        : setTimeout(onIdle, 10);
    },
    createWidget() {
      if (!this.cloudinary) {
        console.error("Cloudinary is not defined");
        return null;
      }

      const options = {
        cloudName: "pitz",
        uploadPreset: "peter-main",
      };

      return this.cloudinary.createUploadWidget(options, (error, result) => {
        if (error || result.event === "success") {
          this.handleImageChange(result);
          emit("on-upload", { error, result, widget: this.widget });
        }
      });
    },
    onClick() {
      if (!this.widget) {
        this.widget = this.createWidget();
      }
      this.widget && this.widget.open();
    },
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
      this.uploadedImageUrl = imageUrl;  // Optionally, update the uploadedImageUrl if needed
    },
  },
  mounted() {
    this.onMounted();
  },
};
</script>

<style scoped>
.container {
  width: 100%;
  max-width: 1024px;
  padding: 0 1em;
  margin: 0 auto;
}

.title {
  text-align: center;
  margin: 2em 0;
}

.subtitle {
  font-weight: normal;
  text-align: center;
  margin: -1em 0 2em;
}
</style>
