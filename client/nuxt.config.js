export default {
  // Global page headers: https://go.nuxtjs.dev/config-head
  head: {
    title: 'test-nuxt',
    htmlAttrs: {
      lang: 'en'
    },
    meta: [
      { charset: 'utf-8' },
      { name: 'viewport', content: 'width=device-width, initial-scale=1' },
      { hid: 'description', name: 'description', content: '' },
      { name: 'format-detection', content: 'telephone=no' }
    ],
    link: [
      { rel: 'icon', type: 'image/x-icon', href: '/favicon.ico' }
    ]
  },

  // Global CSS: https://go.nuxtjs.dev/config-css
  css: [
  ],

  // Plugins to run before rendering page: https://go.nuxtjs.dev/config-plugins
  plugins: [
    {src: '~/plugins/chart.js', mode: 'client'}
  ],

  // Auto import components: https://go.nuxtjs.dev/config-components
  components: true,

  // Modules for dev and build (recommended): https://go.nuxtjs.dev/config-modules
  buildModules: [
  ],

  // Modules: https://go.nuxtjs.dev/config-modules
  modules: [
    // https://go.nuxtjs.dev/bootstrap
    'bootstrap-vue/nuxt',
    '@nuxtjs/axios',
    '@nuxtjs/auth-next'
  ],

  // Build Configuration: https://go.nuxtjs.dev/config-build
  build: {
  },

  router:{
    middleware:['auth'],
  },
  auth: {
    cookie: {
      options: {
        secure: false,
      },
    },
    localStorage: false,
    strategies: {
      local: {
        tokenRequired: true,
        tokenName: 'Authorization',
        tokenType: 'Bearer',
        refreshToken:false,
        endpoints: {
          login: {
            method:'POST',
            url: '/auth/login',
            propertyName:'token',
          },
          logout: {
            method:'POST',
            url: '/auth/logout'
          },
          user: {
            method:'GET',
            url: '/auth/user',
          }
        },
        user: {
          property: 'user',
          autoFetch:true
        },
      }
    },
    redirect: {
      login:'/auth/login',
      logout:'/',
      dashboard:'/dashboard',
      callback:false
    },
    watchLoggedIn: true,
  },
  axios: {
    baseUrl:'http://localhost/api',
    credentials:true,
  },
}
