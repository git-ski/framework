new Vue({
  el: '#app',
  render (h) {
    return h('div', this.message)
  },
  data: {
    message: 'hello, world from vuejs'
  }
});
