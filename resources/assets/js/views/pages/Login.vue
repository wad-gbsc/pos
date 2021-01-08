<style>
  img{
    height: auto!important;
    filter: blur(1px);
  }
  .login-block{
    height: 100%!important;
    background: linear-gradient(to bottom, #d6eaf9, #0294fd);
    float:left;
    width:100%;
    padding : 50px 0;
    margin: 0;
  }
  .container{
    min-height: 100%;
    background:#fff; 
    border-radius: 10px;
  }
  .banner-sec{background-size:cover; min-height:100%; border-radius: 10px 0 0 10px; padding:0;}
  .carousel-inner{border-radius:10px 0 0 10px;}
  .carousel-caption{text-align:left; left:5%;}
  .login-sec{padding: 50px 30px; position:relative;}
  .login-sec .copy-text{position:absolute; width:80%; bottom:20px; font-size:13px; text-align:center;}
  .login-sec .copy-text i{color:#1f81c7;}
  .login-sec .copy-text a{color:#1f81c7;}
  .login-sec h2{margin-bottom:30px; font-weight:800; font-size:30px; color: #000000;}
  .login-sec h2:after{content:" "; width:100px; height:5px; background:#000000; display:block; margin-top:20px; border-radius:3px; margin-left:auto;margin-right:auto}
  .banner-text{width:70%; position:absolute; bottom:40px; padding-left:20px;}
  .banner-text h2{color:#000000; font-weight:600;}
  .banner-text h2:after{content:" "; width:100px; height:5px; background:#000000; display:block; margin-top:20px; border-radius:3px;}
  .banner-text p{color:#000000;}
</style>
<template>
  <!-- <div class="app flex-row align-items-center">
    <b-container>
      <b-row class="justify-content-center">
        <b-col md=6>
          <b-card-group>
            <b-card p=4>
              <b-card-body>
                <h1>Login</h1>
                <p class="text-muted">Sign In to your account</p>
                <b-form @submit.prevent="authLogin()" @input="login.success = null">
                  <b-form-group>
                    <label>Username</label>
                    <b-form-input
                          v-model="login.name"
                          :state="login.success"
                          type="text"
                          placeholder="Username">
                    </b-form-input>
                    <b-form-invalid-feedback>
                        <i class="fa fa-exclamation-triangle text-danger"></i>
                        <span v-if="login.success==false">
                            Incorrect username or password.
                        </span>
                    </b-form-invalid-feedback>
                  </b-form-group>
                  <b-form-group>
                    <label>Password</label>
                    <b-form-input
                          v-model="login.password"
                          :state="login.success"
                          type="password"
                          placeholder="Password">
                    </b-form-input>
                  </b-form-group>
                  <b-row>
                    <b-col>
                      <b-btn type="submit" variant="primary" px-4>Login</b-btn>
                    </b-col>
                  </b-row>
                </b-form>
              </b-card-body>
            </b-card>
          </b-card-group>
        </b-col>
      </b-row>
    </b-container>
  </div> -->
  <div>
    <notifications group="notification" />
    <section class="login-block">
      <b-container>
        <b-row>
          <b-col md="8" class="banner-sec">
            <div class="carousel-inner carousel">
              <img class="d-block img-fluid" src="https://static.pexels.com/photos/33972/pexels-photo.jpg" alt="First slide">
              <div class="carousel-caption d-none d-md-block">
                <div class="banner-text">
                    <h2>Billing System</h2>
                </div>	
              </div>
            </div>
          </b-col>
          <b-col md="4" class="login-sec">
            <h2 class="text-center">Login</h2>
            <b-form @submit.prevent="authLogin()" @input="login.success = null">
              <b-form-group>
                <label class="text-uppercase">Username</label>
                <b-form-input
                  ref="username" 
                  v-model="login.username"
                  type="text" 
                  placeholder="Username">
                </b-form-input>
                <b-form-invalid-feedback>
                    <i class="fa fa-exclamation-triangle text-danger"></i>
                    <span v-if="login.success==false">
                        Incorrect username or password.
                    </span>
                </b-form-invalid-feedback>
              </b-form-group>
              <b-form-group>
                <label for="exampleInputPassword1" class="text-uppercase">Password</label>
                <b-form-input 
                  v-model="login.password"
                  type="password" 
                  placeholder="Password">
                </b-form-input>
              </b-form-group>
              <b-row>
                <b-col>
                  <b-btn :disabled="login.is_saving" type="submit" class="float-right" variant="primary" px-4>
                    <icon v-if="login.is_saving" name="sync" spin></icon>
                    Login
                  </b-btn>
                </b-col>
              </b-row>
            </b-form>
          </b-col>
        </b-row>
      </b-container>
    </section>
  </div>
</template>

<script>
export default {
  name: 'Login',
  data(){
    return{
      login: {
        username: null,
        password: null,
        is_saving: false
      }
    }
  },
  methods: {
    authLogin(){
      this.login.is_saving = true
      this.$http.post('api/auth/login', { 
                    username: this.login.username,
                    password: this.login.password
                }).then(response => {
                    this.$store.commit('loginUser')
                    this.$store.commit('user', response.data.user)
                    localStorage.setItem('token', response.data.access_token)
                    this.$notify({
                      type: 'success',
                      group: 'notification',
                      title: 'Success!',
                      text: 'User authenticated successfully.'
                    })
                    setTimeout(function(){
                      this.$router.push({ name: 'Dashboard' })
                    }.bind(this), 1000)
                    this.login.is_saving = false
      }).catch(err => {
            this.$notify({
              type: 'error',
              group: 'notification',
              title: 'Error!',
              text: 'Incorrect username or password.'
            })
            this.login.is_saving = false
      });
    }
  },
  mounted(){
    this.focusElement('username')
  }
}
</script>
