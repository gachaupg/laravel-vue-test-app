<template>
    <div class="container mt-5">
      <div class="card">
        <div class="card-header">
          <h4>Login</h4>
        </div>
        <form @submit.prevent="login">
        <div class="card-body">
          
          <div class="mb-3">
            <label for="">Email of the User</label>
            <input
            v-model="email"
              type="email"
              class="form-control"
            />
          </div>
          <div class="mb-3">
            <label for="">Password of the user</label>
            <input v-model="password" type="password" class="form-control" />
          </div>
          
  
          <div class="mb-3">
            <button
            type="submit"
              style="width: 100%"
              class="btn btn-secondary"
            >
              Save the details
            </button>
          </div>
        </div></form>
      </div>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  
  export default {
  data() {
  return {
  // Data model for the form inputs
  email: "",
  password: ""
  };
  },
  methods: {
    async login() {
  try {
    const response = await axios.post("http://127.0.0.1:8000/api/users/login", {
      email: this.email,
      password: this.password
    });
console.log(response)

    if (response.data.message) {
      localStorage.setItem('token', response.data.message);
      // Committing a mutation to update 'isLoggedIn' state
      await this.$store.dispatch('loginAction');

      // Redirecting to the home page
      // location.reload(); // This line reloads the page
      this.$router.push('/');

    }
  } catch (error) {
    console.error("An error occurred:", error);
  }
}

  }
  };
  </script>




