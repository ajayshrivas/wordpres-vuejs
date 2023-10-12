const Home = {
    template: '<div><h1>My Latest Posts</h1><div><p v-for="post in posts"><router-link :to="`/post/${post.id}`">{{ post.title.rendered }}</router-link></p></div></div>',
    data() {
      return {
        posts: [],
      };
    },
    methods: {
      fetchPosts: function() {
        var url = 'https://themes91.in/wp_legal_pages/chrishitman/wp-json/wp/v2/posts';
        fetch(url)
          .then((response) => response.json())
          .then((data) => {
            this.posts = data;
          });
      },
    },
    mounted() {
      this.fetchPosts();
      setInterval(() => {
        this.fetchPosts();
      }, 50000);
    },
  };
  
  const Post = {
    template: '<div>{{ post.title.rendered }}<br>{{ post.content.rendered }}</div>',
    data() {
      return {
        post: null,
      };
    },
    methods: {
      fetchPost: function() {
        var postId = this.$route.params.id;
        var url = `https://themes91.in/wp_legal_pages/chrishitman/wp-json/wp/v2/posts/${postId}`;
        fetch(url)
          .then((response) => response.json())
          .then((data) => {
            this.post = data;
          });
      },
    },
    watch: {
      '$route.params.id': 'fetchPost',
    },
    created() {
      this.fetchPost();
    },
  };
  const About = {
    template: '<div>About Page</div>',
  };
  
  const Contact = {
    template: '<div>Contact Page</div>',
  };
  const routes = [
    { path: '/', component: Home },
    { path: '/about', component: About },
    { path: '/contact', component: Contact },
    { path: '/post/:id', component: Post },
  ];
  
  const router = new VueRouter({
    routes,
  });
  
  const app = new Vue({
    router,
  }).$mount('#app');
  