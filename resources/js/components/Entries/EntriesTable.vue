<template>
  <div>
    <p v-show="loading">Loading...</p>
    <table class="table striped">
      <thead>
        <tr>
          <th>Date</th>
          <th>Category</th>
          <th>Title</th>
          <th>Description</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody v-if="data.length > 0">
        <tr v-for="entry in data" :key="entry.id">
          <td>{{ entry.formattedDate }}</td>
          <td>{{ entry.category.name }}</td>
          <td>{{ entry.title }}</td>
          <td>{{ entry.shortDescription }}</td>
          <td>
            <div class="dropdown">
              <span
                role="button"
                id="dropdownMenuLink"
                :data-toggle="toggle"
                aria-haspopup="false"
                aria-expanded="false"
              >
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="16"
                  height="16"
                  fill="currentColor"
                  class="bi bi-three-dots-vertical"
                  viewBox="0 0 16 16"
                >
                  <path
                    d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"
                  />
                </svg>
              </span>
              <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                <a class="dropdown-item" :href="route('entries.show', entry)"
                  >View</a
                >
                <a class="dropdown-item" :href="route('entries.edit', entry)"
                  >Edit</a
                >
                <form @submit.prevent="deleteEntry(entry)">
                  <button type="submit" class="dropdown-item">Delete</button>
                </form>
              </div>
            </div>
          </td>
        </tr>
      </tbody>
      <tbody v-else>
        <tr>
          <td colspan="4" class="text-center">
            <span>
              No entry found
              <a href="/entries/create">Add an entry</a>
            </span>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
export default {
  name: "EntriesTable",
  props: ["entries", "entry"],
  data() {
    return {
      error: null,
      data: this.entries,
      dropdown: "dropdown",
      loading: false,
    };
  },
  methods: {
    deleteEntry(entry) {
      axios
        .delete(route("entries.destroy", entry))
        .then((response) => {
          this.data.splice(this.data.indexOf(entry), 1);
          this.dropdown = "";
        })
        .catch((error) => error.response.data.errors);
    },
  },
  computed: {
    toggle() {
      return (this.dropdown = "dropdown");
    },
  },
  mounted() {
    this.$root.$on("weekEntry", (date) => {
      axios
        .get(route("entries.weekending", date))
        .then((response) => {
          this.loading = true;
          this.data = response.data[0];
          this.loading = false;
        })
        .catch((error) => error.response.data.errors);
    });
  },
};
</script>
