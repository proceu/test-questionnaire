export default function (context) {
  if (context.$auth.loggedIn && !context.$auth.user.isAdmin) {
    return context.redirect({name:'index'});
  }
}
