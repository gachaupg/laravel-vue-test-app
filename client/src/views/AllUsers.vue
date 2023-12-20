<template>
    <div class="container">
      <div class="card" style="width: 100%;">
        <div class="card-header" style="display:flex;align-items:center;justify-content:space-between;" >
          <h4>
            All Users </h4>
           <div style="display:flex;align-items:center;justify-content:center;gap:1rem">
            <RouterLink to="/addUsers" class="btn btn-info float-end">
              Add a User
            </RouterLink>
           
           </div>
         
        </div>
        <div class="card-body">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>Name</th>
                <th>email</th>
                <!-- <th>isbn</th>
                <th>added-by</th> -->
                <!-- <th>pages</th> -->
                <th>CreatedAt</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody v-if="this.users.length>0">
              <tr v-for="(user, index) in users" :key="index">
                <!-- Content for each table row goes here -->
                <td>{{ user.name }}</td>
                <td>{{ user.email }}</td>
               
                <td>{{ user.created_at }}</td>
                <td style="display: flex;justify-content: space-between;">
                  <RouterLink 
                  style="width: 4.5rem; margin-bottom: 1px;" 
                  :to="{path:'/user/'+user.id}" class="btn btn-success">
                    Edit
                  </RouterLink>
                  <button @click="deleteUser(user.id)" class="btn btn-danger">
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
  name: "users",
  data() {
    return {
      users: [],
    };
  },
  mounted() {
    this.getUsers();
  },
  methods: {
    getUsers() {
      axios.get("http://127.0.0.1:8000/api/users").then((res) => {
        this.users = res.data.users;
        console.log(res.data);
      });
    },
    deleteUser(userId) {
      if (confirm('Are you sure you want to delete?')) {
        axios.delete(`http://127.0.0.1:8000/api/users/delete/${userId}`).then((res) => {
          alert(res.data.message);
          this.getUsers();
        });
      } else {
        alert('No ID found');
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
  