<template>
  <div class="main">
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <div>
          <RouterLink class="navbar-brand" to="/">Bookstore</RouterLink>
        </div>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul
              style="gap: 1rem"
              class="navbar-nav d-flex justify-content-end"
            >
              <li class="nav-item">
                <RouterLink class="nav-link" to="/">Home</RouterLink>
              </li>

              <li class="nav-item">
                <RouterLink class="nav-link" to="/admin">
                  {{ user?.admin ? "Admin" : "" }}
                </RouterLink>
              </li>
              <li>
                <RouterLink class="nav-link" to="/login" v-if="!user"
                  >Login</RouterLink
                >
              </li>

              <li class="nav-item">
                <RouterLink v-if="user" class="nav-link" to="/profile"
                  >Profile</RouterLink
                >
              </li>
              <li>
                <RouterLink
                  class="nav-link"
                  to="/login"
                  @click="logout"
                  v-if="user"
                  >Logout</RouterLink
                >
              </li>
            </ul>
      <form class="d-flex" role="search">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>
    </div>
  </div>
</nav>
  

    <RouterView />
    <div id="bottomBar">bookstore@ {{ new Date().getFullYear() }}</div>
  </div>


    
        
  
</template>


<script>
import axios from "axios";
import { mapState, mapActions } from "vuex";

export default {
  name: "books",
  data() {
    return {
      books: [],
      user: null,
      isSidebarOpen: false,
    };
  },

  computed: {
    // Using Vuex helpers to map the 'isLoggedIn' state to a computed property
    ...mapState(["isLoggedIn"]),
  },
  methods: {
    // Using Vuex helpers to map the 'logout' action to a method
    ...mapActions(["logout"]),
    toggleSidebar() {
      this.isSidebarOpen = !this.isSidebarOpen;
    },
  },

  mounted() {
    this.loadUser();
  },
  methods: {
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
          // location.reload(); // This line reloads the page
        })
        .catch((error) => {
          console.error("Failed to load user:", error.response.data.message);
        });
    },
    logout() {
      localStorage.removeItem("token");
      this.$router.push("/login");
    },
  },
};
</script>
