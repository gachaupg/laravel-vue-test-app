<script setup>
import { ref } from "vue";
import { RouterLink, RouterView } from "vue-router";

const isSidebarOpen = ref(false);

const toggleSidebar = () => {
  isSidebarOpen.value = !isSidebarOpen.value;
};
</script>

<template>
  <header>
    <div>
      <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div
          class="container-fluid d-flex justify-content-between align-items-center"
        >
          <div>
            <RouterLink class="navbar-brand" to="/">Logo</RouterLink>
          </div>
          <div>
            <button class="navbar-toggler" type="button" @click="toggleSidebar">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div
              class="collapse navbar-collapse"
              :class="{ show: isSidebarOpen }"
            >
              <ul class="navbar-nav d-flex justify-content-end">
                <li class="nav-item">
                  <RouterLink class="nav-link" to="/">Home</RouterLink>
                </li>

                <li class="nav-item">
                  <RouterLink class="nav-link" to="/admin">
                    {{ user?.admin ? "Admin" : "" }}
                  </RouterLink>
                </li>
                <li>
                  <router-link class="nav-link" to="/login" v-if="!user"
                    >Login</router-link
                  >
                </li>

                <li class="nav-item">
                  <RouterLink v-if="user" class="nav-link" to="/profile"
                    >Profile</RouterLink
                  >
                </li>
                <li>
                  <router-link
                    class="nav-link"
                    to="/login"
                    @click="logout"
                    v-if="user"                  
                    >Logout</router-link
                  >
                </li>
              </ul>
            </div>
          </div>
        </div>
      </nav>
    </div>
  </header>

  <RouterView />
  <div style="width: 100%; display: flex; align-items: center; justify-content: center;">
  bookstore@ {{ new Date().getFullYear() }}
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
    };
  },

  computed: {
    // Using Vuex helpers to map the 'isLoggedIn' state to a computed property
    ...mapState(["isLoggedIn"]),
  },
  methods: {
    // Using Vuex helpers to map the 'logout' action to a method
    ...mapActions(["logout"]),
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

  }
};
</script>
