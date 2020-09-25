<template>
  <div>
    <button
      :class="
        this.isWatched
          ? 'bg-green-500 px-2 py-3 rounded text-white'
          : 'bg-gray-500 px-2 py-3 rounded text-white'
      "
      @click="toggleProgress()"
    >
      {{ this.isWatched ? "Terminé" : "Terminé?" }}
    </button>
  </div>
</template>

<script>
export default {
  props: ["episodeId", "watchedEpisodes"],

  data() {
    return {
      watchedEp: this.watchedEpisodes,
      isWatched: null,
    };
  },

  methods: {
    toggleProgress() {
      axios
        .post("/toggleProgress", {
          episodeId: this.episodeId,
        })
        .then((response) => {
          if (response.status === 200) {
            this.isWatched = !this.isWatched;
            eventBus.$emit("toggleProgress", response.data);
          }
        })
        .catch((error) => console.log(error));
    },

    isWatchedEp() {
      return this.watchedEp.find((episode) => episode.id === this.episodeId)
        ? true
        : false;
    },
  },

  // Une fois le composant prêt la méthode isWatchedEp est automatiquement executée
  mounted() {
    this.isWatched = this.isWatchedEp();
  },
};
</script>
